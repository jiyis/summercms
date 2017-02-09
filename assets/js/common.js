//获取前台地址
function getBaseUrl(category) {
	return app.frontUrl + category;
}

//获取接口地址
function getApiUrl(category) {
	return app.apiUrl + category;
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

	return app.hotCity;
}

//获取电竞地图其他城市
function getOtherCity() {

	return app.otherCity;
}

