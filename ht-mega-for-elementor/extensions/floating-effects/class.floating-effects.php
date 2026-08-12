<?php 
namespace HTMega_Floating_Effects;
use Elementor\Controls_Manager;
use Elementor\Element_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMegaFloatingEffects_Elementor {

    private static $_instance = null;
	static $load_script = false;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
	
    public function __construct() {
		add_action( 'elementor/element/common/_section_style/after_section_end', [ __CLASS__, 'register_controls' ], 1 );
		add_action( 'elementor/frontend/widget/before_render', [ __CLASS__, 'should_script_enqueue' ] );
		add_action( 'elementor/preview/enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );
    }
	/**
	 * Enqueue scripts.
	 *
	 * Enqueue required JS dependencies for the extension.
	 *
	 * @since 2.2.9
	 * @access public
	 */
	public static function enqueue_scripts() {
        // JS File
        wp_enqueue_script( 'htmega-floating-effects', HTMEGA_ADDONS_PL_URL . 'extensions/floating-effects/assets/js/htmega-floating-effects.js', array('jquery'),HTMEGA_VERSION );
        // phpcs:disable WordPress.WP.EnqueuedResourceParameters.NotInFooter -- 'anime' is already registered with in_footer=true in includes/class.assests.php's shared script-registration loop; this call just enqueues the already-registered handle by name (no src passed), so it already loads in the footer at runtime.
        wp_enqueue_script( 'anime' );
        // phpcs:enable WordPress.WP.EnqueuedResourceParameters.NotInFooter

	}



	/**
	 * Set should_script_enqueue based on module settings
	 *
	 * @param Element_Base $section
	 * @return void
	 */
	public static function should_script_enqueue( Element_Base $section ) {
		if ( self::$load_script ) {
			return;
		}

		if ( 'yes' == $section->get_settings_for_display( 'htmega_fe' ) ) {
			self::enqueue_scripts();

			self::$load_script = true;

			remove_action( 'elementor/frontend/widget/before_render', [ __CLASS__, 'should_script_enqueue' ] );
		}
	}



	/**
	 * Register Wrapper link controls.
	 *
	 * @since 2.2.9
	 * @access public
	 * @param object $element for current element.
	 */
	public static function register_controls( $element ) {

		$element->start_controls_section(
			'section_floating_effects',
			[
				'label' => __( 'HTMega Floating Effects', 'ht-mega-for-elementor' ),
				'tab' => Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'htmega_fe',
			[
				'label' => __( 'Enable', 'ht-mega-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
				'frontend_available' => true,
			]
		);
		$element->add_control(
			'htmega_fe_motion_toggle',
			[
				'label' => __( 'Motion', 'ht-mega-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
				'frontend_available' => true,
				'condition' => [
					'htmega_fe' => 'yes',
				]
			]
		);

		$element->add_control(
			'htmega_fe_translate_toggle',
			[
				'label' => __( 'Translate', 'ht-mega-for-elementor' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'frontend_available' => true,
				'condition' => [
					'htmega_fe' => 'yes',
					'htmega_fe_motion_toggle' => 'yes',
				]
			]
		);

		$element->start_popover();

		$element->add_control(
			'htmega_fe_translate_x',
			[
				'label' => __( 'Translate X', 'ht-mega-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'sizes' => [
						'from' => 0,
						'to' => 5,
					],
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					]
				],
				'labels' => [
					__( 'From', 'ht-mega-for-elementor' ),
					__( 'To', 'ht-mega-for-elementor' ),
				],
				'scales' => 1,
				'handles' => 'range',
				'condition' => [
					'htmega_fe_translate_toggle' => 'yes',
					'htmega_fe' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'htmega_fe_translate_y',
			[
				'label' => __( 'Translate Y', 'ht-mega-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'sizes' => [
						'from' => 0,
						'to' => 5,
					],
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					]
				],
				'labels' => [
					__( 'From', 'ht-mega-for-elementor' ),
					__( 'To', 'ht-mega-for-elementor' ),
				],
				'scales' => 1,
				'handles' => 'range',
				'condition' => [
					'htmega_fe_translate_toggle' => 'yes',
					'htmega_fe' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'htmega_fe_translate_duration',
			[
				'label' => __( 'Duration', 'ht-mega-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10000,
						'step' => 100
					]
				],
				'default' => [
					'size' => 1000,
				],
				'condition' => [
					'htmega_fe_translate_toggle' => 'yes',
					'htmega_fe' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'htmega_fe_translate_delay',
			[
				'label' => __( 'Delay', 'ht-mega-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5000,
						'step' => 100
					]
				],
				'condition' => [
					'htmega_fe_translate_toggle' => 'yes',
					'htmega_fe' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->end_popover();

		$element->add_control(
			'htmega_fe_rotate_toggle',
			[
				'label' => __( 'Rotate', 'ht-mega-for-elementor' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'frontend_available' => true,
				'condition' => [
					'htmega_fe' => 'yes',
					'htmega_fe_motion_toggle' => 'yes',
				]
			]
		);

		$element->start_popover();

		$element->add_control(
			'htmega_fe_rotate_x',
			[
				'label' => __( 'Rotate X', 'ht-mega-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'sizes' => [
						'from' => 0,
						'to' => 45,
					],
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => -180,
						'max' => 180,
					]
				],
				'labels' => [
					__( 'From', 'ht-mega-for-elementor' ),
					__( 'To', 'ht-mega-for-elementor' ),
				],
				'scales' => 1,
				'handles' => 'range',
				'condition' => [
					'htmega_fe_rotate_toggle' => 'yes',
					'htmega_fe' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'htmega_fe_rotate_y',
			[
				'label' => __( 'Rotate Y', 'ht-mega-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'sizes' => [
						'from' => 0,
						'to' => 45,
					],
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => -180,
						'max' => 180,
					]
				],
				'labels' => [
					__( 'From', 'ht-mega-for-elementor' ),
					__( 'To', 'ht-mega-for-elementor' ),
				],
				'scales' => 1,
				'handles' => 'range',
				'condition' => [
					'htmega_fe_rotate_toggle' => 'yes',
					'htmega_fe' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'htmega_fe_rotate_z',
			[
				'label' => __( 'Rotate Z', 'ht-mega-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'sizes' => [
						'from' => 0,
						'to' => 45,
					],
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => -180,
						'max' => 180,
					]
				],
				'labels' => [
					__( 'From', 'ht-mega-for-elementor' ),
					__( 'To', 'ht-mega-for-elementor' ),
				],
				'scales' => 1,
				'handles' => 'range',
				'condition' => [
					'htmega_fe_rotate_toggle' => 'yes',
					'htmega_fe' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'htmega_fe_rotate_duration',
			[
				'label' => __( 'Duration', 'ht-mega-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10000,
						'step' => 100
					]
				],
				'default' => [
					'size' => 1000,
				],
				'condition' => [
					'htmega_fe_rotate_toggle' => 'yes',
					'htmega_fe' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'htmega_fe_rotate_delay',
			[
				'label' => __( 'Delay', 'ht-mega-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5000,
						'step' => 100
					]
				],
				'condition' => [
					'htmega_fe_rotate_toggle' => 'yes',
					'htmega_fe' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->end_popover();

		$element->add_control(
			'htmega_fe_scale_toggle',
			[
				'label' => __( 'Scale', 'ht-mega-for-elementor' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'frontend_available' => true,
				'condition' => [
					'htmega_fe' => 'yes',
					'htmega_fe_motion_toggle' => 'yes',
				]
			]
		);

		$element->start_popover();

		$element->add_control(
			'htmega_fe_scale_x',
			[
				'label' => __( 'Scale X', 'ht-mega-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'sizes' => [
						'from' => 1,
						'to' => 1.2,
					],
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => .1
					]
				],
				'labels' => [
					__( 'From', 'ht-mega-for-elementor' ),
					__( 'To', 'ht-mega-for-elementor' ),
				],
				'scales' => 1,
				'handles' => 'range',
				'condition' => [
					'htmega_fe_scale_toggle' => 'yes',
					'htmega_fe' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'htmega_fe_scale_y',
			[
				'label' => __( 'Scale Y', 'ht-mega-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'sizes' => [
						'from' => 1,
						'to' => 1.2,
					],
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => .1
					]
				],
				'labels' => [
					__( 'From', 'ht-mega-for-elementor' ),
					__( 'To', 'ht-mega-for-elementor' ),
				],
				'scales' => 1,
				'handles' => 'range',
				'condition' => [
					'htmega_fe_scale_toggle' => 'yes',
					'htmega_fe' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'htmega_fe_scale_duration',
			[
				'label' => __( 'Duration', 'ht-mega-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10000,
						'step' => 100
					]
				],
				'default' => [
					'size' => 1000,
				],
				'condition' => [
					'htmega_fe_scale_toggle' => 'yes',
					'htmega_fe' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'htmega_fe_scale_delay',
			[
				'label' => __( 'Delay', 'ht-mega-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10000,
						'step' => 100
					]
				],
				'condition' => [
					'htmega_fe_scale_toggle' => 'yes',
					'htmega_fe' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->end_popover();
		// Skew
		$element->add_control(
			'htmega_fe_skew_togglep',
			[
				'label' => __( 'Skew', 'ht-mega-for-elementor' ) . ' <i class="eicon-pro-icon"></i>',
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'frontend_available' => true,
				'condition' => [
					'htmega_fe' => 'yes',
					'htmega_fe_motion_toggle' => 'yes',
				],
				'classes' => 'htmega-disable-control',
			]
		);

		$element->add_control(
			'htmega_fe_style_togglep',
			array(
				'label'        => __( 'Style', 'ht-mega-for-elementor' ) . ' <i class="eicon-pro-icon"></i>',
				'type'         => Controls_Manager::SWITCHER,
				'separator'    => 'before',
				'condition'    => array(
					'htmega_fe' => 'yes',
				),
				'frontend_available' => true,
				'classes' => 'htmega-disable-control',
			)
		);

		// End Style Settings
		$element->add_control(
			'htmega_fe_filters_togglep',
			array(
				'label'        => __( 'Filters', 'ht-mega-for-elementor' ) . ' <i class="eicon-pro-icon"></i>',
				'type'         => Controls_Manager::SWITCHER,
				'separator'    => 'before',
				'condition'    => array(
					'htmega_fe' => 'yes',
				),
				'frontend_available' => true,
				'classes' => 'htmega-disable-control',
			)
		);

		// General Setting start
		$element->add_control(
			'htmega_fe_general_settings_heading',
			array(
				'label'     => __( 'General Settings', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'htmega_fe' => 'yes',
				),
			)
		);

		$element->add_control(
			'htmega_fe_direction',
			array(
				'label'     => __( 'Direction', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'alternate',
				'options'   => array(
					'normal'    => __( 'Normal', 'ht-mega-for-elementor' ),
					'reverse'   => __( 'Reverse', 'ht-mega-for-elementor' ),
					'alternate' => __( 'Alternate', 'ht-mega-for-elementor' ),
				),
				'condition' => array(
					'htmega_fe' => 'yes',
				),
				'frontend_available' => true,
			)
		);

		$element->add_control(
			'htmega_fe_loop',
			array(
				'label'     => __( 'Loop', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'default',
				'options'   => array(
					'default' => __( 'Infinite', 'ht-mega-for-elementor' ),
					'number'  => __( 'Custom', 'ht-mega-for-elementor' ),
				),
				'condition' => array(
					'htmega_fe' => 'yes',
				),
				'frontend_available' => true,
			)
		);

		$element->add_control(
			'htmega_fe_loop_number',
			array(
				'label'     => __( 'Number', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3,
				'condition' => array(
					'htmega_fe' => 'yes',
					'htmega_fe_loop'     => 'number',
				),
				'frontend_available' => true,
			)
		);

		$element->add_control(
			'htmega_fe_easing',
			array(
				'label'     => __( 'Easing', 'ht-mega-for-elementor' ) . ' <i class="eicon-pro-icon"></i>',
				'type'      => Controls_Manager::SELECT,
				'default'   => 'easeInOutSine',
				'options'   => array(
					'linear'                  => __( 'Linear', 'ht-mega-for-elementor' ),
					'easeInOutSine'           => __( 'easeInOutSine', 'ht-mega-for-elementor' ),
					'easeInOutExpo'           => __( 'easeInOutExpo', 'ht-mega-for-elementor' ),
					'easeInOutQuart'          => __( 'easeInOutQuart', 'ht-mega-for-elementor' ),
					'easeInOutCirc'           => __( 'easeInOutCirc', 'ht-mega-for-elementor' ),
					'easeInOutBack'           => __( 'easeInOutBack', 'ht-mega-for-elementor' ),
					'steps'                   => __( 'Steps', 'ht-mega-for-elementor' ),
					'easeInElastic(1, .6)'    => __( 'Elastic In', 'ht-mega-for-elementor' ),
					'easeOutElastic(1, .6)'   => __( 'Elastic Out', 'ht-mega-for-elementor' ),
					'easeInOutElastic(1, .6)' => __( 'Elastic In Out', 'ht-mega-for-elementor' ),
				),
				'condition' => array(
					'htmega_fe' => 'yes',
				),
				'frontend_available' => true,
				'classes' => 'htmega-disable-control',

			)
		);

		$element->add_control(
			'htmega_fe_ease_step',
			array(
				'label'     => __( 'Steps', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5,
				'condition' => array(
					'htmega_fe' => 'yes',
					'htmega_fe_easing'   => 'steps',
				),
				'frontend_available' => true,
			)
		);

		$element->end_controls_section();
	}
}

HTMegaFloatingEffects_Elementor::instance();