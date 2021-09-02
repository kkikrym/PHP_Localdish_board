<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Progate</title>
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
    <div class="thanks-message">お問い合わせいただきありがとうございます。</div>
    <div class="display-contact">
      <div class="form-title">入力内容</div>

      <div class="form-item">■ 名前</div>
      <?php echo $_POST['name']; ?>

      <div class="form-item">■ 年齢</div>
      <?php echo $_POST['age']; ?>

      <div class="form-item">■ お問い合わせの種類</div>
      <!-- この下でcategoryを受け取りechoしましょう -->
      <?php echo $_POST['category']; ?>

      <div class="form-item">■ 内容</div>
      <?php echo $_POST['body']; ?>
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