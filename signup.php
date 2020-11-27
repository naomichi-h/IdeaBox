<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ユーザー登録ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//post送信されていた場合
if(!empty($_POST)){

    //変数にユーザー情報を代入
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_re = $_POST['password_re'];
  
    //未入力チェック
    validRequired($email, 'email');
    validRequired($password, 'password');
    validRequired($password_re, 'password_re');
  
    if(empty($err_msg)){
  
      //emailの形式チェック
      validEmail($email, 'email');
      //emailの最大文字数チェック
      validMaxLen($email, 'email');
//       //email重複チェック
      validEmailDup($email);
  
      //パスワードの半角英数字チェック
      validHalf($password, 'password');
      //パスワードの最大文字数チェック
      validMaxLen($password, 'password');
      //パスワードの最小文字数チェック
      validMinLen($password, 'password');
  
      //パスワード（再入力）の最大文字数チェック
      validMaxLen($password_re, 'password_re');
      //パスワード（再入力）の最小文字数チェック
      validMinLen($password_re, 'password_re');
  
      if(empty($err_msg)){
  
//         //パスワードとパスワード再入力が合っているかチェック
        validMatch($password, $password_re, 'password_re');
  
        if(empty($err_msg)){
  
          //例外処理
          try {
            // DBへ接続
            $dbh = dbConnect();
            // SQL文作成
            $sql = 'INSERT INTO users (email,password, create_date) VALUES(:email,:pass,:create_date)';
            $data = array(':email' => $email, ':pass' => password_hash($password, PASSWORD_DEFAULT),
                          ':create_date' => date('Y-m-d H:i:s'));
            // クエリ実行
            $stmt = queryPost($dbh, $sql, $data);
            
            // クエリ成功の場合
            if($stmt){
              //ログイン有効期限（デフォルトを１時間とする）
              $sesLimit = 60*60;
              // 最終ログイン日時を現在日時に
              $_SESSION['login_date'] = time();
              $_SESSION['login_limit'] = $sesLimit;
              // ユーザーIDを格納
              $_SESSION['user_id'] = $dbh->lastInsertId();
  
              debug('セッション変数の中身：'.print_r($_SESSION,true));
  
            //   header("Location:mypage.php"); //マイページへ
            }
  
          } catch (Exception $e) {
            error_log('エラー発生:' . $e->getMessage());
            $err_msg['common'] = MSG07;
          }
  
        }
      }
    }
  }
  
?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Idea Box | 会員登録</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="background-color">
    <div class ="form-wrap">
        <img class="site-icon" src="images/idea-box-icon.png" alt="idea-box-icon">
        <h1 class ="title">IdeaBox</h1>
        <p class = "catch">アイデアから、アイデアを。</p>
        <form action="" method="post">

            <input class="form-input" type="text" name="email" placeholder="Eメール">
            <div class="area-msg">
                <?php 
                    if(!empty($err_msg['email'])) echo $err_msg['email'];
                ?>
            </div>

            <input class="form-input" type="password" name="password" placeholder="パスワード">
            <div class="area-msg">
                <?php 
                    if(!empty($err_msg['password'])) echo $err_msg['password'];
                ?>
            </div>

            <input class="form-input" type="password" name="password_re" placeholder="パスワード再入力">
            <div class="area-msg">
                <?php 
                    if(!empty($err_msg['password_re'])) echo $err_msg['password_re'];
                ?>
            </div>


            <input class="btn form-btn" type="submit" value="新規登録">
        </form>
        <div class="form-comment">
        <p>アカウントを作成すると、サービス<a href="">利用規約</a>および<br>
        <a href="">プライバシーポリシー</a>に同意したとみなされます。</p>
        <p>すでにアカウントをお持ちですか？<br>
        <a class="login" href="">ログイン</a></p>
        </div>
    </div>
</body>
</html>