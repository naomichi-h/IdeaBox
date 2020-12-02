<?php

//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　Ajaxバリデーション処理　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//post送信されていた場合
if (!empty($_POST)) {

    //変数にユーザー情報を代入
    $auth_key = $_POST['token'];

    //未入力チェック
    validRequired($auth_key, 'token');

    //未入力チェックokなら先へ
    //ifのネストが深くなっているが、これは、エラーメッセージの有無の切り替え(問題が生じた時は出し、その後問題がなくなれば消す)と、
    //一つ一つのバリデーションを独立させて判定させることを両立させる方法が他に見つからなかったため
    if (empty($err_msg['token'])) {
        debug('バリデーションOK。');

        if ($auth_key !== $_SESSION['auth_key']) {
            $err_msg['token'] = MSG15;
        }

        if (empty($err_msg['token'])) {
            debug('認証キー照合ok');

            if (time() > $_SESSION['auth_key_limit']) {
                $err_msg['token'] = MSG16;
            }


            if (empty($err_msg['token'])) {
                $password = makeRandKey(); //パスワード生成


                debug('認証キー期限内ok');

                //例外処理
                try {
                    // DBへ接続
                    $dbh = dbConnect();
                    // SQL文作成
                    $sql = 'UPDATE users SET password = :password WHERE email = :email AND delete_flg = 0';
                    $data = array(':email' => $_SESSION['auth_email'], ':password' => password_hash($password, PASSWORD_DEFAULT));
                    // クエリ実行
                    $stmt = queryPost($dbh, $sql, $data);
  
                    // クエリ成功の場合
                    if ($stmt) {
                        debug('クエリ成功。');
  
                        //メールを送信
                        $from = 'info@ideabox.com';
                        $to = $_SESSION['auth_email'];
                        $subject = '【パスワード再発行完了】｜IdeaBox';
                        $comment = <<<EOT
  本メールアドレス宛にパスワードの再発行を致しました。
  下記のURLにて再発行パスワードをご入力頂き、ログインください。
  
  ログインページ：http://localhost:8888/idea_box/login.php
  再発行パスワード：{$password}
  ※ログイン後、パスワードのご変更をお願い致します
  
  ////////////////////////////////////////
  ウェブカツマーケットカスタマーセンター
  URL  http://webukatu.com/
  E-mail info@webukatu.com
  ////////////////////////////////////////
  EOT;
                        sendMail($from, $to, $subject, $comment);
  
                        //セッション削除
                        session_unset();
                        $_SESSION['msg_success'] = SUC03;
                        debug('セッション変数の中身：'.print_r($_SESSION, true));
                    } else {
                        debug('クエリに失敗しました。');
                        $err_msg['token'] = MSG07;
                    }
                } catch (Exception $e) {
                    error_log('エラー発生:' . $e->getMessage());
                    $err_msg['token'] = MSG07;
                }
            }
        }
    }
}

echo json_encode($err_msg);
