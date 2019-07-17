<?php
/**
 * _ez functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _s
 */

if ( ! function_exists( '_ez_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function _ez_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on _s, use a find and replace
		 * to change '_ez' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( '_ez', get_template_directory() . '/languages' );

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
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', '_ez' ),
		) );

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
		add_theme_support( 'custom-background', apply_filters( '_ez_custom_background_args', array(
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
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', '_ez_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _ez_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( '_ez_content_width', 640 );
}
add_action( 'after_setup_theme', '_ez_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function _ez_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', '_ez' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', '_ez' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', '_ez_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function _ez_scripts() {
	wp_enqueue_style( '_s-style', get_stylesheet_uri() );

	wp_enqueue_script( '_s-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( '_s-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', '_ez_scripts' );

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

/**
 * Changes reset password to more uniform text
 */
add_action( 'resetpass_form', 'resettext');
function resettext(){ ?>

<script type="text/javascript">
   jQuery( document ).ready(function() {                 
     jQuery('#resetpassform input#wp-submit').val("Set Password");
   });
</script>
<?php
}

/**
 * Hides shit from the default login on wp.login
 */
function my_login_page_remove_back_to_link() { ?>
    <style type="text/css">
        body.login div#login p#backtoblog,
        body.login div#login p#nav {
          display: none;
        }
    </style>
<?php }
//This loads the function above on the login page
add_action( 'login_enqueue_scripts', 'my_login_page_remove_back_to_link' );

/**
 * Redirects the user if not admin to a specific page
 */
function admin_login_redirect( $redirect_to, $request, $user ) {
	global $user;
	
	if( isset( $user->roles ) && is_array( $user->roles ) ) {
	   if( in_array( "administrator", $user->roles ) ) {
	   return $redirect_to;
	   } 
	   else {
		return home_url();
	   }
	}
	else {
	return $redirect_to;
	}
 }
add_filter("login_redirect", "admin_login_redirect", 10, 3);

/**
 * Custom pagination
 */
function pagination($pages = '', $range = 4)
{
    $showitems = ($range * 2)+1;
 
    global $paged;
    if(empty($paged)) $paged = 1;
 
    if($pages == '')
    {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if(!$pages)
        {
            $pages = 1;
        }
    }
 
    if(1 != $pages)
    {
        echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
        if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
        if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
 
        for ($i=1; $i <= $pages; $i++)
        {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
            {
                echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
            }
        }
 
        if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";
        if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
        echo "</div>\n";
    }
}

/**
 * Somehow fixes the buggy pagination
 */
function custom_posts_per_page( $query ) {
if ( $query->is_archive('project') ) 
	{
	set_query_var('posts_per_page', -1);
	}
}
add_action( 'pre_get_posts', 'custom_posts_per_page' );

/**
 * Hide the tags that are not needed in pagination
 */
function sanitize_pagination($content) {
	// Remove h2 tag
	$content = str_replace('role="navigation"', '', $content);
    $content = preg_replace('#<h2.*?>(.*?)<\/h2>#si', '', $content);
    return $content;
}
add_action('navigation_markup_template', 'sanitize_pagination');

/**
 *Remove access to normal users from wp admin backend
 */
function wpse23007_redirect(){
	if( is_admin() && !defined('DOING_AJAX') && ( current_user_can('subscriber') || current_user_can('contributor') ) ){
	  wp_redirect(home_url());
	  exit;
	}
}
add_action('init','wpse23007_redirect');

/**
 *Remove admin panel for frontend users
 */
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}
add_action('after_setup_theme', 'remove_admin_bar');

add_filter( 'wp_mime_type_icon', 'acf_change_icon_on_files', 10, 3 );

/**
	 * Create A Simple Theme Options Panel
	 *
	 */
	
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}
	
	// Start Class
	if ( ! class_exists( 'WPEX_Theme_Options' ) ) {
	
		class WPEX_Theme_Options {
	
			/**
			 * Start things up
			 *
			 * @since 1.0.0
			 */
			public function __construct() {
	
				// We only need to register the admin panel on the back-end
				if ( is_admin() ) {
					add_action( 'admin_menu', array( 'WPEX_Theme_Options', 'add_admin_menu' ) );
					add_action( 'admin_init', array( 'WPEX_Theme_Options', 'register_settings' ) );
				}
	
			}
	
			/**
			 * Returns all theme options
			 *
			 * @since 1.0.0
			 */
			public static function get_theme_options() {
				return get_option( 'theme_options' );
			}
	
			/**
			 * Returns single theme option
			 *
			 * @since 1.0.0
			 */
			public static function get_theme_option( $id ) {
				$options = self::get_theme_options();
				if ( isset( $options[$id] ) ) {
					return $options[$id];
				}
			}
	
			/**
			 * Add sub menu page
			 *
			 * @since 1.0.0
			 */
			public static function add_admin_menu() {
				add_menu_page(
					esc_html__( 'Theme Settings', 'ez' ),
					esc_html__( 'Theme Settings', 'ez' ),
					'manage_options',
					'theme-settings',
					array( 'WPEX_Theme_Options', 'create_admin_page' )
				);
			}
	
			/**
			 * Register a setting and its sanitization callback.
			 *
			 * We are only registering 1 setting so we can store all options in a single option as
			 * an array. You could, however, register a new setting for each option
			 *
			 * @since 1.0.0
			 */
			public static function register_settings() {
				register_setting( 'theme_options', 'theme_options', array( 'WPEX_Theme_Options', 'sanitize' ) );
			}
	
			/**
			 * Sanitization callback
			 *
			 * @since 1.0.0
			 */
			public static function sanitize( $options ) {
	
				// If we have options lets sanitize them
				if ( $options ) {
	
					// Checkbox
					// if ( ! empty( $options['checkbox_example'] ) ) {
					// 	$options['checkbox_example'] = 'on';
					// } else {
					// 	unset( $options['checkbox_example'] ); // Remove from options if not checked
					// }
	
					// // Input
					// if ( ! empty( $options['input_example'] ) ) {
					// 	$options['input_example'] = sanitize_text_field( $options['input_example'] );
					// } else {
					// 	unset( $options['input_example'] ); // Remove from options if empty
					// }

					// Input
					if ( ! empty( $options['place1'] ) ) {
						$options['place1'] = sanitize_text_field( $options['place1'] );
					} else {
						unset( $options['place1'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['place2'] ) ) {
						$options['place2'] = sanitize_text_field( $options['place2'] );
					} else {
						unset( $options['place2'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['place1_phone'] ) ) {
						$options['place1_phone'] = sanitize_text_field( $options['place1_phone'] );
					} else {
						unset( $options['place1_phone'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['place1_address'] ) ) {
						$options['place1_address'] = sanitize_text_field( $options['place1_address'] );
					} else {
						unset( $options['place1_address'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['place1_email'] ) ) {
						$options['place1_email'] = sanitize_text_field( $options['place1_email'] );
					} else {
						unset( $options['place1_email'] ); // Remove from options if empty
					}

					// Input
					if ( ! empty( $options['place2_phone'] ) ) {
						$options['place2_phone'] = sanitize_text_field( $options['place2_phone'] );
					} else {
						unset( $options['place2_phone'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['place2_address'] ) ) {
						$options['place2_address'] = sanitize_text_field( $options['place2_address'] );
					} else {
						unset( $options['place2_address'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['place2_email'] ) ) {
						$options['place2_email'] = sanitize_text_field( $options['place2_email'] );
					} else {
						unset( $options['place2_email'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['pagination'] ) ) {
						$options['pagination'] = sanitize_text_field( $options['pagination'] );
					} else {
						unset( $options['pagination'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['login_error'] ) ) {
						$options['login_error'] = sanitize_text_field( $options['login_error'] );
					} else {
						unset( $options['login_error'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['email_body'] ) ) {
						$options['email_header'] = sanitize_text_field( $options['email_header'] );
					} else {
						unset( $options['email_header'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['email_body'] ) ) {
						$options['email_body'] = sanitize_text_field( $options['email_body'] );
					} else {
						unset( $options['email_body'] ); // Remove from options if empty
					}
					// Input
					if ( ! empty( $options['email_link'] ) ) {
						$options['email_link'] = sanitize_text_field( $options['email_link'] );
					} else {
						unset( $options['email_link'] ); // Remove from options if empty
					}
	
					// // Select
					// if ( ! empty( $options['select_example'] ) ) {
					// 	$options['select_example'] = sanitize_text_field( $options['select_example'] );
					// }
	
				}
	
				// Return sanitized options
				return $options;
	
			}
	
			/**
			 * Settings page output
			 *
			 * @since 1.0.0
			 */
			public static function create_admin_page() { ?>

<div class="wrap">

    <h1><?php esc_html_e( 'OIl baron settings', 'ez' ); ?></h1>

    <form method="post" action="options.php">

        <?php settings_fields( 'theme_options' ); ?>

        <table class="form-table wpex-custom-admin-login-table">

            <!-- <?php // Checkbox example ?>
							<tr valign="top">
								<th scope="row"><?php// esc_html_e( 'Checkbox Example', 'ez' ); ?></th>
								<td>
									<?php// $value = self::get_theme_option( 'checkbox_example' ); ?>
									<input type="checkbox" name="theme_options[checkbox_example]" <?php// checked( $value, 'on' ); ?>> <?php// esc_html_e( 'Checkbox example description.', 'ez' ); ?>
								</td>
							</tr>
	
							<?php// // Text input example ?>
							<tr valign="top">
								<th scope="row"><?php// esc_html_e( 'Input Example', 'ez' ); ?></th>
								<td>
									<?php// $value = self::get_theme_option( 'input_example' ); ?>
									<input type="text" name="theme_options[input_example]" value="<?php// echo esc_attr( $value ); ?>">
								</td>
							</tr> -->

            <?php // book online text ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Place of work', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'place1' ); ?>
                    <input type="text" name="theme_options[place1]" value="<?php echo esc_attr( $value ); ?>">
                </td>
            </tr>
            <?php // book online text ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Place of work Phone Number', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'place1_phone' ); ?>
                    <input type="text" name="theme_options[place1_phone]" value="<?php echo esc_attr( $value ); ?>">
                </td>
            </tr>

            <?php // book online link ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Place of work Address', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'place1_address' ); ?>
                    <textarea type="text" name="theme_options[place1_address]" cols="50"
                        rows="8" /><?php echo esc_attr( $value ); ?></textarea>
                </td>
            </tr>

            <?php // footer copyright ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Place of work Email ', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'place1_email' ); ?>
                    <input type="text" name="theme_options[place1_email]" value="<?php echo esc_attr( $value ); ?>">
                </td>
            </tr>

            <?php // telephone number ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Place of work', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'place2' ); ?>
                    <input type="text" name="theme_options[place2]" value="<?php echo esc_attr( $value ); ?>">
                </td>
            </tr>
            <?php // telephone number ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Place of work Phone Number', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'place2_phone' ); ?>
                    <input type="text" name="theme_options[place2_phone]" value="<?php echo esc_attr( $value ); ?>">
                </td>
            </tr>

            <?php // telephone number ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Place of work Address', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'place2_address' ); ?>
                    <textarea type="text" name="theme_options[place2_address]" cols="50"
                        rows="8" /><?php echo esc_attr( $value ); ?></textarea>

                </td>
            </tr>

            <?php // telephone number ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Place of work Email', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'place2_email' ); ?>
                    <input type="text" name="theme_options[place2_email]" value="<?php echo esc_attr( $value ); ?>">
                </td>
			</tr>

			<tr valign="top">
				<th scope="row"><h2><?php esc_html_e( 'Pagination settings', 'ez' ); ?></h2></th>
			</tr>
            <?php // telephone number ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'How many certificates to be shown on one page', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'pagination' ); ?>
                    <input type="text" name="theme_options[pagination]" value="<?php echo esc_attr( $value ); ?>">
                </td>
            </tr>

			<tr valign="top">
				<th scope="row"><h2><?php esc_html_e( 'Login settings (If using custom login pages/forms)', 'ez' ); ?></h2></th>
			</tr>
            <?php // telephone number ?>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'If user name or/and password doesnt match error header', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'login_error' ); ?>
                    <input type="text" name="theme_options[login_error]" value="<?php echo esc_attr( $value ); ?>">
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'If user name or/and password doesnt match error message', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'login_error_text' ); ?>
					<textarea type="text" name="theme_options[login_error_text]" cols="50"
                        rows="8" /><?php echo esc_attr( $value ); ?></textarea>
                </td>
			</tr>

			<tr valign="top">
				<th scope="row"><h2><?php esc_html_e( 'User registration email settings (If using custom email plugin)', 'ez' ); ?></h2></th>
			</tr>
			<tr valign="top">
                <th scope="row"><?php esc_html_e( 'Email header ', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'email_header' ); ?>
					<textarea type="text" name="theme_options[email_header]" cols="50"
                        rows="8" /><?php echo esc_attr( $value ); ?></textarea>
                </td>
            </tr>

			<tr valign="top">
                <th scope="row"><?php esc_html_e( 'Email message', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'email_body' ); ?>
					<textarea type="text" name="theme_options[email_body]" cols="50"
                        rows="8" /><?php echo esc_attr( $value ); ?></textarea>
                </td>
            </tr>

			<tr valign="top">
                <th scope="row"><?php esc_html_e( 'Email link message', 'ez' ); ?></th>
                <td>
                    <?php $value = self::get_theme_option( 'email_link' ); ?>
					<input type="text" name="theme_options[email_link]" value="<?php echo esc_attr( $value ); ?>">
                </td>
            </tr>

            <!-- <?php// // Select example ?>
							<tr valign="top" class="wpex-custom-admin-screen-background-section">
								<th scope="row"><?php// esc_html_e( 'Select Example', 'ez' ); ?></th>
								<td>
									<?php// $value = self::get_theme_option( 'select_example' ); ?>
									<select name="theme_options[select_example]">
										<?php//
										//$options = array(
										//	'1' => esc_html__( 'Option 1', 'ez' ),
										//	'2' => esc_html__( 'Option 2', 'ez' ),
										//	'3' => esc_html__( 'Option 3', 'ez' ),
										//);
										//foreach ( $options as $id => $label ) { ?>
											<option value="<?php// echo esc_attr( $id ); ?>" <?php// selected( $value, $id, true ); ?>>
												<?php// echo strip_tags( $label ); ?>
											</option>
										<?php// } ?>
									</select>
								</td>
							</tr> -->

        </table>

        <?php submit_button(); ?>

    </form>

</div><!-- .wrap -->
<?php }
	
		}
	}
	new WPEX_Theme_Options();
	
	// Helper function to use in your theme to return a theme option value
	function myprefix_get_theme_option( $id = '' ) {
		return WPEX_Theme_Options::get_theme_option( $id );
	}
