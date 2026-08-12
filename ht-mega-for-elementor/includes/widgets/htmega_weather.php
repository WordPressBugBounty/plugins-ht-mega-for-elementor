<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_Weather extends Widget_Base {

    public function get_name() {
        return 'htmega-weather-addons';
    }
    
    public function get_title() {
        return __( 'Weather', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-cloud-check';
    }

    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_style_depends(){
        return [
            'regular-weather-icon'
        ];
    }
    public function get_keywords() {
        return ['htmega', 'ht mega', 'weather', 'geolocation', 'forecast', 'addons','widget'];
    }

    public function get_help_url() {
        return 'https://wphtmega.com/docs/general-widgets/weather-widget/';
    }
    protected function register_controls() {

        $this->start_controls_section(
            'weather_content',
            [
                'label' => __( 'Weather', 'ht-mega-for-elementor' ),
            ]
        );

            $this->add_control(
                'overridetitle',
                [
                    'label'   => __( 'Override Title', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => '',
                ]
            );

            $this->add_control(
                'units',
                [
                    'label'   => __( 'Units', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'C',
                    'options' => [
                        'F'   => __( 'F', 'ht-mega-for-elementor' ),
                        'C'   => __( 'C', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'layout',
                [
                    'label'   => __( 'Style', 'ht-mega-for-elementor' ),
                    'type'    => 'htmega-preset-select',
                    'default' => 'layout-1',
                    'options' => [
                        'layout-1'  => __( 'Style One', 'ht-mega-for-elementor' ),
                        'layout-2'  => __( 'Style Two', 'ht-mega-for-elementor' ),
                        'layout-3'  => __( 'Style Three', 'ht-mega-for-elementor' ),
                        'layout-4'  => __( 'Style Four', 'ht-mega-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'forecast',
                [
                    'label'   => __( 'Forecast', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => '4',
                    'options' => [
                        '3' => __( '3 Days', 'ht-mega-for-elementor' ),
                        '4' => __( '4 Days', 'ht-mega-for-elementor' ),
                        '5' => __( '5 Days', 'ht-mega-for-elementor' ),
                        '6' => __( '6 Days', 'ht-mega-for-elementor' ),
                    ],
                    'conditions'=>[
                        'relation' => 'or',
                        'terms' => [
                            [
                                'name' => 'layout',
                                'operator' => '==',
                                'value' => 'layout-1'
                            ],
                            [
                                'name' => 'layout',
                                'operator' => '==',
                                'value' => 'layout-2'
                            ],
                            [
                                'name' => 'layout',
                                'operator' => '==',
                                'value' => 'layout-4'
                            ],
                        ]
                    ],
                ]
            );

            $this->add_control(
                'hidecurrentstate',
                [
                    'label'   => __( 'Hide Current Status', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'conditions'=>[
                        'relation' => 'or',
                        'terms' => [
                            [
                                'name' => 'layout',
                                'operator' => '==',
                                'value' => 'layout-1'
                            ],
                            [
                                'name' => 'layout',
                                'operator' => '==',
                                'value' => 'layout-4'
                            ]
                        ]
                    ],
                ]
            );

            $this->add_control(
                'hidesunstate',
                [
                    'label'   => __( 'Hide Sun Status', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'condition'=>[
                        'layout' => 'layout-1'
                    ],
                ]
            );

            $this->add_control(
                'hide_forcast',
                [
                    'label'   => __( 'Hide Forecast', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'conditions'=>[
                        'relation' => 'or',
                        'terms' => [
                            [
                                'name' => 'layout',
                                'operator' => '==',
                                'value' => 'layout-1'
                            ],
                            [
                                'name' => 'layout',
                                'operator' => '==',
                                'value' => 'layout-4'
                            ]
                        ]
                    ],
                ]
            );

            $this->add_control(
                'custom_giolocation',
                [
                    'label'   => __( 'Custom Geolocation', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SWITCHER,
                    'default' => 'no',
                ]
            );

            $this->add_control(
                'custom_lat',
                [
                    'label'   => __( 'Latitude', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => '',
                    'condition'=>[
                        'custom_giolocation' => 'yes'
                    ],
                ]
            );

            $this->add_control(
                'custom_long',
                [
                    'label'   => __( 'Longitude', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::TEXT,
                    'default' => '',
                    'condition'=>[
                        'custom_giolocation' => 'yes'
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'custom_bg_color',
                    'label' => __( 'Custom Background Color', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htm-weather-wraper,{{WRAPPER}} .htm-weather-wraper.layout-4',
                ]
            );

            $this->add_control(
                'custom_bg_overlay',
                [
                    'label' => __( 'Background Overlay', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'condition'=>[
                        'custom_bg_color_background' => 'classic'
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .htm-weather-wraper:after' => 'background: {{VALUE}}'
                    ],
                ]
            );

            $this->add_control(
                'text_color',
                [
                    'label' => __( 'Text Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .htm-weather-wraper' => 'color: {{VALUE}}',
                    ],
                ]
            );
            
        $this->end_controls_section();

        
        // Title Style
        $this->start_controls_section(
            'weather_title_style_section',
            [
                'label' => __( 'Title', 'ht-mega-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'weather_title_color',
                [
                    'label'     => __( 'Color', 'ht-mega-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '#fff',
                    'selectors' => [
                        '{{WRAPPER}} .htm-weather-wraper h3' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'     => 'weather_title_typography',
                    'selector' => '{{WRAPPER}} .htm-weather-wraper h3',
                ]
            );

            $this->add_responsive_control(
                'weather_title_padding',
                [
                    'label'      => __( 'Padding', 'ht-mega-for-elementor' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .htm-weather-wraper h3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'weather_title_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htm-weather-wraper h3',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'weather_title_background',
                    'label' => __( 'Background', 'ht-mega-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .htm-weather-wraper h3',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'     => 'weather_title_shadow',
                    'label'     => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htm-weather-wraper h3',
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'weather_forcast_style_section',
            [
                'label' => __( 'Forcast', 'ht-mega-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'weather_forcast_border',
                'label' => __( 'Border', 'ht-mega-for-elementor' ),
                'selector' => '{{WRAPPER}} .htm-weather-wraper .htm-weather-forcast',
            ]
        );

        $this->add_responsive_control(
            'weather_forcast_padding',
            [
                'label'      => __( 'Padding', 'ht-mega-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .htm-weather-wraper .htm-weather-forcast' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    private function add_weather_rosource(){
        require_once HTMEGA_ADDONS_PL_PATH.'includes/weather-resource/weather-resource.php';
        require_once HTMEGA_ADDONS_PL_PATH.'includes/weather-resource/weather-map.php';
    }

    protected function render( $instance = [] ) {

        if(file_exists(HTMEGA_ADDONS_PL_PATH.'includes/weather-resource/weather-resource.php') && file_exists(HTMEGA_ADDONS_PL_PATH.'includes/weather-resource/weather-map.php')){
            $this->add_weather_rosource();
        }else{
            return;
        }

        $settings   = $this->get_settings_for_display();
        $api_key  = htmega_get_option( 'weather_map_api_key','htmega_general_tabs' );
        $hide_current_stats = $settings['hidecurrentstate'] == 'yes' ? 1 : 0;
        $hide_sun_stats = $settings['hidesunstate'] == 'yes' ? 1 : 0;
        $hide_forcast  = $settings['hide_forcast'] == 'yes' ? 1 : 0;
        $units = $settings['units'];
        $custom_lat = $settings['custom_lat'];
        $custom_long = $settings['custom_long'];

        if(empty($api_key) ) {
            ?>
                <div class="htm-api-notice">
                    <p><?php echo esc_html__('Please Insert Weather Map API Key from "HTMega Addons > Settings > Other options > Weather Map API Key".','ht-mega-for-elementor'); ?></p>
                </div>
            <?php
            return;
        }

        $weather = HtMega\Weather\WeatherMap::get_wather_data(array(
            'api_key' => sanitize_text_field( $api_key ),
            'language'=> 'en',
            'units'   => esc_attr( $units ),
            'forecast_days' => (int)$settings['forecast'], 
            'custom_lat' => sanitize_text_field( $custom_lat ),
            'custom_long' => sanitize_text_field( $custom_long )
        ));

        if( !is_array($weather) && !isset($weather['current']) ){
            echo $weather; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            return;
        }

        $current_temp_max = $weather['forecast'][0]['high'];
        $current_temp_min = $weather['forecast'][0]['low'];
        if(file_exists(HTMEGA_ADDONS_PL_PATH . 'includes/weather-resource/template/'.$settings['layout'].'.php')) {
            require_once( HTMEGA_ADDONS_PL_PATH . 'includes/weather-resource/template/' . sanitize_file_name( $settings['layout'] ) . '.php' );
        }

    }

}

