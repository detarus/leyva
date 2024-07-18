/**
 * File home-script.js.
 */

jQuery(document).ready(function($) {

	(function initPage(){
		initTab();
		initSwipers();
		initHead();
	}());

	function initHead(){
		$(window).on('scroll', function() {
			$('.site-header').toggleClass('active', $(this).scrollTop() > 6.83);
		});
	}

	function initTab(){

		$('.feat-home-link').click(function (e) {
			e.preventDefault();
			if(window.innerWidth < 901){
				// $('.feat-home-link, .feat-home-content--mobile').removeClass('active');
				// $('.feat-home-content--mobile').slideUp();
				$(this).toggleClass('active');
				$(this).next().slideToggle();
				// $(this).next().slideDown();
			} else {
				$id = $(this).attr('id').split('--');
				$('.feat-home-link, .feat-home-content').removeClass('active');
				$(this).addClass('active');
				$('#feat-cont--' + $id[1]).addClass('active');
			}
			
    })

	}

	function initSwipers(){

		var swiperProducts = new Swiper('.product-home-swiper', {
			slidesPerView: window.innerWidth < 901 ? 1.2 :  5.7,
			pagination: {el: '.home-products-swiper-pagination'},
			loop: true,
      navigation: {
        nextEl: '.home-products-next',
        prevEl: '.home-products-prev',
      },
    });

		var swiperCats = new Swiper('.cats-home-swiper', {
			slidesPerView: window.innerWidth < 901 ? 1.1 :  4,
			spaceBetween: window.innerWidth < 901 ? 12 :  20,
			centeredSlides: window.innerWidth < 901 ? true : false,
			pagination: {el: '.home-cats-swiper-pagination'},
			loop: true,
      navigation: {
        nextEl: '.home-cats-next',
        prevEl: '.home-cats-prev',
      },
    });

		var swiperRev = new Swiper('.home-rev-swiper', {
			spaceBetween: 30,
			pagination: {el: '.home-rev-swiper-pagination'},
      navigation: {
        nextEl: '.home-rev-next',
        prevEl: '.home-rev-prev',
      },
    });
		
	}

});
