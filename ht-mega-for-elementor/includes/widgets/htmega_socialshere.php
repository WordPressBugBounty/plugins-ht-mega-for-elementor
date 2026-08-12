<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_SocialShere extends Widget_Base {

    public function get_name() {
        return 'htmega-social-shere-addons';
    }
    
    public function get_title() {
        return __( 'Social Share', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-share';
    }
    
    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_keywords() {
        return ['social share', 'elementor social share','share button', 'social', 'share', 'facebook', 'twitter', 'instagram', 'linkedin'];
    }

    public function get_help_url() {
        return 'https://wphtmega.com/docs/social-widgets/social-share-widget/';
    }

    public function get_script_depends() {
        return [
            'htmega-goodshare',
        ];
    }
    protected function is_dynamic_content():bool {
		return false;
	}
    protected function register_controls() {

        $this->start_controls_section(
            'social_media_sheres',
            [
                'label' => esc_html__( 'Social Share', 'ht-mega-for-elementor' ),
            ]
        );
        
            $repeater = new Repeater();

            $repeater->add_control(
                'htmega_social_media',
                [
                    'label' => esc_html__( 'Social Media', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'facebook',
                    'options' => [
                        'facebook'      => esc_html__( 'Facebook', 'ht-mega-for-elementor' ),
                        'twitter'       => esc_html__( 'Twitter', 'ht-mega-for-elementor' ),
                        'googleplus'    => esc_html__( 'Google+', 'ht-mega-for-elementor' ),
                        'pinterest'     => esc_html__( 'Pinterest', 'ht-mega-for-elementor' ),
                        'linkedin'      => esc_html__( 'Linkedin', 'ht-mega-for-elementor' ),
                        'tumblr'        => esc_html__( 'tumblr', 'ht-mega-for-elementor' ),
                        'vkontakte'     => esc_html__( 'Vkontakte', 'ht-mega-for-elementor' ),
                        'odnoklassniki' => esc_html__( 'Odnoklassniki', 'ht-mega-for-elementor' ),
                        'moimir'        => esc_html__( 'Moimir', 'ht-mega-for-elementor' ),
                        'livejournal'   => esc_html__( 'Live journal', 'ht-mega-for-elementor' ),
                        'blogger'       => esc_html__( 'Blogger', 'ht-mega-for-elementor' ),
                        'digg'          => esc_html__( 'Digg', 'ht-mega-for-elementor' ),
                        'evernote'      => esc_html__( 'Evernote', 'ht-mega-for-elementor' ),
                        'reddit'        => esc_html__( 'Reddit', 'ht-mega-for-elementor' ),
                        'delicious'     => esc_html__( 'Delicious', 'ht-mega-for-elementor' ),
                        'stumbleupon'   => esc_html__( 'Stumbleupon', 'ht-mega-for-elementor' ),
                        'pocket'        => esc_html__( 'Pocket', 'ht-mega-for-elementor' ),
                        'surfingbird'   => esc_html__( 'Surfingbird', 'ht-mega-for-elementor' ),
                        'liveinternet'  => esc_html__( 'Liveinternet', 'ht-mega-for-elementor' ),
                        'buffer'        => esc_html__( 'Buffer', 'ht-mega-for-elementor' ),
                        'instapaper'    => esc_html__( 'Instapaper', 'ht-mega-for-elementor' ),
                        'xing'          => esc_html__( 'Xing', 'ht-mega-for-elementor' ),
                        'wordpress'     => esc_html__( 'WordPress', 'ht-mega-for-elementor' ),
                        'baidu'         => esc_html__( 'Baidu', 'ht-mega-for-elementor' ),
                        'renren'        => esc_html__( 'Renren', 'ht-mega-for-elementor' ),
                        'weibo'         => esc_html__( 'Weibo', 'ht-mega-for-elementor' ),
                        'skype'         => esc_html__( 'Skype', 'ht-mega-for-elementor' ),
                        'telegram'      => esc_html__( 'Telegram', 'ht-mega-for-elementor' ),
                        'viber'         => esc_html__( 'Viber', 'ht-mega-for-elementor' ),
                        'whatsapp'      => esc_html__( 'Whatsapp', 'ht-mega-for-elementor' ),
                        'line'          => esc_html__( 'Line', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $repeater->add_control(
                'htmega_social_title',
                [
                    'label'   => esc_html__( 'Title', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Facebook', 'ht-mega-for-elementor' ),
                ]
            );

            $repeater->add_control(
                'htmega_social_icon',
                [
                    'label'   => esc_html__( 'Icon', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::ICONS,
                    'default' => [
                        'value'=>'fab fa-facebook-square',
                        'library'=>'brands',
                    ],
                ]
            );
            
            $repeater->add_control(
                'normal_style_area_heading',
                [
                    'label' => esc_html__( 'Normal Style', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $repeater->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'social_rep_background',
                    'label' => esc_html__( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-social-share {{CURRENT_ITEM}}',
                ]
            );

            $repeater->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'social_rep_border',
                    'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-social-share {{CURRENT_ITEM}}',
                ]
            );

            $repeater->add_control(
                'hover_style_area_heading',
                [
                    'label' => esc_html__( 'Hover Style', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $repeater->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'social_rep_hover_background',
                    'label' => esc_html__( 'Hover Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-social-share {{CURRENT_ITEM}}:hover',
                ]
            );

            $repeater->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'social_rep_hover_border',
                    'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-social-share {{CURRENT_ITEM}}:hover',
                ]
            );

            $repeater->start_controls_tabs('social_content_area_tabs');

                $repeater->start_controls_tab(
                    'social_rep_style',
                    [
                        'label' => esc_html__( 'Title', 'ht-mega-for-elementor' ),
                    ]
                );

                    $repeater->add_control(
                        'social_text_color',
                        [
                            'label'     => esc_html__( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'default'   => '#000000',
                            'selectors' => [
                                '{{WRAPPER}} .htmega-social-share {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $repeater->add_control(
                        'social_text_hover_color',
                        [
                            'label'     => esc_html__( 'Hover Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-social-share {{CURRENT_ITEM}}:hover' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                $repeater->end_controls_tab();// End Style tab

                // Start Icon tab
                $repeater->start_controls_tab(
                    'social_rep_icon_style',
                    [
                        'label' => esc_html__( 'Icon', 'ht-mega-for-elementor' ),
                    ]
                );
                    
                    $repeater->add_control(
                        'normal_style_icon_heading',
                        [
                            'label' => esc_html__( 'Normal Style', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::HEADING,
                            'separator' => 'before',
                        ]
                    );

                    $repeater->add_control(
                        'social_icon_color',
                        [
                            'label'     => esc_html__( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-social-share {{CURRENT_ITEM}} i' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-social-share {{CURRENT_ITEM}} svg path' => 'fill: {{VALUE}};',
                            ],
                        ]
                    );

                    $repeater->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'social_rep_icon_background',
                            'label' => esc_html__( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-social-share {{CURRENT_ITEM}} i',
                        ]
                    );

                    $repeater->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'social_rep_icon_border',
                            'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-social-share {{CURRENT_ITEM}} i',
                        ]
                    );

                    $repeater->add_responsive_control(
                        'social_rep_icon_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-social-share {{CURRENT_ITEM}} i' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                            'separator'=>'after',
                        ]
                    );

                    $repeater->add_control(
                        'hover_style_icon_heading',
                        [
                            'label' => esc_html__( 'Hover Style', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::HEADING,
                        ]
                    );


                    $repeater->add_control(
                        'social_icon_hover_color',
                        [
                            'label'     => esc_html__( 'Hover Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-social-share {{CURRENT_ITEM}}:hover i' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-social-share {{CURRENT_ITEM}}:hover svg path' => 'fill: {{VALUE}};',
                            ],
                        ]
                    );

                    $repeater->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'social_rep_icon_hover_background',
                            'label' => esc_html__( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-social-share {{CURRENT_ITEM}}:hover i',
                        ]
                    );

                    $repeater->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'social_rep_icon_hover_border',
                            'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-social-share {{CURRENT_ITEM}}:hover i',
                        ]
                    );

                $repeater->end_controls_tab();// End icon Style tab

            $repeater->end_controls_tabs();// Repeater Tabs end

            $this->add_control(
                'htmega_socialmedia_list',
                [
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $repeater->get_controls(),
                    'prevent_empty' => false,
                    'default' => [
                        [
                            'htmega_social_media' => 'facebook',
                            'htmega_social_title' => esc_html__( 'Facebook', 'ht-mega-for-elementor' ),
                            'htmega_social_icon' => 'fab fa-linkedin-in',
                        ],
                        [
                            'htmega_social_media' => 'twitter',
                            'htmega_social_title' => esc_html__( 'Twitter', 'ht-mega-for-elementor' ),
                            'htmega_social_icon' => 'fab fa-twitter-x',
                        ],
                        [
                            'htmega_social_media' => 'linkedin',
                            'htmega_social_title' => esc_html__( 'Linkedin', 'ht-mega-for-elementor' ),
                            'htmega_social_icon' => 'fab fa-linkedin-in',
                        ],
                    ],
                    'title_field' => '{{{ htmega_social_title }}}',
                ]
            );
            
            $this->add_control(
                'social_view',
                [
                    'label' => esc_html__( 'View', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'label_block' => false,
                    'options' => [
                        'icon'       => 'Icon',
                        'title'      => 'Title',
                        'icon-title' => 'Icon & Title',
                    ],
                    'default'      => 'icon',
                ]
            );

            $this->add_control(
                'show_counter',
                [
                    'label'        => esc_html__( 'Count', 'ht-mega-for-elementor' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'label_on'     => esc_html__( 'Show', 'ht-mega-for-elementor' ),
                    'label_off'    => esc_html__( 'Hide', 'ht-mega-for-elementor' ),
                    'return_value' => 'yes',
                    'condition'    => [
                        'social_view!' => 'icon',
                    ],
                ]
            );
            
            $this->add_responsive_control(
                'social_icon_alignment',
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
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-social-share ul' => 'text-align: {{VALUE}};',
                    ],
                    'default' => 'left',
                ]
            );

        $this->end_controls_section();

        // Style tab section
        $this->start_controls_section(
            'htmega_socialshere_style_section',
            [
                'label' => esc_html__( 'Style', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
                'social_shere_padding',
                [
                    'label' => esc_html__( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-social-share ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'social_shere_margin',
                [
                    'label' => esc_html__( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-social-share ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'social_shere_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%',],
                    'default' => [
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-social-share li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'social_shere_border',
                    'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-social-share li',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'social_shere_margin_box_shadow',
                    'label' => esc_html__( 'Box Shadow', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-social-share ul li',
                ]
            );

            $this->add_control(
                'icon_control_offset_toggle',
                [
                    'label' => esc_html__( 'Icon Settings', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::POPOVER_TOGGLE,
                    'label_off' => esc_html__( 'None', 'ht-mega-for-elementor' ),
                    'label_on' => esc_html__( 'Custom', 'ht-mega-for-elementor' ),
                    'return_value' => 'yes',
                    'condition'    => [
                        'social_view!' => 'title',
                    ],
                ]
            );

            $this->start_popover();

            $this->add_control(
                'icon_height',
                [
                    'label' => esc_html__( 'Icon Height', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ]
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 42,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-social-share ul li i' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .htmega-social-share ul li svg' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'icon_line_height',
                [
                    'label' => esc_html__( 'Line Height', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ]
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 42,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-social-share ul li i' => 'line-height: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .htmega-social-share ul li svg' => 'line-height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'icon_width',
                [
                    'label' => esc_html__( 'Icon Width', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ]
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 42,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-social-share ul li i' => 'width: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .htmega-social-share ul li svg' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_control(
                'icon_fontsize',
                [
                    'label' => esc_html__( 'Icon Size', 'ht-mega-for-elementor' ),
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
                        '{{WRAPPER}} .htmega-social-share ul li i' => 'font-size: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .htmega-social-share ul li > svg' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'social_icon_border',
                    'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-social-share li i,{{WRAPPER}} .htmega-social-share li svg',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'social_icon_background',
                    'label' => esc_html__( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-social-share li i,{{WRAPPER}} .htmega-social-share li svg',
                ]
            );

            $this->add_responsive_control(
                'social_icon_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-social-share li i' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                        '{{WRAPPER}} .htmega-social-share li svg' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->end_popover();

            $this->add_control(
                'share_button_line_height',
                [
                    'label' => esc_html__( 'Button Line Height', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ]
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 42,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-social-share ul li' => 'line-height: {{SIZE}}{{UNIT}};',
                    ],
                    'condition'    => [
                        'social_view!' => 'icon',
                    ],
                ]
            );
            
            $this->add_control(
                'normal_style_title_heading',
                [
                    'label' => esc_html__( 'Title Style', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'social_view!' =>'icon',
                    ],
                ]
            );

            $this->add_responsive_control(
                'social_shere_title_padding',
                [
                    'label' => esc_html__( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-social-share ul li span.htmega-share-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'social_view!' =>'icon',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'selector' => '{{WRAPPER}} .htmega-social-share ul li span',
                    'condition' => [
                        'social_view!' =>'icon',
                    ],
                ]
            );

            $this->start_controls_tabs('social_share_style_tabs');

            // Start Icon tab
            $this->start_controls_tab(
                'social_share_normal_style',
                [
                    'label' => esc_html__( 'Normal', 'ht-mega-for-elementor' ),
                ]
            );


                $this->add_control(
                    'social_shere_color',
                    [
                        'label'     => esc_html__( 'Color', 'ht-mega-for-elementor' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .htmega-social-share ul li' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .htmega-social-style-1 ul li svg path,{{WRAPPER}} .htmega-social-share ul li svg path' => 'fill: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'social_shere_background',
                        'label' => esc_html__( 'Background', 'ht-mega-for-elementor' ),
                        'types' => [ 'classic', 'gradient' ],
                        'selector' => '{{WRAPPER}} .htmega-social-share li',
                    ]
                );

            $this->end_controls_tab();// End Style tab

            // Start Icon tab
            $this->start_controls_tab(
                'social_share_hover_style',
                [
                    'label' => esc_html__( 'Hover', 'ht-mega-for-elementor' ),
                ]
            );

                $this->add_control(
                    'social_shere_hover_color',
                    [
                        'label'     => esc_html__( 'Color', 'ht-mega-for-elementor' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .htmega-social-share ul li:hover' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .htmega-social-share ul li:hover svg path' => 'fill: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'social_shere_hover_background',
                        'label' => esc_html__( 'Background', 'ht-mega-for-elementor' ),
                        'types' => [ 'classic', 'gradient' ],
                        'selector' => '{{WRAPPER}} .htmega-social-share li:hover',
                    ]
                );

            $this->end_controls_tab();// End Style tab

            $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();

        $this->add_render_attribute( 'htmega_socialshere', 'class', 'htmega-social-share htmega-social-style-1' );
        if( $settings['social_view'] == 'icon-title' || $settings['social_view'] == 'title' ){
            $this->add_render_attribute( 'htmega_socialshere', 'class', 'htmega-social-view-' . esc_attr( $settings['social_view'] ) );
        }
             
        ?>
            <div <?php echo $this->get_render_attribute_string( 'htmega_socialshere' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor core get_render_attribute_string() already escapes attributes. ?> >
                <ul>
                    <?php foreach ( $settings['htmega_socialmedia_list'] as $socialmedia ) :?>
                        <li class="elementor-repeater-item-<?php echo esc_attr( $socialmedia['_id']); ?>" data-social="<?php echo esc_attr( $socialmedia['htmega_social_media'] ); ?>" > 
                            <?php
                                if( $settings['social_view'] == 'icon' ){
                                    echo HTMega_Icon_manager::render_icon( $socialmedia['htmega_social_icon'], [ 'aria-hidden' => 'true' ] );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTMega_Icon_manager::render_icon() delegates to Elementor's Icons_Manager::render_icon(), which escapes output.
                                }elseif( $settings['social_view'] == 'title' ){
                                    echo sprintf('<span class="htmega-share-title">%1$s</span>', htmega_kses_title( $socialmedia['htmega_social_title'] ));  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_title() sanitizes via wp_kses(), see includes/helper-function.php
                                }else{
                                    echo sprintf('%1$s<span class="htmega-share-title">%2$s</span>', HTMega_Icon_manager::render_icon( $socialmedia['htmega_social_icon'], [ 'aria-hidden' => 'true' ] ), htmega_kses_title(  $socialmedia['htmega_social_title'] ));  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTMega_Icon_manager::render_icon() delegates to Elementor's Icons_Manager::render_icon(), which escapes output. Trailing htmega_kses_title() call on this line is also safe (see helper-function.php).
                                }
                                if( $settings['show_counter'] == 'yes' ){
                                    echo '<span class="htmega-share-counter" data-counter="'.esc_attr( $socialmedia['htmega_social_media'] ).'"></span>';
                                }
                            ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php

    }

}

