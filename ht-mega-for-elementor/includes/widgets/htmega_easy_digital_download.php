<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_Easy_Digital_Download extends Widget_Base {

    public function get_name() {
        return 'htmega-easydigitaldownload-addons';
    }
    
    public function get_title() {
        return __( 'Easy Digital Downloads', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-file-download';
    }

    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_keywords() {
        return [ 'easy downloads', 'download', 'easy digital downloads', 'widget','ht mega','htmega addons' ];
    }

    public function get_help_url() {
		return 'https://wphtmega.com/docs/3rd-party-plugin-widgets/easy-digital-downloads-widget/';
	}
    protected function register_controls() {
        if ( ! is_plugin_active('easy-digital-downloads/easy-digital-downloads.php') ) {
            $this->messing_parent_plg_notice();
        } else {
            $this->easy_digital_download_regster_fields();
        }
    }
    protected function messing_parent_plg_notice() {

        $this->start_controls_section(
            'messing_parent_plg_notice_section',
            [
                'label' => __( 'Easy Digital Download', 'ht-mega-for-elementor' ),
            ]
        );
            $this->add_control(
                'htmega_plugin_parent_missing_notice',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => sprintf(
                        /* translators: %1$s: Plugin name (Easy Digital Download) with an install/activate link, repeated twice in the sentence */
                        __( 'It appears that %1$s is not currently installed on your site. Kindly use the link below to install or activate %1$s. After completing the installation or activation, please refresh this page.', 'ht-mega-for-elementor' ),
                        '<a href="' . esc_url( admin_url( 'plugin-install.php?s=Easy%2520Digital%2520Download&tab=search&type=term' ) ) . '" target="_blank" rel="noopener">Easy Digital Download</a>'
                    ),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
                ]
            );
        

            $this->add_control(
                'parent_plugin_install',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<a href="'.esc_url( admin_url( 'plugin-install.php?s=Easy%2520Digital%2520Download&tab=search&type=term' ) ).'" target="_blank" rel="noopener">Click to install or activate Easy Digital Download</a>',
                ]
            );
        $this->end_controls_section();

    }
    protected function easy_digital_download_regster_fields() {

        $this->start_controls_section(
            'easydigitaldownload_content',
            [
                'label' => __( 'Easy Digital Downloads', 'ht-mega-for-elementor' ),
            ]
        );

            $this->add_responsive_control(
                'columns',
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
                    'selectors' => [
                        '{{WRAPPER}} .edd_downloads_list'   => 'grid-template-columns: repeat({{VALUE}},1fr);',
                    ],
                ]
            );

            $this->add_control(
                'number',
                [
                    'label'   => __( 'Number of Item', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::NUMBER,
                    'default' => '4',
                ]
            );

            $this->add_control(
                'easydigitaldownload_thumbnail_show',
                [
                    'label'        => __( 'Show Thumbnail', 'ht-mega-for-elementor' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default'      => 'yes',
                ]
            );

            $this->add_control(
                'easydigitaldownload_excerpt_show',
                [
                    'label'        => __( 'Show Content', 'ht-mega-for-elementor' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default'      => 'yes',
                ]
            );

            $this->add_control(
                'easydigitaldownload_price_show',
                [
                    'label'        => __( 'Show Price', 'ht-mega-for-elementor' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default'      => 'yes',
                ]
            );

            $this->add_control(
                'easydigitaldownload_buy_button',
                [
                    'label'        => __( 'Show Buy Button', 'ht-mega-for-elementor' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default'      => 'yes',
                ]
            );

            $this->add_control(
                'easydigitaldownload_pagination_show',
                [
                    'label'        => __( 'Show Pagination', 'ht-mega-for-elementor' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default'      => 'yes',
                ]
            );
            
        $this->end_controls_section();

        // Content Options
        $this->start_controls_section(
            'section_options',
            [
                'label' => __( 'Options', 'ht-mega-for-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

            $this->add_control(
                'source',
                [
                    'label'   => _x( 'Source', 'Posts Query Control', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        ''          => __( 'Show All', 'ht-mega-for-elementor' ),
                        'by_id'     => __( 'Manual Selection', 'ht-mega-for-elementor' ),
                        'by_parent' => __( 'By Parent', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $categories = get_terms( 'download_category' );
            $options = array();
            foreach ( $categories as $category ) {
                $options[ $category->term_id ] = $category->name;
            }

            $this->add_control(
                'categories',
                [
                    'label'       => __( 'Categories', 'ht-mega-for-elementor' ),
                    'type'        => Controls_Manager::SELECT2,
                    'options'     => $options,
                    'default'     => [],
                    'label_block' => true,
                    'multiple'    => true,
                    'condition'   => [
                        'source' => 'by_id',
                    ],
                ]
            );

            $parent_options = array( '0' => __( 'Only Top Level', 'ht-mega-for-elementor' ) ) + $options;
            $this->add_control(
                'parent',
                [
                    'label'     => __( 'Parent', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::SELECT,
                    'default'   => '0',
                    'options'   => $parent_options,
                    'condition' => [
                        'source' => 'by_parent',
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
                        'asc'  => __( 'ASC', 'ht-mega-for-elementor' ),
                        'desc' => __( 'DESC', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

        $this->end_controls_section();

        // Single Item section
        $this->start_controls_section(
            'single_item_style_section',
            [
                'label' => __( 'Single Item', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
                'single_item_gap',
                [
                    'label'   => esc_html__( 'Item Gap', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => 15,
                    ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 200,
                        ],
                    ],
                    // 'selectors' => [
                    //     '{{WRAPPER}} .edd_downloads_list' => 'margin: -{{SIZE}}px -{{SIZE}}px 0',
                    //     '(desktop){{WRAPPER}} .edd_downloads_list .edd_download' => 'width: calc( 100% / {{columns.SIZE}} ); border: {{SIZE}}px solid transparent',
                    //     '(tablet){{WRAPPER}} .edd_downloads_list .edd_download'  => 'width: calc( 100% / 2 ); border: {{SIZE}}px solid transparent',
                    //     '(mobile){{WRAPPER}} .edd_downloads_list .edd_download'  => 'width: calc( 100% / 1 ); border: {{SIZE}}px solid transparent',
                    //     '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner'        => 'margin: 0;',
                    // ],
                    'selectors' => [
                        '{{WRAPPER}} .edd_downloads_list' => 'margin: -{{SIZE}}px -{{SIZE}}px 0',
                        '{{WRAPPER}} .edd_downloads_list .edd_download' => 'border: {{SIZE}}px solid transparent',
                        '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner'        => 'margin: 0;',
                    ],
                    'frontend_available' => true,
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'single_item_background',
                    'label' => __( 'Item Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner',
                ]
            );

            $this->add_responsive_control(
                'single_item_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'      => 'single_item_border',
                    'label'     => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                    'selector'  => '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner',
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'single_item_border_radius',
                [
                    'label'      => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors'  => [
                        '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'    => 'single_item_box_shadow',
                    // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_exclude -- false positive: this is Group_Control_Box_Shadow's 'exclude' param removing the box_shadow_position sub-control from the Elementor Style panel, not a WP_Query exclude arg.
                    'exclude' => [
                        'box_shadow_position',
                    ],
                    'selector' => '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner',
                ]
            );

            $this->add_control(
                'single_item_alignment',
                [
                    'label'   => esc_html__( 'Alignment', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
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
                        '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner' => 'text-align: {{VALUE}}',
                    ],
                ]
            );
            
        $this->end_controls_section();

        // Item Title section
        $this->start_controls_section(
            'single_item_title_style_section',
            [
                'label' => __( 'Title', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->start_controls_tabs('title_style_tabs');

                $this->start_controls_tab(
                    'title_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'title_color',
                        [
                            'label'     => esc_html__( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'default'   => '',
                            'selectors' => [
                                '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_download_title a' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name'     => 'title_typography',
                            'label'    => esc_html__( 'Typography', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_download_title a',
                        ]
                    );

                    $this->add_responsive_control(
                        'title_margin',
                        [
                            'label'      => esc_html__( 'Margin', 'ht-mega-for-elementor' ),
                            'type'       => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors'  => [
                                '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_download_title a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Title Hover Start
                $this->start_controls_tab(
                    'title_style_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'title_hover_color',
                        [
                            'label'     => esc_html__( 'Hover Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_download_title a:hover' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Description Style section
        $this->start_controls_section(
            'single_item_description_style_section',
            [
                'label' => __( 'Description', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'easydigitaldownload_excerpt_show'=>'yes',
                ]
            ]
        );

            $this->add_control(
                'single_item_description_color',
                [
                    'label'     => esc_html__( 'Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_download_excerpt' => 'color: {{VALUE}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'single_item_description_margin',
                [
                    'label'      => esc_html__( 'Margin', 'ht-mega-for-elementor' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors'  => [
                        '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_download_excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'single_item_description_typography',
                    'label'    => esc_html__( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_download_excerpt',
                ]
            );

        $this->end_controls_section();

        // Price Style section
        $this->start_controls_section(
            'single_item_price_style_section',
            [
                'label' => __( 'Price', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'easydigitaldownload_price_show'=>'yes',
                ]
            ]
        );

            $this->add_control(
                'single_item_price_color',
                [
                    'label'     => esc_html__( 'Price Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner span.edd_price, 
                         {{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_price_options span' => 'color: {{VALUE}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'single_item_price_typography',
                    'label'    => esc_html__( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner span.edd_price, 
                     {{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_price_options span',
                ]
            );

            $this->add_responsive_control(
                'single_item_price_margin',
                [
                    'label'      => esc_html__( 'Price Margin', 'ht-mega-for-elementor' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors'  => [
                        '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner span.edd_price, 
                         {{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_price_options span,{{WRAPPER}} .edd_download_purchase_form .edd_price_options li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};display:inline-block;',
                        '{{WRAPPER}} .edd_download_purchase_form .edd_price_options li span' => 'margin: 0!important;',
                    ],
                ]
            );

        $this->end_controls_section();

        // Button section
        $this->start_controls_section(
            'single_item_button_style_section',
            [
                'label' => __( 'Button', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'easydigitaldownload_buy_button'=>'yes',
                ]
            ]
        );
            
            $this->start_controls_tabs('single_item_button_style_tabs');

                $this->start_controls_tab(
                    'single_item_button_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'button_text_color',
                        [
                            'label'     => esc_html__( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'default'   => '',
                            'selectors' => [
                                '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_purchase_submit_wrapper > .button' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'button_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_purchase_submit_wrapper > .button',
                        ]
                    );


                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name'        => 'button_border',
                            'label'       => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                            'placeholder' => '1px',
                            'default'     => '1px',
                            'selector'    => '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_purchase_submit_wrapper > .button',
                            'separator'   => 'before',
                        ]
                    );

                    $this->add_control(
                        'button_border_radius',
                        [
                            'label'      => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type'       => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors'  => [
                                '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_purchase_submit_wrapper > .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'button_padding',
                        [
                            'label'      => esc_html__( 'Padding', 'ht-mega-for-elementor' ),
                            'type'       => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors'  => [
                                '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_purchase_submit_wrapper > .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );
                    $this->add_responsive_control(
                        'button_margin',
                        [
                            'label'      => esc_html__( 'Margin', 'ht-mega-for-elementor' ),
                            'type'       => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors'  => [
                                '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_purchase_submit_wrapper > .button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );
                $this->end_controls_tab();

                // Button Hover
                $this->start_controls_tab(
                    'single_item_button_style_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );

                    $this->add_control(
                        'button_text_hover_color',
                        [
                            'label'     => esc_html__( 'Color', 'ht-mega-for-elementor' ),
                            'type'      => Controls_Manager::COLOR,
                            'default'   => '',
                            'selectors' => [
                                '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_purchase_submit_wrapper > .button:hover' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'button_hover_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_purchase_submit_wrapper > .button:hover',
                        ]
                    );


                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name'        => 'button_hover_border',
                            'label'       => esc_html__( 'Border', 'ht-mega-for-elementor' ),
                            'placeholder' => '1px',
                            'default'     => '1px',
                            'selector'    => '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_purchase_submit_wrapper > .button:hover',
                        ]
                    );

                    $this->add_control(
                        'button_hover_border_radius',
                        [
                            'label'      => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type'       => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors'  => [
                                '{{WRAPPER}} .edd_downloads_list .edd_download .edd_download_inner .edd_purchase_submit_wrapper > .button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
        // Pagination section
        $this->start_controls_section(
            'pagination_style_section',
            [
                'label' => __( 'Pagination', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' =>[
                    'easydigitaldownload_pagination_show' => 'yes',
                ]
            ]
        );

            $this->add_control(
                'pagination_alignment',
                [
                    'label'   => esc_html__( 'Alignment', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
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
                        '{{WRAPPER}} .edd_pagination ' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'pagination_color',
                [
                    'label'     => esc_html__( 'Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} .page-numbers ' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'pagination_color_active_color',
                [
                    'label'     => esc_html__( 'Active Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} .page-numbers.current,{{WRAPPER}} .page-numbers:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'pagination_typography',
                    'label'    => esc_html__( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .page-numbers',
                ]
            );
            $this->add_responsive_control(
                'pagination__margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .page-numbers' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};display:inline-block',
                    ],
                ]
            );
        $this->end_controls_section();
    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();

        if ( ! is_plugin_active('easy-digital-downloads/easy-digital-downloads.php') ) {
            htmega_plugin_missing_alert( __('Easy Digital Download', 'ht-mega-for-elementor') );
            return;
        }
        $edd_attributes = [
            'number'     => absint( $settings['number'] ),
            'columns'    => absint( $settings['columns'] ),
            'hide_empty' => ( 'yes' === $settings['hide_empty'] ) ? 1 : 0,
            'orderby'    => sanitize_text_field( $settings['orderby'] ),
            'order'      => sanitize_text_field( $settings['order'] ),
            'thumbnails' => ('yes' === $settings['easydigitaldownload_thumbnail_show']) ? 'true' : 'false',
            'excerpt'    => ('yes' === $settings['easydigitaldownload_excerpt_show']) ? 'yes' : 'no',
            'price'      => ('yes' === $settings['easydigitaldownload_price_show']) ? 'yes' : 'no',
            'buy_button' => ('yes' === $settings['easydigitaldownload_buy_button']) ? 'yes' : 'no',
            'pagination' => ('yes' === $settings['easydigitaldownload_pagination_show']) ? 'true' : 'false',
        ];

        if ( 'by_id' === $settings['source'] ) {
            $sanitized_categories = array_map('sanitize_text_field', $settings['categories']);
            $edd_attributes['category'] = implode(',', $sanitized_categories);
        } elseif ( 'by_parent' === $settings['source'] ) {
            $edd_attributes['parent'] = sanitize_text_field( $settings['parent'] );
        }

        $this->add_render_attribute( 'shortcode', $edd_attributes );

        echo do_shortcode( sprintf( '[edd_downloads %s]', $this->get_render_attribute_string( 'shortcode' ) ) );

    }

}