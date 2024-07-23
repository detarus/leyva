<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package leyva-theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if(!is_cart() || !is_checkout()): ?>
		<header class="entry-header">
			<div class="wc-breadcrumb-page">
				<?php woocommerce_breadcrumb(array(
					'delimiter'   => '<span class="bread-del">/</span>',
					'wrap_before' => '<nav class="woocommerce-breadcrumb">',
					'wrap_after'  => '</nav>',
					'before'      => '',
					'after'       => '',
					'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
				) ); ?>
			</div>
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->
		
		<?php leyva_theme_post_thumbnail(); ?>
	<?php else: ?>
		<header class="wc-cart-header">
			<div class="container container-wc-head">
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
			</div>
		</header>
	<?php endif; ?>

	<?php if(is_cart()): ?>
		<div class="entry-content">
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'leyva-theme' ),
					'after'  => '</div>',
				)
			);
			?>
		</div><!-- .entry-content -->
	<?php else: ?>
		<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'leyva-theme' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>
	
	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'leyva-theme' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
