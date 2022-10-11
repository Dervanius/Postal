<?php
  $prefix = "kurir.transfera.com/index.php?qr=";

  $n=13;
  function getSuffix($n) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
  }

  $sufix = getSuffix($n);
 echo trim($prefix).trim($sufix);
// echo 'Bane';
  $_SESSION['prefix'] = $prefix;
