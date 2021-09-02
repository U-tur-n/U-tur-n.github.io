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
		<div class="cell-title">
			<span class="label-step-r"><?php echo $lca_code["title:appendix"]; ?></span>
		</div>
	</div>

	<div class="psect-body">
		<div class="row">
			<div class="col-sm-12">
				<p><?php echo $lca_code["text:appendix"]; ?></p>

<?php CInstCode::printDemoHtml(); ?>
<?php $url = CApp::vurl("run-demo","pid={$pid}&tid={$tid}"); ?>
				<div style="text-align:center;">
					<a class="btn btn-default" href="<?php echo $url ?>" target="_blank">
					<?php echo $lca_code["label:run-demo"]; ?></a>
				</div>

			</div>
		</div>
	</div>
</div>
<?php // ?>