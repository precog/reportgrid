<?php

class chx_text_Sprintf {
	public function __construct(){}
	static $kPAD_ZEROES = 1;
	static $kLEFT_ALIGN = 2;
	static $kSHOW_SIGN = 4;
	static $kPAD_POS = 8;
	static $kALT_FORM = 16;
	static $kLONG_VALUE = 32;
	static $kUSE_SEPARATOR = 64;
	static $DEBUG = false;
	static $TRACE = false;
	static function format($format, $args) {
		if($format === null) {
			return "";
		}
		if($args === null) {
			$args = new _hx_array(array());
		}
		$destString = "";
		$argIndex = 0;
		$formatIndex = 0;
		$percentIndex = 0;
		$ch = 0;
		$value = null;
		$length = 0;
		$precision = 0;
		$properties = 0;
		$fieldCount = 0;
		$fieldOutcome = null;
		while($formatIndex < strlen($format)) {
			$percentIndex = _hx_index_of($format, "%", $formatIndex);
			if($percentIndex === -1) {
				$destString .= _hx_substr($format, $formatIndex, null);
				$formatIndex = strlen($format);
			} else {
				$destString .= _hx_substr($format, $formatIndex, $percentIndex - $formatIndex);
				$fieldOutcome = "** sprintf: invalid format at " . $argIndex . " **";
				$length = $properties = $fieldCount = 0;
				$precision = -1;
				$formatIndex = $percentIndex + 1;
				$value = $args[$argIndex++];
				while(Std::is($fieldOutcome, _hx_qtype("String")) && $formatIndex < strlen($format)) {
					$ch = _hx_char_code_at($format, $formatIndex++);
					switch($ch) {
					case 35:{
						if($fieldCount === 0) {
							$properties |= 16;
						} else {
							$fieldOutcome = "** sprintf: \"#\" came too late **";
						}
					}break;
					case 45:{
						if($fieldCount === 0) {
							$properties |= 2;
						} else {
							$fieldOutcome = "** sprintf: \"-\" came too late **";
						}
					}break;
					case 43:{
						if($fieldCount === 0) {
							$properties |= 4;
						} else {
							$fieldOutcome = "** sprintf: \"+\" came too late **";
						}
					}break;
					case 32:{
						if($fieldCount === 0) {
							$properties |= 8;
						} else {
							$fieldOutcome = "** sprintf: \" \" came too late **";
						}
					}break;
					case 46:{
						if($fieldCount < 2) {
							$fieldCount = 2;
							$precision = 0;
						} else {
							$fieldOutcome = "** sprintf: \".\" came too late **";
						}
					}break;
					case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:{
						if($ch === 48 && $fieldCount === 0) {
							$properties |= 1;
						} else {
							if($fieldCount === 3) {
								$fieldOutcome = "** sprintf: shouldn't have a digit after h,l,L **";
							} else {
								if($fieldCount < 2) {
									$fieldCount = 1;
									$length = $length * 10 + ($ch - 48);
								} else {
									$precision = $precision * 10 + ($ch - 48);
								}
							}
						}
					}break;
					case 100:case 105:{
						$fieldOutcome = true;
						$destString .= chx_text_Sprintf::formatD($value, $properties, $length, $precision);
					}break;
					case 111:{
						$fieldOutcome = true;
						$destString .= chx_text_Sprintf::formatO($value, $properties, $length, $precision);
					}break;
					case 120:case 88:{
						$fieldOutcome = true;
						$destString .= chx_text_Sprintf::formatX($value, $properties, $length, $precision, $ch === 88);
					}break;
					case 101:case 69:{
						$fieldOutcome = true;
						$destString .= chx_text_Sprintf::formatE($value, $properties, $length, $precision, $ch === 69);
					}break;
					case 102:{
						$fieldOutcome = true;
						$destString .= chx_text_Sprintf::formatF($value, $properties, $length, $precision);
					}break;
					case 103:case 71:{
						$fieldOutcome = true;
						$destString .= chx_text_Sprintf::formatG($value, $properties, $length, $precision, $ch === 71);
					}break;
					case 99:case 67:case 115:case 83:{
						if($ch === 99 || $ch === 67) {
							$precision = 1;
						}
						$fieldOutcome = true;
						$destString .= chx_text_Sprintf::formatS($value, $properties, $length, $precision);
					}break;
					case 37:{
						$fieldOutcome = true;
						$destString .= "%";
						$argIndex--;
					}break;
					default:{
						$fieldOutcome = "** sprintf: " . Std::string($ch - 48) . " not supported **";
					}break;
					}
				}
				if(!_hx_equal($fieldOutcome, true)) {
					if(chx_text_Sprintf::$DEBUG) {
						$destString .= $fieldOutcome;
					}
					if(chx_text_Sprintf::$TRACE) {
						haxe_Log::trace($fieldOutcome, _hx_anonymous(array("fileName" => "Sprintf.hx", "lineNumber" => 243, "className" => "chx.text.Sprintf", "methodName" => "format")));
					}
				}
			}
		}
		return $destString;
	}
	static function finish($output, $value, $properties, $length, $precision, $prefix) {
		if($prefix === null) {
			$prefix = "";
		}
		if($prefix === null) {
			$prefix = "";
		}
		if($value < 0) {
			$prefix = "-" . $prefix;
		} else {
			if(($properties & 4) !== 0) {
				$prefix = "+" . $prefix;
			} else {
				if(($properties & 8) !== 0) {
					$prefix = " " . $prefix;
				}
			}
		}
		if($length === 0 && $precision > -1) {
			$length = $precision;
			$properties |= 1;
		}
		while(strlen($output) + strlen($prefix) < $length) {
			if(($properties & 2) !== 0) {
				$output = $output . " ";
			} else {
				if(($properties & 1) !== 0) {
					$output = "0" . $output;
				} else {
					$prefix = " " . $prefix;
				}
			}
		}
		return $prefix . $output;
	}
	static function number($v) {
		if($v === null) {
			return 0.;
		}
		if(Std::is($v, _hx_qtype("String"))) {
			if(_hx_equal($v, "")) {
				return 0.0;
			}
			return Std::parseFloat($v);
		}
		if(Std::is($v, _hx_qtype("Float"))) {
			if(Math::isNaN($v)) {
				return $v;
			}
			return $v;
		}
		if(Std::is($v, _hx_qtype("Int"))) {
			return $v * 1.0;
		}
		if(Std::is($v, _hx_qtype("Bool"))) {
			return (($v) ? 1.0 : 0.0);
		}
		return Math::$NaN;
	}
	static function formatD($value, $properties, $length, $precision) {
		$output = "";
		$value = chx_text_Sprintf::number($value);
		if($precision !== 0 || !_hx_equal($value, 0)) {
			$output = Std::string(Math::floor(Math::abs($value)));
		}
		while(strlen($output) < $precision) {
			$output = "0" . $output;
		}
		return chx_text_Sprintf::finish($output, $value, $properties, $length, $precision, null);
	}
	static function formatO($value, $properties, $length, $precision) {
		$output = "";
		$prefix = "";
		$value = chx_text_Sprintf::number($value);
		if($precision !== 0 && !_hx_equal($value, 0)) {
			$output = _hx_string_call($value, "toString", array(8));
		}
		if(($properties & 16) !== 0) {
			$prefix = "0";
		}
		while(strlen($output) < $precision) {
			$output = "0" . $output;
		}
		return chx_text_Sprintf::finish($output, $value, $properties, $length, $precision, $prefix);
	}
	static function formatX($value, $properties, $length, $precision, $upper) {
		$output = "";
		$prefix = "";
		$value = chx_text_Sprintf::number($value);
		if($precision !== 0 && !_hx_equal($value, 0)) {
			$output = _hx_string_call($value, "toString", array(16));
		}
		if(($properties & 16) !== 0) {
			$prefix = "0x";
		}
		while(strlen($output) < $precision) {
			$output = "0" . $output;
		}
		if($upper) {
			$prefix = strtoupper($prefix);
			$output = strtoupper($output);
		} else {
			$output = strtolower($output);
		}
		return chx_text_Sprintf::finish($output, $value, $properties, $length, $precision, $prefix);
	}
	static function formatE($value, $properties, $length, $precision, $upper) {
		$output = "";
		$expCount = 0;
		$value = chx_text_Sprintf::number($value);
		if(Math::abs($value) > 1) {
			while(Math::abs($value) > 10) {
				$value /= 10;
				$expCount++;
			}
		} else {
			while(Math::abs($value) < 1) {
				$value *= 10;
				$expCount--;
			}
		}
		$expCountStr = chx_text_Sprintf::format("%c%+.2d", new _hx_array(array((($upper) ? "E" : "e"), $expCount)));
		if(($properties & 2) !== 0) {
			$output = chx_text_Sprintf::formatF($value, $properties, 1, $precision) . $expCountStr;
			while(strlen($output) < $length) {
				$output .= " ";
			}
		} else {
			$output = chx_text_Sprintf::formatF($value, $properties, intval(Math::max($length - strlen($expCountStr), 0)), $precision) . $expCount;
		}
		return $output;
	}
	static function formatF($value, $properties, $length, $precision) {
		$output = "";
		$intPortion = "";
		$decPortion = "";
		if($precision === -1) {
			$precision = 6;
		}
		$valStr = Std::string($value);
		if(_hx_index_of($valStr, ".", null) === -1) {
			$intPortion = Std::string(Math::abs(chx_text_Sprintf::number($valStr)));
			$decPortion = "0";
		} else {
			$intPortion = Std::string(Math::abs(chx_text_Sprintf::number(_hx_substr($valStr, 0, _hx_index_of($valStr, ".", null)))));
			$decPortion = _hx_substr($valStr, _hx_index_of($valStr, ".", null) + 1, null);
		}
		if(_hx_equal(chx_text_Sprintf::number($decPortion), 0)) {
			$decPortion = "";
			while(strlen($decPortion) < $precision) {
				$decPortion .= "0";
			}
		} else {
			if(strlen($decPortion) > $precision) {
				$dec = Math::round(Math::pow(10, $precision) * chx_text_Sprintf::number("0." . $decPortion));
				if(strlen(Std::string($dec)) > $precision && $dec !== 0) {
					$decPortion = "0";
					$intPortion = Std::string((Math::abs(chx_text_Sprintf::number($intPortion)) + 1) * (((chx_text_Sprintf::number($intPortion) >= 0) ? 1 : -1)));
				} else {
					$decPortion = Std::string($dec);
				}
			}
			if(strlen($decPortion) < $precision) {
				$decPortion = $decPortion;
				while(strlen($decPortion) < $precision) {
					$decPortion .= "0";
				}
			}
		}
		if($precision === 0) {
			$output = $intPortion;
			if(($properties & 16) !== 0) {
				$output .= ".";
			}
		} else {
			$output = $intPortion . "." . $decPortion;
		}
		return chx_text_Sprintf::finish($output, Std::parseFloat($valStr), $properties, $length, $precision, "");
	}
	static function formatG($value, $properties, $length, $precision, $upper) {
		$out1 = chx_text_Sprintf::formatE($value, $properties, 1, $precision, $upper);
		$out2 = chx_text_Sprintf::formatF($value, $properties, 1, $precision);
		if(strlen($out1) < strlen($out2)) {
			return chx_text_Sprintf::formatE($value, $properties, $length, $precision, $upper);
		} else {
			return chx_text_Sprintf::formatF($value, $properties, $length, $precision);
		}
	}
	static function formatS($value, $properties, $length, $precision) {
		$output = Std::string($value);
		if($precision > 0 && $precision < strlen($output)) {
			$output = _hx_substr($output, 0, $precision);
		}
		$properties &= -30;
		return chx_text_Sprintf::finish($output, $value, $properties, $length, $precision, "");
	}
	function __toString() { return 'chx.text.Sprintf'; }
}
