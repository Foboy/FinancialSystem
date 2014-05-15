function CustomerSpendingStatisticsCtrl($scope, $http, $location, $routeParams, $resturls) {
	
	  //商家销售总额趋势图(默认昨天今天)
    $scope.SaleTotalTrendGraph = function () {
        $("#reservation").val('');
        $('#reservation').daterangepicker({
            showDropdowns: true,
            format: 'YYYY/MM/DD',
            ranges: {
                '今天/昨天': [moment().subtract('days', 1), moment()],
                '最近7天': [moment().subtract('days', 6), moment()],
                '最近30天': [moment().subtract('days', 29), moment()]
            },
            startDate: moment().subtract('days', 1),
            endDate: moment()
        },
           function (start, end) {
               create_time1 = start / 1000;
               create_time2 = end / 1000;
               $scope.SaleTotalTrendGraphByTime( $scope.timestamptostr(create_time1), $scope.timestamptostr(create_time2));
              
           });
        
        var Datas = [];
        var d=Math.round(new Date().getTime()/1000);
        console.log( $scope.timestamptostr(d-24*3600));
        
        $http.post($resturls["SaleTotalTrendGraphByTime"], { create_time1: $scope.timestamptostr(d-24*3600), create_time2: $scope.timestamptostr(d) }).success(function (result) {
            if (result.Error == 0) {
           	 var twodaysData = {
        	            today:result.Data.today,
        	            yesterday:result.Data.yesterday
        	        };
        	 
        	        Datas = [{ label: "今日销售总额", data: twodaysData.today, color: "#1ABC9C" }, { label: "昨日销售总额", data: twodaysData.yesterday, color: "#fa787e" }];
        	       
        	        var options = {
        	            series: {
        	                lines: {
        	                    show: true
        	                },
        	                points: {
        	                    show: true
        	                }
        	            },
        	            xaxis: {
        	                tickSize: 1,
        	                tickFormatter: function (rule) {
        	                    return rule + '时';
        	                }
        	            },  //指定固定的显示内容
        	            yaxis: {
        	                ticks: 5,
        	                tickFormatter: function (rule) {
        	                    if (rule > 10000) {
        	                        return rule / 10000 + '万';
        	                    } else {
        	                        return rule + '元';
        	                    }
        	                },
        	                min: 0
        	            },  //在y轴方向显示5个刻度，此时显示内容由 flot 根据所给的数据自动判断
        	            grid: {
        	                hoverable: true
        	            },
        	            tooltip: true,
        	            tooltipOpts: {
        	                content: "%x的销售总额：%y",
        	                shifts: {
        	                    x: -60,
        	                    y: 25
        	                },
        	                onHover: function (flotItem, $tooltipEl) {
        	                    // console.log(flotItem, $tooltipEl);
        	                }
        	            }
        	        }
        	        $.plot($("#flot-line-chart"), Datas, options);
                
            } else {
                $scope.showerror = true;
                $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
            }
        }).error(function (data, status, headers, config) {
            $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
        });
        
    
       
    }
    //时间区间发生变化商家销售总额趋势图
    $scope.SaleTotalTrendGraphByTime = function (starttime, endtime) {
        var Datas = [];
        var type = 2;
        $http.post($resturls["SaleTotalTrendGraphByTime"], { create_time1: starttime, create_time2: endtime }).success(function (result) {
            if (result.Error == 0) {
      type=result.Data.type;
           	 switch (type) {
             case 1://按小时
               	 var twodaysData = {
     	            today:result.Data.today,
     	            yesterday:result.Data.yesterday
     	        };
                 Datas = [{ label: "今日销售总额", data: twodaysData.today, color: "#1ABC9C" }, { label: "昨日销售总额", data: twodaysData.yesterday, color: "#fa787e" }];
                 break;
             case 2://按日
                 var weekDatas = result.Data.data;
                 Datas = [{ label: "时间区间内销售总额", data: weekDatas, color: "#1ABC9C" }];
                 break;
             case 3://按月
                 var weekDatas = result.Data.data;
                 Datas = [{ label: "时间区间内销售总额", data: weekDatas, color: "#1ABC9C" }];
                 break;
         }
         var ts=86400;
    
        	 switch(type)
        	 {
        	 case 1:
        		ts = 3600;
        		 //ts = [1,"hour"];
        		 break;
        	 case 2:
        		ts = 86400;
        		 //ts = [1,"day"];
        		 break;
        	 case 3:
        		 ts = 86400*30;
        		 //ts = [1,"month"];
        		 break;
        	 };
    
         var options = {
             series: {
                 lines: {
                     show: true
                 },
                 points: {
                     show: true
                 }
             },
             xaxis: {
            	// minTickSize:ts,
                 tickSize: ts,
                 tickFormatter: function (rule) {
                     return $scope.TimestampToStr(rule, type);
                 }
             },  //指定固定的显示内容
             yaxis: {
                 ticks: 5,
                 tickFormatter: function (rule) {
                     if (rule > 10000) {
                         return rule / 10000 + '万';
                     } else {
                         return rule + '元';
                     }
                 },
                 min: 0
             },  //在y轴方向显示5个刻度，此时显示内容由 flot 根据所给的数据自动判断
             grid: {
                 hoverable: true
             },
             tooltip: true,
             tooltipOpts: {
                 content: "%x的销售总额：%y",
                 shifts: {
                     x: -60,
                     y: 25
                 },
                 onHover: function (flotItem, $tooltipEl) {
                     // console.log(flotItem, $tooltipEl);
                 }
             }
         }
         $.plot($("#flot-line-chart"), Datas, options);
                
            } else {
                $scope.showerror = true;
                $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
            }
        }).error(function (data, status, headers, config) {
            $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
        });
        
       
    }
   
  
};