<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

if ( !class_exists( '\HTMegaOpt\Admin\Options_Field'  ) ) {
    require_once HTMEGAOPT_INCLUDES . '/classes/Admin/Options_field.php';
}

class HTMega_Widgets_Control{

    private static $instance = null;
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct(){
        // Register custom categories (legacy + 2025)
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_category' ] );
        // Init legacy widgets
        add_action( 'elementor/widgets/register', [ $this, 'init_widgets' ] );
        // Init HT Mega 2025 widgets (new architecture)
        add_action( 'elementor/widgets/register', [ $this, 'init_widgets_2025' ] );
        // Enqueue 2025 widget assets: editor admin panel + editor preview iframe.
        // Frontend (non-editing) loading is handled by the CSS combine system in class.assests-cache.php.
        add_action( 'elementor/editor/after_enqueue_styles',   [ $this, 'enqueue_2025_assets' ] );
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_2025_editor_preview' ] );

        // Add custom control
        add_action( 'elementor/controls/register', [ $this, 'initiliaze_custom_control' ] );

    }

    public function initiliaze_custom_control($controls_manager){
        if ( file_exists( HTMEGA_ADDONS_PL_PATH.'admin/include/custom-control/preset-select.php' ) ) {
            $controls_manager->register( new \HtMega\Preset\Preset_Select());
        }
    }
    // Add custom categories.
    public function add_category( $elements_manager ) {
        // Legacy category
        $elements_manager->add_category(
            'htmega-addons',
            [
                'title' => __( 'HTMega Addons', 'ht-mega-for-elementor' ),
                'icon'  => 'fa fa-snowflake',
            ]
        );
        // 2026 Collection category (new widgets)
        $elements_manager->add_category(
            'htmega-2026',
            [
                'title' => __( 'HT Mega 2026', 'ht-mega-for-elementor' ),
                'icon'  => 'eicon-apps',
            ]
        );
    }

    /**
     * Register HT Mega 2025 widgets.
     * These use a separate file naming convention (htmega_2025_*.php)
     * and always-on registration (no settings panel toggle needed until
     * they are promoted to the main widget list).
     */
    public function init_widgets_2025() {
        if ( ! did_action( 'elementor/loaded' ) ) {
            return;
        }

        // NOTE: File names keep the htmega_2025_ prefix (internal convention).
        // Only user-facing labels say "2026". Next year: bump labels to 2027, files unchanged.
        $widgets_2025 = [
            'hero' => 'HTMega_Elementor_Widget_Hero_2025',
            // Add more 2026 widgets here as they are built:
            'about'        => 'HTMega_Elementor_Widget_About_2025',
            'services'     => 'HTMega_Elementor_Widget_Services_2025',
            'pricing'      => 'HTMega_Elementor_Widget_Pricing_2025',
            'testimonials' => 'HTMega_Elementor_Widget_Testimonials_2025',
            'stats'        => 'HTMega_Elementor_Widget_Stats_2025',
            'cta'          => 'HTMega_Elementor_Widget_CTA_2025',
            'team'         => 'HTMega_Elementor_Widget_Team_2025',
            'faq'          => 'HTMega_Elementor_Widget_FAQ_2025',
            'blog'         => 'HTMega_Elementor_Widget_Blog_2025',
            'contact'      => 'HTMega_Elementor_Widget_Contact_2025',
        ];

        $widgets_manager = \Elementor\Plugin::instance()->widgets_manager;

        foreach ( $widgets_2025 as $slug => $class_name ) {
            if ( 'on' !== htmega_get_option( $slug, 'htmega_sections_element_tabs', 'on' ) ) {
                continue;
            }
            $file = HTMEGA_ADDONS_PL_PATH . 'includes/widgets/htmega_2025_' . $slug . '.php';
            if ( ! file_exists( $file ) ) {
                continue;
            }
            require_once $file;
            $fqn = '\\Elementor\\' . $class_name;
            if ( ! class_exists( $fqn ) ) {
                continue;
            }
            if ( htmega_is_elementor_version( '>=', '3.5.0' ) ) {
                $widgets_manager->register( new $fqn() );
            } else {
                $widgets_manager->register_widget_type( new $fqn() );
            }
        }
    }

    /**
     * Enqueue 2025 CSS token file + per-widget styles.
     * Runs on both frontend and Elementor editor.
     */
    public function enqueue_2025_assets() {
        $css_path = HTMEGA_ADDONS_PL_PATH . 'assets/css/';
        $css_url  = HTMEGA_ADDONS_PL_URL  . 'assets/css/';
        $base_ver = defined( 'HTMEGA_VERSION' ) ? HTMEGA_VERSION : '1.0.0';

        // Version helper: append the file's modified time so any CSS edit
        // automatically busts the browser/Elementor cache.
        $file_ver = function ( $file ) use ( $base_ver ) {
            return file_exists( $file ) ? $base_ver . '.' . filemtime( $file ) : $base_ver;
        };

        // 1. Token system (always loaded — tiny file, needed by all 2025 widgets)
        wp_enqueue_style(
            'htm25-tokens',
            $css_url . 'htm25-tokens.css',
            [],
            $file_ver( $css_path . 'htm25-tokens.css' )
        );

        // 2. Per-widget styles (only load if the widget's file exists)
        $widget_styles = [
            'hero' => 'htm25-hero',
            'about'        => 'htm25-about',
            'services'     => 'htm25-services',
            'pricing'      => 'htm25-pricing',
            'testimonials' => 'htm25-testimonials',
            'stats'        => 'htm25-stats',
            'cta'          => 'htm25-cta',
            'team'         => 'htm25-team',
            'faq'          => 'htm25-faq',
            'blog'         => 'htm25-blog',
            'contact'      => 'htm25-contact',
        ];

        foreach ( $widget_styles as $slug => $handle ) {
            if ( 'on' !== htmega_get_option( $slug, 'htmega_sections_element_tabs', 'on' ) ) {
                continue;
            }
            $widget_file = $css_path . 'widgets/htmega_2025_' . $slug . '.php';
            $css_file    = $css_path . 'widgets/' . $handle . '.css';

            if ( file_exists( $css_file ) ) {
                wp_enqueue_style(
                    $handle,
                    $css_url . 'widgets/' . $handle . '.css',
                    [ 'htm25-tokens' ],
                    $file_ver( $css_file )
                );
            }
        }
    }

    public function enqueue_2025_editor_preview() {
        // The Elementor editor preview iframe fires elementor/frontend/after_enqueue_styles.
        // The CSS combine system skips editing mode, so load all 2025 styles explicitly here.
        if ( function_exists( 'htmega_is_editing_mode' ) && htmega_is_editing_mode() ) {
            $this->enqueue_2025_assets();
        }
    }

    public function init_widgets(){
        // Only check if Elementor is loaded
        if (!did_action('elementor/loaded')) {
            return;
        }

        // Check maintenance mode
        if (!is_admin()) {
            $maintenance_mode = get_option('elementor_maintenance_mode_mode');
            if ($maintenance_mode && $maintenance_mode !== 'disabled' && !\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                if (!current_user_can('edit_posts')) {
                    return;
                }
            }
        }
        $widget_list = $this->get_widget_list();
        $widgets_manager = \Elementor\Plugin::instance()->widgets_manager;
        //Get registered settings
        $settings  = \HTMegaOpt\Admin\Options_Field::instance()->get_registered_settings();

        foreach($widget_list as $option_key => $option){

            $option_tab = $option['option-tab'];
            
            $settings_ids = array_column($settings[$option_tab], 'default','id');
            $default_status =  ( array_key_exists($option_key, $settings_ids) ) ? $settings_ids[$option_key] : 'on';

            $widget_path = $option['is_pro'] ? HTMEGA_ADDONS_PL_PATH_PRO : HTMEGA_ADDONS_PL_PATH;

            if(strpos($option['title'], ' ') !== false){
                $widget_file_name = strtolower(str_replace(' ', '_', $option['title']));
                $widget_class = $option['is_pro'] ? 'HTMegaPro\Elementor\Widget\HTMega_'. str_replace(' ', '_', $option['title']).'_Element' : "\Elementor\HTMega_Elementor_Widget_" . str_replace(' ', '_', $option['title']);
            }else{
                $widget_file_name = strtolower($option['title']);
                $widget_class =$option['is_pro'] ? 'HTMegaPro\Elementor\Widget\HTMega_'. $option['title'] .'_Element' : "\Elementor\HTMega_Elementor_Widget_" . $option['title'];
            }
           
            if(isset($option['third-party-resource'])){
                $widget_status = is_plugin_active($option['third-party-resource']) && ( htmega_get_option( $option_key, $option['option-tab'], $default_status ) === 'on' ) && file_exists( $widget_path.'includes/widgets/htmega_'.$widget_file_name.'.php' ) ? true : false ;
            }else{
                $widget_status = ( htmega_get_option( $option_key, $option['option-tab'], $default_status ) === 'on' ) && file_exists( $widget_path.'includes/widgets/htmega_'.$widget_file_name.'.php' ) ? true : false ;
            }

            if ( $widget_status ){
                if( htmega_is_pro_active() && file_exists( HTMEGA_ADDONS_PL_PATH_PRO.'includes/widgets/htmega_'.$widget_file_name.'.php' ) ) {
                    require_once HTMEGA_ADDONS_PL_PATH_PRO.'includes/widgets/htmega_'.$widget_file_name.'.php';
                } else {
                    require_once $widget_path.'includes/widgets/htmega_'.$widget_file_name.'.php';
                }

                if ( htmega_is_elementor_version( '>=', '3.5.0' ) ){
                    $widgets_manager->register( new $widget_class() );
                }else{
                    $widgets_manager->register_widget_type( new $widget_class() );
                }
                
            }

        }
    }
    
    private function get_widget_list(){

        $widget_list =[
            'accordion'=> [
                'title' => 'Accordion',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'animatesectiontitle'=> [
                'title' => 'Animated Heading',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'addbanner' => [
                'title' => 'Add Banner',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'specialadsbanner' =>[
                'title' => 'Special day Banner',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'blockquote' =>[
                'title' => 'Blockquote',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'brandlogo' =>[
                'title' => 'Brand',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'businesshours' =>[
                'title' => 'Business Hours',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'button' =>[
                'title' => 'Button',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'calltoaction' =>[
                'title' => 'Call To Action',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'carousel' =>[
                'title' => 'Carousel',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'countdown' =>[
                'title' => 'Countdown',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'counter' =>[
                'title' => 'Counter',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'customevent' =>[
                'title' => 'Custom_Event',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'dualbutton' =>[
                'title' => 'Double Button',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'dropcaps' =>[
                'title' => 'Dropcaps',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'flipbox' =>[
                'title' => 'Flip Box',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'galleryjustify' =>[
                'title' => 'Gallery Justify',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'googlemap' =>[
                'title' => 'GoogleMap',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'imagecomparison' =>[
                'title' => 'Image Comparison',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'imagegrid' =>[
                'title' => 'Image Grid',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'imagemagnifier' =>[
                'title' => 'Image Magnifier',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'imagemarker' =>[
                'title' => 'ImageMarker',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'imagemasonry' =>[
                'title' => 'Image_Masonry',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'inlinemenu' =>[
                'title' => 'InlineMenu',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'instagram' =>[
                'title' => 'Instagram',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'lightbox' =>[
                'title' => 'Lightbox',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'modal' =>[
                'title' => 'Modal',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'newtsicker' =>[
                'title' => 'Newsticker',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'notify' =>[
                'title' => 'Notify',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'offcanvas' =>[
                'title' => 'Offcanvas',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'panelslider' =>[
                'title' => 'Panel Slider',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'popover' =>[
                'title' => 'Popover',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'postcarousel' =>[
                'title' => 'Post Carousel',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'postgrid' =>[
                'title' => 'PostGrid',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'postgridtab' =>[
                'title' => 'Post Grid Tab',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'postslider' =>[
                'title' => 'Post Slider',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'pricinglistview' =>[
                'title' => 'Pricing List View',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'pricingtable' =>[
                'title' => 'Pricing Table',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'progressbar' =>[
                'title' => 'Progress Bar',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'scrollimage' =>[
                'title' => 'Scroll Image',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'scrollnavigation' =>[
                'title' => 'Scroll Navigation',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'search' =>[
                'title' => 'Search',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'sectiontitle' =>[
                'title' => 'Section_Title',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'service' =>[
                'title' => 'Service',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'singlepost' =>[
                'title' => 'SinglePost',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'thumbgallery' =>[
                'title' => 'Slider Thumb Gallery',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'socialshere' =>[
                'title' => 'SocialShere',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'switcher' =>[
                'title' => 'Switcher',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'tabs' =>[
                'title' => 'Tabs',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'datatable' =>[
                'title' => 'Data Table',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'teammember' =>[
                'title' => 'TeamMember',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'testimonial' =>[
                'title' => 'Testimonial',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'testimonialgrid' =>[
                'title' => 'Testimonial Grid',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'toggle' =>[
                'title' => 'Toggle',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'tooltip' =>[
                'title' => 'Tooltip',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'twitterfeed' =>[
                'title' => 'Twitter_Feed',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'userloginform' =>[
                'title' => 'User Login Form',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'userregisterform' =>[
                'title' => 'User Register Form',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'verticletimeline' =>[
                'title' => 'Verticle Time Line',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'videoplayer' =>[
                'title' => 'VideoPlayer',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'workingprocess' =>[
                'title' => 'Working Process',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'errorcontent' =>[
                'title' => 'ErrorContent',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'template_selector' =>[
                'title' => 'Template Selector',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'weather' =>[
                'title' => 'Weather',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'audio_player' =>[
                'title' => 'Audio Player',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],
            'calendly' =>[
                'title' => 'Calendly',
                'option-tab'=>'htmega_element_tabs', 
                'is_pro'   => false,
            ],

            'bbpress' => [   
                'title' => 'Bbpress',
                'option-tab'=> 'htmega_thirdparty_element_tabs', 
                'is_pro'=>false 
            ],

            'bookedcalender' => [
                'title' => 'Booked Calendar',
                'option-tab'=> 'htmega_thirdparty_element_tabs', 
                'third-party-resource' => 'booked/booked.php',
                'is_pro'=>false 
            ],

            'buddypress' => [   
                'title' => 'Buddy Press',
                'option-tab'=> 'htmega_thirdparty_element_tabs',
                'is_pro'=>false 
            ],

            'calderaform' => [   
                'title' => 'Caldera Form',
                'option-tab'=> 'htmega_thirdparty_element_tabs',
                'is_pro'=>false 
            ],

            'contactform' => [   
                'title' => 'Contact Form Seven',
                'option-tab'=> 'htmega_thirdparty_element_tabs',
                'is_pro'=>false 
            ],

            'downloadmonitor' => [   
                'title' => 'Download Monitor',
                'option-tab'=> 'htmega_thirdparty_element_tabs',
                'is_pro'=>false 
            ],

            'easydigitaldownload' => [   
                'title' => 'Easy Digital Download',
                'option-tab'=> 'htmega_thirdparty_element_tabs',
                'is_pro'=>false 
            ],

            'gravityforms' => [   
                'title' => 'Gravity Forms',
                'option-tab'=> 'htmega_thirdparty_element_tabs',
                'is_pro'=>false 
            ],

            'instragramfeed' => [   
                'title' => 'Instragram Feed',
                'option-tab'=> 'htmega_thirdparty_element_tabs',
                'is_pro'=>false 
            ],

            'jobmanager' => [   
                'title' => 'Job Manager',
                'option-tab'=> 'htmega_thirdparty_element_tabs',
                'is_pro'=>false 
            ],
            'layerslider' => [   
                'title' => 'Layer Slider',
                'option-tab'=> 'htmega_thirdparty_element_tabs',
                'third-party-resource' => 'LayerSlider/layerslider.php', 
                'is_pro'=>false 
            ],

            'mailchimpwp' => [   
                'title' => 'Mailchimp Wp',
                'option-tab'=> 'htmega_thirdparty_element_tabs',
                'is_pro'=>false 
            ],

            'ninjaform' => [   
                'title' => 'Ninja Form',
                'option-tab'=> 'htmega_thirdparty_element_tabs',
                'is_pro'=>false 
            ],

           'quforms' => [   
                'title' => 'QUforms',
                'option-tab'=> 'htmega_thirdparty_element_tabs',
                'is_pro'=>false 
            ],

            'wpforms' => [   
                'title' => 'WPforms',
                'option-tab'=> 'htmega_thirdparty_element_tabs',
                'is_pro'=>false 
            ],

            'revolution' => [   
                'title' => 'Revolution Slider',
                'option-tab'=> 'htmega_thirdparty_element_tabs',
                'is_pro'=>false 
            ],

            'tablepress' => [   
                'title' => 'Tablepress',
                'option-tab'=> 'htmega_thirdparty_element_tabs',
                'is_pro'=>false 
            ],

            'wcaddtocart' => [   
                'title' => 'WC Add to Cart',
                'option-tab'=> 'htmega_thirdparty_element_tabs',
                'third-party-resource' => 'woocommerce/woocommerce.php', 
                'is_pro'=>false 
            ],

            'categories' => [   
                'title' => 'WC Categories',
                'option-tab'=> 'htmega_thirdparty_element_tabs',
                'third-party-resource' => 'woocommerce/woocommerce.php', 
                'is_pro'=>false 
            ],

            'wcpages' => [   
                'title' => 'WC Element Pages',
                'option-tab'=> 'htmega_thirdparty_element_tabs',
                'third-party-resource' => 'woocommerce/woocommerce.php', 
                'is_pro'=>false 
            ],

        ];

        return apply_filters( 'htmega_widget_list', $widget_list );
    }
}
HTMega_Widgets_Control::instance();