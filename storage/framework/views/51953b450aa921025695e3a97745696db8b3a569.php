<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>后台角色管理-{$Think.config.cms_name}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel='stylesheet' type='text/css' href='<?php echo e(asset('static/Admin/css/admin_style.css')); ?>' />
	<script type="text/javascript" src="<?php echo e(asset('static/js/jquery.min.js')); ?>"></script>
	<script type="text/javascript" src="<?php echo e(asset("static/js/jquery.form.min.js")); ?>"></script>
	<script type="text/javascript" src="<?php echo e(asset('static/Admin/js/function.js')); ?>"></script>
	<style>td{ height:22px; line-height:22px}</style>
</head>
<body>
	<form action="<?php echo e(url('/admin/user/role_sort')); ?>" method="post" name="form" id="myform" onsubmit="ajax_form('myform');return false;">
	<?php echo e(csrf_field()); ?>

	<table width="98%" border="0" cellpadding="5" cellspacing="1" class="table">
		<tr>
			<td colspan="6" class="table_title">
				<span class="fl">后台角色管理</span>
				<span class="fr">
					<a href="<?php echo e(url('/admin/user/role_add')); ?>">添加角色</a>
				</span>
			</td>
			<tr class="list_head ct">
				<td width="70">排序权重</td>
				<td width="70">ID</td>
				<td width="350">角色名称</td>
				<td >角色描述</td>
				<td width="70">状态</td>
				<td width="200">管理操作</td>
			</tr>
		<?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr class='<?php if($loop->iteration % 2 == 1 ): ?> tr <?php else: ?> ji <?php endif; ?>'>
				<td align='center'>
					<input type='text' value='<?php echo e($vo->sort); ?>' size='3' name='sort[<?php echo e($vo->id); ?>]'></td>
				<td align='center'><?php echo e($vo->id); ?></td>
				<td ><?php echo e($vo->name); ?></td>
				<td ><?php echo e($vo->remark); ?></td>
				<td align='center'><?php if($vo['status'] == 1): ?><font color="red">√</font><?php else: ?><font color="blue">×</font><?php endif; ?>
				</td>
				<td align='center'>
					<a href="javascript:setting_access(<?php echo e($vo->id); ?>, '<?php echo e($vo->name); ?>')">权限设置</a>
					| <a href="<?php echo e(url('/admin/user/role_edit/'. $vo['id'])); ?>">修改</a>
					| <a href="javascript:void(0)" onclick="return confirmurl('<?php echo e(url('/admin/user/role_del/' . $vo['id'])); ?>','确定删除该角色吗?',true)">删除</a>
				</td>
			</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<tr class="tr">
          <td colspan="6" valign="middle">
            <input type="submit" value="排序" class="bginput" />
          </td>
        </tr>
		</table>
	</form>
		<script>var version='<?php echo e(config('cms.cms_var')); ?>';</script>
		<?php echo $__env->make('admin.index_footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</body>
<script type="text/javascript">
//权限设置
function setting_access(id, name) {
	window.top.art.dialog.open('<?php echo e(url('/admin/user/access')); ?>' + '/' +id,{title: name+'权限设置', width: 600, height: 500});
}
</script>
</html>