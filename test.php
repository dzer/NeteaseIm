<?php
//测试
include('./im.php');
$im = new ImUser();
////创建云信id
//$im->accid = 'test-' . time();
//$im->name = 'me';
//$im->token = md5($im->accid);
//print_r($im->create());

//获取用户
print_r($im->getinfos(array('20053140')));


?>