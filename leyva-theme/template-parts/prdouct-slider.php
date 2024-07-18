<div class="wc-cart-ret-products">
	<h2 class="product-home-title">You may also like</h2>
	<div class="product-home-swiper swiper">
		<div class="product-home-wrapper swiper-wrapper">
			<?php 
				$args = array(
					'limit' => 10,
					'orderby' => 'date',
					'order' => 'DESC'
				);

				$query = new WC_Product_Query($args);
				$products = $query->get_products();

				if(!empty($products)){
					foreach ($products as $product) {						
						$link = get_permalink($product->get_id());
						$img_link = wp_get_attachment_url($product->get_image_id());
						$slug = $product->post_name;
						$title = $product->get_title();
						if($product->get_short_description()){
							$desc = $product->get_short_description();
						} else {
							$desc = get_the_excerpt($product->get_id());
						}
						$price = $product->get_price();
						$atrs = $product->get_attributes();
						$color_icons = '';
						foreach($atrs as $atr){
							if($atr->get_data()['name'] == 'pa_color') $colors = $atr->get_data();
						}
						foreach($colors['options'] as $color){
							$color_icons .= ' <img src="' . get_field('product_att_img', 'pa_color_' . $color) . '" alt="color-product">';
						}
						?>
							<div class="product-wrap swiper-slide">
								<a class="product-img-link" href="<?php echo $link; ?>">
									<img src="<?php echo $img_link; ?>" alt="<?php echo $slug; ?>">
								</a>
								<div class="product-content-block">
									<span class="product-block-color">Color: <?php echo $color_icons; ?></span>
									<a class="product-block-title" href="<?php echo $link; ?>"><?php echo $title; ?></a>
									<?php 
										if($desc){
											echo '<span class="product-block-desc">' . $desc .'</span>';
										}
									?>
									<span class="product-block-price"><?php echo $price . ' ' . get_woocommerce_currency_symbol(); ?></span>
								</div>
								<a class="product-swiper-add-cart" href="<?php echo $product->add_to_cart_url(); ?>">Add to cart</a>
							</div>
							
						<?php
					}
				}
			?>
		</div>
		<div class="home-products-arrows">
			<div class="home-products-next"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#BE3155"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#BE3155" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 16L16 12L12 8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8 12H16" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>
			<div class="home-products-prev"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#BE3155"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#BE3155" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 16L16 12L12 8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8 12H16" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>
		</div>
		<div class="home-products-swiper-pagination"></div>
	</div>
</div>
