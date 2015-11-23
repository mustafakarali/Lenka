<?php

if (function_exists(Routes::$func)) {
    func_app(Routes::$func);
}

/** Search
 * 
 * @param string  $_POST['string']  string to search
 * @return string  search result
 */
function search()
{
    $search = security($_POST['string']);
    $products = select('products_locals')->where("product_name LIKE '%$search%'")->limit(5)->results();

    if (!empty($products)) {
        $p = new Product();
        foreach ($products as $product) {
            $p->product_id = $product['product_id'];
            @$res = $p->product();

            if (strpos($res['general']['img_t'], 'jpg') || strpos($res['general']['img_t'], 'png')) {
                echo '
				<div class="clearfix m_bottom_15">
					<img class="f_left m_right_15 m_sm_bottom_10 f_sm_none f_xs_left m_xs_bottom_0" alt="" src="'.$res['general']['img_t'].'" width="45">
					<a class="color_dark d_block bt_link" href="'.Routes::$base.'product/'.$res['general']['product_id'].'/'.$res['name'].'">'.$res['name'].'</a>
				</div>';
            }
        }
    }
}
/** Installements options 
 * 
 * @param int  $_POST['id']  payment id
 * @return string  installement option
 */
function installements()
{
    require_once 'core/lib/app/payment.php';
    $pay = new Payment();

    $pay->payment_id = $_POST['id'];

    $payment = $pay->payments();
    $_POST['total'] += $payment['payment_price'];

    $_SESSION['payment_id'] = $pay->payment_id;

    if (!empty($payment['payment_condition'])) {
        $pay->total = $_POST['total'];
        $installements = $pay->installements();

        echo '	<form class="formlar sepetimform">
					<table cellspacing="3" cellpadding="3" id="sepet">
						<tr class="baslik">
							<td width="18%" align="center">SEÇİM</td>
							<td width="18%" align="center">TAKSİT</td>
							<td width="18%" align="center">AYLIK ÖDEME</td>
							<td width="18%" align="center">TOPLAM</td>
							<td width="38%" align="center">AÇIKLAMA</td>
						</tr>
						<tr>
							<td align="center"><input type="radio" name="radio" value="radio" /></td>
							<td align="center">1</td>
							<td align="center">'.$pay->total.'</td>
							<td align="center">'.$pay->total.'</td>
							<td align="center">Tek Çekim</td>
						</tr>';

        $i = 2;
        foreach ($installements as $installement) {
            $sum = $pay->total * $installement;
            $m = $sum / $i;

            echo '
							<tr>
								<td align="center"><input type="radio" name="radio" id="installement" onClick="change_total('.$sum.');" value="'.$i.'" /></td>
								<td align="center">'.$i.'</td>
								<td align="center">'.$m.'</td>
								<td align="center">'.$sum.'</td>
								<td align="center">'.$i.' Çekim</td>
							</tr>';
            $i++;
        }
        echo '
					</table>
				</form>';
    } else {
        echo $_POST['total'];
    }
}

/** Products in the cart
 *
 * ['cart']['products]	 => each product in the cart
 * ['cart']['amount'] 	 => quentity of each product
 * ['cart']['weight']	 => weight of cart
 * ['cart']['shipping']  => selected shipping option
 *
 * @return cart
 */
function cart_add()
{
    $p = new Product();

    if ($_POST['id'] > 0) {
        if (!isset($_POST['count'])) {
            $count = 1;
        }

        // Products in cart
        if (empty($_SESSION['cart']['products'][(int) $_POST['id']])) {
            $_SESSION['cart']['products'][(int) $_POST['id']] = (int) $_POST['id'];

            // Add 1 of product
            $_SESSION['cart']['amount'][(int) $_POST['id']] = 1;

            // Update of count
            if (isset($_POST['count'])) {
                $_SESSION['cart']['amount'][(int) $_POST['id']] = (int) $_POST['count'];
            }
        } else {
            // How many product is in the cart; if count > 1 update amount else add one
            if (isset($_POST['count'])) {
                $_SESSION['cart']['amount'][(int) $_POST['id']] = (int) $_POST['count'];
            } else {
                $_SESSION['cart']['amount'][(int) $_POST['id']] = $_SESSION['cart']['amount'][$_POST['id']] + $count;
            }
        }

        // Total count of product in the cart
        $_SESSION['cart']['count'] = 0;
        foreach ($_SESSION['cart']['amount'] as $amount) {
            $_SESSION['cart']['count'] += $amount;
        }
    }

    // Total price of products
    $_SESSION['cart']['price_with_tax']     = 0;
    $_SESSION['cart']['price_without_tax']    = 0;
    $_SESSION['cart']['price_tax'] = 0;

    foreach ($_SESSION['cart']['products'] as $product_id) {
        $p->product_id = $product_id;
        $cart_p = $p->product();

        $_SESSION['cart']['price'][$product_id] = $cart_p['general']['product_price_with_tax'];

        $_SESSION['cart']['price_with_tax']        += $_SESSION['cart']['amount'][$product_id]    * $cart_p['general']['product_price_with_tax'];
        $_SESSION['cart']['price_without_tax']    += $_SESSION['cart']['amount'][$product_id]    * $cart_p['general']['product_price_without_tax'];
        $_SESSION['cart']['price_tax']            += $_SESSION['cart']['amount'][$product_id]    * $cart_p['general']['product_price_tax'];
    }

    // Reset weight of cart and re-calculate it
    if (!isset($_SESSION['cart']['shipping_id'])) {
        $_SESSION['cart']['shipping_id'] = 7;
    }

    $_SESSION['cart']['weight']     = 0;
    $_SESSION['cart']['desi']     = 0;
    foreach ($_SESSION['cart']['products'] as $product_id) {
        $_SESSION['cart']['weight']    += $p->product_weight($product_id) * $_SESSION['cart']['amount'][$product_id];
        $_SESSION['cart']['desi']    += $p->product_desi($product_id) * $_SESSION['cart']['amount'][$product_id];
    }

    /* Additional prices, shipping and payment options */
    if (!isset($_SESSION['cart']['price_extra'])) {
        $_SESSION['cart']['price_extra_payment'] = 0;
        $_SESSION['cart']['price_extra_shipping'] = 0;

        $_SESSION['cart']['price_extra'] = 0;
    }

    if (isset($_POST['pay']) || isset($_POST['shipping'])) {
        $pay = new Payment();

        if ($_POST['pay'] > 0) {
            $_SESSION['cart']['payment_id'] = (int) security($_POST['pay']);
            $pay->payment_id = $_SESSION['cart']['payment_id'];

            $_SESSION['cart']['price_extra_payment'] = $pay->payment_price();
        } elseif (!isset($_SESSION['cart']['price_extra_payment'])) {
            $_SESSION['cart']['price_extra_payment'] = 0;
        }

        if ($_POST['shipping'] > 0) {
            $_SESSION['cart']['shipping_id'] = (int) security($_POST['shipping']);
            $p->shipping_id = $_SESSION['cart']['shipping_id'];

            $_SESSION['cart']['price_extra_shipping'] = $p->shipping_price();
        } elseif (!isset($_SESSION['cart']['price_extra_shipping'])) {
            $_SESSION['cart']['price_extra_shipping'] = 0;
        }

        $_SESSION['cart']['price_extra'] = $_SESSION['cart']['price_extra_payment'] + $_SESSION['cart']['price_extra_shipping'];
    } else {
        $_SESSION['cart']['price_extra'] = $_SESSION['cart']['price_extra_payment'] + $_SESSION['cart']['price_extra_shipping'];
    }

    /* Effect of sale and extra price */
    if (!isset($_SESSION['cart']['price_sale'])) {
        $_SESSION['cart']['price_sale'] = 0;
    }

    echo echo_cart_header();
}
/** Removes a product from cart
 * 
 * @return removes product from session
 */
function cart_del()
{
    $p = new Product();

    unset($_SESSION['cart']['products'][$_POST['id']]);
    unset($_SESSION['cart']['amount'][$_POST['id']]);

    // Total count of product in the cart
    $_SESSION['cart']['count'] = 0;
    foreach ($_SESSION['cart']['amount'] as $amount) {
        $_SESSION['cart']['count'] += $amount;
    }

    // Total price of products
    $_SESSION['cart']['price_with_tax']     = 0;
    $_SESSION['cart']['price_without_tax']    = 0;
    $_SESSION['cart']['price_tax'] = 0;
    foreach ($_SESSION['cart']['products'] as $product_id) {
        $p->product_id = $product_id;
        $cart_p = $p->product();
        $_SESSION['cart']['price_with_tax']        += $_SESSION['cart']['amount'][$product_id]    * $cart_p['general']['product_price_with_tax'];
        $_SESSION['cart']['price_without_tax']    += $_SESSION['cart']['amount'][$product_id]    * $cart_p['general']['product_price_without_tax'];
        $_SESSION['cart']['price_tax']            += $_SESSION['cart']['amount'][$product_id]    * $cart_p['general']['product_price_tax'];
    }

    // Reset weight of cart and re-calculate it
    $_SESSION['cart']['weight']     = 0;
    $_SESSION['cart']['desi']     = 0;
    foreach ($_SESSION['cart']['products'] as $product_id) {
        $_SESSION['cart']['weight']    += $p->product_weight($product_id) * $_SESSION['cart']['amount'][$product_id];
        $_SESSION['cart']['desi']    += $p->product_desi($product_id) * $_SESSION['cart']['amount'][$product_id];
    }

    // Unset selected shipping option
    if (isset($_SESSION['cart']['shipping'])) {
        unset($_SESSION['cart']['shipping']);
    }

    echo echo_cart_header();
}
/** Applies sale coupon
 * 
 */
function cart_coupon()
{
    global $site;

    $code = security($_POST['coupon']);
    $coupon = select('coupons')->where('coupon_code = "'.$code.'" AND coupon_min < '.$_SESSION['cart']['price_with_tax'].' AND coupon_start <= '.$site['timestamp'].' AND coupon_expire >= '.$site['timestamp'].' AND coupon_amount > 0')->limit(1)->result();

    if (!empty($coupon['coupon_value'])) {
        $_SESSION['cart']['coupon_code'] = $code;
        $_SESSION['cart']['price_sale'] = $coupon['coupon_value'];
    } else {
        $_SESSION['cart']['coupon_code'] = '';
        $_SESSION['cart']['price_sale'] = 0;
    }
}
function cart_table()
{
    echo echo_cart_table($_SESSION['cart']);
}
function cart_shipping()
{
    $_SESSION['cart']['shipping_id'] = (int) security($_POST['id']);

    $p = new Product();
    $p->shipping_id = $_SESSION['cart']['shipping_id'];

    $_SESSION['cart']['shipping'] = $p->shipping_price();
    //echo $p->shipping_calculate_price((int)$_POST['sum'], $_SESSION['cart']['shipping'], $_POST['city_id']);
}
/** Shipping systems
 * 
 * @return string  available shipping options
 */
function cart_shipping_systems()
{
    require_once 'core/lib/app/product.php';
    $p = new Product();

    echo '	<div class="taksitBilgi">Kargo yöntemini seçin</div>
			<div class="sepetim secim">
				<form class="formlar sepetimform">
					<table cellspacing="3" cellpadding="3" id="sepet">
						<tr class="baslik">
							<td width="20%" align="center">SEÇİM</td>
							<td width="20%" align="center">KARGO YÖNTEMİ</td>
							<td width="20%" align="center">KARGO FİYATI</td>
							<td width="40%" align="center">AÇIKLAMA</td>
						</tr>';

    foreach ($p->shippings_public() as $shipping) {
        $price = $p->shipping_calculate_price($_POST['sum'], $shipping['shipping_id'], $_POST['city_id']);

        if (is_numeric($price)) {
            $selected = '';
            if (isset($_SESSION['cart']['shipping'])) {
                if ($shipping['shipping_id'] == $_SESSION['cart']['shipping']) {
                    $selected = 'checked';
                }
            } else {
                $_SESSION['cart']['shipping'] = 0;
            }
            echo '	<tr>
											<td align="center"><input type="radio" name="shipping" value="'.$shipping['shipping_id'].'" '.$selected.' onClick="cart_shipping('.$shipping['shipping_id'].');"/></td>
											<td align="center">'.__($shipping['shipping_name']).'</td>
											<td align="center">'.$price.' TL</td>
											<td align="center">'.__($shipping['shipping_desc'], array('limit' => $price)).'</td>
										</tr>';
        }
    }
    echo '
					</table>
				</form>
			</div>
			<div class="clear"></div>';
}
/** Payment systems
 * 
 * @return string  available payment options
 */
function cart_payment()
{
    $pay = new Payment();

    $pay->payment_id = (int) security($_POST['type']);
    $pay->total = (int) security($_SESSION['cart']['price_with_tax']);

    if ($pay->is_payment_available()) {
        $_SESSION['cart']['payment'] = $pay->payment_price();
        echo_cart_payment($pay->payment_id);
    } else {
        return false;
    }
    /*
    if ($_POST['type'] == 'paypal')
    {
        // # CreatePaymentSample
        //
        // This sample code demonstrate how you can process
        // a direct credit card payment. Please note that direct
        // credit card payment and related features using the
        // REST API is restricted in some countries.
        // API used: /v1/payments/payment

        require_once('core/lib/app/paypal/sample/bootstrap.php');

        // ### CreditCard
        // A resource representing a credit card that can be
        // used to fund a payment.
        $card = new CreditCard();
        $card->setType("visa")
            ->setNumber("4148529247832259")
            ->setExpireMonth("11")
            ->setExpireYear("2019")
            ->setCvv2("012")
            ->setFirstName("Joe")
            ->setLastName("Shopper");

        // ### FundingInstrument
        // A resource representing a Payer's funding instrument.
        // For direct credit card payments, set the CreditCard
        // field on this object.
        $fi = new FundingInstrument();
        $fi->setCreditCard($card);

        // ### Payer
        // A resource representing a Payer that funds a payment
        // For direct credit card payments, set payment method
        // to 'credit_card' and add an array of funding instruments.
        $payer = new Payer();
        $payer->setPaymentMethod("credit_card")
            ->setFundingInstruments(array($fi));

        // ### Itemized information
        // (Optional) Lets you specify item wise
        // information
        $item1 = new Item();
        $item1->setName('Ground Coffee 40 oz')
            ->setDescription('Ground Coffee 40 oz')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setTax(0.3)
            ->setPrice(7.50);
        $item2 = new Item();
        $item2->setName('Granola bars')
            ->setDescription('Granola Bars with Peanuts')
            ->setCurrency('USD')
            ->setQuantity(5)
            ->setTax(0.2)
            ->setPrice(2);

        $itemList = new ItemList();
        $itemList->setItems(array($item1, $item2));

        // ### Additional payment details
        // Use this optional field to set additional
        // payment information such as tax, shipping
        // charges etc.
        $details = new Details();
        $details->setShipping(1.2)
            ->setTax(1.3)
            ->setSubtotal(17.5);

        // ### Amount
        // Lets you specify a payment amount.
        // You can also specify additional details
        // such as shipping, tax.
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal(20)
            ->setDetails($details);

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it.
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent set to sale 'sale'
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setTransactions(array($transaction));

        // For Sample Purposes Only.
        $request = clone $payment;

        // ### Create Payment
        // Create a payment by calling the payment->create() method
        // with a valid ApiContext (See bootstrap.php for more on `ApiContext`)
        // The return object contains the state.
        try {
            $payment->create($apiContext);
        } catch (Exception $ex) {
            ResultPrinter::printError('Create Payment Using Credit Card. If 500 Exception, try creating a new Credit Card using <a href="https://ppmts.custhelp.com/app/answers/detail/a_id/750">Step 4, on this link</a>, and using it.', 'Payment', null, $request, $ex);
            exit(1);
        }

        ResultPrinter::printResult('Create Payment Using Credit Card', 'Payment', $payment->getId(), $request, $payment);

        return $payment;

    }
    */
}
/** Insert order into database 
 * 
 * @param array  $_POST  get params to complete order
 * @return creates new order and invoice
 */
function cart_complete()
{
    global $pdo, $site;

    $address['cargo']['name'] = $_POST['address_cargo_name'];
    $address['cargo']['address'] = $_POST['address_cargo_address'];
    $address['cargo']['city'] = select('data_cities')->where('city_id = '.$_POST['address_cargo_city'])->limit(1)->result('city_name');
    $address['cargo']['tel'] = $_POST['address_cargo_tel'];

    $address['invoice']['name'] = $_POST['address_invoice_name'];
    $address['invoice']['address'] = $_POST['address_invoice_address'];
    $address['invoice']['city'] = select('data_cities')->where('city_id = '.$_POST['address_invoice_city'])->limit(1)->result('city_name');
    $address['invoice']['tel'] = $_POST['address_invoice_tel'];

    $payment_id = $_SESSION['payment_id'];
    $installement = $_POST['installement'];
    $total = $_POST['total'];

    $weight = $_SESSION['cart']['weight'];
    $desi = $_SESSION['cart']['desi'];
    $shipping_id = $_SESSION['cart']['shipping'];

    // Array of product
    $products = $_SESSION['cart']['products']; // Use $_SESSION['cart']['amout'] to find amount of products, check firebug to usa

    /** Firstly, create invoice
     *
     * Invoice type is important to choose is customer a firm or person
     * Use 0 for person and 1 for firm, default is 0
	 * 
	 * @return creates an invoice
     */
    insert('products_invoices')->values(array('user_id' => $_SESSION['user_id'],
                                              'invoice_type' => 0,
                                              'invoice_name' => $address['invoice']['name'],
                                              'invoice_address' => $address['invoice']['address'],
                                              'invoice_city' => $address['invoice']['city'],
                                              'invoice_tel' => $address['invoice']['tel'], ));
    $invoice_id = $pdo->insert_id();

    /** Then insert the product details for current order state, calculate price again to check
     *
     * Order status is the important thing in here and designed as
     * 0->error, 1->waiting for payment, 2->waiting for cargo, 3->completed, 4->returned
     *
     * Product details will be stored in products_orders_products
	 * 
	 * @return inserts details of cart into database
     */
    insert('products_orders')->values(array('user_id' => $_SESSION['user_id'],
                                            'invoice_id' => $invoice_id,
                                            'order_name' => $address['cargo']['name'],
                                            'order_address' => $address['cargo']['address'],
                                            'order_city' => $address['cargo']['city'],
                                            'order_tel' => $address['cargo']['tel'],
                                            'order_comment' => '',
                                            'order_timestamp' => $site['timestamp'],
                                            'order_desi' => $desi,
                                            'order_weight' => $weight,
                                            'order_total' => $total,
                                            'order_shipping_id' => $shipping_id,
                                            'order_payment_id' => $payment_id,
                                            'order_installement_id' => $installement,
                                            'order_status' => 1, ));

    $order_id = $pdo->insert_id();

    /** Finally, insert details of order
     *
     * In $products array we will see only products id so use it wisely to find quantity of each from
     * $_SESSION['cart']['amout']
     *
     * Order product status is the important thing in here and will be determined by status table
     * but for now use 1 freely to mark it as waiting
     *
	 * @return inserts detailed products in order
     */
    require_once 'core/lib/app/product.php';
    $p = new Product();

    foreach ($products as $product) {
        $p->product_id = $product;
        $pro = $p->product();

        insert('products_orders_products')->values(array('user_id' => $_SESSION['user_id'],
                                                         'order_id' => $order_id,
                                                         'product_id' => $product,
                                                         'order_product_price' => $pro['general']['product_price_with_tax'],
                                                         'order_product_quantity' => $_SESSION['cart']['amount'][$product],
                                                         'order_product_status' => 1, ));
    }
    unset($_SESSION['cart']);
    unset($_POST);
	
    /* Items in cart added into an order so clear session cart and open an empty cart */
}
