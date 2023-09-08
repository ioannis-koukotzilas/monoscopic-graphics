<?php

/**
 * Plugin Name: Core
 * Plugin URI: https://monoscopic.net
 * Description: Application core functions. It should always be activated.
 * Version: 1.0.0
 * Author: Monoscopic Studio
 * Author URI: https://monoscopic.net
 * Text Domain: core-functions
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) exit;

/**
 * Disable Gutenberg.
 */

// Disable Gutenberg on the back end.
add_filter('use_block_editor_for_post', '__return_false');

// Disable Gutenberg for widgets.
add_filter('use_widgets_block_editor', '__return_false');

add_action('wp_enqueue_scripts', function () {
  // Remove CSS on the front end.
  wp_dequeue_style('wp-block-library');

  // Remove Gutenberg theme.
  wp_dequeue_style('wp-block-library-theme');

  // Remove inline global CSS on the front end.
  wp_dequeue_style('global-styles');

  // Remove auto generated classic theme styles.
  wp_dequeue_style('classic-theme-styles');
}, 20);

/**
 * Setup Images.
 */

// Disable the scaling of big images.
add_filter('big_image_size_threshold', '__return_false');

/**
 * Admin setup.
 */

// Change the font of the WordPress editor area.
function custom_admin_editor_style()
{
  echo '<style>
        #wp-content-editor-container .wp-editor-area, #wp-content-editor-container .mce-content-body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            font-size: 13px;
        }
    </style>';
}
add_action('admin_head', 'custom_admin_editor_style');
