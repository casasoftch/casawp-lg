jQuery( function () {
	"use strict";

	(function($){

		var maxHeight = -1;

		$('.casawp-lg_slide').each(function() {
		    maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
		});

		$('#clgFormAnchor').outerHeight(maxHeight);

		$(window).resize(function(){
			$('.casawp-lg_slide').each(function() {
			    maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
			});

			$('.casawp-lg-wrapper_inner').outerHeight(maxHeight);
		})

		$('.btn-forward').click(function(e){
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

		$('.btn-backward').click(function(e){
			e.preventDefault();
			var $this = $(this).parent().parent().parent().parent().parent();
			prevSlide($this);
			return false;
		});

		function prevSlide(currentSlide){
			$(currentSlide).removeClass('active');
			$(currentSlide).prev().addClass('active').removeClass('old');
		}

		function nextSlide(currentSlide){
			$(currentSlide).removeClass('active').addClass('old');
			$(currentSlide).next().addClass('active');
		}

		$('input[type="range"]').rangeslider({
		    polyfill : false,
		    onInit : function() {
		        this.output = $( '<div class="range-output" />' ).insertAfter( this.$range ).html( this.$element.val() );
		    },
		    onSlide : function( position, value ) {
		        this.output.html( value );
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
