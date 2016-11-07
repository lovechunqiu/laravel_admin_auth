@extends('layouts.admin')
@section('content')
    <script type="text/javascript">
        var delUrl = "{{url('admin/adminuser')}}";
    </script>
    <style>
        body{background-image:none;}
    </style>
    <div class="pubheit1"></div>
    <div class="so_main">
        <div class="page_tit1"><h5><i class="icon-text-height"></i>{{$position}}管理</h5></div>
        <div>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th style="width:30px;">
                        <input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
                        <label for="checkbox"></label>
                    </th>
                    <th class="line_l">ID</th>
                    <th class="line_l">用户名</th>
                    <th class="line_l">真实姓名</th>
                    <th class="line_l">手机号</th>
                    <th class="line_l">所属用户组</th>
                    <th class="line_l">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $key => $value)
                <tr overstyle='on' id="list_{{$value->id}}">
                    <td><input type="checkbox" name="checkbox" id="checkbox2" onclick="checkon(this)" value="{{$value->id}}"></td>
                    <td>{{$value->id}}</td>
                    <td><span id="name_{{$value->id}}">{{$value->user_name}}</span></td>
                    <td><span id="real_name_{{$value->id}}">{{$value->real_name}}</span></td>
                    <td><span id="phone_{{$value->id}}">{{$value->mobile}}</span></td>
                    <td><span id="group_{{$value->id}}">{{$value->groupname}}</span></td>
                    <td>
                        @if(get_other_auth('adminuser', 'edit'))
                            <a href="{{url('admin/adminuser/' . $value->id . '/edit')}}">编辑</a>
                        @endif
                        @if(get_other_auth('adminuser', 'destroy'))
                            <a href="javascript:void(0);" onclick="del('{{csrf_token()}}','{{$value->id}}');">删除</a>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        <div class="pubheit"></div>
        <div class="toolbar">
            @if(get_other_auth('adminuser', 'create'))
                <li><a href="{{url('admin/adminuser/create')}}"><span>添加{{$position}}</span></a></li>
            @endif
            <div class="nav pull-right">
                <span class="dropdown-toggle navbar-icon pagination" data-toggle="dropdown" style="border-left:none;">

                </span>
            </div>
        </div>
    </div>

@endsection