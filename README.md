![](http://www.thinkphp.cn/Uploads/editor/2017-07-05/595d043d9ed5b.png)
![](http://www.thinkphp.cn/Uploads/editor/2017-07-05/595d0445b4fea.png)
![](http://www.thinkphp.cn/Uploads/editor/2017-07-05/595d044bb981d.png)

# 安装说明

### ① 下载源码包：
~~~
你可以通过多种方式下载源码（如HTTP下载，Git克隆），下载之后进入源码目录，使用 composer 安装PHP依赖，生成 .env 配置文件。

Linux 下可执行下面命令：

git clone https://github.com/chenbei360/laravel.rbac
cd laravel.rbac
composer install
touch .env
Windows 下生成 .env 文件可以在命令行输入下面命令：

echo. > .env
~~~

### ② 导入数据库，并修改 .env 配置文件：
~~~
请将源码包根目录下 cms.sql 导入数据库，默认使用 UTF-8 编码，utf8_unicode_ci作为排序规则。

请根据数据库与服务器实际情况修改 .env 配置文件，这里给出一个示例。

APP_ENV=local
APP_DEBUG=true
APP_KEY=RrQvzbUxaKIlj74s3hOYClGQ71zoVixr

DB_HOST=localhost
DB_DATABASE=cms
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

MAIL_DRIVER=smtp
MAIL_HOST=mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null

~~~

### ③ 服务器绑定域名，并将文档根目录设置为源码包 public 目录下，给 storage 目录可写权限。

#### ④ 访问服务器绑定的域名，如果能访问演示站类似的前台界面，说明您已经安装成功。

##### ⑤ 登录后台，后台使用的帐号与密码均为 admin，登入之后，您可以体验一番。

##### ⑥ 后台菜单设置方法请参考已有的那些菜单

>联系作者 
~~~
Email: 3279867796@qq.com 
官网：https://www.kancloud.cn/@tpcms
交流群：653354872
朕要体验：139.199.168.122:8888/admin  test123 test123
~~~
