<?php

namespace HtMeaga\ElementorTemplate;
use Elementor\TemplateLibrary\Source_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Library_Source extends Source_Base {

	/**
	 * [get_id] Get remote template ID.
	 * @return [string] The remote template ID.
	 */
	public function get_id() {
		return 'htmega-library';
	}
	
	/**
	 * [get_title] Get remote template title. 
	 * Retrieve the remote template title.
	 * @return [string] The remote template title.
	 */
	public function get_title() {
		return __( 'HT Mega Library', 'ht-mega-for-elementor' );
	}
	
	/**
	 * [register_data] Register remote template data.
	 * Used to register custom template data like a post type, a taxonomy or any
	 * other data.
	 * @return [void]
	 */
	public function register_data() {}
	
	/**
	 * [get_items] Retrieve htmega templates from htmega library servers.
	 * @param  array  $args Optional. Nou used in htmega source.
	 * @return [array] Move templates.
	 */
	public function get_items( $args = [] ) {
		$library_data = self::get_library_data();

		$templates = [];
		if ( ! empty( $library_data['templates'] ) ) {
			foreach ( $library_data['templates'] as $template_data ) {
				$templates[] = $this->prepare_template( $template_data );
			}
		}
		return $templates;
	}

	/**
	 * [get_library_data] Retrieve the templates data from a htmega server.
	 * @param  boolean $force_update Optional. Whether to force the data update or
	 *  not. Default is false.
	 * @return [array] The templates data.
	 */
	public static function get_library_data() {

		$data = \HTMega_Template_Library::instance()->get_templates_info();

		if ( empty( $data ) ) {
			return [];
		}

		return $data;
	}
	
	/**
	 * [get_item Get remote template.] Retrieve a single remote template from Elementor.com servers.
	 * @param  [int] $template_id The template ID.
	 * @return [array] Remote template.
	 */
	public function get_item( $template_id ) {
		$templates = $this->get_items();

		return $templates[ $template_id ];
	}

	/**
	 * [save_item Save remote template.] Remote template from htmega servers cannot be saved on the
	 * database as they are retrieved from remote servers.
	 * @param  [array] $template_data Remote template data.
	 * @return \WP_Error 
	 */
	public function save_item( $template_data ) {
		return new \WP_Error( 'invalid_request', 'Cannot save template to a htmega source' );
	}

	/**
	 * [update_item Update remote template] Remote template from htmega servers cannot be updated on the database as they are retrieved from remote servers.
	 * @param  [array] $new_data New template data.
	 * @return \WP_Error
	 */
	public function update_item( $new_data ) {
		return new \WP_Error( 'invalid_request', 'Cannot update template to a htmega source' );
	}

	/**
	 * [delete_template Delete remote template.] Remote template from htmega servers cannot be deleted from the database as they are retrieved from remote servers.
	 * @param  [int] $template_id The template ID.
	 * @return \WP_Error 
	 */
	public function delete_template( $template_id ) {
		return new \WP_Error( 'invalid_request', 'Cannot delete template from a htmega source' );
	}
	
	/**
	 * [export_template Export remote template.] Remote template from htmega servers cannot be exported from the database as they are retrieved from remote servers.
	 * @param  [int] $template_id The template ID.
	 * @return \WP_Error
	 */
	public function export_template( $template_id ) {
		return new \WP_Error( 'invalid_request', 'Cannot export template from a htmega source' );
	}
	
	/**
	 * [get_data Get remote template data.] Retrieve the data of a single remote template from htmega servers.
	 * @param  array  $args    Custom template arguments.
	 * @param  string $context Optional. The context. Default is `display`.
	 * @return [array] Remote Template data.
	 */
	public function get_data( array $args, $context = 'display' ) {
		$data = self::get_template_content( $args['template_id'] );

		$data = json_decode( $data, true );

		if ( empty( $data ) || ! is_array( $data ) ) {
			throw new \Exception( esc_html__( 'Template does not have any content', 'ht-mega-for-elementor' ) );
		}

		// Resolve Elementor elements tree for widget auto-enable (same shapes as Theme Builder / varied API payloads).
		$resolved = array(
			'elements'       => array(),
			'page_settings'  => array(),
			'page_template'  => '',
		);
		if ( function_exists( 'htmega_resolve_remote_template_for_import' ) ) {
			$resolved = htmega_resolve_remote_template_for_import( $data );
		} elseif ( function_exists( 'htmega_normalize_remote_template_payload_for_import' ) ) {
			$resolved = htmega_normalize_remote_template_payload_for_import( $data );
		}

		$tpl_elements = isset( $resolved['elements'] ) && is_array( $resolved['elements'] ) ? $resolved['elements'] : array();
		if ( empty( $tpl_elements ) && isset( $data['content']['content'] ) && is_array( $data['content']['content'] ) ) {
			$tpl_elements = $data['content']['content'];
		}

		if ( empty( $tpl_elements ) ) {
			throw new \Exception( esc_html__( 'Template does not have any content', 'ht-mega-for-elementor' ) );
		}

		if ( ! isset( $data['content'] ) || ! is_array( $data['content'] ) ) {
			$data['content'] = array();
		}
		$data['content']['content'] = $tpl_elements;

		$tpl_page = array();
		if ( isset( $resolved['page_settings'] ) && is_array( $resolved['page_settings'] ) ) {
			$tpl_page = $resolved['page_settings'];
		}
		if ( isset( $data['page_settings'] ) && is_array( $data['page_settings'] ) ) {
			$tpl_page = array_merge( $tpl_page, $data['page_settings'] );
		}

		$htmega_options_changed = false;
		if ( function_exists( 'htmega_enable_widgets_for_imported_template_content' ) ) {
			$htmega_options_changed = htmega_enable_widgets_for_imported_template_content( $tpl_elements, $tpl_page );
		}

		// JSON key retained for backwards compatibility (JS: refresh widgets via get_widgets_config before import, not page reload).
		$needs_widgets_refresh = $htmega_options_changed;
		if ( ! $needs_widgets_refresh && function_exists( 'htmega_template_import_payload_uses_registered_htmega_widget_types' ) ) {
			$needs_widgets_refresh = htmega_template_import_payload_uses_registered_htmega_widget_types( $tpl_elements );
		}

		$data['content'] = $this->replace_elements_ids( $data['content']['content'] );
		$data['content'] = $this->process_export_import_content( $data['content'], 'on_import' );

		$post_id = $args['editor_post_id'];
		$document = htmega_get_elementor()->documents->get( $post_id );

		if ( $document ) {
			$data['content'] = $document->get_elements_raw_data( $data['content'], true );
		}

		/**
		 * When true, the editor scripts call Elementor `get_widgets_config` before `document/elements/import`
		 * so newly-enabled HT Mega widgets appear in `elementor.widgetsCache` (historic key name: reload).
		 *
		 * @param bool  $suggest_widgets_refresh Matching $needs_widgets_refresh before override.
		 * @param array $data                  Template payload (content processed for Elementor).
		 */
		$data['htmega_reload_editor'] = (bool) apply_filters(
			'htmega_template_import_suggest_editor_reload',
			$needs_widgets_refresh,
			$data
		);

		return $data;
	}

	/**
	 * [get_template_content Get template content.]
	 * @param  [int] $template_id The template ID.
	 * @return [array] The template content.
	 */
	public static function get_template_content( $template_id ) {
		if ( empty( $template_id ) ) {
			return;
		}

		$body = [
			'api_version'	=> HTMEGA_VERSION,
			'site_lang'		=> get_bloginfo( 'language' ),
			'home_url'		=> trailingslashit( home_url() ),
		];

		$content_url = sprintf( \HTMega_Template_Library::get_api_templateapi(), $template_id );

		global $wp_version;

		$response = wp_remote_get(
			$content_url,
			[
				'body'       => $body,
				'timeout'    => 60,
				'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url(),
			]
		);

		if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
			return '';
		}

		return wp_remote_retrieve_body( $response );
	}

	/**
	 * [prepare_template Prepare template items to match model]
	 * @param  array  $template_data [description]
	 * @return [array]  template list
	 */
	private function prepare_template( array $template_data ) {
		return [
			'template_id' => $template_data['id'],
			'title'       => $template_data['title'],
			'type'        => $template_data['type'],
			'thumbnail'   => $template_data['thumbnail'],
			'date'        => $template_data['human_date'],
			'tags'        => $template_data['tags'],
			'isPro'       => $template_data['isPro'],
			'url'         => $template_data['url'],
		];
	}

}