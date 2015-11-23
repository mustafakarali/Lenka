<?php
/** Gallery Class
 * 
 * @category 	Core
 * @version		0.1.0
 */
class Gallery
{
	/** Gallery id or gallery sef. If it's gallery_id, method changes it to the sef, so it doesn't matter for the method.
	 * But using gallery_sef is better for the app performance
	 *
	 * @access public
	 * @var int/string
	 */
	var $gallery;
	
	/** Name of gallery
	 *
	 * @access public
	 * @var string
	 */
	var $name;
	
	/** Text, definition of gallery
	 *
	 * @access public
	 * @var string
	 */
	var $text;	
	
	/** Img of gallery
	 * 
     * @access public
     * @var string
	 */
	var $img;
	
	/** Creation date of gallery
	 * 
     * @access public
     * @var timespan
	 */
	var $time;
	/** Gallery format
	 * 
     * @access public
     * @var bool
	 */
	var $gallery_format = true;
	
	/** How long will title and text seen
	 * 
     * @access public
     * @var int
	 */
	var $short_title;
	var $short_text;
	
	public static $no_pic = 'core/img/no-pic.png';
	
	public static $table_gallery = 'galleries';
	public static $table_data = 'galleries_data';

	/** Selected gallery
	 * 
	 * @param int 
	 * @return array
	 */
	function gallery($gallery = '')
	{
		if (is_numeric($gallery))
			$gallery = $this->gallery_id_to_sef($gallery);
		
		return $this->format(select(self::$table_gallery)->where('gallery_sef = "'.$gallery.'" ')->result());
	}
	/** All galleries
	 * 
	 * @return array
	 */
	function galleries()
	{
		$galleries = select(self::$table_gallery)->order('gallery_order ASC')->results();
		foreach ($galleries AS $g)
		{
			$gallery[] = $this->format($g);
		}
		return $gallery;
	}	
	/** All galleries with language filter
	 * 
	 * @return array
	 */
	function galleries_by_lang($lang_id)
	{
		$galleries = select(self::$table_gallery)->where('lang_id = "'.$lang_id.'"')->results();
		foreach ($galleries AS $g)
		{
			$gallery[] = $this->format($g);
		}
		return $gallery;
	}	
	/** Data of selected gallery
	 * 
	 * @return array
	 */
	function gallery_data()
	{
		return select(self::$table_data)->where('gallery_id = "'.$this->gallery.'"')->results();		
	}
	/** Format the gallery
	 * 
	 * Set date, image paths, title, user authentication and shorten strings
	 */
	protected function format($result)
	{
		global $setting, $site;
		
		$this->gallery = $result['gallery_id'];
			
		if ($this->gallery_format)
		{
			// Format the date
			$result['gallery_date'] = date($setting['date_format'], $result['gallery_time']);		
			
			// Images
			$result = self::images($result);	
	
			if (!empty($this->short_title))
				$result['gallery_title'] = shorten($result['gallery_title'], $this->short_title);
			
			if (!empty($this->short_summary))
				$result['gallery_text'] = shorten($result['gallery_text'], $this->short_summary);
			
			$result['gallery_pics'] = $this->gallery_data();
			if (!empty($result['gallery_pics'][0]['gallery_data_id']))
				$result['gallert_pic_count'] = count($result['gallery_pics']);
			else
				$result['gallert_pic_count'] = 0;
			
			if (@$result['is_public'])
				$result['gallery_public'] = '<a href="javascript:void(0)" onClick="update_value(\'galleries\', \'is_public\', '.$this->gallery.', 0, \'refresh\');" class="hover" style="position:absolute;"><img src="'.Routes::$base.'cms/design/images/icons/unlocked.png"/></a>';
			else
				$result['gallery_public'] = '<a href="javascript:void(0)" onClick="update_value(\'galleries\', \'is_public\', '.$this->gallery.', 1, \'refresh\');" class="hover" style="position:absolute;"><img src="'.Routes::$base.'cms/design/images/icons/locked.png"/></a>';
					
		}
		return $result;	
	}
	/** Format galleries for select
	 * 
	 * @return array
	 */
	public function format_galleries_for_select($galleries)
	{
		for ($i=0; $i<count($galleries); $i++)
		{
			$data[$i]['id'] = $galleries[$i]['gallery_id'];
			$data[$i]['value'] = $galleries[$i]['gallery_title'];	
		}
		return $data;
	}
	/** Set image path of gallery items
	 * 
	 * @param string
	 * @return string
	 */
	public static function images($result)
	{
		global $site;
		
		// Küçük resmin yolunu belirle, içeriği tanımlamak için bu tip bir resim olmalı
		if (!empty($result['gallery_img']))
			$result['gallery_img'] = $site['image_path'].$result['gallery_img'];
		else
			$result['gallery_img'] = $site['url'].self::$no_pic;
		
		return $result;
	}
	
	/** Content id to sef
	 * 
	 * @param int
	 * @return string
	 */
	public final function gallery_id_to_sef($id)
	{
		return select(self::$table_gallery)->where('gallery_id = "'.$id.'"')->limit(1)->result('gallery_sef');	
	}
	/** Content sef to id
	 * 
	 * @param string
	 * @return int
	 */
	public final function gallery_sef_to_id($sef)
	{
		return select(self::$table_gallery)->where('gallery_sef = "'.$sef.'"')->limit(1)->result('gallery_id');	
	}
	/** Lang of gallery
	 * 
	 * @return int
	 */
	public final function gallery_lang()
	{
		if (is_numeric($this->$gallery))
			$this->$gallery = $this->gallery_id_to_sef($this->$gallery);
		
		return select(self::$table_gallery)->where('gallery_sef = "'.$this->$gallery.'" ')->limit(1)->result('lang_id');	
	}
}