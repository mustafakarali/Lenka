<?php
$blog = new Blog();

// Asked category
if (!empty(Routes::$get[1]))
{
	$blog->category = (int)Routes::$get[1];
	// Current category
	$current_category = $blog->category();
	// Child categories
	$child_categories = $blog->child_categories((int)Routes::$get[1]);
}
// Return the contents in the asked category and shorten some strings
$blog->short_summary = 400;
$blog->is_public = '= 1';
$blog->limit = 3;
$blog->condition = 'ORDER BY contents.content_order ASC, contents.content_time DESC';
$contents_0to5 = $blog->contents();

// Return the latest contents in the given category
$blog->limit = '3, 15';
$contents_5to15 = $blog->contents();

// Parent category
$blog->category = $contents_0to5[0]['parent_id'];
$parent_category = $blog->category();
// Contents in parent category
$contents_in_category = $blog->contents();