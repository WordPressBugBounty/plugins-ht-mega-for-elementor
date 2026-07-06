<?php
/**
 * HT Mega 2026 — CTA Section Widget
 * Class: HTMega_Elementor_Widget_CTA_2025
 * get_name(): htmega-2026-cta
 *
 * Five design style presets (bento / glass / dark / aurora / neo).
 * Layout options: Centered, Split (text + image), Banner (compact strip).
 * Primary + optional secondary CTA buttons.
 * CSS: htm25-tokens.css + assets/css/widgets/htm25-cta.css
 * Zero jQuery, zero hardcoded colours. WCAG 2.1 AA.
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class HTMega_Elementor_Widget_CTA_2025 extends Widget_Base {

	public function get_name() {
		return 'htmega-2026-cta';
	}

	public function get_title() {
		return __( 'CTA Section 2026', 'htmega-addons' );
	}

	public function get_icon() {
		return 'htmega-icon eicon-call-to-action';
	}

	public function get_categories() {
		return [ 'htmega-2026' ];
	}

	public function get_keywords() {
		return [ 'cta', 'call to action', 'banner', 'promo', 'conversion', '2026', 'htmega' ];
	}

	public function get_style_depends() {
		return [ 'htm25-tokens', 'htm25-cta' ];
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
			'default' => 'centered',
			'options' => [
				'centered' => __( 'Centered',             'htmega-addons' ),
				'split'    => __( 'Split (text + image)', 'htmega-addons' ),
				'banner'   => __( 'Banner (compact strip)','htmega-addons' ),
			],
		] );

		$this->add_control( 'image_position', [
			'label'     => __( 'Image Position', 'htmega-addons' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'right',
			'options'   => [
				'right' => __( 'Image on Right', 'htmega-addons' ),
				'left'  => __( 'Image on Left',  'htmega-addons' ),
			],
			'condition' => [ 'layout' => 'split' ],
		] );

		$this->end_controls_section();

		/* ── Content ──────────────────────────────────────────────── */
		$this->start_controls_section( 'section_content', [
			'label' => __( 'Content', 'htmega-addons' ),
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
			'default'   => __( 'Get Started Today', 'htmega-addons' ),
			'condition' => [ 'show_section_label' => 'yes' ],
		] );

		$this->add_control( 'headline', [
			'label'   => __( 'Headline', 'htmega-addons' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => __( "Start building faster\nwith HT Mega 2026.", 'htmega-addons' ),
		] );

		$this->add_control( 'headline_highlight', [
			'label'   => __( 'Highlighted Word(s)', 'htmega-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => __( 'faster', 'htmega-addons' ),
		] );

		$this->add_control( 'headline_tag', [
			'label'   => __( 'Headline Tag', 'htmega-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'h2',
			'options' => [ 'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3' ],
		] );

		$this->add_control( 'description', [
			'label'   => __( 'Description', 'htmega-addons' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => __( 'Join 10,000+ teams already using the most advanced Elementor addon on the market. No lock-in, cancel any time.', 'htmega-addons' ),
		] );

		$this->end_controls_section();

		/* ── Primary CTA ──────────────────────────────────────────── */
		$this->start_controls_section( 'section_primary_cta', [
			'label' => __( 'Primary Button', 'htmega-addons' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'show_primary_cta', [
			'label'        => __( 'Show Primary Button', 'htmega-addons' ),
			'type'         => Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'primary_cta_text', [
			'label'     => __( 'Button Text', 'htmega-addons' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => __( 'Get Started Free', 'htmega-addons' ),
			'condition' => [ 'show_primary_cta' => 'yes' ],
		] );

		$this->add_control( 'primary_cta_url', [
			'label'       => __( 'Button URL', 'htmega-addons' ),
			'type'        => Controls_Manager::URL,
			'default'     => [ 'url' => '#' ],
			'condition'   => [ 'show_primary_cta' => 'yes' ],
		] );

		$this->add_control( 'primary_cta_icon', [
			'label'     => __( 'Icon (optional)', 'htmega-addons' ),
			'type'      => Controls_Manager::ICONS,
			'default'   => [ 'value' => '', 'library' => 'solid' ],
			'condition' => [ 'show_primary_cta' => 'yes' ],
		] );

		$this->add_control( 'primary_cta_icon_position', [
			'label'     => __( 'Icon Position', 'htmega-addons' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'before',
			'options'   => [
				'before' => __( 'Before Text', 'htmega-addons' ),
				'after'  => __( 'After Text',  'htmega-addons' ),
			],
			'condition' => [ 'show_primary_cta' => 'yes' ],
		] );

		$this->end_controls_section();

		/* ── Secondary CTA ────────────────────────────────────────── */
		$this->start_controls_section( 'section_secondary_cta', [
			'label' => __( 'Secondary Button', 'htmega-addons' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'show_secondary_cta', [
			'label'        => __( 'Show Secondary Button', 'htmega-addons' ),
			'type'         => Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'secondary_cta_text', [
			'label'     => __( 'Button Text', 'htmega-addons' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => __( 'View Demo', 'htmega-addons' ),
			'condition' => [ 'show_secondary_cta' => 'yes' ],
		] );

		$this->add_control( 'secondary_cta_url', [
			'label'     => __( 'Button URL', 'htmega-addons' ),
			'type'      => Controls_Manager::URL,
			'default'   => [ 'url' => '#' ],
			'condition' => [ 'show_secondary_cta' => 'yes' ],
		] );

		$this->end_controls_section();

		/* ── Image (Split layout) ─────────────────────────────────── */
		$this->start_controls_section( 'section_image', [
			'label'     => __( 'Image', 'htmega-addons' ),
			'tab'       => Controls_Manager::TAB_CONTENT,
			'condition' => [ 'layout' => 'split' ],
		] );

		$this->add_control( 'cta_image', [
			'label'       => __( 'Image', 'htmega-addons' ),
			'type'        => Controls_Manager::MEDIA,
			'default'     => [ 'url' => '' ],
		] );

		$this->add_control( 'cta_image_alt', [
			'label'   => __( 'Alt Text', 'htmega-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => '',
		] );

		$this->end_controls_section();

		/* ═══════════════════════════════════════════════════════════
		   STYLE TAB
		═══════════════════════════════════════════════════════════ */

		/* ── Style: Section ──────────────────────────────────────── */
		$this->start_controls_section( 'style_section', [
			'label' => __( 'Section', 'htmega-addons' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'section_bg',
				'label'    => __( 'Background', 'htmega-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-cta',
			]
		);

		$this->add_control( 'section_padding_heading', [
			'label'     => __( 'Spacing', 'htmega-addons' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_responsive_control( 'section_padding', [
			'label'      => __( 'Padding', 'htmega-addons' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .htm25-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		/* ── Style: Section Label ─────────────────────────────────── */
		$this->start_controls_section( 'style_section_label', [
			'label'     => __( 'Section Label', 'htmega-addons' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_section_label' => 'yes' ],
		] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'section_label_typography',
				'selector' => '{{WRAPPER}} .htm25-cta__section-label',
			]
		);

		$this->add_control( 'section_label_color', [
			'label'     => __( 'Text Color', 'htmega-addons' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-cta__section-label' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'section_label_bg_color', [
			'label'     => __( 'Background Color', 'htmega-addons' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-cta__section-label' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'section_label_border_radius', [
			'label'      => __( 'Border Radius', 'htmega-addons' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .htm25-cta__section-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'section_label_padding', [
			'label'      => __( 'Padding', 'htmega-addons' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .htm25-cta__section-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		/* ── Style: Headline ─────────────────────────────────────── */
		$this->start_controls_section( 'style_headline', [
			'label' => __( 'Headline', 'htmega-addons' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'headline_typography',
				'selector' => '{{WRAPPER}} .htm25-cta__headline',
			]
		);

		$this->add_control( 'headline_color', [
			'label'     => __( 'Color', 'htmega-addons' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-cta__headline' => 'color: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'headline_margin', [
			'label'      => __( 'Margin', 'htmega-addons' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .htm25-cta__headline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_control( 'headline_accent_heading', [
			'label'     => __( 'Headline Accent', 'htmega-addons' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'headline_highlight_color', [
			'label'     => __( 'Accent Color', 'htmega-addons' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-cta__headline-accent' => 'background-color: {{VALUE}}; background-image: none;',
			],
		] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'headline_highlight_gradient',
				'label'          => __( 'Accent Gradient', 'htmega-addons' ),
				'types'          => [ 'gradient' ],
				'selector'       => '{{WRAPPER}} .htm25-cta__headline-accent',
				'fields_options' => [
					'background' => [
						'label' => __( 'Gradient Color', 'htmega-addons' ),
					],
				],
			]
		);

		$this->end_controls_section();

		/* ── Style: Description ───────────────────────────────────── */
		$this->start_controls_section( 'style_description', [
			'label' => __( 'Description', 'htmega-addons' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .htm25-cta__description',
			]
		);

		$this->add_control( 'description_color', [
			'label'     => __( 'Color', 'htmega-addons' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-cta__description' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_section();

		/* ── Style: Primary Button ───────────────────────────────── */
		$this->start_controls_section( 'style_primary_btn', [
			'label'     => __( 'Primary Button', 'htmega-addons' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_primary_cta' => 'yes' ],
		] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'primary_btn_typography',
				'selector' => '{{WRAPPER}} .htm25-cta__btn--primary',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'primary_btn_bg',
				'label'    => __( 'Background', 'htmega-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-cta__btn--primary',
			]
		);

		$this->add_control( 'primary_btn_color', [
			'label'     => __( 'Text Color', 'htmega-addons' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-cta__btn--primary' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'primary_btn_border',
				'selector' => '{{WRAPPER}} .htm25-cta__btn--primary',
			]
		);

		$this->add_responsive_control( 'primary_btn_border_radius', [
			'label'      => __( 'Border Radius', 'htmega-addons' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .htm25-cta__btn--primary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'primary_btn_padding', [
			'label'      => __( 'Padding', 'htmega-addons' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .htm25-cta__btn--primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'buttons_gap', [
			'label'      => __( 'Buttons Gap', 'htmega-addons' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'selectors'  => [
				'{{WRAPPER}} .htm25-cta__actions' => 'gap: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'primary_btn_icon_heading', [
			'label'     => __( 'Icon', 'htmega-addons' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'primary_btn_icon_color', [
			'label'     => __( 'Icon Color', 'htmega-addons' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-cta__btn--primary i'        => 'color: {{VALUE}};',
				'{{WRAPPER}} .htm25-cta__btn--primary svg'      => 'color: {{VALUE}};',
				'{{WRAPPER}} .htm25-cta__btn--primary svg path' => 'fill: {{VALUE}};',
			],
		] );

		$this->add_control( 'primary_btn_hover_heading', [
			'label'     => __( 'Hover', 'htmega-addons' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'primary_btn_hover_bg',
				'label'    => __( 'Hover Background', 'htmega-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-cta__btn--primary:hover',
			]
		);

		$this->add_control( 'primary_btn_hover_color', [
			'label'     => __( 'Hover Text Color', 'htmega-addons' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-cta__btn--primary:hover' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'primary_btn_hover_border',
				'label'    => __( 'Hover Border', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-cta__btn--primary:hover',
			]
		);

		$this->end_controls_section();

		/* ── Style: Secondary Button ─────────────────────────────── */
		$this->start_controls_section( 'style_secondary_btn', [
			'label'     => __( 'Secondary Button', 'htmega-addons' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_secondary_cta' => 'yes' ],
		] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'secondary_btn_typography',
				'selector' => '{{WRAPPER}} .htm25-cta__btn--secondary',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'secondary_btn_bg',
				'label'    => __( 'Background', 'htmega-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-cta__btn--secondary',
			]
		);

		$this->add_control( 'secondary_btn_color', [
			'label'     => __( 'Text Color', 'htmega-addons' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-cta__btn--secondary' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'secondary_btn_border',
				'selector' => '{{WRAPPER}} .htm25-cta__btn--secondary',
			]
		);

		$this->add_responsive_control( 'secondary_btn_border_radius', [
			'label'      => __( 'Border Radius', 'htmega-addons' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .htm25-cta__btn--secondary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'secondary_btn_padding', [
			'label'      => __( 'Padding', 'htmega-addons' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .htm25-cta__btn--secondary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_control( 'secondary_btn_hover_heading', [
			'label'     => __( 'Hover', 'htmega-addons' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'secondary_btn_hover_bg',
				'label'    => __( 'Hover Background', 'htmega-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-cta__btn--secondary:hover',
			]
		);

		$this->add_control( 'secondary_btn_hover_color', [
			'label'     => __( 'Hover Text Color', 'htmega-addons' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-cta__btn--secondary:hover' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'secondary_btn_hover_border',
				'label'    => __( 'Hover Border', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-cta__btn--secondary:hover',
			]
		);

		$this->end_controls_section();

		/* ── Style: Image (Split layout) ─────────────────────────── */
		$this->start_controls_section( 'style_image', [
			'label'     => __( 'Image', 'htmega-addons' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'layout' => 'split' ],
		] );

		$this->add_responsive_control( 'image_border_radius', [
			'label'      => __( 'Border Radius', 'htmega-addons' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .htm25-cta__image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'image_border',
				'selector' => '{{WRAPPER}} .htm25-cta__image',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .htm25-cta__image',
			]
		);

		$this->end_controls_section();
	}

	/* ---------------------------------------------------------------
	   RENDER
	--------------------------------------------------------------- */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->render_cta( $settings );
	}

	private function render_cta( array $settings ) {

		$style          = ! empty( $settings['design_style'] )   ? sanitize_html_class( $settings['design_style'] ) : 'bento';
		$layout         = ! empty( $settings['layout'] )         ? sanitize_html_class( $settings['layout'] )        : 'centered';
		$image_position = ! empty( $settings['image_position'] ) ? sanitize_html_class( $settings['image_position'] ) : 'right';

		$show_label = ! empty( $settings['show_section_label'] ) && $settings['show_section_label'] === 'yes';
		$label_text = ! empty( $settings['section_label_text'] ) ? $settings['section_label_text'] : '';

		$headline  = ! empty( $settings['headline'] ) ? esc_html( $settings['headline'] ) : '';
		$highlight = ! empty( $settings['headline_highlight'] ) ? trim( $settings['headline_highlight'] ) : '';
		if ( $highlight && $headline ) {
			$headline = str_replace(
				esc_html( $highlight ),
				'<span class="htm25-cta__headline-accent">' . esc_html( $highlight ) . '</span>',
				$headline
			);
		}
		$headline_tag = ! empty( $settings['headline_tag'] ) && in_array( $settings['headline_tag'], [ 'h1', 'h2', 'h3' ] )
			? $settings['headline_tag'] : 'h2';

		$description = ! empty( $settings['description'] ) ? $settings['description'] : '';

		// Primary CTA
		$show_primary        = ! empty( $settings['show_primary_cta'] ) && $settings['show_primary_cta'] === 'yes';
		$primary_text        = ! empty( $settings['primary_cta_text'] ) ? $settings['primary_cta_text'] : '';
		$primary_url         = ! empty( $settings['primary_cta_url']['url'] ) ? $settings['primary_cta_url']['url'] : '#';
		$primary_target      = ! empty( $settings['primary_cta_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
		$primary_icon_pos    = ! empty( $settings['primary_cta_icon_position'] ) ? $settings['primary_cta_icon_position'] : 'before';

		// Secondary CTA
		$show_secondary   = ! empty( $settings['show_secondary_cta'] ) && $settings['show_secondary_cta'] === 'yes';
		$secondary_text   = ! empty( $settings['secondary_cta_text'] ) ? $settings['secondary_cta_text'] : '';
		$secondary_url    = ! empty( $settings['secondary_cta_url']['url'] ) ? $settings['secondary_cta_url']['url'] : '#';
		$secondary_target = ! empty( $settings['secondary_cta_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';

		// Image
		$image_url = ! empty( $settings['cta_image']['url'] ) ? $settings['cta_image']['url'] : '';
		$image_alt = ! empty( $settings['cta_image_alt'] )    ? $settings['cta_image_alt']    : '';

		$section_class = 'htm25-cta htm25-style--' . $style . ' htm25-cta--' . $layout;
		if ( $layout === 'split' ) {
			$section_class .= ' htm25-cta--image-' . $image_position;
		}
		?>
		<section class="<?php echo esc_attr( $section_class ); ?>" aria-label="<?php esc_attr_e( 'Call to action', 'htmega-addons' ); ?>">

			<?php if ( in_array( $style, [ 'aurora', 'glass' ], true ) ) : ?>
			<div class="htm25-cta__bg-blobs" aria-hidden="true">
				<div class="htm25-cta__blob htm25-cta__blob--1"></div>
				<div class="htm25-cta__blob htm25-cta__blob--2"></div>
			</div>
			<?php endif; ?>


			<div class="htm25-cta__inner">

				<div class="htm25-cta__content">

					<?php if ( $show_label && $label_text ) : ?>
					<p class="htm25-cta__section-label htm25-section-label">
						<?php echo esc_html( $label_text ); ?>
					</p>
					<?php endif; ?>

					<?php if ( $headline ) : ?>
					<<?php echo $headline_tag; ?> class="htm25-cta__headline"><?php echo $headline; ?></<?php echo $headline_tag; ?>>
					<?php endif; ?>

					<?php if ( $description ) : ?>
					<p class="htm25-cta__description"><?php echo wp_kses_post( $description ); ?></p>
					<?php endif; ?>

					<?php if ( $show_primary || $show_secondary ) : ?>
					<div class="htm25-cta__actions">

						<?php if ( $show_primary && $primary_text ) : ?>
						<a
							href="<?php echo esc_url( $primary_url ); ?>"
							class="htm25-btn htm25-btn--primary htm25-cta__btn htm25-cta__btn--primary"
							<?php echo $primary_target; // phpcs:ignore ?>
						>
							<?php if ( $primary_icon_pos === 'before' && ! empty( $settings['primary_cta_icon']['value'] ) ) : ?>
							<?php Icons_Manager::render_icon( $settings['primary_cta_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							<?php endif; ?>
							<?php echo esc_html( $primary_text ); ?>
							<?php if ( $primary_icon_pos === 'after' && ! empty( $settings['primary_cta_icon']['value'] ) ) : ?>
							<?php Icons_Manager::render_icon( $settings['primary_cta_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							<?php endif; ?>
						</a>
						<?php endif; ?>

						<?php if ( $show_secondary && $secondary_text ) : ?>
						<a
							href="<?php echo esc_url( $secondary_url ); ?>"
							class="htm25-btn htm25-btn--outline htm25-cta__btn htm25-cta__btn--secondary"
							<?php echo $secondary_target; // phpcs:ignore ?>
						>
							<?php echo esc_html( $secondary_text ); ?>
						</a>
						<?php endif; ?>

					</div>
					<?php endif; ?>

				</div><!-- /.htm25-cta__content -->

				<?php if ( $layout === 'split' ) : ?>
				<div class="htm25-cta__media">
					<?php if ( $image_url ) : ?>
					<img
						class="htm25-cta__image"
						src="<?php echo esc_url( $image_url ); ?>"
						alt="<?php echo esc_attr( $image_alt ); ?>"
						loading="lazy"
					>
					<?php else : ?>
					<div class="htm25-cta__image-placeholder" aria-hidden="true">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="48" height="48" aria-hidden="true"><path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd"/></svg>
						<span><?php esc_html_e( 'Add an image', 'htmega-addons' ); ?></span>
					</div>
					<?php endif; ?>
				</div><!-- /.htm25-cta__media -->
				<?php endif; ?>

			</div><!-- /.htm25-cta__inner -->

		</section>
		<?php
	}
}
