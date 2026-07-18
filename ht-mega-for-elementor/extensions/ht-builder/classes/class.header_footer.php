<?php

namespace HTMega_Builder\Elementor\HeaderFooter;
use Elementor\Plugin as Elementor;
use Elementor\Controls_Manager;
use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
*  HT Builder Header and Footer
*/
class HTMegaBuilder_Header_Footer{

    public $header_id = '';
    public $footer_id = '';

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    function __construct(){

        // Theme Support
        add_action( 'after_setup_theme', [ $this, 'theme_setup' ] );

        // Register Control Document
        add_action( 'elementor/documents/register_controls', [ $this, 'add_elementor_page_settings_controls'], 10, 1 );

        // Init Hook in wp
        add_action( 'wp', [ $this, 'init' ] );
    }

    /*
    * WP Hooks Init
    */
    public function init() {

        // Header Id
        if( !empty( htmega_get_elementor_setting( 'htmegaheader_template', get_the_ID() ) ) ){
            $this->header_id = htmega_get_elementor_setting( 'htmegaheader_template', get_the_ID() );
        }else{
            $this->header_id = htmega_get_module_option( 'htmega_themebuilder_module_settings', 'themebuilder', 'header_page' ) ? htmega_get_module_option( 'htmega_themebuilder_module_settings', 'themebuilder', 'header_page' ) : htmega_get_option( 'header_page', 'htmegabuilder_templatebuilder_tabs', '0' );
        }

        // Footer id
        if( !empty( htmega_get_elementor_setting( 'htmegafooter_template', get_the_ID() ) ) ){
            $this->footer_id = htmega_get_elementor_setting( 'htmegafooter_template', get_the_ID() );
        }else{
            $this->footer_id = htmega_get_module_option( 'htmega_themebuilder_module_settings', 'themebuilder', 'footer_page' ) ? htmega_get_module_option( 'htmega_themebuilder_module_settings', 'themebuilder', 'footer_page' ) : htmega_get_option( 'footer_page', 'htmegabuilder_templatebuilder_tabs', '0' );
        }

        // Content Hooks
        add_action( 'htmegabuilder_header_content', [ $this, 'header_content_elementor' ], 999999 );
        add_action( 'htmegabuilder_footer_content', [ $this, 'footer_content_elementor' ], 999999 );

        // Header Template Ovewrite
        if ( ! empty( $this->header_id ) ) {
            add_action( 'get_header', [ $this, 'get_header' ] );
        }

        // Footer Template Ovewrite
        if( ! empty( $this->footer_id )  ){
            add_action( 'get_footer', [ $this, 'get_footer' ] );
        }

        // Elementor only generates atomic-widget CSS for the main queried post; register
        // the header/footer templates before that one-shot pass so their atomic styles aren't skipped.
        if ( ! empty( $this->header_id ) || ! empty( $this->footer_id ) ) {
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_atomic_styles_for_header_footer_templates' ], 15 );
        }

        /*
         * Block (FSE) themes render header/footer via core/template-part, not get_header()/get_footer().
         */
        if ( function_exists( 'wp_is_block_theme' ) && wp_is_block_theme() && ( ! empty( $this->header_id ) || ! empty( $this->footer_id ) ) ) {
            add_filter( 'render_block', [ $this, 'filter_render_block_template_part' ], 10, 2 );
        }

    }

    /*
    * Elementor Page Document Setting Add
    */
    public function add_elementor_page_settings_controls( $header ) {

        $header->start_controls_section(
            'htmega_section_header_footer',
            [
                'label' => __( 'HT Header & Footer', 'htmega-addons' ),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

            $header->add_control(
                'htmegaheader_template',
                [
                    'label' => __( 'Header Template', 'htmega-addons' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '0',
                    'options' => htmega_elementor_template(),
                    'label_block'=>true,
                ]
            );

            $header->add_control(
                'htmegafooter_template',
                [
                    'label' => __( 'Footer Template', 'htmega-addons' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '0',
                    'options' => htmega_elementor_template(),
                    'label_block'=>true,
                    'separator'=>'before',
                ]
            );

        $header->end_controls_section();

    }

    /*
    * After Theme Setup
    */
    public function theme_setup() {
        add_theme_support( 'custom-logo', array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ) );
    }

    /*
    * Header Content Overwrite to Custom template.
    */
    public function get_header( $name ) {
        require ( HTMEGA_ADDONS_PL_PATH.'extensions/ht-builder/templates/theme-header.php' );

        $templates = [];
        $name = (string) $name;
        if ( '' !== $name ) {
            $templates[] = "header-{$name}.php";
        }
        $templates[] = 'header.php';

        /*
         * theme-header.php already ran wp_head(). Buffered locate_template() pulls theme header.php, which calls
         * wp_head() again — duplicate enqueues/order bugs unless callbacks are cleared first.
         */
        remove_all_actions( 'wp_head' );
        ob_start();
        // Overwrite All Header Templates.
        locate_template( $templates, true );
        ob_get_clean();
    }

    /*
    * Footer Content Overwrite to Custom Template.
    */
    public function get_footer( $name ) {
        require ( HTMEGA_ADDONS_PL_PATH.'extensions/ht-builder/templates/theme-footer.php' );

        $templates = [];
        $name = (string) $name;
        if ( '' !== $name ) {
            $templates[] = "footer-{$name}.php";
        }
        $templates[] = 'footer.php';

        ob_start();
        // Overwrite All Footer Templates.
        locate_template( $templates, true );
        ob_get_clean();
    }

    /**
     * Register header/footer Elementor templates with Elementor's atomic-widget CSS pipeline
     * before its own single per-request enqueue pass runs (Frontend::enqueue_styles(),
     * hooked at wp_enqueue_scripts priority 20). That pass fires
     * 'elementor/frontend/after_enqueue_post_styles' unconditionally on every request, which
     * is what actually triggers the atomic CSS generation for every post id registered via
     * 'elementor/post/render' so far — so we only need to register our template ids here
     * (priority 15, before Elementor's own priority 20 pass), not force-run enqueue_styles()
     * ourselves. Calling enqueue_styles() directly would trip its internal static one-shot
     * guard and race with any other extension (e.g. the mega menu) doing the same, silently
     * dropping whichever extension's ids weren't registered yet at that moment.
     */
    public function enqueue_atomic_styles_for_header_footer_templates() {
        if ( is_admin() || ! class_exists( '\Elementor\Plugin' ) ) {
            return;
        }

        $template_ids = array_unique( array_filter( [ absint( $this->header_id ), absint( $this->footer_id ) ] ) );
        if ( empty( $template_ids ) ) {
            return;
        }

        foreach ( $template_ids as $template_id ) {
            do_action( 'elementor/post/render', $template_id );
        }
    }

    /*
    * Render Elementor Header Content
    */
    public function header_content_elementor() {
        $templateid = $this->header_id;
        if( !empty( $templateid ) ){
            echo htmega_get_template_content_by_id( $templateid );// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }

    /* 
    * Render Elementor Header Content
    */
    public function footer_content_elementor() {
        $templateid = $this->footer_id;
        if( !empty( $templateid ) ){
            echo htmega_get_template_content_by_id( $templateid ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }

    /**
     * Replace core/template-part output for header/footer on block themes.
     *
     * @param string $block_content Rendered block HTML.
     * @param array  $block         Parsed block (blockName, attrs, …).
     * @return string
     */
    public function filter_render_block_template_part( $block_content, $block ) {
        if ( is_admin() || empty( $block['blockName'] ) || 'core/template-part' !== $block['blockName'] ) {
            return $block_content;
        }

        $attrs = isset( $block['attrs'] ) && is_array( $block['attrs'] ) ? $block['attrs'] : [];

        if ( ! empty( $this->header_id ) && $this->is_block_theme_header_template_part( $attrs ) ) {
            return $this->get_block_theme_part_wrapper( 'header', $attrs );
        }

        if ( ! empty( $this->footer_id ) && $this->is_block_theme_footer_template_part( $attrs ) ) {
            return $this->get_block_theme_part_wrapper( 'footer', $attrs );
        }

        return $block_content;
    }

    /**
     * @param array $attrs core/template-part block attributes.
     */
    private function is_block_theme_header_template_part( array $attrs ) {
        if ( ! empty( $attrs['area'] ) && 'header' === $attrs['area'] ) {
            return true;
        }
        if ( ! empty( $attrs['slug'] ) && 'header' === $attrs['slug'] ) {
            return true;
        }
        return false;
    }

    /**
     * @param array $attrs core/template-part block attributes.
     */
    private function is_block_theme_footer_template_part( array $attrs ) {
        if ( ! empty( $attrs['area'] ) && 'footer' === $attrs['area'] ) {
            return true;
        }
        if ( ! empty( $attrs['slug'] ) && 'footer' === $attrs['slug'] ) {
            return true;
        }
        return false;
    }

    /**
     * @param string $which 'header'|'footer'.
     * @param array  $attrs Block attrs (tagName from theme).
     */
    private function get_block_theme_part_wrapper( $which, array $attrs ) {
        ob_start();
        if ( 'header' === $which ) {
            do_action( 'htmegabuilder_header_content' );
        } else {
            do_action( 'htmegabuilder_footer_content' );
        }
        $inner = ob_get_clean();

        $tag = 'div';
        if ( ! empty( $attrs['tagName'] ) && is_string( $attrs['tagName'] ) ) {
            $tn = strtolower( $attrs['tagName'] );
            if ( preg_match( '/^[a-z][a-z0-9_-]*$/', $tn ) ) {
                $tag = $tn;
            }
        } elseif ( 'header' === $which ) {
            $tag = 'header';
        } elseif ( 'footer' === $which ) {
            $tag = 'footer';
        }

        $class = ( 'header' === $which ) ? 'htmega-tb-block-header' : 'htmega-tb-block-footer';

        return sprintf(
            '<%1$s class="%2$s">%3$s</%1$s>',
            esc_attr( $tag ),
            esc_attr( $class ),
            $inner
        ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — inner is Elementor HTML.
    }

}

HTMegaBuilder_Header_Footer::instance();