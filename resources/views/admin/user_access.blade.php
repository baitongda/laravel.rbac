<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>权限设置</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel='stylesheet' type='text/css' href='{{ asset('static/Admin/css/admin_style.css') }}' />
	<script type="text/javascript" src="{{ asset('static/js/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('static/js/treetable/jquery.treetable.js') }}"></script>
	<link rel='stylesheet' type='text/css' href='{{ asset('static/js/treetable/css/jquery.treeTable.css') }}' />
    <script type="text/javascript" src="{{ asset("static/js/jquery.form.min.js")}}"></script>
    <script type="text/javascript" src="{{asset('static/Admin/js/function.js')}}"></script>
</head>
<body>
	<form action="{{url('/admin/user/access_edit')}}" method="post" name="form" id="form" onsubmit="ajax_form('form');return false;">
        {{  csrf_field() }}
		<input type="hidden" name="roleid" value="{{$roleid}}" />
		<table id="tree" width="100%" border="0" cellpadding="4" cellspacing="1" class="table">
			{!! $html_tree !!}
			<tr class="tr lt">
				<td>
					<input class="bginput" type="submit" name="dosubmit" value="提 交" ></td>
			</tr>
		</table>
	</form>
</body>
	<script type="text/javascript">
  $(document).ready(function() {
  	//树配置
    $("#tree").treeTable({
    	expandable: true,
    });

   });

function checknode(obj)
  {
      var chk = $("input[type='checkbox']");
      var count = chk.length;
      var num = chk.index(obj);
      var level_top = level_bottom =  chk.eq(num).attr('level')
      for (var i=num; i>=0; i--)
      {
              var le = chk.eq(i).attr('level');
              if(eval(le) < eval(level_top)) 
              {
                  chk.eq(i).attr("checked",'checked');
                  var level_top = level_top-1;
              }
      }
      for (var j=num+1; j<count; j++)
      {
              var le = chk.eq(j).attr('level');
              if(chk.eq(num).attr("checked")=='checked') {
                  if(eval(le) > eval(level_bottom)) chk.eq(j).attr("checked",'checked');
                  else if(eval(le) == eval(level_bottom)) break;
              }
              else {
                  if(eval(le) > eval(level_bottom)) chk.eq(j).attr("checked",false);
                  else if(eval(le) == eval(level_bottom)) break;
              }
      }
  }
</script>
</html>