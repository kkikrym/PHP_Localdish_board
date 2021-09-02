<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>新規投稿</title>
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
<!--編集用フォームが記入済みであればその番号の投稿を表示 -->

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
        .graybg{
            background-color:#eee;
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
    <div class="top-wrapper">
        <div class="container">
        <div class="btn-wrapper">
    </div>
  </div>

 <div class="main">
    <div class="contact-form">
    <?php echo '<a href="Mission7_forup/localdishes.php">掲示板に戻る<a>'; ?>
    <?php
    session_start();
    $id = $_SESSION['MAIL'];
    $name = $_SESSION['NAME'];
    session_regenerate_id(true);
    $_SESSION['MAIL'] = $id;
    $_SESSION['NAME'] = $name;

    echo '<div class="">ユーザー名： '.$name.' さん</div>';
?>
<div class="form-title">新規投稿</div>
<form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="edi_num" value="<?php if($whether_edit){
        echo $_POST['ediform'];
        } ?>">
        <div class="form-item">料理名</div>
        <input type="text" name="dishname" value="<?php if($whether_edit){
        foreach($result as $row){
            if($_POST["ediform"] == $row['commentnum']){
                echo $row['username'];
            }
        }
    } ?>">

        <div class="form-item">都道府県</div>
        <select name="prefecture">
          <option value="未選択">選択してください</option>
            <?php
            $prefectures = array('北海道','青森県','岩手県','宮城県','秋田県','山形県','福島県','茨城県','栃木県','群馬県','埼玉県','千葉県','東京都','神奈川県','新潟県','富山県','石川県','福井県','山梨県','長野県','岐阜県','静岡県','愛知県','三重県','滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県','鳥取県','島根県','岡山県','広島県','山口県','徳島県','香川県','愛媛県','高知県','福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県','沖縄県');
            foreach ($prefectures as $prefecture) {
            echo "<option value='{$prefecture}'>{$prefecture}</option>";
            }
            ?>
        </select>
        
        <div class="form-item">画像のアップロード</div>
        <input type="file" name="image">
        
        <div class="form-item">内容</div>
        <textarea name="comment" value="<?php if($whether_edit){
        foreach($result as $row){
            if($_POST["ediform"] == $row['commentnum']){
                echo $row['comment'];
            }
        }
    } ?>"  cols="190" raws="5" ></textarea>

        <input type="submit" value="投稿">
        
      </form>


<?php
    $dsn = '';
    $user = '';
    $password = '';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    $whether_edit = false;
    $wrongpass = false;
    $notfilled = false;
    $notimage = false;

    if (!empty($_POST["comment"]) or !empty($_POST["image"])or !empty($_POST["prefecture"]) or !empty($_POST["dishname"])){
        
        if ($_POST["comment"] == ""){
            $notfilled = true;
        }
        if ($_POST["dishname"] == ""){
            $notfilled = true;
        }
        if (!is_uploaded_file($_FILES["image"]["tmp_name"])){
            $notfilled = true;
        }
        if ($_POST["prefecture"] == ""){
            $notfilled = true;
        }
        if (!$notfilled){
            if(!exif_imagetype($_FILES['image']['tmp_name'])){
                $notimage =true;
            }
            if (!$notimage) {
                if ($_POST["edi_num"]) {
                    /*
                    $sql = $pdo -> prepare('UPDATE testbd SET username=:username,comment=:comment,date=:date,password=:password WHERE commentnum=:this');
                    $sql -> bindParam(':username', $username, PDO::PARAM_STR);
                    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
                    $sql -> bindParam(':password', $password, PDO::PARAM_STR);
                    $sql -> bindParam(':this', $edi_num, PDO::PARAM_STR);

                    $username = $_POST["name"];
                    $comment = $_POST["comment"];
                    $password = $_POST["password"];
                    $date = date("Y/m/d H:i:s");
                    $edi_num = $_POST["edi_num"];
                    $sql -> execute();
                    */
                } else {
                    $image = uniqid(mt_rand(), true);//ファイル名をユニーク化
                    $image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);//アップロードされたファイルの拡張子を取得
                    $file = "images/$image";
                    move_uploaded_file($_FILES['image']['tmp_name'], './images/'.$image);

                    $sql = $pdo -> prepare("INSERT INTO localdish (commentnum, mail, date, dishname, comment, prefecture, image)
                    VALUES (NULL, :mail, :date, :dishname, :comment, :prefecture, :image)");

                    $sql -> bindParam(':mail', $mail, PDO::PARAM_STR);
                    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
                    $sql -> bindParam(':dishname', $dishname, PDO::PARAM_STR);
                    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                    $sql -> bindParam(':prefecture', $prefecture, PDO::PARAM_STR);
                    $sql -> bindParam(':image', $path, PDO::PARAM_STR);

                    $mail = $_SESSION["MAIL"];
                    $date = date("Y/m/d H:i:s");
                    $dishname = $_POST["dishname"];
                    $comment = $_POST["comment"];
                    $prefecture = $_POST["prefecture"];
                    $path = $file;
                    $sql -> execute();
                    echo '<div class="bigger" style=color:blue;>　投稿完了</div>';
                }
            }
        }
    }

    if($notfilled){
    echo '<div class="redchar bigger">　　！全ての欄を埋めて下さい。！</div><hr>';
    }
    if($notimage){
    echo '<div class="redchar bigger">　　！画像ファイルをアップロードして下さい。！</div><hr>';
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