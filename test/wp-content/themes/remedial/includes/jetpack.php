<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Remedial
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function remedial_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'content',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'remedial_jetpack_setup' );
