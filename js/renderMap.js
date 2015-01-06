  google.load("maps", "3",  {other_params:"key=AIzaSyA97SAEtJRZFH5hsM4Bg4PJ58sAFFiuWPU&sensor=false"});
  google.load("jquery", "1.3.2");

  active_marker = null;
  var infowindow = null;

  function initialize() {
  	infowindow = new google.maps.InfoWindow({
			content: "holding..."
		});
    var myLatlng = new google.maps.LatLng(37.09024, -95.71289);
    var myOptions = {
      zoom: 4,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var query = "../ajax.php?<?php echo $_SERVER['QUERY_STRING']; ?>";
    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    jQuery.get(query, {}, function(data) {
      jQuery(data).find("item").each(function() {
        marker = jQuery(this);
        var latlng = new google.maps.LatLng(parseFloat(marker.attr("lat")),
                                    parseFloat(marker.attr("lon")));
        title = marker.attr("name");
        id = marker.attr("id");
        url = '<b>' + marker.attr("name") + '</b>' + '<br>' +
        	'<a href="http://hotels.triposal.com/templates/331659/hotels/list?' +
					'lang=en' +
					'&currency=USD' +
					'&destination=' + marker.attr("name") +
					'&roomsCount=1' +
					'&standardCheckin=12%2F04%2F2013' +
					'&standardCheckout=12%2F06%2F2013">See Hotel Results!</a>';
        marker = new google.maps.Marker( {
        	position: latlng,
        	map: map,
        	id: id,
        	title: title,
        	animation: google.maps.Animation.DROP,
        	options: {
						icon: "../img/red-marker.png"
					}
        });
        (function (url, marker) {
         // Attaching a click event to the current marker
         //console.log(data[6]);
        	google.maps.event.addListener(marker, "click", function (e) {
        		if (active_marker){
								active_marker.setAnimation(null);
								active_marker.setIcon('../img/red-marker.png');
							}
						active_marker = marker;
						//marker.setAnimation(google.maps.Animation.BOUNCE);
						marker.setIcon( '../img/blue-marker.png' );
						//alert("Test");
          	infowindow.setContent(url);
            infowindow.open(map, marker);
          });
        }(url, marker));
    	});
    });
  }
  google.setOnLoadCallback(initialize);
