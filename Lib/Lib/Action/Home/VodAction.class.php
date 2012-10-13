<?php
class VodAction extends HomeAction{
    //影视搜索
    public function search(){
		//通过地址栏参数支持筛选条件,$JumpUrl传递分页及跳转参数
		$Url = ff_param_url();
		$JumpUrl = ff_param_jump($Url);
		$JumpUrl['p'] = '{!page!}';
		C('jumpurl',UU('Home-vod/search',$JumpUrl,false,true));	
		C('currentpage',$Url['page']);
		//变量赋值
		$search = $this->Lable_Search($Url,'vod');
		$this->assign($search);
		$this->display($search['search_skin']);
    }
    //影视列表
    public function show(){
		//通过地址栏参数支持筛选条件,$JumpUrl传递分页及跳转参数
		$Url = ff_param_url();
		$JumpUrl = ff_param_jump($Url);
		$JumpUrl['p'] = '{!page!}';	
		C('jumpurl',UU('Home-vod/show',$JumpUrl,false,true));	
		C('currentpage',$Url['page']);
		//变量赋值
		$List = list_search(F('_ppvod/list'),'list_id='.$Url['id']);
		$channel = $this->Lable_Vod_List($Url,$List[0]);
		$this->assign($channel);
		$this->display($channel['list_skin']);
    }
	//影片内容页
    public function read(){
		$where = array();
		$where['vod_id'] = $_GET['id'];
		$where['vod_cid'] = array('gt',0);
		$where['vod_status'] = array('eq',1);
		$rs = D("Vod");
		$array_vod = $rs->where($where)->relation('Tag')->find();
		if($array_vod){
			$array = $this->Lable_Vod_Read($array_vod);
			$this->assign($array['show']);
			$this->assign($array['read']);
			$this->display($array['read']['vod_skin']);
		}else{
			$this->assign("jumpUrl",C('site_path'));
			$this->error('此影片已经删除，请选择观看其它节目！');
		}
    }	
	//影片播放页
    public function play(){
		$where = array();
		$where['vod_id'] = $_GET['id'];
		$where['vod_cid'] = array('gt',0);
		$where['vod_status'] = array('eq',1);
		$rs = D("Vod");
		$array_vod = $rs->where($where)->relation('Tag')->find();
		if($array_vod){
			$array_play = array();
			$array_play['id'] =  intval($_GET['id']);
			$array_play['sid'] = intval($_GET['sid']);
			$array_play['pid'] = intval($_GET['pid']);
			$arrays = $this->Lable_Vod_Read($array_vod);
			$arrays['read'] = $this->Lable_Vod_Play($arrays['read'],$array_play);
			$this->assign($arrays['show']);
			$this->assign($arrays['read']);
			$this->display($arrays['read']['vod_skin_play']);
		}else{
			$this->assign("jumpUrl",C('site_path'));
			$this->error('此影片已经删除，请选择观看其它节目！');
		}
    }				
}
?>