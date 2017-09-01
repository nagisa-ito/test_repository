<?php

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/functions.php');

header("Content-type: text/plain; charset=UTF-8");
if (isset($_POST['date'])){
        //ここに何かしらの処理を書く（DB登録やファイルへの書き込みなど）
            //DBへの接続

            try {
              $state = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
              $state -> setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
              echo $e->getMessage();
              exit;
            }

            print_r($_POST);

            $sql = $state->prepare("insert into request_details (
                                    date,
                                    client,
                                    vehicle_id,
                                    _from,
                                    _to,
                                    cost,
                                    overview
                                    )
                                    values(
                                    :date,
                                    :client,
                                    :vehicle,
                                    :_from,
                                    :_to,
                                    :cost,
                                    :overview
                                    )");

                $new_date = $_POST['date'];
                $new_client = $_POST['client'];
                $new_vehicle_id = $_POST['vehicle'];
                $new_from = $_POST['_from'];
                $new_to = $_POST['_to'];
                $new_cost = $_POST['cost'];
                $new_overview = $_POST['overview'];
                //echo $new_to;
                $sql->bindValue(':date', $new_date, PDO::PARAM_STR);
                $sql->bindValue(':client', $new_client, PDO::PARAM_STR);
                $sql->bindValue(':vehicle', $new_vehicle_id, PDO::PARAM_STR);
                $sql->bindValue(':_from', $new_from, PDO::PARAM_STR);
                $sql->bindValue(':_to', $new_to, PDO::PARAM_STR);
                $sql->bindValue(':cost', $new_cost, PDO::PARAM_STR);
                $sql->bindValue(':overview', $new_overview, PDO::PARAM_STR);

                if(!$sql->execute()){
                    echo "だめです。";
                }
                $sql = null;

                //リクエストテーブルへの追加
                $add_request = $state->prepare("insert into requests (staff_id) values (:staff_id)");
                $staff_id = $_POST['staff_id'];
                $add_request -> bindValue(':staff_id', $staff_id);

                if(!$add_request->execute()){
                    echo "requestテーブルへの追加が失敗しました。";
                }
                $add_request = null;

        //echoが返り値？？？？
        echo "登録が完了しました。";
}
else
{
echo 'The parameter is not found.';
}
?>
