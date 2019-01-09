<?php
require_once(dirname(__FILE__).'/formValidator.php');
require_once(dirname(__FILE__).'/regexValidator.php');

class characterValidator extends formValidator {

    public function __construct($target, $targetDisp, $required) { 
        parent::__construct($target, $targetDisp, $required);
    }

    public function validate() {
        /** 必須チェック */
        $this->validateRequired();
        /** 正規表現による形式チェック */
        $regexValidator = new regexValidator();
        $this->errorMessages = $regexValidator->validate($this->target, $this->targetDisp, $this->errorMessages, "/^[a-zA-Zぁ-んァ-ヶー一-龠]+$/u");

        return $this->errorMessages;
    }
}
?>