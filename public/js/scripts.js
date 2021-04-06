// jQuery(function(){
//
//     /**
//      *  LIGHT-BOX
//      */
//
//     var el = jQuery('ul.variable-items-wrapper[data-attribute_name="attribute_pa_marime"]');
//     var el = jQuery('select#pa_marime');
//     // TO DO : add lunch URL
//
//     if(jQuery(el).length){
//         var td = jQuery(el).parent();
//         var sizes = jQuery( 'div.s360-sizes-wrapper' );
//
//         if(jQuery(sizes).length){
//
//             jQuery('<a class="s360-sizes" href="javascript:void(null);"><i class="fas fa-table"></i> Vezi tabelul de mărimi</a>').on('click', function(){
//                 jQuery( sizes ).removeClass( 'light-box' );
//                 jQuery( sizes ).find( 'a.s360-close' ).unbind( 'click' );
//                 jQuery( sizes ).find( 'a.s360-shadow' ).unbind( 'click' );
//
//                 if( jQuery( sizes ).length ){
//                     if( !jQuery( sizes ).hasClass( 'light-box' ) ){
//                         jQuery( sizes ).addClass( 'light-box' );
//
//                         jQuery( sizes ).find( 'a.s360-close' ).on( 'click', function(){
//                             jQuery( sizes ).removeClass( 'light-box' );
//                             jQuery( sizes ).find( 'a.s360-close' ).unbind( 'click' );
//                             jQuery( sizes ).find( 'a.s360-shadow' ).unbind( 'click' );
//                         });
//
//                         jQuery( sizes ).find( 'div.s360-shadow' ).on( 'click', function(){
//                             jQuery( sizes ).removeClass( 'light-box' );
//                             jQuery( sizes ).find( 'a.s360-close' ).unbind( 'click' );
//                             jQuery( sizes ).find( 'a.s360-shadow' ).unbind( 'click' );
//                         });
//                     }
//                 }
//             }).appendTo(td);
//         }
//     }
//
//     /**
//      *  TAB
//      */
//
//     var tab = jQuery( 'div.s360-tabs-wrapper' );
//
//     if( jQuery(tab).length ){
//         jQuery( tab ).find( 'nav li a').on( 'click', function(){
//             var li = jQuery(this).parent('li');
//
//             if( !jQuery(this).hasClass( 'current') ){
//                 jQuery(li).parent('ul').find('li').removeClass('current');
//                 jQuery(li).parent('ul').parent('nav').parent('div').find('div.s360-tabs div.s360-tab').removeClass('current');
//                 var index = jQuery(li).index();
//                 jQuery(li).addClass('current');
//                 jQuery(li).parent('ul').parent('nav').parent('div').find('div.s360-tabs div.s360-tab').eq(index).addClass('current');
//             }
//         });
//     }

//     /**
//      *  TEAM & MEMBERS
//      */
//
//     jQuery( '.s360-tm-readmore a' ).on( 'click', function(){
//         var parent  = jQuery( this ).parents( '.s360-tm-member' );
//         var wrapper = jQuery( this ).parents( '.s360-tm-member-wrapper' );
//
//         if( !jQuery( wrapper ).hasClass('slick-slide') ){
//             var width = jQuery( wrapper ).width();
//             var height = jQuery( wrapper ).height();
//
//             jQuery( wrapper ).css({
//                 'width' : width + 'px',
//                 'height' : height + 'px',
//             });
//         }
//
//         if( !jQuery( parent ).hasClass( 's360-expand' ) ){
//             jQuery( parent ).addClass( 's360-expand' );
//         }
//
//         jQuery( parent ).find( 'a.s360-tm-close' ).on( 'click', function(){
//             jQuery( parent ).removeClass( 's360-expand' );
//             jQuery( this ).prop( 'onclick', null ).off( 'click' );
//
//             if( !jQuery( wrapper ).hasClass('slick-slide') ){
//                 jQuery( wrapper ).attr( 'style' , '' );
//             }
//         });
//     });
// });
