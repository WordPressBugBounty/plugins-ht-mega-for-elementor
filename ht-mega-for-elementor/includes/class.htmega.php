<?php

final class HTMega_Addons_Elementor {
    
    const MINIMUM_ELEMENTOR_VERSION = '2.5.0';
    const MINIMUM_HTMEGA_PRO_VERSION = '1.9.5';
    const MINIMUM_PHP_VERSION = '7.0';

    /**
     * [$template_info]
     * @var array
     */
    public static $template_info = [];

    /**
     * [$_instance]
     * @var null
     */
    private static $_instance = null;

    /**
     * [instance] Initializes a singleton instance
     * @return [HTMega_Addons_Elementor]
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * [__construct] Class construcotr
     */
    private function __construct() {
        if ( ! function_exists('is_plugin_active') ){ include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); }
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ],15 );
        
        // Register Plugin Active Hook
        register_activation_hook( HTMEGA_ADDONS_PL_ROOT, [ $this, 'plugin_activate_hook'] );

    }

    /**
     * [i18n] Load Text Domain
     * @return [void]
     */
    public function i18n() {
        load_plugin_textdomain( 'htmega-addons', false, dirname( plugin_basename( HTMEGA_ADDONS_PL_ROOT ) ) . '/languages/' );
    }

    /**
     * [init] Plugins Loaded Init Hook
     * @return [void]
     */
    public function init() {

        // Check if Elementor installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
            return;
        }

        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
            return;
        }

        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return;
        }

        // Add Image Size
        $this->add_image_size();

        // Include Required files
        $this->includes();

        // After Active Plugin then redirect to setting page
        $this->plugin_redirect_option_page();

        // Load Template Manager - this needs to be before init
        $this->load_template_manager();

        // Load components that need translations
        add_action('init', [$this, 'init_components'], 5);

         //elementor editor template library
         if ( is_user_logged_in() && did_action( 'elementor/loaded' ) ) {
            HtMeaga\ElementorTemplate\Elementor_Library_Manage::instance();
        }

        // Plugins Setting Page
        add_filter('plugin_action_links_'.HTMEGA_ADDONS_PLUGIN_BASE, [ $this, 'plugins_setting_links' ] );
        add_filter( 'plugin_row_meta', [ $this, 'htmega_plugin_row_meta' ], 10, 4 );
    }

    /**
     * Initialize components that require translations
     */
    public function init_components() {
        // Load Recommended Plugins
        if( is_admin() ){
            require_once ( HTMEGA_ADDONS_PL_PATH . 'includes/recommended-plugins/class.recommended-plugins.php' );
            require_once ( HTMEGA_ADDONS_PL_PATH . 'includes/recommended-plugins/recommended-plugins.php' );
        }
    }

    /**
     * Load template manager after init
     */
    public function load_template_manager() {
        if ( is_plugin_active( 'htmega-pro/htmega_pro.php' ) && file_exists( HTMEGA_ADDONS_PL_PATH_PRO . 'includes/admin/class.theme-builder.php' ) ) {
            require_once ( HTMEGA_ADDONS_PL_PATH_PRO . 'includes/admin/class.theme-builder.php' );
        } else {
            require_once ( HTMEGA_ADDONS_PL_PATH . 'admin/include/class.theme-builder.php' );
        }
    }

    /**
     * [includes] Load Required files
     * @return [void]
     */
    public function includes() {
        require_once ( HTMEGA_ADDONS_PL_PATH . 'includes/helper-function.php' );
        require_once ( HTMEGA_ADDONS_PL_PATH . 'includes/class.assests-cache.php' );
        require_once ( HTMEGA_ADDONS_PL_PATH . 'includes/class.assests.php' );
        require_once ( HTMEGA_ADDONS_PL_PATH . 'admin/admin-init.php' );
        require_once ( HTMEGA_ADDONS_PL_PATH . 'includes/widgets_control.php' );
        require_once ( HTMEGA_ADDONS_PL_PATH . 'includes/class.htmega-icon-manager.php' );
        require_once ( HTMEGA_ADDONS_PL_PATH . 'includes/class.updater.php' );
        require_once ( HTMEGA_ADDONS_PL_PATH . 'admin/include/custom-control/preset-manage.php' );
        require_once ( HTMEGA_ADDONS_PL_PATH . 'admin/include/custom-control/preset-select.php' );
        
        // Initialize onboarding early
        if ( ! get_option( 'htmega_onboarding_completed' ) && ! get_option('htmega_element_tabs') && ! get_option('htmega_advance_element_tabs ') ) {
            require_once ( HTMEGA_ADDONS_PL_PATH . 'admin/include/settings-panel/includes/classes/Onboarding.php' );
        }

        if('yes' === get_option('woocommerce_enable_ajax_add_to_cart')){
            require_once ( HTMEGA_ADDONS_PL_PATH.'includes/class.single-product-ajax-addto-cart.php' );
        }

        // Admin Required File
        if( is_admin() ){

            // Post Duplicator
            if( htmega_get_option( 'postduplicator', 'htmega_advance_element_tabs', 'off' ) === 'on' ){
                require_once ( HTMEGA_ADDONS_PL_PATH . 'includes/class.post-duplicator.php' );
            }
            // Admin Notices
            add_action( 'admin_head', [ $this, 'admin_rating_notice' ] );
            if ( is_plugin_active('htmega-pro/htmega_pro.php' ) ) {
                add_action( 'admin_head', [ $this, 'admin_htmega_pro_version_compatibily' ] );
            }
        }

        // Extension Assest Management
        require_once( HTMEGA_ADDONS_PL_PATH . 'extensions/class.enqueue_scripts.php' );

        // HT Builder
        if ( ( 'on' == htmega_get_module_option( 'htmega_themebuilder_module_settings','themebuilder','themebuilder_enable','off' ) ) ||
         (  htmega_get_option( 'themebuilder', 'htmega_advance_element_tabs', 'off' ) === 'on' && empty ( htmega_get_module_option( 'htmega_themebuilder_module_settings') ) )) {
            require_once( HTMEGA_ADDONS_PL_PATH . 'extensions/ht-builder/init.php' );

        }
        // WC Sales Notification
        if( htmega_get_option( 'salenotification', 'htmega_advance_element_tabs', 'off' ) === 'on' && is_plugin_active('woocommerce/woocommerce.php') ){
            if( is_plugin_active('htmega-pro/htmega_pro.php') ){
                if( htmega_get_option( 'notification_content_type', 'htmegawcsales_setting_tabs', 'actual' ) == 'fakes' ){
                    require_once( HTMEGA_ADDONS_PL_PATH_PRO . 'extensions/wc-sales-notification/classes/class.sale_notification_fake.php' );
                }else{
                    require_once( HTMEGA_ADDONS_PL_PATH_PRO . 'extensions/wc-sales-notification/classes/class.sale_notification.php' );
                }
            }else{
                require_once( HTMEGA_ADDONS_PL_PATH . 'extensions/wc-sales-notification/classes/class.sale_notification.php' );
            }
        }

        // HT Menu
        if ( ( 'on' == htmega_get_module_option( 'htmega_megamenu_module_settings','megamenubuilder','megamenubuilder_enable','off' ) ) ||
         ( htmega_get_option( 'megamenubuilder', 'htmega_advance_element_tabs', 'off' ) === 'on' && empty ( htmega_get_module_option( 'htmega_megamenu_module_settings') )) ) {

            if ( is_plugin_active( 'htmega-pro/htmega_pro.php' ) ) {
                require_once( HTMEGA_ADDONS_PL_PATH_PRO . 'extensions/ht-menu/classes/class.mega-menu.php' );
            } else {
                require_once( HTMEGA_ADDONS_PL_PATH . 'extensions/ht-menu/classes/class.mega-menu.php' );
            }
        }

        //Wrapper Link Module
        if( htmega_get_option( 'wrapperlink', 'htmega_advance_element_tabs', 'off' ) === 'on' ){
            require_once( HTMEGA_ADDONS_PL_PATH . 'extensions/wrapper-link/class.wrapper-link.php' );
        }
        //Reading progress bar Module
        $htmega_rpbar_module_settings = htmega_get_option( 'htmega_rpbar', 'htmega_rpbar_module_settings' );
        $htmega_rpbar_module_settings = json_decode( $htmega_rpbar_module_settings,true );

        if( ! empty ( $htmega_rpbar_module_settings['rpbar_enable'] ) ) {

            if( 'on' == $htmega_rpbar_module_settings['rpbar_enable'] ) {
                require_once( HTMEGA_ADDONS_PL_PATH . 'extensions/reading-progress-bar/class.reading-progress-bar.php' );
            }

        } else {
            
            if  (  htmega_get_option( 'htmega_rpbar', 'htmega_advance_element_tabs', 'off' ) === 'on' ){
                require_once( HTMEGA_ADDONS_PL_PATH . 'extensions/reading-progress-bar/class.reading-progress-bar.php' );
            }
        }
        //Scroll To Top Module
        $htmega_stt_module_settings = htmega_get_option( 'htmega_stt', 'htmega_stt_module_settings' );
        $htmega_stt_module_settings = json_decode( $htmega_stt_module_settings, true );

        if( ! empty ( $htmega_stt_module_settings['stt_enable'] ) && 'on' == $htmega_stt_module_settings['stt_enable'] ) {
            require_once( HTMEGA_ADDONS_PL_PATH . 'extensions/scroll-to-top/class.scroll-to-top.php' );
        }
        // Floating Effects Module
        if( htmega_get_option( 'floating_effects', 'htmega_advance_element_tabs', 'off' ) === 'on' ){

            if( is_plugin_active('htmega-pro/htmega_pro.php')  && file_exists( HTMEGA_ADDONS_PL_PATH_PRO . 'extensions/floating-effects/class.floating-effects.php' )){
                require_once( HTMEGA_ADDONS_PL_PATH_PRO . 'extensions/floating-effects/class.floating-effects.php' );
            }else{
                require_once( HTMEGA_ADDONS_PL_PATH . 'extensions/floating-effects/class.floating-effects.php' );
            }
            
        }

        /**
         * Load HT Mega AI Integration
         */
        if (file_exists(HTMEGA_ADDONS_PL_PATH . 'includes/ai/htmega-ai-integration.php')) {
           
            require_once HTMEGA_ADDONS_PL_PATH . 'includes/ai/htmega-ai-integration.php';
            // add_action('elementor/loaded', function() {
            //     require_once HTMEGA_ADDONS_PL_PATH . 'includes/ai/htmega-ai-integration.php';
            // });
        }
    }
    
   /**
     * [htmega_plugin_row_meta] Plugin row meta
     * @return [links] plugin action link
     */
    public function htmega_plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {
    
        if ( $plugin_file === HTMEGA_ADDONS_PLUGIN_BASE ) {
            $new_links = array(
                'docs'          => '<a href="https://wphtmega.com/docs/" target="_blank"><span class="dashicons dashicons-search"></span>' . esc_html__( 'Documentation', 'htmega-addons' ) . '</a>',
                'facebookgroup' => '<a href="https://www.facebook.com/groups/woolentor" target="_blank"><span class="dashicons dashicons-facebook" style="font-size:14px;line-height:1.3"></span>' . esc_html__( 'Facebook Group', 'htmega-addons' ) . '</a>',
                'rateus'        => '<a href="https://wordpress.org/support/plugin/ht-mega-for-elementor/reviews/?filter=5#new-post" target="_blank"><span class="dashicons dashicons-star-filled" style="font-size:14px;line-height:1.3"></span>' . esc_html__( 'Rate the plugin', 'htmega-addons' ) . '</a>',

                );
            
            $plugin_meta = array_merge( $plugin_meta, $new_links );
        }
        
        return $plugin_meta;
    }

    /**
     * Rating Notice
     *
     * @return void
     */
    public function admin_rating_notice(){

        if ( ! get_option( 'htmega_diagnostic_data_notice', false ) ) {
            return;
        }
        if ( get_option( 'htmega_rating_already_rated', false ) ) {
            return;
        }
        
        $logo_url = esc_url(HTMEGA_ADDONS_PL_URL . "admin/assets/images/logo.png");

        $message = '<div class="hastech-review-notice-wrap">
                    <div class="hastech-rating-notice-logo">
                        <img src="' . $logo_url . '" alt="' . esc_attr__('HT Mega','htmega-addons') . '" style="max-width:85px"/>
                    </div>
                    <div class="hastech-review-notice-content">
                        <h3>' . esc_html__('Hi there! Thanks a lot for choosing HT Mega Elementor Addons to take your WordPress website to the next level.','htmega-addons').'</h3>
                        <p>' . esc_html__('It would be greatly appreciated if you consider giving us a review in WordPress. These reviews help us improve the plugin further and make it easier for other users to decide when exploring HT Mega Elementor Addons!', 'htmega-addons') . '</p>
                        <div class="hastech-review-notice-action">
                            <a href="https://wordpress.org/support/plugin/ht-mega-for-elementor/reviews/?filter=5#new-post" class="hastech-review-notice button-primary" target="_blank">' . esc_html__('Ok, you deserve it!','htmega-addons') . '</a>
                            <span class="dashicons dashicons-calendar"></span>
                            <a href="#" class="hastech-notice-close hastech-review-notice">' . esc_html__('Maybe Later','htmega-addons').'</a>
                            <span class="dashicons dashicons-smiley"></span>
                            <a href="#" data-already-did="yes" class="hastech-notice-close hastech-review-notice">' . esc_html__('I already did','htmega-addons') . '</a>
                        </div>
                    </div>
                </div>';

        \HasTech_Notices::set_notice(
            [
                'id'          => 'htmega-rating-notice',
                'type'        => 'info',
                'dismissible' => true,
                'message_type' => 'html',
                'message'     => $message,
                'display_after' => ( 2 * WEEK_IN_SECONDS ),
                'expire_time' => MONTH_IN_SECONDS,
                'close_by'    => 'transient'
            ]
        );
    }



    /**
     * HT Mega Pro version compatibility Notice
     *
     * @return void
     */
    public function admin_htmega_pro_version_compatibily() {

        if ( version_compare( HTMEGA_VERSION_PRO, self::MINIMUM_HTMEGA_PRO_VERSION, '>=' ) ) {
            return;
        }
        $message = '<p>' . __( 'To ensure smooth functionality of <strong>HT MEGA Addons for Elementor</strong>, please update to version '. self::MINIMUM_HTMEGA_PRO_VERSION .' or greater of <strong>HT Mega Pro</strong> for seamless compatibility.', 'htmega-addons' ) . '</p>';

        \HasTech_Notices::set_notice(
            [
                'id'          => 'htmega-free-and-pro-compatibilty-notice',
                'type'        => 'warning',
                'dismissible' => false,
                'message_type' => 'html',
                'message'     => $message,
                'display_after'  => 1,
                'expire_time' => 0,
                'close_by'    => 'user'
            ]
        );
    }

    /**
     * [add_image_size]
     * @return [void]
     */
    public function add_image_size() {
        add_image_size( 'htmega_size_585x295', 585, 295, true );
        add_image_size( 'htmega_size_1170x536', 1170, 536, true );
        add_image_size( 'htmega_size_396x360', 396, 360, true );
    }

    /**
     * [is_plugins_active] Check Plugin installation status
     * @param  [string]  $pl_file_path plugin location
     * @return boolean  True | False
     */
    public function is_plugins_active( $pl_file_path = NULL ){
        $installed_plugins_list = get_plugins();
        return isset( $installed_plugins_list[$pl_file_path] );
    }

    /**
     * [admin_notice_missing_main_plugin] Admin Notice if elementor Deactive | Not Install
     * @return [void]
     */
    public function admin_notice_missing_main_plugin() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $elementor = 'elementor/elementor.php';
        if( $this->is_plugins_active( $elementor ) ) {
            if( ! current_user_can( 'activate_plugins' ) ) { return; }

            $activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $elementor . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $elementor );

            $message = '<p>' . __( '<strong>HTMEGA Addons for Elementor</strong> requires "<strong>Elementor</strong>" plugin to be active. Please activate Elementor to continue.', 'htmega-addons' ) . '</p>';
            $message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, __( 'Elementor Activate Now', 'htmega-addons' ) ) . '</p>';
        } else {
            if ( ! current_user_can( 'install_plugins' ) ) { return; }

            $install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );

            $message = '<p>' . __( '<strong>HTMEGA Addons for Elementor</strong> requires "<strong>Elementor</strong>" plugin to be active. Please install the Elementor plugin to continue.', 'htmega-addons' ) . '</p>';

            $message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Elementor Install Now', 'htmega-addons' ) ) . '</p>';
        }
        echo '<div class="error"><p>' . $message . '</p></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    /**
     * [admin_notice_minimum_elementor_version]
     * @return [void] Elementor Required version check with current version
     */
    public function admin_notice_minimum_elementor_version() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            /* translators: 1: Plugin name (HTMega Addons), 2: Required plugin name (Elementor), 3: Minimum required version */
            __( '"%1$s" requires "%2$s" version %3$s or greater.', 'htmega-addons' ),
            '<strong>' . __( 'HTMega Addons', 'htmega-addons' ) . '</strong>',
            '<strong>' . __( 'Elementor', 'htmega-addons' ) . '</strong>',
             self::MINIMUM_ELEMENTOR_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    /**
     * [admin_notice_minimum_php_version] Check PHP Version with required version
     * @return [void]
     */
    public function admin_notice_minimum_php_version() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf( /* translators: 1: Plugin name (HTMega Addons), 2: Required component name (PHP), 3: Minimum required version */
            __( '"%1$s" requires "%2$s" version %3$s or greater.', 'htmega-addons' ),
            '<strong>' . __( 'HTMega Addons', 'htmega-addons' ) . '</strong>',
            '<strong>' . __( 'PHP', 'htmega-addons' ) . '</strong>',
             self::MINIMUM_PHP_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    } 

    /**
     * [plugins_setting_links]
     * @param  [array] $links plugin menu list.
     * @return [array] plugin menu list.
     */
    public function plugins_setting_links( $links ) {
        $htmega_settings_link = '<a href="admin.php?page=htmega-addons#/general">'.esc_html__( 'Settings', 'htmega-addons' ).'</a>';
        array_unshift( $links, $htmega_settings_link );
        if( !is_plugin_active('htmega-pro/htmega_pro.php') ){
            $links['htmegago_pro'] = sprintf('<a href="https://wphtmega.com/pricing/" target="_blank" style="color: #39b54a; font-weight: bold;">' . esc_html__('Go Pro','htmega-addons') . '</a>');
        }
        return $links; 
    }

    /**
     * [plugin_activate_hook] Plugin Activation Hook
     * @return [void]
     */
    public function plugin_activate_hook() {


        // save plugin activation time
        if ( false === get_option( 'htmega_elementor_addons_activation_time' ) ) {
            add_option( 'htmega_elementor_addons_activation_time', absint( intval( strtotime('now') ) ) );
        }
        // save plugin version
        if ( false === get_option( 'htmega_elementor_addons_version' ) ) {
            update_option('htmega_elementor_addons_version', HTMEGA_VERSION );
        }

        add_option('htmega_do_activation_redirect', true);
    }

    /**
     * [plugin_redirect_option_page] After Install plugin then redirect setting page
     * @return [void]
     */
    public function plugin_redirect_option_page() {

        // save data for old user before version 1.4.5
        if ( false === get_option( 'htmega_elementor_addons_activation_time' ) ) {
            add_option( 'htmega_elementor_addons_activation_time', absint( intval( strtotime('now') ) ) );
        }
        // save plugin version
        if ( false === get_option( 'htmega_elementor_addons_version' ) ) {
            update_option('htmega_elementor_addons_version', HTMEGA_VERSION );
        } 
        if ( get_option( 'htmega_do_activation_redirect', false ) ) {
            delete_option('htmega_do_activation_redirect');
            if( !isset( $_GET['activate-multi'] ) ) {
                wp_redirect( admin_url("admin.php?page=htmega-addons") );
            }
        }
    }

}

/**
 * Initializes the main plugin
 *
 * @return \HTMega_Addons_Elementor
 */
function htmega() {
    return HTMega_Addons_Elementor::instance();
}