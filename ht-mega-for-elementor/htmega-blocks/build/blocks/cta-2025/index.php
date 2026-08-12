<?php
/**
 * HT Mega 2026 — CTA Section Block
 * Server-side renderer for htmega/cta-2025.
 *
 * @package HT_Mega
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$attributes = $settings; // render callback provides $settings

// ── Attribute extraction ──────────────────────────────────────────────────────
$design_style      = isset( $attributes['designStyle'] )      ? sanitize_html_class( $attributes['designStyle'] )    : 'bento';
$layout            = isset( $attributes['layout'] )            ? sanitize_html_class( $attributes['layout'] )         : 'centered';
$image_position    = isset( $attributes['imagePosition'] )     ? sanitize_html_class( $attributes['imagePosition'] )  : 'right';

$show_label        = ! empty( $attributes['showSectionLabel'] );
$label_text        = isset( $attributes['sectionLabelText'] )  ? esc_html( $attributes['sectionLabelText'] )           : '';
$headline          = isset( $attributes['headline'] )          ? esc_html( $attributes['headline'] )                   : '';
$headline_hl       = isset( $attributes['headlineHighlight'] ) ? esc_html( $attributes['headlineHighlight'] )           : '';
$headline_tag      = isset( $attributes['headlineTag'] )       ? tag_escape( $attributes['headlineTag'] )               : 'h2';
$description       = isset( $attributes['description'] )       ? esc_html( $attributes['description'] )                : '';

$show_primary      = ! empty( $attributes['showPrimaryCta'] );
$primary_text      = isset( $attributes['primaryCtaText'] )    ? esc_html( $attributes['primaryCtaText'] )              : '';
$primary_url       = isset( $attributes['primaryCtaUrl'] )     ? esc_url( $attributes['primaryCtaUrl'] )                : '#';
$primary_target    = ( isset( $attributes['primaryCtaTarget'] ) && $attributes['primaryCtaTarget'] === '_blank' ) ? '_blank' : '_self';
$primary_icon      = isset( $attributes['primaryCtaIcon'] )         ? sanitize_text_field( $attributes['primaryCtaIcon'] )        : '';
$show_primary_icon = ! empty( $attributes['showPrimaryCtaIcon'] );
$primary_icon_pos  = isset( $attributes['primaryCtaIconPosition'] ) ? sanitize_text_field( $attributes['primaryCtaIconPosition'] ) : 'after';

$show_secondary    = ! empty( $attributes['showSecondaryCta'] );
$secondary_text    = isset( $attributes['secondaryCtaText'] )  ? esc_html( $attributes['secondaryCtaText'] )            : '';
$secondary_url     = isset( $attributes['secondaryCtaUrl'] )   ? esc_url( $attributes['secondaryCtaUrl'] )              : '#';
$secondary_target  = ( isset( $attributes['secondaryCtaTarget'] ) && $attributes['secondaryCtaTarget'] === '_blank' ) ? '_blank' : '_self';

$image_url         = isset( $attributes['ctaImageUrl'] )       ? esc_url( $attributes['ctaImageUrl'] )                 : '';
$image_alt         = isset( $attributes['ctaImageAlt'] )       ? esc_attr( $attributes['ctaImageAlt'] )                : '';

// ── Derived flags ─────────────────────────────────────────────────────────────
$is_split      = ( $layout === 'split' );
$is_image_left = ( $is_split && $image_position === 'left' );

$section_class = implode( ' ', array_filter( [
	'htm25-cta',
	'htm25-cta--' . $layout,
	$is_image_left ? 'htm25-cta--image-left' : '',
] ) );

// ── Headline with highlight ───────────────────────────────────────────────────
$headline_html = '';
if ( $headline ) {
	if ( $headline_hl && strpos( $headline, $headline_hl ) !== false ) {
		$headline_html = str_replace(
			esc_html( $headline_hl ),
			'<span class="htm25-cta__headline-accent">' . esc_html( $headline_hl ) . '</span>',
			esc_html( $headline )
		);
	} else {
		$headline_html = esc_html( $headline );
	}
}

// ── Dynamic CSS (mirrors buildCtaCss in edit.js) ─────────────
$block_id = isset( $attributes['blockUniqId'] ) ? sanitize_html_class( $attributes['blockUniqId'] ) : uniqid( 'htm25-cta-' );
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
if ( ! empty( $attributes['styleSectionBgColor'] )    ) $_sec[] = 'background-color: ' . esc_attr( $attributes['styleSectionBgColor'] );
if ( ! empty( $attributes['styleSectionBgGradient'] ) ) { $_sec[] = 'background: ' . esc_attr( $attributes['styleSectionBgGradient'] ); $_sec[] = 'background-color: transparent'; }
$_sec = array_merge( $_sec, $_dim( $attributes['styleSectionPadding'] ?? null, 'padding' ), $_border( $attributes['sectionBorderType'] ?? null, $attributes['sectionBorderWidth'] ?? null, $attributes['sectionBorderColor'] ?? null ), $_radius( $attributes['styleSectionBorderRadius'] ?? null ) );
$_sw = $_shadow( $attributes['styleSectionShadow'] ?? null ); if ( $_sw ) $_sec[] = $_sw;
if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-cta { ' . implode( '; ', $_sec ) . '; }';
if ( ! empty( $attributes['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-cta__inner { max-width: ' . esc_attr( $attributes['styleContainerMaxWidth'] ) . '; }';

// Headline
$_hl = array_merge( $_typo( $attributes['styleHeadlineTypography'] ?? null ), $_dim( $attributes['styleHeadlineMargin'] ?? null, 'margin' ) );
if ( ! empty( $attributes['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $attributes['styleHeadlineColor'] );
$_rule( ' .htm25-cta__headline', $_hl );
if ( ! empty( $attributes['styleHeadlineHighlightColor'] )   ) $_css[] = $sc . ' .htm25-cta__headline-accent { background-color: ' . esc_attr( $attributes['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
if ( ! empty( $attributes['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-cta__headline-accent { background: ' . esc_attr( $attributes['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

// Description
$_desc = $_typo( $attributes['styleDescTypography'] ?? null );
if ( ! empty( $attributes['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $attributes['styleDescColor'] );
$_rule( ' .htm25-cta__description', $_desc );

// Section Label
$_lbl = $_typo( $attributes['styleLabelTypography'] ?? null );
if ( ! empty( $attributes['styleLabelColor'] )   ) $_lbl[] = 'color: ' . esc_attr( $attributes['styleLabelColor'] );
if ( ! empty( $attributes['styleLabelBgColor'] ) ) $_lbl[] = 'background-color: ' . esc_attr( $attributes['styleLabelBgColor'] );
$_rule( ' .htm25-cta__section-label', $_lbl );

// Primary button — normal
$_pb = $_typo( $attributes['stylePrimaryBtnTypography'] ?? null );
if ( ! empty( $attributes['stylePrimaryBtnBgColor'] )    ) { $_pb[] = 'background-color: ' . esc_attr( $attributes['stylePrimaryBtnBgColor'] ); $_pb[] = 'background-image: none'; }
if ( ! empty( $attributes['stylePrimaryBtnBgGradient'] ) ) { $_pb[] = 'background: ' . esc_attr( $attributes['stylePrimaryBtnBgGradient'] ); $_pb[] = 'background-color: transparent'; }
if ( ! empty( $attributes['stylePrimaryBtnTextColor'] )  ) $_pb[] = 'color: ' . esc_attr( $attributes['stylePrimaryBtnTextColor'] );
$_pb = array_merge( $_pb, $_border( $attributes['primaryBtnBorderType'] ?? null, $attributes['primaryBtnBorderWidth'] ?? null, $attributes['primaryBtnBorderColor'] ?? null ), $_radius( $attributes['stylePrimaryBtnBorderRadius'] ?? null ) );
$_pbsw = $_shadow( $attributes['stylePrimaryBtnShadow'] ?? null ); if ( $_pbsw ) $_pb[] = $_pbsw;
$_rule( ' .htm25-cta__btn--primary', $_pb );

// Primary button — hover
$_pbh = [];
if ( ! empty( $attributes['stylePrimaryBtnHoverBgGradient'] ) ) $_pbh[] = 'background: ' . esc_attr( $attributes['stylePrimaryBtnHoverBgGradient'] );
elseif ( ! empty( $attributes['stylePrimaryBtnHoverBgColor'] ) ) $_pbh[] = 'background: ' . esc_attr( $attributes['stylePrimaryBtnHoverBgColor'] );
if ( ! empty( $attributes['stylePrimaryBtnHoverTextColor'] ) ) $_pbh[] = 'color: ' . esc_attr( $attributes['stylePrimaryBtnHoverTextColor'] );
$_pbh = array_merge( $_pbh, $_border( $attributes['primaryBtnHoverBorderType'] ?? null, $attributes['primaryBtnHoverBorderWidth'] ?? null, $attributes['primaryBtnHoverBorderColor'] ?? null ) );
$_rule( ' .htm25-cta__btn--primary:hover', $_pbh );

// Secondary button — normal
$_sb = $_typo( $attributes['styleSecondaryBtnTypography'] ?? null );
if ( ! empty( $attributes['styleSecondaryBtnBgGradient'] ) ) $_sb[] = 'background: ' . esc_attr( $attributes['styleSecondaryBtnBgGradient'] );
elseif ( ! empty( $attributes['styleSecondaryBtnBgColor'] ) ) $_sb[] = 'background: ' . esc_attr( $attributes['styleSecondaryBtnBgColor'] );
if ( ! empty( $attributes['styleSecondaryBtnTextColor'] ) ) $_sb[] = 'color: ' . esc_attr( $attributes['styleSecondaryBtnTextColor'] );
$_sb = array_merge( $_sb, $_border( $attributes['secondaryBtnBorderType'] ?? null, $attributes['secondaryBtnBorderWidth'] ?? null, $attributes['secondaryBtnBorderColor'] ?? null ), $_radius( $attributes['styleSecondaryBtnBorderRadius'] ?? null ) );
$_rule( ' .htm25-cta__btn--secondary', $_sb );

// Secondary button — hover
$_sbh = [];
if ( ! empty( $attributes['styleSecondaryBtnHoverBgGradient'] ) ) $_sbh[] = 'background: ' . esc_attr( $attributes['styleSecondaryBtnHoverBgGradient'] );
elseif ( ! empty( $attributes['styleSecondaryBtnHoverBgColor'] ) ) $_sbh[] = 'background: ' . esc_attr( $attributes['styleSecondaryBtnHoverBgColor'] );
if ( ! empty( $attributes['styleSecondaryBtnHoverTextColor'] ) ) $_sbh[] = 'color: ' . esc_attr( $attributes['styleSecondaryBtnHoverTextColor'] );
$_sbh = array_merge( $_sbh, $_border( $attributes['secondaryBtnHoverBorderType'] ?? null, $attributes['secondaryBtnHoverBorderWidth'] ?? null, $attributes['secondaryBtnHoverBorderColor'] ?? null ) );
$_rule( ' .htm25-cta__btn--secondary:hover', $_sbh );

// Image
$_img = array_merge( $_border( $attributes['imageBorderType'] ?? null, $attributes['imageBorderWidth'] ?? null, $attributes['imageBorderColor'] ?? null ), $_radius( $attributes['styleImageBorderRadius'] ?? null ) );
$_imgsw = $_shadow( $attributes['styleImageShadow'] ?? null ); if ( $_imgsw ) $_img[] = $_imgsw;
$_rule( ' .htm25-cta__media img', $_img );

// ── Google Fonts: collect @import rules and prepend ──
$_gf_sys = '/^(sans-serif|serif|serif-alt|monospace)$/i';
$_gf_imp = [];
foreach ( $attributes as $_gf_v ) {
    if ( ! is_array( $_gf_v ) || empty( $_gf_v['family'] ) ) continue;
    if ( preg_match( $_gf_sys, $_gf_v['family'] ) ) continue;
    $_gf_e = rawurlencode( $_gf_v['family'] );
    $_gf_imp[ $_gf_v['family'] ] = "@import url('https://fonts.googleapis.com/css?family={$_gf_e}:400,400italic,600,600italic,700,700italic&display=swap');";
}
if ( $_gf_imp ) array_unshift( $_css, implode( ' ', $_gf_imp ) );
$_css_out = implode( "\n", $_css );

// ── Image / placeholder ───────────────────────────────────────────────────────
$render_image = function() use ( $image_url, $image_alt ) {
	if ( $image_url ) {
		return '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $image_alt ) . '" class="htm25-cta__image" loading="lazy" />';
	}
	return '<div class="htm25-cta__image-placeholder" aria-hidden="true">
		<svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.5"/>
			<circle cx="8.5" cy="8.5" r="1.5" stroke="currentColor" stroke-width="1.5"/>
			<path d="M21 15L16 10L9 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M14 17L11 14L7 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
		<span>Add an image</span>
	</div>';
};
?>
<?php if ( $_css_out ) : ?><style><?php echo $_css_out; // phpcs:ignore WordPress.Security.EscapeOutput ?></style><?php endif; ?>
<div class="htmega-block-<?php echo esc_attr( $block_id ); ?>">
<div class="htm25-style--<?php echo esc_attr( $design_style ); ?>">
	<section class="<?php echo esc_attr( $section_class ); ?>">

		<?php if ( in_array( $design_style, [ 'glass', 'aurora' ], true ) ) : ?>
		<div class="htm25-cta__bg-blobs" aria-hidden="true">
			<div class="htm25-cta__blob htm25-cta__blob--1"></div>
			<div class="htm25-cta__blob htm25-cta__blob--2"></div>
		</div>
		<?php endif; ?>

		<?php if ( $design_style === 'neo' ) : ?>
		<div class="htm25-cta__neo-grid" aria-hidden="true"></div>
		<?php endif; ?>

		<div class="htm25-cta__inner">

			<?php if ( $is_split ) : ?>

				<div class="htm25-cta__content">
					<?php if ( $show_label && $label_text ) : ?>
					<p class="htm25-cta__section-label">
						<span><?php echo esc_html( $label_text ); ?></span>
					</p>
					<?php endif; ?>

					<?php if ( $headline_html ) : ?>
					<<?php echo $headline_tag; // phpcs:ignore ?> class="htm25-cta__headline"><?php echo $headline_html; // phpcs:ignore ?></<?php echo $headline_tag; // phpcs:ignore ?>>
					<?php endif; ?>

					<?php if ( $description ) : ?>
					<p class="htm25-cta__description"><?php echo esc_html( $description ); ?></p>
					<?php endif; ?>

					<?php if ( $show_primary || $show_secondary ) : ?>
					<div class="htm25-cta__actions">
						<?php if ( $show_primary && $primary_text ) : ?>
						<a href="<?php echo esc_url( $primary_url ); ?>"
						   class="htm25-btn htm25-btn--primary htm25-cta__btn htm25-cta__btn--primary"
						   <?php if ( $primary_target === '_blank' ) : ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>>
							<?php if ( $show_primary_icon && $primary_icon && $primary_icon_pos === 'before' ) : ?>
							<i class="<?php echo esc_attr( $primary_icon ); ?>" aria-hidden="true"></i>
							<?php endif; ?>
							<span><?php echo esc_html( $primary_text ); ?></span>
							<?php if ( $show_primary_icon && $primary_icon && $primary_icon_pos !== 'before' ) : ?>
							<i class="<?php echo esc_attr( $primary_icon ); ?>" aria-hidden="true"></i>
							<?php endif; ?>
						</a>
						<?php endif; ?>

						<?php if ( $show_secondary && $secondary_text ) : ?>
						<a href="<?php echo esc_url( $secondary_url ); ?>"
						   class="htm25-btn htm25-btn--ghost htm25-cta__btn htm25-cta__btn--secondary"
						   <?php if ( $secondary_target === '_blank' ) : ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>>
							<?php echo esc_html( $secondary_text ); ?>
						</a>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</div><!-- .htm25-cta__content -->

				<div class="htm25-cta__media">
					<?php echo $render_image(); // phpcs:ignore ?>
				</div><!-- .htm25-cta__media -->

			<?php else : ?>

				<div class="htm25-cta__content">
					<?php if ( $show_label && $label_text ) : ?>
					<p class="htm25-cta__section-label">
						<span><?php echo esc_html( $label_text ); ?></span>
					</p>
					<?php endif; ?>

					<?php if ( $headline_html ) : ?>
					<<?php echo $headline_tag; // phpcs:ignore ?> class="htm25-cta__headline"><?php echo $headline_html; // phpcs:ignore ?></<?php echo $headline_tag; // phpcs:ignore ?>>
					<?php endif; ?>

					<?php if ( $description ) : ?>
					<p class="htm25-cta__description"><?php echo esc_html( $description ); ?></p>
					<?php endif; ?>

					<?php if ( $show_primary || $show_secondary ) : ?>
					<div class="htm25-cta__actions">
						<?php if ( $show_primary && $primary_text ) : ?>
						<a href="<?php echo esc_url( $primary_url ); ?>"
						   class="htm25-btn htm25-btn--primary htm25-cta__btn htm25-cta__btn--primary"
						   <?php if ( $primary_target === '_blank' ) : ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>>
							<?php if ( $show_primary_icon && $primary_icon && $primary_icon_pos === 'before' ) : ?>
							<i class="<?php echo esc_attr( $primary_icon ); ?>" aria-hidden="true"></i>
							<?php endif; ?>
							<span><?php echo esc_html( $primary_text ); ?></span>
							<?php if ( $show_primary_icon && $primary_icon && $primary_icon_pos !== 'before' ) : ?>
							<i class="<?php echo esc_attr( $primary_icon ); ?>" aria-hidden="true"></i>
							<?php endif; ?>
						</a>
						<?php endif; ?>

						<?php if ( $show_secondary && $secondary_text ) : ?>
						<a href="<?php echo esc_url( $secondary_url ); ?>"
						   class="htm25-btn htm25-btn--ghost htm25-cta__btn htm25-cta__btn--secondary"
						   <?php if ( $secondary_target === '_blank' ) : ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>>
							<?php echo esc_html( $secondary_text ); ?>
						</a>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</div><!-- .htm25-cta__content -->

			<?php endif; ?>

		</div><!-- .htm25-cta__inner -->
	</section><!-- .htm25-cta -->
</div><!-- .htm25-style -->
</div><!-- /.htmega-block-scope -->
