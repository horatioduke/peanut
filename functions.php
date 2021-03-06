<?php
/**
 * Peanut functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Peanut
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'peanut_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function peanut_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Peanut, use a find and replace
		 * to change 'peanut' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'peanut', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

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
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'peanut' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
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

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'peanut_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'peanut_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function peanut_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'peanut_content_width', 640 );
}
add_action( 'after_setup_theme', 'peanut_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

function peanut_custom_widgets_init() {

	register_sidebar( array(
		'name'          => 'Front Page Contact Area',
		'id'            => 'front_page_contact_widget_1',
		'before_widget' => '<div class="front_page_contact_widget_1 widget-area centered-widget" role="complementary">',
		'after_widget'  => '</div>',
		'before_title'  => '<header class="widget-header"><h2 class="scaled-down">',
		'after_title'   => '</h2></header>',
	) );

	register_sidebar( array(
		'name'          => 'Footer Area',
		'id'            => 'footer_widget_1',
		'before_widget' => '<div class="footer_widget_1 widget-area centered-widget" role="complementary">',
		'after_widget'  => '</div>',
		'before_title'  => '<header class="widget-header"><h2 class="scaled-down">',
		'after_title'   => '</h2></header>',
	) );

}
add_action( 'widgets_init', 'peanut_custom_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function peanut_scripts() {

	// Google Fonts

	$headings_font = get_theme_mod('peanut_headings_fonts');
	$headings_font_size = get_theme_mod('peanut_headings_fonts_sizes');
	$body_font = get_theme_mod('peanut_body_fonts');
	$body_font_size = get_theme_mod('peanut_body_fonts_sizes');
	
	if( $headings_font ) {
		wp_enqueue_style( 'peanut-headings-fonts', '//fonts.googleapis.com/css?family='. $headings_font );
	} else {
		wp_enqueue_style( 'peanut-headings_fonts', '//fonts.googleapis.com/css?family=Cormorant+Garamond:300,300italic,400,400italic,700,700italic');
	}
	if( $body_font ) {
		wp_enqueue_style( 'peanut-body-fonts', '//fonts.googleapis.com/css?family='. $body_font );
	} else {
		wp_enqueue_style( 'peanut-body-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,700,700italic');
	}

	// Stylesheets

	wp_style_add_data( 'peanut-style', 'rtl', 'replace' );
	
	// Javascript

	wp_enqueue_script( 'peanut-jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js' );
	wp_enqueue_script( 'peanut-font-awesome', 'https://use.fontawesome.com/1d1478e2c0.js' );
	wp_enqueue_script( 'peanut-jankybox', get_template_directory_uri() . '/js/jankybox.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'peanut-scripts', get_template_directory_uri() . '/js/scripts.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'peanut-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'peanut-carousel', get_template_directory_uri() . '/js/bootstrap-carousel.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Inline Styles from Customizer

}
add_action( 'wp_enqueue_scripts', 'peanut_scripts' );


/**
 * Customizer Settings
 */

 // Give the output a CSS handler - in this case style.css
 function peanut_customizer_settings() {
    wp_enqueue_style(
        'peanut_customizer_values',
        get_template_directory_uri() . '/style.css'
	);
	
	$neutral = get_theme_mod('peanut_neutral_color');
	$dark = get_theme_mod('peanut_dark_color');
	$midtone = get_theme_mod('peanut_midtone_color');
	$accent1 = get_theme_mod('peanut_accent_color_1');
	$accent2 = get_theme_mod('peanut_accent_color_2');
	$headings_font = get_theme_mod('peanut_headings_fonts');
	$headings_font_size = get_theme_mod('peanut_headings_fonts_sizes');
	$body_font = get_theme_mod('peanut_body_fonts');
	$body_font_size = get_theme_mod('peanut_body_fonts_sizes');

	$custom_css .= ":root { --main-neutral: $neutral; --main-dark: $dark; --main-midtone: $midtone; --main-accent-1: $accent1; --main-accent-2: $accent2; }" . "\n";

	if ( $body_font && $body_font_size ) {
		$font_pieces = explode(":", $body_font);
		$custom_css .= "body, button, input, select, textarea { font-family: {$font_pieces[0]}; font-weight: {$body_font_size}; }"."\n";
	}
	
	if ( $headings_font && $headings_font_size ) {
		$font_pieces = explode(":", $headings_font);
		$custom_css .= "h1, h2, h3, h4, h5, h6 { font-family: {$font_pieces[0]}; font-weight: {$headings_font_size}; }";
	}

    wp_add_inline_style( 'peanut_customizer_values', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'peanut_customizer_settings' );


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


// 'Peanut' Theme Additions

/**
 * Apply tags to media attachments.
*/
function wptp_add_tags_to_attachments() {
    register_taxonomy_for_object_type( 'post_tag', 'attachment' );
}
add_action( 'init' , 'wptp_add_tags_to_attachments' );


/**
 * Create a placeholder image for Carousel Slide 1
 */

function peanut_carousel_placeholder() {
	add_theme_support( 'peanut-carousel-img', apply_filters( 'peanut_carousel_placeholder_args', array(
		'default-image' => get_template_directory_uri() . '/img/carousel_1.jpg',
	) ) );
}
add_action( 'after_setup_theme', 'peanut_carousel_placeholder' );


/**
 * Call the Images into the Front Page Carousel.
 */

function get_carousel_images() {
	
	$carousel_img_1 = get_theme_mod( 'carousel_img_1' );
	$carousel_img_2 = get_theme_mod( 'carousel_img_2' );
	$carousel_img_3 = get_theme_mod( 'carousel_img_3' );
	$carousel_img_4 = get_theme_mod( 'carousel_img_4' );
	$carousel_img_5 = get_theme_mod( 'carousel_img_5' );
	
		?>
			<section id="welcome" class="welcome-section" >
			<div id="welcome-carousel" class="carousel slide carousel-fade" data-ride="carousel" data-interval="3500">
			<div class="carousel-inner">

			<div class="carousel-item active"> 
			<?php if ( $carousel_img_1 ) { ?>
			<img
				src="<?php	$profID = get_theme_mod( 'carousel_img_1' ); echo wp_get_attachment_url( $profID );	?>"
				alt="Carousel Image 1"
			>
			<?php } else { ?>
			<img
				src="<?php echo get_template_directory_uri() . '/img/carousel_1.jpg'; ?>"
				alt="Carousel Image Spoon"
			>
			<?php } ?>
			</div>
			<?php

			if ( $carousel_img_2 ) { ?>
			<div class="carousel-item">
			<img
				src="<?php $profID = get_theme_mod( 'carousel_img_2' ); echo wp_get_attachment_url( $profID );?>"
				alt="Carousel Image 2"
			>
			</div>
			<?php }

			if ( $carousel_img_3 ) { ?>
			<div class="carousel-item">
			<img
				src="<?php $profID = get_theme_mod( 'carousel_img_3' ); echo wp_get_attachment_url( $profID );?>"
				alt="Carousel Image 3"
			>
			</div>
			<?php }

			if ( $carousel_img_4 ) { ?>
			<div class="carousel-item">
			<img
				src="<?php $profID = get_theme_mod( 'carousel_img_4' ); echo wp_get_attachment_url( $profID );?>"
				alt="Carousel Image 4"
			>
			</div>
			<?php }

			if ( $carousel_img_5 ) { ?>
			<div class="carousel-item">
			<img
				src="<?php $profID = get_theme_mod( 'carousel_img_5' ); echo wp_get_attachment_url( $profID );?>"
				alt="Carousel Image 5"
			>
			</div>
			<?php }
			?>
		
		<div class="carousel-caption">
			<?php
			$peanut_description = get_bloginfo( 'description', 'display' );
				the_custom_logo();
				?>
			<div class="microtron">
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<p class="site-description uppercase-spaced"><?php echo $peanut_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			</div>

			<?php
			if ( get_theme_mod( 'floating_prompt_destination' ) != '' ) {
			?>
			
			<a href="<?php echo get_home_url() . get_theme_mod( 'floating_prompt_destination' ); ?>" class="prompt-to-scroll">
				<p><i class="fa fa-chevron-down"></i></p>
			</a>

				<?php } ?>

		</div>

		</div>
		</div>	
		
		</section>

		<?php	
}

/**
 * Create 'Photo Collection' Content Type.
 */

// The custom post type function
 
function photo_collection_post_type() {
 
	// Set UI labels for Custom Post Type
		$labels = array(
			'name'                => _x( 'Photo Collections', 'Post Type General Name', 'peanut' ),
			'singular_name'       => _x( 'Photo Collection', 'Post Type Singular Name', 'peanut' ),
			'menu_name'           => __( 'Photo Collections', 'peanut' ),
			'parent_item_colon'   => __( 'Parent Photo Collection', 'peanut' ),
			'all_items'           => __( 'All Photo Collections', 'peanut' ),
			'view_item'           => __( 'View Photo Collection', 'peanut' ),
			'add_new_item'        => __( 'Add New Photo Collection', 'peanut' ),
			'add_new'             => __( 'Add New', 'peanut' ),
			'edit_item'           => __( 'Edit Photo Collection', 'peanut' ),
			'update_item'         => __( 'Update Photo Collection', 'peanut' ),
			'search_items'        => __( 'Search Photo Collection', 'peanut' ),
			'not_found'           => __( 'Not Found', 'peanut' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'peanut' ),
		);
		 
	// Set other options for Custom Post Type
		 
		$args = array(
			'label'               => __( 'photo_collection', 'peanut' ),
			'description'         => __( '', 'peanut' ),
			'labels'              => $labels,
			// Features this CPT supports in Post Editor
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
			
			// Associate the Custom Post Type with a taxonomy or custom taxonomy. 
			
			'taxonomies'          => array( 'genres' => 'genres', ), // Not needed right now.
			
			/* A hierarchical CPT is like Pages and can have
			* Parent and child items. A non-hierarchical CPT
			* is like Posts.
			*/ 
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest' 		  => true, // Provides block editor support!
	 
		);
		 
		// Registering your Custom Post Type
		register_post_type( 'photo_collection', $args );
	 
	}
	 
	/* Hook into the 'init' action so that the function
	* Containing our post type registration is not 
	* unnecessarily executed. 
	*/
	 
	add_action( 'init', 'photo_collection_post_type', 0 );

add_action( 'init', 'peanut_photo_collection_taxonomy', 0 );

//Custom Photo Portfolio Taxonomy

function peanut_photo_collection_taxonomy() {
	
	$labels = array(
	'name' => _x( 'Peanut Theme Options', 'taxonomy general name' ),
	'singular_name' => _x( 'Peanut Theme Option', 'taxonomy singular name' ),
	'search_items' =>  __( 'Search Peanut Theme Options' ),
	'all_items' => __( 'All Peanut Theme Options' ),
	'parent_item' => __( 'Parent Peanut Theme Option' ),
	'parent_item_colon' => __( 'Parent Peanut Theme Option:' ),
	'edit_item' => __( 'Edit Peanut Theme Option' ), 
	'update_item' => __( 'Update Peanut Theme Option' ),
	'add_new_item' => __( 'Add New Peanut Theme Option' ),
	'new_item_name' => __( 'New Type Peanut Theme Option' ),
	'menu_name' => __( 'Peanut Theme Option' ),
	);

	$capabilities = array(
	'manage_terms' => '',
    'edit_terms'   => '',
    'delete_terms' => '',
	// 'assign_terms' => 'edit_post' 
	);
	
	register_taxonomy('peanut_photo_collection_options',array('photo_collection'), array(
	'hierarchical' => true,
	'labels' => $labels,
	'show_ui' => true,
	'show_admin_column' => true,
	'query_var' => true,
	'rewrite' => array( 'slug' => 'photo-collection-options' ),
	'capabilities' => $capabilities
	));
}

/**
 * Force the Custom Photo Collection Taxonomy to Have One Default Option.
 */
function force_photo_collection_term() {
	if(!term_exists('Stick to Front Page Portfolio', 'peanut_photo_collection_options'))
    wp_insert_term('Stick to Front Page Portfolio', 'peanut_photo_collection_options');
}
add_action( 'init', 'force_photo_collection_term', 0 );



/**
 * Call The 'Photo Collection' content type to the Front Page Portfolio Section.
 */
function get_portfolio_section() {

	if ( get_theme_mod( 'display_portfolio_section' ) == true ) {
	
		$args = array(
			'post_type' => 'photo_collection',
			'peanut_photo_collection_options' => 'Stick to Front Page Portfolio',
			'orderby' => 'modified',
			'order' => 'DESC'
		);

		$portfolio_item_count = $args['posts_per_page'];
		
		$portfolio_items = get_posts( $args ); 
		if ($portfolio_items) {
			?>
			
			<section id="portfolio" class="standard-section portfolio-section">
				<?php if ( get_theme_mod( 'portfolio_section_header' ) != '' ) { ?>
					<h2 class="fp-section-header">
						<?php echo get_theme_mod( 'portfolio_section_header' ) ?>
					</h2>
				<?php } ?>

				<div class="portfolio-grid">
					<?php
						foreach ($portfolio_items as $portfolio_item) {
							?>
							<a href="<?php echo get_post_permalink( $portfolio_item->ID ); ?>" class="portfolio-item">
							<figure>
								<?php
									echo get_the_post_thumbnail( $portfolio_item->ID, 'large', '', ["class" => "portfolio-item-image"] );
								?>
								<figcaption class="gallery-caption uppercase-spaced">
									
									<?php echo get_the_title( $portfolio_item->ID ); ?>
								</figcaption>
							</figure>
							</a>
									<?php
								}
					?>
				</div>
				<?php if ( get_theme_mod( 'portfolio_archive_button_text' ) != '' ) { ?>
					<a
						href="<?php echo get_post_type_archive_link( $portfolio_item->post_type ); ?>"
						class="btn uppercase-spaced portfolio-see-more"
						>
						<span><?php echo get_theme_mod('portfolio_archive_button_text'); ?> <i class="fa fa-chevron-right"></i></span>
					</a>
				<?php } } else { ?>
					<details class="portfolio-empty-msg">
						<summary>This section is currently empty (click for explanation).</summary>
							<p>To populate this section, create and publish a new 'Photo Collection' post type (included with this theme), making sure to attach a featured image.</p>
							<p>Then find your newly created collection in <i><b>Photo Collections > All Photo Collections</b></i> and in the quick edit menu, select <i><b>Stick to Front Page Portfolio</b></i> under 'Peanut Theme Options'.</p>
							<p>This section formats best when populated with collections in multiples of 3.</p>
							<p>To hide this section (including this message) from view for now, uncheck <i>Display 'Portfolio' Section</i> from the customizer menu.</p>
					</details>
					<?php } ?>
			</section>
			<?php
	}
}


/**
 * Calls inputs from the customizer to populate the 'About' section.
 */
function get_about_section() {

	if ( get_theme_mod( 'display_about_section' ) == true ) {
		?>
		<section id="about" class="standard-section about-section">
			<?php if ( get_theme_mod( 'about_section_header' ) != '' ) { ?>
				<h2 class="fp-section-header">
					<?php echo get_theme_mod( 'about_section_header' ); ?>
				</h2>
			<?php } ?>
			
			<div class="about-grid">
			<?php if ( get_theme_mod( 'about_section_img' ) != '' ) { ?>
				<div class="about-tile about-image">
					<img
						src="<?php $profID = get_theme_mod( 'about_section_img' ); echo wp_get_attachment_url( $profID );?>"
						alt="my profile picture"
						class="profile-pic"
					>
				</div>
			<?php }
			if ( get_theme_mod( 'about_section_bio' ) != '' ) { ?>
				<div class="about-tile about-blurb">
					<p><?php echo get_theme_mod( 'about_section_bio' ) ?></p>
				</div>
			<?php } ?>
			</div>
		</section>
		<?php
	}
}

/**
 * Basic contact form.
 */
function peanut_contact_form_code() {
	echo '<form id="contact-form" class="contact-form" action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
	echo '<div class="form-group">';
	echo '<label id="name-label" for="cf-name">Name</label>';
	echo '<input id="name" type="text" name="cf-name" class="form-control" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["name"] ) ? esc_attr( $_POST["name"] ) : '' ) . '" required />';
	echo '</div>';
	echo '<div class="form-group">';
	echo '<label id="email-label" for="cf-email">Email</label>';
	echo '<input id=email" type="email" name="cf-email" class="form-control" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" required />';
	echo '</div>';
	echo '<div class="form-group">';
	echo '<label id="subject-label" for="cf-subject">Subject</label>';
	echo '<input id="subject" type="text" name="cf-subject" class="form-control" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["cf-subject"] ) ? esc_attr( $_POST["cf-subject"] ) : '' ) . '" required />';
	echo '</div>';
	echo '<div class="form-group">';
	echo '<label id="message-label" for="cf-message">Message</label>';
	echo '<textarea id="message" class="input-message" name="cf-message" required >' . ( isset( $_POST["cf-message"] ) ? esc_attr( $_POST["cf-message"] ) : '' ) . '</textarea>';
	echo '</div>';
	echo '<div class="form-group">';
	echo '<button type="submit" id="submit" class="submit-button" name="submit">Submit</button>';
	echo '</div>';
	echo '</form>';
}

// Sanitizes the information submitted to the above form and delivers it to the admin email address.
function peanut_deliver_mail() {

	// if the submit button is clicked, send the email
	if ( isset( $_POST['cf-submitted'] ) ) {

		// sanitize form values
		$name    = sanitize_text_field( $_POST["cf-name"] );
		$email   = sanitize_email( $_POST["cf-email"] );
		$subject = sanitize_text_field( $_POST["cf-subject"] );
		$message = esc_textarea( $_POST["cf-message"] );

		// get the blog administrator's email address
		$to = get_option( 'admin_email' );

		$headers = "From: $name <$email>" . "\r\n";

		// If email has been process for sending, display a success message
		if ( wp_mail( $to, $subject, $message, $headers ) ) {
			echo '<div>';
			echo '<p>Thanks for contacting me, expect a response soon.</p>';
			echo '</div>';
		} else {
			echo 'An unexpected error occurred';
		}
	}
}

// Creates a contact form shortcode.
function peanut_cf_shortcode() {
	ob_start();
	peanut_deliver_mail();
	peanut_contact_form_code();

	return ob_get_clean();
}
add_shortcode( 'peanut_contact_form', 'peanut_cf_shortcode' );

/**
 * Calls inputs from the customizer to populate the 'Contact' section.
 */
function get_contact_section() {
	if ( get_theme_mod( 'display_contact_section' ) == true ) {
		?>
		<section id="contact" class="standard-section contact-section">
			<?php if ( get_theme_mod( 'contact_section_header' ) != '' ) { ?>
			<h2 class="fp-section-header">
				<?php echo get_theme_mod( 'contact_section_header' ) ?>
			</h2>
			<?php } ?>

			<?php if ( get_theme_mod( 'contact_section_textarea' ) != '' ) { ?>
				<p class="fp-section-textarea">
					<?php echo get_theme_mod('contact_section_textarea') ?>
				</p>

			<?php } 
				if ( get_theme_mod( 'display_contact_form' ) == true ) {
					echo do_shortcode( '[peanut_contact_form]' );
			} ?>

			<?php if ( is_active_sidebar( 'front_page_contact_widget_1' ) ) : ?>
				<?php dynamic_sidebar( 'front_page_contact_widget_1' ); ?>
			<?php endif; ?>

		</section>
		<?php
	}
}

/**
 * Creates a Social Media Icons Widget.
 */

class peanut_socials_widget extends WP_Widget {
  
	function __construct() {
	parent::__construct(
	  
	// Base ID of your widget
	'peanut_socials_widget', 
	  
	// Widget name will appear in UI
	__('\'Peanut\' Theme Social Icons', 'peanut_widget_domain'), 
	  
	// Widget description
	array( 'description' => __( 'Displays links to social media sites as animated icons.', 'peanut_widget_domain' ), ) 
	);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	$facebook = apply_filters( 'widget_facebook', $instance['facebook'] );
	$twitter = apply_filters( 'widget_twitter', $instance['twitter'] );
	$instagram = apply_filters( 'widget_instagram', $instance['instagram'] );
	$flickr = apply_filters( 'widget_flickr', $instance['flickr'] );
	$email = apply_filters( 'widget_email', $instance['email'] );
	  
	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	if ( ! empty( $title ) )
	echo $args['before_title'] . $title . $args['after_title'];
	  
	// This is where you run the code and display the output
	if ( $facebook ) {
		?><a href="<?php echo __( $facebook , 'peanut_widget_domain' ); ?>" class="social-contact-link"><i class="fa fa-2x fa-facebook-square"></i></a><?php
	}
	if ( $twitter ) {
		?><a href="<?php echo __( $twitter , 'peanut_widget_domain' ); ?>" class="social-contact-link"><i class="fa fa-2x fa-twitter"></i></a><?php
	}
	if ( $instagram ) {
		?><a href="<?php echo __( $instagram , 'peanut_widget_domain' ); ?>" class="social-contact-link"><i class="fa fa-2x fa-instagram"></i></a><?php
	}
	if ( $flickr ) {
		?><a href="<?php echo __( $flickr , 'peanut_widget_domain' ); ?>" class="social-contact-link"><i class="fa fa-2x fa-flickr"></i></a><?php
	}
	if ( $email ) {
		?><a href="mailto:<?php echo __( $email , 'peanut_widget_domain' ); ?>" class="social-contact-link"><i class="fa fa-2x fa-envelope"></i></a><?php
	}


	echo $args['after_widget'];
	}
			  
	// Widget Backend 
	public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
	$title = $instance[ 'title' ];
	}
	else {
	$title = __( 'Social Media Links:', 'peanut_widget_domain' );
	}
	if ( isset( $instance[ 'facebook' ] ) ) {
	$facebook = $instance[ 'facebook' ];
	}
	else {
	$facebook = __( 'https://facebook.com', 'peanut_widget_domain' );
	}
	if ( isset( $instance[ 'twitter' ] ) ) {
	$twitter = $instance[ 'twitter' ];
	}
	else {
	$twitter = __( 'https://twitter.com', 'peanut_widget_domain' );
	}
	if ( isset( $instance[ 'instagram' ] ) ) {
	$instagram = $instance[ 'instagram' ];
	}
	else {
	$instagram = __( 'https://instagram.com', 'peanut_widget_domain' );
	}
	if ( isset( $instance[ 'flickr' ] ) ) {
	$flickr = $instance[ 'flickr' ];
	}
	else {
	$flickr = __( 'https://flickr.com', 'peanut_widget_domain' );
	}
	if ( isset( $instance[ 'email' ] ) ) {
	$email = $instance[ 'email' ];
	}
	else {
	$email = __( 'example@123example.co', 'peanut_widget_domain' );
	}
	// Widget admin form
	?>

	<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Facebook Page URL:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Twitter Profile URL:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e( 'Instagram Page URL:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" type="text" value="<?php echo esc_attr( $instagram ); ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id( 'flickr' ); ?>"><?php _e( 'Flickr Photo Feed URL:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'flickr' ); ?>" name="<?php echo $this->get_field_name( 'flickr' ); ?>" type="text" value="<?php echo esc_attr( $flickr ); ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email Address:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>" />
	</p>

	<?php 
	}
		  
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	$instance['facebook'] = ( ! empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : '';
	$instance['twitter'] = ( ! empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : '';
	$instance['instagram'] = ( ! empty( $new_instance['instagram'] ) ) ? strip_tags( $new_instance['instagram'] ) : '';
	$instance['flickr'] = ( ! empty( $new_instance['flickr'] ) ) ? strip_tags( $new_instance['flickr'] ) : '';
	$instance['email'] = ( ! empty( $new_instance['email'] ) ) ? strip_tags( $new_instance['email'] ) : '';
	return $instance;
	}
	 
	// Class peanut_socials_widget ends here
} 
	 
	 
// Register and load the widget
function peanut_load_widget() {
	register_widget( 'peanut_socials_widget' );
}
add_action( 'widgets_init', 'peanut_load_widget' );


// Sanitize the Font Selection
function peanut_sanitize_fonts( $input ) {
	$valid = array(
		'Cormorant Garamond:300,300italic,400,400italic,700,700italic' => 'Cormorant Garamond',
		'Josefin Sans:300,300italic,400,400italic,700,700italic' => 'Josefin Sans',
		'Lato:300,300italic,400,400italic,700,700italic' => 'Lato',
		'Merriweather:300,300italic,400,400italic,700,700italic' => 'Merriweather',
		'Montserrat:300,300italic,400,400italic,700,700italic' => 'Montserrat',
		'Open Sans:300,300italic,400,400italic,700,700italic' => 'Open Sans',
		'Raleway:300,300italic,400,400italic,700,700italic' => 'Raleway',
		'Roboto:300,300italic,400,400italic,700,700italic' => 'Roboto',
		'Source Serif Pro:300,300italic,400,400italic,700,700italic' => 'Source Serif Pro',
		'Spectral:300,300italic,400,400italic,700,700italic' => 'Spectral',
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}