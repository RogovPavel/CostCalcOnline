<?php

require_once(Yii::app()->request->baseUrl . '/protected/extensions/phpquery/phpQuery-onefile.php');

class LSParserHTML extends CComponent {
    
    public function init() {
        
    }
    
    public function parsefield($string) {
        $result = array(
            'source' => null,
            'fieldname' => null,
            'isfield' => false
        );
        
        $field = explode(".", $string);

        if (count($field) >= 1) {
            $result['source'] = $field[0];
            $result['fieldname'] = $field[1];
            $result['isfield'] = true;
        } else {
            $result['source'] = null;
            $result['fieldname'] = $field[0];
        }
        
        return $result;
    }
    
    public function getsourcecolumns($elems) {
        $sourcecolums = array();
        
        foreach ($elems as $td) {
            $sourcestr = pq($td)->attr('field');
            $class = pq($td)->attr('class');
            $field = $this->parsefield($sourcestr);
            
            if ($field['isfield']) {
                if (isset($sourcecolums[$field['source']]))
                    array_push($sourcecolums[$field['source']], array('fieldname' => $field['fieldname'], 'class' => $class));
                else
                    $sourcecolums = array_merge($sourcecolums, array($field['source'] => array(array('fieldname' => $field['fieldname'], 'class' => $class))));
            }
        }
        
        return $sourcecolums;
    }
    
    public function fillTable($source = array(), $columns, $elem) {
        $tbody = '';
        for ($i = 0; $i < count($source); $i++) {
            $tbody .= '<tr>';
            for ($j = 0; $j < count($columns); $j++) {
                if ($columns[$j]['fieldname'] == 'recno')
                    $tbody .= '<td class="' . $columns[$j]['class'] . '">' . ($i + 1) . '</td>';
                else
                    $tbody .= '<td class="' . $columns[$j]['class'] . '">' . $source[$i][$columns[$j]['fieldname']] . '</td>';
            }
            $tbody .= '</tr>';
        }
        
        pq($elem)->after($tbody);
        pq($elem)->remove();
    }
    
    public function fillHTML($sources = array(), $strings = '') {
        $doc = phpQuery::newDocumentHTML($strings);
        
        phpQuery::selectDocument($doc);
        
        foreach(pq('tr[data]') as $elem) {
            $source = pq($elem)->attr('data');
            $tds = pq($elem)->find('td');
            
            $columns = $this->getsourcecolumns($tds);
            if (isset($sources[$source]))
                $this->fillTable($sources[$source], $columns[$source], $elem);
        }
        
        foreach(pq('[field]') as $elem) {
            $sourcestr = pq($elem)->attr('field');
            $field = $this->parsefield($sourcestr);
            
            if ($field['isfield']) {
                if (isset($sources[$field['source']][$field['fieldname']])) {
                    pq($elem)->text($sources[$field['source']][$field['fieldname']]);
                } else 
                    pq($elem)->text('');
            }
            
        }
        return $doc->html();
    }
    
}

