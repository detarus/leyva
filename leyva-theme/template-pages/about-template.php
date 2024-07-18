<?php

/**
 * Template Name: About Us
 * @package Leyva
 */

get_header();

$arrow_white = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 16L16 12L12 8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 12H16" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
$arrow_black = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#101010" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 16L16 12L12 8" stroke="#101010" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 12H16" stroke="#101010" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
$arrow_rose = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#BE3155"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#BE3155" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 16L16 12L12 8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8 12H16" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>';
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

<?php if(get_field('cont_info_repeater')[0]['info_cont_img'] && get_field('cont_info_repeater')[0]['info_cont_text']): ?>
	<?php foreach(get_field('cont_info_repeater') as $key => $content):?>
		<?php if (($key + 1) % 2 === 0): ?>
			<section class="s-left-about">
				<div class="container container-left-about">
					<div class="left-about__img-block">
						<img src="<?php echo $content['info_cont_img'];?>" alt="">
					</div>
					<div class="left-about__text-block">
						<?php echo $content['info_cont_text'];?>
					</div>
				</div>
			</section>
		<?php else: ?>
			<section class="s-right-about">
				<div class="container container-right-about">
					<div class="right-about__img-block">
						<img src="<?php echo $content['info_cont_img'];?>" alt="">
					</div>
					<div class="right-about__text-block">
						<?php echo $content['info_cont_text'];?>
					</div>
				</div>
			</section>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>

<section class="s-team">
	<div class="container container-team">
		<h2 class="team-title"><?php if(get_field('about_team_title')) echo get_field('about_team_title'); else echo 'Our Team';?></h2>
		<div class="team-wrapper">
			<?php 
				$temp = '';
				foreach(get_field('team_repeator') as $key => $human){
					if($human['human_group']['about_h_img']){
						$img = '<img src="' . $human['human_group']['about_h_img'] . '" alt="worker-' . $key + 1 . '">';
					} else {
						$img = '<img src="' . get_template_directory_uri() . '/assets/img/Persona-1.png" alt="worker-' . $key + 1 . '">';
					}
					if($human['human_group']['about_h_job']){
						$job = '<span class="team-job">' . $human['human_group']['about_h_job'] . '</span>';
					}
					if($human['human_group']['about_h_name']){
						$temp .= '<div class="team-wrap"><div class="team-img-block">' . $img . '</div><div class="team-info-block"><span class="team-name">' . $human['human_group']['about_h_name'] . '</span>' . $job . '</div></div>';
					}		
				}
				echo $temp;
			?>
		</div>
	</div>
</section>

<?php
get_footer();
