<?php
  require "key_path.php";

  $key = connection();
  $sql = "SELECT restaurant_id , restaurant_name, address, photo_path as photo_path from
    restaurant";
  $res = $key->prepare($sql);
  $res->execute();

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>List data restoran</title>
  </head>
  <body>
    <table border="1">
      <tr>
        <th>No.</th>
        <th>Nama Restoran</th>
        <th>Alamat</th>
        <th>Foto</th>
        <th>Rating</th>
        <th>Tambahkan Rating</th>
      </tr>
      <?php
      $i = 1;
      $newkey = connection();
      while($row = $res->fetch()):
        $ratingsql = "SELECT sum(rating) as jumlah_rating, count(rating) as total_rating from rating WHERE restaurant_id = ?";
        $resrating = $newkey->prepare($ratingsql);
        $resrating->execute([$row['restaurant_id']]);
        $countrating = $resrating->fetch();
        $total_rating = 0;
        if(!empty($countrating['jumlah_rating'])){
          $total_rating = $countrating['jumlah_rating'] / $countrating['total_rating'];
        }

        ?>
      <tr>
        <td><?= $i; ?></td>
        <td><?= $row['restaurant_name']; ?></td>
        <td><?= $row['address']; ?></td>
        <td><img src="<?=$row['photo_path']; ?>" width="300" height="300"></td>
        <td><?= round($total_rating, 2) ?></td>
        <td><a href="tambah_rating.php?id=<?= $row['restaurant_id']; ?>&nama_resto=<?= $row['restaurant_name']?>&rating=<?= $total_rating ?>">Tambah rating</a></td>
      </tr>
    <?php
      $i++;
      endwhile; ?>
    </table>
  </body>
</html>
