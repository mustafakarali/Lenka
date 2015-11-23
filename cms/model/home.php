<?php
/** Check user auth level to continue
 *
 */	
if (!is_auth(100))
	die();

// Include important functions in cms folder
require_once('cms/functions.php');

// Helper class for input elements
new Input();

// If multi-lang support is disabled set lang_id to $_SESSION['lang_id'] when it's empty
if (empty($_POST['lang_id']))
	$_POST['lang_id'] = $_SESSION['lang_id'];

/** Extends Setting Class from core 
 * 
 */
class _Setting extends Setting
{
	/** Gathers settings from database by group_id 
	 *
	 * @param int group 
	 * @return array settings by group_id 
	 */
	public static function settings_by_group($group = 1)
	{
		return select(self::$table_settings)->where('setting_group = "'.$group.'"')->order('setting_id ASC')->results();
	}
	
	public static function add_setting()
	{
		if (isset($_POST['setting_add'])){
			$values = array("setting_name"=>$_POST['name'],
							"setting_value"=>$_POST['value'],
							"setting_explanation"=>$_POST['desc']);
					   
			insert(self::$table_settings)->values($values);
			
			note('Added successfully');
			
			unset($_POST);
		}
	}

	public static function edit_setting()
	{
		if (!empty($_POST['setting_edit'])){
			$keys = array_keys($_POST);	
			$vals = array_values($_POST);
		
			// Tek tek tüm değerleri update et
			for ($i=0; $i<count($_POST); $i++){					  
				update(self::$table_settings)->values(array('setting_value'=>$vals[$i]))->where('setting_name = "'.$keys[$i].'" ');
			}
			
			note('Edited successfully');
			
			unset($_POST);
		}
	}
}
/** Extends Calendar Class from core 
 * 
 */
class _Calendar extends Calendar
{
	public function add_event()
	{
		if (isset($_POST['title'])){
			$_POST['start'] = strtotime(str_replace('00:00:00',  $_POST['start_time'], date('Y-m-d 00:00:00',$_POST['start'])));
			$_POST['end']   = strtotime(str_replace('00:00:00',  $_POST['end_time'], date('Y-m-d 00:00:00',$_POST['end']))); 

			insert('calendars_events')->values(array('user_id'=>$_SESSION['user_id'],
													 'title'=>$_POST['title'],
													 'text'=>$_POST['text'],
													 'start'=>$_POST['start'],
													 'end'=>$_POST['end'],
													 'allday'=>$_POST['allday'],
													 'url'=>$_POST['url'],
													 'color'=>$_POST['color'],
													 'textColor'=>$_POST['textColor']));	
			
			note('Added successfully');
		}
	}	
	
	public function edit_event()
	{
		if (isset($_POST['title'])){
			$_POST['start'] = strtotime(str_replace('00:00:00',  $_POST['start_time'], date('Y-m-d 00:00:00',$_POST['start'])));
			$_POST['end']   = strtotime(str_replace('00:00:00',  $_POST['end_time'], date('Y-m-d 00:00:00',$_POST['end']))); 
			
			update('calendars_events')->values(array('user_id'=>$_SESSION['user_id'],
													 'title'=>$_POST['title'],
													 'text'=>$_POST['text'],
													 'start'=>$_POST['start'],
													 'end'=>$_POST['end'],
													 'allday'=>$_POST['allday'],
													 'url'=>$_POST['url'],
													 'color'=>'#'.$_POST['color'],
													 'textColor'=>'#'.$_POST['textColor']))->where('calendar_event_id = '.Routes::$get[1]);	
			note('Added successfully');
		}
	}	
}
/** Extends User Class from core 
 * 
 */
class _User extends User
{
	public function add_user()
	{
		if (isset($_POST['add_user'])){
			$array['user_email'] = $_POST['email'];
			
			// User can't add a user who has more rights than existing one
			if ($_POST['auth'] > $_SESSION['user_auth'])
				$array['user_auth'] = $_SESSION['user_auth'];
			else
				$array['user_auth'] = $_POST['auth'];
				
			$array['user_name'] = $_POST['name'];
			$array['user_surname'] = $_POST['surname'];
			$array['user_img'] = $_POST['image'];
			$array['user_about'] = $_POST['user_about'];
			
			// Encrypt password before inserting into database
			if (!empty($_POST['pass1']))
				$array['user_pass'] = encrypt($_POST['pass1']);
			
			insert(self::$table)->values($array);
			
			note('Added successfully');	
		}	
	}	
	public function edit_user()
	{
		if (isset($_POST['edit_user'])){
			$array['user_email'] = $_POST['email'];
			$array['user_auth'] = $_POST['auth'];
			$array['user_name'] = $_POST['name'];
			$array['user_surname'] = $_POST['surname'];
			$array['user_img'] = $_POST['image'];
			$array['user_about'] = $_POST['user_about'];
			
			// Encrypt password before inserting into database
			if (!empty($_POST['pass1']))
				$array['user_pass'] = encrypt($_POST['pass1']);
			
			update(self::$table)->values($array)->where('user_id = '.Routes::$get[1]);
			
			note('Edited successfully');
		}	
	}	
}
/** Extends Menu Class from core 
 * 
 */
class _Menu extends Menu
{
	private static $table = 'menus';
	private static $table_data = 'menus_data';
	
	public function add_menu()
	{
		if (isset($_POST['menu_add'])){
			insert(self::$table)->values(array('lang_id'=>$_POST['lang_id'], 
											   'menu_name'=>$_POST['menu_name'],
											   'menu_text'=>$_POST['menu_text']));
							
			note('Added successfully');
		}			
	}
	
	/** Fetchs all menu data 
	 *
	 * @return array 
	 */
	public function menus_data()
	{
		return select(self::$table.'_datas')->results();	
	}
	
	/** Fetchs all menu data in selected menu
	 *
	 * @param int menu_id
	 * @return array 
	 */
	public function menus_data_by_menu($menu_id)
	{
		return select(self::$table.'_datas')->where('menu_id = "'.$menu_id.'" ')->results();	
	}
	
	public function add_menus_data()
	{
		if (isset($_POST['add_menus_data'])){
			insert(self::$table_data)->values(array('menu_id'=>$_POST['menu_id'], 
											   		'menu_data_name'=>$_POST['menu_data_name'],
											   		'menu_data_href'=>$_POST['menu_data_href'],
											   		'menu_data_target'=>$_POST['menu_data_target']));
				
			note('Added successfully');
		}	
	}
	
	public function edit_menus_data()
	{
		if (isset($_POST['edit_menus_data'])){
			//Array ( [menu_id] => 1 [menu_data_name] => Başkandan Mesaj [menu_data_href] => content/baskandanmesaj [menu_data_target] => _self 
			update(self::$table_data)->values(array('menu_id'=>$_POST['menu_id'], 
											   		'menu_data_name'=>$_POST['menu_data_name'],
											   		'menu_data_href'=>$_POST['menu_data_href'],
											   		'menu_data_target'=>$_POST['menu_data_target']))->where('menu_data_id = '.$_POST['menu_data_id']);
													
			note('Edited successfully');
		}			
	}
	
	/** Display menu as tree structured
	 *
	 * @return array 
	 
	public function display_menus($menu = 0, $menu_eleman_id = 0, $ic_menu = 0)
	{
		global $site, $pdo;
		
		// Kategorinin altındaki alt kategorileri ağaç yapısı içinde gösteren fonksiyon
		$sorgu = $pdo->query("SELECT * FROM gnc_menuler 
							 LEFT JOIN gnc_menulerin_elemanlari ON gnc_menulerin_elemanlari.menu_id = gnc_menuler.menu_id
							 WHERE gnc_menulerin_elemanlari.menu_eleman_id_ust = '$menu_eleman_id' AND gnc_menuler.menu_id = '$menu'
							 ORDER BY gnc_menulerin_elemanlari.menu_eleman_sira ASC ");
		
		// Drag & Drop ile sıralama için gerekli olan yapı, $ic_kategori ana kategori olmadığını bir parent kategorinin child'ı durumunu ifade etmektedir.
		if ($ic_menu == 1)
			echo '<ol>';
		while ($sonuc = $pdo->fetch_array($sorgu))
		{
			echo '<li id="list_'.$sonuc['menu_eleman_id'].'">
					<div>
						<span class="disclose"><span></span></span>
						<a href="'. $sonuc['menu_eleman_href'] .'">'. $sonuc['menu_eleman_adi'] .'</a>
					
						<a href="'.Routes::$base.'yonetim/menu-elemani-duzenle/'.$sonuc['menu_eleman_id'].'" onClick="" title="'. __('Edit') .'" class="sortable_silme_tusu hover" style="right:50px;"><img src="'.Routes::$base.'sistem/gorunum/yonetim/tasarim/images/icons/update.png" alt="" /></a>
					
						<a href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['menu_eleman_id'].',\'gnc_yonetim_menu_elemani_sil\',\'list\');" title="'. __('Del') .'" class="sortable_silme_tusu hover"><img src="'.Routes::$base.'sistem/gorunum/yonetim/tasarim/images/icons/delete.png" alt="" /></a>
					</div>';
			
			$this->display($sonuc['menu_id'], $sonuc['menu_eleman_id'], 1);
			
			echo '</li>';
		}
		if ($ic_menu == 1)
			echo '</ol>';	
	}
	*/ 
}
/** Popup class for CMS part
 * 
 */
class _Popup
{
	private static $table = 'popup';
	
	/** Fetchs popup data by session lang 
	 * 
	 * @return array
	 */
	public function popup_by_lang()
	{
		return select(self::$table)->where('lang_id = "'.$_SESSION['lang_id'].'"')->result();	
	}

	public function edit_popup()
	{
		if (isset($_POST['edit'])){
			update(self::$table)->values(array('popup_img'=>$_POST['image'],
											   'popup_img_width'=>$_POST['image_width'],
											   'popup_text'=>$_POST['popup_text'],
											   'popup_href'=>$_POST['popup_href'],
											   'popup_target'=>$_POST['target'],
											   'popup_width'=>$_POST['window_width'],
											   'popup_height'=>$_POST['window_height']))->where('lang_id = "'.$_SESSION['lang_id'].'" ');
			note('Edited successfully');
		}
	}
}
/** Extends Slide Class from core 
 * 
 */
class _Slide extends Slide
{
	private static $table = 'slides';
	
	public function add_slide()
	{
		if (isset($_POST['add_slide'])){
			if (!isset($_POST['slide_href']))
				$_POST['slide_href'] = '';
				
			insert(self::$table)->values(array('lang_id'=>$_POST['lang_id'],
											   'slide_img'=>$_POST['slide_img'], 
											   'slide_title'=>$_POST['slide_title'],
											   'slide_text'=>$_POST['slide_text'],
											   'slide_href'=>$_POST['slide_href'],
											   'slide_target'=>$_POST['slide_target'],
											   'slide_group'=>Routes::$get[1]));
				
			note('Added successfully');
		}	
	}
	/*
	public function display($lang_id)
	{
		$this->slide_group = Routes::$get[1];
		$results = $this->slides_by_lang($lang_id);
		
		echo '	<li id="list_'.$sonuc['slide_id'].'">
					<div>
						<img src="'.$site['resim_yolu'].$sonuc['slide_resmi'].'" width="240" style="margin: 10px;">
						<a href="'. $sonuc['slide_href'] .'" style="display: inline-block; margin-top:10px; position: absolute; width: 900px;"><h4>'. $sonuc['slide_baslik'] .'</h4><p>'. $sonuc['slide_aciklama'] .'</p></a>
						<a href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['slide_id'].',\'gnc_yonetim_slide_sil\',\'list\');" title="'. __('Del') .'" class="sortable_silme_tusu hover"><img src="'.Routes::$base.'sistem/gorunum/yonetim/tasarim/images/icons/delete.png" alt="" /></a>
					</div>
				</li>';
	}
	*/
}
/** Lang class for CMS
 * 
 */
class _Lang
{
	private static $table = 'langs';
	
	/** Fetchs all languages 
	 * 
	 * @return array
	 */
	public function langs()
	{
		return select(self::$table)->results();	
	}	
	/*
	public function add_lang()
	{
		if (isset($_POST['dil_adi']) && isset($_POST['dil_kodu']) && isset($_FILES['dil_dosyasi']))
		{
			$lang_adi  = guvenlik($_POST['dil_adi'] );
			$lang_kodu = guvenlik($_POST['dil_kodu']);
			$_FILES['dil_dosyasi']['name'] = $lang_kodu.'.php';
			
	 		// Tüm upload dosyalarına PHP'nin $_FILES objesinden ulaşışabilir. Örneğimizde, HTML elementimizin name değeri dosya'dır
			$handle = new Upload($_FILES['dil_dosyasi']);
			  
			// Geçici yükleme işlemi tamamlandı mı kontrol edelim
			// Dosyamız geçici yükleme işleminin yapıldığı *temporary* sunucudaki konumda bulunuyor. (Genellikle /tmp klasörüdür.)
			if ($handle->uploaded) { 
				// Yüklenen dosyayı geçici klasöründen bizim konmasını istediğimiz klasöre alalım. Dosya izinlerine dikkat, everyone read&write olmalı!
				// Örneğin $handle->Process('/home/www/veri/');
				$dir_dest = 'sistem/diller/';
				$handle->no_script = false; 	// Php, asp gibi script yüklenmesine izin ver, ciddi risk içerir. Sadece geliştiricinin buraya erişimi olmalı!
				$handle->mime_check = false;	// Dosya yükleme sınıfının izin verdiği bir dosyamı değil mi? Bunun kontrolünü devre dışı bırak.
				$handle->Process($dir_dest);
				$handle->mime_check = true;		// Güvenlik riskinden dolayı, mime kontrol özelliğini aktif et!
			}
			$pdo->query("INSERT INTO gnc_diller
							(dil_adi, dil_kodu)
						VALUES
							('$lang_adi', '$lang_kodu')");
			header("Location:".Routes::$current);
		}		
	}
	*/
}
/** Dynamic Variables Class for CMS
 * 
 */
class _Dynamic_variable
{
	private static $table = 'dynamic_vars';
	private static $table_langs = 'langs';
	
	/** Fetchs all dynamic variables 
	 * 
	 * @return array
	 */
	public function dynamic_variables()
	{
		return select(self::$table)->left(self::$table_langs.' ON '.self::$table_langs.'.lang_id = '.self::$table.'.lang_id')->results();		
	}
	
	/** Fetchs dynamic variables by lang
	 * 
	 * @param int $lang_id
	 * @return array
	 */
	public function dynamic_variables_by_lang($lang_id)
	{
		return select(self::$table)->where('lang_id = "'.$_SESSION['lang_id'].'" ')->results();		
	}
	
	function add_dynamic_variable()
	{
		if (isset($_POST['add_dyn_var'])){
			insert(self::$table)->values(array('lang_id'=>$_POST['lang_id'], 
											   'dynamic_var_key'=>$_POST['dynamic_var_key'],
											   'dynamic_var_value'=>$_POST['dynamic_var_value'],
											   'dynamic_var_type'=>$_POST['dynamic_var_type']));
							
			note('Added successfully');
		}	
	}
	function edit_dynamic_variable()
	{
		if (isset($_POST['edit_dyn_var']))
		{
			$keys = array_keys($_POST);	
			$vals = array_values($_POST);
			
			for ($i=0; $i<count($_POST); $i++){
				update(self::$table)->values(array('dynamic_var_value'=>$vals[$i], ))->where('dynamic_var_id = "'.$keys[$i].'" ');
			}
						
			note('Edited successfully');
		}
	}
}
/** Actions about modules and files as in the MVC structure
 * 
 */
class _Module
{
	private static $table_modules = 'modules';
	private static $table_routes = 'routers';
	private static $table_langs = 'langs';
	
	var $module_id;
	var $router_id;
	
	// Modules
	function _module()
	{
		return select(self::$table_modules)->where('module_id = "'.$this->module_id.'"')->result();	
	}
	function modules()
	{
		return select(self::$table_modules)->results();		
	}
	function add_module()
	{
		global $pdo, $setting;
		
		if (isset($_POST['module_name']))
		{
			// Store module info into database
			insert(self::$table_modules)->values(array('module_parent_folder'=>$_POST['parent_folder'],
											'module_name'=>$_POST['module_name'],
											'module_auth'=>$_POST['module_auth'],
											'module_header'=> '',
											'module_footer'=> '',
											'view_cache'=> $_POST['view_cache'],
											'model_cache'=> $_POST['model_cache'],
											'header_cache'=> $_POST['header_cache'],
											'footer_cache'=> $_POST['footer_cache'],
											'is_visible'=>1,
											'is_erasable'=>1));
									  
			// Create a router by default				
			$module_id = $pdo->insert_id();
			$sef = sef($_POST['module_name']);
			$lang_id = $setting['default_lang_id'];
			
			insert(self::$table_routes)->values(array('lang_id'=>$lang_id,
											'module_id'=>$module_id,
											'router_sef'=>$sef));
			
			// Create files in correct directory
			$newFileName = './'.$_POST['parent_folder'].'/controller/'.$_POST['module_name'].".php";
			$newFileContent = '<?php echo "..."; ?>';
			if(file_put_contents($newFileName, $newFileContent) != false)
			{
			    echo "View file created (".basename($newFileName).")";
			}
			else
			{
			    echo "Can not create controller of module (".basename($newFileName).")";
			}
			$newFileName = './'.$_POST['parent_folder'].'/model/'.$_POST['module_name'].".php";
			$newFileContent = '<?php echo "..."; ?>';
			if(file_put_contents($newFileName, $newFileContent) != false)
			{
			    echo "View file created (".basename($newFileName).")";
			}
			else
			{
			    echo "Can not create model of module (".basename($newFileName).")";
			}
			$newFileName = './'.$_POST['parent_folder'].'/view/'.$_POST['module_name'].".php";
			$newFileContent = '<?php echo "..."; ?>';
			if(file_put_contents($newFileName, $newFileContent) != false)
			{
			    echo "View file created (".basename($newFileName).")";
			}
			else
			{
			    echo "Can not create view of module (".basename($newFileName).")";
			}
											
			note('Added successfully');
		}	
	}
	function edit_module()
	{
		if (isset($_POST['module_auth']))
		{
			update(self::$table_modules)->values(array('module_auth'=> $_POST['module_auth'],
											'module_header'=> $_POST['module_header'],
											'module_footer'=> $_POST['module_footer'],
											'view_cache'=> $_POST['view_cache'],
											'model_cache'=> $_POST['model_cache'],
											'header_cache'=>$_POST['header_cache'] ,
											'footer_cache'=> $_POST['footer_cache'],
											'is_visible'=> $_POST['is_visible'],
											'is_erasable'=> $_POST['is_erasable']))->where('module_id = "'.$this->module_id.'" ');
		
			note('Edited successfully');
		}
	}
	function format_modules_for_select()
	{
		$values = $this->modules();
	
		for ($i=0; $i<count($values); $i++)
		{
			$data[$i]['id'] = $values[$i]['module_id'];
			$data[$i]['value'] = $values[$i]['module_parent_folder'].'/'.$values[$i]['module_name'];	
		}
		return $data;
	}
	// Routers
	function _router()
	{
		return select(self::$table_routes)
				->left(self::$table_modules.' ON '.self::$table_modules.'.module_id = '.self::$table_routes.'.module_id')
				->where(self::$table_routes.'.route_id = "'.$this->route_id.'"')
				->result();		
	}
	function routers()
	{
		return select(self::$table_modules)
				   ->left(self::$table_routes.' ON '.self::$table_routes.'.module_id = '.self::$table_modules.'.module_id')
				   ->left(self::$table_langs.'  ON '.self::$table_langs.'.lang_id = '.self::$table_routes.'.lang_id')
				   ->order(self::$table_routes.'.module_id ASC, '.self::$table_routes.'.lang_id ASC')
				   ->results();	
	}
	function add_router()
	{
		if (isset($_POST['router_name']))
		{
			// Store module info into database
			insert(self::$table_routes)->values(array('lang_id'=>$_POST['lang_id'],
													  'module_id'=>$_POST['module_id'],
													  'router_sef'=>sef($_POST['router_name']),
													  'is_erasable'=>1));
								
			note('Added successfully');
		}	
	}
	// Cache
	function clean_cache_folders()
	{
		global $site;
		
		// Gizli dosyalar dahil cache klasöründeki dosyaları seçelim
		$files = glob('app/cache/{,.}*', GLOB_BRACE);
		
		// Seçili tüm dosyaları tek tek sil
		foreach($files as $file)
		{
			if(is_file($file))
				unlink($file); 
		}
	}
	public function edit_cache_intervals()
	{
		global $pdo;
		
		if (isset($_POST['dosya_gorunum_cache']) || isset($_POST['dosya_model_cache']) || isset($_POST['dosya_header_cache']) || isset($_POST['dosya_footer_cache']))
		{
			$dosya_id = (int)guvenlik($_POST['dosya_id']);	
			$dosya_gorunum_cache = guvenlik($_POST['dosya_gorunum_cache']);	
			$dosya_model_cache 	= guvenlik($_POST['dosya_model_cache']);	
			$dosya_header_cache = guvenlik($_POST['dosya_header_cache']);	
			$dosya_footer_cache = guvenlik($_POST['dosya_footer_cache']);	
			
			
			$pdo->query("UPDATE gnc_moduller SET 
							dosya_gorunum_cache = '$dosya_gorunum_cache', 
							dosya_model_cache = '$dosya_model_cache', 
							dosya_header_cache = '$dosya_header_cache', 
							dosya_footer_cache = '$dosya_footer_cache'
						WHERE dosya_id = '$dosya_id'");
		}
	}
}
/** Extends Blog Class from core 
 * 
 */
class _Blog extends Blog
{
	static $table_content = 'contents';
	static $table_category = 'categories';
	static $table_pattern = 'patterns';
	
	function __construct()
	{
		if (isset($_POST['save_draft']))
			$this->is_public = 0;	
			
		if (isset($_POST['save_content']))
			$this->is_public = 1;	
	}		
	function add_content()
	{
		global $pdo;
				
		if (isset($_POST['content_title']) && isset($_POST['categories']))
		{
			if (!isset($_POST['content_map_lat']))
				$_POST['content_map_lat'] = '';
			
			if (!isset($_POST['content_map_lng']))
				$_POST['content_map_lng'] = '';
				
			if (!isset($_POST['content_img_c']))
				$_POST['content_img_c'] = '';
			
			// Itself
			$pdo->insert(self::$table_content)->values(array(  "lang_id"=>$_POST['lang_id'],
															   "user_id"=>$_SESSION['user_id'],
															   "content_title"=>$_POST['content_title'],
															   "content_sef"=>sef($_POST['content_title']),
															   "content_text"=>$_POST['content_text'],
															   "content_summary"=>$_POST['content_summary'],
															   "content_lat"=>$_POST['content_map_lat'],
															   "content_lng"=>$_POST['content_map_lng'],
															   "content_time"=>$_POST['content_time'],
															   "content_img_c"=>$_POST['content_img_c'],
															   "content_img_t"=>$_POST['content_img_t'],
															   "is_home"=>$_POST['is_home'],
															   "is_public"=>$this->is_public));
			$content_id = $pdo->insert_id();
			
			// Categories
			for ($i=0; $i<count($_POST['categories']); $i++)
				insert('contents_categories')->values(array("content_id"=>$content_id, "category_id"=>$_POST['categories'][$i]));
			
			// Similars
			if (!empty($_POST['similars']))
				for ($i=0; $i<count($_POST['similars']); $i++)
					insert('contents_similars')->values(array("content_id"=>$content_id, "similar_id"=>$_POST['similars'][$i]));
			
			// Pattern -> $_POST['pattern_id']
			if (!empty($_POST['pattern']))
			{
				$pattern_keys = array_keys($_POST['pattern']);
				$pattern_vals = array_values($_POST['pattern']);
				for ($i=0; $i<count($_POST['pattern']); $i++)
				{
					insert('contents_patterns')->values(array("content_id"=>$content_id, "pattern_id"=>$_POST['pattern_id'], "pattern_data_id"=>$pattern_keys[$i], "content_pattern_value"=>$pattern_vals[$i]));	
				}
			}
			
			// Album
			if (!empty($_POST['gallery_id']))
				insert('contents_gallery')->values(array("content_id"=>$content_id, "gallery_id"=>$_POST['gallery_id']));			
			
			note('Added successfully');
		}	
	}
	public function edit_content()
	{
		global $pdo, $setting;
		// Update content
		if (isset($_POST['save_content']) || isset($_POST['save_draft']) || isset($_POST['make_public']))
		{
			if (isset($_POST['save_draft']))
				$is_public = 0;
			else
				$is_public = 1;
			
			if (!isset($_POST['content_img_c']))
				$_POST['content_img_c'] = '';
			
			update('contents')->values(array('lang_id'=>$_POST['lang_id'],
						   'content_title'=>$_POST['content_title'],
						   'content_text'=>$_POST['content_text'],
						   'content_summary'=>$_POST['content_summary'],
						   'content_time'=>$_POST['content_time'],
						   'content_img_c'=>$_POST['content_img_c'],
						   'content_img_t'=>$_POST['content_img_t'],
						   'is_home'=>$_POST['is_home'],
						   'is_public'=>$is_public))->where('content_id = '.$_POST['content_id']);
			
			// Categories
			$pdo->query("DELETE FROM contents_categories WHERE content_id = '{$_POST['content_id']}'");
			for ($i=0; $i<count($_POST['categories']); $i++)
			{
				insert('contents_categories')->values(array("content_id"=>$_POST['content_id'], "category_id"=>$_POST['categories'][$i]));
			}
			
			// Similars
			delete('contents_similars')->where('content_id = '.$_POST['content_id'])->run();
			if (!empty($_POST['similars']))
			{
				for ($i=0; $i<count($_POST['similars']); $i++)
				{
					insert('contents_similars')->values(array("content_id"=>$_POST['content_id'], "similar_id"=>$_POST['similars'][$i]));
				}
			}
			// Pattern
			delete('contents_patterns')->where('content_id = "'.$_POST['content_id'].'"')->run();
			if (!empty($_POST['pattern']))
			{
				$pattern_keys = array_keys($_POST['pattern']);
				$pattern_vals = array_values($_POST['pattern']);
				for ($i=0; $i<count($_POST['pattern']); $i++)
				{
					insert('contents_patterns')->values(array("content_id"=>$_POST['content_id'], "pattern_id"=>$_POST['pattern_id'], "pattern_data_id"=>$pattern_keys[$i], "content_pattern_value"=>$pattern_vals[$i]));	
				}
			}
			// Gallery
			delete('contents_gallery', $_POST['content_id']);
			if (!empty($_POST['gallery_id']))
				insert('contents_gallery')->values(array("content_id"=>$_POST['content_id'], "gallery_id"=>$_POST['gallery_id']));			
			
			// SEO Option
			if ($setting['content_seo_mode'] == 'on')
			{
				update(self::$table_content)->values(array('content_seo_title'=>$_POST['seo_title'],
														   'content_seo_desc'=>$_POST['seo_desc'],
														   'content_seo_author'=>$_POST['seo_author'],
														   'content_seo_keywords'=>$_POST['seo_keywords'],
														   'content_seo_img'=>$_POST['seo_img']))->where('content_id = "'.$_POST['content_id'].'"');
				 
			}
			
			note('Edited successfully');
		}
	}
	function delete_content($id)
	{
		global $pdo;
		
		$query = $pdo->prepare("CALL content_delete(:content_id)");
		$query->bindValue(':content_id', $id, PDO::PARAM_INT);
		$query->execute();
	}
	function add_category()
	{
		if (!empty($_POST['category_name']))
		{
			$category_sef = sef($_POST['category_name']);
					
			insert(self::$table_category)->values(array('category_name'=>$_POST['category_name'], 
														'category_desc'=>$_POST['category_desc'],
														'category_sef'=>$category_sef, 'parent_id'=>$_POST['parent_id'],
														'lang_id'=>$_POST['lang_id']));
			
			note('Added successfully');
		}
	}
	function edit_category()
	{
		global $pdo;
		
		if (!empty($_POST['category_name']))
		{
			$query = $pdo->prepare("UPDATE ".self::$table_category." SET 
							category_name = :category_name,
							category_desc = :category_desc,
							parent_id = :parent_id
							WHERE category_sef = :category_sef");
			
			$query->execute(array('category_name'=>$_POST['category_name'],
								  'category_desc'=>$_POST['category_desc'],
								  'parent_id'=>$_POST['parent_id'],
								  'category_sef'=>Routes::$get[1]));
								  
			note('Edited successfully');
		}
	}
	function add_pattern()
	{
		global $pdo;
		
		if (!empty($_POST['pattern_name']))
		{
			insert(self::$table_pattern)->values(array('pattern_name'=>$_POST['pattern_name']));
			$pattern_id = $pdo->insert_id();
			
			foreach ($_POST['pattern_keys'] AS $key)
				insert(self::$table_pattern.'_data')->values(array('pattern_id'=>$pattern_id, 'pattern_data_key'=>$key));
				
			note('Added successfully');	
		}			
	}
	/*
	function display_categories($kategori_id = 0, $lang_id = 1, $ic_kategori = 0)
	{
		global $lang, $site, $pdo;
			
		// Kategorinin altındaki alt kategorileri ağaç yapısı içinde gösteren fonksiyon
		$sorgu = $pdo->query("SELECT * FROM gnc_kategoriler 
							 LEFT JOIN gnc_diller ON gnc_diller.dil_id = gnc_kategoriler.dil_id
							 WHERE kategori_id_ust = '$kategori_id' AND gnc_diller.dil_id = '$lang_id'
							 ORDER BY gnc_kategoriler.kategori_sira ASC ");
		
		// Drag & Drop ile sıralama için gerekli olan yapı, $ic_kategori ana kategori olmadığını bir parent kategorinin child'ı durumunu ifade etmektedir.
		if ($ic_kategori == 1)
			echo '<ol>';
		while ($sonuc = $pdo->fetch_array($sorgu))
		{
			echo '<li id="list_'.$sonuc['kategori_id'].'">
					<div>
						<span class="disclose"><span></span></span>'. $sonuc['kategori_adi'] .'
						<a href="'.Routes::$base.'yonetim/yeni-icerik/'.$sonuc['kategori_id'].'" title="'.$lang['kategoriye_icerik_ekle'].'" class="sortable_silme_tusu hover" style="margin-right:30px;"><img src="'.Routes::$base.'sistem/gorunum/yonetim/tasarim/images/icons/add.png" alt="" /></a>
						<a href="javascript:void(0);" onClick="gnc_veri_sil('.$sonuc['kategori_id'].',\'gnc_yonetim_kategori_sil\',\'list\');" title="'.$lang['sil'].'" class="sortable_silme_tusu hover"><img src="'.Routes::$base.'sistem/gorunum/yonetim/tasarim/images/icons/delete.png" alt="" /></a>
					</div>';
			gnc_model_kategorileri_agac_yapisinda_goster($sonuc['kategori_id'], $lang_id, 1);
			echo '</li>';
		}
		if ($ic_kategori == 1)
			echo '</ol>';
	
	}
	*/
	function edit_pattern()
	{
		global $pdo;
			
		if (!empty($_POST['pattern_name']))
		{
			// Update pattern
			$query = $pdo->prepare("UPDATE ".self::$table_pattern." 
									SET pattern_name = :pattern_name
									WHERE pattern_id = :pattern_id");
			
			$query->execute(array('pattern_name'=>$_POST['pattern_name'],
								  'pattern_id'=>Routes::$get[1]));
			
			// Update pattern_datas
			$data_ids = array_keys($_POST['pattern_keys']);
			$data_vals = array_values($_POST['pattern_keys']);
			for($i=0; $i<count($_POST['pattern_keys']); $i++)
			{
				
				$query = $pdo->prepare("UPDATE ".self::$table_pattern."_data 
										SET pattern_data_key = :pattern_data_key
										WHERE pattern_data_id = :pattern_data_id");
				
				$query->execute(array('pattern_data_key'=>$data_vals[$i],
								  	  'pattern_data_id'=>$data_ids[$i]));
			}											  
			
			note('Edited successfully');
		}
	}
}
/** Extends Product Class from core 
 * 
 */
class _Product extends Product
{
	function add_product()
	{
		global $pdo, $site;
		
		if (isset($_POST['save_content']))
		{
			if (!isset($_POST['product_map_lat']))
				$_POST['product_map_lat'] = '';
			
			if (!isset($_POST['product_map_lng']))
				$_POST['product_map_lng'] = '';
			
			if (!isset($_POST['expire']))
				$_POST['expire'] = '';
			
			// Add global variables of product
			insert(self::$table_products)->values(array('user_id'=>$_SESSION['user_id'],
														'manufacturer_id'=>$_POST['manufacturer'], 
													    'tax_id'=>$_POST['tax'], 
													    'currency_id'=>$_POST['currency'], 
													    'product_time'=>$site['timestamp'],
													    'product_expire'=>$_POST['expire'],
													    'product_code'=>$_POST['code'],
													    'product_price'=>$_POST['price'], 
													    'product_img_c'=>$_POST['img_c'], 
													    'product_img_t'=>$_POST['img_t'], 
													    'product_video'=>$_POST['video'], 
													    'product_stock_amount'=>$_POST['stock_amount'],
													    'product_l'=>$_POST['length'],
													    'product_w'=>$_POST['width'],
													    'product_h'=>$_POST['height'],
													    'product_weight'=>$_POST['weight'],
													    'product_lat'=>$_POST['product_map_lat'],
													    'product_lng'=>$_POST['product_map_lng'],
														'sale_price'=>$_POST['sale_price'],
														'sale_start'=>$_POST['sale_start'],
														'sale_expire'=>$_POST['sale_expire'],
														'product_seo_title'=>$_POST['seo_title'],
														'product_seo_desc'=>$_POST['seo_desc'],
														'product_seo_author'=>$_POST['seo_author'],
														'product_seo_keywords'=>$_POST['seo_keywords'],
														'product_seo_img'=>$_POST['seo_img'],
														'is_featured'=>$_POST['featured'],
														'is_public'=>$_POST['is_public']));
			
			// Find product_id
			$product_id = $pdo->insert_id();
			
			// Add local variables of product
			foreach(langs() AS $l)
			{
				if (!empty($_POST['product_name'][$l['lang_id']]))
				{
					insert(self::$table_products_locals)->values(array('product_id'=>$product_id,
																	   'lang_id'=>$l['lang_id'],
																	   'product_name'=>$_POST['product_name'][$l['lang_id']],
																	   'product_sef'=>sef($_POST['product_name'][$l['lang_id']]),
																	   'product_text'=>$_POST['product_text'][$l['lang_id']]));
				}
			}

			// Add categories
			for ($i=0; $i<count($_POST['categories']); $i++)
				insert(self::$table_products_categories)->values(array("product_id"=>$product_id, "category_id"=>$_POST['categories'][$i]));
			
			// Similars
			if (!empty($_POST['similars']))
				for ($i=0; $i<count($_POST['similars']); $i++)
					insert(self::$table_products_similars)->values(array("product_id"=>$product_id, "similar_id"=>$_POST['similars'][$i]));
					
			// Add images
			for ($i=0; $i<count($_POST['product_img']); $i++)
				if ($_POST['product_img'][$i])
					insert(self::$table_products_images)->values(array("product_id"=>$product_id, "product_img_path"=>$_POST['product_img'][$i]));
			
			// Features
			if (!empty($_POST['features']))
			{
				foreach ($_POST['features'] AS $feature)
				{
					insert(self::$table_products_prices)->values(array("feature_id"=>$feature,
																	   "product_id"=>$product_id,
																	   "products_feature_price"=>0));	
				}
			}
			// Detailed pricing system
			if (!empty($_POST['pricing_detailed']))
			{
				for ($i=0; $i<count($_POST['pricing_detailed']); $i++)
				{
					insert(self::$table_products_prices)->values(array("product_id"=>$product_id,
																	   "price_start"=>$_POST['pricing_start'][$i],
																	   "price_expire"=>$_POST['pricing_expire'][$i],
																	   "price_price"=>$_POST['pricing_detailed'][$i]));
				}
			}
			
			note('Added successfully');	
		}
	}
	function edit_product()
	{
		global $pdo, $site;
		
		if (isset($_POST['save_content']))
		{
			if (!isset($_POST['product_map_lat']))
				$_POST['product_map_lat'] = '';
			
			if (!isset($_POST['product_map_lng']))
				$_POST['product_map_lng'] = '';
			
			if (!isset($_POST['expire']))
				$_POST['expire'] = '';
			
			// Find product_id
			$product_id = Routes::$get[1];
			
			// Add global variables of product
			update(self::$table_products)->values(array('user_id'=>$_SESSION['user_id'],
														'manufacturer_id'=>$_POST['manufacturer'], 
													    'tax_id'=>$_POST['tax'], 
													    'currency_id'=>1, 
													    'product_time'=>$site['timestamp'],
													    'product_expire'=>$_POST['expire'],
													    'product_code'=>$_POST['code'],
													    'product_price'=>$_POST['price'], 
													    'product_img_c'=>$_POST['img_c'], 
													    'product_img_t'=>$_POST['img_t'], 
													    'product_video'=>$_POST['video'], 
													    'product_stock_amount'=>$_POST['stock_amount'],
													    'product_l'=>$_POST['length'],
													    'product_w'=>$_POST['width'],
													    'product_h'=>$_POST['height'],
													    'product_weight'=>$_POST['weight'],
													    'product_lat'=>$_POST['product_map_lat'],
													    'product_lng'=>$_POST['product_map_lng'],
														'sale_price'=>$_POST['sale_price'],
														'sale_start'=>$_POST['sale_start'],
														'sale_expire'=>$_POST['sale_expire'],
														'product_seo_title'=>$_POST['seo_title'],
														'product_seo_desc'=>$_POST['seo_desc'],
														'product_seo_author'=>$_POST['seo_author'],
														'product_seo_keywords'=>$_POST['seo_keywords'],
														'product_seo_img'=>$_POST['seo_img'],
														'is_featured'=>$_POST['featured'],
														'is_public'=>$_POST['is_public']))->where('product_id = '.$product_id);
														
			
			
			// Add local variables of product
			foreach(langs() AS $l)
			{
				if (!empty($_POST['product_name'][$l['lang_id']]))
				{
					update(self::$table_products_locals)->values(array('lang_id'=>$l['lang_id'],
																	   'product_name'=>$_POST['product_name'][$l['lang_id']],
																	   'product_sef'=>sef($_POST['product_name'][$l['lang_id']]),
																	   'product_text'=>$_POST['product_text'][$l['lang_id']]))
														->where('product_id = "'.$product_id.'" AND lang_id = "'.$l['lang_id'].'"');
				}
			}

			// Add categories
			delete(self::$table_products_categories)->where('product_id = "'.$product_id.'"')->run();
			for ($i=0; $i<count($_POST['categories']); $i++)
				insert(self::$table_products_categories)->values(array("product_id"=>$product_id, "category_id"=>$_POST['categories'][$i]));
			
			// Similars
			delete(self::$table_products_similars)->where('product_id = "'.$product_id.'"')->run();
			if (!empty($_POST['similars']))
				for ($i=0; $i<count($_POST['similars']); $i++)
					insert(self::$table_products_similars)->values(array("product_id"=>$product_id, "similar_id"=>$_POST['similars'][$i]));
					
			// Images
			delete(self::$table_products_images)->where('product_id = "'.$product_id.'"')->run();
			for ($i=0; $i<count($_POST['product_img']); $i++)
				if ($_POST['product_img'][$i])
					insert(self::$table_products_images)->values(array("product_id"=>$product_id, "product_img_path"=>$_POST['product_img'][$i]));
			
			// Features
			delete(self::$table_products_features)->where('product_id = "'.$product_id.'"')->run();
			if (!empty($_POST['features']))
			{
				foreach ($_POST['features'] AS $feature)
				{
					insert(self::$table_products_features)->values(array("feature_id"=>$feature,
																 "product_id"=>$product_id,
																 "products_feature_price"=>0));	
				}
			}
			// Detailed pricing system
			if (!empty($_POST['pricing_detailed']))
			{
				for ($i=0; $i<count($_POST['pricing_detailed']); $i++)
				{
					insert(self::$table_products_prices)->values(array("product_id"=>$product_id,
																	   "price_start"=>$_POST['pricing_start'][$i],
																	   "price_expire"=>$_POST['pricing_expire'][$i],
																	   "price_price"=>$_POST['pricing_detailed'][$i]));
				}
			}
		}
	}	
	function edit_order_address_cargo_details()
	{
		if (isset($_POST['order_cargo_details']))
		{
			update(self::$table_products_orders)->values(array('order_total'=>$_POST['order_total'],
															   'order_shipping_id'=>$_POST['order_shipping_id'],
															   'order_shipping_code'=>$_POST['order_shipping_code']))->where('order_id = '.$_POST['order_id']);	
															   
			note('Edited successfully');
		}	
	}
	function edit_order_address_cargo()
	{
		if (isset($_POST['order_cargo_address']))
		{
			update(self::$table_products_orders)->values(array('order_name'=>$_POST['order_name'],
															   'order_address'=>$_POST['order_address'],
															   'order_city'=>$_POST['order_city'],
															   'order_tel_h'=>$_POST['order_tel_h'],
															   'order_tel_m'=>$_POST['order_tel_m'],
															   'order_fax'=>$_POST['order_fax'],
															   'order_email'=>$_POST['order_email'],
															   'user_note'=>$_POST['user_note'],
															   'order_comment'=>$_POST['order_comment']))->where('order_id = '.$_POST['order_id']);	
															   
			note('Edited successfully');
		}	
	}
	function edit_order_address_invoice()
	{
		if (isset($_POST['order_invoice_address']))
		{
			update(self::$table_products_invoices)->values(array('invoice_name'=>$_POST['invoice_name'],
															   'invoice_address'=>$_POST['invoice_address'],
															   'invoice_city'=>$_POST['invoice_city'],
															   'invoice_tel_h'=>$_POST['invoice_tel_h'],
															   'invoice_tel_m'=>$_POST['invoice_tel_m'],
															   'invoice_fax'=>$_POST['invoice_fax'],
															   'invoice_email'=>$_POST['invoice_email'],
															   'invoice_email_on'=>$_POST['invoice_email_on']))->where('invoice_id = '.$_POST['invoice_id']);	
			note('Edited successfully');
		}
	}
}
/** Extends Payment Class from core 
 * 
 */
class _Payment extends Payment
{
	public function edit_payment()
	{
		if (isset($_POST['payment_min']))
		{
			$values['payment_name'] = $_POST['payment_name'];
				
			$values['payment_min'] = $_POST['payment_min'];
			$values['payment_max'] = $_POST['payment_max'];
			$values['is_public'] = $_POST['is_public'];
			$values['payment_order'] = $_POST['payment_order'];
			
			if (isset($_POST['price']))
				$_POST['payment_price'] = $_POST['price'];
			
			if (isset($_POST['condition']))
				$_POST['payment_condition'] = $_POST['condition'];
			
			update('payments')->values($values)->where('payment_id = '.Routes::$get[1]);
			note('Edited successfully');		
		}									  
	}
}
/** Faq Class for CMS 
 * 
 */
class _Faq
{
	private static $table_faqs  = 'faqs';
	private static $table_langs = 'langs';
	
	function faqs()
	{
		return select(self::$table_faqs)->left(self::$table_langs .' ON '.self::$table_langs.'.lang_id = '.self::$table_faqs.'.lang_id')->results();	
	}
	function faqs_by_lang($lang_id)
	{
		return select(self::$table_faqs)->left(self::$table_langs .' ON '.self::$table_langs.'.lang_id = '.self::$table_faqs.'.lang_id')->where(self::$table_faqs.'.lang_id = "'.$lang_id.'"')->results();	
	}
}
/** Extends Gallery Class from core 
 * 
 */
class _Gallery extends Gallery
{
	static $table_gallery = 'galleries';
	static $table_gallery_data = 'galleries_data';
	
	function add_gallery()
	{
		global $site;
	
		if (isset($_POST['gallery_title']))
		{
			insert(self::$table_gallery)->values(array('user_id'=>$_SESSION['user_id'],
													   'lang_id'=>$_POST['lang_id'],
													   'gallery_title'=>$_POST['gallery_title'],
													   'gallery_sef'=>sef($_POST['gallery_title']),
													   'gallery_text'=>$_POST['gallery_text'],
													   'gallery_time'=>strtotime($_POST['gallery_date']),
													   'gallery_img'=>$_POST['gallery_img'],
													   'gallery_thumb_w'=>$_POST['thumb_w'],
													   'gallery_thumb_h'=>$_POST['thumb_h'],
													   'gallery_crop_w'=>$_POST['crop_w'],
													   'gallery_crop_h'=>$_POST['crop_h'],
													   'gallery_lat'=>$_POST['gallery_lat'],
													   'gallery_lng'=>$_POST['gallery_lng'],));
			note('Added successfully');
		}		
	}	
	function edit_gallery()
	{
		global $pdo, $site;
	
		if (isset($_POST['gallery_title']))
		{
			$query = $pdo->prepare("UPDATE ".self::$table_gallery." SET 
										user_id = :user_id,
										lang_id = :lang_id,
										gallery_title = :gallery_title,
										gallery_text = :gallery_text,
										gallery_img = :gallery_img,
										gallery_time = :gallery_time,
										gallery_thumb_w = :gallery_thumb_w,
										gallery_thumb_h = :gallery_thumb_h,
										gallery_crop_w = :gallery_crop_w,
										gallery_crop_h = :gallery_crop_h
									WHERE gallery_sef = :gallery_sef");
			
			$query->execute(array('user_id'=>$_SESSION['user_id'],
								  'lang_id'=>$_SESSION['lang_id'],
								  'gallery_title'=>$_POST['gallery_title'],
								  'gallery_text'=>$_POST['gallery_text'],
								  'gallery_img'=>$_POST['gallery_img'],
								  'gallery_time'=>$_POST['gallery_date'],
								  'gallery_thumb_w'=>$_POST['thumb_w'],
								  'gallery_thumb_h'=>$_POST['thumb_h'],
								  'gallery_crop_w'=>$_POST['crop_w'],
								  'gallery_crop_h'=>$_POST['crop_h'],
								  'gallery_sef'=>Routes::$get[1]));
								  
			note('Edited successfully');
		}	
	}
	function add_data_to_gallery()
	{
		
		global $site;

		// Is image
		if (isset($_POST['gallery_data_type']) && $_POST['gallery_data_type'] == 1)
		{
			$gallery_id = $this->gallery_sef_to_id(Routes::$get[1]);
			$image = $_POST['gallery_data_image'];
			$text = $_POST['gallery_data_text'];
			
			// Crop işlemi için seçili olan resmin yolunu bulalım
			if (isset($_POST['x']) && !empty($_POST['x']))
			{

				$crop = $site['dir'].$site['image_dir'].$image;

				$x1 = $_POST['x'];
				$y1 = $_POST['y'];
				$x2 = $_POST['x2'];
				$y2 = $_POST['y2'];
				$w  = $_POST['w'];
				$h  = $_POST['h'];
				
				$handle = new Upload($crop);

				if ($handle->uploaded) 
				{
					// Resim kırpma için ilgili değerleri al
					$img_x = $handle->image_src_x; // Resmin genişliği
					$img_y = $handle->image_src_y; // Resmin boyu		
					
					$handle->image_ratio_crop = 'L';
					$handle->image_x = $x1;
					$handle->image_y = $y1;		
					
					$x2 = $img_x - $x2;
					$y2 = $img_y - $y2;
					$handle->image_crop = array($y1, $x2, $y2, $x1); // T R B L
					
					// Yüklenen dosyayı geçici klasöründen bizim konmasını istediğimiz klasöre alalım. Dosya izinlerine dikkat, everyone read&write olmalı!
					$crop_dest = $site['image_dir'].'Crops/';
					$thumb_dest = $site['image_dir'].'Thumbs/';		

					$handle->Process($thumb_dest); 
					$thumb = $handle->file_dst_name;
				}
			}
			else 
			{
				$thumb = $image;
			}
			
			insert(self::$table_gallery_data)->values(array('gallery_id'=>$gallery_id,
															'gallery_data_path'=>$image,
															'gallery_data_path_crop'=>$image,
															'gallery_data_path_thumb'=>$thumb,
															'gallery_data_text'=>$text));
			
			note('Added successfully');
		}	
		elseif (isset($_POST['gallery_vid']))
		{
			$gallery_id = $this->gallery_sef_to_id(Routes::$get[1]);
			$text = $_POST['gallery_video_text'];
			
			insert(self::$table_gallery_data)->values(array('gallery_id'=>$gallery_id,
															'gallery_data_path'=>$_POST['gallery_vid'],
															'gallery_data_text'=>$text,
															'is_video'=>1));
			note('Added successfully');
		}
		
	}
}
/** Subscriber Class for CMS 
 * 
 */
class _Subscriber
{
	private static $table = 'subscribers';
	
	function subscribers()
	{
		return select(self::$table)->results();
	} 	
	function add_subscriber()
	{
		global $pdo;
	
		if (isset($_POST['kullanici_eposta']) && !empty($_POST['kullanici_eposta']))
		{
			$lang_id = guvenlik($_POST['dil_id']);
			$kullanici_adi = guvenlik($_POST['kullanici_adi']);
			$kullanci_eposta = guvenlik($_POST['kullanici_eposta']);
			
			$pdo->query("INSERT INTO gnc_aboneler
							(dil_id, kullanici_adi, kullanici_eposta)
						VALUES
							('$lang_id', '$kullanici_adi', '$kullanci_eposta')");
			unset($_POST);
		}	
	}
	
	function subscribe_email1()
	{
		return select('users')->where('user_email1 = 1')->results();
	}
	function subscribe_email2()
	{
		return select('users')->where('user_email2 = 1')->results();
	}
}
/** Database Backup Class for CMS
 * 
 */
class _Database_backup
{
	public function backups()
	{
		return select('database_backups')->results();
	}
	public function add_backup()
	{
		global $pdo;
		
		ini_set("memory_limit","1024M"); // 1024 MB
		ini_set('max_execution_time', 6000); // 10 minutes
		
		$query = $pdo->query('SHOW TABLES');
		$results = $query->fetch_array();
		$tablolar = array();
		foreach ($results AS $result)
		{
			$tables[] = reset($result);
		}
		
		$return = '';
		// Tablolar için sırayla yedeği oluştur
		foreach($tables AS $table)
		{
			$rows = select($table)->results();

			$return.= 'DROP TABLE IF EXISTS '.$table.';';
			
			$query = $pdo->query('SHOW CREATE TABLE '.$table);
			$create = $query->fetch();

			$return.= "\n\n".$create['Create Table'].";\n\n";
			
			for ($i = 0; $i < count($rows); $i++) 
			{
				for ($j = 0; $j < count($rows); $j++) 
				{				
					$return.= 'INSERT INTO '.$table.' VALUES(';
					
					$colums = array_keys($rows[$j]);
					$values = array_values($rows[$j]);
					
					for ($k = 0; $k < count($values); $k++)
					{
						$return .= '"'.$values[$k].'"';
						
						if ($k < (count($values)-1))
							$return .= ', ';
					}
					$return.= ");\n";
				}
			}
			$return.="\n\n\n";
		}
		// Dosyayı ana dizine yedekle
		$file_name = 'db-backup-'.time().'-'.(md5(implode(',',$tablolar))).'.sql';
		$file = fopen($file_name,'w+');
		fwrite($file,$return);
		fclose($file);
		
		insert('database_backups')->values(array('database_backup_path'=> $file_name,
												 'database_backup_time'=> time()));
												 
		note('Added successfully');
	}
}
/** Data Class for CMS
 * You can find some ready datasets in database such as country names, city names etc...
 * They're especially for Turkish debelopers but anydeveloper can easly change it for specific usage.
 * 
 */
class _Data
{
	/** Country id
	 * 
	 * @var int - use 7 for Turkey
	 */
	var $country_id = false;
	
	/** Region id
	 * 
	 * @var int
	 */
	var $region_id = false;
	
	/** City id
	 * 
	 * @var int
	 */
	var $city_id = false;
	
	/** Continents
	 * 
	 * @return array
	 */
	public function continents()
	{
		return select('data_continents')->order('continent_name ASC')->results();
	}
	/** Countries
	 * 
	 * @return array
	 */	
	public function countries()
	{
		if ($this->country_id)
			return select('data_countries')->where('country_id = '.$this->country_id)->limit(1)->result();
		
		return select('data_countries')->order('country_name ASC')->results();
	}	
	/** Regions
	 * 
	 * @return array
	 */	
	public function regions()
	{
		if ($this->country_id)
			return select('data_regions')->where('region_id = '.$this->region_id)->limit(1)->result();
		
		return select('data_regions')->order('region_name ASC')->results();
	}	
	/** Regoion id of selected city
	 * 
	 * @return int
	 */	
	public function region_of_city()
	{
		$city = $this->cities();
		return $city['region_id'];
	}
	/** Cities
	 * 
	 * @return array
	 */	
	public function cities()
	{
		if ($this->city_id)
			return select('data_cities')->where('city_id = '.$this->city_id)->limit(1)->result();
		
		return select('data_cities')->order('city_name ASC')->results();
	}	
	
}
/** Writes note box 
 *
 * @param string $text
 * @return string  
 */
function note($text)
{
	echo '	<div class="nNote nInformation">
				<p>'.__($text).'</p>
			</div>';
}

/** Dynamic forms
 * 
 * The main purpose of this class is to make automatic actions for any row in any database table
 */
class Dynamic_forms
{
	/** Table name which is stored in dynamic_tables table
     *
     * @access public
     * @var string
     */
	var $table;
	
	// First column name, will be calculated in class
	var $index = false;

	/** Id of the selected table
     *
     * @access public
     * @var int
     */
	var $id;
	
	/** Data in the table
     *
     * @access public
     * @var array
     */
	var $data;
	
	/** Stored rules for table
     *
     * @access public
     * @var json
     */
	var $rule;
	
	/** Stored column names for table
     *
     * @access public
     * @var string
     */
	var $th;
	
	/** Stored column names to match with th
	 * 
     * @access public
     * @var string
     */
	var $td;
	
	/** Warning message
     *
     * @access public
     * @var string
     */
	var $warning = false;
	
	/** Title to display in sortable table and other forms
     *
     * @access public
     * @var string
     */
	var $title;
	
	/** Prefix of columns in table
     * This variable is really very important! It defines not only prefix of columns but also function of single data
	 * Editor or Developer can write it when storing rules
	 * 
     * @access public
     * @var string
     */
	var $prefix;
	
	/** Prefix to add the link of details button
	 * 
     * @access public
     * @var booleon
     */
	var $link = false;
	
	/** Every data will be listed in sortable table and table has a search option
	 * by default it's open and users no need to click on the icon at the right corner
	 * but if developer wants to close it, can use this option
	 * 
     * @access public
     * @var booleon
     */
	var $search_is_open = true;
	
	var $details = true;	
	
	/** Fetch contents for data listing 
	 * 
	 * @return contents from database 
	 */
	function content()
	{
		return select(Routes::$get[1])->results();
	}
	/** Get rules from database for selected table 
	 * 
	 * @return dynamic rules 
	 */
	function rules()
	{
		return select('dynamic_tables')->where('dynamic_table_name = "'.Routes::$get[1].'"')->limit(1)->result();	
	}
	function edit_data_rule()
	{
		if (!empty($_POST['edit_data_rule']))	
		{
			// convert column_type and column_data source to json
			$i = 0;
			foreach ($_POST['name'] AS $name)
			{
				if ($_POST['type_'.$name])
				{
					$array[$i]['name'] = $name;
					$array[$i]['type'] = $_POST['type_'.$name];
					$array[$i]['data'] = $_POST['data_'.$name];
					$array[$i]['note'] = $_POST['note_'.$name];
					
					$i++;
				}				
			}
			$rule = json_encode($array);
			
			// details button 
			if (isset($_POST['is_details_button'])){
				$is_details_button = 1;
			} else {
				$is_details_button = 0;	
			}
			
			// additional button values
			if (!empty($_POST['additional_button_name'])){
				$button['button_name'] = $_POST['additional_button_name'];
				if (isset($_POST['additional_button_external']))
					$button['is_external'] = 1;
				else
					$button['is_external'] = 0;
				$button['button_href'] = $_POST['additional_button_href'];
				$button['button_event'] = $_POST['additional_button_event'];
			}
			$additional_button = json_encode($button);
			
			//print_r($_POST);
			
			// update related row of dynamic_tables
			delete('dynamic_tables')->where('dynamic_table_name = "'.$_POST['table'].'"')->run();
			insert('dynamic_tables')->values(array('dynamic_table_name'=>$_POST['table'],
												   'dynamic_table_title'=>$_POST['dynamic_table_title'],
												   'dynamic_table_prefix'=>$_POST['dynamic_table_prefix'],
												   'dynamic_table_image'=>$_POST['dynamic_table_image'],
												   'dynamic_table_th'=>$_POST['dynamic_table_th'],
												   'dynamic_table_td'=>$_POST['dynamic_table_td'],
												   'is_inmenu'=>$_POST['is_inmenu'],
												   'is_public'=>$_POST['is_public'],
												   'dynamic_table_rules'=>$rule,
												   'is_details_button'=>$is_details_button,
												   'dynamic_table_additional_buttons'=>$additional_button));
			
			note('Edited successfully');
			
			header('Location: '.Routes::$base.'admin/dynamic-table/'.last_id());
		}
			
	}
	
	function add_data()
	{
		if (count($_POST) > 2)
		{
			insert(Routes::$get[1])->values($_POST);
		
			note('Added successfully');
		}
		unset($_POST);
	}
	
	function edit_data()
	{
		if (count($_POST) > 2)
		{
			update(Routes::$get[1])->values($_POST)->where(Routes::$get[2].' = '.Routes::$get[3]);
		
			note('Edited successfully');
		}
		unset($_POST);	
	}

	/** It shows a single row from database as mentions in the rule with it's update feature
     *
     * @access public
     * @var string
     */
	function data_row()
	{
		global $setting;
		
		$rules = select('dynamic_tables')->where('dynamic_table_name = "'.$this->table.'"')->limit(1)->result('dynamic_table_rules');	
		$rules = json_decode($rules, true);
		
		$results = find($this->table, $this->id);
		
		// If class has a warning show it
		$this->show_warning();	
		
		echo '	<div class="wrapper">    
				    <div class="fluid">
				    	<div class="widget grid12">
				    		<div class="whead">
								<h6>'.ucfirst(__($this->title)).'</h6>
								<div class="clear"></div>
						  	</div>
						  	<div class="body">
							  	<form class="main" method="post" action="'. Routes::$current .'">
									<fieldset>';
										foreach ($rules AS $rule)
										{
											// If data of input class is feeding from a function
											if (function_exists($rule['data']))
												$rule['data'] = $rule['data']();
											
											$data = $results[$rule['name']];
											// Check column name to toggle language selector. If multi lang option is off, no need to show selector here
											if ($rule['name'] == 'lang_id')
											{
												if ($setting['multi_lang'])
													echo Input::$rule['type']($rule['name'], $rule['data'], $data);
											}
											else 
											{
												if ($rule['type'] == 'select')
													echo Input::$rule['type']($rule['name'], $rule['data'], $data);
												else
													echo Input::$rule['type']($rule['name'], $data);	
											}	
										}
										echo '
										<div class="formRow">
									    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
							            	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Edit') .'">
										</div>
									</fieldset>
								</form>
							</div>
						</div>
					</div>
				</div>';
	}
	/** It generates the form to add a single row from database as mentions in the rule
     *
     * @access public
     * @var string
     */
	function data_new()
	{
		global $setting;
		
		$rules = select('dynamic_tables')->where('dynamic_table_name = "'.$this->table.'"')->limit(1)->result('dynamic_table_rules');	
		$rules = json_decode($rules, true);
		
		// If class has a warning show it
		$this->show_warning();	
		
		echo '	<div class="wrapper">    
				    <div class="fluid">
				    	<div class="widget grid12">
				    		<div class="whead">
								<h6>'.__($this->title).'</h6>
								<div class="clear"></div>
						  	</div>
						  	<div class="body">
							  	<form class="main" method="post" action="'. Routes::$current .'">
									<fieldset>';
										foreach ($rules AS $rule)
										{
											// If data of input class is feeding from a function
											if (function_exists($rule['data']))
												$rule['data'] = $rule['data']();
											
											// Check column name to toggle language selector. If multi lang option is off, no need to show selector here
											if ($rule['name'] == 'lang_id')
											{
												if ($setting['multi_lang'])
													echo Input::$rule['type']($rule['name'], $rule['data']);
											}
											else 
											{
												if ($rule['type'] == 'select')
													echo Input::$rule['type']($rule['name'], $rule['data']);
												else
													echo Input::$rule['type']($rule['name']);	
											}	
										}
										echo '
										<div class="formRow">
									    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
							            	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Add') .'">
										</div>
									</fieldset>
								</form>
							</div>
						</div>
					</div>
				</div>';
	}
	/** It shows every rows from database as mentions in the rule
	 * Rows will be listed in a sortable and filterable table
	 * User can delete a row or show the details of a selected row
     *
     * @access public
     * @var string
     */
	function data_list()
	{
		// Set index from dara
		$keys = @array_keys($this->data[0]);
		$this->index = $keys[0];
			
		// If class has a warning show it
		$this->show_warning();
		
		// Show the content in proper way		
		echo '	<div class="wrapper">    
				    <div class="fluid">
				    	<div class="widget grid12">
				    		<div class="whead">
				    			<h6>'.__($this->title).'</h6>
				    			<div class="clear"></div>
				    		</div>';
							
							if ($this->search_is_open)
							{
								echo '	<div id="dyn" class="shownpars">
				                			<a class="tOptions act" title="Options"><img src="'.Routes::$base.'cms/design/images/icons/options.png" alt="" /></a>';
							}
							else 
							{
								echo '	<div id="dyn" class="hiddenpars">
				                			<a class="tOptions" title="Options"><img src="'.Routes::$base.'cms/design/images/icons/options.png" alt="" /></a>';
							}
				            echo '
				                <table cellpadding="0" cellspacing="0" border="0" class="dinamik_tablo" id="dynamic">
					                <thead>
						                <tr>';
						                	foreach ($this->th AS $th)
												echo	'<th>'. __($th) .'</th>';
							                
											echo '
							                <th>'. __('Actions') .' </th>
						                </tr>
					                </thead>
					                <tbody>';
									
										foreach ($this->data AS $result)
										{
											echo '	<tr class="gradeX" id="row_'.$result[$this->index].'">';
														
														foreach ($this->td AS $td)
														{
															if ($td == 'is_public' || $td == 'not_public')
															{
																if ($result[$td] > 0)
																	$result[$td] = __('is_public');
																else
																	$result[$td] = __('not_public');
															}	

															echo	'<td>'. __($result[$td]) .'</td>';
														}
															
														
														echo '
														<td class="center">';
															$this->show_details_button($result);
															$this->show_additional_button($result);
															$this->show_delete_button($result);
														echo '
									                   	</td>
													</tr>';
										}
							            echo '
						            </tbody>
				                </table> 
				            </div>
				            <div class="clear"></div> 
						</div>
					</div>
				</div>
			</div>';
	}
	/** It shows details button
     *
     * @access public
     * @var string
     */
	function show_details_button($result)
	{
		if ($this->rule['is_details_button']){
			if ($this->details){
				if ($this->link)
					$link = $this->link;
				else
					$link = $this->index;
				
				echo '<a href="'.Routes::$base.'admin/'. $this->link .'/'. $result[$this->index] .'" class="buttonM bDefault ml10">'. __('Details') .'</a>';
			}	
		}
	}
	/** It shows an additional button between details and delete buttons
     *
     * @access public
     * @var string
     */
	function show_additional_button($result)
	{
		$button = json_decode($this->rule['dynamic_table_additional_buttons'], true);
		
		if (!$button['is_external'])
			$button['button_href'] = str_replace('#', $result[$this->index], Routes::$base.$button['button_href']);
		
		if (!empty($button['button_event']))
			$button['button_href'] = 'javascript:void(0)';
		
		if (isset($button['button_name']))
			echo '<a href="'. $button['button_href'] .'" '.str_replace('#', $result[$this->index], $button['button_event']).' class="buttonM bDefault ml10">'. __($button['button_name']) .'</a>';
	}
	/** It shows the delete buttons for each row
     *
     * @access public
     * @var string
     */
	function show_delete_button($result)
	{
		echo '	<a href="javascript:void(0);" onClick="delete_from_database(\''.$this->table.'\', '.$result[$this->index].', \'row\');" class="buttonM bRed ml10" style="color:#fff">'. __('Del') .'</a>';
									                   	
	}
	/** It shows a warning message
     *
     * @access public
     * @var string
     */
	function show_warning()
	{
		// If class has a warning show it
		if ($this->warning)
		{
			echo '	<!-- Main content -->
					<div class="wrapper">  
						<div class="fluid">
					    	<div class="grid12">
						    	<div class="nNote nSuccess">
									<p>'.__($this->warning) .'</p>
								</div>
							</div>
						</div> 
					</div>';
		}		
	}
}



