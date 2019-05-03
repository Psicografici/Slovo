<?php
/**
 * slovo Theme Customizer
 *
 * @package slovo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if ( ! function_exists( 'slovo_customize_register' ) ) {
	/**
	 * Register basic customizer support.
	 *
	 * @param object $wp_customize Customizer reference.
	 */
	function slovo_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}
}
add_action( 'customize_register', 'slovo_customize_register' );

if ( ! function_exists( 'slovo_theme_customize_register' ) ) {
	/**
	 * Register individual settings through customizer's API.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer reference.
	 */
	function slovo_theme_customize_register( $wp_customize ) {

		// Theme layout settings.
		$wp_customize->add_section(
			'slovo_theme_layout_options',
			array(
				'title'       => __( 'Theme Layout Settings', 'slovo' ),
				'capability'  => 'edit_theme_options',
				'description' => __( 'Container width and sidebar defaults', 'slovo' ),
				'priority'    => 160,
			)
		);

		$wp_customize->add_section(
			'slovo_google_fonts_section', 
			array(
				'title'          => __( 'Google Fonts', 'slovo' ),
				'priority'       => 170,
				'capability'  => 'edit_theme_options',
				'description' => __( 'Select Google Fonts', 'slovo' ),
			) 
		);

		/**
		 * Select sanitization function
		 *
		 * @param string               $input   Slug to sanitize.
		 * @param WP_Customize_Setting $setting Setting instance.
		 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
		 */
		function slovo_theme_slug_sanitize_select( $input, $setting ) {

			// Ensure input is a slug (lowercase alphanumeric characters, dashes and underscores are allowed only).
			$input = sanitize_key( $input );

			// Get the list of possible select options.
			$choices = $setting->manager->get_control( $setting->id )->choices;

				// If the input is a valid key, return it; otherwise, return the default.
				return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

		}

		//Sanitizes Fonts
		function slovo_sanitize_fonts( $input ) {
			$valid = array(
				'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',
				'Open Sans:400italic,700italic,400,700' => 'Open Sans',
				'Oswald:400,700' => 'Oswald',
				'Playfair Display:400,700,400italic' => 'Playfair Display',
				'Montserrat:400,700' => 'Montserrat',
				'Raleway:400,700' => 'Raleway',
				'Droid Sans:400,700' => 'Droid Sans',
				'Lato:400,700,400italic,700italic' => 'Lato',
				'Arvo:400,700,400italic,700italic' => 'Arvo',
				'Lora:400,700,400italic,700italic' => 'Lora',
				'Merriweather:400,300italic,300,400italic,700,700italic' => 'Merriweather',
				'Oxygen:400,300,700' => 'Oxygen',
				'PT Serif:400,700' => 'PT Serif',
				'PT Sans:400,700,400italic,700italic' => 'PT Sans',
				'PT Sans Narrow:400,700' => 'PT Sans Narrow',
				'Cabin:400,700,400italic' => 'Cabin',
				'Fjalla One:400' => 'Fjalla One',
				'Francois One:400' => 'Francois One',
				'Josefin Sans:400,300,600,700' => 'Josefin Sans',
				'Libre Baskerville:400,400italic,700' => 'Libre Baskerville',
				'Arimo:400,700,400italic,700italic' => 'Arimo',
				'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
				'Bitter:400,700,400italic' => 'Bitter',
				'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
				'Roboto:400,400italic,700,700italic' => 'Roboto',
				'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
				'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
				'Roboto Slab:400,700' => 'Roboto Slab',
				'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
				'Rokkitt:400' => 'Rokkitt',
			);
			if ( array_key_exists( $input, $valid ) ) {
				return $input;
			} else {
				return '';
			}
		}
		

		$wp_customize->add_setting(
			'slovo_container_type',
			array(
				'default'           => 'container',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'slovo_theme_slug_sanitize_select',
				'capability'        => 'edit_theme_options',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'slovo_container_type',
				array(
					'label'       => __( 'Container Width', 'slovo' ),
					'description' => __( 'Choose between Bootstrap\'s container and container-fluid', 'slovo' ),
					'section'     => 'slovo_theme_layout_options',
					'settings'    => 'slovo_container_type',
					'type'        => 'select',
					'choices'     => array(
						'container'       => __( 'Fixed width container', 'slovo' ),
						'container-fluid' => __( 'Full width container', 'slovo' ),
					),
					'priority'    => '10',
				)
			)
		);

		$wp_customize->add_setting(
			'slovo_sidebar_position',
			array(
				'default'           => 'right',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'capability'        => 'edit_theme_options',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'slovo_sidebar_position',
				array(
					'label'             => __( 'Sidebar Positioning', 'slovo' ),
					'description'       => __(
						'Set sidebar\'s default position. Can either be: right, left, both or none. Note: this can be overridden on individual pages.',
						'slovo'
					),
					'section'           => 'slovo_theme_layout_options',
					'settings'          => 'slovo_sidebar_position',
					'type'              => 'select',
					'sanitize_callback' => 'slovo_theme_slug_sanitize_select',
					'choices'           => array(
						'right' => __( 'Right sidebar', 'slovo' ),
						'left'  => __( 'Left sidebar', 'slovo' ),
						'both'  => __( 'Left & Right sidebars', 'slovo' ),
						'none'  => __( 'No sidebar', 'slovo' ),
					),
					'priority'          => '20',
				)
			)
		);

		// Google fonts array

		$font_choices = array(
			'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',
			'Open Sans:400italic,700italic,400,700' => 'Open Sans',
			'Oswald:400,700' => 'Oswald',
			'Playfair Display:400,700,400italic' => 'Playfair Display',
			'Montserrat:400,700' => 'Montserrat',
			'Raleway:400,700' => 'Raleway',
			'Droid Sans:400,700' => 'Droid Sans',
			'Lato:400,700,400italic,700italic' => 'Lato',
			'Arvo:400,700,400italic,700italic' => 'Arvo',
			'Lora:400,700,400italic,700italic' => 'Lora',
			'Merriweather:400,300italic,300,400italic,700,700italic' => 'Merriweather',
			'Oxygen:400,300,700' => 'Oxygen',
			'PT Serif:400,700' => 'PT Serif',
			'PT Sans:400,700,400italic,700italic' => 'PT Sans',
			'PT Sans Narrow:400,700' => 'PT Sans Narrow',
			'Cabin:400,700,400italic' => 'Cabin',
			'Fjalla One:400' => 'Fjalla One',
			'Francois One:400' => 'Francois One',
			'Josefin Sans:400,300,600,700' => 'Josefin Sans',
			'Libre Baskerville:400,400italic,700' => 'Libre Baskerville',
			'Arimo:400,700,400italic,700italic' => 'Arimo',
			'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
			'Bitter:400,700,400italic' => 'Bitter',
			'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
			'Roboto:400,400italic,700,700italic' => 'Roboto',
			'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
			'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
			'Roboto Slab:400,700' => 'Roboto Slab',
			'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
			'Rokkitt:400' => 'Rokkitt',
		);

		$wp_customize->add_setting( 'slovo_headings_fonts', array(
				'sanitize_callback' => 'slovo_sanitize_fonts',
			)
		);
		$wp_customize->add_control( 'slovo_headings_fonts', array(
				'type' => 'select',
				'description' => __('Select your desired font for the headings.', 'slovo'),
				'section' => 'slovo_google_fonts_section',
				'choices' => $font_choices
			)
		);
		$wp_customize->add_setting( 'slovo_body_fonts', array(
				'sanitize_callback' => 'slovo_sanitize_fonts'
			)
		);
		$wp_customize->add_control( 'slovo_body_fonts', array(
				'type' => 'select',
				'description' => __( 'Select your desired font for the body.', 'slovo' ),
				'section' => 'slovo_google_fonts_section',
				'choices' => $font_choices
			)
		);

	}
} // endif function_exists( 'slovo_theme_customize_register' ).
add_action( 'customize_register', 'slovo_theme_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
if ( ! function_exists( 'slovo_customize_preview_js' ) ) {
	/**
	 * Setup JS integration for live previewing.
	 */
	function slovo_customize_preview_js() {
		wp_enqueue_script(
			'slovo_customizer',
			get_template_directory_uri() . '/js/customizer.js',
			array( 'customize-preview' ),
			'20130508',
			true
		);
	}
}
add_action( 'customize_preview_init', 'slovo_customize_preview_js' );
