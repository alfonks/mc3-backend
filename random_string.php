<?php
  function makeRandomString() {
    $i = 0; //Reset the counter.
    $possible_keys = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $keys_length = strlen($possible_keys);
    $str = ""; //Let's declare the string, to add later.
    while($i<80) {
        $rand = mt_rand(1,$keys_length-1);
        $str.= $possible_keys[$rand];
        $i++;
    }
    return $str;
  }

 ?>
