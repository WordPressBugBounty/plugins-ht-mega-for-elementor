<?php
/**
 * Applies safe defaults when a site updates past older HT Mega (via {@see Updater::maybe_run_upgrade()}).
 *
 * Registered on {@see 'htmega_plugin_migrations'} using {@see HTMEGA_SEMVER_MIGRATION_310}.
 *
 * Completion markers:
 * - **`htmega_migrated_310_assets`** — performance defaults (`htmega_force_global_assets`, `htmega_query_cache_enabled`).
 * - **`htmega_migrated_310`** — Theme Builder **3.1.0 upgrade step** recorded (duplicate buffered `wp_head` suppression
 *   lives in code; Elementor TB CSS pre-enqueues on {@see 'wp_enqueue_scripts'} — no separate option required).
 *
 * Prior builds may have used other **`htmega_migrated_*`** keys; {@see HTMega_Migration_310::normalize_migration_option_keys()}
 * rewrites them on first admin load.
 *
 * Half-finished states are repaired via {@see 'htmega_partial_migration_fixes'} inside {@see Updater},
 * including when stored version already equals {@see HTMEGA_VERSION}.
 *
 * **Direct update from 3.0.10 → 3.1.0:** both halves run on first admin load after update (Elementor active).
 *
 * @package HTMega
 */

defined( 'ABSPATH' ) || exit;

/**
 * Migration registry version key ({@see 'htmega_plugin_migrations'}). Keep **3.1.0** when releasing **3.1.1**+
 * unless new defaults require another keyed migration block.
 */
const HTMEGA_SEMVER_MIGRATION_310 = '3.1.0';

/**
 * 3.1.0 upgrade defaults — does not overwrite explicit user saves.
 */
final class HTMega_Migration_310 extends HTMega_Migration_Base {

	/**
	 * Move legacy option keys to current names so **`htmega_migrated_310`** means Theme Builder step complete.
	 *
	 * @return void
	 */
	public function normalize_migration_option_keys(): void {
		$perf_assets = get_option( 'htmega_migrated_310_assets', false );
		$key310      = get_option( 'htmega_migrated_310', false );

		if ( $key310 && ! $perf_assets ) {
			update_option( 'htmega_migrated_310_assets', $key310, false );
			delete_option( 'htmega_migrated_310' );
		}

		foreach ( array( '311', '310_wp_head' ) as $legacy_flag ) {
			$legacy_val = get_option( 'htmega_migrated_' . $legacy_flag, false );
			if ( ! $legacy_val ) {
				continue;
			}
			if ( ! get_option( 'htmega_migrated_310', false ) ) {
				update_option( 'htmega_migrated_310', $legacy_val, false );
			}
			delete_option( 'htmega_migrated_' . $legacy_flag );
		}
	}

	/**
	 * @return void
	 */
	public function migrate(): void {
		$this->normalize_migration_option_keys();

		if ( ! $this->is_already_run( '310_assets' ) ) {
			add_option( 'htmega_force_global_assets', true, '', false );
			add_option( 'htmega_query_cache_enabled', true, '', false );

			$this->backup(
				'310_assets',
				array(
					'note' => 'Upgrade default: global HT Mega asset compatibility on all pages; widget query cache enabled. Options only added if missing.',
				)
			);

			$this->mark_complete( '310_assets' );
			$this->log( 'htmega migrated: performance defaults (assets + query cache)' );
		}

		if ( ! $this->is_already_run( '310' ) ) {
			$this->backup(
				'310',
				array(
					'note' => 'Theme Builder 3.1.0: unconditional remove_all_actions before buffered theme header.php; Elementor header/footer document CSS pre-enqueued on wp_enqueue_scripts (htmega_enqueue_theme_builder_elementor_document_styles). No wp_head runtime option.',
				)
			);

			$this->mark_complete( '310' );
			$this->log( 'htmega migrated: theme builder 3.1.0 header/footer stylesheet pipeline' );
		}
	}
}

add_filter(
	'htmega_plugin_migrations',
	static function ( array $migrations ): array {
		$migrations[ HTMEGA_SEMVER_MIGRATION_310 ] = static function ( string $previous_version ): void {
			unset( $previous_version );
			( new HTMega_Migration_310() )->run( '' );
		};

		return $migrations;
	}
);

add_filter(
	'htmega_partial_migration_fixes',
	static function ( array $callbacks ): array {
		$callbacks[] = static function (): void {
			if ( ! class_exists( 'HTMega_Migration_310', false ) ) {
				return;
			}
			$migration = new HTMega_Migration_310();
			$migration->normalize_migration_option_keys();
			if ( get_option( 'htmega_migrated_310', false ) ) {
				return;
			}
			if ( ! get_option( 'htmega_migrated_310_assets', false ) ) {
				return;
			}
			$migration->run( '' );
		};
		return $callbacks;
	}
);
