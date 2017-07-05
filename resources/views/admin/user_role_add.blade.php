<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{{$tpltitle}}后台角色</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' type='text/css' href='{{asset('static/Admin/css/admin_style.css')}}' />
<script type="text/javascript" src="{{asset('static/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('static/js/formValidator.js')}}"></script>
<script type="text/javascript" src="{{ asset("static/js/jquery.form.min.js")}}"></script>
<script type="text/javascript" src="{{asset('static/Admin/js/function.js')}}"></script>

	<script type="text/javascript">
	$(document).ready(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){
			window.top.art.dialog({content:msg,lock:true,width:250,height:100,ok:function(){$(obj).focus();}});
		},onsuccess:function(){ajax_form('myform');return false;}});
		$("#name").formValidator({onshow:"请输入角色名称",onfocus:"请输入角色名称"}).inputValidator({min:1,onerror:"菜单名称必须填写"});
		$("#remark").formValidator({empty:true,onshow:"请输入你的描述",onfocus:"请输入你的描述"}).inputValidator({max:250,onerror:"描述不能超过250个字符,请确认"});
	});
</script>
</head>
<body>
		@if($info['id'] > 0)
			<form action="{{url('/admin/user/role_edit')}}" method="post" name="form" id="myform">
			<input type="hidden" name="id" value="{{$info->id}}">
		@else
			<form action="{{url('/admin/user/role_add')}}" method="post" name="form" id="myform">
		@endif
				{{  csrf_field() }}
			<table width="98%" border="0" cellpadding="4" cellspacing="1" class="table">

				<tr class="table_title">
					<td colspan="4">{{$tpltitle}}后台角色</td>
				</tr>

				<tr class="tr rt">
					<td width="100">角色名称：</td>
					<td colspan="3" class="lt">
						<input type="text" name="name" id="name" style="width:200px" value="{{$info->name}}">
					</td>
				</tr>
				<tr class="tr rt">
					<td >角色状态：</td>
					<td colspan="3" class="lt">
						<input type="radio" class="radio" value="1" name="status" @if ($info['status'] == 1 || $info['status'] == '') checked="" @endif >
							启用
							<input type="radio" class="radio" value="0" name="status" @if($info['status'] === 0 ||  $info['status'] === '0') checked="" @endif >
							关闭
					</td>
				</tr>
				<tr class="tr rt">
					<td >备注说明：</td>
					<td colspan="3" class="lt">
						<input type="text" name="remark" id="remark" style="width:400px" value="{{$info->remark}}">
					</td>
				</tr>
	<tr class="tr lt">
		<td colspan="4">
			<input name="dosubmit" type="hidden"/>
			@if($info['id'] > 0)
				<input class="bginput" type="submit" name="dosubmit" value="修 改" >
			@else
				<input class="bginput" type="submit" name="dosubmit" value="添 加">@endif
			&nbsp;
			<input class="bginput" type="button" onclick="javascript:history.back(-1);" value="返 回" ></td>
	</tr>
</table>
</form>
<include file="index:footer" />
</body>
</html>