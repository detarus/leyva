<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package leyva-theme
 */

?>
<?php if ((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_tag())): ?>
	<?php 
		$title = '<a href="' . get_the_permalink() . '" class="single-blog__title">' . get_the_title() . '</a>';
		$link = '<a href="' . get_the_permalink() . '" class="single-blog__link">Read more</a>';
		$cats_arr = get_the_category();
		$cats = '<div class="single-blog__cats-wrapper">';
		foreach($cats_arr as $cat){
			$cats .= '<a href="' . get_term_link($cat->term_id) . '" class="single-blog__cat">' . $cat->name . '</a>';
		}
		$cats .= '</div>';
		$content = $cats . $title . $link;
	?>
	<div class="single-blog-wrap">
		<div class="single-blog-left">
			<img class="single-blog__cover" src="<?php echo get_the_post_thumbnail_url();?>" alt="blog-cover">
		</div>
		<div class="single-blog-right">
			<?php echo $content; ?>
		</div>
	</div>
<?php else: ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php
			if (is_singular()) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) :
				$categories_list = get_the_category_list( esc_html__( ', ', 'leyva-theme' ) );
				if ( $categories_list ) {
					/* translators: 1: list of categories. */
					printf( '<span class="post-cat-link">' . esc_html__( '%1$s', 'leyva-theme' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<?php leyva_theme_post_thumbnail(); ?>

		<div class="entry-content">
			<?php
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'leyva-theme' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'leyva-theme' ),
					'after'  => '</div>',
				)
			);
			?>
		</div><!-- .entry-content -->
	</article><!-- #post-<?php the_ID(); ?> -->
<?php endif; ?>