<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
  require "key_path.php";
  $key = connection();
  $sql = "INSERT INTO rating(restaurant_id ,rating, review) VALUES (?,?,?)";
  $res = $key->prepare($sql);
  $res->execute([$_GET['id'], $_POST['nilai_rating'], $_POST['comment']]);

  header('refresh:2;index.php');
?>

<script>
function sweetclick(){
  swal({
    icon: "success",
    title: "Berhasil menambahkan rating",
  });
}
window.onload = sweetclick;
</script>
