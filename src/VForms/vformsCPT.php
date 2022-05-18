<?php

// Register Custom Post Type
function vforms() {

	$labels = array(
		'name'                  => _x( 'Forms', 'Post Type General Name', 'vforms' ),
		'singular_name'         => _x( 'Form', 'Post Type Singular Name', 'vforms' ),
		'menu_name'             => __( 'Forms', 'vforms' ),
		'name_admin_bar'        => __( 'Form', 'vforms' ),
		'archives'              => __( 'Form Archives', 'vforms' ),
		'attributes'            => __( 'Form Attributes', 'vforms' ),
		'parent_item_colon'     => __( 'Parent Form:', 'vforms' ),
		'all_items'             => __( 'All Forms', 'vforms' ),
		'add_new_item'          => __( 'Add New Form', 'vforms' ),
		'add_new'               => __( 'Add New', 'vforms' ),
		'new_item'              => __( 'New Form', 'vforms' ),
		'edit_item'             => __( 'Edit Form', 'vforms' ),
		'update_item'           => __( 'Update Form', 'vforms' ),
		'view_item'             => __( 'View Form', 'vforms' ),
		'view_items'            => __( 'View Forms', 'vforms' ),
		'search_items'          => __( 'Search Form', 'vforms' ),
		'not_found'             => __( 'Not found', 'vforms' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'vforms' ),
		'featured_image'        => __( 'Featured Image', 'vforms' ),
		'set_featured_image'    => __( 'Set featured image', 'vforms' ),
		'remove_featured_image' => __( 'Remove featured image', 'vforms' ),
		'use_featured_image'    => __( 'Use as featured image', 'vforms' ),
		'insert_into_item'      => __( 'Insert into form', 'vforms' ),
		'uploaded_to_this_item' => __( 'Uploaded to this form', 'vforms' ),
		'items_list'            => __( 'Forms list', 'vforms' ),
		'items_list_navigation' => __( 'Forms list navigation', 'vforms' ),
		'filter_items_list'     => __( 'Filter formss list', 'vforms' ),
	);
	$args = array(
		'label'                 => __( 'Form', 'vforms' ),
		'description'           => __( 'Custom Forms', 'vforms' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'revisions', 'custom-fields', 'author' ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-media-spreadsheet',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
	);
	register_post_type( 'vform', $args );

}
add_action( 'init', 'vforms', 0 );

// Register Custom Post Type
function vdata() {

    $labels = array(
        'name'                  => _x( 'Data', 'Post Type General Name', 'vdata' ),
        'singular_name'         => _x( 'Data', 'Post Type Singular Name', 'vdata' ),
        'menu_name'             => __( 'Data', 'vdata' ),
        'name_admin_bar'        => __( 'Data', 'vdata' ),
        'archives'              => __( 'Data Archives', 'vdata' ),
        'attributes'            => __( 'Data Attributes', 'vdata' ),
        'parent_item_colon'     => __( 'Parent Data:', 'vdata' ),
        'all_items'             => __( 'All Data', 'vdata' ),
        'add_new_item'          => __( 'Add New Data', 'vdata' ),
        'add_new'               => __( 'Add New', 'vdata' ),
        'new_item'              => __( 'New Data', 'vdata' ),
        'edit_item'             => __( 'Edit Data', 'vdata' ),
        'update_item'           => __( 'Update Data', 'vdata' ),
        'view_item'             => __( 'View Data', 'vdata' ),
        'view_items'            => __( 'View Data', 'vdata' ),
        'search_items'          => __( 'Search Data', 'vdata' ),
        'not_found'             => __( 'Not found', 'vdata' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'vdata' ),
        'featured_image'        => __( 'Featured Image', 'vdata' ),
        'set_featured_image'    => __( 'Set featured image', 'vdata' ),
        'remove_featured_image' => __( 'Remove featured image', 'vdata' ),
        'use_featured_image'    => __( 'Use as featured image', 'vdata' ),
        'insert_into_item'      => __( 'Insert into Data', 'vdata' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'vdata' ),
        'items_list'            => __( 'Data list', 'vdata' ),
        'items_list_navigation' => __( 'Data list navigation', 'vdata' ),
        'filter_items_list'     => __( 'Filter Data list', 'vdata' ),
    );
    $capabilities = array(
        'edit_post'             => 'edit_post',
        'read_post'             => 'publish_posts',
        'delete_post'           => 'delete_post',
        'edit_posts'            => 'edit_posts',
        'edit_others_posts'     => 'edit_others_posts',
        'publish_posts'         => 'publish_posts',
        'read_private_posts'    => 'read_private_posts',
    );
    $args = array(
        'label'                 => __( 'Data', 'vdata' ),
        'description'           => __( 'Form Data', 'vdata' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'revisions', 'custom-fields' , 'author' ),
        'taxonomies'            => array(),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-database',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => false,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'page',
        'show_in_rest'          => false,
       // 'capabilities'          => $capabilities,
    );

    register_post_type( 'vdata', $args );

}
add_action( 'init', 'vdata', 0 );


function wpse454363_posts_filter( $query ){
    global $pagenow;
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
   // if ( 'product' == $type && is_admin() && $pagenow=='edit.php') {
     //   $meta_query = array(); // Declare meta query to fill after
   //     if (isset($_GET['post_date']) && $_GET['post_date'] != '') {
            // first meta key/value
            $meta_query[] = array (
                'key'      => 'vform-post-id',
                'value'    => 5
            );
      //  }
      //  if (isset($_GET['order_status']) && $_GET['order_status'] != '') {
            // second meta key/value
            //$meta_query[] = array (
            //    'key'      => 'order_status',
            //    'value'    => $_GET['order_status']
          //  );
       // }
      //$query->query_vars['meta_query'] = $meta_query; // add meta queries to $query
}

add_filter( 'parse_query', 'wpse454363_posts_filter' );