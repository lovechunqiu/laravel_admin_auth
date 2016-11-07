<?php
/*array(菜单名，菜单url参数，是否显示)*/
//error_reporting(E_ALL);
/*
$auth_inc[$i]['low_leve']['global']  global是model
每个action前必须添加eqaction_前缀'eqaction_websetting'  => 'at1','at1'表示唯一标志,可独自命名,eqaction_后面跟的action必须统一小写


*/
$auth_inc =  array();
$i=0;
$auth_inc[$i]['low_title'][] = '全局设置';
//欢迎页面
$auth_inc[$i]['low_leve']['welcome']= array( "欢迎页" =>array(
		"查看" 		=> 'wel1',
	),
   "data" => array(
   		//欢迎页
		'eqaction_index'  => 'wel1',
	)
);

//网站设置
$i++;
$auth_inc[$i]['low_title'][] = '网站设置';
$auth_inc[$i]['low_leve']['setting']= array( "网站设置" =>array(
	"列表" 		=> 'setting1',
	"增加" 		=> 'setting2',
	"删除" 		=> 'setting3',
	"修改" 		=> 'setting4',
	"清除" 		=> 'setting5',
),
	"data" => array(
		//网站设置
		'eqaction_websetting'  => 'setting1',
		'eqaction_doadd'       => 'setting2',
		'eqaction_dodelweb'    => 'setting3',
		'eqaction_doedit'      => 'setting4',
		'eqaction_cleanall'    => 'setting5'
	)
);

//操作日志
$i++;
$auth_inc[$i]['low_title'][] = '操作日志';
$auth_inc[$i]['low_leve']['adminlogs']= array( "操作日志" =>array(
	"列表" 		=> 'adminlogs1',
	"增加" 		=> 'adminlogs2',
	"删除" 		=> 'adminlogs3',
	"修改" 		=> 'adminlogs4',
),
	"data" => array(
		'eqaction_index'    => 'adminlogs1',
		'eqaction_doadd'    => 'adminlogs2',
		'eqaction_add'      => 'adminlogs2',
		'eqaction_dodelete' => 'adminlogs3',
		'eqaction_doedit'   => 'adminlogs4',
		'eqaction_edit'   	=> 'adminlogs4',
	)
);

//管理员管理
$i++;
$auth_inc[$i]['low_title'][] = '管理员管理';
$auth_inc[$i]['low_leve']['adminuser']= array(
	"管理员管理" =>array(
		"列表" 		=> 'adminuser1',
		"增加" 		=> 'adminuser2',
		"删除" 		=> 'adminuser3',
		"修改" 		=> 'adminuser4',
	),
	"data" => array(
		//管理员管理
		'eqaction_index'    => 'adminuser1',
		'eqaction_create'   => 'adminuser2',
		'eqaction_store'    => 'adminuser2',
		'eqaction_destroy'  => 'adminuser3',
		'eqaction_edit'     => 'adminuser4',
		'eqaction_update'   => 'adminuser4',
	)
);

//权限管理
$i++;
$auth_inc[$i]['low_title'][] = '权限管理';
$auth_inc[$i]['low_leve']['auth']= array(
	"权限管理" =>array(
		"列表" 		=> 'auth1',
		"增加" 		=> 'auth2',
		"删除" 		=> 'auth3',
		"修改" 		=> 'auth4',
	),
	"data" => array(
		//权限管理
		'eqaction_index'    => 'auth1',
		'eqaction_create'   => 'auth2',
		'eqaction_store'    => 'auth2',
		'eqaction_destroy'  => 'auth3',
		'eqaction_edit'     => 'auth4',
		'eqaction_update'   => 'auth4',
	)
);

//数据库管理
// $i++;
// $auth_inc[$i]['low_title'][] = '数据库管理';
// $auth_inc[$i]['low_leve']['db']= array(
// 	"数据库信息" =>array(
// 		"查看"		=> 'db1',
// 		"备份"		=> 'db2',
// 		"查看表结构"	=> 'db3',
// 	),
//    "数据库备份管理" =>array(
// 		"备份列表" 		=> 'db4',
// 		"删除备份" 		=> 'db5',
// 		"恢复备份" 		=> 'db6',
// 		"打包下载" 		=> 'db7',
// 	),
//    "清空数据" =>array(
// 		"清空数据"		=> 'db8',
// 	),
// 	"data" => array(
//    		//权限管理
// 		'eqaction_index'  		=> 'db1',
// 		'eqaction_set'  		=> 'db2',
// 		'eqaction_backup'  		=> 'db2',
// 		'eqaction_showtable'  	=> 'db3',
// 		'eqaction_baklist'  	=> 'db4',
// 		'eqaction_delbak'  		=> 'db5',
// 		'eqaction_restore'  	=> 'db6',
// 		'eqaction_dozip'  		=> 'db7',
// 		'eqaction_downzip'  	=> 'db7',
// 		'eqaction_truncate'  	=> 'db8',
// 	)
// );



/* End of file auth.inc.php */
/* Location: ./admin/auth.inc.php */
