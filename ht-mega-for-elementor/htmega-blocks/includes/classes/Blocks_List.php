<?php
namespace HtMegaBlocks;

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Manage Blocks
 */
class Blocks_List
{

    /**
     * Block List
     * @return array
     */
    public static function get_block_list()
    {
        $blockList = [
            'accordion' => [
                'label' => __( 'Accordion', 'ht-mega-for-elementor' ),
                'name' => 'htmega/accordion',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('accordion', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'accordion-card' => [
                'label' => __( 'Accordion Card', 'ht-mega-for-elementor' ),
                'name' => 'htmega/accordion-card',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('accordion', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'brand' => [
                'label' => __( 'Brand Logo', 'ht-mega-for-elementor' ),
                'name' => 'htmega/brand',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('brand', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'buttons' => [
                'label' => __( 'Buttons', 'ht-mega-for-elementor' ),
                'name' => 'htmega/buttons',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('buttons', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'button' => [
                'label' => __( 'Button', 'ht-mega-for-elementor' ),
                'name' => 'htmega/button',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('buttons', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'cta' => [
                'label' => __( 'Call To Action', 'ht-mega-for-elementor' ),
                'name' => 'htmega/cta',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('cta', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'image-grid' => [
                'label' => __( 'Image Grid', 'ht-mega-for-elementor' ),
                'name' => 'htmega/image-grid',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('image-grid', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'info-box' => [
                'label' => __( 'Info Box', 'ht-mega-for-elementor' ),
                'name' => 'htmega/info-box',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('info-box', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'section-title' => [
                'label' => __( 'Section Title', 'ht-mega-for-elementor' ),
                'name' => 'htmega/section-title',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('section-title', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'tab' => [
                'label' => __( 'Tab', 'ht-mega-for-elementor' ),
                'name' => 'htmega/tab',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('tab', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'tab-content' => [
                'label' => __( 'Tab Content', 'ht-mega-for-elementor' ),
                'name' => 'htmega/tab-content',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('tab', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'team' => [
                'label' => __( 'Team', 'ht-mega-for-elementor' ),
                'name' => 'htmega/team',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('team', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'testimonial' => [
                'label' => __( 'Testimonial', 'ht-mega-for-elementor' ),
                'name' => 'htmega/testimonial',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('testimonial', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],

            // ── HT Mega 2025 Collection ─────────────────────────────────
            // New blocks using modern CSS tokens (htm25-*), BEM HTML,
            // no jQuery. Toggle via Sections tab in the settings panel.
            'hero-2025' => [
                'label'              => __( 'Hero 2025', 'ht-mega-for-elementor' ),
                'name'               => 'htmega/hero-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'hero-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'about-2025' => [
                'label'              => __( 'About / Feature 2026', 'ht-mega-for-elementor' ),
                'name'               => 'htmega/about-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'about-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'services-2025' => [
                'label'              => __( 'Services 2026', 'ht-mega-for-elementor' ),
                'name'               => 'htmega/services-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'services-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'pricing-2025' => [
                'label'              => __( 'Pricing Table 2026', 'ht-mega-for-elementor' ),
                'name'               => 'htmega/pricing-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'pricing-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'testimonials-2025' => [
                'label'              => __( 'Testimonials 2026', 'ht-mega-for-elementor' ),
                'name'               => 'htmega/testimonials-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'testimonials-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'stats-2025' => [
                'label'              => __( 'Stats / Counter 2026', 'ht-mega-for-elementor' ),
                'name'               => 'htmega/stats-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'stats-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'cta-2025' => [
                'label'              => __( 'CTA Section 2026', 'ht-mega-for-elementor' ),
                'name'               => 'htmega/cta-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'cta-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'team-2025' => [
                'label'              => __( 'Team 2026', 'ht-mega-for-elementor' ),
                'name'               => 'htmega/team-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'team-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'faq-2025' => [
                'label'              => __( 'FAQ 2026', 'ht-mega-for-elementor' ),
                'name'               => 'htmega/faq-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'faq-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'blog-2025' => [
                'label'              => __( 'Blog / Posts 2026', 'ht-mega-for-elementor' ),
                'name'               => 'htmega/blog-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'blog-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'contact-2025' => [
                'label'              => __( 'Contact Section 2026', 'ht-mega-for-elementor' ),
                'name'               => 'htmega/contact-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'contact-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
        ];
        return apply_filters('htmega_block_list', $blockList);
    }

    /**
     * Get translated block list. Labels are already run through __() at
     * definition time in get_block_list(), so this just returns them —
     * passing an already-resolved label through __() again would take a
     * variable, which the translation parser can't statically extract.
     * @return array
     */
    public static function get_translated_block_list()
    {
        return self::get_block_list();
    }
}
