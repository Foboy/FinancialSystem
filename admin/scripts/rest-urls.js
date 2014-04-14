/*
**  Create by foboy.cray
**  2014/03/25
*/
(function (window, angular, undefined) {
    'use strict';
    angular.module('ngRestUrls', ['ng']).
      config(['$provide', function ($provide) {
          var resturls = {};
          //resturls.base = "http://localhost/FinancialSystem/index.php";
          resturls.base = "http://192.168.1.7/FinancialSystem/index.php";
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

          resturls.add("LoadOwnCustomersList", "Customers/searchPrivateBP"); //分页获取商家自有客户信息
          resturls.add("LoadGoGoCustomerList", "Customers/searchGOGOBP"); //分页获取商家有消费记录gogo客户
          resturls.add("AddOwnCustomer", "Customers/addPrivateCustomer");//添加商家自有客户信息
          resturls.add("UpdateOwnCustomer", "Customers/update");//跟新商家自有客户信息
          resturls.add("SensMessage", "Messages/send");//发送消息

          //基本信息设置
          resturls.add("GetMerchantInfo", "ShopInfo/get"); //获取商家基本信息
          resturls.add("EditMerchantInfo", "ShopInfo/updateName"); //编辑商家信息(名字)
          resturls.add("SearchMerchantSetLevels", "ShopRank/search");//获取商家设置的会员的等级
          resturls.add("AddMemberLevels", "ShopRank/add");//新增会员等级信息
          resturls.add("DeleteMemberShipLevel", "ShopRank/delete");//删除会员等级
          resturls.add("UpdateMemberLevels", "ShopRank/update");//修改会员等级信息

          
          //financial
          //账号
          resturls.add("LoadUserAccountList", "user/searchFinancialsAcount");//分页查询用户账号列表  user_type 1 ADMIN 2 APP 3 STAFF
          resturls.add("AddUserAccount", "user/register");//添加用户账号
          resturls.add("UpdateUserState", "user/updateUserState");//启用禁用用户 1 启用 0禁用
          resturls.add("RestPassword", "user/updatePass");//修改用户账号密码
          //商家统计
          resturls.add("ShopBills", "Bill/searchBills");//获取交易记录
          $provide.constant('$resturls', resturls);

      } ]);
})(window, window.angular);