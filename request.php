<?php

  namespace reqApp;

  class Request {
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

  public function getStaffID($num) {
    $stmt = $this->_db->query("select * from requests where staff_id = $num");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  /*public function getStaffID($staffnum) {
    $staff_id = $this->_db->query("select * from requests where staff_id = $staffnum");
    return $staff_id->fetch(\PDO::FETCH_OBJ);
  }*/

}
