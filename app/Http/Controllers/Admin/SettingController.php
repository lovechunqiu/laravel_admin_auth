<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\AdminAuth;
use App\Http\Model\WebGlobal;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;

class SettingController extends CommonController
{

    public function websetting()
    {
        //判断是否是post提交
        if($input = Input::except('_token', 'fid')){
            foreach($input as $key => $value){
                WebGlobal::where('id', $key)->update(array('text' => $value, 'updated_time' => time()));
            }
            return redirect('admin/websetting');
        }else{
            $list = WebGlobal::where('status', 1)->orderBy('order_sn', 'desc')->get();
            $position = '网站设置';
            return view('admin.setting.websetting', compact('list', 'position'));
        }
    }

    public function dodelweb(){

        $input = Input::all();
        dd($input);
    }
    
    /**
     * 清除缓存
     */
    public function cleanall()
    {
        $list = AdminAuth::where('status', 1)->select('id')->get();
        if( ! $list->isEmpty()){
            foreach($list as $key => $value){
                Cache::forget('submenu_' . $value['id']);
            }
        }
        return redirect('admin/welcome');
    }
}
