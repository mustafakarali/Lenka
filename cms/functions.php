<?php
$setting['ver_cms'] = '0.1';

// Run functions by checking their authentications level
function func_cms($func_name)
{
	// Set levels
	$func_auth = array("cache_klasorunu_temizle"=>"100",
					   "tablodaki_ilgili_satir_ve_sutunu_guncelle" => "100");
	
	if (!empty($func_auth[$func_name]))
	{
		if ($_SESSION['user_auth'] > $func_auth[$func_name])
		{
			$func_name();
		}
		else 
		{
			include('cms/view/header.php');
			error_in_page(401);
			return false;
		}	
	}
	else
	{
		$func_name();	
	}
}
/** Generates Input elements for CMS
 * 
 * @category 	Library
 * @version		0.1.0
 *
 * @example echo Input::text('text_field');
 * 
 * @return string html elements
 */
class Input
{
	public static $start;
	public static $finish;
	
	public static $required = false;
	public static $disabled = false;
	public static $checked = null;
	public static $default = true;
	// label of element
	public static $label = false;
	// id value of element
	public static $id = false;
	// name value of element
	public static $name = false;
	// warning note after element
	public static $note = false;
	
	public static $container = true;
	public static $only_element = false;
	
	// variables for map
	public static $lat = '41.001897';
	public static $lng = '28.583706';
	public static $zoom = 9;
	
	public function __construct()
	{
		if (self::$container)
			self::$start = '	<div class="formRow">';	
	}
	public function __destruct()
	{
		if (self::$container)
		{
			self::$finish .= '	<div class="clear"></div>    
							</div>';	
		}
		self::$name = false;
		self::$note = false;
	}

	/** First part of the element 
	 * which is covering label part
	 * 
	 * @param string $label
	 * @param int $grid
	 * 
	 * @return string
	 */
	public static function first_part($label, $grid = 2)
	{
		if (self::$label)
			$label = self::$label;
		
		return '	<div class="grid'.$grid.'">
						<label>'.__($label).'</label>
					</div>';
	}
	/** Second part of the element 
	 * which is covering html element
	 * 
	 * @param string $label
	 * @param int $grid
	 * @param bool $note
	 * @return string
	 */
	public static function second_part($element, $grid = 10, $note = true)
	{
		$result = '<div class="grid'.$grid.'">';
		
		$result .= $element;
		
		if ($note)
			$result .= self::note();
		
		$result .= '</div>';
					
		return $result;
	}
	/** Note part of the element
	 * 
	 * @return string note
	 */
	public static function note()
	{
		return '<span class="note">'. __(self::$note) .'</span>';
	}
	/** Generates a text element
	 * 
	 * @category type="text"
	 * 
	 * @param string $name
	 * @param string $data
	 * @return string
	 */ 
	public static function text($name, $data = '')
	{
		if (self::$disabled)
			self::$disabled = 'disabled';
				
		if (self::$name)
			$_name = self::$name;
		else
			$_name = $name;
		
		if (self::$required)
			self::$required = 'required';
		
		$element = '<input type="text" name="'.$_name.'" id="'.$name.'" value="'.$data.'" class="'.self::$required.'" '.self::$disabled.'>';
		
		if (self::$only_element)
			return $element;
			
		$result = '	'.self::first_part($name).'
					'.self::second_part($element);
		
		return self::$start.$result.self::$finish;
	} 
	/** Generates a pass element
	 * 
	 * @category type="password"
	 * 
	 * @param string $name
	 * @return string
	 */
	public static function pass($name)
	{
		if (self::$name)
			$_name = self::$name;
		else
			$_name = $name;
		
		if (self::$required)
			self::$required = 'required';
		
		$element = '<input type="password" name="'.$_name.'" id="'.$name.'" class="'.self::$required.'">';
		
		if (self::$only_element)
			return $element;
			
		$result = '	'.self::first_part($name).'
					'.self::second_part($element);
		
		return self::$start.$result.self::$finish;
	} 
	/** Generates a file element
	 * 
	 * @category type="file"
	 * 
	 * @param string $name
	 * @return string
	 */
	public static function browse($name)
	{
		if (self::$disabled)
			self::$disabled = 'disabled';
		
		if (self::$name)
			$_name = self::$name;
		else
			$_name = $name;
		
		if (self::$required)
			self::$required = 'required';
		
		$element = '<input type="file" name="'.$_name.'" id="'.$name.'" class="'.self::$required.'" '.self::$disabled.'>';
		
		if (self::$only_element)
			return $element;
			
		$result = '	'.self::first_part($name).'
					'.self::second_part($element);
		
		return self::$start.$result.self::$finish;
	} 
	/** Generates a finder field to pick a file
	 * 
	 * @category ckfinder
	 * 
	 * @param string $name
	 * @param string $data
	 * @return string
	 */
	public static function finder($name, $data = '')
	{
		if (self::$name)
			$_name = self::$name;
		else
			$_name = $name;
			
		if (self::$required)
			self::$required = 'required';
		
		?>
		<script type="text/javascript">
		// CK editör
		function BrowseServer(startupPath, functionData)
		{
			// You can use the "CKFinder" class to render CKFinder in a page:
			var finder = new CKFinder();
			// The path for the installation of CKFinder (default = "/ckfinder/").
			finder.basePath = '../';
			//Startup path in a form: "Type:/path/to/directory/"
			finder.startupPath = startupPath;
			// Name of a function which is called when a file is selected in CKFinder.
			finder.selectActionFunction = SetFileField;
			// Additional data to be passed to the selectActionFunction in a second argument.
			// We'll use this feature to pass the Id of a field that will be updated.
			finder.selectActionData = functionData;
			// Name of a function which is called when a thumbnail is selected in CKFinder.
			finder.selectThumbnailActionFunction = ShowThumbnails;
			// Launch CKFinder
			finder.popup();
		}
		// This is a sample function which is called when a file is selected in CKFinder.
		function SetFileField(fileUrl, data)
		{
			var sFileName = this.getSelectedFile().name;
			var sFileFolder = this.getSelectedFile().folder;
			text = sFileFolder+sFileName;
			text = text.substr(1);
			
			document.getElementById(data["selectActionData"] ).value = text;
		}
		// This is a sample function which is called when a thumbnail is selected in CKFinder.
		function ShowThumbnails(fileUrl, data)
		{
			// this = CKFinderAPI
			var sFileName = this.getSelectedFile().name;
			document.getElementById( 'thumbnails' ).innerHTML +=
					'<div class="thumb">' +
						'<img src="' + fileUrl + '" />' +
						'<div class="caption">' +
							'<a href="' + data["fileUrl"] + '" target="_blank">' + sFileName + '</a> (' + data["fileSize"] + 'KB)' +
						'</div>' +
					'</div>';
			document.getElementById( 'preview' ).style.display = "";
			// It is not required to return any value.
			// When false is returned, CKFinder will not close automatically.
			return false;
		}
		</script>
		<?php
		if (self::$only_element)
			return '<div class="grid1">
                    	<a class="buttonS bBlack first" onclick="BrowseServer( \'Images:/\', \''.$name.'\' );">'.__('Select').'</a>
                    </div> 
                    <div class="grid9">
                    	<input id="'.$name.'" name="'.$_name.'" type="text" size="60" value="'.$data.'" class="'.self::$required.'"/>
                    	<span class="note">'. __(self::$note) .'</span>
					</div>
					<div class="grid2">
                    	<a class="buttonS bRed" onclick="clean(\''.$name.'\')">'. __('Do_not_use_image').'</a>
                    </div>';
		
		$result = '	'.self::first_part($name).'
                    <div class="grid10">
                    	<div class="grid1">
                        	<a class="buttonS bBlack first" onclick="BrowseServer( \'Images:/\', \''.$name.'\' );">'.__('Select').'</a>
                        </div> 
                        <div class="grid9">
                        	<input id="'.$name.'" name="'.$_name.'" type="text" size="60" value="'.$data.'" class="'.self::$required.'"/>
                        	<span class="note">'. __(self::$note) .'</span>
						</div>
						<div class="grid2">
                        	<a class="buttonS bRed" onclick="clean(\''.$name.'\')">'. __('Don\'t use image').'</a>
                        </div>
                    </div>';
		
		return self::$start.$result.self::$finish;
	} 
	
	public static function check($name, $data = 0)
	{
		if ($data == 1)
			self::$checked = 'checked="checked" ';	
		else
			self::$checked = NULL;
		
		if (self::$disabled)
			self::$disabled = 'disabled';
				
		if (self::$name)
			$_name = self::$name;
		else
			$_name = $name;
		
		if (self::$required)
			self::$required = 'required';
		
		$element = '<input type="checkbox" '.self::$checked.' name="'.$_name.'" id="'.$name.'" value="'.$data.'" class="'.self::$required.'" '.self::$disabled.'>';
		
		if (self::$only_element)
			return $element;
			
		$result = '	'.self::first_part($name).'
					'.self::second_part($element, '10 on_off');
		
		return self::$start.$result.self::$finish;		
	}
	

	/** Generates a select box
	 * 
	 * @category select box
	 * @param string $name
	 * @param array $data
	 * @param string selected_id
	 * @return string
	 */
	public static function select($name, $data, $selected_id = '')
	{
		if (self::$disabled)
			self::$disabled = 'disabled';
		
		if (self::$id)
			$id = self::$id;
		else
	    	$id = $name;
			
		if (self::$required)
			self::$required = 'required';
		
		if (self::$only_element)
		{
			$result = '	<select class="'.self::$required.' '.$name.'" id="'.$id.'" name="'.$name.'" '.self::$disabled.' style="width:350px;">';
	                        if (self::$default)
	                        	$result .= ' <option value="0">'.__('None').'</option>'; 
							
							for ($i=0; $i<count($data); $i++)
							{
								if ($data[$i]['id'] == $selected_id)
									$selected = 'selected';
								else
									$selected = '';
									
								$result .= ' <option '.$selected.' value="'.$data[$i]['id'].'">'.$data[$i]['value'].'</option>'; 
	                     	}
			$result .= '	</select>';
					
			return $result;
        }
		$result = '	'.self::first_part($name).'
                    <div class="grid10 searchDrop">
                        <select data-placeholder="'.__('Select').'" class="select '.self::$required.'" id="'.$id.'" name="'.$name.'" '.self::$disabled.' style="width:350px;" tabindex="2">';
                            if (self::$default)
                            	$result .= ' <option value="0">'.__('None').'</option>'; 
							
							for ($i=0; $i<count($data); $i++)
							{
								if ($data[$i]['id'] == $selected_id)
									$selected = 'selected';
								else
									$selected = '';
									
								$result .= ' <option '.$selected.' value="'.$data[$i]['id'].'">'.$data[$i]['value'].'</option>'; 
                         	}
							
                         $result .= '   
                        </select>
                        <div class="clear"></div>
                        <span class="note">'. __(self::$note) .'</span>
                    </div>';
	
		return self::$start.$result.self::$finish;
	}

	/** Generates a textarea
	 * 
	 * @category textarea
	 * 
	 * @param string $name
	 * @param array $data
	 * @return string
	 */
	public static function textarea($name, $data = '')
	{
		if (self::$disabled)
			self::$disabled = 'disabled';
			
		if (self::$name)
			$_name = self::$name;
		else
			$_name = $name;
		
		if (self::$required)
			self::$required = 'required';
		
		$element = '<textarea name="'.$_name.'" id="'.$name.'" class="'.self::$required.'" '.self::$disabled.'>'.$data.'</textarea>';
		
		if (self::$only_element)
			return $element;
			
		$result = '	'.self::first_part($name).'
					'.self::second_part($element);
		
		return self::$start.$result.self::$finish;
	} 
	
	/** Generates a textarea
	 * 
	 * @category ckeditor
	 * 
	 * @param string $name
	 * @param array $data
	 * @return string
	 */
	public static function editor($name, $data = '')
	{
		if (self::$label)
			$label = self::$label;
		else
	    	$label = $name;
		
		if (self::$name)
			$_name = self::$name;
		else
			$_name = $name;
		
		if (self::$required)
			self::$required = 'required';
		
		require_once('ckeditor/ckupload.php');
		
		$element = '<textarea class="ckeditor '.self::$required.'" id="ckeditor" name="'.$_name.'" rows="10" cols="80">'.$data.'</textarea>';
		
	    if (self::$only_element)
			return $element;
			
		$result = '	'.self::first_part($name).'
					'.self::second_part($element);
		
		return self::$start.$result.self::$finish;
	}
	
	/** Generates a img
	 * 
	 * @category image
	 * 
	 * @param string $name
	 * @param array $data
	 * @return string
	 */
	public static function img($name, $data)
	{
		$element = '<img src="'.$data.'" name="'.$name.'" id="'.$name.'">';
		
		if (self::$only_element)
			return $element;
			
		$result = '	'.self::first_part($name).'
					'.self::second_part($element);
		
		return self::$start.$result.self::$finish;
	}
	
	/** Generates a googlemap selector
	 * 
	 * @category map
	 * 
	 * @param string $name
	 * @return string
	 */
	public static function map($name)
	{
		if (self::$name)
			$_name = self::$name;
		else
			$_name = $name;
			
		if (self::$required)
			self::$required = 'required';
		?>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=tr"></script>
		<script type="text/javascript">
		var map;
		var marker;
		var geocoder;
		function initialize() 
		{
			geocoder = new google.maps.Geocoder();
			var latlng = new google.maps.LatLng($('#<?php echo $name;?>_lat').val() , $('#<?php echo $name;?>_lng').val());
			var myOptions = {
				zoom: <?php echo self::$zoom; ?>,
				center: latlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
			
			marker = new google.maps.Marker({
				position: latlng,
				map: map,
				icon: '<?php echo Routes::$base.'core/img/marker.png'; ?>'
			});
			
			google.maps.event.addListener(marker, 'dragend', function() {
				var pos=marker.getPosition();
				document.getElementById('<?php echo $name;?>_lat').value=pos.lat().toFixed(7);
				document.getElementById('<?php echo $name;?>_lng').value=pos.lng().toFixed(7);
			});
			// To add the marker to the map, call setMap();
			marker.setMap(map);
			marker.setDraggable(true);
		}
		
		$(document).ready(function()
		{
			initialize();
		});
		</script>
		<?php
		$element = '	<input type="hidden" id="'.$name.'_lat" name="'.$name.'_lat" placeholder="" value="'.self::$lat.'" class="'.self::$required.'">
                    	<input type="hidden" id="'.$name.'_lng" name="'.$name.'_lng" placeholder="" value="'.self::$lng.'" class="'.self::$required.'">
                		<div id="map_canvas" style="height: 400px; width: 100%;"></div>';
						
		if (self::$only_element)
			return $element;
			
		$result = '	'.self::first_part($name).'
					'.self::second_part($element);
		
		return self::$start.$result.self::$finish;
	}	

	/** Generates a date picker
	 * 
	 * @category date
	 * 
	 * @param string $name
	 * @param timestamp $data
	 * @return string
	 */
	public static function date($name, $data = 0)
	{
		global $site;
		
		if (self::$name)
			$_name = self::$name;
		else
			$_name = $name;
		
		if (self::$id)
			$id = self::$id;
		else
	    	$id = $name;
		
		if (empty($data))
			$data = $site['timestamp'];
		
		if (!is_numeric($data))
			$expire = date('Y-m-d', strtotime($data));
		else
			$expire = date('Y-m-d', $data);
		
		?>
		<script type="text/javascript">
		$(function() {
			$('#inlinedate_<?php echo $id; ?>').datepicker({
		        inline: true,
				showOtherMonths:true,
				onSelect: function(dateText, inst) {
					$(".inlinedate_<?php echo $id; ?>_value").val(dateText.substring(0, dateText.length-3));
				},
				defaultDate: '<?php echo $data; ?>000',
				dateFormat: '@'
		    });
		 });
		</script>
		<?php
		
		$element = '<div id="inlinedate_'.$id.'"></div>
                    <input type="hidden" class="inlinedate_'.$id.'_value" size="10" id="'.$id.'" name="'.$_name.'" value="'.$data.'"/>';
					
		if (self::$only_element)
			return $element;
			
		$result = '	'.self::first_part($name).'
					'.self::second_part($element);
		
		return self::$start.$result.self::$finish;
	}			

	/** Generates a time picker
	 * 
	 * @category time
	 * 
	 * @param string $name
	 * @return string
	 */	
	public static function time($name)
	{
		if (self::$name)
			$_name = self::$name;
		else
			$_name = $name;
		
		$element = '<input type="text" class="timepicker" size="10" id="'.$name.'" name="'.$_name.'" value="'.date('H:i:s', time()).'"/>';
					
		if (self::$only_element)
			return $element;
			
		$result = '	'.self::first_part($name).'
					'.self::second_part($element);
		
		return self::$start.$result.self::$finish;
	} 	
	
	/** Generates a color picker
	 * 
	 * @category color
	 * 
	 * @param string $name
	 * @param string $data
	 * @return string
	 */
	public static function color($name, $data = '#e62e90')
	{
		if (self::$name)
			$_name = self::$name;
		else
			$_name = $name;
		?>
		<script type="text/javascript">
		$(function() {
			$('.cPicker_<?php echo $name; ?>').ColorPicker({
				color: '<?php echo $data;?>',
				onShow: function (colpkr) {
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					$('.cPicker_<?php echo $name; ?> div').css('backgroundColor', '#' + hex);
					$('#color_<?php echo $name; ?>').val(hex);
				}
			});
		});
		</script>
		<?php
		$element = '<div class="cPicker_'.$name.'" id="cPicker">
                		<div style="background-color: '.$data.'"></div>
                		<input type="hidden" size="10" id="color_'.$name.'" name="'.$_name.'"/>
                		<span class="note">'. __(self::$note) .'</span>
                	</div>';
					
		if (self::$only_element)
			return $element;
			
		$result = '	'.self::first_part($name).'
					'.self::second_part($element, 10, false);
		
		return self::$start.$result.self::$finish;
	} 	
	/** Generates a label
	 * 
	 * @category label
	 * 
	 * @param string $name
	 * @param int $grid
	 * @return string
	 */
	public static function label($label, $grid = 12){
		$result = '	<div class="grid'.$grid.'">
						<label>'.$label.'</label>
					</div>';
		
		return self::$start.$result.self::$finish;
	}
	/** Generates a hidden text input
	 * 
	 * @category type="hidden"
	 * 
	 * @param string $name
	 * @param array $data
	 * @return string
	 */
	public static function hidden($name, $data = '')
	{
		if (self::$required)
			self::$required = 'required';
		
		$result = '<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.$data.'" class="'.self::$required.'">';
					
		return $result;
	} 
	
	/** Generates a warning message box
	 * 
	 * @category div
	 * 
	 * @param array $data
	 * @param string $type
	 * @return string
	 */
	public static $wrapper = false;
	
	public static function warning($data = 'Message', $type = 'Success')
	{
		switch ($type) {
			case 'yellow':
				$type = 'Warning';
				break;
			case 'blue':
				$type = 'Information';
				break;
			case 'green':
				$type = 'Success';
				break;
			case 'red':
				$type = 'Failure';
				break;		
			default:
				$type = 'Success';
				break;
		}
		
		if (self::$wrapper)
			echo '	<div class="wrapper">';
		
			echo '		<div class="fluid">
							<div class="grid12">
								<div class="nNote n'.$type.'">
									<p>'.__($data).'</p>
								</div>
							</div>
						</div>';
						
		if (self::$wrapper)
			echo '	</div>';
	}
}
/** Frequently used function to fill select box with possible language options
 * 
 * @return array 
 */
function format_langs_for_select()
{
	$values = langs();
	
	for ($i=0; $i<count($values); $i++)
	{
		$data[$i]['id'] = $values[$i]['lang_id'];
		$data[$i]['value'] = $values[$i]['lang_name'];	
	}
	return $data;
}
/** Frequently used function to fill select box with stored menus in database
 * 
 * @return array 
 */
function format_menus_for_select()
{
	$values = select('menus')->where('lang_id = '.$_SESSION['user_id'])->results();
	
	for ($i=0; $i<count($values); $i++)
	{
		$data[$i]['id'] = $values[$i]['menu_id'];
		$data[$i]['value'] = $values[$i]['menu_name'];	
	}
	return $data;
}
/** Frequently used function to fill select box with possible status options
 * 
 * @return array 
 */
function format_status_for_select()
{
	$values = select('status')->where('lang_id = '.$_SESSION['lang_id'])->results();
	
	for ($i=0; $i<count($values); $i++)
	{
		$data[$i]['id'] = $values[$i]['status_id'];
		$data[$i]['value'] = $values[$i]['status_name'];	
	}
	return $data;
}
/** Frequently used function to fill select box with possible input types
 * 
 * @return array 
 */
function format_types_for_select()
{
	$data[0]['id'] = 'text';
	$data[0]['value'] = 'text';
	$data[1]['id'] = 'pass';
	$data[1]['value'] = 'pass';
	$data[2]['id'] = 'browse';
	$data[2]['value'] = 'browse';
	$data[3]['id'] = 'finder';
	$data[3]['value'] = 'finder';
	$data[4]['id'] = 'check';
	$data[4]['value'] = 'check';
	$data[5]['id'] = 'select';
	$data[5]['value'] = 'select';
	$data[6]['id'] = 'textarea';
	$data[6]['value'] = 'textarea';
	$data[7]['id'] = 'editor';
	$data[7]['value'] = 'editor';
	$data[8]['id'] = 'map';
	$data[8]['value'] = 'map';
	$data[9]['id'] = 'date';
	$data[9]['value'] = 'date';
	$data[10]['id'] = 'time';
	$data[10]['value'] = 'time';
	$data[11]['id'] = 'color';
	$data[11]['value'] = 'color';
	$data[12]['id'] = 'hidden';
	$data[12]['value'] = 'hidden';	
	
	return $data;	
}
/** Frequently used function to fill select box with numbers from 0 to $j
 * 
 * @param int $j
 * @return array 
 */
function format_i($j = 9)
{
	for ($i=0; $i<$j; $i++)
	{
		$data[$i]['id'] = $i;
		$data[$i]['value'] = $i;
	}
	return $data;
}
/** Frequently used function to fill select box with selected words
 * 
 * @param string $s1
 * @param string $s2
 * @return array 
 */
function format_true_false($s1 = 'True', $s2 = 'False')
{
	$data[0]['id'] = 1;
	$data[0]['value'] = __($s1);
	$data[1]['id'] = 0;
	$data[1]['value'] = __($s2);
	
	return $data;
}
/** Frequently used function to fill select box with selected words
 * 
 * @param string $s1
 * @param string $s2
 * @return array 
 */
function format_string_string($s1 = 'True', $s2 = 'False')
{
	$data[0]['id'] = 1;
	$data[0]['value'] = __($s1);
	$data[1]['id'] = 2;
	$data[1]['value'] = __($s2);
	
	return $data;
}
/** Format cities by id for select box
 * 
 * @return array
 */
function format_cities_id_for_select()
{
	$values = select('data_cities')->results();
	
	for ($i=0; $i<count($values); $i++)
	{
		$data[$i]['id'] = $values[$i]['city_id'];
		$data[$i]['value'] = $values[$i]['city_name'];	
	}
	return $data;
}
/** Format cities by name for select box
 * 
 * @return array
 */
function format_cities_name_for_select()
{
	$values = select('data_cities')->results();
	
	for ($i=0; $i<count($values); $i++)
	{
		$data[$i]['id'] = $values[$i]['city_name'];
		$data[$i]['value'] = $values[$i]['city_name'];	
	}
	return $data;
}
/** Format shippings by id for select box
 * 
 * @return array
 */
function format_shippings_id_for_select()
{
	$values = select('shippings')->where('is_public = 1')->results();
	
	for ($i=0; $i<count($values); $i++)
	{
		$data[$i]['id'] = $values[$i]['shipping_id'];
		$data[$i]['value'] = $values[$i]['shipping_name'];	
	}
	return $data;
}
/** Serialize for categories
 * 
 * @return string
 */
function _categories_for_serialize($category_id = 0, $lang_id = 1, $child = 0)
{
	$rows = select('categories')->left('langs ON langs.lang_id = categories.lang_id')->where('parent_id = "'.$category_id.'" AND langs.lang_id = "'.$lang_id.'"')->order('category_order ASC')->results();
	
	if ($child)
		echo '<ol>';
	
	foreach($rows AS $row)
	{
		echo '<li id="list_'.$row['category_id'].'">
				<div>
					<span class="disclose"></span>'. $row['category_name'] .'
					<a href="'.Routes::$base.'admin/category/'.$row['category_sef'].'" title="'. __('Update').'" class="sortable_silme_tusu hover" style="right: 55px;"><img alt="" src="http://localhost/pervin/cms/design/images/icons/update.png"></a>
					<a href="javascript:void(0);" onClick="delete_from_database(\'categories\', '.$row['category_id'].', \'row\');" title="'. __('Delete') .'" class="sortable_silme_tusu hover"><img src="'.Routes::$base.'cms/design/images/icons/delete.png" alt="" /></a>
				</div>';
		_categories_for_serialize($row['category_id'], $lang_id, 1);
		echo '</li>';
	}
	if ($child)
		echo '</ol>';
}
/** Serialize for menu data
 * 
 * @return string
 */
function _menu_data_for_serialize($menu_id = 1, $menu_data_id = 0, $child = 0)
{
	$rows = select('menus')
				->left('menus_data ON menus_data.menu_id = menus.menu_id')
				->where('menus.menu_id = "'.$menu_id.'" AND menus_data.parent_id = "'.$menu_data_id.'"')
				->order('menus_data.menu_data_order ASC')
				->results();
				
	
	if ($child)
		echo '<ol>';
	
	foreach($rows AS $row)
	{
		echo '<li id="list_'.$row['menu_data_id'].'">
				<div>
					<span class="disclose"></span>'. $row['menu_data_name'] .'
					<a href="'.Routes::$base.'admin/menu-data/'.$row['menu_data_id'].'" title="'.__('Edit').'" class="sortable_silme_tusu hover" style="padding-right: 30px;"><img src="'.Routes::$base.'cms/design/images/icons/update.png" alt="" /></a>
					<a href="javascript:void(0);" onClick="delete_from_database(\'menus_data\', '.$row['menu_data_id'].', \'list\');" title="'. __('Delete') .'" class="sortable_silme_tusu hover"><img src="'.Routes::$base.'cms/design/images/icons/delete.png" alt="" /></a>
				</div>';
		_menu_data_for_serialize($row['menu_id'], $row['menu_data_id'], 1);
		echo '</li>';
	}
	if ($child)
		echo '</ol>';
}
/** Content of selectbox to select target attribute for a tag
 * 
 * @return array
 */
function _menu_target()
{
	$data[0]['id'] = '_self';
	$data[0]['value'] = __('menu_self');
	$data[1]['id'] = '_blank';
	$data[1]['value'] = __('menu_blank');
	/*
	$data[2]['id'] = '_parent';
	$data[2]['value'] = __('parent');
	$data[3]['id'] = '_top';
	$data[3]['value'] = __('top');
	*/
	
	return $data;
}
/** Content of selectbox which to use to select user auth level
 * 
 * @return array
 */
function _user_auth()
{
	$data[0]['id'] = 1;
	$data[0]['value'] = __('Users');
	$data[1]['id'] = 90;
	$data[1]['value'] = __('Test Users');
	$data[2]['id'] = 99;
	$data[2]['value'] = __('Editors');

	if (is_auth(100))
	{
		$data[3]['id'] = 100;
		$data[3]['value'] = __('Owner');
	}
	if (is_auth(101))
	{
		$data[4]['id'] = 101;
		$data[4]['value'] = __('Consultant');
	}
	if (is_auth(111))
	{	
		$data[5]['id'] = 111;
		$data[5]['value'] = __('Developer');
	}

	return $data;
}
