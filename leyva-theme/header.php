<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package leyva-theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<header id="masthead" class="site-header home-site-header">
		<div class="container container-head">
			<div class="main-head-body">
				<nav id="site-navigation" class="head-navigation">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
						)
					);
					?>
				</nav>
				<a class="head-brand-link" href="<?php echo esc_url(home_url('/')); ?>" rel="home">Leyva</a>
				<div class="advanced-head-block">
					<a class="cart-link-head" href="<?php echo esc_url(wc_get_checkout_url()); ?>"><svg width="37" height="36" viewBox="0 0 37 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="0.666992" y="0.5" width="35" height="35" rx="17.5" stroke="#BE3155"/><path fill-rule="evenodd" clip-rule="evenodd" d="M14.5016 9.02564C14.7881 8.42051 15.4052 8 16.1205 8H20.2135C20.9278 8 21.5448 8.42051 21.8324 9.02564C22.5313 9.03179 23.0767 9.06359 23.5637 9.25436C24.1452 9.48233 24.6509 9.86976 25.0229 10.3723C25.3985 10.8779 25.5745 11.5282 25.817 12.4215L25.8549 12.561L26.4586 14.7836C26.8615 14.9866 27.2145 15.2766 27.4921 15.6328C28.1286 16.4503 28.2411 17.4236 28.1286 18.5395C28.0181 19.6226 27.6783 20.9867 27.2526 22.6944L27.225 22.8021C26.9559 23.8821 26.7369 24.759 26.478 25.4431C26.2058 26.1569 25.862 26.7415 25.2941 27.1856C24.7272 27.6297 24.0774 27.8215 23.3212 27.9138C22.5957 28 21.6942 28 20.584 28H15.75C14.6398 28 13.7372 28 13.0128 27.9128C12.2555 27.8226 11.6068 27.6297 11.0389 27.1846C10.472 26.7415 10.1282 26.1569 9.85597 25.4431C9.59606 24.759 9.3781 23.8821 9.10898 22.8021L9.08135 22.6944C8.65567 20.9867 8.31492 19.6226 8.20543 18.5405C8.09287 17.4226 8.20543 16.4503 8.84088 15.6328C9.13047 15.2615 9.47736 14.9867 9.87439 14.7836L10.4781 12.561L10.517 12.4215C10.7595 11.5282 10.9355 10.8779 11.3111 10.3713C11.6833 9.86911 12.1889 9.48205 12.7703 9.25436C13.2573 9.06359 13.8017 9.03077 14.5016 9.02564ZM14.5027 10.5672C13.8252 10.5744 13.5541 10.6 13.329 10.6882C13.0158 10.811 12.7435 11.0196 12.5431 11.2903C12.363 11.5333 12.2566 11.8728 11.9598 12.9672L11.5976 14.2964C12.6597 14.1538 14.0309 14.1538 15.7337 14.1538H20.5993C22.3031 14.1538 23.6743 14.1538 24.7354 14.2964L24.3742 12.9662C24.0764 11.8718 23.971 11.5323 23.7909 11.2892C23.5905 11.0186 23.3182 10.8099 23.005 10.6872C22.7799 10.599 22.5077 10.5733 21.8303 10.5662C21.6849 10.8725 21.4558 11.1312 21.1697 11.3124C20.8835 11.4935 20.552 11.5897 20.2135 11.5897H16.1205C15.782 11.5897 15.4505 11.4935 15.1643 11.3124C14.8782 11.1312 14.6491 10.8725 14.5037 10.5662M16.1205 9.53846C16.0526 9.53846 15.9875 9.56548 15.9396 9.61356C15.8916 9.66165 15.8646 9.72687 15.8646 9.79487C15.8646 9.86288 15.8916 9.9281 15.9396 9.97618C15.9875 10.0243 16.0526 10.0513 16.1205 10.0513H20.2135C20.2814 10.0513 20.3465 10.0243 20.3944 9.97618C20.4424 9.9281 20.4694 9.86288 20.4694 9.79487C20.4694 9.72687 20.4424 9.66165 20.3944 9.61356C20.3465 9.56548 20.2814 9.53846 20.2135 9.53846H16.1205ZM11.7204 15.8318C10.7892 15.9672 10.3379 16.2133 10.0524 16.5805C9.76592 16.9467 9.63801 17.4441 9.73317 18.3836C9.83038 19.3436 10.1425 20.599 10.5866 22.3836C10.8711 23.52 11.0675 24.3077 11.2926 24.8964C11.5075 25.4646 11.7193 25.7651 11.9854 25.9733C12.2504 26.1805 12.5922 26.3128 13.1959 26.3856C13.8201 26.4605 14.6285 26.4615 15.7991 26.4615H20.5369C21.7065 26.4615 22.5169 26.4605 23.1401 26.3856C23.7438 26.3138 24.0856 26.1805 24.3506 25.9733C24.6167 25.7651 24.8275 25.4646 25.0444 24.8964C25.2675 24.3077 25.465 23.52 25.7484 22.3836C26.1936 20.599 26.5057 19.3436 26.6018 18.3836C26.698 17.4441 26.5691 16.9456 26.2836 16.5795C25.9981 16.2133 25.5469 15.9672 24.6146 15.8318C23.663 15.6944 22.3716 15.6923 20.5369 15.6923H15.7991C13.9644 15.6923 12.673 15.6944 11.7214 15.8318" fill="#BE3155"/></svg><span class="head-count-cart"><?php echo WC()->cart->get_cart_contents_count() ?></span></a>
					<a class="head-contact-link contact-us-link" href="#">Contact Us</a>
				</div>
			</div>
			<div class="mobile-head-body">
				<div class="mobile-head-top">
					<a class="head-brand-link" href="<?php echo esc_url(home_url('/')); ?>" rel="home">Leyva</a>
					<div class="head-cart-block">
						<a class="cart-link-head" href="<?php echo esc_url(wc_get_checkout_url()); ?>"><svg width="37" height="36" viewBox="0 0 37 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="0.666992" y="0.5" width="35" height="35" rx="17.5" stroke="#BE3155"/><path fill-rule="evenodd" clip-rule="evenodd" d="M14.5016 9.02564C14.7881 8.42051 15.4052 8 16.1205 8H20.2135C20.9278 8 21.5448 8.42051 21.8324 9.02564C22.5313 9.03179 23.0767 9.06359 23.5637 9.25436C24.1452 9.48233 24.6509 9.86976 25.0229 10.3723C25.3985 10.8779 25.5745 11.5282 25.817 12.4215L25.8549 12.561L26.4586 14.7836C26.8615 14.9866 27.2145 15.2766 27.4921 15.6328C28.1286 16.4503 28.2411 17.4236 28.1286 18.5395C28.0181 19.6226 27.6783 20.9867 27.2526 22.6944L27.225 22.8021C26.9559 23.8821 26.7369 24.759 26.478 25.4431C26.2058 26.1569 25.862 26.7415 25.2941 27.1856C24.7272 27.6297 24.0774 27.8215 23.3212 27.9138C22.5957 28 21.6942 28 20.584 28H15.75C14.6398 28 13.7372 28 13.0128 27.9128C12.2555 27.8226 11.6068 27.6297 11.0389 27.1846C10.472 26.7415 10.1282 26.1569 9.85597 25.4431C9.59606 24.759 9.3781 23.8821 9.10898 22.8021L9.08135 22.6944C8.65567 20.9867 8.31492 19.6226 8.20543 18.5405C8.09287 17.4226 8.20543 16.4503 8.84088 15.6328C9.13047 15.2615 9.47736 14.9867 9.87439 14.7836L10.4781 12.561L10.517 12.4215C10.7595 11.5282 10.9355 10.8779 11.3111 10.3713C11.6833 9.86911 12.1889 9.48205 12.7703 9.25436C13.2573 9.06359 13.8017 9.03077 14.5016 9.02564ZM14.5027 10.5672C13.8252 10.5744 13.5541 10.6 13.329 10.6882C13.0158 10.811 12.7435 11.0196 12.5431 11.2903C12.363 11.5333 12.2566 11.8728 11.9598 12.9672L11.5976 14.2964C12.6597 14.1538 14.0309 14.1538 15.7337 14.1538H20.5993C22.3031 14.1538 23.6743 14.1538 24.7354 14.2964L24.3742 12.9662C24.0764 11.8718 23.971 11.5323 23.7909 11.2892C23.5905 11.0186 23.3182 10.8099 23.005 10.6872C22.7799 10.599 22.5077 10.5733 21.8303 10.5662C21.6849 10.8725 21.4558 11.1312 21.1697 11.3124C20.8835 11.4935 20.552 11.5897 20.2135 11.5897H16.1205C15.782 11.5897 15.4505 11.4935 15.1643 11.3124C14.8782 11.1312 14.6491 10.8725 14.5037 10.5662M16.1205 9.53846C16.0526 9.53846 15.9875 9.56548 15.9396 9.61356C15.8916 9.66165 15.8646 9.72687 15.8646 9.79487C15.8646 9.86288 15.8916 9.9281 15.9396 9.97618C15.9875 10.0243 16.0526 10.0513 16.1205 10.0513H20.2135C20.2814 10.0513 20.3465 10.0243 20.3944 9.97618C20.4424 9.9281 20.4694 9.86288 20.4694 9.79487C20.4694 9.72687 20.4424 9.66165 20.3944 9.61356C20.3465 9.56548 20.2814 9.53846 20.2135 9.53846H16.1205ZM11.7204 15.8318C10.7892 15.9672 10.3379 16.2133 10.0524 16.5805C9.76592 16.9467 9.63801 17.4441 9.73317 18.3836C9.83038 19.3436 10.1425 20.599 10.5866 22.3836C10.8711 23.52 11.0675 24.3077 11.2926 24.8964C11.5075 25.4646 11.7193 25.7651 11.9854 25.9733C12.2504 26.1805 12.5922 26.3128 13.1959 26.3856C13.8201 26.4605 14.6285 26.4615 15.7991 26.4615H20.5369C21.7065 26.4615 22.5169 26.4605 23.1401 26.3856C23.7438 26.3138 24.0856 26.1805 24.3506 25.9733C24.6167 25.7651 24.8275 25.4646 25.0444 24.8964C25.2675 24.3077 25.465 23.52 25.7484 22.3836C26.1936 20.599 26.5057 19.3436 26.6018 18.3836C26.698 17.4441 26.5691 16.9456 26.2836 16.5795C25.9981 16.2133 25.5469 15.9672 24.6146 15.8318C23.663 15.6944 22.3716 15.6923 20.5369 15.6923H15.7991C13.9644 15.6923 12.673 15.6944 11.7214 15.8318" fill="#BE3155"/></svg><span class="head-count-cart"><?php echo WC()->cart->get_cart_contents_count() ?></span></a>
						<a class="mobile-burger-btn" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none"><path d="M6 27H30C30.825 27 31.5 26.325 31.5 25.5C31.5 24.675 30.825 24 30 24H6C5.175 24 4.5 24.675 4.5 25.5C4.5 26.325 5.175 27 6 27ZM6 19.5H30C30.825 19.5 31.5 18.825 31.5 18C31.5 17.175 30.825 16.5 30 16.5H18H6C5.175 16.5 4.5 17.175 4.5 18C4.5 18.825 5.175 19.5 6 19.5ZM4.5 10.5C4.5 11.325 5.175 12 6 12H30C30.825 12 31.5 11.325 31.5 10.5C31.5 9.675 30.825 9 30 9H6C5.175 9 4.5 9.675 4.5 10.5Z" fill="white"/></svg></a>
					</div>
				</div>
				<div class="mobile-head-menu">
					<div class="mobile-head-menu--top">
						<a class="head-brand-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">Leyva</a>
						<a class="head-close" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none"><path d="M27 9L9 27" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 9L27 27" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
					</div>
					<div class="head-mobile-content">
						<nav id="site-navigation" class="head-navigation">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'menu_id'        => 'primary-menu',
								)
							);
							?>
						</nav>
						<a class="head-contact-link contact-us-link" href="#">Contact Us</a>
					</div>
				</div>
			</div>
		</div>
		<div class="wc-mini-cart-block">
			<div class="container container-mini-cart">
				<div class="mini-cart-head">
					<a class="mini-cart-close" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none"><path d="M15.9997 29.3337C8.63588 29.3337 2.66634 23.3641 2.66634 16.0003C2.66634 8.63653 8.63588 2.66699 15.9997 2.66699C23.3635 2.66699 29.333 8.63653 29.333 16.0003C29.333 23.3641 23.3635 29.3337 15.9997 29.3337Z" stroke="#101010" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 21.3337L10.6667 16.0003L16 10.667" stroke="#101010" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M21.333 16H10.6663" stroke="#101010" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Back</a>
				</div>
				<?php woocommerce_mini_cart(); ?>
			</div>
		</div>
		
	</header><!-- #masthead -->