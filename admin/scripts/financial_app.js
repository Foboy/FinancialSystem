angular.module('gogotownfinancial', ['ngRoute', 'ui.router', 'ngRestUrls']).
config(['$provide', '$httpProvider', '$routeProvider', '$stateProvider', '$urlRouterProvider', '$resturls', function ($provide, $httpProvider, $routeProvider, $stateProvider, $urlRouterProvider, $resturls) {
    $routeProvider
        .when('/permissions/:sorts?/:pageIndex?', { template: '', controller: function () { } })
        .when('/client/:sorts?/:pageIndex?/:parameters?', { template: '', controller: function () { } })
        .when('/lakala/:pageIndex?', { template: '', controller: function () { } })
        .when('/shop/:pageIndex?', { template: '', controller: function () { } })
        .when('/customer/:pageIndex?', { template: '', controller: function () { } })
        //.otherwise({ redirectTo: '/home' });
    $stateProvider
         .state('home', {
             url: '/home',
             templateUrl: 'partials/home.html',
             controller: function () { 
                    setTimeout(function() {

                        //loadflotpanel();
                    }, 1000);
             }
         })
         .state('client', { url: '/client*path', templateUrl: 'partials/client.html', controller: ClientMainCtrl })
         .state('lakala', { url: '/lakala*path', templateUrl: 'partials/lakala.html', controller: LakalaCtrl })
         .state('shop', { url: '/shop*path', templateUrl: 'partials/client/shop.html', controller: ShopCtrl })
         .state('sp_statistics', { url: '/sp_statistics*path', templateUrl: 'partials/client/shop-statistics.html', controller: ShopStatisticsCtrl })
         .state('customer', { url: '/customer*path', templateUrl: 'partials/customer.html', controller: CustomerCtrl })
         .state('cus_statistics', { url: '/cus_statistics*path', templateUrl: 'partials/customer/customer-statistics.html', controller: CustomerStatisticsCtrl })
         .state('total_statistics', { url: '/total_statistics*path', templateUrl: 'partials/total_statistics.htm', controller: TotalStatisticsCtrl })
         .state('splist', { url: '/splist*path', templateUrl: 'partials/client/shoplist.html', controller: ShopListCtrl })
         .state('permissions', { url: '/permissions*path', templateUrl: 'partials/authoritymanagement.html', controller: AcountCtrl });
         
         

    $httpProvider.interceptors.push(function () {
        return {
            'response': function (response) {
                if (response && typeof response.data === 'object') {
                    if (response.data.Error == 11) {
                        setTimeout(function () { window.location.href = 'login.html'; }, 3000);
                    }
                }
                return response || $q.when(response);
            }
        };
    });
}])
    .value('$anchorScroll', angular.noop)
    .run(
      ['$rootScope', '$state', '$stateParams',
      function ($rootScope, $state, $stateParams) {
          $rootScope.$state = $state;
          $rootScope.$stateParams = $stateParams;
      }]);;

function MainCtrl($scope, $routeParams, $http, $location, $filter, $resturls) {
    $scope.currentuser = null;
    //登录
    $http.post($resturls["GetCurrentUser"], {}).success(function (result) {
        if (result.Error == 0) {
            $scope.currentuser = result.Data;
        } else {
            $scope.currentuser = {};
        }
    });
    
    // unix时间戳转化为 eg:'2014-04-08'
    $scope.timestamptostr = function (timestamp) {
        if (timestamp.indexOf('-') == -1) {
            var month = 0;
            var day = 0;
            if (timestamp) {
                var unixTimestamp = new Date(timestamp * 1000);
                if (unixTimestamp.getMonth() < 9) {
                    month = '0' + (unixTimestamp.getMonth() + 1);
                }
                if (unixTimestamp.getDay() < 9) {
                    day = '0' + unixTimestamp.getDay();
                }
                var str = unixTimestamp.getFullYear() + '-' + month + '-' + day;
                return str;
            } else {
                return "";
            }
        } else {
            return timestamp;
        }
    }

    // 时间格式字符串 ey:'2014-04-08'转化为unix时间戳
    $scope.strtotimestamp = function (datestr) {
        var arr = datestr.split("-");
        var timestap = new Date(Date.UTC(arr[0], arr[1] - 1, arr[2])).getTime() / 1000;
        return timestap;
    }
    //删除字符串末尾空格和指定字符
    $scope.trimEnd = function (temp, str) {
        if (!str) { return temp; }
        while (true) {
            if (temp.substr(temp.length - str.length, str.length) != str) {
                break;
            }
            temp = temp.substr(0, temp.length - str.length);
        }
        return temp;
    }
}
