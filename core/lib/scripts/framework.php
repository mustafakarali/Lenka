<?php
/** img tag
 * 
 * @param string 
 * @param string 
 * @param string 
 * @return string
 */
function img($src, $alt = '', $title = ''){
	return '<img src="'.$src.'" alt="'.$alt.'" title="'.$title.'">';
}
/** List function
 * 
 * @param array
 * @param string -> ul || ol 
 */
function ul($elemanlar, $tip = 'ul')
{	
	echo '	<'.$tip.'>';
	$say = count($elemanlar);
	for ($i=0; $i<$say; $i++)
		echo '<li>'.$elemanlar[$i].'</li>';
	echo '	</'.$tip.'>';
			
}
/** Success messages
 * 
 * @param string 
 * @return string
 */
function success($veri)
{
	global $lang;
	echo '<strong>'.$lang['basari'].' </strong>'. $veri;
}
/** Warning messages
 * 
 * @param string 
 * @return string
 */
function warning($veri)
{
	global $lang;
	echo '<strong>'.$lang['hata'].' </strong>'. $veri;
}
/** Errors which be shown as a page ex: 401, 404 
 * 
 * @param int 
 * @return die
 */
function error_in_page($sorun)
{
	global $lang, $site;
	
	include('app/view/'.$sorun.'.php');
	die();	
}
/** Multibyte versions of strtoupper,strtolower, ucfirst, ucwords functions 
 * 
 */
$upper = array('ç', 'ğ', 'i', 'ı', 'ö', 'ş', 'ü');
$lower = array('Ç', 'Ğ', 'İ', 'I', 'Ö', 'Ş', 'Ü');

function tr_strtoupper($str)
{
	global $lower, $upper;
	return strtoupper(str_replace($kucuk, $upper, $str));
}

function tr_strtolower($metin) 
{
	global $lower, $upper;
	return strtolower(str_replace($upper, $kucuk, $str));
}

function tr_ucfirst($str, $e='utf-8') 
{
	$fc = tr_strtoupper(mb_substr($str, 0, 1, $e), $e);
	return $fc.mb_substr($str, 1, mb_strlen($str, $e), $e);
}

function tr_ucwords($str)
{
	$str = explode(" ", $str);

	$result = NULL;
	$i = true;
	
	foreach ($str as $part)
	{
		$result .= tr_ucfirst($part);
		$result .= ' ';
		$i = false;
	}
	return $result;
}

/** Outputs the html checked attribute.
 * 
 * Compares the first two arguments and if identical marks as checked
 * 
 * @param mixed $checked One of the values to compare
 * @param mixed $current (true) The other value to compare if not just true
 * @param bool $echo Whether to echo or just return the string
 * 
 * @return string html attribute or empty string
 */
function checked($checked, $current = true, $echo = true){
	return __checked_selected_helper($checked, $current, $echo, 'checked');
}
/** Outputs the html selected attribute.
 * 
 * Compares the first two arguments and if identical marks as selected
 * 
 * @param mixed $selected One of the values to compare
 * @param mixed $current (true) The other value to compare if not just true
 * @param bool $echo Whether to echo or just return the string
 * @return string html attribute or empty string
 */
function selected($selected, $current = true, $echo = true){
	return __checked_selected_helper($selected, $current, $echo, 'selected');
}
/** Outputs the html disabled attribute.
 * 
 * Compares the first two arguments and if identical marks as disabled
 * 
 * @param mixed $disabled One of the values to compare
 * @param mixed $current (true) The other value to compare if not just true
 * @param bool $echo Whether to echo or just return the string
 * @return string html attribute or empty string
 */
function disabled($disabled, $current = true, $echo = true){
	return __checked_selected_helper($disabled, $current, $echo, 'disabled');
}
/** Private helper function for checked, selected, and disabled.
 * 
 * Compares the first two arguments and if identical marks as $type
 * 
 * @access private
 * 
 * @param mixed $helper One of the values to compare
 * @param mixed $current (true) The other value to compare if not just true
 * @param bool $echo Whether to echo or just return the string
 * @param string $type The type of checked|selected|disabled we are doing
 * @return string html attribute or empty string
 */
function __checked_selected_helper($helper, $current, $echo, $type){
	if ((string)$helper === (string)$current)
		$result = " $type='$type'";
	else
		$result = '';

	if ($echo)
		echo $result;
	else
		return $result;
}
/** Singular or Pularal helper for language 
 * 
 * @param string $s singular form of text
 * @param string $p pulural form of text
 * @param int to determine which text will be in the display
 * @return string 
 */
function n($s, $p, $value){
	if ($value > 1)
		return $value.' '.__($p);
	else
		return $value.' '.__($s); 
}
/** Only replace first match
 * 
 * @param $search 
 * @param $replace
 * @param $subject
 * @return string
 */
function str_replace_first($search, $replace, $subject) {
    return implode($replace, explode($search, $subject, 2));
}