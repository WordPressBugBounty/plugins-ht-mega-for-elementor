<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class HTMegaBuilder_Admin_Settings {
    private $settings_api;
    function __construct() {

        $this->settings_api = new HTMega_Settings_API();
        add_action( 'admin_init', [ $this, 'admin_init' ] );
        add_action( 'wsa_form_bottom_htmegabuilder_templatebuilder_tabs', [ $this, 'popup_box' ] );
    }

    // Admin Initialize
    function admin_init() {
        add_filter( 'htmega_admin_fields_sections', [ $this, 'fields_section' ], 10, 1 );
        add_filter( 'htmega_admin_fields_sub_sections', [ $this, 'fields_subsection' ], 10, 1 );

        //initialize settings
        $this->settings_api->admin_init();
    }

    /**
     * Admin Fields Section Route
     *
     * @param [array] $sections
     * @return void
     */
    public function fields_section( $sections ){
        // Theme Builder moved to Elements sub-tab — no longer a main tab.
        return $sections;
    }

    public function fields_subsection( $subtabs ){

        if ( isset( $subtabs['elements']['elementor'] ) ) {
            $subtabs['elements']['elementor']['panels'][] = [
                'id'     => 'htmega_themebuilder_element_tabs',
                'title'  => __( 'Theme Builder Widgets List', 'ht-mega-for-elementor' ),
                'desc'   => __( 'Freely use these elements to create your site. You can enable which you are not using, and all associated assets will be disabled to improve your site loading speed.', 'ht-mega-for-elementor' ),
                'column' => 3,
            ];
        }

        return $subtabs;

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
                        $(".htmega_table_row.pro input[type='checkbox'],.htmegapro select").attr("disabled", true);
                    });

                } )( jQuery );
            </script>
        <?php
        echo ob_get_clean(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    // Admin Menu Page Render
    function plugin_page() {

        echo '<div class="wrap">';
            echo '<h2>'.esc_html__( 'HT Builder Settings','ht-mega-for-elementor' ).'</h2>';
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

new HTMegaBuilder_Admin_Settings();