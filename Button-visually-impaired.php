<?php
/**
 * Button visually impaired
 * Plugin Name: Button visually impaired
 * Plugin URI: http://bvi.isvek.ru/
 * Description: Версия сайта для слабовидящих.
 * Version: 2.0
 * Author: Vek
 * Text Domain: bvi-languages
 * Domain Path: /languages/
 * Author URI: https://github.com/veks
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

class bvi_plugin {
	/**
	 * Название плагина
	 *
	 * @var string $plugin_name
	 */
	public $plugin_name = 'Button visually impaired';

	/**
	 * Текущая версия плагина
	 *
	 * @var string $version
	 */
	public $version = '2.0';

	/**
	 * Опции плагина
	 *
	 * @var array $get_option
	 */
	public $get_option;

	/**
	 * Настройки опции плагина
	 *
	 * @var string $get_option_name
	 */
	public $get_option_name = 'bvi_database';

	/**
	 * bvi_plugin constructor.
	 */
	public function __construct() {
		$this->get_option = get_option( $this->get_option_name );

		add_action( 'plugins_loaded', array( $this, 'languages' ), 10, 0 );
		add_action( 'plugins_loaded', array( &$this, 'constants' ), 10, 0 );
		add_action( 'admin_menu', array( &$this, 'add_plugin_menu' ), 10, 0 );
		add_action( 'admin_init', array( $this, 'display_options' ) );
		add_filter( 'plugin_action_links', array( &$this, 'add_plugin_page_settings_link' ), 10, 2 );

		/**
		 * Выводим плагин на внешний интерфейс
		 */
		if ( $this->get_option['bvi_active'] == 1 ) {
			add_action( 'wp_enqueue_scripts', array( &$this, 'frontend_assets' ), 999, 0 );
			add_shortcode( 'bvi', array( &$this, 'shortcode' ), 999, 0 );
		}

		register_activation_hook( __FILE__, array( $this, 'activation_plugin' ) );
	}

	/**
	 *
	 */
	public function languages() {
		load_plugin_textdomain( 'bvi-languages', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Ссылка на странице плагинов
	 *
	 * @param string $links
	 * @param string $plugin_file
	 *
	 * @return array
	 */
	public function add_plugin_page_settings_link( $links, $plugin_file ) {
		if ( $plugin_file == plugin_basename( __FILE__ ) && current_user_can( 'administrator' ) ) {
			$url     = admin_url( 'admin.php?page=bvi' );
			$links   = (array) $links;
			$links[] = sprintf( '<a href="%s">%s</a>', $url, 'Настройки' );
		}

		return $links;
	}

	/**
	 * Шорткод
	 *
	 * @param array $atts
	 * @param null  $content
	 *
	 * @return string
	 */
	public function shortcode( $atts, $content = null ) {
		if ( ! empty( $atts['text'] ) ) {
			extract(
				shortcode_atts(
					array(
						'bvi_text' => $atts['text'],
					), $atts
				)
			);
		} else {
			$bvi_text = '';
		}

		return '<a href="#" class="bvi-link-shortcode bvi-open"><svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="bvi-svg-eye"><path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"></path></svg> ' . $bvi_text . '</a>';
	}

	/**
	 * Константы плагина
	 */
	public function constants() {
		define( 'BVI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		define( 'BVI_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		define( 'BVI_PLUGIN_DIR_PAGES', BVI_PLUGIN_DIR . 'pages/' );
		define( 'BVI_PLUGIN_URL_CSS', BVI_PLUGIN_URL . 'assets/css/' );
		define( 'BVI_PLUGIN_URL_JS', BVI_PLUGIN_URL . 'assets/js/' );
		define( 'BVI_PLUGIN_URL_IMG', BVI_PLUGIN_URL . 'assets/img/' );
	}

	/**
	 * Файлы стилей и скриптов для администратора
	 */
	public function frontend_assets_admin() {
		wp_enqueue_script( 'jquery' );

		wp_register_script( 'bvi-bootstrap', BVI_PLUGIN_URL_JS . 'bootstrap.min.js', array( 'jquery' ), '4.3.1', true );
		wp_enqueue_script( 'bvi-bootstrap' );

		wp_register_style( 'bvi-bootstrap', BVI_PLUGIN_URL_CSS . 'bootstrap.min.css', '', $this->version );
		wp_enqueue_style( 'bvi-bootstrap' );
	}

	/**
	 * Файлы стилей и скриптов для внешнего интерфейса
	 */
	public function frontend_assets() {
		wp_register_style( 'bvi-style', BVI_PLUGIN_URL_CSS . 'bvi.min.css', '2.0', $this->version );

		$bvi_style = "a.bvi-link-widget, a.bvi-link-shortcode {color: {$this->get_option['bvi_link_color']} !important; background-color: {$this->get_option['bvi_link_bg']} !important;}";
		wp_enqueue_style( 'bvi-style' );
		wp_add_inline_style( 'bvi-style', $bvi_style );

		wp_enqueue_script( 'jquery' );

		wp_register_script( 'bvi-cookie', BVI_PLUGIN_URL_JS . 'js.cookie.min.js', array( 'jquery' ), '2.2.1', $this->script_location() );
		wp_enqueue_script( 'bvi-cookie' );

		wp_register_script( 'bvi-init', BVI_PLUGIN_URL_JS . 'bvi-init.min.js', array( 'jquery' ), $this->version, $this->script_location() );
		wp_localize_script(
			'bvi-init', 'bvi_init', array(
				          'settings' => array(
					          'bvi_theme'          => (string) $this->get_option['bvi_theme'],
					          'bvi_font'           => (string) $this->get_option['bvi_font'],
					          'bvi_font_size'      => (int) $this->get_option['bvi_font_size'],
					          'bvi_letter_spacing' => (string) $this->get_option['bvi_letter_spacing'],
					          'bvi_line_height'    => (string) $this->get_option['bvi_line_height'],
					          'bvi_images'         => ( $this->get_option['bvi_images'] === 'grayscale' ) ? $this->get_option['bvi_images'] : filter_var( $this->get_option['bvi_images'], FILTER_VALIDATE_BOOLEAN ),
					          'bvi_reload'         => filter_var( $this->get_option['bvi_reload'], FILTER_VALIDATE_BOOLEAN ),
					          'bvi_fixed'          => filter_var( $this->get_option['bvi_fixed'], FILTER_VALIDATE_BOOLEAN ),
					          'bvi_tts'            => filter_var( $this->get_option['bvi_tts'], FILTER_VALIDATE_BOOLEAN ),
					          'bvi_flash_iframe'   => filter_var( $this->get_option['bvi_flash_iframe'], FILTER_VALIDATE_BOOLEAN ),
					          'bvi_hide'           => filter_var( $this->get_option['bvi_hide'], FILTER_VALIDATE_BOOLEAN ),
				          ),
			          )
		);
		wp_enqueue_script( 'bvi-init' );

		wp_register_script( 'bvi-js', BVI_PLUGIN_URL_JS . 'bvi.min.js', array( 'jquery' ), $this->version, $this->script_location() );
		wp_enqueue_script( 'bvi-js' );
	}

	/**
	 * Местоположение скрипта
	 *
	 * @return bool
	 */
	public function script_location() {
		if ( $this->get_option['bvi_script_location'] == false ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Регистрация меню
	 */
	public function add_plugin_menu() {
		if ( function_exists( 'add_menu_page' ) ) {
			$admin_menu = add_menu_page(
				"Плагин для слабовидящих bvi v{$this->version}",
				"BVI v{$this->version}",
				'administrator',
				'bvi',
				array( &$this, 'bvi_settings_page' ),
				'dashicons-universal-access-alt'
			);

			add_action( "admin_print_scripts-{$admin_menu}", array( $this, 'frontend_assets_admin' ) );
		}
	}

	/**
	 * Активация плагина
	 */
	public function activation_plugin() {
		if ( current_user_can( 'administrator' ) ) {

			$db = self::settings_default();

			if ( get_option( 'database_bvi' ) ) {
				delete_option( 'database_bvi' );
			}

			if ( get_option( 'bvi_database' ) ) {
				update_option( 'bvi_database', $db );
			} else {
				add_option( 'bvi_database', $db );
			}
		}
	}

	/**
	 * Настройки плагина по умолчанию
	 *
	 * @return array
	 */
	public function settings_default() {
		$settings_default = array(
			'bvi_active'          => 0,
			'bvi_script_location' => 0,
			'bvi_theme'           => 'white',
			'bvi_font'            => 'arial',
			'bvi_font_size'       => '16',
			'bvi_letter_spacing'  => 'normal',
			'bvi_line_height'     => 'normal',
			'bvi_images'          => 1,
			'bvi_reload'          => 0,
			'bvi_tts'             => 1,
			'bvi_flash_iframe'    => 1,
			'bvi_hide'            => 0,
			'bvi_fixed'           => 1,
			'bvi_link_color'      => '#ffffff',
			'bvi_link_bg'         => '#e53935',
			'bvi_link_text'       => 'Версия сайта для слабовидящих',
		);

		return $settings_default;
	}

	/**
	 * Отображение опций
	 */
	public function display_options() {

		register_setting( 'bvi-setting', $this->get_option_name, array( $this, 'bvi_validate_option' ) );

		register_setting( 'bvi-section-reset', $this->get_option_name, array( $this, 'bvi_reset_validate_option' ) );

		add_settings_section( "bvi-section", "Внешний вид версии сайта для слабовидящих", null, "bvi" );
		add_settings_section( "bvi-section-widgets", "Настройки виджета и шорткода", null, "bvi" );

		add_settings_field(
			"bvi-active",
			"Плагин активен",
			array( $this, "bvi_element_options" ),
			"bvi",
			"bvi-section",
			array(
				'name'      => 'bvi_active',
				'type'      => 'radio',
				'id'        => 'bvi-active',
				'desc'      => '',
				'value'     => array(
					0 => 'Нет',
					1 => 'Да',
				),
				'label_for' => 'bvi-active',
			)
		);

		add_settings_field(
			"bvi-theme",
			"Цветовая гамма",
			array( $this, "bvi_element_options" ),
			"bvi",
			"bvi-section",
			array(
				'name'      => 'bvi_theme',
				'type'      => 'select',
				'id'        => 'bvi-theme',
				'desc'      => '',
				'value'     => array(
					'white' => 'Белым по черному',
					'black' => 'Черным по белому',
					'blue'  => 'Темно-синим по голубому',
					'brown' => 'Коричневым по бежевому',
					'green' => 'Зеленым по темно-коричневому',
				),
				'label_for' => 'bvi-theme',
			)
		);

		add_settings_field(
			"bvi-font-size",
			"Размер шрифта",
			array( $this, "bvi_element_options" ),
			"bvi",
			"bvi-section",
			array(
				'name'      => 'bvi_font_size',
				'type'      => 'select',
				'id'        => 'bvi-font-size',
				'desc'      => '',
				'value'     => $this->get_bvi_font_size(),
				'label_for' => 'bvi-font-size',
			)
		);

		add_settings_field(
			"bvi-font",
			"Шрифт",
			array( $this, "bvi_element_options" ),
			"bvi",
			"bvi-section",
			array(
				'name'      => 'bvi_font',
				'type'      => 'select',
				'id'        => 'bvi-font',
				'desc'      => '',
				'value'     => array(
					'arial' => 'Без засечек - Arial',
					'times' => 'С засечками - Times New roman',
				),
				'label_for' => 'bvi-font',
			)
		);

		add_settings_field(
			"bvi-letter-spacing",
			"Межбуквенный интервал",
			array( $this, "bvi_element_options" ),
			"bvi",
			"bvi-section",
			array(
				'name'      => 'bvi_letter_spacing',
				'type'      => 'select',
				'id'        => 'bvi-letter-spacing',
				'desc'      => 'Задайте расстояние между буквами, так называемую "разрядку".',
				'value'     => array(
					'normal'  => 'Одинарный',
					'average' => 'Полуторный',
					'big'     => 'Двойной',
				),
				'label_for' => 'bvi-letter-spacing',
			)
		);

		add_settings_field(
			"bvi-line-height",
			"Междустрочный интервал",
			array( $this, "bvi_element_options" ),
			"bvi",
			"bvi-section",
			array(
				'name'      => 'bvi_line_height',
				'type'      => 'select',
				'id'        => 'bvi-line-height',
				'desc'      => 'Задайте вертикальное расстояние между строками.',
				'value'     => array(
					'normal'  => 'Одинарный',
					'average' => 'Полуторный',
					'big'     => 'Двойной',
				),
				'label_for' => 'bvi-line-height',
			)
		);

		add_settings_field(
			"bvi-images",
			"Адаптация изображений",
			array( $this, "bvi_element_options" ),
			"bvi",
			"bvi-section",
			array(
				'name'      => 'bvi_images',
				'type'      => 'select',
				'id'        => 'bvi-images',
				'desc'      => '',
				'value'     => array(
					1           => 'Без изменений',
					'grayscale' => 'Серая гамма',
					0           => 'Изображения отключены',
				),
				'label_for' => 'bvi-images',
			)
		);

		add_settings_field(
			"bvi-reload",
			"Включить перезагрузку страницы",
			array( $this, "bvi_element_options" ),
			"bvi",
			"bvi-section",
			array(
				'name'      => 'bvi_reload',
				'type'      => 'radio',
				'id'        => 'bvi-reload',
				'desc'      => 'При переходе на <u>обычную версию сайта</u> текущая страница будет презагружена.',
				'value'     => array(
					0 => 'Нет',
					1 => 'Да',
				),
				'label_for' => 'bvi-reload',
			)
		);

		add_settings_field(
			"bvi-tts",
			"Включить синтез речи",
			array( $this, "bvi_element_options" ),
			"bvi",
			"bvi-section",
			array(
				'name'      => 'bvi_tts',
				'type'      => 'radio',
				'id'        => 'bvi-tts',
				'desc'      => 'Синтезатор речи озвучит вслух изменения настроек отображения, которые произведёт пользователь.',
				'value'     => array(
					0 => 'Нет',
					1 => 'Да',
				),
				'label_for' => 'bvi-tts',
			)
		);

		add_settings_field(
			"bvi-flash-iframe",
			"Включить встроенные элементы",
			array( $this, "bvi_element_options" ),
			"bvi",
			"bvi-section",
			array(
				'name'      => 'bvi_flash_iframe',
				'type'      => 'radio',
				'id'        => 'bvi-flash-iframe',
				'desc'      => '<u>Встроенные элементы</u> - это компонент HTML-элемента, который позволяет встраивать документы, видео, карты и интерактивные медиафайлы на страницу.',
				'value'     => array(
					0 => 'Нет',
					1 => 'Да',
				),
				'label_for' => 'bvi-flash-iframe',
			)
		);

		add_settings_field(
			"bvi-not-work",
			"Выберите источник / местоположение скрипта и таблиц стилей плагина",
			array( $this, "bvi_element_options" ),
			"bvi",
			"bvi-section",
			array(
				'name'      => 'bvi_script_location',
				'type'      => 'radio',
				'id'        => 'bvi-not-work',
				'desc'      => 'Если вы заметили какие-либо ошибки на своем веб-сайте после переключения параметра, просто переключите его снова, и ваш сайт вернется в нормальное состояние. <br><code>head</code> - Верхняя часть сайта.<br><code>footer</code> - Нижняя часть сайта.',
				'value'     => array(
					1 => 'head',
					0 => 'footer',
				),
				'label_for' => 'bvi-not-work',
			)
		);

		add_settings_field(
			"bvi-hide",
			"Скрыть панель настроек плагина",
			array( $this, "bvi_element_options" ),
			"bvi",
			"bvi-section",
			array(
				'name'      => 'bvi_hide',
				'type'      => 'radio',
				'id'        => 'bvi-hide',
				'desc'      => 'Панель настроек плагина для пользователя скроется, когда пользователь включит версию вашего сайта для слабовидящих, в место неё будет выводится иконка плагина.',
				'value'     => array(
					0 => 'Нет',
					1 => 'Да',
				),
				'label_for' => 'bvi-hide',
			)
		);

		add_settings_field(
			"bvi-fixed",
			"Зафиксировать панель настроек плагина в верхней части страницы.",
			array( $this, "bvi_element_options" ),
			"bvi",
			"bvi-section",
			array(
				'name'      => 'bvi_fixed',
				'type'      => 'radio',
				'id'        => 'bvi-fixed',
				'desc'      => 'Панель настроек плагина для пользователя будет зафиксирована в верхней части при прокрутке страницы.',
				'value'     => array(
					0 => 'Нет',
					1 => 'Да',
				),
				'label_for' => 'bvi-fixed',
			)
		);

		add_settings_field(
			"bvi-link-text",
			"Текст виджета ссылки для переключения версии сайта",
			array( $this, "bvi_element_options" ),
			"bvi",
			"bvi-section-widgets",
			array(
				'name'      => 'bvi_link_text',
				'type'      => 'text',
				'id'        => 'bvi-link-text',
				'desc'      => 'Данный текст <u>не применяется</u> в шорткоде.',
				'label_for' => 'bvi-link-text',
			)
		);

		add_settings_field(
			"bvi-link-color",
			"Цвет ссылки для переключения версии сайта",
			array( $this, "bvi_element_options" ),
			"bvi",
			"bvi-section-widgets",
			array(
				'name'      => 'bvi_link_color',
				'type'      => 'color',
				'id'        => 'bvi-link-color',
				'desc'      => 'Данный цвет применяется в виджете, шорткоде и иконки.',
				'label_for' => 'bvi-link-color',
			)
		);

		add_settings_field(
			"bvi-link-bg",
			"Фон ссылки для переключения версии сайта",
			array( $this, "bvi_element_options" ),
			"bvi",
			"bvi-section-widgets",
			array(
				'name'      => 'bvi_link_bg',
				'type'      => 'color',
				'id'        => 'bvi-link-bg',
				'desc'      => 'Данный цвет применяется в виджете и шорткоде.',
				'label_for' => 'bvi-link-bg',
			)
		);
	}

	/**
	 * Размеры шрифта
	 *
	 * @return mixed
	 */
	public function get_bvi_font_size() {
		for ( $i = 1; $i <= 40; $i ++ ) {
			$array[ $i ] = $i;
		}

		return $array;
	}

	/**
	 * Определяем тип элемента поля
	 *
	 * @param $args
	 *
	 * @return mixed
	 */
	public function bvi_element_options( $args ) {
		switch ( $args['type'] ) {
			case 'text' :
				echo "<input type='text' name='{$this->get_option_name}[{$args['name']}]' value='{$this->get_option[$args['name']]}' class='regular-text code' id='{$args['id']}' class='regular-text'/>";
				echo ( $args['desc'] != '' ) ? "<p id='tagline-description' class='description'>{$args['desc']}</p>" : "";
				break;
			case 'select' :
				$bvi_font_size = ( $args['name'] == 'bvi_font_size' ) ? 'пикселов.' : '';

				echo "<select name='{$this->get_option_name}[{$args['name']}]' id='{$args['id']}'>";
				foreach ( $args['value'] as $key => $value ) {
					$selected = selected( $key, $this->get_option[ $args['name'] ], false );
					echo "<option value='{$key}'{$selected}>{$value}</option>";
				}
				echo "</select>" . " " . $bvi_font_size;
				echo ( $args['desc'] != '' ) ? "<p id='tagline-description' class='description'>{$args['desc']}</p>" : "";
				break;
			case 'color' :
				echo "<input type='color' name='{$this->get_option_name}[{$args['name']}]' value='{$this->get_option[$args['name']]}' id='{$args['id']}'>";
				echo ( $args['desc'] != '' ) ? "<p id='tagline-description' class='description'>{$args['desc']}</p>" : "";
				break;
			case 'radio' :
				echo "<div class='btn-group btn-group-toggle btn-group-sm shadow-sm {$args['id']}' id='{$args['id']}' data-toggle='buttons'>";
				foreach ( $args['value'] as $key => $value ) {
					$keys    = ( $key == 0 ) ? 'danger' : 'success';
					$active  = ( $key == $this->get_option[ $args['name'] ] ) ? ' active' : '';
					$checked = ( checked( $key, $this->get_option[ $args['name'] ], false ) ) ? " checked" : '';
					echo "<label class='btn btn-outline-{$keys}{$active}'><input type='radio' name='{$this->get_option_name}[{$args['name']}]' value='{$key}' id='{$args['id']}' autocomplete='off'{$checked}>{$value}</label>";
				}
				echo '</div>';
				echo ( $args['desc'] != '' ) ? "<p id='tagline-description' class='description'>{$args['desc']}</p>" : "";
				break;
		}
	}

	/**
	 * Проверка форм
	 *
	 * @param $input
	 *
	 * @return mixed
	 */
	public function bvi_validate_option( $input ) {
		$output = $this->get_option;

		if ( ( $input['bvi_active'] == 1 || $input['bvi_active'] == 0 ) ) {
			$output['bvi_active'] = $input['bvi_active'];
		} else {
			add_settings_error( 'bvi-active', 'invalid-bvi-active', 'Неправильное значение для поля (Плагин активен).' );
		}

		if ( $input['bvi_theme'] == 'white' || $input['bvi_theme'] == 'black' || $input['bvi_theme'] == 'blue' || $input['bvi_theme'] == 'brown' || $input['bvi_theme'] == 'green' ) {
			$output['bvi_theme'] = $input['bvi_theme'];
		} else {
			add_settings_error( 'bvi-theme', 'invalid-bvi-theme', 'Неправильное значение для поля (Цветовая гамма).' );
		}

		if ( preg_match( '/^[0-9]{0,2}$/', $input['bvi_font_size'] ) ) {
			$output['bvi_font_size'] = $input['bvi_font_size'];
		} else {
			add_settings_error( 'bvi-font', 'invalid-bvi-font', 'Неправильное значение для поля (Размер шрифта).' );
		}

		if ( $input['bvi_font'] == 'arial' || $input['bvi_font'] == 'times' ) {
			$output['bvi_font'] = $input['bvi_font'];
		} else {
			add_settings_error( 'bvi-font', 'invalid-bvi-font', 'Неправильное значение для поля (Шрифт).' );
		}

		if ( $input['bvi_letter_spacing'] == 'normal' || $input['bvi_letter_spacing'] == 'average' || $input['bvi_letter_spacing'] == 'big' ) {
			$output['bvi_letter_spacing'] = $input['bvi_letter_spacing'];
		} else {
			add_settings_error( 'bvi-letter-spacing', 'invalid-bvi-letter-spacing', 'Неправильное значение для поля (Межбуквенный интервал).' );
		}

		if ( $input['bvi_line_height'] == 'normal' || $input['bvi_line_height'] == 'average' || $input['bvi_line_height'] == 'big' ) {
			$output['bvi_line_height'] = $input['bvi_line_height'];
		} else {
			add_settings_error( 'bvi-line-height', 'invalid-bvi-line-height', 'Неправильное значение для поля (Междустрочный интервал).' );
		}

		if ( $input['bvi_images'] == 1 || $input['bvi_images'] == 0 || $input['bvi_images'] == 'grayscale' ) {
			$output['bvi_images'] = $input['bvi_images'];
		} else {
			add_settings_error( 'bvi-images', 'invalid-bvi-images', 'Неправильное значение для поля (Адаптация изображений).' . $input['bvi_images'] );
		}

		if ( $input['bvi_reload'] == 1 || $input['bvi_reload'] == 0 ) {
			$output['bvi_reload'] = $input['bvi_reload'];
		} else {
			add_settings_error( 'bvi-reload', 'invalid-bvi-reload', 'Неправильное значение для поля (Включить перезагрузку страницы).' );
		}

		if ( ( $input['bvi_tts'] == 1 || $input['bvi_tts'] == 0 ) ) {
			$output['bvi_tts'] = $input['bvi_tts'];
		} else {
			add_settings_error( 'bvi-tts', 'invalid-bvi-tts', 'Неправильное значение для поля (Включить синтез речи).' );
		}

		if ( $input['bvi_script_location'] == 1 || $input['bvi_script_location'] == 0 ) {
			$output['bvi_script_location'] = $input['bvi_script_location'];
		} else {
			add_settings_error( 'bvi-script-location', 'invalid-bvi-script-location', 'Неправильное значение для поля (Выберите источник / местоположение скрипта и таблиц стилей плагина)' );
		}

		if ( $input['bvi_flash_iframe'] == 1 || $input['bvi_flash_iframe'] == 0 ) {
			$output['bvi_flash_iframe'] = $input['bvi_flash_iframe'];
		} else {
			add_settings_error( 'bvi-flash-iframe', 'invalid-bvi-flash-iframe', 'Неправильное значение для поля (Включить встроенные элементы).' );
		}

		if ( $input['bvi_hide'] == 1 || $input['bvi_hide'] == 0 ) {
			$output['bvi_hide'] = $input['bvi_hide'];
		} else {
			add_settings_error( 'bvi-hide', 'invalid-bvi-hide', 'Неправильное значение для поля (Скрыть панель настроек плагина).' );
		}

		if ( $input['bvi_fixed'] == 1 || $input['bvi_fixed'] == 0 ) {
			$output['bvi_fixed'] = $input['bvi_fixed'];
		} else {
			add_settings_error( 'bvi-fixed', 'invalid-bvi-fixed', 'Неправильное значение для поля (Зафиксировать панель настроек плагина в верхней части страницы.).' );
		}

		if ( ! empty( $input['bvi_link_text'] ) ) {
			$output['bvi_link_text'] = $input['bvi_link_text'];
		} else {
			add_settings_error( 'bvi-link-text', 'invalid-bvi-link-text', 'Текст виджета ссылки пустое значение.' );
		}

		if ( preg_match( '/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/', $input['bvi_link_color'] ) ) {
			$output['bvi_link_color'] = $input['bvi_link_color'];
		} else {
			add_settings_error( 'bvi-link-color', 'invalid-bvi-link-color', 'Неправильное значение для поля (Цвет ссылки для переключения версии сайта).' );
		}

		if ( preg_match( '/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/', $input['bvi_link_bg'] ) ) {
			$output['bvi_link_bg'] = $input['bvi_link_bg'];
		} else {
			add_settings_error( 'bvi-link-bg', 'invalid-bvi-link-bg', 'Неправильное значение для поля (Фон ссылки для переключения версии сайта).' );
		}

		return $output;
	}

	/**
	 * Сброс настроек
	 *
	 * @param $input
	 *
	 * @return array
	 */
	public function bvi_reset_validate_option( $input ) {
		if ( isset( $_POST['bvi-reset'] ) ) {
			add_settings_error( 'bvi-reset-setting', 'bvi-reset-setting', 'Ваши настройки были изменены по умолчанию.', 'updated' );

			return $input = $this->settings_default();
		}

		return $input;
	}

	/**
	 * Страница администратора
	 */
	public function bvi_settings_page() {
		if ( current_user_can( 'administrator' ) ) {
			if ( file_exists( BVI_PLUGIN_DIR_PAGES . 'admin.php' ) ) {
				include_once BVI_PLUGIN_DIR_PAGES . 'admin.php';
			}
		}
	}
}

/*
 *  Виджет
 */

class Bvi_Widget extends WP_Widget {
	public $bvi_option;

	function __construct() {
		$this->bvi_option = get_option( 'bvi_database' );

		parent::__construct( 'Bvi_Widget', 'Button visually impaired' );
	}

	function widget( $args, $instance ) {
		$title                     = apply_filters( 'widget_title', $instance['title'] );
		$instance['bvi_link_text'] = ( ! empty( $new_instance['bvi_link_text'] ) ) ? strip_tags( $new_instance['bvi_link_text'] ) : strip_tags( $this->bvi_option['bvi_link_text'] );
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		echo '<a href="#" class="bvi-link-widget bvi-open"><svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="bvi-svg-eye"><path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z" class=""></path></svg> ' . $instance['bvi_link_text'] . '</a>';
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance                          = $old_instance;
		$instance                          = $new_instance;
		$instance['title']                 = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['bvi_link_text']         = ( ! empty( $new_instance['bvi_link_text'] ) ) ? strip_tags( $new_instance['bvi_link_text'] ) : strip_tags( $this->bvi_option['bvi_link_text'] );
		$this->bvi_option['bvi_link_text'] = esc_attr( $instance['bvi_link_text'] );
		update_option( 'bvi_database', $this->bvi_option );

		return $instance;
	}

	function form( $instance ) {
		$title         = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$bvi_link_text = ! empty( $instance['bvi_link_text'] ) ? $instance['bvi_link_text'] : $this->bvi_option['bvi_link_text'];

		echo '<p><label for="' . $this->get_field_id( "title" ) . '">Заголовок: <input class="widefat" id="' . $this->get_field_id( "title" ) . '" name="' . $this->get_field_name( "title" ) . '" type="text" value="' . esc_attr( $title ) . '"></label></p>';
		echo '<p><label for="' . $this->get_field_id( "title" ) . '">Текс ссылки: <input class="widefat" id="' . $this->get_field_id( "bvi_link_text" ) . '" name="' . $this->get_field_name( "bvi_link_text" ) . '" type="text" value="' . esc_attr( $bvi_link_text ) . '"></label></p>';
		echo '<p><a href="/wp-admin/admin.php?page=bvi#bvi-link-color" class="page-title-action">Изменить цвет ссылки</a></p>';
	}
}

$bvi_plugin = new bvi_plugin();

if ( $bvi_plugin->get_option['bvi_active'] == 1 ) {
	function register_bvi_widget() {
		register_widget( 'Bvi_Widget' );
	}

	add_action( 'widgets_init', 'register_bvi_widget' );
}