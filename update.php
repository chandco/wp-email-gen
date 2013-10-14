<?php

// This file performs a bunch of AJAX stuff.

include("../../../wp-load.php");


// different post actions define what happens here

switch ( $_POST["action"]):


case "loadpost":
// just get a post details and spit out 

  $post = get_post($_POST["postid"], "OBJECT");       

// check the thumbnail, does it have one? we won't overwrite if so...
		 
  $already_has_thumb = has_post_thumbnail($_POST["storyid"]);
  if (!$already_has_thumb)  {
	  // let's add from the added post as there wasn't one already
              $attached_image = get_post_thumbnail_id( $_POST["postid"] );
                          if ($attached_image) {
                               set_post_thumbnail($_POST["storyid"], $attached_image);
							   $return["addedthumbnail"] = "Featured image updated, will show when you save this post";
                                } else {
									$return["addedthumbnail"] = "";
                       		 }
  }
	  
	  
	$return["post_title"] = $post->post_title;
		$return["post_content"] = $post->post_content;  
		
$returnJSON = json_encode($return);

die($returnJSON);		

break;



case "saveorder":
//postid[]=b&postid[]=a

//pageid[]=111&pageid[]=344

// to do: 

// Explode query string into page id pairs.  
# for each page id, run a counter and save the menu_order for that post using wp_update_post

# that means there's an order saved for each newsletter story.

# then it's a case of implementing a front end template on the ita theme.

# after that point, add a meta_box to the newsletter custom to download a zip of HTML and images.

## I think you're done at that point!
//// Update post 37
  $my_post = array(
      'ID'           => 37,
      'post_content' => 'This is the updated content.'
  );

// Update the post into the database
 // wp_update_post( $my_post );
break;
		

		
endswitch	;	?>