var CAHNRS_PDF = {
	
	wrap: jQuery('#cwp-pdf-editor'),
	
	init:function(){
		
		CAHNRS_PDF.wrap.on('click' , '.cwp-pdf-update a' , function(){
			event.preventDefault();
			CAHNRS_PDF.update_pdf( jQuery( this ) );
			});
		
	},
	
	update_pdf:function( ic ){
		
		CAHNRS_PDF.show_window();
		
		jQuery.get(
			ic.attr('href'),
			function( response ){
				
				console.log( response );
				
				CAHNRS_PDF.set_response( response );
				
			},
			'json'
		);
		
	},
	
	set_response: function( response ){
		
		if ( response.file ){
			
			var txt = 'Success! PDF updated';
			
			jQuery('.cwp-pdf-url input').val( response.file );
			
		} else {
			
			var txt = 'Well snap, something went wrong';
			
		} //
		
		CAHNRS_PDF.update_modal( txt );
		
	},
	
	update_modal:function( txt ){
		
		var modal = jQuery('#cwp-pdf-modal');
		
		modal.find('div').html( txt );
		
		var timer = setTimeout( function(){ CAHNRS_PDF.hide_window(); } , 1500 );
		
	},
	
	show_window:function(){
		
		var msg = 'Generating PDF. Please Wait...';
		
		var bg = '<div id="cwp-pdf-bg"></div>';
		
		var modal = '<div id="cwp-pdf-modal"><div>' + msg + ' </div></div>';
		
		jQuery('body').append( bg + modal );
		
	},
	
	hide_window:function(){
		
		var bg = jQuery('#cwp-pdf-bg');
		
		var modal = jQuery('#cwp-pdf-modal');
		
		modal.fadeOut('fast', function(){ jQuery( this ).remove()} );
		
		bg.fadeOut('fast', function(){ jQuery( this ).remove()} );
		
	},
	
}

CAHNRS_PDF.init();