<?php

class LSSecurity extends CComponent {
    
    public function init() {
        
    }
    
    public function HideShowMenuItem($operation = '') {
        if (Yii::app()->user->checkAccess($operation))
            echo '';
        else
            echo 'hidden="true"';
        
        return;
    }
}
