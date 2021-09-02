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

<style>
<?php
	$lca_css = CEnv::locale("app/css");
	echo $lca_css["css-reset"];
	echo $lca_css["css-init"];
?> 
</style>
<?php
if (!function_exists('array_key_first')) {
	function array_key_first($arr) {
		foreach($arr as $key => $unused) {
			return $key;
		}
		return NULL;
	}
}
?>
<?php
	$tids = CTplLoaderX::getAllTids(1);
	$tpls = CTplLoaderX::getTplsByTids($tids);
	$tid = count($tids) ? array_key_first($tids) : "";
	$tpl = ( $tid ) ? $tpls[$tid] : null;
?>

<div class="psect">
	<div class="psect-heading">
		<div class="cell-step">
			<span class="label-step"><?php echo $step++; ?></span>
		</div>
		<div class="cell-title"><?php echo $lca_form["title:select-tpl"]; ?></div>
	</div>
	<div class="psect-body">

		<div class="row">
			<div class="col-sm-12">
				<p><?php echo $lca_form["text:select-tpl"]; ?></p>

				<div class="form-group">
					<div class="inppvbtn-preview">
						<div class="inppvbtn-preview-css">
							<?php if ($tid): ?>
							<style class="inppvbtn-css-<?php echo $tid; ?>">
							<?php echo implode("\r\n",$tpl["css"]); ?>
							</style>
							<?php endif; ?>
						</div>
						<div class="inppvbtn-preview-header">
							<?php if ($tid): ?>
							<?php echo htmlspecialchars("{$tid}"); ?>
							<?php endif; ?>
						</div>
						<div class="inppvbtn-preview-body">
							<div class="ajax-iine">
							<?php if ($tid): ?>
							<?php echo CCompact::html($tpl["html"]["tpl.html"]); ?>
							<?php endif; ?>
							</div>
						</div>
					</div>
					<div style="text-align:center;">
						<button class="btn btn-default btn-inppvbtn-sel"
						style="min-width:200px;">
						<?php echo $lca_form["label:select-tpl"]; ?></button>
					</div>
					<script>
					$(".inppvbtn-preview-body").find(".aiin-vcnt").html(999);
					</script>
					<input type="text" class="inppvbtn _ffe_" name="tid" data-type="tpl"
						value="<?php echo $tid; ?>" />
				</div>
			</div>
		</div>
	</div>
</div>
<?php // ?>