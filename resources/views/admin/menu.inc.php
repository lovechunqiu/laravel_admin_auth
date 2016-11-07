<?php
/*array(菜单名，菜单url参数，是否显示)*/
$i=0;
$j=0;
$menu_left =  array();
$menu_left[$i]=array('全局','#',1);
$menu_left[$i]['low_title'][$i."-".$j] = array('全局设置','#',1);
$menu_left[$i][$i."-".$j][] = array('欢迎页',url('admin/welcome'),1,'welcome','wel1');
$j++;
$menu_left[$i]['low_title'][$i."-".$j] = array('缓存管理','#',1);
$menu_left[$i][$i."-".$j][] = array('所有缓存',url('admin/cleanall'),1,'setting','setting5');

$i++;
$menu_left[$i]= array('网站管理','#',1);
$menu_left[$i]['low_title'][$i."-".$j] = array('网站管理',"#",1);
$menu_left[$i][$i."-".$j][] = array('网站列表',url('admin/websetting'),1,'setting','setting1');

$i++;
$menu_left[$i]= array('日志管理','#',1);
$menu_left[$i]['low_title'][$i."-".$j] = array('日志管理',"#",1);
$menu_left[$i][$i."-".$j][] = array('日志列表',url('admin/adminlogs'),1,'adminlogs','adminlogs1');

$i++;
$menu_left[$i]= array('权限','#',1);
$menu_left[$i]['low_title'][$i."-".$j] = array('用户权限管理',"#",1);
$menu_left[$i][$i."-".$j][] = array('管理员管理',url('admin/adminuser'),1,'adminuser','adminuser1');
$menu_left[$i][$i."-".$j][] = array('用户组权限管理',url('admin/auth'),1,'auth','auth1');

// $i++;
// $menu_left[$i]= array('数据库','#',1);
// $menu_left[$i]['low_title'][$i."-".$j] = array('数据库管理','#',1);
// $menu_left[$i][$i."-".$j][] = array('数据库信息',{{url('db/index'),1,'Db','db1');
// $menu_left[$i][$i."-".$j][] = array('备份管理',{{url('db/baklist'),1,'Db','db4');



?>
