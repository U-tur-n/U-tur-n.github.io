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
"use strict";

function getVerN( ver ){
	var vx = ver.split(".");
	var cof = 1.0;
	var total = 0.0;
	for( var i=0; i<vx.length; i++ ) {
		total += parseInt(vx[i]) * cof;
		cof = cof / 100;
	}
	return total;
};

function shouldLoadJq( cfg ) {
	/* inclusive version range check */
	var b_load_jq = true;
	if ( window.jQuery ) {
		b_load_jq = false;
		var jq_vn = getVerN(window.jQuery.fn.jquery);
		if ( cfg.jq_min_ver ) {
			if ( jq_vn < getVerN(cfg.jq_min_ver) ) {
				b_load_jq = true;
			}
		}
		if ( cfg.jq_max_ver ) {
			if ( jq_vn > getVerN(cfg.jq_max_ver) ) {
				b_load_jq = true;
			}
		}
	}
	return b_load_jq;
};

function loadScript(url, callback){
	if ( !url ) {
		callback( false );
		return;
	}

	var script = document.createElement("script");
	script.type = "text/javascript";

	if (script.readyState){/*IE*/
		script.onreadystatechange = function(){
			if (script.readyState == "loaded" ||
				script.readyState == "complete"){
				script.onreadystatechange = null;
				callback( true );
			}
		};
	} else {/*Others*/
		script.onload = function(){
			callback( true );
		};
	}

	script.src = url;

	/*-- document.head.appendChild(script); --*/
	/*-- document.head isn't available to IE<9. Just use  --*/
	document.getElementsByTagName("head")[0].appendChild(script);
};

var loader = {
	jQuery:null,
	app_main:null
};

function runApp(loader) {
	var b = (loader.jQuery && loader.app_main);
	if (b) {
		window[loader.app_main](loader.jQuery,cfg.appcfg);
	}
	return b;
};

function main() {

	/*-- load jQuery --*/
	var url_js1 = shouldLoadJq(cfg) ? cfg.url_js1 : null;
	loadScript(url_js1,function(b_loaded){
		loader.jQuery = window.jQuery;
		if (b_loaded) {
			window.jQuery.noConflict(true);
		}
		runApp(loader);
	});

	/*-- load App --*/
	loadScript(cfg.url_js2,function(b_loaded){
		loader.app_main = cfg.app_main;
		runApp(loader);
	});
};

main();
