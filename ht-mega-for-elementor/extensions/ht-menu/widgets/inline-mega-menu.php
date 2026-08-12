<?php
namespace Elementor;

// Elementor Classes
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMegaMenu_Inline_Menu extends Widget_Base {

    public function get_name() {
        return 'htmega-menu-inline-menu';
    }

    public function get_title() {
        return __( 'Inline Mega Menu', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-menu-bar';
    }

    public function get_categories() {
        return array( 'htmegamenu-addons' );
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_menu_options',
            array(
                'label' => __( 'Menu', 'ht-mega-for-elementor' ),
            )
        );

            $this->add_control(
                'menu',
                array(
                    'label'   => __( 'Select Menu', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => '',
                    'options' => htmega_get_all_create_menus(),
                )
            );

            $this->add_control(
                'dropdown_icon',
                array(
                    'label'       => __( 'Dropdown Icon', 'ht-mega-for-elementor' ),
                    'type'        => Controls_Manager::ICONS,
                    'label_block' => true,
                    'default'     => [
                        'value' => 'fa fa-angle-down',
                        'library' => 'fa-solid',
                    ],
                )
            );
            // "Hide Menu Badge" / "Hide Menu Badge Arrow" controls (pro-only) are
            // injected here by htmega-pro via the
            // elementor/element/htmega-menu-inline-menu/section_menu_options/before_section_end
            // hook — see htmega-pro/extensions/ht-menu/widgets/inline-mega-menu-pro.php
        $this->end_controls_section();

        // Menu Style
        $this->start_controls_section(
            'section_main_menu_style',
            array(
                'label'      => __( 'Menu Area', 'ht-mega-for-elementor' ),
                'tab'        => Controls_Manager::TAB_STYLE,
            )
        );
            
            $this->add_responsive_control(
                'menu_wrap_width',
                array(
                    'label' => __( 'Main Menu Width', 'ht-mega-for-elementor' ),
                    'type'  => Controls_Manager::SLIDER,
                    'size_units' => array(
                        '%', 'px',
                    ),
                    'range' => array(
                        '%' => array(
                            'min' => 10,
                            'max' => 100,
                        ),
                        'px' => array(
                            'min' => 10,
                            'max' => 1500,
                        ),
                    ),
                    'default' => array(
                        'unit' => '%',
                        'size' => 100,
                    ),
                    'selectors'  => array(
                        '{{WRAPPER}} .htmega-menu-area' => 'width: {{SIZE}}{{UNIT}}',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                array(
                    'name'     => 'main_menu_background',
                    'selector' => '{{WRAPPER}} .htmega-menu-area',
                )
            );

            $this->add_responsive_control(
                'main_menu_margin',
                array(
                    'label'      => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%', 'em' ),
                    'selectors'  => array(
                        '{{WRAPPER}} .htmega-menu-area'=> 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
                )
            );

            $this->add_responsive_control(
                'main_menu_padding',
                array(
                    'label'      => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%' ),
                    'selectors'  => array(
                        '{{WRAPPER}} .htmega-menu-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
                )
            );

            $this->add_responsive_control(
                'main_menu_border_radius',
                array(
                    'label'      => __( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%' ),
                    'selectors'  => array(
                        '{{WRAPPER}} .htmega-menu-area' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                array(
                    'name'        => 'main_menu_border',
                    'label'       => __( 'Border', 'ht-mega-for-elementor' ),
                    'placeholder' => '1px',
                    'default'     => '1px',
                    'selector'    => '{{WRAPPER}} .htmega-menu-area',
                )
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                array(
                    'name'     => 'main_menu_box_shadow',
                    'selector' => '{{WRAPPER}} .htmega-menu-area',
                )
            );

            $this->add_responsive_control(
                'main_menu_alignment',
                array(
                    'label'   => __( 'Alignment', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => array(
                        'left'    => array(
                            'title' => __( 'Left', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-h-align-left',
                        ),
                        'center' => array(
                            'title' => __( 'Center', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-h-align-center',
                        ),
                        'right' => array(
                            'title' => __( 'Right', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-h-align-right',
                        ),
                    ),
                    'selectors_dictionary' => array(
                        'left'   => 'justify-content: start;',
                        'center' => 'justify-content: center;',
                        'right'  => 'justify-content: end;',
                    ),
                    'selectors'  => array(
                        '{{WRAPPER}} .htmega-menu-container ul' => '{{VALUE}}',
                    ),
                )
            );

        $this->end_controls_section();

        // Sub Menu Style
        $this->start_controls_section(
            'section_sub_menu_style',
            array(
                'label'      => __( 'Sub Menu', 'ht-mega-for-elementor' ),
                'tab'        => Controls_Manager::TAB_STYLE,
            )
        );
            
            $this->add_responsive_control(
                'sub_menu_width',
                array(
                    'label' => __( 'Sub Menu Width', 'ht-mega-for-elementor' ),
                    'type'  => Controls_Manager::SLIDER,
                    'size_units' => array(
                        '%', 'px',
                    ),
                    'range' => array(
                        '%' => array(
                            'min' => 10,
                            'max' => 100,
                        ),
                        'px' => array(
                            'min' => 100,
                            'max' => 1500,
                        ),
                    ),
                    'default' => array(
                        'unit' => 'px',
                        'size' => 250,
                    ),
                    'selectors'  => array(
                        '{{WRAPPER}} .htmega-menu-area .sub-menu' => 'min-width: {{SIZE}}{{UNIT}}',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                array(
                    'name'     => 'sub_menu_background',
                    'selector' => '{{WRAPPER}} .htmega-menu-area .sub-menu',
                )
            );

            $this->add_responsive_control(
                'sub_menu_padding',
                array(
                    'label'      => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%' ),
                    'selectors'  => array(
                        '{{WRAPPER}} .htmega-menu-area .sub-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
                )
            );

            $this->add_responsive_control(
                'sub_menu_border_radius',
                array(
                    'label'      => __( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%' ),
                    'selectors'  => array(
                        '{{WRAPPER}} .htmega-menu-area .sub-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                array(
                    'name'        => 'sub_menu_border',
                    'label'       => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector'    => '{{WRAPPER}} .htmega-menu-area .sub-menu',
                )
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                array(
                    'name'     => 'sub_menu_box_shadow',
                    'selector' => '{{WRAPPER}} .htmega-menu-area .sub-menu',
                )
            );

            $this->add_responsive_control(
                'sub_menu_items_padding',
                array(
                    'label'      => __( 'Item Padding', 'ht-mega-for-elementor' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%' ),
                    'selectors'  => array(
                        '{{WRAPPER}} .htmega-menu-area ul > li > ul.sub-menu li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
                )
            );

            $this->add_control(
                'sub_menu_items_color',
                array(
                    'label'     => __( 'Text Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .htmega-menu-area ul > li > ul.sub-menu li a' => 'color: {{VALUE}}',
                    ),
                    'separator' =>'before'
                )
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'     => 'sub_menu_items_typography',
                    'selector' => '{{WRAPPER}} .htmega-menu-area ul > li > ul.sub-menu li a',
                )
            );

            $this->add_control(
                'sub_menu_items_hover_color',
                array(
                    'label'     => __( 'Hover Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .htmega-menu-area ul > li > ul.sub-menu li a:hover' => 'color: {{VALUE}}',
                    ),
                )
            );

        $this->end_controls_section();

        // Mega Menu Style
        $this->start_controls_section(
            'section_mega_menu_style',
            array(
                'label'      => __( 'Mega Menu', 'ht-mega-for-elementor' ),
                'tab'        => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_responsive_control(
                'mega_menu_width_op',
                [
                    'label' => esc_html__( 'Mega Menu Width', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'custom',
                    'options' => [
                        'inherit' => esc_html__( 'Default', 'ht-mega-for-elementor' ),
                        'fullwidth' => esc_html__( 'Full Width', 'ht-mega-for-elementor' ) . ' (100%)',
                        'custom' => esc_html__( 'Custom', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'menu_full_width_hidden',
                [
                    'label' => esc_html__( 'Full Width', 'ht-mega-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::HIDDEN,
                    'default' => 'traditional',
                    'condition' => [
                        'mega_menu_width_op' => 'fullwidth',
                    ],
                    'selectors'  => array(
                        '{{WRAPPER}} .htmega-megamenu li.htmega_mega_menu' => 'position:static;',
                        '{{WRAPPER}} .htmega-menu-area .htmegamenu-content-wrapper' => 'min-width: 100vw;left:50%!important;transform:translateX(-50%);',
                    ),
                ]
            );
            $this->add_responsive_control(
                'mega_menu_width',
                array(
                    'label' => __( 'Width', 'ht-mega-for-elementor' ),
                    'type'  => Controls_Manager::SLIDER,
                    'size_units' => array(
                        '%', 'px',
                    ),
                    'range' => array(
                        '%' => array(
                            'min' => 10,
                            'max' => 100,
                        ),
                        'px' => array(
                            'min' => 100,
                            'max' => 1500,
                        ),
                    ),
                    'default' => array(
                        'unit' => 'px',
                        'size' => 750,
                    ),
                    'selectors'  => array(
                        '{{WRAPPER}} .htmega-menu-area .htmegamenu-content-wrapper' => 'min-width: {{SIZE}}{{UNIT}};max-width: {{SIZE}}{{UNIT}}',
                    ),
                    'condition' => array(
                        'mega_menu_width_op' => 'custom',
                    )
                )
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                array(
                    'name'     => 'mega_menu_background',
                    'selector' => '{{WRAPPER}} .htmega-menu-area .htmegamenu-content-wrapper',
                )
            );

            $this->add_responsive_control(
                'mega_menu_padding',
                array(
                    'label'      => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%' ),
                    'selectors'  => array(
                        '{{WRAPPER}} .htmega-menu-area .htmegamenu-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
                )
            );

            $this->add_responsive_control(
                'mega_menu_border_radius',
                array(
                    'label'      => __( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%' ),
                    'selectors'  => array(
                        '{{WRAPPER}} .htmega-menu-area .htmegamenu-content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                array(
                    'name'        => 'mega_menu_border',
                    'label'       => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector'    => '{{WRAPPER}} .htmega-menu-area .htmegamenu-content-wrapper',
                )
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                array(
                    'name'     => 'mega_menu_box_shadow',
                    'selector' => '{{WRAPPER}} .htmega-menu-area .htmegamenu-content-wrapper',
                )
            );

        $this->end_controls_section();

        // Main Menu Items Style
        $this->start_controls_section(
            'section_main_menu_items_style',
            array(
                'label'      => __( 'Main Menu Items', 'ht-mega-for-elementor' ),
                'tab'        => Controls_Manager::TAB_STYLE,
            )
        );

            $this->start_controls_tabs( 'main_menu_item_style_tabs' );
                
                // Items Normal Tabs
                $this->start_controls_tab(
                    'main_menu_item_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );
                    
                    $this->add_control(
                        'main_menu_items_color',
                        array(
                            'label'     => __( 'Text Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .htmega-menu-area ul > li > a' => 'color: {{VALUE}}',
                                '{{WRAPPER}} .htmega-menu-area ul > li > a > span.htmenu-icon' => 'color: {{VALUE}}',
                            ),
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'     => 'main_menu_items_typography',
                            'selector' => '{{WRAPPER}}  .htmega-menu-area ul.htmega-megamenu > li > a',
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'main_menu_items_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-menu-area ul > li',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        array(
                            'name'     => 'main_menu_items_bg',
                            'selector' => '{{WRAPPER}} .htmega-menu-area ul > li > a',
                            'fields_options' => array(
                                'background' => array(
                                    'default' => 'classic',
                                )
                            ),
                            // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_exclude -- false positive: this is Group_Control_Background's 'exclude' param restricting which background type options (image, position, etc.) appear in the Elementor Style panel, not a WP_Query exclude arg.
                            'exclude' => array(
                                'image',
                                'position',
                                'attachment',
                                'attachment_alert',
                                'repeat',
                                'size',
                            ),
                        )
                    );

                    $this->add_responsive_control(
                        'main_menu_items_padding',
                        array(
                            'label'      => __( 'Padding', 'ht-mega-for-elementor' ),
                            'type'       => Controls_Manager::DIMENSIONS,
                            'size_units' => array( 'px', '%' ),
                            'selectors'  => array(
                                '{{WRAPPER}} .htmega-menu-area ul > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ),
                        )
                    );

                $this->end_controls_tab();
                
                // Items Hover Tabs
                $this->start_controls_tab(
                    'main_menu_item_style_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );
                    
                    $this->add_control(
                        'main_menu_items_hover_color',
                        array(
                            'label'     => __( 'Text Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .htmega-menu-area ul > li > a:hover' => 'color: {{VALUE}}',
                                '{{WRAPPER}} .htmega-menu-area ul > li > a:hover > span.htmenu-icon' => 'color: {{VALUE}}',
                            ),
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'main_menu_items_hover_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-menu-area ul > li:hover',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        array(
                            'name'     => 'main_menu_items_hover_bg',
                            'selector' => '{{WRAPPER}} .htmega-menu-area ul > li > a:hover',
                            'fields_options' => array(
                                'background' => array(
                                    'default' => 'classic',
                                )
                            ),
                            // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_exclude -- false positive: this is Group_Control_Background's 'exclude' param restricting which background type options (image, position, etc.) appear in the Elementor Style panel, not a WP_Query exclude arg.
                            'exclude' => array(
                                'image',
                                'position',
                                'attachment',
                                'attachment_alert',
                                'repeat',
                                'size',
                            ),
                        )
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        //Dropdown Icon Style
        $this->start_controls_section(
            'dorpdown_icon_style',
            array(
                'label'      => __( 'Dropdown Icon', 'ht-mega-for-elementor' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'condition' =>[
                    'dropdown_icon[value]!' => '',
                ]
            )
        );                    
        $this->add_control(
            'dropdown_icon_color',
            array(
                'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .htmega-menu-area ul > li > a > span.htmenu-icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .htmega-menu-area ul > li > a > span.htmenu-icon svg path' => 'fill: {{VALUE}}',
                ),
            )
        );
        $this->add_responsive_control(
            'dropdown_icon_fontsize',
            [
                'label' => __( 'Icon Size', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 14,
                ],
                'selectors' => [
                    '{{WRAPPER}} .htmega-menu-area ul > li > a > span.htmenu-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .htmega-menu-area ul > li > a > span.htmenu-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_inner_space',
            [
                'label' => esc_html__( 'Inner Sapce', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'min' => -100,
                'max' => 100,
                'step' => 1,
                'default' => 5,
                'selectors' => [
                    '{{WRAPPER}} .htmega-menu-area ul > li > a > span.htmenu-icon' => 'margin-left:{{VALUE}}px',
                ],
            ]
        );
        $this->end_controls_section();

        // "Menu Badge" style section (pro-only) is appended here by htmega-pro via the
        // elementor/element/htmega-menu-inline-menu/dorpdown_icon_style/after_section_end
        // hook — see htmega-pro/extensions/ht-menu/widgets/inline-mega-menu-pro.php
        // Button Icon style tab start
        $this->start_controls_section(
            'toggle_button_section',
            [
                'label'     => __( 'Toggle Button', 'ht-mega-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
            $this->add_control(
                'toggle_button_alignment',
                array(
                    'label'   => __( 'Alignment', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => array(
                        'left'    => array(
                            'title' => __( 'Left', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-h-align-left',
                        ),
                        'right' => array(
                            'title' => __( 'Right', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-h-align-right',
                        ),
                    ),
                    'selectors'  => array(
                        '{{WRAPPER}} .htmega-menu-area .htmobile-aside-button' => 'float:{{VALUE}}',
                    ),
                )
            );

            $this->add_control(
                'toggle_button_fontsize',
                [
                    'label' => __( 'Icon Size', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 14,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-menu-area .htmobile-aside-button i' => 'font-size: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .htmega-menu-area .htmobile-aside-button svg' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'toggle_button_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-menu-area .htmobile-aside-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; line-height:0;',
                    ],

                ]
            );

            // Button Icon style tabs start
            $this->start_controls_tabs( 'toggle_button_style_tabs' );

                // Button Icon style normal tab start
                $this->start_controls_tab(
                    'buttonicon_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'htmega_toggle_button_color',
                        [
                            'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-menu-area .htmobile-aside-button i' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-menu-area .htmobile-aside-button svg path' => 'fill: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'toggle_button_background',
                            'label' => __( 'Icon Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-menu-area .htmobile-aside-button',
                            'separator' => 'before',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'toggle_button_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-menu-area .htmobile-aside-button',
                        ]
                    );

                    $this->add_control(
                        'toggle_button_radius',
                        [
                            'label' => __( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-menu-area .htmobile-aside-button' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                            'separator' => 'before',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'toggle_button_shadow',
                            'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-menu-area .htmobile-aside-button',
                        ]
                    );

                $this->end_controls_tab(); // Button Icon style normal tab end

                // Button Icon style Hover tab start
                $this->start_controls_tab(
                    'toggle_button_style_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'toggle_button_hover_color',
                        [
                            'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-menu-area .htmobile-aside-button:hover i' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-menu-area .htmobile-aside-button:hover svg path' => 'fill: {{VALUE}};',
                            ],
                        ]
                    );
                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'toggle_button_border_hover',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-menu-area .htmobile-aside-button:hover',
                        ]
                    );
                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'toggle_button_hover_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-menu-area .htmobile-aside-button:hover',
                        ]
                    );

                $this->end_controls_tab(); // Button Icon style hover tab end

            $this->end_controls_tabs(); // Button Icon style tabs end

        $this->end_controls_section(); // Button Icon style tab end
        // Button Icon style tab start
        $this->start_controls_section(
            'toggle_button_close_section',
            [
                'label'     => __( 'Toggle Close Button', 'ht-mega-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
            $this->add_control(
                'htmega_toggle_close_button_color',
                [
                    'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htmobile-menu-wrap .htmobile-aside-close i' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .htmobile-menu-wrap .htmobile-aside-close svg path' => 'fill: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'toggle_close_button_background',
                    'label' => __( 'Icon Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmobile-menu-wrap .htmobile-aside-close',
                    'separator' => 'before',
                ]
            );

        $this->end_controls_section(); // Button Icon style tab end
        // Mobile Menu Style
        $this->start_controls_section(
            'section_mobile_menu_items_style',
            array(
                'label'      => __( 'Mobile Menu', 'ht-mega-for-elementor' ),
                'tab'        => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_control(
                'mobile_menu_items_color',
                array(
                    'label'     => __( 'Text Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .htmobile-menu-wrap .htmobile-navigation .htmega-megamenu > li > a,
                        {{WRAPPER}} .htmobile-menu-wrap .htmobile-navigation .sub-menu > li > a' => 'color: {{VALUE}}',
                    ),
                )
            );
            $this->add_control(
                'mobile_menu_items_hover_color',
                array(
                    'label'     => __( 'Text Hover Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .htmobile-menu-wrap .htmobile-navigation .htmega-megamenu > li:hover > a,
                        {{WRAPPER}} .htmobile-menu-wrap .htmobile-navigation .sub-menu > li:hover > a' => 'color: {{VALUE}}',
                    ),
                )
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'     => 'mobile_menu_items_typography',
                    'selector' => '{{WRAPPER}} .htmobile-menu-wrap .htmobile-navigation .htmega-megamenu > li > a,
                    {{WRAPPER}} .htmobile-menu-wrap .htmobile-navigation .sub-menu > li > a',
                )
            );

            $this->add_control(
                'mobile_expand_color',
                array(
                    'label'     => __( 'Expand Icon Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .htmobile-menu-wrap .menu-expand i'=>'color: {{VALUE}}',
                    ),
                )
            );
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'shtmobile_menu_wrap_bg',
                    'label' => __( 'Icon Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmobile-menu-wrap',
                ]
            );
        $this->end_controls_section();
    }
    
    protected function render( $instance = [] ) {

        $settings  = $this->get_settings_for_display();

        $wrapper_class = 'htmega-menu-container';
        
        if( isset( $settings['mega_menu_width']['unit'] ) && '%' ==  $settings['mega_menu_width']['unit'] ){
            $wrapper_class .= ' htmega-parent-list-static';
        }
        
        if ( ! $settings['menu'] ) {
            return;
        }

        $htmega_on_mobile = '<a href="#" class="htmobile-aside-button"><i class="fa fa-bars"></i></a>';
            $htmega_on_mobile_menu = '<div class="htmobile-menu-wrap"><a class="htmobile-aside-close"><i class="fa fa-times"></i></a><div class="htmobile-navigation"><ul id="%1$s" class="%2$s">%3$s</ul></div></div>';

        $items_wrap = '<div class="htmega-menu-area"><ul id="%1$s" class="%2$s">%3$s</ul>'.$htmega_on_mobile.'</div>'.$htmega_on_mobile_menu;

        $args = array(
            'menu'            => $settings['menu'],
            'fallback_cb'     => '',
            'container'       => 'div',
            'container_class' => $wrapper_class,
            'menu_class'      => 'htmega-megamenu',
            'items_wrap'      => $items_wrap,
            'walker'          => new \HTMega_Menu_Nav_Walker(),
            'extra_menu_settings' => array(
                'dropdown_icon' => HTMega_Icon_manager::render_icon( $settings['dropdown_icon'] ),
           ),
        );

        wp_nav_menu( $args );

    }

}

htmega_widget_register_manager( new HTMegaMenu_Inline_Menu() );
