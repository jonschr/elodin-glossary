<?php
/*
	Plugin Name: Elodin Glossary
	Plugin URI: https://elod.in
    Description: Just another plugin
	Version: 0.1
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
define ( 'ELODIN_GLOSSARY_VERSION', '0.1' );

require_once( 'lib/post-type.php' );
require_once( 'lib/shortcode/words-template.php' );
require_once( 'lib/shortcode/shortcode-glossary.php' );
require_once( 'lib/shortcode/shortcode-glossary-letters.php' );
require_once( 'lib/shortcode/shortcode-glossary-search.php' );

add_action( 'wp_enqueue_scripts', 'elodin_glossary_enqueue' );
function elodin_glossary_enqueue() {

	// Plugin styles
    wp_enqueue_style( 'elodin-glossary-style', plugin_dir_url( __FILE__ ) . 'css/elodin-glossary-style.css', array(), ELODIN_GLOSSARY_VERSION, 'screen' );
    
    // // Script
    // wp_register_script( 'slick-init', plugin_dir_url( __FILE__ ) . 'js/slick-init.js', array( 'slick-main' ), ELODIN_GLOSSARY_VERSION, true );
	
	
}
