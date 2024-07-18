/**
 * File cart-script.js.
 */

jQuery(document).ready(function($) {

	(function initPage(){
		initCartQuantity();
		initProdSwiper();
		initDevPrice();
		initPaymentHeight();
		// initMapPosition();
		initHead();
	}());

	function initCartQuantity(){

		$('.wc-cart__quantity-block').on('click', '.wc-cart__quantity-plus, .wc-cart__quantity-minus', function(e){
			e.preventDefault();
			$this = $(this).closest('.wc-cart__quantity-block').find('.qty');
			$val_old = parseFloat($this.val());
			$max = parseFloat($this.attr('max'));
			$min = parseFloat($this.attr('min'));
			$step = parseFloat($this.attr('step'));

			if ($(this).is('.wc-cart__quantity-plus')){
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

			if($this.val() < $val_old || $this.val() > $val_old){
				$('.woocommerce-cart-form .actions .button').removeAttr('disabled');
				$('.woocommerce-cart-form .actions .button').trigger('click');
			}
			
		});

	}

	function initProdSwiper(){

		var swiperProducts = new Swiper('.product-home-swiper', {
			slidesPerView: window.innerWidth < 901 ? 1 :  5.7,
			spaceBetween: window.innerWidth < 901 ? 20 : 0,
			pagination: {el: '.home-products-swiper-pagination'},
			loop: true,
      navigation: {
        nextEl: '.home-products-next',
        prevEl: '.home-products-prev',
      },
    });

	};

	function initDevPrice(){
		if($('#shipping_method')){

			$('input.shipping_method').each(function(index){
				if($(this).is(':checked')){
					if($(this).next().find('.shipping-method-cost').html() == 'Free'){
						$('.wc-cart-total__subtitle--delivery').html('0,00 €');
						$('#lpac-store-selector-shortcode').css({'display' : 'block'});
						if(window.innerWidth > 900){
							$('#lpac-map-container').css({'top' : '23.073vw'});
							$('.wc-cart-checkout-block').css({'padding-top' : '37.5vw'});
						} else {
							$('#lpac-map-container').css({'top' : '97.067vw'});
							$('.wc-cart-checkout-block').css({'padding-top' : '182.133vw'});
						}
					} else {
						$price =  $(this).next().find('.shipping-method-cost').html().replace('.', ',');
						$('.wc-cart-total__subtitle--delivery').html($price);
						$('#lpac-store-selector-shortcode').css({'display' : 'none'});
						if(window.innerWidth > 900){
							$('#lpac-map-container').css({'top' : '20.052vw'});
							$('.wc-cart-checkout-block').css({'padding-top' : '34.427vw'});
						} else {
							$('#lpac-map-container').css({'top' : '82.133vw'});
							$('.wc-cart-checkout-block').css({'padding-top' : '167.2vw'});
						}
					}
				}
			});

			$('#shipping_method').on('change', 'input.shipping_method', function(e){
				$('input.shipping_method').each(function(index){
					if($(this).is(':checked')){
						if($(this).next().find('.shipping-method-cost').html() == 'Free'){
							$('.wc-cart-total__subtitle--delivery').html('0,00 €');
							$('#lpac-store-selector-shortcode').css({'display' : 'block'});
							if(window.innerWidth > 900){
								$('#lpac-map-container').css({'top' : '23.073vw'});
								$('.wc-cart-checkout-block').css({'padding-top' : '37.5vw'});
							} else {
								$('#lpac-map-container').css({'top' : '97.067vw'});
								$('.wc-cart-checkout-block').css({'padding-top' : '182.133vw'});
							}
						} else {
							$price =  $(this).next().find('.shipping-method-cost').html().replace('.', ',');
							$('.wc-cart-total__subtitle--delivery').html($price);
							$('#lpac-store-selector-shortcode').css({'display' : 'none'});
							if(window.innerWidth > 900){
								$('#lpac-map-container').css({'top' : '20.052vw'});
								$('.wc-cart-checkout-block').css({'padding-top' : '34.427vw'});
							} else {
								$('#lpac-map-container').css({'top' : '82.133vw'});
								$('.wc-cart-checkout-block').css({'padding-top' : '167.2vw'});
							}
						}
					}
				});
			})
			
		}
	};

	function initPaymentHeight(){
		if(window.innerWidth < 901){
			$padding = ((($('#payment').outerHeight(true) * 100) + 10) / $(window).width());
			$('.wc-cart-checkout-block').css({'padding-bottom' : $padding + 'vw'});

			$('.woocommerce-checkout-review-order').on('change', '.woocommerce-checkout-payment input', function(){
				setTimeout(function() { 
					$padding = ((($('#payment').outerHeight(true) * 100) + 10) / $(window).width());
					$('.wc-cart-checkout-block').css({'padding-bottom' : $padding + 'vw'});
				}, 250);
				
			})
		} else {
			$padding = (($('#payment').outerHeight(true) * 100) / $(window).width());
			$('.wc-cart-checkout-block').css({'padding-bottom' : $padding + 'vw'});
	
			$('.woocommerce-checkout-review-order').on('change', '.woocommerce-checkout-payment input', function(){
				setTimeout(function() { 
					$padding = (($('#payment').outerHeight(true) * 100) / $(window).width());
					$('.wc-cart-checkout-block').css({'padding-bottom' : $padding + 'vw'});
				}, 250);
				
			})
		}
		
	};
	
	function initMapPosition(){
		setTimeout(function() { 
			$block_height = $('.wc-shipping-totals__title').outerHeight(true) + $('#shipping_method').outerHeight(true) + $('.woocommerce-shipping-destination').outerHeight(true) + $('.shipping-calculator-form__title').outerHeight(true) + $('#calc_shipping_country_field').outerHeight(true) + $('#calc_shipping_state_field').outerHeight(true) + $('#calc_shipping_city_field').outerHeight(true) + $('#calc_shipping_postcode_field').outerHeight(true);
			$map_height = $('#lpac-map-container').outerHeight(true);
			$main_height = ($block_height - $map_height) - 16;
			$top_height = (($main_height * 100) / $(window).width());
			$('#lpac-map-container').css({'top' : $top_height + 'vw'});
		}, 300);
	};

	function initHead(){
		$(window).on('scroll', function() {
			$('.site-header').toggleClass('active', $(this).scrollTop() > 6.83);
		});
	};

});
