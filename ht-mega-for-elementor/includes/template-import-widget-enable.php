<?php
/**
 * When importing HT Mega library templates, turn on HT Mega / Pro widgets (Elements tab),
 * Theme Builder / Menu Builder nested module toggles (Modules tab), and any feature modules
 * implied by imported Elementor settings (Particles, Wrapper Link, Floating Effects, …).
 *
 * @package HTMega_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @param mixed $raw Elementor elements as JSON string or array.
 * @return array
 */
function htmega_template_import_parse_elements_tree( $raw ) {
	if ( is_string( $raw ) ) {
		$decoded = json_decode( $raw, true );
		if ( JSON_ERROR_NONE !== json_last_error() ) {
			return [];
		}
		return is_array( $decoded ) ? $decoded : [];
	}
	return is_array( $raw ) ? $raw : [];
}

/**
 * @param array $elements Elementor elements tree.
 * @param array $collector Output; keys are widget type strings.
 */
function htmega_template_import_collect_widget_types( $elements, array &$collector ) {
	if ( ! is_array( $elements ) ) {
		return;
	}
	foreach ( $elements as $el ) {
		if ( ! is_array( $el ) ) {
			continue;
		}
		if ( isset( $el['elType'] ) && 'widget' === $el['elType'] && ! empty( $el['widgetType'] ) ) {
			$collector[ $el['widgetType'] ] = true;
		}
		if ( ! empty( $el['elements'] ) && is_array( $el['elements'] ) ) {
			htmega_template_import_collect_widget_types( $el['elements'], $collector );
		}
	}
}

/**
 * Normalize JSON decoded from the HT Mega remote template API into Elementor elements + page_settings.
 * Handles shapes used by Elementor exports (`content.content`), legacy flat trees, and JSON-string `content`.
 *
 * @param array $decoded Top-level decoded API response.
 * @return array{elements: array, page_settings: array, page_template: string}
 */
function htmega_normalize_remote_template_payload_for_import( array $decoded ) {
	$page_settings = isset( $decoded['page_settings'] ) && is_array( $decoded['page_settings'] ) ? $decoded['page_settings'] : array();
	$page_template = isset( $decoded['page_template'] ) ? (string) $decoded['page_template'] : '';
	$elements      = array();

	if ( isset( $decoded['content'] ) ) {
		$c = $decoded['content'];
		if ( is_string( $c ) ) {
			$inner = json_decode( $c, true );
			if ( is_array( $inner ) ) {
				if ( isset( $inner['content'] ) && is_array( $inner['content'] ) ) {
					$elements = $inner['content'];
				} else {
					$elements = $inner;
				}
			}
		} elseif ( is_array( $c ) ) {
			if ( isset( $c['content'] ) && is_array( $c['content'] ) ) {
				$elements = $c['content'];
			} else {
				$elements = $c;
			}
		}
	}

	if ( ! is_array( $elements ) ) {
		$elements = array();
	}

	if ( empty( $elements ) && isset( $decoded['elements'] ) && is_array( $decoded['elements'] ) && htmega_template_import_array_is_elementor_elements_list( $decoded['elements'] ) ) {
		$elements = $decoded['elements'];
	}

	if ( empty( $elements ) && isset( $decoded['data']['content']['content'] ) && is_array( $decoded['data']['content']['content'] ) ) {
		$elements = $decoded['data']['content']['content'];
	}

	if ( empty( $page_settings ) && isset( $decoded['data']['page_settings'] ) && is_array( $decoded['data']['page_settings'] ) ) {
		$page_settings = $decoded['data']['page_settings'];
	}

	if ( ! is_array( $elements ) ) {
		$elements = array();
	}

	return array(
		'elements'       => $elements,
		'page_settings'  => $page_settings,
		'page_template'  => $page_template,
	);
}

/**
 * True when $arr is a sequential list of Elementor nodes (each has elType).
 *
 * @param array $arr Array to check.
 * @return bool
 */
function htmega_template_import_array_is_elementor_elements_list( array $arr ) {
	if ( array() === $arr ) {
		return false;
	}
	$keys = array_keys( $arr );
	if ( $keys !== range( 0, count( $arr ) - 1 ) ) {
		return false;
	}
	$first = reset( $arr );

	return is_array( $first ) && isset( $first['elType'] );
}

/**
 * Breadth-first search for the first Elementor elements tree inside an arbitrary decoded payload.
 *
 * @param array $root Decoded JSON root.
 * @return array|null
 */
function htmega_template_import_find_first_elementor_elements_tree( array $root ) {
	$queue   = array( $root );
	$visited = 0;
	while ( ! empty( $queue ) && $visited < 500 ) {
		$visited++;
		$node = array_shift( $queue );
		if ( ! is_array( $node ) ) {
			continue;
		}
		if ( htmega_template_import_array_is_elementor_elements_list( $node ) ) {
			return $node;
		}
		foreach ( $node as $child ) {
			if ( is_array( $child ) ) {
				$queue[] = $child;
			}
		}
	}

	return null;
}

/**
 * Resolve elements + meta after {@see htmega_normalize_remote_template_payload_for_import()} (adds deep fallback).
 *
 * @param array $decoded Valid JSON-decoded template API root.
 * @return array{elements: array, page_settings: array, page_template: string}
 */
function htmega_resolve_remote_template_for_import( array $decoded ) {
	$norm = htmega_normalize_remote_template_payload_for_import( $decoded );
	if ( empty( $norm['elements'] ) ) {
		$found = htmega_template_import_find_first_elementor_elements_tree( $decoded );
		if ( null !== $found ) {
			$norm['elements'] = $found;
		}
	}

	return $norm;
}

/**
 * Fetch and decode HT Mega remote template JSON (HTTP 200 + valid JSON only).
 * Matches {@see \HtMeaga\ElementorTemplate\Library_Source::get_template_content()} (same URL params/body).
 *
 * @param string|int $template_id Remote template id.
 * @return array|null Decoded associative array or null on failure.
 */
function htmega_fetch_remote_template_api_decoded( $template_id ) {
	$template_id = sanitize_text_field( (string) $template_id );
	if ( '' === $template_id || ! class_exists( 'HTMega_Template_Library' ) ) {
		return null;
	}

	global $wp_version;

	// Match Library_Source::get_template_content() so Theme Builder preflight gets the same JSON the editor library receives.
	$url = sprintf( \HTMega_Template_Library::get_api_templateapi(), $template_id );
	$response = wp_remote_get(
		$url,
		array(
			'body'       => array(
				'api_version' => HTMEGA_VERSION,
				'site_lang'   => get_bloginfo( 'language' ),
				'home_url'    => trailingslashit( home_url() ),
			),
			'timeout'    => 60,
			'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url(),
		)
	);

	if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
		return null;
	}

	$body = wp_remote_retrieve_body( $response );
	if ( ! is_string( $body ) || '' === $body ) {
		return null;
	}

	$decoded = json_decode( $body, true );

	return is_array( $decoded ) ? $decoded : null;
}

/**
 * Fetch remote HT Mega library JSON for a template id and run widget/module auto-enable (Theme Builder + Template Library parity).
 *
 * Loaded from core includes so this runs for Free and Pro (Pro ships its own Theme Builder class file).
 *
 * @param string $template_id Remote library template id.
 * @return array{ decoded_ok: bool, enabled_called: bool }
 */
function htmega_sync_tb_widgets_from_remote_template_id( $template_id ) {
	$template_id = sanitize_text_field( (string) $template_id );
	$result      = array(
		'decoded_ok'     => false,
		'enabled_called' => false,
	);

	if ( '' === $template_id ) {
		return $result;
	}

	if (
		! function_exists( 'htmega_fetch_remote_template_api_decoded' )
		|| ! function_exists( 'htmega_resolve_remote_template_for_import' )
		|| ! function_exists( 'htmega_enable_widgets_for_imported_template_content' )
	) {
		return $result;
	}

	$decoded = htmega_fetch_remote_template_api_decoded( $template_id );
	if ( ! is_array( $decoded ) ) {
		return $result;
	}

	$result['decoded_ok'] = true;

	$resolved  = htmega_resolve_remote_template_for_import( $decoded );
	$elements  = isset( $resolved['elements'] ) && is_array( $resolved['elements'] ) ? $resolved['elements'] : array();
	$page_sets = isset( $resolved['page_settings'] ) && is_array( $resolved['page_settings'] ) ? $resolved['page_settings'] : array();

	htmega_enable_widgets_for_imported_template_content( $elements, $page_sets );
	$result['enabled_called'] = true;

	return $result;
}

/**
 * Theme Builder create-template AJAX: sync widget options from remote sample before the Theme Builder handler runs (works with Free + Pro Theme Builder classes).
 */
function htmega_tb_ajax_create_template_preflight_widgets() {
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'htmega_template_builder_nonce' ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$selected_template = isset( $_POST['selected_template'] ) ? sanitize_text_field( wp_unslash( $_POST['selected_template'] ) ) : '';
	if ( '' === $selected_template || ! function_exists( 'htmega_sync_tb_widgets_from_remote_template_id' ) ) {
		return;
	}
	htmega_sync_tb_widgets_from_remote_template_id( $selected_template );
}

add_action( 'wp_ajax_htmega_create_template', 'htmega_tb_ajax_create_template_preflight_widgets', 5 );

/**
 * Deep-scan arbitrary settings arrays for HTMega module hints (popover/repeater payloads, etc.).
 *
 * @param array $data Recursive structure.
 * @param array $signals Mutable map of canonical signal keys → true.
 * @param int   $depth   Recursion guard.
 */
function htmega_template_import_scan_settings_recursive( $data, array &$signals, $depth = 0 ) {
	if ( $depth > 30 || ! is_array( $data ) ) {
		return;
	}
	foreach ( $data as $key => $value ) {
		if ( is_string( $key ) ) {
			switch ( $key ) {
				case 'htmega_fe':
					if ( 'yes' === $value ) {
						$signals['floating_effects'] = true;
					}
					break;
				case 'htmega_particle_switcher':
					if ( 'yes' === $value ) {
						$signals['particles_module']  = true;
						$signals['particles_modulep'] = true;
					}
					break;
				case 'htmega_parallax_switcher':
					if ( 'yes' === $value ) {
						$signals['parallax_module']  = true;
						$signals['parallax_modulep'] = true;
					}
					break;
				case 'htmega_advanced_sticky_switcher':
					if ( 'yes' === $value ) {
						// Advance tab Vue stores `advanced_sticky_modulep`; Pro runtime uses `advanced_sticky_module`.
						$signals['advanced_sticky_module']  = true;
						$signals['advanced_sticky_modulep'] = true;
					}
					break;
				case 'htmega_condition_enable':
					if ( 'yes' === $value ) {
						$signals['d_conditional_module']  = true;
						$signals['d_conditional_modulep'] = true;
					}
					break;
				case 'htmega_custom_css':
					if ( is_string( $value ) && strlen( trim( $value ) ) > 0 ) {
						$signals['custom_css_module']  = true;
						$signals['custom_css_modulep'] = true;
					}
					break;
				case 'htmega_element_link':
					if ( is_array( $value ) && ! empty( $value['url'] ) ) {
						$signals['wrapperlink'] = true;
					}
					break;
				default:
					break;
			}
		}
		if ( is_array( $value ) ) {
			htmega_template_import_scan_settings_recursive( $value, $signals, $depth + 1 );
		}
	}
}

/**
 * Build module enable signals from the element tree plus optional Elementor document page settings.
 *
 * @param array $elements      Parsed Elementor elements.
 * @param array $page_settings Document settings blob (often from template API `page_settings`).
 * @return array<string,bool>
 */
function htmega_template_import_collect_module_signals( array $elements, $page_settings = array() ) {
	$signals = array();

	if ( is_array( $page_settings ) ) {
		if ( isset( $page_settings['htmega_rpbar_enable'] ) && 'yes' === $page_settings['htmega_rpbar_enable'] ) {
			$signals['htmega_rpbar'] = true;
		}
		if ( isset( $page_settings['htmega_stt_enable'] ) && 'yes' === $page_settings['htmega_stt_enable'] ) {
			$signals['htmega_stt'] = true;
		}
		htmega_template_import_scan_settings_recursive( $page_settings, $signals );
	}

	$walker = null;
	$walker = static function ( $nodes ) use ( &$signals, &$walker ) {
		if ( ! is_array( $nodes ) ) {
			return;
		}
		foreach ( $nodes as $el ) {
			if ( ! is_array( $el ) ) {
				continue;
			}
			if ( isset( $el['widgetType'] ) && is_string( $el['widgetType'] ) ) {
				$wt = $el['widgetType'];
				if ( 0 === strpos( $wt, 'bl-', 0 ) ) {
					$signals['themebuilder'] = true;
				}
				if ( 'htmega-menu-inline-menu' === $wt || 'htmega-menu-verticle-menu' === $wt ) {
					$signals['megamenubuilder'] = true;
				}
			}
			if ( ! empty( $el['settings'] ) && is_array( $el['settings'] ) ) {
				htmega_template_import_scan_settings_recursive( $el['settings'], $signals );
			}
			if ( ! empty( $el['elements'] ) ) {
				$walker( $el['elements'] );
			}
		}
	};

	$walker( $elements );

	return apply_filters( 'htmega_template_import_module_signals', $signals, $elements, $page_settings );
}

/**
 * Merge switches into HT Mega “Modules / extensions” bucket (htmega_advance_element_tabs).
 *
 * @param array<string,true> $flags Option id => truthy marker.
 * @return bool True when the saved option differs from storage (an update occurred).
 */
function htmega_template_import_merge_advance_tabs( array $flags ) {
	if ( empty( $flags ) ) {
		return false;
	}
	$opts = get_option( 'htmega_advance_element_tabs', array() );
	if ( ! is_array( $opts ) ) {
		$opts = array();
	}
	$changed = false;
	foreach ( array_keys( $flags ) as $fid ) {
		if ( isset( $opts[ $fid ] ) && 'on' === $opts[ $fid ] ) {
			continue;
		}
		$opts[ $fid ] = 'on';
		$changed    = true;
	}
	if ( ! $changed ) {
		return false;
	}
	update_option( 'htmega_advance_element_tabs', $opts );
	return true;
}

/**
 * Merge keys into JSON blob stored inside a module settings option (theme builder, mega menu, STT, …).
 *
 * @param string $storage_option WP option storing multiple JSON groups.
 * @param string $group_id       Inner key (`themebuilder`, `megamenubuilder`, `htmega_stt`, …).
 * @param array  $pairs          Key/value pairs merged into decoded JSON object.
 * @return bool True when the stored blob actually changed.
 */
function htmega_template_import_merge_nested_module_blob( $storage_option, $group_id, array $pairs ) {
	if ( '' === (string) $storage_option || '' === (string) $group_id || empty( $pairs ) ) {
		return false;
	}
	$storage = get_option( $storage_option, array() );
	if ( ! is_array( $storage ) ) {
		$storage = array();
	}
	$blob = isset( $storage[ $group_id ] ) ? $storage[ $group_id ] : '';
	if ( is_string( $blob ) ) {
		$decoded = json_decode( $blob, true );
	} elseif ( is_array( $blob ) ) {
		$decoded = $blob;
	} else {
		$decoded = array();
	}
	if ( ! is_array( $decoded ) ) {
		$decoded = array();
	}
	$changed = false;
	foreach ( $pairs as $k => $v ) {
		$prev = array_key_exists( $k, $decoded ) ? $decoded[ $k ] : null;
		if ( $prev !== $v ) {
			$changed = true;
		}
		$decoded[ $k ] = $v;
	}
	if ( ! $changed ) {
		return false;
	}
	$storage[ $group_id ] = wp_json_encode( $decoded );
	update_option( $storage_option, $storage );
	return true;
}

/**
 * Enable HT Mega Modules + nested toggles inferred from imported template markup / document settings.
 *
 * @param array<string,bool> $signals Signal map from {@see htmega_template_import_collect_module_signals()}.
 * @return bool True when any module option blob or advance-tab option was updated.
 */
function htmega_template_import_enable_modules_from_signals( array $signals ) {
	if ( empty( $signals ) ) {
		return false;
	}

	$advance_keys = array();
	$changed      = false;

	if ( ! empty( $signals['megamenubuilder'] ) ) {
		$advance_keys['megamenubuilder'] = true;
		$changed                         = htmega_template_import_merge_nested_module_blob(
			'htmega_megamenu_module_settings',
			'megamenubuilder',
			array( 'megamenubuilder_enable' => 'on' )
		) || $changed;
	}

	if ( ! empty( $signals['themebuilder'] ) ) {
		$advance_keys['themebuilder'] = true;
		$changed                      = htmega_template_import_merge_nested_module_blob(
			'htmega_themebuilder_module_settings',
			'themebuilder',
			array( 'themebuilder_enable' => 'on' )
		) || $changed;
	}

	if ( ! empty( $signals['htmega_rpbar'] ) ) {
		$advance_keys['htmega_rpbar'] = true;
		$changed                      = htmega_template_import_merge_nested_module_blob(
			'htmega_rpbar_module_settings',
			'htmega_rpbar',
			array( 'rpbar_enable' => 'on' )
		) || $changed;
	}

	if ( ! empty( $signals['htmega_stt'] ) ) {
		$advance_keys['htmega_stt'] = true;
		$changed                   = htmega_template_import_merge_nested_module_blob(
			'htmega_stt_module_settings',
			'htmega_stt',
			array( 'stt_enable' => 'on' )
		) || $changed;
	}

	$configurable = array(
		'wrapperlink'                => true,
		'floating_effects'           => true,
		'particles_module'           => true,
		'particles_modulep'          => true,
		'parallax_module'            => true,
		'parallax_modulep'           => true,
		'd_conditional_module'       => true,
		'd_conditional_modulep'       => true,
		'advanced_sticky_module'      => true,
		'advanced_sticky_modulep'    => true,
		'custom_css_module'          => true,
		'custom_css_modulep'         => true,
	);

	foreach ( $configurable as $flag => $_ ) {
		if ( ! empty( $signals[ $flag ] ) ) {
			$advance_keys[ $flag ] = true;
		}
	}

	if ( ! empty( $advance_keys ) ) {
		$changed = htmega_template_import_merge_advance_tabs( $advance_keys ) || $changed;
	}

	return $changed;
}

/**
 * Map Elementor widget type (get_name) to HT Mega settings option key and options section.
 * Tuple: [ option_key, section_option_name ].
 *
 * @return array<string, array{0: string, 1: string}>
 */
function htmega_template_import_widget_type_settings_map() {
	static $map = null;
	if ( null !== $map ) {
		return $map;
	}

	$main             = 'htmega_element_tabs';
	$third            = 'htmega_thirdparty_element_tabs';
	$themebuilder_tab = 'htmega_themebuilder_element_tabs';

	$map = array(
		'htmega-accordion-addons'            => array( 'accordion', $main ),
		'htmega-animatedheading-addons'      => array( 'animatesectiontitle', $main ),
		'htmega-addbanner-addons'            => array( 'addbanner', $main ),
		'htmega-specialdaybanner-addons'     => array( 'specialadsbanner', $main ),
		'htmega-blockquote-addons'           => array( 'blockquote', $main ),
		'htmega-brand-addons'                => array( 'brandlogo', $main ),
		'htmega-businesshours-addons'        => array( 'businesshours', $main ),
		'htmega-button-addons'               => array( 'button', $main ),
		'htmega-calltoaction-addons'         => array( 'calltoaction', $main ),
		'htmega-carousel-addons'             => array( 'carousel', $main ),
		'htmega-countdown-addons'            => array( 'countdown', $main ),
		'htmega-counter-addons'              => array( 'counter', $main ),
		'htmega-customevent-addons'          => array( 'customevent', $main ),
		'htmega-dualbutton-addons'           => array( 'dualbutton', $main ),
		'htmega-dropcaps-addons'             => array( 'dropcaps', $main ),
		'htmega-flipbox-addons'              => array( 'flipbox', $main ),
		'htmega-galleryjustify-addons'       => array( 'galleryjustify', $main ),
		'htmega-google-map-addons'           => array( 'googlemap', $main ),
		'htmega-imagecomparison-addons'      => array( 'imagecomparison', $main ),
		'htmega-imagegrid-addons'            => array( 'imagegrid', $main ),
		'htmega-imagemagnifier-addons'       => array( 'imagemagnifier', $main ),
		'htmega-imagemarker-addons'          => array( 'imagemarker', $main ),
		'htmega-imagemasonryd-addons'        => array( 'imagemasonry', $main ),
		'htmega-inlinemenu-addons'           => array( 'inlinemenu', $main ),
		'htmega-instagram-addons'            => array( 'instagram', $main ),
		'htmega-magnific-popup-addons'       => array( 'lightbox', $main ),
		'htmega-modal-addons'                => array( 'modal', $main ),
		'htmega-newtsicker-addons'           => array( 'newtsicker', $main ),
		'htmega-notify-addons'               => array( 'notify', $main ),
		'htmega-offcanvas-addons'            => array( 'offcanvas', $main ),
		'htmega-panelslider-addons'          => array( 'panelslider', $main ),
		'htmega-popover-addons'              => array( 'popover', $main ),
		'htmega-postcarousel-addons'         => array( 'postcarousel', $main ),
		'htmega-postgrid-addons'             => array( 'postgrid', $main ),
		'htmega-postgridtab-addons'          => array( 'postgridtab', $main ),
		'htmega-postslider-addons'           => array( 'postslider', $main ),
		'htmega-pricinglistview-addons'      => array( 'pricinglistview', $main ),
		'htmega-pricing-table-addons'        => array( 'pricingtable', $main ),
		'htmega-progressbar-addons'          => array( 'progressbar', $main ),
		'htmega-scrollimage-addons'          => array( 'scrollimage', $main ),
		'htmega-scrollnavigation-addons'     => array( 'scrollnavigation', $main ),
		'htmega-search-addons'               => array( 'search', $main ),
		'section-title-addons'               => array( 'sectiontitle', $main ),
		'htmega-service-addons'              => array( 'service', $main ),
		'htmega-singlepost-addons'           => array( 'singlepost', $main ),
		'htmega-thumbgallery-addons'         => array( 'thumbgallery', $main ),
		'htmega-social-shere-addons'         => array( 'socialshere', $main ),
		'htmega-switcher-addons'             => array( 'switcher', $main ),
		'htmega-tab-addons'                  => array( 'tabs', $main ),
		'htmega-datatable-addons'            => array( 'datatable', $main ),
		'htmega-team-member-addons'          => array( 'teammember', $main ),
		'htmega-testimonial-addons'          => array( 'testimonial', $main ),
		'htmega-testimonialgrid-addons'      => array( 'testimonialgrid', $main ),
		'htmega-toggle-addons'               => array( 'toggle', $main ),
		'htmega-tooltip-addons'              => array( 'tooltip', $main ),
		'htmega-twitterfeed-addons'          => array( 'twitterfeed', $main ),
		'htmega-userlogin-form-addons'       => array( 'userloginform', $main ),
		'htmega-userregister-form-addons'    => array( 'userregisterform', $main ),
		'htmega-verticletimeline-addons'     => array( 'verticletimeline', $main ),
		'htmega-videoplayer-addons'          => array( 'videoplayer', $main ),
		'htmega-working-process-addons'      => array( 'workingprocess', $main ),
		'htmega-errorcontent-addons'         => array( 'errorcontent', $main ),
		'htmega-template-selector'           => array( 'template_selector', $main ),
		'htmega-weather-addons'              => array( 'weather', $main ),
		'htmega-audio-player-addons'         => array( 'audio_player', $main ),
		'htmega-calendly-addons'             => array( 'calendly', $main ),
		'htmega-bbpress-addons'              => array( 'bbpress', $third ),
		'htmega-bookedcalender-addons'       => array( 'bookedcalender', $third ),
		'htmega-buddypress-addons'           => array( 'buddypress', $third ),
		'htmega-calderaform-addons'          => array( 'calderaform', $third ),
		'htmega-contactform-addons'          => array( 'contactform', $third ),
		'htmega-downloadmonitor-addons'      => array( 'downloadmonitor', $third ),
		'htmega-easydigitaldownload-addons'  => array( 'easydigitaldownload', $third ),
		'htmega-gravityforms-addons'         => array( 'gravityforms', $third ),
		'htmega-instragramfeed-addons'       => array( 'instragramfeed', $third ),
		'htmega-jobmanager-addons'           => array( 'jobmanager', $third ),
		'htmega-layerslider-addons'          => array( 'layerslider', $third ),
		'htmega-mailchimp-wp-addons'         => array( 'mailchimpwp', $third ),
		'htmega-ninjaform-addons'            => array( 'ninjaform', $third ),
		'htmega-quforms-addons'              => array( 'quforms', $third ),
		'htmega-wpforms-addons'              => array( 'wpforms', $third ),
		'htmega-revolution-addons'           => array( 'revolution', $third ),
		'htmega-tablepress-addons'           => array( 'tablepress', $third ),
		'htmega-wcaddtocart-addons'          => array( 'wcaddtocart', $third ),
		'htmega-categories-addons'           => array( 'categories', $third ),
		'htmega-wcpages-addons'              => array( 'wcpages', $third ),

		/*
		 * HT Mega Pro — widget option keys mirror `classes/class.widgets-control.php` (htmega_element_tabs).
		 * Widgets that overlap Free (`htmega-accordion-addons`, etc.) are already mapped above.
		 */
		'htmega-view-counter-addons'                 => array( 'htmega_view_counter', $main ),
		'htmega-sticky-section-addons'               => array( 'htmega_sticky_section', $main ),
		'htmega-image-roted-addons'                  => array( 'htmega_image_roted', $main ),
		'htmega-lottie-addons'                       => array( 'lottie', $main ),
		'htmega-event-calendar-addons'             => array( 'event_calendar', $main ),
		'htmega-info-box-addons'                     => array( 'info_box', $main ),
		'htmega-category-list-addons'                => array( 'category_list', $main ),
		'htmega-pricing-menu-addons'                 => array( 'pricing_menu', $main ),
		'htmega-feature-list-addons'                 => array( 'feature_list', $main ),
		'htmega-social-network-icons-addons'         => array( 'social_network_icons', $main ),
		'htmega-taxonomy-terms-addons'               => array( 'taxonomy_terms', $main ),
		'htmega-background-switcher'                  => array( 'background_switcher', $main ),
		'htmega-facebook-review-addons'              => array( 'facebook_review', $main ),
		'htmega-breadcrumbs'                         => array( 'breadcrumbs', $main ),
		'htmega-page-list-addons'                    => array( 'page_list', $main ),
		'htmega-team-carousel-addons'                => array( 'team_carousel', $main ),
		'htmega-icon-box-addons'                     => array( 'icon_box', $main ),
		'htmega-interactive-promo-addons'            => array( 'interactive_promo', $main ),
		'htmega-event-box-addons'                    => array( 'event_box', $main ),
		'htmega-filterable-gallery-addons'           => array( 'filterable_gallery', $main ),
		'htmega-whatsapp-chat-addons'                => array( 'whatsapp_chat', $main ),
		'htmega-chart-addons'                        => array( 'chart', $main ),
		'htmega-post-timeline-addons'                => array( 'post_timeline', $main ),
		'htmega-post-masonry-addons'                 => array( 'post_masonry', $main ),
		'htmega-source-code-addons'                  => array( 'source_code', $main ),
		'htmega-threesixty-rotation-addons'          => array( 'threesixty_rotation', $main ),
		'htmega-pricing-table-flip-box'             => array( 'pricing_table_flip_box', $main ),
		'htmega-flip-switcher-pricing-table-addons'  => array( 'flip_switcher_pricing_table', $main ),
		'htmega-dynamic-gallery-addons'              => array( 'dynamic_gallery', $main ),
		'htmega-advanced-slider-addons'              => array( 'advanced_slider', $main ),
		'htmega-flip-carousel-addons'                => array( 'flip_carousel', $main ),
		'htmega-interactive-circle-infographic-addons' => array( 'interactive_circle_infographic', $main ),
		'htmega-copy-coupon-code-addons'             => array( 'copy_coupon_code', $main ),
		'htmega-video-gallery-addons'                => array( 'video_gallery', $main ),
		'htmega-video-playlist-addons'               => array( 'video_playlist', $main ),
		'htmega-blob-shape-addons'                   => array( 'blob_shape', $main ),

		// HT Mega Builder (Theme Builder category): Elementor `widgetType` matches each widget class `get_name()`; option ids match Options_field (htmega_themebuilder_element_tabs).
		'bl-single-blog-title'     => array( 'bl_post_title', $themebuilder_tab ),
		'bl-post-featured-image'   => array( 'bl_post_featured_image', $themebuilder_tab ),
		'bl-post-meta-info'        => array( 'bl_post_meta_info', $themebuilder_tab ),
		'bl-post-excerpt'          => array( 'bl_post_excerpt', $themebuilder_tab ),
		'bl-post-content'          => array( 'bl_post_content', $themebuilder_tab ),
		'bl-post-commnets'         => array( 'bl_post_comments', $themebuilder_tab ),
		'bl-post-search-form'      => array( 'bl_post_search_form', $themebuilder_tab ),
		'bl-post-archive'          => array( 'bl_post_archive', $themebuilder_tab ),
		'bl-post-archive-title'    => array( 'bl_post_archive_title', $themebuilder_tab ),
		'bl-page-title'            => array( 'bl_page_title', $themebuilder_tab ),
		'bl-site-title'            => array( 'bl_site_title', $themebuilder_tab ),
		'bl-site-logo'             => array( 'bl_site_logo', $themebuilder_tab ),
		'bl-nav-menu'              => array( 'bl_nav_menu', $themebuilder_tab ),
		'bl-post-author-info'      => array( 'bl_post_author_info', $themebuilder_tab ),

		// HT Mega Pro Theme Builder widgets (settings option ids use `p` suffix in `htmega_themebuilder_element_tabs`).
		'bl-popular-post'         => array( 'bl_popular_postp', $themebuilder_tab ),
		'bl-social-share'         => array( 'bl_social_sharep', $themebuilder_tab ),
		'bl-related-post'         => array( 'bl_related_postp', $themebuilder_tab ),
		'bl-print-page'           => array( 'bl_print_pagep', $themebuilder_tab ),
		'bl-post-navigation'      => array( 'bl_post_navigationp', $themebuilder_tab ),
		'bl-view-counter'         => array( 'bl_view_counterp', $themebuilder_tab ),

		// HT Mega 2026 Collection — Elementor widgets (get_name() = 'htmega-2026-{slug}'; option key = htmega_sections_element_tabs, default 'on').
		'htmega-2026-hero'         => array( 'hero', 'htmega_sections_element_tabs' ),
		'htmega-2026-about'        => array( 'about', 'htmega_sections_element_tabs' ),
		'htmega-2026-services'     => array( 'services', 'htmega_sections_element_tabs' ),
		'htmega-2026-pricing'      => array( 'pricing', 'htmega_sections_element_tabs' ),
		'htmega-2026-testimonials' => array( 'testimonials', 'htmega_sections_element_tabs' ),
		'htmega-2026-stats'        => array( 'stats', 'htmega_sections_element_tabs' ),
		'htmega-2026-cta'          => array( 'cta', 'htmega_sections_element_tabs' ),
		'htmega-2026-team'         => array( 'team', 'htmega_sections_element_tabs' ),
		'htmega-2026-faq'          => array( 'faq', 'htmega_sections_element_tabs' ),
		'htmega-2026-blog'         => array( 'blog', 'htmega_sections_element_tabs' ),
		'htmega-2026-contact'      => array( 'contact', 'htmega_sections_element_tabs' ),

		// HT Mega 2026 Collection — FSE Gutenberg blocks (block name = 'htmega/{slug}-2025'; option key = htmega_sections_gutenberg_tabs, default 'off').
		'htmega/hero-2025'         => array( 'hero-2025', 'htmega_sections_gutenberg_tabs' ),
		'htmega/about-2025'        => array( 'about-2025', 'htmega_sections_gutenberg_tabs' ),
		'htmega/services-2025'     => array( 'services-2025', 'htmega_sections_gutenberg_tabs' ),
		'htmega/pricing-2025'      => array( 'pricing-2025', 'htmega_sections_gutenberg_tabs' ),
		'htmega/testimonials-2025' => array( 'testimonials-2025', 'htmega_sections_gutenberg_tabs' ),
		'htmega/stats-2025'        => array( 'stats-2025', 'htmega_sections_gutenberg_tabs' ),
		'htmega/cta-2025'          => array( 'cta-2025', 'htmega_sections_gutenberg_tabs' ),
		'htmega/team-2025'         => array( 'team-2025', 'htmega_sections_gutenberg_tabs' ),
		'htmega/faq-2025'          => array( 'faq-2025', 'htmega_sections_gutenberg_tabs' ),
		'htmega/blog-2025'         => array( 'blog-2025', 'htmega_sections_gutenberg_tabs' ),
		'htmega/contact-2025'      => array( 'contact-2025', 'htmega_sections_gutenberg_tabs' ),
	);

	$map = apply_filters( 'htmega_template_import_widget_type_settings_map', $map );
	return $map;
}

/**
 * Enable HT Mega Elements (widgets), Theme Builder / Menu Builder module toggles,
 * extension modules implied by markup, and Reading Progress Bar / Scroll To Top when
 * the imported document turns them on in Page Settings.
 *
 * @param mixed      $elementor_raw_content JSON string or array (Elementor `content` subtree).
 * @param mixed|null $page_settings         Template `page_settings` array from API decode, optional.
 * @return bool True when any HT Mega WP option was changed (client should refresh widgets config before import).
 */
function htmega_enable_widgets_for_imported_template_content( $elementor_raw_content, $page_settings = null ) {

	$options_changed = false;

	$page_settings_arr = array();
	if ( is_array( $page_settings ) ) {
		$page_settings_arr = $page_settings;
	}

	$elements = htmega_template_import_parse_elements_tree( $elementor_raw_content );
	if ( ! is_array( $elements ) ) {
		$elements = array();
	}

	$found_types = array();
	if ( ! empty( $elements ) ) {
		htmega_template_import_collect_widget_types( $elements, $found_types );
	}

	if ( apply_filters( 'htmega_auto_enable_widgets_on_template_import', true ) ) {
		if ( ! empty( $found_types ) ) {
			$map           = htmega_template_import_widget_type_settings_map();
			$tabs_to_touch = array();

			foreach ( array_keys( $found_types ) as $widget_type ) {
				if ( empty( $map[ $widget_type ] ) ) {
					continue;
				}

				list( $option_key, $tab_key ) = $map[ $widget_type ];
				$tabs_to_touch[ $tab_key ][ $option_key ] = true;
			}

			foreach ( $tabs_to_touch as $tab_key => $keys ) {
				$opts = get_option( $tab_key, array() );
				if ( ! is_array( $opts ) ) {
					$opts = array();
				}
				$tab_changed = false;
				foreach ( array_keys( $keys ) as $k ) {
					if ( isset( $opts[ $k ] ) && 'on' === $opts[ $k ] ) {
						continue;
					}
					$opts[ $k ] = 'on';
					$tab_changed = true;
				}
				if ( $tab_changed ) {
					update_option( $tab_key, $opts );
					$options_changed = true;
				}
			}
		}
	}

	if ( ! apply_filters( 'htmega_auto_enable_modules_on_template_import', true ) ) {
		return $options_changed;
	}

	if ( empty( $elements ) && empty( $page_settings_arr ) ) {
		return $options_changed;
	}

	$signals = htmega_template_import_collect_module_signals( $elements, $page_settings_arr );

	foreach ( array_keys( $found_types ) as $wt ) {
		if ( is_string( $wt ) && 0 === strpos( $wt, 'bl-', 0 ) ) {
			$signals['themebuilder'] = true;
		}
	}

	if ( empty( $signals ) ) {
		return $options_changed;
	}

	$modules_touched = htmega_template_import_enable_modules_from_signals( $signals );

	return $modules_touched || $options_changed;
}

/**
 * Whether the elements tree uses an HT Mega / Theme Builder Elementor widget whose editor registration
 * depends on PHP options merged at AJAX time (client should refresh `get_widgets_config` before import).
 *
 * @param mixed $elements_raw Elementor content subtree (array or JSON string).
 * @return bool
 */
function htmega_template_import_payload_uses_registered_htmega_widget_types( $elements_raw ) {
	$elements = htmega_template_import_parse_elements_tree( $elements_raw );
	if ( empty( $elements ) ) {
		return false;
	}
	$found = array();
	htmega_template_import_collect_widget_types( $elements, $found );
	if ( empty( $found ) ) {
		return false;
	}
	$map = htmega_template_import_widget_type_settings_map();
	foreach ( array_keys( $found ) as $wt ) {
		if ( ! is_string( $wt ) || '' === $wt ) {
			continue;
		}
		if ( isset( $map[ $wt ] ) ) {
			return true;
		}
		if ( 0 === strpos( $wt, 'htmega-', 0 ) || 0 === strpos( $wt, 'bl-', 0 ) ) {
			return true;
		}
		if ( false !== strpos( $wt, 'htmega' ) ) {
			return true;
		}
	}
	return false;
}
