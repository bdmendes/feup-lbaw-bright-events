
async function getAddress(lat, lon) {
  // https://nominatim.openstreetmap.org/reverse.php?lat=41.3647716&lon=-8.1989321&zoom=18&format=jsonv2
  let url =
      'https://nominatim.openstreetmap.org/reverse.php?accept-language=en&lat=' +
      lat + '&lon=' + lon + '&format=jsonv2';
  let options = {
    method: 'get',
    headers: {'Content-Type': 'application/json'},
  };
  let response = await fetch(url, options);
  let data = await response.text();
  data = JSON.parse(data);
  return data;
}


function searchMap() {
  let queryParam = document.getElementById('mapGlobalFilter').value;
  let url =
      'https://nominatim.openstreetmap.org/search?format=json&accept-language=en&q=' +
      queryParam;
  let options = {
    method: 'get',
    headers: {'Content-Type': 'application/json'},
  };
  fetch(url, options).then((response) => response.text()).then(data => {
    data = JSON.parse(data)[0];
    let lat = data.lat;
    let lon = data.lon;
    let name = data.display_name;
    map.setView([lat, lon], 16);
  });
}


async function clickMap(ev) {
  let cityHtml = document.getElementById('city');
  let postcodeHtml = document.getElementById('postcode');
  let countryHtml = document.getElementById('country');
  let displayNameHtml = document.getElementById('display_name');
  let latHtml = document.getElementById('lat');
  let longHtml = document.getElementById('long');
  cityHtml.classList.remove('black');
  postcodeHtml.classList.remove('black');
  countryHtml.classList.remove('black');
  displayNameHtml.classList.remove('black');

  if (mapMarker != null) {
    map.removeLayer(mapMarker);
  }
  mapMarker = L.marker(ev.latlng).addTo(map);
  let data = await getAddress(ev.latlng.lat, ev.latlng.lng);
  let address = data['address'];
  cityHtml.value = address['city'];
  postcodeHtml.value = address['postcode'];
  countryHtml.value = address['country'];
  displayNameHtml.value = data['display_name'];


  latHtml.value = ev.latlng.lat;
  longHtml.value = ev.latlng.lng;
  giveBlack();
}

function giveBlack() {
  let cityHtml = document.getElementById('city');
  let postcodeHtml = document.getElementById('postcode');
  let countryHtml = document.getElementById('country');
  let displayNameHtml = document.getElementById('display_name');
  cityHtml.classList.add('black');
  postcodeHtml.classList.add('black');
  countryHtml.classList.add('black');
  displayNameHtml.classList.add('black');
}
