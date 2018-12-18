<?php

require_once(Yii::app()->request->baseUrl . '/protected/extensions/phpquery/phpQuery-onefile.php');

class LSParserHTML extends CComponent {
    
    public function init() {
        
    }
    
    public function getfield($string) {
        $result = array(
            'source' => null,
            'fieldname' => null,
            'isfield' => false
        );
        
        $search = array('{', '}');
        
        if (substr($string, 0, 1) == '{') {
            $value = str_ireplace($search, '', $string);
            $field = explode(".", $value);
            
            if (count($field) >= 1) {
                $result['source'] = $field[0];
                $result['fieldname'] = $field[1];
                $result['isfield'] = true;
            } else {
                $result['source'] = null;
                $result['fieldname'] = $field[0];
            }
        } else 
            $result['fieldname'] = $string;
        
        return $result;
    }
    
    public function parse($sources = array(), $strings = '') {
        $doc = phpQuery::newDocumentHTML($strings);
        
        phpQuery::selectDocument($doc);
        
        
        
//        foreach(pq('tr[data]') as $elem) {
//            $columns = array();
//            $r = pq($elem)->find('td');
//            foreach ($r as $td) {
//                pq($td)->attr('testing', '1');
//                array_push($columns, array(
//                    
//                ))
//            }
//            
//            
//
//        }
        
        foreach(pq('td') as $elem) {
            $value = pq($elem)->text();
            $field = $this->getfield($value);
            
            if ($field['isfield']) {
                if (isset($sources[$field['source']]['fieldname'])) {
                    pq($elem)->text($sources[$field['source']]['fieldname']);
                } else 
                    pq($elem)->text('');
            }
            
        }
        
        return $doc->html();
    }
    
}

