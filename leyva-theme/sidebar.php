<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package leyva-theme
 */

if (!is_active_sidebar('sidebar-1') || is_woocommerce()) {
	return;
}
$filter_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none"><path d="M18.5 15L12.5 9L6.5 15" stroke="#BE3155" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
?>

<aside id="secondary" class="widget-area">
	<div class="main-sidebar">
		<?php if (!is_single()): ?>
		<div class="main-sidebar-filter__cats">
			<h5 class="main-sidebar-title">Categories <?php echo $filter_svg; ?></h5>
			<div class="main-sidebar-content" style="display: none;">
				<ul class="main-sidebar-list">
					<?php						
						$categories = get_categories();
						foreach($categories as $cat){
							$name = $cat->name;
							$slug = $cat->slug;
							$link = get_category_link($cat->term_id);
							if(is_category()){
								if(get_queried_object()->name == $name){
									echo '<li class="main-sidebar-list__title active"><a class="main-sidebar-link-cat filter-cat--' . $slug . '" href="' . $link . '">' . $name . '</a></li>';
								} else {
									echo '<li class="main-sidebar-list__title"><a class="main-sidebar-link-cat filter-cat--' . $slug . '" href="' . $link . '">' . $name . '</a></li>';
								}
							} else {
								echo '<li class="main-sidebar-list__title"><a class="main-sidebar-link-cat filter-cat--' . $slug . '" href="' . $link . '">' . $name . '</a></li>';
							}
						}
					?>
				</ul>
			</div>
		</div>
		<?php endif; ?>
		<form class="wc-filters-form">
			<h5 class="wc-filters-form__title">Subscribe! Lorem ipsum dolor sit amet</h5>
			<input class="input-wc-filters" type="email" placeholder="Email">
			<button class="btn-wc-filters" type="sudmit">Subscribe</button>
			<label class="label-wc-formn-filters" for="wc-filter-personal"><input required class="checkbox-wc-formn-filters" id="wc-filter-personal" type="checkbox"><span class="label-wc-formn-span">by filling in the form, you agree to the processing of personal data</span></label>
		</form>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div>
</aside><!-- #secondary -->
