<?php
class CacheAction extends BaseAction{
	//缓存管理列表
    public function show(){    
		 $this->display('./Public/system/cache_show.html');
    }
	//清除系统缓存AJAX
    public function del(){
		import("ORG.Io.Dir");
		$dir = new Dir;
		$this->ppvod_list();
		@unlink('./Runtime/~app.php');
		@unlink('./Runtime/~runtime.php');
		if(!$dir->isEmpty('./Runtime/Data/_fields')){$dir->del('./Runtime/Data/_fields');}
		if(!$dir->isEmpty('./Runtime/Temp')){$dir->delDir('./Runtime/Temp');}
		if(!$dir->isEmpty('./Runtime/Cache')){$dir->delDir('./Runtime/Cache');}
		if(!$dir->isEmpty('./Runtime/Logs')){$dir->delDir('./Runtime/Logs');}
		echo('清除成功');
    }
	// 删除静态缓存
	public function delhtml(){
		$id = $_GET['id'];
	    import("ORG.Io.Dir");
		$dir = new Dir;
		if('index' == $id){
			@unlink(HTML_PATH.'index'.C('html_file_suffix'));
		}elseif('vodlist'== $id){
			if(is_dir(HTML_PATH.'Vod_show')){$dir->delDir(HTML_PATH.'Vod_show');}	    
		}elseif('vodread' == $id){
			if(is_dir(HTML_PATH.'Vod_read')){$dir->delDir(HTML_PATH.'Vod_read');}	    
		}elseif('vodplay' == $id){
			if(is_dir(HTML_PATH.'Vod_play')){$dir->delDir(HTML_PATH.'Vod_play');}	    
		}elseif('newslist' == $id){
			if(is_dir(HTML_PATH.'News_show')){$dir->delDir(HTML_PATH.'News_show');}    
		}elseif('newsread' == $id){
			if(is_dir(HTML_PATH.'News_read')){$dir->delDir(HTML_PATH.'News_read');}   
		}elseif('ajax' == $id){
		    if(is_dir(HTML_PATH.'Ajax_show')){$dir->delDir(HTML_PATH.'Ajax_show');}	    
		}else{
		    @unlink(HTML_PATH.'index'.C('html_file_suffix'));
			if(is_dir(HTML_PATH.'Vod_show')){$dir->delDir(HTML_PATH.'Vod_show');}	    
			if(is_dir(HTML_PATH.'Vod_read')){$dir->delDir(HTML_PATH.'Vod_read');}	    
			if(is_dir(HTML_PATH.'Vod_play')){$dir->delDir(HTML_PATH.'Vod_play');}	    
			if(is_dir(HTML_PATH.'News_show')){$dir->delDir(HTML_PATH.'News_show');}    
			if(is_dir(HTML_PATH.'News_read')){$dir->delDir(HTML_PATH.'News_read');}   
		    if(is_dir(HTML_PATH.'Ajax_show')){$dir->delDir(HTML_PATH.'Ajax_show');}	    
		}
		echo('清除成功');
	}
	//
	public function vodday(){
	    $this->ppvod_cachevodday();
		$this->assign("jumpUrl",'?s=Admin-Cache-Show');
		$this->success('清空当天静态缓存成功！');
	}
}
?>