<?php
/* 用于数据库链接等的配置 */
/* 用get_config方法即可获得config数组 */
function get_config(){
	return array(
		/* 用于数据库链接 */
		'db'=>array(
			'host'=>'localhost',
			'dbname'=>'test',
			'username'=>'root',
			'password'=>'toor',
		),
	);
}
?>