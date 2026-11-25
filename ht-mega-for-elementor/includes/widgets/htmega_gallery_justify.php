<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_Gallery_Justify extends Widget_Base {

    public function get_name() {
        return 'htmega-galleryjustify-addons';
    }
    
    public function get_title() {
        return __( 'Gallery Justify', 'ht-mega-for-elementor' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-gallery-justified';
    }

    public function get_categories() {
        return [ 'htmega-addons' ];
    }

    public function get_style_depends() {
        return [
            'justify-gallery',
            'magnific-popup'
        ];
    }

    public function get_script_depends() {
        return [
            'justified-gallery',
            'magnific-popup',
            'imagesloaded'
        ];
    }

    public function get_keywords() {
        return [ 'image justify', 'justify gallery','image gallery','gallery justify','gallery images','htmega','ht mega' ];
    }

    public function get_help_url() {
		return 'https://wphtmega.com/docs/general-widgets/image-justify-widget/';
	}
    protected function is_dynamic_content():bool {
		return false;
	}
    protected function register_controls() {
        $this->start_controls_section(
            'gallery_content',
            [
                'label' => __( 'Gallery Justify', 'ht-mega-for-elementor' ),
            ]
        );

            $this->add_control(
                'gallery_images',
                [
                    'label' => __( 'Add Images', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::GALLERY,
                ]
            );

            $this->add_control(
                'row_height',
                [
                    'label' => __( 'Row Height', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 300,
                ]
            );

            $this->add_control(
                'space_margin',
                [
                    'label' => __( 'Space', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 20,
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'justify_image_area_border',
                    'label' => __( 'Border', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-justify-single-image',
                ]
            );

            $this->add_responsive_control(
                'justify_image_area_border_radius',
                [
                    'label' => __( 'Border Radius', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .htmega-justify-single-image' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'justify_image_box_shadow',
                    'label' => __( 'Box Shadow', 'ht-mega-for-elementor' ),
                    'selector' => '{{WRAPPER}} .htmega-justify-single-image',
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'popup_options',
                [
                    'label' => __( 'Popup options', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '2',
                    'options' => [
                        '1'   => __( 'Popup None', 'ht-mega-for-elementor' ),
                        '2'   => __( 'Default Popup', 'ht-mega-for-elementor' ),
                        '3'   => __( 'Gallery Popup ', 'ht-mega-for-elementor' ),
                    ],
                ]
            );
            $this->add_control(
                'gallery_title_on_off', 
                [
                    'label'         => __( 'Show Gallery Title', 'ht-mega-for-elementor' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'return_value'  => 'yes',
                    'default'       => 'no',
                    'condition'     => [
                        'popup_options' =>'3',
                    ]
                ]
            );
            $this->add_control(
                'gallery_counter_on_off', 
                [
                    'label'         => __( 'Show Image Counter', 'ht-mega-for-elementor' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'return_value'  => 'yes',
                    'default'       => 'no',
                    'condition'     => [
                        'popup_options' =>'3',
                    ]
                ]
            );
            $this->add_control(
                'title_color',
                [
                    'label' => __( 'Title Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '.htmega.mfp-title' => 'color: {{VALUE}};',
                    ],
                    'condition'     => [
                        'gallery_title_on_off' =>'yes',
                        'popup_options' =>'3',
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'selector' => '.htmega.mfp-title',
                    'condition'     => [
                        'gallery_title_on_off' =>'yes',
                        'popup_options' =>'3',
                    ]
                ]
            );
            $this->add_control(
                'counter_color',
                [
                    'label' => __( 'Counter Color', 'ht-mega-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '.htmega.mfp-counter' => 'color: {{VALUE}};',
                    ],
                    'condition'     => [
                        'gallery_counter_on_off' =>'yes',
                        'popup_options' =>'3',
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'counter_typography',
                    'selector' => '.htmega.mfp-counter',
                    'condition'     => [
                        'gallery_counter_on_off' =>'yes',
                        'popup_options' =>'3',
                    ]
                ]
            );
        $this->end_controls_section();

    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        $id         = $this->get_id();
        $this->add_render_attribute( 'justify_gallery_attr', 'id', 'npgallery' . esc_attr( $id ) );
        $this->add_render_attribute( 'justify_gallery_attr', 'class', array( 'htmega-justify-gallery', 'npgallery_active' . esc_attr( $id ) ) );

        // Options are handed to the widget handler in htmega-widgets-active.js through a data attribute
        // (no inline script, no page-global #id lookup).
        $justify_options = array(
            'rowHeight'      => absint( $settings['row_height'] ),
            'margins'        => absint( $settings['space_margin'] ),
            'lightbox'       => ( '3' == $settings['popup_options'] ),
            'counter'        => ( 'yes' === $settings['gallery_counter_on_off'] ),
        );
        $this->add_render_attribute( 'justify_gallery_attr', 'data-justifyopt', wp_json_encode( $justify_options, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ) );


        // Remove Elementor Lightbox
 
    
        if( isset( $settings['gallery_images'] ) ):

            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_render_attribute_string() is Elementor core and returns pre-escaped attribute output.
            echo '<div '.$this->get_render_attribute_string( 'justify_gallery_attr' ).' style="display:none;">';
                foreach ( $settings['gallery_images'] as $image ) {
                    $image_src = wp_get_attachment_image_url( $image['id'], 'full' );

                    if( '1' == $settings['popup_options'] ){
                        $this->add_render_attribute( $image["id"], 'data-elementor-open-lightbox', 'no' );
                        $this->add_render_attribute( $image["id"], 'href', '#' );

                    } else if( '2' == $settings['popup_options'] ){
                        $this->add_render_attribute( $image["id"], 'href', esc_url( $image['url'] ) );
                    }  else if( '3' == $settings['popup_options'] ){

                        $this->add_render_attribute( $image["id"], 'data-elementor-open-lightbox', 'no' );
                        $this->add_render_attribute( $image["id"], 'href', esc_url( $image['url'] ) );
                        if ( 'yes' == $settings['gallery_title_on_off'] ){
                            $this->add_render_attribute( $image["id"], 'title', esc_attr( get_the_title($image["id"])) );  
                        }
                    }
                                    
                    ?>
                        <div class="htmega-justify-single-image">
                            <div class="thumb">
                                <?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_render_attribute_string() is Elementor core and returns pre-escaped attribute output. ?>
                                <a <?php echo $this->get_render_attribute_string( $image["id"] ); ?> rel="npgallery">
                                    <img src="<?php echo esc_url( $image_src );?>" alt="<?php echo esc_attr( get_post_meta( $image['id'], '_wp_attachment_image_alt', true) ) ;?>">
                                </a>
                            </div>
                        </div>

                    <?php
                }
            echo '</div>';
        endif;
    }

}

