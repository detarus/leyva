/**
 * File blog-script.js.
 */

jQuery(document).ready(function($) {

	(function initPage(){
		initShopSidebar();
	}());

	function initShopSidebar(){
		if($('.wc-shop-sidebar') && (window.innerWidth < 901)){
      $('.widget.widget_block').addClass('swiper-slide');
      $('.widget.widget_block').wrapAll('<div class="shop-side-wrapper swiper-wrapper">');
      $('.shop-side-wrapper').wrap('<div class="shop-side-swiper swiper">');
      $('.shop-side-swiper.swiper').append('<div class="shop-side-swiper-pagination"></div>');

      var swiperShop = new Swiper('.shop-side-swiper', {
        spaceBetween: 30,
        loop: true,
        pagination: {el: '.shop-side-swiper-pagination'},
      });
    }
	}

});