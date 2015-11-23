<?php
$c = new Checkout();
		
if (isset($_POST)) 
{
	if (isset($_POST['checkout']))
	{
		array_walk($_POST, 'security');
		
		$order_id = $c->add_order($_POST, $_SESSION['cart']);
	}
}