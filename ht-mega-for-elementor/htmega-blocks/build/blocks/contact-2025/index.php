<?php
/**
 * HT Mega 2026 — Contact Section FSE block renderer
 * Block: htmega/contact-2025
 *
 * Uses PHP closures so multiple instances on the same page
 * never trigger "Cannot redeclare" fatals.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$attributes = $settings; // render callback provides $settings

// ── Attributes ───────────────────────────────────────────────
$design_style  = isset( $attributes['designStyle'] )       ? sanitize_html_class( $attributes['designStyle'] )      : 'bento';
$layout        = isset( $attributes['layout'] )            ? sanitize_html_class( $attributes['layout'] )           : 'split';
$show_label    = isset( $attributes['showSectionLabel'] )  ? (bool) $attributes['showSectionLabel']                 : true;
$label_text    = isset( $attributes['sectionLabelText'] )  ? $attributes['sectionLabelText']                        : 'Contact Us';
$headline      = isset( $attributes['headline'] )          ? $attributes['headline']                                : "We'd Love to Hear From You";
$highlight     = isset( $attributes['headlineHighlight'] ) ? $attributes['headlineHighlight']                       : 'Love';
$headline_tag  = isset( $attributes['headlineTag'] )       ? $attributes['headlineTag']                             : 'h2';
$description   = isset( $attributes['description'] )       ? $attributes['description']                             : '';

$form_title    = isset( $attributes['formTitle'] )    ? esc_html( $attributes['formTitle'] )    : '';
$form_subtitle = isset( $attributes['formSubtitle'] ) ? esc_html( $attributes['formSubtitle'] ) : '';
$form_plugin   = isset( $attributes['formPlugin'] )   ? $attributes['formPlugin']                : '';
$form_id       = isset( $attributes['formId'] )       ? (int) $attributes['formId']              : 0;
$form_css_class = isset( $attributes['formCssClass'] ) ? sanitize_html_class( $attributes['formCssClass'] ) : '';

$info_items    = isset( $attributes['contactInfoItems'] )  ? $attributes['contactInfoItems']                        : [];
$show_map      = isset( $attributes['showMap'] )           ? (bool) $attributes['showMap']                         : false;
$map_url       = isset( $attributes['mapEmbedUrl'] )       ? esc_url( $attributes['mapEmbedUrl'] )                 : '';
$map_height    = isset( $attributes['mapHeight'] )         ? esc_attr( $attributes['mapHeight'] )                  : '';

// Working hours
$show_hours   = isset( $attributes['showHours'] )      ? (bool) $attributes['showHours']      : true;
$hours_title  = isset( $attributes['hoursTitle'] )     ? $attributes['hoursTitle']             : '';
$hours_items  = isset( $attributes['hoursItems'] )     ? $attributes['hoursItems']             : [];
$hours_badge  = isset( $attributes['hoursOpenBadge'] ) ? (bool) $attributes['hoursOpenBadge'] : true;
$badge_text   = isset( $attributes['hoursBadgeText'] ) ? $attributes['hoursBadgeText']         : '';

// Social links
$show_social  = isset( $attributes['showSocial'] )   ? (bool) $attributes['showSocial']  : true;
$social_title = isset( $attributes['socialTitle'] )  ? $attributes['socialTitle']         : '';
$social_items = isset( $attributes['socialItems'] )  ? $attributes['socialItems']         : [];

// Trust block
$show_trust    = isset( $attributes['showTrust'] )      ? (bool) $attributes['showTrust']      : true;
$trust_label   = isset( $attributes['trustLabel'] )     ? $attributes['trustLabel']             : '';
$trust_number  = isset( $attributes['trustNumber'] )    ? $attributes['trustNumber']            : '';
$trust_subtext = isset( $attributes['trustSubtext'] )   ? $attributes['trustSubtext']           : '';
$trust_stars   = isset( $attributes['trustShowStars'] ) ? (bool) $attributes['trustShowStars'] : true;
$trust_footer  = isset( $attributes['trustFooter'] )    ? $attributes['trustFooter']            : '';

// Allowed heading tags
$allowed_tags = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ];
if ( ! in_array( $headline_tag, $allowed_tags, true ) ) {
	$headline_tag = 'h2';
}

// ── Headline with highlight ──────────────────────────────────
$headline_html = esc_html( $headline );
if ( $highlight && false !== strpos( $headline, $highlight ) ) {
	$headline_html = str_replace(
		esc_html( $highlight ),
		'<span class="htm25-contact__headline-accent">' . esc_html( $highlight ) . '</span>',
		$headline_html
	);
}

// ── has_aside logic (mirrors Elementor) ─────────────────────
$has_aside = ( $layout !== 'centered' ) && (
	! empty( $info_items ) ||
	( $show_hours && ! empty( $hours_items ) ) ||
	( $show_social && ! empty( $social_items ) ) ||
	( $show_map && $map_url ) ||
	$show_trust
);

$no_map_class = ( ! $show_map || ! $map_url ) ? ' htm25-contact--no-map' : '';

// ── Dynamic CSS (mirrors buildContactCss in edit.js) ─────────
$block_id = isset( $attributes['blockUniqId'] ) ? sanitize_html_class( $attributes['blockUniqId'] ) : uniqid( 'htm25-contact-' );
$sc   = '.htmega-block-' . $block_id;
$_css = [];

$_border = function( $type, $width, $color ) {
	if ( ! $type || $type === 'none' ) return [];
	$r = [ 'border-style: ' . esc_attr( $type ) ];
	if ( $width && is_array( $width ) ) {
		$u = $width['unit'] ?? 'px';
		if ( isset( $width['link'] ) && $width['link'] === 'yes' && isset( $width['top'] ) ) {
			$r[] = 'border-width: ' . $width['top'] . $u;
		} else {
			foreach ( [ 'top', 'right', 'bottom', 'left' ] as $_s ) {
				if ( ! empty( $width[ $_s ] ) ) $r[] = "border-{$_s}-width: {$width[$_s]}{$u}";
			}
		}
	}
	if ( $color ) $r[] = 'border-color: ' . esc_attr( $color );
	return $r;
};
$_radius = function( $rv ) {
	if ( ! $rv || ! is_array( $rv ) ) return [];
	$u   = $rv['unit'] ?? 'px';
	$map = [ 'top' => 'top-left', 'right' => 'top-right', 'bottom' => 'bottom-right', 'left' => 'bottom-left' ];
	$r   = [];
	foreach ( $map as $_s => $corner ) {
		if ( isset( $rv[ $_s ] ) && $rv[ $_s ] !== '' ) $r[] = "border-{$corner}-radius: {$rv[$_s]}{$u}";
	}
	return $r;
};
$_shadow = function( $s ) {
	if ( ! $s || ! is_array( $s ) || empty( $s['color'] ) ) return '';
	$i = ! empty( $s['inset'] ) ? 'inset ' : '';
	return 'box-shadow: ' . $i . ( $s['horizontal'] ?? 0 ) . 'px ' . ( $s['vertical'] ?? 0 ) . 'px ' . ( $s['blur'] ?? 0 ) . 'px ' . ( $s['spread'] ?? 0 ) . 'px ' . esc_attr( $s['color'] );
};
$_typo = function( $t ) {
	if ( ! $t || ! is_array( $t ) ) return [];
	$r = [];
	if ( ! empty( $t['family'] )        ) $r[] = "font-family: '" . esc_attr( $t['family'] ) . "', sans-serif";
	if ( ! empty( $t['size'] )          ) $r[] = 'font-size: '       . $t['size']       . ( $t['sizeUnit']      ?? 'px' );
	if ( ! empty( $t['weight'] )        ) $r[] = 'font-weight: '     . esc_attr( $t['weight'] );
	if ( ! empty( $t['lineHeight'] )    ) $r[] = 'line-height: '     . $t['lineHeight'];
	if ( ! empty( $t['letterSpacing'] ) ) $r[] = 'letter-spacing: '  . $t['letterSpacing'] . 'px';
	if ( ! empty( $t['transform'] )     ) $r[] = 'text-transform: '  . esc_attr( $t['transform'] );
	return $r;
};
$_dim = function( $dim, $prop ) {
	if ( ! $dim || ! is_array( $dim ) ) return [];
	$d = isset( $dim['desktop'] ) ? $dim['desktop'] : $dim;
	$u = $d['unit'] ?? $dim['unit'] ?? 'px';
	$r = [];
	foreach ( [ 'top', 'right', 'bottom', 'left' ] as $_s ) {
		if ( isset( $d[ $_s ] ) && $d[ $_s ] !== '' ) $r[] = "{$prop}-{$_s}: {$d[$_s]}{$u}";
	}
	return $r;
};
$_rule = function( $sel, $rules ) use ( $sc, &$_css ) {
	if ( ! empty( $rules ) ) $_css[] = $sc . $sel . ' { ' . implode( '; ', $rules ) . '; }';
};

// Section
$_sec = [];
if ( ! empty( $attributes['styleSectionBgColor'] )    ) $_sec[] = 'background-color: ' . esc_attr( $attributes['styleSectionBgColor'] );
if ( ! empty( $attributes['styleSectionBgGradient'] ) ) { $_sec[] = 'background: ' . esc_attr( $attributes['styleSectionBgGradient'] ); $_sec[] = 'background-color: transparent'; }
$_sec = array_merge( $_sec, $_dim( $attributes['styleSectionPadding'] ?? null, 'padding' ), $_border( $attributes['sectionBorderType'] ?? null, $attributes['sectionBorderWidth'] ?? null, $attributes['sectionBorderColor'] ?? null ), $_radius( $attributes['styleSectionBorderRadius'] ?? null ) );
$_sw = $_shadow( $attributes['styleSectionShadow'] ?? null ); if ( $_sw ) $_sec[] = $_sw;
if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-contact { ' . implode( '; ', $_sec ) . '; }';
if ( ! empty( $attributes['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-contact__inner { max-width: ' . esc_attr( $attributes['styleContainerMaxWidth'] ) . '; }';

// Card / Tile
$_tile = [];
if ( ! empty( $attributes['styleTileBgColor'] )    ) $_tile[] = 'background-color: ' . esc_attr( $attributes['styleTileBgColor'] );
if ( ! empty( $attributes['styleTileBgGradient'] ) ) { $_tile[] = 'background: ' . esc_attr( $attributes['styleTileBgGradient'] ); $_tile[] = 'background-color: transparent'; }
$_tile = array_merge( $_tile, $_border( $attributes['tileBorderType'] ?? null, $attributes['tileBorderWidth'] ?? null, $attributes['tileBorderColor'] ?? null ), $_radius( $attributes['styleTileBorderRadius'] ?? null ) );
$_tsw = $_shadow( $attributes['styleTileShadow'] ?? null ); if ( $_tsw ) $_tile[] = $_tsw;
if ( ! empty( $_tile ) ) $_css[] = $sc . ' .htm25-contact__tile { ' . implode( '; ', $_tile ) . '; }';

// Tile label
$_tlbl = $_typo( $attributes['styleTileLabelTypography'] ?? null );
if ( ! empty( $attributes['styleTileLabelColor'] ) ) $_tlbl[] = 'color: ' . esc_attr( $attributes['styleTileLabelColor'] );
$_rule( ' .htm25-contact__tile-label', $_tlbl );

// Section label
$_slbl = array_merge( $_typo( $attributes['styleSectionLabelTypography'] ?? null ), $_radius( $attributes['styleSectionLabelRadius'] ?? null ), $_dim( $attributes['styleSectionLabelPadding'] ?? null, 'padding' ) );
if ( ! empty( $attributes['styleSectionLabelColor'] )   ) $_slbl[] = 'color: ' . esc_attr( $attributes['styleSectionLabelColor'] );
if ( ! empty( $attributes['styleSectionLabelBgColor'] ) ) $_slbl[] = 'background-color: ' . esc_attr( $attributes['styleSectionLabelBgColor'] );
$_rule( ' .htm25-contact__section-label', $_slbl );

// Headline
$_hl = array_merge( $_typo( $attributes['styleHeadlineTypography'] ?? null ), $_dim( $attributes['styleHeadlineMargin'] ?? null, 'margin' ) );
if ( ! empty( $attributes['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $attributes['styleHeadlineColor'] );
$_rule( ' .htm25-contact__headline', $_hl );
if ( ! empty( $attributes['styleHeadlineHighlightColor'] )    ) $_css[] = $sc . ' .htm25-contact .htm25-contact__headline-accent { background-color: ' . esc_attr( $attributes['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
if ( ! empty( $attributes['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-contact .htm25-contact__headline-accent { background: ' . esc_attr( $attributes['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

// Description
$_desc = $_typo( $attributes['styleDescTypography'] ?? null );
if ( ! empty( $attributes['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $attributes['styleDescColor'] );
$_rule( ' .htm25-contact__description', $_desc );

// Form tile
$_form = [];
if ( ! empty( $attributes['styleFormBgColor'] ) ) $_form[] = 'background-color: ' . esc_attr( $attributes['styleFormBgColor'] );
$_form = array_merge( $_form, $_border( $attributes['formBorderType'] ?? null, $attributes['formBorderWidth'] ?? null, $attributes['formBorderColor'] ?? null ), $_radius( $attributes['styleFormBorderRadius'] ?? null ) );
$_fsw = $_shadow( $attributes['styleFormShadow'] ?? null ); if ( $_fsw ) $_form[] = $_fsw;
$_rule( ' .htm25-contact__tile--form', $_form );

// Form heading / subheading
$_fhead = $_typo( $attributes['styleFormHeadingTypography'] ?? null );
if ( ! empty( $attributes['styleFormHeadingColor'] ) ) $_fhead[] = 'color: ' . esc_attr( $attributes['styleFormHeadingColor'] );
$_rule( ' .htm25-contact__form-heading', $_fhead );
$_fsubh = $_typo( $attributes['styleFormSubheadingTypography'] ?? null );
if ( ! empty( $attributes['styleFormSubheadingColor'] ) ) $_fsubh[] = 'color: ' . esc_attr( $attributes['styleFormSubheadingColor'] );
$_rule( ' .htm25-contact__form-subheading', $_fsubh );

// Form field labels
$_flbl = $_typo( $attributes['styleLabelTypography'] ?? null );
if ( ! empty( $attributes['styleLabelColor'] ) ) $_flbl[] = 'color: ' . esc_attr( $attributes['styleLabelColor'] );
if ( ! empty( $_flbl ) ) $_css[] = $sc . ' .htm25-contact .htm25-contact__form-col label { ' . implode( '; ', $_flbl ) . '; }';

// Input / textarea token overrides
$_itok = [];
if ( ! empty( $attributes['styleInputBgColor'] )           ) $_itok[] = '--c-field-bg: ' . esc_attr( $attributes['styleInputBgColor'] );
if ( ! empty( $attributes['styleInputTextColor'] )         ) $_itok[] = '--c-field-text: ' . esc_attr( $attributes['styleInputTextColor'] );
if ( ! empty( $attributes['styleInputBorderColor'] )       ) $_itok[] = '--c-field-border: ' . esc_attr( $attributes['styleInputBorderColor'] );
if ( ! empty( $attributes['styleInputBorderWidth'] )       ) $_itok[] = '--c-field-border-width: ' . esc_attr( $attributes['styleInputBorderWidth'] ) . 'px';
if ( ! empty( $attributes['styleInputPlaceholderColor'] )  ) $_itok[] = '--c-field-placeholder: ' . esc_attr( $attributes['styleInputPlaceholderColor'] );
if ( ! empty( $attributes['styleInputFocusBorderColor'] )  ) $_itok[] = '--c-field-focus-border: ' . esc_attr( $attributes['styleInputFocusBorderColor'] );
if ( ! empty( $_itok ) ) $_css[] = $sc . ' .htm25-contact { ' . implode( '; ', $_itok ) . '; }';

// Input border radius + typography
$_input_els = implode( ",\n", [
	$sc . ' .htm25-contact .htm25-contact__form-col input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"])',
	$sc . ' .htm25-contact .htm25-contact__form-col select',
	$sc . ' .htm25-contact .htm25-contact__form-col textarea',
] );
$_inp_rules = array_merge( $_radius( $attributes['styleInputBorderRadius'] ?? null ), $_typo( $attributes['styleInputTypography'] ?? null ) );
if ( ! empty( $_inp_rules ) ) $_css[] = $_input_els . ' { ' . implode( '; ', $_inp_rules ) . '; }';

// Input focus border — explicit rule to beat form plugin CSS
if ( ! empty( $attributes['styleInputFocusBorderColor'] ) ) {
	$_focus_sel = implode( ",\n", [
		$sc . ' .htm25-contact .htm25-contact__form-col input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]):focus',
		$sc . ' .htm25-contact .htm25-contact__form-col select:focus',
		$sc . ' .htm25-contact .htm25-contact__form-col textarea:focus',
	] );
	$_css[] = $_focus_sel . ' { border-color: ' . esc_attr( $attributes['styleInputFocusBorderColor'] ) . '; outline: none; }';
}

// Submit button — normal
$_submit_sel = implode( ",\n", [
	$sc . ' .htm25-contact .htm25-contact__form-col input[type="submit"]',
	$sc . ' .htm25-contact .htm25-contact__form-col button[type="submit"]',
	$sc . ' .htm25-contact .htm25-contact__form-col .wpcf7-submit',
	$sc . ' .htm25-contact .htm25-contact__form-col .ff-btn-submit',
	$sc . ' .htm25-contact .htm25-contact__form-col .wpforms-submit',
	$sc . ' .htm25-contact .htm25-contact__form-col .gform_button',
] );
$_submit = [];
if ( ! empty( $attributes['styleSubmitBgColor'] )    ) { $_submit[] = 'background-color: ' . esc_attr( $attributes['styleSubmitBgColor'] ); $_submit[] = 'background-image: none'; }
if ( ! empty( $attributes['styleSubmitBgGradient'] ) ) { $_submit[] = 'background: ' . esc_attr( $attributes['styleSubmitBgGradient'] ); $_submit[] = 'background-color: transparent'; }
if ( ! empty( $attributes['styleSubmitTextColor'] )  ) $_submit[] = 'color: ' . esc_attr( $attributes['styleSubmitTextColor'] );
$_submit = array_merge( $_submit, $_border( $attributes['submitBorderType'] ?? null, $attributes['submitBorderWidth'] ?? null, $attributes['submitBorderColor'] ?? null ), $_radius( $attributes['styleSubmitBorderRadius'] ?? null ), $_dim( $attributes['styleSubmitPadding'] ?? null, 'padding' ), $_typo( $attributes['styleSubmitTypography'] ?? null ) );
$_ssw = $_shadow( $attributes['styleSubmitShadow'] ?? null ); if ( $_ssw ) $_submit[] = $_ssw;
if ( ! empty( $_submit ) ) $_css[] = $_submit_sel . ' { ' . implode( '; ', $_submit ) . '; }';

// Submit button — hover
$_submit_hover_sel = implode( ",\n", [
	$sc . ' .htm25-contact .htm25-contact__form-col input[type="submit"]:hover',
	$sc . ' .htm25-contact .htm25-contact__form-col button[type="submit"]:hover',
	$sc . ' .htm25-contact .htm25-contact__form-col .wpcf7-submit:hover',
	$sc . ' .htm25-contact .htm25-contact__form-col .ff-btn-submit:hover',
	$sc . ' .htm25-contact .htm25-contact__form-col .wpforms-submit:hover',
	$sc . ' .htm25-contact .htm25-contact__form-col .gform_button:hover',
] );
$_submith = [];
if ( ! empty( $attributes['styleSubmitHoverBgGradient'] ) ) $_submith[] = 'background: ' . esc_attr( $attributes['styleSubmitHoverBgGradient'] );
elseif ( ! empty( $attributes['styleSubmitHoverBgColor'] ) ) $_submith[] = 'background: ' . esc_attr( $attributes['styleSubmitHoverBgColor'] );
if ( ! empty( $attributes['styleSubmitHoverTextColor'] ) ) $_submith[] = 'color: ' . esc_attr( $attributes['styleSubmitHoverTextColor'] );
if ( ! empty( $_submith ) ) $_css[] = $_submit_hover_sel . ' { ' . implode( '; ', $_submith ) . '; }';

// Info item background
if ( ! empty( $attributes['styleInfoItemBgColor'] ) ) $_css[] = $sc . ' .htm25-contact__info-item { background-color: ' . esc_attr( $attributes['styleInfoItemBgColor'] ) . '; }';

// Info icon
$_iico = [];
if ( ! empty( $attributes['styleInfoIconBgColor'] ) ) $_iico[] = 'background-color: ' . esc_attr( $attributes['styleInfoIconBgColor'] );
if ( ! empty( $attributes['styleInfoIconColor'] )   ) $_iico[] = 'color: ' . esc_attr( $attributes['styleInfoIconColor'] );
$_rule( ' .htm25-contact__info-icon', $_iico );
if ( ! empty( $attributes['styleInfoIconColor'] ) ) { $_iic = esc_attr( $attributes['styleInfoIconColor'] ); $_css[] = "$sc .htm25-contact__info-icon svg { color: $_iic; }"; $_css[] = "$sc .htm25-contact__info-icon svg path { fill: $_iic; }"; }
if ( ! empty( $attributes['styleInfoIconSize'] ) ) { $_isz = esc_attr( $attributes['styleInfoIconSize'] ); $_css[] = "$sc .htm25-contact__info-icon svg { width: $_isz; height: $_isz; }"; }

// Info label
$_ilbl = $_typo( $attributes['styleInfoLabelTypography'] ?? null );
if ( ! empty( $attributes['styleInfoLabelColor'] ) ) $_ilbl[] = 'color: ' . esc_attr( $attributes['styleInfoLabelColor'] );
$_rule( ' .htm25-contact__info-label', $_ilbl );

// Info value
$_ival = $_typo( $attributes['styleInfoValueTypography'] ?? null );
if ( ! empty( $attributes['styleInfoValueColor'] ) ) $_ival[] = 'color: ' . esc_attr( $attributes['styleInfoValueColor'] );
$_rule( ' .htm25-contact__info-value', $_ival );

// Working hours
$_hrow = array_merge( $_typo( $attributes['styleHoursRowTypography'] ?? null ) );
if ( ! empty( $attributes['styleHoursRowColor'] ) ) $_hrow[] = 'color: ' . esc_attr( $attributes['styleHoursRowColor'] );
if ( ! empty( $_hrow ) ) $_css[] = $sc . ' .htm25-contact__hours-row, ' . $sc . ' .htm25-contact__hours-row span:last-child { ' . implode( '; ', $_hrow ) . '; }';
$_hbdg = array_merge( $_typo( $attributes['styleHoursBadgeTypography'] ?? null ) );
if ( ! empty( $attributes['styleHoursBadgeColor'] )   ) $_hbdg[] = 'color: ' . esc_attr( $attributes['styleHoursBadgeColor'] );
if ( ! empty( $attributes['styleHoursBadgeBgColor'] ) ) $_hbdg[] = 'background-color: ' . esc_attr( $attributes['styleHoursBadgeBgColor'] );
$_rule( ' .htm25-contact__badge-open', $_hbdg );

// Social links
if ( ! empty( $attributes['styleSocialIconSize'] ) ) { $_sz = esc_attr( $attributes['styleSocialIconSize'] ); $_css[] = "$sc .htm25-contact__social-link svg { width: $_sz; height: $_sz; }"; }
$_slink = array_merge( $_radius( $attributes['styleSocialBorderRadius'] ?? null ) );
if ( ! empty( $attributes['styleSocialColor'] )       ) $_slink[] = 'color: ' . esc_attr( $attributes['styleSocialColor'] );
if ( ! empty( $attributes['styleSocialBgColor'] )     ) $_slink[] = 'background-color: ' . esc_attr( $attributes['styleSocialBgColor'] );
if ( ! empty( $attributes['styleSocialBorderColor'] ) ) $_slink[] = 'border-color: ' . esc_attr( $attributes['styleSocialBorderColor'] );
$_rule( ' .htm25-contact__social-link', $_slink );
$_slinkh = [];
if ( ! empty( $attributes['styleSocialHoverColor'] )        ) $_slinkh[] = 'color: ' . esc_attr( $attributes['styleSocialHoverColor'] );
if ( ! empty( $attributes['styleSocialHoverBgColor'] )      ) $_slinkh[] = 'background-color: ' . esc_attr( $attributes['styleSocialHoverBgColor'] );
if ( ! empty( $attributes['styleSocialHoverBorderColor'] )  ) $_slinkh[] = 'border-color: ' . esc_attr( $attributes['styleSocialHoverBorderColor'] );
$_rule( ' .htm25-contact__social-link:hover', $_slinkh );

// Trust tile
$_trust_tile = [];
if ( ! empty( $attributes['styleTrustTileBgColor'] )    ) { $_trust_tile[] = 'background-color: ' . esc_attr( $attributes['styleTrustTileBgColor'] ); }
if ( ! empty( $attributes['styleTrustTileBgGradient'] ) ) { $_trust_tile[] = 'background: ' . esc_attr( $attributes['styleTrustTileBgGradient'] ); $_trust_tile[] = 'background-color: transparent'; }
$_rule( ' .htm25-contact__tile--trust', $_trust_tile );
$_tnum = $_typo( $attributes['styleTrustNumTypography'] ?? null );
if ( ! empty( $attributes['styleTrustNumColor'] ) ) $_tnum[] = 'color: ' . esc_attr( $attributes['styleTrustNumColor'] );
$_rule( ' .htm25-contact__trust-num', $_tnum );
$_tsub = $_typo( $attributes['styleTrustSubTypography'] ?? null );
if ( ! empty( $attributes['styleTrustSubColor'] ) ) $_tsub[] = 'color: ' . esc_attr( $attributes['styleTrustSubColor'] );
$_rule( ' .htm25-contact__trust-sub', $_tsub );
if ( ! empty( $attributes['styleTrustStarsColor'] )  ) $_css[] = $sc . ' .htm25-contact__trust-stars { color: ' . esc_attr( $attributes['styleTrustStarsColor'] ) . '; }';
$_tfoot = $_typo( $attributes['styleTrustFooterTypography'] ?? null );
if ( ! empty( $attributes['styleTrustFooterColor'] ) ) $_tfoot[] = 'color: ' . esc_attr( $attributes['styleTrustFooterColor'] );
$_rule( ' .htm25-contact__trust-foot', $_tfoot );

// Map
$_map = $_radius( $attributes['styleMapBorderRadius'] ?? null );
$_msw = $_shadow( $attributes['styleMapShadow'] ?? null ); if ( $_msw ) $_map[] = $_msw;
$_rule( ' .htm25-contact__tile--map', $_map );
if ( ! empty( $map_height ) ) $_css[] = $sc . ' .htm25-contact__map { min-height: ' . esc_attr( $map_height ) . '; }';

$_css_out = implode( "\n", $_css );

// ── Icon SVG map ─────────────────────────────────────────────
$icons = [
	'address' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z" fill="currentColor"/></svg>',
	'phone'   => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" fill="currentColor"/></svg>',
	'email'   => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" fill="currentColor"/></svg>',
	'hours'   => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z" fill="currentColor"/></svg>',
	'website' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm6.93 6h-2.95c-.32-1.25-.78-2.45-1.38-3.56 1.84.63 3.37 1.91 4.33 3.56zM12 4.04c.83 1.2 1.48 2.53 1.91 3.96h-3.82c.43-1.43 1.08-2.76 1.91-3.96zM4.26 14C4.1 13.36 4 12.69 4 12s.1-1.36.26-2h3.38c-.08.66-.14 1.32-.14 2 0 .68.06 1.34.14 2H4.26zm.82 2h2.95c.32 1.25.78 2.45 1.38 3.56-1.84-.63-3.37-1.9-4.33-3.56zm2.95-8H5.08c.96-1.66 2.49-2.93 4.33-3.56C8.81 5.55 8.35 6.75 8.03 8zM12 19.96c-.83-1.2-1.48-2.53-1.91-3.96h3.82c-.43 1.43-1.08 2.76-1.91 3.96zM14.34 14H9.66c-.09-.66-.16-1.32-.16-2 0-.68.07-1.35.16-2h4.68c.09.65.16 1.32.16 2 0 .68-.07 1.34-.16 2zm.25 5.56c.6-1.11 1.06-2.31 1.38-3.56h2.95c-.96 1.65-2.49 2.93-4.33 3.56zM16.36 14c.08-.66.14-1.32.14-2 0-.68-.06-1.34-.14-2h3.38c.16.64.26 1.31.26 2s-.1 1.36-.26 2h-3.38z" fill="currentColor"/></svg>',
	'custom'  => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
];

$social_icons = [
	'facebook'  => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
	'twitter'   => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.9 2H22l-7.5 8.6L23 22h-6.6l-5.2-6.8L5.3 22H2l8-9.2L1.5 2h6.8l4.7 6.2zm-1.2 18h1.8L7.2 3.8H5.3z"/></svg>',
	'linkedin'  => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9h4v12H3zM9 9h3.8v1.7h.1c.5-1 1.8-2 3.7-2 4 0 4.7 2.6 4.7 6V21h-4v-5.3c0-1.3 0-2.9-1.8-2.9s-2 1.4-2 2.8V21H9z"/></svg>',
	'instagram' => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.2c3.2 0 3.6 0 4.9.1 3.3.1 4.8 1.7 4.9 4.9.1 1.3.1 1.6.1 4.8s0 3.5-.1 4.8c-.1 3.2-1.6 4.8-4.9 4.9-1.3.1-1.6.1-4.9.1s-3.6 0-4.9-.1c-3.3-.1-4.8-1.7-4.9-4.9C2.1 15.5 2.1 15.2 2.1 12s0-3.5.1-4.8C2.3 4 3.8 2.4 7.1 2.3 8.4 2.2 8.8 2.2 12 2.2zm0 3.2a6.6 6.6 0 1 0 0 13.2 6.6 6.6 0 0 0 0-13.2zm0 10.9a4.3 4.3 0 1 1 0-8.6 4.3 4.3 0 0 1 0 8.6zm6.8-11.1a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/></svg>',
	'youtube'   => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23 7.5a3 3 0 0 0-2.1-2.1C19 4.9 12 4.9 12 4.9s-7 0-8.9.5A3 3 0 0 0 1 7.5 31 31 0 0 0 .5 12 31 31 0 0 0 1 16.5a3 3 0 0 0 2.1 2.1c1.9.5 8.9.5 8.9.5s7 0 8.9-.5a3 3 0 0 0 2.1-2.1A31 31 0 0 0 23.5 12 31 31 0 0 0 23 7.5zM9.8 15.3V8.7l5.7 3.3z"/></svg>',
	'github'    => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2a10 10 0 0 0-3.2 19.5c.5.1.7-.2.7-.5v-1.7c-2.8.6-3.4-1.3-3.4-1.3-.5-1.2-1.1-1.5-1.1-1.5-.9-.6.1-.6.1-.6 1 .1 1.5 1 1.5 1 .9 1.6 2.4 1.1 3 .9.1-.7.4-1.1.6-1.4-2.2-.3-4.6-1.1-4.6-5 0-1.1.4-2 1-2.7-.1-.3-.4-1.3.1-2.7 0 0 .8-.3 2.7 1a9.3 9.3 0 0 1 5 0c1.9-1.3 2.7-1 2.7-1 .5 1.4.2 2.4.1 2.7.6.7 1 1.6 1 2.7 0 3.9-2.4 4.7-4.6 5 .4.3.7.9.7 1.9v2.8c0 .3.2.6.7.5A10 10 0 0 0 12 2z"/></svg>',
];

// ── Closure: render a single info item (li element) ──────────
$render_info_item = function( $item ) use ( $icons ) {
	$icon_type = isset( $item['infoIconType'] ) ? $item['infoIconType'] : 'custom';
	$label     = isset( $item['infoLabel'] )    ? esc_html( $item['infoLabel'] ) : '';
	$value     = isset( $item['infoValue'] )    ? $item['infoValue']              : '';
	$link      = isset( $item['infoLink'] )     ? esc_url( $item['infoLink'] )    : '';
	$icon_svg  = isset( $icons[ $icon_type ] )  ? $icons[ $icon_type ]            : $icons['custom'];
	$value_html = nl2br( esc_html( $value ) );
	?>
	<li class="htm25-contact__info-item" role="listitem">
		<div class="htm25-contact__info-icon" aria-hidden="true">
			<?php echo $icon_svg; // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>
		<div class="htm25-contact__info-content">
			<?php if ( $label ) : ?><span class="htm25-contact__info-label"><?php echo esc_html( $label ); ?></span><?php endif; ?>
			<?php if ( $link ) : ?>
			<a href="<?php echo esc_url( $link ); ?>" class="htm25-contact__info-value htm25-contact__info-value--link">
				<?php echo $value_html; // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</a>
			<?php else : ?>
			<span class="htm25-contact__info-value"><?php echo $value_html; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
			<?php endif; ?>
		</div>
	</li>
	<?php
};
?>
<?php if ( $_css_out ) : ?><style><?php echo $_css_out; // phpcs:ignore WordPress.Security.EscapeOutput ?></style><?php endif; ?>
<div class="htmega-block-<?php echo esc_attr( $block_id ); ?>">
<div class="htm25-style--<?php echo esc_attr( $design_style ); ?>">
<section class="htm25-contact htm25-contact--<?php echo esc_attr( $layout ); ?><?php echo esc_attr( $no_map_class ); ?>" aria-label="<?php esc_attr_e( 'Contact section', 'htmega-addons' ); ?>">

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

		<?php if ( ( $show_label && $label_text ) || $headline || $description ) : ?>
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
				<?php
				$shortcodes = [
					'htcf'         => $form_id ? sprintf( '[ht_form id="%d"]', $form_id ) : '',
					'cf7'          => $form_id ? sprintf( '[contact-form-7 id="%d"]', $form_id ) : '',
					'wpforms'      => $form_id ? sprintf( '[wpforms id="%d"]', $form_id ) : '',
					'fluentform'   => $form_id ? sprintf( '[fluentform id="%d"]', $form_id ) : '',
					'gravityforms' => $form_id ? sprintf( '[gravityforms id="%d"]', $form_id ) : '',
					'ninjaforms'   => $form_id ? sprintf( '[ninja_form id="%d"]', $form_id ) : '',
				];

				if ( $form_plugin && $form_id && isset( $shortcodes[ $form_plugin ] ) ) {
					$wrapper_class = 'htm25-contact__form htm25-contact__form--third-party htm25-contact__form--' . esc_attr( $form_plugin );
					if ( $form_css_class ) {
						$wrapper_class .= ' ' . esc_attr( $form_css_class );
					}
					echo '<div class="' . esc_attr( $wrapper_class ) . '">' . do_shortcode( $shortcodes[ $form_plugin ] ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput
				} else {
					echo '<div class="htm25-contact__form-placeholder" style="padding:24px;text-align:center;border:2px dashed var(--htm25-border-color,#ddd);border-radius:8px;color:var(--htm25-text-muted,#888);">'
					   . esc_html__( 'Select a form plugin and form in the block settings panel.', 'htmega-addons' )
					   . '</div>';
				}
				?>
			</div><!-- .htm25-contact__form-col -->
			<?php endif; ?>

			<?php if ( $has_aside ) : ?>
			<!-- ── Info / Hours / Social / Map / Trust ── -->
			<aside class="htm25-contact__info-col" aria-label="<?php esc_attr_e( 'Contact information', 'htmega-addons' ); ?>">

				<?php if ( ! empty( $info_items ) ) : ?>
				<div class="htm25-contact__tile htm25-contact__tile--info">
					<ul class="htm25-contact__info-list" role="list">
						<?php foreach ( $info_items as $item ) : $render_info_item( $item ); endforeach; ?>
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
								<span><?php echo esc_html( ! empty( $hrow['hoursDay'] ) ? $hrow['hoursDay'] : '' ); ?></span>
								<span><?php echo esc_html( ! empty( $hrow['hoursTime'] ) ? $hrow['hoursTime'] : '' ); ?></span>
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
								$net  = ! empty( $sitem['socialNetwork'] ) ? $sitem['socialNetwork'] : 'facebook';
								$surl = ! empty( $sitem['socialUrl'] )     ? esc_url( $sitem['socialUrl'] ) : '#';
								$ssvg = isset( $social_icons[ $net ] )     ? $social_icons[ $net ]          : $social_icons['facebook'];
							?>
							<a class="htm25-contact__social-link" href="<?php echo esc_url( $surl ); ?>"
							   aria-label="<?php echo esc_attr( ucfirst( $net ) ); ?>"
							   target="_blank" rel="noopener noreferrer">
								<?php echo $ssvg; // phpcs:ignore WordPress.Security.EscapeOutput ?>
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
</div><!-- .htmega-block-scope -->
