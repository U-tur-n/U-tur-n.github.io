<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CCompact {

	public static function js( $txt ) {
		$txt = preg_replace('/(\/\*(.*?)\*\/)/s',"",$txt);
		$txt = preg_replace('/(\/\/\-\-(.*)\n)/',"",$txt);
		$txt = preg_replace('/([\r\n\t]+)/',"",$txt);
		return $txt;
	}

	public static function css( $txt ) {
		return self::js($txt);
	}

	public static function html( $txt ) {
		$txt = preg_replace('/(\<\!\-\-(.*)\-\-\>)/',"",$txt);
		$txt = preg_replace('/([\r\n\t]+)/',"",$txt);
		return $txt;
	}

}

?>