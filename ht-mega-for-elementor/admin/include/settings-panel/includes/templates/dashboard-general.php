<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$subcribeFormAtts = '';
$subcribeFormAtts .= ' data-htmega-button-text="' . esc_attr__( 'Subscribe', 'ht-mega-for-elementor' ) . '"';
$subcribeFormAtts .= ' data-htmega-processing-text="'. esc_attr__( 'Subscribing...', 'ht-mega-for-elementor' ) . '"';
$subcribeFormAtts .= ' data-htmega-completed-text="' . esc_attr__( 'Subscribed', 'ht-mega-for-elementor' ) . '"';
$subcribeFormAtts .= ' data-htmega-ajax-error-text="' . esc_attr__( 'Something went wrong.', 'ht-mega-for-elementor' ) . '"';

// Official Elementor API for a "new page, opened straight in the editor" link — includes the
// nonce Elementor's admin_action_elementor_new_post handler requires (core/admin/admin.php).
$new_page_editor_url = class_exists( '\Elementor\Plugin' )
    ? \Elementor\Plugin::$instance->documents->get_create_new_post_url( 'page' )
    : admin_url( 'post-new.php?post_type=page' );

ob_start();
?>
<div class="htmega-general-tabs">
<div class="htmega-admin-main-tab-pane-inner">
        <!-- Banner Start -->
        <div class="htmega-admin-banner" style="background-image: url('<?php echo esc_url( HTMEGAOPT_URL . '/assets/images/dashboard-welcome-bg.jpg' ); ?>'); background-size: cover;">
            <div class="htmega-banner-logo">
            <img src="<?php echo esc_url( HTMEGAOPT_URL . '/assets/images/htmega-logo-white.png' ); ?>" alt="<?php echo esc_attr__('HT Mega Logo', 'ht-mega-for-elementor'); ?>">
            </div>
            <div class="htmega-banner-content">
                <h1><?php esc_html_e( 'Welcome To The HT Mega Family!', 'ht-mega-for-elementor' ); ?></h1>
                <p><?php esc_html_e( 'You have made a great choice. Let’s build something extraordinary!', 'ht-mega-for-elementor' ) ?></p>
                <a href="<?php echo esc_url( $new_page_editor_url ); ?>" class="htmega-doc-btn htmega-banner-cta"><?php esc_html_e( 'Build Your First Page', 'ht-mega-for-elementor' ); ?></a>
            </div>
        </div>
        <!-- Banner End -->

        <!-- Get Started Section -->
        <div class="htmega-get-started">
            <h2><?php esc_html_e( 'Get started in 3 steps', 'ht-mega-for-elementor' ); ?></h2>
            <div class="htmega-get-started-steps">

                <a class="htmega-get-started-step" href="<?php echo esc_url( $new_page_editor_url ); ?>">
                    <span class="htmega-get-started-num">1</span>
                    <strong><?php esc_html_e( 'Open Elementor', 'ht-mega-for-elementor' ); ?></strong>
                    <span class="htmega-get-started-desc"><?php esc_html_e( 'Start a new page with the Elementor editor.', 'ht-mega-for-elementor' ); ?></span>
                </a>

                <div class="htmega-get-started-step htmega-get-started-step--static">
                    <span class="htmega-get-started-num">2</span>
                    <strong><?php esc_html_e( 'Choose a template or generate with AI', 'ht-mega-for-elementor' ); ?></strong>
                    <span>
                        <?php
                        /* translators: %s: "HT Mega Template Library" wrapped in a link to the template browsing page */
                        echo wp_kses_post( sprintf( __( 'Pick a layout in the editor, or click the sparkle button to build a section — or full page — from a prompt with HT Mega AI. You can also browse the %s first.', 'ht-mega-for-elementor' ), '<a href="' . esc_url( admin_url( 'admin.php?page=htmega-addons#/templates' ) ) . '">' . esc_html__( 'HT Mega Template Library', 'ht-mega-for-elementor' ) . '</a>' ) );
                        ?>
                    </span>
                </div>

                <div class="htmega-get-started-step htmega-get-started-step--static">
                    <span class="htmega-get-started-num">3</span>
                    <strong><?php esc_html_e( 'Customize', 'ht-mega-for-elementor' ); ?></strong>
                    <span>
                        <?php
                        /* translators: %s: "HT Mega AI Builder" wrapped in a link to the AI Builder module page */
                        echo wp_kses_post( sprintf( __( 'Edit text, images, and styles — or generate copy with %s.', 'ht-mega-for-elementor' ), '<a href="' . esc_url( 'https://wphtmega.com/modules/ai-builder/' ) . '" target="_blank">' . esc_html__( 'HT Mega AI Builder', 'ht-mega-for-elementor' ) . '</a>' ) );
                        ?>
                    </span>
                </div>

            </div>
        </div>
        <!-- Get Started Section End -->

    <!-- Documentation Section -->
    <div class="htmega-documentation">
        <div class="htmega-doc-image">
            <img src="<?php echo esc_url(HTMEGAOPT_URL . '/assets/images/documentation-img.png'); ?>" alt="<?php echo esc_html__('Documentation', 'ht-mega-for-elementor'); ?>">
        </div>
        <div class="htmega-doc-content">
            <div class="htmega-doc-icon"><img src="<?php echo esc_url( HTMEGAOPT_URL . '/assets/images/info-icon/documentation-new.png' ); ?>" alt="<?php echo esc_html__('documentation','ht-mega-for-elementor');?>"></div>
            <h3><?php echo esc_html__('Documentation', 'ht-mega-for-elementor'); ?></h3>
            <p><?php echo esc_html__('Regularly updated and organized, our documentation ensures you have the latest information. Use this manual to navigate our plugin efficiently and maximize its potential.', 'ht-mega-for-elementor');?></p>
            <a href="https://wphtmega.com/docs/" target="_blank" class="htmega-doc-btn"><?php echo esc_html__('Get Now', 'ht-mega-for-elementor'); ?></a>
        </div>
    </div>

    <!-- Support & Community Section -->
    <h2 class="htmega-support-heading"><?php esc_html_e( 'Need more help?', 'ht-mega-for-elementor' ); ?></h2>
    <div class="htmega-quick-links">
        <div class="htmega-quick-link-item">
            <div class="quick-link-icon support"><img src="<?php echo esc_url( HTMEGAOPT_URL . '/assets/images/info-icon/support-new.png' ); ?>" alt="<?php echo esc_attr__('happy with us','ht-mega-for-elementor');?>"></div>
            <h3><?php echo esc_html__('Support & Feedback', 'ht-mega-for-elementor'); ?></h3>
            <p><?php echo esc_html__('Need help or want a free store set-up? We will get back to you within 12-24 hours after receiving your inquiry.', 'ht-mega-for-elementor'); ?></p>
            <a href="https://wphtmega.com/support/" target="_blank" class="quick-link-btn">
                <?php echo esc_html__('Get Support', 'ht-mega-for-elementor'); ?>
                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_2016_5576)"><path d="M12.1679 11.3176C12.1057 11.3176 12.0441 11.3053 11.9867 11.2815C11.9292 11.2577 11.877 11.2228 11.833 11.1788C11.789 11.1348 11.7541 11.0826 11.7303 11.0252C11.7065 10.9677 11.6942 10.9061 11.6942 10.844L11.6907 5.96518L5.1448 12.5111C5.05616 12.5997 4.93588 12.6494 4.81043 12.6493C4.68498 12.6492 4.56462 12.5993 4.47584 12.5105C4.38706 12.4217 4.33713 12.3014 4.33703 12.1759C4.33692 12.0505 4.38666 11.9302 4.4753 11.8416L11.0212 5.29569L6.14239 5.29216C6.01687 5.29206 5.89645 5.2421 5.80762 5.15327C5.71879 5.06444 5.66883 4.94401 5.66872 4.81849C5.66862 4.69297 5.71839 4.57263 5.80708 4.48394C5.89576 4.39525 6.0161 4.34549 6.14163 4.34559L12.1622 4.35046C12.2244 4.35047 12.286 4.36274 12.3434 4.38656C12.4009 4.41038 12.4531 4.44528 12.4971 4.48927C12.5411 4.53326 12.576 4.58548 12.5998 4.64294C12.6236 4.70039 12.6359 4.76196 12.6359 4.82412L12.6408 10.8447C12.6409 10.9069 12.6287 10.9684 12.605 11.0259C12.5812 11.0833 12.5464 11.1354 12.5025 11.1794C12.4586 11.2233 12.4064 11.2581 12.349 11.2818C12.2916 11.3055 12.23 11.3177 12.1679 11.3176Z" fill="black"/></g><defs><clipPath id="clip0_2016_5576"><rect width="12" height="12" fill="white" transform="translate(8.48535 0.0146484) rotate(45)"/></clipPath></defs></svg>
        </a>
        </div>

        <div class="htmega-quick-link-item">
            <div class="quick-link-icon community"><img src="<?php echo esc_url( HTMEGAOPT_URL . '/assets/images/info-icon/join-community.png' ); ?>" alt="<?php echo esc_attr__('join community','ht-mega-for-elementor');?>"></div>
            <h3><?php echo esc_html__('Join Our Community', 'ht-mega-for-elementor'); ?></h3>
            <p><?php echo esc_html__('Engage with our community to connect & share your ideas. Join a network where collaboration and growth thrive!', 'ht-mega-for-elementor'); ?></p>
            <a href="https://www.facebook.com/hasthemes" target="_blank" class="quick-link-btn">
                <?php echo esc_html__('Join Now', 'ht-mega-for-elementor'); ?>
                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_2016_5576)"><path d="M12.1679 11.3176C12.1057 11.3176 12.0441 11.3053 11.9867 11.2815C11.9292 11.2577 11.877 11.2228 11.833 11.1788C11.789 11.1348 11.7541 11.0826 11.7303 11.0252C11.7065 10.9677 11.6942 10.9061 11.6942 10.844L11.6907 5.96518L5.1448 12.5111C5.05616 12.5997 4.93588 12.6494 4.81043 12.6493C4.68498 12.6492 4.56462 12.5993 4.47584 12.5105C4.38706 12.4217 4.33713 12.3014 4.33703 12.1759C4.33692 12.0505 4.38666 11.9302 4.4753 11.8416L11.0212 5.29569L6.14239 5.29216C6.01687 5.29206 5.89645 5.2421 5.80762 5.15327C5.71879 5.06444 5.66883 4.94401 5.66872 4.81849C5.66862 4.69297 5.71839 4.57263 5.80708 4.48394C5.89576 4.39525 6.0161 4.34549 6.14163 4.34559L12.1622 4.35046C12.2244 4.35047 12.286 4.36274 12.3434 4.38656C12.4009 4.41038 12.4531 4.44528 12.4971 4.48927C12.5411 4.53326 12.576 4.58548 12.5998 4.64294C12.6236 4.70039 12.6359 4.76196 12.6359 4.82412L12.6408 10.8447C12.6409 10.9069 12.6287 10.9684 12.605 11.0259C12.5812 11.0833 12.5464 11.1354 12.5025 11.1794C12.4586 11.2233 12.4064 11.2581 12.349 11.2818C12.2916 11.3055 12.23 11.3177 12.1679 11.3176Z" fill="black"/></g><defs><clipPath id="clip0_2016_5576"><rect width="12" height="12" fill="white" transform="translate(8.48535 0.0146484) rotate(45)"/></clipPath></defs></svg>
            </a>
        </div>
    </div>
    <!-- Support & Community Section End -->

    <!-- Feature Request Section -->
    <div class="htmega-feature-request">
        <div class="htmega-feature-left">
            <img src="<?php echo esc_url(HTMEGAOPT_URL . '/assets/images/feature-request-img.png'); ?>" alt="<?php echo esc_html__('Feature Request', 'ht-mega-for-elementor'); ?>">
        </div>
        <div class="htmega-feature-right">
            <div class="feature-icon">
            <img src="<?php echo esc_url( HTMEGAOPT_URL . '/assets/images/info-icon/missing-feature-new.png' ); ?>" alt="<?php echo esc_attr__('missing feature','ht-mega-for-elementor');?>">
            </div>
            <h3><?php echo esc_html__('Missing Any Feature?', 'ht-mega-for-elementor'); ?></h3>
            <p><?php echo esc_html__('Have you ever noticed any missing features? Please notify us if you do. As soon as possible, our staff will add any necessary features based on your requests. Our commitment to our clients is second to none.', 'ht-mega-for-elementor');?></p>
            <a href="https://hasthemes.com/contact-us/" target="_blank" class="htmega-doc-btn"><?php echo esc_html__('Request Feature ', 'ht-mega-for-elementor');?></a>
        </div>
    </div>

    <!-- Subscribe Banner Start -->
    <div class="htmega-admin-subscribe">
        <div class="htmega-admin-subscribe-content">

        <div class="htmega-video-badge">
            <span class="video-icon">
            <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="19" height="19" rx="1.93953" fill="black"/><path d="M10.6486 12.2743L14.3745 8.54798V5.16676C14.3745 3.97179 13.4028 3 12.2079 3H6.79151C6.21712 3.00043 5.66638 3.22878 5.26017 3.63491C4.85397 4.04105 4.62551 4.59178 4.62493 5.16622V8.54798L8.35036 12.2743C8.96458 12.888 10.0349 12.888 10.6486 12.2743ZM6.96429 7.62386C6.86222 7.52533 6.80287 7.39068 6.799 7.24886C6.79514 7.10704 6.84706 6.96936 6.94362 6.86541C7.04018 6.76147 7.17366 6.69956 7.31537 6.69299C7.45708 6.68642 7.59571 6.73572 7.70147 6.83028L8.70405 7.76253C8.84976 7.9077 9.06479 7.90825 9.19749 7.77553L11.2899 5.75828C11.3932 5.65851 11.532 5.60388 11.6756 5.60642C11.8192 5.60896 11.956 5.66846 12.0557 5.77182C12.1555 5.87519 12.2101 6.01396 12.2076 6.1576C12.2051 6.30125 12.1456 6.438 12.0422 6.53777L9.95634 8.54852C9.82543 8.67899 9.67005 8.78232 9.49912 8.8526C9.32819 8.92287 9.14506 8.95871 8.96025 8.95804C8.77314 8.95836 8.5878 8.92178 8.41484 8.85039C8.24188 8.77901 8.08468 8.67422 7.95225 8.54202L6.96429 7.62386ZM15.9995 9.88324V13.2916C15.9995 14.785 14.7846 16 13.2912 16H5.70822C4.21491 16 3 14.785 3 13.2916V9.88324C3 9.47914 3.09966 9.08588 3.27082 8.72566L7.58502 13.0408C8.09687 13.5521 8.77663 13.8338 9.50027 13.8338C10.2239 13.8338 10.9037 13.5521 11.415 13.0408L15.7292 8.72566C15.9003 9.08588 15.9995 9.47969 15.9995 9.88324Z" fill="white"/>
                    </svg>
            </span>
                <?php echo esc_html__('Subscribe Our Newsletter', 'ht-mega-for-elementor'); ?>
        </div>

            <div class="htmega-newsletter-content">
                <h2><?php echo esc_html__('Subscribe to receive discount, offer, plugin updates and news in your inbox.', 'ht-mega-for-elementor');?></h2>
            </div>
        </div>
        <div class="htmega-admin-subscribe-wrapper">
            <form action="#" class="htmega-admin-subscribe-form" <?php echo wp_kses_post( trim( $subcribeFormAtts ) ); ?>>
                <input type="email" value="<?php echo esc_attr( get_bloginfo('admin_email') ); ?>" placeholder="<?php echo esc_attr__('Enter your email', 'ht-mega-for-elementor'); ?>">
                <button type="submit"><?php esc_html_e( 'Subscribe', 'ht-mega-for-elementor' ) ?></button>
            </form>
            <span class="htmega-subscribe-status"></span>
        </div>
    </div>
    <!-- Subscribe Banner End -->

    </div>
</div>
<?php echo apply_filters('htmega_dashboard_general', ob_get_clean() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>