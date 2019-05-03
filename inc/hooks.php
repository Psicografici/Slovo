<?php
/**
 * Custom hooks.
 *
 * @package slovo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'slovo_site_info' ) ) {
	/**
	 * Add site info hook to WP hook library.
	 */
	function slovo_site_info() {
		do_action( 'slovo_site_info' );
	}
}

if ( ! function_exists( 'slovo_add_site_info' ) ) {
	add_action( 'slovo_site_info', 'slovo_add_site_info' );

	/**
	 * Add site info content.
	 */
	function slovo_add_site_info() {
		$the_theme = wp_get_theme();

		$site_info = sprintf(
			'<a href="%1$s">%2$s</a><span class="sep"> | </span>%3$s(%4$s)',
			esc_url( __( 'http://wordpress.org/', 'slovo' ) ),
			sprintf(
				/* translators:*/
				esc_html__( 'Proudly powered by %s', 'slovo' ),
				'WordPress'
			),
			sprintf( // WPCS: XSS ok.
				/* translators:*/
				esc_html__( 'Theme: %1$s by %2$s.', 'slovo' ),
				$the_theme->get( 'Name' ),
				'<a href="' . esc_url( __( 'http://understrap.com', 'slovo' ) ) . '">understrap.com</a>'
			),
			sprintf( // WPCS: XSS ok.
				/* translators:*/
				esc_html__( 'Version: %1$s', 'slovo' ),
				$the_theme->get( 'Version' )
			)
		);

		echo apply_filters( 'slovo_site_info_content', $site_info ); // WPCS: XSS ok.
	}
}
