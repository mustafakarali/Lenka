<?php
/** Routes Class
 * 
 * This Class is parsing URL
 * 
 * @category 	Core
 * @version		0.1.0
 * 
 */
class Routes
{
	/** Base URL
	 * 
	 * @access 	Public
	 * @var string
	 */
	public static $base;
	
	/** Base URL with https
	 * 
	 * @access 	Public
	 * @var string
	 */
	public static $secure;
	
	/** First part of the URL
	 * 
	 * @access 	Public
	 * @var string
	 */
	public static $module;
	
	/** Second part of the URL
	 * 
	 * @access 	Public
	 * @var string
	 */
	public static $func;
	
	/** Exploded parts of the URL after second part
	 * 
	 * @access 	Public
	 * @var string
	 */
	public static $get;
	
	/** Path for image folder
	 * 
	 * @access 	Public
	 * @var string
	 */
	public static $current;
	
	/** Path for image folder
	 * 
	 * @access 	Public
	 * @var string
	 */
	public static $full;
	
	/** Path for image folder
	 * 
	 * @access 	Public
	 * @var string
	 */
	public static $page;
	
	/** Path for image folder
	 * 
	 * @access 	Public
	 * @var string
	 */
	public static $image;
	
	public static $path;

	public function __construct()
	{
		global $setting, $site;

		if (isset($_SERVER['ORIG_PATH_INFO']))
			$path = $_SERVER['ORIG_PATH_INFO'];
		elseif (isset($_SERVER['PATH_INFO']))
			$path = $_SERVER['PATH_INFO'];
		elseif (isset($_SERVER['REDIRECT_SCRIPT_URL']))
			$path = $_SERVER['REDIRECT_SCRIPT_URL'];
		
		if (strpos($site['url'], 'https://') !== false && strpos($_SERVER['SCRIPT_URI'], 'http://') !== false)
		{
			header('Location: '.str_replace('http://', 'https://', $_SERVER['SCRIPT_URI']));
		}
		
		if (isset($path))
		{
			$path = str_replace('/index.php', '', $path);
		
			$path = substr($path, 1);
			$route = explode('/', $path);
			
			self::$module	= @$route[0];
			self::$func		= @$route[1];
			self::$get		= @array('1'=>$route[2],
									 '2'=>$route[3],
								     '3'=>$route[4],
								     '4'=>$route[5],
								     '5'=>$route[6]);
			
			self::$current 	= $site['url'].$path;
			self::$full		= $site['url'].$path;
			self::$page 	= $site['url'].$path;
		}
		else
		{
			self::$module	= $setting['index'];
			self::$current 	= $site['url'];
			self::$full		= $site['url'];
			self::$page		= $site['url'];
		}
		
		self::$base = $site['url'];
		self::$secure = str_replace('http:', 'https:', $site['url']);	
		
		self::$path = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];		
		
		self::$image = self::$base.'data/_images/';
	}
}