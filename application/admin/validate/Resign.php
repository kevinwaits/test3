<?php
namespace app\admin\validate;
use think\Validate;
class Resign extends Validate
{
    protected $rule = [
        'phone' => 'require|length:0,20',
        'pass' => 'require|length:0,20',
    ];
    protected $message = [
        'phone.require' => '用户名必须',
        'pass.require' => '密码必须',
    ];
}
