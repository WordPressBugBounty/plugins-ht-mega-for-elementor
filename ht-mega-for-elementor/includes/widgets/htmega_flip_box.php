<?php
namespace Elementor;

// Elementor Classes
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_Flip_Box extends Widget_Base {

    public function get_name() {
        return 'htmega-flipbox-addons';
    }
    
    public function get_title() {
        return esc_html__( 'Flip Box', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-flip-box';
    }

    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_keywords() {
        return ['flip box', 'flip content', 'content box', 'flip item', 'htmega', 'ht mega', 'addons','widget'];
    }

    public function get_help_url() {
        return 'https://wphtmega.com/docs/creative-widgets/flipbox-widget/';
    }
    protected function is_dynamic_content():bool {
		return false;
	}
    protected function register_controls() {

        // Layout Content area Start
        $this->start_controls_section(
            'flipbox_content_layout',
            [
                'label' => esc_html__( 'Layout', 'ht-mega-for-elementor' ),
            ]
        );

            $this->add_control(
                'flipbox_layout',
                [
                    'label' => esc_html__( 'Layout', 'ht-mega-for-elementor' ),
                    'type' => 'htmega-preset-select',
                    'default' => '1',
                    'options' => [
                        '1'   => esc_html__( 'Layout One', 'ht-mega-for-elementor' ),
                        '2'   => esc_html__( 'Layout Two', 'ht-mega-for-elementor' ),
                        '3'   => esc_html__( 'Layout Three', 'ht-mega-for-elementor' ),
                        '4'   => esc_html__( 'Layout Four', 'ht-mega-for-elementor' ),
                        '5'   => esc_html__( 'Layout Five', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

        $this->end_controls_section();

        // Front Content area Start
        $this->start_controls_section(
            'flipbox_content_front',
            [
                'label' => esc_html__( 'Front', 'ht-mega-for-elementor' ),
            ]
            );
            $this->add_control(
                'content_type',
                [
                    'label' => esc_html__( 'Content Type', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'custom',
                    'options' => [
                        'custom'   => esc_html__( 'Custom', 'ht-mega-for-elementor' ),
                        'template'   => esc_html__( 'Elementor Template (Pro)', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'pro_notice2',
                [
                    'raw' => sprintf(/* translators: 1: Opening strong and anchor tags for Pro Version link, 2: Closing anchor and strong tags */
                        __('Upgrade to pro version to use this feature %1$s Pro Version %2$s', 'ht-mega-for-elementor'),
                        '<strong><a href="https://wphtmega.com/pricing/" target="_blank">',
                        '</a></strong>'),
                    'type' => Controls_Manager::RAW_HTML,
                    'content_classes' => 'htmega-pro-notice',
                    'condition' => [
                        'content_type'=> 'template',
                    ]
                ]
            );

            $this->add_control(
                'flipbox_content_type',
                [
                    'label'   => esc_html__( 'Icon Type', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => [
                        'none' => [
                            'title' => esc_html__( 'None', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-ban',
                        ],
                        'number' => [
                            'title' => esc_html__( 'Number', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-counter',
                        ],
                        'image' => [
                            'title' => esc_html__( 'Image', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-image-bold',
                        ],
                        'icon' => [
                            'title' => esc_html__( 'Icon', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-info-circle',
                        ],
                    ],
                    'default' => 'number',
                ]
            );

            $this->add_control(
                'flipbox_front_title',
                [
                    'label'         => esc_html__( 'Title', 'ht-mega-for-elementor' ),
                    'type'          => Controls_Manager::TEXT,
                    'default'       => esc_html__( 'Flip Box Heading', 'ht-mega-for-elementor' ),
                    'placeholder'   => esc_html__( 'Type your title here', 'ht-mega-for-elementor' ),
                ]
            );
            $this->add_control(
                'flipbox_front_number',
                [
                    'label'         => esc_html__( 'Number', 'ht-mega-for-elementor' ),
                    'type'          => Controls_Manager::TEXT,
                    'default'       => esc_html__( '01', 'ht-mega-for-elementor' ),
                    'condition'=>[
                        'flipbox_content_type'=>'number',
                    ],
                ]
            );

            $this->add_control(
                'flipbox_front_icon',
                [
                    'label'         => esc_html__( 'Icon', 'ht-mega-for-elementor' ),
                    'type'          => Controls_Manager::ICONS,
                    'condition'=>[
                        'flipbox_content_type'=>'icon',
                    ],
    
                ]
            );

            $this->add_control(
                'flipbox_front_image',
                [
                    'label' => __('Image','ht-mega-for-elementor'),
                    'type'=>Controls_Manager::MEDIA,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'condition' => [
                        'flipbox_content_type' => 'image',
                    ]
                ]
            );
            $this->add_control(
                'flipbox_front_s4_image',
                [
                    'label' => __('Backgournd Image','ht-mega-for-elementor'),
                    'type'=>Controls_Manager::MEDIA,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'condition' => [
                        'flipbox_layout'=>'4',
                    ]
                ]
            );
            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'flipboximagesize',
                    'default' => 'large',
                    'separator' => 'none',
                    'conditions' => [
                        'relation' => 'or',
                        'terms' => [
                            [
                            'terms' => [
                                    ['name' => 'flipbox_content_type', 'operator' => '==', 'value' => 'image']
                                ]
                            ],
                            [
                            'terms' => [
                                    ['name' => 'flipbox_layout', 'operator' => '===', 'value' => '4'],
                                ]
                            ],
                        ]
                    ],
                ]
            );
            $this->add_control(
                'flipbox_front_description',
                [
                    'label'         => esc_html__( 'Description', 'ht-mega-for-elementor' ),
                    'type'          => Controls_Manager::TEXTAREA,
                    'placeholder'   => esc_html__( 'Description', 'ht-mega-for-elementor' ),
                    'condition'=>[
                        'flipbox_layout'=>array( '3','4' ),
                    ],
                ]
            );
            $this->add_control(
                'flipbox_bottom_index_number',
                [
                    'label'         => esc_html__( 'Bottom Index Number', 'ht-mega-for-elementor' ),
                    'type'          => Controls_Manager::TEXT,
                    'default'       => esc_html__( '01', 'ht-mega-for-elementor' ),
                    'condition'=>[
                        'flipbox_layout'=>'3',
                    ],
                ]
            );
        $this->end_controls_section(); // Front Content area end

        // Back Content area Start
        $this->start_controls_section(
            'flipbox_content_back',
            [
                'label' => esc_html__( 'Back', 'ht-mega-for-elementor' ),
            ]
            );

            $this->add_control(
                'content_typeb',
                [
                    'label' => esc_html__( 'Content Type', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'custom',
                    'options' => [
                        'custom'   => esc_html__( 'Custom', 'ht-mega-for-elementor' ),
                        'template'   => esc_html__( 'Elementor Template (Pro)', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'pro_noticeb',
                [
                    'raw' => sprintf(/* translators: 1: Opening strong and anchor tags for Pro Version link, 2: Closing anchor and strong tags */
                        __('Upgrade to pro version to use this feature %1$s Pro Version %2$s', 'ht-mega-for-elementor'),
                        '<strong><a href="https://wphtmega.com/pricing/" target="_blank">',
                        '</a></strong>'),
                    'type' => Controls_Manager::RAW_HTML,
                    'content_classes' => 'htmega-pro-notice',
                    'condition' => [
                        'content_typeb'=> 'template',
                    ]
                ]
            );

            $this->add_control(
                'flipbox_back_content_type',
                [
                    'label'   => esc_html__( 'Icon Type', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => [
                        'none' => [
                            'title' => esc_html__( 'None', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-ban',
                        ],
                        'number' => [
                            'title' => esc_html__( 'Number', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-counter',
                        ],
                        'image' => [
                            'title' => esc_html__( 'Image', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-image-bold',
                        ],
                        'icon' => [
                            'title' => esc_html__( 'Icon', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-info-circle',
                        ],
                    ],
                    'default' => 'number',
                    'condition'=>[
                        'flipbox_layout!'=>'5',
                    ],
                ]
            );

            $this->add_control(
                'flipbox_back_title',
                [
                    'label'         => esc_html__( 'Title', 'ht-mega-for-elementor' ),
                    'type'          => Controls_Manager::TEXT,
                    'default'       => esc_html__( 'Flip Box Back Heading', 'ht-mega-for-elementor' ),
                    'placeholder'   => esc_html__( 'Type your title here', 'ht-mega-for-elementor' ),
                ]
            );
            $this->add_control(
                'flipbox_back_sub_title',
                [
                    'label'         => esc_html__( 'Sub Title', 'ht-mega-for-elementor' ),
                    'type'          => Controls_Manager::TEXT,
                    'default'       => esc_html__( 'UI/UX Designer', 'ht-mega-for-elementor' ),
                    'placeholder'   => esc_html__( 'Type your sub title here', 'ht-mega-for-elementor' ),
                    'condition' =>[
                        'flipbox_layout' => '5'
                    ]
                ]
            );

            $this->add_control(
                'flipbox_back_number',
                [
                    'label'         => esc_html__( 'Number', 'ht-mega-for-elementor' ),
                    'type'          => Controls_Manager::TEXT,
                    'default'       => esc_html__( '01', 'ht-mega-for-elementor' ),
                    'condition'=>[
                        'flipbox_back_content_type'=>'number',
                        'flipbox_layout!' => '5'
                    ],
                ]
            );

            $this->add_control(
                'flipbox_back_icon',
                [
                    'label'         => esc_html__( 'Icon', 'ht-mega-for-elementor' ),
                    'type'          => Controls_Manager::ICONS,
                    'condition'=>[
                        'flipbox_back_content_type'=>'icon',
                        'flipbox_layout!' => '5'
                        
                    ],
                ]
            );

            $this->add_control(
                'flipbox_back_image',
                [
                    'label' => __('Image','ht-mega-for-elementor'),
                    'type'=>Controls_Manager::MEDIA,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'condition' => [
                        'flipbox_back_content_type' => 'image',
                        'flipbox_layout!' => '5'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'flipboxbackimagesize',
                    'default' => 'large',
                    'separator' => 'none',
                    'condition' => [
                        'flipbox_back_content_type' => 'image',
                        'flipbox_layout!' => '5'
                    ]
                ]
            );

            $this->add_control(
                'flipbox_back_description',
                [
                    'label'         => esc_html__( 'Description', 'ht-mega-for-elementor' ),
                    'type'          => Controls_Manager::TEXTAREA,
                    'default'       => esc_html__( 'There are many variations of passages Lorem Ipsum available, but the majority hav suffered alteration in.', 'ht-mega-for-elementor' ),
                    'placeholder'   => esc_html__( 'Description', 'ht-mega-for-elementor' ),
                ]
            );

            $this->add_control(
                'flipbox_button',
                [
                    'label' => esc_html__( 'Button Text', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'condition' => [
                        'flipbox_layout!' => '5'
                    ]
                ]
            );

            $this->add_control(
                'flipbox_button_link',
                [
                    'label' => esc_html__( 'Button Link', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'ht-mega-for-elementor' ),
                    'show_external' => true,
                    'default' => [
                        'url' => '#',
                        'is_external' => false,
                        'nofollow' => false,
                    ],
                    'condition'=>[
                        'flipbox_button!'=>'',
                        'flipbox_layout!' => '5'
                    ]
                ]
            );
            $this->add_control(
                'flipbox_back_bottom_index_number',
                [
                    'label'         => esc_html__( 'Bottom Index Number', 'ht-mega-for-elementor' ),
                    'type'          => Controls_Manager::TEXT,
                    'default'       => esc_html__( '01', 'ht-mega-for-elementor' ),
                    'condition'=>[
                        'flipbox_layout'=>'3',
                    ],
                ]
            );

            $this->add_control(
                'show_social_list',
                [
                    'label' => esc_html__( 'Social Links', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'condition' =>[
                        'flipbox_layout'=>'5',
                    ]
                ]
            );
        $repeater = new Repeater();

            $repeater->add_control(
                'htmega_social_title',
                [
                    'label'   => esc_html__( 'Title', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => 'Facebook',
                ]
            );

            $repeater->add_control(
                'htmega_social_link',
                [
                    'label'   => esc_html__( 'Link', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => esc_url( 'https://www.facebook.com/hastech.company/' ),

                ]
            );

            $repeater->add_control(
                'htmega_social_icon',
                [
                    'label'   => esc_html__( 'Icon', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::ICONS,
                    'default' => [
                        'value'=>'fab fa-facebook-f',
                        'library'=>'fa-solid',
                    ],
                ]
            );

            $this->add_control(
                'htmega_flipbox_social_link_list',
                [
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $repeater->get_controls(),
                    'default' => [

                        [
                            'htmega_social_title'      => 'Facebook',
                            'htmega_social_icon'       => 'fab fa-facebook-f',
                            'htmega_social_link'       => esc_url( 'https://www.facebook.com/hastech.company/' ),
                        ],
                    ],
                    'title_field' => '{{{ htmega_social_title }}}',
                    'prevent_empty'=>false,
                    'condition' =>[
                        'show_social_list'=>'yes',
                        'flipbox_layout'=>'5',
                    ]
                ]
            );

        $this->end_controls_section();

        // Style Content area Start
        $this->start_controls_section(
            'flipbox_options',
            [
                'label' => esc_html__( 'Additional Options', 'ht-mega-for-elementor' ),
            ]
        );

            $this->add_responsive_control(
                'flipbox_height',
                [
                    'label' => esc_html__( 'Height', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 100,
                            'max' => 1000,
                        ],
                        'vh' => [
                            'min' => 10,
                            'max' => 100,
                        ],
                    ],
                    'size_units' => [ 'px', 'vh' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-flip-box-area' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'flipbox_animation',
                [
                    'label' => esc_html__( 'Animation', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'right',
                    'options' => [
                        'top'   => esc_html__( 'Flip Top', 'ht-mega-for-elementor' ),
                        'bottom'   => esc_html__( 'Flip Bottom', 'ht-mega-for-elementor' ),
                        'left'   => esc_html__( 'Flip Left', 'ht-mega-for-elementor' ),
                        'right'   => esc_html__( 'Flip Right', 'ht-mega-for-elementor' ),
                        'zoom_in'   => esc_html__( 'Zoom In', 'ht-mega-for-elementor' ),
                        'zoom_out'   => esc_html__( 'Zoom Out', 'ht-mega-for-elementor' ),
                        'fade_in'   => esc_html__( 'Fade In (Pro)', 'ht-mega-for-elementor' ),
                        'slide_left'   => esc_html__( 'Slide Left (Pro)', 'ht-mega-for-elementor' ),
                        'slide_right'   => esc_html__( 'Slide Right (Pro)', 'ht-mega-for-elementor' ),
                        'slide_top'   => esc_html__( 'Slide Top (Pro)', 'ht-mega-for-elementor' ),
                        'slide_bottom'   => esc_html__( 'Slide Bottom (Pro)', 'ht-mega-for-elementor' ),
                        'push_left'   => esc_html__( 'Push Left (Pro)', 'ht-mega-for-elementor' ),
                        'push_right'   => esc_html__( 'Push Right (Pro)', 'ht-mega-for-elementor' ),
                    ],
                ]
            );
            $this->add_control(
                'pro_notice',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => sprintf(/* translators: 1: Opening strong and anchor tags for Pro Version link, 2: Closing anchor and strong tags */
                        __('Upgrade to pro version to use this feature %1$s Pro Version %2$s', 'ht-mega-for-elementor'),
                        '<strong><a href="https://wphtmega.com/pricing/" target="_blank">',
                        '</a></strong>'),
                    'content_classes' => 'htmega-pro-notice',
                    'condition' => [
                        'flipbox_animation!'=> array('top','bottom','left','right','zoom_in','zoom_out'),
                    ]
                ]
            );
            $this->add_control(
                'htmega_3d_flip',
                [
                    'label' => esc_html__( '3D View', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                    
                ]
            );
            $this->add_control(
                'flip_heading_tag_free',
                [
                    'label' => esc_html__( 'Title Tag ', 'ht-mega-for-elementor' ) . ' <i class="eicon-pro-icon"></i>',
                    'type' => Controls_Manager::SELECT,
                    'default' => 'h2',
                    'options' => [
                        'h1' => esc_html__('H1', 'ht-mega-for-elementor'),
                        'h2' => esc_html__('H2', 'ht-mega-for-elementor'),
                        'h3' => esc_html__('H3', 'ht-mega-for-elementor'),
                        'h4' => esc_html__('H4', 'ht-mega-for-elementor'),
                        'h5' => esc_html__('H5', 'ht-mega-for-elementor'),
                        'h6' => esc_html__('H6', 'ht-mega-for-elementor'),
                        'span' => esc_html__('Span', 'ht-mega-for-elementor'),
                        'p' => esc_html__('P', 'ht-mega-for-elementor'),
                        'div' => esc_html__('Div', 'ht-mega-for-elementor'),
                    ],
                    'classes' => 'htmega-disable-control',
                ]
            );
        $this->end_controls_section();

        // Style tab section
        $this->start_controls_section(
            'flipbox_front_style_section',
            [
                'label' => esc_html__( 'Front', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_responsive_control(
                'flipbox_front_padding',
                [
                    'label' => esc_html__( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-flip-box-front .front-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'flipbox_front_background',
                    'label' => esc_html__( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-flip-box-front .front-container',
                ]
            );

            $this->add_control(
                'flipbox_front_background_overlay',
                [
                    'label'     => esc_html__( 'Background Overlay', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-flip-box-front .htmega-flip-overlay' => 'background-color: {{VALUE}};',
                    ],
                    'separator' => 'before',
                    'condition' => [
                        'flipbox_front_background_image[id]!' => '',
                    ],
                ]
            );

            $this->add_control(
                'flipbox_front_background_opacity',
                [
                    'label'   => esc_html__( 'Opacity (%)', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => 1,
                    ],
                    'range' => [
                        'px' => [
                            'max'  => 1,
                            'min'  => 0.10,
                            'step' => 0.01,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-flip-box-front .htmega-flip-overlay' => 'opacity: {{SIZE}};',
                    ],
                    'condition' => [
                        'flipbox_front_background_image[id]!' => '',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'flipbox_front_border',
                    'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-flip-box-front',
                ]
            );

            $this->add_responsive_control(
                'flipbox_front_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-flip-box-front' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );
            // Image Style tab front
            $this->add_control(
                'flipbox_style_image_heading',
                [
                    'label' => esc_html__( 'Image Box Style', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' =>[
                        'flipbox_layout' => '4',
                    ],
                ]
            );
            $this->add_responsive_control(
                'flipbox_image_height',
                [
                    'label' => esc_html__( 'Image Height', 'ht-mega-for-elementor' ),
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
                        '{{WRAPPER}} .htmega-flipbox-s4-image' => 'height: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .htmega-flipbox-s4-image img' => 'height: 100%',
                    ],
                    'condition' =>[
                        'flipbox_layout' => '4',
                    ],
                    'separator' => 'after',
                ]
            );            
            // Content Style tab front
            $this->add_control(
                'flipbox_style_tab_heading',
                [
                    'label' => esc_html__( 'Content Style Tabs', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->start_controls_tabs('flipbox_front_style_tabs');
                
                // Title style start
                $this->start_controls_tab(
                    'flipbox_front_style_title_tab',
                    [
                        'label' => esc_html__( 'Title', 'ht-mega-for-elementor' ),
                    ]
                );
                    $this->add_control(
                        'flipbox_front_title_color',
                        [
                            'label' => esc_html__( 'Title Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#4a4a4a',
                            'selectors' => [
                                '{{WRAPPER}} .front-container h2' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'flipbox_front_title_typography',
                            'selector' => '{{WRAPPER}} .front-container h2',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_front_title_padding',
                        [
                            'label' => esc_html__( 'Title Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .front-container h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_front_title_margin',
                        [
                            'label' => esc_html__( 'Title Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .front-container h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'flipbox_front_title_border',
                            'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .front-container h2',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_front_title_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .front-container h2' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Title style end
                // Description front style start
                $this->start_controls_tab(
                    'flipbox_front_style_description_tab',
                    [
                        'label' => esc_html__( 'Description', 'ht-mega-for-elementor' ),
                        'condition'=>[
                            'flipbox_layout'=>array( '3','4' ),
                        ],
                    ]
                    
                );
                    $this->add_control(
                        'flipbox_front_description_color',
                        [
                            'label' => esc_html__( 'Description Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .front-container p' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'flipbox_front_description_typography',
                            'selector' => '{{WRAPPER}} .front-container p',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_front_description_padding',
                        [
                            'label' => esc_html__( 'Description Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .front-container p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_front_description_margin',
                        [
                            'label' => esc_html__( 'Description Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .front-container p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );
                    

                $this->end_controls_tab(); // Description style end
                 // Icon style tab start
                $this->start_controls_tab(
                    'flipbox_front_style_icon_tab',
                    [
                        'label' => esc_html__( 'Icon', 'ht-mega-for-elementor' ),
                        'condition'=>[
                            'flipbox_front_icon[value]!'=>'',
                        ]
                    ]
                );
                    
                    $this->add_control(
                        'flipbox_front_icon_color',
                        [
                            'label' => esc_html__( 'Icon Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#4a4a4a',
                            'selectors' => [
                                '{{WRAPPER}} .front-container span.flipbox-icon i' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .front-container span.flipbox-icon svg path' => 'fill: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'flipbox_front_icon_fontsize',
                        [
                            'label' => esc_html__( 'Icon Size', 'ht-mega-for-elementor' ),
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
                            'default' => [
                                'unit' => 'px',
                                'size' => 70,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .front-container span i,{{WRAPPER}} .front-container span.flipbox-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                                '{{WRAPPER}} .front-container span.flipbox-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'flipbox_front_icon_background_color',
                        [
                            'label' => esc_html__( 'Icon Background Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#ff7a5a',
                            'selectors' => [
                                '{{WRAPPER}} .front-container span.flipbox-icon' => 'background-color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'flipbox_front_icon_width',
                        [
                            'label' => esc_html__( 'Icon Width', 'ht-mega-for-elementor' ),
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
                                '{{WRAPPER}} .front-container span.flipbox-icon' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                            'separator'=>'before',
                        ]
                    );

                    $this->add_control(
                        'flipbox_front_icon_height',
                        [
                            'label' => esc_html__( 'Icon Height', 'ht-mega-for-elementor' ),
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
                                '{{WRAPPER}} .front-container span.flipbox-icon' =>'min-height: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};display: flex;align-items: center;justify-content: center;line-height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_front_icon_padding',
                        [
                            'label' => esc_html__( 'Icon Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .front-container span.flipbox-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_front_icon_margin',
                        [
                            'label' => esc_html__( 'Icon Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .front-container span.flipbox-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'flipbox_front_icon_border',
                            'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .front-container span.flipbox-icon',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_front_icon_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .front-container span.flipbox-icon' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );
                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'flipbox_front_icon_boxshadow',
                            'label' => esc_html__( 'Box Shadow', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .front-container span.flipbox-icon',
                            'separator' =>'before',
                        ]
                    );
                    $this->add_control(
                        'flipbox_front_icon_seperator_color',
                        [
                            'label' => esc_html__( 'Separator Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-flip-box-style-2 .htmega-flip-box-front span.flipbox-icon::before, {{WRAPPER}} .htmega-flip-box-style-2 .htmega-flip-box-front span.flipbox-icon::after' => 'background-color: {{VALUE}};',
                            ],
                            'condition' => [
                                'flipbox_layout' => '2'
                            ]
                        ]
                    );                    
                $this->end_controls_tab(); // Icon style tab end

                 // Number style tab start
                $this->start_controls_tab(
                    'flipbox_front_style_number_tab',
                    [
                        'label' => esc_html__( 'Number', 'ht-mega-for-elementor' ),
                        'condition'=>[
                            'flipbox_content_type'=>'number',
                            'flipbox_front_number!'=>'',
                            // 'flipbox_layout!' => '4'
                        ]
                    ]
                );
                    
                    $this->add_control(
                        'flipbox_front_number_color',
                        [
                            'label' => esc_html__( 'Number Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#4a4a4a',
                            'selectors' => [
                                '{{WRAPPER}} .front-container .flipbox-number' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'flipbox_front_number_typography',
                            'selector' => '{{WRAPPER}} .front-container .flipbox-number',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_front_number_padding',
                        [
                            'label' => esc_html__( 'Number Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .front-container .flipbox-number' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_front_number_margin',
                        [
                            'label' => esc_html__( 'Number Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .front-container .flipbox-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'flipbox_front_number_border',
                            'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .front-container .flipbox-number',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_front_number_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .front-container .flipbox-number' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );
                    $this->add_control(
                        'flipbox_front_icon_seperator_color2',
                        [
                            'label' => esc_html__( 'Separator Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-flip-box-style-2 .htmega-flip-box-front span::before,{{WRAPPER}} .htmega-flip-box-style-2 .htmega-flip-box-front span::after' => 'background-color: {{VALUE}};',
                            ],
                            'condition' => [
                                'flipbox_layout' => '2'
                            ]
                        ]
                    );  
                $this->end_controls_tab(); // Number style tab end
                // Index front style start
                $this->start_controls_tab(
                    'flipbox_front_style_index_tab',
                    [
                        'label' => esc_html__( 'Index', 'ht-mega-for-elementor' ),
                        'condition'=>[
                            'flipbox_layout'=>'3',
                        ],
                    ]
                    
                );
                    $this->add_control(
                        'flipbox_front_index_color',
                        [
                            'label' => esc_html__( 'Index Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-flipbox-bottom-index-number' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'flipbox_front_index_typography',
                            'selector' => '{{WRAPPER}} .htmega-flipbox-bottom-index-number',
                        ]
                    );
                    $this->add_responsive_control(
                        'flipbox_front_index_margin',
                        [
                            'label' => esc_html__( 'Description Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-flipbox-bottom-index-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );
                    $this->add_control(
                        'index_front_stroke',
                        [
                            'label' => esc_html__( 'Stroke', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::SWITCHER,
                            'return_value' => 'yes',
                            'default' => 'no',
                            'condition' =>[
                                'flipbox_bottom_index_number!' => '',
                            ]
                        ]
                    );
                    $this->add_control(
                        'index_front_stroke_color',
                        [
                            'label' => esc_html__( 'Stroke Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-flipbox-bottom-index-number' => '-webkit-text-stroke-color: {{VALUE}};',
                            ],
                            'condition' =>[
                                'index_front_stroke' => 'yes',
                            ]
                        ]
                    );
                    $this->add_control(
                        'index_front_stroke_widht',
                        [
                            'label' => esc_html__( 'Stroke Fill Width', 'ht-mega-for-elementor' ),
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
                                '{{WRAPPER}} .htmega-flipbox-bottom-index-number' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                            ],
                            'condition' =>[
                                'index_front_stroke' => 'yes',
                            ]
                        ]
                    );                  
                $this->end_controls_tab(); // Index style end
            $this->end_controls_tabs();

        $this->end_controls_section();

        // Style tab section
        $this->start_controls_section(
            'flipbox_back_style_section',
            [
                'label' => esc_html__( 'Back', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
                'flipbox_back_padding',
                [
                    'label' => esc_html__( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-flip-box-back .back-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'flipbox_back_background',
                    'label' => esc_html__( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-flip-box-back',
                ]
            );

            $this->add_control(
                'flipbox_back_background_overlay',
                [
                    'label'     => esc_html__( 'Background Overlay', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-flip-box-back .htmega-flip-overlay' => 'background-color: {{VALUE}};',
                    ],
                    'separator' => 'before',
                    'condition' => [
                        'flipbox_back_background_image[id]!' => '',
                    ],
                ]
            );

            $this->add_control(
                'flipbox_back_background_opacity',
                [
                    'label'   => esc_html__( 'Opacity (%)', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => 1,
                    ],
                    'range' => [
                        'px' => [
                            'max'  => 1,
                            'min'  => 0.10,
                            'step' => 0.01,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-flip-box-back .htmega-flip-overlay' => 'opacity: {{SIZE}};',
                    ],
                    'condition' => [
                        'flipbox_back_background_image[id]!' => '',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'flipbox_back_border',
                    'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-flip-box-back',
                ]
            );

            $this->add_responsive_control(
                'flipbox_back_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-flip-box-back .back-container,{{WRAPPER}} .htmega-flip-box-back' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );


            // Content Style tab
            $this->add_control(
                'flipbox_back_style_tab_heading',
                [
                    'label' => esc_html__( 'Content Style Tabs', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->start_controls_tabs('flipbox_back_style_tabs');
                
                // Title style start
                $this->start_controls_tab(
                    'flipbox_back_style_title_tab',
                    [
                        'label' => esc_html__( 'Title', 'ht-mega-for-elementor' ),
                    ]
                );
                    $this->add_control(
                        'flipbox_back_title_color',
                        [
                            'label' => esc_html__( 'Title Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .back-container h2' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'flipbox_back_title_typography',
                            'selector' => '{{WRAPPER}} .back-container h2',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_back_title_padding',
                        [
                            'label' => esc_html__( 'Title Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .back-container h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_back_title_margin',
                        [
                            'label' => esc_html__( 'Title Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .back-container h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'flipbox_back_title_border',
                            'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .back-container h2',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_back_title_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .back-container h2' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Title style end
                // Sub Title style start
                $this->start_controls_tab(
                    'flipbox_back_style_sub_title_tab',
                    [
                        'label' => esc_html__( 'Sub Title', 'ht-mega-for-elementor' ),
                        'condition' =>[
                            'flipbox_layout' => '5',
                            'flipbox_back_sub_title!' => ''
                        ]
                    ]
                    
                );
                    $this->add_control(
                        'flipbox_back_sub_title_color',
                        [
                            'label' => esc_html__( 'Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .back-container h3' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'flipbox_back_sub_title_typography',
                            'selector' => '{{WRAPPER}} .back-container h3',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_back_sub_title_padding',
                        [
                            'label' => esc_html__( 'Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .back-container h3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_back_sub_title_margin',
                        [
                            'label' => esc_html__( 'Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .back-container h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'flipbox_back_sub_title_border',
                            'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .back-container h3',
                        ]
                    );

                $this->end_controls_tab(); // Sub Title style end

                // Description style start
                $this->start_controls_tab(
                    'flipbox_back_style_description_tab',
                    [
                        'label' => esc_html__( 'Description', 'ht-mega-for-elementor' ),
                    ]
                );
                    $this->add_control(
                        'flipbox_back_description_color',
                        [
                            'label' => esc_html__( 'Description Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .back-container p' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'flipbox_back_description_typography',
                            'selector' => '{{WRAPPER}} .back-container p',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_back_description_padding',
                        [
                            'label' => esc_html__( 'Description Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .back-container p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_back_description_margin',
                        [
                            'label' => esc_html__( 'Description Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .back-container p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );
                    

                $this->end_controls_tab(); // Title style end

                 // Icon style tab start
                $this->start_controls_tab(
                    'flipbox_back_style_icon_tab',
                    [
                        'label' => esc_html__( 'Icon', 'ht-mega-for-elementor' ),
                        'condition'=>[
                            'flipbox_back_content_type'=>'icon',
                            'flipbox_back_icon[value]!'=>'',
                        ]
                    ]
                );
                    
                    $this->add_control(
                        'flipbox_back_icon_color',
                        [
                            'label' => esc_html__( 'Icon Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#4a4a4a',
                            'selectors' => [
                                '{{WRAPPER}} .back-container span.flipbox-icon i' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .back-container span.flipbox-icon svg path' => 'fill: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'flipbox_back_icon_fontsize',
                        [
                            'label' => esc_html__( 'Icon Size', 'ht-mega-for-elementor' ),
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
                            'default' => [
                                'unit' => 'px',
                                'size' => 70,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .back-container span.flipbox-icon i,{{WRAPPER}} .back-container span.flipbox-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                                '{{WRAPPER}} .back-container span.flipbox-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'flipbox_back_icon_background_color',
                        [
                            'label' => esc_html__( 'Icon Background Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#ff7a5a',
                            'selectors' => [
                                '{{WRAPPER}} .back-container span.flipbox-icon' => 'background-color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'flipbox_back_icon_width',
                        [
                            'label' => esc_html__( 'Icon Width', 'ht-mega-for-elementor' ),
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
                                '{{WRAPPER}} .back-container span.flipbox-icon' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                            'separator'=>'before',
                        ]
                    );

                    $this->add_control(
                        'flipbox_back_icon_height',
                        [
                            'label' => esc_html__( 'Icon Height', 'ht-mega-for-elementor' ),
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
                                '{{WRAPPER}} .back-container span.flipbox-icon' => 'min-height: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};display: flex;align-items: center;justify-content: center;line-height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_back_icon_padding',
                        [
                            'label' => esc_html__( 'Icon Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .back-container span.flipbox-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_back_icon_margin',
                        [
                            'label' => esc_html__( 'Icon Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .back-container span.flipbox-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'after',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'flipbox_back_icon_border',
                            'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .back-container span.flipbox-icon',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_back_icon_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .back-container span.flipbox-icon' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );
                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'flipbox_back_icon_boxshadow',
                            'label' => esc_html__( 'Box Shadow', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .back-container span.flipbox-icon',
                            'separator' =>'before',
                        ]
                    );
                    $this->add_control(
                        'flipbox_front_icon_seperator_color3',
                        [
                            'label' => esc_html__( 'Separator Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-flip-box-style-2 .htmega-flip-box-back span.flipbox-icon::before,{{WRAPPER}} .htmega-flip-box-style-2 .htmega-flip-box-back span.flipbox-icon::after' => 'background-color: {{VALUE}};',
                            ],
                            'condition' => [
                                'flipbox_layout' => '2'
                            ]
                        ]
                    );  
                $this->end_controls_tab(); // Icon style tab end
                 //Social Icon style tab start
                 $this->start_controls_tab(
                    'flipbox_social_style_icon_tab',
                    [
                        'label' => esc_html__( 'Icons', 'ht-mega-for-elementor' ),
                        'condition'=>[
                            'show_social_list'=>'yes',
                            'flipbox_layout' => '5'
                        ]
                    ]
                );
                    
                    $this->add_control(
                        'flipbox_social_icon_color',
                        [
                            'label' => esc_html__( 'Icon Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} ul.htmega-flipbox-social-list li a' => 'color: {{VALUE}};',
                                '{{WRAPPER}} ul.htmega-flipbox-social-list li a svg path' => 'fill: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'flipbox_social_icon_fontsize',
                        [
                            'label' => esc_html__( 'Icon Size', 'ht-mega-for-elementor' ),
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
                                '{{WRAPPER}} ul.htmega-flipbox-social-list li a' => 'font-size: {{SIZE}}{{UNIT}};',
                                '{{WRAPPER}} ul.htmega-flipbox-social-list li a svg' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'flipbox_social_icon_background_color',
                        [
                            'label' => esc_html__( 'Icon Background Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} ul.htmega-flipbox-social-list li a' => 'background-color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'flipbox_social_icon_width',
                        [
                            'label' => esc_html__( 'Icon Width', 'ht-mega-for-elementor' ),
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
                                '{{WRAPPER}} ul.htmega-flipbox-social-list li a' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                            'separator'=>'before',
                        ]
                    );

                    $this->add_control(
                        'flipbox_social_icon_height',
                        [
                            'label' => esc_html__( 'Icon Height', 'ht-mega-for-elementor' ),
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
                                '{{WRAPPER}} ul.htmega-flipbox-social-list li a' => 'min-height: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};display: flex;align-items: center;justify-content: center;line-height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );
                    $this->add_responsive_control(
                        'flipbox_social_icon_margin',
                        [
                            'label' => esc_html__( 'Icon Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} ul.htmega-flipbox-social-list li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'after',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'flipbox_social_icon_border',
                            'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} ul.htmega-flipbox-social-list li a',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_back_social_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} ul.htmega-flipbox-social-list li a' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );
                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'flipbox_social_icon_boxshadow',
                            'label' => esc_html__( 'Box Shadow', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} ul.htmega-flipbox-social-list li a',
                            'separator' =>'before',
                        ]
                    ); 
                    // Social Icon Hover
                    $this->add_control(
                        'social_icon_hover_heading',
                        [
                            'label' => esc_html__( 'Icon Hover Style', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::HEADING,
                            'separator' =>'before',
                        ]
                    );               
                    $this->add_control(
                        'flipbox_social_icon_color_hover',
                        [
                            'label' => esc_html__( 'Icon Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} ul.htmega-flipbox-social-list li a:hover' => 'color: {{VALUE}};',
                                '{{WRAPPER}} ul.htmega-flipbox-social-list li a:hover svg path' => 'fill: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'flipbox_social_icon_background_color_hover',
                        [
                            'label' => esc_html__( 'Icon Background Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} ul.htmega-flipbox-social-list li a:hover' => 'background-color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'flipbox_social_icon_border_hover',
                            'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} ul.htmega-flipbox-social-list li a:hover',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_back_social_border_radius_hover',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} ul.htmega-flipbox-social-list li a:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );
                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'flipbox_social_icon_boxshadow_hover',
                            'label' => esc_html__( 'Box Shadow', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} ul.htmega-flipbox-social-list li a:hover',
                            'separator' =>'before',
                        ]
                    ); 

                $this->end_controls_tab(); //Social Icon style tab end
                 // Number style tab start
                $this->start_controls_tab(
                    'flipbox_back_style_number_tab',
                    [
                        'label' => esc_html__( 'Number', 'ht-mega-for-elementor' ),
                        'condition'=>[
                            'flipbox_back_content_type'=>'number',
                            'flipbox_back_number!'=>'',
                                'flipbox_layout!' => '5'
                        ]
                    ]
                );
                    
                    $this->add_control(
                        'flipbox_back_number_color',
                        [
                            'label' => esc_html__( 'Number Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .back-container .flipbox-number' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'flipbox_back_number_typography',
                            'selector' => '{{WRAPPER}} .back-container .flipbox-number',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_back_number_padding',
                        [
                            'label' => esc_html__( 'Number Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .back-container .flipbox-number' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_back_number_margin',
                        [
                            'label' => esc_html__( 'Number Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .back-container .flipbox-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'flipbox_back_number_border',
                            'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .back-container .flipbox-number',
                        ]
                    );

                    $this->add_responsive_control(
                        'flipbox_back_number_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .back-container .flipbox-number' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );
                    $this->add_control(
                        'flipbox_front_icon_seperator_color4',
                        [
                            'label' => esc_html__( 'Separator Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-flip-box-style-2 .htmega-flip-box-back span::before,{{WRAPPER}} .htmega-flip-box-style-2 .htmega-flip-box-back span::after' => 'background-color: {{VALUE}};',
                            ],
                            'condition' => [
                                'flipbox_layout' => '2'
                            ]
                        ]
                    ); 
                $this->end_controls_tab(); // Number style tab end
                // Index back style start
                $this->start_controls_tab(
                    'flipbox_back_style_index_tab',
                    [
                        'label' => esc_html__( 'Index', 'ht-mega-for-elementor' ),
                        'condition'=>[
                            'flipbox_layout'=>'3',
                        ],
                    ]
                    
                );
                    $this->add_control(
                        'flipbox_back_index_color',
                        [
                            'label' => esc_html__( 'Index Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-flipbox-back-bottom-index-number' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'flipbox_back_index_typography',
                            'selector' => '{{WRAPPER}} .htmega-flipbox-back-bottom-index-number',
                        ]
                    );
                    $this->add_responsive_control(
                        'flipbox_back_index_margin',
                        [
                            'label' => esc_html__( 'Description Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-flipbox-back-bottom-index-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );
                    $this->add_control(
                        'index_back_stroke',
                        [
                            'label' => esc_html__( 'Stroke', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::SWITCHER,
                            'return_value' => 'yes',
                            'default' => 'no',
                            'condition' =>[
                                'flipbox_back_bottom_index_number!' => '',
                            ]
                        ]
                    );
                    $this->add_control(
                        'index_back_stroke_color',
                        [
                            'label' => esc_html__( 'Stroke Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-flipbox-back-bottom-index-number' => '-webkit-text-stroke-color: {{VALUE}};',
                            ],
                            'condition' =>[
                                'index_back_stroke' => 'yes',
                            ]
                        ]
                    );
                    $this->add_control(
                        'index_back_stroke_widht',
                        [
                            'label' => esc_html__( 'Stroke Fill Width', 'ht-mega-for-elementor' ),
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
                                '{{WRAPPER}} .htmega-flipbox-back-bottom-index-number' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
                            ],
                            'condition' =>[
                                'index_back_stroke' => 'yes',
                            ]
                        ]
                    );                     
                $this->end_controls_tab(); // Index back style end
            $this->end_controls_tabs();

            $this->add_control(
                'read_more_button_style',
                [
                    'label' => esc_html__( 'Button Style', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition'=>[
                        'flipbox_button!'=>'',
                        'flipbox_layout!' => '5'
                    ]
                ]
            );  
       // Style Read More button tab section        
       $this->start_controls_tabs('readmore_style_tabs',
       [ 'condition'=>[
            'flipbox_button!'=>'',
            'flipbox_layout!' => '5'
        ]
       ]
    );
        $this->start_controls_tab(
            'readmore_style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'ht-mega-for-elementor' ),

            ]
        );

            $this->add_control(
                'readmore_color',
                [
                    'label' => esc_html__( 'Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-flip-box-area .flp-btn a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'readmore_typography',
                    'label' => esc_html__( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-flip-box-area .flp-btn a',
                ]
            );

            $this->add_responsive_control(
                'readmore_margin',
                [
                    'label' => esc_html__( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-flip-box-area .flp-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'readmore_padding',
                [
                    'label' => esc_html__( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-flip-box-area .flp-btn a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'readmore_background',
                    'label' => esc_html__( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-flip-box-area .flp-btn a',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'readmore_border',
                    'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-flip-box-area .flp-btn a',
                ]
            );

            $this->add_responsive_control(
                'readmore_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-flip-box-area .flp-btn a' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

        $this->end_controls_tab(); // Normal Tab end

        $this->start_controls_tab(
            'readmore_style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'ht-mega-for-elementor' ),
            ]
        );
            $this->add_control(
                'readmore_hover_color',
                [
                    'label' => esc_html__( 'Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-flip-box-area .flp-btn a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'readmore_hover_background',
                    'label' => esc_html__( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-flip-box-area .flp-btn a:hover',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'readmore_hover_border',
                    'label' => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-flip-box-area .flp-btn a:hover',
                ]
            );

            $this->add_responsive_control(
                'readmore_hover_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-flip-box-area .flp-btn a:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

        $this->end_controls_tab(); // Hover Tab end

    $this->end_controls_tabs();
        $this->end_controls_section();


    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        $this->add_render_attribute( 'htmega_flipbox_attr', 'class', 'htmega-flip-box-area' );
        if( '4' == $settings['flipbox_layout'] ){
            $this->add_render_attribute( 'htmega_flipbox_attr', 'class', 'htmega-flip-box-style-1  htmega-flip-box-style-3 htmega-flip-box-style-'. esc_attr( $settings['flipbox_layout'] ) );
        } elseif( '3' == $settings['flipbox_layout'] ){
            $this->add_render_attribute( 'htmega_flipbox_attr', 'class', 'htmega-flip-box-style-1 htmega-flip-box-style-'. esc_attr( $settings['flipbox_layout'] ) );
        } else {
            $this->add_render_attribute( 'htmega_flipbox_attr', 'class', 'htmega-flip-box-style-'. esc_attr( $settings['flipbox_layout'] ) );
        }
        if( in_array( $settings['flipbox_animation'], array( 'push_left', 'slide_bottom', 'slide_top', 'slide_right','slide_left', 'fade_in', 'push_right') ) ){
            $this->add_render_attribute( 'htmega_flipbox_attr', 'class', 'htmega-flip-box-animation-none' );
        } else {
            $this->add_render_attribute( 'htmega_flipbox_attr', 'class', 'htmega-flip-box-animation-'. esc_attr( $settings['flipbox_animation'] ) );
        }
        if( 'yes' == $settings['htmega_3d_flip'] ) {
            $this->add_render_attribute( 'htmega_flipbox_attr', 'class', 'htmega-3d-wrap' );
        }
        if ( isset(  $settings['flipbox_button_link']['url'] ) && ! empty( $settings['flipbox_button_link']['url'] ) ) {
            $this->add_link_attributes( 'url', $settings['flipbox_button_link'] );

            $flbbutton = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'url' ), $settings['flipbox_button'] );
        }
       
        ?>
            
            <div <?php echo $this->get_render_attribute_string( 'htmega_flipbox_attr' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor core get_render_attribute_string() already escapes attributes. ?>>

                <div class='htmega-flip-box-front'>
                    <div class="front-container">
                    <?php if( 'yes' == $settings['htmega_3d_flip'] ) { echo '<div class="htmega-3d-flip">'; } ?>
                        <?php if( '4' == $settings['flipbox_layout'] ){ ?>
                            <div class="htmega-flipbox-s4-image">
                                    <?php
                                    if( !empty( $settings['flipbox_front_s4_image']['url'] ) ){
                                        echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'flipboximagesize', 'flipbox_front_s4_image' );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor core Group_Control_Image_Size::get_attachment_image_html() already escapes output.
                                    }

                                    if( !empty( $settings['flipbox_front_number'] ) ){
                                        echo '<span class="flipbox-number">'.esc_html( $settings['flipbox_front_number'] ).'</span>';
                                    }
                                    if( !empty( $settings['flipbox_front_icon']['value'] ) ){
                                        echo '<span class="flipbox-icon">'.HTMega_Icon_manager::render_icon( $settings['flipbox_front_icon'], [ 'aria-hidden' => 'true' ] ).'</span>';  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTMega_Icon_manager::render_icon() delegates to Elementor's Icons_Manager::render_icon(), which escapes output.
                                    }
                                    if( !empty( $settings['flipbox_front_image']['url'] ) ){
                                        echo'<span class="flipbox-icon">'. Group_Control_Image_Size::get_attachment_image_html( $settings, 'flipboximagesize', 'flipbox_front_image' ).'</span>';  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor core Group_Control_Image_Size::get_attachment_image_html() already escapes output.
                                    }

                                    ?>
                            </div>
                        <?php } ?>
                        <?php
                            if( '4' != $settings['flipbox_layout'] ){
                                if( !empty( $settings['flipbox_front_number'] ) ){
                                    echo '<span class="flipbox-number">'.esc_html( $settings['flipbox_front_number'] ).'</span>';
                                }
                                if( !empty( $settings['flipbox_front_icon']['value'] ) ){
                                    echo '<span class="flipbox-icon">'.HTMega_Icon_manager::render_icon( $settings['flipbox_front_icon'], [ 'aria-hidden' => 'true' ] ).'</span>';  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTMega_Icon_manager::render_icon() delegates to Elementor's Icons_Manager::render_icon(), which escapes output.
                                }
                                if( !empty( $settings['flipbox_front_image']['url'] ) ){
                                    echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'flipboximagesize', 'flipbox_front_image' );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor core Group_Control_Image_Size::get_attachment_image_html() already escapes output.
                                }
                            }
                            if( !empty( $settings['flipbox_front_title'] ) ){
                                echo '<h2>'.htmega_kses_title( $settings['flipbox_front_title'] ).'</h2>';  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_title() sanitizes via wp_kses(), see includes/helper-function.php
                            }
                            if( !empty( $settings['flipbox_front_description'] ) ){
                                echo '<p>'.htmega_kses_desc( $settings['flipbox_front_description'] ).'</p>';  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_desc() sanitizes via wp_kses(), see includes/helper-function.php
                            }
                            if( !empty( $settings['flipbox_bottom_index_number'] ) ){
                                echo '<div class="htmega-flipbox-bottom-index-number">'.esc_html( $settings['flipbox_bottom_index_number'] ).'</div>';
                            }
                        ?>
                    <?php if( 'yes' == $settings['htmega_3d_flip'] ) { echo '</div>'; } ?>
                    </div>
                    <div class="htmega-flip-overlay"></div>
                </div>

                <div class='htmega-flip-box-back'>
                    <div class="back-container">
                    <?php if( 'yes' == $settings['htmega_3d_flip'] ) { echo '<div class="htmega-3d-flip">'; } ?>
                        <?php
                            if( !empty( $settings['flipbox_back_number'] ) ){
                                echo '<span class="flipbox-number">'.esc_html( $settings['flipbox_back_number'] ).'</span>';
                            }
                            if( !empty( $settings['flipbox_back_icon']['value'] ) ){
                                echo '<span class="flipbox-icon">'.HTMega_Icon_manager::render_icon( $settings['flipbox_back_icon'], [ 'aria-hidden' => 'true' ] ).'</span>';  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTMega_Icon_manager::render_icon() delegates to Elementor's Icons_Manager::render_icon(), which escapes output.
                            }
                            if( !empty( $settings['flipbox_back_image']['url'] ) ){
                                echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'flipboxbackimagesize', 'flipbox_back_image' );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor core Group_Control_Image_Size::get_attachment_image_html() already escapes output.
                            }
                            if( !empty( $settings['flipbox_back_title'] ) ){
                                echo '<h2>'.esc_html( $settings['flipbox_back_title'] ).'</h2>';
                            }
                            if( !empty( $settings['flipbox_back_sub_title'] ) ){
                                echo '<h3>'.esc_html( $settings['flipbox_back_sub_title'] ).'</h3>';
                            }
                            if( !empty( $settings['flipbox_back_description'] ) ){
                                echo '<p>'.esc_html( $settings['flipbox_back_description'] ).'</p>';
                            }
                            if( !empty( $settings['flipbox_button'] ) ){
                                echo '<div class="flp-btn">'.wp_kses_post( $flbbutton ).'</div>';
                            }
                            if( !empty( $settings['flipbox_back_bottom_index_number'] ) ){
                                echo '<div class="htmega-flipbox-back-bottom-index-number">'.esc_html( $settings['flipbox_back_bottom_index_number'] ).'</div>';
                            }
                            if( !empty( $settings['htmega_flipbox_social_link_list'] ) ){ ?>
                            <ul class="htmega-flipbox-social-list">
                                <?php foreach ( $settings['htmega_flipbox_social_link_list'] as $socialprofile ) :?>
                                    <li><a href="<?php echo esc_url( $socialprofile['htmega_social_link'] ); ?>"><?php echo HTMega_Icon_manager::render_icon( $socialprofile['htmega_social_icon'], [ 'aria-hidden' => 'true' ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTMega_Icon_manager::render_icon() delegates to Elementor's Icons_Manager::render_icon(), which escapes output. ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php
                        }
                        ?>

                        <?php if( 'yes' == $settings['htmega_3d_flip'] ) { echo '</div>'; } ?>
                    </div>
                    <div class="htmega-flip-overlay"></div>
                </div>

            </div>

        <?php

    }

}