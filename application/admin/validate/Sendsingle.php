<?php
namespace app\admin\validate;
use think\Validate;
class Sendsingle extends Validate
{
    protected $rule = [
        'phone' => 'require|length:0,11',
    ];
    protected $message = [
        'phone.require' => '手机号必须',
        'phone.length' => '手机号长度不对',
    ];
}
