function ShopListCtrl($scope, $http, $location, $routeParams, $resturls,$rootScope) {
	 var $parent = $scope.$parent;
	$scope.shopinfo=$rootScope.shopinfo;
    //获取交易记录 
	// parms sname （模糊查询商户名称客户名称手机号昵称）,shop_id,customer_id,pay_mothed（1:刷卡2:GO币）,
	//       cash1,cash2,go_coin1,go_coin2,type,create_time1, create_time2,pageindex, pagesize

    $scope.SearchShopBills = function (pageIndex, rankId) {
        if (!rankId) rankId = 0;
        if (pageIndex == 0) pageIndex = 1;
        $http.post($resturls["ShopBills"], { rank_id: rankId, name: "", phone: "", sex: 0, pageindex: pageIndex - 1, pagesize: 2 }).success(function (result) {
            if (result.Error == 0) {
                $scope.gogoclients = result.Data;
                $parent.gogocustomerActpageIndex = pageIndex;
                $parent.pages = utilities.paging(result.totalcount, pageIndex, 2, '#maintenance/' + '{0}');
            } else {
                $scope.gogoclients = [];
                $parent.pages = utilities.paging(0, pageIndex, 2);
            }
        });
    }
    
    $('#reservation').daterangepicker({showDropdowns:true,format: 'YYYY年MM月DD日'});
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
    
    //获取消费类型
    $scope.Consumptiontype=[
                    {"id":"1","name":"服饰"},
                    {"id":"2","name":"箱包"},
                    {"id":"3","name":"数码"}
                    ];
    $scope.ChooseConsumptiontype=function(data)
    {
    	$scope.cct=data;
    };
    
    //获取商圈范围
    $scope.ShopRange=[
                      {"id":"1","name":"金牛1"},
                            {"id":"2","name":"万达"},
                            {"id":"3","name":"天府广场"}
                            ];
    //获取支付类型
    $scope.PayType=[
                      {"id":"1","name":"GO币"},
                      {"id":"2","name":"现金"}
                      ];
  
};