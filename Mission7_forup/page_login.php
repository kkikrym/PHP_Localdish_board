
<!DOCTYPE html>
<html lang = ja>

<html>
<head>
    <meta charset="utf-8" />
    <title>ログイン</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <style>
        .bluechar{
            color:blue;
        }
        .redchar{
            color:red;
        }
        .bigger{
            font-size:30px;
        }
        button {
            /* ブラウザ特有のスタイルを無効に */
            -moz-appearance: none;
            -webkit-appearance: none;
            appearance: none;

            /* 整える */
            margin: 1em 0; /* 前後の隙間 */
            padding: 0.6em 1em; /* 塗りの余白 */
            font-size: 1em; /* フォントサイズ */
            background-color: #1aa1ff; /* 背景色 */
            color: #FFF; /* テキストカラー */
            cursor: pointer; /* カーソルを指マークに */
            border-radius: 3px; /* 角の丸み */
            border: 0; /* 枠線を消す */
            transition: 0.3s; /* ホバーの変化を滑らかに */
        }
        /* ホバー時（カーソルをのせた時）の見た目 */
        button:hover {
        background-color: #064fda; /* 背景色 */
        }

        table {
            background-color: #eee;
        }
    </style>

</head>
<body>
  <div class="header">
    <div class="header-left">郷土料理紀行</div>
    <div class="header-right">
        <ul>
          <li><a href="Mission7_forup/question_page.php" class="selected">お問い合わせ</a></li>
        </ul>
        </div>
      </div>

      <div class="container">
        <div class="btn-wrapper">
    </div>
  </div>
<?php
    session_start();
    if (!empty($SESSION['MAIL'])) {
        header("Location: page_newpost.php");
        exit;
    }
?>
<div class="main">
<div class="contact-form">
<a href="Mission7_forup/localdishes.php">掲示板に戻る<a>

 <div class="form-title">ログイン</div>


※未登録の方は<a href="Mission7_forup/page_newuser.php">こちら</a>から新規登録をお願いします。<hr>

<form action="" method="post">
    <div class="form-item">メールアドレス：</div>
        <input type="text" name="mail"><br>
    <div class="form-item">パスワード：</div>
        <input type="password" name="pass"><br>
    <input type="submit" name="submit" value="ログイン">
</form>
<hr>
<?php


$notfilled = false;
$n = false;
$notmail = false;

if (!empty($_POST["mail"]) or !empty($_POST["pass"])) {
    if ($_POST["mail"]!="" && $_POST["pass"]!=""){
        //POSTのvalidate
        if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            $notmail = true;
        }else{
            //DB内でPOSTされたメールアドレスを検索
                $dsn = '';
                $user = '';
                $password = '';
                $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
                $stmt = $pdo->prepare('select * from localdish_users where mail = ?');
                $stmt->execute([$_POST['mail']]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //emailがDB内に存在しているか確認
            if (!isset($row['mail'])) {
                $n =true;
            }
            //パスワード確認後sessionにメールアドレスを渡す
            if ($_POST['pass'] === $row['password']) {
                session_regenerate_id(true); //session_idを新しく生成し、置き換える
                $_SESSION['MAIL'] = $row['mail'];
                $_SESSION['NAME'] = $row['username'];
                echo '<div class="bluechar bigger">ログインしました<br>';
                echo $row["username"].'　さん、ようこそ！</div><hr>';
                echo '<a href="Mission7_forup/page_newpost.php">このまま投稿する<a><br>';
            } else {
                $n =true;
            }
        }
    }else{
        $notfilled=true;
    }
}

if($notfilled){
    echo '<div class="redchar bigger">　　！全ての欄を埋めて下さい。！</div><hr>';
}
if($n){
    echo '<div class="redchar bigger">　　！メールアドレス又はパスワードが間違っています。！</div><hr>';
}
if($notmail){
    echo '<div class="redchar bigger">　　！入力されたメールアドレスが不正です。！</div><hr>';
}

?>
</div>
</div>
<div class="footer">
    <div class="footer-left">
      <ul>
        <li><a href="Mission7_forup/admin_login.php">管理者ページ</a></li>
        <li><a href="Mission7_forup/localdishes.php" class="login">掲示板に戻る</a></li>
      </ul>
    </div>
  </div>
</body>
</html>