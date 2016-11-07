<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends CommonController
{
    //get.admin/adminuser  全部管理员列表
    public function index()
    {
        $data = Admin::where('status', '1')->orderBy('id', 'desc')->paginate(10);
        if($data){
            $group_list = get_group_data();
            foreach($data as $key => $value){
                $data[$key]['groupname'] = $group_list[$value->user_group_id]['groupname'];
            }
        }
        $position = '管理员';
        return view('admin.adminuser.index', compact('data', 'position'));
    }

    //post.admin/adminuser/create  添加管理员
    public function create()
    {
        $group_list = get_group_data();
        $position = '添加管理员';
        return view('admin.adminuser.add', compact('group_list', 'position'));
    }

    //post.admin/adminuser 添加管理员提交
    public function store()
    {
        $input = Input::except('_token');
        //判断管理员用户名是否存在
        $aBool = $this->_admin_user_check($input);
        if($aBool) {
            alogs(-100, '', 'adminName:' . $input['user_name'] . '，用户名已存在，请重新输入！');
            return back()->with('errors', '用户名已存在，请重新输入！');
        }
        //验证规则
        $rules = [
            'user_name' => 'required',
            'user_pass'  => 'required',
        ];
        //自定义内容
        $message = [
            'user_name.required' => '用户名不能为空！',
            'user_pass.required'  => '密码不能为空！',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $input['pid']          = session('admin_info.admin');
            $input['user_pass']    = Crypt::encrypt($input['user_pass']);
            $input['created_time'] = time();
            $input['updated_time'] = time();
            $re = Admin::create($input);
            if($re){
                alogs(-100, '', 'adminName:' . $input['user_name'] . '，管理员添加成功！');
                return redirect('admin/adminuser');
            }else{
                alogs(-100, '', 'adminName:' . $input['user_name'] . '，数据填充失败，请稍后重试！');
                return back()->with('errors', '数据填充失败，请稍后重试！');
            }
        }else{
            //打印错误信息
            //dd($validator->errors()->all());
            alogs(-100, '', 'adminName:' . $input['user_name'] . '，参数校验错误！');
            return back()->withErrors($validator);
        }
    }

    public function show()
    {

    }

    //get.admin/adminuser/{adminuser}/edit  编辑管理员
    public function edit($id)
    {
        $field = Admin::find($id);
        $group_list = get_group_data();
        $position = '编辑管理员';
        return view('admin.adminuser.add', compact('field', 'group_list', 'position'));
    }

    //put.admin/adminuser/{adminuser}  更新管理员
    public function update($id)
    {
        //剔除不要的参数
        $input = Input::except('_token', '_method');
        //判断管理员用户名是否存在
        $aBool = $this->_admin_user_check($input);
        if($aBool){
            alogs(-100, '', 'adminName:' . $input['user_name'] . '，用户名已存在，请重新输入！');
            return back()->with('errors', '用户名已存在，请重新输入！');
        }
        //验证规则
        $rules = [
            'user_name' => 'required',
        ];
        //自定义内容
        $message = [
            'user_name.required' => '用户名不能为空！',
        ];
        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            if($input['user_pass']){
                $data['user_pass'] = Crypt::encrypt($input['user_pass']);
            }
            $data['user_name'] = $input['user_name'];
            $data['real_name'] = $input['real_name'];
            $data['mobile']    = $input['mobile'];
            $data['user_group_id'] = $input['user_group_id'];
            $data['updated_time'] = time();
            $re = Admin::where('id', $id)->update($data);
            if($re){
                alogs(-100, '', 'adminName:' . $input['user_name'] . '，编辑成功！');
                return redirect('admin/adminuser');
            }else{
                alogs(-100, '', 'adminName:' . $input['user_name'] . '，信息更新失败，请稍后重试！');
                return back()->with('errors', '信息更新失败，请稍后重试！');
            }
        }else{
            //打印错误信息
            //dd($validator->errors()->all());
            alogs(-100, '', 'adminName:' . $input['user_name'] . '，参数校验错误！');
            return back()->withErrors($validator);
        }
    }

    //delete.admin/adminuser/{adminuser}  删除单个管理员
    public function destroy($id)
    {
        $res = Admin::where('id', $id)->update(array('status' => 0));
        if($res){
            callback_json(1, '删除成功！');
        }else{
            callback_json(0, '删除失败！');
        }
    }

    /**
     * 检测管理员用户名是否存在
     * @param $post
     */
    private function _admin_user_check($post){
        if( ! empty($post['id'])){
            $info = Admin::find($post['id']);
            if( ! empty($info) && ($info['user_name'] != $post['user_name'])){
                return $this->_get_info_by_name($post['user_name']);
            }
        }else{
            return $this->_get_info_by_name($post['user_name']);
        }
    }

    /**
     * 通过用户名获取信息
     * @param $user_name
     */
    private function _get_info_by_name($user_name){
        $res = Admin::where('user_name', $user_name)->get();
        if( ! $res->isEmpty()){
            return TRUE;
        }else{
            return FALSE;
        }
    }

}
