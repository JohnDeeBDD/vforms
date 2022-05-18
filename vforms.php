<?php
/*
Plugin Name: VForms
Plugin URI: https://generalchicken.guru/vforms
Description: A custom form application
Version: 2.0
Author: johndee, victorp
*/



//die("vforms");

require_once (plugin_dir_path(__FILE__). 'src/VForms/autoloader.php');
require_once (plugin_dir_path(__FILE__). 'src/VForms/vformsCPT.php');

add_shortcode('vform', [new \VForms\ShortcodeFeature(), 'renderShortcode']);

add_action('manage_vform_posts_custom_column', [new \VForms\ColumnsFeature(), 'custom_vform_column'], 10, 2);
add_filter('manage_vform_posts_columns',  [new \VForms\ColumnsFeature(), 'set_custom_edit_vform_columns']);

if(isset($_POST['vform-rec-id'])){
    $Listener = new \VForms\Listener();
    add_action('init', [$Listener, 'doCaptureSubmission']);
}

function VForms_forceJqueryOnEveryPageLoad() {
    wp_enqueue_script( 'jquery' );
}
//We want jQuery to ALWAYS be available:
add_action( 'wp_enqueue_scripts', 'VForms_forceJqueryOnEveryPageLoad');

$parts = parse_url($_SERVER['REQUEST_URI']);
if (
    //These actions / filters fire on the vdata edit.php page
    (isset($parts['path'])) &&
    (isset($parts['query'])) &&
    ($parts['path'] == "/wp-admin/edit.php") &&
    ($parts['query'] == "post_type=vdata")
){
    add_action('admin_footer', [new \VForms\ColumnsFeature(), 'renderJQueryForEditScreen']);
    add_filter('post_row_actions', [new \VForms\ColumnsFeature(), 'doRemoveQuickEditLink'], 10, 2 );
    add_filter( 'get_edit_post_link', [new \VForms\ColumnsFeature(), 'doModifyVDataEditPostLinks'], 10, 2 );
}

if (
    //These actions / filters fire on the vform edit.php page
    (isset($parts['path'])) &&
    (isset($parts['query'])) &&
    ($parts['path'] == "/wp-admin/edit.php") &&
    ($parts['query'] == "post_type=vform")
){
    add_filter('post_row_actions', [new \VForms\ColumnsFeature(), 'doRemoveQuickEditLink'], 10, 2 );
    //die("hello");

}

function vFormActivation(){
    $L = new \VForms\Listener();
    $L->mother();
}
register_activation_hook( __FILE__, 'vFormActivation' );

//This enqueues VEditor.js when a VForm is looked at in the admin area on post.php or post-new.php
global $pagenow;
if( ($pagenow == "post-new.php") and (isset($_GET['post_type']))){
    if($_GET['post_type'] == "vform"){
        add_action( 'admin_enqueue_scripts', [new \VForms\VEditor(), "doEnqueueAdminScript"]);
    }
}
if( ($pagenow == "post.php") and (isset($_GET['action'])) and (isset($_GET['post']))){
    if($_GET['action'] == "edit"){
        if(\get_post_type($_GET['post']) == "vform"){
            add_action( 'admin_enqueue_scripts', [new \VForms\VEditor(), "doEnqueueAdminScript"]);
        }
    }
}


require_once (plugin_dir_path(__FILE__). 'src/plugin-update-checker-4.11/plugin-update-checker.php');
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://generalchicken.guru/wp-content/uploads/vforms-details.json',
    __FILE__, //Full path to the main plugin file or functions.php.
    'vforms'
);

