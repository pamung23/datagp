<template>
    <div ref="map" style="height: 400px;"></div>
  </template>
  
  <script>
  import 'leaflet/dist/leaflet.css';
  import L from 'leaflet';
  
  export default {
    mounted() {
      const map = L.map(this.$refs.map).setView([51.505, -0.09], 13);
  
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);
  
      // Tambahkan marker ke peta
      L.marker([51.505, -0.09]).addTo(map)
        .bindPopup('Ini adalah marker Leaflet.')
        .openPopup();
    }
  }
  </script>
  