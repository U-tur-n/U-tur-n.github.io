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
<link href="<?php echo $url_mod; ?>css/CSetup.css" rel="stylesheet">
<link href="<?php echo $url_mod; ?>css/CPermCheck.css" rel="stylesheet">
<link href="<?php echo $url_mod; ?>css/CDone.css" rel="stylesheet">

<script src="<?php echo $url_mod; ?>js/CSetup.js"></script>
<script>
(function($){
	$(document).ready(function(){
		if ( !CDuan.isTouchDevice() ) {
			$(".homebtn").show();
		}
	});
}(jQuery));
</script>
<?php // ?>