<?php
/* 用于数据库链接等的配置 */
class AppConfig {
	//网站名称
	public static $web_name = 'HelloWorld';
	//用于数据库链接
	public static $db = array(
			'host'=>'192.168.1.250',
			'dbname'=>'yulong',
			'username'=>'dreamfly',
			'password'=>'zhangmeng',
		);
	//后台管理用户名及密码
	public static $admin = array(
			'username'=>'admin',
			'password'=>'admin',
		);
	//debug模式开关
	public static $debug = true;

	/********************************************************** 一般不用改的配置 ***********************************************************/
	//自动导入框架的类文件的路径
	//仅添加自定义扩展类时要添加扩展类的路径
	public static $includePath = array(
			'application'	=>'application',	//应用根目录
			'framework'	=>'application.framework',
			'widget'	=>'application.framework.widget',
		);

}
?>