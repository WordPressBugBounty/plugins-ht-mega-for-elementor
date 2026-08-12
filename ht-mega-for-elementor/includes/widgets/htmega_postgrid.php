<?php
namespace Elementor;

// Elementor Classes

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_PostGrid extends Widget_Base {

    public function get_name() {
        return 'htmega-postgrid-addons';
    }
    
    public function get_title() {
        return __( 'Post Grid', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-posts-grid';
    }

    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_keywords() {
        return [ 'post grid', 'post grid layout','custom post grid','post','htmega addons' ];
    }
    
    public function get_help_url() {
		return 'https://wphtmega.com/docs/post-widgets/post-grid-widget/';
	}
    protected function register_controls() {

        // Content Option Start
        $this->start_controls_section(
            'post_content_option',
            [
                'label' => __( 'Post Query', 'ht-mega-for-elementor' ),
            ]
            );
            $this->show_post_source();

        $this->end_controls_section(); // Content Option End
        $this->start_controls_section(
                'post_grid_content',
                [
                    'label' => __( 'Display Settings', 'ht-mega-for-elementor' ),
                ]
            );
            $this->add_control(
                'post_grid_style',
                [
                    'label' => __( 'Layout', 'ht-mega-for-elementor' ),
                    'type' => 'htmega-preset-select',
                    'default' => '1',
                    'options' => [
                        '1'   => __( 'Layout One', 'ht-mega-for-elementor' ),
                        '2'   => __( 'Layout Two', 'ht-mega-for-elementor' ),
                        '3'   => __( 'Layout Three', 'ht-mega-for-elementor' ),
                        '4'   => __( 'Layout Four', 'ht-mega-for-elementor' ),
                        '5'   => __( 'Layout Five', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'show_title',
                [
                    'label' => esc_html__( 'Show Title', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'title_length',
                [
                    'label' => __( 'Title Length', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::NUMBER,
                    'step' => 1,
                    'default' => 5,
                    'condition' => [
                        'show_title' => 'yes',
                    ]
                ]
            );
            $this->add_control(
                'title_tag',
                [
                    'label' => __('Title Tag', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'h4',
                    'options' => [
                        'h1' => __('H1', 'ht-mega-for-elementor'),
                        'h2' => __('H2', 'ht-mega-for-elementor'),
                        'h3' => __('H3', 'ht-mega-for-elementor'),
                        'h4' => __('H4', 'ht-mega-for-elementor'),
                        'h5' => __('H5', 'ht-mega-for-elementor'),
                        'h6' => __('H6', 'ht-mega-for-elementor'),
                        'span' => __('Span', 'ht-mega-for-elementor'),
                        'p' => __('P', 'ht-mega-for-elementor'),
                        'div' => __('Div', 'ht-mega-for-elementor'),
                    ],
                    'condition' => [
                        'show_title' => 'yes',
                    ]
                ]
            );
            $this->add_control(
                'show_category',
                [
                    'label' => esc_html__( 'Show Category', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'show_date',
                [
                    'label' => esc_html__( 'Show Date', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );
            $this->add_control(
                'show_content',
                [
                    'label' => esc_html__( 'Show Content', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );
            $this->add_control(
                'content_type',
                [
                    'label' => esc_html__( 'Content Source', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'content',
                    'options' => [
                        'content'          => esc_html__('Content','ht-mega-for-elementor'),
                        'excerpt'            => esc_html__('Excerpt','ht-mega-for-elementor'),
                    ],
                    'condition'=>[
                        'show_content'=>'yes',
                    ]
                ]
            );
            $this->add_control(
                'content_length',
                [
                    'label' => __( 'Content Length', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::NUMBER,
                    'step' => 1,
                    'default' => 20,
                    'condition'=>[
                        'show_content'=>'yes',
                    ]
                ]
            );
            $this->add_control(
                'show_read_more_btn',
                [
                    'label' => esc_html__( 'Read More Button', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );
    
            $this->add_control(
                'read_more_txt',
                [
                    'label' => __( 'Button Text', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Read More', 'ht-mega-for-elementor' ),
                    'placeholder' => __( 'Read More', 'ht-mega-for-elementor' ),
                    'label_block'=>true,
                    'condition'=>[
                        'show_read_more_btn'=>'yes',
                    ]
                ]
            );

        $this->end_controls_section();
        // Style tab section
        $this->start_controls_section(
            'post_items_style_section',
            [
                'label' => __( 'Items Style', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
            );
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'item_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .ht-post',
                    
                ]
            );  
            $this->add_responsive_control(
                'post_items_margin',
                [
                    'label' => __( 'Item Gap', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-post-grid-layout-1 .row-1 > [class*="col"] .ht-post,{{WRAPPER}} .htmega-post-grid-layout-3 .row-1 > [class*="col"] .ht-post ' =>'margin-top:0;',
                        '{{WRAPPER}} .htmega-post-grid-layout-1 .row-1 > [class*="col"], {{WRAPPER}} .htmega-post-grid-layout-3 .row-1 > [class*="col"]' =>'padding-bottom:1px; padding-top:1px;',
                        '{{WRAPPER}} .ht-post.black-overlay.mt--30, {{WRAPPER}} .ht-post.mt--20' =>'margin-top:{{TOP}}{{UNIT}};',

                        '{{WRAPPER}} .htmega-post-grid-layout-1 .row-1 > [class*="col"],
                        {{WRAPPER}} .htmega-post-grid-layout-3 .row-1 > [class*="col"],
                        {{WRAPPER}} .htmega-post-grid-layout-4 .row--10 > [class*="col"],
                        {{WRAPPER}} .htmega-post-grid-layout-5 .row--10 > [class*="col"]
                        
                        ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',                        
                        '{{WRAPPER}} .htmega-post-grid-layout-1 .htb-row,
                        {{WRAPPER}} .htmega-post-grid-layout-3 .htb-row,
                        {{WRAPPER}} .htmega-post-grid-layout-4 .htb-row,
                        {{WRAPPER}} .htmega-post-grid-layout-5 .htb-row
                        ' => 'margin: -{{TOP}}{{UNIT}} -{{RIGHT}}{{UNIT}} -{{BOTTOM}}{{UNIT}} -{{LEFT}}{{UNIT}};',

                        '{{WRAPPER}} .htmega-post-grid-layout-2 .ht-post' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; float:left',
                        '{{WRAPPER}} .htmega-post-grid-layout-2 .htb-row' => 'margin: -{{TOP}}{{UNIT}} -{{RIGHT}}{{UNIT}} -{{BOTTOM}}{{UNIT}} -{{LEFT}}{{UNIT}};',

                    ],
                   
                ]
            );
            $this->add_responsive_control(
                'item_box_padding',
                [
                    'label' => esc_html__('Item Padding', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .ht-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'item_box_border',
                    'label' => esc_html__('Border', 'ht-mega-for-elementor'),
                    'selector' => '{{WRAPPER}} .ht-post',
                ]
            );

            $this->add_responsive_control(
                'item_box_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-post' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'item_box_shadow',
                    'selector' => '{{WRAPPER}} .ht-post',
                ]
            );
            $this->add_control(
                'content_box_style_heading',
                [
                    'label' => __( 'Content Box Style', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_responsive_control(
                'post_items_item_padding_box',
                [
                    'label' => __( 'Content Box Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-post .post-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'post_items_item_margin_box',
                [
                    'label' => __( 'Content Box Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-post .post-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; width: auto; left:0; right:0;',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'content_box_bg',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .ht-post .post-content',
                    
                ]
            );  
            $this->add_responsive_control(
                'content_box_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .ht-post .post-content' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                    'separator' => 'before',
                ]
            );
            $this->add_responsive_control(
                'post_items_item_alignment_box',
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
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-post .post-content .content' => 'text-align: {{VALUE}};',
                    ],
                ]
            );
        $this->end_controls_section();

       // Group Item gradient Style
       $this->start_controls_section(
        'post_gridtab_gradients_tyle_items',
        [
            'label' => __( 'Custom Gradient Color', 'ht-mega-for-elementor' ),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition'=> [
                'post_grid_style'=> array('1','5'),
                
            ],
        ]
    );
        $this->add_control(
            'gradient1_heading',
            [
                'label' => __( 'Item One Gradient', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::HEADING,
            ]
        );  
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'gradient1',
                'label' => __( 'Gradient One', 'ht-mega-for-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .gradient-overlay.gradient-overlay-1 .thumb a::before',
                'separator'=>'after'
            ]
        );
        $this->add_control(
            'gradient2_heading',
            [
                'label' => __( 'Item Two Gradient', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator'=>'before'
            ]
        );  
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'gradient2',
                'label' => __( 'Gradient One', 'ht-mega-for-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .gradient-overlay.gradient-overlay-2 .thumb a::before',
                'separator'=>'before'
            ]
        );
        $this->add_control(
            'gradient3_heading',
            [
                'label' => __( 'Item Three Gradient', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator'=>'before'
            ]
        );  
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'gradient3',
                'label' => __( 'Gradient Three', 'ht-mega-for-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .gradient-overlay.gradient-overlay-3 .thumb a::before',
                'separator'=>'before'
            ]
        );
        $this->add_control(
            'gradient4_heading',
            [
                'label' => __( 'Item Four Gradient', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator'=>'before'
            ]
        );  
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'gradient4',
                'label' => __( 'Gradient Four', 'ht-mega-for-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .gradient-overlay.gradient-overlay-4 .thumb a::before',
                'separator'=>'before'
            ]
        );
        $this->add_control(
            'gradient5_heading',
            [
                'label' => __( 'Item Five Gradient', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator'=>'before'
            ]
        );  
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'gradient5',
                'label' => __( 'Gradient Five', 'ht-mega-for-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .gradient-overlay.gradient-overlay-5 .thumb a::before',
                'separator'=>'before'
            ]
        );
        $this->add_control(
            'gradient6_heading',
            [
                'label' => __( 'Item Six Gradient', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator'=>'before'
            ]
        );  
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'gradient6',
                'label' => __( 'Gradient ', 'ht-mega-for-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .gradient-overlay.gradient-overlay-6 .thumb a::before',
                'separator'=>'before'
            ]
        );
        $this->add_control(
            'gradient7_heading',
            [
                'label' => __( 'Item Seven Gradient', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator'=>'before'
            ]
        );
    $this->end_controls_section();     
        // Style Thumbnail section
        $this->start_controls_section(
            'thumbnail_section_style',
            [
                'label' => __( 'Thumbnail', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
            );
            
            $this->add_control(
                'post_carousel_image_overlay_heading',
                [
                    'label' => __( 'Image Overlay', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'post_slider_image_overlay',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .ht-post .thumb a:after',
                    
                ]
            );   
            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'htmega_image',
                    'label' => esc_html__( 'Image Size', 'ht-mega-for-elementor' ),
                    'exclude'      => ['custom'], // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_exclude -- not a WP_Query arg: this is Elementor's Group_Control_Image_Size config, excluding the "custom" option from the image size dropdown list, unrelated to post filtering.
                    'default'      => 'full',
                    'separator' => 'none',
                ]
            );      
            $this->add_responsive_control(
                'post_items_item_border_radius_image',
                [
                    'label' => esc_html__( 'Image Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .ht-post .thumb' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );
        $this->end_controls_section();   
        // Style Title tab section
        $this->start_controls_section(
            'post_grid_title_style_section',
            [
                'label' => __( 'Title', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'show_title'=>'yes',
                ]
            ]
        );
            $this->add_control(
                'title_color',
                [
                    'label' => __( 'Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default'=>'#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .ht-post .post-content .content h2 a,
                        {{WRAPPER}} .ht-post .post-content .content h4 a,
                        {{WRAPPER}} .ht-post .post-content .content .htmega-post-g-title a' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'title_color_hover',
                [
                    'label' => __( 'Hover Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default'=>'#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .ht-post .post-content .content h2 a:hover,
                        {{WRAPPER}} .ht-post .post-content .content h4 a:hover,
                        {{WRAPPER}} .ht-post .post-content .content .htmega-post-g-title a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .ht-post .post-content .content h4, {{WRAPPER}} .ht-post .post-content .content h2,{{WRAPPER}} .ht-post .post-content .content .htmega-post-g-title',
                ]
            );

            $this->add_responsive_control(
                'title_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-post .post-content .content h4,
                        {{WRAPPER}} .ht-post .post-content .content h2,{{WRAPPER}} .ht-post .post-content .content .htmega-post-g-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'title_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-post .post-content .content h4,
                        {{WRAPPER}} .ht-post .post-content .content h2,
                        {{WRAPPER}} .ht-post .post-content .content .htmega-post-g-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'title_align',
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
                        '{{WRAPPER}} .ht-post .post-content .content h2,{{WRAPPER}} .ht-post .post-content .content h4,{{WRAPPER}} .ht-post .post-content .content .htmega-post-g-title' => 'text-align: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'post_title2typography',
                [
                    'label' => __( 'Title Two Style', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'post_grid_style' => array( '2','3','5' ),
                    ]
                ]
            );            
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title2_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-post-grid-layout-2 .htb-col-lg-6 .ht-post .post-content .content h4,{{WRAPPER}} .ht-post .post-content .content h2,{{WRAPPER}} .htmega-post-grid-layout-5 .htb-col-lg-8 .ht-post .post-content .content h4,
                    {{WRAPPER}} .htmega-post-grid-layout-2 .htb-col-lg-6 .ht-post .post-content .content .htmega-post-g-title,
                    {{WRAPPER}} .htmega-post-grid-layout-5 .htb-col-lg-8 .ht-post .post-content .content .htmega-post-g-title',
                    'condition' => [
                        'post_grid_style' => array( '2','3','5' ),
                    ]
                ]
            );

        $this->end_controls_section();

        // Style Date tab section
        $this->start_controls_section(
            'post_grid_date_style_section',
            [
                'label' => __( 'Date', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'show_date'=>'yes',
                ]
            ]
        );
            $this->add_control(
                'date_color',
                [
                    'label' => __( 'Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default'=>'#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .ht-post .post-content .content .meta' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'date_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .ht-post .post-content .content .meta',
                ]
            );

            $this->add_responsive_control(
                'date_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-post .post-content .content .meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'date_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-post .post-content .content .meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'date_align',
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
                        '{{WRAPPER}} .ht-post .post-content .content .meta' => 'text-align: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_section();

        // Style Category tab section
        $this->start_controls_section(
            'post_grid_category_style_section',
            [
                'label' => __( 'Category', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'show_category'=>'yes',
                ]
            ]
        );
            $this->add_control(
                'category_color',
                [
                    'label' => __( 'Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default'=>'#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .ht-post a.post-category' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'category_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .ht-post a.post-category',
                ]
            );

            $this->add_responsive_control(
                'category_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-post a.post-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'category_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-post a.post-category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'category_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .ht-post a.post-category',
                ]
            );

        $this->end_controls_section();
        // Content style
        $this->start_controls_section(
            'post_description_section',
            [
                'label' => esc_html__('Description', 'ht-mega-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_content' => 'yes',
                ]
            ]
            );
            
            $this->add_control(
                'post_description_color',
                [
                    'label' => esc_html__('Color', 'ht-mega-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} p.htmega-post-g-description' => 'color: {{VALUE}};',
                    ],

                ]
            );
            
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'post_description_typography',
                    'selector' => '{{WRAPPER}} p.htmega-post-g-description',
                ]
            );
            $this->add_responsive_control(
                'post_description_margin',
                [
                    'label' => esc_html__( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} p.htmega-post-g-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],                
                ]
            );
            
        $this->end_controls_section();
        // Style Read More button section
        $this->start_controls_section(
            'readmore_style_section',
            [
                'label' => __( 'Read More', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'show_read_more_btn'=>'yes',
                    'read_more_txt!'=>'',
                ]
            ]
            );
            $this->start_controls_tabs('readmore_style_tabs');

                $this->start_controls_tab(
                    'readmore_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'readmore_color',
                        [
                            'label' => __( 'Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} a.htmega-post-g-read-more' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'readmore_typography',
                            'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} a.htmega-post-g-read-more',
                        ]
                    );
                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'readmore_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} a.htmega-post-g-read-more',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'readmore_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} a.htmega-post-g-read-more',
                        ]
                    );

                    $this->add_responsive_control(
                        'readmore_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} a.htmega-post-g-read-more' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );
                    $this->add_responsive_control(
                        'readmore_padding',
                        [
                            'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} a.htmega-post-g-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );
                    $this->add_responsive_control(
                        'readmore_margin',
                        [
                            'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} a.htmega-post-g-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );
                $this->end_controls_tab(); // Normal Tab end

                $this->start_controls_tab(
                    'readmore_style_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );
                    $this->add_control(
                        'readmore_hover_color',
                        [
                            'label' => __( 'Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} a.htmega-post-g-read-more:hover' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'readmore_hover_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} a.htmega-post-g-read-more:hover',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'readmore_hover_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} a.htmega-post-g-read-more:hover',
                        ]
                    );

                    $this->add_responsive_control(
                        'readmore_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} a.htmega-post-g-read-more:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Hover Tab end

            $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();

        $post_type =  isset( $settings['grid_post_type'] ) ? $settings['grid_post_type'] : 'post';
        $post_categorys = [];
        if( 'post'== $post_type && ! empty( $settings['grid_categories'] ) && is_array( $settings['grid_categories'] ) ) {
            $post_categorys = $settings['grid_categories'];
        } else if( 'product'== $post_type && ! empty( $settings['grid_prod_categories'] ) && is_array( $settings['grid_prod_categories'] ) ) {
            $post_categorys = $settings['grid_prod_categories'];
        }else {
            if( ! empty( $settings[ $post_type.'_post_category'] )  && is_array( $settings[ $post_type.'_post_category'] ) ) {
                $post_categorys =  $settings[ $post_type.'_post_category'];
            }
        }
        $post_author = $settings['post_author'];
        $exclude_posts = $settings['exclude_posts'];
        $orderby            = $this->get_settings_for_display('orderby');
        $postorder          = $this->get_settings_for_display('postorder');
        $category_name =  get_object_taxonomies($post_type);
        $this->add_render_attribute( 'htmega_post_grid', 'class', 'htmega-post-grid-area htmega-post-grid-layout-'.$settings['post_grid_style'] );

        // Post query
        $args = array(
            'post_type'             => $post_type,
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => !empty( $settings['post_limit'] ) ? (int)$settings['post_limit'] : 3,
        );

        if (  !empty( $post_categorys ) ) {

            if( is_array($post_categorys) && count($post_categorys) > 0 ){

                if ( in_array( "product_type", $category_name ) ) {
                    $category_name['0'] = 'product_cat';
                }

                $field_name = is_numeric( $post_categorys[0] ) ? 'term_id' : 'slug';
                $args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- intentional: implements the widget's category filter controls (`grid_categories` / `grid_prod_categories` / `{post_type}_post_category`) letting the site builder restrict the grid to chosen terms.
                    array(
                        'taxonomy' => $category_name[0],
                        'terms' => $post_categorys,
                        'field' => $field_name,
                        'include_children' => false
                    )
                );
            }
        }
        // author check
        if ( !empty( $post_author ) && is_array( $post_author ) ) {
            $args['author__in'] = $post_author;
        }
        // order by  check
        if ( !empty( $orderby ) ) {
            if ( 'date' == $orderby && 'yes'== $settings['custom_order_by_date'] && (!empty( $settings['order_by_date_after'] || $settings['order_by_date_before'] ) ) ) {
            $order_by_date_after = strtotime($settings['order_by_date_after']);
            $order_by_date_before = strtotime($settings['order_by_date_before']);
                $args['date_query'] = array(
                    array(
                        'before'    => array(
                            'year'  => gmdate('Y', $order_by_date_before),
                            'month' =>gmdate('m', $order_by_date_before),
                            'day'   => gmdate('d', $order_by_date_before),
                        ),
                        'after'    => array(
                            'year'  => gmdate('Y', $order_by_date_after),
                            'month' =>gmdate('m', $order_by_date_after),
                            'day'   => gmdate('d', $order_by_date_after),
                        ),
                        'inclusive' => true,
                    ),
                );

            } else {
                $args['orderby'] = $orderby;
            }
        }

        // Exclude posts check
        $exclude_merge = array();
        if ( ! empty( $exclude_posts ) ) {
            $exclude_merge = array_filter(
                array_map(
                    'absint',
                    explode( ',', str_replace( ' ', '', sanitize_text_field( $exclude_posts ) ) )
                )
            );
        }
        if ( 'yes' === $settings['hide_current_post'] && is_singular() ) {
            $exclude_merge[] = get_the_ID();
        }
        if ( ! empty( $exclude_merge ) ) {
            $args['post__not_in'] = array_values( array_unique( $exclude_merge ) ); // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_post__not_in -- intentional: implements the widget's "Exclude Posts" control (`$settings['exclude_posts']`) and "Hide Current Post" toggle (`$settings['hide_current_post']`).
        }

        // Order check
        if ( ! empty( $postorder ) ) {
            $args['order'] = $postorder;
        }
        // empty thumbnail post
        if ( 'yes' === $settings['hide_empty_thumbnail_post'] ) {
            $args['meta_query'] = [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- intentional: implements the widget's "Hide post without featured image" toggle (`$settings['hide_empty_thumbnail_post']`), filtering to posts that have a `_thumbnail_id` meta value.
                [
                    'key' => '_thumbnail_id',
                    'compare' => 'EXISTS'
                ],
            ];
        }

        $grid_post = \HTMega_Query_Cache::query( $args );
       

        $this->add_render_attribute( 'htmega_post_attr', 'class', 'htmega-post-g-title' );
        $htmega_image_size  = $this->get_settings_for_display('htmega_image_size');
        ?>
            
        <div <?php echo $this->get_render_attribute_string( 'htmega_post_grid' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string(). ?>>
            <div class="htb-col">
                <div class="<?php if( $settings['post_grid_style'] == 1 || $settings['post_grid_style'] == 2 || $settings['post_grid_style'] == 3 ) { echo 'row-1'; }else{ echo 'row--10' ;}?> htb-row">
                    <?php
                    $countrow = $gdc = $rowcount = 0;
                    $roclass = 'htb-col-lg-4 htb-col-md-4';
                    if($grid_post->have_posts() ):
                    while( $grid_post->have_posts() ) : $grid_post->the_post();
                        $countrow++;
                        $gdc++;
                        if( $gdc > 6){ $gdc = 1; }
                        if( $countrow > 3){ $roclass = 'htb-col-lg-6 htb-col-md-6'; }else{ $roclass = $roclass; }

                        if ( 0 > $settings['title_length'] ) {
                            $title_display = wp_kses_post( get_the_title() );
                        } else {
                            $title_display = wp_kses_post( wp_trim_words( get_the_title(), floatval( $settings['title_length'] ), '' ) );
                        }
                        $title_link_text = '<a href="' . esc_url( get_permalink() ) . '">' . $title_display . '</a>';
                        ?>

                        <?php if( $settings['post_grid_style'] == 2 ): ?>

                            <?php if ( $countrow == 1 ) : ?>
                                <div class="htb-col-lg-3 htb-col-sm-6 htb-col-12">
                            <?php endif;?>
                                 <?php if ( $countrow == 1 || $countrow == 2) : ?>
                                    <div class="ht-post">
                                        <div class="thumb">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php 
                                                    if ( has_post_thumbnail() ){
                                                        the_post_thumbnail( $htmega_image_size ); 
                                                    }else{
                                                        echo '<img src="' . esc_url( HTMEGA_ADDONS_PL_URL . '/assets/images/image-placeholder.png' ) . '" alt="' . esc_attr( get_the_title() ) . '" />';
                                                    }
                                                ?>
                                            </a>
                                        </div>
                                        <?php
                                            if( $settings['show_category'] == 'yes' ){
                                                if( $category_name ){
                                                    $i=0;
                                                    $get_terms = get_the_terms($grid_post->ID, $category_name[0] );
                                                    if( $settings['grid_post_type'] == 'product' ){
                                                        $get_terms = get_the_terms($grid_post->ID, 'product_cat');
                                                    }
                                                    if( $get_terms ){
                                                        foreach ( $get_terms as $category ) {
                                                            $i++;
                                                            $term_link = get_term_link( $category );
                                                            ?>
                                                                <a href="<?php echo esc_url( $term_link ); ?>" class="category post-category post-position-top-left <?php echo esc_attr( $category->slug ); ?>"><?php echo esc_html( $category->name );?></a>
                                                            <?php
                                                            if($i==1){break;}
                                                        }
                                                    }
                                                }
                                            }
                                        if ( $settings['show_title'] == 'yes' || $settings['show_date'] == 'yes' || $settings['show_content'] == 'yes' || $settings['show_read_more_btn'] == 'yes' ) {
                                            ?>
                                            <div class="post-content">
                                                <div class="content">
                                                        <?php 
                                                    if( $settings['show_title'] == 'yes' ): 
                                                        printf( '<%1$s %2$s>%3$s</%1$s>',
                                                        htmega_escape_tags( $settings['title_tag'], 'h4' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_escape_tags() returns only a whitelisted tag name (h1-h6/div/span/p).
                                                        $this->get_render_attribute_string( 'htmega_post_attr' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string().
                                                        $title_link_text); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built above from esc_url() href + wp_kses_post()'d title, see $title_display.
                                                    endif;
                                                    
                                                    if( $settings['show_date'] == 'yes' ): ?>
                                                        <div class="meta">
                                                            <span class="meta-item date"><i class="fa fa-clock-o"></i>
                                                                <?php the_time( 'd F Y' ); ?>
                                                            </span>
                                                        </div>
                                                        <?php 
                                                    endif;?>
                                                        <?php
                                                    if( $settings['show_content'] == 'yes' ):
                                                        if( $settings['content_type'] == 'excerpt' ){
                                                            echo '<p class="htmega-post-g-description">'. esc_html( wp_trim_words( get_the_excerpt(), floatval( $settings['content_length'] ),'' ) ) .'</p>';
                                                        } else {
                                                            echo '<p class="htmega-post-g-description">'. wp_kses_post( wp_trim_words( strip_shortcodes( get_the_content() ), floatval( $settings['content_length'] ), '' ) ).'</p>'; 
                                                        }
                                                    endif;
                                                    if( $settings['show_read_more_btn'] == 'yes' && !empty( $settings['read_more_txt'] ) ): ?>
                                                        <a class="htmega-post-g-read-more" href="<?php the_permalink();?>">
                                                            <?php echo htmega_kses_desc( $settings['read_more_txt'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_desc() sanitizes via wp_kses(), see includes/helper-function.php. ?>
                                                        </a>
                                                        <?php
                                                    endif; ?>
                                                </div>
                                            </div>
                                            <?php 
                                        } ?>
                                    </div>
                                <?php endif;?>
                            <?php if ( $countrow == 2 ) : ?>
                                </div>
                            <?php endif;?>

                            <?php if ( $countrow == 3 ) : ?>
                                <div class="htb-col-lg-6 htb-col-sm-6 htb-col-12">
                                    <div class="ht-post">
                                        <div class="thumb">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php 
                                                    if ( has_post_thumbnail() ){
                                                        the_post_thumbnail( $htmega_image_size ); 
                                                    }else{
                                                        echo '<img src="' . esc_url( HTMEGA_ADDONS_PL_URL . '/assets/images/image-placeholder.png' ) . '" alt="' . esc_attr( get_the_title() ) . '" />';

                                                    }
                                                ?>
                                            </a>
                                        </div>
                                        <?php
                                            if( $settings['show_category'] == 'yes' ){
                                                
                                                if( $category_name ){
                                                    $i=0;
                                                    $get_terms = get_the_terms($grid_post->ID, $category_name[0] );
                                                    if( $settings['grid_post_type'] == 'product' ){
                                                        $get_terms = get_the_terms($grid_post->ID, 'product_cat');
                                                    }
                                                    if( $get_terms ){
                                                        foreach ( $get_terms as $category ) {
                                                            $i++;
                                                            $term_link = get_term_link( $category );
                                                            ?>
                                                                <a href="<?php echo esc_url( $term_link ); ?>" class="category post-category post-position-top-left <?php echo esc_attr( $category->slug ); ?>"><?php echo esc_html( $category->name );?></a>
                                                            <?php
                                                            if($i==1){break;}
                                                        }
                                                    }
                                                }
                                            }
                                        if ( $settings['show_title'] == 'yes' || $settings['show_date'] == 'yes' || $settings['show_content'] == 'yes' || $settings['show_read_more_btn'] == 'yes' ) {
                                            ?>
                                            <div class="post-content">
                                                <div class="content">
                                                    <?php if( $settings['show_title'] == 'yes' ): 
                                                        printf( '<%1$s %2$s>%3$s</%1$s>',
                                                        htmega_escape_tags( $settings['title_tag'], 'h4' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_escape_tags() returns only a whitelisted tag name (h1-h6/div/span/p).
                                                        $this->get_render_attribute_string( 'htmega_post_attr' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string().
                                                        $title_link_text);  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built above from esc_url() href + wp_kses_post()'d title, see $title_display.
                                                        endif;
                                                        if( $settings['show_date'] == 'yes' ): ?>
                                                        <div class="meta">
                                                            <span class="meta-item date"><i class="fa fa-clock-o"></i>
                                                                <?php the_time( 'd F Y' ); ?>
                                                            </span>
                                                        </div>
                                                    <?php endif;?>
                                                    <?php
                                                    if( $settings['show_content'] == 'yes' ):
                                                        if( $settings['content_type'] == 'excerpt' ){
                                                            echo '<p class="htmega-post-g-description">'. esc_html( wp_trim_words( get_the_excerpt(), floatval( $settings['content_length'] ),'' ) ) .'</p>';
                                                        } else {
                                                            echo '<p class="htmega-post-g-description">'. wp_kses_post( wp_trim_words( strip_shortcodes( get_the_content() ), floatval( $settings['content_length'] ), '' ) ).'</p>'; 
                                                        }
                                                    endif;
                                                    if( $settings['show_read_more_btn'] == 'yes' && !empty( $settings['read_more_txt'] ) ): ?>
                                                        <a class="htmega-post-g-read-more" href="<?php the_permalink();?>">
                                                            <?php echo htmega_kses_desc( $settings['read_more_txt'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_desc() sanitizes via wp_kses(), see includes/helper-function.php. ?>
                                                        </a>
                                                        <?php
                                                    endif; ?>
                                                </div>
                                            </div>
                                            <?php 
                                        } ?>
                                    </div>
                                </div>
                            <?php endif;?>

                            <?php if ( $countrow == 4 ) : ?>
                                <div class="htb-col-lg-3 htb-col-sm-6 htb-col-12">
                            <?php endif;?>
                                 <?php if ( $countrow == 4 || $countrow == 5 ) : ?>
                                    <div class="ht-post">
                                        <div class="thumb">
                                            <a href="<?php the_permalink();?>">
                                                <?php 
                                                    if ( has_post_thumbnail() ){
                                                        the_post_thumbnail( $htmega_image_size ); 
                                                    }else{
                                                        echo '<img src="' . esc_url( HTMEGA_ADDONS_PL_URL . '/assets/images/image-placeholder.png' ) . '" alt="' . esc_attr( get_the_title() ) . '" />';
                                                    }
                                                ?>
                                            </a>
                                        </div>
                                        <?php
                                            if( $settings['show_category'] == 'yes' ){
                                                if( $category_name ){
                                                    $i=0;
                                                    $get_terms = get_the_terms($grid_post->ID, $category_name[0] );
                                                    if( $settings['grid_post_type'] == 'product' ){
                                                        $get_terms = get_the_terms($grid_post->ID, 'product_cat');
                                                    }
                                                    if( $get_terms ){
                                                        foreach ( $get_terms as $category ) {
                                                            $i++;
                                                            $term_link = get_term_link( $category );
                                                            ?>
                                                                <a href="<?php echo esc_url( $term_link ); ?>" class="category post-category post-position-top-left <?php echo esc_attr( $category->slug ); ?>"><?php echo esc_html( $category->name );?></a>
                                                            <?php
                                                            if($i==1){break;}
                                                        }
                                                    }
                                                }
                                            }
                                        if ( $settings['show_title'] == 'yes' || $settings['show_date'] == 'yes' || $settings['show_content'] == 'yes' || $settings['show_read_more_btn'] == 'yes' ) {
                                            ?>
                                            <div class="post-content">
                                                <div class="content">
                                                    <?php if( $settings['show_title'] == 'yes' ):  
                                                        printf( '<%1$s %2$s>%3$s</%1$s>',
                                                        htmega_escape_tags( $settings['title_tag'], 'h4' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_escape_tags() returns only a whitelisted tag name (h1-h6/div/span/p).
                                                        $this->get_render_attribute_string( 'htmega_post_attr' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string().
                                                        $title_link_text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built above from esc_url() href + wp_kses_post()'d title, see $title_display.
                                                        endif;
                                                        if( $settings['show_date'] == 'yes' ): ?>
                                                        <div class="meta">
                                                            <span class="meta-item date"><i class="fa fa-clock-o"></i>
                                                                <?php the_time( 'd F Y' ); ?>
                                                            </span>
                                                        </div>
                                                    <?php endif;?>
                                                    <?php
                                                    if( $settings['show_content'] == 'yes' ):
                                                        if( $settings['content_type'] == 'excerpt' ){
                                                            echo '<p class="htmega-post-g-description">'. esc_html( wp_trim_words( get_the_excerpt(), floatval( $settings['content_length'] ),'' ) ) .'</p>';
                                                        } else {
                                                            echo '<p class="htmega-post-g-description">' . wp_kses_post( wp_trim_words( strip_shortcodes( get_the_content() ), floatval( $settings['content_length'] ), '' ) ) .'</p>'; 
                                                        }
                                                    endif;
                                                    if( $settings['show_read_more_btn'] == 'yes' && !empty( $settings['read_more_txt'] ) ): ?>
                                                        <a class="htmega-post-g-read-more" href="<?php the_permalink();?>">
                                                            <?php echo htmega_kses_desc( $settings['read_more_txt'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_desc() sanitizes via wp_kses(), see includes/helper-function.php. ?>
                                                        </a>
                                                        <?php
                                                    endif; ?>
                                                </div>
                                            </div>
                                            <?php 
                                        } ?>
                                    </div>
                                <?php endif;?>
                            <?php if ( $countrow == 5 ) : ?>
                                </div>
                            <?php endif;?>


                        <?php elseif( $settings['post_grid_style'] == 3 ): ?>
                            <?php if( $countrow == 1): ?>
                                <div class="htb-col-lg-6 htb-col-sm-6 htb-col-12">
                                    <div class="ht-post">
                                        <div class="thumb">
                                            <a href="<?php the_permalink();?>">
                                                <?php 
                                                    if ( has_post_thumbnail() ){
                                                        the_post_thumbnail( $htmega_image_size ); 
                                                    }else{
                                                        echo '<img src="' . esc_url( HTMEGA_ADDONS_PL_URL . '/assets/images/image-placeholder.png' ) . '" alt="' . esc_attr( get_the_title() ) . '" />';
                                                    }
                                                ?>
                                            </a>
                                        </div>
                                        <?php
                                            if( $settings['show_category'] == 'yes' ){
                                                if( $category_name ){
                                                    $i=0;
                                                    $get_terms = get_the_terms($grid_post->ID, $category_name[0] );
                                                    if( $settings['grid_post_type'] == 'product' ){
                                                        $get_terms = get_the_terms($grid_post->ID, 'product_cat');
                                                    }
                                                    if( $get_terms ){
                                                        foreach ( $get_terms as $category ) {
                                                            $i++;
                                                            $term_link = get_term_link( $category );
                                                            ?>
                                                                <a href="<?php echo esc_url( $term_link ); ?>" class="category post-category post-position-top-left <?php echo esc_attr( $category->slug ); ?>"><?php echo esc_html( $category->name );?></a>
                                                            <?php
                                                            if($i==1){break;}
                                                        }
                                                    }
                                                }
                                            }
                                        if ( $settings['show_title'] == 'yes' || $settings['show_date'] == 'yes' || $settings['show_content'] == 'yes' || $settings['show_read_more_btn'] == 'yes' ) {
                                            ?>
                                            <div class="post-content">
                                                <div class="content">
                                                    <?php if( $settings['show_title'] == 'yes' ):
                                                    printf( '<%1$s %2$s>%3$s</%1$s>',
                                                    htmega_escape_tags( $settings['title_tag'], 'h2' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_escape_tags() returns only a whitelisted tag name (h1-h6/div/span/p).
                                                    $this->get_render_attribute_string( 'htmega_post_attr' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string().
                                                    $title_link_text); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built above from esc_url() href + wp_kses_post()'d title, see $title_display.
                                                    endif;
                                                    if( $settings['show_date'] == 'yes' ): ?>
                                                        <div class="meta">
                                                            <span class="meta-item date"><i class="fa fa-clock-o"></i> 
                                                                <?php the_time( 'd F Y' ); ?>
                                                            </span>
                                                        </div>
                                                    <?php endif;?>
                                                    <?php
                                                    if( $settings['show_content'] == 'yes' ):
                                                        if( $settings['content_type'] == 'excerpt' ){
                                                            echo '<p class="htmega-post-g-description">'. esc_html( wp_trim_words( get_the_excerpt(), floatval( $settings['content_length'] ),'' ) ) .'</p>';
                                                        } else {
                                                            echo '<p class="htmega-post-g-description">' . wp_kses_post( wp_trim_words( strip_shortcodes( get_the_content() ), floatval( $settings['content_length'] ), '' ) ) .'</p>'; 
                                                        }
                                                    endif;
                                                    if( $settings['show_read_more_btn'] == 'yes' && !empty( $settings['read_more_txt'] ) ): ?>
                                                        <a class="htmega-post-g-read-more" href="<?php the_permalink();?>">
                                                            <?php echo htmega_kses_desc( $settings['read_more_txt'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_desc() sanitizes via wp_kses(), see includes/helper-function.php. ?>
                                                        </a>
                                                        <?php
                                                    endif; ?>
                                                </div>
                                            </div>
                                            <?php 
                                        } ?>
                                    </div>
                                </div>

                                <div class="htb-col-lg-6 htb-col-sm-6 htb-col-12">
                                    <div class="htb-row row-1">
                            <?php endif; ?>

                                    <?php if ( $countrow == 2) : ?>
                                        <div class="htb-col-lg-12">
                                            <div class="ht-post">
                                                <div class="thumb">
                                                    <a href="<?php the_permalink();?>">
                                                        <?php 
                                                            if ( has_post_thumbnail() ){
                                                                the_post_thumbnail('htmega_size_585x295'); 
                                                            }else{
                                                                echo '<img src="' . esc_url( HTMEGA_ADDONS_PL_URL . '/assets/images/image-placeholder.png' ) . '" alt="' . esc_attr( get_the_title() ) . '" />';
                                                            }
                                                        ?>
                                                    </a>
                                                </div>
                                                <?php
                                                    if( $settings['show_category'] == 'yes' ){
                                                        if( $category_name ){
                                                            $i=0;
                                                            $get_terms = get_the_terms($grid_post->ID, $category_name[0] );
                                                            if( $settings['grid_post_type'] == 'product' ){
                                                                $get_terms = get_the_terms($grid_post->ID, 'product_cat');
                                                            }
                                                            if( $get_terms ){
                                                                foreach ( $get_terms as $category ) {
                                                                    $i++;
                                                                    $term_link = get_term_link( $category );
                                                                    ?>
                                                                        <a href="<?php echo esc_url( $term_link ); ?>" class="category post-category post-position-top-left <?php echo esc_attr( $category->slug ); ?>"><?php echo esc_html( $category->name );?></a>
                                                                    <?php
                                                                    if($i==1){break;}
                                                                }
                                                            }
                                                        }
                                                    }

                                                if ($settings['show_title'] == 'yes' || $settings['show_date'] == 'yes' || $settings['show_content'] == 'yes' || $settings['show_read_more_btn'] == 'yes') {
                                                    ?>
                                                    <div class="post-content">
                                                        <div class="content">
                                                            <?php if ($settings['show_title'] == 'yes'):

                                                                printf(
                                                                    '<%1$s %2$s>%3$s</%1$s>',
                                                                    htmega_escape_tags($settings['title_tag'], 'h4'), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_escape_tags() returns only a whitelisted tag name (h1-h6/div/span/p).
                                                                    $this->get_render_attribute_string('htmega_post_attr'), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string().
                                                                    $title_link_text // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built above from esc_url() href + wp_kses_post()'d title, see $title_display.
                                                                );

                                                            endif;
                                                            if ($settings['show_date'] == 'yes'): ?>
                                                                <div class="meta">
                                                                    <span class="meta-item date"><i class="fa fa-clock-o"></i>
                                                                        <?php the_time('d F Y'); ?>
                                                                    </span>
                                                                </div>
                                                            <?php endif; ?>
                                                                <?php
                                                                if ($settings['show_content'] == 'yes'):
                                                                    if ($settings['content_type'] == 'excerpt') {
                                                                        echo '<p class="htmega-post-g-description">' . esc_html( wp_trim_words( get_the_excerpt(), floatval( $settings['content_length'] ),'' ) ) . '</p>';
                                                                    } else {
                                                                        echo '<p class="htmega-post-g-description">' .wp_kses_post( wp_trim_words(strip_shortcodes(get_the_content()), floatval($settings['content_length'] ), '') ) . '</p>';
                                                                    }
                                                                endif;
                                                                if ($settings['show_read_more_btn'] == 'yes' && !empty($settings['read_more_txt'])): ?>
                                                                <a class="htmega-post-g-read-more" href="<?php the_permalink(); ?>">
                                                                    <?php echo htmega_kses_desc($settings['read_more_txt']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_desc() sanitizes via wp_kses(), see includes/helper-function.php. ?>
                                                                </a>
                                                                <?php
                                                                endif; ?>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php endif;?>

                                    <?php if ( $countrow == 3 || $countrow == 4) : ?>
                                        <div class="htb-col-lg-6">
                                            <div class="ht-post">
                                                <div class="thumb">
                                                    <a href="<?php the_permalink();?>">
                                                        <?php 
                                                            if ( has_post_thumbnail() ){
                                                                the_post_thumbnail( $htmega_image_size ); 
                                                            }else{
                                                                echo '<img src="' . esc_url( HTMEGA_ADDONS_PL_URL . '/assets/images/image-placeholder.png' ) . '" alt="' . esc_attr( get_the_title() ) . '" />';
                                                            }
                                                        ?>
                                                    </a>
                                                </div>
                                                <?php
                                                    if( $settings['show_category'] == 'yes' ){
                                                        if( $category_name ){
                                                            $i=0;
                                                            $get_terms = get_the_terms($grid_post->ID, $category_name[0] );
                                                            if( $settings['grid_post_type'] == 'product' ){
                                                                $get_terms = get_the_terms($grid_post->ID, 'product_cat');
                                                            }
                                                            if( $get_terms ){
                                                                foreach ( $get_terms as $category ) {
                                                                    $i++;
                                                                    $term_link = get_term_link( $category );
                                                                    ?>
                                                                        <a href="<?php echo esc_url( $term_link ); ?>" class="category post-category post-position-top-left <?php echo esc_attr( $category->slug ); ?>"><?php echo esc_html( $category->name );?></a>
                                                                    <?php
                                                                    if($i==1){break;}
                                                                }
                                                            }
                                                        }
                                                    }
                                                if ($settings['show_title'] == 'yes' || $settings['show_date'] == 'yes' || $settings['show_content'] == 'yes' || $settings['show_read_more_btn'] == 'yes') {
                                                    ?>
                                                    <div class="post-content">
                                                        <div class="content">
                                                            <?php if ($settings['show_title'] == 'yes'):

                                                                printf(
                                                                    '<%1$s %2$s>%3$s</%1$s>',
                                                                    htmega_escape_tags($settings['title_tag'], 'h4'), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_escape_tags() returns only a whitelisted tag name (h1-h6/div/span/p).
                                                                    $this->get_render_attribute_string('htmega_post_attr'), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string().
                                                                    $title_link_text // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built above from esc_url() href + wp_kses_post()'d title, see $title_display.
                                                                );

                                                            endif;
                                                            if ($settings['show_date'] == 'yes'): ?>
                                                                <div class="meta">
                                                                    <span class="meta-item date"><i class="fa fa-clock-o"></i> 
                                                                        <?php the_time('d F Y'); ?>
                                                                    </span>
                                                                </div>
                                                            <?php endif; ?>
                                                                <?php
                                                                if ($settings['show_content'] == 'yes'):
                                                                    if ($settings['content_type'] == 'excerpt') {
                                                                        echo '<p class="htmega-post-g-description">' . esc_html( wp_trim_words( get_the_excerpt(), floatval( $settings['content_length'] ),'' ) ) . '</p>';
                                                                    } else {
                                                                        echo '<p class="htmega-post-g-description">' .wp_kses_post( wp_trim_words(strip_shortcodes(get_the_content()), floatval($settings['content_length'] ), '') ) . '</p>';
                                                                    }
                                                                endif;
                                                                if ($settings['show_read_more_btn'] == 'yes' && !empty($settings['read_more_txt'])): ?>
                                                                <a class="htmega-post-g-read-more" href="<?php the_permalink(); ?>">
                                                                    <?php echo htmega_kses_desc($settings['read_more_txt']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_desc() sanitizes via wp_kses(), see includes/helper-function.php. ?>
                                                                </a>
                                                                <?php
                                                                endif; ?>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                            <?php if ( $countrow == 5 ) : ?>
                                </div>
                            </div>
                        <?php endif;?>

                        <?php elseif( $settings['post_grid_style'] == 4 ): ?>
                            <div class="htb-col-lg-4 htb-col-sm-6 htb-col-12">
                                <div class="ht-post black-overlay mt--30">
                                        <div class="thumb">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php
                                                if (has_post_thumbnail()) {
                                                    the_post_thumbnail($htmega_image_size);
                                                } else {
                                                    echo '<img src="' . esc_url( HTMEGA_ADDONS_PL_URL . '/assets/images/image-placeholder.png' ) . '" alt="' . esc_attr( get_the_title() ) . '" />';
                                                }
                                                ?>
                                            </a>
                                        </div>
                                    <?php
                                    if( $settings['show_category'] == 'yes' ){
                                        if( $category_name ){
                                            $i=0;
                                            $get_terms = get_the_terms($grid_post->ID, $category_name[0] );
                                            if( $settings['grid_post_type'] == 'product' ){
                                                $get_terms = get_the_terms($grid_post->ID, 'product_cat');
                                            }
                                            if( $get_terms ){
                                                foreach ( $get_terms as $category ) {
                                                    $i++;
                                                    $term_link = get_term_link( $category );
                                                    ?>
                                                        <a href="<?php echo esc_url( $term_link ); ?>" class="category post-category post-position-top-left <?php echo esc_attr( $category->slug ); ?>"><?php echo esc_html( $category->name );?></a>
                                                    <?php
                                                    if($i==1){break;}
                                                }
                                            }
                                        }
                                    }
                                    if ($settings['show_title'] == 'yes' || $settings['show_date'] == 'yes' || $settings['show_content'] == 'yes' || $settings['show_read_more_btn'] == 'yes') {
                                        ?>
                                        <div class="post-content">
                                            <div class="content">
                                                <?php if( $settings['show_title'] == 'yes' ):

                                                printf( '<%1$s %2$s>%3$s</%1$s>',
                                                htmega_escape_tags( $settings['title_tag'], 'h4' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_escape_tags() returns only a whitelisted tag name (h1-h6/div/span/p).
                                                $this->get_render_attribute_string( 'htmega_post_attr' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string().
                                                $title_link_text); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built above from esc_url() href + wp_kses_post()'d title, see $title_display.

                                                endif; if( $settings['show_date'] == 'yes' ): ?>
                                                    <div class="meta">
                                                        <span class="meta-item date"><i class="fa fa-clock-o"></i>  
                                                            <?php the_time( 'd F Y' ); ?>
                                                        </span>
                                                    </div>
                                                <?php endif;?>
                                                <?php
                                                if( $settings['show_content'] == 'yes' ):
                                                    if( $settings['content_type'] == 'excerpt' ) {
                                                        echo '<p class="htmega-post-g-description">'. esc_html( wp_trim_words( get_the_excerpt(), floatval( $settings['content_length'] ),'' ) ) .'</p>';
                                                    } else {
                                                        echo '<p class="htmega-post-g-description">' . wp_kses_post( wp_trim_words( strip_shortcodes( get_the_content() ), floatval( $settings['content_length'] ), '' ) ) .'</p>'; 
                                                    }
                                                endif;
                                                if( $settings['show_read_more_btn'] == 'yes' && !empty( $settings['read_more_txt'] ) ): ?>
                                                    <a class="htmega-post-g-read-more" href="<?php the_permalink();?>">
                                                        <?php echo htmega_kses_desc( $settings['read_more_txt'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_desc() sanitizes via wp_kses(), see includes/helper-function.php. ?>
                                                    </a>
                                                    <?php
                                                endif; ?>
                                            </div>
                                        </div>
                                        <?php
                                    } ?>
                                </div>
                            </div>

                        <?php elseif( $settings['post_grid_style'] == 5 ): ?>
                            <?php if( $countrow == 1): ?>
                                <div class="htb-col-lg-8 htb-col-sm-6 htb-col-12">
                                    <div class="ht-post gradient-overlay gradient-overlay-<?php echo esc_attr($gdc);?> mt--20">
                                        <div class="thumb">
                                            <a href="<?php the_permalink();?>">
                                                <?php 
                                                    if ( has_post_thumbnail() ){
                                                        the_post_thumbnail('htmega_size_585x295'); 
                                                    }else{
                                                        echo '<img src="' . esc_url( HTMEGA_ADDONS_PL_URL . '/assets/images/image-placeholder.png' ) . '" alt="' . esc_attr( get_the_title() ) . '" />';
                                                    }
                                                ?>
                                            </a>
                                        </div>
                                        <?php
                                            if( $settings['show_category'] == 'yes' ){
                                                if( $category_name ){
                                                    $i=0;
                                                    $get_terms = get_the_terms($grid_post->ID, $category_name[0] );
                                                    if( $settings['grid_post_type'] == 'product' ){
                                                        $get_terms = get_the_terms($grid_post->ID, 'product_cat');
                                                    }
                                                    if( $get_terms ){
                                                        foreach ( $get_terms as $category ) {
                                                            $i++;
                                                            $term_link = get_term_link( $category );
                                                            ?>
                                                                <a href="<?php echo esc_url( $term_link ); ?>" class="category post-category post-position-top-left <?php echo esc_attr( $category->slug ); ?>"><?php echo esc_html( $category->name );?></a>
                                                            <?php
                                                            if($i==1){break;}
                                                        }
                                                    }
                                                }
                                            }
                                        if ( $settings['show_title'] == 'yes' || $settings['show_date'] == 'yes' || $settings['show_content'] == 'yes' || $settings['show_read_more_btn'] == 'yes' ) {
                                            ?>
                                            <div class="post-content">
                                                <div class="content">
                                                    <?php if( $settings['show_title'] == 'yes' ):

                                                    printf( '<%1$s %2$s>%3$s</%1$s>',
                                                    htmega_escape_tags( $settings['title_tag'], 'h4' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_escape_tags() returns only a whitelisted tag name (h1-h6/div/span/p).
                                                    $this->get_render_attribute_string( 'htmega_post_attr' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string().
                                                    $title_link_text); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built above from esc_url() href + wp_kses_post()'d title, see $title_display.
                                                    
                                                    endif; if( $settings['show_date'] == 'yes' ): ?>
                                                        <div class="meta">
                                                            <span class="meta-item date"><i class="fa fa-clock-o"></i> <?php the_time( 'd F Y' );?></span>
                                                        </div>
                                                    <?php endif;?>
                                                    <?php
                                                    if( $settings['show_content'] == 'yes' ):
                                                        if( $settings['content_type'] == 'excerpt' ){
                                                            echo '<p class="htmega-post-g-description">'. esc_html( wp_trim_words( get_the_excerpt(), floatval( $settings['content_length'] ),'' ) ) .'</p>';
                                                        } else {
                                                            echo '<p class="htmega-post-g-description">' . wp_kses_post( wp_trim_words( strip_shortcodes( get_the_content() ), floatval( $settings['content_length'] ), '' ) ) .'</p>'; 
                                                        }
                                                    endif;
                                                    if( $settings['show_read_more_btn'] == 'yes' && !empty( $settings['read_more_txt'] ) ): ?>
                                                        <a class="htmega-post-g-read-more" href="<?php the_permalink();?>">
                                                            <?php echo htmega_kses_desc( $settings['read_more_txt'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_desc() sanitizes via wp_kses(), see includes/helper-function.php. ?>
                                                        </a>
                                                        <?php
                                                    endif; ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php endif;?>
                            <?php if( $countrow == 2): ?>
                                <div class="htb-col-lg-4 htb-col-sm-6 htb-col-12">
                                    <div class="ht-post gradient-overlay gradient-overlay-<?php echo esc_attr($gdc);?> mt--20">
                                        <div class="thumb">
                                            <a href="<?php the_permalink();?>">
                                                <?php 
                                                    if ( has_post_thumbnail() ){
                                                        the_post_thumbnail( $htmega_image_size ); 
                                                    }else{
                                                        echo '<img src="' . esc_url( HTMEGA_ADDONS_PL_URL . '/assets/images/image-placeholder.png' ) . '" alt="' . esc_attr( get_the_title() ) . '" />';
                                                    }
                                                ?>
                                            </a>
                                        </div>
                                        <?php
                                            if( $settings['show_category'] == 'yes' ){
                                                if( $category_name ){
                                                    $i=0;
                                                    $get_terms = get_the_terms($grid_post->ID, $category_name[0] );
                                                    if( $settings['grid_post_type'] == 'product' ){
                                                        $get_terms = get_the_terms($grid_post->ID, 'product_cat');
                                                    }
                                                    if( $get_terms ){
                                                        foreach ( $get_terms as $category ) {
                                                            $i++;
                                                            $term_link = get_term_link( $category );
                                                            ?>
                                                                <a href="<?php echo esc_url( $term_link ); ?>" class="category post-category post-position-top-left <?php echo esc_attr( $category->slug ); ?>"><?php echo esc_html( $category->name );?></a>
                                                            <?php
                                                            if($i==1){break;}
                                                        }
                                                    }
                                                }
                                            }
                                        if ( $settings['show_title'] == 'yes' || $settings['show_date'] == 'yes' || $settings['show_content'] == 'yes' || $settings['show_read_more_btn'] == 'yes' ) {
                                            ?>
                                            <div class="post-content">
                                                <div class="content">
                                                    <?php if( $settings['show_title'] == 'yes' ):

                                                    printf( '<%1$s %2$s>%3$s</%1$s>',
                                                    htmega_escape_tags( $settings['title_tag'], 'h4' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_escape_tags() returns only a whitelisted tag name (h1-h6/div/span/p).
                                                    $this->get_render_attribute_string( 'htmega_post_attr' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string().
                                                    $title_link_text); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built above from esc_url() href + wp_kses_post()'d title, see $title_display.

                                                    endif; if( $settings['show_date'] == 'yes' ): ?>
                                                        <div class="meta">
                                                            <span class="meta-item date"><i class="fa fa-clock-o"></i> <?php the_time( 'd F Y' );?></span>
                                                        </div>
                                                    <?php endif;?>
                                                    <?php
                                                    if( $settings['show_content'] == 'yes' ):
                                                        if( $settings['content_type'] == 'excerpt' ){
                                                            echo '<p class="htmega-post-g-description">'. esc_html( wp_trim_words( get_the_excerpt(), floatval( $settings['content_length'] ),'' ) ) .'</p>';
                                                        } else {
                                                            echo '<p class="htmega-post-g-description">' . wp_kses_post( wp_trim_words( strip_shortcodes( get_the_content() ), floatval( $settings['content_length'] ), '' ) ) .'</p>'; 
                                                        }
                                                    endif;
                                                    if( $settings['show_read_more_btn'] == 'yes' && !empty( $settings['read_more_txt'] ) ): ?>
                                                        <a class="htmega-post-g-read-more" href="<?php the_permalink();?>">
                                                            <?php echo htmega_kses_desc( $settings['read_more_txt'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_desc() sanitizes via wp_kses(), see includes/helper-function.php. ?>
                                                        </a>
                                                        <?php
                                                    endif; ?>
                                                </div>
                                            </div>
                                            <?php 
                                        } ?>
                                    </div>
                                </div>
                            <?php endif;?>
                            <?php if( $countrow > 2 ): ?>
                                <div class="htb-col-lg-4 htb-col-sm-6 htb-col-12">
                                    <div class="ht-post gradient-overlay gradient-overlay-<?php echo esc_attr($gdc);?> mt--20">
                                        <div class="thumb">
                                            <a href="<?php the_permalink();?>">
                                                <?php 
                                                    if ( has_post_thumbnail() ){
                                                        the_post_thumbnail( $htmega_image_size ); 
                                                    }else{
                                                        echo '<img src="' . esc_url( HTMEGA_ADDONS_PL_URL . '/assets/images/image-placeholder.png' ) . '" alt="' . esc_attr( get_the_title() ) . '" />';
                                                    }
                                                ?>
                                            </a>
                                        </div>
                                        <?php
                                            if( $settings['show_category'] == 'yes' ){
                                                if( $category_name ){
                                                    $i=0;
                                                    $get_terms = get_the_terms($grid_post->ID, $category_name[0] );
                                                    if( $settings['grid_post_type'] == 'product' ){
                                                        $get_terms = get_the_terms($grid_post->ID, 'product_cat');
                                                    }
                                                    if( $get_terms ){
                                                        foreach ( $get_terms as $category ) {
                                                            $i++;
                                                            $term_link = get_term_link( $category );
                                                            ?>
                                                                <a href="<?php echo esc_url( $term_link ); ?>" class="category post-category post-position-top-left <?php echo esc_attr( $category->slug ); ?>"><?php echo esc_html( $category->name );?></a>
                                                            <?php
                                                            if($i==1){break;}
                                                        }
                                                    }
                                                }
                                            }
                                        if ( $settings['show_title'] == 'yes' || $settings['show_date'] == 'yes' || $settings['show_content'] == 'yes' || $settings['show_read_more_btn'] == 'yes' ) {
                                            ?>
                                            <div class="post-content">
                                                <div class="content">
                                                    <?php if( $settings['show_title'] == 'yes' ):

                                                    printf( '<%1$s %2$s>%3$s</%1$s>',
                                                    htmega_escape_tags( $settings['title_tag'], 'h4' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_escape_tags() returns only a whitelisted tag name (h1-h6/div/span/p).
                                                    $this->get_render_attribute_string( 'htmega_post_attr' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string().
                                                    $title_link_text); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built above from esc_url() href + wp_kses_post()'d title, see $title_display.
                                                    
                                                    endif; if( $settings['show_date'] == 'yes' ): ?>
                                                        <div class="meta">
                                                            <span class="meta-item date"><i class="fa fa-clock-o"></i> <?php the_time( 'd F Y' );?></span>
                                                        </div>
                                                    <?php endif;?>
                                                    <?php
                                                    if( $settings['show_content'] == 'yes' ):
                                                        if( $settings['content_type'] == 'excerpt' ){
                                                            echo '<p class="htmega-post-g-description">'. esc_html( wp_trim_words( get_the_excerpt(), floatval( $settings['content_length'] ),'' ) ) .'</p>';
                                                        } else {
                                                            echo '<p class="htmega-post-g-description">' . wp_kses_post( wp_trim_words( strip_shortcodes( get_the_content() ), floatval( $settings['content_length'] ), '' ) ) .'</p>'; 
                                                        }
                                                    endif;
                                                    if( $settings['show_read_more_btn'] == 'yes' && !empty( $settings['read_more_txt'] ) ): ?>
                                                        <a class="htmega-post-g-read-more" href="<?php the_permalink();?>">
                                                            <?php echo htmega_kses_desc( $settings['read_more_txt'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_desc() sanitizes via wp_kses(), see includes/helper-function.php. ?>
                                                        </a>
                                                        <?php
                                                    endif; ?>
                                                </div>
                                            </div>
                                            <?php 
                                        } ?>
                                    </div>
                                </div>
                            <?php endif;?>

                        <?php else:?>
                            <div class="<?php echo esc_attr( $roclass ); ?> htb-col-12">
                                <div class="ht-post gradient-overlay gradient-overlay-<?php echo esc_attr($gdc);?> hero-post">
                                    
                                    <div class="thumb">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php 
                                                if ( has_post_thumbnail() ){
                                                    the_post_thumbnail( $htmega_image_size ); 
                                                }else{
                                                    echo '<img src="' . esc_url( HTMEGA_ADDONS_PL_URL . '/assets/images/image-placeholder.png' ) . '" alt="' . esc_attr( get_the_title() ) . '" />';
                                                }
                                            ?>
                                        </a>
                                    </div>
                                    <?php
                                        if( $settings['show_category'] == 'yes' ){
                                            if( $category_name ){
                                                $i=0;
                                                $get_terms = get_the_terms($grid_post->ID, $category_name[0] );
                                                if( $settings['grid_post_type'] == 'product' ){
                                                    $get_terms = get_the_terms($grid_post->ID, 'product_cat');
                                                }
                                                if( $get_terms ){
                                                    foreach ( $get_terms as $category ) {
                                                        $i++;
                                                        $term_link = get_term_link( $category );
                                                        ?>
                                                            <a href="<?php echo esc_url( $term_link ); ?>" class="category post-category post-position-top-left <?php echo esc_attr( $category->slug ); ?>"><?php echo esc_html( $category->name ); ?></a>
                                                        <?php
                                                        if($i==1){break;}
                                                    }
                                                }
                                            }
                                        }
                                        if ( $settings['show_title'] == 'yes' || $settings['show_date'] == 'yes' || $settings['show_content'] == 'yes' || $settings['show_read_more_btn'] == 'yes' ) {
                                            ?>
                                            <div class="post-content">
                                                <div class="content">
                                                    <?php if( $settings['show_title'] == 'yes' ):

                                                    printf( '<%1$s %2$s>%3$s</%1$s>',
                                                    htmega_escape_tags( $settings['title_tag'], 'h4' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_escape_tags() returns only a whitelisted tag name (h1-h6/div/span/p).
                                                    $this->get_render_attribute_string( 'htmega_post_attr' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own escaped attribute string, see get_render_attribute_string().
                                                    $title_link_text); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built above from esc_url() href + wp_kses_post()'d title, see $title_display.

                                                    endif; if( $settings['show_date'] == 'yes' ): ?>
                                                        <div class="meta">
                                                            <span class="meta-item date"><i class="fa fa-clock-o"></i> <?php the_time( 'd F Y' ); ?></span>
                                                        </div>
                                                    <?php endif;

                                                        if( $settings['show_content'] == 'yes' ):
                                                            if( $settings['content_type'] == 'excerpt' ){
                                                                echo '<p class="htmega-post-g-description">'. esc_html( wp_trim_words( get_the_excerpt(), floatval( $settings['content_length'] ),'' ) ) .'</p>';
                                                            } else {
                                                                echo '<p class="htmega-post-g-description">' . wp_kses_post( wp_trim_words( strip_shortcodes( get_the_content() ), floatval( $settings['content_length'] ), '' ) ) .'</p>'; 
                                                            }
                                                        endif;
                                                
                                                        if( $settings['show_read_more_btn'] == 'yes' && !empty( $settings['read_more_txt'] ) ): ?>
                                                            <a class="htmega-post-g-read-more" href="<?php the_permalink();?>">
                                                                <?php echo htmega_kses_desc( $settings['read_more_txt'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_desc() sanitizes via wp_kses(), see includes/helper-function.php. ?>
                                                            </a>
                                                            <?php
                                                        endif; ?>
                                                </div>
                                            </div>
                                            <?php 
                                        } ?>

                                </div>
                            </div>

                        <?php endif;?>

                        <?php 
                    endwhile; wp_reset_postdata(); 
                    else:
                        echo "<div class='htmega-error-notice'>".esc_html__('There are no posts in this query','ht-mega-for-elementor')."</div>";
                    endif;
                    ?>
                </div>
            </div>
        </div>

        <?php

    }
    // post query fields
    public function show_post_source(){

        $this->add_control(
            'grid_post_type',
            [
                'label' => esc_html__( 'Post Type', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => htmega_get_post_types(),
                'default' =>'post',
                'frontend_available' => true,
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'include_by',
            [
                'label' => __( 'Include By', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'default' =>'in_category',
                'options' => [
                    'in_author'      => __( 'Author', 'ht-mega-for-elementor' ),
                    'in_category'      => __( 'Category', 'ht-mega-for-elementor' ),
                ],
            ]
        );
        $this->add_control(
            'post_author',
            [
                'label' => esc_html__( 'Authors', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => htmega_get_authors_list(),
                'condition' =>[
                    'include_by' => 'in_author',
                ]
            ]
        );
        $all_post_type = htmega_get_post_types();
        foreach( $all_post_type as $post_key => $post_item ){
            
            if( 'post' == $post_key ){
                $this->add_control(
                    'grid_categories',
                    [
                        'label' => esc_html__( 'Categories', 'ht-mega-for-elementor' ),
                        'type' => Controls_Manager::SELECT2,
                        'label_block' => true,
                        'multiple' => true,
                        'options' => htmega_get_taxonomies(),
                        'condition' =>[
                            'grid_post_type' => 'post',
                            'include_by' => 'in_category',
                        ]
                    ]
                );
            } else if( 'product' == $post_key){
                $this->add_control(
                    'grid_prod_categories',
                    [
                        'label' => esc_html__( 'Categories', 'ht-mega-for-elementor' ),
                        'type' => Controls_Manager::SELECT2,
                        'label_block' => true,
                        'multiple' => true,
                        'options' => htmega_get_taxonomies('product_cat'),
                        'condition' =>[
                            'grid_post_type' => 'product',
                            'include_by' => 'in_category',
                        ]
                    ]
                );

            } else {
                $this->add_control(
                    "{$post_key}_post_category",
                    [
                        'label' => esc_html__( 'Select Categories', 'ht-mega-for-elementor' ),
                        'type' => Controls_Manager::SELECT2,
                        'label_block' => true,
                        'multiple' => true,
                        'options' => all_object_taxonomie_show_catagory($post_key),
                        'condition' => [
                            'grid_post_type' => $post_key,
                            'include_by' => 'in_category',
                        ],
                    ]
                );
            }

        }
        $this->add_control(
            "exclude_posts",
            [
                'label' => esc_html__( 'Exclude Posts', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__( 'Example: 10,11,105', 'ht-mega-for-elementor' ),
                'description' => esc_html__( "To Exclude Post, Enter  the post id separated by ','", 'ht-mega-for-elementor' ),
            ]
        );
        $this->add_control(
            'post_limit',
            [
                'label' => __('Limit', 'ht-mega-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5,
                'separator'=>'before',
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => esc_html__( 'Order By', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'ID'            => esc_html__('ID','ht-mega-for-elementor'),
                    'date'          => esc_html__('Date','ht-mega-for-elementor'),
                    'name'          => esc_html__('Name','ht-mega-for-elementor'),
                    'title'         => esc_html__('Title','ht-mega-for-elementor'),
                    'comment_count' => esc_html__('Comment count','ht-mega-for-elementor'),
                    'rand'          => esc_html__('Random','ht-mega-for-elementor'),
                ],
            ]
        );
        $this->add_control(
            'custom_order_by_date',
            [
                'label' => esc_html__( 'Custom Date', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'no',
                'condition' =>[
                    'orderby'=>'date'
                ]
            ]
        );
        $this->add_control(
            'order_by_date_before',
            [
                'label' => __( 'Before Date', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::DATE_TIME,
                'condition' =>[
                    'orderby'=>'date',
                    'custom_order_by_date'=>'yes',
                ]
            ]
        );
        $this->add_control(
            'order_by_date_after',
            [
                'label' => __( 'After Date', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::DATE_TIME,
                'condition' =>[
                    'orderby'=>'date',
                    'custom_order_by_date'=>'yes',
                ]
            ]
        );
        $this->add_control(
            'postorder',
            [
                'label' => esc_html__( 'Order', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC'  => esc_html__('Descending','ht-mega-for-elementor'),
                    'ASC'   => esc_html__('Ascending','ht-mega-for-elementor'),
                ],

            ]
        );
        $this->add_control(
            'hide_empty_thumbnail_post',
            [
                'label'         => esc_html__( 'Hide Empty Thumbnail', 'ht-mega-for-elementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'yes',
                'default'       => 'no',
            ]
        );
        $this->add_control(
            'hide_current_post',
            [
                'label'         => esc_html__( 'Hide Current Post', 'ht-mega-for-elementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'yes',
                'default'       => 'no',
                'separator'     =>'after',
            ]
        );
    }
}