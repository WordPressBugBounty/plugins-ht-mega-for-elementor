<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_GoogleMap extends Widget_Base {

    public function get_name() {
        return 'htmega-google-map-addons';
    }
    
    public function get_title() {
        return __( 'Google Map', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-google-maps';
    }

    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_script_depends() {
        return [
            'google-map-api',
            'mapmarker',
            'dompurify'
        ];
    }

    public function get_keywords() {
        return ['google map', 'map', 'google location', 'htmega', 'ht mega', 'addons','widget'];
    }

    public function get_help_url() {
        return 'https://wphtmega.com/docs/creative-widgets/google-map-widget/';
    }
    protected function register_controls() {

        $this->start_controls_section(
            'google_map_content',
            [
                'label' => __( 'Google Map', 'ht-mega-for-elementor' ),
            ]
        );
            
            $this->add_control(
                'zoom_control',
                [
                    'label' => __( 'Zoom Control', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $this->add_control(
                'htmega_map_default_zoom',
                [
                    'label' => __( 'Default Zoom', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => 5,
                    ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 24,
                        ],
                    ],
                    'condition' => [
                        'zoom_control' => 'yes',
                    ]
                ]
            );

            $this->add_responsive_control(
                'htmega_google_map_height',
                [
                    'label' => __( 'Map Height', 'ht-mega-for-elementor' ),
                    'type'  => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 1000,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 500,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-google-map'  => 'min-height: {{SIZE}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_control(
                'htmega_center_address',
                [
                    'label' => __( 'Center Address', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'placeholder' => __( 'Enter your center address.', 'ht-mega-for-elementor' ),
                    'default' => __( 'Bangladesh', 'ht-mega-for-elementor' ),
                ]
            );


            $this->add_control(
                'htmega_style_address',
                [
                    'label' => __( 'Map Style', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'placeholder' => __( 'Enter Map Style Json Code.', 'ht-mega-for-elementor' ),
                    'description'   => __( 'Go to <a href="https://snazzymaps.com/" target=_blank>Snazzy Maps</a> and Choose/Customize your Map Style. Click on your demo and copy JavaScript Style Array', 'ht-mega-for-elementor' )
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'google_map_marker',
            [
                'label' => __( 'Map Marker', 'ht-mega-for-elementor' ),
            ]
        );


            $repeater = new Repeater();

            $repeater->add_control(
                'marker_lat', 
                [
                    'label'       => __( 'Latitude', 'ht-mega-for-elementor' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '31.42866311735861',
                ]
            );
            $repeater->add_control(
                'marker_lng', 
                [
                    'label'       => __( 'Longitude', 'ht-mega-for-elementor' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => '-98.61328125',
                ]
            );
            
            $repeater->add_control(
                'marker_info_box',
                [
                    'label' => __( 'Marker Info Box ', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                    'separator' => 'before',
                ]
            );

            $repeater->add_control(
                'marker_title', 
                [
                'label'     => esc_html__( 'Title', 'ht-mega-for-elementor' ),
                'type'      => Controls_Manager::TEXTAREA,
                'default'   => __('Another Place','ht-mega-for-elementor'),
                ]
            );
            
            $repeater->add_control(
                'custom_marker', 
                [
                'label'       => esc_html__( 'Custom marker', 'ht-mega-for-elementor' ),
                'description' => esc_html__('Use max 32x32 px size.', 'ht-mega-for-elementor'),
                'type'        => Controls_Manager::MEDIA,
                ]
            );

             $repeater->add_control(
                'htmega_marker_address_heading',
                [
                    'label' => esc_html__( 'Info Address Style', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

             $repeater->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'htmega_marker_address_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .gm-style-iw .htmega-baloon-text{{CURRENT_ITEM}}',
                    'condition' => [
                        'marker_info_box' => 'yes',
                    ],
                    'separator' => 'before',
                ]
            );

             $repeater->add_control(
                'htmega_marker_address_color',
                [
                    'label'     => esc_html__( 'Font Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .gm-style-iw .htmega-baloon-text{{CURRENT_ITEM}}' => 'color: {{VALUE}}',
                    ],
                    'separator' => 'before',
                ]
            );

             $repeater->add_control(
                'htmega_marker_address_heading_span',
                [
                    'label' => esc_html__( 'Info Address Span Style', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

             $repeater->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'htmega_marker_address_span_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .gm-style-iw .htmega-baloon-text{{CURRENT_ITEM}} span',
                    'separator' => 'before',
                ]
            );

             $repeater->add_control(
                'htmega_marker_address_Span_color',
                [
                    'label'     => esc_html__( 'Font Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .gm-style-iw .htmega-baloon-text{{CURRENT_ITEM}} span' => 'color: {{VALUE}}',
                    ],
                    'separator' => 'before',
                ]
            ); 

            $this->add_control(
            'htmega_map_marker_list',
            [
                'label'     => __( 'Marker', 'ht-mega-for-elementor' ),
                'type'      => Controls_Manager::REPEATER,
                'fields'    => $repeater->get_controls(),
                'default' => [
                    [
                            'marker_info_box' => __('no','ht-mega-for-elementor'),
                            'marker_title' => __('This is <span>Dhaka</span>','ht-mega-for-elementor'),
                            'marker_lat'   => __('23.8103','ht-mega-for-elementor'),
                            'marker_lng'   => __('90.4125','ht-mega-for-elementor'),
                            'custom_marker'=> __('90.4125','ht-mega-for-elementor'),
                    ],
                ],
                'title_field' => '{{{ marker_title }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'google_map_fixed_address',
            [
                'label' => __( 'Map Fixed Address', 'ht-mega-for-elementor' ),
            ]
        );

            $this->add_control(
                'google_map_fixed_address_control',
                [
                    'label'   => __( 'Fixed Maps Address:', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                ]
            );

            $this->add_control(
                'htmega_fixed_address',
                [
                    'label' => __( 'Fixed Address', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'placeholder' => __( 'Enter your fixed address.', 'ht-mega-for-elementor' ),
                    'default' => '<span>ADDRESS</span><br>Iris Watson <br>P.O. Box 283 8562 Fusce Rd.<br>Frederick Nebraska 20620<br>(372) 587-2335',
                    'separator' => 'before',
                    'condition' => [
                        'google_map_fixed_address_control' => 'yes',
                    ]
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'google_map_info_address',
            [
                'label' => __( 'Maps Info Address', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'htmega_info_address_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .gm-style-iw',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'htmega_info_address_area_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .gm-style-iw',
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'htmega_info_address_area_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .gm-style-iw' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->add_responsive_control(
                'htmega_info_address_area_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .gm-style-iw' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'htmega_info_address_area_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .gm-style-iw' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'htmega_info_address_heading',
                [
                    'label' => esc_html__( 'Info Pointer', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'htmega_info_address_background_pointer_width',
                [
                    'label'   => __( 'Pointer Width', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 50,
                        ],
                    ],
                    'size_units' => ['px' ],
                    'selectors'  => [
                        '{{WRAPPER}} .gm-style .gm-style-iw-t::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'htmega_info_address_background_pointer',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'gradient' ],
                    'selector' => '{{WRAPPER}} .gm-style .gm-style-iw-t::after',
                ]
            );

            $this->add_control(
                'htmega_info_address_close_button',
                [
                    'label' => __( 'Info Button Close', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'separator' => 'before',
                ]
            );

        $this->end_controls_section();


        $this->start_controls_section(
            'google_map_fixed_address_style',
            [
                'label' => __( 'Maps Fixed Address', 'ht-mega-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' =>[
                    'google_map_fixed_address_control' => 'yes',
                ]
            ]
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'htmega_fixed_address_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-google-map-address-yes p',
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'htmega_fixed_address_color',
                [
                    'label'     => esc_html__( 'Font Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-google-map-address-yes' => 'color: {{VALUE}}',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'htmega_fixed_address_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htmega-google-map-address-yes',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'htmega_fixed_address_area_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-google-map-address-yes',
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'htmega_fixed_address_area_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-google-map-address-yes' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->add_responsive_control(
                'htmega_fixed_address_area_padding',
                [
                    'label' => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-google-map-address-yes' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'htmega_fixed_address_area_margin',
                [
                    'label' => __( 'Margin', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-google-map-address-yes' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'fixed_address_heading_span',
                [
                    'label' => esc_html__( 'Fixed Address Span Style', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'htmega_fixed_address_span_typography',
                    'label' => __( 'Typography', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-google-map-address-yes p span',
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'htmega_fixed_address_Span_color',
                [
                    'label'     => esc_html__( 'Font Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htmega-google-map-address-yes p span' => 'color: {{VALUE}}',
                    ],
                    'separator' => 'before',
                ]
            ); 

        $this->end_controls_section();


    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        $id         = $this->get_id();
        
        $map_options     = [];
        $marker_opts     = [];
        $all_markerslist = [];
        foreach ( $settings['htmega_map_marker_list'] as $marker_item ) {
            $marker_opts['latitude'] = ( $marker_item['marker_lat'] ) ? sanitize_text_field( $marker_item['marker_lat'] ) : '';
            $marker_opts['longitude'] = ( $marker_item['marker_lng'] ) ? sanitize_text_field( $marker_item['marker_lng'] ) : '';
            $marker_opts['baloon_text'] = ( $marker_item['marker_title'] ) ? "<div class='htmega-baloon-text elementor-repeater-item-" . esc_attr( $marker_item['_id'] ) ."'>".wp_kses_post( $marker_item['marker_title'] ) . "</div>" : '';
            $marker_opts['icon'] = ( $marker_item['custom_marker']['url'] ) ? esc_url( $marker_item['custom_marker']['url'] ) : '';
            $marker_opts['baloon_text_fixed'] = ( $marker_item['marker_info_box'] ) ?  esc_attr( $marker_item['marker_info_box'] ) : '';
            $all_markerslist[] = $marker_opts;
        };
        $map_options['zoom'] = !empty( $settings['htmega_map_default_zoom']['size'] ) ? absint( $settings['htmega_map_default_zoom']['size'] ): 5;
        $map_options['center'] = !empty( $settings['htmega_center_address'] ) ? esc_html( $settings['htmega_center_address'] ) : 'Bangladesh';

        $this->add_render_attribute( 'googlemaps_inilasije', 'class', 'htmega-google-map-inilasije' );
        $this->add_render_attribute( 'googlemaps_address_attr', 'class', 'htmega-google-map-address-' . esc_attr( $settings['google_map_fixed_address_control'] ) );

        $this->add_render_attribute( 'googlemaps_attr', 'class', 'htmega-google-map' );
        $this->add_render_attribute( 'googlemaps_attr', 'id', 'htmega-google-map-'.$id );
        $this->add_render_attribute( 'googlemaps_attr', 'data-mapmarkers', wp_json_encode( $all_markerslist ) );
        $this->add_render_attribute( 'googlemaps_attr', 'data-mapoptions', wp_json_encode( $map_options ) );
        $this->add_render_attribute( 'googlemaps_attr', 'data-mapstyle', esc_attr( $settings['htmega_style_address'] ) );

        ?>
            <div <?php echo $this->get_render_attribute_string('googlemaps_inilasije'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> >
                <div <?php echo $this->get_render_attribute_string('googlemaps_address_attr'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> >
                    <p><?php echo htmega_kses_desc( $settings['htmega_fixed_address'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- htmega_kses_desc() sanitizes via wp_kses(), see includes/helper-function.php ?></p>
                </div>
                <div <?php echo $this->get_render_attribute_string('googlemaps_attr'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> >&nbsp;</div>
            </div>

            <?php if($settings['htmega_info_address_close_button'] == 'yes'): ?>
                <style><?php echo '#htmega-google-map-' . sanitize_key( $id ) ?> .gm-style-iw .gm-ui-hover-effect{ display: none !important;}</style>
           <?php endif;

    }

}