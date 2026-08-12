<?php 
// Prevent direct output
if (!defined('ABSPATH')) {
    exit;
}

ob_start(); 
?>
<div class="htoptions-sidebar-adds-area">
<?php 
try {
    if (!function_exists('is_plugin_active')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    if (class_exists('HTMega_Notice_Manager')) {
        // showing sidbar  through the remote api
        $noticeManager = HTMega_Notice_Manager::instance();
        $notices = $noticeManager->get_sidebar_info();
        if (htmega_is_pro_active()) {
            $htmega_license_title = apply_filters('htmega_license_title', 'lifetime'); 
            if (!str_contains($htmega_license_title, 'Growth') && !str_contains($htmega_license_title, 'Unlimited - Lifetime')) {
                if (isset($notices[1]['status']) && !empty($notices[1]['status']) && !empty($notices[1]['bannerimage']) ) {
                    ?>
                    <div class="htmega-opt-sidebar-item htmega-opt-banner-image">
                        <a href="<?php echo esc_url($notices[1]['bannerlink']); ?>" target="_blank">
                            <img class="htoptions-banner-img" src="<?php echo esc_url($notices[1]['bannerimage']); ?>" alt="<?php echo esc_attr__('HT Mega Addons', 'ht-mega-for-elementor'); ?>"/>
                        </a>
                    </div>
                    <?php
                }
            }
        } else { 
            if (isset($notices[0]['status']) && !empty($notices[0]['status']) && !empty($notices[0]['bannerimage']) ) {
                ?>
                <div class="htmega-opt-sidebar-item htmega-opt-banner-image">
                    <a href="<?php echo esc_url($notices[0]['bannerlink']); ?>" target="_blank">
                        <img class="htoptions-banner-img" src="<?php echo esc_url($notices[0]['bannerimage']); ?>" alt="<?php echo esc_attr__('HT Mega Addons', 'ht-mega-for-elementor'); ?>"/>
                    </a>
                </div>
                <?php
            }
            ?>
            <div class="htmega-opt-get-pro htmega-opt-sidebar-item">
                <div class="htmega-opt-get-pro-header">
                    <h2 class="htmega-opt-get-pro-header-title"> <?php esc_html_e( 'Get HT Mega', 'ht-mega-for-elementor' )?> <span style="color: #FF6067;"><?php esc_html_e( 'PRO', 'ht-mega-for-elementor' )?></span></h2>
                    <p class="htmega-opt-get-pro-desc"><?php esc_html_e( 'Get more powerful widgets & extensions to elevate your Elementor website', 'ht-mega-for-elementor' )?></p>
                </div>
                <div class="htmega-opt-get-pro-content">
                    <h3 class="htmega-opt-get-pro-title"><?php esc_html_e( 'What You Get', 'ht-mega-for-elementor' )?></h3>
                    <ul>
                        <li><?php esc_html_e( '145+ Elemetor Widgets', 'ht-mega-for-elementor' ) ?></li>
                        <li><?php esc_html_e( '14+ Essential Modules', 'ht-mega-for-elementor' ) ?></li>
                        <li><?php esc_html_e( '245+ Page Templates', 'ht-mega-for-elementor') ?></li>
                        <li><?php esc_html_e( '850+ Elementor Blocks & Sections Templates', 'ht-mega-for-elementor' ) ?></li>
                        <li><?php esc_html_e( 'AI Writer', 'ht-mega-for-elementor' ) ?></li>
                        <li><?php esc_html_e( 'Mega Menu Builder', 'ht-mega-for-elementor' ) ?></li>
                        <li><?php esc_html_e( 'Theme Builder', 'ht-mega-for-elementor' ) ?></li>
                        <li><?php esc_html_e( 'Advanced Slider', 'ht-mega-for-elementor' ) ?></li>
                        <li><?php esc_html_e( 'Conditional Display', 'ht-mega-for-elementor' ) ?></li>
                        <li><?php esc_html_e( 'Much More..', 'ht-mega-for-elementor' ) ?></li>
                    </ul>
                    <a href="https://wphtmega.com/pricing/?utm_source=admin&utm_medium=mainmenu&utm_campaign=free" class="upgrade-button" target="_blank"><img src="<?php echo esc_url(HTMEGA_ADDONS_PL_URL.'admin/assets/images/icon/get-pro.png'); ?>" alt="<?php echo esc_attr__('Rating icon', 'ht-mega-for-elementor'); ?>"> <?php esc_html_e( 'Upgrade To PRO ', 'ht-mega-for-elementor' ); ?></a>
                </div>
            </div>
            <?php
        }
    }
} catch (Exception $e) {
    // Silently fail
}
?>
    <div class="htoption-rating-area htmega-opt-sidebar-item">
        <div class="htoption-rating-icon">
            <img src="<?php echo esc_url(HTMEGA_ADDONS_PL_URL.'admin/assets/images/icon/rating-new.png'); ?>" alt="<?php echo esc_attr__('Rating icon', 'ht-mega-for-elementor'); ?>">
        </div>
        <div class="htoption-rating-intro">
        <h3 class="htmega-rating-title"><?php esc_html_e( 'Have We Fully Met Your Expectations?', 'ht-mega-for-elementor' ) ?></h3>
        <p class="htmega-rating-desc">
            <?php echo esc_html__('Thank you for choosing our plugin! If it makes your work easier, please share your happiness with a 5-star rating on WordPress. It’ll take just 2 minutes & means a lot to us!','ht-mega-for-elementor'); ?></p>
            <a href="https://wordpress.org/support/plugin/ht-mega-for-elementor/reviews/#new-post" class="htmega-admin-pro-rating-bution htmega-doc-btn" target="_blank"><?php esc_html_e( 'Provide Your Feedback', 'ht-mega-for-elementor' ) ?></a>
       </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
echo wp_kses_post(apply_filters('htmega_sidebar_adds_banner', $content));
?>