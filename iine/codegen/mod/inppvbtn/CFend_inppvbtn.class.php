<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CFend_inppvbtn extends CObject {

	public function init () {
		self::load(array(
			"fbc/CFend",
		));

		$this->bind("hd_HtmlHead");
		$this->bind("hd_Content");
	}

	public function hd_HtmlHead() {
		$url_mod = $this->urlMod();
?>
<?php CJRLdr::loadLocale("inppvbtn/dlgpvbtn"); ?>

<link rel="stylesheet" href="<?php echo $url_mod; ?>css/CDlgPvBtn2.css">
<script src="<?php echo $url_mod; ?>js/CDlgPvBtn2.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $url_mod; ?>css/CInpPvBtn2.css" />
<script type="text/javascript" src="<?php echo $url_mod; ?>js/CInpPvBtn2.js"></script>

<script type="text/javascript" src="<?php echo CEnv::urlClient(); ?>cn.php"></script>
<?php }

	public function hd_Content() {
		include( dirname(__FILE__) . "/tpl.dialog.inc.php" );
	}

}

?>