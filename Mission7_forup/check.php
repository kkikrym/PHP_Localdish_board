
<!DOCTYPE html>
<html lang = ja>

<html>
<head>
    <meta charset="utf-8" />
    <title></title>
    <style>
        .redchar{
            color:red;
        }
        .bigger{
            font-size:30px;
        }
    </style>
</head>
<body>
<?php
    //接続
    $dsn = '';
    $user = '';
    $password = '';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    //table作成


    //コメントアウト解除でdb上書き
    /*
    $sql = 'DROP TABLE localdish;';
    $pdo->query($sql);
    */

    $data = "CREATE TABLE IF NOT EXISTS localdish_users"
    ." ("
    ."userid int AUTO_INCREMENT PRIMARY KEY,"
    ."mail VARCHAR(255) NOT NULL,"
    ."username VARCHAR(255) NOT NULL,"
    ."password VARCHAR(255) NOT NULL"
    .");";
    $create = $pdo->query($data);

    $data = "CREATE TABLE IF NOT EXISTS localdish"
    ." ("
    ."commentnum INT AUTO_INCREMENT PRIMARY KEY,"
    ."userid VARCHAR(255) NOT NULL,"
    ."date VARCHAR(255) NOT NULL,"
    ."dishname VARCHAR(255) NOT NULL,"
    ."comment TEXT NOT NULL,"
    ."prefecture VARCHAR(255) NOT NULL,"
    ."image VARCHAR(255) NOT NULL"
    .");";
    $create = $pdo->query($data);

    $sql = 'SHOW TABLES;';
    $result = $pdo->query($sql);
    foreach ($result as $row){
        echo $row[0];
        echo '<br>';
    }
    

    /*
    $sql = 'SHOW CREATE TABLE testbd';
    $result = $pdo -> query($sql);
    foreach ($result as $row){
        echo $row[1];
        echo '<br>';
    }
    */

    /*
    $names = array();
    $users = array();
    foreach ($result as $row) {
        $user = array();
        if (!in_array($row["username"], $names)){
            $names[] = $row["username"];
            $user["name"] = $row["username"];
            $user["password"] = $row["password"];
            $user["commentnums"] = $row["commentnum"];
            $user["comment"] = $row["comment"];
        }else{

        }
    }

    */



?>
</body>
</html>