<!-- 削除機能の作成 -->

<?php

//セッション引き継ぎ & DB接続
session_start();
include('login_function.php');
check_session_id();

//idデータ受け取り ▶︎ DBに接続 ▶︎ DBで処理を実行 ▶︎ データを引っ張ってくる

//idデータの受け取り
$id = $_GET['id'];

// DB接続
// include('function.php');
$pdo = connect_to_db();

// SQL実行  
// ******WHERE以下(WHERE id=:id')を書かないと全てに適応されてしまう******
$sql = 'DELETE FROM items_table WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:item-read.php");
exit();

?>