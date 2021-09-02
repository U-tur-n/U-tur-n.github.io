<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CBend_inppvbtn extends CBend_crud {

	public function init() {
		$this->bind("hd_load_page");
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

	public function hd_load_page( $data ) {
		clearstatcache();

		$form = $data->requ["form"];

		$keyword = $form["keyword"];
		$pidx = $form["pidx"];

		//-- max per page
		$cfg = array();
		include("config.inc.php");
		$max_per_page = $cfg["max-per-page"];

		$rec = $this->getTplsForPage($keyword,$pidx,$max_per_page);
		$data->resp["itotal"] = $rec["itotal"];
		$data->resp["pidx"] = $rec["pidx"];
		$data->resp["ptotal"] = $rec["ptotal"];
		$data->resp["keyword"] = $keyword;

		//-- render html
		$tpls = $rec["tpls"];
		self::obStart();
		include("tpl.page.inc.php");
		$html = self::obEnd();

		//-- resp
		$data->resp["html"] = $html;
		$this->ret($data);
	}

	public function getTplsForPage( $keyword, $pidx, $max_per_page ) {

		$tids = CTplLoaderX::getAllTids();

		//-- filter by keyword
		if ( $keyword != "" ) {
			$tids0 = array();
			foreach( $tids as $tid => $path ) {
				$pos = strpos($tid,$keyword);
				if ( $pos !== false ) {
					$tids0[$tid] = $path;
				}
			}
			$tids = $tids0;
		}

		//-- calc pidx and ptotal
		$itotal = count($tids);
		if ( $itotal == 0 ) {
			$ptotal = 0;
			$pidx = 0;
		} else {
			$ptotal = intval(floor(($itotal-1)/$max_per_page))+1;
			if ( $pidx > $ptotal ) {
				$pidx = $ptotal;
			}
			if ( $pidx < 1 ) {
				$pidx = 1;
			}
		}

		//-- get tpls for a page specified by pidx
		$tids = array_slice($tids,
			($pidx-1)*$max_per_page, $max_per_page);
		$tpls = CTplLoaderX::getTplsByTids($tids);

		//-- set return array
		return array(
			"itotal"=>$itotal,
			"pidx"=>$pidx,
			"ptotal"=>$ptotal,
			"tpls"=>$tpls,
		);
	}
}

?>