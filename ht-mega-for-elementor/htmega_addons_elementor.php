<?php
/**
 * Plugin Name: HT Mega Addons for Elementor - Elementor Widgets & Template Builder
 * Description: Elementor addon offering 146+ widgets, AI Builder, Mega Menu, Ready Templates, Page Builder, Slider, Gallery, Post Grid & more.
 * Plugin URI: 	https://wphtmega.com/
 * Author: 		HasThemes
 * Author URI: 	https://hasthemes.com/
 * Version: 	3.2.5
 * License:     GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ht-mega-for-elementor
 * Domain Path: /languages
 * Elementor tested up to: 4.2.4
 * Elementor Pro tested up to: 4.2.3
 * Requires Plugins: elementor
*/
if( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly
define( 'HTMEGA_VERSION', '3.2.5' );
define( 'HTMEGA_ADDONS_PL_ROOT', __FILE__ );
define( 'HTMEGA_ADDONS_PL_URL', plugins_url( '/', HTMEGA_ADDONS_PL_ROOT ) );
define( 'HTMEGA_ADDONS_PL_PATH', plugin_dir_path( HTMEGA_ADDONS_PL_ROOT ) );
define( 'HTMEGA_ADDONS_PLUGIN_BASE', plugin_basename( HTMEGA_ADDONS_PL_ROOT ) );


/**
 * Gutenberg Blocks
 */
require_once ( HTMEGA_ADDONS_PL_PATH.'htmega-blocks/htmega-blocks.php' );

// Required File
require_once ( HTMEGA_ADDONS_PL_PATH .'includes/class.htmega.php' );
htmega();