<?php

namespace AddApp;

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

    public function getAll() {
      $stmt = $this->_db->query("select * from requests order by id");
      return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function AddData($date, $client, $vehicle_id, $from, $to, $cost, $overview){
        $stmt = $this->_db->prepare("insert into
                                    request_details (date, client, vehicle_id, from, to, cost, overview)
                                    values (:date, :client, :vehicle_id, :from, :to, :cost, :overview)");

        $stmt -> bindValue(":date", $date);
        $stmt -> bindValue(":client", $client);
        $stmt -> bindValue(":vehicle_id", $vehicle_id);
        $stmt -> bindValue(":from", $from);
        $stmt -> bindValue(":to", $to);
        $stmt -> bindValue(":cost", $cost);
        $stmt -> bindValue(":overview", $overview);

        $stmt->execute();
        return;
    }

}

    require_once(__DIR__ . '/config.php');
    require_once(__DIR__ . '/functions.php');



    $new_date = $_POST["new_date"]; //前ページからの取得
    $new_client = $_POST["new_client"];
    if($_POST["new_vehicle"]=="電車"){
        $new_vehicle_id = 1;
    } elseif($_POST["new_vehicle"]=="バス"){
        $new_vehicle_id = 2;
    } else{
        $new_vehicle_id = 3;
    }
    $new_from = $_POST["new_from"];
    $new_to = $_POST["new_to"];
    $new_cost = $_POST["new_cost"];
    $new_overview = $_POST["new_overview"];
    
    $addApp = new \addApp\Add();
    $addApp->AddData($new_date, $new_client, $new_vehicle_id, $new_from, $new_to, $new_cost, $new_overview);

 ?>

 <html>
<body>
<button>戻る</button>
</body>
 </html>
