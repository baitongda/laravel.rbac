<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>菜单管理-<?php echo e(config('cms.cms_name')); ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel='stylesheet' type='text/css' href='<?php echo e(asset('static/Admin/css/admin_style.css')); ?>' />
  <script type="text/javascript" src="<?php echo e(asset('static/js/jquery.min.js')); ?>"></script>
  <script type="text/javascript" src="<?php echo e(asset('static/Admin/js/function.js')); ?>"></script>
  <script type="text/javascript" src="<?php echo e(asset("static/js/jquery.form.min.js")); ?>"></script>
  <style>td{ height:22px; line-height:22px}</style>

</head>
<body>
  <form action="<?php echo e(url('/admin/node/sort')); ?>" method="post" name="form" id="myform" onsubmit="ajax_form('myform');return false;">
   <?php echo e(csrf_field()); ?>

  <table width="98%" border="0" cellpadding="5" cellspacing="1" class="table">
      <tr>
        <td colspan="7" class="table_title">
          <span class="fl">后台菜单(节点)管理</span>
          <span class="fr">
            <a href="<?php echo e(url('/admin/node/add')); ?>">添加菜单(节点)</a>
          </span>
        </td>
        <tr class="list_head ct">
          <td width="70">排序权重</td>
          <td width="70">ID</td>
          <td >菜单名称</td>
          <td width="70">类型</td>
          <td width="70">状态</td>
          <td width="70">显示</td>
          <td width="200">管理操作</td>
        </tr>
        <?php echo $html_tree; ?>

        <tr class="tr">
          <td colspan="7" valign="middle">
            <input type="submit" value="排序" class="bginput" />
          </td>
        </tr>
    </table>
  </form>
    <script>var version='<?php echo e(config('cms.cms_var')); ?>';</script>
    <?php echo $__env->make('admin.index_footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</body>
  </html>