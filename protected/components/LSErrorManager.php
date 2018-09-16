<?php

class LSErrorManager extends CComponent {
    
    const ERROR_TYPE = 0;
    const ERROR_CREATE_TYPE = 15;
    
    const ERROR_UNDEFINED_MESSAGE = 10;
    const ERROR_CREATE_MESSAGE = 15;
    const ERROR_UPDATE_MESSAGE = 20;
    const ERROR_DELETE_MESSAGE = 30;
    
    private $ErrorTypes;
    private $ErrorMessages;
    
    public function init() {
        // Типы ошибок
        $this->ErrorTypes[self::ERROR_TYPE] = 'Неизвестный тип ошибки';
        $this->ErrorTypes[self::ERROR_CREATE_TYPE] = 'Неизвестный тип ошибки';
        
        // Сообщения
        $this->ErrorMessages[self::ERROR_UNDEFINED_MESSAGE] = 'Внимание! Произошла неизвестная ошибка.';
        $this->ErrorMessages[self::ERROR_CREATE_MESSAGE] = 'Внимание! Произошла ошибка вставки записи.';
        $this->ErrorMessages[self::ERROR_UPDATE_MESSAGE] = 'Внимание! Произошла ошибка редактирования записи.';
        $this->ErrorMessages[self::ERROR_DELETE_MESSAGE] = 'Внимание! Произошла ошибка удаления записи.';
    }
    
    public function getErrorType($code = 0) {
        if (isset($this->ErrorTypes[$code]))
            return $this->ErrorTypes[$code];
        else return $this->ErrorTypes[0];
    }
    
    public function getErrorMessage($code = 0) {
        if (isset($this->ErrorMessages[$code]))
            return $this->ErrorMessages[$code];
        else return $this->ErrorMessages[10];
    }
}

