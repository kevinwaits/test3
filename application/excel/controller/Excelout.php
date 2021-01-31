<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-29
 * Time: 上午 2:08
 */

namespace app\excel\controller;

use think\Db;
use think\Controller;
use app\excel\controller\Exceloutassistant;
class Excelout extends Controller
{
    public function show()
    {
        return $this->fetch();
    }

//    下面这个excel的导出借用了一个Php叫做exceloutassistant
    public function excel_out()
    {
        $excel = new Exceloutassistant();
        $orders = Db::table('excel')->select();

//设置表头：
        $head = ['订单id', '声音', '名字'];
//数据中对应的字段，用于读取相应数据：
        $keys = ['id', 'pass', 'name'];
        $excel->outdata('kevin', $orders, $head, $keys);
    }
}