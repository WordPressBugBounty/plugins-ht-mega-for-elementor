<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * [htmegaopt_data_clean] clean array data
 *
 * @param [array] $var
 * @return void
 */
if ( ! function_exists( 'htmegaopt_data_clean' ) ) {
function htmegaopt_data_clean( $var ) {
    if ( is_array( $var ) ) {
        return array_map( 'htmegaopt_data_clean', $var );
    } else {
        return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
    }
}
}

/**
 * Get Options Value
 *
 * @param [type] $key
 * @param [type] $section
 * @param boolean $default
 * @return void
 */
if ( ! function_exists( 'htmegaopt_get_option' ) ) {
function htmegaopt_get_option( $key, $section, $default = false ){
    $options = get_option( $section );
    if ( isset( $options['blocks'] ) && isset( $options['blocks'][$key] ) ) {
        $value = $options['blocks'][$key];
    }elseif ( isset( $options[$key] ) ) {
        $value = $options[$key];
    }else{
        $value = $default;
    }
    return apply_filters( 'htmegaopt' . '_get_option_' . $key, $value, $key, $default );
}
}

/**
 * Get Option value Section wise
 *
 * @param [array] $registered_settings
 * @return void
 */
if ( ! function_exists( 'htmegaopt_get_options' ) ) {
function htmegaopt_get_options( $registered_settings = [] ) {
    if( ! is_array( $registered_settings ) ){
        return;
    }
    $settings = [];
    $options = [];
    foreach ( $registered_settings as $section_key => $setting_section ) {
        foreach ( $setting_section as $key => $setting ) {
            if( $key === 'blocks' ) {
                foreach ( $setting as $block ) {
                    $default                   = $block['default'];
                    $options['blocks'][$block['id']] = htmegaopt_get_option( $block['id'], $section_key, $default );
                }
            } else {

                if( isset( $setting['section'] ) ){
                    $options2 = [];
                    foreach ($setting['setting_fields'] as $key => $sub_setting ) {
                        $default = isset( $sub_setting['std'] ) ? $sub_setting['std'] : ( isset( $sub_setting['default'] ) ? $sub_setting['default'] : '' );
                        $options2[ $sub_setting['id']] = htmega_get_module_option( $setting['section'], $setting['id'], $sub_setting['id'], $default );
                    } 
    
                    $settings[$setting['section']] = $options2;
                    $options2 = [];
                }else{
                    $default                   = isset( $setting['std'] ) ? $setting['std'] : ( isset( $setting['default'] ) ? $setting['default'] : '' );
                    $options[ $setting['id'] ] = htmegaopt_get_option( $setting['id'], $section_key, $default );
                }
            }
        }
        $settings[$section_key] = $options;
        $options = [];
    }
    return apply_filters( 'htmegaopt' . '_get_settings', $settings );

}
}
/**
 * NOTE: get_elements_list(), get_modules_list(), and extractElementData() were previously
 * duplicated here as bare global functions, left behind after this logic was moved into
 * Onboarding::get_elements_list() / ::get_modules_list() / ::extractElementData(). They were
 * never called anywhere as bare functions (confirmed: only Onboarding's own `$this->...()`
 * calls exist, which resolve to the class methods). The global get_elements_list()/
 * get_modules_list() versions also referenced `$this` outside any object context, so calling
 * them directly would have fatal-errored. Removed as dead, unreachable code.
 */
add_action( 'wp_ajax_htmega_get_sidebar_content', 'htmega_get_sidebar_content' );
    /**
     * AJAX handler for getting sidebar banner content
     */
     function htmega_get_sidebar_content() {
        try {
            // Prevent any unwanted output
            @error_reporting(0); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.prevent_path_disclosure_error_reporting -- disables (not enables) error display for this AJAX handler only, to stop a stray notice/warning from an unrelated plugin/theme corrupting the JSON response body.
            @ini_set('display_errors', 0); // phpcs:ignore Squiz.PHP.DiscouragedFunctions.Discouraged -- same reasoning as above; scoped to this request only, restores nothing globally.

            if (!current_user_can('manage_options')) {
                wp_send_json_error(array('message' => 'Unauthorized access'));
                return;
            }

            // Include required dependencies
            if (!function_exists('is_plugin_active')) {
                require_once ABSPATH . 'wp-admin/includes/plugin.php';
            }

            // Start output buffering
            ob_start();
            
            // Include the template
            $template_path = HTMEGA_ADDONS_PL_PATH . 'admin/include/settings-panel/includes/templates/sidebar-banner.php';
            
            if (!file_exists($template_path)) {
                wp_send_json_error(array('message' => esc_html__('Template file not found', 'ht-mega-for-elementor')));
                return;
            }

            // Include template and get content
            include $template_path;
            $content = ob_get_clean();

            // Clean any unwanted output
            while (ob_get_level()) {
                ob_end_clean();
            }

            if (empty($content)) {
                wp_send_json_error(array('message' => esc_html__('Empty content', 'ht-mega-for-elementor')));
                return;
            }

            // Send JSON response
            wp_send_json_success(array(
                'content' => $content
            ));

        } catch (Exception $e) {
            wp_send_json_error(array('message' => $e->getMessage()));
        }
    }