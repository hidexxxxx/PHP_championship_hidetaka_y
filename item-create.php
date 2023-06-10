<?php
// POSTデータ確認
// var_dump($_POST);
// exit();

//記入欄にデータが未記入のときの処理
//前者は未定義、後者はから文字列の条件
if (
    !isset($_POST['item']) || $_POST['item'] === '' ||
    !isset($_FILES['photo_A']['name']) || $_FILES['photo_A']['name'] === '' ||
    !isset($_FILES['photo_A']['tmp_name']) || $_FILES['photo_A']['tmp_name'] === '' ||
    !isset($_FILES['photo_B']['name']) || $_FILES['photo_B']['name'] === '' ||
    !isset($_FILES['photo_B']['tmp_name']) || $_FILES['photo_B']['tmp_name'] === '' ||
    !isset($_FILES['photo_C']['name']) || $_FILES['photo_C']['name'] === '' ||
    !isset($_FILES['photo_C']['tmp_name']) || $_FILES['photo_C']['tmp_name'] === '' ||
    !isset($_POST['explanation']) || $_POST['explanation'] === '' ||
    !isset($_POST['price']) || $_POST['price'] === '' 
) {
    exit('未記入/未選択の箇所があります。');
};

//変数の定義
$item = $_POST["item"];
$explanation = $_POST["explanation"];
$price = $_POST["price"];

//元ファイルのファイル名を取得。FILESはフォーム内の <input type="file"> 要素に対して発動
$photo_name_A = $_FILES['photo_A']['name'];
$photo_name_B = $_FILES['photo_B']['name'];
$photo_name_C = $_FILES['photo_C']['name'];

//$photo_tmpはアップロードされたファイルの一時的な保存先のパス。一時的に保存することにより安全性や柔軟性が向上
$photo_tmp_A = $_FILES['photo_A']['tmp_name'];
$photo_tmp_B = $_FILES['photo_B']['tmp_name'];
$photo_tmp_C = $_FILES['photo_C']['tmp_name'];

//$photo_dirはアップロードされたファイルの最終的な保存先のパス。dataHolderに保存されている
$photo_dir_A = './dataHolder/' . $photo_name_A;
$photo_dir_B = './dataHolder/' . $photo_name_B;
$photo_dir_C = './dataHolder/' . $photo_name_C;

//▼画像を一時的な保存場所$photo_tmpから、永続的な保存場所$photo_dirに移動させるコード
move_uploaded_file($photo_tmp_A, $photo_dir_A);
move_uploaded_file($photo_tmp_B, $photo_dir_B);
move_uploaded_file($photo_tmp_C, $photo_dir_C);

//DB接続
$dbn ='mysql:dbname=07_php02_work_items;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';

try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}
// exit("ok");

$sql = 'INSERT INTO items_table (id, item, photo_A, photo_B, photo_C, explanation, created_at, uploaded_at, price) VALUES (NULL, :item, :photo_A, :photo_B, :photo_C, :explanation, now(), now(), :price)';
$stmt = $pdo->prepare($sql);

//バインド変数から変換
$stmt->bindValue(":item", $item, PDO::PARAM_STR);
$stmt->bindValue(":explanation", $explanation, PDO::PARAM_STR);
$stmt->bindValue(":price", $price, PDO::PARAM_STR);
// $photo_dirがポイント
$stmt->bindValue(":photo_A", $photo_dir_A, PDO::PARAM_STR);
$stmt->bindValue(":photo_B", $photo_dir_B, PDO::PARAM_STR);
$stmt->bindValue(":photo_C", $photo_dir_C, PDO::PARAM_STR);

// SQL実行
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
};

header('Location:item-read.php');
exit();

?>