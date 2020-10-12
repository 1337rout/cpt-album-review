<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    album_review
 * @subpackage album_review/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    album_review
 * @subpackage album_review/admin
 * @author     Your Name <email@example.com>
 */
class Album_Review_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $brian_album_review    The ID of this plugin.
	 */
	private $album_review;

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
	 * @param      string    $brian_album_review       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $album_review, $version ) {

		$this->album_review = $album_review;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in brian_album_review_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The brian_album_review_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->album_review, plugin_dir_url( __FILE__ ) . 'css/brian-r-brian-album-review-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in brian_album_review_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The brian_album_review_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if ( 'brian_album_review' == get_post_type() ) {
		wp_register_script( $this->album_review, plugin_dir_url( __FILE__ ) . 'js/brian-r-brian-album-review-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->album_review, 'brAlbum',
		[
			'apiKey' => get_option( 'brian_album_review_settings_option_name' )['brian_last_fm_api_key_0'],
		]
		);
		wp_enqueue_script( $this->album_review );
		}
	}

}

class BrianAlbumReviewSettings {
	private $brian_album_review_settings_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'brian_album_review_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'brian_album_review_settings_page_init' ) );
	}

	public function brian_album_review_settings_add_plugin_page() {
		add_options_page(
			'Brian Album Review Settings', // page_title
			'Brian Album Review Settings', // menu_title
			'manage_options', // capability
			'brian-album-review-settings', // menu_slug
			array( $this, 'brian_album_review_settings_create_admin_page' ) // function
		);
	}

	public function brian_album_review_settings_create_admin_page() {
		$this->brian_album_review_settings_options = get_option( 'brian_album_review_settings_option_name' ); ?>

		<div class="wrap">
			<h2>Brian Album Review Settings</h2>
			<p>Last.FM API Key is needed. </p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'brian_album_review_settings_option_group' );
					do_settings_sections( 'brian-album-review-settings-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function brian_album_review_settings_page_init() {
		register_setting(
			'brian_album_review_settings_option_group', // option_group
			'brian_album_review_settings_option_name', // option_name
			array( $this, 'brian_album_review_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'brian_album_review_settings_setting_section', // id
			'Settings', // title
			array( $this, 'brian_album_review_settings_section_info' ), // callback
			'brian-album-review-settings-admin' // page
		);

		add_settings_field(
			'brian_last_fm_api_key_0', // id
			'Last.FM API Key', // title
			array( $this, 'brian_last_fm_api_key_0_callback' ), // callback
			'brian-album-review-settings-admin', // page
			'brian_album_review_settings_setting_section' // section
		);
	}

	public function brian_album_review_settings_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['brian_last_fm_api_key_0'] ) ) {
			$sanitary_values['brian_last_fm_api_key_0'] = sanitize_text_field( $input['brian_last_fm_api_key_0'] );
		}

		return $sanitary_values;
	}

	public function brian_album_review_settings_section_info() {
		
	}

	public function brian_last_fm_api_key_0_callback() {
		printf(
			'<input class="regular-text" type="text" name="brian_album_review_settings_option_name[brian_last_fm_api_key_0]" id="brian_last_fm_api_key_0" value="%s">',
			isset( $this->brian_album_review_settings_options['brian_last_fm_api_key_0'] ) ? esc_attr( $this->brian_album_review_settings_options['brian_last_fm_api_key_0']) : ''
		);
	}

}
$brian_album_review_settings = new BrianAlbumReviewSettings();