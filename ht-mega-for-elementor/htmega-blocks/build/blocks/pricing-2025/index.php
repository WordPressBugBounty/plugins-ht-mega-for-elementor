<?php
/**
 * HT Mega 2026 — Pricing Table Block (FSE / Gutenberg)
 * Block name: htmega/pricing-2025
 *
 * Server-side renderer. Shares the same BEM HTML structure as
 * the Elementor widget (htmega_2025_pricing.php) and the same CSS
 * (htm25-tokens.css + assets/css/widgets/htm25-pricing.css).
 *
 * PHP variables available from Blocks_init::prepare_block_data():
 *   $settings (array)  — block attributes
 *   $content  (string) — inner block content (not used — server render)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ── Attribute helpers ────────────────────────────────────────────

$style  = isset( $settings['designStyle'] ) ? sanitize_html_class( $settings['designStyle'] ) : 'bento';
$layout = isset( $settings['layout'] )      ? sanitize_html_class( $settings['layout'] )      : 'cards';
$cols   = isset( $settings['planColumns'] ) ? (int) $settings['planColumns'] : 3;
$cols   = in_array( $cols, [ 2, 3, 4 ], true ) ? $cols : 3;

$show_label = isset( $settings['showSectionLabel'] ) ? (bool) $settings['showSectionLabel'] : true;
$label_text = isset( $settings['sectionLabelText'] ) ? $settings['sectionLabelText'] : 'Pricing';

$headline  = isset( $settings['headline'] ) ? $settings['headline'] : "Simple pricing for\nevery team size.";
$headline  = esc_html( $headline );
$highlight = isset( $settings['headlineHighlight'] ) ? trim( $settings['headlineHighlight'] ) : '';
if ( $highlight ) {
    $headline = str_replace(
        esc_html( $highlight ),
        '<span class="htm25-pricing__headline-accent">' . esc_html( $highlight ) . '</span>',
        $headline
    );
}
$headline_tag = isset( $settings['headlineTag'] ) && in_array( $settings['headlineTag'], [ 'h1', 'h2', 'h3' ] )
    ? $settings['headlineTag'] : 'h2';

$description = isset( $settings['description'] ) ? $settings['description'] : '';

$show_toggle   = isset( $settings['showBillingToggle'] ) ? (bool) $settings['showBillingToggle'] : true;
$label_monthly = isset( $settings['billingMonthlyLabel'] ) ? $settings['billingMonthlyLabel'] : 'Monthly';
$label_annual  = isset( $settings['billingAnnualLabel'] )  ? $settings['billingAnnualLabel']  : 'Annual';
$save_badge    = isset( $settings['billingSaveBadge'] )    ? $settings['billingSaveBadge']    : '';

$plan_items = isset( $settings['planItems'] ) && is_array( $settings['planItems'] ) ? $settings['planItems'] : [];

$uid       = isset( $settings['blockUniqId'] ) && $settings['blockUniqId'] ? $settings['blockUniqId'] : uniqid( 'pr' );
$toggle_id = 'htm25-toggle-' . $uid;
$block_id  = $uid;

// ── Dynamic CSS (mirrors buildPricingCss in edit.js) ─────────
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

// Section
$_sec = [];
if ( ! empty( $settings['styleSectionBgColor'] )    ) $_sec[] = 'background-color: ' . esc_attr( $settings['styleSectionBgColor'] );
if ( ! empty( $settings['styleSectionBgGradient'] ) ) { $_sec[] = 'background: ' . esc_attr( $settings['styleSectionBgGradient'] ); $_sec[] = 'background-color: transparent'; }
$_sec = array_merge( $_sec, $_dim( $settings['styleSectionPadding'] ?? null, 'padding' ), $_border( $settings['sectionBorderType'] ?? null, $settings['sectionBorderWidth'] ?? null, $settings['sectionBorderColor'] ?? null ), $_radius( $settings['styleSectionBorderRadius'] ?? null ) );
$_sw = $_shadow( $settings['styleSectionShadow'] ?? null ); if ( $_sw ) $_sec[] = $_sw;
if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-pricing { ' . implode( '; ', $_sec ) . '; }';
if ( ! empty( $settings['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-pricing__inner { max-width: ' . esc_attr( $settings['styleContainerMaxWidth'] ) . '; }';

// Headline
$_hl = array_merge( $_typo( $settings['styleHeadlineTypography'] ?? null ), $_dim( $settings['styleHeadlineMargin'] ?? null, 'margin' ) );
if ( ! empty( $settings['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $settings['styleHeadlineColor'] );
$_rule( ' .htm25-pricing__headline', $_hl );
if ( ! empty( $settings['styleHeadlineHighlightColor'] )   ) $_css[] = $sc . ' .htm25-pricing__headline-accent { background-color: ' . esc_attr( $settings['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
if ( ! empty( $settings['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-pricing__headline-accent { background: ' . esc_attr( $settings['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

// Description
$_desc = $_typo( $settings['styleDescTypography'] ?? null );
if ( ! empty( $settings['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $settings['styleDescColor'] );
$_rule( ' .htm25-pricing__description', $_desc );

// Billing Toggle
if ( ! empty( $settings['styleToggleBgColor'] )       ) $_css[] = $sc . ' .htm25-pricing__toggle-track { background: ' . esc_attr( $settings['styleToggleBgColor'] ) . '; }';
if ( ! empty( $settings['styleToggleActiveBgColor'] ) ) { $_tac = esc_attr( $settings['styleToggleActiveBgColor'] ); $_css[] = "$sc .htm25-pricing__toggle-cb:checked + .htm25-pricing__toggle-track { background: $_tac; border-color: $_tac; }"; }
if ( ! empty( $settings['styleToggleTextColor'] )     ) $_css[] = $sc . ' .htm25-pricing__toggle-label { color: ' . esc_attr( $settings['styleToggleTextColor'] ) . '; }';

// Plan Cards
$_card = array_merge( $_border( $settings['cardBorderType'] ?? null, $settings['cardBorderWidth'] ?? null, $settings['cardBorderColor'] ?? null ), $_radius( $settings['styleCardBorderRadius'] ?? null ) );
if ( ! empty( $settings['styleCardBgColor'] ) ) $_card[] = 'background-color: ' . esc_attr( $settings['styleCardBgColor'] );
$_csw = $_shadow( $settings['styleCardShadow'] ?? null ); if ( $_csw ) $_card[] = $_csw;
$_rule( ' .htm25-pricing__card', $_card );
if ( ! empty( $settings['styleFeaturedCardAccentColor'] )    ) { $_fac = esc_attr( $settings['styleFeaturedCardAccentColor'] ); $_css[] = "$sc .htm25-pricing__card--featured { border-color: $_fac; box-shadow: 0 0 0 2px $_fac, var(--htm25-shadow-card-hover); }"; }
if ( ! empty( $settings['styleFeaturedCardHeaderBgColor'] )  ) $_css[] = $sc . ' .htm25-pricing__card--featured .htm25-pricing__card-head { background-color: ' . esc_attr( $settings['styleFeaturedCardHeaderBgColor'] ) . '; }';

// Popular Badge
$_badge = array_merge( $_typo( $settings['styleBadgeTypography'] ?? null ), $_radius( $settings['styleBadgeBorderRadius'] ?? null ) );
if ( ! empty( $settings['styleBadgeTextColor']  ) ) $_badge[] = 'color: '            . esc_attr( $settings['styleBadgeTextColor'] );
if ( ! empty( $settings['styleBadgeBgColor']    ) ) { $_badge[] = 'background-color: ' . esc_attr( $settings['styleBadgeBgColor'] ); $_badge[] = 'background-image: none'; }
if ( ! empty( $settings['styleBadgeBgGradient'] ) ) { $_badge[] = 'background: '       . esc_attr( $settings['styleBadgeBgGradient'] ); $_badge[] = 'background-color: transparent'; }
$_rule( ' .htm25-pricing__card-badge', $_badge );

// Plan Name
$_pn = $_typo( $settings['stylePlanNameTypography'] ?? null );
if ( ! empty( $settings['stylePlanNameColor'] ) ) $_pn[] = 'color: ' . esc_attr( $settings['stylePlanNameColor'] );
$_rule( ' .htm25-pricing__card-name', $_pn );

// Price
$_pr = $_typo( $settings['stylePriceTypography'] ?? null );
if ( ! empty( $settings['stylePriceColor'] ) ) $_pr[] = 'color: ' . esc_attr( $settings['stylePriceColor'] );
if ( ! empty( $_pr ) ) $_css[] = "$sc .htm25-pricing__card-amount--monthly, $sc .htm25-pricing__card-amount--annual { " . implode( '; ', $_pr ) . '; }';
if ( ! empty( $settings['stylePriceGradient'] ) ) $_css[] = "$sc .htm25-pricing__card-amount--monthly, $sc .htm25-pricing__card-amount--annual { background: " . esc_attr( $settings['stylePriceGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }';

// Features list
$_fi = $_typo( $settings['styleFeatureItemTypography'] ?? null );
if ( ! empty( $settings['styleFeatureItemColor'] ) ) $_fi[] = 'color: ' . esc_attr( $settings['styleFeatureItemColor'] );
$_rule( ' .htm25-pricing__card-feature', $_fi );
if ( ! empty( $settings['styleFeatureCheckColor'] )   ) { $_fc = esc_attr( $settings['styleFeatureCheckColor'] ); $_css[] = "$sc .htm25-pricing__card-feature-check { color: $_fc; }"; $_css[] = "$sc .htm25-pricing__card-feature-check svg { color: $_fc; }"; $_css[] = "$sc .htm25-pricing__card-feature-check svg path { fill: $_fc; }"; }
if ( ! empty( $settings['styleFeatureCheckBgColor'] ) ) $_css[] = "$sc .htm25-pricing__card-feature-check { background-color: " . esc_attr( $settings['styleFeatureCheckBgColor'] ) . "; }";

// CTA Button — normal
$_cta = $_typo( $settings['styleCtaTypography'] ?? null );
if ( ! empty( $settings['styleCtaBgColor'] )    ) { $_cta[] = 'background-color: ' . esc_attr( $settings['styleCtaBgColor'] ); $_cta[] = 'background-image: none'; }
if ( ! empty( $settings['styleCtaBgGradient'] ) ) { $_cta[] = 'background: ' . esc_attr( $settings['styleCtaBgGradient'] ); $_cta[] = 'background-color: transparent'; }
if ( ! empty( $settings['styleCtaTextColor'] )  ) $_cta[] = 'color: ' . esc_attr( $settings['styleCtaTextColor'] );
$_cta = array_merge( $_cta, $_border( $settings['ctaBorderType'] ?? null, $settings['ctaBorderWidth'] ?? null, $settings['ctaBorderColor'] ?? null ), $_radius( $settings['styleCtaBorderRadius'] ?? null ) );
$_ctasw = $_shadow( $settings['styleCtaShadow'] ?? null ); if ( $_ctasw ) $_cta[] = $_ctasw;
$_rule( ' .htm25-pricing__card-cta', $_cta );

// CTA Button — hover
$_ctah = [];
if ( ! empty( $settings['styleCtaHoverBgGradient'] ) ) $_ctah[] = 'background: ' . esc_attr( $settings['styleCtaHoverBgGradient'] );
elseif ( ! empty( $settings['styleCtaHoverBgColor'] ) ) $_ctah[] = 'background: ' . esc_attr( $settings['styleCtaHoverBgColor'] );
if ( ! empty( $settings['styleCtaHoverTextColor'] ) ) $_ctah[] = 'color: ' . esc_attr( $settings['styleCtaHoverTextColor'] );
$_ctah = array_merge( $_ctah, $_border( $settings['ctaHoverBorderType'] ?? null, $settings['ctaHoverBorderWidth'] ?? null, $settings['ctaHoverBorderColor'] ?? null ) );
$_rule( ' .htm25-pricing__card-cta:hover', $_ctah );

// ── Google Fonts: collect @import rules and prepend ──
$_gf_sys = '/^(sans-serif|serif|serif-alt|monospace)$/i';
$_gf_imp = [];
foreach ( $settings as $_gf_v ) {
    if ( ! is_array( $_gf_v ) || empty( $_gf_v['family'] ) ) continue;
    if ( preg_match( $_gf_sys, $_gf_v['family'] ) ) continue;
    $_gf_e = rawurlencode( $_gf_v['family'] );
    $_gf_imp[ $_gf_v['family'] ] = "@import url('https://fonts.googleapis.com/css?family={$_gf_e}:400,400italic,600,600italic,700,700italic&display=swap');";
}
if ( $_gf_imp ) array_unshift( $_css, implode( ' ', $_gf_imp ) );
$_css_out = implode( "\n", $_css );

// ── Card renderer closure (prevents "Cannot redeclare" on multi-block pages) ──

$render_plan_card = function( array $item ) {
    $name        = isset( $item['name'] )          ? $item['name']          : '';
    $is_featured = ! empty( $item['isFeatured'] );
    $badge       = $is_featured && ! empty( $item['featuredBadge'] ) ? $item['featuredBadge'] : '';
    $icon_class  = isset( $item['icon'] )          ? $item['icon']          : '';
    $currency    = isset( $item['currency'] )      ? $item['currency']      : '$';
    $monthly     = isset( $item['priceMonthly'] )  ? $item['priceMonthly']  : '0';
    $annual      = isset( $item['priceAnnual'] )   ? $item['priceAnnual']   : '0';
    $period      = isset( $item['period'] )        ? $item['period']        : '/month';
    $tagline     = isset( $item['tagline'] )       ? $item['tagline']       : '';
    $features_raw= isset( $item['features'] )      ? $item['features']      : '';
    $cta_text    = isset( $item['ctaText'] )       ? $item['ctaText']       : '';
    $cta_url     = isset( $item['ctaUrl'] )        ? $item['ctaUrl']        : '#';
    $cta_target  = ! empty( $item['ctaTarget'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
    $cta_variant = isset( $item['ctaVariant'] )    ? $item['ctaVariant']    : 'outline';

    $features    = array_filter( array_map( 'trim', explode( "\n", $features_raw ) ) );
    $card_class  = 'htm25-pricing__card' . ( $is_featured ? ' htm25-pricing__card--featured' : '' );
    ?>
    <div class="<?php echo esc_attr( $card_class ); ?>" role="listitem">

        <?php if ( $badge ) : ?>
        <div class="htm25-pricing__card-badge"><?php echo esc_html( $badge ); ?></div>
        <?php endif; ?>

        <div class="htm25-pricing__card-head">

            <?php if ( $icon_class ) : ?>
            <div class="htm25-pricing__card-icon-wrap" aria-hidden="true">
                <span class="htm25-pricing__card-icon">
                    <i class="<?php echo esc_attr( $icon_class ); ?>" aria-hidden="true"></i>
                </span>
            </div>
            <?php endif; ?>

            <?php if ( $name ) : ?>
            <h3 class="htm25-pricing__card-name"><?php echo esc_html( $name ); ?></h3>
            <?php endif; ?>

            <div class="htm25-pricing__card-price-wrap">
                <span class="htm25-pricing__card-currency"><?php echo esc_html( $currency ); ?></span>
                <span class="htm25-pricing__card-amount htm25-pricing__card-amount--monthly"><?php echo esc_html( $monthly ); ?></span>
                <span class="htm25-pricing__card-amount htm25-pricing__card-amount--annual"><?php echo esc_html( $annual ); ?></span>
                <span class="htm25-pricing__card-period"><?php echo esc_html( $period ); ?></span>
            </div>

            <?php if ( $tagline ) : ?>
            <p class="htm25-pricing__card-tagline"><?php echo wp_kses_post( $tagline ); ?></p>
            <?php endif; ?>

        </div><!-- /.htm25-pricing__card-head -->

        <?php if ( $features ) : ?>
        <hr class="htm25-pricing__card-divider" aria-hidden="true">

        <ul class="htm25-pricing__card-features" role="list" aria-label="<?php esc_attr_e( 'Plan features', 'ht-mega-for-elementor' ); ?>">
            <?php foreach ( $features as $feature ) : ?>
            <li class="htm25-pricing__card-feature">
                <span class="htm25-pricing__card-feature-check" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" width="14" height="14" aria-hidden="true"><path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                </span>
                <span><?php echo esc_html( $feature ); ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <?php if ( $cta_text ) : ?>
        <div class="htm25-pricing__card-cta-wrap">
            <a
                href="<?php echo esc_url( $cta_url ); ?>"
                class="htm25-btn htm25-btn--<?php echo esc_attr( $cta_variant ); ?> htm25-pricing__card-cta"
                <?php echo $cta_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- constrained to a hardcoded literal target/rel attribute string, not user input. ?>
            >
                <?php echo esc_html( $cta_text ); ?>
            </a>
        </div>
        <?php endif; ?>

    </div><!-- /.htm25-pricing__card -->
    <?php
};

?>
<?php if ( $_css_out ) : ?><style><?php echo $_css_out; // phpcs:ignore WordPress.Security.EscapeOutput ?></style><?php endif; ?>
<div class="htmega-block-<?php echo esc_attr( $block_id ); ?>">
<section
    id="htm25-pricing-<?php echo esc_attr( $uid ); ?>"
    class="htm25-pricing htm25-style--<?php echo $style; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $style sanitize_html_class()'d above */ ?> htm25-pricing--<?php echo $layout; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $layout sanitize_html_class()'d above */ ?>"
    aria-label="<?php esc_attr_e( 'Pricing section', 'ht-mega-for-elementor' ); ?>"
>
    <?php if ( $style === 'aurora' || $style === 'glass' ) : ?>
    <div class="htm25-pricing__bg-blobs" aria-hidden="true">
        <div class="htm25-pricing__blob htm25-pricing__blob--1"></div>
        <div class="htm25-pricing__blob htm25-pricing__blob--2"></div>
    </div>
    <?php endif; ?>

    <?php if ( $style === 'neo' ) : ?>
    <div class="htm25-pricing__neo-grid" aria-hidden="true"></div>
    <?php endif; ?>

    <div class="htm25-pricing__inner">

        <?php if ( $show_label || $headline || $description ) : ?>
        <div class="htm25-pricing__header">

            <?php if ( $show_label && $label_text ) : ?>
            <p class="htm25-pricing__section-label htm25-section-label">
                <?php echo esc_html( $label_text ); ?>
            </p>
            <?php endif; ?>

            <?php if ( $headline ) : ?>
            <<?php echo $headline_tag; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $headline_tag whitelisted to h1/h2/h3 above */ ?> class="htm25-pricing__headline"><?php echo $headline; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- esc_html()'d + esc_html()'d highlight span applied above ?></<?php echo $headline_tag; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $headline_tag whitelisted to h1/h2/h3 above */ ?>>
            <?php endif; ?>

            <?php if ( $description ) : ?>
            <p class="htm25-pricing__description"><?php echo wp_kses_post( $description ); ?></p>
            <?php endif; ?>

        </div>
        <?php endif; ?>

        <?php if ( $show_toggle ) : ?>
        <div class="htm25-pricing__toggle-wrap" role="group" aria-label="<?php esc_attr_e( 'Billing period', 'ht-mega-for-elementor' ); ?>">
            <span class="htm25-pricing__toggle-label htm25-pricing__toggle-label--monthly" id="<?php echo esc_attr( $toggle_id ); ?>-monthly">
                <?php echo esc_html( $label_monthly ); ?>
            </span>

            <label class="htm25-pricing__toggle" for="<?php echo esc_attr( $toggle_id ); ?>">
                <input
                    type="checkbox"
                    id="<?php echo esc_attr( $toggle_id ); ?>"
                    class="htm25-pricing__toggle-cb"
                    role="switch"
                    aria-checked="false"
                    aria-labelledby="<?php echo esc_attr( $toggle_id ); ?>-monthly <?php echo esc_attr( $toggle_id ); ?>-annual"
                >
                <span class="htm25-pricing__toggle-track" aria-hidden="true">
                    <span class="htm25-pricing__toggle-thumb"></span>
                </span>
            </label>

            <span class="htm25-pricing__toggle-label htm25-pricing__toggle-label--annual" id="<?php echo esc_attr( $toggle_id ); ?>-annual">
                <?php echo esc_html( $label_annual ); ?>
                <?php if ( $save_badge ) : ?>
                <span class="htm25-pricing__save-badge"><?php echo esc_html( $save_badge ); ?></span>
                <?php endif; ?>
            </span>
        </div>
        <?php endif; ?>

        <?php if ( $plan_items ) : ?>
        <div class="htm25-pricing__cards htm25-pricing__cards--cols-<?php echo (int) $cols; ?>" role="list">
            <?php foreach ( $plan_items as $item ) :
                $render_plan_card( (array) $item );
            endforeach; ?>
        </div>
        <?php endif; ?>

    </div><!-- /.htm25-pricing__inner -->

</section>
</div><!-- /.htmega-block-scope -->

<?php if ( $show_toggle ) : ?>
<script>
( function () {
    var wrap = document.getElementById( 'htm25-pricing-<?php echo esc_js( $uid ); ?>' );
    var cb   = wrap && wrap.querySelector( '.htm25-pricing__toggle-cb' );
    if ( ! cb ) return;
    cb.addEventListener( 'change', function () {
        wrap.classList.toggle( 'htm25-pricing--annual', this.checked );
        this.setAttribute( 'aria-checked', this.checked ? 'true' : 'false' );
    } );
} )();
</script>
<?php endif; ?>
