<?php

class php_net_Socket {
	public function __construct($s) {
		if(!php_Boot::$skip_constructor) {
		$this->__s = $s;
		$this->input = new php_io_FileInput($this->__s);
		$this->output = new php_io_FileOutput($this->__s);
		$this->protocol = "tcp";
	}}
	public $__s;
	public $input;
	public $output;
	public $custom;
	public $protocol;
	public function assignHandler() {
		$this->input->__f = $this->__s;
		$this->output->__f = $this->__s;
	}
	public function close() {
		fclose($this->__s);
		{
			$this->input->__f = null;
			$this->output->__f = null;
		}
		$this->input->close();
		$this->output->close();
	}
	public function read() {
		$b = "";
		while (!feof($this->__s)) $b .= fgets($this->__s);
		return $b;
	}
	public function write($content) {
		fwrite($this->__s, $content);
		return;
	}
	public function connect($host, $port) {
		$errs = null;
		$errn = null;
		$r = stream_socket_client($this->protocol . "://" . $host->_ip . ":" . $port, $errn, $errs);
		php_net_Socket::checkError($r, $errn, $errs);
		$this->__s = $r;
		$this->assignHandler();
	}
	public function listen($connections) {
	}
	public function shutdown($read, $write) {
		$r = null;
		if(function_exists("stream_socket_shutdown")) {
			$rw = (($read && $write) ? 2 : (($write) ? 1 : (($read) ? 0 : 2)));
			$r = stream_socket_shutdown($this->__s, $rw);
		} else {
			$r = fclose($this->__s);
		}
		php_net_Socket::checkError($r, 0, "Unable to Shutdown");
	}
	public function bind($host, $port) {
		$errs = null;
		$errn = null;
		$r = stream_socket_server($this->protocol . "://" . $host->_ip . ":" . $port, $errn, $errs, (($this->protocol === "udp") ? STREAM_SERVER_BIND : STREAM_SERVER_BIND | STREAM_SERVER_LISTEN));
		php_net_Socket::checkError($r, $errn, $errs);
		$this->__s = $r;
		$this->assignHandler();
	}
	public function accept() {
		$r = stream_socket_accept($this->__s);
		php_net_Socket::checkError($r, 0, "Unable to accept connections on socket");
		return new php_net_Socket($r);
	}
	public function hpOfString($s) {
		$parts = _hx_explode(":", $s);
		if($parts->length === 2) {
			return _hx_anonymous(array("host" => new php_net_Host($parts[0]), "port" => Std::parseInt($parts[1])));
		} else {
			return _hx_anonymous(array("host" => new php_net_Host(_hx_substr($parts[1], 2, null)), "port" => Std::parseInt($parts[2])));
		}
	}
	public function peer() {
		$r = stream_socket_get_name($this->__s, true);
		php_net_Socket::checkError($r, 0, "Unable to retrieve the peer name");
		return $this->hpOfString($r);
	}
	public function host() {
		$r = stream_socket_get_name($this->__s, false);
		php_net_Socket::checkError($r, 0, "Unable to retrieve the host name");
		return $this->hpOfString($r);
	}
	public function setTimeout($timeout) {
		$s = intval($timeout);
		$ms = intval(($timeout - $s) * 1000000);
		$r = stream_set_timeout($this->__s, $s, $ms);
		php_net_Socket::checkError($r, 0, "Unable to set timeout");
	}
	public function setBlocking($b) {
		$r = stream_set_blocking($this->__s, $b);
		php_net_Socket::checkError($r, 0, "Unable to block");
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->»dynamics[$m]) && is_callable($this->»dynamics[$m]))
			return call_user_func_array($this->»dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call «'.$m.'»');
	}
	static function newUdpSocket() {
		$s = new php_net_Socket(null);
		$s->protocol = "udp";
		return $s;
	}
	static function newSslSocket() {
		$s = new php_net_Socket(null);
		$s->protocol = "ssl";
		return $s;
	}
	static function checkError($r, $code, $msg) {
		if(!($r === false)) {
			return;
		}
		throw new HException(haxe_io_Error::Custom("Error [" . $code . "]: " . $msg));
	}
	static function getType($isUdp) {
		return (($isUdp) ? SOCK_DGRAM : SOCK_STREAM);
	}
	static function getProtocol($protocol) {
		return getprotobyname($protocol);
	}
	function __toString() { return 'php.net.Socket'; }
}
