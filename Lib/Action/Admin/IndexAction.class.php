<?php

class IndexAction extends CommonAction {

	public function _initialize() {
		C('TMPL_ACTION_ERROR', THINK_PATH.'/Tpl/dispatch_jump.tpl');
		C('TMPL_ACTION_SUCCESS', THINK_PATH.'/Tpl/dispatch_jump.tpl');
	}

	public function index() {
		auth_admin();
		$this->assign("username", $_SESSION['adminname']);
		$this->display();
	}

	public function logout() {
		unset($_SESSION['is_admin']);
		unset($_SESSION['adminname']);
		redirect(U('admin/index/login'));
	}

	public function login() {
		if ($this->isPost()) {
			$M = D("Manager");
			if ($M->create()) {
				if($_SESSION['verify'] != md5($_POST['verify'])) {
					$this->error("验证码错误");
				} else if(! $M->where("username='".$_POST['username']."' AND password='".md5($_POST['password'])."'")->count()){
					$this->error("用户名或密码错误");
				} else {
					session("is_admin", TRUE);
					session("adminname", $_POST['username']);
					session('manager_data', $M->where("username='".$_POST['username']."' AND password='".md5($_POST['password'])."'")->find());
					redirect(U('/admin/index'));
				}
			} else {
				$this->error($M->getError());
			}
		}
		$this->display();
	}

	public function welcome() {
		$this->assign('system_os', PHP_OS);
		$this->assign('system_web_server', @ $_SERVER['SERVER_SOFTWARE']);
		$this->assign('system_php_version', PHP_VERSION);
		$this->assign('system_mysql_version', mysql_get_server_info());
		$this->display();
	}

	public function configure() {
		auth_admin();
		$M = M("Configure");
		$list = $M->select();
		$count = count($list);
		for ($i = 0; $i < $count; $i++)
		{
			$list[$list[$i]['variable']] = $list[$i];
			$GLOBALS['post_data'][$list[$i]['variable']] = $list[$i]['value'];
		}
		if ($this->isPost()) {
			foreach ($GLOBALS['post_data'] as $s_key => $s_value)
			{
				$M->where("variable='{$s_key}'")->save(array(
						'value' => $_POST[$s_key]
				));
			}
			$this->success("网站设置修改成功");
			exit;
		}
		$this->assign("configure_list", $list);
		$this->assign("post_data", $GLOBALS['post_data']);
		$this->display();
	}

	public function menu() {
		LoadLanguage('common');
		//读取菜单数组
		$a_admin_menu_group_list = GetLanguage('admin_menu_group_list');
		$a_menu_list = array();
		$a_sub_menu_list = array();

		//获取主菜单列表
		foreach ($a_admin_menu_group_list as $s_key => $s_value)
		{
			if (has_permission($s_key))
			{
				$a_menu_list[] = array('id' => $s_key, 'title' => $s_value);

				//加载子菜单列表
				LoadLanguage($s_key . '_menu');
			}
		}

		//获得子菜单列表
		$a_admin_menu_list = GetLanguage('admin_menu_list');
		if (is_array($a_admin_menu_list))
		{
			foreach ($a_admin_menu_list as $s_key => $s_value)
			{
				$i_count = count($a_admin_menu_list[$s_key]);
				for ($i = 0; $i < $i_count; $i++)
				{
					$a_permission = explode('|', $a_admin_menu_list[$s_key][$i]['permission']);
					$b_has_permission = FALSE;
					foreach ($a_permission as $s_permission)
					{
						if (has_permission($s_permission))
						{
							$b_has_permission = TRUE;
						}
					}
					if ($b_has_permission)
					{
						$a_admin_menu_list[$s_key][$i]['id'] = $s_key;
						$a_sub_menu_list[] = $a_admin_menu_list[$s_key][$i];
					}
				}
			}
		}
		$this->assign('menu', $a_menu_list);
		$this->assign('sub_menu', $a_sub_menu_list);
		$this->display();
	}

}