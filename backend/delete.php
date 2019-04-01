<?php
require 'tad-php.php';
header ("Content-Type:text/html");
$tad_factory = new TADPHP\TADFactory(['ip'=>'103.91.229.62']);
$tad = $tad_factory->get_instance();
//$user_info = $tad->get_att_log();
//
//
//header("Content-type:application/json");
//$r = $tad->set_user_info(['pin' => $_POST['id'], 'group'=>$_POST['membership'], 'name'=> $_POST['name']]);
//$k= json_encode($r->to_array());
//echo $k;

$tad->delete_user(['pin'=>32]);

?>
