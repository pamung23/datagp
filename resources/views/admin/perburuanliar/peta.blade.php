<!DOCTYPE html>
<html>

<head>
    <title>Leaflet Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map {
            height: 1000px;
        }
    </style>
</head>

<body>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="{{ asset('peta/datajson.js') }}"></script>
    <script src="{{ asset('peta/json_LandUse.js') }}"></script>

    <script>
        const map = L.map('map').setView([-6.747446210258649, 106.9672966499052], 11);    
    const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
   
    function doStyleLandUse(feature) {
    let fillColor;
    switch (feature.properties.Classific) {
        case 'Agriculture':
            fillColor = '#93422282';
            break;
        case 'Forest':
            fillColor = '#c2d45b85';
            break;
        case 'Open Field':
            fillColor = '#b0502682';
            break;
        case 'Plantation':
            fillColor = '#2be35f82';
            break;
        case 'Rawa':
            fillColor = '#3bc32682';
            break;
        case 'Settlements':
            fillColor = '#53f52680';
            break;
        case 'Shrubs':
            fillColor = '#1911b880';
            break;
        case 'Swamp':
            fillColor = '#89498482';
            break;
        case 'Tubuh air':
            fillColor = '#6976e685';
            break;
        default:
            fillColor = '#000000'; // Warna default jika tidak ada kecocokan
    }

    return {
        weight: '1.04',
        fillColor: fillColor,
        color: '',
        dashArray: '',
        opacity: '1.0',
        fillOpacity: '1.0',
    };
}

// Tambahkan GeoJSON layer dengan gaya yang diatur
L.geoJSON(json_LandUse, {
    style: doStyleLandUse
}).addTo(map);

function doStyledatajson(feature) {
return {
    weight: 1.04,
    color: '#ff0101',
    fillColor: '#c95568',
    dashArray: '',
    opacity: 0.3,
    fillOpacity: 0.0
};
}

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        @foreach($data as $item)
            L.marker([{{ $item->latitude }}, {{ $item->longitude }}])
            .addTo(map)
            .bindPopup("<b>Resort: {{ $item->resort }}</b><br><b>Bulan: {{ $item->bulan }}</b><br><b>Nama Barang: {{ $item->nama }}</b><br>Latitude: {{ $item->latitude }}<br>Longitude: {{ $item->longitude }}");
        @endforeach
    </script>
</body>

</html>