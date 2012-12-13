<?php

function checklogin() {
	$key   = "1x8K$8yrG8#5CzTw7u^ntci8t@iw4OWQ3";
	$token = cookie("Login");
	if (empty($token) === TRUE) {
		return false;
	} else {
		list($uid, $utoken) = explode(',', $token);
		$valcode = md5($uid.','.$key);
		if ($valcode != $utoken) {
			return false;
		} else {
			$user = array(
				'userid'   => $uid,
				'username' => cookie('username')
			);
			session('user', $user);
			return $user;
		}
	}
}

function auth() {
	//$is_login = checklogin();
	if (empty($_SESSION['user']) === TRUE) {
		cookie('refer', 'http://west.kting.cn/', array('domain', '.kting.cn'));
		redirect('http://www.kting.cn/user-login', 3, '您尚未登录或已经超时，请重新登录');
	}
}

function auth_admin() {
	if (! $_SESSION['is_admin']) {
		redirect(U('admin/index/login'));
	}
}

function getUnixTime() {
	date_default_timezone_set('PRC');
	return time();
}

function getFullTime() {
	date_default_timezone_set('PRC');
	return date('Y-m-d H:i:s');
}

function getFormatDatetime($unixtime, $format = 'Y-m-d H:i:s') {
	return gmdate($format, $unixtime);
}

function getTimeToStr($time){
	$unixtime = strtotime($time);
	$diff = time() - $unixtime;
	if ($diff < 60 * 10){
		return "刚刚";
	}elseif($diff <  60 * 60){
		return "半小时前";
	}elseif($diff < 60 * 60 * 2){
		return "一小时前";
	}elseif($diff < 60 * 60 * 3){
		return "2小时前";
	}elseif($diff < 60 * 60 * 4){
		return "三小时前";
	}elseif($diff < 60 * 60 * 5){
		return "四小时前";
	}elseif($diff < 60 * 60 * 12){
		return "五小时前";
	}else{
		return $time;
	}

}

/**
 * 加载语言包
 *
 * @param string $sFile 语言包文件名
 * @access public
 * @return null
 */
function LoadLanguage($sFile)
{
	if (! strlen($sFile))
	{
		return;
	}
	$s_file_path   = __ROOT__ . 'Lang/Admin/' . $sFile . '.lang.php';
	@ include_once $s_file_path;
}

/**
 * 获得语言
 *
 * @param string $sName 语言变量名
 * @access public
 * @return string
 */
function GetLanguage($sName)
{
	global $_LANG;
	if (! strlen($sName))
	{
		return '';
	}
	else
	{
		return isset($_LANG[$sName]) ? $_LANG[$sName] : '';
	}
}

/**
 * 检测是否拥有该权限
 *
 * @param string $sAction 操作动作
 * @return boolean
 */
function has_permission($sAction)
{
	//超级管理员 super 能操作所有的
	if (get_manager_info('level') == 10)
	{
		return TRUE;
	}
	//普通管理员
	$b_permission = FALSE;

	if (strpos($sAction, '.') === FALSE)
	{
		//入口权限检测
		$b_permission = (strpos(get_manager_info('permission'), $sAction) !== FALSE);
	}
	else
	{
		//具体权限检测
		$a_permission = unserialize(get_manager_info('permission'));
		if (is_array($a_permission))
		{
			$b_permission = in_array($sAction, $a_permission);
		}
	}
	return $b_permission;
}

/**
 * 检测权限
 *
 * @param string $sAction 操作动作
 * @return null
 */
function check_permission($sAction)
{
	$b_permission = has_permission($sAction);
	if (! $b_permission)
	{
		exit('no permission');
	}
}

/**
 * 获得管理员信息
 *
 * @param string $sName 信息名称
 * @return string
 */
function get_manager_info($sName)
{
	$a_manager_data = session('manager_data');
	return isset($a_manager_data[$sName]) ? $a_manager_data[$sName] : '';
}

function get_thumb_photo($source, $size = 80) {
	return str_replace('.', '_thumb_'.$size.'.', $source);
}
