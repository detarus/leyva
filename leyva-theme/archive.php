<?php
/**
 * The template for displaying archive pages
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

		<?php if ( have_posts() ) : ?>

			<header class="index-header">
				
				<?php
				the_archive_title( '<h1 class="main-page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
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
?></div><?php
get_footer();
