<?php
$data = file_get_contents("products.json");
$products = json_decode($data, true);

foreach ($products as $p) {
    echo $p['name'] . " - Rs " . $p['price'] . "<br>";
}
?>
