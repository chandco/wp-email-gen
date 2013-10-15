<?php

/**
 * Plugin Name: WP Email Newsletter Generator
 * Plugin URI: http://itavenues.co.uk
 * Description: Uses content from Posts to populate info in a custom post type "newsletter"
 * Version: 0.1
 * Author: Nathan Edwards
 * Author URI: mailto:nathan.edwards@chandco.net
 * License: GPL2
 */
 
// initialise and check authorisation
/* include("../../../wp-load.php"); */


// initialisation
add_action( 'init', 'create_newsletter_post_type' );

function create_newsletter_post_type() {
	// groups newsletter stories
	register_post_type( 'newsletter',
		array(
			'labels' => array(
				'name' => __( 'Newsletters' ),
				'singular_name' => __( 'Newsletter' )
			),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => 'newsletters'),
		'supports' => array( 'title', 'editor', 'thumbnail' )
		)
	);
	// newsletter stories, each individual article
	register_post_type( 'newsletterstory',
		array(
			'labels' => array(
				'name' => __( 'Newsletter Stories' ),
				'singular_name' => __( 'Newsletter Story' )
			),
		'public' => true,
		'has_archive' => false,
		'rewrite' => array('slug' => 'newsletterstories'),
		'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' )
		)
	);
	
	

	
}


//wp_enqueue_script('abc_shop_categories_widget_js', plugin_dir_url(__FILE__) . 'abc_shop_categories_widget.js', array('jquery', 'jquery-ui-core', 'jquery-ui-sortable'), '', true);
		
// add the javascript
function wpen_load_js_file()
{
	
		wp_enqueue_script('jquery');
		wp_enqueue_script('wpen_the_js', plugins_url('javascript.js',__FILE__), array('jquery', 'jquery-ui-core', 'jquery-ui-sortable') );
		
		//wp_enqueue_script('vfe_the_js', 'javascript.js' );
		
		wp_localize_script( 
		'wpen_the_js',
		'wpen',
		array(
			'ajaxurl' => plugins_url('update.php',__FILE__)
		)
	);
		
}
add_action('admin_enqueue_scripts', 'wpen_load_js_file');



// add the metaboxes to the admin for newsletter stories
function wpen_add_custom_box() {

    add_meta_box('wpen_list_stories_in_newsletter',
	__('Here are the stories in this newsletter.  Drag them around to change the order that they appear in.  Click on edit to edit that story.  Search for stories in the Newsletter Stories section to add more stories to this newsletter.', 'wpen_textdomain'),
	'wpen_list_stories_in_newsletter_box',
	'newsletter'
	);

        add_meta_box(
            'wpen_sectionid',
            __( 'Populate content from another blog post', 'wpen_textdomain' ),
            'wpen_inner_custom_box',
            'newsletterstory'
        );
		
		add_meta_box(
		'wpen_set_newsletter_parent',
		__('Which newsletter is this a story of?', 'wpen_textdomain' ),
		'wpen_inner_parent_box',
		'newsletterstory'
		);
		
		add_meta_box(
		'wpen_set_newsletter_ctalink',
		__('What is the main CTA link for this story?', 'wpen_textdomain' ),
		'wpen_set_newsletter_ctalink_box',
		'newsletterstory'
		);
		
		
		
   
}
add_action( 'add_meta_boxes', 'wpen_add_custom_box' );



function wpen_set_newsletter_ctalink_box( $post ) {
	
	$ctalink = get_post_meta($post->ID,"_newsletter_story_cta_link",true);
	$ctatext = get_post_meta($post->ID,"_newsletter_story_cta_text",true);
	echo '<label for="wpen_cta_link">Link:</label> <input type="text" name="wpen_cta_link" id="wpen_cta_link" value="' . $ctalink . '"/>';
	echo '<label for="wpen_cta_link">Text:</label> <input type="text" name="wpen_cta_text" id="wpen_cta_text" value="' . $ctatext . '" />';
	
}

// newsletter box.  Will list the currently attached newsletters
function wpen_list_stories_in_newsletter_box( $post ) {
	
	$args = array(
	'posts_per_page' => -1,
	'post_type' => 'newsletterstory',
	'meta_query' =>	array(
			'key' => '_newsletter_story_parent',
			'value' => $post->ID
		),
	'orderby' => 'menu_order',
	'order' => 'ASC'
	
	);
	
	$posts = get_posts($args);
	echo '<style>
  #wpen_sortable ul { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #wpen_sortable ul li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; cursor:move; }
  #wpen_sortable ul li span { position: absolute; margin-left: -1.3em; }
  </style>';
	echo '<div id="wpen_status"></div><div id="wpen_sortable"><ul >';
	foreach ($posts as $blogpost)
	{
		echo '<li id="postid-' . $blogpost->ID . '">' . $blogpost->post_title  . ' ( <a href="' . get_edit_post_link( $blogpost->ID ) . '">EDIT</a> ) </li>';
	}
	echo "</ul></div>";
		
}


// this box will let you choose which newsletter it is a parent of
// this will be saved as meta data
function wpen_inner_parent_box ( $post ) {
	
		$args = array(
	'posts_per_page' => -1,
	'post_type' => 'newsletter'
	);
	
	$posts = get_posts($args);
	echo '<select name="newsletter_story_parent" id="newsletter_story_parent">';
	
	$parent_newsletter = get_post_meta($post->ID,"_newsletter_story_parent",true);
	
	foreach ($posts as $blogpost)
	{
		if ($parent_newsletter == $blogpost->ID) 
		{
			$selected = " selected";
		} else {
			$selected = "";
		}
		echo '<option value="' . $blogpost->ID . '"' . $selected . '>' . $blogpost->post_title  . '</option>\n';
	}
		
	echo '</select>';	
}


// save the  field above

function wpen_save_postdata($post_id){

 if ( 'newsletterstory' != $_POST['post_type']) return; // don't want to do this if it's not the right post type
     
	
	$blc = $_POST['newsletter_story_parent'];
	
	$cta_link = $_POST["wpen_cta_link"];
	$cta_text = $_POST["wpen_cta_text"];
	echo $blc;
      // save data in INVISIBLE custom field (note the "_" prefixing the custom fields' name
      update_post_meta($post_id, '_newsletter_story_parent', $blc); 
	  update_post_meta($post_id, '_newsletter_story_cta_link', $cta_link); 
	  update_post_meta($post_id, '_newsletter_story_cta_text', $cta_text); 
	  

    }

    //On post save, save plugin's data
    add_action('save_post', 'wpen_save_postdata');





// this box will find a blog post, and insert the content.  If there is no featured image already on this post, the featured image from 
// that blog post will be set.  It's a quick way of adding stories.  The idea is that you edit down the copy from the blog post in such a 
// way that you do not have to edit the original blog post, and editing a newsletter is quick.

function wpen_inner_custom_box( $post ) {

echo '<div id="wpen_status"></div>';
echo '<input type="hidden" id="wpen-current-post" value="' . $post->ID . '" />';
echo '<select name="find-a-post" id="find-a-post">';

echo '<option value="nothing">Populate this with the content from another news story...</option>';

$args = array(
'posts_per_page' => -1,
);

$posts = get_posts($args);

foreach ($posts as $blogpost)
{
	echo '<option value="' . $blogpost->ID . '">' . $blogpost->post_title  . '</option>\n';
}

echo '</select> <button id="populate_wpen" onClick="return false;">Add this blog post\'s content</button>';



}















## Nathan's stuff.  Above is copied from codex




 
 
?>