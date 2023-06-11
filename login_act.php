<?php

// <!-- **********ここに以下のコードは記述NG！！****************
// //ログインしていないと動いて欲しくないので
// session_start();
// include('functions.php');
// check_session_id(); -->
// <!-- ****************ループしてしまう******************* -->

// データ受け取り
session_start();
include('login_function.php');

$username = $_POST['username'];
$password = $_POST['password'];

// DB接続
$pdo = connect_to_db();

// SQL実行
// username，password，deleted_atの3項目全ての条件満たすデータを抽出する．sqlでデータを探す
$sql = 'SELECT * FROM users_table WHERE username=:username AND password=:password AND deleted_at IS NULL';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);


// ユーザ有無で条件分岐
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$user = $stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($user);
// exit();


//ログイン情報が違った時
if (!$user) {
  echo "<p>ログイン情報に誤りがあります</p>";
  echo "<a href=login.php>ログイン</a>";
  exit();

  //ログイン情報が正しかった時,空にして,id情報は以下に必ず入れておく
} else {
  $_SESSION = array();
  $_SESSION['session_id'] = session_id();
  $_SESSION['is_admin'] = $user['is_admin'];
  $_SESSION['username'] = $user['username'];

  //保存後は一覧ページへ遷移する    
  header("Location:collection.html");
  exit();
}

?>



