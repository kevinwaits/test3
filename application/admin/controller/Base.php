<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-03-27
 * Time: 下午 12:58
 */

namespace app\admin\controller;
use think\Controller;
use think\Session;
class Base extends Controller
{
    public function _initialize()
    {
        $this->check();
    }

    private function check()
    {
        if (Session::get('name')) {
        } else {
            $this->redirect('admin/Baselogin/baselogin');
        }
    }

}
//三大块,1,一个固定的base,这个就是检查是否有session,如果有的话,没事,如果没有的话,跳转登录页面
//三大块 2 ,baselogin 就是上面说的登录页面,登录写入 session,注意::这个不要继承base了,否则没完了
//三大块 3, baserun, 就是普通的业务页面,这个页面是继承base的, 如果没有session的名字,那么会跳转.
