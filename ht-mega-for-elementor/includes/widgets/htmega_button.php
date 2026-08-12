<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_Button extends Widget_Base {

    public function get_name() {
        return 'htmega-button-addons';
    }
    
    public function get_title() {
        return __( 'Button', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-button';
    }

    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_script_depends() {
        return ['counterup', 'htmega-admin'];
    }
    public function get_keywords() {
        return ['button', 'buttons', 'button animation','creative button', 'htmega', 'ht mega', 'addons'];
    }

    public function get_help_url() {
        return 'https://wphtmega.com/docs/general-widgets/button-widget/';
    }
    protected function is_dynamic_content():bool {
		return false;
	}
    protected function register_controls() {
        
        $this->start_controls_section(
            'button_content',
            [
                'label' => __( 'Button', 'ht-mega-for-elementor' ),
            ]
        );

            $this->add_control(
                'button_style',
                [
                    'label'   => __( 'Button Style', 'ht-mega-for-elementor' ),
                    'type'    => 'htmega-preset-select',
                    'default' => '1',
                    'options' => [
                        '1'   => __( 'Style One', 'ht-mega-for-elementor' ),
                        '2'   => __( 'Style Two', 'ht-mega-for-elementor' ),
                        '3'   => __( 'Style Three', 'ht-mega-for-elementor' ),
                        '4'   => __( 'Style Four', 'ht-mega-for-elementor' ),
                    ]
                ]
            );


            $this->add_control(
                'button_text',
                [
                    'label' => __( 'Text', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => __( 'Enter your Text', 'ht-mega-for-elementor' ),
                    'default' => __( 'Click Me', 'ht-mega-for-elementor' ),
                    'title' => __( 'Enter your Text', 'ht-mega-for-elementor' ),
                ]
            );

            $this->add_control(
                'button_link',
                [
                    'label' => __( 'Link', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::URL,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'placeholder' => __( 'https://your-link.com', 'ht-mega-for-elementor' ),
                    'default' => [
                        'url' => '#',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'button_size',
                [
                    'label'   => __( 'Button Size', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'md',
                    'options' => [
                        'sm' => __( 'Small', 'ht-mega-for-elementor' ),
                        'md' => __( 'Medium', 'ht-mega-for-elementor' ),
                        'lg' => __( 'Large', 'ht-mega-for-elementor' ),
                        'xl' => __( 'Extra Large', 'ht-mega-for-elementor' ),
                        'xs' => __( 'Extra Small', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'button_icon',
                [
                    'label'       => __( 'Icon', 'ht-mega-for-elementor' ),
                    'type'        => Controls_Manager::ICONS,
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'button_icon_align',
                [
                    'label'   => __( 'Icon Position', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'right',
                    'options' => [
                        'left'   => __( 'Left', 'ht-mega-for-elementor' ),
                        'right'  => __( 'Right', 'ht-mega-for-elementor' ),
                        'top'    => __( 'Top', 'ht-mega-for-elementor' ),
                        'bottom' => __( 'Bottom', 'ht-mega-for-elementor' ),
                    ],
                    'condition' => [
                        'button_icon!' => '',
                    ],
                ]
            );

            $this->add_control(
                'icon_specing',
                [
                    'label' => __( 'Icon Spacing', 'ht-mega-for-elementor' ),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 150,
                        ],
                    ],
                    'default' => [
                        'size' => 8,
                    ],
                    'condition' => [
                        'button_icon!' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .button-align-icon-right .htmega_button_icon'  => 'margin-left: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .button-align-icon-left .htmega_button_icon'   => 'margin-right: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .button-align-icon-top .htmega_button_icon'    => 'margin-bottom: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .button-align-icon-bottom .htmega_button_icon' => 'margin-top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'buttonalign',
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
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_section();

        // Style tab section
        $this->start_controls_section(
            'htmega_button_style_section',
            [
                'label' => __( 'Button Style', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->start_controls_tabs('button_style_tabs');

                // Button Normal tab Start
                $this->start_controls_tab(
                    'button_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );
                    $this->add_control(
                        'htmega_button_text_color',
                        [
                            'label'     => __( 'Text Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'default'   => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .htmega-button .htb-btn' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'button_typography',
                            'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-button .htb-btn',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'button_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-button .htb-btn',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_border_radius',
                        [
                            'label' => __( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-button .htb-btn, {{WRAPPER}} .htmega-button .htb-btn::before' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'button_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'fields_options'=>[
                                'background'=>[
                                    'default'=>'classic',
                                ],
                                'color'=>[
                                    'default'=>'#000000',
                                ],
                            ],
                            'selector' => '{{WRAPPER}} .htmega-button .htb-btn',
                            'separator' => 'before',
                        ]
                    );

                    $this->add_control(
                        'button_second_background_heading',
                        [
                            'label' => __( 'Second Background', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::HEADING,
                            'separator' => 'before'
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'button_second_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'fields_options'=>[
                                'background'=>[
                                    'default'=>'classic',
                                ]
                            ],
                            'selector' => '{{WRAPPER}} .htmega-btn-style-2 .htb-btn::after',
                            'condition' => array(
                                'button_style'  => '2'
                            )
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'box_shadow',
                            'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-button .htb-btn',
                            'separator' => 'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_padding',
                        [
                            'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-button .htb-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                            ],
                            'separator' => 'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_margin',
                        [
                            'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-button .htb-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' => 'before',
                        ]
                    );

                $this->end_controls_tab(); // Button Normal tab end

                // Button Hover tab start
                $this->start_controls_tab(
                    'button_style_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'htmega_buttonhover_text_color',
                        [
                            'label'     => __( 'Text Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-button .htb-btn:hover' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'buttonhover_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-button .htb-btn:hover',
                        ]
                    );

                    $this->add_responsive_control(
                        'buttonhover_border_radius',
                        [
                            'label' => __( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-button .htb-btn:hover, {{WRAPPER}} .htmega-button .htb-btn:hover:before' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'buttonhover_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-button .htb-btn:hover,{{WRAPPER}} .htmega-button .htb-btn:hover:before',
                            'separator' => 'before',
                        ]
                    );

                    $this->add_control(
                        'buttonhover_second_background_heading',
                        [
                            'label' => __( 'Second Background', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::HEADING,
                            'separator' => 'before'
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'buttonhover_second_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'fields_options'=>[
                                'background'=>[
                                    'default'=>'classic',
                                ]
                            ],
                            'selector' => '{{WRAPPER}} .htmega-btn-style-1 .htb-btn:hover::after',
                            'condition' => array(
                                'button_style'  => '2'
                            )
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'boxhover_shadow',
                            'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-button .htb-btn:hover',
                        ]
                    );

                    $this->add_control(
                        'button_effect',
                        [
                            'label'   => __( 'Button Hover Effect', 'ht-mega-for-elementor' ),
                            'type'    => Controls_Manager::SELECT,
                            'default' => '1',
                            'options' => [
                                '0' => __( 'None', 'ht-mega-for-elementor' ),
                                '1' => __( 'Effect 1', 'ht-mega-for-elementor' ),
                                '2' => __( 'Effect 2', 'ht-mega-for-elementor' ),
                                '3' => __( 'Effect 3', 'ht-mega-for-elementor' ),
                                '4' => __( 'Effect 4', 'ht-mega-for-elementor' ),
                                '5' => __( 'Effect 5', 'ht-mega-for-elementor' ),
                                '6' => __( 'Effect 6', 'ht-mega-for-elementor' ),
                                '7' => __( 'Effect 7', 'ht-mega-for-elementor' ),
                                '8' => __( 'Effect 8', 'ht-mega-for-elementor' ),
                                '9' => __( 'Effect 9', 'ht-mega-for-elementor' ),
                                '10' => __( 'Effect 10', 'ht-mega-for-elementor' ),
                                '11' => __( 'Effect 11', 'ht-mega-for-elementor' ),
                                '12' => __( 'Effect 12', 'ht-mega-for-elementor' ),
                                '13' => __( 'Effect 13', 'ht-mega-for-elementor' ),
                                '14' => __( 'Effect 14', 'ht-mega-for-elementor' ),
                            ],
                        ]
                    );

                    $this->add_control(
                        'button_effect_hover_before_color_heading',
                        [
                            'label' => __( 'Effect Before Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::HEADING,
                            'separator' => 'before'
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'button_effect_hover_before_color',
                            'label' => __( 'Effect Before Color', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} [class*="htmega-btn-effect-"]::before',
                        ]
                    );

                    $this->add_control(
                        'button_effect_hover_after_color_heading',
                        [
                            'label' => __( 'Effect After Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::HEADING,
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'button_effect_hover_after_color',
                            'label' => __( 'Effect Before Color', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} [class*="htmega-btn-effect-"]::after',
                        ]
                    );                    

                    $this->add_control(
                        'button_shadow',
                        [
                            'label'   => __( 'Button Hover Shadow', 'ht-mega-for-elementor' ),
                            'type'    => Controls_Manager::SELECT,
                            'default' => '0',
                            'options' => [
                                '0' => __( 'None', 'ht-mega-for-elementor' ),
                                '1' => __( 'Shadow 1', 'ht-mega-for-elementor' ),
                                '2' => __( 'Shadow 2', 'ht-mega-for-elementor' ),
                            ],
                            'separator' => 'before'
                        ]
                    );

                    $this->add_control(
                        'button_hover_animation',
                        [
                            'label' => __( 'Hover Animation', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::HOVER_ANIMATION,
                        ]
                    );

                $this->end_controls_tab(); // Button Hover tab end

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Button Icon style tab start
        $this->start_controls_section(
            'htmega_button_icon_style_section',
            [
                'label'     => __( 'Icon Style', 'ht-mega-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'button_icon!' => '',
                ],
            ]
        );

            // Button Icon style tabs start
            $this->start_controls_tabs( 'button_icon_style_tabs' );

                // Button Icon style normal tab start
                $this->start_controls_tab(
                    'buttonicon_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'htmega_button_icon_color',
                        [
                            'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-button .htb-btn .htmega_button_icon' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-button .htb-btn .htmega_button_icon svg path' => 'fill: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'button_icon_background',
                            'label' => __( 'Icon Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-button .htb-btn .htmega_button_icon',
                            'separator' => 'before',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'buttonicon_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-button .htb-btn .htmega_button_icon',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_bordericon_radius',
                        [
                            'label' => __( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-button .htb-btn .htmega_button_icon' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                            'separator' => 'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_icon_padding',
                        [
                            'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-button .htb-btn .htmega_button_icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' => 'before',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'button_icon_typography',
                            'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-button .htb-btn .htmega_button_icon',
                            'fields_options'=>[
                                'font_size' => [
                                    'selectors' => [
                                        '{{WRAPPER}} .htmega-button .htb-btn .htmega_button_icon' => 'font-size: {{SIZE}}{{UNIT}}',
                                        '{{WRAPPER}} .htmega-button .htb-btn .htmega_button_icon svg' => 'width: {{SIZE}}{{UNIT}}',
                                    ],
                                ]
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'icon_box_shadow',
                            'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-button .htb-btn .htmega_button_icon',
                        ]
                    );

                $this->end_controls_tab(); // Button Icon style normal tab end

                // Button Icon style Hover tab start
                $this->start_controls_tab(
                    'buttonicon_style_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'htmega_button_iconhover_color',
                        [
                            'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-button .htb-btn:hover .htmega_button_icon' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-button .htb-btn:hover .htmega_button_icon svg path' => 'fill: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'button_iconhover_background',
                            'label' => __( 'Icon Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-button .htb-btn:hover .htmega_button_icon',
                            'separator' => 'before',
                        ]
                    );

                $this->end_controls_tab(); // Button Icon style hover tab end

            $this->end_controls_tabs(); // Button Icon style tabs end

        $this->end_controls_section(); // Button Icon style tab end

    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        $this->add_render_attribute( 'htmega_button', 'class', 'htmega-button' );
        $this->add_render_attribute( 'htmega_button', 'class', 'htmega-btn-style-'. esc_attr( $settings['button_style'] ) );
        $this->add_render_attribute( 'htmega_button', 'class', 'htmega-btn-shadow-'. esc_attr( $settings['button_shadow'] ) );
        
        if( !empty( $settings['button_icon']['value'] ) ){
            $this->add_render_attribute( 'htmega_button', 'class', 'button-align-icon-'. esc_attr( $settings['button_icon_align'] ) );
        }

        $button_text  = ! empty( $settings['button_text'] ) ? wp_kses_post( $settings['button_text'] ) : '';
        $button_icon  = ! empty( $settings['button_icon']['value'] ) ? HTMega_Icon_manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ) : '';

        // URL Generate
        if ( ! empty( $settings['button_link']['url'] ) ) {
            
            $this->add_link_attributes( 'url', $settings['button_link'] );

            $this->add_render_attribute( 'url', 'class', 'htb-btn' );
            $this->add_render_attribute( 'url', 'class', 'htmega-btn-size-'. esc_attr( $settings['button_size'] ) );
            $this->add_render_attribute( 'url', 'class', 'htmega-btn-effect-'. esc_attr( $settings['button_effect'] ) );

            if ( $settings['button_hover_animation'] ) {
                $this->add_render_attribute( 'url', 'class', 'elementor-animation-' . esc_attr( $settings['button_hover_animation'] ) );
            }

            $button_text = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'url' ), $button_text );
        }

        if( !empty( $settings['button_icon']['value'] ) ){
            $button_text = sprintf( '<a %1$s><span class="htmega_button_txt">%2$s</span><span class="htmega_button_icon">%3$s</span></a>', $this->get_render_attribute_string( 'url' ), htmega_kses_desc( $settings['button_text'] ), $button_icon );
        }
        if( !empty( $button_text ) ){
            printf( '<div %1$s>%2$s</div>', $this->get_render_attribute_string( 'htmega_button' ), $button_text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }
}
