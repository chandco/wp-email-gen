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
				jQuery("input#wpen_cta_link").val(obj.cta_link);
				jQuery("input#wpen_cta_text").val(obj.cta_text);
				jQuery("#wpen_status").html(obj.addedthumbnail);
				
				jQuery(this).html("Add this blog post's content");
				jQuery(this).prop('disabled', false);
				
				jQuery("form#post").submit();
				
				}); // jquery post
		
	});// click populate_wpen
	
	



	}); // document ready


jQuery(document).ready(function() {
    jQuery("#wpen_sortable ul").sortable(
	
		{
			axis: 'y',
			cursor: 'move',
			stop: function (event, ui) {
				data = {}
				data.serialize = jQuery(this).sortable('serialize');
				data.action = "saveorder";
				console.log(data);
				// data = item[]=1&item[]=2
				jQuery("#wpen_status").html("saving order...");
				jQuery.post(
			
					wpen.ajaxurl,
			
					data,
			
					function ( response ) {
						
						if (response == "true")
						{
						// response will be string true or false
							jQuery("#wpen_status").html("Saved new order").delay(800).html("");
						} else {
							jQuery("#wpen_status").html("ERROR! Problems saving order").delay(800).html("");
						}
					}
					);
				} // stop: function (event, ui)
	}); // jQuery("#wpen_sortable ul").sortable(

    jQuery('#wpen_sortable ul').disableSelection();
    jQuery('#wpen_sortable li').disableSelection();
	
	});
