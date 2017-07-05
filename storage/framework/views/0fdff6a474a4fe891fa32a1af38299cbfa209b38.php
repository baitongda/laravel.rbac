<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo e($tpltitle); ?>菜单(节点)</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' type='text/css' href='<?php echo e(asset("static/Admin/css/admin_style.css")); ?>' />
<script type="text/javascript" src="<?php echo e(asset("static/js/jquery.min.js")); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset("static/js/formValidator.js")); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset("static/js/formValidatorRegex.js")); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('static/Admin/js/function.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset("static/js/jquery.form.min.js")); ?>"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){
			window.top.art.dialog({content:msg,lock:true,width:250,height:100,ok:function(){$(obj).focus();}});
		},onsuccess:function () {
			ajax_form('myform');
			return false;
        }});
		$("#title").formValidator({onshow:"请输入菜单名称",onfocus:"请输入菜单名称"}).inputValidator({min:1,onerror:"菜单名称必须填写"});
		$("#name").formValidator({onshow:"请输入节点名称",oncorrect:"输入正确"}).regexValidator({regexp:"username",datatype:"enum",onerror:"节点名称不正确"});
		$("#data").formValidator({empty:true,onshow:"请输入访问参数或完整URL地址",onfocus:"如：?s=/xx/xx/xx 或 http://www.xxx.com",onCorrect:"输入正确"}).inputValidator({max:250,onerror:"描述不能超过250个字符,请确认"});
		$("#remark").formValidator({empty:true,onshow:"请输入你的描述",onfocus:"请输入你的描述"}).inputValidator({max:250,onerror:"描述不能超过250个字符,请确认"});
	});
</script>
</head>
<body>
		<?php if($info->id > 0): ?>
			<form action="<?php echo e(url('/admin/node/edit')); ?>" method="post" name="form" id="myform">
			<input type="hidden" name="id" value="<?php echo e($info['id']); ?>">
		<<?php else: ?>
			<form action="<?php echo e(url('/admin/node/add')); ?>" method="post" name="form" id="myform">
		<?php endif; ?>
			<?php echo e(csrf_field()); ?>

			<table width="98%" border="0" cellpadding="4" cellspacing="1" class="table">
				<tr class="table_title">
					<td colspan="4"><?php echo e($tpltitle); ?>菜单(节点)</td>
				</tr>
				<tr class="tr rt">
					<td width="100">上级菜单：</td>
					<td colspan="3" class="lt">
						<select name="pid">
							<?php echo $select_categorys; ?>

						</select>
					</td>
				</tr>
				<tr class="tr rt">
					<td width="100">菜单名称：</td>
					<td colspan="3" class="lt">
						<input type="text" name="title" id="title" style="width:200px" value="<?php echo e($info['title']); ?>">
					</td>
				</tr>
				<tr class="tr rt">
					<td >菜单类型：</td>
					<td colspan="3" class="lt">
						<select name="display">
							<option value="1" <?php if($info->id == 1): ?> selected=""  <?php endif; ?> >主菜单</option>
							<option value="2" <?php if($info->id == 2): ?>  selected=""  <?php endif; ?> >子菜单</option>
							<option value="0" <?php if($info->id == 0): ?>  selected=""  <?php endif; ?> >不显示</option>
						</select>
					</td>
				</tr>
				<tr class="tr rt">
					<td width="100">节点类型：</td>
					<td colspan="3" class="lt">
						<select name="level">
							<!--option value="1">应用级</option-->
							<option value="2" <?php if($info->level == 2): ?>  selected=""  <?php endif; ?> >模块</option>
							<option value="3" <?php if($info->level == 3): ?>  selected=""  <?php endif; ?> >方法</option>
							<option value="0" <?php if($info->level == 0): ?>  selected=""  <?php endif; ?> >非节点</option>
						</select>
					</td>
				</tr>
				<tr class="tr rt">
					<td width="100">节点名称：</td>
					<td colspan="3" class="lt">
						<input type="text" name="name" id="name" style="width:200px" value="<?php echo e($info->name); ?>">
					</td>
				</tr>
				<tr class="tr rt">
					<td >链接参数：</td>
					<td colspan="3" class="lt">
						<input type="text" name="data" id="data" style="width:400px" value="<?php echo e($info->data); ?>">
					</td>
				</tr>
				<tr class="tr rt">
					<td >节点状态：</td>
					<td colspan="3" class="lt">
						<input type="radio" class="radio" value="1" name="status"
							   <?php if($info->status == 1 || $info->status == ''): ?>  checked="" <?php endif; ?>>
							启用
							<input type="radio" class="radio" value="0" name="status"
								<?php if($info->status === '0' || $info->status === 0): ?> checked="" <?php endif; ?>>
							关闭
					</td>
				</tr>
				<tr class="tr rt">
					<td >备注说明：</td>
					<td colspan="3" class="lt">
						<input type="text" name="remark" id="remark" style="width:400px" value="<?php echo e($info->remark); ?>">
					</td>
				</tr>
	<tr class="tr lt">
		<td colspan="4">
			<input name="dosubmit" type="hidden"/>
			<?php if($info->id > 0): ?>
				<input class="bginput" type="submit"  value="修 改" >
			<?php else: ?>
				<input class="bginput" type="submit"  value="添 加">
			&nbsp;<?php endif; ?>
			<input class="bginput" type="button" onclick="javascript:history.back(-1);" value="返 回" ></td>
	</tr>
</table>
</form>
<?php echo $__env->make('admin.index_footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</body>
</html>