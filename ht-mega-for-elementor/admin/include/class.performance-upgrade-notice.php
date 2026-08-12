<?php
/**
 * Dismissible upgrade notice: offer “fast” global asset mode after 3.1.0 migration.
 *
 * @package HTMega
 */

defined( 'ABSPATH' ) || exit;

/**
 * Admin notice + AJAX to disable global asset compatibility.
 */
final class HTMega_Performance_Upgrade_Notice {

	/**
	 * Register hooks.
	 */
	public static function init(): void {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'register_ajax_script' ) );
		add_action( 'admin_notices', array( __CLASS__, 'render_notice' ) );
		add_action( 'wp_ajax_htmega_enable_fast_asset_mode', array( __CLASS__, 'ajax_fast_mode' ) );
		add_action( 'wp_ajax_htmega_dismiss_perf_notice', array( __CLASS__, 'ajax_dismiss_notice' ) );
	}

	/**
	 * Localize script only on HT Mega admin screens.
	 *
	 * @param string $hook_suffix Current admin page.
	 */
	public static function register_ajax_script( $hook_suffix ): void {
		unset( $hook_suffix );
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || false === strpos( (string) $screen->id, 'ht-mega-for-elementor' ) ) {
			return;
		}

		wp_register_script( 'htmega-perf-notice', '', array( 'jquery' ), HTMEGA_VERSION, true );
		wp_enqueue_script( 'htmega-perf-notice' );
		wp_localize_script(
			'htmega-perf-notice',
			'HTMEGA_PERF_NOTICE',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'htmega_perf_notice_nonce' ),
			)
		);
		wp_add_inline_script(
			'htmega-perf-notice',
			'jQuery(function($){$(document).on("click",".htmega-perf-enable-fast",(function(){var b=$(this);b.prop("disabled",!0);$.post(HTMEGA_PERF_NOTICE.ajaxUrl,{action:"htmega_enable_fast_asset_mode",nonce:HTMEGA_PERF_NOTICE.nonce},(function(){b.closest(".notice").fadeOut()}))}));$(document).on("click",".htmega-perf-upgrade-notice .notice-dismiss",(function(){$.post(HTMEGA_PERF_NOTICE.ajaxUrl,{action:"htmega_dismiss_perf_notice",nonce:HTMEGA_PERF_NOTICE.nonce})}))});'
		);
	}

	/**
	 * Output notice when migration left compatibility loading on.
	 */
	public static function render_notice(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || false === strpos( (string) $screen->id, 'ht-mega-for-elementor' ) ) {
			return;
		}

		if ( get_option( 'htmega_upgrade_notice_dismissed', false ) ) {
			return;
		}

		if ( ! filter_var( get_option( 'htmega_force_global_assets', false ), FILTER_VALIDATE_BOOLEAN ) ) {
			return;
		}

		?>
	<div class="notice notice-info is-dismissible htmega-perf-upgrade-notice" data-dismiss-hook="htmega_perf">
		<p>
			<strong><?php esc_html_e( 'HT Mega:', 'ht-mega-for-elementor' ); ?></strong>
			<?php esc_html_e( 'This version ships a faster asset loader. Compatibility mode keeps legacy global styles on every page.', 'ht-mega-for-elementor' ); ?>
			<?php esc_html_e( 'If your site looks correct in fast mode, you can load HT Mega CSS/JS only on pages that need them.', 'ht-mega-for-elementor' ); ?>
			<button type="button" class="button button-primary htmega-perf-enable-fast">
				<?php esc_html_e( 'Enable fast mode', 'ht-mega-for-elementor' ); ?>
			</button>
		</p>
	</div>
		<?php
	}

	/**
	 * AJAX: Turn off compatibility global enqueue and dismiss notice.
	 */
	public static function ajax_fast_mode(): void {
		check_ajax_referer( 'htmega_perf_notice_nonce', 'nonce' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Forbidden.', 'ht-mega-for-elementor' ) ), 403 );
		}

		update_option( 'htmega_force_global_assets', false, false );
		update_option( 'htmega_upgrade_notice_dismissed', true, false );

		$tabs = get_option( 'htmega_general_tabs', array() );
		if ( is_array( $tabs ) ) {
			$tabs['htmega_perf_force_global'] = 'off';
			update_option( 'htmega_general_tabs', $tabs, false );
		}

		wp_send_json_success();
	}

	/**
	 * AJAX: Dismiss notice without changing asset mode (user closed the banner).
	 */
	public static function ajax_dismiss_notice(): void {
		check_ajax_referer( 'htmega_perf_notice_nonce', 'nonce' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Forbidden.', 'ht-mega-for-elementor' ) ), 403 );
		}

		update_option( 'htmega_upgrade_notice_dismissed', true, false );
		wp_send_json_success();
	}
}

HTMega_Performance_Upgrade_Notice::init();
