/**
 * File shop-script.js.
 */

jQuery(document).ready(function($) {

	(function initPage(){
		initImgSlider();
    initProductVariations();
    initDescription();
    initReviewForm();
	}());

	function initImgSlider(){

		var swiperGallSec = new Swiper('.wc-swiper-gallery--second', {
      direction: 'vertical',
      loop: true,
      spaceBetween: 10,
      slidesPerView: 3,
      watchSlidesProgress: true,
    });

    var swiperGall = new Swiper('.wc-swiper-gallery--main', {
      loop: true,
      spaceBetween: 12,
      pagination: {el: '.wc-single-prod-pagination'},
      navigation: {
        nextEl: '.wc-single-prod-btn-next',
        prevEl: '.wc-single-prod-btn-prev',
      },
      thumbs: {
        swiper: swiperGallSec,
      },
    });


    var swiperProducts = new Swiper('.product-home-swiper', {
      slidesPerView: window.innerWidth < 901 ? 1 :  5.7,
      spaceBetween: window.innerWidth < 901 ? 20 :  0,
      pagination: {el: '.home-products-swiper-pagination'},
      loop: true,
      navigation: {
        nextEl: '.home-products-next',
        prevEl: '.home-products-prev',
      },
    });
    
    $length = $('.product-small-swiper .product-wrap').length;
    if($length < 4) $length = 4;
    var swiperProducts = new Swiper('.product-small-swiper', {
      slidesPerView: window.innerWidth < 901 ? 1 :  $length,
      spaceBetween: window.innerWidth < 901 ? 20 :  30,
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

    if($('.commentlist') && (window.innerWidth < 901)){
      $('.commentlist .review').addClass('swiper-slide');
      $('.commentlist .review').wrapAll('<div class="rev-single-wrapper swiper-wrapper">');
      $('.rev-single-wrapper').wrap('<div class="rev-single-swiper swiper">');
      $('.rev-single-swiper.swiper').append('<div class="rev-single-swiper-pagination"></div>');

      var swiperShop = new Swiper('.rev-single-swiper', {
        spaceBetween: 30,
        loop: true,
        pagination: {el: '.rev-single-swiper-pagination'},
      });
    }

	}

  function initProductVariations(){

		$(document).on('change', '.wc-product-variation-radios input', function(){
      $('.wc-product-variation-radios input:checked').each(function(index, element){
        const radio = $(element)
        const radioName = radio.attr('name')
        const radioValue  = radio.attr('value')
        $('select[name="' + radioName + '"]').val(radioValue).trigger('change');
      })
    })

    $('.single_variation_wrap').on('show_variation', function(event, variation){
      $('.wc-prod-swiper-img__first-img').attr('src', variation['image']['full_src']);
      // $('.wc-swiper-gallery--second .swiper-slide').removeClass('swiper-slide-active');
      // $('.wc-swiper-gallery--second .swiper-slide').removeClass('swiper-slide-thumb-active'); 
      // $('.wc-swiper-gallery--second').find('.wc-prod-swiper-img__first-img').parent().addClass('swiper-slide-active'); 
      // $('.wc-swiper-gallery--second').find('.wc-prod-swiper-img__first-img').parent().addClass('swiper-slide-thumb-active');

      // $('.wc-swiper-gallery--main .swiper-slide').removeClass('swiper-slide-active');
      // $('.wc-swiper-gallery--main').find('.wc-prod-swiper-img__first-img').parent().addClass('swiper-slide-active');

      const swiperGall = document.querySelector('.wc-swiper-gallery--main').swiper;
      // Now you can use all slider methods like
      // swiperGall.slideReset(500, false);
      swiperGall.slideTo(1);
    });

	}

  function initDescription(){
    $('.wc-single-prod-details-title, .wc-single-prod-description-title').click(function () {
      $(this).toggleClass('active');
      $(this).next().slideToggle();
      // $(this).next().slideDown();
    })
  }

  function initReviewForm(){
    $('.form-submit .submit').click(function(e) {
      e.preventDefault();
      $('.alert-form-comment').removeClass('active');
      if(($('.comment-form-author input').val() == '') || ($('.comment-form-email input').val() == '') || ($('.comment-form-comment textarea').val() == '')){
        $('.alert-form-comment').html('Please fill the required fields.');
        $('.alert-form-comment').addClass('active');
      } else if (($('.comment-form-author input').val() != '') && ($('.comment-form-email input').val() != '') && ($('.comment-form-comment textarea').val() != '')){
        const $regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!$regex.test($('.comment-form-email input').val())) {
          $('.alert-form-comment').html('Please enter a valid email address.');
          $('.alert-form-comment').addClass('active');
        } else {
          $(this).unbind('click');
          $(this).trigger('click');
        }
      } else {
        $('.alert-form-comment').html('Please fill the required fields.');
        $('.alert-form-comment').addClass('active');
      }
    })
  }

});