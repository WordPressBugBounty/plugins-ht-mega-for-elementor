<?php

namespace HtMega\Preset;

defined( 'ABSPATH' ) || die();

class Preset_Manage {
    public static function init() {
        add_action( 'wp_ajax_htmega_preset_design', [ __CLASS__, 'get_preset_design' ] );
    }

    public static function get_preset_design(){

        if ( ! isset( $_GET['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['nonce'] ) ), 'htmega_preset_select' ) ) {
            wp_send_json_error( __( 'Invalid preset request', 'ht-mega-for-elementor' ), 403 );
        }

        if ( empty( $_GET['widget'] ) ) {
            wp_send_json_error( __( 'Incomplete preset request', 'ht-mega-for-elementor' ), 404 );
        }

        $widget = sanitize_text_field( wp_unslash( $_GET['widget'] ) );

        if ( ! ( $preset_designs = self::get_presets_option( $widget ) ) ) {
            wp_send_json_error( __( 'Preset not found', 'ht-mega-for-elementor' ), 404 );
        }

        wp_send_json_success( $preset_designs, 200 );

        die();
    }

    protected static function get_presets_option($presete_name) {
        $preset_path = HTMEGA_ADDONS_PL_PATH . 'admin/assets/presets/' . sanitize_file_name( $presete_name ) . '.json'; 
    
        if (htmega_is_pro_active()) {
            if (!file_exists($preset_path)) {
                $preset_path = HTMEGA_ADDONS_PL_PATH_PRO . 'assets/preset-json/' . sanitize_file_name( $presete_name ) . '.json';
            }
        }

        return htmega_get_local_file_data( $preset_path );
    }
    
}

Preset_Manage::init();