# mihdan-infinite-scroll
WordPress-плагин, реализующий бесконечную подгрузку постов на сингл-страницах 

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
