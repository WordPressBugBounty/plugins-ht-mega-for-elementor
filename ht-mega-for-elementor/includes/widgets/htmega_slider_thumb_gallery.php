<?php
namespace Elementor;

// Elementor Classes
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_Slider_Thumb_Gallery extends Widget_Base {

    public function get_name() {
        return 'htmega-thumbgallery-addons';
    }
    
    public function get_title() {
        return __( 'Slider Thumbnail Gallery', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-thumbnails-down';
    }

    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_style_depends() {
        return [
            'elementor-icons-shared-0-css','elementor-icons-fa-brands','elementor-icons-fa-regular','elementor-icons-fa-solid','slick'
        ];
    }

    public function get_script_depends() {
        return [
            'slick'
        ];
    }
    public function get_keywords() {
        return [ 'thumbnail gallery', 'slider thumbnail gallery widget', 'thumbnails gallery','gallery','slider','thumbnail', 'htmega', 'ht mega' ];
    }

    public function get_help_url() {
		return 'https://wphtmega.com/docs/general-widgets/slider-thumbnails-gallery-widget/';
	}
    protected function is_dynamic_content():bool {
		return false;
	}
    protected function register_controls() {

        $this->start_controls_section(
            'thumbnails_gallery_content',
            [
                'label' => __( 'Slider Thumbnail', 'ht-mega-for-elementor' ),
            ]
        );
            $this->add_control(
                'sliderthumbnails_style',
                [
                    'label' => __( 'Thumbnail Position', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '1',
                    'options' => [
                        '1'   => __( 'Right', 'ht-mega-for-elementor' ),
                        '2'   => __( 'Bottom', 'ht-mega-for-elementor' ),
                        '3'   => __( 'Left', 'ht-mega-for-elementor' ),
                        '4'   => __( 'Top', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'slider_title',
                [
                    'label'   => __( 'Title', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => __('Location Name Here.','ht-mega-for-elementor'),
                ]
            );
            $repeater->add_control(
                'slider_sub_title',
                [
                    'label'   => __( 'Sub Title', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );

            $repeater->add_control(
                'slider_image',
                [
                    'label' => __( 'Image', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::MEDIA,
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );

            $repeater->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'slider_imagesize',
                    'default' => 'large',
                    'separator' => 'none',
                ]
            );

            $repeater->add_control(
                'more_options',
                [
                    'label' => __( 'Thumbnails Image Size', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $repeater->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'slider_thumbnails_imagesize',
                    'default' => 'large',
                    'separator' => 'none',
                ]
            );

            $this->add_control(
                'slider_list',
                [
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $repeater->get_controls(),
                    'default' => [

                        [
                            'slider_title'           => esc_html__( 'Mountain Hills, USA', 'ht-mega-for-elementor' ),
                            'slider_sub_title'       => esc_html__( 'Photo by David Swindler', 'ht-mega-for-elementor' ),
                            'slider_image'           => [
                                'url' => esc_url( HTMEGA_ADDONS_PL_URL . 'assets/widgets/thumbnail-slider/images/image1.jpg' ),
                            ],
                        ],
                        [
                            'slider_title'           => esc_html__( 'Mountain river, USA', 'ht-mega-for-elementor' ),
                            'slider_sub_title'           => esc_html__( 'Photo by David Swindler', 'ht-mega-for-elementor' ),
                            'slider_image'           => [
                                'url' => esc_url( HTMEGA_ADDONS_PL_URL . 'assets/widgets/thumbnail-slider/images/image2.jpg' ),
                            ]
                        ],
                        [
                            'slider_title'           =>esc_html__( 'Mountain Hills, USA', 'ht-mega-for-elementor' ),
                            'slider_sub_title'           => esc_html__( 'Photo by David Swindler', 'ht-mega-for-elementor' ),
                            'slider_image'           => [
                                'url' => esc_url( HTMEGA_ADDONS_PL_URL . 'assets/widgets/thumbnail-slider/images/image3.jpg' ),
                            ]
                        ],

                    ],
                    'title_field' => '{{{ slider_title }}}',
                ]
            );

        $this->end_controls_section();

        // Slider setting
        $this->start_controls_section(
            'slider_option',
            [
                'label' => esc_html__( 'Slider Option', 'ht-mega-for-elementor' ),
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
                    'default' => 1,
                    
                ]
            );

            $this->add_control(
                'slarrows',
                [
                    'label' => esc_html__( 'Slider Arrow', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                    
                ]
            );

            $this->add_control(
                'slprevicon',
                [
                    'label' => __( 'Previous icon', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value'=>'fas fa-angle-left',
                        'library'=>'fa-solid',
                    ],
                    'condition' => [
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
                        'library'=>'fa-solid',
                    ],
                    'condition' => [
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
                   
                ]
            );

            $this->add_control(
                'slcentermode',
                [
                    'label' => esc_html__( 'Center Mode', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                    
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
                    'default' => 50,
                    'condition' => [
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
                    
                ]
            );

            $this->add_control(
                'slautoplay_speed',
                [
                    'label' => __('Autoplay speed', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 3000,
                    
                ]
            );


            $this->add_control(
                'slanimation_speed',
                [
                    'label' => __('Autoplay animation speed', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 300,
                    
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
                   
                ]
            );

            $this->add_control(
                'heading_tablet',
                [
                    'label' => __( 'Tablet', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                    
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
                    
                ]
            );

            $this->add_control(
                'sltablet_width',
                [
                    'label' => __('Tablet Resolution', 'ht-mega-for-elementor'),
                    'description' => __('The resolution to tablet.', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 750,
                   
                ]
            );

            $this->add_control(
                'heading_mobile',
                [
                    'label' => __( 'Mobile Phone', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                    
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
                   
                ]
            );

            $this->add_control(
                'slmobile_width',
                [
                    'label' => __('Mobile Resolution', 'ht-mega-for-elementor'),
                    'description' => __('The resolution to mobile.', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 480,
                    
                ]
            );

        $this->end_controls_section(); // Slider Option end

        // Slider Nav option setting
        $this->start_controls_section(
            'slider_nav_option',
            [
                'label' => esc_html__( 'Thumbnails Gallery Option', 'ht-mega-for-elementor' ),
            ]
        );

            $this->add_control(
                'slnavitems',
                [
                    'label' => esc_html__( 'Thumbnails Items', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 20,
                    'step' => 1,
                    'default' => 4,
                    
                ]
            );

            $this->add_control(
                'slnavarrows',
                [
                    'label' => esc_html__( 'Thumbnails Arrow', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                    
                ]
            );

            $this->add_control(
                'slnavprevicon',
                [
                    'label' => __( 'Thumbnails Previous icon', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value'=>'fas fa-angle-left',
                        'library'=>'fa-solid',
                    ],
                    'condition' => [
                        'slnavarrows' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slnavnexticon',
                [
                    'label' => __( 'Thumbnails Next icon', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value'=>'fas fa-angle-right',
                        'library'=>'fa-solid',
                    ],
                    'condition' => [
                        'slnavarrows' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slnavdots',
                [
                    'label' => esc_html__( 'Thumbnails dots', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                    
                ]
            );

            $this->add_control(
                'slnavvertical',
                [
                    'label' => esc_html__( 'Vertical Slide', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                    
                ]
            );

            $this->add_control(
                'slnavpause_on_hover',
                [
                    'type' => Controls_Manager::SWITCHER,
                    'label_off' => __('No', 'ht-mega-for-elementor'),
                    'label_on' => __('Yes', 'ht-mega-for-elementor'),
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'label' => __('Pause on Hover?', 'ht-mega-for-elementor'),
                   
                ]
            );

            $this->add_control(
                'slnavcentermode',
                [
                    'label' => esc_html__( 'Thumbnails Center Mode', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                    
                ]
            );

            $this->add_control(
                'slnavcenterpadding',
                [
                    'label' => esc_html__( 'Thumbnails Center padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 0,
                    'max' => 500,
                    'step' => 1,
                    'default' => 50,
                    'condition' => [
                        'slnavcentermode' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slnavautolay',
                [
                    'label' => esc_html__( 'Thumbnails auto play', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'separator' => 'before',
                    'default' => 'no',
                    
                ]
            );

            $this->add_control(
                'slnavautoplay_speed',
                [
                    'label' => __('Thumbnails Autoplay speed', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 3000,
                    
                ]
            );


            $this->add_control(
                'slnavanimation_speed',
                [
                    'label' => __('Thumbnails Autoplay animation speed', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 300,
                    
                ]
            );

            $this->add_control(
                'slnavscroll_columns',
                [
                    'label' => __('Thumbnails Slider item to scroll', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 10,
                    'step' => 1,
                    'default' => 1,
                   
                ]
            );

            $this->add_control(
                'heading_nav_tablet',
                [
                    'label' => __( 'Thumbnails Tablet', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                    
                ]
            );

            $this->add_control(
                'slnavtablet_display_columns',
                [
                    'label' => __('Thumbnails Items', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 20,
                    'step' => 1,
                    'default' => 1,
                    
                ]
            );

            $this->add_control(
                'slnavtablet_scroll_columns',
                [
                    'label' => __('Thumbnails item to scroll', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 20,
                    'step' => 1,
                    'default' => 1,
                    
                ]
            );

            $this->add_control(
                'slnavtablet_width',
                [
                    'label' => __('Thumbnails Tablet Resolution', 'ht-mega-for-elementor'),
                    'description' => __('The resolution to tablet.', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 750,
                   
                ]
            );

            $this->add_control(
                'heading_nav_mobile',
                [
                    'label' => __( 'Thumbnails Mobile Phone', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                    
                ]
            );
            $this->add_control(
                'hide_on_mobile',
                [
                    'label' => esc_html__( 'Hide on Mobile', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );
            $this->add_control(
                'slnavmobile_display_columns',
                [
                    'label' => __('Thumbnails Items', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 4,
                    'step' => 1,
                    'default' => 1,
                    'condition' =>[
                        'hide_on_mobile!'=>'yes'
                    ]
                    
                ]
            );

            $this->add_control(
                'slnavmobile_scroll_columns',
                [
                    'label' => __('Thumbnails item to scroll', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 4,
                    'step' => 1,
                    'default' => 1,
                    'condition' =>[
                        'hide_on_mobile!'=>'yes'
                    ]
                   
                ]
            );

            $this->add_control(
                'slnavmobile_width',
                [
                    'label' => __('Thumbnails Mobile Resolution', 'ht-mega-for-elementor'),
                    'description' => __('The resolution to mobile.', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 480,
                    
                ]
            );

        $this->end_controls_section(); // Slider Option end

        // Style Title Style start
        $this->start_controls_section(
            'slider_title_style',
            [
                'label'     => __( 'Content Box Style', 'ht-mega-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'box_bg_style',
            [
                'label' => __( 'Slide BG Image Style', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'wrapper_border_style',
                'label' => __( 'Border', 'ht-mega-for-elementor' ),
                'selector' => '{{WRAPPER}} .ht-thumb-gallery ul.htmega-thumbgallery-for li img',
            ]
        );

        $this->add_responsive_control(
            'wrapper_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .ht-thumb-gallery ul.htmega-thumbgallery-for li img' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->add_control(
            'title_style',
            [
                'label' => __( 'Title Style', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
            $this->add_control(
                'slider_title_color',
                [
                    'label' => __( 'Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .htmega-thumbgallery-for .content h2' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'slider_title_typography',
                    'selector' => '{{WRAPPER}} .htmega-thumbgallery-for .content h2',
                ]
            );

            $this->add_responsive_control(
                'slider_title_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-thumbgallery-for .content h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );
            $this->add_responsive_control(
                'slider_title_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-thumbgallery-for .content h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_control(
                'sub_title_style',
                [
                    'label' => __( 'Sub Title Style', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'slider_sub_title_color',
                [
                    'label' => __( 'Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .htmega-thumbgallery-for .content h4' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'slider_sub_title_typography',
                    'selector' => '{{WRAPPER}} .htmega-thumbgallery-for .content h4',
                ]
            );
            $this->add_control(
                'box_style',
                [
                    'label' => __( 'Content Box', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_responsive_control(
                'content_box_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-thumbgallery-for .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );
            $this->add_responsive_control(
                'content_box_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-thumbgallery-for .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'slider_title_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-thumbgallery-for .content',
                ]
            );

        $this->end_controls_section(); // Title Style end

        // Style Testimonial arrow style start
        $this->start_controls_section(
            'slider_thumbnails_arrow_style',
            [
                'label'     => __( 'Arrow', 'ht-mega-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' =>[
                    'slarrows'  => 'yes',
                ],
            ]
        );
            
            $this->start_controls_tabs( 'thumbnails_arrow_style_tabs' );

                // Normal tab Start
                $this->start_controls_tab(
                    'thumbnails_arrow_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'thumbnails_arrow_color',
                        [
                            'label' => __( 'Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .htmega-thumbgallery-for button,{{WRAPPER}} .htmega-thumbgallery-nav button.slick-arrow' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-thumbgallery-for button svg path,{{WRAPPER}} .htmega-thumbgallery-nav button.slick-arrow svg path' => 'fill: {{VALUE}};transition: all 0.3s ease-in-out;',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'thumbnails_arrow_fontsize',
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
                            'default' => [
                                'unit' => 'px',
                                'size' => 18,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-thumbgallery-for button.slick-arrow,{{WRAPPER}} .htmega-thumbgallery-nav button.slick-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
                                '{{WRAPPER}} .htmega-thumbgallery-for button.slick-arrow svg,{{WRAPPER}} .htmega-thumbgallery-nav button.slick-arrow svg' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'thumbnails_arrow_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-thumbgallery-for button.slick-arrow,{{WRAPPER}} .htmega-thumbgallery-nav button.slick-arrow',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'thumbnails_arrow_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-thumbgallery-for .slick-arrow,{{WRAPPER}} .htmega-thumbgallery-nav button.slick-arrow',
                        ]
                    );

                    $this->add_responsive_control(
                        'thumbnails_arrow_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-thumbgallery-for .slick-arrow,{{WRAPPER}} .htmega-thumbgallery-nav button.slick-arrow' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'thumbnails_arrow_height',
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
                                '{{WRAPPER}} .htmega-thumbgallery-for .slick-arrow,{{WRAPPER}} .htmega-thumbgallery-nav button.slick-arrow' => 'height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'thumbnails_arrow_width',
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
                                'size' => 50,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-thumbgallery-for .slick-arrow,{{WRAPPER}} .htmega-thumbgallery-nav button.slick-arrow' => 'width: {{SIZE}}{{UNIT}};',
                            ],
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
                                '{{WRAPPER}} .htmega-thumbgallery-for .slick-arrow' => 'left: {{SIZE}}{{UNIT}};',
                                '{{WRAPPER}} .htmega-thumbgallery-for .slick-arrow.htmega-carosul-next' => 'right: {{SIZE}}{{UNIT}}; left:auto;',
                            ],
                        ]
                    );
                    $this->add_responsive_control(
                        'thumbnails_arrow_padding',
                        [
                            'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-thumbgallery-for .slick-arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                $this->end_controls_tab(); // Normal tab end

                // Hover tab Start
                $this->start_controls_tab(
                    'thumbnails_arrow_style_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'thumbnails_arrow_hover_color',
                        [
                            'label' => __( 'Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .htmega-thumbgallery-for .slick-arrow:hover,{{WRAPPER}} .htmega-thumbgallery-nav button.slick-arrow:hover' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-thumbgallery-for .slick-arrow:hover svg path,{{WRAPPER}} .htmega-thumbgallery-nav button.slick-arrow:hover svg path' => 'fill: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'thumbnails_arrow_hover_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-thumbgallery-for .slick-arrow:hover,{{WRAPPER}} .htmega-thumbgallery-nav button.slick-arrow:hover',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'thumbnails_arrow_hover_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-thumbgallery-for .slick-arrow:hover,{{WRAPPER}} .htmega-thumbgallery-nav button.slick-arrow:hover',
                        ]
                    );

                    $this->add_responsive_control(
                        'thumbnails_arrow_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-thumbgallery-for .slick-arrow:hover,{{WRAPPER}} .htmega-thumbgallery-nav button.slick-arrow:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Hover tab end

            $this->end_controls_tabs();

        $this->end_controls_section(); // Style Testimonial arrow style end


        // Style Testimonial Dots style start
        $this->start_controls_section(
            'thumbnails_dots_style',
            [
                'label'     => __( 'Pagination', 'ht-mega-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                        'terms' => [
                                ['name' => 'sldots', 'operator' => '===', 'value' => 'yes']
                            ]
                        ],
                        [
                        'terms' => [
                                ['name' => 'slnavdots', 'operator' => '===', 'value' => 'yes'],
                            ]
                        ],
                    ]
                ], 

            ]
        );
            
            $this->start_controls_tabs( 'thumbnails_dots_style_tabs' );

                // Normal tab Start
                $this->start_controls_tab(
                    'thumbnails_dots_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'thumbnails_dots_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-thumbgallery-for .slick-dots li button,{{WRAPPER}} .htmega-thumbgallery-nav .slick-dots li button',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'thumbnails_dots_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-thumbgallery-for .slick-dots li button,{{WRAPPER}} .htmega-thumbgallery-nav .slick-dots li button',
                        ]
                    );

                    $this->add_responsive_control(
                        'thumbnails_dots_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-thumbgallery-for .slick-dots li button,{{WRAPPER}} .htmega-thumbgallery-nav .slick-dots li button' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_control(
                        'thumbnails_dots_height',
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
                                'size' => 12,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-thumbgallery-for .slick-dots li button,{{WRAPPER}} .htmega-thumbgallery-nav .slick-dots li button' => 'height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'thumbnails_dots_width',
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
                                'size' => 12,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-thumbgallery-for .slick-dots li button,{{WRAPPER}} .htmega-thumbgallery-nav .slick-dots li button' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Normal tab end

                // Hover tab Start
                $this->start_controls_tab(
                    'thumbnails_dots_style_hover_tab',
                    [
                        'label' => __( 'Active', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'thumbnails_dots_hover_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-thumbgallery-for .slick-dots li.slick-active button,{{WRAPPER}} .htmega-thumbgallery-nav .slick-dots li.slick-active button',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'thumbnails_dots_hover_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-thumbgallery-for .slick-dots li.slick-active button,{{WRAPPER}} .htmega-thumbgallery-nav .slick-dots li.slick-active button',
                        ]
                    );

                    $this->add_responsive_control(
                        'thumbnails_dots_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-thumbgallery-for .slick-dots li.slick-active button,{{WRAPPER}} .htmega-thumbgallery-nav .slick-dots li.slick-active button' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Hover tab end

            $this->end_controls_tabs();

        $this->end_controls_section(); // Style Thumb dots style end

        // Thumbnail gallery hover style start
        $this->start_controls_section(
            'thumbnails_thumbnail_style',
            [
                'label'     => __( 'Thumbnail Style', 'ht-mega-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_responsive_control(
                'thumbnails_slider_iner_space',
                [
                    'label' => __( 'Slider & Thumb Inner space', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -200,
                            'max' => 200,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-thumbnails-style-1 .htb-row .htb-col-lg-10' => 'padding-right: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .htmega-thumbnails-style-1 .htb-row .htmega-nav-col' => 'padding-left: 0;',
                        '{{WRAPPER}} .htmega-thumbnails-style-3 .htb-row .htb-col-lg-10' => 'padding-left: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .htmega-thumbnails-style-3 .htb-row .htmega-nav-col' => 'padding-right: 0;',
                        '{{WRAPPER}} .htmega-thumbnails-style-2 .htb-row .htmega-nav-col' => 'margin-top: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .htmega-thumbnails-style-4 .htb-row .htmega-nav-col' => 'margin-bottom: {{SIZE}}{{UNIT}};',

                    ],
                ]
            );

            $this->add_responsive_control(
                'thumbnails_space',
                [
                    'label' => __( 'Item space', 'ht-mega-for-elementor' ),
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
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htb-row' => 'margin-left:-{{SIZE}}{{UNIT}};margin-right: -{{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .htb-row > [class*="col"]' => 'padding-left:{{SIZE}}{{UNIT}};padding-right: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .htmega-thumbgallery-nav.htmega-thumbgallery-nav .slick-slide' => 'padding-top:{{SIZE}}{{UNIT}};padding-bottom: {{SIZE}}{{UNIT}};padding-left:0; padding-right:0;',
                        '{{WRAPPER}} .htmega-thumbnails-style-2 .htmega-thumbgallery-nav.htmega-thumbgallery-nav .slick-slide' => 'padding-right:{{SIZE}}{{UNIT}};padding-bottom:0',
                        '{{WRAPPER}} .htmega-thumbnails-style-2 .htmega-thumbgallery-nav.htmega-thumbgallery-nav,{{WRAPPER}} .htmega-thumbnails-style-4 .htmega-thumbgallery-nav.htmega-thumbgallery-nav' => 'margin-right:-{{SIZE}}{{UNIT}};',

                        '{{WRAPPER}} .htmega-thumbnails-style-4 .htmega-thumbgallery-nav.htmega-thumbgallery-nav .slick-slide' => 'padding-top:0;padding-right:{{SIZE}}{{UNIT}};',

                        '{{WRAPPER}} .slick-vertical .slick-slide' => 'border:none;',
                    ],
                ]
            );
            $this->add_control(
                'thumbnails_color_border_heading',
                [
                    'label' => __( 'Colors and Border', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->start_controls_tabs( 'thumbnails_thumbnail_style_tabs' );

                // Normal tab Start
                $this->start_controls_tab(
                    'thumbnails_thumbnail_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );
                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'thumbnails_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-thumbgallery-nav .small-thumb img',
                        ]
                    );

                    $this->add_responsive_control(
                        'thumbnails_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-thumbgallery-nav .small-thumb img,{{WRAPPER}} .htmega-thumbgallery-nav .small-thumb' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Normal tab end

                // Hover tab Start
                $this->start_controls_tab(
                    'thumbnails_style_hover_tab',
                    [
                        'label' => __( 'Active', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'thumbnails_hover_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-thumbgallery-nav .small-thumb:after',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'thumbnails_hover_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-thumbgallery-nav .slick-slide.slick-current.slick-active.slick-center .small-thumb img,{{WRAPPER}} .htmega-thumbgallery-nav .slick-slide.slick-current .small-thumb img',
                        ]
                    );

                    $this->add_responsive_control(
                        'thumbnails_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-thumbgallery-nav .slick-slide.slick-current.slick-active.slick-center .small-thumb img,{{WRAPPER}} .htmega-thumbgallery-nav .slick-slide.slick-current.slick-active.slick-center .small-thumb,{{WRAPPER}} .htmega-thumbgallery-nav .slick-slide.slick-current .small-thumb img,{{WRAPPER}} .htmega-thumbgallery-nav .slick-slide.slick-current .small-thumb' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Hover tab end

            $this->end_controls_tabs();

        $this->end_controls_section(); // Style Thumb gallery hover style end

    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        $sectionid = "sid". $this-> get_id();
        $this->add_render_attribute( 'htmega_thumbnail_sliderarea_attr', 'class', 'htmega-sliderarea htmega-thumbnails-style-' . esc_attr( $settings['sliderthumbnails_style'].' '. $sectionid ) );

        // Slider options
        $direction = is_rtl() ? 'rtl' : 'ltr';
        $this->add_render_attribute( 'htmega_thumbnails_slider_attr', 'dir', $direction );
        $this->add_render_attribute( 'htmega_thumbnails_slider_attr', 'class', 'htmega-thumbgallery-for htmega-arrow-' . esc_attr( $settings['sliderthumbnails_style'] ) );

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
        $this->add_render_attribute( 'htmega_thumbnails_slider_attr', 'data-settings', wp_json_encode( $slider_settings ) );


        // Thumbnails Slider options
        $this->add_render_attribute( 'htmega_thumbnails_navslider_attr', 'class', 'htmega-thumbgallery-nav ' );

        $nav_slider_settings = [
            'navarrows' => ('yes' === $settings['slnavarrows']),
            'navarrow_prev_txt' => HTMega_Icon_manager::render_icon( $settings['slnavprevicon'], [ 'aria-hidden' => 'true' ] ),
            'navarrow_next_txt' => HTMega_Icon_manager::render_icon( $settings['slnavnexticon'], [ 'aria-hidden' => 'true' ] ),
            'navdots' => ('yes' === $settings['slnavdots']),
            'navvertical' => ('yes' === $settings['slnavvertical']),
            'navautoplay' => ('yes' === $settings['slnavautolay']),
            'navautoplay_speed' => absint($settings['slnavautoplay_speed']),
            'navanimation_speed' => absint($settings['slnavanimation_speed']),
            'navpause_on_hover' => ('yes' === $settings['slnavpause_on_hover']),
            'navcenter_mode' => ( 'yes' === $settings['slnavcentermode']),
            'navcenter_padding' => absint($settings['slnavcenterpadding']),
        ];

        $nav_slider_responsive_settings = [
            'navdisplay_columns' => absint( $settings['slnavitems'] ),
            'navscroll_columns' => absint( $settings['slnavscroll_columns'] ),
            'navtablet_width' => absint( $settings['sltablet_width'] ),
            'navtablet_display_columns' => absint( $settings['slnavtablet_display_columns'] ),
            'navtablet_scroll_columns' => absint( $settings['slnavtablet_scroll_columns'] ),
            'navmobile_width' => absint( $settings['slnavmobile_width'] ),
            'navmobile_display_columns' => absint( $settings['slnavmobile_display_columns'] ),
            'navmobile_scroll_columns' => absint( $settings['slnavmobile_scroll_columns'] ),

        ];

        $nav_slider_settings = array_merge( $nav_slider_settings, $nav_slider_responsive_settings );
        $this->add_render_attribute( 'htmega_thumbnails_navslider_attr', 'data-navsettings', wp_json_encode( $nav_slider_settings ) );

       
        ?>
            <div <?php echo $this->get_render_attribute_string( 'htmega_thumbnail_sliderarea_attr' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string(). ?> >
                <div class="htb-row row--5 htb-align-items-center mt--40">

                    <?php if( $settings['sliderthumbnails_style'] == 3 ): ?>
                        <div class="htb-col-lg-2 htb-col-md-2 htb-col-sm-2 htmega-nav-col">
                            <div <?php echo $this->get_render_attribute_string( 'htmega_thumbnails_navslider_attr' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string(). ?> style="display:none">
                                <?php foreach ( $settings['slider_list'] as $slideritem ) :?>
                                    <div class="small-thumb">
                                        <?php
                                            echo Group_Control_Image_Size::get_attachment_image_html( $slideritem, 'slider_thumbnails_imagesize', 'slider_image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor core, builds output via wp_get_attachment_image().
                                        ?>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                        <div class="htb-col-lg-10 htb-col-md-10 htb-col-sm-10">
                            <div class="ht-thumb-gallery">
                                <ul <?php echo $this->get_render_attribute_string( 'htmega_thumbnails_slider_attr' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string(). ?>  style="display:none;">
                                    <?php foreach ( $settings['slider_list'] as $slideritem ) :?>
                                        <li>
                                            <?php
                                                echo Group_Control_Image_Size::get_attachment_image_html( $slideritem, 'slider_imagesize', 'slider_image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor core, builds output via wp_get_attachment_image().

                                                if( !empty( $slideritem['slider_title'] ) || !empty( $slideritem['slider_sub_title'] ) ){
                                                    echo '<div class="content right-bottom">';
                                                    if( !empty( $slideritem['slider_title'] ) ){
                                                        echo '<h2>'.esc_html( $slideritem['slider_title'] ).'</h2>';
                                                    }
                                                    if( !empty( $slideritem['slider_sub_title'] ) ){
                                                        echo '<h4>'.esc_html( $slideritem['slider_sub_title'] ).'</h4>';
                                                    }
                                                    echo '</div>';
                                                }
                                            ?>
                                        </li>
                                    <?php endforeach;?>
                                </ul>

                            </div>
                        </div>

                    <?php elseif( $settings['sliderthumbnails_style'] == 4 ): ?>
                        <div class="htb-col-lg-12 htmega-nav-col">
                            <div <?php echo $this->get_render_attribute_string( 'htmega_thumbnails_navslider_attr' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string(). ?> style="display:none">
                                <?php foreach ( $settings['slider_list'] as $slideritem ) :?>
                                    <div class="small-thumb">
                                        <?php
                                            echo Group_Control_Image_Size::get_attachment_image_html( $slideritem, 'slider_thumbnails_imagesize', 'slider_image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor core, builds output via wp_get_attachment_image().
                                        ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="htb-col-lg-12">
                            <div class="ht-thumb-gallery">
                                <ul <?php echo $this->get_render_attribute_string( 'htmega_thumbnails_slider_attr' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string(). ?> style="display:none">
                                    <?php foreach ( $settings['slider_list'] as $slideritem ) :?>
                                        <li>
                                            <?php
                                                echo Group_Control_Image_Size::get_attachment_image_html( $slideritem, 'slider_imagesize', 'slider_image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor core, builds output via wp_get_attachment_image().
                                                if( !empty( $slideritem['slider_title'] ) || !empty( $slideritem['slider_sub_title'] ) ){
                                                    echo '<div class="content">';
                                                    if( !empty( $slideritem['slider_title'] ) ){
                                                        echo '<h2>'.esc_html( $slideritem['slider_title'] ).'</h2>';
                                                    }
                                                    if( !empty( $slideritem['slider_sub_title'] ) ){
                                                        echo '<h4>'.esc_html( $slideritem['slider_sub_title'] ).'</h4>';
                                                    }
                                                    echo '</div>';
                                                }
                                            ?>
                                        </li>
                                    <?php endforeach;?>
                                </ul>

                            </div>
                        </div>

                    <?php else:?>
                        <div class="<?php if( $settings['sliderthumbnails_style'] == 2 ){ echo esc_attr( 'htb-col-lg-12' );}else{ echo esc_attr( 'htb-col-lg-10 htb-col-md-10 htb-col-sm-10' ); } ?>">
                            <div class="ht-thumb-gallery">
                                <ul <?php echo $this->get_render_attribute_string( 'htmega_thumbnails_slider_attr' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string(). ?> style="display:none;" >
                                    <?php foreach ( $settings['slider_list'] as $slideritem ) : ?>
                                        <li>
                                            <?php
                                                echo Group_Control_Image_Size::get_attachment_image_html( $slideritem, 'slider_imagesize', 'slider_image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor core, builds output via wp_get_attachment_image().

                                                 if( !empty( $slideritem['slider_title'] ) || !empty( $slideritem['slider_sub_title'] ) ){
                                                    echo '<div class="content">';
                                                    if( !empty( $slideritem['slider_title'] ) ){
                                                        echo '<h2>'.esc_html( $slideritem['slider_title'] ).'</h2>';
                                                    }
                                                    if( !empty( $slideritem['slider_sub_title'] ) ){
                                                        echo '<h4>'.esc_html( $slideritem['slider_sub_title'] ).'</h4>';
                                                    }
                                                    echo '</div>';
                                                }


                                            ?>
                                        </li>
                                    <?php endforeach;?>
                                </ul>

                            </div>
                        </div>

                        <div class="<?php if( $settings['sliderthumbnails_style'] == 2 ){ echo esc_attr( 'htb-col-lg-12 htmega-nav-col' ); }else{ echo esc_attr( 'htb-col-lg-2 htb-col-md-2 htb-col-sm-2 htmega-nav-col' ); } ?>">
                            <div <?php echo $this->get_render_attribute_string( 'htmega_thumbnails_navslider_attr' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string(). ?> style="display:none;">
                                <?php foreach ( $settings['slider_list'] as $slideritem ) :?>
                                    <div class="small-thumb">
                                        <?php
                                            echo Group_Control_Image_Size::get_attachment_image_html( $slideritem, 'slider_thumbnails_imagesize', 'slider_image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor core, builds output via wp_get_attachment_image().
                                        ?>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    <?php endif;?>

                    <!-- End Thumb Gallery -->
                </div>
            </div>
            
            <?php 
            
            if( 'yes'== $settings['hide_on_mobile'] ){

                $slnavmobile_width  = $settings['slnavmobile_width'];

                    $htmega_print_css =  " @media (max-width: {$slnavmobile_width}px) {
                            .{$sectionid} .htmega-nav-col {
                                display:none;
                                } 
                            }";
                    ?>
                    <style>
                        <?php echo esc_html( $htmega_print_css ); ?>
                    </style>

                <?php } ?>
        <?php

    }

}

