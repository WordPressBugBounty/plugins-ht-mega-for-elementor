<?php
/**
 * HT Mega AI Integration Class
 * Supports OpenAI, Claude, and Google AI
 * File: admin/includes/htmega-ai-integration.php
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class HTMega_AI_Integration {
    
    /**
     * Single instance of this class
     */
    private static $instance = null;
    
    /**
     * Current AI engine
     */
    private $current_engine = 'openai';

    /**
     * Approximate USD price per 1M tokens, by model.
     * Informational only (BYOK — the provider bills the user directly).
     * Verify against each provider's current pricing page before relying on this for real budgeting.
     */
    const PRICE_TABLE = [
        'gpt-5.6-luna'          => [ 'input' => 1.00,  'output' => 6.00 ],
        'gpt-5.6-terra'         => [ 'input' => 2.50,  'output' => 15.00 ],
        'gpt-5.6-sol'           => [ 'input' => 5.00,  'output' => 30.00 ],
        'claude-haiku-4-5'      => [ 'input' => 1.00,  'output' => 5.00 ],
        'claude-sonnet-5'       => [ 'input' => 3.00,  'output' => 15.00 ],
        'claude-opus-5'         => [ 'input' => 5.00,  'output' => 25.00 ],
        'gemini-3.5-flash-lite' => [ 'input' => 0.30,  'output' => 2.50 ],
        'gemini-3.6-flash'      => [ 'input' => 1.50,  'output' => 7.50 ],
        'gemini-3.5-flash'      => [ 'input' => 1.50,  'output' => 9.00 ],
        // Verified against https://api-docs.deepseek.com/quick_start/pricing (cache-miss
        // input rate — the standard, non-cached price):
        'deepseek-v4-flash'     => [ 'input' => 0.14,  'output' => 0.28 ],
        'deepseek-v4-pro'       => [ 'input' => 0.435, 'output' => 0.87 ],
        // Verified against https://platform.kimi.ai/docs/pricing/* (cache-miss input rate):
        'kimi-k3'               => [ 'input' => 3.00,  'output' => 15.00 ],
        'kimi-k2.6'             => [ 'input' => 0.95,  'output' => 4.00 ],
        'moonshot-v1-8k'        => [ 'input' => 0.20,  'output' => 2.00 ],
        // Verified against https://docs.z.ai/guides/overview/pricing:
        'glm-5.2'               => [ 'input' => 1.4,   'output' => 4.4 ],
        'glm-5-turbo'           => [ 'input' => 1.2,   'output' => 4.0 ],
        'glm-4.7-flash'         => [ 'input' => 0.0,   'output' => 0.0 ], // free tier
    ];

    /**
     * Option key the usage log is stored under, capped to the last self::USAGE_LOG_MAX entries.
     */
    const USAGE_LOG_OPTION = 'htmega_ai_usage_log';
    const USAGE_LOG_MAX    = 200;

    /**
     * Get single instance
     */
    public static function instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        // Hook into your settings system
        add_action( 'admin_menu',  [ $this,'admin_sub_menu'], 226);
        add_filter('htmega_admin_fields_sections', [$this, 'add_ai_tab'], 99);
        add_filter('htmega_admin_fields', [$this, 'add_ai_settings'], 99);

        
        // Only continue if AI is enabled
        add_action('init', [$this, 'maybe_init_ai'], 15);
    }
    
    /**
     * Add AI sub menu
     */
    public function admin_sub_menu() {
        add_submenu_page(
            'htmega-addons', 
            esc_html__( 'AI Builder', 'ht-mega-for-elementor' ),
            esc_html__( 'AI Builder', 'ht-mega-for-elementor' ),
            'manage_options',
            'admin.php?page=htmega-addons#/htmega_ai', 
        );
    }
    /**
     * Add AI tab to settings
     */
    public function add_ai_tab($tabs) {
        $tabs['htmega_ai'] = [
            'id'    => 'htmega_ai_features_tabs',
            'title' => esc_html__('AI Builder', 'ht-mega-for-elementor'),
            'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"> <path d="M12 22c-.25 0-.49-.09-.69-.26l-2.35-2.17c-.4-.35-.94-.52-1.49-.55-.2 0-.38 0-.57-.01a1.43 1.43 0 0 1-.94-.4 1.38 1.38 0 0 1 0-1.88l2.15-2.33c.35-.39.52-.89.56-1.36 0-.17.03-.34.07-.5.13-.46.39-.87.75-1.18a1.38 1.38 0 0 1 1.75 0c.36.31.62.72.75 1.18.04.16.06.33.07.5.03.47.21.97.56 1.36l2.15 2.33a1.38 1.38 0 0 1 0 1.88c-.26.25-.6.39-.95.4-.18 0-.36.01-.57.01-.55.03-1.09.2-1.49.55l-2.35 2.17c-.2.17-.44.26-.69.26ZM18 13.97a4.2 4.2 0 0 1-.75-1.51 4.2 4.2 0 0 1-1.38-.96 4.2 4.2 0 0 1 1.38-.96c.2-.63.5-1.2.75-1.51.2.31.55.88.75 1.51.53.21 1.02.54 1.38.96a4.2 4.2 0 0 1-1.38.96c-.2.63-.55 1.2-.75 1.51ZM6 13.97a4.2 4.2 0 0 1-.75-1.51 4.2 4.2 0 0 1-1.38-.96 4.2 4.2 0 0 1 1.38-.96c.2-.63.55-1.2.75-1.51.2.31.55.88.75 1.51.53.21 1.02.54 1.38.96a4.2 4.2 0 0 1-1.38.96c-.2.63-.55 1.2-.75 1.51ZM12 7.97c-.28-1.15-1.03-2.01-2.2-2.4 1.17-.43 1.92-1.29 2.2-2.4.28 1.15 1.03 2.01 2.2 2.4-1.17.43-1.92 1.29-2.2 2.4Z"/></svg>',
            'content' => [
                'enableall' => false,
                'title' => __( 'AI Builder Settings', 'ht-mega-for-elementor' ),
                'desc'  => __( 'Configure AI Builder to generate content, sections, and full pages across your site.', 'ht-mega-for-elementor' ),
                'wrapper_class'  => 'htmega-integrarion-section',
            ],
        ];
        
        return $tabs;
    }
    
    /**
     * Add AI settings fields
     */
    public function add_ai_settings($fields) {

        $fields['htmega_ai_features_tabs'][] = [
            'id'        => 'htmega_ai_enable',
            'name'      => __('Enable AI Builder', 'ht-mega-for-elementor'),
            'type'      => 'checkbox',
            'default'   => 'on',
            'label_on'  => __('On', 'ht-mega-for-elementor'),
            'label_off' => __('Off', 'ht-mega-for-elementor'),
            'desc'      => __('Enable AI Builder for content, section, and page generation across HT Mega widgets.', 'ht-mega-for-elementor'),
        ];
        
        $fields['htmega_ai_features_tabs'][] = [
            'id'      => 'htmega_ai_engine', 
            'name'    => __('AI Engine', 'ht-mega-for-elementor'),
            'type'    => 'select',
            'default' => 'openai',
            'options' => array(
                'openai'   => __('OpenAI', 'ht-mega-for-elementor'),
                'claude'   => __('Claude (Anthropic)', 'ht-mega-for-elementor'),
                'google'   => __('Google AI (Gemini)', 'ht-mega-for-elementor'),
                'deepseek' => __('DeepSeek', 'ht-mega-for-elementor'),
                'kimi'     => __('Kimi (Moonshot AI)', 'ht-mega-for-elementor'),
                'zai'      => __('Z.ai (GLM)', 'ht-mega-for-elementor'),
            ),
            'condition' => [ ['condition_key' => 'htmega_ai_enable', 'condition_value' => 'on'] ],
            'desc'      => __('Select the AI engine to use for content, section, and page generation.', 'ht-mega-for-elementor'),
        ];
        
        // OpenAI Settings
        $fields['htmega_ai_features_tabs'][] = [
            'id'      => 'htmega_openai_api_key', 
            'name'    => __('OpenAI API Key', 'ht-mega-for-elementor'),
            'type'    => 'text',
            'default' => '',
            'placeholder' => 'sk-...',
            'desc'    => 'Get your API key from <a href="https://platform.openai.com/api-keys" target="_blank">OpenAI Platform</a>.',
            'condition' => [ ['condition_key' => 'htmega_ai_enable', 'condition_value' => 'on'] , ['condition_key' => 'htmega_ai_engine', 'condition_value' => 'openai'] ],
            'secure' => true,
        ];
        
        $fields['htmega_ai_features_tabs'][] = [
            'id'      => 'htmega_openai_model',
            'name'    => __('OpenAI Model', 'ht-mega-for-elementor'),
            'type'    => 'select',
            // gpt-4o-mini/gpt-4o still respond today but OpenAI's current default lineup
            // moved to the GPT-5.6 family (GA July 2026); gpt-3.5-turbo has a confirmed
            // shutdown date of Oct 23 2026. If this errors again with "model not found,"
            // re-check https://developers.openai.com/api/docs/models and this plugin's
            // Google/Claude equivalents below — all three providers churn model IDs fast.
            'default' => 'gpt-5.6-luna',
            'options' => [
                'gpt-5.6-luna'  => __('GPT-5.6 Luna (Fast & Affordable)', 'ht-mega-for-elementor'),
                'gpt-5.6-terra' => __('GPT-5.6 Terra (Balanced)', 'ht-mega-for-elementor'),
                'gpt-5.6-sol'   => __('GPT-5.6 Sol (Best Performance)', 'ht-mega-for-elementor'),
            ],
            'condition' => [ ['condition_key' => 'htmega_ai_enable', 'condition_value' => 'on'] , ['condition_key' => 'htmega_ai_engine', 'condition_value' => 'openai'] ],
            'desc'      => __('Select the OpenAI model to use for content, section, and page generation.', 'ht-mega-for-elementor'),
        ];
        
        // Claude Settings
        $fields['htmega_ai_features_tabs'][] = [
            'id'      => 'htmega_claude_api_key', 
            'name'    => __('Claude API Key', 'ht-mega-for-elementor'),
            'type'    => 'text',
            'default' => '',
            'placeholder' => 'sk-ant-...',
            'desc'    => 'Get your API key from <a href="https://console.anthropic.com/" target="_blank">Anthropic Console</a>.',
            'condition' => [ ['condition_key' => 'htmega_ai_enable', 'condition_value' => 'on'] , ['condition_key' => 'htmega_ai_engine', 'condition_value' => 'claude'] ],
            'secure' => true,
        ];
        
        $fields['htmega_ai_features_tabs'][] = [
            'id'      => 'htmega_claude_model',
            'name'    => __('Claude Model', 'ht-mega-for-elementor'),
            'type'    => 'select',
            // The entire Claude 3 line (3.5 Sonnet, 3 Haiku, 3 Opus) is retired — Claude
            // 3.5 Sonnet specifically since Oct 28 2025. If this errors again with
            // "not_found_error," re-check https://platform.claude.com/docs/en/about-claude/models/overview.
            'default' => 'claude-sonnet-5',
            'options' => [
                'claude-sonnet-5' => __('Claude Sonnet 5 (Best Performance)', 'ht-mega-for-elementor'),
                'claude-haiku-4-5' => __('Claude Haiku 4.5 (Fast & Affordable)', 'ht-mega-for-elementor'),
                'claude-opus-5' => __('Claude Opus 5 (Most Capable)', 'ht-mega-for-elementor'),
            ],
            'condition' => [ ['condition_key' => 'htmega_ai_enable', 'condition_value' => 'on'] , ['condition_key' => 'htmega_ai_engine', 'condition_value' => 'claude'] ],
            'desc'      => __('Select the Claude model to use for content, section, and page generation.', 'ht-mega-for-elementor'),
        ];
        
        // Google AI Settings
        $fields['htmega_ai_features_tabs'][] = [
            'id'      => 'htmega_google_api_key', 
            'name'    => __('Google AI API Key', 'ht-mega-for-elementor'),
            'type'    => 'text',
            'default' => '',
            'placeholder' => 'AIza...',
            'desc'    => 'Get your API key from <a href="https://makersuite.google.com/app/apikey" target="_blank">Google AI Studio</a>.',
            'condition' => [ ['condition_key' => 'htmega_ai_enable', 'condition_value' => 'on'] , ['condition_key' => 'htmega_ai_engine', 'condition_value' => 'google'] ],
            'secure' => true,
        ];
        
        $fields['htmega_ai_features_tabs'][] = [
            'id'      => 'htmega_google_model',
            'name'    => __('Google AI Model', 'ht-mega-for-elementor'),
            'type'    => 'select',
            // gemini-1.5-*, gemini-pro, and gemini-2.0-* are fully retired. gemini-2.5-*
            // (all three: flash, pro, flash-lite) is scheduled for shutdown 16 Oct 2026 and
            // was ALREADY refusing new API keys as of Jul 2026 ("no longer available to new
            // users") — don't reintroduce any gemini-2.5-* id here even though it still
            // works for some older keys. Google's lineup churns fast — if this errors again,
            // re-check https://ai.google.dev/gemini-api/docs/models and update both this list
            // and the fallback default in get_valid_model_option() calls below.
            'default' => 'gemini-3.6-flash',
            'options' => [
                'gemini-3.5-flash-lite' => __('Gemini 3.5 Flash-Lite (Fast & Affordable)', 'ht-mega-for-elementor'),
                'gemini-3.6-flash'      => __('Gemini 3.6 Flash (Balanced)', 'ht-mega-for-elementor'),
                'gemini-3.5-flash'      => __('Gemini 3.5 Flash (Best Performance)', 'ht-mega-for-elementor'),
            ],
            'condition' => [ ['condition_key' => 'htmega_ai_enable', 'condition_value' => 'on'] , ['condition_key' => 'htmega_ai_engine', 'condition_value' => 'google'] ],
            'desc'      => __('Select the Google AI model to use for content, section, and page generation.', 'ht-mega-for-elementor'),
        ];

        // DeepSeek Settings
        $fields['htmega_ai_features_tabs'][] = [
            'id'      => 'htmega_deepseek_api_key',
            'name'    => __('DeepSeek API Key', 'ht-mega-for-elementor'),
            'type'    => 'text',
            'default' => '',
            'placeholder' => 'sk-...',
            'desc'    => 'Get your API key from <a href="https://platform.deepseek.com/api_keys" target="_blank">DeepSeek Platform</a>.',
            'condition' => [ ['condition_key' => 'htmega_ai_enable', 'condition_value' => 'on'] , ['condition_key' => 'htmega_ai_engine', 'condition_value' => 'deepseek'] ],
            'secure' => true,
        ];

        $fields['htmega_ai_features_tabs'][] = [
            'id'      => 'htmega_deepseek_model',
            'name'    => __('DeepSeek Model', 'ht-mega-for-elementor'),
            'type'    => 'select',
            // Verified against https://api-docs.deepseek.com/ — DeepSeek's model lineup
            // churns like the other providers here; re-check that page if this errors
            // with a "model not found"-style response.
            'default' => 'deepseek-v4-flash',
            'options' => [
                'deepseek-v4-flash' => __('DeepSeek V4 Flash (Fast & Affordable)', 'ht-mega-for-elementor'),
                'deepseek-v4-pro'   => __('DeepSeek V4 Pro (Best Performance)', 'ht-mega-for-elementor'),
            ],
            'condition' => [ ['condition_key' => 'htmega_ai_enable', 'condition_value' => 'on'] , ['condition_key' => 'htmega_ai_engine', 'condition_value' => 'deepseek'] ],
            'desc'      => __('Select the DeepSeek model to use for content, section, and page generation.', 'ht-mega-for-elementor'),
        ];

        // Kimi (Moonshot AI) Settings
        $fields['htmega_ai_features_tabs'][] = [
            'id'      => 'htmega_kimi_api_key',
            'name'    => __('Kimi API Key', 'ht-mega-for-elementor'),
            'type'    => 'text',
            'default' => '',
            'placeholder' => 'sk-...',
            // Real gotcha, confirmed via Moonshot's own docs: two separate regional
            // platforms with NON-interchangeable keys — platform.kimi.ai
            // (international, api.moonshot.ai — what this plugin calls) vs
            // platform.kimi.com / platform.moonshot.cn (China, api.moonshot.cn). A
            // key from the China console fails here with exactly "Invalid
            // Authentication" even though it's a real, valid key — just for the
            // other region's endpoint. Spelled out explicitly since this is an easy
            // trap (both consoles are reachable from moonshot.ai/.cn/.com domains).
            'desc'    => 'Get your API key from the <a href="https://platform.kimi.ai/console/api-keys" target="_blank">international Kimi platform</a> (platform.kimi.ai). A key from platform.kimi.com or platform.moonshot.cn (the China platform) will NOT work here — it uses a separate account system and fails with "Invalid Authentication."',
            'condition' => [ ['condition_key' => 'htmega_ai_enable', 'condition_value' => 'on'] , ['condition_key' => 'htmega_ai_engine', 'condition_value' => 'kimi'] ],
            'secure' => true,
        ];

        $fields['htmega_ai_features_tabs'][] = [
            'id'      => 'htmega_kimi_model',
            'name'    => __('Kimi Model', 'ht-mega-for-elementor'),
            'type'    => 'select',
            // Verified against https://platform.moonshot.ai/docs/api/chat — re-check that
            // page if this errors with a "model not found"-style response.
            'default' => 'kimi-k3',
            'options' => [
                'kimi-k3'          => __('Kimi K3 (Best Performance)', 'ht-mega-for-elementor'),
                'kimi-k2.6'        => __('Kimi K2.6 (Balanced)', 'ht-mega-for-elementor'),
                'moonshot-v1-8k'   => __('Moonshot v1 8k (Fast & Affordable)', 'ht-mega-for-elementor'),
            ],
            'condition' => [ ['condition_key' => 'htmega_ai_enable', 'condition_value' => 'on'] , ['condition_key' => 'htmega_ai_engine', 'condition_value' => 'kimi'] ],
            'desc'      => __('Select the Kimi model to use for content, section, and page generation.', 'ht-mega-for-elementor'),
        ];

        // Z.ai (GLM) Settings
        $fields['htmega_ai_features_tabs'][] = [
            'id'      => 'htmega_zai_api_key',
            'name'    => __('Z.ai API Key', 'ht-mega-for-elementor'),
            'type'    => 'text',
            'default' => '',
            'placeholder' => '...',
            'desc'    => 'Get your API key from <a href="https://z.ai/manage-apikey/apikey-list" target="_blank">Z.ai Platform</a>.',
            'condition' => [ ['condition_key' => 'htmega_ai_enable', 'condition_value' => 'on'] , ['condition_key' => 'htmega_ai_engine', 'condition_value' => 'zai'] ],
            'secure' => true,
        ];

        $fields['htmega_ai_features_tabs'][] = [
            'id'      => 'htmega_zai_model',
            'name'    => __('Z.ai Model', 'ht-mega-for-elementor'),
            'type'    => 'select',
            // Verified against https://docs.z.ai/guides/overview/pricing — GLM-5.2 is the
            // current flagship (GLM-4.6 was current at time of an earlier, narrower doc
            // page; the pricing page shows the fuller, newer lineup). Re-check that page
            // if this errors with a "model not found"-style response — this lineup churns
            // like every other provider here.
            'default' => 'glm-5.2',
            'options' => [
                'glm-5.2'      => __('GLM-5.2 (Best Performance)', 'ht-mega-for-elementor'),
                'glm-5-turbo'  => __('GLM-5-Turbo (Balanced)', 'ht-mega-for-elementor'),
                'glm-4.7-flash' => __('GLM-4.7-Flash (Fast & Affordable)', 'ht-mega-for-elementor'),
            ],
            'condition' => [ ['condition_key' => 'htmega_ai_enable', 'condition_value' => 'on'] , ['condition_key' => 'htmega_ai_engine', 'condition_value' => 'zai'] ],
            'desc'      => __('Select the Z.ai model to use for content, section, and page generation.', 'ht-mega-for-elementor'),
        ];

        return $fields;
    }
    
    /**
     * Initialize AI features if enabled
     */
    public function maybe_init_ai() {
        if ($this->is_ai_enabled()) {
            $this->current_engine = $this->get_ai_option('htmega_ai_engine', 'openai');
            $this->init_ai_features();
        }
    }
    
    /**
     * Initialize AI features
     */
    private function init_ai_features() {
        // Enqueue AI scripts in Elementor editor
        add_action('elementor/editor/before_enqueue_scripts', [$this, 'enqueue_ai_scripts']);
        
        // Add AI button to widgets
        add_action('elementor/element/after_section_end', [$this, 'inject_ai_buttons'], 10, 2);
        
        // AJAX handlers
        add_action('wp_ajax_htmega_ai_generate', [$this, 'handle_ai_generation']);
        add_action('wp_ajax_htmega_ai_test_connection', [$this, 'test_api_connection']);
    }
    
    /**
     * Enqueue AI scripts for Elementor editor
     */
    public function enqueue_ai_scripts() {
        wp_enqueue_script(
            'htmega-ai-integration',
            HTMEGA_ADDONS_PL_URL . 'admin/assets/js/htmega-ai-integration.js',
            ['jquery'],
            HTMEGA_VERSION,
            true
        );
        
        wp_enqueue_style(
            'htmega-ai-integration',
            HTMEGA_ADDONS_PL_URL . 'admin/assets/css/htmega-ai-integration.css',
            [],
            HTMEGA_VERSION
        );
        
        // Localize script with AI settings
        wp_localize_script('htmega-ai-integration', 'htmegaAI', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('htmega_ai_nonce'),
            'api_key_set' => $this->is_api_key_configured(),
            'current_engine' => $this->current_engine,
            'admin_url' => admin_url(),
            'strings' => [
                'generating' => esc_html__('Generating...', 'ht-mega-for-elementor'),
                'api_not_configured' => esc_html__('AI Engine not configured', 'ht-mega-for-elementor'),
                'configure_api' => esc_html__('Please set up your AI Engine in the HT Mega settings before using this feature.', 'ht-mega-for-elementor'),
                'go_to_settings' => esc_html__('Go to Settings', 'ht-mega-for-elementor'),
                'error_occurred' => esc_html__('An error occurred. Please try again.', 'ht-mega-for-elementor'),
                'write_with_ai' => esc_html__('Write with HT Mega AI', 'ht-mega-for-elementor'),
            ]
        ]);
    }
    
    /**
     * Inject AI buttons into widgets
     */
    public function inject_ai_buttons($element, $section_id) {
        // Only add to content sections that likely have text controls
        $target_sections = ['section_content', 'content_section', 'section_title', 'section_button'];
        
        if (!in_array($section_id, $target_sections)) {
            return;
        }
        
        // Add AI button control (will be handled by JavaScript)
        $element->start_injection([
            'type' => 'section',
            'at' => 'end',
            'of' => $section_id,
        ]);
        
        $element->add_control(
            'htmega_ai_helper_' . $section_id,
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => '<div class="htmega-ai-widget-helper" data-section="' . $section_id . '"></div>',
                'content_classes' => 'htmega-ai-control-wrapper',
            ]
        );
        
        $element->end_injection();
    }
    
    /**
     * Handle AI generation request
     */
    public function handle_ai_generation() {
        if ( ! current_user_can( 'edit_posts' ) ) {
            wp_send_json_error( array( 'message' => __( 'Forbidden.', 'ht-mega-for-elementor' ) ), 403 );
            return;
        }
        $nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
        if ( ! wp_verify_nonce( $nonce, 'htmega_ai_nonce' ) ) {
            wp_send_json_error( array( 'message' => __( 'Invalid security token', 'ht-mega-for-elementor' ) ) );
            return;
        }
        
        // Check if AI is enabled
        if (!$this->is_ai_enabled()) {
            wp_send_json_error('AI integration is not enabled');
            return;
        }
        
        // Check API key
        if (!$this->is_api_key_configured()) {
            wp_send_json_error('API key not configured');
            return;
        }
        
        $prompt = isset( $_POST['prompt'] ) ? sanitize_textarea_field( wp_unslash( $_POST['prompt'] ) ) : '';
        $widget_type = isset( $_POST['widget_type'] ) ? sanitize_text_field( wp_unslash( $_POST['widget_type'] ) ) : '';
        $control_name = isset( $_POST['control_name'] ) ? sanitize_text_field( wp_unslash( $_POST['control_name'] ) ) : '';
        $context = isset( $_POST['context'] ) ? sanitize_textarea_field( wp_unslash( $_POST['context'] ) ) : '';
        
        if (empty($prompt)) {
            wp_send_json_error('Prompt is required');
            return;
        }
        
        try {
            $generated_content = $this->generate_ai_content($prompt, $widget_type, $control_name, $context);
            wp_send_json_success([
                'content' => $generated_content,
                'engine' => $this->current_engine
            ]);
        } catch (Exception $e) {
            wp_send_json_error('AI generation failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Test API connection
     */
    public function test_api_connection() {
        if ( ! current_user_can( 'edit_posts' ) ) {
            wp_send_json_error( array( 'message' => __( 'Forbidden.', 'ht-mega-for-elementor' ) ), 403 );
            return;
        }
        $nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
        if ( ! wp_verify_nonce( $nonce, 'htmega_ai_nonce' ) ) {
            wp_send_json_error( array( 'message' => __( 'Invalid security token', 'ht-mega-for-elementor' ) ) );
            return;
        }
        
        try {
            $test_response = $this->generate_ai_content('Say "Connection successful!" in exactly those words.', 'test', 'test');
            
            wp_send_json_success([
                'message' => 'API connection is working perfectly!',
                'response' => $test_response,
                'engine' => $this->current_engine
            ]);
        } catch (Exception $e) {
            wp_send_json_error([
                'message' => $e->getMessage(),
                'suggestions' => $this->get_error_suggestions($e->getMessage()),
                'engine' => $this->current_engine
            ]);
        }
    }
    
    /**
     * Generate AI content based on current engine
     */
    private function generate_ai_content($prompt, $widget_type = '', $control_name = '', $context = '') {
        // Enhance prompt with context
        $enhanced_prompt = $this->enhance_prompt($prompt, $widget_type, $control_name, $context);

        // Route to appropriate AI service
        switch ($this->current_engine) {
            case 'claude':
                return $this->generate_claude_content($enhanced_prompt);
            case 'google':
                return $this->generate_google_content($enhanced_prompt);
            case 'deepseek':
                return $this->generate_deepseek_content($enhanced_prompt);
            case 'kimi':
                return $this->generate_kimi_content($enhanced_prompt);
            case 'zai':
                return $this->generate_zai_content($enhanced_prompt);
            case 'openai':
            default:
                return $this->generate_openai_content($enhanced_prompt);
        }
    }

    /**
     * Generate structured (JSON) output based on the currently configured engine.
     *
     * Unlike generate_ai_content() (plain text, used by the field-level "Write with AI"
     * button), this forces the model to return JSON matching $schema — used by the
     * AI Section Assistant to get back {widget_slug, layout_variant, design_style, content}
     * instead of a prose string.
     *
     * @param string $prompt     User-facing task description.
     * @param array  $schema     JSON-schema-like array: ['type' => 'object', 'properties' => [...], 'required' => [...]].
     * @param string $tool_name  Logical name for the structured call (used by Claude's tool-use format).
     * @return array Decoded JSON response matching $schema.
     * @throws Exception on API failure or a response that doesn't parse as JSON.
     */
    public function generate_structured_content( $prompt, array $schema, $tool_name = 'generate_output' ) {
        // Dev-only escape hatch — define('HTMEGA_AI_MOCK_MODE', true) in wp-config.php
        // (never in a live/production config) to exercise the whole selection →
        // content → assembly → insert pipeline with zero real API calls, e.g. while
        // rate-limited. Schema-driven, so it works for both the selection and
        // content calls without separate mock logic per call site.
        if ( defined( 'HTMEGA_AI_MOCK_MODE' ) && HTMEGA_AI_MOCK_MODE ) {
            return $this->mock_from_schema( $schema );
        }

        switch ( $this->current_engine ) {
            case 'claude':
                return $this->generate_claude_content( $prompt, null, null, $schema, $tool_name );
            case 'google':
                return $this->generate_google_content( $prompt, null, null, $schema );
            case 'deepseek':
                return $this->generate_deepseek_content( $prompt, null, null, $schema, $tool_name );
            case 'kimi':
                return $this->generate_kimi_content( $prompt, null, null, $schema, $tool_name );
            case 'zai':
                return $this->generate_zai_content( $prompt, null, null, $schema, $tool_name );
            case 'openai':
            default:
                return $this->generate_openai_content( $prompt, null, null, $schema, $tool_name );
        }
    }

    /**
     * Walk a JSON-schema (the same shape passed to the real providers) and produce
     * synthetic-but-schema-valid data — enum fields pick a real value (so a mock
     * "selection" call always returns a real widget_slug/layout/style), string
     * fields get placeholder text naming the field, arrays get minItems rows.
     * Deliberately does NOT special-case headline/headline_highlight to be a real
     * substring of each other — that's a good thing: it means mock mode also
     * exercises the clean_field_value()/assemble_element() safety check that's
     * supposed to catch exactly that mismatch.
     */
    private function mock_from_schema( $schema ) {
        if ( ! is_array( $schema ) || ! isset( $schema['type'] ) ) {
            return null;
        }

        switch ( $schema['type'] ) {
            case 'object':
                $out = [];
                foreach ( (array) ( $schema['properties'] ?? [] ) as $key => $prop_schema ) {
                    $out[ $key ] = $this->mock_from_schema( $prop_schema );
                }
                return $out;

            case 'array':
                $count = isset( $schema['minItems'] ) ? (int) $schema['minItems'] : 2;
                $items = [];
                for ( $i = 0; $i < $count; $i++ ) {
                    $items[] = $this->mock_from_schema( $schema['items'] ?? [ 'type' => 'string' ] );
                }
                return $items;

            case 'boolean':
                return false; // e.g. selection's no_match — mock mode always "finds" a match.

            case 'string':
            default:
                if ( ! empty( $schema['enum'] ) ) {
                    return $schema['enum'][ array_rand( $schema['enum'] ) ];
                }
                return '[Mock] Sample generated text for testing.';
        }
    }
    
    /**
     * Generate content using OpenAI
     *
     * @param string      $prompt
     * @param string|null $api_key
     * @param string|null $model
     * @param array|null  $schema    When provided, forces structured JSON output matching this schema.
     * @param string      $tool_name Logical name for the structured call.
     */
    private function generate_openai_content($prompt, $api_key = null, $model = null, $schema = null, $tool_name = 'generate_output') {
        if( empty($api_key) ){
            $api_key = $this->get_ai_option('htmega_openai_api_key');
        }
        if( empty($model) ){
            $model = $this->get_valid_model_option('htmega_openai_model', 'gpt-5.6-luna');
        }

        // Validate API key
        if (empty($api_key)) {
            throw new Exception('OpenAI API key is not configured');
        }

        $validation_result = $this->validate_openai_key($api_key);
        if ($validation_result !== true) {
            // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- message is sanitized with wp_strip_all_tags() where it's built above, and this exception is only ever caught and passed to wp_send_json_error() (JSON-encoded).
            throw new Exception($validation_result);
        }

        // Prepare request body
        $body = [
            'model' => $model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a helpful assistant for creating website content. Provide clear, engaging, and professional content suitable for websites. Each response should be creative and engaging.'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            // Newer OpenAI models (the gpt-5.6 family and reasoning models like o1/o3)
            // reject 'max_tokens' outright ("Unsupported parameter... Use
            // 'max_completion_tokens' instead") — this is OpenAI's own rename, not
            // something optional to keep backward-compatible with, since every
            // model currently in htmega_openai_model's dropdown requires the new name.
            'max_completion_tokens' => 500,
            // Also newer-OpenAI-model fallout, same as max_completion_tokens above:
            // gpt-5.6 rejects any non-default temperature outright ("Unsupported
            // value... Only the default (1) value is supported"). Omitting these
            // entirely lets the API use its required default rather than us trying
            // to guess/send one — top_p and frequency_penalty are the same family
            // of "custom sampling" params and are dropped for the same reason.
            'n' => 1
        ];

        if ( ! empty( $schema ) ) {
            $body['response_format'] = [
                'type' => 'json_schema',
                'json_schema' => [
                    'name'   => $tool_name,
                    'strict' => true,
                    'schema' => $schema,
                ],
            ];
            // Structured picks (widget/layout/style + a handful of content fields) need more room than a single field rewrite.
            $body['max_completion_tokens'] = 1500;
        }

        $response = wp_remote_post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json',
                'User-Agent' => 'HT-Mega-AI/1.0',
            ],
            'body' => json_encode($body),
            'timeout' => 60,
            'sslverify' => true,
        ]);

        return $this->process_openai_response($response, ! empty( $schema ), $model);
    }
    
    /**
     * Generate content using Claude
     *
     * @param array|null $schema    When provided, forces structured JSON output matching this schema via tool-use.
     * @param string     $tool_name Tool name Claude will be forced to call.
     */
    private function generate_claude_content($prompt, $api_key = null, $model = null, $schema = null, $tool_name = 'generate_output') {
        $api_key = $this->get_ai_option('htmega_claude_api_key');
        $model = $this->get_valid_model_option('htmega_claude_model', 'claude-sonnet-5');

        // Validate API key
        if (empty($api_key)) {
            throw new Exception('Claude API key is not configured');
        }

        $validation_result = $this->validate_claude_key($api_key);
        if ($validation_result !== true) {
            // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- message is sanitized with wp_strip_all_tags() where it's built above, and this exception is only ever caught and passed to wp_send_json_error() (JSON-encoded).
            throw new Exception($validation_result);
        }

        // Prepare request body
        $body = [
            'model' => $model,
            'max_tokens' => 500,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'system' => 'You are a helpful assistant for creating website content. Provide clear, engaging, and professional content suitable for websites. Each response should be creative and engaging.'
        ];

        if ( ! empty( $schema ) ) {
            $body['tools'] = [
                [
                    'name'         => $tool_name,
                    'description'  => 'Return the requested structured data.',
                    'input_schema' => $schema,
                ],
            ];
            $body['tool_choice'] = [ 'type' => 'tool', 'name' => $tool_name ];
            $body['max_tokens']  = 1500;
        }

        $response = wp_remote_post('https://api.anthropic.com/v1/messages', [
            'headers' => [
                'x-api-key' => $api_key,
                'anthropic-version' => '2023-06-01',
                'Content-Type' => 'application/json',
                'User-Agent' => 'HT-Mega-AI/1.0',
            ],
            'body' => json_encode($body),
            'timeout' => 60,
            'sslverify' => true,
        ]);

        return $this->process_claude_response($response, ! empty( $schema ), $model, $tool_name);
    }
    
    /**
     * Generate content using Google AI
     *
     * @param array|null $schema When provided, forces structured JSON output matching this schema.
     */
    private function generate_google_content($prompt, $api_key = null, $model = null, $schema = null) {
        $api_key = $this->get_ai_option('htmega_google_api_key');
        $model = $this->get_valid_model_option('htmega_google_model', 'gemini-3.6-flash');

        // Validate API key
        if (empty($api_key)) {
            throw new Exception('Google AI API key is not configured');
        }

        $validation_result = $this->validate_google_key($api_key, $model);
        if ($validation_result !== true) {
            // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- message is sanitized with wp_strip_all_tags() where it's built above, and this exception is only ever caught and passed to wp_send_json_error() (JSON-encoded).
            throw new Exception($validation_result);
        }

        // Prepare request body
        $body = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => "You are a helpful assistant for creating website content. Provide clear, engaging, and professional content suitable for websites. Each response should be creative and engaging.\n\n" . $prompt
                        ]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.8,
                'topP' => 0.9,
                'maxOutputTokens' => 500,
            ]
        ];

        if ( ! empty( $schema ) ) {
            $body['generationConfig']['responseMimeType'] = 'application/json';
            $body['generationConfig']['responseSchema']   = $schema;
            $body['generationConfig']['maxOutputTokens']  = 1500;
        }

        // v1beta is being phased out in favor of the stable v1 endpoint.
        $url = "https://generativelanguage.googleapis.com/v1/models/{$model}:generateContent?key={$api_key}";

        $response = wp_remote_post($url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'User-Agent' => 'HT-Mega-AI/1.0',
            ],
            'body' => json_encode($body),
            'timeout' => 60,
            'sslverify' => true,
        ]);

        return $this->process_google_response($response, ! empty( $schema ), $model);
    }

    /**
     * Generate content using DeepSeek (OpenAI-compatible chat-completions API,
     * verified against https://api-docs.deepseek.com/).
     *
     * DeepSeek confirmed to support only response_format: {type: 'json_object'} —
     * NOT OpenAI's strict json_schema structured-output mode. Without server-side
     * schema enforcement, the shape is instead described directly in the prompt
     * (DeepSeek's own docs recommend exactly this: "include the word 'json'...
     * and provide an example of the desired format"). Downstream code
     * (htmega_ai_validate_selection(), clean_field_value(), etc. in the AI
     * Section Assistant) never trusts a model's structured output blindly
     * already, so a schema-noncompliant response degrades gracefully instead
     * of breaking.
     *
     * @param array|null $schema When provided, requests JSON matching this shape (best-effort, not enforced).
     */
    private function generate_deepseek_content($prompt, $api_key = null, $model = null, $schema = null, $tool_name = 'generate_output') {
        if ( empty( $api_key ) ) {
            $api_key = $this->get_ai_option('htmega_deepseek_api_key');
        }
        if ( empty( $model ) ) {
            $model = $this->get_valid_model_option('htmega_deepseek_model', 'deepseek-v4-flash');
        }

        if (empty($api_key)) {
            throw new Exception('DeepSeek API key is not configured');
        }

        $validation_result = $this->validate_deepseek_key($api_key, $model);
        if ($validation_result !== true) {
            // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- message is sanitized with wp_strip_all_tags() where it's built above, and this exception is only ever caught and passed to wp_send_json_error() (JSON-encoded).
            throw new Exception($validation_result);
        }

        $system_content = 'You are a helpful assistant for creating website content. Provide clear, engaging, and professional content suitable for websites. Each response should be creative and engaging.';

        if ( ! empty( $schema ) ) {
            $system_content .= "\n\nRespond with ONLY a single valid JSON object — no markdown, no commentary — matching exactly this JSON Schema:\n" . wp_json_encode( $schema );
        }

        $body = [
            'model' => $model,
            'messages' => [
                [ 'role' => 'system', 'content' => $system_content ],
                [ 'role' => 'user', 'content' => $prompt ],
            ],
            'max_tokens' => 500,
        ];

        if ( ! empty( $schema ) ) {
            $body['response_format'] = [ 'type' => 'json_object' ];
            $body['max_tokens'] = 1500;
        }

        $response = wp_remote_post('https://api.deepseek.com/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json',
                'User-Agent' => 'HT-Mega-AI/1.0',
            ],
            'body' => json_encode($body),
            'timeout' => 60,
            'sslverify' => true,
        ]);

        return $this->process_openai_response($response, ! empty( $schema ), $model, 'deepseek');
    }

    /**
     * Generate content using Kimi / Moonshot AI (OpenAI-compatible chat-
     * completions API, verified against https://platform.kimi.ai/docs/api/chat).
     *
     * Unlike DeepSeek/Z.ai, Kimi confirmed to support OpenAI's exact strict
     * json_schema structured-output shape — same body shape as
     * generate_openai_content(). Schemas must conform to Moonshot's "MFJS"
     * spec; the plain object/enum/array schemas this plugin generates (see
     * section-manifest.php) are well within that.
     *
     * @param array|null $schema When provided, forces structured JSON output matching this schema.
     */
    private function generate_kimi_content($prompt, $api_key = null, $model = null, $schema = null, $tool_name = 'generate_output') {
        if ( empty( $api_key ) ) {
            $api_key = $this->get_ai_option('htmega_kimi_api_key');
        }
        if ( empty( $model ) ) {
            $model = $this->get_valid_model_option('htmega_kimi_model', 'kimi-k3');
        }

        if (empty($api_key)) {
            throw new Exception('Kimi API key is not configured');
        }

        $validation_result = $this->validate_kimi_key($api_key, $model);
        if ($validation_result !== true) {
            // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- message is sanitized with wp_strip_all_tags() where it's built above, and this exception is only ever caught and passed to wp_send_json_error() (JSON-encoded).
            throw new Exception($validation_result);
        }

        $body = [
            'model' => $model,
            'messages' => [
                [ 'role' => 'system', 'content' => 'You are a helpful assistant for creating website content. Provide clear, engaging, and professional content suitable for websites. Each response should be creative and engaging.' ],
                [ 'role' => 'user', 'content' => $prompt ],
            ],
            // Confirmed via Kimi's own docs: max_completion_tokens (max_tokens is
            // deprecated there too), and the 'n' param is unsupported on K-series
            // models (kimi-k3/k2.7/k2.6/k2.5, our whole model list) — only
            // moonshot-v1 models accept it — so it's deliberately omitted here
            // rather than sent as 1 "just in case."
            'max_completion_tokens' => 500,
        ];

        if ( ! empty( $schema ) ) {
            $body['response_format'] = [
                'type' => 'json_schema',
                'json_schema' => [
                    'name'   => $tool_name,
                    'strict' => true,
                    'schema' => $schema,
                ],
            ];
            $body['max_completion_tokens'] = 1500;
        }

        $response = wp_remote_post('https://api.moonshot.ai/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json',
                'User-Agent' => 'HT-Mega-AI/1.0',
            ],
            'body' => json_encode($body),
            'timeout' => 60,
            'sslverify' => true,
        ]);

        return $this->process_openai_response($response, ! empty( $schema ), $model, 'kimi');
    }

    /**
     * Generate content using Z.ai / GLM (OpenAI-compatible chat-completions
     * API, verified against https://docs.z.ai/api-reference/llm/chat-completion).
     *
     * Same "no strict schema enforcement, describe it in the prompt instead"
     * situation as DeepSeek above — Z.ai confirmed to support only
     * response_format: {type: 'json_object'}, not json_schema.
     *
     * @param array|null $schema When provided, requests JSON matching this shape (best-effort, not enforced).
     */
    private function generate_zai_content($prompt, $api_key = null, $model = null, $schema = null, $tool_name = 'generate_output') {
        if ( empty( $api_key ) ) {
            $api_key = $this->get_ai_option('htmega_zai_api_key');
        }
        if ( empty( $model ) ) {
            $model = $this->get_valid_model_option('htmega_zai_model', 'glm-5.2');
        }

        if (empty($api_key)) {
            throw new Exception('Z.ai API key is not configured');
        }

        $validation_result = $this->validate_zai_key($api_key, $model);
        if ($validation_result !== true) {
            // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- message is sanitized with wp_strip_all_tags() where it's built above, and this exception is only ever caught and passed to wp_send_json_error() (JSON-encoded).
            throw new Exception($validation_result);
        }

        $system_content = 'You are a helpful assistant for creating website content. Provide clear, engaging, and professional content suitable for websites. Each response should be creative and engaging.';

        if ( ! empty( $schema ) ) {
            $system_content .= "\n\nRespond with ONLY a single valid JSON object — no markdown, no commentary — matching exactly this JSON Schema:\n" . wp_json_encode( $schema );
        }

        $body = [
            'model' => $model,
            'messages' => [
                [ 'role' => 'system', 'content' => $system_content ],
                [ 'role' => 'user', 'content' => $prompt ],
            ],
            'max_tokens' => 500,
        ];

        if ( ! empty( $schema ) ) {
            $body['response_format'] = [ 'type' => 'json_object' ];
            $body['max_tokens'] = 1500;
        }

        $response = wp_remote_post('https://api.z.ai/api/paas/v4/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json',
                'User-Agent' => 'HT-Mega-AI/1.0',
            ],
            'body' => json_encode($body),
            'timeout' => 60,
            'sslverify' => true,
        ]);

        return $this->process_openai_response($response, ! empty( $schema ), $model, 'zai');
    }

    /**
     * Branded display name for an engine key — used only in user-facing error
     * messages from process_openai_response(). NOT ucfirst($engine): that
     * mangles every name here except 'kimi' ('openai' -> 'Openai', losing the
     * existing "OpenAI" capitalization on error text that predates this
     * method; 'deepseek' -> 'Deepseek' instead of 'DeepSeek'; 'zai' -> 'Zai'
     * instead of 'Z.ai').
     */
    private function engine_display_name( $engine ) {
        $names = [
            'openai'   => 'OpenAI',
            'claude'   => 'Claude',
            'google'   => 'Google',
            'deepseek' => 'DeepSeek',
            'kimi'     => 'Kimi',
            'zai'      => 'Z.ai',
        ];
        return $names[ $engine ] ?? ucfirst( $engine );
    }

    /**
     * Process OpenAI API response — also reused as-is for DeepSeek/Kimi/Z.ai
     * (all 3 confirmed OpenAI-compatible chat-completions response shape, see
     * add_ai_settings()'s DeepSeek/Kimi/Z.ai field blocks), rather than
     * duplicating this parsing 3 more times.
     *
     * @param mixed       $response
     * @param bool        $structured Whether this call requested structured (json_schema) output.
     * @param string|null $model      Model used, for usage-cost logging.
     * @param string      $engine     Which provider actually made this call — only affects the
     *                                usage-log 'engine' label (get_usage_summary()'s per-engine
     *                                breakdown), not parsing; defaults to 'openai' for the real
     *                                OpenAI call site.
     * @return string|array Plain text, or a decoded array when $structured is true.
     */
    private function process_openai_response($response, $structured = false, $model = null, $engine = 'openai') {
        // Check for WordPress HTTP errors
        if (is_wp_error($response)) {
            // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- message is sanitized with wp_strip_all_tags() or engine_display_name() returns a static whitelisted string; exception is only caught and passed to wp_send_json_error() (JSON-encoded).
            throw new Exception('API request failed: ' . wp_strip_all_tags( $response->get_error_message() ));
        }

        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);

        if ($response_code !== 200) {
            $error_data = json_decode($response_body, true);
            $error_message = 'HTTP ' . $response_code;

            if (isset($error_data['error']['message'])) {
                $error_message = wp_strip_all_tags( $error_data['error']['message'] );
            }

            // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- message is sanitized with wp_strip_all_tags() where it's built above, and this exception is only ever caught and passed to wp_send_json_error() (JSON-encoded).
            throw new Exception($error_message);
        }

        $data = json_decode($response_body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- message is sanitized with wp_strip_all_tags() or engine_display_name() returns a static whitelisted string; exception is only caught and passed to wp_send_json_error() (JSON-encoded).
            throw new Exception( 'Invalid JSON response from ' . $this->engine_display_name( $engine ) );
        }

        if (isset($data['error'])) {
            // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- message is sanitized with wp_strip_all_tags() or engine_display_name() returns a static whitelisted string; exception is only caught and passed to wp_send_json_error() (JSON-encoded).
            throw new Exception( $this->engine_display_name( $engine ) . ' API error: ' . wp_strip_all_tags( $data['error']['message'] ) );
        }

        if (!isset($data['choices'][0]['message']['content'])) {
            throw new Exception('Invalid API response structure');
        }

        if ( isset( $data['usage'] ) ) {
            $this->log_usage( $engine, $model, $data['usage']['prompt_tokens'] ?? 0, $data['usage']['completion_tokens'] ?? 0 );
        }

        $generated_content = trim($data['choices'][0]['message']['content']);

        if (empty($generated_content)) {
            // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- message is sanitized with wp_strip_all_tags() or engine_display_name() returns a static whitelisted string; exception is only caught and passed to wp_send_json_error() (JSON-encoded).
            throw new Exception( 'Empty response from ' . $this->engine_display_name( $engine ) . ' API' );
        }

        if ( $structured ) {
            $decoded = json_decode( $generated_content, true );
            if ( json_last_error() !== JSON_ERROR_NONE || ! is_array( $decoded ) ) {
            // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- message is sanitized with wp_strip_all_tags() or engine_display_name() returns a static whitelisted string; exception is only caught and passed to wp_send_json_error() (JSON-encoded).
                throw new Exception( $this->engine_display_name( $engine ) . ' did not return valid structured JSON' );
            }
            return $decoded;
        }

        return $generated_content;
    }
    
    /**
     * Process Claude API response
     *
     * @param bool        $structured Whether this call forced tool-use structured output.
     * @param string|null $model      Model used, for usage-cost logging.
     * @param string      $tool_name  Tool name forced in the request, to locate the matching tool_use block.
     * @return string|array Plain text, or the tool's decoded input array when $structured is true.
     */
    private function process_claude_response($response, $structured = false, $model = null, $tool_name = 'generate_output') {
        if (is_wp_error($response)) {
            // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- message is sanitized with wp_strip_all_tags() or engine_display_name() returns a static whitelisted string; exception is only caught and passed to wp_send_json_error() (JSON-encoded).
            throw new Exception('API request failed: ' . wp_strip_all_tags( $response->get_error_message() ));
        }

        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);

        if ($response_code !== 200) {
            $error_data = json_decode($response_body, true);
            $error_message = 'HTTP ' . $response_code;

            if (isset($error_data['error']['message'])) {
                $error_message = wp_strip_all_tags( $error_data['error']['message'] );
            }

            // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- message is sanitized with wp_strip_all_tags() where it's built above, and this exception is only ever caught and passed to wp_send_json_error() (JSON-encoded).
            throw new Exception($error_message);
        }

        $data = json_decode($response_body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON response from Claude');
        }

        if (isset($data['error'])) {
            // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- message is sanitized with wp_strip_all_tags() or engine_display_name() returns a static whitelisted string; exception is only caught and passed to wp_send_json_error() (JSON-encoded).
            throw new Exception('Claude API error: ' . wp_strip_all_tags( $data['error']['message'] ));
        }

        if ( isset( $data['usage'] ) ) {
            $this->log_usage( 'claude', $model, $data['usage']['input_tokens'] ?? 0, $data['usage']['output_tokens'] ?? 0 );
        }

        if ( $structured ) {
            foreach ( (array) ( $data['content'] ?? [] ) as $block ) {
                if ( isset( $block['type'], $block['input'] ) && 'tool_use' === $block['type'] && $block['name'] === $tool_name ) {
                    return $block['input'];
                }
            }
            throw new Exception( 'Claude did not return the expected tool call' );
        }

        if (!isset($data['content'][0]['text'])) {
            throw new Exception('Invalid Claude API response structure');
        }

        $generated_content = trim($data['content'][0]['text']);

        if (empty($generated_content)) {
            throw new Exception('Empty response from Claude API');
        }

        return $generated_content;
    }
    
    /**
     * Process Google AI API response
     *
     * @param bool        $structured Whether this call requested structured (responseSchema) output.
     * @param string|null $model      Model used, for usage-cost logging.
     * @return string|array Plain text, or a decoded array when $structured is true.
     */
    private function process_google_response($response, $structured = false, $model = null) {
        if (is_wp_error($response)) {
            // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- message is sanitized with wp_strip_all_tags() or engine_display_name() returns a static whitelisted string; exception is only caught and passed to wp_send_json_error() (JSON-encoded).
            throw new Exception('API request failed: ' . wp_strip_all_tags( $response->get_error_message() ));
        }

        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);

        if ($response_code !== 200) {
            $error_data = json_decode($response_body, true);
            $error_message = 'HTTP ' . $response_code;

            if (isset($error_data['error']['message'])) {
                $error_message = wp_strip_all_tags( $error_data['error']['message'] );
            }

            // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- message is sanitized with wp_strip_all_tags() where it's built above, and this exception is only ever caught and passed to wp_send_json_error() (JSON-encoded).
            throw new Exception($error_message);
        }

        $data = json_decode($response_body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON response from Google AI');
        }

        if (isset($data['error'])) {
            // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped -- message is sanitized with wp_strip_all_tags() or engine_display_name() returns a static whitelisted string; exception is only caught and passed to wp_send_json_error() (JSON-encoded).
            throw new Exception('Google AI error: ' . wp_strip_all_tags( $data['error']['message'] ));
        }

        if ( isset( $data['usageMetadata'] ) ) {
            $this->log_usage( 'google', $model, $data['usageMetadata']['promptTokenCount'] ?? 0, $data['usageMetadata']['candidatesTokenCount'] ?? 0 );
        }

        if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            throw new Exception('Invalid Google AI response structure');
        }

        $generated_content = trim($data['candidates'][0]['content']['parts'][0]['text']);

        if (empty($generated_content)) {
            throw new Exception('Empty response from Google AI');
        }

        if ( $structured ) {
            $decoded = json_decode( $generated_content, true );
            if ( json_last_error() !== JSON_ERROR_NONE || ! is_array( $decoded ) ) {
                throw new Exception( 'Google AI did not return valid structured JSON' );
            }
            return $decoded;
        }

        return $generated_content;
    }
    
    /**
     * Enhance prompt with widget context
     */
    private function enhance_prompt($prompt, $widget_type, $control_name, $context) {
        $widget_contexts = [
            'heading' => [
                'title' => 'Create a compelling headline',
                'subtitle' => 'Write a supporting subtitle'
            ],
            'button' => [
                'text' => 'Generate call-to-action button text',
                'url' => 'Suggest relevant URL'
            ],
            'text-editor' => [
                'content' => 'Write engaging content'
            ],
        ];
        
        $context_prefix = '';
        if (isset($widget_contexts[$widget_type][$control_name])) {
            $context_prefix = $widget_contexts[$widget_type][$control_name] . ': ';
        } elseif ($widget_type) {
            $context_prefix = "For a {$widget_type} widget: ";
        }
        
        // System instruction for clean output
        $system_instruction = "IMPORTANT Note: Return ONLY the exact content to be inserted, with no additional text. DO NOT include any labels, prefixes, or descriptors such as 'Heading Text:', 'Content:', 'Button Text:', etc. DO NOT add quotes, explanations, or any other text. The response should contain ONLY the content that will be directly inserted into the field and no variation content at a time.";
        
        $enhanced_prompt = $prompt;
        if ($context) {
            $enhanced_prompt = $system_instruction . "\n\nTask: " . $enhanced_prompt . "\n\nCurrent Content: " . $context;
        } else {
            $enhanced_prompt = $system_instruction . "\n\nTask: " . $enhanced_prompt;
        }
        
        return $enhanced_prompt;
    }
    
    /**
     * Check if AI is enabled
     */
    private function is_ai_enabled() {
        $enable_option = $this->get_ai_option('htmega_ai_enable');
        if ( ! isset( $enable_option ) ) {
            return true;
        }
        return ($enable_option === 'on' || $enable_option === 'yes' || $enable_option === true);
    }
    
    /**
     * Check if API key is configured for current engine
     */
    private function is_api_key_configured() {
        switch ($this->current_engine) {
            case 'claude':
                $api_key = $this->get_ai_option('htmega_claude_api_key');
                return !empty($api_key);
            case 'google':
                $api_key = $this->get_ai_option('htmega_google_api_key');
                return !empty($api_key);
            case 'deepseek':
                $api_key = $this->get_ai_option('htmega_deepseek_api_key');
                return !empty($api_key);
            case 'kimi':
                $api_key = $this->get_ai_option('htmega_kimi_api_key');
                return !empty($api_key);
            case 'zai':
                $api_key = $this->get_ai_option('htmega_zai_api_key');
                return !empty($api_key);
            case 'openai':
            default:
                $api_key = $this->get_ai_option('htmega_openai_api_key');
                return !empty($api_key);
        }
    }
    
    /**
     * Get AI option value using your existing system
     */
    private function get_ai_option($option_key, $default = null) {
        // Use your existing function to get options
        if (function_exists('htmega_get_option')) {
            return htmega_get_option($option_key, 'htmega_ai_features_tabs', $default);
        }

        // Fallback to direct option retrieval
        return get_option($option_key, $default);
    }

    /**
     * Same as get_ai_option(), but for a model-select field specifically: if the
     * previously SAVED value isn't one of the model's own PRICE_TABLE keys, fall
     * back to $default instead of passing a stale model id straight to the API.
     *
     * Provider model IDs get retired frequently (see PRICE_TABLE's own comments) —
     * a value a user saved months ago can go invalid without them touching this
     * setting again. Without this, that stale value would silently keep erroring
     * every single generation until someone happens to re-open the dropdown and
     * re-save, exactly what just happened with a saved `gemini-1.5-pro` value.
     */
    private function get_valid_model_option( $option_key, $default ) {
        $saved = $this->get_ai_option( $option_key, $default );
        return isset( self::PRICE_TABLE[ $saved ] ) ? $saved : $default;
    }
    
    /**
     * Estimate USD cost for a call, from self::PRICE_TABLE. Informational only under BYOK.
     *
     * @return float 0.0 if the model isn't in the price table (unknown/new model) rather than guessing.
     */
    private function estimate_cost( $model, $prompt_tokens, $completion_tokens ) {
        if ( ! isset( self::PRICE_TABLE[ $model ] ) ) {
            return 0.0;
        }
        $rates = self::PRICE_TABLE[ $model ];
        return ( $prompt_tokens / 1000000 * $rates['input'] ) + ( $completion_tokens / 1000000 * $rates['output'] );
    }

    /**
     * Append one call's token usage to the rolling usage log (capped at self::USAGE_LOG_MAX entries).
     * Purely informational under BYOK — no charge happens on our side, the provider bills the user directly.
     */
    private function log_usage( $engine, $model, $prompt_tokens, $completion_tokens ) {
        $log = get_option( self::USAGE_LOG_OPTION, [] );
        if ( ! is_array( $log ) ) {
            $log = [];
        }

        $log[] = [
            'time'             => current_time( 'mysql' ),
            'engine'           => $engine,
            'model'            => $model,
            'prompt_tokens'    => (int) $prompt_tokens,
            'completion_tokens' => (int) $completion_tokens,
            'estimated_cost'   => $this->estimate_cost( $model, $prompt_tokens, $completion_tokens ),
        ];

        if ( count( $log ) > self::USAGE_LOG_MAX ) {
            $log = array_slice( $log, -1 * self::USAGE_LOG_MAX );
        }

        update_option( self::USAGE_LOG_OPTION, $log, false );
    }

    /**
     * Get the usage log, optionally summarized (total tokens + estimated cost for entries since $since).
     *
     * @param string|null $since 'mysql' datetime string; only entries at/after this are summarized. Null = all.
     * @return array{entries: array, total_tokens: int, total_cost: float}
     */
    public function get_usage_summary( $since = null ) {
        $log = get_option( self::USAGE_LOG_OPTION, [] );
        if ( ! is_array( $log ) ) {
            $log = [];
        }

        $entries = $since
            ? array_values( array_filter( $log, function( $row ) use ( $since ) {
                return isset( $row['time'] ) && $row['time'] >= $since;
            } ) )
            : $log;

        $total_tokens = 0;
        $total_cost   = 0.0;
        foreach ( $entries as $row ) {
            $total_tokens += (int) ( $row['prompt_tokens'] ?? 0 ) + (int) ( $row['completion_tokens'] ?? 0 );
            $total_cost   += (float) ( $row['estimated_cost'] ?? 0 );
        }

        return [
            'entries'      => $entries,
            'total_tokens' => $total_tokens,
            'total_cost'   => $total_cost,
        ];
    }

    /**
     * Get error suggestions based on AI engine
     */
    private function get_error_suggestions($error_message) {
        $suggestions = [];
        
        if (strpos($error_message, 'API key') !== false) {
            switch ($this->current_engine) {
                case 'claude':
                    $suggestions[] = 'Check that your Claude API key is correctly entered';
                    $suggestions[] = 'Ensure your Anthropic account has available credits';
                    break;
                case 'google':
                    $suggestions[] = 'Check that your Google AI API key is correctly entered';
                    $suggestions[] = 'Ensure the API key has proper permissions';
                    break;
                case 'deepseek':
                    $suggestions[] = 'Check that your DeepSeek API key is correctly entered';
                    $suggestions[] = 'Ensure your DeepSeek account has available credits';
                    break;
                case 'kimi':
                    $suggestions[] = 'Check that your Kimi API key is correctly entered';
                    $suggestions[] = 'Ensure your Moonshot AI account has available credits';
                    break;
                case 'zai':
                    $suggestions[] = 'Check that your Z.ai API key is correctly entered';
                    $suggestions[] = 'Ensure your Z.ai account has available credits';
                    break;
                case 'openai':
                default:
                    $suggestions[] = 'Check that your OpenAI API key is correctly entered';
                    $suggestions[] = 'Ensure your OpenAI account has available credits';
                    break;
            }
        } elseif (strpos($error_message, 'quota') !== false || strpos($error_message, 'rate limit') !== false) {
            $suggestions[] = 'Check your usage limits and billing information';
            $suggestions[] = 'Try again in a few moments';
        } else {
            $suggestions[] = 'Check your internet connection';
            $suggestions[] = 'Try again in a few moments';
        }
        
        return $suggestions;
    }
    
    /**
     * Validate OpenAI API key
     * 
     * @param string $api_key The API key to validate
     * @return bool|string True if valid, error message if invalid
     */
    public function validate_openai_key($api_key, $model = 'gpt-5.6-luna') {
        if (empty($api_key)) {
            return 'OpenAI API key is required';
        }

        $response = wp_remote_post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'model' => $model,
                'messages' => [
                    ['role' => 'user', 'content' => 'test']
                ],
                'max_completion_tokens' => 5
            ]),
            'timeout' => 15
        ]);

        if (is_wp_error($response)) {
            return 'Connection error: ' . wp_strip_all_tags( $response->get_error_message() );
        }

        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        $response_data = json_decode($response_body, true);

        if ($response_code !== 200) {
            $error_msg = isset($response_data['error']['message']) ? wp_strip_all_tags( $response_data['error']['message'] ) : 'Unknown error occurred';
            return 'OpenAI API error: ' . $error_msg;
        }

        return true;
    }

    /**
     * Validate DeepSeek API key
     *
     * @param string $api_key The API key to validate
     * @return bool|string True if valid, error message if invalid
     */
    public function validate_deepseek_key($api_key, $model = 'deepseek-v4-flash') {
        if (empty($api_key)) {
            return 'DeepSeek API key is required';
        }

        $response = wp_remote_post('https://api.deepseek.com/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'model' => $model,
                'messages' => [
                    ['role' => 'user', 'content' => 'test']
                ],
                'max_tokens' => 5
            ]),
            'timeout' => 15
        ]);

        if (is_wp_error($response)) {
            return 'Connection error: ' . wp_strip_all_tags( $response->get_error_message() );
        }

        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        $response_data = json_decode($response_body, true);

        if ($response_code !== 200) {
            $error_msg = isset($response_data['error']['message']) ? wp_strip_all_tags( $response_data['error']['message'] ) : 'Unknown error occurred';
            return 'DeepSeek API error: ' . $error_msg;
        }

        return true;
    }

    /**
     * Validate Kimi (Moonshot AI) API key
     *
     * @param string $api_key The API key to validate
     * @return bool|string True if valid, error message if invalid
     */
    public function validate_kimi_key($api_key, $model = 'kimi-k3') {
        if (empty($api_key)) {
            return 'Kimi API key is required';
        }

        $response = wp_remote_post('https://api.moonshot.ai/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'model' => $model,
                'messages' => [
                    ['role' => 'user', 'content' => 'test']
                ],
                // K-series models reject 'n' (see generate_kimi_content()) — omitted here too.
                'max_completion_tokens' => 5
            ]),
            'timeout' => 15
        ]);

        if (is_wp_error($response)) {
            return 'Connection error: ' . wp_strip_all_tags( $response->get_error_message() );
        }

        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        $response_data = json_decode($response_body, true);

        if ($response_code !== 200) {
            $error_msg = isset($response_data['error']['message']) ? wp_strip_all_tags( $response_data['error']['message'] ) : 'Unknown error occurred';
            return 'Kimi API error: ' . $error_msg;
        }

        return true;
    }

    /**
     * Validate Z.ai (GLM) API key
     *
     * @param string $api_key The API key to validate
     * @return bool|string True if valid, error message if invalid
     */
    public function validate_zai_key($api_key, $model = 'glm-5.2') {
        if (empty($api_key)) {
            return 'Z.ai API key is required';
        }

        $response = wp_remote_post('https://api.z.ai/api/paas/v4/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'model' => $model,
                'messages' => [
                    ['role' => 'user', 'content' => 'test']
                ],
                'max_tokens' => 5
            ]),
            'timeout' => 15
        ]);

        if (is_wp_error($response)) {
            return 'Connection error: ' . wp_strip_all_tags( $response->get_error_message() );
        }

        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        $response_data = json_decode($response_body, true);

        if ($response_code !== 200) {
            $error_msg = isset($response_data['error']['message']) ? wp_strip_all_tags( $response_data['error']['message'] ) : 'Unknown error occurred';
            return 'Z.ai API error: ' . $error_msg;
        }

        return true;
    }

    /**
     * Validate Claude API key
     * 
     * @param string $api_key The API key to validate
     * @return bool|string True if valid, error message if invalid
     */
    public function validate_claude_key($api_key) {
        if (empty($api_key)) {
            return 'Claude API key is required';
        }

        $response = wp_remote_post('https://api.anthropic.com/v1/messages', [
            'headers' => [
                'x-api-key' => $api_key,
                'anthropic-version' => '2023-06-01',
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'model' => 'claude-haiku-4-5',
                'max_tokens' => 5,
                'messages' => [
                    ['role' => 'user', 'content' => 'test']
                ]
            ]),
            'timeout' => 15
        ]);

        if (is_wp_error($response)) {
            return 'Connection error: ' . wp_strip_all_tags( $response->get_error_message() );
        }

        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        $response_data = json_decode($response_body, true);

        if ($response_code !== 200) {
            $error_msg = isset($response_data['error']['message']) ? wp_strip_all_tags( $response_data['error']['message'] ) : 'Unknown error occurred';
            return 'Claude API error: ' . $error_msg;
        }

        return true;
    }

    /**
     * Validate Google AI API key
     * 
     * @param string $api_key The API key to validate
     * @return bool|string True if valid, error message if invalid
     */
    public function validate_google_key($api_key, $model = 'gemini-3.6-flash') {
        if (empty($api_key)) {
            return 'Google AI API key is required';
        }
        $url = "https://generativelanguage.googleapis.com/v1/models/{$model}:generateContent?key={$api_key}";
        $response = wp_remote_post($url, [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'contents' => [
                    ['parts' => [['text' => 'test']]]
                ]
            ]),
            'timeout' => 15
        ]);

        if (is_wp_error($response)) {
            return 'Connection error: ' . wp_strip_all_tags( $response->get_error_message() );
        }

        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        $response_data = json_decode($response_body, true);

        if ($response_code !== 200) {
            $error_msg = isset($response_data['error']['message']) ? wp_strip_all_tags( $response_data['error']['message'] ) : 'Unknown error occurred';
            return 'Google AI API error: ' . $error_msg;
        }

        return true;
    }
}

// Initialize the AI integration only if needed
add_action('plugins_loaded', function() {
    if (class_exists('HTMega_AI_Integration')) {
        HTMega_AI_Integration::instance();
    }
}, 20);