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
    $login_save = (!empty($_POST['login_save'])) ? true : false;

    debug('$_POSTの中身:' . print_r($_POST, true));

    //未入力チェック
    validRequired($email, 'email');
    validRequired($password, 'password');

    //未入力チェックokなら先へ
    //ifのネストが深くなっているが、これは、エラーメッセージの有無の切り替え(問題が生じた時は出し、その後問題がなくなれば消す)と、
    //一つ一つのバリデーションを独立させて判定させることを両立させる方法が他に見つからなかったため
    if (empty($err_msg['email']) && empty($err_msg['password'])) {

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

                //パスワードの最小文字数チェック
                validMinLen($password, 'password');

                if (empty($err_msg['email']) && empty($err_msg['password'])) {
                    //例外処理
                    try {
                        // DBへ接続
                        $dbh = dbConnect();
                        // SQL文作成
                        $sql = 'SELECT password,id  FROM users WHERE email = :email AND delete_flg = 0';
                        $data = array(':email' => $email);
                        // クエリ実行
                        $stmt = queryPost($dbh, $sql, $data);
                        // クエリ結果の値を取得
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
      
                        debug('クエリ結果の中身：'.print_r($result, true));
      
                        // パスワード照合
                        if (!empty($result) && password_verify($password, array_shift($result))) {
                            debug('パスワードがマッチしました。');
        
                            //ログイン有効期限（デフォルトを１時間とする）
                            $sesLimit = 60*60;
                            // 最終ログイン日時を現在日時に
                            $_SESSION['login_date'] = time(); //time関数は1970年1月1日 00:00:00 を0として、1秒経過するごとに1ずつ増加させた値が入る
        
                            // ログイン保持にチェックがある場合
                            if ($login_save) {
                                debug('ログイン保持にチェックがあります。');
                                // ログイン有効期限を30日にしてセット
                                $_SESSION['login_limit'] = $sesLimit * 24 * 30;
                            } else {
                                debug('ログイン保持にチェックはありません。');
                                // ログイン有効期限を1時間後にセット
                                $_SESSION['login_limit'] = $sesLimit;
                            }
                            // ユーザーIDを格納
                            $_SESSION['user_id'] = $result['id'];
        
                            debug('セッション変数の中身：'.print_r($_SESSION, true));
                            debug('マイページへ遷移します。');
                        } else {
                            debug('パスワードがアンマッチです。');
                            $err_msg['password'] = MSG09;
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
