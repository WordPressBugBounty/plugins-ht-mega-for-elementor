<?php
namespace Elementor;

// Elementor Classes
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_Verticle_Time_Line extends Widget_Base {

    public function get_name() {
        return 'htmega-verticletimeline-addons';
    }
    
    public function get_title() {
        return __( 'Vertical Timeline', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-time-line';
    }

    public function get_categories() {
        return [ 'htmega-addons' ];
    }
    public function get_keywords() {
        return ['htmega', 'ht mega', 'vertical timeline', 'timeline', 'content', 'addons','widget'];
    }

    public function get_help_url() {
        return 'https://wphtmega.com/docs/creative-widgets/vertical-timeline-widget/';
    }
    protected function is_dynamic_content():bool {
		return false;
	}
    protected function register_controls() {

        $this->start_controls_section(
            'button_content',
            [
                'label' => __( 'Vertical Timeline Layout', 'ht-mega-for-elementor' ),
            ]
        );

            $this->add_control(
              'verticle_timeline_layout',
                [
                'label'         => esc_html__( 'Layout', 'ht-mega-for-elementor' ),
                    'type'          => 'htmega-preset-select',
                    'default'       => '1',
                    'label_block'   => false,
                    'options'       => [
                        '1'    => esc_html__( 'Layout One', 'ht-mega-for-elementor' ),
                        '2'   => esc_html__( 'Layout Two', 'ht-mega-for-elementor' ),
                        '3'   => esc_html__( 'Layout Three', 'ht-mega-for-elementor' ),
                        '4'   => esc_html__( 'Layout Four', 'ht-mega-for-elementor' ),
                    ],
                ]
            );
            
        $this->end_controls_section();

         // Timeline Content
        $this->start_controls_section(
            'verticle_timeline_content',
            [
                'label' => __( 'Content', 'ht-mega-for-elementor' ),
            ]
        );

            $repeater = new Repeater();

            $repeater->add_control(
                'content_date',
                [
                    'label'   => __( 'Content Date', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => __( 'Sep<br/>2018', 'ht-mega-for-elementor' ),
                ]
            );

            $repeater->add_control(
                'content_title',
                [
                    'label'   => __( 'Title', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::TEXT,
                ]
            );

            $repeater->add_control(
                'content_text',
                [
                    'label' => __( 'Content', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::WYSIWYG,
                    'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipis icing elit, sed do eiusmod tempor incid ut labore et dolore magna aliqua Ut enim ad min.', 'ht-mega-for-elementor' ),
                ]
            );

            $this->add_control(
                'custom_content_list',
                [
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $repeater->get_controls(),
                    'default' => [
                        [
                            'content_date' => __( 'Sep<br/>2018', 'ht-mega-for-elementor' ),
                            'content_text' => __( 'Lorem ipsum dolor sit amet, consectetur adipis icing elit, sed do eiusmod tempor incid ut labore et dolore magna aliqua Ut enim ad min.', 'ht-mega-for-elementor' ),
                        ],
                        [
                            'content_date' => __( 'Oct<br/>2018', 'ht-mega-for-elementor' ),
                            'content_text' => __( 'Lorem ipsum dolor sit amet, consectetur adipis icing elit, sed do eiusmod tempor incid ut labore et dolore magna aliqua Ut enim ad min.', 'ht-mega-for-elementor' ),
                        ],
                        [
                            'content_date' => __( 'Aug<br/>2018', 'ht-mega-for-elementor' ),
                            'content_text' => __( 'Lorem ipsum dolor sit amet, consectetur adipis icing elit, sed do eiusmod tempor incid ut labore et dolore magna aliqua Ut enim ad min.', 'ht-mega-for-elementor' ),
                        ]

                    ],
                    'title_field' => '{{{ content_date }}}',
                ]
            );

        $this->end_controls_section();

        // Title Style tab section
        $this->start_controls_section(
            'verticle_timeline_title_style_section',
            [
                'label' => __( 'Title', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'content_title_color',
                [
                    'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   =>'',
                    'selectors' => [
                        '{{WRAPPER}} .htc-verctimeline-wrapper > div .timeline-content h6.time_line_title' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'content_title_hover_color',
                [
                    'label'     => __( 'Hover Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   =>'',
                    'selectors' => [
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--2:hover .timeline-content h6.time_line_title,{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--3:hover .timeline-content h6.time_line_title' => 'color: {{VALUE}};',
                    ],
                    'condition' => [
                        'verticle_timeline_layout' =>array( '2','3'),
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_title_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htc-verctimeline-wrapper > div .timeline-content h6.time_line_title',
                ]
            );
            
            $this->add_responsive_control(
                'title_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htc-verctimeline-wrapper > div .timeline-content h6.time_line_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
        $this->end_controls_section();

        // Content Style tab section
        $this->start_controls_section(
            'verticle_timeline_content_style_section',
            [
                'label' => __( 'Content', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs(
            'content_style_tabs'
        );
            // Normal Style Tab
            $this->start_controls_tab(
                'content_style_normal_tab',
                [
                    'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                ]
            );

            $this->add_control(
                'content_text_color',
                [
                    'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   =>'',
                    'selectors' => [
                        '{{WRAPPER}} .htc-verctimeline-wrapper > div .timeline-content,{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--2 .timeline-content p,{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--3 .timeline-content p' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_text_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htc-verctimeline-wrapper > div .timeline-content,{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--2 .timeline-content p,{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--3 .timeline-content p',
                ]
            );
            
            $this->add_control(
                'content_background_color',
                [
                    'label'     => __( 'Background Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   =>'',
                    'selectors' => [
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--3 .timeline-content .content' => 'background: {{VALUE}};',
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--3 .timeline-content .content::before' => 'border-right-color: {{VALUE}};border-left-color:transparent;',
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--3.vertical-reverse .timeline-content .content::before' => 'border-left-color: {{VALUE}}; border-right-color:transparent;',
                    ],
                    'condition' => [
                        'verticle_timeline_layout' =>array( '3'),
                    ],
                ]
            );
            $this->add_responsive_control(
                'content_box_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--3 .timeline-content .content' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                    'condition' => [
                        'verticle_timeline_layout' =>array( '3'),
                    ],
                ]
            );
            $this->add_responsive_control(
                'content_box_padding',
                [
                    'label' => esc_html__( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--3 .timeline-content .content' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                    'condition' => [
                        'verticle_timeline_layout' =>array( '3'),
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'content_boxshadow',
                    'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--3 .timeline-content .content',
                    'condition'=>[
                        'verticle_timeline_layout' =>array( '3'),
                    ]
                ]
            );
            $this->end_controls_tab();

                // Hover Style Tab
                $this->start_controls_tab(
                    'content_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );
                $this->add_control(
                    'content_text_color_hover',
                    [
                        'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   =>'',
                        'selectors' => [
                            '{{WRAPPER}} .htc-verctimeline-wrapper > div:hover .timeline-content,{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--2:hover .timeline-content p,{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--3:hover .timeline-content p,{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--3:hover .vertical-time .vertical-date span.month' => 'color: {{VALUE}};',
                            
                        ],
                    ]
                );
                


                $this->add_control(
                    'content_background_color_hover',
                    [
                        'label'     => __( 'Background Color', 'ht-mega-for-elementor' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   =>'',
                        'selectors' => [
                            '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--3:hover .timeline-content .content' => 'background: {{VALUE}};',
                            '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--3:hover .timeline-content .content::before' => 'border-right-color: {{VALUE}};border-left-color:transparent;',
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--3.vertical-reverse:hover .timeline-content .content::before' => 'border-left-color: {{VALUE}}; border-right-color:transparent;',
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--3:hover .vertical-time .vertical-date span.month' => 'border-color: {{VALUE}}; background:{{VALUE}};',

                        ],
                        'condition' => [
                            'verticle_timeline_layout' =>array( '3'),
                        ],
                    ]
                );

                $this->end_controls_tab();
            $this->end_controls_tabs();
        $this->end_controls_section();

        // Date Style tab section
        $this->start_controls_section(
            'verticle_timeline_date_style_section',
            [
                'label' => __( 'Date', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'content_date_color',
                [
                    'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   =>'',
                    'selectors' => [
                        '{{WRAPPER}} .htc-verctimeline-wrapper > div .vertical-date span.month' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_date_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htc-verctimeline-wrapper > div .vertical-date span.month',
                ]
            );
            $this->add_responsive_control(
                'box_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-verticletimeline-style-4 .ht-ver-timeline .vertical-time .vertical-date,{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--2 .vertical-time .vertical-date span.month' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'verticle_timeline_layout' =>array( '4','2'),
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'date_border_radius',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--3 .vertical-time .vertical-date span.month',
                    'condition' => [
                        'verticle_timeline_layout' =>array( '3'),
                    ],
                ]
            );
            
            $this->add_responsive_control(
                'border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-verticletimeline-style-4 .ht-ver-timeline .vertical-time .vertical-date,
                        {{WRAPPER}} .htmega-verticletimeline-style-4 .ht-ver-timeline .vertical-time .vertical-date:after,
                        {{WRAPPER}} .htmega-verticletimeline-style-4 .ht-ver-timeline .vertical-time .vertical-date span.month,
                        {{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--2 .vertical-time .vertical-date span.month:after,
                        {{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--2 .vertical-time .vertical-date span.month' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                    'condition' => [
                        'verticle_timeline_layout' =>array( '4','2'),
                    ],
                ]
            );
            $this->add_control(
                'date_border_heading',
                [
                    'label' => __( 'Box Border', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'verticle_timeline_layout' =>'4',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'date_background_border',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-verticletimeline-style-4 .ht-ver-timeline .vertical-time .vertical-date:after,{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--2 .vertical-time .vertical-date span.month:after,{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--3 .vertical-time .vertical-date span.month',
                    'condition' => [
                        'verticle_timeline_layout' =>array( '4','2','3'),
                    ],
                ]
            );
            $this->add_control(
                'timeline_arrow_color',
                [
                    'label'     => __( 'Arrow Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   =>'',
                    'selectors' => [
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline .vertical-time .vertical-date::before' => 'border-color: transparent transparent transparent {{VALUE}};',
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--2 .vertical-time .vertical-date span.month:before' => 'border-left-color:{{VALUE}};',
                        '{{WRAPPER}} .htc-verctimeline-wrapper.htmega-verticletimeline-style-4 .ht-ver-timeline .vertical-time::before' => 'border-color: {{VALUE}};',
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline.vertical-reverse .vertical-time .vertical-date::before' => 'border-color: transparent {{VALUE}} transparent transparent;',
                    ],
                    'condition' => [
                        'verticle_timeline_layout' =>array( '4','2'),
                    ],
                    'separator' => 'after',
                ]
            );
            $this->add_control(
                'date_border_heading2',
                [
                    'label' => __( 'Box Style Reverse', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'verticle_timeline_layout' =>array( '4','2'),
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'date_background_border2',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-verticletimeline-style-4 .ht-ver-timeline.vertical-reverse .vertical-time .vertical-date:after,{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--2.vertical-reverse .vertical-time .vertical-date span.month:after',
                    'condition' => [
                        'verticle_timeline_layout' =>array( '4','2'),
                    ],
                ]
            );
            $this->add_control(
                'timeline_arrow_color2',
                [
                    'label'     => __( 'Arrow Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   =>'',
                    'selectors' => [
                        '{{WRAPPER}} .htc-verctimeline-wrapper.htmega-verticletimeline-style-4 .ht-ver-timeline.vertical-reverse .vertical-time::before' => 'border-color: {{VALUE}};',
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--2.vertical-reverse .vertical-time .vertical-date span.month:before' => 'border-right-color: {{VALUE}}; border-left-color: transparent',
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline.vertical-reverse .vertical-time .vertical-date::before' => 'border-color: transparent {{VALUE}} transparent transparent;',
                    ],
                    'condition' => [
                        'verticle_timeline_layout' =>array( '4','2'),
                    ],
                    'separator' => 'after',
                ]
            );
            
            $this->add_control(
                'date_border_heading_background',
                [
                    'label' => __( 'Box Background', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'condition' => [
                        'verticle_timeline_layout' =>array( '4'),
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'date_background_box',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-verticletimeline-style-4 .ht-ver-timeline .vertical-time .vertical-date span.month',
                    'condition' => [
                        'verticle_timeline_layout' =>'4',
                    ],
                ]
            );
        $this->end_controls_section();
        // Timeline Style tab section
        $this->start_controls_section(
            'verticle_timelin_style_section',
            [
                'label' => __( 'Timeline Style', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'timeline_border_color',
                [
                    'label'     => __( 'Timeline Primary Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   =>'',
                    'selectors' => [
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline .vertical-time .vertical-date' => 'border-color: {{VALUE}};',
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline .vertical-time .vertical-date::before' => 'border-color: transparent transparent transparent {{VALUE}};',
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline.vertical-reverse .vertical-time .vertical-date::before' => 'border-color: transparent {{VALUE}} transparent transparent;',
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline .timeline-content::before' => 'border-color: {{VALUE}};',
                    ],
                    'condition' => [
                        'verticle_timeline_layout!' =>array( '4','2','3' ),
                    ],
                ]
            );

            $this->add_control(
                'timeline_line_color',
                [
                    'label'     => __( 'Timeline Line Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   =>'',
                    'selectors' => [
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline::before' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline .vertical-time::before' => 'border-color: {{VALUE}};',
                        '{{WRAPPER}} .htc-verctimeline-wrapper.htmega-verticletimeline-style-2::before' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--2 .vertical-time::before' => 'border-color: {{VALUE}};',
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--3::before' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--3 .vertical-time .vertical-date span' => 'background-color: {{VALUE}};',
                    ],
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'timeline_line_dot_color',
                [
                    'label'     => __( 'Timeline Dot Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   =>'',
                    'selectors' => [
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline .vertical-time::before' => 'border-color: {{VALUE}};',

                    ],
                    'condition' => [
                        'verticle_timeline_layout!' =>array( '4','2','3'),
                    ],
                ]
            );
            $this->add_control(
                'timeline_line_dot_bg_color',
                [
                    'label'     => __( 'Timeline Dot BG Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   =>'',
                    'selectors' => [
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline .vertical-time::before,{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--2 .vertical-time::before' => 'background: {{VALUE}};',
                    ],
                    'condition' => [
                        'verticle_timeline_layout!' =>array( '3'),
                    ],
                ]
            );
            $this->add_control(
                'timeline_line_dot_hover_bg_color',
                [
                    'label'     => __( 'Timeline Dot Hover BG Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   =>'',
                    'selectors' => [
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--2:hover .vertical-time::before' => 'background: {{VALUE}};',
                    ],
                    'condition' => [
                        'verticle_timeline_layout' =>array( '2'),
                    ],
                ]
            );

            $this->add_control(
                'timeline_line_hover_color',
                [
                    'label'     => __( 'Timeline Hover Line Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   =>'',
                    'selectors' => [
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--2::before' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--2:hover .vertical-time::before' => 'border-color: {{VALUE}};',
                        '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--2:hover .timeline-content h6' => 'color: {{VALUE}};',
                    ],
                    'condition' => [
                        'verticle_timeline_layout' =>'2',
                    ],
                ]
            );
            $this->add_control(
                'dot_hover_gradient',
                [
                    'label' => __( ' Dot Border Hover Gradient Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'verticle_timeline_layout' =>array('2'),
                    ],
                ]
            );
                
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'dot_hover_gradient',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_exclude -- false positive: this is Group_Control_Background's 'exclude' param restricting which background type options (image) appear in the Elementor Style panel, not a WP_Query exclude arg.
                    'exclude' => [ 'image' ],
                    'selector' => '{{WRAPPER}} .htc-verctimeline-wrapper .ht-ver-timeline--2::before',
                    'condition' => [
                        'verticle_timeline_layout' =>array('2'),
                    ],
                ]
            );
        $this->end_controls_section();

    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();

        if( '4' == $settings['verticle_timeline_layout'] ){
            $this->add_render_attribute( 'verticle_timeline_attr', 'class', 'htc-verctimeline-wrapper htmega-verticletimeline-style-1 htmega-verticletimeline-style-' . esc_attr( $settings['verticle_timeline_layout'] ) );
        }else{
            $this->add_render_attribute( 'verticle_timeline_attr', 'class', 'htc-verctimeline-wrapper htmega-verticletimeline-style-' . esc_attr( $settings['verticle_timeline_layout'] ) );
        }

        $item_class = 'ht-ver-timeline';
        if( $settings['verticle_timeline_layout'] > 1 && $settings['verticle_timeline_layout'] < 4 ){
            $item_class = 'ht-ver-timeline--'.$settings['verticle_timeline_layout'];
        }else{
            $item_class = $item_class;
        }
       
        ?>
        <div <?php echo $this->get_render_attribute_string( 'verticle_timeline_attr' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_render_attribute_string() is Elementor core, values added via add_render_attribute() were esc_attr()'d above ?>>

            <?php
                $i = 0;
                if( isset( $settings['custom_content_list'] ) && is_array( $settings['custom_content_list'] ) ) :
                    foreach ( $settings['custom_content_list'] as $items ):
                        $i++;
            ?>
               
                <?php if( $i%2 == 0 ): ?>
                    <div class="<?php echo esc_attr( $item_class ); ?> vertical-reverse">
                        <?php if( !empty( $items['content_date'] ) ): ?>
                            <div class="vertical-time">
                                <div class="vertical-date">
                                    <span class="month"><?php echo wp_kses_post( $items['content_date'] ); ?></span>
                                </div>
                            </div>
                        <?php endif; if( !empty( $items['content_text'] ) || !empty( $items['content_title'] ) ):?>
                            <div class="timeline-content">
                                <?php
                                    if( $settings['verticle_timeline_layout'] == 3 ){
                                        echo '<div class="content">';
                                    }
                                    if( !empty( $items['content_title'] ) ){
                                        echo '<h6 class="time_line_title">'. wp_kses_post($items['content_title']) .'</h6>'; 
                                    }
                                    echo wp_kses_post( $items['content_text'] );
                                    if( $settings['verticle_timeline_layout'] == 3 ){
                                        echo '</div>';
                                    }
                                ?>
                            </div>
                        <?php endif;?>
                    </div>

                <?php else:?>
                    <div class="<?php echo esc_attr( $item_class ); ?>">
                        <?php if( !empty( $items['content_date'] ) ): ?>
                            <div class="vertical-time">
                                <div class="vertical-date">
                                    <span class="month"><?php echo wp_kses_post( $items['content_date'] ); ?></span>
                                </div>
                            </div>
                        <?php endif; if( !empty( $items['content_text'] ) || !empty( $items['content_title'] ) ):?>
                            <div class="timeline-content">
                                <?php
                                    if( $settings['verticle_timeline_layout'] == 3 ){
                                        echo '<div class="content">';
                                    }
                                    if( !empty( $items['content_title'] ) ){
                                        echo '<h6 class="time_line_title">'. wp_kses_post( $items['content_title'] ) .'</h6>'; 
                                    }
                                    echo wp_kses_post( $items['content_text'] );
                                    if( $settings['verticle_timeline_layout'] == 3 ){
                                        echo '</div>';
                                    }
                                ?>
                            </div>
                        <?php endif;?>
                    </div>
                <?php endif;?>

            <?php endforeach; endif; ?>

        </div>

        <?php

    }

}