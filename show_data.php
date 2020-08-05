<?php
  require "key_path.php";
  require "json_struct.php";
  $key = connection();
  $array_data = [];
  if(isset($_GET['category'])) {
    $param = $_GET['category'];
    $sql = "SELECT * FROM restaurant WHERE category = ?";
    $res = $key->prepare($sql);
    $res->execute([$param]);

    while($row = $res->fetch()) {
      $days = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
      $galery = [];
      $obj = new resto_struct();
      $obj->id_resto = $row['restaurant_id'];
      $obj->category = $row['category'];
      $obj->resto_name = $row['restaurant_name'];
      $obj->lat = $row['latitude'];
      $obj->lng = $row['longitude'];
      $obj->jam_buka = (isset($row['open_hour'])) ? $row['open_hour'] : "-";
      $obj->jam_tutup = (isset($row['close_hour'])) ? $row['close_hour'] : "-";

      //Days open
      if($row['open_day'] == "allday") {
        $obj->schedule = $days;
      } else {
        $final_day = [];
        foreach($days as $day) {
          if($row['open_day'] == $day) {
            continue;
          } else {
            array_push($final_day, $day);
          }
        }
        $obj->schedule = $final_day;
      }

      $obj->price_group = str_repeat("$",$row['group_price']);
      $obj->price = "Rp. " . $row['lowest_price'] . " - Rp. " . $row['highest_price'];
      $obj->address = $row['address'];
      $obj->contact = (isset($row['phone'])) ? $row['phone'] : "-";
      $obj->overview = (isset($row['description'])) ? $row['description'] : "-";
      $obj->history = (isset($row['history'])) ? $row['history'] : "-";
      $obj->fun_fact = (isset($row['fun_facts'])) ? $row['fun_facts'] : "-";


      $newkey = connection();
      $rat_sql = "SELECT * FROM rating ORDER BY RAND() LIMIT 10";
      $res_rating = $newkey->prepare($rat_sql);
      $res_rating->execute();
      $total = 0;
      while($fetch_data = $res_rating->fetch()) {
        $total += $fetch_data['rating'];
      }

      $obj->rating = number_format($total / 10, 1);
      $obj->image = "http://travelfunmc3.freesite.vip/".$row['photo_path'];

      $otherkey = connection();
      $galery_sql = "SELECT * FROM photo WHERE restaurant_id = ?";
      $res_galery = $otherkey->prepare($galery_sql);
      $res_galery->execute([$row['restaurant_id']]);

      while($galery_row = $res_galery->fetch()) {
        $path = "http://travelfunmc3.freesite.vip/".$galery_row['photo_path'];
        array_push($galery, $path);
      }

      $obj->galery_images =  $galery;

      array_push($array_data, $obj);
    }
    echo json_encode(['result' => $array_data]);

  } elseif (isset($_GET['id'])){
    $param = $_GET['id'];
    $sql = "SELECT * FROM restaurant WHERE restaurant_id = ?";
    $res = $key->prepare($sql);
    $res->execute([$param]);
    $obj = new resto_struct();
    $days = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
    $galery = [];
    $row = $res->fetch();
    if(isset($row['restaurant_id'])) {

        $obj->id_resto = $row['restaurant_id'];
        $obj->category = $row['category'];
        $obj->resto_name = $row['restaurant_name'];
        $obj->lat = $row['latitude'];
        $obj->lng = $row['longitude'];
        $obj->jam_buka = (isset($row['open_hour'])) ? $row['open_hour'] : "-";
        $obj->jam_tutup = (isset($row['close_hour'])) ? $row['close_hour'] : "-";

        //Days open
        if($row['open_day'] == "allday") {
            $obj->schedule = $days;
        } else {
            $final_day = [];
            foreach($days as $day) {
            if($row['open_day'] == $day) {
                continue;
            } else {
                array_push($final_day, $day);
            }
            }
            $obj->schedule = $final_day;
        }

        $obj->price_group = str_repeat("$",$row['group_price']);
        $obj->price = "Rp. " . $row['lowest_price'] . " - Rp. " . $row['highest_price'];
        $obj->address = $row['address'];
        $obj->contact = (isset($row['phone'])) ? $row['phone'] : "-";
        $obj->overview = (isset($row['description'])) ? $row['description'] : "-";
        $obj->history = (isset($row['history'])) ? $row['history'] : "-";
        $obj->fun_fact = (isset($row['fun_facts'])) ? $row['fun_facts'] : "-";


        $newkey = connection();
        $rat_sql = "SELECT * FROM rating ORDER BY RAND() LIMIT 10";
        $res_rating = $newkey->prepare($rat_sql);
        $res_rating->execute();
        $total = 0;
        while($fetch_data = $res_rating->fetch()) {
        $total += $fetch_data['rating'];
        }

        $obj->rating = number_format($total / 10, 1);
        $obj->image = "http://travelfunmc3.freesite.vip/".$row['photo_path'];

        $otherkey = connection();
        $galery_sql = "SELECT * FROM photo WHERE restaurant_id = ?";
        $res_galery = $otherkey->prepare($galery_sql);
        $res_galery->execute([$row['restaurant_id']]);

        while($galery_row = $res_galery->fetch()) {
        $path = "http://travelfunmc3.freesite.vip/".$galery_row['photo_path'];
        array_push($galery, $path);
        }

        $obj->galery_images =  $galery;

        echo json_encode(['result' => $obj]);
    } else {

        echo json_encode(['result' => $array_data]);
    }


  } elseif(isset($_GET['rand'])) {
    // $param = $_GET['rand'];
    $sql = "SELECT * FROM restaurant ORDER BY RAND() LIMIT ".$_GET['rand'];
    $res = $key->prepare($sql);
    $res->execute();

    while($row = $res->fetch()) {
      $days = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
      $galery = [];
      $obj = new resto_struct();
      $obj->id_resto = $row['restaurant_id'];
      $obj->category = $row['category'];
      $obj->resto_name = $row['restaurant_name'];
      $obj->lat = $row['latitude'];
      $obj->lng = $row['longitude'];
      $obj->jam_buka = (isset($row['open_hour'])) ? $row['open_hour'] : "-";
      $obj->jam_tutup = (isset($row['close_hour'])) ? $row['close_hour'] : "-";

      //Days open
      if($row['open_day'] == "allday") {
        $obj->schedule = $days;
      } else {
        $final_day = [];
        foreach($days as $day) {
          if($row['open_day'] == $day) {
            continue;
          } else {
            array_push($final_day, $day);
          }
        }
        $obj->schedule = $final_day;
      }

      $obj->price_group = str_repeat("$",$row['group_price']);
      $obj->price = "Rp. " . $row['lowest_price'] . " - Rp. " . $row['highest_price'];
      $obj->address = $row['address'];
      $obj->contact = (isset($row['phone'])) ? $row['phone'] : "-";
      $obj->overview = (isset($row['description'])) ? $row['description'] : "-";
      $obj->history = (isset($row['history'])) ? $row['history'] : "-";
      $obj->fun_fact = (isset($row['fun_facts'])) ? $row['fun_facts'] : "-";


      $newkey = connection();
      $rat_sql = "SELECT * FROM rating ORDER BY RAND() LIMIT 10";
      $res_rating = $newkey->prepare($rat_sql);
      $res_rating->execute();
      $total = 0;
      while($fetch_data = $res_rating->fetch()) {
        $total += $fetch_data['rating'];
      }

      $obj->rating = number_format($total / 10, 1);
      $obj->image = "http://travelfunmc3.freesite.vip/".$row['photo_path'];

      $otherkey = connection();
      $galery_sql = "SELECT * FROM photo WHERE restaurant_id = ?";
      $res_galery = $otherkey->prepare($galery_sql);
      $res_galery->execute([$row['restaurant_id']]);

      while($galery_row = $res_galery->fetch()) {
        $path = "http://travelfunmc3.freesite.vip/".$galery_row['photo_path'];
        array_push($galery, $path);
      }

      $obj->galery_images =  $galery;

      array_push($array_data, $obj);
    }
    echo json_encode(['result' => $array_data]);
  } elseif (isset($_GET['place'])){
    $param = $_GET['place'];
    $sql = "SELECT * FROM restaurant WHERE (restaurant_name like ? or restaurant_name like ?
     or restaurant_name like ?)";
    $res = $key->prepare($sql);
    $res->execute([
      $param."%",
      "%".$param."%",
      "%".$param
    ]);

    while($row = $res->fetch()) {
      $days = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
      $galery = [];
      $obj = new resto_struct();
      $obj->id_resto = $row['restaurant_id'];
      $obj->category = $row['category'];
      $obj->resto_name = $row['restaurant_name'];
      $obj->lat = $row['latitude'];
      $obj->lng = $row['longitude'];
      $obj->jam_buka = (isset($row['open_hour'])) ? $row['open_hour'] : "-";
      $obj->jam_tutup = (isset($row['close_hour'])) ? $row['close_hour'] : "-";

      //Days open

      if($row['open_day'] == "allday") {
        $obj->schedule = $days;
      } else {
        $final_day = [];
        foreach($days as $day) {
          if($row['open_day'] == $day) {
            continue;
          } else {
            array_push($final_day, $day);
          }
        }
        $obj->schedule = $final_day;
      }



      $obj->price_group = str_repeat("$",$row['group_price']);
      $obj->price = "Rp. " . $row['lowest_price'] . " - Rp. " . $row['highest_price'];
      $obj->address = $row['address'];
      $obj->contact = (isset($row['phone'])) ? $row['phone'] : "-";
      $obj->overview = (isset($row['description'])) ? $row['description'] : "-";
      $obj->history = (isset($row['history'])) ? $row['history'] : "-";
      $obj->fun_fact = (isset($row['fun_facts'])) ? $row['fun_facts'] : "-";


      $newkey = connection();
      $rat_sql = "SELECT * FROM rating ORDER BY RAND() LIMIT 10";
      $res_rating = $newkey->prepare($rat_sql);
      $res_rating->execute();
      $total = 0;
      while($fetch_data = $res_rating->fetch()) {
        $total += $fetch_data['rating'];
      }

      $obj->rating = number_format($total / 10, 1);
      $obj->image = "http://travelfunmc3.freesite.vip/".$row['photo_path'];

      $otherkey = connection();
      $galery_sql = "SELECT * FROM photo WHERE restaurant_id = ?";
      $res_galery = $otherkey->prepare($galery_sql);
      $res_galery->execute([$row['restaurant_id']]);

      while($galery_row = $res_galery->fetch()) {
        $path = "http://travelfunmc3.freesite.vip/".$galery_row['photo_path'];
        array_push($galery, $path);
      }

      $obj->galery_images =  $galery;

      array_push($array_data, $obj);
    }
    echo json_encode(['result' => $array_data]);

  } else {
    $sql = "SELECT * FROM restaurant";
    $res = $key->prepare($sql);
    $res->execute();

    while($row = $res->fetch()) {
      $days = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
      $galery = [];
      $obj = new resto_struct();
      $obj->id_resto = $row['restaurant_id'];
      $obj->category = $row['category'];
      $obj->resto_name = $row['restaurant_name'];
      $obj->lat = $row['latitude'];
      $obj->lng = $row['longitude'];
      $obj->jam_buka = (isset($row['open_hour'])) ? $row['open_hour'] : "-";
      $obj->jam_tutup = (isset($row['close_hour'])) ? $row['close_hour'] : "-";

      //Days open

      if($row['open_day'] == "allday") {
        $obj->schedule = $days;
      } else {
        $final_day = [];
        foreach($days as $day) {
          if($row['open_day'] == $day) {
            continue;
          } else {
            array_push($final_day, $day);
          }
        }
        $obj->schedule = $final_day;
      }



      $obj->price_group = str_repeat("$",$row['group_price']);
      $obj->price = "Rp. " . $row['lowest_price'] . " - Rp. " . $row['highest_price'];
      $obj->address = $row['address'];
      $obj->contact = (isset($row['phone'])) ? $row['phone'] : "-";
      $obj->overview = (isset($row['description'])) ? $row['description'] : "-";
      $obj->history = (isset($row['history'])) ? $row['history'] : "-";
      $obj->fun_fact = (isset($row['fun_facts'])) ? $row['fun_facts'] : "-";


      $newkey = connection();
      $rat_sql = "SELECT * FROM rating ORDER BY RAND() LIMIT 10";
      $res_rating = $newkey->prepare($rat_sql);
      $res_rating->execute();
      $total = 0;
      while($fetch_data = $res_rating->fetch()) {
        $total += $fetch_data['rating'];
      }

      $obj->rating = number_format($total / 10, 1);
      $obj->image = "http://travelfunmc3.freesite.vip/".$row['photo_path'];

      $otherkey = connection();
      $galery_sql = "SELECT * FROM photo WHERE restaurant_id = ?";
      $res_galery = $otherkey->prepare($galery_sql);
      $res_galery->execute([$row['restaurant_id']]);

      while($galery_row = $res_galery->fetch()) {
        $path = "http://travelfunmc3.freesite.vip/".$galery_row['photo_path'];
        array_push($galery, $path);
      }

      $obj->galery_images =  $galery;

      array_push($array_data, $obj);
    }
    echo json_encode(['result' => $array_data]);
  }



 ?>
