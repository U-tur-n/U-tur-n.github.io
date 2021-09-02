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
	<div class="psect-heading">
		<div class="cell-step">
			<span class="label-step"><?php echo $step++; ?></span>
		</div>
		<div class="cell-title"><?php echo $lca_form["title:generate-code"]; ?></div>
	</div>
	<div class="psect-body">

		<div class="row">
			<div class="col-sm-12">
				<p><?php echo $lca_form["text:generate-code"]; ?></p>

				<div class="form-group">
					<div style="text-align:center;padding-top:20px;">
						<button class="btn btn-lg btn-primary btn-gen-code">
						<?php echo $lca_form["label:generate-code"]; ?></button>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
<?php // ?>