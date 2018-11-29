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
 * @package    ontra_members
 * @subpackage ontra_members/includes
 */


class Ontra_members {


	protected $loader;
	protected $ontraport;
	protected $admin;
	protected $plugin_name;
	protected $version;



	public function __construct() {

		$this->plugin_name = 'ontra-members';
		$this->version = '1.0.0';
		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}


	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ontra-members-loader.php';


		/**
		 *  The Core Ontraport Library
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/lib/ontraport/Ontraport.php';

		/**
		 * The class is use to connect Ontaport API
		 */
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/lib/ontraport-api.php';


		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ontra-members-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'api/WistiaApi.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/members/class-members.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/members/class-fasttrack.php';


		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ontra-members-public.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-affiliate-centre.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-link-builder.php';

		$this->loader 	 = new Ontra_Members_Loader();
		$this->ontraport = new Ontraport_API();
		$this->wistia    = new WistiaApi(get_option('ontra_member_bb_wistia_key'));  


	}



	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		
		$plugin_admin = new Ontra_Members_Admin( $this->get_plugin_name(), $this->get_version(), $this->ontraport->connect());

		
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		//Register Menu and Submenu
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_subpage' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'settings_init' );



	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {


		$plugin_public 	  = new Ontra_Members_Public( $this->get_plugin_name(), $this->get_version(), $this->ontraport->connect(), $this->wistia);
		$affiliate_center = new MyBB_Affiliate_Centre( $this->ontraport->connect() );
		$link_builder     = new LinkBuilder();

		
		add_shortcode( 'BB_fastrackMember', array( $plugin_public, 'display_fasttrackmembers' ) );
		add_shortcode( 'BB_EliteMember', array( $plugin_public, 'display_elitemembers' ) );
		add_shortcode( 'bb_active_members', array( $plugin_public, 'display_active_members' ) );
		add_shortcode( 'MBB_contactInfo', array( $plugin_public, 'get_contactInfo' ) );
		add_shortcode( 'mbb_get_customer_type', array( $plugin_public, 'get_member_type' ) );
		add_shortcode( 'MBB_update_info', array( $plugin_public, 'generate_membership_form' ) );
		add_shortcode( 'mbb_your_consultant', array( $plugin_public, 'your_consultant' ) );
		add_shortcode( 'mbb_user_profile', array( $plugin_public, 'user_profile' ) );
		add_shortcode( 'mbb_affiliate_centre', array( $affiliate_center, 'affiliate_centre' ) );
		add_shortcode( 'mbb_silver_membership', array( $plugin_public, 'display_silver' ) );

		add_shortcode( 'mbb_latest_uploads', array( $plugin_public, 'getLatestUploads' ) );
		add_shortcode( 'mbb_featured_videos', array( $plugin_public, 'getFeaturedVideos' ) );
		add_shortcode( 'mbb_success_stories', array( $plugin_public, 'getSuccessStories' ) );




		$this->loader->add_action( 'wp_ajax_search_ontra', $plugin_public, 'searchMembers' );
		$this->loader->add_action( 'wp_ajax_nopriv_search_ontra', $plugin_public, 'searchMembers' );

		$this->loader->add_action( 'wp_ajax_ontra_update_contact', $plugin_public, 'update_contact' );
		$this->loader->add_action( 'wp_ajax_nopriv_ontra_update_contact', $plugin_public, 'update_contact' );

		$this->loader->add_action( 'wp_ajax_nopriv_upload_user_photo', $plugin_public, 'upload_user_photo' );
		$this->loader->add_action( 'wp_ajax_upload_user_photo', $plugin_public, 'upload_user_photo' );

		$this->loader->add_action( 'wp_ajax_nopriv_update_profile_photo', $plugin_public, 'update_profile_photo' );
		$this->loader->add_action( 'wp_ajax_update_profile_photo', $plugin_public, 'update_profile_photo' );

		$this->loader->add_action( 'wp_ajax_nopriv_upload_new_photo', $plugin_public, 'uploadNewPhoto' );
		$this->loader->add_action( 'wp_ajax_upload_new_photo', $plugin_public, 'uploadNewPhoto' );

		$this->loader->add_action( 'wp_ajax_nopriv_get_wistia_image', $plugin_public, 'getPostImage' );
		$this->loader->add_action( 'wp_ajax_get_wistia_image', $plugin_public, 'getPostImage' );


		$this->loader->add_action( 'wp_ajax_nopriv_get_post_list', $plugin_public, 'getVideoTimeline' );
		$this->loader->add_action( 'wp_ajax_get_post_list', $plugin_public, 'getVideoTimeline' );
		
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}


	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}


}
