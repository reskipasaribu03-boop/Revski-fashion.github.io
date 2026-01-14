<?php
require 'config.php';

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.binderbyte.com/wilayah/provinsi?api_key=$api_key",
    CURLOPT_RETURNTRANSFER => true,
]);

$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);

echo "<option value=''>-- Pilih Provinsi --</option>";

if ($data['status'] != 200) exit;

foreach ($data['value'] as $prov) {
    echo "<option value='".$prov['id']."'>".$prov['name']."</option>";
}
?>
