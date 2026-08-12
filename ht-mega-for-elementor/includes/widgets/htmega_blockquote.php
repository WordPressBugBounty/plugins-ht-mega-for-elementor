<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_Blockquote extends Widget_Base {

    public function get_name() {
        return 'htmega-blockquote-addons';
    }
    
    public function get_title() {
        return __( 'Blockquote', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-blockquote';
    }
    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_keywords() {
        return ['blockquote', 'quote', 'quote content', 'htmega', 'ht mega', 'addons'];
    }

    public function get_help_url() {
        return 'https://wphtmega.com/docs/general-widgets/blockquote-widget/';
    }
    protected function register_controls() {

        $this->start_controls_section(
            'blockquote_content',
            [
                'label' => __( 'Blockquote', 'ht-mega-for-elementor' ),
            ]
        );
        
            $this->add_control(
                'content_source',
                [
                    'label'   => __( 'Select Content Source', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'custom',
                    'options' => [
                        'custom'    => __( 'Custom', 'ht-mega-for-elementor' ),
                        "elementor" => __( 'Elementor Template', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'template_id',
                [
                    'label'       => __( 'Content', 'ht-mega-for-elementor' ),
                    'type'        => Controls_Manager::SELECT,
                    'default'     => '0',
                    'options'     => htmega_elementor_template(),
                    'condition'   => [
                        'content_source' => "elementor"
                    ],
                ]
            );

            $this->add_control(
                'custom_content',
                [
                    'label' => __( 'Content', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::WYSIWYG,
                    'title' => __( 'Blockquote Content', 'ht-mega-for-elementor' ),
                    'condition' => [
                        'content_source' =>'custom',
                    ],
                ]
            );

            $this->add_control(
                'blockquote_by',
                [
                    'label' => __( 'Blockquote By', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Jon Doy', 'ht-mega-for-elementor' ),
                    'placeholder' => __( 'Jon Doy', 'ht-mega-for-elementor' ),
                ]
            );

            $this->add_control(
                'blockquote_type',
                [
                    'label' => __('Blockquote Type','ht-mega-for-elementor'),
                    'type' =>Controls_Manager::CHOOSE,
                    'options' =>[
                        'img' =>[
                            'title' =>__('Image','ht-mega-for-elementor'),
                            'icon' =>'eicon-image',
                        ],
                        'icon' =>[
                            'title' =>__('Icon','ht-mega-for-elementor'),
                            'icon' =>'eicon-info-circle',
                        ]
                    ],
                    'default' =>'img',
                ]
            );

            $this->add_control(
                'blockquote_image',
                [
                    'label' => __('Image','ht-mega-for-elementor'),
                    'type'=>Controls_Manager::MEDIA,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'condition' => [
                        'blockquote_type' => 'img',
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'blockquote_imagesize',
                    'default' => 'large',
                    'separator' => 'none',
                    'condition' => [
                        'blockquote_type' => 'img',
                    ]
                ]
            );

            $this->add_control(
                'blockquote_icon',
                [
                    'label' =>__('Icon','ht-mega-for-elementor'),
                    'type'=>Controls_Manager::ICONS,
                    'default' => [
                        'value' => 'fas fa-pencil',
                        'library' => 'fa-solid',
                    ],
                    'condition' => [
                        'blockquote_type' => 'icon',
                    ]
                ]
            );

            $this->add_control(
                'blockquote_position',
                [
                    'label' => __( 'Blockquote Position', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'righttop',
                    'options' => [
                        'lefttop'      => __( 'Left Top', 'ht-mega-for-elementor' ),
                        'leftcenter'   => __( 'Left Center', 'ht-mega-for-elementor' ),
                        'leftbottom'   => __( 'Left Bottom', 'ht-mega-for-elementor' ),
                        'centertop'    => __( 'Center Top', 'ht-mega-for-elementor' ),
                        'center'       => __( 'Center Center', 'ht-mega-for-elementor' ),
                        'centerbottom' => __( 'Center Bottom', 'ht-mega-for-elementor' ),
                        'righttop'     => __( 'Right Top', 'ht-mega-for-elementor' ),
                        'rightcenter'  => __( 'Right Center', 'ht-mega-for-elementor' ),
                        'rightbottom'  => __( 'Right Bottom', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

        $this->end_controls_section();

        // Style tab section
        $this->start_controls_section(
            'htmega_blockquote_style_section',
            [
                'label' => __( 'Style', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $this->add_responsive_control(
                'htmega_blockquote_align',
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
                        '{{WRAPPER}} .htmega-blockquote blockquote' => 'text-align: {{VALUE}};',
                    ],
                    'default' => 'left',
                    'separator' =>'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'htmega_blockquote_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-blockquote blockquote',
                ]
            );

            $this->add_responsive_control(
                'htmega_blockquote_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'htmega_blockquote_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'htmega_blockquote_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-blockquote blockquote',
                ]
            );

            $this->add_responsive_control(
                'htmega_blockquote_border_radius',
                [
                    'label' => __( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

        $this->end_controls_section();


        $this->start_controls_section(
            'htmega_blockquote_content_style_section',
            [
                'label' => __( 'Content', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'htmega_blockquote_content_color',
                [
                    'label' => __( 'Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#5b5b5b',
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote .blockquote_content' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .htmega-blockquote blockquote .blockquote_content p' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'htmega_blockquote_content_typography',
                    'selector' => '{{WRAPPER}} .htmega-blockquote blockquote .blockquote_content,{{WRAPPER}} .htmega-blockquote blockquote .blockquote_content p',
                ]
            );

            $this->add_responsive_control(
                'htmega_blockquote_content_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote .blockquote_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'htmega_blockquote_content_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote .blockquote_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

        $this->end_controls_section();


        $this->start_controls_section(
            'htmega_blockquoteby_style_section',
            [
                'label' => __( 'Quote By', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $this->add_control(
                'htmega_blockquoteby_color',
                [
                    'label' => __( 'Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#0056ff',
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote cite' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'htmega_blockquotenby_typography',
                    'selector' => '{{WRAPPER}} .htmega-blockquote blockquote cite',
                ]
            );

            $this->add_responsive_control(
                'htmega_blockquoteby_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote cite' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'htmega_blockquoteby_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote cite' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'htmega_blockquoteby_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-blockquote blockquote cite',
                ]
            );

            $this->add_responsive_control(
                'htmega_blockquoteby_border_radius',
                [
                    'label' => __( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote cite' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->add_control(
                'blockquoteby_before_position',
                [
                    'label' => __( 'Separator Position', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'before',
                    'options' => [
                        'before' => __( 'Before', 'ht-mega-for-elementor' ),
                        'after'  => __( 'After', 'ht-mega-for-elementor' ),
                        'none'   => __( 'None', 'ht-mega-for-elementor' ),
                    ],
                    'separator'=>'before',
                ]
            );

            $this->add_control(
                'blockquoteby_before_color',
                [
                    'label' => __( 'Separator Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#0056ff',
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote cite::before' => 'background-color: {{VALUE}};',
                    ],
                    'condition'=>[
                        'blockquoteby_before_position!'=>'none',
                    ]
                ]
            );

            $this->add_control(
                'blockquoteby_before_width',
                [
                    'label' => __( 'Separator Width', 'ht-mega-for-elementor' ),
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
                        '{{WRAPPER}} .htmega-blockquote blockquote cite::before' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'condition'=>[
                        'blockquoteby_before_position!'=>'none',
                    ]
                ]
            );

            $this->add_control(
                'blockquoteby_before_height',
                [
                    'label' => __( 'Separator Height', 'ht-mega-for-elementor' ),
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
                        'size' => 2,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote cite::before' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'condition'=>[
                        'blockquoteby_before_position!'=>'none',
                    ]
                ]
            );

        $this->end_controls_section();


        // blockquote icon style start
        $this->start_controls_section(
            'htmega_blockquoteicon_style_section',
            [
                'label' => __( 'Quote Icon', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' =>[
                    'blockquote_type' =>'icon',
                    'blockquote_icon!' =>'',
                ],
            ]
        );

            $this->add_control(
                'blockquoteicon_color',
                [
                    'label' => __( 'Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote .blockquote_icon' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .htmega-blockquote blockquote .blockquote_icon svg path' => 'fill: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'blockquoteicon_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-blockquote blockquote .blockquote_icon',
                ]
            );

            $this->add_responsive_control(
                'blockquoteicon_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote .blockquote_icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'blockquoteicon_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote .blockquote_icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'after',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'blockquoteicon_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-blockquote blockquote .blockquote_icon',
                ]
            );

            $this->add_responsive_control(
                'blockquoteicon_border_radius',
                [
                    'label' => __( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote .blockquote_icon' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->add_control(
                'blockquoteicon_fontsize',
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
                        'size' => 18,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote .blockquote_icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_control(
                'blockquoteicon_line_height',
                [
                    'label' => __( 'Line Height', 'ht-mega-for-elementor' ),
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
                        'size' => 45,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote .blockquote_icon' => 'line-height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'blockquoteicon_width',
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
                        'size' => 45,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote .blockquote_icon' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_control(
                'blockquoteicon_height',
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
                        'size' => 45,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote .blockquote_icon' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();
        

        // blockquote image style start
        $this->start_controls_section(
            'htmega_blockquoteimage_style_section',
            [
                'label' => __( 'Quote Image', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'blockquote_type' => 'img',
                ],
            ]
        );
            
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'blockquoteimage_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-blockquote blockquote img',
                ]
            );

            $this->add_responsive_control(
                'blockquoteimage_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'blockquoteimage_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'blockquoteimage_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-blockquote blockquote img',
                ]
            );

            $this->add_responsive_control(
                'blockquoteimage_border_radius',
                [
                    'label' => __( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote img' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->add_control(
                'blockquoteimage_width',
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
                        'size' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-blockquote blockquote img' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

        $this->end_controls_section();

    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();

        $this->add_render_attribute( 'htmega_blockquote_attr', 'class', 'htmega-blockquote' );
        $this->add_render_attribute( 'htmega_blockquote_attr', 'class', 'htmega-blockquote-position-'. esc_attr( $settings['blockquote_position'] ) );
        $this->add_render_attribute( 'htmega_blockquote_attr', 'class', 'htmega-citeseparator-position-'. esc_attr( $settings['blockquoteby_before_position'] ) );
       
        ?>
            <?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_render_attribute_string() is Elementor core and returns pre-escaped attribute output. ?>
            <div <?php echo $this->get_render_attribute_string( 'htmega_blockquote_attr' ); ?>>
                <blockquote>
                    <?php 
                        if ( $settings['content_source'] == 'custom' && !empty( $settings['custom_content'] ) ) {
                            echo '<div class="blockquote_content">'.wp_kses_post( $settings['custom_content'] ).'</div>';
                        } elseif ( $settings['content_source'] == "elementor" && !empty( $settings['template_id'] )) {
                            $template_id = absint( $settings['template_id'] );
                            echo htmega_get_template_content_by_id( $template_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        }
                        if( !empty( $settings['blockquote_by'] ) ){
                            echo '<cite class="quote-by"> '.esc_html( $settings['blockquote_by']).' </cite>';
                        }
                        if( !empty( $settings['blockquote_image'] ) && $settings['blockquote_type'] == 'img' ){
                            echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'blockquote_imagesize', 'blockquote_image' );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        }else{
                            echo sprintf('<span class="blockquote_icon">%1$s</span>', HTMega_Icon_manager::render_icon( $settings['blockquote_icon'], [ 'aria-hidden' => 'true' ] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        }
                    ?>
                </blockquote>
           </div>

        <?php
    }
}