<?php
/**
 * Keep Integrations UI fields in sync with standalone performance options (Phase 3).
 *
 * @package HTMega
 */

defined( 'ABSPATH' ) || exit;

/**
 * Merge standalone flags into REST-loaded option shape when keys missing.
 *
 * @param mixed $value Option value.
 * @return mixed
 */
function htmega_performance_merge_general_tabs_display( $value ) {
	if ( ! is_array( $value ) ) {
		return $value;
	}
	if ( ! array_key_exists( 'htmega_perf_force_global', $value ) ) {
		$value['htmega_perf_force_global'] = filter_var(
			get_option( 'htmega_force_global_assets', false ),
			FILTER_VALIDATE_BOOLEAN
		) ? 'on' : 'off';
	}
	if ( ! array_key_exists( 'htmega_perf_query_cache', $value ) ) {
		$value['htmega_perf_query_cache'] = filter_var(
			get_option( 'htmega_query_cache_enabled', true ),
			FILTER_VALIDATE_BOOLEAN
		) ? 'on' : 'off';
	}

	return $value;
}
add_filter( 'option_htmega_general_tabs', 'htmega_performance_merge_general_tabs_display' );

/**
 * Mirror saved Integrations toggles into standalone options.
 *
 * @param mixed  $value     New value.
 * @param mixed  $old_value Old value.
 * @param string $option    Option name.
 * @return mixed
 */
function htmega_performance_pre_update_general_tabs( $value, $old_value, $option ) {
	unset( $option, $old_value );
	if ( ! is_array( $value ) ) {
		return $value;
	}

	if ( isset( $value['htmega_perf_force_global'] ) ) {
		update_option(
			'htmega_force_global_assets',
			'on' === $value['htmega_perf_force_global'],
			false
		);
	}
	if ( isset( $value['htmega_perf_query_cache'] ) ) {
		update_option(
			'htmega_query_cache_enabled',
			'on' === $value['htmega_perf_query_cache'],
			false
		);
	}

	return $value;
}
add_filter( 'pre_update_option_htmega_general_tabs', 'htmega_performance_pre_update_general_tabs', 10, 3 );
