<?php
class ALump_Request{
	private static $instance = null;
	
	private $_gets = null;
	private $_posts = null;
	private $_requests = null;
	private $_ip = null;
	
	private function __construct(){
		$this->_gets = $_GET;
		$this->_posts = $_POST;
		$this->_requests = $_REQUEST;
		$this->_files = $_FILES;
		$this->_servers = $_SERVER;
	}
	
	public static function getInstance(){
		if(self::$instance == null){
			self::$instance = new Alump_Request();
		}
		
		return self::$instance;
	}
	
	function get($name){
		return $this->_getVal($this->_gets, $name);
	}
	
	function post($name){
		return $this->_getVal($this->_posts, $name);
	}
	
	function request($name){
		return $this->_getVal($this->_requests, $name);
	}
	
	function server($name){
		return $this->_getVal($this->_servers, $name);
	}
	
	function file($name){
		return $this->_getVal($this->_files, $name);
	}
	
	private function _getVal($tarArr, $name){
		if(isset($tarArr[$name])){
			return $tarArr[$name];
		}
		return '';
	}
	
	/**
	 * 设置ip地址
	 *
	 * @access public
	 * @param unknown $ip
	 * @return unknown
	 */
	public function setIp($ip = NULL)
	{
		switch (true) {
			case NULL !== $this->getServer('HTTP_X_FORWARDED_FOR'):
				$this->_ip = $this->getServer('HTTP_X_FORWARDED_FOR');
				return;
			case NULL !== $this->getServer('HTTP_CLIENT_IP'):
				$this->_ip = $this->getServer('HTTP_CLIENT_IP');
				return;
			case NULL !== $this->getServer('REMOTE_ADDR'):
				$this->_ip = $this->getServer('REMOTE_ADDR');
				return;
			default:
				break;
		}
	
		$this->_ip = 'unknown';
	}
	
	/**
	 * 获取ip地址
	 *
	 * @access public
	 * @return string
	 */
	public function getIp()
	{
		if (NULL === $this->_ip) {
			$this->setIp();
		}
	
		return $this->_ip;
	}
}
?>