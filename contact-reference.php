<?php
/**
 * Plugin Name: Contact Reference
 * Plugin URI: http://pupungbp.com/plugins
 * Description: Dynamically change the contact name of the site
 * Version: 1.0.2
 * Author: Pupung Budi Purnama
 * Author URI: http://pupungbp.com
 * License: GPL2
 */


/**
 * Include Lib
 */
if(!function_exists('cmb_init'))
require_once('lib/metabox/custom-meta-boxes.php');

require_once('inc/metabox.php');


/*
 * Include Languange Text Domain
 */
function cref_add_dc_lang() {
	load_plugin_textdomain( 'contact-reference', false, '/contact-reference/lang' );
}
add_action( 'init', 'cref_add_dc_lang' );

/**
 * Add Custom Post Type For Contact
 */
function cref_add_contact_cpt() {
	$labels = array(
	    'name'               => __( 'Contact','contact-reference' ),
	    'singular_name'      => __( 'Contact','contact-reference' ),
	    'add_new'            => __( 'Add New','contact-reference' ),
	    'add_new_item'       => __( 'Add New Contact','contact-reference' ),
	    'edit_item'          => __( 'Edit Contact','contact-reference' ),
	    'new_item'           => __( 'New Contact','contact-reference' ),
	    'all_items'          => __( 'All Contacts','contact-reference' ),
	    'view_item'          => __( 'View Contact','contact-reference' ),
	    'search_items'       => __( 'Search Contact','contact-reference' ),
	    'not_found'          => __( 'No Contact found','contact-reference' ),
	    'not_found_in_trash' => __( 'No Contact found in Trash','contact-reference' ),
	    'menu_name'          => __( 'Contact Referal','contact-reference' )
  	);

  	$args = array(
	    'labels'             => $labels,
	    'public'             => true,
	    'publicly_queryable' => true,
	    'show_ui'            => true,
	    'show_in_menu'       => true,
	    'query_var'          => true,
	    'rewrite'            => array( 'slug' => 'refcontact' ),
	    'capability_type'    => 'page',
	    'has_archive'        => true,
	    'hierarchical'       => false,
	    'menu_position'      => null,
	    'supports'           => array( 'title' )
  	);

  	register_post_type( 'refcontact', $args );
}
add_action( 'init', 'cref_add_contact_cpt' );

/**
 * Default Text Modification
 */
function cref_change_default_title( $title ){
     $screen = get_current_screen();
 
     if  ( 'refcontact' == $screen->post_type ) {
          $title = __('Contact Referal User ID','contact-reference');
     }
 
     return $title;
}
add_filter( 'enter_title_here', 'cref_change_default_title' );

function cref_change_publish_button( $translation, $text ) {
if ( 'refcontact' == get_post_type())
if ( $text == 'Publish' )
    return 'Save';

return $translation;
}
add_filter( 'gettext', 'cref_change_publish_button', 10, 2 );


/**
 * Add Styling to Admin
 */
function cref_style_admin() {
	echo '<style type="text/css">';
	echo '.acf_postbox p.label { width:25%;float:left; }';
	echo '#titlediv .inside { display: none; }';
	echo '</style>';
}
add_action( 'admin_head', 'cref_style_admin', 19 );

/**
 * Add Front End Styling	
 */
function cref_styling_front() {
	wp_register_style( 'cr-style', plugins_url( '/assets/css/cr-style.css', __FILE__ ) );
    wp_register_style( 'cr-genericons', plugins_url( '/assets/css/genericons.css', __FILE__  ) );
	wp_enqueue_style( 'cr-style' );
    wp_enqueue_style( 'cr-genericons' );
}
add_action( 'wp_enqueue_scripts', 'cref_styling_front' );

/**
 * Add Admin Styling
 */
function cref_styling_back() {
    wp_register_style( 'cr-admin-style', plugins_url( '/assets/css/cr-admin-style.css', __FILE__  ) );
    wp_enqueue_style( 'cr-admin-style' ); 
}
add_action( 'admin_enqueue_scripts', 'cref_styling_back' );

/**
 * Reference URL Metabox
 */
function cref_ref_url() {
	$post_data = get_post($post->ID, ARRAY_A);
    $slug = $post_data['post_name'];
    echo '<strong>';
    echo __( 'URL for Referral:', 'contact-reference' );
    echo '</strong><br />';
	echo get_bloginfo('url') . '/?id=';
	echo $slug;
}
function cref_metabox_url() {
	add_meta_box( 'refurl', 'Reference URL', 'cref_ref_url', 'refcontact', 'side' );
}
add_action( 'add_meta_boxes', 'cref_metabox_url' );

/**
 * Set Manage Posts Column
 */
function cref_set_refcontact_columns($columns) {
    return array(
        'cb' => '<input type="checkbox" />',
        'title' => __('User ID', 'contact-reference'),
        'name' => __('Name', 'contact-reference'),
        'address' => __('Address', 'contact-reference'),
        'phone' => __('Phone', 'contact-reference'),
        'email' =>__( 'Email', 'contact-reference')
    );
}
add_filter( 'manage_refcontact_posts_columns' , 'cref_set_refcontact_columns' );

function cref_custom_refcontact_column( $column, $post_id ) {
		
		$column_name = get_post_meta( get_the_id(), 'name', true );
    	$column_address = get_post_meta( get_the_id(), 'address', true );
    	$column_phone = get_post_meta( get_the_id(), 'phone', true );
    	$column_email = get_post_meta( get_the_id(), 'email', true );

    switch ( $column ) {

        case 'name' :
            echo $column_name;
            break;

        case 'address' :
        	echo $column_address;
            break;

        case 'phone':
        	echo $column_phone;
        	break;

        case 'email':
        	echo $column_email;
        	break;

    }
}
add_action( 'manage_refcontact_posts_custom_column' , 'cref_custom_refcontact_column', 10, 2 );

function cref_remove_quick_edit( $actions ) {
	if( get_post_type() == 'refcontact' ) {
		unset( $actions['inline hide-if-no-js'] );
		unset( $actions['view'] );
	}
	return $actions;
}
add_filter('post_row_actions','cref_remove_quick_edit',11,1);

/**
 * Set Session
 */

include('inc/session.php');


/**
 * Set Widget
 */

include('inc/widget.php');

/**
 * Set Shortcode
 */
include('inc/shortcode.php');

/**
 * Set Icon
 */

function cref_cpt_icons() {
    ?>
    <style type="text/css" media="screen">
        #menu-posts-refcontact .wp-menu-image:before {
            content: '\f465' !important;
        }
    </style>
<?php }
add_action( 'admin_head', 'cref_cpt_icons' );

/**
 * Add Options Page
 */
include('inc/options.php');


