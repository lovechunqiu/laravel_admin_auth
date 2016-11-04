<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin;
use App\Http\Model\AdminAuth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WelcomeController extends CommonController
{
    public function index()
    {
        $user = $this->_getAdminInfo();
        return view('admin.home.welcome', compact('user'));
    }

    private function _getAdminInfo(){

        $id = session('admin_info.admin');
        $info = Admin::find($id);
        $admin_auth = AdminAuth::find($info['user_group_id']);

        $userinfo['last_log_time'] = $_SERVER['REQUEST_TIME'];
        $userinfo['last_log_ip'] = $_SERVER['REMOTE_ADDR'];
        $userinfo['user_name'] = session('admin_info.adminname');
        $userinfo['groupname'] = $admin_auth['groupname'];

        return $userinfo;
    }
}
