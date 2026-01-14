<?php
require 'config.php';

$destination = $_GET['destination'];
$weight      = $_GET['weight'];
$courier     = $_GET['courier'];

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.binderbyte.com/ongkir?"
        . "api_key=$api_key"
        . "&courier=$courier"
        . "&origin=$origin"
        . "&destination=$destination"
        . "&weight=$weight",
    CURLOPT_RETURNTRANSFER => true,
]);

$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);

echo "<option value=''>-- Pilih Paket --</option>";

if ($data['status'] != 200) exit;

foreach ($data['data']['costs'] as $row) {
    $service = $row['service'];
    $value   = $row['cost'][0]['value'];
    $etd     = $row['cost'][0]['etd'];

    echo "<option value='$value'>$service - Rp$value (ETD $etd hari)</option>";
}
?>
