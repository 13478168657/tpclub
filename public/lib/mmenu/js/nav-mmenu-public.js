$(function() {

	$("#menu").mmenu({
		extensions 		: [ "theme-white", "pagedim-black" ],
		dropdown 		: true,
		counters		: false,
		navbar          :false
		/*navbars	: [{content: [ "" ]}, true]*/

	}, {

		dropdown: {
			offset: {
				button: {
					y: 0,
					x: 3
				}
			}
		} });

	//���»�Ч��
	$(".mh-head.mm-sticky").mhead({
		scroll: {
			hide: 200
		}
	});
	$(".mh-head:not(.mm-sticky)").mhead({
		scroll: false
	});



	$('body').on( 'click',
		'a[href^="#/"]',
		function() {
			alert( "Thank you for clicking, but that's a demo link." );
			return false;
		}
	);
});