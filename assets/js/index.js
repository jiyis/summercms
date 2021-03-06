$(function(){
	//notice
	$('<li></li>').html($('.notice-list>li').eq(0).html()).appendTo($('.notice-list'));
	var h = $('.notice-box').height();
	var notice_order = 0;
	var notice_len = $('.notice-list').children().length;
	setTimeout(noticeRoll,3000);

	function noticeRoll(){
		notice_order++;
		$('.notice-list').css({
			'transition-duration':'.5s',
			'transform': 'translate3d(0px, -'+notice_order*h+'px, 0px)'
		});
		if (notice_order == notice_len-1){
			notice_order = 0;
			setTimeout(function(){
				$('.notice-list').css({
					'transition-duration':'0s',
					'transform': 'translate3d(0px, -'+notice_order*h+'px, 0px)'
				});
			},500);
		}
		setTimeout(noticeRoll,3000);
	}

	//slide
	$('<li></li>').html($('.slide-list>li').eq(0).html()).appendTo($('.slide-list'));
	var len = $('.slide-list').children().length;
	var wid = $('.news-slide').width();
	var order = 0;
	setTimeout(slide,3000);
	function slide(){
		order++;
		$('.slide-list').css({
			'transition-duration':'.5s',
			'transform': 'translate3d(-'+order*wid+'px, 0px, 0px)'
		});
		if (order == len-1){
			order = 0;
			setTimeout(function(){
				$('.slide-list').css({
					'transition-duration':'0s',
					'transform': 'translate3d(-'+order*wid+'px, 0px, 0px)'
				});
			},500);
		}
		$('.slide-paging').find('.active').removeClass('active');
		$('.slide-paging>li').eq(order).addClass('active');

		setTimeout(slide,3000);
	}
	$('.slide-paging>li>a').each(function(index){
		$(this).on('click',function(){
			if (index == order-1){
				return false;
			}
			order = index;
			$('.slide-list').css({
				'transition-duration':'.5s',
				'transform': 'translate3d(-'+order*wid+'px, 0px, 0px)'
			});
			$('.slide-paging').find('.active').removeClass('active');
			$('.slide-paging>li').eq(order).addClass('active');
		});
	});

	//side-bar
	var colH = new Array();
	colH[0] = 0;
	$('.column-box').each(function(){
		colH.push($(this).offset().top);
	});
	$(window).on('scroll',function(){
		if ($(window).width() < 1200){
			return false;
		}
		var scrollH = $(document).scrollTop() - $(window).height()/2;
		if (scrollH > 0){
			$('.side-bar').css('display','block');
		}else{
			$('.side-bar').css('display','none');
		}
		for (var i=1;i<colH.length;i++){
			if (scrollH>colH[i-1] && scrollH<colH[i]){
				$('.side-bar').find('.active').removeClass('active');
				$('.side-bar>ul>li').eq(i-1).addClass('active');
			}
		}
	});

	//Game
	var game_vm = new Vue({
		el: '#game',
        data:{
        	games:'',
        	baseUrl: getApiUrl('match'),
        	liWid:[],
        	hrStyle:[],
        	mWid:[],
        	mLeft:[],
        	styleObject:{
        		width: '1200%',
        		transform:'translateX(0px)'
        	}
        },
        created:function(){
            var url = this.baseUrl;
            this.$http.get(url).then(function(res){
                this.games=res.body.data;
                for (var i=0;i<this.games.length; i++){
                	var game = this.games[i];
                	var count = game.groupCount;
                	if (parseInt(count) == 0){
                		var wid = 0;
                	}else{
                		var wid = 1170 / count;
                	}
                	this.liWid[game.id] = wid;
                	this.hrStyle[game.id] = {
                		wid : wid * (count - 1),
                		left : wid / 2 + 15
                	}
                	this.mWid[game.id] = new Array();
                	this.mLeft[game.id] = new Array();
                	for (var j=0;j<game.groups.length; j++){
                		var group = game.groups[j];
                		this.mWid[game.id][group.id] = 277 * group.matchCount;
                		var temp = 0;
                		for (var k=0;k<group.matchs.length; k++){
                			if (parseInt(group.matchs[k].default) == 1){
                				temp = k;
                				break;
                			}
                		}
                		this.mLeft[game.id][group.id] = -277 * temp;
                	}
                }
            },function(response){
                console.info(response);
            });
        },
        methods:{
			changeGame:function (gameid) {
				var groupid = 0;
				for (var i=0;i<this.games.length; i++){
					if (this.games[i].id == gameid){
						this.games[i].default = 1;
						for (var j=0;j<this.games[i].groups.length; j++){
							if (this.games[i].groups[j].default == 1){
								groupid = this.games[i].groups[j].id;
								break;
							}
						}
					}else{
						this.games[i].default = 0;
					}
				}
				this.styleObject.transform = 'translateX('+this.mLeft[gameid][groupid]+'px)';
				this.styleObject.width = this.mWid[gameid][groupid]+'px';
			},
			changeGroup:function (gameid,groupid) {
				for (var i=0;i<this.games.length; i++){
					if (gameid == this.games[i].id){
						for (var j=0;j<this.games[i].groups.length; j++){
							if (groupid == this.games[i].groups[j].id){
								this.games[i].groups[j].default = 1;
							}else{
								this.games[i].groups[j].default = 0;
							}
						}
					}
				}
				this.styleObject.transform = 'translateX('+this.mLeft[gameid][groupid]+'px)';
				this.styleObject.width = this.mWid[gameid][groupid]+'px';
			},
			translateLeft:function (gameid,groupid) {
				if (this.mLeft[gameid][groupid] <= -277){
					this.mLeft[gameid][groupid] += 277;
				}
				this.styleObject.transform = 'translateX('+this.mLeft[gameid][groupid]+'px)';
			},
			translateRight:function (gameid,groupid) {
				if (this.mLeft[gameid][groupid] > -(this.mWid[gameid][groupid] - 277 * 4)){
					this.mLeft[gameid][groupid] -= 277;
				}
				this.styleObject.transform = 'translateX('+this.mLeft[gameid][groupid]+'px)';
			}

        }
	});

	var venue_vm = new Vue({
		el:'#map',
		data:{
			hotCity:getHotCity(),
			otherCity:getOtherCity(),
			baseUrl:getBaseUrl('venue'),
		},
		methods:{
			redirectPage:function () {
				var val = document.getElementById('venueName').value;
			    if (val != ''){
                    window.location.href= this.baseUrl + '?city=' + val;
                }else{
                    document.getElementById('venueName').placeholder = "不能为空";
                }
			}
		}
	});

	var search_vm = new Vue({
		el:'#search',
		data:{
			baseUrl:getBaseUrl('search'),
		},
		methods:{
			redirectPage:function () {
				var val = document.getElementById('keyword').value;
				if (val != ''){
                    window.location.href= this.baseUrl + '?key=' + val; 
                }else{
                    document.getElementById('keyword').placeholder = "关键词不能为空";
                }	
			}
		}
	});
});

function getLeft(str){
	var arr = str.replace(/[^0-9^,^-]/ig,"").split(',');
	return parseInt(arr[4]);
}