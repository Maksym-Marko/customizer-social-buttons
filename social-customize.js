jQuery( document ).ready( function( $ ) {

	// add button
	$( '.mx_add_new_social_button' ).on( 'click', function(e) {

		var icon = $( '#mx_add_new_button_icon' ).val();

		var url = $( '#mx_add_new_button_url' ).val();

		var button_element = $( '.mx-template-social-button-el' );

		button_element.clone()
			.appendTo( '.mx-social-buttons-wrap' )
			.removeClass( 'mx-template-social-button-el' )
			.addClass( 'social-button-element-editable' );

		$( '.social-button-element-editable' ).find( 'i' ).addClass( 'icon-' + icon );

		$( '.social-button-element-editable' ).find( 'i' ).attr( 'data-icon', icon );

		$( '.social-button-element-editable' ).find( 'input' ).val( url );

		$( '.mx-social-buttons-wrap' ).find( '.social-button-element-editable' ).removeClass( 'social-button-element-editable' );

		setTimeout( function() {
			mx_parse_buttons();
		}, 1000 );

		e.preventDefault();

	} );

	var ajaxurl = social_button_obj.ajaxurl;

	var social_buttons_array = [];

	$( '.mx-social-buttons-wrap' ).each( function() {

		$( this ).on( 'blur', 'input', function() {

			mx_parse_buttons();

		} );

	} );

	// delete button
	$( '.mx-social-buttons-wrap' ).on( 'click', '.mx-delete-social-button', function( e ) {

		$(this).parent().remove();

		mx_parse_buttons();

		e.preventDefault();

	} );
	


	// each button
	function mx_parse_buttons() {

		social_buttons_array = [];

		$( '.mx-social-buttons-wrap .mx-social-button' ).each( function() {

			var _icon = $( this ).find( 'i' ).attr( 'data-icon' );				

			var input_val = $( this ).find( 'input' ).val();

			social_buttons_array.push( {
				icon: _icon,
				url: input_val
			} );

		} );

		mx_social_ajax( ajaxurl, social_buttons_array );						

	}

	// ajax
	function mx_social_ajax( ajaxurl, social_data ) {

		var data = {

			'action'					: 	'social_buttons',
			'nonce'						: 	$( '#mx_nonce_request' ).val(),
			'social_data'				: 	social_data

		};

		jQuery.post( ajaxurl, data, function( response ) {

			$( '#mx_social_button_input' ).val( response );

			$( '#mx_social_button_input' ).change();

		} );

	}

} );