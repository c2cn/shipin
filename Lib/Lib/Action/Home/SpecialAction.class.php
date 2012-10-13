<?php
class SpecialAction extends HomeAction{
    //专题列表
    public function show(){
		//通过地址栏参数支持筛选条件,$JumpUrl传递分页及跳转参数
		$Url = ff_param_url();
		$JumpUrl = ff_param_jump($Url);
		$JumpUrl['p'] = '{!page!}';	
		C('jumpurl',UU('Home-special/show',$JumpUrl,false,true));	
		C('currentpage',$Url['page']);
		//变量赋值
		$channel = $this->Lable_Special_List($Url);
		$this->assign($channel);
		$this->display($channel['special_skin']);
    }
	//专题内容页
    public function read(){
		$where = array();
		$where['special_id'] = $_GET['id'];
		$where['special_status'] = array('eq',1);
		$rs = D("Special");
		$array_special = $rs->where($where)->find();
		if($array_special){
			$array = $this->Lable_Special_Read($array_special);
			$this->assign($array['read']);
			$this->assign('list_vod',$array['list_vod']);
			$this->assign('list_news',$array['list_news']);
			$this->display($array['read']['special_skin']);
		}else{
			$this->assign("jumpUrl",C('site_path'));
			$this->error('此专题已经删除！');
		}
    }				
}
?>