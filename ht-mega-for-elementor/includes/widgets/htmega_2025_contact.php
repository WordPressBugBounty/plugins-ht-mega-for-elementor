<?php
/**
 * HT Mega 2026 — Contact Section Widget
 *
 * @package HT_Mega
 * @since   1.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class HTMega_Elementor_Widget_Contact_2025
 */
class HTMega_Elementor_Widget_Contact_2025 extends Widget_Base {

	public function get_name() {
		return 'htmega-2026-contact';
	}

	public function get_title() {
		return esc_html__( 'Contact 2026', 'htmega-addons' );
	}

	public function get_icon() {
		return 'htmega-icon eicon-mail';
	}

	public function get_categories() {
		return [ 'htmega-2026' ];
	}

	public function get_keywords() {
		return [ 'contact', 'form', 'email', 'address', 'map', 'htmega', '2026' ];
	}

	protected function register_controls() {

		// ── CONTENT TAB ────────────────────────────────────────────────────────

		// ── Design Style ──────────────────────────────────────────────────────
		$this->start_controls_section(
			'section_design_style',
			[
				'label' => esc_html__( 'Design Style', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'design_style',
			[
				'label'   => esc_html__( 'Style Preset', 'htmega-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bento',
				'options' => [
					'bento'  => esc_html__( 'Bento Grid',    'htmega-addons' ),
					'glass'  => esc_html__( 'Glassmorphism', 'htmega-addons' ),
					'dark'   => esc_html__( 'Dark Minimal',  'htmega-addons' ),
					'aurora' => esc_html__( 'Aurora',        'htmega-addons' ),
					'neo'    => esc_html__( 'Neo-Brutalist', 'htmega-addons' ),
				],
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'htmega-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'split',
				'options' => [
					'split'     => esc_html__( 'Split (Form + Info)', 'htmega-addons' ),
					'centered'  => esc_html__( 'Centered (Form only)', 'htmega-addons' ),
					'info-only' => esc_html__( 'Info Cards (no form)', 'htmega-addons' ),
				],
			]
		);

		$this->end_controls_section();

		// ── Section Header ─────────────────────────────────────────────────────
		$this->start_controls_section(
			'section_header',
			[
				'label' => esc_html__( 'Section Header', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_section_label',
			[
				'label'        => esc_html__( 'Show Section Label', 'htmega-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'section_label_text',
			[
				'label'     => esc_html__( 'Label Text', 'htmega-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Get In Touch', 'htmega-addons' ),
				'condition' => [ 'show_section_label' => 'yes' ],
			]
		);

		$this->add_control(
			'headline',
			[
				'label'   => esc_html__( 'Headline', 'htmega-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( "We'd Love to Hear From You", 'htmega-addons' ),
			]
		);

		$this->add_control(
			'headline_highlight',
			[
				'label'   => esc_html__( 'Headline Highlight', 'htmega-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Love', 'htmega-addons' ),
			]
		);

		$this->add_control(
			'headline_tag',
			[
				'label'   => esc_html__( 'Headline Tag', 'htmega-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'htmega-addons' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Have a question, project idea, or just want to say hello? Fill out the form and our team will be back in touch within 24 hours.', 'htmega-addons' ),
			]
		);

		$this->end_controls_section();

		// ── Contact Form ───────────────────────────────────────────────────────
		$this->start_controls_section(
			'section_form',
			[
				'label'     => esc_html__( 'Contact Form', 'htmega-addons' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [ 'layout' => [ 'split', 'centered' ] ],
			]
		);

		$this->add_control(
			'form_title',
			[
				'label'   => esc_html__( 'Form Title', 'htmega-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Send us a message', 'htmega-addons' ),
			]
		);

		$this->add_control(
			'form_subtitle',
			[
				'label'   => esc_html__( 'Form Subtitle', 'htmega-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( "Fill in the form and we'll get back to you shortly.", 'htmega-addons' ),
			]
		);

		$plugin_options = $this->get_available_form_plugins();

		if ( ! empty( $plugin_options ) ) {

			$this->add_control(
				'form_plugin',
				[
					'label'   => esc_html__( 'Form Plugin', 'htmega-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => array_key_first( $plugin_options ),
					'options' => $plugin_options,
				]
			);

			// Per-plugin form selectors — each shown only when its plugin is active.
			foreach ( $this->get_form_lists_per_plugin() as $plugin_key => $forms ) {
				// Auto-select the first real form (skip the empty "— Select a form —" placeholder).
				$real_forms = array_filter( $forms, fn( $k ) => '' !== $k, ARRAY_FILTER_USE_KEY );
				$default_id = ! empty( $real_forms ) ? (string) array_key_first( $real_forms ) : '';

				$this->add_control(
					'form_id_' . $plugin_key,
					[
						'label'     => esc_html__( 'Select Form', 'htmega-addons' ),
						'type'      => Controls_Manager::SELECT,
						'default'   => $default_id,
						'options'   => $forms,
						'condition' => [ 'form_plugin' => $plugin_key ],
					]
				);
			}

			$this->add_control(
				'form_css_class',
				[
					'label'       => esc_html__( 'Custom CSS Class', 'htmega-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => 'my-form-style',
					'description' => esc_html__( 'Optional extra class on the form wrapper div.', 'htmega-addons' ),
				]
			);

		} else {

			// Detect whether HT Contact Form is installed (but inactive) or not installed at all.
			$htcf_plugin_file = 'ht-contactform/contact-form-widget-elementor.php';
			$htcf_installed   = file_exists( WP_PLUGIN_DIR . '/' . $htcf_plugin_file );

			if ( $htcf_installed ) {
				$card_title   = esc_html__( 'HT Contact Form is installed but not active', 'htmega-addons' );
				$card_body    = esc_html__( 'Activate it to start embedding forms here — 38+ fields and 21+ integrations, completely free.', 'htmega-addons' );
				$button_label = esc_html__( 'Activate Now →', 'htmega-addons' );
				$data_action  = 'activate';
			} else {
				$card_title   = esc_html__( 'No form plugin installed', 'htmega-addons' );
				$card_body    = esc_html__( 'Install HT Contact Form — free drag & drop builder with 38+ fields and 21+ integrations. No coding required.', 'htmega-addons' );
				$button_label = esc_html__( 'Install Free →', 'htmega-addons' );
				$data_action  = 'install';
			}

			$this->add_control(
				'no_plugin_notice',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw'  => sprintf(
						'<div style="background:linear-gradient(135deg,#4f46e5,#7c3aed);border-radius:6px;padding:14px;color:#fff;">
							<strong style="display:block;font-size:13px;margin-bottom:6px;">%1$s</strong>
							<span style="font-size:12px;opacity:.9;line-height:1.5;">%2$s</span><br><br>
							<button type="button" class="htm25-cplugin-btn" data-action="%3$s"
								style="display:inline-block;background:#fff;color:#4f46e5;border:none;cursor:pointer;border-radius:4px;padding:5px 14px;font-size:12px;font-weight:700;">
								%4$s
							</button>
						</div>',
						$card_title,
						$card_body,
						esc_attr( $data_action ),
						$button_label
					),
				]
			);

		}

		$this->end_controls_section();

		// ── Contact Info ───────────────────────────────────────────────────────
		$this->start_controls_section(
			'section_info',
			[
				'label'     => esc_html__( 'Contact Info', 'htmega-addons' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [ 'layout' => [ 'split', 'info-only' ] ],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'info_icon_type',
			[
				'label'   => esc_html__( 'Icon Type', 'htmega-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'email',
				'options' => [
					'address' => esc_html__( 'Address',  'htmega-addons' ),
					'phone'   => esc_html__( 'Phone',    'htmega-addons' ),
					'email'   => esc_html__( 'Email',    'htmega-addons' ),
					'hours'   => esc_html__( 'Hours',    'htmega-addons' ),
					'website' => esc_html__( 'Website',  'htmega-addons' ),
					'custom'  => esc_html__( 'Custom Icon', 'htmega-addons' ),
				],
			]
		);

		$repeater->add_control(
			'info_custom_icon',
			[
				'label'     => esc_html__( 'Custom Icon', 'htmega-addons' ),
				'type'      => Controls_Manager::ICONS,
				'condition' => [ 'info_icon_type' => 'custom' ],
			]
		);

		$repeater->add_control(
			'info_label',
			[
				'label'   => esc_html__( 'Label', 'htmega-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Email', 'htmega-addons' ),
			]
		);

		$repeater->add_control(
			'info_value',
			[
				'label'   => esc_html__( 'Value', 'htmega-addons' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 2,
				'default' => esc_html__( 'hello@example.com', 'htmega-addons' ),
			]
		);

		$repeater->add_control(
			'info_link',
			[
				'label'       => esc_html__( 'Link URL (optional)', 'htmega-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'mailto:hello@example.com',
				'default'     => [ 'url' => '' ],
			]
		);

		$this->add_control(
			'contact_info_items',
			[
				'label'       => esc_html__( 'Info Items', 'htmega-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ info_label }}}',
				'default'     => [
					[
						'info_icon_type' => 'address',
						'info_label'     => 'Our Office',
						'info_value'     => "123 Innovation Drive\nSan Francisco, CA 94103",
					],
					[
						'info_icon_type' => 'email',
						'info_label'     => 'Email Us',
						'info_value'     => 'hello@example.com',
						'info_link'      => [ 'url' => 'mailto:hello@example.com' ],
					],
					[
						'info_icon_type' => 'phone',
						'info_label'     => 'Call Us',
						'info_value'     => '+1 (555) 000-0000',
						'info_link'      => [ 'url' => 'tel:+15550000000' ],
					],
					[
						'info_icon_type' => 'hours',
						'info_label'     => 'Working Hours',
						'info_value'     => "Mon – Fri: 9am – 6pm\nWeekends: By appointment",
					],
				],
			]
		);

		$this->end_controls_section();

		// ── Map ────────────────────────────────────────────────────────────────
		$this->start_controls_section(
			'section_map',
			[
				'label' => esc_html__( 'Map', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_map',
			[
				'label'        => esc_html__( 'Show Map', 'htmega-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'map_embed_url',
			[
				'label'       => esc_html__( 'Map Embed URL', 'htmega-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://www.google.com/maps/embed?pb=...',
				'description' => esc_html__( 'Paste the src URL from a Google Maps or OpenStreetMap embed code.', 'htmega-addons' ),
				'default'     => [ 'url' => 'https://www.openstreetmap.org/export/embed.html?bbox=-122.4313%2C37.7681%2C-122.3897%2C37.7899&layer=mapnik' ],
				'condition'   => [ 'show_map' => 'yes' ],
			]
		);

		$this->end_controls_section();

		// ── Working Hours ──────────────────────────────────────────────────────
		$this->start_controls_section(
			'section_hours',
			[
				'label'     => esc_html__( 'Working Hours', 'htmega-addons' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [ 'layout' => [ 'split', 'info-only' ] ],
			]
		);

		$this->add_control(
			'show_hours',
			[
				'label'        => esc_html__( 'Show Working Hours', 'htmega-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'hours_title',
			[
				'label'     => esc_html__( 'Title', 'htmega-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Working Hours', 'htmega-addons' ),
				'condition' => [ 'show_hours' => 'yes' ],
			]
		);

		$hours_rep = new Repeater();
		$hours_rep->add_control(
			'hours_day',
			[
				'label'   => esc_html__( 'Day(s)', 'htmega-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Mon – Fri', 'htmega-addons' ),
			]
		);
		$hours_rep->add_control(
			'hours_time',
			[
				'label'   => esc_html__( 'Time', 'htmega-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( '9:00 – 18:00', 'htmega-addons' ),
			]
		);

		$this->add_control(
			'hours_items',
			[
				'label'       => esc_html__( 'Hours Rows', 'htmega-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $hours_rep->get_controls(),
				'title_field' => '{{{ hours_day }}}',
				'default'     => [
					[ 'hours_day' => 'Mon – Fri', 'hours_time' => '9:00 – 18:00' ],
					[ 'hours_day' => 'Saturday',  'hours_time' => '10:00 – 14:00' ],
					[ 'hours_day' => 'Sunday',    'hours_time' => 'Closed' ],
				],
				'condition'   => [ 'show_hours' => 'yes' ],
			]
		);

		$this->add_control(
			'hours_open_badge',
			[
				'label'        => esc_html__( 'Show "Open now" Badge', 'htmega-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'show_hours' => 'yes' ],
			]
		);

		$this->add_control(
			'hours_badge_text',
			[
				'label'     => esc_html__( 'Badge Text', 'htmega-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Open now', 'htmega-addons' ),
				'condition' => [ 'show_hours' => 'yes', 'hours_open_badge' => 'yes' ],
			]
		);

		$this->end_controls_section();

		// ── Social Links ───────────────────────────────────────────────────────
		$this->start_controls_section(
			'section_social',
			[
				'label'     => esc_html__( 'Social Links', 'htmega-addons' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [ 'layout' => [ 'split', 'info-only' ] ],
			]
		);

		$this->add_control(
			'show_social',
			[
				'label'        => esc_html__( 'Show Social Links', 'htmega-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'social_title',
			[
				'label'     => esc_html__( 'Title', 'htmega-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Follow Us', 'htmega-addons' ),
				'condition' => [ 'show_social' => 'yes' ],
			]
		);

		$social_rep = new Repeater();
		$social_rep->add_control(
			'social_network',
			[
				'label'   => esc_html__( 'Network', 'htmega-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'facebook',
				'options' => [
					'facebook'  => esc_html__( 'Facebook',  'htmega-addons' ),
					'twitter'   => esc_html__( 'X / Twitter', 'htmega-addons' ),
					'linkedin'  => esc_html__( 'LinkedIn',  'htmega-addons' ),
					'instagram' => esc_html__( 'Instagram', 'htmega-addons' ),
					'youtube'   => esc_html__( 'YouTube',   'htmega-addons' ),
					'github'    => esc_html__( 'GitHub',    'htmega-addons' ),
				],
			]
		);
		$social_rep->add_control(
			'social_url',
			[
				'label'       => esc_html__( 'URL', 'htmega-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://',
				'default'     => [ 'url' => '#' ],
			]
		);

		$this->add_control(
			'social_items',
			[
				'label'       => esc_html__( 'Social Items', 'htmega-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $social_rep->get_controls(),
				'title_field' => '{{{ social_network }}}',
				'default'     => [
					[ 'social_network' => 'facebook',  'social_url' => [ 'url' => '#' ] ],
					[ 'social_network' => 'twitter',   'social_url' => [ 'url' => '#' ] ],
					[ 'social_network' => 'linkedin',  'social_url' => [ 'url' => '#' ] ],
					[ 'social_network' => 'instagram', 'social_url' => [ 'url' => '#' ] ],
				],
				'condition'   => [ 'show_social' => 'yes' ],
			]
		);

		$this->end_controls_section();

		// ── Trust / Response Block ─────────────────────────────────────────────
		$this->start_controls_section(
			'section_trust',
			[
				'label'     => esc_html__( 'Trust Block', 'htmega-addons' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [ 'layout' => [ 'split', 'info-only' ] ],
			]
		);

		$this->add_control(
			'show_trust',
			[
				'label'        => esc_html__( 'Show Trust Block', 'htmega-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'trust_label',
			[
				'label'     => esc_html__( 'Label', 'htmega-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Why teams choose us', 'htmega-addons' ),
				'condition' => [ 'show_trust' => 'yes' ],
			]
		);

		$this->add_control(
			'trust_number',
			[
				'label'     => esc_html__( 'Highlight Stat', 'htmega-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( '< 1 hr', 'htmega-addons' ),
				'condition' => [ 'show_trust' => 'yes' ],
			]
		);

		$this->add_control(
			'trust_subtext',
			[
				'label'     => esc_html__( 'Stat Description', 'htmega-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Average first response time', 'htmega-addons' ),
				'condition' => [ 'show_trust' => 'yes' ],
			]
		);

		$this->add_control(
			'trust_show_stars',
			[
				'label'        => esc_html__( 'Show Star Rating', 'htmega-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'show_trust' => 'yes' ],
			]
		);

		$this->add_control(
			'trust_footer',
			[
				'label'     => esc_html__( 'Footer Text', 'htmega-addons' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Rated 4.9/5 by 2,400+ customers', 'htmega-addons' ),
				'condition' => [ 'show_trust' => 'yes' ],
			]
		);

		$this->end_controls_section();

		// ── STYLE TAB ──────────────────────────────────────────────────────────

		// ── 1. Section ────────────────────────────────────────────────────────
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Section', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'section_bg',
				'label'    => esc_html__( 'Background', 'htmega-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-contact',
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label'      => esc_html__( 'Padding', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-contact' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 1b. Card / Tile ───────────────────────────────────────────────────
		$this->start_controls_section(
			'style_tiles',
			[
				'label' => esc_html__( 'Card / Tile', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'tile_bg',
				'label'    => esc_html__( 'Background', 'htmega-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-contact__tile',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'tile_border',
				'selector' => '{{WRAPPER}} .htm25-contact__tile',
			]
		);

		$this->add_responsive_control(
			'tile_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-contact__tile' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tile_box_shadow',
				'selector' => '{{WRAPPER}} .htm25-contact__tile',
			]
		);

		$this->add_control(
			'tile_label_heading',
			[
				'label'     => esc_html__( 'Tile Label', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tile_label_typography',
				'selector' => '{{WRAPPER}} .htm25-contact__tile-label',
			]
		);

		$this->add_control(
			'tile_label_color',
			[
				'label'     => esc_html__( 'Label Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__tile-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 2. Section Label ──────────────────────────────────────────────────
		$this->start_controls_section(
			'style_label',
			[
				'label'     => esc_html__( 'Section Label', 'htmega-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_section_label' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .htm25-contact__section-label',
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__section-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'label_bg_color',
			[
				'label'     => esc_html__( 'Background', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__section-label' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'label_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-contact__section-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'label_padding',
			[
				'label'      => esc_html__( 'Padding', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-contact__section-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 3. Headline ───────────────────────────────────────────────────────
		$this->start_controls_section(
			'style_headline',
			[
				'label' => esc_html__( 'Headline', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'headline_typography',
				'selector' => '{{WRAPPER}} .htm25-contact__headline',
			]
		);

		$this->add_control(
			'headline_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__headline' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'headline_accent_color',
			[
				'label'     => esc_html__( 'Highlight Color (solid)', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__headline-accent' => 'background-color: {{VALUE}}; background-image: none;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'headline_accent_gradient',
				'label'          => esc_html__( 'Highlight Gradient', 'htmega-addons' ),
				'types'          => [ 'gradient' ],
				'selector'       => '{{WRAPPER}} .htm25-contact__headline-accent',
				'fields_options' => [
					'background' => [
						'label' => esc_html__( 'Gradient Color', 'htmega-addons' ),
					],
				],
			]
		);

		$this->end_controls_section();

		// ── 4. Description ────────────────────────────────────────────────────
		$this->start_controls_section(
			'style_description',
			[
				'label' => esc_html__( 'Description', 'htmega-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .htm25-contact__description',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 5. Form Tile ──────────────────────────────────────────────────────
		$this->start_controls_section(
			'style_form_tile',
			[
				'label'     => esc_html__( 'Form Tile', 'htmega-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'layout' => [ 'split', 'centered' ] ],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'form_tile_bg',
				'label'    => esc_html__( 'Tile Background', 'htmega-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-contact__tile--form',
			]
		);

		$this->add_responsive_control(
			'form_tile_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-contact__tile--form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'form_heading_heading',
			[
				'label'     => esc_html__( 'Form Title', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'form_heading_typography',
				'selector' => '{{WRAPPER}} .htm25-contact__form-heading',
			]
		);

		$this->add_control(
			'form_heading_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__form-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'form_subheading_heading',
			[
				'label'     => esc_html__( 'Form Subtitle', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'form_subheading_typography',
				'selector' => '{{WRAPPER}} .htm25-contact__form-subheading',
			]
		);

		$this->add_control(
			'form_subheading_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__form-subheading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 5b. Form Fields ───────────────────────────────────────────────────
		$this->start_controls_section(
			'style_form_fields',
			[
				'label'     => esc_html__( 'Form Fields', 'htmega-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'layout' => [ 'split', 'centered' ] ],
			]
		);

		$this->add_control(
			'field_bg_color',
			[
				'label'     => esc_html__( 'Field Background', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact' => '--c-field-bg: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_text_color',
			[
				'label'     => esc_html__( 'Field Text', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact' => '--c-field-text: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact' => '--c-field-border: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_border_width',
			[
				'label'      => esc_html__( 'Border Width', 'htmega-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 5 ] ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-contact' => '--c-field-border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'field_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-contact .htm25-contact__form-col input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]), {{WRAPPER}} .htm25-contact .htm25-contact__form-col select, {{WRAPPER}} .htm25-contact .htm25-contact__form-col textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'field_label_color',
			[
				'label'     => esc_html__( 'Label Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .htm25-contact' => '--c-field-label: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact' => '--c-field-placeholder: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_focus_border_color',
			[
				'label'     => esc_html__( 'Focus Border', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .htm25-contact' => '--c-field-focus-border: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'field_typography',
				'label'     => esc_html__( 'Field Typography', 'htmega-addons' ),
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .htm25-contact .htm25-contact__form-col input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]), {{WRAPPER}} .htm25-contact .htm25-contact__form-col select, {{WRAPPER}} .htm25-contact .htm25-contact__form-col textarea',
			]
		);

		$this->end_controls_section();

		// ── 5c. Submit Button ─────────────────────────────────────────────────
		$this->start_controls_section(
			'style_submit_btn',
			[
				'label'     => esc_html__( 'Submit Button', 'htmega-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'layout' => [ 'split', 'centered' ] ],
			]
		);

		$btn_selector = '{{WRAPPER}} .htm25-contact .htm25-contact__form-col input[type="submit"],
			{{WRAPPER}} .htm25-contact .htm25-contact__form-col button[type="submit"],
			{{WRAPPER}} .htm25-contact .htm25-contact__form-col .wpcf7-submit,
			{{WRAPPER}} .htm25-contact .htm25-contact__form-col .ff-btn-submit,
			{{WRAPPER}} .htm25-contact .htm25-contact__form-col .wpforms-submit,
			{{WRAPPER}} .htm25-contact .htm25-contact__form-col .gform_button';

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'btn_bg',
				'label'    => esc_html__( 'Background', 'htmega-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => $btn_selector,
			]
		);

		$this->add_control(
			'btn_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact' => '--c-btn-text: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'btn_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					$btn_selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					$btn_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'btn_typography',
				'selector' => $btn_selector,
			]
		);

		$this->add_control(
			'btn_hover_heading',
			[
				'label'     => esc_html__( 'Hover State', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'btn_hover_bg_color',
			[
				'label'     => esc_html__( 'Hover Background', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact' => '--c-btn-hover-bg: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_hover_text_color',
			[
				'label'     => esc_html__( 'Hover Text', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact .htm25-contact__form-col input[type="submit"]:hover,
					{{WRAPPER}} .htm25-contact .htm25-contact__form-col button[type="submit"]:hover,
					{{WRAPPER}} .htm25-contact .htm25-contact__form-col .wpcf7-submit:hover,
					{{WRAPPER}} .htm25-contact .htm25-contact__form-col .ff-btn-submit:hover,
					{{WRAPPER}} .htm25-contact .htm25-contact__form-col .wpforms-submit:hover,
					{{WRAPPER}} .htm25-contact .htm25-contact__form-col .gform_button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 6. Contact Info ───────────────────────────────────────────────────
		$this->start_controls_section(
			'style_info_tile',
			[
				'label'     => esc_html__( 'Contact Info', 'htmega-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'layout' => [ 'split', 'info-only' ] ],
			]
		);

		$this->add_control(
			'info_icon_heading',
			[
				'label' => esc_html__( 'Icon', 'htmega-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'info_icon_bg_color',
			[
				'label'     => esc_html__( 'Icon Background', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__info-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'info_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__info-icon'          => 'color: {{VALUE}};',
					'{{WRAPPER}} .htm25-contact__info-icon svg'      => 'color: {{VALUE}};',
					'{{WRAPPER}} .htm25-contact__info-icon svg path' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'info_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'htmega-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 48 ] ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-contact__info-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'info_label_heading',
			[
				'label'     => esc_html__( 'Info Label', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'info_label_typography',
				'selector' => '{{WRAPPER}} .htm25-contact__info-label',
			]
		);

		$this->add_control(
			'info_label_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__info-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'info_value_heading',
			[
				'label'     => esc_html__( 'Info Value', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'info_value_typography',
				'selector' => '{{WRAPPER}} .htm25-contact__info-value',
			]
		);

		$this->add_control(
			'info_value_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__info-value' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 7. Working Hours ──────────────────────────────────────────────────
		$this->start_controls_section(
			'style_hours',
			[
				'label'     => esc_html__( 'Working Hours', 'htmega-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_hours' => 'yes',
					'layout'     => [ 'split', 'info-only' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'hours_row_typography',
				'label'    => esc_html__( 'Row Typography', 'htmega-addons' ),
				'selector' => '{{WRAPPER}} .htm25-contact__hours-row',
			]
		);

		$this->add_control(
			'hours_row_color',
			[
				'label'     => esc_html__( 'Row Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__hours-row'                  => 'color: {{VALUE}};',
					'{{WRAPPER}} .htm25-contact__hours-row span:last-child' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hours_badge_style_heading',
			[
				'label'     => esc_html__( '"Open now" Badge', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'hours_badge_typography',
				'selector' => '{{WRAPPER}} .htm25-contact__badge-open',
			]
		);

		$this->add_control(
			'hours_badge_color',
			[
				'label'     => esc_html__( 'Badge Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__badge-open' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hours_badge_bg_color',
			[
				'label'     => esc_html__( 'Badge Background', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__badge-open' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 8. Social Links ───────────────────────────────────────────────────
		$this->start_controls_section(
			'style_social',
			[
				'label'     => esc_html__( 'Social Links', 'htmega-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_social' => 'yes',
					'layout'      => [ 'split', 'info-only' ],
				],
			]
		);

		$this->add_responsive_control(
			'social_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'htmega-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 40 ] ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-contact__social-link svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'social_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-contact__social-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'social_normal_heading',
			[
				'label'     => esc_html__( 'Normal', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'social_color',
			[
				'label'     => esc_html__( 'Icon Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__social-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_bg_color',
			[
				'label'     => esc_html__( 'Background', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__social-link' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__social-link' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_hover_heading',
			[
				'label'     => esc_html__( 'Hover', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'social_hover_color',
			[
				'label'     => esc_html__( 'Icon Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__social-link:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_hover_bg_color',
			[
				'label'     => esc_html__( 'Background', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__social-link:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__social-link:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 9. Trust Block ────────────────────────────────────────────────────
		$this->start_controls_section(
			'style_trust',
			[
				'label'     => esc_html__( 'Trust Block', 'htmega-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_trust' => 'yes',
					'layout'     => [ 'split', 'info-only' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'trust_tile_bg',
				'label'    => esc_html__( 'Tile Background', 'htmega-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .htm25-contact__tile--trust',
			]
		);

		$this->add_control(
			'trust_num_heading',
			[
				'label'     => esc_html__( 'Stat Number', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'trust_num_typography',
				'selector' => '{{WRAPPER}} .htm25-contact__trust-num',
			]
		);

		$this->add_control(
			'trust_num_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__trust-num' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'trust_sub_heading',
			[
				'label'     => esc_html__( 'Stat Description', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'trust_sub_typography',
				'selector' => '{{WRAPPER}} .htm25-contact__trust-sub',
			]
		);

		$this->add_control(
			'trust_sub_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__trust-sub' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'trust_stars_color',
			[
				'label'     => esc_html__( 'Stars Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__trust-stars' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'trust_footer_heading',
			[
				'label'     => esc_html__( 'Footer Text', 'htmega-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'trust_footer_typography',
				'selector' => '{{WRAPPER}} .htm25-contact__trust-foot',
			]
		);

		$this->add_control(
			'trust_footer_color',
			[
				'label'     => esc_html__( 'Color', 'htmega-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .htm25-contact__trust-foot' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ── 10. Map ───────────────────────────────────────────────────────────
		$this->start_controls_section(
			'style_map',
			[
				'label'     => esc_html__( 'Map', 'htmega-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_map' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'map_height',
			[
				'label'      => esc_html__( 'Map Height', 'htmega-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [ 'px' => [ 'min' => 100, 'max' => 800 ] ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-contact__map' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'map_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'htmega-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .htm25-contact__tile--map' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->render_contact( $settings );
	}

	/**
	 * Build the full contact section HTML.
	 */
	private function render_contact( array $settings ) {
		$design_style = ! empty( $settings['design_style'] ) ? $settings['design_style'] : 'bento';
		$layout       = ! empty( $settings['layout'] )       ? $settings['layout']       : 'split';

		$show_label  = ! empty( $settings['show_section_label'] ) && $settings['show_section_label'] === 'yes';
		$label_text  = ! empty( $settings['section_label_text'] ) ? $settings['section_label_text'] : '';
		$headline    = ! empty( $settings['headline'] )           ? $settings['headline']           : '';
		$headline_hl = ! empty( $settings['headline_highlight'] ) ? $settings['headline_highlight'] : '';
		$headline_tag = ! empty( $settings['headline_tag'] )      ? tag_escape( $settings['headline_tag'] ) : 'h2';
		$description  = ! empty( $settings['description'] )       ? $settings['description']        : '';

		// Headline highlight
		$headline_html = '';
		if ( $headline ) {
			if ( $headline_hl && strpos( $headline, $headline_hl ) !== false ) {
				$headline_html = str_replace(
					esc_html( $headline_hl ),
					'<span class="htm25-contact__headline-accent">' . esc_html( $headline_hl ) . '</span>',
					esc_html( $headline )
				);
			} else {
				$headline_html = esc_html( $headline );
			}
		}

		// Form title / subtitle
		$form_title    = ! empty( $settings['form_title'] )    ? $settings['form_title']    : '';
		$form_subtitle = ! empty( $settings['form_subtitle'] ) ? $settings['form_subtitle'] : '';

		// 3rd party form settings
		$form_plugin    = ! empty( $settings['form_plugin'] ) ? $settings['form_plugin'] : '';
		$form_id        = $form_plugin && ! empty( $settings[ 'form_id_' . $form_plugin ] )
		                    ? (int) $settings[ 'form_id_' . $form_plugin ]
		                    : 0;
		$form_css_class = ! empty( $settings['form_css_class'] ) ? sanitize_html_class( $settings['form_css_class'] ) : '';

		// Info
		$info_items = ! empty( $settings['contact_info_items'] ) ? $settings['contact_info_items'] : [];

		// Map
		$show_map    = ! empty( $settings['show_map'] ) && $settings['show_map'] === 'yes';
		$map_url     = ! empty( $settings['map_embed_url']['url'] ) ? esc_url( $settings['map_embed_url']['url'] ) : '';

		// Working hours
		$show_hours   = ! empty( $settings['show_hours'] ) && $settings['show_hours'] === 'yes';
		$hours_title  = ! empty( $settings['hours_title'] ) ? $settings['hours_title'] : '';
		$hours_items  = ! empty( $settings['hours_items'] ) ? $settings['hours_items'] : [];
		$hours_badge  = ! empty( $settings['hours_open_badge'] ) && $settings['hours_open_badge'] === 'yes';
		$badge_text   = ! empty( $settings['hours_badge_text'] ) ? $settings['hours_badge_text'] : '';

		// Social
		$show_social   = ! empty( $settings['show_social'] ) && $settings['show_social'] === 'yes';
		$social_title  = ! empty( $settings['social_title'] ) ? $settings['social_title'] : '';
		$social_items  = ! empty( $settings['social_items'] ) ? $settings['social_items'] : [];

		// Trust
		$show_trust    = ! empty( $settings['show_trust'] ) && $settings['show_trust'] === 'yes';
		$trust_label   = ! empty( $settings['trust_label'] )   ? $settings['trust_label']   : '';
		$trust_number  = ! empty( $settings['trust_number'] )  ? $settings['trust_number']  : '';
		$trust_subtext = ! empty( $settings['trust_subtext'] ) ? $settings['trust_subtext'] : '';
		$trust_stars   = ! empty( $settings['trust_show_stars'] ) && $settings['trust_show_stars'] === 'yes';
		$trust_footer  = ! empty( $settings['trust_footer'] )  ? $settings['trust_footer']  : '';

		// Icon SVGs
		$icons        = $this->get_info_icons();
		$social_icons = $this->get_social_icons();

		// Whether the info column should render at all
		$has_aside = ( $layout !== 'centered' ) && (
			! empty( $info_items ) ||
			( $show_hours && ! empty( $hours_items ) ) ||
			( $show_social && ! empty( $social_items ) ) ||
			( $show_map && $map_url ) ||
			$show_trust
		);
		?>
		<?php $no_map_class = ( ! $show_map || ! $map_url ) ? ' htm25-contact--no-map' : ''; ?>
		<div class="htm25-style--<?php echo esc_attr( $design_style ); ?>">
			<section class="htm25-contact htm25-contact--<?php echo esc_attr( $layout ); ?><?php echo esc_attr( $no_map_class ); ?>">

				<?php if ( in_array( $design_style, [ 'glass', 'aurora' ], true ) ) : ?>
				<div class="htm25-contact__bg-blobs" aria-hidden="true">
					<div class="htm25-contact__blob htm25-contact__blob--1"></div>
					<div class="htm25-contact__blob htm25-contact__blob--2"></div>
					<?php if ( $design_style === 'aurora' ) : ?>
					<div class="htm25-contact__blob htm25-contact__blob--3"></div>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<div class="htm25-contact__inner">

					<?php if ( $show_label && $label_text || $headline || $description ) : ?>
					<header class="htm25-contact__header">
						<?php if ( $show_label && $label_text ) : ?>
						<p class="htm25-contact__section-label">
							<span class="htm25-contact__label-dot" aria-hidden="true"></span>
							<span><?php echo esc_html( $label_text ); ?></span>
						</p>
						<?php endif; ?>

						<?php if ( $headline_html ) : ?>
						<<?php echo $headline_tag; // phpcs:ignore ?> class="htm25-contact__headline"><?php echo $headline_html; // phpcs:ignore ?></<?php echo $headline_tag; // phpcs:ignore ?>>
						<?php endif; ?>

						<?php if ( $description ) : ?>
						<p class="htm25-contact__description"><?php echo esc_html( $description ); ?></p>
						<?php endif; ?>
					</header>
					<?php endif; ?>

					<div class="htm25-contact__body">

						<?php if ( $layout !== 'info-only' ) : ?>
						<!-- ── Contact Form ── -->
						<div class="htm25-contact__form-col htm25-contact__tile htm25-contact__tile--form">
							<?php if ( $form_title ) : ?>
							<h2 class="htm25-contact__form-heading"><?php echo esc_html( $form_title ); ?></h2>
							<?php endif; ?>
							<?php if ( $form_subtitle ) : ?>
							<p class="htm25-contact__form-subheading"><?php echo esc_html( $form_subtitle ); ?></p>
							<?php endif; ?>
							<?php echo $this->render_third_party_form( $form_plugin, $form_id, $form_css_class ); // phpcs:ignore ?>
						</div><!-- .htm25-contact__form-col -->
						<?php endif; ?>

						<?php if ( $has_aside ) : ?>
						<!-- ── Info / Hours / Social / Map / Trust ── -->
						<aside class="htm25-contact__info-col" aria-label="<?php esc_attr_e( 'Contact information', 'htmega-addons' ); ?>">

							<?php if ( ! empty( $info_items ) ) : ?>
							<div class="htm25-contact__tile htm25-contact__tile--info">
								<ul class="htm25-contact__info-list" role="list">
									<?php foreach ( $info_items as $item ) :
										$icon_type = ! empty( $item['info_icon_type'] ) ? $item['info_icon_type'] : 'email';
										$label     = ! empty( $item['info_label'] )     ? $item['info_label']     : '';
										$value     = ! empty( $item['info_value'] )     ? $item['info_value']     : '';
										$link_url  = ! empty( $item['info_link']['url'] ) ? esc_url( $item['info_link']['url'] ) : '';
										if ( $icon_type === 'custom' && ! empty( $item['info_custom_icon']['value'] ) ) {
											$icon_svg = \Elementor\Icons_Manager::try_get_icon_html( $item['info_custom_icon'], [ 'aria-hidden' => 'true' ] );
										} else {
											$icon_svg = isset( $icons[ $icon_type ] ) ? $icons[ $icon_type ] : $icons['email'];
										}
									?>
									<li class="htm25-contact__info-item" role="listitem">
										<div class="htm25-contact__info-icon" aria-hidden="true">
											<?php echo $icon_svg; // phpcs:ignore ?>
										</div>
										<div class="htm25-contact__info-content">
											<span class="htm25-contact__info-label"><?php echo esc_html( $label ); ?></span>
											<?php if ( $link_url ) : ?>
											<a href="<?php echo esc_url( $link_url ); ?>"
											   class="htm25-contact__info-value htm25-contact__info-value--link">
												<?php echo nl2br( esc_html( $value ) ); // phpcs:ignore ?>
											</a>
											<?php else : ?>
											<span class="htm25-contact__info-value">
												<?php echo nl2br( esc_html( $value ) ); // phpcs:ignore ?>
											</span>
											<?php endif; ?>
										</div>
									</li>
									<?php endforeach; ?>
								</ul>
							</div>
							<?php endif; ?>

							<div class="htm25-contact__minicards">

								<?php if ( $show_hours && ! empty( $hours_items ) ) : ?>
								<div class="htm25-contact__tile htm25-contact__tile--hours">
									<?php if ( $hours_title ) : ?>
									<span class="htm25-contact__tile-label"><?php echo esc_html( $hours_title ); ?></span>
									<?php endif; ?>
									<ul class="htm25-contact__hours-list" role="list">
										<?php foreach ( $hours_items as $hrow ) : ?>
										<li class="htm25-contact__hours-row">
											<span><?php echo esc_html( ! empty( $hrow['hours_day'] ) ? $hrow['hours_day'] : '' ); ?></span>
											<span><?php echo esc_html( ! empty( $hrow['hours_time'] ) ? $hrow['hours_time'] : '' ); ?></span>
										</li>
										<?php endforeach; ?>
									</ul>
									<?php if ( $hours_badge && $badge_text ) : ?>
									<span class="htm25-contact__badge-open">
										<span class="htm25-contact__badge-dot" aria-hidden="true"></span>
										<?php echo esc_html( $badge_text ); ?>
									</span>
									<?php endif; ?>
								</div>
								<?php endif; ?>

								<?php if ( $show_social && ! empty( $social_items ) ) : ?>
								<div class="htm25-contact__tile htm25-contact__tile--social">
									<?php if ( $social_title ) : ?>
									<span class="htm25-contact__tile-label"><?php echo esc_html( $social_title ); ?></span>
									<?php endif; ?>
									<div class="htm25-contact__social-grid">
										<?php foreach ( $social_items as $sitem ) :
											$net  = ! empty( $sitem['social_network'] ) ? $sitem['social_network'] : 'facebook';
											$surl = ! empty( $sitem['social_url']['url'] ) ? esc_url( $sitem['social_url']['url'] ) : '#';
											$ssvg = isset( $social_icons[ $net ] ) ? $social_icons[ $net ] : $social_icons['facebook'];
										?>
										<a class="htm25-contact__social-link" href="<?php echo esc_url( $surl ); ?>"
										   aria-label="<?php echo esc_attr( ucfirst( $net ) ); ?>"
										   target="_blank" rel="noopener noreferrer">
											<?php echo $ssvg; // phpcs:ignore ?>
										</a>
										<?php endforeach; ?>
									</div>
								</div>
								<?php endif; ?>

							</div><!-- .htm25-contact__minicards -->

							<?php if ( $show_map && $map_url ) : ?>
							<div class="htm25-contact__tile htm25-contact__tile--map htm25-contact__map-wrap">
								<iframe src="<?php echo esc_url( $map_url ); ?>"
								        class="htm25-contact__map"
								        loading="lazy"
								        allowfullscreen
								        referrerpolicy="no-referrer-when-downgrade"
								        title="<?php esc_attr_e( 'Location map', 'htmega-addons' ); ?>"></iframe>
							</div>
							<?php endif; ?>

							<?php if ( $show_trust ) : ?>
							<div class="htm25-contact__tile htm25-contact__tile--trust">
								<?php if ( $trust_label ) : ?>
								<span class="htm25-contact__tile-label"><?php echo esc_html( $trust_label ); ?></span>
								<?php endif; ?>
								<?php if ( $trust_number ) : ?>
								<div class="htm25-contact__trust-num"><?php echo esc_html( $trust_number ); ?></div>
								<?php endif; ?>
								<?php if ( $trust_subtext ) : ?>
								<div class="htm25-contact__trust-sub"><?php echo esc_html( $trust_subtext ); ?></div>
								<?php endif; ?>
								<?php if ( $trust_stars ) : ?>
								<div class="htm25-contact__trust-stars" aria-label="<?php esc_attr_e( '5 out of 5 stars', 'htmega-addons' ); ?>">★★★★★</div>
								<?php endif; ?>
								<?php if ( $trust_footer ) : ?>
								<div class="htm25-contact__trust-foot"><?php echo esc_html( $trust_footer ); ?></div>
								<?php endif; ?>
							</div>
							<?php endif; ?>

						</aside><!-- .htm25-contact__info-col -->
						<?php endif; ?>

					</div><!-- .htm25-contact__body -->

					<?php if ( $layout === 'centered' && $show_map && $map_url ) : ?>
					<div class="htm25-contact__tile htm25-contact__map-wrap htm25-contact__map-wrap--full">
						<iframe src="<?php echo esc_url( $map_url ); ?>"
						        class="htm25-contact__map"
						        loading="lazy"
						        allowfullscreen
						        referrerpolicy="no-referrer-when-downgrade"
						        title="<?php esc_attr_e( 'Location map', 'htmega-addons' ); ?>"></iframe>
					</div>
					<?php endif; ?>

				</div><!-- .htm25-contact__inner -->
			</section><!-- .htm25-contact -->
		</div><!-- .htm25-style -->
		<?php
	}

	/**
	 * Return inline SVG icons keyed by social network.
	 */
	private function get_social_icons(): array {
		return [
			'facebook'  => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
			'twitter'   => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.9 2H22l-7.5 8.6L23 22h-6.6l-5.2-6.8L5.3 22H2l8-9.2L1.5 2h6.8l4.7 6.2zm-1.2 18h1.8L7.2 3.8H5.3z"/></svg>',
			'linkedin'  => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9h4v12H3zM9 9h3.8v1.7h.1c.5-1 1.8-2 3.7-2 4 0 4.7 2.6 4.7 6V21h-4v-5.3c0-1.3 0-2.9-1.8-2.9s-2 1.4-2 2.8V21H9z"/></svg>',
			'instagram' => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.2c3.2 0 3.6 0 4.9.1 3.3.1 4.8 1.7 4.9 4.9.1 1.3.1 1.6.1 4.8s0 3.5-.1 4.8c-.1 3.2-1.6 4.8-4.9 4.9-1.3.1-1.6.1-4.9.1s-3.6 0-4.9-.1c-3.3-.1-4.8-1.7-4.9-4.9C2.1 15.5 2.1 15.2 2.1 12s0-3.5.1-4.8C2.3 4 3.8 2.4 7.1 2.3 8.4 2.2 8.8 2.2 12 2.2zm0 3.2a6.6 6.6 0 1 0 0 13.2 6.6 6.6 0 0 0 0-13.2zm0 10.9a4.3 4.3 0 1 1 0-8.6 4.3 4.3 0 0 1 0 8.6zm6.8-11.1a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/></svg>',
			'youtube'   => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23 7.5a3 3 0 0 0-2.1-2.1C19 4.9 12 4.9 12 4.9s-7 0-8.9.5A3 3 0 0 0 1 7.5 31 31 0 0 0 .5 12 31 31 0 0 0 1 16.5a3 3 0 0 0 2.1 2.1c1.9.5 8.9.5 8.9.5s7 0 8.9-.5a3 3 0 0 0 2.1-2.1A31 31 0 0 0 23.5 12 31 31 0 0 0 23 7.5zM9.8 15.3V8.7l5.7 3.3z"/></svg>',
			'github'    => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2a10 10 0 0 0-3.2 19.5c.5.1.7-.2.7-.5v-1.7c-2.8.6-3.4-1.3-3.4-1.3-.5-1.2-1.1-1.5-1.1-1.5-.9-.6.1-.6.1-.6 1 .1 1.5 1 1.5 1 .9 1.6 2.4 1.1 3 .9.1-.7.4-1.1.6-1.4-2.2-.3-4.6-1.1-4.6-5 0-1.1.4-2 1-2.7-.1-.3-.4-1.3.1-2.7 0 0 .8-.3 2.7 1a9.3 9.3 0 0 1 5 0c1.9-1.3 2.7-1 2.7-1 .5 1.4.2 2.4.1 2.7.6.7 1 1.6 1 2.7 0 3.9-2.4 4.7-4.6 5 .4.3.7.9.7 1.9v2.8c0 .3.2.6.7.5A10 10 0 0 0 12 2z"/></svg>',
		];
	}

	/**
	 * Return an array of active form plugin keys => labels.
	 * HT Contact Form is always listed first.
	 */
	private function get_available_form_plugins(): array {
		$options = [];

		// HT Contact Form — our plugin, pinned first.
		if ( defined( 'HTCONTACTFORM_VERSION' ) || class_exists( 'HTContactForm\Plugin' ) || function_exists( 'htcontactform' ) ) {
			$options['htcf'] = esc_html__( '★ HT Contact Form (Recommended)', 'htmega-addons' );
		}

		if ( defined( 'WPCF7_VERSION' ) ) {
			$options['cf7'] = esc_html__( 'Contact Form 7', 'htmega-addons' );
		}

		if ( function_exists( 'wpforms' ) ) {
			$options['wpforms'] = esc_html__( 'WPForms', 'htmega-addons' );
		}

		if ( defined( 'FLUENTFORM' ) ) {
			$options['fluentform'] = esc_html__( 'Fluent Forms', 'htmega-addons' );
		}

		if ( class_exists( 'GFAPI' ) ) {
			$options['gravityforms'] = esc_html__( 'Gravity Forms', 'htmega-addons' );
		}

		if ( function_exists( 'Ninja_Forms' ) ) {
			$options['ninjaforms'] = esc_html__( 'Ninja Forms', 'htmega-addons' );
		}

		return $options;
	}

	/**
	 * Return form lists keyed by plugin slug.
	 * Each value is an [ id => title ] array suitable for a SELECT control.
	 */
	private function get_form_lists_per_plugin(): array {
		$lists = [];
		$empty = [ '' => esc_html__( '— Select a form —', 'htmega-addons' ) ];

		// HT Contact Form
		if ( defined( 'HTCONTACTFORM_VERSION' ) || class_exists( 'HTContactForm\Plugin' ) || function_exists( 'htcontactform' ) ) {
			$forms = get_posts( [
				'post_type'      => 'ht_form',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'orderby'        => 'title',
				'order'          => 'ASC',
			] );
			$options = $empty;
			foreach ( $forms as $form ) {
				$options[ $form->ID ] = $form->post_title;
			}
			$lists['htcf'] = $options;
		}

		// Contact Form 7
		if ( defined( 'WPCF7_VERSION' ) ) {
			$forms = get_posts( [
				'post_type'      => 'wpcf7_contact_form',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'orderby'        => 'title',
				'order'          => 'ASC',
			] );
			$options = $empty;
			foreach ( $forms as $form ) {
				$options[ $form->ID ] = $form->post_title;
			}
			$lists['cf7'] = $options;
		}

		// WPForms
		if ( function_exists( 'wpforms' ) ) {
			$forms = get_posts( [
				'post_type'      => 'wpforms',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'orderby'        => 'title',
				'order'          => 'ASC',
			] );
			$options = $empty;
			foreach ( $forms as $form ) {
				$options[ $form->ID ] = $form->post_title;
			}
			$lists['wpforms'] = $options;
		}

		// Fluent Forms (uses a custom DB table, not CPT)
		if ( defined( 'FLUENTFORM' ) ) {
			global $wpdb;
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$forms   = $wpdb->get_results( "SELECT id, title FROM {$wpdb->prefix}fluentform_forms ORDER BY title ASC" );
			$options = $empty;
			foreach ( $forms as $form ) {
				$options[ $form->id ] = $form->title;
			}
			$lists['fluentform'] = $options;
		}

		// Gravity Forms
		if ( class_exists( 'GFAPI' ) ) {
			$forms   = \GFAPI::get_forms();
			$options = $empty;
			foreach ( $forms as $form ) {
				$options[ $form['id'] ] = $form['title'];
			}
			$lists['gravityforms'] = $options;
		}

		// Ninja Forms
		if ( function_exists( 'Ninja_Forms' ) ) {
			$forms   = \Ninja_Forms()->form()->get_forms();
			$options = $empty;
			foreach ( $forms as $form ) {
				$options[ $form->get_id() ] = $form->get_setting( 'title' );
			}
			$lists['ninjaforms'] = $options;
		}

		return $lists;
	}

	/**
	 * Render the chosen 3rd-party form via its shortcode.
	 *
	 * @param string $plugin      Plugin key (htcf, cf7, wpforms, etc.).
	 * @param int    $form_id     Form ID.
	 * @param string $css_class   Optional extra wrapper class.
	 * @return string             HTML output.
	 */
	private function render_third_party_form( string $plugin, int $form_id, string $css_class ): string {
		// Editor placeholder when nothing is selected yet.
		if ( ! $plugin || ! $form_id ) {
			if ( isset( \Elementor\Plugin::$instance->editor ) && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				return '<div class="htm25-contact__form-placeholder" style="padding:24px;text-align:center;border:2px dashed #ccc;border-radius:6px;color:#888;">'
				       . esc_html__( 'Select a form plugin and form in the Content tab.', 'htmega-addons' )
				       . '</div>';
			}
			return '';
		}

		$shortcodes = [
			'htcf'         => sprintf( '[ht_form id="%d"]', $form_id ),
			'cf7'          => sprintf( '[contact-form-7 id="%d"]', $form_id ),
			'wpforms'      => sprintf( '[wpforms id="%d"]', $form_id ),
			'fluentform'   => sprintf( '[fluentform id="%d"]', $form_id ),
			'gravityforms' => sprintf( '[gravityforms id="%d"]', $form_id ),
			'ninjaforms'   => sprintf( '[ninja_form id="%d"]', $form_id ),
		];

		if ( ! isset( $shortcodes[ $plugin ] ) ) {
			return '';
		}

		$wrapper_class = 'htm25-contact__form htm25-contact__form--third-party htm25-contact__form--' . esc_attr( $plugin );
		if ( $css_class ) {
			$wrapper_class .= ' ' . esc_attr( $css_class );
		}

		return '<div class="' . $wrapper_class . '">' . do_shortcode( $shortcodes[ $plugin ] ) . '</div>';
	}

	/**
	 * Return inline SVG icons keyed by info type.
	 */
	private function get_info_icons(): array {
		return [
			'address' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z" fill="currentColor"/></svg>',
			'phone'   => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" fill="currentColor"/></svg>',
			'email'   => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" fill="currentColor"/></svg>',
			'hours'   => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z" fill="currentColor"/></svg>',
			'website' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm6.93 6h-2.95c-.32-1.25-.78-2.45-1.38-3.56 1.84.63 3.37 1.91 4.33 3.56zM12 4.04c.83 1.2 1.48 2.53 1.91 3.96h-3.82c.43-1.43 1.08-2.76 1.91-3.96zM4.26 14C4.1 13.36 4 12.69 4 12s.1-1.36.26-2h3.38c-.08.66-.14 1.32-.14 2 0 .68.06 1.34.14 2H4.26zm.82 2h2.95c.32 1.25.78 2.45 1.38 3.56-1.84-.63-3.37-1.9-4.33-3.56zm2.95-8H5.08c.96-1.66 2.49-2.93 4.33-3.56C8.81 5.55 8.35 6.75 8.03 8zM12 19.96c-.83-1.2-1.48-2.53-1.91-3.96h3.82c-.43 1.43-1.08 2.76-1.91 3.96zM14.34 14H9.66c-.09-.66-.16-1.32-.16-2 0-.68.07-1.35.16-2h4.68c.09.65.16 1.32.16 2 0 .68-.07 1.34-.16 2zm.25 5.56c.6-1.11 1.06-2.31 1.38-3.56h2.95c-.96 1.65-2.49 2.93-4.33 3.56zM16.36 14c.08-.66.14-1.32.14-2 0-.68-.06-1.34-.14-2h3.38c.16.64.26 1.31.26 2s-.1 1.36-.26 2h-3.38z" fill="currentColor"/></svg>',
			'custom'  => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
		];
	}
}
