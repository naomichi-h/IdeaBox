<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　パスワードリマインダー認証キー入力ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//SESSIONに認証キーがあるか確認、なければリダイレクト
if (empty($_SESSION['auth_key'])) {
    header("Location:passRemindSend.php"); //認証キー送信ページへ
}


?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IdeaBox | パスワード再発行認証</title>
    <link rel="stylesheet" type="text/css" href="node_modules/ress/dist/ress.min.css" >
    <link rel="stylesheet" type="text/css" href="css/style.css" >
</head>
<body class="background-color">
    <div class ="form-wrap">
        <a href="index.php">
        <img class="site-icon" src="images/ideabox_icon.png" alt="ideabox_icon">
        <h1 class ="title">IdeaBox</h1>
        <p class = "catch">アイデアから、アイデアを。</p>
        </a>
        <div class="form-container">
            <p class="form-comment">ご指定のメールアドレスにお送りした<br>
            【パスワード再発行認証】<br>
            メール内にある「認証キー」をご入力ください
            </p>
            <form action="" method="post">

                <input class="form-input js-token" type="text" name="token" placeholder="認証キー">
                <div class="area-msg js-msg-token">
                </div>

                <input id="ajax-valid" class="btn form-btn" type="submit" value="再発行する">
            </form>
        </div>
        <div class="form-comment">
        <p><a href="pass_remind_send.php" class="link-color3">&lt; パスワード再発行メールを再度送信する</a></p>
        </div>
    </div>
</body>
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
<script src="js/ajax_pass_remind_recieve.js"></script>
</html>