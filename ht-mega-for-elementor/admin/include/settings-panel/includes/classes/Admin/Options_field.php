<?php
namespace HTMegaOpt\Admin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Options_Field {

    /**
     * [$_instance]
     * @var null
     */
    private static $_instance = null;

    /**
     * [instance] Initializes a singleton instance
     * @return [Admin]
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function get_settings_tabs(){
        $tabs = array(
            'general' => [
                'id'    => 'htmega_pro_vs_free_tabs',
                'title' => esc_html__( 'General', 'ht-mega-for-elementor' ),
                'icon'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <g clip-path="url(#clip0_1_9612)"> <path d="M10 12.4937C8.6193 12.4937 7.5 13.6129 7.5 14.9937V19.9937H12.5V14.9937C12.5 13.6129 11.3807 12.4937 10 12.4937Z" fill="#7D8087"/> <path d="M14.1667 14.9951V19.9951H17.5C18.8807 19.9951 20 18.8758 20 17.4951V9.89429C20.0002 9.46136 19.8319 9.04535 19.5308 8.73429L12.4492 1.07844C11.1996 -0.273518 9.09074 -0.356525 7.73879 0.893006C7.67457 0.95236 7.61271 1.01422 7.55336 1.07844L0.48418 8.73179C0.173944 9.04415 -0.000116212 9.46655 5.82127e-08 9.90679V17.4951C5.82127e-08 18.8758 1.1193 19.9951 2.5 19.9951H5.83332V14.9951C5.84891 12.7228 7.68355 10.8671 9.89867 10.8137C12.1879 10.7585 14.1492 12.6457 14.1667 14.9951Z" fill="#7D8087"/> <path d="M10 12.4937C8.6193 12.4937 7.5 13.6129 7.5 14.9937V19.9937H12.5V14.9937C12.5 13.6129 11.3807 12.4937 10 12.4937Z" fill="#7D8087"/> </g> <defs> <clipPath id="clip0_1_9612"> <rect width="20" height="20" fill="white"/> </clipPath> </defs> </svg>',
                'content' => [
                    'header' => false,
                    'footer' => false,
                    'title' => __( 'Free VS Pro', 'ht-mega-for-elementor' ),
                    'desc'  => __( 'Freely use these elements to create your site. You can enable which you are not using, and, all associated assets will be disable to improve your site loading speed.', 'ht-mega-for-elementor' ),
                ],
            ],
            'elements' => [
                'id'    => 'htmega_element_tabs',
                'title' => esc_html__( 'Elements', 'ht-mega-for-elementor' ),
                'icon'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <g clip-path="url(#clip0_1_9620)"> <path d="M20 5.81V11.75H10.75V0H14.19C17.83 0 20 2.17 20 5.81ZM0 13.25V14.19C0 17.83 2.17 20 5.81 20H9.25V8.25H0V13.25ZM0 5.81V6.75H9.25V0H5.81C2.17 0 0 2.17 0 5.81ZM10.75 20H14.19C17.83 20 20 17.83 20 14.19V13.25H10.75V20Z" fill="#7D8087"/> </g> <defs> <clipPath id="clip0_1_9620"> <rect width="20" height="20" fill="white"/> </clipPath> </defs> </svg>',
                'content' => [
                    'column' => 3,
                    'title' => __( 'Widget List', 'ht-mega-for-elementor' ),
                    'desc'  => __( 'Freely use these elements to create your site. You can enable which you are not using, and, all associated assets will be disable to improve your site loading speed.', 'ht-mega-for-elementor' ),
                ],
            ],
            'sections' => [
                'id'    => 'htmega_sections_element_tabs',
                'title' => esc_html__( 'Sections', 'ht-mega-for-elementor' ),
                'icon'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="1" y="1" width="18" height="5" rx="1.5" fill="#7D8087"/><rect x="1" y="8" width="8" height="11" rx="1.5" fill="#7D8087"/><rect x="11" y="8" width="8" height="5" rx="1.5" fill="#7D8087"/><rect x="11" y="15" width="8" height="4" rx="1.5" fill="#7D8087"/></svg>',
                'content' => [
                    'column' => 3,
                    'title'  => __( 'HT Mega 2026 Collection', 'ht-mega-for-elementor' ),
                    'desc'   => __( 'Toggle individual 2026 section widgets for Elementor and Gutenberg. Disable unused sections to improve your site loading speed.', 'ht-mega-for-elementor' ),
                ],
            ],
            'advance' => array(
                'id'    => 'htmega_advance_element_tabs',
                'title' => esc_html__( 'Modules', 'ht-mega-for-elementor' ),
                'icon'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <g clip-path="url(#clip0_1_9645)"> <path d="M10.4067 0.106243C10.1565 -0.0354143 9.84705 -0.0354143 9.59691 0.106243L1.86746 4.48204C1.73243 4.55849 1.7321 4.7529 1.86687 4.8298L9.91876 9.42424C9.98029 9.45935 10.0558 9.45929 10.1173 9.42408L18.1378 4.83012C18.2723 4.75307 18.2718 4.5589 18.1369 4.48253L10.4067 0.106243ZM10.7048 10.4448C10.6426 10.4805 10.6042 10.5467 10.6042 10.6184V19.6569C10.6042 19.8102 10.7694 19.9065 10.9028 19.831L18.6403 15.4506C18.887 15.3109 19.0387 15.0547 19.0387 14.7776V6.01639C19.0387 5.86274 18.8726 5.76648 18.7393 5.84285L10.7048 10.4448ZM0.964844 14.7776C0.964844 15.0547 1.11654 15.3109 1.36323 15.4506L9.10077 19.831C9.23409 19.9065 9.3993 19.8102 9.3993 19.6569V10.6001C9.3993 10.5283 9.36079 10.462 9.29842 10.4264L1.26396 5.84195C1.13063 5.76587 0.964844 5.86215 0.964844 6.01566V14.7776Z" fill="#7D8087"/> </g> <defs> <clipPath id="clip0_1_9645"> <rect width="20" height="20" fill="white"/> </clipPath> </defs> </svg>',
                'content' => [
                    'column' => 3,
                    'title' => __( 'Module List', 'ht-mega-for-elementor' ),
                    'desc'  => __( 'Freely use these elements to create your site. You can enable which you are not using, and, all associated assets will be disable to improve your site loading speed.', 'ht-mega-for-elementor' ),
                ],
            ),
            'others' => array(
                'id'    => 'htmega_general_tabs',
                'title' => esc_html__( 'Settings', 'ht-mega-for-elementor' ),
                'icon'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <g clip-path="url(#clip0_1_9639)"> <path d="M9.28571 15.0181H8.57143V15.735C8.57143 16.0109 8.41379 16.2614 8.16686 16.3811C7.91921 16.5001 7.62486 16.4666 7.41071 16.295L3.83929 13.4275C3.66979 13.2911 3.57143 13.0852 3.57143 12.8675C3.57143 12.6498 3.66979 12.4439 3.83929 12.3074L7.41071 9.43993C7.62557 9.26771 7.91786 9.23479 8.16686 9.35379C8.41379 9.47357 8.57143 9.72414 8.57143 10V10.7169H9.28571V8.56621C9.28571 8.17 9.60521 7.84936 10 7.84936H12.1429C12.5189 7.84936 12.8264 8.14057 12.8551 8.51021L14.571 7.13243L12.8551 5.75464C12.8265 6.12429 12.5189 6.4155 12.1429 6.4155H10C9.60521 6.4155 9.28571 6.09486 9.28571 5.69864V0C4.10507 0.370143 0 4.70786 0 10C0 15.2921 4.10507 19.6299 9.28571 20V15.0181Z" fill="#7D8087"/> <path d="M10.715 0V4.98186H11.4293V4.26493C11.4293 3.98907 11.5869 3.7385 11.8338 3.61879C12.0808 3.49907 12.3751 3.53264 12.59 3.70493L16.1614 6.57243C16.3309 6.70893 16.4293 6.91479 16.4293 7.1325C16.4293 7.35021 16.3309 7.55607 16.1614 7.69257L12.59 10.5601C12.3758 10.733 12.0828 10.7659 11.8338 10.6462C11.5869 10.5264 11.4293 10.2759 11.4293 10V9.28314H10.715V11.4338C10.715 11.83 10.3955 12.1506 10.0007 12.1506H7.85783C7.48183 12.1506 7.17426 11.8594 7.14562 11.4898L5.42969 12.8676L7.14562 14.2454C7.17419 13.8757 7.48183 13.5845 7.85783 13.5845H10.0007C10.3955 13.5845 10.715 13.9051 10.715 14.3014V20C15.8956 19.6299 20.0007 15.2921 20.0007 10C20.0007 4.70786 15.8956 0.370143 10.715 0Z" fill="#7D8087"/> </g> <defs> <clipPath id="clip0_1_9639"> <rect width="20" height="20" fill="white"/> </clipPath> </defs> </svg>',
                'content' => [
                    'enableall' => false,
                    'title' => __( 'Settings', 'ht-mega-for-elementor' ),
                    'desc'  => __( 'Set the fields value to use these features', 'ht-mega-for-elementor' ),
                    'wrapper_class'  => 'htmega-integrarion-section',
                ],
            ),
        );

        return apply_filters( 'htmega_admin_fields_sections', $tabs );

    }

    public function get_settings_subtabs(){

        $subtabs = array(
            'elements' => array(
                'elementor' => array(
                    'id'      => 'htmega_element_tabs',
                    'title'   => __( 'Elementor Widgets', 'ht-mega-for-elementor' ),
                    'content' => [
                        'column' => 3,
                        'title'  => __( 'Elementor Widget List', 'ht-mega-for-elementor' ),
                        'desc'   => __( 'Freely use these elements to create your site. You can enable which you are not using, and all associated assets will be disabled to improve your site loading speed.', 'ht-mega-for-elementor' ),
                    ],
                    'panels' => [
                        [
                            'id'     => 'htmega_thirdparty_element_tabs',
                            'title'  => __( 'Third Party Plugin\'s Widget List', 'ht-mega-for-elementor' ),
                            'desc'   => __( 'Freely use these elements to create your site. You can enable which you are not using, and all associated assets will be disabled to improve your site loading speed.', 'ht-mega-for-elementor' ),
                            'column' => 3,
                        ],
                    ],
                ),
                'gutenberg' => array(
                    'id'      => 'htmega_gutenberg_tabs',
                    'title'   => __( 'Gutenberg Blocks', 'ht-mega-for-elementor' ),
                    'content' => [
                        'column' => 3,
                        'title'  => __( 'Gutenberg Block List', 'ht-mega-for-elementor' ),
                        'desc'   => __( 'Freely use these Gutenberg blocks to create your site. You can disable which you are not using, and all associated assets will be disabled to improve your site loading speed.', 'ht-mega-for-elementor' ),
                    ],
                ),
            ),
            'sections' => array(
                'elementor' => array(
                    'id'      => 'htmega_sections_element_tabs',
                    'title'   => __( 'Elementor Sections', 'ht-mega-for-elementor' ),
                    'content' => [
                        'column' => 3,
                        'title'  => __( 'HT Mega 2026 — Elementor Widgets', 'ht-mega-for-elementor' ),
                        'desc'   => __( 'Toggle individual 2026 collection widgets for Elementor. Disable unused sections to improve your site loading speed.', 'ht-mega-for-elementor' ),
                    ],
                ),
                'gutenberg' => array(
                    'id'      => 'htmega_sections_gutenberg_tabs',
                    'title'   => __( 'Gutenberg Sections', 'ht-mega-for-elementor' ),
                    'content' => [
                        'column' => 3,
                        'title'  => __( 'HT Mega 2026 — Gutenberg Blocks', 'ht-mega-for-elementor' ),
                        'desc'   => __( 'Toggle individual 2026 collection blocks for the WordPress block editor. Disable unused blocks to improve your site loading speed.', 'ht-mega-for-elementor' ),
                    ],
                ),
            ),
        );

        $subtabs = apply_filters( 'htmega_admin_fields_sub_sections', $subtabs );

        // Gutenberg always last in elements tab, regardless of filter insertion order.
        if ( isset( $subtabs['elements']['gutenberg'] ) ) {
            $gutenberg = $subtabs['elements']['gutenberg'];
            unset( $subtabs['elements']['gutenberg'] );
            $subtabs['elements']['gutenberg'] = $gutenberg;
        }

        return $subtabs;
    }

    public function get_registered_settings(){
        $settings = array(
            'htmega_pro_vs_free_tabs' => array(
                
                array(
                    'id'   => 'htmega_pro_vs_free_html',
                    'type' => 'html',
                    'html' => $this->general_page_html_tabs()
                ),
                
            ),

            'htmega_element_tabs' => array(

                array(
                    'id'  => 'accordion',
                    'name'  => __( 'Accordion', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default' => 'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-accordion-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/accordion-widget/',
                ),
            
                array(
                    'id'  => 'animatesectiontitle',
                    'name'  => __( 'Animate Heading', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-animated-headline-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/animated-heading-widget/',
                ),
            
                array(
                    'id'  => 'addbanner',
                    'name'  => __( 'Ads Banner', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-banner-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/banner-widget/',
                ),
            
                array(
                    'id'  => 'specialadsbanner',
                    'name'  => __( 'Special Day Offer', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-special-day-offer-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/special-day-offer-widget/',
                ),
            
                array(
                    'id'  => 'blockquote',
                    'name'  => __( 'Blockquote', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-blockquote-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/blockquote-widget/',
                ),
            
                array(
                    'id'  => 'brandlogo',
                    'name'  => __( 'Brands', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-brand-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/brand-widget/',
                ),
            
                array(
                    'id'  => 'businesshours',
                    'name'  => __( 'Business Hours', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-business-hours-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/business-hours-widget/',
                ),
            
                array(
                    'id'  => 'button',
                    'name'  => __( 'Button', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-button-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/button-widget/',
                ),
            
                array(
                    'id'  => 'calltoaction',
                    'name'  => __( 'Call To Action', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-call-to-action-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/call-to-action-widget/',
                ),
            
                array(
                    'id'  => 'carousel',
                    'name'  => __( 'Carousel', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-custom-carousel-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/custom-carousel-widget/',
                ),
            
                array(
                    'id'  => 'countdown',
                    'name'  => __( 'Countdown', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-countdown-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/countdown-widget/',
                ),
            
                array(
                    'id'  => 'counter',
                    'name'  => __( 'Counter', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-counter-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/counter-widget/',
                ),
            
                array(
                    'id'  => 'customevent',
                    'name'  => __( 'Custom Event', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => '',
                    'doc_link' => '',
                ),
            
                array(
                    'id'  => 'dualbutton',
                    'name'  => __( 'Double Button', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-double-button-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/double-button-widget/',
                ),
                array(
                    'id'  => 'dropcaps',
                    'name'  => __( 'Dropcaps', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-drop-cap-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/dropcaps-widget/',
                ),
                array(
                    'id'  => 'flipbox',
                    'name'  => __( 'Flip Box', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-flip-box-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/flipbox-widget/',
                ),
            
                array(
                    'id'  => 'galleryjustify',
                    'name'  => __( 'Gallery Justify', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-image-justify-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/gallery-justify-widget/',
                ),
            
                array(
                    'id'  => 'googlemap',
                    'name'  => __( 'Google Map', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-google-map-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/google-map-widget/',
                ),
            
                array(
                    'id'  => 'imagecomparison',
                    'name'  => __( 'Image Comparison', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-image-comparison-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/image-comparison-widget/',
                ),
            
                array(
                    'id'  => 'imagegrid',
                    'name'  => __( 'Image Grid', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-image-grid-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/images-grid-widget/',
                ),

                array(
                    'id'  => 'imagemagnifier',
                    'name'  => __( 'Image Magnifier', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/docs/general-widgets/image-magnifier-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/image-magnifier-widget/',
                ),
                
                array(
                    'id'  => 'imagemarker',
                    'name'  => __( 'Image Marker', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-image-marker-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/image-marker-widget/',
                ),
                
                array(
                    'id'  => 'imagemasonry',
                    'name'  => __( 'Image Masonry', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-image-masonry-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/image-masonry-widget/',
                ),
                
                array(
                    'id'  => 'inlinemenu',
                    'name'  => __( 'Inline Navigation', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-inline-menu-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/inline-menu-widget/',
                ),

                array(
                    'id'  => 'instagram',
                    'name'  => __( 'Instagram', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Social Media Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-instagram-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/social-widgets/instagram-widget/',
                ),
            
                array(
                    'id'  => 'lightbox',
                    'name'  => __( 'Light Box', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-lightbox-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/light-box-widget/',
                ),
            
                array(
                    'id'  => 'modal',
                    'name'  => __( 'Modal', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-modal-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/modal-widget/',
                ),

                array(
                    'id'  => 'newtsicker',
                    'name'  => __( 'News Ticker', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Post Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-news-ticker-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/post-widgets/news-ticker-widget/',
                ),
            
                array(
                    'id'  => 'notify',
                    'name'  => __( 'Notify', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-notification-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/notification-widget/',
                ),
            
                array(
                    'id'  => 'offcanvas',
                    'name'  => __( 'Offcanvas', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-off-canvas-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/offcanvas-widget/',
                ),
            
                array(
                    'id'  => 'panelslider',
                    'name'  => __( 'Panel Slider', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-panel-slider-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/panel-slider-widget/',
                ),
            
                array(
                    'id'  => 'popover',
                    'name'  => __( 'Popover', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-popover-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/popover-widget/',
                ),
            
                array(
                    'id'  => 'postcarousel',
                    'name'  => __( 'Post carousel', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Post Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-post-carousel-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/post-widgets/post-carousel-widget/',
                ),
            
                array(
                    'id'  => 'postgrid',
                    'name'  => __( 'Post Grid', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Post Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-post-grid-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/post-widgets/post-grid-widget/',
                ),
            
                array(
                    'id'  => 'postgridtab',
                    'name'  => __( 'Post Grid Tab', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Post Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-post-grid-tab-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/post-widgets/post-grid-tab-widget/',
                ),
            
                array(
                    'id'  => 'postslider',
                    'name'  => __( 'Post Slider', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Post Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-post-slider-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/post-widgets/post-slider-widget/',
                ),
            
                array(
                    'id'  => 'pricinglistview',
                    'name'  => __( 'Pricing List View', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-price-list-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/pricing-list-view-widget/',
                ),
            
                array(
                    'id'  => 'pricingtable',
                    'name'  => __( 'Pricing Table', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-pricing-table-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/pricing-table-widget/',
                ),
            
                array(
                    'id'  => 'progressbar',
                    'name'  => __( 'Progress Bar', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-progress-bar-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/progress-bar-widget/',
                ),
            
                array(
                    'id'  => 'scrollimage',
                    'name'  => __( 'Scroll Image', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-scroll-image-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/scroll-image-widget/',
                ),
            
                array(
                    'id'  => 'scrollnavigation',
                    'name'  => __( 'Scroll Navigation', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-scroll-navigation-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/scroll-navigation-widget/',
                ),
            
                array(
                    'id'  => 'search',
                    'name'  => __( 'Search', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-search-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/search-widget/',
                ),
            
                array(
                    'id'  => 'sectiontitle',
                    'name'  => __( 'Section Title', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-heading-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/section-title-widget/',
                ),
            
                array(
                    'id'  => 'service',
                    'name'  => __( 'Service', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-services-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/services-widget/',
                ),
            
                array(
                    'id'  => 'singlepost',
                    'name'  => __( 'Single Post', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Post Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-single-post-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/post-widgets/single-post-widget/',
                ),
            
                array(
                    'id'  => 'thumbgallery',
                    'name'  => __( 'Slider Thumbnail Gallery', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-thumbnails-gallery-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/slider-thumbnail-gallery-widget/',
                ),
            
                array(
                    'id'  => 'socialshere',
                    'name'  => __( 'Social Share', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Social Media Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-social-share-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/social-widgets/social-share-widget/',
                ),
            
                array(
                    'id'  => 'switcher',
                    'name'  => __( 'Switcher', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-switcher-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/switcher-widget/',
                ),
            
                array(
                    'id'  => 'tabs',
                    'name'  => __( 'Tabs', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-tab-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/tabs-widget/',
                ),
                array(
                    'id'  => 'datatable',
                    'name'  => __( 'Data Table', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-data-table-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/data-table-widget/',
                ),
            
                array(
                    'id'  => 'teammember',
                    'name'  => __( 'Team Member', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-team-member-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/team-member-widget/',
                ),
            
                array(
                    'id'  => 'testimonial',
                    'name'  => __( 'Testimonial Carousel', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-testimonial-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/testimonial-widget/',
                ),
            
                array(
                    'id'  => 'testimonialgrid',
                    'name'  => __( 'Testimonial Grid', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-testimonial-grid-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/testimonial-grid-widget/',
                ),
            
                array(
                    'id'  => 'toggle',
                    'name'  => __( 'Toggle', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-toggle-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/toggle-widget/',
                ),
            
                array(
                    'id'  => 'tooltip',
                    'name'  => __( 'Tooltip', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-tooltip-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/tooltip-widget/',
                ),
            
                array(
                    'id'  => 'twitterfeed',
                    'name'  => __( 'Twitter Feed', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Social Media Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-twitter-feed-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/social-widgets/twitter-feed-widget/',
                ),
            
                array(
                    'id'  => 'userloginform',
                    'name'  => __( 'User Login Form', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Form Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-user-login-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/user-login-form-widget/',
                ),
            
                array(
                    'id'  => 'userregisterform',
                    'name'  => __( 'User Register Form', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Form Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-user-register-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/user-register-form-widget/',
                ),
            
                array(
                    'id'  => 'verticletimeline',
                    'name'  => __( 'Verticle Timeline', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-vertical-timeline-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/vertical-timeline-widget/',
                ),
            
                array(
                    'id'  => 'videoplayer',
                    'name'  => __( 'Video Player', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-video-player-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/video-player-widget/',
                ),
            
                array(
                    'id'  => 'workingprocess',
                    'name'  => __( 'Working Process', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-working-process-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/working-process-widget/',
                ),
    
                array(
                    'id'  => 'htmega_sticky_sectionp',
                    'name'  => __( 'Sticky Section', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'default'=>'off',
                    'is_pro' => true,
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => '',
                    'doc_link' => '',

                ),
    
                array(
                    'id'  => 'htmega_image_rotedp',
                    'name'  => __( 'Image Rotate', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'default'=>'off',
                    'is_pro' => true,
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => '',
                    'doc_link' => '',
                ),
                array(
                    'id'  => 'errorcontent',
                    'name'  => __( '404 Content', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => '',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/404-widget/',
                ),
            
                array(
                    'id'  => 'template_selector',
                    'name'  => __( 'Remote Template', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => '',
                    'doc_link' => '',
                ),
            
                array(
                    'id'  => 'weather',
                    'name'  => __( 'Weather', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'on',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-weather-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/weather-widget/',
                ),
            
                array(
                    'id'  => 'audio_player',
                    'name'  => __( 'Audio Player', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'default'=> 'off',
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-audio-player-widget/',
                    'doc_link' => '',
                ),
            
                array(
                    'id'  => 'calendly',
                    'name'  => __( 'Calendly', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'default'=> 'on',
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-calendly-widget/',
                    'doc_link' => '',
                ),

                // pro addon list
                array(
                    'id'  => 'info_boxp',
                    'name'  => __( 'Info Box', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-info-box-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/info-box-widget/',
                ),
            
                array(
                    'id'  => 'lottiep',
                    'name'  => __( 'Lottie', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-lottie-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/lottie-widget/',
                ),
                array(
                    'id'  => 'event_calendarp',
                    'name'  => __( 'Event Calendar', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/docs/general-widgets/lottie-widget/',
                    'doc_link' => 'https://wphtmega.com/widget/elementor-event-calendar-widget/',
                ),
                array(
                    'id'  => 'category_listp',
                    'name'  => __( 'Category List', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Post Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-category-list-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/category-list-widget/',
                ),
                array(
                    'id'  => 'pricing_menup',
                    'name'  => __( 'Pricing Menu', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-price-menu-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/price-menu-widget/',
                ),
                array(
                    'id'  => 'feature_listp',
                    'name'  => __( 'Feature List', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-feature-list-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/feature-list-widget/',

                ),
                array(
                    'id'  => 'social_network_iconsp',
                    'name'  => __( 'Social Network Icons', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Social Media Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-social-network-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/social-network-widget/',
                ),
                array(
                    'id'  => 'taxonomy_termsp',
                    'name'  => __( 'Taxonomy Terms', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Post Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-taxonomy-terms-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/taxonomy-terms-widget/',
                ),
                array(
                    'id'  => 'background_switcherp',
                    'name'  => __( 'Background Switcher', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/elementor-background-switcher-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/background-switcher-widget/',
                ),
                array(
                    'id'  => 'breadcrumbsp',
                    'name'  => __( 'Breadcrumbs', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Post Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/elementor-breadcrumbs-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/breadcrumbs-widget/',
                ),
                array(
                    'id'  => 'page_listp',
                    'name'  => __( 'Page List', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Post Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/elementor-page-list-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/page-list-widget/',
                ),
                array(
                    'id'  => 'icon_boxp',
                    'name'  => __( 'Icon Box', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/elementor-icon-box-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/icon-box-widget/',
                ),
                array(
                    'id'  => 'team_carouselp',
                    'name'  => __( 'Team Carousel', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/elementor-team-carousel-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/team-carousel-widget/',
                ),
                array(
                    'id'  => 'interactive_promop',
                    'name'  => __( 'Interactive Promo', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/elementor-interactive-promo-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/interactive-promo-widget/',
                ),
                array(
                    'id'  => 'facebook_reviewp',
                    'name'  => __( 'Facebook Review', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Social Media Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-facebook-review-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/facebook-review-widget/',
                ),
                array(
                    'id'  => 'whatsapp_chatp',
                    'name'  => __( 'WhatsApp Chat', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Social Media Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/elementor-whatsapp-chat-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/whatsapp-chat-widget/',
                ),
                array(
                    'id'  => 'filterable_galleryp',
                    'name'  => __( 'Filterable Gallery', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/elementor-filterable-gallery-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/filterable-gallery-widget/',
                ),
                array(
                    'id'  => 'event_boxp',
                    'name'  => __( 'Event Box', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/elementor-event-box-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/event-box-widget/',
                ),
                array(
                    'id'  => 'chartp',
                    'name'  => __( 'Chart', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/docs/general-widgets/event-box-widget/',
                    'doc_link' => 'https://wphtmega.com/widget/elementor-chart-widget/',
                ),
                array(
                    'id'  => 'post_timelinep',
                    'name'  => __( 'Post Timeline', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Post Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-post-timeline-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/post-widgets/post-timeline-widget/',
                ),
                array(
                    'id'  => 'post_masonryp',
                    'name'  => __( 'Post Masonry', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Post Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-post-masonry-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/post-widgets/post-masonry-widget/',
                ),

                array(
                    'id'  => 'source_codep',
                    'name'  => __( 'Source Code', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-source-code-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/source-code-widget/',
                ),
                array(
                    'id'  => 'threesixty_rotationp',
                    'name'  => __( '360 Rotation', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-360-rotation-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/360-rotation-widget/',
                ),
                array(
                    'id'  => 'pricing_table_flip_boxp',
                    'name'  => __( 'Pricing Table Flip Box', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'default'=>'off',
                    'is_pro' => true,
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/elementor-pricing-table-flip-box-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/pricing-table-flip-box-widget/',
                ),
                array(
                    'id'  => 'flip_switcher_pricing_tablep',
                    'name'  => __( 'Flip Switcher Pricing Table', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'default'=>'off',
                    'is_pro' => true,
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/elementor-pricing-table-flip-box-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/flip-switcher-pricing-table/',
                ),
                array(
                    'id'  => 'dynamic_galleryp',
                    'name'  => __( 'Dynamic Gallery', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'default'=>'off',
                    'is_pro' => true,
                    'category' => __( 'Post Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-dynamic-gallery-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/post-widgets/dynamic-gallery-widget/',
                ),
                array(
                    'id'  => 'advanced_sliderp',
                    'name'  => __( 'Advanced Slider', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'default'=>'off',
                    'is_pro' => true,
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-advanced-slider-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/advanced-slider-widget/',
                ),
                array(
                    'id'  => 'flip_carouselp',
                    'name'  => __( 'Flip Carousel', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'default'=>'off',
                    'is_pro' => true,
                    'category' => __( 'General Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-flip-carousel-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/elementor-flip-carousel-widget/',
                ),
                array(
                    'id'  => 'interactive_circle_infographicp',
                    'name'  => __( 'Interactive Circle Infographic', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'default'=>'off',
                    'is_pro' => true,
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-interactive-circle-infographic-widget/',
                    'doc_link' => '',

                ),
                array(
                    'id'  => 'copy_coupon_codep',
                    'name'  => __( 'Copy Coupon Code', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'default'=>'off',
                    'is_pro' => true,
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-copy-coupon-code-widget/',
                    'doc_link' => '',
                ),
                array(
                    'id'  => 'video_galleryp',
                    'name'  => __( 'Video Gallery', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'default'=> 'off',
                    'is_pro' => true,
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-video-gallery-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/elementor-video-gallery-widget/',
                ),
                array(
                    'id'  => 'video_playlistp',
                    'name'  => __( 'Video Palylist', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'default'=> 'off',
                    'is_pro' => true,
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-video-playlist-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/elementor-video-playlist-widget/',

                ),
                array(
                    'id'  => 'blob_shapep',
                    'name'  => __( 'Blob Shape', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'default'=> 'off',
                    'is_pro' => true,
                    'category' => __( 'Creative Widgets', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-blob-shape-widget/',
                    'doc_link' => 'https://wphtmega.com/docs/creative-widgets/elementor-blob-shape-widget/',
                ),
            ),

            'htmega_gutenberg_tabs' => [
                'blocks' => [
                    [
                        'id'  => 'accordion',
                        'name'  => __( 'Accordion', 'ht-mega-for-elementor' ),
                        'type'  => 'element',
                        'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                        'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                        'default'=>'off',
                        'is_pro' => false,
                    ],
                    [
                        'id'  => 'brand',
                        'name'  => __( 'Brand', 'ht-mega-for-elementor' ),
                        'type'  => 'element',
                        'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                        'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                        'default'=>'off',
                        'is_pro' => false,
                    ],
                    [
                        'id'  => 'buttons',
                        'name'  => __( 'Buttons', 'ht-mega-for-elementor' ),
                        'type'  => 'element',
                        'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                        'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                        'default'=>'off',
                        'is_pro' => false,
                    ],
                    [
                        'id'  => 'cta',
                        'name'  => __( 'Call To Action', 'ht-mega-for-elementor' ),
                        'type'  => 'element',
                        'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                        'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                        'default'=>'off',
                        'is_pro' => false,
                    ],
                    [
                        'id'  => 'image-grid',
                        'name'  => __( 'Image Grid', 'ht-mega-for-elementor' ),
                        'type'  => 'element',
                        'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                        'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                        'default'=>'off',
                        'is_pro' => false,
                    ],
                    [
                        'id'  => 'info-box',
                        'name'  => __( 'Info Box', 'ht-mega-for-elementor' ),
                        'type'  => 'element',
                        'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                        'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                        'default'=>'off',
                        'is_pro' => false,
                    ],
                    [
                        'id'  => 'section-title',
                        'name'  => __( 'Section Title', 'ht-mega-for-elementor' ),
                        'type'  => 'element',
                        'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                        'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                        'default'=>'off',
                        'is_pro' => false,
                    ],
                    [
                        'id'  => 'tab',
                        'name'  => __( 'Tabs', 'ht-mega-for-elementor' ),
                        'type'  => 'element',
                        'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                        'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                        'default'=>'off',
                        'is_pro' => false,
                    ],
                    [
                        'id'  => 'team',
                        'name'  => __( 'Team', 'ht-mega-for-elementor' ),
                        'type'  => 'element',
                        'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                        'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                        'default'=>'off',
                        'is_pro' => false,
                    ],
                    [
                        'id'  => 'testimonial',
                        'name'  => __( 'Testimonial', 'ht-mega-for-elementor' ),
                        'type'  => 'element',
                        'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                        'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                        'default'=>'off',
                        'is_pro' => false,
                    ],
                ]
            ],

            'htmega_general_tabs' => array(
                array(
                    'id'  => 'google_map_api_key',
                    'name' => __( 'Google Map API Key', 'ht-mega-for-elementor' ),
                    'desc'  => __( 'Go to <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">https://developers.google.com</a> and generate the API key.', 'ht-mega-for-elementor' ),
                    'placeholder' => __( 'Google Map API key', 'ht-mega-for-elementor' ),
                    'type' => 'text',
                ),

                array(
                    'id'  => 'weather_map_api_key',
                    'name' => __( 'Weather Map API Key', 'ht-mega-for-elementor' ),
                    'desc'  => __( 'Please enter a OpenWeatherMaps API key. OpenWeather is a weather provider service which is capable of delivering all the necessary weather information for any location on the globe.To create API key, go to this link <a href="https://openweathermap.org/appid" target="_blank">OpenWeather</a>.', 'ht-mega-for-elementor' ),
                    'placeholder' => __( 'Weather Map API key', 'ht-mega-for-elementor' ),
                    'type' => 'text',
                ),

                array(
                    'id'    => 'errorpage',
                    'name'   => __( 'Select 404 Page.', 'ht-mega-for-elementor' ),
                    'desc'    => __( 'You can select 404 page from here.', 'ht-mega-for-elementor' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => htmega_post_name( 'page', -1 )
                ),

                array(
                    'id'  => 'loadpostlimit',
                    'name' => __( 'Load Post in Elementor Addons', 'ht-mega-for-elementor' ),
                    'desc'  => wp_kses_post( 'Load Post in Elementor Addons' ),
                    'min'               => 1,
                    'max'               => 1000,
                    'step'              => '1',
                    'type'              => 'number',
                    'default'           => '20',
                    'sanitize_callback' => 'floatval',
                ),

                array(
                    'id'         => 'htmega_perf_force_global',
                    'name'       => __( 'Load HT Mega assets on every page', 'ht-mega-for-elementor' ),
                    'desc'       => __( 'Keeps legacy behavior (global CSS/JS). Turn off so assets load only on Elementor pages and where the theme builder/header/footer templates apply.', 'ht-mega-for-elementor' ),
                    'type'       => 'checkbox',
                    'default'    => 'off',
                    'class'      => 'htmega-action-field-left',
                    'label_on'   => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off'  => __( 'Off', 'ht-mega-for-elementor' ),
                ),

                array(
                    'id'         => 'htmega_perf_query_cache',
                    'name'       => __( 'Cache post queries in widgets', 'ht-mega-for-elementor' ),
                    'desc'       => __( 'Caches post lists for sliders, grids, and similar widgets (skipped in the Elementor editor). Disable when debugging stale content.', 'ht-mega-for-elementor' ),
                    'type'       => 'checkbox',
                    'default'    => 'on',
                    'class'      => 'htmega-action-field-left',
                    'label_on'   => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off'  => __( 'Off', 'ht-mega-for-elementor' ),
                ),

            ),

            'htmega_advance_element_tabs' => array(
                array(
                    'id'  => 'themebuilder',
                    'name'  => __( 'Theme Builder', 'ht-mega-for-elementor' ),
                    'type'  => 'module',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'option_active_key' => 'themebuilder_enable',
                    'video_link' => 'https://wphtmega.com/modules/theme-builder/',
                    'doc_link' => '',
                    'section'  => 'htmega_themebuilder_module_settings',
                    'setting_fields' => array(
                        array(
                            'id'  => 'themebuilder_enable',
                            'name' => esc_html__( 'Enable / Disable', 'ht-mega-for-elementor' ),
                            'desc'  => esc_html__( 'You can enable / disable Theme Builder from  here.', 'ht-mega-for-elementor' ),
                            'type'  => 'checkbox',
                            'default' => 'off',
                            'class' => 'htmega-action-field-left',
                            'label_on' => esc_html__( 'On', 'ht-mega-for-elementor' ),
                            'label_off' => esc_html__( 'Off', 'ht-mega-for-elementor' ),
                        ),
                        array(
                            'id'    => 'single_blog_page',
                            'name'   => __( 'Single Blog Template.', 'ht-mega-for-elementor' ),
                            'desc' => __( 'You can select a single blog page from here. Or create a ', 'ht-mega-for-elementor' ) . ' <a href="' . esc_url( admin_url( 'edit.php?post_type=htmega_theme_builder' ) ) . '">' . esc_html__( 'new one', 'ht-mega-for-elementor' ) . '</a>',
                            'type'    => 'select',
                            'default' => '0',
                            'options' => [
                                'group'=>[
                                    'htmega' => [
                                        'label' => __( 'HT Mega', 'ht-mega-for-elementor' ),
                                        'options' => htmega_theme_builder_templates(['single_blog_page']),
                                    ],
                                    'elementor' => [
                                        'label' => __( 'Elementor', 'ht-mega-for-elementor' ),
                                        'options' => htmega_elementor_template()
                                    ]
                                ]
                            ],
                            'condition' => [ ['condition_key' => 'themebuilder_enable', 'condition_value' => 'on'] ]
                        ),
                        array(
                            'id'    => 'archive_blog_page',
                            'name'   => __( 'Blog Template.', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'You can select blog page from here. Or create a ', 'ht-mega-for-elementor' ) . ' <a href="' . esc_url( admin_url( 'edit.php?post_type=htmega_theme_builder' ) ) . '">' . esc_html__( 'new one', 'ht-mega-for-elementor' ) . '</a>',
                            'type'    => 'select',
                            'default' => '0',
                            'options' => [
                                'group'=>[
                                    'htmega' => [
                                        'label' => __( 'HT Mega', 'ht-mega-for-elementor' ),
                                        'options' => htmega_theme_builder_templates(['archive_blog_page']),
                                    ],
                                    'elementor' => [
                                        'label' => __( 'Elementor', 'ht-mega-for-elementor' ),
                                        'options' => htmega_elementor_template()
                                    ]
                                ]
                            ],
                            'condition' => [ ['condition_key' => 'themebuilder_enable', 'condition_value' => 'on'] ]
                        ),
                        array(
                            'id'    => 'header_page',
                            'name'   => __( 'Header Template.', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'You can select header template from here. Or create a ', 'ht-mega-for-elementor' ) . ' <a href="' . esc_url( admin_url( 'edit.php?post_type=htmega_theme_builder' ) ) . '">' . esc_html__( 'new one', 'ht-mega-for-elementor' ) . '</a>',
                            'type'    => 'select',
                            'default' => '0',
                            'options' => [
                                'group'=>[
                                    'htmega' => [
                                        'label' => __( 'HT Mega', 'ht-mega-for-elementor' ),
                                        'options' => htmega_theme_builder_templates(['header_page']),
                                    ],
                                    'elementor' => [
                                        'label' => __( 'Elementor', 'ht-mega-for-elementor' ),
                                        'options' => htmega_elementor_template()
                                    ]
                                ]
                            ],
                            'condition' => [ ['condition_key' => 'themebuilder_enable', 'condition_value' => 'on'] ]
                        ),
                        array(
                            'id'    => 'footer_page',
                            'name'   => __( 'Footer Template.', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'You can select footer template from here. Or create a ', 'ht-mega-for-elementor' ) . ' <a href="' . esc_url( admin_url( 'edit.php?post_type=htmega_theme_builder' ) ) . '">' . esc_html__( 'new one', 'ht-mega-for-elementor' ) . '</a>',
                            'type'    => 'select',
                            'default' => '0',
                            'options' => [
                                'group'=>[
                                    'htmega' => [
                                        'label' => __( 'HT Mega', 'ht-mega-for-elementor' ),
                                        'options' => htmega_theme_builder_templates(['footer_page']),
                                    ],
                                    'elementor' => [
                                        'label' => __( 'Elementor', 'ht-mega-for-elementor' ),
                                        'options' => htmega_elementor_template()
                                    ]
                                ]
                            ],
                            'condition' => [ ['condition_key' => 'themebuilder_enable', 'condition_value' => 'on'] ]
                        ),
                        array(
                            'id'    => 'search_pagep',
                            'name'   => __( 'Search Page Template.', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'You can select search page from here.', 'ht-mega-for-elementor' ),
                            'type'    => 'select',
                            'default' => '0',
                            'options' => [
                                'group'=>[
                                    'htmega' => [
                                        'label' => __( 'HT Mega', 'ht-mega-for-elementor' ),
                                        'options' => htmega_theme_builder_templates(['search_page']),
                                    ],
                                    'elementor' => [
                                        'label' => __( 'Elementor', 'ht-mega-for-elementor' ),
                                        'options' => htmega_elementor_template()
                                    ]
                                ]
                            ],
                            'is_pro' => true,
                            'condition' => [ ['condition_key' => 'themebuilder_enable', 'condition_value' => 'on'] ]
                        ),
                        array(
                            'id'    => 'error_pagep',
                            'name'   => __( '404 Page Template.', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'You can select 404 page from here.', 'ht-mega-for-elementor' ),
                            'type'    => 'select',
                            'default' => '0',
                            'options' => [
                                'group'=>[
                                    'htmega' => [
                                        'label' => __( 'HT Mega', 'ht-mega-for-elementor' ),
                                        'options' => htmega_theme_builder_templates(['error_page']),
                                    ],
                                    'elementor' => [
                                        'label' => __( 'Elementor', 'ht-mega-for-elementor' ),
                                        'options' => htmega_elementor_template()
                                    ]
                                ]
                            ],
                            'is_pro' => true,
                            'condition' => [ ['condition_key' => 'themebuilder_enable', 'condition_value' => 'on'] ]
                        ),
                        array(
                            'id'    => 'coming_soon_pagep',
                            'name'   => __( 'Coming Soon Page Template.', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'You can select coming soon page from here.', 'ht-mega-for-elementor' ),
                            'type'    => 'select',
                            'default' => '0',
                            'options' => [
                                'group'=>[
                                    'htmega' => [
                                        'label' => __( 'HT Mega', 'ht-mega-for-elementor' ),
                                        'options' => htmega_theme_builder_templates(['coming_soon_page']),
                                    ],
                                    'elementor' => [
                                        'label' => __( 'Elementor', 'ht-mega-for-elementor' ),
                                        'options' => htmega_elementor_template()
                                    ]
                                ]
                            ],
                            'is_pro' => true,
                            'condition' => [ ['condition_key' => 'themebuilder_enable', 'condition_value' => 'on'] ]
                        ),
                    ),
                ),
                array(
                    'id'  => 'salenotification',
                    'name'  => __( 'Sales Notification', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                ),

                array(
                    'id'  => 'megamenubuilder',
                    'name'  => __( 'Menu Builder', 'ht-mega-for-elementor' ),
                    'type'  => 'module',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'option_active_key' => 'megamenubuilder_enable',
                    'video_link' => 'https://wphtmega.com/modules/megamenu/',
                    'doc_link' => '',
                    'section'  => 'htmega_megamenu_module_settings',
                    'setting_fields' => array(
                        array(
                            'id'  => 'megamenubuilder_enable',
                            'name' => esc_html__( 'Enable / Disable', 'ht-mega-for-elementor' ),
                            'desc'  => esc_html__( 'You can enable / disable Menu Builder from  here.', 'ht-mega-for-elementor' ),
                            'type'  => 'checkbox',
                            'default' => 'off',
                            'class' => 'htmega-action-field-left',
                            'label_on' => esc_html__( 'On', 'ht-mega-for-elementor' ),
                            'label_off' => esc_html__( 'Off', 'ht-mega-for-elementor' ),
                        ),

                        array(
                            'id'    => 'menu_items_color',
                            'name'   => __( 'Menu Items Color', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'Set the Menu Items Color.', 'ht-mega-for-elementor' ),
                            'class' => 'htmega-action-field-left',
                            'type'    => 'color',
                            'default' => '',
                            'condition' => [['condition_key' => 'megamenubuilder_enable', 'condition_value' => 'on']]
                        ),
                        array(
                            'id'    => 'menu_items_hover_color',
                            'name'   => __( 'Menu Items Hover Color', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'Set the Menu Items Hover Color.', 'ht-mega-for-elementor' ),
                            'class' => 'htmega-action-field-left',
                            'type'    => 'color',
                            'default' => '',
                            'condition' => [['condition_key' => 'megamenubuilder_enable', 'condition_value' => 'on']]
                        ),
                        array(
                            'id'  => 'sub_menu_width',
                            'name' => __( 'Sub Menu Width', 'ht-mega-for-elementor' ),
                            'desc'  => __( 'Specify the width of the Sub Menu (px).', 'ht-mega-for-elementor' ),
                            'min'               => 0,
                            'max'               => 1000,
                            'step'              => '1',
                            'type'              => 'number',
                            'default'           => '200',
                            'sanitize_callback' => 'floatval',
                            'condition' => [['condition_key' => 'megamenubuilder_enable', 'condition_value' => 'on']]
                        ),
                        array(
                            'id'    => 'sub_menu_bg_color',
                            'name'   => __( 'Sub Menu Background Color', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'Set the Sub Menu Background Color.', 'ht-mega-for-elementor' ),
                            'class' => 'htmega-action-field-left',
                            'type'    => 'color',
                            'default' => '',
                            'condition' => [['condition_key' => 'megamenubuilder_enable', 'condition_value' => 'on']]
                        ),
                        array(
                            'id'    => 'sub_menu_items_color',
                            'name'   => __( 'Sub Menu Items Color', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'Set the Sub Menu Items Color.', 'ht-mega-for-elementor' ),
                            'class' => 'htmega-action-field-left',
                            'type'    => 'color',
                            'default' => '',
                            'condition' => [['condition_key' => 'megamenubuilder_enable', 'condition_value' => 'on']]
                        ),
                        array(
                            'id'    => 'sub_menu_items_hover_color',
                            'name'   => __( 'Sub Menu Items Hover Color', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'Set the Sub Menu Items Hover Color.', 'ht-mega-for-elementor' ),
                            'class' => 'htmega-action-field-left',
                            'type'    => 'color',
                            'default' => '',
                            'condition' => [['condition_key' => 'megamenubuilder_enable', 'condition_value' => 'on']]
                        ),
                        array(
                            'id'  => 'mega_menu_width',
                            'name' => __( 'Mega Menu Width', 'ht-mega-for-elementor' ),
                            'desc'  => __( 'Specify the Mega Menu Width (px)', 'ht-mega-for-elementor' ),
                            'min'               => 0,
                            'max'               => 2000,
                            'step'              => '1',
                            'type'              => 'number',
                            'default'           => '',
                            'sanitize_callback' => 'floatval',
                            'condition' => [['condition_key' => 'megamenubuilder_enable', 'condition_value' => 'on']]
                        ),
                        array(
                            'id'    => 'mega_menu_bg_color',
                            'name'   => __( 'Mega Menu Background Color', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'Set the Mega Menu Background Color.', 'ht-mega-for-elementor' ),
                            'class' => 'htmega-action-field-left',
                            'type'    => 'color',
                            'default' => '',
                            'condition' => [['condition_key' => 'megamenubuilder_enable', 'condition_value' => 'on']]
                        )
                    ),
                ),

                array(
                    'id'  => 'postduplicator',
                    'name'  => __( 'Post Duplicator', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                ),
                
                array(
                    'id'  => 'wrapperlink',
                    'name'  => __( 'Wrapper Link', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                ),
                
                array(
                    'id'  => 'floating_effects',
                    'name'  => __( 'Floating Effects', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/modules/elementor-floating-effects-module/',
                    'doc_link' => 'https://wphtmega.com/docs/modules/floating-effects/',
                ),
                
                array(
                    'id'  => 'htmega_rpbar',
                    'name'  => __( 'Reading Progress Bar', 'ht-mega-for-elementor' ),
                    'type'  => 'module',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'section'  => 'htmega_rpbar_module_settings',
                    'option_active_key' => 'rpbar_enable',
                    'video_link' => '',
                    'doc_link' => 'https://wphtmega.com/docs/modules/reading-progress-bar-module/',
                    'setting_fields' => array(
                        array(
                            'id'  => 'rpbar_enable',
                            'name' => __( 'Enable/Disable', 'ht-mega-for-elementor' ),
                            'desc'  => __( 'You can enable/disable the Reading Progress Bar from here.', 'ht-mega-for-elementor' ),
                            'type'  => 'checkbox',
                            'default' => 'off',
                            'class' => 'htmega-action-field-left',
                            'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                            'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                        ),
                        array(
                            'id'  => 'rpbar_globalp',
                            'name' => __( 'Enable/Disable Global', 'ht-mega-for-elementor' ),
                            'desc'  => __( 'Enable Reading Progress Bar Globally.' , 'ht-mega-for-elementor'),
                            'type'  => 'checkbox',
                            'default' => 'off',
                            'class' => 'htmega-action-field-left',
                            'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                            'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                            'is_pro' => true,
                        ),
                        array(
                            'id'    => 'rpbar_background_color',
                            'name'   => __( 'Background Color', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'Set the reading progress bar background color.', 'ht-mega-for-elementor' ),
                            'class' => 'htmega-action-field-left',
                            'type'    => 'color',
                            'default' => '#000000',
                            'is_pro' => true,
                            'condition' => [
                                ['condition_key' => 'rpbar_enable', 'condition_value' => 'on'],
                                ['condition_key' => 'rpbar_globalp', 'condition_value' => 'on']
                            ]
        
                        ),
                        array(
                            'id'    => 'rpbar_fill_color',
                            'name'   => __( 'Fill Color', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'Set the fill color.', 'ht-mega-for-elementor' ),
                            'class' => 'htmega-action-field-left',
                            'type'    => 'color',
                            'default' => '#D43A6B',
                            'is_pro' => true,
                            'condition' => [
                                ['condition_key' => 'rpbar_enable', 'condition_value' => 'on'],
                                ['condition_key' => 'rpbar_globalp', 'condition_value' => 'on']
                            ]
        
                        ),
                        array(
                            'id'    => 'rpbar_select_to_show_pages',
                            'name'   => __( 'Select Pages', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'Select the option where you want to display it.', 'ht-mega-for-elementor' ),
                            'type'    => 'select',
                            'default' => 'all',
                            'is_pro' => true,
                            'options' => [
                                'posts' => __('All Posts', 'ht-mega-for-elementor'),
                                'pages' => __('All Pages', 'ht-mega-for-elementor'),
                                'all' => __('All Posts & Pages', 'ht-mega-for-elementor'),
                            ],
                            'condition' => [
                                ['condition_key' => 'rpbar_enable', 'condition_value' => 'on'],
                                ['condition_key' => 'rpbar_globalp', 'condition_value' => 'on']
                            ]
        
                        ),
                        array(
                            'id'  => 'rpbar_loading_height',
                            'name' => __( 'Loading Progress Bar Height', 'ht-mega-for-elementor' ),
                            'desc'  => __( 'Specify the height of the loading progress bar.', 'ht-mega-for-elementor' ),
                            'min'               => 1,
                            'max'               => 100,
                            'step'              => '1',
                            'type'              => 'number',
                            'default'           => '5',
                            'is_pro' => true,
                            'sanitize_callback' => 'floatval',
                            'condition' => [
                                ['condition_key' => 'rpbar_enable', 'condition_value' => 'on'],
                                ['condition_key' => 'rpbar_globalp', 'condition_value' => 'on']
                            ]
                        ),
                        array(
                            'id'    => 'rpbar_position',
                            'name'   => __( 'Position', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'Choose the loading bar position to display the progress bar at the top or bottom.', 'ht-mega-for-elementor' ),
                            'type'    => 'select',
                            'default' => 'top',
                            'is_pro' => true,
                            'options' => [
                                'top' => __('Top', 'ht-mega-for-elementor'),
                                'bottom' => __('Bottom', 'ht-mega-for-elementor'),
                            ],
                            'condition' => [
                                ['condition_key' => 'rpbar_enable', 'condition_value' => 'on'],
                                ['condition_key' => 'rpbar_globalp', 'condition_value' => 'on']
                            ]
        
                        ),
    
                    )
                ),
                array(
                    'id'  => 'htmega_stt',
                    'name'  => __( 'Scroll To Top', 'ht-mega-for-elementor' ),
                    'type'  => 'module',
                    'default'=>'off',
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'option_active_key' => 'stt_enable',
                    'video_link' => '',
                    'doc_link' => 'https://wphtmega.com/docs/modules/scroll-to-top/',
                    'section'  => 'htmega_stt_module_settings',
                    'setting_fields' => array(
                        array(
                            'id'  => 'stt_enable',
                            'name' => __( 'Enable/Disable', 'ht-mega-for-elementor' ),
                            'desc'  => __( 'You can enable/disable Scroll To Top from here.', 'ht-mega-for-elementor' ),
                            'type'  => 'checkbox',
                            'default' => 'off',
                            'class' => 'htmega-action-field-left',
                            'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                            'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                        ),
                        array(
                            'id'  => 'stt_globalp',
                            'name' => __( 'Enable/Disable Global', 'ht-mega-for-elementor' ),
                            'desc'  => __( 'Enable Scroll To Top Globally.', 'ht-mega-for-elementor' ),
                            'type'  => 'checkbox',
                            'default' => 'off',
                            'class' => 'htmega-action-field-left',
                            'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                            'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                            'is_pro' => true,
                        ),
                        array(
                            'id'    => 'stt_select_to_show_pages',
                            'name'   => __( 'Select Pages', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'Select the option where you would like to display it.', 'ht-mega-for-elementor' ),
                            'type'    => 'select',
                            'default' => 'all',
                            'is_pro' => true,
                            'options' => [
                                'posts' => __('All Posts', 'ht-mega-for-elementor'),
                                'pages' => __('All Pages', 'ht-mega-for-elementor'),
                                'all' => __('All Posts & Pages', 'ht-mega-for-elementor'),
                            ],
                            'condition' => [
                                ['condition_key' => 'stt_enable', 'condition_value' => 'on'],
                                ['condition_key' => 'stt_globalp', 'condition_value' => 'on']
                            ]
                            
                        ),
                        array(
                            'id'    => 'stt_position',
                            'name'   => __( 'Position', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'Choose the position to display the Scroll To Top button on the left or right.', 'ht-mega-for-elementor' ),
                            'type'    => 'select',
                            'default' => 'right',
                            'options' => [
                                'left' => __('Bottom Left', 'ht-mega-for-elementor'),
                                'right' => __('Bottom Right', 'ht-mega-for-elementor'),
                            ],
                            'is_pro' => true,
                            'condition' => [
                                ['condition_key' => 'stt_enable', 'condition_value' => 'on'],
                                ['condition_key' => 'stt_globalp', 'condition_value' => 'on']
                            ]
                        ),
                        array(
                            'id'  => 'stt_bottom_space',
                            'name' => __( 'Bottom Space', 'ht-mega-for-elementor' ),
                            'desc'  => __( 'Specify the bottom spacing for the Scroll To Top button.', 'ht-mega-for-elementor' ),
                            'step'              => '1',
                            'type'              => 'number',
                            'default'           => '30',
                            'sanitize_callback' => 'floatval',
                            'is_pro' => true,
                            'condition' => [
                                ['condition_key' => 'stt_enable', 'condition_value' => 'on'],
                                ['condition_key' => 'stt_globalp', 'condition_value' => 'on']
                            ]
                        ),
                        array(
                            'id'    => 'stt_color',
                            'name'   => __( 'Color', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'Set the button icon/text color.', 'ht-mega-for-elementor' ),
                            'class' => 'htmega-action-field-left',
                            'type'    => 'color',
                            'default' => '#ffffff',
                            'is_pro' => true,
                            'condition' => [
                                ['condition_key' => 'stt_enable', 'condition_value' => 'on'],
                                ['condition_key' => 'stt_globalp', 'condition_value' => 'on']
                            ]
                        ),
                        array(
                            'id'    => 'stt_bg_color',
                            'name'   => __( 'Background Color', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'Set the button background color.', 'ht-mega-for-elementor' ),
                            'class' => 'htmega-action-field-left',
                            'type'    => 'color',
                            'default' => '#000000',
                            'is_pro' => true,
                            'condition' => [
                                ['condition_key' => 'stt_enable', 'condition_value' => 'on'],
                                ['condition_key' => 'stt_globalp', 'condition_value' => 'on']
                            ]
        
                        ),
                        array(
                            'id'    => 'stt_color_hover',
                            'name'   => __( 'Hover Color', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'Set the button icon/text hover color.', 'ht-mega-for-elementor' ),
                            'class' => 'htmega-action-field-left',
                            'type'    => 'color',
                            'default' => '#ffffff',
                            'is_pro' => true,
                            'condition' => [
                                ['condition_key' => 'stt_enable', 'condition_value' => 'on'],
                                ['condition_key' => 'stt_globalp', 'condition_value' => 'on']
                            ]
                        ),
                        array(
                            'id'    => 'stt_bg_color_hover',
                            'name'   => __( 'Hover Background Color', 'ht-mega-for-elementor' ),
                            'desc'    => __( 'Set the button hover background color.', 'ht-mega-for-elementor' ),
                            'class' => 'htmega-action-field-left',
                            'type'    => 'color',
                            'default' => '#000000',
                            'is_pro' => true,
                            'condition' => [
                                ['condition_key' => 'stt_enable', 'condition_value' => 'on'],
                                ['condition_key' => 'stt_globalp', 'condition_value' => 'on']
                            ]
                        )
                    )
                ),
               
                array(
                    'id'  => 'crossdomaincpp',
                    'name'  => __( 'Cross Domain Copy Paste', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'video_link' => '',
                    'doc_link' => '',
                ),
                array(
                    'id'  => 'parallax_modulep',
                    'name'  => __( 'Parallax', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default' => 'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-parallax-module/',
                    'doc_link' => '',
                ),
                array(
                    'id'  => 'particles_modulep',
                    'name'  => __( 'Particles', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default' => 'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/widget/elementor-particles-module/',
                    'doc_link' => 'https://wphtmega.com/docs/general-widgets/particles-module/',
                ),
                array(
                    'id'  => 'd_conditional_modulep',
                    'name'  => __( 'Conditional Display', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default' => 'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/modules/conditional-display-module/',
                    'doc_link' => 'https://wphtmega.com/docs/modules/conditional-display-module/',
                ),
                array(
                    'id'  => 'advanced_sticky_modulep',
                    'name'  => __( 'Advanced Sticky', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default' => 'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                    'video_link' => 'https://wphtmega.com/modules/advanced-sticky-module/',
                    'doc_link' => 'https://wphtmega.com/docs/',
                ),
                array(
                    'id'  => 'custom_css_modulep',
                    'name'  => __( 'Custom CSS', 'ht-mega-for-elementor' ),
                    'type'  => 'element',
                    'default'=>'off',
                    'is_pro' => true,
                    'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                    'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                ),
            ),
        );

        $settings['htmega_themebuilder_element_tabs'] = array(

            array(
                'id'  => 'bl_post_title',
                'name'  => __( 'Post Title', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'on',
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),

            array(
                'id'  => 'bl_post_featured_image',
                'name'  => __( 'Post Featured Image', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'on',
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),

            array(
                'id'  => 'bl_post_meta_info',
                'name'  => __( 'Post Meta Info', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'on',
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),

            array(
                'id'  => 'bl_post_excerpt',
                'name'  => __( 'Post Excerpt', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'on',
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),

            array(
                'id'  => 'bl_post_content',
                'name'  => __( 'Post Content', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'on',
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),

            array(
                'id'  => 'bl_post_comments',
                'name'  => __( 'Post Comments', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'on',
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),

            array(
                'id'  => 'bl_post_search_form',
                'name'  => __( 'Post Search Form', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'on',
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),

            array(
                'id'  => 'bl_post_archive',
                'name'  => __( 'Archive Posts', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'on',
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),

            array(
                'id'  => 'bl_post_archive_title',
                'name'  => __( 'Archive Title', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'on',
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),
            
            array(
                'id'  => 'bl_page_title',
                'name'  => __( 'Page Title', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'on',
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),

            array(
                'id'  => 'bl_site_title',
                'name'  => __( 'Site Title', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'on',
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),

            array(
                'id'  => 'bl_site_logo',
                'name'  => __( 'Site Logo', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'on',
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),

            array(
                'id'  => 'bl_nav_menu',
                'name'  => __( 'Nav Menu', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'on',
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),

            array(
                'id'  => 'bl_post_author_info',
                'name'  => __( 'Author Info', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'on',
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),

            array(
                'id'  => 'bl_social_sharep',
                'name'  => __( 'Social Share', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'off',
                'is_pro' => true,
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),

            array(
                'id'  => 'bl_print_pagep',
                'name'  => __( 'Print Page', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'off',
                'is_pro' => true,
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),

            array(
                'id'  => 'bl_view_counterp',
                'name'  => __( 'View Counter', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'off',
                'is_pro' => true,
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),

            array(
                'id'  => 'bl_post_navigationp',
                'name'  => __( 'Post Navigation', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'off',
                'is_pro' => true,
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),

            array(
                'id'  => 'bl_related_postp',
                'name'  => __( 'Related Post', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'off',
                'is_pro' => true,
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),

            array(
                'id'  => 'bl_popular_postp',
                'name'  => __( 'Popular Post', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => 'off',
                'is_pro' => true,
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
            ),


        );

        // Post Duplicator Condition
        if( htmega_get_option( 'postduplicator', 'htmega_advance_element_tabs', 'off' ) === 'on' ){
            $post_types = htmega_get_post_types( array('defaultadd'=>'all') );
            if ( did_action( 'elementor/loaded' ) && defined( 'ELEMENTOR_VERSION' ) ) {
                $post_types['elementor_library'] = esc_html__( 'Templates', 'ht-mega-for-elementor' );
            }
            $settings['htmega_general_tabs'][] = [
                'id'    => 'postduplicate_condition',
                'name'   => __( 'Post Duplicator Condition', 'ht-mega-for-elementor' ),
                'desc'    => __( 'You can enable duplicator for individual post.', 'ht-mega-for-elementor' ),
                'type'    => 'multiselect',
                'default' => '',
                'options' => $post_types,
            ];
        }

        $third_party_element = array();
        // Third Party Addons

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'bbpress',
                'name'    => __( 'bbPress', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => 'https://wphtmega.com/docs/3rd-party-plugin-widgets/bbpress-widget/',
            ];

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'bookedcalender',
                'name'    => __( 'Booked Calender', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => 'https://wphtmega.com/docs/general-widgets/booked-calendar-widget/',
            ];
    

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'buddypress',
                'name'    => __( 'BuddyPress', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => 'https://wphtmega.com/docs/3rd-party-plugin-widgets/buddypress-widget/',
            ];
  

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'calderaform',
                'name'    => __( 'Caldera Form', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => 'https://wphtmega.com/docs/3rd-party-plugin-widgets/caldera-form-widget/',
            ];



            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'contactform',
                'name'    => __( 'Contact form 7', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => 'https://wphtmega.com/docs/forms-widgets/contact-form-widget/',
            ];
   

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'downloadmonitor',
                'name'    => __( 'Download Monitor', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => 'https://wphtmega.com/docs/3rd-party-plugin-widgets/download-monitor-widget/',
            ];

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'easydigitaldownload',
                'name'    => __( 'Easy Digital Downloads', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => 'https://wphtmega.com/docs/3rd-party-plugin-widgets/easy-digital-downloads-widget/',
            ];
   
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'gravityforms',
                'name'    => __( 'Gravity Forms', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => 'https://wphtmega.com/docs/forms-widgets/gravity-forms-widget/',
            ];

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'instragramfeed',
                'name'    => __( 'Instragram Feed', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => 'https://wphtmega.com/docs/social-widgets/instagram-feed-widget/',
            ];

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'jobmanager',
                'name'    => __( 'Job Manager', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => 'https://wphtmega.com/docs/3rd-party-plugin-widgets/job-manager-widget/',
            ];

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'layerslider',
                'name'    => __( 'Layer Slider', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => 'https://wphtmega.com/docs/3rd-party-plugin-widgets/layer-slider-widget/',
            ];

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'mailchimpwp',
                'name'    => __( 'Mailchimp for wp', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => 'https://wphtmega.com/docs/3rd-party-plugin-widgets/mailchimp-for-wp-widget/',
            ];

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'ninjaform',
                'name'    => __( 'Ninja Form', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => 'https://wphtmega.com/docs/3rd-party-plugin-widgets/ninja-form-widget/',
            ];

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'quforms',
                'name'    => __( 'QU Form', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => 'https://wphtmega.com/docs/3rd-party-plugin-widgets/quform-widget/',
            ];

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'wpforms',
                'name'    => __( 'WP Form', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => 'https://wphtmega.com/docs/3rd-party-plugin-widgets/wp-forms-widget/',                
            ];

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'revolution',
                'name'    => __( 'Revolution Slider', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => '',
            ];

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'tablepress',
                'name'    => __( 'TablePress', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => 'https://wphtmega.com/docs/3rd-party-plugin-widgets/tablepress-widget/',
            ];

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'wcaddtocart',
                'name'    => __( 'WC : Add To cart', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => 'https://wphtmega.com/docs/woocommerce-widgets/woocommerce-add-to-cart-widget/',
            ];

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'categories',
                'name'    => __( 'WC : Categories', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => 'https://wphtmega.com/docs/woocommerce-widgets/woocommerce-category-widget/',
            ];

            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'wcpages',
                'name'    => __( 'WC : Pages', 'ht-mega-for-elementor' ),
                'type'    => 'element',
                'default' => "on",
                'label_on' => __( 'On', 'ht-mega-for-elementor' ),
                'label_off' => __( 'Off', 'ht-mega-for-elementor' ),
                'video_link' => '',
                'doc_link' => 'https://wphtmega.com/docs/woocommerce-widgets/woocommerce-page-widget/',
            ];


        if( empty( $third_party_element ) ){
            $third_party_element['htmega_thirdparty_element_tabs'][] = [
                'id'    => 'noelement',
                'html'    => __( 'No Element Found', 'ht-mega-for-elementor' ),
                'type'    => 'html',
            ];
        }

        $settings['htmega_sections_element_tabs'] = apply_filters( 'htmega_sections_element_fields', array(
            array( 'id' => 'hero',         'name' => __( 'Hero 2026',            'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'on', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'about',        'name' => __( 'About / Feature 2026', 'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'on', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'services',     'name' => __( 'Services 2026',        'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'on', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'pricing',      'name' => __( 'Pricing Table 2026',   'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'on', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'testimonials', 'name' => __( 'Testimonials 2026',    'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'on', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'stats',        'name' => __( 'Stats / Counter 2026', 'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'on', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'cta',          'name' => __( 'CTA Section 2026',     'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'on', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'team',         'name' => __( 'Team 2026',            'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'on', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'faq',          'name' => __( 'FAQ 2026',             'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'on', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'blog',         'name' => __( 'Blog / Posts 2026',    'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'on', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'contact',      'name' => __( 'Contact Section 2026', 'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'on', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
        ) );

        $settings['htmega_sections_gutenberg_tabs'] = apply_filters( 'htmega_sections_gutenberg_fields', array(
            array( 'id' => 'hero-2025',         'name' => __( 'Hero 2026',            'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'off', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'about-2025',        'name' => __( 'About / Feature 2026', 'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'off', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'services-2025',     'name' => __( 'Services 2026',        'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'off', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'pricing-2025',      'name' => __( 'Pricing Table 2026',   'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'off', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'testimonials-2025', 'name' => __( 'Testimonials 2026',    'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'off', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'stats-2025',        'name' => __( 'Stats / Counter 2026', 'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'off', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'cta-2025',          'name' => __( 'CTA Section 2026',     'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'off', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'team-2025',         'name' => __( 'Team 2026',            'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'off', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'faq-2025',          'name' => __( 'FAQ 2026',             'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'off', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'blog-2025',         'name' => __( 'Blog / Posts 2026',    'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'off', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
            array( 'id' => 'contact-2025',      'name' => __( 'Contact Section 2026', 'ht-mega-for-elementor' ), 'type' => 'element', 'default' => 'off', 'label_on' => __( 'On', 'ht-mega-for-elementor' ), 'label_off' => __( 'Off', 'ht-mega-for-elementor' ) ),
        ) );

        $allFields = array_merge( $settings, $third_party_element );
        return apply_filters( 'htmega_admin_fields', $allFields );

    }

    // General tab
    public function general_page_html_tabs(){
        ob_start();
        include_once HTMEGAOPT_INCLUDES .'/templates/dashboard-general.php';
        return ob_get_clean();
    }

}