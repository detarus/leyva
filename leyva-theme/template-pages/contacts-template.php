<?php

/**
 * Template Name: Contacts
 * @package Leyva
 */

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
		<h1 class="site-head__title"><?php the_title(); ?></h1>
	</div>
</section>

<section class="s-contact-info">
	<div class="container container-contacts">
		<div class="conatct-wrapper">
			<div class="contact-map">
				<?php echo do_shortcode('[kikote_map id="186"]'); ?>
			</div>
			<div class="contact-content">
				<div class="contact-content__main"><?php the_content(); ?></div>
				<?php if(get_field('tel_contact')): ?>
				<div class="contact-content__phone">
					<span class="contact-content__title">Number:</span>
					<span class="contact-content__paragraph"><?php echo get_field('tel_contact')?></span>
				</div>
				<?php endif; ?>
				<?php if(get_field('email_contact')): ?>
				<div class="contact-content__email">
					<span class="contact-content__title">Email:</span>
					<span class="contact-content__paragraph"><?php echo get_field('email_contact')?></span>
				</div>
				<?php endif; ?>
				<?php if(get_field('adr_contact')): ?>
				<div class="contact-content__adr">
					<span class="contact-content__title">Addresses:</span>
					<span class="contact-content__paragraph"><?php echo get_field('adr_contact')?></span>
				</div>
				<?php endif; ?>
			</div>
			<div class="contact-form__block">
				<h2 class="contact-form__title">Contact Us</h2>
				<form class="contact-form">
					<input class="contact-form-input contact-form-name" name="contact-form-name" placeholder="Name" type="text">
					<input class="contact-form-input contact-form-email" name="contact-form-email" placeholder="Email" type="email">
					<input class="contact-form-input contact-form-tel" name="contact-form-tel" placeholder="Number" type="tel">
					<input class="contact-form-input contact-form-theme" name="contact-form-theme" placeholder="Topic" type="text">
					<textarea class="contact-form-textarea contact-form-mes" name="contact-form-mes" placeholder="Message"></textarea>
					<button class="contact-form-submit" type="sudmit">Send</button>
				</form>
			</div>
		</div>
		
	</div>
</section>

<?php
get_footer();
