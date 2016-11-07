<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\AdminAuth;
use App\Http\Model\WebGlobal;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

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

    /**
     * 删除配置
     */
    public function dodelweb(){
        if($input = Input::except('_token')){
            $id = $input['id'];
            $info = WebGlobal::find($id);
            if($info['is_sys'] == 1){
                $a_data['status'] = 0;
                $a_data['message'] = "系统参数，禁止删除";
                exit(json_encode($a_data));
            }
            $update = WebGlobal::where('id', $id)->update(array('status' => 0));
            if($update){
                $a_data['status'] = 1;
                $a_data['id'] = $id;
                $a_data['message'] = '删除成功';
            }else{
                $a_data['status'] = 0;
                $a_data['message'] = "删除失败";
            }

            exit(json_encode($a_data));
        }else{

        }
    }

    public function doadd()
    {
        $input = Input::except('_token');
        //验证规则
        $rules = [
            'name' => 'required',
            'code' => 'required',
        ];
        //自定义内容
        $message = [
            'name.required'  => '参数名称不能为空！',
            'code.required'  => '参数代码不能为空！',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $input['created_time'] = time();
            $input['updated_time'] = time();
            $res = WebGlobal::create($input);
            if($res){
                $this->callback_json(1, '添加成功');
            }else{
                $this->callback_json(0, '数据填充失败，请稍后重试！');
            }
        }else{
//            dd($validator->errors()->all());
            $this->callback_json(0, '参数校验不正确！');
        }
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
