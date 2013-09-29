<?php

class sys_io_Process {
	public function __construct($cmd, $args) {
		if(!php_Boot::$skip_constructor) {
		$pipes = array();
		$descriptorspec = array(
			array('pipe', 'r'),
			array('pipe', 'w'),
			array('pipe', 'w')
		);
		$this->p = proc_open($cmd . $this->sargs($args), $descriptorspec, $pipes);
		if(($this->p === false)) {
			throw new HException("Process creation failure : " . $cmd);
		}
		$this->stdin = new sys_io__Process_Stdin($pipes[0]);
		$this->stdout = new sys_io__Process_Stdout($pipes[1]);
		$this->stderr = new sys_io__Process_Stdout($pipes[2]);
	}}
	public $p;
	public $st;
	public $cl;
	public $stdout;
	public $stderr;
	public $stdin;
	public function close() {
		if(null === $this->st) {
			$this->st = proc_get_status($this->p);
		}
		$this->replaceStream($this->stderr);
		$this->replaceStream($this->stdout);
		$this->cl = proc_close($this->p);
	}
	public function sargs($args) {
		$b = "";
		{
			$_g = 0;
			while($_g < $args->length) {
				$arg = $args[$_g];
				++$_g;
				$arg = _hx_explode("\"", $arg)->join("\"");
				if(_hx_index_of($arg, " ", null) >= 0) {
					$arg = "\"" . $arg . "\"";
				}
				$b .= " " . $arg;
				unset($arg);
			}
		}
		return $b;
	}
	public function getPid() {
		$r = proc_get_status($this->p);
		return $r["pid"];
	}
	public function kill() {
		proc_terminate($this->p);
	}
	public function replaceStream($input) {
		$fp = fopen("php://memory", "r+");
		while(true) {
			$s = fread($input->p, 8192);
			if(($s === false) || $s === null || $s === "") {
				break;
			}
			fwrite($fp, $s);
			unset($s);
		}
		rewind($fp);
		$input->p = $fp;
	}
	public function exitCode() {
		if(null === $this->cl) {
			$this->st = proc_get_status($this->p);
			while($this->st["running"]) {
				Sys::sleep(0.01);
				$this->st = proc_get_status($this->p);
			}
			$this->close();
		}
		return sys_io_Process_0($this);
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
	function __toString() { return 'sys.io.Process'; }
}
function sys_io_Process_0(&$»this) {
	if($»this->st["exitcode"] < 0) {
		return $»this->cl;
	} else {
		return $»this->st["exitcode"];
	}
}
