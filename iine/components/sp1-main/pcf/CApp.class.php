<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタンv2.23用サービスパック１ [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBSP-100J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CApp {

	public function __construct( $data ) {
		CCMS::bind("app-bind",$this,"bind");
	}

	public function bind( $data ) {
		CCMS::bind("app-ddriver",$this,"ddriver");
		CCMS::bind("app-dispatch",$this,"dispatch");
		CCMS::bind("app-cmd-init",$this,"cmd_init");
		CCMS::bind("app-cmd-vote",$this,"cmd_vote");
		CCMS::bind("app-output",$this,"output");
	}

	public function dispatch( $data ) {
		$data->cmd = CData::sanitizeCmd( $data );

		if ( empty($data->cmd) ) {
			CData::setResult($data,"missing cmd");
			return;
		}

		CCMS::trigger("app-cmd-".$data->cmd,$data);
	}

	public function ddriver( $data ) {
		$data->ddriver = new CDDriver();
	}

	public function cmd_init( $data ) {
		if ( empty($data->requ["pollx"]) ) {
			return;
		}

		//-- init
		CData::sanitizeTids($data);
		CData::makeDataStruct($data);

		//-- html
		$data->resp["htmlx"] = CComponent::htmlcode(
			CComponent::buildReso("html"),"app");

		//-- css
		$data->resp["cssx"] = array();
		$lca = CEnv::locale("app/css");
		if ( $data->requ["b_css_reset"] ) {
			CData::addCss($lca["css-reset"]);
		}
		CData::addCss($lca["css-init"]);
		CData::addCss(CComponent::csscode(
			CComponent::buildReso("css"),"app"));

		//-- data driver
		CCMS::trigger("app-ddriver",$data);
		if ( $data->ddriver->open_status ) {
			CData::setResult($data,"database error [".
				$data->ddriver->open_status . "]" );
			return;
		}
		$data->ddriver->load($data);

		//-- run poll classes
		CComponent::registerPcfClass("poll",$data);
		CCMS::trigger("poll-bind",$data);
		CCMS::trigger("poll-load",$data);
		CCMS::trigger("poll-type",$data);
		CCMS::trigger("poll-pack",$data);
	}

	public function cmd_vote( $data ) {

		//-- init
		if ( !CData::validateID($data,
			array("wid","pid","tid","bid")) ) {
			return;
		}

		//-- setup tpl and type
		CData::makeTpl($data);
		$data->resp["type"] = isset($data->requ["type"]) ? 
			$data->requ["type"] : "def";

		//-- data driver
		CCMS::trigger("app-ddriver",$data);

		//-- expire voters
		$data->ddriver->expire($data);

		//-- run poll classes
		CComponent::registerPcfClass("poll",$data);
		CCMS::trigger("poll-bind",$data);
		CCMS::trigger("poll-vote",$data);
	}

	public function output( $data ) {
		echo CJson::encode($data->resp);
	}

	public function run( $data ) {
		CCMS::trigger("app-bind",$data);
		CCMS::trigger("app-dispatch",$data);
		CCMS::trigger("app-output",$data);
	}

}

?>