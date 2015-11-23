<?php
/** Product Class
 * 
 * @category 	Core
 * @version		0.1.0
 */
class Product
{
	var $product_id = 0;
	var $product_sef;
	var $product;
	
	// Is product featured
	var $is_featured = '>= 0';
	
	// Orders
	var $order_id;
	var $order_status = '>= 0';
	
	// Invoices
	var $invoice_id = false;
	
	// If not registered set 0, else use $_SESSION
	var $user_id = 0;
	
	// Currency
	var $currency_id;
	
	// Status; waitinig, broken etc... which is determined from database table
	var $status_id;
	
	var $short_name = false;
	
	// Category
	var $category_id;
	
	// Feature of product
	var $feature_id = false;
	var $feature_group = false;
	
	// Manufacturer or maker of product
	var $manufacturer_id;
	
	// Tax id
	var $tax_id = false;
	
	// Language id which is checking langs table
	var $lang_id = false;
	
	// Shipping model
	var $shipping_id = false;
	
	// Payment model
	var $payment_id = false;
	
	// Set a limit for sql queries
	var $limit = 99999;
	
	var $format = true;
	
	// Tables which are directly related with products
	public static $table_products = 'products';
	public static $table_products_categories = 'products_categories';
	public static $table_products_comments = 'products_comments';
	public static $table_products_currencies = 'products_currencies';
	public static $table_products_features = 'products_features';
	public static $table_products_images = 'products_images';
	public static $table_products_locals = 'products_locals';
	
	public static $table_products_orders = 'products_orders';
	public static $table_products_orders_products = 'products_orders_products';
	public static $table_products_invoices = 'products_invoices';
	
	public static $table_products_prices = 'products_prices';
	public static $table_products_similars = 'products_similars';
	public static $table_products_taxes = 'products_taxes';
	// Tables which may related with products
	public static $table_addresses = 'addresses';
	public static $table_categories = 'categories';
	public static $table_features = 'features';
	public static $table_features_locals = 'features_locals';
	public static $table_manufacturers = 'manufacturers';
	public static $table_status = 'status';
	
	public static $table_shippings = 'shippings';
	public static $table_payments = 'payments';
	
	public static $table_langs = 'langs';
	
	function __construct()
	{
		$this->product = array();
	}
	function product()
	{
		// Name of product in session lang
		$product['name'] = select(self::$table_products_locals)->where('product_id = '.$this->product_id.' AND lang_id = '.$_SESSION['lang_id'])->result('product_name');
		
		// Local information about product
		$product['locals'] = select(self::$table_products_locals)
						->left(self::$table_langs .' ON '.self::$table_langs.'.lang_id = '.self::$table_products_locals.'.lang_id')
						->where(self::$table_products_locals.'.product_id = '.$this->product_id)
						->results();
		
		// Check the lang_id to show only wanted local information
		if ($this->lang_id)	
		{
			foreach($product['locals'] AS $local)
			{
				if ($this->lang_id == $local['lang_id'])
					$product['locals'] = $local;
				
				break;
			}	
		}
		
		// General information about product
		$product['general'] = select(self::$table_products)
						->left(self::$table_manufacturers .' ON '.self::$table_manufacturers.'.manufacturer_id = '.self::$table_products.'.manufacturer_id')
						->where(self::$table_products.'.product_id = '.$this->product_id)
						->result();
		
		if ($this->format)
			$product['general'] = $this->format_product($product['general']);
			
		// Images of product
		$product['images'] = select(self::$table_products_images)->where(self::$table_products_images.'.product_id = '.$this->product_id)->results();
		
		// Similar products like selected one
		$product['similars'] = $this->similars();
		
		return $product;
	}
	function product_weight($product_id)
	{
		return select(self::$table_products)->where('product_id = '.$product_id)->result('product_weight');
	}
	function product_desi($product_id)
	{
		$product = select(self::$table_products)->where('product_id = '.$product_id)->result();
		return $product['product_l']*$product['product_w']*$product['product_h']/3000;
	}
	function products($category = false)
	{
		if ($category)
		{
			
			$products = select(self::$table_products_categories)
					->left(self::$table_products. ' ON '.self::$table_products.'.product_id = '.self::$table_products_categories.'.product_id')
					->left(self::$table_products_locals .' ON '.self::$table_products_locals.'.product_id = '.self::$table_products.'.product_id')
					->where(self::$table_products_locals.'.lang_id = '.$_SESSION['lang_id'].' AND is_featured '.$this->is_featured.' AND '.self::$table_products_categories.'.category_id = '.$category)
					->group(self::$table_products.'.product_id')
					->results();
				
		}
		else 
		{
			$products = select(self::$table_products)
					->left(self::$table_products_locals .' ON '.self::$table_products_locals.'.product_id = '.self::$table_products.'.product_id')
					->where(self::$table_products_locals.'.lang_id = '.$_SESSION['lang_id'].' AND is_featured '.$this->is_featured)
					->results();
		}
		
		foreach($products AS $product)
			$p[] = $this->format_product($product);
		
		if (isset($p))
			return $p;
	}
	function products_orderby($order)
	{
		$products = select(self::$table_products)
					->left(self::$table_products_locals .' ON '.self::$table_products_locals.'.product_id = '.self::$table_products.'.product_id')
					->where(self::$table_products_locals.'.lang_id = '.$_SESSION['lang_id'])
					->order($order)
					->results();

		foreach($products AS $product)
			$p[] = $this->format_product($product);
		
		if (isset($p))
			return $p;
	}
	function products_recently_added()
	{
		$products = select(self::$table_products)
					->left(self::$table_products_locals .' ON '.self::$table_products_locals.'.product_id = '.self::$table_products.'.product_id')
					->where(self::$table_products_locals.'.lang_id = '.$_SESSION['lang_id'])
					->order(self::$table_products.'.product_id DESC')
					->limit($this->limit)
					->results();
		
		foreach($products AS $product)
			$p[] = $this->format_product($product);
		
		return $p;	
	}
	function products_featured()
	{
		$products = select(self::$table_products)
					->left(self::$table_products_locals .' ON '.self::$table_products_locals.'.product_id = '.self::$table_products.'.product_id')
					->where(self::$table_products_locals.'.lang_id = '.$_SESSION['lang_id'].' AND '.self::$table_products.'.is_featured = 1')
					->order(self::$table_products.'.product_id DESC')
					->limit($this->limit)
					->results();
		
		foreach($products AS $product)
			$p[] = $this->format_product($product);
		
		return $p;	
	}
	function products_in_sale()
	{
		global $site;
		
		$products = select(self::$table_products)
					->left(self::$table_products_locals .' ON '.self::$table_products_locals.'.product_id = '.self::$table_products.'.product_id')
					->where(self::$table_products_locals.'.lang_id = '.$_SESSION['lang_id'].' AND '.self::$table_products.'.sale_start <= '.$site['timestamp'].' AND '.self::$table_products.'.sale_expire >= '.$site['timestamp'])
					->order(self::$table_products.'.product_id DESC')
					->limit($this->limit)
					->results();
		
		foreach($products AS $product)
			$p[] = $this->format_product($product);
		
		if (!empty($p))
		return $p;	
	}
	function products_in_category()
	{
		$products = select(self::$table_products)
					->left(self::$table_products_locals .' ON '.self::$table_products_locals.'.product_id = '.self::$table_products.'.product_id')
					->left(self::$table_products_categories.' ON '.self::$table_products_categories.'.product_id = '.self::$table_products.'.product_id')
					->where(self::$table_products_categories.'.category_id = "'.$this->category_id.'"')
					->group(self::$table_products.'.product_id')
					->order(self::$table_products_locals.'.product_name ASC')
					->results();	
		
		foreach($products AS $product)
			$p[] = $this->format_product($product);
		
		if (!empty($p))
			return $p;
	}
	function products_in_category_order($order, $type)
	{
		$products = select(self::$table_products)
					->left(self::$table_products_locals .' ON '.self::$table_products_locals.'.product_id = '.self::$table_products.'.product_id')
					->left(self::$table_products_categories.' ON '.self::$table_products_categories.'.product_id = '.self::$table_products.'.product_id')
					->where(self::$table_products_categories.'.category_id = "'.$this->category_id.'"')
					->group(self::$table_products.'.product_id')
					->order($order.' '.$type)
					->results();	
		
		foreach($products AS $product)
			$p[] = $this->format_product($product);
		
		return $p;
	}
	function products_by_manufacturer()
	{
		$products = select(self::$table_products)
					->left(self::$table_products_locals .' ON '.self::$table_products_locals.'.product_id = '.self::$table_products.'.product_id')
					->where('manufacturer_id = "'.$this->manufacturer_id.'" AND lang_id = "'.$_SESSION['lang_id'].'"')->results();	
		
		foreach($products AS $product)
			$p[] = $this->format_product($product);
		
		return $p;
	}
	function products_by_search($string)
	{
		$products = select(self::$table_products)
					->left(self::$table_products_locals .' ON '.self::$table_products_locals.'.product_id = '.self::$table_products.'.product_id')
					->where("product_name LIKE '%".$string."%'")
					->results();
					
		foreach($products AS $product)
			$p[] = $this->format_product($product);
		
		return $p;
	}
	function categories_of_product()
	{
		return select(self::$table_products_categories)
				->left(self::$table_categories.' ON '.self::$table_categories.'.category_id = '.self::$table_products_categories.'.category_id')
				->where(self::$table_products_categories.'.product_id = "'.$this->product_id.'" ')->results();
	
	}
	function sub_categories()
	{
		return select(self::$table_categories)
			->where('parent_id = '.$this->category_id)
			->order('category_name ASC')
			->results();
	}
	function product_id_to_sef()
	{
		return select(self::$table_products)->where('product_id = "'.$this->product_id.'"')->result('product_sef');
	}
	function product_sef_to_id()
	{
		return select(self::$table_products)->where('product_sef = "'.$this->product_sef.'"')->result('product_id');
	}
	// Find the linked similar products of the asked content
	function similars()
	{
		$similars = select(self::$table_products_similars)
				->left(self::$table_products.' ON '.self::$table_products.'.product_id = '.self::$table_products_similars.'.similar_id')
				->left(self::$table_products_locals .' ON '.self::$table_products_locals.'.product_id = '.self::$table_products.'.product_id')
				->where(self::$table_products_similars.'.product_id = '.$this->product_id.' AND '.self::$table_products_locals.'.lang_id = '.$_SESSION['lang_id'])->order('product_name ASC')
				->results();
				
		foreach ($similars AS $similar)
			$s[] = $this->format_product($similar);
		
		if (isset($s))
			return $s;
	}
	function not_similars()
	{
		// Contents expect our selected content
		$others = select(self::$table_products)
							->left(self::$table_products_locals .' ON '.self::$table_products_locals.'.product_id = '.self::$table_products.'.product_id')
							->where(self::$table_products_locals.'.product_id <> '.$this->product_id.' AND '.self::$table_products_locals.'.lang_id = '.$_SESSION['lang_id'])->order('product_name ASC')
							->results();
		// Similar contents
		$similars = $this->similars();

		// Unset similars to determine not similar contents
		if (!empty($similars))
		{
			foreach ($similars AS $similar)
			{
				for($i=0; $i<count($others); $i++)
				{
					if ($similar['product_id'] == $others[$i]['product_id'])
						unset ($others[$i]);
				}	
			}	
		}
		return $others;	
	}
	/* Manufacturers */
	function manufacturers($is_public = '>= 0')
	{
		if (empty($this->manufacturer_id))
			return select(self::$table_manufacturers)->where('is_public '.$is_public)->order('manufacturer_name ASC')->results();
		else
			return select(self::$table_manufacturers)->where('manufacturer_id = "'.$this->manufacturer_id.'"')->limit(1)->result();
	}
	function add_manufacturer()
	{
		if (!empty($_POST['name']))
		{
			insert(self::$table_manufacturers)->values(array('manufacturer_name'=>$_POST['name'], 
														 	'manufacturer_sef'=>sef($_POST['name']), 
														 	'manufacturer_desc'=>$_POST['desc'],
														 	'manufacturer_img'=>$_POST['image'],
															'is_public'=>$_POST['is_public']));
			
			echo note('Added successfully');
		}	
	}	
	function edit_manufacturer()
	{
		if (!empty($_POST['name']))
		{
			update(self::$table_manufacturers)->values(array('manufacturer_name'=>$_POST['name'], 
														 	'manufacturer_sef'=>sef($_POST['name']), 
														 	'manufacturer_desc'=>$_POST['desc'],
														 	'manufacturer_img'=>$_POST['image'],
															'is_public'=>$_POST['is_public']))->where('manufacturer_id = "'.$this->manufacturer_id.'"');
			
			echo note('Edited successfully');
		}	
	}
	function manufacturers_for_select()
	{
		$this->manufacturer_id = false;
		$values = $this->manufacturers();
		
		for ($i=0; $i<count($values); $i++)
		{
			$data[$i]['id'] = $values[$i]['manufacturer_id'];
			$data[$i]['value'] = $values[$i]['manufacturer_name'];	
		}
		return $data;
	}
	/* Shippings */
	function shippings()
	{
		if (empty($this->shipping_id))
			return select(self::$table_shippings)->where('shipping_auth <= '.$_SESSION['user_auth'])->group('shipping_id')->order('shipping_order ASC, shipping_id ASC')->results();
		else
			return select(self::$table_shippings)->where('shipping_auth <= '.$_SESSION['user_auth'].' AND shipping_id = "'.$this->shipping_id.'"')->limit(1)->result();
	}
	/* Active shipping models */
	function shippings_public()
	{
		return select(self::$table_shippings)->where('shipping_auth <= '.$_SESSION['user_auth'].' AND is_public = 1')->order('shipping_order ASC, shipping_id ASC')->results();	
	}
	function shipping_price()
	{
		$shipping = $this->shippings();
		return $shipping['shipping_price'];
	}
	function add_shipping()
	{
		global $pdo;
		
		if (!empty($_POST['name']))
		{
			
			insert(self::$table_shippings)->values(array('shipping_type'=>$_POST['type'],
														 'shipping_name'=>$_POST['name'], 
														 'shipping_desc'=>$_POST['desc'],
														 'shipping_price'=>$_POST['price'],
														 'shipping_condition'=>$_POST['condition'],
														 'shipping_order'=>$_POST['order'],
														 'is_public'=>$_POST['is_public']));
			
			$this->shipping_id = $pdo->insert_id();
			
			$this->edit_desies();
			echo note('Added successfully');
		}	
	}	
	function edit_shipping()
	{
		if (!empty($_POST['type']))
		{
			if ($this->shipping_id > 6)
			{
				update(self::$table_shippings)->values(array('shipping_name'=>$_POST['name'], 
														 	 'shipping_desc'=>$_POST['desc']))->where('shipping_id = "'.$this->shipping_id.'"');
			}
 			if ($_POST['type'] == 1)
			{
				update(self::$table_shippings)->values(array('shipping_condition'=>$_POST['condition'],
															 'shipping_order'=>$_POST['order'],
															 'is_public'=>$_POST['is_public']))->where('shipping_id = "'.$this->shipping_id.'"');
			}
			if ($_POST['type'] == 2)
			{
				update(self::$table_shippings)->values(array('shipping_price'=>$_POST['price'],
															 'shipping_condition'=>$_POST['condition'],
															 'shipping_order'=>$_POST['order'],
															 'is_public'=>$_POST['is_public']))->where('shipping_id = "'.$this->shipping_id.'"');
			}
			if ($_POST['type'] == 3)
			{
				update(self::$table_shippings)->values(array('shipping_condition'=>$_POST['condition'],
															 'shipping_order'=>$_POST['order'],
															 'is_public'=>$_POST['is_public']))->where('shipping_id = "'.$this->shipping_id.'"');
			}
			if ($_POST['type'] == 4)
			{
				update(self::$table_shippings)->values(array('shipping_price'=>$_POST['price'],
															 'shipping_condition'=>$_POST['condition'],
															 'shipping_order'=>$_POST['order'],
															 'is_public'=>$_POST['is_public']))->where('shipping_id = "'.$this->shipping_id.'"');
			
				$this->edit_desies();
			}			
			echo note('Edited successfully');
		}	
	}
	function edit_desies()
	{
		delete('shippings_desies')->where('shipping_id = '.$this->shipping_id)->run();	
		
		foreach ($_POST['desi'] AS $desi)
		{
			//ksort($desi['region']);
			$regions = array_keys($desi['region']);
			foreach ($regions AS $region)
			{
				if (!empty($desi['region'][$region]))
				{
					insert('shippings_desies')->values(array('shipping_id'=>$this->shipping_id,
															 'region_id'=>$region,
															 'desi_id'=>$desi['desi_id'],
															 'desi_price'=>$desi['region'][$region]));	
				}	
			}
			
		}
	}
	function shippings_for_select()
	{
		$this->shipping_id = false;
		$values = $this->shippings();
		
		for ($i=0; $i<count($values); $i++)
		{
			$data[$i]['id'] = $values[$i]['shipping_id'];
			$data[$i]['value'] = $values[$i]['shipping_name'];	
		}
		return $data;
	}
	public function shipping_desies_by_regions($desi_id)
	{
		$desies = select('shippings_desies')->where('shipping_id = 6 AND desi_id = '.$desi_id)->results();
		if ($desies)
		{
			foreach ($desies AS $desi)
				$d[$desi['region_id']] = $desi['desi_price'];
				
			return $d;
		}
		return false;
	}
	/* Find region of given city */
	public function shipping_region_of_city($city_id)
	{
		return select('data_cities')->where('city_id = '.$city_id)->limit(1)->result('region_id');
	}
	/* Calculate desi of cart */
	public function shipping_calculate_desi($shipping_id)
	{
		$desi = 0;
		foreach ($_SESSION['cart']['products'] AS $product_id)
		{
			$desi += $this->product_desi($product_id)*$_SESSION['cart']['amount'][$product_id];
		}
		return $desi;
	}
	/* Calculate shipping price for cart depends on various shipping model */
	public function shipping_calculate_price($price, $shipping_id = 0, $city_id = 0)
	{
		if ($shipping_id == 0)
			return 0;
		
		$this->shipping_id = $shipping_id;
		$shipping = $this->shippings();
		
		// Free shipping
		if (($shipping['shipping_type'] == 1 || $shipping['shipping_type'] == 5) && $price >= $shipping['shipping_condition'])
			return 0;
		elseif ($shipping['shipping_type'] == 1)
			return $shipping['shipping_price'];

		// Fixed shipping price
		if ($shipping['shipping_type'] == 2)
		{
			if ($price >= $shipping['shipping_condition'])
			{
				return 0;
			}
			else 
			{
				// Fixed price for order
				if ($shipping['shipping_id'] == 2 || $shipping['shipping_id'] == 4 || $shipping['shipping_id'] == 12)	
				{
					return $shipping['shipping_price'];
				}
				// Fixed price for each product
				if ($shipping['shipping_id'] == 3)	
				{
					$i = 0;
					foreach ($_SESSION['cart']['amount'] AS $amount)
						$i += $amount;

					return $shipping['shipping_price']*$i;	
				}
			}
		}	
		// Shipping by weight
		if ($shipping['shipping_type'] == 3)
		{
			$conditions = explode(',', $shipping['shipping_condition']);
			foreach ($conditions AS $condition)
			{
				$array = explode(':', $condition);
				$shipping[$array[0]] = $array[1];
			}
			if (isset($shipping[$_SESSION['cart']['weight']]))
				$shipping_price = $shipping[$_SESSION['cart']['weight']];
			else
				$shipping_price = '-';
		}
		// Shipping by desi
		if ($shipping['shipping_type'] == 4)
		{
			$price = $shipping['shipping_price'];
			$region_id = $this->shipping_region_of_city($city_id);
			
			$desi = select('shippings_desies')->where('shipping_id = '.$shipping_id.' AND region_id = '.$region_id.' AND desi_id <= '.$_SESSION['cart']['desi'])->order('shipping_desi_id DESC')->result();
			
			if ($_SESSION['cart']['desi'] - $desi['desi_id'] > 1)
			{
				$desi['desi_price'] += ($_SESSION['cart']['desi'] - $desi['desi_id']) * $shipping['shipping_condition'];
				
			}
			$shipping_price = $price + $desi['desi_price'];
		}
		// Shipping by firm
		if ($shipping['shipping_type'] == 5)
		{
			if ($shipping['shipping_type'] < $_SESSION['cart']['price'])
				$shipping_price = $shipping['shipping_price'];
			else
				$shipping_price = 0;
		}
				
		return $shipping_price;
	}
	public function shipping_calculate_price_cheapest()
	{
		
	}
	/* Payments */
	public function payments()
	{
		if ($this->payment_id)
			return select(self::$table_payments)->where('payment_id = '.$this->payment_id)->limit(1)->result();
		else
			return select(self::$table_payments)->where('payment_auth <= '.$_SESSION['user_auth'])->order('payment_order ASC')->results();
	}
	public function payments_public()
	{
		return select(self::$table_payments)->where('is_public = 1 AND payment_auth <= '.$_SESSION['user_auth'])->results();	
	}
	/* Installement of the payment */
	function installement($payment)
	{
		
	}
	function add_payment()
	{
		if (!empty($_POST['name']))
		{
			echo note('Added successfully');
		}	
	}	
	function edit_payment()
	{
		if (!empty($_POST['name']))
		{
			echo note('Edited successfully');
		}	
	}
	function payments_for_select()
	{
		$this->shipping_id = false;
		$values = $this->payments();
		
		for ($i=0; $i<count($values); $i++)
		{
			$data[$i]['id'] = $values[$i]['shipping_id'];
			$data[$i]['value'] = $values[$i]['shipping_name'];	
		}
		return $data;
	}
	/* Taxes */
	function taxes()
	{
		if (!empty($this->tax_id))
			return select(self::$table_products_taxes)->where('tax_id = '.$this->tax_id)->limit(1)->result();
		else	
			return select(self::$table_products_taxes)->results();
	}
	function add_tax()
	{
		if (!empty($_POST['name']))
		{
			insert(self::$table_products_taxes)->values(array('tax_name'=>$_POST['name'], 
												 	 'tax_percent'=>$_POST['percent'],
												 	 'tax_amount'=>$_POST['fixed']));
			
			echo note('Added successfully');
		}	
	}	
	function edit_tax()
	{
		if (!empty($_POST['name']))
		{
			update(self::$table_products_taxes)->values(array('tax_name'=>$_POST['name'], 
												 	 'tax_percent'=>$_POST['desc'],
												 	 'tax_amount'=>$_POST['fixed']))->where('tax_id = "'.$this->tax_id.'"');
			
			echo note('Edited successfully');
		}	
	}
	function taxes_for_select()
	{
		$values = $this->taxes();
		
		for ($i=0; $i<count($values); $i++)
		{
			$data[$i]['id'] = $values[$i]['tax_id'];
			$data[$i]['value'] = $values[$i]['tax_name'];	
		}
		return $data;
	}
	/* Status for products which describes; cancelled, waitinig, completed etc... 
	 * It's important to set different status
	 * 
	 * returns array
	 */
	function status()
	{
		if (empty($this->status_id))
			return select(self::$table_status)->left(self::$table_langs)->using('lang_id')->results();
		else
			return select(self::$table_status)->where('status_id = "'.$this->status_id.'"')->result();
	}
	function add_status()
	{
		global $pdo;
		
		if (!empty($_POST['name']))
		{
			// Find biggest id of the table
			$status_id = (int)select(self::$table_status)->order('status_id DESC')->limit(1)->result('status_id')+1;
			
			// Add local variables of product
			foreach(langs() AS $l)
			{
				if (!empty($_POST['name'][$l['lang_id']]))
				{
					insert(self::$table_status)->values(array('status_id'=>$status_id,
															  'lang_id'=>$l['lang_id'],
															  'status_name'=>$_POST['name'][$l['lang_id']]));
					
					}
			}
			echo note('Added successfully');
		}	
	}	
	function edit_status()
	{
		if (!empty($_POST['status_id']))
		{
			// Find biggest id of the table
			$status_id = $_POST['status_id'];
			delete(self::$table_status)->where('status_id = '.$status_id)->run();
					
			// Add local variables of product
			foreach(langs() AS $l)
			{
				if (!empty($_POST['name'][$l['lang_id']]))
				{
					insert(self::$table_status)->values(array('status_id'=>$status_id,
															  'lang_id'=>$l['lang_id'],
															  'status_name'=>$_POST['name'][$l['lang_id']]));
			
				}
			}
			
			echo note('Edited successfully');
		}	
	}
	function status_for_select()
	{
		$values = $this->status();
		
		for ($i=0; $i<count($values); $i++)
		{
			$data[$i]['id'] = $values[$i]['status_id'];
			$data[$i]['value'] = $values[$i]['status_name'];	
		}
		return $data;
	}
	/* Status for products which describes; cancelled, waitinig, completed etc... 
	 * It's important to set different status
	 * 
	 * returns array
	 */
	function currencies()
	{
		if (empty($this->currency_id))
			return select(self::$table_products_currencies)->order('currency_name ASC')->results();
		else
			return select(self::$table_products_currencies)->where('currency_id = "'.$this->currency_id.'"')->limit(1)->result();
	}
	function add_currency()
	{
		if (!empty($_POST['name']))
		{
			insert(self::$table_products_currencies)
				->values(array('currency_name'=>$_POST['name'], 
							  'currency_code'=>$_POST['code'],
							  'currency_multiplier'=>$_POST['multiplier'],
							  'currency_side'=>$_POST['side'],
							  'currency_order'=>$_POST['order']));
			
			echo note('Added successfully');
		}	
	}	
	function edit_currency()
	{
		if (!empty($_POST['name']))
		{
			update(self::$table_products_currencies)
				->values(array('currency_name'=>$_POST['name'], 
							   'currency_code'=>$_POST['currency_code'],
							   'currency_multiplier'=>$_POST['multiplier'],
							   'currency_side'=>$_POST['side'],
							   'currency_order'=>$_POST['order']))
				->where('currency_id = "'.$this->currency_id.'"');
			
			echo note('Edited successfully');
		}	
	}
	function currencies_for_select()
	{
		$this->currency_id = false;
		$values = $this->currencies();
		
		for ($i=0; $i<count($values); $i++)
		{
			$data[$i]['id'] = $values[$i]['currency_id'];
			$data[$i]['value'] = $values[$i]['currency_name'];	
		}
		return $data;
	}
	/* Features */
	function features($feature_group = 0)
	{
		if ($this->feature_id)
			return select(self::$table_features)
					->left(self::$table_features_locals. ' ON '.self::$table_features_locals.'.feature_id = '. self::$table_features.'.feature_id')
					->where(self::$table_features.'.feature_id = '.$this->feature_id.' AND '.self::$table_features_locals.'.lang_id = '.$_SESSION['lang_id'])->result();
		
		if ($feature_group)
			return select(self::$table_features)->where('feature_group = '.$feature_group)->order('feature_group ASC, feature_id ASC')->results();
		
		return select(self::$table_features)
				->left(self::$table_features_locals.' ON '.self::$table_features_locals.'.feature_id = '. self::$table_features.'.feature_id')
				->where(self::$table_features_locals.'.lang_id = '.$_SESSION['lang_id'])
				->results();
	}
	function features_of_product()
	{
		return select(self::$table_products_features)
				->left(self::$table_features. ' ON '. self::$table_features.'.feature_id = '.self::$table_products_features.'.feature_id')
				->left(self::$table_features_locals. ' ON '.self::$table_features_locals.'.feature_id = '. self::$table_features.'.feature_id')
				->where('product_id = '.$this->product_id)
				->results();
	}
	function add_feature()
	{
		global $pdo;
		
		if (!empty($_POST['name']))
		{
			insert(self::$table_features)->values(array('feature_group'=>0));
			// Find product_id
			$feature_id = $pdo->insert_id();
			
			// Add local variables of product
			foreach(langs() AS $l)
			{
				if (!empty($_POST['name'][$l['lang_id']]))
				{
					insert(self::$table_features_locals)->values(array('feature_id'=>$feature_id,
																	   'lang_id'=>$l['lang_id'],
																	   'feature_name'=>$_POST['name'][$l['lang_id']],
																	   'feature_text'=>$_POST['text'][$l['lang_id']]));
				}
			}
			
			echo note('Added successfully');
		}	
	}	
	function edit_feature()
	{
		if (!empty($_POST['name']))
		{
			update(self::$table_features)->values(array('feature_name'=>$_POST['name'], 
														'feature_text'=>$_POST['text']))
										 ->where('feature_id = "'.$this->feature_id.'"');
			
			echo note('Edited successfully');
		}	
	}
	function orders()
	{
		if ($this->order_id)
		{
			return select(self::$table_products_orders)
					->left('users')->using('user_id')
					->left(self::$table_products_orders_products)->using('order_id')
					->left(self::$table_products_invoices)->using('invoice_id')
					->where(self::$table_products_orders.'.order_id = '.$this->order_id)->results();
		}
		else
		{
			return select(self::$table_products_orders)->where('order_status '.$this->order_status)->results();
		}
	}
	/* Returns products in order list and check prices with current situation */
	function products_in_order()
	{
		$products = select(self::$table_products_orders_products)
					->left(self::$table_products .' ON '.self::$table_products.'.product_id = '.self::$table_products_orders_products.'.product_id')
					->left(self::$table_products_locals .' ON '.self::$table_products.'.product_id = '.self::$table_products_locals.'.product_id')
					->where(self::$table_products_orders_products.'.order_id = '.$this->order_id)
					->group(self::$table_products_orders_products.'.product_id')
					->results();
		
		// Calculate price			
		foreach($products AS $product)
			$p[] = $this->format_product($product);
		
		// Check if order_price is lower than current_price and set a warning variable
		foreach ($p AS $pro)
		{
			if ($pro['product_price_with_tax'] < $pro['order_product_price'])	
				$pro['warning'] = true;

			$prod[] = $pro;
		}
		
		// Return products
		return $prod;	
	}
	function invoices()
	{
		if ($this->invoice_id)
		{
			return select(self::$table_products_invoices)
					->left(self::$table_products_orders)->using('invoice_id')
					->where(self::$table_products_orders.'.invoice_id = '.$this->invoice_id)->result();
		}
		else
			return select(self::$table_products_invoices)->results();
	}
	public function is_order($order_id)
	{
		return select(self::$table_products_orders)->where('order_id = '.$order_id)->limit(1)->result('order_id');
	}
	/* Calculates; last price of product, price with product and price without product 
	 * if product has a sale or other condition which effects product_price, function sets product_price_old, product_price_old_with_tax, product_price_old_without_tax
	 * 
	 * @param array - product
	 * @set product_price_with_tax, product_price_without_tax, product_price_tax, 
	 * @return array - product 
	 */
	public function format_product($product)
	{
		global $setting, $site;
		
		$product['img_c'] = $site['url'].$site['image_dir'].$product['product_img_c'];
		$product['img_t'] = $site['url'].$site['image_dir'].$product['product_img_t'];
		
		if ($this->format)
		{	
			$product['product_price_tax'] = 0;
			$product['product_price_without_tax'] = $product['product_price'];	
			
			/* Calculate by sale */
			if (isset($product['sale_start']) && !empty($product['sale_price']))
			{
				if ($site['timestamp'] >= $product['sale_start'] && $site['timestamp'] <= $product['sale_expire'])
				{
					// Old price of product
					$product['product_price_old'] = $product['product_price'];
					$product['product_price_old_without_tax'] = $product['product_price'];
					// Product price
					$product['product_price'] = $product['sale_price'];	
					$product['product_price_without_tax'] = $product['sale_price'];
				}
			}
			/* Calculate by detailed pricing system */
			if ($setting['product_detailed_pricing'] == 'on' && !empty($product['product_id']))
			{
				$pricing = @select(self::$table_products_prices)
							->where('product_id = "'.$this->product['product_id'].'" AND price_start <= "'.$site['timestamp'].'" AND price_expire >= "'.$site['timestamp'].'"')
							->result();
				
				if ($pricing)
				{
					// Old price of product
					$product['product_price_old'] = $this->product['product_price'];			
					$product['product_price_old_without_tax'] = $pricing['product_price'];	
					// Product price
					$product['product_price'] = $pricing['product_price'];	
					$product['product_price_without_tax'] = $pricing['product_price'];
				}
			}
	
			/* Calculate by tax_id */
			if($product['tax_id'])
			{
				$tax = select(self::$table_products_taxes)->where('tax_id = '.$product['tax_id'])->limit(1)->result();
				
				if ($tax['tax_amount'])
					$product['product_price_with_tax'] = $product['product_price_without_tax'] + $tax['tax_amount'];
				
				if ($tax['tax_percent'])
					$product['product_price_with_tax'] = $product['product_price_without_tax'] + ($product['product_price_without_tax'] * $tax['tax_percent'])/100;
			
				$product['product_price_tax'] = $product['product_price_with_tax'] - $product['product_price_without_tax'];
				
				// Product has a sale or a condition which changes price, so set old prices
				if (isset($product['product_price_old']))
				{
					if ($tax['tax_amount'])
						$product['product_price_old_with_tax'] = $product['product_price_old_without_tax'] + $tax['tax_amount'];
				
					if ($tax['tax_percent'])
						$product['product_price_old_with_tax'] = $product['product_price_old_without_tax'] + ($product['product_price_old_without_tax'] * $tax['tax_percent'])/100;
				
					$product['product_price_old_tax'] = $product['product_price_old_with_tax'] - $product['product_price_old'];
				}
			}
			/* Weight */
			$product['product_weight'] = number_format($product['product_weight'], 3);
			if ($this->short_name)
				$product['product_name'] = shorten($product['product_name'], $this->short_name);
				
		}
		
		return $product;
	}
	/* Adds currency code before/after price
	 * 
	 * @param int price
	 * @return string
	 */
	protected function show_price_with_currency($price)
	{
		$currency = select(self::$table_products_currencies)->where('is_default = 1')->result();
		
		if ($currency['currency_side'] == 'right')
			return $price.' '.$currency['currency_code'];
		else
			return $currency['currency_code'].' '.$price;
	}
}