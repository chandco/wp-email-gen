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


function wpen_add_custom_box() {




// NEED TO CHANGE TO NEWSLETTERS
    $screens = array( 'venues' );

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

echo "this plugin is working";


}















## Nathan's stuff.  Above is copied from codex




 
 
?>