<?php 

/**
 * 权限控制模型
 * @author panduo 
 * 2016-4-8
 */
use \Library\M;
use \Library\Query;
use \Library\tool;
class RbacModel{
	private $role;//角色模型
	private $node;//权限节点模型
	private $access;//授权中间模型
	private $role_user;//用户分组中间模型
	private $admin;//管理员表

	public function __construct(){
		$this->admin = new M('admin');
		$this->role = new M('admin_role');
		$this->node = new M('admin_node');
		$this->access = new M('admin_access');
		$this->role_user = new M('admin_role_user');
	}

	//角色规则
	protected $roleRules = array(
		array('id','number','id错误',0,'regex'),
		array('name','/^\S{2,20}$/','分组名格式错误',0,'regex'),
		array('remark','/^\S{2,50}$/','备注格式错误',0,'regex'),
		array('status','number','状态错误',0,'regex'),
	);

	//节点规则
	protected $nodeRules = array(
		array('id','number','id错误',0,'regex'),
		array('module_name','/^\S{2,50}$/','模块名格式错误',0,'regex'),
		array('controller_name','/^\S{2,50}$/','控制器名格式错误',0,'regex'),
		array('action_name','/^\S{2,50}$/','动作方法名格式错误',0,'regex'),
		array('module_title','/^\S{2,50}$/','模块标题格式错误',0,'regex'),
		array('controller_title','/^\S{2,50}$/','控制器格式错误',0,'regex'),
		array('action_title','/^\S{2,50}$/','动作方法标题格式错误',0,'regex'),
	);

	/**
	 * 获取角色列表
	 * @return [type] [description]
	 */
	public function roleList($page,$pagesize=5,$where = ''){
		$Q = new Query('admin_role');
		$Q->page = $page;
		$Q->pagesize = $pagesize;
		if($where)$Q->where = $where;
		$data = $Q->find();
		$pageBar =  $Q->getPageBar();
		return array('data'=>$data,'bar'=>$pageBar);
	}

	/**
	 * 添加/编辑角色
	 */
	public function roleUpdate($data){
		if($this->role->data($data)->validate($this->roleRules)){
			if(isset($data['id']) && $data['id']>0){
				$id = $data['id'];
				if(isset($data['name']) && $this->existRole(array('name'=>$data['name'],'id'=>array('neq',$id)))){
					return tool::getSuccInfo(0,'用户名已注册');
				}
				unset($data['id']);
				$res = $this->role->where(array('id'=>$id))->data($data)->update();
				$res = is_int($res) && $res>0 ? true : ($this->role->getError() ? $this->role->getError() : '数据未修改');
			}else{
				if($this->existRole(array('name'=>$data['name']))){
					return tool::getSuccInfo(0,'用户名已注册');
				}
				$res = $this->role->add();
				$new_id = $res;
				$res = intval($res)>0 ? true : $this->role->getError();
			}	
		}else{
			$res = $this->role->getError();
		}
		if($res === true){
			$log = new \Library\log();

			if(isset($id)){
				$log->addLog(array('table'=>'admin_role','type'=>'update','id'=>$id));
			}
			if(isset($new_id)){
				$log->addLog(array('table'=>'admin_role','type'=>'add','id'=>$new_id));
			}
			$resInfo = tool::getSuccInfo();
		}
		else{
			$resInfo = tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
		}
		return $resInfo;
	}

	/**
	 * 判断角色名称是否存在
	 * @return [type] [description]
	 */
	public function existRole($roleData){
		$data = $this->role->fields('id')->where($roleData)->getObj();
		return empty($data) ? false : true;
	}

	/**
	 * 根据id获取角色信息
	 * @param  int $id 
	 * @return array
	 */
	public function roleInfo($id){
		if(isset($id) && $id>0){
			$info = $this->role->where(array('id'=>$id))->getObj();
		}
		return $info ? $info : array();
	}

	/**
	 * 根据分组id删除角色（同时删除相关用户角色分配信息）
	 * @param  int $id 管理员id		
	 */
	public function roleDel($id){
		$role = $this->role;
		if(($id = intval($id))>0){
			$tag = $role->where(array('id'=>$id))->getField('tag');
			if($tag!='')
				return tool::getSuccInfo(0,'该角色不可删除');
			try {
				$role->beginTrans();

				$role->where(array('id'=>$id))->delete();
				$this->admin->where(array('role'=>$id))->data(array('role'=>0))->update();
				$log = new \Library\log();
				$log->addLog(array('table'=>'管理员角色','type'=>'delete','id'=>$id));
				$res = $role->commit();
			} catch (PDOException $e) {
				$role->rollBack();
				$res = $e->getMessage();
			}
			
		}else{
			$res = '参数错误';
		}

		if($res===true){
			$resInfo = tool::getSuccInfo();
		}
		else{
			$resInfo = tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
		}
		return $resInfo;		
	}


	/**
	 * 获取所有模块列表
	 * @return [type] [description]
	 */
	public function moduleList(){
		$app_path = rtrim(APPLICATION_PATH,'/').'/application/modules';
		$dir_path = @glob($app_path."/*");
		foreach ($dir_path as $key => $value) {
			$dir_name = basename($value);
			if(!is_dir($value) || in_array(strtolower($dir_name),array('deal','libs'))){
				continue;
			}
			$dirs []= $dir_name;
		}

		return $dirs;
	}

	/**
	 * 获取某一模块下所有的控制器名称
	 * @param string 模块名
	 * @return array 控制器数组
	 */
	public function controllerList($module='admin',$to_html = false){
		//缓存TODO
		if(!$module)
			return tool::getSuccInfo(0,'参数错误');
		$controller_path = rtrim(APPLICATION_PATH,'/').'/application/modules/'.$module.'/controllers/';
		if(!is_dir($controller_path)) return tool::getSuccInfo(0,'无指定模块');
		$controller_path .= "*.php";
		$controllers = @glob($controller_path);

		$controllers_html = '<option value="-1">请选择</option>';
		foreach ($controllers as $key => $value) {
			$value = basename($value,'.php');
			$controller_name []= $value;
			if($to_html === true){
				$controllers_html .= "<option value='{$value}'>{$value}</option>";
			}
		}
		
		//查询节点表中的标题
		$title = $this->node->where(array('name'=>$module,'level'=>1))->getField('title');
		$resInfo =  tool::getSuccInfo();
		$resInfo['controllers'] = $to_html === true ? $controllers_html : $controller_name;
		$resInfo['title'] = $title ? $title : '';	
		return $resInfo;
	}

	/**
	 * 获取指定控制器下的action 列表 （过滤特殊方法/查询不在数据库中的action）
	 * @param  [type] $controller [description]
	 * @param  bool   notin_db  是否只取不在数据库中的
	 * @return [type]             [description]
	 */
	public function actionList($module,$controller,$to_html = false,$notin_db = false){
		//缓存 TODO
		$path = rtrim(APPLICATION_PATH,'/')."/application/modules/".$module."/controllers/".$controller.'.php';
		if(!file_exists($path)){
			$resInfo = tool::getSuccInfo(0,$controller.'.php文件不存在');
		}else{
			if($controller != 'Rbac')
				include_once $path;	
			$class_name = $controller."Controller";
			if(class_exists($class_name)){
				$obj = new $class_name();
				$actions = get_class_methods($obj);
				if($notin_db){
					//获取数据库中的action列表
					$tmp_db_actions = $this->node->where(array('level'=>3))->fields('name')->select();
					foreach ($tmp_db_actions as $value) {
						$db_actions []= $value['name'].'Action';
					}
					$actions = array_diff($actions,$db_actions);
				}
				$actions_html = '<option value="-1">请选择</option>';
				foreach ($actions as $key => $value) {
					if(!strpos($value,'Action')){
						unset($actions[$key]);
						continue;
					}
					$value = str_replace('Action','',$value);
					$action_name []= $value;
					if($to_html === true){
						$actions_html .= "<option value='{$value}'>{$value}</option>";
					}
				}
				$resInfo = tool::getSuccInfo();
				$resInfo['actions'] = $to_html === true ? $actions_html : $action_name;	
			}else{
				$resInfo = tool::getSuccInfo(0,$controller.'Controller类不存在');
			}
		}
		
		//查询节点表中的标题
		$title = $this->node->where(array('name'=>$controller,'level'=>2))->getField('title');
		$resInfo['title'] = $title ? $title : '';	
		return $resInfo;
	}

	/**
	 * 获取指定action的标题
	 * @return [type] [description]
	 */
	public function actionTitle($module_name,$controller_name,$action_name){
		$query = new Query('admin_node as n1');
		$query->join = 'left join admin_node as n2 on n1.id = n2.pid left join admin_node as n3 on n2.id = n3.pid';
		$query->where = " n1.name = '$module_name' and n2.name = '$controller_name' and n3.name = '$action_name'";
		$query->fields = "n3.title";
		$res = $query->getObj();
		
		$title = isset($res['title']) ? $res['title'] : '';
		$resInfo = tool::getSuccInfo();
		$resInfo['action_title'] = $title;
		return $resInfo;
	}

	/**
	 * 权限节点入库
	 * @param  $data array 表单数据
	 * @return 
	 */
	public function nodeAdd($data){
		if(!isset($data['module_name'])){
			$res = '参数错误';	
		}else{
			if($this->node->data($data)->validate($this->nodeRules)){
				//查询是否已在节点表中
				try {
					//strtolower?
					$this->node->beginTrans();
					$module_info = $this->node->where(array('name'=>$data['module_name'],'level'=>1))->getObj();
					if(!isset($module_info['id'])){
						if(isset($data['module_title'])){
							$module_data['name'] = $data['module_name'];
							$module_data['level'] = 1;
							$module_data['pid'] = 0;
							$module_data['title'] = $data['module_title'];
							$module_id = $this->node->data($module_data)->add();
							//$module_id = $this->node->lastInsertId();
						}
					}elseif(($module_id = $module_info['id']) && $module_info['title'] != $data['module_title']){
						//更新标题
						$this->node->where(array('id'=>$module_id))->data(array('title'=>$data['module_title']))->update();
					}
					//控制器节点
					if(isset($data['controller_name'])){
						$controller_info = $this->node->where(array('name'=>$data['controller_name'],'level'=>2,'pid'=>$module_id))->getObj();
						if(!isset($controller_info['id'])){
							if(isset($data['controller_title'])){
								$controller_data['name'] = $data['controller_name'];
								$controller_data['level'] = 2;
								$controller_data['pid'] = $module_id;
								$controller_data['title'] = $data['controller_title'];
								$controller_id = $this->node->data($controller_data)->add();
								//$controller_id = $this->node->lastInsertId();
							}
						}elseif(($controller_id = $controller_info['id']) && isset($data['controller_title']) && $controller_info['title'] != $data['controller_title']){
							//更新标题
							$this->node->where(array('id'=>$controller_id))->data(array('title'=>$data['controller_title']))->update();
						}
					}
					//action节点
					if(isset($data['action_name'])){
						$action_info = $this->node->where(array('name'=>$data['action_name'],'level'=>3,'pid'=>$controller_id))->getObj();
						if(!isset($action_info['id'])){
							if(isset($data['action_title'])){
								$action_data['name'] = $data['action_name'];
								$action_data['level'] = 3;
								$action_data['pid'] = $controller_id;
								$action_data['title'] = $data['action_title'];
								$this->node->data($action_data)->add();
							}
						}elseif(($action_id = $action_info['id']) && isset($data['action_title']) && $action_info['title'] != $data['action_title']){
							//更新标题
							$this->node->where(array('id'=>$action_id))->data(array('title'=>$data['action_title']))->update();
						}
					}
					$res = $this->node->commit();
				} catch (PDOException $e) {
					$this->node->rollBack();
					$res = $e->getMessage();
				}	
			}else{
				$res = $this->node->getError();
			}
			
		}
		if($res==true){
			$log = new \Library\log();
			$log->addLog(array('content'=>'添加了一个权限节点'));
		}
		return $res === true ? tool::getSuccInfo() : tool::getSuccInfo(0,$res && is_string($res) ? $res : '未知错误,请重试');
	}

	//节点的子节点信息
	public function nodeChild($id){
		return count($this->node->where(array('pid'=>$id))->select());
	}

	public function singleNodeDel($id){
		return $this->node->where(array('id'=>$id))->delete() ? true : '删除失败';
	}

	/**
	 * 删除节点
	 * @param  int $node_id 节点id
	 * @return array
	 */
	public function nodeDel($node_id){
		$child = $this->nodeChild($node_id);
		$res = $child > 0 ? '有子节点,无法删除' : $this->singleNodeDel($node_id);
		
		return $res === true ? tool::getSuccInfo() : tool::getSuccInfo(0,$res);
	}

	/**
	 * 获取节点树(三层)
	 * TODO 将sql移出递归
	 * @return array
	 */
	public function nodeTree($pid = 0,$level = 1,$role_id = 0){
		//缓存TODO
		$query = new Query('admin_node as n');
		$where = ' n.level='.$level.' and n.pid= '.$pid.' and n.status=0';
		if(is_int($role_id) && $role_id > 0){
			$query->join = ' right join admin_access as a on n.id = a.node_id ';
			$where .= ' and a.role_id = '.$role_id;
		}
		//$where = array('level'=>$level,'pid'=>$pid,'status'=>0);
		$query->fields = " n.id,n.title,n.level";
		//$data = $this->node->fields('id,title,level')->where()->select();
		//
		
		$query->where = $where;
		$data = $query->find();
		foreach ($data as $key => &$value) {
			$action_array = array();
			if(!isset($value['_child']) && $level != 2){
				$value['_child'] = $this->nodeTree($value['id'],$level+1,$role_id);
			}else{
				$actions = $this->nodeTree($value['id'],$level+1,$role_id);
				foreach ($actions as $k => &$v) {
					$title = explode(',',$v['title']);
					$v['title'] = isset($title[1]) ? $title[1] : $title[0];
					$pre = isset($title[0]) ? $title[0] : '未分类';
					$action_array [$pre][] = $v;
				}
				$value['_child'] = $action_array;
			}
		}
		return $data;
	}

	/**
	 * 获取某一个角色已入库的所有节点
	 * @param  int $role_id 角色id		
	 * @return array
	 */
	public function accessArray($role_id){
		$res = $this->access->where(array('role_id'=>$role_id))->select();
		if(count($res) > 0){
			foreach ($res as $key => $value) {
				$node_ids []= $value['node_id'];
			}
		}
		return isset($node_ids) ? $node_ids : array();
	}

	/**
	 * 为角色授权
	 * @param  int $role_id 角色id
	 * @param  array $node_id 节点数组
	 * @return array 状态信息
	 */
	public function accessAdd($role_id,$node_id=array()){
		if(isset($role_id) && $role_id>0 && is_array($node_id)){
			$data = array();
			foreach ($node_id as $key => $value) {
				$data []= array('role_id'=>$role_id,'node_id'=>$value);
			}
			try {
				$this->access->beginTrans();
				$this->access->where(array('role_id'=>$role_id))->delete();
				if(count($data)>0)
					$this->access->data($data)->adds();	
				$res = $this->access->commit();
			} catch (PDOException $e) {
				$this->access->rollBack();
				$res = $e->getMessage();
			}
		}else{
			$res = '参数错误';
		}
		if($res === true){
			$log = new Library\log();
			$log->addLog(array('content'=>'为id为'.$role_id.'的角色分配权限'));
			$resInfo = tool::getSuccInfo();
		}else{
			$resInfo = tool::getSuccInfo(0,is_string($res) && $res ? $res : '未知错误,请重试');
		}
		return $resInfo;
	}

	/**
	 * 根据id获取管理员分组
	 * @param  int    $id  管理员id
	 * @return string $res 分组描述
	 */	
	public function adminRole($id){
		$info = $this->role->where(array('id'=>$id))->getField('name');
		return $info ? $info : '无分组';
	}
}
?>



