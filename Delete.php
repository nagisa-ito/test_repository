<?php

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/functions.php');

header("Content-type: text/plain; charset=UTF-8");
    if (isset($_POST['delete_id'])){
        //ここに何かしらの処理を書く（DB登録やファイルへの書き込みなど）
            //DBへの接続

            try {
              $state = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
              $state -> setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
              echo $e->getMessage();
              exit;
            }

            $delete_id = $_POST['delete_id'];
            $staff_id = $_POST['staff_id'];

            $stmt = $state->query("select staff_id from requests where id = $delete_id");
            $judge_id = $stmt->fetch(\PDO::FETCH_OBJ);

            $judge = $judge_id->staff_id;

            if($judge != $staff_id){
                echo "申請IDが存在しません。";
                exit;
            }

            $del_sql = $state->prepare("delete from requests where id = :id");
            $del_sql->bindValue(':id', $delete_id, PDO::PARAM_STR);
            $del_sql->execute();

            $del_sql2 = $state->prepare("delete from request_details where id = :id");
            $del_sql2->bindValue(':id', $delete_id, PDO::PARAM_STR);
            $del_sql2->execute();

            echo "申請ID " . $delete_id . " を削除しました。";

    }else{
        echo 'The parameter is not found.';
    }

?>
