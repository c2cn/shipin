<?php
class CollectAction extends BaseAction{	
	// 栏目分类转换
    public function change(){
		$change_content = trim(F('_collect/change'));
		$this->assign('change_content',$change_content);
        $this->display('./Public/system/collect_change.html');
    }
	// 栏目分类转换保存
    public function changeup(){
		F('_collect/change',trim($_POST["content"]));
		$array_rule = explode(chr(13),trim($_POST["content"]));
		foreach($array_rule as $key => $listvalue){
			$arrlist = explode('|',trim($listvalue));
			$array[$arrlist[0]] = intval($arrlist[1]);
		}
		F('_collect/change_array',$array);		
		$this->assign("jumpUrl",'?s=Admin-Collect-Change');
		$this->success('栏目转换规则编辑成功！');
	}
	// 栏目分类转换保存
    public function test(){
		
	}	
	// 采集节点列表
    public function show(){
		dump('2.0正式版才推出。');
		exit();
	    $rs = M("Collect");
		$list = $rs->order('collect_id desc')->select();
		$this->assign('list_collect',$list);
        $this->display('./Public/system/collect_show.html');
    }
	// 添加编辑采集节点
    public function add(){
		$rs = M("Collect");
		$collect_id = intval($_GET['id']);
		if($collect_id){
            $where['collect_id'] = $collect_id;
			$array = $rs->where($where)->find();
			$array['collect_replace'] = explode('|||',$array['collect_replace']);
			$array['collect_tpltitle'] = '修改';
		}else{
		    $array['collect_id'] = 0;
		    $array['collect_encoding'] = '2312';
			$array['collect_player'] = 'qvod';
			$array['collect_savepic'] = 0;
			$array['collect_order'] = 0;
			$array['collect_pagetype'] = 1;
			$array['collect_pagesid'] = 1;
			$array['collect_pageeid'] = 9;
			$array['collect_tpltitle'] = '添加';
		}
		$array['collect_step'] = intval($_GET['step']);
		$this->ppvod_play();
		$this->assign($array);
		$this->assign('listtree',F('_ppvod/listvod'));
		$this->display('./Public/system/collect_add.html');
    }
	// 采集节点数据入库
	public function insert() {
		$rs = D("Collect");
		if($rs->create()){
		    $id = $rs->add();
			if(false !==  $id){
			    //$this->f_replace($_POST['collect_replace'],$id);
				redirect('?s=Admin-Collect-Add-id-'.$id.'-step-2');
			}else{
				$this->error('数据写入错误');
			}
		}else{
		    $this->error($rs->getError());
		}
	}	
	// 更新数据库信息
	public function update(){
		if(empty($_POST['collect_savepic'])){
			$_POST['collect_savepic'] = 0;
		}
		if(empty($_POST['collect_order'])){
			$_POST['collect_order'] = 0;
		}
		$rs = D("Collect");
		if($rs->create()){
			$id = intval($_POST['collect_id']);
			if(false !==  $rs->save()){
				//F('_collects/id_'.$id,NULL);
				//F('_collects/id_'.$id.'_rule',NULL);
				//$this->f_replace($_POST['collect_replace'],$id);
				$this->assign("jumpUrl",'?s=Admin-Collect-Caiji-ids-'.$id.'-tid-2');
				$this->success('采集规则更新成功,测试一下是否能正常采集！');
			}else{
				$this->error("没有更新任何数据！");
			}
		}else{
			$this->error($rs->getError());
		}
	}
	// 复制规则
    public function cop(){
	    $rs = D("Collect");
		$id = intval($_GET['id']);
		$array = $rs->find($id);
		unset($array["collect_id"]);
		$array["collect_title"] = $array["collect_title"].'-复制';
		$rs->data($array)->add();
		$this->success('复制采集规则成功！');
    }	
	// 删除规则
    public function del(){
		$rs = D("Collect");
		$id = intval($_GET['id']);
		$where['collect_id'] = $id;
		$rs->where($where)->delete();
		F('_collects/cid_'.$id.'_rule',NULL);
		F('_collects/cid_'.$id.'_replace',NULL);
		$this->success('删除ID为'.$id.'的采集规则成功！');
    }
	// 批量删除规则
    public function delall(){
		if(empty($_POST['ids'])){
			$this->error('请选择需要删除的采集规则！');
		}	
		$array = $_POST['ids'];
		$rs = D("Collect");
		foreach($array as $value){
		    $rs->where('collect_id='.$value)->delete();
			F('_collects/cid_'.$value.'_rule',NULL);
			F('_collects/cid_'.$value.'_replace',NULL);
		}	
		$this->success('批量删除采集规则成功！');
    }	
	// 采集导出
    public function export(){
		dump('2.0正式版才推出。');
		exit();	
	    $rs = M("Collect");
		$list = $rs->order('collect_id desc')->select();
		$this->assign('list_collect',$list);
		$this->display('./Public/system/collect_export.html');
    }		
	// 执行采集导出
    public function exportsql(){
		$ids = $_POST['ids'];
	    if(!is_array($ids)){
			$this->error("请选择要导出的规则！");
		}
	    $where['collect_id'] = array('in',$ids);
	    $rs = M("Collect");
		$list = $rs->where($where)->order('collect_id desc')->select();	
		F('_collects/ppvod_collect',$list);
        $this->success("恭喜您!您选择的采集规则已经完整导出！");
    }
	// 采集导入
    public function import(){
		dump('2.0正式版才推出。');
		exit();	
		$list = F('_collects/ppvod_collect');
		if(!is_array($list)){
			$this->error("没有找到采集规则文件Runtime/Data/_collects/ppvod_collect.php");
		}
		$this->assign('list_collect',$list);
        $this->display('./Public/system/collect_export.html');
    }	
	// 执行采集导入
    public function importsql(){
	    $ids = $_POST['ids'];
		if(!is_array($ids)){
			$this->error("请选择要导入的规则！");
		}
		$list = F('_collects/ppvod_collect');
		$rs = D("Collect");
		$replace = array('all'=>'','listname'=>'','vodname'=>'','actor'=>'','director'=>'','content'=>'','vodpic'=>'','continu'=>'','url'=>'');
		foreach($list as $key=>$val){
		    if(in_array($val['collect_id'],$ids)){
				unset($val['collect_id']);
				$cid = $rs->data($val)->add();
				$abc = explode('|||',$val['collect_replace']);
				$replace = array();
				$replace['all'] = $abc[0];
				$replace['listname'] = $abc[1];
				$replace['vodname'] = $abc[2];
				$replace['actor'] = $abc[3];
				$replace['director'] = $abc[4];
				$replace['content'] = $abc[5];
				$replace['vodpic'] = $abc[6];
				$replace['continu'] = $abc[7];
				$replace['url'] = $abc[8];
				//$this->f_replace($replace,$cid);
			};
		}
		$this->assign("jumpUrl",'?s=Admin-Collect-Show');
		$this->success("恭喜您，您选择的采集规则已经成功导入！");
    }	
	// 采集主干
    public function caiji(){
		//判断是否批量采集并生成当前采集ID
		$ids = $_REQUEST['ids'];
		if(is_array($ids)){
			$ids = '1,'.implode(',',$ids);
			$id = $ids[0];
		}else{
			$ids = $_GET['ids'];
			$id = $ids;
		}
		//生成采集列表与规则		
		$array = $this->caijicreateurl($id);
		$pagetype = $array['rule']['collect_pagetype'];
		//采集方式分支-开始采集	ids=多个ID id=当前id sid=start eid=end tid=test
		if($pagetype<3){
			//按列表页采集
			$jumpurl = '?s=Admin-Collect-Caijilist-ids-'.$ids.'-id-'.$id.'-sid-0-eid-'.count($array['list']).'-tid-'.$_GET['tid'].'.html';
		}else{
			//按内容页采集
			$jumpurl = '?s=Admin-Collect-Caijiid-ids-'.$ids.'-id-'.$id.'-sid-0-eid-'.count($array['list']).'-tid-'.$_GET['tid'].'.html';
		}
		redirect($jumpurl);		
	}
	// 按列表页采集
	public function caijilist(){
	    $list = F('_collects/id_'.$_GET['id']);
		$rule = F('_collects/id_'.$_GET['id'].'_rule');
		if(!$list || !$rule){
			$this->error("采集范围或采集规则不正确,请修改！");
		}
		//判断采集范围是否采集完成
		if($_GET['sid'] < $_GET['eid']){
			$listurl = trim($list[$_GET['sid']]);
			$html = ff_file_get_contents($listurl);
			if(!html){
				dump('获取网页'.$url.'数据失败！');
				exit();
			}			
			//编码转换
			if("utf-8" <> $rule['collect_encoding']){
				$html = g2u($html);
			}
			//缩小列表范围
			if(!empty($rule['collect_listurlstr'])){
				$html = ff_preg_match($html,$rule['collect_listurlstr']);
			}
			//列表页采集图片
			if(!empty($rule['collect_listpicstr'])){
				$array_url_pic = ff_preg_match_all($html,$rule['collect_listpicstr']);
				$array_url_pic = preg_replace($replace['1']['patterns'],$replace['1']['replaces'],trim(ff_preg_match($html,$rule['collect_content'])));
			}
			//内容页链接数组
			$array_url_detail = ff_preg_match_all($html,$rule['collect_listlink']);
			//是否倒序
			if(1 == $rule['collect_order']){
				$array_url_pic = ff_krsort_url($array_url_pic);
				$array_url_detail = ff_krsort_url($array_url_detail);
			}
			//获取内容页源码并入库
			foreach($array_url_detail as $key=>$val){
				$list_picurl = preg_replace($replace['0']['patterns'],$replace['0']['replaces'],trim($array_url_pic[$key]));
				$vod = $this->caijimdb(get_base_url($listurl,trim($val)),$rule,$list_picurl,$_GET['tid']);
				dump($vod);
				ob_flush();flush();
			}
		}else{
			F('_collects/id_'.$_GET['id'],NULL);
			F('_collects/id_'.$_GET['id'].'_rule',NULL);
			$this->checknext($_GET['id']);		
			$this->assign("jumpUrl",'?s=Admin-Vod-Show-vod_cid-0');
			$this->success('恭喜你!所有采集任务成功完成!<br><br>点此查看一些相似的影片是否需要入库！');
		}
	}	
	// 按影片ID采集
	public function caijiid(){
	    $list = F('_collects/id_'.$_GET['id']);
		$rule = F('_collects/id_'.$_GET['id'].'_rule');
		if(!$list || !$rule){
			$this->error("采集范围或采集规则不正确,请修改！");
		}
		//判断是否为采集完测试
		if($_GET['tid']){
			$vod = $this->caijimdb(trim($list[$_GET['sid']]),$rule,'',$_GET['tid']);
			$this->caijishow($vod);
			exit();
		}
		//判断采集范围是否采集完成
		if($_GET['sid'] < $_GET['eid']){
			$sid = intval($_GET['sid']);
			for($ii=0;$ii<10;$ii++){//一次采集5个
				$vod = $this->caijimdb(trim($list[$sid]),$rule,'',$_GET['tid']);
				$this->caijishow($vod);
				$sid++;
				if($sid > $_GET['eid']){
					dump('采集完成');
					exit();
				}
			}
			$jumpurl = '?s=Admin-Collect-Caijiid-ids-'.$_GET['ids'].'-id-'.$_GET['id'].'-sid-'.($sid+1).'-eid-'.$_GET['eid'].'-tid-'.$_GET['tid'].'.html';
			$this->caijijumpurl($jumpurl);		
		}
		//判断采集节点是否采集完成
		$this->caijiend($_GET['id']);
	}
	//处理采集内容页并入库		
	public function caijimdb($url,$rule,$picurl='',$tid=''){
		//获取过滤规则
	    $replace = F('_collects/id_'.$rule['collect_id'].'_replace');
		$url = preg_replace($replace['0']['patterns'],$replace['0']['replaces'],$url);
		$html = ff_file_get_contents($url);
		if(!html){
			$vod['vod_state'] = '获取网页'.$url.'数据失败!';
			return $vod;
		}
		//编码转换
		if("utf-8" <> $rule['collect_encoding']){
			$html = g2u($html);
		}
		$vod['vod_cid'] = $rule['collect_cid'];
		if( 0 == $vod['vod_cid']){
			$vod['vod_cid'] = preg_replace($replace['2']['patterns'],$replace['2']['replaces'],trim(ff_preg_match($html,$rule['collect_listname'])));
			$vod['vod_cid'] = getlistid($vod['vod_cid']);
		}
		$vod['vod_name'] = preg_replace($replace['3']['patterns'],$replace['3']['replaces'],trim(ff_preg_match($html,$rule['collect_name'])));
		$vod['vod_title'] = preg_replace($replace['4']['patterns'],$replace['4']['replaces'],trim(ff_preg_match($html,$rule['collect_info'])));			
		$vod['vod_actor'] = preg_replace($replace['5']['patterns'],$replace['5']['replaces'],trim(ff_preg_match($html,$rule['collect_actor'])));
		$vod['vod_director'] = preg_replace($replace['6']['patterns'],$replace['6']['replaces'],trim(ff_preg_match($html,$rule['collect_director'])));
		$vod['vod_content'] = preg_replace($replace['7']['patterns'],$replace['7']['replaces'],trim(ff_preg_match($html,$rule['collect_content'])));	
		if(C('play_collect')){
			$vod['vod_content'] = ff_rand_str($vod['vod_content']);
		}
		//是否列表页获取图片
		if($picurl){
			$vod['vod_pic'] = get_base_url($url,$picurl);
		}else{
			$vod['vod_pic'] = preg_replace($replace['8']['patterns'],$replace['8']['replaces'],trim(ff_preg_match($html,$rule['collect_pic'])));
			$vod['vod_pic'] = get_base_url($url,$vod['vod_pic']);
		}
		$vod['vod_continu'] = preg_replace($replace['9']['patterns'],$replace['9']['replaces'],trim(ff_preg_match($html,$rule['collect_continu'])));
		if(empty($vod['vod_continu'])){
			$vod['vod_continu'] = 0;
		}
		$vod['vod_area'] = preg_replace($replace['10']['patterns'],$replace['10']['replaces'],trim(ff_preg_match($html,$rule['collect_area'])));
	$vod['vod_language'] = preg_replace($replace['11']['patterns'],$replace['11']['replaces'],trim(ff_preg_match($html,$rule['collect_language'])));
		$vod['vod_year'] = preg_replace($replace['12']['patterns'],$replace['12']['replaces'],trim(ff_preg_match($html,$rule['collect_year'])));
		//默认值
		$vod['vod_savepic'] = $rule['collect_savepic'];
		$vod['vod_addtime'] = time();
		$vod['vod_inputer'] = 'collect'.$rule['collect_id'];
		$vod['vod_stars'] = 1;
		$vod['vod_letter'] = ff_letter_first($vod['vod_name']);
		$vod['vod_play'] = $rule['collect_player'];
		$vod['vod_reurl'] = $url;
		//是否缩小地址范围
		if(!empty($rule['collect_urlstr'])){
			$html = ff_preg_match($html,$rule['collect_urlstr']);
		}
		//是否采集分集名称
		if(!empty($rule['collect_urlname'])){
			$arrname = ff_preg_match_all($html,$rule['collect_urlname']);
		}
		$arrurl = ff_preg_match_all($html,$rule['collect_urllink']);
		$playurl = '';
		foreach($arrurl as $key=>$val){
			if(is_array($arrname)){
				$playname = $arrname[$key].'$';
			}else{
				$playname = '';
			}
			//播放页是否新窗口
			if(!empty($rule['collect_url'])){
				$val = preg_replace($replace['url']['patterns'],$replace['url']['replaces'],$val);
				$html = ff_file_get_contents(get_base_url($url,$val));
				if("utf-8"<>$rule['collect_encoding']){
					$html = g2u($html);
				}
				$playurl = $playurl.chr(13).$playname.trim(ff_preg_match($html,$rule['collect_url']));
			}else{
				$playurl = $playurl.chr(13).$playname.trim($val);
			}
		}
		$vod['vod_url'] = trim(preg_replace($replace['13']['patterns'],$replace['13']['replaces'],$playurl));
		//处理是否写入数据
		if($tid){
			$vod['vod_state'] = '采集测试，数据不写入数据库!';
		}else{
			$vod['vod_state'] = $this->xml_insert($vod);
		}
		return $vod;
	}
	//定时采集
	public function dingshi(){
	if(in_array(date("w"),$_POST['collect_week'])){
		if(in_array(date("H"),$_POST['collect_hour'])){
			$gid=implode(',',$_REQUEST['collect_id']);
			$gid='?s=Admin-Collect-Ing-collect_id-'.$_REQUEST['collect_id'][0].'-gid-1,'.$gid;
		}
	}
	$this->assign('gid',$gid);
	$this->display(APP_PATH.'/Public/admin/collect.html');
	}		
	// 生成采集列表缓存/采集规则缓存/替换规则缓存
	public function caijicreateurl($id){
		$rs = M("Collect");
		$array = $rs->where('collect_id='.$id)->find();
		if(!$array){
			exit();			
		}
		// 组合替换规则($rule)
		foreach($array as $key =>$val){
			if(strpos($val,'[$ppvod]')>0){
				$rule[$key] = ff_replace_rule($val);
			}else{
				$rule[$key] = $val;
			}
		}
		//组合采集范围($listurl)
		if($array['collect_pagetype']==2 || $array['collect_pagetype']==3){
			for($i=0;$i <= abs(intval($array['collect_pagesid']-$array['collect_pageeid']));$i++){
				$listurl[$i] = str_replace('[$ppvod]',$i+$array['collect_pagesid'],$array['collect_pagestr']);
			}
		}elseif($array['collect_pagetype']==1 || $array['collect_pagetype']==4){
			$listurl = explode(chr(13),$array['collect_liststr']);
		};
		//是否倒序($listurl)
		if(1 == $array['collect_order']){
			$listurl = ff_krsort_url($listurl);
		}	
		//生成采集范围与采集规则缓存
		F('_collects/id_'.$id,$listurl);
		F('_collects/id_'.$id.'_rule',$rule);
		//生成替换规则缓存
		$arr_replace = explode('|||',$array['collect_replace']);
		foreach($arr_replace as $i=>$v1){
			foreach(explode(chr(13),trim($v1)) as $j=>$v){
				list($key,$val) = explode('$$$',trim($v));
				$arr1[$j] = '/'.trim(stripslashes($key)).'/si';
				$arr2[$j] = trim($val);
			}
			$arr[$i] = array('patterns'=>$arr1,'replaces'=>$arr2);
		}
		F('_collects/id_'.$id.'_replace',$arr);	
		//返回采集列表与规则数组
		return array('list'=>$listurl,'rule'=>$rule);
	}	
	//显示采集信息
	public function caijishow($vod){
		echo('<div style="font-size:12px;margin-bottom:5px;">');
		echo('影片：'.$vod['vod_name'].'<br />');
		echo('主演：'.$vod['vod_actor'].'<br />');
		echo('图片：<a href="'.$vod['vod_pic'].'" target="_blank">'.$vod['vod_pic'].'</a><br />');
		echo('来源：<a href="'.$vod['vod_reurl'].'" target="_blank">'.$vod['vod_reurl'].'</a><br />');
		echo('状态：<font color=red>'.$vod['vod_state'].'</font><br />');
		echo('</div>');
		ob_flush();flush();		
	}	
	//采集节点跳转
	public function caijijumpurl($jumpurl){
		echo('<div style="font-size:12px;margin-bottom:5px;color:read">');
		echo C('play_collect_time').'秒后将自动采集下一页!';
		echo('</div>');
		echo '<meta http-equiv="refresh" content='.C('play_collect_time').';url='.$jumpurl.'>';
		ob_flush();flush();
		exit();
	}	
	//检测采集任务是否完成
	public function caijiend($id){
		$this->checknext($_GET['id']);
		F('_collects/id_'.$_GET['id'],NULL);
		F('_collects/id_'.$_GET['id'].'_rule',NULL);
		F('_collects/id_'.$_GET['id'].'_replace',NULL);
		$this->assign("jumpUrl",'?s=Admin-Vod-Show-vod_cid-0');
		$this->success('恭喜你!所有采集任务成功完成!<br><br>点此查看一些相似的影片是否需要入库！');	
	}	
	//判断与处理下一个采集节点转向地址
	public function checknext($string){
		if(!empty($string)){
			$gid=explode(',',$string);
			$collect_nowid=$gid[0];
			$gid[0]=$collect_nowid+1;
			$collect_nexturl='?s=Admin-Collect-Ing-collect_id-'.$gid[$gid[0]];	
			$collect_count=count($gid)-1;
			$gid=implode(',',$gid);
			$collect_nexturl=$collect_nexturl.'-gid-'.$gid;//生成下一个采集节点地址
			if($collect_nowid==$collect_count){
				if(c('url_html')){
					header("Location: ?s=Admin-Html-Showvod-did-1-gid-1");//生成当天静态
				}else{
					if(c('html_cache_on')){
					header("Location: ?s=Admin-Cache-Vodday");//清空当天缓存
					}
				}
			}else{
				header("Location: ".$collect_nexturl."");
			}
		}
	}
	// 写入替换规则缓存
    public function f_replace($rearr,$collectid){
		foreach($rearr as $i=>$v1){
			foreach(explode(chr(13),trim($v1)) as $j=>$v){
				list($key,$val)=explode('$$$',trim($v));
				$arr1[$j]='/'.trim(stripslashes($key)).'/si';
				$arr2[$j]=trim($val);
			}
			$arr[$i]=array('patterns'=>$arr1,'replaces'=>$arr2);
		}				
		F('_collects/id_'.$collectid.'_replace',$arr);
		return $arr;   
	}				
}
?>