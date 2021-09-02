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
			<span class="label-step-g"><?php echo $step++; ?></span>
		</div>
		<div class="cell-title">
			<?php echo $lca_code["title:put-script"]; ?>
		</div>
	</div>

	<div class="psect-body">
		<div class="row">
			<div class="col-sm-12">
				<p><?php echo $lca_code["text:put-script"]; ?></p>

<?php CInstCode::printScriptTag(); ?>
				<div style="margin:10px 0 20px 0;text-align:center;">
					<a class="btn btn-default inpcopy2clip _ffe_" href="#"
						data-text="<?php echo CInstCode::getScriptTag(); ?>"
					><?php echo $lca_code["label:copy-to-clip"]; ?></a>
				</div>

				<p><?php echo $lca_code["text:put-script-suggestion"]; ?></p>

<?php CInstCode::printScriptTagInHead(); ?>

				<p><?php echo $lca_code["text:put-script-note"]; ?></p>

			</div>
		</div>
	</div>
</div>
<?php // ?>