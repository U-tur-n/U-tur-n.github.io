<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CAjaxTool {

	public static function printHeader() {
		header("Content-Type: application/javascript");
	}

	public static function returnAjax( $json ) {
		if ( isset($_GET["callback"]) ) {
			echo $_GET["callback"] . "(" . json_encode( $json ) . ");";
		} else {
			echo json_encode( $json );
		}
	}

	public static function obStart() {
		ob_start();
	}

	public static function obEnd() {
		$html = ob_get_contents();
		if ( !empty($html) ) {
			ob_end_clean();
		}
		return $html;
	}

	public static function getConfig( $px ) {
		return CJson::encode($px);
	}

	public static function pathMinJs( $path, $fn ) {
		return ( file_exists($path . $fn) ) ?
			($path . $fn) :
			($path . str_replace(".min","",$fn));
	}

	public static function urlMinJs( $path, $url, $fn ) {
		return ( file_exists($path . $fn) ) ?
			($url . $fn) :
			($url . str_replace(".min","",$fn));
	}
}

?>