<?php

/**
 * Template Name: Empty Cart
 * @package Leyva
 */

if (0 == WC()->cart->get_cart_contents_count()) : ?>
<?php 
get_header();
?>

<section class="s-single-head">
  <div class="container container-single-head">
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
    <h1 class="site-head__title">Your Shopping Cart</h1>
  </div>
</section>

<section class="s-empty-cart">
  <div class="container container-empty-cart">
    <p class="empty-cart-mess">Your cart is empty. Please, add some product to  continue.</p>
    <a class="empty-cart-link" href="<?php echo wc_get_page_permalink('shop'); ?>">Go to Catalog</a>
  </div>
</section>

<?php
get_footer();
?>

<?php else: ?> 
  <?php wp_safe_redirect(wc_get_checkout_url()); ?>
<?php endif; ?>