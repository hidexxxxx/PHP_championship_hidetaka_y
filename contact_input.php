<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="contact_input.css">
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
            <form action="contact_create.php" method="POST">
                <p><a href="contact_read.php" class="to-contact-read-link">▶︎過去の問い合わせ内容確認</a></p>      
                <fieldset>
                    <legend>お問い合わせフォーム</legend>          
                    <div>
                        <input type="text" class="name" placeholder="氏名を記入してください" name="name">
                    </div>
                    <div>
                        <input type="email" class="email" placeholder="メールアドレスを記入してください" name="email">
                    </div>
                    <div>
                        <textarea rows="8" class="contents" placeholder="お問い合わせ内容を記入してください" name="contents"></textarea>
                    </div>
                    <div class="send-button-box">
                        <button class="send-button">送信</button>
                    </div>
                </fieldset>
            </form>
        </main>

        <!-- グローバルナビゲーションでメニューバー表示 -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="header-grobalNavi-move.js"></script>

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
        <h5 class="copy-rights">©️2023 Cloud Garage Co,.Ltd. All Rights Reserved</h5>
    </footer>
    
</html>