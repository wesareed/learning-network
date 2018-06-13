<?php
/**
 * Plugin Name: Learning Network
 * Plugin URI: https://www.wesreed.co/
 * Description: Registers custom post types and taxonomies
 * Version: 1.0
 * Author: Wes Reed
 * License: GPL2
 */

/*
* Remove Dashboard Widgets
*/
function remove_dashboard_widgets () {

	remove_meta_box('dashboard_quick_press','dashboard','side');         //Quick Press widget
	remove_meta_box('dashboard_recent_drafts','dashboard','side');       //Recent Drafts
	remove_meta_box('dashboard_primary','dashboard','side');             //WordPress.com Blog
	remove_meta_box('dashboard_secondary','dashboard','side');           //Other WordPress News
	remove_meta_box('dashboard_incoming_links','dashboard','normal');    //Incoming Links
	remove_meta_box('dashboard_plugins','dashboard','normal');           //Plugins
	remove_meta_box('dashboard_right_now','dashboard', 'normal');        //Right Now
	remove_meta_box('rg_forms_dashboard','dashboard','normal');          //Gravity Forms
	remove_meta_box('dashboard_recent_comments','dashboard','normal');   //Recent Comments
	remove_meta_box('icl_dashboard_widget','dashboard','normal');        //Multi Language Plugin
	remove_meta_box('dashboard_activity','dashboard', 'normal');         //Activity
	remove_action('welcome_panel','wp_welcome_panel');

}

add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

/*
* Remove Menu Items
*/
add_action( 'admin_init', 'remove_menu_pages' );
function remove_menu_pages() {
	//remove_menu_page( 'index.php' );                //Dashboard
	//remove_menu_page( 'jetpack' );                  //Jetpack*
	remove_menu_page( 'edit.php' );                   //Posts
	remove_menu_page( 'upload.php' );                 //Media
	// remove_menu_page( 'edit.php?post_type=page' );    //Pages
	remove_menu_page( 'edit-comments.php' );          //Comments
	// remove_menu_page( 'themes.php' );                 //Appearance
	// remove_menu_page( 'plugins.php' );             //Plugins
	// remove_menu_page( 'users.php' );               //Users
	// remove_menu_page( 'tools.php' );               //Tools
	// remove_menu_page( 'options-general.php' );     //Settings
}

/*
* Add Reviewr Role
*/

$result = add_role(
	'reviewer',
	__( 'Reviewer' ),
	array(
		'read'         => true,  // true allows this capability
		'edit_posts'   => true,
		'delete_posts' => false, // Use false to explicitly deny
	)
);

/*
* Custom Post Types
*/
function phln_custom_posttypes() {
	$labels = array(
		'name'               => _x('Learning Resources', 'post type general name', 'phln-learning-resources' ),
		'singular_name'      => _x('Learning Resource', 'post type singular name', 'phln-learning-resources' ),
		'menu_name'          => _x('Learning Resources', 'admin menu', 'phln-learning-resources' ),
		'name_admin_bar'     => _x('Learning Resource', 'add new on admin bar', 'phln-learning-resources' ),
		'add_new'            => _x('Add New Learning Resource', 'learning resource', 'phln-learning-resources' ),
		'add_new_item'       => __('Add New Learning Resource', 'phln-learning-resources' ),
		'new_item'           => __('New Learning Resource', 'phln-learning-resources' ),
		'edit_item'          => __('Edit Learning Resource', 'phln-learning-resources' ),
		'view_item'          => __('View Learning Resource', 'phln-learning-resources' ),
		'all_items'          => __('All Learning Resources', 'phln-learning-resources' ),
		'search_items'       => __('Search Learning Resources', 'phln-learning-resources' ),
		'parent_item_colon'  => __('Parent Learning Resources:', 'phln-learning-resources' ),
		'not_found'          => __('No learning resource found', 'phln-learning-resources' ),
		'not_found_in_trash' => __('No learning resource found in Trash', 'phln-learning-resources'
		),
	);

	$args = array(
		'labels'            => $labels,
		'has_archive'       => true,
		'public'            => true,
		'publicly_querable' => true,
		'show_ui'           => true,
		'show_in_menu'      => true,
		'rewrite'           => array('slug' => 'resources'),
		'capability_type'   => 'post',
		'has_archive'       => true,
		'hierarchical'      => true,
		'menu_icon'         => 'dashicons-universal-access-alt',
		'supports'          => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'custom-fields'),
		'menu_position'     => 5,
		//'taxonomies'        => array('post_tag')
	);
	register_post_type('learning_resources', $args);
}
add_action('init', 'phln_custom_posttypes');



/*
* Custom Taxonomies
*/
function phln_custom_taxonomies() {
	// Teaching Modality Category (hierarchical)
	$labels = array(
		'name'              => _x('Teaching Modalities', 'taxonomy general name'),
		'singular_name'     => __('Teaching Modality', 'taxonomy singular name'),
		'search_items'      => __('Search Teaching Modalities'),
		'all_items'         => __('All Teaching Modalities'),
		'parent_item'       => __('Parent Teaching Modality'),
		'parent_item_colon' => __('Parent Teaching Modality:'),
		'edit_item'         => __('Edit Teaching Modality'),
		'update_item'       => __('Update Teaching Modality'),
		'add_new_item'      => __('Add New Teaching Modality'),
		'new_item_name'     => __('New Teaching Modality'),
		'menu_name'         => __('Teaching Modalities')
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array('slug' => 'type')
	);

	register_taxonomy('teaching_modality', array('learning_resources'), $args);

	// Intended Geographic Area Category (hierarchical)
	$labels = array(
		'name'              => _x('Intended Geographic Areas', 'taxonomy general name'),
		'singular_name'     => __('Intended Geographic Area', 'taxonomy singular name'),
		'search_items'      => __('Search Intended Geographic Areas'),
		'all_items'         => __('All Intended Geographic Areas'),
		'parent_item'       => __('Parent Intended Geographic Area'),
		'parent_item_colon' => __('Parent Intended Geographic Area:'),
		'edit_item'         => __('Edit Intended Geographic Area'),
		'update_item'       => __('Update Intended Geographic Area'),
		'add_new_item'      => __('Add New Intended Geographic Area'),
		'new_item_name'     => __('New Intended Geographic Area'),
		'menu_name'         => __('Intended Geographic Areas')
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array('slug' => 'geographic-area')
	);

	register_taxonomy('intended_geographic_area', array('learning_resources'), $args);

	// Level Category (hierarchical)
	$labels = array(
		'name'                        => _x('Levels', 'taxonomy general name'),
		'singular_name'               => __('Level', 'taxonomy singular name'),
		'search_items'                => __('Search Levels'),
		'popular_items'               => __('Popular Levels'),
		'all_items'                   => __('All Levels'),
		'parent_item'                 => __('Parent Level'),
		'parent_item_colon'           => __('Parent Level:'),
		'edit_item'                   => __('Edit Level'),
		'update_item'                 => __('Update Level'),
		'add_new_item'                => __('Add New Level'),
		'new_item_name'               => __('New Level Name'),
		'menu_name'                   => __('Levels')
	);

	$args = array(
		'labels'                => $labels,
		'hierarchical'          => true,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'query_var'             => true,
		'rewrite'               => array('slug' => 'levels')
	);

	register_taxonomy('level', array('learning_resources'), $args);

	// CEU's Offered Category (hierarchical)
	$labels = array(
		'name'                        => _x('Continuing Education Units', 'taxonomy general name'),
		'singular_name'               => __('Continuing Education Unit', 'taxonomy singular name'),
		'search_items'                => __('Search Continuing Education Units'),
		'popular_items'               => __('Popular Continuing Education Units'),
		'all_items'                   => __('All Continuing Education Units'),
		'parent_item'                 => __('Parent Continuing Education Unit'),
		'parent_item_colon'           => __('Parent Continuing Education Unit:'),
		'edit_item'                   => __('Edit Continuing Education Unit'),
		'update_item'                 => __('Update Continuing Education Unit'),
		'add_new_item'                => __('Add New Continuing Education Unit'),
		'new_item_name'               => __('New Continuing Education Unit Name'),
		'menu_name'                   => __('Continuing Education Units')
	);

	$args = array(
		'labels'                => $labels,
		'hierarchical'          => true,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'query_var'             => true,
		'rewrite'               => array('slug' => 'cont_ed_units')
	);

	register_taxonomy('cont_ed_unit', array('learning_resources'), $args);

	// Subject Area Tag (non-hierarchical)
	$labels = array(
		'name'                        => _x('Subject Areas', 'taxonomy general name'),
		'singular_name'               => __('Subject Area', 'taxonomy singular name'),
		'search_items'                => __('Search Subject Areas'),
		'popular_items'               => __('Popular Subject Areas'),
		'all_items'                   => __('All Subject Areas'),
		'parent_item'                 => null,
		'parent_item_colon'           => null,
		'edit_item'                   => __('Edit Subject Area'),
		'update_item'                 => __('Update Subject Area'),
		'add_new_item'                => __('Add New Subject Area'),
		'new_item_name'               => __('New Subject Area Name'),
		'separate_items_with_commas'  => __('Separate Subject Areas with commas'),
		'Add_or_remove_items'         => __('Add or remove topics'),
		'choose_from_most_used'       => __('Choose from the most used topics'),
		'not_found'                   => __('No topics found.'),
		'new_item_name'               => __('New Subject Area'),
		'menu_name'                   => __('Subject Areas')
	);

	$args = array(
		'labels'                => $labels,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array('slug' => 'subject_areas')
	);

	register_taxonomy('subject_area', array('learning_resources'), $args);
}
add_action('init', 'phln_custom_taxonomies');
