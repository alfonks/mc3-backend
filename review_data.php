<?php
  require "key_path.php";
  require "json_struct.php";
  require "random_name.php";

  $random = rand(3,6);
  $key = connection();
  $sql = "SELECT * FROM rating ORDER BY RAND () LIMIT " . $random ;
  $res = $key->prepare($sql);
  $res->execute();
  $review = [];
  while($row = $res->fetch()) {
    $obj = new review_struct();
    $obj->name = name_generator();
    $obj->rating = $row['rating'];
    $obj->review = $row['review'];
    array_push($review, $obj);
  }

  echo json_encode(['result' => $review]);

 ?>
