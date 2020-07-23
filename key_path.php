<?php
  function connection(){
    try {
      $a = "mysql:host=localhost; dbname=frsiv_26319363_mc3travel";
      $key = new PDO($a,"root","");
      return $key;
    } catch (PDOExcption $e){

    }
  }
 ?>
