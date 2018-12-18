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
                    'actions'=>array('CostCalcView'),
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
    
    public function Open($sources = array(), $template = null) {
        $result = '';
        
        if ($template != null) {
            $result = $template;
            
            $parser = new LSParserHTML();
            $result = $parser->parse($sources, $result);
            
        };
        
        return $result;
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
            'costcalcequips' => $costcalcequips,
            'costcalcworks' => $costcalcworks
        ), $template);
        
        
        
        $this->render('index', array(
            'html' => $html
        ));
    }
    
}