$(document).ready(function() {
	$('.single-item').slick({
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
  		autoplaySpeed: 3000,
  		accessibility: true,
  		adaptiveHeight: true,
  		arrows: true,
  		focusOnSelect: false,
  		pauseOnHover: true
    });
					
});