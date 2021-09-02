<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<
?>
<div class="dlgpvbtn-list">
<?php
	foreach( $tpls as $tid => $cfg ) {
		if ( isset($cfg["html"]["tpl.html"]) ) {
?>
<style class="inppvbtn-css-<?php echo $tid; ?>">
<?php echo implode("\r\n",$cfg["css"]); ?>
</style>

<div class="dlgpvbtn-box" data-key="<?php echo $tid; ?>" tabindex="0">
	<div class="dlgpvbtn-box-header">
		<?php echo htmlspecialchars("{$tid}"); ?>
	</div>
	<div class="dlgpvbtn-box-body">
		<div class="ajax-iine">
			<?php echo CCompact::html($cfg["html"]["tpl.html"]); ?>
		</div>
	</div>
</div>

	<?php }
	}
?>
<div class="dlgpvbtn-endbar"></div>
</div>

</div>
<?php // ?>