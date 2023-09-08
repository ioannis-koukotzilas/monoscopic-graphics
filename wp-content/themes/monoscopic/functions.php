<?php

if ( ! defined( '_MONOSCOPIC_VERSION' ) ) {
	define( '_S_VERSION', '1.0.0' );
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

function monoscopic_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'monoscopic' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'monoscopic' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'monoscopic_widgets_init' );

function monoscopic_scripts() {
	wp_enqueue_style( 'monoscopic-style', get_stylesheet_uri(), array(), _S_VERSION );
}
add_action( 'wp_enqueue_scripts', 'monoscopic_scripts' );

require get_template_directory() . '/inc/template-tags.php';

require get_template_directory() . '/inc/template-functions.php';