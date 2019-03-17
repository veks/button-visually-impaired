<?php
/**
 * Button visually impaired
 * Plugin Name: Button visually impaired
 * Plugin URI: http://www.bvi.isvek.ru/
 * Description: Версия плагина для слабовидящих.
 * Version: 1.0.7
 * Author: Vek
 * Author URI: http://www.bvi.isvek.ru/vek
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

class bvi_isvek
{
	/**
	 * @var string
	 */
    public $plugin_name = 'Button visually impaired';

	/**
	 * @var string
	 */
    public $ver = '1.0.7';

	/**
	 * @var
	 */
    public $get_option;

    public $theme;

    public function __construct()
    {
        $this->get_option = get_option('bvi_database');

        add_action('wp_ajax_settings_save', array($this, 'settings_save'), 10, 0);
        add_action('wp_ajax_settings_reset', array($this, 'settings_reset'), 10, 0);

        add_action('plugins_loaded', array(&$this, 'constants'), 10, 0);
        add_action('admin_menu', array(&$this, 'add_plugin_menu'), 10, 0);

        if ((bool) $this->get_option['bvi_active'] == true)
        {
	        show_admin_bar(false);
            add_action('wp_enqueue_scripts', array(&$this, 'scripts'), 9999, 0);
            add_shortcode('bvi', array(&$this, 'shortcode'), 10, 0);
        }

        register_activation_hook( __FILE__, array($this, 'activation_plugin'));
    }

	/**
	 * @param      $atts
	 * @param null $content
	 *
	 * @return string
	 */
    public function shortcode($atts, $content = null)
    {
        if (!empty($atts['text']))
        {
            extract(shortcode_atts(array(
            	'bvi_text'=> $atts['text']
            ),$atts));
        }
        else
        {
            $bvi_text = null;
        }

        return '<div class="bvi-button"><a href="#" class="bvi-open">'.$bvi_text.'</a></div>';
    }

	/**
	 *
	 */
    public function constants()
    {
	    define('BVI_PLUGIN_DIR', plugin_dir_path(__FILE__));
	    define('BVI_PLUGIN_URL', plugin_dir_url(__FILE__));
	    define('BVI_PLUGIN_DIR_PAGES', BVI_PLUGIN_DIR . 'pages/');
	    define('BVI_PLUGIN_URL_CSS', BVI_PLUGIN_URL . 'assets/css/');
	    define('BVI_PLUGIN_URL_JS', BVI_PLUGIN_URL . 'assets/js/');
	    define('BVI_PLUGIN_URL_IMG', BVI_PLUGIN_URL . 'assets/img/');
    }

	/**
	 *
	 */
    public function admin_scripts()
    {
        wp_register_script('bvi-bootstrap-notify', BVI_PLUGIN_URL_JS . 'bootstrap-notify.min.js', array('jquery'), '3.0.0', true);
        wp_enqueue_script('bvi-bootstrap-notify');

        wp_register_script('bvi-bootstrap', BVI_PLUGIN_URL_JS . 'bootstrap.min.js', array('jquery'), '4.3.1', true);
        wp_enqueue_script('bvi-bootstrap');

        wp_register_script('bvi-admin-js', BVI_PLUGIN_URL_JS.'bvi-admin.min.js', array('jquery'), $this->ver, true);
        wp_localize_script('bvi-admin-js', 'bvi', array('ajaxurl'=> admin_url('admin-ajax.php')));
        wp_enqueue_script('bvi-admin-js');

        wp_enqueue_style( 'wp-color-picker' );

        wp_register_style('bvi-bootstrap', BVI_PLUGIN_URL_CSS.'bootstrap.min.css', '', $this->ver);
        wp_enqueue_style('bvi-bootstrap');

        wp_register_style('bvi-admin', BVI_PLUGIN_URL_CSS.'bvi-admin.min.css', '', $this->ver);
        wp_enqueue_style('bvi-admin');
    }

	/**
	 *
	 */
    public function scripts()
    {
        /*
         * CSS
         */
        wp_register_style('bvi', BVI_PLUGIN_URL_CSS . 'bvi.min.css', '1.0.7', $this->ver);
        wp_enqueue_style('bvi');

        wp_register_style('bvi-ie-9', BVI_PLUGIN_URL_CSS . 'bootstrap-ie9.min.css', '4.2.1', $this->ver);
        wp_style_add_data('bvi-ie-9', 'conditional', 'if lt IE 9');
        wp_enqueue_style('bvi-ie-9');

        wp_register_style('bvi-ie-8', BVI_PLUGIN_URL_CSS . 'bootstrap-ie8.min.css', '4.2.1', $this->ver);
        wp_style_add_data('bvi-ie-8', 'conditional', 'if lt IE 8');
        wp_enqueue_style('bvi-ie-8');

        wp_register_style('bvi-fontawesome', BVI_PLUGIN_URL_CSS . 'all.min.css', '5.1.1', $this->ver);
        wp_enqueue_style('bvi-fontawesome');
        /*
         * JS
         */
        wp_enqueue_script('jquery');

        wp_register_script('bvi-responsivevoice-js', BVI_PLUGIN_URL_JS . 'responsivevoice.min.js', array('jquery'), '1.5.12', $this->no_work());
        wp_enqueue_script('bvi-responsivevoice-js');

        wp_register_script('bvi-cookie', BVI_PLUGIN_URL_JS . 'js.cookie.min.js', array('jquery'), '2.2.0', $this->no_work());
        wp_enqueue_script('bvi-cookie');

        wp_register_script('bvi-init', BVI_PLUGIN_URL_JS . 'bvi-init.js', array('jquery'), $this->ver, $this->no_work());
        wp_localize_script('bvi-init', 'bvi_init', array('bvi_init_setting' => array(
            'bvi_theme'          => $this->get_option['bvi_theme'],
            'bvi_font'           => $this->get_option['bvi_font'],
            'bvi_font_size'      => (int) $this->get_option['bvi_font_size'],
            'bvi_letter_spacing' => $this->get_option['bvi_letter_spacing'],
            'bvi_line_height'    => $this->get_option['bvi_line_height'],
            'bvi_images'         => $this->get_option['bvi_images'],
            'bvi_reload'         => $this->get_option['bvi_reload'],
            'bvi_fixed'          => $this->get_option['bvi_fixed'],
            'bvi_voice'          => $this->get_option['bvi_voice'],
            'bvi_flash_iframe'   => $this->get_option['bvi_flash_iframe'],
            'bvi_hide'           => $this->get_option['bvi_hide']
        )));
        wp_enqueue_script('bvi-init');

        wp_register_script('bvi-js', BVI_PLUGIN_URL_JS . 'bvi.min.js', array('jquery'), $this->ver, $this->no_work());
        wp_enqueue_script('bvi-js');
    }

	/**
	 *
	 */
    public function add_plugin_menu()
    {
        if (function_exists('add_menu_page')){
            $admin_menu = add_menu_page(
                __("Плагин для слабовидящих bvi v{$this->ver}", 'bvi_language'),
                "bvi v{$this->ver}",
                'administrator',
                'bvi',
                array (&$this, 'settings_page'),
                'dashicons-visibility'
            );

            add_action("admin_print_scripts-{$admin_menu}",array($this,'admin_scripts'));
            add_action("admin_print_scripts-{$admin_menu}",array($this,'admin_scripts'));
            add_action('load-'.$admin_menu, array($this,'plugin_menu_help_tab'));
        }
    }

	/**
	 *
	 */
    public function plugin_menu_help_tab()
    {
        global $admin_menu;
        $screen = get_current_screen();

        if ($screen->id != $admin_menu)

        $screen->add_help_tab(array(
                'id' => 'contact_help_tab2',
                'title' => 'Дополнительная информация',
                'content' => '<p>Дополнительная информация находится по адресу <a href="http://bvi.isvek.ru/" target="_blank">http://bvi.isvek.ru/</a></p>'
            ));

        $screen->add_help_tab(array(
            'id'  => 'contact_help_tab1',
            'title' => 'Контакты',
            'content' => '<p>По всем вопросам пишите на почту <a href="mailto:bvi@isvek.ru" title="bvi@isvek.ru">bvi@isvek.ru</a> или воспользуйтесь <a href="http://bvi.isvek.ru/feedback" target="_blank">формой обратной связи</a></p>'
        ));
    }

	/**
	 * @return bool
	 */
    public function no_work()
    {
        if ($this->get_option['bvi_not_work'] == false)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

	/**
	 *
	 */
    public function activation_plugin()
    {
        if (current_user_can('administrator'))
        {
            if (get_option('database_bvi') !== false)
            {
                delete_option('database_bvi');
            }
            else
            {
                $db = self::settings_default();
                add_option('bvi_database', $db);
            }
        }
    }

	/**
	 *
	 */
    public function settings_page()
    {
        if (current_user_can('administrator'))
        {
            if(file_exists(BVI_PLUGIN_DIR_PAGES . 'admin.php'))
            {
                require_once (BVI_PLUGIN_DIR_PAGES . 'admin.php');
            }
            else
            {
                echo '<div class="wrap"><h1>'.__('Страница не найдена', 'bvi_language').'</h1></div>';
            }
        }
    }

	/**
	 *
	 */
    public function settings_save()
    {
        if (current_user_can('administrator'))
        {
            if (!empty($_POST) && check_admin_referer('settings_save', 'settings_save'))
            {
                if (get_option('bvi_database') !== false)
                {
                    $param  = array(
                        'bvi_active'         => esc_attr($_POST['bvi_active']),
                        'bvi_not_work'       => esc_attr($_POST['bvi_not_work']),
                        'bvi_theme'          => esc_attr($_POST['bvi_theme']),
                        'bvi_font'           => esc_attr($_POST['bvi_font']),
                        'bvi_font_size'      => esc_attr($_POST['bvi_font_size']),
                        'bvi_letter_spacing' => esc_attr($_POST['bvi_letter_spacing']),
                        'bvi_line_height'    => esc_attr($_POST['bvi_line_height']),
                        'bvi_images'         => esc_attr($_POST['bvi_images']),
                        'bvi_reload'         => esc_attr($_POST['bvi_reload']),
                        'bvi_voice'          => esc_attr($_POST['bvi_voice']),
                        'bvi_flash_iframe'   => esc_attr($_POST['bvi_flash_iframe']),
                        'bvi_hide'           => esc_attr($_POST['bvi_hide']),
                        'bvi_fixed'          => esc_attr($_POST['bvi_fixed'])
                    );

                    $result = $this->wp_error_form($param);

                    if (is_wp_error($result))
                    {
                        wp_send_json(array("msg" => $result->get_error_messages(), "type" => "danger"));
                    }
                    else
                    {
                        if (get_option('bvi_database') !== false)
                        {
                            if ($_POST['bvi_images'] === 'grayscale')
                            {
                                $bvi_image = 'grayscale';
                            }
                            else
                            {
                                $bvi_image = filter_var(esc_attr($_POST['bvi_images']), FILTER_VALIDATE_BOOLEAN);
                            }
                            $params  = array(
                                'bvi_active'         => filter_var(esc_attr($_POST['bvi_active']), FILTER_VALIDATE_BOOLEAN),
                                'bvi_not_work'       => filter_var(esc_attr($_POST['bvi_not_work']), FILTER_VALIDATE_BOOLEAN),
                                'bvi_theme'          => (string) esc_attr($_POST['bvi_theme']),
                                'bvi_font'           => (string) esc_attr($_POST['bvi_font']),
                                'bvi_font_size'      => (int) esc_attr($_POST['bvi_font_size']),
                                'bvi_letter_spacing' => (string) esc_attr($_POST['bvi_letter_spacing']),
                                'bvi_line_height'    => (string) esc_attr($_POST['bvi_line_height']),
                                'bvi_images'         => $bvi_image,
                                'bvi_reload'         => filter_var(esc_attr($_POST['bvi_reload']), FILTER_VALIDATE_BOOLEAN),
                                'bvi_voice'          => filter_var(esc_attr($_POST['bvi_voice']), FILTER_VALIDATE_BOOLEAN),
                                'bvi_flash_iframe'   => filter_var(esc_attr($_POST['bvi_flash_iframe']), FILTER_VALIDATE_BOOLEAN),
                                'bvi_hide'           => filter_var(esc_attr($_POST['bvi_hide']), FILTER_VALIDATE_BOOLEAN),
                                'bvi_fixed'          => filter_var(esc_attr($_POST['bvi_fixed']), FILTER_VALIDATE_BOOLEAN)
                            );

                            update_option('bvi_database', $params, true);

                            wp_send_json(array("msg" => "Настройки сохранены", "type" => "success"));
                        }
                        else
                        {
                            wp_send_json(array("msg" => "Ошибка базы данных", "type" => "danger"));
                        }
                    }
                }
                else
                {
                    $db = self::settings_default();
                    add_option('bvi_database', $db);
                    wp_send_json(array("msg" => "Обновление базы данных", "type" => "info"));
                }
            }
        }
        else
        {
            wp_send_json(array("msg" => "Ошибка доступа", "type" => "danger"));
        }
    }

	/**
	 * @param $param
	 *
	 * @return WP_Error
	 */
    public function wp_error_form($param)
    {
        $errors = new WP_Error();

        if ($param['bvi_active'] != false && $param['bvi_active'] != true)
        {
            $errors->add('bvi_active', "Неправильное значение <code>{$param['bvi_active']}</code> для поля 'Включить плагин?'");
        }

        if ((string)$param['bvi_theme'] != 'white' && (string)$param['bvi_theme'] != 'black' && (string)$param['bvi_theme'] != 'blue' && (string)$param['bvi_theme'] != 'brown' && $param['bvi_theme'] != (string)'green')
        {
            $errors->add('bvi_theme', "Неправильное значение <code>{$param['bvi_theme']}</code> для поля 'Цвета сайта'");
        }

        if (!preg_match("/^[0-4]?[0-9]$/", (int)$param['bvi_font_size']))
        {
            $errors->add('bvi_font_size', "Неправильное значение <code>'{$param['bvi_font_size']}'</code> для поля 'Размер шрифта'");
        }

        if ((string)$param['bvi_font'] != 'arial' && (string)$param['bvi_font'] != 'times')
        {
            $errors->add('bvi_font', "Неправильное значение <code>{$param['bvi_font']}</code> для поля 'Шрифт'");
        }

        if ((string)$param['bvi_letter_spacing'] != 'normal' && (string)$param['bvi_letter_spacing'] != 'average' && (string)$param['bvi_letter_spacing'] != 'big')
        {
            $errors->add('bvi_letter_spacing', "Неправильное значение <code>{$param['bvi_letter_spacing']}</code> для поля 'Межбуквенный интервал'");
        }

        if ((string)$param['bvi_line_height'] != 'normal' && (string)$param['bvi_line_height'] != 'average' && (string)$param['bvi_line_height'] != 'big')
        {
            $errors->add('bvi_line_height', "Неправильное значение <code>{$param['bvi_line_height']}</code> для поля 'Междустрочный интервал'");
        }

        if((string)$param['bvi_images'] != 'grayscale' && $param['bvi_images'] != true && $param['bvi_images'] != false)
        {
            $errors->add('bvi_images', "Неправильное значение <code>{$param['bvi_images']}</code> для поля 'Изображения'");
        }

        if ($param['bvi_fixed'] != true && $param['bvi_fixed'] != false)
        {
            $errors->add('bvi_fixed', "Неправильное значение <code>{$param['bvi_fixed']}</code> для поля 'Зафиксировать панель настроек вверху страницы'");
        }

        if ($param['bvi_reload'] != true && $param['bvi_reload'] != false)
        {
            $errors->add('bvi_reload', "Неправильное значение <code>{$param['bvi_reload']}</code> для поля 'Перезагрузка страницы'");
        }

        if ($param['bvi_flash_iframe'] != true && $param['bvi_flash_iframe'] != false)
        {
            $errors->add('bvi_flash_iframe', "Неправильное значение <code>{$param['bvi_flash_iframe']}</code> для поля 'iframe'");
        }

        if ($param['bvi_hide'] != true && $param['bvi_hide'] != false)
        {
            $errors->add('bvi_hide', "Неправильное значение <code>{$param['bvi_hide']}</code> для поля 'Скрыть панель для славбовидящих'");
        }

        if ($param['bvi_voice'] != true && $param['bvi_voice'] != false)
        {
            $errors->add('bvi_voice', "Неправильное значение <code>{$param['bvi_voice']}</code> для поля 'Синтез речи'");
        }

        $err = $errors->get_error_codes();

        if (!empty($err))
        {
            return $errors;
        }
    }

	/**
	 *
	 */
    public function settings_reset()
    {
        if (current_user_can('administrator'))
        {
            if (!empty($_POST) && check_admin_referer('settings_reset', 'settings_reset'))
            {
                update_option('bvi_database', $this->settings_default(), true);
                wp_send_json(array("msg" =>"Настройки сброшены", "type" => "info"));
            }
        }
        else
        {
            wp_send_json(array("msg" => "error administrator", "type" => "danger"));
        }
    }

	/**
	 * @return array
	 */
    public function settings_default()
    {
        $SettingsDefaultDataBase = array(
            'bvi_active'         => false,
            'bvi_not_work'       => false,
            'bvi_theme'          => 'white',
            'bvi_font'           => 'arial',
            'bvi_font_size'      =>  16,
            'bvi_letter_spacing' => 'normal',
            'bvi_line_height'    => 'normal',
            'bvi_images'         => true,
            'bvi_reload'         => false,
            'bvi_voice'          => true,
            'bvi_flash_iframe'   => true,
            'bvi_hide'           => false,
            'bvi_fixed'          => true
        );
        return $SettingsDefaultDataBase;
    }

    function check_active($active, $param)
    {
        if ($active === $param)
        {
            echo 'active';
        }
    }
}
$Bvi = new bvi_isvek();

class Bvi_Widget extends WP_Widget
{
    function __construct()
    {
        parent::__construct('Bvi_Widget', 'Версия для слабовидящих');
    }

    function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        echo $args['before_widget'];
        if (!empty($title))
        {
            echo $args['before_title'].$title.$args['after_title'];
        }
        echo $this->template_button();
        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance = $new_instance;
        $instance['title'] = (!empty( $new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

    function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : 'Версия для слабовидящих';
        echo '<p><input class="widefat" id="'.$this->get_field_id("title").'" name="'.$this->get_field_name("title").'" type="text" value="'.esc_attr($title).'"></p>';
    }

    public function template_button()
    {
        return '<div><a href="#" class="bvi-open">Версия сайта для слабовидящих</a></div>';
    }
}
$BviPanel = get_option('bvi_database');

if ($BviPanel['bvi_active'] === true)
{
    function register_foo_widget()
    {
        register_widget( 'Bvi_Widget' );
    }

    add_action('widgets_init', 'register_foo_widget');
}


