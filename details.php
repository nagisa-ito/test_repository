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
    //var_dump($to_array_staff);

    //カラムがidの値を配列で取得
    $staff_id = array_column($to_array_staff, 'id');
    //print_r($staff_id);

    //配列の中身を文字列で格納し、コンマで区切る
    $str=implode(",", $staff_id);

    $stmt = $this->_db->query("select *
                              from request_details
                              where request_id
                              in ($str);");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

}
