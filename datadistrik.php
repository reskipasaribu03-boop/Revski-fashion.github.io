<?php
require_once "config.php";

$prov_id = $_GET['prov_id'];

$url = "https://api.binderbyte.com/v1/wilayah/kabupaten?api_key=$api_key_binderbyte&provinsi_id=$prov_id";

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

if (!$data || !isset($data["value"])) {
    echo "<option value=''>Gagal mengambil kota/kabupaten</option>";
    exit;
}

foreach ($data["value"] as $city) {
    echo "<option value='".$city['id']."'>".$city['name']."</option>";
}
?>
