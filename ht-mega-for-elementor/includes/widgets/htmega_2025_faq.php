<?php
/**
 * HT Mega 2026 — FAQ Section Widget
 *
 * @package HT_Mega
 * @since   1.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class HTMega_Elementor_Widget_FAQ_2025
 */
class HTMega_Elementor_Widget_FAQ_2025 extends Widget_Base {

	public function get_name() {
		return 'htmega-2026-faq';
	}

	public function get_title() {
		return esc_html__( 'FAQ 2026', 'htmega-addons' );
	}

	public function get_icon() {
		return 'htmega-icon eicon-accordion';
	}

	public function get_categories() {
		return [ 'htmega-2026' ];
	}

	public function get_keywords() {
		return [ 'faq', 'accordion', 'questions', 'answers', 'htmega', '2026' ];
	}

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
					'bento'  => esc_html__( 'Bento Grid',    'htmega-addons' ),
					'glass'  => esc_html__( 'Glassmorphism', 'htmega-addons' ),
					'dark'   => esc_html__( 'Dark Minimal',  'htmega-addons' ),
					'aurora' => esc_html__( 'Aurora',        'htmega-addons' ),
					'neo'    => esc_html__( 'Neo-Brutalist', 'htmega-addons' ),
				],
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'htmega-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'simple',
				'options' => [
					'simple' => esc_html__( 'Simple',  'htmega-addons' ),
					'grid'   => esc_html__( 'Two-Column Grid', 'htmega-addons' ),
					'boxed'  => esc_html__( 'Boxed Cards', 'htmega-addons' ),
				],
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
				'default'   => esc_html__( 'FAQ', 'htmega-addons' ),
				'condition' => [ 'show_section_label' => 'yes' ],
			]
		);

		$this->add_control(
			'headline',
			[
				'label'   => esc_html__( 'Headline', 'htmega-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Frequently Asked Questions', 'htmega-addons' ),
			]
		);

		$this->add_control(
			'headline_highlight',
			[
				'label'   => esc_html__( 'Headline Highlight', 'htmega-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Asked', 'htmega-addons' ),
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
				'default' => esc_html__( "Can't find what you're looking for? We've compiled answers to our most common questions below.", 'htmega-addons' ),
			]
		);

		$this->end_controls_section();

		// ── FAQ Items ──────────────────────────────────────────────────────────
		$this->start_controls_section(
			'section_faq_items',
			[
				'label' => esc_html__( 'FAQ Items', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'faq_question',
			[
				'label'   => esc_html__( 'Question', 'htmega-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'How do I get started?', 'htmega-addons' ),
			]
		);

		$repeater->add_control(
			'faq_answer',
			[
				'label'   => esc_html__( 'Answer', 'htmega-addons' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => esc_html__( 'Getting started is easy. Simply sign up for a free account, choose your plan, and follow the onboarding guide. Our team is available to help you at every step.', 'htmega-addons' ),
			]
		);

		$repeater->add_control(
			'faq_category',
			[
				'label'       => esc_html__( 'Category Tag', 'htmega-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'e.g. Billing', 'htmega-addons' ),
			]
		);

		$repeater->add_control(
			'faq_open',
			[
				'label'        => esc_html__( 'Open by Default', 'htmega-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'htmega-addons' ),
				'label_off'    => esc_html__( 'No',  'htmega-addons' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'faq_items',
			[
				'label'       => esc_html__( 'FAQ Items', 'htmega-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ faq_question }}}',
				'default'     => [
					[
						'faq_question' => 'How do I get started?',
						'faq_answer'   => 'Getting started is easy. Simply sign up for a free account, choose your plan, and follow the onboarding guide. Our team is available to help you at every step.',
						'faq_category' => 'General',
						'faq_open'     => 'yes',
					],
					[
						'faq_question' => 'What payment methods do you accept?',
						'faq_answer'   => 'We accept all major credit and debit cards (Visa, Mastercard, Amex), PayPal, and bank transfers for annual plans. All payments are securely processed and encrypted.',
						'faq_category' => 'Billing',
					],
					[
						'faq_question' => 'Can I cancel my subscription at any time?',
						'faq_answer'   => 'Yes, you can cancel your subscription at any time from your account dashboard. Your access will continue until the end of your current billing period — no questions asked.',
						'faq_category' => 'Billing',
					],
					[
						'faq_question' => 'Is there a free trial available?',
						'faq_answer'   => 'Absolutely. We offer a 14-day free trial on all paid plans — no credit card required. You get full access to every feature so you can evaluate if it\'s the right fit.',
						'faq_category' => 'Plans',
					],
					[
						'faq_question' => 'How do I contact support?',
						'faq_answer'   => 'Our support team is available via live chat, email, and our help centre. Pro and Enterprise customers also get priority phone support with a guaranteed 4-hour response time.',
						'faq_category' => 'Support',
					],
					[
						'faq_question' => 'Can I upgrade or downgrade my plan?',
						'faq_answer'   => 'Yes, you can change your plan at any time. Upgrades take effect immediately and you\'ll be charged a prorated amount. Downgrades take effect at the start of your next billing cycle.',
						'faq_category' => 'Plans',
					],
				],
			]
		);

		$this->end_controls_section();

		// ── STYLE TAB ──────────────────────────────────────────────────────────

		// ── 1. Section ─────────────────────────────────────────────────────────
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
					'{{WRAPPER}} .htm25-faq' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'section_bg',
				'label'    => esc_html__( 'Background', 'htmega-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-faq',
			]
		);

		$this->end_controls_section();

		// ── 2. Section Label ───────────────────────────────────────────────────
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
				'selector' => '{{WRAPPER}} .htm25-faq__section-label',
			]
		);

		$this->add_control(
			'section_label_color',
			[
				'label'     => esc_html__( 'Text Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-faq__section-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'section_label_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-faq__section-label' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .htm25-faq__section-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .htm25-faq__section-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 3. Headline ────────────────────────────────────────────────────────
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
				'selector' => '{{WRAPPER}} .htm25-faq__headline',
			]
		);

		$this->add_control(
			'headline_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-faq__headline' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .htm25-faq__headline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'headline_accent_color',
			[
				'label'     => esc_html__( 'Accent Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-faq__headline-accent' => 'background-color: {{VALUE}}; background-image: none;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'headline_accent_gradient',
				'label'          => esc_html__( 'Accent Gradient', 'htmega-addons' ),
				'types'          => [ 'gradient' ],
				'selector'       => '{{WRAPPER}} .htm25-faq__headline-accent',
				'fields_options' => [
					'background' => [
						'label' => esc_html__( 'Gradient Color', 'htmega-addons' ),
					],
				],
			]
		);

		$this->end_controls_section();

		// ── 4. Description ─────────────────────────────────────────────────────
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
				'selector' => '{{WRAPPER}} .htm25-faq__description',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-faq__description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 5. FAQ Item ────────────────────────────────────────────────────────
		$this->start_controls_section(
			'style_faq_item',
			[
				'label' => esc_html__( 'FAQ Item', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'faq_item_bg',
				'label'    => esc_html__( 'Background', 'htmega-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-faq__item',
			]
		);

		$this->add_responsive_control(
			'faq_item_padding',
			[
				'label'      => esc_html__( 'Padding', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-faq__item-summary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'faq_item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-faq__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'faq_item_border',
				'label'    => esc_html__( 'Border', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-faq__item',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'faq_item_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-faq__item',
			]
		);

		$this->add_control(
			'faq_item_open_heading',
			[
				'label'     => esc_html__( 'Open / Active State', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'faq_item_open_bg',
				'label'    => esc_html__( 'Background (Open)', 'htmega-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-faq__item[open]',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'faq_item_open_border',
				'label'    => esc_html__( 'Border (Open)', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-faq__item[open]',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'faq_item_open_box_shadow',
				'label'    => esc_html__( 'Box Shadow (Open)', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-faq__item[open]',
			]
		);

		$this->end_controls_section();

		// ── 6. Question ────────────────────────────────────────────────────────
		$this->start_controls_section(
			'style_question',
			[
				'label' => esc_html__( 'Question', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'question_typography',
				'label'    => esc_html__( 'Typography', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-faq__item-question',
			]
		);

		$this->add_control(
			'question_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-faq__item-question' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'question_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-faq__item-summary:hover .htm25-faq__item-question' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'question_active_color',
			[
				'label'     => esc_html__( 'Active / Open Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-faq__item[open] .htm25-faq__item-question' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'question_category_heading',
			[
				'label'     => esc_html__( 'Category Tag', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'category_typography',
				'label'    => esc_html__( 'Typography', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-faq__item-category',
			]
		);

		$this->add_control(
			'category_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-faq__item-category' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'category_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-faq__item-category' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 7. Answer ──────────────────────────────────────────────────────────
		$this->start_controls_section(
			'style_answer',
			[
				'label' => esc_html__( 'Answer', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'answer_typography',
				'label'    => esc_html__( 'Typography', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-faq__item-answer',
			]
		);

		$this->add_control(
			'answer_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-faq__item-answer' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 8. Toggle Icon (Chevron) ───────────────────────────────────────────
		$this->start_controls_section(
			'style_toggle_icon',
			[
				'label' => esc_html__( 'Toggle Icon', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'toggle_icon_size',
			[
				'label'      => esc_html__( 'Size', 'htmega-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 10, 'max' => 60, 'step' => 1 ],
					'em' => [ 'min' => 0.5, 'max' => 4, 'step' => 0.1 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .htm25-faq__item-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'toggle_icon_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-faq__item-icon'           => 'color: {{VALUE}};',
					'{{WRAPPER}} .htm25-faq__item-icon svg'       => 'color: {{VALUE}};',
					'{{WRAPPER}} .htm25-faq__item-icon svg path'  => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'toggle_icon_active_color',
			[
				'label'     => esc_html__( 'Active / Open Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-faq__item[open] .htm25-faq__item-icon'          => 'color: {{VALUE}};',
					'{{WRAPPER}} .htm25-faq__item[open] .htm25-faq__item-icon svg'      => 'color: {{VALUE}};',
					'{{WRAPPER}} .htm25-faq__item[open] .htm25-faq__item-icon svg path' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->render_faq( $settings );
	}

	/**
	 * Build the full FAQ HTML.
	 */
	private function render_faq( array $settings ) {
		$design_style = ! empty( $settings['design_style'] ) ? $settings['design_style'] : 'bento';
		$layout       = ! empty( $settings['layout'] )       ? $settings['layout']       : 'simple';
		$items        = ! empty( $settings['faq_items'] )    ? $settings['faq_items']    : [];

		$show_label   = ! empty( $settings['show_section_label'] ) && $settings['show_section_label'] === 'yes';
		$label_text   = ! empty( $settings['section_label_text'] ) ? $settings['section_label_text'] : '';
		$headline     = ! empty( $settings['headline'] )     ? $settings['headline']     : '';
		$headline_hl  = ! empty( $settings['headline_highlight'] ) ? $settings['headline_highlight'] : '';
		$headline_tag = ! empty( $settings['headline_tag'] ) ? tag_escape( $settings['headline_tag'] ) : 'h2';
		$description  = ! empty( $settings['description'] )  ? $settings['description']  : '';

		// Headline highlight
		$headline_html = '';
		if ( $headline ) {
			if ( $headline_hl && strpos( $headline, $headline_hl ) !== false ) {
				$headline_html = str_replace(
					esc_html( $headline_hl ),
					'<span class="htm25-faq__headline-accent">' . esc_html( $headline_hl ) . '</span>',
					esc_html( $headline )
				);
			} else {
				$headline_html = esc_html( $headline );
			}
		}

		// Chevron SVG
		$chevron_svg = '<svg class="htm25-faq__item-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
		?>
		<section class="htm25-faq htm25-style--<?php echo esc_attr( $design_style ); ?> htm25-faq--<?php echo esc_attr( $layout ); ?>">

				<?php if ( in_array( $design_style, [ 'glass', 'aurora' ], true ) ) : ?>
				<div class="htm25-faq__bg-blobs" aria-hidden="true">
					<div class="htm25-faq__blob htm25-faq__blob--1"></div>
					<div class="htm25-faq__blob htm25-faq__blob--2"></div>
				</div>
				<?php endif; ?>


				<div class="htm25-faq__inner">

					<?php if ( $show_label && $label_text || $headline || $description ) : ?>
					<header class="htm25-faq__header">
						<?php if ( $show_label && $label_text ) : ?>
						<p class="htm25-faq__section-label">
							<span><?php echo esc_html( $label_text ); ?></span>
						</p>
						<?php endif; ?>

						<?php if ( $headline_html ) : ?>
						<<?php echo $headline_tag; // phpcs:ignore ?> class="htm25-faq__headline"><?php echo $headline_html; // phpcs:ignore ?></<?php echo $headline_tag; // phpcs:ignore ?>>
						<?php endif; ?>

						<?php if ( $description ) : ?>
						<p class="htm25-faq__description"><?php echo esc_html( $description ); ?></p>
						<?php endif; ?>
					</header>
					<?php endif; ?>

					<?php if ( ! empty( $items ) ) : ?>
					<div class="htm25-faq__list" role="list">
						<?php foreach ( $items as $index => $item ) : ?>
							<?php $this->render_faq_item( $item, $index, $chevron_svg ); ?>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>

				</div><!-- .htm25-faq__inner -->
		</section><!-- .htm25-faq -->
		<?php
	}

	/**
	 * Render a single FAQ item using <details>/<summary> for native a11y.
	 */
	private function render_faq_item( array $item, int $index, string $chevron_svg ) {
		$question = ! empty( $item['faq_question'] ) ? $item['faq_question'] : '';
		$answer   = ! empty( $item['faq_answer'] )   ? $item['faq_answer']   : '';
		$category = ! empty( $item['faq_category'] ) ? $item['faq_category'] : '';
		$is_open  = ! empty( $item['faq_open'] ) && $item['faq_open'] === 'yes';
		?>
		<details class="htm25-faq__item" <?php if ( $is_open ) echo 'open'; ?> role="listitem">
			<summary class="htm25-faq__item-summary">
				<div class="htm25-faq__item-question-wrap">
					<?php if ( $category ) : ?>
					<span class="htm25-faq__item-category"><?php echo esc_html( $category ); ?></span>
					<?php endif; ?>
					<span class="htm25-faq__item-question"><?php echo esc_html( $question ); ?></span>
				</div>
				<?php echo $chevron_svg; // phpcs:ignore ?>
			</summary>
			<div class="htm25-faq__item-body">
				<p class="htm25-faq__item-answer"><?php echo esc_html( $answer ); ?></p>
			</div>
		</details><!-- .htm25-faq__item -->
		<?php
	}
}
