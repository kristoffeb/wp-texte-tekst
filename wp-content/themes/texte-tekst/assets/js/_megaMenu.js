( function( megaMenu, $, undefined ) {
	'use strict';

	megaMenu.init = function() {
		var burger = $('#menu .burger');
		var body = $('body');

		burger.click(function() {
			body.toggleClass('menu-open');
		});
	};

} ( window.megaMenu = window.megaMenu || {}, jQuery ) );
