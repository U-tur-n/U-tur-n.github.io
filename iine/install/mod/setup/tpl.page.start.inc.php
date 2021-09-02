<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<
	$lca_ai = CEnv::locale("app/info");
	$lca = CEnv::locale("install/page.start");
	$msg = str_replace( "%app-name%", $lca_ai["app:name"], $lca["click-start"] );
?>
<article style="margin-left:auto;margin-right:auto;max-width:900px;">

<div class="page1">
<input type="hidden" name="page-key" value="start"/>

<div class="psect">
	<div class="psect-body">
		<div class="ctar-form">
			<p class="instruction text-info">
				<?php echo $msg; ?> 
			</p>

			<div class="ctar-falert"></div>

			<div style="text-align:center;">
				<h1><button type="button" class="btn btn-primary btn-lg btn-start"
					><?php echo $lca[ "btn-start" ]; ?></button></h1>
			</div>

<?php if ( !empty($lca_ai[ "app:home:url" ]) ): ?>
			<div class="homebtn btn-a" data-href="<?php echo $lca_ai[ "app:home:url" ]; ?>"
				data-target="_blank" title="<?php echo $lca_ai[ "app:home:name" ]; ?>"
				><span class="glyphicon glyphicon-home"></span></div>
<?php endif; ?>

		</div>
	</div>

</div>

</div>

<textarea id="wdata" style="display:none;">{}</textarea>

</article>
<?php // ?>