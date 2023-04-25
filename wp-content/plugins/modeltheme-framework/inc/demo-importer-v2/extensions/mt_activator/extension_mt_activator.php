<?php
/**
 * Extension-Boilerplate

 *
 * @package     WBC_Activator - Extension for Importing demo content
 * @version     1.0.3
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if ( !class_exists( 'ReduxFramework_extension_mt_activator' ) ) {
    class ReduxFramework_extension_mt_activator {
        public static $instance;
        static $version = "1.0.3";
        protected $parent;
        private $filesystem = array();
        //make it accessible everywhere
        public static $productID = 43111834;
        /**
         * Class Constructor
         *
         * @since       1.0
         * @access      public
         * @return      void
         */
        public function __construct( $parent ) {
            $this->parent = $parent;
            if ( !is_admin() ) return;
            //Hides importer section if anything but true returned. Way to abort :)

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
            }
            //Delete saved options of imported demos, for dev/testing purpose
            // delete_option('wbc_imported_demos');
            $this->field_name = 'wbc_lic';
            self::$instance = $this;
            add_filter( 'redux/' . $this->parent->args['opt_name'] . '/field/class/' . $this->field_name, array( &$this,
                    'overload_field_path'
                ) );

            add_filter( 'redux/' . $this->parent->args['opt_name'] . '/field/class/' . $this->field_name.'_importer', array( &$this,
                'overload_field_path_importer'
            ) );

            $this->add_section();

        }

        public static function get_instance() {
            return self::$instance;
        }

        // Forces the use of the embeded field path vs what the core typically would use
        public function overload_field_path( $field ) {
            return dirname( __FILE__ ) . '/' . $this->field_name . '/field_' . $this->field_name . '.php';
        }
        // Forces the use of the embeded field path vs what the core typically would use
        public function overload_field_path_importer( $field ) {
            return dirname( __FILE__ ) . '/' . $this->field_name . '/field_' . $this->field_name . '_importer.php';
        }
        function add_section() {
            // Checks to see if section was set in config of redux.
            for ( $n = 0; $n <= count( $this->parent->sections ); $n++ ) {
                if ( isset( $this->parent->sections[$n]['id'] ) && $this->parent->sections[$n]['id'] == 'wbc_lic_section' ) {
                    return;
                }
            }
            if(get_option("modelthemeAPIactivator") !== false) {
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, "http://api.modeltheme.com/activator/license-status.php");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                    "key" => get_option("modelthemeAPIactivator")[0],
                    "productId" => self::$productID,
                    "data" => [
                        "user" => [
                            ["value" => get_option("siteurl")],
                            ["value" => get_option("admin_email")]
                        ]
                    ]
                ], JSON_UNESCAPED_SLASHES));

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $server_output = curl_exec($ch);

                curl_close($ch);
                $state = json_decode($server_output, true);

                if ($state["success"] == false) {
                    $this->replace_importer();
                }
            } else {
                $this->replace_importer();
            }
            // prevent duplicates

            $key = array_search('wbc_activator_section', array_column($this->parent->sections, 'id'), true);
            if($key === false) {
                $wbc_importer_label = (!empty($wbc_importer_label)) ? $wbc_importer_label : __('License Manager', 'framework');
                $this->parent->sections[] = array(
                    'id' => 'wbc_activator_section',
                    'title' => $wbc_importer_label,
                    'icon' => 'el-icon-website',
                    'fields' => array(
                        array(
                            'id' => 'wbc_lic_manager',
                            'type' => 'wbc_lic'
                        )
                    )
                );
            }
        }

        public function replace_importer() {
            $key = array_search('wbc_importer_section', array_column($this->parent->sections, 'id'), true);

            $this->parent->sections[$key + 1] = array(
                'id' => 'wbc_importer_section',
                'title' => __('Demo Importer', 'framework'),
                'icon' => 'el-icon-website',
                'fields' => array(
                    array(
                        'id' => 'wbc_lic_importer',
                        'type' => 'wbc_lic_importer'
                    )
                )
            );
        }
    } // class
}
