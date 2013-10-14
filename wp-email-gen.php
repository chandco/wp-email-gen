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
add_action( 'init', 'create_newsletter_post_type' );
function create_newsletter_post_type() {
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
	register_post_type( 'newsletterstory',
		array(
			'labels' => array(
				'name' => __( 'Newsletter Stories' ),
				'singular_name' => __( 'Newsletter Story' )
			),
		'public' => true,
		'has_archive' => false,
		'rewrite' => array('slug' => 'newsletterstories'),
		'supports' => array( 'title', 'editor', 'thumbnail' )
		)
	);
	
	

	
}


function wpen_load_js_file()
{
	
		wp_enqueue_script('jquery');
		wp_enqueue_script('wpen_the_js', plugins_url('javascript.js',__FILE__) );
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

function wpen_add_custom_box() {
// NEED TO CHANGE TO NEWSLETTERS
    $screens = array( 'newsletterstory' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'wpen_sectionid',
            __( 'Export Venue to Venue Finder', 'wpen_textdomain' ),
            'wpen_inner_custom_box',
            $screen
        );
    }
}
add_action( 'add_meta_boxes', 'wpen_add_custom_box' );



function wpen_inner_custom_box( $post ) {

echo '<div id="wpen_status"></div>';
echo '<input type="hidden" id="wpen-current-post" value="' . $post->ID . '" />';
echo '<select name="find-a-post" id="find-a-post">';

echo '<option value="">Populate this with the content from another news story...</option>';

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