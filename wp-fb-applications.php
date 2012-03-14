<?php
/*
Plugin Name: WP-Facebook applications
Version: 0.4.4
Plugin URI: http://www.werewp.com/my-plugins/wp-facebook-applications/
Description: Create custom tabs for your Facebook pages, hosted on your WordPress blog.
Author: Jeremy Herve
Author URI: http://jeremyherve.com
License: GPL2
*/
/*  Copyright 2012 Jeremy Herve (email : jeremy@jeremyherve.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define( 'WPFBAPPS_URL', plugin_dir_url(__FILE__) );

// Internationalization
function werewp_fbapp_load_plugin_textdomain() {
	load_plugin_textdomain( 'werewpfbapps', false, 'wp-facebook-applications/languages' );
}
add_action( 'init', 'werewp_fbapp_load_plugin_textdomain' );

/*
 * Create a new post type for Facebook iFrame applications
 * within our theme
 */
// Create applications custom post type 
function werewp_fbapp_post_type() {
	register_post_type( 'werewp_fbapp',
		array(
			'labels' => array(
				'name' => __( 'Applications', 'werewpfbapps' ),
				'singular_name' => __( 'Application', 'werewpfbapps' ),
				'add_new' => __( 'Add New', 'werewpfbapps' ),
				'add_new_item' => __( 'Add New Facebook tab', 'werewpfbapps' ),
				'edit' => __( 'Edit', 'werewpfbapps' ),
				'edit_item' => __( 'Edit Facebook tab', 'werewpfbapps' ),
				'view' => __( 'View Facebook tab', 'werewpfbapps' )
			),
		'description' => __( 'The Applications post type allows you to create new pages with a custom style and custom options. Creating new applications will allow you to create custom tabs on your Facebook pages.', 'werewpfbapps' ),
		'public' => true,
		'has_archive' => true,
		'exclude_from_search' => true,
		'menu_position' => 20,
		'menu_icon' => WPFBAPPS_URL . '/img/fb-app.png',
		'rewrite' => array( 'slug' => 'fbtabs', 'with_front' => false ),
		'supports' => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies' => array( 'app_id', 'app_secret', 'app_fbcomments' ),
		)
	);
	flush_rewrite_rules();
}
add_action( 'init', 'werewp_fbapp_post_type' );

// Add support for thumbnails
add_post_type_support( 'werewp_fbapp', 'thumbnail' );

// Register thumbnails
function werewp_fbapps_thumbnails() {
	add_theme_support( 'post-thumbnails' );
	if ( function_exists( 'add_image_size' ) ) {
    	add_image_size( 'fb-nonfans', 520, 2000, true );
	}
}
add_action( 'after_setup_theme', 'werewp_fbapps_thumbnails' );


/*
 * Customize our Edit Custom type panel to be able to
 * include Facebook application settings
 */
// Change Enter the title prompt on page
function werewp_fbapp_title( $title ){
     $screen = get_current_screen();
 
     if  ( 'werewp_fbapp' == $screen->post_type ) {
          $title = __( 'Enter the name of your Facebook tab', 'werewpfbapps' );
     }
 
     return $title;
} 
add_filter( 'enter_title_here', 'werewp_fbapp_title' );

// Add metaboxes with custom fields
function werewp_fbapps_metaboxes(){
	add_meta_box( 'appid_meta', __( 'Application parameters', 'werewpfbapps'), 'werewp_fbappappparameters', 'werewp_fbapp', 'advanced', 'core' );
}
add_action( 'admin_init', 'werewp_fbapps_metaboxes' );
 
function werewp_fbappappparameters() {
  	global $post;
 	$custom = get_post_custom($post->ID);
 	$appid = $custom['appid'][0];
 	$appsecret = $custom['appsecret'][0];
 	$fbcomments = $custom['fbcomments'][0];
 	?>
 	<h3><?php _e( 'Create your application on Facebook', 'werewpfbapps' ); ?></h3>
	<p><?php _e( 'Before to start creating content, you must create an application on Facebook:', 'werewpfbapps' ); ?>
	 <a href="http://www.facebook.com/developers/createapp.php" target="_blank"><?php _e( 'Create application.', 'werewpfbapps' ); ?></a> 
	 <?php _e( 'Once it is done, provide a description and icons to that application. Then, in the <strong>Web Site</strong> tab, fill in with your website\'s URL.', 'werewpfbapps'); ?></p>
	<h3><?php _e( 'Fill it application details', 'werewpfbapps' ); ?></h3>
	<p><?php _e( 'You now have the necessary information to fill in the parameters below:', 'werewpfbapps' ); ?></p>
 	<p><label><strong><?php _e( 'Application ID:', 'werewpfbapps' ); ?></strong></label><br />
 	<textarea cols="50" rows="1" name="appid"><?php echo $appid; ?></textarea></p>
 	<p><label><strong><?php _e( 'Application Secret:', 'werewpfbapps' ); ?></strong></label><br />
 	<textarea cols="50" rows="1" name="appsecret"><?php echo $appsecret; ?></textarea></p>
 	<p><label><strong><?php _e( 'Number of Facebook comments displayed</strong> (leave empty if you do not wish to have this feature enabled):', 'werewpfbapps' ); ?></label><br />
 	<textarea cols="1" rows="1" name="fbcomments"><?php echo $fbcomments; ?></textarea></p>
 	<h3><?php _e( 'Choose the image displayed to the non-fans of your page', 'werewpfbapps' ); ?></h3>
 	<p><?php _e( 'Facebook users who are not fans of your page will see a single image, that you input in the <strong>Featured image</strong> area of this page.<br/>If you don\'t want any specific content for the non-fans, simply leave the Featured Image empty, and all viewers will see all the content.', 'werewpfbapps' ); ?></p>
 	<h3><?php _e( 'Add content for your fans to see', 'werewpfbapps' ); ?></h3>
 	<p><?php _e( 'In the content area, add the content you want your fans to see. Publish, copy the URL of the created page to your clipboard:', 'werewpfbapps' ); ?><br/><br/><code><?php the_permalink(); ?></code></p>
 	<p><?php _e( 'Back to Facebook and your application settings, in the <strong>Facebook integration tab</strong>, scroll to the bottom and paste your URL into the <em>Tab URL</em> box.', 'werewpfbapps' ); ?></p>
 	<p><?php _e( 'And that\'s it!', 'werewpfbapps' ); ?></p>
 	<?php
}
 
function werewp_save_details(){
	global $post;

	if ( $post->post_type == 'werewp_fbapp' ) {
		update_post_meta($post->ID, 'appid', $_POST['appid']);
		update_post_meta($post->ID, 'appsecret', $_POST['appsecret']);
		update_post_meta($post->ID, 'fbcomments', $_POST['fbcomments']);
	}
}
add_action( 'save_post', 'werewp_save_details' );

// Add columns to Edit panel
function werewp_fbapp_edit_columns($columns){
  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title' => __( 'Application title', 'werewpfbapps' ),
    'appid' => __( 'Application ID', 'werewpfbapps' ),
    'appsecret' => __( 'Application secret', 'werewpfbapps' ),
  );
 
  return $columns;
}
add_filter( 'manage_edit-werewp_fbapp_columns', 'werewp_fbapp_edit_columns' );

function werewp_fbapp_custom_columns($column){
  global $post;
 
  switch ($column) {
    case "appid":
      $custom = get_post_custom();
      echo $custom["appid"][0];
      break;
    case "appsecret":
      $custom = get_post_custom();
      echo $custom["appsecret"][0];
      break;
  }
}
add_action( 'manage_posts_custom_column', 'werewp_fbapp_custom_columns' );


/*
 * Customize the display of the custom post type
 * on the frontend
 */
// Do not allow indexing of the application pages
function werewp_fbapps_robots() {
	if ( 'werewp_fbapp' == get_post_type() ) { ?>
	<meta name="robots" content="noindex,nofollow" />
	<?php }
}
add_action( 'wp_head', 'werewp_fbapps_robots' );

// Load specific template page for custom post type
function werewp_fbapp_template() {
    if ( 'werewp_fbapp' == get_post_type() ) {
        include( 'template.php' );
        exit;
    }
}
add_action( 'template_redirect', 'werewp_fbapp_template' );

// Load specific css for custom post type
function werewp_fbapps_style() {
	$fbapps_style = WPFBAPPS_URL . 'css/fblayout.css';
	
	if ( 'werewp_fbapp' == get_post_type() && !is_admin() ) {
		wp_register_style('werewp-fbapps', $fbapps_style);
        wp_enqueue_style( 'werewp-fbapps');
	}
}
add_action( 'wp_print_styles', 'werewp_fbapps_style' );

// Restrict the width of the embedded media to 488px
function werewp_fbapps_embed( $embed_size ) {
    if ( 'werewp_fbapp' == get_post_type() ) { 
        $embed_size['width'] = 488;
        $embed_size['height'] = 600;
    }
    return $embed_size;
}
add_filter( 'embed_defaults', 'werewp_fbapps_embed' );
?>