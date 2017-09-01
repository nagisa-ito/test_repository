<?php
  namespace detailApp;
  class Detail {
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
    $stmt = $this->_db->query("select * from request_details order by id");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }
  public function getRequestID($selected_staff) {
    //オブジェクトを配列に変換する。
    $to_array_staff = json_decode(json_encode($selected_staff), true);
    //カラムがidの値を配列で取得
    $staff_id = array_column($to_array_staff, 'id');
    //配列の中身を文字列で格納し、コンマで区切る
    $str=implode(",", $staff_id);
    $stmt = $this->_db->query("select *
                              from vehicles
                              inner join request_details
                              on vehicles.id = request_details.vehicle_id
                              where request_details.id
                              in ($str);");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }
  public function getTotalCost($selected_staff){
      $to_array_staff = json_decode(json_encode($selected_staff), true);
      $staff_id = array_column($to_array_staff, 'id');
      $str=implode(",", $staff_id);
      $stmt = $this->_db->query("select sum(cost) from request_details where id in ($str)");
      return $stmt->fetch(\PDO::FETCH_OBJ);
  }

  public function getFilterID($selected_staff){
      $to_array_staff = json_decode(json_encode($selected_staff), true);
      $staff_id = array_column($to_array_staff, 'id');
      $str=implode(",", $staff_id);
      return $str;
  }

}
