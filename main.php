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
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="css/main.css">
      <title>交通費申請システム</title>
    </head>
    <body>
      <div class="container">
        <h1>交通費精算表</h1>
        <div id="check_" class="col-sm-2">
        <table class="table table-bordered .col-md-3" id="total_cost_table">
            <tr class="active">
                <th class="col-md-2">合計金額</th>
            </tr>
            <tr>
                <td id="total_cost"><?php echo $total_cost["sum(cost)"]; ?></td>
            </tr>
            <tr>
                <td id="request_month">すべての申請分</td>
            </tr>
        </table>
        </div>
        <div id="staff_info">
                <h3>No. <?php echo $id->id . "   " . $id->staff_name; ?></h3>
        </div>
            <div>
            <table class="table table-bordered" style="width:400px;">
                <tr>
                    <th colspan="2" class="text-center active" >利用区間</th>
                    <th class="active">定期代</th>
                </tr>
                <tr>
                    <td><?php echo $id->season_ticket_from ?></td>
                    <td><?php echo $id->season_ticket_to ?></td>
                    <td><?php echo $id->season_ticket_cost ?></td>
                </tr>
            </div>
            </table>
            <div id="add_delete_button">
                <div>
                    <form>
                        <input id="filter_req_id" type="hidden" value="<?php echo $filter_req_id; ?>">
                        <input type="month" id="month_filter">
                        <input type="button" value="絞り込む" id="filter_button" class="btn btn-default">
                    </form>
                </div>
            <span class="pull-right" id="buttons">
                <input type = "button" value="追加" id="show_button" class="btn btn-success">
                <input type = "button" value="削除" id="delete_button" class="btn btn-danger">
            </span>
        </div>
            <!--ここから非表示-->
            <div id="delete_form">
                <p>
                    <form method="post" id="delete_data" action="POST">
                        <input type="text" id="delete_id" placeholder="削除したい申請IDを入力">
                        <input type="button" value="確定" id="delete_ajax_button" class="btn btn-info" onclick="disp();">
                        <input type="button" value="取消" id="delete_ajax_cancel" class="btn btn-default">
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
                    <input type="radio" name="new_vehicle" id="new_vehicle" value="4"/>タクシー
                    <input type="radio" name="new_vehicle" id="new_vehicle" value="5"/>その他
                </p>
                <p>利用区間: <input type="text" name="new_from" id="new_from"> から <input type="text" name="new_to" id="new_to"> まで</p>
                <p>料金: <input type="text" size="40" name="new_cost"id="new_cost" placeholder="定期代を考慮した料金を記入すること。"></p>
                <p>往復 or 片道:
                    <input type="radio" name="new_one_way_or_round" id="new_one_way_or_round" value="往復"/>往復
                    <input type="radio" name="new_one_way_or_round" id="new_one_way_or_round" value="片道"/>片道
                </p>
                <p><textarea name="new_overview" rows="4" cols="40" id="new_overview" placeholder="特記事項"></textarea></p>
            <div>
                <input type = "button" value="確定" id="ajax_button" class="btn btn-info" onclick="disp();">
            </form>
                <input type = "button" value="取消" id="hide_button" class="btn btn-default">
            </div>
        </div>
            <!--ここまで非表示-->
            <div>
            <table class="table table-hover data_table table-bordered">
                <thead>
                <tr class="active" id="add_row">
                  <th>申請ID</th>
                  <th>日付</th>
                  <th>クライアント名</th>
                  <th>交通機関</th>
                  <th colspan="2" class="text-center">利用区間</th>
                  <th>料金</th>
                  <th>片道or往復</th>
                  <th>特記事項</th>
                </tr>
            </thead>
                <!-- 申請数(request_id)のぶん、行として表示 -->
                <tbody>
                    <?php foreach ($table_element as $element) : ?>
                        <tr class="data_all">
                          <td><?php echo $element->id; ?></td>
                          <td><?php echo $element->date; ?></td>
                          <td><?php echo $element->client; ?></td>
                          <td><?php echo $element->vehicle_type; ?></td>
                          <td><?php echo $element->_from; ?></td>
                          <td><?php echo $element->_to; ?></td>
                          <td><?php echo $element->cost; ?></td>
                          <td><?php echo $element->one_way_or_round; ?></td>
                          <td><?php echo $element->overview; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div id="stamp" class="pull-right"></div>
      </div>
      <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="js/main.js"></script>
    </body>

 </html>
