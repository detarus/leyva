!function(){function o(o,e){var t=void 0===o?{center:{lat:mapOptions.lpac_map_default_latitude,lng:mapOptions.lpac_map_default_longitude},zoom:mapOptions.lpac_map_zoom_level,streetViewControl:!1,clickableIcons:mapOptions.lpac_map_clickable_icons,backgroundColor:mapOptions.lpac_map_background_color}:o,n=void 0===e?"":e;n=n||"lpac-map";var i=document.querySelector(".".concat(n));if(i)return new google.maps.Map(i,t)}function e(o){var e=void 0===o?{disableAutoPan:!0}:o;return new google.maps.InfoWindow(e)}function t(o,t){Object.keys(t).forEach((function(n){var i=t[n],a=i.store_cords_text.split(","),l=a[0],r=a[1],s={lat:parseFloat(l),lng:parseFloat(r)},p={clickable:!1,icon:"undefined"!=typeof lpac_pro_js&&lpac_pro_js.is_pro?i.store_icon_text:"",position:s,map:o},c={content:i.store_name_text,disableAutoPan:!0},g=function(o){var e=void 0===o?{}:o;return new google.maps.Marker(e)}(p);e(c).open(o,g)}))}function n(o,t,n){wp.ajax.post("lpac_get_shipping_regions_for_shortcode",{mapID:t}).done((function(t){"string"==typeof t?console.log(t):function(o,t,n){if(null==o)return void console.log("LPAC: No regions returned. Returning...");o.forEach((function(o){var i;new google.maps.Polygon({paths:o.polygon,strokeColor:o.bgColor,strokeOpacity:.8,strokeWeight:2,fillColor:o.bgColor,fillOpacity:.35,clickable:!1}).setMap(t);for(var a,l=new google.maps.LatLngBounds,r=0;r<o.polygon.length;r++)l.extend(o.polygon[r]);var s=null!==(a=null===(i=n.shipping_settings)||void 0===i?void 0:i.shipping_regions_settings)&&void 0!==a?a:"";if(s){var p=e();s.display_region_name;var c="on"===s.display_region_price?"<p style='margin: 5px 0 0 0;'>".concat(n.shop_currency).concat(parseFloat(o.cost).toFixed(2),"</p>"):"",g="on"===s.display_region_name?"<p style='margin: 0;'>".concat(o.name,"</p>"):"";p.setContent('<div class="lpac-shipping-region-infowindow" style="font-weight: 800; text-align: center; margin: 0 !important; font-size: 14px"> '.concat(g," ").concat(c," </div>")),p.setPosition(l.getCenter()),p.open(t)}}))}(t,o,n)})).fail((function(o){console.log(o.responseJSON.data)}))}!function(e){function i(){return function(o,e){var t=!0,n=!1,i=void 0;try{for(var a,l=e[Symbol.iterator]();!(t=(a=l.next()).done);t=!0){var r=a.value;o("#".concat(r)).selectWoo()}}catch(o){n=!0,i=o}finally{try{t||null==l.return||l.return()}finally{if(n)throw i}}}(e,["shipping-regions","store-locations"])}e((function(){i(),function(){var e=previewSettings.display_settings.default_coordinates,i={lat:parseFloat(e.latitude),lng:parseFloat(e.longitude)};if(!0!==previewSettings.is_new){var a,l,r,s,p=o({streetViewControl:!!previewSettings.display_settings.streetview_control,clickableIcons:!!previewSettings.display_settings.clickable_icons,backgroundColor:null!==(a=previewSettings.display_settings.background_color)&&void 0!==a?a:"",mapId:null!==(l=previewSettings.display_settings.google_map_id)&&void 0!==l?l:"",mapTypeId:null!==(r=previewSettings.display_settings.map_type)&&void 0!==r?r:"",center:i,zoom:parseInt(previewSettings.display_settings.zoom)},"kikote-map-builder-preview");n(p,postID,previewSettings),t(p,null!==(s=previewSettings.shipping_settings.store_locations)&&void 0!==s?s:{})}else o({center:i,zoom:12},"kikote-map-builder-preview")}()}))}(jQuery)}();