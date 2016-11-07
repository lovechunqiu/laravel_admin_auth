<?php

/**
 * 获取用户权限数组
 * @param string $id
 * @return bool
 */
function get_user_auth($id=""){
    $model=strtolower(MODULE_NAME);
    if(empty($id)) return false;
    $info = \App\Http\Model\Admin::find($id);
    $al = get_group_data($info['user_group_id']);
    $auth = $al['controller'];
    $auth_key = auth_get_key();
//    echo '<pre>';
//    var_dump($auth_key);
//    var_dump($model);
//    var_dump($auth);die;
    if( ! empty($auth_key) && ! empty($auth[$model]) && array_keys($auth[$model],$auth_key)) return true;
    else return false;
}

function get_other_auth($model, $action){
    $model  = strtolower($model);
    $action = strtolower($action);
    $id = session('admin_info.admin');
    if(empty($id))
        return false;
    $info     = \App\Http\Model\Admin::find($id);
    $al       = get_group_data($info['user_group_id']);
    $auth     = $al['controller'];
    $auth_key = auth_get_key($model, $action);
    if( ! empty($auth_key) && ! empty($auth[$model]) && array_keys($auth[$model],$auth_key))
        return true;
    else
        return false;
}

/**
 * 获取权限组数据
 * @param int $gid
 * @return array
 */
function get_group_data($gid=0){
    $gid=intval($gid);
    $expiresAt = \Carbon\Carbon::now()->addMinutes(60);
    if($gid == 0){
        if( ! $list = \Illuminate\Support\Facades\Cache::get('AUTH_all')){
            $data   = \App\Http\Model\AdminAuth::where('status', 1)->get();
            $list   = array();
            foreach($data as $key => $v){
                $list[$v['id']] = $v;
                $list[$v['id']]['controller'] = unserialize($v['controller']);
            }
            \Illuminate\Support\Facades\Cache::put('AUTH_all', $list, $expiresAt);
        }
    }else{
        if( ! $list = \Illuminate\Support\Facades\Cache::get('AUTH_' . $gid)){
            $data   = \App\Http\Model\AdminAuth::find($gid);
            $data['controller'] = unserialize($data['controller']);
            $list = $data;
            \Illuminate\Support\Facades\Cache::put('AUTH_' . $gid, $list, $expiresAt);
        }
    }
    return $list;
}

/**
 * 获取权限key值
 * @param string $model
 * @param string $action
 * @return int|null|string
 */
function auth_get_key($model = '', $action = ''){
    empty($model)?$model=strtolower(MODULE_NAME):$model=strtolower($model);
    empty($action)?$action=strtolower(ACTION_NAME):$action=strtolower($action);
    $keys = array($model,'data','eqaction_'.$action);
    $inc = json_decode(AUTHINC, TRUE);
    $array = array();
    foreach($inc as $key => $v){
        if(isset($v['low_leve'][$model])){
            $array = $v['low_leve'];
            continue;
        }
    }//找到auth.inc中对当前模块的定义的数组

    $num = count($keys);
    $num_last = $num - 1;
    $this_array_0 = &$array;
    $last_key = $keys[$num_last];
    for ($i = 0; $i < $num_last; $i++){
        $this_key = $keys[$i];
        $this_var_name = 'this_array_' . $i;
        $next_var_name = 'this_array_' . ($i + 1);
        if (!array_key_exists($this_key, $$this_var_name)) {
            break;
        }
        $$next_var_name = &${$this_var_name}[$this_key];
    }
    /*取得条件下的数组  ${$next_var_name}得到data数组 $last_key即$keys = array($model,'data','eqaction_'.$action);里面的'eqaction_'.$action,所以总的组成就是，在auth.inc数组里找到键为$model的数组里的键为data的数组里的键为'eqaction_'.$action的值;*/
    $actions = isset(${$next_var_name}[$last_key]) ? ${$next_var_name}[$last_key] : NULL;//这个值即为当前action的别名,然后用别名与用户的权限比对,如果是带有参数的条件则$actions是数组，数组里有相关的参数限制
    if(is_array($actions)){
        foreach($actions as $key_s => $v_s){
            $ma = true;
            if(isset($v_s['POST'])){
                foreach($v_s['POST'] as $pkey => $pv){
                    switch($pv){
                        case 'G_EMPTY';//必须为空
                            if( isset($_POST[$pkey]) && !empty($_POST[$pkey]) ) $ma = false;
                            break;

                        case 'G_NOTSET';//不能设置
                            if( isset($_POST[$pkey]) ) $ma = false;
                            break;

                        case 'G_ISSET';//必须设置
                            if( !isset($_POST[$pkey]) ) $ma = false;
                            break;

                        default;//默认
                            if( !isset($_POST[$pkey]) || strtolower($_POST[$pkey]) != strtolower($pv) ) $ma = false;
                            break;
                    }
                }
            }

            if(isset($v_s['GET'])){
                foreach($v_s['GET'] as $pkey => $pv){
                    switch($pv){
                        case 'G_EMPTY';//必须为空
                            if( isset($_GET[$pkey]) && !empty($_GET[$pkey]) ) $ma = false;
                            break;

                        case 'G_NOTSET';//不能设置
                            if( isset($_GET[$pkey]) ) $ma = false;
                            break;

                        case 'G_ISSET';//必须设置
                            if( !isset($_GET[$pkey]) ) $ma = false;
                            break;

                        default;//默认
                            if( !isset($_GET[$pkey]) || strtolower($_GET[$pkey]) != strtolower($pv) ) $ma = false;
                            break;
                    }

                }
            }
            if($ma)	return $key_s;
            else $actions="0";
        }//foreach
    }else{
        return $actions;
    }
}

/**
 * 缓存菜单
 * @param $name
 * @param string $value
 * @return bool|int|mixed|string
 */
function cache_menu($name, $value='') {
    if ('' !== $value) {
        if (is_null($value)) {
            // 删除缓存
            \Illuminate\Support\Facades\Cache::forget($name);
        } else {
            $expiresAt = \Carbon\Carbon::now()->addMinutes(60);
            // 缓存数据
            \Illuminate\Support\Facades\Cache::put($name, $value, $expiresAt);
        }
    }
    if($data = \Illuminate\Support\Facades\Cache::get($name)){
        return $data;
    }else{
        return FALSE;
    }
}

/**
 * json返回数据
 * @param int $status
 * @param string $info
 * @param array $data
 */
function callback_json($status = 1, $info = '成功', $data = array()){
    echo json_encode(array('status' => $status, 'info' => $info, 'data' => $data));die;
}

/**
 * 后台管理员操作日志
 * @author lideqiang87@gmail.com
 * @date   2016-11-07
 * @param  [type]     $type   [description]
 * @param  integer    $tid    [description]
 * @param  string     $desc   [description]
 * @param  string     $user   [description]
 * @param  string     $mobile [description]
 * @return [type]             [description]
 */
function alogs($type, $tid = 0, $desc = '', $user = '', $mobile = ''){
    if(empty($mobile)){
        $aid  = session('admin_info.admin');
        $info = \App\Http\Model\Admin::find($aid);
    }
    $arr  = array();
    $arr['aid']  = ! empty($info) ? $info['id'] : 0;
    $arr['name'] = $user ? $user : ( ! empty($info) ? ($info['user_name'] . '(' . $info['real_name'] . ')') : '');
    if( ! empty($mobile))
        $arr['mobile'] = $mobile;
    $arr['desc'] = $desc;
    $arr['ip']   = get_client_ip();
    $arr['type'] = $type;
    $arr['tid']  = ! empty($tid) ? $tid : 0;
    $result      = \App\Http\Model\AdminLogs::create($arr);
    return $result;
}

/**
 * 获取客户端IP地址
 * @author lideqiang87@gmail.com
 * @date   2016-09-21
 * @return [type]     [description]
 */
function get_client_ip() {
    static $ip = NULL;
    if ($ip !== NULL) return $ip;
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos =  array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip   =  trim($arr[0]);
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';
    return $ip;
}

