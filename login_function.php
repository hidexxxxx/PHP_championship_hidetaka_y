<?php

//DB接続関数
function connect_to_db()
{
  $dbn = 'mysql:dbname=07_php02_work_items;charset=utf8mb4;port=3306;host=localhost';
  $user = 'root';
  $pwd = '';

  // try: 例外が発生する可能性のあるコードブロックを定義
  try {
    return new PDO($dbn, $user, $pwd);
    // catch: tryブロック内でスローされた例外をキャッチしexitする
    // PDOExceptionは、PHPに組み込まれている例外クラスの一つ,エラーが発生した場合にスローされる
  } catch (PDOException $e) {
    // $e->getMessage()は$eという変数が持つ例外オブジェクトのgetMessage メソッドを呼び出してエラーメッセージを作成
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
  }
}

// ログイン状態のチェック関数
//ログインしていないと機能して欲しくないファイルはcheck session id関数を全て書く
function check_session_id()
{
  //!isset($_SESSION["session_id"]はnullだった時、$_SESSION["session_id"] !== session_id()は違うidだった時
  if (!isset($_SESSION["session_id"]) || $_SESSION["session_id"] !== session_id()) {
    header('Location:login.php');
    exit();
  } else {
    session_regenerate_id(true);
    $_SESSION["session_id"] = session_id();
  }
};


?>