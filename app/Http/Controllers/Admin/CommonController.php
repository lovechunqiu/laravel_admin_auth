<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\AdminAuth;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class CommonController extends Controller
{
    /**
     * 获取权限组数据
     * @param int $gid
     * @return array
     */
    public function get_group_data($gid=0){
        $gid=intval($gid);
        $expiresAt = Carbon::now()->addMinutes(60);
        if($gid == 0){
            if( ! $list = Cache::get('AUTH_all')){
                $data   = AdminAuth::where('status', 1)->get();
                $list   = array();
                foreach($data as $key => $v){
                    $list[$v['id']] = $v;
                    $list[$v['id']]['controller'] = unserialize($v['controller']);
                }
                Cache::put('AUTH_all', $list, $expiresAt);
            }
        }else{
            if( ! $list = Cache::get('AUTH_' . $gid)){
                $data   = AdminAuth::find($gid);
                $data['controller'] = unserialize($data['controller']);
                $list = $data;
                Cache::put('AUTH_' . $gid, $list, $expiresAt);
            }
        }
        return $list;
    }

    /**
     * 缓存菜单
     * @param $name
     * @param string $value
     * @return bool|int|mixed|string
     */
    public function cache_menu($name, $value='') {
        if ('' !== $value) {
            if (is_null($value)) {
                // 删除缓存
                Cache::forget($name);
            } else {
                $expiresAt = Carbon::now()->addMinutes(60);
                // 缓存数据
                Cache::put($name, $value, $expiresAt);
            }
        }
        if($data = Cache::get($name)){
            return $data;
        }else{
            return FALSE;
        }
    }


}
