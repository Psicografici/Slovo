<?php
/**
 * slovo enqueue scripts
 *
 * @package slovo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'slovo_scripts' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function slovo_scripts() {
		// Get the theme data.
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' );

		// Get the Google Fonts from customizer
		$headings_font = esc_html(get_theme_mod('slovo_headings_fonts'));
		$body_font = esc_html(get_theme_mod('slovo_body_fonts'));

		if( $headings_font ) {
			wp_enqueue_style( 'slovo-headings-fonts', '//fonts.googleapis.com/css?family='. $headings_font );
		} else {
			wp_enqueue_style( 'slovo-source-sans', '//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
		}
		if( $body_font ) {
			wp_enqueue_style( 'slovo-body-fonts', '//fonts.googleapis.com/css?family='. $body_font );
		} else {
			wp_enqueue_style( 'slovo-source-body', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,400italic,700,600');
		}


		$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/css/theme.min.css' );
		wp_enqueue_style( 'slovo-styles', get_template_directory_uri() . '/css/theme.min.css', array(), $css_version );

		wp_enqueue_script( 'jquery' );

		$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/theme.min.js' );
		wp_enqueue_script( 'slovo-scripts', get_template_directory_uri() . '/js/theme.min.js', array(), $js_version, true );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
} // endif function_exists( 'slovo_scripts' ).

add_action( 'wp_enqueue_scripts', 'slovo_scripts' );
