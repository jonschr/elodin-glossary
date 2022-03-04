<?php
/*
	Plugin Name: Elodin Glossary
	Plugin URI: https://elod.in
    Description: Just another plugin
	Version: 1.0.1
    Author: Jon Schroeder
    Author URI: https://elod.in

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.
*/


/* Prevent direct access to the plugin */
if ( !defined( 'ABSPATH' ) ) {
    die( "Sorry, you are not allowed to access this page directly." );
}

// Plugin directory
define( 'ELODIN_GLOSSARY', dirname( __FILE__ ) );

// Define the version of the plugin
define ( 'ELODIN_GLOSSARY_VERSION', '1.0.1' );

//////////////
// INCLUDES //
//////////////

require_once( 'vendor/cmb2/init.php' );
require_once( 'lib/post-type.php' );
require_once( 'shortcode/words-template.php' );
require_once( 'shortcode/shortcode-glossary.php' );
require_once( 'shortcode/shortcode-glossary-letters.php' );
require_once( 'shortcode/shortcode-glossary-search.php' );

//////////////////////
// REGISTER SCRIPTS //
//////////////////////

add_action( 'wp_enqueue_scripts', 'elodin_glossary_enqueue' );
function elodin_glossary_enqueue() {

	// Plugin styles
    wp_enqueue_style( 'elodin-glossary-style', plugin_dir_url( __FILE__ ) . 'css/elodin-glossary-style.css', array(), ELODIN_GLOSSARY_VERSION, 'screen' );	
	
}


////////////////////
// PLUGIN UPDATER //
////////////////////

// Updater
require 'vendor/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/jonschr/elodin-glossary',
	__FILE__,
	'elodin-glossary'
);

// Optional: Set the branch that contains the stable release.
$myUpdateChecker->setBranch( 'main' );

//////////////
// META BOX //
//////////////


add_action( 'cmb2_admin_init', 'cmb2_sample_metaboxes' );
function cmb2_sample_metaboxes() {

	$cmb = new_cmb2_box( array(
		'id'            => 'words_details',
		'title'         => __( 'Word Details', 'cmb2' ),
		'object_types'  => array( 'words', ), // Post type
		'context'       => 'side',
		'priority'      => 'default',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

	// Regular text field
	$cmb->add_field( array(
		'name'       => __( 'Part of speech', 'cmb2' ),
		'desc'       => __( 'e.g. noun, verb, etc.', 'cmb2' ),
		'id'         => 'part_of_speech',
		'type'       => 'text',
	) );

}