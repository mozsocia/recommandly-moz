<?php
/*
Plugin Name: Test Plugin
Description: Simple Plugin shows the  form submission
Version: 1.0.0
Author: Jhon Doe
 */

//
// ========== some default defination ====================
define("MOZ_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
define("DATA_FORMAT", "Y-m-d");

if (!function_exists('moz_debug_fn')) {
    function moz_debug_fn($data)
    {

        // to theme directory
        // $file = get_stylesheet_directory() .'/coutom_log.txt';
        // to this plugin dir
        $file = plugin_dir_path(__FILE__) . '/custom_log.txt';
        file_put_contents($file, current_time('mysql') . " :: " . print_r($data, true) . "\n\n", FILE_APPEND);
    };
}
;

if (!function_exists('moz_plugin_log')) {
    // to use in production site
    function moz_plugin_log($entry, $mode = 'a', $file = 'moz_plugin_log')
    {
        // Get WordPress uploads directory.
        $upload_dir = wp_upload_dir();
        $upload_dir = $upload_dir['basedir'];
        // the entry to json_encode.
        $entry = json_encode($entry);
        // Write the log file.
        $file = $upload_dir . '/' . $file . '.log';
        $file = fopen($file, $mode);
        $bytes = fwrite($file, current_time('mysql') . "::" . print_r($entry, true) . "\n\n");
        fclose($file);
        return $bytes;
    }
}

//
// ======================= main code start ===========================

//
// ====== setting admin_menu =============
function moz_menus_development()
{
    add_menu_page("Moz Plugin", "Test Plugin", "manage_options", "wp-moz-plugin", "moz_wp_list_call");

    add_submenu_page("wp-moz-plugin", "Addd Some", "Add Some", "manage_options", "wp-moz-add", "moz_wp_add_call");
}

add_action("admin_menu", "moz_menus_development");

function moz_wp_list_call()
{
    include_once MOZ_PLUGIN_DIR_PATH . '/views/list-some.php';
}

function moz_wp_add_call()
{
    include_once MOZ_PLUGIN_DIR_PATH . '/views/add-some.php';
}

//
// ========== ajax call code must be in main plugin file

add_action('wp_ajax_my_ajax_form_action', 'my_ajax_form_handler');
add_action('wp_ajax_nopriv_my_ajax_form_action', 'my_ajax_form_handler');

function my_ajax_form_handler()
{

    // if (!isset($_POST['_moz_nonce']) || !wp_verify_nonce($_POST['_moz_nonce'], 'moz_nonce_secret')) {
    //     wp_send_json('invalid request ');
    //     return;
    // }

    // Verify the nonce
    check_ajax_referer('moz_nonce_secret', '_moz_nonce');

    // moz_debug_fn([$_POST]);

    /**
     * get cattegories and update option
     */

    // $args = array(
    //     // 'orderby' => 'name',
    //     'order' => 'DESC',
    // );
    // $categories = get_categories($args);
    // $json_cat = serialize($categories);

    // update_option("catagories_all", $json_cat);

    // moz_debug_fn($json_cat);

    // moz_debug_fn($categories);

    /**
     * get cattegories from option
     */

    $get_res = get_option("catagories_all");

    $res = unserialize($get_res);

    moz_debug_fn($res);

    /**
     * working with date
     */

    // $currentDate = date("Y-m-d");

    // moz_debug_fn($currentDate);

    // Do something with the data (e.g. save to database, send email, etc.)

    // Return a response
    wp_send_json(['msg' => 'nooo Form submitted successfully!']);
}
