<?php

/**
 * Contains :
 * custom post types
    * Business Type - business_page

 *
 * @link https://github.com/kdemi/business-services-child-theme
 *
 * @package business-services-child-theme
 */
/**
 *  Create Custom Post Types
 *
 * Additional custom post types can be defined here
 * http://codex.wordpress.org/Post_Types
 *
 * @link https://github.com/kdemi/business-services-child-theme
 *
 *
 */

 /*-----------------------------------------------------------------------------------*/
 /*	enqueue styles
 /*-----------------------------------------------------------------------------------*/


 add_action( 'init', 'theme_enqueue_styles' );
 function theme_enqueue_styles() {
 if(!is_admin()){
     wp_dequeue_style('pkt-style');
     wp_enqueue_style( 'pkt-style', get_template_directory_uri() . '/style.css');
     wp_enqueue_style( 'child-style', get_stylesheet_uri(), array('pkt-style'));
 }
 }

 /*-----------------------------------------------------------------------------------*/
 /*	Custom Post Types
 /*-----------------------------------------------------------------------------------*/


if (!class_exists('BusinessServicesCustomPostTypes')){
    class BusinessServicesCustomPostTypes{
        function create_business_post_type() {
          register_post_type( 'business_page',
            array(
                'labels' => array(
                    'name' => __( 'Business Type' ),
                    'singular_name' => __( 'Business Type' ),
                    'add_new'   => __('Add Business Type Page'),
                    'all_items'   => __('All Business Type Pages'),
                    'add_new_item' => __('Add Business Type Page'),
                    'edit_item'   => __('Edit Business Type Page'),
                    'view_item'   => __('View Business Type Page'),
                    'search_items'   => __('Search Business Type Pages'),
                    'not_found'   => __('Business Type Page Not Found'),
                    'not_found_in_trash'   => __('Business Type Page not found in trash'),
              ),
                'taxonomies' => array('category'),
                'public' => true,
                'has_archive' => true,
                'menu_position' => 5,
                'menu_icon' => 'dashicons-store',
                'hierarchical' => true,
                'rewrite' => array(
                    'slug' => 'business',
                ),
            )
          );
        }

    }//end class

}


if (class_exists("BusinessServicesCustomPostTypes")){
    $custom_post_types = new BusinessServicesCustomPostTypes();
}

if (isset($custom_post_types)){
    //actions
    add_action( 'init', array($custom_post_types, 'create_business_post_type'));

    register_activation_hook( __FILE__, array($custom_post_types, 'rewrite_flush') );
}

/*-----------------------------------------------------------------------------------*/
/*	Create Custom Taxonomies
/*-----------------------------------------------------------------------------------*/

if (!class_exists('BusinessServicesTaxonomy')){
    class BusinessServicesTaxonomy{
      function create_content_type_tax() {

        $labels = array(
          'name'                       => 'Content Types',
          'singular_name'              => 'Content Type',
          'menu_name'                  => 'Content Types',
          'all_items'                  => 'All Content Types',
          'parent_item'                => 'Parent Item',
          'parent_item_colon'          => 'Parent Item:',
          'new_item_name'              => 'New Content Types',
          'add_new_item'               => 'Add New Content Type',
          'edit_item'                  => 'Edit Content Type',
          'update_item'                => 'Update Content Type',
          'separate_items_with_commas' => 'Separate items with commas',
          'search_items'               => 'Search Items',
          'add_or_remove_items'        => 'Add or remove items',
          'choose_from_most_used'      => 'Choose from the most used items',
          'not_found'                  => 'Not Found'
        );
        $args = array(
          'labels'                     => $labels,
          'hierarchical'               => true,
          'public'                     => true,
          'show_ui'                    => true,
          'show_admin_column'          => true,
          'show_in_nav_menus'          => true
        );
        register_taxonomy( 'content_type', array( 'post' ), $args );
      }
    }//end class
  }

if (class_exists("BusinessServicesTaxonomy")){
    $custom_taxonomy = new BusinessServicesTaxonomy();
}
if (isset($custom_taxonomy)){
    //actions
    add_action( 'init', array($custom_taxonomy, 'create_content_type_tax'), 0);
}
/*-----------------------------------------------------------------------------------*/
/*	Remove unnecessary post types
/*-----------------------------------------------------------------------------------*/

function remove_medical_press_theme_features() {
   // remove Movie Custom Post Type
//   remove_action( 'init', 'create_doctor_post_type' );
//   remove_action( 'init', 'create_gallery_post_type' );
//   remove_action( 'init', 'create_testimonial_post_type' );
//   remove_action( 'init', 'create_service_post_type' );

   //remove theme support for post formats
   remove_theme_support('post-formats');
}

add_action( 'after_setup_theme', 'remove_medical_press_theme_features', 11 );



/*-----------------------------------------------------------------------------------*/
/*	Remove tags
/*-----------------------------------------------------------------------------------*/

function unregister_taxonomy(){
    register_taxonomy('post_tag', array());
}
add_action('init', 'unregister_taxonomy');


/*-----------------------------------------------------------------------------------*/
/*	Register Taxonomy for Media
/*-----------------------------------------------------------------------------------*/
function business_register_taxonomy_for_images() {
    register_taxonomy_for_object_type( 'category', 'attachment' ); 
	register_taxonomy_for_object_type( 'content_type', 'attachment' );
}
add_action( 'init', 'business_register_taxonomy_for_images' );


/*-----------------------------------------------------------------------------------*/
/*	Add cateogry filter to Media
/*-----------------------------------------------------------------------------------*/
function business_add_image_category_filter() {
    $screen = get_current_screen();
    if ( 'upload' == $screen->id ) {
        $dropdown_options = array( 'show_option_all' => __( 'View all categories', 'olab' ), 'hide_empty' => false, 'hierarchical' => true, 'orderby' => 'name', );
        wp_dropdown_categories( $dropdown_options );
    }
}
add_action( 'restrict_manage_posts', 'business_add_image_category_filter' );



/*-----------------------------------------------------------------------------------*/
/*	enqueue styles/scripts
/*-----------------------------------------------------------------------------------*/
function business_scripts() {
  wp_enqueue_script( 'custom_js', get_stylesheet_directory_uri() . '/js/scripts.js', array(), '0.1', true );
}

add_action( 'wp_enqueue_scripts', 'business_scripts' );

/*-----------------------------------------------------------------------------------*/
/*	add business page sidebar
/*-----------------------------------------------------------------------------------*/

add_action( 'widgets_init', 'business_widgets_init' );
function business_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Business Page Sidebar', 'business' ),
        'id' => 'sidebar_business',
        'description' => __( 'Widgets in this area will be shown on Business Type Pages.', 'business' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s gdlr-item gdlr-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="gdlr-widget-title">',
        'after_title'   => '</h3><div class="clear"></div>'
        )
    );
}
