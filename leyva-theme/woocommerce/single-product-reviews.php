<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.3.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="woocommerce-Reviews">
	<h2 class="wc-reviews-main-title">Product rating</h2>
	<div id="comments">
		<h3 class="woocommerce-Reviews-title">
			<?php	esc_html_e( 'Reviews', 'woocommerce' );	?>
		</h3>

		<?php if ( have_comments() ) : ?>
			<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php
			if ( get_comment_pages_count() > 1 && get_option('page_comments')) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links(
					apply_filters(
						'woocommerce_comment_pagination_args',
						array(
							'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
							'next_text' => is_rtl() ? '&larr;' : '&rarr;',
							'type'      => 'list',
						)
					)
				);
				echo '</nav>';
			endif;
			?>
		<?php else : ?>
			<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'woocommerce' ); ?></p>
		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
		<div id="review_form_wrapper">
			<div class="wc-reviews-rating-block">
				<?php
					$average = $product->get_average_rating();
					$review_count = $product->get_review_count();
					$rating_count_arr = get_post_meta( $product->get_id(), '_wc_rating_count', true );
					echo '<h2 class="star-rating-title">' . $average . '</h2>';
					echo '<div class="star-rating"><span style="width:' . (($average/5) * 100) . '%" title="' . $average . '"></span></div>';
					?>

					<div class="wc-product-rating-list">
						<?php
							if(!$rating_count_arr){
								$rating_count_arr = array(0, 0, 0, 0, 0);
							}
							for ($i = 5; $i > 0 ; $i--) {
								if (!isset( $rating_count_arr[$i])) {
									$rating_count_arr[$i] = 0;
								}
								$percent = 0 ;
								if ($rating_count_arr[$i] > 0) {
									$percent = round(($rating_count_arr[$i] / $review_count) * 100);
								}

								if($i <= 1) $stars = $i . ' star'; else $stars = $i . ' stars';
								echo '
									<div class="wc-product-rating-wrap">
										<span class="wc-rating-stars-count">' . $stars . '</span>
										<div class="wc-rating-percent-body"><div class="wc-rating-bar" style="width: ' . $percent . '%"></div></div>
										<span class="wc-rating-count">( ' . $rating_count_arr[$i] . ' )</span>
									</div>';
							} 
						?>
					</div>
			</div>
			<div id="review_form">
				<h2 class="wc-reviews-rating-block__title">Add your review</h2>
				<?php
				$commenter    = wp_get_current_commenter();
				$comment_form = array(
					/* translators: %s is product title */
					'title_reply'         => '',
					/* translators: %s is product title */
					'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'woocommerce' ),
					'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
					'title_reply_after'   => '</span>',
					'comment_notes_after' => '',
					'label_submit'        => esc_html__( 'Send', 'woocommerce' ),
					'logged_in_as'        => '',
					'comment_field'       => '',
				);

				$name_email_required = (bool) get_option( 'require_name_email', 1 );
				$fields              = array(
					'author' => array(
						'label'    => __( 'Name', 'woocommerce' ),
						'type'     => 'text',
						'value'    => $commenter['comment_author'],
						'required' => $name_email_required,
						'placeholder' => __( 'Name', 'woocommerce' ),
					),
					'email'  => array(
						'label'    => __( 'Email', 'woocommerce' ),
						'type'     => 'email',
						'value'    => $commenter['comment_author_email'],
						'required' => $name_email_required,
						'placeholder' => __( 'Email', 'woocommerce' ),
					),
				);

				$comment_form['fields'] = array();

				foreach ( $fields as $key => $field ) {
					$field_html  = '<p class="comment-form-' . esc_attr( $key ) . '">';
					// $field_html .= '<label class="wc-review-' . esc_attr( $key ) . '-label" for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] ) . '</label>';

					// if ( $field['required'] ) {
					// 	$field_html .= '&nbsp;<span class="required">*</span>';
					// }

					$field_html .= '<input class="wc-rating-input--' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' /></p>';

					$comment_form['fields'][ $key ] = $field_html;
				}

				$account_page_url = wc_get_page_permalink( 'myaccount' );
				if ( $account_page_url ) {
					/* translators: %s opening and closing link tags respectively */
					$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'woocommerce' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
				}

				if ( wc_review_ratings_enabled() ) {
					$comment_form['comment_field'] = '<div class="comment-form-rating"><label class="wc-review-rating-label" for="rating">' . esc_html__( 'Product rating:', 'woocommerce' ) . ( wc_review_ratings_required() ? '&nbsp;' : '' ) . '</label><select name="rating" id="rating" required>
						<option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
						<option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
						<option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
						<option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
						<option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
						<option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
					</select></div>';
				}

				$comment_form['comment_field'] .= '<p class="comment-form-comment"><textarea class="wc-rating-input--textarea-comment" placeholder="Write a review" id="comment" name="comment" cols="45" rows="8" required></textarea></p>';
				$comment_form['comment_field'] .= '<p class="alert-form-comment"></p>';

				comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>
	<?php else : ?>
		<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>
	<?php endif; ?>

	<div class="clear"></div>
</div>
