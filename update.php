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


		

		
endswitch	;	?>