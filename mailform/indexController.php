<?php 
require_once(dirname(__FILE__).'/validator/formValidator.php');
require_once(dirname(__FILE__).'/validator/characterValidator.php');
require_once(dirname(__FILE__).'/validator/emailValidator.php');
require_once(dirname(__FILE__).'/validator/telnumberValidator.php');
require_once(dirname(__FILE__).'/mailSender/mailSender.php');

 

// 1ページ目の「確認画面へ」押下時
if (!empty($_POST['confirm'])) {
    $_POST['confirm'] = '';

    $validators = array();
    $errorMessages = array();
    $next = true;

    // 値保持用
    $query_title = $_POST['title'];
    $query_name = $_POST['name'];
    $query_email = $_POST['email'];
    $query_telnumber = $_POST['telnumber'];
    $query_content = htmlspecialchars($_POST['content']);

    // バリデーションクラス呼び出し
    $titleValidator = new formValidator($_POST['title'], '件名', true);
    $nameValidator = new characterValidator($_POST['name'], '名前', true);
    $emailValidator = new emailValidator($_POST['email'], 'メールアドレス', true);
    $telnumberValidator = new telnumberValidator($_POST['telnumber'], '電話番号', true);
    $contentValidator = new formValidator($_POST['content'], 'お問い合わせ内容', true);

    $errorMessages[] = $titleValidator->validate();
    $errorMessages[] = $nameValidator->validate();
    $errorMessages[] = $emailValidator->validate();
    $errorMessages[] = $telnumberValidator->validate();
    $errorMessages[] = $contentValidator->validate();

    foreach ($errorMessages as $array) {
        if (count($array) != 0) {
            $next = false;
            $page_flag = 1;
        }
    }
    if ($next) {
        $page_flag = 2;
    }
}


// 2ページ目の「戻る」押下時
if (!empty($_POST['back'])) {
    $_POST['back'] = '';
    // 値保持用
    $query_title = $_POST['title'] ? $_POST['title'] : '';
    $query_name = $_POST['name'] ? $_POST['name'] : '';
    $query_email = $_POST['email'] ? $_POST['email'] : '';
    $query_telnumber = $_POST['telnumber'] ? $_POST['telnumber'] : '';
    $query_content = $_POST['content'] ? htmlspecialchars($_POST['content']) : '';
    $page_flag = 1;
}

// 2ページの「送信」押下時
if (!empty($_POST['send'])) {
    $_POST['send'] = '';
    // 値保持用
    $query_title = $_POST['title'] ? $_POST['title'] : '';
    $query_name = $_POST['name'] ? $_POST['name'] : '';
    $query_email = $_POST['email'] ? $_POST['email'] : '';
    $query_telnumber = $_POST['telnumber'] ? $_POST['telnumber'] : '';
    $query_content = $_POST['content'] ? htmlspecialchars($_POST['content']) : '';

    $adminAddress = 'blue.guitar.tone@icloud.com';
    $adminTelnumber = '090-7496-0328';
    $returnContent = '弊社Webサイトより、お問い合わせ頂きありがとうございました。' . PHP_EOL
                   . '本メールはお問い合わせ受付の確認メールですので返信は不要です。';
    $sendAdmin = new mailSender($adminAddress, $query_email, $query_title, $query_name, $query_content, $query_telnumber);
    $sendAdminCheck = $sendAdmin->send();
    if ($sendAdminCheck) {
        $sendUser = new mailSender($query_email, $adminAddress, 'メール送信完了', '管理者', $returnContent, $adminTelnumber);
        $sendAdminCheck = $sendUser->send();
        if ($sendAdminCheck) {
            // 多重送信防止のためリダイレクト
            header("Location: http://mailform.wew.jp/finished.html");
            exit();
        } else {
            $sendErrorMessages[] = 'システムエラー。メール送信に失敗しました';       
        }
    } else {
        $sendErrorMessages[] = 'システムエラー。メール送信に失敗しました';
        $page_flag = 2;
    }
}



?>