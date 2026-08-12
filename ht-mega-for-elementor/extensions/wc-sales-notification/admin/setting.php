<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class HTMegaWcsale_Admin_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new HTMega_Settings_API();
        add_action( 'admin_init', [ $this, 'admin_init' ] );
        add_action( 'admin_menu', [ $this, 'admin_menu' ], 224 );

        add_action( 'wsa_form_bottom_htmegawcsales_setting_tabs', [ $this, 'popup_box' ] );
    }

    // Admin Initialize
    function admin_init() {

        // //set the settings
        $this->settings_api->set_sections( $this->admin_get_settings_sections() );
        $this->settings_api->set_fields( $this->admin_fields_settings() );

        // //initialize settings
        $this->settings_api->admin_init();
    }

    // Plugins menu Register
    function admin_menu() {

        add_submenu_page(
            'htmega-addons', 
            esc_html__( 'Sales Notification', 'ht-mega-for-elementor' ),
            esc_html__( 'Sales Notification', 'ht-mega-for-elementor' ), 
            'manage_options', 
            'htmeganotification', 
            array ( $this, 'plugin_page' ) 
        );

    }

    // Options page Section register
    function admin_get_settings_sections() {
        $sections = array(

            array(
                'id'    => 'htmegawcsales_setting_tabs',
                'title' => esc_html__( 'Sale Notification Settings', 'ht-mega-for-elementor' )
            ),

        );
        return $sections;
    }

    // Options page field register
    protected function admin_fields_settings() {

        $settings_fields = array(
            
            'htmegawcsales_setting_tabs' => array(
                
                array(
                    'name'    => 'notification_content_typep',
                    'label'   => __( 'Notification Content Type', 'ht-mega-for-elementor' ),
                    'desc'    => __( 'Select Content Type <span>( Pro )</span>', 'ht-mega-for-elementor' ),
                    'type'    => 'radio',
                    'default' => 'actual',
                    'options' => array(
                        'actual' => __('Real','ht-mega-for-elementor'),
                        'fakes'  => __('Fakes','ht-mega-for-elementor'),
                    ),
                    'class'=>'htmegapro',
                ),

                array(
                    'name'    => 'notification_posp',
                    'label'   => __( 'Position', 'ht-mega-for-elementor' ),
                    'desc'    => __( 'Sale Notification Position on frontend.( Top Left, Top Right, Bottom Right option are pro features ) <span>( Pro )</span>', 'ht-mega-for-elementor' ),
                    'type'    => 'select',
                    'default' => 'bottomleft',
                    'options' => array(
                        'bottomleft'    =>__( 'Bottom Left','ht-mega-for-elementor' ),
                    ),
                    'class'=>'htmegapro',
                ),

                array(
                    'name'    => 'notification_layoutp',
                    'label'   => __( 'Image Position', 'ht-mega-for-elementor' ),
                    'desc'    => __( 'Notification Layout. <span>( Pro )</span>', 'ht-mega-for-elementor' ),
                    'type'    => 'select',
                    'default' => 'imageleft',
                    'options' => array(
                        'imageleft'       =>__( 'Image Left','ht-mega-for-elementor' ),
                    ),
                    'class'       => 'notification_real htmegapro'
                ),

                array(
                    'name'    => 'show_buyer_name',
                    'label'   => __( 'Show Buyer Name', 'ht-mega-for-elementor' ),
                    'desc'    => __( 'Display buyer first name in the notification.', 'ht-mega-for-elementor' ),
                    'type'    => 'checkbox',
                    'default' => 'off',
                ),

                array(
                    'name'    => 'show_city',
                    'label'   => __( 'Show City', 'ht-mega-for-elementor' ),
                    'desc'    => __( 'Display buyer city in the notification.', 'ht-mega-for-elementor' ),
                    'type'    => 'checkbox',
                    'default' => 'off',
                ),

                array(
                    'name'    => 'show_state',
                    'label'   => __( 'Show State', 'ht-mega-for-elementor' ),
                    'desc'    => __( 'Display buyer state in the notification.', 'ht-mega-for-elementor' ),
                    'type'    => 'checkbox',
                    'default' => 'off',
                ),

                array(
                    'name'    => 'show_country',
                    'label'   => __( 'Show Country', 'ht-mega-for-elementor' ),
                    'desc'    => __( 'Display buyer country in the notification.', 'ht-mega-for-elementor' ),
                    'type'    => 'checkbox',
                    'default' => 'off',
                ),

                array(
                    'name'              => 'notification_limit',
                    'label'             => __( 'Limit', 'ht-mega-for-elementor' ),
                    'desc'              => __( 'Order Limit for notification.', 'ht-mega-for-elementor' ),
                    'min'               => 1,
                    'max'               => 100,
                    'default'           => '5',
                    'step'              => '1',
                    'type'              => 'number',
                    'sanitize_callback' => 'number',
                    'class'       => 'notification_real',
                ),

                array(
                    'name'    => 'notification_loadduration',
                    'label'   => __( 'Loading Time', 'ht-mega-for-elementor' ),
                    'desc'    => __( 'Notification Loading duration.', 'ht-mega-for-elementor' ),
                    'type'    => 'select',
                    'default' => '3',
                    'options' => array(
                        '2'       =>__( '2 seconds','ht-mega-for-elementor' ),
                        '3'       =>__( '3 seconds','ht-mega-for-elementor' ),
                        '4'       =>__( '4 seconds','ht-mega-for-elementor' ),
                        '5'       =>__( '5 seconds','ht-mega-for-elementor' ),
                        '6'       =>__( '6 seconds','ht-mega-for-elementor' ),
                        '7'       =>__( '7 seconds','ht-mega-for-elementor' ),
                        '8'       =>__( '8 seconds','ht-mega-for-elementor' ),
                        '9'       =>__( '9 seconds','ht-mega-for-elementor' ),
                        '10'       =>__( '10 seconds','ht-mega-for-elementor' ),
                        '20'       =>__( '20 seconds','ht-mega-for-elementor' ),
                        '30'       =>__( '30 seconds','ht-mega-for-elementor' ),
                        '40'       =>__( '40 seconds','ht-mega-for-elementor' ),
                        '50'       =>__( '50 seconds','ht-mega-for-elementor' ),
                        '60'       =>__( '1 minute','ht-mega-for-elementor' ),
                        '90'       =>__( '1.5 minutes','ht-mega-for-elementor' ),
                        '120'       =>__( '2 minutes','ht-mega-for-elementor' ),
                    ),
                ),

                array(
                    'name'    => 'notification_time_intp',
                    'label'   => __( 'Time Interval', 'ht-mega-for-elementor' ),
                    'desc'    => __( 'Time between notifications. <span>( Pro )</span>', 'ht-mega-for-elementor' ),
                    'type'    => 'select',
                    'default' => '4',
                    'options' => array(
                        '4'       =>__( '4 seconds','ht-mega-for-elementor' ),
                    ),
                    'class' => 'htmegapro',
                ),

                array(
                    'name'    => 'notification_uptodatep',
                    'label'   => __( 'Order Upto', 'ht-mega-for-elementor' ),
                    'desc'    => __( 'Do not show purchases older than.( More Options are Pro features ) <span>( Pro )</span>', 'ht-mega-for-elementor' ),
                    'type'    => 'select',
                    'default' => '7',
                    'options' => array(
                        '7'   =>__( '1 week','ht-mega-for-elementor' ),
                    ),
                    'class'   => 'notification_real htmegapro',
                ),

                array(
                    'name'    => 'notification_inanimationp',
                    'label'   => __( 'Animation In', 'ht-mega-for-elementor' ),
                    'desc'    => __( 'Notification Enter Animation. <span>( Pro )</span>', 'ht-mega-for-elementor' ),
                    'type'    => 'select',
                    'default' => 'fadeInLeft',
                    'options' => array(
                        'fadeInLeft'  =>__( 'fadeInLeft','ht-mega-for-elementor' ),
                    ),
                    'class' => 'htmegapro',
                ),

                array(
                    'name'    => 'notification_outanimationp',
                    'label'   => __( 'Animation Out', 'ht-mega-for-elementor' ),
                    'desc'    => __( 'Notification Out Animation. <span>( Pro )</span>', 'ht-mega-for-elementor' ),
                    'type'    => 'select',
                    'default' => 'fadeOutRight',
                    'options' => array(
                        'fadeOutRight'  =>__( 'fadeOutRight','ht-mega-for-elementor' ),
                    ),
                    'class' => 'htmegapro',
                ),
                
                array(
                    'name'  => 'background_colorp',
                    'label' => __( 'Background Color', 'ht-mega-for-elementor' ),
                    'desc' => wp_kses_post( 'Notification Background Color. <span>( Pro )</span>', 'ht-mega-for-elementor' ),
                    'type' => 'color',
                    'class'=> 'notification_real htmegapro',
                ),

                array(
                    'name'  => 'heading_colorp',
                    'label' => __( 'Heading Color', 'ht-mega-for-elementor' ),
                    'desc' => wp_kses_post( 'Notification Heading Color. <span>( Pro )</span>', 'ht-mega-for-elementor' ),
                    'type' => 'color',
                    'class'       => 'notification_real htmegapro',
                ),

                array(
                    'name'  => 'content_colorp',
                    'label' => __( 'Content Color', 'ht-mega-for-elementor' ),
                    'desc' => wp_kses_post( 'Notification Content Color. <span>( Pro )</span>', 'ht-mega-for-elementor' ),
                    'type' => 'color',
                    'class'=> 'notification_real htmegapro',
                ),

                array(
                    'name'  => 'cross_colorp',
                    'label' => __( 'Cross Icon Color', 'ht-mega-for-elementor' ),
                    'desc' => wp_kses_post( 'Notification Cross Icon Color. <span>( Pro )</span>', 'ht-mega-for-elementor' ),
                    'type' => 'color',
                    'class'=> 'htmegapro',
                ),

            ),


        );
        
        return array_merge( $settings_fields );
    }

    // Pop up Box
    function popup_box(){
        ob_start();
        ?>
            <div id="htmega-dialog" title="<?php echo esc_attr( 'Go Premium' ); ?>" style="display: none;">
                <div class="htmega-content">
                    <span><i class="dashicons dashicons-warning"></i></span>
                    <p>
                        <?php
                            echo esc_html__('Purchase our','ht-mega-for-elementor').' <strong><a href="'.esc_url( 'https://wphtmega.com/pricing/' ).'" target="_blank" rel="nofollow">'.esc_html__( 'premium version', 'ht-mega-for-elementor' ).'</a></strong> '.esc_html__('to unlock these pro elements!','ht-mega-for-elementor');
                        ?>
                    </p>
                </div>
            </div>
            <script type="text/javascript">
                ( function( $ ) {
                    
                    $(function() {
                        $( '.htmega_table_row.pro,.htmegapro label' ).click(function() {
                            $( "#htmega-dialog" ).dialog({
                                modal: true,
                                minWidth: 500,
                                buttons: {
                                    Ok: function() {
                                      $( this ).dialog( "close" );
                                    }
                                }
                            });
                        });
                        $(".htmega_table_row.pro input[type='checkbox'],.htmegapro select,.htmegapro input[type='radio']").attr("disabled", true);
                    });

                } )( jQuery );
            </script>
        <?php
        echo ob_get_clean(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    // Admin Menu Page Render
    function plugin_page() {

        echo '<div class="wrap">';
            echo '<h2>'.esc_html__( 'WC Sales Notification Settings','ht-mega-for-elementor' ).'</h2>';
            $this->save_message();
            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();
        echo '</div>';

    }

    // Save Options Message
    function save_message() {
        if( isset($_GET['settings-updated']) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
            <div class="updated notice is-dismissible"> 
                <p><strong><?php esc_html_e('Successfully Settings Saved.', 'ht-mega-for-elementor') ?></strong></p>
            </div>
            <?php
        }
    }


}

new HTMegaWcsale_Admin_Settings();