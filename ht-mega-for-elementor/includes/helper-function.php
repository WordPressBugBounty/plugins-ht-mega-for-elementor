<?php

/**
 * [htmega_get_elementor] Get elementor instance
 * @return [\Elementor\Plugin]
 */
if ( ! function_exists( 'htmega_get_elementor' ) ) {
    function htmega_get_elementor() {
        return \Elementor\Plugin::instance();
    }
}
    // elementor editor mode check
if ( ! function_exists( 'htmega_is_editor_mode' ) ) {

    function htmega_is_editor_mode() {
        return \Elementor\Plugin::$instance->editor->is_edit_mode();
    }

}
// elementor editing mode
if( !function_exists('htmega_is_editing_mode') ){
    function htmega_is_editing_mode() {
        return ( htmega_get_elementor()->editor->is_edit_mode() ||
        htmega_get_elementor()->preview->is_preview_mode() ||
        is_preview() );
    }
}

if ( ! function_exists( 'htmega_is_elementor_preview_request' ) ) {
	/**
	 * True only when serving the Elementor editor preview iframe (not the wp-admin editor shell, not WordPress
	 * native `?preview=true`). Use this to conditionally merge heavy script deps for template import / live canvas —
	 * avoids loading bundle extras on normal front-end requests when {@see htmega_is_editing_mode()} would also be
	 * true for WordPress post preview.
	 *
	 * @return bool
	 */
	function htmega_is_elementor_preview_request() {
		if ( ! class_exists( '\Elementor\Plugin', false ) ) {
			return false;
		}
		$preview = \Elementor\Plugin::$instance->preview;
		return $preview && $preview->is_preview_mode();
	}
}
/**
 * [htmega_get_elementor_option]
 * @param  [string] $key Option Key
 * @param  [int] $post_id page id
 * @return [string] custom value
 */
if ( ! function_exists( 'htmega_get_elementor_option' ) ) {
    function htmega_get_elementor_option( $key, $post_id ){
        // Get the page settings manager
        $page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );

        // Get the settings model for current post
        $page_settings_model = $page_settings_manager->get_model( $post_id );

        // Retrieve value
        $elget_value = $page_settings_model->get_settings( $key );
        return $elget_value;
    }
}


/**
* Elementor Version check
* Return boolean value
*/
if ( ! function_exists( 'htmega_is_elementor_version' ) ) {
    function htmega_is_elementor_version( $operator = '<', $version = '2.6.0' ) {
        return defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, $version, $operator );
    }
}
// Compatibility with elementor version 3.6.1
if ( ! function_exists( 'htmega_widget_register_manager' ) ) {
    function htmega_widget_register_manager($widget_class){
        $widgets_manager = \Elementor\Plugin::instance()->widgets_manager;
        
        if ( htmega_is_elementor_version( '>=', '3.5.0' ) ){
            $widgets_manager->register( $widget_class );
        }else{
            $widgets_manager->register_widget_type( $widget_class );
        }
    }
}

/*
 * Plugisn Options value
 * return on/off
 */
if( !function_exists('htmega_get_option') ){
    function htmega_get_option( $option, $section, $default = '' ){
        $options = get_option( $section );
        if ( isset( $options[$option] ) ) {
            return $options[$option];
        }
        return $default;
    }
}

/*
 * Elementor Templates List
 * return array
 */
if( !function_exists('htmega_elementor_template') ){
    function htmega_elementor_template( $args = [] ) {
        if( class_exists('\Elementor\Plugin') ){

            $template_instance = \Elementor\Plugin::instance()->templates_manager->get_source( 'local' );

            $defaults = [
                'post_type' => 'elementor_library',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC',
                'meta_query' => [
                    [
                        'key' => '_elementor_template_type',
                        'value' => $template_instance::get_template_types()
                    ],
                ],
            ];
            $query_args = wp_parse_args( $args, $defaults );

            $templates_query = new \WP_Query( $query_args );

            $templates = [];
            if ( $templates_query->have_posts() ) {
                $templates = [ '0' => __( 'Select Template', 'htmega-addons' ) ];
                foreach ( $templates_query->get_posts() as $post ) {
                    $templates[$post->ID] = $post->post_title . '(' . $template_instance::get_template_type( $post->ID ). ')';
                }
            }else{
                $templates = [ '0' => __( 'No saved templates found!', 'htmega-addons' ) ];
            }
            wp_reset_postdata();

            return $templates;

        }else{
            return array( '0' => __( 'No saved templates found!', 'htmega-addons' ) );
        }
    }
}
/**
 * Get HTMega templates list by type
 *
 * @param string $type Template type to filter by
 * @return array Filtered list of templates
 */
if( !function_exists('htmega_theme_builder_templates') ){

    function htmega_theme_builder_templates( $type = [] ){
        $template_lists = [];

        $args = array(
            'post_type'            => 'htmega_theme_builder',
            'post_status'          => 'publish',
            'ignore_sticky_posts'  => 1,
            'posts_per_page'       => -1,
        );

        if( is_array( $type ) && count( $type ) > 0 ){
            $args['meta_key'] = '_htmega_template_type';
            $args['meta_value'] = $type;
            $args['meta_compare'] = 'IN';
        }

        $templates = new WP_Query( $args );

        if( $templates->have_posts() ){
            foreach ( $templates->get_posts() as $post ) {
                $template_lists[ $post->ID ] = $post->post_title;
            }
        }
        wp_reset_query();
        return $template_lists;

    }
}

/*
 * Elementor Setting page value
 * return $elget_value
 */
if( !function_exists('htmega_get_elementor_setting') ){
    function htmega_get_elementor_setting( $key, $post_id ){
        // Get the page settings manager
        $page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );

        // Get the settings model for current post
        $page_settings_model = $page_settings_manager->get_model( $post_id );

        // Retrieve value
        $elget_value = $page_settings_model->get_settings( $key );
        return $elget_value;
    }
}


/*
 * Sidebar Widgets List
 * return array
 */
if( !function_exists('htmega_sidebar_options') ){
    function htmega_sidebar_options() {
        global $wp_registered_sidebars;
        $sidebar_options = array();

        if ( ! $wp_registered_sidebars ) {
            $sidebar_options['0'] = __( 'No sidebars were found', 'htmega-addons' );
        } else {
            $sidebar_options['0'] = __( 'Select Sidebar', 'htmega-addons' );
            foreach ( $wp_registered_sidebars as $sidebar_id => $sidebar ) {
                $sidebar_options[ $sidebar_id ] = $sidebar['name'];
            }
        }
        return $sidebar_options;
    }
}

/*
 * Get Taxonomy
 * return array
 */
if( !function_exists('htmega_get_taxonomies') ){
    function htmega_get_taxonomies( $htmega_texonomy = 'category' ){
        $terms = get_terms( array(
            'taxonomy' => $htmega_texonomy,
            'hide_empty' => true,
        ));
        $options = array();
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ( $terms as $term ) {
                $options[ $term->slug ] = $term->name;
            }
            return $options;
        }
    }
}

/*
 * Get Post Type
 * return array
 */
if( !function_exists('htmega_get_post_types') ){
    function htmega_get_post_types( $args = [] ) {
        $post_type_args = [
            'show_in_nav_menus' => true,
        ];
        if ( ! empty( $args['post_type'] ) ) {
            $post_type_args['name'] = $args['post_type'];
        }
        $_post_types = get_post_types( $post_type_args , 'objects' );

        $post_types  = [];
        if( !empty( $args['defaultadd'] ) ){
            $post_types[ strtolower($args['defaultadd']) ] = ucfirst($args['defaultadd']);
        }
        foreach ( $_post_types as $post_type => $object ) {
            $post_types[ $post_type ] = $object->label;
        }
        return $post_types;
    }
}

/*
 * HTML Tag list
 * return array
 */
if( !function_exists('htmega_html_tag_lists') ){
    function htmega_html_tag_lists() {
        $html_tag_list = [
            'h1'   => __( 'H1', 'htmega-addons' ),
            'h2'   => __( 'H2', 'htmega-addons' ),
            'h3'   => __( 'H3', 'htmega-addons' ),
            'h4'   => __( 'H4', 'htmega-addons' ),
            'h5'   => __( 'H5', 'htmega-addons' ),
            'h6'   => __( 'H6', 'htmega-addons' ),
            'p'    => __( 'p', 'htmega-addons' ),
            'div'  => __( 'div', 'htmega-addons' ),
            'span' => __( 'span', 'htmega-addons' ),
        ];
        return $html_tag_list;
    }
}

/*
 * HTML Tag Validation
 * return strig
 */
if ( ! function_exists( 'htmega_validate_html_tag' ) ) {
    function htmega_validate_html_tag( $tag ) {
        $allowed_html_tags = [
            'article',
            'aside',
            'footer',
            'header',
            'section',
            'nav',
            'main',
            'div',
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
            'p',
            'span',
        ];
        $valid_tag = is_string( $tag ) ? strtolower( $tag ) : 'div';
        return in_array( $valid_tag, $allowed_html_tags ) ? $tag : 'div';
    }
}

/*
 * Custom Pagination
 */
if( !function_exists('htmega_custom_pagination') ){
    function htmega_custom_pagination( $totalpage ){
        $big = 999999999;
        echo '<div class="htbuilder-pagination">';
            echo paginate_links( array( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'current' => max( 1, get_query_var('paged') ),
                'total' => $totalpage,
                'prev_text' => '&larr;', 
                'next_text' => '&rarr;', 
                'type'      => 'list', 
                'end_size'  => 3, 
                'mid_size'  => 3
            ) ); 
        echo '</div>';
    }
}

/*
 * Contact form list
 * return array
 */
if( !function_exists('htmega_contact_form_seven') ){
    function htmega_contact_form_seven(){
        $countactform = array();
        $htmega_forms_args = array( 'posts_per_page' => -1, 'post_type'=> 'wpcf7_contact_form' );
        $htmega_forms = get_posts( $htmega_forms_args );

        if( $htmega_forms ){
            foreach ( $htmega_forms as $htmega_form ){
                $countactform[$htmega_form->ID] = $htmega_form->post_title;
            }
        }else{
            $countactform[ esc_html__( 'No contact form found', 'htmega-addons' ) ] = 0;
        }
        return $countactform;
    }
}


/*
 * All Post Name
 * return array
 */
if( !function_exists('htmega_post_name') ){
    function htmega_post_name ( $post_type = 'post', $limit = 'default' ){
        if( $limit === 'default' ){
            $limit = htmega_get_option( 'loadpostlimit', 'htmega_general_tabs', '20' );
        }
        $options = array();
        $options = ['0' => esc_html__( 'None', 'htmega-addons' )];
        $wh_post = array( 'posts_per_page' => $limit, 'post_type'=> $post_type );
        $wh_post_terms = get_posts( $wh_post );
        if ( ! empty( $wh_post_terms ) && ! is_wp_error( $wh_post_terms ) ){
            foreach ( $wh_post_terms as $term ) {
                $options[ $term->ID ] = $term->post_title;
            }
            return $options;
        }
    }
}

/**
* Blog page return true
*/
if( !function_exists('htmega_builder_is_blog_page') ){
    function htmega_builder_is_blog_page() {
        global $post;
        //Post type must be 'post'.
        $post_type = get_post_type( $post );
        return (
            ( is_home() || is_archive() )
            && ( $post_type == 'post')
        ) ? true : false ;
    }
}

/**
 * Get all menu list
 * return array
 */
if( !function_exists('htmega_get_all_create_menus') ){
    function htmega_get_all_create_menus() {
        $raw_menus = wp_get_nav_menus();
        $menus     = wp_list_pluck( $raw_menus, 'name', 'term_id' );
        $parent    = isset( $_GET['parent_menu'] ) ? absint( $_GET['parent_menu'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if ( 0 < $parent && isset( $menus[ $parent ] ) ) {
            unset( $menus[ $parent ] );
        }
        return $menus;
    }
}

/*
 * Caldera Form
 * @return array
 */
if( !function_exists('htmega_caldera_forms_options') ){
    function htmega_caldera_forms_options() {
        if ( class_exists( 'Caldera_Forms' ) ) {
            $caldera_forms = Caldera_Forms_Forms::get_forms( true, true );
            $form_options  = ['0' => esc_html__( 'Select Form', 'htmega-addons' )];
            $form          = array();
            if ( ! empty( $caldera_forms ) && ! is_wp_error( $caldera_forms ) ) {
                foreach ( $caldera_forms as $form ) {
                    if ( isset($form['ID']) and isset($form['name'])) {
                        $form_options[$form['ID']] = $form['name'];
                    }   
                }
            }
        } else {
            $form_options = ['0' => esc_html__( 'Form Not Found!', 'htmega-addons' ) ];
        }
        return $form_options;
    }
}

/*
 * Check user Login and call this function
 */
global $user;
if ( empty( $user->ID ) ) {
    add_action('elementor/init', 'htmega_ajax_login_init' );
    add_action( 'elementor/init', 'htmega_ajax_register_init' );
}

/*
 * wp_ajax_nopriv Function
 */
function htmega_ajax_login_init() {
    add_action( 'wp_ajax_nopriv_htmega_ajax_login', 'htmega_ajax_login' );
}

/*
 * ajax login
 */
function htmega_ajax_login(){
    check_ajax_referer( 'ajax-login-nonce', 'security' );
    $user_data = array();
    $user_data['user_login'] = !empty( $_POST['username'] ) ? sanitize_text_field( $_POST['username'] ): "";
    $user_data['user_password'] = !empty( $_POST['password'] ) ? sanitize_text_field( $_POST['password'] ): "";
    $user_data['remember'] = true;
    $user_signon = wp_signon( $user_data, false );

    $messages = !empty( $_POST['messages'] ) ? $_POST['messages']: "";
    if( $messages ){
        $messages = json_decode( stripslashes( $messages ), true );
    }

    if ( is_wp_error($user_signon) ){

        $invalid_info = !empty( $messages['invalid_info'] ) ? esc_html( $messages['invalid_info'] ) : esc_html__('Invalid username or password!', 'htmega-addons');
        echo wp_json_encode( [ 'loggeauth'=>false, 'message'=> $invalid_info ] );
    } else {
        $success_msg = !empty( $messages['success_msg'] ) ? esc_html( $messages['success_msg'] ) : esc_html__('Login Successfully', 'htmega-addons');
        echo wp_json_encode( [ 'loggeauth'=>true, 'message'=> $success_msg ] );
    }
    wp_die();
}

/*
 * wp_ajax_nopriv Register Function
 */
function htmega_ajax_register_init() {
    add_action( 'wp_ajax_nopriv_htmega_ajax_register', 'htmega_ajax_register' );
}

/*
* Ajax Register Call back
*/
function htmega_ajax_register() {

	if ( ! isset( $_POST['nonce'] ) ) {
		echo wp_json_encode( [ 'registerauth' =>false, 'message'=> esc_html__( 'Invalid Request', 'htmega-addons' ) ] );
		wp_die();
	}

    $verified_nonce = wp_verify_nonce( $_POST['nonce'], 'htmega_register_nonce' );
    
    if ( ! $verified_nonce ) {
        echo wp_json_encode( [ 'registerauth' =>false, 'message'=> esc_html__( 'Invalid Request', 'htmega-addons' ) ] );
        wp_die();
    }
    if ( ! get_option( 'users_can_register' ) ) {
        echo wp_json_encode( [ 'registerauth' =>false, 'message'=> esc_html__( 'User registration is currently not allowed.', 'htmega-addons' ) ] );
        wp_die();
    }


    $user_data = array(
        'user_login'    => ! empty( $_POST['reg_name'] ) ? sanitize_text_field( $_POST['reg_name'] ) : "",
        'user_pass'     => ! empty( $_POST['reg_password'] ) ? sanitize_text_field( $_POST['reg_password'] ) : "",
        'user_email'    => ! empty( $_POST['reg_email'] ) ? sanitize_email( $_POST['reg_email'] ) : "",
        'user_url'      => ! empty( $_POST['reg_website'] ) ? esc_url( $_POST['reg_website'] ) : "",
        'first_name'    => ! empty( $_POST['reg_fname'] ) ? sanitize_text_field( $_POST['reg_fname'] ) : "",
        'last_name'     => ! empty( $_POST['reg_lname'] ) ? sanitize_text_field( $_POST['reg_lname'] ) : "",
        'nickname'      => ! empty( $_POST['reg_nickname'] ) ? sanitize_text_field( $_POST['reg_nickname'] ) : "",
        'description' => !empty( $_POST['reg_bio'] ) ? sanitize_text_field( $_POST['reg_bio'] ) : "",
    );
    $messages = ! empty( $_POST['messages'] ) ? $_POST['messages'] : "";
    if ( $messages ) {
        $messages = json_decode( stripslashes( $messages ), true );
    }

    if ( htmega_validation_data( $user_data ) !== true ) {
        echo htmega_validation_data( $user_data, $messages  ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    } else {
        $register_user = wp_insert_user( $user_data );

        if ( is_wp_error( $register_user ) ){
            $server_error_msg = !empty( $messages['server_error_msg'] ) ? esc_html( $messages['server_error_msg'] ) : esc_html__('Something is wrong please check again!', 'htmega-addons');
            echo wp_json_encode( [ 'registerauth' =>false, 'message'=> $server_error_msg ] );
        } else {
            $success_msg = !empty( $messages['success_msg'] ) ? esc_html( $messages['success_msg'] ) : esc_html__('Successfully Register', 'htmega-addons');
            echo wp_json_encode( [ 'registerauth' =>true, 'message'=> $success_msg ] );
        }
    }
    wp_die();

}

// Register Data Validation
function htmega_validation_data( $user_data = null, $messages = null ){
// phpcs:ignore WordPress.Security.NonceVerification.Recommended
    if( empty( $user_data['user_login'] ) || empty( $_POST['reg_email'] ) || empty( $_POST['reg_password'] ) ){ // phpcs:ignore WordPress.Security.NonceVerification.Missing

        $required_msg = !empty( $messages['required_msg'] ) ? esc_html( $messages['required_msg'] ) : esc_html__('Username, Password and E-Mail are required', 'htmega-addons');
        return wp_json_encode( [ 'registerauth' =>false, 'message'=> $required_msg ] );
    }
    if( !empty( $user_data['user_login'] ) ){

        if ( 4 > strlen( $user_data['user_login'] ) ) {
            $user_length_msg = !empty( $messages['user_length_msg'] ) ? esc_html( $messages['user_length_msg'] ) : esc_html__('Username too short. At least 4 characters is required', 'htmega-addons');

            return wp_json_encode( [ 'registerauth' =>false, 'message'=> $user_length_msg ] );
        }

        if ( username_exists( $user_data['user_login'] ) ){
            $user_exists_msg = !empty( $messages['user_exists_msg'] ) ? esc_html( $messages['user_exists_msg'] ) : esc_html__('Sorry, that username already exists!', 'htmega-addons');
            
            return wp_json_encode( [ 'registerauth' =>false, 'message'=> $user_exists_msg ] );
        }

        if ( !validate_username( $user_data['user_login'] ) ) {

            $user_invalid_msg = !empty( $messages['user_invalid_msg'] ) ? esc_html( $messages['user_invalid_msg'] ) : esc_html__('Sorry, the username you entered is not valid', 'htmega-addons');
            
            return wp_json_encode( [ 'registerauth' =>false, 'message'=> $user_invalid_msg ] );
        }

    }
    if( !empty( $user_data['user_pass'] ) ){
        if ( 5 > strlen( $user_data['user_pass'] ) ) {

            $password_length_msg = !empty( $messages['password_length_msg'] ) ? esc_html( $messages['password_length_msg'] ) : esc_html__('Password length must be greater than 5', 'htmega-addons');
            
            return wp_json_encode( [ 'registerauth' =>false, 'message'=> $password_length_msg ] );
        }
    }

    if ( !is_email( $user_data['user_email'] ) ) {

        $invalid_email_msg = !empty( $messages['invalid_email_msg'] ) ? esc_html( $messages['invalid_email_msg'] ) : esc_html__('Email is not valid', 'htmega-addons');
        
        return wp_json_encode( [ 'registerauth' =>false, 'message'=> $invalid_email_msg ] );
    }
    if ( email_exists( $user_data['user_email'] ) ) {
        $email_exists_msg = !empty( $messages['email_exists_msg'] ) ? esc_html( $messages['email_exists_msg'] ) : esc_html__('Email Already in Use', 'htmega-addons');
        
        return wp_json_encode( [ 'registerauth' =>false, 'message'=> $email_exists_msg ] );
    }
    if( !empty( $user_data['user_url'] ) ){
        if ( !filter_var( $user_data['user_url'], FILTER_VALIDATE_URL ) ) {
            $invalid_url_msg = !empty( $messages['invalid_url_msg'] ) ? esc_html( $messages['invalid_url_msg'] ) : esc_html__('Website is not a valid URL', 'htmega-addons');
            
            return wp_json_encode( [ 'registerauth' =>false, 'message'=> $invalid_url_msg ] );
        }
    }
    return true;

}

/*
 * Redirect 404 page select from plugins options
 */
if( !function_exists('htmega_redirect_404') ){
    function htmega_redirect_404() {
        $errorpage_id = htmega_get_option( 'errorpage','htmega_general_tabs' );
        if ( is_404() && !empty ( $errorpage_id ) ) {
            wp_redirect( esc_url( get_page_link( $errorpage_id ) ) ); die();
        }
    }
    add_action('template_redirect','htmega_redirect_404');
}


/*
 * All list of allowed html tags.
 *
 * @param string $tag_type Allowed levels are title and desc
 * @return array
 */
if ( ! function_exists( 'htmega_get_html_allowed_tags' ) ) {
    function htmega_get_html_allowed_tags($tag_type = 'title') {
        $accept_html_tags = [
            'span'   => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'strong' => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'br'     => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],        
            'b'      => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'sub'    => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'sup'    => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'i'      => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'u'      => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            's'      => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'em'     => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'del'    => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'ins'    => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],

            'code'   => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'mark'   => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'small'  => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'strike' => [
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
            'abbr'   => [
                'title' => [],
                'class' => [],
                'id'    => [],
                'style' => [],
            ],
        ];

        if ('desc' === $tag_type) {
            $desc_tags = [
                'h1' => [
                    'class' => [],
                    'id'    => [],
                    'style' => [],
                ],
                'h2' => [
                    'class' => [],
                    'id'    => [],
                    'style' => [],
                ],
                'h3' => [
                    'class' => [],
                    'id'    => [],
                    'style' => [],
                ],
                'h4' => [
                    'class' => [],
                    'id'    => [],
                    'style' => [],
                ],
                'h5' => [
                    'class' => [],
                    'id'    => [],
                    'style' => [],
                ],
                'h6' => [
                    'class' => [],
                    'id'    => [],
                    'style' => [],
                ],
                'p' => [
                    'class' => [],
                    'id'    => [],
                    'style' => [],
                ],
                'a'       => [
                    'href'  => [],
                    'title' => [],
                    'class' => [],
                    'id'    => [],
                    'style' => [],
                ],
                'q'       => [
                    'cite'  => [],
                    'class' => [],
                    'id'    => [],
                    'style' => [],
                ],
                'img'     => [
                    'src'    => [],
                    'alt'    => [],
                    'height' => [],
                    'width'  => [],
                    'class'  => [],
                    'id'     => [],
                    'title'  => [],
                    'style'  => [],
                ],
                'dfn'     => [
                    'title' => [],
                    'class' => [],
                    'id'    => [],
                    'style' => [],
                ],
                'time'    => [
                    'datetime' => [],
                    'class'    => [],
                    'id'       => [],
                    'style'    => [],
                ],
                'cite'    => [
                    'title' => [],
                    'class' => [],
                    'id'    => [],
                    'style' => [],
                ],
                'acronym' => [
                    'title' => [],
                    'class' => [],
                    'id'    => [],
                    'style' => [],
                ],
                'hr'      => [
                    'class' => [],
                    'id'    => [],
                    'style' => [],
                ],
                'div' => [
                    'class' => [],
                    'id'    => [],
                    'style' => []
                ],
            
                'button' => [
                    'class' => [],
                    'id'    => [],
                    'style' => [],
                ],

            ];

            $accept_html_tags = array_merge($accept_html_tags, $desc_tags);
        }

        return $accept_html_tags;
    }
}
/*
 * Escaping function for allow html tags
 * Title escaping function
 */
if ( ! function_exists( 'htmega_kses_title' ) ) {
    function htmega_kses_title( $string = '' ) {

        if ( ! is_string( $string ) ) {
            $string = ''; 
        }

        return wp_kses( $string, htmega_get_html_allowed_tags( 'title' ) );
    }
}


/*
 * Escaping function for allow html tags
 * Description escaping function
 */
if ( ! function_exists( 'htmega_kses_desc' ) ) {
    function htmega_kses_desc( $string = '' ) {
        if ( ! is_string( $string ) ) {
            $string = ''; 
        }
        return wp_kses( $string, htmega_get_html_allowed_tags( 'desc' ) );
    }
}

/**
 * To show allowed html tags in description
 */
if ( ! function_exists( 'htmega_get_allowed_tag_desc' ) ) {
    function htmega_get_allowed_tag_desc( $tag_type = 'title' ) {
        if (!in_array( $tag_type, ['title', 'desc'] )) {
            $tag_type = 'title';
        }

        $tags_string = '<' . implode('>,<', array_keys(htmega_get_html_allowed_tags( $tag_type ))) . '>';
        return sprintf( /* translators: %s: List of supported HTML tags */ __('This input field supports the following HTML tags: %1$s', 'htmega-addons'), '<code>' . esc_html($tags_string) . '</code>');
    }
}


/**
 * Escaped title html tags
 *
 * @param string $tag input string of title tag
 * @return string $default default tag will be return during no matches
 */
if (!function_exists('htmega_escape_tags')) {
    function htmega_escape_tags($tag, $default = 'span', $extra = [])
    {

        $supports = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p'];

        $supports = array_merge($supports, $extra);

        if (!in_array($tag, $supports, true)) {
            return $default;
        }

        return $tag;
    }
}



/**
 * [htmega_get_page_list]
 * @param  string $post_type
 * @return [array]
 */
if( !function_exists('htmega_get_page_list') ){
function htmega_get_page_list( $post_type = 'page' ){
    $options = array();
    $options['0'] = __('Select','htmega-addons');
    $perpage = -1;
    $all_post = array( 'posts_per_page' => $perpage, 'post_type'=> $post_type );
    $post_terms = get_posts( $all_post );
    if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ){
        foreach ( $post_terms as $term ) {
            $options[ $term->ID ] = $term->post_title;
        }
        return $options;
    }
}
}


/*
 * Instagram feed list
 * return array
 */
if( !function_exists('htmega_instagram_feed_list') ){
    function htmega_instagram_feed_list(){
        global $wpdb;
        $table_name     =  esc_sql( $wpdb->prefix . 'sbi_sources' );
        $feeds_sql      = "SELECT username FROM $table_name WHERE %d";
        $feeds_query    = $wpdb->prepare( $feeds_sql, 1 ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
        $get_feeds      = $wpdb->get_results( $feeds_query, ARRAY_A ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
        $all_feeds      = array();
        if( !empty( $get_feeds ) ){
            foreach($get_feeds as $value){
                $all_feeds[$value['username']] = $value['username'];
            }
        }else{
            $all_feeds['blank'] = "connect instagram account from settings"; 
        }
        return $all_feeds;
    }
}
/*
 * All Taxonomie Category Load
 * return Array
*/
if( !function_exists('all_object_taxonomie_show_catagory') ){
    function all_object_taxonomie_show_catagory($taxonomieName){

        $allTaxonomie =  get_object_taxonomies($taxonomieName);
        if(isset($allTaxonomie['0'])){
            if($allTaxonomie['0'] == "product_type"){
                $allTaxonomie['0'] = 'product_cat';
            }
            return htmega_get_taxonomies($allTaxonomie['0']);
        }
    }
}

/**
 * Get all Authors List
 *
 * @return array
 */
if( !function_exists('htmega_get_authors_list') ){
    function htmega_get_authors_list() {
        $args = [
            'capability'          => [ 'edit_posts' ],
            'has_published_posts' => true,
            'fields'              => [
                'ID',
                'display_name',
            ],
        ];

        // Version check 5.9.
        if ( version_compare( $GLOBALS['wp_version'], '5.9-alpha', '<' ) ) {
            $args['who'] = 'authors';
            unset( $args['capability'] );
        }

        $authors = get_users( $args );

        if ( ! empty( $authors ) ) {
            return wp_list_pluck( $authors, 'display_name', 'ID' );
        }

        return [];
    }
}

/**
 * Get HT Mega Elementor section dashboard icon
 *
 * @return image
 */
if (!function_exists('htmega_get_elementor_section_icon')) {
	function htmega_get_elementor_section_icon() {
		return "<img class='ht-badge-icon' src='".HTMEGA_ADDONS_PL_URL."admin/assets/images/menu-icon-collerd.png' alt='".esc_attr('HT','htmega-addons')."'>";
	}
}

/**
 *  Elementor pro feature notice function
 *
 * @param [type] $repeater/ $this
 * @param [type] $condition_key
 * @param [type] $array_value
 * @param [type] $type Controls_Manager::RAW_HTML
 * @return HTML
 */
function htmega_pro_notice( $repeater,$condition_key, $array_value, $type ){

    $repeater->add_control(
        'update_pro'.$condition_key,
        [
            'type' => $type,
            'raw' => sprintf(/* translators: 1: Opening strong and anchor tags for Pro Version link, 2: Closing anchor and strong tags */
                __('Upgrade to pro version to use this feature %1$s Pro Version %2$s', 'htmega-addons'),
                '<strong><a href="https://wphtmega.com/pricing/" target="_blank">',
                '</a></strong>'),
            'content_classes' => 'htmega-addons-notice',
            'condition' => [
                $condition_key => $array_value,
            ]
        ]
    );
}


/**
 * Get module option value
 * @input section, option_id, option_key, default
 * @return mixed
 */
if( !function_exists('htmega_get_module_option') ) {
    function htmega_get_module_option( $section = '', $option_id = '', $option_key = '', $default = null ){

        $module_settings = get_option( $section );
        
        if( $option_id && is_array( $module_settings ) && count( $module_settings ) > 0 ) {


            if( isset ( $module_settings[ $option_id ] ) && '' != $module_settings[ $option_id ] ) {

                $option_value = json_decode( $module_settings[ $option_id ], true );

                if( $option_key && is_array( $option_value  ) && count( $option_value  ) > 0 ) {

                    if ( isset($option_value[$option_key] ) && '' != $option_value[$option_key] ) {
                        return $option_value[$option_key];
                    } else {
                        return $default;
                    }
                } else {
                    return $module_settings[ $option_id ];
                }
                
            } else {
                return $default;;
            }

        } else {
            return $module_settings;
        }

    }
}

/**
 * Update module option value
 * @input section, option_id, option_key, value
 * @return boolean
 */
if( !function_exists('htmega_update_module_option') ) {
    function htmega_update_module_option( $section = '', $option_id = '', $option_key = '', $value = null ){

        $module_settings = get_option( $section );
        
        if( $option_id && is_array( $module_settings ) && count( $module_settings ) > 0 ) {

            if( isset ( $module_settings[ $option_id ] ) && '' != $module_settings[ $option_id ] ) {

                $option_value = json_decode( $module_settings[ $option_id ], true );

                if( $option_key && is_array( $option_value  ) && count( $option_value  ) > 0 ) {

                    if ( isset($option_value[$option_key] ) && '' != $option_value[$option_key] ) {
                        $option_value[$option_key] = $value;
                    } else {
                        $option_value[$option_key] = $value;
                    }

                    $module_settings[ $option_id ] = json_encode( $option_value );
                } else {
                    $module_settings[ $option_id ] = $value;
                }

                return update_option( $section, $module_settings );
                
            } else {
                return false;
            }

        } else {
            return false;
        }
    }
}
/**
 * [htmega_clean]
 * @param  [JSON] $var
 * @return [array]
 */

 if( !function_exists('htmega_clean') ) {

    function htmega_clean( $var ) {
        if ( is_array( $var ) ) {
            return array_map( 'htmega_clean', $var );
        } else {
            return is_scalar( $var ) ? esc_html( $var ) : $var;
        }
    }
 }

/**
 * [htmega_get_local_file_data]
 * @param  string $file_path
 * @return mixed  $data | false
 */
if ( ! function_exists( 'htmega_get_local_file_data' ) ) {
    function htmega_get_local_file_data( $file_path ) {
        if ( ! file_exists( $file_path ) ) {
            return false;
        }

        // Initialize the WordPress filesystem
        global $wp_filesystem;
        if ( empty( $wp_filesystem ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
            WP_Filesystem();
        }
        
        // Check if the file is readable
        if ( ! is_readable( $file_path ) ) {
            return false;
        }
        
        // Read the file contents using the WP_Filesystem API
        $data = $wp_filesystem->get_contents( $file_path );
        if ( $data === false ) {
            return false;
        }

        return $data;
    }
}

/**
 * [htmega_get_remote_file_data]
 * @param  string $file_url
 * @return mixed  $data | false
 */
if ( ! function_exists( 'htmega_get_remote_file_data' ) ) {
    function htmega_get_remote_file_data( $file_url ) {
        // Using wp_remote_get to fetch the remote file
        $response = wp_remote_get( $file_url );

        // Check if the response contains an error
        if ( is_wp_error( $response ) ) {
            return false;
        }

        // Retrieve the body of the response
        $data = wp_remote_retrieve_body( $response );

        // Check if the body is empty
        if ( empty( $data ) ) {
            return false;
        }

        return $data;
    }
}

/**
 * Summary of htmega_custom_class_modify_litespeed_excludes
 * @param mixed $current_excludes
 * @return mixed
 */
function htmega_custom_class_modify_litespeed_excludes($current_excludes) {
    // image comparison widget support in litespeed cache
    $current_excludes[] = 'beer-slider';
    $current_excludes[] = 'zoom_thumbnail_area';
    $current_excludes[] = 'small-thumb';
    return $current_excludes;
}
add_filter('litespeed_media_lazy_img_parent_cls_excludes', 'htmega_custom_class_modify_litespeed_excludes');

/**
 * Ensure Elementor base frontend styles/scripts are registered before document CSS enqueue.
 *
 * WordPress 6.9+ warns when a stylesheet lists a dependency that is not registered. Theme Builder and
 * template widgets can render `get_builder_content()` before `wp_enqueue_scripts` priority 5 has run.
 */
if ( ! function_exists( 'htmega_elementor_ensure_frontend_dependencies_registered' ) ) {
	function htmega_elementor_ensure_frontend_dependencies_registered() {
		if ( ! class_exists( '\Elementor\Plugin', false ) ) {
			return;
		}
		$plugin = \Elementor\Plugin::instance();
		if ( ! isset( $plugin->frontend ) || ! is_object( $plugin->frontend ) ) {
			return;
		}
		if ( wp_style_is( 'elementor-frontend', 'registered' ) ) {
			return;
		}
		$frontend = $plugin->frontend;
		if ( is_callable( array( $frontend, 'register_scripts' ) ) ) {
			$frontend->register_scripts();
		}
		if ( is_callable( array( $frontend, 'register_styles' ) ) ) {
			$frontend->register_styles();
		}
	}
}

if ( did_action( 'elementor/loaded' ) ) {
	add_action( 'elementor/frontend/before_get_builder_content', 'htmega_elementor_ensure_frontend_dependencies_registered', 1 );
} else {
	add_action(
		'elementor/loaded',
		static function (): void {
			add_action( 'elementor/frontend/before_get_builder_content', 'htmega_elementor_ensure_frontend_dependencies_registered', 1 );
		},
		5
	);
}

/**
 * Enqueue Elementor Post CSS for Theme Builder header/footer templates during {@see 'wp_enqueue_scripts'}.
 *
 * `theme-header.php` prints {@see wp_head()} in `<head>` before the Elementor template renders in the body.
 * Elementor usually registers `elementor-post-{id}` CSS while rendering builder output — after that first
 * `wp_head()` pass. Legacy strip then clears `wp_head` before the theme’s duplicate header runs, so late
 * stylesheet registration never reaches the page. Pre-enqueue fixes missing header/footer styling.
 *
 * Must run during Elementor preview / Theme Builder preview URLs too: {@see htmega_is_editing_mode()} is often true
 * there (`preview->is_preview_mode()` / `is_preview()`), so skipping would drop `elementor-post-{id}` on those requests.
 */
if ( ! function_exists( 'htmega_enqueue_theme_builder_elementor_document_styles' ) ) {
	function htmega_enqueue_theme_builder_elementor_document_styles() {
		if ( is_admin() ) {
			return;
		}
		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}
		if ( ! class_exists( '\Elementor\Core\Files\CSS\Post', false ) ) {
			return;
		}
		if ( ! function_exists( 'htmega_get_theme_builder_header_footer_ids_for_request' ) ) {
			return;
		}

		$placement = htmega_get_theme_builder_header_footer_ids_for_request();
		$doc_ids   = array();
		foreach ( array( 'header', 'footer' ) as $slot ) {
			if ( empty( $placement[ $slot ] ) || '0' === (string) $placement[ $slot ] ) {
				continue;
			}
			$doc_ids[] = absint( $placement[ $slot ] );
		}

		// Single blog template CSS
		if ( is_singular( 'post' ) ) {
			$single_tm_id = htmega_get_module_option( 'htmega_themebuilder_module_settings', 'themebuilder', 'single_blog_page' );
			if ( empty( $single_tm_id ) ) {
				$single_tm_id = htmega_get_option( 'single_blog_page', 'htmegabuilder_templatebuilder_tabs', '0' );
			}
			if ( ! empty( $single_tm_id ) && '0' !== (string) $single_tm_id ) {
				$doc_ids[] = absint( $single_tm_id );
			}
		}

		// Archive blog template CSS
		if ( is_post_type_archive( 'post' ) || ( function_exists( 'htmega_builder_is_blog_page' ) && htmega_builder_is_blog_page() ) ) {
			$archive_tm_id = htmega_get_module_option( 'htmega_themebuilder_module_settings', 'themebuilder', 'archive_blog_page' );
			if ( empty( $archive_tm_id ) ) {
				$archive_tm_id = htmega_get_option( 'archive_blog_page', 'htmegabuilder_templatebuilder_tabs', '0' );
			}
			if ( ! empty( $archive_tm_id ) && '0' !== (string) $archive_tm_id ) {
				$doc_ids[] = absint( $archive_tm_id );
			}
		}

		// Search page template CSS (pro)
		if ( is_search() ) {
			$search_tm_id = htmega_get_module_option( 'htmega_themebuilder_module_settings', 'themebuilder', 'search_page' );
			if ( ! empty( $search_tm_id ) && '0' !== (string) $search_tm_id ) {
				$doc_ids[] = absint( $search_tm_id );
			}
		}

		// 404 error page template CSS (pro)
		if ( is_404() ) {
			$error_tm_id = htmega_get_module_option( 'htmega_themebuilder_module_settings', 'themebuilder', 'error_page' );
			if ( ! empty( $error_tm_id ) && '0' !== (string) $error_tm_id ) {
				$doc_ids[] = absint( $error_tm_id );
			}
		}

		// Coming soon template CSS (pro) — shown to non-logged-in users
		if ( ! is_user_logged_in() ) {
			$comingsoon_tm_id = htmega_get_module_option( 'htmega_themebuilder_module_settings', 'themebuilder', 'coming_soon_page' );
			if ( ! empty( $comingsoon_tm_id ) && '0' !== (string) $comingsoon_tm_id ) {
				$doc_ids[] = absint( $comingsoon_tm_id );
			}
		}

		$doc_ids = array_unique( array_filter( $doc_ids ) );
		if ( empty( $doc_ids ) ) {
			return;
		}

		if ( function_exists( 'htmega_elementor_ensure_frontend_dependencies_registered' ) ) {
			htmega_elementor_ensure_frontend_dependencies_registered();
		}

		foreach ( $doc_ids as $post_id ) {
			if ( ! $post_id ) {
				continue;
			}
			$post_css = new \Elementor\Core\Files\CSS\Post( $post_id );
			$post_css->enqueue();
		}
	}
}
add_action( 'wp_enqueue_scripts', 'htmega_enqueue_theme_builder_elementor_document_styles', 15 );

/**
 * Get template content by id
 * @since 2.6.6
 * @param [type] $template_id
 * @return string
 */
if ( !function_exists('htmega_get_template_content_by_id') ) {
    function htmega_get_template_content_by_id( $template_id ) {
        static $template_cache = [];

        $current_post_id = (int) get_the_ID();
        $cache_key       = $template_id . '_' . $current_post_id;

        if ( isset( $template_cache[ $cache_key ] ) ) {
            return $template_cache[ $cache_key ];
        }

        $template_post = get_post( $template_id );

        if ( $template_post && $template_post->post_status === 'publish' ) {
            $content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id );
        } else {
            $content = esc_html__( 'Template not published or does not exist', 'htmega-addons' );
        }

        $template_cache[ $cache_key ] = $content;

        return $content;
    }
}

if ( ! function_exists('htmega_is_elementor_page') ) {
	/**
	 * Whether a post/page is built with Elementor (uses Elementor document API when available).
	 *
	 * @param int|null $post_id Post ID, or null for the current singular main query object.
	 * @return bool
	 */
	function htmega_is_elementor_page( $post_id = null ) {
		if ( null === $post_id ) {
			if ( ! is_singular() ) {
				return false;
			}
			$post_id = get_queried_object_id();
		}
		$post_id = absint( $post_id );
		if ( ! $post_id ) {
			return false;
		}

		if ( did_action( 'elementor/loaded' ) && class_exists( '\Elementor\Plugin' ) ) {
			$plugin = \Elementor\Plugin::$instance;
			if ( isset( $plugin->documents ) && is_callable( array( $plugin->documents, 'get' ) ) ) {
				$document = $plugin->documents->get( $post_id );
				if ( $document && method_exists( $document, 'is_built_with_elementor' ) ) {
					return (bool) $document->is_built_with_elementor();
				}

				return false;
			}
			if ( isset( $plugin->db ) && is_callable( array( $plugin->db, 'is_built_with_elementor' ) ) ) {
				return (bool) $plugin->db->is_built_with_elementor( $post_id );
			}
		}

		return 'builder' === (string) get_post_meta( $post_id, '_elementor_edit_mode', true );
	}
}

if ( ! function_exists( 'htmega_get_theme_builder_header_footer_ids_for_request' ) ) {
	/**
	 * Resolved HT Builder header/footer template IDs for the current request (matches Header_Footer resolver).
	 *
	 * @return array{header:mixed, footer:mixed}
	 */
	function htmega_get_theme_builder_header_footer_ids_for_request() {
		$pid       = get_queried_object_id();
		$header_id = '';
		$footer_id = '';

		if ( function_exists( 'htmega_get_elementor_setting' ) && $pid && is_singular() ) {
			$page_header = htmega_get_elementor_setting( 'htmegaheader_template', $pid );
			$page_footer = htmega_get_elementor_setting( 'htmegafooter_template', $pid );
			if ( ! empty( $page_header ) && '0' !== (string) $page_header ) {
				$header_id = $page_header;
			}
			if ( ! empty( $page_footer ) && '0' !== (string) $page_footer ) {
				$footer_id = $page_footer;
			}
		}

		if ( '' === $header_id || '0' === (string) $header_id ) {
			$mod_header = htmega_get_module_option( 'htmega_themebuilder_module_settings', 'themebuilder', 'header_page', '' );
			$header_id  = ! empty( $mod_header ) ? $mod_header : ( htmega_get_option( 'header_page', 'htmegabuilder_templatebuilder_tabs', '0' ) ?: '' );
		}
		if ( '' === $footer_id || '0' === (string) $footer_id ) {
			$mod_footer = htmega_get_module_option( 'htmega_themebuilder_module_settings', 'themebuilder', 'footer_page', '' );
			$footer_id  = ! empty( $mod_footer ) ? $mod_footer : ( htmega_get_option( 'footer_page', 'htmegabuilder_templatebuilder_tabs', '0' ) ?: '' );
		}

		return array(
			'header' => $header_id,
			'footer' => $footer_id,
		);
	}
}

if ( ! function_exists( 'htmega_should_enqueue_global_assets' ) ) {
	/**
	 * Whether HT Mega global frontend assets should load on this request (Phase 3 asset gate).
	 *
	 * @return bool
	 */
	function htmega_should_enqueue_global_assets() {
		static $memo = null;
		if ( null !== $memo ) {
			return $memo;
		}
		if ( is_admin() ) {
			$memo = true;

			return $memo;
		}

		$force_standalone = filter_var(
			get_option( 'htmega_force_global_assets', false ),
			FILTER_VALIDATE_BOOLEAN
		);
		if ( (bool) apply_filters( 'htmega_force_global_assets', $force_standalone ) ) {
			$memo = true;

			return $memo;
		}

		$needs = false;
		if ( function_exists( 'htmega_is_editing_mode' ) && htmega_is_editing_mode() ) {
			$needs = true;
		} else {
			$placement = function_exists( 'htmega_get_theme_builder_header_footer_ids_for_request' )
				? htmega_get_theme_builder_header_footer_ids_for_request()
				: array( 'header' => '', 'footer' => '' );
			$hid       = isset( $placement['header'] ) ? $placement['header'] : '';
			$fid       = isset( $placement['footer'] ) ? $placement['footer'] : '';
			if ( ( '' !== (string) $hid && '0' !== (string) $hid ) || ( '' !== (string) $fid && '0' !== (string) $fid ) ) {
				$needs = true;
			} elseif ( function_exists( 'htmega_is_elementor_page' ) && htmega_is_elementor_page( null ) ) {
				$needs = true;
			} elseif ( is_singular( 'post' ) ) {
				$single_tm_id = htmega_get_module_option( 'htmega_themebuilder_module_settings', 'themebuilder', 'single_blog_page' );
				if ( empty( $single_tm_id ) ) {
					$single_tm_id = htmega_get_option( 'single_blog_page', 'htmegabuilder_templatebuilder_tabs', '0' );
				}
				if ( ! empty( $single_tm_id ) && '0' !== (string) $single_tm_id ) {
					$needs = true;
				}
			} elseif ( is_post_type_archive( 'post' ) || ( function_exists( 'htmega_builder_is_blog_page' ) && htmega_builder_is_blog_page() ) ) {
				$archive_tm_id = htmega_get_module_option( 'htmega_themebuilder_module_settings', 'themebuilder', 'archive_blog_page' );
				if ( empty( $archive_tm_id ) ) {
					$archive_tm_id = htmega_get_option( 'archive_blog_page', 'htmegabuilder_templatebuilder_tabs', '0' );
				}
				if ( ! empty( $archive_tm_id ) && '0' !== (string) $archive_tm_id ) {
					$needs = true;
				}
			} elseif ( is_search() ) {
				$search_tm_id = htmega_get_module_option( 'htmega_themebuilder_module_settings', 'themebuilder', 'search_page' );
				if ( ! empty( $search_tm_id ) && '0' !== (string) $search_tm_id ) {
					$needs = true;
				}
			} elseif ( is_404() ) {
				$error_tm_id = htmega_get_module_option( 'htmega_themebuilder_module_settings', 'themebuilder', 'error_page' );
				if ( ! empty( $error_tm_id ) && '0' !== (string) $error_tm_id ) {
					$needs = true;
				}
			} elseif ( ! is_user_logged_in() ) {
				$comingsoon_tm_id = htmega_get_module_option( 'htmega_themebuilder_module_settings', 'themebuilder', 'coming_soon_page' );
				if ( ! empty( $comingsoon_tm_id ) && '0' !== (string) $comingsoon_tm_id ) {
					$needs = true;
				}
			}
		}

		$memo = (bool) apply_filters( 'htmega_should_enqueue_global_assets', $needs );

		return $memo;
	}
}

if ( ! function_exists( 'htmega_is_mega_menu_module_enabled' ) ) {
	/**
	 * True when the Menu Builder / Mega Menu extension is bootstrapped (same rules as class.htmega.php).
	 *
	 * @return bool
	 */
	function htmega_is_mega_menu_module_enabled() {
		static $memo = null;
		if ( null !== $memo ) {
			return $memo;
		}
		if ( 'on' === htmega_get_module_option( 'htmega_megamenu_module_settings', 'megamenubuilder', 'megamenubuilder_enable', 'off' ) ) {
			$memo = true;

			return $memo;
		}
		$legacy_on  = htmega_get_option( 'megamenubuilder', 'htmega_advance_element_tabs', 'off' ) === 'on';
		$empty_mod  = empty( htmega_get_module_option( 'htmega_megamenu_module_settings' ) );
		$memo       = $legacy_on && $empty_mod;

		return $memo;
	}
}

if ( ! function_exists( 'htmega_get_nav_menu_term_ids_with_megamenu_enabled' ) ) {
	/**
	 * Menu terms whose “Enable megamenu?” checkbox is saved in HT Mega nav settings.
	 *
	 * @return int[]
	 */
	function htmega_get_nav_menu_term_ids_with_megamenu_enabled() {
		static $memo = null;
		if ( null !== $memo ) {
			return $memo;
		}
		if ( ! htmega_is_mega_menu_module_enabled() ) {
			$memo = array();

			return $memo;
		}
		$memo = array();
		foreach ( (array) wp_get_nav_menus() as $menu ) {
			if ( empty( $menu->term_id ) ) {
				continue;
			}
			$settings = get_option( 'ht_menu_options_' . absint( $menu->term_id ), array() );
			if ( is_array( $settings ) && isset( $settings['enable_menu'] ) && 'on' === $settings['enable_menu'] ) {
				$memo[] = absint( $menu->term_id );
			}
		}

		return $memo;
	}
}

if ( ! function_exists( 'htmega_is_megamenu_assigned_to_theme_location' ) ) {
	/**
	 * True when a mega-enabled menu is assigned to any registered theme location (typical headers).
	 *
	 * @return bool
	 */
	function htmega_is_megamenu_assigned_to_theme_location() {
		$enabled = htmega_get_nav_menu_term_ids_with_megamenu_enabled();
		if ( empty( $enabled ) ) {
			return false;
		}
		$locations = get_nav_menu_locations();
		if ( empty( $locations ) || ! is_array( $locations ) ) {
			return false;
		}
		foreach ( $locations as $menu_term_id ) {
			if ( $menu_term_id && in_array( absint( $menu_term_id ), $enabled, true ) ) {
				return true;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'htmega_has_active_mega_menu' ) ) {
	/**
	 * Frontend: mega nav is expected to render (classic theme menus). Filter to override detection.
	 *
	 * Use `add_filter( 'htmega_has_active_mega_menu', '__return_true' )` when the menu prints without `theme_location`.
	 *
	 * @return bool
	 */
	function htmega_has_active_mega_menu() {
		static $memo = null;
		if ( null !== $memo ) {
			return $memo;
		}
		if ( is_admin() ) {
			$memo = false;

			return $memo;
		}
		if ( ! htmega_is_mega_menu_module_enabled() ) {
			$memo = false;

			return $memo;
		}

		$detected = htmega_is_megamenu_assigned_to_theme_location();
		$memo     = (bool) apply_filters( 'htmega_has_active_mega_menu', $detected );

		return $memo;
	}
}

if ( ! function_exists( 'htmega_should_load_frontend_mega_menu_assets' ) ) {
	/**
	 * Mega menu stylesheet/script + inline customization on this request (full globals or mega companion path).
	 *
	 * @return bool
	 */
	function htmega_should_load_frontend_mega_menu_assets() {
		if ( function_exists( 'htmega_should_enqueue_global_assets' ) && htmega_should_enqueue_global_assets() ) {
			return true;
		}

		return function_exists( 'htmega_has_active_mega_menu' ) && htmega_has_active_mega_menu();
	}
}

if ( ! function_exists( 'htmega_enqueue_mega_menu_companion_pack' ) ) {
	/**
	 * Slim HT Mega bundle so Elementor-built mega dropdowns (htb/grid) resolve on non-Elementor screens.
	 * Handles are registered in HTMega_Elementor_Addons_Assests::register_assets().
	 */
	function htmega_enqueue_mega_menu_companion_pack() {
		if ( ! apply_filters( 'htmega_should_enqueue_mega_menu_companion_pack', true ) ) {
			return;
		}

		do_action( 'htmega_enqueue_mega_menu_companion_assets' );

		wp_enqueue_style( 'htbbootstrap' );
		wp_enqueue_script( 'htbbootstrap' );
		wp_enqueue_script( 'waypoints' );

		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			wp_enqueue_style( 'htmega-global-style' );
			wp_enqueue_script( 'htmega-widgets-scripts' );
		} else {
			wp_enqueue_style( 'htmega-global-style-min' );
			wp_enqueue_script( 'htmega-widgets-scripts-min' );
		}

		wp_enqueue_style( 'htmega-animation' );
		wp_enqueue_style( 'htmega-keyframes' );

		if ( wp_style_is( 'elementor-frontend', 'registered' ) ) {
			wp_enqueue_style( 'elementor-frontend' );
		}

		do_action( 'htmega_after_mega_menu_companion_pack' );
	}
}

if ( ! function_exists( 'htmega_get_module_option2' ) ) {
    function htmega_get_module_option2( $option_name ) {
        $options = get_option('htmega_advance_element_tabs');
        return isset($options[$option_name]) ? $options[$option_name] : null;
    }
}

if ( ! function_exists( 'htmega_is_legacy_mode' ) ) {
    /**
     * Master legacy-mode filter (Phase 0). Return true via add_filter to favor old behavioural paths once toggles exist downstream.
     *
     * @return bool
     */
    function htmega_is_legacy_mode() {
        static $cached = null;
        if ( null === $cached ) {
            $cached = (bool) apply_filters( 'htmega_legacy_mode', false );
        }
        return $cached;
    }
}

if ( ! function_exists( 'htmega_is_pro_active' ) ) {
    /**
     * Cached HT Mega Pro activation check (Phase 0 helper).
     *
     * @return bool
     */
    function htmega_is_pro_active() {
        static $active = null;
        if ( null === $active ) {
            if ( ! function_exists( 'is_plugin_active' ) ) {
                require_once ABSPATH . 'wp-admin/includes/plugin.php';
            }
            $active = is_plugin_active( 'htmega-pro/htmega_pro.php' );
        }

        return $active;
    }
}

if ( ! function_exists( 'htmega_safe_hex_color' ) ) {
	/**
	 * Normalize a hex color to #rgb or #rrggbb for safe CSS interpolation.
	 *
	 * @param string $hex Raw value (may include leading #).
	 * @return string Empty if invalid.
	 */
	function htmega_safe_hex_color( $hex ) {
		$hex = strtolower( trim( (string) $hex ) );
		$hex = ltrim( $hex, '#' );
		if ( preg_match( '/^[0-9a-f]{3}$/', $hex ) || preg_match( '/^[0-9a-f]{6}$/', $hex ) ) {
			return '#' . $hex;
		}
		return '';
	}
}

if ( ! function_exists( 'htmega_sanitize_menu_icon_classes' ) ) {
	/**
	 * Space-separated Font Awesome / icon classes hardened for class attributes.
	 *
	 * @param string $class_string Raw class list.
	 */
	function htmega_sanitize_menu_icon_classes( $class_string ) {
		$parts = preg_split( '/\s+/', trim( (string) $class_string ), -1, PREG_SPLIT_NO_EMPTY );
		$sanitized = array();
		foreach ( $parts as $part ) {
			$c = sanitize_html_class( $part );
			if ( '' !== $c ) {
				$sanitized[] = $c;
			}
		}

		return implode( ' ', array_unique( $sanitized ) );
	}
}

if ( ! function_exists( 'htmega_sanitize_simple_css_px' ) ) {
	/**
	 * Numeric pixel-ish value for width/offset (digits and optional decimal).
	 *
	 * @param mixed $value Raw.
	 */
	function htmega_sanitize_simple_css_px( $value ) {
		if ( ! is_numeric( $value ) ) {
			return '';
		}

		return (string) round( (float) $value, 2 );
	}
}

if ( ! function_exists( 'htmega_sanitize_module_color_for_inline_css' ) ) {
	/**
	 * Restrict module option strings embedded in frontend CSS (#hex / basic rgb/rgba).
	 *
	 * @param string $color Raw color token.
	 */
	function htmega_sanitize_module_color_for_inline_css( $color ) {
		$color = trim( wp_strip_all_tags( (string) $color ) );
		if ( '' === $color ) {
			return '';
		}

		if ( '#' === substr( $color, 0, 1 ) ) {
			$c = sanitize_hex_color( $color );
			return is_string( $c ) ? $c : '';
		}

		if ( preg_match( '/^rgba?\(\s*[0-9]{1,3}\s*(?:,\s*[0-9]{1,3}\s*){2}(?:,\s*(?:0|1|0?\.\d+)\s*)?\)$/i', $color ) ) {
			return $color;
		}

		return '';
	}
}

if ( ! function_exists( 'htmega_walker_submenu_wrapper_style_attr' ) ) {
	/**
	 * First-level submenu ul inline width/offset.
	 *
	 * @param string|int|float $menuwidth Walker state width.
	 * @param string|int|float $menupos   Walker state left offset.
	 */
	function htmega_walker_submenu_wrapper_style_attr( $menuwidth, $menupos ) {
		$w     = htmega_sanitize_simple_css_px( $menuwidth );
		$l     = htmega_sanitize_simple_css_px( $menupos );
		$style = '';
		if ( '' !== $w ) {
			$style .= 'width:' . $w . 'px;';
		}
		if ( '' !== $l ) {
			$style .= 'left:' . $l . 'px;';
		}

		return '' !== $style ? 'style="' . esc_attr( $style ) . '"' : '';
	}
}

if ( ! function_exists( 'htmega_walker_menu_icon_markup' ) ) {
	/**
	 * Front-end menu item icon HTML.
	 *
	 * @param object $item WP nav menu item with HT Mega fields.
	 */
	function htmega_walker_menu_icon_markup( $item ) {
		if ( empty( $item->ficon ) ) {
			return '';
		}
		$icons = substr( $item->ficon, 0, 3 );
		$icons = str_replace( $icons, $icons . ' ', $item->ficon );
		$icon_style = '';
		if ( ! empty( $item->ficoncolor ) ) {
			$safe = htmega_safe_hex_color( $item->ficoncolor );
			if ( $safe ) {
				$icon_style .= 'color:' . $safe . ';';
			}
		}
		$class_list = htmega_sanitize_menu_icon_classes( $icons );
		if ( '' === $class_list ) {
			return '';
		}

		return '<i class="' . esc_attr( $class_list ) . '" style="' . esc_attr( $icon_style ) . '"></i>';
	}
}

if ( ! function_exists( 'htmega_walker_menu_badge_markup' ) ) {
	/**
	 * Menu badge / tag span.
	 *
	 * @param object $item Nav menu item.
	 */
	function htmega_walker_menu_badge_markup( $item ) {
		if ( empty( $item->menutag ) ) {
			return '';
		}
		$badge_style   = '';
		$badge_bg_type = isset( $item->badge_bg_type ) ? $item->badge_bg_type : '';
		$bg_two        = isset( $item->badge_bg_color_two ) ? $item->badge_bg_color_two : '';

		if ( ! empty( $item->menutagcolor ) ) {
			$c = htmega_safe_hex_color( $item->menutagcolor );
			if ( $c ) {
				$badge_style .= 'color:' . $c . ';';
			}
		}
		if ( 'gradient' === $badge_bg_type ) {
			$c1 = htmega_safe_hex_color( isset( $item->menutagbgcolor ) ? $item->menutagbgcolor : '' );
			$c2 = htmega_safe_hex_color( $bg_two );
			if ( $c1 && $c2 ) {
				$badge_style .= 'background-image:linear-gradient(45deg,' . $c1 . ' 0%,' . $c2 . ' 100%);';
			}
		} elseif ( ! empty( $item->menutagbgcolor ) ) {
			$bg = htmega_safe_hex_color( $item->menutagbgcolor );
			if ( $bg ) {
				$badge_style .= 'background-color:' . $bg . ';';
			}
		}

		return '<span class="htmenu-menu-tag" style="' . esc_attr( $badge_style ) . '">' . esc_html( $item->menutag ) . '</span>';
	}
}

if ( ! function_exists( 'htmega_walker_menu_item_title' ) ) {
	/**
	 * Filtered nav title with optional kses lock-down.
	 *
	 * @param object $item Nav menu item.
	 */
	function htmega_walker_menu_item_title( $item ) {
		$title = apply_filters( 'the_title', $item->title, $item->ID );

		return wp_kses_post( $title );
	}
}

if ( ! function_exists( 'htmega_walker_megamenu_wrap_markup' ) ) {
	/**
	 * Mega menu dropdown content wrapper markup.
	 *
	 * @param object $item           Nav menu item.
	 * @param string $buildercontent Template HTML output.
	 */
	function htmega_walker_megamenu_wrap_markup( $item, $buildercontent ) {
		$styles = '';
		if ( isset( $item->menuposition ) && is_numeric( $item->menuposition ) ) {
			$p = htmega_sanitize_simple_css_px( $item->menuposition );
			if ( '' !== $p ) {
				$styles .= 'left:' . $p . 'px;';
			}
		}
		if ( isset( $item->menuwidth ) && is_numeric( $item->menuwidth ) ) {
			$w = htmega_sanitize_simple_css_px( $item->menuwidth );
			if ( '' !== $w ) {
				$styles .= 'width:' . $w . 'px;';
			}
		}

		return sprintf(
			'<div class="htmegamenu-content-wrapper sub-menu" style="%1$s">%2$s</div>',
			esc_attr( $styles ),
			$buildercontent
		);
	}
}

/**
 * Get plugin missing notice
 *
 * @param string $plugin
 * @return void
 */
if ( ! function_exists( 'htmega_plugin_missing_alert' ) ) {
function htmega_plugin_missing_alert($plugin) {
        if (current_user_can('activate_plugins') && $plugin) {
            printf(
                '<div %s>%s</div>',
                'style="margin: 1rem;padding: 1rem 1.25rem;border-left: 5px solid #ffe58f;color: rgb(0 0 0 / 88%);background-color: #fffbe6;"',
                $plugin . __(' is missing! Please install and activate ', 'htmega-addons') . $plugin . '.'
            );
        }
    }
}