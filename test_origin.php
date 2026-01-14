<?php
$q = "Medan"; // kata kunci pencarian

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search=" . urlencode($q),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTPHEADER => array(
    "key: 80211fc6748543f2cd0d7bd34b479601035f641a26dbf2eecd8ba9b873d58b84"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

echo "<pre>";
if ($err) {
   echo "Error: $err";
} else {
   print_r(json_decode($response, true));
}
echo "</pre>";
