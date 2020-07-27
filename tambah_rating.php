<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Tambah rating</title>
  </head>
  <body>
    <label><b>Nama Restoran</b>: <?= $_GET['nama_resto']; ?></label>
    <br>
    <label><b>Rating Sekarang</b>: <?= $_GET['rating']; ?>
    <br><br>

    <form action="tambah_rating_process.php?id=<?= $_GET['id']; ?>" method="post">
      <div class="form-group">
        <label>Nilai Rating</label>
        <select name="nilai_rating">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </div>

      <div class="form-grop">
        <label>Komentar</label>
        <textarea type="text" class="form-control" name="comment" rows="5" cols="100"></textarea>
      </div>
      <br>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </body>
</html>
