<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CUtil {

	public static function getRandomStr($n) {
		$text = "";
		$possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		for( $i=0; $i<$n; $i++) {
			$text .= substr($possible,rand(0,strlen($possible)-1),1);
		}
		return $text;
	}

	public static function strtotime_utc( $utc_tstr ) {
		$dt = new DateTime( $utc_tstr, new DateTimeZone("UTC") );
		return $dt->format("U");
	}

}

?>