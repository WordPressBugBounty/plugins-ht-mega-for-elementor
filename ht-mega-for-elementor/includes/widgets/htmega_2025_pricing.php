<?php
/**
 * HT Mega 2026 — Pricing Table Widget
 * Widget name: htmega-2026-pricing
 *
 * Part of the HT Mega 2026 Collection.
 * Shares BEM HTML with htmega-blocks/src/blocks/pricing-2025/index.php.
 * All styles live in assets/css/widgets/htm25-pricing.css.
 * All CSS values reference tokens from assets/css/htm25-tokens.css.
 *
 * PHP namespace: \Elementor   (required for Elementor auto-discovery)
 * Class: HTMega_Elementor_Widget_Pricing_2025
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class HTMega_Elementor_Widget_Pricing_2025 extends Widget_Base {

    // ── Identity ──────────────────────────────────────────────

    public function get_name()        { return 'htmega-2026-pricing'; }
    public function get_title()       { return __( 'Pricing Table 2026', 'htmega-addons' ); }
    public function get_icon()        { return 'htmega-icon eicon-price-table'; }
    public function get_categories()  { return [ 'htmega-2026' ]; }
    public function get_keywords()    { return [ 'pricing', 'price', 'table', 'plans', 'htmega', '2026' ]; }

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
                'default' => 'cards',
                'options' => [
                    'cards'    => __( 'Side-by-Side Cards', 'htmega-addons' ),
                    'centered' => __( 'Centered',           'htmega-addons' ),
                ],
            ] );

            $this->add_control( 'plan_columns', [
                'label'   => __( 'Columns', 'htmega-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '2' => __( '2 Plans', 'htmega-addons' ),
                    '3' => __( '3 Plans', 'htmega-addons' ),
                    '4' => __( '4 Plans', 'htmega-addons' ),
                ],
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
                'default'   => __( 'Pricing', 'htmega-addons' ),
                'condition' => [ 'show_section_label' => 'yes' ],
            ] );

            $this->add_control( 'headline', [
                'label'   => __( 'Headline', 'htmega-addons' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __( "Simple pricing for\nevery team size.", 'htmega-addons' ),
                'rows'    => 3,
            ] );

            $this->add_control( 'headline_highlight', [
                'label'       => __( 'Highlighted Word(s)', 'htmega-addons' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'every team size', 'htmega-addons' ),
                'description' => __( 'These words will be styled with the accent color/gradient.', 'htmega-addons' ),
            ] );

            $this->add_control( 'headline_tag', [
                'label'   => __( 'HTML Tag', 'htmega-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [ 'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3' ],
            ] );

            $this->add_control( 'description', [
                'label'   => __( 'Description', 'htmega-addons' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __( 'No hidden fees. No lock-in. Upgrade or downgrade at any time.', 'htmega-addons' ),
                'rows'    => 3,
            ] );

        $this->end_controls_section();

        /* ── Billing Toggle ── */
        $this->start_controls_section( 'section_billing_toggle', [
            'label' => __( 'Billing Toggle', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

            $this->add_control( 'show_billing_toggle', [
                'label'        => __( 'Show Monthly / Annual Toggle', 'htmega-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'htmega-addons' ),
                'label_off'    => __( 'Hide', 'htmega-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ] );

            $this->add_control( 'billing_monthly_label', [
                'label'     => __( 'Monthly Label', 'htmega-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Monthly', 'htmega-addons' ),
                'condition' => [ 'show_billing_toggle' => 'yes' ],
            ] );

            $this->add_control( 'billing_annual_label', [
                'label'     => __( 'Annual Label', 'htmega-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Annual', 'htmega-addons' ),
                'condition' => [ 'show_billing_toggle' => 'yes' ],
            ] );

            $this->add_control( 'billing_save_badge', [
                'label'       => __( 'Savings Badge Text', 'htmega-addons' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Save 20%', 'htmega-addons' ),
                'description' => __( 'Shown next to the Annual label. Leave empty to hide.', 'htmega-addons' ),
                'condition'   => [ 'show_billing_toggle' => 'yes' ],
            ] );

        $this->end_controls_section();

        /* ── Plan Items ── */
        $this->start_controls_section( 'section_plans', [
            'label' => __( 'Pricing Plans', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

            $repeater = new Repeater();

            $repeater->add_control( 'plan_name', [
                'label'   => __( 'Plan Name', 'htmega-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Pro', 'htmega-addons' ),
            ] );

            $repeater->add_control( 'is_featured', [
                'label'        => __( 'Featured / Popular Plan', 'htmega-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'htmega-addons' ),
                'label_off'    => __( 'No', 'htmega-addons' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ] );

            $repeater->add_control( 'featured_badge', [
                'label'     => __( 'Badge Text', 'htmega-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Most Popular', 'htmega-addons' ),
                'condition' => [ 'is_featured' => 'yes' ],
            ] );

            $repeater->add_control( 'plan_icon', [
                'label'   => __( 'Plan Icon', 'htmega-addons' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [ 'value' => '', 'library' => 'fa-solid' ],
            ] );

            $repeater->add_control( 'currency', [
                'label'   => __( 'Currency Symbol', 'htmega-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => '$',
                'classes' => 'elementor-control-direction-ltr',
            ] );

            $repeater->add_control( 'price_monthly', [
                'label'   => __( 'Monthly Price', 'htmega-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => '29',
            ] );

            $repeater->add_control( 'price_annual', [
                'label'   => __( 'Annual Price (per month)', 'htmega-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => '23',
            ] );

            $repeater->add_control( 'period', [
                'label'   => __( 'Period Label', 'htmega-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( '/month', 'htmega-addons' ),
            ] );

            $repeater->add_control( 'tagline', [
                'label'   => __( 'Tagline', 'htmega-addons' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __( 'For growing teams that need more power.', 'htmega-addons' ),
                'rows'    => 2,
            ] );

            $repeater->add_control( 'features', [
                'label'       => __( 'Features (one per line)', 'htmega-addons' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => "Unlimited projects\n50 GB storage\nPriority email support\nAdvanced analytics\nAPI access",
                'rows'        => 6,
                'description' => __( 'Each line becomes a feature row with a check icon.', 'htmega-addons' ),
            ] );

            $repeater->add_control( 'cta_text', [
                'label'   => __( 'Button Text', 'htmega-addons' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Get Started', 'htmega-addons' ),
            ] );

            $repeater->add_control( 'cta_url', [
                'label'   => __( 'Button URL', 'htmega-addons' ),
                'type'    => Controls_Manager::URL,
                'default' => [ 'url' => '#' ],
            ] );

            $repeater->add_control( 'cta_variant', [
                'label'   => __( 'Button Style', 'htmega-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'outline',
                'options' => [
                    'primary' => __( 'Primary (filled)', 'htmega-addons' ),
                    'outline' => __( 'Outline',          'htmega-addons' ),
                ],
            ] );

            $this->add_control( 'plan_items', [
                'label'       => __( 'Plans', 'htmega-addons' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'plan_name'     => __( 'Starter', 'htmega-addons' ),
                        'is_featured'   => 'no',
                        'featured_badge'=> __( 'Most Popular', 'htmega-addons' ),
                        'currency'      => '$',
                        'price_monthly' => '9',
                        'price_annual'  => '7',
                        'period'        => __( '/month', 'htmega-addons' ),
                        'tagline'       => __( 'Perfect for freelancers and solo creators.', 'htmega-addons' ),
                        'features'      => "3 Projects\n5 GB Storage\nEmail Support\nBasic Analytics",
                        'cta_text'      => __( 'Start Free Trial', 'htmega-addons' ),
                        'cta_variant'   => 'outline',
                    ],
                    [
                        'plan_name'     => __( 'Pro', 'htmega-addons' ),
                        'is_featured'   => 'yes',
                        'featured_badge'=> __( 'Most Popular', 'htmega-addons' ),
                        'currency'      => '$',
                        'price_monthly' => '29',
                        'price_annual'  => '23',
                        'period'        => __( '/month', 'htmega-addons' ),
                        'tagline'       => __( 'For growing teams that need more power.', 'htmega-addons' ),
                        'features'      => "Unlimited Projects\n50 GB Storage\nPriority Support\nAdvanced Analytics\nAPI Access",
                        'cta_text'      => __( 'Get Started', 'htmega-addons' ),
                        'cta_variant'   => 'primary',
                    ],
                    [
                        'plan_name'     => __( 'Enterprise', 'htmega-addons' ),
                        'is_featured'   => 'no',
                        'featured_badge'=> __( 'Most Popular', 'htmega-addons' ),
                        'currency'      => '$',
                        'price_monthly' => '79',
                        'price_annual'  => '63',
                        'period'        => __( '/month', 'htmega-addons' ),
                        'tagline'       => __( 'Custom solutions for large organisations.', 'htmega-addons' ),
                        'features'      => "Unlimited Everything\n500 GB Storage\nDedicated Support\nCustom Integrations\nSSO & SAML\nSLA Guarantee",
                        'cta_text'      => __( 'Contact Sales', 'htmega-addons' ),
                        'cta_variant'   => 'outline',
                    ],
                ],
                'title_field' => '{{{ plan_name }}}',
            ] );

        $this->end_controls_section();

        // ════════════════════════════════════════════════════════
        //  STYLE TAB
        // ════════════════════════════════════════════════════════

        /* ── 1. Section (wrapper) ── */
        $this->start_controls_section( 'style_section', [
            'label' => __( 'Section', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

            $this->add_responsive_control( 'section_padding', [
                'label'      => __( 'Padding', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-pricing' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name'     => 'section_bg',
                    'label'    => __( 'Background', 'htmega-addons' ),
                    'types'    => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htm25-pricing',
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
                    'selector' => '{{WRAPPER}} .htm25-pricing__section-label',
                ]
            );

            $this->add_control( 'section_label_color', [
                'label'     => __( 'Text Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__section-label' => 'color: {{VALUE}};',
                ],
            ] );

            $this->add_control( 'section_label_bg_color', [
                'label'     => __( 'Background Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__section-label' => 'background-color: {{VALUE}};',
                ],
            ] );

            $this->add_responsive_control( 'section_label_border_radius', [
                'label'      => __( 'Border Radius', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-pricing__section-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_responsive_control( 'section_label_padding', [
                'label'      => __( 'Padding', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-pricing__section-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    'selector' => '{{WRAPPER}} .htm25-pricing__headline',
                ]
            );

            $this->add_control( 'headline_color', [
                'label'     => __( 'Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__headline' => 'color: {{VALUE}};',
                ],
            ] );

            $this->add_responsive_control( 'headline_margin', [
                'label'      => __( 'Margin', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-pricing__headline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_control( 'headline_accent_heading', [
                'label'     => __( 'Headline Accent', 'htmega-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ] );

            $this->add_control( 'headline_accent_color', [
                'label'     => __( 'Accent Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__headline-accent' => 'background-color: {{VALUE}}; background-image: none;',
                ],
            ] );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name'           => 'headline_accent_gradient',
                    'label'          => __( 'Accent Gradient', 'htmega-addons' ),
                    'types'          => [ 'gradient' ],
                    'selector'       => '{{WRAPPER}} .htm25-pricing__headline-accent',
                    'fields_options' => [
                        'background' => [
                            'label' => __( 'Gradient Color', 'htmega-addons' ),
                        ],
                    ],
                ]
            );

        $this->end_controls_section();

        /* ── 4. Description ── */
        $this->start_controls_section( 'style_description', [
            'label' => __( 'Description', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'description_typography',
                    'selector' => '{{WRAPPER}} .htm25-pricing__description',
                ]
            );

            $this->add_control( 'description_color', [
                'label'     => __( 'Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__description' => 'color: {{VALUE}};',
                ],
            ] );

        $this->end_controls_section();

        /* ── 5. Pricing Card ── */
        $this->start_controls_section( 'style_card', [
            'label' => __( 'Pricing Card', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name'     => 'card_bg',
                    'label'    => __( 'Background', 'htmega-addons' ),
                    'types'    => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htm25-pricing__card',
                ]
            );

            $this->add_responsive_control( 'card_padding', [
                'label'      => __( 'Card Header Padding', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-pricing__card-head' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_responsive_control( 'card_border_radius', [
                'label'      => __( 'Border Radius', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-pricing__card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'     => 'card_border',
                    'selector' => '{{WRAPPER}} .htm25-pricing__card',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'     => 'card_box_shadow',
                    'selector' => '{{WRAPPER}} .htm25-pricing__card',
                ]
            );

            $this->add_control( 'card_featured_heading', [
                'label'     => __( 'Featured Card', 'htmega-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ] );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name'     => 'card_featured_bg',
                    'label'    => __( 'Background', 'htmega-addons' ),
                    'types'    => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htm25-pricing__card--featured',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'     => 'card_featured_border',
                    'selector' => '{{WRAPPER}} .htm25-pricing__card--featured',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'     => 'card_featured_box_shadow',
                    'selector' => '{{WRAPPER}} .htm25-pricing__card--featured',
                ]
            );

        $this->end_controls_section();

        /* ── 6. Price ── */
        $this->start_controls_section( 'style_price', [
            'label' => __( 'Price', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'price_amount_typography',
                    'label'    => __( 'Price Amount Typography', 'htmega-addons' ),
                    'selector' => '{{WRAPPER}} .htm25-pricing__card-amount--monthly, {{WRAPPER}} .htm25-pricing__card-amount--annual',
                ]
            );

            $this->add_control( 'price_amount_color', [
                'label'     => __( 'Price Amount Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__card-amount--monthly' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .htm25-pricing__card-amount--annual'  => 'color: {{VALUE}};',
                ],
            ] );

            $this->add_control( 'price_currency_color', [
                'label'     => __( 'Currency Symbol Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__card-currency' => 'color: {{VALUE}};',
                ],
            ] );

            $this->add_control( 'price_period_heading', [
                'label'     => __( 'Period / Billing Label', 'htmega-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ] );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'price_period_typography',
                    'selector' => '{{WRAPPER}} .htm25-pricing__card-period',
                ]
            );

            $this->add_control( 'price_period_color', [
                'label'     => __( 'Period Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__card-period' => 'color: {{VALUE}};',
                ],
            ] );

        $this->end_controls_section();

        /* ── 7. Plan Name ── */
        $this->start_controls_section( 'style_plan_name', [
            'label' => __( 'Plan Name', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'plan_name_typography',
                    'selector' => '{{WRAPPER}} .htm25-pricing__card-name',
                ]
            );

            $this->add_control( 'plan_name_color', [
                'label'     => __( 'Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__card-name' => 'color: {{VALUE}};',
                ],
            ] );

        $this->end_controls_section();

        /* ── 8. Features List ── */
        $this->start_controls_section( 'style_features', [
            'label' => __( 'Features List', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'feature_item_typography',
                    'selector' => '{{WRAPPER}} .htm25-pricing__card-feature',
                ]
            );

            $this->add_control( 'feature_item_color', [
                'label'     => __( 'Feature Text Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__card-feature' => 'color: {{VALUE}};',
                ],
            ] );

            $this->add_control( 'feature_check_heading', [
                'label'     => __( 'Check Icon', 'htmega-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ] );

            $this->add_control( 'feature_check_color', [
                'label'     => __( 'Check Icon Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__card-feature-check'      => 'color: {{VALUE}};',
                    '{{WRAPPER}} .htm25-pricing__card-feature-check svg'  => 'color: {{VALUE}};',
                    '{{WRAPPER}} .htm25-pricing__card-feature-check svg path' => 'fill: {{VALUE}};',
                ],
            ] );

            $this->add_control( 'feature_check_bg_color', [
                'label'     => __( 'Check Icon Background Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__card-feature-check' => 'background-color: {{VALUE}};',
                ],
            ] );

            $this->add_control( 'plan_icon_heading', [
                'label'     => __( 'Plan Icon', 'htmega-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ] );

            $this->add_control( 'plan_icon_color', [
                'label'     => __( 'Plan Icon Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__card-icon i'        => 'color: {{VALUE}};',
                    '{{WRAPPER}} .htm25-pricing__card-icon svg'      => 'color: {{VALUE}};',
                    '{{WRAPPER}} .htm25-pricing__card-icon svg path' => 'fill: {{VALUE}};',
                ],
            ] );

            $this->add_control( 'plan_icon_bg_color', [
                'label'     => __( 'Plan Icon Background Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__card-icon-wrap' => 'background-color: {{VALUE}};',
                ],
            ] );

            $this->add_responsive_control( 'plan_icon_size', [
                'label'      => __( 'Plan Icon Size', 'htmega-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 10, 'max' => 80 ] ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-pricing__card-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .htm25-pricing__card-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ] );

        $this->end_controls_section();

        /* ── 9. CTA Button ── */
        $this->start_controls_section( 'style_cta', [
            'label' => __( 'CTA Button', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'cta_typography',
                    'selector' => '{{WRAPPER}} .htm25-pricing__card-cta',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name'     => 'cta_bg',
                    'label'    => __( 'Background', 'htmega-addons' ),
                    'types'    => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htm25-pricing__card-cta.htm25-btn--primary',
                ]
            );

            $this->add_control( 'cta_text_color', [
                'label'     => __( 'Text Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__card-cta' => 'color: {{VALUE}};',
                ],
            ] );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'     => 'cta_border',
                    'selector' => '{{WRAPPER}} .htm25-pricing__card-cta',
                ]
            );

            $this->add_responsive_control( 'cta_border_radius', [
                'label'      => __( 'Border Radius', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-pricing__card-cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

            $this->add_control( 'cta_hover_heading', [
                'label'     => __( 'Hover', 'htmega-addons' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ] );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name'     => 'cta_hover_bg',
                    'label'    => __( 'Hover Background', 'htmega-addons' ),
                    'types'    => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htm25-pricing__card-cta:hover',
                ]
            );

            $this->add_control( 'cta_hover_text_color', [
                'label'     => __( 'Hover Text Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__card-cta:hover' => 'color: {{VALUE}};',
                ],
            ] );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'     => 'cta_hover_border',
                    'selector' => '{{WRAPPER}} .htm25-pricing__card-cta:hover',
                ]
            );

        $this->end_controls_section();

        /* ── 10. Popular Badge ── */
        $this->start_controls_section( 'style_popular_badge', [
            'label' => __( 'Popular Badge', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'popular_badge_typography',
                    'selector' => '{{WRAPPER}} .htm25-pricing__card-badge',
                ]
            );

            $this->add_control( 'popular_badge_color', [
                'label'     => __( 'Text Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__card-badge' => 'color: {{VALUE}};',
                ],
            ] );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name'     => 'popular_badge_bg',
                    'label'    => __( 'Background', 'htmega-addons' ),
                    'types'    => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htm25-pricing__card-badge',
                ]
            );

            $this->add_responsive_control( 'popular_badge_border_radius', [
                'label'      => __( 'Border Radius', 'htmega-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .htm25-pricing__card-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ] );

        $this->end_controls_section();

        /* ── 11. Billing Toggle ── */
        $this->start_controls_section( 'style_billing_toggle', [
            'label'     => __( 'Billing Toggle', 'htmega-addons' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_billing_toggle' => 'yes' ],
        ] );

            $this->add_control( 'toggle_track_color', [
                'label'     => __( 'Track Color (inactive)', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__toggle-track' => 'background: {{VALUE}};',
                ],
            ] );

            $this->add_control( 'toggle_track_active_color', [
                'label'     => __( 'Track Color (active)', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__toggle-cb:checked + .htm25-pricing__toggle-track' => 'background: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ] );

            $this->add_control( 'toggle_thumb_color', [
                'label'     => __( 'Thumb Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__toggle-thumb' => 'background: {{VALUE}};',
                ],
            ] );

            $this->add_control( 'save_badge_color', [
                'label'     => __( 'Save Badge Text Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__save-badge' => 'color: {{VALUE}};',
                ],
            ] );

            $this->add_control( 'save_badge_bg', [
                'label'     => __( 'Save Badge Background', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__save-badge' => 'background-color: {{VALUE}};',
                ],
            ] );

        $this->end_controls_section();

        /* ── 12. Plan Tagline ── */
        $this->start_controls_section( 'style_tagline', [
            'label' => __( 'Plan Tagline', 'htmega-addons' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'tagline_typography',
                    'selector' => '{{WRAPPER}} .htm25-pricing__card-tagline',
                ]
            );

            $this->add_control( 'tagline_color', [
                'label'     => __( 'Color', 'htmega-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .htm25-pricing__card-tagline' => 'color: {{VALUE}};',
                ],
            ] );

        $this->end_controls_section();
    }

    // ── Render ────────────────────────────────────────────────

    protected function render() {
        $settings = $this->get_settings_for_display();
        $uid = uniqid( 'p' );
        $this->render_pricing( $settings, $uid );
    }

    /**
     * Shared renderer — identical BEM HTML used by both Elementor render()
     * and the FSE block's index.php.
     *
     * @param array  $settings  Elementor settings array (or block attributes).
     * @param string $uid       Unique ID for scoping the billing toggle JS.
     */
    private function render_pricing( array $settings, string $uid ) {

        // ── Helpers ──────────────────────────────────────────

        $style  = ! empty( $settings['design_style'] ) ? sanitize_html_class( $settings['design_style'] ) : 'bento';
        $layout = ! empty( $settings['layout'] )       ? sanitize_html_class( $settings['layout'] )       : 'cards';
        $cols   = ! empty( $settings['plan_columns'] ) ? (int) $settings['plan_columns'] : 3;
        $cols   = in_array( $cols, [ 2, 3, 4 ], true ) ? $cols : 3;

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
                '<span class="htm25-pricing__headline-accent">' . esc_html( $highlight ) . '</span>',
                $headline
            );
        }
        $headline_tag = isset( $settings['headline_tag'] ) && in_array( $settings['headline_tag'], [ 'h1', 'h2', 'h3' ] )
            ? $settings['headline_tag'] : 'h2';

        // ── Description ──
        $description = ! empty( $settings['description'] ) ? $settings['description'] : '';

        // ── Billing toggle ──
        $show_toggle      = ! empty( $settings['show_billing_toggle'] ) && $settings['show_billing_toggle'] !== 'no';
        $label_monthly    = ! empty( $settings['billing_monthly_label'] ) ? $settings['billing_monthly_label'] : 'Monthly';
        $label_annual     = ! empty( $settings['billing_annual_label'] )  ? $settings['billing_annual_label']  : 'Annual';
        $save_badge       = ! empty( $settings['billing_save_badge'] )    ? $settings['billing_save_badge']    : '';

        // ── Plans ──
        $plan_items = ! empty( $settings['plan_items'] ) && is_array( $settings['plan_items'] )
            ? $settings['plan_items'] : [];

        $toggle_id = 'htm25-toggle-' . $uid;

        ?>
        <section
            id="htm25-pricing-<?php echo esc_attr( $uid ); ?>"
            class="htm25-pricing htm25-style--<?php echo $style; ?> htm25-pricing--<?php echo $layout; ?>"
            aria-label="<?php esc_attr_e( 'Pricing section', 'htmega-addons' ); ?>"
        >
            <?php if ( $style === 'aurora' || $style === 'glass' ) : ?>
            <div class="htm25-pricing__bg-blobs" aria-hidden="true">
                <div class="htm25-pricing__blob htm25-pricing__blob--1"></div>
                <div class="htm25-pricing__blob htm25-pricing__blob--2"></div>
            </div>
            <?php endif; ?>


            <div class="htm25-pricing__inner">

                <?php if ( $show_label || $headline || $description ) : ?>
                <div class="htm25-pricing__header">

                    <?php if ( $show_label && $label_text ) : ?>
                    <p class="htm25-pricing__section-label htm25-section-label">
                        <?php echo esc_html( $label_text ); ?>
                    </p>
                    <?php endif; ?>

                    <?php if ( $headline ) : ?>
                    <<?php echo $headline_tag; ?> class="htm25-pricing__headline"><?php echo $headline; ?></<?php echo $headline_tag; ?>>
                    <?php endif; ?>

                    <?php if ( $description ) : ?>
                    <p class="htm25-pricing__description">
                        <?php echo wp_kses_post( $description ); ?>
                    </p>
                    <?php endif; ?>

                </div><!-- /.htm25-pricing__header -->
                <?php endif; ?>

                <?php if ( $show_toggle ) : ?>
                <div class="htm25-pricing__toggle-wrap" role="group" aria-label="<?php esc_attr_e( 'Billing period', 'htmega-addons' ); ?>">
                    <span class="htm25-pricing__toggle-label htm25-pricing__toggle-label--monthly" id="<?php echo esc_attr( $toggle_id ); ?>-monthly">
                        <?php echo esc_html( $label_monthly ); ?>
                    </span>

                    <label class="htm25-pricing__toggle" for="<?php echo esc_attr( $toggle_id ); ?>">
                        <input
                            type="checkbox"
                            id="<?php echo esc_attr( $toggle_id ); ?>"
                            class="htm25-pricing__toggle-cb"
                            role="switch"
                            aria-checked="false"
                            aria-labelledby="<?php echo esc_attr( $toggle_id ); ?>-monthly <?php echo esc_attr( $toggle_id ); ?>-annual"
                        >
                        <span class="htm25-pricing__toggle-track" aria-hidden="true">
                            <span class="htm25-pricing__toggle-thumb"></span>
                        </span>
                    </label>

                    <span class="htm25-pricing__toggle-label htm25-pricing__toggle-label--annual" id="<?php echo esc_attr( $toggle_id ); ?>-annual">
                        <?php echo esc_html( $label_annual ); ?>
                        <?php if ( $save_badge ) : ?>
                        <span class="htm25-pricing__save-badge"><?php echo esc_html( $save_badge ); ?></span>
                        <?php endif; ?>
                    </span>
                </div>
                <?php endif; ?>

                <?php if ( $plan_items ) : ?>
                <div
                    class="htm25-pricing__cards htm25-pricing__cards--cols-<?php echo $cols; ?>"
                    role="list"
                >
                    <?php foreach ( $plan_items as $item ) :
                        $this->render_plan_card( $item );
                    endforeach; ?>
                </div>
                <?php endif; ?>

            </div><!-- /.htm25-pricing__inner -->

        </section>

        <?php if ( $show_toggle ) : ?>
        <script>
        ( function () {
            var wrap = document.getElementById( 'htm25-pricing-<?php echo esc_js( $uid ); ?>' );
            var cb   = wrap && wrap.querySelector( '.htm25-pricing__toggle-cb' );
            if ( ! cb ) return;
            cb.addEventListener( 'change', function () {
                wrap.classList.toggle( 'htm25-pricing--annual', this.checked );
                this.setAttribute( 'aria-checked', this.checked ? 'true' : 'false' );
            } );
        } )();
        </script>
        <?php endif; ?>
        <?php
    }

    /**
     * Render a single pricing plan card.
     *
     * @param array $item  Repeater item.
     */
    private function render_plan_card( array $item ) {
        $name        = ! empty( $item['plan_name'] )    ? $item['plan_name']    : '';
        $is_featured = ! empty( $item['is_featured'] ) && $item['is_featured'] !== 'no';
        $badge       = $is_featured && ! empty( $item['featured_badge'] ) ? $item['featured_badge'] : '';
        $icon        = ! empty( $item['plan_icon'] )    ? $item['plan_icon']    : [];
        $currency    = isset( $item['currency'] )       ? $item['currency']     : '$';
        $monthly     = ! empty( $item['price_monthly'] ) ? $item['price_monthly'] : '0';
        $annual      = ! empty( $item['price_annual'] )  ? $item['price_annual']  : '0';
        $period      = ! empty( $item['period'] )       ? $item['period']       : '/month';
        $tagline     = ! empty( $item['tagline'] )      ? $item['tagline']      : '';
        $features_raw= ! empty( $item['features'] )     ? $item['features']     : '';
        $cta_text    = ! empty( $item['cta_text'] )     ? $item['cta_text']     : '';
        $cta_url     = ! empty( $item['cta_url']['url'] ) ? $item['cta_url']['url'] : '#';
        $cta_target  = ! empty( $item['cta_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        $cta_variant = ! empty( $item['cta_variant'] )  ? $item['cta_variant']  : 'outline';

        $features = array_filter( array_map( 'trim', explode( "\n", $features_raw ) ) );

        $card_class = 'htm25-pricing__card';
        if ( $is_featured ) $card_class .= ' htm25-pricing__card--featured';
        ?>
        <div class="<?php echo esc_attr( $card_class ); ?>" role="listitem">

            <?php if ( $badge ) : ?>
            <div class="htm25-pricing__card-badge" aria-label="<?php echo esc_attr( $badge ); ?>">
                <?php echo esc_html( $badge ); ?>
            </div>
            <?php endif; ?>

            <div class="htm25-pricing__card-head">

                <?php if ( ! empty( $icon['value'] ) ) : ?>
                <div class="htm25-pricing__card-icon-wrap" aria-hidden="true">
                    <span class="htm25-pricing__card-icon">
                        <?php Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
                    </span>
                </div>
                <?php endif; ?>

                <?php if ( $name ) : ?>
                <h3 class="htm25-pricing__card-name"><?php echo esc_html( $name ); ?></h3>
                <?php endif; ?>

                <div class="htm25-pricing__card-price-wrap">
                    <span class="htm25-pricing__card-currency"><?php echo esc_html( $currency ); ?></span>
                    <span class="htm25-pricing__card-amount htm25-pricing__card-amount--monthly"><?php echo esc_html( $monthly ); ?></span>
                    <span class="htm25-pricing__card-amount htm25-pricing__card-amount--annual"><?php echo esc_html( $annual ); ?></span>
                    <span class="htm25-pricing__card-period"><?php echo esc_html( $period ); ?></span>
                </div>

                <?php if ( $tagline ) : ?>
                <p class="htm25-pricing__card-tagline"><?php echo wp_kses_post( $tagline ); ?></p>
                <?php endif; ?>

            </div><!-- /.htm25-pricing__card-head -->

            <?php if ( $features ) : ?>
            <hr class="htm25-pricing__card-divider" aria-hidden="true">

            <ul class="htm25-pricing__card-features" role="list" aria-label="<?php esc_attr_e( 'Plan features', 'htmega-addons' ); ?>">
                <?php foreach ( $features as $feature ) : ?>
                <li class="htm25-pricing__card-feature">
                    <span class="htm25-pricing__card-feature-check" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" width="14" height="14" aria-hidden="true"><path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                    </span>
                    <span><?php echo esc_html( $feature ); ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>

            <?php if ( $cta_text ) : ?>
            <div class="htm25-pricing__card-cta-wrap">
                <a
                    href="<?php echo esc_url( $cta_url ); ?>"
                    class="htm25-btn htm25-btn--<?php echo esc_attr( $cta_variant ); ?> htm25-pricing__card-cta"
                    <?php echo $cta_target; // phpcs:ignore — already sanitized ?>
                >
                    <?php echo esc_html( $cta_text ); ?>
                </a>
            </div>
            <?php endif; ?>

        </div><!-- /.htm25-pricing__card -->
        <?php
    }

} // end class HTMega_Elementor_Widget_Pricing_2025
