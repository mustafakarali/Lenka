<?php
class Checkout extends Product
{
	/* Datatables */
	var $table_orders = 'products_orders';
	var $table_orders_products = 'products_orders_products';
	
	var $table_invoices = 'products_invoices';
	
	/* Payment method */
	var $payment_type;
	
	/* Order id */
	var $order_id;
	
	function add_order($info, $cart)
	{
		/******** $info ********
		 * 
		 * [company_1] => company 
		 * [user_1] => user 
		 * [address_!] => address 
		 * [postal_1] => postal 
		 * [city_1] => city 
		 * [tel_h_1] => 23412412 
		 * [tel_m_1] => 124124124 
		 * [fax_1] => 12412412241 
		 * 
		 * [company_2] => 
		 * [user_2] => 
		 * [address_2] => 
		 * [postal_2] => 
		 * [city_2] => 
		 * [tel_h_2] => 
		 * [tel_m_2] => 
		 * [fax_2] => 
		 * 
		 * [radio_1] => on 
		 * [radio_2] => garanti 
		 * [termofservice] => on 
		 * [checkout] => ) 
		 * 
		 */
		 
		global $pdo, $site;
		
		$invoice_id = $this->add_invoice($info);
		
		$cart['info'] = $info;
		
		if (!isset($info['note']))
			$info['note'] = '';
		
		if (@$_POST['order_address_is_invoice_address'] == 'on')
		{
			if (!isset($info['company_2']))
				$info['company_2'] = $info['company_1'];
			if (!isset($info['user_2']))
				$info['user_2'] = $info['user_1'];
			if (!isset($info['address_2']))
				$info['address_2'] = $info['address_1'];
			if (!isset($info['city_2']))
				$info['city_2'] = $info['city_1'];
			if (!isset($info['postal_2']))
				$info['postal_2'] = $info['postal_1'];
			if (!isset($info['tel_h_2']))
				$info['tel_h_2'] = $info['tel_h_1'];
			if (!isset($info['tel_m_2']))
				$info['tel_m_2'] = $info['tel_m_1'];			
			if (!isset($info['fax_2']))
				$info['fax_2'] = $info['fax_1'];
			if (!isset($info['email_2']))
				$info['email_2'] = $info['email_1'];
		}
		
		// Waiting for shipping
		if ($info['checkout'] == 'atdoor')
			$info['order_status'] = 3;
		
		// Waiting for payment
		if (!isset($info['order_status']) || empty($info['order_status']))
			$info['order_status'] = 2;
		
		
		
		/* Insert into order table */ 
		insert($this->table_orders)->values(array('user_id'=>$_SESSION['user_id'],
											'user_note'=>$info['note'],
											'invoice_id'=>$invoice_id,
											'order_company'=>$info['company_2'],
											'order_name'=>$info['user_2'],
											'order_address'=>$info['address_2'],
											'order_city'=>$info['city_2'],
											'order_postal'=>$info['postal_2'],
											'order_tel_h'=>$info['tel_h_2'],
											'order_tel_m'=>$info['tel_m_2'],
											'order_fax'=>$info['fax_2'],
											'order_email'=>$info['email_2'],
											'order_timestamp'=>$site['timestamp'],
											'order_desi'=>$cart['desi'],
											'order_weight'=>$cart['weight'],
											'order_total'=>$cart['total'],
											'order_shipping_id'=>$info['radio_1'],
											'order_payment_id'=>$info['radio_2'],
											'order_installement_id'=>'',
											'order_data'=>json_encode($cart),
											'order_status'=>$info['order_status']));
		
		$this->order_id = $pdo->insert_id();
		
		/* Insert products one by one into orders_products */
		foreach ($cart['products'] AS $product_id)
		{
			insert($this->table_orders_products)->values(array('user_id'=>$_SESSION['user_id'],
															   'order_id'=>$this->order_id,
															   'product_id'=>$product_id,
															   'order_product_price'=>$cart['price'][$product_id],
															   'order_product_quantity'=>$cart['amount'][$product_id],
															   'order_product_status'=>2));
		}
		
		/* Get cookie if exist add new order else create it */
		if (isset($_COOKIE['order']))
		{
			$orders = unserialize($_COOKIE['order']);
			// empty cookie
			setcookie('order', '', time() + (86400 * 90), "/"); // 86400 * 90 = 90 day
			unset($_COOKIE);
			
			array_push($orders, $this->order_id);
			$a = serialize($orders);
			setcookie('order', $a, time() + (86400 * 90), "/"); // 86400 * 90 = 90 day
		}
		else 
		{
			$orders[0] = $this->order_id;
			$a = serialize($orders);
			setcookie('order', $a, time() + (86400 * 90), "/"); // 86400 * 90 = 90 day
		}
		
		// Reduce the usage of coupon
		if (isset($_SESSION['cart']['coupon_code']) && !empty($_SESSION['cart']['coupon_code']))
		{
			$coupon = select('coupons')->where('coupon_code = "'.$_SESSION['cart']['coupon_code'].'" AND coupon_min < '.$_SESSION['cart']['price_with_tax'].' AND coupon_start <= '.$site['timestamp'].' AND coupon_expire >= '.$site['timestamp'].' AND coupon_amount > 0')->limit(1)->result();
			$amount = $coupon['coupon_amount']-1;
			update('coupons')->values(array('coupon_amount'=>$amount))->where('coupon_id = '.$coupon['coupon_id']);
		}
		
		unset($_SESSION['cart']);
		unset($_POST);
		
		/* Everything is completed send notification to user*/
		$this->order_mail($this->order_id, $info['email_1']);
		$this->order_sms($this->order_id, $info['tel_h_1']);
		
		/* Send notification to operator */
		if ($info['email_1'] != 'guncebektas@gmail.com')
			$this->order_mail($this->order_id, 'guncebektas@gmail.com');
		
		if ($info['tel_h_1'] != '0(533)611-53-03')
			$this->order_sms($this->order_id, '0(533)611-53-03');
		
		/* Order added into the database */
		if (isset($info['checkout']) && ($info['checkout'] == 'credit' || $info['checkout'] == 'paypal'))
		{
			header('Location:'. Routes::$base.'payment/'.$this->order_id.'/'.$info['checkout']);
		}	
		
		return $this->order_id;
	}
	function order($order_id)
	{
		$order = select($this->table_orders)->where('order_id = '.$order_id)->limit(1)->result();
		$order['order_data'] = json_decode($order['order_data'], true);
		
		return $order;
	}
	function order_data($order_id)
	{
		$order = select($this->table_orders)->where('order_id = '.$order_id)->limit(1)->result('order_data');
		return json_decode($order, true);
	}
	function order_display($order_id)
	{
		$order = select($this->table_orders)->where('order_id = '.$order_id)->limit(1)->result('order_data');
		
		echo_order_table(json_decode($order, true), false);
	}
	function order_display_cargo_details($order_id)
	{
		$order = select($this->table_orders)->left('shippings ON '.$this->table_orders.'.order_shipping_id = shippings.shipping_id')->where('order_id = '.$order_id)->limit(1)->result();
		
		echo_order_shipping_detail($order);
	}
	function order_date($order_id)
	{
		global $setting;
		
		$order = select($this->table_orders)->where('order_id = '.$order_id)->limit(1)->result('order_timestamp');

		return date($setting['date_format'], $order);
	}
	final public function order_mail($order_id, $email)
	{
		global $settings;
		
		$message = '<html> 
						<body style="margin:0;padding:0;">
							<table width="100%" cellspacing="0" cellpadding="0" style="margin:0;padding:0;" bgcolor="#438ec2">
								<tr>
									<td height="50">&nbsp;</td>
								</tr>
								<tr>
								<td>
									<table width="600" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
										<tr>
											<td width="10" bgcolor="#3c80ae">
												&nbsp;
											</td>
											<td width="580" valign="top">
												<table width="580" valign="top" height="10" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="#3c80ae">
													<tr>
														<td height="10" style="font-size:0px;">
															&nbsp;
														</td>
													</tr>
												</table>
												<table width="580" valign="top" height="10" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
													<tr>
														<td height="40" style="font-size:0px;">&nbsp;</td>
													</tr>
													<tr>
														<td align="center">
															<img style="font-size:0;padding:0;margin:0;" src="'.Routes::$base.'email/welcome.jpg" alt="parfümal.com" />
														</td>
													</tr>
												</table>
											</td>
											<td width="10" height="110" bgcolor="#3c80ae" align="right" style="font-size:0px;">&nbsp;</td>
										</tr>
									</table>
									<table width="670" align="center" cellspacing="0" cellpadding="0" bgcolor="#438ec2">
										<tr>
											<td width="10" style="font-size:0;padding:0;margin:0;" valign="bottom"></td>
											<td width="25" style="font-size:0;padding:0;margin:0;" valign="bottom"><img style="padding:0;margin:0;" src="'.Routes::$base.'email/bottom_left_blue.png" alt="" /></td>
											<td style="padding:0;margin:0;">
												<table cellspacing="0" cellpadding="0" bgcolor="#3c80ae">
													<tr>
														<td width="10" style="font-size:0;padding:0;margin:0;" valign="bottom"><img src="'.Routes::$base.'email/bottom_left_2_blue.png" alt="" /></td>
														<td>
															<table width="580" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
																<tr>
																	<td width="30">&nbsp;</td>
																	<td>
																		<table>
																			<tr>
																				<td style="font-size:0;" height="30">&nbsp; </td>
																			</tr>
																		</table>
																						
																		<table align="center" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td align="center">
																					<h1 style="color:#323a45;font-size:22px;font-family:Calibri;font-weight:normal;"> Teşekkür ederiz, siparişiniz alınmıştır.</h1>
																					<p style="color:#808080;font-family:Calibri;font-size:14px;line-height:20px;margin:20px 0 15px 0;">
																						Sipariş numaranız: <strong>'.$order_id.'</strong>
																					</p>
																					
																					<a href="'.Routes::$base.'checkorder"><img style="border:0;"  style="border:0;" src="'.Routes::$base.'email/button_2.jpg" alt="Tüm siparişlerinizi takip etmek için tıklayın" /></a>
																				</td>
																			</tr>
																		</table>
																		
																		<table>
																			<tr>
																				<td style="font-size:0;" height="30">&nbsp; </td>
																			</tr>
																		</table>
																						
																	</td>
																	<td width="30">&nbsp;</td>
																</tr>
															</table>
														</td>
													<td width="10" style="font-size:0;padding:0;margin:0;" valign="bottom"><img style="padding:0;margin:0;" src="'.Routes::$base.'email/bottom_right_2_blue.png" alt="" /></td>
													</tr>
												</table>
											</td>
											<td width="25" style="font-size:0;padding:0;margin:0;" valign="bottom"><img style="padding:0;margin:0;" src="'.Routes::$base.'email/bottom_right_blue.png" alt="" /></td>
											<td width="10" style="font-size:0;padding:0;margin:0;" valign="bottom"></td>
										</tr>
										<tr>
											<td colspan="5" style="font-size:0;padding:0;margin:0;"><img style="padding:0;margin:0;" src="'.Routes::$base.'email/bottom_blue.png" alt="" /></td>
										</tr>
									</table>
									<table align="center" width="650">
										<tr>
											<td height="10">&nbsp;</td>
										</tr>
										<tr>
											<td align="center" style="color:#FFFFFF;text-decoration:none;font-family:Calibri;font-size:14px;font-weight:normal;line-height:22px;">
												Her türlü soru, görüş ve öneriniz için '.$settings['contact_email'].' adresine email atarak bizimle iletişime geçebilirsiniz.
												If you are not interested to receive this email click <a href="'.Routes::$base.'unsubscribe" style="font-size:14px;text-decoration:none;color:#000000;font-family:Calibri;">Unsubscribe</a> 
											</td>
										</tr>
										<tr>
											<td height="10">&nbsp;</td>
										</tr>
									</table>
								</td>	
								</tr>
								</table>
							</body>
						</html>';
		
		email($email, 'parfümal.com siparişiniz', $message);
	}
	function order_sms($order_id, $to)
	{
		global $site;
		
		require_once('core/lib/app/NexmoMessage.php');
		$sms = new NexmoMessage('91f273f2', 'parfumal');
		
		$to = '+9'.str_replace(')', '', str_replace('(', '', str_replace('-', '', $to)));
		
		$sms->sendText ($to, 'Siparis nu', 'Parfümal.com\'dan '.date('d.m.Y', $site['timestamp']).' tarihindeki alışverişinizin sipariş numarası: '.$order_id.'', $unicode = null);
	}
	function add_invoice($info)
	{
		global $pdo;
		
		if ($_POST['invoice_email_on'] == 'on')
			$email_on = 1;
		else
			$email_on = 0;
			
		insert($this->table_invoices)->values(array('user_id'=>$_SESSION['user_id'],
													'invoice_type'=>0,
													'invoice_company'=>$info['company_1'],
													'invoice_name'=>$info['user_1'],
													'invoice_address'=>$info['address_1'],
													'invoice_postal'=>$info['postal_1'],
													'invoice_city'=>$info['city_1'],
													'invoice_tel_h'=>$info['tel_h_1'],
													'invoice_tel_m'=>$info['tel_m_1'],
													'invoice_fax'=>$info['fax_1'],
													'invoice_email'=>$info['email_1'],
													'invoice_email_on'=>$email_on));
		
		return $pdo->insert_id();												
	}
	
	/* Make payment */
	public function payment_paypal()
	{
		$order = $this->order_data($this->order_id);
		
		echo '	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<h2 class="color_dark tt_uppercase m_bottom_25">Ödemenizi "PayPal" Üzerinden Şimdi Yapın! Alışverişinizi Tamamlayın...</h2>
					<input type="hidden" name="cmd" value="_xclick">
				  	<input type="hidden" name="quantity" value="1" />
				   	<input type="hidden" name="business" value="guncebektas@gmail.com" />
				   	<input type="hidden" name="currency_code" value="TRY" />
				   	<input type="hidden" name="return" value="http://parfümal.com" />
				   	<input type="hidden" name="item_name" id="item_name" size="45" value="Siparis nu: '.$this->order_id.'" />
				   	<input type="hidden" name="amount" value="'.$order['total'].'">
					
					
				   	<button class="button_type_6 bg_scheme_color f_size_large r_corners tr_all_hover color_light m_bottom_20" type="submit" name="checkout">'.$order['total'].' TL\'yi PayPal Kullanarak Öde</button>
				</form>';
	
	}
	public function payment_iyzico()
	{
		$url = "https://api.iyzico.com/v2/create";
        $data =  'api_id=im065125800483dc1bfe761424123961' .
                         '&secret=im067315900f67e93fb95c1424123961' .
                         '&external_id='.rand(Routes::$func, 1000000).
                         '&mode=test' .
                         '&type=CC.DB' .
                         '&return_url='.Routes::$base.'payment/completed'.
                         '&amount=100' .
                         '&currency=TRY' .
                         '&descriptor=PAYMENT_DESCRIPTION'.
                         '&item_id_1=ITEM_ID'.
                         '&item_name_1=ITEM_NAME'.
                         '&item_unit_quantity_1=ITEM_UNIT_QUANTITY'.
                         '&item_unit_amount_1=ITEM_UNIT_AMOUNT'.
                         '&customer_first_name=CUSTOMER_FIRSTNAME' .
                         '&customer_last_name=CUSTOMER_LASTNAME' .
                         '&customer_company_name=COMPANY_NAME' .
                         '&customer_shipping_address_line_1=CUSTOMER_SHIPPING_ADDRESS_LINE_1' .
                         '&customer_shipping_address_line_2=CUSTOMER_SHIPPING_ADDRESS_LINE_2' .
                         '&customer_shipping_address_zip=CUSTOMER_SHIPPING_ADDRESS_ZIP' .
                         '&customer_shipping_address_city=CUSTOMER_SHIPPING_ADDRESS_CITY' .
                         '&customer_shipping_address_state=CUSTOMER_SHIPPING_ADDRESS_STATE' .
                         '&customer_shipping_address_country=CUSTOMER_SHIPPING_ADDRESS_COUNTRY_CODE' .
                         '&customer_billing_address_line_1=CUSTOMER_BILLING_ADDRESS_LINE_1' .
                         '&customer_billing_address_line_2=CUSTOMER_BILLING_ADDRESS_LINE_2' .
                         '&customer_billing_address_zip=CUSTOMER_BILLING_ADDRESS_ZIP' .
                         '&customer_billing_address_city=CUSTOMER_BILLING_ADDRESS_CITY' .
                         '&customer_billing_address_state=CUSTOMER_BILLING_ADDRESS_STATE' .
                         '&customer_billing_address_country=CUSTOMER_BILLING_ADDRESS_COUNTRY_CODE' .
                         '&customer_contact_phone=CUSTOMER_PHONE' .
                         '&customer_contact_mobile=CUSTOMER_MOBILE' .
                         '&customer_contact_email=CUSTOMER_EMAIL' .
                         '&customer_contact_ip=CUSTOMER_IP'.
                         '&customer_language=tr'.
                         '&installment=true';  

        $params = array('http' => array(
                      'method' => 'POST',
                      'content' => $data
                  ));
        $ctx = stream_context_create($params);
        $fp = @fopen($url, 'rb', false, $ctx);
        if (!$fp) {
          throw new Exception("Problem with $url, $php_errormsg");
        }
        $response = @stream_get_contents($fp);
        if ($response === false) {
          throw new Exception("Problem reading data from $url, $php_errormsg");
        }

        $resultJson = json_decode($response,true);
		
		echo $resultJson['code_snippet'];
	}
	public function payment_creditcard_vakifbank()
    {
    	$order = select('products_orders')->where('order_id = '.Routes::$func)->limit(1)->result();
		
    	if (isset($_POST['KartNo'])){
			$PostUrl = 'https://onlineodeme.vakifbank.com.tr:4443/VposService/v3/Vposreq.aspx';	//Dokümanda yer alan VPOS URLi
			$IsyeriNo = '000000000108217';
			$TerminalNo = 'VP010842';
			$IsyeriSifre = 's4R9Yrb8';
			$KartNo = str_replace('-', '', $_POST["KartNo"]);
			$KartAy = $_POST["KartAy"];
			$KartYil = $_POST["KartYil"];
			$KartCvv = $_POST["KartCvv"];
			
			$Tutar = $order['order_total]'];
			
			$SiparID = $order['order_id'];
			$IslemTipi = 'Sale';
			$TutarKodu = 949;
			//$Taksit = $_POST["InstallmentCount"];
			
			$PosXML ='prmstr=<?xml version="1.0" encoding="utf-8"?>
			<VposRequest>
			  <MerchantId>'.$IsyeriNo.'</MerchantId>
			  <Password>'.$IsyeriSifre.'</Password>
			  <TerminalNo>'.$TerminalNo.'</TerminalNo>
			  <TransactionType>'.$IslemTipi.'</TransactionType>
			  <TransactionId>'.$SiparID.'</TransactionId>
			  <ClientIp>62.75.223.2</ClientIp>
			  <CurrencyAmount>'.$Tutar.'</CurrencyAmount>
			  <CurrencyCode>'.$TutarKodu.'</CurrencyCode>
			  <Pan>'.$KartNo.'</Pan>
			  <Cvv>'.$KartCvv.'</Cvv>
			  <Expiry>'.$KartYil.$KartAy.'</Expiry>
			  <TransactionDeviceSource>0</TransactionDeviceSource>
			</VposRequest>';
			
			//echo '<h1>Xml formatı </h1>';
			//echo $PostUrl."<br/>";
			//echo '<textarea col="10" row="80">'.$PosXML.'</textarea><br/><br/><br/>';
			/*	                                                               
			$ch = curl_init();
				                                                               
			curl_setopt($ch, CURLOPT_URL,$PostUrl);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$PosXML);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 5);
			curl_setopt($ch, CURLOPT_TIMEOUT, 59);
			
			$result = curl_exec($ch);
			curl_close($ch);
			*/
			
			//echo '<h1>Sonuç değerleri</h1>';
			//echo $result.'</br></br>';
			
			/* Payment is completed and money is in, so update order details */
			if (strstr($result, 'Basarili')) {
				update('products_orders')->values(array('order_status'=>3))->where('order_id = '.$order['order_id']);
			}
			else {
				echo '	<div class="row clearfix">
							<div class="col-lg-12 col-md-12 col-sm-12 m_bottom_40 m_xs_bottom_10">
								<div class="alert_box r_corners color_green error m_bottom_10">
									<i class="fa fa-bullhorn"></i>
									<h2>Hata!</h2>
									<p>Girdiğiniz bilgilerde hata var, lütfen tekrar deneyin</p>
								</div>
							</div>
						</div>';
			}
		}   
			
		echo '	<form id="invoice" method="POST" action="'.Routes::$current.'" class="col-md-6 col-sm-12">
    				<h5 class="fw_medium m_bottom_15">Kredi Kartı Bilgilerinizi Girin</h5>
					<ul>
						<li class="m_bottom_15">
							<label class="m_bottom_5 required">Kart Numarası <small>"Kartınızın ön yüzündeki numara"</small></label>
							<input type="text" name="KartNo" size="49" placeholder="Kart Numarası" class="r_corners full_width validate[required] credit-number-mask">
						</li>
						<li class="m_bottom_15">
							<label class="m_bottom_5 required">Son Kullanım Tarihi <small>"Kartınızın son kullanma tarihini ay ve yıl olarak girin"</small></label>
							<br/>
							<input type="text" name="KartAy" size="5" placeholder="AY" value="" class="validate[required] credit-dd-mask">
							<input type="text" name="KartYil" size="12" placeholder="YIL" value="" class="validate[required] credit-dddd-mask">
						</li>
						<li class="m_bottom_15">
							<label class="m_bottom_5 required">CVV <small>"Kartınızın arkasındaki 3 haneli kod"</small></label>
							<br/>
							<input type="text" name="KartCvv" size="3" placeholder="CVV" value="" class="validate[required] credit-cvv-mask">
						</li>
						<button class="button_type_6 bg_scheme_color f_size_large r_corners tr_all_hover color_light m_bottom_20" type="submit" name="checkout">Ödemeyi Gerçekleştir</button>
				</form>';
	}
}

$p = new Product();
$shippings = $p->shippings_public();

$pay = new Payment();
$payments_available = $pay->payments_available();
