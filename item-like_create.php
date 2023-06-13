<?php

// var_dump($_GET);
// exit();


//DB接続
session_start();
include("login_function.php");
check_session_id();


//GETで送信される
//******** データの取得には$_GETを使用、データの送信や変更には`$_POST*********
if (
  !isset($_GET['todo_id']) || $_GET['todo_id'] === '' ||
  !isset($_GET['user_id']) || $_GET['user_id'] === ''
) {
  exit('paramError');
}

//変数も「$_GET」とする
$todo_id = $_GET['todo_id'];
$user_id = $_GET['user_id'];


//PDOオブジェクトを格納する変数には$pdoという名前がよく使われる
$pdo = connect_to_db();


//like件数を確認
$sql = 'SELECT COUNT(*) FROM like_table WHERE user_id=:user_id AND todo_id=:todo_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':todo_id', $todo_id, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//fetchを使って指定したカラムの値を取得し変数$like_countに代入しlikeをカウント
$like_count = $stmt->fetchColumn();
// まずはデータ確認
// var_dump($like_count);
// exit();


// ▼自作自演ができないように１ユーザ１いいねの機能を実装する
// ▼いいねされている状態。いいねが同じユーザーで複数ある条件の時削除する
if ($like_count !== 0) {
  $sql = 'DELETE FROM like_table WHERE user_id=:user_id AND todo_id=:todo_id';
  // ▼いいねされていない状態(0個の時)。情報をインサートしていいねを実行する
} else {
  $sql = 'INSERT INTO like_table (id, user_id, todo_id, created_at) VALUES (NULL, :user_id, :todo_id, now())';
}


//情報をインサートで実行する。以下のsql分だけでは自作自演ができてしまうので上記if文のelseに入れる
// $sql = 'INSERT INTO like_table (id, user_id, todo_id, created_at) VALUES (NULL, :user_id, :todo_id, now())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':todo_id', $todo_id, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:item-read.php");
exit();






?>
