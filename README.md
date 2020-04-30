# Mihdan: Infinite Scroll

Плагин под WordPress, реализующий бесконечную подгрузку записей (постов) на одиночных(single) страницах.

> Плагине не работает на архивных (archive) страницах!

## Конфигурация

```php
add_filter(
    'mihdan_infinite_scroll_config',
    function( $config ) { 
        $config['container'] = '.articles',
        $config['append']    = '.article',

        return $config;
    }
);
```

## События

```php
$( '.articles' ).on(
	'append.infiniteScroll',
	function( event, response, path, items ) {
		// Делаем что-то.
	}
);
```

### Список возможных событий

* `scrollThreshold.infiniteScroll`
* `request.infiniteScroll`
* `load.infiniteScroll`
* `append.infiniteScroll`
* `error.infiniteScroll`
* `last.infiniteScroll`
* `history.infiniteScroll`

Более подробную информацию по событиями можно посмотреть на [официальном сайте](https://infinite-scroll.com/events.html#infinite-scroll-events) библиотеки Infinite Scroll.
