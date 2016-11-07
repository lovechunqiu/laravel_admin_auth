@extends('layouts.admin')
@section('content')
<style type="text/css">
    .lineD dt b{color:#0C0}
    body{background-image:none;}
    .mark{padding:5px 10px;border:1px dashed #e5e5e5;background:#fcf8e3;border-radius:3px;margin-bottom:3px;}
</style>
<div class="pubheit"></div>
<div class="so_main">
    <div class="page_tit1"><h5><i class="icon-text-height"></i>用户级权限配置</h5></div>
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
    <div class="form2" style="border:1px solid #D5D5D5">
        <form method="post" action="{{url('admin/auth/' . $field->id)}}">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="put">
            <dl class="lineD">
                <dt class="t">用户组名称：</dt>
                <dd><input type="text" name="groupname" id="groupname" class="input" value="{{$field->groupname}}" /></dd>
            </dl>

            @foreach($auth_list as $ke => $vo)

                <dl class="lineD">
                    <dt class="t"><b>{{$vo['low_title']['0']}}</b></dt>
                    <dd>请选择相关权限<input type="checkbox" onclick="select_all('fa{{$ke}}');" id="fa{{$ke}}" /><label for="fa{{$ke}}">全选</label></dd>
                </dl>

                @foreach($vo['low_leve'] as $fmodel => $vs)
                    @foreach($vs as $keyname => $item)
                        @if($keyname != "data")
                            <dl class="lineD">
                                <dt>{{$keyname}}：</dt>
                                <dd>
                                    @foreach($item as $itemname => $itemkey)
                                        <input data="fa{{$ke}}_son" type="checkbox" name="model[{{$fmodel}}][]" @if(isset($field['controller'][$fmodel]) && ($field['controller'][$fmodel]) && array_keys($field['controller'][$fmodel],$itemkey)) checked="checked" @endif class="check" value="{{$itemkey}}" id="{{$fmodel . $itemkey}}"><label for="{{$fmodel . $itemkey}}">{{$itemname}}</label>
                                    @endforeach
                                </dd>
                            </dl>
                        @endif
                    @endforeach
                @endforeach
            @endforeach

            <div class="form-actions align-left" style="border:none;">
                <input class="btn btn-primary" type="submit" value="提交">
                <input type="button" class="btn btn-primary" value="返回" onclick="javascript:history.back();"/>
            </div>

        </form>
    </div>

</div>
<script>

    function select_all(id){
        var se = id+"_son";
        if($("#"+id).attr('checked')){
            $("input:[data="+se+"]").each(function(i,obj){
                obj.checked = true;
            });
        }else{
            $("input:[data="+se+"]").each(function(i,obj){
                obj.checked = false;
            });
        }

    }
    $(document).ready(function(){
        $(".lineD").mouseover(function(){
            $(this).find(".a_del").css("display","block")
        })
        $(".lineD").mouseleave(function(){
            $(this).find(".a_del").css("display","none")
        })
    });
</script>
@endsection