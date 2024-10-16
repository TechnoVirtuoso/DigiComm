<?php

// Remove blog posts from Menu since we are not doing a blog
function remove_posts_menu() {
  remove_menu_page('edit.php');
}
add_action('admin_menu', 'remove_posts_menu');

// Adds SVG support to media
function add_to_upload_mimes( $upload_mimes ) {
  $upload_mimes['svg'] = 'image/svg+xml';
  $upload_mimes['svgz'] = 'image/svg+xml';
  $upload_mimes['ico'] = 'image/x-icon';
  return $upload_mimes;

}
add_filter( 'upload_mimes', 'add_to_upload_mimes', 10, 1 ); 

// Register custom taxonomies
function add_custom_taxonomies() {

  /*register_taxonomy('type', ['recipe', 'product'], array(
    'hierarchical' => true,
    'labels' => array(
      'name' => _x( 'Types', 'taxonomy general name' ),
      'singular_name' => _x( 'Type', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Types' ),
      'all_items' => __( 'All Types' ),
      'parent_item' => __( 'Parent Type' ),
      'parent_item_colon' => __( 'Parent Type:' ),
      'edit_item' => __( 'Edit Type' ),
      'update_item' => __( 'Update Type' ),
      'add_new_item' => __( 'Add New Type' ),
      'new_item_name' => __( 'New Type Name' ),
      'menu_name' => __( 'Types' ),
    ),
    'rewrite' => array(
      'slug' => 'types',
      'with_front' => false, 
      'hierarchical' => true
    ),
  ));*/
}

add_action( 'init', 'add_custom_taxonomies', 0 );


// Register Post Types
function create_customContentTypes() {

  // Create Global Block content type
  register_post_type( 'globalblock',
    array(
      'labels' => array(
        'name' => __( 'Global Blocks' ),
        'singular_name' => __( 'Global Block' ),
        'all_items' => __('All Global Blocks'),
        'view_item' => __('View Global Block'),
        'add_new' => __('Add New Global Block'),
        'add_new_item' => __('Add Global Block'),
        'edit_item' => __('Edit Global Block'),
        'update_item' => __('Update Global Block'),
        'search_items' => __('Search Global Blocks')
      ),
      'menu_icon' => 'dashicons-admin-site',
      'public' => true,
      'publicly_queryable'  => false,
      'has_archive' => true,
      'rewrite' => array('slug' => 'globalblock'),
      'supports' => array( 'title'),
    )
  );
 

  add_theme_support( 'post-thumbnails' );  

}
add_action( 'init', 'create_customContentTypes' );

if( function_exists('acf_add_options_page') ) {
  
    // Adds Theme Options Page
    acf_add_options_page(array(
        'page_title'     => 'Theme General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'        => false,
        'position' => '42',
    ));

    // Add Navigation Page
    acf_add_options_page(array(
      'page_title'     => 'Navigation',
      'menu_title'    => 'Navigation',
      'menu_slug'     => 'navigation',
      'capability'    => 'edit_posts',
      'redirect'        => false,
      'position' => '40',
      'icon_url' => 'dashicons-menu-alt',
      
  ));
}





function compareByName($a, $b) {
  return strcmp($a->name, $b->name);
}

function get_terms_by_post_type( $taxonomies, $post_types ) {

  global $wpdb;

  $query = $wpdb->prepare(
      "SELECT t.*, COUNT(*) from $wpdb->terms AS t
      INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
      INNER JOIN $wpdb->term_relationships AS r ON r.term_taxonomy_id = tt.term_taxonomy_id
      INNER JOIN $wpdb->posts AS p ON p.ID = r.object_id
      WHERE p.post_type IN('%s') AND tt.taxonomy IN('%s')
      GROUP BY t.term_id",
      join( "', '", $post_types ),
      join( "', '", $taxonomies )
  );

  $results = $wpdb->get_results( $query );

  usort($results, 'compareByName');

  return $results;

}

add_post_type_support( 'page', 'excerpt' );



function add_superandsubscript($buttons) {  
    array_push($buttons, 'superscript');
    array_push($buttons, 'subscript');
    return $buttons;
}
add_filter('mce_buttons', 'add_superandsubscript');
    

// disable xmlrpc
function remove_xmlrpc_methods( $methods ) {
    return array();
}
add_filter( 'xmlrpc_methods', 'remove_xmlrpc_methods' );


add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
   add_theme_support( 'woocommerce' );
}   


// Redirect users to the home page after registration
function custom_registration_redirect() {
  wp_redirect( home_url() );
  exit;
}
add_action( 'woocommerce_registration_redirect', 'custom_registration_redirect' );

// Redirect users to the home page after login
function custom_login_redirect() {
  wp_redirect( home_url() );
  exit;
}
add_filter( 'woocommerce_login_redirect', 'custom_login_redirect' );



// function delete_all_products() {
//   $args = array(
//       'post_type' => 'product',
//       'posts_per_page' => -1, // Get all posts
//   );
//   $products = get_posts($args);
//   foreach($products as $product) {
//       wp_delete_post($product->ID, true);
//   }
// }

// add_action('init', 'delete_all_products');



// function import_properties_from_json() {
//    $url = 'https://onlinedemoserver4.com/digicomm_product_data.json';
//   $json = file_get_contents($url);
//   $properties = json_decode($json, true);

//   foreach ($properties as $property) {

//       $title = $property['Supplier Part Number'];
//       $post_id = property_exists_in_wordpress($title);
//       $post_data = array(
//           'post_title' => $title,
//           'post_type' => 'product',
//           'post_status' => 'publish',
//       );

//       if ($post_id) {
//           $post_data['ID'] = $post_id;
//       }

//       $post_id = wp_insert_post($post_data);

//        update_post_meta( $post_id, '_regular_price', $property['Charter Price'] );
//        update_post_meta( $post_id, '_price', $property['Charter Price'] );
//        update_post_meta( $post_id, '_sku', $property['Charter Part Number'] );
//       //  update_post_meta($post_id, 'address', $property['address']);
//       // update_post_meta($post_id, 'price', $property['price']);
//       // update_post_meta($post_id, 'bedrooms', $property['bedrooms']);
//       // update_post_meta($post_id, 'bathrooms', $property['bathrooms']);
//       // add more fields here

//   }

//   delete_missing_properties($properties);
// }

// function property_exists_in_wordpress($title) {
//   global $wpdb;

//   $query = "SELECT ID FROM {$wpdb->posts} WHERE post_title = %s AND post_type = 'product'";
//   $post_id = $wpdb->get_var($wpdb->prepare($query, $title));

//   return $post_id;
// }

// function delete_missing_properties($properties) {
//   global $wpdb;

//   $query = "SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type = 'product'";
//   $posts = $wpdb->get_results($query);

//   foreach ($posts as $post) {
//       $title = $post->post_title;

//       if (!property_exists_in_array($title, $properties)) {
//           wp_delete_post($post->ID);
//       }
//   }
// }

// function property_exists_in_array($title, $properties) {
//   foreach ($properties as $property) {
//       if ($property['Supplier Part Number'] == $title) {
//           return true;
//       }
//   }

//   return false;
// }

// import_properties_from_json();

// function scratchcode_run_code_one_time() {
//   if ( !get_option('run_only_once_01') ):

//     import_properties_from_json();

//       add_option('run_only_once_01', 1); 
//   endif;
// }
// add_action( 'init', 'scratchcode_run_code_one_time' );

// function delete_duplicate_products() {
//   global $wpdb;
//   $duplicates = $wpdb->get_results("
//       SELECT post_title, COUNT(*) 
//       FROM {$wpdb->prefix}posts 
//       WHERE post_type = 'product' 
//       GROUP BY post_title 
//       HAVING COUNT(*) > 1
//   ");

//   foreach ($duplicates as $duplicate) {
//       $product_ids = $wpdb->get_col("
//           SELECT ID 
//           FROM {$wpdb->prefix}posts 
//           WHERE post_title = '$duplicate->post_title' 
//           AND post_type = 'product'
//       ");

//       // Keep the first product and delete the rest
//       $first_product = array_shift($product_ids);
//       foreach ($product_ids as $product_id) {
//           wp_delete_post($product_id, true);
//       }
//   }
// }
// add_action('admin_init', 'delete_duplicate_products');



?>