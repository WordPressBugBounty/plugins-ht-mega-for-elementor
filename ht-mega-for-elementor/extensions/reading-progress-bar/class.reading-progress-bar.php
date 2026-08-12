<?php 
namespace HTMega_Reading_Progress_Bar;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMegaReadingProgressBar_Elementor {

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
	
    public function __construct() {
		add_action('elementor/documents/register_controls', [ $this, 'register_controls' ], 10);
        add_action('wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }
	/**
	 * Enqueue scripts.
	 *
	 * Enqueue required JS dependencies for the extension.
	 *
	 * @since 2.2.5
	 * @access public
	 */
	public static function enqueue_scripts() {
        if ( function_exists( 'htmega_should_enqueue_global_assets' ) && ! htmega_should_enqueue_global_assets() ) {
            return;
        }

        $htmega_rpbar_module_settings = htmega_get_option( 'htmega_rpbar', 'htmega_rpbar_module_settings' );
        $htmega_rpbar_module_settings = json_decode( $htmega_rpbar_module_settings, true );

        $rpbar_global = isset( $htmega_rpbar_module_settings['rpbar_global'] ) ? $htmega_rpbar_module_settings['rpbar_global'] : 'off';

        // Enqueue js and css for individual page 
        $htmega_rpbar_enable = htmega_get_elementor_option( 'htmega_rpbar_enable', get_the_ID() );
        $htmega_rpbar_disable = htmega_get_elementor_option( 'htmega_rpbar_disable', get_the_ID() );

        if( ( isset( $htmega_rpbar_enable ) &&  'yes' == $htmega_rpbar_enable ) ) {
            wp_enqueue_script( 'htmega-rpbar-script');
            wp_enqueue_style( 'htmega-rpbar-css');
        }
        if( ( isset( $htmega_rpbar_disable ) &&  'yes' == $htmega_rpbar_disable )  && 'on' == $rpbar_global ) {
            wp_dequeue_script( 'htmega-rpbar-script');
            wp_dequeue_script( 'htmega-rpbar-css');
        }
	}

	/**
	 * Register Reading progress bar controls.
	 *
	 * @since 2.2.5
	 * @access public
	 * @param object $element for current element.
	 */
	public function register_controls( $element ) {

        $htmega_rpbar_module_settings = htmega_get_option( 'htmega_rpbar', 'htmega_rpbar_module_settings' );
        $htmega_rpbar_module_settings = json_decode( $htmega_rpbar_module_settings, true );

		$tabs = Controls_Manager::TAB_SETTINGS;

		$element->start_controls_section(
			'section_htmega_rpbar_section',
			array(
				'label' => __( 'HTMega Reading Progress Bar', 'ht-mega-for-elementor' ),
				'tab'   => $tabs,
			)
		);

        // Sitewide auto-enable (pro-only) injects its own "Disable for this page"
        // control here via Elementor's start_injection/end_injection API — see
        // htmega-pro/extensions/reading-progress-bar/class.reading-progress-bar-pro.php
        $element->add_control(
            'htmega_rpbar_enable',
            [
                'label' =>  __('Enable Reading Progress Bar', 'ht-mega-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => __('Yes', 'ht-mega-for-elementor'),
                'label_off' => __('No', 'ht-mega-for-elementor'),
                'return_value' => 'yes',
            ]
        );
        $element->add_control(
            'htmega_rpbar_notice',
            [
                'raw'             => __( 'The <b>Reading Progress Bar settings</b> are not functional in Editor mode. Please preview the page  & Scroll to see the desired result.', 'ht-mega-for-elementor' ),
                'type'            => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'condition'   => [
                    'htmega_rpbar_enable' => 'yes'
                ],
            ]
        );
        $element->add_control(
            'htmega_rpbar_position',
            [
                'label' => esc_html__('Position', 'ht-mega-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'top',
                'label_block' => false,
                'options' => [
                    'top' => esc_html__('Top', 'ht-mega-for-elementor'),
                    'bottom' => esc_html__('Bottom', 'ht-mega-for-elementor'),
                ],
                'separator' => 'before',
                'condition' => [
                    'htmega_rpbar_enable' => 'yes',
                ],
                'selectors_dictionary' => [
                    'top' => 'top:0!important; bottom:auto!important',
                    'bottom' =>'bottom:0 !important; top:auto!important'
                ],
				'selectors' => [
                    '{{WRAPPER}} .htmega-rpbar-wrap' => '{{VALUE}}',
                ],
            ]
        );

        $element->add_control(
            'htmega_rpbar_height',
            [
                'label' => __('Height', 'ht-mega-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .htmega-rpbar-wrap,{{WRAPPER}} .htmega-rpbar-wrap .htmega-reading-progress-bar' => 'height: {{SIZE}}{{UNIT}} !important',
                ],
                'separator' => 'before',
                'condition' => [
                    'htmega_rpbar_enable' => 'yes',
                ],
            ]
        );

        $element->add_control(
            'htmega_rpbar_bg_color',
            [
                'label' => __('Background Color', 'ht-mega-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    'body .htmega-rpbar-wrap' => 'background-color: {{VALUE}}!important',
                ],
                'separator' => 'before',
                'condition' => [
                    'htmega_rpbar_enable' => 'yes',
                ],
            ]
        );

        $element->add_control(
            'htmega_rpbar_fill_color',
            [
                'label' => __('Fill Color', 'ht-mega-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#D43A6B',
                'selectors' => [
                    '{{WRAPPER}} .htmega-rpbar-wrap .htmega-reading-progress-bar' => 'background-color: {{VALUE}}!important',
                ],
                'separator' => 'before',
                'condition' => [
                    'htmega_rpbar_enable' => 'yes',
                ],
            ]
        );

        $element->add_control(
            'htmega_rpbar_animation_speed',
            [
                'label' => __('Animation Speed', 'ht-mega-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .htmega-rpbar-wrap .htmega-reading-progress-bar' => 'transition: width {{SIZE}}ms ease;',
                ],
                'separator' => 'before',
                'condition' => [
                    'htmega_rpbar_enable' => 'yes',
                ],
            ]
        );
		$element->end_controls_section();

	}

}

HTMegaReadingProgressBar_Elementor::instance();