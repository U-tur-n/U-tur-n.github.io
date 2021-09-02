<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

function autoloader_include( $class ) {
	$path = dirname(__FILE__) . "/{$class}.class.php";
	if ( is_file( $path ) ) {
		require_once( $path );
	}
}
spl_autoload_register( "autoloader_include" );

?>