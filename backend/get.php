<?php
date_default_timezone_set('Asia/Dhaka');
require 'tad-php.php';

header("Content-Type:text/json");
$tad_factory = new TADPHP\TADFactory(['ip' => '103.91.229.62']);
$tad = $tad_factory->get_instance();
$user_info = $tad->get_att_log();
//$date = date('2019-02-11');
//$date = $_POST['date'];

if ($_POST['date'] == 'today') {
    $sDate = date('Y-m-d');
    $eDate = date('Y-m-d');
} elseif ($_POST['date'] == 'yesterday') {
    $sDate = date("Y-m-d", strtotime( '-1 days' ) );
    $eDate = date("Y-m-d", strtotime( '-1 days' ) );
}elseif ($_POST['date'] == 'specific') {
    $sDate = $_POST['specific'];
    $eDate = $_POST['specific'];
}

$t = $user_info->filter_by_date(['start' => $sDate, 'end' => $eDate]);
if ($t->is_empty_response()) {
    $new_obj = new stdClass();
    $new_obj->Row = array();
    echo json_encode($new_obj);

} else {
    $t = $user_info->to_array();
    if (!array_key_exists('PIN', $t['Row'])) {
        $arr = reset($t);
//    print_r($arr);exit;
        foreach ($arr as $key => $value) {

            $pin = $value['PIN'];
            $user_info = $tad->get_user_info(['pin' => $pin])->to_array();
            $arr[$key]['Name'] = reset($user_info)['Name'];

        }

        $new_obj = new stdClass();
        $new_obj->Row = $arr;
        echo json_encode($new_obj);
    } else {
        $arr = $t['Row'];
        $new_obj = new stdClass();
        $new_obj->Row = $arr;

        $user_info = $tad->get_user_info(['pin' => $new_obj->Row['PIN']])->to_array();
        $new_obj->Row['Name'] = reset($user_info)['Name'];

        $new_obj1 = new stdClass();
        $new_obj1->Row = array();
        $new_obj1->Row[] = $new_obj->Row;
        echo json_encode($new_obj1);
    }
}
?>
