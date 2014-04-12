function CustomerCtrl($scope, $http, $location, $routeParams, $resturls, $rootScope) {
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
}


