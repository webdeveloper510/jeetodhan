<?php
require 'Vite.php';
// // LOAD PLUGIN TEXTDOMAIN
// function mta_license_manager_load_textdomain() {
//     load_plugin_textdomain( 'mta_license_manager', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
// }

// add_action( 'plugins_loaded', 'mta_license_manager_load_textdomain' );

// // add parent category to site menu
// function mta_license_manager_add_settings_page() {
//     if ( !empty ( $GLOBALS['admin_page_hooks']['mt_plugins'] ) ) {
//         return;
//     }

//     add_menu_page(
//         esc_html__("MT Plugins", "mta_license_manager"), esc_html__("MT Plugins", "mta_license_manager"), "NULL", "mt_plugins", "sc_menu_page", "", 3611
//     );
// }

// add_action( 'admin_menu', 'mta_license_manager_add_settings_page' );

// // add child category to parent to site menu
// function mta_license_manager_add_submenu_pages() {
//     add_submenu_page(
//         "mt_plugins",
//         esc_html__("Licenses Manager", "mta_license_manager"),
//         esc_html__("Licenses Manager", "mta_license_manager"),
//         "manage_options",
//         "mt-activator",
//         "mta_license_manager_render_plugin_settings_page"
//     );
// }
// add_action( 'admin_menu', 'mta_license_manager_add_submenu_pages' );

// render form
function mta_license_manager_render_plugin_settings_page($tid) {
    ?>
    <div id="app"
         data-nonce="<?php echo wp_create_nonce( 'wp_rest' );?>"
         data-code="<?php echo get_option("modelthemeAPIactivator")[0]; ?>"
         data-install="<?php echo esc_url(get_site_url());?>"
         data-api-location="<?php echo esc_url(get_rest_url());?>"
         data-tid="<?php echo $tid;?>"
    >
        <noscript><?php echo esc_html__('You need javascript enabled to see this content', 'mta_license_manager'); ?>.</noscript>
        <?php echo esc_html__('Loading...', 'mta_license_manager'); ?>
    </div>
    <?php
    $vite = new Mta_Vite();
    echo $vite;

}
