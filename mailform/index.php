<!-- 全体のコントローラ -->
<?php require(dirname(__FILE__).'/indexController.php'); ?>

<!DOCTYPE html>
<html lang="ja">
	<meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>お問い合わせフォーム</title>
    <!-- BootstrapのCSS読み込み -->
    <link href='css/bootstrap.min.css' rel='stylesheet'>
    <link href='css/style.css' rel='stylesheet'>
    <!-- jQuery読み込み -->
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script>
    <script>
        $(function () {
            $('#reset').bind('click', function () {
                $(this.form).find('textarea, :text, select').val('').end().find(':checked').prop('checked', false);
                $('#inputAge option:first').prop('selected', true);
            });
        });
        function disableButton(obj) {
            obj.disabled = true;
            obj.value = '処理中';
            obj.form.submit();
        }
    </script>
    <!-- BootstrapのJS読み込み -->
    <script src='js/bootstrap.min.js'></script>	<link rel='stylesheet' type='text/css' href='css/style.css'>
</head>
<body>
    <main>
        <div class='jumbotron'>
            <div class='container bg-light'>
                <div class='padding'>
                <?php if ($page_flag == 2) :  ?> <!-- 確認画面 -->
                    <div class='text-center'><h1>入力内容をご確認ください</h1></div>
                    <?php if (isset($sendErrorMessages)) {
                        foreach ($sendErrorMessages as $message) {
                            echo "<div class=\"alert alert-danger\">" . $message . "</div>";
                        }
                    } ?>
                    <table class="table table-striped">
                        <tr><th>件名</th><td><?= isset($query_title) ? $query_title : '' ?></td></tr>
                        <tr><th>名前</th><td><?= isset($query_name) ? $query_name : '' ?></td></tr>
                        <tr><th>メールアドレス</th><td><?= isset($query_email) ? $query_email : '' ?></td></tr>
                        <tr><th>電話番号</th><td><?= isset($query_telnumber) ? $query_telnumber : '' ?></td></tr>
                        <tr><th>お問い合わせ内容</th><td><?= isset($query_content) ? nl2br($query_content) : '' ?></td></tr>
                    </table>
                    <div class='row'>
                        <div class='col-md-1 offset-md-5'>
                            <form method='POST' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                <input type="hidden" name="title" value="<?= isset($query_title) ? $query_title : '' ?>">
                                <input type="hidden" name="name" value="<?= isset($query_name) ? $query_name : '' ?>">
                                <input type="hidden" name="email" value="<?= isset($query_email) ? $query_email : '' ?>">
                                <input type="hidden" name="telnumber" value="<?= isset($query_telnumber) ? $query_telnumber : '' ?>">
                                <input type="hidden" name="content" value="<?= isset($query_content) ? $query_content : '' ?>">
                                <input type='hidden' name='send' value='true'>
                                <input type='submit' value='送信する' class='btn btn-info btn-sm' onclick="disableButton(this);">
                                &nbsp;&nbsp;
                            </form>
                        </div>
                        <div class='col-md-6'>
                            <form method='POST' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                <input type="hidden" name="title" value="<?= isset($query_title) ? $query_title : '' ?>">
                                <input type="hidden" name="name" value="<?= isset($query_name) ? $query_name : '' ?>">
                                <input type="hidden" name="email" value="<?= isset($query_email) ? $query_email : '' ?>">
                                <input type="hidden" name="telnumber" value="<?= isset($query_telnumber) ? $query_telnumber : '' ?>">
                                <input type="hidden" name="content" value="<?= isset($query_content) ? $query_content : '' ?>">  
                                <input type='hidden' name='back' value='true'>
                                <input type='submit' value='戻る' class='btn btn-secondary btn-sm'>
                            </form>
                        </div>
                    </div>
                <?php else : ?>　<!-- 入力画面 -->
                    <div class='text-center'><h1>お問い合わせフォーム</h1></div>
                    <?php if (isset($errorMessages)) {
                        foreach ($errorMessages as $messages) {
                            foreach ($messages as $message) {
                                echo "<div class=\"alert alert-danger\">" . $message . "</div>";
                            }
                        }
                    } ?>
            		<form class='form' method='POST' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name='mainForm'>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-4'>
            						<label for='title'><span class="badge badge-secondary">必須</span> 件名</label>
                                </div>
                                <div class='col-md-8'>
            						<select class='form-control input-sm' id='title' name='title'>
            							<option value='' >選択してください</option>
            							<option value='ご意見' <?= (isset($query_title) && $query_title == 'ご意見') ? 'selected' : ''?>>ご意見</option>
            							<option value='感想' <?= (isset($query_title) && $query_title == '感想') ? 'selected' : ''?>>感想</option>
            							<option value='その他'  <?= (isset($query_title) && $query_title == 'その他') ? 'selected' : ''?>>その他</option>
            						</select>
                                </div>
            				</div>
                        </div>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-4'>
            						<label for='name'><span class="badge badge-secondary">必須</span> 名前</label>
                                </div>
                                <div class='col-md-8'>
           							<input class="form-control" id='name' type='text' name='name' value="<?= isset($query_name) ? $query_name : '' ?>" placeholder='例) 田中 一郎'>
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-4'>
            						<label for='email'><span class="badge badge-secondary">必須</span> メールアドレス</label>
                                </div>
                                <div class='col-md-8'>
           							<input class="form-control" id='email' type='text' name='email' value="<?= isset($query_email) ? $query_email : '' ?>" placeholder='例) xxx@example.com'>
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-4'>
            						<label for='telnumber'><span class="badge badge-secondary">必須</span> 電話番号</label>
                                </div>
                                <div class='col-md-8'>
                                       <input class="form-control" id='telnumber' type='tel' name='telnumber' value="<?= isset($query_telnumber) ? $query_telnumber : '' ?>" placeholder='例) 01234567890 (ハイフンなし)'>
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-4'>
            						<label for='content'><span class="badge badge-secondary">必須</span> お問い合わせ内容</label>
                                </div>
                                <div class='col-md-8'>
                                    <textarea class='form-control' id='content' name='content' ><?= isset($query_content) ? $query_content : '' ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                			<div class='col-md-7 offset-md-5'>
                				<input type='submit' name='confirm' value='確認画面へ' class='btn btn-info'>
                				&nbsp;&nbsp;
                				<button type='button' id='reset' class='btn btn-secondary'>リセット</button>
            			    </div>
                        </div>
        		    </form>
                <?php endif; ?> <!-- 入力画面終了 -->
                </div> <!-- padding終了 -->
            </div> <!-- container bg-light終了 -->
        </div> <!-- jumbotron終了 -->
    </main>
</body>
</html>
