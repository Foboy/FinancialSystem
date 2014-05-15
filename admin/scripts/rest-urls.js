/*
**  Create by foboy.cray
**  2014/03/25
*/
(function (window, angular, undefined) {
    'use strict';
    angular.module('ngRestUrls', ['ng']).
      config(['$provide', function ($provide) {
          var resturls = {};
          resturls.base = "/FinancialSystem/index.php";
          resturls.excelbaseurl = "/FinancialSystem/application/excelHandle/";
//          resturls.base = "http://192.168.0.62:81/FinancialSystem/index.php";
//          resturls.excelbaseurl = "http://192.168.0.62:81/FinancialSystem/application/excelHandle/";
          resturls.add = function (name, url) {
              resturls[name] = resturls.base + "?url=" + url;
          };
          resturls.addpage = function (name, url) {
              resturls[name] = resturls.base + url;
          };


          // 主模块
          resturls.add("GetCurrentUser", "user/getCurrentUser");
          resturls.add("Login", "user/finacillogin");


          // 客户管理



          
          //financial
          //账号
          resturls.add("LoadUserAccountList", "user/searchFinancialsAcount");//分页查询用户账号列表  user_type 1 ADMIN 2 APP 3 STAFF
          resturls.add("AddUserAccount", "user/register");//添加用户账号
          resturls.add("UpdateUserState", "user/updateUserState");//启用禁用用户 1 启用 0禁用
          resturls.add("RestPassword", "user/updatePass");//修改用户账号密码
          //商家统计
          resturls.add("ShopBills", "bill/searchBills");//获取交易记录
          resturls.add("ExcelBills", "bill/searchBillsToExcel");//设置EXCEL
          resturls.add("BillsToExcel", "bill/excelDownload");//导出EXCEL
          resturls.add("ShopList", "bill/searchShopList");//查询商家列表
          resturls.add("SetShopRate", "bill/SetShopRate");//设置商家手续费率
          resturls.add("SearchArea", "bill/SearchArea");//设置商家手续费率
          
          //主页
          resturls.add("SaleTotalTrendGraphByTime", "home/SaleTotalTrendGraphByTime");//昨日今日销售分析统计 (每天24小时)
          resturls.add("AppuserTrendGraphByTime", "home/AppuserTrendGraphByTime");//收银员APP
          resturls.add("getHeaderNumber","home/getHeaderNumber");
          
          $provide.constant('$resturls', resturls);

      } ]);
})(window, window.angular);