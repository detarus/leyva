<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package leyva-theme
 */

get_header();
?>

<div class="site-main-breadcrumb">
	<?php woocommerce_breadcrumb(array(
		'delimiter'   => '<span class="bread-del">/</span>',
		'wrap_before' => '<nav class="woocommerce-breadcrumb">',
		'wrap_after'  => '</nav>',
		'before'      => '',
		'after'       => '',
		'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
	) ); ?>
</div>

<div class="container site-container">
	<main id="primary" class="site-main">
		
			<?php
			if ( have_posts() ) :

				if ( is_home() && ! is_front_page() ) :
					?>
					<header class="index-header">
						<?php if ((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())): ?>
							<h1 class="main-page-title"><?php single_post_title(); ?></h1>
						<?php else: ?>
							<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
						<?php endif; ?>
					</header>
					<?php
				endif;

				/* Start the Loop */
				?><div class="articles-posts-wrapper"><?php
				while ( have_posts() ) :
					the_post();
					
					/*
					* Include the Post-Type-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Type name) and that will be used instead.
					*/
					get_template_part( 'template-parts/content', get_post_type() );

				endwhile;
				?></div><?php
				the_posts_navigation();
				
			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>
		
	</main><!-- #main -->

	<?php
	get_sidebar();
	?>
	</div>
<?php
get_footer();
