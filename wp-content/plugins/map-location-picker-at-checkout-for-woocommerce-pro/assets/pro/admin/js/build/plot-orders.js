!function(o){var n=window.lpac_map,t=[];function e(){return{from:o("#lpac_export_date_from").val(),to:o("#lpac_export_date_to").val()}}function a(o){wp.ajax.post("lpac_get_orders_by_range",{dateRange:o}).done(r).fail((function(o){alert(o)}))}function r(o){for(var e=0;e<t.length;e++)t[e].setMap(null);o.forEach((function(o){if(o.latitude&&o.longitude){var e=function(o){var n=void 0===o?{}:o;return new google.maps.Marker(n)}({clickable:!1,position:{lat:parseFloat(o.latitude),lng:parseFloat(o.longitude)},map:n});t.push(e);var a,r,l=(r=void 0===a?{disableAutoPan:!0}:a,new google.maps.InfoWindow(r));l.setContent("<strong>Order #".concat(o.orderID,"</strong>")),l.open(n,e)}}))}google.maps.event.addListenerOnce(n,"tilesloaded",(function(){a(e())})),o("#lpac_export_date_from").on("change",(function(){a(e())})),o("#lpac_export_date_to").on("change",(function(){a(e())}))}(jQuery);