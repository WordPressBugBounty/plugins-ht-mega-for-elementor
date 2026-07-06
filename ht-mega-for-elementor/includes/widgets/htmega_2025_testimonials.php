<?php
/**
 * HT Mega 2026 — Testimonials Widget
 * Class: HTMega_Elementor_Widget_Testimonials_2025
 * get_name(): htmega-2026-testimonials
 *
 * Five design style presets (bento / glass / dark / aurora / neo).
 * Layout options: Grid, Masonry, Centered.
 * Star ratings, author avatar, quote markup — all WCAG 2.1 AA.
 * CSS: htm25-tokens.css + assets/css/widgets/htm25-testimonials.css
 * Zero jQuery, zero hardcoded colours.
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class HTMega_Elementor_Widget_Testimonials_2025 extends Widget_Base {

	public function get_name() {
		return 'htmega-2026-testimonials';
	}

	public function get_title() {
		return __( 'Testimonials 2026', 'htmega-addons' );
	}

	public function get_icon() {
		return 'htmega-icon eicon-testimonial';
	}

	public function get_categories() {
		return [ 'htmega-2026' ];
	}

	public function get_keywords() {
		return [ 'testimonial', 'review', 'quote', 'rating', 'feedback', '2026', 'htmega' ];
	}

	public function get_style_depends() {
		return [ 'htm25-tokens', 'htm25-testimonials' ];
	}

	/* ---------------------------------------------------------------
	   CONTROLS
	--------------------------------------------------------------- */
	protected function register_controls() {

		/* ── Design Style ─────────────────────────────────────────── */
		$this->start_controls_section( 'section_design', [
			'label' => __( 'Design Style', 'htmega-addons' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'design_style', [
			'label'   => __( 'Style Preset', 'htmega-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'bento',
			'options' => [
				'bento'  => __( 'Bento Grid',    'htmega-addons' ),
				'glass'  => __( 'Glassmorphism', 'htmega-addons' ),
				'dark'   => __( 'Dark Minimal',  'htmega-addons' ),
				'aurora' => __( 'Aurora',        'htmega-addons' ),
				'neo'    => __( 'Neo-Brutalist',  'htmega-addons' ),
			],
		] );

		$this->add_control( 'layout', [
			'label'   => __( 'Layout', 'htmega-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'grid',
			'options' => [
				'grid'     => __( 'Grid',     'htmega-addons' ),
				'masonry'  => __( 'Masonry',  'htmega-addons' ),
				'centered' => __( 'Centered', 'htmega-addons' ),
			],
		] );

		$this->add_control( 'testimonial_columns', [
			'label'   => __( 'Columns', 'htmega-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '3',
			'options' => [
				'2' => __( '2 Columns', 'htmega-addons' ),
				'3' => __( '3 Columns', 'htmega-addons' ),
				'4' => __( '4 Columns', 'htmega-addons' ),
			],
			'condition' => [ 'layout' => [ 'grid', 'masonry' ] ],
		] );

		$this->end_controls_section();

		/* ── Section Header ───────────────────────────────────────── */
		$this->start_controls_section( 'section_header', [
			'label' => __( 'Section Header', 'htmega-addons' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'show_section_label', [
			'label'        => __( 'Show Section Label', 'htmega-addons' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => __( 'Show', 'htmega-addons' ),
			'label_off'    => __( 'Hide', 'htmega-addons' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'section_label_text', [
			'label'     => __( 'Section Label', 'htmega-addons' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => __( 'Testimonials', 'htmega-addons' ),
			'condition' => [ 'show_section_label' => 'yes' ],
		] );

		$this->add_control( 'headline', [
			'label'   => __( 'Headline', 'htmega-addons' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => __( "Trusted by teams\nat world-class companies.", 'htmega-addons' ),
		] );

		$this->add_control( 'headline_highlight', [
			'label'   => __( 'Highlighted Word(s)', 'htmega-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => __( 'world-class companies', 'htmega-addons' ),
		] );

		$this->add_control( 'headline_tag', [
			'label'   => __( 'Headline Tag', 'htmega-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'h2',
			'options' => [
				'h1' => 'H1',
				'h2' => 'H2',
				'h3' => 'H3',
			],
		] );

		$this->add_control( 'description', [
			'label'   => __( 'Description', 'htmega-addons' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => __( 'Real feedback from real users — no cherry-picking, no marketing spin.', 'htmega-addons' ),
		] );

		$this->end_controls_section();

		/* ── Testimonials Repeater ────────────────────────────────── */
		$this->start_controls_section( 'section_items', [
			'label' => __( 'Testimonials', 'htmega-addons' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$repeater = new Repeater();

		$repeater->add_control( 'quote_text', [
			'label'   => __( 'Quote', 'htmega-addons' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 4,
			'default' => __( 'The design system saved us months of work. Every token is perfectly considered and the DX is outstanding.', 'htmega-addons' ),
		] );

		$repeater->add_control( 'rating', [
			'label'   => __( 'Star Rating (0 = hidden)', 'htmega-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '5',
			'options' => [
				'0' => __( 'None', 'htmega-addons' ),
				'1' => '★ 1',
				'2' => '★★ 2',
				'3' => '★★★ 3',
				'4' => '★★★★ 4',
				'5' => '★★★★★ 5',
			],
		] );

		$repeater->add_control( 'author_name', [
			'label'   => __( 'Author Name', 'htmega-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => __( 'Alex Morgan', 'htmega-addons' ),
		] );

		$repeater->add_control( 'author_role', [
			'label'   => __( 'Role / Title', 'htmega-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => __( 'Lead Designer', 'htmega-addons' ),
		] );

		$repeater->add_control( 'author_company', [
			'label'   => __( 'Company', 'htmega-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => __( 'Stripe', 'htmega-addons' ),
		] );

		$repeater->add_control( 'author_avatar', [
			'label'       => __( 'Avatar Image', 'htmega-addons' ),
			'type'        => Controls_Manager::MEDIA,
			'default'     => [ 'url' => '' ],
			'description' => __( 'Square image recommended (64×64 minimum)', 'htmega-addons' ),
		] );

		$repeater->add_control( 'is_featured', [
			'label'        => __( 'Featured (highlighted card)', 'htmega-addons' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => __( 'Yes', 'htmega-addons' ),
			'label_off'    => __( 'No', 'htmega-addons' ),
			'return_value' => 'yes',
			'default'      => '',
		] );

		$this->add_control( 'testimonial_items', [
			'label'       => __( 'Testimonials', 'htmega-addons' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ author_name }}}',
			'default'     => [
				[
					'quote_text'     => __( 'The design system saved us months of work. Every token is perfectly considered and the DX is outstanding.', 'htmega-addons' ),
					'rating'         => '5',
					'author_name'    => 'Alex Morgan',
					'author_role'    => 'Lead Designer',
					'author_company' => 'Stripe',
					'is_featured'    => '',
				],
				[
					'quote_text'     => __( 'Performance gains were immediate. Our Lighthouse score jumped from 54 to 98 after switching to this system.', 'htmega-addons' ),
					'rating'         => '5',
					'author_name'    => 'Sarah Kim',
					'author_role'    => 'CTO',
					'author_company' => 'Vercel',
					'is_featured'    => 'yes',
				],
				[
					'quote_text'     => __( 'Accessibility out of the box. Our WCAG 2.1 AA audit passed on the first try — no remediation needed.', 'htmega-addons' ),
					'rating'         => '5',
					'author_name'    => 'James Tran',
					'author_role'    => 'Frontend Lead',
					'author_company' => 'Shopify',
					'is_featured'    => '',
				],
				[
					'quote_text'     => __( 'The Neo-Brutalist preset is unlike anything else on the market. Our studio won two awards using it.', 'htmega-addons' ),
					'rating'         => '5',
					'author_name'    => 'Priya Rao',
					'author_role'    => 'Creative Director',
					'author_company' => 'Awwwards',
					'is_featured'    => '',
				],
				[
					'quote_text'     => __( 'Five stars — the support team responds in minutes and the code quality is genuinely exceptional.', 'htmega-addons' ),
					'rating'         => '5',
					'author_name'    => 'David Liu',
					'author_role'    => 'Senior Developer',
					'author_company' => 'HubSpot',
					'is_featured'    => '',
				],
			],
		] );

		$this->end_controls_section();

		// ════════════════════════════════════════════════════════
		//  STYLE TAB
		// ════════════════════════════════════════════════════════

		/* ── Section ─────────────────────────────────────────────── */
		$this->start_controls_section( 'style_section', [
			'label' => __( 'Section', 'htmega-addons' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

			$this->add_responsive_control( 'section_padding', [
				'label'      => __( 'Padding', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-testimonials' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			] );

			$this->add_group_control( Group_Control_Background::get_type(), [
				'name'     => 'section_bg',
				'label'    => __( 'Background', 'htmega-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-testimonials',
			] );

		$this->end_controls_section();

		/* ── Section Label ───────────────────────────────────────── */
		$this->start_controls_section( 'style_label', [
			'label'     => __( 'Section Label', 'htmega-addons' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_section_label' => 'yes' ],
		] );

			$this->add_group_control( Group_Control_Typography::get_type(), [
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .htm25-testimonials__section-label',
			] );

			$this->add_control( 'label_color', [
				'label'     => __( 'Text Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-testimonials__section-label' => 'color: {{VALUE}};',
				],
			] );

			$this->add_control( 'label_bg_color', [
				'label'     => __( 'Background Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-testimonials__section-label' => 'background-color: {{VALUE}};',
				],
			] );

			$this->add_control( 'label_border_radius', [
				'label'      => __( 'Border Radius', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-testimonials__section-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			] );

			$this->add_responsive_control( 'section_label_padding', [
				'label'      => __( 'Padding', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-testimonials__section-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			] );

		$this->end_controls_section();

		/* ── Headline ────────────────────────────────────────────── */
		$this->start_controls_section( 'style_headline', [
			'label' => __( 'Headline', 'htmega-addons' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

			$this->add_group_control( Group_Control_Typography::get_type(), [
				'name'     => 'headline_typography',
				'selector' => '{{WRAPPER}} .htm25-testimonials__headline',
			] );

			$this->add_control( 'headline_color', [
				'label'     => __( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-testimonials__headline' => 'color: {{VALUE}};',
				],
			] );

			$this->add_responsive_control( 'headline_margin', [
				'label'      => __( 'Margin', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-testimonials__headline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			] );

			/* — Headline Accent — */
			$this->add_control( 'accent_heading', [
				'label'     => __( 'Headline Accent', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			] );

			$this->add_control( 'headline_accent_color', [
				'label'     => __( 'Accent Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-testimonials__headline-accent' => 'background-color: {{VALUE}}; background-image: none;',
				],
			] );

			$this->add_group_control( Group_Control_Background::get_type(), [
				'name'           => 'headline_accent_gradient',
				'label'          => __( 'Accent Gradient', 'htmega-addons' ),
				'types'          => [ 'gradient' ],
				'selector'       => '{{WRAPPER}} .htm25-testimonials__headline-accent',
				'fields_options' => [
					'background' => [
						'label' => __( 'Gradient Color', 'htmega-addons' ),
					],
				],
			] );

		$this->end_controls_section();

		/* ── Description ─────────────────────────────────────────── */
		$this->start_controls_section( 'style_description', [
			'label' => __( 'Description', 'htmega-addons' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

			$this->add_group_control( Group_Control_Typography::get_type(), [
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .htm25-testimonials__description',
			] );

			$this->add_control( 'description_color', [
				'label'     => __( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-testimonials__description' => 'color: {{VALUE}};',
				],
			] );

		$this->end_controls_section();

		/* ── Card ────────────────────────────────────────────────── */
		$this->start_controls_section( 'style_card', [
			'label' => __( 'Card', 'htmega-addons' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

			$this->add_group_control( Group_Control_Background::get_type(), [
				'name'     => 'card_bg',
				'label'    => __( 'Background', 'htmega-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-testimonials__card',
			] );

			$this->add_responsive_control( 'card_padding', [
				'label'      => __( 'Padding', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-testimonials__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			] );

			$this->add_control( 'card_border_radius', [
				'label'      => __( 'Border Radius', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-testimonials__card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			] );

			$this->add_group_control( Group_Control_Border::get_type(), [
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .htm25-testimonials__card',
			] );

			$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
				'name'     => 'card_shadow',
				'selector' => '{{WRAPPER}} .htm25-testimonials__card',
			] );

			/* — Featured card — */
			$this->add_control( 'featured_card_heading', [
				'label'     => __( 'Featured Card', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			] );

			$this->add_group_control( Group_Control_Background::get_type(), [
				'name'     => 'featured_card_bg',
				'label'    => __( 'Featured Background', 'htmega-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-testimonials__card--featured',
			] );

			$this->add_group_control( Group_Control_Border::get_type(), [
				'name'     => 'featured_card_border',
				'label'    => __( 'Featured Border', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-testimonials__card--featured',
			] );

			$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
				'name'     => 'featured_card_shadow',
				'label'    => __( 'Featured Box Shadow', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-testimonials__card--featured',
			] );

		$this->end_controls_section();

		/* ── Quote Text ──────────────────────────────────────────── */
		$this->start_controls_section( 'style_quote', [
			'label' => __( 'Quote Text', 'htmega-addons' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

			$this->add_group_control( Group_Control_Typography::get_type(), [
				'name'     => 'quote_typography',
				'selector' => '{{WRAPPER}} .htm25-testimonials__card-text',
			] );

			$this->add_control( 'quote_color', [
				'label'     => __( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-testimonials__card-text' => 'color: {{VALUE}};',
				],
			] );

			$this->add_control( 'quote_icon_color', [
				'label'     => __( 'Quote Icon Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-testimonials__card-quote-icon' => 'color: {{VALUE}};',
				],
			] );

		$this->end_controls_section();

		/* ── Star Rating ─────────────────────────────────────────── */
		$this->start_controls_section( 'style_rating', [
			'label' => __( 'Star Rating', 'htmega-addons' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

			$this->add_control( 'star_filled_color', [
				'label'     => __( 'Filled Star Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-testimonials__star--filled' => 'color: {{VALUE}};',
				],
			] );

			$this->add_control( 'star_empty_color', [
				'label'     => __( 'Empty Star Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-testimonials__star--empty' => 'color: {{VALUE}};',
				],
			] );

			$this->add_responsive_control( 'star_size', [
				'label'      => __( 'Star Size', 'htmega-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 40 ] ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-testimonials__star' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			] );

		$this->end_controls_section();

		/* ── Author ──────────────────────────────────────────────── */
		$this->start_controls_section( 'style_author', [
			'label' => __( 'Author', 'htmega-addons' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

			/* — Avatar — */
			$this->add_control( 'avatar_heading', [
				'label' => __( 'Avatar', 'htmega-addons' ),
				'type'  => Controls_Manager::HEADING,
			] );

			$this->add_responsive_control( 'avatar_size', [
				'label'      => __( 'Avatar Size', 'htmega-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 24, 'max' => 120 ] ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-testimonials__card-avatar'             => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .htm25-testimonials__card-avatar-placeholder' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: calc({{SIZE}}{{UNIT}} * 0.4);',
				],
			] );

			$this->add_control( 'avatar_border_radius', [
				'label'      => __( 'Avatar Border Radius', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-testimonials__card-avatar'             => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .htm25-testimonials__card-avatar-placeholder' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			] );

			/* — Author Name — */
			$this->add_control( 'author_name_heading', [
				'label'     => __( 'Author Name', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			] );

			$this->add_group_control( Group_Control_Typography::get_type(), [
				'name'     => 'author_name_typography',
				'selector' => '{{WRAPPER}} .htm25-testimonials__card-name',
			] );

			$this->add_control( 'author_name_color', [
				'label'     => __( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-testimonials__card-name' => 'color: {{VALUE}};',
				],
			] );

			/* — Author Meta (role / company) — */
			$this->add_control( 'author_meta_heading', [
				'label'     => __( 'Role / Company', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			] );

			$this->add_group_control( Group_Control_Typography::get_type(), [
				'name'     => 'author_meta_typography',
				'selector' => '{{WRAPPER}} .htm25-testimonials__card-meta',
			] );

			$this->add_control( 'author_role_color', [
				'label'     => __( 'Role Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-testimonials__card-role' => 'color: {{VALUE}};',
				],
			] );

			$this->add_control( 'author_company_color', [
				'label'     => __( 'Company Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-testimonials__card-company' => 'color: {{VALUE}};',
				],
			] );

		$this->end_controls_section();

	}

	/* ---------------------------------------------------------------
	   RENDER
	--------------------------------------------------------------- */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->render_testimonials( $settings );
	}

	/**
	 * Main renderer — builds the full testimonials section.
	 */
	private function render_testimonials( array $settings ) {

		$style  = ! empty( $settings['design_style'] ) ? sanitize_html_class( $settings['design_style'] ) : 'bento';
		$layout = ! empty( $settings['layout'] )       ? sanitize_html_class( $settings['layout'] )       : 'grid';
		$cols   = ! empty( $settings['testimonial_columns'] ) ? (int) $settings['testimonial_columns'] : 3;
		$cols   = in_array( $cols, [ 2, 3, 4 ], true ) ? $cols : 3;

		$show_label = ! empty( $settings['show_section_label'] ) && $settings['show_section_label'] === 'yes';
		$label_text = ! empty( $settings['section_label_text'] ) ? $settings['section_label_text'] : '';

		$headline  = ! empty( $settings['headline'] ) ? esc_html( $settings['headline'] ) : '';
		$highlight = ! empty( $settings['headline_highlight'] ) ? trim( $settings['headline_highlight'] ) : '';
		if ( $highlight && $headline ) {
			$headline = str_replace(
				esc_html( $highlight ),
				'<span class="htm25-testimonials__headline-accent">' . esc_html( $highlight ) . '</span>',
				$headline
			);
		}

		$headline_tag = ! empty( $settings['headline_tag'] ) && in_array( $settings['headline_tag'], [ 'h1', 'h2', 'h3' ] )
			? $settings['headline_tag'] : 'h2';

		$description = ! empty( $settings['description'] ) ? $settings['description'] : '';
		$items       = ! empty( $settings['testimonial_items'] ) && is_array( $settings['testimonial_items'] )
			? $settings['testimonial_items'] : [];

		$section_classes = 'htm25-testimonials htm25-style--' . $style . ' htm25-testimonials--' . $layout;
		?>
		<section class="<?php echo esc_attr( $section_classes ); ?>" aria-label="<?php esc_attr_e( 'Testimonials section', 'htmega-addons' ); ?>">

			<?php if ( in_array( $style, [ 'aurora', 'glass' ], true ) ) : ?>
			<div class="htm25-testimonials__bg-blobs" aria-hidden="true">
				<div class="htm25-testimonials__blob htm25-testimonials__blob--1"></div>
				<div class="htm25-testimonials__blob htm25-testimonials__blob--2"></div>
			</div>
			<?php endif; ?>


			<div class="htm25-testimonials__inner">

				<?php if ( $show_label || $headline || $description ) : ?>
				<div class="htm25-testimonials__header">

					<?php if ( $show_label && $label_text ) : ?>
					<p class="htm25-testimonials__section-label htm25-section-label">
						<?php echo esc_html( $label_text ); ?>
					</p>
					<?php endif; ?>

					<?php if ( $headline ) : ?>
					<<?php echo $headline_tag; ?> class="htm25-testimonials__headline"><?php echo $headline; ?></<?php echo $headline_tag; ?>>
					<?php endif; ?>

					<?php if ( $description ) : ?>
					<p class="htm25-testimonials__description"><?php echo wp_kses_post( $description ); ?></p>
					<?php endif; ?>

				</div>
				<?php endif; ?>

				<?php if ( $items ) : ?>
				<div class="htm25-testimonials__grid htm25-testimonials__grid--cols-<?php echo $cols; ?>" role="list">
					<?php foreach ( $items as $item ) :
						$this->render_testimonial_card( $item, $layout );
					endforeach; ?>
				</div>
				<?php endif; ?>

			</div><!-- /.htm25-testimonials__inner -->

		</section>
		<?php
	}

	/**
	 * Renders a single testimonial card.
	 */
	private function render_testimonial_card( array $item, string $layout ) {

		$quote       = ! empty( $item['quote_text'] )     ? $item['quote_text']     : '';
		$rating      = ! empty( $item['rating'] )         ? (int) $item['rating']   : 0;
		$name        = ! empty( $item['author_name'] )    ? $item['author_name']    : '';
		$role        = ! empty( $item['author_role'] )    ? $item['author_role']    : '';
		$company     = ! empty( $item['author_company'] ) ? $item['author_company'] : '';
		$avatar_url  = ! empty( $item['author_avatar']['url'] ) ? $item['author_avatar']['url'] : '';
		$is_featured = ! empty( $item['is_featured'] ) && $item['is_featured'] === 'yes';

		$card_class = 'htm25-testimonials__card' . ( $is_featured ? ' htm25-testimonials__card--featured' : '' );
		?>
		<div class="<?php echo esc_attr( $card_class ); ?>" role="listitem">

			<div class="htm25-testimonials__card-quote">
				<div class="htm25-testimonials__card-quote-icon" aria-hidden="true">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 32" fill="currentColor" width="40" height="32" aria-hidden="true" focusable="false">
						<path d="M0 32V20.16Q0 12.48 4.16 6.24T16 0l2.24 3.36Q11.52 5.76 8.32 10.56T5.12 20.16H10V32H0Zm22 0V20.16q0-7.68 4.16-13.92T38 0l2.24 3.36q-6.72 2.4-9.92 7.2T27.12 20.16H32V32H22Z"/>
					</svg>
				</div>

				<?php if ( $rating > 0 && $rating <= 5 ) : ?>
				<div class="htm25-testimonials__card-rating" aria-label="<?php printf( esc_attr__( 'Rated %d out of 5 stars', 'htmega-addons' ), $rating ); ?>">
					<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="16" height="16" class="htm25-testimonials__star htm25-testimonials__star--<?php echo $i <= $rating ? 'filled' : 'empty'; ?>" aria-hidden="true" focusable="false">
						<path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.83-4.401Z" clip-rule="evenodd"/>
					</svg>
					<?php endfor; ?>
				</div>
				<?php endif; ?>

				<?php if ( $quote ) : ?>
				<p class="htm25-testimonials__card-text"><?php echo wp_kses_post( $quote ); ?></p>
				<?php endif; ?>
			</div><!-- /.htm25-testimonials__card-quote -->

			<div class="htm25-testimonials__card-author">

				<?php if ( $avatar_url ) : ?>
				<img
					class="htm25-testimonials__card-avatar"
					src="<?php echo esc_url( $avatar_url ); ?>"
					alt="<?php echo esc_attr( $name ); ?>"
					width="48"
					height="48"
					loading="lazy"
				>
				<?php else : ?>
				<div class="htm25-testimonials__card-avatar-placeholder" aria-hidden="true">
					<?php echo esc_html( mb_substr( $name, 0, 1 ) ); ?>
				</div>
				<?php endif; ?>

				<div class="htm25-testimonials__card-author-info">
					<?php if ( $name ) : ?>
					<strong class="htm25-testimonials__card-name"><?php echo esc_html( $name ); ?></strong>
					<?php endif; ?>
					<?php if ( $role || $company ) : ?>
					<span class="htm25-testimonials__card-meta">
						<?php if ( $role ) : ?><span class="htm25-testimonials__card-role"><?php echo esc_html( $role ); ?></span><?php endif; ?>
						<?php if ( $role && $company ) : ?><span class="htm25-testimonials__card-sep" aria-hidden="true"> · </span><?php endif; ?>
						<?php if ( $company ) : ?><span class="htm25-testimonials__card-company"><?php echo esc_html( $company ); ?></span><?php endif; ?>
					</span>
					<?php endif; ?>
				</div>

			</div><!-- /.htm25-testimonials__card-author -->

		</div><!-- /.htm25-testimonials__card -->
		<?php
	}
}
