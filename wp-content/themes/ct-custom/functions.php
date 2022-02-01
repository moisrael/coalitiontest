<?php
/**
 * CT Custom functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package CT_Custom
 */

if ( !function_exists( 'ct_custom_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ct_custom_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on CT Custom, use a find and replace
		 * to change 'ct-custom' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ct-custom', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Adds metadata
		function add_meta_data() {
		?>
			<meta charset="<?php bloginfo('charset'); ?>">
			<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<?php
		}

		// Add metadata to the website head
		add_action('wp_head', 'add_meta_data');
		
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'main-menu' => esc_html__( 'Primary', 'ct-custom' )
		) );

		// Remove admin bar for subscriber accounts
		function remove_subscriber_admin_bar() {
			$current_user = wp_get_current_user();

			if (count($current_user->roles) == 1 && $current_user->roles[0] == 'subscriber') {
				show_admin_bar(false);
			}
		}

		add_action('wp_loaded', 'remove_subscriber_admin_bar');

		// Redirect subscriber accounts from dashboard to homepage
		function redirect_subscriber_to_frontend() {
			$current_user = wp_get_current_user();

			if (count($current_user->roles) == 1 && $current_user->roles[0] == 'subscriber') {
				wp_redirect(site_url('/'));
				exit;
			}
		}

		add_action('admin_init', 'redirect_subscriber_to_frontend');

		// Redirects to the homepage
		function redirect_to_homepage($redirect_to, $request, $user) {
			if (isset($user->roles) && is_array($user->roles)) {
				return home_url();
			}
		}
		
		// If log in is successful, redirect to the homepage
		add_filter('login_redirect', 'redirect_to_homepage', 10, 3);

		// After user logs out, redirect to the homepage
		add_filter('logout_redirect', 'redirect_to_homepage', 10, 3);

		// Changes log in page header url
		function custom_header_url() {
			return esc_url(site_url('/'));
		}
		
		// Change the header url on the log in/Sign up screen
		add_filter('login_headerurl', 'custom_header_url');
		
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'ct_custom_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		// add_theme_support( 'custom-logo', array(
		// 	'height'      => 250,
		// 	'width'       => 250,
		// 	'flex-width'  => true,
		// 	'flex-height' => true,
		// ) );

		// For theme settings page
		function add_theme_settings() {?>
			<div class="container">
				<h1>Theme Settings</h1>
				<?php settings_errors(); ?>
				<form action="options.php" method="post">
					<?php

						settings_fields('contact_info');
						do_settings_sections('theme-settings');
						submit_button();
					
					?>
				</form>
			</div>
<?php 	}
		
		// Creates theme settings page
		function create_theme_settings_page() {
			add_menu_page('Theme Settings', 'Theme Settings', 'manage_options', 'theme-settings', 'add_theme_settings', 'dashicons-admin-generic', 61);
		}

		// Create theme settings page
		add_action('admin_menu', 'create_theme_settings_page');

		// Displays logo upload button
		function set_website_logo() {
			$website_logo = esc_attr(get_option('website_logo'));?>
			
			<button type="button" class="button button-secondary" id="upload-button">Upload Website Logo</button>
			<input type="hidden" name="website_logo" id="website-logo" value="<?php echo $website_logo; ?>"/>
			<span id="file-name"><?php echo substr($website_logo, strrpos($website_logo, '/') + 1); ?></span><?php
		}

		// Displays office address fields
		function set_office_address() {
			$office_address_street = esc_attr(get_option('office_address_street'));
			$office_address_country = esc_attr(get_option('office_address_country'));?>

			<input type="text" name="office_address_street" class="regular-text ltr" id="office-address-street" value="<?php echo $office_address_street; ?>" placeholder="Street" style="display: block;">
			<input type="text" name="office_address_country" class="regular-text ltr" id="office-address-country" value="<?php echo $office_address_country; ?>" placeholder="Country" style="display: block; margin-top: 0.5rem;"><?php
		}

		// Displays the phone number field
		function set_phone_number() {
			$phone_number = esc_attr(get_option('phone_number'));?>

			<input type="tel" name="phone_number" class="regular-text ltr" id="phone-number" value="<?php echo $phone_number; ?>" placeholder="Phone Number (no spacing)" style="display: block;"><?php
		}

		// Displays the fax number field
		function set_fax_number() {
			$fax_number = esc_attr(get_option('fax_number'));?>

			<input type="tel" name="fax_number" class="regular-text ltr" id="fax-number" value="<?php echo $fax_number; ?>" placeholder="Fax Number (no spacing)" style="display: block;"><?php
		}

		// Displays social media URL fields
		function set_social_media_urls() {
			$facebook_url = esc_attr(get_option('facebook_url'));
			$twitter_url = esc_attr(get_option('twitter_url'));
			$linkedin_url = esc_attr(get_option('linkedin_url'));
			$pinterest_url = esc_attr(get_option('pinterest_url'));?>
			
			<input type="text" name="facebook_url" class="regular-text ltr" id="facebook-url" value="<?php echo $facebook_url; ?>" placeholder="Facebook Page URL" style="display: block;">
			<input type="text" name="twitter_url" class="regular-text ltr" id="twitter-url" value="<?php echo $twitter_url; ?>" placeholder="Twitter Page URL" style="display: block; margin-top: 0.5rem;">
			<input type="text" name="linkedin_url" class="regular-text ltr" id="linkedin-url" value="<?php echo $linkedin_url; ?>" placeholder="LinkedIn Page URL" style="display: block; margin-top: 0.5rem;">
			<input type="text" name="pinterest_url" class="regular-text ltr" id="pinterest-url" value="<?php echo $pinterest_url; ?>" placeholder="Pinterest Page URL" style="display: block; margin-top: 0.5rem;"><?php
		}

		// Displays theme settings fields
		function display_theme_settings_fields() {
			add_settings_section('contact_info', 'Contact Information', null, 'theme-settings');

			register_setting('contact_info', 'website_logo');
			register_setting('contact_info', 'office_address_street');
			register_setting('contact_info', 'office_address_country');
			register_setting('contact_info', 'phone_number');
			register_setting('contact_info', 'fax_number');
			register_setting('contact_info', 'facebook_url');
			register_setting('contact_info', 'twitter_url');
			register_setting('contact_info', 'linkedin_url');
			register_setting('contact_info', 'pinterest_url');

			add_settings_field('website_logo', 'Website Logo', 'set_website_logo', 'theme-settings', 'contact_info');
			add_settings_field('office_address', 'Office Address', 'set_office_address', 'theme-settings', 'contact_info');
			add_settings_field('phone_number', 'Phone Number', 'set_phone_number', 'theme-settings', 'contact_info');
			add_settings_field('fax_number', 'Fax Number', 'set_fax_number', 'theme-settings', 'contact_info');
			add_settings_field('social_media_urls', 'Social Media URLs', 'set_social_media_urls', 'theme-settings', 'contact_info');
		}

		// Display theme settings fields
		add_action('admin_init', 'display_theme_settings_fields');


		// CONTACT & CONTACT FORM
		add_action('init', 'ct_custom_contact_custom_post_type');
		
		add_filter('manage_ct_custom-contact_posts_columns', 'ct_custom_set_contact_columns');
		add_action('manage_ct_custom-contact_posts_custom_column', 'ct_custom_contact_custom_column', 10, 2);
		
		add_action('add_meta_boxes', 'ct_custom_contact_add_meta_box');
		add_action('save_post', 'ct_custom_save_contact_phone_number');
		add_action('save_post', 'ct_custom_save_contact_email_number');

		/* CONTACT Custom Post Type */
		function ct_custom_contact_custom_post_type() {
			$labels = array(
				'name' 				=> 'Messages',
				'singular_name' 	=> 'Message',
				'menu_name'			=> 'Messages',
				'name_admin_bar'	=> 'Message'
			);
			
			$args = array(
				'labels'			=> $labels,
				'show_ui'			=> true,
				'show_in_menu'		=> true,
				'capability_type'	=> 'post',
				'hierarchical'		=> false,
				'menu_position'		=> 26,
				'menu_icon'			=> 'dashicons-email-alt',
				'supports'			=> array('title', 'editor', 'author')
			);
			
			register_post_type('ct_custom-contact', $args);
			
		}

		function ct_custom_set_contact_columns($columns) {
			$addColumns = array();
			$addColumns['title'] = 'Full Name';
			$addColumns['message'] = 'Message';
			$addColumns['phone'] = 'Phone';
			$addColumns['email'] = 'Email';
			$addColumns['date'] = 'Date';
			
			$newColumns = array_slice($columns, 0, 3, true) + $addColumns + array_slice($columns, 3, count($columns) - 1, true);

			return $newColumns;
		}

		function ct_custom_contact_custom_column($column, $post_id) {
			switch($column) {
				case 'message' :
					echo get_the_excerpt();
					break;
					
				case 'email' :
					//email column
					$email = get_post_meta($post_id, '_contact_email_value_key', true);
					echo '<a href="mailto:'.$email.'">'.$email.'</a>';
					break;

				case 'phone' :
					//phone column
					$phone = get_post_meta($post_id, '_contact_phone_value_key', true);
					echo '<a href="tel:'.$phone.'">'.$phone.'</a>';
					break;
			}
		}

		/* CONTACT Meta Boxes */

		function ct_custom_contact_add_meta_box() {
			add_meta_box('contact_phone', 'User Phone', 'ct_custom_contact_phone_callback', 'ct_custom-contact', 'side');
			add_meta_box('contact_email', 'User Email', 'ct_custom_contact_email_callback', 'ct_custom-contact', 'side');
		}

		function ct_custom_contact_phone_callback($post) {
			wp_nonce_field('ct_custom_save_contact_phone_number', 'ct_custom_contact_phone_meta_box_nonce');
			
			$value = get_post_meta($post->ID, '_contact_phone_value_key', true);
			
			echo '<label for="ct_custom_contact_phone_field">User Phone Number	: </label>';
			echo '<input type="tel" id="ct_custom_contact_phone_field" name="ct_custom_contact_phone_field" value="' . esc_attr($value) . '" size="25" />';
		}

		function ct_custom_contact_email_callback($post) {
			wp_nonce_field('ct_custom_save_contact_email_number', 'ct_custom_contact_email_meta_box_nonce');
			
			$value = get_post_meta($post->ID, '_contact_email_value_key', true);
			
			echo '<label for="ct_custom_contact_email_field">User Email Address: </label>';
			echo '<input type="email" id="ct_custom_contact_email_field" name="ct_custom_contact_email_field" value="' . esc_attr($value) . '" size="25" />';
		}

		// saves phone number
		function ct_custom_save_contact_phone_number($post_id) {
			
			if (!isset($_POST['ct_custom_contact_phone_meta_box_nonce'])) {
				return;
			}
			
			if (!wp_verify_nonce($_POST['ct_custom_contact_phone_meta_box_nonce'], 'ct_custom_save_contact_phone_number')) {
				return;
			}
			
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
				return;
			}
			
			if (!current_user_can('edit_post', $post_id)) {
				return;
			}
			
			if (!isset($_POST['ct_custom_contact_phone_field'])) {
				return;
			}
			
			$my_data = sanitize_text_field($_POST['ct_custom_contact_phone_field']);
			
			update_post_meta($post_id, '_contact_phone_value_key', $my_data);
			
		}
		
		// Saves e-mail address
		function ct_custom_save_contact_email_number($post_id) {
			
			if (!isset($_POST['ct_custom_contact_email_meta_box_nonce'])) {
				return;
			}
			
			if (!wp_verify_nonce($_POST['ct_custom_contact_email_meta_box_nonce'], 'ct_custom_save_contact_email_number')) {
				return;
			}
			
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
				return;
			}
			
			if (!current_user_can('edit_post', $post_id)) {
				return;
			}
			
			if (!isset($_POST['ct_custom_contact_email_field'])) {
				return;
			}
			
			$my_data = sanitize_text_field($_POST['ct_custom_contact_email_field']);
			
			update_post_meta($post_id, '_contact_email_value_key', $my_data);
			
		}

		// CONTACT FORM
		add_action('wp_ajax_nopriv_ct_custom_save_user_contact_form', 'ct_custom_save_contact');
		add_action('wp_ajax_ct_custom_save_user_contact_form', 'ct_custom_save_contact');
		
		function ct_custom_save_contact() {
			$title = wp_strip_all_tags($_POST['name']);
			$phone = wp_strip_all_tags($_POST['phone']);
			$email = wp_strip_all_tags($_POST['email']);
			$message = wp_strip_all_tags($_POST['message']);

			$args = array(
				'post_title' => $title,
				'post_content' => $message,
				'post_author' => 1,
				'post_status' => 'publish',
				'post_type' => 'ct_custom-contact',
				'meta_input' => array(
					'_contact_phone_value_key' => $phone,
					'_contact_email_value_key' => $email
				),
			);

			$postID = wp_insert_post($args);

			if ($postID !== 0) {
				$to = get_bloginfo('admin_email');
				$subject = 'CT Custom Contact Form - '.$title;

				$headers[] = 'From: '.get_bloginfo('name').' <'.$to.'>';
				$headers[] = 'Reply-To: '.$title.' <'.$email.'>';
				$headers[] = 'Content-Type: text/html: charset=UTF-8';

				wp_mail($to, $subject, $message, $headers);
			}

			echo $postID;

			die();
		}

		function mailtrap($phpmailer) {
			$phpmailer->isSMTP();
			$phpmailer->Host = 'smtp.mailtrap.io';
			$phpmailer->SMTPAuth = true;
			$phpmailer->Port = 2525;
			$phpmailer->Username = '052b62966a93b6';
			$phpmailer->Password = '9a04cd804970fe';
		}

		add_action('phpmailer_init', 'mailtrap');
	}
endif;
add_action( 'after_setup_theme', 'ct_custom_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ct_custom_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'ct_custom_content_width', 640 );
}
add_action( 'after_setup_theme', 'ct_custom_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ct_custom_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ct-custom' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ct-custom' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'ct_custom_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ct_custom_scripts() {
	wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );

	wp_enqueue_style( 'ct-custom-style', get_template_directory_uri() . '/css/style.css' );

	// wp_enqueue_style( 'ct-custom-style', get_stylesheet_uri() );

	// wp_enqueue_script( 'ct-custom-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	// wp_enqueue_script( 'ct-custom-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	// Front-End page header JavaScript
	wp_enqueue_script( 'ct-custom-header-navigation', get_template_directory_uri() . '/js/header-navigation.js', array(), '20220120', true );

	// Contact form JavaScript
	wp_enqueue_script( 'ct-custom-contact', get_template_directory_uri() . '/js/contact.js', array('jquery'), '20220120', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ct_custom_scripts' );

// Theme settings scripts
function theme_settings_scripts() {
	wp_enqueue_script( 'ct-custom-theme-settings.js', get_template_directory_uri() . '/js/theme-settings.js', array('jquery'), '20220120', true );
}

add_action( 'admin_enqueue_scripts', 'theme_settings_scripts' );
add_action( 'admin_enqueue_scripts', function( $hook_suffix ) {
		wp_enqueue_media();
	}
);

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
