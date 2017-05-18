<?php
/**
 * Customizer Handler.
 *
 * @link https://codex.wordpress.org/Theme_Customization_API
 *
 * @package Mesa
 */

/**
 * Hook into customize_register.
 */
function mesa_customize_register( $wp_customize ) {

	// Add section
	$wp_customize->add_section( 'mesa', [
		'capability'  => 'edit_theme_options',
		'title'       => __( 'Visual Settings', THEMEDOMAIN ),
		'description' => __( 'Theme settings or logo, colors etc.', THEMEDOMAIN )
	] );

	// Add logo setting and control
	$wp_customize->add_setting( 'mesa_logo', [
		'capability'  => 'pco_mesa_settings'
	] );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mesa_logo', [
		'settings'    => 'mesa_logo',
		'label'       => __( 'Logo', THEMEDOMAIN ),
		'description' => __( 'Logo will be resized at 60px height', THEMEDOMAIN ),
		'section'     => 'mesa'
	] ) );

	// Add base color setting and control
	$wp_customize->add_setting( 'base_accent_color', [
		'capability'  => 'pco_mesa_settings'
	] );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'base-accent-color', [
		'label'       => __( 'Base Accent Color', THEMEDOMAIN ),
		'description' => __( 'The main color, with enough contrast for white text on top.', THEMEDOMAIN ),
		'section'     => 'mesa',
		'settings'    => 'base_accent_color',
	] ) );

	// Add base color variant setting and control
	$wp_customize->add_setting( 'base_accent_color_variant', [
		'capability'  => 'pco_mesa_settings'
	] );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'base_accent_color_variant', [
		'label'       => __( 'Base Accent Color Variant', THEMEDOMAIN ),
		'description' => __( 'Used as a hover color for some elements. Typically a darker or lighter version of the base accent color.', THEMEDOMAIN ),
		'section'     => 'mesa',
		'settings'    => 'base_accent_color_variant',
	] ) );

	// Add body background color setting and control
	$wp_customize->add_setting( 'body_color_background', [
		'capability'  => 'pco_mesa_settings'
	] );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'body_color_background', [
		'label'       => __( 'Body Background Color', THEMEDOMAIN ),
		'description' => __( 'Used as a background color on the body', THEMEDOMAIN ),
		'section'     => 'mesa',
		'settings'    => 'body_color_background',
	] ) );

	// Add footer background color setting and control
	$wp_customize->add_setting( 'footer_color_background', [
		'capability'  => 'pco_mesa_settings'
	] );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_color_background', [
		'label'       => __( 'Footer Background Color', THEMEDOMAIN ),
		'description' => __( 'Used as a background color on the footer', THEMEDOMAIN ),
		'section'     => 'mesa',
		'settings'    => 'footer_color_background',
	] ) );

	// Add footer color setting and control
	$wp_customize->add_setting( 'footer_color_text', [
		'capability'  => 'pco_mesa_settings'
	] );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_color_text', [
		'label'       => __( 'Footer Text Color', THEMEDOMAIN ),
		'description' => __( 'Used as a color for the text in the footer', THEMEDOMAIN ),
		'section'     => 'mesa',
		'settings'    => 'footer_color_text',
	] ) );

	// Add header font type setting and control
	$wp_customize->add_setting( 'header_font_type' , array(
		'default' => '',
		'capability'  => 'pco_mesa_settings'
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'header_font_type', [
		'label'       => __( 'Header Font Type', THEMEDOMAIN ),
		'description' => __( 'Define the header font type', THEMEDOMAIN ),
		'section'     => 'mesa',
		'settings'    => 'header_font_type',
		'type'        => 'text',
	] ) );

	// Add body font type setting and control
	$wp_customize->add_setting( 'body_font_type' , array(
		'default' => '',
		'capability'  => 'pco_mesa_settings'
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'body_font_type', [
		'label'       => __( 'Body Font Type', THEMEDOMAIN ),
		'description' => __( 'Define the body font type', THEMEDOMAIN ),
		'section'     => 'mesa',
		'settings'    => 'body_font_type',
		'type'        => 'text',
	] ) );

	//Add pixel width in order to specify when to show the mobile menu
	$wp_customize->add_setting( 'mobile_menu_breakpoint', [
		'capability'  => 'pco_mesa_settings'
	] );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mobile_menu_breakpoint', [
		'label'       => __( 'Mobile Menu Breakpoint', THEMEDOMAIN ),
		'description' => __( 'Set a width in ems where the mobile menu switches to the full horizontal menu.', THEMEDOMAIN ),
		'section'     => 'mesa',
		'settings'    => 'mobile_menu_breakpoint',
		'type'        => 'text',
	] ) );

	//Add setting to not display author's names on the site
	$wp_customize->add_setting( 'hide_author', [
		'capability'  => 'pco_mesa_settings'
	] );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'hide_author', [
		'label'       => __( 'Hide Author', THEMEDOMAIN ),
		'description' => __( 'Check to hide authors on posts and news list', THEMEDOMAIN ),
		'section'     => 'mesa',
		'settings'    => 'hide_author',
		'type'        => 'checkbox',
	] ) );

	// Add body font type setting and control
	$wp_customize->add_setting( 'css_custom', [
		'capability'  => 'pco_mesa_settings'
	] );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'css_custom', [
		'label'       => __( 'Custom CSS', THEMEDOMAIN ),
		'description' => __( 'Adds small custom CSS in the header', THEMEDOMAIN ),
		'section'     => 'mesa',
		'settings'    => 'css_custom',
		'type'        => 'textarea',
	] ) );
}
add_action( 'customize_register', 'mesa_customize_register' );

/**
 * Add css rules generated fromn Customizer fields.
 */
function mesa_custom_css() {
	echo '<style type="text/css">';
	get_theme_mod( 'mobile_menu_breakpoint' ) ? $menu_breakpoint = floatval( get_theme_mod( 'mobile_menu_breakpoint' ) ).'em' : $menu_breakpoint = '64.063em';

	echo " @media screen and (max-width: $menu_breakpoint ){
		body.drawer-navbar.drawer-fixed {
			padding-top: 0;
		}

		.drawer-main {
			position: fixed;
			z-index: 5300;
			top: 0;
			overflow: hidden;
			width: 260px;
			height: 100%;
		}

		.admin-bar .drawer-main {
			top: 46px;
		}

		.drawer-right .drawer-main {
			right: -280px;
			-webkit-transition: -webkit-transform .4s cubic-bezier(.19, 1, .22, 1);
				 -o-transition:	  -o-transform .4s cubic-bezier(.19, 1, .22, 1);
					transition:		 transform .4s cubic-bezier(.19, 1, .22, 1);
			-webkit-transform: translate3d(260px, 0px, 0px);
					transform: translate3d(260px, 0px, 0px);
		}

		.drawer-right.drawer-open .drawer-main {
			right: 0;
			-webkit-transform: translate3d(0px, 0px, 0px);
					transform: translate3d(0px, 0px, 0px);
		}

		.drawer-overlay {
			position: relative;
		}

		.drawer-right .drawer-hamburger {
			right: 0;

			-webkit-transform: translateX(0px) translateY(0px);
				-ms-transform: translateX(0px) translateY(0px);
				 -o-transform: translateX(0px) translateY(0px);
					transform: translateX(0px) translateY(0px);
		}

		.drawer-right.drawer-open .drawer-hamburger {
			-webkit-transform: translateX(-260px) translateY(0px);
				-ms-transform: translateX(-260px) translateY(0px);
				 -o-transform: translateX(-260px) translateY(0px);
					transform: translateX(-260px) translateY(0px);
		}

		.drawer-overlay-upper {
			position: fixed;
			z-index: 5200;
			top: 0;
			left: 0;
			display: none;
			width: 100%;
			height: 100%;
			background-color: #000;
			background-color: rgba(0, 0, 0, .5);
		}

		.drawer-open .drawer-overlay-upper {
			display: block !important;
		}

		.drawer-hamburger {
			position: absolute;
			z-index: 5250;
			top: 0;
			display: block;
			width: 70px;
			height: 60px;
			padding: 20px;
			border: 0;
			outline: 0;
			background: 0;
			background-color: transparent;
		}

		.drawer-hamburger:hover {
			cursor: pointer;
		}

		.drawer-hamburger-icon {
			position: relative;
			display: block;
			margin-top: 10px;
		}

		.drawer-hamburger-icon,
		.drawer-hamburger-icon:before,
		.drawer-hamburger-icon:after {
			width: 100%;
			height: 3px;
			-webkit-transition: all .4s cubic-bezier(.19, 1, .22, 1);
				 -o-transition: all .4s cubic-bezier(.19, 1, .22, 1);
					transition: all .4s cubic-bezier(.19, 1, .22, 1);
			border-radius: 1px;
			background-color: #333;
		}

		.drawer-hamburger-icon:before,
		.drawer-hamburger-icon:after {
			position: absolute;
			top: -10px;
			left: 0;
			content: ' ';
		}

		.drawer-hamburger-icon:after {
			top: 10px;
		}

		.drawer-open .drawer-hamburger-icon {
			background-color: transparent;
		}

		.drawer-open .drawer-hamburger-icon:before,
		.drawer-open .drawer-hamburger-icon:after {
			top: 0;
			background-color: #fff;
		}

		.drawer-open .drawer-hamburger-icon:before {
			-webkit-transform: rotate(45deg);
				-ms-transform: rotate(45deg);
				 -o-transform: rotate(45deg);
					transform: rotate(45deg);
		}

		.drawer-open .drawer-hamburger-icon:after {
			-webkit-transform: rotate(-45deg);
				-ms-transform: rotate(-45deg);
				 -o-transform: rotate(-45deg);
					transform: rotate(-45deg);
		}

		.drawer-default {
			background-color: #fff;
			-webkit-box-shadow: inset 0 0 0 rgba(0, 0, 0, .5);
					box-shadow: inset 0 0 0 rgba(0, 0, 0, .5);
		}

		.drawer-default + .drawer-overlay {
			background-color: #fff;
		}

		.drawer-default li,
		.drawer-default a,
		.drawer-default .drawer-brand {
			position: relative;
			display: block;
		}

		.drawer-default a {
			text-decoration: none;
		}

		.drawer-default a:hover,
		.drawer-default a:focus {
			text-decoration: underline;
		}

		.drawer-default .drawer-brand a {
			font-size: 22px;
			padding: 20px 15px;
			color: #fff;
		}

		.drawer-default .drawer-brand a:hover {
			color: #555;
		}

		.drawer-default .drawer-brand > img {
			display: block;
		}

		.drawer-default .drawer-footer {
			line-height: 50px;
			position: relative;
			height: 50px;
			padding: 0 15px;
			background-color: transparent;
		}

		.drawer-default .drawer-footer span:before,
		.drawer-default .drawer-footer span:after {
			display: block;
			content: ' ';
		}

		.drawer-default ul {
			margin: 0;
			padding: 0;
			list-style: none;
		}

		.drawer-default .drawer-menu-item {
			font-size: 18px;
			padding: 15px 15px 0;
			color: #555;
		}

		.drawer-default .drawer-menu-item.disabled a {
			color: #333;
		}

		.drawer-default .drawer-menu-item.disabled a:hover,
		.drawer-default .drawer-menu-item.disabled a:focus {
			cursor: not-allowed;
			color: #333;
			background-color: transparent;
		}

		.drawer-default .drawer-menu-item a {
			color: #888;
		}

		.drawer-default .drawer-menu-item a:hover,
		.drawer-default .drawer-menu-item a:focus {
			color: #fff;
			background-color: transparent;
		}

		.drawer-default .drawer-menu-item a img {
			max-width: none;
		}

		.drawer-default .drawer-submenu {
			margin-bottom: 20px;
		}

		.drawer-default .drawer-submenu:last-child {
			margin-bottom: 0;
		}

		.drawer-default .drawer-submenu-item {
			padding: 0;
		}

		.drawer-default .drawer-submenu-item a {
			font-size: 14px;
			line-height: 50px;
			height: 50px;
		}

		.drawer-default .drawer-submenu-item a:hover,
		.drawer-default .drawer-submenu-item a:focus {
			color: #fff;
		}

		.drawer-default .dropdown-menu {
			position: absolute;
			z-index: 5000;
			display: none;
			border: 0;
			background-color: #222;
			-webkit-box-shadow: none;
					box-shadow: none;
		}

		.drawer-default .dropdown-menu > li > a {
			padding: 0!important;
		}

		.drawer-default .dropdown.open > .dropdown-menu {
			position: static;
			display: block;
			float: none;
			width: auto;
		}

		.drawer-default a:hover,
		.drawer-default a:focus {
			text-decoration: none;
			color: #888 !important;
		}

		.drawer-dropdown .caret,
		.drawer-dropdown-hover .caret {
			display: inline-block;
			width: 0;
			height: 0;
			margin-left: 2px;
			-webkit-transition: -webkit-transform .2s ease, opacity .2s ease;
				 -o-transition:	  -o-transform .2s ease, opacity .2s ease;
					transition:		 transform .2s ease, opacity .2s ease;
			-webkit-transform: rotate(0deg);
				-ms-transform: rotate(0deg);
				 -o-transform: rotate(0deg);
					transform: rotate(0deg);
			vertical-align: middle;
			border-top: 4px solid;
			border-right: 4px solid transparent;
			border-left: 4px solid transparent;
		}

		.drawer-dropdown.open .caret,
		.drawer-dropdown-hover.open .caret {
			-webkit-transform: rotate(180deg);
				-ms-transform: rotate(180deg);
				 -o-transform: rotate(180deg);
					transform: rotate(180deg);
		}

		.dropdown-backdrop {
			position: fixed;
			z-index: 990;
			top: 0;
			right: 0;
			bottom: 0;
			left: 0;
		}

		.sr-only {
			position: absolute;
			overflow: hidden;
			clip: rect(0, 0, 0, 0);
			width: 1px;
			height: 1px;
			margin: -1px;
			padding: 0;
			border: 0;
		}

		.sr-only-focusable:active,
		.sr-only-focusable:focus {
			position: static;
			overflow: visible;
			clip: auto;
			width: auto;
			height: auto;
			margin: 0;
		}

		.drawer-header {
		  display: block;
		}
	}

	@media screen and (max-width: 48.063em ){
		 .drawer-hamburger {
			 height: 70px;
		 }
	 }

	@media screen and (min-width: $menu_breakpoint ){
		 .drawer-responsive.drawer-right .drawer-toggle {
			 display: none;
			 visibility: hidden;
		 }

		 .drawer-responsive.drawer-right .drawer-main {
			 right: 0;
			 display: block;
			 -webkit-transform: none;
				 -ms-transform: none;
				  -o-transform: none;
					 transform: none;
		 }
	}";

	// Base color
	if( get_theme_mod( 'base_accent_color' ) ) {
		$color = get_theme_mod( 'base_accent_color' );
		echo "a { color: {$color} }";
		echo ".color-base-accent-color, .color-base-accent-color-hover:hover { color: {$color} !important; }";
		echo ".bg-base-accent-color, .bg-base-accent-color-hover:hover, .bg-base-accent-color::after { background-color: {$color} !important }";
		echo ".border-base-accent-color { border-color: {$color} !important; }";
		echo ".mesa-color-wrap::after { background-color: {$color} !important }";
	}

	// Base variant color
	if( get_theme_mod( 'base_accent_color_variant' ) ) {
		$color = get_theme_mod( 'base_accent_color_variant' );
		echo "a:hover, a:focus { color: {$color} }";
		echo ".color-base-accent-color-variant, .color-base-accent-color-variant-hover:hover { color: {$color} !important; }";
		echo ".bg-base-accent-color-variant, .bg-base-accent-color-variant-hover:hover { background-color: {$color} !important }";
		echo ".border-base-accent-color-variant { border-color: {$color} !important; }";
	}

	// Body background color
	if( get_theme_mod( 'body_color_background' ) ) {
		$color = get_theme_mod( 'body_color_background' );
		echo "body { background-color: {$color} }";
	}

	// Footer background color
	if( get_theme_mod( 'footer_color_background' ) ) {
		$color = get_theme_mod( 'footer_color_background' );
		echo "#footer { background-color: {$color} }";
	}

	// Footer text color
	if( get_theme_mod( 'footer_color_text' ) ) {
		$color = get_theme_mod( 'footer_color_text' );
		echo "#footer { color: {$color} }";
		echo "#footer p { color: {$color} }";
		echo "#footer a, #footer a:hover, #footer a:focus { color: {$color} !important; }";
	}

	// Header font type
	if( get_theme_mod( 'header_font_type' ) ) {
		$font = get_theme_mod( 'header_font_type' );
		$font_settings = explode( ':', $font );
		$font_family = isset( $font_settings[0] ) ? $font_settings[0] : '';
		echo "h1, h2, h3, h4, h5, h6 { font-family: {$font_family}; }";

		// @TODO find a way to handle different weights, the following elements had different weights defined
		// echo "#nav .menu > li, .menu li { font-family: {$font_family}; }";
		// echo ".item-block h2 { font-family: {$font_family}; }";
		// echo ".hero-unit h2 { font-family: {$font_family}; }";
		// echo ".call-to-action h2 a { font-family: {$font_family}; }";

	}

	// Body font type
	if( get_theme_mod( 'body_font_type' ) ) {
		$font = get_theme_mod( 'body_font_type' );
		$font_settings = explode( ':', $font );
		$font_family = isset( $font_settings[0] ) ? $font_settings[0] : '';
		echo "body { font-family: {$font_family}; }";

		// @TODO find a way to handle different weights, the following elements had different weights defined
		// echo "table, button, input { font-family: {$font_family}; }";
	}

	if( get_theme_mod( 'css_custom' ) ) {
		$custom_css = get_theme_mod( 'css_custom' );
		echo $custom_css;
	}

	echo '</style>';
}
add_action( 'wp_head', 'mesa_custom_css' );
