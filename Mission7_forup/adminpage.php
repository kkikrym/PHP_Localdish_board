
<!DOCTYPE html>
<html lang = ja>

<html>
<head>
    <meta charset="utf-8" />
    <title>管理者ページ</title>
    <link rel="stylesheet" type="text/css" href="localdish.css">
    <style>
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
    <div class="bigger" style=color:blue;>管理者ページ</div><br>
    <a href="https://tech-base.net/tb-230215/Mission7/localdishes.php">掲示板に戻る<a><hr>
    <form method="post" action="">
        <button type=submit name="ulist" value="ユーザーリスト">ユーザーリスト</button>
        <button type=submit name="posts" value="投稿一覧">投稿一覧</button>
    </form>

<?php
    //接続

    $dsn = 'mysql:dbname=tb230215db;host=localhost';
    $user = 'tb-230215';
    $password = '2cQzsYn8c4';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    $data = "CREATE TABLE IF NOT EXISTS testbd"
    ." ("
    ."commentnum TEXT,"
    ."username TEXT,"
    ."comment TEXT,"
    ."date TEXT,"
    ."password TEXT"
    .");";
    $create = $pdo->query($data);

    /*
    $sql = 'SHOW CREATE TABLE testbd';
    $result = $pdo -> query($sql);
    foreach ($result as $row){
        echo $row[1];
        echo '<br>';
    }
    */
?>


<?php

//ユーザー一覧のボタンが押された時にユーザー、パスワードを表示

if(isset($_POST['ulist'])){
    echo '<table border="1" cellspacing="">
    <caption>ユーザー一覧</caption>
    <thead>
        <tr>
            <th>名前</th><th>メールアドレス</th><th>ユーザーネーム</th><th>パスワード</th><th>投稿数</th><th>投稿一覧</th>
        </tr>
    </thead>
    <tbody>';

    $stmt = $pdo -> prepare('SELECT * FROM localdish_users');
    $stmt ->execute();
    $uinfo = $stmt->fetchall(PDO::FETCH_ASSOC);
    foreach ($uinfo as $user) {
        echo "<tr>";
        echo "<td>".$user["userid"]."</td>";
        echo "<td>".$user["mail"]."</td>";
        echo "<td>".$user["username"]."</td>";
        echo "<td>".$user["password"]."</td>";
        echo "</tr>";
    }
    echo '</tbody>
    </table>';
}

//投稿一覧のボタンが押された時に掲示板の内容を表示

if (isset($_POST['posts'])) {
    $sql = 'SELECT * FROM localdish';
    $stmt = $pdo -> query($sql);
    $result = $stmt->fetchAll();

    foreach ($result as $row){
        $stmt = $pdo -> prepare('SELECT * FROM localdish_users WHERE mail=?');
        $stmt ->execute([$row['mail']]);
        $uinfo = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row["commentnum"].". ";
        echo $uinfo['username']." from: ";
        echo $row["prefecture"].' ('.$row["date"].")<br> ";
        echo "料理：".$row["dishname"].'<br>';
        echo $row["comment"]."<br>";
        echo '<img src="'.$row["image"].'" alt="'.$row["dishname"].'" width="193", height="130"';
        echo '" ><hr>';
    }
}
?>

</body>
</html>