<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ユーザー登録ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IdeaBox | 会員登録</title>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/ress/dist/ress.min.css" >
    <link rel="stylesheet" type="text/css" href="css/style.css" >
</head>
<body class="background-color">
    <div class ="form-wrap">
        <a href="index.php">
        <img class="site-icon" src="images/ideabox_icon.png" alt="ideabox_icon">
        <h1 class ="title">IdeaBox</h1>
        <p class = "catch">アイデアから、アイデアを。</p>
        </a>
        <form action="" method="post">

            <input class="form-input js-email" type="text" name="email" placeholder="Eメール">
            <div class="area-msg js-msg-email">
            </div>

            <input class="form-input js-password" type="password" name="password" placeholder="パスワード">
            <div class="area-msg js-msg-password">
            </div>

            <input class="form-input js-password-re" type="password" name="password_re" placeholder="パスワード再入力">
            <div class="area-msg js-msg-password-re">
            </div>


            <input id="ajax-valid" class="btn form-btn" type="submit" value="新規登録">
        </form>
        <div class="form-comment-wrap">
        <p class="form-comment">アカウントを作成すると、サービス<a class="link-color3" href="" >利用規約</a>および<br>
        <a class="link-color3" href="">プライバシーポリシー</a>に同意したとみなされます。</p>
        <p class="form-comment">すでにアカウントをお持ちですか？<br>
        <a class="fontsize-m link-color3" href="login.php">ログイン</a></p>
        </div>
    </div>
</body>
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
<script src="js/ajax_signup.js"></script>
</html>