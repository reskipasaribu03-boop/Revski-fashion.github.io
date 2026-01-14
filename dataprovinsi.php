<?php
require_once "config.php";

$url = "https://api.binderbyte.com/v1/wilayah/provinsi?api_key=$api_key_binderbyte";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

// Debug (sementara)
if (!$data) {
    echo "<option value=''>API tidak merespon</option>";
    exit;
}

if (!isset($data["value"])) {
    echo "<option value=''>Tidak ada data provinsi</option>";
    exit;
}

foreach($data["value"] as $prov){
    echo "<option value='".$prov['id']."'>".$prov['name']."</option>";
}
?>
