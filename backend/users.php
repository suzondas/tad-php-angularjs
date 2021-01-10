<?php
set_time_limit(200);
require 'tad-php.php';
header("Content-Type:text/json");
$tad_factory = new TADPHP\TADFactory(['ip' => '103.91.229.62']);
$tad = $tad_factory->get_instance();
$t = $tad->get_all_user_info()->to_array();

if (!array_key_exists('PIN', $t['Row'])) {

    $arr = reset($t);

    foreach ($arr as $key => $value) {
        $pin = $value['PIN2'];
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

    $user_info = $tad->get_user_info(['pin' => $new_obj->Row['PIN2']])->to_array();
    $new_obj->Row['Name'] = reset($user_info)['Name'];

    $new_obj1 = new stdClass();
    $new_obj1->Row = array();
    $new_obj1->Row[] = $new_obj->Row;
    echo json_encode($new_obj1);
}


// $tad->set_user_info([
// 'pin' => 1,
// 'name'=> 'suzon'
// ]);
// $t = $tad->get_user_info(['pin'=>1]);
// echo $t;
?>
