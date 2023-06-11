<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="login-resister.css">
  <title>Resister</title>
</head>

<body>
  <header id="header">
        <div class="logo-box">
            <a href="login.php"><img class="brand-logo" src="img/logo/brand-logo.png" alt="logo"></a>
        </div>
  </header>

  <form action="login_resister_act.php" method="POST">

      <legend>Resister</legend>
      <div>
        <input type="text" name="username" class="username" placeholder="* Username">
      </div>
      <div>
        <input type="text" name="password" class="password" placeholder="* Password">
      </div>
      <div class="control-button">
        <div>
          <button class="resister-button">Register</button>
        </div>
        <a href="login.php" class="to-login">▶︎ Login</a>
      </div>
  </form>

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