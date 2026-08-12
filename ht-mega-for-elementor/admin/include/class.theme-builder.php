<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class HTMega_Theme_Builder {
    
    private static $_instance = null;
    private $template_types = [];
    private $pro_template_types = ['search_page', 'error_page', 'coming_soon_page'];
    
    const CPT = 'htmega_theme_builder';
    const TAB_BASE = "edit.php?post_type=htmega_theme_builder";

    /**
     * Get Instance
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    /**
     * Constructor
     */
    public function __construct() {
        // Register core functionality without translations first
        $this->register_post_type_args();
        
        // Initialize template types and other functionality on init
        add_action('init', [$this, 'init_plugin'], 0);
        
        // Admin and AJAX handlers (these don't need early initialization)
        add_action('admin_menu', [$this, 'add_submenu'], 225);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
        
        // AJAX handlers
        add_action('wp_ajax_htmega_create_template', [$this, 'ajax_create_template']);
        add_action('wp_ajax_htmega_manage_default_template', [$this, 'manage_template_status']);
        add_action('wp_ajax_htmega_template_import', [$this, 'template_import']);
        add_action('wp_ajax_htmega_trash_templates', [$this, 'ajax_trash_templates']);

        // Row and bulk actions
        add_filter('post_row_actions', [$this, 'filter_post_row_actions'], 10, 2);
        add_filter('bulk_actions-edit-' . self::CPT, [$this, 'register_bulk_actions']);
    }

    /**
     * Initialize all plugin functionality that requires translations
     */
    public function init_plugin() {
        $this->initialize_template_types();
        $this->register_post_type();
        
        // Template filters
        add_filter('query_vars', [$this, 'add_query_vars_filter']);
        add_filter('views_edit-' . self::CPT, [$this, 'admin_print_tabs']);
        add_action('pre_get_posts', [$this, 'query_filter']);

        // Admin columns
        add_filter('manage_' . self::CPT . '_posts_columns', [$this, 'admin_columns_headers']);
        add_action('manage_' . self::CPT . '_posts_custom_column', [$this, 'admin_columns_content'], 10, 2);

        // Template creation
        add_action('admin_action_htmega_new_template', [$this, 'admin_action_new_template']);
    }

    /**
     * Register post type arguments without translations
     */
    private function register_post_type_args() {
        register_post_type(self::CPT, [
            'public' => true,
            'show_in_menu' => false,
            'rewrite' => false,
            'show_in_nav_menus' => false,
            'show_in_admin_bar' => false,
            'exclude_from_search' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'supports' => ['title', 'editor', 'revisions'],
            'menu_icon' => 'dashicons-admin-page',
        ]);
    }

    /**
     * Register post type with translations
     */
    public function register_post_type() {
        $labels = [
            'name' => __('HT Mega Templates', 'ht-mega-for-elementor'),
            'singular_name' => __('Template', 'ht-mega-for-elementor'),
            'add_new' => __('Add New', 'ht-mega-for-elementor'),
            'add_new_item' => __('Add New Template', 'ht-mega-for-elementor'),
            'edit_item' => __('Edit Template', 'ht-mega-for-elementor'),
            'new_item' => __('New Template', 'ht-mega-for-elementor'),
            'all_items' => __('All Templates', 'ht-mega-for-elementor'),
            'view_item' => __('View Template', 'ht-mega-for-elementor'),
            'search_items' => __('Search Templates', 'ht-mega-for-elementor'),
            'not_found' => __('No templates found', 'ht-mega-for-elementor'),
            'not_found_in_trash' => __('No templates found in trash', 'ht-mega-for-elementor'),
            'menu_name' => __('Templates', 'ht-mega-for-elementor'),
        ];

        $args = [
            'labels' => $labels,
            'public' => true,
            'show_in_menu' => false,
            'rewrite' => false,
            'show_in_nav_menus' => false,
            'show_in_admin_bar' => false,
            'exclude_from_search' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'supports' => ['title', 'editor', 'revisions','elementor'],
            'menu_icon' => 'dashicons-admin-page',
        ];

        register_post_type(self::CPT, $args);
    }

    /**
     * Initialize template types
     */
    public function initialize_template_types() {
        $this->template_types = [
            'header_page' => __('Header', 'ht-mega-for-elementor'),
            'footer_page' => __('Footer', 'ht-mega-for-elementor'),
            'single_blog_page' => __('Single', 'ht-mega-for-elementor'),
            'archive_blog_page' => __('Blog', 'ht-mega-for-elementor'),
            'search_page' => __('Search', 'ht-mega-for-elementor'),
            'error_page' => __('404', 'ht-mega-for-elementor'),
            'coming_soon_page' => __('Coming Soon', 'ht-mega-for-elementor')
        ];
    }

    /**
     * Add submenu
     */
    public function add_submenu() {
        add_submenu_page(
            'htmega-addons',
            __('Theme Builder', 'ht-mega-for-elementor'),
            __('Theme Builder', 'ht-mega-for-elementor'),
            'manage_options',
            'edit.php?post_type=' . self::CPT
        );
    }

    /**
     * Add query vars
     */
    public function add_query_vars_filter($vars) {
        $vars[] = 'template_type';
        return $vars;
    }

    /**
     * Query filter
     */
    public function query_filter($query) {
        if (!is_admin() || !$query->is_main_query()) {
            return;
        }

        if (self::CPT !== $query->get('post_type')) {
            return;
        }

        // phpcs:disable WordPress.Security.NonceVerification.Recommended -- read-only: only narrows the admin list-table query (pre_get_posts) to filter which existing templates are displayed; no data is written. Page itself requires edit_posts capability for this CPT.
        if (!empty($_GET['template_type'])) {
            $query->set('meta_key', '_htmega_template_type');
            $query->set('meta_value', sanitize_text_field(wp_unslash($_GET['template_type'])));
        }
        // phpcs:enable WordPress.Security.NonceVerification.Recommended
    }

    /**
     * Check if current screen is this post type
     */
    private function is_current_screen() {
        if (!function_exists('get_current_screen')) {
            return false;
        }

        $screen = get_current_screen();
        return $screen && $screen->post_type === self::CPT;
    }

    /**
     * Admin columns headers
     */
    public function admin_columns_headers($columns) {
        $date_column = $columns['date'];
        unset($columns['date']);

        $columns['setdefault'] 	= esc_html__('Default', 'ht-mega-for-elementor');
        $columns['type'] = __('Type', 'ht-mega-for-elementor');
        $columns['date'] = $date_column;

        return $columns;
    }

    /**
     * Admin columns content
     */
    public function admin_columns_content($column_name, $post_id) {
        if ('type' === $column_name) {
            $type = get_post_meta($post_id, '_htmega_template_type', true);
            if (isset($this->template_types[$type])) {
                echo '<a class="column-tmptype" href="' . esc_url(admin_url(self::TAB_BASE . '&template_type=' . $type)) . '">' . esc_html($this->template_types[$type]) . '</a>';
            }
        }

        if ('setdefault' === $column_name) {
            $type = get_post_meta($post_id, '_htmega_template_type', true);

            if (!$type || !isset($this->template_types[$type])) {
                return;
            }
            //$type = $this->get_template_option_key( $type );

           $value = $this->get_default_template_id($type);
            
            $checked = checked($value, $post_id, false);
            echo '<label class="htmega-default-tmp-status-switch" id="htmega-default-tmp-status-'.esc_attr( $type ).'-'.esc_attr( $post_id ).'"><input class="htmega-status-'.esc_attr( $type ).'" id="htmega-default-tmp-status-'.esc_attr( $type ).'-'.esc_attr( $post_id ).'" type="checkbox" value="'.esc_attr( $post_id ).'" '.$checked.'/><span><span>'.esc_html__('NO','ht-mega-for-elementor').'</span><span>'.esc_html__('YES','ht-mega-for-elementor').'</span></span><a>&nbsp;</a></label>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }

    /**
     * Get default template id
     */
    public function get_default_template_id($type) {
        $settings = get_option('htmega_themebuilder_module_settings');
        $template_data = isset($settings['themebuilder']) ? json_decode($settings['themebuilder'], true) : [];
        return isset($template_data[$type]) ? $template_data[$type] : '0';
    }

    /**
     * Get template type
     */
    public function get_template_type($post_id) {
        return get_post_meta($post_id, '_htmega_template_type', true);
    }

    /**
     * Admin print tabs
     */
    public function admin_print_tabs($views) {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only: value is only used to decide which nav-tab is marked active and to compare against known template-type keys; no data is written. Page itself requires edit_posts capability for this CPT.
        $current_type = isset($_GET['template_type']) ? sanitize_text_field(wp_unslash($_GET['template_type'])) : '';
        ?>
        <div id="htmega-template-tabs-wrapper" class="nav-tab-wrapper">
            <div class="htmega-menu-area">
                <a class="nav-tab <?php echo !$current_type ? 'nav-tab-active' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- constrained to hardcoded literal 'nav-tab-active' or '' ?>"
                    href="<?php echo esc_url( admin_url(self::TAB_BASE) ); ?>">
                        <?php esc_html_e('All', 'ht-mega-for-elementor'); ?>
                    </a>
                    <?php foreach ($this->template_types as $type => $label) : 
                    $active = ($current_type === $type) ? 'nav-tab-active' : '';
                    $url = admin_url(self::TAB_BASE . '&template_type=' . $type);
                    $is_pro = in_array($type, $this->pro_template_types);
                    ?>
                    <a class="nav-tab <?php echo $active; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- constrained to hardcoded literal 'nav-tab-active' or '' ?> <?php echo $is_pro ? 'htmega-pro-tab' : ''; ?>"
                       href="<?php echo $is_pro ? '#' : esc_url($url); ?>"
                       <?php echo $is_pro ? 'data-template-type="' . esc_attr($type) . '"' : ''; ?>>
                        <?php echo esc_html($label); ?>
                        <?php if ($is_pro) : ?>
                            <span class="htmega-pro-badge"><?php esc_html_e('Pro', 'ht-mega-for-elementor'); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
			</div>

            <div class="htmega-template-importer">
                <button class="button button-primary" id="htmega-import-template-trigger">
                    <span class="dashicons dashicons-download"></span>
                    <span class="htmega-template-importer-btn-text"><?php esc_html_e('Import Previously Assigned Templates', 'ht-mega-for-elementor'); ?></span>
                </button>
            </div>
        </div>
        <?php
        return $views;
    }

    /**
     * Admin action new template
     */
    public function admin_action_new_template() {
        if (!current_user_can('manage_options')) {
            return;
        }

        // Genuine state change (creates a new template post) reachable via a plain GET admin_action hook.
        // No part of this plugin currently links to this action, so this nonce check adds CSRF protection
        // with no impact on any existing flow; any caller must now append a valid `_wpnonce` (see wp_nonce_url()).
        check_admin_referer( 'htmega_new_template_action' );

        $template_type = isset( $_GET['template_type'] ) ? sanitize_text_field( wp_unslash( $_GET['template_type'] ) ) : '';

        if ( '' === $template_type || ! isset( $this->template_types[ $template_type ] ) ) {
            wp_die( esc_html__( 'Template type not found.', 'ht-mega-for-elementor' ) );
        }

        $template_title = isset($_GET['template_title']) ? sanitize_text_field( wp_unslash( $_GET['template_title'] ) ) : '';

        if (empty($template_title)) {
            $template_title = ucwords($template_type) . ' ' . __('Template', 'ht-mega-for-elementor');
        }

        $template_data = [
            'post_title' => $template_title,
            'post_status' => 'publish',
            'post_type' => self::CPT,
        ];

        $template_id = wp_insert_post($template_data);

        if (!is_wp_error($template_id)) {
            update_post_meta($template_id, '_htmega_template_type', $template_type);
            update_post_meta($template_id, '_wp_page_template', 'elementor_canvas');
            update_post_meta($template_id, '_elementor_edit_mode', 'builder');
            update_post_meta($template_id, '_elementor_template_type', $template_type);
            update_post_meta($template_id, '_elementor_data', '[]');

            $edit_url = add_query_arg(
                [
                    'post' => $template_id,
                    'action' => 'elementor',
                ],
                admin_url('post.php')
            );

            wp_safe_redirect($edit_url);
            exit;
        }
    }

    /**
     * Filter post row actions
     */
    public function filter_post_row_actions($actions, $post) {
        if (self::CPT !== $post->post_type) {
            return $actions;
        }
        
        // Ensure the trash action is present
        if (current_user_can('delete_post', $post->ID)) {
            if (!isset($actions['trash'])) {
                $actions['trash'] = sprintf(
                    '<a href="%s" class="submitdelete" aria-label="%s">%s</a>',
                    get_delete_post_link($post->ID),
                    /* translators: %s: post title */
                    esc_attr(sprintf(__('Move &#8220;%s&#8221; to the Trash', 'ht-mega-for-elementor'), $post->post_title)),
                    _x('Trash', 'verb', 'ht-mega-for-elementor')
                );
            }
        }
        
        return $actions;
    }
    
    /**
     * Register bulk actions
     */
    public function register_bulk_actions($bulk_actions) {
        $bulk_actions['trash'] = __('Move to Trash', 'ht-mega-for-elementor');
        return $bulk_actions;
    }
    
    /**
     * Handle bulk actions
     */
    public function handle_bulk_actions($redirect_to, $action, $post_ids) {
        if ($action !== 'trash') {
            return $redirect_to;
        }

        $trashed = 0;
        foreach ($post_ids as $post_id) {
            // Verify post type
            $post = get_post($post_id);
            if ($post && $post->post_type === self::CPT) {
                if (wp_trash_post($post_id)) {
                    $trashed++;
                }
            }
        }

        if ($trashed > 0) {
            $redirect_to = add_query_arg(
                array(
                    'trashed' => $trashed,
                    'ids' => join(',', $post_ids),
                ),
                $redirect_to
            );
        }

        return $redirect_to;
    }

    /**
     * AJAX handler for creating new template
     */
    public function ajax_create_template() {
        check_ajax_referer('htmega_template_builder_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('Permission denied', 'ht-mega-for-elementor'));
            return;
        }

        $template_type = isset($_POST['template_type']) ? sanitize_text_field( wp_unslash( $_POST['template_type'] ) ) : '';
        $template_name = isset($_POST['template_name']) ? sanitize_text_field( wp_unslash( $_POST['template_name'] ) ) : '';
        $set_as_default = isset($_POST['set_as_default']) ? filter_var( wp_unslash( $_POST['set_as_default'] ), FILTER_VALIDATE_BOOLEAN ) : false;
        $selected_template = isset($_POST['selected_template']) ? sanitize_text_field(wp_unslash($_POST['selected_template'])) : '';

        if (!$template_type || !isset($this->template_types[$template_type])) {
            wp_send_json_error(__('Invalid template type', 'ht-mega-for-elementor'));
            return;
        }

        if (!$template_name) {
            wp_send_json_error(__('Template name is required', 'ht-mega-for-elementor'));
            return;
        }

        $post_id = wp_insert_post([
            'post_title'  => $template_name,
            'post_status' => 'publish',
            'post_type'   => self::CPT,
        ]);

        if (is_wp_error($post_id)) {
            wp_send_json_error($post_id->get_error_message());
            return;
        }

        // Add template metadata
        update_post_meta($post_id, '_htmega_template_type', $template_type);
        update_post_meta($post_id, '_wp_page_template', 'elementor_canvas');
        update_post_meta($post_id, '_elementor_edit_mode', 'builder');
        update_post_meta($post_id, '_elementor_template_type', $template_type);
        
        $saved_builder_markup = false;

        // Same pipeline as Elementor Template Library (`get_htmega_template_data` → Library_Source::get_data): enables widgets/modules, replaces IDs, processes import content against this document.
        if (
            '' !== $selected_template
            && class_exists( '\Elementor\Plugin', false )
            && class_exists( '\HtMeaga\ElementorTemplate\Elementor_Library_Manage', false )
        ) {
            $db = \Elementor\Plugin::$instance->db;
            $db->switch_to_post( $post_id );
            try {
                $result = \HtMeaga\ElementorTemplate\Elementor_Library_Manage::instance()->get_template_data(
                    array(
                        'template_id'    => $selected_template,
                        'editor_post_id' => $post_id,
                    )
                );
                if ( is_array( $result ) && ! empty( $result['content'] ) && is_array( $result['content'] ) ) {
                    update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( $result['content'] ) ) );
                    if ( ! empty( $result['page_settings'] ) && is_array( $result['page_settings'] ) ) {
                        update_post_meta( $post_id, '_elementor_page_settings', $result['page_settings'] );
                    }
                    if ( ! empty( $result['page_template'] ) ) {
                        update_post_meta( $post_id, '_wp_page_template', $result['page_template'] );
                    }
                    $saved_builder_markup = true;
                }
            } catch ( \Exception $e ) {
                // Leave canvas empty; Library_Source may throw on invalid remote payloads.
            } finally {
                if ( method_exists( $db, 'restore_current_post' ) ) {
                    $db->restore_current_post();
                }
            }
        }

        if ( ! $saved_builder_markup ) {
            update_post_meta( $post_id, '_elementor_data', '[]' );
        }
        
        // Handle set as default ONLY if checkbox is checked
        if ($set_as_default === true) {
            htmega_update_module_option('htmega_themebuilder_module_settings', 'themebuilder', 'themebuilder_enable', 'on');  
            htmega_update_module_option('htmega_themebuilder_module_settings', 'themebuilder', $template_type, (string)$post_id);
        }

        // Return success with edit URL
        $edit_url = add_query_arg(
            [
                'action' => 'elementor',
                'post' => $post_id,
            ],
            admin_url('post.php')
        );

        wp_send_json_success([
            'template_id' => $post_id,
            'edit_url' => $edit_url,
        ]);
    }

    /**
     * Manage template default status
     */
    public function manage_template_status() {
        // Verify nonce
        if (!check_ajax_referer('htmega_template_builder_nonce', 'nonce', false)) {
            wp_send_json_error(__('Invalid nonce', 'ht-mega-for-elementor'));
            return;
        }

        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('You do not have permission to perform this action', 'ht-mega-for-elementor'));
            return;
        }

        $template_id = isset( $_POST['template_id'] ) ? sanitize_text_field( wp_unslash( $_POST['template_id'] ) ) : '';
        $type         = isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : '';

        if (!isset($this->template_types[$type])) {
            wp_send_json_error(__('Invalid template type', 'ht-mega-for-elementor'));
            return;
        }

        $current_value = $this->get_default_template_id($type);

        // If this template is being enabled
        if ($current_value != $template_id) {
            htmega_update_module_option('htmega_themebuilder_module_settings','themebuilder', 'themebuilder_enable', 'on');  
            htmega_update_module_option('htmega_themebuilder_module_settings','themebuilder', $type, $template_id);          
            wp_send_json_success(array(
                'message' => __('Default template updated', 'ht-mega-for-elementor')
            ));
        } else {
            htmega_update_module_option('htmega_themebuilder_module_settings','themebuilder', 'themebuilder_enable', 'on');  
            htmega_update_module_option('htmega_themebuilder_module_settings','themebuilder',$type, '0');
            wp_send_json_success(array(
                'message' => __('Default template removed', 'ht-mega-for-elementor'),
                'templates' => array()
            ));
        }
    }

    /**
     * Template Import
     */
    public function template_import() {
        if ( isset( $_POST ) ) {
            
            if ( !current_user_can('manage_options') ) {
                wp_send_json_error(array(
                    'message' => __('You are unauthorized to import templates!', 'ht-mega-for-elementor')
                ));
                return;
            }
            
            if ( !check_ajax_referer('htmega_template_builder_nonce', 'nonce', false) ) {
                wp_send_json_error(array(
                    'message' => __('Nonce verification failed!', 'ht-mega-for-elementor')
                ));
                return;
            }

            $settings = get_option('htmega_themebuilder_module_settings');
            $template_data = isset($settings['themebuilder']) ? json_decode($settings['themebuilder'], true) : [];
            $imported_templates = [];

            if (is_array($template_data)) {
                foreach ($this->template_types as $type => $label) {
                    if (isset($template_data[$type]) && !empty($template_data[$type]) && $template_data[$type] !== '0') {
                        $template_id = $template_data[$type];
                        
                        // Check if template exists
                        $template_query = new \WP_Query([
                            'p' => $template_id,
                            'post_type' => ['elementor_library', self::CPT],
                            'post_status' => 'any'
                        ]);
                        wp_reset_postdata();

                        if ($template_query->have_posts()) {
                            $template = $template_query->posts[0];
                            
                            // Only update if it's not already our post type
                            if ($template->post_type !== self::CPT) {
                                // Update post type
                                $args = [
                                    'ID' => $template_id,
                                    'post_type' => self::CPT,
                                ];
                                $update_id = wp_update_post($args);

                                if (!is_wp_error($update_id)) {
                                    // Update template type
                                    update_post_meta($update_id, '_htmega_template_type', $type);
                                    $imported_templates[] = [
                                        'type' => $type,
                                        'id' => $update_id
                                    ];
                                }
                            }
                        }
                    }
                }
            }

            wp_send_json_success([
                'message' => __('Templates have been imported successfully', 'ht-mega-for-elementor'),
                'templates' => $imported_templates
            ]);

        } else {
            wp_send_json_error([
                'message' => __('Something went wrong!', 'ht-mega-for-elementor')
            ]);
            return;
        }
    }

    /**
     * Handle AJAX trash templates request
     */
    public function ajax_trash_templates() {
        // Verify nonce
        if (!check_ajax_referer('htmega_template_builder_nonce', 'nonce', false)) {
            wp_send_json_error(__('Invalid nonce', 'ht-mega-for-elementor'));
            return;
        }

        // Check administrator capability
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('Permission denied', 'ht-mega-for-elementor'));
            return;
        }

        // Get template IDs
        $template_ids = isset($_POST['template_ids']) ? array_map('intval', $_POST['template_ids']) : [];
        if (empty($template_ids)) {
            wp_send_json_error(__('No templates selected', 'ht-mega-for-elementor'));
            return;
        }

        $trashed = 0;
        foreach ($template_ids as $template_id) {
            // Verify post type is elementor_library
            $post_type = get_post_type($template_id);
            
            if ($post_type !== self::CPT) {
                continue;
            }

            // Check if user is template author or admin
            $post = get_post($template_id);
            if (!current_user_can('manage_options') && $post->post_author != get_current_user_id()) {
                continue;
            }

            if (wp_trash_post($template_id)) {
                $trashed++;
            }
        }

        if ($trashed > 0) {
            wp_send_json_success([
                'message' => sprintf(
                    /* translators: %s: number of templates moved to trash */
                    _n('%s template moved to trash.', '%s templates moved to trash.', $trashed, 'ht-mega-for-elementor'),
                    number_format_i18n($trashed)
                )
            ]);
        } else {
            wp_send_json_error(__('Failed to move templates to trash', 'ht-mega-for-elementor'));
            return;
        }
    }

    /**
     * Print import modal
     */
    public function print_import_modal() {
        ?>
        <div id="htmega-import-template-modal" style="display: none;">
            <div class="htmega-modal-overlay"></div>
            <div class="htmega-modal-content">
                <div class="htmega-modal-header">
                    <span class="htmega-modal-icon">!</span>
                </div>
                <div class="htmega-modal-body">
                    <h3><?php esc_html_e('Are you sure?', 'ht-mega-for-elementor'); ?></h3>
                    <p><?php esc_html_e('It will import those templates that were created from the "Templates" menu of Elementor and assigned to corresponding pages.', 'ht-mega-for-elementor'); ?></p>
                </div>
                <div class="htmega-modal-footer">
                    <button class="button button-primary htmega-modal-confirm"><?php esc_html_e('Yes', 'ht-mega-for-elementor'); ?></button>
                    <button class="button htmega-modal-cancel"><?php esc_html_e('Cancel', 'ht-mega-for-elementor'); ?></button>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Enqueue scripts
     */
    public function enqueue_scripts() {
        $screen = get_current_screen();
        if (!$screen || self::CPT !== $screen->post_type) {
            return;
        }
        $library = HTMega_Template_Library::instance();
        $templates_info = $library->get_templates_info();
        // Enqueue Slick Carousel files
        wp_enqueue_style('slick' );
        wp_enqueue_script('slick');

        wp_enqueue_style('htmega-template-builder', HTMEGA_ADDONS_PL_URL . 'admin/assets/css/theme-builder.css', ['slick'], HTMEGA_VERSION);
        wp_enqueue_script('htmega-template-builder', HTMEGA_ADDONS_PL_URL . 'admin/assets/js/template-builder.js', ['jquery', 'slick'], HTMEGA_VERSION, true);

        wp_localize_script('htmega-template-builder', 'HTMegaTemplateBuilder', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('htmega_template_builder_nonce'),
            'templateTypes' => $this->template_types,
            'templatesInfo' => isset( $templates_info['templates'] ) ? $templates_info['templates'] : [],
            'i18n' => [
                'addNewTemplate' => __('Add New Template', 'ht-mega-for-elementor'),
                'selectTemplateType' => __('Select Template Type', 'ht-mega-for-elementor'),
                'enterName' => __('Enter Template Name', 'ht-mega-for-elementor'),
                'createTemplate' => __('Create Template', 'ht-mega-for-elementor'),
                'confirmDelete' => __('Are you sure you want to delete this template?', 'ht-mega-for-elementor'),
                'noTemplatesSelected' => __('No templates selected.', 'ht-mega-for-elementor')
            ]
        ]);

        // Override the "Add New" button URL
        add_action('admin_footer', function() {
            ?>
            <script>
                jQuery(document).ready(function($) {
                    $('.page-title-action').attr('id', 'htmega-add-new-template').attr('href', '#');
                });
            </script>
            <?php
        });

        // Add modal HTML
        add_action('admin_footer', [$this, 'print_import_modal']);
    }
}

// Initialize
HTMega_Theme_Builder::instance();