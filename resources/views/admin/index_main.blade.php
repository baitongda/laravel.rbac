<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>环境检测-{$Think.config.cms_name}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel='stylesheet' type='text/css' href='{{ asset('static/Admin/css/admin_style.css') }}'>
    <script type="text/javascript" src="{{ asset('static/js/jquery.min.js') }}"></script>
    <style>td{ height:22px; line-height:22px}</style>
</head>
<body>
<table width="98%" border="0" cellpadding="4" cellspacing="1" class="table">
    <tr class="table_title">
        <td colspan="2">系统环境检测：</td>
    </tr>
    <tr class="ji">
        <td width="200">主机名 (IP：端口)：</td>
        <td ><?php echo $_SERVER['SERVER_NAME'].' ('.$_SERVER['SERVER_ADDR'].':'.$_SERVER['SERVER_PORT'].')';?></td>
    </tr>
    <tr class="ou">
        <td>程序目录：</td>
        <td>{{ config('cms.web_path')}}</td>
    </tr>
    <tr class="ji">
        <td>Web服务器：</td>
        <td>{{ $_SERVER['SERVER_SOFTWARE']}}</td>
    </tr>
    <tr class="ou">
        <td>PHP 运行方式：</td>
        <td>{{ PHP_SAPI }}</td>
    </tr>
    <tr class="ji">
        <td>PHP版本：</td>
        <td>{{ PHP_VERSION }}</td>
    </tr>
    <tr class="ou">
        <td>MySQL 版本：</td>
        <td><?php if (function_exists("mysql_close")) {
                echo mysql_get_client_info();
            }else{
                echo '不支持';
            }?>&nbsp;&nbsp;</td>
    </tr>
    <tr class="ji">
        <td>GD库版本：</td>
        <td><?php
            if(function_exists('gd_info')){
                $gd = gd_info();
                echo $gd['GD Version'];
            }else{
                echo "不支持";
            }
            ?></td>
    </tr>
    <tr class="ou">
        <td>最大上传限制：</td>
        <td><?php if (ini_get('file_uploads')) {
                echo ini_get('upload_max_filesize');
            }else{
                echo '<span style="color:red">Disabled</span>';
            }?></td>
    </tr>
    <tr class="ji">
        <td>最大执行时间：</td>
        <td><?php echo ini_get('max_execution_time')?>秒</td>
    </tr>
    <tr class="ou">
        <td>采集函数检测：</td>
        <td><?php if (ini_get('allow_url_fopen')) {
                echo '支持';
            }else{
                echo '<span style="color:red">不支持</span>';
            }?></td>
    </tr>
</table>
<script>var version='{{ config('cms.cms_var') }}';</script>
@include('admin.index_footer')
</body>
</html>