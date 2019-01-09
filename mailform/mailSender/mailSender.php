<?php
require_once(dirname(__FILE__).'/interfaces/send.php');

class mailSender implements send
{
    public $to;
    public $subject;
    public $message;
    public $headers;

    public function __construct($recieverAddress, $senderAddress, $title, $name, $content, $telnumber) { 
        $this->to = $recieverAddress;
        $this->subject = $title;
        $this->message = $content . PHP_EOL.PHP_EOL
                       .'<送信者情報>-----------------' . PHP_EOL
                       .'名前：' . $name . PHP_EOL
                       .'電話番号：' . $telnumber . PHP_EOL
                       .'---------------------------';
        $this->headers = 'From: ' .mb_encode_mimeheader($name) .'<'. $senderAddress .'>'. PHP_EOL;

    }

    public function send() {
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
        return mb_send_mail($this->to, $this->subject, $this->message, $this->headers);
    }


}

?>