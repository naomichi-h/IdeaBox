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
    <link rel="stylesheet" type="text/css" href="style.css" >
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

            <input class="form-input js-password_re" type="password" name="password_re" placeholder="パスワード再入力">
            <div class="area-msg js-msg-password_re">
            </div>


            <input id="ajax-valid" class="btn form-btn" type="submit" value="新規登録">
        </form>
        <div class="form-comment">
        <p>アカウントを作成すると、サービス<a href="">利用規約</a>および<br>
        <a href="">プライバシーポリシー</a>に同意したとみなされます。</p>
        <p>すでにアカウントをお持ちですか？<br>
        <a class="login" href="">ログイン</a></p>
        </div>
    </div>
</body>
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
<script src="app.js"></script>
</html>