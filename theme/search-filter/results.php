<?php
/**
 * Search & Filter Pro 
 *
 * Sample Results Template
 * 
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 * 
 * Note: these templates are not full page templates, rather 
 * just an encaspulation of the your results loop which should
 * be inserted in to other pages by using a shortcode - think 
 * of it as a template part
 * 
 * This template is an absolute base example showing you what
 * you can do, for more customisation see the WordPress docs 
 * and using template tags - 
 * 
 * http://codex.wordpress.org/Template_Tags
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $query->have_posts() )
{
	?>

	<p class="product_found" >  Found <?php echo $query->found_posts; ?> Results </p>
	<!-- <p class="page_no" > Page <?php echo $query->query['paged']; ?> of <?php echo $query->max_num_pages; ?></p> -->
	
	<div class="pagination">
	
		
		<div class="nav-previous"><?php next_posts_link( 'Older posts', $query->max_num_pages ); ?></div>
		<div class="nav-next"><?php previous_posts_link( 'Newer posts' ); ?></div>
		<?php
			/* example code for using the wp_pagenavi plugin */
			if (function_exists('wp_pagenavi'))
			{
				echo "<br />";
				wp_pagenavi( array( 'query' => $query ) );
			}
		?>
	</div>
	<div class ="result_table">
	<?php
	while ($query->have_posts())
	{
		$query->the_post();
		
		?>
		
			<!-- <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> -->
			<div class="content">
				<h2 class= "category_heading"><?php the_title(); ?></h2>
				<div class="details">
					<div class="description">
						<h3>Description:</h3>
						<p><?php the_excerpt(); ?></p>
					</div>
						
					<?php 
					?>
					<p><?php the_category(); ?></p>
					<p><?php the_tags(); ?></p>
					<!-- <p><small><?php the_date(); ?></small></p> -->
				</div>		
				<div class="select_btn">
					<button  value="<?php echo get_the_title();?>">Select</button>
				</div>
			</div>
		
			
			
			<hr />
			<?php
	}
	?>
	</div>
	<p class="page_no">Page <?php echo $query->query['paged']; ?> of <?php echo $query->max_num_pages; ?></p>
	
	<div class="pagination">
		
		<div class="nav-previous"><?php next_posts_link( 'Older posts', $query->max_num_pages ); ?></div>
		<div class="nav-next"><?php previous_posts_link( 'Newer posts' ); ?></div>
		<?php
			/* example code for using the wp_pagenavi plugin */
			if (function_exists('wp_pagenavi'))
			{
				echo "<br />";
				wp_pagenavi( array( 'query' => $query ) );
			}
		?>
	
		
	</div>
	<div class="search_select">
	<div class="search_select_wrap">
		<form action="" method="post" class="search_form">
			<input id="search_select" name = "selected_item" type="text" placeholder="Selected Search Item">
			<div class="select_submit_btn">
				<button >Add to Cart</button>
			</div>
		</form>
		
	</div>
	<?php 
	// var_dump($_POST['selected_item']); 
	?>
	<?php

		$product = array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'posts_per_page' => -1,
		);
		$products = new WP_Query( $product );
		if(isset($_POST['selected_item'])){
			$products_id =  explode( "," , ($_POST['selected_item']) );
			$products_id = array_unique( $products_id );
		} 
						
		foreach($products_id as $product_id){
			foreach( $products->posts as $post){
				$sku = (wc_get_product($post) -> sku);
				$id = $post->ID;
				$name = $post->post_title;
				if (($product_id == $sku) || ($product_id == $name)) {
					WC()->cart->add_to_cart( $id );
				}
				}
							
				}


    ?>
						
    
</div>



	<?php
}
else
{
	echo "No Results Found";
}
?>




<script>
	
</script>