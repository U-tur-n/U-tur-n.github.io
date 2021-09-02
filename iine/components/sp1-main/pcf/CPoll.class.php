<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタンv2.23用サービスパック１ [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBSP-100J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CPoll {

	public function __construct( $data ) {
		CCMS::bind("poll-bind",$this,"bind");
	}

	public function bind( $data ) {
		CCMS::bind("poll-load:begin",$this,"load");
		CCMS::bind("poll-type:begin",$this,"type");
		CCMS::bind("poll-pack",$this,"pack");
		CCMS::bind("poll-vote",$this,"vote");
		CCMS::bind("poll-vote-process:end",$this,"vote_process");
	}

	public function load( $data ) {
		foreach( $data->resp["tplx"] as $tid=>&$tpl ) {
			CTplLoader::setupTid($tid);
			if ( $tpl["load-resource"] ) {
				$tpl["html"] = CTplLoader::loadAllFiles("html");
				CData::addCss(CTplLoader::loadAllFiles("css"));
			}
		}
	}

	public function type( $data ) {
		$typex = array();
		foreach( $data->resp["tplx"] as $tid => $tpl ) {
			if ( isset($tpl["type"]) ) {
				$type = $tpl["type"];
				if ( !isset($typex[$type]) ) {
					$typex[$type] = array(
						"list"=>array()
					);
				}
				$typex[$type]["list"][] = $tid;
			}
		}
		$data->resp["typex"] = $typex;
	}

	public function pack( $data ) {
		CData::packCss($data);
		CData::packHtml($data);
	}

	public function vote( $data ) {
		CData::loadTplCfg( $data );
		CCMS::trigger("poll-vote-process",$data);
	}

	public function vote_process( $data ) {

		//-- get history data
		$data->ddriver->hist($data);

		//-- init arrays
		$data->update_btn = array();
		$data->update_hist = array();
		$data->update_vcnt = array();
		$data->resp["change"] = 0;

		if ( $data->bid == "" ) {
			//-- change
			$data->resp["change"] = 1;
			//-- increment the new bid
			$data->update_btn[] = array(
				"bid"=>$data->requ["bid"],
				"change"=>1,
			);
			//-- insert the new hist
			$data->update_hist[] = array(
				"cmd"=>"insert",
				"bid"=>$data->requ["bid"],
			);
			//-- update the new vcnt
			$data->update_vcnt[$data->requ["bid"]] = 1;
		} else {
			if ( $data->cfg_tpl["enable-undo"] ) {
				if ( $data->requ["bid"] == $data->bid ) {
					//-- change
					$data->resp["change"] = -1;
					//-- decrement the prev bid
					$data->update_btn[] = array(
						"bid"=>$data->requ["bid"],
						"change"=>-1,
					);
					//-- delete the prev hist
					$data->update_hist[] = array(
						"cmd"=>"delete",
						"hist_id"=>$data->hist_id,
					);
					//-- update the prev vcnt
					$data->update_vcnt[$data->requ["bid"]] = 0;
				} else {
					//-- change
					$data->resp["change"] = 0;
					//-- shouldn't happend but delete hist anyway
					$data->update_hist[] = array(
						"cmd"=>"delete",
						"hist_id"=>$data->hist_id,
					);
				}
			}
		}

		//-- update
		$data->ddriver->update($data);
	}

}

?>