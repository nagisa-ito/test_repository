<?php
  //namespace detailApp;
  class Detail {
    private $_db;
    public function __construct() {
    try {
      $this->_db = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
      $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->_db->query("set names utf8");
    } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }
  public function getAll() {
    $stmt = $this->_db->query("select * from request_details order by id");
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }
  public function getRequestID($selected_staff) {
    //オブジェクトを配列に変換する。
    $to_array_staff = json_decode(json_encode($selected_staff), true);
    //カラムがidの値を配列で取得
    $staff_id = $this->array_column($to_array_staff, 'id');
    //配列の中身を文字列で格納し、コンマで区切る
    $str=implode(",", $staff_id);
    $stmt = $this->_db->query("select *
                              from vehicles
                              inner join request_details
                              on vehicles.id = request_details.vehicle_id
                              where request_details.id
                              in ($str)
                              order by request_details.id;");
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }
  public function getTotalCost($selected_staff){
      $to_array_staff = json_decode(json_encode($selected_staff), true);
      $staff_id = $this->array_column($to_array_staff, 'id');
      $str=implode(",", $staff_id);
      $stmt = $this->_db->query("select sum(cost) from request_details where id in ($str)");
      return $stmt->fetch(PDO::FETCH_OBJ);
  }

  public function getFilterID($selected_staff){
      $to_array_staff = json_decode(json_encode($selected_staff), true);
      $staff_id = $this->array_column($to_array_staff, 'id');
      $str=implode(",", $staff_id);
      return $str;
  }

  public function array_column ($target_data, $column_key, $index_key = null) {

    if (is_array($target_data) === FALSE || count($target_data) === 0) return FALSE;

    $result = array();
    foreach ($target_data as $array) {
        if (array_key_exists($column_key, $array) === FALSE) continue;
        if (is_null($index_key) === FALSE && array_key_exists($index_key, $array) === TRUE) {
            $result[$array[$index_key]] = $array[$column_key];
            continue;
        }
        $result[] = $array[$column_key];
    }

    if (count($result) === 0) return FALSE;
    return $result;

}


}
