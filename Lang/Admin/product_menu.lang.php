<?php

global $_LANG;

$_LANG['admin_menu_list']['product'][] = array(
	'name' => '产品管理',
	'url'  => U('admin/product/lists'),
	'permission' => 'product.add|product.edit|product.batch',
);

$_LANG['admin_menu_list']['product'][] = array(
	'name' => '产品分类',
	'url'  => U('admin/category/lists', 'category=1'),
	'permission' => 'product.cateadd|product.cateedit|product.catedelete',
);

$_LANG['admin_menu_list']['product'][] = array(
	'name' => '产品型号',
	'url'  => U('admin/category/lists', 'category=2'),
	'permission' => 'product.xhadd|product.xhedit|product.xhdelete',
);

$_LANG['admin_menu_list']['product'][] = array(
	'name' => '品牌管理',
	'url'  => U('admin/category/lists', 'category=3'),
	'permission' => 'product.bandadd|product.bandedit|product.banddelete',
);

$_LANG['admin_menu_list']['product'][] = array(
	'name' => '供应商管理',
	'url'  => U('admin/category/lists', 'category=4'),
	'permission' => 'product.vendoradd|product.vendoredit|product.vendordelete',
);

$_LANG['admin_menu_list']['product'][] = array(
	'name' => '属性管理',
	'url'  => U('admin/attribute/lists'),
	'permission' => 'product.attradd|product.attredit|product.attrbatch',
);

/*$_LANG['admin_menu_list']['info'][] = array(
	'name' => '信息分类管理',
	'url' => U('admin_infocate/l'),
	'permission' => 'info.category_add|info.category_edit|info.category_delete',
);*/

?>