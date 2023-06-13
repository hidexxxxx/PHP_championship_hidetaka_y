<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="contact_input.css">
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

        <!-- プロフィールテキストの読み込み -->
        <script src="profile_textData_read.js" type="module"></script>

        <!-- プロフィール画像の読み込み -->
        <script src="profile_photoData_read.js" type="module"></script>
        
    </header>

  <form action="contact_create.php" method="POST">
  <p><a href="contact_read.php">▶︎過去の問い合わせ内容確認</a></p>      
  <fieldset>
            <legend>お問い合わせフォーム</legend>          
            <div>
                <label>氏名</label>
                <input type="text" placeholder="氏名を記入してください" name="name">
            </div>
            <div>
                <label>メールアドレス</label>
                <input type="email" placeholder="メールアドレスを記入してください" name="email">
            </div>
            <div>
                <label>お問い合わせ内容</label>
                <textarea rows="3" placeholder="お問い合わせ内容を記入してください" name="contents"></textarea>
            </div>
            
            <div>
                <button>Send</button>
            </div>
        </fieldset>
  </form>





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