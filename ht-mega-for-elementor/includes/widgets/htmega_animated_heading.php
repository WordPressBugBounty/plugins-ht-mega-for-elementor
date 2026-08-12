<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_Animated_Heading extends Widget_Base {

    public function get_name() {
        return 'htmega-animatedheading-addons';
    }
    
    public function get_title() {
        return __( 'Animated Heading', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-animated-headline';
    }

    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_style_depends() {
        return [
            'animated-heading'
        ];
    }

    public function get_script_depends() {
        return [
            'animated-heading',
        ];
    }
    public function get_keywords() {
        return ['heading', 'title', 'animated headline', 'animated heading', 'dual color heading', 'htmega', 'ht mega', 'addons'];
    }

    public function get_help_url() {
        return 'https://wphtmega.com/docs/general-widgets/animated-heading-widget/';
    }
    protected function is_dynamic_content():bool {
		return false;
	}
    protected function register_controls() {

        $this->start_controls_section(
            'animatedheading_content',
            [
                'label' => __( 'Animated Heading', 'ht-mega-for-elementor' ),
            ]
        );

            $this->add_control(
                'layout_style',
                [
                    'label'   => __( 'Layout', 'ht-mega-for-elementor' ),
                    'type'    => 'htmega-preset-select',
                    'default' => '1',
                    'options' => [
                        '1' => __( 'Style One', 'ht-mega-for-elementor' ),
                        '2' => __( 'Style Two', 'ht-mega-for-elementor' ),
                        '3' => __( 'Style Three', 'ht-mega-for-elementor' ),
                        '4' => __( 'Style Four', 'ht-mega-for-elementor' ),
                        '5' => __( 'Style Five', 'ht-mega-for-elementor' ),
                        '6' => __( 'Style Six', 'ht-mega-for-elementor' ),
                        '7' => __( 'Style Seven', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'animation_type',
                [
                    'label'   => __( 'Animation Type', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'slide',
                    'options' => [
                        'type'          => __( 'Type', 'ht-mega-for-elementor' ),
                        'loading-bar'   => __( 'Loading bar', 'ht-mega-for-elementor' ),
                        'slide'         => __( 'Slide', 'ht-mega-for-elementor' ),
                        'clip'          => __( 'Clip', 'ht-mega-for-elementor' ),
                        'zoom'          => __( 'Zoom', 'ht-mega-for-elementor' ),
                        'scale'         => __( 'Scale', 'ht-mega-for-elementor' ),
                        'push'          => __( 'Push', 'ht-mega-for-elementor' ),
                        'rotate-1'      => __( 'Rotate Style One', 'ht-mega-for-elementor' ),
                        'rotate-2'      => __( 'Rotate Style Two', 'ht-mega-for-elementor' ),
                        'rotate-3'      => __( 'Rotate Style Three', 'ht-mega-for-elementor' ),
                    ],
                    'condition'=>[
                        'layout_style!' => '2',
                    ],
                ]
            );

            $this->add_control(
                'animated_before_text',
                [
                    'label' => __( 'Heading Before Text', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Honesty is the best policy', 'ht-mega-for-elementor' ),
                    'label_block' => true,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'animated_heading_text',
                [
                    'label'       => __( 'Animated Heading Text', 'ht-mega-for-elementor' ),
                    'type'        => Controls_Manager::TEXTAREA,
                    'default'     => __( "Purpose,policy,Company", 'ht-mega-for-elementor' ),
                    'condition'=>[
                        'layout_style!' => '2',
                    ],
                ]
            );

            $this->add_control(
                'visible_items',
                [
                    'label' => __( 'Visible Item Number', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'step' => 1,
                    'default' => 1,
                    'condition'=>[
                        'layout_style!' => '2',
                    ],
                ]
            );

            $this->add_control(
                'animated_after_text',
                [
                    'label' => __( 'Heading After Text', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'label_block' => true,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'animated_placeholder_text',
                [
                    'label' => __( 'Heading Placeholder Text', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'label_block' => true,
                    'separator' => 'before',
                ]
            );
            $this->add_responsive_control(
                'heading_align',
                [
                    'label'   => __( 'Alignment', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => [
                        'left'    => [
                            'title' => __( 'Left', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'ht-mega-for-elementor' ),
                            'icon'  => 'eicon-text-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-animated-heading, {{WRAPPER}} .cd-headline'   => 'text-align: {{VALUE}};',
                    ],
                    'separator' => 'before',
                    'render_type' => 'template',
                ]
            );
        $this->end_controls_section();

        // Before Style tab section
        $this->start_controls_section(
            'animated_heading_beforetext_style',
            [
                'label' => __( 'Before Text Style', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'animated_before_text!'=>'',
                ]
            ]
        );
            $this->add_control(
                'heading_before_text_color',
                [
                    'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   =>'',
                    'selectors' => [
                        '{{WRAPPER}} .htmega-animated-heading h4 span.beforetext' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'heading_before_text_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-animated-heading h4 span.beforetext',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'heading_before_text_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-animated-heading h4 span.beforetext',
                ]
            );

            $this->add_responsive_control(
                'heading_before_text_border_radius',
                [
                    'label' => __( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-animated-heading h4 span.beforetext' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'heading_before_text_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-animated-heading h4 span.beforetext',
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'heading_before_text_box_shadow',
                    'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-animated-heading h4 span.beforetext',
                ]
            );

            $this->add_responsive_control(
                'heading_before_text_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-animated-heading h4 span.beforetext' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'heading_placeholder_options_title',
                    [
                        'label' => esc_html__( 'Placeholder Text', 'ht-mega-for-elementor' ),
                        'type' => Controls_Manager::HEADING,
                        'separator' => 'before',
                    ]
                );

            $this->add_control(
                'heading_placeholder_text_color',
                [
                    'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   =>'',
                    'selectors' => [
                        '{{WRAPPER}} .htmega-animated-heading .cd-headline::before' => 'color: {{VALUE}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'heading_placeholder_text_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-animated-heading .cd-headline::before',
                    'separator' => 'before'
                ]
            );

            $this->add_responsive_control(
                'heading_placeholder_text_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-animated-heading .cd-headline::before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

        // After Style tab section
        $this->start_controls_section(
            'animated_heading_aftertext_style',
            [
                'label' => __( 'After Text Style', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'animated_after_text!'=>'',
                ]
            ]
        );
            $this->add_control(
                'heading_after_text_color',
                [
                    'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   =>'',
                    'selectors' => [
                        '{{WRAPPER}} .htmega-animated-heading h4 span.aftertext' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'heading_after_text_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-animated-heading h4 span.aftertext',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'heading_after_text_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-animated-heading h4 span.aftertext',
                ]
            );

            $this->add_responsive_control(
                'heading_after_text_border_radius',
                [
                    'label' => __( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-animated-heading h4 span.aftertext' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'heading_after_text_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-animated-heading h4 span.aftertext',
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'heading_after_text_box_shadow',
                    'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-animated-heading h4 span.aftertext',
                ]
            );

            $this->add_responsive_control(
                'heading_after_text_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-animated-heading h4 span.aftertext' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

        $this->end_controls_section();

        // Animated text Style tab section
        $this->start_controls_section(
            'animated_heading_text_style',
            [
                'label' => __( 'Animated Text Style', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'layout_style!'=>'2',
                ]
            ]
        );
            $this->add_control(
                'heading_animated_text_color',
                [
                    'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   =>'',
                    'selectors' => [
                        '{{WRAPPER}} .htmega-animated-heading .cd-words-wrapper b' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .cd-headline.loading-bar .cd-words-wrapper::after' =>  'background:{{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'heading_animated_text_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-animated-heading .cd-words-wrapper b',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'heading_animated_text_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-animated-heading .cd-words-wrapper b',
                ]
            );

            $this->add_responsive_control(
                'heading_animated_text_border_radius',
                [
                    'label' => __( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-animated-heading .cd-words-wrapper b' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'heading_animated_text_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-animated-heading .cd-words-wrapper b',
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'heading_animated_text_box_shadow',
                    'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-animated-heading .cd-words-wrapper b',
                ]
            );

            $this->add_responsive_control(
                'heading_animated_text_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-animated-heading .cd-words-wrapper b' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );
            
            $this->add_responsive_control(
                'heading_animated_after_clip',
                [
                    'label'     => __( 'Clip Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   =>'',
                    'condition'=>[
                        'animation_type'=>'clip',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cd-headline.clip .cd-words-wrapper::after' => 'background-color: {{VALUE}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'heading_animated_after_clip_width',
                [
                    'label' => esc_html__( 'Clip Width', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::NUMBER,
                    'placeholder' => '0',
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'default' => 2,
                    'condition'=>[
                        'animation_type'=>'clip',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cd-headline.clip .cd-words-wrapper::after' => 'width: {{VALUE}}px;',
                    ],
                ]
            );

        $this->end_controls_section();

    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        $rotateAmimationClass = ( $settings['animation_type'] == 'scale' || $settings['animation_type'] == 'rotate-2' || $settings['animation_type'] == 'rotate-3') ? 'letters':'';
        
        $this->add_render_attribute( 'heading_area_attr', 'class', 'htmega-animated-heading htmega-style-'. esc_attr( $settings['layout_style'] ) );

        if ( isset( $settings['heading_align'] ) && ! empty( $settings['heading_align'] ) ) {
            $this->add_render_attribute( 'heading_area_attr', 'class', 'htmega-animated-alignment-'. esc_attr( $settings['heading_align'] ) ); 
        }

        $this->add_render_attribute( 'heading_attr', 'class', 'cd-headline '. esc_attr( $rotateAmimationClass ) .' headline-placeholder '. esc_attr( $settings['animation_type'] ) );
        $animatedheading_text = explode(",", esc_html( $settings['animated_heading_text'] ) );
       
        ?>

            <div <?php echo $this->get_render_attribute_string( 'heading_area_attr' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> >
                <h4
                    <?php if($settings['animated_placeholder_text'] !== ''): ?>
                        data-pltext="<?php echo esc_attr( $settings['animated_placeholder_text'] ) ?>"
                    <?php endif ?>
                    <?php echo $this->get_render_attribute_string( 'heading_attr' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                    <?php
                        if( !empty( $settings['animated_before_text'] ) ){
                            echo '<span class="beforetext">'.esc_html( $settings['animated_before_text'] ).'</span>';
                        }

                        if( is_array( $animatedheading_text ) && count( $animatedheading_text ) > 0 ): ?>
                           
                           <span class="cd-words-wrapper">
                                <?php
                                    $i = 0; 
                                    foreach ( $animatedheading_text as $animatedheadintext ) {
                                        $i++;
                                        if( $i == $settings['visible_items'] ){
                                            echo '<b class="is-visible" >'.esc_html( $animatedheadintext ).'</b>';
                                        }else{
                                            echo '<b>'.esc_html( $animatedheadintext ).'</b>';
                                        }
                                    }
                                ?>
                            </span>
                    <?php endif;
                    
                        if( !empty( $settings['animated_after_text'] ) ){
                            echo '<span class="aftertext">'.esc_html( $settings['animated_after_text'] ).'</span>';
                        }
                    ?>
                </h4>
            </div>
        <?php
    }
}

