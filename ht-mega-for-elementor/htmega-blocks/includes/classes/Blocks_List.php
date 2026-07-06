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
                'label' => 'Accordion',
                'name' => 'htmega/accordion',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('accordion', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'accordion-card' => [
                'label' => 'Accordion Card',
                'name' => 'htmega/accordion-card',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('accordion', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'brand' => [
                'label' => 'Brand Logo',
                'name' => 'htmega/brand',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('brand', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'buttons' => [
                'label' => 'Buttons',
                'name' => 'htmega/buttons',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('buttons', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'button' => [
                'label' => 'Button',
                'name' => 'htmega/button',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('buttons', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'cta' => [
                'label' => 'Call To Action',
                'name' => 'htmega/cta',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('cta', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'image-grid' => [
                'label' => 'Image Grid',
                'name' => 'htmega/image-grid',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('image-grid', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'info-box' => [
                'label' => 'Info Box',
                'name' => 'htmega/info-box',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('info-box', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'section-title' => [
                'label' => 'Section Title',
                'name' => 'htmega/section-title',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('section-title', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'tab' => [
                'label' => 'Tab',
                'name' => 'htmega/tab',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('tab', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'tab-content' => [
                'label' => 'Tab Content',
                'name' => 'htmega/tab-content',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('tab', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'team' => [
                'label' => 'Team',
                'name' => 'htmega/team',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('team', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],
            'testimonial' => [
                'label' => 'Testimonial',
                'name' => 'htmega/testimonial',
                'server_side_render' => true,
                'type' => 'common',
                'active' => htmegaBlocks_get_option('testimonial', 'htmega_gutenberg_tabs', 'off') === 'on' ? true : false,
            ],

            // ── HT Mega 2025 Collection ─────────────────────────────────
            // New blocks using modern CSS tokens (htm25-*), BEM HTML,
            // no jQuery. Toggle via Sections tab in the settings panel.
            'hero-2025' => [
                'label'              => 'Hero 2025',
                'name'               => 'htmega/hero-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'hero-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'about-2025' => [
                'label'              => 'About / Feature 2026',
                'name'               => 'htmega/about-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'about-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'services-2025' => [
                'label'              => 'Services 2026',
                'name'               => 'htmega/services-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'services-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'pricing-2025' => [
                'label'              => 'Pricing Table 2026',
                'name'               => 'htmega/pricing-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'pricing-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'testimonials-2025' => [
                'label'              => 'Testimonials 2026',
                'name'               => 'htmega/testimonials-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'testimonials-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'stats-2025' => [
                'label'              => 'Stats / Counter 2026',
                'name'               => 'htmega/stats-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'stats-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'cta-2025' => [
                'label'              => 'CTA Section 2026',
                'name'               => 'htmega/cta-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'cta-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'team-2025' => [
                'label'              => 'Team 2026',
                'name'               => 'htmega/team-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'team-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'faq-2025' => [
                'label'              => 'FAQ 2026',
                'name'               => 'htmega/faq-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'faq-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'blog-2025' => [
                'label'              => 'Blog / Posts 2026',
                'name'               => 'htmega/blog-2025',
                'server_side_render' => true,
                'type'               => 'htm25',
                'active'             => htmega_sections_get_option( 'blog-2025', 'htmega_sections_gutenberg_tabs', 'off' ) === 'on',
                'enqueue_style'      => false,
            ],
            'contact-2025' => [
                'label'              => 'Contact Section 2026',
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
     * Get translated block list
     * @return array
     */
    public static function get_translated_block_list()
    {
        $blocks = self::get_block_list();
        
        foreach ($blocks as $key => &$block) {
            if (isset($block['label'])) {
                $block['label'] = __($block['label'], 'htmega-addons');
            }
        }
        
        return $blocks;
    }
}
