<?php
/** Main security function to check strings
 * 
 * @param string $input
 * @return string 
 */
function security($input)
{
	// Clear not allowed chars
	$input = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $input);
	
	// Search for these
	$search = 'abcdefghijklmnopqrstuvwxyz';
	$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$search .= '1234567890!@#$%^&*()';
	$search .= '~`";:?+/={}[]-_|\'\\';
	
	// Clear not allowed chars again
	for ($i = 0; $i < strlen($search); $i++) 
	{
		$input = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $input);
		$input = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $input);
	}
	
	// Remove java, flash etc.. 
	$ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
	$ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
	
	// Merge arrays
	$ra = array_merge($ra1, $ra2);
	
	// Remove possible threats which are defined above
	$find = true;
	while ($find == true) 
	{
		$first = $input;
		for ($i = 0; $i < sizeof($ra); $i++) 
		{
			$action = '/';
			for ($j = 0; $j < strlen($ra[$i]); $j++) 
			{
				if ($j > 0) 
				{
					$action .= '(';
					$action .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
					$action .= '|(&#0{0,8}([9][10][13]);?)?';
					$action .= ')?';
				}
				$action .= $ra[$i][$j];
			}
			
			$action .= '/i';
			$change = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2);
			$input = preg_replace($action, $change, $input);
			
			if ($first == $input) 
			{
				$find = false;
			}
		}
	}
	
	// Allowed tags
	$result = strip_tags($input, '<p><strong><em><b><i><ul><li><pre><hr><blockquote><span>');
	
	// Change special chars to their html version 
	$result = htmlspecialchars($result);

	// \n to <br>
	$result = str_replace("\n", "<br />", $result);

	// Add slash
	$result = addslashes($result);

	return $result;
}

/** Clear unnecessary chars
 * 
 * @param string
 * @return string
 */
function clean($input)
{
    $input = str_replace("\'", "'", $input);
	$input = str_replace("\\\\", "\\", $input);
	$input = str_replace("<br />", "\n", $input);
	$input = str_replace("&amp;", "&", $input);
	$input = str_replace("&quot;", "\"", $input);
	$input = str_replace("<", "&lt;", $input);
	$input = str_replace(">", "&gt;", $input);

	return $input;
}