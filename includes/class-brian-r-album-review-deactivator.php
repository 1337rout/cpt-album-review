<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Album_Review
 * @subpackage Album_Review/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Album_Review
 * @subpackage Album_Review/includes
 * @author     Your Name <email@example.com>
 */
class Album_Review_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		//Let's un-register the CPT and Taxonomies we created on Activation. 
		unregister_post_type( 'album_review' );
	}

}
