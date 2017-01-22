//获取接口地址
function getBaseUrl(category='') {
	return 'http://fcms.yearn.cc/' + category;
}

//获取接口地址
function getApiUrl(category='') {
	return 'http://api.yearn.cc/' + category;
}

//获取get参数
function getQueryString(name){
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if (r != null){
     	return decodeURI(r[2]);
     }else{
     	return null;
     } 
}

//获取电竞地图热门城市
function getHotCity() {
	var cityArr = new Array();
	cityArr[0] = '上海';
	cityArr[1] = '青岛';
	cityArr[2] = '苏州';
	cityArr[3] = '怀化';	
	cityArr[4] = '聊城';
	cityArr[5] = '扬州';

	return cityArr;
}

//获取电竞地图其他城市
function getOtherCity() {
	var cityArr = new Array();
	cityArr[0] = '北京';
	cityArr[1] = '杭州';
	cityArr[2] = '深圳';
	cityArr[3] = '天津';
	cityArr[4] = '重庆';
	cityArr[5] = '武汉';
	cityArr[6] = '长沙';
	cityArr[7] = '西安';
	
	return cityArr;
}

