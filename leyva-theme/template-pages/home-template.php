<?php

/**
 * Template Name: Home Page
 * @package Leyva
 */

get_header();

$arrow_white = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 16L16 12L12 8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 12H16" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
$arrow_black = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#101010" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 16L16 12L12 8" stroke="#101010" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 12H16" stroke="#101010" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
$arrow_rose = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#BE3155"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#BE3155" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 16L16 12L12 8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8 12H16" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>';
?>

<section class="s-home-hero">
	<div class="container container-home-hero">
		<img class="home-bg" src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-post-thumbnail')[0]; ?>" alt="home-background">
		<div class="hero-home-wrapper">
			<div class="hero-home-left">
				<h1 class="home-hero__title"><?php if(get_field('home_hero_fields')['home_hero_title']) echo get_field('home_hero_fields')['home_hero_title']; else echo 'Value Proposition';?></h1>
				<p class="hero-home-paragraph"><?php if(get_field('home_hero_fields')['home_hero_p']) echo get_field('home_hero_fields')['home_hero_p']; else echo 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';?></p>
				<a class="hero-home-link link-btn" href="<?php if(get_field('home_hero_fields')['home_link_url']) echo get_field('home_hero_fields')['home_link_url']; else echo wc_get_page_permalink('shop'); ?>"><?php if(get_field('home_hero_fields')['hero_link_title']) echo get_field('home_hero_fields')['hero_link_title']; else echo 'Go to Catalog';?></a>
			</div>
			<div class="hero-home-right">
				<img class="hero-home-img" src="<?php if(get_field('home_hero_fields')['home_hero_img']) echo get_field('home_hero_fields')['home_hero_img']; else echo get_template_directory_uri() . '/assets/img/hero-home-wallet.jpg'; ?>" alt="hero-wallet">
			</div>
		</div>
	</div>
</section>
<?php if(get_field('on_home_catalog')): ?>
	<section class="s-product-home">
		<div class="container container-product-home">
			<div class="home-product-head">
				<h2 class="product-home-title"><?php if(get_field('home_catalog_title')) echo get_field('home_catalog_title'); else echo 'New Arrivals (or Popular)';?></h2>
				<a class="product-home-link full-home-link" href="<?php echo wc_get_page_permalink('shop'); ?>"><?php if(get_field('home_catalog_link_title')) echo get_field('home_catalog_link_title'); else echo 'All Wallets';?></a>
			</div>
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
								$desc = $product->get_short_description();
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
									</div>
									
								<?php
							}
						}
					?>
				</div>
				<div class="home-products-arrows">
					<div class="home-products-next"><?php echo $arrow_rose; ?></div>
					<div class="home-products-prev"><?php echo $arrow_rose; ?></div>
				</div>
				<div class="home-products-swiper-pagination"></div>
			</div>
			<a class="product-home-link full-home-link full-home-link--mobile" href="<?php echo wc_get_page_permalink('shop'); ?>"><?php if(get_field('home_catalog_link_title')) echo get_field('home_catalog_link_title'); else echo 'All Wallets';?></a>
		</div>
	</section>
<?php endif; ?>
<?php if(get_field('on_home_cats')): ?>
	<section class="s-cats-home">
		<div class="container container-cats-home">
			<h2 class="cats-home-title"><?php if(get_field('home_cats_title')) echo get_field('home_cats_title'); else echo 'Categories';?></h2>
			<div class="cats-home-swiper swiper">
				<div class="cats-home-wrapper swiper-wrapper">
					<?php 
						$args = array(
							'taxonomy'   => "product_cat",
							'number'     => $number,
							'orderby'    => $orderby,
							'order'      => $order,
							'hide_empty' => $hide_empty,
							'include'    => $ids
						);
						$product_categories = get_terms($args);
						foreach($product_categories as $cat){
							$image = '<img src="' . wp_get_attachment_url(get_term_meta($cat->term_id, 'thumbnail_id', true)) . '" alt="' . $slug . '" />';
							$name = $cat->name;
							$slug = $cat->slug;
							$link = get_term_link( $cat->term_id, 'product_cat' );

							echo '<div class="swiper-slide home-single-cat-content">' . $image . '<a class="home-single-cat-link" href="' . $link . '">' . $name . $arrow_white . '</a></div>';
						}
					?>
					
				</div>
				<div class="home-cats-arrows">
					<div class="home-cats-next"><?php echo $arrow_rose; ?></div>
					<div class="home-cats-prev"><?php echo $arrow_rose; ?></div>
				</div>
				<div class="home-cats-swiper-pagination"></div>
			</div>
			<a class="product-home-link full-home-link full-home-link--mobile" href="<?php echo wc_get_page_permalink('shop'); ?>"><?php if(get_field('home_cats_link_title')) echo get_field('home_cats_link_title'); else echo 'All Categories';?></a>
		</div>
	</section>
<?php endif; ?>
<?php if(get_field('on_home_feats')): ?>
	<section class="s-home-features">
		<div class="container container-home-feat">
			<h2 class="feat-home-title"><?php if(get_field('home_feat_group')['home_feat_title']) echo get_field('home_feat_group')['home_feat_title']; else echo 'Why we are perfect match';?></h2>
			<div class="feat-home-wrapper">
				<?php 
					$left = '';
					$right = '';
					foreach(get_field('home_feat_group')['features_rep'] as $key => $feat){
						if(!wp_is_mobile() && ($key == 0)) $active = 'active'; else $active = '';
						$left .= '<a class="feat-home-link ' . $active . '" id="feat-link--' . $key + 1 . '" href="#">' . $feat['home_feat_title'] . $arrow_black . '</a><div class="feat-home-content--mobile active"><div class="feat-img-block"><img src="' . $feat['home_feat_img'] . '" alt="feature-img"></div><div class="feat-home-content--text"><p class="feat-home-main-text">' . $feat['home_feat_subtitle'] . '</p><span class="feat-home-desc">' . $feat['home_feat_desc'] . '</span></div></div>';
						$right .= '<div id="feat-cont--' . $key + 1 . '" class="feat-home-content ' . $active . '"><div class="feat-img-block"><img src="' . $feat['home_feat_img'] . '" alt="feature-img"></div>
						<div class="feat-home-content--text"><p class="feat-home-main-text">' . $feat['home_feat_subtitle'] . '</p><span class="feat-home-desc">' . $feat['home_feat_desc'] . '</span></div></div>';
					}

					echo '<div class="feat-home-left">' . $left . '</div><div class="feat-home-right">' . $right . '</div>';
				?>
			</div>
		</div>
	</section>
<?php endif; ?>
<?php if(get_field('on_home_disc')): ?>
	<section class="s-discover">
		<div class="container container-discover" <?php if(wp_is_mobile()) echo 'style="background-image:url(' . get_field('home_disc_fields')['home_disc_bg'] . ')"';?>>
			<img class="discover-bg" src="<?php echo get_field('home_disc_fields')['home_disc_bg']; ?>" alt="discover-background">
			<h2 class="discover-title"><?php if(get_field('home_disc_fields')['home_disc_title']) echo get_field('home_disc_fields')['home_disc_title']; else echo 'Discover Our Unique Collection';?></h2>
			<span class="discover-desc"><?php if(get_field('home_disc_fields')['home_disc_p']) echo get_field('home_disc_fields')['home_disc_p']; else echo 'Explore our collection of leather goods  accessories, perfect for giving as gifts or complementing your product  offering.  From purses to card holders, each item carries with it  Leyva&#39s distinctive craftsmanship.';?></span>
			<a class="discover-link" href="<?php if(get_field('home_disc_fields')['home_disc_link_url']) echo get_field('home_disc_fields')['home_disc_link_url']; else echo wc_get_page_permalink('shop'); ?>"><?php if(get_field('home_disc_fields')['home_disc_link_title']) echo get_field('home_disc_fields')['home_disc_link_title']; else echo 'Go to Catalog';?></a>
		</div>
	</section>
<?php endif; ?>
<?php if(get_field('on_home_blog')): ?>
	<section class="s-articles">
		<div class="container container-articles">
			<div class="home-articles-head">
				<h2 class="articles-home-title"><?php if(get_field('home_blog_title')) echo get_field('home_blog_title'); else echo 'Blog';?></h2>
				<a class="articles-home-link full-home-link" href="<?php echo get_permalink(get_option('page_for_posts')); ?>"><?php if(get_field('home_blog_link_title')) echo get_field('home_blog_link_title'); else echo 'All Articles';?></a>
			</div>
			<div class="articles-home-wrapper">
				<?php 
					$posts = get_posts( array(
						'numberposts' => 3,
						'orderby'     => 'date',
						'order'       => 'DESC',
						'post_type'   => 'post',
						'suppress_filters' => true,
					) );

					global $post;

					foreach( $posts as $key => $post ){
						setup_postdata($post);
						$link = '<a href="' . get_the_permalink() . '" class="home-s-blog-link">Read more</a>';
						$title = '<a href="' . get_the_permalink() . '" class="home-s-blog-title">' . get_the_title() . '</a>';
						if(get_the_post_thumbnail_url()){
							$img = '<img class="home-blog-cover" src="' . get_the_post_thumbnail_url() . '" alt="blog-cover">';
						} else {
							$img = '<img class="home-blog-cover" src="' . get_template_directory_uri() . '/assets/img/hero-home-wallet.jpg" alt="blog-cover">';
						}
						$cats_arr = get_the_category();
						$cats = '<div class="article-home-cats">';
						foreach($cats_arr as $cat){
							$cats .= '<a href="' . get_term_link($cat->term_id) . '" class="article-single-cat">' . $cat->name . '</a>';
						}
						$cats .= '</div>';

						if($key == 0){
							echo '<div class="home-single-blog--main"><div class="home-s-blog-left">' . $img . '</div><div class="home-s-blog-right">' . $cats . $title . $link . '</div></div>';
						} else {
							echo '<div class="home-single-blog">' . $cats . $title . $link . '</div>';
						}
					}

					wp_reset_postdata();
				?>
			</div>
			<a class="articles-home-link full-home-link full-home-link--mobile" href="<?php echo get_permalink(get_option('page_for_posts')); ?>"><?php if(get_field('home_blog_link_title')) echo get_field('home_blog_link_title'); else echo 'All Articles';?></a>
		</div>
	</section>
<?php endif; ?>
<?php if(get_field('on_home_rev')): ?>
	<section class="s-home-rev">
		<div class="container container-home-rev">
			<h2 class="home-rev-title"><?php if(get_field('home_rev_title')) echo get_field('home_rev_title'); else echo 'Reviews';?></h2>
			<div class="home-rev-swiper swiper">
				<div class="home-rev-wrapper swiper-wrapper">
					<?php
						$temp = '';
						foreach(get_field('home_rev_rep') as $review){
							$temp .= '<div class="swiper-slide home-rev-content"><h4 class="rev-slider-title">' . $review['home_rev_rep_title'] . '</h4><p class="rev-slider-text">' . $review['home_rev_rep_desc'] . '</p><span class="rev-slide-author">' . $review['home_rev_rep_auth'] . '</span></div>';
						}
						echo $temp;
					?>
				</div>
				<div class="home-rev-arrows">
					<div class="home-rev-next"><?php echo $arrow_rose; ?></div>
					<div class="home-rev-prev"><?php echo $arrow_rose; ?></div>
				</div>
				<div class="home-rev-swiper-pagination"></div>
			</div>
		</div>
	</section>
<?php endif; ?>
<?php if(get_field('on_home_contact')): ?>
	<section class="s-contact-home">
		<div class="container container-home-cont">
			<img class="home-cont-bg" src="<?php echo get_template_directory_uri() . '/assets/img/contact-home-bg.png'; ?>" alt="contact-background">
			<h2 class="home-cont-title"><?php if(get_field('home_cont_fields')['home_cont_title']) echo get_field('home_cont_fields')['home_cont_title']; else echo 'Contact and Distribution';?></h2>
			<p class="home-cont-text"><?php if(get_field('home_cont_fields')['home_cont_p']) echo get_field('home_cont_fields')['home_cont_p']; else echo 'If you are looking to differentiate yourself in your product offering, collaborating with Leyva Marroquinería is the right choice. We are committed to providing high quality products, handcrafted with the attention to detail that sets us apart. Become an exclusive Leyva distributor and bring elegance to your customers. Contact us today to find out more about how we can elevate your business with our exclusive range of leather goods. We are here to ensure that every purchase is a unique style experience.';?></p>
			<a class="home-cont-link contact-us-link" href="<?php if(get_field('home_cont_fields')['home_cont_link_url']) echo get_field('home_cont_fields')['home_cont_link_url']; else echo get_page_link(61); ?>"><?php if(get_field('home_cont_fields')['home_cont_link_title']) echo get_field('home_cont_fields')['home_cont_link_title']; else echo 'Contact US';?></a>
		</div>
	</section>
<?php endif; ?>
<?php
get_footer();
