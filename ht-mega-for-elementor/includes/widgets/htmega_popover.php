<?php
namespace Elementor;

// Elementor Classes
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_Popover extends Widget_Base {

    public function get_name() {
        return 'htmega-popover-addons';
    }
    
    public function get_title() {
        return __( 'Popover', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-info-box';
    }

    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_keywords() {
        return ['popover', 'tooltip', 'pop over', 'popovers', 'htmega', 'ht mega', 'addons','widget'];
    }

    public function get_help_url() {
        return 'https://wphtmega.com/docs/creative-widgets/popover-widget/';
    }
    protected function is_dynamic_content():bool {
		return false;
	}
    protected function register_controls() {

        $this->start_controls_section(
            'popover_content',
            [
                'label' => __( 'Popover Button', 'ht-mega-for-elementor' ),
            ]
        );
            $this->add_responsive_control(
                'popover_button_type',
                [
                    'label' => esc_html__( 'Button Type', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'label_block' => false,
                    'options' => [
                        'icon' => [
                            'title' => esc_html__( 'Icon', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-info-circle',
                        ],
                        'text' => [
                            'title' => esc_html__( 'Text', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-animation-text',
                        ],
                        'image' => [
                            'title' => esc_html__( 'Image', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-image-bold',
                        ],
                    ],
                    'default' => 'text',
                ]
            );

            $this->add_control(
                'popover_button_txt',
                [
                    'label' => esc_html__( 'Button Text', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'label_block' => true,
                    'default' => esc_html__( 'Popover', 'ht-mega-for-elementor' ),
                    'condition' => [
                        'popover_button_type' => [ 'text' ]
                    ],
                    'dynamic' => [ 'active' => true ]
                ]
            );

            $this->add_control(
                'popover_button_icon',
                [
                    'label' => esc_html__( 'Icon', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value'=>'fas fa-home',
                        'library' => 'fa-solid',
                    ],
                    'condition' => [
                        'popover_button_type' => [ 'icon' ]
                    ]
                ]
            );

            $this->add_control(
                'popover_button_img',
                [
                    'label' => __('Image','ht-mega-for-elementor'),
                    'type'=>Controls_Manager::MEDIA,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'condition' => [
                        'popover_button_type' => [ 'image' ]
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'popover_button_imgsize',
                    'default' => 'large',
                    'separator' => 'none',
                    'condition' => [
                        'popover_button_type' => [ 'image' ]
                    ]
                ]
            );

            $this->add_control(
                'show_link',
                [
                    'label' => __( 'Show Link', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Hide', 'ht-mega-for-elementor' ),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $this->add_control(
                'button_link',
                [
                    'label' => __( 'Link', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::URL,
                    'placeholder' => __( 'https://your-link.com', 'ht-mega-for-elementor' ),
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                    'condition'=>[
                        'show_link'=>'yes',
                    ]
                ]
            );

        $this->end_controls_section();

        // Popover options
        $this->start_controls_section(
            'popover_options',
            [
                'label' => __( 'Popover Options', 'ht-mega-for-elementor' ),
            ]
        );
            $this->add_control(
                'popover_text',
                [
                    'label' => esc_html__( 'Popover Text', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'label_block' => true,
                    'default' => esc_html__( 'Popover content Here', 'ht-mega-for-elementor' ),
                    'dynamic' => [ 'active' => true ]
                ]
            );

            $this->add_control(
                'popover_header_text',
                [
                    'label' => esc_html__( 'Popover Header Text', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'label_block' => true,
                    'default' => esc_html__( 'Popover Header Here', 'ht-mega-for-elementor' ),
                    'dynamic' => [ 'active' => true ]
                ]
            );

            $this->add_control(
              'popover_dir',
                [
                    'label'         => esc_html__( 'Direction', 'ht-mega-for-elementor' ),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'right',
                    'label_block'   => false,
                    'options'       => [
                        'left'      => esc_html__( 'Left', 'ht-mega-for-elementor' ),
                        'right'     => esc_html__( 'Right', 'ht-mega-for-elementor' ),
                        'top'       => esc_html__( 'Top', 'ht-mega-for-elementor' ),
                        'bottom'    => esc_html__( 'Bottom', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'show_popover',
                [
                    'label' => __( 'Active', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Hide', 'ht-mega-for-elementor' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_responsive_control(
                'popover_space',
                [
                    'label' => __( 'Space With Button', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1200,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 12,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htb-bs-popover-auto[x-placement^=top]' => 'top: -{{SIZE}}{{UNIT}} !important;',
                        '{{WRAPPER}} .htb-bs-popover-top' => 'top: -{{SIZE}}{{UNIT}} !important;',
                        '{{WRAPPER}} .htb-bs-popover-auto[x-placement^=bottom]' => 'top: {{SIZE}}{{UNIT}} !important;',
                        '{{WRAPPER}} .htb-bs-popover-bottom' => 'top: {{SIZE}}{{UNIT}} !important;',
                        '{{WRAPPER}} .htb-bs-popover-auto[x-placement^=right]' => 'left: {{SIZE}}{{UNIT}} !important;',
                        '{{WRAPPER}} .htb-bs-popover-right' => 'left: {{SIZE}}{{UNIT}} !important;',
                        '{{WRAPPER}} .htb-bs-popover-auto[x-placement^=left]' => 'left: {{SIZE}}{{UNIT}} !important;',
                        '{{WRAPPER}} .htb-bs-popover-left' => 'left: -{{SIZE}}{{UNIT}} !important;',
                    ],
                ]
            );

        $this->end_controls_section();

        // Style tab section
        $this->start_controls_section(
            'popover_style_section',
            [
                'label' => __( 'Style', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
                'popover_style_section_align',
                [
                    'label' => __( 'Alignment', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-justify',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-popover' => 'text-align: {{VALUE}};',
                    ],
                    'default' => 'center',
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'popover_style_section_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-popover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'popover_style_section_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-popover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );
            
        $this->end_controls_section();

        // Button Style tab section
        $this->start_controls_section(
            'popover_button_section',
            [
                'label' => __( 'Button', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->start_controls_tabs('button_style_tabs');

                $this->start_controls_tab(
                    'button_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );
                    $this->add_control(
                        'button_color',
                        [
                            'label' => __( 'Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .htmega-popover span' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-popover span a' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-popover span svg path,{{WRAPPER}} .htmega-popover span a svg path' => 'fill: {{VALUE}}; transition:all 0.3s ease-in-out;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'button_typography',
                            'selector' => '{{WRAPPER}} .htmega-popover span',
                            'condition'=>[
                                'popover_button_type'=>'text',
                            ]
                        ]
                    );

                    $this->add_control(
                        'button_icon_fontsize',
                        [
                            'label' => __( 'Icon Size', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 100,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 20,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-popover span i' => 'font-size: {{SIZE}}{{UNIT}};',
                                '{{WRAPPER}} .htmega-popover span svg' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                            'condition'=>[
                                'popover_button_type'=>'icon',
                                'popover_button_icon[value]!'=>'',
                            ]
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'button_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-popover span',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'button_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-popover span',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-popover span' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'button_margin',
                        [
                            'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-popover span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_padding',
                        [
                            'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-popover span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                $this->end_controls_tab(); // Normal tab end

                // Hover Tab start
                $this->start_controls_tab(
                    'button_style_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );
                    $this->add_control(
                        'button_hover_color',
                        [
                            'label' => __( 'Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .htmega-popover span:hover' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-popover span:hover svg path' => 'fill: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'button_hover_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-popover span:hover',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'button_hover_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-popover span:hover',
                        ]
                    );

                $this->end_controls_tab();// Hover tab end

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Popover Style tab section
        $this->start_controls_section(
            'hover_popover_style_section',
            [
                'label' => __( 'Popover', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->start_controls_tabs('hover_popover_style_tabs');

                $this->start_controls_tab(
                    'hover_popover_area_tab',
                    [
                        'label' => __( 'Area', 'ht-mega-for-elementor' ),
                    ]
                );
                    $this->add_responsive_control(
                        'hover_popover_area_width',
                        [
                            'label' => __( 'Width', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1200,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 330,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htb-popover' => 'max-width: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'hover_popover_area_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htb-popover',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'hover_popover_area_box_shadow',
                            'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htb-popover',
                            'separator'=>'before',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'hover_popover_area_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htb-popover',
                        ]
                    );

                    $this->add_responsive_control(
                        'hover_popover_area_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htb-popover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Header area tab
                $this->start_controls_tab(
                    'hover_popover_header_tab',
                    [
                        'label' => __( 'Header', 'ht-mega-for-elementor' ),
                        'condition'=>[
                            'popover_header_text!'=>'',
                        ],
                    ]
                );
                    
                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'hover_popover_header_typography',
                            'selector' => '{{WRAPPER}} .htb-popover .htb-popover-header',
                        ]
                    );

                    $this->add_control(
                        'hover_popover_header_color',
                        [
                            'label' => __( 'Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#262626',
                            'selectors' => [
                                '{{WRAPPER}} .htb-popover .htb-popover-header' => 'color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'hover_popover_header_padding',
                        [
                            'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htb-popover .htb-popover-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'hover_popover_header_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htb-popover .htb-popover-header',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'hover_popover_header_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htb-popover .htb-popover-header',
                        ]
                    );

                    $this->add_responsive_control(
                        'hover_popover_header_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htb-popover .htb-popover-header' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'hover_popover_header_align',
                        [
                            'label' => __( 'Alignment', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::CHOOSE,
                            'options' => [
                                'left' => [
                                    'title' => __( 'Left', 'ht-mega-for-elementor' ),
                                    'icon' => 'eicon-text-align-left',
                                ],
                                'center' => [
                                    'title' => __( 'Center', 'ht-mega-for-elementor' ),
                                    'icon' => 'eicon-text-align-center',
                                ],
                                'right' => [
                                    'title' => __( 'Right', 'ht-mega-for-elementor' ),
                                    'icon' => 'eicon-text-align-right',
                                ],
                                'justify' => [
                                    'title' => __( 'Justified', 'ht-mega-for-elementor' ),
                                    'icon' => 'eicon-text-align-justify',
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htb-popover .htb-popover-header' => 'text-align: {{VALUE}};',
                            ],
                            'default' => 'left',
                            'separator' =>'before',
                        ]
                    );

                $this->end_controls_tab();

                // Content area tab
                $this->start_controls_tab(
                    'hover_popover_content_tab',
                    [
                        'label' => __( 'Content', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'hover_popover_content_typography',
                            'selector' => '{{WRAPPER}} .htb-popover .htb-popover-body',
                        ]
                    );

                    $this->add_control(
                        'hover_popover_content_color',
                        [
                            'label' => __( 'Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#262626',
                            'selectors' => [
                                '{{WRAPPER}} .htb-popover .htb-popover-body' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'hover_popover_content_padding',
                        [
                            'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htb-popover .htb-popover-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'hover_popover_content_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htb-popover .htb-popover-body',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'hover_popover_content_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htb-popover .htb-popover-body',
                        ]
                    );

                    $this->add_responsive_control(
                        'hover_popover_content_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htb-popover .htb-popover-body' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'hover_popover_content_align',
                        [
                            'label' => __( 'Alignment', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::CHOOSE,
                            'options' => [
                                'left' => [
                                    'title' => __( 'Left', 'ht-mega-for-elementor' ),
                                    'icon' => 'eicon-text-align-left',
                                ],
                                'center' => [
                                    'title' => __( 'Center', 'ht-mega-for-elementor' ),
                                    'icon' => 'eicon-text-align-center',
                                ],
                                'right' => [
                                    'title' => __( 'Right', 'ht-mega-for-elementor' ),
                                    'icon' => 'eicon-text-align-right',
                                ],
                                'justify' => [
                                    'title' => __( 'Justified', 'ht-mega-for-elementor' ),
                                    'icon' => 'eicon-text-align-justify',
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htb-popover .htb-popover-body' => 'text-align: {{VALUE}};',
                            ],
                            'default' => 'left',
                            'separator' =>'before',
                        ]
                    );

                $this->end_controls_tab();

                // Arrow area tab
                $this->start_controls_tab(
                    'hover_popover_arrow_tab',
                    [
                        'label' => __( 'Arrow', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'hover_popover_arrow_color',
                        [
                            'label' => __( 'Arrow Border Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#e0e0e0',
                            'selectors' => [
                                '{{WRAPPER}} .htb-bs-popover-auto[x-placement^=top] .htb-arrow::before' => 'border-top-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .htb-bs-popover-top .htb-arrow::before' => 'border-top-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .htb-bs-popover-auto[x-placement^=bottom] .htb-arrow::before' => 'border-bottom-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .htb-bs-popover-bottom .htb-arrow::before' => 'border-bottom-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .htb-bs-popover-auto[x-placement^=left] .htb-arrow::before' => 'border-left-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .htb-bs-popover-left .htb-arrow::before' => 'border-left-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .htb-bs-popover-auto[x-placement^=right] .htb-arrow::before' => 'border-right-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .htb-bs-popover-right .htb-arrow::before' => 'border-right-color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                    $this->add_control(
                        'hover_popover_arrow_bg_color',
                        [
                            'label' => __( 'Arrow Background Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .htb-popover.htb-bs-popover-auto[x-placement^="top"] .htb-arrow::after' => 'border-top-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .htb-popover.htb-bs-popover-top .htb-arrow::after' => 'border-top-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .htb-popover.htb-bs-popover-auto[x-placement^="bottom"] .htb-arrow::after' => 'border-top-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .htb-popover.htb-bs-popover-bottom .htb-arrow::after' => 'border-bottom-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .htb-popover.htb-bs-popover-auto[x-placement^="left"] .htb-arrow::after' => 'border-left-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .htb-popover.htb-bs-popover-left .htb-arrow::after' => 'border-left-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .htb-popover.htb-bs-popover-auto[x-placement^="right"] .htb-arrow::after' => 'border-right-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .htb-popover.htb-bs-popover-right .htb-arrow::after' => 'border-right-color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        $id = $this->get_id();
        $this->add_render_attribute( 'htmega_popover_attr', 'class', 'htmega-popover htmega-popover-container-'.$id );

        ?>
            
            <div <?php echo $this->get_render_attribute_string( 'htmega_popover_attr' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string(). ?>>
                <?php
                    $button_txt = $active_class = '';
                    if( isset( $settings['popover_button_txt'] ) ){
                        $button_txt = wp_kses_post( $settings['popover_button_txt'] );
                    }
                    if( isset( $settings['popover_button_icon']['value'] ) ){
                        $button_txt = HTMega_Icon_manager::render_icon( $settings['popover_button_icon'], [ 'aria-hidden' => 'true' ] );
                    }
                    if( isset( $settings['popover_button_img']['url'] ) ){
                        $button_txt = Group_Control_Image_Size::get_attachment_image_html( $settings, 'popover_button_imgsize', 'popover_button_img' );
                    }
                    if( $settings['show_popover'] == 'yes' ){
                        $active_class = 'show';
                    }

                    // Button Generate
                    if ( isset(  $settings['button_link']['url'] ) && ! empty( $settings['button_link']['url'] ) ) {
                        $this->add_render_attribute( 'url', 'href', esc_url( $settings['button_link']['url'] ) );

                        if ( $settings['button_link']['is_external'] ) {
                            $this->add_render_attribute( 'url', 'target', '_blank' );
                        }

                        if ( ! empty( $settings['button_link']['nofollow'] ) ) {
                            $this->add_render_attribute( 'url', 'rel', 'nofollow' );
                        }
                        $button_txt = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'url' ), $button_txt );
                    }
                    echo sprintf('<span class="%1$s" data-container=".htmega-popover-container-%6$s" data-toggle="popover" data-placement="%2$s" data-content="%3$s" title="%4$s">%5$s</span>', esc_attr( $active_class ), esc_attr( $settings['popover_dir'] ), htmega_kses_desc( htmlspecialchars( $settings['popover_text'] ) ), htmega_kses_title( htmlspecialchars( $settings['popover_header_text'] ) ),  $button_txt, esc_attr( $id ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                ?>
            </div>

        <?php

    }

}

