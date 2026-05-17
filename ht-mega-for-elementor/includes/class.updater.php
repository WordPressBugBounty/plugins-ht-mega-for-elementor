<?php
/**
 * Version migrations and upgrade hooks.
 *
 * @package HTMega
 */

defined( 'ABSPATH' ) || exit;

if ( class_exists( 'Updater' ) ) {
	return;
}

/**
 * Loads migration classes and executes registered upgrade steps once per target version.
 *
 * Supported bump from last stable **3.0.10** (and other **3.0.x**) to **3.1.0**: saved version may live in
 * `htmega_version` or legacy `htmega_elementor_addons_version` — both are read in {@see resolve_stored_version()}.
 */
class Updater {

	/**
	 * Whether hooks already registered for this request.
	 *
	 * @var bool
	 */
	protected static $hooks_registered = false;

	/**
	 * Register WordPress hooks (admin upgrades + cron).
	 *
	 * @return void
	 */
	public static function register_hooks(): void {
		if ( self::$hooks_registered ) {
			return;
		}
		self::$hooks_registered = true;

		add_action( 'admin_init', array( __CLASS__, 'maybe_run_upgrade' ), 5 );
		add_action( 'htmega_cleanup_backups', array( __CLASS__, 'cleanup_backup_options' ) );
		add_action(
			'init',
			static function (): void {
				if ( ! wp_next_scheduled( 'htmega_cleanup_backups' ) ) {
					wp_schedule_event( time() + HOUR_IN_SECONDS, 'daily', 'htmega_cleanup_backups' );
				}
			},
			20
		);
	}

	/**
	 * Target version migrations: version string => callable( string $previous_version ): void
	 *
	 * @return array<string, callable>
	 */
	protected static function get_registered_migrations(): array {
		$migrations = array();
		return apply_filters( 'htmega_plugin_migrations', $migrations );
	}

	/**
	 * Persist a migration runner error without stopping other migrations.
	 *
	 * @param Throwable $exception Exception thrown from a migration callable.
	 */
	protected static function record_migration_error( $exception ): void {
		if ( ! is_object( $exception ) || ! method_exists( $exception, 'getMessage' ) ) {
			return;
		}
		$entry = array(
			't'       => time(),
			'type'    => get_class( $exception ),
			'message' => $exception->getMessage(),
			'file'    => $exception->getFile(),
			'line'    => $exception->getLine(),
		);
		$errors = get_option( 'htmega_migration_errors', array() );
		if ( ! is_array( $errors ) ) {
			$errors = array();
		}
		$errors[] = $entry;
		if ( count( $errors ) > 50 ) {
			$errors = array_slice( $errors, -50 );
		}
		update_option( 'htmega_migration_errors', $errors, false );
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- debug-only breadcrumbs.
			error_log( '[HTMega migration] ' . $entry['type'] . ': ' . $entry['message'] );
		}
	}

	/**
	 * Normalize stored semver for comparisons.
	 *
	 * @param string|false $v Version or empty marker.
	 */
	protected static function normalize_version( $v ): string {
		if ( false === $v || null === $v ) {
			return '0';
		}
		$v = (string) $v;

		return '' === trim( $v ) ? '0' : trim( $v );
	}

	/**
	 * Read stored version marker; prefer canonical `htmega_version`, fall back to legacy option once.
	 *
	 * @return array{has_canonical:bool, version:string|false}
	 */
	protected static function resolve_stored_version(): array {
		$canonical = get_option( 'htmega_version', false );
		if ( false !== $canonical && '' !== trim( (string) $canonical ) ) {
			return array(
				'has_canonical' => true,
				'version'       => trim( (string) $canonical ),
			);
		}
		$legacy = get_option( 'htmega_elementor_addons_version', false );
		if ( false !== $legacy && '' !== trim( (string) $legacy ) ) {
			return array(
				'has_canonical' => false,
				'version'       => trim( (string) $legacy ),
			);
		}

		return array(
			'has_canonical' => false,
			'version'       => false,
		);
	}

	/**
	 * Run upgrade routine on admin bootstrap.
	 *
	 * @return void
	 */
	public static function maybe_run_upgrade(): void {
		if ( ! defined( 'HTMEGA_VERSION' ) ) {
			return;
		}

		self::maybe_run_stamp_migrations();

		self::maybe_complete_partial_migrations();

		$resolved = self::resolve_stored_version();

		if ( false === $resolved['version'] ) {
			update_option( 'htmega_version', HTMEGA_VERSION, false );
			update_option( 'htmega_elementor_addons_version', HTMEGA_VERSION );
			do_action( 'htmega_updated', HTMEGA_VERSION, false );

			return;
		}

		$previous_norm = self::normalize_version( $resolved['version'] );

		// e.g. 3.0.10 < 3.1.0 → run semver migrations (htmega_plugin_migrations key '3.1.0').
		if ( version_compare( $previous_norm, HTMEGA_VERSION, '>=' ) ) {
			if ( ! $resolved['has_canonical'] ) {
				update_option( 'htmega_version', $resolved['version'], false );
			}

			return;
		}

		update_option( 'htmega_elementor_addons_previous_version', $resolved['version'] );

		$migrations = self::get_registered_migrations();
		uksort( $migrations, 'version_compare' );

		$applied_cursor = self::normalize_version( $resolved['version'] );

		foreach ( $migrations as $migration_version => $callback ) {
			if ( ! is_callable( $callback ) ) {
				continue;
			}
			$m_version = self::normalize_version( (string) $migration_version );
			if ( version_compare( $applied_cursor, $m_version, '>=' ) ) {
				continue;
			}

			try {
				call_user_func( $callback, (string) $resolved['version'] );
				if ( version_compare( $applied_cursor, $m_version, '<' ) ) {
					$applied_cursor = $m_version;
				}
			} catch ( Throwable $exception ) {
				self::record_migration_error( $exception );
			}
		}

		if ( version_compare( $previous_norm, HTMEGA_VERSION, '<' ) && class_exists( 'HTMega_Elementor_Assests_Cache', false ) ) {
			try {
				$assets_cache = new HTMega_Elementor_Assests_Cache();
				$assets_cache->delete_all();
			} catch ( Throwable $exception ) {
				self::record_migration_error( $exception );
			}
		}

		update_option( 'htmega_version', HTMEGA_VERSION, false );
		update_option( 'htmega_elementor_addons_version', HTMEGA_VERSION );
		do_action( 'htmega_updated', HTMEGA_VERSION, $resolved['version'] );
	}

	/**
	 * Delete migration backup snapshots older than 90 days (expects wrapped backups from Migration_Base).
	 *
	 * @return void
	 */
	public static function cleanup_backup_options(): void {
		global $wpdb;

		if ( ! isset( $wpdb->options ) ) {
			return;
		}

		$table = esc_sql( $wpdb->options );

		// phpcs:disable WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$names = $wpdb->get_col(
			"SELECT option_name FROM {$table} WHERE option_name LIKE 'htmega_backup_%'"
		);
		// phpcs:enable

		foreach ( $names as $name ) {
			$value = get_option( $name, false );
			if ( ! is_array( $value ) || ! isset( $value['_created'] ) ) {
				continue;
			}
			$created = absint( $value['_created'] );
			if ( $created <= 0 ) {
				continue;
			}
			if ( ( time() - $created ) > ( 90 * DAY_IN_SECONDS ) ) {
				delete_option( $name );
			}
		}
	}

	/**
	 * Run idempotent migrations keyed by option stamp (not semver).
	 *
	 * Register via filter `htmega_stamp_migrations`:
	 * `[ [ 'id' => 'my_migration_id', 'callback' => callable ], ... ]`
	 *
	 * @return void
	 */
	public static function maybe_run_stamp_migrations(): void {
		/** @var array<int, array{id:string, callback:callable}> $queued */
		$queued = apply_filters( 'htmega_stamp_migrations', array() );
		if ( empty( $queued ) || ! is_array( $queued ) ) {
			return;
		}
		foreach ( $queued as $item ) {
			if ( ! is_array( $item ) || empty( $item['id'] ) || empty( $item['callback'] ) || ! is_callable( $item['callback'] ) ) {
				continue;
			}
			$flag = sanitize_key( (string) $item['id'] );
			if ( '' === $flag || get_option( 'htmega_migrated_' . $flag, false ) ) {
				continue;
			}
			try {
				call_user_func( $item['callback'] );
				update_option( 'htmega_migrated_' . $flag, true, false );
			} catch ( Throwable $exception ) {
				self::record_migration_error( $exception );
			}
		}
	}

	/**
	 * Run idempotent callbacks when stored version already matches {@see HTMEGA_VERSION} but an older build left a half-finished migration (e.g. `htmega_migrated_310_assets` set without `htmega_migrated_310`).
	 *
	 * Register via filter {@see 'htmega_partial_migration_fixes'}: `apply_filters( 'htmega_partial_migration_fixes', array() )`
	 * returns a list of callables. Runs on every {@see maybe_run_upgrade()} before semver early-return.
	 *
	 * @return void
	 */
	protected static function maybe_complete_partial_migrations(): void {
		/** @var array<int, callable> $callbacks */
		$callbacks = apply_filters( 'htmega_partial_migration_fixes', array() );
		if ( empty( $callbacks ) || ! is_array( $callbacks ) ) {
			return;
		}
		foreach ( $callbacks as $callback ) {
			if ( ! is_callable( $callback ) ) {
				continue;
			}
			try {
				call_user_func( $callback );
			} catch ( Throwable $exception ) {
				self::record_migration_error( $exception );
			}
		}
	}
}
