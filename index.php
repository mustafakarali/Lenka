<?php

/**** .htaccess dosya içeriği aşağıdaki şekilde tanımlanabilir ****

    SetOutputFilter DEFLATE
    AddDefaultCharset UTF-8
    DefaultLanguage tr-TR
    RewriteEngine On
    RewriteBase /
    RewriteCond %{HTTP_HOST} ^www\.(.*)$ [NC]
    RewriteRule ^(.*)$ http://%1/$1 [R=301,L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L]

******************************************************************/

// Important apache & php settings
ini_set('session.bug_compat_warn', 0);
ini_set('session.bug_compat_42', 0);
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_language('uni');
mb_regex_encoding('UTF-8');

// Include the main.php
include_once 'app/main.php';

/*
$products = select('products')->results();
foreach ($products AS $p)
{
    $b = select('products_copy')->where('product_id = '.$p['product_id'])->result();

    $price = $b['product_price']/1.30;
    update('products')->values(array('product_price'=>$price))->where('product_id = '.$p['product_id']);
}
*/
