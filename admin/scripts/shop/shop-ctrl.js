function ShopCtrl($scope, $http, $location, $routeParams, $resturls,$rootScope) {

	 var $parent = $scope.$parent;
	$scope.shopinfo=$rootScope.shopinfo;
	if(!$scope.shopinfo)
		$scope.shopinfo=[];
    //获取交易记录 
	// parms sname （模糊查询商户名称客户名称手机号昵称）,shop_id,customer_id,pay_mothed（1:刷卡2:GO币）,
	//       cash1,cash2,go_coin1,go_coin2,type,create_time1, create_time2,pageindex, pagesize

	var shop_id=0;
	var customer_id=0;
	var cash1=0;
	var cash2=0;
	var go_coin1=0;
	var go_coin2=0;
	var create_time1="";
	var create_time2="";
    $scope.SearchShopBills = function (pageIndex, rankId) {
    	
    	if(!$scope.shopinfo)
    		$scope.shopinfo=[];
    	
        if (pageIndex == 0) pageIndex = 1;
        $http.post($resturls["ShopBills"], { sname: $scope.shopinfo.skey, shop_id: 0, customer_id: 0, pay_mothed: $scope.cpt_id,  cash1: cash1, cash2: cash2,go_coin1: go_coin1, go_coin2: go_coin2,type:$scope.cct_id,create_time1:create_time1,create_time2:create_time2,pageindex: pageIndex - 1, pagesize: 2 }).success(function (result) {
            if (result.Error == 0) {
                $scope.shopBills = result.Data;
                $parent.shopBillsActpageIndex = pageIndex;
                $parent.pages = utilities.paging(result.totalcount, pageIndex, 2, '#shop/' + '{0}');
            } else {
                $scope.shopBills = [];
                $parent.pages = utilities.paging(0, pageIndex, 2);
            }
        });
    }
    
    $('#reservation').daterangepicker({showDropdowns:true,format: 'YYYY/MM/DD'});
    $("[data-widget='collapse']").click(function() {
        //Find the box parent        
        var box = $(this).parents(".box").first();
        //Find the body and the footer
        var bf = box.find(".box-body, .box-footer");
        if (!box.hasClass("collapsed-box")) {
            box.addClass("collapsed-box");
            bf.slideUp();
        } else {
            box.removeClass("collapsed-box");
            bf.slideDown();
        }
    });
    
    $scope.cct_name="消费类型";
    $scope.cct_id=0;
    $scope.csr_name="商圈范围";
    $scope.csr_id=0;
    $scope.cpt_name="支付类型";
    $scope.cpt_id=0;
    
    //获取消费类型
    $scope.Consumptiontype=[
                    {"id":1,"name":"服饰"},
                    {"id":2,"name":"箱包"},
                    {"id":3,"name":"数码"}
                    ];
    $scope.ChooseConsumptiontype=function(data)
    {
    	$scope.cct_name=data.name;
    	$scope.cct_id=data.id;
    };
    
    //获取商圈范围
    $scope.ShopRange=[
                      {"id":1,"name":"金牛1"},
                            {"id":2,"name":"万达"},
                            {"id":3,"name":"天府广场"}
                            ];
    $scope.ChooseShopRange=function(data)
    {
    	$scope.csr_name=data.name;
    	$scope.csr_id=data.id;
    };
    //获取支付类型
    $scope.PayType=[
                      {"id":1,"name":"GO币"},
                      {"id":2,"name":"现金"}
                      ];
    $scope.ChoosePayType=function(data)
    {
    	$scope.cpt_name=data.name;
    	$scope.cpt_id=data.id;
    };
  
};