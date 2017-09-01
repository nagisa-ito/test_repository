<?php

    require_once(__DIR__ . '/config.php');
    require_once(__DIR__ . '/functions.php');

    header("Content-type: text/plain; charset=UTF-8");

    try {
      $state = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
      $state->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
      echo $e->getMessage();
      exit;
    }

    if(isset($_POST['filtering_id']) || isset($_POST['month'])){

        $filtering_id = $_POST['filtering_id'];
        $month = $_POST['month'];
        $month = str_replace("-", "", $month);

        $stmt = $state->prepare("select * from request_details
                                     where date_format(date, '%Y%m') = :date
                                     and id in ($filtering_id)");
        $stmt->bindValue(':date', $month, PDO::PARAM_STR);
        $stmt->execute();

        $filtering_data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        $json_data = json_encode($filtering_data,JSON_UNESCAPED_UNICODE);

        echo $json_data;
    }else{
        echo 'The parameter is not found.';
    }
