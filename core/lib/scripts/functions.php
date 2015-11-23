<?php
$setting['ver_core'] = '0.1';

/* SEO Class to set metatags and title before everything */
Seo::$name = $setting['site_name'];
Seo::$desc = $setting['meta_description'];
Seo::$keys = $setting['meta_keywords'];
Seo::$author = $setting['site_name'];
Seo::$img = $setting['og_image'];

/** Languages stored in database
 * 
 * @return array
 */
function langs()
{
	return select('langs')->results();
}
/** Dynamic language files to use placeholders
 * 
 * @example __('Hello :username', array('username'=>'Günce'));
 * @example __('Image dimension should be :img_w px and height :img_h px', array('img_w'=>50, 'img_h'=>50));
 * @param string language variable which includes placeholder
 * @param string values which will be replaced with placeholders
 * 
 * @return if values not empty, new language variable with replaced placeholder
 * 		   if values are emptty return language variable
 */
function __($variable, $values = '')
{
	global $lang;

	if ($values)
	{
		$key = array_keys($values);
		$val = array_values($values);
			
		if (count($key) == 1)
		{
			if (isset($lang[$variable]))
				$lang[$variable] = str_replace(':'.$key[0], $val[0], $lang[$variable]);	
			else
				$variable = str_replace(':'.$key[0], $val[0], $variable);	
		}
		else 
		{
			for($i = 0; $i<count($key); $i++)
			{
				if (isset($lang[$variable]))
					$lang[$variable] = str_replace_first(':'.$key[$i], $val[$i], $lang[$variable]);
				else
					$variable = str_replace_first(':'.$key[$i], $val[$i], $variable);
			}	
		}
		// Return new variable
		if (isset($lang[$variable]))
			return $lang[$variable];
		else
			return $variable;
	}	
	else 
	{
		// If variable has been setted in static language files return it
		if (isset($lang[$variable]))
		{
			return $lang[$variable];
		}	
		else
		{
			// If variable couldn't be found in static language files, check dynamic variables and if it exists return it
			$dynamic_var = select('dynamic_vars')->where('dynamic_var_key = "'.$variable.'" AND lang_id = "'.$_SESSION['lang_id'].'"')->limit(1)->result('dynamic_var_value');
			if ($dynamic_var)
				return $dynamic_var;
			else
				return $variable;
		}
	}
}
/** User authentication
 * 
 * @param authentication level
 * @return bool 
 */
function is_auth($auth)
{	
	if ($_SESSION['user_auth'] < $auth)
		return false;
	else
		return true;	
}
// Is user using a mobile device
$_SESSION['mobile'] = is_mobile();
function is_mobile()
{
	if (empty($_SERVER['HTTP_USER_AGENT']) || !isset($_SERVER['HTTP_USER_AGENT'])) 
	{
		$is_mobile = 0;
	} 
	elseif ( strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false // Çoğu mobil cihaz (iPhone, iPad, vb...)
		  || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
		  || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
		  || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
		  || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
		  || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
		  || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false ) 
	{
		$is_mobile = 1;
	} 
	else 
	{
	    $is_mobile = 0;
	}
	return $is_mobile;
}
/** Set session variables of user
 *
 * @param user information in array
 * @set session variables
 */
function set_session($data)
{
	if (isset($data['user_pass']))
		unset($data['user_pass']);
	
	$_SESSION = $data;
}	
/** IP of user
 * 
 * @return string 
 */
function ip() 
{
  if (getenv("HTTP_CLIENT_IP"))
    $ip = getenv("HTTP_CLIENT_IP");
  else if(getenv("HTTP_X_FORWARDED_FOR"))
    $ip = getenv("HTTP_X_FORWARDED_FOR");
  else if(getenv("REMOTE_ADDR"))
    $ip = getenv("REMOTE_ADDR");
  else
    $ip = "0";
  
  if ($ip = '::1')
  	$ip = '127.0.0.1';
  
  return $ip;
}
/** County of user
 * 
 * @return string
 */
function country()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
	
    $country  = false;
    
    if(filter_var($client, FILTER_VALIDATE_IP))
        $ip = $client;
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
        $ip = $forward;
    else
        $ip = $remote;

    $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));

    if($ip_data && $ip_data->geoplugin_countryName != null)
        return $ip_data->geoplugin_countryName;

    return $country;
}
/** Encrypt function creates a returnable hash
 * 
 * @param value
 * @return encrypted value
 */
function encrypt($value, $key = 0) 
{
	global $setting;
	
	if ($key == 0)
		$key = $setting['crypto_key'];	
	
	$result = '';
	for($i=0; $i<strlen($value); $i++) {
	    $char    		= substr($value, $i, 1);
	    $key_char		= substr($key, ($i % strlen($key)) -1, 1);
	    $char			= chr(ord($char) + ord($key_char));
	    $result .= $char;
	}
	// encypted value
	return base64_encode($result);
}
/** Dencrypt function creates a returnable hash
 * 
 * @param value
 * @return encrypted value
 */
function decrypt($value, $key = 0) 
{
	global $setting;
	
	if ($anahtar == 0)
		$key = $setting['crypto_key'];
	
	$result = '';
	$value = base64_decode($value);
	for($i=0; $i<strlen($value); $i++) {
    	$char    		= substr($value, $i, 1);
    	$key_char 	= substr($key, ($i % strlen($key))-1, 1);
    	$char			= chr(ord($char)-ord($key_char));
    	$result .= $char;
	}
	// dencypted value
	return $result; 
}
/** Mail function 
 * 
 * @param email address
 * @param subject
 * @param message
 * 
 * @return send email
 */
function email($to,$subject,$message)
{
	global $setting;
		
	// sender
	$from  = $setting['contact_email'];
	
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: <'.$from.'>' . "\r\n";
	$headers .= "Reply-To:". $from ."\r\n";
	$headers .= 'Message-ID: <A' . time() . '@' . $_SERVER['HTTP_HOST'] . '>' . "\r\n";
  
	mail($to, $subject, $message, $headers);
}
/** Breadcrumb
 * 
 * @return string
 */
function breadcrumb()
{
	global $setting;

	// If it's special for admin pages 
	if (Routes::$module == 'admin'){
		require_once('cms/lang/'.$_SESSION['lang_code'].'/default.php');
		
		// Check to see if it's a dynamic content
		if (strpos(Routes::$func, 'dynamic') !== false){
			$result = '	<li><a href="'.Routes::$base.'">'.ucfirst($setting['site_name']).'</a></li>
						<li><a href="'.Routes::$base.'admin">'.__(ucfirst(str_replace('-', ' ', Routes::$module))).'</a></li>';
				
			if (strpos(Routes::$func, 'dynamic-tables') !== false || strpos(Routes::$func, 'dynamic-table') !== false){
				$result .= '	<li><a href="'.Routes::$base.'admin/datatables">'.__('Datatables').'</a></li>
								<li class="current"><a href="#">'.__(ucfirst(str_replace('-', ' ', Routes::$func))).'</a></li>';
			}	
			
			if (strpos(Routes::$func, 'dynamic-rows') !== false || strpos(Routes::$func, 'dynamic-row') !== false){
				$result .= '	<li class="current"><a href="'.Routes::$base.'admin/dynamic-rows/'.Routes::$get[1].'">'.__(ucfirst(str_replace('-', ' ', Routes::$get[1]))).'</a></li>';
			}
				  
			return $result;
		}
	}
	
	if (!empty(Routes::$func))
		return '<li><a href="'.Routes::$base.'">'.ucfirst($setting['site_name']).'</a></li>
			  	<li><a href="#">'.__(ucfirst(str_replace('-', ' ', Routes::$module))).'</a></li>
			  	<li class="current"><a href="#">'.__(ucfirst(str_replace('-', ' ', Routes::$func))).'</a></li>';
	else 
		return '<li><a href="'.Routes::$base.'">'.ucfirst($setting['site_name']).'</a></li>
			  	<li class="current"><a href="#">'.ucfirst(__(str_replace('-', ' ', Routes::$module))).'</a></li>';
} 

/** Shorten the given string 
 * 
 * @param string
 * @param int limit 
 * @return shortened string
 */
function shorten($string, $limit = 30)
{
  if (strlen($string) > $limit)
    return mb_substr($string,0,$limit-5,'UTF-8').'...';
  else
    return $string;  
}
/** Create sef link 
 * 
 * @param string
 * @return sef link
 */
function sef($veri)
{
	global $pdo;
	
	$characterHash = array (
		'a'		=>	array ('a', 'A', 'à', 'À', 'á', 'Á', 'â', 'Â', 'ã', 'Ã', 'ä', 'Ä', 'å', 'Å', 'ª', 'ą', 'Ą', 'а', 'А', 'ạ', 'Ạ', 'ả', 'Ả', 'Ầ', 'ầ', 'Ấ', 'ấ', 'Ậ', 'ậ', 'Ẩ', 'ẩ', 'Ẫ', 'ẫ', 'Ă', 'ă', 'Ắ', 'ắ', 'Ẵ', 'ẵ', 'Ặ', 'ặ', 'Ằ', 'ằ', 'Ẳ', 'ẳ', 'あ', 'ア', 'α', 'Α'),
		'aa'	=>	array ('ا'),
		'ae'	=>	array ('æ', 'Æ', 'ﻯ'),
		'and'	=>	array ('&'),
		'at'	=>	array ('@'),
		'b'		=>	array ('b', 'B', 'б', 'Б', 'ب'),
		'ba'	=>	array ('ば', 'バ'),
		'be'	=>	array ('べ', 'ベ'),
		'bi'	=>	array ('び', 'ビ'),
		'bo'	=>	array ('ぼ', 'ボ'),
		'bu'	=>	array ('ぶ', 'ブ'),
		'c'		=>	array ('c', 'C', 'ç', 'Ç', 'ć', 'Ć', 'č', 'Č'),
		'cent'	=>	array ('¢'),
		'ch'	=>	array ('ч', 'Ч', 'χ', 'Χ'),
		'chi'	=>	array ('ち', 'チ'),
		'copyright'	=>	array ('©'),
		'd'		=>	array ('d', 'D', 'Ð', 'д', 'Д', 'د', 'ض', 'đ', 'Đ', 'δ', 'Δ'),
		'da'	=>	array ('だ', 'ダ'),
		'de'	=>	array ('で', 'デ'),
		'degrees'	=>	array ('°'),
		'dh'	=>	array ('ذ'),
		'do'	=>	array ('ど', 'ド'),
		'e'		=>	array ('e', 'E', 'è', 'È', 'é', 'É', 'ê', 'Ê', 'ë', 'Ë', 'ę', 'Ę', 'е', 'Е', 'ё', 'Ё', 'э', 'Э', 'Ẹ', 'ẹ', 'Ẻ', 'ẻ', 'Ẽ', 'ẽ', 'Ề', 'ề', 'Ế', 'ế', 'Ệ', 'ệ', 'Ể', 'ể', 'Ễ', 'ễ', 'え', 'エ', 'ε', 'Ε'),
		'f'		=>	array ('f', 'F', 'ф', 'Ф', 'ﻑ', 'φ', 'Φ'),	
		'fu'	=>	array ('ふ', 'フ'),
		'g'		=>	array ('g', 'G', 'ğ', 'Ğ', 'г', 'Г', 'γ', 'Γ'),
		'ga'	=>	array ('が', 'ガ'),
		'ge'	=>	array ('げ', 'ゲ'),
		'gh'	=>	array ('غ'),
		'gi'	=>	array ('ぎ', 'ギ'),
		'go'	=>	array ('ご', 'ゴ'),
		'gu'	=>	array ('ぐ', 'グ'),
		'h'		=>	array ('h', 'H', 'ح', 'ه'),
		'ha'	=>	array ('は', 'ハ'),
		'half'	=>	array ('½'),
		'he'	=>	array ('へ', 'ヘ'),
		'hi'	=>	array ('ひ', 'ヒ'),
		'ho'	=>	array ('ほ', 'ホ'),
		'i'		=>	array ('i', 'I', 'ì', 'Ì', 'í', 'Í', 'î', 'Î', 'ï', 'Ï', 'ı', 'İ', 'и', 'И', 'Ị', 'ị', 'Ỉ', 'ỉ', 'Ĩ', 'ĩ', 'い', 'イ', 'η', 'Η', 'Ι', 'ι'),
		'j'		=>	array ('j', 'J', 'ج'),
		'ji'	=>	array ('じ', 'ぢ', 'ジ', 'ヂ'),
		'k'		=>	array ('k', 'K', 'к', 'К', 'ك', 'κ', 'Κ'),
		'ka'	=>	array ('か', 'カ'),
		'ke'	=>	array ('け', 'ケ'),
		'kh'	=>	array ('х', 'Х', 'خ'),
		'ki'	=>	array ('き', 'キ'),
		'ko'	=>	array ('こ', 'コ'),
		'ku'	=>	array ('く', 'ク'),
		'l'		=>	array ('l', 'L', 'ł', 'Ł', 'л', 'Л', 'ل', 'λ', 'Λ'),
		'la'	=>	array ('ﻻ'),
		'm'		=>	array ('m', 'M', 'м', 'М', 'م', 'μ', 'Μ'),
		'ma'	=>	array ('ま', 'マ'),
		'me'	=>	array ('め', 'メ'),
		'mi'	=>	array ('み', 'ミ'),
		'mo'	=>	array ('も', 'モ'),
		'mu'	=>	array ('む', 'ム'),
		'n'		=>	array ('n', 'N', 'ñ', 'Ñ', 'ń', 'Ń', 'н', 'Н', 'ن', 'ん', 'ン', 'ν', 'Ν'),
		'na'	=>	array ('な', 'ナ'),
		'ne'	=>	array ('ね', 'ネ'),
		'ni'	=>	array ('に', 'ニ'),
		'no'	=>	array ('の', 'ノ'),
		'nu'	=>	array ('ぬ', 'ヌ'),
		'o'		=>	array ('o', 'O', 'ò', 'Ò', 'ó', 'Ó', 'ô', 'Ô', 'õ', 'Õ', 'ö', 'Ö', 'ø', 'Ø', 'º', 'о', 'О', 'Ọ', 'ọ', 'Ỏ', 'ỏ', 'Ộ', 'ộ', 'Ố', 'ố', 'Ỗ', 'ỗ', 'Ồ', 'ồ', 'Ổ', 'ổ', 'Ơ', 'ơ', 'Ờ', 'ờ', 'Ớ', 'ớ', 'Ợ', 'ợ', 'Ở', 'ở', 'Ỡ', 'ỡ', 'お', 'オ', 'ο', 'Ο', 'ω', 'Ω'),
		'p'		=>	array ('p', 'P', 'п', 'П', 'π', 'Π'),
		'pa'	=>	array ('ぱ', 'パ'),
		'pe'	=>	array ('ぺ', 'ペ'),
		'percent'	=>	array ('%'),
		'pi'	=>	array ('ぴ', 'ピ'),
		'plus'	=>	array ('+'),
		'plusminus'	=>	array ('±'),
		'po'	=>	array ('ぽ', 'ポ'),
		'pound'	=>	array ('£'),
		'ps'	=>	array ('ψ', 'Ψ'),
		'pu'	=>	array ('ぷ', 'プ'),
		'q'		=>	array ('q', 'Q', 'ق'),
		'quarter'	=>	array ('¼'),
		'r'		=>	array ('r', 'R', '®', 'р', 'Р', 'ر'),
		'ra'	=>	array ('ら', 'ラ'),
		're'	=>	array ('れ', 'レ'),
		'ri'	=>	array ('り', 'リ'),
		'ro'	=>	array ('ろ', 'ロ'),
		'ru'	=>	array ('る', 'ル'),
		's'		=>	array ('s', 'S', 'ş', 'Ş', 'ś', 'Ś', 'с', 'С', 'س', 'ص', 'š', 'Š', 'σ', 'ς', 'Σ'),
		'sa'	=>	array ('さ', 'サ'),
		'se'	=>	array ('せ', 'セ'),
		'section'	=>	array ('§'),
		'sh'	=>	array ('ш', 'Ш', 'ش'),
		'shi'	=>	array ('し', 'シ'),
		'shch'	=>	array ('щ', 'Щ'),
		'so'	=>	array ('そ', 'ソ'),
		'ss'	=>	array ('ß'),
		'su'	=>	array ('す', 'ス'),
		't'		=>	array ('t', 'T', 'т', 'Т', 'ت', 'ط', 'τ', 'Τ', 'ţ', 'Ţ'),
		'ta'	=>	array ('た', 'タ'),
		'te'	=>	array ('て', 'テ'),
		'th'	=>	array ('ث', 'θ', 'Θ'),
		'three-quarters'	=>	array ('¾'),
		'to'	=>	array ('と', 'ト'),
		'ts'	=>	array ('ц', 'Ц'),
		'tsu'	=>	array ('つ', 'ツ'),
		'u'		=>	array ('u', 'U', 'ù', 'Ù', 'ú', 'Ú', 'û', 'Û', 'ü', 'Ü', 'у', 'У', 'Ụ', 'ụ', 'Ủ', 'ủ', 'Ũ', 'ũ', 'Ư', 'ư', 'Ừ', 'ừ', 'Ứ', 'ứ', 'Ự', 'ự', 'Ử', 'ử', 'Ữ', 'ữ', 'う', 'ウ', 'υ', 'Υ'),
		'v'		=>	array ('v', 'V', 'в', 'В', 'β', 'Β'),	
		'w'		=>	array ('w', 'W', 'و'),
		'wa'	=>	array ('わ', 'ワ'),
		'wo'	=>	array ('を', 'ヲ'),
		'x'		=>	array ('x', 'X', '×', 'ξ', 'Ξ'),	
		'y'		=>	array ('y', 'Y', 'ý', 'Ý', 'ÿ', 'й', 'Й', 'ы', 'Ы', 'ي', 'Ỳ', 'ỳ', 'Ỵ', 'ỵ', 'Ỷ', 'ỷ', 'Ỹ', 'ỹ'),
		'ya'	=>	array ('я', 'Я', 'や'),
		'yen'	=>	array ('¥'),
		'yo'	=>	array ('よ'),
		'yu'	=>	array ('ю', 'Ю', 'ゆ'),
		'z'		=>	array ('z', 'Z', 'ż', 'Ż', 'ź', 'Ź', 'з', 'З', 'ز', 'ظ', 'ž', 'Ž', 'ζ', 'Ζ'),
		'za'	=>	array ('ざ', 'ザ'),
		'ze'	=>	array ('ぜ', 'ゼ'),
		'zh'	=>	array ('ж', 'Ж'),
		'zo'	=>	array ('ぞ', 'ゾ'),
		'zu'	=>	array ('ず', 'づ', 'ズ', 'ヅ'),
		'-'		=>	array ('-', ' ', '.', ','),
		'_'		=>	array ('_'),
		'!'		=>	array ('!'),
		'~'		=>	array ('~'),
		'*'		=>	array ('*'),
		''		=>	array ("'", '"', 'ﺀ', 'ع'),
		'('		=>	array ('(', '{', '['),
		')'		=>	array (')', '}', ']'),
		'$'		=>	array ('$'),	
		'0'		=>	array ('0'),
		'1'		=>	array ('1', '¹'),
		'2'		=>	array ('2', '²'),
		'3'		=>	array ('3', '³'),
		'4'		=>	array ('4'),
		'5'		=>	array ('5'),
		'6'		=>	array ('6'),
		'7'		=>	array ('7'),
		'8'		=>	array ('8'),	
		'9'		=>	array ('9'),
	);	
	$prettytext = '';	
	preg_match_all("~.~su", $veri, $characters);
	
	foreach ($characters[0] as $aLetter)
	{
		foreach ($characterHash as $replace => $search)
		{
			if (in_array($aLetter, $search))
			{
				$prettytext .= $replace;
				break;
			}
		}
	}
	//	Remove unwanted '-' 
	$prettytext = str_replace('', '-', $prettytext);
		
	return $prettytext;
}
/** Convert an UTF-8 encoded string to a single-byte string suitable for
 * functions such as levenshtein.
 * 
 * The function simply uses (and updates) a tailored dynamic encoding
 * (in/out map parameter) where non-ascii characters are remapped to
 * the range [128-255] in order of appearance.
 * 
 * Thus it supports up to 128 different multibyte code points max over
 * the whole set of strings sharing this encoding.
 * 
 * @param string
 * @param string
 * @return string
 */
function utf8_to_extended_ascii($str, &$map)
{
    // find all multibyte characters (cf. utf-8 encoding specs)
    $matches = array();
    if (!preg_match_all('/[\xC0-\xF7][\x80-\xBF]+/', $str, $matches))
        return $str; // plain ascii string
   
    // update the encoding map with the characters not already met
    foreach ($matches[0] as $mbc)
        if (!isset($map[$mbc]))
            $map[$mbc] = chr(128 + count($map));
   
    // finally remap non-ascii characters
    return strtr($str, $map);
}
/** Didactic example showing the usage of the previous conversion function but,
 * for better performance, in a real application with a single input string
 * matched against many strings from a database, you will probably want to
 * pre-encode the input only once.
 * 
 * @param string
 * @param string
 * @return booleon
 */
function levenshtein_utf8($s1, $s2)
{
    $charMap = array();
    $s1 = utf8_to_extended_ascii($s1, $charMap);
    $s2 = utf8_to_extended_ascii($s2, $charMap);
   
    return levenshtein($s1, $s2);
}


/** Divide array 
 * 
 * @param array $array 
 * @param int $n
 * @return array
 */
function array_divide($array, $n = 2) {
    $array_len = count( $array );
    $part_len = floor( $array_len / $n );
    $partrem = $array_len % $n;
    
    $partition = array();
    $mark = 0;
	
    for ($i = 0; $i < $n; $i++) 
    {
        $incr = ($i < $partrem) ? $part_len + 1 : $part_len;
        $partition[$i] = array_slice( $array, $mark, $incr );
        $mark += $incr;
    }
    return $partition;
}

/** This function inverses a color to it's opposite.
 * White to black, blue to yellow, etc.
 * 
 * @param string hexcode
 * @return string hexcode
 */
function color_inverse($color){
    $color = str_replace('#', '', $color);
    if (strlen($color) != 6){ return '000000'; }
    $rgb = '';
    for ($x=0;$x<3;$x++){
        $c = 255 - hexdec(substr($color,(2*$x),2));
        $c = ($c < 0) ? 0 : dechex($c);
        $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
    }
    return '#'.$rgb;
}


/* Zip array
function array_zip(...$arrays) {
    return array_merge(...array_map(NULL, ...$arrays));
}
*/

/** Order array
 * 
 * @return array
 */
function array_orderby()
{
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}
/** Page Views to get user experience
 * 
 */
function url_views()
{
	global $site;
	
	if (!strpos(Routes::$current, 'core') &&
		!strpos(Routes::$current, 'cms') &&
		!strpos(Routes::$current, 'app') &&
		!strpos(Routes::$current, 'admin') && 
		!strpos(Routes::$current, 'yonetim') && 
		!strpos(Routes::$current, 'ajax') && 
		!strpos(Routes::$current, 'anasayfa') && 
		!strpos(Routes::$current, 'home') && 
		!strpos(Routes::$current, 'exit') && 
		!strpos(Routes::$current, '.css')  && 
		!strpos(Routes::$current, '.js')  && 
		!strpos(Routes::$current, '.xml') &&
		!strpos(Routes::$current, 'img') &&
		!empty(Routes::$module))
	{
		insert('url_views')->values(array('url' => Routes::$current,
										  'user_id' => $_SESSION['user_id'],
										  'url_timestamp' => $site['timestamp']));
	}
}
//url_views();