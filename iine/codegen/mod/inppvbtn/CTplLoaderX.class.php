<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CTplLoaderX extends CTplLoader {

	public static function getAllTids( $max = null ) {
		$path_tpl = CAppPath::pathTpl();
		$tids = array();
		$idx = 0;
		foreach (glob("{$path_tpl}*") as $path) {
			if ( is_dir($path) && ( substr($path,0,1) != "_" )) {
				$path_parts = pathinfo( $path );
				$tid = $path_parts["basename"];
				$tids[$tid] = $path;

				$idx++;
				if (( $max != null ) && ( $idx >= $max )){
					break;
				}
			}
		}
		ksort($tids);
		return $tids;
	}

	public static function getTplsByTids( $tids ) {
		$tpls = array();
		foreach( $tids as $tid=>$path ) {
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
		return $tpls;
	}

}

?>