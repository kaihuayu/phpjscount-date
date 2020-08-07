<html>
<head>
<title>日期计算</title>
<script  type="text/javascript"  language="javascript"    src= "/wdata/My97DatePicker/4.8/WdatePicker.js"></script>
<script src="https://www.jq22.com/jquery/jquery-1.9.1.js"></script>
</head>

<body>


//https://github.com/kaihuayu/phpjscount-date.git
<div>
<form class="" >
<input type="text" class="input-text radius" style="width:170px;"  id="create_begin" placeholder="提交开始时间" name="create_begin" value="" onclick="WdatePicker({readOnly:true, dateFmt:'yyyy-MM-dd HH:mm'})"> -
			<input type="text" class="input-text radius" style="width:170px;" placeholder="提交结束时间" name="create_end" value="" onclick="WdatePicker({readOnly:true, dateFmt:'yyyy-MM-dd HH:mm'})" id="create_end">
	<button type="button " id="" name="" onclick="jisuan()">提交</button>		
</form>
</div>

</body>

<script>

function jisuan(){
	var sDate1=$("#create_begin").val();
var sDate2=$("#create_end").val();
	var d=getDiffYmdBetweenDate(sDate1,sDate2);
	alert("相差"+d.y+"年" +d.m + "月"+ d.d +"天");
	
}

function getDiffYmdBetweenDate(sDate1,sDate2){
    var fixDate = function(sDate){
        var aD = sDate.split('-');
        for(var i = 0; i < aD.length; i++){
            aD[i] = fixZero(parseInt(aD[i]));  //parseInt函数可解析一个字符串，并返回一个整数。
        }
        return aD.join('-');
    };
      
    var fixZero = function(n){
        return n < 10 ? '0'+n : n;  //判断日期前是否有0 没有加上 8月 =>08
    };
      
    var fixInt = function(a){
        for(var i = 0; i < a.length; i++){
            a[i] = parseInt(a[i]);        //判断日期前是否有0 有加取整去掉 08 => 8
        }
        return a;
    };
      
    var getMonthDays = function(y,m){   // 获取月的天数
        var aMonthDays = [0,31,28,31,30,31,30,31,31,30,31,30,31];//12个月每月的天数
        if((y%400 == 0) || (y%4==0 && y%100!=0)){  // 取模运算计算是否是瑞年年份除以400, 除得尽的 是闰年。能整除4且不能整除100的为闰年 
            aMonthDays[2] = 29; //润年的二月是29天
        }
        return aMonthDays[m];
    };
    
	var getHoliday = function(date){   // 排除假期
		var Holiday =["2020-01-01","2020-01-25","2020-01-29","2020-01-30","2020-01-24","2020-01-26","2020-01-28","2020-01-27","2020-01-31","2020-04-06","2020-05-01","2020-05-04","2020-05-05","2020-06-25","2020-06-26","2020-10-01","2020-10-03","2020-10-02","2020-10-04","2020-10-06","2020-10-07","2020-10-05","2020-10-08"];  //全年节假日
		for (var i=0;i<Holiday.length;i++){
			if (Holiday[i]==date){
				return true;
			}
			
		}
		return false;

	}
	
	//判断是否是周末
	var get_day =function(nextDate){
		var day = new Date(nextDate).getDay();//0-周日，6-周六
                if(day==0 || day==6) {
                    return true;
                }
		return false;
	}
	
    var checkDate = function(sDate){
    };
    var y = 0;
    var m = 0;
    var d = 0;
    var sTmp;
    var aTmp;
    sDate1 = fixDate(sDate1);
    sDate2 = fixDate(sDate2);
    if(sDate1 > sDate2){
        return 'past'
    }
    var aDate1 = sDate1.split('-');
    aDate1 = fixInt(aDate1);
    var aDate2 = sDate2.split('-');
    aDate2 = fixInt(aDate2);
    //计算相差的年份
    /*aTmp = [aDate1[0]+1,fixZero(aDate1[1]),fixZero(aDate1[2])];
    while(aTmp.join('-') <= sDate2){
        y++;
        aTmp[0]++;
    }*/
    y = aDate2[0] - aDate1[0];  //两个年份相减
    if( sDate2.replace(aDate2[0],'') < sDate1.replace(aDate1[0],'')){   // 如果日期差不到一年 就减一
        y = y - 1;
    }
    //计算月份
    aTmp = [aDate1[0]+y,aDate1[1],fixZero(aDate1[2])]; //年加上相差的年Y ，月，日
    while(true){
        if(aTmp[1] == 12){ //如果月等于12 
            aTmp[0]++;  //年就加+
            aTmp[1] = 1;// 如果是12月了就把月份重置为 1月 从1月开始
        }else{       //如果月不等于12 
            aTmp[1]++; //月份加1
        }
        if(([aTmp[0],fixZero(aTmp[1]),aTmp[2]]).join('-') <= sDate2){  //如果日期atmp 小于 sDate2 就加一月 知道atmp的等于 Sdate2
            m++;                        //循环的次数就是 相差的月数                         
        } else {
            break;   // 跳出循环
        }
    }
    //计算天数
    aTmp = [aDate1[0]+y,aDate1[1]+m,aDate1[2]]; //aDate1 加上相差的 年  加上相差的月 
    if(aTmp[1] > 12){    //如果月 大于12
        aTmp[0]++;          //年就加1
        aTmp[1] -= 12; // 月就减12
    }
    while(true){
        if(aTmp[2] == getMonthDays(aTmp[0],aTmp[1])){  //如果 aTmp[2]天数等于当月的天数
            aTmp[1]++;   //月份加1
            aTmp[2] = 1;  // 天数从1开始
        } else {
            aTmp[2]++;    //天数加1
        }
        sTmp = ([aTmp[0],fixZero(aTmp[1]),fixZero(aTmp[2])]).join('-');  
        if(sTmp <= sDate2 ){ //比较如果Stmp 日期小于 sDate2 d天就+ 	
		 if(!getHoliday(sTmp) && !get_day(sTmp)){  //如果不是放假 或者不是周六日
            d++; 
		 }			
        } else {
            break; //直到等于天数 返回 跳出循环。
        }
    }
    return {y:y,m:m,d:d}
}
    


</script>
</html>