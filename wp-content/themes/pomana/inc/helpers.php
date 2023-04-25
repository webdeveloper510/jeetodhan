<?php 
defined( 'ABSPATH' ) || exit;

/*
 * Return fallback plugin version by slug
 * @param string plugin_slug
 * @return string plugin version by slug
 */
function pomana_fallback_plugin_version($plugin_slug = ''){
	$plugins = array(
	    "modeltheme-framework-pomana" => "1.4",
	    "js_composer" => "6.10.0",
    	"parallax-backgrounds-for-vc" => "4.5",
    	"woocommerce-lottery" => "2.1.10",
    	"woocommerce-lottery-progress-bar-in-loop" => "1.0",
	    "revslider" => "6.6.11",
	    "modeltheme-addons-for-wpbakery" => "1.5.1"
	);

	return $plugins[$plugin_slug];
}


/*
 * Return plugin version by slug from remote json
 * @param string plugin_slug
 * @return string plugin version by slug
 */
function pomana_plugin_version($plugin_slug = ''){

    $request = wp_remote_get('https://modeltheme.com/json/plugin_versions.json');
    $plugin_versions = json_decode(wp_remote_retrieve_body($request), true);

	if( is_wp_error( $request ) ) {
		return pomana_fallback_plugin_version($plugin_slug);
	}else{
    	return $plugin_versions[0][$plugin_slug];
	}

}