<?php

if( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly

if ( !class_exists( 'HTMega_Elementor_Addons_Assests' ) ) {

    class HTMega_Elementor_Addons_Assests{

        /**
         * [$_instance]
         * @var null
         */
        private static $_instance = null;

        /**
         * [instance] Initializes a singleton instance
         * @return [HTMega_Elementor_Addons_Assests]
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
        public function __construct(){

            // Register Scripts
            add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
            add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ] );

            // Elementor Editor Style
            add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'editor_scripts' ] );

            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

            // delete asset cache when save or delete post
            add_action( 'elementor/editor/after_save', [ $this, 'cache_widgets_asset' ], 10, 2 );
		    add_action( 'after_delete_post', [ $this, 'delete_cache' ] );

            // One-click install/activate for contact form plugin from Elementor editor
            add_action( 'wp_ajax_htmega_activate_contact_plugin', [ $this, 'ajax_activate_contact_plugin' ] );

        }

        /**
         * All available styles
         *
         * @return array
         */
        public function get_styles() {

            $style_list = [

                'htbbootstrap' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/css/htbbootstrap.css',
                    'version' => HTMEGA_VERSION
                ],
                'htmega-global-style' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/css/htmega-global-style.css',
                    'version' => HTMEGA_VERSION
                ],
                'htmega-global-style-min' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/css/htmega-global-style.min.css',
                    'version' => HTMEGA_VERSION
                ],
                'htmega-widgets-style' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/widgets/htmega-widgets-style.min.css',
                    'version' => HTMEGA_VERSION
                ],
                'htmega-animation' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/css/animation.css',
                    'version' => HTMEGA_VERSION
                ],
                'htmega-weather' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/widgets/weather/style.css',
                    'version' => HTMEGA_VERSION
                ],
                'regular-weather-icon' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/css/weather-icons.min.css',
                    'version' => HTMEGA_VERSION
                ],
                'slick' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/css/slick.min.css',
                    'version' => HTMEGA_VERSION
                ],
                'magnific-popup' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/css/magnific-popup.css',
                    'version' => HTMEGA_VERSION
                ],
                'ytplayer' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/css/jquery.mb.YTPlayer.min.css',
                    'version' => HTMEGA_VERSION
                ],
                'compare-image' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/css/compare-image.css',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'htmega-global-style' ]
                ],
                'justify-gallery' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/css/justify-gallery.css',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'htmega-global-style' ]
                ],
                'datatables' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/css/datatables.min.css',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'htmega-global-style' ]
                ],
                'magnifier' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/css/magnifier.css',
                    'version' => HTMEGA_VERSION,
                    'deps'    => ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? [ 'htmega-global-style' ] : [ 'htmega-global-style-min' ],
                ],
                'animated-heading' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/css/animated-text.css',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'htmega-global-style' ]
                ],
                'htmega-keyframes' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/css/htmega-keyframes.css',
                    'version' => HTMEGA_VERSION
                ],

                'htmega-admin' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'admin/assets/css/htmega_admin.css',
                    'version' => HTMEGA_VERSION
                ],
                'htmega-rpbar-css' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'extensions/reading-progress-bar/assets/css/htmega-reading-progress-bar.css',
                    'version' => HTMEGA_VERSION
                ],
                'htmega-stt-css' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'extensions/scroll-to-top/assets/css/htmega-scroll-to-top.css',
                    'version' => HTMEGA_VERSION
                ],
                'htmega-audio-player' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/widgets/audio-player/style.css',
                    'version' => HTMEGA_VERSION
                ]
            ];

            return apply_filters( 'htmega_style_list', $style_list );

        }

        /**
         * All available scripts
         *
         * @return array
         */
        public function get_scripts(){

            $google_map_api_key = htmega_get_option( 'google_map_api_key','htmega_general_tabs' );

            $script_list = [

                'htmega-audio-player' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/widgets/audio-player/active.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'htbbootstrap' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/htbbootstrap.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery', 'htmega-popper' ],
                ],
                'htmega-popper' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/popper.min.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'dompurify' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/purify.min.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'htmega-calendly' => [
                    'src'     => 'https://assets.calendly.com/assets/external/widget.js',
                    'version' => null,
                    'deps'    => []
                ],
                'htmega-widgets-scripts' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/htmega-widgets-active.js',
                    'version' => HTMEGA_VERSION,
                    // magnifier must load before the bundle (Image Magnifier uses $.fn.magnify in element_ready).
                    'deps'    => [ 'jquery', 'magnifier' ],
                ],
                'htmega-widgets-scripts-min' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/htmega-widgets-active.min.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery', 'magnifier' ],
                ],
                'slick' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/slick.min.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'magnific-popup' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/jquery.magnific-popup.min.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'beerslider' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/jquery-beerslider-min.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'ytplayer' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/jquery.mb.YTPlayer.min.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'mapmarker' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/mapmarker.jquery.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'jquery-easing' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/jquery.easing.1.3.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'jquery-mousewheel' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/jquery.mousewheel.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'vaccordion' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/jquery.vaccordion.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'easy-pie-chart' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/jquery-easy-pie-chart.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'htmega-countdown' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/jquery-countdown.min.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'htmega-newsticker' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/jquery-newsticker-min.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'htmega-goodshare' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/goodshare.min.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'htmega-notify' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/notify.min.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'counterup' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/jquery.counterup.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'isotope' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/isotope.pkgd.min.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'justified-gallery' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/justified-gallery.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'datatables' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/datatables.min.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'magnifier' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/magnifier.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'animated-heading' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/animated-heading.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'waypoints' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/waypoints.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'google-map-api' => [
                    'src'     => 'https://maps.googleapis.com/maps/api/js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],

                'htmega-admin' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'admin/assets/js/admin.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'htmega-templates' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'admin/assets/js/template_library_manager.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'htmega-install-manager' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'admin/assets/js/install_manager.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'htmega-templates', 'wp-util', 'updates' ]
                ],
                'htmega-rpbar-script' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'extensions/reading-progress-bar/assets/js/htmega-reading-progress-bar.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'htmega-stt-script' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'extensions/scroll-to-top/assets/js/htmega-scroll-to-top.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
                'anime' => [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'extensions/floating-effects/assets/js/anime.min.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ],
            ];

            if( !empty( $google_map_api_key ) ){
                $script_list['google-map-api'] = [
                    'src'     => add_query_arg( array( 'key' => $google_map_api_key ), 'https://maps.googleapis.com/maps/api/js' ),
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ];
            }

            if ( is_plugin_active('woocommerce/woocommerce.php') && htmega_get_option( 'wcaddtocart', 'htmega_thirdparty_element_tabs', 'on' ) === 'on' && 'yes' === get_option('woocommerce_enable_ajax_add_to_cart') ) {
                $script_list['htmega-single-product-ajax-cart'] = [
                    'src'     => HTMEGA_ADDONS_PL_URL . 'assets/js/single_product_ajax_add_to_cart.js',
                    'version' => HTMEGA_VERSION,
                    'deps'    => [ 'jquery' ]
                ];
            }

            return apply_filters( 'htmega_script_list', $script_list );

        }

        /**
         * Register scripts and styles
         *
         * @return void
         */
        public function register_assets() {
            $scripts = $this->get_scripts();
            $styles  = $this->get_styles();

            // Elementor preview iframes only collect widget script handles from the initial document; template imports
            // inject new widgets without re-fetching the frame, so libraries (Slick, BeerSlider, easy-pie-chart, …)
            // may be absent when htmega-widgets-active handlers run.
            $merge_editor_preview_deps = function_exists( 'htmega_is_elementor_preview_request' ) && htmega_is_elementor_preview_request();
            if ( ! $merge_editor_preview_deps && ! function_exists( 'htmega_is_elementor_preview_request' ) && function_exists( 'htmega_is_editing_mode' ) ) {
                $merge_editor_preview_deps = htmega_is_editing_mode();
            }
            if ( $merge_editor_preview_deps ) {
                /** @var string[] Script handles merged into the main widget bundle in editor/preview (filterable). */
                $editor_bundle_extra_deps = apply_filters(
                    'htmega_editor_preview_widget_bundle_extra_deps',
                    array(
                        'slick',
                        'beerslider',
                        'easy-pie-chart',
                        'htmega-countdown',
                        'htmega-newsticker',
                        'isotope',
                        'swiper',
                        'magnific-popup',
                        'ytplayer',
                        'vaccordion',
                        'counterup',
                        'animated-heading',
                        'mapmarker',
                        'magnifier',
                        // Masonry widget uses core-registered scripts:
                        'masonry',
                        'imagesloaded',
                    )
                );
                foreach ( array( 'htmega-widgets-scripts', 'htmega-widgets-scripts-min' ) as $bundle_handle ) {
                    if ( empty( $scripts[ $bundle_handle ] ) ) {
                        continue;
                    }
                    $deps = isset( $scripts[ $bundle_handle ]['deps'] ) && is_array( $scripts[ $bundle_handle ]['deps'] )
                        ? $scripts[ $bundle_handle ]['deps']
                        : array( 'jquery' );
                    foreach ( $editor_bundle_extra_deps as $dep_handle ) {
                        if ( isset( $scripts[ $dep_handle ] ) || wp_script_is( $dep_handle, 'registered' ) ) {
                            $deps[] = $dep_handle;
                        }
                    }
                    $deps                              = array_values( array_unique( $deps ) );
                    $scripts[ $bundle_handle ]['deps'] = $deps;
                }
            }

            $localize_data_frontend = [];
            $localize_data_admin = [];

            if( is_plugin_active('elementor-pro/elementor-pro.php') ){
                $localize_data_frontend['elementorpro'] = true;
            }else{
                $localize_data_frontend['elementorpro'] = false;
            }
            // string for carousel next/ preve area button
            $localize_data_frontend['buttion_area_text_next'] = __( 'Next', 'ht-mega-for-elementor');
            $localize_data_frontend['buttion_area_text_prev'] = __( 'Previous', 'ht-mega-for-elementor');
            
            // Register Scripts
            foreach ( $scripts as $handle => $script ) {
                $deps = ( isset( $script['deps'] ) ? $script['deps'] : false );
                wp_register_script( $handle, $script['src'], $deps, $script['version'], true );
            }

            // Register Styles
            foreach ( $styles as $handle => $style ) {
                $deps = ( isset( $style['deps'] ) ? $style['deps'] : false );
                wp_register_style( $handle, $style['src'], $deps, $style['version'] );
            }

            // Localize Scripts for frontend
            wp_localize_script( 'htmega-widgets-scripts', 'HTMEGAF', $localize_data_frontend );
            wp_localize_script( 'htmega-widgets-scripts-min', 'HTMEGAF', $localize_data_frontend );
            if( htmega_is_pro_active() ){
                wp_localize_script( 'htmega-pro-slick-active', 'HTMEGAF', $localize_data_frontend );
                wp_localize_script( 'htmega-pro-active', 'HTMEGAF', $localize_data_frontend );
            }
            // admin js ajax request nonce
            $localize_data_admin['admin_ajax_nonce'] = wp_create_nonce( "htmega-admin-ajax-request" );

            wp_localize_script( 'htmega-admin', 'HTMEGAA', $localize_data_admin );

            // Localize Scripts for template manager
            $current_user  = wp_get_current_user();
            $localize_data = [
                'ajaxurl'          => admin_url( 'admin-ajax.php' ),
                'adminURL'         => admin_url(),
                'elementorURL'     => admin_url( 'edit.php?post_type=elementor_library' ),
                'version'          => HTMEGA_VERSION,
                'pluginURL'        => plugin_dir_url( __FILE__ ),
                'alldata'          => !empty( HTMega_Addons_Elementor::$template_info['templates'] ) ? HTMega_Addons_Elementor::$template_info['templates'] : array(),
                'prolink'          => isset( HTMega_Addons_Elementor::$template_info['pro_link'] ) ? HTMega_Addons_Elementor::$template_info['pro_link'] : '#',
                'htmegaProActive' => htmega_is_pro_active() ? 'true':'false',

                'prolabel'         => esc_html__( 'Pro', 'ht-mega-for-elementor' ),
                'loadingimg'       => HTMEGA_ADDONS_PL_URL . 'admin/assets/images/loading.gif',
                'message'          =>[
                    'packagedesc'=> esc_html__( 'in this package', 'ht-mega-for-elementor' ),
                    'allload'    => esc_html__( 'All Items have been Loaded', 'ht-mega-for-elementor' ),
                    'notfound'   => esc_html__( 'No templates found', 'ht-mega-for-elementor' ),
                    'noMatchingTemplates' => esc_html__( 'No templates were found matching your criteria', 'ht-mega-for-elementor' ),
                    'faildToLoad'   => esc_html__( 'Failed to load templates', 'ht-mega-for-elementor' ),
                    'importedSuccess'   => esc_html__( 'Template Imported Successfully!', 'ht-mega-for-elementor' ),
                    'readyToUse'   => esc_html__( 'Your template has been imported and is ready to use', 'ht-mega-for-elementor' ),
                    'importingTemplate' => esc_html__( 'Importing template...', 'ht-mega-for-elementor' ),
                    'requiredPlugins' => esc_html__( 'Required Plugins:', 'ht-mega-for-elementor' ),
                    'pageNameAlert' => esc_html__( 'Please enter a page name', 'ht-mega-for-elementor' ),
                ],
                'buttontxt'      =>[
                    'tmplibrary' => esc_html__( 'Import to Library', 'ht-mega-for-elementor' ),
                    'tmppage'    => esc_html__( 'Import to Page', 'ht-mega-for-elementor' ),
                    'import'     => esc_html__( 'Import', 'ht-mega-for-elementor' ),
                    'buynow'     => esc_html__( 'Buy Now', 'ht-mega-for-elementor' ),
                    'preview'    => esc_html__( 'Preview', 'ht-mega-for-elementor' ),
                    'installing' => esc_html__( 'Installing..', 'ht-mega-for-elementor' ),
                    'activating' => esc_html__( 'Activating..', 'ht-mega-for-elementor' ),
                    'active'     => esc_html__( 'Active', 'ht-mega-for-elementor' ),
                    'activated'  => esc_html__( 'Activated', 'ht-mega-for-elementor' ),
                    'activate'   => esc_html__( 'Activate', 'ht-mega-for-elementor' ),
                    'install'    => esc_html__( 'Install', 'ht-mega-for-elementor' ),
                    'proLabel'     => esc_html__( 'Pro', 'ht-mega-for-elementor' ),
                    'editTemplate'     => esc_html__( 'Edit Template', 'ht-mega-for-elementor' ),
                    'close'     => esc_html__( 'Close', 'ht-mega-for-elementor' ),
                    'allTypes'  => esc_html__( 'All Types', 'ht-mega-for-elementor' ),
                    'upgradeToPro'  => esc_html__( 'Upgrade To PRO', 'ht-mega-for-elementor' ),
                    'previewAll'  => esc_html__( 'All Pages', 'ht-mega-for-elementor' ),
                    'backToHomepages'  => esc_html__( 'Back to Homepages', 'ht-mega-for-elementor' ),
                    'allPages'  => esc_html__( 'All Pages', 'ht-mega-for-elementor' ),
                ],
                'user'           => [
                    'email' => $current_user->user_email,
                ],
                'plgactivenonce'   => wp_create_nonce( 'htmega_actication_verifynonce' ),
                'labels' =>[
                    'createNewPage' => esc_html__( 'Create a new page from this template', 'ht-mega-for-elementor' ),
                    'importToLibrary' => esc_html__( 'Import template to your Library', 'ht-mega-for-elementor' ),
                    'enterPageName' => esc_html__( 'Enter a Page Name', 'ht-mega-for-elementor' ),
                    'or' => esc_html__( 'OR', 'ht-mega-for-elementor' ),
                    'searchTemplate' => esc_html__( 'Search templates...', 'ht-mega-for-elementor' ),
                    'templates' => esc_html__( 'Templates', 'ht-mega-for-elementor' ),
                    'all' => esc_html__( 'All', 'ht-mega-for-elementor' ),
                ]
            ];

            wp_localize_script( 'htmega-templates', 'HTTM', $localize_data );
            wp_localize_script( 'htmegaopt-admin', 'HTTM', $localize_data );

            // Reading Progress Bar / Scroll To Top sitewide auto-enable is a pro-only
            // convenience feature — relocated to htmega-pro (see
            // extensions/reading-progress-bar/class.reading-progress-bar-pro.php and
            // extensions/scroll-to-top/class.scroll-to-top-pro.php) so no pro-gated
            // code ships in the free plugin. Per-page enable already works free via
            // extensions/reading-progress-bar/class.reading-progress-bar.php and
            // extensions/scroll-to-top/class.scroll-to-top.php, unaffected by this.

            // localize  woocommerce  add to card button action
            if ( is_plugin_active('woocommerce/woocommerce.php') && htmega_get_option( 'wcaddtocart', 'htmega_thirdparty_element_tabs', 'on' ) === 'on' && 'yes' === get_option('woocommerce_enable_ajax_add_to_cart') ) {
                $localize_data_woocommerce = [];
                $localize_data_woocommerce['woocommerce_ajax_nonce'] = wp_create_nonce( "htmega-woocommerce-ajax-request" );
                wp_localize_script( 'htmega-single-product-ajax-cart', 'HTMEGAW', $localize_data_woocommerce );
            }
        }


        /**
         * [editor_scripts]
         * @return [void] Load Editor Scripts
         */
        public function editor_scripts() {
            wp_enqueue_style('htmega-element-editor', HTMEGA_ADDONS_PL_URL . 'assets/css/htmega-elementor-editor.css',['elementor-editor'], HTMEGA_VERSION );
            wp_enqueue_script("htmega-widgets-editor", HTMEGA_ADDONS_PL_URL ."/assets/js/htmega-widgets-editor.js", array( "elementor-editor","jquery" ), HTMEGA_VERSION,true);
            wp_enqueue_script("htmega-pormotion-editor", HTMEGA_ADDONS_PL_URL ."/assets/js/promotion.js", array( "elementor-editor","jquery" ), HTMEGA_VERSION,true);
            //Localized  promotional widget for editor js
            wp_localize_script(
                'htmega-widgets-editor',
                'htmegaPanelSettings',
                array(
                    'htmega_pro_installed'        => htmega_is_pro_active() ? true : false,
                    'htmega_pro_widgets'          => $this->get_promotional_widget_list(),
                    'contact_plugin_nonce'        => wp_create_nonce( 'htmega_contact_plugin_action' ),
                )
            );

            // Contact widget: one-click install/activate HT Contact Form
            wp_enqueue_script( 'updates' );
            wp_enqueue_script(
                'htmega-contact-editor',
                HTMEGA_ADDONS_PL_URL . 'assets/js/htm25-contact-editor.js',
                [ 'jquery', 'updates', 'htmega-widgets-editor' ],
                HTMEGA_VERSION,
                true
            );
        }

        /**
         * AJAX handler — activate HT Contact Form plugin from within Elementor editor.
         */
        public function ajax_activate_contact_plugin() {
            check_ajax_referer( 'htmega_contact_plugin_action', 'nonce' );

            if ( ! current_user_can( 'activate_plugins' ) ) {
                wp_send_json_error( [ 'message' => esc_html__( 'Insufficient permissions.', 'ht-mega-for-elementor' ) ] );
            }

            $plugin_file = 'ht-contactform/contact-form-widget-elementor.php';
            $result      = activate_plugin( $plugin_file );

            if ( is_wp_error( $result ) ) {
                wp_send_json_error( [ 'message' => $result->get_error_message() ] );
            }

            wp_send_json_success();
        }

        /**
         * [enqueue_scripts]
         * @return [void] Frontend Scripts
         */
        public function enqueue_scripts( ){
            $allow_global = ! function_exists( 'htmega_should_enqueue_global_assets' ) || htmega_should_enqueue_global_assets();
            $mega_active  = function_exists( 'htmega_has_active_mega_menu' ) && htmega_has_active_mega_menu();

            if ( ! $allow_global && ! $mega_active ) {
                return;
            }

            if ( $mega_active && ! $allow_global ) {
                if ( function_exists( 'htmega_enqueue_mega_menu_companion_pack' ) ) {
                    htmega_enqueue_mega_menu_companion_pack();
                }
                return;
            }

            // CSS
            wp_enqueue_style( 'htbbootstrap' );
            wp_enqueue_style( 'font-awesome' );
            wp_enqueue_style( 'htmega-animation' );
            wp_enqueue_style( 'htmega-keyframes' );
            

            // JS (Popper loads first — required by htbbootstrap.js for tooltips/dropdowns)
            wp_enqueue_script( 'htbbootstrap' );
            wp_enqueue_script( 'waypoints' ); 


            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                wp_enqueue_style( 'htmega-global-style' );
                wp_enqueue_script( 'htmega-widgets-scripts' ); 
            } else {
                wp_enqueue_style( 'htmega-global-style-min' );
                wp_enqueue_script( 'htmega-widgets-scripts-min' );
            }

            if ( function_exists( 'htmega_is_editing_mode' ) && htmega_is_editing_mode() ) {
                wp_enqueue_style( 'slick' );
                // Image comparison + animated heading: styles are normally enqueued only when the widget is in the
                // initial document; match deps to the global stylesheet (min vs non-min) already loaded above.
                $editor_global_style_dep = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? array( 'htmega-global-style' ) : array( 'htmega-global-style-min' );
                wp_enqueue_style(
                    'htmega-compare-image-editor',
                    HTMEGA_ADDONS_PL_URL . 'assets/css/compare-image.css',
                    $editor_global_style_dep,
                    HTMEGA_VERSION
                );
                wp_enqueue_style(
                    'htmega-animated-heading-editor',
                    HTMEGA_ADDONS_PL_URL . 'assets/css/animated-text.css',
                    $editor_global_style_dep,
                    HTMEGA_VERSION
                );
                wp_enqueue_style(
                    'htmega-magnifier-editor',
                    HTMEGA_ADDONS_PL_URL . 'assets/css/magnifier.css',
                    $editor_global_style_dep,
                    HTMEGA_VERSION
                );
            }

            /*
             * Merged per-widget CSS files. Theme Builder header/footer IDs must merge even when
             * `htmega_is_editing_mode()` is true (Elementor preview iframe / Theme Builder preview URLs); otherwise only
             * `htmega-widgets-style` loads and TB templates miss scoped combines.
             */
            $post_id = get_the_ID();
            $combine_document_ids = array();
            if ( ! htmega_is_editing_mode() ) {
                if ( $post_id && htmega_is_elementor_page( $post_id ) ) {
                    $combine_document_ids[] = (int) $post_id;
                }
            }
            if ( function_exists( 'htmega_get_theme_builder_header_footer_ids_for_request' ) ) {
                $tb_ids = htmega_get_theme_builder_header_footer_ids_for_request();
                foreach ( array( 'header', 'footer' ) as $slot ) {
                    $tid = isset( $tb_ids[ $slot ] ) ? absint( $tb_ids[ $slot ] ) : 0;
                    if ( ! $tid || ! htmega_is_elementor_page( $tid ) ) {
                        continue;
                    }
                    $combine_document_ids[] = $tid;
                }
            }
            $combine_document_ids = array_values( array_unique( array_filter( $combine_document_ids ) ) );
            foreach ( $combine_document_ids as $document_id ) {
                $assets_cache = new HTMega_Elementor_Assests_Cache( $document_id );
                $assets_cache->combine_ht_mega_css_files();
            }

            if ( htmega_is_editing_mode() ) {
                wp_enqueue_style( 'htmega-widgets-style' );
            }

            $regenerate_elementor_file = get_option( 'htmega_elementor_regenerate_file' );
            $previous_version = get_option( 'htmega_elementor_addons_previous_version' );

            if ( ! $regenerate_elementor_file && $previous_version ) {

                \Elementor\Plugin::$instance->files_manager->clear_cache();
                update_option( 'htmega_elementor_regenerate_file', HTMEGA_VERSION );
            }

            // One-time bust of per-page CSS cache to include 2026 section widget styles.
            // Cache files generated before the combine-system integration lack 2026 CSS.
            $cache_bust_version = '3.1.2-2026sections';
            if ( get_option( 'htmega_css_cache_bust' ) !== $cache_bust_version ) {
                $assets_cache = new HTMega_Elementor_Assests_Cache();
                $assets_cache->delete_all();
                update_option( 'htmega_css_cache_bust', $cache_bust_version, true );
            }
            
        }

        /**
         * get_promotional_widget_list function
         *
         * @return promotional_widgets list
         */
       public function get_promotional_widget_list() {
        
        $promotional_widgets = array(
            array(
				'key'       => 'htmega-info-box-addons',
				'title'      => __( 'Info Box', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-info',
				'action_url' => esc_url('https://wphtmega.com/widget/elementor-info-box-widget/'),
			),
            array(
				'key'       => 'htmega-advanced-slider-addons',
				'title'      => __( 'Advanced Slider', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-post-slider',
				'action_url' => esc_url('https://wphtmega.com/widget/elementor-advanced-slider-widget/'),
			),
            array(
				'key'       => 'htmega-background-switcher',
				'title'      => __( 'Background Switcher', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-exchange',
				'action_url' => esc_url('https://wphtmega.com/elementor-background-switcher-widget/'),
			),
            array(
				'key'        => 'htmega-breadcrumbs',
				'title'      => __( 'Breadcrumbs', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-exchange',
				'action_url' => esc_url('https://wphtmega.com/widget/elementor-breadcrumbs-widget/'),
			),
            array(
				'key'        => 'htmega-category-list-addons',
				'title'      => __( 'Category List', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-bullet-list',
				'action_url' => esc_url('https://wphtmega.com/widget/elementor-category-list-widget/'),
			),
            array(
				'key'       => 'htmega-chart-addons',
				'title'      => __( 'Chart', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon htmega-chart-img',
				'action_url' => esc_url('https://wphtmega.com/widget/elementor-chart-widget/'),
			),
            array(
				'key'       => 'htmega-dynamic-gallery-addons',
				'title'      => __( 'Dynamic Gallery', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-gallery-justified',
				'action_url' => esc_url('https://wphtmega.com/widget/elementor-dynamic-gallery-widget/'),
			),
            array(
				'key'       => 'htmega-event-box-addons',
				'title'      => __( 'Event Box', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-table-of-contents',
				'action_url' => esc_url('https://wphtmega.com/elementor-event-box-widget/'),
			),
            array(
				'key'       => 'htmega-event-calendar-addons',
				'title'      => __( 'Event Calendar', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-calendar',
				'action_url' => esc_url('https://wphtmega.com/elementor-event-calendar-widget/'),
			),
            array(
				'key'       => 'htmega-facebook-review-addons',
				'title'      => __( 'Facebook Review', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-facebook',
				'action_url' => esc_url('https://wphtmega.com/elementor-facebook-review-widget/'),
			),
            array(
				'key'       => 'htmega-feature-list-addons',
				'title'      => __( 'Feature List', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-post-list',
				'action_url' => esc_url('https://wphtmega.com/elementor-feature-list-widget/'),
			),
            array(
				'key'       => 'htmega-filterable-gallery-addons',
				'title'      => __( 'Filterable Gallery', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-gallery-justified',
				'action_url' => esc_url('https://wphtmega.com/elementor-filterable-gallery-widget/'),
			),
            array(
				'key'       => 'htmega-flip-switcher-pricing-table-addons',
				'title'      => __( 'Flip Switcher Pricing Table', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-dual-button',
				'action_url' => esc_url('https://wphtmega.com/elementor-pricing-table-flip-box-widget/'),
			),
            array(
				'key'       => 'htmega-icon-box-addons',
				'title'      => __( 'Icon Box', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-icon-box',
				'action_url' => esc_url('https://wphtmega.com/elementor-icon-box-widget/'),
			),
            array(
				'key'       => 'htmega-image-roted-addons',
				'title'      => __( 'Image Rotate', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-image-before-after',
				'action_url' => esc_url('https://wphtmega.com/'),
			),
            array(
				'key'       => 'htmega-interactive-promo-addons',
				'title'      => __( 'Interactive Promo', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-call-to-action',
				'action_url' => esc_url('https://wphtmega.com/elementor-interactive-promo-widget/'),
			),
            array(
				'key'       => 'htmega-lottie-addons',
				'title'      => __( 'Lottie', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-lottie',
				'action_url' => esc_url('https://wphtmega.com/elementor-lottie-widget/'),
			),
            array(
				'key'       => 'htmega-page-list-addons',
				'title'      => __( 'Page List', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-bullet-list',
				'action_url' => esc_url('https://wphtmega.com/elementor-page-list-widget/'),
			),
            array(
				'key'       => 'htmega-post-masonry-addons',
				'title'      => __( 'Post Masonry', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-posts-masonry',
				'action_url' => esc_url('https://wphtmega.com/elementor-post-masonry-widget/'),
			),
            array(
				'key'       => 'htmega-post-timeline-addons',
				'title'      => __( 'Post Timeline', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-time-line',
				'action_url' => esc_url('https://wphtmega.com/elementor-post-timeline-widget/'),
			),
            array(
				'key'       => 'htmega-pricing-menu-addons',
				'title'      => __( 'Pricing Menu', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-info-box',
				'action_url' => esc_url('https://wphtmega.com/widget/elementor-price-menu-widget/'),
			),
            array(
				'key'       => 'htmega-pricing-table-flip-box',
				'title'      => __( 'Pricing Table Flip Box', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-flip-box',
				'action_url' => esc_url('https://wphtmega.com/elementor-pricing-table-flip-box-widget/'),
			),
            array(
				'key'       => 'htmega-social-network-icons-addons',
				'title'      => __( 'Social Network Icons', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-social-icons',
				'action_url' => esc_url('https://wphtmega.com/widget/elementor-social-network-widget/'),
			),
            array(
				'key'       => 'htmega-source-code-addons',
				'title'      => __( 'Source Code', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-code',
				'action_url' => esc_url('https://wphtmega.com/widget/elementor-source-code-widget/'),
			),
            array(
				'key'       => 'htmega-sticky-section-addons',
				'title'      => __( 'Sticky Section', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-filter',
				'action_url' => esc_url('https://wphtmega.com/'),
			),
            array(
				'key'       => 'htmega-taxonomy-terms-addons',
				'title'      => __( 'Taxonomy Terms', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-radio',
				'action_url' => esc_url('https://wphtmega.com/widget/elementor-taxonomy-terms-widget/'),
			),
            array(
				'key'       => 'htmega-team-carousel-addons',
				'title'      => __( 'Team Carousel', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-person',
				'action_url' => esc_url('https://wphtmega.com/elementor-team-carousel-widget/'),
			),
            array(
				'key'       => 'htmega-threesixty-rotation-addons',
				'title'      => __( '360 Rotation', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon htmega-threesixty-rotation-img',
				'action_url' => esc_url('https://wphtmega.com/widget/elementor-360-rotation-widget/'),
			),
            array(
				'key'       => 'htmega-whatsapp-chat-addons',
				'title'      => __( 'WhatsApp Chat', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-commenting-o',
				'action_url' => esc_url('https://wphtmega.com/widget/elementor-whatsapp-chat-widget/'),
			),
            array(
				'key'       => 'htmega-flip-carousel-addons',
				'title'      => __( 'Flip Carousel', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-media-carousel',
				'action_url' => esc_url('https://wphtmega.com/widget/elementor-flip-carousel-widget/'),
			),

            array(
				'key'       => 'htmega-interactive-circle-infographic-addons',
				'title'      => __( 'Interactive Circle Infographic', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-integration',
				'action_url' => esc_url('https://wphtmega.com/widget/elementor-interactive-circle-infographic-widget/'),
			),
            array(
				'key'       => 'htmega-copy-coupon-code-addons',
				'title'      => __( 'Copy Coupon Code', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-copy',
				'action_url' => esc_url('https://wphtmega.com/widget/elementor-copy-coupon-code-widget/'),
			),
            array(
				'key'       => 'htmega-video-gallery-addons',
				'title'      => __( 'Video Gallery', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-media-carousel',
				'action_url' => esc_url('https://wphtmega.com/widget/elementor-video-gallery-widget/'),
			),
            array(
				'key'       => 'htmega-video-playlist-addons',
				'title'      => __( 'Video Playlist', 'ht-mega-for-elementor' ),
				'icon'       => 'htmega-icon eicon-video-playlist',
				'action_url' => esc_url('https://wphtmega.com/widget/elementor-video-playlist-widget/'),
			),

        );

        return $promotional_widgets;
       }

       public static function delete_cache( $post_id ) {
            // Delete to regenerate cache file
            $assets_cache = new HTMega_Elementor_Assests_Cache( $post_id );
            $assets_cache->delete();
        }

        public static function cache_widgets_asset( $post_id, $data ) {
            if ( ! self::is_published_post( $post_id ) ) {
                return;
            }

            // Delete to regenerate cache file
            $assets_cache = new HTMega_Elementor_Assests_Cache( $post_id );
            $assets_cache->delete();
        }

        public static function is_published_post( $post_id ) {
            return get_post_status( $post_id ) === 'publish';
        }
    }

    HTMega_Elementor_Addons_Assests::instance();

}