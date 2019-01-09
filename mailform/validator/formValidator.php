<?php
require_once(dirname(__FILE__).'/interfaces/validate.php');

class formValidator implements validate
{
    public $errorMessages = array();
    public $target;
    public $targetDisp;
    public $required;

    public function __construct($target, $targetDisp, $required) { 
        $this->target = $target;
        $this->targetDisp = $targetDisp;
        $this->required = $required;
    }

    public function validate() {
        $this->validateRequired();
        return $this->errorMessages;
    }

    public function validateRequired() {
        if (isset($this->target) && isset($this->targetDisp) && isset($this->required)) {
            if ($this->required == true) {
                if (empty($this->target)) {
                    $this->errorMessages[] = $this->targetDisp . 'は必須項目です。';
                }
            }
        } else {
            $this->errorMessages[] = 'システム不具合';
        }
    }
}

?>