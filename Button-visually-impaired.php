<?php
/**
 * Button visually impaired
 * Plugin Name: Button visually impaired
 * Plugin URI: http://www.bvi.isvek.ru/
 * Description: Версия плагина для слабовидящих.
 * Version: 1.0.5
 * Author: Vek
 * Author URI: http://www.bvi.isvek.ru/vek
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

class ButtonVisuallyImpaired
{
    public $plugin_name = 'Button visually impaired';
    public $ver = '1.0.5';
    public $get_option;

    public function __construct()
    {
        $this->get_option = get_option('database_bvi');

        add_action('wp_ajax_settings_save', array($this, 'settings_save'), 10, 0);
        add_action('wp_ajax_settings_reset', array($this, 'settings_reset'), 10, 0);
        add_action('plugins_loaded', array(&$this, 'constants'), 10, 0);
        /*
        add_action('plugins_loaded',array($this, 'languages'), 10, 0);
        */
        add_action('admin_menu', array(&$this, 'add_plugin_menu'), 10, 0);

        if ($this->get_option['BviPanel'] == '1')
        {
            add_action('wp_enqueue_scripts', array(&$this, 'scripts'), 10, 0);
            add_action('wp_enqueue_scripts', array(&$this, 'css'), 10, 0);

            add_shortcode('bvi', array(&$this, 'shortcode'), 10, 0);
            add_filter('widget_text', 'do_shortcode');
        }

        register_activation_hook( __FILE__, array($this, 'activation_plugin'));
    }

    /*
    public function languages() {
        load_plugin_textdomain( 'bvi_languages', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }
    */

    public function shortcode($atts, $content = null)
    {
        if (!empty($atts['text']))
        {
            extract(shortcode_atts(array(
                'bvi_text'     => $atts['text']
            ), $atts));
        }
        else
        {
            $bvi_text = null;
        }

        return '<div class="bvi-button"><a href="#" class="bvi-panel-open"><span class="bvi-glyphicon bvi-glyphicon-eye"></span> '.$bvi_text.'</a></div>';
    }

    public function constants()
    {
        define('BVI_PLUGIN_DIR', plugin_dir_path(__FILE__));
        define('BVI_PLUGIN_URL', plugin_dir_url(__FILE__));
        define('BVI_PLUGIN_ADMIN', BVI_PLUGIN_DIR.'assets/pages/');
        define('BVI_PLUGIN_CSS', BVI_PLUGIN_URL.'assets/css/');
        define('BVI_PLUGIN_JS', BVI_PLUGIN_URL.'assets/js/');
        define('BVI_PLUGIN_IMG', BVI_PLUGIN_URL.'assets/img/');
    }

    public function admin_scripts()
    {
        wp_register_script('bvi-bootstrap-notify', BVI_PLUGIN_JS.'bootstrap-notify.min.js', array('jquery'), '3.0.0', true);
        wp_enqueue_script('bvi-bootstrap-notify');

        wp_register_script('bvi-admin-js', BVI_PLUGIN_JS.'bvi-admin.min.js', array('jquery', 'wp-color-picker'), '0.1', true);
        wp_localize_script('bvi-admin-js', 'bvi', array('ajaxurl'=> admin_url('admin-ajax.php')));
        wp_enqueue_script('bvi-admin-js');
    }

    public function admin_css()
    {
        wp_enqueue_style( 'wp-color-picker' );

        wp_register_style('bvi-bootstrap', BVI_PLUGIN_CSS.'bootstrap.min.css', '', $this->ver);
        wp_enqueue_style('bvi-bootstrap');

        wp_register_style('bvi-admin', BVI_PLUGIN_CSS.'bvi-admin.min.css', '', $this->ver);
        wp_enqueue_style('bvi-admin');
    }

    public function scripts()
    {
        wp_enqueue_script('jquery');

        wp_register_script('responsivevoice',BVI_PLUGIN_JS.'responsivevoice.min.js', array('jquery'), '1.5.0', $this->no_work());
        wp_enqueue_script('responsivevoice');

        wp_register_script('bvi-panel',BVI_PLUGIN_JS.'bvi-init-panel.min.js', array('jquery'),'0.1', $this->no_work());
        wp_localize_script('bvi-panel', 'bvi', array(
            'BviPanel'              => $this->get_option['BviPanel'],
            'BviPanelBg'            => $this->get_option['BviPanelBg'],
            'BviPanelFontSize'      => $this->get_option['BviPanelFontSize'],
            'BviPanelLetterSpacing' => $this->get_option['BviPanelLetterSpacing'],
            'BviPanelLineHeight'    => $this->get_option['BviPanelLineHeight'],
            'BviPanelImg'           => $this->get_option['BviPanelImg'],
            'BviPanelImgXY'         => $this->get_option['BviPanelImgXY'],
            'BviPanelReload'        => $this->get_option['BviPanelReload'],
            'BviPanelText'          => $this->get_option['BviPanelText'],
            'BviPanelCloseText'     => $this->get_option['BviPanelCloseText'],
            'BviCloseClassAndId'    => $this->get_option['BviCloseClassAndId'],
            'BviFixPanel'           => $this->get_option['BviFixPanel'],
            'BviPlay'               => $this->get_option['BviPlay']
        ));
        wp_enqueue_script('bvi-panel');
        
        wp_register_script('bvi-js', BVI_PLUGIN_JS.'bvi.min.js', array('jquery'), $this->ver, $this->no_work());
        wp_enqueue_script('bvi-js');

        wp_register_script('bvi-cookie',BVI_PLUGIN_JS.'js.cookie.min.js', array('jquery'),'2.1.3', $this->no_work());
        wp_enqueue_script('bvi-cookie');
    }

    public function css()
    {
        wp_register_style('bvi-default', BVI_PLUGIN_CSS.'bvi.min.css','',$this->ver);
        wp_enqueue_style('bvi-default');

        $BviTextBg = $this->get_option['BviTextBg'];
        $BviTextColor = $this->get_option['BviTextColor'];
        $BviSizeText = $this->get_option['BviSizeText'];
        $BviSizeIcon = $this->get_option['BviSizeIcon'];
        $custom_css = "
        .bvi-button .bvi-panel-open {
            color: {$BviTextColor} !important;
        }
		.bvi-button a {
			background-color: {$BviTextBg};
			color: {$BviTextColor};
			border: 1px solid {$this->color($BviTextBg,-0.8)};
			border-radius: 2px;
			padding: 5px 10px;
			display: inline-block;
			font-size: {$BviSizeText}px;
			text-decoration: none;
			font-weight: 500;
			vertical-align: middle;
		}
		.bvi-button a:link {
		    color: {$BviTextColor};
		    text-decoration: none;
		}
		.bvi-button a:visited {
		    color: {$BviTextColor};
		    text-decoration: none;
		}
		.bvi-button a:hover {
			color: {$BviTextColor};
		    text-decoration: none;
		}
		.bvi-button a:active {
			color: {$BviTextColor};
		    text-decoration: none;
		}
		.bvi-glyphicon-eye {
		    font-size: {$BviSizeIcon}px;
		}
		";

        wp_add_inline_style( 'bvi-default', $custom_css );
    }

    private function color($hex, $percent) {
        // Work out if hash given
        $hash = '';
        if (stristr($hex,'#')) {
            $hex = str_replace('#','',$hex);
            $hash = '#';
        }
        /// HEX TO RGB
        $rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
        //// CALCULATE
        for ($i=0; $i<3; $i++) {
            // See if brighter or darker
            if ($percent > 0) {
                // Lighter
                $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
            } else {
                // Darker
                $positivePercent = $percent - ($percent*2);
                $rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
            }
            // In case rounding up causes us to go to 256
            if ($rgb[$i] > 255) {
                $rgb[$i] = 255;
            }
        }
        //// RBG to Hex
        $hex = '';
        for($i=0; $i < 3; $i++) {
            // Convert the decimal digit to hex
            $hexDigit = dechex($rgb[$i]);
            // Add a leading zero if necessary
            if(strlen($hexDigit) == 1) {
                $hexDigit = "0" . $hexDigit;
            }
            // Append to the hex string
            $hex .= $hexDigit;
        }
        return $hash.$hex;
    }

    public function add_plugin_menu()
    {
        if (function_exists('add_menu_page')){
            $admin_menu = add_menu_page(
                __("Плагин для слабовидящих bvi v{$this->ver}", 'bvi_languages'),
                "bvi v{$this->ver}",
                'administrator',
                'bvi',
                array (&$this, 'settings_page'),
                'dashicons-visibility'
            );
            add_action("admin_print_scripts-{$admin_menu}",array($this,'admin_scripts'));
            add_action("admin_print_scripts-{$admin_menu}",array($this,'admin_css'));
            add_action('load-'.$admin_menu, array($this,'plugin_menu_help_tab'));
        }
    }

    public function plugin_menu_help_tab()
    {
        global $admin_menu;
        $screen = get_current_screen();
        if ( $screen->id != $admin_menu )

        $screen->add_help_tab(
            array(
                'id' => 'contact_help_tab2',
                'title' => __('Документация', 'bvi_languages'),
                'content' => '<p>'.__('Дополнительная информация находится по адресу', 'bvi_languages').' <a href="http://bvi.isvek.ru/pages/install" target="_blank">http://bvi.isvek.ru/pages/install</a></p>'
            ));
        $screen->add_help_tab(array(
            'id'  => 'contact_help_tab1',
            'title' => __('Контакты', 'bvi_languages'),
            'content' => '<p>'.__('По всем вопросам пишите на почту', 'bvi_languages').' <a href="mailto:oleg@isvek.ru" title="oleg@isvek.ru">oleg@isvek.ru</a> '.__('или воспользуйтесь', 'bvi_languages').' <a href="http://bvi.isvek.ru/pages/contact" target="_blank">'.__('формой обратной связи', 'bvi_languages').'</a></p>'
        ));
    }

    public function no_work()
    {
        if ($this->get_option['BviPanelNoWork'] == 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function activation_plugin()
    {
        if (current_user_can('administrator'))
        {
            $db = self::settings_default();
            add_option('database_bvi',$db);
        }
    }

    public function settings_page()
    {
        if (current_user_can('administrator'))
        {
            if(file_exists(BVI_PLUGIN_ADMIN.'admin.php'))
            {
                require_once (BVI_PLUGIN_ADMIN.'admin.php');
            }
            else
            {
                echo '<div class="wrap"><h1>'.__('Страница не найдена', 'bvi_languages').'</h1></div>';
            }
        }
    }

    public function settings_save()
    {
        if (current_user_can('administrator'))
        {
            if (!empty($_POST) && check_admin_referer('settings_save','settings_save'))
            {
                $this->get_option['BviPanel']                      = esc_attr($_POST['BviPanel']);
                $this->get_option['BviPanelBg']                    = esc_attr($_POST['BviPanelBg']);
                $this->get_option['BviPanelFontSize']              = esc_attr($_POST['BviPanelFontSize']);
                $this->get_option['BviPanelLetterSpacing']         = esc_attr($_POST['BviPanelLetterSpacing']);
                $this->get_option['BviPanelLineHeight']            = esc_attr($_POST['BviPanelLineHeight']);
                $this->get_option['BviPanelImg']                   = esc_attr($_POST['BviPanelImg']);
                $this->get_option['BviPanelImgXY']                 = esc_attr($_POST['BviPanelImgXY']);
                $this->get_option['BviPanelReload']                = esc_attr($_POST['BviPanelReload']);
                $this->get_option['BviPanelNoWork']                = esc_attr($_POST['BviPanelNoWork']);
                $this->get_option['BviPanelText']                  = esc_attr($_POST['BviPanelText']);
                $this->get_option['BviPanelCloseText']             = esc_attr($_POST['BviPanelCloseText']);
                $this->get_option['BviCloseClassAndId']            = esc_attr($_POST['BviCloseClassAndId']);
                $this->get_option['BviFixPanel']                   = esc_attr(isset($_POST['BviFixPanel'])? 1 : 0);
                $this->get_option['BviTextBg']                     = esc_attr($_POST['BviTextBg']);
                $this->get_option['BviTextColor']                  = esc_attr($_POST['BviTextColor']);
                $this->get_option['BviSizeText']                   = esc_attr($_POST['BviSizeText']);
                $this->get_option['BviSizeIcon']                   = esc_attr($_POST['BviSizeIcon']);
                $this->get_option['BviPlay']                       = esc_attr($_POST['BviPlay']);

                update_option('database_bvi', $this->get_option);
                wp_send_json(array("msg" => __("Настройки сохранены", "bvi_languages"), "type" => "success"));
            }
        }
        else
        {
            wp_send_json(array("msg" => "error administrator", "type" => "danger"));
        }
    }

    public function settings_reset()
    {
        if (current_user_can('administrator'))
        {
            if (!empty($_POST) && check_admin_referer('settings_reset', 'settings_reset'))
            {
                update_option('database_bvi', $this->settings_default());
                wp_send_json(array("msg" => __("Настройки сброшены", "bvi_languages"), "type" => "info"));
            }
        }
        else
        {
            wp_send_json(array("msg" => "error administrator", "type" => "danger"));
        }
    }

    public function settings_default()
    {
        $SettingsDefaultDataBase = array(
            'BviPanel'                      => 0,
            'BviPanelBg'                    => 'white',
            'BviPanelFontSize'              => '12',
            'BviPanelLetterSpacing'         => 'normal',
            'BviPanelLineHeight'            => 'normal',
            'BviPanelImg'                   => 1,
            'BviPanelImgXY'                 => 1,
            'BviPanelReload'                => 0,
            'BviPanelNoWork'                => 0,
            'BviPanelText'                  => __('Версия для слабовидящих', 'bvi_languages'),
            'BviPanelCloseText'             => __('Обычная версия сайта', 'bvi_languages'),
            'BviFixPanel'                   => 1,
            'ver'                           => 'Button visually impaired version '.$this->ver,
            'BviCloseClassAndId'            => '.hide-screen-fixed',
            'BviTextBg'                     => '#e53935',
            'BviTextColor'                  => '#ffffff',
            'BviSizeText'                   => '14',
            'BviSizeIcon'                   => '20',
            'BviPlay'                       => 1
        );
        return $SettingsDefaultDataBase;
    }
}
$Bvi = new ButtonVisuallyImpaired();


class Bvi_Widget extends WP_Widget
{
    function Bvi_Widget()
    {
        parent::__construct(false, __('Версия для слабовидящих', 'bvi_languages'));
        add_action( 'load-widgets.php', array(&$this, 'load_widgets') );
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
        $db = get_option('database_bvi');

        $instance = $old_instance;
        $instance = $new_instance;
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['BviTextBg'] = $new_instance['BviTextBg'];
        $instance['BviTextColor'] = $new_instance['BviTextColor'];
        $db['BviTextBg'] = $instance['BviTextBg'];
        $db['BviTextColor'] = $instance['BviTextColor'];
        update_option('database_bvi',$db);
        return $instance;
    }

    function form($instance)
    {
        $db = get_option('database_bvi');
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __('Версия для слабовидящих', 'bvi_languages');
        echo '<p>
			<input class="widefat" id="'.$this->get_field_id( "title" ).'" name="'.$this->get_field_name( "title" ).'" type="text" value="'.esc_attr( $title ).'">
		</p>';
        echo'<b>'.__('Фон кнопки', 'bvi_languages').'</b><br><input id="BviTextBg" type="text" name="'.$this->get_field_name('BviTextBg').'" value="'. $db['BviTextBg'].'" class="color-picker" /><br>
             <b>'.__('Цвет текста кнопки иконки', 'bvi_languages').'</b><br><input id="BviTextColor" type="text" name="'.$this->get_field_name('BviTextColor').'" value="'. $db['BviTextColor'].'" class="color-picker" />';
         
    }

    function load_widgets()
    {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        wp_register_script('bvi-widget', BVI_PLUGIN_JS.'widget.js', array('jquery'), '3.0.0', true);
        wp_enqueue_script('bvi-widget');
    }

    public function template_button()
    {
        $template_button = get_option('database_bvi');

        if(!empty($template_button))
        {
            $text = $template_button['BviPanelText'];
        }
        else
        {
            $text = FALSE;
        }

        return '<div class="bvi-button" style="text-align: center;"><a href="#" class="bvi-panel-open" style="width: 100%"><span class="bvi-glyphicon bvi-glyphicon-eye"></span> '.$text.'</a></div>';
    }
}
$BviPanel = get_option('database_bvi');
if ($BviPanel['BviPanel'] == '1')
{
    function register_foo_widget() {
        register_widget( 'Bvi_Widget' );
    }
    add_action( 'widgets_init', 'register_foo_widget' );
}