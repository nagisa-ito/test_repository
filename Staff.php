<?php

  namespace TransApp;

  class Staff {
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
    $stmt = $this->_db->query("select * from staffs order by id");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function getID($num) {
    $id = $this->_db->query("select * from staffs where id = $num");
    return $id->fetch(\PDO::FETCH_OBJ);
  }


  }
