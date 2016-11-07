<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\AdminAuth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AuthController extends CommonController
{
    //get.admin/auth  全部用户组权限列表
    public function index()
    {
        $data = AdminAuth::where('status', '1')->orderBy('id', 'desc')->paginate(10);
        $position = '用户组权限';
        return view('admin.auth.index', compact('data', 'position'));
    }

    //post.admin/auth/create  添加用户组权限
    public function create()
    {
        $auth_list = json_decode(AUTHINC, TRUE);
        $position = '添加用户组权限';
        return view('admin.auth.add', compact('auth_list', 'position'));
    }

    //post.admin/adminuser 添加管理员提交
    public function store()
    {
        $input = Input::except('_token');
        //验证规则
        $rules = [
            'groupname' => 'required',
        ];
        //自定义内容
        $message = [
            'groupname.required' => '用户组名称不能为空！',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $data['groupname']    = $input['groupname'];
            $data['controller']   = serialize($input['model']);
            $data['created_time'] = time();
            $data['updated_time'] = time();
            $re = AdminAuth::create($data);
            if($re){
                Cache::forget('AUTH_all');
                return redirect('admin/auth');
            }else{
                return back()->with('errors', '数据填充失败，请稍后重试！');
            }
        }else{
            //打印错误信息
            //dd($validator->errors()->all());
            return back()->withErrors($validator);
        }
    }

    public function show()
    {

    }

    //get.admin/auth/{auth}/edit  编辑用户组权限
    public function edit($id)
    {
        $auth_list = json_decode(AUTHINC, TRUE);
        $field = AdminAuth::find($id);
        $field['controller'] = unserialize($field['controller']);
        $position = '编辑用户组权限';
        return view('admin.auth.edit', compact('field', 'auth_list', 'position'));
    }

    //put.admin/auth/{auth}  更新用户组权限
    public function update($id)
    {
        //剔除不要的参数
        $input = Input::except('_token', '_method');
        //验证规则
        $rules = [
            'groupname' => 'required',
        ];
        //自定义内容
        $message = [
            'groupname.required' => '用户组名称不能为空！',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $data['groupname']    = $input['groupname'];
            $data['controller']   = serialize($input['model']);
            $data['updated_time'] = time();
            $re = AdminAuth::where('id', $id)->update($data);
            if($re){
                Cache::forget('AUTH_all');
                Cache::forget('AUTH_' . $id);
                return redirect('admin/auth');
            }else{
                return back()->with('errors', '信息更新失败，请稍后重试！');
            }
        }else{
            //打印错误信息
            //dd($validator->errors()->all());
            return back()->withErrors($validator);
        }
    }

    //delete.admin/auth/{auth}  删除单个用户组权限
    public function destroy($id)
    {
        $res = AdminAuth::where('id', $id)->update(array('status' => 0));
        if($res){
            callback_json(1, '删除成功！');
        }else{
            callback_json(0, '删除失败！');
        }
    }


}
