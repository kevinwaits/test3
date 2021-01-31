<?php

namespace app\resign\validate;
use think\Validate;

class Resign extends Validate
{
    protected $rule = [
        'name' => 'require|length:0,20',
        'pass' => 'require',
        'captcha'=>'require'
    ];

    protected $message = [
        'name.require' => '用户名555称必须',
        'name.length' => '用户名长度',
        'captcha.require'=>"验证码必须",
        'pass.require' => 'kevin密码必须',
    ];

}