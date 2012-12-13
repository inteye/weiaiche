<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends CommonAction {

	public function index(){
		$this->display();
	}
	
	public function login() {
		if ($this->isPost()) {
			$pass = $_POST['pass'];
			$M = D("Shop");
			$cnt = $M->where("pass='{$pass}'")->count();
			if (! $cnt) {
				$this->assign("error", "登录密码错误");
			} else {
				session('islogin', true);
				redirect(U('index'));
			}
		}
		$this->display();
	}
	
	public function exchange() {
		$code = $_POST['code'];
		if (! strlen($code)) {
			$this->error("请输入兑奖码");
		}
		$Gift = D("Gift");
		$data = $Gift->where("card='{$code}'")->find();
		if (empty($data) === true) {
			exit(self::jsondata(array('code' => $code), 1, '号码错误'));
		}
		if ($data['usetime'] || $data['uid']) {
			exit(self::jsondata(array('code' => $code, 'usetime' => getFormatDatetime($data['usetime'], 'Y.m.d H:i:s')), 2, '已使用'));
		}
		session('gift', $data);
		exit(self::jsondata(array(), 0));		
	}
	
	public function show() {
		$giftinfo = session('gift');
		if (is_null($giftinfo)) {
			redirect(U('index'));
		}
		$this->assign('gift', $giftinfo);
		$this->display();
	}
	
	public function success() {
		$giftinfo = session('gift');
		if (is_null($giftinfo)) {
			redirect(U('index'));
		}
		$Gift = D("Gift");
		$updata = array(
			'usetime' => getUnixTime(),
			'uid'	  => $_SESSION['uid']
		);
		$Gift->where("id={$giftinfo['id']} AND usetime = 0 AND uid = 0")->save($updata);
		session('gift', null);
		$this->display();
	}
	
	private static function jsondata($data, $status = 0, $msg = '') {
		$data = array(
			'tp'   => $status,
			'err'  => $msg,
			'data' => $data
		);
		return json_encode($data);
	}
	
}