<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_Notify extends Widget_Base {

    public function get_name() {
        return 'htmega-notify-addons';
    }
    
    public function get_title() {
        return __( 'Notify', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-alert';
    }

    public function get_keywords() {
        return ['notification','notice','remark', 'ht mega', 'htmega', 'notify'];
    }

    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_help_url() {
        return 'https://wphtmega.com/docs/creative-widgets/notification-widget/';
    }

    public function get_script_depends() {
        return [
            'htmega-notify','dompurify'
        ];
    }
    protected function is_dynamic_content():bool {
		return false;
	}
    protected function register_controls() {

        // Notification Button
        $this->start_controls_section(
            'notify_button',
            [
                'label' => __( 'Button', 'ht-mega-for-elementor' ),
            ]
        );
            
            $this->add_control(
                'notification_button_txt',
                [
                    'label' => __( 'Button Text', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Show Info', 'ht-mega-for-elementor' ),
                ]
            );

        $this->end_controls_section();


        // Notification Content
        $this->start_controls_section(
            'notify_content',
            [
                'label' => __( 'Notification Content', 'ht-mega-for-elementor' ),
            ]
        );

            $this->add_control(
                'notification_content',
                [
                    'label' => __( 'Notification Message', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => __( '<strong>Welcome,</strong>to Notification.', 'ht-mega-for-elementor' ),
                ]
            );

        $this->end_controls_section();

        // Notification Option
        $this->start_controls_section(
            'notification_option',
            [
                'label' => __( 'Notification Option', 'ht-mega-for-elementor' ),
            ]
        );
            $this->add_control(
                'notification_element_container',
                [
                    'label'   => __( 'Element Container', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'self',
                    'options' => [
                        'body'   => __( 'Body', 'ht-mega-for-elementor' ),
                        'self'   => __( 'Self', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'notification_position',
                [
                    'label'   => __( 'Notification Position', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'topcenter',
                    'options' => [
                        'topleft'           => __( 'Top Left', 'ht-mega-for-elementor' ),
                        'topcenter'         => __( 'Top Center', 'ht-mega-for-elementor' ),
                        'topright'          => __( 'Top Right', 'ht-mega-for-elementor' ),
                        'bottomleft'        => __( 'Bottom Left', 'ht-mega-for-elementor' ),
                        'bottomcenter'      => __( 'Bottom Center', 'ht-mega-for-elementor' ),
                        'bottomright'       => __( 'Bottom Right', 'ht-mega-for-elementor' ),
                        'topfullwidth'      => __( 'Top Fullwidth', 'ht-mega-for-elementor' ),
                        'bottomfullwidth'   => __( 'Bottom Fullwidth', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'notification_type',
                [
                    'label'   => __( 'Notification Type', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'info',
                    'options' => [
                        'info'   => __( 'Info', 'ht-mega-for-elementor' ),
                        'danger'   => __( 'Danger', 'ht-mega-for-elementor' ),
                        'success'   => __( 'Success', 'ht-mega-for-elementor' ),
                        'warning'   => __( 'Warning', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'notification_enter_animation',
                [
                    'label'   => __( 'Show Animation', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'fadeInUp',
                    'options' => [
                        'none'           => __('None','ht-mega-for-elementor'),
                        'bounceOut'      => __('bounceOut','ht-mega-for-elementor'),
                        'bounceOutDown'  => __('bounceOutDown','ht-mega-for-elementor'),
                        'bounceOutLeft'  => __('bounceOutLeft','ht-mega-for-elementor'),
                        'bounceOutRight' => __('bounceOutRight','ht-mega-for-elementor'),
                        'bounceOutUp'    => __('bounceOutUp','ht-mega-for-elementor'),
                        'fadeIn'         => __('fadeIn','ht-mega-for-elementor'),
                        'fadeInDown'     => __('fadeInDown','ht-mega-for-elementor'),
                        'fadeInDownBig'  => __('fadeInDownBig','ht-mega-for-elementor'),
                        'fadeInLeft'     => __('fadeInLeft','ht-mega-for-elementor'),
                        'fadeInLeftBig'  => __('fadeInLeftBig','ht-mega-for-elementor'),
                        'fadeInRight'    => __('fadeInRight','ht-mega-for-elementor'),
                        'fadeInRightBig' => __('fadeInRightBig','ht-mega-for-elementor'),
                        'fadeOutRight'   => __('fadeOutRight','ht-mega-for-elementor'),
                        'fadeOutLeft'    => __('fadeOutLeft','ht-mega-for-elementor'),
                        'fadeInUp'       => __('fadeInUp','ht-mega-for-elementor'),
                        'fadeOutUp'      => __('fadeOutUp','ht-mega-for-elementor'),
                        'fadeOutDown'    => __('fadeOutDown','ht-mega-for-elementor'),
                        'fadeInUpBig'    => __('fadeInUpBig','ht-mega-for-elementor'),
                        'bounceIn'       => __('bounceIn','ht-mega-for-elementor'),
                        'bounceInDown'   => __('bounceInDown','ht-mega-for-elementor'),
                        'bounceInLeft'   => __('bounceInLeft','ht-mega-for-elementor'),
                        'bounceInRight'  => __('bounceInRight','ht-mega-for-elementor'),
                        'bounceInUp'     => __('bounceInUp','ht-mega-for-elementor'),
                    ],
                ]
            );

            $this->add_control(
                'notification_exit_animation',
                [
                    'label'   => __( 'Exit Animation', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'fadeOutDown',
                    'options' => [
                        'none'           => __('None','ht-mega-for-elementor'),
                        'bounceOut'      => __('bounceOut','ht-mega-for-elementor'),
                        'bounceOutDown'  => __('bounceOutDown','ht-mega-for-elementor'),
                        'bounceOutLeft'  => __('bounceOutLeft','ht-mega-for-elementor'),
                        'bounceOutRight' => __('bounceOutRight','ht-mega-for-elementor'),
                        'bounceOutUp'    => __('bounceOutUp','ht-mega-for-elementor'),
                        'fadeIn'         => __('fadeIn','ht-mega-for-elementor'),
                        'fadeInDown'     => __('fadeInDown','ht-mega-for-elementor'),
                        'fadeInDownBig'  => __('fadeInDownBig','ht-mega-for-elementor'),
                        'fadeInLeft'     => __('fadeInLeft','ht-mega-for-elementor'),
                        'fadeInLeftBig'  => __('fadeInLeftBig','ht-mega-for-elementor'),
                        'fadeInRight'    => __('fadeInRight','ht-mega-for-elementor'),
                        'fadeInRightBig' => __('fadeInRightBig','ht-mega-for-elementor'),
                        'fadeOutRight'   => __('fadeOutRight','ht-mega-for-elementor'),
                        'fadeOutLeft'    => __('fadeOutLeft','ht-mega-for-elementor'),
                        'fadeInUp'       => __('fadeInUp','ht-mega-for-elementor'),
                        'fadeOutUp'      => __('fadeOutUp','ht-mega-for-elementor'),
                        'fadeOutDown'    => __('fadeOutDown','ht-mega-for-elementor'),
                        'fadeInUpBig'    => __('fadeInUpBig','ht-mega-for-elementor'),
                        'bounceIn'       => __('bounceIn','ht-mega-for-elementor'),
                        'bounceInDown'   => __('bounceInDown','ht-mega-for-elementor'),
                        'bounceInLeft'   => __('bounceInLeft','ht-mega-for-elementor'),
                        'bounceInRight'  => __('bounceInRight','ht-mega-for-elementor'),
                        'bounceInUp'     => __('bounceInUp','ht-mega-for-elementor'),
                    ],
                ]
            );

            $this->add_control(
                'notification_offset',
                [
                    'label' => __('Offset', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 80,
                ]
            );

            $this->add_control(
                'notification_delay',
                [
                    'label' => __('Delay', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 5000,
                ]
            );

            $this->add_control(
                'notification_width',
                [
                    'label'   => __( 'Bootstrap Column Width', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'auto',
                    'options' => [
                        'auto'   => __( 'Auto', 'ht-mega-for-elementor' ),
                        'htb-col-md-12'  => __( 'col-md-12', 'ht-mega-for-elementor' ),
                        'htb-col-md-11'  => __( 'col-md-11', 'ht-mega-for-elementor' ),
                        'htb-col-md-10'  => __( 'col-md-10', 'ht-mega-for-elementor' ),
                        'htb-col-md-9'   => __( 'col-md-9', 'ht-mega-for-elementor' ),
                        'htb-col-md-8'   => __( 'col-md-8', 'ht-mega-for-elementor' ),
                        'htb-col-md-7'   => __( 'col-md-7', 'ht-mega-for-elementor' ),
                        'htb-col-md-6'   => __( 'col-md-6', 'ht-mega-for-elementor' ),
                        'htb-col-md-5'   => __( 'col-md-5', 'ht-mega-for-elementor' ),
                        'htb-col-md-4'   => __( 'col-md-4', 'ht-mega-for-elementor' ),
                        'htb-col-md-3'   => __( 'col-md-3', 'ht-mega-for-elementor' ),
                        'htb-col-md-2'   => __( 'col-md-2', 'ht-mega-for-elementor' ),
                        'htb-col-md-1'   => __( 'col-md-1', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'notification_icon',
                [
                    'label' => __('Icon', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value'=>'fas fa-info-circle',
                        'library' => 'fa-solid',
                    ],
                ]
            );

        $this->end_controls_section();

        // Style tab section
        $this->start_controls_section(
            'notify_style_section',
            [
                'label' => __( 'Style', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
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
                    'default' => 'center',
                    'selectors' => [
                        '{{WRAPPER}} .htmega_notify_area' => 'text-align: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_section();

        // Style Button tab section
        $this->start_controls_section(
            'notify_button_style',
            [
                'label' => __( 'Button', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->start_controls_tabs('notify_button_style_tabs');
                
                // Button Normal Style
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
                            'default' =>'#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} button.htmega-notify-button' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'button_typography',
                            'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} button.htmega-notify-button',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'button_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} button.htmega-notify-button',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} button.htmega-notify-button' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'button_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} button.htmega-notify-button',
                            'separator' => 'before',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'box_shadow',
                            'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} button.htmega-notify-button',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_padding',
                        [
                            'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} button.htmega-notify-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                                '{{WRAPPER}} button.htmega-notify-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' => 'before',
                        ]
                    );

                $this->end_controls_tab(); // Normal Button style end

                // Button Hover Style
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
                            'default' =>'#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} button.htmega-notify-button:hover' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'button_hover_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} button.htmega-notify-button:hover',
                            'separator' => 'before',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'button_hover_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} button.htmega-notify-button:hover',
                        ]
                    );

                $this->end_controls_tab(); // Hover Button style end

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Style Content tab section
        $this->start_controls_section(
            'notify_notifycontent_style',
            [
                'label' => __( 'Notify Content', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $this->start_controls_tabs('notify_content_style_tabs');
                
                // Notify Content Normal Style
                $this->start_controls_tab(
                    'notify_content_style_tab',
                    [
                        'label' => __( 'Content', 'ht-mega-for-elementor' ),
                    ]
                );
                    $this->add_control(
                        'notify_content_color',
                        [
                            'label' => __( 'Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' =>'#ffffff',
                            'selectors' => [
                                '.htmega-alert-wrap-{{ID}}.alert strong' => 'color: {{VALUE}} !important',
                                '.htmega-alert-wrap-{{ID}}.alert' => 'color: {{VALUE}} !important',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'notify_content_typography',
                            'label' => __( 'Hello Typography', 'ht-mega-for-elementor' ),
                            'selector' => '.htmega-alert-wrap-{{ID}}.alert',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'notify_content_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '.htmega-alert-wrap-{{ID}}.alert',
                        ]
                    );

                    $this->add_responsive_control(
                        'notify_content_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '.htmega-alert-wrap-{{ID}}.alert' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'notify_content_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '.htmega-alert-wrap-{{ID}}.alert',
                            'separator' => 'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'notify_content_padding',
                        [
                            'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '.htmega-alert-wrap-{{ID}}.alert' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' => 'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'notify_content_margin',
                        [
                            'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '.htmega-alert-wrap-{{ID}}.alert span.notify-message-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' => 'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'notify_content_align',
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
                            'default' => 'center',
                            'selectors' => [
                                '.htmega-alert-wrap-{{ID}}.alert' => 'text-align: {{VALUE}};',
                            ],
                        ]
                    );   
                    
                    $this->add_responsive_control(
                        'notify_content_position',
                        [
                            'label' => __( 'Top', 'ht-mega-for-elementor' ),
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
                                'size' => 0,
                            ],
                            'selectors' => [
                                '.htmega-alert-wrap-{{ID}}.alert span.notify-message-content' => 'top: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );                                      

                $this->end_controls_tab();
                
                // Notify Content Normal Style
                $this->start_controls_tab(
                    'close_button_style_tab',
                    [
                        'label' => __( 'Close Button', 'ht-mega-for-elementor' ),
                    ]
                );
                    $this->add_control(
                        'close_button_color',
                        [
                            'label' => __( 'Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' =>'#ffffff',
                            'selectors' => [
                                '.htmega-alert-wrap-{{ID}}.alert span.htmega-close' => 'color: {{VALUE}} !important',
                            ],
                        ]
                    );

                $this->end_controls_tab();
                
                // Notify Content Normal Style
                $this->start_controls_tab(
                    'info_icon_button_style_tab',
                    [
                        'label' => __( 'Info Icon', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_responsive_control(
                        'info_icon_typography',
                        [
                            'label' => __( 'Icon Size', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::SLIDER,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-alert-wrap-{{ID}}.alert > i' => 'font-size: {{SIZE}}{{UNIT}};',
                                '{{WRAPPER}} .htmega-alert-wrap-{{ID}}.alert > svg' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );                    
                    $this->add_control(
                        'info_button_color',
                        [
                            'label' => __( 'Icon Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' =>'#ffffff',
                            'selectors' => [
                                '.htmega-alert-wrap-{{ID}}.alert > i' => 'color: {{VALUE}} !important',
                                '.htmega-alert-wrap-{{ID}}.alert > svg path' => 'fill: {{VALUE}} !important',
                            ],
                        ]
                    );
                    
                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'info_icon_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '.htmega-alert-wrap-{{ID}}.alert > i , .htmega-alert-wrap-{{ID}}.alert > svg',
                        ]
                    );  

                    $this->add_responsive_control(
                        'info_icon_height',
                        [
                            'label' => __( 'Height', 'ht-mega-for-elementor' ),
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
                                'size' => 30,
                            ],
                            'selectors' => [
                                '.htmega-alert-wrap-{{ID}}.alert > i , .htmega-alert-wrap-{{ID}}.alert > svg' => 'height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'info_icon_line_height',
                        [
                            'label' => __( 'Line Height', 'ht-mega-for-elementor' ),
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
                                'size' => 30,
                            ],
                            'selectors' => [
                                '.htmega-alert-wrap-{{ID}}.alert > i , .htmega-alert-wrap-{{ID}}.alert > svg' => 'line-height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );
                    
                    $this->add_responsive_control(
                        'info_icon_width',
                        [
                            'label' => __( 'Width', 'ht-mega-for-elementor' ),
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
                                'size' => 30,
                            ],
                            'selectors' => [
                                '.htmega-alert-wrap-{{ID}}.alert > i , .htmega-alert-wrap-{{ID}}.alert > svg' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );        
                    
                    $this->add_responsive_control(
                        'info_icon_position',
                        [
                            'label' => __( 'Top', 'ht-mega-for-elementor' ),
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
                                'size' => 0,
                            ],
                            'selectors' => [
                                '.htmega-alert-wrap-{{ID}}.alert > i , .htmega-alert-wrap-{{ID}}.alert > svg' => 'top: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );               

                    $this->add_responsive_control(
                        'info_icon_padding',
                        [
                            'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '.htmega-alert-wrap-{{ID}}.alert > i, .htmega-alert-wrap-{{ID}}.alert > svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' => 'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'info_icon_margin',
                        [
                            'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '.htmega-alert-wrap-{{ID}}.alert > i , .htmega-alert-wrap-{{ID}}.alert > svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'info_icon_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '.htmega-alert-wrap-{{ID}}.alert > i, .htmega-alert-wrap-{{ID}}.alert > svg' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'info_icon_align',
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
                            'default' => 'center',
                            'selectors' => [
                                '.htmega-alert-wrap-{{ID}}.alert > i' => 'text-align: {{VALUE}};',
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
        $notify_options = array();
        $notify_options['notify_btn_class'] = '.show-info-'.esc_attr( $id );
        $notify_options['notify_class'] = '.htmega-notify-alert-'.esc_attr( $id );
        $notify_options['type'] = esc_attr( $settings['notification_type'] );
        $notify_options['notifymessage'] = wp_kses_post( $settings['notification_content'] );
        $notify_options['offset'] = absint( $settings['notification_offset'] );
        $notify_options['delay'] = absint( $settings['notification_delay'] );
        $notify_options['enter'] = esc_attr( $settings['notification_enter_animation'] );
        $notify_options['exit'] = esc_attr( $settings['notification_exit_animation'] );
        $notify_options['width'] = esc_attr( $settings['notification_width'] );
        $notify_options['icon'] = HTMega_Icon_manager::render_icon( $settings['notification_icon'], [ 'aria-hidden' => 'true' ] );
        $notify_options['wrapid'] = esc_attr( $id );

        if( $settings['notification_element_container'] == 'body' ){
            $notify_options['notify_class'] = 'body';
        }

        if( $settings['notification_position'] == 'topleft' ){
            $notify_options['from'] = 'top';
            $notify_options['align'] = 'left';
        }elseif( $settings['notification_position'] == 'topright' ){
            $notify_options['from'] = 'top';
            $notify_options['align'] = 'right';
        }elseif( $settings['notification_position'] == 'bottomleft' ){
            $notify_options['from'] = 'bottom';
            $notify_options['align'] = 'left';
        }elseif( $settings['notification_position'] == 'bottomright' ){
            $notify_options['from'] = 'bottom';
            $notify_options['align'] = 'right';
        }elseif( $settings['notification_position'] == 'bottomcenter' ){
            $notify_options['from'] = 'bottom';
            $notify_options['align'] = 'center';
        }elseif( $settings['notification_position'] == 'bottomfullwidth' ){
            $notify_options['from'] = 'bottom';
            $notify_options['align'] = 'center';
        }else{
            $notify_options['from'] = 'top';
            $notify_options['align'] = 'center';
        }

        $this->add_render_attribute( 'notify_attr', 'class', 'htmega_notify_area' );
        $this->add_render_attribute( 'notify_attr', 'data-notifyopt', wp_json_encode( $notify_options ) );

        ?>
            <div <?php echo $this->get_render_attribute_string('notify_attr'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string(). ?> >

                <div class="htmega-notify-alert-<?php echo esc_attr( $id );?>">
                    <button class="htmega-notify-button show-info-<?php echo esc_attr( $id );?> alert-<?php echo esc_attr( $notify_options['type'] ); ?>"><?php echo esc_html( $settings['notification_button_txt'] );?></button>
                </div>
                
            </div>
        <?php
    }
}