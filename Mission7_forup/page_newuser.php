<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>新規登録</title>
    
    <link rel="stylesheet" href="Mission7_forup/register.css">
  </head>
  <body>
    <header>
      <div class="container">
        <div class="header-left">
        </div>
        <div class="header-right">
        </div>
      </div>
    </header>
    <div class="top-wrapper">
      <div class="container">
        <h1>〜郷土料理紀行〜</h1>
        <h3>〜家で退屈しているあなたに、料理を通じて旅行気分〜</h3>
        <p></p>
        <p></p>
        <div class="btn-wrapper">
        <form action="" method="post">
          <input type="text" name="name" placeholder="username">
          <input type="text" name="mail" placeholder="mail-address"><br>
          <input type="password" name="pass" placeholder="password">
          <input type="password" name="pass_re" placeholder="re-password"><br>
          <input type="submit" name="submit" value="登録"><br>
          <a href="Mission7_forup/page_login.php" class="re-form">ログインページへ</a><br>
          <a href="Mission7_forup/localdishes.php" class="re-form">掲示板に戻る<a>
        </form>
        </div>
      </div>
    </div>
    <?php
    $dsn = '';
    $user = '';
    $password = '';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    $notfilled = false;
    $n = false;
    $notmail = false;
    $under8 = false;

    if (!empty($_POST["name"]) or !empty($_POST["mail"]) or !empty($_POST["pass"])or !empty($_POST["pass_re"])){
        if ($_POST["name"]!="" && $_POST["mail"]!="" && $_POST["pass"]!="" && $_POST["pass_re"]!=""){
            if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                $notmail = true;
            }elseif($_POST["pass"] != $_POST["pass_re"]){
                $n = true;
            }elseif(preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['pass'])){
                $under8 = true;
            }
            else{
                try {
                    $stmt = $pdo -> prepare("INSERT INTO localdish_users (userid, mail, username, password) VALUES (NULL, :mail, :username, :password)");
                    $stmt ->bindParam(":mail", $mail, PDO::PARAM_STR);
                    $stmt ->bindParam(":username", $username, PDO::PARAM_STR);
                    $stmt ->bindParam(":password", $password, PDO::PARAM_STR);
                    $mail = $_POST['mail'];
                    $username = $_POST['name'];
                    $password = $_POST['pass'];
                    $stmt ->execute();
                    echo '<div class="bluechar bigger">　　登録完了</div><hr>';
                }catch(\Exception $e){
                    echo $e->getMessage() . PHP_EOL;
                }
            }
        }else{
            $notfilled =true;
        }
    }

    if($notfilled){
        echo '<div class="redchar bigger">　　！全ての欄を埋めて下さい。！</div><hr>';
    }
    if($n){
        echo '<div class="redchar bigger">　　！パスワードが一致しません。！</div><hr>';
    }
    if($notmail){
        echo '<div class="redchar bigger">　　！入力されたメールアドレスが不正です。！</div><hr>';
    }
    if($under8){
        echo '<div class="redchar bigger">　　！パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。！</div><hr>';
    }
?>
  </body>
</html>