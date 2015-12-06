<?php
//测试
include('./im.php');
//$im = new ImUser();
////创建云信id
//$im->accid = 'test-' . time();
//$im->name = 'me';
//$im->token = md5($im->accid);
//print_r($im->create());

//获取用户
//print_r($im->refreshToken('20053140'));
class test{
	public $test =1;
}
$data = array(
	'int' => 100,
	'string' => 'ffsdf',
	'bool' => true,
	'array' => array(1,2,3,'ffs'),
	'object' => new test(),
	'null' => null

);
echo json_encode($data);
?>