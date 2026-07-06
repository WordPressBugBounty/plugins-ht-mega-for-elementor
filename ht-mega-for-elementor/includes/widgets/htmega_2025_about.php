<?php
/**
 * HT Mega 2026 — About / Feature Widget
 * Widget name: htmega-2026-about
 *
 * Part of the HT Mega 2026 Collection.
 * Shares BEM HTML with htmega-blocks/src/blocks/about-2025/index.php.
 * All styles live in assets/css/widgets/htm25-about.css.
 * All CSS values reference tokens from assets/css/htm25-tokens.css.
 *
 * PHP namespace: \Elementor   (required for Elementor auto-discovery)
 * Class: HTMega_Elementor_Widget_About_2025
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class HTMega_Elementor_Widget_About_2025 extends Widget_Base {

    // ── Identity ──────────────────────────────────────────────

    public function get_name()        { return 'htmega-2026-about'; }
    public function get_title()       { return __( 'About / Feature 2026', 'htmega-addons' ); }
    public function get_icon()        { return 'htmega-icon eicon-info-box'; }
    public function get_categories()  { return [ 'htmega-2026' ]; }
    public function get_keywords()    { return [ 'about', 'why choose us','about us', 'feature', 'htmega', '2026', 'section', 'services', 'bento' ]; }

    // ── Controls ──────────────────────────────────────────────

    protected function register_controls() {

        // ════════════════════════════════════════════════════════
        //  CONTENT TAB
        // ════════════════════════════════════════════════════════

        /* ── Design Style ── */
        $this->start_controls_section( 'section_design_style', [
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
                'default' => 'split-left',
                'options' => [
                    'split-left'   => __( 'Split — Text Left',  'htmega-addons' ),
                    'split-right'  => __( 'Split — Text Right', 'htmega-addons' ),
                    'centered'     => __( 'Centered / Stacked', 'htmega-addons' ),
                    'feature-grid' => __( 'Feature Grid',       'htmega-addons' ),
                ],
            ] );

            $this->add_control( 'feature_columns', [
                'label'     => __( 'Feature Columns', 'htmega-addons' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '2',
                'options'   => [
                    '1' => __( '1 Column',  'htmega-addons' ),
                    '2' => __( '2 Columns', 'htmega-addons' ),
                    '3' => __( '3 Columns', 'htmega-addons' ),
                ],
                'condition' => [ 'layout' => 'feature-grid' ],
            ] );

        $this->end_controls_section();

        /* ── Section Header ── */
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
                'default'   => __( 'Why Choose Us', 'htmega-addons' ),
                'condition' => [ 'show_section_label' => 'yes' ],
            ] );

            $this->add_control( 'headline', [
                'label'   => __( 'Headline', 'htmega-addons' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __( "Everything you need to\nbuild something great.", 'htmega-addons' ),
                'rows'    => 3,
            ] );

            $this->add_control( 'headline_highlight', [
                'label'       => __( 'Highlighted Word(s)', 'htmega-addons' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'something great', 'htmega-addons' ),
                'description' => __( 'These words will be styled with the accent color/gradient.', 'htmega-addons' ),
            ] );

            $this->add_control( 'headline_tag', [
                'label'   => __( 'HTML Tag', 'htmega-addons' ),
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
                'default' => __( 'A focused toolkit designed around real developer and designer workflows. Minimal setup, maximum output.', 'htmega-addons' ),
                'rows'    => 4,
            ] );

        $this->end_controls_section();

        /* ── Feature Items ── */
        $this->start_controls_section( 'section_features', [
            'label' => __( 'Feature Items', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

            $repeater = new Repeater();

            $repeater->add_control( 'feature_icon', [
                'label'   => __( 'Icon', 'htmega-addons' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ] );

            $repeater->add_control( 'feature_title', [
                'label'   => __( 'Title', 'htmega-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Feature Name', 'htmega-addons' ),
            ] );

            $repeater->add_control( 'feature_description', [
                'label'   => __( 'Description', 'htmega-addons' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __( 'Short explanation of what this feature does and why it matters.', 'htmega-addons' ),
                'rows'    => 3,
            ] );

            $this->add_control( 'feature_items', [
                'label'       => __( 'Features', 'htmega-addons' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'feature_icon'        => [ 'value' => 'fas fa-bolt',   'library' => 'fa-solid' ],
                        'feature_title'       => __( 'Lightning Fast', 'htmega-addons' ),
                        'feature_description' => __( 'Optimised for Core Web Vitals from day one — zero layout shift, sub-second LCP.', 'htmega-addons' ),
                    ],
                    [
                        'feature_icon'        => [ 'value' => 'fas fa-shield-alt', 'library' => 'fa-solid' ],
                        'feature_title'       => __( 'Secure by Default', 'htmega-addons' ),
                        'feature_description' => __( 'Every output is sanitised and escaped. CSRF tokens on all forms, nonces everywhere.', 'htmega-addons' ),
                    ],
                    [
                        'feature_icon'        => [ 'value' => 'fas fa-palette', 'library' => 'fa-solid' ],
                        'feature_title'       => __( 'Design Token System', 'htmega-addons' ),
                        'feature_description' => __( 'Full CSS custom-property token layer — change a brand colour in one place, it updates everywhere.', 'htmega-addons' ),
                    ],
                    [
                        'feature_icon'        => [ 'value' => 'fas fa-universal-access', 'library' => 'fa-solid' ],
                        'feature_title'       => __( 'Accessible First', 'htmega-addons' ),
                        'feature_description' => __( 'WCAG 2.1 AA compliant. Proper landmarks, focus rings, and ARIA attributes out of the box.', 'htmega-addons' ),
                    ],
                ],
                'title_field' => '{{{ feature_title }}}',
            ] );

        $this->end_controls_section();

        /* ── Media ── */
        $this->start_controls_section( 'section_media', [
            'label'     => __( 'Media', 'htmega-addons' ),
            'tab'       => Controls_Manager::TAB_CONTENT,
            'condition' => [
                'layout!' => [ 'centered', 'feature-grid' ],
            ],
        ] );

            $this->add_control( 'about_image', [
                'label'   => __( 'Image', 'htmega-addons' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [ 'url' => '' ],
            ] );

            $this->add_control( 'about_image_size', [
                'label'   => __( 'Image Size', 'htmega-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'large',
                'options' => [
                    'thumbnail' => __( 'Thumbnail', 'htmega-addons' ),
                    'medium'    => __( 'Medium',    'htmega-addons' ),
                    'large'     => __( 'Large',     'htmega-addons' ),
                    'full'      => __( 'Full',      'htmega-addons' ),
                ],
            ] );

            $this->add_control( 'show_floating_badge', [
                'label'        => __( 'Show Floating Badge', 'htmega-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'htmega-addons' ),
                'label_off'    => __( 'Hide', 'htmega-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ] );

            $this->add_control( 'floating_stat_number', [
                'label'     => __( 'Badge Number', 'htmega-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => '10K+',
                'condition' => [ 'show_floating_badge' => 'yes' ],
            ] );

            $this->add_control( 'floating_stat_label', [
                'label'     => __( 'Badge Label', 'htmega-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Projects Built', 'htmega-addons' ),
                'condition' => [ 'show_floating_badge' => 'yes' ],
            ] );

        $this->end_controls_section();

        /* ── CTA Button ── */
        $this->start_controls_section( 'section_cta', [
            'label' => __( 'CTA Button', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

            $this->add_control( 'show_cta', [
                'label'        => __( 'Show CTA Button', 'htmega-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'htmega-addons' ),
                'label_off'    => __( 'Hide', 'htmega-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ] );

            $this->add_control( 'cta_text', [
                'label'     => __( 'Button Text', 'htmega-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Explore Features', 'htmega-addons' ),
                'condition' => [ 'show_cta' => 'yes' ],
            ] );

            $this->add_control( 'cta_url', [
                'label'       => __( 'Button URL', 'htmega-addons' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => 'https://',
                'default'     => [ 'url' => '#' ],
                'condition'   => [ 'show_cta' => 'yes' ],
            ] );

            $this->add_control( 'cta_icon', [
                'label'     => __( 'Button Icon', 'htmega-addons' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-arrow-right',
                    'library' => 'fa-solid',
                ],
                'condition' => [ 'show_cta' => 'yes' ],
            ] );

        $this->end_controls_section();

        // ════════════════════════════════════════════════════════
        //  STYLE TAB
        // ════════════════════════════════════════════════════════

        /* ── Section Padding ── */
        $this->start_controls_section( 'style_section', [
            'label' => __( 'Section', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

            $this->add_responsive_control( 'section_padding', [
                'label'      => __( 'Padding', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-about' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_group_control( Group_Control_Background::get_type(), [
                'name'     => 'section_bg',
                'label'    => __( 'Background', 'htmega-addons' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .htm25-about',
            ] );

        $this->end_controls_section();

        /* ── Typography ── */
        $this->start_controls_section( 'style_typography', [
            'label' => __( 'Typography', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

            /* — Section Label — */
            $this->add_control( 'label_heading', [
                'label'     => __( 'Section Label', 'htmega-addons' ),
                'type'      => Controls_Manager::HEADING,
                'condition' => [ 'show_section_label' => 'yes' ],
            ] );

            $this->add_group_control( Group_Control_Typography::get_type(), [
                'name'      => 'label_typography',
                'selector'  => '{{WRAPPER}} .htm25-about__section-label',
                'condition' => [ 'show_section_label' => 'yes' ],
            ] );

            $this->add_control( 'heading_label_color', [
                'label'     => __( 'Text Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => [ 'show_section_label' => 'yes' ],
                'selectors' => [
                    '{{WRAPPER}} .htm25-about__section-label' => 'color: {{VALUE}};',
                ],
            ] );

            $this->add_control( 'section_label_bg', [
                'label'     => __( 'Background Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => [ 'show_section_label' => 'yes' ],
                'selectors' => [
                    '{{WRAPPER}} .htm25-about__section-label' => 'background-color: {{VALUE}};',
                ],
            ] );

            $this->add_control( 'section_label_radius', [
                'label'      => __( 'Border Radius', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'condition'  => [ 'show_section_label' => 'yes' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-about__section-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_control( 'section_label_padding', [
                'label'      => __( 'Padding', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'condition'  => [ 'show_section_label' => 'yes' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-about__section-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            /* — Headline — */
            $this->add_control( 'headline_heading', [
                'label'     => __( 'Headline', 'htmega-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ] );

            $this->add_group_control( Group_Control_Typography::get_type(), [
                'name'     => 'headline_typography',
                'selector' => '{{WRAPPER}} .htm25-about__headline',
            ] );

            $this->add_control( 'headline_color', [
                'label'     => __( 'Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-about__headline' => 'color: {{VALUE}};',
                ],
            ] );

            $this->add_responsive_control( 'headline_margin', [
                'label'      => __( 'Margin', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-about__headline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            /* — Headline Accent / Highlight — */
            $this->add_control( 'accent_heading', [
                'label'     => __( 'Headline Accent', 'htmega-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ] );

            $this->add_control( 'headline_accent_color', [
                'label'     => __( 'Accent Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-about__headline-accent' => 'background-color: {{VALUE}}; background-image: none;',
                ],
            ] );

            $this->add_group_control( Group_Control_Background::get_type(), [
                'name'           => 'headline_highlight_gradient',
                'label'          => __( 'Accent Gradient', 'htmega-addons' ),
                'types'          => [ 'gradient' ],
                'selector'       => '{{WRAPPER}} .htm25-about__headline-accent',
                'fields_options' => [
                    'background' => [
                        'label' => __( 'Gradient Color', 'htmega-addons' ),
                    ],
                ],
            ] );

            /* — Description — */
            $this->add_control( 'description_heading', [
                'label'     => __( 'Description', 'htmega-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ] );

            $this->add_group_control( Group_Control_Typography::get_type(), [
                'name'     => 'description_typography',
                'selector' => '{{WRAPPER}} .htm25-about__description',
            ] );

            $this->add_control( 'description_color', [
                'label'     => __( 'Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-about__description' => 'color: {{VALUE}};',
                ],
            ] );

        $this->end_controls_section();

        /* ── Feature Cards ── */
        $this->start_controls_section( 'style_features', [
            'label' => __( 'Feature Items', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

            /* — Card — */
            $this->add_group_control( Group_Control_Background::get_type(), [
                'name'     => 'feature_card_bg',
                'label'    => __( 'Card Background', 'htmega-addons' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .htm25-about__feature',
            ] );

            $this->add_responsive_control( 'feature_card_padding', [
                'label'      => __( 'Card Padding', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-about__feature' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_control( 'feature_card_radius', [
                'label'      => __( 'Card Border Radius', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-about__feature' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_group_control( Group_Control_Border::get_type(), [
                'name'     => 'feature_card_border',
                'selector' => '{{WRAPPER}} .htm25-about__feature',
            ] );

            $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
                'name'     => 'feature_card_shadow',
                'selector' => '{{WRAPPER}} .htm25-about__feature',
            ] );

            /* — Icon — */
            $this->add_control( 'feature_icon_heading', [
                'label'     => __( 'Icon', 'htmega-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ] );

            $this->add_control( 'feature_icon_color', [
                'label'     => __( 'Icon Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-about .htm25-about__feature-icon i'        => 'color: {{VALUE}};',
                    '{{WRAPPER}} .htm25-about .htm25-about__feature-icon svg'      => 'color: {{VALUE}};',
                    '{{WRAPPER}} .htm25-about .htm25-about__feature-icon svg path' => 'fill: {{VALUE}};',
                ],
            ] );

            $this->add_responsive_control( 'feature_icon_size', [
                'label'      => __( 'Icon Size', 'htmega-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 8, 'max' => 80 ], 'em' => [ 'min' => 0.5, 'max' => 4 ] ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-about .htm25-about__feature-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .htm25-about .htm25-about__feature-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ] );

            $this->add_control( 'feature_icon_bg_color', [
                'label'     => __( 'Icon BG Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-about__feature-icon-wrap' => 'background-color: {{VALUE}};',
                ],
            ] );

            $this->add_control( 'feature_icon_bg_radius', [
                'label'      => __( 'Icon BG Border Radius', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-about__feature-icon-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            /* — Title — */
            $this->add_control( 'feature_title_heading', [
                'label'     => __( 'Title', 'htmega-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ] );

            $this->add_group_control( Group_Control_Typography::get_type(), [
                'name'     => 'feature_title_typography',
                'selector' => '{{WRAPPER}} .htm25-about__feature-title',
            ] );

            $this->add_control( 'feature_title_color', [
                'label'     => __( 'Title Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-about__feature-title' => 'color: {{VALUE}};',
                ],
            ] );

            /* — Description — */
            $this->add_control( 'feature_desc_heading', [
                'label'     => __( 'Description', 'htmega-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ] );

            $this->add_group_control( Group_Control_Typography::get_type(), [
                'name'     => 'feature_desc_typography',
                'selector' => '{{WRAPPER}} .htm25-about__feature-description',
            ] );

            $this->add_control( 'feature_desc_color', [
                'label'     => __( 'Description Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-about__feature-description' => 'color: {{VALUE}};',
                ],
            ] );

        $this->end_controls_section();

        /* ── CTA Button Style ── */
        $this->start_controls_section( 'style_cta', [
            'label'     => __( 'CTA Button', 'htmega-addons' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_cta' => 'yes' ],
        ] );

            $this->add_group_control( Group_Control_Typography::get_type(), [
                'name'     => 'cta_typography',
                'selector' => '{{WRAPPER}} .htm25-about__cta',
            ] );

            $this->add_group_control( Group_Control_Background::get_type(), [
                'name'     => 'cta_bg',
                'label'    => __( 'Background', 'htmega-addons' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .htm25-about__cta',
            ] );

            $this->add_control( 'cta_color', [
                'label'     => __( 'Text Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-about__cta' => 'color: {{VALUE}};',
                ],
            ] );

            $this->add_group_control( Group_Control_Border::get_type(), [
                'name'     => 'cta_border',
                'selector' => '{{WRAPPER}} .htm25-about__cta',
            ] );

            $this->add_responsive_control( 'cta_border_radius', [
                'label'      => __( 'Border Radius', 'htmega-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-about__cta' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ] );

            $this->add_control( 'cta_hover_heading', [
                'label'     => __( 'Hover', 'htmega-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ] );

            $this->add_group_control( Group_Control_Background::get_type(), [
                'name'     => 'cta_bg_hover',
                'label'    => __( 'Hover Background', 'htmega-addons' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .htm25-about__cta:hover',
            ] );

            $this->add_control( 'cta_color_hover', [
                'label'     => __( 'Hover Text Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-about__cta:hover' => 'color: {{VALUE}};',
                ],
            ] );

            $this->add_group_control( Group_Control_Border::get_type(), [
                'name'     => 'cta_border_hover',
                'label'    => __( 'Hover Border', 'htmega-addons' ),
                'selector' => '{{WRAPPER}} .htm25-about__cta:hover',
            ] );

        $this->end_controls_section();

        /* ── Image / Media ── */
        $this->start_controls_section( 'style_media', [
            'label'     => __( 'Image / Media', 'htmega-addons' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'layout!' => [ 'centered', 'feature-grid' ] ],
        ] );

            $this->add_control( 'about_image_radius', [
                'label'      => __( 'Border Radius', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-about__img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
                'name'     => 'about_image_shadow',
                'selector' => '{{WRAPPER}} .htm25-about__img',
            ] );

        $this->end_controls_section();

        /* ── Floating Badge ── */
        $this->start_controls_section( 'style_floating_badge', [
            'label'     => __( 'Floating Badge', 'htmega-addons' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_floating_badge' => 'yes',
                'layout!'             => [ 'centered', 'feature-grid' ],
            ],
        ] );

            $this->add_control( 'badge_bg', [
                'label'     => __( 'Background', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-about__float-badge' => 'background-color: {{VALUE}};',
                ],
            ] );

            $this->add_group_control( Group_Control_Typography::get_type(), [
                'name'     => 'badge_number_typography',
                'label'    => __( 'Number Typography', 'htmega-addons' ),
                'selector' => '{{WRAPPER}} .htm25-about__float-number',
            ] );

            $this->add_control( 'badge_number_color', [
                'label'     => __( 'Number Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-about__float-number' => 'color: {{VALUE}};',
                ],
            ] );

            $this->add_group_control( Group_Control_Typography::get_type(), [
                'name'     => 'badge_label_typography',
                'label'    => __( 'Label Typography', 'htmega-addons' ),
                'selector' => '{{WRAPPER}} .htm25-about__float-label',
            ] );

            $this->add_control( 'badge_label_color', [
                'label'     => __( 'Label Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-about__float-label' => 'color: {{VALUE}};',
                ],
            ] );

            $this->add_control( 'badge_radius', [
                'label'      => __( 'Border Radius', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-about__float-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

        $this->end_controls_section();

    } // end register_controls()

    // ── Render ────────────────────────────────────────────────

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->render_about( $settings );
    }

    /**
     * Shared renderer — identical BEM HTML used by both Elementor
     * render() and the FSE block's index.php.
     *
     * @param array $settings  Elementor settings array (or block attributes array).
     */
    private function render_about( array $settings ) {

        // ── Helpers ──
        $style   = ! empty( $settings['design_style'] ) ? sanitize_html_class( $settings['design_style'] ) : 'bento';
        $layout  = ! empty( $settings['layout'] )       ? sanitize_html_class( $settings['layout'] )       : 'split-left';
        $cols    = ! empty( $settings['feature_columns'] ) ? (int) $settings['feature_columns'] : 2;
        $cols    = in_array( $cols, [ 1, 2, 3 ], true ) ? $cols : 2;

        $is_split = in_array( $layout, [ 'split-left', 'split-right' ], true );

        // ── Section label ──
        $show_label  = ! empty( $settings['show_section_label'] ) && $settings['show_section_label'] !== 'no';
        $label_text  = ! empty( $settings['section_label_text'] ) ? $settings['section_label_text'] : '';

        // ── Headline ──
        $headline  = ! empty( $settings['headline'] ) ? $settings['headline'] : '';
        $headline  = esc_html( $headline );
        $highlight = ! empty( $settings['headline_highlight'] ) ? trim( $settings['headline_highlight'] ) : '';
        if ( $highlight ) {
            $headline = str_replace(
                esc_html( $highlight ),
                '<span class="htm25-about__headline-accent">' . esc_html( $highlight ) . '</span>',
                $headline
            );
        }
        $headline_tag = isset( $settings['headline_tag'] ) && in_array( $settings['headline_tag'], [ 'h1', 'h2', 'h3' ] )
            ? $settings['headline_tag'] : 'h2';

        // ── Description ──
        $description = ! empty( $settings['description'] ) ? $settings['description'] : '';

        // ── Feature items ──
        $feature_items = ! empty( $settings['feature_items'] ) && is_array( $settings['feature_items'] )
            ? $settings['feature_items'] : [];

        // ── Media (split layouts) ──
        $about_image       = ! empty( $settings['about_image'] )       ? $settings['about_image']       : [];
        $about_image_size  = ! empty( $settings['about_image_size'] )  ? $settings['about_image_size']  : 'large';
        $show_float_badge  = ! empty( $settings['show_floating_badge'] ) && $settings['show_floating_badge'] !== 'no';
        $float_number      = ! empty( $settings['floating_stat_number'] ) ? $settings['floating_stat_number'] : '';
        $float_label       = ! empty( $settings['floating_stat_label'] )  ? $settings['floating_stat_label']  : '';

        $image_html = '';
        if ( $is_split ) {
            $image_id  = ! empty( $about_image['id'] ) ? (int) $about_image['id'] : 0;
            $image_url = ! empty( $about_image['url'] ) ? $about_image['url'] : '';
            if ( $image_id ) {
                $image_html = wp_get_attachment_image( $image_id, $about_image_size, false, [ 'loading' => 'lazy', 'class' => 'htm25-about__img' ] );
            } elseif ( $image_url ) {
                $image_html = '<img src="' . esc_url( $image_url ) . '" alt="" class="htm25-about__img" loading="lazy">';
            }
        }

        // ── CTA ──
        $show_cta = ! empty( $settings['show_cta'] ) && $settings['show_cta'] !== 'no';
        $cta_text = ! empty( $settings['cta_text'] ) ? $settings['cta_text'] : '';
        $cta_url  = ! empty( $settings['cta_url']['url'] ) ? $settings['cta_url']['url'] : '#';
        $cta_target = ! empty( $settings['cta_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        // Note: access $settings['cta_icon'] directly in the template (not via intermediate var)
        // to avoid array-copy edge cases — see Hero widget pattern.

        ?>
        <section
            class="htm25-about htm25-style--<?php echo $style; ?> htm25-about--<?php echo $layout; ?>"
            aria-label="<?php esc_attr_e( 'About section', 'htmega-addons' ); ?>"
        >
            <?php if ( $style === 'aurora' || $style === 'glass' ) : ?>
            <div class="htm25-about__bg-blobs" aria-hidden="true">
                <div class="htm25-about__blob htm25-about__blob--1"></div>
                <div class="htm25-about__blob htm25-about__blob--2"></div>
            </div>
            <?php endif; ?>


            <div class="htm25-about__inner">

                <?php if ( $layout === 'split-right' && $is_split ) : ?>
                <?php $this->render_media_column( $image_html, $show_float_badge, $float_number, $float_label ); ?>
                <?php endif; ?>

                <div class="htm25-about__content">

                    <?php if ( $show_label && $label_text ) : ?>
                    <p class="htm25-about__section-label htm25-section-label">
                        <?php echo esc_html( $label_text ); ?>
                    </p>
                    <?php endif; ?>

                    <<?php echo $headline_tag; ?> class="htm25-about__headline"><?php echo $headline; // nl2br + esc_html + safe accent span ?></<?php echo $headline_tag; ?>>

                    <?php if ( $description ) : ?>
                    <p class="htm25-about__description">
                        <?php echo wp_kses_post( $description ); ?>
                    </p>
                    <?php endif; ?>

                    <?php if ( $feature_items ) : ?>
                    <ul
                        class="htm25-about__features htm25-about__features--cols-<?php echo $cols; ?>"
                        role="list"
                        aria-label="<?php esc_attr_e( 'Feature list', 'htmega-addons' ); ?>"
                    >
                        <?php foreach ( $feature_items as $item ) : ?>
                        <li class="htm25-about__feature htm25-card">
                            <?php $this->render_feature_item( $item ); ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>

                    <?php if ( $show_cta && $cta_text ) : ?>
                    <div class="htm25-about__cta-wrap">
                        <a
                            href="<?php echo esc_url( $cta_url ); ?>"
                            class="htm25-btn htm25-btn--primary htm25-about__cta"
                            <?php echo $cta_target; // phpcs:ignore — already sanitized ?>
                        >
                            <?php echo esc_html( $cta_text ); ?>
                            <?php if ( ! empty( $settings['cta_icon']['value'] ) ) : ?>
                            <span class="htm25-about__cta-icon" aria-hidden="true">
                                <?php Icons_Manager::render_icon( $settings['cta_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            </span>
                            <?php endif; ?>
                        </a>
                    </div>
                    <?php endif; ?>

                </div><!-- /.htm25-about__content -->

                <?php if ( $layout === 'split-left' && $is_split ) : ?>
                <?php $this->render_media_column( $image_html, $show_float_badge, $float_number, $float_label ); ?>
                <?php endif; ?>

            </div><!-- /.htm25-about__inner -->

        </section>
        <?php
    }

    /**
     * Render a single feature list item.
     */
    private function render_feature_item( array $item ) {
        $title       = ! empty( $item['feature_title'] )       ? $item['feature_title']       : '';
        $description = ! empty( $item['feature_description'] ) ? $item['feature_description'] : '';
        ?>
        <?php if ( ! empty( $item['feature_icon']['value'] ) ) : ?>
        <div class="htm25-about__feature-icon-wrap" aria-hidden="true">
            <span class="htm25-about__feature-icon">
                <?php Icons_Manager::render_icon( $item['feature_icon'], [ 'aria-hidden' => 'true' ] ); ?>
            </span>
        </div>
        <?php endif; ?>
        <?php if ( $title ) : ?>
        <h3 class="htm25-about__feature-title"><?php echo esc_html( $title ); ?></h3>
        <?php endif; ?>
        <?php if ( $description ) : ?>
        <p class="htm25-about__feature-description"><?php echo wp_kses_post( $description ); ?></p>
        <?php endif; ?>
        <?php
    }

    /**
     * Render the image / media column (shared between split-left and split-right).
     * When $image_html is empty a styled placeholder is shown instead.
     */
    private function render_media_column( string $image_html, bool $show_float, string $float_number, string $float_label ) {
        ?>
        <div class="htm25-about__media">
            <?php if ( $image_html ) : ?>
            <?php echo $image_html; // phpcs:ignore WordPress.Security.EscapeOutput — already escaped ?>
            <?php else : ?>
            <div class="htm25-about__img-placeholder" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                    <circle cx="12" cy="13" r="4"/>
                </svg>
                <span><?php esc_html_e( 'Add an image', 'htmega-addons' ); ?></span>
            </div>
            <?php endif; ?>
            <?php if ( $show_float && ( $float_number || $float_label ) ) : ?>
            <div
                class="htm25-about__float-badge"
                aria-label="<?php echo esc_attr( $float_number . ' ' . $float_label ); ?>"
            >
                <span class="htm25-about__float-number"><?php echo esc_html( $float_number ); ?></span>
                <span class="htm25-about__float-label"><?php echo esc_html( $float_label ); ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php
    }

} // end class HTMega_Elementor_Widget_About_2025
