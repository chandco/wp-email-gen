// JavaScript Document




jQuery(document).ready(function(e) {



jQuery ("button#populate_wpen").click(function(e) {
	
	
	var postID = jQuery("#find-a-post").val();
	
	
	if (postID == "nothing") return false;



	data = {}
	data.storyid = jQuery('#wpen-current-post').val();
	
	jQuery(this).prop('disabled', true);
	
	jQuery(this).html("loading...");
	
	
	
	data.action = "loadpost";
	data.postid = postID; // the id of the blog post we're importing
	
	 // the newsletter story id
	jQuery.post(
		
				wpen.ajaxurl,
		
				data,
		
				function ( response ) {
		
		
				var obj = jQuery.parseJSON( response );
				
				jQuery("input#title").val(obj.post_title);
				jQuery("textarea#content").val(obj.post_content);
				jQuery("#wpen_status").html(obj.addedthumbnail);
				
				jQuery(this).html("Add this blog post's content");
				jQuery(this).prop('disabled', false);
				
				jQuery("form#post").submit();
				
				}); // jquery post
		
			});// click populate_wpen
	
	



	}); // document ready


jQuery(document).ready(function() {
    jQuery("#wpen_sortable ul").sortable({
		axis: 'y',
        cursor: 'move',
		stop: function (event, ui) {
			var data = jQuery(this).sortable('serialize');
			data.action = "saveorder";
			
			// data = item[]=1&item[]=2
			jQuery.post(
		
				wpen.ajaxurl,
		
				data,
		
				function ( response ) {
					
					
				}
    });

    jQuery('#wpen_sortable ul').disableSelection();
    jQuery('#wpen_sortable li').disableSelection();
});