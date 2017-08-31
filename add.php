<?php

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/details.php');

class Add {
  private $_db;

  public function __construct() {
  try {
    $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
    $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  } catch (\PDOException $e) {
    echo $e->getMessage();
    exit;
  }
}

public function Add($date) {
    $sql = "insert into
            request_details date
            values :date";
    $stmt = $this->_db->prepare($sql);
    $stmt -> bindParam(':date', $date);
    $stmt -> execute();
    return;
}

}


header("Content-type: text/plain; charset=UTF-8");
if (isset($_POST['date']))
{
//ここに何かしらの処理を書く（DB登録やファイルへの書き込みなど）


echo "登録が完了しました。";
}
else
{
echo 'The parameter is not found.';
}
?>
