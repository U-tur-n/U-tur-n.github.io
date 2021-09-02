<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CComponent {

	private static $path_cmp_root;
	private static $url_cmp_root;
	private static $path_tpl_root;
	private static $url_tpl_root;

	public static $cmpdb = array();
	public static $cmpcfg = array();
	private static $spec_file = "spec/main.inc.php";
	private static $config_file = "config.inc.php";
	private static $def_component = "main";
	private static $def_scope = "app";
	private static $def_version = 1.0;
	private static $instances = array();

	private static function compareVersions( $cfg_x, $cfg_y ) {
		$ver_x = isset($cfg_x["version"]) ?
			$cfg_x["version"] : self::$def_version;
		$ver_y = isset($cfg_y["version"]) ?
			$cfg_y["version"] : self::$def_version;
		return ( $ver_y > $ver_x );
	}

	private static function loadCmpCfg( $cmpname, $path_fd ) {
		self::$cmpcfg[$cmpname] = null;
		$path_config = $path_fd . self::$config_file;
		if ( file_exists($path_config) ) {
			$cfg = array();
			include($path_config);
			self::$cmpcfg[$cmpname] = $cfg;
		}
	}

	private static function setupFolder( $cmptype, $path_fd, $url_fd ) {
		$path_spec = $path_fd . self::$spec_file;
		if ( file_exists($path_spec) ) {
			$cfg = array();
			include($path_spec);
			if ( isset($cfg[$cmptype]) ) {
				$cfg = $cfg[$cmptype];
				if ( isset($cfg["cmpname"]) ) {
					$cmpname = $cfg["cmpname"];
					$b_insert = ( isset(self::$cmpdb[$cmpname]) ) ?
						self::compareVersions( self::$cmpdb[$cmpname], $cfg ) :
						true;
					if ( $b_insert ) {
						$cfg["dir"] = ( isset($cfg["dir"]) ? $cfg["dir"] : "" );
						$cfg["path"] = $path_fd . $cfg["dir"];
						$cfg["url"] = $url_fd . $cfg["dir"];
						self::$cmpdb[$cmpname] = $cfg;
						self::loadCmpCfg($cmpname,$path_fd);
					}
				}
			}
		}
	}

	public static function setupCmp( $cmptype ) {
		self::$path_cmp_root = CAppPath::pathComponent();
		self::$url_cmp_root = CAppPath::urlComponent();

		self::$cmpdb = array();
		foreach( glob(self::$path_cmp_root."*") as $path_cmp ) {
			if ( is_dir($path_cmp) ) {
				$path_parts = pathinfo($path_cmp);
				$fd = $path_parts["basename"];
				if ( substr($fd,0,1) != "_" ) {
					self::setupFolder($cmptype,
						self::$path_cmp_root.$fd."/",
						self::$url_cmp_root.$fd."/");
				}
			}
		}

		//-- sort array
		ksort(self::$cmpdb);

		//-- put the default component on the beginning
		$def = self::$def_component;
		if ( isset(self::$cmpdb[$def]) ) {
			$cfg = self::$cmpdb[$def];
			unset(self::$cmpdb[$def]);
			self::$cmpdb = array_reverse(self::$cmpdb);
			self::$cmpdb[$def] = $cfg;
			self::$cmpdb = array_reverse(self::$cmpdb);
		}

		//-- register pcf
		self::registerPcf();
	}

	public static function setupTpl( $cmptype, $tidx ) {
		self::$path_tpl_root = CAppPath::pathTpl();
		self::$url_tpl_root = CAppPath::urlTpl();

		//-- setup tpl folders
		foreach( $tidx as $tid ) {
			self::setupFolder($cmptype,
				self::$path_tpl_root.$tid."/",
				self::$url_tpl_root.$tid."/");
		}

		//-- register pcf
		self::registerPcf();
	}

	private static function registerPcf() {
		foreach( self::$cmpdb as $cmpname=>&$cfg ) {
			$path = $cfg["path"] . "pcf/index.inc.php";
			if ( file_exists($path) ) { include_once($path); }
		}
	}

	public static function registerPcfClass( $scope, $data ) {
		foreach( self::$cmpdb as $cmpname=>$cfg ) {
			if ( isset($cfg["pcf"]) && isset($cfg["pcf"][$scope]) ) {
				$ls = $cfg["pcf"][$scope];
				foreach( $ls as $cname ) {
					self::$instances[$cname] = new $cname($data);
				}
			}
		}
	}

	public static function getPcfClass( $cname ) {
		return isset(self::$instances[$cname]) ?
			self::$instances[$cname] : null;
	}

	public static function buildReso( $restype ) {
		$rx = array();

		foreach( self::$cmpdb as $cmpname => $cfg ) {
			if ( isset($cfg[$restype]) ) {
				if ( is_array($cfg[$restype]) ) {
					foreach( $cfg[$restype] as $resname=>$rescfg ) {
						self::createResEntry( $restype, $resname, $rescfg,
							$cmpname, $cfg, $rx );
					}
				}
			} else {
				$path_res_root = $cfg["path"] . "/{$restype}/";

				foreach (glob("{$path_res_root}*") as $path_res ) {
					if ( !is_dir($path_res) ) {
						$path_parts = pathinfo($path_res);
						$resname = $path_parts["basename"];
						self::createResEntry( $restype, $resname, null,
							$cmpname, $cfg, $rx );
					}
				}
			}
		}

		return $rx;
	}

	private static function createResEntry( $restype,
		 $resname, $rescfg, $cmpname, $cfg, &$rx ) {

		//-- comment out
		if ( substr($resname,0,1) == "_" ) { return; }

		//-- if rescfg is empty set it to default
		$rescfg = ( $rescfg ) ? $rescfg : array(
			"version"=>self::$def_version,
		);

		//-- resolve "scope" if not specified
		if ( !isset($rescfg["scope"]) ) {
			switch( $restype ) {
			case "js":
			case "css":
				$rescfg["scope"] = self::$def_scope;
				break;
			case "html":
			case "img":
				$rescfg["scope"] = $cmpname;
				break;
			}
		}
		$scope = $rescfg["scope"];

		//-- init $rx[$scope]
		if ( !isset($rx[$scope]) ) {
			$rx[$scope] = array();
		}
		$ls =& $rx[$scope];

		//-- replace or create entry
		$b_replace = ( isset($ls[$resname]) ) ?
			self::compareVersions($ls[$resname], $rescfg ) :
			true;
		if ( $b_replace ) {
			$rescfg["path"] = $cfg["path"];
			$rescfg["url"] = $cfg["url"];
			$ls[$resname] = $rescfg;
		}
	}

	public static function jscode( $reso, $scope ) {
		$js = "";
		if ( isset($reso) && isset($reso[$scope]) ) {
			$ls = $reso[$scope];
			$sx = array();
			foreach( $ls as $jsname=>$cfg ) {
				$path = $cfg["path"] . "js/{$jsname}";
				if ( file_exists($path) ) {
					$sx[] = file_get_contents($path); 
				}
			}
			$js = implode("\r\n",$sx);
		}
		return $js;
	}

	public static function htmlcode( $reso ) {
		$htmlx = array();
		if ( isset($reso) ) {
			foreach( $reso as $scope=>$fx ) {
				$sx = array();
				foreach( $fx as $htmlname=>$cfg ) {
					$path = $cfg["path"] . "html/{$htmlname}";
					if ( file_exists($path) ) {
						$txt = file_get_contents($path); 
						$txt = str_replace("%url-cmp%",$cfg["url"],$txt);
						$sx[$htmlname] = $txt;
					}
				}
				$htmlx[$scope] = $sx;
			}
		}
		return $htmlx;
	}

	public static function csscode( $reso, $scope ) {
		$css = "";
		if ( isset($reso) && isset($reso[$scope]) ) {
			$ls = $reso[$scope];
			$sx = array();
			foreach( $ls as $cssname=>$cfg ) {
				$path = $cfg["path"] . "css/{$cssname}";
				if ( file_exists($path) ) {
					$txt = file_get_contents($path); 
					$txt = str_replace("%url-cmp%",$cfg["url"],$txt);
					$sx[] = $txt;
				}
			}
			$css = implode("\r\n",$sx);
		}
		return $css;
	}
}

?>