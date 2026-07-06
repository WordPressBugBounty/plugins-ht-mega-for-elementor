( function ( $ ) {
	'use strict';

	function activatePlugin( btn ) {
		var params = window.htmegaPanelSettings || {};

		$.post( ajaxurl, {
			action: 'htmega_activate_contact_plugin',
			nonce:  params.contact_plugin_nonce,
		} )
		.done( function ( res ) {
			if ( res.success ) {
				btn.text( 'Activated! Saving & reloading…' );
				safeReload();
			} else {
				btn.text( 'Activation failed — try manually' ).prop( 'disabled', false );
			}
		} )
		.fail( function () {
			btn.text( 'Error — try manually' ).prop( 'disabled', false );
		} );
	}

	function safeReload() {
		// $e.run() is the modern Elementor command API (2.9+); returns a Promise.
		if ( window['$e'] && window['$e'].run ) {
			window['$e'].run( 'document/save/draft', { force: true } )
				.then( function () {
					// Clear dirty flag so Elementor removes its beforeunload listener.
					if ( window['elementor'] && window['elementor'].saver && window['elementor'].saver.setFlagEditorChange ) {
						window['elementor'].saver.setFlagEditorChange( false );
					}
					location.reload();
				} )
				.catch( function () { location.reload(); } );
		} else {
			location.reload();
		}
	}

	$( document ).on( 'click', '.htm25-cplugin-btn', function () {
		var btn    = $( this );
		var action = btn.data( 'action' );

		btn.text( 'Working…' ).prop( 'disabled', true );

		if ( action === 'install' ) {
			// wp.updates.installPlugin requires pagenow — not set in Elementor editor.
			if ( typeof window.pagenow === 'undefined' ) {
				window.pagenow = 'plugin-install';
			}
			wp.updates.installPlugin( {
				slug:    'ht-contactform',
				success: function () {
					btn.text( 'Activating…' );
					activatePlugin( btn );
				},
				error: function () {
					btn.text( 'Install failed — try manually' ).prop( 'disabled', false );
				},
			} );
		} else {
			activatePlugin( btn );
		}
	} );

} )( jQuery );
