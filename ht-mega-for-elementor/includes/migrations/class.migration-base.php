<?php
/**
 * Shared helpers for HT Mega migrations.
 *
 * @package HTMega
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'HTMega_Migration_Base' ) ) {

	abstract class HTMega_Migration_Base {

		/**
		 * Run migration logic (implement in subclasses).
		 *
		 * @return void
		 */
		abstract public function migrate(): void;

		/**
		 * Entry called by the updater.
		 *
		 * @param string $previous_version Semver before this plugin version.
		 */
		public function run( string $previous_version ): void {
			unset( $previous_version );
			$this->migrate();
		}

		/**
		 * Snapshot data before writes (stored as no-autoload).
		 *
		 * @param string $migration_id Stable id for wp option key.
		 * @param mixed  $data         Payload (serializable).
		 */
		protected function backup( string $migration_id, $data ): void {
			$migration_id = sanitize_key( $migration_id );
			$wrapped      = array(
				'_created' => time(),
				'_data'    => $data,
			);
			update_option( 'htmega_backup_' . $migration_id, $wrapped, false );
		}

		/**
		 * Whether a stamped migration ran already.
		 *
		 * @param string $flag Short id (e.g. "310").
		 */
		protected function is_already_run( string $flag ): bool {
			return (bool) get_option( 'htmega_migrated_' . sanitize_key( $flag ), false );
		}

		/**
		 * Mark migration complete.
		 *
		 * @param string $flag Short id (e.g. "310").
		 */
		protected function mark_complete( string $flag ): void {
			update_option( 'htmega_migrated_' . sanitize_key( $flag ), HTMEGA_VERSION, false );
		}

		/**
		 * Append migration log lines (trimmed).
		 *
		 * @param string $message Log line.
		 */
		protected function log( string $message ): void {
			$logs = get_option( 'htmega_migration_log', array() );
			if ( ! is_array( $logs ) ) {
				$logs = array();
			}
			$logs[] = array(
				't' => time(),
				'm' => $message,
			);
			if ( count( $logs ) > 50 ) {
				$logs = array_slice( $logs, -50 );
			}
			update_option( 'htmega_migration_log', $logs, false );
		}
	}
}
