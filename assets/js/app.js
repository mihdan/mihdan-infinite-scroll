( function ( $, window, undefined ) {

	'use strict';

	var config = window.mihdan_infinite_scroll_config,
		infiniteScroll = window.infiniteScroll,
		next_url,
		update_next_url = function ( doc ) {
			next_url = $( doc ).find( config.next ).attr( 'href' );
		};

	// инициализация next_url
	update_next_url( document );

	$( config.container ).after( ' ' +
	                             '<div class="mihdan_infinite_scroll_status">\n' +
	                             '  <div class="loader-ellips infinite-scroll-request">\n' +
	                             '    <span class="loader-ellips__dot"></span>\n' +
	                             '    <span class="loader-ellips__dot"></span>\n' +
	                             '    <span class="loader-ellips__dot"></span>\n' +
	                             '    <span class="loader-ellips__dot"></span>\n' +
	                             '  </div>\n' +
	                             //'  <p class="infinite-scroll-last">End of content</p>\n' +
	                             '  <p class="infinite-scroll-error">Больше нет страниц для загрузки</p>\n' +
	                             '</div>'
	);

	// Инициализация Infinite Scroll
	var $container = $( config.container ).infiniteScroll( {
		// Функция для установки кастомного урла
		path: function() {
			return next_url;
		},
		append: config.append,
		history: config.history,
		historyTitle: config.historyTitle,
		debug: config.debug,
		scrollThreshold: config.scrollThreshold,
		status: config.status
	} );

	// Обновить next_url при загрузке страницы
	$container.on( 'load.infiniteScroll', function( event, response ) {
		update_next_url( response );
	} );

} )( window.jQuery, window );
