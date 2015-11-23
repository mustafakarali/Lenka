<?php
/** Slide Class
 * 
 * @category 	Core
 * @version		0.1.0
 */
class Slide
{
	private static $table = 'slides';
	
	var $slide_group = 1;
	
	public function slides_by_lang($lang_id)
	{
		return select(self::$table)->where('lang_id = "'.$lang_id.'" AND slide_group = "'.$slide_group.'"')->order('slide_order ASC')->results();
	}
}
