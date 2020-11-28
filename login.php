<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ログインページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IdeaBox | ログイン</title>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/ress/dist/ress.min.css" >
    <link rel="stylesheet" type="text/css" href="css/style.css" >
</head>
<body class="background-color">
    <div class ="form-wrap">
        <img class="site-icon" src="images/idea-box-icon.png" alt="idea-box-icon">
        <h1 class ="title">IdeaBox</h1>
        <p class = "catch">アイデアから、アイデアを。</p>
        <form action="" method="post">

            <input class="form-input js-email" type="text" name="email" placeholder="Eメール">
            <div class="area-msg js-msg-email">
            </div>

            <input class="form-input js-password" type="password" name="password" placeholder="パスワード">
            <div class="area-msg js-msg-password">
            </div>

            <label class="label">
            <input class="checkbox js-login-save" type="checkbox" name="login_save">30日間ログインを省略する
            </label>


            <input id="ajax-valid" class="btn form-btn" type="submit" value="ログイン">
        </form>
        <div class="form-comment">
        <p>パスワードを忘れた方は<a href="">コチラ</a></p>
        <p><a class="signup.php" href="">アカウントを作成</a></p>
        </div>
    </div>
</body>
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
<script src="js/ajax_login.js"></script>
</html>