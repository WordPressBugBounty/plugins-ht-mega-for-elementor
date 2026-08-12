<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_Mailchimp_Wp extends Widget_Base {

    public function get_name() {
        return 'htmega-mailchimp-wp-addons';
    }
    
    public function get_title() {
        return esc_html__( 'Mailchimp for wp', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-mailchimp';
    }

    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_keywords() {
        return ['email subscription', 'mailchimp for wp', 'htmega', 'ht mega'];
    }

    public function get_help_url() {
        return 'https://wphtmega.com/docs/3rd-party-plugin-widgets/mailchimp-for-wp-widget/';
    }
    protected function register_controls() {
        if ( ! is_plugin_active('mailchimp-for-wp/mailchimp-for-wp.php') ) {
            $this->messing_parent_plg_notice();
        } else {
            $this->mailchimp_regster_fields();
        }
    }
    protected function messing_parent_plg_notice() {

        $this->start_controls_section(
            'messing_parent_plg_notice_section',
            [
                'label' => esc_html__( 'Mailchimp Wp', 'ht-mega-for-elementor' ),
            ]
        );
            $this->add_control(
                'htmega_plugin_parent_missing_notice',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => sprintf(
                        /* translators: %1$s: plugin name with install/activate link */
                        __( 'It appears that %1$s is not currently installed on your site. Kindly use the link below to install or activate %1$s. After completing the installation or activation, please refresh this page.', 'ht-mega-for-elementor' ),
                        '<a href="' . esc_url( admin_url( 'plugin-install.php?s=Mailchimp%2520Wp&tab=search&type=term' ) ) . '" target="_blank" rel="noopener">Mailchimp Wp</a>'
                    ),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
                ]
            );
        

            $this->add_control(
                'parent_plugin_install',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<a href="' . esc_url( admin_url( 'plugin-install.php?s=Mailchimp%2520Wp&tab=search&type=term' ) ) . '" target="_blank" rel="noopener">' . esc_html__( 'Click to install or activate Mailchimp WP', 'ht-mega-for-elementor' ) . '</a>',
                ]
            );
            
        $this->end_controls_section();

    }
    protected function mailchimp_regster_fields() {

        $this->start_controls_section(
            'htmega_mailchimp',
            [
                'label' => esc_html__( 'Mailchimp', 'ht-mega-for-elementor' ),
            ]
        );
        
            $this->add_control(
                'htmega_mailchimp_form_style',
                [
                    'label' => esc_html__( 'Style', 'ht-mega-for-elementor' ),
                    'type' => 'htmega-preset-select',
                    'default' => '1',
                    'options' => [
                        '1'   => esc_html__( 'Style One', 'ht-mega-for-elementor' ),
                        '2'   => esc_html__( 'Style Two', 'ht-mega-for-elementor' ),
                        '3'   => esc_html__( 'Style Three', 'ht-mega-for-elementor' ),
                        '4'   => esc_html__( 'Style Four', 'ht-mega-for-elementor' ),
                        '5'   => esc_html__( 'Style Five', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'htmega_mailchimp_id',
                [
                    'label'       => esc_html__( 'Mailchimp ID', 'ht-mega-for-elementor' ),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => esc_html__( '294', 'ht-mega-for-elementor' ),
                    'description' => esc_html__( 'For show ID <a href="admin.php?page=mailchimp-for-wp-forms" target="_blank"> Click here </a>', 'ht-mega-for-elementor' ),
                    'label_block' => true,
                    'separator'   => 'before',
                ]
            );

        $this->end_controls_section();

        // Style tab section
        $this->start_controls_section(
            'htmega_mailchimp_section_style',
            [
                'label' => esc_html__( 'Style', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_responsive_control(
                'htmega_mailchimp_section_padding',
                [
                    'label' => esc_html__( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-input-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'htmega_mailchimp_section_margin',
                [
                    'label' => esc_html__( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-input-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'htmega_mailchimp_section_background',
                    'label' => esc_html__( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-input-box',
                ]
            );

            $this->add_responsive_control(
                'htmega_mailchimp_section_align',
                [
                    'label' => esc_html__( 'Alignment', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                        'justify' => [
                            'title' => esc_html__( 'Justified', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-text-align-justify',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-input-box' => 'text-align: {{VALUE}};',
                    ],
                    'default' => 'center',
                    'separator' =>'before',
                ]
            );

        $this->end_controls_section();

        // Input Box style tab start
        $this->start_controls_section(
            'htmega_mailchimp_input_style',
            [
                'label'     => esc_html__( 'Input Box', 'ht-mega-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
                'htmega_input_box_height',
                [
                    'label' => esc_html__( 'Height', 'ht-mega-for-elementor' ),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 150,
                        ],
                    ],
                    'default' => [
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .mc4wp-form input[type*="text"]'  => 'height: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'htmega_input_box_width',
                [
                    'label' => esc_html__( 'Width', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 5,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .mc4wp-form input[type*="text"],
                        {{WRAPPER}} .mc4wp-form input[type*="email"]' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'htmega_input_box_typography',
                    'selector' => '{{WRAPPER}} .mc4wp-form input[type*="email"]',
                ]
            );

            $this->add_control(
                'htmega_input_box_background',
                [
                    'label'     => esc_html__( 'Background Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .mc4wp-form input[type*="text"]'         => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="email"]'        => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .mc4wp-form select[name*="_mc4wp_lists"]' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'htmega_input_box_text_color',
                [
                    'label'     => esc_html__( 'Text Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .mc4wp-form input[type*="text"]'  => 'color: {{VALUE}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'htmega_input_box_placeholder_color',
                [
                    'label'     => esc_html__( 'Placeholder Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .mc4wp-form input[type*="text"]::-webkit-input-placeholder'  => 'color: {{VALUE}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="text"]::-moz-placeholder'  => 'color: {{VALUE}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="text"]:-ms-input-placeholder'  => 'color: {{VALUE}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="email"]::-webkit-input-placeholder' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="email"]::-moz-placeholder' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="email"]:-ms-input-placeholder' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .mc4wp-form select[name*="_mc4wp_lists"]'      => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'htmega_input_box_border',
                    'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .mc4wp-form input[type*="email"]',
                ]
            );

            $this->add_responsive_control(
                'htmega_input_box_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .mc4wp-form input[type*="text"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                        '{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'htmega_input_box_padding',
                [
                    'label' => esc_html__( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .mc4wp-form input[type*="text"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'htmega_input_box_margin',
                [
                    'label' => esc_html__( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .mc4wp-form input[type*="text"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .mc4wp-form input[type*="email"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );
           
        $this->end_controls_section(); // Input box style tab end

        // Input submit button style tab start
        $this->start_controls_section(
            'htmega_mailchimp_inputsubmit_style',
            [
                'label'     => esc_html__( 'Button', 'ht-mega-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->start_controls_tabs('htmega_submit_style_tabs');

                // Button Normal tab start
                $this->start_controls_tab(
                    'htmega_submit_style_normal_tab',
                    [
                        'label' => esc_html__( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_responsive_control(
                        'htmega_input_submit_height',
                        [
                            'label' => esc_html__( 'Height', 'ht-mega-for-elementor' ),
                            'type'  => Controls_Manager::SLIDER,
                            'range' => [
                                'px' => [
                                    'max' => 150,
                                ],
                            ],
                            'default' => [
                                'size' => 40,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .mc4wp-form input[type*="submit"]' => 'height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );
                    
                    $this->add_responsive_control(
                        'htmega_input_submit_width',
                        [
                            'label' => esc_html__( 'Width', 'ht-mega-for-elementor' ),
                            'type'  => Controls_Manager::SLIDER,
                            'range' => [
                                'px' => [
                                    'max' => 150,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .mc4wp-form input[type*="submit"]' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );
                    $this->add_responsive_control(
                        'htmega_input_submit_position',
                        [
                            'label' => esc_html__( 'Position', 'ht-mega-for-elementor' ),
                            'type'  => Controls_Manager::SLIDER,
                            'range' => [
                                'px' => [
                                    'max' => 150,
                                ],
                            ],
                            'default' => [
                                'size' => 20,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-mailchimp-style-4 .htmega-input-box::before' => 'right: {{SIZE}}{{UNIT}};',
                            ],
                            'condition' => [
                                'htmega_mailchimp_form_style' =>'4',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'htmega_input_submit_typography',
                            'selector' => '{{WRAPPER}} .mc4wp-form input[type*="submit"]',
                        ]
                    );

                    $this->add_control(
                        'htmega_input_submit_text_color',
                        [
                            'label'     => esc_html__( 'Text Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .mc4wp-form input[type*="submit"]'  => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'htmega_input_submit_background_color',
                        [
                            'label'     => esc_html__( 'Background Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .mc4wp-form input[type*="submit"]'  => 'background-color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'htmega_input_submit_padding',
                        [
                            'label' => esc_html__( 'Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .mc4wp-form input[type*="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'htmega_input_submit_margin',
                        [
                            'label' => esc_html__( 'Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .mc4wp-form input[type*="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'htmega_input_submit_border',
                            'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .mc4wp-form input[type*="submit"]',
                        ]
                    );

                    $this->add_responsive_control(
                        'htmega_input_submit_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .mc4wp-form input[type*="submit"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'htmega_input_submit_box_shadow',
                            'label' => esc_html__( 'Box Shadow', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .mc4wp-form input[type*="submit"]',
                        ]
                    );

                $this->end_controls_tab(); // Button Normal tab end

                // Button Hover tab start
                $this->start_controls_tab(
                    'htmega_submit_style_hover_tab',
                    [
                        'label' => esc_html__( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'htmega_input_submithover_text_color',
                        [
                            'label'     => esc_html__( 'Text Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .mc4wp-form input[type*="submit"]:hover'  => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'htmega_input_submithover_background_color',
                        [
                            'label'     => esc_html__( 'Background Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .mc4wp-form input[type*="submit"]:hover'  => 'background-color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'htmega_input_submithover_border',
                            'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .mc4wp-form input[type*="submit"]:hover',
                        ]
                    );

                $this->end_controls_tab(); // Button Hover tab end

            $this->end_controls_tabs();

        $this->end_controls_section(); // Input submit button style tab end

    }

    protected function render( $instance = [] ) {
        if ( ! is_plugin_active('mailchimp-for-wp/mailchimp-for-wp.php') ) {
            htmega_plugin_missing_alert( __('Mailchimp Wp', 'ht-mega-for-elementor') );
            return;
        }
        $settings   = $this->get_settings_for_display();

        $this->add_render_attribute( 'mailchimp_area_attr', 'class', 'htmega-mailchimp' );
        $this->add_render_attribute( 'mailchimp_area_attr', 'class', 'htmega-mailchimp-style-' . esc_attr( $settings['htmega_mailchimp_form_style'] ) );
       
        ?>
            <?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_render_attribute_string() is Elementor core and returns pre-escaped attribute output. ?>
            <div <?php echo $this->get_render_attribute_string( 'mailchimp_area_attr' ); ?> >
                <div class="htmega-input-box">
                    <?php echo do_shortcode( '[mc4wp_form  id="'. esc_attr( $settings['htmega_mailchimp_id'] ) . '"]' ); ?>
                </div>
            </div>
        <?php
    }

}

