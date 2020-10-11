<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Album_Review
 * @subpackage Album_Review/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Album_Review
 * @subpackage Album_Review/admin
 * @author     Your Name <email@example.com>
 */
class Album_Review_Admin {

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
	 * @param      string    $Album_Review       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Album_Review, $version ) {

		$this->Album_Review = $Album_Review;
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
		 * defined in Album_Review_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Album_Review_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->Album_Review, plugin_dir_url( __FILE__ ) . 'css/brian-r-album-review-admin.css', array(), $this->version, 'all' );

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
		 * defined in Album_Review_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Album_Review_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if ( 'album_review' == get_post_type() ) {
		wp_register_script( $this->Album_Review, plugin_dir_url( __FILE__ ) . 'js/brian-r-album-review-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->Album_Review, 'brAlbum',
		[
			'apiKey' => get_option( 'album_review_settings_option_name' )['last_fm_api_key_0'],
		]
		);
		wp_enqueue_script( $this->Album_Review );
		}
	}

}

class AlbumReviewSettings {
	private $album_review_settings_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'album_review_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'album_review_settings_page_init' ) );
	}

	public function album_review_settings_add_plugin_page() {
		add_options_page(
			'Album Review Settings', // page_title
			'Album Review Settings', // menu_title
			'manage_options', // capability
			'album-review-settings', // menu_slug
			array( $this, 'album_review_settings_create_admin_page' ) // function
		);
	}

	public function album_review_settings_create_admin_page() {
		$this->album_review_settings_options = get_option( 'album_review_settings_option_name' ); ?>

		<div class="wrap">
			<h2>Album Review Settings</h2>
			<p>Last.FM API Key is needed. </p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'album_review_settings_option_group' );
					do_settings_sections( 'album-review-settings-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function album_review_settings_page_init() {
		register_setting(
			'album_review_settings_option_group', // option_group
			'album_review_settings_option_name', // option_name
			array( $this, 'album_review_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'album_review_settings_setting_section', // id
			'Settings', // title
			array( $this, 'album_review_settings_section_info' ), // callback
			'album-review-settings-admin' // page
		);

		add_settings_field(
			'last_fm_api_key_0', // id
			'Last.FM API Key', // title
			array( $this, 'last_fm_api_key_0_callback' ), // callback
			'album-review-settings-admin', // page
			'album_review_settings_setting_section' // section
		);
	}

	public function album_review_settings_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['last_fm_api_key_0'] ) ) {
			$sanitary_values['last_fm_api_key_0'] = sanitize_text_field( $input['last_fm_api_key_0'] );
		}

		return $sanitary_values;
	}

	public function album_review_settings_section_info() {
		
	}

	public function last_fm_api_key_0_callback() {
		printf(
			'<input class="regular-text" type="text" name="album_review_settings_option_name[last_fm_api_key_0]" id="last_fm_api_key_0" value="%s">',
			isset( $this->album_review_settings_options['last_fm_api_key_0'] ) ? esc_attr( $this->album_review_settings_options['last_fm_api_key_0']) : ''
		);
	}

}
$album_review_settings = new AlbumReviewSettings();