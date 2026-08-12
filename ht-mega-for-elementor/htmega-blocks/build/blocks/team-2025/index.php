<?php
/**
 * HT Mega 2026 — Team Section Block
 * Server-side renderer for htmega/team-2025.
 *
 * @package HT_Mega
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$attributes = $settings; // render callback provides $settings

// ── Attribute extraction ──────────────────────────────────────────────────────
$design_style  = isset( $attributes['designStyle'] )     ? sanitize_html_class( $attributes['designStyle'] )  : 'bento';
$layout        = isset( $attributes['layout'] )          ? sanitize_html_class( $attributes['layout'] )       : 'grid';
$columns       = isset( $attributes['teamColumns'] )     ? (int) $attributes['teamColumns']                   : 3;
$members       = isset( $attributes['teamMembers'] )     ? $attributes['teamMembers']                        : [];

$show_label    = ! empty( $attributes['showSectionLabel'] );
$label_text    = isset( $attributes['sectionLabelText'] ) ? esc_html( $attributes['sectionLabelText'] )       : '';
$headline      = isset( $attributes['headline'] )         ? esc_html( $attributes['headline'] )               : '';
$headline_hl   = isset( $attributes['headlineHighlight'] ) ? esc_html( $attributes['headlineHighlight'] )     : '';
$headline_tag  = isset( $attributes['headlineTag'] )      ? tag_escape( $attributes['headlineTag'] )          : 'h2';
$description   = isset( $attributes['description'] )      ? esc_html( $attributes['description'] )            : '';

// ── Headline highlight ────────────────────────────────────────────────────────
$headline_html = '';
if ( $headline ) {
	if ( $headline_hl && strpos( $headline, $headline_hl ) !== false ) {
		$headline_html = str_replace(
			esc_html( $headline_hl ),
			'<span class="htm25-team__headline-accent">' . esc_html( $headline_hl ) . '</span>',
			esc_html( $headline )
		);
	} else {
		$headline_html = esc_html( $headline );
	}
}

// ── Dynamic CSS (mirrors buildTeamCss in edit.js) ────────────
$block_id = isset( $attributes['blockUniqId'] ) ? sanitize_html_class( $attributes['blockUniqId'] ) : uniqid( 'htm25-team-' );
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
if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-team { ' . implode( '; ', $_sec ) . '; }';
if ( ! empty( $attributes['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-team__inner { max-width: ' . esc_attr( $attributes['styleContainerMaxWidth'] ) . '; }';

// Headline
$_hl = array_merge( $_typo( $attributes['styleHeadlineTypography'] ?? null ), $_dim( $attributes['styleHeadlineMargin'] ?? null, 'margin' ) );
if ( ! empty( $attributes['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $attributes['styleHeadlineColor'] );
$_rule( ' .htm25-team__headline', $_hl );
if ( ! empty( $attributes['styleHeadlineHighlightColor'] )   ) $_css[] = $sc . ' .htm25-team__headline-accent { background-color: ' . esc_attr( $attributes['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
if ( ! empty( $attributes['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-team__headline-accent { background: ' . esc_attr( $attributes['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

// Description
$_desc = $_typo( $attributes['styleDescTypography'] ?? null );
if ( ! empty( $attributes['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $attributes['styleDescColor'] );
$_rule( ' .htm25-team__description', $_desc );

// Card
$_card = array_merge( $_border( $attributes['cardBorderType'] ?? null, $attributes['cardBorderWidth'] ?? null, $attributes['cardBorderColor'] ?? null ), $_radius( $attributes['styleCardBorderRadius'] ?? null ) );
if ( ! empty( $attributes['styleCardBgColor'] ) ) $_card[] = 'background-color: ' . esc_attr( $attributes['styleCardBgColor'] );
$_csw = $_shadow( $attributes['styleCardShadow'] ?? null ); if ( $_csw ) $_card[] = $_csw;
$_rule( ' .htm25-team__card', $_card );

// Member Name
$_mn = $_typo( $attributes['styleMemberNameTypography'] ?? null );
if ( ! empty( $attributes['styleMemberNameColor'] ) ) $_mn[] = 'color: ' . esc_attr( $attributes['styleMemberNameColor'] );
$_rule( ' .htm25-team__card-name', $_mn );

// Member Role
$_mr = $_typo( $attributes['styleMemberRoleTypography'] ?? null );
if ( ! empty( $attributes['styleMemberRoleColor'] ) ) $_mr[] = 'color: ' . esc_attr( $attributes['styleMemberRoleColor'] );
$_rule( ' .htm25-team__card-role', $_mr );

// Department Tag
$_dept = array_merge( $_typo( $attributes['styleDeptTagTypography'] ?? null ), $_radius( $attributes['styleDeptTagRadius'] ?? null ) );
if ( ! empty( $attributes['styleDeptTagColor'] )   ) $_dept[] = 'color: ' . esc_attr( $attributes['styleDeptTagColor'] );
if ( ! empty( $attributes['styleDeptTagBgColor'] ) ) $_dept[] = 'background-color: ' . esc_attr( $attributes['styleDeptTagBgColor'] );
$_rule( ' .htm25-team__card-department', $_dept );

// Social Icons — normal
if ( ! empty( $attributes['styleSocialIconColor'] ) ) {
	$_ic = esc_attr( $attributes['styleSocialIconColor'] );
	$_css[] = "$sc .htm25-team__card-social .htm25-team__card-social-link i, $sc .htm25-team__card-social-overlay .htm25-team__card-social-link i { color: $_ic; }";
	$_css[] = "$sc .htm25-team__card-social .htm25-team__card-social-link svg, $sc .htm25-team__card-social-overlay .htm25-team__card-social-link svg { color: $_ic; }";
	$_css[] = "$sc .htm25-team__card-social .htm25-team__card-social-link svg path, $sc .htm25-team__card-social-overlay .htm25-team__card-social-link svg path { fill: $_ic; }";
}

// Social Icons — hover
if ( ! empty( $attributes['styleSocialIconHoverColor'] ) ) {
	$_hc = esc_attr( $attributes['styleSocialIconHoverColor'] );
	$_css[] = "$sc .htm25-team__card-social .htm25-team__card-social-link:hover i, $sc .htm25-team__card-social-overlay .htm25-team__card-social-link:hover i { color: $_hc; }";
	$_css[] = "$sc .htm25-team__card-social .htm25-team__card-social-link:hover svg, $sc .htm25-team__card-social-overlay .htm25-team__card-social-link:hover svg { color: $_hc; }";
	$_css[] = "$sc .htm25-team__card-social .htm25-team__card-social-link:hover svg path, $sc .htm25-team__card-social-overlay .htm25-team__card-social-link:hover svg path { fill: $_hc; }";
}

// Social Icons — size
if ( ! empty( $attributes['styleSocialIconSize'] ) ) {
	$_sz = esc_attr( $attributes['styleSocialIconSize'] );
	$_css[] = "$sc .htm25-team__card-social .htm25-team__card-social-link svg, $sc .htm25-team__card-social-overlay .htm25-team__card-social-link svg { width: {$_sz}px; height: {$_sz}px; }";
	$_css[] = "$sc .htm25-team__card-social .htm25-team__card-social-link i, $sc .htm25-team__card-social-overlay .htm25-team__card-social-link i { font-size: {$_sz}px; }";
}

// Social Icons — circle background
if ( ! empty( $attributes['styleSocialIconBgColor'] ) ) {
	$_bg = esc_attr( $attributes['styleSocialIconBgColor'] );
	$_css[] = "$sc .htm25-team__card-social .htm25-team__card-social-link, $sc .htm25-team__card-social-overlay .htm25-team__card-social-link { background-color: $_bg; }";
}

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

// ── Social SVG icons ─────────────────────────────────────────────────────────
$icon_linkedin = '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>';
$icon_twitter  = '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L2.03 2.25H8.8l4.259 5.631 5.185-5.631zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77z"/></svg>';
$icon_github   = '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M12 2A10 10 0 0 0 2 12c0 4.42 2.87 8.17 6.84 9.5.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34-.46-1.16-1.11-1.47-1.11-1.47-.91-.62.07-.6.07-.6 1 .07 1.53 1.03 1.53 1.03.87 1.52 2.34 1.07 2.91.83.09-.65.35-1.09.63-1.34-2.22-.25-4.55-1.11-4.55-4.92 0-1.11.38-2 1.03-2.71-.1-.25-.45-1.29.1-2.64 0 0 .84-.27 2.75 1.02.79-.22 1.65-.33 2.5-.33.85 0 1.71.11 2.5.33 1.91-1.29 2.75-1.02 2.75-1.02.55 1.35.2 2.39.1 2.64.65.71 1.03 1.6 1.03 2.71 0 3.82-2.34 4.66-4.57 4.91.36.31.69.92.69 1.85V21c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12A10 10 0 0 0 12 2z"/></svg>';

// ── Card renderer (closure prevents redeclare on multiple blocks) ────────────
$render_member_card = function( $member, $index ) use ( $layout, $icon_linkedin, $icon_twitter, $icon_github ) {
	$name        = isset( $member['memberName'] )       ? esc_html( $member['memberName'] )       : '';
	$role        = isset( $member['memberRole'] )       ? esc_html( $member['memberRole'] )        : '';
	$bio         = isset( $member['memberBio'] )        ? esc_html( $member['memberBio'] )         : '';
	$department  = isset( $member['memberDepartment'] ) ? esc_html( $member['memberDepartment'] )  : '';
	$photo_url   = isset( $member['memberPhotoUrl'] )   ? esc_url( $member['memberPhotoUrl'] )     : '';
	$photo_alt   = isset( $member['memberPhotoAlt'] )   ? esc_attr( $member['memberPhotoAlt'] )    : $name;
	$is_featured = ! empty( $member['isFeatured'] );

	$li_url = isset( $member['socialLinkedin'] ) ? esc_url( $member['socialLinkedin'] ) : '';
	$tw_url = isset( $member['socialTwitter'] )  ? esc_url( $member['socialTwitter'] )  : '';
	$gh_url = isset( $member['socialGithub'] )   ? esc_url( $member['socialGithub'] )   : '';

	$card_class = implode( ' ', array_filter( [
		'htm25-team__card',
		$is_featured          ? 'htm25-team__card--featured' : '',
		$layout === 'featured' && $index === 0 ? 'htm25-team__card--hero' : '',
	] ) );

	// Initials fallback
	$initials = '';
	if ( $name ) {
		$parts = explode( ' ', wp_strip_all_tags( $name ) );
		foreach ( $parts as $part ) {
			$initials .= mb_substr( $part, 0, 1 );
		}
		$initials = mb_strtoupper( mb_substr( $initials, 0, 2 ) );
	}

	$has_social = $li_url || $tw_url || $gh_url;
	?>
	<article class="<?php echo esc_attr( $card_class ); ?>" role="listitem">

		<div class="htm25-team__card-photo-wrap">
			<?php if ( $photo_url ) : ?>
			<img src="<?php echo esc_url( $photo_url ); ?>"
			     alt="<?php echo esc_attr( $photo_alt ); ?>"
			     class="htm25-team__card-photo"
			     loading="lazy" />
			<?php else : ?>
			<div class="htm25-team__card-photo-placeholder" aria-hidden="true">
				<span><?php echo esc_html( $initials ); ?></span>
			</div>
			<?php endif; ?>

			<?php if ( $has_social && $layout !== 'list' ) : ?>
			<div class="htm25-team__card-social-overlay" aria-hidden="true">
				<?php if ( $li_url ) : ?>
				<a href="<?php echo esc_url( $li_url ); ?>" target="_blank" rel="noopener noreferrer"
				   class="htm25-team__card-social-link">
					<?php echo $icon_linkedin; // phpcs:ignore ?>
				</a>
				<?php endif; ?>
				<?php if ( $tw_url ) : ?>
				<a href="<?php echo esc_url( $tw_url ); ?>" target="_blank" rel="noopener noreferrer"
				   class="htm25-team__card-social-link">
					<?php echo $icon_twitter; // phpcs:ignore ?>
				</a>
				<?php endif; ?>
				<?php if ( $gh_url ) : ?>
				<a href="<?php echo esc_url( $gh_url ); ?>" target="_blank" rel="noopener noreferrer"
				   class="htm25-team__card-social-link">
					<?php echo $icon_github; // phpcs:ignore ?>
				</a>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div><!-- .htm25-team__card-photo-wrap -->

		<div class="htm25-team__card-body">
			<?php if ( $department ) : ?>
			<span class="htm25-team__card-department"><?php echo esc_html( $department ); ?></span>
			<?php endif; ?>

			<h3 class="htm25-team__card-name"><?php echo esc_html( $name ); ?></h3>

			<?php if ( $role ) : ?>
			<p class="htm25-team__card-role"><?php echo esc_html( $role ); ?></p>
			<?php endif; ?>

			<?php if ( $bio ) : ?>
			<p class="htm25-team__card-bio"><?php echo esc_html( $bio ); ?></p>
			<?php endif; ?>

			<?php if ( $has_social ) : ?>
			<div class="htm25-team__card-social" aria-label="<?php echo esc_attr( $name ) . ' social links'; ?>">
				<?php if ( $li_url ) : ?>
				<a href="<?php echo esc_url( $li_url ); ?>" target="_blank" rel="noopener noreferrer"
				   class="htm25-team__card-social-link" aria-label="<?php echo esc_attr( wp_strip_all_tags( $name ) ) . ' on LinkedIn'; ?>">
					<?php echo $icon_linkedin; // phpcs:ignore ?>
				</a>
				<?php endif; ?>
				<?php if ( $tw_url ) : ?>
				<a href="<?php echo esc_url( $tw_url ); ?>" target="_blank" rel="noopener noreferrer"
				   class="htm25-team__card-social-link" aria-label="<?php echo esc_attr( wp_strip_all_tags( $name ) ) . ' on X'; ?>">
					<?php echo $icon_twitter; // phpcs:ignore ?>
				</a>
				<?php endif; ?>
				<?php if ( $gh_url ) : ?>
				<a href="<?php echo esc_url( $gh_url ); ?>" target="_blank" rel="noopener noreferrer"
				   class="htm25-team__card-social-link" aria-label="<?php echo esc_attr( wp_strip_all_tags( $name ) ) . ' on GitHub'; ?>">
					<?php echo $icon_github; // phpcs:ignore ?>
				</a>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div><!-- .htm25-team__card-body -->

	</article>
	<?php
};
?>
<?php if ( $_css_out ) : ?><style><?php echo $_css_out; // phpcs:ignore WordPress.Security.EscapeOutput ?></style><?php endif; ?>
<div class="htmega-block-<?php echo esc_attr( $block_id ); ?>">
<div class="htm25-style--<?php echo esc_attr( $design_style ); ?>">
	<section class="htm25-team htm25-team--<?php echo esc_attr( $layout ); ?>">

		<?php if ( in_array( $design_style, [ 'glass', 'aurora' ], true ) ) : ?>
		<div class="htm25-team__bg-blobs" aria-hidden="true">
			<div class="htm25-team__blob htm25-team__blob--1"></div>
			<div class="htm25-team__blob htm25-team__blob--2"></div>
		</div>
		<?php endif; ?>

		<div class="htm25-team__inner">

			<?php if ( $show_label && $label_text || $headline || $description ) : ?>
			<header class="htm25-team__header">
				<?php if ( $show_label && $label_text ) : ?>
				<p class="htm25-team__section-label">
					<span><?php echo esc_html( $label_text ); ?></span>
				</p>
				<?php endif; ?>

				<?php if ( $headline_html ) : ?>
				<<?php echo $headline_tag; // phpcs:ignore ?> class="htm25-team__headline"><?php echo $headline_html; // phpcs:ignore ?></<?php echo $headline_tag; // phpcs:ignore ?>>
				<?php endif; ?>

				<?php if ( $description ) : ?>
				<p class="htm25-team__description"><?php echo esc_html( $description ); ?></p>
				<?php endif; ?>
			</header>
			<?php endif; ?>

			<?php if ( ! empty( $members ) ) : ?>
			<div class="htm25-team__grid htm25-team__grid--cols-<?php echo esc_attr( $columns ); ?>"
			     role="list">
				<?php foreach ( $members as $index => $member ) : ?>
					<?php $render_member_card( $member, $index ); ?>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>

		</div><!-- .htm25-team__inner -->
	</section><!-- .htm25-team -->
</div><!-- .htm25-style -->
</div><!-- /.htmega-block-scope -->
