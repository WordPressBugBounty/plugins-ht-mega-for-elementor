<?php
namespace Elementor;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class HTMega_Elementor_Widget_WC_Add_to_Cart extends Widget_Button {

    public function get_name() {
        return 'htmega-wcaddtocart-addons';
    }
    
    public function get_title() {
        return __( 'WC : Add To cart', 'htmega-addons' );
    }

    public function get_icon() {
        return 'htmega-icon eicon-product-add-to-cart';
    }

    public function get_categories() {
        return [ 'htmega-addons' ];
    }
    public function get_script_depends() {
        return ['htmega-single-product-ajax-cart'];
    }

    public function on_export( $element ) {
        unset( $element['settings']['product_id'] );

        return $element;
    }

    public function unescape_html( $safe_text, $text ) {
        return $text;
    }
    public function get_keywords() {
        return ['htmega', 'ht mega', 'woocommerce', 'add to cart', 'wc cart', 'button', 'addons','widget'];
    }

    public function get_help_url() {
        return 'https://wphtmega.com/docs/woocommerce-widgets/woocommerce-add-to-cart-widget/';
    }
    protected function register_controls() {
        if ( ! is_plugin_active('woocommerce/woocommerce.php') ) {
            $this->messing_parent_plg_notice();
        } else {
            $this->wcaddtocart_regster_fields();
        }
    }
    protected function messing_parent_plg_notice() {

        $this->start_controls_section(
            'messing_parent_plg_notice_section',
            [
                'label' => __( 'WC Add to Cart', 'htmega-addons' ),
            ]
        );
            $this->add_control(
                'htmega_plugin_parent_missing_notice',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => sprintf(
                        __( 'It appears that %1$s is not currently installed on your site. Kindly use the link below to install or activate %1$s. After completing the installation or activation, please refresh this page.', 'htmega-addons' ),
                        '<a href="' . esc_url( admin_url( 'plugin-install.php?s=Woocommerce&tab=search&type=term' ) ) . '" target="_blank" rel="noopener">Woocommerce</a>'
                    ),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
                ]
            );
        

            $this->add_control(
                'parent_plugin_install',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<a href="' . esc_url( admin_url( 'plugin-install.php?s=Woocommerce&tab=search&type=term' ) ) . '" target="_blank" rel="noopener">' . esc_html__( 'Click to install or activate Woocommerce', 'htmega-addons' ) . '</a>',
                ]
            );
            
        $this->end_controls_section();

    }

    protected function wcaddtocart_regster_fields() {

        $this->start_controls_section(
            'wcaddtocart_content',
            [
                'label' => __( 'Product', 'htmega-addons' ),
            ]
        );

            $post_list = get_posts(['numberposts' => 50, 'post_type' => 'product',]);
            $post_list_options = ['0' => esc_html__( 'Select Post', 'htmega-addons' ) ];
            foreach ( $post_list as $list ) :
                $post_list_options[ $list->ID ] = $list->post_title;
            endforeach;

            $this->add_control(
                'product_id',
                [
                    'label' => __( 'Product', 'htmega-addons' ),
                    'type'        => Controls_Manager::SELECT2,
                    'options'     => $post_list_options,
                    'default'     => ['0'],
                ]
            );

            $this->add_control(
                'show_quantity',
                [
                    'label'     => __( 'Show Quantity', 'htmega-addons' ),
                    'type'      => Controls_Manager::SWITCHER,
                    'label_off' => __( 'Hide', 'htmega-addons' ),
                    'label_on'  => __( 'Show', 'htmega-addons' ),
                ]
            );

            $this->add_control(
                'quantity',
                [
                    'label'     => __( 'Quantity', 'htmega-addons' ),
                    'type'      => Controls_Manager::NUMBER,
                    'default'   => 1,
                    'condition' => [
                        'show_quantity' => '',
                    ],
                ]
            );
            // For button aliment control
            $this->add_control(
                'button_hidden_selector',
                [
                    'label' => esc_html__( 'View', 'htmega-addons' ),
                    'type' => Controls_Manager::HIDDEN,
                    'default' => 'traditional',
                    'selectors'         => [
                        '{{WRAPPER}} .elementor-button-text' => 'flex-grow: unset',
                    ],
                ]
            );
        $this->end_controls_section();

        parent::register_controls();

        $this->update_control(
            'link',
            [
                'type'    => Controls_Manager::HIDDEN,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->update_control(
            'text',
            [
                'default'     => __( 'Add to Cart', 'htmega-addons' ),
                'placeholder' => __( 'Add to Cart', 'htmega-addons' ),
            ]
        );

        $this->update_control(
            'icon',
            [
                'default' => 'fa fa-shopping-cart',
                
            ]
        );

        $this->update_control(
            'background_color',
            [
                'default' => '#61ce70',
            ]
        );

    }

    protected function render() {

        $settings = $this->get_settings();

        if ( ! is_plugin_active('woocommerce/woocommerce.php') ) {
            htmega_plugin_missing_alert( __('Woocommerce', 'htmega-addons') );
            return;
        }

        if ( ! empty( $settings['product_id'] ) ) {
            $product_id = absint( $settings['product_id'] );
        } elseif ( wp_doing_ajax() ) {
            $product_id = absint( $_POST['post_id'] );
        } else {
            $product_id = get_queried_object_id();
        }

        global $product;
        $product = wc_get_product( $product_id );

        if ( 'yes' === $settings['show_quantity']  ) {
            $this->render_form_button( $product );
        } else {
            $this->render_ajax_button( $product );
        }
    }

    
    private function render_ajax_button( $product ) {
        $settings = $this->get_settings();
        if ( $product ) {
            if ( version_compare( WC()->version, '3.0.0', '>=' ) ) {
                $product_type = $product->get_type();
            }else{
                $product_type = $product->product_type;
            }

            $class = implode( ' ', array_filter( [
                'product_type_' . $product_type,
                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
            ] ) );

            $this->add_render_attribute( 'button', [
                    'rel' => 'nofollow',
                    'href' => $product->add_to_cart_url(),
                    'data-quantity' => ( isset( $settings['quantity'] ) ? $settings['quantity'] : 1 ),
                    'data-product_id' => $product->get_id(),
                    'class' => $class,
                ]
            );

            parent::render();

        } elseif ( current_user_can( 'manage_options' ) ) {
            /*$settings['text'] = __( 'Please set a valid product', 'htmega-addons' );
            $this->set_settings( $settings );*/
            echo esc_html__( 'Please set a valid product', 'htmega-addons' );
        }
    }

    private function render_form_button( $product ) {
        if ( ! $product && current_user_can( 'manage_options' ) ) {
            echo  esc_html__( 'Please set a valid product', 'htmega-addons' );
            return;
        }

        $text_callback = function () {
            ob_start();
            $this->render_text();
            return ob_get_clean();
        };

        add_filter( 'woocommerce_get_stock_html', '__return_empty_string' );
        add_filter( 'woocommerce_product_single_add_to_cart_text', $text_callback );
        add_filter( 'esc_html', [ $this, 'unescape_html' ], 10 ,2 );

        ob_start();
        
        if($product){
            echo '<div class="product">';
                do_action( 'woocommerce_' . $product->get_type() . '_add_to_cart' );
            echo '</div>';
        }else{
            woocommerce_template_single_add_to_cart();
        }

        $form = ob_get_clean();
        $form = str_replace( 'single_add_to_cart_button', 'single_add_to_cart_button elementor-button', $form );
        echo $form; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

        remove_filter( 'woocommerce_product_single_add_to_cart_text', $text_callback );
        remove_filter( 'woocommerce_get_stock_html', '__return_empty_string' );
        remove_filter( 'esc_html', [ $this, 'unescape_html' ] );
    }

}