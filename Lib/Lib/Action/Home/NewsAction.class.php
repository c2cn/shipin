<?php
class NewsAction extends HomeAction{
    //资讯搜索
    public function search(){
		//通过地址栏参数支持筛选条件,$JumpUrl传递分页及跳转参数
		$Url = ff_param_url();
		$JumpUrl = ff_param_jump($Url);
		$JumpUrl['p'] = '{!page!}';
		C('jumpurl',UU('Home-news/search',$JumpUrl,false,true));	
		C('currentpage',$Url['page']);
		//变量赋值
		$search = $this->Lable_Search($Url,'news');
		$this->assign($search);
		$this->display($search['search_skin']);
    }
    //资讯列表
    public function show(){
		//通过地址栏参数支持筛选条件,$JumpUrl传递分页及跳转参数
		$Url = ff_param_url();
		$JumpUrl = ff_param_jump($Url);
		$JumpUrl['p'] = '{!page!}';	
		C('jumpurl',UU('Home-news/show',$JumpUrl,false,true));
		C('currentpage',$Url['page']);
		//变量赋值
		$List = list_search(F('_ppvod/list'),'list_id='.$Url['id']);
		$channel = $this->Lable_News_List($Url,$List[0]);		
		$this->assign($channel);
		$this->display($channel['list_skin']);
    }
	//资讯内容页
    public function read(){
		$where = array();
		$where['news_id'] = $_GET['id'];
		$where['news_status'] = array('eq',1);
		$rs = D("News");
		$array_news = $rs->where($where)->relation('Tag')->find();
		if($array_news){
			$array = $this->Lable_News_Read($array_news);
			$this->assign($array['show']);
			$this->assign($array['read']);
			$this->display($array['read']['news_skin']);
		}else{
			$this->assign("jumpUrl",C('site_path'));
			$this->error('此资讯已经删除！');
		}
    }			
}
?>