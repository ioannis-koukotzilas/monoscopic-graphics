<?php

if ( ! defined( '_MONOSCOPIC_VERSION' ) ) {
	define( '_MONOSCOPIC_VERSION', '1.0.1' );
}

function monoscopic_setup() {
	
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'monoscopic' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
}
add_action( 'after_setup_theme', 'monoscopic_setup' );

function monoscopic_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'monoscopic_content_width', 2560 );
}
add_action( 'after_setup_theme', 'monoscopic_content_width', 0 );

function monoscopic_scripts() {
	wp_enqueue_style( 'monoscopic-style', get_stylesheet_uri(), array(), _MONOSCOPIC_VERSION );
	wp_enqueue_script('three', get_template_directory_uri() . '/src/js/three.min.js', array(), _MONOSCOPIC_VERSION, true);
	wp_enqueue_script('html2canvas', get_template_directory_uri() . '/src/js/html2canvas.js', array(), _MONOSCOPIC_VERSION, true);
	wp_enqueue_script('record-rtc', get_template_directory_uri() . '/src/js/record-rtc.js', array(), _MONOSCOPIC_VERSION, true);
	wp_enqueue_script('app', get_template_directory_uri() . '/src/js/app.js', array(), _MONOSCOPIC_VERSION, true);
	
}
add_action( 'wp_enqueue_scripts', 'monoscopic_scripts' );

require get_template_directory() . '/inc/template-tags.php';

require get_template_directory() . '/inc/template-functions.php';