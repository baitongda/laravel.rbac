<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{{$tpltitle}}后台用户</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' type='text/css' href='{{ asset("static/Admin/css/admin_style.css") }}' />
<script type="text/javascript" src='{{ asset("static/js/jquery.min.js") }}'></script>
<script type="text/javascript" src='{{ asset("static/js/formValidator.js") }}'></script>
<script type="text/javascript" src="{{ asset("static/js/jquery.form.min.js")}}"></script>
<script type="text/javascript" src="{{asset('static/Admin/js/function.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){
			window.top.art.dialog({content:msg,lock:true,width:250,height:100,ok:function(){$(obj).focus();}});
		},onsuccess:function(){ajax_form('myform');return false;}});
		$("#username").formValidator({onshow:"请输入用户名",onfocus:"用户名至少3个字符,最多50个字符",oncorrect:"输入正确"}).inputValidator({min:3,empty:{leftempty:false,rightempty:false,emptyerror:"两边不能有空符号"},onerror:"你输入的用户名非法,请确认"})
		    .ajaxValidator({
			datatype : "json",
			async : true,
			type: "GET",
			url : "{{ url('/admin/user/check_username/' . $info->id)}}",
			success : function(data){
	            if( data == "0" ){
	            	return true;
	            }else{
	            	return false;
	            }
			},
			error: function(){
				window.top.art.dialog({content:"服务器没有返回数据，可能服务器忙，请重试",lock:true,width:250,height:100,ok:function(){}});
			},
			onerror : "该用户名已存在，请更换",
			onwait : "用户名校验中..."
		}) @if($info['id']) .defaultPassed() @endif;
		$("#password").formValidator({@if($info['id'])empty:true,@endif onshow:"请输入密码",onfocus:"至少6个长度",oncorrect:"密码合法"}).inputValidator({min:6,empty:{leftempty:false,rightempty:false,emptyerror:"密码两边不能有空符号"},onerror:"密码不能为空,请确认"});
		$("#repassword").formValidator({@if($info['id'])empty:true,@endif onshow:"输再次输入密码",onfocus:"至少6个长度",oncorrect:"密码一致"}).inputValidator({min:6,empty:{leftempty:false,rightempty:false,emptyerror:"重复密码两边不能有空符号"},onerror:"重复密码不能为空,请确认"}).compareValidator({desid:"password",operateor:"=",onerror:"两次密码不一致,请确认"});
		$("#remark").formValidator({empty:true,onshow:"请输入你的描述"}).inputValidator({max:250,onerror:"描述不能超过250个字符,请确认"});

	});
</script>
</head>
<body>
		@if($info->id > 0)
			<form action="{{ url('/admin/user/edit')}}" method="post" name="form" id="myform">
			<input type="hidden" name="id" value="{{$info['id']}}">
		@else
			<form action="{{url('/admin/user/add')}}" method="post" name="form" id="myform">
		@endif;
			{{  csrf_field() }}

			<table width="98%" border="0" cellpadding="4" cellspacing="1" class="table">
				<tr class="table_title">
					<td colspan="4">{{$tpltitle}}后台用户</td>
				</tr>

				<tr class="tr rt">
					<td width="100">用户名称：</td>
					<td colspan="3" class="lt">
						<input type="text" name="username" id="username" style="width:200px" value="{{$info->username}}" @if($info['username' == config('cms.SPECIAL_USER')]) readonly="readonly" @endif>
					</td>
				</tr>
				<tr class="tr rt">
					<td width="100">密　　码：</td>
					<td colspan="3" class="lt">
						<input type="password" name="password" id="password" style="width:200px" value="">
					</td>
				</tr>
				<tr class="tr rt">
					<td width="100">确认密码：</td>
					<td colspan="3" class="lt">
						<input type="password" name="repassword" id="repassword" style="width:200px" value="">
					</td>
				</tr>
				<tr class="tr rt">
					<td width="100">用户角色：</td>
					<td colspan="3" class="lt">
						<select name="role">
							@foreach($role as $vo)
								<option value="{{$vo->id}}" @if($vo->id == $info->role)selected=""@endif >{{$vo->name}}</option>
							@endforeach;
						</select>
					</td>
				</tr>
				<tr class="tr rt">
					<td >用户状态：</td>
					<td colspan="3" class="lt">
						<input type="radio" class="radio" value="1" name="status" id="status1" @if($info['status'] == 1|| $info['status'] == '') checked=""@endif >
							启用
							<input type="radio" class="radio" value="0" name="status" id="status2" @if($info['status'] === 0 || $info['status'] === '0') checked="" @endif >
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
				<input class="bginput" type="submit"  value="修 改" >
			@else
				<input class="bginput" type="submit"  value="添 加"></gt>
			@endif
			&nbsp;
			<input class="bginput" type="button" onclick="javascript:history.back(-1);" value="返 回" ></td>
	</tr>
</table>
</form>
@include('admin.index_footer')
</body>
</html>