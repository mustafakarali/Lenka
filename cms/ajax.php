<?php
require_once('cms/functions.php');

if (function_exists(Routes::$func))
	func_cms(Routes::$func);

// Default language file for CMS
require_once('cms/lang/'. $_SESSION['lang_code'] .'/default.php');

/** Search engine of CMS 
 * 
 * @param string $_POST;
 * @return string search result
 */
function show_search_results()
{
	global $setting;
	
	$search = $_POST['aranan'];
	
	echo '  <span class="arrow"></span>
            <ul class="updates">';
    
	// Contents
	$contents = select('contents')->where("content_title LIKE '%$search%'")->limit(5)->results();
	// Users
	$users = select('users')->where("user_name LIKE '%$search%'")->limit(5)->results();
	
	// Orders 
	if ($setting['ecommerce_mode'] == 'on')
	{
		if (is_numeric($search))
			$order = select('products_orders')->where('order_id = '.$search)->limit(1)->result();
		else
			$products = select('products_locals')->left('products')->using('product_id')->where("products_locals.product_name LIKE '%$search%'")->limit(5)->results();
	}
	
	if (count($contents) > 0 || count($users) > 0 || isset($order['order_id']) || isset($products))
	{
		// Contents
		foreach ($contents AS $res)
		{
			echo '<li>
	              	<span class="uDone">
	                	<a href="'.Routes::$base.'admin/content/'.$res['content_sef'].'" title="">'.$res['content_title'].'</a>
	                    <span>'.$res['content_summary'].'</span>
	                </span>
	                <span class="uDate"><span>'.date('d',$res['content_time']).'</span>'.__(date('M',$res['content_time'])).'</span>
	                <span class="clear"></span>
	              </li>';
		}	
		// Users
		foreach ($users AS $res)
		{
			echo '<li>
	              	<span class="uDone">
	                	<a href="'.Routes::$base.'admin/user/'.$res['user_id'].'">'.$res['user_name'].'</a>
	                    <span>'.$res['user_name'].' '.$res['user_surname'].'</span>
	                </span>
	                <span class="clear"></span>
	              </li>';
		}	
		
		if ($setting['ecommerce_mode'] == 'on')
		{
			// Order
			if (isset($order['order_id']))
			{
				echo '	<li>
							<span class="uDone">
			                	<a href="'.Routes::$base.'admin/orders/'.$order['order_id'].'">'.__('Total').': '.$order['order_total'].' TL</a>
			                    <span>'.$order['order_tel_h'].' '.$order['order_email'].'</span>
			                </span>
			                <span class="uDate"><span>'.date('d',$order['order_timestamp']).'</span>'.__(date('M',$order['order_timestamp'])).'</span>
		                    <span class="clear"></span>
						</li>';
			}
			
			// Products
			if (isset($products))
			{
				foreach ($products AS $res)
				{
					echo '<li>
			              	<span class="uDone">
			                	<a href="'.Routes::$base.'admin/product/'.$res['product_id'].'">'.$res['product_name'].'</a>
			                </span>
			                <span class="clear"></span>
			              </li>';
				}	
			}
		}
	}
	else 
	{
		echo '	<li>
	              	<span class="uAlert">
	                	<a href="javascript:void(0)" title="">'.__('Nothing found').'</a>
	                    <span>'.__('Please search something different').'</span>';
                
              
    	$contents = select('contents')->results();
		foreach ($contents AS $res)
		{
			if (levenshtein_utf8($res['content_title'], $search) < 6)
			{
				echo '  <hr>
						<span>'.__('Did you mean?').' <a href="'. Routes::$base .'admin/content/'.$res['content_sef'].'" title="">'.$res['content_title'].'</a></span>';	
			}	
		}	

		echo '		</span>
              	</li>';	
	}
	echo '  </ul>';
}
function search_possible_href()
{
	$search = $_POST['aranan'];
	
	echo '  <span class="arrow"></span>
            <ul class="updates">';
    
	// Contents
	$contents = select('contents')->where('content_title LIKE "%'.$search.'%" OR content_sef LIKE "%'.$search.'%"')->limit(5)->results();

	// Categories
	$categories = select('categories')->where('category_name LIKE "%'.$search.'%"')->limit(5)->results();
	
	// Routers
	$routers = select('routers')->where('router_sef LIKE "%'.$search.'%"')->limit(5)->results();
	
	// Galleries
	$galleries = select('galleries')->where('gallery_title LIKE "%'.$search.'%"')->limit(5)->results();
	
	if (count($contents) || count($categories) || count($routers) || count($galleries))
	{
		foreach ($contents AS $res)
		{
			echo '<li>
	              	<span class="uDone">
	                    <span>'.$res['content_title'].'
	                    </br><a href="javascript:void(0);" class="select" rel="page/'.$res['content_sef'].'/'.$res['content_id'].'">'.__('Select').'</a></span>
	                </span>
	                <span class="uDate"><span>'.date('d',$res['content_time']).'</span>'.__(date('M',$res['content_time'])).'</span>
	                <span class="clear"></span>
	              </li>';
		}	
		foreach ($categories AS $res)
		{
			echo '<li>
	              	<span class="uDone">
	                    <span>'.$res['category_name'].'
	                    </br><a href="javascript:void(0);" class="select" rel="blog/'.$res['category_sef'].'/'.$res['category_id'].'">'.__('Select').'</a></span>
	                </span>
	                <span class="clear"></span>
	              </li>';
		}	
		foreach ($routers AS $res)
		{
			echo '<li>
	              	<span class="uDone">
	                    <span>'. __('Module').': '.$res['router_sef'].'
	                    </br><a href="javascript:void(0);" class="select" rel="'.$res['router_sef'].'">'.__('Select').'</a></span>
	                </span>
	                <span class="clear"></span>
	              </li>';
		}	
		foreach ($galleries AS $res)
		{
			echo '<li>
	              	<span class="uDone">
	                    <span>'.$res['gallery_title'].'
	                    </br><a href="javascript:void(0);" class="select" rel="gallery/'.$res['gallery_sef'].'">'.__('Select').'</a></span>
	                </span>
	                <span class="clear"></span>
	              </li>';
		}	
	}
	else 
	{
		echo '	<li>
	              	<span class="uAlert sonuc_bulunamadi">
	                	<a href="javascript:void(0)" title="">'.__('Nothing found').'</a>
	                    <span>'. __('Please search something different') .'</span>';
		
		$contents = select('contents')->results();
		foreach ($contents AS $res)
		{
			if (levenshtein_utf8($res['content_title'], $search) < 6)
			{
				$a = array('value'=>'<a href="javascript:void(0);" class="select" rel="content/'.$res['content_sef'].'">'.$res['content_title'].'</a>');
				echo '  <hr>
						<span>'. __('Did_you_mean', $a) .'</span>';	
			}	
		}	
					
		echo '  	</span>
              	</li>';
	}
	echo '  </ul>';
}
function search_possible_product()
{
	$search = $_POST['aranan'];
	
	echo '  <span class="arrow"></span>
            <ul class="updates">';
    
	// Contents
	$contents = select('products_locals')->where('product_name LIKE "%'.$search.'%"')->limit(10)->results();

	if (count($contents))
	{
		foreach ($contents AS $res)
		{
			echo '<li>
	              	<span class="uDone">
	                    <span>'.$res['product_name'].'
	                    </br><a href="javascript:void(0);" class="select" rel="'.$res['product_name'].'">'.__('Select').'</a></span>
	                </span>
	                <span class="clear"></span>
	              </li>';
		}
	}
	else 
	{
		echo '	<li>
	              	<span class="uAlert sonuc_bulunamadi">
	                	<a href="javascript:void(0)" title="">'.__('Nothing found').'</a>
	                    <span>'. __('Please search something different') .'</span>';
		
		$contents = select('products_locals')->results();
		foreach ($contents AS $res)
		{
			if (levenshtein_utf8($res['product_name'], $search) < 6)
			{
				$a = array('value'=>'<a href="javascript:void(0);" class="select" rel="'.$res['product_name'].'">'.$res['product_name'].'</a>');
				echo '  <hr>
						<span>'. __('Did_you_mean', $a) .'</span>';	
			}	
		}	
					
		echo '  	</span>
              	</li>';
	}
	echo '  </ul>';
}
/** Delete from database easily 
 * 
 * @return deletes a row from database
 */
function delete_from_database()
{
	delete($_POST['table'], (int)$_POST['key']);
}
/** Delete content from database by calling stored procedure 
 * 
 * @return deletes a content from database
 */
function delete_content_from_database()
{
	global $pdo;
		
	$query = $pdo->prepare("CALL content_delete(:content_id)");
	$query->bindValue(':content_id', $_POST['id'], PDO::PARAM_INT);
	$query->execute();
}
function update_value_on_database()
{
	global $pdo;
	
	$columns = $pdo->column($_POST['table']);
	update($_POST['table'])->values(array($_POST['col'] => $_POST['val']))->where(''.$columns['Field'] .' = "'.$_POST['row'].'"');
}
/** Inpage edit for content page, very useful for blogs 
 * 
 */
function inpage_content_edit()
{
	global $site;

	if (!empty($_POST['sef']) && is_auth(99))
	{
		update('contents')->values(array('content_text'=>$_POST['text'], 'content_time'=>$site['timestamp']))->where('content_sef = "'.$_POST['sef'].'"');		
	}
}
function content_pattern()
{
	require_once('cms/model/home.php');
	
	$blog = new _Blog();
	
	$blog->pattern_id = $_POST['pattern_id'];
	$pattern_data = $blog->pattern();
	
	foreach ($pattern_data AS $pattern)
	{
		Input::$name = 'pattern['.$pattern['pattern_data_id'].']';
		echo Input::$pattern['pattern_type']($pattern['pattern_data_key']);
		/*
		echo '	<div class="formRow">
					<div class="grid2">'.$pattern['pattern_data_key'].'</div>
					<div class="grid10"><input type="text" name="pattern['.$pattern['pattern_data_id'].']" value=""/></div>
	            	<div class="clear"></div>     
	          	</div>';	
		*/ 
	}
}
/* Serialize */
function serialize_in_database()
{
	global $pdo;
	
	$table = Routes::$get[1];
	$column = Routes::$get[2];
	
	$indis = array_keys($_POST['list']);
		
	for ($i=0; $i<count($_POST['list']); $i++)
	{
		$query = $pdo->prepare("UPDATE ".$table." SET 
								".$column."_order = :".$column."_order
								WHERE ".$column."_id = :".$column."_id");

		$values = array($column."_order"=>$i,
						$column."_id"=>$indis[$i]);

		$query->execute($values);
	}	
}
function serialize_categories()
{
	global $pdo;

	for ($i=0; $i<count($_POST['list']); $i++)
	{
		$indis = array_keys($_POST['list']);
		$deger = array_values($_POST['list']);
		if ($deger[$i] == 'null')
			$deger[$i] = 0;	
		
		$query = $pdo->prepare("UPDATE categories SET 
								parent_id = :parent_id,
								category_order = :category_order
								WHERE category_id = :category_id");

		$values = array('parent_id' => $deger[$i],
						'category_order' => $i,
						'category_id'=>$indis[$i]);

		$query->execute($values);
	}
}
function categories_for_serialize()
{
	echo '<ol class="sortable">';
	_categories_for_serialize(0, $_POST['lang_id']);
	echo '</ol>';
	
	echo '	<div class="formRow border-0 padding-0 padding-bottom-35">
				<a id="serialize" class="buttonM bBlue grid12" href="javascript:void(0);">
					<span class="icon-export"></span>
					<span>'. __('Save') .'</span>
				</a>
				<!--<pre id="serializeOutput"></pre>-->
			</div>';
}
function serialize_menu_data()
{
	global $pdo;

	for ($i=0; $i<count($_POST['list']); $i++)
	{
		$indis = array_keys($_POST['list']);
		$value = array_values($_POST['list']);
		if ($value[$i] == 'null')
			$value[$i] = 0;	
		
		$query = $pdo->prepare("UPDATE menus_data SET 
								parent_id = :parent_id,
								menu_data_order = :menu_data_order
								WHERE menu_data_id = :menu_data_id");

		$values = array('parent_id' => $value[$i],
						'menu_data_order' => $i,
						'menu_data_id'=>$indis[$i]);

		$query->execute($values);
	}
}
function menu_data_for_serialize()
{
	echo '<ol class="sortable">';
	_menu_data_for_serialize($_POST['menu_id'], 0, 0);
	echo '</ol>';
	
	echo '	<div class="formRow border-0 padding-0 padding-bottom-35">
				<a class="buttonM bRed grid2" onclick="delete_from_database(\'menus\','.$_POST['menu_id'].',\'refresh\');" href="javascript:void(0);">'. __('Del') .'</a>
				<a id="serialize" class="buttonM bBlue grid10" href="javascript:void(0);"><span class="icon-export"></span><span>'. __('Save').'</span></a>
			</div>';	
}
function serialize_slides()
{
	global $pdo;

	for ($i=0; $i<count($_POST['list']); $i++)
	{
		$indis = array_keys($_POST['list']);
		$deger = array_values($_POST['list']);
		if ($deger[$i] == 'null')
			$deger[$i] = 0;	
		
		$query = $pdo->prepare("UPDATE slides SET 
								slide_order = :slide_order
								WHERE slide_id = :slide_id");

		$values = array('slide_order' => $i,
						'slide_id'=>$indis[$i]);

		$query->execute($values);
	}
}
function slides_for_serialize()
{
	global $site;
	
	$rows = select('slides')->where('slide_group = '.$_POST['slide_group'])->order('slide_order ASC')->results();
	
	echo '	<ol class="sortable">';
	foreach($rows AS $row)
	{
		echo '<li id="list_'.$row['slide_id'].'">
				<div>
					<img src="'.$site['image_path'].$row['slide_img'].'" width="240" style="margin: 10px;">
					<a href="'. $row['slide_href'] .'" style="display: inline-block; margin-top:10px; position: absolute; width: 900px;"><h4>'. $row['slide_title'] .'</h4><p>'. $row['slide_text'] .'</p></a>
					<a href="'.Routes::$base.'admin/dynamic-row/slides/slide_id/'.$row['slide_id'].'" title="'. __('Edit') .'" class="sortable_silme_tusu hover" style="right:55px"><img src="'.Routes::$base.'cms/design/images/icons/update.png"/></a>
					<a href="javascript:void(0);" onClick="delete_from_database(\'slides\','.$row['slide_id'].',\'list\');" title="'. __('Del') .'" class="sortable_silme_tusu hover"><img src="'.Routes::$base.'cms/design/images/icons/delete.png"/></a>
				</div>
			</li>';
	}
	echo '	</ol>
			<div class="formRow border-0 padding-0 padding-bottom-35">
				<a id="serialize" class="buttonM bBlue grid12" href="javascript:void(0);">
					<span class="icon-export"></span>
					<span>'. __('Save').'</span>
				</a>
			</div>';
}
function serialize_faqs()
{
	global $pdo;

	for ($i=0; $i<count($_POST['list']); $i++)
	{
		$indis = array_keys($_POST['list']);
		$deger = array_values($_POST['list']);
		if ($deger[$i] == 'null')
			$deger[$i] = 0;	
		
		$query = $pdo->prepare("UPDATE faqs SET 
								faq_order = :faq_order
								WHERE faq_id = :faq_id");

		$values = array('faq_order' => $i,
						'faq_id'=>$indis[$i]);

		$query->execute($values);
	}
}
function faqs_for_serialize()
{
	$rows = select('faqs')->order('faq_order ASC')->results();
	
	echo '	<ol class="sortable">';
	foreach($rows AS $row)
	{
		echo '	<li id="list_'.$row['faq_id'].'">
					<div>
						<span class="disclose"></span>'. $row['faq_question'] .'
						<a href="'.Routes::$base.'admin/dynamic-row/faqs/faq_id/'.$row['faq_id'].'" title="'. __('Update').'" class="sortable_silme_tusu hover" style="right: 55px;"><img alt="" src="http://localhost/pervin/cms/design/images/icons/update.png"></a>
						<a href="javascript:void(0);" onClick="delete_from_database(\'faqs\', '.$row['faq_id'].', \'row\');" title="'. __('Delete') .'" class="sortable_silme_tusu hover"><img src="'.Routes::$base.'cms/design/images/icons/delete.png" alt="" /></a>
					</div>
				</li>';
	}
	echo '	</ol>
			<div class="formRow border-0 padding-0 padding-bottom-35">
				<a id="serialize" class="buttonM bBlue grid12" href="javascript:void(0);">
					<span class="icon-export"></span>
					<span>'. __('Save').'</span>
				</a>
			</div>';
}
/** Change a value in products field easly 
 * 
 */
function product_change_fast()
{
	update('products')->values(array($_POST['field']=>$_POST['value']))->where('product_id = '.$_POST['id']);
	
	return true;
}
/** Sets a sale for price for coming 90 days for selected product
 * 
 */
function product_sale_price()
{
	global $site;
	
	$sale_start = $site['timestamp'];
	$sale_expire = $site['timestamp'] + 90*24*60*60;
	
	update('products')
		->values(array($_POST['field']=>$_POST['value'],
					   'sale_start'=>$sale_start,
					   'sale_expire'=>$sale_expire))
		->where('product_id = '.$_POST['id']);
	
	return true;
}
function price_range_new()
{
	global $site;
	
	$i =  $_POST['price_i'] + 1;
	$result = '	<h3 class="green mt40">'. $i .'. '.__('price_range').'</h3>';
	
	Input::$label = 'price';
	$result .= '<div class="formRow" style="border-top:none;">'.Input::text('pricing_detailed['.$_POST['price_i'].']').'<div class="clear"></div></div>';
	Input::$label = false;
	
	Input::$id = 'pricing_start_'.$_POST['price_i'];
	Input::$name = 'pricing_start['.$_POST['price_i'].']';
	$result .= '<div class="formRow">'.Input::date('pricing_start').'<div class="clear"></div></div>';
	
	Input::$id = 'pricing_expire_'.$_POST['price_i'];
	Input::$name = 'pricing_expire['.$_POST['price_i'].']';
	$result .= '<div class="formRow">'.Input::date('pricing_expire', $site['timestamp']+6*30*24*60*60).'<div class="clear"></div></div>';
	
	Input::$id = false;
	Input::$name = false;
	
	echo $result;	
}
/** Changes status of order such as waiting for payment, completed etc... 
 * 
 */
function change_status_of_order()
{
	update('products_orders')->values(array('order_status'=>$_POST['val']))->where('order_id = '.$_POST['order_id']);
	return true;
}
/** Changes status of product in order such as ready for shipping, error in product 
 * 
 */
function change_status_of_product_in_order()
{
	// Check current status
	$current_status = select('products_orders_products')->where('order_id = '.$_POST['order_id'].' AND product_id = '.$_POST['product_id'])->limit(1)->result('order_product_status');
	
	if ($_POST['val'] != $current_status)
	{
		update('products_orders_products')->values(array('order_product_status'=>$_POST['val']))->where('order_id = '.$_POST['order_id'].' AND product_id = '.$_POST['product_id']);
	
		// Product is accepted, so reduce stock by the number of the quantity in order
		$amount = select('products_orders_products')->where('order_id = '.$_POST['order_id'].' AND product_id = '.$_POST['product_id'])->limit(1)->result('order_product_quantity');
		$stock = select('products')->where('product_id = '.$_POST['product_id'])->limit(1)->result('product_stock_amount');
			
		if ($current_status != 4 && $_POST['val'] == 4)
		{
			$new_stock = $stock - $amount;
			update('products')->values(array('product_stock_amount'=>$new_stock))->where('product_id = '.$_POST['product_id']);
		}
			
		if ($current_status == 4 && $_POST['val'] != 4)
		{
			$new_stock = $stock + $amount;
			update('products')->values(array('product_stock_amount'=>$new_stock))->where('product_id = '.$_POST['product_id']);
		}
		
		return true;	
	}
	return false;
}
