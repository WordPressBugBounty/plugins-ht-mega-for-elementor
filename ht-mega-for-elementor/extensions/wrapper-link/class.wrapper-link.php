<?php 
namespace HTMega_Wrapper_link;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMegaWrapperLink_Elementor {

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
	
    public function __construct() {
		add_action( 'elementor/element/column/section_advanced/after_section_end', array( $this, 'register_controls' ), 1 );
		add_action( 'elementor/element/section/section_advanced/after_section_end', array( $this, 'register_controls' ), 1 );
		add_action( 'elementor/element/container/section_layout/after_section_end', array( $this, 'register_controls' ), 1 );
		add_action( 'elementor/element/common/_section_style/after_section_end', array( $this, 'register_controls' ), 1 );
		add_action( 'elementor/frontend/before_render' ,array( $this, 'before_render' ), 1 );

		// Register the handle early so it can be enqueued on demand from before_render(),
		// on any page, whether or not the page itself is built with Elementor.
		add_action( 'wp_enqueue_scripts', array( $this, 'register_script' ), 1 );

		// Add this line to enqueue scripts properly
		add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'enqueue_scripts' ) );
    }

	/**
	 * Register the wrapper link script handle.
	 *
	 * Registering is free — WordPress only prints handles that are actually enqueued —
	 * so this can run unconditionally and gives enqueue_scripts()/before_render() a single
	 * source of truth for the file URL, dependencies and version.
	 *
	 * @since 2.0.2
	 * @access public
	 */
	public function register_script() {
		if ( wp_script_is( 'htmega-wrapper-link', 'registered' ) ) {
			return;
		}

		wp_register_script(
			'htmega-wrapper-link',
			HTMEGA_ADDONS_PL_URL . 'extensions/wrapper-link/assets/js/htmega-wrapper-link.js',
			array( 'jquery' ),
			HTMEGA_VERSION,
			true
		);
	}

	/**
	 * Enqueue scripts.
	 *
	 * Enqueue required JS dependencies for the extension.
	 *
	 * @since 2.0.2
	 * @access public
	 */
	public function enqueue_scripts() {
		if ( function_exists( 'htmega_should_enqueue_global_assets' ) && ! htmega_should_enqueue_global_assets() ) {
			return;
		}

		$this->register_script();
		wp_enqueue_script( 'htmega-wrapper-link' );
	}

	/**
	 * Enqueue the wrapper link script the moment a wrapper-linked element renders.
	 *
	 * The markup half of this feature is element level — it is added by before_render()
	 * wherever the element renders, including an Elementor template pulled into a mega menu
	 * dropdown, a theme builder part or a shortcode on a page that is not built with
	 * Elementor. The page level asset gate (htmega_should_enqueue_global_assets()) returns
	 * false on those requests, so relying on it alone left the markup in place with no
	 * behaviour attached. Enqueueing here keeps the script scoped to pages that really need
	 * it while covering every render context.
	 *
	 * @since 2.0.2
	 * @access protected
	 */
	protected function enqueue_script_on_demand() {
		static $done = false;
		if ( $done ) {
			return;
		}
		$done = true;

		$this->register_script();

		// Footer scripts have already been printed (element rendered from an unusually late
		// hook), so wp_enqueue_script() would be a no-op — print the handle directly instead.
		// WP_Scripts::do_items() is used rather than wp_print_scripts(), because the latter
		// re-fires the global 'wp_print_scripts' action even when an explicit handle is passed,
		// which would run third party callbacks (WooCommerce, Gravity Forms, …) a second time.
		if ( did_action( 'wp_print_footer_scripts' ) ) {
			if ( ! wp_script_is( 'htmega-wrapper-link', 'done' ) ) {
				wp_scripts()->do_items( 'htmega-wrapper-link' );
			}
			return;
		}

		wp_enqueue_script( 'htmega-wrapper-link' );
	}

	/**
	 * Register Wrapper link controls.
	 *
	 * @since 2.0.2
	 * @access public
	 * @param object $element for current element.
	 */
	public function register_controls( $element ) {
		$tabs = Controls_Manager::TAB_CONTENT;
		if ( 'section' === $element->get_name() || 'column' === $element->get_name()  || 'container' === $element->get_name()) {
			$tabs = Controls_Manager::TAB_LAYOUT;
		}

		$element->start_controls_section(
			'section_htmega_wrapper_link',
			array(
				'label' => __( 'Wrapper Link', 'ht-mega-for-elementor' ).htmega_get_elementor_section_icon(),
				'tab'   => $tabs,
			)
		);

		$element->add_control(
			'htmega_element_link',
			[
				'label'       => __( 'Link', 'ht-mega-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => 'https://example.com',
			]
		);

		$element->end_controls_section();

	}

	/**
	 * Render HTML output on the frontend.
	 *
	 * Written in PHP and used to generate the final Output.
	 *
	 * @since 2.0.2
	 * @access public
	 * @param object $element for current element.
	 */
	public function before_render( $element ) {
		$htmega_wrapper_link = $element->get_settings_for_display( 'htmega_element_link' );
		if ( $htmega_wrapper_link && ! empty( $htmega_wrapper_link['url'] ) ) {
			$htmega_wrapper_link['url'] = esc_url( $htmega_wrapper_link['url'] );
			$element->add_render_attribute(
				'_wrapper',
				[
					'data-htmega-element-link' => wp_json_encode( $htmega_wrapper_link ),
					'style' => 'cursor: pointer',
					'class' => 'htmega-element-link'
				]
			);

			$this->enqueue_script_on_demand();
		}
	}
}

HTMegaWrapperLink_Elementor::instance();