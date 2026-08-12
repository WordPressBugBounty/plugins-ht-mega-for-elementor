<?php
namespace Elementor;

// Elementor Classes

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_Panel_Slider extends Widget_Base {

    public function get_name() {
        return 'htmega-panelslider-addons';
    }
    
    public function get_title() {
        return __( 'Panel Slider', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-slideshow';
    }

    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_style_depends() {
        return [
            'slick'
        ];
    }

    public function get_script_depends() {
        return [
            'slick'
        ];
    }
    
    public function get_keywords() {
        return [ 'panel slider', 'slider widget','htmega','ht mega' ];
    }

    public function get_help_url() {
		return 'https://wphtmega.com/docs/creative-widgets/panel-slider-widget/';
	}
    protected function is_dynamic_content():bool {
		return false;
	}
    protected function register_controls() {

        $this->start_controls_section(
            'panel_slider_content',
            [
                'label' => __( 'Panel Slider', 'ht-mega-for-elementor' ),
            ]
        );

            $this->add_control(
                'panel_slider_style',
                [
                    'label' => __( 'Style', 'ht-mega-for-elementor' ),
                    'type' => 'htmega-preset-select',
                    'default' => '1',
                    'options' => [
                        '1'   => __( 'Style One', 'ht-mega-for-elementor' ),
                        '2'   => __( 'Style Two', 'ht-mega-for-elementor' ),
                        '3'   => __( 'Style Three', 'ht-mega-for-elementor' ),
                        '4'   => __( 'Style Four', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'slider_title',
                [
                    'label'   => __( 'Slider Title', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => __( 'Tattoo Boy From New York', 'ht-mega-for-elementor' ),
                ]
            );

            $repeater->add_control(
                'slider_sub_title',
                [
                    'label'   => __( 'Slider Sub Title', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => __( 'Made in 2017', 'ht-mega-for-elementor' ),
                ]
            );

            $repeater->add_control(
                'slider_image',
                [
                    'label' => __('Image','ht-mega-for-elementor'),
                    'type'=>Controls_Manager::MEDIA,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                ]
            );

            $repeater->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'slider_image_size',
                    'default' => 'large',
                    'separator' => 'none',
                ]
            );
            $repeater->add_control(
                'external_link',
                [
                    'label' => __( 'Link', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::URL,
                    'placeholder' => __( 'https://your-link.com', 'ht-mega-for-elementor' ),
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                    ],
                ]
            );
            $this->add_control(
                'panel_slider_list',
                [
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  =>  $repeater->get_controls(),
                    'default' => [
                        [
                            'slider_title' => __( 'Tattoo Boy From New York', 'ht-mega-for-elementor' ),
                            'slider_sub_title' => __( 'Made in 2019', 'ht-mega-for-elementor' ),
                        ],
                        [
                            'slider_title' => __( 'Tattoo Boy From New York', 'ht-mega-for-elementor' ),
                            'slider_sub_title' => __( 'Made in 2018', 'ht-mega-for-elementor' ),
                        ],
                        [
                            'slider_title' => __( 'Tattoo Boy From New York', 'ht-mega-for-elementor' ),
                            'slider_sub_title' => __( 'Made in 2017', 'ht-mega-for-elementor' ),
                        ],
                        [
                            'slider_title' => __( 'Tattoo Boy From New York', 'ht-mega-for-elementor' ),
                            'slider_sub_title' => __( 'Made in 2016', 'ht-mega-for-elementor' ),
                        ]

                    ],
                    'title_field' => '{{{ slider_title }}}',
                ]
            );
            $this->add_control(
                'linkshow_title',
                [
                    'label'         => __( 'Show link on Title', 'ht-mega-for-elementor' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => __( 'Yes', 'ht-mega-for-elementor' ),
                    'label_off'     => __( 'No', 'ht-mega-for-elementor' ),
                    'return_value'  => 'yes',
                    'default'       => 'no',
                ]
            );
            $this->add_control(
                'linkshow_image',
                [
                    'label'         => __( 'Show link on Image', 'ht-mega-for-elementor' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => __( 'Yes', 'ht-mega-for-elementor' ),
                    'label_off'     => __( 'No', 'ht-mega-for-elementor' ),
                    'return_value'  => 'yes',
                    'default'       => 'no',
                ]
            );
            $this->add_control(
                'slider_on',
                [
                    'label'         => __( 'Slider', 'ht-mega-for-elementor' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off'     => __( 'Off', 'ht-mega-for-elementor' ),
                    'return_value'  => 'yes',
                    'default'       => 'yes',
                ]
            );
            
        $this->end_controls_section();

        // Slider setting
        $this->start_controls_section(
            'slider_option',
            [
                'label' => esc_html__( 'Slider Option', 'ht-mega-for-elementor' ),
                'condition' => [
                    'slider_on' => 'yes',
                ]
            ]
        );

            $this->add_control(
                'slitems',
                [
                    'label' => esc_html__( 'Slider Items', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 20,
                    'step' => 1,
                    'default' => 3,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );
            $this->add_responsive_control(
                'column_gap',
                [
                    'label' => esc_html__( 'Column Gap', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'description' => esc_html__( 'Add Column gap Ex. 15px', 'ht-mega-for-elementor' ),
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .panel-slider-wrapper.htmega-carousel-activation' => 'margin: 0 -{{SIZE}}px',
                        '{{WRAPPER}} .panel-slider-wrapper.htmega-carousel-activation .slick-track' => 'margin: 0',
                        '{{WRAPPER}} .panel-slider-wrapper.htmega-carousel-activation .slick-track .slick-slide' => 'padding-left:{{SIZE}}px;padding-right: {{SIZE}}px',
                        '{{WRAPPER}} .panel_slider_style-4 .htmega-carousel-activation .slick-slide' => 'margin:0',
                    ],
                ]
            );
            $this->add_control(
                'variable_width',
                [
                    'label' => esc_html__( 'Custom Width', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'description' => __('Column width according to image', 'ht-mega-for-elementor'),
                    'return_value' => 'yes',
                    'default' => 'no',
                    'condition' => [
                        'slider_on' => 'yes',
                        'panel_slider_style!' => '4',
                    ]
                    
                ]
            );
            $this->add_control(
                'slarrows',
                [
                    'label' => esc_html__( 'Slider Arrow', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slprevicon',
                [
                    'label' => __( 'Previous icon', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value'=>'fas fa-angle-left',
                        'library' => 'fa-solid',
                    ],
                    'condition' => [
                        'slider_on' => 'yes',
                        'slarrows' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slnexticon',
                [
                    'label' => __( 'Next icon', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value'=>'fas fa-angle-right',
                        'library' => 'fa-solid',
                    ],
                    'condition' => [
                        'slider_on' => 'yes',
                        'slarrows' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'sldots',
                [
                    'label' => esc_html__( 'Slider dots', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slpause_on_hover',
                [
                    'type' => Controls_Manager::SWITCHER,
                    'label_off' => __('No', 'ht-mega-for-elementor'),
                    'label_on' => __('Yes', 'ht-mega-for-elementor'),
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'label' => __('Pause on Hover?', 'ht-mega-for-elementor'),
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slcentermode',
                [
                    'label' => esc_html__( 'Center Mode', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slcenterpadding',
                [
                    'label' => esc_html__( 'Center padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 0,
                    'max' => 500,
                    'step' => 1,
                    'default' => 0,
                    'condition' => [
                        'slider_on' => 'yes',
                        'slcentermode' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slautolay',
                [
                    'label' => esc_html__( 'Slider auto play', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'separator' => 'before',
                    'default' => 'no',
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slautoplay_speed',
                [
                    'label' => __('Autoplay speed', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 3000,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );


            $this->add_control(
                'slanimation_speed',
                [
                    'label' => __('Autoplay animation speed', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 300,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slscroll_columns',
                [
                    'label' => __('Slider item to scroll', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 10,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'heading_tablet',
                [
                    'label' => __( 'Tablet', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'sltablet_display_columns',
                [
                    'label' => __('Slider Items', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 8,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'sltablet_scroll_columns',
                [
                    'label' => __('Slider item to scroll', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 8,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'sltablet_width',
                [
                    'label' => __('Tablet Resolution', 'ht-mega-for-elementor'),
                    'description' => __('The resolution to tablet.', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 750,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'heading_mobile',
                [
                    'label' => __( 'Mobile Phone', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slmobile_display_columns',
                [
                    'label' => __('Slider Items', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 4,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slmobile_scroll_columns',
                [
                    'label' => __('Slider item to scroll', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 4,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slmobile_width',
                [
                    'label' => __('Mobile Resolution', 'ht-mega-for-elementor'),
                    'description' => __('The resolution to mobile.', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 480,
                    'condition' => [
                        'slider_on' => 'yes',
                    ]
                ]
            );

        $this->end_controls_section(); // Slider Option end

        // Style Slider Content style start
        $this->start_controls_section(
            'slider_content_style',
            [
                'label'     => __( 'Content area', 'ht-mega-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
                'content_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .panel-slider .content,{{WRAPPER}} .panel_slider_style-2 .htmega-carousel-activation .panel-slider .content' => 'top: auto; right: {{RIGHT}}{{UNIT}};bottom: {{BOTTOM}}{{UNIT}}; left: {{LEFT}}{{UNIT}};width:auto',
                        '{{WRAPPER}} .panel_slider_style-2 .htmega-carousel-activation .panel-slider .content' => 'margin-bottom: -{{BOTTOM}}{{UNIT}};',
                        '{{WRAPPER}} .panel_slider_style-2 .htmega-carousel-activation .panel-slider:hover .content' => 'margin-bottom: 0;',
                    ],
                ]
            );

            $this->add_responsive_control(
                'content_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .panel-slider .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'content_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .panel-slider .content',
                    'condition' => [
                        'panel_slider_style!' => '3',
                    ]
                ]
            );

            $this->add_responsive_control(
                'content_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .panel-slider .content' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                    'condition' => [
                        'panel_slider_style!' => '3',
                    ]
                ]
            );
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'content_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .panel-slider .content,{{WRAPPER}} .panel_slider_style-3 .panel-slider .content-inner::after',
                ]
            );
            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'content_boxshadow',
                    'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .panel-slider .content',
                    'condition' => [
                        'panel_slider_style!' => '3',
                    ]
                ]
            );
            $this->add_responsive_control(
                'content_align',
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
                        '{{WRAPPER}} .panel-slider .content' => 'text-align: {{VALUE}};',
                    ],
                ]
            );    
            $this->add_control(
                'image_overlay_heading',
                [
                    'label' => __( 'Image Overlay', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'panel_slider_style' => '4',
                    ]
                ]
            );
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'image_overlay',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .panel_slider_style-4 .htmega-carousel-activation .panel-slider::before',
                    'condition' => [
                        'panel_slider_style' => '4',
                    ]
                ]
            );
            $this->add_responsive_control(
                'Image_box_padding',
                [
                    'label' => __( 'Image Box Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .panel-slider' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                    'condition' => [
                        'panel_slider_style' => '4',
                    ]
                ]
            );
        $this->end_controls_section(); // Slider Content end

        // Style Slider Title style start
        $this->start_controls_section(
            'slider_title_style',
            [
                'label'     => __( 'Title', 'ht-mega-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'slider_title_color',
                [
                    'label' => __( 'Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default'=>'',
                    'selectors' => [
                        '{{WRAPPER}} .panel-slider .content h2' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'slider_title_color_hover',
                [
                    'label' => __( 'Hover Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default'=>'',
                    'selectors' => [
                        '{{WRAPPER}} .panel-slider .content h2 a:hover' => 'color: {{VALUE}}',
                    ],
                    'condition' =>[
                        'linkshow_title' => 'yes',
                    ]
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'slider_title_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .panel-slider .content h2',
                ]
            );

            $this->add_responsive_control(
                'slider_title_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .panel-slider .content h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'slider_title_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .panel-slider .content h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section(); // Slider Title style end

        // Style Slider Sub Title style start
        $this->start_controls_section(
            'slider_subtitle_style',
            [
                'label'     => __( 'Sub Title', 'ht-mega-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'slider_subtitle_color',
                [
                    'label' => __( 'Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default'=>'',
                    'selectors' => [
                        '{{WRAPPER}} .panel-slider .content span' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'slider_subtitle_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .panel-slider .content span',
                ]
            );

            $this->add_responsive_control(
                'slider_subtitle_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .panel-slider .content span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'slider_subtitle_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .panel-slider .content span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section(); // Slider Title style end

        // Style Slider arrow style start
        $this->start_controls_section(
            'slider_arrow_style',
            [
                'label'     => __( 'Arrow', 'ht-mega-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' =>[
                    'slider_on' => 'yes',
                    'slarrows'  => 'yes',
                ],
            ]
        );
        
            $this->start_controls_tabs( 'slider_arrow_style_tabs' );

                // Normal tab Start
                $this->start_controls_tab(
                    'slider_arrow_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'slider_arrow_color',
                        [
                            'label' => __( 'Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow svg path' => 'fill: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'slider_arrow_fontsize',
                        [
                            'label' => __( 'Font Size', 'ht-mega-for-elementor' ),
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
                            'selectors' => [
                                '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
                                '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow svg' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'slider_arrow_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'slider_arrow_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow',
                        ]
                    );

                    $this->add_responsive_control(
                        'slider_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );
                    $this->add_responsive_control(
                        'slider_border_radius_next',
                        [
                            'label' => esc_html__( 'Border Radius Next Button', 'ht-mega-for-elementor' ),
                            'description' => esc_html__( 'If need to different from prev button', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow.htmega-carosul-next' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );
                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'slider_boxshadow',
                            'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow',
                        ]
                    );
                    $this->add_responsive_control(
                        'slider_arrow_height',
                        [
                            'label' => __( 'Height', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 50,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow' => 'height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'slider_arrow_width',
                        [
                            'label' => __( 'Width', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 500,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 50,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'slider_arrow_padding',
                        [
                            'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );
                    $this->add_responsive_control(
                        'slider_arrow_horizontal_postion',
                        [
                            'label' => __( 'Horizontal Position', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => -1200,
                                    'max' => 1200,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => -100,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow' => 'left: {{SIZE}}{{UNIT}};',
                                '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow.htmega-carosul-next' => 'right: {{SIZE}}{{UNIT}}; left:auto;',
                            ],
                        ]
                    );
                    $this->add_responsive_control(
                        'slider_arrow_vertical_postion',
                        [
                            'label' => __( 'Vertical Position', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => -1200,
                                    'max' => 1200,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => -100,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow' => 'margin-top: {{SIZE}}{{UNIT}};margin-bottom:0px;',
                            ],
                            
                        ]
                    );
                $this->end_controls_tab(); // Normal tab end

                // Hover tab Start
                $this->start_controls_tab(
                    'slider_arrow_style_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'slider_arrow_hover_color',
                        [
                            'label' => __( 'Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#00282a',
                            'selectors' => [
                                '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow:hover' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow:hover svg path' => 'fill: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'slider_arrow_hover_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow:hover',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'slider_arrow_hover_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow:hover',
                        ]
                    );

                    $this->add_responsive_control(
                        'slider_arrow_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );
                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'slider_boxshadow_hover',
                            'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-carousel-activation button.slick-arrow:hover',
                        ]
                    );
        
                $this->end_controls_tab(); // Hover tab end

            $this->end_controls_tabs();

        $this->end_controls_section(); // Style Slider arrow style end

        // Style Pagination button tab section
        $this->start_controls_section(
            'post_slider_pagination_style_section',
            [
                'label' => __( 'Pagination', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'slider_on' => 'yes',
                    'sldots'=>'yes',
                ]
            ]
        );
            
            $this->start_controls_tabs('pagination_style_tabs');

                $this->start_controls_tab(
                    'pagination_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_responsive_control(
                        'slider_pagination_height',
                        [
                            'label' => __( 'Height', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 15,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-carousel-activation .slick-dots li button' => 'height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'slider_pagination_width',
                        [
                            'label' => __( 'Width', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 15,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-carousel-activation .slick-dots li button' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'pagination_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-carousel-activation .slick-dots li button',
                        ]
                    );

                    $this->add_responsive_control(
                        'pagination_margin',
                        [
                            'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-carousel-activation .slick-dots li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'pagination_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-carousel-activation .slick-dots li button',
                        ]
                    );

                    $this->add_responsive_control(
                        'pagination_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-carousel-activation .slick-dots li button' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Normal Tab end

                $this->start_controls_tab(
                    'pagination_style_active_tab',
                    [
                        'label' => __( 'Active', 'ht-mega-for-elementor' ),
                    ]
                );
                    
                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'pagination_hover_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-carousel-activation .slick-dots li:hover button, {{WRAPPER}} .htmega-carousel-activation .slick-dots li.slick-active button',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'pagination_hover_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-carousel-activation .slick-dots li button:hover, {{WRAPPER}} .htmega-carousel-activation .slick-dots li.slick-active button',
                        ]
                    );

                    $this->add_responsive_control(
                        'pagination_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-carousel-activation .slick-dots li.slick-active button' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                                '{{WRAPPER}} .htmega-carousel-activation .slick-dots li:hover button' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Hover Tab end

            $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();

        
        $custom_width_class = ('yes' == $settings['slcentermode'] && 'yes' == $settings['variable_width']) ? 'htmega-custom-width' : '';

        $this->add_render_attribute( 'htmega_panel_sliderarea_attr', 'class', 'panel_slider_area panel_slider_style-'. esc_attr( $settings['panel_slider_style'] .' '.$custom_width_class ) );


        // Slider options
        if( $settings['slider_on'] == 'yes' ){

            $direction = is_rtl() ? 'rtl' : 'ltr';
            $this->add_render_attribute( 'htmega_panel_slider_attr', 'dir', $direction );
            
            $this->add_render_attribute( 'htmega_panel_slider_attr', 'class', 'panel-slider-wrapper htmega-carousel-activation' );

            $slider_settings = [
                'arrows' => ('yes' === $settings['slarrows']),
                'arrow_prev_txt' => HTMega_Icon_manager::render_icon( $settings['slprevicon'], [ 'aria-hidden' => 'true' ] ),
                'arrow_next_txt' => HTMega_Icon_manager::render_icon( $settings['slnexticon'], [ 'aria-hidden' => 'true' ] ),
                'dots' => ('yes' === $settings['sldots']),
                'autoplay' => ('yes' === $settings['slautolay']),
                'autoplay_speed' => absint($settings['slautoplay_speed']),
                'animation_speed' => absint($settings['slanimation_speed']),
                'pause_on_hover' => ('yes' === $settings['slpause_on_hover']),
                'center_mode' => ( 'yes' === $settings['slcentermode']),
                'center_padding' => absint($settings['slcenterpadding']),
                'variable_width' => ('yes' === $settings['variable_width']),
            ];

            $slider_responsive_settings = [
                'display_columns' => absint( $settings['slitems'] ),
                'scroll_columns' => absint( $settings['slscroll_columns'] ),
                'tablet_width' => absint( $settings['sltablet_width'] ),
                'tablet_display_columns' => absint( $settings['sltablet_display_columns'] ),
                'tablet_scroll_columns' => absint( $settings['sltablet_scroll_columns'] ),
                'mobile_width' => absint( $settings['slmobile_width'] ),
                'mobile_display_columns' => absint( $settings['slmobile_display_columns'] ),
                'mobile_scroll_columns' => absint( $settings['slmobile_scroll_columns'] ),

            ];

            $slider_settings = array_merge( $slider_settings, $slider_responsive_settings );

            $this->add_render_attribute( 'htmega_panel_slider_attr', 'data-settings', wp_json_encode( $slider_settings ) );
        }
       
        ?>
            <div <?php echo $this->get_render_attribute_string( 'htmega_panel_sliderarea_attr' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string(). ?> >
                <div <?php echo $this->get_render_attribute_string( 'htmega_panel_slider_attr' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string(). ?> style="display:none">

                    <?php foreach ( $settings['panel_slider_list'] as $sliders ):
                        $url = esc_attr( $sliders['_id'] );
                        if ( ! empty( $sliders['external_link']['url'] ) ) {
                            $this->add_link_attributes( $url, $sliders['external_link'] );
                        }
                        
                        ?>
                        <div class="panel-slider">
                            <div class="thumb">
                            <?php
                            if( $sliders['external_link']['url']  && 'yes' == $settings['linkshow_image'] ){

                                echo '<a '.$this->get_render_attribute_string( $url).' >'.Group_Control_Image_Size::get_attachment_image_html( $sliders, 'slider_image_size', 'slider_image' ).'</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string(); Group_Control_Image_Size::get_attachment_image_html() builds output via wp_get_attachment_image().

                            } else {
                                echo Group_Control_Image_Size::get_attachment_image_html( $sliders, 'slider_image_size', 'slider_image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor core, builds output via wp_get_attachment_image().
                            }
                                ?>
                            </div>
                            <?php if( $settings['panel_slider_style'] == 3 ) { echo '<div class="content-inner">'; } ?>
                                <?php if( !empty( $sliders['slider_title'] ) || !empty( $sliders['slider_sub_title'] )): ?>
                                <div class="content">
                                    <?php
                                        if( !empty( $sliders['slider_title'] ) ){
                                            
                                            if( $sliders['external_link']['url']  && 'yes' == $settings['linkshow_title'] ){
                                                echo '<h2><a '.$this->get_render_attribute_string( $url).' >'.esc_html( $sliders['slider_title'] ).'</a></h2>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string().
                                            } else {
                                                echo '<h2>'.esc_html( $sliders['slider_title'] ).'</h2>';
                                            }
                                            
                                        }
                                        if( !empty( $sliders['slider_sub_title'] ) ){
                                            echo '<span>'.esc_html( $sliders['slider_sub_title'] ).'</span>';
                                        }
                                    ?>
                                </div>
                            <?php endif; if( $settings['panel_slider_style'] == 3 ) { echo '</div>'; }?>
                        </div>
                    <?php endforeach;?>

                </div>
            </div>
        <?php

    }

}

