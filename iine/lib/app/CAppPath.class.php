<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CAppPath {

	public static function pathComponent( $component = null ) {
		$path = CEnv::pathRoot() . CEnv::get("dir-component") . "/";
		if ( !is_null( $component ) ) {
			$path .= $component . "/";
		}
		return $path;
	}

	public static function urlComponent( $component = null ) {
		$url = CEnv::urlRoot() . CEnv::get("dir-component") . "/";

		if ( !is_null( $component ) ) {
			$url .= $component . "/";
		}
		return $url;
	}

	public static function pathTpl( $tid = null ) {
		$path = CEnv::pathRoot() . CEnv::get("dir-tpl") . "/";
		if ( !is_null( $tid ) ) {
			$path .= $tid . "/";
		}
		return $path;
	}

	public static function urlTpl( $tid = null ) {
		$url = CEnv::urlRoot() . CEnv::get("dir-tpl") . "/";
		if ( !is_null( $tid ) ) {
			$url .= $tid . "/";
		}
		return $url;
	}

}

?>