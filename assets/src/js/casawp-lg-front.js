function verifyCaptcha(event) {
	console.log(event);
	jQuery('button[type=submit]').removeAttr('disabled').removeAttr('style');
}

function preventDefault(e) {
  e = e || window.event;
  if (e.preventDefault)
	  e.preventDefault();
  e.returnValue = false;  
}

function keydown(e) {
	for (var i = keys.length; i--;) {
		if (e.keyCode === keys[i]) {
			preventDefault(e);
			return;
		}
	}
}

function wheel(e) {
  preventDefault(e);
}

function disable_scroll() {
  if (window.addEventListener) {
	  window.addEventListener('DOMMouseScroll', wheel, false);
  }
  window.onmousewheel = document.onmousewheel = wheel;
  document.onkeydown = keydown;
}

function enable_scroll() {
	if (window.removeEventListener) {
		window.removeEventListener('DOMMouseScroll', wheel, false);
	}
	window.onmousewheel = document.onmousewheel = document.onkeydown = null;  
}	

if (typeof prevSlide === "undefined") {
	function prevSlide(currentSlide){
		jQuery(currentSlide).removeClass('active');
		jQuery(currentSlide).prev().addClass('active').removeClass('old');
		
		maxHeight = jQuery('.casawp-lg_slide.active').outerHeight();

		jQuery('#clgFormAnchor').outerHeight(maxHeight);

		disable_scroll();
		jQuery('html, body').stop().animate({
			scrollTop: jQuery('#clgFormAnchor').offset().top - jQuery('#header').outerHeight()
		}, 700, function () {
			enable_scroll();
		});
	}
}

if (typeof nextSlide === "undefined") {
	function nextSlide(currentSlide){
		jQuery(currentSlide).removeClass('active').addClass('old');
		jQuery(currentSlide).next().addClass('active');
		
		maxHeight = jQuery('.casawp-lg_slide.active').outerHeight();

		jQuery('#clgFormAnchor').outerHeight(maxHeight);

		disable_scroll();
		jQuery('html, body').stop().animate({
			scrollTop: jQuery('#clgFormAnchor').offset().top - jQuery('#header').outerHeight()
		}, 700, function () {
			enable_scroll();
		});
	}
}

jQuery( function () {
	"use strict";

	(function($){

		var maxHeight = -1;

		maxHeight = $('.casawp-lg_slide.active').outerHeight();

		$('#clgFormAnchor').outerHeight(maxHeight);

		$(window).on('resize', function(){
			maxHeight = $('.casawp-lg_slide.active').outerHeight();

			$('#clgFormAnchor').outerHeight(maxHeight);
		})

		$('.btn-forward').on('click', function(e){
			e.preventDefault();
			var $this = $(this).parent().parent().parent().parent().parent();
			if ($this.find('#pac-input').length) {
				if ($('#cityName').val()) {
					nextSlide($this);
				} else {
					$('#pac-input').css('border-color', 'red');
				}
			} else {
				nextSlide($this);
			}
			return false;
		});

		$('.btn-backward').on('click', function(e){
			e.preventDefault();
			var $this = $(this).parent().parent().parent().parent().parent();
			prevSlide($this);
			return false;
		});

		

		$('input[type="range"]').rangeslider({
		    polyfill : false,
		    onInit : function() {
		        this.output = $( '<div class="range-output" />' ).insertAfter( this.$range ).html( this.$element.val() );
		    },
		    onSlide : function( position, value ) {
		        this.output.html( value );
		    }
		});

		if ($('input[name="extra_data[propertyType]"]:checked').val() == 'single-family-house') {
			$('#casawp-lg-property-surface').parent().show();
			$('#casawp-lg-bathroom').parent().hide();
		}

		$('input[type="radio"][name="extra_data[propertyType]"]').change(function(){
			if ($('input[name="extra_data[propertyType]"]:checked').val() == 'single-family-house') {
				$('#casawp-lg-property-surface').parent().show();
				$('#casawp-lg-bathroom').parent().hide();
			} else if($('input[name="extra_data[propertyType]"]:checked').val() == 'flat') {
				$('#casawp-lg-property-surface').parent().hide();
				$('#casawp-lg-bathroom').parent().show();
			}
		});

		function initAutocomplete() {
	        var map = new google.maps.Map(document.getElementById('casawp-lg_map'), {
	          center: {lat: 47.377960, lng: 8.539920},
	          zoom: 10,
	          mapTypeId: 'roadmap',
	          disableDefaultUI: true
	        });

	        // Create the search box and link it to the UI element.
	        var card = document.getElementById('pac-card');
	        var input = document.getElementById('pac-input');
	        var searchBox = new google.maps.places.SearchBox(input);
	        map.controls[google.maps.ControlPosition.TOP_CENTER].push(card);

	        // Bias the SearchBox results towards current map's viewport.
	        map.addListener('bounds_changed', function() {
	          searchBox.setBounds(map.getBounds());
					});
					
					google.maps.event.addDomListener(input, 'keydown', function(event) {
						if (event.keyCode === 13) {
							// ENTER
							event.preventDefault();
						} 
					});

	        var markers = [];
	        // Listen for the event fired when the user selects a prediction and retrieve
	        // more details for that place.
	        searchBox.addListener('places_changed', function() {
	          var places = searchBox.getPlaces();

						if (places.length == 0) {
	            return;
	          }

	          // Clear out the old markers.
	          markers.forEach(function(marker) {
	            marker.setMap(null);
	          });
	          markers = [];

	          // For each place, get the icon, name and location.
	          var bounds = new google.maps.LatLngBounds();
						var country = '';
						var locality = '';
						var postalCode = '';
	          places.forEach(function(place) {
	            if (!place.geometry) {
	              console.log("Returned place contains no geometry");
	              return;
							}
							if (place.address_components) {
								var countryItem = place.address_components.find(function(item) {
									return item.types.indexOf('country') !== -1;
								});
								if (countryItem) {
									country = countryItem.short_name ? countryItem.short_name : '';
								}
							}
							document.getElementById('countryName').value = country;
	          	document.getElementById('cityName').value = place.name;
              document.getElementById('cityLat').value = place.geometry.location.lat();
              document.getElementById('cityLng').value = place.geometry.location.lng();
              document.getElementById('formattedAddress').value = place.formatted_address;

              if ($('#cityLocality').length && $('#cityPostalCode').length) {
              	if (place.address_components) {
              		var localityItem = place.address_components.find(function(item) {
              			return item.types.indexOf('locality') !== -1;
              		});
              		if (localityItem) {
              			locality = localityItem.short_name ? localityItem.short_name : '';
              		}
              		var postalItem = place.address_components.find(function(item) {
              			return item.types.indexOf('postal_code') !== -1;
              		});
              		if (postalItem) {
              			postalCode = postalItem.short_name ? postalItem.short_name : '';
              		}
              	}
              	document.getElementById('cityLocality').value = locality;
              	document.getElementById('cityPostalCode').value = postalCode;
              }
              
              $('#pac-input').css('border-color', 'transparent');

	            // Create a marker for each place.
	            markers.push(new google.maps.Marker({
	              map: map,
	              title: place.name,
	              position: place.geometry.location
	            }));

	            if (place.geometry.viewport) {
	              // Only geocodes have viewport.
	              bounds.union(place.geometry.viewport);
	            } else {
	              bounds.extend(place.geometry.location);
	            }
	          });
	          map.fitBounds(bounds);
	        });
	      }

	      if ($('#casawp-lg_map').length) {
	      	initAutocomplete();
	      }

	}(jQuery));

} );
