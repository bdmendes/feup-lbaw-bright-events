
async function getAddress(lat, lon){
    //https://nominatim.openstreetmap.org/reverse.php?lat=41.3647716&lon=-8.1989321&zoom=18&format=jsonv2
    let url =  "https://nominatim.openstreetmap.org/reverse.php?accept-language=en&lat="+lat+"&lon="+lon+"&format=jsonv2";
    let  options = {
        method: 'get' ,
        headers: {
            'Content-Type': 'application/json'
        },
      };
    let response = await fetch(url, options);
    let data = await response.text();
    data = JSON.parse(data);
    return data;

}


function searchMap(){
    let queryParam = document.getElementById("mapGlobalFilter").value;
    console.log("queryParam = " + queryParam);
    let url =  "https://nominatim.openstreetmap.org/search?format=json&accept-language=en&q=" + queryParam;
    let  options = {
        method: 'get' ,
        headers: {
            'Content-Type': 'application/json'
        },
      };
    fetch(url, options)
    .then((response) => response.text())
    .then(data => {
        data = JSON.parse(data)[0];
        console.log("lat = " + JSON.stringify(data));
        let lat = data.lat;
        let lon = data.lon;
        let name = data.display_name;
        console.log("lat = " + lat + " lon = " + lon);
        map.setView([lat, lon], 16);
    });
}
