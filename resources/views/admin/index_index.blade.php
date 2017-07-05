<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <TITLE>管理中心-{{ config('cms.cms_name') }}</TITLE>
    <META content="text/html; charset=utf-8" http-equiv=Content-Type>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <link rel='stylesheet' type='text/css' href='{{ asset("/static/Admin/css/admin_index.css")}}'>
    <link rel='stylesheet' type='text/css' href='{{ asset("/static/Admin/css/admin_top.css")}}'>
    <link rel='stylesheet' type='text/css' href='{{ asset("/static/Admin/css/admin_style.css")}}'>
    <script type="text/javascript" src="{{ asset("/static/js/jquery.min.js")}}"></script>
    <script type="text/javascript" src="{{ asset("/static/js/artDialog/jquery.artDialog.js?skin=default")}}"></script>
    <script type="text/javascript" src="{{ asset("/static/js/artDialog/plugins/iframeTools.js")}}"></script>

    <script type="text/javascript" src="{{ asset("/static/js/toast/jquery.toast.js")}}"></script>
    <link rel='stylesheet' type='text/css' href='{{ asset("/static/js/toast/jquery.toast.css")}}'>

    <style type="text/css">
        html{_overflow-y:scroll}
    </style>
    <script language="JavaScript1.2">if(self!=top){top.location=self.location;}</script>
</head>
<body  scroll='no'  >


<div class="topnav">
    <div class="sitenav">
        <div class=welcome>您好：<span class="username">{{session('username')}} </span>，欢迎使用{{ config('cms.cms_name') }}！ </div>
        <div class=sitelink><a href="{{ url('admin/index/index') }}" target="_parent">后台首页</a> | <a href="{{ config('cms.web_url') }}" target="_blank">网站主页</a> | <a href="{{ config('cms.cms_ur') }}" target="_blank">官方网站</a> | <a class="top-txt" href="{{ url('admin/cache/delcore') }}" target="frmright" id="delcache">更新缓存</a><a id="cache"></a></div>
    </div>
    <div class="leftnav">
        <ul>
            <li class="navleft"></li>
            <?php $i = 1;?>
            @foreach ($main_menu as $vo)
                <?php
                if($i == 1){	//设置首菜单ID
                    $first_menu_id = $vo->id;
                }
                ?>
                <li id="d{{$i}}" @if($i == 1) class="thisclass" @else  @endif onClick="ConClass({{ $i }});"><a href="{{ url('/admin/index/left/'.$vo->id)}}" target="leftfra" >{{$vo->title}}</a></li>
            <?php $i++; ?>
            @endforeach
            <li id="logout" style="margin-right: -1px"><a href="{{  url('admin/login/logout') }}" target="_parent">注销登录</a></li>
            <li class="navright"></li>
        </ul>
    </div>
</div>



<div id="Maincontent">
    <div id="leftMenu">
        <iframe src="{{ url('/admin/index/left/' . $first_menu_id)}}" id="leftfra" name="leftfra" frameborder="0" scrolling="no"  style="border:none" width="100%" height="100%" ></iframe>
    </div>


    <div id="mainNav">
        <div class="cur_position"><div class="cur">当前位置：<span id='current'></span><span id='sub_current'></span></div></div>

        <div class="mframe">
            <iframe name="main" id="main" src="{{ url('/admin/index/main') }}" frameborder="false" scrolling="auto" style="border:none; margin-bottom:10px;"  width="100%" height="auto" ></iframe>
        </div>

    </div>
</div>
<script type="text/javascript">
    //clientHeight-0; 空白值 iframe自适应高度
    function windowW(){
        if($(window).width()<980){

            $('#Maincontent').css('width',980+'px');
            $('body').attr('scroll','');
            $('body').css('overflow','');
        }
    }
    windowW();
    $(window).resize(function(){
        if($(window).width()<980){
            windowW();
        }else{
            $('#Maincontent').css('width','auto');
            $('body').attr('scroll','no');
            $('body').css('overflow','hidden');

        }
    });
    window.onresize = function(){
        var heights = document.documentElement.clientHeight-150;document.getElementById('main').height = heights;
        var openClose = $("#main").height()+39;
    }
    window.onresize();


    $(document).ready(function(){
        $("#delcache").click(function(){
            $ajaxurl = $(this).attr('href');
            $.get($ajaxurl,null,function(data){
                $("#cache").show();
                $("#cache").html(' <font color=#ff0000>'+data+'</font>');
                window.setTimeout(function(){
                    $("#cache").hide();
                },2000);
            });
            return false;
        });
        $("#cache").click(function(){
            $("#cache").hide();
            return false;
        });
    });

    function left(url){
        leftfra.show(url);
    }

    function ConClass(id){
        var i,max;
        max = '{{$i}}';
        if(max == false) {max = 10;}
        var str=$('#d'+id).text()+' > ';
        for(i=1;i<=max;i++){
            if (id==i) {
                $('#d'+i).addClass('thisclass');
            }else{
                $('#d'+i).removeClass('thisclass');
            }
        }
        $('#sub_current').html('');
        $('#current').html(str);
    }


</script>

</body>

</html>