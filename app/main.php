<?php
/**********************************************************************************
* main.php                                                                        *
***********************************************************************************
* LENKA CMS																		  *
* Arama Motoru Dostu İçerik Yönetim Sistemi                         			  *
* =============================================================================== * 
* Yazılım Sürümü:             Lenka 0.1 Beta                                       *
* Yazar:					  Günce Ali Bektaş <guncebektas@gmail.com>		      *
* Telif Hakkı Sahibi:         Günce Ali Bektaş					  				  *
* İndirme Adresi: 			  www.guncebektas.com 								  *
***********************************************************************************
* Bu yazılım gnc adı altında ücretsiz ve açık kaynak olarak Günce Bektaş 		  *
* tarafından sunulmuştur. 														  *
* 													                              *
* Kullanım hakkı dağıtım ve satış haklarını birlikte getirmez, dağıtımı ve satışı * 
* yasaktır her dosya kullanıcıya özel olarak işaretlenmiş olup, lisansa aykırı    *
* bir durum halinde T.C. Ankara Mahkemeleri yetkilidir.                           *
**********************************************************************************/

// Define LENKA
define('lenka', 1);

require_once('core/lib/scripts/security.php');		// Security functions

// Database connections
require_once('database.php');
// Settings
require_once('settings.php');

// Auto looader
function autoload($class_name) 
{
	if (!class_exists($class_name))
	{
		@include_once('core/lib/classes/'.$class_name.'.php');
		@include_once('core/lib/scripts/'.$class_name.'.php');
	    @include_once('core/lib/app/'.$class_name.'.php');
	}
}
	
spl_autoload_register('autoload');

// Routes
new Routes();

// Frequently used functions
require_once('core/lib/classes/Upload.php');		// Framework
require_once('core/lib/scripts/framework.php');		// Framework

// Manage sessions on database
ini_set('session.gc_maxlifetime', $setting['session_life']);
new Sessions($pdo);

// Error reporting
if ($_SESSION['user_auth'] == 111)
	error_reporting(E_ALL);
elseif ($_SESSION['user_auth'] > 99)
	error_reporting(E_NOTICE);
else
	error_reporting(0);

// Check multi lang support, if disabled set session data to default language
if (!$setting['multi_lang'])
{
	$_SESSION['lang_code'] = $setting['default_lang'];
	$_SESSION['lang_id'] = $setting['default_lang_id'];	
}
else
{
	// If multi lang is on, include language file
	if (!empty($_GET['lang']))
	{
		$browser_lang = $_GET['lang'];
		$result = select('langs')->where('lang_code = "'.$browser_lang.'"')->limit(1)->result();
		$_SESSION['lang_code'] = $result['lang_code'];
		$_SESSION['lang_id'] = $result['lang_id']; 	
	}
	if (empty($_SESSION['lang_code']))
	{
		$browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		$result = select('langs')->where('lang_code = "'.$browser_lang.'"')->limit(1)->result();
		if($result)    
		{
			$_SESSION['lang_code'] = $result['lang_code'];
			$_SESSION['lang_id'] = $result['lang_id']; 
		}
	}	
}
// Google bot can see the site on default lang
if (strpos($_SERVER['HTTP_USER_AGENT'],"Googlebot"))
{
	$_SESSION['lang_code'] = $setting['default_lang'];
	$_SESSION['lang_id'] = $setting['default_lang_id'];
}
// Include language files
include_once('core/lang/'. $_SESSION['lang_code'] .'/default.php');	
// Include frequently used functions in core
require_once('core/lib/scripts/functions.php');
// Include frequently used functions in app
require_once('functions.php');

// Maintaince mode, only editors can access to the site
$error_message = '';
$warning_message = '';
unset($_SESSION['warning']);
if ($setting['maintaince'] == 'on')
{
	$error_message = __('There is a small maintaince issue on the site');
	if (is_auth(90))
		$_SESSION['warning'] =  '<p>'. __('Maintaince mode is on! Users can\'t use some feautures of the site during maintaince, please visit again later') .'</p>';
	else 
		$warning_message = __('Maintaince mode is on! Users can\'t use some feautures of the site during maintaince, please visit again later');
		
	if (Routes::$module != 'admin' && Routes::$module != 'sign-in' && Routes::$module != 'giris' && !is_auth(90))
	{
		require_once('view/header_clean.php');
		require_once('view/maintaince.php');
		require_once('view/footer_clean.php');
		die;	
	}	
}
// Maintaince mode, only editors can access to the site
if ($setting['construction'] == 'on')
{
	$error_message = __('Site is under construction');
	if (is_auth(90))
		$_SESSION['warning'] = '<p>'. __('Site is under construction! Users can\'t use some feautures of the site during construction, please visit again later') .'</p>';
	else 
		$warning_message = __('Site is under construction! Users can\'t use some feautures of the site during construction, please visit again later');

	if (Routes::$module != 'admin' && Routes::$module != 'sign-in' && Routes::$module != 'giris' && !is_auth(90))
	{
		require_once('view/header_clean.php');
		require_once('view/construction.php');
		require_once('view/footer_clean.php');
		die;	
	}	
}

// PDF, JS, XML & Sitemap must be called before Gzip
if (Routes::$module == 'sitemap.php')
{
	require_once('view/sitemap.php');
	site_map();
	die;
}

// Gzip
if (!empty($setting['gzip_sikistirma']) && ini_get('zlib.output_compression') == FALSE)
	ob_start('ob_gzhandler');
else
	ob_start();

// Ajax
if (Routes::$module == 'ajax')
{
	require_once('core/ajax.php');
	die;
}
if (Routes::$module == 'ajax-app')
{
	require_once('app/ajax.php');
	die;
}
if (Routes::$module == 'ajax-cms')
{
	require_once('cms/ajax.php');
	die;
}

/* Set last_online, and ip address to the database */
$_SESSION['user_lastonline'] = $site['timestamp'];
$_SESSION['user_ip'] = ip();

if (@$_REQUEST['flush'] == 'yes')
{
	if ($_SESSION['user_auth'] == 111)
	{
		// Memcache modülünü çalıştır
		$memcache = new Memcache;
		$memcache->connect('127.0.0.1', 11211) or die ("MemCached servera baglanilamiyor!");	
		
		memcache_flush($memcache);
	}	
}

$module = new Modules();