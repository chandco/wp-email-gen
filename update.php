<?php

// This file performs a bunch of AJAX stuff.

include("../../../wp-load.php");


// different post actions define what happens here

switch ( $_POST["action"]):


case "loadpost":
## The user just selected a blog post to populate a newsletter story


## get the post details
  $post = get_post($_POST["postid"], "OBJECT");       

// check the thumbnail of the existing newsletter story, does it have one? we won't overwrite if so...
		 
  $already_has_thumb = has_post_thumbnail($_POST["storyid"]);
  if (!$already_has_thumb)  {
	  ## there's no post thumbnail, so we're going to add the one from the seleted blog post and set it
	  // let's add from the added post as there wasn't one already
              $attached_image = get_post_thumbnail_id( $_POST["postid"] );
                          if ($attached_image) {
                               set_post_thumbnail($_POST["storyid"], $attached_image);
							   $return["addedthumbnail"] = "Featured image updated, will show when you save this post";
							   ## can't do this with Jquery AFAIK
                                } else {
									## leave the user selected thumbnail
									$return["addedthumbnail"] = "";
                       		 }
  }
	  
	  ## set up data for the JSON array. 
	  ## WE STILL NEED TO ADD THE PERMALINK - DO WE NEED ANYTHING ELSE?
	  
	  ## DO WE WANT TO JUST SET THE POST DATA HERE AND REFRESH TO AVOID JS ISSUES?
	$return["post_title"] = $post->post_title;
		$return["post_content"] = $post->post_content;  
		$return["cta_link"] = get_permalink($post->ID);
		$return["cta_text"] = "Read More...";
		
		## set up the data in JSON so javascipt can read it
$returnJSON = json_encode($return);

# die to ensure no output beneath messes up the json, 
die($returnJSON);		

break;



case "saveorder": #We're on newsletter page and someone just switched the order of the newsletter stories by drag and dropping

 

// Explode query string into page id pairs.  

// jquery ui sortable will be giving us the data in this format:
// $_POST["serialize"]  = postid[]=108&postid[]=109

// seperate into an array
$serials = explode("&",$_POST["serialize"]);
$counter = 1;
$success = true; // assume it's going towork, until it doesn't
foreach ($serials as $serial)
{
	// give us just the id
	$postid = str_replace("postid[]=","",$serial);
	
	// set up the arguments to update the wordpress post
	$updateArgs = array(
      'ID'           => $postid,
      'menu_order' => $counter
  );
	// update the post
	$success1 = wp_update_post($updateArgs);
	// if this worked, and it's worked so far, stay true, else false
	$success = ($success AND $success1) ? true : false;
	$counter++;
	
	## IF THIS EVER FAILS, WE SHOULD START TO GIVE MORE INTELLIGENT ERROR REPORTING BUT IT'LL PROBABLY NEVER FAIL!
}
	

// give a basic success or fail output so that javascript can tell the user
  
if ($success) {	die ("true");  }
else { die("false"); }

break;
		

		
endswitch	;	?>