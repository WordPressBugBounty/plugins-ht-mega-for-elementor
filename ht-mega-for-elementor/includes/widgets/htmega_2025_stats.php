<?php
/**
 * HT Mega 2026 — Stats / Counter Widget
 * Class: HTMega_Elementor_Widget_Stats_2025
 * get_name(): htmega-2026-stats
 *
 * Five design style presets (bento / glass / dark / aurora / neo).
 * Layout options: Row, Grid, Bento-Card.
 * Animated count-up via IntersectionObserver + requestAnimationFrame.
 * CSS: htm25-tokens.css + assets/css/widgets/htm25-stats.css
 * Zero jQuery, zero hardcoded colours. WCAG 2.1 AA.
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class HTMega_Elementor_Widget_Stats_2025 extends Widget_Base {

	public function get_name() {
		return 'htmega-2026-stats';
	}

	public function get_title() {
		return __( 'Stats / Counter 2026', 'ht-mega-for-elementor' );
	}

	public function get_icon() {
		return 'htmega-icon eicon-counter';
	}

	public function get_categories() {
		return [ 'htmega-2026' ];
	}

	public function get_keywords() {
		return [ 'stats', 'counter', 'numbers', 'facts', 'count-up', '2026', 'htmega' ];
	}

	public function get_style_depends() {
		return [ 'htm25-tokens', 'htm25-stats' ];
	}

	/* ---------------------------------------------------------------
	   CONTROLS
	--------------------------------------------------------------- */
	protected function register_controls() {

		/* ── Design Style ─────────────────────────────────────────── */
		$this->start_controls_section( 'section_design', [
			'label' => __( 'Design Style', 'ht-mega-for-elementor' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'design_style', [
			'label'   => __( 'Style Preset', 'ht-mega-for-elementor' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'bento',
			'options' => [
				'bento'  => __( 'Bento Grid',    'ht-mega-for-elementor' ),
				'glass'  => __( 'Glassmorphism', 'ht-mega-for-elementor' ),
				'dark'   => __( 'Dark Minimal',  'ht-mega-for-elementor' ),
				'aurora' => __( 'Aurora',        'ht-mega-for-elementor' ),
				'neo'    => __( 'Neo-Brutalist',  'ht-mega-for-elementor' ),
			],
		] );

		$this->add_control( 'layout', [
			'label'   => __( 'Layout', 'ht-mega-for-elementor' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'row',
			'options' => [
				'row'   => __( 'Row (horizontal strip)',  'ht-mega-for-elementor' ),
				'grid'  => __( 'Grid (cards)',            'ht-mega-for-elementor' ),
				'bento' => __( 'Bento (featured first)',  'ht-mega-for-elementor' ),
			],
		] );

		$this->add_control( 'stat_columns', [
			'label'   => __( 'Columns', 'ht-mega-for-elementor' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '4',
			'options' => [
				'2' => __( '2 Columns', 'ht-mega-for-elementor' ),
				'3' => __( '3 Columns', 'ht-mega-for-elementor' ),
				'4' => __( '4 Columns', 'ht-mega-for-elementor' ),
			],
			'condition' => [ 'layout' => [ 'grid', 'bento' ] ],
		] );

		$this->add_control( 'enable_countup', [
			'label'        => __( 'Enable Count-Up Animation', 'ht-mega-for-elementor' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => __( 'On', 'ht-mega-for-elementor' ),
			'label_off'    => __( 'Off', 'ht-mega-for-elementor' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->end_controls_section();

		/* ── Section Header ───────────────────────────────────────── */
		$this->start_controls_section( 'section_header', [
			'label' => __( 'Section Header', 'ht-mega-for-elementor' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'show_section_header', [
			'label'        => __( 'Show Section Header', 'ht-mega-for-elementor' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => __( 'Show', 'ht-mega-for-elementor' ),
			'label_off'    => __( 'Hide', 'ht-mega-for-elementor' ),
			'return_value' => 'yes',
			'default'      => '',
			'description'  => __( 'Show a headline + description above the stats strip (common for Grid/Bento layouts).', 'ht-mega-for-elementor' ),
		] );

		$this->add_control( 'show_section_label', [
			'label'        => __( 'Show Section Label', 'ht-mega-for-elementor' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => __( 'Show', 'ht-mega-for-elementor' ),
			'label_off'    => __( 'Hide', 'ht-mega-for-elementor' ),
			'return_value' => 'yes',
			'default'      => 'yes',
			'condition'    => [ 'show_section_header' => 'yes' ],
		] );

		$this->add_control( 'section_label_text', [
			'label'     => __( 'Section Label', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => __( 'By the Numbers', 'ht-mega-for-elementor' ),
			'condition' => [ 'show_section_header' => 'yes', 'show_section_label' => 'yes' ],
		] );

		$this->add_control( 'headline', [
			'label'     => __( 'Headline', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::TEXTAREA,
			'rows'      => 2,
			'default'   => __( 'Trusted by thousands\nof businesses worldwide.', 'ht-mega-for-elementor' ),
			'condition' => [ 'show_section_header' => 'yes' ],
		] );

		$this->add_control( 'headline_highlight', [
			'label'     => __( 'Highlighted Word(s)', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => __( 'thousands', 'ht-mega-for-elementor' ),
			'condition' => [ 'show_section_header' => 'yes' ],
		] );

		$this->add_control( 'headline_tag', [
			'label'     => __( 'Headline Tag', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'h2',
			'options'   => [ 'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3' ],
			'condition' => [ 'show_section_header' => 'yes' ],
		] );

		$this->add_control( 'description', [
			'label'     => __( 'Description', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::TEXTAREA,
			'rows'      => 2,
			'default'   => __( 'Real numbers. No rounding. No marketing fluff.', 'ht-mega-for-elementor' ),
			'condition' => [ 'show_section_header' => 'yes' ],
		] );

		$this->end_controls_section();

		/* ── Stats Repeater ───────────────────────────────────────── */
		$this->start_controls_section( 'section_items', [
			'label' => __( 'Stats Items', 'ht-mega-for-elementor' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$repeater = new Repeater();

		$repeater->add_control( 'stat_icon', [
			'label'   => __( 'Icon (optional)', 'ht-mega-for-elementor' ),
			'type'    => Controls_Manager::ICONS,
			'default' => [ 'value' => '', 'library' => 'solid' ],
		] );

		$repeater->add_control( 'stat_prefix', [
			'label'       => __( 'Prefix', 'ht-mega-for-elementor' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => '',
			'placeholder' => __( 'e.g. $', 'ht-mega-for-elementor' ),
			'description' => __( 'Shown before the number (e.g. "$" for "$2.5M").', 'ht-mega-for-elementor' ),
		] );

		$repeater->add_control( 'stat_number', [
			'label'       => __( 'Number', 'ht-mega-for-elementor' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => '10',
			'placeholder' => '10',
			'description' => __( 'Numeric value used for the count-up animation. Supports decimals (e.g. "4.9").', 'ht-mega-for-elementor' ),
		] );

		$repeater->add_control( 'stat_suffix', [
			'label'       => __( 'Suffix', 'ht-mega-for-elementor' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => 'K+',
			'placeholder' => __( 'e.g. K+', 'ht-mega-for-elementor' ),
			'description' => __( 'Shown after the number (e.g. "K+", "%", "M+").', 'ht-mega-for-elementor' ),
		] );

		$repeater->add_control( 'stat_label', [
			'label'   => __( 'Label', 'ht-mega-for-elementor' ),
			'type'    => Controls_Manager::TEXT,
			'default' => __( 'Happy Customers', 'ht-mega-for-elementor' ),
		] );

		$repeater->add_control( 'stat_description', [
			'label'   => __( 'Sub-label (optional)', 'ht-mega-for-elementor' ),
			'type'    => Controls_Manager::TEXT,
			'default' => '',
		] );

		$this->add_control( 'stat_items', [
			'label'       => __( 'Stats', 'ht-mega-for-elementor' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ stat_label }}}',
			'default'     => [
				[
					'stat_prefix'      => '$',
					'stat_number'      => '2.5',
					'stat_suffix'      => 'M+',
					'stat_label'       => __( 'Revenue Generated', 'ht-mega-for-elementor' ),
					'stat_description' => __( 'Across 150+ countries', 'ht-mega-for-elementor' ),
				],
				[
					'stat_prefix'      => '',
					'stat_number'      => '10',
					'stat_suffix'      => 'K+',
					'stat_label'       => __( 'Happy Customers', 'ht-mega-for-elementor' ),
					'stat_description' => __( 'And growing every day', 'ht-mega-for-elementor' ),
				],
				[
					'stat_prefix'      => '',
					'stat_number'      => '99.9',
					'stat_suffix'      => '%',
					'stat_label'       => __( 'Uptime SLA', 'ht-mega-for-elementor' ),
					'stat_description' => __( 'Guaranteed reliability', 'ht-mega-for-elementor' ),
				],
				[
					'stat_prefix'      => '',
					'stat_number'      => '4.9',
					'stat_suffix'      => '/5',
					'stat_label'       => __( 'Average Rating', 'ht-mega-for-elementor' ),
					'stat_description' => __( 'From verified reviews', 'ht-mega-for-elementor' ),
				],
			],
		] );

		$this->end_controls_section();

		/* ================================================================
		   STYLE TAB
		   ================================================================ */

		/* ── 1. Section Wrapper ────────────────────────────────────── */
		$this->start_controls_section( 'style_section', [
			'label' => __( 'Section', 'ht-mega-for-elementor' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'section_padding', [
			'label'      => __( 'Padding', 'ht-mega-for-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .htm25-stats' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'section_bg',
				'label'    => __( 'Background', 'ht-mega-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-stats',
			]
		);

		$this->end_controls_section();

		/* ── 2. Section Label ──────────────────────────────────────── */
		$this->start_controls_section( 'style_section_label', [
			'label'     => __( 'Section Label', 'ht-mega-for-elementor' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'show_section_header' => 'yes',
				'show_section_label'  => 'yes',
			],
		] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'section_label_typography',
				'selector' => '{{WRAPPER}} .htm25-stats__section-label',
			]
		);

		$this->add_control( 'section_label_color', [
			'label'     => __( 'Text Color', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-stats__section-label' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'section_label_bg_color', [
			'label'     => __( 'Background Color', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-stats__section-label' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'section_label_border_radius', [
			'label'      => __( 'Border Radius', 'ht-mega-for-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .htm25-stats__section-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'section_label_padding', [
			'label'      => __( 'Padding', 'ht-mega-for-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .htm25-stats__section-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		/* ── 3. Headline ───────────────────────────────────────────── */
		$this->start_controls_section( 'style_headline', [
			'label'     => __( 'Headline', 'ht-mega-for-elementor' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_section_header' => 'yes' ],
		] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'headline_typography',
				'selector' => '{{WRAPPER}} .htm25-stats__headline',
			]
		);

		$this->add_control( 'headline_color', [
			'label'     => __( 'Text Color', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-stats__headline' => 'color: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'headline_margin', [
			'label'      => __( 'Margin', 'ht-mega-for-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .htm25-stats__headline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_control( 'headline_accent_heading', [
			'label'     => __( 'Headline Accent (Highlighted Word)', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'headline_accent_color', [
			'label'     => __( 'Accent Color', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-stats__headline-accent' => 'background-color: {{VALUE}}; background-image: none;',
			],
		] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'headline_accent_gradient',
				'label'          => __( 'Accent Gradient', 'ht-mega-for-elementor' ),
				'types'          => [ 'gradient' ],
				'selector'       => '{{WRAPPER}} .htm25-stats__headline-accent',
				'fields_options' => [
					'background' => [
						'label' => __( 'Gradient Color', 'ht-mega-for-elementor' ),
					],
				],
			]
		);

		$this->end_controls_section();

		/* ── 4. Description ────────────────────────────────────────── */
		$this->start_controls_section( 'style_description', [
			'label'     => __( 'Description', 'ht-mega-for-elementor' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_section_header' => 'yes' ],
		] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .htm25-stats__description',
			]
		);

		$this->add_control( 'description_color', [
			'label'     => __( 'Text Color', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-stats__description' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_section();

		/* ── 5. Stat Card ──────────────────────────────────────────── */
		$this->start_controls_section( 'style_stat_card', [
			'label' => __( 'Stat Card', 'ht-mega-for-elementor' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'card_bg',
				'label'    => __( 'Background', 'ht-mega-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-stats__item',
			]
		);

		$this->add_responsive_control( 'card_padding', [
			'label'      => __( 'Padding', 'ht-mega-for-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .htm25-stats__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'card_border_radius', [
			'label'      => __( 'Border Radius', 'ht-mega-for-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .htm25-stats__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .htm25-stats__item',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .htm25-stats__item',
			]
		);

		$this->add_control(
			'card_hover_heading',
			[
				'label'     => __( 'Hover State', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'card_hover_bg',
				'label'    => __( 'Hover Background', 'ht-mega-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-stats--grid .htm25-stats__item:hover, {{WRAPPER}} .htm25-stats--bento .htm25-stats__item:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_hover_box_shadow',
				'label'    => __( 'Hover Box Shadow', 'ht-mega-for-elementor' ),
				'selector' => '{{WRAPPER}} .htm25-stats--grid .htm25-stats__item:hover, {{WRAPPER}} .htm25-stats--bento .htm25-stats__item:hover',
			]
		);

		$this->end_controls_section();

		/* ── 5b. Row Strip ─────────────────────────────────────────── */
		$this->start_controls_section( 'style_row_strip', [
			'label'     => __( 'Row Strip', 'ht-mega-for-elementor' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'layout' => 'row' ],
		] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'row_strip_bg',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-stats__grid',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'row_strip_border',
				'selector' => '{{WRAPPER}} .htm25-stats__grid',
			]
		);

		$this->add_responsive_control( 'row_strip_border_radius', [
			'label'      => __( 'Border Radius', 'ht-mega-for-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .htm25-stats__grid' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'row_strip_box_shadow',
				'selector' => '{{WRAPPER}} .htm25-stats__grid',
			]
		);

		$this->add_control(
			'row_hover_accent_heading',
			[
				'label'     => __( 'Hover Accent Line', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'row_hover_accent_color',
			[
				'label'     => __( 'Accent Line Color', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-stats--row .htm25-stats__item::before' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'row_hover_accent_height',
			[
				'label'      => __( 'Accent Line Height', 'ht-mega-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 1, 'max' => 10, 'step' => 1 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .htm25-stats--row .htm25-stats__item::before' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ── 6. Stat Number / Value ────────────────────────────────── */
		$this->start_controls_section( 'style_stat_number', [
			'label' => __( 'Stat Number', 'ht-mega-for-elementor' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'stat_number_typography',
				'selector' => '{{WRAPPER}} .htm25-stats__item-number',
			]
		);

		$this->add_control( 'stat_number_color', [
			'label'     => __( 'Number Color', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-stats__item-number' => 'background-color: {{VALUE}}; background-image: none;',
			],
		] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'stat_number_gradient',
				'types'    => [ 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-stats__item-number',
				'fields_options' => [
					'background' => [
						'label' => __( 'Gradient Color', 'ht-mega-for-elementor' ),
					],
				],
			]
		);

		$this->add_control( 'stat_prefix_heading', [
			'label'     => __( 'Prefix', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'stat_prefix_typography',
				'selector' => '{{WRAPPER}} .htm25-stats__item-prefix',
			]
		);

		$this->add_control( 'stat_prefix_color', [
			'label'     => __( 'Prefix Color', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-stats__item-prefix' => 'color: {{VALUE}}; -webkit-text-fill-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'stat_suffix_heading', [
			'label'     => __( 'Suffix', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'stat_suffix_typography',
				'selector' => '{{WRAPPER}} .htm25-stats__item-suffix',
			]
		);

		$this->add_control( 'stat_suffix_color', [
			'label'     => __( 'Suffix Color', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-stats__item-suffix' => 'color: {{VALUE}}; -webkit-text-fill-color: {{VALUE}};',
			],
		] );

		$this->end_controls_section();

		/* ── 7. Stat Label ─────────────────────────────────────────── */
		$this->start_controls_section( 'style_stat_label', [
			'label' => __( 'Stat Label', 'ht-mega-for-elementor' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'stat_label_typography',
				'selector' => '{{WRAPPER}} .htm25-stats__item-label',
			]
		);

		$this->add_control( 'stat_label_color', [
			'label'     => __( 'Label Color', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-stats__item-label' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'stat_sublabel_heading', [
			'label'     => __( 'Sub-label', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'stat_sublabel_typography',
				'selector' => '{{WRAPPER}} .htm25-stats__item-description',
			]
		);

		$this->add_control( 'stat_sublabel_color', [
			'label'     => __( 'Sub-label Color', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-stats__item-description' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_section();

		/* ── 8. Icon ───────────────────────────────────────────────── */
		$this->start_controls_section( 'style_icon', [
			'label' => __( 'Icon', 'ht-mega-for-elementor' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'icon_size', [
			'label'      => __( 'Icon Size', 'ht-mega-for-elementor' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [
				'px' => [ 'min' => 10, 'max' => 80, 'step' => 1 ],
				'em' => [ 'min' => 0.5, 'max' => 5, 'step' => 0.1 ],
			],
			'selectors'  => [
				'{{WRAPPER}} .htm25-stats__item-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .htm25-stats__item-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'icon_color', [
			'label'     => __( 'Icon Color', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-stats__item-icon i'        => 'color: {{VALUE}};',
				'{{WRAPPER}} .htm25-stats__item-icon svg'      => 'color: {{VALUE}};',
				'{{WRAPPER}} .htm25-stats__item-icon svg path' => 'fill: {{VALUE}};',
			],
		] );

		$this->add_control( 'icon_bg_color', [
			'label'     => __( 'Icon Background Color', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-stats__item-icon-wrap' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'icon_bg_border_radius', [
			'label'      => __( 'Icon Background Border Radius', 'ht-mega-for-elementor' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .htm25-stats__item-icon-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		/* ── 9. Divider ────────────────────────────────────────────── */
		$this->start_controls_section( 'style_divider', [
			'label'     => __( 'Divider', 'ht-mega-for-elementor' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'layout' => 'row' ],
		] );

		$this->add_control( 'divider_color', [
			'label'     => __( 'Divider Color', 'ht-mega-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .htm25-stats__item-divider' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'divider_width', [
			'label'      => __( 'Divider Width', 'ht-mega-for-elementor' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [
				'px' => [ 'min' => 1, 'max' => 10, 'step' => 1 ],
			],
			'selectors'  => [
				'{{WRAPPER}} .htm25-stats__item-divider' => 'width: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();
	}

	/* ---------------------------------------------------------------
	   RENDER
	--------------------------------------------------------------- */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$uid      = uniqid( 'st' );
		$this->render_stats( $settings, $uid );
	}

	/**
	 * Main renderer.
	 */
	private function render_stats( array $settings, string $uid ) {

		$style   = ! empty( $settings['design_style'] ) ? sanitize_html_class( $settings['design_style'] ) : 'bento';
		$layout  = ! empty( $settings['layout'] )       ? sanitize_html_class( $settings['layout'] )       : 'row';
		$cols    = ! empty( $settings['stat_columns'] ) ? (int) $settings['stat_columns'] : 4;
		$cols    = in_array( $cols, [ 2, 3, 4 ], true ) ? $cols : 4;
		$countup = ! empty( $settings['enable_countup'] ) && $settings['enable_countup'] === 'yes';

		$show_header = ! empty( $settings['show_section_header'] ) && $settings['show_section_header'] === 'yes';
		$show_label  = $show_header && ! empty( $settings['show_section_label'] ) && $settings['show_section_label'] === 'yes';
		$label_text  = ! empty( $settings['section_label_text'] ) ? $settings['section_label_text'] : '';

		$headline  = ! empty( $settings['headline'] ) ? esc_html( $settings['headline'] ) : '';
		$highlight = ! empty( $settings['headline_highlight'] ) ? trim( $settings['headline_highlight'] ) : '';
		if ( $highlight && $headline ) {
			$headline = str_replace(
				esc_html( $highlight ),
				'<span class="htm25-stats__headline-accent">' . esc_html( $highlight ) . '</span>',
				$headline
			);
		}
		$headline_tag = ! empty( $settings['headline_tag'] ) && in_array( $settings['headline_tag'], [ 'h1', 'h2', 'h3' ] )
			? $settings['headline_tag'] : 'h2';
		$description  = ! empty( $settings['description'] ) ? $settings['description'] : '';

		$items = ! empty( $settings['stat_items'] ) && is_array( $settings['stat_items'] ) ? $settings['stat_items'] : [];

		$section_class = 'htm25-stats htm25-style--' . $style . ' htm25-stats--' . $layout;
		?>
		<section
			id="htm25-stats-<?php echo esc_attr( $uid ); ?>"
			class="<?php echo esc_attr( $section_class ); ?>"
			aria-label="<?php esc_attr_e( 'Stats section', 'ht-mega-for-elementor' ); ?>"
		>
			<?php if ( in_array( $style, [ 'aurora', 'glass' ], true ) ) : ?>
			<div class="htm25-stats__bg-blobs" aria-hidden="true">
				<div class="htm25-stats__blob htm25-stats__blob--1"></div>
				<div class="htm25-stats__blob htm25-stats__blob--2"></div>
			</div>
			<?php endif; ?>


			<div class="htm25-stats__inner">

				<?php if ( $show_header ) : ?>
				<div class="htm25-stats__header">
					<?php if ( $show_label && $label_text ) : ?>
					<p class="htm25-stats__section-label htm25-section-label">
						<?php echo esc_html( $label_text ); ?>
					</p>
					<?php endif; ?>
					<?php if ( $headline ) : ?>
					<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $headline_tag is whitelisted to h1/h2/h3 above (line 828); $headline is esc_html()'d at assignment (line 819) then combined with fixed, hardcoded <span> markup (line 824). ?>
					<<?php echo esc_html( $headline_tag ); ?> class="htm25-stats__headline"><?php echo $headline; ?></<?php echo esc_html( $headline_tag ); ?>>
					<?php endif; ?>
					<?php if ( $description ) : ?>
					<p class="htm25-stats__description"><?php echo wp_kses_post( $description ); ?></p>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<?php if ( $items ) : ?>
				<div class="htm25-stats__grid htm25-stats__grid--cols-<?php echo (int) $cols; ?>" role="list">
					<?php foreach ( $items as $index => $item ) :
						$this->render_stat_item( $item, $index, $layout, $countup );
					endforeach; ?>
				</div>
				<?php endif; ?>

			</div><!-- /.htm25-stats__inner -->

		</section>

		<?php if ( $countup && $items ) : ?>
		<script>
		( function () {
			var section = document.getElementById( 'htm25-stats-<?php echo esc_js( $uid ); ?>' );
			if ( ! section ) return;

			var motionOK = ! window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
			var numbers  = section.querySelectorAll( '.htm25-stats__item-number[data-target]' );

			/* Show final values immediately if motion is disabled */
			if ( ! motionOK ) {
				numbers.forEach( function( el ) {
					el.textContent = el.getAttribute( 'data-target' );
				} );
				return;
			}

			var animated = false;

			function runCountUp() {
				if ( animated ) return;
				animated = true;

				numbers.forEach( function( el ) {
					var targetStr = el.getAttribute( 'data-target' );
					var target    = parseFloat( targetStr );
					if ( isNaN( target ) ) { el.textContent = targetStr; return; }

					var isFloat  = targetStr.indexOf( '.' ) !== -1;
					var decimals = isFloat ? ( targetStr.split( '.' )[ 1 ] || '' ).length : 0;
					var duration = 2000;
					var start    = null;

					function step( ts ) {
						if ( ! start ) start = ts;
						var progress = Math.min( ( ts - start ) / duration, 1 );
						var ease     = 1 - Math.pow( 1 - progress, 3 ); /* ease-out cubic */
						var current  = ease * target;
						el.textContent = isFloat
							? current.toFixed( decimals )
							: Math.floor( current ).toLocaleString();
						if ( progress < 1 ) {
							requestAnimationFrame( step );
						} else {
							el.textContent = isFloat
								? target.toFixed( decimals )
								: target.toLocaleString();
						}
					}
					requestAnimationFrame( step );
				} );
			}

			if ( 'IntersectionObserver' in window ) {
				var observer = new IntersectionObserver( function( entries ) {
					entries.forEach( function( entry ) {
						if ( entry.isIntersecting ) {
							runCountUp();
							observer.disconnect();
						}
					} );
				}, { threshold: 0.25 } );
				observer.observe( section );
			} else {
				runCountUp();
			}
		} )();
		</script>
		<?php endif; ?>
		<?php
	}

	/**
	 * Renders a single stat item.
	 */
	private function render_stat_item( array $item, int $index, string $layout, bool $countup ) {

		$prefix      = ! empty( $item['stat_prefix'] )      ? $item['stat_prefix']      : '';
		$number      = ! empty( $item['stat_number'] )      ? $item['stat_number']      : '0';
		$suffix      = ! empty( $item['stat_suffix'] )      ? $item['stat_suffix']      : '';
		$label       = ! empty( $item['stat_label'] )       ? $item['stat_label']       : '';
		$description = ! empty( $item['stat_description'] ) ? $item['stat_description'] : '';

		$is_first  = $index === 0;
		$item_class = 'htm25-stats__item' . ( $is_first && $layout === 'bento' ? ' htm25-stats__item--featured' : '' );

		// display number for non-JS: format with commas if it's an integer
		$display_number = is_numeric( $number )
			? ( strpos( $number, '.' ) !== false ? $number : number_format( (float) $number ) )
			: $number;
		?>
		<div class="<?php echo esc_attr( $item_class ); ?>" role="listitem">

			<?php if ( ! empty( $item['stat_icon']['value'] ) ) : ?>
			<div class="htm25-stats__item-icon-wrap" aria-hidden="true">
				<span class="htm25-stats__item-icon">
					<?php Icons_Manager::render_icon( $item['stat_icon'], [ 'aria-hidden' => 'true' ] ); ?>
				</span>
			</div>
			<?php endif; ?>

			<div class="htm25-stats__item-value-wrap" aria-label="<?php echo esc_attr( $prefix . $display_number . $suffix . ' ' . $label ); ?>">
				<?php if ( $prefix ) : ?>
				<span class="htm25-stats__item-prefix" aria-hidden="true"><?php echo esc_html( $prefix ); ?></span>
				<?php endif; ?>
				<span
					class="htm25-stats__item-number"
					<?php if ( $countup && is_numeric( $number ) ) : ?>
					data-target="<?php echo esc_attr( $number ); ?>"
					<?php endif; ?>
					aria-hidden="true"
				><?php echo esc_html( $display_number ); ?></span>
				<?php if ( $suffix ) : ?>
				<span class="htm25-stats__item-suffix" aria-hidden="true"><?php echo esc_html( $suffix ); ?></span>
				<?php endif; ?>
			</div>

			<?php if ( $label ) : ?>
			<p class="htm25-stats__item-label"><?php echo esc_html( $label ); ?></p>
			<?php endif; ?>

			<?php if ( $description ) : ?>
			<p class="htm25-stats__item-description"><?php echo esc_html( $description ); ?></p>
			<?php endif; ?>

			<?php if ( $layout === 'row' ) : ?>
			<div class="htm25-stats__item-divider" aria-hidden="true"></div>
			<?php endif; ?>

		</div>
		<?php
	}
}
