/**
 * File about-script.js.
 */

jQuery(document).ready(function($) {

	(function initPage(){
		initContainerPadding();
	}());

	function initContainerPadding(){
		if(window.innerWidth < 901){
      setTimeout(function() { 
        $block_height = $('.contact-content__main').outerHeight(true);
        $padding_height = (($block_height * 100) / $(window).width());
        $('.container.container-contacts').css({'padding-top' : $padding_height + 'vw'});
      }, 300);
    }
	}

});