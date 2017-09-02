<?php
 require_once(__DIR__ . '/config.php');
 require_once(__DIR__ . '/functions.php');
 require_once(__DIR__ . '/Staff.php');


 //get staffs
 $staffApp = new \TransApp\Staff();
 $staffs = $staffApp->getAll();
 //get id
 //$id = $staffApp->getID(2);
 //echo $id->id;

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
        <?php echo $staff->id . " " . $staff->staff_name; ?> </option>
    <?php endforeach; ?>
    </select>
    <div><input type="submit" value="Enter" class="btn btn-default" id="enter_button"></div>
  </form>
 </div>
 <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
 <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
 <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 </body>
 </html>
