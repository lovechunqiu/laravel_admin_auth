<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class IndexController extends CommonController
{
    public function index()
    {
        require_once 'resources/views/admin/auth.inc.php';
        require_once 'resources/views/admin/menu.inc.php';
        //获取相应管理员下的权限分配
        $aid = session('admin_info.admin');
        $aid = ! empty($aid) ? $aid : 0;
        $admin_info = Admin::find($aid);
        $user_group_id = $admin_info['user_group_id'];
        $al      = $this->get_group_data($user_group_id);
        $auth    = $al['controller'];
        $submenu = $this->cache_menu('submenu_' . $user_group_id);
        if( ! $submenu){
            $submenu = array();
            foreach ($menu_left as $key => $value) {
                if($value[2]==0) continue;
                $submenu[$key.'one']['icon'] = '';
                $submenu[$key.'one']['id'] = $key.'one';
                $submenu[$key.'one']['name'] = $value[0];
                $submenu[$key.'one']['url'] = $value[1];
                if(isset($value['low_title']) && !empty($value['low_title'])){
                    foreach ($value['low_title'] as $k => $val) {
                        if($val[2]==0) continue;
                        $submenu[$key.'one']['items'][$k.'two'.$key]['icon'] = '';
                        $submenu[$key.'one']['items'][$k.'two'.$key]['id'] = $k.'two'.$key;
                        $submenu[$key.'one']['items'][$k.'two'.$key]['name'] = $val[0];
                        $submenu[$key.'one']['items'][$k.'two'.$key]['url'] = $val[1];
                        if(isset($value[$k]) && !empty($value[$k])){
                            foreach ($value[$k] as $n => $v) {
                                if($v[2]==0) continue;
                                if(isset($auth[strtolower($v[3])]) && in_array($v[4],$auth[strtolower($v[3])])){
                                    $submenu[$key.'one']['items'][$k.'two'.$key]['items'][$n.$k.'three'.$key]['icon'] = '';
                                    $submenu[$key.'one']['items'][$k.'two'.$key]['items'][$n.$k.'three'.$key]['id'] = $n.$k.'three'.$key;
                                    $submenu[$key.'one']['items'][$k.'two'.$key]['items'][$n.$k.'three'.$key]['name'] = $v[0];
                                    $submenu[$key.'one']['items'][$k.'two'.$key]['items'][$n.$k.'three'.$key]['url'] = $v[1];
                                }
                            }
                        }
                    }
                }
            }

            //遍历数据
            foreach($submenu as $key=>$value){
                foreach ($value['items'] as $k => $v) {
                    if(empty($v['items'])){
                        unset($submenu[$key]['items'][$k]);
                    }
                }
            }
            foreach ($submenu as $key => $value) {
                if(empty($value['items'])){
                    unset($submenu[$key]);
                }
            }
            $this->cache_menu('submenu_'.$user_group_id, $submenu);
        }
        return view('admin.home.home', compact('submenu'));
    }




}
