<?php
require_once(dirname(__FILE__).'/formValidator.php');
require_once(dirname(__FILE__).'/regexValidator.php');

class telnumberValidator extends formValidator {

    public function __construct($target, $targetDisp, $required) { 
        parent::__construct($target, $targetDisp, $required);
    }

    public function validate() {
        /** 必須チェック */
        $this->validateRequired();
        /** 正規表現による形式チェック */
        $regexValidator = new regexValidator();
        $this->errorMessages = $regexValidator->validate($this->target, $this->targetDisp, $this->errorMessages, "/^[0-9]{2,4}[0-9]{2,4}[0-9]{3,4}$/");

        return $this->errorMessages;
    }
}
?>