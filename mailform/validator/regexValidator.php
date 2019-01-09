<?php
class regexValidator {
    public function validate($target, $targetDisp, $errorMessages, $regex) {
        if (!preg_match($regex, $target)) {
            $errorMessages[] = $targetDisp . 'を正しい形式で入力してください。';
        }
        return $errorMessages;
    }
}
?>