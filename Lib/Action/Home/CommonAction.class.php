<?php
// 本类由系统自动生成，仅供测试用途
class CommonAction extends Action {
	
	public function _initialize() {
		$conf = self::formatConfigure(self::getConfigure());
		$this->assign('configure', $conf);
	}

	public function verify() {
		import("ORG.Util.Image");
		Image::buildImageVerify();
	}

	public function getConfigure() {
		$M    = D('Configure');
		$list = $M->select();
		$cnt  = count($list);
		for ($i = 0; $i < $cnt; $i++)
		{
			if (! is_numeric($list[$i]['value']))
			{
				$list[$i]['value'] = str_replace("'", "\'", $list[$i]['value']);
			}
		}
		return $list;
	}
	
	protected function formatConfigure($conf) {
		$config = array();
		foreach($conf as $c) {
			$config[$c['variable']] = $c['value'];
		}
		return $config;
	}

}
