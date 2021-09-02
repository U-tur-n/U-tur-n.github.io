<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<
	$lca_appinfo = CEnv::locale( "app/info" );
	$lca_form = CEnv::locale( "codegen/form" );
?>

<div class="main">
<?php include("tpl.page-title.inc.php"); ?>

<div class="spage spage-form">
<?php include("tpl.form-intro.inc.php"); ?>

<div class="ctar-form">
<div class="ctar-falert"></div>
<?php $step = 1; ?>
<?php include("tpl.enter-key.inc.php"); ?>
<?php include("tpl.select-tpl.inc.php"); ?>
<?php include("tpl.generate-code.inc.php"); ?>
</div>
</div>

</div>

<?php // ?>