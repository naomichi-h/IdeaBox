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

            debug('認証キー照合ok')

            if (time() > $_SESSION['auth_key_limit']) {
                $err_msg['token'] = MSG16;
            }


            if (empty($err_msg['token'])) {

                debug('認証キー期限内ok')

        //例外処理
                try {
                    // DBへ接続
                    $dbh = dbConnect();
                    // SQL文作成
                    $sql = 'SELECT count(*) FROM users WHERE email = :email AND delete_flg = 0';
                    $data = array(':email' => $email);
                    // クエリ実行
                    $stmt = queryPost($dbh, $sql, $data);
                    // クエリ結果の値を取得
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    // EmailがDBに登録されている場合
                    if ($stmt && array_shift($result)) {
                        debug('クエリ成功。DB登録あり。');
                        $_SESSION['msg_success'] = SUC03;
          
                        $auth_key = makeRandKey(); //認証キー生成
          
                        //メールを送信
                        $from = 'info@ideabox.com';
                        $to = $email;
                        $subject = '【パスワード再発行認証】｜IdeaBox';
                        $comment = <<<EOT
本メールアドレス宛にパスワード再発行のご依頼がありました。
下記のURLにて認証キーをご入力頂くとパスワードが再発行されます。

パスワード再発行認証キー入力ページ：http://localhost:8888/idea_box/pass_remind_recieve.php
認証キー：{$auth_key}
※認証キーの有効期限は30分となります。

認証キーを再発行されたい場合は下記ページより再度再発行をお願い致します。
http://localhost:8888/idea_box/pass_remind_send.php

////////////////////////////////////////
アイデアボックスカスタマーセンター
URL  http://ideabox.com/
E-mail info@ideabox.com
////////////////////////////////////////
EOT;
                        sendMail($from, $to, $subject, $comment);
          
                        //認証に必要な情報をセッションへ保存
                        $_SESSION['auth_key'] = $auth_key;
                        $_SESSION['auth_email'] = $email;
                        $_SESSION['auth_key_limit'] = time()+(60*30); //現在時刻より30分後のUNIXタイムスタンプを入れる
                        debug('セッション変数の中身：'.print_r($_SESSION, true));
                    } else {
                        debug('クエリに失敗したかDBに登録のないEmailが入力されました。');
                        $err_msg['email'] = MSG07;
                    }
                } catch (Exception $e) {
                    error_log('エラー発生:' . $e->getMessage());
                    $err_msg['email'] = MSG07;
                }
            }
        }
    }
}

echo json_encode($err_msg);
