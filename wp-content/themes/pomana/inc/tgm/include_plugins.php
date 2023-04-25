<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme  for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

require_once get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'pomana_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function pomana_register_required_plugins() {
    /*
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        // LOCAL Plugins - PREMIUM
        array(
            'name'                  => esc_html__('WPBakery Page Builder', 'pomana'), // The plugin name
            'slug'                  => 'js_composer', // The plugin slug (typically the folder name)
            'source'                => esc_url('https://modeltheme.com/TFPLUGINS/js_composer.zip'), // The plugin source.
            'required'              => true, // If false, the plugin is only 'recommended' instead of required
            'version'               => pomana_plugin_version('js_composer'), // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'                  => esc_html__('ModelTheme Framework','pomana'), // The plugin name
            'slug'                  => 'modeltheme-framework', // The plugin slug (typically the folder name)
            'source'                => esc_url('https://modeltheme.com/TFPLUGINS/pomana/modeltheme-framework.zip'), // The plugin source.
            'required'              => true, // If false, the plugin is only 'recommended' instead of required
            'version'               => pomana_plugin_version('modeltheme-framework-pomana'), // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'                  => esc_html__('Revolution Slider', 'pomana'), // The plugin name
            'slug'                  => 'revslider', // The plugin slug (typically the folder name)
            'source'                => esc_url('http://modeltheme.com/TFPLUGINS/revslider.zip'), // The plugin source.
            'required'              => true, // If false, the plugin is only 'recommended' instead of required
            'version'               => pomana_plugin_version('revslider'), // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'                  => esc_html__('WooCommerce Lottery', 'pomana'), // The plugin name
            'slug'                  => 'woocommerce-lottery', // The plugin slug (typically the folder name)
            'source'                => esc_url('http://modeltheme.com/TFPLUGINS/pomana/woocommerce-lottery.zip'), // The plugin source.
            'required'              => true, // If false, the plugin is only 'recommended' instead of required
            'version'               => pomana_plugin_version('woocommerce-lottery'), // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'                  => esc_html__('WooCommere Lottery Progress Bar in Product Loop', 'pomana'), // The plugin name
            'slug'                  => 'woocommerce-lottery-progress-bar-in-loop', // The plugin slug (typically the folder name)
            'source'                => esc_url('http://modeltheme.com/TFPLUGINS/pomana/woocommerce-lottery-progress-bar-in-loop.zip'), // The plugin source.
            'required'              => true, // If false, the plugin is only 'recommended' instead of required
            'version'               => pomana_plugin_version('woocommerce-lottery-progress-bar-in-loop'), // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'                  => esc_html__('Parallax Backgrounds for VC', 'pomana'), // The plugin name
            'slug'                  => 'parallax-backgrounds-for-vc', // The plugin slug (typically the folder name)
            'source'                => esc_url('https://modeltheme.com/TFPLUGINS/parallax-backgrounds-for-vc.zip'), // The plugin source.
            'required'              => true, // If false, the plugin is only 'recommended' instead of required
            'version'               => pomana_plugin_version('parallax-backgrounds-for-vc'), // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'                  => esc_html__('ModelTheme Addons for WPBakery and Elementor', 'pomana'), // The plugin name
            'slug'                  => 'modeltheme-addons-for-wpbakery', // The plugin slug (typically the folder name)
            'source'                => esc_url('https://modeltheme.com/TFPLUGINS/modeltheme-addons-for-wpbakery.zip'), // The plugin source.
            'required'              => true, // If false, the plugin is only 'recommended' instead of required
            'version'               => pomana_plugin_version('modeltheme-addons-for-wpbakery'), // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
        ),
        // FROM WordPress Repository
        array(
            'name'                  => esc_html__('WooCommerce','pomana'), // The plugin name
            'slug'                  => 'woocommerce', // The plugin slug (typically the folder name)
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
        ),
        array(
            'name'                  => esc_html__('Redux Framework','pomana'), // The plugin name
            'slug'                  => 'redux-framework', // The plugin slug (typically the folder name)
            'required'              => true, // If false, the plugin is only 'recommended' instead of required
        ),
        array(
            'name'                  => esc_html__('Contact form 7','pomana'), // The plugin name
            'slug'                  => 'contact-form-7', // The plugin slug (typically the folder name)
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
        ),
        array(
            'name'                  => esc_html__('MailChimp for WordPress','pomana'), // The plugin name
            'slug'                  => 'mailchimp-for-wp', // The plugin slug (typically the folder name)
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
        ),
        array(
            'name'                  => esc_html__('YITH WooCommerce Quick View','pomana'), // The plugin name
            'slug'                  => 'yith-woocommerce-quick-view', // The plugin slug (typically the folder name)
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
        ),
        array(
            'name'                  => esc_html__('YITH WooCommerce Wishlist','pomana'), // The plugin name
            'slug'                  => 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name)
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
        ),
    );

    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     */
    $config = array(
        'id'           => 'pomana',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.

    );

    tgmpa( $plugins, $config );
}
