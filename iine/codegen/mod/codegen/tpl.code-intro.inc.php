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
<div class="psect">
	<div class="psect-body">
		<div style="margin-bottom:10px;text-align:left;">
			
		</div>

		<div class="status" style="display:table;width:100%;">
			<div style="display:table-cell;width:80px;text-align:left;">
				<button class="btn btn-default btn-back">
				<span class="glyphicon glyphicon-chevron-left"></span>
				<?php echo $lca_code["label:goback"]; ?></button>
			</div>

			<div style="display:table-cell;text-align:center;">
				<div class="success-msg"><?php echo $lca_code["msg:success"]; ?></div>
			</div>

			<div style="display:table-cell;width:80px;text-align:right;">
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<p><?php echo $lca_code["text:intro"]; ?></p>
			</div>
		</div>
	</div>
</div>
<?php // ?>