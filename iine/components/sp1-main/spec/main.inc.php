<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタンv2.23用サービスパック１ [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBSP-100J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

$cfg["client"] = array(
	"cmpname"=>"main",
	"version"=>2.0,
	"pcf"=>array(
		"app"=>array(
			"CApp",
		),
		"poll"=>array(
			"CPoll",
		),
	),
	"js"=>array(

		/* base */
		"functions.js"=>array("scope"=>"base"),
		"CUtil.js"=>array("scope"=>"base"),
		"CCmp.js"=>array("scope"=>"base"),
		"CCMS.js"=>array("scope"=>"base"),
		"CGate.js"=>array("scope"=>"base"),
		"CHeadReso.js"=>array("scope"=>"base"),

		/* app */
		"CApp.js"=>array("scope"=>"app"),
		"CPoll.js"=>array("scope"=>"app"),

	),

);

?>