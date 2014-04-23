<?php
error_reporting ( E_ALL );
// error_reporting(0);
ini_set ( "display_errors", 1 );
require_once '../excelHandle/excelConfig.php';
class report_handle {
	public function reportinit($data, $stime, $etime) {
		$bdata = array (
				"Amount" => 0,
				"sys_time" => "" 
		);
		for($i = 0; $i < count ( $data ); $i ++) {
			while ( list ( $key, $val ) = each ( $data [$i] ) ) {
				if ($key == "sys_time") {
					$bdata [$key] = $val;
				}
				if ($key == "Amount") {
					$bdata [$key] = $val;
				}
			}
			$data [$i] = $bdata;
		}
		$type = "";
		
		$days = round(($etime - $stime) / (24 * 3600));
		// echo $days;
		if ($days < 2) {
			$type = "hours";
		} elseif ($days <= 31) {
			$type = "days";
		} else {
			$type = "months";
		}
		
		switch ($type) {
			case "hours" :
				report_handle::report_hours ( $data, $stime, $etime );
				break;
			case "days" :
				report_handle::report_days ( $data, $stime, $etime );
				break;
			case "months" :
				report_handle::report_months ( $data, $stime, $etime );
				break;
		}
	}
	public function report_hours($data, $stime, $etime) {
		$resut = array ();
		for($i = 0; $i <= 24; $i ++) {
			$arr=array();
			$amount = 0;
			for($j = 0; $j < count ( $data ); $j ++) {
				
				$time = strtotime ( $data [$j]["sys_time"] );
				if (date ( "H", $time ) == $i) {
					$amount = $amount + $data [$j]["Amount"];
				}
			}
			array_push($arr, $i,$amount);
			array_push($resut, $arr);
		}
		
		 echo json_encode($resut);
	}
	public function report_days($data, $stime, $etime) {
	 $days =	round(($etime - $stime) / (24 * 3600));
	 
			$resut = array ();
			$nextday=$stime;
		for($i = 1; $i <= $days; $i ++) {
			$arr=array();
			$amount = 0;
			for($j = 0; $j < count ( $data ); $j ++) {
				
				$time = strtotime ( $data [$j]["sys_time"] );
				if (date ( "d", $time ) == date ( "d", $nextday )) {
					$amount = $amount + $data [$j]["Amount"];
				}
			}
			array_push($arr, $i,$amount);
			array_push($resut, $arr);
			$nextday=$stime+24*3600*$i;
		}
		
		 echo json_encode($resut);
	}
	public function report_months($data, $stime, $etime) {
// 	    echo strtotime(date("Y-m",$stime));
			$resut = array ();
		for($i =(int)date("m",$stime); $i <= (int)date("m",$etime); $i ++) {
			$arr=array();
			$amount = 0;
			for($j = 0; $j < count ( $data ); $j ++) {
				
				$time = strtotime ( $data [$j]["sys_time"] );
				if (date ( "m", $time ) == $i) {
					$amount = $amount + $data [$j]["Amount"];
				}
			}
			array_push($arr, $i,$amount);
			array_push($resut, $arr);
		}
		
	 echo json_encode($resut);
	}
}

$bills_model = new BillsModel ( new Database () );

// echo json_encode($data);
$sdate = "2014-04-16";
$edate = "2014-04-16";

$stime = strtotime ( $sdate );
$etime = strtotime ( $edate );
$data = $bills_model->searchReport (date("Y-m-d H:i:s",$stime),date("Y-m-d H:i:s",$etime+24*3600-1));
$m = new report_handle ();
$m->reportinit ( $data, $stime, $etime );

