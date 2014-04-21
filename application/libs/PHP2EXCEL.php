<?php
/**
 * PHPEXCEL生成excel文件
 * @author:
 * @desc 支持任意行列数据生成excel文件，暂未添加单元格样式和对齐
 */
// require_once 'LIBS/PHPExcel.php';
// require_once 'LIBS/PHPExcel/Reader/Excel2007.php';
// require_once 'LIBS/PHPExcel/Reader/Excel5.php';
// include_once 'LIBS/PHPExcel/IOFactory.php';


class PHP2EXCEL {
	function getExcel($fileName, $headArr, $data) {
		if (empty ( $data ) || ! is_array ( $data )) {
			die ( "data must be a array" );
		}
		if (empty ( $fileName )) {
			exit ();
		}
		$date = date ( "Y_m_d", time () );
		$fileName .= "_{$date}.xlsx";
		
		// 创建新的PHPExcel对象
		$objPHPExcel = new PHPExcel ();
		//$objProps = $objPHPExcel->getProperties ();
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
		->setLastModifiedBy("Maarten Balliauw")
		->setTitle("Office 2007 XLSX Test Document")
		->setSubject("Office 2007 XLSX Test Document")
		->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
		->setKeywords("office 2007 openxml php")
		->setCategory("Test result file");
		
// 		print json_encode($data);
// 		print "-----------------\r\n";
		//$headArrkeys = $headArr.key();
		//$test=array();
		// 循环取数据
		$column = 2;
		for($i = 0; $i < count ( $data ); $i ++) {
			$span = ord ( "A" );
			
			while (list($key, $val) = each($data [$i]))
			{
			  if(!array_key_exists($key, $headArr))
			  {
			  	continue;
			  }

				$colum = chr ( $span );
				//print $headArr[$key]."||";
				if ($i == 0) {
						
					$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( $colum . '1', $headArr[$key] );
				}
				//array_push ( $test, "|".$colum . $column."|".$val );
				$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( $colum . $column, $val );
				$span ++;
					
			}
			
			
			$column ++;
		}
		//printf(json_encode($test));

		
		$fileName = iconv ( "utf-8", "gb2312", $fileName );
		// 重命名表
		$objPHPExcel->getActiveSheet ()->setTitle ( 'Simple' );
		// 设置活动单指数到第一个表,所以Excel打开这是第一个表
		$objPHPExcel->setActiveSheetIndex ( 0 );
		// 将输出重定向到一个客户端web浏览器(Excel2007)
// 		header ( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
// 		header ( "Content-Disposition: attachment; filename=\"$fileName\"" );
// 		header ( 'Cache-Control: max-age=0' );
		
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header ( "Content-Disposition: attachment; filename=\"$fileName\"" );
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
header('Content-Type:text/html;charset=utf-8');

		
		$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel2007' );
	    $objWriter->save ( 'php://output' ); 
		exit;
	}
}