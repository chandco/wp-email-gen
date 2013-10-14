// JavaScript Document




jQuery(document).ready(function(e) {



jQuery ("button#populate_wpen").click(function(e) {
	
	var postID = jQuery("#find-a-post").val();
	
	jQuery(this).prop('disabled', true);
	
	jQuery(this).html("loading...");
	
	data = {}
	
	data.action = "loadpost";
	data.postid = postID; // the id of the blog post we're importing
	
	data.storyid = jQuery('#wpen-current-post').val(); // the newsletter story id
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
				}); // jquery post
		
			});// click populate_wpen
	
	



	}); // document ready
