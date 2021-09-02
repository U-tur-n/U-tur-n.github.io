<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタンv2.23用サービスパック１ [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBSP-100J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CCMS {

	public static $binding = array();

	public static function trigger( $ename, $data = null, $ref = null ) {
		if ( isset(self::$binding[$ename]) ) {
			if ( !$data ) { $data = new CCMSData(); }
			$data->ename = $ename;
			$b_skip = ($ref?true:false);
			$ls = self::$binding[$ename];
			for( $i=0; $i<count($ls); $i++ ) {
				$rec = $ls[$i];
				if ( $rec["func"] != null ) {
					if ( $b_skip ) {
						$b_skip = ( $rec["obj"] != $ref );
					} else {
						if ( method_exists( $rec["obj"], $rec["func"] ) ) {
							if ( call_user_func_array(
								array( $rec["obj"], $rec["func"] ),
								array( $data ) ) === false ) {
								return false;
							}
						}
					}
				}
			}
		}

		return true;
	}

	public static function bind( $enames, $obj, $func ) {
		if ( $obj ) { self::unbind( $enames, $obj ); }
		self::binds( $enames, $obj, $func );
	}

	public static function binds( $enames, $obj, $func ) {
		$ex = explode(",",$enames);
		for( $i=0; $i<count($ex); $i++ ) {
			$str = trim($ex[$i]);
			$sx = explode(':',$str);
			if ( count($sx) > 0 ) {
				$ename = $sx[0];
				$bindex = 0;
				if ( count($sx) > 1 ) {
					$bindex = $sx[1];
					if ( $bindex == "begin" ) {
						$bindex = -100;
					} else if ( $bindex == "end" ) {
						$bindex = 100;
					} else {
						if ( is_numeric($bindex) ) {
							$bindex = floatval($sx[1]);
						} else  {
							$bindex = 0;
						}
					}
				}

				if ( !isset(self::$binding[$ename]) ) {
					self::$binding[$ename] = array();
				}
				$insert = array(
					"bindex"=>$bindex,
					"obj"=>$obj,
					"func"=>$func
				);
				$ls =& self::$binding[$ename];
				$b_inserted = false;
				for( $j=0; $j<count($ls); $j++ ) {
					if ( $bindex < $ls[$j]["bindex"] ) {
						array_splice( $ls, $j, 0, array($insert) );
						$b_inserted = true;
						break;
					}
				}
				if ( !$b_inserted ) {
					$ls[] = $insert;
				}
			}
		}
	}

	public static function unbind( $enames, $obj = null ) {
		$ex = explode(",",$enames);
		for( $i=0; $i<count($ex); $i++ ) {
			$ename = trim($ex[$i]);
			if ( isset(self::$binding[$ename]) ) {
				if ( !$obj ) {
					$temp = self::$binding[$ename];
					self::$binding[$ename] = array();
					return $temp;
				} else {
					for( $j=0; $j<count(self::$binding[$ename]); $j++ ) {
						if ( self::$binding[$ename][$j]["obj"] == $obj ) {
							$func = self::$binding[$ename][$j]["func"];
							self::$binding[$ename][$j]["obj"] = null;
							self::$binding[$ename][$j]["func"] = null;
							return $func;
						}
					}
				}
			}
		}
	}

	public static function unbindAll() {
		self::$binding = array();
	}

}

?>