/* Portfolio Sorting */


jQuery(document).ready(function () { 
	(function ($) { 
		var container = $('.works-list');
		
		container.imagesLoaded(function () { 
			
			container.isotope( { 
				itemSelector : '.project', 
				layoutMode : 'fitRows', 
				resizable : false 
			} );
		} );
		
		$('.sort-panel .filter a').click(function () { 
			var selector = $(this).attr('data-filter');
			
			
			$(this).parent().parent().find('> li.active').removeClass('active');
			
			
			$(this).parent().addClass('active');
			
			
			container.isotope( { 
				filter : selector 
			} );
			
			return false;
		} );
		
		
	} )(jQuery);
} );

