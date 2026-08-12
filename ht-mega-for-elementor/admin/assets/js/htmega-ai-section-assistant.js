/**
 * HT Mega AI Section Assistant — editor UI
 * File: admin/assets/js/htmega-ai-section-assistant.js
 *
 * Canvas trigger (the icon added to Elementor's "Drag widget here" row) and
 * insertion (document/elements/create) are both confirmed working in a live
 * Elementor session. The canvas-trigger mechanism intentionally mirrors
 * admin/assets/js/elementors_template_library.js's own injector — same
 * selector, same elementor.$previewContents reference, same preview:loaded
 * event — since that code is this plugin's own proven pattern for reaching
 * the canvas.
 */
/* global elementor, $e */
( function ( $ ) {
	'use strict';

	var cfg = window.htmegaAISectionAssistant || {};
	var strings = cfg.strings || {};

	window.HTMegaAISectionAssistant = {

		$modal: null,
		targetContainer: null, // Elementor container the next insert should target, if known.
		currentPreviewIndex: null, // Which result the open lightbox is showing — see openPreviewLightbox().

		init: function () {
			this.buildModal();
			this.buildPreviewLightbox();
			this.bindTriggers();
		},

		/* ---------------------------------------------------------------
		 * Entry points
		 * ------------------------------------------------------------- */

		// Matches admin/assets/js/elementors_template_library.js's own injector —
		// same selector, same insertion point, same events.
		SPARKLE_FIND_SELECTOR: '.elementor-add-new-section .elementor-add-section-drag-title',

		bindTriggers: function () {
			var self = this;

			// Removed: a button injected into #elementor-panel-header-wrapper. Dropped
			// after live testing — it showed up floating above the widget-edit panel
			// (Content/Style/Advanced tabs), a context mismatch (you're editing an
			// existing widget there, not adding new content) and visually disconnected
			// from Elementor's own UI. The canvas sparkle below is the sole entry point
			// now — contextually correct (appears exactly where/when you'd add a new
			// section) and consistent with where Elementor puts its own AI trigger.

			if ( window.elementor && typeof elementor.on === 'function' ) {
				elementor.on( 'preview:loaded', function () {
					self.setupCanvasTrigger();
				} );
				// preview:loaded may have already fired before this script attached
				// (enqueue-order dependent) — $previewContents existing means it did.
				if ( elementor.$previewContents && elementor.$previewContents.length ) {
					self.setupCanvasTrigger();
				}
			}
		},

		setupCanvasTrigger: function () {
			var self = this;
			var $pc = window.elementor && elementor.$previewContents;
			if ( ! $pc || ! $pc.length || this._canvasTriggerBound ) {
				return;
			}
			this._canvasTriggerBound = true;

			function inject() {
				$pc.find( self.SPARKLE_FIND_SELECTOR ).each( function () {
					var $title = jQuery( this );
					if ( $title.siblings( '.htmega-ai-section-sparkle' ).length ) {
						return;
					}
					// Deliberately a pill, not a plain circle like the '+'/template/native-AI
					// icons — a shape difference can't be confused with another icon glyph
					// the way a same-size circle can (this button went through two rounds
					// of "looks the same as X" with icon-only attempts before this).
					$title.before(
						'<div class="elementor-add-section-area-button htmega-ai-section-sparkle" ' +
							'title="' + ( strings.panelTitle || 'HT Mega AI' ) + '">' +
							'<i class="eicon-ai" aria-hidden="true"></i>' +
							'<span>' + ( strings.panelTitle || 'HT Mega AI' ) + '</span>' +
						'</div>'
					);
				} );
			}

			// Same polling-until-first-match pattern as the template-library injector:
			// keep retrying fast (new sections can appear anytime) until at least one
			// exists, then rely on the click-triggered re-injection below for new ones
			// created afterward (e.g. via the "+" add-element icon).
			var poll = setInterval( function () {
				inject();
				if ( $pc.find( '.elementor-add-new-section' ).length > 0 ) {
					clearInterval( poll );
				}
			}, 100 );

			// Re-run injection when Elementor adds a new empty-section placeholder
			// (mirrors the template-library injector's own re-bind on this same event).
			$pc.on( 'click.htmegaAiAddElement', '.elementor-editor-section-settings .elementor-editor-element-add', function () {
				setTimeout( inject, 50 );
			} );

			$pc.on( 'click.htmegaAiSparkle', '.htmega-ai-section-sparkle', function ( e ) {
				e.preventDefault();
				e.stopPropagation();
				// This row's job is creating a new top-level section at this position,
				// not targeting an existing container — document root is the correct target.
				self.targetContainer = null;
				self.openModal();
			} );
		},

		/* ---------------------------------------------------------------
		 * Modal
		 * ------------------------------------------------------------- */

		buildModal: function () {
			var self = this;

			this.$modal = $(
				'<div class="htmega-ai-section-modal" style="display:none;">' +
					'<div class="htmega-ai-section-modal__overlay"></div>' +
					'<div class="htmega-ai-section-modal__box">' +
						'<div class="htmega-ai-section-modal__header">' +
							'<strong>' + ( strings.panelTitle || 'Build with HT Mega AI' ) + '</strong>' +
							'<button type="button" class="htmega-ai-section-modal__close">&times;</button>' +
						'</div>' +
						'<div class="htmega-ai-section-modal__body">' +
							'<div class="htmega-ai-section-modal__mode">' +
								'<label><input type="radio" name="htmega-ai-mode" value="section" checked> ' + ( strings.oneSection || 'Add one section' ) + '</label>' +
								'<label><input type="radio" name="htmega-ai-mode" value="page"> ' + ( strings.fullPage || 'Build a full page' ) + '</label>' +
							'</div>' +
							'<div class="htmega-ai-page-name-wrap" style="display:none;">' +
								'<input type="text" class="htmega-ai-page-name" placeholder="' + ( strings.pageNamePlaceholder || 'Page/business name — e.g. \"Bella Vista Restaurant\"' ) + '" />' +
								'<p class="htmega-ai-section-modal__hint">' + ( strings.pageNameHint || 'Optional — set this once and every generated section uses the exact name consistently, instead of relying on it being mentioned (and spelled the same way) in the prompt each time.' ) + '</p>' +
							'</div>' +
							'<label class="htmega-ai-section-modal__field-label">' + ( strings.promptLabel || 'What would you like to generate?' ) + '</label>' +
							'<textarea class="htmega-ai-section-modal__prompt" placeholder="' + ( strings.placeholder || '' ) + '"></textarea>' +
							'<div class="htmega-ai-section-modal__status" aria-live="polite"></div>' +
							'<div class="htmega-ai-section-modal__results"></div>' +
						'</div>' +
						'<div class="htmega-ai-section-modal__footer">' +
							'<button type="button" class="htmega-ai-section-modal__cancel">' + ( strings.cancel || 'Cancel' ) + '</button>' +
							'<button type="button" class="htmega-ai-section-modal__regenerate" style="display:none;">' + ( strings.regenerate || 'Regenerate' ) + '</button>' +
							'<button type="button" class="htmega-ai-section-modal__generate">' + ( strings.generate || 'Generate' ) + '</button>' +
						'</div>' +
					'</div>' +
				'</div>'
			);

			var $pageNameWrap = this.$modal.find( '.htmega-ai-page-name-wrap' );

			// No manual page-type control — the backend always classifies it from the
			// prompt (see HTMega_AI_Section_Assistant::classify_page_type()). Removed
			// after review: with auto-detect as the only path anyway, a dropdown next
			// to a prompt that already says what page it is just duplicated the input.
			this.$modal.find( 'input[name="htmega-ai-mode"]' ).on( 'change', function () {
				$pageNameWrap.toggle( $( this ).val() === 'page' );
				// Switching mode mid-session starts that mode fresh — a prior
				// mode's results/history don't carry over (page mode's Insert-all
				// flow and section mode's Regenerate history aren't compatible
				// concepts), and this also avoids a real edge case: Generate hides
				// itself once Regenerate takes over (see generateOneSection()), so
				// without this reset, switching page -> section -> page again could
				// leave BOTH buttons hidden/disabled with no way to generate at all.
				self.$modal.find( '.htmega-ai-section-modal__results' ).empty();
				self.lastElements = [];
				self.setStatus( '' );
				self.$modal.find( '.htmega-ai-section-modal__generate' )
					.prop( 'disabled', false )
					.text( strings.generate || 'Generate' )
					.show();
				self.$modal.find( '.htmega-ai-section-modal__regenerate' ).hide();
			} );

			this.$modal.on( 'click', '.htmega-ai-section-modal__close, .htmega-ai-section-modal__overlay, .htmega-ai-section-modal__cancel', function () {
				self.closeModal();
			} );

			this.$modal.on( 'click', '.htmega-ai-section-modal__generate', function () {
				self.generate();
			} );

			this.$modal.on( 'click', '.htmega-ai-section-modal__regenerate', function () {
				self.regenerate();
			} );

			this.$modal.on( 'click', '.htmega-ai-section-result__insert', function () {
				var index = $( this ).data( 'index' );
				self.insertResult( index, $( this ) );
			} );

			this.$modal.on( 'click', '.htmega-ai-preview-btn', function () {
				self.openPreviewLightbox( $( this ).data( 'index' ) );
			} );

			$( 'body' ).append( this.$modal );
		},

		/**
		 * A separate, larger overlay (own DOM tree, own z-index, sits above the
		 * main modal) for "view the full design," not squeezed into a fixed-height
		 * thumbnail. Built once at init, reused for whichever result the user
		 * clicks Preview on — see openPreviewLightbox() for how it's filled in.
		 */
		buildPreviewLightbox: function () {
			var self = this;

			this.$previewLightbox = $(
				'<div class="htmega-ai-lightbox" style="display:none;">' +
					'<div class="htmega-ai-lightbox-overlay"></div>' +
					'<div class="htmega-ai-lightbox-actions">' +
						'<button type="button" class="htmega-ai-section-result__insert htmega-ai-lightbox-insert">' + ( strings.insert || 'Insert' ) + '</button>' +
						'<button type="button" class="htmega-ai-lightbox-close">&times;</button>' +
					'</div>' +
					'<div class="htmega-ai-lightbox-scroll">' +
						'<div class="htmega-ai-lightbox-body"></div>' +
					'</div>' +
				'</div>'
			);

			this.$previewLightbox.on( 'click', '.htmega-ai-lightbox-overlay, .htmega-ai-lightbox-close', function () {
				self.$previewLightbox.hide().find( '.htmega-ai-lightbox-body' ).empty();
			} );

			// Insert straight from the full-size view — no need to close the
			// lightbox first, find the same row in the results list, and click
			// Insert there too. insertResult() already does everything else
			// (finds the right cached element, runs document/elements/create,
			// handles the single-section-vs-full-page auto-close rule); this
			// only needs to know WHICH index is currently open and close the
			// lightbox itself afterward, matching what the close button does.
			this.$previewLightbox.on( 'click', '.htmega-ai-lightbox-insert', function () {
				var $btn = $( this );
				if ( $btn.prop( 'disabled' ) || null == self.currentPreviewIndex ) {
					return;
				}
				self.insertResult( self.currentPreviewIndex, $btn );
				// Keep the matching row's own Insert button (back in the results
				// list, a separate DOM element from this one) in sync — otherwise
				// it stays clickable and a second click there would insert the
				// same section again.
				self.$modal.find( '.htmega-ai-section-result__insert[data-index="' + self.currentPreviewIndex + '"]' )
					.prop( 'disabled', true ).text( strings.inserted || 'Inserted' );
				self.$previewLightbox.hide().find( '.htmega-ai-lightbox-body' ).empty();
			} );

			$( 'body' ).append( this.$previewLightbox );
		},

		openModal: function () {
			this.$modal.find( '.htmega-ai-section-modal__prompt' ).val( '' );
			this.$modal.find( '.htmega-ai-section-modal__status' ).empty();
			this.$modal.find( '.htmega-ai-section-modal__results' ).empty();
			// Generate locks permanently after a successful generation (see generate()) —
			// reset it here so each fresh open of the modal starts from a clean, usable state.
			this.$modal.find( '.htmega-ai-section-modal__generate' )
				.prop( 'disabled', false )
				.text( strings.generate || 'Generate' )
				.show();
			this.$modal.find( '.htmega-ai-section-modal__regenerate' ).hide();
			this.$modal.show();
		},

		closeModal: function () {
			this.$modal.hide();
			if ( this.$previewLightbox ) {
				this.$previewLightbox.hide().find( '.htmega-ai-lightbox-body' ).empty();
			}
		},

		setStatus: function ( text, isError ) {
			this.$modal.find( '.htmega-ai-section-modal__status' )
				.text( text )
				.css( 'color', isError ? '#c4342b' : '' );
		},

		/* ---------------------------------------------------------------
		 * Generation + insertion
		 * ------------------------------------------------------------- */

		/**
		 * Build one result row (thumbnail + descriptor + Insert button) and append
		 * it to the results list. Shared by both single-section mode and the
		 * full-page loop below — index MUST match this element's position in
		 * self.lastElements, since insertResult(index) reads straight off that
		 * array.
		 */
		appendResultRow: function ( el, meta, index, versionLabel ) {
			var self = this;
			meta = meta || {};
			// Server-computed human-readable descriptor (see generate_section()'s
			// 'meta' in section-assistant.php) — not the raw widgetType/settings
			// slugs, which read as internal IDs ("htmega-2026-cta — centered / neo")
			// rather than something a non-technical user recognizes.
			var descriptor = ( meta.label || 'Section' ) + ' — ' + ( meta.layout || '' ) + ', ' + ( meta.style || '' );
			// versionLabel only ever passed for single-section regenerate history
			// (see generateOneSection()) — every row there IS the same section, so
			// "v1"/"v2" tells attempts apart. Full-page mode's rows are DIFFERENT
			// sections, not versions of one, so it's omitted there (no versionLabel
			// passed at that call site). A small pill, not plain inline text, so it
			// reads as metadata/a tag rather than part of the sentence.
			var versionBadge = versionLabel ? '<span class="htmega-ai-section-result__version">' + versionLabel + '</span>' : '';
			var $results = this.$modal.find( '.htmega-ai-section-modal__results' );
			var $row = $(
				'<div class="htmega-ai-section-result">' +
					'<div class="htmega-ai-preview-thumb-wrap">' +
						'<div class="htmega-ai-preview-thumb"></div>' +
						'<button type="button" class="htmega-ai-preview-btn" data-index="' + index + '">' + ( strings.preview || 'Preview full design' ) + '</button>' +
					'</div>' +
					'<div class="htmega-ai-section-result__body">' +
						'<span>' + descriptor + versionBadge + '</span>' +
						'<button type="button" class="htmega-ai-section-result__insert" data-index="' + index + '">' + ( strings.insert || 'Insert' ) + '</button>' +
					'</div>' +
				'</div>'
			);
			$results.append( $row );
			// preview-btn only appears once the thumbnail actually rendered —
			// nothing to view full-size for a render that never resolved.
			$row.find( '.htmega-ai-preview-btn' ).hide();
			self.renderPreview( el, $row.find( '.htmega-ai-preview-thumb' ), index, $row.find( '.htmega-ai-preview-btn' ) );
		},

		generate: function () {
			var prompt = this.$modal.find( '.htmega-ai-section-modal__prompt' ).val().trim();
			var mode = this.$modal.find( 'input[name="htmega-ai-mode"]:checked' ).val();

			if ( ! prompt ) {
				this.setStatus( strings.emptyPrompt || 'Enter a prompt first.', true );
				return;
			}

			this.setStatus( strings.generating || 'Generating…' );
			this.$modal.find( '.htmega-ai-section-modal__results' ).empty();
			this.lastElements = [];
			this.lastPreviewData = {}; // cleared per generation — see renderPreview()/openPreviewLightbox()
			this.$modal.find( '.htmega-ai-section-modal__regenerate' ).hide();

			// Disabled + relabeled the instant this fires. On success it STAYS disabled
			// permanently for this modal session — trying again from here on is what
			// the separate Regenerate button is for (see generateOneSection()/
			// regenerate()), which appends to the results history instead of
			// replacing it. Only a failed attempt re-enables Generate itself.
			var $generateBtn = this.$modal.find( '.htmega-ai-section-modal__generate' );
			$generateBtn.prop( 'disabled', true ).text( strings.generating || 'Generating…' );

			var isPage = mode === 'page';

			if ( ! isPage ) {
				this.generateOneSection( prompt, $generateBtn );
				return;
			}

			var pageName = this.$modal.find( '.htmega-ai-page-name' ).val().trim();
			// Same fold-once-reuse-everywhere behavior the old server-side loop had —
			// every section's prompt sees the business name, not just the first.
			if ( pageName ) {
				prompt = 'Page/business name: ' + pageName + '. ' + prompt;
			}

			this.generateFullPage( prompt, $generateBtn );
		},

		/**
		 * Single-section mode. Shared by the initial Generate click AND every
		 * subsequent Regenerate click (see regenerate() below) — each call
		 * APPENDS one more result to the history (self.lastElements/the results
		 * list) rather than replacing it, so earlier attempts stay pickable
		 * instead of disappearing the moment a new one comes back.
		 *
		 * @param {string}  prompt
		 * @param {jQuery}  $btn       The button that triggered this call (Generate
		 *   the first time, Regenerate every time after) — re-enabled/relabeled
		 *   with its OWN idle label on failure; only failure re-enables it, same
		 *   permanently-disabled-on-success rule Generate always had.
		 * @param {string}  [idleLabel] Defaults to the Generate button's label.
		 */
		generateOneSection: function ( prompt, $btn, idleLabel ) {
			var self = this;
			idleLabel = idleLabel || ( strings.generate || 'Generate' );

			$.post( cfg.ajaxurl, {
				action: cfg.generateAction,
				nonce: cfg.nonce,
				prompt: prompt,
			} )
				.done( function ( response ) {
					if ( ! response || ! response.success ) {
						$btn.prop( 'disabled', false ).text( idleLabel );
						self.setStatus( ( response && response.data && response.data.message ) || strings.noMatch, true );
						return;
					}

					$btn.text( idleLabel );
					self.setStatus( strings.resultsReady || 'Pick a result to insert.' );

					var index = self.lastElements.length;
					self.lastElements.push( response.data.element );
					self.appendResultRow( response.data.element, response.data.meta, index, 'v' + ( index + 1 ) );

					// Regenerate REPLACES Generate visually the moment there's at least
					// one result — Generate is permanently disabled from here on (see
					// generate()), so leaving it visible next to Regenerate would just
					// be a dead, greyed-out button taking up space for no reason.
					self.$modal.find( '.htmega-ai-section-modal__generate' ).hide();
					self.$modal.find( '.htmega-ai-section-modal__regenerate' )
						.show().prop( 'disabled', false ).text( strings.regenerate || 'Regenerate' );
				} )
				.fail( function () {
					$btn.prop( 'disabled', false ).text( idleLabel );
					self.setStatus( strings.error || 'Something went wrong.', true );
				} );
		},

		/**
		 * Re-run the current prompt (read fresh — the user may have tweaked it)
		 * and add the result to the SAME history instead of starting over, so
		 * they can compare attempts and insert whichever one turned out best.
		 */
		regenerate: function () {
			var prompt = this.$modal.find( '.htmega-ai-section-modal__prompt' ).val().trim();
			if ( ! prompt ) {
				this.setStatus( strings.emptyPrompt || 'Enter a prompt first.', true );
				return;
			}

			this.setStatus( strings.generating || 'Generating…' );
			var $regenerateBtn = this.$modal.find( '.htmega-ai-section-modal__regenerate' );
			$regenerateBtn.prop( 'disabled', true ).text( strings.generating || 'Generating…' );

			this.generateOneSection( prompt, $regenerateBtn, strings.regenerate || 'Regenerate' );
		},

		/**
		 * Full-page mode — client-driven loop, one small request per section,
		 * instead of one long server-side request. Real bug this replaces: a
		 * prompt naming ~9 sections meant handle_generate_page() used to run up
		 * to ~19 sequential OpenAI calls inside ONE PHP request, long enough to
		 * trip the web server's own request timeout and fail with a generic
		 * "Something went wrong" (confirmed via an empty wp-content/debug.log —
		 * no PHP fatal, so this was never a script-side crash to catch server-side;
		 * it was the HTTP connection itself timing out). Splitting into many
		 * small requests keeps every single request well under any reasonable
		 * timeout, and gives real per-section progress as a side benefit.
		 */
		generateFullPage: function ( prompt, $generateBtn ) {
			var self = this;

			this.setStatus( strings.planningPage || 'Planning page sections…' );

			$.post( cfg.ajaxurl, {
				action: cfg.selectPageSectionsAction,
				nonce: cfg.nonce,
				prompt: prompt,
			} )
				.done( function ( response ) {
					var sections = ( response && response.success && response.data && response.data.sections ) || [];
					if ( ! sections.length ) {
						$generateBtn.prop( 'disabled', false ).text( strings.generate || 'Generate' );
						self.setStatus( ( response && response.data && response.data.message ) || strings.noMatch, true );
						return;
					}
					self.runPageSectionQueue( sections, prompt, 0, null, $generateBtn );
				} )
				.fail( function () {
					$generateBtn.prop( 'disabled', false ).text( strings.generate || 'Generate' );
					self.setStatus( strings.error || 'Something went wrong.', true );
				} );
		},

		/**
		 * Recursive one-at-a-time walk over the section list — sequential on
		 * purpose (not parallel), since lockedStyle from section 0's result has
		 * to be known before section 1's request is even built.
		 */
		runPageSectionQueue: function ( sections, prompt, i, lockedStyle, $generateBtn ) {
			var self = this;

			if ( i >= sections.length ) {
				this.finishPageGeneration( $generateBtn );
				return;
			}

			var section = sections[ i ];
			var progress = ( strings.generatingSection || 'Generating {current} of {total}: {slug}…' )
				.replace( '{current}', i + 1 )
				.replace( '{total}', sections.length )
				.replace( '{slug}', section.label || section.slug );
			this.setStatus( progress );

			var sectionHint = 'This is the "' + section.slug + '" section of the page. Overall page brief: ' + prompt;
			var data = {
				action: cfg.generateAction,
				nonce: cfg.nonce,
				prompt: sectionHint,
			};
			if ( lockedStyle ) {
				data.design_style = lockedStyle;
			}

			$.post( cfg.ajaxurl, data )
				.done( function ( response ) {
					if ( response && response.success && response.data && response.data.element ) {
						var index = self.lastElements.length;
						self.lastElements.push( response.data.element );
						self.appendResultRow( response.data.element, response.data.meta, index );
						// Lock every subsequent section to the FIRST section's style so
						// the page stays visually consistent — same rule the old
						// server-side loop used.
						if ( ! lockedStyle ) {
							lockedStyle = ( response.data.meta && response.data.meta.raw_style ) || null;
						}
					}
					// One section failing (no match, or the request itself erroring)
					// doesn't sink the rest of the page — just move on, same
					// partial-failure handling the old server-side loop had.
					self.runPageSectionQueue( sections, prompt, i + 1, lockedStyle, $generateBtn );
				} )
				.fail( function () {
					self.runPageSectionQueue( sections, prompt, i + 1, lockedStyle, $generateBtn );
				} );
		},

		finishPageGeneration: function ( $generateBtn ) {
			var self = this;

			if ( ! this.lastElements.length ) {
				$generateBtn.prop( 'disabled', false ).text( strings.generate || 'Generate' );
				this.setStatus( strings.noMatch || 'Could not generate any sections for this page.', true );
				return;
			}

			$generateBtn.text( strings.generate || 'Generate' );
			this.setStatus( strings.resultsReady || 'Pick a result to insert.' );

			if ( this.lastElements.length > 1 ) {
				var elements = this.lastElements;
				this.$modal.find( '.htmega-ai-section-modal__results' ).append(
					$( '<button type="button" class="htmega-ai-section-result__insert-all" style="width:100%;margin-top:4px;">' + ( strings.insertAll || 'Insert all' ) + '</button>' )
						.on( 'click', function () {
							$( this ).prop( 'disabled', true ).text( strings.inserted || 'Inserted' );
							elements.forEach( function ( _el, i ) {
								self.insertResult( i );
							} );
							self.setStatus( strings.draftNotice || '' );
							setTimeout( function () {
								self.closeModal();
							}, 700 );
						} )
				);
			}
		},

		/**
		 * Request a real server-rendered HTML preview of one generated element and
		 * drop it into $container as a scaled-down iframe thumbnail — same
		 * create_element_instance()/print_element() mechanism Elementor's own
		 * editor uses to preview a single element that isn't saved to any post
		 * yet (see handle_render_preview() in section-assistant.php for why this
		 * is accurate without needing per-post dynamic CSS: our AI only ever
		 * fills Content-tab fields, never Style-tab controls).
		 *
		 * Silently leaves the placeholder empty on any failure (missing context
		 * post ID, Elementor error, etc.) — the text descriptor next to it still
		 * works as a fallback, so a failed preview shouldn't block using the result.
		 *
		 * @param {number} index Cached into this.lastPreviewData so
		 *   openPreviewLightbox() can reopen the same render full-size without a
		 *   second server round-trip.
		 * @param {jQuery} [$previewBtn] Revealed only once the render actually
		 *   succeeds — nothing to view full-size for a thumbnail that never loaded.
		 */
		renderPreview: function ( element, $container, index, $previewBtn ) {
			var contextPostId = this.getContextPostId();
			if ( ! contextPostId ) {
				return;
			}

			$.post( cfg.ajaxurl, {
				action: cfg.renderPreviewAction,
				nonce: cfg.nonce,
				context_post_id: contextPostId,
				element: JSON.stringify( element ),
			} ).done( function ( response ) {
				if ( ! response || ! response.success || ! response.data.html ) {
					return;
				}

				this.lastPreviewData = this.lastPreviewData || {};
				this.lastPreviewData[ index ] = { html: response.data.html, css: response.data.css || [] };

				var cssLinks = ( response.data.css || [] ).map( function ( url ) {
					return '<link rel="stylesheet" href="' + url + '">';
				} ).join( '' );
				// This is a static thumbnail, not a scrollable preview — real content
				// (e.g. a blog widget's stacked cards) can genuinely be taller than the
				// iframe's own fixed height, which would otherwise show a working
				// scrollbar inside the scaled-down thumbnail. Force overflow:hidden on
				// the iframe's own document so it silently crops instead.
				var srcdoc = '<!doctype html><html><head>' + cssLinks +
					'<style>html,body{margin:0;overflow:hidden !important;}</style>' +
					'</head><body>' + response.data.html + '</body></html>';
				var $iframe = $( '<iframe class="htmega-ai-preview-iframe" scrolling="no"></iframe>' ).attr( 'srcdoc', srcdoc );
				$container.empty().append( $iframe );

				// Fixed 0.28 scale (the CSS default) doesn't match the thumbnail's real
				// width, leaving a blank gap on the right instead of filling it edge to
				// edge. Compute the scale from the container's actual width instead —
				// same real-width/1440 math as the lightbox, just height stays fixed
				// (140px) and cropped rather than fit, since this is the compact list
				// view, not the "see it all" one.
				var containerWidth = $container.width();
				if ( containerWidth ) {
					var thumbScale = containerWidth / 1440;
					$iframe.css( {
						width: '1440px',
						height: '500px',
						transform: 'scale(' + thumbScale + ')',
						transformOrigin: 'top left',
					} );
				}

				if ( $previewBtn ) {
					$previewBtn.show();
				}
			}.bind( this ) );
			// .fail() deliberately omitted — see docblock, empty placeholder is an
			// acceptable, non-blocking outcome here.
		},

		/**
		 * Reopen an already-rendered preview (see renderPreview()) at a size that
		 * actually fits the viewport, unscaled-down and uncropped — the thumbnail
		 * is deliberately tiny/cropped, this is the "let me actually see it" view.
		 * No second server request; this only replays cached HTML/CSS.
		 */
		openPreviewLightbox: function ( index ) {
			var data = this.lastPreviewData && this.lastPreviewData[ index ];
			if ( ! data ) {
				return;
			}

			this.currentPreviewIndex = index;
			// Mirror whatever state the matching row's own Insert button is
			// already in — if that section was inserted via the row before the
			// lightbox was ever opened, don't offer a second insert here either.
			var rowInserted = this.$modal.find( '.htmega-ai-section-result__insert[data-index="' + index + '"]' ).prop( 'disabled' );
			this.$previewLightbox.find( '.htmega-ai-lightbox-insert' )
				.prop( 'disabled', !! rowInserted )
				.text( rowInserted ? ( strings.inserted || 'Inserted' ) : ( strings.insert || 'Insert' ) );

			var cssLinks = ( data.css || [] ).map( function ( url ) {
				return '<link rel="stylesheet" href="' + url + '">';
			} ).join( '' );
			var srcdoc = '<!doctype html><html><head>' + cssLinks +
				'<style>html,body{margin:0;}</style>' + // full view: no overflow:hidden — see the whole thing, not a crop
				'</head><body>' + data.html + '</body></html>';

			var $iframe = $( '<iframe class="htmega-ai-lightbox-iframe" scrolling="no"></iframe>' ).attr( 'srcdoc', srcdoc );
			this.$previewLightbox.find( '.htmega-ai-lightbox-body' ).empty().append( $iframe );
			this.$previewLightbox.show();

			// Real content height isn't known until the iframe's own document has
			// loaded — measure it then, scale to fit the viewport width, and size
			// the outer scroll container to match so nothing is cropped or forced
			// into its own separate internal scrollbar.
			$iframe.on( 'load', function () {
				var frame = this;
				var doc = frame.contentDocument;
				var realWidth = 1440;
				var targetWidth = window.innerWidth - 30; // full width minus a 15px gap on each side
				var scale = targetWidth / realWidth;

				function applyHeight( realHeight ) {
					$( frame ).css( {
						width: realWidth + 'px',
						height: realHeight + 'px',
						transform: 'scale(' + scale + ')',
						transformOrigin: 'top left',
					} );
					$( frame ).parent().css( {
						width: Math.round( realWidth * scale ) + 'px',
						height: Math.round( realHeight * scale ) + 'px',
					} );
				}

				applyHeight( ( doc && doc.body && doc.body.scrollHeight ) || 600 );

				// Web fonts / icons referenced by the linked CSS can finish loading
				// (and reflow the layout) after this 'load' event already fired —
				// a one-shot measurement here left a stale height: a blank gap below
				// the content if the late reflow shrank it, or cropped content if it
				// grew. Keep syncing to the real height as it actually settles.
				if ( doc && doc.body && window.ResizeObserver ) {
					new ResizeObserver( function () {
						applyHeight( doc.body.scrollHeight );
					} ).observe( doc.body );
				}
			} );
		},

		/**
		 * Best-effort lookup of the post ID currently open in the editor — needed
		 * as an editing context for Elementor's element-instantiation API, not
		 * because the preview relates to that post's own content in any way.
		 */
		getContextPostId: function () {
			if ( window.elementor && elementor.config && elementor.config.document && elementor.config.document.id ) {
				return elementor.config.document.id;
			}
			if ( window.elementor && elementor.documents && typeof elementor.documents.getCurrent === 'function' ) {
				var doc = elementor.documents.getCurrent();
				if ( doc && doc.id ) {
					return doc.id;
				}
			}
			return null;
		},

		/**
		 * Insert a generated element via Elementor's own editor command — the
		 * identical command Elementor's own editor uses for a manual paste or
		 * its own AI layout insertion. This only changes in-editor state; the
		 * page still needs the user's normal Update/Publish click.
		 *
		 * @param {number} index
		 * @param {jQuery} [$btn] The clicked Insert button — always disabled
		 *   immediately on success (prevents a double-click inserting the same
		 *   section twice), regardless of mode. Omitted when called from the
		 *   "Insert all" loop, which handles its own button state/close.
		 */
		insertResult: function ( index, $btn ) {
			if ( ! this.lastElements || ! this.lastElements[ index ] ) {
				return;
			}
			var self = this;
			var model = this.lastElements[ index ];
			var container = this.resolveTargetContainer();

			if ( ! container || ! window.$e || typeof $e.run !== 'function' ) {
				this.setStatus( 'Could not find where to insert this section.', true );
				return;
			}

			try {
				$e.run( 'document/elements/create', {
					container: container,
					model: model,
				} );
				this.setStatus( strings.draftNotice || 'Inserted.' );

				if ( $btn ) {
					$btn.prop( 'disabled', true ).text( strings.inserted || 'Inserted' );

					// Auto-close only in single-section mode, where this is the one and
					// only result — nothing left to do after inserting it. In full-page
					// mode there are several individual results; closing after the first
					// one would make the rest unreachable, so leave the modal open and let
					// the user insert as many (or as few) as they want, or use Insert all.
					var isPageMode = this.$modal.find( 'input[name="htmega-ai-mode"]:checked' ).val() === 'page';
					if ( ! isPageMode ) {
						setTimeout( function () {
							self.closeModal();
						}, 700 );
					}
				}
			} catch ( err ) {
				console.error( 'HT Mega AI: $e.run(\'document/elements/create\') threw', err );
				this.setStatus( 'Insert failed: ' + ( err && err.message ? err.message : err ), true );
			}
		},

		/**
		 * this.targetContainer (set by the sparkle click) takes priority when known;
		 * otherwise the document root — confirmed working via elementor.documents
		 * .getCurrent().container in live testing.
		 */
		resolveTargetContainer: function () {
			if ( this.targetContainer ) {
				return this.targetContainer;
			}
			var doc = window.elementor && elementor.documents && elementor.documents.getCurrent && elementor.documents.getCurrent();
			return ( doc && doc.container ) || null;
		},
	};

	$( function () {
		if ( window.elementor ) {
			window.HTMegaAISectionAssistant.init();
		} else {
			$( window ).on( 'elementor:init', function () {
				window.HTMegaAISectionAssistant.init();
			} );
		}
	} );

} )( jQuery );
