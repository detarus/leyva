/**
 * File about-script.js.
 */

jQuery(document).ready(function($) {

	(function initPage(){
		initShopSidebar();
	}());

	function initShopSidebar(){
		if($('.s-team') && (window.innerWidth < 901)){
      $('.team-wrap').addClass('swiper-slide');
      $('.team-wrap').wrapAll('<div class="team-slide-wrapper swiper-wrapper">');
      $('.team-slide-wrapper').wrap('<div class="team-swiper swiper">');
      $('.team-swiper.swiper').append('<div class="team-swiper-pagination"></div>');

      var swiperShop = new Swiper('.team-swiper', {
        spaceBetween: 30,
        loop: true,
        pagination: {el: '.team-swiper-pagination'},
      });
    }
	}

});