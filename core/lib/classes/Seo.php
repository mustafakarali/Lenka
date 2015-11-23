<?php
/** Seo Class
 * 
 * @category 	Core
 * @version		0.1.0
 * 
 */
class Seo
{
	static $value;
	static $title;
	
	/** Possible metatag options
	 * 
	 * @var string
	 */
	static $name;
	static $desc;
	static $keys;
	static $author;
	static $img;
	static $video;
	
	/** Generates Title Meta, if not defined generates it from URL
	 * 
	 * @return string
	 */	
	public static function title()
	{
		if (!empty(self::$value))
			return self::$value;
		
		if (!empty(self::$title))
			return self::$title;	
		
		if (!empty(Routes::$func))
			return ucfirst(str_replace('-', ' ', Routes::$func));
		elseif (!empty(Routes::$module))
			return ucfirst(str_replace('-', ' ', Routes::$module));
		else
			return strip_tags(self::$name);
	}	
	/** Desctiption tag
	 * 
	 * @return string
	 */	
	public static function description()
	{
		return strip_tags(self::$desc);
	}
	/** Keywords tag
	 * 
	 * @return string
	 */	
	public static function keywords()
	{
		return strip_tags(self::$keys);
	}
	/** Author tag
	 * 
	 * @return string
	 */	
	public static function author()
	{
		return strip_tags(self::$author);
	}
	/** Image tag
	 * 
	 * @return string
	 */	
	public static function image()
	{
		return strip_tags(self::$img);
	}
	/** Video tag
	 * 
	 * @return string
	 */	
	public static function video()
	{
		return strip_tags(self::$video);
	}
}