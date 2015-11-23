<?php
$p = new Product();

if (is_numeric(Routes::$func))
{
	$b = new Blog();
	$b->category = Routes::$func;
	$category = $b->category();
	
	$p->category_id = (int)Routes::$func;
	$products = $p->products_in_category();
}
elseif (Routes::$func == 'featured')
{
	$p->limit = 15;
	$products = $p->products_featured();
	Routes::$get[1] = 'ÖNE ÇIKAN ÜRÜNLER';
}
else
{
	$p->limit = 15;
	$products = $p->products_recently_added();
	Routes::$get[1] = 'YENİ ÜRÜNLER';
}

if (isset($_REQUEST['order_by'])) 
{
	if ($_REQUEST['order_by'] == 'product_name_ASC')
	{
		$products = array_orderby($products, 'product_name', SORT_ASC);
	}
	elseif ($_REQUEST['order_by'] == 'product_name_DESC')
	{
		$products = array_orderby($products, 'product_name', SORT_DESC);
	}
	elseif ($_REQUEST['order_by'] == 'product_price_ASC')
	{
		$products = array_orderby($products, 'product_price_with_tax', SORT_ASC);
	}
	elseif ($_REQUEST['order_by'] == 'product_price_DESC')
	{
		$products = array_orderby($products, 'product_price_with_tax', SORT_DESC);
	}
}