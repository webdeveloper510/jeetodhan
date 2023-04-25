<?php
/**
 *
 * @package     WBC_Activator
 * @version     1.0.1
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
require(str_replace("wbc_lic","",dirname(__FILE__)).'mt-activator.php');

// Don't duplicate me!
if ( !class_exists( 'ReduxFramework_wbc_lic' ) ) {

    /**
     * Main ReduxFramework_wbc_lic class
     *
     * @since       1.0.0
     */
    class ReduxFramework_wbc_lic {

        /**
         * Field Constructor.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='', $parent ) {
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;
            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
            }    
            // Set default args for this field to avoid bad indexes. Change this to anything you use.
            $defaults = array(
                'options'           => array(),
                'stylesheet'        => '',
                'output'            => true,
                'enqueue'           => true,
                'enqueue_frontend'  => true
            );
            $this->field = wp_parse_args( $this->field, $defaults );        
        }

        /**
         * Field Render Function.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render() {
            echo '</fieldset></td></tr><tr><td colspan="2"><fieldset class="redux-field">';
            return mta_license_manager_render_plugin_settings_page(ReduxFramework_extension_mt_activator::$productID);
        }

        /**
         * Enqueue Function.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue() {

        }
    }
}
