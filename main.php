<?php
//
 require_once(__DIR__ . '/config.php');
 require_once(__DIR__ . '/functions.php');
 require_once(__DIR__ . '/Staff.php');
 require_once(__DIR__ . '/request.php');
 require_once(__DIR__ . '/details.php');

  //Staff.php
  $staffApp = new \TransApp\Staff();
  $staffs = $staffApp->getAll();
  $id = $staffApp->getID($_POST["staff_id"]); //前ページからのid取得

  //request.php
  //idの注文一覧を取得
  $reqApp = new \reqApp\Request();
  $requests =  $reqApp->getAll();
  //var_dump($requests);
  $selected_staff = $reqApp->getStaffID($id->id);
  $selected_staff_id = $selected_staff[0]->staff_id; //選択したスタッフのID

  //details.php
  $detailApp = new \detailApp\Detail();
  $details = $detailApp->getAll();

  //合計金額を持ってくる
  $total_cost = $detailApp->getTotalCost($selected_staff);
  $total_cost = json_decode(json_encode($total_cost), true);

  //表の要素
  $table_element = $detailApp->getRequestID($selected_staff);

  //フィルター用のidを保持
  $filter_req_id = $detailApp->getFilterID($selected_staff);

 ?>

 <!DOCTYPE html>
 <html>
 <meta charset="utf-8">
 </html>
    <head>
      <link rel="stylesheet" type="text/css" href="css/main.css">
      <title>交通費申請システム</title>
    </head>
    <body>
      <div id="container2">
        <h1>交通費精算表</h1>
            <table border="1">
                    <tr>
                      <th>No. <?php echo $id->id ?></th>
                      <th>氏名</th>
                      <th><?php echo $id->staff_name; ?></th>
                    </tr>
            </table>
            <table border="1">
                <tr>
                    <th>合計金額</th>
                    <th id="total_cost"><?php echo $total_cost["sum(cost)"]; ?></th>
                </tr>
            </table>
                <div>
                    <form>
                        <input id="filter_req_id" type="hidden" value="<?php echo $filter_req_id; ?>">
                        <input type="month" id="month_filter">
                        <input type="button" value="絞り込む" id="filter_button">
                    </form>
                </div>
            <span>
                <input type = "button" value="追加" id="show_button">
                <input type = "button" value="削除" id="delete_button">
            </span>
            <!--ここから非表示-->
            <div id="delete_form">
                <p>
                    <form method="post" id="delete_data" action="POST">
                        <input type="text" id="delete_id" placeholder="削除したい申請IDを入力">
                        <input type="button" value="確定" id="delete_ajax_button">
                        <input type="button" value="取消" id="delete_ajax_cancel">
                    </form>
                </p>
            </div>
        <div id="input_form">
            <form method="post" id="send_data" action="POST">
                <input id="staff_id_hidden" type="hidden" value="<?php echo $selected_staff_id; ?>" name="staff_id_hidden">
                <p>日付: <input type="date" name="new_date" id="new_date"></p>
                <p>クライアント名: <input type="text" name="new_client" id="new_client"></p>
                <p>交通機関:
                    <input type="radio" name="new_vehicle" id="new_vehicle" value="1"/>電車
                    <input type="radio" name="new_vehicle" id="new_vehicle" value="2"/>バス
                    <input type="radio" name="new_vehicle" id="new_vehicle" value="3"/>飛行機
                    <input type="radio" name="new_vehicle" id="new_vehicle" value="4"/>その他
                </p>
                <p>利用区間: <input type="text" name="new_from" id="new_from"> から <input type="text" name="new_to" id="new_to"> まで</p>
                <p>料金: <input type="text" name="new_cost"id="new_cost"></p>
                <p><textarea name="new_overview" rows="4" cols="40" id="new_overview" placeholder="特記事項"></textarea></p>
            <div>
                <input type = "button" value="確定" id="ajax_button">
            </form>
                <input type = "button" value="取消" id="hide_button">
            </div>
        </div>
            <!--ここまで非表示-->
        <div id="result"></div>
            <table border="1" class="data_table">
                <tr id="add_row">
                  <th>申請ID</th>
                  <th>日付</th>
                  <th>クライアント名</th>
                  <th>交通機関</th>
                  <th colspan="2">利用区間</th>
                  <th>料金</th>
                  <th>特記事項</th>
                </tr>
                <!-- 申請数(request_id)のぶん、行として表示 -->
                    <?php foreach ($table_element as $element) : ?>
                        <tr class="hide">
                          <th><?php echo $element->id; ?></th>
                          <th><?php echo $element->date; ?></th>
                          <th><?php echo $element->client; ?></th>
                          <th><?php echo $element->vehicle_id; ?></th>
                          <th><?php echo $element->_from; ?></th>
                          <th><?php echo $element->_to; ?></th>
                          <th><?php echo $element->cost; ?></th>
                          <th><?php echo $element->overview; ?></th>
                        </tr>
                    <?php endforeach; ?>
            </table>
      </div>
      <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="js/main.js"></script>
    </body>

 </html>
