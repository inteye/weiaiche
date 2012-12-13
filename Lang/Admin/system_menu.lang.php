<?php

global $_LANG;

$_LANG['admin_menu_list']['system'][] = array(
	'name' => '网站设置',
	'url' => U('admin/index/configure'),
	'permission' => 'system.configure',
);

$_LANG['admin_menu_list']['system'][] = array(
	'name' => '管理员管理',
	'url' => U('admin/manager/l'),
	'permission' => 'system.manager',
);

?>