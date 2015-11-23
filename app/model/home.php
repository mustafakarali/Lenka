<?php
class Home
{
	function slides($lang_id)	
	{
		return select('slides')->where('lang_id = "'.$_SESSION['lang_id'].'" AND slide_group = 1')->results();
	}
	function popup()
	{
		return select('popup')->where('lang_id = "'.$_SESSION['lang_id'].'"')->result();
	}
}

$p = new Product();
$p->limit = 6;
//$p->short_name = 24;
$featured_products = $p->products_featured();

$p->limit = 12;
$new_products = $p->products_recently_added();
shuffle($new_products);


$manufacturers = $p->manufacturers();


$blog = new Blog();
$blog->short_summary = 300;
$blog->is_public = '= 1';
$blog->limit = 6;
$blog->condition = 'ORDER BY contents.content_order ASC, contents.content_time DESC';
$contents = $blog->contents();