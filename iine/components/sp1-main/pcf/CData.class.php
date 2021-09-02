<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタンv2.23用サービスパック１ [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBSP-100J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CData {

	private static $css = array();

	public static function setResult( $data, $msg ) {
		$data->resp["result"] = $msg;
	}

	public static function makeTpl( $data ) {
		$tid = $data->requ["tid"];
		$path = CAppPath::pathTpl($tid)."config.inc.php";
		if ( file_exists($path) ) {
			$cfg =& $data->requ;
			include($path);
		}
	}

	public static function makeDataStruct( $data ) {
		$pidx = array();
		$tplx = array();
		foreach( $data->requ["pollx"] as $poll ) {
			$tid = $poll["tid"];
			$pidx[] = $poll["pid"];
			if ( !isset($tplx[$tid]) ) {
				$path = CAppPath::pathTpl($tid)."config.inc.php";
				if ( file_exists($path) ) {
					$cfg = array();
					include($path);
					if ( !isset($cfg["type"]) ) {
						$cfg["type"] = "def";
					}
					$cfg["list"] = array();
					$tplx[$tid] = $cfg;
				}
			}
			if ( isset($tplx[$tid]) ) {
				$tplx[$tid]["list"][] = $poll;
			}
		}
		$data->pidx = $pidx;
		$data->resp["tplx"] = $tplx;
	}

	public static function sani( $v, $b_slash = true ) {
		if ( is_string($v) ) {
			if ( $b_slash ) {
				$v = preg_replace('/[\.\/\\\\]/', '_', $v);
			}
		}
		return $v;
	}

	public static function sanitizeCmd( $data ) {
		$data->requ["cmd"] = preg_replace("/[^a-zA-Z0-9]+/", "",
			isset($data->requ["cmd"])?$data->requ["cmd"]:"");
		return $data->requ["cmd"];
	}

	public static function validateID( $data, $idnamex ) {
		foreach( $idnamex as $idname ) {
			switch( $idname ) {
			case "wid": $id = CData::sanitizeWid($data); break;
			case "bid": $id = CData::sanitizeBid($data); break;
			case "pid": $id = CData::sanitizePid($data); break;
			case "tid": $id = CData::sanitizeTid($data); break;
			}
			if ( empty($id) ) {
				CData::setResult($data,"missing {$idname}");
				return false;
			}
			$data->resp[$idname] = $id;
		}
		return true;
	}

	public static function sanitizeID( $data, $idname, $b_slash = false ) {
		$data->requ[$idname] = self::sani(
			isset($data->requ[$idname])?$data->requ[$idname]:"",
			$b_slash);
		return $data->requ[$idname];
	}

	public static function sanitizeWid( $data ) {
		return self::sanitizeID($data,"wid");
	}

	public static function sanitizeBid( $data ) {
		return self::sanitizeID($data,"bid");
	}

	public static function sanitizePid( $data ) {
		return self::sanitizeID($data,"pid",true);
	}

	public static function sanitizeTid( $data ) {
		return self::sanitizeID($data,"tid",true);
	}

	public static function sanitizeTids( $data ) {
		foreach( $data->requ["pollx"] as &$poll ) {
			$poll["tid"] = self::sani($poll["tid"]);
		}
	}

	public static function addCss( $css ) {
		if ( is_array($css) ) {
			self::$css[] = implode("",$css);
		} else {
			self::$css[] = $css;
		}
	}

	public static function packCss( $data ) {
		//-- compact css in components & templates
		$txt = implode("",self::$css);
		$data->resp["cssx"]["all"] = CCompact::css($txt);
	}

	public static function packHtml( $data ) {
		//-- compact htmls in components
		foreach( $data->resp["htmlx"] as $name=>&$html ) {
			$html = CCompact::html($html);
		}

		//-- compact htmls in templates
		foreach( $data->resp["tplx"] as $tid=>&$tpl ) {
			if ( isset($tpl["html"]) ) {
				foreach( $tpl["html"] as $fn=>&$html ) {
					$html = CCompact::html($html);
				}
			}
		}
	}

	public static function loadTplCfg( $data ) {
		$path = CAppPath::pathTpl($data->requ["tid"])."config.inc.php";
		if ( file_exists($path) ) {
			$cfg = array();
			include($path);
			$data->cfg_tpl = $cfg;
		}
	}

}

?>