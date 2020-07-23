<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
  require "key_path.php";
  require "random_string.php";
  $key = connection();
  $targetDir = "photo/";
  $allowTypes = ["jpg","png","jpeg","gif"];
  $photo_path = "";

  $sql = "INSERT INTO restaurant (restaurant_name, address, latitude, longitude, phone,
    open_hour, close_hour, open_day, lowest_price, highest_price, group_price, description,
    history, fun_facts, photo_path) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

  $nama_restoran = $_POST['nama_restoran'];
  $alamat = $_POST['alamat_restoran'];
  $lat = $_POST['latitude'];
  $long = $_POST['longitude'];
  $phone = (isset($_POST['telefon_restoran'])) ? $_POST['telefon_restoran'] : "-";
  $open = $_POST['jam_buka'];
  $close = $_POST['jam_tutup'];
  $openday = $_POST['hari_tutup'];
  $lowest = $_POST['harga_murah'];
  $highest = $_POST['harga_mahal'];
  $range = $_POST['price_range'];
  $desc = (isset($_POST['deskripsi'])) ? $_POST['deskripsi'] : "-";
  $history = (isset($_POST['history'])) ? $_POST['history'] : "-";
  $funfact = (isset($_POST['fun_fact'])) ? $_POST['fun_fact'] : "-";
  $mainphoto = $_FILES['fotoMain']['tmp_name'];
  $ext = explode(".", $_FILES['fotoMain']['name']);
  $ext = end($ext);
  $ext = strtolower($ext);

  //check if the extension is valid
  if(in_array($ext, $allowTypes)) {
    $photo_path = $targetDir . makeRandomString() . "." . $ext;
  }
  move_uploaded_file($mainphoto,$photo_path);
  $concatData = [$nama_restoran, $alamat, $lat, $long, $phone, $open,
    $close, $openday, $lowest, $highest, $range, $desc, $history, $funfact,
    $photo_path];

  $res = $key->prepare($sql);
  $res->execute($concatData);

  $fileName = array_filter($_FILES['files']['name']);
  if(!empty($fileName)){
    //Look for restaurant_id for recently inputted data
    $query = "SELECT restaurant_id FROM restaurant WHERE restaurant_name like ? AND
    address like ? AND latitude = ? AND longitude = ?";
    $img_res = $key->prepare($query);
    $img_res->execute([$nama_restoran, $alamat, $lat, $long]);
    $img_row = $img_res->fetch();
    $restaurant_id = $img_row['restaurant_id'];

    foreach($_FILES['files']['name'] as $key=>$val){
      $exten = explode(".", $_FILES['files']['name'][$key]);
      $exten = end($exten);
      $exten = strtolower($exten);

      if(in_array($exten, $allowTypes)) {
        $galery_path = $targetDir . makeRandomString() . "." . $exten;
        move_uploaded_file($_FILES['files']['tmp_name'][$key], $galery_path);
        $new_key = connection();
        $insert_img = "INSERT INTO photo(restaurant_id, photo_path) VALUES (?,?)";
        $result_insert = $new_key->prepare($insert_img);
        $result_insert->execute([$restaurant_id, $galery_path]);
      }
    }
  }

 ?>


 <script>
 function sweetclick(){
   swal({
     icon: "success",
     title: "Success Insert to Database",
   });
 }
 window.onload = sweetclick;
</script>
