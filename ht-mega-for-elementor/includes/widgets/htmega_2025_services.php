<?php
/**
 * HT Mega 2026 — Services Widget
 * Widget name: htmega-2026-services
 *
 * Part of the HT Mega 2026 Collection.
 * Shares BEM HTML with htmega-blocks/src/blocks/services-2025/index.php.
 * All styles live in assets/css/widgets/htm25-services.css.
 * All CSS values reference tokens from assets/css/htm25-tokens.css.
 *
 * PHP namespace: \Elementor   (required for Elementor auto-discovery)
 * Class: HTMega_Elementor_Widget_Services_2025
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class HTMega_Elementor_Widget_Services_2025 extends Widget_Base {

    // ── Identity ──────────────────────────────────────────────

    public function get_name()        { return 'htmega-2026-services'; }
    public function get_title()       { return __( 'Services 2026', 'htmega-addons' ); }
    public function get_icon()        { return 'htmega-icon eicon-tools'; }
    public function get_categories()  { return [ 'htmega-2026' ]; }
    public function get_keywords()    { return [ 'services', 'cards', 'features', 'htmega', '2026', 'grid', 'list' ]; }

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
                'default' => 'grid',
                'options' => [
                    'grid'     => __( 'Card Grid',         'htmega-addons' ),
                    'list'     => __( 'Icon-Left List',    'htmega-addons' ),
                    'centered' => __( 'Centered / Stacked','htmega-addons' ),
                ],
            ] );

            $this->add_control( 'service_columns', [
                'label'     => __( 'Grid Columns', 'htmega-addons' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '3',
                'options'   => [
                    '2' => __( '2 Columns', 'htmega-addons' ),
                    '3' => __( '3 Columns', 'htmega-addons' ),
                    '4' => __( '4 Columns', 'htmega-addons' ),
                ],
                'condition' => [ 'layout' => 'grid' ],
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
                'default'   => __( 'What We Offer', 'htmega-addons' ),
                'condition' => [ 'show_section_label' => 'yes' ],
            ] );

            $this->add_control( 'headline', [
                'label'   => __( 'Headline', 'htmega-addons' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __( "Services built for\nmodern teams.", 'htmega-addons' ),
                'rows'    => 3,
            ] );

            $this->add_control( 'headline_highlight', [
                'label'       => __( 'Highlighted Word(s)', 'htmega-addons' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'modern teams', 'htmega-addons' ),
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
                'default' => __( 'Everything your team needs to design, build, and ship faster than ever before.', 'htmega-addons' ),
                'rows'    => 4,
            ] );

        $this->end_controls_section();

        /* ── Service Items ── */
        $this->start_controls_section( 'section_services', [
            'label' => __( 'Service Items', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

            $repeater = new Repeater();

            $repeater->add_control( 'service_icon', [
                'label'   => __( 'Icon', 'htmega-addons' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ] );

            $repeater->add_control( 'service_title', [
                'label'   => __( 'Title', 'htmega-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Service Name', 'htmega-addons' ),
            ] );

            $repeater->add_control( 'service_description', [
                'label'   => __( 'Description', 'htmega-addons' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __( 'A short description of this service and the value it delivers to your clients.', 'htmega-addons' ),
                'rows'    => 4,
            ] );

            $repeater->add_control( 'show_service_link', [
                'label'        => __( 'Show Link', 'htmega-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'htmega-addons' ),
                'label_off'    => __( 'Hide', 'htmega-addons' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ] );

            $repeater->add_control( 'service_link_text', [
                'label'     => __( 'Link Text', 'htmega-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Learn more', 'htmega-addons' ),
                'condition' => [ 'show_service_link' => 'yes' ],
            ] );

            $repeater->add_control( 'service_link_url', [
                'label'     => __( 'Link URL', 'htmega-addons' ),
                'type'      => Controls_Manager::URL,
                'default'   => [ 'url' => '#' ],
                'condition' => [ 'show_service_link' => 'yes' ],
            ] );

            $this->add_control( 'service_items', [
                'label'       => __( 'Services', 'htmega-addons' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'service_icon'        => [ 'value' => 'fas fa-bolt',             'library' => 'fa-solid' ],
                        'service_title'       => __( 'Speed Optimisation',   'htmega-addons' ),
                        'service_description' => __( 'Sub-second load times out of the box. We fine-tune Core Web Vitals so your users never wait.',  'htmega-addons' ),
                        'show_service_link'   => 'no',
                    ],
                    [
                        'service_icon'        => [ 'value' => 'fas fa-shield-alt',       'library' => 'fa-solid' ],
                        'service_title'       => __( 'Security Hardening',   'htmega-addons' ),
                        'service_description' => __( 'Proactive vulnerability scanning, nonce protection, and sanitised outputs on every request.',     'htmega-addons' ),
                        'show_service_link'   => 'no',
                    ],
                    [
                        'service_icon'        => [ 'value' => 'fas fa-palette',          'library' => 'fa-solid' ],
                        'service_title'       => __( 'Design Systems',       'htmega-addons' ),
                        'service_description' => __( 'Token-driven component libraries that keep your brand consistent across every surface.',          'htmega-addons' ),
                        'show_service_link'   => 'no',
                    ],
                    [
                        'service_icon'        => [ 'value' => 'fas fa-universal-access', 'library' => 'fa-solid' ],
                        'service_title'       => __( 'Accessibility Audits', 'htmega-addons' ),
                        'service_description' => __( 'WCAG 2.1 AA compliance reviews with actionable fixes delivered in plain English.',               'htmega-addons' ),
                        'show_service_link'   => 'no',
                    ],
                    [
                        'service_icon'        => [ 'value' => 'fas fa-chart-line',       'library' => 'fa-solid' ],
                        'service_title'       => __( 'Analytics Setup',      'htmega-addons' ),
                        'service_description' => __( 'GA4, GTM, and conversion tracking configured correctly from day one — no data gaps.',            'htmega-addons' ),
                        'show_service_link'   => 'no',
                    ],
                    [
                        'service_icon'        => [ 'value' => 'fas fa-headset',          'library' => 'fa-solid' ],
                        'service_title'       => __( 'Ongoing Support',      'htmega-addons' ),
                        'service_description' => __( 'Dedicated account managers and priority response SLAs so you\'re never left waiting.',           'htmega-addons' ),
                        'show_service_link'   => 'no',
                    ],
                ],
                'title_field' => '{{{ service_title }}}',
            ] );

        $this->end_controls_section();

        /* ── Bottom CTA ── */
        $this->start_controls_section( 'section_cta', [
            'label' => __( 'Bottom CTA', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

            $this->add_control( 'show_cta', [
                'label'        => __( 'Show CTA Button', 'htmega-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'htmega-addons' ),
                'label_off'    => __( 'Hide', 'htmega-addons' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ] );

            $this->add_control( 'cta_text', [
                'label'     => __( 'Button Text', 'htmega-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'View All Services', 'htmega-addons' ),
                'condition' => [ 'show_cta' => 'yes' ],
            ] );

            $this->add_control( 'cta_url', [
                'label'     => __( 'Button URL', 'htmega-addons' ),
                'type'      => Controls_Manager::URL,
                'default'   => [ 'url' => '#' ],
                'condition' => [ 'show_cta' => 'yes' ],
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

        /* ── 1. Section ── */
        $this->start_controls_section( 'style_section', [
            'label' => __( 'Section', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

            $this->add_responsive_control( 'section_padding', [
                'label'      => __( 'Padding', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-services' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name'     => 'section_bg',
                    'label'    => __( 'Background', 'htmega-addons' ),
                    'types'    => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htm25-services',
                ]
            );

        $this->end_controls_section();

        /* ── 2. Section Label ── */
        $this->start_controls_section( 'style_section_label', [
            'label'     => __( 'Section Label', 'htmega-addons' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_section_label' => 'yes' ],
        ] );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'section_label_typography',
                    'selector' => '{{WRAPPER}} .htm25-services__section-label',
                ]
            );

            $this->add_control( 'section_label_color', [
                'label'     => __( 'Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .htm25-services__section-label' => 'color: {{VALUE}};' ],
            ] );

            $this->add_control( 'section_label_bg_color', [
                'label'     => __( 'Background Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .htm25-services__section-label' => 'background-color: {{VALUE}};' ],
            ] );

            $this->add_responsive_control( 'section_label_border_radius', [
                'label'      => __( 'Border Radius', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-services__section-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_responsive_control( 'section_label_padding', [
                'label'      => __( 'Padding', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-services__section-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

        $this->end_controls_section();

        /* ── 3. Headline ── */
        $this->start_controls_section( 'style_headline', [
            'label' => __( 'Headline', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'headline_typography',
                    'selector' => '{{WRAPPER}} .htm25-services__headline',
                ]
            );

            $this->add_control( 'headline_color', [
                'label'     => __( 'Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .htm25-services__headline' => 'color: {{VALUE}};' ],
            ] );

            $this->add_responsive_control( 'headline_margin', [
                'label'      => __( 'Margin', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-services__headline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

        $this->end_controls_section();

        /* ── 4. Headline Accent ── */
        $this->start_controls_section( 'style_headline_accent', [
            'label' => __( 'Headline Accent', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

            $this->add_control( 'headline_accent_color', [
                'label'     => __( 'Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-services__headline-accent' => 'background-color: {{VALUE}}; background-image: none;',
                ],
            ] );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name'           => 'headline_accent_gradient',
                    'label'          => __( 'Gradient', 'htmega-addons' ),
                    'types'          => [ 'gradient' ],
                    'selector'       => '{{WRAPPER}} .htm25-services__headline-accent',
                    'fields_options' => [
                        'background' => [
                            'label' => __( 'Gradient Color', 'htmega-addons' ),
                        ],
                    ],
                ]
            );

        $this->end_controls_section();

        /* ── 5. Description ── */
        $this->start_controls_section( 'style_description', [
            'label' => __( 'Description', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'description_typography',
                    'selector' => '{{WRAPPER}} .htm25-services__description',
                ]
            );

            $this->add_control( 'description_color', [
                'label'     => __( 'Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .htm25-services__description' => 'color: {{VALUE}};' ],
            ] );

        $this->end_controls_section();

        /* ── 6. Service Card ── */
        $this->start_controls_section( 'style_card', [
            'label' => __( 'Service Card', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

            /* — Card box — */
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name'     => 'card_bg',
                    'label'    => __( 'Background', 'htmega-addons' ),
                    'types'    => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htm25-services__card',
                ]
            );

            $this->add_responsive_control( 'card_border_radius', [
                'label'      => __( 'Border Radius', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-services__card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'     => 'card_box_shadow',
                    'selector' => '{{WRAPPER}} .htm25-services__card',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'     => 'card_border',
                    'selector' => '{{WRAPPER}} .htm25-services__card',
                ]
            );

            /* — Card icon — */
            $this->add_control( 'card_icon_heading', [
                'label'     => __( 'Card Icon', 'htmega-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ] );

            $this->add_responsive_control( 'card_icon_size', [
                'label'      => __( 'Icon Size', 'htmega-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 10, 'max' => 80 ], 'em' => [ 'min' => 0.5, 'max' => 5 ] ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-services .htm25-services__card-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .htm25-services .htm25-services__card-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ] );

            $this->add_control( 'card_icon_color', [
                'label'     => __( 'Icon Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-services .htm25-services__card-icon i'        => 'color: {{VALUE}};',
                    '{{WRAPPER}} .htm25-services .htm25-services__card-icon svg'      => 'color: {{VALUE}};',
                    '{{WRAPPER}} .htm25-services .htm25-services__card-icon svg path' => 'fill: {{VALUE}};',
                ],
            ] );

            $this->add_control( 'card_icon_bg_color', [
                'label'     => __( 'Icon BG Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .htm25-services__card-icon-wrap' => 'background-color: {{VALUE}};' ],
            ] );

            $this->add_responsive_control( 'card_icon_bg_border_radius', [
                'label'      => __( 'Icon BG Border Radius', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-services__card-icon-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            /* — Card title — */
            $this->add_control( 'card_title_heading', [
                'label'     => __( 'Card Title', 'htmega-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ] );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'card_title_typography',
                    'selector' => '{{WRAPPER}} .htm25-services__card-title',
                ]
            );

            $this->add_control( 'card_title_color', [
                'label'     => __( 'Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .htm25-services__card-title' => 'color: {{VALUE}};' ],
            ] );

            $this->add_responsive_control( 'card_title_margin', [
                'label'      => __( 'Margin', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-services__card-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            /* — Card description — */
            $this->add_control( 'card_desc_heading', [
                'label'     => __( 'Card Description', 'htmega-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ] );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'card_desc_typography',
                    'selector' => '{{WRAPPER}} .htm25-services__card-description',
                ]
            );

            $this->add_control( 'card_desc_color', [
                'label'     => __( 'Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .htm25-services__card-description' => 'color: {{VALUE}};' ],
            ] );

            /* — Card link — */
            $this->add_control( 'card_link_heading', [
                'label'     => __( 'Card Link', 'htmega-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ] );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'card_link_typography',
                    'selector' => '{{WRAPPER}} .htm25-services__card-link',
                ]
            );

            $this->add_control( 'card_link_color', [
                'label'     => __( 'Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .htm25-services__card-link' => 'color: {{VALUE}};' ],
            ] );

            $this->add_control( 'card_link_hover_color', [
                'label'     => __( 'Hover Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .htm25-services__card-link:hover' => 'color: {{VALUE}};' ],
            ] );

        $this->end_controls_section();

        /* ── 7. CTA Button ── */
        $this->start_controls_section( 'style_cta', [
            'label'     => __( 'CTA Button', 'htmega-addons' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_cta' => 'yes' ],
        ] );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'cta_typography',
                    'selector' => '{{WRAPPER}} .htm25-services__cta',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name'     => 'cta_bg',
                    'label'    => __( 'Background', 'htmega-addons' ),
                    'types'    => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htm25-services__cta',
                ]
            );

            $this->add_control( 'cta_text_color', [
                'label'     => __( 'Text Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .htm25-services__cta' => 'color: {{VALUE}};' ],
            ] );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'     => 'cta_border',
                    'selector' => '{{WRAPPER}} .htm25-services__cta',
                ]
            );

            $this->add_responsive_control( 'cta_border_radius', [
                'label'      => __( 'Border Radius', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-services__cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_responsive_control( 'cta_padding', [
                'label'      => __( 'Padding', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-services__cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_control( 'cta_hover_heading', [
                'type'      => Controls_Manager::RAW_HTML,
                'raw'       => __( '<strong>Hover State</strong>', 'htmega-addons' ),
                'separator' => 'before',
            ] );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name'     => 'cta_hover_bg',
                    'label'    => __( 'Hover Background', 'htmega-addons' ),
                    'types'    => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htm25-services__cta:hover',
                ]
            );

            $this->add_control( 'cta_hover_text_color', [
                'label'     => __( 'Hover Text Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .htm25-services__cta:hover' => 'color: {{VALUE}};' ],
            ] );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'     => 'cta_hover_border',
                    'label'    => __( 'Hover Border', 'htmega-addons' ),
                    'selector' => '{{WRAPPER}} .htm25-services__cta:hover',
                ]
            );

        $this->end_controls_section();
    }

    // ── Render ────────────────────────────────────────────────

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->render_services( $settings );
    }

    /**
     * Shared renderer — identical BEM HTML used by both Elementor render()
     * and the FSE block's index.php.
     *
     * @param array $settings  Elementor settings array (or block attributes).
     */
    private function render_services( array $settings ) {

        // ── Helpers ──────────────────────────────────────────

        $style   = ! empty( $settings['design_style'] ) ? sanitize_html_class( $settings['design_style'] ) : 'bento';
        $layout  = ! empty( $settings['layout'] )       ? sanitize_html_class( $settings['layout'] )       : 'grid';
        $cols    = ! empty( $settings['service_columns'] ) ? (int) $settings['service_columns'] : 3;
        $cols    = in_array( $cols, [ 2, 3, 4 ], true ) ? $cols : 3;

        // ── Section label ──
        $show_label = ! empty( $settings['show_section_label'] ) && $settings['show_section_label'] !== 'no';
        $label_text = ! empty( $settings['section_label_text'] ) ? $settings['section_label_text'] : '';

        // ── Headline ──
        $headline  = ! empty( $settings['headline'] ) ? $settings['headline'] : '';
        $headline  = esc_html( $headline );
        $highlight = ! empty( $settings['headline_highlight'] ) ? trim( $settings['headline_highlight'] ) : '';
        if ( $highlight ) {
            $headline = str_replace(
                esc_html( $highlight ),
                '<span class="htm25-services__headline-accent">' . esc_html( $highlight ) . '</span>',
                $headline
            );
        }
        $headline_tag = isset( $settings['headline_tag'] ) && in_array( $settings['headline_tag'], [ 'h1', 'h2', 'h3' ] )
            ? $settings['headline_tag'] : 'h2';

        // ── Description ──
        $description = ! empty( $settings['description'] ) ? $settings['description'] : '';

        // ── Service items ──
        $service_items = ! empty( $settings['service_items'] ) && is_array( $settings['service_items'] )
            ? $settings['service_items'] : [];

        // ── CTA ──
        $show_cta   = ! empty( $settings['show_cta'] ) && $settings['show_cta'] !== 'no';
        $cta_text   = ! empty( $settings['cta_text'] ) ? $settings['cta_text'] : '';
        $cta_url    = ! empty( $settings['cta_url']['url'] ) ? $settings['cta_url']['url'] : '#';
        $cta_target = ! empty( $settings['cta_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';

        ?>
        <section
            class="htm25-services htm25-style--<?php echo $style; ?> htm25-services--<?php echo $layout; ?>"
            aria-label="<?php esc_attr_e( 'Services section', 'htmega-addons' ); ?>"
        >
            <?php if ( $style === 'aurora' || $style === 'glass' ) : ?>
            <div class="htm25-services__bg-blobs" aria-hidden="true">
                <div class="htm25-services__blob htm25-services__blob--1"></div>
                <div class="htm25-services__blob htm25-services__blob--2"></div>
            </div>
            <?php endif; ?>


            <div class="htm25-services__inner">

                <?php if ( $show_label || $headline || $description ) : ?>
                <div class="htm25-services__header">

                    <?php if ( $show_label && $label_text ) : ?>
                    <p class="htm25-services__section-label htm25-section-label">
                        <?php echo esc_html( $label_text ); ?>
                    </p>
                    <?php endif; ?>

                    <?php if ( $headline ) : ?>
                    <<?php echo $headline_tag; ?> class="htm25-services__headline"><?php echo $headline; // nl2br + esc_html + safe accent span ?></<?php echo $headline_tag; ?>>
                    <?php endif; ?>

                    <?php if ( $description ) : ?>
                    <p class="htm25-services__description">
                        <?php echo wp_kses_post( $description ); ?>
                    </p>
                    <?php endif; ?>

                </div><!-- /.htm25-services__header -->
                <?php endif; ?>

                <?php if ( $service_items ) : ?>
                <ul
                    class="htm25-services__cards htm25-services__cards--cols-<?php echo $cols; ?>"
                    role="list"
                    aria-label="<?php esc_attr_e( 'Service list', 'htmega-addons' ); ?>"
                >
                    <?php foreach ( $service_items as $item ) :
                        $this->render_service_card( $item, $layout );
                    endforeach; ?>
                </ul>
                <?php endif; ?>

                <?php if ( $show_cta && $cta_text ) : ?>
                <div class="htm25-services__cta-wrap">
                    <a
                        href="<?php echo esc_url( $cta_url ); ?>"
                        class="htm25-btn htm25-btn--primary htm25-services__cta"
                        <?php echo $cta_target; // phpcs:ignore — already sanitized ?>
                    >
                        <?php echo esc_html( $cta_text ); ?>
                        <?php if ( ! empty( $settings['cta_icon']['value'] ) ) : ?>
                        <span class="htm25-services__cta-icon" aria-hidden="true">
                            <?php Icons_Manager::render_icon( $settings['cta_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </span>
                        <?php endif; ?>
                    </a>
                </div>
                <?php endif; ?>

            </div><!-- /.htm25-services__inner -->

        </section>
        <?php
    }

    /**
     * Render a single service card.
     *
     * @param array  $item    Repeater item (Elementor settings).
     * @param string $layout  'grid' | 'list' | 'centered'.
     */
    private function render_service_card( array $item, string $layout ) {
        $title       = ! empty( $item['service_title'] )       ? $item['service_title']       : '';
        $description = ! empty( $item['service_description'] ) ? $item['service_description'] : '';
        $show_link   = ! empty( $item['show_service_link'] ) && $item['show_service_link'] !== 'no';
        $link_text   = ! empty( $item['service_link_text'] )   ? $item['service_link_text']   : __( 'Learn more', 'htmega-addons' );
        $link_url    = ! empty( $item['service_link_url']['url'] ) ? $item['service_link_url']['url'] : '#';
        $link_target = ! empty( $item['service_link_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        ?>
        <li class="htm25-services__card htm25-card">

            <?php if ( ! empty( $item['service_icon']['value'] ) ) : ?>
            <div class="htm25-services__card-icon-wrap" aria-hidden="true">
                <span class="htm25-services__card-icon">
                    <?php Icons_Manager::render_icon( $item['service_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </span>
            </div>
            <?php endif; ?>

            <div class="htm25-services__card-body">

                <?php if ( $title ) : ?>
                <h3 class="htm25-services__card-title"><?php echo esc_html( $title ); ?></h3>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                <p class="htm25-services__card-description"><?php echo wp_kses_post( $description ); ?></p>
                <?php endif; ?>

                <?php if ( $show_link && $link_text ) : ?>
                <a
                    href="<?php echo esc_url( $link_url ); ?>"
                    class="htm25-services__card-link"
                    <?php echo $link_target; // phpcs:ignore — already sanitized ?>
                >
                    <?php echo esc_html( $link_text ); ?>
                    <span class="htm25-services__card-link-arrow" aria-hidden="true">→</span>
                </a>
                <?php endif; ?>

            </div><!-- /.htm25-services__card-body -->

        </li>
        <?php
    }

} // end class HTMega_Elementor_Widget_Services_2025
