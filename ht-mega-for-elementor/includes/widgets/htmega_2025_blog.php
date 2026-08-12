<?php
/**
 * HT Mega 2026 — Blog / Posts Section Widget
 *
 * @package HT_Mega
 * @since   1.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class HTMega_Elementor_Widget_Blog_2025
 */
class HTMega_Elementor_Widget_Blog_2025 extends Widget_Base {

	public function get_name() {
		return 'htmega-2026-blog';
	}

	public function get_title() {
		return esc_html__( 'Blog / Posts 2026', 'ht-mega-for-elementor' );
	}

	public function get_icon() {
		return 'htmega-icon eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'htmega-2026' ];
	}

	public function get_keywords() {
		return [ 'blog', 'posts', 'news', 'articles', 'grid', 'htmega', '2026' ];
	}

	protected function register_controls() {

		// ── CONTENT TAB ────────────────────────────────────────────────────────

		// ── Design Style ──────────────────────────────────────────────────────
		$this->start_controls_section(
			'section_design_style',
			[
				'label' => esc_html__( 'Design Style', 'ht-mega-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'design_style',
			[
				'label'   => esc_html__( 'Style Preset', 'ht-mega-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bento',
				'options' => [
					'bento'  => esc_html__( 'Bento Grid',    'ht-mega-for-elementor' ),
					'glass'  => esc_html__( 'Glassmorphism', 'ht-mega-for-elementor' ),
					'dark'   => esc_html__( 'Dark Minimal',  'ht-mega-for-elementor' ),
					'aurora' => esc_html__( 'Aurora',        'ht-mega-for-elementor' ),
					'neo'    => esc_html__( 'Neo-Brutalist', 'ht-mega-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'ht-mega-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => [
					'grid'     => esc_html__( 'Grid',     'ht-mega-for-elementor' ),
					'list'     => esc_html__( 'List',     'ht-mega-for-elementor' ),
					'featured' => esc_html__( 'Featured', 'ht-mega-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'columns',
			[
				'label'     => esc_html__( 'Columns', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '3',
				'options'   => [
					'2' => esc_html__( '2 Columns', 'ht-mega-for-elementor' ),
					'3' => esc_html__( '3 Columns', 'ht-mega-for-elementor' ),
				],
				'condition' => [ 'layout' => [ 'grid', 'featured' ] ],
			]
		);

		$this->end_controls_section();

		// ── Section Header ─────────────────────────────────────────────────────
		$this->start_controls_section(
			'section_header',
			[
				'label' => esc_html__( 'Section Header', 'ht-mega-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_section_header',
			[
				'label'        => esc_html__( 'Show Section Header', 'ht-mega-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ht-mega-for-elementor' ),
				'label_off'    => esc_html__( 'No',  'ht-mega-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_section_label',
			[
				'label'        => esc_html__( 'Show Label', 'ht-mega-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ht-mega-for-elementor' ),
				'label_off'    => esc_html__( 'No',  'ht-mega-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'show_section_header' => 'yes' ],
			]
		);

		$this->add_control(
			'section_label_text',
			[
				'label'     => esc_html__( 'Label Text', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Latest Articles', 'ht-mega-for-elementor' ),
				'condition' => [
					'show_section_header' => 'yes',
					'show_section_label'  => 'yes',
				],
			]
		);

		$this->add_control(
			'headline',
			[
				'label'     => esc_html__( 'Headline', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Stories Worth Reading', 'ht-mega-for-elementor' ),
				'condition' => [ 'show_section_header' => 'yes' ],
			]
		);

		$this->add_control(
			'headline_highlight',
			[
				'label'     => esc_html__( 'Headline Highlight', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Worth', 'ht-mega-for-elementor' ),
				'condition' => [ 'show_section_header' => 'yes' ],
			]
		);

		$this->add_control(
			'headline_tag',
			[
				'label'     => esc_html__( 'Headline Tag', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h2',
				'options'   => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
				],
				'condition' => [ 'show_section_header' => 'yes' ],
			]
		);

		$this->add_control(
			'description',
			[
				'label'     => esc_html__( 'Description', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::TEXTAREA,
				'rows'      => 3,
				'default'   => esc_html__( 'Insights, tutorials, and updates from our team — delivered fresh.', 'ht-mega-for-elementor' ),
				'condition' => [ 'show_section_header' => 'yes' ],
			]
		);

		$this->end_controls_section();

		// ── Query ──────────────────────────────────────────────────────────────
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'ht-mega-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Number of Posts', 'ht-mega-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 1,
				'max'     => 24,
			]
		);

		// Build category options from WordPress
		$cat_options = [];
		foreach ( get_categories( [ 'hide_empty' => false ] ) as $cat ) {
			$cat_options[ (string) $cat->term_id ] = esc_html( $cat->name );
		}

		$this->add_control(
			'category_ids',
			[
				'label'    => esc_html__( 'Categories', 'ht-mega-for-elementor' ),
				'type'     => Controls_Manager::SELECT2,
				'multiple' => true,
				'default'  => [],
				'options'  => $cat_options,
			]
		);

		// Tag filter
		$tag_options = [ '0' => esc_html__( 'All Tags', 'ht-mega-for-elementor' ) ];
		foreach ( get_tags( [ 'hide_empty' => false ] ) as $tag ) {
			$tag_options[ (string) $tag->term_id ] = esc_html( $tag->name );
		}

		$this->add_control(
			'tag_id',
			[
				'label'   => esc_html__( 'Tag', 'ht-mega-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $tag_options,
			]
		);

		// Author filter
		$author_options = [ '0' => esc_html__( 'All Authors', 'ht-mega-for-elementor' ) ];
		foreach ( get_users( [ 'capability' => [ 'edit_posts' ], 'fields' => [ 'ID', 'display_name' ] ] ) as $u ) {
			$author_options[ (string) $u->ID ] = esc_html( $u->display_name );
		}

		$this->add_control(
			'author_id',
			[
				'label'   => esc_html__( 'Author', 'ht-mega-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $author_options,
			]
		);

		$this->add_control(
			'sticky_posts',
			[
				'label'   => esc_html__( 'Sticky Posts', 'ht-mega-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'include',
				'options' => [
					'include' => esc_html__( 'Include (Default)', 'ht-mega-for-elementor' ),
					// phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_exclude -- false positive: this is just the array key/label for the 'sticky_posts' SELECT control option ("Exclude Sticky"), not a WP_Query exclude arg.
					'exclude' => esc_html__( 'Exclude Sticky',    'ht-mega-for-elementor' ),
					'only'    => esc_html__( 'Sticky Only',       'ht-mega-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'exclude_current',
			[
				'label'        => esc_html__( 'Exclude Current Post', 'ht-mega-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ht-mega-for-elementor' ),
				'label_off'    => esc_html__( 'No',  'ht-mega-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'posts_offset',
			[
				'label'   => esc_html__( 'Offset (Skip Posts)', 'ht-mega-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'min'     => 0,
				'max'     => 100,
			]
		);

		$this->add_control(
			'order_by',
			[
				'label'   => esc_html__( 'Order By', 'ht-mega-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'   => esc_html__( 'Newest First',    'ht-mega-for-elementor' ),
					'date_a' => esc_html__( 'Oldest First',    'ht-mega-for-elementor' ),
					'title'  => esc_html__( 'Title A–Z',       'ht-mega-for-elementor' ),
					'rand'   => esc_html__( 'Random',          'ht-mega-for-elementor' ),
					'modified' => esc_html__( 'Recently Updated', 'ht-mega-for-elementor' ),
				],
			]
		);

		$this->end_controls_section();

		// ── Card Display ───────────────────────────────────────────────────────
		$this->start_controls_section(
			'section_display',
			[
				'label' => esc_html__( 'Card Display', 'ht-mega-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_image',
			[
				'label'        => esc_html__( 'Featured Image', 'ht-mega-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ht-mega-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'ht-mega-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_category',
			[
				'label'        => esc_html__( 'Category Badge', 'ht-mega-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ht-mega-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'ht-mega-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_author',
			[
				'label'        => esc_html__( 'Author', 'ht-mega-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ht-mega-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'ht-mega-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'        => esc_html__( 'Date', 'ht-mega-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ht-mega-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'ht-mega-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_read_time',
			[
				'label'        => esc_html__( 'Read Time', 'ht-mega-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ht-mega-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'ht-mega-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label'        => esc_html__( 'Excerpt', 'ht-mega-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ht-mega-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'ht-mega-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label'     => esc_html__( 'Excerpt Length (words)', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 20,
				'min'       => 5,
				'max'       => 80,
				'condition' => [ 'show_excerpt' => 'yes' ],
			]
		);

		$this->add_control(
			'show_read_more',
			[
				'label'        => esc_html__( 'Read More Link', 'ht-mega-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ht-mega-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'ht-mega-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label'     => esc_html__( 'Read More Text', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read Article', 'ht-mega-for-elementor' ),
				'condition' => [ 'show_read_more' => 'yes' ],
			]
		);

		$this->end_controls_section();

		// ── STYLE TAB ──────────────────────────────────────────────────────────

		// ── 1. Section ─────────────────────────────────────────────────────────
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Section', 'ht-mega-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label'      => esc_html__( 'Padding', 'ht-mega-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-blog' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'section_bg',
				'label'    => esc_html__( 'Background', 'ht-mega-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-blog',
			]
		);

		$this->end_controls_section();

		// ── 2. Section Label ───────────────────────────────────────────────────
		$this->start_controls_section(
			'style_section_label',
			[
				'label'     => esc_html__( 'Section Label', 'ht-mega-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_section_header' => 'yes',
					'show_section_label'  => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'section_label_typography',
				'selector' => '{{WRAPPER}} .htm25-blog__section-label',
			]
		);

		$this->add_control(
			'section_label_color',
			[
				'label'     => esc_html__( 'Text Color', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-blog__section-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'section_label_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-blog__section-label' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_label_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-blog__section-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_label_padding',
			[
				'label'      => esc_html__( 'Padding', 'ht-mega-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-blog__section-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 3. Headline ────────────────────────────────────────────────────────
		$this->start_controls_section(
			'style_headline',
			[
				'label'     => esc_html__( 'Headline', 'ht-mega-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_section_header' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'headline_typography',
				'selector' => '{{WRAPPER}} .htm25-blog__headline',
			]
		);

		$this->add_control(
			'headline_color',
			[
				'label'     => esc_html__( 'Color', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-blog__headline' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'headline_margin',
			[
				'label'      => esc_html__( 'Margin', 'ht-mega-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-blog__headline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'headline_accent_heading',
			[
				'label'     => esc_html__( 'Headline Accent', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'headline_accent_color',
			[
				'label'     => esc_html__( 'Accent Color', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-blog__headline-accent' => 'background-color: {{VALUE}}; background-image: none;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'headline_accent_gradient',
				'label'          => esc_html__( 'Accent Gradient', 'ht-mega-for-elementor' ),
				'types'          => [ 'gradient' ],
				'selector'       => '{{WRAPPER}} .htm25-blog__headline-accent',
				'fields_options' => [
					'background' => [
						'label' => esc_html__( 'Gradient Color', 'ht-mega-for-elementor' ),
					],
				],
			]
		);

		$this->end_controls_section();

		// ── 4. Description ─────────────────────────────────────────────────────
		$this->start_controls_section(
			'style_description',
			[
				'label'     => esc_html__( 'Description', 'ht-mega-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_section_header' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .htm25-blog__description',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Color', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-blog__description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 5. Post Card ───────────────────────────────────────────────────────
		$this->start_controls_section(
			'style_card',
			[
				'label' => esc_html__( 'Post Card', 'ht-mega-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'card_bg',
				'label'    => esc_html__( 'Background', 'ht-mega-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-blog__card',
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Body Padding', 'ht-mega-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-blog__card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-blog__card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .htm25-blog__card',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .htm25-blog__card',
			]
		);

		$this->add_responsive_control(
			'card_grid_gap',
			[
				'label'      => esc_html__( 'Grid Gap', 'ht-mega-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-blog__grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 6. Post Thumbnail / Image ──────────────────────────────────────────
		$this->start_controls_section(
			'style_image',
			[
				'label'     => esc_html__( 'Post Thumbnail', 'ht-mega-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_image' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-blog__card-image-wrap'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .htm25-blog__card-image-wrap img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label'      => esc_html__( 'Image Height', 'ht-mega-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'vh' ],
				'range'      => [ 'px' => [ 'min' => 100, 'max' => 600 ] ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-blog__card-image-wrap' => 'aspect-ratio: unset; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .htm25-blog__card-image-wrap',
			]
		);

		$this->end_controls_section();

		// ── 7. Category Badge ──────────────────────────────────────────────────
		$this->start_controls_section(
			'style_category',
			[
				'label'     => esc_html__( 'Category Badge', 'ht-mega-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_category' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'category_typography',
				'selector' => '{{WRAPPER}} .htm25-blog__card-category',
			]
		);

		$this->add_control(
			'category_color',
			[
				'label'     => esc_html__( 'Text Color', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-blog__card-category' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'category_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-blog__card-category' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'category_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-blog__card-category' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 8. Post Title ──────────────────────────────────────────────────────
		$this->start_controls_section(
			'style_post_title',
			[
				'label' => esc_html__( 'Post Title', 'ht-mega-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'post_title_typography',
				'selector' => '{{WRAPPER}} .htm25-blog__card-title',
			]
		);

		$this->add_control(
			'post_title_color',
			[
				'label'     => esc_html__( 'Color', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-blog__card-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'post_title_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-blog__card-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 9. Post Excerpt ────────────────────────────────────────────────────
		$this->start_controls_section(
			'style_excerpt',
			[
				'label'     => esc_html__( 'Post Excerpt', 'ht-mega-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_excerpt' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'excerpt_typography',
				'selector' => '{{WRAPPER}} .htm25-blog__card-excerpt',
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label'     => esc_html__( 'Color', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-blog__card-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 10. Post Meta (author, date, read time) ────────────────────────────
		$this->start_controls_section(
			'style_post_meta',
			[
				'label' => esc_html__( 'Post Meta', 'ht-mega-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'post_meta_typography',
				'selector' => '{{WRAPPER}} .htm25-blog__card-author, {{WRAPPER}} .htm25-blog__card-date, {{WRAPPER}} .htm25-blog__card-read-time',
			]
		);

		$this->add_control(
			'post_meta_color',
			[
				'label'     => esc_html__( 'Color', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-blog__card-author'    => 'color: {{VALUE}};',
					'{{WRAPPER}} .htm25-blog__card-date'      => 'color: {{VALUE}};',
					'{{WRAPPER}} .htm25-blog__card-read-time' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'author_avatar_heading',
			[
				'label'     => esc_html__( 'Author Avatar', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'show_author' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'author_avatar_size',
			[
				'label'      => esc_html__( 'Avatar Size', 'ht-mega-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-blog__card-avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'show_author' => 'yes' ],
			]
		);

		$this->add_control(
			'author_avatar_border_radius',
			[
				'label'      => esc_html__( 'Avatar Border Radius', 'ht-mega-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-blog__card-avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 'show_author' => 'yes' ],
			]
		);

		$this->add_control(
			'author_avatar_border_width',
			[
				'label'      => esc_html__( 'Avatar Border Width', 'ht-mega-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 10 ] ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-blog__card-avatar' => 'border-style: solid; border-width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'show_author' => 'yes' ],
			]
		);

		$this->add_control(
			'author_avatar_border_color',
			[
				'label'     => esc_html__( 'Avatar Border Color', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-blog__card-avatar' => 'border-color: {{VALUE}};',
				],
				'condition' => [ 'show_author' => 'yes' ],
			]
		);

		$this->end_controls_section();

		// ── 11. Read More Link ─────────────────────────────────────────────────
		$this->start_controls_section(
			'style_read_more',
			[
				'label'     => esc_html__( 'Read More Link', 'ht-mega-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_read_more' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'read_more_typography',
				'selector' => '{{WRAPPER}} .htm25-blog__card-read-more',
			]
		);

		$this->add_control(
			'read_more_color',
			[
				'label'     => esc_html__( 'Color', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-blog__card-read-more' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'read_more_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'ht-mega-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-blog__card-read-more:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->render_blog( $settings );
	}

	/**
	 * Build the full blog HTML.
	 */
	private function render_blog( array $settings ) {
		$design_style = ! empty( $settings['design_style'] )   ? $settings['design_style']   : 'bento';
		$layout       = ! empty( $settings['layout'] )          ? $settings['layout']          : 'grid';
		$columns      = ! empty( $settings['columns'] )         ? (int) $settings['columns']   : 3;

		// Display flags
		$show_header    = ! empty( $settings['show_section_header'] ) && $settings['show_section_header'] === 'yes';
		$show_label     = $show_header && ! empty( $settings['show_section_label'] ) && $settings['show_section_label'] === 'yes';
		$label_text     = ! empty( $settings['section_label_text'] )  ? $settings['section_label_text']  : '';
		$headline       = ! empty( $settings['headline'] )             ? $settings['headline']             : '';
		$headline_hl    = ! empty( $settings['headline_highlight'] )   ? $settings['headline_highlight']   : '';
		$headline_tag   = ! empty( $settings['headline_tag'] )         ? tag_escape( $settings['headline_tag'] ) : 'h2';
		$description    = ! empty( $settings['description'] )          ? $settings['description']          : '';

		$show_image     = ! empty( $settings['show_image'] )     && $settings['show_image']     === 'yes';
		$show_category  = ! empty( $settings['show_category'] )  && $settings['show_category']  === 'yes';
		$show_author    = ! empty( $settings['show_author'] )    && $settings['show_author']    === 'yes';
		$show_date      = ! empty( $settings['show_date'] )      && $settings['show_date']      === 'yes';
		$show_read_time = ! empty( $settings['show_read_time'] ) && $settings['show_read_time'] === 'yes';
		$show_excerpt   = ! empty( $settings['show_excerpt'] )   && $settings['show_excerpt']   === 'yes';
		$excerpt_length = ! empty( $settings['excerpt_length'] ) ? (int) $settings['excerpt_length'] : 20;
		$show_read_more = ! empty( $settings['show_read_more'] ) && $settings['show_read_more'] === 'yes';
		$read_more_text = ! empty( $settings['read_more_text'] ) ? $settings['read_more_text'] : esc_html__( 'Read Article', 'ht-mega-for-elementor' );

		// Headline HTML
		$headline_html = '';
		if ( $show_header && $headline ) {
			if ( $headline_hl && strpos( $headline, $headline_hl ) !== false ) {
				$headline_html = str_replace(
					esc_html( $headline_hl ),
					'<span class="htm25-blog__headline-accent">' . esc_html( $headline_hl ) . '</span>',
					esc_html( $headline )
				);
			} else {
				$headline_html = esc_html( $headline );
			}
		}

		// WP_Query
		$order    = 'DESC';
		$orderby  = 'date';
		$order_by = ! empty( $settings['order_by'] ) ? $settings['order_by'] : 'date';
		if ( $order_by === 'date_a' ) {
			$orderby = 'date';
			$order   = 'ASC';
		} elseif ( $order_by === 'title' ) {
			$orderby = 'title';
			$order   = 'ASC';
		} elseif ( $order_by === 'rand' ) {
			$orderby = 'rand';
		} elseif ( $order_by === 'modified' ) {
			$orderby = 'modified';
		}

		$query_args = [
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => ! empty( $settings['posts_per_page'] ) ? (int) $settings['posts_per_page'] : 6,
			'orderby'        => $orderby,
			'order'          => $order,
			'no_found_rows'  => true,
		];

		// Category multi-select (Issue #8)
		$cat_ids = array_filter( array_map( 'intval', (array) ( $settings['category_ids'] ?? [] ) ) );
		if ( ! empty( $cat_ids ) ) {
			$query_args['category__in'] = $cat_ids;
		}

		// Tag filter (Issue #9)
		$tag_id = intval( $settings['tag_id'] ?? 0 );
		if ( $tag_id > 0 ) {
			$query_args['tag_id'] = $tag_id;
		}

		// Author filter (Issue #10)
		$author_id = intval( $settings['author_id'] ?? 0 );
		if ( $author_id > 0 ) {
			$query_args['author'] = $author_id;
		}

		// Sticky posts (Issue #11)
		$sticky_posts = $settings['sticky_posts'] ?? 'include';
		if ( $sticky_posts === 'exclude' ) {
			$query_args['ignore_sticky_posts'] = 1;
		} elseif ( $sticky_posts === 'only' ) {
			$sticky_ids = get_option( 'sticky_posts' );
			$query_args['post__in'] = ! empty( $sticky_ids ) ? $sticky_ids : [ 0 ];
		}

		// Exclude current post (Issue #12)
		if ( ( $settings['exclude_current'] ?? '' ) === 'yes' ) {
			$current_id = get_the_ID();
			if ( $current_id ) {
				$existing = $query_args['post__not_in'] ?? [];
				// phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_post__not_in -- intentional: implements the widget's 'Exclude Current Post' (exclude_current) control, letting the site builder omit the current post from the blog listing.
				$query_args['post__not_in'] = array_merge( (array) $existing, [ $current_id ] );
			}
		}

		// Offset (Issue #13)
		$offset = intval( $settings['posts_offset'] ?? 0 );
		if ( $offset > 0 ) {
			$query_args['offset'] = $offset;
		}

		$query = new \WP_Query( $query_args );

		$display = compact(
			'show_image', 'show_category', 'show_author', 'show_date',
			'show_read_time', 'show_excerpt', 'excerpt_length',
			'show_read_more', 'read_more_text'
		);

		?>
		<section class="htm25-blog htm25-style--<?php echo esc_attr( $design_style ); ?> htm25-blog--<?php echo esc_attr( $layout ); ?>">

			<?php if ( in_array( $design_style, [ 'glass', 'aurora' ], true ) ) : ?>
			<div class="htm25-blog__bg-blobs" aria-hidden="true">
				<div class="htm25-blog__blob htm25-blog__blob--1"></div>
				<div class="htm25-blog__blob htm25-blog__blob--2"></div>
			</div>
			<?php endif; ?>


			<div class="htm25-blog__inner">

				<?php if ( $show_header && ( $label_text || $headline_html || $description ) ) : ?>
				<header class="htm25-blog__header">
					<?php if ( $show_label && $label_text ) : ?>
					<p class="htm25-blog__section-label">
						<span><?php echo esc_html( $label_text ); ?></span>
					</p>
					<?php endif; ?>

					<?php if ( $headline_html ) : ?>
					<<?php echo $headline_tag; // phpcs:ignore ?> class="htm25-blog__headline"><?php echo $headline_html; // phpcs:ignore ?></<?php echo $headline_tag; // phpcs:ignore ?>>
					<?php endif; ?>

					<?php if ( $description ) : ?>
					<p class="htm25-blog__description"><?php echo esc_html( $description ); ?></p>
					<?php endif; ?>
				</header>
				<?php endif; ?>

				<?php if ( $query->have_posts() ) : ?>
				<div class="htm25-blog__grid htm25-blog__grid--cols-<?php echo esc_attr( $columns ); ?>"
				     role="list">
					<?php
					$post_index = 0;
					while ( $query->have_posts() ) :
						$query->the_post();
						$this->render_post_card( get_post(), $post_index, $layout, $display );
						$post_index++;
					endwhile;
					wp_reset_postdata();
					?>
				</div>
				<?php else : ?>
				<div class="htm25-blog__empty">
					<p><?php esc_html_e( 'No posts found. Publish some posts to see them here.', 'ht-mega-for-elementor' ); ?></p>
				</div>
				<?php endif; ?>

			</div><!-- .htm25-blog__inner -->
		</section><!-- .htm25-blog -->
		<?php
	}

	/**
	 * Render a single post card.
	 */
	private function render_post_card( \WP_Post $post, int $index, string $layout, array $d ) {
		$post_id    = $post->ID;
		$permalink  = get_permalink( $post_id );
		$title      = get_the_title( $post_id );
		$is_hero    = ( $layout === 'featured' && $index === 0 );

		// Read time (approx 200 words/min)
		$word_count = str_word_count( wp_strip_all_tags( $post->post_content ) );
		$read_mins  = max( 1, (int) ceil( $word_count / 200 ) );

		// Primary category
		$cats     = get_the_category( $post_id );
		$cat_name = ! empty( $cats ) ? $cats[0]->name : '';
		$cat_url  = ! empty( $cats ) ? get_category_link( $cats[0]->term_id ) : '';

		// Author
		$author_id     = $post->post_author;
		$author_name   = get_the_author_meta( 'display_name', $author_id );
		$author_avatar = get_avatar_url( $author_id, [ 'size' => 40 ] );

		// Excerpt
		$excerpt = '';
		if ( $d['show_excerpt'] ) {
			if ( $post->post_excerpt ) {
				$excerpt = wp_trim_words( $post->post_excerpt, $d['excerpt_length'], '…' );
			} else {
				$excerpt = wp_trim_words( wp_strip_all_tags( $post->post_content ), $d['excerpt_length'], '…' );
			}
		}

		// Image size: hero gets large, others medium
		$img_size = $is_hero ? 'large' : 'medium_large';
		$thumb    = $d['show_image'] ? get_the_post_thumbnail( $post_id, $img_size ) : '';

		$card_class = implode( ' ', array_filter( [
			'htm25-blog__card',
			$is_hero ? 'htm25-blog__card--hero' : '',
		] ) );
		?>
		<article class="<?php echo esc_attr( $card_class ); ?>" role="listitem">

			<?php if ( $d['show_image'] && $thumb ) : ?>
			<a href="<?php echo esc_url( $permalink ); ?>" class="htm25-blog__card-image-link" tabindex="-1" aria-hidden="true">
				<div class="htm25-blog__card-image-wrap">
					<?php echo $thumb; // phpcs:ignore ?>
				</div>
			</a>
			<?php elseif ( $d['show_image'] ) : ?>
			<a href="<?php echo esc_url( $permalink ); ?>" class="htm25-blog__card-image-link" tabindex="-1" aria-hidden="true">
				<div class="htm25-blog__card-image-wrap htm25-blog__card-image-wrap--placeholder">
					<svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.5"/>
						<circle cx="8.5" cy="8.5" r="1.5" stroke="currentColor" stroke-width="1.5"/>
						<path d="M21 15L16 10L9 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</div>
			</a>
			<?php endif; ?>

			<div class="htm25-blog__card-body">

				<?php if ( $d['show_category'] && $cat_name ) : ?>
				<div class="htm25-blog__card-meta-top">
					<a href="<?php echo esc_url( $cat_url ); ?>" class="htm25-blog__card-category">
						<?php echo esc_html( $cat_name ); ?>
					</a>
					<?php if ( $d['show_read_time'] ) : ?>
					<span class="htm25-blog__card-read-time" aria-label="<?php echo esc_attr( $read_mins . ' min read' ); ?>">
						<?php echo esc_html( $read_mins ) . esc_html__( ' min read', 'ht-mega-for-elementor' ); ?>
					</span>
					<?php endif; ?>
				</div>
				<?php elseif ( $d['show_read_time'] ) : ?>
				<div class="htm25-blog__card-meta-top">
					<span class="htm25-blog__card-read-time">
						<?php echo esc_html( $read_mins ) . esc_html__( ' min read', 'ht-mega-for-elementor' ); ?>
					</span>
				</div>
				<?php endif; ?>

				<h3 class="htm25-blog__card-title">
					<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
				</h3>

				<?php if ( $d['show_excerpt'] && $excerpt ) : ?>
				<p class="htm25-blog__card-excerpt"><?php echo esc_html( $excerpt ); ?></p>
				<?php endif; ?>

				<footer class="htm25-blog__card-footer">
					<?php if ( $d['show_author'] || $d['show_date'] ) : ?>
					<div class="htm25-blog__card-byline">
						<?php if ( $d['show_author'] ) : ?>
						<img src="<?php echo esc_url( $author_avatar ); ?>"
						     alt="<?php echo esc_attr( $author_name ); ?>"
						     class="htm25-blog__card-avatar"
						     width="28" height="28"
						     loading="lazy" />
						<span class="htm25-blog__card-author"><?php echo esc_html( $author_name ); ?></span>
						<?php endif; ?>

						<?php if ( $d['show_author'] && $d['show_date'] ) : ?>
						<span class="htm25-blog__card-byline-sep" aria-hidden="true">·</span>
						<?php endif; ?>

						<?php if ( $d['show_date'] ) : ?>
						<time class="htm25-blog__card-date" datetime="<?php echo esc_attr( get_the_date( 'c', $post_id ) ); ?>">
							<?php echo esc_html( get_the_date( '', $post_id ) ); ?>
						</time>
						<?php endif; ?>
					</div>
					<?php endif; ?>

					<?php if ( $d['show_read_more'] ) : ?>
					<a href="<?php echo esc_url( $permalink ); ?>"
					   class="htm25-blog__card-read-more"
					   aria-label="<?php echo esc_attr( $d['read_more_text'] . ': ' . $title ); ?>">
						<?php echo esc_html( $d['read_more_text'] ); ?>
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
							<path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</a>
					<?php endif; ?>
				</footer>

			</div><!-- .htm25-blog__card-body -->

		</article><!-- .htm25-blog__card -->
		<?php
	}
}
