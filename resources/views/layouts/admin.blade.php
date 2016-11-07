<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>后台管理中心</title>

    <link href="{{asset('resources/views/admin/css/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/views/admin/css/main.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{asset('resources/views/admin/js/plugins/ui/jquery-1.7.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/js/common.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/js/plugins/ui/admincommon.js')}}"></script>

    <script type="text/javascript" src="{{asset('resources/views/admin/js/plugins/ui/jquery.easytabs.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/js/plugins/ui/jquery.collapsible.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('resources/views/admin/js/files/functions.js')}}"></script>

    <!--dialog弹出框-->
    <link href="{{asset('resources/org/artdialog/css/ui-dialog.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{asset('resources/org/artdialog/dist/dialog-min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/org/artdialog/dist/dialog-plus-min.js')}}"></script>
    <!--dialog弹出框-->

</head>
<body>
<script type="text/javascript">
    //穿越iframe
    window.dialog = dialog;
</script>
@yield('content')

<script type="text/javascript" src="{{asset('resources/views/admin/js/plugins/ui/index.js')}}"></script>
