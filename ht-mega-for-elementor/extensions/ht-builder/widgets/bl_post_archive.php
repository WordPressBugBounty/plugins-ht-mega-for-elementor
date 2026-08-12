<?php
namespace HTMega_Builder\Elementor\Widget;

// Elementor Classes
use Elementor\Plugin as Elementor;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Bl_Post_Archive_ELement extends Widget_Base {

    public function get_name() {
        return 'bl-post-archive';
    }

    public function get_title() {
        return __( 'Archive Posts', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-posts-grid';
    }
    public function get_keywords() {
        return ['archive', 'archive posts', 'post archive', 'posts', 'blog posts','htmega', 'ht mega', 'addons'];
    }

    public function get_help_url() {
        return 'https://wphtmega.com/docs';
    }
    protected function register_controls() {

        // Content
        $this->start_controls_section(
            'post-layout-setting',
            [
                'label' => __( 'Settings', 'ht-mega-for-elementor' ),
            ]
        );
            
            $this->add_control(
                'post_layout',
                [
                    'label' => __( 'Layout', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'one',
                    'options' => [
                        'one' => __( 'Layout One', 'ht-mega-for-elementor' ),
                        'two' => __( 'Layout Two', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'post_grid_column',
                [
                    'label' => __( 'Columns', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '4',
                    'options' => [
                        '1' => __( '1', 'ht-mega-for-elementor' ),
                        '2' => __( '2', 'ht-mega-for-elementor' ),
                        '3' => __( '3', 'ht-mega-for-elementor' ),
                        '4' => __( '4', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'read_more_btn_text',
                [
                    'label' => __( 'Read More Button Text', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Read more', 'ht-mega-for-elementor' ),
                    'placeholder' => __( 'Enter Your Text', 'ht-mega-for-elementor' ),
                ]
            );

            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'imagesize',
                    'default' => 'full',
                    'separator' => 'none',
                ]
            );

            $this->add_control(
                'post_more_options',
                [
                    'label' => __( 'Additional Options', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'show_title',
                [
                    'label' => __( 'Show Title', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Hide', 'ht-mega-for-elementor' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'show_category',
                [
                    'label' => __( 'Show Category', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Hide', 'ht-mega-for-elementor' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'show_meta_info',
                [
                    'label' => __( 'Show Post Meta', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Hide', 'ht-mega-for-elementor' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'show_read_more',
                [
                    'label' => __( 'Show Read More Button', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Hide', 'ht-mega-for-elementor' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

        $this->end_controls_section();

        // Post Query
        $this->start_controls_section(
            'posts-query',
            [
                'label' => __( 'Query Settings', 'ht-mega-for-elementor' ),
            ]
        );

            $this->add_control(
                'content_length',
                [
                    'label' => __( 'Content Length', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 0,
                    'max' => 1000,
                    'step' => 1,
                    'default' => 50,
                ]
            );

            $this->add_control(
                'title_length',
                [
                    'label' => __( 'Title Length', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 0,
                    'max' => 1000,
                    'step' => 1,
                    'default' => 6,
                    'condition'=> [
                        'show_title' => 'yes'
                    ]
                ]
            );

            $this->add_control(
                'post_custom_order',
                [
                    'label' => __( 'Custom order', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $this->add_control(
                'orderby',
                [
                    'label' => __( 'Orderby', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'none',
                    'options' => [
                        'none'          => __('None','ht-mega-for-elementor'),
                        'ID'            => __('ID','ht-mega-for-elementor'),
                        'date'          => __('Date','ht-mega-for-elementor'),
                        'name'          => __('Name','ht-mega-for-elementor'),
                        'title'         => __('Title','ht-mega-for-elementor'),
                        'comment_count' => __('Comment count','ht-mega-for-elementor'),
                        'rand'          => __('Random','ht-mega-for-elementor'),
                    ],
                    'condition' => [
                        'post_custom_order' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'order',
                [
                    'label' => __( 'order', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'DESC',
                    'options' => [
                        'DESC'  => __('Descending','ht-mega-for-elementor'),
                        'ASC'   => __('Ascending','ht-mega-for-elementor'),
                    ],
                    'condition' => [
                        'post_custom_order' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'hide_pagination_button',
                [
                    'label' => __( 'Hide Pagination', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .htbuilder-pagination' => 'display: none;',
                    ],
                ]
            );

        $this->end_controls_section();

        // Item Box Style
        $this->start_controls_section(
            'post_item_style_section',
            array(
                'label' => __( 'Item', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_responsive_control(
                'post_item_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htbuilder-single-post' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'post_item_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htbuilder-single-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'post_item_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htbuilder-single-post',
                ]
            );

            $this->add_responsive_control(
                'post_item_border_radius',
                [
                    'label' => __( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htbuilder-single-post' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
            $this->add_responsive_control(
                'post_item_align',
                [
                    'label'   => __( 'Alignment', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options'      => [
                        'left'   => [
                            'title' => __( 'Left', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-text-align-center',
                        ],
                        'right'  => [
                            'title' => __( 'Right', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-text-align-right',
                        ],
                    ],                    
                    'selectors' => [
                        '{{WRAPPER}} .htbuilder-single-post'   => 'text-align: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_section();

        // Title Style
        $this->start_controls_section(
            'post_title_style_section',
            array(
                'label' => __( 'Title', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=> [
                    'show_title' => 'yes'
                ]
            )
        );

            $this->start_controls_tabs( 'title_style_tabs' );
                
                // Title Normal Style
                $this->start_controls_tab(
                    'style_title_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'post_title_color',
                        [
                            'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-post-title a' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'post_title_typography',
                            'label'     => __( 'Typography', 'ht-mega-for-elementor' ),
                            'selector'  => '{{WRAPPER}} .htbuilder-post-title',
                        )
                    );

                    $this->add_responsive_control(
                        'post_title_margin',
                        [
                            'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'post_title_align',
                        [
                            'label'   => __( 'Alignment', 'ht-mega-for-elementor' ),
                            'type'    => Controls_Manager::CHOOSE,
                            'options'      => [
                                'left'   => [
                                    'title' => __( 'Left', 'ht-mega-for-elementor' ),
                                    'icon'  => 'eicon-text-align-left',
                                ],
                                'center' => [
                                    'title' => __( 'Center', 'ht-mega-for-elementor' ),
                                    'icon'  => 'eicon-text-align-center',
                                ],
                                'right'  => [
                                    'title' => __( 'Right', 'ht-mega-for-elementor' ),
                                    'icon'  => 'eicon-text-align-right',
                                ],
                            ],   
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-post-title'   => 'text-align: {{VALUE}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();
                
                // Title Hover
                $this->start_controls_tab(
                    'style_title_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );
                    
                    $this->add_control(
                        'post_title_hover_color',
                        [
                            'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-post-title a:hover' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Meta Info Style
        $this->start_controls_section(
            'post_meta_info_style_section',
            array(
                'label' => __( 'Meta Info', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=> [
                    'show_meta_info' => 'yes'
                ]
            )
        );

            $this->start_controls_tabs('post_meta_info_style_tabs');

                // Meta info Normal
                $this->start_controls_tab(
                    'post_meta_info_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );
                    
                    $this->add_control(
                        'post_meta_info_color',
                        [
                            'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-post-meta-info' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htbuilder-post-meta-info a' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'post_meta_info_typography',
                            'label'     => __( 'Typography', 'ht-mega-for-elementor' ),
                            'selector'  => '{{WRAPPER}} .htbuilder-post-meta-info',
                        )
                    );

                    $this->add_responsive_control(
                        'post_meta_info_margin',
                        [
                            'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-post-meta-info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'post_meta_info_align',
                        [
                            'label'   => __( 'Alignment', 'ht-mega-for-elementor' ),
                            'type'    => Controls_Manager::CHOOSE,
                            'options'      => [
                                'left'   => [
                                    'title' => __( 'Left', 'ht-mega-for-elementor' ),
                                    'icon'  => 'eicon-text-align-left',
                                ],
                                'center' => [
                                    'title' => __( 'Center', 'ht-mega-for-elementor' ),
                                    'icon'  => 'eicon-text-align-center',
                                ],
                                'right'  => [
                                    'title' => __( 'Right', 'ht-mega-for-elementor' ),
                                    'icon'  => 'eicon-text-align-right',
                                ],
                            ],   
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-post-meta-info'   => 'text-align: {{VALUE}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Meta Info Hover
                $this->start_controls_tab(
                    'post_meta_info_style_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );
                    
                    $this->add_control(
                        'post_meta_info_hover_color',
                        [
                            'label'     => __( 'Link Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-post-meta-info a:hover' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Category Style
        $this->start_controls_section(
            'post_meta_category_style_section',
            array(
                'label' => __( 'Category', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=> [
                    'show_category' => 'yes'
                ]
            )
        );

            $this->start_controls_tabs('post_meta_category_style_tabs');

                // Category Normal
                $this->start_controls_tab(
                    'post_meta_category_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );
                    
                    $this->add_control(
                        'post_meta_category_color',
                        [
                            'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-post-cat a' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'post_meta_category_typography',
                            'label'     => __( 'Typography', 'ht-mega-for-elementor' ),
                            'selector'  => '{{WRAPPER}} .htbuilder-post-cat a',
                        )
                    );

                    $this->add_responsive_control(
                        'post_meta_category_margin',
                        [
                            'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-post-cat' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'post_meta_category_align',
                        [
                            'label'   => __( 'Alignment', 'ht-mega-for-elementor' ),
                            'type'    => Controls_Manager::CHOOSE,
                            'options'      => [
                                'left'   => [
                                    'title' => __( 'Left', 'ht-mega-for-elementor' ),
                                    'icon'  => 'eicon-text-align-left',
                                ],
                                'center' => [
                                    'title' => __( 'Center', 'ht-mega-for-elementor' ),
                                    'icon'  => 'eicon-text-align-center',
                                ],
                                'right'  => [
                                    'title' => __( 'Right', 'ht-mega-for-elementor' ),
                                    'icon'  => 'eicon-text-align-right',
                                ],
                            ],   
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-post-cat'   => 'text-align: {{VALUE}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Meta Info Hover
                $this->start_controls_tab(
                    'post_meta_category_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );
                    
                    $this->add_control(
                        'post_meta_category_hover_color',
                        [
                            'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-post-cat a:hover' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Content Style
        $this->start_controls_section(
            'post_content_style_section',
            array(
                'label' => __( 'Content', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'post_content_color',
                [
                    'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htbuilder-post-content p' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'post_content_typography',
                    'label'     => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector'  => '{{WRAPPER}} .htbuilder-post-content p',
                )
            );

            $this->add_responsive_control(
                'post_content_align',
                [
                    'label'   => __( 'Alignment', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options'      => [
                        'left'   => [
                            'title' => __( 'Left', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-text-align-center',
                        ],
                        'right'  => [
                            'title' => __( 'Right', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-text-align-right',
                        ],
                    ],   
                    'selectors' => [
                        '{{WRAPPER}} .htbuilder-post-content p'   => 'text-align: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_section();

        // Read More Style
        $this->start_controls_section(
            'post_readmore_style_section',
            array(
                'label' => __( 'Read More', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=> [
                    'show_read_more' => 'yes'
                ]
            )
        );

            $this->start_controls_tabs('post_readmore_style_tabs');

                // Read More Normal
                $this->start_controls_tab(
                    'post_readmore_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );
                    
                    $this->add_control(
                        'post_readmore_color',
                        [
                            'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-read-more-btn' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'post_readmore_typography',
                            'label'     => __( 'Typography', 'ht-mega-for-elementor' ),
                            'selector'  => '{{WRAPPER}} .htbuilder-read-more-btn',
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'post_readmore_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htbuilder-read-more-btn',
                        ]
                    );

                    $this->add_responsive_control(
                        'post_readmore_border_radius',
                        [
                            'label' => __( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-read-more-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'post_readmore_padding',
                        [
                            'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-read-more-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'post_readmore_margin',
                        [
                            'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-read-more-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Read More Hover
                $this->start_controls_tab(
                    'post_readmore_style_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'post_readmore_hover_color',
                        [
                            'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-read-more-btn:hover' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'post_readmore_hover_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htbuilder-read-more-btn:hover',
                        ]
                    );

                    $this->add_responsive_control(
                        'post_readmore_hover_border_radius',
                        [
                            'label' => __( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-read-more-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Pagination Style
        $this->start_controls_section(
            'post_pagination_style_section',
            array(
                'label' => __( 'Pagination', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'hide_pagination_button!'=>'yes'
                ]
            )
        );

            $this->start_controls_tabs('post_pagination_style_tabs');

                // Read More Normal
                $this->start_controls_tab(
                    'post_pagination_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );
                    
                    $this->add_control(
                        'post_pagination_color',
                        [
                            'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-pagination ul li a' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htbuilder-pagination ul li span.current' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'post_pagination_typography',
                            'label'     => __( 'Typography', 'ht-mega-for-elementor' ),
                            'selector'  => '{{WRAPPER}} .htbuilder-pagination ul li a',
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'post_pagination_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htbuilder-pagination ul li a',
                        ]
                    );

                    $this->add_responsive_control(
                        'post_pagination_border_radius',
                        [
                            'label' => __( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-pagination ul li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'post_pagination_margin',
                        [
                            'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-pagination ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Pagination Hover
                $this->start_controls_tab(
                    'post_pagination_style_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'post_pagination_hover_color',
                        [
                            'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-pagination ul li span.current' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htbuilder-pagination ul li:hover a' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'post_pagination_hover_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htbuilder-pagination ul li:hover a, {{WRAPPER}} .htbuilder-pagination ul li span.current',
                        ]
                    );

                    $this->add_responsive_control(
                        'post_pagination_hover_border_radius',
                        [
                            'label' => __( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htbuilder-pagination ul li:hover a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                                '{{WRAPPER}} .htbuilder-pagination ul li span.current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render( $instance = [] ) {

        $settings           = $this->get_settings_for_display();
        $custom_order_ck    = $this->get_settings_for_display('post_custom_order');
        $orderby            = $this->get_settings_for_display('orderby');
        $order              = $this->get_settings_for_display('order');


        $search_query = [];
        $search_query['orderby'] = $orderby;
        $search_query['order'] = $order;

        // Search Page Arg
        if( is_search() ){
            global $query_string;
            wp_parse_str( $query_string, $search_query );
            $blog_post = new \WP_Query( $search_query );
        }
        // Other Page Arg
        else{
            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
            $args = array(
                'post_type'             => 'post',
                'post_status'           => 'publish',
                'ignore_sticky_posts'   => 1,
                'paged'                 => $paged, 
            );

            if( $custom_order_ck == 'yes' ){
                $args['orderby'] = $orderby;
                $args['order'] = $order;
            }

            if( is_category() ){
                $termobj = get_queried_object();
                $field_name = 'term_id';
                // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- intentional: this is the 'Archive Posts' (bl-post-archive) widget's core behavior — it must filter posts by the current category archive term (get_queried_object()) to mirror the native WordPress archive template it's placed on.
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'category',
                        'terms' => $termobj->term_id,
                        'field' => $field_name,
                        'include_children' => false
                    )
                );
            }elseif( is_tag() ){
                $termobj = get_queried_object();
                $field_name = 'term_id';
                // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- intentional: this is the 'Archive Posts' (bl-post-archive) widget's core behavior — it must filter posts by the current tag archive term (get_queried_object()) to mirror the native WordPress archive template it's placed on.
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'post_tag',
                        'terms' => $termobj->term_id,
                        'field' => $field_name,
                        'include_children' => false
                    )
                );
            }elseif( is_author() ){
                $author = get_user_by( 'slug', get_query_var('author_name') );
                $current_user_name = $author->user_nicename;
                $args['author_name'] = $current_user_name;
            }

            $blog_post = new \WP_Query( $args );
        }

        if( $blog_post->have_posts() ):
            ?>
            <div class="htbuilder-post-area htbuilder-col-<?php echo esc_attr($settings['post_grid_column']); ?>">
                <?php
                    while( $blog_post->have_posts() ): $blog_post->the_post();
                        ?>
                            <div class="htbuilder-post-col htbuilder-layout-<?php echo esc_attr($settings['post_layout']);?>">

                                <div class="htbuilder-single-post">
                                    <?php if( has_post_thumbnail() ): ?>
                                        <div class="htbuilder-post-media">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php
                                                    if( $settings['imagesize_size'] == 'custom' ){
                                                        the_post_thumbnail( array( $settings['imagesize_custom_dimension']['width'], $settings['imagesize_custom_dimension']['height'] ) );
                                                    }else{
                                                        the_post_thumbnail( $settings['imagesize_size'] ); 
                                                    }
                                                ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <div class="htbuilder-post-info <?php if( !has_post_thumbnail() ){ echo 'htbuilder-noimg'; } ?>">

                                        <?php if( $settings['show_category'] == 'yes' ): ?>
                                            <div class="htbuilder-post-cat">
                                                <?php
                                                    $i=0;
                                                    foreach ( get_the_category() as $category ) {
                                                        $i++;
                                                        $term_link = get_term_link( $category );
                                                        ?>
                                                            <a href="<?php echo esc_url( $term_link ); ?>"><?php echo esc_html( $category->name );?></a>
                                                        <?php
                                                        if( $i == 2 ){ break; }
                                                    }
                                                ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if( $settings['show_title'] == 'yes' ): ?>
                                            <h3 class="htbuilder-post-title">
                                                <a href="<?php the_permalink(); ?>"><?php echo esc_html( wp_trim_words( get_the_title(), floatval( $settings['title_length'] ), '' ) ); ?></a>
                                            </h3>
                                        <?php endif; ?>

                                        <?php if( $settings['show_meta_info'] == 'yes' ): ?>
                                            <div class="htbuilder-post-meta-info">
                                                <?php the_time( esc_html__('M d, Y','ht-mega-for-elementor') );?>
                                                <span class="htbuilder-meta-separator"> -</span>
                                                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ); ?>" class="htauthor">
                                                    <?php the_author();?>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                        <div class="htbuilder-post-content">
                                            <p><?php echo wp_kses_post( wp_trim_words( get_the_content(), floatval( $settings['content_length'] ), '' ) ); ?></p>
                                        </div>

                                        <?php if( $settings['show_read_more'] == 'yes' ): ?>
                                            <a class="htbuilder-read-more-btn" href="<?php the_permalink(); ?>">
                                                <?php
                                                    if( !empty( $settings['read_more_btn_text'] ) ){
                                                        echo esc_html( $settings['read_more_btn_text'] );
                                                    }else{
                                                        echo esc_html__( 'Read more', 'ht-mega-for-elementor' );
                                                    }
                                                ?>
                                            </a>
                                        <?php endif; ?>

                                    </div>
                                </div>

                            </div>

                        <?php
                    endwhile;
                ?>
            </div>
            <?php
        endif;
        if( $blog_post->max_num_pages > 1 ){ htmega_custom_pagination( $blog_post->max_num_pages ); }
        wp_reset_postdata();

    }

    

}
