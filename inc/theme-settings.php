<?php
/**
 * Check and setup theme's default settings
 *
 * @package slovo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'slovo_setup_theme_default_settings' ) ) {
	function slovo_setup_theme_default_settings() {

		// check if settings are set, if not set defaults.
		// Caution: DO NOT check existence using === always check with == .
		// Latest blog posts style.
		$slovo_posts_index_style = get_theme_mod( 'slovo_posts_index_style' );
		if ( '' == $slovo_posts_index_style ) {
			set_theme_mod( 'slovo_posts_index_style', 'default' );
		}

		// Sidebar position.
		$slovo_sidebar_position = get_theme_mod( 'slovo_sidebar_position' );
		if ( '' == $slovo_sidebar_position ) {
			set_theme_mod( 'slovo_sidebar_position', 'right' );
		}

		// Container width.
		$slovo_container_type = get_theme_mod( 'slovo_container_type' );
		if ( '' == $slovo_container_type ) {
			set_theme_mod( 'slovo_container_type', 'container' );
		}
	}
}
