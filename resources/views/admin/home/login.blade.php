<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>后台管理</title>
    <link href="{{asset('resources/views/admin/css/main.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{asset('resources/views/admin/js/plugins/ui/jquery-1.7.1.min.js')}}"></script>

    <!--dialog弹出框-->
    <link href="{{asset('resources/org/artdialog/css/ui-dialog.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{asset('resources/org/artdialog/dist/dialog-min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/org/artdialog/dist/dialog-plus-min.js')}}"></script>
    <!--dialog弹出框-->

    <script type="text/javascript" src="{{asset('resources/views/admin/js/plugins/ui/admincommon.js')}}"></script>

</head>

<body class="no-background">

<!-- Fixed top -->
<div id="top">
    <div class="fixed">
        <span class="logo"><img src="{{asset('resources/views/admin/img/logo.png')}}" alt="" /></span>
    </div>
</div>
<!-- /fixed top -->

<!-- Login block -->
<div class="login">
    <div class="navbar">
        <div class="navbar-inner">
            <h6><i class="icon-user"></i>管理员登录</h6>
        </div>
    </div>
    <div class="well">
        <form action="" method="post" class="form-horizontal" name="form">
            {{csrf_field()}}
            @if(session('msg'))
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls" style="color: red;">
                    {{session('msg')}}
                </div>
            </div>
            @endif
            <div class="control-group">
                <label class="control-label">用户名：</label>
                <div class="controls">
                    <input type="text" id="admin_name" name="admin_name" placeholder="" style="width:250px;"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">密码：</label>
                <div class="controls">
                    <input type="password" name="admin_pass" placeholder="" style="width:250px;"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">验证码：</label>
                <div class="controls">
                    <input type="text" name="code" placeholder="" style="width:137px;" />&nbsp;&nbsp;&nbsp;
                    <img src="{{url('admin/code')}}" alt="" onclick="this.src='{{url('admin/code')}}?'+Math.random()">
                </div>
            </div>

            <div class="login-btn"><input type="submit" value="登 陆" class="btn btn-danger btn-block"/></div>
        </form>
    </div>
</div>
<!-- /login block -->

<!-- Footer -->
<div id="footer">
    <div class="copyrights">后台管理</div>
    <!-- <ul class="footer-links">
        <li><a href="" title=""><i class="icon-cogs"></i>Contact admin</a></li>
        <li><a href="" title=""><i class="icon-screenshot"></i>Report bug</a></li>
    </ul> -->
</div>
<!-- /footer -->

</body>
</html>
