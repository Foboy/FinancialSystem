<?php
/**
 * PHPEXCEL生成excel文件
 * @author:firmy
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
		$objProps = $objPHPExcel->getProperties ();
		
// 		print json_encode($data);
// 		print "-----------------\r\n";
		//$headArrkeys = $headArr.key();
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
				//array_push ( $headArr, $colum . $column );
				$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( $colum . $column, $val );
				$span ++;
					
			}
			
			
			$column ++;
		}
		
		//print json_encode ( $headArr );
		//print "-----------------\r\n";
		// 设置表头
		// $key = ord ( "A" );
		// foreach ( $headArr as $v ) {
		// $colum = chr ( $key );
		// $objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( $colum . '1', $v );
		// $key += 1;
		// }
		
		// $column = 2;
		// $objActSheet = $objPHPExcel->getActiveSheet ();
		// foreach ( $data as $key => $rows ) { // 行写入
		// $span = ord ( "A" );
		// foreach ( $rows as $keyName => $value ) { // 列写入
		// $j = chr ( $span );
		// $objActSheet->setCellValue ( $j . $column, $value );
		// $span ++;
		// }
		// $column ++;
		// }
		
		$fileName = iconv ( "utf-8", "gb2312", $fileName );
		// 重命名表
		$objPHPExcel->getActiveSheet ()->setTitle ( 'Simple' );
		// 设置活动单指数到第一个表,所以Excel打开这是第一个表
		$objPHPExcel->setActiveSheetIndex ( 0 );
		// 将输出重定向到一个客户端web浏览器(Excel2007)
		header ( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
		header ( "Content-Disposition: attachment; filename=\"$fileName\"" );
		header ( 'Cache-Control: max-age=0' );
		$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel2007' );
		if (! empty ( $_GET ['excel'] )) {
			$objWriter->save ( 'php://output' ); // 文件通过浏览器下载
		} else {
			$objWriter->save ( $fileName ); // 脚本方式运行，保存在当前目录
		}
		exit ();
	}
}