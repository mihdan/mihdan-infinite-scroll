<?php
/**
 * Plugin Name: Mihdan: Infinite Scroll
 * Plugin URI: https://github.com/mihdan/mihdan-infinite-scroll
 * Description: Бесконечный скролл для одиночных постов
 * Version: 1.0.21
 * Author: Mikhail Kobzarev
 * Author URI: https://www.kobzarev.com/
 * GitHub Plugin URI: https://github.com/mihdan/mihdan-infinite-scroll
 */

namespace Mihdan\Infinite\Scroll;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Core {
	/**
	 * Слаг
	 */
	const SLUG = 'mihdan_infinite_scroll';

	/**
	 * Путь к плагину
	 *
	 * @var string
	 */
	private static $dir_path;

	/**
	 * URL до плагина
	 *
	 * @var string
	 */
	private static $dir_uri;

	/**
	 * Хранит экземпляр класса
	 *
	 * @var $instance
	 */
	private static $instance;

	/**
	 * Вернуть единственный экземпляр класса
	 *
	 * @return Core
	 */
	public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	protected function __construct() {
		$this->setup();
		$this->includes();
		$this->hooks();
	}

	/**
	 * Настройки плагина
	 */
	public function setup() {
		self::$dir_path = trailingslashit( plugin_dir_path( __FILE__ ) );
		self::$dir_uri  = trailingslashit( plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Подключаем зависимости
	 */
	public function includes() {}

	/**
	 * Цепляемся за хуки
	 */
	public function hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'the_content', array( $this, 'add_prev_next_link' ) );
		add_filter( 'previous_post_link', array( $this, 'previous_post_link' ) );
		//add_filter( 'next_post_link', array( $this, 'next_post_link' ) );
	}

	/**
	 * Подключаем стили и скрипты
	 */
	public function enqueue_scripts() {
		// Суффикс для скриптов
		$suffix = ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? '' : '.min';

		// Настройки для JS
		$config = apply_filters( self::SLUG . '_config', array(
			'container'       => '.articles',
			'append'          => '.article',
			'history'         => 'push',
			'historyTitle'    => true,
			'next'            => '.' . self::SLUG . '_previous_post_link',
			'debug'           => false,
			'scrollThreshold' => 200,
			'status'          => '.' . self::SLUG . '_status',
		) );

		wp_register_script( self::SLUG, self::$dir_uri . 'assets/js/infinite-scroll.pkgd' . $suffix . '.js', array(), null, true );
		wp_register_script( self::SLUG . '_app', self::$dir_uri . 'assets/js/app.js', array( self::SLUG ), null, true );
		wp_register_style( self::SLUG . '_app', self::$dir_uri . 'assets/css/app.css', array(), null );

		wp_enqueue_script( self::SLUG );
		wp_enqueue_script( self::SLUG . '_app' );
		wp_enqueue_style( self::SLUG . '_app' );

		wp_localize_script( self::SLUG, self::SLUG . '_config', $config );
	}

	/**
	 * Добавляем ссылки не предыдущую и следующую записи
	 *
	 * @param $content
	 *
	 * @return mixed
	 */
	public function add_prev_next_link( $content ) {

		if ( is_single() ) {

			$content .= get_previous_post_link( '%link' );
			//$content .= get_next_post_link();
		}

		return $content;
	}

	/**
	 * Добавить класс для ссылки на предыдущий пост
	 *
	 * @param string $link html ссылка
	 *
	 * @return string
	 */
	public function previous_post_link( $link ) {

		$link = str_replace( 'rel="prev"', 'rel="prev" style="display: none" class="' . self::SLUG . '_previous_post_link"', $link );

		return $link;
	}

	/**
	 * Добавить класс для ссылки на следующий пост
	 *
	 * @param string $link html ссылка
	 *
	 * @return string
	 */
	public function next_post_link( $link ) {

		$link = str_replace( 'rel="next"', 'rel="prev" class="next_post_link"', $link );

		return $link;
	}
}

add_action( 'init', function () {
	return Core::get_instance();
} );
// eof;
