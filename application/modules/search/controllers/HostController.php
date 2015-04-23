<?php

/**
 * Description of HostController
 *
 * @author mleko
 */
class Search_HostController extends Zend_Controller_Action {

	public function fzlistAction() {
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_response->setHeader('Content-Type', 'text/plain; charset=UTF-8');

		$se_list = array("10.5.2.67", "10.12.12.12", "10.8.10.12");

		$append = array();
		foreach($se_list as $value) {
			$append[$value] = TRUE;
		}

		$content = '';
		$hosts = App_Host::ShareList(1024 * 1024 * 1024, 0.1, 1);
		foreach($hosts as $host) {
			$ip = long2ip($host['host']);
			$content .= $ip . "\r\n";
			if(in_array($ip, $se_list)) { unset($append[$ip]); }
		}
		foreach($append as $key => $value) {
			if($value) { $content .= "$key\r\n"; }
		}

		$this->_response->setBody($content);
	}

	public function listAction() {
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_response->setHeader('Content-Type', 'text/plain; charset=UTF-8');

		$se_list = array("10.5.2.67", "10.12.12.12", "10.8.10.12");

		$append = array();
		foreach($se_list as $value) {
			$append[$value] = TRUE;
		}

		$content = '';
		$hosts = App_Host::ShareList();
		foreach($hosts as $host) {
			$ip = long2ip($host['host']);
			$content .= $ip . ';' . $host['shared'] . ';' . $host['uptime'] . ";" . ($host['blacklist'] ? '1' : '0') . "\r\n";
			if(in_array($ip, $se_list)) { unset($append[$ip]); }
		}
		foreach($append as $key => $value) {
			if($value) { $content .= "$key;0;1;0\r\n"; }
		}

		$this->_response->setBody($content);
	}

	public function blacklistAction() {
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_response->setHeader('Content-Type', 'text/plain; charset=UTF-8');

		$content = '';
		$hosts = App_Host::BlackList();
		foreach($hosts as $host) {
			$ip = long2ip($host['host']);
			$content .= $ip . "\r\n";
		}

		$this->_response->setBody($content);
	}

	public function addAction() {
		$ip = $this->_getParam('ip', NULL);
		$pattern = '/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/';
		$ips = explode(';', $ip);
		foreach($ips as $ip) {
			if($ip && preg_match($pattern, $ip)) {
				App_Host::Add($ip);
			}
		}
		$this->_redirect('/');
	}

	public function punchcardAction() {
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_response->setHeader('Content-Type', 'image/svg+xml');

		$ip = $this->_getParam('ip', NULL);
		$pattern = '/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/';
		if(!is_numeric($ip) && preg_match($pattern, $ip)) {
			$ip = ip2long($ip);
		}
		if(!$ip) {
			exit;
		}

		$uptimeList = App_Host::GetUptimeList($ip, 4);
		$punchcard = Search_Punchcard::fromUptimeList($uptimeList);

		$dayLabels = array('Pn', 'Wt', "Śr", 'Cz', 'Pt', 'So', 'Nd');
		$fieldSize = 13;

		$this->_response->setBody($punchcard->generateSVG($dayLabels, $fieldSize));
	}

}
