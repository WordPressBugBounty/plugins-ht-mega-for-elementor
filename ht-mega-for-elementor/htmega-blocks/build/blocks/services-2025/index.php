<?php
/**
 * HT Mega 2026 — Services Block (FSE / Gutenberg)
 * Block name: htmega/services-2025
 *
 * Server-side renderer. Shares the same BEM HTML structure as
 * the Elementor widget (htmega_2025_services.php) and the same CSS
 * (htm25-tokens.css + assets/css/widgets/htm25-services.css).
 *
 * PHP variables available from Blocks_init::prepare_block_data():
 *   $settings (array)  — block attributes
 *   $content  (string) — inner block content (not used — server render)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ── Attribute helpers ────────────────────────────────────────────

$style  = isset( $settings['designStyle'] ) ? sanitize_html_class( $settings['designStyle'] ) : 'bento';
$layout = isset( $settings['layout'] )      ? sanitize_html_class( $settings['layout'] )      : 'grid';
$cols   = isset( $settings['serviceColumns'] ) ? (int) $settings['serviceColumns'] : 3;
$cols   = in_array( $cols, [ 2, 3, 4 ], true ) ? $cols : 3;

// Section label
$show_label = isset( $settings['showSectionLabel'] ) ? (bool) $settings['showSectionLabel'] : true;
$label_text = isset( $settings['sectionLabelText'] ) ? $settings['sectionLabelText'] : 'What We Offer';

// Headline
$headline  = isset( $settings['headline'] ) ? $settings['headline'] : "Services built for\nmodern teams.";
$headline  = esc_html( $headline );
$highlight = isset( $settings['headlineHighlight'] ) ? trim( $settings['headlineHighlight'] ) : '';
if ( $highlight ) {
    $headline = str_replace(
        esc_html( $highlight ),
        '<span class="htm25-services__headline-accent">' . esc_html( $highlight ) . '</span>',
        $headline
    );
}
$headline_tag = isset( $settings['headlineTag'] ) && in_array( $settings['headlineTag'], [ 'h1', 'h2', 'h3' ] )
    ? $settings['headlineTag'] : 'h2';

// Description
$description = isset( $settings['description'] ) ? $settings['description'] : '';

// Service items
$service_items = isset( $settings['serviceItems'] ) && is_array( $settings['serviceItems'] )
    ? $settings['serviceItems'] : [];

// CTA
$show_cta   = isset( $settings['showCta'] )   ? (bool) $settings['showCta']   : false;
$cta_text   = isset( $settings['ctaText'] )   ? $settings['ctaText']           : 'View All Services';
$cta_url    = isset( $settings['ctaUrl'] )    ? $settings['ctaUrl']            : '#';
$cta_target = ! empty( $settings['ctaTarget'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
$cta_icon   = isset( $settings['ctaIcon'] )   ? $settings['ctaIcon']           : '';

// Unique wrapper ID
$block_id = isset( $settings['blockUniqId'] ) ? sanitize_html_class( $settings['blockUniqId'] ) : uniqid( 'htm25-services-' );

// Use a closure for the card renderer to avoid "Cannot redeclare" fatal
// if two Services blocks appear on the same page.
$render_card = function( array $item, string $layout ) {
    $icon        = isset( $item['icon'] )        ? $item['icon']        : '';
    $title       = isset( $item['title'] )       ? $item['title']       : '';
    $description = isset( $item['description'] ) ? $item['description'] : '';
    $show_link   = ! empty( $item['showLink'] );
    $link_text   = isset( $item['linkText'] )    ? $item['linkText']    : 'Learn more';
    $link_url    = isset( $item['linkUrl'] )     ? $item['linkUrl']     : '#';
    ?>
    <li class="htm25-services__card htm25-card">

        <?php if ( $icon ) : ?>
        <div class="htm25-services__card-icon-wrap" aria-hidden="true">
            <span class="htm25-services__card-icon">
                <i class="<?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>
            </span>
        </div>
        <?php endif; ?>

        <div class="htm25-services__card-body">

            <?php if ( $title ) : ?>
            <h3 class="htm25-services__card-title"><?php echo esc_html( $title ); ?></h3>
            <?php endif; ?>

            <?php if ( $description ) : ?>
            <p class="htm25-services__card-description"><?php echo wp_kses_post( $description ); ?></p>
            <?php endif; ?>

            <?php if ( $show_link && $link_text ) : ?>
            <a href="<?php echo esc_url( $link_url ); ?>" class="htm25-services__card-link">
                <?php echo esc_html( $link_text ); ?>
                <span class="htm25-services__card-link-arrow" aria-hidden="true">→</span>
            </a>
            <?php endif; ?>

        </div><!-- /.htm25-services__card-body -->

    </li>
    <?php
};

// ── Dynamic CSS (mirrors buildServicesCss in edit.js) ───────────
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
if ( ! empty( $settings['styleAccentColor'] )       ) $_sec[] = '--htm25-accent-primary: '   . esc_attr( $settings['styleAccentColor'] );
if ( ! empty( $settings['styleSectionBgColor'] )    ) $_sec[] = 'background-color: '         . esc_attr( $settings['styleSectionBgColor'] );
if ( ! empty( $settings['styleSectionBgGradient'] ) ) { $_sec[] = 'background: ' . esc_attr( $settings['styleSectionBgGradient'] ); $_sec[] = 'background-color: transparent'; }
$_sec = array_merge( $_sec, $_dim( $settings['styleSectionPadding'] ?? null, 'padding' ), $_border( $settings['sectionBorderType'] ?? null, $settings['sectionBorderWidth'] ?? null, $settings['sectionBorderColor'] ?? null ), $_radius( $settings['styleSectionBorderRadius'] ?? null ) );
$_sw = $_shadow( $settings['styleSectionShadow'] ?? null ); if ( $_sw ) $_sec[] = $_sw;
if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-services { ' . implode( '; ', $_sec ) . '; }';
if ( ! empty( $settings['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-services__inner { max-width: ' . esc_attr( $settings['styleContainerMaxWidth'] ) . '; }';

// Headline
$_hl = array_merge( $_typo( $settings['styleHeadlineTypography'] ?? null ), $_dim( $settings['styleHeadlineMargin'] ?? null, 'margin' ) );
if ( ! empty( $settings['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $settings['styleHeadlineColor'] );
$_rule( ' .htm25-services__headline', $_hl );
if ( ! empty( $settings['styleHeadlineHighlightColor'] )    ) $_css[] = $sc . ' .htm25-services .htm25-services__headline-accent { background-color: ' . esc_attr( $settings['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
if ( ! empty( $settings['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-services .htm25-services__headline-accent { background: ' . esc_attr( $settings['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

// Description
$_desc = $_typo( $settings['styleDescTypography'] ?? null );
if ( ! empty( $settings['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $settings['styleDescColor'] );
$_rule( ' .htm25-services__description', $_desc );

// Service Cards — normal
$_card = array_merge( $_border( $settings['cardBorderType'] ?? null, $settings['cardBorderWidth'] ?? null, $settings['cardBorderColor'] ?? null ), $_radius( $settings['styleCardBorderRadius'] ?? null ) );
if ( ! empty( $settings['styleCardBgColor'] ) ) $_card[] = 'background-color: ' . esc_attr( $settings['styleCardBgColor'] );
$_csw = $_shadow( $settings['styleCardShadow'] ?? null ); if ( $_csw ) $_card[] = $_csw;
$_rule( ' .htm25-services__card', $_card );

// Service Cards — hover
if ( ! empty( $settings['styleCardHoverBgColor'] ) ) $_css[] = $sc . ' .htm25-services__card:hover { background-color: ' . esc_attr( $settings['styleCardHoverBgColor'] ) . '; }';

// Card Icon
if ( ! empty( $settings['styleIconColor'] ) ) { $_ic = esc_attr( $settings['styleIconColor'] ); $_css[] = "$sc .htm25-services .htm25-services__card-icon i { color: $_ic; }"; $_css[] = "$sc .htm25-services .htm25-services__card-icon svg { color: $_ic; }"; $_css[] = "$sc .htm25-services .htm25-services__card-icon svg path { fill: $_ic; }"; }
if ( ! empty( $settings['styleIconSize'] )  ) { $_sz = esc_attr( $settings['styleIconSize'] );  $_css[] = "$sc .htm25-services .htm25-services__card-icon i { font-size: {$_sz}px; }"; $_css[] = "$sc .htm25-services .htm25-services__card-icon svg { width: {$_sz}px; height: {$_sz}px; }"; }

// Card Title
$_ct = $_typo( $settings['styleCardTitleTypography'] ?? null ); if ( ! empty( $settings['styleCardTitleColor'] ) ) $_ct[] = 'color: ' . esc_attr( $settings['styleCardTitleColor'] ); $_rule( ' .htm25-services__card-title', $_ct );

// Card Description
$_cd = $_typo( $settings['styleCardDescTypography'] ?? null ); if ( ! empty( $settings['styleCardDescColor'] ) ) $_cd[] = 'color: ' . esc_attr( $settings['styleCardDescColor'] ); $_rule( ' .htm25-services__card-description', $_cd );

// CTA Button — normal
$_cta = $_typo( $settings['styleCtaTypography'] ?? null );
if ( ! empty( $settings['styleCtaBgColor'] )    ) { $_cta[] = 'background-color: ' . esc_attr( $settings['styleCtaBgColor'] ); $_cta[] = 'background-image: none'; }
if ( ! empty( $settings['styleCtaBgGradient'] ) ) { $_cta[] = 'background: ' . esc_attr( $settings['styleCtaBgGradient'] ); $_cta[] = 'background-color: transparent'; }
if ( ! empty( $settings['styleCtaTextColor'] )  ) $_cta[] = 'color: ' . esc_attr( $settings['styleCtaTextColor'] );
$_cta = array_merge( $_cta, $_border( $settings['ctaBorderType'] ?? null, $settings['ctaBorderWidth'] ?? null, $settings['ctaBorderColor'] ?? null ), $_radius( $settings['styleCtaBorderRadius'] ?? null ) );
$_ctasw = $_shadow( $settings['styleCtaShadow'] ?? null ); if ( $_ctasw ) $_cta[] = $_ctasw;
$_rule( ' .htm25-services__cta', $_cta );

// CTA Button — hover
$_ctah = [];
if ( ! empty( $settings['styleCtaHoverBgGradient'] ) ) $_ctah[] = 'background: ' . esc_attr( $settings['styleCtaHoverBgGradient'] );
elseif ( ! empty( $settings['styleCtaHoverBgColor'] ) ) $_ctah[] = 'background: ' . esc_attr( $settings['styleCtaHoverBgColor'] );
if ( ! empty( $settings['styleCtaHoverTextColor'] ) ) $_ctah[] = 'color: ' . esc_attr( $settings['styleCtaHoverTextColor'] );
$_ctah = array_merge( $_ctah, $_border( $settings['ctaHoverBorderType'] ?? null, $settings['ctaHoverBorderWidth'] ?? null, $settings['ctaHoverBorderColor'] ?? null ) );
$_rule( ' .htm25-services__cta:hover', $_ctah );

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

// ── Render ───────────────────────────────────────────────────
?>
<?php if ( $_css_out ) : ?><style><?php echo $_css_out; // phpcs:ignore WordPress.Security.EscapeOutput ?></style><?php endif; ?>
<div class="htmega-block-<?php echo esc_attr( $block_id ); ?>">
<section
    class="htm25-services htm25-style--<?php echo esc_attr( $style ); ?> htm25-services--<?php echo esc_attr( $layout ); ?>"
    aria-label="<?php esc_attr_e( 'Services section', 'ht-mega-for-elementor' ); ?>"
>
    <?php if ( $style === 'aurora' || $style === 'glass' ) : ?>
    <div class="htm25-services__bg-blobs" aria-hidden="true">
        <div class="htm25-services__blob htm25-services__blob--1"></div>
        <div class="htm25-services__blob htm25-services__blob--2"></div>
    </div>
    <?php endif; ?>

    <?php if ( $style === 'neo' ) : ?>
    <div class="htm25-services__neo-grid" aria-hidden="true"></div>
    <?php endif; ?>

    <div class="htm25-services__inner">

        <?php if ( $show_label || $headline || $description ) : ?>
        <div class="htm25-services__header">

            <?php if ( $show_label && $label_text ) : ?>
            <p class="htm25-services__section-label htm25-section-label">
                <?php echo esc_html( $label_text ); ?>
            </p>
            <?php endif; ?>

            <?php if ( $headline ) : ?>
            <<?php echo esc_html( $headline_tag ); ?> class="htm25-services__headline"><?php echo wp_kses_post( $headline ); // nl2br + esc_html + safe accent span ?></<?php echo esc_html( $headline_tag ); ?>>
            <?php endif; ?>

            <?php if ( $description ) : ?>
            <p class="htm25-services__description">
                <?php echo wp_kses_post( $description ); ?>
            </p>
            <?php endif; ?>

        </div><!-- /.htm25-services__header -->
        <?php endif; ?>

        <?php if ( $service_items ) : ?>
        <ul
            class="htm25-services__cards htm25-services__cards--cols-<?php echo esc_attr( $cols ); ?>"
            role="list"
            aria-label="<?php esc_attr_e( 'Service list', 'ht-mega-for-elementor' ); ?>"
        >
            <?php foreach ( $service_items as $item ) :
                $render_card( (array) $item, $layout );
            endforeach; ?>
        </ul>
        <?php endif; ?>

        <?php if ( $show_cta && $cta_text ) : ?>
        <div class="htm25-services__cta-wrap">
            <a
                href="<?php echo esc_url( $cta_url ); ?>"
                class="htm25-btn htm25-btn--primary htm25-services__cta"
                <?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $cta_target is a hardcoded ' target="_blank" rel="noopener noreferrer"' string or empty, not user-controlled text. ?>
                <?php echo $cta_target; ?>
            >
                <?php echo esc_html( $cta_text ); ?>
                <?php if ( $cta_icon ) : ?>
                <span class="htm25-services__cta-icon" aria-hidden="true">
                    <i class="<?php echo esc_attr( $cta_icon ); ?>" aria-hidden="true"></i>
                </span>
                <?php endif; ?>
            </a>
        </div>
        <?php endif; ?>

    </div><!-- /.htm25-services__inner -->

</section>
</div><!-- /.htmega-block-scope -->
