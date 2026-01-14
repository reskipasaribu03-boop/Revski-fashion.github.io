<?php
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_TIMEOUT => 15,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "key: KEGNVgXL7621eb8c629e9928maW4nbOe"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

echo "<h3>RESPONSE:</h3>";
echo "<pre>";
var_dump($response);
echo "</pre>";

echo "<h3>ERROR:</h3>";
echo "<pre>";
var_dump($err);
echo "</pre>";
