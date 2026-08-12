<?php
/**
 * HT Mega 2026 — About / Feature Block (FSE / Gutenberg)
 * Block name: htmega/about-2025
 *
 * Server-side renderer. Shares the same BEM HTML structure as
 * the Elementor widget (htmega_2025_about.php) and the same CSS
 * (htm25-tokens.css + assets/css/widgets/htm25-about.css).
 *
 * PHP variables available from Blocks_init::prepare_block_data():
 *   $settings (array)  — block attributes
 *   $content  (string) — inner block content (not used — server render)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ── Attribute helpers ────────────────────────────────────────

$style   = isset( $settings['designStyle'] ) ? sanitize_html_class( $settings['designStyle'] ) : 'bento';
$layout  = isset( $settings['layout'] )      ? sanitize_html_class( $settings['layout'] )      : 'split-left';
$cols    = isset( $settings['featureColumns'] ) ? (int) $settings['featureColumns'] : 2;
$cols    = in_array( $cols, [ 1, 2, 3 ], true ) ? $cols : 2;

$is_split = in_array( $layout, [ 'split-left', 'split-right' ], true );

// Unique wrapper ID
$block_id = isset( $settings['blockUniqId'] ) ? sanitize_html_class( $settings['blockUniqId'] ) : uniqid( 'htm25-about-' );

// Section label
$show_label = isset( $settings['showSectionLabel'] ) ? (bool) $settings['showSectionLabel'] : true;
$label_text = isset( $settings['sectionLabelText'] ) ? $settings['sectionLabelText'] : 'Why Choose Us';

// Headline
$headline  = isset( $settings['headline'] ) ? $settings['headline'] : "Everything you need to\nbuild something great.";
$headline  = esc_html( $headline );
$highlight = isset( $settings['headlineHighlight'] ) ? trim( $settings['headlineHighlight'] ) : '';
if ( $highlight ) {
    $headline = str_replace(
        esc_html( $highlight ),
        '<span class="htm25-about__headline-accent">' . esc_html( $highlight ) . '</span>',
        $headline
    );
}
$headline_tag = isset( $settings['headlineTag'] ) && in_array( $settings['headlineTag'], [ 'h1', 'h2', 'h3' ] )
    ? $settings['headlineTag'] : 'h2';

// Description
$description = isset( $settings['description'] ) ? $settings['description'] : '';

// Feature items
$feature_items = isset( $settings['featureItems'] ) && is_array( $settings['featureItems'] )
    ? $settings['featureItems'] : [];

// Media (split layouts)
$image_html       = '';
$show_float_badge = isset( $settings['showFloatingBadge'] ) ? (bool) $settings['showFloatingBadge'] : true;
$float_number     = isset( $settings['floatingStatNumber'] ) ? $settings['floatingStatNumber'] : '';
$float_label      = isset( $settings['floatingStatLabel'] )  ? $settings['floatingStatLabel']  : '';

if ( $is_split ) {
    $image_id   = isset( $settings['aboutImageId'] )  ? (int) $settings['aboutImageId']  : 0;
    $image_url  = isset( $settings['aboutImageUrl'] ) ? $settings['aboutImageUrl'] : '';
    $image_size = isset( $settings['aboutImageSize'] ) ? $settings['aboutImageSize'] : 'large';

    if ( $image_id ) {
        $image_html = wp_get_attachment_image( $image_id, $image_size, false, [
            'loading' => 'lazy',
            'class'   => 'htm25-about__img',
        ] );
    } elseif ( $image_url ) {
        $image_html = '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( isset( $settings['aboutImageAlt'] ) ? $settings['aboutImageAlt'] : '' ) . '" class="htm25-about__img" loading="lazy">';
    }
}

// CTA
$show_cta  = isset( $settings['showCta'] ) ? (bool) $settings['showCta'] : true;
$cta_text  = isset( $settings['ctaText'] ) ? $settings['ctaText'] : 'Explore Features';
$cta_url   = isset( $settings['ctaUrl'] )  ? $settings['ctaUrl']  : '#';
$cta_target = ! empty( $settings['ctaTarget'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
$cta_icon   = isset( $settings['ctaIcon'] ) ? $settings['ctaIcon'] : '';

// ── Helper: media column ─────────────────────────────────────
// Use a closure so re-rendering multiple blocks on the same page
// never triggers a "Cannot redeclare function" fatal error.

$htm25_about_media_column = function( string $img_html, bool $show_float, string $float_num, string $float_lbl ) : string {
    ob_start();
    ?>
    <div class="htm25-about__media">
        <?php if ( $img_html ) : ?>
            <?php echo $img_html; // phpcs:ignore WordPress.Security.EscapeOutput ?>
        <?php else : ?>
            <div class="htm25-about__img-placeholder" aria-hidden="true">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M23 19C23 19.5304 22.7893 20.0391 22.4142 20.4142C22.0391 20.7893 21.5304 21 21 21H3C2.46957 21 1.96086 20.7893 1.58579 20.4142C1.21071 20.0391 1 19.5304 1 19V8C1 7.46957 1.21071 6.96086 1.58579 6.58579C1.96086 6.21071 2.46957 6 3 6H7L9 3H15L17 6H21C21.5304 6 22.0391 6.21071 22.4142 6.58579C22.7893 6.96086 23 7.46957 23 8V19Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="13" r="4" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                <span><?php esc_html_e( 'Add an image', 'ht-mega-for-elementor' ); ?></span>
            </div>
        <?php endif; ?>
        <?php if ( $show_float && ( $float_num || $float_lbl ) ) : ?>
        <div class="htm25-about__float-badge" aria-label="<?php echo esc_attr( $float_num . ' ' . $float_lbl ); ?>">
            <span class="htm25-about__float-number"><?php echo esc_html( $float_num ); ?></span>
            <span class="htm25-about__float-label"><?php echo esc_html( $float_lbl ); ?></span>
        </div>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
};

// ── Dynamic CSS (mirrors buildAboutCss in edit.js) ───────────
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
if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-about { ' . implode( '; ', $_sec ) . '; }';
if ( ! empty( $settings['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-about__inner { max-width: ' . esc_attr( $settings['styleContainerMaxWidth'] ) . '; }';

// Headline
$_hl = array_merge( $_typo( $settings['styleHeadlineTypography'] ?? null ), $_dim( $settings['styleHeadlineMargin'] ?? null, 'margin' ) );
if ( ! empty( $settings['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $settings['styleHeadlineColor'] );
$_rule( ' .htm25-about__headline', $_hl );
if ( ! empty( $settings['styleHeadlineHighlightColor'] )   ) $_css[] = $sc . ' .htm25-about .htm25-about__headline-accent { background-color: ' . esc_attr( $settings['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
if ( ! empty( $settings['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-about .htm25-about__headline-accent { background: ' . esc_attr( $settings['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

// Description
$_desc = $_typo( $settings['styleDescTypography'] ?? null );
if ( ! empty( $settings['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $settings['styleDescColor'] );
$_rule( ' .htm25-about__description', $_desc );

// Feature cards
$_card = array_merge( $_border( $settings['cardBorderType'] ?? null, $settings['cardBorderWidth'] ?? null, $settings['cardBorderColor'] ?? null ), $_radius( $settings['styleCardBorderRadius'] ?? null ) );
if ( ! empty( $settings['styleCardBgColor'] ) ) $_card[] = 'background-color: ' . esc_attr( $settings['styleCardBgColor'] );
$_csw = $_shadow( $settings['styleCardShadow'] ?? null ); if ( $_csw ) $_card[] = $_csw;
$_rule( ' .htm25-about__feature', $_card );

// Icon
if ( ! empty( $settings['styleIconColor'] ) ) { $_ic = esc_attr( $settings['styleIconColor'] ); $_css[] = "$sc .htm25-about .htm25-about__feature-icon i { color: $_ic; }"; $_css[] = "$sc .htm25-about .htm25-about__feature-icon svg { color: $_ic; }"; $_css[] = "$sc .htm25-about .htm25-about__feature-icon svg path { fill: $_ic; }"; }
if ( ! empty( $settings['styleIconSize'] )  ) { $_sz = esc_attr( $settings['styleIconSize'] ); $_css[] = "$sc .htm25-about .htm25-about__feature-icon i { font-size: {$_sz}px; }"; $_css[] = "$sc .htm25-about .htm25-about__feature-icon svg { width: {$_sz}px; height: {$_sz}px; }"; }

// Feature title / desc
$_ft = $_typo( $settings['styleFeatureTitleTypography'] ?? null ); if ( ! empty( $settings['styleFeatureTitleColor'] ) ) $_ft[] = 'color: ' . esc_attr( $settings['styleFeatureTitleColor'] ); $_rule( ' .htm25-about__feature-title', $_ft );
$_fd = $_typo( $settings['styleFeatureDescTypography']  ?? null ); if ( ! empty( $settings['styleFeatureDescColor'] ) )  $_fd[] = 'color: ' . esc_attr( $settings['styleFeatureDescColor'] );  $_rule( ' .htm25-about__feature-description', $_fd );

// CTA normal
$_cta = $_typo( $settings['styleCtaTypography'] ?? null );
if ( ! empty( $settings['styleCtaBgColor'] )    ) { $_cta[] = 'background-color: ' . esc_attr( $settings['styleCtaBgColor'] ); $_cta[] = 'background-image: none'; }
if ( ! empty( $settings['styleCtaBgGradient'] ) ) { $_cta[] = 'background: ' . esc_attr( $settings['styleCtaBgGradient'] ); $_cta[] = 'background-color: transparent'; }
if ( ! empty( $settings['styleCtaTextColor'] )  ) $_cta[] = 'color: ' . esc_attr( $settings['styleCtaTextColor'] );
$_cta = array_merge( $_cta, $_border( $settings['ctaBorderType'] ?? null, $settings['ctaBorderWidth'] ?? null, $settings['ctaBorderColor'] ?? null ), $_radius( $settings['styleCtaBorderRadius'] ?? null ) );
$_ctasw = $_shadow( $settings['styleCtaShadow'] ?? null ); if ( $_ctasw ) $_cta[] = $_ctasw;
$_rule( ' .htm25-about__cta', $_cta );

// CTA hover
$_ctah = [];
if ( ! empty( $settings['styleCtaHoverBgGradient'] ) ) $_ctah[] = 'background: ' . esc_attr( $settings['styleCtaHoverBgGradient'] );
elseif ( ! empty( $settings['styleCtaHoverBgColor'] ) ) $_ctah[] = 'background: ' . esc_attr( $settings['styleCtaHoverBgColor'] );
if ( ! empty( $settings['styleCtaHoverTextColor'] ) ) $_ctah[] = 'color: ' . esc_attr( $settings['styleCtaHoverTextColor'] );
$_ctah = array_merge( $_ctah, $_border( $settings['ctaHoverBorderType'] ?? null, $settings['ctaHoverBorderWidth'] ?? null, $settings['ctaHoverBorderColor'] ?? null ) );
$_rule( ' .htm25-about__cta:hover', $_ctah );

// Image
$_img = array_merge( $_border( $settings['imageBorderType'] ?? null, $settings['imageBorderWidth'] ?? null, $settings['imageBorderColor'] ?? null ), $_radius( $settings['styleImageBorderRadius'] ?? null ) );
$_isw = $_shadow( $settings['styleImageShadow'] ?? null ); if ( $_isw ) $_img[] = $_isw;
$_rule( ' .htm25-about__img', $_img );

// Float badge
$_fb = $_radius( $settings['styleFloatBadgeRadius'] ?? null );
if ( ! empty( $settings['styleFloatBadgeBgColor'] ) ) $_fb[] = 'background-color: ' . esc_attr( $settings['styleFloatBadgeBgColor'] );
$_rule( ' .htm25-about__float-badge', $_fb );
$_fbn = $_typo( $settings['styleFloatBadgeNumberTypography'] ?? null ); if ( ! empty( $settings['styleFloatBadgeNumberColor'] ) ) $_fbn[] = 'color: ' . esc_attr( $settings['styleFloatBadgeNumberColor'] ); $_rule( ' .htm25-about__float-number', $_fbn );
$_fbl = $_typo( $settings['styleFloatBadgeLabelTypography']  ?? null ); if ( ! empty( $settings['styleFloatBadgeLabelColor'] ) )  $_fbl[] = 'color: ' . esc_attr( $settings['styleFloatBadgeLabelColor'] );  $_rule( ' .htm25-about__float-label', $_fbl );

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
    id="<?php echo esc_attr( $block_id ); ?>"
    class="htm25-about htm25-style--<?php echo $style; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitize_html_class()'d above */ ?> htm25-about--<?php echo $layout; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitize_html_class()'d above */ ?>"
    aria-label="<?php esc_attr_e( 'About section', 'ht-mega-for-elementor' ); ?>"
>

    <?php if ( $style === 'aurora' || $style === 'glass' ) : ?>
    <div class="htm25-about__bg-blobs" aria-hidden="true">
        <div class="htm25-about__blob htm25-about__blob--1"></div>
        <div class="htm25-about__blob htm25-about__blob--2"></div>
    </div>
    <?php endif; ?>

    <?php if ( $style === 'neo' ) : ?>
    <div class="htm25-about__neo-grid" aria-hidden="true"></div>
    <?php endif; ?>

    <div class="htm25-about__inner">

        <?php if ( $layout === 'split-right' ) :
            echo $htm25_about_media_column( $image_html, $show_float_badge, $float_number, $float_label ); // phpcs:ignore
        endif; ?>

        <div class="htm25-about__content">

            <?php if ( $show_label && $label_text ) : ?>
            <p class="htm25-about__section-label htm25-section-label">
                <?php echo esc_html( $label_text ); ?>
            </p>
            <?php endif; ?>

            <<?php echo $headline_tag; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- whitelisted to h1/h2/h3 above */ ?> class="htm25-about__headline"><?php echo $headline; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- esc_html()'d above, accent span wraps esc_html()'d text only */ ?></<?php echo $headline_tag; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- whitelisted to h1/h2/h3 above */ ?>>

            <?php if ( $description ) : ?>
            <p class="htm25-about__description">
                <?php echo wp_kses_post( $description ); ?>
            </p>
            <?php endif; ?>

            <?php if ( $feature_items ) : ?>
            <ul
                class="htm25-about__features htm25-about__features--cols-<?php echo $cols; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- (int) cast and whitelisted to [1,2,3] above */ ?>"
                role="list"
                aria-label="<?php esc_attr_e( 'Feature list', 'ht-mega-for-elementor' ); ?>"
            >
                <?php foreach ( $feature_items as $item ) : ?>
                <?php
                $f_icon  = isset( $item['icon'] )        ? $item['icon']        : '';
                $f_title = isset( $item['title'] )       ? $item['title']       : '';
                $f_desc  = isset( $item['description'] ) ? $item['description'] : '';
                ?>
                <li class="htm25-about__feature htm25-card">
                    <?php if ( $f_icon ) : ?>
                    <div class="htm25-about__feature-icon-wrap" aria-hidden="true">
                        <span class="htm25-about__feature-icon">
                            <i class="<?php echo esc_attr( $f_icon ); ?>"></i>
                        </span>
                    </div>
                    <?php endif; ?>
                    <?php if ( $f_title ) : ?>
                    <h3 class="htm25-about__feature-title"><?php echo esc_html( $f_title ); ?></h3>
                    <?php endif; ?>
                    <?php if ( $f_desc ) : ?>
                    <p class="htm25-about__feature-description"><?php echo wp_kses_post( $f_desc ); ?></p>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>

            <?php if ( $show_cta && $cta_text ) : ?>
            <div class="htm25-about__cta-wrap">
                <a
                    href="<?php echo esc_url( $cta_url ); ?>"
                    class="htm25-btn htm25-btn--primary htm25-about__cta"
                    <?php echo $cta_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- constrained to hardcoded literal ' target="_blank" rel="noopener noreferrer"' or '' ?>
                >
                    <?php echo esc_html( $cta_text ); ?>
                    <?php if ( $cta_icon ) : ?>
                    <span class="htm25-about__cta-icon" aria-hidden="true">
                        <i class="<?php echo esc_attr( $cta_icon ); ?>"></i>
                    </span>
                    <?php endif; ?>
                </a>
            </div>
            <?php endif; ?>

        </div><!-- /.htm25-about__content -->

        <?php if ( $layout === 'split-left' ) :
            echo $htm25_about_media_column( $image_html, $show_float_badge, $float_number, $float_label ); // phpcs:ignore
        endif; ?>

    </div><!-- /.htm25-about__inner -->

</section>
</div><!-- /.htmega-block-scope -->
