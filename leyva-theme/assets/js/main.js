/**
 * File main-script.js.
 */

jQuery(document).ready(function($) {

	$ajax_url = '/wp-admin/admin-ajax.php';

	(function initPage(){
		initMobileHeader();
		initPopupContact();
		initMinCartQuantity();
	}());

	function initMobileHeader(){
		$('.mobile-burger-btn').click(function (e) {
			e.preventDefault();
			$('.mobile-head-menu').addClass('active');
			$('body').addClass('no-scroll');
		});
		
		$('.head-close').click(function (e) {
			e.preventDefault();
			$('.mobile-head-menu').removeClass('active');
			$('body').removeClass('no-scroll');
		});

		$('.cart-link-head').click(function (e) {
			e.preventDefault();
			if(!$('body').hasClass('woocommerce-cart') && !$('body').hasClass('woocommerce-checkout')){
				if($('body').hasClass('page-template-home-template')){
					$('.site-header').addClass('active');
				}
				if($('.wc-mini-cart-block').hasClass('active')){
					$('.wc-mini-cart-block').removeClass('active');
				}else{
					$('.wc-mini-cart-block').addClass('active');
				}
			}
		});

		$('.mini-cart-close').click(function (e) {
			e.preventDefault();
			$('.wc-mini-cart-block').removeClass('active');
		});

		$(document).mouseup(function (e) {
			if($('.wc-mini-cart-block').hasClass('active')){
				if ((!$('.container-mini-cart').is(e.target) && $('.container-mini-cart').has(e.target).length === 0)){
					$('.wc-mini-cart-block').removeClass('active');
				}
			}
		});
	}

	function initPopupContact(){

		$('.contact-us-link').click(function (e) {
			e.preventDefault();
			$('.contact-popup').addClass('active');
			$('body').addClass('no-scroll');
		})
		
		$('.popup-contact-close').click(function (e) {
			e.preventDefault();
			$('.contact-popup').removeClass('active');
			$('body').removeClass('no-scroll');
		})

	}

	function initMinCartQuantity(){

		$('.wc-min-cart__quantity-block').on('click', '.wc-min-cart__quantity-plus, .wc-min-cart__quantity-minus', function(){
			$this = $(this).closest('.wc-min-cart__quantity-block').find('.wc-min-cart__quantity-input');
			$val_old = parseFloat($this.val());
			$max = parseFloat($this.attr('max'));
			$min = parseFloat($this.attr('min'));
			$step = parseFloat($this.attr('step'));

			if ($(this).is('.wc-min-cart__quantity-plus')){
				if ($max && ($max <= $val_old)){
					$this.val($max);
				}	else {
					$this.val($val_old + $step);
				}
			}	else {
				if ($min && ($min >= $val_old)){
					this.val(min);
				}	else if ($val_old > 1){
					$this.val($val_old - $step);
				}
			}

			$key = $this.attr('cart-key');
			$product_id = $this.attr('id').split('--')[1];
			$ajax_val = {
				action: 'change_mini_cart_quantity',
        product_id: $product_id,
				block_id: $this.attr('for-product'),
				value: $this.val(),
				key: $key,
      };

      $.ajax({
        type: 'POST',
        url: $ajax_url,
        data: $ajax_val,
        success: function (aj_end) {
          // console.log(aj_end['data']);
					$product = $('#' + aj_end['data']['product_id']);
					$total_price = aj_end['data']['total_price'];

					$product.find('.min-cart-price').html(aj_end['data']['product_price']);
					$('.wc-mini-cart-total--count').html(aj_end['data']['total_items']);
					$('.head-count-cart').html(aj_end['data']['total_items']);
					$('.wc-mini-cart-total--subtotal').html($total_price);
					$('.wc-cart-min--final-price').html($total_price);
					
        },
        error: function (aj_end) {
            console.log('Ajax ended with error: ' + aj_end);
        },
      });

		});

	}

});
