<?php
namespace HtMegaBlocks;

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Blocks Assets Manage
 */
class Scripts
{

	/**
	 * [$_instance]
	 * @var null
	 */
	private static $_instance = null;

	/**
	 * [instance] Initializes a singleton instance
	 * @return [Scripts]
	 */
	public static function instance()
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * The Constructor.
	 */
	public function __construct()
	{
		add_action('enqueue_block_assets', [$this, 'block_assets']);
		add_action('enqueue_block_editor_assets', [$this, 'block_editor_assets']);
		add_action('wp_ajax_htmega_activate_htcf',          [$this, 'ajax_activate_htcf']);
		add_action('wp_ajax_htmega_install_htcf',           [$this, 'ajax_install_htcf']);
		add_action('wp_ajax_htmega_get_contact_form_data',  [$this, 'ajax_get_contact_form_data']);
	}

	/**
	 * AJAX: activate HT Contact Form plugin without leaving the block editor.
	 */
	public function ajax_activate_htcf() {
		check_ajax_referer( 'htmega_activate_htcf', 'nonce' );

		if ( ! current_user_can( 'activate_plugins' ) ) {
			wp_send_json_error( [ 'message' => __( 'Permission denied.', 'htmega-addons' ) ] );
		}

		$plugin = 'ht-contactform/contact-form-widget-elementor.php';

		if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin ) ) {
			wp_send_json_error( [ 'message' => __( 'Plugin not installed.', 'htmega-addons' ) ] );
		}

		$result = activate_plugin( $plugin );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( [ 'message' => $result->get_error_message() ] );
		}

		wp_send_json_success( [ 'message' => __( 'HT Contact Form activated.', 'htmega-addons' ) ] );
	}

	/**
	 * AJAX: install HT Contact Form from WordPress.org, then auto-activate it.
	 */
	public function ajax_install_htcf() {
		check_ajax_referer( 'htmega_activate_htcf', 'nonce' );

		if ( ! current_user_can( 'install_plugins' ) ) {
			wp_send_json_error( [ 'message' => __( 'Permission denied.', 'htmega-addons' ) ] );
		}

		require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php';

		$api = plugins_api( 'plugin_information', [
			'slug'   => 'ht-contactform',
			'fields' => [ 'sections' => false ],
		] );

		if ( is_wp_error( $api ) ) {
			wp_send_json_error( [ 'message' => $api->get_error_message() ] );
		}

		$skin     = new \WP_Ajax_Upgrader_Skin();
		$upgrader = new \Plugin_Upgrader( $skin );
		$result   = $upgrader->install( $api->download_link );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( [ 'message' => $result->get_error_message() ] );
		}
		if ( is_wp_error( $skin->result ) ) {
			wp_send_json_error( [ 'message' => $skin->result->get_error_message() ] );
		}

		$plugin   = 'ht-contactform/contact-form-widget-elementor.php';
		$activate = activate_plugin( $plugin );

		if ( is_wp_error( $activate ) ) {
			wp_send_json_error( [ 'message' => $activate->get_error_message() ] );
		}

		wp_send_json_success( [ 'message' => __( 'HT Contact Form installed and activated.', 'htmega-addons' ) ] );
	}

	/**
	 * AJAX: return fresh form plugin + form list after activation (no page reload needed).
	 */
	public function ajax_get_contact_form_data() {
		check_ajax_referer( 'htmega_activate_htcf', 'nonce' );

		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_send_json_error();
		}

		wp_send_json_success( [
			'plugins' => $this->get_contact_form_plugins(),
			'forms'   => $this->get_contact_forms_per_plugin(),
		] );
	}

	/**
	 * Block assets.
	 */
	public function block_assets()
	{

		// Also pass through when any 2025-type block is active.
		// htmegaBlocks_any_block_enabled() only checks legacy blocks (htmega_gutenberg_tabs).
		// 2025 blocks live in htmega_sections_gutenberg_tabs and default to 'off'.
		$sections_opts   = get_option( 'htmega_sections_gutenberg_tabs', [] );
		$any_2025_active = in_array( 'on', $sections_opts, true );
		if ( ! is_admin() && ! htmegaBlocks_any_block_enabled() && ! $any_2025_active ) {
			return;
		}
		wp_enqueue_style('dashicons');
		wp_enqueue_style(
			'htmega-block-common-style',
			HTMEGA_BLOCK_URL . 'build/assets/css/common-style.css',
			[],
			HTMEGA_VERSION
		);
		wp_enqueue_style(
			'slick',
			HTMEGA_ADDONS_PL_URL . 'assets/css/slick.min.css',
			[],
			HTMEGA_VERSION
		);
		wp_enqueue_style(
			'htmega-block-fontawesome',
			HTMEGA_ADDONS_PL_URL . 'admin/assets/extensions/ht-menu/css/font-awesome.min.css',
			[],
			HTMEGA_VERSION
		);
		wp_enqueue_style(
			'htmega-block-style',
			HTMEGA_BLOCK_URL . 'build/style-blocks-htmega.css',
			[],
			HTMEGA_VERSION,
			'all'
		);

		// HT Mega 2025 — design token system (loaded for all pages that
		// include any 2025 block; the file is tiny ~8 KB, no penalty).
		wp_enqueue_style(
			'htm25-tokens',
			HTMEGA_ADDONS_PL_URL . 'assets/css/htm25-tokens.css',
			[],
			filemtime( HTMEGA_ADDONS_PL_PATH . 'assets/css/htm25-tokens.css' ),
			'all'
		);

		// HT Mega 2025 blocks use FA5 solid icons (fas fa-*).
		// Load directly from Elementor's bundled FA5 copy — more reliable than
		// checking handle registration which depends on Elementor's init order.
		if ( defined( 'ELEMENTOR_ASSETS_URL' ) && defined( 'ELEMENTOR_ASSETS_PATH' ) ) {
			$fa_path = ELEMENTOR_ASSETS_PATH . 'lib/font-awesome/css/';
			$fa_url  = ELEMENTOR_ASSETS_URL  . 'lib/font-awesome/css/';
			if ( file_exists( $fa_path . 'all.min.css' ) ) {
				wp_enqueue_style( 'htm25-fa5', $fa_url . 'all.min.css', [], '5.15.3' );
			}
		}

		wp_enqueue_script(
			'slick',
			HTMEGA_ADDONS_PL_URL . 'assets/js/slick.min.js',
			['jquery'],
			HTMEGA_VERSION,
			true
		);
		wp_enqueue_script(
			'htmega-block-main',
			HTMEGA_BLOCK_URL . 'build/assets/js/script.js',
			['slick'],
			HTMEGA_VERSION,
			true
		);

		// 2025 block CSS — loaded here (enqueue_block_assets) so it appears
		// inside the editor canvas iframe (WP 6.1+), making @media queries
		// fire against the iframe viewport for tablet/mobile responsive preview.
		// Same hook also fires on the frontend, so no separate render_callback
		// enqueue is needed (Blocks_List sets enqueue_style => false).
		if ( defined( 'HTMEGA_ADDONS_PL_URL' ) && defined( 'HTMEGA_ADDONS_PL_PATH' ) ) {
			$htm25_styles = [
				'hero-2025'         => 'assets/css/widgets/htm25-hero.css',
				'about-2025'        => 'assets/css/widgets/htm25-about.css',
				'services-2025'     => 'assets/css/widgets/htm25-services.css',
				'pricing-2025'      => 'assets/css/widgets/htm25-pricing.css',
				'testimonials-2025' => 'assets/css/widgets/htm25-testimonials.css',
				'stats-2025'        => 'assets/css/widgets/htm25-stats.css',
				'cta-2025'          => 'assets/css/widgets/htm25-cta.css',
				'team-2025'         => 'assets/css/widgets/htm25-team.css',
				'faq-2025'          => 'assets/css/widgets/htm25-faq.css',
				'blog-2025'         => 'assets/css/widgets/htm25-blog.css',
				'contact-2025'      => 'assets/css/widgets/htm25-contact.css',
			];
			foreach ( $htm25_styles as $slug => $css_path ) {
				if ( htmega_sections_get_option( $slug, 'htmega_sections_gutenberg_tabs', 'off' ) !== 'on' ) {
					continue;
				}
				$full_path = HTMEGA_ADDONS_PL_PATH . $css_path;
				if ( ! file_exists( $full_path ) ) {
					continue;
				}
				wp_enqueue_style(
					'htmega-' . $slug,
					HTMEGA_ADDONS_PL_URL . $css_path,
					[ 'htm25-tokens' ],
					filemtime( $full_path ),
					'all'
				);
			}
		}

	}

	/**
	 * Block editor assets.
	 */
	public function block_editor_assets()
	{

		global $pagenow;

		if ($pagenow !== 'widgets.php') {

			wp_enqueue_style('slick');
			wp_enqueue_style(
				'htmega-block-editor-style',
				HTMEGA_BLOCK_URL . 'build/assets/css/editor-style.css',
				[],
				HTMEGA_VERSION,
				'all'
			);

			$dependencies = require_once(HTMEGA_BLOCK_PATH . '/build/blocks-htmega.asset.php');
			wp_enqueue_script(
				'htmega-blocks',
				HTMEGA_BLOCK_URL . 'build/blocks-htmega.js',
				$dependencies['dependencies'],
				file_exists( HTMEGA_BLOCK_PATH . '/build/blocks-htmega.js' )
					? filemtime( HTMEGA_BLOCK_PATH . '/build/blocks-htmega.js' )
					: HTMEGA_VERSION,
				true
			);

			/**
			 * Localize data
			 */
			$htcf_plugin_file = 'ht-contactform/contact-form-widget-elementor.php';
			$htcf_installed   = file_exists( WP_PLUGIN_DIR . '/' . $htcf_plugin_file );
			$htcf_active      = defined( 'HTCONTACTFORM_VERSION' ) || class_exists( 'HTContactForm\Plugin' ) || function_exists( 'htcontactform' );

			if ( $htcf_active ) {
				$htcf_status      = 'active';
				$htcf_action_url  = '';
			} elseif ( $htcf_installed ) {
				$htcf_status      = 'inactive';
				$htcf_action_url  = wp_nonce_url(
					admin_url( 'plugins.php?action=activate&plugin=' . rawurlencode( $htcf_plugin_file ) ),
					'activate-plugin_' . $htcf_plugin_file
				);
			} else {
				$htcf_status      = 'not_installed';
				$htcf_action_url  = admin_url( 'plugin-install.php?s=ht+contact+form&tab=search&type=term' );
			}

			$editor_localize_data = array(
				'url'                 => HTMEGA_BLOCK_URL,
				'ajax'                => admin_url('admin-ajax.php'),
				'security'            => wp_create_nonce('htmega-block-nonce'),
				'locale'              => get_locale(),
				'options'             => $this->get_block_list()['block_list'],
				'contactFormPlugins'  => $this->get_contact_form_plugins(),
				'contactForms'        => $this->get_contact_forms_per_plugin(),
				'htcfStatus'          => $htcf_status,
				'htcfActionUrl'       => $htcf_action_url,
				'htcfActivateNonce'   => wp_create_nonce( 'htmega_activate_htcf' ),
				'ajaxUrl'             => admin_url( 'admin-ajax.php' ),
			);

			wp_localize_script('htmega-blocks', 'htmegaData', $editor_localize_data);

			// ── HT Mega 2025 block editor scripts ──────────────────────
			// Each 2025 block has its own edit.js that registers the block
			// type using wp.* globals — no webpack rebuild ever needed.
			// Pattern: add one wp_enqueue_script per new 2025 block here.
			$this->enqueue_2025_block_editor_scripts();
		}

	}

	/**
	 * Enqueue editor JS for HT Mega 2025 blocks.
	 * Uses wp-server-side-render so each block's PHP renderer
	 * is called live in the editor — no separate editor template needed.
	 */
	private function enqueue_2025_block_editor_scripts() {

		$blocks_2025 = [];
		// All 2025 blocks are now webpack-compiled via build/blocks-htmega.js.
		// Standalone IIFE enqueues are no longer needed.

		// Dependencies every 2025 editor script needs
		$deps = [
			'wp-blocks',
			'wp-block-editor',
			'wp-components',
			'wp-server-side-render',
			'wp-i18n',
			'wp-element',
			'htmega-blocks',  // ensure main bundle (and htmega-blocks category) loads first
		];

		foreach ( $blocks_2025 as $slug => $block ) {
			if ( htmega_sections_get_option( $slug, 'htmega_sections_gutenberg_tabs', 'off' ) !== 'on' ) {
				continue;
			}
			$file_path = HTMEGA_BLOCK_PATH . '/' . $block['file'];
			$file_url  = HTMEGA_BLOCK_URL  . $block['file'];

			if ( ! file_exists( $file_path ) ) {
				continue;
			}

			wp_enqueue_script(
				$block['handle'],
				$file_url,
				$deps,
				filemtime( $file_path ),  // auto-bust cache on file change
				true
			);

			wp_set_script_translations( $block['handle'], 'htmega-addons' );
		}

		// FA5 solid — 2025 blocks use fas fa-* classes. Enqueue Elementor's copy in the editor too.
		if ( wp_style_is( 'elementor-icons-shared-0-css', 'registered' ) ) {
			wp_enqueue_style( 'elementor-icons-shared-0-css' );
		}
		if ( wp_style_is( 'elementor-icons-fa-solid', 'registered' ) ) {
			wp_enqueue_style( 'elementor-icons-fa-solid' );
		}

	}

	/**
	 * Return active form plugin options for the contact block editor.
	 * Format: [ [ 'value' => 'htcf', 'label' => '...' ], ... ]
	 */
	private function get_contact_form_plugins(): array {
		$options = [];
		if ( defined( 'HTCONTACTFORM_VERSION' ) || class_exists( 'HTContactForm\Plugin' ) || function_exists( 'htcontactform' ) ) {
			$options[] = [ 'value' => 'htcf',         'label' => '★ HT Contact Form (Recommended)' ];
		}
		if ( defined( 'WPCF7_VERSION' ) ) {
			$options[] = [ 'value' => 'cf7',          'label' => 'Contact Form 7' ];
		}
		if ( function_exists( 'wpforms' ) ) {
			$options[] = [ 'value' => 'wpforms',      'label' => 'WPForms' ];
		}
		if ( defined( 'FLUENTFORM' ) ) {
			$options[] = [ 'value' => 'fluentform',   'label' => 'Fluent Forms' ];
		}
		if ( class_exists( 'GFAPI' ) ) {
			$options[] = [ 'value' => 'gravityforms', 'label' => 'Gravity Forms' ];
		}
		if ( function_exists( 'Ninja_Forms' ) ) {
			$options[] = [ 'value' => 'ninjaforms',   'label' => 'Ninja Forms' ];
		}
		return $options;
	}

	/**
	 * Return form lists keyed by plugin slug for the contact block editor.
	 * Format: [ 'htcf' => [ [ 'value' => '123', 'label' => 'My Form' ], ... ], ... ]
	 */
	private function get_contact_forms_per_plugin(): array {
		$lists = [];
		$empty = [ [ 'value' => '', 'label' => '— Select a form —' ] ];

		if ( defined( 'HTCONTACTFORM_VERSION' ) || class_exists( 'HTContactForm\Plugin' ) || function_exists( 'htcontactform' ) ) {
			$forms = get_posts( [ 'post_type' => 'ht_form', 'posts_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'title', 'order' => 'ASC' ] );
			$items = $empty;
			foreach ( $forms as $form ) {
				$items[] = [ 'value' => (string) $form->ID, 'label' => $form->post_title ];
			}
			$lists['htcf'] = $items;
		}

		if ( defined( 'WPCF7_VERSION' ) ) {
			$forms = get_posts( [ 'post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'title', 'order' => 'ASC' ] );
			$items = $empty;
			foreach ( $forms as $form ) {
				$items[] = [ 'value' => (string) $form->ID, 'label' => $form->post_title ];
			}
			$lists['cf7'] = $items;
		}

		if ( function_exists( 'wpforms' ) ) {
			$forms = get_posts( [ 'post_type' => 'wpforms', 'posts_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'title', 'order' => 'ASC' ] );
			$items = $empty;
			foreach ( $forms as $form ) {
				$items[] = [ 'value' => (string) $form->ID, 'label' => $form->post_title ];
			}
			$lists['wpforms'] = $items;
		}

		if ( defined( 'FLUENTFORM' ) ) {
			global $wpdb;
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$forms = $wpdb->get_results( "SELECT id, title FROM {$wpdb->prefix}fluentform_forms ORDER BY title ASC" );
			$items = $empty;
			foreach ( $forms as $form ) {
				$items[] = [ 'value' => (string) $form->id, 'label' => $form->title ];
			}
			$lists['fluentform'] = $items;
		}

		if ( class_exists( 'GFAPI' ) ) {
			$forms = \GFAPI::get_forms();
			$items = $empty;
			foreach ( $forms as $form ) {
				$items[] = [ 'value' => (string) $form['id'], 'label' => $form['title'] ];
			}
			$lists['gravityforms'] = $items;
		}

		if ( function_exists( 'Ninja_Forms' ) ) {
			$forms = \Ninja_Forms()->form()->get_forms();
			$items = $empty;
			foreach ( $forms as $form ) {
				$items[] = [ 'value' => (string) $form->get_id(), 'label' => $form->get_setting( 'title' ) ];
			}
			$lists['ninjaforms'] = $items;
		}

		return $lists;
	}

	/**
	 * Manage block based on template type
	 */
	public function get_block_list()
	{
		$blocks_list  = Blocks_init::$blocksList;
		$common_block = array_key_exists( 'common', $blocks_list ) ? $blocks_list['common'] : [];

		// Blocks_init::$blocksList['htm25'] may be empty on FSE site-editor.php because
		// register_blocks() has an early-return when $_GET['action'] is absent.
		// Read 2025 blocks directly from Blocks_List to always include them.
		$htm25_block = [];
		foreach ( Blocks_List::get_block_list() as $key => $block ) {
			if (
				is_array( $block ) &&
				isset( $block['type'] ) && $block['type'] === 'htm25' &&
				! empty( $block['active'] ) &&
				isset( $block['name'] )
			) {
				$htm25_block[] = str_replace( 'htmega/', '', trim( $block['name'] ) );
			}
		}

		return array(
			'block_list' => array_merge( $common_block, $htm25_block ),
		);
	}

}