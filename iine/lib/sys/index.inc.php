<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CLibAutoloader {
	public static function autoloader( $class, $path_dir ) {
		$path = "{$path_dir}/{$class}.class.php";
		if ( is_file( $path ) ) {
			require_once( $path );
		}
	}
}

function lib_autoloader( $class ) {
	CLibAutoloader::autoloader( $class, dirname(__FILE__) );
}
spl_autoload_register("lib_autoloader");

?>