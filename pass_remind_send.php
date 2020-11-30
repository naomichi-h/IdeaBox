<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　パスワードリマインダーページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();


?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IdeaBox | ログイン</title>
    <link rel="stylesheet" type="text/css" href="node_modules/ress/dist/ress.min.css" >
    <link rel="stylesheet" type="text/css" href="css/style.css" >
</head>
<body class="background-color">
    <div class ="form-wrap">
        <img class="site-icon" src="images/ideabox_icon.png" alt="ideabox_icon">
        <h1 class ="title">IdeaBox</h1>
        <p class = "catch">アイデアから、アイデアを。</p>
        <div class="form-container">
            <p class="form-comment">ご指定のメールアドレス宛にパスワード再発行の<br>
            URLと認証キーをお送りいたします</p>
            <form action="" method="post">

                <input class="form-input js-email" type="text" name="email" placeholder="Eメール">
                <div class="area-msg js-msg-email">
                </div>

                <input id="ajax-valid" class="btn form-btn" type="submit" value="送信する">
            </form>
        </div>
        <div class="form-comment">
        <p><a href="login.php" class="link-color3">&lt; ログインページに戻る</a></p>
        </div>
    </div>
</body>
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
<script src="js/ajax_pass_remind_send.js"></script>
</html>