<?php
/**
 * HT Mega 2026 — Hero Widget
 *
 * Widget name : htmega-2026-hero
 * Category    : htmega-2026
 * Prefix      : htm25-   (never conflicts with legacy htmega-)
 * HTML        : BEM structured, no jQuery, no Bootstrap grid
 * CSS         : references htm25-tokens.css custom properties
 *
 * Styles
 *   bento  — white cards, crisp grid, SaaS
 *   glass  — frosted glass, dark bg, fintech/crypto
 *   dark   — black surface, lime accent, dev-tools/AI
 *   aurora — gradient mesh, rounded, AI/tech brands
 *   neo    — hard border, flat color, offset shadow, agencies
 *
 * Layouts
 *   centered    — headline + sub centered, CTA row below
 *   split-left  — text left | media right (image/badge stack)
 *   split-right — media left | text right
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class HTMega_Elementor_Widget_Hero_2025 extends Widget_Base {

    /* -------------------------------------------------------
       Identity
    ------------------------------------------------------- */

    public function get_name() {
        return 'htmega-2026-hero';
    }

    public function get_title() {
        return __( 'Hero Section 2026', 'htmega-addons' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-banner';
    }

    public function get_keywords() {
        return [ 'hero', 'banner', 'header', 'headline', 'htmega', 'ht mega', '2026', 'modern' ];
    }

    public function get_categories() {
        return [ 'htmega-2026' ];
    }

    public function get_help_url() {
        return 'https://wphtmega.com/docs/';
    }

    public function get_style_depends() {
        return [ 'htm25-tokens', 'htm25-hero' ];
    }

    /* -------------------------------------------------------
       Controls
    ------------------------------------------------------- */

    protected function register_controls() {

        /* ── STYLE PRESET ──────────────────────────────────── */
        $this->start_controls_section(
            'section_preset',
            [
                'label' => __( 'Design Style', 'htmega-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

            $this->add_control(
                'design_style',
                [
                    'label'   => __( 'Style Preset', 'htmega-addons' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'bento',
                    'options' => [
                        'bento'  => __( 'Bento Grid',       'htmega-addons' ),
                        'glass'  => __( 'Glassmorphism',    'htmega-addons' ),
                        'dark'   => __( 'Dark Minimal',     'htmega-addons' ),
                        'aurora' => __( 'Aurora',           'htmega-addons' ),
                        'neo'    => __( 'Neo-Brutalist',    'htmega-addons' ),
                    ],
                ]
            );

            $this->add_control(
                'layout',
                [
                    'label'   => __( 'Layout', 'htmega-addons' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'centered',
                    'options' => [
                        'centered'    => __( 'Centered',     'htmega-addons' ),
                        'split-left'  => __( 'Split – Text Left',  'htmega-addons' ),
                        'split-right' => __( 'Split – Text Right', 'htmega-addons' ),
                    ],
                ]
            );

        $this->end_controls_section();

        /* ── BADGE ─────────────────────────────────────────── */
        $this->start_controls_section(
            'section_badge',
            [
                'label' => __( 'Eyebrow / Badge', 'htmega-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

            $this->add_control(
                'badge_show',
                [
                    'label'        => __( 'Show Badge', 'htmega-addons' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'label_on'     => __( 'Yes', 'htmega-addons' ),
                    'label_off'    => __( 'No',  'htmega-addons' ),
                    'return_value' => 'yes',
                    'default'      => 'yes',
                ]
            );

            $this->add_control(
                'badge_icon',
                [
                    'label'     => __( 'Badge Icon', 'htmega-addons' ),
                    'type'      => Controls_Manager::ICONS,
                    'default'   => [ 'library' => 'fa-solid', 'value' => 'fas fa-rocket' ],
                    'condition' => [ 'badge_show' => 'yes' ],
                ]
            );

            $this->add_control(
                'badge_text',
                [
                    'label'     => __( 'Badge Text', 'htmega-addons' ),
                    'type'      => Controls_Manager::TEXT,
                    'default'   => __( 'Now in Beta', 'htmega-addons' ),
                    'condition' => [ 'badge_show' => 'yes' ],
                ]
            );

        $this->end_controls_section();

        /* ── HEADLINE ───────────────────────────────────────── */
        $this->start_controls_section(
            'section_headline',
            [
                'label' => __( 'Headline', 'htmega-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

            $this->add_control(
                'headline',
                [
                    'label'       => __( 'Headline', 'htmega-addons' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __( "Build Faster.\nShip Smarter.", 'htmega-addons' ),
                    'label_block' => true,
                    'rows'        => 3,
                ]
            );

            $this->add_control(
                'headline_highlight',
                [
                    'label'       => __( 'Highlighted Word(s)', 'htmega-addons' ),
                    'type'        => Controls_Manager::TEXT,
                    'description' => __( 'These exact words in the headline will be styled with the accent gradient/color.', 'htmega-addons' ),
                    'default'     => 'Smarter',
                ]
            );

            $this->add_control(
                'headline_tag',
                [
                    'label'   => __( 'HTML Tag', 'htmega-addons' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'h1',
                    'options' => [
                        'h1' => 'H1',
                        'h2' => 'H2',
                        'h3' => 'H3',
                    ],
                ]
            );

        $this->end_controls_section();

        /* ── DESCRIPTION ────────────────────────────────────── */
        $this->start_controls_section(
            'section_description',
            [
                'label' => __( 'Description', 'htmega-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

            $this->add_control(
                'description',
                [
                    'label'       => __( 'Description', 'htmega-addons' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __( 'The all-in-one toolkit for teams who ship. Beautiful, accessible, and fast by default.', 'htmega-addons' ),
                    'rows'        => 4,
                    'label_block' => true,
                ]
            );

        $this->end_controls_section();

        /* ── CTA BUTTONS ────────────────────────────────────── */
        $this->start_controls_section(
            'section_cta',
            [
                'label' => __( 'CTA Buttons', 'htmega-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

            $this->add_control(
                'primary_btn_show',
                [
                    'label'        => __( 'Show Primary Button', 'htmega-addons' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default'      => 'yes',
                ]
            );

            $this->add_control(
                'primary_btn_text',
                [
                    'label'     => __( 'Primary Button Text', 'htmega-addons' ),
                    'type'      => Controls_Manager::TEXT,
                    'default'   => __( 'Get Started Free', 'htmega-addons' ),
                    'condition' => [ 'primary_btn_show' => 'yes' ],
                ]
            );

            $this->add_control(
                'primary_btn_url',
                [
                    'label'       => __( 'Primary Button URL', 'htmega-addons' ),
                    'type'        => Controls_Manager::URL,
                    'default'     => [ 'url' => '#' ],
                    'condition'   => [ 'primary_btn_show' => 'yes' ],
                ]
            );

            $this->add_control(
                'secondary_btn_show',
                [
                    'label'        => __( 'Show Secondary Button', 'htmega-addons' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default'      => 'yes',
                ]
            );

            $this->add_control(
                'secondary_btn_text',
                [
                    'label'     => __( 'Secondary Button Text', 'htmega-addons' ),
                    'type'      => Controls_Manager::TEXT,
                    'default'   => __( 'View Demo', 'htmega-addons' ),
                    'condition' => [ 'secondary_btn_show' => 'yes' ],
                ]
            );

            $this->add_control(
                'secondary_btn_url',
                [
                    'label'     => __( 'Secondary Button URL', 'htmega-addons' ),
                    'type'      => Controls_Manager::URL,
                    'default'   => [ 'url' => '#' ],
                    'condition' => [ 'secondary_btn_show' => 'yes' ],
                ]
            );

            $this->add_control(
                'secondary_btn_icon',
                [
                    'label'     => __( 'Secondary Button Icon', 'htmega-addons' ),
                    'type'      => Controls_Manager::ICONS,
                    'default'   => [ 'library' => 'fa-solid', 'value' => 'fas fa-play' ],
                    'condition' => [ 'secondary_btn_show' => 'yes' ],
                ]
            );

        $this->end_controls_section();

        /* ── SOCIAL PROOF ───────────────────────────────────── */
        $this->start_controls_section(
            'section_social_proof',
            [
                'label' => __( 'Social Proof', 'htmega-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

            $this->add_control(
                'social_proof_show',
                [
                    'label'        => __( 'Show Social Proof', 'htmega-addons' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default'      => 'yes',
                ]
            );

            $this->add_control(
                'social_proof_text',
                [
                    'label'     => __( 'Social Proof Text', 'htmega-addons' ),
                    'type'      => Controls_Manager::TEXT,
                    'default'   => __( 'Trusted by 50,000+ builders worldwide', 'htmega-addons' ),
                    'condition' => [ 'social_proof_show' => 'yes' ],
                ]
            );

            $this->add_control(
                'social_proof_rating',
                [
                    'label'     => __( 'Rating Text', 'htmega-addons' ),
                    'type'      => Controls_Manager::TEXT,
                    'default'   => __( '4.9 / 5.0', 'htmega-addons' ),
                    'condition' => [ 'social_proof_show' => 'yes' ],
                ]
            );

        $this->end_controls_section();

        /* ── MEDIA (split layouts) ──────────────────────────── */
        $this->start_controls_section(
            'section_media',
            [
                'label'     => __( 'Hero Media', 'htmega-addons' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [ 'layout!' => 'centered' ],
            ]
        );

            $this->add_control(
                'hero_image',
                [
                    'label'   => __( 'Hero Image', 'htmega-addons' ),
                    'type'    => Controls_Manager::MEDIA,
                    'default' => [ 'url' => Utils::get_placeholder_image_src() ],
                ]
            );

            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name'    => 'hero_image',
                    'default' => 'full',
                ]
            );

            $this->add_control(
                'floating_badge_show',
                [
                    'label'        => __( 'Show Floating Stat Badge', 'htmega-addons' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default'      => 'yes',
                ]
            );

            $this->add_control(
                'floating_stat_number',
                [
                    'label'     => __( 'Stat Number', 'htmega-addons' ),
                    'type'      => Controls_Manager::TEXT,
                    'default'   => '50K+',
                    'condition' => [ 'floating_badge_show' => 'yes' ],
                ]
            );

            $this->add_control(
                'floating_stat_label',
                [
                    'label'     => __( 'Stat Label', 'htmega-addons' ),
                    'type'      => Controls_Manager::TEXT,
                    'default'   => __( 'Happy Users', 'htmega-addons' ),
                    'condition' => [ 'floating_badge_show' => 'yes' ],
                ]
            );

        $this->end_controls_section();

        /* ── STYLE: SECTION ─────────────────────────────────── */
        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Section', 'htmega-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
                'section_padding',
                [
                    'label'      => __( 'Section Padding', 'htmega-addons' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', 'rem', '%' ],
                    'selectors'  => [
                        '{{WRAPPER}} .htm25-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name'     => 'section_background',
                    'label'    => __( 'Background', 'htmega-addons' ),
                    'types'    => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htm25-hero',
                ]
            );

        $this->end_controls_section();

        /* ── STYLE: HEADLINE ────────────────────────────────── */
        $this->start_controls_section(
            'style_headline',
            [
                'label' => __( 'Headline', 'htmega-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'headline_typography',
                    'selector' => '{{WRAPPER}} .htm25-hero__headline',
                ]
            );

            $this->add_control(
                'headline_color',
                [
                    'label'     => __( 'Color', 'htmega-addons' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htm25-hero__headline' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'headline_margin',
                [
                    'label'      => __( 'Margin', 'htmega-addons' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', 'rem' ],
                    'selectors'  => [
                        '{{WRAPPER}} .htm25-hero__headline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'headline_highlight_heading',
                [
                    'label'     => __( 'Highlight Word', 'htmega-addons' ),
                    'type'      => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'headline_highlight_color',
                [
                    'label'     => __( 'Highlight Color', 'htmega-addons' ),
                    'type'      => Controls_Manager::COLOR,
                    'separator' => 'after',
                    'selectors' => [
                        '{{WRAPPER}} .htm25-hero__headline-accent' => 'background-color: {{VALUE}}; background-image: none;',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name'           => 'headline_highlight_gradient',
                    'types'          => [ 'gradient' ],
                    'selector'       => '{{WRAPPER}} .htm25-hero__headline-accent',
                    'fields_options' => [
                        'background' => [
                            'label' => __( 'Gradient Color', 'htmega-addons' ),
                        ],
                    ],
                ]
            );

        $this->end_controls_section();

        /* ── STYLE: BUTTONS ─────────────────────────────────── */
        $this->start_controls_section(
            'style_buttons',
            [
                'label' => __( 'Buttons', 'htmega-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'btn_gap',
                [
                    'label'      => __( 'Gap Between Buttons', 'htmega-addons' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', 'rem' ],
                    'range'      => [ 'px' => [ 'min' => 0, 'max' => 48 ] ],
                    'default'    => [ 'unit' => 'rem', 'size' => 0.75 ],
                    'selectors'  => [
                        '{{WRAPPER}} .htm25-hero__actions' => 'gap: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->start_controls_tabs( 'btn_tabs' );

                /* Primary */
                $this->start_controls_tab( 'btn_primary_tab', [ 'label' => __( 'Primary', 'htmega-addons' ) ] );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name'     => 'primary_btn_typography',
                            'selector' => '{{WRAPPER}} .htm25-btn--primary',
                        ]
                    );

                    $this->add_control(
                        'primary_btn_bg_solid_color',
                        [
                            'label'     => __( 'Background Color', 'htmega-addons' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htm25-btn--primary' => 'background-color: {{VALUE}}; background-image: none;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name'           => 'primary_btn_bg',
                            'types'          => [ 'gradient' ],
                            'selector'       => '{{WRAPPER}} .htm25-btn--primary',
                            'fields_options' => [
                                'background' => [ 'label' => __( 'Background Gradient', 'htmega-addons' ) ],
                            ],
                        ]
                    );

                    $this->add_control(
                        'primary_btn_color',
                        [
                            'label'     => __( 'Text Color', 'htmega-addons' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htm25-btn--primary' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name'     => 'primary_btn_border',
                            'selector' => '{{WRAPPER}} .htm25-btn--primary',
                        ]
                    );

                    $this->add_control(
                        'primary_btn_radius',
                        [
                            'label'      => __( 'Border Radius', 'htmega-addons' ),
                            'type'       => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors'  => [
                                '{{WRAPPER}} .htm25-btn--primary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'primary_btn_padding',
                        [
                            'label'      => __( 'Padding', 'htmega-addons' ),
                            'type'       => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors'  => [
                                '{{WRAPPER}} .htm25-btn--primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'primary_btn_bg_hover',
                        [
                            'label'     => __( 'Hover Background', 'htmega-addons' ),
                            'type'      => Controls_Manager::COLOR,
                            'separator' => 'before',
                            'selectors' => [
                                '{{WRAPPER}} .htm25-btn--primary:hover' => 'background: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'primary_btn_color_hover',
                        [
                            'label'     => __( 'Hover Text Color', 'htmega-addons' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htm25-btn--primary:hover' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name'     => 'primary_btn_border_hover',
                            'label'    => __( 'Hover Border', 'htmega-addons' ),
                            'selector' => '{{WRAPPER}} .htm25-btn--primary:hover',
                        ]
                    );

                $this->end_controls_tab();

                /* Secondary */
                $this->start_controls_tab( 'btn_secondary_tab', [ 'label' => __( 'Secondary', 'htmega-addons' ) ] );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name'     => 'secondary_btn_typography',
                            'selector' => '{{WRAPPER}} .htm25-btn--outline',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name'     => 'secondary_btn_bg',
                            'label'    => __( 'Background', 'htmega-addons' ),
                            'types'    => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htm25-btn--outline',
                        ]
                    );

                    $this->add_control(
                        'secondary_btn_color',
                        [
                            'label'     => __( 'Text Color', 'htmega-addons' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htm25-btn--outline' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'play_icon_bg_heading',
                        [
                            'label'     => __( 'Icon Circle', 'htmega-addons' ),
                            'type'      => Controls_Manager::HEADING,
                            'separator' => 'before',
                        ]
                    );

                    $this->add_control(
                        'play_icon_bg_color',
                        [
                            'label'     => __( 'Icon Circle Background', 'htmega-addons' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htm25-hero__play-icon' => 'background-color: {{VALUE}}; background-image: none;',
                            ],
                        ]
                    );

                    $this->add_control(
                        'play_icon_color',
                        [
                            'label'     => __( 'Icon Color', 'htmega-addons' ),
                            'type'      => Controls_Manager::COLOR,
                            'default'   => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .htm25-hero__play-icon i'        => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htm25-hero__play-icon svg'      => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htm25-hero__play-icon svg path' => 'fill: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name'     => 'secondary_btn_border',
                            'selector' => '{{WRAPPER}} .htm25-btn--outline',
                            'separator' => 'before',
                        ]
                    );

                    $this->add_control(
                        'secondary_btn_padding',
                        [
                            'label'      => __( 'Padding', 'htmega-addons' ),
                            'type'       => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors'  => [
                                '{{WRAPPER}} .htm25-btn--outline' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'secondary_btn_color_hover',
                        [
                            'label'     => __( 'Hover Text Color', 'htmega-addons' ),
                            'type'      => Controls_Manager::COLOR,
                            'separator' => 'before',
                            'selectors' => [
                                '{{WRAPPER}} .htm25-btn--outline:hover'                              => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htm25-btn--outline:hover .htm25-hero__play-icon'       => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htm25-btn--outline:hover .htm25-hero__play-icon i'     => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htm25-btn--outline:hover .htm25-hero__play-icon svg'   => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htm25-btn--outline:hover .htm25-hero__play-icon svg path' => 'fill: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name'     => 'secondary_btn_border_hover',
                            'label'    => __( 'Hover Border', 'htmega-addons' ),
                            'selector' => '{{WRAPPER}} .htm25-btn--outline:hover',
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        /* ── STYLE: BADGE / EYEBROW ─────────────────────────── */
        $this->start_controls_section(
            'style_badge',
            [
                'label'     => __( 'Badge / Eyebrow', 'htmega-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'badge_show' => 'yes' ],
            ]
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'badge_typography',
                    'selector' => '{{WRAPPER}} .htm25-hero__badge',
                ]
            );

            $this->add_control(
                'badge_color',
                [
                    'label'     => __( 'Text Color', 'htmega-addons' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htm25-hero__badge' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'badge_bg',
                [
                    'label'     => __( 'Background Color', 'htmega-addons' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htm25-hero__badge' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'badge_border_radius',
                [
                    'label'      => __( 'Border Radius', 'htmega-addons' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors'  => [
                        '{{WRAPPER}} .htm25-hero__badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'badge_icon_heading',
                [
                    'label'     => __( 'Icon', 'htmega-addons' ),
                    'type'      => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'badge_icon_color',
                [
                    'label'     => __( 'Icon Color', 'htmega-addons' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htm25-hero__badge-icon i'        => 'color: {{VALUE}};',
                        '{{WRAPPER}} .htm25-hero__badge-icon svg path'  => 'fill: {{VALUE}};',
                        '{{WRAPPER}} .htm25-hero__badge-icon svg'       => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'badge_icon_size',
                [
                    'label'      => __( 'Icon Size', 'htmega-addons' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', 'em' ],
                    'range'      => [ 'px' => [ 'min' => 8, 'max' => 48 ] ],
                    'selectors'  => [
                        '{{WRAPPER}} .htm25-hero__badge-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .htm25-hero__badge-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .htm25-hero__badge-icon img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'badge_icon_gap',
                [
                    'label'      => __( 'Icon & Text Gap', 'htmega-addons' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', 'em' ],
                    'range'      => [ 'px' => [ 'min' => 0, 'max' => 24 ] ],
                    'selectors'  => [
                        '{{WRAPPER}} .htm25-hero__badge' => 'gap: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

        /* ── STYLE: DESCRIPTION ─────────────────────────────── */
        $this->start_controls_section(
            'style_description',
            [
                'label' => __( 'Description', 'htmega-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'description_typography',
                    'selector' => '{{WRAPPER}} .htm25-hero__description',
                ]
            );

            $this->add_control(
                'description_color',
                [
                    'label'     => __( 'Color', 'htmega-addons' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htm25-hero__description' => 'color: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_section();

        /* ── STYLE: SOCIAL PROOF ────────────────────────────── */
        $this->start_controls_section(
            'style_social_proof',
            [
                'label'     => __( 'Social Proof', 'htmega-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'social_proof_show' => 'yes' ],
            ]
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'social_proof_typography',
                    'label'    => __( 'Text Typography', 'htmega-addons' ),
                    'selector' => '{{WRAPPER}} .htm25-hero__social-text',
                ]
            );

            $this->add_control(
                'social_proof_color',
                [
                    'label'     => __( 'Text Color', 'htmega-addons' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htm25-hero__social-text' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'rating_typography',
                    'label'    => __( 'Rating Typography', 'htmega-addons' ),
                    'selector' => '{{WRAPPER}} .htm25-hero__rating',
                ]
            );

            $this->add_control(
                'rating_color',
                [
                    'label'     => __( 'Rating Color', 'htmega-addons' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htm25-hero__rating' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'stars_color',
                [
                    'label'     => __( 'Stars Color', 'htmega-addons' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htm25-hero__stars svg path' => 'fill: {{VALUE}};',
                        '{{WRAPPER}} .htm25-hero__stars'          => 'color: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_section();

        /* ── STYLE: FLOATING BADGE ──────────────────────────── */
        $this->start_controls_section(
            'style_floating_badge',
            [
                'label'     => __( 'Floating Badge', 'htmega-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout!'             => 'centered',
                    'floating_badge_show' => 'yes',
                ],
            ]
        );

            $this->add_control(
                'floating_badge_bg',
                [
                    'label'     => __( 'Background', 'htmega-addons' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htm25-hero__float-badge' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'floating_badge_number_typography',
                    'label'    => __( 'Number Typography', 'htmega-addons' ),
                    'selector' => '{{WRAPPER}} .htm25-hero__float-number',
                ]
            );

            $this->add_control(
                'floating_badge_number_color',
                [
                    'label'     => __( 'Number Color', 'htmega-addons' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htm25-hero__float-number' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'floating_badge_label_typography',
                    'label'    => __( 'Label Typography', 'htmega-addons' ),
                    'selector' => '{{WRAPPER}} .htm25-hero__float-label',
                ]
            );

            $this->add_control(
                'floating_badge_label_color',
                [
                    'label'     => __( 'Label Color', 'htmega-addons' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htm25-hero__float-label' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'floating_badge_radius',
                [
                    'label'      => __( 'Border Radius', 'htmega-addons' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors'  => [
                        '{{WRAPPER}} .htm25-hero__float-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

        /* ── STYLE: IMAGE / MEDIA ───────────────────────────── */
        $this->start_controls_section(
            'style_media',
            [
                'label'     => __( 'Image / Media', 'htmega-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'layout!' => 'centered' ],
            ]
        );

            $this->add_control(
                'image_border_radius',
                [
                    'label'      => __( 'Border Radius', 'htmega-addons' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors'  => [
                        '{{WRAPPER}} .htm25-hero__media img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'     => 'image_box_shadow',
                    'selector' => '{{WRAPPER}} .htm25-hero__media img',
                ]
            );

        $this->end_controls_section();

    } // end register_controls()


    /* -------------------------------------------------------
       Render
    ------------------------------------------------------- */

    protected function render() {
        $settings = $this->get_settings_for_display();

        $style  = esc_attr( $settings['design_style'] );
        $layout = esc_attr( $settings['layout'] );

        // Prepare headline with highlighted word accent
        $headline  = wp_kses_post( $settings['headline'] );
        $highlight = ! empty( $settings['headline_highlight'] )
            ? trim( $settings['headline_highlight'] )
            : '';

        if ( $highlight ) {
            $headline = str_replace(
                esc_html( $highlight ),
                '<span class="htm25-hero__headline-accent">' . esc_html( $highlight ) . '</span>',
                $headline
            );
        }

        $headline_tag = in_array( $settings['headline_tag'], [ 'h1', 'h2', 'h3' ] )
            ? $settings['headline_tag']
            : 'h1';

        // Primary button attributes
        $primary_btn_attrs = '';
        if ( ! empty( $settings['primary_btn_url']['url'] ) ) {
            $this->add_link_attributes( 'primary_btn', $settings['primary_btn_url'] );
            $primary_btn_attrs = $this->get_render_attribute_string( 'primary_btn' );
        }

        // Secondary button attributes
        $secondary_btn_attrs = '';
        if ( ! empty( $settings['secondary_btn_url']['url'] ) ) {
            $this->add_link_attributes( 'secondary_btn', $settings['secondary_btn_url'] );
            $secondary_btn_attrs = $this->get_render_attribute_string( 'secondary_btn' );
        }

        // Image for split layouts
        $image_html = '';
        if ( $layout !== 'centered' && ! empty( $settings['hero_image']['id'] ) ) {
            $image_html = Group_Control_Image_Size::get_attachment_image_html(
                $settings, 'hero_image', 'hero_image'
            );
        } elseif ( $layout !== 'centered' && ! empty( $settings['hero_image']['url'] ) ) {
            $image_html = '<img src="' . esc_url( $settings['hero_image']['url'] ) . '" alt="" loading="lazy">';
        }

        ?>
        <section class="htm25-hero htm25-style--<?php echo $style; ?> htm25-hero--<?php echo $layout; ?>" aria-label="<?php esc_attr_e( 'Hero section', 'htmega-addons' ); ?>">

            <?php if ( $style === 'aurora' || $style === 'glass' ) : ?>
            <div class="htm25-hero__bg-blobs" aria-hidden="true">
                <div class="htm25-hero__blob htm25-hero__blob--1"></div>
                <div class="htm25-hero__blob htm25-hero__blob--2"></div>
                <?php if ( $style === 'aurora' ) : ?>
                <div class="htm25-hero__blob htm25-hero__blob--3"></div>
                <?php endif; ?>
            </div>
            <?php endif; ?>


            <div class="htm25-hero__inner">

                <?php if ( $layout === 'split-right' && $image_html ) : ?>
                <div class="htm25-hero__media">
                    <?php echo $image_html; // already escaped via WP functions ?>
                    <?php $this->render_floating_badge( $settings ); ?>
                </div>
                <?php endif; ?>

                <div class="htm25-hero__content">

                    <?php if ( $settings['badge_show'] === 'yes' && ! empty( $settings['badge_text'] ) ) : ?>
                    <div class="htm25-hero__badge htm25-badge" role="note">
                        <?php if ( ! empty( $settings['badge_icon']['value'] ) ) : ?>
                        <span class="htm25-hero__badge-icon" aria-hidden="true">
                            <?php Icons_Manager::render_icon( $settings['badge_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </span>
                        <?php endif; ?>
                        <span><?php echo esc_html( $settings['badge_text'] ); ?></span>
                    </div>
                    <?php endif; ?>

                    <<?php echo $headline_tag; ?> class="htm25-hero__headline"><?php echo $headline; // nl2br + wp_kses_post applied above ?></<?php echo $headline_tag; ?>>

                    <?php if ( ! empty( $settings['description'] ) ) : ?>
                    <p class="htm25-hero__description">
                        <?php echo wp_kses_post( $settings['description'] ); ?>
                    </p>
                    <?php endif; ?>

                    <?php if ( $settings['primary_btn_show'] === 'yes' || $settings['secondary_btn_show'] === 'yes' ) : ?>
                    <div class="htm25-hero__actions">

                        <?php if ( $settings['primary_btn_show'] === 'yes' && ! empty( $settings['primary_btn_text'] ) ) : ?>
                        <a class="htm25-btn htm25-btn--primary" <?php echo $primary_btn_attrs; ?>>
                            <?php echo esc_html( $settings['primary_btn_text'] ); ?>
                        </a>
                        <?php endif; ?>

                        <?php if ( $settings['secondary_btn_show'] === 'yes' && ! empty( $settings['secondary_btn_text'] ) ) : ?>
                        <a class="htm25-btn htm25-btn--outline htm25-hero__btn-secondary" <?php echo $secondary_btn_attrs; ?>>
                            <?php if ( ! empty( $settings['secondary_btn_icon']['value'] ) ) : ?>
                            <span class="htm25-hero__play-icon" aria-hidden="true">
                                <?php Icons_Manager::render_icon( $settings['secondary_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            </span>
                            <?php endif; ?>
                            <?php echo esc_html( $settings['secondary_btn_text'] ); ?>
                        </a>
                        <?php endif; ?>

                    </div>
                    <?php endif; ?>

                    <?php if ( $settings['social_proof_show'] === 'yes' && ! empty( $settings['social_proof_text'] ) ) : ?>
                    <div class="htm25-hero__social-proof">
                        <div class="htm25-hero__stars" aria-hidden="true">
                            <?php for ( $i = 0; $i < 5; $i++ ) : ?>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M7 1L8.854 5.04L13.294 5.635L10.147 8.7L10.909 13.122L7 11L3.091 13.122L3.853 8.7L0.706 5.635L5.146 5.04L7 1Z" fill="currentColor"/>
                            </svg>
                            <?php endfor; ?>
                        </div>
                        <?php if ( ! empty( $settings['social_proof_rating'] ) ) : ?>
                        <span class="htm25-hero__rating"><?php echo esc_html( $settings['social_proof_rating'] ); ?></span>
                        <?php endif; ?>
                        <span class="htm25-hero__social-text"><?php echo esc_html( $settings['social_proof_text'] ); ?></span>
                    </div>
                    <?php endif; ?>

                </div><!-- /.htm25-hero__content -->

                <?php if ( $layout === 'split-left' && $image_html ) : ?>
                <div class="htm25-hero__media">
                    <?php echo $image_html; ?>
                    <?php $this->render_floating_badge( $settings ); ?>
                </div>
                <?php endif; ?>

            </div><!-- /.htm25-hero__inner -->

        </section>
        <?php
    }

    /* -------------------------------------------------------
       Helper: floating stat badge
    ------------------------------------------------------- */

    private function render_floating_badge( $settings ) {
        if ( $settings['floating_badge_show'] !== 'yes' ) {
            return;
        }
        if ( empty( $settings['floating_stat_number'] ) && empty( $settings['floating_stat_label'] ) ) {
            return;
        }
        ?>
        <div class="htm25-hero__float-badge" aria-label="<?php echo esc_attr( $settings['floating_stat_number'] . ' ' . $settings['floating_stat_label'] ); ?>">
            <span class="htm25-hero__float-number"><?php echo esc_html( $settings['floating_stat_number'] ); ?></span>
            <span class="htm25-hero__float-label"><?php echo esc_html( $settings['floating_stat_label'] ); ?></span>
        </div>
        <?php
    }

} // end class
