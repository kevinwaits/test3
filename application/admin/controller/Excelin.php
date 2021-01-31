<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-13
 * Time: 上午 11:03
 */

namespace app\admin\controller;

use think\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use think\Db;

class Excelin extends Controller
{

    public function excelin() {
            return $this->fetch();
    }

    public function excelin_do()
    {
        $file = request()->file('file');  //注意>>>这里的 file是 form里 input的name
        if (empty($file)) {
            $this->error('请选择上传文件');
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        if ($file) {
            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'uploads/excel/');
            if ($info) {
                $inputFileName = './uploads/excel/' . $info->getFilename();
                echo $inputFileName;
                //下面是把excel进入数组
                $spreadsheet = IOFactory::load($inputFileName);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                var_dump($sheetData);
                //上面是导入excel进入数组
//        导入之后dump($sheetData)如下
//        array (size=4)
//          1 =>
//          array (size=3)
//              'A' => string '名字' (length=6)
//              'B' => string '密码' (length=6)
//              'C' => string '工资' (length=6)
//          2 =>
//         array (size=3)
//               'A' => string 'kevin' (length=6)
//              'B' => string '123' (length=6)
//              'C' => string '5000' (length=6)
//           A  B  C 应该为字段名字
                //利用array_combine("前数组","后数组")可以替换后数组的键名;
                $newKey = ["name","pass","phone"];//把正确的字段写成一个数组  放在"前数组"
                for ($i = 2; $i < count($sheetData) + 1; $i++)  //循环刚导入形成的数组
                {
                    $arr_new[$i] = array_combine($newKey, $sheetData[$i]);
                }
//                dump($arr_new);   //完成
                Db::table('excel')->insertAll($arr_new);
//                $this->redirect("Admin/salary");
            } else {
                // >>上传失败获取错误信息
                echo $file->getError();
            }
        }
    }

}