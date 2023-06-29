<?php

function my_theme_enqueue_styles() {
	wp_enqueue_style( 'child-style', get_stylesheet_uri(), array( 'parenthandle' ), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

/**
 * Register the created custom guttenberg blocks
 */
require_once __DIR__ . '/blocks/register-block.php';