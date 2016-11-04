@extends('layouts.admin')
@section('content')

<style>
    body{background-image:none;}
    .pubheit{height:10px;}
</style>
<div class="pubheit"></div>
<h5 class="widget-name"><i class="icon-text-height"></i>站点配置</h5>




<!-- 搜索用户 -->

<form class="form-horizontal" method="post" action="">
    {{csrf_field()}}
    <fieldset>
        <div class="row-fluid">
            <div class="navbar">
                <div class="navbar-inner">
                    <h6>
                        <a href="javascript:void(0);" onclick="addWebSetting();">
                            <span class="searchUser_action">添加新参数</span>
                        </a>
                    </h6>
                </div>
            </div>
            <div class="well">
                @foreach($list as $key => $value)
                <div class="control-group" id="line_{{$value->id}}">
                    <label class="control-label">
                        <a href="javascript:void(0);" style="display:none;" onclick="delx('{{$value->id}}');" class="a_del" title="删除此条数据">X&nbsp;&nbsp;</a>
                        {{$value->name}}：
                    </label>
                    <div class="controls">
                        {{$dis = " "}}
                        @if($value['dis_abled'] == 1)
                            {{$dis = "disabled"}}
                        @endif
                        @if($value['type'] == 'textarea')
                            <textarea {{$dis}} name="{{$value->id}}" class="span4">{{$value->text}}</textarea>
                        @else
                            <input {{$dis}} name="{{$value->id}}" class="span4" type="text" value="{{$value->text}}">
                        @endif
                        @if( ! empty($value->tip))
                            {{$value->tip . '(' . $value->code . ')'}}
                        @else
                            {{$value->code}}
                        @endif
                    </div>
                </div>
                @endforeach
                <div class="form-actions align-left">
                    <input type="hidden" name="fid" id="fid"/>
                    <button class="btn btn-primary" type="submit">确定</button><span style="color:#CCCCCC"> (所有方式修改提交一次即可)</span>
                </div>
            </div>
        </div>
    </fieldset>
</form>

<script type="text/javascript">
    $(document).ready(function(){
        $(".control-label").mouseover(function(){
                    $(this).find(".a_del").css({"display":"block","float":"left"})
                }
        )
        $(".control-label").mouseleave(function(){
                    $(this).find(".a_del").css("display","none")
                }
        )
    });
    function delx(id){

        top.dialog({
            title:'消息',
            content:'您确定要删除这些记录吗？',
            id:'dd',
            zIndex: 1100,
            button: [
                {
                    value: '同意',
                    callback: function () {
                        var datas = {'id':id, '_token':'{{csrf_token()}}'};
                        $.post("{{url('admin/dodelweb')}}", datas,delSettingResponse,'json');
                    },
                    autofocus: true
                },
                {
                    value: '取消'
                }
            ]
        }).showModal();

    }

    function delSettingResponse(res){
        if(res.status){
            $("#line_"+res.id).css("display","none");
        }
        var msg = res.message;
        tanDialog(msg);
    }
</script>
@endsection

