<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Album_Review
 * @subpackage Album_Review/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Album_Review
 * @subpackage Album_Review/includes
 * @author     Your Name <email@example.com>
 */
class Album_Review {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Album_Review_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $Album_Review    The string used to uniquely identify this plugin.
	 */
	protected $Album_Review;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'Album_Review_VERSION' ) ) {
			$this->version = Album_Review_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->Album_Review = 'brian-r-album-review';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

    /**
		 * Define path and URL to the ACF plugin.
     * Include the ACF plugin.
     * Customize the url setting to fix incorrect asset URLs.
     * Hide the ACF admin menu item.
		 */
    define( 'Album_Review_ACF_PATH', plugin_dir_path( dirname( __FILE__ ) ) . '/includes/acf/' );
    define( 'Album_Review_ACF_URL', plugin_dir_url( dirname( __FILE__ ) ) . '/includes/acf/' );

    include_once( Album_Review_ACF_PATH . 'acf.php' );

    add_filter('acf/settings/url', 'Album_Review_settings_url');
    function Album_Review_settings_url( $url ) {
        return Album_Review_ACF_URL;
    }
    add_filter('acf/settings/show_admin', 'Album_Review_settings_show_admin');
    function Album_Review_settings_show_admin( $show_admin ) {
        return false;
    }

    add_filter('acf/settings/save_json', 'Album_Review_json_save_point');
    function Album_Review_json_save_point( $path ) {
        $path = plugin_dir_path( dirname( __FILE__ ) ) . '/acf-json';
        return $path;
    }

    add_filter('acf/settings/load_json', 'Album_Review_json_load_point');
    function Album_Review_json_load_point( $paths ) {        
        unset($paths[0]);
        $paths[] = plugin_dir_path( dirname( __FILE__ ) ) . '/acf-json';
        return $paths;
	}
		/**
	 * Setup CPT Albums
	 */
	function album_review_cpt_add() {
		$labels = [
			"name" => __( "Album Reviews", 'brian-r-album-review' ),
			"singular_name" => __( "Album Review", 'brian-r-album-review' ),
			'menu_name'           => __( 'Album Review', 'brian-r-album-review' ),
			'parent_item_colon'   => __( 'Parent Album Reviews', 'brian-r-album-review' ),
			'all_items'           => __( 'All Album Review', 'brian-r-album-review' ),
			'view_item'           => __( 'View Album Review', 'brian-r-album-review' ),
			'add_new_item'        => __( 'Add New Album Review', 'brian-r-album-review' ),
			'add_new'             => __( 'Add New', 'brian-r-album-review' ),
			'edit_item'           => __( 'Edit Album Review', 'brian-r-album-review' ),
			'update_item'         => __( 'Update Album Review', 'brian-r-album-review' ),
			'search_items'        => __( 'Search Album Review', 'brian-r-album-review' ),
			'not_found'           => __( 'Not Found', 'brian-r-album-review' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'brian-r-album-review' ),
		];

		$args = [
			"label" => __( "Album Reviews", 'brian-r-album-review' ),
			"labels" => $labels,
			"description" => "Loved an album? Hated it?
				Review it, post it, share it. 
				Create as many Album Reviews as you would like and generate a shortcode to post anywhere on your WordPress Website.",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => false,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"delete_with_user" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => [ "slug" => "album_review", "with_front" => true ],
			"query_var" => true,
			"menu_icon" => "dashicons-album",
			"supports" => [ "title", "thumbnail", "custom-fields" ],
		];

		register_post_type( "album_review", $args );
		/**
	 	* Change Title on Album CPT
	 	*/
		add_filter('enter_title_here', 'my_title_place_holder' , 20 , 2 );
		function my_title_place_holder($title , $post){

			if( $post->post_type == 'album_review' ){
				$my_title = "Enter Album Title";
				return $my_title;
			}

			return $title;

		}
		
	}

	add_action( 'init', 'album_review_cpt_add' );
	function register_my_taxes_genre() {

		/**
		 * Taxonomy: Genres.
		 */

		$labels = [
			"name" => __( "Genres", 'brian-r-album-review' ),
			"singular_name" => __( "Genre", 'brian-r-album-review' ),
		];

		$args = [
			"label" => __( "Genres", 'brian-r-album-review' ),
			"labels" => $labels,
			"public" => true,
			"publicly_queryable" => true,
			"hierarchical" => false,
			"show_ui" => false,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => [ 'slug' => 'genre', 'with_front' => true, ],
			"show_admin_column" => true,
			"show_in_rest" => true,
			"rest_base" => "genre",
			"rest_controller_class" => "WP_REST_Terms_Controller",
			"show_in_quick_edit" => false,
				];
		register_taxonomy( "genre", [ "album_review" ], $args );
	}
	add_action( 'init', 'register_my_taxes_genre' );


	/**
	 * Shortcode function and adding the shortcode for single album review
	 *
	 * @since     1.0.0
	 */

	 function register_shortcodes(){
		add_shortcode('album-review', 'showAlbumReview');
		add_shortcode('recent-albums', 'showAlbumReviewRecent');
		add_shortcode('albums-genre', 'showAlbumReviewGenre');
	 }
	 add_action( 'init', 'register_shortcodes');

	 add_action( 'load-post.php', 'album_review_meta_boxes_setup' );

	 function album_review_meta_boxes_setup() {
	
		add_action( 'add_meta_boxes', 'album_review_add_post_meta_boxes' );
	  }
	
	 function album_review_add_post_meta_boxes() {
	
		add_meta_box(
		  'album-review-shortcode', 
		  esc_html__( 'Shortcode', 'example' ),
		  'album_review_shortcode',
		  'album_review',
		  'side',
		  'high'
		);
	  }
	  
	/* Display the post meta box. */
	function album_review_shortcode( $post ) { ?>
		<code>
		  <?php echo '[album-review album="' . get_the_ID() . '"]';
		  ?>
		</code>
	  <?php }

	/* Setup column on CPT admin of view all. */
	  add_filter( 'manage_album_review_posts_columns', 'set_custom_edit_album_columns' );
	  function set_custom_edit_album_columns($columns) {
		  unset( $columns['date'] );
		  $columns['shortcode'] = __( 'Shortcode', 'brian-r-album-review' );
	  
		  return $columns;
	  }
	/* Setup data for the custom column */
	add_action( 'manage_album_review_posts_custom_column' , 'custom_shortcode_column', 10, 2 );
	function custom_shortcode_column( $column, $post_id ) {
    	switch ( $column ) {

        case 'shortcode' :
            echo '[album-review album="' . $post_id . '"]';
            break;

    	}
	}


	/**
	 * The class responsible for orchestrating the actions and filters of the
	 * core plugin.
	 */
	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-brian-r-album-review-loader.php';

	/**
	 * The class responsible for defining internationalization functionality
	 * of the plugin.
	 */
	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-brian-r-album-review-i18n.php';

	/**
	 * The class responsible for defining all actions that occur in the admin area.
	 */
	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-brian-r-album-review-admin.php';

	/**
	 * The class responsible for defining all actions that occur in the public-facing
	 * side of the site.
	 */
	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-brian-r-album-review-public.php';

	$this->loader = new Album_Review_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Album_Review_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Album_Review_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Album_Review_Admin( $this->get_Album_Review(), $this->get_version() );
		
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Album_Review_Public( $this->get_Album_Review(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_Album_Review() {
		return $this->Album_Review;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Album_Review_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
	/**
	* Single Album Shortcode Function
	*/
	function showAlbumReview($atts){
		$album_content ='';
		extract(shortcode_atts(array(
			'album' => 1,
		), $atts));
		$album_content .= '<div class="album-review"><div class="album-cover-cont">';
		if(get_field('album_art', $album)){
			$album_content .= '<img src="' . get_field('album_art', $album).'">';
		}
		$album_content .= '</div>
		<div class="album-details">
			<h3 class="album-name-author"><strong>' . get_the_title($album) .'</strong>';
			if(get_field('artist', $album)){
				$album_content .= '<br>by ' . get_field('artist', $album);
			}
			$album_content .= '</h3>';
			$genres = get_the_terms($album, 'category');
			if(!empty($genres)){
			$album_content .= '<p class="album-genre">'. join(', ', wp_list_pluck($genres, 'name')). '</p>
			<div class="album-rating">';
			}
			$rating = get_field('rating', $album);

			if ( $rating ) {
				$average_stars = round( $rating * 2 ) / 2;
			
				$drawn = 5;

				$album_content .= '<div class="star-rating">';
				
				// full stars.
				for ( $i = 0; $i < floor( $average_stars ); $i++ ) {
					$drawn--;
					$album_content .= '<svg aria-hidden="true" data-prefix="fas" data-icon="star" class="svg-inline--fa fa-star fa-w-18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>';
				}

				// half stars.
				if ( $rating - floor( $average_stars ) === 0.5 ) {
					$drawn--;
					$album_content .= '<svg aria-hidden="true" data-prefix="fas" data-icon="star-half-alt" class="svg-inline--fa fa-star-half-alt fa-w-17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 536 512"><path fill="currentColor" d="M508.55 171.51L362.18 150.2 296.77 17.81C290.89 5.98 279.42 0 267.95 0c-11.4 0-22.79 5.9-28.69 17.81l-65.43 132.38-146.38 21.29c-26.25 3.8-36.77 36.09-17.74 54.59l105.89 103-25.06 145.48C86.98 495.33 103.57 512 122.15 512c4.93 0 10-1.17 14.87-3.75l130.95-68.68 130.94 68.7c4.86 2.55 9.92 3.71 14.83 3.71 18.6 0 35.22-16.61 31.66-37.4l-25.03-145.49 105.91-102.98c19.04-18.5 8.52-50.8-17.73-54.6zm-121.74 123.2l-18.12 17.62 4.28 24.88 19.52 113.45-102.13-53.59-22.38-11.74.03-317.19 51.03 103.29 11.18 22.63 25.01 3.64 114.23 16.63-82.65 80.38z"/></svg>';
				}

				// empty stars.
				for ( $i = 0; $i < $drawn; $i++ ) {
					$album_content .= '<svg aria-hidden="true" data-prefix="far" data-icon="star" class="svg-inline--fa fa-star fa-w-18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"/></svg>';
				}

				$album_content .= '</div>';
			}

			$album_content .= '</div>
			</div>';
		return $album_content;
	}

	/**
	* Recent Albums Shortcode Function
	*/
	function showAlbumReviewRecent($atts){
		$album_content ='';
		extract(shortcode_atts(array(
			'albums' => 5,
		), $atts));
		$args = array(
			'post_type' => 'album_review',
			'posts_per_page' => $albums,
		);
		$albums = new WP_Query($args);
		if ( $albums->have_posts() ) {
			$album_content .= '<div class=all-albums"><h3>Recent Album Reviews</h3>';
			while ( $albums->have_posts() ) {
				$albums->the_post();
				$album = get_the_ID();

				$album_content .= '<div class="album-review"><div class="album-cover-cont">';
				if(get_field('album_art', $album)){
					$album_content .= '<img src="' . get_field('album_art', $album).'">';
				}
				$album_content .= '</div>
				<div class="album-details">
					<h3 class="album-name-author"><strong>' . get_the_title($album) .'</strong>';
					if(get_field('artist', $album)){
						$album_content .= '<br>by ' . get_field('artist', $album);
					}
					$album_content .= '</h3>';
					$genres = get_the_terms($album, 'genre');
					if(!empty($genres)){
					$album_content .= '<p class="album-genre">'. join(', ', wp_list_pluck($genres, 'name')). '</p>
					<div class="album-rating">';
					}
					$rating = get_field('rating', $album);

					if ( $rating ) {
						$average_stars = round( $rating * 2 ) / 2;
					
						$drawn = 5;

						$album_content .= '<div class="star-rating">';
						
						// full stars.
						for ( $i = 0; $i < floor( $average_stars ); $i++ ) {
							$drawn--;
							$album_content .= '<svg aria-hidden="true" data-prefix="fas" data-icon="star" class="svg-inline--fa fa-star fa-w-18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>';
						}

						// half stars.
						if ( $rating - floor( $average_stars ) === 0.5 ) {
							$drawn--;
							$album_content .= '<svg aria-hidden="true" data-prefix="fas" data-icon="star-half-alt" class="svg-inline--fa fa-star-half-alt fa-w-17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 536 512"><path fill="currentColor" d="M508.55 171.51L362.18 150.2 296.77 17.81C290.89 5.98 279.42 0 267.95 0c-11.4 0-22.79 5.9-28.69 17.81l-65.43 132.38-146.38 21.29c-26.25 3.8-36.77 36.09-17.74 54.59l105.89 103-25.06 145.48C86.98 495.33 103.57 512 122.15 512c4.93 0 10-1.17 14.87-3.75l130.95-68.68 130.94 68.7c4.86 2.55 9.92 3.71 14.83 3.71 18.6 0 35.22-16.61 31.66-37.4l-25.03-145.49 105.91-102.98c19.04-18.5 8.52-50.8-17.73-54.6zm-121.74 123.2l-18.12 17.62 4.28 24.88 19.52 113.45-102.13-53.59-22.38-11.74.03-317.19 51.03 103.29 11.18 22.63 25.01 3.64 114.23 16.63-82.65 80.38z"/></svg>';
						}

						// empty stars.
						for ( $i = 0; $i < $drawn; $i++ ) {
							$album_content .= '<svg aria-hidden="true" data-prefix="far" data-icon="star" class="svg-inline--fa fa-star fa-w-18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"/></svg>';
						}

						$album_content .= '</div>';
					}

					$album_content .= '</div>
									</div>';
					}
				$album_content .= '</div>';
				}
			wp_reset_postdata();
			return $album_content;

	}

	/**
	* Album Genre Shortcode Function
	*/
	function showAlbumReviewGenre($atts){
		$album_content ='';
		extract(shortcode_atts(array(
			'genre' => '',
			'albums' => 5,
		), $atts));
		$args = array(
			'post_type' => 'album_review',
			'tax_query' => array(
				array(
				'taxonomy' => 'genre',
				'field' => 'slug',
				'terms' => $genre,
				),
			),
			'posts_per_page' => $albums,
		);
		$albums = new WP_Query($args);
		if ( $albums->have_posts() ) {
			$album_content .= '<div class=all-albums"><h3 class="genre-title">Recent ' . $genre . ' Album Reviews';
			while ( $albums->have_posts() ) {
				$albums->the_post();
				$album = get_the_ID();

				$album_content .= '<div class="album-review"><div class="album-cover-cont">';
				if(get_field('album_art', $album)){
					$album_content .= '<img src="' . get_field('album_art', $album).'">';
				}
				$album_content .= '</div>
				<div class="album-details">
					<h3 class="album-name-author"><strong>' . get_the_title($album) .'</strong>';
					if(get_field('artist', $album)){
						$album_content .= '<br>by ' . get_field('artist', $album);
					}
					$album_content .= '</h3>';
					$genres = get_the_terms($album, 'genre');
					if(!empty($genres)){
					$album_content .= '<p class="album-genre">'. join(', ', wp_list_pluck($genres, 'name')). '</p>
					<div class="album-rating">';
					}
					$rating = get_field('rating', $album);

					if ( $rating ) {
						$average_stars = round( $rating * 2 ) / 2;
					
						$drawn = 5;

						$album_content .= '<div class="star-rating">';
						
						// full stars.
						for ( $i = 0; $i < floor( $average_stars ); $i++ ) {
							$drawn--;
							$album_content .= '<svg aria-hidden="true" data-prefix="fas" data-icon="star" class="svg-inline--fa fa-star fa-w-18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>';
						}

						// half stars.
						if ( $rating - floor( $average_stars ) === 0.5 ) {
							$drawn--;
							$album_content .= '<svg aria-hidden="true" data-prefix="fas" data-icon="star-half-alt" class="svg-inline--fa fa-star-half-alt fa-w-17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 536 512"><path fill="currentColor" d="M508.55 171.51L362.18 150.2 296.77 17.81C290.89 5.98 279.42 0 267.95 0c-11.4 0-22.79 5.9-28.69 17.81l-65.43 132.38-146.38 21.29c-26.25 3.8-36.77 36.09-17.74 54.59l105.89 103-25.06 145.48C86.98 495.33 103.57 512 122.15 512c4.93 0 10-1.17 14.87-3.75l130.95-68.68 130.94 68.7c4.86 2.55 9.92 3.71 14.83 3.71 18.6 0 35.22-16.61 31.66-37.4l-25.03-145.49 105.91-102.98c19.04-18.5 8.52-50.8-17.73-54.6zm-121.74 123.2l-18.12 17.62 4.28 24.88 19.52 113.45-102.13-53.59-22.38-11.74.03-317.19 51.03 103.29 11.18 22.63 25.01 3.64 114.23 16.63-82.65 80.38z"/></svg>';
						}

						// empty stars.
						for ( $i = 0; $i < $drawn; $i++ ) {
							$album_content .= '<svg aria-hidden="true" data-prefix="far" data-icon="star" class="svg-inline--fa fa-star fa-w-18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"/></svg>';
						}

						$album_content .= '</div>';
					}

					$album_content .= '</div>
									</div>';
				}
			$album_content .= '</div>';
			}
		wp_reset_postdata();
		return $album_content;

	}