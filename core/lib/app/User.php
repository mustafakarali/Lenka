<?php
/** Every possible action for User management 
 * 
 * @category 	Core
 * @version		0.1.0
 */
class User
{
	/** Tables which are related with user 
	 * 
	 *
	 * @access public
	 * @var string
	 */
	public static $table = 'users';
	public static $table_address = 'addresses';
	
	/** user id  
	 * 
	 *
	 * @access public
	 * @var int
	 */
	var $user_id = false;
	
	/** user email. 
	 * 
	 *
	 * @access public
	 * @var bool
	 */
	var $user_email = false;
	
	/** user auth level to list. 
	 * 
	 *
	 * @access public
	 * @var bool
	 */
	var $user_auth = '= 1';
	
	/** user is active for listing purposes
	 * 
	 * @access public
	 * @var bool
	 */
	var $user_is_active = 1;
	
	/** address id 
	 * 
	 * @access public
	 * @var int
	 */
	var $address_id;
	
	/** address type for different addresses such as invoice, home, work etc...
	 * 
	 * @access public
	 * @var int
	 */
	var $address_type;
	
	/** users table name in database
	 * 
	 *
	 * @access public
	 * @var bool
	 */
	public $is_auth = false;
	
	/** User format
	 * 
     * @access public
     * @var bool
	 */
	var $user_format = true;
	
	/** Show if img value isempty
	 * 
     * @access public
     * @var string
	 */
	public static $no_pic = 'core/img/avatar.png';
	
	/** Limit for query
	 *
	 * @var int 
	 */ 
	 var $limit = 20;
	
	// Detect if user is authenticated over the selected user
	function __construct()
	{
		if ($this->user_id > 0 && $this->user_id == $_SESSION['user_id'] || $_SESSION['user_auth'] > 110)
			$this->is_auth = true;
	}
	// Gather the user information and format it
	function user_by_id()
	{
		if (!is_numeric($this->user))
			$this->user = $this->email_to_id($this->user);
		
		$user = find(self::$table, $this->user);
		$user['address'] = $this->addresses();
		return $this->format($user);
	}
	function user_with_details_by_id()
	{
		$user = $this->user_by_id();
		// Last page that user viewed
		$user['last_page'] = select('url_views')->where('user_id = "'.$this->user.'"')->order('url_views_id DESC')->limit(1)->result('url');
		// Visited pages
		$user['pages'] = select('url_views')->which('*, count(user_id) AS count')->where('user_id = "'.$this->user.'"')->group('url')->order('count DESC')->limit(10)->results();

		return $user;
	}
	/** Fetch users list and format users
	 * 
	 * @return array
	 */
	function users()
	{
		$users = select(self::$table)->results();
		
		foreach($users AS $result)
		{
			$results[] = $this->format($result);
		}
		return $results;
	}
	/** Fetch users by auth level and format users
	 * 
	 * @return array
	 */
	function users_by_auth()
	{
		$users = select(self::$table)->where('user_auth '.$this->user_auth)->limit($this->limit)->results();
		
		foreach($users AS $result)
		{
			$results[] = $this->format($result);
		}
		return $results;
	}
	/** Fetch users by lastlogin and format users
	 * 
	 * @return array
	 */
	function users_by_lastlogin()
	{
		$users = select(self::$table)->where('user_auth '.$this->user_auth.' AND is_active > 0')->order('user_timestamp DESC')->limit($this->limit)->results();
		
		foreach($users AS $result)
		{
			$results[] = $this->format($result);
		}
		return @$results;
		
	}
	/** Fetch users by lastactive and format users
	 * 
	 * @return array
	 */
	function users_by_active()
	{
		$users = select(self::$table)->where('is_active = '.$this->user_is_active)->order('user_timestamp ASC')->limit($this->limit)->results();
		
		foreach($users AS $result)
		{
			$results[] = $this->format($result);
		}
		return $results;
	}
	/** Find user and gather id by email
	 * 
	 * @param string email address of user
	 * @return int id of user
	 */
	function email_to_id($user)
	{
		return select(self::$table)->where('user_email = "'.$user.'"')->limit(1)->result('user_id');		
	}
	/** Find user and gather id by email
	 * 
	 * @param int id of the user
	 * @return string email address of user
	 */
	function id_to_email($user)
	{
		return select(self::$table)->where('user_id = "'.$user.'"')->limit(1)->result('user_email');			
	}
	/** Add new user
	 * 
	 * @param array
	 * @return insert 
	 */
	public function add($values)
	{
		insert(self::$table)->values($values);
	}
	/** Update
	 * 
	 * @param array
	 * @return update 
	 */
	public function update($values, $user)
	{
		if (!is_numeric($user))
			$user = $this->email_to_id($user);
		
		// Check users authentication 
		if ($this->is_auth)
			return update(self::$table)->values($values)->where('user_id = "'.$user.'"');
	}
	/** Addresses, user, product, shipping etc... there might be houndreds of address for specific items
	 * 
	 * @return array 
	 */
	public function addresses()
	{
		return select(self::$table_address)->where('user_id = '.$this->user)->results();	
	}
	/** Update addresses of user
	 * 
	 * @param values array, address value of user
	 * @param user, user_id
	 * @return updated address
	 */
	public function update_address($values, $user)
	{
		// If user has address update it else insert a new one
		if ($this->address_id > 0 && $this->has_address($this->address_id))
		{
			update(self::$table_address)->values(array('address_receiver'=>$values['receiver'],
													   'address_address'=>$values['address'],
													   'address_district'=>$values['district'],
													   'address_city'=>$values['city'],
													   'address_tel'=>$values['tel']))
										->where('address_id = '.$this->address_id);
		}
		else 
		{
			insert(self::$table_address)->values(array('user_id'=>$user,
												   'address_receiver'=>$values['receiver'],
												   'address_type'=>$this->address_type,
												   'address_address'=>$values['address'],
												   'address_district'=>$values['district'],
												   'address_city'=>$values['city'],
												   'address_tel'=>$values['tel']));
		
		}	
	}
	/** Check if there is an address
	 * 
	 * @return array
	 */
	protected function has_address()
	{
		return select(self::$table_address)->where('address_id = '.$this->address_id)->limit(1)->result();	
	}	
	/** Delete a user
	 * 
	 * @param int user_id
	 * @return deletes row
	 */ 
	public function delete($user)
	{
		if (!is_numeric($user))
			$user = $this->email_to_id($user);
		
		// Check users authentication 
		if ($this->is_auth)
			delete(self::$table)->where('user_id = "'.$user.'"')->run();
				
		return false;
	}
	/** Format user info to display
	 * 
	 * @param array
	 * @return array
	 */
	protected function format($result)
	{
		global $setting, $site;
		
		// Set a new variable to determine activation level of user by color
		if ($result['is_active'] == 0)
			$color = 'style="color:red;"';
		elseif ($result['is_active'] == 1)
			$color = '';
		else
			$color = 'style="color:darkred;"';	
		
		$result['user_colored_email'] = '<span '.$color.'>'.$result['user_email'].'</span>';
		
		if ($this->user_format)
		{
			if (!empty($result['user_img']))
				$result['user_img'] = $site['image_path'].$result['user_img'];
			else
				$result['user_img'] = Routes::$base.self::$no_pic;
			
			if ($result['user_ip'] = '::1')
				$result['user_ip'] = '127.0.0.1';
		}
		$result['user_timestamp'] = date($setting['date_format'], $result['user_timestamp']);
		
		unset($result['user_pass']);	
			
		return $result;
	}
	
	/** Sign in member 
	 * 
	 * @param string
	 * @param string
	 */
	function signin($user_email, $user_pass)
	{
		global $site;
		
		// Encrypt
		$user_pass = encrypt($user_pass);
		
		// Gather user info
		$result = select(self::$table)->where('user_email = "'.$user_email.'" AND user_pass = "'.$user_pass.'"')->limit(1)->result();
		
		if ($result)
		{
			// If user is active go on
			if ($result['is_active'] == 1)
			{
				// Update user last login and ip addresss
				update(self::$table)->values(array("user_timestamp"=>$site['timestamp'], "user_ip"=>ip()))->where('user_id = "'.$result['user_id'].'"');
				$result['address'] = select(self::$table_address)->where('user_id = "'.$result['user_id'].'"')->order('address_type ASC')->results();
				$result = $this->format($result);
				set_session($result);
				
				if ($result['user_auth'] < 100)
					header("Location: ".Routes::$base);
				else
					header("Location: ".Routes::$base.'admin');	
			}	
			// is member active or banned
			elseif ($result['is_active'] == 0)
				echo __('You are banned');	
			// Hiç aktivasyon yapmamış kullanıcı
			else
				echo __('You have to activate your account');	
		}
		
		$_SESSION['error'] = __('Something went wrong please try again');
		
		return false;
	}	
	/** Sign up new user
	 * 
	 * @param string
	 * @param string
	 * @param string
	 */
	function signup($email, $pass1, $pass2)
	{
		global $setting, $site;
		
		// Control the passwords, if they are matching creat a hash to insert
		if (!empty($email) && !empty($pass1) && $pass1 == $pass2)
		{
			$pass = encrypt($pass1);
		}
		else 
		{
			$_SESSION['error'] = __('Passwords are not same');
			return false;
		}
		// Is user a member? If yes, sign in! If not, sign up...
		if (isset($email))
		{
			$result = select(self::$table)->where('user_email = "'.$email.'"')->limit(1)->result();
			
			if ($result)
			{
				$_SESSION['error'] = __('User is already a member');
				
				// Is a member, and everything is ok to sign in, so sign in!
				if ($result['user_pass'] == $pass1 && $result['is_active'] == 1)
					$this->signin($email, $pass1);
				// Is member exist but banned, stop it!
				elseif ($result['user_pass'] == $pass1 && $result['is_active'] == 0)
					$_SESSION['error'] = __('You are banned');	
				// User exists but have not activate account, show a message
				else
					$_SESSION['error'] = __('You have to activate your account');		
				
				return false;
			}
		}
		/* insert user into database */
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
		{
			$_SESSION['error'] = __('Registiration is completed. Please activate your account');
			// Set an activation code
			$aktivation_code = rand(10000,99999);
			// Compose email
			$msg = '	<html>
							<body>
							  <h3>'.__('Aktivation code').'</h3>
							  <p><a href="'.Routes::$base.'/giris/'.$aktivation_code.'">'. __('Click to activate') .'</a></p>
							</body>
						</html>';
			email($email, __('Aktivation mail'), $msg);	
			
			insert(self::$table)->values(array("user_email" => $email, "user_pass"=>$pass, "user_auth"=>1, "is_active"=>$aktivation_code));
			return true;
		}
		else
		{
		    $_SESSION['error'] = __('There is an error in your information');
			return false;
		}	
	}
	/** Activate user with activation code
	 * 
	 * @param string
	 * @param string
	 */
	function activate_user($email, $code)
	{
		global $setting;
		
		// Gather user
		$result = select(self::$table)->where('user_email = "'.$email.'" ')->limit(1)->result();
		
		// User is currently active so must type password in
		if ($result['is_active'] == 1)
		{
			echo __('Account had activated before');
			return false;	
		}
		// User is banned, stop activation
		elseif ($result['is_active'] == 0)
		{
			echo __('You are banned');	
			return false;	
		}
		// Activate user
		elseif ($result['is_active'] == $code)
		{
			echo __('Activation is completed');
			
			// Activate
			$result = update(self::$table)->values(array('is_active'=>1))->where('user_name = "'.$email.'" AND is_active = "'.$code.'" ')->result();
			
			// Signin! To sign in, we must decrypt user's password which is not a cool thing
			$this->signin($email,decrypt($result['user_pass']));
			return false;			
		}
	}
	/** Generate new password and mail it
	 * 
	 * @param int
	 */
	function forget_password($user)
	{
		global $setting;
		
		if (!is_numeric($user))
			$user = $this->email_to_id($user);
		
		$result = select(self::$table)->where('user_id = "'.$user.'"')->limit(1)->result();
		
		if ($sonuc)
		{
			// New pass
			$new_pass = $this->change_password($user);
			// Mesajı aktivasyon koduyla birlikte oluşturark mail'in içeriğini yaratalım
			$msg = __('New password').': '.$new_pass;
			
			email($this->id_to_email($user), __('New password'), $msg);	
		}
		else 
		{
			// Couldn't find the member
			echo __('You are not a member');
		}
	}
	/** Change the password of user with randomly created one
	 * 
	 * @param int
	 * @return string
	 */
	private function change_password($user)
	{
		if (!is_numeric($user))
			$user = $this->email_to_id($user);
		
		$new_pass = rand(10000,99999);
		$new_hash = encrypt($new_pass);

		update(self::$table)->values(array('user_pass'=>$new_hash))->where('user_id = "'.$user.'"')->limit(1)->run();

		return $new_pass;			
	}
	/** Check to see if pass is true
	 * 
	 * @param int
	 * @param string
	 * @return array
	 */
	public function is_pass_true($user_id, $pass)
	{
		return select(self::$table)->where('user_id = '.$user_id.' AND user_pass = "'.encrypt($pass).'"')->result();
	}
	public final function connect_fb($facebook_id, $facebook_profile, $facebook_friendlist)
	{
		global $site;
		
		// Eğer kullanıcı daha önce kayıt yaptıysa oturum bilgisini yükleyerek ana sayfaya döndürelim
		$sonuc = select(self::$table)->where('user_fb = "'.$facebook_id.'"')->limit(1)->result();
		$facebook_sifre = rand(0, 999999);
			
		/* Important fields
		$facebook_id;
		$facebook_profile['first_name'];
		$facebook_profile['last_name'];
		$facebook_profile['user_name'];
		$facebook_profile['gender'];
		$facebook_profile['link'];
		$facebook_profile['education'][0]['name'];
		$facebook_profile['languages'];
		$facebook_profile['location']['name'];
		$facebook_profile['timezone'];
		$facebook_profile['work'][0]['employer']['name'];
		$facebook_profile['work'][0]['position']['name'];
		$facebook_profile['hometown']['name'];
		*/
			
		// Kullanıcı mevcut giriş izni verelim
		if ($sonuc)
		{
			// Aktif kullanıcı	
			if ($sonuc['is_active'] == 1)
			{
				/* Kullanıcı tablosunda güncellemmeleri yapalım
				 * 
				 * kullanici_timestamp, kullanici_ip vb. her sayfa yenilendiğinde otomatik olarak atanmaktadır. 
				 * Giriş sırasında bunu veritabanına kaydetmek yerinde olacaktır.
				 */
				update(self::$table)->values(array('user_ip'=>ip()))->where('user_id = "'.$sonuc['user_id'].'"');
				
				/*
				// Kullanıcılarımızdan elemanın takip etmediği arkadaşlarını bulalım
				$sorgu_friend = "SELECT * FROM gnc_kullanicilar WHERE kullanici_fb > 0 AND "; 
				$f = 1;
				$i_facebook_friend = count($facebook_friendlist);
				foreach($facebook_friendlist AS $facebook_friend)
				{
					$sorgu_friend .= "kullanici_fb = '".$facebook_friend['id']."'";
					if ($i_facebook_friend != $f)
					{
						$sorgu_friend .= " OR ";
					}
					$f++;
					
				}			
				if ($facebook_id = 607969237)
				{
					$sorgu_friend = $vt->query($sorgu_friend);
					
					while ($sonuc_friend = $vt->fetch_array($sorgu_friend))
						$facebook_friends[] = $sonuc_friend;
					
				}
				*/
				
				$_SESSION = $sonuc;
				
				header("Location:".Routes::$base);
			}	
		}
		// Kullanıcı bulunmuyor, kayıt işlemini tamamlayıp giriş yaptıralım
		else 
		{
			$facebook_sifre = rand(0, 999999);
			
			/* Important fields
			$facebook_id;
			$facebook_profile['first_name'];
			$facebook_profile['last_name'];
			$facebook_profile['user_name'];
			$facebook_profile['gender'];
			$facebook_profile['link'];
			$facebook_profile['education'][0]['school']['name'];
			$facebook_profile['languages'];
			$facebook_profile['location']['name'];
			$facebook_profile['timezone'];
			$facebook_profile['work'][0]['employer']['name'];
			$facebook_profile['work'][0]['position']['name'];
			$facebook_profile['hometown']['name'];
			*/
			
			if ($facebook_profile['gender'] == 'male')
				$facebook_profile['gender'] = 1;
			else
				$facebook_profile['gender'] = 2;
			
			$facebook_location = (explode(',', $facebook_profile['location']['name']));
			$loc_city = $facebook_location[0];
			$loc_country = $facebook_location[1];
			
			insert(self::$table)->values(array('user_email'=>$facebook_id, 
										  'user_pass'=>$facebook_sifre,
										  'user_auth'=>1,
										  'user_name'=>$facebook_profile['first_name'],
										  'user_gender'=>$facebook_profile['gender'],
										  'user_fb'=>$facebook_id,
										  'user_timestamp'=>$site['user_timestamp'],
										  'user_ip'=>$_SESSION['user_ip'],
										  'is_active'=>1));
			
			$sonuc = select('users')->where('user_fb = "'.$facebook_id.'"')->limit(1)->result();
			
			if ($sonuc)
			{
				$_SESSION = $sonuc;
				
				header("Location:".Routes::$base);
			}		
		}
	}
}

