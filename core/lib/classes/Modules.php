<?php
/** Module Class
 * 
 * All system is based on modules which is structured as MVC files
 * It's integrated with database and everypage in the project is generated with 
 * this way and predefined rules
 * 
 * @category 	Core
 * @version		0.1.0
 * 
 */
class Modules
{
	/** Module table
	 *
	 * @access private
	 * @var string
	 */
	private static $table_modules = 'modules';
	
	/** Routers table
	 *
	 * @access private
	 * @var string
	 */
	private static $table_routes  = 'routers';
	
	/** Parent folder of module files
	 *
	 * @access private
	 * @var string
	 */
	var $parent_folder = 'app';
	
	function __construct()
	{
		/* Call every global variables in here
		 * otherwise it won't work properly
		 * 
		 */
		global $lang, $setting, $site;
		
		if (empty(Routes::$module))
			$module = $setting['index'];
		else
			$module = Routes::$module;

		$res = select(self::$table_modules)->left(self::$table_routes.' ON '.self::$table_routes.'.module_id = '.self::$table_modules.'.module_id')->where(self::$table_modules.'.is_visible = 1 AND '.self::$table_routes.'.router_sef = "'.$module.'"')->limit(1)->result();
		
		// Parent folder
		if (!empty($res['module_parent_folder']))
			$this->parent_folder = $res['module_parent_folder'];
		
		// Check user auth level
		if ($res['module_auth'] > $_SESSION['user_auth'])
		{
			// If not an authenticated user show 401 page
			include('app/view/header.php');
			error_in_page(401);
			return false;
		}
		
		// Check if page is existing
		if (!file_exists($this->parent_folder.'/view/'.$res['module_name'].'.php'))
		{
			// If not show 404 page
			include($this->parent_folder.'/view/header.php');
			error_in_page(404);
			return false;
		}
		
		if (empty($res['module_header']))
			$res['module_header'] = 'header';
		
		if (empty($res['module_footer']))
			$res['module_footer'] = 'footer';
		
		// Language files in core
		@include_once('core/lang/'. $_SESSION['lang_code'] .'/default.php');
		@include_once('core/lang/'. $_SESSION['lang_code'] .'/'.$res['module_name'].'.php');
		// Language files of applications
		@include_once($this->parent_folder.'/lang/'. $_SESSION['lang_code'] .'/default.php');
		@include_once($this->parent_folder.'/lang/'. $_SESSION['lang_code'] .'/'.$res['module_name'].'.php');
		// Core class for asked module
		if (@file_exists('core/lib/app/'.$res['module_name'].'.php'))
			include_once('core/lib/app/'.$res['module_name'].'.php');
		// MVC files
		include_once($this->parent_folder.'/model/'.$res['module_name'].'.php');
		include_once($this->parent_folder.'/controller/'.$res['module_name'].'.php');
		
		if (file_exists($this->parent_folder.'/view/'.$res['module_header'].'.php'))
			include_once($this->parent_folder.'/view/'.$res['module_header'].'.php');	
		
		include_once($this->parent_folder.'/view/'.$res['module_name'].'.php');	
		
		if (@file_exists($this->parent_folder.'/view/'.$res['module_footer'].'.php'))
			include_once($this->parent_folder.'/view/'.$res['module_footer'].'.php');	
	}	
	/** In URL structure default usage is defined as second part of the URL is 
	 * the main function of module as http://domainname/module/function so if there
	 * is a function with the same name as in the URL will run automatically 
	 * after authentication check
	 * 
	 * @return runs a function
	 */
	public final function func_run($default_func = '')
	{
		if (!empty(Routes::$func))
			Routes::$func = str_replace('-', '_', Routes::$func);
		
		if (empty(Routes::$func) && function_exists(Routes::$module))
			$this->func_auth(Routes::$module);
		elseif (!empty(Routes::$func) && function_exists(Routes::$func))
			$this->func_auth(Routes::$func);
		elseif (empty(Routes::$func) && !function_exists(Routes::$module))
			$this->func_auth($default_func());	
		else
		{
			include($this->parent_folder.'/view/header.php');
			error_in_page(401);
		}
	}
	/** Checks if user level is in the blacklist for function
	 * 
	 * @return runs a function
	 */
	public function func_auth($func)
	{
		/** Define authentication levels for function to create a black list
		 * If not determined user can run this function
		 * 
		 * @var array
		 */
		$func_auth = array(	"cache_klasorunu_temizle"=>"100",
							"tablodaki_ilgili_satir_ve_sutunu_guncelle" => "100");
		
		if (!empty($func_auth[$func]))
		{
			if ($_SESSION['user_auth'] > $func_auth[$func])
			{
				$func();
			}
			else 
			{
				include($this->parent_folder.'/view/header.php');
				error_in_page(401);
			}	
		}
		else
		{
			if (!empty($func))
				$func();	
		}
	}
}