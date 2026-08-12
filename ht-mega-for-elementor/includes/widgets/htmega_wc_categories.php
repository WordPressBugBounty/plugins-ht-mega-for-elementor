<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_WC_Categories extends Widget_Base {

    public function get_name() {
        return 'htmega-categories-addons';
    }
    
    public function get_title() {
        return __( 'WC : Categories', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-product-categories';
    }
    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_keywords() {
        return ['htmega', 'ht mega', 'woocommerce', 'product categories', 'category', 'button', 'addons','widget'];
    }

    public function get_help_url() {
        return 'https://wphtmega.com/docs/woocommerce-widgets/woocommerce-category-widget/';
    }
    protected function register_controls() {

        $this->start_controls_section(
            'categories_content',
            [
                'label' => __( 'Categories', 'ht-mega-for-elementor' ),
            ]
        );
            
            $this->add_control(
                'category_columns',
                [
                    'label'   => __( 'Columns', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                    ],
                    'default' => '4',
                ]
            );

            $this->add_control(
                'show_number_of_item',
                [
                    'label'   => __( 'Number of Category', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::NUMBER,
                    'default' => '4',
                ]
            );

        $this->end_controls_section();

        // Options tab
        $this->start_controls_section(
            'categories_options',
            [
                'label' => __( 'Options', 'ht-mega-for-elementor' ),
            ]
        );

            $this->add_control(
                'select_category_type',
                [
                    'label'   => __( 'Select Category Type', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        ''          => __( 'Show All', 'ht-mega-for-elementor' ),
                        'by_id'     => __( 'Manual Selection', 'ht-mega-for-elementor' ),
                        'by_parent' => __( 'By Parent', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $categories = get_terms( 'product_cat' );
            $options = array();
            foreach ( $categories as $category ) {
                $options[ $category->term_id ] = $category->name;
            }

            $this->add_control(
                'categories_ids',
                [
                    'label'       => __( 'Categories', 'ht-mega-for-elementor' ),
                    'type'        => Controls_Manager::SELECT2,
                    'options'     => $options,
                    'default'     => [],
                    'label_block' => true,
                    'multiple'    => true,
                    'condition'   => [
                        'select_category_type' => 'by_id',
                    ],
                ]
            );

            $parent_options = [ '0' => __( 'Only Top Level', 'ht-mega-for-elementor' ) ] + $options;
            $this->add_control(
                'parent',
                [
                    'label'     => __( 'Parent', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::SELECT,
                    'default'   => '0',
                    'options'   => $parent_options,
                    'condition' => [
                        'select_category_type' => 'by_parent',
                    ],
                ]
            );

            $this->add_control(
                'orderby',
                [
                    'label'   => __( 'Order by', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'name',
                    'options' => [
                        'name'        => __( 'Name', 'ht-mega-for-elementor' ),
                        'slug'        => __( 'Slug', 'ht-mega-for-elementor' ),
                        'description' => __( 'Description', 'ht-mega-for-elementor' ),
                        'count'       => __( 'Count', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'order',
                [
                    'label'   => __( 'Order', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'desc',
                    'options' => [
                        'asc'  => __( 'Ascending', 'ht-mega-for-elementor' ),
                        'desc' => __( 'Descending', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'hide_empty',
                [
                    'label'        => __( 'Hide Empty', 'ht-mega-for-elementor' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                ]
            );

        $this->end_controls_section();

        // Category area style tab section
        $this->start_controls_section(
            'category_area_style_section',
            [
                'label' => __( 'Category Area', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->start_controls_tabs('category_area_style_tabs');
                
                $this->start_controls_tab(
                    'category_area_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );
                    

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'category_area_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .woocommerce .product-category a',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'category_area_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .woocommerce .product-category a',
                        ]
                    );

                    $this->add_responsive_control(
                        'category_area_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce .product-category a' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'category_area_padding',
                        [
                            'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce .product-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' => 'before',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'category_area_box_shadow',
                            'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .woocommerce .product-category a',
                        ]
                    );

                $this->end_controls_tab();
                
                // Category area Hover
                $this->start_controls_tab(
                    'category_area_style_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'category_area_hover_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .woocommerce .product-category a:hover',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'category_area_hover_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .woocommerce .product-category a:hover',
                        ]
                    );

                    $this->add_responsive_control(
                        'category_area_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce .product-category a:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();
            
        $this->end_controls_section();

        // Title style section
        $this->start_controls_section(
            'category_title_style',
            [
                'label' => esc_html__( 'Title', 'ht-mega-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->start_controls_tabs( 'category_title_tabs_style' );

                $this->start_controls_tab(
                    'category_title_tab_normal',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name'     => 'category_title_typography',
                            'label'    => esc_html__( 'Typography', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .woocommerce .product-category .woocommerce-loop-category__title, {{WRAPPER}} .woocommerce .product-category .woocommerce-loop-category__title mark',
                        ]
                    );

                    $this->add_control(
                        'category_title_color',
                        [
                            'label'     => esc_html__( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce .product-category .woocommerce-loop-category__title' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .woocommerce .product-category .woocommerce-loop-category__title mark' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'category_title_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .woocommerce ul.products li.product .ast-shop-product-out-of-stock, .woocommerce ul.products li.product .woocommerce-loop-category__title, .woocommerce-page ul.products li.product .ast-shop-product-out-of-stock, .woocommerce-page ul.products li.product .woocommerce-loop-category__title',
                        ]
                    );


                    $this->add_responsive_control(
                        'category_title_margin',
                        [
                            'label'      => esc_html__( 'Margin', 'ht-mega-for-elementor' ),
                            'type'       => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors'  => [
                                '{{WRAPPER}} .woocommerce .product-category .woocommerce-loop-category__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'category_title_padding',
                        [
                            'label'      => esc_html__( 'Padding', 'ht-mega-for-elementor' ),
                            'type'       => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors'  => [
                                '{{WRAPPER}} .woocommerce .product-category .woocommerce-loop-category__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'category_title_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .woocommerce .product-category .woocommerce-loop-category__title',
                        ]
                    );

                    $this->add_responsive_control(
                        'category_title_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce .product-category .woocommerce-loop-category__title' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'category_title_align',
                        [
                            'label'   => esc_html__( 'Alignment', 'ht-mega-for-elementor' ),
                            'type'    => Controls_Manager::CHOOSE,
                            'default' => 'center',
                            'options' => [
                                'left'    => [
                                    'title' => esc_html__( 'Left', 'ht-mega-for-elementor' ),
                                    'icon'  => 'eicon-text-align-left',
                                ],
                                'center' => [
                                    'title' => esc_html__( 'Center', 'ht-mega-for-elementor' ),
                                    'icon'  => 'eicon-text-align-center',
                                ],
                                'right' => [
                                    'title' => esc_html__( 'Right', 'ht-mega-for-elementor' ),
                                    'icon'  => 'eicon-text-align-right',
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce .product-category .woocommerce-loop-category__title' => 'text-align: {{VALUE}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                $this->start_controls_tab(
                    'category_title_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'category_title_hover_color',
                        [
                            'label'     => esc_html__( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce .product-category a:hover .woocommerce-loop-category__title' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .woocommerce .product-category a:hover .woocommerce-loop-category__title mark' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'category_title_hover_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .woocommerce .product-category a:hover .woocommerce-loop-category__title, {{WRAPPER}} .woocommerce .product-category a:hover .woocommerce-loop-category__title mark',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'category_title_hover_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .woocommerce .product-category .woocommerce-loop-category__title:hover',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'menu_normal_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .linemenu-nav ul.htmega-mainmenu li a',
                        ]
                    );


                $this->end_controls_tab();
            
            $this->end_controls_tabs();

        $this->end_controls_section();

        // Image style section
        $this->start_controls_section(
            'category_image_style',
            [
                'label' => esc_html__( 'Image', 'ht-mega-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->start_controls_tabs( 'category_image_tabs_style' );

                $this->start_controls_tab(
                    'category_image_tab_normal',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_responsive_control(
                        'category_image_margin',
                        [
                            'label'      => esc_html__( 'Margin', 'ht-mega-for-elementor' ),
                            'type'       => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors'  => [
                                '{{WRAPPER}} .woocommerce .product-category a img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'category_image_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .woocommerce .product-category a img',
                        ]
                    );

                    $this->add_responsive_control(
                        'category_image_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce .product-category a img' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                $this->start_controls_tab(
                    'category_image_tab_hover',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );
                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'category_image_hover_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .woocommerce .product-category a:hover img',
                        ]
                    );

                    $this->add_responsive_control(
                        'category_image_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce .product-category a:hover img' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();

        $category_attributes = [
            'number'     => absint($settings['show_number_of_item'] ),
            'columns'    => absint( $settings['category_columns'] ),
            'hide_empty' => ( 'yes' === $settings['hide_empty'] ) ? true : false,
            'orderby'    => sanitize_text_field( $settings['orderby'] ),
            'order'      => sanitize_text_field( $settings['order'] ),
        ];

        if (  $settings['select_category_type'] === 'by_id' ) {
            $category_attributes['ids'] = implode( ',', $settings['categories_ids'] );
        } elseif ( 'by_parent' === $settings['select_category_type'] ) {
            $category_attributes['parent'] = sanitize_text_field(  $settings['parent'] );
        }

        $this->add_render_attribute( 'shortcode', $category_attributes );

        echo do_shortcode( sprintf( '[product_categories %s]', $this->get_render_attribute_string( 'shortcode' ) ) );

    }

}

