<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>管理登录-{{ config('cms.cms_name') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel='stylesheet' type='text/css' href='{{ asset("static/Admin/css/admin_login.css") }}'>
    <script type="text/javascript" src="{{ asset("static/js/jquery.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("static/js/artDialog/jquery.artDialog.js?skin=default") }}"></script>
    <script type="text/javascript" src="{{ asset("static/js/artDialog/plugins/iframeTools.js") }}"></script>
    <script type="text/javascript" src="{{ asset("static/admin/js/function.js") }}"></script>
    <script>
        function loginok(form){
            if (form.login_name.value==""){
                alert("用户名不能为空！");
                form.login_name.focus();
                return (false);
            }
            if (form.login_pwd.value==""){
                alert("密码不能为空！");
                form.login_pwd.focus();
                return (false);
            }
            if (form.verify.value==""){
                alert("验证码不能为空！");
                form.verify.focus();
                return (false);
            }
            return (true);
        }

        if(self!=top){
            top.location=self.location;
        }

        $(function () {
            @if (isset($errors) && count($errors) > 0 )
                art.dialog({
                content: '{{ $errors->all()[0] }}',
                icon: 'error',
                ok: function(){}
            }).lock().time(2);
                @elseif(!empty(session('success'))) {
                art.dialog({
                    content: '{{session('success')}}',
                    icon: 'succeed',
                    ok: function(){}
                }).lock().time(2);
            }
            @endif
        })
    </script>
</head>
<body>
<div class="main">
    <div class="title"></div>
    <div class="login">
        <form action="{{ url('admin/login/checkLogin') }}" method="post" name="cms" onSubmit="return loginok(this)">
            {{  csrf_field() }}
            <div class="inputbox">
                <dl>
                    <dd>{{ trans('rbac.lan_username') }}：</dd>
                    <dd>
                        <input type="text" name="username" value="{{ old('username') }}" id="login_name" size="15" onfocus="this.style.borderColor='#fc9938'" onblur="this.style.borderColor='#dcdcdc'" />
                    </dd>
                    <dd>{{ trans('rbac.lan_password')}}：</dd>
                    <dd>
                        <input type="password" name="password" value="{{ old('password') }}" id="login_pwd" size="15" onfocus="this.style.borderColor='#fc9938'" onblur="this.style.borderColor='#dcdcdc'" />
                    </dd>
                    <dd>{{ trans('rbac.lan_verify')}}：</dd>
                    <dd>
                        <input type="text" name="verify" value="{{ old('verify') }}" id="verify" size="3" onfocus="this.style.borderColor='#fc9938'" onblur="this.style.borderColor='#dcdcdc'" />
                        <img id="verifyImg" SRC="{{ url('admin/public/verify') }}" onclick='this.src=this.src+"?"+Math.random()' BORDER="0" ALT="点击刷新验证码" style="cursor:pointer" align="absmiddle">
                    </dd>
                    <dd>
                        <input name="submit" type="submit" value="" class="input" />
                    </dd>
                </dl>
            </div>
            <div class="butbox">
                <dl>
                    <dd>{{  config('cms.cms_name') }}是一个采用PHP和MYSQL数据库构建的高效的管理系统</dd>
                </dl>
            </div>
            <div style="clear:both"></div>
        </form>
    </div>
</div>
<div class="copyright">
    Powered by <a href="{{  config('cms.cms_url') }}" target="_blank">{{  config('cms.web_name') }}&nbsp;{{  config('cms.cms_var') }}</a>&nbsp;Copyright&nbsp;&copy;2011-2012
</div>
</body>
</html>