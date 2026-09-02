<?php
namespace HTMegaOpt\Api;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use WP_Error;

/**
 * Recommended Plugins REST handler.
 *
 * Powers the "Recommendations" tab inside the HT Mega dashboard: live wp.org
 * lookup, install-state detection, and one-click install/activate.
 *
 * Routes:
 *   GET  /htmegaopt/v1/recommended-plugins
 *   POST /htmegaopt/v1/recommended-plugins/install
 *   POST /htmegaopt/v1/recommended-plugins/activate
 */
class RecommendedPlugins {

    /**
     * REST namespace.
     *
     * @var string
     */
    protected $namespace = 'htmegaopt/v1';

    /**
     * Curated tab list — the server side source of truth and the whitelist that
     * install/activate requests are validated against. `location` is the full
     * plugin basename (slug/main-file.php) used for install-state checks.
     *
     * @return array
     */
    protected function get_tabs() {

        $woocommerce_active = class_exists( 'WooCommerce' );

        $shoplentor = array(
            'slug'     => 'woolentor-addons',
            'location' => 'woolentor-addons/woolentor_addons_elementor.php',
            'name'     => __( 'ShopLentor – WooCommerce Builder for Elementor & Gutenberg', 'ht-mega-for-elementor' ),
        );

        return array(
            array(
                'key'     => 'recommended',
                'title'   => __( 'Recommended Plugins', 'ht-mega-for-elementor' ),
                'plugins' => array_merge(
                    $woocommerce_active ? array( $shoplentor ) : array(),
                    array(
                        array(
                            'slug'     => 'support-genix-lite',
                            'location' => 'support-genix-lite/support-genix-lite.php',
                            'name'     => __( 'Support Genix – Helpdesk, AI Chatbot, Knowledge Base & Customer Support Ticketing System', 'ht-mega-for-elementor' ),
                        ),
                        array(
                            'slug'     => 'hashbar-wp-notification-bar',
                            'location' => 'hashbar-wp-notification-bar/init.php',
                            'name'     => __( 'Notification Bar for WordPress', 'ht-mega-for-elementor' ),
                        ),
                        array(
                            'slug'     => 'wp-plugin-manager',
                            'location' => 'wp-plugin-manager/plugin-main.php',
                            'name'     => __( 'WP Plugin Manager', 'ht-mega-for-elementor' ),
                        ),
                        array(
                            'slug'     => 'cookieray',
                            'location' => 'cookieray/cookieray.php',
                            'name'     => __( 'CookieRay – Cookie Banner for Cookie Consent (GDPR/CCPA Compliant)', 'ht-mega-for-elementor' ),
                        ),
                        array(
                            'slug'     => 'pixelavo',
                            'location' => 'pixelavo/pixelavo.php',
                            'name'     => __( 'Pixelavo – Server Side Tracking & Pixel + AI Ads Tools', 'ht-mega-for-elementor' ),
                        ),
                    )
                ),
            ),
            array(
                'key'     => 'woocommerce',
                'title'   => __( 'WooCommerce', 'ht-mega-for-elementor' ),
                'plugins' => array_merge(
                    $woocommerce_active ? array() : array( $shoplentor ),
                    array(
                        array(
                            'slug'     => 'whols',
                            'location' => 'whols/whols.php',
                            'name'     => __( 'Whols – Wholesale Prices and B2B Store Solution for WooCommerce', 'ht-mega-for-elementor' ),
                        ),
                        array(
                            'slug'     => 'recurio',
                            'location' => 'recurio/recurio.php',
                            'name'     => __( 'Recurio – Ultimate Subscription for WooCommerce', 'ht-mega-for-elementor' ),
                        ),
                    )
                ),
            ),
            array(
                'key'     => 'popular',
                'title'   => __( 'Popular', 'ht-mega-for-elementor' ),
                'plugins' => array(
                    array(
                        'slug'     => 'wp-plugin-manager',
                        'location' => 'wp-plugin-manager/plugin-main.php',
                        'name'     => __( 'WP Plugin Manager', 'ht-mega-for-elementor' ),
                    ),
                    array(
                        'slug'     => 'ht-easy-google-analytics',
                        'location' => 'ht-easy-google-analytics/ht-easy-google-analytics.php',
                        'name'     => __( 'HT Easy GA4 ( Google Analytics 4 )', 'ht-mega-for-elementor' ),
                    ),
                    array(
                        'slug'     => 'ht-contactform',
                        'location' => 'ht-contactform/contact-form-widget-elementor.php',
                        'name'     => __( 'HT Contact Form – Drag & Drop Form Builder for WordPress', 'ht-mega-for-elementor' ),
                    ),
                    array(
                        'slug'     => 'kelune-crm',
                        'location' => 'kelune-crm/kelune-crm.php',
                        'name'     => __( 'Kelune CRM – Contact Management, Email Marketing, Newsletter & Marketing Automation', 'ht-mega-for-elementor' ),
                    ),
                    array(
                        'slug'     => 'cookieray',
                        'location' => 'cookieray/cookieray.php',
                        'name'     => __( 'CookieRay – Cookie Banner for Cookie Consent (GDPR/CCPA Compliant)', 'ht-mega-for-elementor' ),
                    ),
                    array(
                        'slug'     => 'insert-headers-and-footers-script',
                        'location' => 'insert-headers-and-footers-script/init.php',
                        'name'     => __( 'Insert Headers and Footers Code', 'ht-mega-for-elementor' ),
                    ),
                    array(
                        'slug'     => 'courseglade-lms',
                        'location' => 'courseglade-lms/courseglade-lms.php',
                        'name'     => __( 'CourseGlade LMS – Online Course & eLearning Platform', 'ht-mega-for-elementor' ),
                    ),
                ),
            ),
        );
    }

    /**
     * Flat, deduped list of every entry across all tabs — the whitelist used to
     * validate install/activate requests.
     *
     * @return array Associative array keyed by slug.
     */
    protected function get_whitelist() {
        $whitelist = array();

        foreach ( $this->get_tabs() as $tab ) {
            foreach ( $tab['plugins'] as $plugin ) {
                $whitelist[ $plugin['slug'] ] = $plugin;
            }
        }

        return $whitelist;
    }

    /**
     * Register the routes.
     *
     * @return void
     */
    public function register_routes() {

        register_rest_route(
            $this->namespace,
            '/recommended-plugins',
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_recommended_plugins' ),
                'permission_callback' => array( $this, 'check_permission' ),
            )
        );

        register_rest_route(
            $this->namespace,
            '/recommended-plugins/install',
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'install_recommended_plugin' ),
                'permission_callback' => array( $this, 'check_install_permission' ),
            )
        );

        register_rest_route(
            $this->namespace,
            '/recommended-plugins/activate',
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'activate_recommended_plugin' ),
                'permission_callback' => array( $this, 'check_install_permission' ),
            )
        );
    }

    /**
     * Look up live wp.org data by slug (not by author account — wp.org's author
     * query filters by SVN repo ownership, which can differ from a plugin's
     * displayed author and silently miss real plugins). Cached for a week.
     *
     * @param  array $slugs Plugin slugs to look up.
     * @return array Associative array keyed by slug; unresolvable slugs are absent.
     */
    protected function get_plugins_info( $slugs ) {

        if ( empty( $slugs ) ) {
            return array();
        }

        $slugs = array_values( array_unique( $slugs ) );
        sort( $slugs ); // deterministic cache key regardless of tab order

        $transient_key = 'htmega_rp_info_' . md5( implode( ',', $slugs ) );
        $plugins_info  = get_transient( $transient_key );

        if ( false === $plugins_info ) {

            require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

            // One blocking wp.org call per slug (~1s each; wp.org has no batch
            // lookup endpoint), which can exceed a shared host's default
            // max_execution_time. Raise it for this request only.
            if ( function_exists( 'set_time_limit' ) ) {
                set_time_limit( max( 60, (int) ini_get( 'max_execution_time' ) ) );
            }

            $plugins_info = array();

            foreach ( $slugs as $slug ) {
                $plugin_info = plugins_api(
                    'plugin_information',
                    array(
                        'slug'   => $slug,
                        'fields' => array(
                            'short_description' => true,
                            'sections'          => false,
                            'icons'             => true,
                            'active_installs'   => true,
                            'author'            => true,
                            'versions'          => false,
                            'ratings'           => false,
                            'reviews'           => false,
                            'banners'           => false,
                            'compatibility'     => false,
                            'homepage'          => false,
                            'donate_link'       => false,
                            'tags'              => false,
                        ),
                    )
                );

                if ( is_wp_error( $plugin_info ) ) {
                    continue; // not on wp.org — falls back to the curated name
                }

                $icons = (array) $plugin_info->icons;

                $plugins_info[ $slug ] = array(
                    'name'            => html_entity_decode( $plugin_info->name, ENT_QUOTES, 'UTF-8' ),
                    'description'     => html_entity_decode( wp_strip_all_tags( $plugin_info->short_description ), ENT_QUOTES, 'UTF-8' ),
                    'author'          => html_entity_decode( wp_strip_all_tags( $plugin_info->author ), ENT_QUOTES, 'UTF-8' ),
                    'active_installs' => $plugin_info->active_installs,
                    'icon'            => ! empty( $icons['svg'] ) ? $icons['svg'] : ( ! empty( $icons['2x'] ) ? $icons['2x'] : ( ! empty( $icons['1x'] ) ? $icons['1x'] : ( isset( $icons['default'] ) ? $icons['default'] : '' ) ) ),
                );
            }

            set_transient( $transient_key, $plugins_info, WEEK_IN_SECONDS );
        }

        return $plugins_info;
    }

    /**
     * GET handler — curated tabs merged with live wp.org data + install state.
     *
     * @return WP_REST_Response
     */
    public function get_recommended_plugins() {

        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $tabs              = $this->get_tabs();
        $live_info         = $this->get_plugins_info( array_keys( $this->get_whitelist() ) );
        $installed_plugins = get_plugins();
        $response_tabs     = array();

        foreach ( $tabs as $tab ) {
            $items = array();

            foreach ( $tab['plugins'] as $plugin ) {
                $info = isset( $live_info[ $plugin['slug'] ] ) ? $live_info[ $plugin['slug'] ] : array();

                $status = 'not_installed';
                if ( isset( $installed_plugins[ $plugin['location'] ] ) ) {
                    $status = is_plugin_active( $plugin['location'] ) ? 'active' : 'inactive';
                }

                $items[] = array(
                    'slug'            => $plugin['slug'],
                    'location'        => $plugin['location'],
                    'name'            => ! empty( $info['name'] ) ? $info['name'] : $plugin['name'],
                    'description'     => isset( $info['description'] ) ? $info['description'] : '',
                    'author'          => isset( $info['author'] ) ? $info['author'] : '',
                    'icon'            => isset( $info['icon'] ) ? $info['icon'] : '',
                    'active_installs' => isset( $info['active_installs'] ) ? $info['active_installs'] : null,
                    'details_link'    => self_admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $plugin['slug'] . '&TB_iframe=true&width=772&height=577' ),
                    // Only linked when the wp.org lookup actually resolved, so an entry
                    // that isn't on wp.org renders as plain text instead of a dead link.
                    'wporg_url'       => ! empty( $info ) ? 'https://wordpress.org/plugins/' . $plugin['slug'] . '/' : '',
                    'status'          => $status,
                );
            }

            $response_tabs[] = array(
                'key'     => $tab['key'],
                'title'   => $tab['title'],
                'plugins' => $items,
            );
        }

        return new WP_REST_Response( array( 'tabs' => $response_tabs ), 200 );
    }

    /**
     * POST handler — install a whitelisted plugin from wp.org, then activate it.
     *
     * @param  WP_REST_Request $request
     * @return WP_REST_Response|WP_Error
     */
    public function install_recommended_plugin( WP_REST_Request $request ) {

        $slug      = sanitize_text_field( (string) $request->get_param( 'slug' ) );
        $whitelist = $this->get_whitelist();

        if ( empty( $slug ) || ! isset( $whitelist[ $slug ] ) ) {
            return new WP_Error( 'htmega_invalid_plugin', __( 'This plugin is not in the recommended list.', 'ht-mega-for-elementor' ), array( 'status' => 400 ) );
        }

        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/misc.php';
        require_once ABSPATH . 'wp-admin/includes/template.php';
        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php';

        $api = plugins_api( 'plugin_information', array( 'slug' => $slug, 'fields' => array( 'sections' => false ) ) );

        if ( is_wp_error( $api ) ) {
            return new WP_Error( 'htmega_plugin_not_found', __( 'Plugin not found on WordPress.org.', 'ht-mega-for-elementor' ), array( 'status' => 404 ) );
        }

        $skin     = new \WP_Ajax_Upgrader_Skin();
        $upgrader = new \Plugin_Upgrader( $skin );
        $result   = $upgrader->install( $api->download_link );

        if ( is_wp_error( $result ) ) {
            return new WP_Error( 'htmega_install_failed', $result->get_error_message(), array( 'status' => 500 ) );
        }

        if ( is_wp_error( $skin->result ) ) {
            return new WP_Error( 'htmega_install_failed', $skin->result->get_error_message(), array( 'status' => 500 ) );
        }

        if ( $skin->get_errors()->has_errors() ) {
            return new WP_Error( 'htmega_install_failed', $skin->get_error_messages(), array( 'status' => 500 ) );
        }

        $plugin_location = $upgrader->plugin_info();

        if ( ! $plugin_location ) {
            return new WP_Error( 'htmega_install_failed', __( 'Could not determine the installed plugin file.', 'ht-mega-for-elementor' ), array( 'status' => 500 ) );
        }

        $activate_result = activate_plugin( $plugin_location );

        if ( is_wp_error( $activate_result ) ) {
            return new WP_Error( 'htmega_activate_failed', $activate_result->get_error_message(), array( 'status' => 500 ) );
        }

        return new WP_REST_Response(
            array(
                'success'  => true,
                'location' => $plugin_location,
                'status'   => 'active',
            ),
            200
        );
    }

    /**
     * POST handler — activate an already installed whitelisted plugin.
     *
     * @param  WP_REST_Request $request
     * @return WP_REST_Response|WP_Error
     */
    public function activate_recommended_plugin( WP_REST_Request $request ) {

        $location  = sanitize_text_field( (string) $request->get_param( 'location' ) );
        $whitelist = $this->get_whitelist();

        $is_whitelisted = false;
        foreach ( $whitelist as $plugin ) {
            if ( $plugin['location'] === $location ) {
                $is_whitelisted = true;
                break;
            }
        }

        if ( empty( $location ) || ! $is_whitelisted ) {
            return new WP_Error( 'htmega_invalid_plugin', __( 'This plugin is not in the recommended list.', 'ht-mega-for-elementor' ), array( 'status' => 400 ) );
        }

        require_once ABSPATH . 'wp-admin/includes/plugin.php';

        if ( ! file_exists( WP_PLUGIN_DIR . '/' . $location ) ) {
            return new WP_Error( 'htmega_plugin_not_found', __( 'Plugin is not installed.', 'ht-mega-for-elementor' ), array( 'status' => 404 ) );
        }

        $result = activate_plugin( $location );

        if ( is_wp_error( $result ) ) {
            return new WP_Error( 'htmega_activate_failed', $result->get_error_message(), array( 'status' => 500 ) );
        }

        return new WP_REST_Response( array( 'success' => true, 'status' => 'active' ), 200 );
    }

    /**
     * Read permission.
     *
     * @return bool
     */
    public function check_permission() {
        return current_user_can( 'manage_options' );
    }

    /**
     * Install / activate permission.
     *
     * @return bool
     */
    public function check_install_permission() {
        return current_user_can( 'manage_options' ) && current_user_can( 'install_plugins' ) && current_user_can( 'activate_plugins' );
    }
}
