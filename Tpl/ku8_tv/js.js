$(document).ready(function(){
	//系统初始化	
	FFvod.Default();
	//评论初始化
	Comment.Default(Root+"index.php?s=Cm-Show-sid-"+Sid+"-id-"+Id+"-p-1");
	//积分初始化
	Gold.Default(Root+'index.php?s=Gold-'+FFvod.GetModel(Sid)+'-id-'+Id);
	//顶踩初始化
	UpDown.Default(Root+'index.php?s=Updown-'+FFvod.GetModel(Sid)+'-id-'+Id);
	//顶踩新闻初始化
	UpDownNews.Default(Root+'index.php?s=Updown-'+FFvod.GetModel(Sid)+'-id-'+Id);	
});
//系统模块
var FFvod = {
	'Url': document.URL,
	'Tpl': 'defalut',
	'GetModel': function ($mid){//获取模型名称
		if($mid == '1') return 'vod';
		if($mid == '2') return 'news';
		if($mid == '3') return 'special';
	},
	'Default': function() {
		//搜索默认关键字
		if($("#wd").length>0){ 
			FFvod.Search('wd');
		}
		//加入收藏夹
		$("#fav").click(function(){
			FFvod.AddFav();
		});
	},
	'Search': function(divId) {
		//控制提交action
		if(Sid=='2'){
			$key = '输入关键字';
			$('#ffsearch').attr('action', Root+'index.php?s=news-search');
		}else{
			$key = '输入影片名称或主演名称';
		}
		//默认关键字
		if($('#'+divId).val() == ''){
			$('#'+divId).val($key);
		}
		//
		$('#'+divId).focus(function(){
			if($('#'+divId).val() == $key){
				$('#'+divId).val('');
			}
		});
		$('#'+divId).blur(function(){
			if($('#'+divId).val() == ''){
				$('#'+divId).val($key);
			}
		});
	},
	'AddFav' : function() {
		var url = window.location.href;					 
		try{
			window.external.addFavorite(url,document.title);
		}catch(err){
			try{
				window.sidebar.addPanel(document.title, url,"");
			}catch(err){
				alert("请使用Ctrl+D为您的浏览器添加书签！");
			}
		}
	}
}
//评论
var Comment = {
	'Default': function($ajaxurl) {
		if($("#Comment").length>0){
			Comment.Show($ajaxurl);
		}
	},
	'Show': function($ajaxurl) {
		$.ajax({
			type: 'get',
			url: $ajaxurl,
			timeout: 5000,
			error: function(){
				$("#Comment").html('评论加载失败...');
			},
			success:function($html){	
				$("#Comment").html($html);
			}
		});
	},
	'Post':function CommentPost(){
		if($("#comment_content").val() == '请在这里发表您的个人看法，最多200个字。'){
			$('#comment_tips').html('请发表您的评论观点！');
			return false;
		}
		var $data = "cm_sid="+Sid+"&cm_cid="+Id+"&cm_content="+$("#comment_content").val();
		$.ajax({
			type: 'post',
			url: Root+'index.php?s=Cm-insert',
			data: $data,
			dataType:'json',
			success:function($string){
				if($string.status == 1){
					Comment.Show(Root+"index.php?s=Cm-Show-sid-"+Sid+"-id-"+Id+"-p-1");
				}
				$('#comment_tips').html($string.info);
			}
		});
	}
}
//顶踩
var UpDown = {
	'Ajaxurl': '',
	'Default': function(ajaxurl){
		UpDown.Ajaxurl = ajaxurl;
		if($("#Up").length || $("#Down").length){
			UpDown.Ajax('');
		}
		$('.Up').click(function(){					
			UpDown.Ajax('up');
		})
		$('.Down').click(function(){
			UpDown.Ajax('down');
		})
	},
	'Ajax': function($ajaxtype){
		$.ajax({
			type: 'get',
			url: UpDown.Ajaxurl+'-type-'+$ajaxtype,
			timeout: 5000,
			dataType:'json',
			success:function($html){
				if(!$html.status){
					alert($html.info);
				}else{
					UpDown.Show($html.data);
					if($ajaxtype){
						alert($html.info);
					}
				}
			}
		});
	},
	'Show': function ($html){
		$(".Up>span").html($html.split(':')[0]);
		$(".Down>span").html($html.split(':')[1]);
	}
}
//顶踩文章
var UpDownNews = {
	'Ajaxurl': '',
	'Default': function(ajaxurl){
		UpDownNews.Ajaxurl = ajaxurl;
		if($("#Digup").length || $("#Digdown").length){
			UpDownNews.Ajax();
		}else{
			UpDownNews.Show($("#Digup_val").html()+':'+$("#Digdown_val").html(),'');
		}
		$('.Digup').click(function(){					
			UpDownNews.Ajax('up');
		})
		$('.Digdown').click(function(){					
			UpDownNews.Ajax('down');
		})		
	},
	'Ajax': function($ajaxtype){
		$.ajax({
			type: 'get',
			url: this.Ajaxurl+'-type-'+$ajaxtype,
			timeout: 5000,
			dataType:'json',
			success:function($html){
				if(!$html.status){
					alert($html.info);
				}else{				
					UpDownNews.Show($html.data);
					if($ajaxtype){
						alert($html.info);
					}
				}
			}
		});
	},
	'Show': function ($html){
		var Digs = $html.split(':');
		var sUp = parseInt(Digs[0]);
		var sDown = parseInt(Digs[1]);
		var sTotal = sUp+sDown;
		var spUp=(sUp/sTotal)*100;
		spUp = Math.round(spUp*10)/10;
		var spDown = 100-spUp;
		spDown = Math.round(spDown*10)/10;
		if(sTotal!=0){
			$('#Digup_val').html(sUp);
			$('#Digdown_val').html(sDown);
			$('#Digup_sp').html(spUp+'%');
			$('#Digdown_sp').html(spDown+'%');
			$('#Digup_img').width(parseInt((sUp/sTotal)*55));
			$('#Digdown_img').width(parseInt((sDown/sTotal)*55));
		}
	}
}
//评分
var Gold = {
	'Ajaxurl': '',
	'Default': function(ajaxurl){
		this.Ajaxurl = ajaxurl;
		if($("#Gold").length>0 || $("#Goldnum").length>0){
			$.ajax({			   
				type: 'get',
				url: Gold.Ajaxurl,
				timeout: 5000,
				dataType:'json',
				error: function(){
					//Gold.Show('0.0:0','');
					$(".Gold").html('评分加载失败');
				},
				success: function($html){
					Gold.Show($html.data,'');
				}
			});			
		}else{
			if($(".Gold").length>0 || $(".Goldnum").length>0){
				Gold.Show($(".Goldnum").html()+':'+$(".Golder").html(),'');
			}
		}
	},
	'Show': function($html,$status){
		//去除与创建title提示
		$(".Goldtitle").remove();
		$(".Gold").after('<span class="Goldtitle" style="width:'+$(".Gold").width()+'px"></span>');
		$(".Goldtitle").css({margin:'20px 0 0 -95px'});
		if($status == 'onclick'){
			$(".Goldtitle").html('评分成功！');
			$(".Goldtitle").show();
			$status = '';
		}
		//展示星级>评分>评分人
		$(".Gold").html(Gold.List($html.split(':')[0]));
		$(".Goldnum").html($html.split(':')[0]);
		$(".Golder").html($html.split(':')[1]);
		//鼠标划过
		$(".Gold>span").mouseover(function(){
			$id = $(this).attr('id')*1;							   	   
			$(".Goldtitle").html(Gold.Title($id*2));
			$(".Goldtitle").show();
			//刷新星级图标
			$bgurl = $(this).css('background-image');
			for(i=0;i<5;i++){
				if(i>$id){
					$(".Gold>#"+i+"").css({background:$bgurl+" 41px 0 repeat"});
				}else{
					$(".Gold>#"+i+"").css({background:$bgurl});
				}
			}
		});
		//鼠标移出
		$(".Gold>span").mouseout(function(){
			//去除title提示	
			$(".Goldtitle").hide();
			//刷新星级图标
			$score = $html.split(':')[0]*1/2;
			$id = $(this).attr('id')*1;
			$bgurl = $(this).css('background-image');
			for(i=0;i<5;i++){
				if(i<Math.round($score)){
					if(i == parseInt($score)){
						$(".Gold>#"+i+"").css({background:$bgurl+" 20px 0 repeat"});
					}else{
						$(".Gold>#"+i+"").css({background:$bgurl});
					}
				}else{
					$(".Gold>#"+i+"").css({background:$bgurl+" 41px 0 repeat"});
				}
			}
		});
		//鼠标点击
		$(".Gold>span").click(function(){
			$.ajax({
				type: 'get',
				url: Gold.Ajaxurl+'-type-'+(($(this).attr('id')*1+1)*2),
				timeout: 5000,
				dataType:'json',
				error: function(){
					$(".Goldtitle").html('评分失败!');
				},
				success: function($html){
					if(!$html.status){
						alert($html.info);
					}else{
						Gold.Show($html.data,'onclick');
					}
				}
			});
		});
	},
	'List': function($score){//星级评分展示
		var $html = '';
		$score = $score/2;
		for(var i = 0 ; i<5; i++){
			var classname = 'all';
			if(i < $score && i<Math.round($score)){
				if(i == parseInt($score)){
					classname = 'half';
				}
			}else{
				classname = 'none';
			}
			$html += '<span id="'+i+'" class="'+classname+'"></span>';// title="'+this.GoldTitle(i*2)+'"
		}
		return $html;
	},
	'Title': function($score){//星级鼠标浮层提示信息
		var array_str = ['很差！','一般！','不错！','很好！','力荐！'];
		var $score = parseFloat($score);
		if($score < 2.0) return array_str[0];
		if($score>=2.0 && $score<4.0) return array_str[1];
		if($score>=4.0 && $score<6.0) return array_str[2];
		if($score>=6.0 && $score<8.0) return array_str[3];
		if($score>=8.0) return array_str[4];
	}
}