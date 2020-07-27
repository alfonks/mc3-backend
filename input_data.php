<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB5m_SwjC-vFd_YcwYyyhE3tCCqqAxyQvE"></script>
    <title>Input Restaurant Data</title>
    <style>
      #mapCanvas{
      width: 100%;
      height: 400px;
      }
    </style>
  </head>
  <body>
    <form action="input_data_process.php" method="post"  enctype="multipart/form-data">
      <div class="form-group">
        <label>Nama Restoran</label>
        <input type="text" class="form-control" id="nama_restoran" name="nama_restoran" placeholder="Nama Restoran"></input>
      </div>

      <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea type="text" class="form-control" name="alamat_restoran" placeholder="Alamat Restoran" rows="5"></textarea>
      </div>

      <div class = "form-row align-items-center">
        <div class="col-auto">
          <label for="koordinat">Koordinat Peta</label>
        </div>
        <div class="col-auto">
          <input type="text" id="lat" class="form-control" name="latitude" value="-6.8272197" onchange="checkLocation()">
        </div>
        <div class="col-auto">
          <input type="text" id="long" class="form-control" name="longitude" value="107.5265488" onchange="checkLocation()">
        </div>
        <div class="col-auto">

        </div>
      </div>
      <div id="mapCanvas"></div>
      <br>

      <div class="form-group">
        <label for="telefon">Telefon Restoran (Optional)</label>
        <input type="text" class="form-control" name="telefon_restoran" placeholder="telefon restoran (optional)"></input>
      </div>
      <br>

      <div class="form-group">
        <label>Kategori Restoran</label>
        <select name="kategori">
          <option value="breakfast">Breakfast</option>
          <option value="lunch">Lunch</option>
          <option value="dinner">Dinner</option>
          <option value="indonesian">Indonesian</option>
          <option value="asian">Asian</option>
          <option value="western">Western</option>
        </select>
      </div>
      <div class="form-row align-items-center">
        <div class="col-auto">
          <label for="openhour">Open Hour</label>
          <input type="text" class="form-control" name="jam_buka" placeholder="jam buka (09:00)"></input>
        </div>
        <div class="col-auto">
          <label for="closehour">Close Hour</label>
          <input type="text" class="form-control" name="jam_tutup" placeholder="jam tutup (23:00)"></input>
        </div>

      </div>
      <br>

      <div class="form-group">
        <label for="closeday">Hari Tidak Jualan</label>
        <br>
        <select name="hari_tutup">
          <option value="allday">Open All Day</option>
          <option value="Senin">Senin</option>
          <option value="Selasa">Selasa</option>
          <option value="Rabu">Rabu</option>
          <option value="Kamis">Kamis</option>
          <option value="Jumat">Jumat</option>
          <option value="Sabtu">Sabtu</option>
          <option value="Minggu">Minggu</option>
        </select>
      </div>

      <div class="form-row align-items-center">
        <div class="col-auto">
          <label for="lowprice">Lowest Price (Contoh: 15000)</label>
          <input type="text" class="form-control" name="harga_murah" placeholder="Lowest Price"></input>
        </div>
        <div class="col-auto">
          <label for="highpricer">Highest Price (Contoh: 250000)</label>
          <input type="text" class="form-control" name="harga_mahal" placeholder="Highest Price"></input>
        </div>
      </div>
      <br>

      <div class="form-group">
        <label for="grouprice">Group Price(Range 1 - 5)</label>
        <select name="price_range">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </div>
      <br>

      <div class="form-group">
        <label>Deskripsi (Optional)</label>
        <textarea type="text" class="form-control" name="deskripsi" placeholder="Deskripsi (Optional)" rows="5"></textarea>
      </div>

      <div class="form-group">
        <label>History (Optional)</label>
        <textarea type="text" class="form-control" name="history" placeholder="History (Optional)" rows="5"></textarea>
      </div>

      <div class="form-group">
        <label>Fun Fact (Optional)</label>
        <textarea type="text" class="form-control" id="fun_fact" placeholder="Fun Fact (Optional)" rows="5"></textarea>
      </div>
      <br>

      <div class="form-group">
        <label>Upload your main image</label><br>
        <input type="file" name="fotoMain" id="main_display">
      </div>

      <div class="form-group">
        <label>Upload your display gallery (Optional)</label><br>
        <input type="file" name="files[]" id="gallery_display" multiple>
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <script>
      var position = [-6.8272197, 107.5265488];

      function checkLocation(){
        position[0] = document.getElementById("lat").value;
        position[1] = document.getElementById("long").value;
        initialize();
      }


      function initialize() {
          var latlng = new google.maps.LatLng(position[0], position[1]);
          var myOptions = {
              zoom: 16,
              center: latlng,
              mapTypeId: google.maps.MapTypeId.ROADMAP
          };
          map = new google.maps.Map(document.getElementById("mapCanvas"), myOptions);

          marker = new google.maps.Marker({
              position: latlng,
              map: map,
              title: "Latitude:"+position[0]+" | Longitude:"+position[1]
          });

          google.maps.event.addListener(map, 'click', function(event) {
              var result = [event.latLng.lat(), event.latLng.lng()];
              transition(result);
          });
      }

      //Load google map
      google.maps.event.addDomListener(window, 'load', initialize);


      var numDeltas = 100;
      var delay = 10; //milliseconds
      var i = 0;
      var deltaLat;
      var deltaLng;

      function transition(result){
          i = 0;
          deltaLat = (result[0] - position[0])/numDeltas;
          deltaLng = (result[1] - position[1])/numDeltas;
          moveMarker();
      }

      function moveMarker(){
          position[0] += deltaLat;
          position[1] += deltaLng;
          addToForm();
          var latlng = new google.maps.LatLng(position[0], position[1]);
          marker.setTitle("Latitude:"+position[0]+" | Longitude:"+position[1]);
          marker.setPosition(latlng);
          if(i!=numDeltas){
              i++;
              setTimeout(moveMarker, delay);
          }
      }

      function addToForm() {
        document.getElementById("lat").value = position[0];
        document.getElementById("long").value = position[1];
      }
    </script>
  </body>
</html>
