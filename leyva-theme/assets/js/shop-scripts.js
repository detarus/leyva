/**
 * File shop-script.js.
 */

jQuery(document).ready(function($) {

  $ajax_url = '/wp-admin/admin-ajax.php';

	(function initPage(){
		initShopSidebar();
    initFiltersOpen();
    initPriceInput();
    initAjaxLoads();
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

  function initFiltersOpen(){
    $('.wc-filter-title, .wc-filter-subtitle').click(function (e) {
      if(window.innerWidth < 901 && $(this).hasClass('wc-filter-title--main')){
        $('body').removeClass('no-scroll');
        return false;
      } else {
        e.preventDefault();
        if($(this).next().attr('class') == 'wc-filter-input-range'){
          $(this).toggleClass('active');
          $(this).next().slideToggle();
          $(this).next().next().slideToggle();
        } else {
          $(this).toggleClass('active');
          $(this).next().slideToggle();
        }
      }
    })

    $('.open-mob-filters').click(function (e) {
      e.preventDefault();
      if(window.innerWidth < 901){
        $('.wc-shop-filters__block').addClass('active');
        $('body').addClass('no-scroll');
      }
    })

    $('.wc-filters-close').click(function (e) {
      e.preventDefault();
      $('.wc-shop-filters__block').removeClass('active');
      $('body').removeClass('no-scroll');
    })
  }

  function initPriceInput(){
		$('#slider-range').slider({
      range: true,
      min: 100,
      max: 999,
      values: [100, 999],
      slide: function(event, ui) {
        $('#amount').val(ui.values[0] + '€ - ' + ui.values[1] + '€');
      }
    });
    $('#amount').val($('#slider-range').slider('values', 0 ) + '€ - ' + $('#slider-range').slider('values', 1) + '€');
	}

  function initAjaxLoads(){

    $("#slider-range").on('slidestop', function() {
      $('.wc-button-more-block').attr('page', 1);
      ajaxLoadPosts();
    });

    $('.wc-filter-radio-input, .wc-filter-checkbox').change(function () {
      $('.wc-button-more-block').attr('page', 1);
      ajaxLoadPosts();
    });
    
    $('#filter-sort-mobile').change(function () {
      $('.wc-button-more-block').attr('page', 1);
      ajaxLoadPosts();
    });

    $('.wc-shop-more-button').click(function (e) {
      e.preventDefault();
      ajaxLoadPosts($delete = false);
    });
    
    function ajaxLoadPosts($delete = true) {
      if($('.wc-shop-filter__cats .wc-filter-radio-input').is(':checked')){
        $('.wc-products-header__title.page-title').html($('.wc-shop-filter__cats .wc-filter-radio-input:checked').next().html());
      }
      $container = '.container.container-wc-shop ul.products';
      $loader = $('.shop-loader-block');
      $button = $('.wc-button-more-block');
      $post_status = 'publish';
      $post_type = 'product';
      if(window.innerWidth < 901){
        $orderby = $('#filter-sort-mobile').find(":selected").val();
      } else {
        $orderby = $('.wc-shop-filter__sort .wc-filter-radio-input:checked').val();
      }
      $post_num = 12;
      $paged = $('.wc-button-more-block').attr('page');
      $taxonomy_array = taxonomyArrayFunc();
      $category = $('.wc-shop-filter__cats .wc-filter-radio-input:checked').val();
      $amount = amountArrayFunc();
      if($delete == true){
        $('li.product.type-product').each(function(index) {
          $(this).remove();
        });
      }
      if($('.noresults')) $('.noresults').remove();

      $loader.addClass('active');

      $.ajax({
        type: 'POST',
        url: $ajax_url,
        data: {
          action: 'load_posts',
          post_status: $post_status,
          post_type: $post_type,
          orderby: $orderby,
          amount: $amount,
          post_num: $post_num,
          paged: $paged,
          taxonomy: $taxonomy_array,
          category: $category,
        },
        success: function (aj_success) {
          if (aj_success.substr(aj_success.length - 3) == 'end' || aj_success.includes('noresults')) {
            aj_success = aj_success.substr(0, aj_success.length - 3);
            $($button).removeClass('active');
          }
          else {
            $($button).addClass('active');
          }
          $($container).append(aj_success);
          $('.wc-button-more-block').attr('page', parseInt($paged) + 1);
          $($loader).removeClass('active');

          return;
        },
        error: function (aj_error) {
            console.log('Error: ' + aj_error);
            $($loader).removeClass('active');

            return;
        }
      });
    }

    function taxonomyArrayFunc() {
      $taxonomy = {};

      $('.wc-filter-list').each(function () {
        $taxonomy_value = $(this).attr('taxonomy');

        if ($taxonomy_value) {
          $current_taxonomy_array = [];

          $(this).find('.wc-filter-checkbox:checked').each(function () {
            $checkbox_id = $(this).attr('term');
            if($checkbox_id) {
              $current_taxonomy_array.push($checkbox_id);
            }
          });

          if($current_taxonomy_array.length > 0) {
            $taxonomy[$taxonomy_value] = $current_taxonomy_array;
          }
        }
      });

      return $taxonomy;
    }

    function amountArrayFunc(){
      $this = $('.wc-filter-input-range').val();
      $simbol = /€/gi;
      $amountArray = $this.replace($simbol, '').split(' - ');

      return $amountArray;
    }
  }

});