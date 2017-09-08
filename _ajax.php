<?php

    header('Content-Type: text/html; charset=UTF-8');

    require_once(dirname(__FILE__) . '/config.php');
    require_once(dirname(__FILE__) . '/functions.php');
    require_once(dirname(__FILE__) . '/management.php');

    $month = $_POST['month'];

    $all_staff_info =  new AllStaffInfo();
    $filter_month_each_staff = $all_staff_info->FilterMonth($month);

    print_r($filter_month_each_staff);

?>
