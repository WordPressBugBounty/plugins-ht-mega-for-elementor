<?php
namespace Elementor;

// Elementor Classes
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_Tooltip extends Widget_Base {

    public function get_name() {
        return 'htmega-tooltip-addons';
    }
    
    public function get_title() {
        return __( 'Tooltip', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-alert';
    }

    public function get_categories() {
        return [ 'htmega-addons' ];
    }
    public function get_keywords() {
        return ['htmega', 'ht mega', 'tooltip', 'content', 'tooltips', 'addons', 'widget'];
    }

    public function get_help_url() {
        return 'https://wphtmega.com/docs/creative-widgets/tooltip-widget/';
    }
    protected function is_dynamic_content():bool {
		return false;
	}
    protected function register_controls() {

        $this->start_controls_section(
            'tooltip_button_content',
            [
                'label' => __( 'Tooltip', 'ht-mega-for-elementor' ),
            ]
        );
            $this->add_responsive_control(
                'tooltip_type',
                [
                    'label' => esc_html__( 'Button Type', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'label_block' => true,
                    'options' => [
                        'icon' => [
                            'title' => esc_html__( 'Icon', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-info-circle',
                        ],
                        'text' => [
                            'title' => esc_html__( 'Text', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-font',
                        ],
                        'image' => [
                            'title' => esc_html__( 'Image', 'ht-mega-for-elementor' ),
                            'icon' => 'eicon-image-bold',
                        ],
                    ],
                    'default' => 'text',
                ]
            );

            $this->add_control(
                'tooltip_button_txt',
                [
                    'label' => esc_html__( 'Text', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'label_block' => true,
                    'default' => esc_html__( 'Tooltip', 'ht-mega-for-elementor' ),
                    'condition' => [
                        'tooltip_type' => [ 'text' ]
                    ],
                    'dynamic' => [ 'active' => true ]
                ]
            );

            $this->add_control(
                'tooltip_button_icon',
                [
                    'label' => esc_html__( 'Icon', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value'=>'fas fa-home',
                        'library'=>'fa-solid',
                    ],
                    'condition' => [
                        'tooltip_type' => [ 'icon' ]
                    ]
                ]
            );

            $this->add_control(
                'tooltip_button_img',
                [
                    'label' => __('Image','ht-mega-for-elementor'),
                    'type'=>Controls_Manager::MEDIA,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'condition' => [
                        'tooltip_type' => [ 'image' ]
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'tooltip_button_imgsize',
                    'default' => 'large',
                    'separator' => 'none',
                    'condition' => [
                        'tooltip_type' => [ 'image' ]
                    ]
                ]
            );

            $this->add_control(
                'show_link',
                [
                    'label' => __( 'Show Link', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Hide', 'ht-mega-for-elementor' ),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $this->add_control(
                'button_link',
                [
                    'label' => __( 'Link', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::URL,
                    'placeholder' => __( 'https://your-link.com', 'ht-mega-for-elementor' ),
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                    'condition'=>[
                        'show_link'=>'yes',
                    ]
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'tooltip_options',
            [
                'label' => __( 'Tooltip Options', 'ht-mega-for-elementor' ),
            ]
        );
            $this->add_control(
                'tooltip_text',
                [
                    'label' => esc_html__( 'Tooltip Text', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'label_block' => true,
                    'default' => esc_html__( 'Tooltip content', 'ht-mega-for-elementor' ),
                    'dynamic' => [ 'active' => true ]
                ]
            );

            $this->add_control(
              'tooltip_dir',
                [
                    'label'         => esc_html__( 'Direction', 'ht-mega-for-elementor' ),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'right',
                    'label_block'   => false,
                    'options'       => [
                        'left'      => esc_html__( 'Left', 'ht-mega-for-elementor' ),
                        'right'     => esc_html__( 'Right', 'ht-mega-for-elementor' ),
                        'top'       => esc_html__( 'Top', 'ht-mega-for-elementor' ),
                        'bottom'    => esc_html__( 'Bottom', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'tooltip_space',
                [
                    'label' => __( 'Space With Button', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1200,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 10,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .bs-tooltip-auto[x-placement^=top]' => 'top: -{{SIZE}}{{UNIT}} !important;',
                        '{{WRAPPER}} .bs-tooltip-top' => 'top: -{{SIZE}}{{UNIT}} !important;',
                        '{{WRAPPER}} .bs-tooltip-auto[x-placement^=bottom]' => 'top: {{SIZE}}{{UNIT}} !important;',
                        '{{WRAPPER}} .bs-tooltip-bottom' => 'top: {{SIZE}}{{UNIT}} !important;',
                        '{{WRAPPER}} .bs-tooltip-auto[x-placement^=right]' => 'left: {{SIZE}}{{UNIT}} !important;',
                        '{{WRAPPER}} .bs-tooltip-right' => 'left: {{SIZE}}{{UNIT}} !important;',
                        '{{WRAPPER}} .bs-tooltip-auto[x-placement^=left]' => 'left: {{SIZE}}{{UNIT}} !important;',
                        '{{WRAPPER}} .bs-tooltip-left' => 'left: -{{SIZE}}{{UNIT}} !important;',
                    ],
                ]
            );

        $this->end_controls_section();

        // Style tab section
        $this->start_controls_section(
            'tooltip_style_section',
            [
                'label' => __( 'Button Box Style', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
                'tooltip_style_section_align',
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
                        '{{WRAPPER}} .htmega-tooltip' => 'text-align: {{VALUE}};',
                    ],
                    'default' => 'center',
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'tooltip_style_section_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'tooltip_style_section_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-tooltip' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );
            
        $this->end_controls_section();

        // Button Style tab section
        $this->start_controls_section(
            'tooltip_button_section',
            [
                'label' => __( 'Button', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->start_controls_tabs('button_style_tabs');

                $this->start_controls_tab(
                    'button_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'ht-mega-for-elementor' ),
                    ]
                );
                    $this->add_control(
                        'button_color',
                        [
                            'label' => __( 'Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .htmega-tooltip span' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-tooltip span a' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-tooltip span svg path' => 'fill: {{VALUE}};',
                                '{{WRAPPER}} .htmega-tooltip span a svg path' => 'fill: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'button_typography',
                            'selector' => '{{WRAPPER}} .htmega-tooltip span',
                            'condition'=>[
                                'tooltip_type'=>'text',
                            ]
                        ]
                    );

                    $this->add_control(
                        'button_icon_fontsize',
                        [
                            'label' => __( 'Icon Size', 'ht-mega-for-elementor' ),
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
                                'size' => 20,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-tooltip span i' => 'font-size: {{SIZE}}{{UNIT}};',
                                '{{WRAPPER}} .htmega-tooltip span svg' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                            'condition'=>[
                                'tooltip_type'=>'icon',
                                'tooltip_button_icon[value]!'=>'',
                            ]
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'button_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-tooltip span',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'button_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-tooltip span',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htmega-tooltip span' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'button_margin',
                        [
                            'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-tooltip span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_padding',
                        [
                            'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htmega-tooltip span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                $this->end_controls_tab(); // Normal tab end

                // Hover Tab start
                $this->start_controls_tab(
                    'button_style_hover_tab',
                    [
                        'label' => __( 'Hover', 'ht-mega-for-elementor' ),
                    ]
                );
                    $this->add_control(
                        'button_hover_color',
                        [
                            'label' => __( 'Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .htmega-tooltip span:hover' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .htmega-tooltip span:hover svg path' => 'fill: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'button_hover_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htmega-tooltip span:hover',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'button_hover_border',
                            'label' => __( 'Border', 'ht-mega-for-elementor' ),
                            'selector' => '{{WRAPPER}} .htmega-tooltip span:hover',
                        ]
                    );

                $this->end_controls_tab();// Hover tab end

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Button Style tab section
        $this->start_controls_section(
            'hover_tooltip_style_section',
            [
                'label' => __( 'Tooltip', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->start_controls_tabs('hover_popover_style_tabs');

                $this->start_controls_tab(
                    'hover_tooltip_content_tab',
                    [
                        'label' => __( 'Content', 'ht-mega-for-elementor' ),
                    ]
                );
                    $this->add_control(
                        'hover_tooltip_content_color',
                        [
                            'label' => __( 'Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .htb-tooltip-inner' => 'color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'hover_tooltip_content_typography',
                            'selector' => '{{WRAPPER}} .htb-tooltip-inner',
                        ]
                    );

                    $this->add_responsive_control(
                        'hover_tooltip_content_padding',
                        [
                            'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .htb-tooltip-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'hover_tooltip_content_background',
                            'label' => __( 'Background', 'ht-mega-for-elementor' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .htb-tooltip-inner',
                        ]
                    );

                    $this->add_responsive_control(
                        'hover_tooltip_content_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .htb-tooltip-inner' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px !important;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Arrow Tab End

                // Arrow Tab Start
                $this->start_controls_tab(
                    'hover_tooltip_arrow_tab',
                    [
                        'label' => __( 'Arrow', 'ht-mega-for-elementor' ),
                    ]
                );
                    $this->add_control(
                        'hover_tooltip_arrow_color',
                        [
                            'label' => __( 'Arrow Color', 'ht-mega-for-elementor' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '#404040',
                            'selectors' => [
                                '{{WRAPPER}} .bs-tooltip-auto[x-placement^=top] .htb-arrow::before' => 'border-top-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .bs-tooltip-top .htb-arrow::before' => 'border-top-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .bs-tooltip-auto[x-placement^=bottom] .htb-arrow::before' => 'border-bottom-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .bs-tooltip-bottom .htb-arrow::before' => 'border-bottom-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .bs-tooltip-auto[x-placement^=left] .htb-arrow::before' => 'border-left-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .bs-tooltip-left .htb-arrow::before' => 'border-left-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .bs-tooltip-auto[x-placement^=right] .htb-arrow::before' => 'border-right-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .bs-tooltip-right .htb-arrow::before' => 'border-right-color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        $id = $this->get_id();
        $this->add_render_attribute( 'htmega_tooltip_attr', 'class', 'htmega-tooltip htmega-tooltip-container-'.esc_attr( $id ) );

        ?>
            <?php
            // phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped -- All dynamic output in this block is already safe:
            // $this->get_render_attribute_string() is Elementor core (self-escaping); htmega_kses_title()/htmega_kses_desc() sanitize
            // via wp_kses() (see includes/helper-function.php); HTMega_Icon_manager::render_icon() delegates to Elementor core
            // Icons_Manager::render_icon() (self-escaping, see includes/class.htmega-icon-manager.php); Group_Control_Image_Size::
            // get_attachment_image_html() is Elementor core (self-escaping); $button_txt only ever holds one of those pre-sanitized
            // HTML fragments (or is wrapped in an <a> tag built from esc_url()/get_render_attribute_string()), so re-escaping it with
            // esc_html() would double-encode the markup and break icon/image rendering.
            ?>
            <div <?php echo $this->get_render_attribute_string( 'htmega_tooltip_attr' ); ?>>
                <?php

                    $button_txt = '';
                    if( isset( $settings['tooltip_button_txt'] ) ){
                        $button_txt = htmega_kses_title( $settings['tooltip_button_txt'] );
                    }
                    if( isset( $settings['tooltip_button_icon']['value'] ) ){
                        $button_txt = HTMega_Icon_manager::render_icon( $settings['tooltip_button_icon'], [ 'aria-hidden' => 'true' ] );
                    }
                    if( isset( $settings['tooltip_button_img']['url'] ) ){
                        $button_txt = Group_Control_Image_Size::get_attachment_image_html( $settings, 'tooltip_button_imgsize', 'tooltip_button_img' );
                    }

                    // Button Generate
                    if ( isset(  $settings['button_link']['url'] ) && ! empty( $settings['button_link']['url'] ) ) {
                        $this->add_render_attribute( 'url', 'href', esc_url( $settings['button_link']['url'] ) );

                        if ( $settings['button_link']['is_external'] ) {
                            $this->add_render_attribute( 'url', 'target', '_blank' );
                        }

                        if ( ! empty( $settings['button_link']['nofollow'] ) ) {
                            $this->add_render_attribute( 'url', 'rel', 'nofollow' );
                        }

                        $button_txt = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'url' ), $button_txt );
                    }

                    echo sprintf('<span data-toggle="tooltip" data-container=".htmega-tooltip-container-%4$s" data-placement="%1$s" title="%2$s">%3$s</span>', esc_attr( $settings['tooltip_dir'] ), htmega_kses_desc( htmlspecialchars( $settings['tooltip_text'] ) ), $button_txt, esc_attr( $id ) );
                ?>
            </div>
            <?php // phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped ?>

        <?php

    }

}

