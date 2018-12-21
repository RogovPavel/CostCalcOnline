<?php 

class ReportController extends Controller {
    
    
    
    public function filters() {
        return array(
                'accessControl',
        );
    }
    
    public function accessRules() {
        return array(
            array('allow',
                    'actions'=>array('CostCalcView', 'Open'),
                    'users'=>array('@'),
            ),
            array('deny',
                    'users'=>array('*'),
            ),
        );
    }
    
    public function ParseHTML($html) {
        $result = array();
        
        
        
    }
    
    public function actionOpen() {
        $this->layout = '//layouts/report_column';
        
        $result = '';
        
        $sources = array();
        $template = null;
        
        if (isset($_POST['sources'])) {
            $sources = $_POST['sources'];
            $sources = json_decode($sources, true);
        }
        
        if (isset($_POST['template'])) {
            $templates = new Templates();
            $templates->get_by_id($_POST['template']);
            
            $template = $templates->template;
        }
        
        if ($template != null) {
            $result = $template;
            
            $parser = new LSParserHTML();
            $result = $parser->fillHTML($sources, $result);
            
        };
        
        $this->render('index', array(
            'html' => $result
        ));
    }
    
    
    public function actionCostCalcView($id) {
        $this->layout = '//layouts/report_column';
        
        $costcalculations = new CostCalculations();
        $costcalculations->get_by_id($id);
        
        $costcalcequips = new CostCalcEquips();
        $costcalcequips = $costcalcequips->find(array(
            array(
                'sql' => 'e.calc_id = :p_calc_id',
                'params' => array(':p_calc_id' => $id)
        )));
        
        $costcalcworks = new CostCalcWorks();
        $costcalcworks = $costcalcworks->find(array(
            array(
                'sql' => 'ccw.calc_id = :p_calc_id',
                'params' => array(':p_calc_id' => $id)
        )));
        
        $template = null;
        
        $templates = new Templates();
        $res = $templates->find(array(array(
            'sql' => 't.type_id = 1',
            'params' => array()
        )));
        
                
        if (count($res) > 0)
            $template = $res[0]['template'];
        
        $html = $this->Open(array(
            'calc' => $costcalculations,
            'calcequips' => $costcalcequips,
            'calcworks' => $costcalcworks
        ), $template);
        
        
        
        $this->render('index', array(
            'html' => $html
        ));
    }
}