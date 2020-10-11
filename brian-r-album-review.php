<?php

/**
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           album_review
 *
 * @wordpress-plugin
 * Plugin Name:       Brian Routzong's Awesome Album Review Plugin
 * Plugin URI:        http://example.com/brian-r-album-review-uri/
 * Description:       This plugin allows you to create album reviews and add them anywhere on your WordPress website with shortcodes.
 * Version:           1.0.0
 * Author:            Brian Routzong
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       brian-r-album-review
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'album_review_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-brian-r-album-review-activator.php
 */
function activate_album_review() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-brian-r-album-review-activator.php';
	album_review_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-brian-r-album-review-deactivator.php
 */
function deactivate_album_review() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-brian-r-album-review-deactivator.php';
	album_review_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_album_review' );
register_deactivation_hook( __FILE__, 'deactivate_album_review' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-brian-r-album-review.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_album_review() {

	$plugin = new album_review();
	$plugin->run();

}
run_album_review();
