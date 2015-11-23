<?php
/** Payment Class
 * 
 * @category 	Core
 * @version		0.1.0
 */
class Payment
{
	// Price
	var $total = 0;
	var $installement = 0;
	
	// Payment model
	var $product_id = false;
	// Payment model
	var $payment_id = false;
	
	var $row_price = false;
	
	// Tables which are directly related with products
	public static $table_products = 'products';
	public static $table_payments = 'payments';
	
	function __construct()
	{
		$this->product = array();
	}
	
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
	public function payments_available()
	{
		return select(self::$table_payments)
				->where('payment_min <= '.$this->total.' AND payment_max >= '.$this->total.' AND is_public > 0')
				->group('payment_id')
				->order('payment_order ASC')
				->results();	
	}
	public function is_payment_available()
	{
		return select(self::$table_payments)
				->where('payment_min <= '.$this->total.' AND payment_max >= '.$this->total.' AND payment_id = '.$this->payment_id)
				->limit(1)
				->result();
	}
	public function payment_name()
	{
		$payment = $this->payments();
		return __($payment['payment_name']);
	}
	public function payment_price()
	{
		$payment = $this->payments();
		
		if ($this->row_price)
			return $payment['payment_price'];
		
		$symbol = substr($payment['payment_info'], 0);
		
		return $symbol.$payment['payment_price'];
	}
	public function installements()
	{
		$payment = $this->payments();
		
		$conditions = explode(',', $payment['payment_condition']);
		foreach ($conditions AS $condition)
		{
			$array = explode(':', $condition);
			@$installement[$array[0]] = $array[1];
		}
		
		return $installement;
	}
	
}