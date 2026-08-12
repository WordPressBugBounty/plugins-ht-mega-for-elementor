<?php
/**
 * HT Mega 2026 — Blog / Posts Section Block
 * Server-side renderer for htmega/blog-2025.
 *
 * @package HT_Mega
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$attributes = $settings; // render callback provides $settings

// ── Attribute extraction ──────────────────────────────────────────────────────
$design_style = isset( $attributes['designStyle'] )    ? sanitize_html_class( $attributes['designStyle'] ) : 'bento';
$layout       = isset( $attributes['layout'] )         ? sanitize_html_class( $attributes['layout'] )      : 'grid';
$columns      = isset( $attributes['columns'] )        ? (int) $attributes['columns']                      : 3;

$show_header  = ! empty( $attributes['showSectionHeader'] );
$show_label   = $show_header && ! empty( $attributes['showSectionLabel'] );
$label_text   = isset( $attributes['sectionLabelText'] )  ? esc_html( $attributes['sectionLabelText'] )   : '';
$headline     = isset( $attributes['headline'] )           ? esc_html( $attributes['headline'] )           : '';
$headline_hl  = isset( $attributes['headlineHighlight'] )  ? esc_html( $attributes['headlineHighlight'] )  : '';
$headline_tag = isset( $attributes['headlineTag'] )        ? tag_escape( $attributes['headlineTag'] )      : 'h2';
$description  = isset( $attributes['description'] )        ? esc_html( $attributes['description'] )        : '';

$posts_per_page = isset( $attributes['postsPerPage'] )   ? (int) $attributes['postsPerPage']   : 6;
$category_id    = isset( $attributes['categoryId'] )     ? (int) $attributes['categoryId']     : 0;
$order_by_raw   = isset( $attributes['orderBy'] )        ? $attributes['orderBy']              : 'date';

$show_image     = ! empty( $attributes['showImage'] );
$show_category  = ! empty( $attributes['showCategory'] );
$show_author    = ! empty( $attributes['showAuthor'] );
$show_date      = ! empty( $attributes['showDate'] );
$show_read_time = ! empty( $attributes['showReadTime'] );
$show_excerpt   = ! empty( $attributes['showExcerpt'] );
$excerpt_length = isset( $attributes['excerptLength'] )  ? (int) $attributes['excerptLength']  : 20;
$show_read_more = ! empty( $attributes['showReadMore'] );
$read_more_text = isset( $attributes['readMoreText'] )   ? esc_html( $attributes['readMoreText'] ) : esc_html__( 'Read Article', 'ht-mega-for-elementor' );

// ── Dynamic CSS (mirrors buildBlogCss in edit.js) ────────────
$block_id = isset( $attributes['blockUniqId'] ) ? sanitize_html_class( $attributes['blockUniqId'] ) : uniqid( 'htm25-blog-' );
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
if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-blog { ' . implode( '; ', $_sec ) . '; }';
if ( ! empty( $attributes['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-blog__inner { max-width: ' . esc_attr( $attributes['styleContainerMaxWidth'] ) . '; }';

// Headline
$_hl = array_merge( $_typo( $attributes['styleHeadlineTypography'] ?? null ), $_dim( $attributes['styleHeadlineMargin'] ?? null, 'margin' ) );
if ( ! empty( $attributes['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $attributes['styleHeadlineColor'] );
$_rule( ' .htm25-blog__headline', $_hl );
if ( ! empty( $attributes['styleHeadlineHighlightColor'] )   ) $_css[] = $sc . ' .htm25-blog__headline-accent { background-color: ' . esc_attr( $attributes['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
if ( ! empty( $attributes['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-blog__headline-accent { background: ' . esc_attr( $attributes['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

// Description
$_desc = $_typo( $attributes['styleDescTypography'] ?? null );
if ( ! empty( $attributes['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $attributes['styleDescColor'] );
$_rule( ' .htm25-blog__description', $_desc );

// Post Cards
$_card = array_merge( $_border( $attributes['cardBorderType'] ?? null, $attributes['cardBorderWidth'] ?? null, $attributes['cardBorderColor'] ?? null ), $_radius( $attributes['styleCardBorderRadius'] ?? null ) );
if ( ! empty( $attributes['styleCardBgColor'] ) ) $_card[] = 'background-color: ' . esc_attr( $attributes['styleCardBgColor'] );
$_csw = $_shadow( $attributes['styleCardShadow'] ?? null ); if ( $_csw ) $_card[] = $_csw;
$_rule( ' .htm25-blog__card', $_card );

// Category Badge
$_cat = array_merge( $_typo( $attributes['styleCategoryTypography'] ?? null ), $_radius( $attributes['styleCategoryRadius'] ?? null ) );
if ( ! empty( $attributes['styleCategoryColor'] )   ) $_cat[] = 'color: ' . esc_attr( $attributes['styleCategoryColor'] );
if ( ! empty( $attributes['styleCategoryBgColor'] ) ) $_cat[] = 'background-color: ' . esc_attr( $attributes['styleCategoryBgColor'] );
$_rule( ' .htm25-blog__card-category', $_cat );

// Post Title
$_title = $_typo( $attributes['stylePostTitleTypography'] ?? null );
if ( ! empty( $attributes['stylePostTitleColor'] ) ) $_title[] = 'color: ' . esc_attr( $attributes['stylePostTitleColor'] );
$_rule( ' .htm25-blog__card-title', $_title );
if ( ! empty( $attributes['stylePostTitleColor'] )      ) $_css[] = $sc . ' .htm25-blog__card-title a { color: ' . esc_attr( $attributes['stylePostTitleColor'] ) . '; }';
if ( ! empty( $attributes['stylePostTitleHoverColor'] ) ) $_css[] = $sc . ' .htm25-blog__card-title a:hover { color: ' . esc_attr( $attributes['stylePostTitleHoverColor'] ) . '; }';

// Excerpt
$_exc = $_typo( $attributes['styleExcerptTypography'] ?? null );
if ( ! empty( $attributes['styleExcerptColor'] ) ) $_exc[] = 'color: ' . esc_attr( $attributes['styleExcerptColor'] );
$_rule( ' .htm25-blog__card-excerpt', $_exc );

// Meta (author, date, read time)
$_meta = $_typo( $attributes['styleMetaTypography'] ?? null );
if ( ! empty( $attributes['styleMetaColor'] ) ) $_meta[] = 'color: ' . esc_attr( $attributes['styleMetaColor'] );
if ( ! empty( $_meta ) ) $_css[] = "$sc .htm25-blog__card-author, $sc .htm25-blog__card-date, $sc .htm25-blog__card-read-time { " . implode( '; ', $_meta ) . '; }';

// Read More
$_rm = $_typo( $attributes['styleReadMoreTypography'] ?? null );
if ( ! empty( $attributes['styleReadMoreColor'] ) ) $_rm[] = 'color: ' . esc_attr( $attributes['styleReadMoreColor'] );
$_rule( ' .htm25-blog__card-read-more', $_rm );
if ( ! empty( $attributes['styleReadMoreHoverColor'] ) ) $_css[] = $sc . ' .htm25-blog__card-read-more:hover { color: ' . esc_attr( $attributes['styleReadMoreHoverColor'] ) . '; }';

$_css_out = implode( "\n", $_css );

// ── Headline highlight ────────────────────────────────────────────────────────
$headline_html = '';
if ( $show_header && $headline ) {
	if ( $headline_hl && strpos( $headline, $headline_hl ) !== false ) {
		$headline_html = str_replace(
			esc_html( $headline_hl ),
			'<span class="htm25-blog__headline-accent">' . esc_html( $headline_hl ) . '</span>',
			esc_html( $headline )
		);
	} else {
		$headline_html = esc_html( $headline );
	}
}

// ── WP_Query ─────────────────────────────────────────────────────────────────
$order   = 'DESC';
$orderby = 'date';
if ( $order_by_raw === 'date_a' ) {
	$orderby = 'date';
	$order   = 'ASC';
} elseif ( $order_by_raw === 'title' ) {
	$orderby = 'title';
	$order   = 'ASC';
} elseif ( $order_by_raw === 'rand' ) {
	$orderby = 'rand';
} elseif ( $order_by_raw === 'modified' ) {
	$orderby = 'modified';
}

$query_args = [
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => $posts_per_page,
	'orderby'        => $orderby,
	'order'          => $order,
	'no_found_rows'  => true,
];

if ( $category_id > 0 ) {
	$query_args['cat'] = $category_id;
}

$query = new WP_Query( $query_args );

// ── Card renderer (closure prevents redeclare) ────────────────────────────────
$render_post_card = function( $post, $index ) use (
	$layout, $show_image, $show_category, $show_author, $show_date,
	$show_read_time, $show_excerpt, $excerpt_length, $show_read_more, $read_more_text
) {
	$post_id   = $post->ID;
	$permalink = get_permalink( $post_id );
	$title     = get_the_title( $post_id );
	$is_hero   = ( $layout === 'featured' && $index === 0 );

	$word_count = str_word_count( wp_strip_all_tags( $post->post_content ) );
	$read_mins  = max( 1, (int) ceil( $word_count / 200 ) );

	$cats     = get_the_category( $post_id );
	$cat_name = ! empty( $cats ) ? $cats[0]->name : '';
	$cat_url  = ! empty( $cats ) ? get_category_link( $cats[0]->term_id ) : '';

	$author_id     = $post->post_author;
	$author_name   = get_the_author_meta( 'display_name', $author_id );
	$author_avatar = get_avatar_url( $author_id, [ 'size' => 40 ] );

	$excerpt = '';
	if ( $show_excerpt ) {
		if ( $post->post_excerpt ) {
			$excerpt = wp_trim_words( $post->post_excerpt, $excerpt_length, '…' );
		} else {
			$excerpt = wp_trim_words( wp_strip_all_tags( $post->post_content ), $excerpt_length, '…' );
		}
	}

	$img_size = $is_hero ? 'large' : 'medium_large';
	$thumb    = $show_image ? get_the_post_thumbnail( $post_id, $img_size ) : '';

	$card_class = 'htm25-blog__card' . ( $is_hero ? ' htm25-blog__card--hero' : '' );
	?>
	<article class="<?php echo esc_attr( $card_class ); ?>" role="listitem">

		<?php if ( $show_image ) : ?>
		<a href="<?php echo esc_url( $permalink ); ?>" class="htm25-blog__card-image-link" tabindex="-1" aria-hidden="true">
			<div class="htm25-blog__card-image-wrap<?php echo ! $thumb ? ' htm25-blog__card-image-wrap--placeholder' : ''; ?>">
				<?php if ( $thumb ) : ?>
					<?php echo $thumb; // phpcs:ignore ?>
				<?php else : ?>
					<svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.5"/>
						<circle cx="8.5" cy="8.5" r="1.5" stroke="currentColor" stroke-width="1.5"/>
						<path d="M21 15L16 10L9 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				<?php endif; ?>
			</div>
		</a>
		<?php endif; ?>

		<div class="htm25-blog__card-body">

			<?php if ( ( $show_category && $cat_name ) || $show_read_time ) : ?>
			<div class="htm25-blog__card-meta-top">
				<?php if ( $show_category && $cat_name ) : ?>
				<a href="<?php echo esc_url( $cat_url ); ?>" class="htm25-blog__card-category">
					<?php echo esc_html( $cat_name ); ?>
				</a>
				<?php endif; ?>
				<?php if ( $show_read_time ) : ?>
				<span class="htm25-blog__card-read-time">
					<?php echo esc_html( $read_mins ) . esc_html__( ' min read', 'ht-mega-for-elementor' ); ?>
				</span>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<h3 class="htm25-blog__card-title">
				<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
			</h3>

			<?php if ( $show_excerpt && $excerpt ) : ?>
			<p class="htm25-blog__card-excerpt"><?php echo esc_html( $excerpt ); ?></p>
			<?php endif; ?>

			<footer class="htm25-blog__card-footer">
				<?php if ( $show_author || $show_date ) : ?>
				<div class="htm25-blog__card-byline">
					<?php if ( $show_author ) : ?>
					<img src="<?php echo esc_url( $author_avatar ); ?>"
					     alt="<?php echo esc_attr( $author_name ); ?>"
					     class="htm25-blog__card-avatar"
					     width="28" height="28" loading="lazy" />
					<span class="htm25-blog__card-author"><?php echo esc_html( $author_name ); ?></span>
					<?php endif; ?>
					<?php if ( $show_author && $show_date ) : ?>
					<span class="htm25-blog__card-byline-sep" aria-hidden="true">·</span>
					<?php endif; ?>
					<?php if ( $show_date ) : ?>
					<time class="htm25-blog__card-date" datetime="<?php echo esc_attr( get_the_date( 'c', $post_id ) ); ?>">
						<?php echo esc_html( get_the_date( '', $post_id ) ); ?>
					</time>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<?php if ( $show_read_more ) : ?>
				<a href="<?php echo esc_url( $permalink ); ?>"
				   class="htm25-blog__card-read-more"
				   aria-label="<?php echo esc_attr( $read_more_text . ': ' . $title ); ?>">
					<?php echo esc_html( $read_more_text ); ?>
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</a>
				<?php endif; ?>
			</footer>

		</div><!-- .htm25-blog__card-body -->

	</article>
	<?php
};
?>
<?php if ( $_css_out ) : ?><style><?php echo $_css_out; // phpcs:ignore WordPress.Security.EscapeOutput ?></style><?php endif; ?>
<div class="htmega-block-<?php echo esc_attr( $block_id ); ?>">
<div class="htm25-style--<?php echo esc_attr( $design_style ); ?>">
	<section class="htm25-blog htm25-blog--<?php echo esc_attr( $layout ); ?>">

		<?php if ( in_array( $design_style, [ 'glass', 'aurora' ], true ) ) : ?>
		<div class="htm25-blog__bg-blobs" aria-hidden="true">
			<div class="htm25-blog__blob htm25-blog__blob--1"></div>
			<div class="htm25-blog__blob htm25-blog__blob--2"></div>
		</div>
		<?php endif; ?>

		<div class="htm25-blog__inner">

			<?php if ( $show_header && ( $label_text || $headline_html || $description ) ) : ?>
			<header class="htm25-blog__header">
				<?php if ( $show_label && $label_text ) : ?>
				<p class="htm25-blog__section-label">
					<span><?php echo esc_html( $label_text ); ?></span>
				</p>
				<?php endif; ?>

				<?php if ( $headline_html ) : ?>
				<<?php echo $headline_tag; // phpcs:ignore ?> class="htm25-blog__headline"><?php echo $headline_html; // phpcs:ignore ?></<?php echo $headline_tag; // phpcs:ignore ?>>
				<?php endif; ?>

				<?php if ( $description ) : ?>
				<p class="htm25-blog__description"><?php echo esc_html( $description ); ?></p>
				<?php endif; ?>
			</header>
			<?php endif; ?>

			<?php if ( $query->have_posts() ) : ?>
			<div class="htm25-blog__grid htm25-blog__grid--cols-<?php echo esc_attr( $columns ); ?>"
			     role="list">
				<?php
				$index = 0;
				while ( $query->have_posts() ) :
					$query->the_post();
					$render_post_card( get_post(), $index );
					$index++;
				endwhile;
				wp_reset_postdata();
				?>
			</div>
			<?php else : ?>
			<div class="htm25-blog__empty">
				<p><?php esc_html_e( 'No posts found. Publish some posts to see them here.', 'ht-mega-for-elementor' ); ?></p>
			</div>
			<?php endif; ?>

		</div><!-- .htm25-blog__inner -->
	</section><!-- .htm25-blog -->
</div><!-- .htm25-style -->
</div><!-- /.htmega-block-scope -->
