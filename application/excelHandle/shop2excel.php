<?php

require_once 'excelConfig.php';

$headArr=array(
		"lakala_order_no"=>"交易流水号",
		"shop_name"=>"商家名称",
		"Pay_Mothed"=>"交易方式",
		"Type"=>"消费类型",
		"Cash"=>"刷卡消费金额",
		"Go_Coin"=>"GO币消费金额",
		"Create_Time"=>"消费时间"

);
$bills_model = new BillsModel(new Database());
$toexcel=new PHP2EXCEL();
//printf(json_encode($bills_model->excelDownloadQuery()));
$toexcel->getExcel('shop', $headArr, $bills_model->excelDownloadQuery());