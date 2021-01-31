<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-02-08
 * Time: 下午 2:48
 */

namespace app\admin\validate;
use think\Validate;

class AdminValidate extends Validate
{
    protected $rule = [
        'name' => 'require|length:0,20',
        'pass' => 'require',
    ];

    protected $message = [
        'name.require' => '用户名称必须',
        'name.length' => '用户名长度',
        'pass.require' => 'kevin密码必须',
    ];
}