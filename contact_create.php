<?php

// var_dump($_POST);
// exit();

// データの受け取り
$getName = $_POST["name"];
$getEmail = $_POST["email"];
$getContents = $_POST["contents"];


// csvファイルに書き込むためにスペースを空けてデータ1件を1行にまとめる（最後に改行を入れる）
$write_data = "{$getName},{$getEmail},{$getContents}\n";

// 追記モードでファイルを開く．引数が`a`である部分に注目！
// csvファイルが自動生成される
$file = fopen("data/contact.csv","a");

// ファイルをロックする
flock($file, LOCK_EX);

// 指定したファイルに指定したデータを書き込む
fwrite($file, $write_data);

// ファイルのロックを解除する
flock($file, LOCK_UN);

// ファイルを閉じる
fclose($file);

// その後データ入力画面に戻る
header("Location:contact_input.php");

?>




