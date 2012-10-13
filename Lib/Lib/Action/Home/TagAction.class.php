<?php
class TagAction extends HomeAction{
    public function show(){
		$this->tagall();
		$this->display('pp_vodtag');
    }
    public function shown(){
		$this->tagall();
		$this->display('pp_newstag');
    }
	public function tagall(){
		//通过地址栏参数支持筛选条件,$JumpUrl传递分页及跳转参数
		$Url = ff_param_url();
		$JumpUrl = ff_param_jump($Url);
		$JumpUrl['p'] = '{!page!}';
		C('jumpurl',UU('Home-tag/show',$JumpUrl,false,true));	
		C('currentpage',$Url['page']);
		//变量赋值
		$tag_list = $this->Lable_Tags($Url);
		$this->assign($tag_list);	
	}	
}
?>