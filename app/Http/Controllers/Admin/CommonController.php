<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin;
use App\Http\Model\AdminAuth;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Cache;

class CommonController extends Controller
{
    public $authInc      = array();
    public $menuLeft     = array();
    protected $justlogin = FALSE;
    function __construct(){

        require_once 'resources/views/admin/menu.inc.php';
        require_once 'resources/views/admin/auth.inc.php';

        //控制器
        $controller = $this->getCurrentControllerName();
        //方法
        $function   = $this->getCurrentMethodName();

        define('MODULE_NAME', $controller);
        define('ACTION_NAME', $function);
        define('AUTHINC', json_encode($auth_inc));
        define('MENULEFT', json_encode($menu_left));

        //有些方法是不需要进行校验的
        if( ! (MODULE_NAME == 'appversion' && ACTION_NAME == 'callbackapk')){
            $this->_check_auth();
        }
    }

    /**
     * 获取当前控制器名
     *
     * @return string
     */
    public function getCurrentControllerName()
    {
        $controller = $this->getCurrentAction()['controller'];
        $ex = explode('Controller', $controller);
        return strtolower($ex[0]);
    }

    /**
     * 获取当前方法名
     *
     * @return string
     */
    public function getCurrentMethodName()
    {
        return strtolower($this->getCurrentAction()['method']);
    }

    /**
     * 获取当前控制器与方法
     *
     * @return array
     */
    public function getCurrentAction()
    {
        $action = \Route::current()->getActionName();
        list($class, $method) = explode('@', $action);
        $class = substr(strrchr($class,'\\'),1);
        return ['controller' => $class, 'method' => $method];
    }

    /**
     * 权限校验
     */
    private function _check_auth(){
        !isset($this->justlogin)?$this->justlogin=false:$this->justlogin=$this->justlogin;

        $admin_id = session('admin_info.admin');
        $query_string = explode("/", $_SERVER['REQUEST_URI']);
        if( ! empty($admin_id)){
            //$this->load->vars(array('adminname' => $this->session->userdata('adminname')));
        }elseif(strtolower(ACTION_NAME) != 'logout' && strtolower(ACTION_NAME) != 'login'){
            return redirect('admin/login?code=' . $query_string[1]);
        }
        if( ! get_user_auth($admin_id) && ! $this->justlogin){
            exit('权限不足！');
            if(empty($admin_id)){
                return redirect('admin/login');
            }else{
                $this->error('权限不足！', url('admin/welcome'));die;
            }
        }
    }

    /**
     * 登陆成功，跳转
     * @author lideqiang87@gmail.com
     * @date   2016-11-07
     * @param  string     $message    [description]
     * @param  string     $url        [description]
     * @param  integer    $waitSecond [description]
     * @return [type]                 [description]
     */
    public function success($message = '成功', $url = '', $waitSecond = 3){

        $data = array(
            'jumpUrl' => $url,
            'message' =>$message,
            'status' => 1,
            'waitSecond' => $waitSecond
        );
        return view('admin.tip', compact('data'));
    }

    /**
     * 登陆失败，跳转
     * @author lideqiang87@gmail.com
     * @date   2016-11-07
     * @param  string     $message    [description]
     * @param  string     $url        [description]
     * @param  integer    $waitSecond [description]
     * @return [type]                 [description]
     */
    public function error($message = '失败', $url = '', $waitSecond = 3){
        $data = array(
            'jumpUrl' => $url,
            'message' => $message,
            'status' => 0,
            'waitSecond' => $waitSecond
        );
        return view('admin.tip', compact('data'));
        exit;
    }


}
