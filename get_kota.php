<?php
require 'config.php';

$id_prov = $_GET['provinsi'];

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.binderbyte.com/wilayah/kabupaten?api_key=$api_key&id_provinsi=$id_prov",
    CURLOPT_RETURNTRANSFER => true,
]);

$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);

echo "<option value=''>-- Pilih Kota/Kabupaten --</option>";

if ($data['status'] != 200) exit;

foreach ($data['value'] as $kab) {
    echo "<option value='".$kab['id']."'>".$kab['name']."</option>";
}
?>
