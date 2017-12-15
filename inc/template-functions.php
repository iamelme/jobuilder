<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package jobuilder
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function jobuilder_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'jobuilder_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function jobuilder_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'jobuilder_pingback_header' );

add_post_type_support( 'page', 'excerpt' );

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );



//form


function my_enqueue() {

      if ( is_page( 'contact' ) ) {

        wp_enqueue_script( 'ajax-script', get_template_directory_uri() . '/js/user-data.js', NULL, 1.0, true);
        // wp_enqueue_script( 'ajax-script', get_template_directory_uri() . '/js/user-data.js', NULL, 1.0, true);

        
        wp_localize_script('ajax-script', 'magicalData', array(
            'nonce' => wp_create_nonce('wp_rest'),
            'siteURL' => get_site_url()
        ));

        wp_localize_script( 'ajax-script', 'my_ajax_object',
                array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
      } 
}
add_action( 'wp_enqueue_scripts', 'my_enqueue' );

function process_user_generated_post() {

    $response_code = $_POST['captcha'];

    $arr = [
        'secret' => '6LemrzwUAAAAAL_VF7ansiu2qbLQ8-YhXmn0SDG_',
        'response' => $response_code
    ];


    function curl($url, $parameters) {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_POST, true);

        $headers = [];
        $headers[] = "Content-Length:" . strlen(http_build_query($parameters));

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        return curl_exec($ch);
    }

    $returned = curl("https://www.google.com/recaptcha/api/siteverify", $arr);

    var_dump($returned);


    $data = json_decode($returned);
    $check = $data->success;

    var_dump($check);


    if($check) {
        $question_data = array(
            'post_title' => sanitize_text_field( $_POST[ 'name' ] ),
            'post_status' => 'draft',
            'post_type' => 'message',
            'post_content' =>  sprintf('%s %s %s', 
                'Phone: ' . sanitize_text_field( $_POST[ 'phone' ]),
                '<br> Email Address: ' . sanitize_text_field( $_POST[ 'email' ]),
                '<br> Message: ' . sanitize_text_field( $_POST[ 'message' ]) )
        );



        $post_id = wp_insert_post( $question_data, true );

        if ( $post_id ) {
            wp_set_object_terms(
                $post_id,
                sanitize_text_field( $_POST[ 'type' ] ),
                'type',
                true
            );
            update_post_meta( $post_id, 'contact_email', sanitize_email( $_POST[ 'data' ][ 'type' ] ) );
        }

        wp_send_json_success( $post_id );

        wp_die();
        
    }
    
}
add_action( 'wp_ajax_process_user_generated_post', 'process_user_generated_post' );
add_action( 'wp_ajax_nopriv_process_user_generated_post', 'process_user_generated_post' );



function register_user_inquiry() {
    $labels = [
        'name' => 'Messages',
        'singular_name' => 'Message',
        'add_new_item' => 'Add New Message',
        'edit_item' => 'Edit Message'
    ];

    $args = [
        'labels'                => $labels,
        'show_ui'               => true,
        'show_in_rest'          => true,
        'public'                => true,
        'has_archive'           => true,
        'publicly_queryable'    => true,
        'query_var'             => true,
        'menu_icon'             => 'dashicons-admin-comments',
        'supports'              => ['title', 'editor']
    ];

    register_post_type('message', $args);
}

add_action('init', 'register_user_inquiry');

function inquiry_taxo() {

    $labels = [
        'name' => 'Types',
        'singular_name' => 'Type',
        'add_new_item' => 'Add New Type',
        'edit_item' => 'Edit Type'
    ];

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'type' ),
    );

    register_taxonomy( 'type', array( 'message' ), $args );

}

add_action( 'init', 'inquiry_taxo', 0 );


// Work admin column

add_filter('manage_work_posts_columns', 'posts_columns');
function posts_columns($defaults){
    $defaults['client_name'] = __('Clients');
    $defaults['post_thumbs'] = __('Thumbs');
    return $defaults;
}
 
add_action('manage_work_posts_custom_column', 'posts_custom_columns', 5, 2);
function posts_custom_columns($column_name, $post_id){
    if($column_name === 'client_name'){
        echo get_post_meta($post_id,'client_name', true);
    }
    if($column_name === 'post_thumbs'){
        if (has_post_thumbnail( $post_id ))
            echo the_post_thumbnail( array('50','50') );
        else
            echo "N/A";
    }
}


// Work

function register_work() {
    $labels = [
        'name' => 'Works',
        'singular_name' => 'Work',
        'add_new_item' => 'Add New Work',
        'edit_item' => 'Edit Work'
    ];

    $args = [
        'labels'                => $labels,
        'show_ui'               => true,
        'show_in_rest'          => true,
        'public'                => true,
        'has_archive'           => true,
        'publicly_queryable'    => true,
        'query_var'             => true,
        'menu_icon'             => 'dashicons-admin-tools',
        'supports'              => ['title', 'editor', 'thumbnail']
    ];

    register_post_type('work', $args);
}

add_action('init', 'register_work');

function work_custom_metabox() {

    add_meta_box(
        'work_meta',
        __( 'Project Details' ),
        'work_meta_callback',
        'work',
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes', 'work_custom_metabox' );

function work_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'work_form' );
    $work_meta = get_post_meta( $post->ID );


    $client_name = (!empty($work_meta['client_name']) ? esc_attr(  $work_meta['client_name'][0]  ) : null);
    ?>

    <div>
        <div class="form__group">
            <input type="text" name="client_name" id="client_name" class="form__control" placeholder="Client Name" value="<?php echo $client_name; ?>">
        </div>


        <div class="form__group">
            <!-- <textarea name="client_name" id="client_name" class="form__t-area" placeholder="Insert verse"><?php echo $client_name; ?></textarea> -->
        </div>

    </div>


    <?php 
}

function work_meta_save( $post_id) {
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'work_form' ] ) && wp_verify_nonce( $_POST[ 'work_form' ], basename( __FILE__ ) ) ) ? 'true' : 'false';


    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    if ( isset( $_POST[ 'client_name' ] ) ) {
        update_post_meta( $post_id, 'client_name', sanitize_text_field( $_POST[ 'client_name' ] ) );
    }
}
add_action( 'save_post', 'work_meta_save' );




// widgets on footer

function arphabet_widgets_init() {

    register_sidebar( array(
        'name'          => 'Footer location',
        'id'            => 'footer_location',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ) );

}
add_action( 'widgets_init', 'arphabet_widgets_init' );


function footer_info_widgets_init() {

    register_sidebar( array(
        'name'          => 'Footer Info',
        'id'            => 'footer_info',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ) );

}
add_action( 'widgets_init', 'footer_info_widgets_init' );


function list_body_class( $wp_classes, $extra_classes )
{
    // List of the only WP generated classes allowed
    // $whitelist = array( 'home', 'blog', 'archive', 'single', 'category', 'tag', 'error404', 'logged-in', 'admin-bar' );

    // List of the only WP generated classes that are not allowed
    $blacklist = array( 'blog' , 'hfeed');

    // Filter the body classes
    // Whitelist result: (comment if you want to blacklist classes)
    // $wp_classes = array_intersect( $wp_classes, $whitelist );
    // Blacklist result: (uncomment if you want to blacklist classes)
    $wp_classes = array_diff( $wp_classes, $blacklist );

    // Add the extra classes back untouched
    return array_merge( $wp_classes, (array) $extra_classes );
}
add_filter( 'body_class', 'list_body_class', 10, 2 );


// Breadcrumbs

function the_breadcrumb() {
       
    // Settings
    $separator          = '/';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumb';
    $home_title         = 'Home';
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       
        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';
           
        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
              
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end(array_values($category));
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
              
            } else {
                  
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
               
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }
       
        echo '</ul>';
           
    }
       
}

add_action('admin_head', 'admin_custom_css');
function admin_custom_css() {
  echo '<style>

    .form__control {
        width: 100%;
        padding: 7px 10px;
    }
  </style>';
}

add_action( 'admin_menu', 'remove_admin_menus' );

function remove_admin_menus() {
    remove_menu_page( 'edit.php' );
    remove_menu_page( 'edit-comments.php' );
    remove_menu_page( 'themes.php' );  
    remove_menu_page( 'tools.php' );  
    remove_menu_page( 'plugins.php' );  
    remove_menu_page( 'index.php' );  
}

function remove_theme_submenu() {
    $current_user = wp_get_current_user();

    if ($current_user->user_login !== 'administrator') {
        remove_submenu_page('themes.php', 'themes.php');
        remove_submenu_page('themes.php', 'theme-editor.php');
        remove_submenu_page('themes.php', 'nav-menus.php');

        remove_menu_page( 'users.php' );  
    }
  
}
add_action('admin_init', 'remove_theme_submenu', 100);


function remove_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
    $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
    $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
    $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
    $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
    $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
    // $wp_admin_bar->remove_menu('site-name');        // Remove the site name menu
    $wp_admin_bar->remove_menu('view-site');        // Remove the view site link
    $wp_admin_bar->remove_menu('updates');          // Remove the updates link
    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
    // $wp_admin_bar->remove_menu('new-content');      // Remove the content link
    $wp_admin_bar->remove_menu('dashboard');      
    $wp_admin_bar->remove_menu('themes');      
    $wp_admin_bar->remove_menu('widgets');      
    $wp_admin_bar->remove_menu('menus');      
    $wp_admin_bar->remove_menu('customize');      
    $wp_admin_bar->remove_menu('new-post');      
    $wp_admin_bar->remove_menu('new-user');      
    $wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
    // $wp_admin_bar->remove_menu('my-account');       // Remove the user details tab


}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

function remove_customize() {
    $customize_url_arr = array();
    $customize_url_arr[] = 'customize.php'; // 3.x
    $customize_url = add_query_arg( 'return', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'customize.php' );
    $customize_url_arr[] = $customize_url; // 4.0 & 4.1
    if ( current_theme_supports( 'custom-header' ) && current_user_can( 'customize') ) {
        $customize_url_arr[] = add_query_arg( 'autofocus[control]', 'header_image', $customize_url ); // 4.1
        $customize_url_arr[] = 'custom-header'; // 4.0
    }
    if ( current_theme_supports( 'custom-background' ) && current_user_can( 'customize') ) {
        $customize_url_arr[] = add_query_arg( 'autofocus[control]', 'background_image', $customize_url ); // 4.1
        $customize_url_arr[] = 'custom-background'; // 4.0
    }
    foreach ( $customize_url_arr as $customize_url ) {
        remove_submenu_page( 'themes.php', $customize_url );
    }
}
add_action( 'admin_menu', 'remove_customize', 999 );


// logo login form

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo5.png);
        height:100px;
        width:300px;
        background-size: 300px 100px;
        background-repeat: no-repeat;
            padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );
