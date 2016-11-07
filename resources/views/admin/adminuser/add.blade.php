@extends('layouts.admin')
@section('content')
<style>
    body{background-image:none;}
    .mark{padding:5px 10px;border:1px dashed #e5e5e5;background:#fcf8e3;border-radius:3px;margin-bottom:3px;}
</style>

<div class="pubheit1"></div>
<div class="so_main">
    <div class="page_tit1"><h5><i class="icon-text-height"></i>{{$position}}</h5></div>
    @if(count($errors) > 0)
        <div class="mark">
            @if(is_object($errors))
                @foreach($errors->all() as $error)
                    <div>{{$error}}</div>
                @endforeach
            @else
                <div>{{$errors}}</div>
            @endif
        </div>
    @endif
    <div id="addAttr_div">
        <form class="form-horizontal" method="post" action="{{ isset($field) ? url('admin/adminuser/' . $field->id) : url('admin/adminuser')}}">
            {{csrf_field()}}
            @if( ! empty($field))
                <input type="hidden" name="_method" value="put">
            @endif
            <fieldset>
                <div class="row-fluid">
                    <div class="well">
                        <div class="control-group">
                            <label class="control-label">管理员用户名：</label>
                            <div class="controls">
                                <input class="span4" type="text" id="user_name" name="user_name" value="{{ isset($field) ? $field->user_name : ''}}" >
                                管理员登陆时的用户中
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">管理员密码：</label>
                            <div class="controls">
                                <input name="user_pass" class="span4" id="user_pass" type="password" value="">
                                登陆员登陆时的密码,密码不区分大小写
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">真实姓名：</label>
                            <div class="controls">
                                <input name="real_name" class="span4" id="real_name" type="text" value="{{ isset($field) ? $field->real_name : ''}}">
                                管理员的真实姓名
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">手机号：</label>
                            <div class="controls">
                                <input name="mobile" class="span4" id="phone" type="text" value="{{ isset($field) ? $field->mobile : ''}}">
                                <span id="phoneContent">管理员的手机号</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">所属用户组：</label>
                            <div class="controls">
                                <select name="user_group_id" class="span4" id="user_group_id">
                                    @foreach($group_list as $key => $value)
                                        <option value="{{$value->id}}"
                                            @if( ! empty($field) && $field->user_group_id == $value->id)
                                                selected
                                            @endif
                                        >{{$value->groupname}}</option>
                                    @endforeach
                                </select>
                                不同的用户组对应不同的权限
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions align-left">
                    @if( ! empty($field))
                        <input type="hidden" name="id" value="{{$field->id}}">
                    @endif
                    <input type="submit" class="btn btn-primary" id="showwait" value="提交" />
                    <a href="javascript:history.back(-1);" class="btn btn-primary">返回</a>
                </div>
            </fieldset>
        </form>
    </div>
</div>
@endsection













