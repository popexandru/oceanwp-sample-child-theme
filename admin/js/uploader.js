function s360_callback( callback, args ){
	(function( c, p ){
        try{
            c( p );
        } catch( e ){
            if ( e instanceof SyntaxError ){
                console.log( ( e.message ) );
            }
        }
    })( callback, args );
}

var S360MediaUploader = function S360MediaUploader( args, callback ){
	jQuery(function($){

		var custom_uploader;

		if (custom_uploader) {
			custom_uploader.open();
			return;
		}

		custom_uploader = wp.media({
			title: 'Selectează',	// args.media.title
			button: {
				text: 'Selectează' // args.media.button
			},
			multiple: false,
			//library: {
                //type: [ 'image', 'video', 'audio', 'pdf' ] // args.media.type video | image ( from registred setting )
            //}
		});

		custom_uploader.on( 'select', function() {
			var data = custom_uploader.state().get('selection').first().toJSON();

			if( typeof args === "object" ){

				args.attachment = data;

				if( typeof callback === "function" ){
					s360_callback( callback, args );
				}
			}
			else{
				console.log( 'MISSING ARGS [ OBJECT TYPE ARGS ]:', typeof args, args );
			}
		});

		custom_uploader.open();
	});
}

/**
 *	Uploader Class
 */
var S360Uploader = function S360Uploader(callback){

	/**
	 *	Setup Upload Function
	 */

	var S360Upload = function S360Upload( el ){
		new S360MediaUploader({
			'el' : el
		}, callback );
	}

	var Init = function Init( selector ){
		jQuery(function(){

			/**
			 *	Init Upload Actions
			 */

			jQuery( selector ).each(function(){
				var self = this;

				if( !jQuery( self ).hasClass( 'is-init-upload') ){

                    jQuery( self ).addClass( 'is-init-upload');
    				jQuery( self ).find( '[type="button"]' ).on( 'click', function(event){

    					event.preventDefault();

    					new S360Upload( self );
    				});
				}
			});
		});
	}

	new Init( '.s360-field.s360-upload' );
}

/**
 *	Uploader Class Instance
 */
new S360Uploader(function(args){
	jQuery(function(){
		if( args.hasOwnProperty( 'el' ) ){
			jQuery( args.el ).find( 'input[type="url"]' ).val( args.attachment.url );
		}
	});
});
