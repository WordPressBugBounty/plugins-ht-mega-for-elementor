<?php
/**
* Class Sale Notification
*/
class HTMegaWC_Sales_Notification{

    private static $_instance = null;
    public static function instance(){
        if( is_null( self::$_instance ) ){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    function __construct(){

        add_action('wp_head',[ $this, 'ajaxurl' ] );

        // ajax function
        add_action('wp_ajax_nopriv_wcsales_purchased_products', [ $this, 'purchased_products' ] );
        add_action('wp_ajax_wcsales_purchased_products', [ $this, 'purchased_products' ] );

        add_action( 'wp_footer', [ $this, 'ajax_request' ] );
        
    }

    public function purchased_products(){

        check_ajax_referer('wcsales-ajax-request', 'security');
        
        $cachekey = 'purchased-new-products';
        $products = get_transient( $cachekey );

        if ( ! $products ) {
            $args = array(
                'post_type' => 'shop_order',
                'post_status' => 'wc-completed, wc-pending, wc-processing, wc-on-hold',
                'orderby' => 'ID',
                'order' => 'DESC',
                'posts_per_page' => htmega_get_option( 'notification_limit','htmegawcsales_setting_tabs','5' ),
                'date_query' => array(
                    'after' => gmdate('Y-m-d', strtotime('-'.'7'.' days'))
                )
            );
            $posts = get_posts( $args );

            $products = array();
            $check_wc_version = version_compare( WC()->version, '3.0', '<') ? true : false;

            foreach( $posts as $post ) {

                $order = new WC_Order( $post->ID );
                $order_items = $order->get_items();

                if( !empty( $order_items ) ) {
                    $first_item = array_values( $order_items )[0];
                    $product_id = $first_item['product_id'];
                    $product = wc_get_product( $product_id );

                    if( !empty( $product ) ){
                        preg_match( '/src="(.*?)"/', $product->get_image( 'thumbnail' ), $imgurl );
                        $allow_html        = (bool) apply_filters( 'htmega_wcsales_allow_html', false );
                        $raw_img           = count( $imgurl ) === 2 ? $imgurl[1] : '';
                        $sanitized_buyer    = array();
                        foreach ( $this->purchased_buyer_info( $order ) as $bk => $bv ) {
                            $sanitized_buyer[ sanitize_key( (string) $bk ) ] = sanitize_text_field( (string) $bv );
                        }
                        $p = array(
                            'name'  => $allow_html ? wp_kses_post( $product->get_name() ) : wp_strip_all_tags( $product->get_name() ),
                            'url'   => esc_url_raw( $product->get_permalink() ),
                            'image' => $raw_img ? esc_url_raw( $raw_img ) : '',
                            'price' => $this->purchased_productprice( $check_wc_version ? $product->get_display_price() : wc_get_price_to_display( $product ) ),
                            'buyer' => $sanitized_buyer,
                        );
                        $p = apply_filters( 'wcsales_product_data', $p );
                        array_push( $products, $p);
                    }
                }

            }
            set_transient( $cachekey, $products, 60 ); // Cache the results for 1 minute
        }
        wp_send_json( $products );

    }

    // Product Price
    private function purchased_productprice($price) {
        if( empty( $price ) ){
            $price = 0;
        }
        return sprintf(
            get_woocommerce_price_format(),
            get_woocommerce_currency_symbol(),
            number_format( $price, wc_get_price_decimals(), wc_get_price_decimal_separator(), wc_get_price_thousand_separator() )
        );  
    }

    // Buyer Info
    private function purchased_buyer_info( $order ){
        $address = $order->get_address( 'billing' );
        if( !isset( $address['city'] ) || empty( $address['city'] ) ){
            $address = $order->get_address( 'shipping' );
        }

        $show_buyer_name = ( htmega_get_option( 'show_buyer_name', 'htmegawcsales_setting_tabs', 'off' ) === 'on' );
        $show_city       = ( htmega_get_option( 'show_city',       'htmegawcsales_setting_tabs', 'off' ) === 'on' );
        $show_state      = ( htmega_get_option( 'show_state',      'htmegawcsales_setting_tabs', 'off' ) === 'on' );
        $show_country    = ( htmega_get_option( 'show_country',    'htmegawcsales_setting_tabs', 'off' ) === 'on' );

        // When buyer name is enabled, expose first name + last initial only (never full last name).
        $lname_raw     = isset( $address['last_name'] ) && !empty( $address['last_name'] ) ? $address['last_name'] : '';
        $lname_initial = !empty( $lname_raw ) ? strtoupper( substr( $lname_raw, 0, 1 ) ) . '.' : '';

        $buyerinfo = array(
            'fname'   => ( $show_buyer_name && !empty( $address['first_name'] ) ) ? ucfirst( $address['first_name'] ) : '',
            'lname'   => ( $show_buyer_name && !empty( $lname_initial ) )         ? $lname_initial                    : '',
            'city'    => ( $show_city    && !empty( $address['city'] ) )           ? ucfirst( $address['city'] )       : '',
            'state'   => ( $show_state   && !empty( $address['state'] ) )          ? ucfirst( $address['state'] )      : '',
            'country' => ( $show_country && !empty( $address['country'] ) )        ? WC()->countries->countries[ $address['country'] ] : '',
        );
        return $buyerinfo;
    }

    // Ajax URL Create
    function ajaxurl() {
        ?>
            <script type="text/javascript">
                var ajaxurl = '<?php echo esc_url( admin_url('admin-ajax.php') ); ?>';
            </script>
        <?php
    }

    // Ajax request
    function ajax_request() {

        $duration       = (int)htmega_get_option( 'notification_loadduration','htmegawcsales_setting_tabs', '3' )*1000;
        $notposition    = 'bottomleft';
        $notlayout      = 'imageleft';

        //Set Your Nonce
        $ajax_nonce = wp_create_nonce( "wcsales-ajax-request" );
        ?>
            <script>
                jQuery( document ).ready( function( $ ) {

                    var notposition = '<?php echo esc_js( $notposition ); ?>',
                        notlayout = ' '+'<?php echo esc_js( $notlayout ); ?>';

                    $('body').append('<div class="wcsales-sale-notification"><div class="wcsales-notification-content '+notposition+notlayout+'"></div></div>');

                    var data = {
                        action: 'wcsales_purchased_products',
                        security: '<?php echo esc_js( $ajax_nonce ); ?>',
                        whatever: 1234
                    };
                    var intervaltime = 4000,
                        i = 0,
                        duration = <?php echo esc_js( $duration ); ?>,
                        inanimation = 'fadeInLeft',
                        outanimation = 'fadeOutRight';

                    window.setTimeout( function(){
                        $.post(
                            ajaxurl, 
                            data,
                            function( response ){
                                var wcpobj = ( typeof response === 'string' ) ? $.parseJSON( response ) : response;
                                if( ! $.isArray( wcpobj ) || wcpobj.length === 0 ) {
                                    return;
                                }
                                function appendSaleRow($container, item) {
                                    var buyer = item.buyer || {};
                                    var line = $.grep([buyer.city, buyer.state, buyer.country], function (v){ return !!(v); }).join(' ');
                                    line = $.trim(line);
                                    var buyerLbl = $.trim(((buyer.fname||'') + ' ' + (buyer.lname||'')));
                                    var imgDiv = $('<div>').addClass('wcnotification_image').append(
                                        $('<img>').attr('src', item.image || '').attr('alt', item.name || '')
                                    );
                                    var contentWrap = $('<div>').addClass('wcnotification_content').append(
                                        $('<h4>').append($('<a>').attr('href', item.url || '#').text(item.name || '')),
                                        $('<p>').text(line ? (line + '.') : ''),
                                        $('<h6>').text('Price : ' + ( item.price || '' )),
                                        $('<span>').addClass('wcsales-buyername').text(buyerLbl ? ('By ' + buyerLbl) : '')
                                    );
                                    var closeSpan = $('<span>').addClass('wccross').html('&times;');
                                    $container.empty().append(imgDiv, contentWrap, closeSpan);
                                }
                                    setInterval(function() {
                                        if( i === wcpobj.length ){ i = 0; }
                                        var $box = $('.wcsales-notification-content');
                                        $box.css('padding','15px');
                                        appendSaleRow($box, wcpobj[i]);
                                        $box.addClass('animated '+inanimation).removeClass(outanimation);
                                        setTimeout(function() {
                                            $box.removeClass(inanimation).addClass(outanimation);
                                        }, intervaltime-500 );
                                        i++;
                                    }, intervaltime );
                            }
                        );
                    }, duration );

                    // Close Button
                    $('.wcsales-notification-content').on('click', '.wccross', function(e){
                        e.preventDefault()
                        $(this).closest('.wcsales-notification-content').removeClass(inanimation).addClass(outanimation);
                    });

                });
            </script>
        <?php 
    }



}

HTMegaWC_Sales_Notification::instance();