(function($){
	"use strict";

	$(window).on( 'load', function(){
		/*-------------------- PRELOADER -------------------*/
		$('body').addClass('animated-page page-loaded');

		/* ---------------- SLIDER HOME ONE --------------- */
		if($('.marathon-slider')[0]){
			$('.marathon-slider').slick({
				infinite: true,
				slidesToShow: 1,
				slidesToScroll: 1,
				dots: true,
				arrows: false,
				speed: 1000,
				fade: true,
				cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)',
				touchThreshold: 100,
				autoplay: true,
				autoplaySpeed: 4500,
				lazyLoad: 'progressive',
				responsive: [
				{
					breakpoint: 1200,
					settings: {
						dots: false,
					}
				}
				]
			});
		}

		/* --------------- SLIDER HOME TWO -------------- */
		if($('.conference-slider')[0]){
			$('.conference-slider').slick({
				infinite: true,
				slidesToShow: 1,
				slidesToScroll: 1,
				dots: false,
				arrows: false,
				speed: 1000,
				fade: true,
				cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)',
				touchThreshold: 100,
				autoplay: true,
				autoplaySpeed: 4500
			});
		}

	});

	/*----------------------- WOW ------------------------*/
	if( $( '.wow' )[0] ){
		new WOW({
			mobile: false,
		}).init();
	}

	/* -------------------- PARALLAX SCROLL ------------------- */

	if($('.bg-effect')[0] && window.navigator.userAgent.indexOf("Firefox") === -1 ){
		var $window  = $( window ),
		$wrapper = $( 'body' ),
		$target  = $( '.bg-effect', $wrapper );

		$window.on( 'scroll.myTemplate resize.myTemplate', scrollHandler ).trigger( 'resize.myTemplate' );

		function scrollHandler( event ) {
			var speed         = 0.25,
			invert            = -1,
			winHeight         = $window.height(),
			winScrollTop      = $window.scrollTop(),
			offsetTop         = $wrapper.offset().top,
			positionDelta     = winScrollTop - offsetTop + ( winHeight / 2 ),
			abs               = positionDelta > 0 ? 1 : -1,
			posY              = abs * Math.pow( Math.abs( positionDelta ), 0.85 );

			posY = invert * Math.ceil( speed * posY );

			$target.css( {
				'transform': 'translateY(' + posY + 'px)'
			} );
		};
	}

	/* --------------------- PARALLAX HOVER -------------------- */
	if( $( '.scene' )[0] && window.navigator.userAgent.indexOf("Firefox") === -1 ){
		$('.scene').each( function( index, element ){
			new Parallax( element );
		});
	}

	/* ---------------------- MENU --------------------- */
	$('.nav-btn').on('click', function(){
		$('.nav-menu').toggleClass('active');
		$(this).toggleClass('active');
		$('body').toggleClass('no-scroll');
		return false;
	});

	$( window ).on('resize.myTemplate', function(){
		$('body')[ ( $(this).width() <= 767 ) ? 'addClass' : 'removeClass' ]('isMobile')
	}).trigger( 'resize.myTemplate' );

	$('.dropdown>a').on('click', function(){
		if(! $('body.isMobile')[0] ) return;
		$(this).parents('li').toggleClass('dropdown-active');
		$(this).parents('li').children('ul').toggle('slow');
		return false;
	});

	$('.dropdown').on( 'mouseenter', function(){
		if( $('body.isMobile')[0] ) return;
		var menuItem = $( this );

		if( menuItem[0].timeOutMenu ){
			clearTimeout( menuItem[0].timeOutMenu );
		}

		menuItem.addClass('active');
	}).on( 'mouseleave', function(){
		if( $('body.isMobile')[0] ) return;

		var menuItem = $( this );

		menuItem[0].timeOutMenu = setTimeout( function(){
			menuItem.removeClass('active');
		}, 500 );
	});

	/* --------------------- TO TOP -------------------- */
	$(window).on( 'scroll.myTemplat', scrollWindow).trigger( 'scroll.myTemplat' );

	function scrollWindow() {
		if ($(window).scrollTop() > 500) {
			$('.to-top').addClass('active');
		} else {
			$('.to-top').removeClass('active');
		}
	}

	$( 'body' ).on( 'click', '.to-top',  function(event) {
		$('html, body').animate({
			scrollTop:0
		}, 400);
		return false;
	});

	/* ----------------- SCROLL HEADER  ---------------- */
	var $window = $(window),
	lastScrollTop = 0,
	st;
	$( window ).on( 'scroll.mySite', function(){
		st = $(this).scrollTop();

		$('header')[ 0 < st ? 'addClass' : 'removeClass' ]('header-top');

		if ( st < lastScrollTop || $window.width() < 768){
			$('header')[ 0 === st ? 'removeClass' : 'addClass' ]('header-scroll');
		} else {
			$('header').removeClass('header-scroll');
		}
		lastScrollTop = st;
	}).trigger('scroll.mySite');


	/*----------------- SCROLL SECTION	-----------------*/
	$('.menu a, .btn, .footer-list a').on('click', function(event) {
		var target = $( $(this).attr('href') );
		if( target.length ) {
			event.preventDefault();
			$('html, body').animate({
				scrollTop: target.offset().top
			}, 600);
		}
	});

	/* ------------------ DANCE-SLIDER ----------------- */
	if($('.dance-slider')[0]){
		$('.dance-slider').slick({
			infinite: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			dots: false,
			arrows: false,
			speed: 1000,
			fade: true,
			cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)',
			touchThreshold: 100
		});
	}

	/* -------------------- CLIENTS ------------------- */
	if( $('.clients-cover')[0] ){
		$( '.clients-cover' ).slick({
			infinite: true,
			slidesToShow: 5,
			slidesToScroll: 1,
			arrows: false,
			speed: 800,
			touchThreshold: 200,
			cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)',
			autoplay: true,
			autoplaySpeed: 4500,
			responsive: [
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3,
				}
			}
			]
		});
	}

	/*-------------------- COUNTDOWN -------------------*/
	if( $( '#clockdiv' )[0] ){
		function getTimeRemaining(endtime) {
			var t = Date.parse(endtime) - Date.parse(new Date());
			var seconds = Math.floor((t / 1000) % 60);
			var minutes = Math.floor((t / 1000 / 60) % 60);
			var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
			var days = Math.floor(t / (1000 * 60 * 60 * 24));
			return {
				'total': t,
				'days': days,
				'hours': hours,
				'minutes': minutes,
				'seconds': seconds
			};
		}

		function initializeClock(id, endtime) {
			var clock = document.getElementById(id);
			var daysSpan = clock.querySelector('.days');
			var hoursSpan = clock.querySelector('.hours');
			var minutesSpan = clock.querySelector('.minutes');
			var secondsSpan = clock.querySelector('.seconds');

			function updateClock() {
				var t = getTimeRemaining(endtime);

				daysSpan.innerHTML = t.days;
				hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
				minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
				secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

				if (t.total <= 0) {
					clearInterval(timeinterval);
				}
			}

			updateClock();
			var timeinterval = setInterval(updateClock, 1000);
		}
			var deadline_date = new Date(2022,9,25,23,59,60);
			var deadline = new Date(Date.parse(deadline_date));
		initializeClock('clockdiv', deadline);
	}

	/* ------------- SCHEDULE MARATHON TABS ------------- */
	if ( $('.schedule-item-info')[0] ) {
		$('.schedule-item-info').on('click', function(){
			$(this).toggleClass('active').find('.schedule-info-content').stop().toggle('ease');
		});
	}

	/*------------------ MODAL WINDOW	------------------*/
	if($('.popup-open')[0]){
		$( 'body' ).on('click', '.popup-open', function( event ){
			var rel = $( event.currentTarget ).attr('rel');

			$('body').addClass('modal');
			$('.overlay').addClass('active');
			$('.popup').removeClass('active');
			$('.popup-'+rel).addClass('active');

			return false;
		});

		$( 'body' ).on('click', '.popup-close, .overlay', function(){
			$('body').removeClass('modal');
			$('.overlay').removeClass('active');
			$('.popup').removeClass('active');

			return false;
		});
	}

	/*----------------- PLAY/STOP VIDEO -----------------*/
	if($('.close_vid')[0]){
		$( 'body' ).on('click', '.close_vid', function() {
			$("iframe").each( function() {
				$( this )[0].contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*')
			});
		});
	}

	/*--------------------- COUNTER --------------------*/
	if ( $('.counter-animate.counter-active')[0] ) {
		$( window ).on( 'scroll', function(){
			var winScrollTop = $( this ).scrollTop(),
			windowHeight = $(this).height();

			$('.counter-animate.counter-active').each(function(){
				var $this = $(this),
				targetPos = $this.offset().top;
				if( targetPos < winScrollTop + 100 + windowHeight / 2 ){
					if( $this.hasClass( 'counter-active' )){
						var time = 4;
						$('.have-prepared span').each(function(){
							var i = 1,
							num = $(this).data('number'),
							step = 500 * time / num,
							that = $(this),
							int = setInterval(function(){
								if (i <= num) {
									that.html(i);
								}
								else {
									clearInterval(int);
								}
								i++;
							},step);
						});
						$this.removeClass('counter-active');
					}
				}
			});
		});
	}

	/* ----------------- CONTACT FORM ----------------- */
	if( $( '#contactform' )[0] ){
		$( '#contactform' ).on( 'submit', function() {
			var action = $( this ).attr( 'action' ),
			message = $( '#message' ),
			submit = $( '#submit' );

			message.slideUp( 750, function() {
				message.hide();
				submit.attr( 'disabled', 'disabled' );
				$.post(
					action,
					{
						name: $( '#name' ).val(),
						email: $( '#email' ).val(),
						comments: $( '#comments' ).val(),
					},
					function( event ) {
						document.getElementById( 'message' ).innerHTML = event;
						message.slideDown( 'slow' );
						submit.removeAttr( 'disabled' );

						if ( null != event.match( 'success' ) ) {
							$( '#contactform' ).slideDown( 'slow' );
						}
					}
					);
			});
			return false;
		});
	}

	/*------------------- NICE SELECT -------------------*/
	if($('.nice-select')[0]){
		$('.nice-select').niceSelect();
	}

	/* -------------- MARATHON-NEWS-SLIDER ------------- */
	if( $('.marathon-news-slider')[0] ){
		$( '.marathon-news-slider' ).slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			arrows: true,
			speed: 800,
			touchThreshold: 200,
			cssEase: 'ease',
			nextArrow: '<span class="slick-arrow-next"><i class="fa fa-angle-right" aria-hidden="true"></i></span>',
			prevArrow: '<span class="slick-arrow-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></span>',
			autoplay: true,
			autoplaySpeed: 4500,
			responsive: [
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 576,
				settings: {
					fade: true,
					slidesToShow: 1,
				}
			}
			]
		});
	}

	/*--------------- TESTIMONIALS SLIDER  --------------*/
	if( $('.slider-testimonial')[0] ){
		$( '.slider-testimonial' ).slick({
			slidesToShow: 2,
			slidesToScroll: 1,
			arrows: false,
			dots: true,
			speed: 800,
			touchThreshold: 200,
			cssEase: 'ease',
			autoplay: true,
			autoplaySpeed: 4500,
			responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
				}
			}
			]
		});
	}

	/*--------------- SLIDER-OUR-SPEAKER  --------------*/
	if( $('.slider-our-speaker')[0] ){
		$( '.slider-our-speaker' ).slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			arrows: false,
			dots: true,
			speed: 800,
			touchThreshold: 200,
			cssEase: 'ease',
			autoplay: true,
			autoplaySpeed: 4500,
			responsive: [
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 400,
				settings: {
					slidesToShow: 1,
				}
			}
			]
		});
	}
	/*-------------- CONFERENCE-NEWS-SLIDER  -------------*/
	if( $('.conference-news-slider')[0] ){
		$( '.conference-news-slider' ).slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			arrows: true,
			dots: false,
			speed: 800,
			touchThreshold: 200,
			cssEase: 'ease',
			nextArrow: '<span class="slick-arrow-next"><i class="fa fa-angle-right" aria-hidden="true"></i></span>',
			prevArrow: '<span class="slick-arrow-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></span>',
			autoplay: true,
			autoplaySpeed: 4500,
			responsive: [
			{
				breakpoint: 1367,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					arrows: false,
				}
			}
			]
		});
	}

	/*--------------- DANCE-MEMBERS-SLIDER  --------------*/
	if( $('.dance-members-slider')[0] ){
		$( '.dance-members-slider' ).slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			arrows: true,
			dots: false,
			speed: 800,
			touchThreshold: 200,
			cssEase: 'ease',
			nextArrow: '<span class="slick-arrow-next"><i class="fa fa-angle-right" aria-hidden="true"></i></span>',
			prevArrow: '<span class="slick-arrow-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></span>',
			autoplay: true,
			autoplaySpeed: 4500,
			responsive: [
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 575,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 400,
				settings: {
					slidesToShow: 1,
				}
			}
			]
		});
	}

	/*-------------------- BY TICKET -------------------*/
	if( $( '.price-final-text' )[0] ){
		$('.inp-price .nice-select .list li').on('click', function(){
			var priceAttr = $(this).attr('data-value');
			$('.price-final-text').html(priceAttr);
		});
	}

	/*----------------------- TABS ----------------------*/
	if( $( '.tab-wrap' )[0] ){
		$( '.tab-wrap' )
		.on( 'click', '.tab-nav .item', switchTab )
		.find( '.tab-nav .item:first-child' ).trigger( 'click' );

		function switchTab( event ){
			var curentTab = $( this ),
			tabWrapper = $( event.delegateTarget ),
			visibleContent = $( '.' + curentTab.attr('rel') ),
			contentHeight;

			$( '.active', tabWrapper ).removeClass( 'active' );
			curentTab.addClass( 'active' );

			$( '.visible-content', tabWrapper ).removeClass( 'visible-content' );
			visibleContent.addClass( 'visible-content' );

			contentHeight = visibleContent.height();
			$( '.tabs-content', tabWrapper ).height( contentHeight );
		}

		$( window ).on( 'resize.myTemplate' , resizeTab );

		function resizeTab( event ){
			var visibleContent = $( '.tab.visible-content' );
			setTimeout(function(){
				visibleContent.each( function() {
					var contentHeight = $( this ).outerHeight(true),
					tabsContent = $( this ).parents( '.tabs-content' );

					tabsContent.height( contentHeight );
				} );
			}, 700);
		}

	}

	/*---------------------- LAZY  ---------------------*/
	if( $( '.rx-lazy' )[0] ){
		$('.rx-lazy').rxLazy();
	}

	/* -------------------- ISOTOPE ------------------- */
	if( $( '.grid-gallery' )[0] ){
		var $grid = $('.grid-gallery').isotope({
			itemSelector: '.gallery-item',
			percentPosition: true,
			masonry: {
				columnWidth: '.grid-sizer'
			}
		});

		$( window ).on( 'load', rebuildMasonry ).on( 'resize', rebuildMasonry );
		function rebuildMasonry(){
			$grid.isotope();
		}
	}
	/* ------------------- FANCYBOX 3 ------------------ */
	if( $( '[data-fancybox]' )[0] ){
		$( '[data-fancybox]' ).fancybox({
			loop: true,
			infobar: false,
			transitionEffect: 'tube',
			buttons: [
			'close'
			],
		});
	}

	/*-------------------- GOOGLE MAP -------------------*/
	if( $('.google-map')[0] ){
		googleMapsInit();
	}

	function googleMapsInit() {
		// Basic options for a simple Google Map
		// For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
		var mapOptions = {
			zoom: 12,
			center: new google.maps.LatLng(40.6501038, -73.9495823),
			mapTypeControl: false,
			fullscreenControl: false,
			scalecontrol: false,
			zoomControl: false,
			streetViewControl: false,
			rotateControl: false,
			// How you would like to style the map.
			// This is where you would paste any style found on Snazzy Maps.
			styles: [{"featureType": "water","elementType": "geometry","stylers": [{"color": "#e9e9e9"},{"lightness": 17}]},{"featureType": "landscape","elementType": "geometry","stylers":[{"color": "#f5f5f5"},{"lightness": 20}]},{"featureType": "road.highway","elementType": "geometry.fill","stylers": [{"color": "#ffffff"},{"lightness": 17}]},{"featureType": "road.highway","elementType": "geometry.stroke","stylers": [{"color": "#ffffff"},{"lightness": 29},{"weight": 0.2}]},{"featureType": "road.arterial","elementType": "geometry","stylers": [{"color": "#ffffff"},{"lightness": 18}]},{"featureType": "road.local","elementType": "geometry","stylers": [{"color": "#ffffff"},{"lightness": 16}]},{"featureType": "poi","elementType": "geometry","stylers": [{"color": "#f5f5f5"},{"lightness": 21}]},{"featureType": "poi.park","elementType": "geometry","stylers": [{"color": "#dedede"},{"lightness": 21}]},{"elementType": "labels.text.stroke","stylers": [{"visibility": "on"},{"color": "#ffffff"},{"lightness": 16}]},{"elementType": "labels.text.fill","stylers": [{"saturation": 36},{"color": "#333333"},{"lightness": 40}]},{"elementType": "labels.icon","stylers": [{"visibility": "off"}]},{"featureType": "transit","elementType": "geometry","stylers": [{"color": "#f2f2f2"},{"lightness": 19}]},{"featureType": "administrative","elementType": "geometry.fill","stylers": [{"color": "#fefefe"},{"lightness": 20}]},{"featureType": "administrative","elementType": "geometry.stroke","stylers": [{"color": "#fefefe"},{"lightness": 17},{"weight": 1.2}]}]
		};
		// Get the HTML DOM element that will contain your map
		// We are using a div with id="map" seen below in the <body>
		var mapElement = document.getElementById('map');

		// Create the Google Map using our element and options defined above
		var map = new google.maps.Map(mapElement, mapOptions);

		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(40.6401038, -73.9495823),
			map: map
		});
	}

	// $('#regForm').validate({
	// 	ignore: [],
	//   rules: {
	// 	select: {
	// 	  required: true
	// 	}
	//   },
	//   messages: {
	// 	select: {
	// 	  required: "Value required"
	// 	}
	//   }
	// });
	
	// $('#regForm').on("submit", function(e){
	// 	e.preventDefault();
	// 	if ($('li[class="inp-cover inp-professional"] '
	// })
$('#regForm').on('submit', function(e){
	e.preventDefault();
	$('#regForm').submit();
	// if ($('#first_name').val() != ''){
		// if ($('#first_name').val() != '' && $('#last_name').val() != '' && $('#email').val() != ''){
		// 	$('#regForm').submit();
		// }
	// }else{
		// alert('You must tick the checkbox to certify that you have read the Privcy Policy and T&Cs to continue');
		// e.preventDefault();
	// }
})
	
}(jQuery));
