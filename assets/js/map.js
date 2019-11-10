const $ = require('jquery');

$(document).ready(function () {
    if ($('#map').length) {
        var lat = $('#map').attr('lat');
        var lon = $('#map').attr('lon');

        var map = L.map('map').setView([lat, lon], 11);
        L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
            minZoom: 1,
            maxZoom: 20
        }).addTo(map);

        L.marker([lat, lon], { icon: L.icon({iconUrl: '/images/balise.jpg'})}).addTo(map);
    }
});
