<?php
/**
 * Transient-backed WP_Query result cache for post-loop widgets (Phase 3).
 *
 * @package HTMega
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'HTMega_Query_Cache' ) ) {

	/**
	 * Caches WP_Query post ID lists keyed by serialized args plus posts last_changed.
	 */
	class HTMega_Query_Cache {

		/**
		 * Run a WP_Query with optional transient caching for post loops.
		 *
		 * @param array<string, mixed> $args WP_Query arguments.
		 * @param int                  $ttl  Cache TTL in seconds.
		 *
		 * @return \WP_Query
		 */
		public static function query( array $args, int $ttl = 300 ) {
			if ( ! filter_var(
				get_option( 'htmega_query_cache_enabled', true ),
				FILTER_VALIDATE_BOOLEAN
			) ) {
				return new \WP_Query( $args );
			}

			if ( function_exists( 'htmega_is_editing_mode' ) && htmega_is_editing_mode() ) {
				return new \WP_Query( $args );
			}

			if ( apply_filters( 'htmega_query_cache_skip', false, $args ) ) {
				return new \WP_Query( $args );
			}

			$ttl_eff = apply_filters( 'htmega_query_cache_ttl', max( 0, $ttl ), $args );
			if ( $ttl_eff <= 0 ) {
				return new \WP_Query( $args );
			}

			$last_changed = function_exists( 'wp_get_last_changed' ) ? wp_get_last_changed( 'posts' ) : wp_cache_get_last_changed( 'posts' );
			$key          = 'htmega_q_' . md5( wp_json_encode( $args ) . $last_changed );

			$ids = get_transient( $key );

			if ( false === $ids ) {
				$query = new \WP_Query( $args );
				$ids   = wp_list_pluck( $query->posts, 'ID' );
				set_transient(
					$key,
					$ids,
					$ttl_eff
				);

				return $query;
			}

			if ( empty( $ids ) ) {
				$empty              = new \WP_Query();
				$empty->posts       = array();
				$empty->post_count  = 0;
				$empty->found_posts = 0;

				return $empty;
			}

			return new \WP_Query(
				array_merge(
					$args,
					array(
						'post__in'            => $ids,
						'orderby'             => 'post__in',
						'posts_per_page'      => count( $ids ),
						'ignore_sticky_posts' => true,
						'paged'               => 1,
						'offset'              => 0,
						'no_found_rows'       => true,
					)
				)
			);
		}
	}
}
