@extends('layouts.admin')
@section('content')
    <style>
        body{background-image:none;}
    </style>
    <div class="pubheit1"></div>
    <div class="so_main">
        <div class="page_tit1"><h5><i class="icon-text-height"></i>{{$position}}管理</h5></div>
        <div class="toolbar">
            <li><a href="javascript:void(0);" onclick="dosearch();"><span class="search_action"><?php echo $search_name;?></span></a></li>
            <div class="nav pull-right">
                <span class="dropdown-toggle navbar-icon pagination" data-toggle="dropdown" style="border-left:none;">

                </span>
            </div>
        </div>
        <div class="pubheit"></div>
        <div>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="line_l">ID</th>
                    <th class="line_l">描述</th>
                    <th class="line_l">操作者</th>
                    <th class="line_l">手机号</th>
                    <th class="line_l">添加时间</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $key => $value)
                    <tr overstyle='on' id="list_{{$value->id}}">
                        <td>{{$value->id}}</td>
                        <td><span id="name_{{$value->id}}">{{$value->desc}}</span></td>
                        <td><span id="real_name_{{$value->id}}">{{$value->name}}</span></td>
                        <td><span id="phone_{{$value->id}}">{{$value->mobile}}</span></td>
                        <td><span id="group_{{$value->id}}">{{date('Y-m-d H:i:s', $value->created_time)}}</span></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection