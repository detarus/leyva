<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

$filter_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none"><path d="M18.5 15L12.5 9L6.5 15" stroke="#BE3155" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
$filter_cross = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M7 16.9972L17 7M7 7L17 16.9972" stroke="#BE3155" stroke-width="1.5" stroke-linecap="round"/></svg>';

?>

<header class="wc-products-header">
	<div class="container container-wc-head">

		<?php 
			/**
			 * Hook: woocommerce_archive_description.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>

		<div class="wc-breadcrumb-shop">
			<?php woocommerce_breadcrumb(array(
				'delimiter'   => '<span class="bread-del">/</span>',
				'wrap_before' => '<nav class="woocommerce-breadcrumb">',
				'wrap_after'  => '</nav>',
				'before'      => '',
				'after'       => '',
				'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
			) ); ?>
		</div>
		<?php 
			if ( apply_filters( 'woocommerce_show_page_title', true ) ){
				if(woocommerce_page_title(false) == 'Catalog'){
					$page_title = 'All wallets';
				} else {
					$page_title = woocommerce_page_title(false);
				}
				echo '<h1 class="wc-products-header__title page-title">' . $page_title . '</h1>';
			} 
		?>
	</div>
</header>
<div class="container container-wc-shop">
	<div class="shop-loader-block">
		<span class="shop-loader"></span>
	</div>
	
	<?php 

	if ( woocommerce_product_loop() ) {

		/**
		 * Hook: woocommerce_before_shop_loop.
		 *
		 * @hooked woocommerce_output_all_notices - 10
		 * @hooked woocommerce_result_count - 20
		 * @hooked woocommerce_catalog_ordering - 30
		 */
		do_action( 'woocommerce_before_shop_loop' );
		
		woocommerce_product_loop_start();

		if ( wc_get_loop_prop( 'total' ) ) {
			while ( have_posts() ) {
				the_post();

				/**
				 * Hook: woocommerce_shop_loop.
				 */
				do_action( 'woocommerce_shop_loop' );

				wc_get_template_part( 'content', 'product' );
			}
		}
		?>
			<div page="1" class="wc-button-more-block">
				<button class="wc-shop-more-button" type="button">Load More Product</button>
			</div>
		<?php
		woocommerce_product_loop_end();

		/**
		 * Hook: woocommerce_after_shop_loop.
		 *
		 * @hooked woocommerce_pagination - 10
		 */
		do_action( 'woocommerce_after_shop_loop' );
	} else {
		/**
		 * Hook: woocommerce_no_products_found.
		 *
		 * @hooked wc_no_products_found - 10
		 */
		do_action( 'woocommerce_no_products_found' );
	}

	if (is_active_sidebar('sidebar-woo')): ?>
		<div class="wc-shop-sidebar">
			<div class="wc-shop-filters__block">
				<div class="wc-shop-filter__cats">
					<h5 class="wc-filter-title">Categories <?php echo $filter_svg; ?></h5>
					<div class="wc-filter-content" style="display: none;">
						<ul class="wc-filter-list">
							<?php 
								$args = array(
									'taxonomy'   => "product_cat",
								);
								$product_categories = get_terms($args);
								foreach($product_categories as $cat){
									$name = $cat->name;
									$slug = $cat->slug;
									$link = get_term_link( $cat->term_id, 'product_cat' );
									if(get_queried_object()->name == $name){
										echo '<li class="wc-filter-list__title"><input type="radio" checked class="wc-filter-radio-input" id="radio-cat--' . $slug . '" name="radio-cat-filter" value="' . $slug . '"><label class="wc-filter-radio-label" for="radio-cat--' . $slug . '">' . $name . '</label></li>';
									} else {
										echo '<li class="wc-filter-list__title"><input type="radio" class="wc-filter-radio-input" id="radio-cat--' . $slug . '" name="radio-cat-filter" value="' . $slug . '"><label class="wc-filter-radio-label" for="radio-cat--' . $slug . '">' . $name . '</label></li>';
									}
								}
							?>
							
						</ul>
					</div>
				</div>
				<div class="wc-shop-filter__sort">
					<h5 class="wc-filter-title">Sort by <?php echo $filter_svg; ?></h5>
					<div class="wc-filter-content" style="display: none;">
						<ul class="wc-filter-list">
							<li class="wc-filter-list__title"><input type="radio" checked class="wc-filter-radio-input" id="radio-sort-default" name="radio-sort-filter" value="menu_order"><label class="wc-filter-radio-label" for="radio-sort-default">Default sorting</label></li>
							<li class="wc-filter-list__title"><input type="radio" class="wc-filter-radio-input" id="radio-sort-popularity" name="radio-sort-filter" value="popularity"><label class="wc-filter-radio-label" for="radio-sort-popularity">Sort by popularity</label></li>
							<li class="wc-filter-list__title"><input type="radio" class="wc-filter-radio-input" id="radio-sort-rating" name="radio-sort-filter" value="rating"><label class="wc-filter-radio-label" for="radio-sort-rating">Sort by average rating</label></li>
							<li class="wc-filter-list__title"><input type="radio" class="wc-filter-radio-input" id="radio-sort-date" name="radio-sort-filter" value="date"><label class="wc-filter-radio-label" for="radio-sort-date">Sort by latest</label></li>
							<li class="wc-filter-list__title"><input type="radio" class="wc-filter-radio-input" id="radio-sort-price" name="radio-sort-filter" value="price"><label class="wc-filter-radio-label" for="radio-sort-price">Sort by price: low to high</label></li>
							<li class="wc-filter-list__title"><input type="radio" class="wc-filter-radio-input" id="radio-sort-price-desc" name="radio-sort-filter" value="price-desc"><label class="wc-filter-radio-label" for="radio-sort-price-desc">Sort by price: high to low</label></li>
						</ul>
					</div>
				</div>
				<div class="wc-shop-filter__filters">
					<h5 class="wc-filter-title wc-filter-title--main">Filters <?php echo $filter_svg; ?><a class="wc-filters-close" href="#"><?php echo $filter_cross; ?></a></h5>
					<div class="wc-filter-content wc-filter-content--flex" style="display: none;">
						<h5 class="wc-filter-subtitle">Material <?php echo $filter_svg; ?></h5>
						<?php 
							$terms = get_terms([
								'taxonomy' => 'pa_material',
								'hide_empty' => false,
							]);
							$taxonomy = '';
							foreach($terms as $key => $term){
								$taxonomy .= '<li class="wc-filter-list__title wc-filter-list--flex"><input class="wc-filter-checkbox" type="checkbox" term="' . $term->slug . '" name="' . $term->slug . '" id="pa_material--' . $term->term_id . '"/><label for="pa_material--' . $term->term_id . '">' . $term->name . '</label></li>';
							}
						?>
						<ul class="wc-filter-list" taxonomy="pa_material" style="display: none;">
							<?php echo $taxonomy; ?>
						</ul>
						<h5 class="wc-filter-subtitle">Color <?php echo $filter_svg; ?></h5>
						<?php 
							$terms = get_terms([
								'taxonomy' => 'pa_color',
								'hide_empty' => false,
							]);
							$taxonomy = '';
							foreach($terms as $key => $term){
								$taxonomy .= '<li class="wc-filter-list__title wc-filter-list--flex"><input class="wc-filter-checkbox" term="' . $term->slug . '" type="checkbox" name="' . $term->slug . '" id="pa_color--' . $term->term_id . '"/><label for="pa_color--' . $term->term_id . '">' . $term->name . '</label></li>';
							}
						?>
						<ul class="wc-filter-list" taxonomy="pa_color" style="display: none;">
							<?php echo $taxonomy; ?>
						</ul>
						<h5 class="wc-filter-subtitle">Price <?php echo $filter_svg; ?></h5>
						<input class="wc-filter-input-range" type="text" id="amount" readonly="" style="display: none;">
						<div class="wc-slide-body" id="slider-range" style="display: none;"></div>
						<h5 class="wc-filter-subtitle">Size <?php echo $filter_svg; ?></h5>
						<?php 
							$terms = get_terms([
								'taxonomy' => 'pa_size',
								'hide_empty' => false,
							]);
							$taxonomy = '';
							foreach($terms as $key => $term){
								$taxonomy .= '<li class="wc-filter-list__title wc-filter-list--flex"><input class="wc-filter-checkbox" type="checkbox" term="' . $term->slug . '" name="' . $term->slug . '" id="pa_size--' . $term->term_id . '"/><label for="pa_size--' . $term->term_id . '">' . $term->name . '</label></li>';
							}
						?>
						<ul class="wc-filter-list" taxonomy="pa_size" style="display: none;">
							<?php echo $taxonomy; ?>
						</ul>
						<a class="wc-filters-reset" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">Reset all</a>
					</div>
				</div>
				<a class="wc-filters-reset wc-filters-reset--mob" href=""<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">Reset all</a>
			</div>
			<form class="wc-filters-form">
				<h5 class="wc-filters-form__title">Subscribe! Lorem ipsum dolor sit amet</h5>
				<input class="input-wc-filters" type="email" placeholder="Email">
				<button class="btn-wc-filters" type="sudmit">Subscribe</button>
				<label class="label-wc-formn-filters" for="wc-filter-personal"><input required class="checkbox-wc-formn-filters" id="wc-filter-personal" type="checkbox">by filling in the form, you agree to the processing of personal data</label>
			</form>
			<?php dynamic_sidebar('sidebar-woo'); ?>
			<h2 class="wc-shop-second-title"><?php echo $page_title; ?></h2>
			<div class="mobile-filter-block">
				<a class="open-mob-filters" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M22.125 7.875H1.875C1.57663 7.875 1.29048 7.75647 1.0795 7.5455C0.868526 7.33452 0.75 7.04837 0.75 6.75C0.75 6.45163 0.868526 6.16548 1.0795 5.9545C1.29048 5.74353 1.57663 5.625 1.875 5.625H22.125C22.4234 5.625 22.7095 5.74353 22.9205 5.9545C23.1315 6.16548 23.25 6.45163 23.25 6.75C23.25 7.04837 23.1315 7.33452 22.9205 7.5455C22.7095 7.75647 22.4234 7.875 22.125 7.875ZM18.375 13.125H5.625C5.32663 13.125 5.04048 13.0065 4.8295 12.7955C4.61853 12.5845 4.5 12.2984 4.5 12C4.5 11.7016 4.61853 11.4155 4.8295 11.2045C5.04048 10.9935 5.32663 10.875 5.625 10.875H18.375C18.6734 10.875 18.9595 10.9935 19.1705 11.2045C19.3815 11.4155 19.5 11.7016 19.5 12C19.5 12.2984 19.3815 12.5845 19.1705 12.7955C18.9595 13.0065 18.6734 13.125 18.375 13.125ZM13.875 18.375H10.125C9.82663 18.375 9.54048 18.2565 9.3295 18.0455C9.11853 17.8345 9 17.5484 9 17.25C9 16.9516 9.11853 16.6655 9.3295 16.4545C9.54048 16.2435 9.82663 16.125 10.125 16.125H13.875C14.1734 16.125 14.4595 16.2435 14.6705 16.4545C14.8815 16.6655 15 16.9516 15 17.25C15 17.5484 14.8815 17.8345 14.6705 18.0455C14.4595 18.2565 14.1734 18.375 13.875 18.375Z" fill="white"/></svg></a>
				<select class="filter-sort-mobile" name="filter-sort-mobile" id="filter-sort-mobile">
					<option selected="true" disabled="disabled" value="menu_order">Sort By</option>
					<option value="menu_order">Default sorting</option>
					<option value="popularity">Sort by popularity</option>
					<option value="rating">Sort by average rating</option>
					<option value="date">Sort by latest</option>
					<option value="price">Sort by price: low to high</option>
					<option value="price-desc">Sort by price: high to low</option>
				</select>
			</div>
		</div>
	<?php endif;

	/**
	 * Hook: woocommerce_after_main_content.
	 *
	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	do_action( 'woocommerce_after_main_content' );

	/**
	 * Hook: woocommerce_sidebar.
	 *
	 * @hooked woocommerce_get_sidebar - 10
	 */
	do_action( 'woocommerce_sidebar' );

	get_footer( 'shop' );

	?>
</div>