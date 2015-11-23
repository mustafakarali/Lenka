<?php
/** Blog Class
 * 
 * @category 	Core
 * @version		0.1.0
 */
class Blog
{
	/** Content id or content sef. If it's content_id, method changes it to the sef, so it doesn't matter for the method.
	 * But using content_sef is better for the performance
	 *
	 * @access public
	 * @var int/string
	 */
	var $content;
	var $content_id;
	
	/** Category id or category sef. If it's category_id, method changes it to the sef, so it doesn't matter for the method.
	 * But using category_sef is better for the performance
	 *
	 * @access public
	 * @var int/string
	 */
	var $category;	
	var $category_id;
	var $parent_id = 0;
	
	/** Turn this true to display cateogry name with parent category name
	 * 
	 * @access public
	 * @var boolean
	 */
	var $category_display_with_parent_name = false;
	
	/** To group categories use group_id
	 *
	 * @access public
	 * @var int
	 */
	var $group_id;
	
	/** Pattern id
	 *
	 * @access public
	 * @var int
	 */
	var $pattern_id;	
	
	/** Language id
	 *
	 * @access public
	 * @var int
	 */
	var $lang_id;	
	
	/** Condition to add to the end of the contents query
	 * 
     * @access public
     * @var string
	 */
	var $condition;
	
	/** Is content public or private
	 * 
     * @access public
     * @var booleon
	 */
	var $is_public = '>= 0';
	
	/** Author of content
	 * 
	 * @access public
	 * @var int
	 */
	var $author;
	 
	/** Is user authenticated to edit
	 * 
     * @access public
     * @var booleon
	 */
	var $is_auth;
	
	/** How long will title and summary seen
	 * 
     * @access public
     * @var int
	 */
	var $short_title;
	var $short_summary;
	
	/** Content format
	 * 
     * @access public
     * @var bool
	 */
	var $content_format = true;
	
	/** Limit the query
	 * 
     * @access public
     * @var int
	 */
	var $limit = 3000;
	
	/** Show if img value isempty
	 * 
     * @access public
     * @var string
	 */
	public static $no_pic = 'core/img/no-pic.png';
	
	public static $table_content = 'contents';
	public static $table_category = 'categories';
	public static $table_pattern = 'patterns';
	public static $table_user = 'users';
	
	/** Show special categories or not
	 * 
     * @access public
     * @var int
	 */
	var $special_categories = 'is_special = 0';
	
	function __construct()
	{
		// Get sef of content from id
		if (is_numeric($this->content))
		{
			
			$this->content_id = $this->content;
			$this->content = $this->content_id_to_sef($this->content);
		}	
		else
		{
			$this->content_id = $this->category_sef_to_id($this->content);
		}
		
		// Get sef of category from id
		if (is_numeric($this->category))
		{
			$this->category_id = $this->category;
			$this->category = $this->category_id_to_sef($this->category);
		}
		else
		{
			$this->category_id = $this->category_sef_to_id($this->category);
		}
	}
	// Asked cantent
	function content()
	{
		$content = select('contents')
					->which('*, contents.content_id AS content_id, contents.lang_id AS lang_id')
					->left('contents_categories')->using('content_id')
					->left('categories')->using('category_id')
					->left('users')->using('user_id')
					->where('contents.content_sef = "'.$this->content.'" OR contents.content_id = "'.$this->content_id.'" ')
					->limit(1)->result();
		
		$this->parent_id = $content['parent_id'];
		
		return $this->format_content($content);			
	}
	// Every contents in asked category
	function contents()
	{
		global $pdo;
		
		if (is_numeric($this->category))
			$this->category = $this->category_id_to_sef($this->category);
			
		$query  = "SELECT *, contents.lang_id AS lang_id FROM contents_categories
				   LEFT JOIN categories ON categories.category_id = contents_categories.category_id  
				   LEFT JOIN contents ON contents.content_id = contents_categories.content_id 
				   LEFT JOIN users ON users.user_id = contents.user_id 
				   LEFT JOIN langs ON langs.lang_id = contents.lang_id 
				   WHERE contents.is_public ".$this->is_public." ";
	   
		if (!empty($this->category) || !empty($this->category_id))
			$query .= " AND (categories.category_sef = '$this->category' OR categories.category_id = '$this->category_id') ";
			
		$query .= " GROUP BY contents.content_id ";

		// Add condition string at the end of query
		if (!empty($this->condition) && !is_numeric($this->condition))
			$query .= $this->condition;
		elseif (!empty($this->condition) && is_numeric($this->condition))
			$query .= " ORDER BY contents.content_order ASC, contents.content_time DESC ";
		else
			$query .= " ORDER BY contents.content_order ASC, contents.content_title ASC ";
		
		// Add limit condition to the query
		if (!empty($this->limit))	
			$query .= " LIMIT ".$this->limit;
		 
		$query = $pdo->query($query);
		$results = $query->fetch_array();
		
		foreach ($results AS $res)
			$result[] = $this->format_content($res);	
		
		return @$result;
	}	
	function contents_by_author()
	{
		$results = select('contents')
					->which('*, contents.content_id AS content_id, contents.lang_id AS lang_id')
					->left('contents_categories')->using('content_id')
					->left('categories')->using('category_id')
					->where('contents.user_id = '.$this->author.' AND contents.is_public '.$this->is_public)->limit($this->limit)->results();
		
		foreach ($results AS $res)
			$result[] = $this->format_content($res);	
		
		return @$result;	
	}
	function category()
	{
		return select(self::$table_category)->where('category_sef = "'.$this->category.'" OR category_id = "'.$this->category.'"')->limit(1)->result();
	}
	function parent_categories($category_id, $i = 0, $result = '')
	{
		if ($category_id) 
		{
			$result[$i] = select(self::$table_category)->where('category_id = "'.$category_id.'"')->limit(1)->result();
			$parent_id = $result[$i]['parent_id'];
		
			$this->parent_categories($parent_id, $i+1, $result);			
		}
		return array_reverse($result);
	}
	function child_categories($category_id)
	{
		return select(self::$table_category)->where('parent_id = "'.$category_id.'"')->results();
	}
	function sibling_categories($category_id = 0, $i = 0, $categories = '')
	{
		$categories = $this->child_categories($category_id);
		
		if (!empty($categories))
		{
			$i = 0;
			foreach ($categories AS $category)
			{
				$c[] = $category;
				
				// 1st sub categories
				$sub_categories = $this->child_categories($category['category_id']);
				if (!empty($sub_categories))
				{
					foreach ($sub_categories AS $cat)
					{
						$c[] = $cat;
						
						// 2nd sub categories
						$sub_categories2 = $this->child_categories($cat['category_id']);
						if (!empty($sub_categories2))
						{
							foreach ($sub_categories2 AS $cat2)
							{
								$c[] = $cat2;
								
								// 3rd sub categories
								$sub_categories3 = $this->child_categories($cat2['category_id']);
								if (!empty($sub_categories3))
								{
									foreach ($sub_categories3 AS $cat3)
									{
										$c[] = $cat3;
									}
								}
							}
						}
					}
					$i++;
				}
			}
		}
		
		/* Format categories */
		foreach ($c AS $res) 
			$result[] = $this->format_category($res);

		/* Return result */
		if (isset($result))
			return $result;
	}
	// Find the categories of given content
	public function categories()
	{
		// If category is not empty return sub categories
		if (!empty($this->category))
			return $this->sub_categories(); 
		
		// Content is empty so gather all categories
		if (empty($this->content_id))
		{
			$results = select(self::$table_category)->left('langs ON langs.lang_id = categories.lang_id')->where($this->special_categories)->results();
			
			foreach ($results AS $res) 
				$result[] = $this->format_category($res);
			
			return $result;
		}
		else 
		{
			return select('contents_cateogries')
					->left('categories ON categories.category_id = contents_cateogries.category_id')
					->where('contents_cateogries.content_id = "'.$this->content_id.'"')
					->results();
		}	
	}
	public function sub_categories($category_id = 0)
	{
		if ($category_id)
			$this->category_id = $category_id;
		
		$results = select(self::$table_category)->left('langs ON langs.lang_id = categories.lang_id')->where('parent_id = '.$this->category_id)->results();
		
		foreach ($results AS $res) 
			$result[] = $this->format_category($res);
		
		if (isset($result))
			return $result;
	}
	public function categories_by_lang()
	{
		$results = select(self::$table_category)->where('lang_id = "'.$this->lang_id.'"')->results();		
		
		foreach ($results AS $res) 
			$result[] = $this->format_category($res);
		
		if (isset($result))
			return $result;
	}
	public function categories_by_group()
	{
		return select(self::$table_category)->where('category_group = "'.$this->group_id.'"')->results();		
	}
	
	public function categories_of_content()
	{
		return select('contents_categories')
				->left(self::$table_category.' ON '.self::$table_category.'.category_id = contents_categories.category_id')
				->where('contents_categories.content_id = "'.$this->content_id.'" ')->results();
	}
	// Asked pattern
	function pattern()
	{
		return select(self::$table_pattern)->left(self::$table_pattern.'_data ON '.self::$table_pattern.'_data.pattern_id = '.self::$table_pattern.'.pattern_id')->where(self::$table_pattern.'.pattern_id = "'.$this->pattern_id.'" ')->results();	
	}
	// Find every patterns in the database
	function patterns()
	{
		return select(self::$table_pattern)->results();		
	}
	function patterns_by_lang()
	{
		return select(self::$table_pattern)->where('lang_id = "'.$this->lang_id.'"')->results();	
	}
	function pattern_of_content()
	{
		return select('contents_patterns')->left('patterns_data ON patterns_data.pattern_data_id = contents_patterns.pattern_data_id')->where('contents_patterns.content_id = "'.$this->content_id.'"')->results();	
	}
	function authors()
	{
		return format_authors_for_select(select(self::$table_user)->where('user_auth > 99')->results());
	}
	/* Format the content
	 * 
	 * Set date, image paths, title, user authentication and shorten strings
	 */
	protected function format_content($result)
	{
		global $setting;
		
		if ($this->content_format && !empty($result))
		{
			// Format the date
			$result['content_date'] = @date($setting['date_format'], $result['content_time']);	
			
			// Images
			$result = self::images($result);	
	
			if (!empty($this->short_title))
				$result['content_title'] = shorten($result['content_title'], $this->short_title);
			
			if (!empty($this->short_summary))
				$result['content_summary'] = shorten($result['content_summary'], $this->short_summary);
			
			if ($result['is_public'])
				@$result['is_public'] = '<span style="color:green">'. __('Public') .'</span>';
			else 
				@$result['is_public'] = '<span style="color:red">'. __('Not public') .'</span>';
		}
		
		$this->is_auth($result['category_auth']); // Is user authenticated user
		
		return $result;	
	}
	/* Format the category
	 * 
	 * Set parent name etc...
	 */
	protected function format_category($result)
	{
		if ($result['parent_id'])
			$result['parent_name'] = $this->category_id_to_name($result['parent_id']);
		else
			$result['parent_name'] = __('Parent category');
		
		if ($this->category_display_with_parent_name)
			$result['category_name'] = $result['category_name'].' - '.$result['parent_name'];
		
		$this->is_auth($result['category_auth']); // Is user authenticated user
		
		return $result;	
	}
	public function format_categories_for_select($values)
	{
		for ($i=0; $i<count($values); $i++)
		{
			$data[$i]['id'] = $values[$i]['category_id'];
			$data[$i]['value'] = $values[$i]['category_name'];	
		}
		if (isset($data))
			return $data;
	}
	public function format_patterns_for_select($values)
	{
		for ($i=0; $i<count($values); $i++)
		{
			$data[$i]['id'] = $values[$i]['pattern_id'];
			$data[$i]['value'] = $values[$i]['pattern_name'];	
		}
		return @$data;	
	}
	public function format_authors_for_select($values)
	{
		for ($i=0; $i<count($values); $i++)
		{
			$data[$i]['id'] = $values[$i]['user_id'];
			$data[$i]['value'] = $values[$i]['user_name'].' '.$values[$i]['user_surname'];	
		}
		return @$data;	
	}
	// Set image paths of content
	public static function images($result)
	{
		global $site;
		
		// Büyük resmin yolunu belirle, eğer yoksa zorunlu değil demektir
		if (!empty($result['content_img_b']))
			$result['content_img_b'] = $site['image_path'].$result['content_img_b'];
		else
			unset($result['content_img_b']);
		
		// Küçük resmin yolunu belirle, içeriği tanımlamak için bu tip bir resim olmalı
		if (!empty($result['content_img_t']))
			$result['content_img_t'] = $site['image_path'].$result['content_img_t'];
		else
			$result['content_img_t'] = $site['url'].self::$no_pic;
		
		return $result;
	}
	// Find the linked gallery of the asked content
	function gallery_of_content()
	{
		global $pdo;
	
		$query = $pdo->query("SELECT * FROM contents_gallery
							 LEFT JOIN galleries ON galleries.gallery_id = contents_gallery.gallery_id
							 WHERE contents_gallery.content_id = '$this->content'
							 LIMIT 1");
	
		return $query->fetch();
	}
	// Find the linked similar contents of the asked content
	function similars()
	{
		return select('contents_similars')
				->left('contents ON contents.content_id = contents_similars.similar_id')
				->where('contents_similars.content_id = '.$this->content_id)
				->results();
	}
	function not_similars()
	{
		if (empty($this->content_id))
			$this->content_id = 0;
		
		// Contents expect our selected content
		$other_contents = select('contents')->where('content_id <> "'.$this->content_id.'" ')->order('content_title ASC')->results();
		// Similar contents
		$similars = $this->similars();

		// Unset similars to determine not similar contents
		if (!empty($similars))
		{
			foreach ($similars AS $similar)
			{
				for($i=0; $i<count($other_contents); $i++)
				{
					if (@isset($other_contents[$i]))
						if ($similar['content_id'] == $other_contents[$i]['content_id'])
							unset($other_contents[$i]);
				}	
			}	
		}
		return $other_contents;	
	}
	// Content id to sef
	public final function content_id_to_sef($id)
	{
		global $pdo;
		
		$query = $pdo->query("SELECT * FROM contents WHERE content_id = '$id' LIMIT 1");
		$result = $pdo->fetch_array($query);
	
		return $result['content_sef'];		
	}
	// Content sef to id
	public final function content_sef_to_id($sef)
	{
		global $pdo;
		
		$query = $pdo->query("SELECT * FROM contents WHERE content_sef = '$sef' LIMIT 1");
		$result = $pdo->fetch_array($query);
		
		return $result['content_id'];		
	}
	// Content lang id
	public final function content_lang()
	{
		global $pdo;
		
		if (is_numeric($this->content))
			$this->content = $this->content_id_to_sef($this->content);
		
		$query = $pdo->query("SELECT *, langs.lang_id AS lang_id FROM contents 
							 LEFT JOIN langs ON langs.lang_id = contents.lang_id
							 WHERE content_sef = '$this->content' LIMIT 1");

		$result = $query->fetch();
				
		return $result['lang_id'];		
	}
	// Category id to sef
	public final function category_id_to_sef($id)
	{
		return select(self::$table_category)->where('category_id = "'.$id.'"')->limit(1)->result('category_sef');	
	}
	// Cateogry sef to id
	public final function category_sef_to_id($sef)
	{
		return select(self::$table_category)->where('category_sef = "'.$sef.'"')->limit(1)->result('category_id');		
	}
	public function category_id_to_name($id)
	{
		return select(self::$table_category)->where('category_id = "'.$id.'"')->limit(1)->result('category_name');
	}
	// Category lang id
	public final function category_lang()
	{
		global $pdo;
		
		if (is_numeric($this->category))
			$this->category = $this->category_id_to_sef($this->category);
		
		$query = $pdo->query("SELECT *, langs.lang_id AS lang_id FROM categories 
							 LEFT JOIN langs ON langs.lang_id = categories.lang_id
							 WHERE category_sef = '$this->category' LIMIT 1");
		$result = $query->fetch();

		return $result['lang_id'];		
	}
	public final function is_auth($auth)
	{
		// Is user authenticated 
		if ($auth > $_SESSION['user_auth'])
			$this->is_auth = false;	
		else		
			$this->is_auth = true;
	}
	function __call($func, $arg)
	{
		echo '<p>You called a method using named '. $func .' with the following arguments</p>';
		print_r($arg); 
	}
}