<?php

//セッション引き継ぎ & DB接続
session_start();
include('login_function.php');
check_session_id();

// 入力項目のチェック
// var_dump($_POST);
// exit();

// DB接続
$pdo = connect_to_db();


//エラー時の処理
if (
    !isset($_POST['item']) || $_POST['item'] === '' ||
    !isset($_POST['explanation']) || $_POST['explanation'] === '' ||
    !isset($_POST['price']) || $_POST['price'] === '' ||
    !isset($_POST['id']) || $_POST['id'] === '' 
) {
    exit('paramError');
};

//変数の定義
$item = $_POST['item'];
$explanation = $_POST['explanation'];
$price = $_POST['price'];
$id = $_POST['id'];


// SQL実行  
// ******WHERE以下(WHERE id=:id')を書かないと全てに適応されてしまう******
// whereの前にカンマは"不要"
$sql = 'UPDATE items_table SET item=:item, explanation=:explanation, price=:price, created_at=now(), uploaded_at=now() WHERE id=:id';


$stmt = $pdo->prepare($sql);
$stmt->bindValue(':item', $item, PDO::PARAM_STR);
$stmt->bindValue(':explanation', $explanation, PDO::PARAM_STR);
$stmt->bindValue(':price', $price, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// header('Location:item-read.php');
// header("Location: " . $_SERVER['PHP_SELF']);


exit();



