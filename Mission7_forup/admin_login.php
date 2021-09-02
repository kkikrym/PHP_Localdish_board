
<!DOCTYPE html>
<html lang = ja>

<html>
<head>
    <meta charset="utf-8" />
    <title>ログイン</title>
    <link rel="stylesheet" type="text/css" href="localdish.css">
    <style>
    </style>

</head>
<body>
    <div class="bigger" style=color:blue;>管理者ページ ログイン</div><br>
    <a href="Mission7_forup/localdishes.php">掲示板に戻る<a><hr>
    <form action="" method="post">
    メールアドレス：<input type="text" name="mail"><br>
    パスワード：<input type="password" name="pass"><br>
    <input type="submit" name="submit" value="ログイン">
</form>
<hr>
<?php
    $adminmail = "";
    $adminpass =  "";

    if (!empty($_POST["mail"]) or !empty($_POST["pass"])) {
        if ($_POST["mail"] == $adminmail && $_POST["pass"] == $adminpass) {
            echo '<div class="" style=color:blue;>ログインに成功</div><br>';
            echo '<a href="Mission7_forup/adminpage.php">管理者ページへ<a><br>';
        } else{
            echo '<div class="redchar bigger">　　！メールアドレス又はパスワードが間違っています。！</div><hr>';
        }
    }
?>


</body>
</html>