<?php
$p = new Product();
$p->manufacturer_id = (int)Routes::$func;

$manufacturer = $p->manufacturers();
$products = $p->products_by_manufacturer();