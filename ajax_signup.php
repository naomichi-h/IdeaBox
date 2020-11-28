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
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_re = $_POST['password_re'];

    //未入力チェック
    validRequired($email, 'email');
    validRequired($password, 'password');
    validRequired($password_re, 'password_re');


    debug("未入力チェック完了");

    //ifのネストが深くなっているが、これは、エラーメッセージの有無の切り替え(問題が生じた時は出し、その後問題がなくなれば消す)と、
    //一つ一つのバリデーションを独立させて判定させることを両立させる方法が他に見つからなかったため
    if (empty($err_msg['email']) && empty($err_msg['password']) && empty($err_msg['password_re'])) {

        //emailの形式チェック
        validEmail($email, 'email');

        //パスワードの半角英数字チェック
        validHalf($password, 'password');

        if (empty($err_msg['email']) && empty($err_msg['password'])) {

            //emailの最大文字数チェック
            validMaxLen($email, 'email');

            //パスワードの最大文字数チェック
            validMaxLen($password, 'password');

            if (empty($err_msg['email']) && empty($err_msg['password'])) {

                //email重複チェック
                validEmailDup($email);

                //パスワードの最小文字数チェック
                validMinLen($password, 'password');

                //パスワードとパスワード再入力が合っているかチェック
                validMatch($password, $password_re, 'password_re');

                if (empty($err_msg['email']) && empty($err_msg['password']) && empty($err_msg['password_re'])) {
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
                        if ($stmt) {
                            //ログイン有効期限（デフォルトを１時間とする）
                            $ses_limit = 60*60;
                            // 最終ログイン日時を現在日時に
                            $_SESSION['login_date'] = time();
                            $_SESSION['login_limit'] = $ses_limit;
                            // ユーザーIDを格納
                            $_SESSION['user_id'] = $dbh->lastInsertId();
          
                            debug('セッション変数の中身：'.print_r($_SESSION, true));
                        }
                    } catch (Exception $e) {
                        error_log('エラー発生:' . $e->getMessage());
                        $err_msg['password'] = MSG07;
                    }
                }
            }
        }
    }
}

echo json_encode($err_msg);
