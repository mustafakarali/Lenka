<?php  
$blog = new Blog();

// Asked content
$blog->content_id = (int)Routes::$func;
$content = $blog->content();

Seo::$value = $content['content_title'];
Seo::$desc = $content['content_seo_desc'];
Seo::$keys = $content['content_seo_keywords'];
Seo::$author = $content['content_seo_author'];

// Contents in category
$blog->category = $content['category_id'];
$contents_in_category = $blog->contents();
if (!empty($contents_in_category))
{
	$in_category = '';
	$i = 0;
	foreach($contents_in_category AS $c) 
	{
		if ($i == 0)
			$class = 'class="active"';
		else
			$class = '';
		
		$in_category .=  '	<li '.$class.'>
								<a href="'.Routes::$base.'page/'.$c['content_id'].'/'.$c['content_sef'].'" class="f_size_large color_dark d_block">
									<b>'.$c['content_title'].'</b>
								</a>
							</li>';
		$i++;
	}
}


// Contents similar
$contents_similar = $blog->similars();
$in_similar = '';
if (!empty($contents_similar))
{
	$in_similar = '';
	$i = 0;
	foreach($contents_similar AS $c) 
	{
		if ($i == 0)
			$class = 'class="active"';
		else
			$class = '';
		
		$in_similar .=  '	<li '.$class.'>
								<a href="'.Routes::$base.'page/'.$c['content_id'].'/'.$c['content_sef'].'" class="f_size_large color_dark d_block">
									<b>'.$c['content_title'].'</b>
								</a>
							</li>';
		$i++;
	}
}