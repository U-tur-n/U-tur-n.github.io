<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CTplLoader {

	public static $tid;
	public static $css_ctar;
	public static $path_tpl;
	public static $url_tpl;
	public static $tpl_first_key = null;

	public static function setupTid( $tid ) {
		self::$tid = $tid;
		self::$css_ctar = "aiin-css-{$tid}";
		self::$path_tpl = CAppPath::pathTpl($tid);
		self::$url_tpl = CAppPath::urlTpl($tid);
	}

	public static function getCssCtarSig() {
		return self::$css_ctar;
	}

	public static function loadAllFiles( $fd ) {
		$path_fd = self::$path_tpl.$fd."/";
		$fx = array();
		foreach (glob("{$path_fd}*") as $path_file) {
			$path_parts_file = pathinfo($path_file);
			$fn = $path_parts_file["basename"];
			if ( substr($fn,0,1) != "_" ) {
				if ( !is_dir($path_file) ) {
					$txt = file_get_contents($path_file);
					if ( $fn == "tpl.html" ) {
						$txt = "<div class='aiin-css %css-ctar%'>{$txt}</div>";
					}
					$txt = str_replace("%css-ctar%",self::$css_ctar,$txt);
					$txt = str_replace("%url-tpl%",self::$url_tpl,$txt);
					$fx[$fn] = $txt;
				}
			}
		}
		return $fx;
	}

	public static function getAllTplNames( &$tpls ) {
		$path_tpl = CAppPath::pathTpl();
		$tpls = array();
		foreach (glob("{$path_tpl}*") as $path) {
			if ( is_dir($path) && ( substr($path,0,1) != "_" )) {
				$path_parts = pathinfo( $path );
				$tid = $path_parts["basename"];
				$path_cfg = $path . "/config.inc.php";
				if ( file_exists($path_cfg) ) {
					self::setupTid($tid);
					$cfg = array();
					include($path_cfg);
					$tpls[$tid] = array(
						"html"=>self::loadAllFiles("html"),
						"css"=>self::loadAllFiles("css"),
					);
					if ( !self::$tpl_first_key ) {
						self::$tpl_first_key = $tid;
					}
				}
			}
		}
		ksort($tpls);
	}

}

?>