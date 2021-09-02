/*js
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajaxいいねボタン v2.23 [ GPL ]
// Copyright (c) phpkobo.com ( http://jpn.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : LKBNX-223J
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<
*/

(function($){

CFRes = {
	execute : function( resp, jqo_form ) {
		if ( jqo_form != undefined ) {
			CForm.setFRes(jqo_form,resp.fres);
			window.scrollTo(0,0);
		}
		if ( resp.fres.nmsg ) {
			CNotice.show(resp.fres);
		}
		
		return ( resp.fres.b_validated );
	}
};

}(jQuery));
