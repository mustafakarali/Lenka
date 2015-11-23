<?php
/** Menu Class
 * 
 * @category 	Core
 * @version		0.1.0
 */
class Menu
{
	private static $table = 'menus';
	
	public function menus()
	{
		return select(self::$table)->results();	
	}
	public function menus_by_lang($lang_id = 1)
	{
		return select(self::$table)->where('lang_id = "'.$lang_id.'" ')->results();	
	}
	public function display()
	{
		
	}
}
