<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-29
 * Time: 上午 1:45
 */

namespace app\excel\controller;

use think\Controller;

class Excelin extends Controller
{
    public function show() {
            return $this->fetch();
    }

    public function excel_rec()
    {
//        这个步骤是特例,可以删除,意思是如果没有填写月,就不准上传
        $month = $this->request->post("month");
        if (empty($month)) {
            $this->error('请填写年月');
        }
//        这个步骤是特例,可以删除,意思是如果没有填写月,就不准上传

        $file = request()->file('file');  //注意这里的 file是 form里 input的name
        if (empty($file)) {
            $this->error('请选择上传文件');
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        if ($file) {
            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'uploads/excel');
            if ($info) {
//                echo $info->getExtension();
                //<<获取后缀
//                echo $info->getSaveName();
                //<<获取文件名字,和下面一个一样的,我不知道区别
//                echo $info->getFilename();
                //<<获取文件名字,和下面一个一样的,我不知道区别
                //######下面是导入excel进入数组
                $inputFileName = './public/uploads/excel/' . $info->getFilename();
//                echo $inputFileName;
                $spreadsheet = IOFactory::load($inputFileName);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
//                dump($sheetData);
                //######上面是导入excel进入数组
//        导入之后dump($sheetData)如下
//        array (size=4)
//          1 =>
//          array (size=3)   //表格第一行
//              'A' => string '名字' (length=6)
//              'B' => string '密码' (length=6)
//              'C' => string '工资' (length=6)
//          2 =>
//         array (size=3)    //表格第二行
//              'A' => string 'kevin' (length=6)
//              'B' => string '123' (length=6)
//              'C' => string '5000' (length=6)
//          实际上 A  B  C 应该是对应数据库里的字段名字,所以要批量替换A B  C
//
                //利用array_combine("前数组","后数组")可以替换后数组的键名;
                $newKey = [ "no", "name","license", "phone","should", "tax", "base","overwork","superwork",
                    "temple", "bonus", "quality",  "late", "withhold",
                    "old", "medicine", "unemployment","hot", "load", "custom_1", "custom_2", "custom_3","real_salary"
                ];//把正确的字段写成一个数组  放在"前数组"
                for ($i = 2; $i < count($sheetData) + 1; $i++)  //循环刚导入形成的数组
                {
                    $arr_new[$i] = array_combine($newKey, $sheetData[$i]);
                }
//                dump($arr_new);   //完成
                Db::table('ningbo_salary')->insertAll($arr_new);
//                到此为止 excel导入完成

            } else {
                // >>上传失败获取错误信息
                echo $file->getError();
            }
        }
    }
}