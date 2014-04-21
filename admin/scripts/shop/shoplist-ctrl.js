function ShopListCtrl($scope, $http, $location, $routeParams, $resturls,$rootScope) {


	 var $parent = $scope.$parent;
	$scope.shopinfo=$rootScope.shopinfo;
	if(!$scope.shopinfo)
		$scope.shopinfo=[];


	$scope.shopinfo.post1=0;
	$scope.shopinfo.post2=0;
	$scope.shopinfo.lakala1=0;
	$scope.shopinfo.lakala2=0;
	$scope.shopinfo.daterange="";
	$scope.shopinfo.skey="";
	
	var create_time1="";
	var create_time2="";
  $scope.SearchShopList = function (pageIndex) {

      if (!pageIndex) 
   	   pageIndex = 0;
      
      $http.post($resturls["ShopList"], { sname: $scope.shopinfo.skey, area_id:$scope.csr_id ,pos_rate1:$scope.shopinfo.post1,pos_rate2:$scope.shopinfo.post2,lakala_rate1:$scope.shopinfo.lakala1,lakala_rate2:$scope.shopinfo.lakala2,create_time1:create_time1,create_time2:create_time2,pageindex:pageIndex,pagesize: 10 }).success(function (result) {
          if (result.Error == 0) {
              $scope.shopList = result.Data;
              //$parent.shopBillsActpageIndex = pageIndex;
              $parent.pages = utilities.paging(result.totalcount, pageIndex+1, 2, '#splist/' + '{0}');
          } else {
              $scope.shopBills = [];
              $parent.pages = utilities.paging(0, pageIndex+1, 2);
          }
      });
  }
  
  $('#setRateModal').modal({
	  show:false
});
  $scope.currentPostRate=0;
  $scope.currentLakalaRate=0;
  $scope.currentShopId=0;
  //修改商家手续费率包括POS机费率以及拉卡拉费率
  $scope.SetShopRate=function()
  {
	  $http.post($resturls["SetShopRate"], { shop_id:$scope.currentShopId, pos_rate:$scope.currentPostRate,lakala_rate:$scope.currentLakalaRate }).success(function (result) {
          if (result.Error == 0) {
        	  $('#setRateModal').modal('hide');
          } else {
           
          }
      });
  }

$scope.GetCurrentShopRate=function(shopid,postrate,lakalarate)
{
	  $scope.currentPostRate=postrate;
	  $scope.currentLakalaRate=lakalarate;
	  $scope.currentShopId=shopid;
}


  $('#reservation').daterangepicker({
			   showDropdowns:true,
			   format: 'YYYY/MM/DD',
			   ranges: {
                  '今天': [moment(), moment()],
                  '昨天': [moment().subtract('days', 1), moment().subtract('days', 1)],
                  '最近7天': [moment().subtract('days', 6), moment()],
                  '最近30天': [moment().subtract('days', 29), moment()],
                  '这个月': [moment().startOf('month'), moment().endOf('month')],
                  '上个月': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
              },
              startDate: moment().subtract('days', 29),
              endDate: moment()
		   },
     function(start, end) {
	   create_time1=start/1000;
	   create_time2=end/1000;
  });
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
  

  $scope.csr_name="商圈范围";
  $scope.csr_id=0;
  
  //获取商圈范围
  $scope.ShopRange=[
                    {"id":1,"name":"万达广场"},
                          {"id":2,"name":"新会展"},
                          {"id":3,"name":"天府广场"}
                          ];
  $scope.ChooseShopRange=function(data)
  {
  //	$scope.csr_name=data.name;
  	$scope.csr_id=data.id;
	$scope.tag_sr_text=data.name;
	$("#tag_sr").removeClass("hidden");
  	
  };
  $scope.Hiddensrtag=function()
  {
	   $("#tag_sr").addClass("hidden");
	   $scope.csr_id=0;
  }
  
  
  
	if($routeParams.pageIndex)
		$scope.SearchShopList($routeParams.pageIndex-1);
	else
		$scope.SearchShopList();
  
};