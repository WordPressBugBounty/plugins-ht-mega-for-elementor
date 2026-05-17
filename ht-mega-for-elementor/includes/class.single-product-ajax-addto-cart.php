<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 *  groupe product Ajax add to cart
 */
class Single_Product_Ajax_Add_To_Cart{

    private static $instance = null;
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function __construct(){
        add_action( 'wp_ajax_woocommerce_grouped_product_ajax_add_to_cart', [ $this, 'grouped_product_addto_cart' ] );
        add_action( 'wp_ajax_nopriv_woocommerce_grouped_product_ajax_add_to_cart', [ $this, 'grouped_product_addto_cart' ] );
    }

    public function grouped_product_addto_cart(){
        check_ajax_referer( 'htmega-woocommerce-ajax-request', 'security' );

        if ( ! isset( $_POST['product_id'] ) ) {
            wp_send_json_error( array( 'message' => __( 'Missing product.', 'htmega-addons' ) ), 400 );
            return;
        }

        $posted = wp_unslash( $_POST );

        if ( isset( $_POST['isgrouped'] ) && 'no' === $_POST['isgrouped'] ){
            $this->single_product_add( $posted );
        } else {
            $this->grouped_product_add( $posted );
        }
    }

    /**
     * @param array<string, mixed> $product_info Posted fields.
     */
    private function single_product_add($product_info){
        $product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( isset( $product_info['product_id'] ) ? $product_info['product_id'] : 0 ) );
        $quantity_input    = isset( $product_info['quantity'] ) ? $product_info['quantity'] : null;
        $quantity          = ( null === $quantity_input || '' === $quantity_input ) ? 1 : wc_stock_amount( wp_unslash( $quantity_input ) );
        $variation_id      = ! empty( $product_info['variation_id'] ) ? absint( $product_info['variation_id'] ) : 0;

        $variations = array();
        if ( ! empty( $product_info['variations'] ) && is_array( $product_info['variations'] ) ) {
            foreach ( $product_info['variations'] as $vk => $vv ) {
                $variations[ sanitize_title( wp_unslash( (string) $vk ) ) ] = sanitize_text_field( wp_unslash( (string) $vv ) );
            }
        }

        $passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variations );
        $product_status    = get_post_status( $product_id );

        if ( $passed_validation && \WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variations ) && 'publish' === $product_status ) {
            do_action( 'woocommerce_ajax_added_to_cart', $product_id );
            if ( 'yes' === get_option('woocommerce_cart_redirect_after_add') ) {
                wc_add_to_cart_message( array( $product_id => $quantity ), true );
            }
            \WC_AJAX::get_refreshed_fragments();
        }

        wp_send_json_error(
            array(
                'error'       => true,
                'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ),
            )
        );
    }

    /**
     * @param array<string, mixed> $product_info Posted fields.
     */
    private function grouped_product_add($product_info){
        $product_id   = absint( isset( $product_info['product_id'] ) ? $product_info['product_id'] : 0 );
        $quanties_raw = isset( $product_info['quantity'] ) ? sanitize_text_field( wp_unslash( (string) $product_info['quantity'] ) ) : '';
        $product_qunatites = '' !== $quanties_raw ? array_map(
            static function ( $chunk ) {
                return wc_stock_amount( wp_unslash( $chunk ) );
            },
            explode( ',', $quanties_raw )
        ) : array();
        $product            = wc_get_product( $product_id );
        $grouped_product_ids = ! empty( $product_info['grouped_product_id'] )
            ? array_filter( array_map( 'absint', explode( ',', sanitize_text_field( wp_unslash( (string) $product_info['grouped_product_id'] ) ) ) ) )
            : array();
        if ( ! empty( $product_qunatites ) && ! empty( $grouped_product_ids ) ) {
            foreach ( $grouped_product_ids as $key => $children_id ){
                $grouped_product_id = apply_filters( 'woocommerce_add_to_cart_product_id', $children_id );
                $quantity           = array_key_exists( $key, $product_qunatites ) && '' !== $product_qunatites[ $key ] ? $product_qunatites[ $key ] : 0;
                $passed_validation  = apply_filters( 'woocommerce_add_to_cart_validation', true, $grouped_product_id, $quantity );
                $product_status     = get_post_status( $grouped_product_id );
                if ( $passed_validation && \WC()->cart->add_to_cart( $grouped_product_id, $quantity ) && 'publish' === $product_status ) {
                    do_action( 'woocommerce_ajax_added_to_cart', $grouped_product_id );
                    if ( 'yes' === get_option('woocommerce_cart_redirect_after_add') ) {
                        wc_add_to_cart_message( array( $product_id => $quantity ), true );
                    }
                }
            }
            \WC_AJAX::get_refreshed_fragments();
            return;
        }

        wp_send_json_error(
            array(
                'error'       => true,
                'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ),
            )
        );
    }


}

Single_Product_Ajax_Add_To_Cart::instance();
