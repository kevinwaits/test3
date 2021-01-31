<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-13
 * Time: 下午 4:18
 */

namespace app\admin\controller;

use think\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use think\Db;
use app\vital\Excel;
class Excelout extends Controller
{

    public function excelout()
    {
        return $this->fetch();
    }

    //下面这个excelout_standar是phpoffice的标准写法,这个写法只能一个一个对单元格内容做更改
    //如果想把一个数组写入excel里并且导出的话,需要用到循环,我不会
    public function excelout_standar()
    {
        $data = Db::table('excel')->select();

        $spreadsheet = new Spreadsheet();

// Set document properties
        $spreadsheet->getProperties()->setCreator('Maarten Balliauw')
            ->setLastModifiedBy('Maarten Balliauw')
            ->setTitle('Office 2007 XLSX Test Document')
            ->setSubject('Office 2007 XLSX Test Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Test result file');
// Add some data
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');
// Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Simple');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="01simple.xlsx"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;

    }

    //下面的这个excelout_do是借用了人家写的一个类,位置在vital->excel里,下面就输入参数即可
    public function excelout_do() {
        $excel = new Excel();
        $orders = Db::table('excel')->select();
//设置表头：
        $head = ['订单编号', '商品总数', '收货人'];
//数据中对应的字段，用于读取相应数据：
        $keys = ['id', 'name', 'pass'];
        $excel->outdata('kevin', $orders, $head, $keys);
    }
}