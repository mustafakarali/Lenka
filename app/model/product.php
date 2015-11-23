<?php
$b = new Blog();
$categories_product = $b->child_categories($setting['product_category_id']);

/* e-commerce */
$p = new Product();
$p->product_id = Routes::$func;
$product = $p->product();

$p->limit = 6;
$p->short_name = 24;
$new_products = $p->products_recently_added();