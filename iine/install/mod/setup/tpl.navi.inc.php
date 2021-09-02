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
	<div class="psect-footer" style="border-width:1px 0 0 0;border-style:dotted;">
		<button class="btn btn-lg btn-default btn-back pull-left">
			<span class="glyphicon glyphicon-chevron-left"></span>
			<?php echo $lca["label:back"]; ?>
		</button>
		<button class="btn btn-lg btn-primary btn-next pull-right" <?php echo
			( isset($btn_next_disabled) && $btn_next_disabled ) ? "disabled" : ""; ?>>
			<?php echo $lca["label:next"]; ?>
			<span class="glyphicon glyphicon-chevron-right"></span>
		</button>
		<div style="clear:both;margin-bottom:20px;"></div>
	</div>
<?php // ?>