<?php
/**
 * Constructor Parameters
 *
 * @param string    $text_domain your plugin text domain.
 * @param string    $parent_menu_slug the menu slug name where the "Recommendations" submenu will appear.
 * @param string    $submenu_label To change the submenu name.
 * @param string    $submenu_page_name an unique page name for the submenu.
 * @param int       $priority Submenu priority adjust.
 * @param string    $hook_suffix use it to load this library assets only to the recommedded plugins page. Not into the whol admin area.
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( class_exists('Hasthemes\HTMega_Builder\HTRP_Recommended_Plugins') ){
    $recommendations = new Hasthemes\HTMega_Builder\HTRP_Recommended_Plugins(
        array( 
            'text_domain'       => 'htmega-addons',
            'parent_menu_slug'  => 'htmega-addons', 
            'menu_capability'   => 'manage_options', 
            'menu_page_slug'    => '',
            'priority'          => 300,
            'assets_url'        => '',
            'hook_suffix'       => 'htmega-addons_page_htmega-addons_extensions',
        )
    );

    add_action('init', function() use ($recommendations) {
        $recommendations->add_new_tab(array(
            'title' => __( 'Recommended Plugins', 'ht-mega-for-elementor' ),
            'active' => true,
            'plugins' => array(
                array(
                    'slug'      => 'woolentor-addons',
                    'location'  => 'woolentor_addons_elementor.php',
                    'name'      => __( 'ShopLentor – WooCommerce Builder for Elementor & Gutenberg +10 Modules – All in One Solution (formerly WooLentor)', 'ht-mega-for-elementor' )
                ),
                array(
                    'slug'      => 'support-genix-lite',
                    'location'  => 'support-genix-lite.php',
                    'name'      => __( 'Support Genix – Helpdesk, AI Chatbot, Knowledge Base & Customer Support Ticketing System', 'ht-mega-for-elementor' )
                ),
                array(
                    'slug'      => 'hashbar-wp-notification-bar',
                    'location'  => 'init.php',
                    'name'      => __( 'Notification Bar for WordPress', 'ht-mega-for-elementor' )
                ),
                array(
                    'slug'      => 'wp-plugin-manager',
                    'location'  => 'plugin-main.php',
                    'name'      => __( 'WP Plugin Manager', 'ht-mega-for-elementor' )
                ),
                array(
                    'slug'      => 'cookieray',
                    'location'  => 'cookieray.php',
                    'name'      => __( 'CookieRay – Cookie Banner for Cookie Consent (GDPR/CCPA Compliant)', 'ht-mega-for-elementor' )
                ),
                array(
                    'slug'      => 'pixelavo',
                    'location'  => 'pixelavo.php',
                    'name'      => __( 'Pixelavo – Server Side Tracking & Pixel + AI Ads Tools', 'ht-mega-for-elementor' )
                ),
            )
        ));

        $recommendations->add_new_tab(array(
            'title' => esc_html__( 'WooCommerce', 'ht-mega-for-elementor' ),

            'plugins' => array(

                array(
                    'slug'      => 'woolentor-addons',
                    'location'  => 'woolentor_addons_elementor.php',
                    'name'      => __( 'WooLentor – WooCommerce Elementor Addons + Builder', 'ht-mega-for-elementor' )
                ),
                array(
                    'slug'      => 'whols',
                    'location'  => 'whols.php',
                    'name'      => __( 'Whols', 'ht-mega-for-elementor' )
                ),

            )

        ));

        $recommendations->add_new_tab(array(
            'title' => esc_html__( 'Other Plugins', 'ht-mega-for-elementor' ),
            'plugins' => array(
                array(
                    'slug'      => 'wp-plugin-manager',
                    'location'  => 'plugin-main.php',
                    'name'      => __( 'WP Plugin Manager', 'ht-mega-for-elementor' )
                ),
                array(
                    'slug'      => 'ht-easy-google-analytics',
                    'location'  => 'ht-easy-google-analytics.php',
                    'name'      => __( 'HT Easy GA4 ( Google Analytics 4 )', 'ht-mega-for-elementor' )
                ),
                array(
                    'slug'      => 'ht-contactform',
                    'location'  => 'contact-form-widget-elementor.php',
                    'name'      => __( 'HT Contact Form 7', 'ht-mega-for-elementor' )
                ),
                array(
                    'slug'      => 'ht-wpform',
                    'location'  => 'wpform-widget-elementor.php',
                    'name'      => __( 'HT WPForms', 'ht-mega-for-elementor' )
                ),
                array(
                    'slug'      => 'cookieray',
                    'location'  => 'cookieray.php',
                    'name'      => __( 'CookieRay – Cookie Banner for Cookie Consent (GDPR/CCPA Compliant)', 'ht-mega-for-elementor' )
                ),
                array(
                    'slug'      => 'recurio',
                    'location'  => 'recurio.php',
                    'name'      => __( 'Recurio – Ultimate Subscription for WooCommerce', 'ht-mega-for-elementor' )
                ),
                array(
                    'slug'      => 'insert-headers-and-footers-script',
                    'location'  => 'init.php',
                    'name'      => __( 'Insert Headers and Footers Code', 'ht-mega-for-elementor' )
                ),
                array(
                    'slug'      => 'extensions-for-cf7',
                    'location'  => 'extensions-for-cf7.php',
                    'name'      => __( 'Extensions For CF7 (Contact form 7 Database, Conditional Fields and Redirection)', 'ht-mega-for-elementor' )
                ),
                array(
                    'slug'      => 'courseglade-lms',
                    'location'  => 'courseglade-lms.php',
                    'name'      => __( 'ECourseGlade LMS – Online Course & eLearning Platform', 'ht-mega-for-elementor' )
                )

            )
        ));
    });
}
