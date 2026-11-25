<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
* Icon render
*/
class HTMega_Icon_manager extends Icons_Manager{

    private static function render_svg_icon( $value ) {
        if ( ! isset( $value['id'] ) ) {
            return '';
        }
        return \Elementor\Core\Files\File_Types\Svg::get_inline_svg( $value['id'] );
    }

    private static function render_icon_html( $icon, $attributes = [], $tag = 'i' ) {
        $icon_types = self::get_icon_manager_tabs();
        if ( isset( $icon_types[ $icon['library'] ]['render_callback'] ) && is_callable( $icon_types[ $icon['library'] ]['render_callback'] ) ) {
            return call_user_func_array( $icon_types[ $icon['library'] ]['render_callback'], [ $icon, $attributes, $tag ] );
        }

        if ( empty( $attributes['class'] ) ) {
            $attributes['class'] = $icon['value'];
        } else {
            if ( is_array( $attributes['class'] ) ) {
                $attributes['class'][] = $icon['value'];
            } else {
                $attributes['class'] .= ' ' . $icon['value'];
            }
        }
        return '<' . $tag . ' ' . Utils::render_html_attributes( $attributes ) . '></' . $tag . '>';
    }

    /**
     * Allow-list the icon value so a user-supplied string can never carry markup.
     * Font icon values are CSS class names (e.g. "fas fa-arrow-left"), so only
     * letters, digits, space, underscore and hyphen are kept. SVG library values
     * are arrays (attachment id + url) and are left untouched.
     */
    public static function sanitize_icon( $icon ) {
        if ( ! is_array( $icon ) ) {
            return [ 'value' => '', 'library' => '' ];
        }
        if ( isset( $icon['value'] ) && is_string( $icon['value'] ) ) {
            $icon['value'] = trim( preg_replace( '/[^A-Za-z0-9_\- ]/', '', $icon['value'] ) );
        }
        if ( isset( $icon['library'] ) ) {
            $icon['library'] = is_string( $icon['library'] ) ? preg_replace( '/[^A-Za-z0-9_\-]/', '', $icon['library'] ) : '';
        }
        return $icon;
    }

    public static function render_icon( $icon, $attributes = [], $tag = 'i' ) {
        $icon = self::sanitize_icon( $icon );
        if ( empty( $icon['value'] ) ) {
            return '';
        }
        ob_start();
        Icons_Manager::render_icon( $icon, $attributes, $tag );

        $icon_html = ob_get_clean();
        return $icon_html;
    }

}