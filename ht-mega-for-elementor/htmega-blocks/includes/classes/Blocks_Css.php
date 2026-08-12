<?php
namespace HtMegaBlocks;

if ( ! defined( 'ABSPATH' ) ) exit;

class Blocks_Css {

    public static function build_block_css( $block_name, $attrs ) {
        switch ( $block_name ) {
            case 'htmega/hero-2025':         return self::hero_css( $attrs );
            case 'htmega/about-2025':        return self::about_css( $attrs );
            case 'htmega/services-2025':     return self::services_css( $attrs );
            case 'htmega/testimonials-2025': return self::testimonials_css( $attrs );
            case 'htmega/pricing-2025':      return self::pricing_css( $attrs );
            case 'htmega/stats-2025':        return self::stats_css( $attrs );
            case 'htmega/cta-2025':          return self::cta_css( $attrs );
            case 'htmega/team-2025':         return self::team_css( $attrs );
            case 'htmega/faq-2025':          return self::faq_css( $attrs );
        }
        return '';
    }

    public static function build_block_script( $block_name, $attrs ) {
        $uid = $attrs['blockUniqId'] ?? '';
        if ( $block_name === 'htmega/stats-2025' && ! empty( $attrs['enableCountup'] ) ) {
            $uid_js = esc_js( $uid );
            return '<script>
( function () {
	var section = document.getElementById( \'htm25-stats-' . $uid_js . '\' );
	if ( ! section ) return;
	var motionOK = ! window.matchMedia( \'(prefers-reduced-motion: reduce)\' ).matches;
	var numbers  = section.querySelectorAll( \'.htm25-stats__item-number[data-target]\' );
	if ( ! motionOK ) {
		numbers.forEach( function( el ) { el.textContent = el.getAttribute( \'data-target\' ); } );
		return;
	}
	var animated = false;
	function runCountUp() {
		if ( animated ) return;
		animated = true;
		numbers.forEach( function( el ) {
			var targetStr = el.getAttribute( \'data-target\' );
			var target    = parseFloat( targetStr );
			if ( isNaN( target ) ) { el.textContent = targetStr; return; }
			var isFloat  = targetStr.indexOf( \'.\' ) !== -1;
			var decimals = isFloat ? ( targetStr.split( \'.\' )[ 1 ] || \'\' ).length : 0;
			var duration = 2000;
			var start    = null;
			function step( ts ) {
				if ( ! start ) start = ts;
				var progress = Math.min( ( ts - start ) / duration, 1 );
				var ease     = 1 - Math.pow( 1 - progress, 3 );
				var current  = ease * target;
				el.textContent = isFloat ? current.toFixed( decimals ) : Math.floor( current ).toLocaleString();
				if ( progress < 1 ) { requestAnimationFrame( step ); } else {
					el.textContent = isFloat ? target.toFixed( decimals ) : target.toLocaleString();
				}
			}
			requestAnimationFrame( step );
		} );
	}
	if ( \'IntersectionObserver\' in window ) {
		var observer = new IntersectionObserver( function( entries ) {
			entries.forEach( function( entry ) { if ( entry.isIntersecting ) { runCountUp(); observer.disconnect(); } } );
		}, { threshold: 0.25 } );
		observer.observe( section );
	} else { runCountUp(); }
} )();
</script>';
        }
        if ( $block_name === 'htmega/faq-2025' ) {
            $uid_js = esc_js( $uid );
            return '<script>
( function () {
	var wrap = document.querySelector( \'.htmega-block-' . $uid_js . '\' );
	if ( ! wrap ) return;

	var duration     = 300;
	var reduceMotion = window.matchMedia( \'(prefers-reduced-motion: reduce)\' ).matches;

	wrap.querySelectorAll( \'.htm25-faq__item\' ).forEach( function ( details ) {
		var summary = details.querySelector( \'.htm25-faq__item-summary\' );
		var body    = details.querySelector( \'.htm25-faq__item-body\' );
		if ( ! summary || ! body ) return;

		var canAnimate = ! reduceMotion && typeof body.animate === \'function\';
		if ( ! canAnimate ) return;

		var anim = null;

		function currentHeight() {
			return body.getBoundingClientRect().height;
		}

		function openItem() {
			if ( anim ) anim.cancel();
			var from = currentHeight();
			details.setAttribute( \'open\', \'\' );
			var to = body.scrollHeight;
			anim = body.animate(
				[ { height: from + \'px\' }, { height: to + \'px\' } ],
				{ duration: duration, easing: \'ease\' }
			);
			anim.onfinish = anim.oncancel = function () {
				body.style.height = \'\';
				anim = null;
			};
		}

		function closeItem() {
			if ( anim ) anim.cancel();
			var from = currentHeight();
			anim = body.animate(
				[ { height: from + \'px\' }, { height: \'0px\' } ],
				{ duration: duration, easing: \'ease\' }
			);
			anim.onfinish = function () {
				details.removeAttribute( \'open\' );
				body.style.height = \'\';
				anim = null;
			};
			anim.oncancel = function () {
				body.style.height = \'\';
				anim = null;
			};
		}

		summary.addEventListener( \'click\', function ( e ) {
			e.preventDefault();
			if ( details.hasAttribute( \'open\' ) ) {
				closeItem();
			} else {
				openItem();
			}
		} );
	} );
} )();
</script>';
        }
        if ( $block_name === 'htmega/pricing-2025' && ! empty( $attrs['showBillingToggle'] ) ) {
            $uid_js = esc_js( $uid );
            return '<script>
( function () {
	var wrap = document.getElementById( \'htm25-pricing-' . $uid_js . '\' );
	var cb   = wrap && wrap.querySelector( \'.htm25-pricing__toggle-cb\' );
	if ( ! cb ) return;
	cb.addEventListener( \'change\', function () {
		wrap.classList.toggle( \'htm25-pricing--annual\', this.checked );
		this.setAttribute( \'aria-checked\', this.checked ? \'true\' : \'false\' );
	} );
} )();
</script>';
        }
        return '';
    }

    // ── Shared helpers ────────────────────────────────────────────

    /**
     * Validate a numeric CSS value + unit pair before interpolating it
     * into a generated stylesheet. Returns '' for anything non-numeric,
     * so untrusted values can never break out of the property they're
     * assigned to (CSS/style-tag injection).
     */
    private static function _num( $value, $unit = 'px' ) {
        if ( ! is_numeric( $value ) ) return '';
        $allowed = [ 'px', 'em', 'rem', '%', 'vh', 'vw', 'vmin', 'vmax', 'ch', 'ex', 'pt' ];
        $unit    = in_array( $unit, $allowed, true ) ? $unit : 'px';
        return ( $value + 0 ) . $unit;
    }

    private static function _border( $type, $width, $color ) {
        if ( ! $type || $type === 'none' ) return [];
        $r = [ 'border-style: ' . esc_attr( $type ) ];
        if ( $width && is_array( $width ) ) {
            $u = $width['unit'] ?? 'px';
            if ( isset( $width['link'] ) && $width['link'] === 'yes' && isset( $width['top'] ) ) {
                $val = self::_num( $width['top'], $u );
                if ( $val !== '' ) $r[] = 'border-width: ' . $val;
            } else {
                foreach ( [ 'top', 'right', 'bottom', 'left' ] as $_s ) {
                    if ( ! empty( $width[ $_s ] ) ) {
                        $val = self::_num( $width[ $_s ], $u );
                        if ( $val !== '' ) $r[] = "border-{$_s}-width: {$val}";
                    }
                }
            }
        }
        if ( $color ) $r[] = 'border-color: ' . esc_attr( $color );
        return $r;
    }

    private static function _radius( $rv ) {
        if ( ! $rv || ! is_array( $rv ) ) return [];
        $u   = $rv['unit'] ?? 'px';
        $map = [ 'top' => 'top-left', 'right' => 'top-right', 'bottom' => 'bottom-right', 'left' => 'bottom-left' ];
        $r   = [];
        foreach ( $map as $_s => $corner ) {
            if ( isset( $rv[ $_s ] ) && $rv[ $_s ] !== '' ) {
                $val = self::_num( $rv[ $_s ], $u );
                if ( $val !== '' ) $r[] = "border-{$corner}-radius: {$val}";
            }
        }
        return $r;
    }

    private static function _shadow( $s ) {
        if ( ! $s || ! is_array( $s ) || empty( $s['color'] ) ) return '';
        $i  = ! empty( $s['inset'] ) ? 'inset ' : '';
        $h  = is_numeric( $s['horizontal'] ?? null ) ? floatval( $s['horizontal'] ) : 0;
        $v  = is_numeric( $s['vertical']   ?? null ) ? floatval( $s['vertical'] )   : 0;
        $b  = is_numeric( $s['blur']       ?? null ) ? floatval( $s['blur'] )       : 0;
        $sp = is_numeric( $s['spread']     ?? null ) ? floatval( $s['spread'] )     : 0;
        return 'box-shadow: ' . $i . $h . 'px ' . $v . 'px ' . $b . 'px ' . $sp . 'px ' . esc_attr( $s['color'] );
    }

    private static function _gf_imports( $attrs ) {
        $sys     = '/^(sans-serif|serif|serif-alt|monospace)$/i';
        $imports = [];
        foreach ( $attrs as $val ) {
            if ( ! is_array( $val ) || empty( $val['family'] ) ) continue;
            if ( preg_match( $sys, $val['family'] ) ) continue;
            $enc = rawurlencode( $val['family'] );
            $imports[ $val['family'] ] = "@import url('https://fonts.googleapis.com/css?family={$enc}:400,400italic,600,600italic,700,700italic&display=swap');";
        }
        return $imports ? implode( ' ', $imports ) . "\n" : '';
    }

    private static function _typo( $t ) {
        if ( ! $t || ! is_array( $t ) ) return [];
        $r = [];
        if ( ! empty( $t['family'] ) ) $r[] = "font-family: '" . esc_attr( $t['family'] ) . "', sans-serif";
        if ( ! empty( $t['size'] ) ) {
            $val = self::_num( $t['size'], $t['sizeUnit'] ?? 'px' );
            if ( $val !== '' ) $r[] = 'font-size: ' . $val;
        }
        if ( ! empty( $t['weight'] ) ) $r[] = 'font-weight: ' . esc_attr( $t['weight'] );
        if ( isset( $t['lineHeight'] ) && is_numeric( $t['lineHeight'] ) ) $r[] = 'line-height: ' . ( $t['lineHeight'] + 0 );
        if ( isset( $t['letterSpacing'] ) && is_numeric( $t['letterSpacing'] ) ) $r[] = 'letter-spacing: ' . ( $t['letterSpacing'] + 0 ) . 'px';
        if ( ! empty( $t['transform'] ) ) $r[] = 'text-transform: ' . esc_attr( $t['transform'] );
        return $r;
    }

    private static function _dim( $dim, $prop ) {
        if ( ! $dim || ! is_array( $dim ) ) return [];
        $d = isset( $dim['desktop'] ) ? $dim['desktop'] : $dim;
        $u = $d['unit'] ?? $dim['unit'] ?? 'px';
        $r = [];
        foreach ( [ 'top', 'right', 'bottom', 'left' ] as $_s ) {
            if ( isset( $d[ $_s ] ) && $d[ $_s ] !== '' ) {
                $val = self::_num( $d[ $_s ], $u );
                if ( $val !== '' ) $r[] = "{$prop}-{$_s}: {$val}";
            }
        }
        return $r;
    }

    private static function _rule( $sc, $sel, $rules, &$_css ) {
        if ( ! empty( $rules ) ) $_css[] = $sc . $sel . ' { ' . implode( '; ', $rules ) . '; }';
    }

    // ── Hero ─────────────────────────────────────────────────────

    private static function hero_css( $attrs ) {
        $sc   = '.htmega-block-' . ( $attrs['blockUniqId'] ?? 'x' );
        $_css = [];

        // Section
        $_sec = [];
        if ( ! empty( $attrs['styleAccentColor'] )       ) $_sec[] = '--htm25-accent-primary: '   . esc_attr( $attrs['styleAccentColor'] );
        if ( ! empty( $attrs['styleSectionBgColor'] )    ) $_sec[] = 'background-color: '         . esc_attr( $attrs['styleSectionBgColor'] );
        if ( ! empty( $attrs['styleSectionBgGradient'] ) ) { $_sec[] = 'background: ' . esc_attr( $attrs['styleSectionBgGradient'] ); $_sec[] = 'background-color: transparent'; }
        $_sec = array_merge( $_sec, self::_dim( $attrs['styleSectionPadding'] ?? null, 'padding' ), self::_border( $attrs['sectionBorderType'] ?? null, $attrs['sectionBorderWidth'] ?? null, $attrs['sectionBorderColor'] ?? null ), self::_radius( $attrs['styleSectionBorderRadius'] ?? null ) );
        $_sw = self::_shadow( $attrs['styleSectionShadow'] ?? null ); if ( $_sw ) $_sec[] = $_sw;
        if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-hero { ' . implode( '; ', $_sec ) . '; }';
        if ( ! empty( $attrs['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-hero__inner { max-width: ' . esc_attr( $attrs['styleContainerMaxWidth'] ) . '; }';

        // Headline
        $_hl = array_merge( self::_typo( $attrs['styleHeadlineTypography'] ?? null ), self::_dim( $attrs['styleHeadlineMargin'] ?? null, 'margin' ) );
        if ( ! empty( $attrs['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $attrs['styleHeadlineColor'] );
        self::_rule( $sc, ' .htm25-hero__headline', $_hl, $_css );
        if ( ! empty( $attrs['styleHeadlineHoverColor'] ) ) $_css[] = $sc . ' .htm25-hero__headline:hover { color: ' . esc_attr( $attrs['styleHeadlineHoverColor'] ) . '; transition: color 0.2s ease; }';
        if ( ! empty( $attrs['styleHeadlineHighlightColor'] )   ) $_css[] = $sc . ' .htm25-hero .htm25-hero__headline-accent { background-color: ' . esc_attr( $attrs['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
        if ( ! empty( $attrs['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-hero .htm25-hero__headline-accent { background: ' . esc_attr( $attrs['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

        // Description
        $_desc = self::_typo( $attrs['styleDescTypography'] ?? null );
        if ( ! empty( $attrs['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $attrs['styleDescColor'] );
        self::_rule( $sc, ' .htm25-hero__description', $_desc, $_css );

        // Badge
        $_badge = self::_typo( $attrs['styleBadgeTypography'] ?? null );
        if ( ! empty( $attrs['styleBadgeTextColor'] ) ) $_badge[] = 'color: '            . esc_attr( $attrs['styleBadgeTextColor'] );
        if ( ! empty( $attrs['styleBadgeBgColor'] )   ) $_badge[] = 'background-color: ' . esc_attr( $attrs['styleBadgeBgColor'] );
        if ( ! empty( $attrs['styleBadgeIconGap'] )   ) $_badge[] = 'gap: '              . absint( $attrs['styleBadgeIconGap'] ) . 'px';
        $_badge = array_merge( $_badge, self::_border( $attrs['badgeBorderType'] ?? null, $attrs['badgeBorderWidth'] ?? null, $attrs['badgeBorderColor'] ?? null ), self::_radius( $attrs['styleBadgeBorderRadius'] ?? null ) );
        self::_rule( $sc, ' .htm25-hero__badge', $_badge, $_css );
        if ( ! empty( $attrs['styleBadgeIconColor'] ) ) {
            $_ic = esc_attr( $attrs['styleBadgeIconColor'] );
            $_css[] = "$sc .htm25-hero__badge-icon i, $sc .htm25-hero__badge-icon span { color: $_ic; }";
            $_css[] = "$sc .htm25-hero__badge-icon svg { color: $_ic; }";
            $_css[] = "$sc .htm25-hero__badge-icon svg path { fill: $_ic; }";
        }
        if ( ! empty( $attrs['styleBadgeIconSize'] ) ) {
            $_sz = absint( $attrs['styleBadgeIconSize'] );
            $_css[] = "$sc .htm25-hero__badge-icon i, $sc .htm25-hero__badge-icon span { font-size: {$_sz}px; }";
            $_css[] = "$sc .htm25-hero__badge-icon svg { width: {$_sz}px; height: {$_sz}px; }";
        }

        // Buttons gap — 0 is valid (no gap); only skip when truly unset
        if ( isset( $attrs['styleBtnGap'] ) && is_numeric( $attrs['styleBtnGap'] ) ) {
            $_css[] = $sc . ' .htm25-hero__actions { gap: ' . floatval( $attrs['styleBtnGap'] ) . 'rem; }';
        }

        // Primary button - normal
        $_pb = self::_typo( $attrs['stylePrimaryBtnTypography'] ?? null );
        if ( ! empty( $attrs['stylePrimaryBtnBgColor'] )    ) { $_pb[] = 'background-color: ' . esc_attr( $attrs['stylePrimaryBtnBgColor'] ); $_pb[] = 'background-image: none'; }
        if ( ! empty( $attrs['stylePrimaryBtnBgGradient'] ) ) { $_pb[] = 'background: ' . esc_attr( $attrs['stylePrimaryBtnBgGradient'] ); $_pb[] = 'background-color: transparent'; }
        if ( ! empty( $attrs['stylePrimaryBtnTextColor'] )  ) $_pb[] = 'color: ' . esc_attr( $attrs['stylePrimaryBtnTextColor'] );
        $_pb  = array_merge( $_pb, self::_border( $attrs['primaryBtnBorderType'] ?? null, $attrs['primaryBtnBorderWidth'] ?? null, $attrs['primaryBtnBorderColor'] ?? null ), self::_radius( $attrs['stylePrimaryBtnBorderRadiusObj'] ?? null ) );
        $_pbs = self::_shadow( $attrs['stylePrimaryBtnShadow'] ?? null ); if ( $_pbs ) $_pb[] = $_pbs;
        self::_rule( $sc, ' .htm25-btn--primary', $_pb, $_css );

        // Primary button - hover
        $_pbh = [];
        if ( ! empty( $attrs['stylePrimaryBtnHoverBgGradient'] ) ) $_pbh[] = 'background: ' . esc_attr( $attrs['stylePrimaryBtnHoverBgGradient'] );
        elseif ( ! empty( $attrs['stylePrimaryBtnHoverBgColor'] ) ) $_pbh[] = 'background: ' . esc_attr( $attrs['stylePrimaryBtnHoverBgColor'] );
        if ( ! empty( $attrs['stylePrimaryBtnHoverTextColor'] ) ) $_pbh[] = 'color: ' . esc_attr( $attrs['stylePrimaryBtnHoverTextColor'] );
        $_pbh = array_merge( $_pbh, self::_border( $attrs['primaryBtnHoverBorderType'] ?? null, $attrs['primaryBtnHoverBorderWidth'] ?? null, $attrs['primaryBtnHoverBorderColor'] ?? null ) );
        self::_rule( $sc, ' .htm25-btn--primary:hover', $_pbh, $_css );

        // Secondary button - normal
        $_sb = self::_typo( $attrs['styleSecondaryBtnTypography'] ?? null );
        if ( ! empty( $attrs['styleSecondaryBtnBgGradient'] ) ) { $_sb[] = 'background: ' . esc_attr( $attrs['styleSecondaryBtnBgGradient'] ); }
        elseif ( ! empty( $attrs['styleSecondaryBtnBgColor'] ) ) { $_sb[] = 'background: ' . esc_attr( $attrs['styleSecondaryBtnBgColor'] ); }
        if ( ! empty( $attrs['styleSecondaryBtnTextColor'] ) ) $_sb[] = 'color: ' . esc_attr( $attrs['styleSecondaryBtnTextColor'] );
        $_sb = array_merge( $_sb, self::_border( $attrs['secondaryBtnBorderType'] ?? null, $attrs['secondaryBtnBorderWidth'] ?? null, $attrs['secondaryBtnBorderColor'] ?? null ) );
        if ( ! empty( $attrs['styleSecondaryBtnBorderColor'] ) && empty( $attrs['secondaryBtnBorderType'] ) ) {
            $_sb[] = 'border-color: ' . esc_attr( $attrs['styleSecondaryBtnBorderColor'] );
        }
        self::_rule( $sc, ' .htm25-btn--outline', $_sb, $_css );

        if ( ! empty( $attrs['styleSecondaryBtnTextColor'] ) ) {
            $_stc = esc_attr( $attrs['styleSecondaryBtnTextColor'] );
            $_css[] = "$sc .htm25-hero__play-icon, $sc .htm25-hero__play-icon i, $sc .htm25-hero__play-icon span { color: $_stc; }";
            $_css[] = "$sc .htm25-hero__play-icon svg { color: $_stc; }";
            $_css[] = "$sc .htm25-hero__play-icon svg path { fill: $_stc; }";
        }
        if ( ! empty( $attrs['styleIconCircleBgColor'] ) ) {
            $_css[] = $sc . ' .htm25-hero__play-icon { background-color: ' . esc_attr( $attrs['styleIconCircleBgColor'] ) . '; background-image: none; }';
        }
        if ( ! empty( $attrs['styleIconCircleColor'] ) ) {
            $_icc = esc_attr( $attrs['styleIconCircleColor'] );
            $_css[] = "$sc .htm25-hero__play-icon i, $sc .htm25-hero__play-icon span { color: $_icc; }";
            $_css[] = "$sc .htm25-hero__play-icon svg { color: $_icc; }";
            $_css[] = "$sc .htm25-hero__play-icon svg path { fill: $_icc; }";
        }

        // Secondary button - hover
        $_sbh = [];
        if ( ! empty( $attrs['styleSecondaryBtnHoverBgGradient'] ) ) $_sbh[] = 'background: ' . esc_attr( $attrs['styleSecondaryBtnHoverBgGradient'] );
        elseif ( ! empty( $attrs['styleSecondaryBtnHoverBgColor'] ) ) $_sbh[] = 'background: ' . esc_attr( $attrs['styleSecondaryBtnHoverBgColor'] );
        if ( ! empty( $attrs['styleSecondaryBtnHoverTextColor'] ) ) $_sbh[] = 'color: ' . esc_attr( $attrs['styleSecondaryBtnHoverTextColor'] );
        $_sbh = array_merge( $_sbh, self::_border( $attrs['secondaryBtnHoverBorderType'] ?? null, $attrs['secondaryBtnHoverBorderWidth'] ?? null, $attrs['secondaryBtnHoverBorderColor'] ?? null ) );
        self::_rule( $sc, ' .htm25-btn--outline:hover', $_sbh, $_css );

        // Social proof
        $_sp = self::_typo( $attrs['styleSocialProofTypography'] ?? null );
        if ( ! empty( $attrs['styleSocialProofTextColor'] ) ) $_sp[] = 'color: ' . esc_attr( $attrs['styleSocialProofTextColor'] );
        self::_rule( $sc, ' .htm25-hero__social-text', $_sp, $_css );
        $_rt = self::_typo( $attrs['styleRatingTypography'] ?? null );
        if ( ! empty( $attrs['styleRatingColor'] ) ) $_rt[] = 'color: ' . esc_attr( $attrs['styleRatingColor'] );
        self::_rule( $sc, ' .htm25-hero__rating', $_rt, $_css );
        if ( ! empty( $attrs['styleStarsColor'] ) ) {
            $_sc2 = esc_attr( $attrs['styleStarsColor'] );
            $_css[] = $sc . ' .htm25-hero__stars { color: ' . $_sc2 . '; }';
            $_css[] = $sc . ' .htm25-hero__stars svg path { fill: ' . $_sc2 . '; }';
        }

        // Floating badge
        $_fb = self::_radius( $attrs['styleFloatBadgeRadius'] ?? null );
        if ( ! empty( $attrs['styleFloatBadgeBgColor'] ) ) $_fb[] = 'background-color: ' . esc_attr( $attrs['styleFloatBadgeBgColor'] );
        self::_rule( $sc, ' .htm25-hero__float-badge', $_fb, $_css );
        $_fbn = self::_typo( $attrs['styleFloatBadgeNumberTypography'] ?? null ); if ( ! empty( $attrs['styleFloatBadgeNumberColor'] ) ) $_fbn[] = 'color: ' . esc_attr( $attrs['styleFloatBadgeNumberColor'] ); self::_rule( $sc, ' .htm25-hero__float-number', $_fbn, $_css );
        $_fbl = self::_typo( $attrs['styleFloatBadgeLabelTypography']  ?? null ); if ( ! empty( $attrs['styleFloatBadgeLabelColor'] ) )  $_fbl[] = 'color: ' . esc_attr( $attrs['styleFloatBadgeLabelColor'] );  self::_rule( $sc, ' .htm25-hero__float-label', $_fbl, $_css );

        // Hero image
        $_img = array_merge( self::_border( $attrs['imageBorderType'] ?? null, $attrs['imageBorderWidth'] ?? null, $attrs['imageBorderColor'] ?? null ), self::_radius( $attrs['styleImageBorderRadiusObj'] ?? null ) );
        $_isw = self::_shadow( $attrs['styleImageShadow'] ?? null ); if ( $_isw ) $_img[] = $_isw;
        self::_rule( $sc, ' .htm25-hero__media img', $_img, $_css );

        return self::_gf_imports( $attrs ) . implode( "\n", $_css );
    }

    // ── About ────────────────────────────────────────────────────

    private static function about_css( $attrs ) {
        $sc   = '.htmega-block-' . ( $attrs['blockUniqId'] ?? 'x' );
        $_css = [];

        $_sec = [];
        if ( ! empty( $attrs['styleAccentColor'] )       ) $_sec[] = '--htm25-accent-primary: '   . esc_attr( $attrs['styleAccentColor'] );
        if ( ! empty( $attrs['styleSectionBgColor'] )    ) $_sec[] = 'background-color: '         . esc_attr( $attrs['styleSectionBgColor'] );
        if ( ! empty( $attrs['styleSectionBgGradient'] ) ) { $_sec[] = 'background: ' . esc_attr( $attrs['styleSectionBgGradient'] ); $_sec[] = 'background-color: transparent'; }
        $_sec = array_merge( $_sec, self::_dim( $attrs['styleSectionPadding'] ?? null, 'padding' ), self::_border( $attrs['sectionBorderType'] ?? null, $attrs['sectionBorderWidth'] ?? null, $attrs['sectionBorderColor'] ?? null ), self::_radius( $attrs['styleSectionBorderRadius'] ?? null ) );
        $_sw = self::_shadow( $attrs['styleSectionShadow'] ?? null ); if ( $_sw ) $_sec[] = $_sw;
        if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-about { ' . implode( '; ', $_sec ) . '; }';
        if ( ! empty( $attrs['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-about__inner { max-width: ' . esc_attr( $attrs['styleContainerMaxWidth'] ) . '; }';

        $_hl = array_merge( self::_typo( $attrs['styleHeadlineTypography'] ?? null ), self::_dim( $attrs['styleHeadlineMargin'] ?? null, 'margin' ) );
        if ( ! empty( $attrs['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $attrs['styleHeadlineColor'] );
        self::_rule( $sc, ' .htm25-about__headline', $_hl, $_css );
        if ( ! empty( $attrs['styleHeadlineHighlightColor'] )   ) $_css[] = $sc . ' .htm25-about .htm25-about__headline-accent { background-color: ' . esc_attr( $attrs['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
        if ( ! empty( $attrs['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-about .htm25-about__headline-accent { background: ' . esc_attr( $attrs['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

        $_desc = self::_typo( $attrs['styleDescTypography'] ?? null );
        if ( ! empty( $attrs['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $attrs['styleDescColor'] );
        self::_rule( $sc, ' .htm25-about__description', $_desc, $_css );

        $_card = array_merge( self::_border( $attrs['cardBorderType'] ?? null, $attrs['cardBorderWidth'] ?? null, $attrs['cardBorderColor'] ?? null ), self::_radius( $attrs['styleCardBorderRadius'] ?? null ) );
        if ( ! empty( $attrs['styleCardBgColor'] ) ) $_card[] = 'background-color: ' . esc_attr( $attrs['styleCardBgColor'] );
        $_csw = self::_shadow( $attrs['styleCardShadow'] ?? null ); if ( $_csw ) $_card[] = $_csw;
        self::_rule( $sc, ' .htm25-about__feature', $_card, $_css );

        if ( ! empty( $attrs['styleIconColor'] ) ) { $_ic = esc_attr( $attrs['styleIconColor'] ); $_css[] = "$sc .htm25-about .htm25-about__feature-icon i { color: $_ic; }"; $_css[] = "$sc .htm25-about .htm25-about__feature-icon svg { color: $_ic; }"; $_css[] = "$sc .htm25-about .htm25-about__feature-icon svg path { fill: $_ic; }"; }
        if ( ! empty( $attrs['styleIconSize'] )  ) { $_sz = esc_attr( $attrs['styleIconSize'] ); $_css[] = "$sc .htm25-about .htm25-about__feature-icon i { font-size: {$_sz}px; }"; $_css[] = "$sc .htm25-about .htm25-about__feature-icon svg { width: {$_sz}px; height: {$_sz}px; }"; }

        $_ft = self::_typo( $attrs['styleFeatureTitleTypography'] ?? null ); if ( ! empty( $attrs['styleFeatureTitleColor'] ) ) $_ft[] = 'color: ' . esc_attr( $attrs['styleFeatureTitleColor'] ); self::_rule( $sc, ' .htm25-about__feature-title', $_ft, $_css );
        $_fd = self::_typo( $attrs['styleFeatureDescTypography']  ?? null ); if ( ! empty( $attrs['styleFeatureDescColor'] ) )  $_fd[] = 'color: ' . esc_attr( $attrs['styleFeatureDescColor'] );  self::_rule( $sc, ' .htm25-about__feature-description', $_fd, $_css );

        $_cta = self::_typo( $attrs['styleCtaTypography'] ?? null );
        if ( ! empty( $attrs['styleCtaBgColor'] )    ) { $_cta[] = 'background-color: ' . esc_attr( $attrs['styleCtaBgColor'] ); $_cta[] = 'background-image: none'; }
        if ( ! empty( $attrs['styleCtaBgGradient'] ) ) { $_cta[] = 'background: ' . esc_attr( $attrs['styleCtaBgGradient'] ); $_cta[] = 'background-color: transparent'; }
        if ( ! empty( $attrs['styleCtaTextColor'] )  ) $_cta[] = 'color: ' . esc_attr( $attrs['styleCtaTextColor'] );
        $_cta = array_merge( $_cta, self::_border( $attrs['ctaBorderType'] ?? null, $attrs['ctaBorderWidth'] ?? null, $attrs['ctaBorderColor'] ?? null ), self::_radius( $attrs['styleCtaBorderRadius'] ?? null ) );
        $_ctasw = self::_shadow( $attrs['styleCtaShadow'] ?? null ); if ( $_ctasw ) $_cta[] = $_ctasw;
        self::_rule( $sc, ' .htm25-about__cta', $_cta, $_css );

        $_ctah = [];
        if ( ! empty( $attrs['styleCtaHoverBgGradient'] ) ) $_ctah[] = 'background: ' . esc_attr( $attrs['styleCtaHoverBgGradient'] );
        elseif ( ! empty( $attrs['styleCtaHoverBgColor'] ) ) $_ctah[] = 'background: ' . esc_attr( $attrs['styleCtaHoverBgColor'] );
        if ( ! empty( $attrs['styleCtaHoverTextColor'] ) ) $_ctah[] = 'color: ' . esc_attr( $attrs['styleCtaHoverTextColor'] );
        $_ctah = array_merge( $_ctah, self::_border( $attrs['ctaHoverBorderType'] ?? null, $attrs['ctaHoverBorderWidth'] ?? null, $attrs['ctaHoverBorderColor'] ?? null ) );
        self::_rule( $sc, ' .htm25-about__cta:hover', $_ctah, $_css );

        $_img = array_merge( self::_border( $attrs['imageBorderType'] ?? null, $attrs['imageBorderWidth'] ?? null, $attrs['imageBorderColor'] ?? null ), self::_radius( $attrs['styleImageBorderRadius'] ?? null ) );
        $_isw = self::_shadow( $attrs['styleImageShadow'] ?? null ); if ( $_isw ) $_img[] = $_isw;
        self::_rule( $sc, ' .htm25-about__img', $_img, $_css );

        $_fb = self::_radius( $attrs['styleFloatBadgeRadius'] ?? null );
        if ( ! empty( $attrs['styleFloatBadgeBgColor'] ) ) $_fb[] = 'background-color: ' . esc_attr( $attrs['styleFloatBadgeBgColor'] );
        self::_rule( $sc, ' .htm25-about__float-badge', $_fb, $_css );
        $_fbn = self::_typo( $attrs['styleFloatBadgeNumberTypography'] ?? null ); if ( ! empty( $attrs['styleFloatBadgeNumberColor'] ) ) $_fbn[] = 'color: ' . esc_attr( $attrs['styleFloatBadgeNumberColor'] ); self::_rule( $sc, ' .htm25-about__float-number', $_fbn, $_css );
        $_fbl = self::_typo( $attrs['styleFloatBadgeLabelTypography']  ?? null ); if ( ! empty( $attrs['styleFloatBadgeLabelColor'] ) )  $_fbl[] = 'color: ' . esc_attr( $attrs['styleFloatBadgeLabelColor'] );  self::_rule( $sc, ' .htm25-about__float-label', $_fbl, $_css );

        return self::_gf_imports( $attrs ) . implode( "\n", $_css );
    }

    // ── Services ─────────────────────────────────────────────────

    private static function services_css( $attrs ) {
        $sc   = '.htmega-block-' . ( $attrs['blockUniqId'] ?? 'x' );
        $_css = [];

        $_sec = [];
        if ( ! empty( $attrs['styleAccentColor'] )       ) $_sec[] = '--htm25-accent-primary: '   . esc_attr( $attrs['styleAccentColor'] );
        if ( ! empty( $attrs['styleSectionBgColor'] )    ) $_sec[] = 'background-color: '         . esc_attr( $attrs['styleSectionBgColor'] );
        if ( ! empty( $attrs['styleSectionBgGradient'] ) ) { $_sec[] = 'background: ' . esc_attr( $attrs['styleSectionBgGradient'] ); $_sec[] = 'background-color: transparent'; }
        $_sec = array_merge( $_sec, self::_dim( $attrs['styleSectionPadding'] ?? null, 'padding' ), self::_border( $attrs['sectionBorderType'] ?? null, $attrs['sectionBorderWidth'] ?? null, $attrs['sectionBorderColor'] ?? null ), self::_radius( $attrs['styleSectionBorderRadius'] ?? null ) );
        $_sw = self::_shadow( $attrs['styleSectionShadow'] ?? null ); if ( $_sw ) $_sec[] = $_sw;
        if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-services { ' . implode( '; ', $_sec ) . '; }';
        if ( ! empty( $attrs['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-services__inner { max-width: ' . esc_attr( $attrs['styleContainerMaxWidth'] ) . '; }';

        $_hl = array_merge( self::_typo( $attrs['styleHeadlineTypography'] ?? null ), self::_dim( $attrs['styleHeadlineMargin'] ?? null, 'margin' ) );
        if ( ! empty( $attrs['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $attrs['styleHeadlineColor'] );
        self::_rule( $sc, ' .htm25-services__headline', $_hl, $_css );
        if ( ! empty( $attrs['styleHeadlineHighlightColor'] )    ) $_css[] = $sc . ' .htm25-services .htm25-services__headline-accent { background-color: ' . esc_attr( $attrs['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
        if ( ! empty( $attrs['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-services .htm25-services__headline-accent { background: ' . esc_attr( $attrs['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

        $_desc = self::_typo( $attrs['styleDescTypography'] ?? null );
        if ( ! empty( $attrs['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $attrs['styleDescColor'] );
        self::_rule( $sc, ' .htm25-services__description', $_desc, $_css );

        $_card = array_merge( self::_border( $attrs['cardBorderType'] ?? null, $attrs['cardBorderWidth'] ?? null, $attrs['cardBorderColor'] ?? null ), self::_radius( $attrs['styleCardBorderRadius'] ?? null ) );
        if ( ! empty( $attrs['styleCardBgColor'] ) ) $_card[] = 'background-color: ' . esc_attr( $attrs['styleCardBgColor'] );
        $_csw = self::_shadow( $attrs['styleCardShadow'] ?? null ); if ( $_csw ) $_card[] = $_csw;
        self::_rule( $sc, ' .htm25-services__card', $_card, $_css );
        if ( ! empty( $attrs['styleCardHoverBgColor'] ) ) $_css[] = $sc . ' .htm25-services__card:hover { background-color: ' . esc_attr( $attrs['styleCardHoverBgColor'] ) . '; }';

        if ( ! empty( $attrs['styleIconColor'] ) ) { $_ic = esc_attr( $attrs['styleIconColor'] ); $_css[] = "$sc .htm25-services .htm25-services__card-icon i { color: $_ic; }"; $_css[] = "$sc .htm25-services .htm25-services__card-icon svg { color: $_ic; }"; $_css[] = "$sc .htm25-services .htm25-services__card-icon svg path { fill: $_ic; }"; }
        if ( ! empty( $attrs['styleIconSize'] )  ) { $_sz = esc_attr( $attrs['styleIconSize'] );  $_css[] = "$sc .htm25-services .htm25-services__card-icon i { font-size: {$_sz}px; }"; $_css[] = "$sc .htm25-services .htm25-services__card-icon svg { width: {$_sz}px; height: {$_sz}px; }"; }

        $_ct = self::_typo( $attrs['styleCardTitleTypography'] ?? null ); if ( ! empty( $attrs['styleCardTitleColor'] ) ) $_ct[] = 'color: ' . esc_attr( $attrs['styleCardTitleColor'] ); self::_rule( $sc, ' .htm25-services__card-title', $_ct, $_css );
        $_cd = self::_typo( $attrs['styleCardDescTypography']  ?? null ); if ( ! empty( $attrs['styleCardDescColor'] ) )  $_cd[] = 'color: ' . esc_attr( $attrs['styleCardDescColor'] );  self::_rule( $sc, ' .htm25-services__card-description', $_cd, $_css );

        $_cta = self::_typo( $attrs['styleCtaTypography'] ?? null );
        if ( ! empty( $attrs['styleCtaBgColor'] )    ) { $_cta[] = 'background-color: ' . esc_attr( $attrs['styleCtaBgColor'] ); $_cta[] = 'background-image: none'; }
        if ( ! empty( $attrs['styleCtaBgGradient'] ) ) { $_cta[] = 'background: ' . esc_attr( $attrs['styleCtaBgGradient'] ); $_cta[] = 'background-color: transparent'; }
        if ( ! empty( $attrs['styleCtaTextColor'] )  ) $_cta[] = 'color: ' . esc_attr( $attrs['styleCtaTextColor'] );
        $_cta = array_merge( $_cta, self::_border( $attrs['ctaBorderType'] ?? null, $attrs['ctaBorderWidth'] ?? null, $attrs['ctaBorderColor'] ?? null ), self::_radius( $attrs['styleCtaBorderRadius'] ?? null ) );
        $_ctasw = self::_shadow( $attrs['styleCtaShadow'] ?? null ); if ( $_ctasw ) $_cta[] = $_ctasw;
        self::_rule( $sc, ' .htm25-services__cta', $_cta, $_css );

        $_ctah = [];
        if ( ! empty( $attrs['styleCtaHoverBgGradient'] ) ) $_ctah[] = 'background: ' . esc_attr( $attrs['styleCtaHoverBgGradient'] );
        elseif ( ! empty( $attrs['styleCtaHoverBgColor'] ) ) $_ctah[] = 'background: ' . esc_attr( $attrs['styleCtaHoverBgColor'] );
        if ( ! empty( $attrs['styleCtaHoverTextColor'] ) ) $_ctah[] = 'color: ' . esc_attr( $attrs['styleCtaHoverTextColor'] );
        $_ctah = array_merge( $_ctah, self::_border( $attrs['ctaHoverBorderType'] ?? null, $attrs['ctaHoverBorderWidth'] ?? null, $attrs['ctaHoverBorderColor'] ?? null ) );
        self::_rule( $sc, ' .htm25-services__cta:hover', $_ctah, $_css );

        return self::_gf_imports( $attrs ) . implode( "\n", $_css );
    }

    // ── Testimonials ─────────────────────────────────────────────

    private static function testimonials_css( $attrs ) {
        $sc   = '.htmega-block-' . ( $attrs['blockUniqId'] ?? 'x' );
        $_css = [];

        $_sec = [];
        if ( ! empty( $attrs['styleSectionBgColor'] )    ) $_sec[] = 'background-color: ' . esc_attr( $attrs['styleSectionBgColor'] );
        if ( ! empty( $attrs['styleSectionBgGradient'] ) ) { $_sec[] = 'background: ' . esc_attr( $attrs['styleSectionBgGradient'] ); $_sec[] = 'background-color: transparent'; }
        $_sec = array_merge( $_sec, self::_dim( $attrs['styleSectionPadding'] ?? null, 'padding' ), self::_border( $attrs['sectionBorderType'] ?? null, $attrs['sectionBorderWidth'] ?? null, $attrs['sectionBorderColor'] ?? null ), self::_radius( $attrs['styleSectionBorderRadius'] ?? null ) );
        $_sw = self::_shadow( $attrs['styleSectionShadow'] ?? null ); if ( $_sw ) $_sec[] = $_sw;
        if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-testimonials { ' . implode( '; ', $_sec ) . '; }';
        if ( ! empty( $attrs['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-testimonials__inner { max-width: ' . esc_attr( $attrs['styleContainerMaxWidth'] ) . '; }';

        $_hl = array_merge( self::_typo( $attrs['styleHeadlineTypography'] ?? null ), self::_dim( $attrs['styleHeadlineMargin'] ?? null, 'margin' ) );
        if ( ! empty( $attrs['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $attrs['styleHeadlineColor'] );
        self::_rule( $sc, ' .htm25-testimonials__headline', $_hl, $_css );
        if ( ! empty( $attrs['styleHeadlineHighlightColor'] )   ) $_css[] = $sc . ' .htm25-testimonials .htm25-testimonials__headline-accent { background-color: ' . esc_attr( $attrs['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
        if ( ! empty( $attrs['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-testimonials .htm25-testimonials__headline-accent { background: ' . esc_attr( $attrs['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

        $_desc = self::_typo( $attrs['styleDescTypography'] ?? null );
        if ( ! empty( $attrs['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $attrs['styleDescColor'] );
        self::_rule( $sc, ' .htm25-testimonials__description', $_desc, $_css );

        $_card = array_merge( self::_border( $attrs['cardBorderType'] ?? null, $attrs['cardBorderWidth'] ?? null, $attrs['cardBorderColor'] ?? null ), self::_radius( $attrs['styleCardBorderRadius'] ?? null ) );
        if ( ! empty( $attrs['styleCardBgColor'] ) ) $_card[] = 'background-color: ' . esc_attr( $attrs['styleCardBgColor'] );
        $_csw = self::_shadow( $attrs['styleCardShadow'] ?? null ); if ( $_csw ) $_card[] = $_csw;
        self::_rule( $sc, ' .htm25-testimonials__card', $_card, $_css );

        $_featured = self::_border( $attrs['featuredCardBorderType'] ?? null, $attrs['featuredCardBorderWidth'] ?? null, $attrs['featuredCardBorderColor'] ?? null );
        if ( ! empty( $attrs['featuredCardBgColor'] ) ) $_featured[] = 'background-color: ' . esc_attr( $attrs['featuredCardBgColor'] );
        $_fsw = self::_shadow( $attrs['featuredCardShadow'] ?? null ); if ( $_fsw ) $_featured[] = $_fsw;
        self::_rule( $sc, ' .htm25-testimonials__card--featured', $_featured, $_css );

        $_qt = self::_typo( $attrs['styleQuoteTypography'] ?? null );
        if ( ! empty( $attrs['styleQuoteColor'] ) ) $_qt[] = 'color: ' . esc_attr( $attrs['styleQuoteColor'] );
        self::_rule( $sc, ' .htm25-testimonials__card-text', $_qt, $_css );

        $_an = self::_typo( $attrs['styleAuthorNameTypography'] ?? null );
        if ( ! empty( $attrs['styleAuthorNameColor'] ) ) $_an[] = 'color: ' . esc_attr( $attrs['styleAuthorNameColor'] );
        self::_rule( $sc, ' .htm25-testimonials__card-name', $_an, $_css );

        $_ar = self::_typo( $attrs['styleAuthorRoleTypography'] ?? null );
        if ( ! empty( $attrs['styleAuthorRoleColor'] )    ) $_ar[] = 'color: ' . esc_attr( $attrs['styleAuthorRoleColor'] );
        self::_rule( $sc, ' .htm25-testimonials__card-role', $_ar, $_css );
        if ( ! empty( $attrs['styleAuthorCompanyColor'] ) ) $_css[] = "$sc .htm25-testimonials__card-company { color: " . esc_attr( $attrs['styleAuthorCompanyColor'] ) . "; }";

        if ( ! empty( $attrs['styleAvatarSize'] ) ) {
            $_sz = esc_attr( $attrs['styleAvatarSize'] );
            $_fs = (int) round( (int) $_sz * 0.4 );
            $_css[] = "$sc .htm25-testimonials__card-avatar { width: {$_sz}px; height: {$_sz}px; min-width: {$_sz}px; }";
            $_css[] = "$sc .htm25-testimonials__card-avatar img { width: {$_sz}px; height: {$_sz}px; }";
            $_css[] = "$sc .htm25-testimonials__card-avatar-placeholder { width: {$_sz}px; height: {$_sz}px; font-size: {$_fs}px; }";
        }
        if ( ! empty( $attrs['styleAvatarBorderRadius'] ) ) {
            $_avr = self::_radius( $attrs['styleAvatarBorderRadius'] ?? null );
            self::_rule( $sc, ' .htm25-testimonials__card-avatar', $_avr, $_css );
            self::_rule( $sc, ' .htm25-testimonials__card-avatar img', $_avr, $_css );
            self::_rule( $sc, ' .htm25-testimonials__card-avatar-placeholder', $_avr, $_css );
        }

        if ( ! empty( $attrs['styleStarsColor'] ) ) {
            $_sc_val = esc_attr( $attrs['styleStarsColor'] );
            $_css[] = "$sc .htm25-testimonials__star--filled { color: $_sc_val; }";
            $_css[] = "$sc .htm25-testimonials__star--filled svg path { fill: $_sc_val; }";
        }
        if ( ! empty( $attrs['styleEmptyStarsColor'] ) ) {
            $_esc_val = esc_attr( $attrs['styleEmptyStarsColor'] );
            $_css[] = "$sc .htm25-testimonials__star--empty { color: $_esc_val; opacity: 1; }";
            $_css[] = "$sc .htm25-testimonials__star--empty svg path { fill: $_esc_val; }";
        }

        return self::_gf_imports( $attrs ) . implode( "\n", $_css );
    }

    // ── Pricing ──────────────────────────────────────────────────

    private static function pricing_css( $attrs ) {
        $sc   = '.htmega-block-' . ( $attrs['blockUniqId'] ?? 'x' );
        $_css = [];

        $_sec = [];
        if ( ! empty( $attrs['styleSectionBgColor'] )    ) $_sec[] = 'background-color: ' . esc_attr( $attrs['styleSectionBgColor'] );
        if ( ! empty( $attrs['styleSectionBgGradient'] ) ) { $_sec[] = 'background: ' . esc_attr( $attrs['styleSectionBgGradient'] ); $_sec[] = 'background-color: transparent'; }
        $_sec = array_merge( $_sec, self::_dim( $attrs['styleSectionPadding'] ?? null, 'padding' ), self::_border( $attrs['sectionBorderType'] ?? null, $attrs['sectionBorderWidth'] ?? null, $attrs['sectionBorderColor'] ?? null ), self::_radius( $attrs['styleSectionBorderRadius'] ?? null ) );
        $_sw = self::_shadow( $attrs['styleSectionShadow'] ?? null ); if ( $_sw ) $_sec[] = $_sw;
        if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-pricing { ' . implode( '; ', $_sec ) . '; }';
        if ( ! empty( $attrs['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-pricing__inner { max-width: ' . esc_attr( $attrs['styleContainerMaxWidth'] ) . '; }';

        $_hl = array_merge( self::_typo( $attrs['styleHeadlineTypography'] ?? null ), self::_dim( $attrs['styleHeadlineMargin'] ?? null, 'margin' ) );
        if ( ! empty( $attrs['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $attrs['styleHeadlineColor'] );
        self::_rule( $sc, ' .htm25-pricing__headline', $_hl, $_css );
        if ( ! empty( $attrs['styleHeadlineHighlightColor'] )   ) $_css[] = $sc . ' .htm25-pricing__headline-accent { background-color: ' . esc_attr( $attrs['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
        if ( ! empty( $attrs['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-pricing__headline-accent { background: ' . esc_attr( $attrs['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

        $_desc = self::_typo( $attrs['styleDescTypography'] ?? null );
        if ( ! empty( $attrs['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $attrs['styleDescColor'] );
        self::_rule( $sc, ' .htm25-pricing__description', $_desc, $_css );

        if ( ! empty( $attrs['styleToggleBgColor'] )       ) $_css[] = $sc . ' .htm25-pricing__toggle-track { background: ' . esc_attr( $attrs['styleToggleBgColor'] ) . '; }';
        if ( ! empty( $attrs['styleToggleActiveBgColor'] ) ) { $_tac = esc_attr( $attrs['styleToggleActiveBgColor'] ); $_css[] = "$sc .htm25-pricing__toggle-cb:checked + .htm25-pricing__toggle-track { background: $_tac; border-color: $_tac; }"; }
        if ( ! empty( $attrs['styleToggleTextColor'] )     ) $_css[] = $sc . ' .htm25-pricing__toggle-label { color: ' . esc_attr( $attrs['styleToggleTextColor'] ) . '; }';

        $_card = array_merge( self::_border( $attrs['cardBorderType'] ?? null, $attrs['cardBorderWidth'] ?? null, $attrs['cardBorderColor'] ?? null ), self::_radius( $attrs['styleCardBorderRadius'] ?? null ) );
        if ( ! empty( $attrs['styleCardBgColor'] ) ) $_card[] = 'background-color: ' . esc_attr( $attrs['styleCardBgColor'] );
        $_csw = self::_shadow( $attrs['styleCardShadow'] ?? null ); if ( $_csw ) $_card[] = $_csw;
        self::_rule( $sc, ' .htm25-pricing__card', $_card, $_css );
        if ( ! empty( $attrs['styleFeaturedCardAccentColor'] )   ) { $_fac = esc_attr( $attrs['styleFeaturedCardAccentColor'] ); $_css[] = "$sc .htm25-pricing__card--featured { border-color: $_fac; box-shadow: 0 0 0 2px $_fac, var(--htm25-shadow-card-hover); }"; }
        if ( ! empty( $attrs['styleFeaturedCardHeaderBgColor'] ) ) $_css[] = $sc . ' .htm25-pricing__card--featured .htm25-pricing__card-head { background-color: ' . esc_attr( $attrs['styleFeaturedCardHeaderBgColor'] ) . '; }';

        $_badge = array_merge( self::_typo( $attrs['styleBadgeTypography'] ?? null ), self::_radius( $attrs['styleBadgeBorderRadius'] ?? null ) );
        if ( ! empty( $attrs['styleBadgeTextColor']  ) ) $_badge[] = 'color: '            . esc_attr( $attrs['styleBadgeTextColor'] );
        if ( ! empty( $attrs['styleBadgeBgColor']    ) ) { $_badge[] = 'background-color: ' . esc_attr( $attrs['styleBadgeBgColor'] ); $_badge[] = 'background-image: none'; }
        if ( ! empty( $attrs['styleBadgeBgGradient'] ) ) { $_badge[] = 'background: '       . esc_attr( $attrs['styleBadgeBgGradient'] ); $_badge[] = 'background-color: transparent'; }
        self::_rule( $sc, ' .htm25-pricing__card-badge', $_badge, $_css );

        $_pn = self::_typo( $attrs['stylePlanNameTypography'] ?? null );
        if ( ! empty( $attrs['stylePlanNameColor'] ) ) $_pn[] = 'color: ' . esc_attr( $attrs['stylePlanNameColor'] );
        self::_rule( $sc, ' .htm25-pricing__card-name', $_pn, $_css );

        $_pr = self::_typo( $attrs['stylePriceTypography'] ?? null );
        if ( ! empty( $attrs['stylePriceColor'] ) ) $_pr[] = 'color: ' . esc_attr( $attrs['stylePriceColor'] );
        if ( ! empty( $_pr ) ) $_css[] = "$sc .htm25-pricing__card-amount--monthly, $sc .htm25-pricing__card-amount--annual { " . implode( '; ', $_pr ) . '; }';
        if ( ! empty( $attrs['stylePriceGradient'] ) ) $_css[] = "$sc .htm25-pricing__card-amount--monthly, $sc .htm25-pricing__card-amount--annual { background: " . esc_attr( $attrs['stylePriceGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }';

        $_fi = self::_typo( $attrs['styleFeatureItemTypography'] ?? null );
        if ( ! empty( $attrs['styleFeatureItemColor'] ) ) $_fi[] = 'color: ' . esc_attr( $attrs['styleFeatureItemColor'] );
        self::_rule( $sc, ' .htm25-pricing__card-feature', $_fi, $_css );
        if ( ! empty( $attrs['styleFeatureCheckColor'] )   ) { $_fc = esc_attr( $attrs['styleFeatureCheckColor'] ); $_css[] = "$sc .htm25-pricing__card-feature-check { color: $_fc; }"; $_css[] = "$sc .htm25-pricing__card-feature-check svg { color: $_fc; }"; $_css[] = "$sc .htm25-pricing__card-feature-check svg path { fill: $_fc; }"; }
        if ( ! empty( $attrs['styleFeatureCheckBgColor'] ) ) $_css[] = "$sc .htm25-pricing__card-feature-check { background-color: " . esc_attr( $attrs['styleFeatureCheckBgColor'] ) . "; }";

        $_cta = self::_typo( $attrs['styleCtaTypography'] ?? null );
        if ( ! empty( $attrs['styleCtaBgColor'] )    ) { $_cta[] = 'background-color: ' . esc_attr( $attrs['styleCtaBgColor'] ); $_cta[] = 'background-image: none'; }
        if ( ! empty( $attrs['styleCtaBgGradient'] ) ) { $_cta[] = 'background: ' . esc_attr( $attrs['styleCtaBgGradient'] ); $_cta[] = 'background-color: transparent'; }
        if ( ! empty( $attrs['styleCtaTextColor'] )  ) $_cta[] = 'color: ' . esc_attr( $attrs['styleCtaTextColor'] );
        $_cta = array_merge( $_cta, self::_border( $attrs['ctaBorderType'] ?? null, $attrs['ctaBorderWidth'] ?? null, $attrs['ctaBorderColor'] ?? null ), self::_radius( $attrs['styleCtaBorderRadius'] ?? null ) );
        $_ctasw = self::_shadow( $attrs['styleCtaShadow'] ?? null ); if ( $_ctasw ) $_cta[] = $_ctasw;
        self::_rule( $sc, ' .htm25-pricing__card-cta', $_cta, $_css );

        $_ctah = [];
        if ( ! empty( $attrs['styleCtaHoverBgGradient'] ) ) $_ctah[] = 'background: ' . esc_attr( $attrs['styleCtaHoverBgGradient'] );
        elseif ( ! empty( $attrs['styleCtaHoverBgColor'] ) ) $_ctah[] = 'background: ' . esc_attr( $attrs['styleCtaHoverBgColor'] );
        if ( ! empty( $attrs['styleCtaHoverTextColor'] ) ) $_ctah[] = 'color: ' . esc_attr( $attrs['styleCtaHoverTextColor'] );
        $_ctah = array_merge( $_ctah, self::_border( $attrs['ctaHoverBorderType'] ?? null, $attrs['ctaHoverBorderWidth'] ?? null, $attrs['ctaHoverBorderColor'] ?? null ) );
        self::_rule( $sc, ' .htm25-pricing__card-cta:hover', $_ctah, $_css );

        return self::_gf_imports( $attrs ) . implode( "\n", $_css );
    }

    // ── Stats ────────────────────────────────────────────────────

    private static function stats_css( $attrs ) {
        $sc   = '.htmega-block-' . ( $attrs['blockUniqId'] ?? 'x' );
        $_css = [];

        $_sec = [];
        if ( ! empty( $attrs['styleSectionBgColor'] )    ) $_sec[] = 'background-color: ' . esc_attr( $attrs['styleSectionBgColor'] );
        if ( ! empty( $attrs['styleSectionBgGradient'] ) ) { $_sec[] = 'background: ' . esc_attr( $attrs['styleSectionBgGradient'] ); $_sec[] = 'background-color: transparent'; }
        $_sec = array_merge( $_sec, self::_dim( $attrs['styleSectionPadding'] ?? null, 'padding' ), self::_border( $attrs['sectionBorderType'] ?? null, $attrs['sectionBorderWidth'] ?? null, $attrs['sectionBorderColor'] ?? null ), self::_radius( $attrs['styleSectionBorderRadius'] ?? null ) );
        $_sw = self::_shadow( $attrs['styleSectionShadow'] ?? null ); if ( $_sw ) $_sec[] = $_sw;
        if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-stats { ' . implode( '; ', $_sec ) . '; }';
        if ( ! empty( $attrs['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-stats__inner { max-width: ' . esc_attr( $attrs['styleContainerMaxWidth'] ) . '; }';

        $_hl = array_merge( self::_typo( $attrs['styleHeadlineTypography'] ?? null ), self::_dim( $attrs['styleHeadlineMargin'] ?? null, 'margin' ) );
        if ( ! empty( $attrs['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $attrs['styleHeadlineColor'] );
        self::_rule( $sc, ' .htm25-stats__headline', $_hl, $_css );
        if ( ! empty( $attrs['styleHeadlineHighlightColor'] )   ) $_css[] = $sc . ' .htm25-stats__headline-accent { background-color: ' . esc_attr( $attrs['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
        if ( ! empty( $attrs['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-stats__headline-accent { background: ' . esc_attr( $attrs['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

        $_desc = self::_typo( $attrs['styleDescTypography'] ?? null );
        if ( ! empty( $attrs['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $attrs['styleDescColor'] );
        self::_rule( $sc, ' .htm25-stats__description', $_desc, $_css );

        $_item = array_merge( self::_border( $attrs['itemBorderType'] ?? null, $attrs['itemBorderWidth'] ?? null, $attrs['itemBorderColor'] ?? null ), self::_radius( $attrs['styleItemBorderRadius'] ?? null ) );
        if ( ! empty( $attrs['styleItemBgColor'] ) ) $_item[] = 'background-color: ' . esc_attr( $attrs['styleItemBgColor'] );
        $_isw = self::_shadow( $attrs['styleItemShadow'] ?? null ); if ( $_isw ) $_item[] = $_isw;
        self::_rule( $sc, ' .htm25-stats__item', $_item, $_css );

        $_num = self::_typo( $attrs['styleNumberTypography'] ?? null );
        if ( ! empty( $attrs['styleNumberGradient'] ) ) {
            $_num[] = 'background: ' . esc_attr( $attrs['styleNumberGradient'] );
            $_num[] = '-webkit-background-clip: text';
            $_num[] = '-webkit-text-fill-color: transparent';
            $_num[] = 'background-clip: text';
            $_num[] = 'background-color: transparent';
        } elseif ( ! empty( $attrs['styleNumberColor'] ) ) {
            $_num[] = 'background-color: ' . esc_attr( $attrs['styleNumberColor'] );
        }
        self::_rule( $sc, ' .htm25-stats__item-number', $_num, $_css );

        $_ps = self::_typo( $attrs['stylePrefixSuffixTypography'] ?? null );
        if ( ! empty( $attrs['stylePrefixSuffixColor'] ) ) $_ps[] = 'color: ' . esc_attr( $attrs['stylePrefixSuffixColor'] );
        if ( ! empty( $_ps ) ) $_css[] = "$sc .htm25-stats__item-prefix, $sc .htm25-stats__item-suffix { " . implode( '; ', $_ps ) . '; }';

        $_lbl = self::_typo( $attrs['styleLabelTypography'] ?? null );
        if ( ! empty( $attrs['styleLabelColor'] ) ) $_lbl[] = 'color: ' . esc_attr( $attrs['styleLabelColor'] );
        self::_rule( $sc, ' .htm25-stats__item-label', $_lbl, $_css );

        $_slbl = self::_typo( $attrs['styleSublabelTypography'] ?? null );
        if ( ! empty( $attrs['styleSublabelColor'] ) ) $_slbl[] = 'color: ' . esc_attr( $attrs['styleSublabelColor'] );
        self::_rule( $sc, ' .htm25-stats__item-description', $_slbl, $_css );

        if ( ! empty( $attrs['styleIconColor'] ) ) { $_ic = esc_attr( $attrs['styleIconColor'] ); $_css[] = "$sc .htm25-stats__item-icon i { color: $_ic; }"; $_css[] = "$sc .htm25-stats__item-icon svg { color: $_ic; }"; $_css[] = "$sc .htm25-stats__item-icon svg path { fill: $_ic; }"; }
        if ( ! empty( $attrs['styleIconSize'] )  ) { $_sz = esc_attr( $attrs['styleIconSize'] ); $_css[] = "$sc .htm25-stats__item-icon i { font-size: {$_sz}px; }"; $_css[] = "$sc .htm25-stats__item-icon svg { width: {$_sz}px; height: {$_sz}px; }"; }

        return self::_gf_imports( $attrs ) . implode( "\n", $_css );
    }

    // ── CTA ──────────────────────────────────────────────────────

    private static function cta_css( $attrs ) {
        $sc   = '.htmega-block-' . ( $attrs['blockUniqId'] ?? 'x' );
        $_css = [];

        $_sec = [];
        if ( ! empty( $attrs['styleSectionBgColor'] )    ) $_sec[] = 'background-color: ' . esc_attr( $attrs['styleSectionBgColor'] );
        if ( ! empty( $attrs['styleSectionBgGradient'] ) ) { $_sec[] = 'background: ' . esc_attr( $attrs['styleSectionBgGradient'] ); $_sec[] = 'background-color: transparent'; }
        $_sec = array_merge( $_sec, self::_dim( $attrs['styleSectionPadding'] ?? null, 'padding' ), self::_border( $attrs['sectionBorderType'] ?? null, $attrs['sectionBorderWidth'] ?? null, $attrs['sectionBorderColor'] ?? null ), self::_radius( $attrs['styleSectionBorderRadius'] ?? null ) );
        $_sw = self::_shadow( $attrs['styleSectionShadow'] ?? null ); if ( $_sw ) $_sec[] = $_sw;
        if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-cta { ' . implode( '; ', $_sec ) . '; }';
        if ( ! empty( $attrs['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-cta__inner { max-width: ' . esc_attr( $attrs['styleContainerMaxWidth'] ) . '; }';

        $_hl = array_merge( self::_typo( $attrs['styleHeadlineTypography'] ?? null ), self::_dim( $attrs['styleHeadlineMargin'] ?? null, 'margin' ) );
        if ( ! empty( $attrs['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $attrs['styleHeadlineColor'] );
        self::_rule( $sc, ' .htm25-cta__headline', $_hl, $_css );
        if ( ! empty( $attrs['styleHeadlineHighlightColor'] )   ) $_css[] = $sc . ' .htm25-cta__headline-accent { background-color: ' . esc_attr( $attrs['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
        if ( ! empty( $attrs['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-cta__headline-accent { background: ' . esc_attr( $attrs['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

        $_desc = self::_typo( $attrs['styleDescTypography'] ?? null );
        if ( ! empty( $attrs['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $attrs['styleDescColor'] );
        self::_rule( $sc, ' .htm25-cta__description', $_desc, $_css );

        $_lbl = self::_typo( $attrs['styleLabelTypography'] ?? null );
        if ( ! empty( $attrs['styleLabelColor'] )   ) $_lbl[] = 'color: ' . esc_attr( $attrs['styleLabelColor'] );
        if ( ! empty( $attrs['styleLabelBgColor'] ) ) $_lbl[] = 'background-color: ' . esc_attr( $attrs['styleLabelBgColor'] );
        self::_rule( $sc, ' .htm25-cta__section-label', $_lbl, $_css );

        $_pb = self::_typo( $attrs['stylePrimaryBtnTypography'] ?? null );
        if ( ! empty( $attrs['stylePrimaryBtnBgColor'] )    ) { $_pb[] = 'background-color: ' . esc_attr( $attrs['stylePrimaryBtnBgColor'] ); $_pb[] = 'background-image: none'; }
        if ( ! empty( $attrs['stylePrimaryBtnBgGradient'] ) ) { $_pb[] = 'background: ' . esc_attr( $attrs['stylePrimaryBtnBgGradient'] ); $_pb[] = 'background-color: transparent'; }
        if ( ! empty( $attrs['stylePrimaryBtnTextColor'] )  ) $_pb[] = 'color: ' . esc_attr( $attrs['stylePrimaryBtnTextColor'] );
        $_pb = array_merge( $_pb, self::_border( $attrs['primaryBtnBorderType'] ?? null, $attrs['primaryBtnBorderWidth'] ?? null, $attrs['primaryBtnBorderColor'] ?? null ), self::_radius( $attrs['stylePrimaryBtnBorderRadius'] ?? null ) );
        $_pbsw = self::_shadow( $attrs['stylePrimaryBtnShadow'] ?? null ); if ( $_pbsw ) $_pb[] = $_pbsw;
        self::_rule( $sc, ' .htm25-cta__btn--primary', $_pb, $_css );

        $_pbh = [];
        if ( ! empty( $attrs['stylePrimaryBtnHoverBgGradient'] ) ) $_pbh[] = 'background: ' . esc_attr( $attrs['stylePrimaryBtnHoverBgGradient'] );
        elseif ( ! empty( $attrs['stylePrimaryBtnHoverBgColor'] ) ) $_pbh[] = 'background: ' . esc_attr( $attrs['stylePrimaryBtnHoverBgColor'] );
        if ( ! empty( $attrs['stylePrimaryBtnHoverTextColor'] ) ) $_pbh[] = 'color: ' . esc_attr( $attrs['stylePrimaryBtnHoverTextColor'] );
        $_pbh = array_merge( $_pbh, self::_border( $attrs['primaryBtnHoverBorderType'] ?? null, $attrs['primaryBtnHoverBorderWidth'] ?? null, $attrs['primaryBtnHoverBorderColor'] ?? null ) );
        self::_rule( $sc, ' .htm25-cta__btn--primary:hover', $_pbh, $_css );

        $_sb = self::_typo( $attrs['styleSecondaryBtnTypography'] ?? null );
        if ( ! empty( $attrs['styleSecondaryBtnBgGradient'] ) ) $_sb[] = 'background: ' . esc_attr( $attrs['styleSecondaryBtnBgGradient'] );
        elseif ( ! empty( $attrs['styleSecondaryBtnBgColor'] ) ) $_sb[] = 'background: ' . esc_attr( $attrs['styleSecondaryBtnBgColor'] );
        if ( ! empty( $attrs['styleSecondaryBtnTextColor'] ) ) $_sb[] = 'color: ' . esc_attr( $attrs['styleSecondaryBtnTextColor'] );
        $_sb = array_merge( $_sb, self::_border( $attrs['secondaryBtnBorderType'] ?? null, $attrs['secondaryBtnBorderWidth'] ?? null, $attrs['secondaryBtnBorderColor'] ?? null ), self::_radius( $attrs['styleSecondaryBtnBorderRadius'] ?? null ) );
        self::_rule( $sc, ' .htm25-cta__btn--secondary', $_sb, $_css );

        $_sbh = [];
        if ( ! empty( $attrs['styleSecondaryBtnHoverBgGradient'] ) ) $_sbh[] = 'background: ' . esc_attr( $attrs['styleSecondaryBtnHoverBgGradient'] );
        elseif ( ! empty( $attrs['styleSecondaryBtnHoverBgColor'] ) ) $_sbh[] = 'background: ' . esc_attr( $attrs['styleSecondaryBtnHoverBgColor'] );
        if ( ! empty( $attrs['styleSecondaryBtnHoverTextColor'] ) ) $_sbh[] = 'color: ' . esc_attr( $attrs['styleSecondaryBtnHoverTextColor'] );
        $_sbh = array_merge( $_sbh, self::_border( $attrs['secondaryBtnHoverBorderType'] ?? null, $attrs['secondaryBtnHoverBorderWidth'] ?? null, $attrs['secondaryBtnHoverBorderColor'] ?? null ) );
        self::_rule( $sc, ' .htm25-cta__btn--secondary:hover', $_sbh, $_css );

        $_img = array_merge( self::_border( $attrs['imageBorderType'] ?? null, $attrs['imageBorderWidth'] ?? null, $attrs['imageBorderColor'] ?? null ), self::_radius( $attrs['styleImageBorderRadius'] ?? null ) );
        $_imgsw = self::_shadow( $attrs['styleImageShadow'] ?? null ); if ( $_imgsw ) $_img[] = $_imgsw;
        self::_rule( $sc, ' .htm25-cta__media img', $_img, $_css );

        return self::_gf_imports( $attrs ) . implode( "\n", $_css );
    }

    // ── Team ─────────────────────────────────────────────────────

    private static function team_css( $attrs ) {
        $sc   = '.htmega-block-' . ( $attrs['blockUniqId'] ?? 'x' );
        $_css = [];

        $_sec = [];
        if ( ! empty( $attrs['styleSectionBgColor'] )    ) $_sec[] = 'background-color: ' . esc_attr( $attrs['styleSectionBgColor'] );
        if ( ! empty( $attrs['styleSectionBgGradient'] ) ) { $_sec[] = 'background: ' . esc_attr( $attrs['styleSectionBgGradient'] ); $_sec[] = 'background-color: transparent'; }
        $_sec = array_merge( $_sec, self::_dim( $attrs['styleSectionPadding'] ?? null, 'padding' ), self::_border( $attrs['sectionBorderType'] ?? null, $attrs['sectionBorderWidth'] ?? null, $attrs['sectionBorderColor'] ?? null ), self::_radius( $attrs['styleSectionBorderRadius'] ?? null ) );
        $_sw = self::_shadow( $attrs['styleSectionShadow'] ?? null ); if ( $_sw ) $_sec[] = $_sw;
        if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-team { ' . implode( '; ', $_sec ) . '; }';
        if ( ! empty( $attrs['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-team__inner { max-width: ' . esc_attr( $attrs['styleContainerMaxWidth'] ) . '; }';

        $_hl = array_merge( self::_typo( $attrs['styleHeadlineTypography'] ?? null ), self::_dim( $attrs['styleHeadlineMargin'] ?? null, 'margin' ) );
        if ( ! empty( $attrs['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $attrs['styleHeadlineColor'] );
        self::_rule( $sc, ' .htm25-team__headline', $_hl, $_css );
        if ( ! empty( $attrs['styleHeadlineHighlightColor'] )   ) $_css[] = $sc . ' .htm25-team__headline-accent { background-color: ' . esc_attr( $attrs['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
        if ( ! empty( $attrs['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-team__headline-accent { background: ' . esc_attr( $attrs['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

        $_desc = self::_typo( $attrs['styleDescTypography'] ?? null );
        if ( ! empty( $attrs['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $attrs['styleDescColor'] );
        self::_rule( $sc, ' .htm25-team__description', $_desc, $_css );

        $_card = array_merge( self::_border( $attrs['cardBorderType'] ?? null, $attrs['cardBorderWidth'] ?? null, $attrs['cardBorderColor'] ?? null ), self::_radius( $attrs['styleCardBorderRadius'] ?? null ) );
        if ( ! empty( $attrs['styleCardBgColor'] ) ) $_card[] = 'background-color: ' . esc_attr( $attrs['styleCardBgColor'] );
        $_csw = self::_shadow( $attrs['styleCardShadow'] ?? null ); if ( $_csw ) $_card[] = $_csw;
        self::_rule( $sc, ' .htm25-team__card', $_card, $_css );

        $_mn = self::_typo( $attrs['styleMemberNameTypography'] ?? null );
        if ( ! empty( $attrs['styleMemberNameColor'] ) ) $_mn[] = 'color: ' . esc_attr( $attrs['styleMemberNameColor'] );
        self::_rule( $sc, ' .htm25-team__card-name', $_mn, $_css );

        $_mr = self::_typo( $attrs['styleMemberRoleTypography'] ?? null );
        if ( ! empty( $attrs['styleMemberRoleColor'] ) ) $_mr[] = 'color: ' . esc_attr( $attrs['styleMemberRoleColor'] );
        self::_rule( $sc, ' .htm25-team__card-role', $_mr, $_css );

        $_dept = array_merge( self::_typo( $attrs['styleDeptTagTypography'] ?? null ), self::_radius( $attrs['styleDeptTagRadius'] ?? null ) );
        if ( ! empty( $attrs['styleDeptTagColor'] )   ) $_dept[] = 'color: ' . esc_attr( $attrs['styleDeptTagColor'] );
        if ( ! empty( $attrs['styleDeptTagBgColor'] ) ) $_dept[] = 'background-color: ' . esc_attr( $attrs['styleDeptTagBgColor'] );
        self::_rule( $sc, ' .htm25-team__card-department', $_dept, $_css );

        if ( ! empty( $attrs['styleSocialIconColor'] ) ) {
            $_ic = esc_attr( $attrs['styleSocialIconColor'] );
            $_css[] = "$sc .htm25-team__card-social .htm25-team__card-social-link i, $sc .htm25-team__card-social-overlay .htm25-team__card-social-link i { color: $_ic; }";
            $_css[] = "$sc .htm25-team__card-social .htm25-team__card-social-link svg, $sc .htm25-team__card-social-overlay .htm25-team__card-social-link svg { color: $_ic; }";
            $_css[] = "$sc .htm25-team__card-social .htm25-team__card-social-link svg path, $sc .htm25-team__card-social-overlay .htm25-team__card-social-link svg path { fill: $_ic; }";
        }
        if ( ! empty( $attrs['styleSocialIconHoverColor'] ) ) {
            $_hc = esc_attr( $attrs['styleSocialIconHoverColor'] );
            $_css[] = "$sc .htm25-team__card-social .htm25-team__card-social-link:hover i, $sc .htm25-team__card-social-overlay .htm25-team__card-social-link:hover i { color: $_hc; }";
            $_css[] = "$sc .htm25-team__card-social .htm25-team__card-social-link:hover svg, $sc .htm25-team__card-social-overlay .htm25-team__card-social-link:hover svg { color: $_hc; }";
            $_css[] = "$sc .htm25-team__card-social .htm25-team__card-social-link:hover svg path, $sc .htm25-team__card-social-overlay .htm25-team__card-social-link:hover svg path { fill: $_hc; }";
        }
        if ( ! empty( $attrs['styleSocialIconSize'] ) ) {
            $_sz = esc_attr( $attrs['styleSocialIconSize'] );
            $_css[] = "$sc .htm25-team__card-social .htm25-team__card-social-link svg, $sc .htm25-team__card-social-overlay .htm25-team__card-social-link svg { width: {$_sz}px; height: {$_sz}px; }";
            $_css[] = "$sc .htm25-team__card-social .htm25-team__card-social-link i, $sc .htm25-team__card-social-overlay .htm25-team__card-social-link i { font-size: {$_sz}px; }";
        }
        if ( ! empty( $attrs['styleSocialIconBgColor'] ) ) {
            $_bg = esc_attr( $attrs['styleSocialIconBgColor'] );
            $_css[] = "$sc .htm25-team__card-social .htm25-team__card-social-link, $sc .htm25-team__card-social-overlay .htm25-team__card-social-link { background-color: $_bg; }";
        }

        return self::_gf_imports( $attrs ) . implode( "\n", $_css );
    }

    // ── FAQ ──────────────────────────────────────────────────────

    private static function faq_css( $attrs ) {
        $sc   = '.htmega-block-' . ( $attrs['blockUniqId'] ?? 'x' );
        $_css = [];

        $_sec = [];
        if ( ! empty( $attrs['styleSectionBgColor'] )    ) $_sec[] = 'background-color: ' . esc_attr( $attrs['styleSectionBgColor'] );
        if ( ! empty( $attrs['styleSectionBgGradient'] ) ) { $_sec[] = 'background: ' . esc_attr( $attrs['styleSectionBgGradient'] ); $_sec[] = 'background-color: transparent'; }
        $_sec = array_merge( $_sec, self::_dim( $attrs['styleSectionPadding'] ?? null, 'padding' ), self::_border( $attrs['sectionBorderType'] ?? null, $attrs['sectionBorderWidth'] ?? null, $attrs['sectionBorderColor'] ?? null ), self::_radius( $attrs['styleSectionBorderRadius'] ?? null ) );
        $_sw = self::_shadow( $attrs['styleSectionShadow'] ?? null ); if ( $_sw ) $_sec[] = $_sw;
        if ( ! empty( $_sec ) ) $_css[] = $sc . ' .htm25-faq { ' . implode( '; ', $_sec ) . '; }';
        if ( ! empty( $attrs['styleContainerMaxWidth'] ) ) $_css[] = $sc . ' .htm25-faq__inner { max-width: ' . esc_attr( $attrs['styleContainerMaxWidth'] ) . '; }';

        $_hl = array_merge( self::_typo( $attrs['styleHeadlineTypography'] ?? null ), self::_dim( $attrs['styleHeadlineMargin'] ?? null, 'margin' ) );
        if ( ! empty( $attrs['styleHeadlineColor'] ) ) $_hl[] = 'color: ' . esc_attr( $attrs['styleHeadlineColor'] );
        self::_rule( $sc, ' .htm25-faq__headline', $_hl, $_css );
        if ( ! empty( $attrs['styleHeadlineHighlightColor'] )   ) $_css[] = $sc . ' .htm25-faq__headline-accent { background-color: ' . esc_attr( $attrs['styleHeadlineHighlightColor'] ) . '; background-image: none; }';
        if ( ! empty( $attrs['styleHeadlineHighlightGradient'] ) ) $_css[] = $sc . ' .htm25-faq__headline-accent { background: ' . esc_attr( $attrs['styleHeadlineHighlightGradient'] ) . '; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-color: transparent; }';

        $_desc = self::_typo( $attrs['styleDescTypography'] ?? null );
        if ( ! empty( $attrs['styleDescColor'] ) ) $_desc[] = 'color: ' . esc_attr( $attrs['styleDescColor'] );
        self::_rule( $sc, ' .htm25-faq__description', $_desc, $_css );

        $_lbl = self::_typo( $attrs['styleLabelTypography'] ?? null );
        if ( ! empty( $attrs['styleLabelColor'] )   ) $_lbl[] = 'color: '            . esc_attr( $attrs['styleLabelColor'] );
        if ( ! empty( $attrs['styleLabelBgColor'] ) ) $_lbl[] = 'background-color: ' . esc_attr( $attrs['styleLabelBgColor'] );
        $_lbl = array_merge( $_lbl, self::_radius( $attrs['styleLabelRadius'] ?? null ), self::_dim( $attrs['styleLabelPadding'] ?? null, 'padding' ) );
        self::_rule( $sc, ' .htm25-faq__section-label', $_lbl, $_css );

        $_item = array_merge( self::_border( $attrs['itemBorderType'] ?? null, $attrs['itemBorderWidth'] ?? null, $attrs['itemBorderColor'] ?? null ), self::_radius( $attrs['styleItemBorderRadius'] ?? null ) );
        if ( ! empty( $attrs['styleItemBgColor'] ) ) $_item[] = 'background-color: ' . esc_attr( $attrs['styleItemBgColor'] );
        $_isw = self::_shadow( $attrs['styleItemShadow'] ?? null ); if ( $_isw ) $_item[] = $_isw;
        self::_rule( $sc, ' .htm25-faq .htm25-faq__item', $_item, $_css );

        $_q = self::_typo( $attrs['styleQuestionTypography'] ?? null );
        if ( ! empty( $attrs['styleQuestionColor'] ) ) $_q[] = 'color: ' . esc_attr( $attrs['styleQuestionColor'] );
        self::_rule( $sc, ' .htm25-faq__item-question', $_q, $_css );
        if ( ! empty( $attrs['styleQuestionActiveColor'] )   ) $_css[] = $sc . ' .htm25-faq__item[open] .htm25-faq__item-question { color: ' . esc_attr( $attrs['styleQuestionActiveColor'] ) . '; }';
        if ( ! empty( $attrs['styleQuestionActiveBgColor'] ) ) $_css[] = $sc . ' .htm25-faq .htm25-faq__item[open] { background-color: ' . esc_attr( $attrs['styleQuestionActiveBgColor'] ) . '; }';

        $_ans = self::_typo( $attrs['styleAnswerTypography'] ?? null );
        if ( ! empty( $attrs['styleAnswerColor'] ) ) $_ans[] = 'color: ' . esc_attr( $attrs['styleAnswerColor'] );
        self::_rule( $sc, ' .htm25-faq .htm25-faq__item .htm25-faq__item-answer', $_ans, $_css );

        $_tag = array_merge( self::_typo( $attrs['styleTagTypography'] ?? null ), self::_radius( $attrs['styleTagRadius'] ?? null ) );
        if ( ! empty( $attrs['styleTagColor'] )   ) $_tag[] = 'color: ' . esc_attr( $attrs['styleTagColor'] );
        if ( ! empty( $attrs['styleTagBgColor'] ) ) $_tag[] = 'background-color: ' . esc_attr( $attrs['styleTagBgColor'] );
        self::_rule( $sc, ' .htm25-faq__item-category', $_tag, $_css );

        if ( ! empty( $attrs['styleChevronSize'] )        ) $_css[] = $sc . ' .htm25-faq__item-icon { width: '  . esc_attr( $attrs['styleChevronSize'] ) . 'px; height: ' . esc_attr( $attrs['styleChevronSize'] ) . 'px; }';
        if ( ! empty( $attrs['styleChevronColor'] )       ) $_css[] = $sc . ' .htm25-faq__item-icon { color: '  . esc_attr( $attrs['styleChevronColor'] ) . '; }';
        if ( ! empty( $attrs['styleChevronActiveColor'] ) ) $_css[] = $sc . ' .htm25-faq__item[open] .htm25-faq__item-icon { color: ' . esc_attr( $attrs['styleChevronActiveColor'] ) . '; }';

        return self::_gf_imports( $attrs ) . implode( "\n", $_css );
    }

}
