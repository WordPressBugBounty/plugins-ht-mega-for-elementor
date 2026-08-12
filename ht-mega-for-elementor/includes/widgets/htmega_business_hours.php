<?php
namespace Elementor;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_Business_Hours extends Widget_Base {

    public function get_name() {
        return 'htmega-businesshours-addons';
    }
    
    public function get_title() {
        return __( 'Business Hours', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-countdown';
    }

    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_keywords() {
        return ['business hours', 'business times', 'business open hours', 'htmega', 'ht mega', 'addons'];
    }

    public function get_help_url() {
        return 'https://wphtmega.com/docs/creative-widgets/business-hours-widget/';
    }
    protected function is_dynamic_content():bool {
		return false;
	}
    protected function register_controls() {

        $this->start_controls_section(
            'businesshours_content',
            [
                'label' => __( 'Business Hours', 'ht-mega-for-elementor' ),
            ]
        );

            $this->add_control(
                'business_hours_layout',
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
                    'separator'=>'after',
                ]
            );

            $this->add_control(
                'business_hour_switcher',
                [
                    'label' => __( 'Business Hour Title', 'ht-mega-for-elementor' ),
                    'type'  => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                ]
            );

            $this->add_control(
                'business_hour_title',
                [
                    'label' => __( 'Title', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'default'=>__('Business Hours​','ht-mega-for-elementor'),
                    'condition' => [
                        'business_hour_switcher' =>'yes',
                    ],
                ]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'business_day',
                [
                    'label'   => __( 'Day', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => __( 'Saturday', 'ht-mega-for-elementor' ),
                ]
            );

            $repeater->add_control(
                'business_time',
                [
                    'label'   => __( 'Time', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::TEXTAREA,
                    'default' => __( '9:00 AM - 6:00 PM', 'ht-mega-for-elementor' ),
                ]
            );

            $repeater->add_control(
                'highlight_this_day',
                [
                    'label'        => esc_html__( 'Hight Light this day', 'ht-mega-for-elementor' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default'      => 'no',
                    'separator'    => 'before',
                ]
            );

            $repeater->add_control(
                'single_business_day_color',
                [
                    'label'     => __( 'Day Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#fa2d2d',
                    'selectors' => [
                        '{{WRAPPER}} .htmega-single-hrs{{CURRENT_ITEM}}.htmega-single-hrs.closed-day span.day' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'highlight_this_day' => 'yes',
                    ],
                    'separator' => 'before',
                ]
            );

            $repeater->add_control(
                'single_business_time_color',
                [
                    'label'     => __( 'Time Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#fa2d2d',
                    'selectors' => [
                        '{{WRAPPER}} .htmega-single-hrs{{CURRENT_ITEM}}.htmega-single-hrs.closed-day span.time' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'highlight_this_day' => 'yes',
                    ],
                    'separator' => 'before',
                ]
            );

            $repeater->add_control(
                'single_business_background_color',
                [
                    'label'     => __( 'Background Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-single-hrs{{CURRENT_ITEM}}.htmega-single-hrs.closed-day' => 'background-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'highlight_this_day' => 'yes',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'business_openday_list',
                [
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => $repeater->get_controls(),
                    'default' => [
                        [
                            'business_day' => __( 'Saturday', 'ht-mega-for-elementor' ),
                            'business_time' => __( '9:00 AM to 6:00 PM','ht-mega-for-elementor' ),
                        ],

                        [
                            'business_day' => __( 'Sunday', 'ht-mega-for-elementor' ),
                            'business_time' => __( 'Close','ht-mega-for-elementor' ),
                            'highlight_this_day' => __( 'yes','ht-mega-for-elementor' ),
                        ],

                        [
                            'business_day' => __( 'Monday', 'ht-mega-for-elementor' ),
                            'business_time' => __( '9:00 AM to 6:00 PM','ht-mega-for-elementor' ),
                        ],

                        [
                            'business_day' => __( 'Tues Day', 'ht-mega-for-elementor' ),
                            'business_time' => __( '9:00 AM to 6:00 PM','ht-mega-for-elementor' ),
                        ],

                        [
                            'business_day' => __( 'Wednesday', 'ht-mega-for-elementor' ),
                            'business_time' => __( '9:00 AM to 6:00 PM','ht-mega-for-elementor' ),
                        ],

                        [
                            'business_day' => __( 'Thursday', 'ht-mega-for-elementor' ),
                            'business_time' => __( '9:00 AM to 6:00 PM','ht-mega-for-elementor' ),
                        ],

                        [
                            'business_day' => __( 'Friday', 'ht-mega-for-elementor' ),
                            'business_time' => __( '9:00 AM to 6:30 PM','ht-mega-for-elementor' ),
                        ]
                    ],
                    'title_field' => '{{{ business_day }}}',
                ]
            );
            
        $this->end_controls_section();


        // Style Area section
        $this->start_controls_section(
            'business_item_area_style_section',
            [
                'label' => __( 'Item Area', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'business_item_area_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-business-hours .business-hrs-inner',
                    'condition' => [
                        'business_hours_layout!' =>'5',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'business_item_areaaaa_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'gradient', ],
                    'selector' => '{{WRAPPER}} .htmega-business-horurs-5 .business-hrs-inner::before',
                    'condition' => [
                        'business_hours_layout' =>'5',
                    ],
                ]
            );

            $this->add_responsive_control(
                'business_item_area_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-business-hours .business-hrs-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'business_item_area_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-business-hours .business-hrs-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'after',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'business_item_area_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-business-hours .business-hrs-inner',
                ]
            );

            $this->add_responsive_control(
                'business_item_area_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-business-hours .business-hrs-inner,{{WRAPPER}} .htmega-business-horurs-5 .business-hrs-inner::before' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'business_item_area_box_shadow',
                    'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-business-hours .business-hrs-inner,.htmega-business-horurs-3 .business-hrs-inner',
                ]
            );

        $this->end_controls_section();

        // Style Item section
        $this->start_controls_section(
            'business_item_style_section',
            [
                'label' => __( 'Item', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'business_item_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-business-hours .htmega-single-hrs',
                ]
            );

            $this->add_responsive_control(
                'business_item_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-business-hours .htmega-single-hrs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'business_item_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-business-hours .htmega-single-hrs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'after',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'business_item_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-business-hours .htmega-single-hrs',
                ]
            );

            $this->add_responsive_control(
                'business_item_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-business-hours .htmega-single-hrs' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'business_item_box_shadow',
                    'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-business-hours .htmega-single-hrs',
                ]
            );
            
        $this->end_controls_section();
        
        // Style Business title section
        $this->start_controls_section(
            'business_day_title_style_section',
            [
                'label' => __( 'Title', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'business_hour_switcher' =>'yes',
                ],
            ]
        );

            $this->add_responsive_control(
                'business_day_title_align',
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
                        '{{WRAPPER}} .business-hrs-inner h4.hour-title' => 'text-align: {{VALUE}};',
                    ],
                    'default' => 'center',
                    'separator' =>'before',
                ]
            );

            $this->add_control(
                'business_day_title_color',
                [
                    'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .business-hrs-inner h4.hour-title' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'business_day_title_typography',
                    'selector' => '{{WRAPPER}} .business-hrs-inner h4.hour-title',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'business_day_title_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .business-hrs-inner h4.hour-title',
                ]
            );

            $this->add_responsive_control(
                'business_day_title_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .business-hrs-inner h4.hour-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'business_day_title_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .business-hrs-inner h4.hour-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'business_day_title_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .business-hrs-inner h4.hour-title',
                ]
            );

            $this->add_responsive_control(
                'business_day_title_border_radius',
                [
                    'label' => __( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .business-hrs-inner h4.hour-title' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'business_day_title_box_shadow',
                    'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .business-hrs-inner h4.hour-title',
                    'separator' => 'before',
                ]
            );
            
        $this->end_controls_section();

        // Style Business day section
        $this->start_controls_section(
            'business_day_style_section',
            [
                'label' => __( 'Day', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'business_day_color',
                [
                    'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-business-hours .htmega-single-hrs span.day' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'business_day_typography',
                    'selector' => '{{WRAPPER}} .htmega-business-hours .htmega-single-hrs span.day',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'business_day_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-business-hours .htmega-single-hrs span.day',
                ]
            );
            
        $this->end_controls_section();

        // Style Business Time section
        $this->start_controls_section(
            'business_time_style_section',
            [
                'label' => __( 'Time', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'business_time_color',
                [
                    'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-business-hours .htmega-single-hrs span.time' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'business_time_typography',
                    'selector' => '{{WRAPPER}} .htmega-business-hours .htmega-single-hrs span.time',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'business_time_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-business-hours .htmega-single-hrs span.time',
                ]
            );
            
        $this->end_controls_section();

    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();

        $this->add_render_attribute( 'htmega_business_hours', 'class', 'htmega-business-hours htmega-business-horurs-' . esc_attr( $settings['business_hours_layout'] ) );
       
        ?>

        <div <?php echo $this->get_render_attribute_string( 'htmega_business_hours' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_render_attribute_string() is Elementor core, values added via add_render_attribute() were esc_attr()'d above ?>>
            <div class="business-hrs-inner">
                <?php
                    if( $settings['business_hour_switcher'] == 'yes' ){
                        echo '<h4 class="hour-title">'.esc_html( $settings['business_hour_title'] ).'</h4>';
                    }
                    foreach ( $settings['business_openday_list'] as $item ):
                ?>

                    <div class="htmega-single-hrs elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?> <?php if( $item['highlight_this_day'] == 'yes' ){ echo esc_attr( 'closed-day' ); }?>">
                        <?php
                            if( !empty( $item['business_day'] ) ){
                                echo '<span class="day">'.esc_html( $item['business_day'] ).'</span>';
                            }
                            if( !empty( $item['business_time'] ) ){
                                echo '<span class="time">'.esc_html( $item['business_time'] ).'</span>';
                            }
                        ?>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>

        <?php
    }
}