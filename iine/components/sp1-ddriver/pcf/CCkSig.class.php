<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタンv2.23用サービスパック１ [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBSP-100J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CCkSig {

	protected function createRandomString( $n ) {
		$s = "";
		for ( $i = 0; $i < $n; $i++ ) {
			if ( rand( 1, 2 ) == 1 ) {
				$s .= chr(rand(97, 122));
			} else {
				$s .= chr(rand(65, 90));
			}
		}
		return $s;
	}

	protected function createVal() {
		return $this->createRandomString(20);
	}

	protected function getCookieKey() {
		$cfg = CEnv::config("poll/sig");
		return $cfg["voter-cookie-key"];
	}

	protected function getMaxCookieExpTime() {
		if ( PHP_INT_SIZE == 4 ) {// 32 bits PHP
			//-- 2147483647 = 2^31-1 = 2038-01-18 19:14:07
			return 2147483647;
		} else {// 64 bits PHP
			//-- 10 years
			return time() + (10 * 365 * 24 * 60 * 60);
		}
	}

	protected function getCookieUrl() {
		return dirname(dirname($_SERVER["SCRIPT_NAME"]));
	}
	
	public function setVal( $val ) {
		$key = $this->getCookieKey();
		$t = $this->getMaxCookieExpTime();
		$url = $this->getCookieUrl();
		if ( function_exists("setcookie_ex") ) {
			setcookie_ex( $key, $val, $t, $url );
		} else {
			setcookie( $key, $val, $t, $url );
		}
		$_COOKIE[$key] = $val;
	}

	public function getVal( $b_create = false ) {
		$key = $this->getCookieKey();
		if ( isset($_COOKIE[$key]) ) {
			return $_COOKIE[$key];
		} else if ( $b_create ) {
			$val = $this->createVal();
			$this->setVal( $val );
			return $val;
		} else {
			return null;
		}
	}

}

?>