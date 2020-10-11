<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Album_Review
 * @subpackage Album_Review/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Album_Review
 * @subpackage Album_Review/public
 * @author     Your Name <email@example.com>
 */
class Album_Review_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $Album_Review    The ID of this plugin.
	 */
	private $Album_Review;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $Album_Review       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Album_Review, $version ) {

		$this->Album_Review = $Album_Review;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Album_Review_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Album_Review_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->Album_Review, plugin_dir_url( __FILE__ ) . 'css/brian-r-album-review-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Album_Review_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Album_Review_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->Album_Review, plugin_dir_url( __FILE__ ) . 'js/brian-r-album-review-public.js', array( 'jquery' ), $this->version, false );

	}

}
