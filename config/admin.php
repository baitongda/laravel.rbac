<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: [apple] <3279867796@qq.com>
// +----------------------------------------------------------------------
return [
    'USER_AUTH_ON' => true,
    'USER_AUTH_TYPE' => 2,
    'USER_AUTH_KEY' => 'authId',
    'ADMIN_AUTH_KEY' => 'administrator',
    'USER_AUTH_MODEL' => 'user',
    'AUTH_PWD_ENCODER' => 'md5',
    'USER_AUTH_GATEWAY' => '/admin/login',
    'NOT_AUTH_MODULE' => 'Login,Public',
    'REQUIRE_AUTH_MODULE' => '',
    'NOT_AUTH_ACTION' => '',
    'REQUIRE_AUTH_ACTION' => '',
    'GUEST_AUTH_ON' => false,
    'GUEST_AUTH_ID' => 0,
    'RBAC_ROLE_TABLE' => 'tp_role',
    'RBAC_USER_TABLE' => 'tp_role_user',
    'RBAC_ACCESS_TABLE' => 'tp_access',
    'RBAC_NODE_TABLE' => 'tp_node',
    'SPECIAL_USER' => 'admin',
    'cms_name' => '管理系统',
    'cms_url' => 'http://t.cn/RoxRwSh',
    'cms_var' => '5.0.1'
];
?>