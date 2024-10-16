<?php
/*
    Template Name: Product Filter Portal

*/
get_header();
?>

<?php
    woocommerce_content();
    $product = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );

    $products = new WP_Query( $product );
?>
<?php if(is_user_logged_in()){ ?>
    <div class="main_container">
        <div class="left_col">

            <div class="search">
                <div class="wrap_search">
                    <div class="heading_container">
                        <div class="search_heading">
                            <h1>Search</h1>
                        </div>
                        <div class="search_image">
                        <div class="log_out">
                            <a href="/my-account/customer-logout/?_wpnonce=c13b28858d"><button>Logout</button></a>
                        </div>
                        </div>
                    </div>


                </div>

            </div>
            <div class = "order_detail_form" id = "capture">
                    <div class="categories_search_btn">
                        <button>Categories Search</button>
                    </div>
                    <div class="text">
                        <h2>OR</h2>
                    </div>
                    <form class = "order_form" action="" method="get">
                            <div class="product_id column" id = "product_id" >
                                <label for="product_id">Search By Charter/Supplier Part Number</label>
                                <input type="text" name="id" Placeholder=" Enter Charter/Supplier Part Number ">
                                <?php
                                $products_id =[];
                                if(isset($_GET["id"])){
                                    $products_id =  explode( "," , ($_GET["id"]) );
                                    $products_id = array_unique( $products_id );
                                }
                                ?>
                            </div>
                        <div class="submit_btn column">
                            <button>Submit</button>
                        </div>

                    </form>
            </div>
            <div class="search_result">
                <div class="wrap_search_result">
                <?php  $i=0; ?>
                <?php foreach($products_id as $product_id){
                    global $product;
                ?>
                <?php foreach( $products->posts as $post){
                    $description = $post->post_content;
                    $sku = (wc_get_product($post) -> sku);
                    $id = $post->ID;
                    $name = $post->post_title;
                    if (($product_id == $sku) || ($product_id == $name)) { ?>
                        <?php $i=$i+1; ?>
                        <?php $product = wc_get_product( $id ); ?>
                        <div class="content">
                            <div class="product_name column">
                                <span class="heading">Supplier Part Number</span>
                                <h2><?php echo $name ?></h2>
                                <span class="heading" >Charter Part Number</span>
                                <p><?php echo $sku ?></p>
                            </div>
                            <div class="product_description column">
                                <h3 class="heading">Description</h3>
                                    <p><?php echo $description ?></p>
                            </div>
                            <div class="manufacturer column">
                                <h3 class="heading" >Manufacture</h3>
                                <img src="<?php  echo   get_the_post_thumbnail_url($post -> ID); ?>" alt="">
                            </div>
                            <div class="add_to_cart column">
                                <?php
                                    global $product;
                                    $product_id = $product->get_id();
                                    $button_text = __('Add to cart', 'woocommerce');
                                    $button_classes = 'button product_type_simple add_to_cart_button ajax_add_to_cart';
                                    $quantity_input = woocommerce_quantity_input( array(), $product, false );
                                    ?>
                                    <form class="cart" method="post" enctype='multipart/form-data'>
                                    <button type="submit" name="add-to-cart" value="<?php echo $product_id; ?>" class="<?php echo $button_classes; ?>"><?php echo $button_text; ?></button>
                                        <?php
                                        //  echo $quantity_input;
                                        ?>
                                    </form>
                            </div>
                        </div>
                    <?php }}} ?>
                    <?php if($i == 0){ ?>
                        <!-- <div class="no_result">
                            <h1>No Result Found</h1>
                        </div> -->
                    <?php } ?>


                </div>

            </div>

<?php  if ( WC()->cart->get_cart_contents_count() >= 1 ) { ?>
            <div class="woocommerce_cart">
                <?php
                    echo do_shortcode( '[woocommerce_cart]' );
                ?>
            </div>
<?php } ?>
            <div class="pdf_btn" >
                <button id="pdf_btn">Downloade PDF</button>
            </div>
        </div>
        <div class="right_col">
            <div class="category_search">
                <div class="cancel_image">
                    <img src="/wp-content/uploads/2023/03/close_1.png" alt="">
                </div>
                <?php
                    $taxonomy = 'product_cat'; // Change this to your custom taxonomy name
                    $terms = get_terms($taxonomy, array('parent' => 0, 'hide_empty' => false)); // Get all the parent terms

                    function getCategoryHierarchy($catId=0, $taxonomy="product_cat", $bEchoList = false ){
                        $cats = null;
                        $args = array(
                            "hide_empty" => 0,
                            "hierarchical" => 1,
                            "taxonomy"=> $taxonomy,
                            "parent" => $catId,
                            'orderby'    => 'ID',
                            'order'      => 'ASC',
                        );

                        $categories = get_categories($args);
                        $last_cat = "2";

                        if(count($categories) > 0){

                            // var_dump(count($categories));
                            if ($bEchoList) echo "<ul>";

                            foreach ($categories as $category) {



                                if ($bEchoList){
                                    echo "<li>".$category->cat_name."</li>";
                                }
                                else{
                                    echo 'last point';
                                }
                                $cats[$category->cat_ID]["product_cat"] =  $category;

                                $children = getCategoryHierarchy($category->cat_ID, $taxonomy, $bEchoList );
                                // var_dump($children);
                                if ($children == null){
                                    // echo "Last One Child";
                                    $_args = array(
                                        'post_type'             => 'product',
                                        'post_status'           => 'publish',
                                        'posts_per_page'        => '-1',
                                        'tax_query'             => array(
                                            array(
                                                'taxonomy'      => 'product_cat',
                                                'terms'         => $category->term_id,
                                            )
                                        )
                                            );
                                        $query = new WP_Query($_args);
                                        if($query->have_posts()){
                                            $_products = $query->get_posts();
                                            // var_dump($_products);
                                            echo "<ul class='products'>";
                                            foreach($_products as $_product){?>
                                                <div class="product">
                                                    <?php
                                                        echo "<li value = '$_product->post_title' >".$_product->post_title."</li>";
                                                        $product_id = $_product->ID;
                                                        $button_text = __('Add to cart', 'woocommerce');
                                                        $button_classes = 'button product_type_simple add_to_cart_button ajax_add_to_cart';
                                                        // $quantity_input = woocommerce_quantity_input( array(), $product, false ); ?>
                                                        <form class="cart" method="post" enctype='multipart/form-data'>
                                                            <button type="submit" name="add-to-cart" value="<?php echo $product_id; ?>" class="<?php echo $button_classes; ?>"><?php echo $button_text; ?></button>
                                                         </form>

                                                </div>

                                            <?php
                                            }
                                            echo "</ul>";
                                        }
                                    // var_dump($category);
                                }
                                if ($children){
                                    $cats[$category->cat_ID]["children"] = $children;
                                }

                            }
                            if ($bEchoList) echo "</ul>";

                            // $last_cat = $categories;
                        }
                        return $cats;
                    }
                    $cat_id = 0; // category id to get (for ALL categories, change to 0 or remove from parameters)
                    $categories = getCategoryHierarchy($cat_id, "product_cat", true );
                ?>
            </div>
        </div>

    </div>

    <div class="product_code">
    </div>

<?php }else{ ?>

    <div class="not_login" style = "" >
        <div class="bacground_image">
            <img src="/wp-content/uploads/2023/03/istockphoto-468184140-1024x1024-transformed.jpeg" alt="">
        </div>
        <h2>Please <a href="/login/">Login</a> Or <a href="h/login/">Sign-up</a>  To Search</h2>

    </div>

<?php } ?>


<?php
get_footer();
?>


