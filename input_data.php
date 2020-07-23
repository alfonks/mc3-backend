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
    <form class="input restaurant data" action="input_data_process.php" method="post">
      <div class="form-group">
        <label for="Restaurantname">Nama Restoran</label>
        <input type="text" class="form-control" id="nama_restoran" placeholder="Nama Restoran">
      </div>

      <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea type="text" class="form-control" id="alamat_restoran" placeholder="Alamat Restoran" rows="5"></textarea>
      </div>

      <div class = "form-row align-items-center">
        <div class="col-auto">
          <label for="koordinat">Koordinat Peta</label>
        </div>
        <div class="col-auto">
          <input type="text" class="form-control" id="latitude" value="-6.8272197" readonly>
        </div>
        <div class="col-auto">
          <input type="text" class="form-control" id="longitude" value="107.5265488" readonly>
        </div>

      </div>
      <div id="mapCanvas"></div>
      <br>

      <div class="form-group">
        <label for="telefon">Telefon Restoran</label>
        <input type="text" class="form-control" id="telefon_restoran" placeholder="telefon restoran (optional)"></input>
      </div>
      <br>

      <div class="form-row align-items-center">
        <div class="col-auto">
          <label for="openhour">Open Hour</label>
          <input type="text" class="form-control" id="jam_buka" placeholder="jam buka"></input>
        </div>
        <div class="col-auto">
          <label for="closehour">Close Hour</label>
          <input type="text" class="form-control" id="jam_tutup" placeholder="jam tutup"></input>
        </div>

      </div>
      <br>

      <div class="form-group">
        <label for="closeday">Hari Tidak Jualan</label>
        <br>
        <select id="hari_tutup" name="days">
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
          <label for="lowprice">Lowest Price</label>
          <input type="text" class="form-control" id="harga_murah" placeholder="Lowest Price"></input>
        </div>
        <div class="col-auto">
          <label for="highpricer">Highest Price</label>
          <input type="text" class="form-control" id="harga_mahal" placeholder="Highest Price"></input>
        </div>
      </div>
      <br>

      <div class="form-group">
        <label for="grouprice">Group Price(Range 1 - 5)</label>
        <input type="text" class="form-control" id="group_price" placeholder="Group Price(Range 1 - 5)">
      </div>
      <br>

      <div class="form-group">
        <label>Deskripsi (Optional)</label>
        <textarea type="text" class="form-control" id="deskripsi" placeholder="Deskripsi (Optional)" rows="5"></textarea>
      </div>

      <div class="form-group">
        <label>History (Optional)</label>
        <textarea type="text" class="form-control" id="history" placeholder="History (Optional)" rows="5"></textarea>
      </div>

      <div class="form-group">
        <label>Fun Fact (Optional)</label>
        <textarea type="text" class="form-control" id="fun_fact" placeholder="Fun Fact (Optional)" rows="5"></textarea>
      </div>
      <br>

      <div class="form-group">
        <label>Upload your image here</label><br>
        <input type="file" name="files[]" multiple>
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <script>
      var position = [-6.8272197, 107.5265488];

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
        document.getElementById("latitude").value = position[0];
        document.getElementById("longitude").value = position[1];
      }
    </script>
  </body>
</html>
