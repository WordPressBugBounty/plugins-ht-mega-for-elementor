<?php
/**
 * HT Mega 2026 — Hero Block (FSE / Gutenberg)
 * Block name: htmega/hero-2025
 *
 * Server-side renderer. Shares the same BEM HTML structure as
 * the Elementor widget (htmega_2025_hero.php) and the same CSS
 * (htm25-tokens.css + assets/css/widgets/htm25-hero.css).
 *
 * PHP variables available from Blocks_init::prepare_block_data():
 *   $settings (array)  — block attributes
 *   $content  (string) — inner block content (not used — server render)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ── Attribute helpers ────────────────────────────────────────

$style  = isset( $settings['designStyle'] ) ? sanitize_html_class( $settings['designStyle'] ) : 'bento';
$layout = isset( $settings['layout'] )      ? sanitize_html_class( $settings['layout'] )      : 'centered';

// Unique wrapper ID (used for CSS class scoping, prefixed 'h' to keep valid CSS identifiers)
$block_id = isset( $settings['blockUniqId'] ) ? sanitize_html_class( $settings['blockUniqId'] ) : uniqid( 'h' );

// Headline + highlight
$headline  = isset( $settings['headline'] ) ? $settings['headline'] : 'Build Faster.\nShip Smarter.';
$headline  = esc_html( $headline );
$highlight = isset( $settings['headlineHighlight'] ) ? trim( $settings['headlineHighlight'] ) : '';

if ( $highlight ) {
    $headline = str_replace(
        esc_html( $highlight ),
        '<span class="htm25-hero__headline-accent">' . esc_html( $highlight ) . '</span>',
        $headline
    );
}

$headline_tag = isset( $settings['headlineTag'] ) && in_array( $settings['headlineTag'], [ 'h1', 'h2', 'h3' ] )
    ? $settings['headlineTag'] : 'h1';

// Badge
$show_badge = ! empty( $settings['showBadge'] );
$badge_text = isset( $settings['badgeText'] ) ? $settings['badgeText'] : '';
$badge_icon = isset( $settings['badgeIcon'] ) ? $settings['badgeIcon'] : '';

$render_icon = function( $cls ) {
    if ( ! $cls ) { return ''; }
    return '<span class="' . esc_attr( $cls ) . '" aria-hidden="true"></span>';
};

// Description
$description = isset( $settings['description'] ) ? $settings['description'] : '';

// CTA buttons
$show_primary_btn   = ! empty( $settings['showPrimaryBtn'] );
$primary_btn_text   = isset( $settings['primaryBtnText'] )   ? $settings['primaryBtnText']   : '';
$primary_btn_url    = isset( $settings['primaryBtnUrl'] )    ? $settings['primaryBtnUrl']    : '#';
$primary_btn_target = ! empty( $settings['primaryBtnTarget'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';

$show_secondary_btn   = ! empty( $settings['showSecondaryBtn'] );
$secondary_btn_text   = isset( $settings['secondaryBtnText'] )   ? $settings['secondaryBtnText']   : '';
$secondary_btn_url    = isset( $settings['secondaryBtnUrl'] )    ? $settings['secondaryBtnUrl']    : '#';
$secondary_btn_target = ! empty( $settings['secondaryBtnTarget'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
$secondary_btn_icon   = isset( $settings['secondaryBtnIcon'] )   ? $settings['secondaryBtnIcon']   : '';

// Social proof
$show_social_proof   = ! empty( $settings['showSocialProof'] );
$social_proof_text   = isset( $settings['socialProofText'] )   ? $settings['socialProofText']   : '';
$social_proof_rating = isset( $settings['socialProofRating'] ) ? $settings['socialProofRating'] : '';

// Media
$hero_image_url = isset( $settings['heroImageUrl'] ) ? $settings['heroImageUrl'] : '';
$hero_image_alt = isset( $settings['heroImageAlt'] ) ? $settings['heroImageAlt'] : '';
$hero_image_id  = isset( $settings['heroImageId'] )  ? (int) $settings['heroImageId'] : 0;

$image_html = '';
if ( $layout !== 'centered' ) {
    if ( $hero_image_id ) {
        $image_html = wp_get_attachment_image( $hero_image_id, 'large', false, [ 'loading' => 'lazy' ] );
    } elseif ( $hero_image_url ) {
        $image_html = '<img src="' . esc_url( $hero_image_url ) . '" alt="' . esc_attr( $hero_image_alt ) . '" loading="lazy">';
    }
}

// Floating badge
$show_float_badge     = ! empty( $settings['showFloatingBadge'] );
$floating_stat_number = isset( $settings['floatingStatNumber'] ) ? $settings['floatingStatNumber'] : '';
$floating_stat_label  = isset( $settings['floatingStatLabel'] )  ? $settings['floatingStatLabel']  : '';

// ── Dynamic CSS (mirrors buildHeroCss in edit.js) ───────────
$sc   = '.htmega-block-' . $block_id;
$_css = [];

$_num = function( $value, $unit = 'px' ) {
    if ( ! is_numeric( $value ) ) return '';
    $allowed = [ 'px', 'em', 'rem', '%', 'vh', 'vw', 'vmin', 'vmax', 'ch', 'ex', 'pt' ];
    $unit    = in_array( $unit, $allowed, true ) ? $unit : 'px';
    return ( $value + 0 ) . $unit;
};
$_border = function( $type, $width, $color ) use ( $_num ) {
    if ( ! $type || $type === 'none' ) return [];
    $r = [ 'border-style: ' . esc_attr( $type ) ];
    if ( $width && is_array( $width ) ) {
        $u = $width['unit'] ?? 'px';
        if ( isset( $width['link'] ) && $width['link'] === 'yes' && isset( $width['top'] ) ) {
            $val = $_num( $width['top'], $u );
            if ( $val !== '' ) $r[] = 'border-width: ' . $val;
        } else {
            foreach ( [ 'top', 'right', 'bottom', 'left' ] as $_s ) {
                if ( ! empty( $width[ $_s ] ) ) {
                    $val = $_num( $width[ $_s ], $u );
                    if ( $val !== '' ) $r[] = "border-{$_s}-width: {$val}";
                }
            }
        }
    }
    if ( $color ) $r[] = 'border-color: ' . esc_attr( $color );
    return $r;
};
$_radius = function( $rv ) use ( $_num ) {
    if ( ! $rv || ! is_array( $rv ) ) return [];
    $u   = $rv['unit'] ?? 'px';
    $map = [ 'top' => 'top-left', 'right' => 'top-right', 'bottom' => 'bottom-right', 'left' => 'bottom-left' ];
    $r   = [];
    foreach ( $map as $_s => $corner ) {
        if ( isset( $rv[ $_s ] ) && $rv[ $_s ] !== '' ) {
            $val = $_num( $rv[ $_s ], $u );
            if ( $val !== '' ) $r[] = "border-{$corner}-radius: {$val}";
        }
    }
    return $r;
};
$_shadow = function( $s ) {
    if ( ! $s || ! is_array( $s ) || empty( $s['color'] ) ) return '';
    $i  = ! empty( $s['inset'] ) ? 'inset ' : '';
    $h  = is_numeric( $s['horizontal'] ?? null ) ? floatval( $s['horizontal'] ) : 0;
    $v  = is_numeric( $s['vertical']   ?? null ) ? floatval( $s['vertical'] )   : 0;
    $b  = is_numeric( $s['blur']       ?? null ) ? floatval( $s['blur'] )       : 0;
    $sp = is_numeric( $s['spread']     ?? null ) ? floatval( $s['spread'] )     : 0;
    return 'box-shadow: ' . $i . $h . 'px ' . $v . 'px ' . $b . 'px ' . $sp . 'px ' . esc_attr( $s['color'] );
};
$_typo = function( $t ) use ( $_num ) {
    if ( ! $t || ! is_array( $t ) ) return [];
    $r = [];
    if ( ! empty( $t['family'] ) ) $r[] = "font-family: '" . esc_attr( $t['family'] ) . "', sans-serif";
    if ( ! empty( $t['size'] ) ) {
        $val = $_num( $t['size'], $t['sizeUnit'] ?? 'px' );
        if ( $val !== '' ) $r[] = 'font-size: ' . $val;
    }
    if ( ! empty( $t['weight'] ) ) $r[] = 'font-weight: ' . esc_attr( $t['weight'] );
    if ( isset( $t['lineHeight'] ) && is_numeric( $t['lineHeight'] ) ) $r[] = 'line-height: ' . ( $t['lineHeight'] + 0 );
    if ( isset( $t['letterSpacing'] ) && is_numeric( $t['letterSpacing'] ) ) $r[] = 'letter-spacing: ' . ( $t['letterSpacing'] + 0 ) . 'px';
    if ( ! empty( $t['transform'] ) ) $r[] = 'text-transform: ' . esc_attr( $t['transform'] );
    return $r;
};
$_dim = function( $dim, $prop ) use ( $_num ) {
    if ( ! $dim || ! is_array( $dim ) ) return [];
    $d = isset( $dim['desktop'] ) ? $dim['desktop'] : $dim;
    $u = $d['unit'] ?? $dim['unit'] ?? 'px';
    $r = [];
    foreach ( [ 'top', 'right', 'bottom', 'left' ] as $_s ) {
        if ( isset( $d[ $_s ] ) && $d[ $_s ] !== '' ) {
            $val = $_num( $d[ $_s ], $u );
            if ( $val !== '' ) $r[] = "{$prop}-{$_s}: {$val}";
        }
    }
    return $r;
};
$_rule = function( $sel, $rules ) use ( $sc, &$_css ) {
    if ( ! empty( $rules ) ) $_css[] = $sc . $sel . ' { ' . implode( '; ', $rules ) . '; }';
};

// ── Section ──
$_sec = [];
if ( ! empty( $settings['styleAccentColor'] )       ) $_sec[] = '--htm25-accent-primary: '   . esc_attr( $settings['styleAccentColor'] );
if ( ! empty( $settings['styleSectionBgColor'] )    ) $_sec[] = 'background-color: '         . esc_attr( $settings['styleSectionBgColor'] );
if ( ! empty( $settings['styleSectionBgGradient'] ) ) { $_sec[] = 'background: ' . esc_attr( $settings['styleSectionBgGradient'] ); $_sec[] = 'background-color: transparent'; }
$_sec = array_merge( $_sec, $_dim( $settings['styleSectionPadding'] ?? null, 'padding' ), $_border( $settings['sectionBorderType'] ?? null, $settings['sectionBorderWidth'] ?? null, $settings['sectionBorderColor'] ?? null ), $_radius( $settings['styleSectionBorderRadius'] ?? null ) );
$_sw = $_shadow( $settings['styleSectionShadow'] ?? null ); if ( $_sw ) $_sec[] = $_sw;
if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-hero { ' . implode( '; ', $_sec ) . '; }';
if ( ! empty( $settings['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-hero__inner { max-width: ' . esc_attr( $settings['styleContainerMaxWidth'] ) . '; }';

// ── Headline ──
$_hl = array_merge( $_typo( $settings['styleHeadlineTypography'] ?? null ), $_dim( $settings['styleHeadlineMargin'] ?? null, 'margin' ) );
if ( ! empty( $settings['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $settings['styleHeadlineColor'] );
$_rule( ' .htm25-hero__headline', $_hl );
if ( ! empty( $settings['styleHeadlineHoverColor'] ) ) $_css[] = $sc . ' .htm25-hero__headline:hover { color: ' . esc_attr( $settings['styleHeadlineHoverColor'] ) . '; transition: color 0.2s ease; }';
// Compound selector for specificity (0,3,0) to beat per-style rules at (0,2,0)
if ( ! empty( $settings['styleHeadlineHighlightColor'] )   ) $_css[] = $sc . ' .htm25-hero .htm25-hero__headline-accent { background-color: ' . esc_attr( $settings['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
if ( ! empty( $settings['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-hero .htm25-hero__headline-accent { background: ' . esc_attr( $settings['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

// ── Description ──
$_desc = $_typo( $settings['styleDescTypography'] ?? null );
if ( ! empty( $settings['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $settings['styleDescColor'] );
$_rule( ' .htm25-hero__description', $_desc );

// ── Badge ──
$_badge = $_typo( $settings['styleBadgeTypography'] ?? null );
if ( ! empty( $settings['styleBadgeTextColor'] ) ) $_badge[] = 'color: '            . esc_attr( $settings['styleBadgeTextColor'] );
if ( ! empty( $settings['styleBadgeBgColor'] )   ) $_badge[] = 'background-color: ' . esc_attr( $settings['styleBadgeBgColor'] );
if ( ! empty( $settings['styleBadgeIconGap'] )   ) $_badge[] = 'gap: '              . absint( $settings['styleBadgeIconGap'] ) . 'px';
$_badge = array_merge( $_badge, $_border( $settings['badgeBorderType'] ?? null, $settings['badgeBorderWidth'] ?? null, $settings['badgeBorderColor'] ?? null ), $_radius( $settings['styleBadgeBorderRadius'] ?? null ) );
$_rule( ' .htm25-hero__badge', $_badge );
if ( ! empty( $settings['styleBadgeIconColor'] ) ) {
    $_ic = esc_attr( $settings['styleBadgeIconColor'] );
    $_css[] = "$sc .htm25-hero__badge-icon i, $sc .htm25-hero__badge-icon span { color: $_ic; }";
    $_css[] = "$sc .htm25-hero__badge-icon svg { color: $_ic; }";
    $_css[] = "$sc .htm25-hero__badge-icon svg path { fill: $_ic; }";
}
if ( ! empty( $settings['styleBadgeIconSize'] ) ) {
    $_sz = absint( $settings['styleBadgeIconSize'] );
    $_css[] = "$sc .htm25-hero__badge-icon i, $sc .htm25-hero__badge-icon span { font-size: {$_sz}px; }";
    $_css[] = "$sc .htm25-hero__badge-icon svg { width: {$_sz}px; height: {$_sz}px; }";
}

// ── Buttons gap ──
// 0 is valid (no gap); only skip when truly unset
if ( isset( $settings['styleBtnGap'] ) && is_numeric( $settings['styleBtnGap'] ) ) {
    $_css[] = $sc . ' .htm25-hero__actions { gap: ' . floatval( $settings['styleBtnGap'] ) . 'rem; }';
}

// ── Primary button – normal ──
$_pb = $_typo( $settings['stylePrimaryBtnTypography'] ?? null );
if ( ! empty( $settings['stylePrimaryBtnBgColor'] )    ) { $_pb[] = 'background-color: ' . esc_attr( $settings['stylePrimaryBtnBgColor'] ); $_pb[] = 'background-image: none'; }
if ( ! empty( $settings['stylePrimaryBtnBgGradient'] ) ) { $_pb[] = 'background: ' . esc_attr( $settings['stylePrimaryBtnBgGradient'] ); $_pb[] = 'background-color: transparent'; }
if ( ! empty( $settings['stylePrimaryBtnTextColor'] )  ) $_pb[] = 'color: ' . esc_attr( $settings['stylePrimaryBtnTextColor'] );
$_pb  = array_merge( $_pb, $_border( $settings['primaryBtnBorderType'] ?? null, $settings['primaryBtnBorderWidth'] ?? null, $settings['primaryBtnBorderColor'] ?? null ), $_radius( $settings['stylePrimaryBtnBorderRadiusObj'] ?? null ) );
$_pbs = $_shadow( $settings['stylePrimaryBtnShadow'] ?? null ); if ( $_pbs ) $_pb[] = $_pbs;
$_rule( ' .htm25-btn--primary', $_pb );

// ── Primary button – hover ──
$_pbh = [];
if ( ! empty( $settings['stylePrimaryBtnHoverBgGradient'] ) ) $_pbh[] = 'background: ' . esc_attr( $settings['stylePrimaryBtnHoverBgGradient'] );
elseif ( ! empty( $settings['stylePrimaryBtnHoverBgColor'] ) ) $_pbh[] = 'background: ' . esc_attr( $settings['stylePrimaryBtnHoverBgColor'] );
if ( ! empty( $settings['stylePrimaryBtnHoverTextColor'] ) ) $_pbh[] = 'color: ' . esc_attr( $settings['stylePrimaryBtnHoverTextColor'] );
$_pbh = array_merge( $_pbh, $_border( $settings['primaryBtnHoverBorderType'] ?? null, $settings['primaryBtnHoverBorderWidth'] ?? null, $settings['primaryBtnHoverBorderColor'] ?? null ) );
$_rule( ' .htm25-btn--primary:hover', $_pbh );

// ── Secondary button – normal ──
$_sb = $_typo( $settings['styleSecondaryBtnTypography'] ?? null );
if ( ! empty( $settings['styleSecondaryBtnBgGradient'] ) ) { $_sb[] = 'background: ' . esc_attr( $settings['styleSecondaryBtnBgGradient'] ); }
elseif ( ! empty( $settings['styleSecondaryBtnBgColor'] ) ) { $_sb[] = 'background: ' . esc_attr( $settings['styleSecondaryBtnBgColor'] ); }
if ( ! empty( $settings['styleSecondaryBtnTextColor'] ) ) $_sb[] = 'color: ' . esc_attr( $settings['styleSecondaryBtnTextColor'] );
$_sb = array_merge( $_sb, $_border( $settings['secondaryBtnBorderType'] ?? null, $settings['secondaryBtnBorderWidth'] ?? null, $settings['secondaryBtnBorderColor'] ?? null ) );
if ( ! empty( $settings['styleSecondaryBtnBorderColor'] ) && empty( $settings['secondaryBtnBorderType'] ) ) {
    $_sb[] = 'border-color: ' . esc_attr( $settings['styleSecondaryBtnBorderColor'] );
}
$_rule( ' .htm25-btn--outline', $_sb );

// Play icon inherits secondary btn text color
if ( ! empty( $settings['styleSecondaryBtnTextColor'] ) ) {
    $_stc = esc_attr( $settings['styleSecondaryBtnTextColor'] );
    $_css[] = "$sc .htm25-hero__play-icon, $sc .htm25-hero__play-icon i, $sc .htm25-hero__play-icon span { color: $_stc; }";
    $_css[] = "$sc .htm25-hero__play-icon svg { color: $_stc; }";
    $_css[] = "$sc .htm25-hero__play-icon svg path { fill: $_stc; }";
}
if ( ! empty( $settings['styleIconCircleBgColor'] ) ) {
    $_css[] = $sc . ' .htm25-hero__play-icon { background-color: ' . esc_attr( $settings['styleIconCircleBgColor'] ) . '; background-image: none; }';
}
if ( ! empty( $settings['styleIconCircleColor'] ) ) {
    $_icc = esc_attr( $settings['styleIconCircleColor'] );
    $_css[] = "$sc .htm25-hero__play-icon i, $sc .htm25-hero__play-icon span { color: $_icc; }";
    $_css[] = "$sc .htm25-hero__play-icon svg { color: $_icc; }";
    $_css[] = "$sc .htm25-hero__play-icon svg path { fill: $_icc; }";
}

// ── Secondary button – hover ──
$_sbh = [];
if ( ! empty( $settings['styleSecondaryBtnHoverBgGradient'] ) ) $_sbh[] = 'background: ' . esc_attr( $settings['styleSecondaryBtnHoverBgGradient'] );
elseif ( ! empty( $settings['styleSecondaryBtnHoverBgColor'] ) ) $_sbh[] = 'background: ' . esc_attr( $settings['styleSecondaryBtnHoverBgColor'] );
if ( ! empty( $settings['styleSecondaryBtnHoverTextColor'] ) ) $_sbh[] = 'color: ' . esc_attr( $settings['styleSecondaryBtnHoverTextColor'] );
$_sbh = array_merge( $_sbh, $_border( $settings['secondaryBtnHoverBorderType'] ?? null, $settings['secondaryBtnHoverBorderWidth'] ?? null, $settings['secondaryBtnHoverBorderColor'] ?? null ) );
$_rule( ' .htm25-btn--outline:hover', $_sbh );

// ── Social proof ──
$_sp = $_typo( $settings['styleSocialProofTypography'] ?? null );
if ( ! empty( $settings['styleSocialProofTextColor'] ) ) $_sp[] = 'color: ' . esc_attr( $settings['styleSocialProofTextColor'] );
$_rule( ' .htm25-hero__social-text', $_sp );

$_rt = $_typo( $settings['styleRatingTypography'] ?? null );
if ( ! empty( $settings['styleRatingColor'] ) ) $_rt[] = 'color: ' . esc_attr( $settings['styleRatingColor'] );
$_rule( ' .htm25-hero__rating', $_rt );

if ( ! empty( $settings['styleStarsColor'] ) ) {
    $_sc = esc_attr( $settings['styleStarsColor'] );
    $_css[] = $sc . ' .htm25-hero__stars { color: ' . $_sc . '; }';
    $_css[] = $sc . ' .htm25-hero__stars svg path { fill: ' . $_sc . '; }';
}

// ── Floating badge ──
$_fb = $_radius( $settings['styleFloatBadgeRadius'] ?? null );
if ( ! empty( $settings['styleFloatBadgeBgColor'] ) ) $_fb[] = 'background-color: ' . esc_attr( $settings['styleFloatBadgeBgColor'] );
$_rule( ' .htm25-hero__float-badge', $_fb );
$_fbn = $_typo( $settings['styleFloatBadgeNumberTypography'] ?? null ); if ( ! empty( $settings['styleFloatBadgeNumberColor'] ) ) $_fbn[] = 'color: ' . esc_attr( $settings['styleFloatBadgeNumberColor'] ); $_rule( ' .htm25-hero__float-number', $_fbn );
$_fbl = $_typo( $settings['styleFloatBadgeLabelTypography']  ?? null ); if ( ! empty( $settings['styleFloatBadgeLabelColor'] ) )  $_fbl[] = 'color: ' . esc_attr( $settings['styleFloatBadgeLabelColor'] );  $_rule( ' .htm25-hero__float-label', $_fbl );

// ── Hero image ──
$_img = array_merge( $_border( $settings['imageBorderType'] ?? null, $settings['imageBorderWidth'] ?? null, $settings['imageBorderColor'] ?? null ), $_radius( $settings['styleImageBorderRadiusObj'] ?? null ) );
$_isw = $_shadow( $settings['styleImageShadow'] ?? null ); if ( $_isw ) $_img[] = $_isw;
$_rule( ' .htm25-hero__media img', $_img );

// ── Google Fonts: collect @import rules and prepend ──
$_sys_font_pat = '/^(sans-serif|serif|serif-alt|monospace)$/i';
$_gf_imports   = [];
$_typo_keys    = [
    'styleHeadlineTypography', 'styleDescTypography', 'styleBadgeTypography',
    'stylePrimaryBtnTypography', 'styleSecondaryBtnTypography',
    'styleSocialProofTypography', 'styleRatingTypography',
    'styleFloatBadgeNumberTypography', 'styleFloatBadgeLabelTypography',
];
foreach ( $_typo_keys as $_tk ) {
    $_tf = isset( $settings[ $_tk ] ) ? (array) $settings[ $_tk ] : [];
    if ( ! empty( $_tf['family'] ) && ! preg_match( $_sys_font_pat, $_tf['family'] ) ) {
        $_fe = rawurlencode( $_tf['family'] );
        $_gf_imports[ $_tf['family'] ] = "@import url('https://fonts.googleapis.com/css?family={$_fe}:400,400italic,600,600italic,700,700italic&display=swap');";
    }
}
if ( $_gf_imports ) array_unshift( $_css, implode( ' ', $_gf_imports ) );

$_css_out = implode( "\n", $_css );

// ── Render ───────────────────────────────────────────────────
?>
<?php if ( $_css_out ) : ?><style><?php echo $_css_out; // phpcs:ignore WordPress.Security.EscapeOutput ?></style><?php endif; ?>
<div class="htmega-block-<?php echo esc_attr( $block_id ); ?>">
<section
    class="htm25-hero htm25-style--<?php echo esc_attr( $style ); ?> htm25-hero--<?php echo esc_attr( $layout ); ?>"
    aria-label="<?php esc_attr_e( 'Hero section', 'ht-mega-for-elementor' ); ?>"
>

    <?php if ( $style === 'aurora' || $style === 'glass' ) : ?>
    <div class="htm25-hero__bg-blobs" aria-hidden="true">
        <div class="htm25-hero__blob htm25-hero__blob--1"></div>
        <div class="htm25-hero__blob htm25-hero__blob--2"></div>
        <?php if ( $style === 'aurora' ) : ?>
        <div class="htm25-hero__blob htm25-hero__blob--3"></div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if ( $style === 'neo' ) : ?>
    <div class="htm25-hero__neo-grid" aria-hidden="true"></div>
    <?php endif; ?>

    <div class="htm25-hero__inner">

        <?php if ( $layout === 'split-right' ) : ?>
        <div class="htm25-hero__media">
            <?php if ( $image_html ) : ?>
                <?php echo $image_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <?php else : ?>
                <div class="htm25-hero__media-placeholder" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                        <circle cx="12" cy="13" r="4"/>
                    </svg>
                    <span><?php esc_html_e( 'Add an image', 'ht-mega-for-elementor' ); ?></span>
                </div>
            <?php endif; ?>
            <?php if ( $show_float_badge && ( $floating_stat_number || $floating_stat_label ) ) : ?>
            <div class="htm25-hero__float-badge" aria-label="<?php echo esc_attr( $floating_stat_number . ' ' . $floating_stat_label ); ?>">
                <span class="htm25-hero__float-number"><?php echo esc_html( $floating_stat_number ); ?></span>
                <span class="htm25-hero__float-label"><?php echo esc_html( $floating_stat_label ); ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="htm25-hero__content">

            <?php if ( $show_badge && $badge_text ) : ?>
            <div class="htm25-hero__badge htm25-badge" role="note">
                <?php if ( $badge_icon ) : ?>
                <span class="htm25-hero__badge-icon" aria-hidden="true">
                    <?php echo $render_icon( $badge_icon ); // phpcs:ignore ?>
                </span>
                <?php endif; ?>
                <span><?php echo esc_html( $badge_text ); ?></span>
            </div>
            <?php endif; ?>

            <<?php echo esc_html( $headline_tag ); ?> class="htm25-hero__headline"><?php echo $headline; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $headline is esc_html()'d above (and any accent span is built from esc_html() pieces + hardcoded markup) ?></<?php echo esc_html( $headline_tag ); ?>>

            <?php if ( $description ) : ?>
            <p class="htm25-hero__description">
                <?php echo wp_kses_post( $description ); ?>
            </p>
            <?php endif; ?>

            <?php if ( $show_primary_btn || $show_secondary_btn ) : ?>
            <div class="htm25-hero__actions">

                <?php if ( $show_primary_btn && $primary_btn_text ) : ?>
                <a
                    href="<?php echo esc_url( $primary_btn_url ); ?>"
                    class="htm25-btn htm25-btn--primary"
                    <?php echo $primary_btn_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $primary_btn_target is a hardcoded literal (' target="_blank" rel="noopener noreferrer"' or ''), no user input ?>
                >
                    <?php echo esc_html( $primary_btn_text ); ?>
                </a>
                <?php endif; ?>

                <?php if ( $show_secondary_btn && $secondary_btn_text ) : ?>
                <a
                    href="<?php echo esc_url( $secondary_btn_url ); ?>"
                    class="htm25-btn htm25-btn--outline htm25-hero__btn-secondary"
                    <?php echo $secondary_btn_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $secondary_btn_target is a hardcoded literal (' target="_blank" rel="noopener noreferrer"' or ''), no user input ?>
                >
                    <?php if ( $secondary_btn_icon ) : ?>
                    <span class="htm25-hero__play-icon" aria-hidden="true">
                        <?php echo $render_icon( $secondary_btn_icon ); // phpcs:ignore ?>
                    </span>
                    <?php endif; ?>
                    <?php echo esc_html( $secondary_btn_text ); ?>
                </a>
                <?php endif; ?>

            </div>
            <?php endif; ?>

            <?php if ( $show_social_proof && $social_proof_text ) : ?>
            <div class="htm25-hero__social-proof">
                <div class="htm25-hero__stars" aria-hidden="true">
                    <?php for ( $i = 0; $i < 5; $i++ ) : ?>
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M7 1L8.854 5.04L13.294 5.635L10.147 8.7L10.909 13.122L7 11L3.091 13.122L3.853 8.7L0.706 5.635L5.146 5.04L7 1Z" fill="currentColor"/>
                    </svg>
                    <?php endfor; ?>
                </div>
                <?php if ( $social_proof_rating ) : ?>
                <span class="htm25-hero__rating"><?php echo esc_html( $social_proof_rating ); ?></span>
                <?php endif; ?>
                <span class="htm25-hero__social-text"><?php echo esc_html( $social_proof_text ); ?></span>
            </div>
            <?php endif; ?>

        </div><!-- /.htm25-hero__content -->

        <?php if ( $layout === 'split-left' ) : ?>
        <div class="htm25-hero__media">
            <?php if ( $image_html ) : ?>
                <?php echo $image_html; // phpcs:ignore ?>
            <?php else : ?>
                <div class="htm25-hero__media-placeholder" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                        <circle cx="12" cy="13" r="4"/>
                    </svg>
                    <span><?php esc_html_e( 'Add an image', 'ht-mega-for-elementor' ); ?></span>
                </div>
            <?php endif; ?>
            <?php if ( $show_float_badge && ( $floating_stat_number || $floating_stat_label ) ) : ?>
            <div class="htm25-hero__float-badge" aria-label="<?php echo esc_attr( $floating_stat_number . ' ' . $floating_stat_label ); ?>">
                <span class="htm25-hero__float-number"><?php echo esc_html( $floating_stat_number ); ?></span>
                <span class="htm25-hero__float-label"><?php echo esc_html( $floating_stat_label ); ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div><!-- /.htm25-hero__inner -->

</section>
</div><!-- /.htmega-block-scope -->
