<!DOCTYPE html>
<html lang = ja>

<html>
<head>
    <meta charset="utf-8" />
    <title>郷土料理紀行</title>
    <link rel="stylesheet" type="text/css" href="localdish.css">
    <link rel="stylesheet" type="text/css" href="iine.css">
    <style>
    </style>
</head>

<body>
    <div class="header">
    <div class="header-left">
        郷土料理紀行
    </div>
    <div class="header-center">
    〜家で退屈しているあなたに、料理を通じて旅行気分〜
    </div>
    <div class="header-migi">
      <a href="Mission7_forup/page_login.php" class="selected">新規投稿</a>
      <a href="Mission7_forup/admin_login.php" class="selected">管理者ページ</a>
    </div>


    </div>

<div class="main contact-form">
    <form method=post action="">
        都道府県ごとに表示：<select name="prefecture" value="都道府県を選択">
        <?php
            $prefectures = array('','北海道','青森県','岩手県','宮城県','秋田県','山形県','福島県','茨城県','栃木県','群馬県','埼玉県','千葉県','東京都','神奈川県','新潟県','富山県','石川県','福井県','山梨県','長野県','岐阜県','静岡県','愛知県','三重県','滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県','鳥取県','島根県','岡山県','広島県','山口県','徳島県','香川県','愛媛県','高知県','福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県','沖縄県');
            foreach($prefectures as $prefecture){
                echo '<option value="'.$prefecture.'">'.$prefecture.'</option>';
            }
        ?>
        </select>
        <input type="submit" name="submit" value="送信">
    </form>


<?php
    session_start();
    session_regenerate_id(true);
    //DB接続
    $dsn = '';
    $user = '';
    $password = '';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    //投稿をしまうdb
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

    //返信をしまうdb
    $data = "CREATE TABLE IF NOT EXISTS localdish_replies"
    ." ("
    ."postnum INT,"
    ."replynum INT,"
    ."reply TEXT"
    .");";
    $create = $pdo->query($data);//投稿番号と返信番号を入れる

    $data = "CREATE TABLE IF NOT EXISTS localdish_iine"
    ." ("
    ."postnum INT,"
    ."goodcount INT"
    .");";
    $create = $pdo->query($data);

    //ソート欄の県が選択されていればその県だけdbから抜き出す、空であれば全て抜き出す
    if (!empty($_POST['prefecture'])) {
        $stmt = $pdo -> prepare('SELECT * FROM localdish WHERE prefecture=?');
        $stmt -> execute([$_POST['prefecture']]);
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
    }else{
        $sql = 'SELECT * FROM localdish';
        $stmt = $pdo -> query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    //$resultに格納された投稿を一つずつ表示した後に返信ボタン、返信一覧をくっつける
    foreach ($result as $row) {
        echo '<div class="layer">';//投稿の一番上〜返信欄を一つのbox要素に詰める、背景グレー
        echo '<hr>';

        //emailでユーザーを選別、そのユーザーの情報をusersのdbから持ってくる
        $stmt = $pdo -> prepare('SELECT * FROM localdish_users WHERE mail=?');
        $stmt ->execute([$row['mail']]);
        $uinfo = $stmt->fetch(PDO::FETCH_ASSOC);

        //投稿内容表示
        echo '<div class="layer-comment">';
        echo $row["commentnum"].". ";
        echo $uinfo["username"]."　from";
        echo $row["prefecture"].' ('.$row["date"].")";
        echo "料理：".$row["dishname"].'<br>';
        echo $row["comment"]."<br></div>";//コメント欄は画像のすぐ右横で改行
        echo '<div class="layer-in"><img src="'.$row["image"].'" alt="'.$row["dishname"].'" width="205", height="145"';
        echo '" ></div>';//layer-inのCSSで画像だけlayerの一番右上に表示

        //返信ボタン
        $postname = "reply_".$row["commentnum"];
        echo '<div class="layer-bottom">';//返信ボタンと投稿ボタンはlayerの底にくっつける
        echo '
        <form method="post" action="" style="display: inline">
            <input type="text" name="'.$postname.'" plcaceholder="reply">
            <input type="submit" name="submit" value="返信">
        </form>';



            //いいねボタン
            //dbに投稿番号がない場合投稿番号＝０いいねのレコードを作る
            $stmt = $pdo -> prepare('SELECT * FROM localdish_iine WHERE postnum=?');
            $stmt ->execute([$row["commentnum"]]);
            $iine = $stmt->fetch(PDO::FETCH_ASSOC);
            if(empty($iine)){
                $pdo -> query('INSERT INTO localdish_iine (postnum, goodcount) VALUES ('.$row["commentnum"].', 0);');
            }
            $stmt = $pdo -> prepare('SELECT * FROM localdish_iine WHERE postnum=?');
            $stmt ->execute([$row["commentnum"]]);
            $iine = $stmt->fetch(PDO::FETCH_ASSOC);
            //いいねボタンといいね数の表示
            $postnum="iine_".$row["commentnum"];//投稿番号ごとにいいねボタンのnameを変える
            echo '
            <form method=post style="display: inline">
                <button type="submit" id="iine" name='.$postnum.'>
                    <div class="iine_wrap">
                        <div class="material-icons heart">❤️️</div>
                    </div>
                </button>
            </form>';

            $goodcount = $iine["goodcount"];
            if(isset($_POST[$postnum])){//いいねボタンが押された時にdbのgoodcountに+1
                $goodcount = $goodcount+1;
                $stmt = $pdo -> prepare('UPDATE localdish_iine SET goodcount=:goodcount WHERE postnum=:postnum');
                $stmt -> bindParam(':goodcount',$goodcount , PDO::PARAM_INT);
                $stmt -> bindParam(':postnum',$row["commentnum"] , PDO::PARAM_INT);
                $stmt ->execute();
            }
            echo $goodcount.' Likes!<br></div>';//いいね数表示


        //返信ボタンが押された時は内容をlocaldish-repliesのdbに書き込み
        if (!empty($_POST[$postname])) {
            $select = 'SELECT * FROM localdish_replies WHERE postnum='.(int)$row['commentnum'].";";
            $stmt = $pdo -> query($select);
            $replies = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $sql = $pdo -> prepare("INSERT INTO localdish_replies (postnum, replynum, reply) VALUES (:postnum, :replynum, :reply)");
            $sql -> bindParam(':postnum', $pnum, PDO::PARAM_INT);
            $sql -> bindParam(':replynum', $rnum, PDO::PARAM_INT);
            $sql -> bindParam(':reply', $reply, PDO::PARAM_STR);
            $rnum = count($replies)+1;
            $pnum = (int)$row['commentnum'];
            $reply = $_POST[$postname];
            $sql -> execute();
        }
        //返信内容表示、<details>タグで返信を折りたたむ
        $sql = 'SELECT * FROM localdish_replies WHERE postnum='.$row['commentnum'].";";
        $stmt = $pdo -> query($sql);
        $replies = $stmt->fetchAll();
        //直前で<div class="layer">を閉じて長さを柔軟に変えられるようにする
        echo '</div><details><summary>返信を表示</summary>';
        foreach ($replies as $item) {
            echo $item["replynum"].': ';
            echo $item["reply"]."<br>";
        }
        echo '</details><hr>';
    }

?>
</div>
</body>
</html>