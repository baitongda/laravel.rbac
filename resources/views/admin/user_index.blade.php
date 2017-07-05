<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>后台用户管理-{{ config('cms.cms_name') }}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel='stylesheet' type='text/css' href='{{ asset("static/Admin/css/admin_style.css")}}' />
	<script type="text/javascript" src='{{ asset("static/js/jquery.min.js")}}'></script>
	<script type="text/javascript" src='{{ asset("static/Admin/js/function.js")}}'></script>
	<style>td{ height:22px; line-height:22px}</style>
</head>
<body>
	<table width="98%" border="0" cellpadding="9" cellspacing="1" class="table">
		<tr>
			<td colspan="9" class="table_title">
				<span class="fl">后台用户管理</span>
				<span class="fr">
					<a href="{{ url('/admin/user/add') }}">添加用户</a>
				</span>
			</td>
			<tr class="list_head ct">
				<td width="70">ID</td>
				<td width="150">用户名称</td>
				<td width="150">角色名称</td>
				<td >用户描述</td>
				<td width="100">最后登录IP</td>
				<td width="150">最后登录位置</td>
				<td width="150">最后登录时间</td>
				<td width="70">状态</td>
				<td width="100">管理操作</td>
			</tr>
		@foreach ($list as $vo)
			<tr class='@if($loop->iteration % 2 == 1 ) tr @else ji @endif'>
				<td align='center'>{{$vo->id}}</td>
				<td >{{$vo->username}}</td>
				<td >{{$role[$vo['role']]}}</td>
				<td >{{$vo->remark}}</td>
				<td align='center'>{{$vo->last_login_ip}}</td>
				<td align='center'>{{$vo->last_location}}</td>
				<td align='center'>{!! get_color_date('Y-m-d H:i:s', $vo['last_login_time']) !!}</td>
				<td align='center'>
					@if ($vo['status'] == 1) <font color="red">√</font>
					@else<font color="blue">×</font>
					@endif
				</td>
				<td align='center'>
					<a href="{{ url('/admin/user/edit',array('id'=>$vo['id'])) }}">修改</a>
					|
					@if ($vo['username'] == config('admin.SPECIAL_USER'))
						<font color="#cccccc">删除</font>
					@else
						<a href="javascript:void(0)" onclick="return confirmurl('{{url('/admin/user/del/'. $vo['id'])}}','确定删除该用户吗?',true)">删除</a>
					@endif
				</td>
			</tr>
		@endforeach

		<tr class="tr">
          <td colspan="9" class="pages">
			  {{$list->links()}}
          </td>
        </tr>
		</table>
		<script>var version="{{config('admin.cms_var')}}";</script>
		@include('admin.index_footer')
</body>
	</html>