<?php
    header('Content-Type: text/html; charset=UTF-8');

    require_once(dirname(__FILE__) . '/config.php');
    require_once(dirname(__FILE__) . '/functions.php');
    require_once(dirname(__FILE__) . '/management.php');

    $all_staff_info = new AllStaffInfo();
    $all_staff_each_cost = $all_staff_info->AllStaffCost();

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/admin.css">
        <title>交通費申請システム</title>
    </head>
    <body>
        <div class="container">
            <div class="center-block">
                <h1>管理用画面</h1>
                <div>
                    <input type="month" id="filter_month">
                    <input type="button" value="絞り込む" class="btn btn-default" id="filter">
                    <input type="button" value="全期間" class="btn btn-default" id="all_term">
                </div>
                <div class="table_display_area">
                    <table class="table table-striped">
                        <tr><th>社員ID</th><th>名前</th><th>申請回数</th><th>営業交通費計</th><th>定期代</th></tr>
                        <?php foreach($all_staff_each_cost as $each_staff) : ?>
                            <tr class="all_term_info">
                                <td> <?php echo $each_staff['id']; ?> </td>
                                <td> <?php echo $each_staff['staff_name']; ?> </td>
                                <td> <?php echo $each_staff['COUNT(request_details.cost)']; ?> </td>
                                <td> <?php echo $each_staff['SUM(request_details.cost)']; ?> </td>
                                <td> <?php echo $each_staff['season_ticket_cost']; ?> </td>
                            </tr>
                        <?php endforeach; ?>
                    </div>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="js/admin.js"></script>
        <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </body>
</html>
