<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_Bbpress extends Widget_Base {

    public function get_name() {
        return 'htmega-bbpress-addons';
    }
    
    public function get_title() {
        return __( 'Bbpress', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-form-horizontal';
    }
    
    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_keywords() {
        return [ 'bbpress', 'bbpress widget', 'forum', 'reply','htmega','htmega' ];
    }

    public function get_help_url() {
		return 'https://wphtmega.com/docs/3rd-party-plugin-widgets/bbpress-widget/';
	}
    
    protected function register_controls() {
        if ( ! is_plugin_active('bbpress/bbpress.php') ) {
            $this->messing_parent_plg_notice();

        } else {
            $this->bbpress_monitor_regster_fields();
        }

    }
    protected function bbpress_monitor_regster_fields() {
        $this->start_controls_section(
            'bbpress_content',
            [
                'label' => __( 'Bbpress', 'ht-mega-for-elementor' ),
            ]
        );

            $this->add_control(
                'bbpress_layout',
                [
                    'label'   => __( 'Layout', 'ht-mega-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'forum-index',
                    'options' => [
                        'forum-index'  => __('Forum Index', 'ht-mega-for-elementor'),
                        'forum-form'   => __('Forum Form', 'ht-mega-for-elementor'),
                        'single-forum' => __('Single Forum', 'ht-mega-for-elementor'),
                        'topic-index'  => __('Topic Index', 'ht-mega-for-elementor'),
                        'topic-form'   => __('Topic Form', 'ht-mega-for-elementor'),
                        'single-topic' => __('Single Topic', 'ht-mega-for-elementor'),
                        'reply-form'   => __('Reply Form', 'ht-mega-for-elementor'),
                        'single-reply' => __('Single Reply', 'ht-mega-for-elementor'),
                        'topic-tags'   => __('Topic Tags', 'ht-mega-for-elementor'),
                        'single-tag'   => __('Single Tag', 'ht-mega-for-elementor'),
                        'single-view'  => __('Single View', 'ht-mega-for-elementor'),
                        'stats'        => __('Stats', 'ht-mega-for-elementor'),
                    ],
                ]
            );

            $this->add_control(
                'bbpress_id',
                [
                    'label'       => __( 'ID', 'ht-mega-for-elementor' ),
                    'type'        => Controls_Manager::TEXT,
                    'condition'   => [
                        'bbpress_layout' => array( 'single-forum', 'single-topic', 'single-reply', 'single-tag', 'single-view' )
                    ],
                ]
            );
            
        $this->end_controls_section();
    }
    protected function messing_parent_plg_notice() {

        $this->start_controls_section(
            'messing_parent_plg_notice_section',
            [
                'label' => __( 'bbPress', 'ht-mega-for-elementor' ),
            ]
        );
            $this->add_control(
                'htmega_plugin_parent_missing_notice',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => sprintf(
                        /* translators: %1$s: Linked plugin name (bbPress), repeated twice in the sentence */
                        __( 'It appears that %1$s is not currently installed on your site. Kindly use the link below to install or activate %1$s. After completing the installation or activation, please refresh this page.', 'ht-mega-for-elementor' ),
                        '<a href="' . esc_url( admin_url( 'plugin-install.php?s=bbpress&tab=search&type=term' ) ) . '" target="_blank" rel="noopener">bbPress</a>'
                    ),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
                ]
            );
        

            $this->add_control(
                'parent_plugin_install',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<a href="'.esc_url( admin_url( 'plugin-install.php?s=bbpress&tab=search&type=term' ) ).'" target="_blank" rel="noopener">Click to install or activate bbPress</a>',
                ]
            );
        $this->end_controls_section();

    }
    protected function render( $instance = [] ) {
        
        if ( ! is_plugin_active('bbpress/bbpress.php') ) {
            htmega_plugin_missing_alert( __('bbPress', 'ht-mega-for-elementor') );
            return;
        }
        $settings   = $this->get_settings_for_display();

        $layout = array( 'single-forum', 'single-topic', 'single-reply', 'single-tag', 'single-view' );
        $bbpress_attributes = array();

        if ( isset( $settings['bbpress_id'] ) ) {
            $bbpress_attributes = array( ' id' => esc_attr( $settings['bbpress_id'] ) );
        } elseif ( $settings['bbpress_layout'] == 'topic-form' && isset( $settings['bbpress_id'] ) ) {
            $bbpress_attributes = array( ' forum_id' =>  esc_attr( $settings['bbpress_id'] ) );
        }
        $this->add_render_attribute( 'shortcode', $bbpress_attributes );

        echo do_shortcode( sprintf( '[bbp-'. esc_attr( $settings['bbpress_layout'] ) .'%s]', $this->get_render_attribute_string( 'shortcode' ) ));

    }

}

