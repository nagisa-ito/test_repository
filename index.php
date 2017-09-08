<?php
 require_once(dirname(__FILE__) . '/config.php');
 require_once(dirname(__FILE__) . '/functions.php');
 require_once(dirname(__FILE__) . '/Staff.php');


 //get staffs
 $staffApp = new Staff();
 $staffs = $staffApp->getAll();


 ?>

 <!DOCTYPE html>
 <html lang="ja">
 <head>
    <meta charset="utf-8">
    <title>交通費申請システム</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
 </head>
 <body>
 <div id="container" align="center">
    <h1 id="title_name">交通費申請システム</h1>
    <p>名前を選んでください:</p>
    <form method="post" action="main.php">
    <select name="staff_id" size="1">
      <?php foreach ($staffs as $staff) : ?>
      <option value="<?php echo $staff->id;?>">
        <?php echo h($staff->id) . " " . h($staff->staff_name); ?> </option>
    <?php endforeach; ?>
    </select>
    <div><input type="submit" value="ログイン" class="btn btn-primary" id="enter_button"></div>
  </form>
  <hr width="500">
  <form method="post" action="admin.php">
     <input type="submit" value="管理用" class="btn btn-default">
  </form>
  <form method="post" action="register.php">
     <input type="submit" value="登録" class="btn btn-default">
  </form>
 </div>
 <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
 <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
 <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 </body>
 </html>
