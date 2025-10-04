const coordinatesFieldClass = 'ea-coordinates-field';

function loadLeafletCSS() {
    return new Promise((resolve) => {
        if (document.getElementById('leaflet-css')) {
            return resolve();
        }
        const link = document.createElement('link');
        link.id = 'leaflet-css';
        link.rel = 'stylesheet';
        link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
        link.onload = resolve;
        document.head.appendChild(link);
    });
}

function loadLeafletJS() {
    return new Promise((resolve) => {
        if (typeof L !== 'undefined') return resolve();
        const script = document.createElement('script');
        script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
        script.onload = resolve;
        document.body.appendChild(script);
    });
}

const getCoordinatesSettings = (element) => ({
    lat: parseFloat(element.dataset.lat) || 48.8566,
    lng: parseFloat(element.dataset.lng) || 2.3522,
    zoom: parseInt(element.dataset.zoom) || 13,
});

const initCoordinatesField = (container) => {
    const settings = getCoordinatesSettings(container);
    const mapDiv = container.querySelector('.ea-coordinates-map');
    const latInput = container.querySelector('.ea-coordinates-lat');
    const lngInput = container.querySelector('.ea-coordinates-lng');

    const map = L.map(mapDiv).setView([settings.lat, settings.lng], settings.zoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    const marker = L.marker([settings.lat, settings.lng], { draggable: true }).addTo(map);

    marker.on('dragend', () => {
        const latlng = marker.getLatLng();
        latInput.value = latlng.lat;
        lngInput.value = latlng.lng;
    });
};

document.addEventListener('DOMContentLoaded', async () => {
    await loadLeafletCSS();
    await loadLeafletJS();

    const mapFields = document.querySelectorAll(`.${coordinatesFieldClass}`);
    mapFields.forEach(initCoordinatesField);
});
