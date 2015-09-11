<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'majale_redux_Framework_config' ) ) {

        class majale_redux_Framework_config {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                // This is needed. Bah WordPress bugs.  ;)
                if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                    $this->initSettings();
                } else {
                    add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
                }

            }

            public function initSettings() {

                // Just for demo purposes. Not needed per say.
                $this->theme = wp_get_theme();

                // Set the default arguments
                $this->setArguments();

                // Set a few help tabs so you can see how it's done
                $this->setHelpTabs();

                // Create the sections and fields
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                // If Redux is running as a plugin, this will remove the demo notice and links
                //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

                // Function to test the compiler hook and demo CSS output.
                // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
                //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);

                // Change the arguments after they've been declared, but before the panel is created
                //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );

                // Change the default value of a field after it's been set, but before it's been useds
                //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );

                // Dynamically add a section. Can be also used to modify sections/fields
                //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

            /**
             * This is a test function that will let you see when the compiler hook occurs.
             * It only runs if a field    set with compiler=>true is changed.
             * */
            function compiler_action( $options, $css, $changed_values ) {
                echo '<h1>The compiler hook has run!</h1>';
                echo "<pre>";
                print_r( $changed_values ); // Values that have changed since the last save
                echo "</pre>";
                //print_r($options); //Option values
                //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

                /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
            }

            /**
             * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
             * Simply include this function in the child themes functions.php file.
             * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
             * so you must use get_template_directory_uri() if you want to use any of the built in icons
             * */
            function dynamic_section( $sections ) {
                //$sections = array();
                $sections[] = array(
                    'title'  => __( 'Section via hook', 'majale' ),
                    'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'majale' ),
                    'icon'   => 'el-icon-paper-clip',
                    // Leave this as a blank section, no options just some intro text set above.
                    'fields' => array()
                );

                return $sections;
            }

            /**
             * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
             * */
            function change_arguments( $args ) {
                //$args['dev_mode'] = true;

                return $args;
            }

            /**
             * Filter hook for filtering the default value of any given field. Very useful in development mode.
             * */
            function change_defaults( $defaults ) {
                $defaults['str_replace'] = 'Testing filter hook!';

                return $defaults;
            }

            // Remove the demo link and the notice of integrated demo from the redux-framework plugin
            function remove_demo() {

                // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    remove_filter( 'plugin_row_meta', array(
                        ReduxFrameworkPlugin::instance(),
                        'plugin_metalinks'
                    ), null, 2 );

                    // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                    remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
                }
            }

            public function setSections() {

                /**
                 * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
                 * */
                // Background Patterns Reader
                $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
                $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
                $sample_patterns      = array();

                if ( is_dir( $sample_patterns_path ) ) :

                    if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
                        $sample_patterns = array();

                        while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                            if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                                $name              = explode( '.', $sample_patterns_file );
                                $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                                $sample_patterns[] = array(
                                    'alt' => $name,
                                    'img' => $sample_patterns_url . $sample_patterns_file
                                );
                            }
                        }
                    endif;
                endif;

                ob_start();

                $ct          = wp_get_theme();
                $this->theme = $ct;
                $item_name   = $this->theme->get( 'Name' );
                $tags        = $this->theme->Tags;
                $screenshot  = $this->theme->get_screenshot();
                $class       = $screenshot ? 'has-screenshot' : '';

                $customize_title = sprintf( __( 'Customize &#8220;%s&#8221;', 'majale' ), $this->theme->display( 'Name' ) );

                ?>
                <div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
                    <?php if ( $screenshot ) : ?>
                        <?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                            <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize"
                               title="<?php echo esc_attr( $customize_title ); ?>">
                                <img src="<?php echo esc_url( $screenshot ); ?>"
                                     alt="<?php esc_attr_e( 'Current theme preview', 'majale' ); ?>"/>
                            </a>
                        <?php endif; ?>
                        <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>"
                             alt="<?php esc_attr_e( 'Current theme preview', 'majale' ); ?>"/>
                    <?php endif; ?>

                    <h4><?php echo $this->theme->display( 'Name' ); ?></h4>

                    <div>
                        <ul class="theme-info">
                            <li><?php printf( __( 'By %s', 'majale' ), $this->theme->display( 'Author' ) ); ?></li>
                            <li><?php printf( __( 'Version %s', 'majale' ), $this->theme->display( 'Version' ) ); ?></li>
                            <li><?php echo '<strong>' . __( 'Tags', 'majale' ) . ':</strong> '; ?><?php printf( $this->theme->display( 'Tags' ) ); ?></li>
                        </ul>
                        <p class="theme-description"><?php echo $this->theme->display( 'Description' ); ?></p>
                        <?php
                            if ( $this->theme->parent() ) {
                                printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'majale' ) . '</p>', __( 'http://codex.wordpress.org/Child_Themes', 'majale' ), $this->theme->parent()->display( 'Name' ) );
                            }
                        ?>

                    </div>
                </div>

                <?php
                $item_info = ob_get_contents();

                ob_end_clean();

                $sampleHTML = '';
                if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
                    Redux_Functions::initWpFilesystem();

                    global $wp_filesystem;

                    $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
                }

                // ACTUAL DECLARATION OF SECTIONS

                /**
                 * 1.0 General Settings
                 */
                $this->sections[] = array(
                    'title'  => __( 'General', 'majale' ),
                    'desc'   => __( 'General setting and controls', 'majale' ),
                    'icon'   => 'el-icon-cogs',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(
                        array(
                            'id'       => 'favicon',
                            'type'     => 'media',
                            'title'    => __( 'Custom favicon', 'majale' ),
                            'mode'     => 'image',
                            'desc'     => __( 'Recommended size: 16x16', 'majale' ),
                            'hint'     => array(
                                'content' => __('little icon apear on the browser tab.', 'majale'),
                            )
                        ),
                        array(
                            'id'       => 'apple_iphone',
                            'type'     => 'media',
                            'title'    => __( 'Apple iPhone Icon', 'majale' ),
                            'mode'     => 'image',
                            'desc'     => __( 'Recommended size: 57x57', 'majale' ),
                            'subtitle' => __( 'Apple icon touch for iphone', 'majale' ),
                        ),  
                        array(
                            'id'       => 'apple_iphone_retina',
                            'type'     => 'media',
                            'title'    => __( 'Apple iPhone Retina Icon', 'majale' ),
                            'mode'     => 'image',
                            'desc'     => __( 'Recommended size: 72x72', 'majale' ),
                            'subtitle' => __( 'Apple icon touch for iphone with retina display', 'majale' )
                        ),  
                        array(
                            'id'       => 'apple_ipad',
                            'type'     => 'media',
                            'title'    => __( 'Apple iPad Icon', 'majale' ),
                            'compiler' => 'true',
                            'mode'     => 'image',
                            'desc'     => __( 'Recommended size: 114x114', 'majale' ),
                            'subtitle' => __( 'Apple icon touch for ipad', 'majale' )
                        ),
                        array(
                            'id'       => 'apple_ipad_retina',
                            'type'     => 'media',
                            'title'    => __( 'Apple iPad Retina Icon', 'majale' ),
                            'compiler' => 'true',
                            'mode'     => 'image',
                            'desc'     => __( 'Recommended size: 144x144', 'majale' ),
                            'subtitle' => __( 'Apple icon touch for ipad with retina display', 'majale' )
                        ),
                        array(
                            'id'       => 'time_format',
                            'type'     => 'radio',
                            'title'    => __( 'Time Format', 'majale' ),
                            'subtitle' => __( 'Default time format', 'majale' ),
                            //'desc'     => __( 'This is the description field, again good for additional info.', 'majale' ),
                            //Must provide key => value pairs for radio options
                            'options'  => array(
                                '1' => 'Disable',
                                '2' => 'WordPress Default',
                                '3' => 'Human Different'
                            ),
                            'default'  => '2'
                        ),
                        array(
                            'id'       => 'header_code',
                            'type'     => 'ace_editor',
                            'title'    => __( 'Custom code for adding in header section', 'majale' ),
                            'mode'     => 'html',
                            'theme'    => 'monokai',
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'footer_code',
                            'type'     => 'ace_editor',
                            'title'    => __( 'Custom code for adding in footer section', 'majale' ),
                            'mode'     => 'html',
                            'theme'    => 'monokai',
                            'default'  => ''                          
                        ),
                        array(
                            'id'       => 'style_code',
                            'type'     => 'ace_editor',
                            'title'    => __( 'Custom CSS', 'majale' ),
                            'subtitle' => __( 'don\'t use style tag, just paste CSS part.', 'majale' ),
                            'mode'     => 'css',
                            'theme'    => 'monokai',
                            'default'  => ''
                        )
                    )
                );                

 
                /**
                 * 2.0 Logo Settings
                 */
                $this->sections[] = array(
                    'icon'   => 'el-icon-cogs',
                    'title'  => __( 'Header', 'majale' ),
                    'fields' => array(
                        array(
                            'id'       => 'logo_type',
                            'type'     => 'button_set',
                            'title'    => __( 'Logo', 'majale' ),
                            //'subtitle' => __( 'Look, it\'s on! Also hidden child elements!', 'majale' ),
                            'options'  => array(
                                '1' => __('Display Site Title', 'majale'),
                                '2' => __('Custom Image Logo', 'majale')
                            ),
                            'default'  => '1'
                        ),
                        array(
                            'id'       => 'logo_image',
                            'type'     => 'media',
                            'title'    => __( 'custom logo', 'majale' ),
                            'compiler' => 'true',
                            'required' => array( 'logo_type', 'equals', '2' ),
                            'mode'     => 'image',
                            // Can be set to false to allow any media type, or can also be set to any mime type.
                            'desc'     => __( 'max width: 1080px<br />max height: 64px', 'majale' ),
                            // 'subtitle' => __( '', 'majale' ),
                            'hint'     => array(
                                //'title'     => '',
                                'content' => __('custom logo image instead of plain text', 'majale'),
                            )
                        ),
                        array(
                            'id'            => 'logo_top_margin',
                            'type'          => 'slider',
                            'title'         => __( 'Logo top margin', 'majale' ),
                            'subtitle'      => __( 'value in px.', 'majale' ),
                            'default'       => 0,
                            'min'           => 0,
                            'max'           => 100,
                            'step'          => 1,
                            'display_value' => 'text'
                        ),
                        array(
                            'id'       => 'logo_image_align',
                            'type'     => 'button_set',
                            'title'    => __( 'Logo Image Align', 'majale' ),
                            'options'  => array(
                                '1' => __('Left', 'majale'),
                                '2' => __('Center', 'majale'),
                                '3' => __('Right', 'majale')
                            ),
                            'default'  => '2'
                        ),
                        array(
                            'id'       => 'search_icon_position',
                            'type'     => 'button_set',
                            'title'    => __( 'Search Icon Position', 'majale' ),
                            'options'  => array(
                                '1' => __('Left', 'majale'),
                                '2' => __('Right', 'majale'),
                                '3' => __('Disabled', 'majale')
                            ),
                            'default'  => '2'
                        ),
                        array(
                            'id'       => 'navigation_menu',
                            'type'     => 'button_set',
                            'title'    => __( 'Navigation Menu Visibility', 'majale' ),
                            'options'  => array(
                                '1' => __('show', 'majale'),
                                '2' => __('hide', 'majale')
                            ),
                            'default'  => '1'
                        )
                    )
                );

                /**
                 * 3.0 Feature Posts settings.
                 */
                $this->sections[] = array(
                    'icon'   => 'el-icon-cogs',
                    'title'  => __( 'Feature Posts', 'majale' ),
                    'fields' => array(
                        array(
                            'id'       => 'feature_posts_width',
                            'type'     => 'button_set',
                            'title'    => __( 'Feature posts style', 'majale' ),
                            'options'  => array(
                                '1' => __('Full Width', 'majale'),
                                '2' => __('Boxed', 'majale')
                            ),
                            'default'  => '2'
                        ),
                        array(
                            'id'       => 'show_feature_posts',
                            'type'     => 'checkbox',
                            'title'    => __( 'Show Features Posts on', 'majale' ),
                            'subtitle' => __( 'Leave this option if you don\'t know what are these pages are for.' , 'majale' ),
                            'options'  => array(
                                '1' => __('Archive Page', 'majale'),
                                '2' => __('Author Page', 'majale'),
                                '3' => __('Category Page', 'majale'),
                                '4' => __('Home Page', 'majale'),
                                '5' => __('Page', 'majale'),
                                '6' => __('Search Page', 'majale'),
                                '7' => __('Single Post Page', 'majale'),
                                '8' => __('Tag Page', 'majale')
                            ),
                            'default'  => array(
                                '1' => '0',
                                '2' => '0',
                                '3' => '0',
                                '4' => '1',
                                '5' => '0',
                                '6' => '0',
                                '7' => '0',
                                '8' => '0'
                            )
                        ),
                        array(
                            'id'            => 'feature_posts_count',
                            'type'          => 'slider',
                            'title'         => __( 'Number of Features Posts to Show', 'majale' ),
                            'subtitle'      => __( 'if number of feature posts are less than this value, it will use count of feature posts instead.', 'majale' ),
                            'desc'          => __( 'Min: 1, max: 8, default value: 8', 'majale' ),
                            'default'       => 8,
                            'min'           => 1,
                            'step'          => 1,
                            'max'           => 8,
                            'display_value' => 'text'
                        ),
                    )
                );

                /**
                 * 4.0 Style Settings
                 */
                $this->sections[] = array(
                    'icon'   => 'el-icon-cogs',
                    'title'  => __( 'Style', 'majale' ),
                    'fields' => array(
                        array(
                            'id'       => 'layout_type',
                            'type'     => 'button_set',
                            'title'    => __( 'Layout Type', 'majale' ),
                            'options'  => array(
                                '1' => 'Boxed',
                                '2' => 'Full Width'
                            ),
                            'default'  => '2'
                        ),
                        array(
                            'id'            => 'site_width',
                            'type'          => 'slider',
                            'title'         => __( 'Site Max Width', 'majale' ),
                            'subtitle'      => __( 'value in px.', 'majale' ),
                            'default'       => 1170,
                            'min'           => 600,
                            'max'           => 1920,
                            'step'          => 10,
                            'display_value' => 'text'
                        ),
                        array(
                            'id'       => 'blog_layout',
                            'type'     => 'image_select',
                            'compiler' => true,
                            'title'    => __( 'Blog Layout', 'majale' ),
                            'options'  => array(
                                '1' => array(
                                    'alt' => '1 Column',
                                    'img' => ReduxFramework::$_url . 'assets/img/1col.png'
                                ),
                                '2' => array(
                                    'alt' => '2 Column Left',
                                    'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
                                ),
                                '3' => array(
                                    'alt' => '2 Column Right',
                                    'img' => ReduxFramework::$_url . 'assets/img/2cr.png'
                                ),
                                '4' => array(
                                    'alt' => '3 Column Middle',
                                    'img' => ReduxFramework::$_url . 'assets/img/3cm.png'
                                ),
                                '5' => array(
                                    'alt' => '3 Column Left',
                                    'img' => ReduxFramework::$_url . 'assets/img/3cl.png'
                                ),
                                '6' => array(
                                    'alt' => '3 Column Right',
                                    'img' => ReduxFramework::$_url . 'assets/img/3cr.png'
                                )
                            ),
                            'default'  => '4'
                        ),
                        array(
                            'id'       => 'shop_layout',
                            'type'     => 'image_select',
                            'compiler' => true,
                            'title'    => __( 'Shop Layout', 'majale' ),
                            'options'  => array(
                                '1' => array(
                                    'alt' => '1 Column',
                                    'img' => ReduxFramework::$_url . 'assets/img/1col.png'
                                ),
                                '2' => array(
                                    'alt' => '2 Column Left',
                                    'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
                                ),
                                '3' => array(
                                    'alt' => '2 Column Right',
                                    'img' => ReduxFramework::$_url . 'assets/img/2cr.png'
                                ),
                                '4' => array(
                                    'alt' => '3 Column Middle',
                                    'img' => ReduxFramework::$_url . 'assets/img/3cm.png'
                                ),
                                '5' => array(
                                    'alt' => '3 Column Left',
                                    'img' => ReduxFramework::$_url . 'assets/img/3cl.png'
                                ),
                                '6' => array(
                                    'alt' => '3 Column Right',
                                    'img' => ReduxFramework::$_url . 'assets/img/3cr.png'
                                )
                            ),
                            'default'  => '4'
                        ),
                        array(
                            'id'       => 'shop_single_layout',
                            'type'     => 'image_select',
                            'compiler' => true,
                            'title'    => __( 'Shop Single product Layout', 'majale' ),
                            'options'  => array(
                                '1' => array(
                                    'alt' => '1 Column',
                                    'img' => ReduxFramework::$_url . 'assets/img/1col.png'
                                ),
                                '2' => array(
                                    'alt' => '2 Column Left',
                                    'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
                                ),
                                '3' => array(
                                    'alt' => '2 Column Right',
                                    'img' => ReduxFramework::$_url . 'assets/img/2cr.png'
                                ),
                                '4' => array(
                                    'alt' => '3 Column Middle',
                                    'img' => ReduxFramework::$_url . 'assets/img/3cm.png'
                                ),
                                '5' => array(
                                    'alt' => '3 Column Left',
                                    'img' => ReduxFramework::$_url . 'assets/img/3cl.png'
                                ),
                                '6' => array(
                                    'alt' => '3 Column Right',
                                    'img' => ReduxFramework::$_url . 'assets/img/3cr.png'
                                )
                            ),
                            'default'  => '4'
                        ),
                        array(
                            'id'   => 'header-info-field',
                            'type' => 'info',
                            'style' => 'success',
                            'desc' => __( 'header style.', 'majale' )
                        ),
                        array(
                            'id'       => 'header-background',
                            'type'     => 'background',
                            'output'   => array( '.logo, .mobile-menu, .mobile-search' ),
                            'title'    => __( 'Header Background', 'majale' ),
                            'subtitle' => __( 'Set Header Background', 'majale' ),
                            'default'   => '#FFF'
                        ),
                        array(
                            'id'       => 'logo-color-rgba',
                            'type'     => 'color_rgba',
                            'title'    => __( 'Text logo color', 'majale' ),
                            'default'  => array( 
                                'color' => '#333', 
                                'alpha' => '1' 
                            ),
                            'output'   => array( '.site-title' ),
                            'mode'     => 'color',
                            'validate' => 'colorrgba'
                        ),
                        array(
                            'id'       => 'tagline-color-rgba',
                            'type'     => 'color_rgba',
                            'title'    => __( 'Tagline color', 'majale' ),
                            'default'  => array( 
                                'color' => '#BDB8B8', 
                                'alpha' => '1' 
                            ),
                            'output'   => array( '.site-description' ),
                            'mode'     => 'color',
                            'validate' => 'colorrgba'
                        ),
                        array(
                            'id'       => 'search_icon_link_color',
                            'type'     => 'link_color',
                            'title'    => __( 'search icon color', 'majale' ),
                            //'regular'   => false, // Disable Regular Color
                            //'hover'     => false, // Disable Hover Color
                            //'active'    => false, // Disable Active Color
                            //'visited'   => true,  // Enable Visited Color
                            'default'  => array(
                                'regular' => '#0fb9ab',
                                'hover'   => '#237E76',
                                'active'  => '#237E76',
                            )
                        ),
                        array(
                            'id'       => 'search-background',
                            'type'     => 'background',
                            'output'   => array( '.search-input' ),
                            'title'    => __( 'Search input background', 'majale' ),
                            'default'   => '#DDD'
                        ),
                        array(
                            'id'       => 'search-color-rgba',
                            'type'     => 'color_rgba',
                            'title'    => __( 'Search color', 'majale' ),
                            'default'  => array( 
                                'color' => '#333', 
                                'alpha' => '1' 
                            ),
                            'output'   => array( '.search-input' ),
                            'mode'     => 'color',
                            'validate' => 'colorrgba'
                        ),
                        array(
                            'id'       => 'navigation-background',
                            'type'     => 'background',
                            'output'   => array( '.main-navigation-container' ),
                            'title'    => __( 'Navigation Background', 'majale' ),
                            'subtitle' => __( 'Set navigation Background', 'majale' ),
                            'default'   => '#FFF'
                        ),
                        array(
                            'id'       => 'navigation-submenu-background',
                            'type'     => 'background',
                            'output'   => array( '#cssmenu ul ul a, #cssmenu ul ul li:hover > a' ),
                            'title'    => __( 'Sub-menu Navigation Background', 'majale' ),
                            'subtitle' => __( 'Set sub-menu navigation Background', 'majale' ),
                            'default'   => '#FFF'
                        ),
                        array(
                            'id'       => 'navigation_link_color',
                            'type'     => 'link_color',
                            'title'    => __( 'Links Color for menu', 'majale' ),
                            //'regular'   => false, // Disable Regular Color
                            //'hover'     => false, // Disable Hover Color
                            //'active'    => false, // Disable Active Color
                            //'visited'   => true,  // Enable Visited Color
                            'default'  => array(
                                'regular' => '#0fb9ab',
                                'hover'   => '#237E76',
                                'active'  => '#237E76',
                            )
                        ),
                        array(
                            'id'   => 'header-info-field2',
                            'type' => 'info',
                            'style' => 'success',
                            'desc' => __( 'Feature posts', 'majale' ),
                        ),
                        array(
                            'id'       => 'feature_posts_default_background',
                            'type'     => 'background',
                            'output'   => array( '.zone' ),
                            'title'    => __( 'Feature Posts Background', 'majale' ),
                            'subtitle' => __( 'Default Values: <br>Background Repeat: no repeat<br>Background Size: Cover<br>Background Attachment: Fixed<br>Background Position: center center<br>Reset section to revert default background.', 'majale' )
                        ),
                        array(
                            'id'       => 'feature_posts_color',
                            'type'     => 'color_rgba',
                            'title'    => __( 'Features posts font color', 'majale' ),
                            'default'  => array( 
                                'color' => '#FFF', 
                                'alpha' => '1' 
                            ),
                            'output'   => array( '.zone .caption' ),
                            'mode'     => 'color',
                            'validate' => 'colorrgba'
                        ),
                        array(
                            'id'   => 'header-info-field3',
                            'type' => 'info',
                            'style' => 'success',
                            'desc' => __( 'Main content', 'majale' ),
                        ),
                        array(
                            'id'       => 'post_background',
                            'type'     => 'background',
                            'output'   => array( '.blog-post-area, .single-post-metadata, .related-posts, .next-post-section, .previous-post-section, .comments-title, .comment-reply, div.comment-form, .comments-navigation, .comment>article, .woocommerce div.product-container, .woocommerce div.product .woocommerce-tabs .panel, .woocommerce div.single-product-container, .shop-page-title, .breadcrumb, .woocommerce div.product-container, .woocommerce div.product .woocommerce-tabs ul.tabs li.active, .woocommerce div.product .woocommerce-tabs ul.tabs li, .quick-view, .modal-content, .comment-area'),
                            'title'    => __( 'Main content area background', 'majale' ),
                            'subtitle' => __( 'background for posts area, meta descriptions bellow the posts and comments.', 'majale' )
                        ),
                        array(
                            'id'       => 'post_color',
                            'type'     => 'color_rgba',
                            'title'    => __( 'Main content area primary color', 'majale' ),
                            'subtitle' => __( 'header and contents.', 'majale' ),
                            'default'  => array( 
                                'color' => '#333', 
                                'alpha' => '1' 
                            ),
                            'output'   => array( '.log-area .article-content, .blog-post-title, .blog-post-area, .single-post-metadata, .related-posts, .next-post-section, .previous-post-section, .comments-title, .comment-reply, div.comment-form, .comments-navigation, .comment>article, .tag-list a, .cat-list a, .commenter-send, .woocommerce div.single-product-container, .woocommerce div.products div.product .price, .woocommerce a.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce .widget_price_filter .price_slider_amount .button, .woocommerce .cart .button, .woocommerce .cart input.button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .modal-footer .btn, .shop-page-title, .breadcrumb, .blog-post-quote blockquote, .quick-view, .modal-content, h1.product_title.entry-title'),
                            'mode'     => 'color',
                            'validate' => 'colorrgba'
                        ),
                        array(
                            'id'       => 'post_meta',
                            'type'     => 'color_rgba',
                            'title'    => __( 'Main content area secondary color', 'majale' ),
                            'subtitle' => __( 'date and author.', 'majale' ),
                            'default'  => array( 
                                'color' => '#DDD', 
                                'alpha' => '1' 
                            ),
                            'output'   => array( '.blog-area span.date, .blog-area span.author, .woocommerce-review-link, .woocommerce #reviews #comments ol.commentlist li .comment-text p.meta, .woocommerce .star-rating:before, .woocommerce .star-rating, .comment-author, .fn, .comment-metadata time'),
                            'mode'     => 'color',
                            'validate' => 'colorrgba'
                        ),
                        array(
                            'id'       => 'post_link_color',
                            'type'     => 'link_color',
                            'title'    => __( 'link colors', 'majale' ),
                            //'regular'   => false, // Disable Regular Color
                            //'hover'     => false, // Disable Hover Color
                            //'active'    => false, // Disable Active Color
                            //'visited'   => true,  // Enable Visited Color
                            'default'  => array(
                                'regular' => '#0fb9ab',
                                'hover'   => '#237E76',
                                'active'  => '#0fb9ab',
                            )
                        ),
                        array(
                            'id'   => 'header-info-field4',
                            'type' => 'info',
                            'style' => 'success',
                            'desc' => __( 'Widget', 'majale' ),
                        ),
                        array(
                            'id'       => 'widget_background',
                            'type'     => 'background',
                            'output'   => array( '.sidebar-1 aside.widget-area, .sidebar-2 aside.widget-area' ),
                            'title'    => __( 'background', 'majale' ),
                            'default'   => '#FFF',
                        ),
                        array(
                            'id'       => 'widget_content_color',
                            'type'     => 'color_rgba',
                            'title'    => __( 'content font color', 'majale' ),
                            'subtitle' => __( 'Apply to texts', 'majale' ),
                            'default'  => array( 
                                'color' => '#333', 
                                'alpha' => '1' 
                            ),
                            'output'   => array( '.sidebar-1 aside.widget-area, .sidebar-2 aside.widget-area' ),
                            'mode'     => 'color',
                            'validate' => 'colorrgba'
                        ),
                        array(
                            'id'       => 'widget_header_color',
                            'type'     => 'color_rgba',
                            'title'    => __( 'header font color', 'majale' ),
                            'subtitle' => __( 'Apply to header', 'majale' ),
                            'default'  => array( 
                                'color' => '#333', 
                                'alpha' => '1' 
                            ),
                            'output'   => array( '.sidebar-1 aside .widget-title, .sidebar-2 aside .widget-title' ),
                            'mode'     => 'color',
                            'validate' => 'colorrgba'
                        ),
                        array(
                            'id'       => 'widget_link_color',
                            'type'     => 'link_color',
                            'title'    => __( 'link colors', 'majale' ),
                            //'regular'   => false, // Disable Regular Color
                            //'hover'     => false, // Disable Hover Color
                            //'active'    => false, // Disable Active Color
                            //'visited'   => true,  // Enable Visited Color
                            'default'  => array(
                                'regular' => '#0fb9ab',
                                'hover'   => '#237E76',
                                'active'  => '#0fb9ab',
                            )
                        ),
                        array(
                            'id'   => 'header-info-field4',
                            'type' => 'info',
                            'style' => 'success',
                            'desc' => __( 'Footer', 'majale' ),
                        ),
                        array(
                            'id'       => 'footer_background',
                            'type'     => 'background',
                            'output'   => array( '.footer' ),
                            'title'    => __( 'Background', 'majale' ),
                            'default'   => '#333',
                        ),
                        array(
                            'id'       => 'footer_content_color',
                            'type'     => 'color_rgba',
                            'title'    => __( 'content font color', 'majale' ),
                            'subtitle' => __( 'Apply to texts', 'majale' ),
                            'default'  => array( 
                                'color' => '#E2DEDE', 
                                'alpha' => '1' 
                            ),
                            'output'   => array( '.footer' ),
                            'mode'     => 'color',
                            'validate' => 'colorrgba'
                        ),
                        array(
                            'id'       => 'footer_header_color',
                            'type'     => 'color_rgba',
                            'title'    => __( 'header font color', 'majale' ),
                            'subtitle' => __( 'Apply to header', 'majale' ),
                            'default'  => array( 
                                'color' => '#E2DEDE', 
                                'alpha' => '1' 
                            ),
                            'output'   => array( '.footer .widget-title' ),
                            'mode'     => 'color',
                            'validate' => 'colorrgba'
                        ),
                        array(
                            'id'       => 'footer_link_color',
                            'type'     => 'link_color',
                            'title'    => __( 'link colors', 'majale' ),
                            //'regular'   => false, // Disable Regular Color
                            //'hover'     => false, // Disable Hover Color
                            //'active'    => false, // Disable Active Color
                            //'visited'   => true,  // Enable Visited Color
                            'default'  => array(
                                'regular' => '#0fb9ab',
                                'hover'   => '#237E76',
                                'active'  => '#0fb9ab',
                            )
                        ),
                        array(
                            'id'   => 'header-info-field6',
                            'type' => 'info',
                            'style' => 'success',
                            'desc' => __( 'Information Footer', 'majale' ),
                        ),
                        array(
                            'id'       => 'footer_info_background',
                            'type'     => 'background',
                            'output'   => array( '.footer-info' ),
                            'title'    => __( 'Background', 'majale' ),
                            'default'   => '#333',
                        ),
                        array(
                            'id'       => 'footer_info_header_color',
                            'type'     => 'color_rgba',
                            'title'    => __( 'text color', 'majale' ),
                            'default'  => array( 
                                'color' => '#939393', 
                                'alpha' => '1' 
                            ),
                            'output'   => array( '.footer-info, .footer-info p' ),
                            'mode'     => 'color',
                            'validate' => 'colorrgba'
                        ),
                        array(
                            'id'   => 'header-info-field5',
                            'type' => 'info',
                            'style' => 'success',
                            'desc' => __( 'Component', 'majale' ),
                        ),
                        array(
                            'id'       => 'body_background',
                            'type'     => 'background',
                            'output'   => array( 'body, #goTop' ),
                            'title'    => __( 'Body Background', 'majale' ),
                            'subtitle' => __( 'Set Body Background', 'majale' ),
                            'default'   => '#DDD',
                        ),
                        array(
                            'id'       => 'pagination_background',
                            'type'     => 'background',
                            'output'   => array( '.page-numbers, .page-numbers.dots' ),
                            'title'    => __( 'Pagination background color', 'majale' ),
                            'default'   => '#fff',
                        ),
                        array(
                            'id'       => 'pagination_color',
                            'type'     => 'color_rgba',
                            'title'    => __( 'Pagination font color', 'majale' ),
                            'default'  => array( 
                                'color' => '#333', 
                                'alpha' => '1' 
                            ),
                            'output'   => array( '.page-numbers, .page-numbers.dots' ),
                            'mode'     => 'color',
                            'validate' => 'colorrgba'
                        ),
                        array(
                            'id'       => 'pagination_avtive_background',
                            'type'     => 'background',
                            'output'   => array( '.page-numbers.current, .page-numbers:hover' ),
                            'title'    => __( 'Pagination background color on hover and active', 'majale' ),
                            'default'   => '#333',
                        ),
                        array(
                            'id'       => 'pagination_color_active',
                            'type'     => 'color_rgba',
                            'title'    => __( 'Pagination font color on hover and active', 'majale' ),
                            'default'  => array( 
                                'color' => '#fff', 
                                'alpha' => '1' 
                            ),
                            'output'   => array( '.page-numbers.current, .page-numbers:hover' ),
                            'mode'     => 'color',
                            'validate' => 'colorrgba'
                        ),
                        array(
                            'id'       => 'input_border_color',
                            'type'     => 'color_rgba',
                            'title'    => __( 'Input and buttons border color', 'majale' ),
                            'default'  => array( 
                                'color' => '#ddd', 
                                'alpha' => '1' 
                            ),
                            'validate' => 'colorrgba'
                        ),
                        array(
                            'id'       => 'input_border_hover',
                            'type'     => 'color_rgba',
                            'title'    => __( 'Input and buttons border color on focus', 'majale' ),
                            'default'  => array( 
                                'color' => '#0fb9ab', 
                                'alpha' => '1' 
                            ),
                            'validate' => 'colorrgba'
                        ),
                    )
                );

                /**
                 * 4.0 Footer
                 */
                $this->sections[] = array(
                    'icon'   => 'el-icon-cogs',
                    'title'  => __( 'Footer', 'majale' ),
                    'fields' => array(
                        array(
                            'id'       => 'footer_info_editor',
                            'type'     => 'editor',
                            'title'    => __( 'Information footer text', 'majale' ),
                            'default'  => 'Themed By AmirMasoud Sheidayi - 2015 &copy;',
                        ),
                    )
                );

                /**
                 * 5.0 Shop Setting
                 */
                $this->sections[] = array(
                    'icon'   => 'el-icon-cogs',
                    'title'  => __( 'Shop', 'majale' ),
                    'fields' => array(
                        array(
                            'id'            => 'products_per_row',
                            'type'          => 'slider',
                            'title'         => __( 'Products in a row', 'majale' ),
                            'subtitle'      => __( 'Number of products to show in a row.', 'majale' ),
                            'default'       => 2,
                            'min'           => 1,
                            'step'          => 1,
                            'max'           => 5,
                            'display_value' => 'label'
                        ),
                    )
                );

                /**
                 * 6.0 Typography Setting
                 */
                $this->sections[] = array(
                    'icon'   => 'el-icon-cogs',
                    'title'  => __( 'Typography', 'majale' ),
                    'fields' => array(
                        array(
                            'id'          => 'logo_description_typography',
                            'type'        => 'typography',
                            'title'       => __( 'logo and description', 'majale' ),
                            'google'      => true,
                            'font-backup' => true,
                            'color'       => false,
                            'all_styles'  => true,
                            'output'      => array( '.site-title, .site-description' ),
                            'units'       => 'px',
                            'default'     => array(
                                'font-family' => 'Abel',
                                'google'      => true,
                            ),
                        ),
                        array(
                            'id'          => 'headers_typography',
                            'type'        => 'typography',
                            'title'       => __( 'Headers', 'majale' ),
                            'google'      => true,
                            'font-backup' => true,
                            'color'       => false,
                            'all_styles'  => true,
                            'output'      => array( '.blog-post-title, .widget-title, .zone .caption, .blog-area article h1, .blog-area article h2, .blog-area article h3, .blog-area article h4, .blog-area article h5, .blog-area article h6, .woocommerce div.products div.product h3, .woocommerce div.product .product_title' ),
                            'units'       => 'px',
                            'description' => 'Blog posts, widget title, features posts, Blog posts content headers, products name',
                            'default'     => array(
                                'font-family' => 'Abel',
                                'google'      => true,
                            ),
                        ),
                        array(
                            'id'          => 'body_typography',
                            'type'        => 'typography',
                            'title'       => __( 'Body', 'majale' ),
                            'google'      => true,
                            'font-backup' => true,
                            'color'       => false,
                            'all_styles'  => true,
                            'output'      => array( 'body' ),
                            'units'       => 'px',
                            'description' => 'main font',
                            'default'     => array(
                                'font-style'  => '400',
                                'font-family' => 'Abel',
                                'google'      => true,
                            ),
                        )
                    )
                );

                if ( file_exists( trailingslashit( dirname( __FILE__ ) ) . 'README.html' ) ) {
                    $tabs['docs'] = array(
                        'icon'    => 'el-icon-book',
                        'title'   => __( 'Documentation', 'majale' ),
                        'content' => nl2br( file_get_contents( trailingslashit( dirname( __FILE__ ) ) . 'README.html' ) )
                    );
                }
            }

            public function setHelpTabs() {

                // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-1',
                    'title'   => __( 'Theme Information 1', 'majale' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'majale' )
                );

                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-2',
                    'title'   => __( 'Theme Information 2', 'majale' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'majale' )
                );

                // Set the help sidebar
                $this->args['help_sidebar'] = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'majale' );
            }

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'             => 'majale',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'         => $theme->get( 'Name' ),
                    // Name that appears at the top of your panel
                    'display_version'      => $theme->get( 'Version' ),
                    // Version that appears at the top of your panel
                    'menu_type'            => 'menu',
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'       => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'           => __( 'Majale Options', 'majale' ),
                    'page_title'           => __( 'Majale Options', 'majale' ),
                    // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'       => '',
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => true,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => true,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-portfolio',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => true,
                    // Show the time the page took to load, etc
                    'update_notice'        => true,
                    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                    'customizer'           => true,
                    // Enable basic customizer support
                    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                    // OPTIONAL -> Give you extra features
                    'page_priority'        => null,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'          => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'     => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'            => '',
                    // Specify a custom URL to an icon
                    'last_tab'             => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'            => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => 'majale_options',
                    // Page slug used to denote the panel
                    'save_defaults'        => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'         => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'         => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export'   => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'       => 60 * MINUTE_IN_SECONDS,
                    'output'               => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'           => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'             => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'          => false,
                    // REMOVE

                    // HINTS
                    'hints'                => array(
                        'icon'          => 'icon-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'   => 'light',
                            'shadow'  => true,
                            'rounded' => false,
                            'style'   => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'mouseover',
                            ),
                            'hide' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'click mouseleave',
                            ),
                        ),
                    )
                );

                // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
                $this->args['admin_bar_links'][] = array(
                    'id'    => 'redux-docs',
                    'href'   => 'http://docs.reduxframework.com/',
                    'title' => __( 'Documentation', 'majale' ),
                );

                $this->args['admin_bar_links'][] = array(
                    //'id'    => 'redux-support',
                    'href'   => 'https://github.com/ReduxFramework/redux-framework/issues',
                    'title' => __( 'Support', 'majale' ),
                );

                $this->args['admin_bar_links'][] = array(
                    'id'    => 'redux-extensions',
                    'href'   => 'reduxframework.com/extensions',
                    'title' => __( 'Extensions', 'majale' ),
                );

                // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
                $this->args['share_icons'][] = array(
                    'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                    'title' => 'Visit us on GitHub',
                    'icon'  => 'el-icon-github'
                    //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                    'title' => 'Like us on Facebook',
                    'icon'  => 'el-icon-facebook'
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'http://twitter.com/reduxframework',
                    'title' => 'Follow us on Twitter',
                    'icon'  => 'el-icon-twitter'
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'http://www.linkedin.com/company/redux-framework',
                    'title' => 'Find us on LinkedIn',
                    'icon'  => 'el-icon-linkedin'
                );

                // Panel Intro text -> before the form
                if ( ! isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
                    if ( ! empty( $this->args['global_variable'] ) ) {
                        $v = $this->args['global_variable'];
                    } else {
                        $v = str_replace( '-', '_', $this->args['opt_name'] );
                    }
                    $this->args['intro_text'] = sprintf( __( '<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'majale' ), $v );
                } else {
                    $this->args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'majale' );
                }

                // Add content after the form.
                $this->args['footer_text'] = __( '<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'majale' );
            }

            public function validate_callback_function( $field, $value, $existing_value ) {
                $error = true;
                $value = 'just testing';

                /*
              do your validation

              if(something) {
                $value = $value;
              } elseif(something else) {
                $error = true;
                $value = $existing_value;
                
              }
             */

                $return['value'] = $value;
                $field['msg']    = 'your custom error message';
                if ( $error == true ) {
                    $return['error'] = $field;
                }

                return $return;
            }

            public function class_field_callback( $field, $value ) {
                print_r( $field );
                echo '<br/>CLASS CALLBACK';
                print_r( $value );
            }

            /**
             * custom method for showing tables in color preset.
             *
             * @param string $name
             * @param array $colors
             * @return table
             */
/*            private function preset_color_table($name, $colors = array())
            {
                return 
                $name . '<table class="color-palette" style="width: 250px; margin-top: 5px;">
                    <tbody>
                        <tr>
                            <td style="background-color: ' . $colors[0] . '">&nbsp;</td>
                            <td style="background-color: ' . $colors[1] . '">&nbsp;</td>
                            <td style="background-color: ' . $colors[2] . '">&nbsp;</td>
                            <td style="background-color: ' . $colors[3] . '">&nbsp;</td>
                            <td style="background-color: ' . $colors[4] . '">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>';
            }*/

        }

        global $reduxConfig;
        $reduxConfig = new majale_redux_Framework_config();
    } else {
        echo "The class named majale_redux_Framework_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ):
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    endif;

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ):
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error = true;
            $value = 'just testing';

            /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            
          }
         */

            $return['value'] = $value;
            $field['msg']    = 'your custom error message';
            if ( $error == true ) {
                $return['error'] = $field;
            }

            return $return;
        }
    endif;
