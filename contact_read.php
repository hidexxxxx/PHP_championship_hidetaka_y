<?php

// ファイルを開く（読み取り専用）
$file = fopen("data/contact.csv", 'r');

// データまとめ用の空文字変数
$str = '';

// ファイルをロック
flock($file, LOCK_EX);

// fgets()は1行ずつ取得する関数なので→$lineに格納
if ($file) {
  while ($line = fgets($file)) {
    // 取得した$lineのデータ全てを順々に連結し`$str`に格納する。
    //「 . 」はphpで文字列する演算子
    $str .="{$line}";
  }
};

// ロックを解除する
flock($file, LOCK_UN);
// ファイルを閉じる
fclose($file);

// データを配列に変換する。(\n)を区切りとして分割し、配列に変換する組み込み関数
$dataArray = explode("\n", $str);

// 条件に一致するものだけを連続して並べる(=空行を削除する)
$dataArray = array_filter($dataArray);

// JSON形式のデータを生成
$jsonData = json_encode($dataArray);

//var_dumpで入っているか確認
//preで綺麗に表示してくれる
// echo '<pre>';
// var_dump($str);
// exit();
// echo '</pre>';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="archive_A.css">
    <title>spotlight × Cloud Garage</title>
</head>

<body>
    <header id="header">
        <div class="logo-box">
            <a href="archive.html"><img class="brand-logo" src="img/logo/brand-logo.png" alt="logo"></a>
        </div>
        <!-- <p class="hamburger-menu-p">Menu</p> -->
        <div class="hamburger-menu">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
        <nav class="wrapper">
            <ul class="menu">
                <li class="menu-top"><a href="#">TOP</a></li>
                <li class="menu-collection"><a href="collection.html">COLLECTION</a></li>
                <li class="menu-archive"><a href="archive.html">ARCHIVE</a></li>
                <li class="menu-category"><a href="#">CATEGORY</a></li>
                <li class="login-login"><a href="login.php">LOGIN</a></li>
                <li class="login-contact"><a href="contact_input.php">CONTACT</a></li>
            </ul>

            <ul class="login">
                <div class="profiles">
                    <!-- プロフィール画像表示 -->
                    <div id="output-profile-photo">
                        <img id="profile-photo" src="" alt="User Photo" onclick="location.href='resister.html';">
                    </div>
                    <!-- プロフィール名表示 -->
                    <h5 id="output"></h5>
                </div>
            </ul>
        </nav>
    </header>

     <a href="contact_input.php">▶お問い合わせ入力欄へ戻る</a>
    <fieldset>
    <legend>お問い合わせ内容確認画面</legend>
    
  <!-- $dataはループ内で使用する変数名 -->
   <?php foreach ($dataArray as $data) {
        //csvファイルでは「,」を区切りとして分割しているので「,」ごとに分かれて
        $dataItems = explode(',', $data);
        $name = $dataItems[0];
        $email = $dataItems[1];
        $contents = $dataItems[2];
    ?>
        <div>
            <h4>名前：<?= $name ?></h4>
            <p>メールアドレス：<?= $email ?></p>
            <p>問い合わせ内容：<?= $contents ?></p>
        </div>
        <!-- <hr>は水平線の横棒を入れて区切れる -->
        <hr>
    <?php } ?>

    </fieldset>
   

  <script>
    let dataArray = <?php echo $jsonData; ?>;
    console.log(dataArray); // データの表示
</script>

    

    <footer>
        <nav class="wrapper-footer">
            <ul class="menu-footer">
                <li><a href="#">初めての方へ</a></li>
                <li><a href="#">よくある質問</a></li>
                <li><a href="#">利用規約</a></li>
                <li><a href="#">特定商品取引法</a></li>
                <li><a href="#">プライバシーポリシー</a></li>
                <li><a href="#">お問い合わせ</a></li>
                <li><a href="#">会社概要</a></li>
            </ul>
        </nav>
        <h5 class="copy-rights">©️2023 Cloud Garage Co,.Ltd. All Rights Reserved</h5>
    </footer>
    </body>


</html>