<?php
/**
 * HT Mega 2026 — Testimonials Block (FSE / Gutenberg)
 * Block name: htmega/testimonials-2025
 *
 * Server-side renderer. Shares the same BEM HTML structure as
 * the Elementor widget (htmega_2025_testimonials.php) and the same CSS
 * (htm25-tokens.css + assets/css/widgets/htm25-testimonials.css).
 *
 * PHP variables available from Blocks_init::prepare_block_data():
 *   $settings (array)  — block attributes
 *   $content  (string) — inner block content (not used — server render)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ── Attribute helpers ────────────────────────────────────────────

$style  = isset( $settings['designStyle'] ) ? sanitize_html_class( $settings['designStyle'] ) : 'bento';
$layout = isset( $settings['layout'] )      ? sanitize_html_class( $settings['layout'] )      : 'grid';
$cols   = isset( $settings['testimonialColumns'] ) ? (int) $settings['testimonialColumns'] : 3;
$cols   = in_array( $cols, [ 2, 3, 4 ], true ) ? $cols : 3;

$show_label = isset( $settings['showSectionLabel'] ) ? (bool) $settings['showSectionLabel'] : true;
$label_text = isset( $settings['sectionLabelText'] ) ? $settings['sectionLabelText'] : 'Testimonials';

$headline  = isset( $settings['headline'] ) ? $settings['headline'] : "Trusted by teams\nat world-class companies.";
$headline  = esc_html( $headline );
$highlight = isset( $settings['headlineHighlight'] ) ? trim( $settings['headlineHighlight'] ) : '';
if ( $highlight ) {
	$headline = str_replace(
		esc_html( $highlight ),
		'<span class="htm25-testimonials__headline-accent">' . esc_html( $highlight ) . '</span>',
		$headline
	);
}

$headline_tag = isset( $settings['headlineTag'] ) && in_array( $settings['headlineTag'], [ 'h1', 'h2', 'h3' ] )
	? $settings['headlineTag'] : 'h2';

$description = isset( $settings['description'] ) ? $settings['description'] : '';

$items = isset( $settings['testimonialItems'] ) && is_array( $settings['testimonialItems'] )
	? $settings['testimonialItems'] : [];

// ── Card renderer closure (prevents "Cannot redeclare" on multi-block pages) ──

// Unique wrapper ID
$block_id = isset( $settings['blockUniqId'] ) ? sanitize_html_class( $settings['blockUniqId'] ) : uniqid( 'htm25-testimonials-' );

// ── Dynamic CSS (mirrors buildTestimonialsCss in edit.js) ────
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
if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-testimonials { ' . implode( '; ', $_sec ) . '; }';
if ( ! empty( $settings['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-testimonials__inner { max-width: ' . esc_attr( $settings['styleContainerMaxWidth'] ) . '; }';

// Headline
$_hl = array_merge( $_typo( $settings['styleHeadlineTypography'] ?? null ), $_dim( $settings['styleHeadlineMargin'] ?? null, 'margin' ) );
if ( ! empty( $settings['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $settings['styleHeadlineColor'] );
$_rule( ' .htm25-testimonials__headline', $_hl );
if ( ! empty( $settings['styleHeadlineHighlightColor'] )   ) $_css[] = $sc . ' .htm25-testimonials .htm25-testimonials__headline-accent { background-color: ' . esc_attr( $settings['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
if ( ! empty( $settings['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-testimonials .htm25-testimonials__headline-accent { background: ' . esc_attr( $settings['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

// Description
$_desc = $_typo( $settings['styleDescTypography'] ?? null );
if ( ! empty( $settings['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $settings['styleDescColor'] );
$_rule( ' .htm25-testimonials__description', $_desc );

// Card
$_card = array_merge( $_border( $settings['cardBorderType'] ?? null, $settings['cardBorderWidth'] ?? null, $settings['cardBorderColor'] ?? null ), $_radius( $settings['styleCardBorderRadius'] ?? null ) );
if ( ! empty( $settings['styleCardBgColor'] ) ) $_card[] = 'background-color: ' . esc_attr( $settings['styleCardBgColor'] );
$_csw = $_shadow( $settings['styleCardShadow'] ?? null ); if ( $_csw ) $_card[] = $_csw;
$_rule( ' .htm25-testimonials__card', $_card );

// Featured card
$_featured = $_border( $settings['featuredCardBorderType'] ?? null, $settings['featuredCardBorderWidth'] ?? null, $settings['featuredCardBorderColor'] ?? null );
if ( ! empty( $settings['featuredCardBgColor'] ) ) $_featured[] = 'background-color: ' . esc_attr( $settings['featuredCardBgColor'] );
$_fsw = $_shadow( $settings['featuredCardShadow'] ?? null ); if ( $_fsw ) $_featured[] = $_fsw;
$_rule( ' .htm25-testimonials__card--featured', $_featured );

// Quote text
$_qt = $_typo( $settings['styleQuoteTypography'] ?? null );
if ( ! empty( $settings['styleQuoteColor'] ) ) $_qt[] = 'color: ' . esc_attr( $settings['styleQuoteColor'] );
$_rule( ' .htm25-testimonials__card-text', $_qt );

// Author name
$_an = $_typo( $settings['styleAuthorNameTypography'] ?? null );
if ( ! empty( $settings['styleAuthorNameColor'] ) ) $_an[] = 'color: ' . esc_attr( $settings['styleAuthorNameColor'] );
$_rule( ' .htm25-testimonials__card-name', $_an );

// Author role / company
$_ar = $_typo( $settings['styleAuthorRoleTypography'] ?? null );
if ( ! empty( $settings['styleAuthorRoleColor'] )    ) $_ar[] = 'color: ' . esc_attr( $settings['styleAuthorRoleColor'] );
$_rule( ' .htm25-testimonials__card-role', $_ar );
if ( ! empty( $settings['styleAuthorCompanyColor'] ) ) $_css[] = "$sc .htm25-testimonials__card-company { color: " . esc_attr( $settings['styleAuthorCompanyColor'] ) . "; }";

// Avatar
if ( ! empty( $settings['styleAvatarSize'] ) ) {
	$_sz = esc_attr( $settings['styleAvatarSize'] );
	$_fs = (int) round( (int) $_sz * 0.4 );
	$_css[] = "$sc .htm25-testimonials__card-avatar { width: {$_sz}px; height: {$_sz}px; min-width: {$_sz}px; }";
	$_css[] = "$sc .htm25-testimonials__card-avatar img { width: {$_sz}px; height: {$_sz}px; }";
	$_css[] = "$sc .htm25-testimonials__card-avatar-placeholder { width: {$_sz}px; height: {$_sz}px; font-size: {$_fs}px; }";
}
if ( ! empty( $settings['styleAvatarBorderRadius'] ) ) {
	$_avr = $_radius( $settings['styleAvatarBorderRadius'] );
	$_rule( ' .htm25-testimonials__card-avatar', $_avr );
	$_rule( ' .htm25-testimonials__card-avatar img', $_avr );
	$_rule( ' .htm25-testimonials__card-avatar-placeholder', $_avr );
}

// Stars
if ( ! empty( $settings['styleStarsColor'] ) ) {
	$_sc_val = esc_attr( $settings['styleStarsColor'] );
	$_css[] = "$sc .htm25-testimonials__star--filled { color: $_sc_val; }";
	$_css[] = "$sc .htm25-testimonials__star--filled svg path { fill: $_sc_val; }";
}
if ( ! empty( $settings['styleEmptyStarsColor'] ) ) {
	$_esc_val = esc_attr( $settings['styleEmptyStarsColor'] );
	$_css[] = "$sc .htm25-testimonials__star--empty { color: $_esc_val; opacity: 1; }";
	$_css[] = "$sc .htm25-testimonials__star--empty svg path { fill: $_esc_val; }";
}

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

$render_testimonial_card = function( array $item ) {

	$quote       = isset( $item['quoteText'] )     ? $item['quoteText']      : '';
	$rating      = isset( $item['rating'] )        ? (int) $item['rating']   : 0;
	$name        = isset( $item['authorName'] )    ? $item['authorName']     : '';
	$role        = isset( $item['authorRole'] )    ? $item['authorRole']     : '';
	$company     = isset( $item['authorCompany'] ) ? $item['authorCompany']  : '';
	$avatar_url  = isset( $item['authorAvatar'] )  ? $item['authorAvatar']   : '';
	$is_featured = ! empty( $item['isFeatured'] );

	$card_class = 'htm25-testimonials__card' . ( $is_featured ? ' htm25-testimonials__card--featured' : '' );
	?>
	<div class="<?php echo esc_attr( $card_class ); ?>" role="listitem">

		<div class="htm25-testimonials__card-quote">
			<div class="htm25-testimonials__card-quote-icon" aria-hidden="true">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 32" fill="currentColor" width="40" height="32" aria-hidden="true" focusable="false">
					<path d="M0 32V20.16Q0 12.48 4.16 6.24T16 0l2.24 3.36Q11.52 5.76 8.32 10.56T5.12 20.16H10V32H0Zm22 0V20.16q0-7.68 4.16-13.92T38 0l2.24 3.36q-6.72 2.4-9.92 7.2T27.12 20.16H32V32H22Z"/>
				</svg>
			</div>

			<?php if ( $rating > 0 && $rating <= 5 ) : ?>
			<div class="htm25-testimonials__card-rating" aria-label="<?php /* translators: %d: star rating out of 5 */ printf( esc_attr__( 'Rated %d out of 5 stars', 'ht-mega-for-elementor' ), (int) $rating ); ?>">
				<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="16" height="16" class="htm25-testimonials__star htm25-testimonials__star--<?php echo $i <= $rating ? 'filled' : 'empty'; ?>" aria-hidden="true" focusable="false">
					<path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.83-4.401Z" clip-rule="evenodd"/>
				</svg>
				<?php endfor; ?>
			</div>
			<?php endif; ?>

			<?php if ( $quote ) : ?>
			<p class="htm25-testimonials__card-text"><?php echo wp_kses_post( $quote ); ?></p>
			<?php endif; ?>
		</div><!-- /.htm25-testimonials__card-quote -->

		<div class="htm25-testimonials__card-author">

			<?php if ( $avatar_url ) : ?>
			<img
				class="htm25-testimonials__card-avatar"
				src="<?php echo esc_url( $avatar_url ); ?>"
				alt="<?php echo esc_attr( $name ); ?>"
				width="48"
				height="48"
				loading="lazy"
			>
			<?php else : ?>
			<div class="htm25-testimonials__card-avatar-placeholder" aria-hidden="true">
				<?php echo esc_html( mb_substr( $name, 0, 1 ) ); ?>
			</div>
			<?php endif; ?>

			<div class="htm25-testimonials__card-author-info">
				<?php if ( $name ) : ?>
				<strong class="htm25-testimonials__card-name"><?php echo esc_html( $name ); ?></strong>
				<?php endif; ?>
				<?php if ( $role || $company ) : ?>
				<span class="htm25-testimonials__card-meta">
					<?php if ( $role ) : ?><span class="htm25-testimonials__card-role"><?php echo esc_html( $role ); ?></span><?php endif; ?>
					<?php if ( $role && $company ) : ?><span class="htm25-testimonials__card-sep" aria-hidden="true"> · </span><?php endif; ?>
					<?php if ( $company ) : ?><span class="htm25-testimonials__card-company"><?php echo esc_html( $company ); ?></span><?php endif; ?>
				</span>
				<?php endif; ?>
			</div>

		</div><!-- /.htm25-testimonials__card-author -->

	</div><!-- /.htm25-testimonials__card -->
	<?php
};

?>
<?php if ( $_css_out ) : ?><style><?php echo $_css_out; // phpcs:ignore WordPress.Security.EscapeOutput ?></style><?php endif; ?>
<div class="htmega-block-<?php echo esc_attr( $block_id ); ?>">
<section
	class="htm25-testimonials htm25-style--<?php echo esc_attr( $style ); ?> htm25-testimonials--<?php echo esc_attr( $layout ); ?>"
	aria-label="<?php esc_attr_e( 'Testimonials section', 'ht-mega-for-elementor' ); ?>"
>
	<?php if ( $style === 'aurora' || $style === 'glass' ) : ?>
	<div class="htm25-testimonials__bg-blobs" aria-hidden="true">
		<div class="htm25-testimonials__blob htm25-testimonials__blob--1"></div>
		<div class="htm25-testimonials__blob htm25-testimonials__blob--2"></div>
	</div>
	<?php endif; ?>

	<?php if ( $style === 'neo' ) : ?>
	<div class="htm25-testimonials__neo-grid" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="htm25-testimonials__inner">

		<?php if ( $show_label || $headline || $description ) : ?>
		<div class="htm25-testimonials__header">

			<?php if ( $show_label && $label_text ) : ?>
			<p class="htm25-testimonials__section-label htm25-section-label">
				<?php echo esc_html( $label_text ); ?>
			</p>
			<?php endif; ?>

			<?php if ( $headline ) : ?>
			<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $headline_tag is whitelisted to h1/h2/h3 above (line 38); $headline is esc_html()'d at assignment (line 28) then combined with fixed, hardcoded <span> markup (line 33). ?>
			<<?php echo esc_html( $headline_tag ); ?> class="htm25-testimonials__headline"><?php echo $headline; ?></<?php echo esc_html( $headline_tag ); ?>>
			<?php endif; ?>

			<?php if ( $description ) : ?>
			<p class="htm25-testimonials__description"><?php echo wp_kses_post( $description ); ?></p>
			<?php endif; ?>

		</div>
		<?php endif; ?>

		<?php if ( $items ) : ?>
		<div class="htm25-testimonials__grid htm25-testimonials__grid--cols-<?php echo (int) $cols; ?>" role="list">
			<?php if ( 'masonry' === $layout ) :
				$masonry_cols = array_fill( 0, $cols, [] );
				foreach ( $items as $i => $item ) {
					$masonry_cols[ $i % $cols ][] = $item;
				}
				foreach ( $masonry_cols as $col_items ) : ?>
			<div class="htm25-testimonials__masonry-col">
				<?php foreach ( $col_items as $item ) :
					$render_testimonial_card( (array) $item );
				endforeach; ?>
			</div>
				<?php endforeach;
			else :
				foreach ( $items as $item ) :
					$render_testimonial_card( (array) $item );
				endforeach;
			endif; ?>
		</div>
		<?php endif; ?>

	</div><!-- /.htm25-testimonials__inner -->

</section>
</div><!-- /.htmega-block-scope -->
