<?php
/**
 * AI Section Assistant — generation endpoint.
 *
 * Orchestrates: prompt -> (1) manifest-constrained widget/layout/style
 * selection -> (2) content generation scoped to that widget's real fields ->
 * (3) deterministic Elementor element JSON assembly. No LLM involvement in
 * step 3, which is why the output can't come back structurally broken.
 *
 * See blueprint/ai-builder/ai-builder-phase1-implementation.php and
 * ai-builder-build-spec.md for the full reasoning.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class HTMega_AI_Section_Assistant {

	private static $instance = null;

	/**
	 * Fixed section list per page type — deliberately hardcoded, never AI-decided.
	 * Keeps "build a full page" a closed problem (same shape as single-section
	 * widget selection) instead of the open-ended sitemap-planning problem that's
	 * explicitly Phase 3 scope, not this one. See ai-builder-build-spec.php §4.
	 */
	const PAGE_TYPES = [
		'home'     => [ 'hero', 'services', 'testimonials', 'stats', 'cta' ],
		'about'    => [ 'hero', 'about', 'team', 'cta' ],
		'services' => [ 'hero', 'services', 'pricing', 'faq', 'cta' ],
		'contact'  => [ 'hero', 'contact' ],
	];

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {
		add_action( 'wp_ajax_htmega_ai_generate_section', [ $this, 'handle_generate_section' ] );
		add_action( 'wp_ajax_htmega_ai_select_page_sections', [ $this, 'handle_select_page_sections' ] );
		add_action( 'wp_ajax_htmega_ai_render_preview', [ $this, 'handle_render_preview' ] );
		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		// The sparkle button lives inside the preview iframe (elementor.$previewContents),
		// a separate document from the top editor chrome — a stylesheet enqueued only via
		// 'elementor/editor/before_enqueue_scripts' never reaches it. Same hook the proven
		// template-library injector uses for its own iframe-side styling
		// (class.htmega-elementor-template-library.php's 'elementor/preview/enqueue_styles').
		add_action( 'elementor/preview/enqueue_styles', [ $this, 'enqueue_preview_styles' ] );
	}

	/**
	 * Editor JS for the prompt panel + insertion logic. Separate handle/file from
	 * the field-level AI Writer's script — different concern, different lifecycle.
	 */
	public function enqueue_scripts() {
		// Free for now — BYOK already means the user's own API key bears the cost,
		// not HasThemes, so there's no cost-driven reason to gate this behind Pro.
		// See ai-builder-cost-benefit.md if this changes later.
		wp_enqueue_style(
			'htmega-ai-section-assistant',
			HTMEGA_ADDONS_PL_URL . 'admin/assets/css/htmega-ai-section-assistant.css',
			[],
			HTMEGA_VERSION
		);

		wp_enqueue_script(
			'htmega-ai-section-assistant',
			HTMEGA_ADDONS_PL_URL . 'admin/assets/js/htmega-ai-section-assistant.js',
			[ 'jquery', 'elementor-editor' ],
			HTMEGA_VERSION,
			true
		);

		wp_localize_script( 'htmega-ai-section-assistant', 'htmegaAISectionAssistant', [
			'ajaxurl'         => admin_url( 'admin-ajax.php' ),
			'nonce'           => wp_create_nonce( 'htmega_ai_nonce' ),
			'generateAction'  => 'htmega_ai_generate_section',
			'selectPageSectionsAction' => 'htmega_ai_select_page_sections',
			'renderPreviewAction' => 'htmega_ai_render_preview',
			'strings'         => [
				'panelTitle'    => esc_html__( 'Build with HT Mega AI', 'ht-mega-for-elementor' ),
				'promptLabel'   => esc_html__( 'What would you like to generate?', 'ht-mega-for-elementor' ),
				'placeholder'   => esc_html__( 'Describe the section you want — e.g. "services section for a law firm, dark and serious"', 'ht-mega-for-elementor' ),
				'pageNamePlaceholder' => esc_html__( 'Page/business name — e.g. "Bella Vista Restaurant"', 'ht-mega-for-elementor' ),
				'pageNameHint'  => esc_html__( 'Optional. Keeps your business name consistent across every generated section.', 'ht-mega-for-elementor' ),
				'generating'    => esc_html__( 'Generating…', 'ht-mega-for-elementor' ),
				// {current}/{total}/{slug} placeholders — plain string replace in JS
				// (page generation is now a client-driven loop of small per-section
				// requests instead of one long server-side request, so JS needs to
				// show live per-section progress; see generate()'s isPage branch).
				'planningPage'  => esc_html__( 'Planning page sections…', 'ht-mega-for-elementor' ),
				'generatingSection' => esc_html__( 'Generating {current} of {total}: {slug}…', 'ht-mega-for-elementor' ),
				'generate'      => esc_html__( 'Generate', 'ht-mega-for-elementor' ),
				'regenerate'    => esc_html__( 'Regenerate', 'ht-mega-for-elementor' ),
				'cancel'        => esc_html__( 'Cancel', 'ht-mega-for-elementor' ),
				'insert'        => esc_html__( 'Insert', 'ht-mega-for-elementor' ),
				'insertAll'     => esc_html__( 'Insert all', 'ht-mega-for-elementor' ),
				'preview'       => esc_html__( 'Preview full design', 'ht-mega-for-elementor' ),
				'inserted'      => esc_html__( 'Inserted', 'ht-mega-for-elementor' ),
				'resultsReady'  => esc_html__( 'Pick a result to insert.', 'ht-mega-for-elementor' ),
				'noMatch'       => esc_html__( "That doesn't match one of HT Mega's AI-ready sections yet.", 'ht-mega-for-elementor' ),
				'error'         => esc_html__( 'Something went wrong — try again.', 'ht-mega-for-elementor' ),
				'emptyPrompt'   => esc_html__( 'Enter a prompt first.', 'ht-mega-for-elementor' ),
				'draftNotice'   => esc_html__( 'Inserted as a draft — nothing is published until you hit Update.', 'ht-mega-for-elementor' ),
				'oneSection'    => esc_html__( 'Add one section', 'ht-mega-for-elementor' ),
				'fullPage'      => esc_html__( 'Build a full page', 'ht-mega-for-elementor' ),
			],
		] );
	}

	/**
	 * Same stylesheet, loaded into the preview iframe specifically — the sparkle
	 * button's actual rendering context (see the hook registration in __construct()
	 * for why this is a separate enqueue, not a duplicate of enqueue_scripts()).
	 */
	public function enqueue_preview_styles() {
		wp_enqueue_style(
			'htmega-ai-section-assistant-preview',
			HTMEGA_ADDONS_PL_URL . 'admin/assets/css/htmega-ai-section-assistant.css',
			[],
			HTMEGA_VERSION
		);
	}

	/**
	 * AJAX: generate one section from a free-text prompt.
	 *
	 * Expects POST: nonce, prompt, (optional) design_style to lock to a
	 * specific style instead of letting the model choose one (used by
	 * full-page mode so every section in a page shares one style).
	 */
	public function handle_generate_section() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_send_json_error( [ 'message' => __( 'Forbidden.', 'ht-mega-for-elementor' ) ], 403 );
			return;
		}

$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'htmega_ai_nonce' ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid security token', 'ht-mega-for-elementor' ) ] );
			return;
		}

		$prompt        = isset( $_POST['prompt'] ) ? sanitize_textarea_field( wp_unslash( $_POST['prompt'] ) ) : '';
		$locked_style  = isset( $_POST['design_style'] ) ? sanitize_key( wp_unslash( $_POST['design_style'] ) ) : '';

		if ( empty( $prompt ) ) {
			wp_send_json_error( [ 'message' => __( 'Prompt is required', 'ht-mega-for-elementor' ) ] );
			return;
		}

		try {
			$generated = $this->generate_section( $prompt, $locked_style ?: null );
		} catch ( Exception $e ) {
			wp_send_json_error( [ 'message' => 'AI generation failed: ' . $e->getMessage() ] );
			return;
		}

		if ( null === $generated ) {
			wp_send_json_error( [ 'message' => __( "None of HT Mega's sections match that request yet — try describing a hero, services, pricing, testimonials, stats, CTA, team, FAQ, blog, about, or contact section.", 'ht-mega-for-elementor' ) ] );
			return;
		}

		// Same auto-enable pass a manual template import runs — a widget the AI just
		// used should switch on automatically, not silently fail to render.
		if ( function_exists( 'htmega_enable_widgets_for_imported_template_content' ) ) {
			htmega_enable_widgets_for_imported_template_content( [ $generated['element'] ] );
		}

		wp_send_json_success( [ 'element' => $generated['element'], 'meta' => $generated['meta'] ] );
	}

	/**
	 * AJAX: pick the section list for a full-page prompt (select_page_sections())
	 * ONLY — no content generation here. Deliberately split out from actually
	 * generating each section's content: the old handle_generate_page() ran the
	 * whole page (this pick + 2 AI calls per section) as ONE PHP request, which
	 * for a prompt naming ~9 sections meant up to ~19 sequential OpenAI calls in
	 * a single AJAX call — long enough to trip the web server's own request
	 * timeout and fail with a generic transport-level error (confirmed via an
	 * empty wp-content/debug.log — no PHP fatal, so it wasn't a script-side
	 * crash). The client now drives the loop instead (see generate()'s isPage
	 * branch in htmega-ai-section-assistant.js), calling this once and then
	 * handle_generate_section() once per section as separate small requests —
	 * each well within any reasonable timeout, and with live per-section
	 * progress as a side benefit.
	 *
	 * Expects POST: nonce, prompt, (optional) page_name.
	 */
	public function handle_select_page_sections() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_send_json_error( [ 'message' => __( 'Forbidden.', 'ht-mega-for-elementor' ) ], 403 );
			return;
		}

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'htmega_ai_nonce' ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid security token', 'ht-mega-for-elementor' ) ] );
			return;
		}

		$prompt = isset( $_POST['prompt'] ) ? sanitize_textarea_field( wp_unslash( $_POST['prompt'] ) ) : '';

		if ( empty( $prompt ) ) {
			wp_send_json_error( [ 'message' => __( 'Prompt is required', 'ht-mega-for-elementor' ) ] );
			return;
		}

		try {
			$section_slugs = $this->select_page_sections( $prompt );
		} catch ( Exception $e ) {
			wp_send_json_error( [ 'message' => 'AI generation failed: ' . $e->getMessage() ] );
			return;
		}

		$manifest = htmega_ai_get_section_manifest();
		$sections = array_map(
			function ( $slug ) use ( $manifest ) {
				return [
					'slug'  => $slug,
					'label' => $manifest[ $slug ]['label'] ?? $slug,
				];
			},
			$section_slugs
		);

		wp_send_json_success( [ 'sections' => $sections ] );
	}

	/**
	 * AJAX: render a generated element (as already returned by
	 * handle_generate_section()/handle_generate_page() — this endpoint doesn't
	 * regenerate anything, purely renders) to real HTML for a visual preview
	 * thumbnail, instead of the plain text descriptor.
	 *
	 * Uses Elementor's own create_element_instance() + print_element() — the
	 * same mechanism Elementor's editor itself uses to preview a single
	 * element/widget that isn't saved to any post yet (confirmed against
	 * Elementor core source: includes/managers/elements.php and
	 * modules/atomic-widgets/ajax/render-element-action.php). This does NOT
	 * create any WordPress post — nothing is written anywhere.
	 *
	 * A "current document" context is still required for dynamic tags/kit
	 * globals — Elementor's own document being edited works fine for this
	 * (get_with_permissions() only needs an existing, editable post; it
	 * doesn't need to relate to our generated content).
	 *
	 * Expects POST: nonce, element (JSON string), context_post_id.
	 */
	public function handle_render_preview() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_send_json_error( [ 'message' => __( 'Forbidden.', 'ht-mega-for-elementor' ) ], 403 );
			return;
		}

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'htmega_ai_nonce' ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid security token', 'ht-mega-for-elementor' ) ] );
			return;
		}

		if ( ! class_exists( '\Elementor\Plugin' ) ) {
			wp_send_json_error( [ 'message' => __( 'Elementor is not active.', 'ht-mega-for-elementor' ) ] );
			return;
		}

		$post_id = isset( $_POST['context_post_id'] ) ? absint( $_POST['context_post_id'] ) : 0;
		if ( ! $post_id || ! current_user_can( 'edit_post', $post_id ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid context post.', 'ht-mega-for-elementor' ) ] );
			return;
		}

		// Raw JSON string — cannot run through sanitize_text_field()/wp_kses()
		// without corrupting the JSON syntax. It is decoded immediately below
		// and the resulting structure is validated (must be an array with an
		// elType, and its widgetType must match one of our own manifest
		// widgets) before it is ever used, so no sanitizer applies to the
		// raw string itself. Nonce + capability are already verified above.
		$element_json = isset( $_POST['element'] ) ? wp_unslash( $_POST['element'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$element      = json_decode( $element_json, true );
		if ( ! is_array( $element ) || empty( $element['elType'] ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid element data.', 'ht-mega-for-elementor' ) ] );
			return;
		}

		// Defense in depth: this should always be one of our own manifest widgets
		// already, since it's rendering data we just generated ourselves — but
		// never hand arbitrary client-provided widgetType/settings straight into
		// Elementor's render pipeline without checking it's actually one of ours.
		$inner_widget_type = $element['elements'][0]['widgetType'] ?? ( $element['widgetType'] ?? '' );
		$known_widget      = false;
		foreach ( htmega_ai_get_section_manifest() as $entry ) {
			if ( $entry['elementor_widget_name'] === $inner_widget_type ) {
				$known_widget = true;
				break;
			}
		}
		if ( ! $known_widget ) {
			wp_send_json_error( [ 'message' => __( 'Unrecognized widget type.', 'ht-mega-for-elementor' ) ] );
			return;
		}

		$document = \Elementor\Plugin::$instance->documents->get_with_permissions( $post_id );
		if ( ! $document ) {
			wp_send_json_error( [ 'message' => __( 'Could not load an editing context for preview.', 'ht-mega-for-elementor' ) ] );
			return;
		}

		\Elementor\Plugin::$instance->documents->switch_to_document( $document );

		try {
			$widget = \Elementor\Plugin::$instance->elements_manager->create_element_instance( $element );
			if ( ! $widget ) {
				throw new Exception( 'Could not instantiate element for preview.' );
			}

			ob_start();
			$widget->print_element();
			$html = (string) ob_get_clean();
		} catch ( Exception $e ) {
			\Elementor\Plugin::$instance->documents->restore_document();
			wp_send_json_error( [ 'message' => $e->getMessage() ] );
			return;
		}

		\Elementor\Plugin::$instance->documents->restore_document();

		// Our AI only ever fills Content-tab fields (never Style-tab color/typography/
		// background controls), so there is no per-post dynamic CSS to generate for
		// this element — its entire appearance comes from these already-static,
		// already-enqueued stylesheets reacting to the layout/design_style classes.
		$slug = str_replace( 'htmega-2026-', '', $inner_widget_type );
		$css  = [
			ELEMENTOR_ASSETS_URL . 'css/frontend.min.css',
			HTMEGA_ADDONS_PL_URL . 'assets/css/htm25-tokens.css',
			HTMEGA_ADDONS_PL_URL . "assets/css/widgets/htm25-{$slug}.css",
		];

		wp_send_json_success( [
			'html' => $html,
			'css'  => $css,
		] );
	}

	/**
	 * Pick the actual SET of sections a full-page prompt needs, in order — not a
	 * single pick from the old fixed self::PAGE_TYPES 4-preset list (kept below
	 * only as the fallback when the model's picks come back empty/invalid).
	 *
	 * Real bug this replaces: a prompt explicitly asking for "pricing plans...
	 * FAQ... contact form" still only got PAGE_TYPES['home'] = [hero, services,
	 * testimonials, stats, cta] — pricing/faq/contact literally could not appear
	 * for that classification, no matter how explicitly the prompt asked, because
	 * the old design picked ONE of 4 fixed lists instead of composing from what
	 * was actually requested. Still manifest-constrained (every item MUST be a
	 * real widget slug from the enum — same never-trust-the-model principle as
	 * everywhere else), but now an array, not a single closed enum pick.
	 *
	 * @return string[] Validated, deduped widget slugs in insertion order.
	 */
	private function select_page_sections( $prompt ) {
		$known_slugs = array_keys( htmega_ai_get_section_manifest() );

		$schema = [
			'type'       => 'object',
			'properties' => [
				'sections' => [
					'type'  => 'array',
					'items' => [
						'type' => 'string',
						'enum' => $known_slugs,
					],
				],
			],
			'required'   => [ 'sections' ],
			'additionalProperties' => false, // required by OpenAI's strict structured-output mode
		];

		$selection_prompt = "List every section this page needs, in top-to-bottom order, choosing only from the allowed section types.\n\nRequest: {$prompt}"
			. "\n\nInclude a section ONLY if the request actually calls for it (explicitly, or as an unmistakable standard part of what's being asked for — e.g. a SaaS landing page implies a hero even if the word \"hero\" is never used). Never include a section type the request gives no basis for (no pricing section unless pricing/plans/tiers are mentioned, no faq section unless FAQs are mentioned, no team section unless a team/about-the-founders section is asked for)."
			. "\n\n'hero' should almost always be first if present. 'cta' (final call-to-action) and 'contact' (contact form), if present, belong last. Typical pages need 3 to 8 sections — don't pad with irrelevant ones, and don't drop ones the request clearly asked for.";

		$result = HTMega_AI_Integration::instance()->generate_structured_content(
			$selection_prompt,
			$schema,
			'select_page_sections'
		);

		$sections = is_array( $result ) && is_array( $result['sections'] ?? null ) ? $result['sections'] : [];
		$sections = array_values( array_unique( array_intersect( $sections, $known_slugs ) ) );

		return ! empty( $sections ) ? $sections : self::PAGE_TYPES['home'];
	}

	/**
	 * Run the full prompt -> element pipeline. Public (not just the AJAX
	 * handler) so full-page mode (Milestone 4) can call this once per section
	 * in a loop without going back through wp_ajax_*.
	 *
	 * @param string      $prompt
	 * @param string|null $locked_style One of bento/glass/dark/aurora/neo, or null to let the model choose.
	 * @return array|null Elementor element array, or null on "no matching widget."
	 * @throws Exception On an underlying AI-call failure (bad key, network, etc.) — not for "no match",
	 *                    which returns null instead, since that's an expected outcome, not a fault.
	 */
	public function generate_section( $prompt, $locked_style = null ) {
		$ai = HTMega_AI_Integration::instance();

		// --- Step 1: selection (widget + layout + style), manifest-constrained ---
		$selection_prompt = "Pick the HT Mega section that best fits this request, and its layout/style.\n\nRequest: " . $prompt;
		if ( $locked_style ) {
			$selection_prompt .= "\n\nThe design_style MUST be \"{$locked_style}\" — this section is part of a page where every section shares one style.";
		}

		$raw_selection = $ai->generate_structured_content(
			$selection_prompt,
			htmega_ai_get_selection_schema(),
			'select_section'
		);

		$selection = htmega_ai_validate_selection( is_array( $raw_selection ) ? $raw_selection : [] );
		if ( null === $selection ) {
			return null;
		}

		// A locked style always wins over the model's own pick, even if it ignored the instruction above.
		if ( $locked_style && in_array( $locked_style, [ 'bento', 'glass', 'dark', 'aurora', 'neo' ], true ) ) {
			$selection['design_style'] = $locked_style;
		}

		$entry = htmega_ai_get_section_manifest_entry( $selection['widget_slug'] );

		// --- Step 2: content, scoped to exactly this widget's real fields ---
		$content_prompt = "Write the content for a {$selection['widget_slug']} section.\n\nOriginal request: {$prompt}\n\nWrite concise, specific copy — no filler like \"we provide quality service.\" Never invent numbers, statistics, prices, or claims the request didn't provide."
			. "\n\nIf a headline_highlight field exists: it MUST be an exact word-for-word substring copied from inside the headline field you write — never a separate phrase. The widget finds and re-styles that exact text within the headline; if it isn't literally there, nothing gets highlighted. Example: headline \"Elevated dining crafted for the night\" → headline_highlight \"the night\" (present verbatim), NOT \"The Night Awaits\" (not present)."
			. "\n\nFor any repeater list (cards, items, testimonials, etc.): if the original request states a specific number of entries (e.g. \"8 cards\", \"5 testimonials\"), write EXACTLY that many. Otherwise choose a count that fits the \"{$selection['layout_variant']}\" layout without leaving a visibly unbalanced gap in the last row — grid-style layouts read best with a count that divides evenly into their columns (e.g. 4 or 6 for a 2-column grid, 3 or 6 for a 3-column grid); single-column layouts (list, centered) read fine with any count from 2 to 5. Never leave a grid layout one short of a full last row.";

		if ( isset( $entry['content_fields']['floating_stat_number'] ) ) {
			$content_prompt .= "\n\nfloating_stat_number/floating_stat_label are a real business stat (e.g. \"10K+\" / \"happy customers\") — the same never-invent rule as numbers elsewhere. Fill BOTH only if the original request states an actual figure for this section; otherwise leave BOTH as empty strings so the badge doesn't show a made-up number.";
		}

		// Icon default behavior differs by widget, not universal — scoped this way
		// on purpose. Stats/Pricing: user explicitly asked icons stay OFF unless the
		// request names them (a counter or price card reads fine as plain numbers).
		// Every other widget (About, Services, Team, CTA...): feature/service cards
		// are conventionally icon-led, so the default is ON — pick one per item, and
		// always a different one per item (dedupe_icon() below also enforces this in
		// code, not just the prompt, since a structured-output model won't reliably
		// self-diversify across array items on instruction alone).
		if ( in_array( $selection['widget_slug'], [ 'stats', 'pricing' ], true ) ) {
			// Real bug found live: a full-page brief saying "attractive icons,
			// modern UI elements" as a general page-wide style note was satisfying
			// the old "explicitly asks for icons for that section" wording for
			// EVERY section it touched — including stats/pricing, which are
			// supposed to default off. A generic page-wide icon/visual-style
			// mention isn't a request for icons ON THIS stats counter or pricing
			// plan specifically — only a mention naming the number/plan itself is.
			$content_prompt .= "\n\nFor any icon field: most designs do NOT use icons here — set it to null by default. A GENERAL page-wide style note (e.g. \"attractive icons\", \"modern icons throughout\", \"visual icons\" as an overall design instruction) does NOT count as a reason to add one here — that describes the page's overall look, not this specific stat/plan. Only choose an icon if the request specifically asks for an icon ON EACH stat/counter or ON EACH pricing plan (e.g. \"icon for every stat\", \"each plan should have an icon\"). If it does, pick a DIFFERENT, contextually relevant icon for each separate item in the same list — never repeat the same icon across multiple items.";
		} else {
			$content_prompt .= "\n\nFor any icon field: pick a contextually relevant icon for each item by default — these are icon-led cards. Pick a DIFFERENT icon for each separate item in the same list — never repeat the same icon across multiple items just because it seems like a safe default.";
		}

		$content = $ai->generate_structured_content(
			$content_prompt,
			htmega_ai_get_content_schema( $selection['widget_slug'] ),
			'generate_content'
		);

		if ( ! is_array( $content ) ) {
			throw new Exception( 'AI did not return usable content for the selected section.' );
		}

		// --- Step 3: deterministic assembly — no AI involved, can't come out structurally broken ---
		return [
			'element' => $this->assemble_element( $entry, $selection, $content ),
			// Human-readable descriptor for the results list — "Services — Grid, Bento
			// Grid style" instead of "htmega-2026-services — grid / bento", which meant
			// nothing to a non-technical user picking between generated options.
			'meta'    => [
				'label'     => $entry['label'],
				'layout'    => htmega_ai_get_layout_label( $selection['layout_variant'] ),
				'style'     => htmega_ai_get_design_style_label( $selection['design_style'] ),
				// Raw slug (not the human label above) — full-page mode's style-locking
				// needs the actual value generate_section()'s $locked_style param expects.
				'raw_style' => $selection['design_style'],
			],
		];
	}

	/**
	 * Convert one AI-returned string into the shape the target Elementor control
	 * actually expects. Text fields pass through sanitized as before; icon fields
	 * need Elementor's Icons_Manager array shape ({value, library}), not a bare
	 * string — a bare string is silently ignored by the icon control, which is
	 * why generated icons were showing the widget's default instead of updating.
	 *
	 * $value is already constrained to htmega_ai_get_icon_enum() by the content
	 * schema, but re-validated here rather than trusted blindly — same
	 * never-trust-the-model-output principle as widget/layout/style selection.
	 */
	private function clean_field_value( $value, $field_type ) {
		if ( 'icon' === $field_type ) {
			// Empty/blank means "no icon for this one" — a real, valid outcome now
			// that the schema allows null (see htmega_ai_schema_property_for_type()),
			// not something to force a fallback icon onto. Returning null tells the
			// caller to omit the setting entirely.
			if ( empty( $value ) ) {
				return null;
			}
			if ( ! in_array( $value, htmega_ai_get_icon_enum(), true ) ) {
				// Non-empty but unrecognized is different from "no icon" — it suggests
				// intent to show one that just picked something outside our safe list
				// (e.g. a topic-specific icon like "yoga"/"heartbeat" we don't carry).
				//
				// Deliberately NOT a fixed fallback (enum[0]) — confirmed bug: several
				// different repeater items each picking their own out-of-list icon all
				// collapsed onto the exact same visible icon, since every invalid value
				// mapped to the identical first enum entry. Hashing the model's
				// (invalid) choice into an index keeps this deterministic — the same
				// invalid input always resolves the same way — while different invalid
				// inputs land on different icons instead of all converging on one.
				$enum  = htmega_ai_get_icon_enum();
				$value = $enum[ abs( crc32( (string) $value ) ) % count( $enum ) ];
			}
			return [
				'value'   => $value,
				'library' => 'fa-solid', // every entry in the enum is an 'fas ' (solid) class.
			];
		}

		return sanitize_textarea_field( $value );
	}

	/**
	 * If $value was already used earlier in the same repeater, swap it for the
	 * next enum icon that hasn't. Deterministic (walks the enum in order from
	 * $value's own index) so re-running the same generation is stable, and never
	 * loops infinitely once every enum entry is exhausted (falls back to letting
	 * the repeat stand rather than looping forever).
	 */
	private function dedupe_icon( $value, array $used_icons ) {
		if ( ! in_array( $value, $used_icons, true ) ) {
			return $value;
		}

		$enum       = htmega_ai_get_icon_enum();
		$start      = array_search( $value, $enum, true );
		$start      = false === $start ? 0 : $start;
		$enum_count = count( $enum );

		for ( $offset = 1; $offset < $enum_count; $offset++ ) {
			$candidate = $enum[ ( $start + $offset ) % $enum_count ];
			if ( ! in_array( $candidate, $used_icons, true ) ) {
				return $candidate;
			}
		}

		return $value; // every enum icon already used — let it repeat.
	}

	/**
	 * Plain PHP array-building: manifest entry + validated selection + generated
	 * content -> a valid Elementor element ready for document/elements/create.
	 */
	private function assemble_element( array $entry, array $selection, array $content ) {
		$settings = [
			'layout'       => $selection['layout_variant'],
			'design_style' => $selection['design_style'],
		];

		foreach ( $entry['content_fields'] as $field => $field_type ) {
			// Real bug (found by checking each ICONS control's own registered
			// 'default', e.g. htmega_2025_about.php's feature_icon — every one is
			// hardcoded to fas fa-star): omitting the setting key does NOT mean "no
			// icon". Elementor merges the control's own default into any missing
			// key, so a "null = no icon" value that gets skipped here instead
			// renders that identical hardcoded default — same icon on every item,
			// regardless of what the model chose or how much the prompt asked for
			// variety. An icon field must always be written explicitly, using the
			// empty shape below to genuinely suppress it (the widget's own render()
			// gates on !empty($item['x_icon']['value']), so this shape hides it).
			if ( 'icon' === $field_type ) {
				$value           = ( isset( $content[ $field ] ) && is_string( $content[ $field ] ) ) ? $content[ $field ] : null;
				$cleaned         = $this->clean_field_value( $value, $field_type );
				$settings[ $field ] = $cleaned ?? [ 'value' => '', 'library' => '' ];
				continue;
			}

			if ( isset( $content[ $field ] ) && is_string( $content[ $field ] ) ) {
				$cleaned = $this->clean_field_value( $content[ $field ], $field_type );
				if ( null !== $cleaned ) {
					$settings[ $field ] = $cleaned;
				}
			}
		}

		// Belt-and-suspenders on top of the prompt instruction above: every 2026
		// widget's headline_highlight only visually works if it's a literal
		// substring of headline (the widget re-styles that exact text within the
		// headline; it doesn't inject a separate phrase). If the model ignored the
		// instruction, clear it rather than ship a highlight word that renders
		// orphaned/unused — a plain headline is correct, a broken highlight isn't.
		if ( isset( $settings['headline'], $settings['headline_highlight'] ) && '' !== $settings['headline_highlight'] ) {
			if ( false === stripos( $settings['headline'], $settings['headline_highlight'] ) ) {
				$settings['headline_highlight'] = '';
			}
		}

		foreach ( $entry['repeaters'] as $repeater_key => $item_fields ) {
			$rows = is_array( $content[ $repeater_key ] ?? null ) ? $content[ $repeater_key ] : [];
			$settings[ $repeater_key ] = [];

			// Icons already used by an earlier row in THIS repeater — real bug found
			// by checking the Services widget's own icon handling (identical
			// !empty()-gated pattern to Stats/About/Pricing, so the render side was
			// never the issue). The model was returning the same VALID enum icon
			// (fas fa-star) for every card. clean_field_value()'s crc32 fallback only
			// fires on an INVALID value, so a repeated-but-valid choice sailed
			// straight through — and a prompt instruction alone can't force a
			// structured-output model to diversify across array items reliably.
			// Enforced here instead, same never-trust-the-model-output principle as
			// everywhere else: dedupe within the repeater, not the prompt.
			$used_icons = [];

			foreach ( $rows as $index => $row ) {
				if ( ! is_array( $row ) ) {
					continue;
				}
				$clean_row = [ '_id' => wp_generate_uuid4() ];

				// stat_number/prefix/suffix are deliberately excluded from
				// $item_fields above — the AI must never invent a real business
				// figure. But omitting the keys entirely isn't a fix either: the
				// stat_number control's own default ('10'/'K+') then gets merged
				// into EVERY row that's missing it, same identical-value bug as the
				// icon issue above, which is exactly what showed four "10K+" cards
				// in a row. Cycling the widget's own pre-approved sample numbers
				// (the exact 4-item array already in htmega_2025_stats.php's
				// 'stat_items' control default) keeps the "no invented figures"
				// guarantee — these are the widget's own shipped placeholders, not
				// AI output — while giving each card a visually distinct number for
				// the user to edit, instead of a repeated one.
				if ( 'stats' === $selection['widget_slug'] && 'stat_items' === $repeater_key ) {
					$placeholders = [
						[ 'stat_prefix' => '$', 'stat_number' => '2.5', 'stat_suffix' => 'M+' ],
						[ 'stat_prefix' => '',  'stat_number' => '10',  'stat_suffix' => 'K+' ],
						[ 'stat_prefix' => '',  'stat_number' => '99.9', 'stat_suffix' => '%' ],
						[ 'stat_prefix' => '',  'stat_number' => '4.9', 'stat_suffix' => '/5' ],
					];
					$clean_row += $placeholders[ $index % count( $placeholders ) ];
				}

				// Same excluded-real-figure pattern, found by auditing every 2026
				// widget for the same class of bug after the About/Stats fixes above
				// — price_monthly/price_annual/currency/period are excluded from
				// $item_fields (manifest comment: "factual numeric claims the user
				// must set, not something the AI should invent"), but every plan card
				// then fell back to the SAME repeater-field default ($29/$23) instead
				// of each tier getting its own price — worse than the stats case
				// since a pricing table with 3 identical prices looks outright broken.
				// Cycling the widget's own 3-tier example ($9/$7, $29/$23, $79/$63,
				// already in htmega_2025_pricing.php's 'plan_items' control default)
				// gives an ascending Starter/Pro/Enterprise-style placeholder ladder.
				if ( 'pricing' === $selection['widget_slug'] && 'plan_items' === $repeater_key ) {
					$price_placeholders = [
						[ 'currency' => '$', 'price_monthly' => '9',  'price_annual' => '7',  'period' => '/month' ],
						[ 'currency' => '$', 'price_monthly' => '29', 'price_annual' => '23', 'period' => '/month' ],
						[ 'currency' => '$', 'price_monthly' => '79', 'price_annual' => '63', 'period' => '/month' ],
					];
					$clean_row += $price_placeholders[ $index % count( $price_placeholders ) ];
				}

				foreach ( $item_fields as $field => $field_type ) {
					if ( 'icon' === $field_type ) {
						// Same "always write it explicitly" fix as the content_fields
						// loop above — a repeater row missing this key falls back to
						// the repeater field's own hardcoded default too, which is why
						// every card showed the identical icon even after dedupe_icon()
						// below started producing genuinely different chosen values.
						$value   = ( isset( $row[ $field ] ) && is_string( $row[ $field ] ) ) ? $row[ $field ] : null;
						$cleaned = $this->clean_field_value( $value, $field_type );
						if ( is_array( $cleaned ) ) {
							$cleaned['value'] = $this->dedupe_icon( $cleaned['value'], $used_icons );
							$used_icons[]      = $cleaned['value'];
						} else {
							$cleaned = [ 'value' => '', 'library' => '' ];
						}
						$clean_row[ $field ] = $cleaned;
						continue;
					}

					if ( isset( $row[ $field ] ) && is_string( $row[ $field ] ) ) {
						$cleaned = $this->clean_field_value( $row[ $field ], $field_type );
						if ( null !== $cleaned ) {
							$clean_row[ $field ] = $cleaned;
						}
					}
				}
				$settings[ $repeater_key ][] = $clean_row;
			}
		}

		$widget = [
			'id'         => substr( wp_generate_uuid4(), 0, 8 ),
			'elType'     => 'widget',
			'widgetType' => $entry['elementor_widget_name'],
			'settings'   => $settings,
			'elements'   => [],
		];

		// Elementor's document root only accepts container/section elements as direct
		// children — a bare widget gets silently rejected (no error, nothing inserted).
		// Wrapping it is safe for both entry points: at document root it's required;
		// inside an already-existing empty section it's just one harmless extra nesting
		// level, not a structural problem.
		return [
			'id'       => substr( wp_generate_uuid4(), 0, 8 ),
			'elType'   => 'container',
			'settings' => [
				// HT Mega's 2026 widgets render as full-bleed sections (see CLAUDE.md's
				// BEM pattern) — Elementor's container default is 'boxed' (centered,
				// max-width), which visibly clips them. 'full' matches the widget's own CSS.
				'content_width' => 'full',
				// Elementor's container also has its own default padding (Controls_Manager::
				// DIMENSIONS, control ID 'padding', includes/elements/container.php) — left
				// unset, that default shows through as a plain white/background gap around
				// the widget (the widget's own background doesn't cover the container's
				// padding area, only its content box). Zeroed explicitly since every 2026
				// widget already manages its own internal spacing via --htm25-* tokens; the
				// wrapper is purely structural and shouldn't add space of its own.
				// Exact array shape confirmed against Elementor's own Control_Dimensions /
				// Control_Base_Units classes, not guessed.
				'padding'        => [
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				],
			],
			'elements' => [ $widget ],
		];
	}
}

add_action( 'plugins_loaded', function() {
	if ( class_exists( 'HTMega_AI_Section_Assistant' ) ) {
		HTMega_AI_Section_Assistant::instance();
	}
}, 21 );
