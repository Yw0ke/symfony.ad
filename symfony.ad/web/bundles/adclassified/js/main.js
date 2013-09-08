$(document).ready(function(){
	/* Infield labels */
	$('label.infield').inFieldLabels();

	/* Nav mobile */
	$('#main-nav .level-1 > li > span').click(function(){
		if ( $('html').width() < 630 ) {
			$(this).next('.level-2').toggle();
		}
	});

	/* Home Slider*/
	$('#home-slider ul').carouFredSel({
		responsive: true,
		height: 'auto',
		items: {
			width : 490,
			visible: 1
		},
		auto: 5000,
		scroll: {
			pauseOnHover: true
		},
		pagination: '#home-slider .pager'
	});

	/* Annonce Slider*/
	$('#annonce-slider ul').carouFredSel({
		responsive: true,
		height: '320px',
		items: {
			width : 632,
			visible: 1
		},
		auto: false,
		prev: '#annonce-slider .prev',
		next: '#annonce-slider .next'
	});

	/* Left sidebar tabs */
	if ( $('.left-sidebar .bloc.tabs').length ) {
		$('.bloc.tabs .select .title').on('click', function(){
			if ( !$(this).hasClass('active') ) {
				$('.bloc.tabs .select .title').toggleClass('active');
				$('.bloc.tabs .tab').toggleClass('hidden');
			}
		});
	}

	/* Annonce technical tabs */
	$('#technical-tabs').easyResponsiveTabs();

	/* Annone Galerie */
	$('#annonce-slider li > a').magnificPopup({
		type:'image',
		tClose: 'Fermer (Echap)',
		tLoading: 'Chargement...',
		image: {
			tError: '<a href="%url%">L\'image</a> n\'a pas pu être chargée'
		},
		gallery: {
			enabled: true,

			preload: [1,2],

			navigateByImgClick: true,

			arrowMarkup: '<button type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',

			tCounter: '%curr% / %total%'
		}
	});
});

$(window).resize(function(){
	/* Home Slider*/
	$('#home-slider ul').carouFredSel({
		responsive: true,
		height: 'auto',
		items: {
			width : 490,
			visible: 1
		},
		auto: 5000,
		scroll: {
			pauseOnHover: true
		},
		pagination: '#home-slider .pager'
	});
});