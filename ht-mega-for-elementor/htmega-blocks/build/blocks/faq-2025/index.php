<?php
/**
 * HT Mega 2026 — FAQ Section Block
 * Server-side renderer for htmega/faq-2025.
 *
 * @package HT_Mega
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$attributes = $settings; // render callback provides $settings

// ── Attribute extraction ──────────────────────────────────────────────────────
$design_style = isset( $attributes['designStyle'] )     ? sanitize_html_class( $attributes['designStyle'] ) : 'bento';
$layout       = isset( $attributes['layout'] )          ? sanitize_html_class( $attributes['layout'] )      : 'simple';
$items        = isset( $attributes['faqItems'] )        ? $attributes['faqItems']                           : [];

$show_label   = ! empty( $attributes['showSectionLabel'] );
$label_text   = isset( $attributes['sectionLabelText'] ) ? esc_html( $attributes['sectionLabelText'] )       : '';
$headline     = isset( $attributes['headline'] )         ? esc_html( $attributes['headline'] )               : '';
$headline_hl  = isset( $attributes['headlineHighlight'] ) ? esc_html( $attributes['headlineHighlight'] )     : '';
$headline_tag = isset( $attributes['headlineTag'] )      ? tag_escape( $attributes['headlineTag'] )          : 'h2';
$description  = isset( $attributes['description'] )      ? esc_html( $attributes['description'] )            : '';

// ── Headline highlight ────────────────────────────────────────────────────────
$headline_html = '';
if ( $headline ) {
	if ( $headline_hl && strpos( $headline, $headline_hl ) !== false ) {
		$headline_html = str_replace(
			esc_html( $headline_hl ),
			'<span class="htm25-faq__headline-accent">' . esc_html( $headline_hl ) . '</span>',
			esc_html( $headline )
		);
	} else {
		$headline_html = esc_html( $headline );
	}
}

// ── Dynamic CSS (mirrors buildFaqCss in edit.js) ─────────────
$block_id = isset( $attributes['blockUniqId'] ) ? sanitize_html_class( $attributes['blockUniqId'] ) : uniqid( 'htm25-faq-' );
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
if ( ! empty( $attributes['styleSectionBgColor'] )    ) $_sec[] = 'background-color: ' . esc_attr( $attributes['styleSectionBgColor'] );
if ( ! empty( $attributes['styleSectionBgGradient'] ) ) { $_sec[] = 'background: ' . esc_attr( $attributes['styleSectionBgGradient'] ); $_sec[] = 'background-color: transparent'; }
$_sec = array_merge( $_sec, $_dim( $attributes['styleSectionPadding'] ?? null, 'padding' ), $_border( $attributes['sectionBorderType'] ?? null, $attributes['sectionBorderWidth'] ?? null, $attributes['sectionBorderColor'] ?? null ), $_radius( $attributes['styleSectionBorderRadius'] ?? null ) );
$_sw = $_shadow( $attributes['styleSectionShadow'] ?? null ); if ( $_sw ) $_sec[] = $_sw;
if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-faq { ' . implode( '; ', $_sec ) . '; }';
if ( ! empty( $attributes['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-faq__inner { max-width: ' . esc_attr( $attributes['styleContainerMaxWidth'] ) . '; }';

// Headline
$_hl = array_merge( $_typo( $attributes['styleHeadlineTypography'] ?? null ), $_dim( $attributes['styleHeadlineMargin'] ?? null, 'margin' ) );
if ( ! empty( $attributes['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $attributes['styleHeadlineColor'] );
$_rule( ' .htm25-faq__headline', $_hl );
if ( ! empty( $attributes['styleHeadlineHighlightColor'] )   ) $_css[] = $sc . ' .htm25-faq__headline-accent { background-color: ' . esc_attr( $attributes['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
if ( ! empty( $attributes['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-faq__headline-accent { background: ' . esc_attr( $attributes['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

// Description
$_desc = $_typo( $attributes['styleDescTypography'] ?? null );
if ( ! empty( $attributes['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $attributes['styleDescColor'] );
$_rule( ' .htm25-faq__description', $_desc );

// FAQ Items
$_item = array_merge( $_border( $attributes['itemBorderType'] ?? null, $attributes['itemBorderWidth'] ?? null, $attributes['itemBorderColor'] ?? null ), $_radius( $attributes['styleItemBorderRadius'] ?? null ) );
if ( ! empty( $attributes['styleItemBgColor'] ) ) $_item[] = 'background-color: ' . esc_attr( $attributes['styleItemBgColor'] );
$_isw = $_shadow( $attributes['styleItemShadow'] ?? null ); if ( $_isw ) $_item[] = $_isw;
$_rule( ' .htm25-faq .htm25-faq__item', $_item );

// Question
$_q = $_typo( $attributes['styleQuestionTypography'] ?? null );
if ( ! empty( $attributes['styleQuestionColor'] ) ) $_q[] = 'color: ' . esc_attr( $attributes['styleQuestionColor'] );
$_rule( ' .htm25-faq__item-question', $_q );
if ( ! empty( $attributes['styleQuestionActiveColor'] )   ) $_css[] = $sc . ' .htm25-faq__item[open] .htm25-faq__item-question { color: ' . esc_attr( $attributes['styleQuestionActiveColor'] ) . '; }';
if ( ! empty( $attributes['styleQuestionActiveBgColor'] ) ) $_css[] = $sc . ' .htm25-faq .htm25-faq__item[open] { background-color: ' . esc_attr( $attributes['styleQuestionActiveBgColor'] ) . '; }';

// Answer
$_ans = $_typo( $attributes['styleAnswerTypography'] ?? null );
if ( ! empty( $attributes['styleAnswerColor'] ) ) $_ans[] = 'color: ' . esc_attr( $attributes['styleAnswerColor'] );
$_rule( ' .htm25-faq .htm25-faq__item .htm25-faq__item-answer', $_ans );

// Category Tag
$_tag = array_merge( $_typo( $attributes['styleTagTypography'] ?? null ), $_radius( $attributes['styleTagRadius'] ?? null ) );
if ( ! empty( $attributes['styleTagColor'] )   ) $_tag[] = 'color: ' . esc_attr( $attributes['styleTagColor'] );
if ( ! empty( $attributes['styleTagBgColor'] ) ) $_tag[] = 'background-color: ' . esc_attr( $attributes['styleTagBgColor'] );
$_rule( ' .htm25-faq__item-category', $_tag );

// Chevron
if ( ! empty( $attributes['styleChevronSize'] )        ) { $_sz = esc_attr( $attributes['styleChevronSize'] ); $_css[] = $sc . ' .htm25-faq__item-icon { width: ' . $_sz . 'px; height: ' . $_sz . 'px; }'; }
if ( ! empty( $attributes['styleChevronColor'] )       ) $_css[] = $sc . ' .htm25-faq__item-icon { color: ' . esc_attr( $attributes['styleChevronColor'] ) . '; }';
if ( ! empty( $attributes['styleChevronActiveColor'] ) ) $_css[] = $sc . ' .htm25-faq__item[open] .htm25-faq__item-icon { color: ' . esc_attr( $attributes['styleChevronActiveColor'] ) . '; }';

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

// ── Chevron SVG ───────────────────────────────────────────────────────────────
$chevron_svg = '<svg class="htm25-faq__item-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';

// ── Item renderer (closure prevents redeclare on multiple blocks) ─────────────
$render_faq_item = function( $item ) use ( $chevron_svg ) {
	$question = isset( $item['faqQuestion'] ) ? esc_html( $item['faqQuestion'] ) : '';
	$answer   = isset( $item['faqAnswer'] )   ? esc_html( $item['faqAnswer'] )   : '';
	$category = isset( $item['faqCategory'] ) ? esc_html( $item['faqCategory'] ) : '';
	$is_open  = ! empty( $item['faqOpen'] );
	?>
	<details class="htm25-faq__item" <?php if ( $is_open ) echo 'open'; ?> role="listitem">
		<summary class="htm25-faq__item-summary">
			<div class="htm25-faq__item-question-wrap">
				<?php if ( $category ) : ?>
				<span class="htm25-faq__item-category"><?php echo esc_html( $category ); ?></span>
				<?php endif; ?>
				<span class="htm25-faq__item-question"><?php echo esc_html( $question ); ?></span>
			</div>
			<?php echo $chevron_svg; // phpcs:ignore ?>
		</summary>
		<div class="htm25-faq__item-body">
			<p class="htm25-faq__item-answer"><?php echo esc_html( $answer ); ?></p>
		</div>
	</details>
	<?php
};
?>
<?php if ( $_css_out ) : ?><style><?php echo $_css_out; // phpcs:ignore WordPress.Security.EscapeOutput ?></style><?php endif; ?>
<div class="htmega-block-<?php echo esc_attr( $block_id ); ?>">
<div class="htm25-style--<?php echo esc_attr( $design_style ); ?>">
	<section class="htm25-faq htm25-faq--<?php echo esc_attr( $layout ); ?>">

		<?php if ( in_array( $design_style, [ 'glass', 'aurora' ], true ) ) : ?>
		<div class="htm25-faq__bg-blobs" aria-hidden="true">
			<div class="htm25-faq__blob htm25-faq__blob--1"></div>
			<div class="htm25-faq__blob htm25-faq__blob--2"></div>
		</div>
		<?php endif; ?>

		<div class="htm25-faq__inner">

			<?php if ( $show_label && $label_text || $headline || $description ) : ?>
			<header class="htm25-faq__header">
				<?php if ( $show_label && $label_text ) : ?>
				<p class="htm25-faq__section-label">
					<span><?php echo esc_html( $label_text ); ?></span>
				</p>
				<?php endif; ?>

				<?php if ( $headline_html ) : ?>
				<<?php echo $headline_tag; // phpcs:ignore ?> class="htm25-faq__headline"><?php echo $headline_html; // phpcs:ignore ?></<?php echo $headline_tag; // phpcs:ignore ?>>
				<?php endif; ?>

				<?php if ( $description ) : ?>
				<p class="htm25-faq__description"><?php echo esc_html( $description ); ?></p>
				<?php endif; ?>
			</header>
			<?php endif; ?>

			<?php if ( ! empty( $items ) ) : ?>
			<div class="htm25-faq__list" role="list">
				<?php foreach ( $items as $item ) : ?>
					<?php $render_faq_item( $item ); ?>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>

		</div><!-- .htm25-faq__inner -->
	</section><!-- .htm25-faq -->
</div><!-- .htm25-style -->
</div><!-- /.htmega-block-scope -->
