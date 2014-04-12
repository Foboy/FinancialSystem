angular.module('gogotownfinancial', ['ngRoute', 'ui.router', 'ngRestUrls']).
config(['$provide', '$httpProvider', '$routeProvider', '$stateProvider', '$urlRouterProvider', '$resturls', function ($provide, $httpProvider, $routeProvider, $stateProvider, $urlRouterProvider, $resturls) {
    $routeProvider
        .when('/permissions/:sorts?/:pageIndex?', { template: '', controller: function () { } })
        .when('/client/:sorts?/:pageIndex?/:parameters?', { template: '', controller: function () { } })
        .otherwise({ redirectTo: '/home' });
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
}
