<?php
class MTA_API
{
    private $namespace = "mt-activator";

    public function __construct()
    {
        add_action('rest_api_init', [$this, 'registerRoutes']);
    }

    public function registerRoutes()
    {
        register_rest_route($this->namespace, '/getSystemData', array(
            'methods' => 'GET',
            'callback' => [$this, 'getSystemConfig'],
            'permission_callback' => function ($request) {
                // This always returns false
                return current_user_can('administrator');
            },
        ));
        register_rest_route($this->namespace, '/plugins', array(
            'methods' => 'GET',
            'callback' => [$this, 'getPluginList'],
            'permission_callback' => function ($request) {
                // This always returns false
                return current_user_can('administrator');
            },
        ));
        register_rest_route($this->namespace, '/userContactData', array(
            'methods' => 'GET',
            'callback' => [$this, 'getUserContactData'],
            'permission_callback' => function ($request) {
                // This always returns false
                return current_user_can('administrator');
            },
        ));
        register_rest_route($this->namespace, '/themes', array(
            'methods' => 'GET',
            'callback' => [$this, 'getThemeList'],
            'permission_callback' => function ($request) {
                // This always returns false
                return current_user_can('administrator');
            },
        ));

        register_rest_route($this->namespace, '/save-api', array(
            'methods' => 'POST',
            'callback' => [$this, 'saveAPI'],
            'permission_callback' => function ($request) {
                // This always returns false
                return current_user_can('administrator');
            },
        ));

        register_rest_route($this->namespace, '/remove-api', array(
            'methods' => 'GET',
            'callback' => [$this, 'removeAPI'],
            'permission_callback' => function ($request) {
                // This always returns false
                return current_user_can('administrator');
            },
        ));
    }
    public function saveAPI($request) {
        $key = $request->get_param( 'code' );

        update_option('modelthemeAPIactivator', [$key]);

    }
    public function removeAPI() {
        update_option('modelthemeAPIactivator', [""]);
    }
    public function getUserContactData()
    {
        return [
            ["key" => "Site URL", "value" => get_option("siteurl")],
            ["key" => "Your Email", "value" => get_option("admin_email")],
        ];
    }

    public function getThemeList()
    {
        return wp_get_themes();
    }

    public function getPluginList()
    {
        $plugins = [];
        foreach (get_plugins() as $plugin => $pluginData) {
            $pluginC = [];

            $pluginC['name'] = $pluginData['Name'] === "" ? $pluginData['Title'] : $pluginData['Name'];
            $pluginC['version'] = $pluginData['Version'];
            $pluginC['author'] = $pluginData['Author'] === "" ? $pluginData['AuthorName'] : $pluginData['Author'];
            $pluginC['description'] = $pluginData['Description'];
            $pluginC['textDomain'] = $pluginData['TextDomain'];
            $pluginC['active'] = is_plugin_active($plugin);

            $plugins[] = $pluginC;
        }
        return $plugins;
    }

    public function getSystemConfig($data)
    {
        $settings = [
            array(
                'title' => esc_html__('PHP Memory Limit', 'alloggio-core'),
                'value' => size_format(wp_convert_hr_to_bytes(@ini_get('memory_limit'))),
                'required' => '128',
                'pass' => (wp_convert_hr_to_bytes(@ini_get('memory_limit')) >= 134217728) ? true : false,
                'notice' => esc_html__('The current value is insufficient to properly support the theme. Please adjust this value to 128 in order to meet the theme requirements. ', 'alloggio-core')
            ),
            array(
                'title' => esc_html__('PHP Version', 'alloggio-core'),
                'value' => phpversion(),
                'required' => '7.3',
                'pass' => version_compare(PHP_VERSION, '7.3.0') >= 0 ? true : false
            ),
            array(
                'title' => esc_html__('PHP Post Max Size', 'alloggio-core'),
                'value' => ini_get('post_max_size'),
                'required' => '256M',
                'pass' => (ini_get('post_max_size') >= 256) ? true : false,
                'notice' => esc_html__('The current value is insufficient to properly support the theme. Please adjust this value to 256 in order to meet the theme requirements. ', 'alloggio-core')
            ),
            array(
                'title' => esc_html__('PHP Time Limit', 'alloggio-core'),
                'value' => ini_get('max_execution_time'),
                'required' => '300',
                'pass' => (ini_get('max_execution_time') >= 300) ? true : false,
                'notice' => esc_html__('The current value is insufficient to properly support the theme. Please adjust this value to 300 in order to meet the theme requirements. ', 'alloggio-core')
            ),
            array(
                'title' => esc_html__('PHP Max Input Vars', 'alloggio-core'),
                'value' => ini_get('max_input_vars'),
                'required' => '5000',
                'pass' => (ini_get('max_input_vars') >= 5000) ? true : false,
                'notice' => esc_html__('The current value is insufficient to properly support the theme. Please adjust this value to 5000 in order to meet the theme requirements. ', 'alloggio-core')
            ),
            array(
                'title' => esc_html__('Max Upload Size', 'alloggio-core'),
                'value' => size_format(wp_max_upload_size()),
                'required' => '64 MB',
                'pass' => (wp_max_upload_size() >= 67108864) ? true : false,
                'notice' => esc_html__('The current value is insufficient to properly support the theme. Please adjust this value to 64 in order to meet the theme requirements. ', 'alloggio-core')
            ),
        ];

        return $settings;
    }
}
$api = new MTA_API();
