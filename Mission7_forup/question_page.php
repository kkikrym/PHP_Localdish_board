<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>郷土料理紀行</title>
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
  <div class="header">
    <div class="header-left">郷土料理紀行</div>
    <div class="header-right">
      <ul>
          <li><a href="form.php" class="selected">お問い合わせ</a></li>
      </ul>
    </div>
  </div>

  <div class="main">
    <div class="contact-form">
      <div class="form-title">お問い合わせ</div>
      <form method="post" action="sent.php">
        <div class="form-item">名前</div>
        <input type="text" name="name">

        <div class="form-item">年齢</div>
        <select name="age">
          <option value="未選択">選択してください</option>
          <!-- for文を用いて6歳から100歳までをoptionで選べるようにしましょう -->
          <?php 
            for ($i = 6; $i <= 100; $i++) {
              echo "<option value='{$i}'>{$i}</option>";
            }
          ?>
        </select>

        <div class="form-item">お問い合わせの種類</div>
        <?php 
          $types = array('新規投稿に関するお問い合わせ', '投稿フォームに関するお問い合わせ', '管理者ページに関するお問い合わせ', "ログインに関するお問い合わせ", '新規登録に関するお問い合わせ', 'その他');
         ?>
        <!-- この下にselectタグを書いていきましょう -->
        <select name="category">
          <option value="未選択">選択してください</option>
            <?php 
              foreach ($types as $type) {
                echo "<option value='{$type}'>{$type}</option>";
              }
            ?>
        </select>
        
        <div class="form-item">内容</div>
        <textarea name="body"></textarea>

        <input type="submit" value="送信">
      </form>
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