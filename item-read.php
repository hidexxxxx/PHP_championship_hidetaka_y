<?php


//セッション引き継ぎ
session_start();
include('login_function.php');
check_session_id();


//データベースから返ってきたデータ
$user_id = $_SESSION['user_id'];
// var_dump($user_id);
// exit();
// $todo_id = $_SESSION['todo_id'];

//DB接続
$pdo = connect_to_db();


// ソートの方法（安い順 or 高い順）とフィールド（価格 or アップロード日時）を取得
$sort = $_GET['sort'] ?? 'asc';
$field = $_GET['field'] ?? 'price';

// SQL作成&実行.まずはmyadminのsqlタブから動作確認した後にここに記載する
$sql = 'SELECT * FROM items_table LEFT OUTER JOIN ( SELECT todo_id, COUNT(id) AS like_count FROM like_table GROUP BY todo_id ) AS result_table ON items_table.id = result_table.todo_id ORDER BY ';

//likeをしたユーザidのtodo_idをlike_tableから選別する
$sql_like = 'SELECT todo_id FROM like_table WHERE user_id = user_id'; 

// ソート対象のフィールドによってSQL文を変更
if ($field == 'price') {
    $sql .= 'price ';
} elseif ($field == 'uploaded_at') {
    $sql .= 'uploaded_at ';
}

// ソートの方法によってSQL文を変更
if ($sort == 'asc') {
    $sql .= 'ASC';
} elseif ($sort == 'desc') {
    $sql .= 'DESC';
}

$stmt = $pdo->prepare($sql);
$stmt_like = $pdo->prepare($sql_like);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

try {
  $status = $stmt_like->execute();
} catch (PDOException $e) {
  echo json_encode(["sql_like error" => "{$e->getMessage()}"]);
  exit();
}

//fetchAll(PDO::FETCH_ASSOC);結果セットの全ての行を取得し連想配列の形式で返す
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$result_like = $stmt_like->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// var_dump($result_like);
// echo "</pre>";
// exit();

// $like_count = $record["like_count"];
// var_dump($like_count);

// 結果表示実行
$output = "";
foreach ($result as $record) {
  //like{$record["like_count"]}でlikeの後にlike数を出力させる"like_count"は連想配列のキー
  $output .= 
    "
    <section class='grid'>
      <div class='each-grid' id=\"{$record['id']}\" value=\"{$record['id']}\">
          <p class='item-title'>{$record["item"]}</p>
          <div class='box'>
              <div>
                  <img src='{$record["photo_A"]}' class='photo_A'>
              </div>
              <div class='half-box'>
                  <img src='{$record["photo_B"]}' class='photo_B'>
                  <img src='{$record["photo_C"]}' class='photo_C'>
              </div>
          </div>
          <p class='item-explanation'>{$record["explanation"]}</p>
          <p class='item-price'>price : ¥ {$record["price"]}</p>
          <div>
              <button class='no-like' onclick=\"location.href='item-like_create.php?user_id={$user_id}&todo_id={$record["id"]}';\">&#9825; {$record["like_count"]}</button>
          </div>
          <div class='edit-delete-box'>
            <button class='openEditModal' onclick=\"openEditModal('item-edit.php?id={$record['id']}')\">▶︎E<span class='edit-dit-char-size'>dit</span></button>
            <a href='item-delete.php?id={$record["id"]}' class='item-delete'>▶︎D<span class='delete-elete-char-size'>elete </span></a>
          </div>
      </div>  
    </section>
    
    ";   
}

?>


<!-- ▲phpはここまで  ▼ここからHTML -->

<!DOCTYPE html>
<html lang="ja">
  
  <head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="reset.css">
    <link rel="stylesheet" type="text/css" href="sanitize.css">
    <link rel="stylesheet" href="item-read.css">
    <link rel="stylesheet" href="item-resister-modal.css">
    <link rel="stylesheet" href="item-edit-modal.css">
    <link rel="stylesheet" type="text/css" href="header-menu-move.css">
    <title>Garage CORSA</title>
  </head>
  
  <body>

    <header id="header" class="DownMove">
        <div class="logo-box">
            <a href="archive.html"><img class="brand-logo" src="img/logo/brand-logo.png" alt="logo"></a>
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

        <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-storage.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <!-- プロフィールテキストの読み込みコード -->
        <script src="profile_textData_read.js" type="module"></script>

        <!-- プロフィール画像の読み込みコード -->
        <script src="profile_photoData_read.js" type="module"></script>

    </header>

    <main>
      <div id="grobalNaviStart"></div>
      <br>
      <br>
      <!-- ▼以下アイテム情報登録のためのモーダル -->
      <!-- モーダルオープンのためのボタン -->
      <div class="to-list-modal">
        <a id="openModal" class="openModal"> ▶︎ To list (出品)</a>
      </div>
      <!-- ▼モーダルエリアここから -->
      <section id="modalArea" class="modalArea">
            <form action="item-create.php" method="POST" enctype="multipart/form-data">
                <fieldset class="fieldset-modal">
                  <p class="item-resister-p"> - 商品登録画面 - </p>
                  <!-- <br> -->
                  <div>
                      <input type="text" name="item" class="item" placeholder="*商品名を入力してください">
                  </div>
                  <!-- <br> -->
                  <div>
                      Photo ①: <input type="file" name="photo_A" class="resister_form_photo_A" accept=".jpg,.jpeg,.png" required>
                      Photo ②: <input type="file" name="photo_B" class="resister_form_photo_B" accept=".jpg,.jpeg,.png" required>
                      Photo ③: <input type="file" name="photo_C" class="resister_form_photo_C" accept=".jpg,.jpeg,.png" required>
                  </div>
                  <!-- <br> -->
                  <div>
                    <textarea rows=3 name="explanation" class="explanation" placeholder="＊商品の説明を記入してください"></textarea>
                  </div>
                  <!-- <br> -->
                  <div>
                    <input type="input" name="price" class="price" placeholder="＊金額を記入して下さい(例：10000円の場合「10000」と記入)">
                  </div>
                  <!-- <br> -->
                  <div class="submit-button-box">
                      <button type="submit" class="resister-button">▶︎登録</button>
                  </div>                
                </fieldset>
              </form>
          <div id="closeModal" class="closeModal">
            ×
          </div>
          
        </div>
      </section>
      <!-- モーダルエリアここまで -->

      <div class='sort-container'>
        <div class='sort-conditions'>
          <!-- 高い順へのソートリンク -->
          <a href="item-read.php?sort=desc&field=price" class='sort-expensive'>▲価格の高い順</a>
          <!-- 安い順へのソートリンク -->
          <a href="item-read.php?sort=asc&field=price" class='sort-cheaper'>▽価格の安い順</a>
          <!-- 新しい順へのソートリンク -->
          <a href="item-read.php?sort=desc&field=uploaded_at" class='sort-new'>▲新しい順</a>
          <!-- 古い順へのソートリンク -->
          <a href="item-read.php?sort=asc&field=uploaded_at" class='sort-old'>▽古い順</a>
        </div>
      </div>

      <!-- 以下の空行は必要。sort-containerが入るため -->
      <!-- <br> -->
    
      <fieldset class="fieldset-garage-sale">

        <legend>Garage Sale !!</legend>
      
          <section class='grid'>

            <!-- 商品編集用のモーダル -->
            <div id="modalEditArea" class="modalEditArea">  
              <iframe id = "modalEdit" class="modalEdit" style="visibility:visible;"></iframe>                 
            </div>  

            <!-- phpでタグ作って結果を表示させる書き方↓-->
            <?php echo $output ?>

          </section>
        <!-- </div> -->

      </fieldset>

      <a href="chat.html"><button type="button" id="to-chat-space-button" class="to-chat-space-button">▶︎ To<br>Chat<br>Space</button></a>

      <!-- ↓body閉じタグ直前でjQueryを読み込む -->
      <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      
      <!-- グローバルナビゲーションでメニューバー表示 -->
      <script src="https://code.jquery.com/jquery-3.4.1.min.js"
          integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
      <script src="header-grobalNavi-move.js"></script>
      
      <!-- 商品登録input用のモーダルコード -->
      <script src="item-input-modal.js"></script>

      <!-- 商品情報の編集用モーダルの起動用コード -->
      <script src="item-edit-modal.js"></script>

      <!-- いいね機能発動用コード -->
      <script>

        const result_id = <?php echo json_encode($result_like); ?>;
        
        const value = $('.each-grid').attr('value');
        // console.log(value);
        // console.log(result_id[0].todo_id);

        for (let result_id2 of result_id) {
        // console.log(result_id2.todo_id);
          const box_id = result_id2.todo_id;
          //button1が見つかった時にはno-likeクラスを削除し代わりにbutton2クラスを追加
          console.log($("#" + box_id).find("button.no-like"));
          
          const findbtn = $("#" + box_id).find("button.no-like");
          console.log(findbtn);

        // ボタンがクリックされた場合の処理
        $(findbtn).removeClass("no-like").addClass("buttonLike");
        
        };

      </script>

    </main>

  </body>

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
        <h5 class="copy-rights">©️2023 GARAGE CORSA Co,.Ltd. All Rights Reserved</h5>
  </footer>

</html>


