<?php
namespace HTMegaOpt\Admin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Menu {

    /**
     * [init]
     */
    public function init() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ], 220 );
        // Priority 230 — after AI Builder (226) and before Upgrade to Pro (329),
        // so "Recommendations" lands at the bottom of the HT Mega submenu list.
        add_action( 'admin_menu', [ $this, 'recommendations_submenu' ], 230 );
        add_action( 'admin_init', [ $this, 'maybe_migrate_legacy_module_settings' ], 5 );
        add_action( 'admin_init', [ $this, 'redirect_legacy_recommendations_page' ] );
    }

    /**
     * Redirect the retired standalone "Recommendations" page to its new home inside
     * the dashboard, so existing bookmarks and older doc links don't dead-end on
     * WordPress's "you are not allowed to access this page" screen.
     *
     * @return void
     */
    public function redirect_legacy_recommendations_page() {
        if ( ! is_admin() || wp_doing_ajax() ) {
            return;
        }

        // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only page check on a GET request, no state is changed.
        $page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';

        if ( 'htmega-addons_extensions' !== $page ) {
            return;
        }

        wp_safe_redirect( admin_url( 'admin.php?page=htmega-addons#/recommended-plugins' ) );
        exit;
    }

    /**
     * Add the "Recommendations" submenu item.
     *
     * Deep links into the dashboard's own Recommendations tab rather than a
     * separate admin page, so the list stays inside the settings panel.
     *
     * @return void
     */
    public function recommendations_submenu() {
        global $submenu;

        $slug       = 'htmega-addons';
        $capability = 'manage_options';

        // The parent menu is registered at priority 220; bail if it isn't there.
        if ( ! isset( $submenu[ $slug ] ) || ! current_user_can( $capability ) ) {
            return;
        }

        $submenu[ $slug ][] = array(
            esc_html__( 'Recommendations', 'ht-mega-for-elementor' ),
            $capability,
            'admin.php?page=' . $slug . '#/recommended-plugins',
        );
    }

    /**
     * One-time migration of legacy mega-menu / theme-builder options into module settings (moved from admin_enqueue_scripts for Phase 5).
     */
    public function maybe_migrate_legacy_module_settings() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $updated_megamenu_options = array(
            'megamenubuilder' => wp_json_encode(
                array(
                    'megamenubuilder_enable'   => htmega_get_option( 'megamenubuilder', 'htmega_advance_element_tabs' ),
                    'menu_items_color'           => htmega_get_option( 'menu_items_color', 'htmegamenu_setting_tabs' ),
                    'menu_items_hover_color'     => htmega_get_option( 'menu_items_hover_color', 'htmegamenu_setting_tabs' ),
                    'sub_menu_width'             => htmega_get_option( 'sub_menu_width', 'htmegamenu_setting_tabs', 200 ),
                    'sub_menu_bg_color'          => htmega_get_option( 'sub_menu_bg_color', 'htmegamenu_setting_tabs' ),
                    'sub_menu_items_color'       => htmega_get_option( 'sub_menu_items_color', 'htmegamenu_setting_tabs' ),
                    'sub_menu_items_hover_color' => htmega_get_option( 'sub_menu_items_hover_color', 'htmegamenu_setting_tabs' ),
                    'mega_menu_width'            => htmega_get_option( 'mega_menu_width', 'htmegamenu_setting_tabs' ),
                    'mega_menu_bg_color'         => htmega_get_option( 'mega_menu_bg_color', 'htmegamenu_setting_tabs' ),
                )
            ),
        );

        if ( empty( htmega_get_module_option( 'htmega_megamenu_module_settings' ) ) ) {
            update_option( 'htmega_megamenu_module_settings', $updated_megamenu_options );
            update_option( 'htmegamenu_setting_tabs', '' );
        }

        $updated_theme_builder_options = array(
            'themebuilder' => wp_json_encode(
                array(
                    'themebuilder_enable' => htmega_get_option( 'themebuilder', 'htmega_advance_element_tabs' ),
                    'single_blog_page'    => htmega_get_option( 'single_blog_page', 'htmegabuilder_templatebuilder_tabs', '0' ),
                    'archive_blog_page'   => htmega_get_option( 'archive_blog_page', 'htmegabuilder_templatebuilder_tabs', '0' ),
                    'header_page'         => htmega_get_option( 'header_page', 'htmegabuilder_templatebuilder_tabs', '0' ),
                    'footer_page'         => htmega_get_option( 'footer_page', 'htmegabuilder_templatebuilder_tabs', '0' ),
                    'search_page'         => htmega_get_option( 'search_page', 'htmegabuilder_templatebuilder_tabs', '0' ),
                    'error_page'          => htmega_get_option( 'error_page', 'htmegabuilder_templatebuilder_tabs', '0' ),
                    'coming_soon_page'    => htmega_get_option( 'coming_soon_page', 'htmegabuilder_templatebuilder_tabs', '0' ),
                    'search_pagep'        => '0',
                    'error_pagep'         => '0',
                    'coming_soon_pagep'   => '0',
                )
            ),
        );

        if ( empty( htmega_get_module_option( 'htmega_themebuilder_module_settings' ) ) ) {
            update_option( 'htmega_themebuilder_module_settings', $updated_theme_builder_options );
            update_option( 'htmegabuilder_templatebuilder_tabs', '' );
        }
    }

    /**
     * Register Menu
     *
     * @return void
     */
    public function admin_menu(){
        global $submenu;

        $slug        = 'htmega-addons';
        $capability  = 'manage_options';

        $hook = add_menu_page(
            esc_html__( 'HTMega Addons', 'ht-mega-for-elementor' ),
            esc_html__( 'HTMega Addons', 'ht-mega-for-elementor' ),
            $capability,
            $slug,
            [ $this, 'plugin_page' ],
            HTMEGA_ADDONS_PL_URL.'admin/assets/images/menu-icon.svg',
            59
        );

        if ( current_user_can( $capability ) ) {
            $onboarding_completed = get_option('htmega_onboarding_completed');
            $default_hash = '#/general';

            if ( ! get_option( 'htmega_onboarding_completed' ) && ! get_option('htmega_element_tabs') && ! get_option('htmega_advance_element_tabs ') ) {
                $default_hash = '#/setup-wizard';
            } else {
                $default_hash = '#/general';
                update_option('htmega_onboarding_completed', true);
            }
            $submenu[ $slug ][] = array( esc_html__( 'Settings', 'ht-mega-for-elementor' ), $capability, 'admin.php?page=' . $slug . $default_hash );
        }

        add_action( 'load-' . $hook, [ $this, 'init_hooks'] );

    }

    /**
     * Initialize our hooks for the admin page
     *
     * @return void
     */
    public function init_hooks() {
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    /**
     * Load scripts and styles for the app
     *
     * @return void
     */
    public function enqueue_scripts() {
        wp_enqueue_style( 'htmegaopt-admin' );
        wp_enqueue_style( 'htmegaopt-style' );
        wp_enqueue_script( 'htmegaopt-admin' );

        $option_localize_script = [
            'adminUrl'      => admin_url( '/' ),
            'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
            'rootApiUrl'    => esc_url_raw( rest_url() ),
            'restNonce'     => wp_create_nonce( 'wp_rest' ),
            'verifynonce'   => wp_create_nonce( 'htmegaopt_verifynonce' ),
            'tabs'          => Options_Field::instance()->get_settings_tabs(),
            'sections'      => Options_Field::instance()->get_settings_subtabs(),
            'settings'      => Options_Field::instance()->get_registered_settings(),
            'onboarding_completed' => get_option('htmega_onboarding_completed'),
            'onboarding'    => $this->get_localize_data()['onboarding'],
            'onboarding_asset_url' => HTMEGA_ADDONS_PL_URL.'admin/include/settings-panel/assets/images/',
            'options'       => htmegaopt_get_options( Options_Field::instance()->get_registered_settings() ),
            'recommendedPlugins' => [
                'title'           => __( 'Recommended Plugins', 'ht-mega-for-elementor' ),
                'subtitle'        => __( 'Handpicked plugins that work great alongside HT Mega. Install and activate without leaving this page.', 'ht-mega-for-elementor' ),
                'by'              => __( 'By', 'ht-mega-for-elementor' ),
                'activeInstalls'  => __( 'Active Installations', 'ht-mega-for-elementor' ),
                'lessThanTen'     => __( 'Less Than 10', 'ht-mega-for-elementor' ),
                'install'         => __( 'Install Now', 'ht-mega-for-elementor' ),
                'activate'        => __( 'Activate', 'ht-mega-for-elementor' ),
                'activated'       => __( 'Activated', 'ht-mega-for-elementor' ),
                'installing'      => __( 'Installing...', 'ht-mega-for-elementor' ),
                'activating'      => __( 'Activating...', 'ht-mega-for-elementor' ),
                'retry'           => __( 'Try Again', 'ht-mega-for-elementor' ),
                'installSuccess'  => __( 'Plugin installed and activated.', 'ht-mega-for-elementor' ),
                'activateSuccess' => __( 'Plugin activated.', 'ht-mega-for-elementor' ),
                'genericError'    => __( 'Something went wrong. Please try again.', 'ht-mega-for-elementor' ),
                'loadError'       => __( 'Could not load the recommended plugins list.', 'ht-mega-for-elementor' ),
            ],
            'labels'        => [
                'pro' => __( 'Pro', 'ht-mega-for-elementor' ),
                'modal' => [
                    'title' => __( 'BUY PRO', 'ht-mega-for-elementor' ),
                    'buynow' => __( 'Buy Now', 'ht-mega-for-elementor' ),
                    'desc' => __( 'Our free version is great, but it doesn\'t have all our advanced features. The best way to unlock all of the features in our plugin is by purchasing the pro version.', 'ht-mega-for-elementor' )
                ],
                'saveButton' => [
                    'text'   => __( 'Save Settings', 'ht-mega-for-elementor' ),
                    'saving' => __( 'Saving...', 'ht-mega-for-elementor' ),
                    'saved'  => __( 'Data Saved', 'ht-mega-for-elementor' ),
                    'alert' => [
                        'title'=> __( 'Success', 'ht-mega-for-elementor' ),
                        'text' => __( 'All data has been saved successfully!', 'ht-mega-for-elementor' )
                    ]
                ],
                'enableAllButton' => [
                    'enable'   => __( 'Enable All', 'ht-mega-for-elementor' ),
                    'disable'  => __( 'Disable All', 'ht-mega-for-elementor' ),
                ],
                'resetButton' => [
                    'text'   => __( 'Reset All Settings', 'ht-mega-for-elementor' ),
                    'reseting'  => __( 'Resetting...', 'ht-mega-for-elementor' ),
                    'reseted'  => __( 'All Data Restored', 'ht-mega-for-elementor' ),
                    'alert' => [
                        'one'=>[
                            'title' => __( 'Are you sure?', 'ht-mega-for-elementor' ),
                            'text' => __( 'It will reset all the settings to default, and all the changes you made will be deleted.', 'ht-mega-for-elementor' ),
                            'confirm' => __( 'Yes', 'ht-mega-for-elementor' ),
                            'cancel' => __( 'No', 'ht-mega-for-elementor' ),
                        ],
                        'two'=>[
                            'title' => __( 'Reset!', 'ht-mega-for-elementor' ),
                            'text' => __( 'All settings has been reset successfully.', 'ht-mega-for-elementor' ),
                            'confirm' => __( 'OK', 'ht-mega-for-elementor' ),
                        ]
                    ],
                ],
            ]
        ];

        wp_localize_script( 'htmegaopt-admin', 'htmegaOptions', $option_localize_script );
    }

    /**
     * Render our admin page
     *
     * @return void
     */
    public function plugin_page() {
        ob_start();
        include_once HTMEGAOPT_INCLUDES .'/templates/settings-page.php';
        echo ob_get_clean(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    public function get_localize_data() {
        return [
            'onboarding' => [
                'steps'=> [
                    'welcome'   => esc_html__('Welcome', 'ht-mega-for-elementor'),
                    'elements'  => esc_html__('Elements', 'ht-mega-for-elementor'),
                    'modules'   => esc_html__('Modules', 'ht-mega-for-elementor'),
                    'gopro'      => esc_html__('Go Pro', 'ht-mega-for-elementor'),
                    'templates' => esc_html__('Templates', 'ht-mega-for-elementor'),
                    'finalize' => esc_html__('Finalize', 'ht-mega-for-elementor'),
                ],
                'buttons' => [
                    'next' => __( 'Next', 'ht-mega-for-elementor' ),
                    'skip' => __( 'Skip', 'ht-mega-for-elementor' ),
                    'back' => __( 'Back', 'ht-mega-for-elementor' ),
                    'go_to_dashboard' => __( 'Go To Dashboard', 'ht-mega-for-elementor' ),
                    'enable_all' => __( 'Enable All', 'ht-mega-for-elementor' ),
                    'disable_all' => __( 'Disable All', 'ht-mega-for-elementor' ),
                ],
                'welcome' => [
                    'title' => __( 'Welcome To HT Mega', 'ht-mega-for-elementor' ),
                    'description' => __( 'Thank You for choosing HT Mega for Elementor. Follow these simple steps of easy setup wizard & enjoy your Elementor web-building experience now!', 'ht-mega-for-elementor' ),
                    'options' => [
                        'basic' => [
                            'title' => __( 'Basic', 'ht-mega-for-elementor' ),
                            'recommended' => [
                                'status' => true,
                                'text' => __( 'Recommended', 'ht-mega-for-elementor' )
                            ],
                            'description' => __( 'General widgets will be activated to build your website. Best suited for lightweight-fast starter websites.', 'ht-mega-for-elementor' ),
                        ],
                        'advanced' => [
                            'title' => __( 'Advanced', 'ht-mega-for-elementor' ),
                            'recommended' => [
                                'status' => false,
                                'text' => __( 'Recommended', 'ht-mega-for-elementor' )
                            ],
                            'description' => __( 'Build complex websites with the advance functionalities of HT Mega. All dynamic elements will be activated in this option.', 'ht-mega-for-elementor' ),
                        ],
                        'custom' => [
                            'title' => __( 'Custom', 'ht-mega-for-elementor' ),
                            'recommended' => [
                                'status' => false,
                                'text' => __( 'Recommended', 'ht-mega-for-elementor' )
                            ],
                            'description' => __( 'Configure the elements of HT mega according to your preferences to make your website engaging & stand out.', 'ht-mega-for-elementor' ),
                        ],
                    ],
                    'data_collection_text' => __( 'By continuing, you agree to allow this plugin to collect some of your data for the purpose of improving your experience.', 'ht-mega-for-elementor' ),
                    'what_we_collect' => __( 'What We Collect', 'ht-mega-for-elementor' ),
                    'data_collection_info' => __( 'We gather basic, non-sensitive information to ensure the plugin works smoothly on your site. This includes your site\'s URL, the versions of WordPress and PHP you\'re using, and a list of your installed plugins and themes. Additionally, we collect your email address to send you exclusive discounts and important updates. This data helps us ensure that HT Mega stays up-to-date and compatible with the most popular plugins and themes. Your privacy is important to us. We will never send you spam, and we handle your data with the utmost care.', 'ht-mega-for-elementor' ),
                    'privacy_policy_link' => 'https://wphtmega.com/privacy-policy/',
                    'privacy_policy_text' => __( 'Privacy Policy', 'ht-mega-for-elementor' ),
                    'proceed_button' => __( 'Proceed to Next', 'ht-mega-for-elementor' ),
                    'skip_button' => __( 'Skip & Go to Dashboard', 'ht-mega-for-elementor' ),
                ],
                'elements' => [
                    'title' => __( 'Activate the Elements You Require', 'ht-mega-for-elementor' ),
                    'description' => __( 'Select the elements you want to use in your website. You can enable or disable them anytime later.', 'ht-mega-for-elementor' ),
                    'view_all' => __( 'View All Elements', 'ht-mega-for-elementor' ),
                    'less_all' => __( 'Show Less Elements', 'ht-mega-for-elementor' ),
                ],
                'modules' => [
                    'title' => __( 'Select the Modules You Require Now', 'ht-mega-for-elementor' ),
                    'description' => __( 'Enable/Disable the Modules anytime you want from the HT Mega Dashboard.', 'ht-mega-for-elementor' ),
                ],
                'gopro' => [
                    'title' => __( '🚀 Experience the Full Power of HT Mega Pro for Your Elementor Design!', 'ht-mega-for-elementor' ),
                    'subtitle' => __( '💡 All Features. More Flexibility. Build Better, Faster, and Smarter.', 'ht-mega-for-elementor' ),
                    'offer_badge' => __( '⭐ Upgrade to HT Mega Pro – Get Full Access Anytime!', 'ht-mega-for-elementor' ),
                    'section_title' => __( 'Explore Premium Features', 'ht-mega-for-elementor' ),
                    'description' => __( 'You can get a lot more out of it upgrading to premium. Get all features', 'ht-mega-for-elementor' ),
                    'features' => [
                        'advanced_slider' => __( 'Advanced Slider', 'ht-mega-for-elementor' ),
                        'conditional_display' => __( 'Conditional Display', 'ht-mega-for-elementor' ),
                        'theme_builder' => __( 'Theme Builder', 'ht-mega-for-elementor' ),
                        'megamenu_builder' => __( 'Megamenu Builder', 'ht-mega-for-elementor' ),
                        'floating_effects' => __( 'Floating Effects', 'ht-mega-for-elementor' ),
                        'custom_css' => __( 'Custom CSS', 'ht-mega-for-elementor' ),
                        'dynamic_gallery' => __( 'Dynamic Gallery', 'ht-mega-for-elementor' ),
                        'cross_domain_copy' => __( 'Live Copy Paste', 'ht-mega-for-elementor' ),
                    ],
                    'more_features_text' => __( '& Many More Features...', 'ht-mega-for-elementor' ),
                    'value_props' => [
                        'widget_experience' => [
                            'title' => __( 'Experience 135+ Widgets & 14 Modules', 'ht-mega-for-elementor' ),
                            'desc'  => __( 'Go beyond Elementor limits and unlock endless customization options.', 'ht-mega-for-elementor' )
                        ],
                        'risk_free' => [
                            'title' => __( 'Risk-Free & Affordable', 'ht-mega-for-elementor' ),
                            'desc'  => __( 'Explore all premium features and see how HT Mega Pro enhances your workflow.', 'ht-mega-for-elementor' )
                        ],
                        'lifetime_access' => [
                            'title' => __( 'Full Access & Updates', 'ht-mega-for-elementor' ),
                            'desc'  => __( 'Enjoy continuous improvements, automatic updates, and premium support—all included.', 'ht-mega-for-elementor' )
                        ]
                    ],
                    'upgrade_button' => __( 'UPGRADE TO HT MEGA PRO', 'ht-mega-for-elementor' ),
                    'upgrade_url' => 'https://wphtmega.com/pricing/#ht-mega-pricing',
                ],
                'templates' => [
                    /* translators: %s: "900+" wrapped in a <span> highlight */
                    'title' => sprintf( __( 'Explore %s Templates', 'ht-mega-for-elementor' ), '<span class="gradient-text">900+</span>' ),
                    'description' => __( 'Design stunning websites effortlessly with HT Mega\'s exclusive collection of templates.', 'ht-mega-for-elementor' ),
                    'features' => [
                        'professionally_designed' => [
                            'title' => __( 'Professionally Designed Templates', 'ht-mega-for-elementor' ),
                            'description' => __( 'Access a variety of ready-to-use templates for every niche, from business to e-commerce, blogs, and more.', 'ht-mega-for-elementor' ),
                        ],
                        'one_click_import' => [
                            'title' => __( 'One-Click Import', 'ht-mega-for-elementor' ),
                            'description' => __( 'Import complete pages or sections in seconds to kickstart your website design with minimal effort.', 'ht-mega-for-elementor' ),
                        ],
                        'fully_customizable' => [
                            'title' => __( 'Fully Customizable', 'ht-mega-for-elementor' ),
                            'description' => __( 'Modify every template to match your branding, ensuring a unique and personalized website.', 'ht-mega-for-elementor' ),
                        ],
                    ],
                ],
                'congrats' => [
                    'title' => __( 'You Have Completed Your Setup for HT Mega', 'ht-mega-for-elementor' ),
                    'go_to_dashboard' => __( 'Go To Dashboard', 'ht-mega-for-elementor' ),
                ],
            ],
        ];
    }

}
