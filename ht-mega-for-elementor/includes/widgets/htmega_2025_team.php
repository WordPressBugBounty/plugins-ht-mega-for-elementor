<?php
/**
 * HT Mega 2026 — Team Section Widget
 *
 * @package HT_Mega
 * @since   1.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class HTMega_Elementor_Widget_Team_2025
 */
class HTMega_Elementor_Widget_Team_2025 extends Widget_Base {

	/**
	 * {@inheritdoc}
	 */
	public function get_name() {
		return 'htmega-2026-team';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_title() {
		return esc_html__( 'Team 2026', 'htmega-addons' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_icon() {
		return 'htmega-icon eicon-person';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_categories() {
		return [ 'htmega-2026' ];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_keywords() {
		return [ 'team', 'members', 'people', 'staff', 'crew', 'htmega', '2026' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {

		// ── CONTENT TAB ────────────────────────────────────────────────────────

		// ── Design Style ──────────────────────────────────────────────────────
		$this->start_controls_section(
			'section_design_style',
			[
				'label' => esc_html__( 'Design Style', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'design_style',
			[
				'label'   => esc_html__( 'Style Preset', 'htmega-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bento',
				'options' => [
					'bento'  => esc_html__( 'Bento Grid',     'htmega-addons' ),
					'glass'  => esc_html__( 'Glassmorphism',  'htmega-addons' ),
					'dark'   => esc_html__( 'Dark Minimal',   'htmega-addons' ),
					'aurora' => esc_html__( 'Aurora',         'htmega-addons' ),
					'neo'    => esc_html__( 'Neo-Brutalist',  'htmega-addons' ),
				],
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'htmega-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => [
					'grid'     => esc_html__( 'Grid',     'htmega-addons' ),
					'list'     => esc_html__( 'List',     'htmega-addons' ),
					'featured' => esc_html__( 'Featured', 'htmega-addons' ),
				],
			]
		);

		$this->add_control(
			'team_columns',
			[
				'label'     => esc_html__( 'Columns', 'htmega-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '3',
				'options'   => [
					'2' => esc_html__( '2 Columns', 'htmega-addons' ),
					'3' => esc_html__( '3 Columns', 'htmega-addons' ),
					'4' => esc_html__( '4 Columns', 'htmega-addons' ),
				],
				'condition' => [ 'layout' => [ 'grid', 'featured' ] ],
			]
		);

		$this->end_controls_section();

		// ── Section Header ─────────────────────────────────────────────────────
		$this->start_controls_section(
			'section_header',
			[
				'label' => esc_html__( 'Section Header', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_section_label',
			[
				'label'        => esc_html__( 'Show Section Label', 'htmega-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'htmega-addons' ),
				'label_off'    => esc_html__( 'No',  'htmega-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'section_label_text',
			[
				'label'     => esc_html__( 'Label Text', 'htmega-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Meet The Team', 'htmega-addons' ),
				'condition' => [ 'show_section_label' => 'yes' ],
			]
		);

		$this->add_control(
			'headline',
			[
				'label'   => esc_html__( 'Headline', 'htmega-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'The People Behind the Product', 'htmega-addons' ),
			]
		);

		$this->add_control(
			'headline_highlight',
			[
				'label'       => esc_html__( 'Headline Highlight', 'htmega-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'People', 'htmega-addons' ),
				'description' => esc_html__( 'Word or phrase within the headline to accent with colour.', 'htmega-addons' ),
			]
		);

		$this->add_control(
			'headline_tag',
			[
				'label'   => esc_html__( 'Headline Tag', 'htmega-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'htmega-addons' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'A passionate group of builders, designers, and thinkers dedicated to crafting exceptional digital experiences.', 'htmega-addons' ),
			]
		);

		$this->end_controls_section();

		// ── Team Members ───────────────────────────────────────────────────────
		$this->start_controls_section(
			'section_team_members',
			[
				'label' => esc_html__( 'Team Members', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'member_photo',
			[
				'label'   => esc_html__( 'Photo', 'htmega-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [ 'url' => '' ],
			]
		);

		$repeater->add_control(
			'member_name',
			[
				'label'   => esc_html__( 'Name', 'htmega-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Team Member', 'htmega-addons' ),
			]
		);

		$repeater->add_control(
			'member_role',
			[
				'label'   => esc_html__( 'Role / Title', 'htmega-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Product Designer', 'htmega-addons' ),
			]
		);

		$repeater->add_control(
			'member_bio',
			[
				'label'       => esc_html__( 'Short Bio', 'htmega-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => '',
				'placeholder' => esc_html__( 'A brief introduction about this person…', 'htmega-addons' ),
			]
		);

		$repeater->add_control(
			'member_department',
			[
				'label'       => esc_html__( 'Department Tag', 'htmega-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'e.g. Engineering', 'htmega-addons' ),
			]
		);

		$repeater->add_control(
			'social_heading',
			[
				'label'     => esc_html__( 'Social Links', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'social_linkedin',
			[
				'label'       => esc_html__( 'LinkedIn URL', 'htmega-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://linkedin.com/in/username',
				'default'     => [ 'url' => '' ],
			]
		);

		$repeater->add_control(
			'social_twitter',
			[
				'label'       => esc_html__( 'X / Twitter URL', 'htmega-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://twitter.com/username',
				'default'     => [ 'url' => '' ],
			]
		);

		$repeater->add_control(
			'social_github',
			[
				'label'       => esc_html__( 'GitHub URL', 'htmega-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://github.com/username',
				'default'     => [ 'url' => '' ],
			]
		);

		$repeater->add_control(
			'is_featured',
			[
				'label'        => esc_html__( 'Featured Member', 'htmega-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'htmega-addons' ),
				'label_off'    => esc_html__( 'No',  'htmega-addons' ),
				'return_value' => 'yes',
				'default'      => '',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'team_members',
			[
				'label'       => esc_html__( 'Team Members', 'htmega-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ member_name }}}',
				'default'     => [
					[
						'member_name'       => 'Alex Rivera',
						'member_role'       => 'Co-Founder & CEO',
						'member_bio'        => 'Visionary product leader with 10+ years scaling B2B SaaS companies from zero to enterprise.',
						'member_department' => 'Leadership',
						'is_featured'       => 'yes',
					],
					[
						'member_name'       => 'Priya Nair',
						'member_role'       => 'Head of Design',
						'member_bio'        => 'Award-winning UX designer who believes great products are built at the intersection of empathy and craft.',
						'member_department' => 'Design',
					],
					[
						'member_name'       => 'Jordan Kim',
						'member_role'       => 'Lead Engineer',
						'member_bio'        => 'Full-stack architect obsessed with performance, clean APIs, and shipping things that actually work.',
						'member_department' => 'Engineering',
					],
					[
						'member_name'       => 'Sam Torres',
						'member_role'       => 'Growth & Marketing',
						'member_bio'        => 'Data-driven marketer with a knack for turning complex stories into campaigns people remember.',
						'member_department' => 'Marketing',
					],
				],
			]
		);

		$this->end_controls_section();

		// ── STYLE TAB ──────────────────────────────────────────────────────────

		// ── Style: Section ────────────────────────────────────────────────────
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Section', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label'      => esc_html__( 'Padding', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-team' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'section_bg',
				'label'    => esc_html__( 'Background', 'htmega-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-team',
			]
		);

		$this->end_controls_section();

		// ── Style: Section Label ──────────────────────────────────────────────
		$this->start_controls_section(
			'style_section_label',
			[
				'label'     => esc_html__( 'Section Label', 'htmega-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_section_label' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'section_label_typography',
				'label'    => esc_html__( 'Typography', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-team__section-label',
			]
		);

		$this->add_control(
			'section_label_color',
			[
				'label'     => esc_html__( 'Text Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-team__section-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'section_label_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-team__section-label' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_label_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-team__section-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_label_padding',
			[
				'label'      => esc_html__( 'Padding', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-team__section-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ── Style: Headline ───────────────────────────────────────────────────
		$this->start_controls_section(
			'style_headline',
			[
				'label' => esc_html__( 'Headline', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'headline_typography',
				'label'    => esc_html__( 'Typography', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-team__headline',
			]
		);

		$this->add_control(
			'headline_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-team__headline' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'headline_margin',
			[
				'label'      => esc_html__( 'Margin', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-team__headline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'headline_accent_heading',
			[
				'label'     => esc_html__( 'Headline Accent', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'headline_highlight_color',
			[
				'label'     => esc_html__( 'Accent Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-team__headline-accent' => 'background-color: {{VALUE}}; background-image: none;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'headline_highlight_gradient',
				'label'          => esc_html__( 'Accent Gradient', 'htmega-addons' ),
				'types'          => [ 'gradient' ],
				'selector'       => '{{WRAPPER}} .htm25-team__headline-accent',
				'fields_options' => [
					'background' => [
						'label' => esc_html__( 'Gradient Color', 'htmega-addons' ),
					],
				],
			]
		);

		$this->end_controls_section();

		// ── Style: Description ────────────────────────────────────────────────
		$this->start_controls_section(
			'style_description',
			[
				'label' => esc_html__( 'Description', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'label'    => esc_html__( 'Typography', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-team__description',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-team__description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ── Style: Team Card ──────────────────────────────────────────────────
		$this->start_controls_section(
			'style_card',
			[
				'label' => esc_html__( 'Team Card', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'card_bg',
				'label'    => esc_html__( 'Background', 'htmega-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-team__card',
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Padding', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-team__card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-team__card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'label'    => esc_html__( 'Border', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-team__card',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-team__card',
			]
		);

		$this->end_controls_section();

		// ── Style: Member Photo ───────────────────────────────────────────────
		$this->start_controls_section(
			'style_member_photo',
			[
				'label' => esc_html__( 'Member Photo', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'photo_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-team__card-photo-wrap'        => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .htm25-team__card-photo'             => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .htm25-team__card-photo-placeholder' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'photo_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-team__card-photo-wrap',
			]
		);

		$this->end_controls_section();

		// ── Style: Member Name ────────────────────────────────────────────────
		$this->start_controls_section(
			'style_member_name',
			[
				'label' => esc_html__( 'Member Name', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'member_name_typography',
				'label'    => esc_html__( 'Typography', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-team__card-name',
			]
		);

		$this->add_control(
			'member_name_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-team__card-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ── Style: Member Role ────────────────────────────────────────────────
		$this->start_controls_section(
			'style_member_role',
			[
				'label' => esc_html__( 'Member Role / Position', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'member_role_typography',
				'label'    => esc_html__( 'Typography', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-team__card-role',
			]
		);

		$this->add_control(
			'member_role_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-team__card-role' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ── Style: Member Bio ─────────────────────────────────────────────────
		$this->start_controls_section(
			'style_member_bio',
			[
				'label' => esc_html__( 'Member Bio', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'member_bio_typography',
				'label'    => esc_html__( 'Typography', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-team__card-bio',
			]
		);

		$this->add_control(
			'member_bio_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-team__card-bio' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ── Style: Social Links ───────────────────────────────────────────────
		$this->start_controls_section(
			'style_social_links',
			[
				'label' => esc_html__( 'Social Links', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'social_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'htmega-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 10, 'max' => 48, 'step' => 1 ],
					'em' => [ 'min' => 0.5, 'max' => 3, 'step' => 0.1 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .htm25-team__card-social .htm25-team__card-social-link svg'   => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .htm25-team__card-social .htm25-team__card-social-link i'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .htm25-team__card-social-overlay .htm25-team__card-social-link svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .htm25-team__card-social-overlay .htm25-team__card-social-link i'   => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'social_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-team__card-social .htm25-team__card-social-link i'                => 'color: {{VALUE}};',
					'{{WRAPPER}} .htm25-team__card-social .htm25-team__card-social-link svg'              => 'color: {{VALUE}};',
					'{{WRAPPER}} .htm25-team__card-social .htm25-team__card-social-link svg path'         => 'fill: {{VALUE}};',
					'{{WRAPPER}} .htm25-team__card-social-overlay .htm25-team__card-social-link i'        => 'color: {{VALUE}};',
					'{{WRAPPER}} .htm25-team__card-social-overlay .htm25-team__card-social-link svg'      => 'color: {{VALUE}};',
					'{{WRAPPER}} .htm25-team__card-social-overlay .htm25-team__card-social-link svg path' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_icon_bg_color',
			[
				'label'     => esc_html__( 'Icon Background Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-team__card-social .htm25-team__card-social-link'         => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .htm25-team__card-social-overlay .htm25-team__card-social-link' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_icon_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-team__card-social .htm25-team__card-social-link'         => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .htm25-team__card-social-overlay .htm25-team__card-social-link' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'social_icon_border_width',
			[
				'label'      => esc_html__( 'Border Width', 'htmega-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 5, 'step' => 1 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .htm25-team__card-social .htm25-team__card-social-link'         => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;',
					'{{WRAPPER}} .htm25-team__card-social-overlay .htm25-team__card-social-link' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;',
				],
			]
		);

		$this->add_responsive_control(
			'social_icon_bg_border_radius',
			[
				'label'      => esc_html__( 'Icon Background Border Radius', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-team__card-social .htm25-team__card-social-link'         => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .htm25-team__card-social-overlay .htm25-team__card-social-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'social_icon_hover_color',
			[
				'label'     => esc_html__( 'Icon Hover Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .htm25-team__card-social .htm25-team__card-social-link:hover i'                => 'color: {{VALUE}};',
					'{{WRAPPER}} .htm25-team__card-social .htm25-team__card-social-link:hover svg'              => 'color: {{VALUE}};',
					'{{WRAPPER}} .htm25-team__card-social .htm25-team__card-social-link:hover svg path'         => 'fill: {{VALUE}};',
					'{{WRAPPER}} .htm25-team__card-social-overlay .htm25-team__card-social-link:hover i'        => 'color: {{VALUE}};',
					'{{WRAPPER}} .htm25-team__card-social-overlay .htm25-team__card-social-link:hover svg'      => 'color: {{VALUE}};',
					'{{WRAPPER}} .htm25-team__card-social-overlay .htm25-team__card-social-link:hover svg path' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_icon_hover_bg_color',
			[
				'label'     => esc_html__( 'Icon Hover Background Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-team__card-social .htm25-team__card-social-link:hover'         => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .htm25-team__card-social-overlay .htm25-team__card-social-link:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_icon_hover_border_color',
			[
				'label'     => esc_html__( 'Icon Hover Border Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-team__card-social .htm25-team__card-social-link:hover'         => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .htm25-team__card-social-overlay .htm25-team__card-social-link:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ── Style: Department Tag ─────────────────────────────────────────────
		$this->start_controls_section(
			'style_department_tag',
			[
				'label' => esc_html__( 'Department Tag', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'department_tag_typography',
				'label'    => esc_html__( 'Typography', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-team__card-department',
			]
		);

		$this->add_control(
			'department_tag_color',
			[
				'label'     => esc_html__( 'Text Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-team__card-department' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'department_tag_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-team__card-department' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'department_tag_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-team__card-department' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->render_team( $settings );
	}

	/**
	 * Build the full team HTML.
	 *
	 * @param array $settings Widget settings.
	 */
	private function render_team( array $settings ) {
		$design_style  = ! empty( $settings['design_style'] ) ? $settings['design_style'] : 'bento';
		$layout        = ! empty( $settings['layout'] ) ? $settings['layout'] : 'grid';
		$columns       = ! empty( $settings['team_columns'] ) ? (int) $settings['team_columns'] : 3;
		$members       = ! empty( $settings['team_members'] ) ? $settings['team_members'] : [];

		$show_label    = ! empty( $settings['show_section_label'] ) && $settings['show_section_label'] === 'yes';
		$label_text    = ! empty( $settings['section_label_text'] ) ? $settings['section_label_text'] : '';
		$headline      = ! empty( $settings['headline'] ) ? $settings['headline'] : '';
		$headline_hl   = ! empty( $settings['headline_highlight'] ) ? $settings['headline_highlight'] : '';
		$headline_tag  = ! empty( $settings['headline_tag'] ) ? tag_escape( $settings['headline_tag'] ) : 'h2';
		$description   = ! empty( $settings['description'] ) ? $settings['description'] : '';

		// Headline highlight injection
		$headline_html = '';
		if ( $headline ) {
			if ( $headline_hl && strpos( $headline, $headline_hl ) !== false ) {
				$headline_html = str_replace(
					esc_html( $headline_hl ),
					'<span class="htm25-team__headline-accent">' . esc_html( $headline_hl ) . '</span>',
					esc_html( $headline )
				);
			} else {
				$headline_html = esc_html( $headline );
			}
		}

		$section_class = 'htm25-team htm25-team--' . esc_attr( $layout );
		?>
		<div class="htm25-style--<?php echo esc_attr( $design_style ); ?>">
			<section class="<?php echo esc_attr( $section_class ); ?>">

				<?php if ( in_array( $design_style, [ 'glass', 'aurora' ], true ) ) : ?>
				<div class="htm25-team__bg-blobs" aria-hidden="true">
					<div class="htm25-team__blob htm25-team__blob--1"></div>
					<div class="htm25-team__blob htm25-team__blob--2"></div>
				</div>
				<?php endif; ?>


				<div class="htm25-team__inner">

					<?php if ( $show_label && $label_text || $headline || $description ) : ?>
					<header class="htm25-team__header">
						<?php if ( $show_label && $label_text ) : ?>
						<p class="htm25-team__section-label">
							<span><?php echo esc_html( $label_text ); ?></span>
						</p>
						<?php endif; ?>

						<?php if ( $headline_html ) : ?>
						<<?php echo $headline_tag; // phpcs:ignore ?> class="htm25-team__headline"><?php echo $headline_html; // phpcs:ignore ?></<?php echo $headline_tag; // phpcs:ignore ?>>
						<?php endif; ?>

						<?php if ( $description ) : ?>
						<p class="htm25-team__description"><?php echo esc_html( $description ); ?></p>
						<?php endif; ?>
					</header>
					<?php endif; ?>

					<?php if ( ! empty( $members ) ) : ?>
					<div class="htm25-team__grid htm25-team__grid--cols-<?php echo esc_attr( $columns ); ?>"
					     role="list">
						<?php foreach ( $members as $index => $member ) : ?>
							<?php $this->render_member_card( $member, $index, $layout, $design_style ); ?>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>

				</div><!-- .htm25-team__inner -->
			</section><!-- .htm25-team -->
		</div><!-- .htm25-style -->
		<?php
	}

	/**
	 * Render a single team member card.
	 *
	 * @param array  $member       Member data from repeater.
	 * @param int    $index        Zero-based position in the list.
	 * @param string $layout       Layout slug.
	 * @param string $design_style Style preset slug.
	 */
	private function render_member_card( array $member, int $index, string $layout, string $design_style ) {
		$name       = ! empty( $member['member_name'] )       ? $member['member_name']       : '';
		$role       = ! empty( $member['member_role'] )       ? $member['member_role']        : '';
		$bio        = ! empty( $member['member_bio'] )        ? $member['member_bio']         : '';
		$department = ! empty( $member['member_department'] ) ? $member['member_department']  : '';
		$photo_url  = ! empty( $member['member_photo']['url'] ) ? $member['member_photo']['url'] : '';
		$is_featured = ! empty( $member['is_featured'] ) && $member['is_featured'] === 'yes';

		$li_url    = ! empty( $member['social_linkedin']['url'] ) ? $member['social_linkedin']['url'] : '';
		$tw_url    = ! empty( $member['social_twitter']['url'] )  ? $member['social_twitter']['url']  : '';
		$gh_url    = ! empty( $member['social_github']['url'] )   ? $member['social_github']['url']   : '';

		$card_class = implode( ' ', array_filter( [
			'htm25-team__card',
			$is_featured ? 'htm25-team__card--featured' : '',
			$layout === 'featured' && $index === 0 ? 'htm25-team__card--hero' : '',
		] ) );

		// Avatar initials fallback
		$initials = '';
		if ( $name ) {
			$parts = explode( ' ', $name );
			foreach ( $parts as $part ) {
				$initials .= mb_substr( $part, 0, 1 );
			}
			$initials = mb_strtoupper( mb_substr( $initials, 0, 2 ) );
		}
		?>
		<article class="<?php echo esc_attr( $card_class ); ?>" role="listitem">

			<div class="htm25-team__card-photo-wrap">
				<?php if ( $photo_url ) : ?>
				<img src="<?php echo esc_url( $photo_url ); ?>"
				     alt="<?php echo esc_attr( $name ); ?>"
				     class="htm25-team__card-photo"
				     loading="lazy" />
				<?php else : ?>
				<div class="htm25-team__card-photo-placeholder" aria-hidden="true">
					<span><?php echo esc_html( $initials ); ?></span>
				</div>
				<?php endif; ?>

				<?php if ( $li_url || $tw_url || $gh_url ) : ?>
				<div class="htm25-team__card-social-overlay" aria-hidden="true">
					<?php if ( $li_url ) : ?>
					<a href="<?php echo esc_url( $li_url ); ?>" target="_blank" rel="noopener noreferrer"
					   class="htm25-team__card-social-link" aria-label="<?php echo esc_attr( $name ) . ' on LinkedIn'; ?>">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>
					</a>
					<?php endif; ?>

					<?php if ( $tw_url ) : ?>
					<a href="<?php echo esc_url( $tw_url ); ?>" target="_blank" rel="noopener noreferrer"
					   class="htm25-team__card-social-link" aria-label="<?php echo esc_attr( $name ) . ' on X'; ?>">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L2.03 2.25H8.8l4.259 5.631 5.185-5.631zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77z"/></svg>
					</a>
					<?php endif; ?>

					<?php if ( $gh_url ) : ?>
					<a href="<?php echo esc_url( $gh_url ); ?>" target="_blank" rel="noopener noreferrer"
					   class="htm25-team__card-social-link" aria-label="<?php echo esc_attr( $name ) . ' on GitHub'; ?>">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M12 2A10 10 0 0 0 2 12c0 4.42 2.87 8.17 6.84 9.5.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34-.46-1.16-1.11-1.47-1.11-1.47-.91-.62.07-.6.07-.6 1 .07 1.53 1.03 1.53 1.03.87 1.52 2.34 1.07 2.91.83.09-.65.35-1.09.63-1.34-2.22-.25-4.55-1.11-4.55-4.92 0-1.11.38-2 1.03-2.71-.1-.25-.45-1.29.1-2.64 0 0 .84-.27 2.75 1.02.79-.22 1.65-.33 2.5-.33.85 0 1.71.11 2.5.33 1.91-1.29 2.75-1.02 2.75-1.02.55 1.35.2 2.39.1 2.64.65.71 1.03 1.6 1.03 2.71 0 3.82-2.34 4.66-4.57 4.91.36.31.69.92.69 1.85V21c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12A10 10 0 0 0 12 2z"/></svg>
					</a>
					<?php endif; ?>
				</div><!-- .htm25-team__card-social-overlay -->
				<?php endif; ?>
			</div><!-- .htm25-team__card-photo-wrap -->

			<div class="htm25-team__card-body">
				<?php if ( $department ) : ?>
				<span class="htm25-team__card-department"><?php echo esc_html( $department ); ?></span>
				<?php endif; ?>

				<h3 class="htm25-team__card-name"><?php echo esc_html( $name ); ?></h3>

				<?php if ( $role ) : ?>
				<p class="htm25-team__card-role"><?php echo esc_html( $role ); ?></p>
				<?php endif; ?>

				<?php if ( $bio ) : ?>
				<p class="htm25-team__card-bio"><?php echo esc_html( $bio ); ?></p>
				<?php endif; ?>

				<?php if ( $li_url || $tw_url || $gh_url ) : ?>
				<div class="htm25-team__card-social" aria-label="<?php echo esc_attr( $name ) . ' social links'; ?>">
					<?php if ( $li_url ) : ?>
					<a href="<?php echo esc_url( $li_url ); ?>" target="_blank" rel="noopener noreferrer"
					   class="htm25-team__card-social-link" aria-label="<?php echo esc_attr( $name ) . ' on LinkedIn'; ?>">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>
					</a>
					<?php endif; ?>

					<?php if ( $tw_url ) : ?>
					<a href="<?php echo esc_url( $tw_url ); ?>" target="_blank" rel="noopener noreferrer"
					   class="htm25-team__card-social-link" aria-label="<?php echo esc_attr( $name ) . ' on X'; ?>">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L2.03 2.25H8.8l4.259 5.631 5.185-5.631zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77z"/></svg>
					</a>
					<?php endif; ?>

					<?php if ( $gh_url ) : ?>
					<a href="<?php echo esc_url( $gh_url ); ?>" target="_blank" rel="noopener noreferrer"
					   class="htm25-team__card-social-link" aria-label="<?php echo esc_attr( $name ) . ' on GitHub'; ?>">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M12 2A10 10 0 0 0 2 12c0 4.42 2.87 8.17 6.84 9.5.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34-.46-1.16-1.11-1.47-1.11-1.47-.91-.62.07-.6.07-.6 1 .07 1.53 1.03 1.53 1.03.87 1.52 2.34 1.07 2.91.83.09-.65.35-1.09.63-1.34-2.22-.25-4.55-1.11-4.55-4.92 0-1.11.38-2 1.03-2.71-.1-.25-.45-1.29.1-2.64 0 0 .84-.27 2.75 1.02.79-.22 1.65-.33 2.5-.33.85 0 1.71.11 2.5.33 1.91-1.29 2.75-1.02 2.75-1.02.55 1.35.2 2.39.1 2.64.65.71 1.03 1.6 1.03 2.71 0 3.82-2.34 4.66-4.57 4.91.36.31.69.92.69 1.85V21c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12A10 10 0 0 0 12 2z"/></svg>
					</a>
					<?php endif; ?>
				</div><!-- .htm25-team__card-social -->
				<?php endif; ?>

			</div><!-- .htm25-team__card-body -->

		</article><!-- .htm25-team__card -->
		<?php
	}
}
