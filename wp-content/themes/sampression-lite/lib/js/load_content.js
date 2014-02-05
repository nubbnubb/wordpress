/**
 * Ajax Function
 * An exquisite jQuery plugin for magical layouts
 *
 * Author: Sampression
 * Author URI: http://sampression.com
 */
 
function appenditem(slug) {
	var ids = new Array();
	var i = 0;
	jQuery('.post').each(function(){
		var pid = jQuery(this).attr('id');
		pid = pid.split('-');
		ids[i] = pid[1];
		i++;
	});
	var postid = ids.join('~');
	jQuery.post(
		MyAjax.ajaxurl, {
			action : 'filter-cat-data',
			category : slug,
			exclude: postid
		},
		function( response ) {
			var $newItems = jQuery(response);
			jQuery('#post-listing').append( $newItems ).isotope( 'appended', $newItems );
		}
	);
	return false;
}