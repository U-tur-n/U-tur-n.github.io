<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CInstCode {

	private static $url_script;
	private static $cls_selector;
	private static $pid;
	private static $tid;

	public static function setup( $pid, $tid ) {

		self::$url_script = self::urlScript();

		$cfg = CEnv::config("client/ajax");
		self::$cls_selector = $cfg["appcfg"]["cls_selector"];

		self::$pid = $pid;
		self::$tid = $tid;
	}

	private static function urlScript() {
		$cfg = CEnv::config("admin/app");
		if ( $cfg["domain-in-url"] ) {
			$url = CEnv::urlClient() . "cn.php";
		} else {
			$url = dirname(dirname($_SERVER["SCRIPT_NAME"])) .
				"/" . CEnv::get("dir-client") . "/cn.php";
		}

		return $url;
	}

	private static function printSourceCode( $txt ) {
		$conv = array(
			"<"=>"&lt;",
			">"=>"&gt;",
			"["=>"<",
			"]"=>">",

		);
		foreach( $conv as $key => $val ) {
			$txt = str_replace( $key, $val, $txt );
		}
		echo "<pre class='code-box'>{$txt}</pre>";
	}

	private static function removeTags( $txt ) {
		$txt = str_replace( "[span class='code-hl']", "", $txt );
		$txt = str_replace( "[/span]", "", $txt );
		return $txt;
	}

	public static function printCss() { ?>
<style>
.code-box {
	font-size:100%;
}
.code-body {
	color:#888;
}
.code-hl {
	font-weight:bold;
	color:#000;
	background-color:#ff8;
}
.label-big {
	font-size:100%;
}
</style>
<?php }

	public static function srcScriptTag() {
		$url_script = self::$url_script;
		$txt=<<<_EOM_
[span class='code-hl']<script type="text/javascript" src="{$url_script}"></script>[/span]
_EOM_;
		return $txt;
	}

	public static function printScriptTag() {
		self::printSourceCode(self::srcScriptTag());
	}

	public static function getScriptTag() {
		return htmlspecialchars(self::removeTags(self::srcScriptTag()));
	}

	public static function printScriptTagInHead() {
		$url_script = self::$url_script;
		$txt=<<<_EOM_
[span class='code-body']<head>
...
...
[span class='code-hl']<script type="text/javascript" src="{$url_script}"></script>[/span]
...
...
</head>[/span]
_EOM_;
		self::printSourceCode( $txt );
	}

	public static function srcDivTag() {
		$cls_selector = self::$cls_selector;
		$pid = self::$pid;
		$tid = self::$tid;
		$txt=<<<_EOM_
[span class='code-hl']<div class="{$cls_selector}" data-pid="{$pid}" data-tid="{$tid}"></div>[/span]
_EOM_;
		return $txt;
	}

	public static function printDivTag() {
		self::printSourceCode(self::srcDivTag());
	}

	public static function getDivTag() {
		return htmlspecialchars(self::removeTags(self::srcDivTag()));
	}

	public static function getDemoHtml() {
		$url_script = self::$url_script;
		$cls_selector = self::$cls_selector;
		$pid = self::$pid;
		$tid = self::$tid;
		$txt=<<<_EOM_
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
[span class='code-hl']<script type="text/javascript" src="{$url_script}"></script>[/span]
</head>
<body>
[span class='code-hl']<div class="{$cls_selector}" data-pid="{$pid}" data-tid="{$tid}"></div>[/span]
</body>
</html>
_EOM_;
		return $txt;
	}

	public static function printDemoHtml() {
		self::printSourceCode( self::getDemoHtml() );
	}

	public static function getDemoSrc() {
		return self::removeTags(self::getDemoHtml());
	}

}

?>