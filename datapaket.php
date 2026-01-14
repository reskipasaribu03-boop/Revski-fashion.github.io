<?php
require_once "config.php";

$city_id = $_GET['city_id']; 
$weight = 1000; // gram
$courier = $_GET['courier']; // jne / jnt / sicepat

$url = "https://api.binderbyte.com/v1/cost?api_key=$api_key_binderbyte&courier=$courier&origin=$origin_city_id&destination=$city_id&weight=$weight";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "<option value=''>cURL Error: $error</option>";
    exit;
}

$data = json_decode($response, true);

// Cek struktur JSON BinderByte
if (!$data || !isset($data["data"]["price"])) {
    echo "<option value=''>Tidak ada paket tersedia</option>";
    exit;
}

// Loop harga
foreach ($data["data"]["price"] as $paket) {
    echo "<option 
            value='".$paket['service']."' 
            data-ongkir='".$paket['cost']."'
            data-estimasi='".$paket['estimation']."'>
            ".$paket['service']." - Rp ".number_format($paket['cost'])." (".$paket['estimation'].")
          </option>";
}
?>
