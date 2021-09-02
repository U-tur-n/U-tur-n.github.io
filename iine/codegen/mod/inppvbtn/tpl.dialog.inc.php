<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<
	$lca = CEnv::locale("inppvbtn/dlgpvbtn");
?>
<div class="dlg dlgpvbtn">

<div class="dlg-heading">
	<div class="dlgpvbtn-heading-table">
		<div class="dlgpvbtn-heading-tcell">
			<span class="dlgpvbtn-title"></span>
		</div>
		<div class="dlgpvbtn-heading-tcell">
			<div class="dlgpvbtn-itotal">
				<span class="dlgpvbtn-itotal-cnt"></span>
				<div class="dlgpvbtn-itotal-bg dlgpvbtn-itotal-bg1"></div>
				<div class="dlgpvbtn-itotal-bg dlgpvbtn-itotal-bg2"></div>
				<div class="dlgpvbtn-itotal-bg dlgpvbtn-itotal-bg3"></div>
			</div>
		</div>
		<div class="dlgpvbtn-heading-tcell">
			<div class="btn-close"
				tabindex="0"
				title="<?php echo $lca["alt:close"]; ?>">
				<span class="btn-close-label">&times;</span>
			</div>
		</div>
	</div>
</div>

<div class="dlg-searchbar">
	<div class="dlg-searchbar-tcell-inp">
		<input type="text" class="form-control input-lg keyword" name="keyword">
	</div>
	<div class="dlg-searchbar-tcell-search" tabindex="0">
		<span class="glyphicon glyphicon-search"></span>
	</div>
</div>

<div class="dlg-body"></div>

<div class="dlg-footer dlgpvbtn-footer">
	<div class="dlgpvbtn-nav">
		<div class="dlgpvbtn-nav-dir dlgpvbtn-nav-first" tabindex="0" data-dir="first">
			<span class="glyphicon glyphicon-step-backward"></span>
		</div>
		<div class="dlgpvbtn-nav-dir dlgpvbtn-nav-prev" tabindex="0" data-dir="prev">
			<span class="glyphicon glyphicon-chevron-left"></span>
		</div>

		<div class="dlgpvbtn-nav-count">
			<span class="dlgpvbtn-nav-pidx">0</span>
			<span class="dlgpvbtn-nav-sepa"> / </span>
			<span class="dlgpvbtn-nav-ptotal">0</span>
		</div>

		<div class="dlgpvbtn-nav-dir dlgpvbtn-nav-next" tabindex="0" data-dir="next">
			<span class="glyphicon glyphicon-chevron-right"></span>
		</div>
		<div class="dlgpvbtn-nav-dir dlgpvbtn-nav-last" tabindex="0" data-dir="last">
			<span class="glyphicon glyphicon-step-forward"></span>
		</div>
	</div>
</div>

</div>
<?php // ?>