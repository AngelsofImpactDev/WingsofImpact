		$('.ue-lightbox').magnificPopup({
			type: 'image',
			closeBtnInside: false,
			closeOnContentClick: true
		});
		$('.ue-zoombox').magnificPopup({
		  type: 'image',
		  closeBtnInside: false,
		  closeOnContentClick: true,
		  mainClass: 'mfp-with-zoom', // this class is for CSS animation below
		  zoom: {
			enabled: true, // By default it's false, so don't forget to enable it
			easing: 'ease-in-out', // CSS transition easing function
		
			// The "opener" function should return the element from which popup will be zoomed in
			// and to which popup will be scaled down
			// By defailt it looks for an image tag:
			opener: function(openerElement) {
			  // openerElement is the element on which popup was initialized, in this case its <a> tag
			  // you don't need to add "opener" option if this code matches your needs, it's defailt one.
			  return openerElement.is('img') ? openerElement : openerElement.find('img');
			}
		  }
		});
		$('.ue-gallery').magnificPopup({
		  type: 'image',
		  gallery:{
			enabled:true
		  }
		});
		$('.ue-zoomgallery').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
				delegate: 'a', // the selector for gallery item
				type: 'image',
				closeBtnInside: false,
				mainClass: 'mfp-with-zoom', // this class is for CSS animation below
				gallery: {
				  enabled:true
				},
				zoom: {
					enabled: true,
					opener: function(element) {
					  return element.find('img');
					}
				}
			});
		});
		$('.ue-popbtn').magnificPopup({
		  type:'inline',
		  //showCloseBtn: false,
		  closeBtnInside: false,
		  midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
		});