<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CFend_codegen extends CObject {

	public function init() {
		$this->bind("hd_HtmlHead");
		$this->bind("hd_Body");
		$this->bind("hd_Content");
	}

	public function hd_HtmlHead() {
		$url_mod = $this->urlMod();
?>
<?php CJRLdr::loadLocale("codegen/reminder"); ?>

<link href="<?php echo $url_mod; ?>css/CCodeGen2.css" rel="stylesheet">
<script src="<?php echo $url_mod; ?>js/CCodeGen2.js"></script>
<?php }

	public function hd_Body() {
		if ( !CAppReq::check() ) {
			echo "<style>body > main {max-width:none;}</style>";
			CAppReq::showErrMsgBox();
			exit;
		}
	}

	public function hd_Content() {
		include( dirname(__FILE__) . "/tpl.form.inc.php" );
?>
<?php }

}

?>