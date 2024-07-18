<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
		'before'      => '<span class="bread-title">',
		'after'       => '</span>',
		'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
	) ); ?>
</div>
<div class="container container-single-page">
	<main id="primary" class="site-main">
		<div class="single-content-block">
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', get_post_type() );

				the_post_navigation(
					array(
						'prev_text' => '<span class="nav-subtitle"><svg xmlns="http://www.w3.org/2000/svg" width="81" height="8" viewBox="0 0 81 8" fill="none"><path d="M0.646446 3.64644C0.451187 3.8417 0.451187 4.15828 0.646446 4.35355L3.82843 7.53553C4.02369 7.73079 4.34027 7.73079 4.53554 7.53553C4.7308 7.34027 4.7308 7.02368 4.53554 6.82842L1.70711 3.99999L4.53554 1.17157C4.7308 0.976304 4.7308 0.659722 4.53554 0.464459C4.34027 0.269197 4.02369 0.269197 3.82843 0.464459L0.646446 3.64644ZM81 3.5L1 3.49999L1 4.49999L81 4.5L81 3.5Z" fill="#BE3155"/></svg></span> <span class="nav-title">' . esc_html__( 'Previous', 'leyva-theme' ) . '</span>',
						'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next', 'leyva-theme' ) . '</span> <span class="nav-title"><svg xmlns="http://www.w3.org/2000/svg" width="81" height="8" viewBox="0 0 81 8" fill="none"><path d="M80.3536 3.64644C80.5488 3.8417 80.5488 4.15828 80.3536 4.35355L77.1716 7.53553C76.9763 7.73079 76.6597 7.73079 76.4645 7.53553C76.2692 7.34027 76.2692 7.02368 76.4645 6.82842L79.2929 3.99999L76.4645 1.17157C76.2692 0.976304 76.2692 0.659722 76.4645 0.464459C76.6597 0.269197 76.9763 0.269197 77.1716 0.464459L80.3536 3.64644ZM-4.37114e-08 3.5L80 3.49999L80 4.49999L4.37114e-08 4.5L-4.37114e-08 3.5Z" fill="#BE3155"/></svg></span>',
					)
				);

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>
		</div>
	</main><!-- #main -->

	<?php
	get_sidebar();
	?> 
</div>
<?php
get_footer();
