<?php
    header('Content-Type: text/html; charset=UTF-8');

    require_once(dirname(__FILE__) . '/config.php');
    require_once(dirname(__FILE__) . '/functions.php');

    class AllStaffInfo{
        private $_db;

        public function __construct(){
            try {
              $this->_db = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
              $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $this->_db->query("SET NAMES utf8");
            } catch (PDOException $e) {
              echo $e->getMessage();
              exit;
            }
        }

        //3つのテーブルを結合し、totalcostとstaff_infoを抽出
        public function AllStaffCost() {
            $stmt = $this->_db->query("
            SELECT staffs.id, staff_name, COUNT(request_details.cost), SUM(request_details.cost), staffs.season_ticket_cost
            FROM staffs
            INNER JOIN requests
            ON staffs.id = requests.staff_id
            INNER JOIN request_details
            ON requests.id = request_details.id
            GROUP BY staffs.id
            ");

            //オブジェクトを配列に変換する。
            $all_staff_each_cost = json_decode(json_encode($stmt->fetchAll(PDO::FETCH_OBJ)), true);
            return $all_staff_each_cost;
        }

        //管理用ページの絞り込み用メソッド
        public function FilterMonth($month){

            $month = $_POST['month'];
            $month = str_replace("-", "", $month);

            $stmt = $this->_db->query("
            SELECT staffs.id, staff_name, COUNT(request_details.cost), SUM(request_details.cost), staffs.season_ticket_cost
            FROM staffs
            INNER JOIN requests
            ON staffs.id = requests.staff_id
            INNER JOIN request_details
            ON requests.id = request_details.id
            WHERE DATE_FORMAT(request_details.date, '%Y%m') = $month
            GROUP BY staffs.id
            ");

            $filter_each_cost = json_decode(json_encode($stmt->fetchAll(PDO::FETCH_OBJ)), true);
            return $filter_each_cost;

        }

    }


?>
