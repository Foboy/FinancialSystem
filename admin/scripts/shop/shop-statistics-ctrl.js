function ShopStatisticsCtrl($scope, $http, $location, $routeParams, $resturls) {
	
    //获取交易记录 
    $scope.SearchLakalalist = function (data) {
   
            $http.post($resturls["AddUserAccount"], { user_type: 5, user_name: data.Name, user_account: data.Account, user_password_new: data.Password, user_password_repeat: data.Password }).success(function (result) {
                if (result.Error == 0) {
                    alert("success");
                    $scope.loadUserAccountSortList($routeParams.pageIndex || 1);
                    $("#AddUsermodal").modal("hide");
                } else {
                    alert(result.ErrorMessage);
                    $scope.showerror = true;
                }
            });
  
    }
  
  
};