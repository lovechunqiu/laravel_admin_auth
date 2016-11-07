<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\AdminLogs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminLogsController extends CommonController
{

    public function index()
    {
        $data        = AdminLogs::where('status', '1')->orderBy('id', 'desc')->paginate(10);
        $position    = '日志';
        $search_name = '搜索/筛选';
        return view('admin.adminlogs.index', compact('data', 'position', 'search_name'));
    }

}
