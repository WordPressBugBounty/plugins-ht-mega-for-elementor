<?php
/**
 * HT Mega 2026 — Stats / Counter Block (FSE / Gutenberg)
 * Block name: htmega/stats-2025
 *
 * Server-side renderer. Shares the same BEM HTML + CSS as
 * the Elementor widget (htmega_2025_stats.php).
 *
 * PHP variables available from Blocks_init::prepare_block_data():
 *   $settings (array)  — block attributes (camelCase keys)
 *   $content  (string) — inner block content (unused)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ── Attribute helpers ────────────────────────────────────────────

$style   = isset( $settings['designStyle'] )  ? sanitize_html_class( $settings['designStyle'] ) : 'bento';
$layout  = isset( $settings['layout'] )       ? sanitize_html_class( $settings['layout'] )      : 'row';
$cols    = isset( $settings['statColumns'] )  ? (int) $settings['statColumns']                  : 4;
$cols    = in_array( $cols, [ 2, 3, 4 ], true ) ? $cols : 4;
$countup = isset( $settings['enableCountup'] ) ? (bool) $settings['enableCountup'] : true;

$show_header = isset( $settings['showSectionHeader'] ) ? (bool) $settings['showSectionHeader'] : false;
$show_label  = $show_header && ( isset( $settings['showSectionLabel'] ) ? (bool) $settings['showSectionLabel'] : true );
$label_text  = isset( $settings['sectionLabelText'] ) ? $settings['sectionLabelText'] : 'By the Numbers';

$headline  = isset( $settings['headline'] ) ? $settings['headline'] : '';
$headline  = esc_html( $headline );
$highlight = isset( $settings['headlineHighlight'] ) ? trim( $settings['headlineHighlight'] ) : '';
if ( $highlight && $headline ) {
	$headline = str_replace(
		esc_html( $highlight ),
		'<span class="htm25-stats__headline-accent">' . esc_html( $highlight ) . '</span>',
		$headline
	);
}

$headline_tag = isset( $settings['headlineTag'] ) && in_array( $settings['headlineTag'], [ 'h1', 'h2', 'h3' ] )
	? $settings['headlineTag'] : 'h2';

$description = isset( $settings['description'] ) ? $settings['description'] : '';

$items    = isset( $settings['statItems'] ) && is_array( $settings['statItems'] ) ? $settings['statItems'] : [];
$uid      = isset( $settings['blockUniqId'] ) && $settings['blockUniqId'] ? $settings['blockUniqId'] : uniqid( 'st' );
$block_id = $uid;

// ── Dynamic CSS (mirrors buildStatsCss in edit.js) ───────────
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
	$i  = ! empty( $s['inset'] ) ? 'inset ' : '';
	$h  = is_numeric( $s['horizontal'] ?? null ) ? floatval( $s['horizontal'] ) : 0;
	$v  = is_numeric( $s['vertical']   ?? null ) ? floatval( $s['vertical'] )   : 0;
	$b  = is_numeric( $s['blur']       ?? null ) ? floatval( $s['blur'] )       : 0;
	$sp = is_numeric( $s['spread']     ?? null ) ? floatval( $s['spread'] )     : 0;
	return 'box-shadow: ' . $i . $h . 'px ' . $v . 'px ' . $b . 'px ' . $sp . 'px ' . esc_attr( $s['color'] );
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
if ( ! empty( $settings['styleSectionBgColor'] )    ) $_sec[] = 'background-color: ' . esc_attr( $settings['styleSectionBgColor'] );
if ( ! empty( $settings['styleSectionBgGradient'] ) ) { $_sec[] = 'background: ' . esc_attr( $settings['styleSectionBgGradient'] ); $_sec[] = 'background-color: transparent'; }
$_sec = array_merge( $_sec, $_dim( $settings['styleSectionPadding'] ?? null, 'padding' ), $_border( $settings['sectionBorderType'] ?? null, $settings['sectionBorderWidth'] ?? null, $settings['sectionBorderColor'] ?? null ), $_radius( $settings['styleSectionBorderRadius'] ?? null ) );
$_sw = $_shadow( $settings['styleSectionShadow'] ?? null ); if ( $_sw ) $_sec[] = $_sw;
if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-stats { ' . implode( '; ', $_sec ) . '; }';
if ( ! empty( $settings['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-stats__inner { max-width: ' . esc_attr( $settings['styleContainerMaxWidth'] ) . '; }';

// Headline
$_hl = array_merge( $_typo( $settings['styleHeadlineTypography'] ?? null ), $_dim( $settings['styleHeadlineMargin'] ?? null, 'margin' ) );
if ( ! empty( $settings['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $settings['styleHeadlineColor'] );
$_rule( ' .htm25-stats__headline', $_hl );
if ( ! empty( $settings['styleHeadlineHighlightColor'] )   ) $_css[] = $sc . ' .htm25-stats__headline-accent { background-color: ' . esc_attr( $settings['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
if ( ! empty( $settings['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-stats__headline-accent { background: ' . esc_attr( $settings['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

// Description
$_desc = $_typo( $settings['styleDescTypography'] ?? null );
if ( ! empty( $settings['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $settings['styleDescColor'] );
$_rule( ' .htm25-stats__description', $_desc );

// Stat Items
$_item = array_merge( $_border( $settings['itemBorderType'] ?? null, $settings['itemBorderWidth'] ?? null, $settings['itemBorderColor'] ?? null ), $_radius( $settings['styleItemBorderRadius'] ?? null ) );
if ( ! empty( $settings['styleItemBgColor'] ) ) $_item[] = 'background-color: ' . esc_attr( $settings['styleItemBgColor'] );
$_isw = $_shadow( $settings['styleItemShadow'] ?? null ); if ( $_isw ) $_item[] = $_isw;
$_rule( ' .htm25-stats__item', $_item );

// Number
$_num = $_typo( $settings['styleNumberTypography'] ?? null );
if ( ! empty( $settings['styleNumberGradient'] ) ) {
	$_num[] = 'background: ' . esc_attr( $settings['styleNumberGradient'] );
	$_num[] = '-webkit-background-clip: text';
	$_num[] = '-webkit-text-fill-color: transparent';
	$_num[] = 'background-clip: text';
	$_num[] = 'background-color: transparent';
} elseif ( ! empty( $settings['styleNumberColor'] ) ) {
	$_num[] = 'background-color: ' . esc_attr( $settings['styleNumberColor'] );
}
$_rule( ' .htm25-stats__item-number', $_num );

// Prefix / Suffix
$_ps = $_typo( $settings['stylePrefixSuffixTypography'] ?? null );
if ( ! empty( $settings['stylePrefixSuffixColor'] ) ) $_ps[] = 'color: ' . esc_attr( $settings['stylePrefixSuffixColor'] );
if ( ! empty( $_ps ) ) $_css[] = "$sc .htm25-stats__item-prefix, $sc .htm25-stats__item-suffix { " . implode( '; ', $_ps ) . '; }';

// Label
$_lbl = $_typo( $settings['styleLabelTypography'] ?? null );
if ( ! empty( $settings['styleLabelColor'] ) ) $_lbl[] = 'color: ' . esc_attr( $settings['styleLabelColor'] );
$_rule( ' .htm25-stats__item-label', $_lbl );

// Sub-label / Description
$_slbl = $_typo( $settings['styleSublabelTypography'] ?? null );
if ( ! empty( $settings['styleSublabelColor'] ) ) $_slbl[] = 'color: ' . esc_attr( $settings['styleSublabelColor'] );
$_rule( ' .htm25-stats__item-description', $_slbl );

// Icon
if ( ! empty( $settings['styleIconColor'] ) ) { $_ic = esc_attr( $settings['styleIconColor'] ); $_css[] = "$sc .htm25-stats__item-icon i { color: $_ic; }"; $_css[] = "$sc .htm25-stats__item-icon svg { color: $_ic; }"; $_css[] = "$sc .htm25-stats__item-icon svg path { fill: $_ic; }"; }
if ( ! empty( $settings['styleIconSize'] )  ) { $_sz = esc_attr( $settings['styleIconSize'] ); $_css[] = "$sc .htm25-stats__item-icon i { font-size: {$_sz}px; }"; $_css[] = "$sc .htm25-stats__item-icon svg { width: {$_sz}px; height: {$_sz}px; }"; }

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

// ── Item renderer closure ──────────────────────────────────────

$render_stat_item = function( array $item, int $index ) use ( $layout, $countup ) {

	$prefix      = isset( $item['statPrefix'] )      ? $item['statPrefix']      : '';
	$number      = isset( $item['statNumber'] )      ? $item['statNumber']      : '0';
	$suffix      = isset( $item['statSuffix'] )      ? $item['statSuffix']      : '';
	$label       = isset( $item['statLabel'] )       ? $item['statLabel']       : '';
	$description = isset( $item['statDescription'] ) ? $item['statDescription'] : '';
	$icon        = isset( $item['statIcon'] )        ? $item['statIcon']        : '';

	$is_first   = $index === 0;
	$item_class = 'htm25-stats__item' . ( $is_first && $layout === 'bento' ? ' htm25-stats__item--featured' : '' );

	$display_number = is_numeric( $number )
		? ( strpos( $number, '.' ) !== false ? $number : number_format( (float) $number ) )
		: $number;
	?>
	<div class="<?php echo esc_attr( $item_class ); ?>" role="listitem">

		<?php if ( $icon ) : ?>
		<div class="htm25-stats__item-icon-wrap" aria-hidden="true">
			<span class="htm25-stats__item-icon">
				<i class="<?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>
			</span>
		</div>
		<?php endif; ?>

		<div class="htm25-stats__item-value-wrap" aria-label="<?php echo esc_attr( $prefix . $display_number . $suffix . ' ' . $label ); ?>">
			<?php if ( $prefix ) : ?>
			<span class="htm25-stats__item-prefix" aria-hidden="true"><?php echo esc_html( $prefix ); ?></span>
			<?php endif; ?>
			<span
				class="htm25-stats__item-number"
				<?php if ( $countup && is_numeric( $number ) ) : ?>
				data-target="<?php echo esc_attr( $number ); ?>"
				<?php endif; ?>
				aria-hidden="true"
			><?php echo esc_html( $display_number ); ?></span>
			<?php if ( $suffix ) : ?>
			<span class="htm25-stats__item-suffix" aria-hidden="true"><?php echo esc_html( $suffix ); ?></span>
			<?php endif; ?>
		</div>

		<?php if ( $label ) : ?>
		<p class="htm25-stats__item-label"><?php echo esc_html( $label ); ?></p>
		<?php endif; ?>

		<?php if ( $description ) : ?>
		<p class="htm25-stats__item-description"><?php echo esc_html( $description ); ?></p>
		<?php endif; ?>

		<?php if ( $layout === 'row' ) : ?>
		<div class="htm25-stats__item-divider" aria-hidden="true"></div>
		<?php endif; ?>

	</div>
	<?php
};

?>
<?php if ( $_css_out ) : ?><style><?php echo $_css_out; // phpcs:ignore WordPress.Security.EscapeOutput ?></style><?php endif; ?>
<div class="htmega-block-<?php echo esc_attr( $block_id ); ?>">
<section
	id="htm25-stats-<?php echo esc_attr( $uid ); ?>"
	class="htm25-stats htm25-style--<?php echo $style; ?> htm25-stats--<?php echo $layout; ?>"
	aria-label="<?php esc_attr_e( 'Stats section', 'htmega-addons' ); ?>"
>
	<?php if ( $style === 'aurora' || $style === 'glass' ) : ?>
	<div class="htm25-stats__bg-blobs" aria-hidden="true">
		<div class="htm25-stats__blob htm25-stats__blob--1"></div>
		<div class="htm25-stats__blob htm25-stats__blob--2"></div>
	</div>
	<?php endif; ?>

	<?php if ( $style === 'neo' ) : ?>
	<div class="htm25-stats__neo-grid" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="htm25-stats__inner">

		<?php if ( $show_header ) : ?>
		<div class="htm25-stats__header">
			<?php if ( $show_label && $label_text ) : ?>
			<p class="htm25-stats__section-label htm25-section-label">
				<?php echo esc_html( $label_text ); ?>
			</p>
			<?php endif; ?>
			<?php if ( $headline ) : ?>
			<<?php echo $headline_tag; ?> class="htm25-stats__headline"><?php echo $headline; ?></<?php echo $headline_tag; ?>>
			<?php endif; ?>
			<?php if ( $description ) : ?>
			<p class="htm25-stats__description"><?php echo wp_kses_post( $description ); ?></p>
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<?php if ( $items ) : ?>
		<div class="htm25-stats__grid htm25-stats__grid--cols-<?php echo $cols; ?>" role="list">
			<?php foreach ( $items as $index => $item ) :
				$render_stat_item( (array) $item, $index );
			endforeach; ?>
		</div>
		<?php endif; ?>

	</div><!-- /.htm25-stats__inner -->

</section>
</div><!-- /.htmega-block-scope -->

<?php if ( $countup && $items ) : ?>
<script>
( function () {
	var section = document.getElementById( 'htm25-stats-<?php echo esc_js( $uid ); ?>' );
	if ( ! section ) return;

	var motionOK = ! window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var numbers  = section.querySelectorAll( '.htm25-stats__item-number[data-target]' );

	if ( ! motionOK ) {
		numbers.forEach( function( el ) {
			el.textContent = el.getAttribute( 'data-target' );
		} );
		return;
	}

	var animated = false;

	function runCountUp() {
		if ( animated ) return;
		animated = true;

		numbers.forEach( function( el ) {
			var targetStr = el.getAttribute( 'data-target' );
			var target    = parseFloat( targetStr );
			if ( isNaN( target ) ) { el.textContent = targetStr; return; }

			var isFloat  = targetStr.indexOf( '.' ) !== -1;
			var decimals = isFloat ? ( targetStr.split( '.' )[ 1 ] || '' ).length : 0;
			var duration = 2000;
			var start    = null;

			function step( ts ) {
				if ( ! start ) start = ts;
				var progress = Math.min( ( ts - start ) / duration, 1 );
				var ease     = 1 - Math.pow( 1 - progress, 3 );
				var current  = ease * target;
				el.textContent = isFloat
					? current.toFixed( decimals )
					: Math.floor( current ).toLocaleString();
				if ( progress < 1 ) {
					requestAnimationFrame( step );
				} else {
					el.textContent = isFloat
						? target.toFixed( decimals )
						: target.toLocaleString();
				}
			}
			requestAnimationFrame( step );
		} );
	}

	if ( 'IntersectionObserver' in window ) {
		var observer = new IntersectionObserver( function( entries ) {
			entries.forEach( function( entry ) {
				if ( entry.isIntersecting ) {
					runCountUp();
					observer.disconnect();
				}
			} );
		}, { threshold: 0.25 } );
		observer.observe( section );
	} else {
		runCountUp();
	}
} )();
</script>
<?php endif; ?>
