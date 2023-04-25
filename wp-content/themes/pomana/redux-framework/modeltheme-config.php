<?php
/**
  ReduxFramework Modeltheme Theme Config File
  For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
 * */


if (!class_exists("Redux_Framework_pomana_config")) {

    class Redux_Framework_pomana_config {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }
            
            // This is needed. Bah WordPress bugs.  ;)
            if ( get_template_directory() && strpos( Redux_Helpers::cleanFilePath(__FILE__), Redux_Helpers::cleanFilePath( get_template_directory() ) ) !== false) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);    
            }
        }

        public function initSettings() {

            if ( !class_exists("ReduxFramework" ) ) {
                return;
            }       
            
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

 
        public function setSections() {

            include_once(get_template_directory() . '/redux-framework/modeltheme-config.arrays.php');
            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $pomana_patterns_path = ReduxFramework::$_dir . '../polygon/patterns/';
            $pomana_patterns_url = ReduxFramework::$_url . '../polygon/patterns/';
            $pomana_patterns = array();

            if (is_dir($pomana_patterns_path)) :

                if ($pomana_patterns_dir = opendir($pomana_patterns_path)) :
                    $pomana_patterns = array();

                    while (( $pomana_patterns_file = readdir($pomana_patterns_dir) ) !== false) {

                        if (stristr($pomana_patterns_file, '.png') !== false || stristr($pomana_patterns_file, '.jpg') !== false) {
                            $name = explode(".", $pomana_patterns_file);
                            $name = str_replace('.' . end($name), '', $pomana_patterns_file);
                            $pomana_patterns[] = array('alt' => $name, 'img' => $pomana_patterns_url . $pomana_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct = wp_get_theme();
            $this->theme = $ct;
            $item_name = $this->theme->get('Name');
            $tags = $this->theme->Tags;
            $screenshot = $this->theme->get_screenshot();
            $class = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'pomana'), $this->theme->display('Name'));
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo esc_url(wp_customize_url()); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php the_title_attribute('echo=0'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview','pomana'); ?>" />
            <?php endif; ?>

                <h4>
            <?php echo  esc_attr($this->theme->display('Name')); ?>
                </h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'pomana'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'pomana'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . esc_html__('Tags', 'pomana') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo  esc_attr($this->theme->display('Description')); ?></p>
                <?php
                if ($this->theme->parent()) {
                    printf(' <p class="howto">' .__('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'pomana') . '</p>', esc_url('http://codex.WordPress.org/Child_Themes'), $this->theme->parent()->display('Name'));
                }
                ?>

                </div>

            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $pmHTML = '';
            if (file_exists(get_template_directory() . '/redux-framework/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global  $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH.'wp-admin/includes/file.php' );
                    WP_Filesystem();
                }
                $pmHTML = $wp_filesystem->get_contents(get_template_directory() . '/redux-framework/info-html.html');
            }


            /**
            ||-> SECTION: General Settings
            */

            $this->sections[] = array(
                'icon' => 'el-icon-wrench',
                'title' => esc_html__('General Settings', 'pomana'),
                'fields' => array(
                    array(
                        'id'   => 'mt_general_breadcrumbs',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '1.1 - Breadcrumbs', 'pomana' )
                    ),
                    array(
                        'id'       => 'modeltheme-enable-breadcrumbs',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Breadcrumbs', 'pomana'),
                        'subtitle' => esc_html__('Enable or disable breadcrumbs', 'pomana'),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'breadcrumbs-delimitator',
                        'type'     => 'text',
                        'title'    => esc_html__('Breadcrumbs delimitator', 'pomana'),
                        'subtitle' => esc_html__('This is a little space under the Field Title in the Options table, additional info is good in here.', 'pomana'),
                        'desc'     => esc_html__('This is the description field, again good for additional info.', 'pomana'),
                        'default'  => '/',
                        'required' => array( 'modeltheme-enable-breadcrumbs', '=', '1' ),
                    ),
                    array(
                        'id' => 'pomana_header_breadcrumbs_image',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Header Breadcrumbs Area Image', 'pomana'),
                        'compiler' => 'true',
                        'default' => array('url' => ''),
                        'required' => array( 'modeltheme-enable-breadcrumbs', '=', '1' ),
                    ),
                    array(
                        'id'       => 'pomana_border_radius',
                        'type'     => 'select', 
                        'title'    => __('Select Border Radius', 'pomana'),
                        'options'   => array(
                            'default'   => 'Rounded',
                            'round'     => 'Round',
                            'boxed'     => 'Rectangular'
                        ),
                        'default'   => 'default',
                        'required' => array( 'modeltheme-enable-breadcrumbs', '=', '1' ),
                    ),
                )
            );


            /**
            ||-> SECTION: Sidebars
            */
            $this->sections[] = array(
                'icon' => 'el-icon-stop',
                'title' => esc_html__('Sidebars', 'pomana'),
                'fields' => array(
                    array(
                        'id'   => 'mt_sidebars_generator',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '2.1 - Generate Unlimited Sidebars', 'pomana' )
                    ),
                    array(
                        'id'       => 'dynamic_sidebars',
                        'type'     => 'multi_text',
                        'title'    => esc_html__( 'Sidebars', 'pomana' ),
                        'subtitle' => esc_html__( 'Use the "Add More" button to create unlimited sidebars.', 'pomana' ),
                        'desc'     => esc_html__( '', 'pomana' ),
                        'add_text' => esc_html__( 'Add one more Sidebar', 'pomana' )
                    )
                )
            );


            /**
            ||-> SECTION: Back to Top
            */
            $this->sections[] = array(
                'icon'       => 'el el-circle-arrow-up',
                'title'      => esc_html__( 'Back to Top Button', 'pomana' ),
                'fields'     => array(
                    array(
                        'id'   => 'mt_back_to_top',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '3.1 - Back to Top Settings', 'pomana' )
                    ),
                    array(
                        'id'       => 'mt_backtotop_status',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Back to Top Button Status', 'pomana'),
                        'subtitle' => esc_html__('Enable or disable "Back to Top Button"', 'pomana'),
                        'default'  => true,
                    ),
                    array(         
                        'id'       => 'mt_backtotop_bg_color',
                        'type'     => 'background',
                        'title'    => esc_html__('Back to Top Button Status Backgrond', 'pomana'), 
                        'subtitle' => esc_html__('Default: #ec6623', 'pomana'),
                        'default'  => array(
                            'background-color' => '#ec6623',
                            'background-repeat' => 'no-repeat',
                            'background-position' => 'center center',
                            'background-image' => get_template_directory_uri().'/images/mt-to-top-arrow.svg',
                        ),
                        'required' => array( 'mt_backtotop_status', '=', '1' ),
                    ),
                ),
            );


            /**
            ||-> SECTION: Styling Settings
            */
            $this->sections[] = array(
                'icon'       => 'el-icon-magic',
                'title'      => esc_html__( 'Styling Settings', 'pomana' ),
                'fields'     => array(
                    array(
                        'id'   => 'mt_styling_colors',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '4.1 - Select Background and Colors', 'pomana' )
                    ),
                    array(
                        'id'       => 'mt_global_link_styling',
                        'type'     => 'link_color',
                        'title'    => esc_html__('Links Color Option', 'pomana'),
                        'subtitle' => esc_html__('Only color validation can be done on this field type(Default Regular: #000000; Default Hover: #000000; Default Active: #000000;)', 'pomana'),
                        'default'  => array(
                            'regular'  => '#000000', // blue
                            'hover'    => '#000000', // blue-x3
                            'active'   => '#000000',  // blue-x3
                            'visited'  => '#000000',  // blue-x3
                        )
                    ),
                    array(
                        'id'       => 'mt_style_main_texts_color',
                        'type'     => 'color',  
                        'title'    => esc_html__('Main texts color', 'pomana'), 
                        'subtitle' => esc_html__('Default: #000000', 'pomana'),
                        'default'  => '#000000',
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'mt_style_main_backgrounds_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Main backgrounds color', 'pomana'), 
                        'subtitle' => esc_html__('Default: #EC6623', 'pomana'),
                        'default'  => '#EC6623',
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'mt_style_main_backgrounds_color_hover',
                        'type'     => 'color',
                        'title'    => esc_html__('Main backgrounds color (hover)', 'pomana'), 
                        'subtitle' => esc_html__('Default: #000000', 'pomana'),
                        'default'  => '#000000',
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'mt_style_semi_opacity_backgrounds',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__( 'Semitransparent blocks background', 'pomana' ),
                        'subtitle' => esc_html__( 'Default: rgba(236, 102, 35, 0.33)', 'pomana' ),
                        'default'  => array(
                            'color' => '#EC6623',
                            'alpha' => '0.7'
                        ),
                        'mode'     => 'background'
                    ),
                ),
            );


            /**
            ||-> SECTION: Typography Settings
            */
            $this->sections[] = array(
                'icon' => 'el el-text-width',
                'title' => esc_html__('Typography Settings', 'pomana'),
                'fields' => array(
                    array(
                        'id'   => 'mt_typo_custom_fonts',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '5.1 - Import Google Fonts', 'pomana' )
                    ),
                    array(
                        'id'       => 'google-fonts-select',
                        'type'     => 'select',
                        'multi'    => true,
                        'title'    => esc_html__('Import Google Font Globally', 'pomana'), 
                        'subtitle' => esc_html__('Select one or multiple fonts', 'pomana'),
                        'desc'     => esc_html__('Importing fonts made easy', 'pomana'),
                        'options'  => $google_fonts_list,
                        'default'  => array(
                                        'Jost:regular,300,400,500,600,700,bold',
                                        'Poppins:300,regular,500,600,700,latin-ext,latin,devanagari',
                                      ),
                    ),
                    array(
                        'id'   => 'mt_typo_blog_post',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '5.3 - Choose Article Font/Style', 'pomana' )
                    ),
                    array(
                        'id'          => 'modeltheme-blog-post-typography',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Blog Post Font family', 'pomana'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => false,
                        'font-weight'  => true,
                        'font-size'   => false,
                        'font-style'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Poppins', 
                            'font-weight'  => '400',
                            'google'      => true,
                        ),
                    ),
                    array(
                        'id'   => 'mt_typo_headings',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '5.4 - Choose Headings Font/Style', 'pomana' )
                    ),
                    array(
                        'id'          => 'modeltheme-heading-h1',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H1 Font family', 'pomana'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => true,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-family'   => 'Jost', 
                            'font-size'     => '55px',
                            'line-height'   => '61px',  
                            'font-weight'   => '700',
                            'google'        => true
                        ),
                    ),
                    array(
                        'id'          => 'modeltheme-heading-h2',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H2 Font family', 'pomana'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => true,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-family'   => 'Jost', 
                            'font-size'     => '50px',
                            'line-height'   => '56px',  
                            'font-weight'   => '700',
                            'google'        => true
                        ),
                    ),
                    array(
                        'id'          => 'modeltheme-heading-h3',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H3 Font family', 'pomana'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => true,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Jost', 
                            'font-size' => '38px',
                            'line-height'   => '49px', 
                            'font-weight' => '700',
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'          => 'modeltheme-heading-h4',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H4 Font family', 'pomana'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => true,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Jost', 
                            'font-size' => '28px', 
                            'line-height'   => '34px', 
                            'font-weight' => '700',
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'          => 'modeltheme-heading-h5',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H5 Font family', 'pomana'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => true,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Jost', 
                            'font-size' => '25px',
                            'line-height'   => '31px',  
                            'font-weight' => '700',
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'          => 'modeltheme-heading-h6',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H6 Font family', 'pomana'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => true,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Jost', 
                            'font-size' => '20px',
                            'line-height'   => '26px',  
                            'font-weight' => '700',
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'   => 'mt_typo_inputs',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '5.5 - Choose Inputs Font/Style', 'pomana' )
                    ),
                    array(
                        'id'                => 'modeltheme-inputs-typography',
                        'type'              => 'typography', 
                        'title'             => esc_html__('Inputs Font family', 'pomana'),
                        'google'            => true, 
                        'font-backup'       => true,
                        'color'             => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'line-height'       => false,
                        'font-weight'       => true,
                        'font-size'         => false,
                        'font-style'        => false,
                        'subsets'           => false,
                        'units'             =>'px',
                        'subtitle'          => esc_html__('Font family for inputs and textareas', 'pomana'),
                        'default'           => array(
                            'font-family'       => 'Poppins', 
                            'google'            => true
                        ),
                    ),
                    array(
                        'id'   => 'mt_typo_buttons',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '5.6 - Choose Buttons Font/Style', 'pomana' )
                    ),
                    array(
                        'id'                => 'modeltheme-buttons-typography',
                        'type'              => 'typography', 
                        'title'             => esc_html__('Buttons Font family', 'pomana'),
                        'google'            => true, 
                        'font-backup'       => true,
                        'color'             => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'line-height'       => false,
                        'font-weight'       => true,
                        'font-size'         => false,
                        'font-style'        => false,
                        'subsets'           => false,
                        'units'             =>'px',
                        'subtitle'          => esc_html__('Font family for buttons', 'pomana'),
                        'default'           => array(
                            'font-family'       => 'Poppins',
                            'font-weight'       => '700', 
                            'google'            => true
                        ),
                    ),
                    array(
                        'id'   => 'mt_typo_buttons',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '5.7 - Choose Menu Font/Style', 'pomana' )
                    ),
                    array(
                        'id'                => 'modeltheme-navigation-typography',
                        'type'              => 'typography', 
                        'title'             => esc_html__('Menu Font family', 'pomana'),
                        'google'            => true, 
                        'font-backup'       => true,
                        'color'             => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'line-height'       => false,
                        'font-weight'       => true,
                        'font-size'         => false,
                        'font-style'        => false,
                        'subsets'           => false,
                        'units'             =>'px',
                        'subtitle'          => esc_html__('Font family for buttons', 'pomana'),
                        'default'           => array(
                            'font-family'       => 'Poppins',
                            'font-weight'       => '600', 
                            'google'            => true
                        ),
                    ),
                )
            );

            /**
            ||-> SECTION: Responsive Typography
            */
            $this->sections[] = array(
                'title'      => esc_html__( 'Responsive Typography', 'pomana' ),
                'id'         => 'mt_styling_typography_responsive',
                'fields'     => array(
                    array(
                        'id'   => 'mt_divider_responsive_h_tablets',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__('Headings Typography on Tablets (Medium Resolution Devices)', 'pomana')
                    ),
                    array(
                        'id'          => 'mt_heading_h1_tablets',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H1 Font size - Tablets', 'pomana'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'font-family'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '55px', 
                            'line-height' => '61px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h2_tablets',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H2 Font size - Tablets', 'pomana'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'font-family'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '50px', 
                            'line-height' => '56px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h3_tablets',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H3 Font size - Tablets', 'pomana'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'font-family'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '43px', 
                            'line-height' => '49px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h4_tablets',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H4 Font size - Tablets', 'pomana'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-family'  => false,
                        'font-style'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '28px', 
                            'line-height' => '36px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h5_tablets',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H5 Font size - Tablets', 'pomana'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'font-family'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '20px', 
                            'line-height' => '23px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h6_tablets',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H6 Font size - Tablets', 'pomana'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'font-family'  => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '18px', 
                            'line-height' => '21px', 
                        ),
                    ),
                    array(
                        'id'   => 'mt_divider_responsive_h_smartphones',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__('Headings Typography on SmartPhones (Small Resolution Devices)', 'pomana')
                    ),
                    array(
                        'id'          => 'mt_heading_h1_smartphones',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H1 Font size - Smartphones', 'pomana'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'font-family'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '55px', 
                            'line-height' => '61px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h2_smartphones',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H2 Font size - Smartphones', 'pomana'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'font-family'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '50px', 
                            'line-height' => '56px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h3_smartphones',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H3 Font size - Smartphones', 'pomana'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'font-family'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '43px', 
                            'line-height' => '49px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h4_smartphones',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H4 Font size - Smartphones', 'pomana'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-family'  => false,
                        'font-style'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '28px', 
                            'line-height' => '36px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h5_smartphones',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H5 Font size - Smartphones', 'pomana'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'font-family'  => false,
                        'subsets'     => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '16px', 
                            'line-height' => '19px', 
                        ),
                    ),
                    array(
                        'id'          => 'mt_heading_h6_smartphones',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H6 Font size - Smartphones', 'pomana'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'font-family'  => false,
                        'units'       =>'px',
                        'default'     => array(
                            'font-size' => '14px', 
                            'line-height' => '17px', 
                        ),
                    ),
                ),
            );



            /**
            ||-> SECTION: Page Preloader
            */
            $this->sections[] = array(
                'title' => esc_html__( 'Page Preloader Settings', 'pomana' ),
                'icon' => 'el el-dashboard',
                'fields' => array(
                    array(
                        'id'   => 'mt_preloader_status',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '6.1 - Preloader Status', 'pomana' )
                    ),
                    array(
                        'id'       => 'mt_preloader_status',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Enable Page Preloader', 'pomana'),
                        'subtitle' => esc_html__('Enable or disable page preloader', 'pomana'),
                        'default'  => false,
                    ),
                    array(
                        'id'   => 'mt_preloader_styling',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '6.2 - Preloader Styling', 'pomana' ),
                        'required' => array( 'mt_preloader_status', '=', '1' ),
                    ),
                    array(         
                        'id'       => 'mt_preloader_bg_color',
                        'type'     => 'background',
                        'required' => array( 'mt_preloader_status', '=', '1' ),
                        'title'    => esc_html__('Page Preloader Backgrond', 'pomana'), 
                        'subtitle' => esc_html__('Default: #0a0a0a', 'pomana'),
                        'default'  => array(
                            'background-color' => '#0a0a0a',
                        ),
                        'required' => array( 'mt_preloader_status', '=', '1' ),
                        'output' => array(
                            '.linify_preloader_holder'
                        )
                    ),
                    array(
                        'id'       => 'mt_preloader_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Preloader color:', 'pomana'), 
                        'subtitle' => esc_html__('Default: #ffffff', 'pomana'),
                        'default'  => '#ffffff',
                        'validate' => 'color',
                        'required' => array( 'mt_preloader_status', '=', '1' ),
                    ),
                ),
            );


            /**
            ||-> SECTION: Header Settings
            */
            $this->sections[] = array(
                'icon' => 'el-icon-arrow-up',
                'title' => esc_html__('Header Settings', 'pomana'),
                'fields' => array(
                    array(
                        'id'   => 'mt_header_layout',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '7.1 - Select Header layout', 'pomana' )
                    ),
                    array(
                        'id'       => 'header_layout',
                        'type'     => 'select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Select Header layout', 'pomana' ),
                        'options'   => array(
                            'first_header'   => 'Header #1'
                        ),
                        'default'  => 'first_header'
                    ),
                    array(
                        'id'   => 'mt_divider_second_header',
                        'type' => 'info',
                        'class' => 'ibid_divider',
                        'desc' => '<h3>'.esc_html__( 'Header Custom Settings', 'pomana' ).'</h3>',
                    ),
                
                    array(
                        'id' => 'pomana_header_booking',
                        'type' => 'text',
                        'title' => esc_html__('Header Button Link', 'pomana'),
                        'default' => 'https://pomana.modeltheme.com/shop'
                    ),
                    array(
                        'id'   => 'mt_divider_third_header',
                        'type' => 'info',
                        'class' => 'ibid_divider',
                        'desc' => '<h3>'.esc_html__( 'Header 3 Custom Settings', 'pomana' ).'</h3>',
                        'required' => array( 'header_layout', '=', 'third_header' ),
                    ),
                    array(
                        'id' => 'pomana_header_donation',
                        'type' => 'text',
                        'title' => esc_html__('Booking Button Link', 'pomana'),
                        'required' => array( 'header_layout', '=', 'third_header' ),
                        'default' => 'https://pomana.modeltheme.com/booking'
                    ),
                    array(
                        'id' => 'pomana_header_donation_txt',
                        'type' => 'text',
                        'title' => esc_html__('Header Button', 'pomana'),
                        'required' => array( 'header_layout', '=', 'third_header' ),
                        'default' => 'Donate'
                    ),
                    array(
                        'id'   => 'mt_header_main',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '7.3 - Header Main - Options', 'pomana' )
                    ),
                    array(
                        'id' => 'pomana_logo',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Logo', 'pomana'),
                        'compiler' => 'true',
                        'default' => array('url' => get_template_directory_uri().'/images/theme_logo.png'),
                    ),
                    array(
                        'id' => 'pomana_logo_sticky_header',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Logo (Sticky Header)', 'pomana'),
                        'compiler' => 'true',
                        'default' => array('url' => get_template_directory_uri().'/images/theme_logo_dark.png'),
                    ),
                    array(
                        'id'        => 'logo_max_width',
                        'type'      => 'slider',
                        'title'     => esc_html__('Logo Max Width', 'pomana'),
                        'subtitle'  => esc_html__('Use the slider to increase/decrease max size of the logo.', 'pomana'),
                        'desc'      => esc_html__('Min: 1px, max: 500px, step: 1px, default value: 140px', 'pomana'),
                        "default"   => 170,
                        "min"       => 1,
                        "step"      => 1,
                        "max"       => 500,
                        'display_value' => 'label'
                    ),
                    array(
                        'id' => 'pomana_favicon',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Favicon url', 'pomana'),
                        'compiler' => 'true',
                        'desc' => esc_html__('', 'pomana'),
                        'subtitle' => esc_html__('Use the upload button to import media.', 'pomana'),
                        'default' => array('url' => get_template_directory_uri().'/images/favicon.jpg'),
                    ),
                    array(         
                        'id'       => 'header_main_background',
                        'type'     => 'background',
                        'title'    => esc_html__('Header (main-header) - background', 'pomana'),
                        'subtitle' => esc_html__('Header background with image or color.', 'pomana'),
                        'output'      => array('.navbar-default,.sub-menu'),
                        'default'  => array(
                            'background-color' => 'transparent',
                        )
                    ),
                    array(
                        'id'       => 'header_nav_color',
                        'type'     => 'color',  
                        'title'    => esc_html__('Navigation texts color', 'pomana'), 
                        'subtitle' => esc_html__('Default: #ffffff', 'pomana'),
                        'default'  => '#ffffff',
                        'validate' => 'color',
                        'output'   => array('.is_header_semitransparent #navbar .menu-item > a')
                    ),
                    array(
                        'id'       => 'is_nav_sticky',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Fixed Navigation menu?', 'pomana'),
                        'subtitle' => esc_html__('Enable or disable "fixed positioned navigation menu".', 'pomana'),
                        'default'  => false,
                    ),
                    array(
                        'id'       => 'header_width',
                        'type'     => 'select', 
                        'title'    => __('Select Header Width', 'pomana'),
                        'options'   => array(
                            'container'   => 'Contain',
                            'fullwidth'   => 'Fullwidth'
                        ),
                        'default'   => 'container'
                    ),
                    array(
                        'id'   => 'mt_top_bar',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( 'Top Bar', 'pomana' )
                    ),
                    array(
                        'id'       => 'is_top_bar',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Enable Header Top Bar?', 'pomana'),
                        'subtitle' => esc_html__('Enable or disable Header Top Bar', 'pomana'),
                        'default'  => false,
                    ),
                )
            );


            /**
            ||-> SECTION: Footer Settings
            */
            $this->sections[] = array(
                'icon' => 'el-icon-arrow-down',
                'title' => esc_html__('Footer Settings', 'pomana'),
                'fields' => array(
                    array(
                        'id'   => 'mt_footer_rows_1',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '8.1 - Footer Widgets Row #1', 'pomana' )
                    ),
                    array(
                        'id'       => 'footer_row_1',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Footer Row #1 - Status', 'pomana' ),
                        'subtitle' => esc_html__( 'Enable/Disable Footer ROW 1', 'pomana' ),
                        'default'  => 0,
                        'on'       => esc_html__( 'Enabled', 'pomana' ),
                        'off'      => esc_html__( 'Disabled', 'pomana' ),
                    ),
                    array(
                        'id'       => 'footer_row_1_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Footer Row #1 - Layout', 'pomana' ),
                        'options'  => array(
                            '1' => array(
                                'alt' => 'Footer 1 Column',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_1.png'
                            ),
                            '2' => array(
                                'alt' => 'Footer 2 Columns',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_2.png'
                            ),
                            '3' => array(
                                'alt' => 'Footer 3 Columns',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_3.png'
                            ),
                            '4' => array(
                                'alt' => 'Footer 4 Columns',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_4.png'
                            ),
                            '5' => array(
                                'alt' => 'Footer 5 Columns',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_5.png'
                            ),
                            '6' => array(
                                'alt' => 'Footer 6 Columns',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_6.png'
                            ),
                            'column_half_sub_half' => array(
                                'alt' => 'Footer 6 + 3 + 3',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_half_sub_half.png'
                            ),
                            'column_sub_half_half' => array(
                                'alt' => 'Footer 3 + 3 + 6',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_sub_half_half.png'
                            ),
                            'column_sub_fourth_third' => array(
                                'alt' => 'Footer 2 + 2 + 2 + 2 + 4',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_sub_fourth_third.png'
                            ),
                            'column_third_sub_fourth' => array(
                                'alt' => 'Footer 4 + 2 + 2 + 2 + 2',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_third_sub_fourth.png'
                            ),
                            'column_sub_third_half' => array(
                                'alt' => 'Footer 2 + 2 + 2 + 6',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_sub_third_half.png'
                            ),
                            'column_half_sub_third' => array(
                                'alt' => 'Footer 6 + 2 + 2 + 2',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_sub_third_half2.png'
                            ),
                            'column_fourth_sub_half' => array(
                                'alt' =>'Footer 4 + 2 + 2 + 4',
                                'img' => get_template_directory_uri().'/redux-framework/assets/footer_columns/column_4_2_2_4.jpg'
                            ),
                        ),
                        'default'  => '1',
                        'required' => array( 'footer_row_1', '=', '1' ),
                    ),
                    array(
                        'id'             => 'footer_row_1_spacing',
                        'type'           => 'spacing',
                        'output'         => array('.footer-row-1'),
                        'mode'           => 'padding',
                        'units'          => array('em', 'px'),
                        'units_extended' => 'false',
                        'title'          => esc_html__('Footer Row #1 - Padding', 'pomana'),
                        'subtitle'       => esc_html__('Choose the spacing for the first row from footer.', 'pomana'),
                        'required' => array( 'footer_row_1', '=', '1' ),
                        'default'            => array(
                            'padding-top'     => '75px', 
                            'padding-bottom'  => '25px', 
                            'units'          => 'px', 
                        )
                    ),
                    array(
                        'id'             => 'footer_row_1margin',
                        'type'           => 'spacing',
                        'output'         => array('.footer-row-1'),
                        'mode'           => 'margin',
                        'units'          => array('em', 'px'),
                        'units_extended' => 'false',
                        'title'          => esc_html__('Footer Row #1 - Margin', 'pomana'),
                        'subtitle'       => esc_html__('Choose the margin for the first row from footer.', 'pomana'),
                        'required' => array( 'footer_row_1', '=', '1' ),
                        'default'            => array(
                            'margin-top'     => '0px', 
                            'margin-bottom'  => '0px', 
                            'units'          => 'px', 
                        )
                    ),
                    array( 
                        'id'       => 'footer_row_1border',
                        'type'     => 'border',
                        'title'    => esc_html__('Footer Row #1 - Borders', 'pomana'),
                        'subtitle' => esc_html__('Only color validation can be done on this field', 'pomana'),
                        'output'   => array('.footer-row-1'),
                        'all'      => false,
                        'required' => array( 'footer_row_1', '=', '1' ),
                        'default'  => array(
                            'border-color'  => '#515b5e', 
                            'border-style'  => 'solid', 
                            'border-top'    => '0', 
                            'border-right'  => '0', 
                            'border-bottom' => '0', 
                            'border-left'   => '0'
                        )
                    ),


                    array(
                        'id'   => 'mt_footer_copyright_text',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '8.4 - Footer Copyright Text - Options', 'pomana' )
                    ),
                    array(
                        'id'       => 'modeltheme-enable-copyright',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Footer Copyright', 'pomana'),
                        'subtitle' => esc_html__('Enable or disable footer copyright', 'pomana'),
                        'default'  => true,
                    ),
                    array(
                        'id' => 'pomana_footer_text_left',
                        'type' => 'editor',
                        'title' => esc_html__('Footer Text left', 'pomana'),
                        'required' => array('modeltheme-enable-copyright', 'equals', '1'),
                        'default' => 'Copyright Pomana',
                    ),
                    array(
                        'id' => 'pomana_footer_text_right',
                        'type' => 'editor',
                        'title' => esc_html__('Footer Text right', 'pomana'),
                        'required' => array('modeltheme-enable-copyright', 'equals', '1'),
                        'default' => '© Pomana Theme by <a href="https://modeltheme.com" target="_blank" rel="noopener">ModelTheme.com</a>. All rights Reserved.',
                    ),
                    array(
                        'id'   => 'mt_footer_styling',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '8.5 - Footer Styling', 'pomana' )
                    ),
                    array(
                        'id'        => 'footer-global-texts-color',
                        'type'      => 'color_rgba',
                        'title'     => 'Footer Global Text Color',
                        'subtitle'  => 'Set color and alpha channel',
                        'desc'      => 'Set color and alpha channel for footer texts (Especially for widget titles)',
                        'output'    => array('color' => 'footer h1.widget-title, footer h3.widget-title, footer .widget-title, footer .textwidget, p.copyright, footer .menu .menu-item a, footer .textwidget p, .footer-top .tagcloud > a'),
                        'default'   => array(
                            'color'     => '#ffffff',
                            'alpha'     => 1
                        ),
                        'options'       => array(
                            'show_input'                => true,
                            'show_initial'              => true,
                            'show_alpha'                => true,
                            'show_palette'              => true,
                            'show_palette_only'         => false,
                            'show_selection_palette'    => true,
                            'max_palette_size'          => 10,
                            'allow_empty'               => true,
                            'clickout_fires_change'     => false,
                            'choose_text'               => 'Choose',
                            'cancel_text'               => 'Cancel',
                            'show_buttons'              => true,
                            'use_extended_classes'      => true,
                            'palette'                   => null,
                            'input_text'                => 'Select Color'
                        ),                        
                    ),
                    array(         
                        'id'       => 'footer_top_background',
                        'type'     => 'background',
                        'title'    => esc_html__('Footer (top) - background', 'pomana'),
                        'subtitle' => esc_html__('Footer background with image or color.', 'pomana'),
                        'output'      => array('footer'),
                        'default'  => array(
                            'background-color' => '#000',
                        )
                    ),
                    array(         
                        'id'       => 'footer_bottom_background',
                        'type'     => 'background',
                        'title'    => esc_html__('Footer (bottom) - background', 'pomana'),
                        'subtitle' => esc_html__('Footer background with image or color.', 'pomana'),
                        'output'      => array('footer .footer'),
                        'default'  => array(
                            'background-color' => '#000',
                        )
                    )
                )
            );



            /**
            ||-> SECTION: Contact Settings
            */
            $this->sections[] = array(
                'icon' => 'el-icon-map-marker-alt',
                'title' => esc_html__('Contact Settings', 'pomana'),
                'fields' => array(
                    array(
                        'id'   => 'mt_contact',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '10.1 - Contact Settings', 'pomana' )
                    ),
                    array(
                        'id' => 'pomana_contact_phone',
                        'type' => 'text',
                        'title' => esc_html__('Phone Number', 'pomana'),
                        'subtitle' => esc_html__('Contact phone number displayed on the contact us page.', 'pomana'),
                        'validate_callback' => 'redux_validate_callback_function',
                        'default' => ' +04 77 333 454 221'
                    ),
                    array(
                        'id' => 'pomana_contact_email',
                        'type' => 'text',
                        'title' => esc_html__('Email', 'pomana'),
                        'subtitle' => esc_html__('Contact email displayed on the contact us page., additional info is good in here.', 'pomana'),
                        'validate' => 'email',
                        'msg' => 'custom error message',
                        'default' => 'pomana@example.com'
                    ),
                    array(
                        'id' => 'pomana_contact_address',
                        'type' => 'text',
                        'title' => esc_html__('Address', 'pomana'),
                        'subtitle' => esc_html__('Enter your contact address', 'pomana'),
                        'default' => '321 Education Street,  New York, NY, USA'
                    ),
                )
            );


            /**
            ||-> SECTION: Services Settings
            */
            $this->sections[] = array(
                'icon' => 'fa fa-briefcase',
                'title' => esc_html__('Services Settings', 'pomana'),
                'fields' => array(
                    array(
                        'id'   => 'mt_services',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '11.1 - Services Settings', 'pomana' )
                    ),
                    array(
                        'id'       => 'pomana_single_service_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Single Service Layout', 'pomana' ),
                        'subtitle' => esc_html__( 'Select Single Service Layout.', 'pomana' ),
                        'options'  => array(
                            'pomana_service_left_sidebar' => array(
                                'alt' => '2 Columns - Left sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-left.jpg'
                            ),
                            'pomana_service_fullwidth' => array(
                                'alt' => '1 Column - Full width',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-no.jpg'
                            ),
                            'pomana_service_right_sidebar' => array(
                                'alt' => '2 Columns - Right sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-right.jpg'
                            )
                        ),
                        'default'  => 'pomana_service_right_sidebar',
                    ),
                    array(
                        'id'       => 'pomana_single_service_sidebar',
                        'type'     => 'select',
                        'data'     => 'sidebars',
                        'title'    => esc_html__( 'Single Service Sidebar', 'pomana' ),
                        'subtitle' => esc_html__( 'Select Single Service Sidebar.', 'pomana' ),
                        'default'   => 'sidebar-1',
                        'required' => array('pomana_single_service_layout', '!=', 'pomana_service_fullwidth'),
                    ),

                )
            );


            /**
            ||-> SECTION: Blog Settings
            */
            $this->sections[] = array(
                'icon' => 'el-icon-comment',
                'title' => esc_html__('Blog Settings', 'pomana'),
                'fields' => array(
                    array(
                        'id'   => 'mt_blog_list',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '12.1 - Blog Archive Options', 'pomana' )
                    ),
                     array(
                            'id'       => 'pomana_blog_layout',
                            'type'     => 'image_select',
                            'compiler' => true,
                            'title'    => esc_html__( 'Blog List Layout', 'pomana' ),
                            'subtitle' => esc_html__( 'Select Blog List layout.', 'pomana' ),
                            'options'  => array(
                                'pomana_blog_left_sidebar' => array(
                                    'alt' => '2 Columns - Left sidebar',
                                    'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-left.jpg'
                                ),
                                'pomana_blog_fullwidth' => array(
                                    'alt' => '1 Column - Full width',
                                    'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-no.jpg'
                                ),
                                'pomana_blog_right_sidebar' => array(
                                    'alt' => '2 Columns - Right sidebar',
                                    'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-right.jpg'
                                )
                            ),
                            'default'  => 'pomana_blog_left_sidebar'
                        ),
                    array(
                        'id'       => 'pomana_blog_layout_sidebar',
                        'type'     => 'select',
                        'data'     => 'sidebars',
                        'title'    => esc_html__( 'Blog List Sidebar', 'pomana' ),
                        'subtitle' => esc_html__( 'Select Blog List Sidebar.', 'pomana' ),
                        'default'   => 'sidebar-1',
                        'required' => array('pomana_blog_layout', '!=', 'pomana_blog_fullwidth'),
                    ),
                    array(
                        'id'        => 'blog-display-type',
                        'type'      => 'select',
                        'title'     => esc_html__('How to display posts', 'pomana'),
                        'subtitle'  => esc_html__('Select how you want to display post on blog list.', 'pomana'),
                        'options'   => array(
                                'list'   => 'List',
                                'grid'   => 'Grid'
                            ),
                        'default'   => 'grid',
                        ),
                    array(
                        'id'        => 'blog-grid-columns',
                        'type'      => 'select',
                        'title'     => esc_html__('Grid columns', 'pomana'),
                        'subtitle'  => esc_html__('Select how many columns you want.', 'pomana'),
                        'options'   => array(
                                '1'   => '1',
                                '2'   => '2',
                                '3'   => '3',
                                '4'   => '4'
                            ),
                        'default'   => '1',
                        'required' => array('blog-display-type', 'equals', 'grid'),
                    ),
                    array(
                        'id'   => 'mt_blog_article',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '12.2 - Blog Article Options', 'pomana' )
                    ),
                    array(
                        'id'       => 'pomana_single_blog_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Single Blog Layout', 'pomana' ),
                        'subtitle' => esc_html__( 'Select Single Blog Layout.', 'pomana' ),
                        'options'  => array(
                            'pomana_blog_left_sidebar' => array(
                                'alt' => '2 Columns - Left sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-left.jpg'
                            ),
                            'pomana_blog_fullwidth' => array(
                                'alt' => '1 Column - Full width',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-no.jpg'
                            ),
                            'pomana_blog_right_sidebar' => array(
                                'alt' => '2 Columns - Right sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-right.jpg'
                            )
                        ),
                        'default'  => 'pomana_blog_left_sidebar',
                        ),
                    array(
                        'id'       => 'pomana_single_blog_sidebar',
                        'type'     => 'select',
                        'data'     => 'sidebars',
                        'title'    => esc_html__( 'Single Blog Sidebar', 'pomana' ),
                        'subtitle' => esc_html__( 'Select Single Blog Sidebar.', 'pomana' ),
                        'default'   => 'sidebar-1',
                        'required' => array('pomana_single_blog_layout', '!=', 'pomana_blog_fullwidth'),
                    ),
                    array(
                        'id'       => 'post_featured_image',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Enable/disable featured image for single post.', 'pomana'),
                        'subtitle' => esc_html__('Show or Hide the featured image from blog post page.".', 'pomana'),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'modeltheme-enable-related-posts',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Related Posts', 'pomana'),
                        'subtitle' => esc_html__('Enable or disable related posts', 'pomana'),
                        'default'  => false,
                    ),
                )
            );


            /**
            ||-> SECTION: Shop Settings
            */
            $this->sections[] = array(
                'icon' => 'el-icon-shopping-cart-sign',
                'title' => esc_html__('Shop Settings', 'pomana'),
                'fields' => array(
                    array(
                        'id'   => 'mt_shop',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '13.1 - Shop Archive Options', 'pomana' )
                    ),
                    array(
                        'id'       => 'pomana_shop_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Shop List Products Layout', 'pomana' ),
                        'subtitle' => esc_html__( 'Select Shop List Products layout.', 'pomana' ),
                        'options'  => array(
                            'pomana_shop_fullwidth' => array(
                                'alt' => '1 Column - Full width',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-no.jpg'
                            ),
                        ),
                        'default'  => 'pomana_shop_fullwidth'
                    ),
                    array(
                        'id'       => 'pomana_shop_layout_sidebar',
                        'type'     => 'select',
                        'data'     => 'sidebars',
                        'title'    => esc_html__( 'Shop List Sidebar', 'pomana' ),
                        'subtitle' => esc_html__( 'Select Shop List Sidebar.', 'pomana' ),
                        'default'   => 'sidebar-1',
                        'required' => array('pomana_shop_layout', '!=', 'pomana_shop_fullwidth'),
                    ),
                    array(
                        'id'        => 'modeltheme-shop-columns',
                        'type'      => 'select',
                        'title'     => esc_html__('Number of shop columns', 'pomana'),
                        'subtitle'  => esc_html__('Number of products per column to show on shop list template.', 'pomana'),
                        'options'   => array(
                            '2'   => '2 columns',
                            '3'   => '3 columns',
                            '4'   => '4 columns'
                        ),
                        'default'   => '3',
                    ),


                    array(
                        'id'   => 'mt_shop_single',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '13.2 - Shop Single Product Options', 'pomana' )
                    ),
                     array(
                        'id'       => 'pomana_single_product_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Single Product Layout', 'pomana' ),
                        'subtitle' => esc_html__( 'Select Single Product Layout.', 'pomana' ),
                        'options'  => array(
                            'pomana_shop_fullwidth' => array(
                                'alt' => '1 Column - Full width',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-no.jpg'
                            ),
                        ),
                        'default'  => 'pomana_shop_fullwidth'
                    ),
                    array(
                        'id'       => 'pomana_single_shop_sidebar',
                        'type'     => 'select',
                        'data'     => 'sidebars',
                        'title'    => esc_html__( 'Shop Single Product Sidebar', 'pomana' ),
                        'subtitle' => esc_html__( 'Select Single Product Sidebar.', 'pomana' ),
                        'default'   => 'sidebar-1',
                        'required' => array('pomana_single_product_layout', '!=', 'pomana_shop_fullwidth'),
                    ),
                    array(
                        'id'       => 'modeltheme-enable-related-products',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Related Products', 'pomana'),
                        'subtitle' => esc_html__('Enable or disable related products on single product', 'pomana'),
                        'default'  => true,
                    ),
                    array(
                        'id'        => 'modeltheme-related-products-number',
                        'type'      => 'select',
                        'title'     => esc_html__('Number of related products', 'pomana'),
                        'subtitle'  => esc_html__('Number of related products to show on single product template.', 'pomana'),
                        'options'   => array(
                            '2'   => '3',
                            '3'   => '6',
                            '4'   => '9'
                        ),
                        'default'   => '3',
                        'required' => array('modeltheme-enable-related-products', '=', true),
                    ),

                )
            );


            /**
            ||-> SECTION: Social Media Settings
            */
            $this->sections[] = array(
                'icon' => 'el-icon-myspace',
                'title' => esc_html__('Social Media Settings', 'pomana'),
                'fields' => array(
                    array(
                        'id'   => 'mt_social_media',
                        'type' => 'info',
                        'class' => 'mt_divider',
                        'desc' => esc_html__( '15.1 - Social Media Urls', 'pomana' )
                    ),
                    array(
                        'id' => 'pomana_social_fb',
                        'type' => 'text',
                        'title' => esc_html__('Facebook URL', 'pomana'),
                        'subtitle' => esc_html__('Type your Facebook url.', 'pomana'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'pomana_social_tw',
                        'type' => 'text',
                        'title' => esc_html__('Twitter username', 'pomana'),
                        'subtitle' => esc_html__('Type your Twitter username.', 'pomana'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'pomana_social_pinterest',
                        'type' => 'text',
                        'title' => esc_html__('Pinterest URL', 'pomana'),
                        'subtitle' => esc_html__('Type your Pinterest url.', 'pomana'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'pomana_social_skype',
                        'type' => 'text',
                        'title' => esc_html__('Skype Name', 'pomana'),
                        'subtitle' => esc_html__('Type your Skype username.', 'pomana'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'pomana_social_instagram',
                        'type' => 'text',
                        'title' => esc_html__('Instagram URL', 'pomana'),
                        'subtitle' => esc_html__('Type your Instagram url.', 'pomana'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'pomana_social_youtube',
                        'type' => 'text',
                        'title' => esc_html__('YouTube URL', 'pomana'),
                        'subtitle' => esc_html__('Type your YouTube url.', 'pomana'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'pomana_social_dribbble',
                        'type' => 'text',
                        'title' => esc_html__('Dribbble URL', 'pomana'),
                        'subtitle' => esc_html__('Type your Dribbble url.', 'pomana'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'pomana_social_linkedin',
                        'type' => 'text',
                        'title' => esc_html__('LinkedIn URL', 'pomana'),
                        'subtitle' => esc_html__('Type your LinkedIn url.', 'pomana'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'pomana_social_deviantart',
                        'type' => 'text',
                        'title' => esc_html__('Deviant Art URL', 'pomana'),
                        'subtitle' => esc_html__('Type your Deviant Art url.', 'pomana'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'pomana_social_digg',
                        'type' => 'text',
                        'title' => esc_html__('Digg URL', 'pomana'),
                        'subtitle' => esc_html__('Type your Digg url.', 'pomana'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'pomana_social_flickr',
                        'type' => 'text',
                        'title' => esc_html__('Flickr URL', 'pomana'),
                        'subtitle' => esc_html__('Type your Flickr url.', 'pomana'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'pomana_social_stumbleupon',
                        'type' => 'text',
                        'title' => esc_html__('Stumbleupon URL', 'pomana'),
                        'subtitle' => esc_html__('Type your Stumbleupon url.', 'pomana'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'pomana_social_tumblr',
                        'type' => 'text',
                        'title' => esc_html__('Tumblr URL', 'pomana'),
                        'subtitle' => esc_html__('Type your Tumblr url.', 'pomana'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'pomana_social_vimeo',
                        'type' => 'text',
                        'title' => esc_html__('Vimeo URL', 'pomana'),
                        'subtitle' => esc_html__('Type your Vimeo url.', 'pomana'),
                        'validate' => 'url',
                        'default' => ''
                    ),

                )
            );


            $theme_info = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri"><strong>' . esc_html__('Theme URL:', 'pomana') . '</strong> 
            <a href="' . esc_url($this->theme->get('ThemeURI')) . '" target="_blank">' .  esc_url($this->theme->get('ThemeURI')) . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author"><strong>' . esc_html__('Author:', 'pomana') . '</strong> ' . esc_attr($this->theme->get('Author')) . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version"><strong>' . esc_html__('Version:', 'pomana') . '</strong> ' . esc_attr($this->theme->get('Version')) . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . esc_attr($this->theme->get('Description')) . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags"><strong>' . esc_html__('Tags:', 'pomana') . '</strong> ' . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-1'
            );

            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-2'
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = '';
        }

        /**
          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
        */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'redux_demo', // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'), // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'), // Version that appears at the top of your panel
                'menu_type' => 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true, // Show the sections below the admin menu item or not
                'menu_title' => esc_html__('Theme Panel', 'pomana'),
                'page' => esc_html__('Theme Panel', 'pomana'),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '', // Must be defined to add google fonts to the typography module
                'admin_bar' => false, // Show the panel pages on the admin bar
                'global_variable' => 'pomana_redux', // Set a different name for your global variable other than the opt_name
                'dev_mode' => false, // Show the time the page took to load, etc
                'customizer' => true, // Enable basic customizer support
                // OPTIONAL -> Give you extra features
                'page_priority'        => 2,
                'page_parent' => 'themes.php', // For a full list of options, visit: http://codex.WordPress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_options', // Permissions needed to access the options panel.
                'menu_icon' => get_template_directory_uri().'/images/svg/theme-panel-menu-icon.svg', // Specify a custom URL to an icon
                'last_tab' => '', // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
                'page_slug' => '_options', // Page slug used to denote the panel
                'save_defaults' => true, // On load save the defaults to DB before user clicks save or not
                'default_show' => false, // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '', // What to print by the field's title if the value shown is default. Suggested: *
                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                'domain'              => 'pomana', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
                'database' => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'show_import_export' => true, // REMOVE
                'system_info' => false, // REMOVE
                'help_tabs' => array(),
                'help_sidebar' => '',       
                'show_options_object'       => false,
            );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace("-", "_", $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('', 'pomana'), $v);
            } else {
                $this->args['intro_text'] = '';
            }

            // Add content after the form.
            $this->args['footer_text'] = '';
        }

    }

    new Redux_Framework_pomana_config();
}