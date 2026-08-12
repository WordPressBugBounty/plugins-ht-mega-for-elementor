<?php
/**
 * AI Section Assistant — widget capability manifest.
 *
 * One entry per HT Mega 2026-collection widget. This is the single source of
 * truth the AI Section Assistant is allowed to choose from — the model never
 * names a widget, layout, or field directly; every choice is validated against
 * this file, and a bad choice falls back to a safe default instead of being
 * trusted blindly. See blueprint/ai-builder/ai-builder-phase1-implementation.php
 * for the reasoning.
 *
 * Deliberately excluded from `content_fields` / repeater field lists:
 * factual/numeric claims (stat numbers, prices), URLs, media, icon-adjacent
 * config selects, and toggles — the AI fills descriptive prose, not facts a
 * user hasn't actually confirmed. Icon fields ARE included (an FA5 class
 * string, not a fact), but the assembler must fall back to the widget's
 * existing default if the model returns something unrecognized.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Icon fields are constrained to this list, the same way widget selection is
 * constrained to the manifest — the model never free-types an icon class.
 * Two reasons: (1) a hallucinated class that doesn't exist renders nothing;
 * (2) CLAUDE.md's own widget-pattern doc flags specific Font Awesome 6-only
 * icons (fa-shield-halved, fa-circle-check, etc.) that silently don't render
 * with the FA5 set HT Mega ships — this list is deliberately FA5-safe only.
 * All 'fas' (solid) style, which is what every 2026 widget's icon control
 * defaults to.
 *
 * @return string[]
 */
function htmega_ai_get_icon_enum() {
	return [
		'fas fa-star', 'fas fa-check', 'fas fa-check-circle', 'fas fa-heart',
		'fas fa-thumbs-up', 'fas fa-users', 'fas fa-user', 'fas fa-chart-line',
		'fas fa-cog', 'fas fa-shield-alt', 'fas fa-lightbulb', 'fas fa-rocket',
		'fas fa-globe', 'fas fa-leaf', 'fas fa-seedling', 'fas fa-fire',
		'fas fa-utensils', 'fas fa-clock', 'fas fa-calendar-alt', 'fas fa-map-marker-alt',
		'fas fa-phone', 'fas fa-envelope', 'fas fa-comment', 'fas fa-comments',
		'fas fa-award', 'fas fa-trophy', 'fas fa-gift', 'fas fa-truck',
		'fas fa-shopping-cart', 'fas fa-credit-card', 'fas fa-lock', 'fas fa-key',
		'fas fa-tools', 'fas fa-book', 'fas fa-graduation-cap', 'fas fa-briefcase',
		'fas fa-handshake', 'fas fa-hand-holding-heart', 'fas fa-tree', 'fas fa-sun',
		'fas fa-bolt', 'fas fa-mobile-alt', 'fas fa-laptop', 'fas fa-camera',
		'fas fa-palette', 'fas fa-paint-brush', 'fas fa-home', 'fas fa-building',
	];
}

/**
 * Human-readable design-style names, matching the exact preset naming used
 * throughout this project's own CLAUDE.md (Bento Grid, Glassmorphism, Dark
 * Minimal, Aurora, Neo-Brutalist) — not the raw internal slug ('bento',
 * 'glass', etc.) a user has no reason to recognize.
 *
 * @return string
 */
function htmega_ai_get_design_style_label( $style ) {
	$labels = [
		'bento'  => 'Bento Grid',
		'glass'  => 'Glassmorphism',
		'dark'   => 'Dark Minimal',
		'aurora' => 'Aurora',
		'neo'    => 'Neo-Brutalist',
	];
	return $labels[ $style ] ?? ucfirst( $style );
}

/**
 * Human-readable layout name — mechanical (hyphens to spaces, title case),
 * since layout slugs like 'split-left' or 'info-only' are already close to
 * readable and don't need a hand-maintained per-widget label map the way
 * design styles and widget names do.
 *
 * @return string
 */
function htmega_ai_get_layout_label( $layout ) {
	return ucwords( str_replace( '-', ' ', $layout ) );
}

/**
 * @return array<string, array> Manifest keyed by short slug (e.g. 'hero').
 */
function htmega_ai_get_section_manifest() {
	static $manifest = null;

	if ( null !== $manifest ) {
		return $manifest;
	}

	$manifest = [

		'hero' => [
			'file'                  => 'htmega_2025_hero.php',
			'elementor_widget_name' => 'htmega-2026-hero',
			'label'                 => 'Hero',
			'section_type'          => [ 'hero' ],
			'layout_variants'       => [ 'centered', 'split-left', 'split-right' ],
			'design_styles'         => [ 'bento', 'glass', 'dark', 'aurora', 'neo' ],
			'content_fields'        => [
				'headline'            => 'text_multiline',
				'headline_highlight'  => 'text',
				'description'         => 'text_multiline',
				'badge_text'          => 'text',
				'primary_btn_text'    => 'text',
				'secondary_btn_text'  => 'text',
				'social_proof_text'   => 'text',
				'floating_stat_label' => 'text',
			],
			'repeaters'             => [],
		],

		'about' => [
			'file'                  => 'htmega_2025_about.php',
			'elementor_widget_name' => 'htmega-2026-about',
			'label'                 => 'About',
			'section_type'          => [ 'about', 'story' ],
			'layout_variants'       => [ 'split-left', 'split-right', 'centered', 'feature-grid' ],
			'design_styles'         => [ 'bento', 'glass', 'dark', 'aurora', 'neo' ],
			'content_fields'        => [
				'section_label_text' => 'text',
				'headline'           => 'text_multiline',
				'headline_highlight' => 'text',
				'description'        => 'text_multiline',
				'floating_stat_number' => 'text',
				'floating_stat_label' => 'text',
				'cta_text'           => 'text',
			],
			'repeaters'             => [
				'feature_items' => [
					'feature_icon'        => 'icon',
					'feature_title'       => 'text',
					'feature_description' => 'text_multiline',
				],
			],
		],

		'services' => [
			'file'                  => 'htmega_2025_services.php',
			'elementor_widget_name' => 'htmega-2026-services',
			'label'                 => 'Services',
			'section_type'          => [ 'services', 'feature-grid' ],
			'layout_variants'       => [ 'grid', 'list', 'centered' ],
			'design_styles'         => [ 'bento', 'glass', 'dark', 'aurora', 'neo' ],
			'content_fields'        => [
				'section_label_text' => 'text',
				'headline'           => 'text_multiline',
				'headline_highlight' => 'text',
				'description'        => 'text_multiline',
				'cta_text'           => 'text',
			],
			'repeaters'             => [
				'service_items' => [
					'service_icon'        => 'icon',
					'service_title'       => 'text',
					'service_description' => 'text_multiline',
					'service_link_text'   => 'text',
				],
			],
		],

		'pricing' => [
			'file'                  => 'htmega_2025_pricing.php',
			'elementor_widget_name' => 'htmega-2026-pricing',
			'label'                 => 'Pricing',
			'section_type'          => [ 'pricing' ],
			'layout_variants'       => [ 'cards', 'centered' ],
			'design_styles'         => [ 'bento', 'glass', 'dark', 'aurora', 'neo' ],
			'content_fields'        => [
				'section_label_text'    => 'text',
				'headline'              => 'text_multiline',
				'headline_highlight'    => 'text',
				'description'           => 'text_multiline',
				'billing_monthly_label' => 'text',
				'billing_annual_label'  => 'text',
				'billing_save_badge'    => 'text',
			],
			'repeaters'             => [
				// price_monthly / price_annual / currency / period intentionally excluded — factual
				// numeric claims the user must set, not something the AI should invent.
				'plan_items' => [
					'plan_name'      => 'text',
					'featured_badge' => 'text',
					'plan_icon'      => 'icon',
					'tagline'        => 'text',
					'features'       => 'text_list', // one feature per line — see htmega_ai_schema_property_for_type()
					'cta_text'       => 'text',
				],
			],
		],

		'testimonials' => [
			'file'                  => 'htmega_2025_testimonials.php',
			'elementor_widget_name' => 'htmega-2026-testimonials',
			'label'                 => 'Testimonials',
			'section_type'          => [ 'testimonials', 'social-proof' ],
			'layout_variants'       => [ 'grid', 'masonry', 'centered' ],
			'design_styles'         => [ 'bento', 'glass', 'dark', 'aurora', 'neo' ],
			'content_fields'        => [
				'section_label_text' => 'text',
				'headline'           => 'text_multiline',
				'headline_highlight' => 'text',
				'description'        => 'text_multiline',
			],
			'repeaters'             => [
				// rating / avatar are user-provided, not generated.
				'testimonial_items' => [
					'quote_text'     => 'text_multiline',
					'author_name'    => 'text',
					'author_role'    => 'text',
					'author_company' => 'text',
				],
			],
		],

		'stats' => [
			'file'                  => 'htmega_2025_stats.php',
			'elementor_widget_name' => 'htmega-2026-stats',
			'label'                 => 'Stats',
			'section_type'          => [ 'stats', 'counter' ],
			'layout_variants'       => [ 'row', 'grid', 'bento' ],
			'design_styles'         => [ 'bento', 'glass', 'dark', 'aurora', 'neo' ],
			'content_fields'        => [
				'section_label_text' => 'text',
				'headline'           => 'text_multiline',
				'headline_highlight' => 'text',
				'description'        => 'text_multiline',
			],
			'repeaters'             => [
				// stat_number / stat_prefix / stat_suffix intentionally excluded — these are
				// factual claims about the business (revenue, client count, etc.) that only
				// the user can know; the AI must never invent them.
				'stat_items' => [
					'stat_icon'  => 'icon',
					'stat_label' => 'text',
				],
			],
		],

		'cta' => [
			'file'                  => 'htmega_2025_cta.php',
			'elementor_widget_name' => 'htmega-2026-cta',
			'label'                 => 'CTA',
			'section_type'          => [ 'cta' ],
			'layout_variants'       => [ 'centered', 'split', 'banner' ],
			'design_styles'         => [ 'bento', 'glass', 'dark', 'aurora', 'neo' ],
			'content_fields'        => [
				'section_label_text' => 'text',
				'headline'           => 'text_multiline',
				'headline_highlight' => 'text',
				'description'        => 'text_multiline',
				'primary_cta_text'   => 'text',
				'secondary_cta_text' => 'text',
			],
			'repeaters'             => [],
		],

		'team' => [
			'file'                  => 'htmega_2025_team.php',
			'elementor_widget_name' => 'htmega-2026-team',
			'label'                 => 'Team',
			'section_type'          => [ 'team' ],
			'layout_variants'       => [ 'grid', 'list', 'featured' ],
			'design_styles'         => [ 'bento', 'glass', 'dark', 'aurora', 'neo' ],
			'content_fields'        => [
				'section_label_text' => 'text',
				'headline'           => 'text_multiline',
				'headline_highlight' => 'text',
				'description'        => 'text_multiline',
			],
			'repeaters'             => [
				'team_members' => [
					'member_name'       => 'text',
					'member_role'       => 'text',
					'member_bio'        => 'text_multiline',
					'member_department' => 'text',
				],
			],
		],

		'faq' => [
			'file'                  => 'htmega_2025_faq.php',
			'elementor_widget_name' => 'htmega-2026-faq',
			'label'                 => 'FAQ',
			'section_type'          => [ 'faq' ],
			'layout_variants'       => [ 'simple', 'grid', 'boxed' ],
			'design_styles'         => [ 'bento', 'glass', 'dark', 'aurora', 'neo' ],
			'content_fields'        => [
				'section_label_text' => 'text',
				'headline'           => 'text_multiline',
				'headline_highlight' => 'text',
				'description'        => 'text_multiline',
			],
			'repeaters'             => [
				'faq_items' => [
					'faq_question' => 'text',
					'faq_answer'   => 'text_multiline',
					'faq_category' => 'text',
				],
			],
		],

		'blog' => [
			'file'                  => 'htmega_2025_blog.php',
			'elementor_widget_name' => 'htmega-2026-blog',
			'label'                 => 'Blog',
			'section_type'          => [ 'blog-feed', 'posts' ],
			'layout_variants'       => [ 'grid', 'list', 'featured' ],
			'design_styles'         => [ 'bento', 'glass', 'dark', 'aurora', 'neo' ],
			'content_fields'        => [
				// Posts render from WP_Query — nothing to generate there. Only the section
				// chrome around the feed is AI-fillable.
				'section_label_text' => 'text',
				'headline'           => 'text_multiline',
				'headline_highlight' => 'text',
				'description'        => 'text_multiline',
				'read_more_text'     => 'text',
			],
			'repeaters'             => [],
		],

		'contact' => [
			'file'                  => 'htmega_2025_contact.php',
			'elementor_widget_name' => 'htmega-2026-contact',
			'label'                 => 'Contact',
			'section_type'          => [ 'contact' ],
			'layout_variants'       => [ 'split', 'centered', 'info-only' ],
			'design_styles'         => [ 'bento', 'glass', 'dark', 'aurora', 'neo' ],
			'content_fields'        => [
				'section_label_text' => 'text',
				'headline'           => 'text_multiline',
				'headline_highlight' => 'text',
				'description'        => 'text_multiline',
				'form_title'         => 'text',
				'form_subtitle'      => 'text',
				'hours_title'        => 'text',
				'social_title'       => 'text',
				'trust_label'        => 'text',
				'trust_subtext'      => 'text',
			],
			'repeaters'             => [
				// info_link / icon_type / social network+url are config, not prose.
				'contact_info_items' => [
					'info_label' => 'text',
					'info_value' => 'text',
				],
				'hours_items'        => [
					'hours_day'  => 'text',
					'hours_time' => 'text',
				],
			],
		],

	];

	return $manifest;
}

/**
 * @return array|null The manifest entry for $slug, or null if it doesn't exist.
 */
function htmega_ai_get_section_manifest_entry( $slug ) {
	$manifest = htmega_ai_get_section_manifest();
	return isset( $manifest[ $slug ] ) ? $manifest[ $slug ] : null;
}

/**
 * JSON-schema for the "selection" call — the model picks a widget_slug (from
 * the closed list of manifest keys), then a layout_variant and design_style
 * as free strings. Layout/style are validated server-side against that
 * specific widget's allowed lists in htmega_ai_validate_selection() — kept as
 * plain strings rather than a conditional per-widget enum here because a
 * single flat JSON schema can't express "valid options depend on which widget
 * was just chosen" across all three providers cleanly.
 *
 * @return array
 */
function htmega_ai_get_selection_schema() {
	$manifest = htmega_ai_get_section_manifest();

	return [
		'type'       => 'object',
		'properties' => [
			'widget_slug'    => [
				'type' => 'string',
				'enum' => array_keys( $manifest ),
			],
			'layout_variant' => [ 'type' => 'string' ],
			'design_style'   => [
				'type' => 'string',
				'enum' => [ 'bento', 'glass', 'dark', 'aurora', 'neo' ],
			],
			'no_match'       => [
				'type'        => 'boolean',
				'description' => 'Set true (and leave other fields as any valid placeholder) if none of the available widgets fit the request.',
			],
		],
		'required'   => [ 'widget_slug', 'layout_variant', 'design_style', 'no_match' ],
		// Required by OpenAI's strict structured-output mode for every object
		// schema node (harmless/ignored by Claude and Gemini, which don't require
		// it but recognize the same JSON-Schema keyword without erroring on it).
		'additionalProperties' => false,
	];
}

/**
 * Server-side validation for the selection call's output. Never trust the
 * model's layout_variant/design_style blindly — fall back to the widget's
 * first defined option on any mismatch rather than passing through a value
 * Elementor doesn't recognize.
 *
 * @return array{widget_slug:string, layout_variant:string, design_style:string}|null
 *         Null if widget_slug isn't a real manifest entry or no_match was set.
 */
function htmega_ai_validate_selection( array $selection ) {
	if ( ! empty( $selection['no_match'] ) ) {
		return null;
	}

	$entry = htmega_ai_get_section_manifest_entry( $selection['widget_slug'] ?? '' );
	if ( ! $entry ) {
		return null;
	}

	$layout = $selection['layout_variant'] ?? '';
	if ( ! in_array( $layout, $entry['layout_variants'], true ) ) {
		$layout = $entry['layout_variants'][0];
	}

	$style = $selection['design_style'] ?? '';
	if ( ! in_array( $style, $entry['design_styles'], true ) ) {
		$style = $entry['design_styles'][0];
	}

	return [
		'widget_slug'    => $selection['widget_slug'],
		'layout_variant' => $layout,
		'design_style'   => $style,
	];
}

/**
 * Schema fragment for one content field, based on its manifest type. Icon
 * fields get constrained to htmega_ai_get_icon_enum() — the same
 * never-let-the-model-free-type principle as widget selection — so the
 * model can't return a Font Awesome 6-only class that silently fails to
 * render (or any string at all that doesn't map to a real icon).
 *
 * @return array
 */
function htmega_ai_schema_property_for_type( $field_type ) {
	if ( 'icon' === $field_type ) {
		// Nullable, not just constrained — most HT Mega section designs don't use
		// icons at all (a design call, not a rendering limitation: the widgets
		// already correctly hide the icon block when unset). Forcing a real icon
		// on every field means one always appears whether the prompt asked for it
		// or not. Kept in the schema's 'required' list (OpenAI's strict mode
		// requires every property to be there), but the VALUE is allowed to be
		// null — the model's documented way to express "optional" in strict mode.
		$enum   = htmega_ai_get_icon_enum();
		$enum[] = null;
		return [
			'type' => [ 'string', 'null' ],
			'enum' => $enum,
		];
	}

	if ( 'text_list' === $field_type ) {
		// A field-level instruction, not just a shared prompt line — scales cleanly
		// to any future widget field with the same "one item per line" need without
		// having to special-case field names in the prompt-building code. Without
		// this, the model reasonably (but wrongly) writes one natural sentence
		// joining items with semicolons/commas instead — confirmed bug: pricing's
		// 'features' rendered as a single joined line because the widget's
		// explode( "\n", ... ) split found nothing to split on.
		return [
			'type'        => 'string',
			'description' => 'One item per line, separated by literal newline characters (\n) — NOT semicolons or commas. Example: "Unlimited Projects\n50 GB Storage\nPriority Support".',
		];
	}

	return [ 'type' => 'string' ];
}

/**
 * Build the JSON-schema for the "content" call, specific to one widget —
 * called only after htmega_ai_validate_selection() has confirmed a real
 * widget slug, so this schema always matches a widget that actually exists.
 *
 * @return array
 */
function htmega_ai_get_content_schema( $slug ) {
	$entry = htmega_ai_get_section_manifest_entry( $slug );
	if ( ! $entry ) {
		return [ 'type' => 'object', 'properties' => [], 'required' => [], 'additionalProperties' => false ];
	}

	$properties = [];
	$required   = [];

	foreach ( $entry['content_fields'] as $field => $field_type ) {
		$properties[ $field ] = htmega_ai_schema_property_for_type( $field_type );
		$required[]           = $field;
	}

	foreach ( $entry['repeaters'] as $repeater_key => $item_fields ) {
		$item_properties = [];
		$item_required   = [];
		foreach ( $item_fields as $field => $field_type ) {
			$item_properties[ $field ] = htmega_ai_schema_property_for_type( $field_type );
			$item_required[]           = $field;
		}

		$properties[ $repeater_key ] = [
			'type'  => 'array',
			'items' => [
				'type'       => 'object',
				'properties' => $item_properties,
				'required'   => $item_required,
				'additionalProperties' => false, // required by OpenAI strict mode, see below
			],
			// Row-count guidance (was minItems/maxItems) dropped: OpenAI's strict
			// structured-output mode doesn't support array length constraints —
			// the content prompt's own instructions carry that guidance instead.
		];
		$required[] = $repeater_key;
	}

	return [
		'type'       => 'object',
		'properties' => $properties,
		'required'   => $required,
		'additionalProperties' => false,
	];
}
