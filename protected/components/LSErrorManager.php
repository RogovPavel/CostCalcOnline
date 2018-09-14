<?php

class LSErrorManager extends CComponent {
    
    const ERROR_TYPE = 0;
    
    private $ErrorTypes;
    
    public function init() {
        $this->ErrorMessages[self::ERROR_TYPE] = 'Неизвестный тип ошибкил';
    }
    
    public function get_error_type($code) {
        return 'Тип ошибки один';
    }
}

