<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin;
use App\Http\Model\AdminAuth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once 'resources/org/code/Code.class.php';

class LoginController extends CommonController
{
    public function login()
    {
        //判断是否是post提交
        if($input = Input::all()){
            //验证码判断
            if(strtoupper($input['code']) != $this->_getCode())
                return back()->with('msg', '验证码错误！');
            $result = Admin::where('user_name', $input['admin_name'])->get();
            if($result->isEmpty())
                return back()->with('msg', '用户名不正确！');
            $info = $result[0];
            if(Crypt::decrypt($info['user_pass']) != $input['admin_pass'])
                return back()->with('msg', '密码不正确！');
            $admin_auth = AdminAuth::find($info['user_group_id']);
            $session_data = array(
                'admin'         => $info['id'],
                'apid'          => $info['pid'],
                'adminname'     => $info['user_name'],
                'realname'      => $info['real_name'],
                'user_group_id' => $info['user_group_id'],
                'other_id'      => $info['other_id'],
                'groupname'     => $admin_auth['groupname'],
            );
            //存储信息
            session(['admin_info' => $session_data]);
            return redirect('admin');
        }else{
            return view('admin.home.login');
        }
    }

    public function crypt()
    {
        $str = 'admin';
        $str_p = Crypt::encrypt($str);
        echo $str_p;die;
        echo '<br>';
        echo Crypt::decrypt($str_p);
    }

    public function logout()
    {
        session(['admin_info' => null]);
        return redirect('admin/login');
    }

    public function code()
    {
        $code = new \Code;
        $code->make();
    }

    private function _getCode(){
        $code = new \Code;
        return $code->get();
    }
}
