<?php
namespace app\admin\validate;
use think\Validate;
class User extends Validate
{
    protected $rule = [
        'name' => 'require|length:0,20',
        'pass' => 'require|length:0,20',
    ];
    protected $message = [
        'name.require' => '用户名必须',
        'name.length' => 'kevin账户长度',
        'pass.require' => 'kevin密码必须',
        'pass.length' => 'kevin密码长度',
    ];
}
