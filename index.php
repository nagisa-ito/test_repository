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
 </head>
 <body>
 <div id="container">
    <h1>交通費申請システム</h1>
    <p>名前を選んでください:</p>
    <form method="post" action="main.php">
    <select name="staff_id" size="1">
      <?php foreach ($staffs as $staff) : ?>
      <option value="<?php echo $staff->id;?>">
        <?php echo $staff->id . " " . $staff->staff_name; ?> </option>
    <?php endforeach; ?>
    </select>
    <div><input type="submit" value="Enter"></div>
  </form>
 </div>
 </body>
 </html>
