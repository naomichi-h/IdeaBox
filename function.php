<?php
//================================
// ログ
//================================
//ログを取るか
ini_set('log_errors','on');
//ログの出力ファイルを指定
ini_set('error_log','php.log');

//================================
// デバッグ
//================================
//デバッグフラグ
$debug_flg = true;
//デバッグログ関数
function debug($str){
  global $debug_flg;
  if(!empty($debug_flg)){
    error_log('デバッグ：'.$str);
  }
}

//================================
// セッション準備・セッション有効期限を延ばす
//================================
//セッションファイルの置き場を変更する（/var/tmp/以下に置くと30日は削除されない）
session_save_path("/var/tmp/");
//ガーベージコレクションが削除するセッションの有効期限を設定（30日以上経っているものに対してだけ１００分の１の確率で削除）
ini_set('session.gc_maxlifetime', 60*60*24*30);
//ブラウザを閉じても削除されないようにクッキー自体の有効期限を延ばす
ini_set('session.cookie_lifetime ', 60*60*24*30);
//セッションを使う
session_start();
//現在のセッションIDを新しく生成したものと置き換える（なりすましのセキュリティ対策）
session_regenerate_id();

//================================
// 画面表示処理開始ログ吐き出し関数
//================================
function debugLogStart(){
    debug('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 画面表示処理開始');
    debug('セッションID：'.session_id());
    debug('セッション変数の中身：'.print_r($_SESSION,true));
    debug('現在日時タイムスタンプ：'.time());
    if(!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit'])){
      debug( 'ログイン期限日時タイムスタンプ：'.( $_SESSION['login_date'] + $_SESSION['login_limit'] ) );
    }
  }

//================================
// 定数
//================================
//エラーメッセージを定数に設定
define('MSG01','この項目は必須です。');
define('MSG02', 'Emailの形式で入力してください。');
define('MSG03','パスワード（再入力）が合っていません。');
define('MSG04','半角英数字のみご利用いただけます。');
define('MSG05','6文字以上で入力してください。');
define('MSG06','256文字以内で入力してください。');
define('MSG07','エラーが発生しました。しばらく経ってからやり直してください。');
define('MSG08', 'そのEmailは既に登録されています。');
define('MSG09', 'メールアドレスまたはパスワードが違います。');
define('MSG12', '古いパスワードが違います。');
define('MSG13', '古いパスワードと同じです。');
define('MSG14', '文字で入力してください。');
define('MSG15', '正しくありません。');
define('MSG16', '有効期限が切れています。');
define('MSG17', '半角数字のみご利用いただけます。');
define('SUC01', 'パスワードを変更しました。');
define('SUC02', 'プロフィールを変更しました。');
define('SUC03', 'メールを送信しました。');
define('SUC04', '登録しました。');

//================================
// グローバル変数
//================================
//エラーメッセージ格納用の配列
$err_msg = array();

//バリデーション関数（未入力チェック）
function validRequired($str, $key){
    if($str === ''){ //金額フォームなどを考えると数値の０はOKにし、空文字はダメにする
      global $err_msg;
      $err_msg[$key] = MSG01;
    }
  }

  //バリデーション関数（Email形式チェック）
function validEmail($str, $key){
    if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $str)){
      global $err_msg;
      $err_msg[$key] = MSG02;
    }
}

//バリデーション関数（Email重複チェック）
function validEmailDup($email){
    global $err_msg;
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
      //array_shift関数で配列の先頭を取り出して判定
      if(!empty(array_shift($result))){
        $err_msg['email'] = MSG08;
      }
    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
      $err_msg['common'] = MSG07;
    }
  }

//バリデーション関数（同値チェック）
function validMatch($str1, $str2, $key){
    if($str1 !== $str2){
      global $err_msg;
      $err_msg[$key] = MSG03;
    }
  }

//バリデーション関数（最小文字数チェック）
function validMinLen($str, $key, $min = 6){
    if(mb_strlen($str) < $min){
      global $err_msg;
      $err_msg[$key] = MSG05;
    }
  }
  //バリデーション関数（最大文字数チェック）
  function validMaxLen($str, $key, $max = 256){
    if(mb_strlen($str) > $max){
      global $err_msg;
      $err_msg[$key] = MSG06;
    }
  }
  //バリデーション関数（半角チェック）
  function validHalf($str, $key){
    if(!preg_match("/^[a-zA-Z0-9]+$/", $str)){
      global $err_msg;
      $err_msg[$key] = MSG04;
    }
}
//パスワードチェック
function validPass($str, $key){
    //半角英数字チェック
    validHalf($str, $key);
    //最大文字数チェック
    validMaxLen($str, $key);
    //最小文字数チェック
    validMinLen($str, $key);
  }

//selectboxチェック
function validSelect($str, $key){
    if(!preg_match("/^[0-9]+$/", $str)){
      global $err_msg;
      $err_msg[$key] = MSG15;
    }
  }
  //エラーメッセージ表示
  function getErrMsg($key){
    global $err_msg;
    if(!empty($err_msg[$key])){
      return $err_msg[$key];
    }
  }
  
//================================
// ログイン認証
//================================
function isLogin(){
    // ログインしている場合
    if( !empty($_SESSION['login_date']) ){
      debug('ログイン済みユーザーです。');
  
      // 現在日時が最終ログイン日時＋有効期限を超えていた場合
      if( ($_SESSION['login_date'] + $_SESSION['login_limit']) < time()){
        debug('ログイン有効期限オーバーです。');
  
        // セッションを削除（ログアウトする）
        session_destroy();
        return false;
      }else{
        debug('ログイン有効期限以内です。');
        return true;
      }
  
    }else{
      debug('未ログインユーザーです。');
      return false;
    }
  }
  
//================================
// データベース
//================================
//DB接続関数
function dbConnect(){
    //DBへの接続準備
    $dsn = 'mysql:dbname=ideabox;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
    $options = array(
      // SQL実行失敗時にはエラーコードのみ設定
      PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
      // デフォルトフェッチモードを連想配列形式に設定
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      // バッファードクエリを使う(一度に結果セットをすべて取得し、サーバー負荷を軽減)
      // SELECTで得た結果に対してもrowCountメソッドを使えるようにする
      PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    );
    // PDOオブジェクト生成（DBへ接続）
    $dbh = new PDO($dsn, $user, $password, $options);
    return $dbh;
  }

//SQL実行関数
function queryPost($dbh, $sql, $data){
    //クエリー作成
    $stmt = $dbh->prepare($sql);
    //プレースホルダに値をセットし、SQL文を実行
    if(!$stmt->execute($data)){
      debug('クエリに失敗しました。');
      debug('失敗したSQL：'.print_r($stmt,true));
      $err_msg['common'] = MSG07;
      return 0;
    }
    debug('クエリ成功。');
    return $stmt;
  }

//================================
// その他
//================================
// サニタイズ
function sanitize($str){
    return htmlspecialchars($str,ENT_QUOTES);
  }
  // フォーム入力保持
  function getFormData($str, $flg = false){
    if($flg){
      $method = $_GET;
    }else{
      $method = $_POST;
    }
    global $dbFormData;
    // ユーザーデータがある場合
    if(!empty($dbFormData)){
      //フォームのエラーがある場合
      if(!empty($err_msg[$str])){
        //POSTにデータがある場合
        if(isset($method[$str])){
          return sanitize($method[$str]);
        }else{
          //ない場合（基本ありえない）はDBの情報を表示
          return sanitize($dbFormData[$str]);
        }
      }else{
        //POSTにデータがあり、DBの情報と違う場合
        if(isset($method[$str]) && $method[$str] !== $dbFormData[$str]){
          return sanitize($method[$str]);
        }else{
          return sanitize($dbFormData[$str]);
        }
      }
    }else{
      if(isset($method[$str])){
        return sanitize($method[$str]);
      }
    }
  }
  