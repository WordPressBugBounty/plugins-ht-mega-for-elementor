<?php
namespace Elementor;

// Elementor Classes
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_Working_Process extends Widget_Base {

    public function get_name() {
        return 'htmega-working-process-addons';
    }
    
    public function get_title() {
        return __( 'Working Process', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-import-export';
    }
    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_keywords() {
        return ['htmega', 'ht mega', 'working process', 'process', 'progress', 'button', 'addons','widget'];
    }

    public function get_help_url() {
        return 'https://wphtmega.com/docs/woocommerce-widgets/woocommerce-add-to-cart-widget/';
    }
    protected function is_dynamic_content():bool {
		return false;
	}
    protected function register_controls() {

        $this->start_controls_section(
            'process_content',
            [
                'label' => __( 'Working Process', 'ht-mega-for-elementor' ),
            ]
        );

            $this->add_control(
                'process_style',
                [
                    'label' => __( 'Style', 'ht-mega-for-elementor' ),
                    'type' => 'htmega-preset-select',
                    'default' => '1',
                    'options' => [
                        '1' => __( 'Style One', 'ht-mega-for-elementor' ),
                        '2' => __( 'Style Two', 'ht-mega-for-elementor' ),
                        '3' => __( 'Style Three', 'ht-mega-for-elementor' ),
                        '4' => __( 'Style Four', 'ht-mega-for-elementor' ),
                        '5' => __( 'Style Five', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'process_column',
                [
                    'label' => __( 'Column', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '4',
                    'options' => [
                        '1' => __( 'Column One', 'ht-mega-for-elementor' ),
                        '2' => __( 'Column Two', 'ht-mega-for-elementor' ),
                        '3' => __( 'Column Three', 'ht-mega-for-elementor' ),
                        '4' => __( 'Column Four', 'ht-mega-for-elementor' ),
                        '5' => __( 'Column Five', 'ht-mega-for-elementor' ),
                    ],
                    'condition' =>[
                        'process_style'=> array(  '1','2' ),
                    ]
                ]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'process_title',
                [
                    'label'   => esc_html__( 'Title', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Process #1', 'ht-mega-for-elementor' ),
                ]
            );

            $repeater->add_control(
                'process_number',
                [
                    'label'   => esc_html__( 'Process Number', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::TEXT,
                ]
            );

            $repeater->add_control(
                'process_description',
                [
                    'label'   => esc_html__( 'Description', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolo magna aliqua. Ut enim ad minim veniam, quis nostrud exerci ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in repre in voluptate.', 'ht-mega-for-elementor' ),
                ]
            );

            $repeater->add_control(
                'process_icon_type',
                [
                    'label' => esc_html__('Icon Type','ht-mega-for-elementor'),
                    'type' =>Controls_Manager::CHOOSE,
                    'options' =>[
                        'img' =>[
                            'title' =>__('Image','ht-mega-for-elementor'),
                            'icon' =>'eicon-image-bold',
                        ],
                        'icon' =>[
                            'title' =>__('Icon','ht-mega-for-elementor'),
                            'icon' =>'eicon-info-circle',
                        ]
                    ],
                    'default' =>'img',
                ]
            );

            $repeater->add_control(
                'process_image',
                [
                    'label' => __('Image','ht-mega-for-elementor'),
                    'type'=>Controls_Manager::MEDIA,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'condition' => [
                        'process_icon_type' => 'img',
                    ]
                ]
            );

            $repeater->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'process_imagesize',
                    'default' => 'large',
                    'separator' => 'none',
                    'condition' => [
                        'process_icon_type' => 'img',
                    ]
                ]
            );

            $repeater->add_control(
                'process_icon',
                [
                    'label' =>__('Icon','ht-mega-for-elementor'),
                    'type'=>Controls_Manager::ICONS,
                    'default' => [
                        'value'=>'fa fa-pencil-alt',
                        'library'=>'fa-solid',
                    ],
                    'condition' => [
                        'process_icon_type' => 'icon',
                    ]
                ]
            );

            $this->add_control(
                'htmega_process_list',
                [
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $repeater->get_controls(),
                    'default' => [
                        [
                            'process_title' => esc_html__( 'Process #1', 'ht-mega-for-elementor' ),
                            'process_description' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor incid idunt ut labore','ht-mega-for-elementor' ),
                        ],
                        [
                            'process_title' => esc_html__( 'Process #2', 'ht-mega-for-elementor' ),
                            'process_description' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor incid idunt ut labore.','ht-mega-for-elementor' ),
                        ],
                        [
                            'process_title' => esc_html__( 'Process #3', 'ht-mega-for-elementor' ),
                            'process_description' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor incid idunt ut labore.','ht-mega-for-elementor' ),
                        ],
                    ],
                    'title_field' => '{{{ process_title }}}',
                ]
            );
            
        $this->end_controls_section();

        // Style tab section
        $this->start_controls_section(
            'process_style_section',
            [
                'label' => __( 'Box Style', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'working_area_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-process-area',
                ]
            );

            $this->add_responsive_control(
                'working_area_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'working_area_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_control(
                'vertical_line_color',
                [
                    'label' => __( 'Vertical Line Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#e51515',
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-style-3::before' => 'background: {{VALUE}}',
                    ],
                    'condition' => array(
                        'process_style' => '3' 
                    )
                ]
            );
            $this->add_control(
                'vertical_border_width',
                [
                    'label' => __( 'Border Width', 'ht-mega-for-elementor' ),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-style-3::before' => 'width: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .htmega-process-style-3 .htmega-single-process.process-reverse .icon::before' => 'left: {{SIZE}}px; margin-left:-1px;',
                        '{{WRAPPER}} .htmega-process-style-3 .htmega-single-process .icon::after' => 'width: {{SIZE}}px;',
                    ],
                    'condition' => array(
                        'process_style' => '3' 
                    )
                ]
            );
            $this->add_control(
                'vertical_border_hieght',
                [
                    'label' => __( 'Arrow Border Height', 'ht-mega-for-elementor' ),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 200,
                        ],
                    ],


                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-style-3 .htmega-single-process .icon::after' => 'height: {{SIZE}}px;',
                    ],
                    'condition' => array(
                        'process_style' => '3' 
                    )
                ]
            );
            $this->add_control(
                'arrow_left_color',
                [
                    'label' => __( 'Arrow Left Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#e51515',
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-style-3 .htmega-single-process:not(.process-reverse) .icon::before' => 'border-right-color: {{VALUE}}',
                    ],
                    'condition' => array(
                        'process_style' => '3' 
                    )
                ]
            );

            $this->add_control(
                'arrow_right_color',
                [
                    'label' => __( 'Arrow Right Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#e51515',
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-style-3 .htmega-single-process.process-reverse .icon::before' => 'border-left-color: {{VALUE}}',
                    ],
                    'condition' => array(
                        'process_style' => '3' 
                    )
                ]
            );
            $this->add_control(
                'arrow_hover_color',
                [
                    'label' => __( 'Arrow Hover Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-style-3 .htmega-single-process.process-reverse:hover .icon::before' => 'border-left-color: {{VALUE}};border-right-color: transparent',
                        '{{WRAPPER}} .htmega-process-style-3 .htmega-single-process:hover .icon::before' => 'border-right-color: {{VALUE}}',

                        '{{WRAPPER}} .htmega-process-style-3 .htmega-single-process .icon::after' => 'background: {{VALUE}}',
                    ],
                    'condition' => array(
                        'process_style' => '3' 
                    )
                ]
            );

        $this->end_controls_section();

        // Process Item tab section
        $this->start_controls_section(
            'process_item_style_section',
            [
                'label' => __( 'Item style', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs(
            'style_iteam_tabs'
        );
            // Normal item Style Tab
            $this->start_controls_tab(
                'iteam_style_normal_tab',
                [
                    'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                ]
            );
            $this->add_responsive_control(
                'item_width',
                [
                    'label' => __( 'Item Width', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => '%',
                    'range' => [
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-style-5 .htmega-single-process-area' => 'width: {{SIZE}}%;',
                    ],
                    'condition' => array(
                        'process_style' => '5' 
                    )
                ]
            ); 
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'working_item_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-single-process',
                    'separator'=> 'before',
                    'condition'=>[
                        'process_style!' =>'4',
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'working_item_4_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-single-process-area',
                    'separator'=> 'before',
                    'condition'=>[
                        'process_style' =>'4',
                    ]
                ]
            );

            $this->add_responsive_control(
                'working_item_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-single-process' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'working_item_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-single-process' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'working_item_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-single-process',
                ]
            );

            $this->add_responsive_control(
                'working_item_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-single-process,{{WRAPPER}} .htmega-process-style-4 .htmega-single-process-area:before' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->add_control(
                'item_seperator_style',
                [
                    'label' => __( 'Items Seperator Style', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition'=>[
                        'process_style' =>array( '2','5'),
                    ]
                ]
            );
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'number_shape_background',
                    'label' => __( 'Item Number Shape', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-number::before,{{WRAPPER}} .htmega-process-style-5 .htmega-single-process-area:after',
                    'condition'=>[
                        'process_style' =>array( '2','5'),
                    ]
                ]
            );
            $this->add_responsive_control(
                'seperator_height',
                [
                    'label' => __( 'Seperator Height', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 200,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-number::before,{{WRAPPER}} .htmega-process-style-5 .htmega-single-process-area:after' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'condition'=>[
                        'process_style' =>array( '2','5'),
                    ]
                ]
            );
            $this->add_responsive_control(
                'seperator_width',
                [
                    'label' => __( 'Seperator Width', 'ht-mega-for-elementor' ),
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
                    'selectors' => [
                        '{{WRAPPER}} .htmega-number::before,{{WRAPPER}} .htmega-process-style-5 .htmega-single-process-area:after' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'condition'=>[
                        'process_style' =>array( '2','5'),
                    ]
                ]
            ); 
            $this->add_responsive_control(
                'seperator_position',
                [
                    'label' => __( 'Position', 'ht-mega-for-elementor' ),
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
                        ''
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-number::before,{{WRAPPER}} .htmega-process-style-5 .htmega-single-process-area:after' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                    'condition'=>[
                        'process_style' =>array('5'),
                    ]
                ]
            ); 


            $this->end_controls_tab(); //end normal tab

            // Item Hover Style Tab
            $this->start_controls_tab(
                'iteam_style_hover_tab',
                [
                    'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    'condition'=>[
                        'process_style' =>array( '4','5'),
                    ]
                ]
            );
                $this->add_responsive_control(
                'item_width_hover',
                [
                    'label' => __( 'Item Width', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' =>'%',
                    'range' => [
                        
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-style-5 .htmega-single-process-area:hover' => 'width: {{SIZE}}%;',
                    ],
                    'condition' => [
                        'process_style' => '5' 
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'working_item_background_hover',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-process-style-5  .htmega-single-process2:before,{{WRAPPER}} .htmega-process-style-4 .htmega-single-process-area:before',
                    'separator'=> 'before',
                    // 'condition'=>[
                    //     'process_style!' =>'5',
                    // ]
                ]
            );
            $this->add_control(
                'hover_all_content_color',
                [
                    'label' => __( 'All Content Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-single-process-area:hover .htmega-content h4, {{WRAPPER}} .htmega-single-process-area:hover .htmega-content p,{{WRAPPER}} .htmega-single-process-area:hover .htmega-number span,{{WRAPPER}} .htmega-single-process-area:hover .htmega-single-process .icon i,{{WRAPPER}} .htmega-process-style-4 .htmega-single-process-area:hover .htmega-single-process .htmega-content h4' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .htmega-single-process-area:hover .htmega-single-process .icon svg path' => 'fill: {{VALUE}}',
                    ],
                    'condition'=>[
                        'process_style' =>array( '5','4'),
                    ]
                ]
            );

            $this->end_controls_tab();
            $this->end_controls_tabs();
        $this->end_controls_section();


        // Process Title tab section
        $this->start_controls_section(
            'process_title_style_section',
            [
                'label' => __( 'Title', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'title_color',
                [
                    'label' => __( 'Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#555555',
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area .htmega-content h4' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'title_color_hover',
                [
                    'label' => __( 'Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area .htmega-single-process:hover .htmega-content h4' => 'color: {{VALUE}}',
                    ],
                    'condition' => array(
                        'process_style' => '3' 
                    )
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-process-area .htmega-content h4',
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'title_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area .htmega-content h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'title_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area .htmega-content h4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'title_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-process-area .htmega-content h4',
                ]
            );

            $this->add_responsive_control(
                'title_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area .htmega-content h4' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

        $this->end_controls_section();

        // Process Description tab section
        $this->start_controls_section(
            'process_content_style_section',
            [
                'label' => __( 'Description', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'content_color',
                [
                    'label' => __( 'Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#494849',
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area .htmega-content p' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-process-area .htmega-content p,{{WRAPPER}} .htmega-process-style-5 .htmega-single-process-area:hover .htmega-single-process .htmega-content p',
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'content_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area .htmega-content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'content_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area .htmega-content p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'content_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-process-area .htmega-content p',
                ]
            );

            $this->add_responsive_control(
                'content_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area .htmega-content p' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

        $this->end_controls_section();

        // Process Description tab section
        $this->start_controls_section(
            'process_number_style_section',
            [
                'label' => __( 'Number', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

           

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'number_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-process-area .htmega-number span',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'number_box_shadow',
                    'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-process-area .htmega-number span',
                ]
            );

            $this->add_control(
                'number_color',
                [
                    'label' => __( 'Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#5a5a5a',
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area .htmega-number span' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'number_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-process-area .htmega-number span',
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'number_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area .htmega-number span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'number_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area .htmega-number span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'number_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-process-area .htmega-number span',
                ]
            );

            $this->add_responsive_control(
                'number_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area .htmega-number span' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );
            $this->add_control(
                'number_width',
                [
                    'label' => __( 'Width', 'ht-mega-for-elementor' ),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 500,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area .htmega-number span' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'number_height',
                [
                    'label' => __( 'Height', 'ht-mega-for-elementor' ),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 500,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area .htmega-number span' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
                
                    ],
                ]
            );
        $this->end_controls_section();

        // Process Icon Style tab section
        $this->start_controls_section(
            'process_icon_style_section',
            [
                'label' => __( 'Icon', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs(
            'icon_style_tabs'
        );
            // Normal Style Tab
            $this->start_controls_tab(
                'icon_style_normal_tab',
                [
                    'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                ]
            );
            $this->add_control(
                'icon_color',
                [
                    'label' => __( 'Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#555555',
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area .htmega-single-process .icon' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .htmega-process-area .htmega-single-process .icon i' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .htmega-process-area .htmega-single-process .icon svg path' => 'fill: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'icon_font_size',
                [
                    'label' => __( 'Font Size', 'ht-mega-for-elementor' ),
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
                        'size' => 20,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area .htmega-single-process .icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .htmega-process-area .htmega-single-process .icon svg' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'icon_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-process-area .htmega-single-process .icon,{{WRAPPER}} .htmega-process-style-4 .htmega-single-process .icon img',
                ]
            );

            $this->add_responsive_control(
                'icon_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-process-area .htmega-single-process .icon,{{WRAPPER}} .htmega-process-style-4 .htmega-single-process .icon img' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'icon_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-process-area .htmega-single-process .icon',
                ]
            );
            $this->add_control(
                'icon_width',
                [
                    'label' => __( 'Width', 'ht-mega-for-elementor' ),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 500,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-single-process .icon' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'condition'=>[
                        'process_style!' =>'3',
                    ]
                ]
            );

            $this->add_control(
                'icon_height',
                [
                    'label' => __( 'Height', 'ht-mega-for-elementor' ),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 500,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-single-process .icon' => 'height: {{SIZE}}{{UNIT}};',
                
                    ],
                    'condition'=>[
                        'process_style!' =>'3',
                    ]
                ]
            );
            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'icon_box_shadow',
                    'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-process-area .htmega-single-process .icon',
                ]
            );

            $this->end_controls_tab(); //end normal tab

            // Hover Style Tab
            $this->start_controls_tab(
                'icon_style_hover_tab',
                [
                    'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                ]
            );
                $this->add_control(
                    'icon_color_hover',
                    [
                        'label' => __( 'Color', 'ht-mega-for-elementor' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .htmega-process-area .htmega-single-process:hover .icon' => 'color: {{VALUE}}',
                            '{{WRAPPER}} .htmega-process-area .htmega-single-process:hover .icon i' => 'color: {{VALUE}}',
                            '{{WRAPPER}} .htmega-process-area .htmega-single-process:hover .icon svg path' => 'fill: {{VALUE}}',
                        ],
                    ]
                );
                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'icon_background_hover',
                        'label' => __( 'Background', 'ht-mega-for-elementor' ),
                        'types' => [ 'classic', 'gradient' ],
                        'selector' => '{{WRAPPER}} .htmega-process-area .htmega-single-process:hover .icon',
                    ]
                );
                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'icon_border_hover',
                        'label' => __( 'Border', 'ht-mega-for-elementor' ),
                        'selector' => '{{WRAPPER}} .htmega-process-area .htmega-single-process:hover .icon',
                    ]
                );
            $this->end_controls_tabS(); //end
        $this->end_controls_section();

        // Process Image Style tab section
        $this->start_controls_section(
            'process_image_style_section',
            [
                'label' => __( 'Image', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'process_image_width',
            [
                'label' => __( 'Width', 'ht-mega-for-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .htmega-single-process .icon img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'process_image_border',
                'label' => __( 'Border', 'ht-mega-for-elementor' ),
                'selector' => '{{WRAPPER}} .htmega-single-process .icon img',
            ]
        );
        $this->add_responsive_control(
            'process_image_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .htmega-single-process .icon img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'process_image_box_shadow',
                'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                'selector' => '{{WRAPPER}} .htmega-single-process .icon img',
            ]
        );
        $this->end_controls_section();

    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        $sectionid = "sid". $this-> get_id();
        if( '5'== $settings['process_style'] ){
            $this->add_render_attribute( 'htmega_process_attr', 'class', 'htmega-process-area  htmega-process-style-2  htmega-process-style-' . esc_attr( $settings['process_style'] ) );
        } else{
            $this->add_render_attribute( 'htmega_process_attr', 'class', 'htmega-process-area htmega-process-style-' . esc_attr( $settings['process_style'] ) );
        }

        if( isset( $settings['process_column'] ) ){
            $this->add_render_attribute( 'htmega_process_attr', 'class', 'htmega-column htmega-process-column-' . esc_attr( $settings['process_column'] ) );
        }

        $active_process_class = '';
        ?>
        <?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_render_attribute_string() is Elementor core, already escaped. ?>
        <div <?php echo $this->get_render_attribute_string( 'htmega_process_attr' ); ?>>

            <?php 
                $i = 0; 
                foreach ( $settings['htmega_process_list'] as $item ) : 
                    $i++;
                    if( $settings['process_style'] == 4 && $i == 1 ){
                        $active_process_class = 'open';
                    }else {
                        $active_process_class = '';
                    }
            ?>
                <div class="htmega-single-process-area">
                <?php 
                if( '5'== $settings['process_style'] ){ ?>

                    <div class="htmega-single-process <?php echo esc_attr( $active_process_class ); if( $i%2 == 0 ){ echo esc_attr( 'process-reverse' ); }?>">
                        <?php
                            if( $item['process_icon_type'] == 'img' && !empty( $item['process_image']['url'] ) ) {
                                // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Group_Control_Image_Size::get_attachment_image_html() is Elementor core, already escaped.
                                echo '<div class="icon">'.Group_Control_Image_Size::get_attachment_image_html( $item, 'process_imagesize', 'process_image' ).'</div>';
                            }else{
                                if( $item['process_icon_type'] == 'icon' && !empty( $item['process_icon']['value'] ) ){
                                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTMega_Icon_manager::render_icon() wraps Elementor core Icons_Manager::render_icon(), already escaped.
                                    echo '<div class="icon">'.HTMega_Icon_manager::render_icon( $item['process_icon'], [ 'aria-hidden' => 'true' ] ).'</div>';
                                }
                            }
                        ?>
                        <?php
                            if( !empty( $item['process_number'] ) ){
                                echo '<div class="htmega-number"><span>'.esc_html( $item['process_number'] ).'</span></div>';
                            }
                        ?>
                        <div class="htmega-content">
                            <?php
                                if( !empty( $item['process_title'] ) ){
                                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_title() sanitizes via wp_kses(), see includes/helper-function.php.
                                    echo '<h4>'.htmega_kses_title( $item['process_title'] ).'</h4>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="htmega-single-process htmega-single-process2 <?php echo esc_attr( $active_process_class ); if( $i%2 == 0 ){ echo esc_attr( 'process-reverse' ); } ?>">
                        <?php
                            if( $item['process_icon_type'] == 'img' && !empty( $item['process_image']['url'] ) ) {
                                // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Group_Control_Image_Size::get_attachment_image_html() is Elementor core, already escaped.
                                echo '<div class="icon">'.Group_Control_Image_Size::get_attachment_image_html( $item, 'process_imagesize', 'process_image' ).'</div>';
                            }else{
                                if( $item['process_icon_type'] == 'icon' && !empty( $item['process_icon']['value'] ) ){
                                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTMega_Icon_manager::render_icon() wraps Elementor core Icons_Manager::render_icon(), already escaped.
                                    echo '<div class="icon">'.HTMega_Icon_manager::render_icon( $item['process_icon'], [ 'aria-hidden' => 'true' ] ).'</div>';
                                }
                            }
                        ?>
                        <?php
                            if( !empty( $item['process_number'] ) ){
                                echo '<div class="htmega-number"><span>'.esc_html( $item['process_number'] ).'</span></div>';
                            }
                        ?>
                        <div class="htmega-content">
                            <?php
                                if( !empty( $item['process_title'] ) ){
                                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_title() sanitizes via wp_kses(), see includes/helper-function.php.
                                    echo '<h4>'.htmega_kses_title( $item['process_title'] ).'</h4>';
                                }
                                if( !empty( $item['process_description'] ) ){
                                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_desc() sanitizes via wp_kses(), see includes/helper-function.php.
                                    echo '<p>'.htmega_kses_desc( $item['process_description'] ).'</p>';
                                }
                            ?>
                        </div>
                    </div>
                    <?php }else{ ?>

                        <div class="htmega-single-process <?php echo esc_attr( $active_process_class ); if( $i%2 == 0 ){ echo esc_attr( 'process-reverse' ); }?>">
                        <?php
                            if( $item['process_icon_type'] == 'img' && !empty( $item['process_image']['url'] ) ) {
                                // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Group_Control_Image_Size::get_attachment_image_html() is Elementor core, already escaped.
                                echo '<div class="icon">'.Group_Control_Image_Size::get_attachment_image_html( $item, 'process_imagesize', 'process_image' ).'</div>';
                            }else{
                                if( $item['process_icon_type'] == 'icon' && !empty( $item['process_icon']['value'] ) ){
                                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTMega_Icon_manager::render_icon() wraps Elementor core Icons_Manager::render_icon(), already escaped.
                                    echo '<div class="icon">'.HTMega_Icon_manager::render_icon( $item['process_icon'], [ 'aria-hidden' => 'true' ] ).'</div>';
                                }
                            }
                        ?>
                        <?php
                            if( !empty( $item['process_number'] ) ){
                                echo '<div class="htmega-number"><span>'.esc_html( $item['process_number'] ).'</span></div>';
                            }
                        ?>
                        <div class="htmega-content">
                            <?php
                                if( !empty( $item['process_title'] ) ){
                                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_title() sanitizes via wp_kses(), see includes/helper-function.php.
                                    echo '<h4>'.htmega_kses_title( $item['process_title'] ).'</h4>';
                                }
                                if( !empty( $item['process_description'] ) ){
                                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_desc() sanitizes via wp_kses(), see includes/helper-function.php.
                                    echo '<p>'.htmega_kses_desc( $item['process_description'] ).'</p>';
                                }
                            ?>
                        </div>
                    </div>
                    <?php } ?>

                </div>
            <?php endforeach;?>

        </div>

        <?php
    }

}

