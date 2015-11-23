<?php
if (!is_auth(100))
	die();
?>
<div id="content">
	<div id="loading"><img src="<?php echo Routes::$base; ?>core/img/ajax-load.gif"><p><?php echo __('Loading'); ?></p></div>
	<div class="contentTop">
        <span class="pageTitle"><span class="icon-screen"></span><?php echo __('Administrator'). ' (cms v.'.$setting['ver_cms'].' - core v.'.$setting['ver_core'].')'; ?></span>
        <div class="fluid">	    
	        <!-- Search box -->
	        <div class="grid3" style="float:right;">
	        	<div class="searchLine" style="margin-top: 15px;">
	                <div class="relative">
	                    <input type="text" class="search-string" rel="show_search_results" title="search_results" placeholder="<?php echo __('Search'); ?>"/>
	                	<button type="submit" name="find" value="">
	                    	<span class="icos-search"></span>
	                	</button>
	                </div>
	                
	                <!-- Search results -->
	                <div class="sResults search_results none"></div>
	                
	           </div>
	        </div>	     
        </div>       
        <div class="clear"></div>
    </div>
     
    <!-- Breadcrumbs line -->
    <div class="breadLine">
        <div class="bc">
            <ul id="breadcrumbs" class="breadcrumbs">
                <?php echo breadcrumb(); ?>
            </ul>
        </div>
        
        <div class="breadLinks">
	        	
		</div>
			
        <div class="breadLinks">
        	<ul>
        		<?php
				if ($setting['multi_lang'])
				{
					echo '	<li id="menu1" class="dropdown">
								<a class="dropdown-toggle" href="#menu1" data-toggle="dropdown">'. __('Languages') .'<b class="caret"></b></a>
								<ul class="dropdown-menu" style="min-width: 140px">';
									foreach (langs() AS $res)
									{
										echo '	<li><a href="?lang='.$res['lang_code'].'"><img src="'.Routes::$base.'cms/lang/'.$res['lang_code'].'/flag.png" style="position:relative; float:left; padding-right:5px; " width="22">'.$res['lang_name'].'</a></li>';
									}
								echo '
								</ul>
							</li>';
				}
				?>
        		<li><a href="<?php echo Routes::$base ?>" target="_blank"><i class="icos-play"></i><span><?php echo __('Go to web site'); ?></span></a></li>
            </ul>
            <div class="clear"></div>
        </div>
    </div>
 
 	<?php
 	/** Call function by module name and check it's auth with func_run()
	 * 
	 */
	$module = new Modules();
 	$module->func_run('admin');	
 	?>	
</div>
<!-- End of page, everything will be working in func_run() -->
<?php
/* All functions which will be run by calling " Routes::$func " */
function admin()
{
	global $setting;
	
	echo   '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid6">
						<div class="whead">
							<h6>'.__('Welcome').' '.$_SESSION['user_name'].'</h6>
							<div class="clear"></div>
						</div>
						<div class="body">
							<ul>
								<div class="divider"></div>
								<li><strong>'.__('Count of users') .':</strong> '.count(select('users')->results()).'</li>
								<li><strong>'.__('Count of categories') .':</strong> '.count(select('categories')->results()).'</li>
								<li><strong>'.__('Count of contents') .':</strong> '.count(select('contents')->results()).'</li>
								<li><strong>'.__('Count of galleries') .':</strong> '.count(select('galleries')->results()).'</li>
								<li><strong>'.__('Count of langs') .':</strong> '.count(select('langs')->results()).'</li>
								<li><strong>'.__('Count of menus') .':</strong> '.count(select('menus')->results()).'</li>';
								
								if ((is_auth(111)) || ($setting['ecommerce'] == 'on'))
								{
									echo '	<div class="divider"></div>
											<li><strong>'.__('Count of products') .':</strong> '.count(select('products')->results()).'</li>
											<li><strong>'.__('Count of orders').':</strong> '.count(select('products_orders')->results()).'</li>';
								}
								
								echo '
								<div class="divider"></div>
								<li><strong>'.__('Count of modules').':</strong> '.count(select('modules')->results()).'</li>
								<li><strong>'.__('Count of routers').':</strong> '.count(select('routers')->results()).'</li>
							</ul>
							
							<div class="fluid">
								<div class="grid12">
								</div>
							</div>
						</div>
					</div>
			    
					<div class="widget grid6">
		                <div class="whead">
		                	<div class="titleOpt left">
								<a data-toggle="dropdown" href="#" style="border:none;">
									'.__('Calendar').' <i class="icon-pen right" style="padding:5px;"></i>
									<span class="clear"></span>
								</a>
								<ul class="dropdown-menu pull-left">
									<li><a class="" href="'.Routes::$base.'admin/calendar-events"><span class="icon-calendar"></span>'.__('My Calendar').'</a></li>
									<li><a class="" href="'.Routes::$base.'admin/calendar-event-new"><span class="icon-plus"></span>'. __('Add') .'</a></li>
								</ul>
							</div>
		                	<div class="clear"></div>
		                </div>
		                <div id="calendar"></div>
		            </div>
		            <div class="clear"></div>
		        </div>
			</div>';
}
/* Settings by group */
function configs()
{
	global $setting, $site;
	
	echo _Setting::add_setting();
	echo _Setting::edit_setting();
	
	echo '	<div class="wrapper">
				<div class="fluid">
					<div class="grid12">
						<form action="'.Routes::$current.'" method="post">      
							<div class="widget acc">';
							if (is_auth(111))
							{
								for ($i = 1; $i < 11; $i++)
								{
									switch ($i) {
										case 1:
										    $title = __('General');
										    break;
										case 2:
										    $title = __('Localization');
										    break;
										case 3:
										    $title = __('Contact');
										    break;
										case 4:
										    $title = __('Meta');
										    break;
										case 5:
										    $title = __('Additional codes');
										    break;
										case 6:
										    $title = __('Social media');
										    break;
										case 7:
										    $title = __('Google analitics');
										    break;
										case 8:
										    $title =  __('SMTP');
										    break;
										case 9:
										    $title = __('Image');
										    break;
										case 10:
										    $title = __('E-commerce');
										    break;
										}
									
									echo '	<div class="whead">
												<h6>'. $title .'</h6>
												<div class="clear"></div>
												</div>
							                <div class="menu_body">';
							                
							                foreach (_Setting::settings_by_group($i) AS $result)
											{
												if ($result['setting_auth'] <= $_SESSION['user_auth'])
												{
													echo '<div class="formRow" id="row_'.$result['setting_id'].'">
									                        <div class="grid3"><label>'. ucFirst(__($result['setting_name'])) .':</label></div>';
															
															if ($result['setting_value'] == 'on' || $result['setting_value'] == 'off')
																echo '<input type="hidden" name="'.$result['setting_name'].'" value="off"/>';
																
															if ($result['setting_value'] == 'on')
																echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" checked="checked" name="'.$result['setting_name'].'" /><span class="note">'.$result['setting_explanation'].'</span></div></div>';
															elseif ($result['setting_value'] == 'off')
								                				echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" name="'.$result['setting_name'].'" /><span class="note">'.$result['setting_explanation'].'</span></div></div>';
															else
																echo '<div class="grid8"><input type="text" name="'.$result['setting_name'].'" value="'.$result['setting_value'].'"/><span class="note">'.$result['setting_explanation'].'</span></div>';
															
															// Latelly added settings
															if ($result['setting_group'] == 0) 
																echo '<div class="grid1"><a class="tablectrl_small bRed" href="javascript:void(0);" onClick="delete_from_database(\'settings\', '.$result['setting_id'].', \'row\');" ><span class="iconb">'. __('Del') .'</span></a></div>'; 
															
									                echo '  <div class="clear"></div>
											              </div>'; 
										        }          
										    }
											echo '
											</div>';
										}
										echo '	<div class="whead">
													<h6>'. __('Others') .'</h6>
													<div class="clear"></div>
												</div>
								                <div class="menu_body">';
								                foreach (_Setting::settings_by_group(0) AS $result)
												{
													if ($result['setting_auth'] <= $_SESSION['user_auth'])
													{
														echo '<div class="formRow" id="row_'.$result['setting_id'].'">
										                        <div class="grid3"><label>'. ucFirst(__($result['setting_name'])) .':</label></div>';
																
																if ($result['setting_value'] == 'on' || $result['setting_value'] == 'off')
																	echo '<input type="hidden" name="'.$result['setting_name'].'" value="off"/>';
																	
																if ($result['setting_value'] == 'on')
																	echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" checked="checked" name="'.$result['setting_name'].'" /><span class="note">'.$result['setting_explanation'].'</span></div></div>';
																elseif ($result['setting_value'] == 'off')
									                				echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" name="'.$result['setting_name'].'" /><span class="note">'.$result['setting_explanation'].'</span></div></div>';
																else
																	echo '<div class="grid8"><input type="text" name="'.$result['setting_name'].'" value="'.$result['setting_value'].'"/><span class="note">'.$result['setting_explanation'].'</span></div>';
																
																// Sonradan eklenen ayarların tipi 0 dır
																if ($result['setting_group'] == 0) 
																	echo '<div class="grid1"><a class="tablectrl_small bRed" href="javascript:void(0);" onClick="delete_from_database(\'settings\', '.$result['setting_id'].', \'row\');" ><span class="iconb">'. __('Del') .'</span></a></div>'; 
																
										                echo '  <div class="clear"></div>
												              </div>'; 
											        }              
												}
												
												echo '
												</div>';	
									}
									else
									{
										// Not developers
										echo '	<div class="whead">
													<h6>'. __('Contact') .'</h6>
													<div class="clear"></div>
												</div>
								                <div class="menu_body">';
								                foreach (_Setting::settings_by_group(3) AS $result)
												{
													if ($result['setting_auth'] <= $_SESSION['user_auth'])
													{
														echo '<div class="formRow" id="row_'.$result['setting_id'].'">
										                        <div class="grid3"><label>'. ucFirst(__($result['setting_name'])) .':</label></div>';
																
																if ($result['setting_value'] == 'on' || $result['setting_value'] == 'off')
																	echo '<input type="hidden" name="'.$result['setting_name'].'" value="off"/>';
																	
																if ($result['setting_value'] == 'on')
																	echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" checked="checked" name="'.$result['setting_name'].'" /><span class="note">'.$result['setting_explanation'].'</span></div></div>';
																elseif ($result['setting_value'] == 'off')
									                				echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" name="'.$result['setting_name'].'" /><span class="note">'.$result['setting_explanation'].'</span></div></div>';
																else
																	echo '<div class="grid8"><input type="text" name="'.$result['setting_name'].'" value="'.$result['setting_value'].'"/><span class="note">'.$result['setting_explanation'].'</span></div>';
																
																// Additional settings will be in 0 group
																if ($result['setting_group'] == 0) 
																	echo '<div class="grid1"><a class="tablectrl_small bRed" href="javascript:void(0);" onClick="delete_from_database(\'settings\', '.$result['setting_id'].', \'row\');" ><span class="iconb">'. __('Del') .'</span></a></div>'; 
																
										                echo '  <div class="clear"></div>
												              </div>'; 
											        }     
												}
												echo '
												</div>	
												
												<div class="whead">
													<h6>'. __('Social media') .'</h6>
													<div class="clear"></div>
												</div>
								                <div class="menu_body">';
								                foreach (_Setting::settings_by_group(6) AS $result)
												{
													if ($result['setting_auth'] <= $_SESSION['user_auth'])
													{
														echo '<div class="formRow" id="row_'.$result['setting_id'].'">
										                        <div class="grid3"><label>'. ucFirst(__($result['setting_name'])) .':</label></div>';
																
																if ($result['setting_value'] == 'on' || $result['setting_value'] == 'off')
																	echo '<input type="hidden" name="'.$result['setting_name'].'" value="off"/>';
																	
																if ($result['setting_value'] == 'on')
																	echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" checked="checked" name="'.$result['setting_name'].'" /><span class="note">'.$result['setting_explanation'].'</span></div></div>';
																elseif ($result['setting_value'] == 'off')
									                				echo '<div class="grid8 on_off"><div class="floatL mr10"><input type="checkbox" name="'.$result['setting_name'].'" /><span class="note">'.$result['setting_explanation'].'</span></div></div>';
																else
																	echo '<div class="grid8"><input type="text" name="'.$result['setting_name'].'" value="'.$result['setting_value'].'"/><span class="note">'.$result['setting_explanation'].'</span></div>';
																
																// Sonradan eklenen ayarların tipi 0 dır
																if ($result['setting_group'] == 0) 
																	echo '<div class="grid1"><a class="tablectrl_small bRed" href="javascript:void(0);" onClick="delete_from_database(\'settings\', '.$result['setting_id'].', \'row\');" ><span class="iconb">'. __('Del') .'</span></a></div>'; 
																
										                echo '  <div class="clear"></div>
												              </div>'; 
											        }     
												}
												echo '
												</div>';
									}
						echo '	
							<div class="formRow" style="border-top:2px; margin-bottom: 25px;">
				            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
				            	<input class="buttonS bBlue formSubmit grid10" name="setting_edit" type="submit" value="'.__('Save').'">
				            </div>
						</div>
					</form>
				</div>
			</div>
		</div>';
		
		
		if (is_auth(111))
		{
		echo '
		<div class="wrapper">
			<div class="fluid">
				<div class="widget grid12">
					<div class="whead">
						<h6>'. __('New') .'</h6>
						<div class="clear"></div>
				  	</div>
				  	<div class="body">
		  				<form action="'.Routes::$current.'" method="post">
							<fieldset>
								'.Input::text('name').'
					    		'.Input::text('value').'
					    		'.Input::textarea('desc').'
					    		<div class="formRow">
					            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
			                    	<input class="buttonS bBlue formSubmit grid10" type="submit" name="setting_add" value="'. __('Add') .'">
			                    </div>
					        </fieldset>
				    	</form>
				    </div>
				</div>
			</div>
		</div>';
		}
}
/* Dynamic language variables */
function dynamic_variables()
{
	global $setting;
	
	$dyn_vars = new _Dynamic_variable();
	echo $dyn_vars->add_dynamic_variable();
	echo $dyn_vars->edit_dynamic_variable();
	
	$dynamic_vars = $dyn_vars->dynamic_variables();
	
	if (!empty($dynamic_vars))
	{
		echo '	<div class="wrapper"><div class="fluid"><div class="widget grid12">
					<div class="whead">
						<h6>'. __('Dynamic variables') .'</h6>
						<div class="clear"></div>
				  	</div>
				  	<div class="body">
				  		<form action="'.Routes::$current.'" method="post">
							<fieldset>';
			                foreach ($dynamic_vars AS $var)
							{
								echo '	<div class="formRow" id="row_'.$var['dynamic_var_id'].'">
					                        <div class="grid2">
					                        	<label>'. __($var['dynamic_var_key']) .' ('.$var['lang_code'].'):';
					                        
								            if (is_auth(111))
								            	echo '</br>"'.$var['dynamic_var_key'].'"';
								
											echo '</label>
											</div>';
											
											Input::$only_element = true;
											echo '<div class="grid9">'. Input::$var['dynamic_var_type']($var['dynamic_var_id'], $var['dynamic_var_value']) .'</div>';
											Input::$only_element = false;
											
											if ($var['is_erasable'] == 1)
												echo '<div class="grid1"><a class="tablectrl_small bRed" href="javascript:void(0);" onClick="delete_from_database(\'dynamic_vars\', '.$var['dynamic_var_id'].', \'row\');" ><span class="iconb">'. __('Del') .'</span></a></div>'; 
											
					        	echo '  	<div class="clear"></div>
							          	</div>';           
							}
							echo '	<div class="formRow">
						            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel').'">
						            	<input class="buttonS bBlue formSubmit grid10" name="edit_dyn_var" type="submit" value="'.__('Save').'">
						            </div>
			            	</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>';
	}

	echo '
	<div class="wrapper">
		<div class="fluid">
			<div class="widget grid12">
				<div class="whead">
					<h6>'. __('New') .'</h6>
					<div class="clear"></div>
		  		</div>
			  	<div class="body">
			  		<form action="'.Routes::$current.'" method="post">
						<fieldset>';
							echo Input::text('dynamic_var_key');
							echo Input::textarea('dynamic_var_value');
					   	
							Input::$default = false;
							
							echo Input::select('dynamic_var_type', format_types_for_select(), 1);
						
							if ($setting['multi_lang'])
								echo Input::select('lang_id', format_langs_for_select(), $_SESSION['lang_id']);
						
							echo '
				            <div class="formRow">
				            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel').'">
				            	<input class="buttonS bBlue formSubmit grid10" name="add_dyn_var" type="submit" value="'. __('Add').'">
				            </div>
				        </fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>';
}
/* Tables in database */
function datatables()
{
	global $pdo;
	
	$query = $pdo->query("SHOW TABLES");
	$tables = $query->fetch_array();
	foreach ($tables AS $t)
	{
		$table[] = array_values($t);
	}
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
			    			<h6>'.__('Tables in database').'</h6>
			    			<div class="clear"></div>
			    		</div>
		            
			            <div id="dyn" class="shownpars">
			                <a class="tOptions act" title="Options"><img src="'.Routes::$base.'cms/design/images/icons/options.png" alt="" /></a>
			                
			                <table cellpadding="0" cellspacing="0" border="0" class="dinamik_tablo tMedia" id="dynamic">
				                <thead>
					                <tr>
					                	<th>'. __('Name') .'</th>
						                <th>'. __('Actions') .' </th>
					                </tr>
				                </thead>
				                <tbody>';
									if (!empty($table))
									{
										foreach ($table AS $result){
											echo '<tr class="gradeX">
													<td>'.$result[0].' </td>
							                	  	<td class="center">
							                	  		<a href="'.Routes::$base.'admin/dynamic-table/'.$result[0].'" class="buttonM bBlue ml10">'. __('Rules') .'</a>
							                	  	</td>
							                      </tr>';
										}
									}    
						            echo '
					            </tbody>
			                </table> 
			            </div>
			            <div class="clear"></div>
					</div>
				</div>
			</div>';	
}
/** To view and update a dynamic table
 * 
 * Developer can manage rules of dynamic table besides that can add additional 
 * button with js events.
 */
function dynamic_table()
{
	$form = new Dynamic_forms();
	echo $form->edit_data_rule();
	
	$row = select('dynamic_tables')->where('dynamic_table_name = "'.Routes::$get[1].'" OR dynamic_table_id = "'.Routes::$get[1].'"')->result();
	
	if (empty($row)){
		$row['dynamic_table_name'] = Routes::$get[1];
	}
	else{
		$rules = json_decode($row['dynamic_table_rules'], true);
		$buttons = json_decode($row['dynamic_table_additional_buttons'], true);
	}

	$data = select($row['dynamic_table_name'])->result();
	$index = array_keys($data);
	
	
	echo '	<div class="wrapper">    
				    <div class="fluid">
				    	<div class="grid12">
				    		<div class="nNote nInformation">
					    		<p><strong>'. __('To use dynamic tables') .'</strong></br>'. __('First of all, create a new table in database') .'<br/> '.__('Secondly, insert one row dummy text').' <br/> '.__('Lastly, set rules to map columns of database table').'</p>
					    	</div>
				    	</div>
				    	<div class="clear">
				    	<div class="widget grid12">
				    		<div class="whead">
								<h6>'. __('Rules of dynamic table') .': '.$row['dynamic_table_name'].'</h6>
								<div class="clear"></div>
							</div>
						  	<ul class="tabs">
								<li class="activeTab"><a href="#1">'.__('General').'</a></li>	
								<li><a href="#2">'.__('Columns').'</a></li>
								<li><a href="#3">'.__('Buttons').'</a></li>
								<li><a href="#4">'.__('Links').'</a></li>
							</ul>
						  	<div class="tab_container">
						  		<form class="main" method="post" action="'. Routes::$current .'">';
									
									echo Input::hidden('table', @$row['dynamic_table_name']);
									
									echo '		
							  		<div id="1" class="tab_content" style="display: block;">
							  			<fieldset>';
											Input::$label = 'Title';
							  				echo Input::text('dynamic_table_title', @$row['dynamic_table_title']);
											
											Input::$label = 'Prefix';
											Input::$note = 'Prefix in the columns name as "coupon", "faq"';
											echo Input::text('dynamic_table_prefix', @$row['dynamic_table_prefix']);
											Input::$note = false;
											
											Input::$default = false;
											Input::$label = 'Will be in menu?';
											echo Input::select('is_inmenu', format_true_false('Yes', 'No'), @$row['is_inmenu']);
											
											Input::$label = 'Icon';
											Input::$note = 'Icon for menu item';
											echo Input::finder('dynamic_table_image', @$row['dynamic_table_image']);
											Input::$note = false;
											
											Input::$default = false;
											Input::$label = false;
											echo Input::select('is_public', format_true_false('Public', 'Not public'), @$row['is_public']);
											
											
											Input::$label = 'Column names for heading';
											Input::$note = 'Seperate with \',\' witout any spaces between items';
											echo Input::text('dynamic_table_th', @$row['dynamic_table_th']);
											Input::$label = 'Column names for data';
											echo Input::text('dynamic_table_td', @$row['dynamic_table_td']);
											Input::$note = false;
											
											echo '
											<div class="formRow">
										    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
								            	<input class="buttonS bBlue formSubmit grid10" type="submit" name="edit_data_rule" value="'. __('Edit') .'">
											</div>
										</fieldset>
							  		</div>
							  		<div id="2" class="tab_content" style="display: block;">
								  		<fieldset>';
											
											for ($i = 1; $i<count($index); $i++)
											{
												$is_done = 0;
												if (!empty($rules))
												{
													foreach ($rules AS $rule)
													{
														if ($rule['name'] == $index[$i])
														{
															echo Input::label('<strong>'.$index[$i].'</strong>');
																
															echo Input::hidden('name[]', $rule['name']);
															Input::$label = __('Type');
															echo Input::select('type_'.$index[$i], format_types_for_select(), $rule['type']);	
															Input::$label = __('Default data');
															echo Input::text('data_'.$index[$i], $rule['data']);	
															Input::$label = __('Note');
															echo Input::text('note_'.$index[$i], $rule['note']);	
															echo '<hr>';
															$is_done = 1;
														}
													}	
												}
												
												if (!$is_done)
												{
													Input::$default = true;
													Input::$label = false;
													
													echo Input::label('<strong>'.$index[$i].'</strong>');
													
													echo Input::hidden('name[]', $index[$i]);
													Input::$label = __('Type');
													echo Input::select('type_'.$index[$i], format_types_for_select());	
													Input::$label = __('Default data');
													echo Input::text('data_'.$index[$i]);	
													Input::$label = __('Note');
													echo Input::text('note_'.$index[$i], @$rule['note']);	
													echo '<hr>';
												}
											}
											echo '
										</fieldset>
									</div>
									<div id="3" class="tab_content" style="display: block;">';
										
										// detail button is on by default
										if (!isset($row['is_details_button'])){
											$row['is_details_button'] = 1;
										}
										echo Input::warning('Is Details button visible to show the details of row?');
										Input::$label = 'Details Button';
										echo Input::check('is_details_button', @$row['is_details_button']);
										
										echo Input::warning('You can add an extra button between details and delete buttons in the table for list view');
										
										Input::$label = 'Name';
										echo Input::text('additional_button_name', @$buttons['button_name']);
										
										Input::$label = 'External Link';
										echo Input::check('additional_button_external', @$buttons['is_external']);
										
										Input::$label = 'Link';
										echo Input::text('additional_button_href', @$buttons['button_href']);
										
										Input::$label = 'Event';
										Input::$note = 'Call onClick, onMouseOver event and type function name with params';
										echo Input::text('additional_button_event', @$buttons['button_event']);
										
										/*
										echo Input::$note = 'Type js function in here if it\'s not a global function';
										echo Input::textarea('additional_button_js_function');
										*/
										
									echo '
									</div>
									<div id="4" class="tab_content" style="display: block;">';
									
										if (isset($row['dynamic_table_title'])){
											echo Input::label('<strong>'.__('List').': </strong><a href="'. Routes::$base.'admin/dynamic-rows/'.$row['dynamic_table_name'].'">'. Routes::$base.'admin/dynamic-rows/'.$row['dynamic_table_name'].'</a>');
											echo Input::label('<strong>'.__('Item').': </strong><a href="'. Routes::$base.'admin/dynamic-row/'.$row['dynamic_table_name'].'/'.$row['dynamic_table_prefix'].'_id/#">'. Routes::$base.'admin/dynamic-row/'.$row['dynamic_table_name'].'/'.$row['dynamic_table_prefix'].'_id/#</a>');
											echo Input::label('<strong>'.__('New').': </strong><a href="'.Routes::$base.'admin/dynamic-new/'.$row['dynamic_table_name'].'">'. Routes::$base.'admin/dynamic-new/'.$row['dynamic_table_name'].'</a>');
											echo Input::label('<strong>'.__('Rules').': </strong><a href="'. Routes::$current.'">'. Routes::$current .'</a>');
										}
										
									echo '
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>';
}
/* Tables of database which have setted rules */
function dynamic_tables()
{
	$table = new Dynamic_forms();

	$table->data = select('dynamic_tables')->results();
	
	$table->title = __('Dynamic tables');
	$table->table = 'dynamic_tables';
	$table->link = 'dynamic-table';
								
	$table->th = array(0=>'name');	
	$table->td = array(0=>'dynamic_table_name');
					   								
	$table->data_list();
}
/* These functions create dynamic tables which is determined in dynamic_tables */
function dynamic_new()
{
	$form = new Dynamic_forms();
	$form->table = Routes::$get[1];
	
	$form->title = __('New');
	
	echo $form->add_data();
	echo $form->data_new();
}
function dynamic_row()
{
	$form = new Dynamic_forms();
	$form->table = Routes::$get[1];
	$form->id = Routes::$get[3];
	
	$form->title = Routes::$get[1];
	
	echo $form->edit_data();
	echo $form->data_row();
}
function dynamic_rows()
{
	$table = new Dynamic_forms();

	$table->rule = $table->rules();
	$table->data = $table->content();
	
	$table->table = $table->rule['dynamic_table_name'];
	$table->title = $table->rule['dynamic_table_title'];
	$table->link = 'dynamic-row/'.$table->table.'/'.$table->rule['dynamic_table_prefix'].'_id';
	
	$th = explode(',', $table->rule['dynamic_table_th']);						
	$table->th = $th;	
	
	$td = explode(',', $table->rule['dynamic_table_td']);				   
	$table->td = $td;
					   								
	$table->data_list();	
}
function module()
{
	$module = new _Module();
	$module->module_id = Routes::$get[1];
	
	echo $module->edit_module();
	
	$result = $module->_module();
	
	echo '
	<div class="wrapper">
		<div class="fluid">
			<div class="widget grid12">
				<div class="whead">
					<h6>'. __('Edit') .': '.$result['module_parent_folder'].'/'.$result['module_name'].'</h6>
					<div class="clear"></div>
				</div>
				<div class="body">
				  	<form class="main" enctype="multipart/form-data" method="post" action="'. Routes::$current .'">
						<fieldset>'.
							Input::select('module_auth', _user_auth(), $result['module_auth']).
							Input::text('module_header', $result['module_header']).
							Input::text('module_footer', $result['module_footer']).
							Input::text('view_cache', $result['view_cache']).
							Input::text('model_cache', $result['model_cache']).
							Input::text('header_cache', $result['header_cache']).
							Input::text('footer_cache', $result['footer_cache']);
							
							$visible_data[0]['id'] = 0;
							$visible_data[0]['value'] = __('visible_0');
							$visible_data[1]['id'] = 1;
							$visible_data[1]['value'] = __('visible_1');
							echo Input::select('is_visible', $visible_data, $result['is_visible']);
							
							$erase_data[0]['id'] = 0;
							$erase_data[0]['value'] = __('erasable_0');
							$erase_data[1]['id'] = 1;
							$erase_data[1]['value'] = __('erasable_1');
							echo Input::select('is_erasable', $erase_data, $result['is_erasable']);
							
							echo '
				            <div class="formRow">
				            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel'). '">
		                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Save'). '">
		                    </div>
				        </fieldset>
					</form>
				</div>
			</div>
	        <div class="clear"></div>
	    </div>				    
	</div>';	
}
function modules()
{
	$module = new _Module();
	
	echo $module->add_module();
	$modules = $module->modules();
	 
	echo '	<!-- Main content -->
			<div class="wrapper">    
				<div class="fluid">
					<div class="widget grid12">
						<div class="whead">
							<h6>'. __('Modules') .'</h6>
							<div class="clear"></div>
						</div>
						<div class="body">';
					
								foreach ($modules AS $result)
								{
									echo '<div class="formRow" id="row_'.$result['module_id'].'">
					                        <div class="grid1"><label>#'. $result['module_id']. '</label></div>
					                        <div class="grid2"><label>'. $result['module_parent_folder'].'/'.$result['module_name'].'</label></div>
					                        <div class="grid3 on_off">';
					                        	if ($result['is_visible'])
					                        		echo '<div class="floatL mr10"><input type="checkbox" id="check1" checked="checked" disabled onChange="gnc_veri_isle('.$result['module_id'].',\'gnc_yonetim_modul_durumunu_degistir\');"/>';
												else
													echo '<div class="floatL mr10"><input type="checkbox" id="check2" disabled onChange="gnc_veri_isle('.$result['module_id'].',\'gnc_yonetim_modul_durumunu_degistir\');"/>';
					                        	
					                        	echo '
				                            	</div>
					                        </div>
					                        <div class="grid4">
					                        	<label>'.$result['module_auth'].'</label>
					                        </div>
					                        <div class="grid1"><a href="'.Routes::$base.'admin/module/'.$result['module_id'].'" class="tablectrl_small bDefault ml10">'. __('Edit') .'</a></div>';
					                 
									 if ($result['is_erasable'])
									   echo '<div class="grid1"><a class="tablectrl_small bRed" href="javascript:void(0);" onClick="delete_from_database(\'modules\', '.$result['module_id'].', \'row\');" ><span class="iconb">'. __('Del') .'</span></a></div>';
					                 
					                 
					                 echo ' <div class="clear"></div>
							              </div>';     
								}			
					echo '	</div>
						</div>
					</div>
				</div>
				<div class="wrapper">
					<div class="fluid">
						<div class="widget grid12">
							<div class="whead">
								<h6>'. __('New') .'</h6>
								<div class="clear"></div>
							</div>
							<div class="body">
							  	<form class="main" enctype="multipart/form-data" method="post" action="'. Routes::$current .'">
									<fieldset>'.
										Input::text('module_name').
										Input::text('parent_folder', 'app').
										//Input::text('module_auth', 0).
										Input::select('module_auth', _user_auth()).
										Input::text('view_cache').
										Input::text('model_cache').
										Input::text('header_cache').
										Input::text('footer_cache').
										'
							            <div class="formRow">
							            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
					                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Add') .'">
					                    </div>
							        </fieldset>
								</form>
							</div>
						</div>
				        <div class="clear"></div>
				    </div>				    
				</div>';
}
function router_new()
{
	global $setting;
	
	$module = new _Module();
	$module->module_id = Routes::$get[1];
	
	echo $module->add_router();
	
	$result = $module->_module();
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
							<h6>'. __('New') .'</h6>
							<div class="clear"></div>
					  	</div>
					  	<div class="body">
						  	<form class="main" method="post" action="'. Routes::$current .'">
								<fieldset>';
								
									if ($setting['multi_lang'])
										echo Input::select('lang_id', format_langs_for_select(), $_SESSION['lang_id']);
									
									echo Input::select('module_id', $module->format_modules_for_select(), $result['module_id']);
									echo Input::text('router_name');
									
									echo '
									<div class="formRow">
								    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
						            	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Add') .'">
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>';
}
function routers()
{
	$module = new _Module();
	$routers = $module->routers();
	
	echo '	<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
				  		<div class="whead">
							<h6>'. __('Routers') .'</h6>
							<div class="clear"></div>
				  		</div>
						<div class="body">';
								$module_path = '';
								foreach ($routers AS $result)
								{
									echo '<div class="formRow" id="row_'.$result['router_id'].'">';
										if ($result['module_parent_folder'].'/'.$result['module_name'] != $module_path)
						                	echo '	<div class="grid2"><label><span class="icon-code"></span>'. $result['module_parent_folder']. '/'. $result['module_name']. '</label></div>
						                  			<div class="grid2"><a href="'.Routes::$base.'admin/router-new/'. $result['module_id'] .'" class="buttonM bDefault">'. __('New') .'</a></div>';
										else
										  	echo '	<div class="grid4"><label> </label></div>';
									  
									  	if (!empty($result['router_sef']))
									  		echo '	<div class="grid1"><label>'. $result['lang_code'].'</label></div>
					                      	  		<div class="grid6"><label><span class="icon-arrow"></span><a href="'.Routes::$base.$result['router_sef'].'">'. $result['router_sef'].'</a></label></div>';
									  	else
									  		echo '	<div class="grid7"><label> </label></div>';
										
					                  	if ($result['is_erasable'])
									  		echo '	<div class="grid1"><a class="tablectrl_medium bRed" href="javascript:void(0);" onClick="delete_from_database(\'routers\', '.$result['router_id'].', \'row\');" ><span class="iconb">'. __('Del') .'</span></a></div>';
					                  		
					                  		echo '	<div class="clear"></div>
							              </div>';    
									
									$module_path = $result['module_parent_folder']. '/'.$result['module_name']; 
								}	
								
				echo '	</div>
					</div>
		        	<div class="clear"></div>
		    	</div>				    
			</div>';	
}
function calendar_event()
{
	$c = new _Calendar();
	echo $c->edit_event();
		
	$c->event_id = Routes::$get[1];
	$event = $c->events();
	
	echo '	<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
							<h6>'. __('New') .'</h6>
							<div class="clear"></div>
					  	</div>
					  	<div class="body">
						  	<form class="main" method="post" action="'. Routes::$current .'">
								<fieldset>';
									// Array ( [title] => yeni event [text] => text [start] => 1414963920 [end] => 1415743200 [allday] => 0 [color] => 61374d [textColor] => 2e31e6 [lang_id] => 1 ) 
									echo Input::text('title', $event['title']);
									echo Input::text('text', $event['text']);
									echo Input::date('start', $event['start']);
									echo Input::time('start_time', date('h:i:s', $event['start']));
									echo Input::date('end', $event['end']);
									echo Input::time('end_time', date('h:i:s', $event['end']));
									$allday[0]['id'] = 0;
									$allday[0]['value'] = __('True');
									$allday[1]['id'] = 1;
									$allday[1]['value'] = __('False');
									Input::$default = false;
									echo Input::select('allday', $allday, $event['allday']);
									echo Input::text('url', $event['url']);
									
									//echo Input::color('color', $event['color']);
									//echo Input::color('textColor', $event['textColor']);
									$color[0]['id'] = '#5f9b1f';
									$color[0]['value'] = __('Green');
									$color[1]['id'] = '#336596';
									$color[1]['value'] = __('Blue');
									$color[2]['id'] = '#e89316';
									$color[2]['value'] = __('Orange');
									$color[3]['id'] = '#9c0e46';
									$color[3]['value'] = __('Dark Red');
									$color[4]['id'] = '#26397b';
									$color[4]['value'] = __('Dark Blue');
									echo Input::select('color', $color, $event['color']);
									echo Input::hidden('textColor', $event['textColor']);
									
									echo '
									<div class="formRow">
								    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
						            	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Edit') .'">
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>';	
}
function calendar_events()
{
	$c = new _Calendar();

	$table = new Dynamic_forms();

	$table->data = $c->events();
	
	$table->title = __('Events');
	$table->link = 'calendar-event';
	$table->table = 'calendars_events';
								
	$table->th = array(0=>'Event title', 
					   1=>'Event start',
					   2=>'URL');	
					   
	$table->td = array(0=>'title', 
					   1=>'start',
					   2=>'url');
					   								
	$table->data_list();	
}
function calendar_event_new()
{
	$c = new _Calendar();
	echo $c->add_event();
	
	echo '	<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
							<h6>'. __('New') .'</h6>
							<div class="clear"></div>
					  	</div>
					  	<div class="body">
						  	<form class="main" method="post" action="'. Routes::$current .'">
								<fieldset>';
								
									echo Input::text('title');
									echo Input::text('text');
									echo Input::date('start');
									echo Input::time('start_time');
									echo Input::date('end');
									echo Input::time('end_time');
									$allday[0]['id'] = 0;
									$allday[0]['value'] = __('True');
									$allday[1]['id'] = 1;
									$allday[1]['value'] = __('False');
									Input::$default = false;
									echo Input::select('allday', $allday);
									echo Input::text('url');
									
									//echo Input::color('color');
									//echo Input::color('textColor');
									
									$color[0]['id'] = '#5f9b1f';
									$color[0]['value'] = __('Green');
									$color[1]['id'] = '#336596';
									$color[1]['value'] = __('Blue');
									$color[2]['id'] = '#e89316';
									$color[2]['value'] = __('Orange');
									$color[3]['id'] = '#9c0e46';
									$color[3]['value'] = __('Dark Red');
									$color[4]['id'] = '#26397b';
									$color[4]['value'] = __('Dark Blue');
									echo Input::select('color', $color);
									echo Input::hidden('textColor', '#e0dddc');
									
									echo '
									<div class="formRow">
								    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
						            	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Add') .'">
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>';
}
function user()
{
	$u = new _User();
	
	echo $u->edit_user();
	
	$u->user_format = false;
	$u->user = Routes::$get[1];
	$user = $u->user_by_id();
	
	echo '	<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid8">
			    		<div class="whead">
							<h6>'. __('Edit') .'</h6>
							<div class="clear"></div>
					  	</div>
					  	<div class="body">
						  	<form class="main" method="post" action="'. Routes::$current .'">
								<fieldset>'.
								
									Input::text('email', $user['user_email']).
									Input::text('pass1').
									Input::text('pass2');
									
									Input::$default = false;
									echo Input::select('auth', _user_auth(), $user['user_auth']);
									
									echo 
									Input::text('name', $user['user_name']).
									Input::text('surname', $user['user_surname']).
									Input::finder('image', $user['user_img']).
									
									Input::textarea('user_about', $user['user_about']).'
									
									<div class="formRow">
								    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
						            	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Save') .'" name="edit_user">
									</div>
								</fieldset>
							</form>
						</div>
					</div>';
					
					$u->user_format = true;
					$user = $u->user_with_details_by_id();
					echo '
					<div class="widget grid4">
					    <div class="whead">
					    	<h6>'. __('Details') .'</h6>
					    	<div class="clear"></div>
					    </div>
	                    <ul class="niceList params">
	                        <li>
	                        	<div class="myPic"><img src="'.$user['user_img'].'" alt="" width="80" height="80"/></div>
	                            <div class="myInfo">
	                                <h5>'.$user['user_name'].' '.$user['user_surname'].'</h5>
	                                <span class="myRole">Auth level: '.$user['user_auth'].'</span>
	                                <span class="followers">IP: '.$user['user_ip'].'</span>
	                            </div>
	                            <div class="clear"></div>
	                        </li>
	                        <li>
	                            <label for="ch1"><span class="icon-clock"></span>'. __('Last seen').': '.$user['user_timestamp'].'</label>
	                            <div class="clear"></div>
	                        </li>';
							if (!empty($user['last_page']))
							{
								echo '
		                        <li>
		                            <label for="ch1"><span class="icon-newspaper"></span>'. __('Last page') .': <a href="'.$user['last_page'].'">'.str_replace(Routes::$base, '', $user['last_page']).'</a></label>
		                            <div class="clear"></div>
		                        </li>';
		                	}
							if (!empty($user['pages']))
							{
								foreach ($user['pages'] AS $page)
								{
									echo '  <li>
					                            <label for="ch1"><span class="icon-paper"></span>'. __('Most visit') .' ('.$page['count'].'): <a href="'.$page['url'].'">'.str_replace(Routes::$base, '', $page['url']).'</a></label>
					                            <div class="clear"></div>
					                        </li>';
					        	}
		                	}
						echo '
	                    </ul>
		            </div>   
				</div>
			</div>';
}
function user_new()
{
	$u = new _User();
	
	echo $u->add_user();
	
	echo '	<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
							<h6>'. __('New') .'</h6>
							<div class="clear"></div>
					  	</div>
					  	<div class="body">
						  	<form class="main" method="post" action="'. Routes::$current .'">
								<fieldset>'.
								
									Input::text('email').
									Input::text('pass1').
									Input::text('pass2');
									
									Input::$default = false;
									echo Input::select('auth', _user_auth());
									
									echo 
									Input::text('name').
									Input::text('surname').
									Input::finder('image').
									
									Input::textarea('user_about').'
									
									<div class="formRow">
								    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
						            	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Add') .'" name="add_user">
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>';
}
function users()
{
	$u = new _User();
	$users = $u->users();
	
	echo '	<div class="wrapper">    
				<div class="fluid">
			        <div class="widget grid8">
						<div class="whead">
				            <div class="whead"><h6>'. __('Users') .'</h6><div class="clear"></div></div>
				            <div id="dyn">
				                <a class="tOptions act" title="Options"><img src="'.Routes::$base.'/cms/design/images/icons/options.png" alt="" /></a>
				                
				                <table cellpadding="0" cellspacing="0" border="0" class="dinamik_tablo" id="dynamic">
					                <thead>
						                <tr>
							                <th>'. __('email') .'</th>
							                <th>'. __('Auth') .'</th>
							                <th>'. __('First name') .'</th>
							                <th>'. __('Surname') .'</th>
							                <th>'. __('Actions') .' </th>
						                </tr>
					                </thead>
					                <tbody>';
										
										foreach ($users AS $user)
										{
											if ($user['user_auth'] <= $_SESSION['user_auth'])
											{
											echo '	<tr class="gradeX" id="row_'.$user['user_id'].'">
														<td>'.$user['user_colored_email'].'</td>
														<td>'.$user['user_auth'].'</td>
														<td>'.$user['user_name'].'</td>
														<td>'.$user['user_surname'].'</td>
														<td class="center">
															<a href="'.Routes::$base.'admin/user/'.$user['user_id'].'" class="buttonM bDefault ml10">'. __('Edit') .'</a>';
															if ($_SESSION['user_auth'] >= $user['user_auth'])
															{
																// Ban or unban
																if ($user['is_active'] == 0)
																	echo '	<a href="javascript:void(0);" class="buttonM bGreen ml10" style="color:#fff" onClick="update_value(\'users\', \'is_active\', '.$user['user_id'].', 1, \'refresh\')">'. __('Activate') .'</a>';
																else
																	echo '	<a href="javascript:void(0);" class="buttonM bRed ml10" style="color:#fff" onClick="update_value(\'users\', \'is_active\', '.$user['user_id'].', 0, \'refresh\')">'. __('Ban') .'</a>';
																	
																// Delete
																echo '	<a href="javascript:void(0);" onClick="delete_from_database(\'users\', '.$user['user_id'].', \'row\');" class="buttonM bRed ml10" style="color:#fff">'. __('Del') .'</a>';
															}
															else
															{
																// Cant delete
																echo '	<a href="javascript:void(0);" class="buttonM bRed ml10 disabled" style="color:#fff" onClick="update_value(\'users\', \'is_active\', '.$user['user_id'].', 0)">'. __('Ban') .'</a>
																		<a href="javascript:void(0);" class="buttonM bRed ml10 disabled" style="color:#fff">'. __('Del') .'</a>';
															}
														echo '	
									                    </td>
													</tr>';
											}
										}
							                
							            echo '
						            </tbody>
				                </table> 
				            </div>
				            <div class="clear"></div> 
						</div>
					</div>';
					
					$u->user = $_SESSION['user_id'];
					$u->user_format = true;
					$user = $u->user_with_details_by_id();
					echo '
					<div class="widget grid4">
					    <div class="whead">
					    	<h6>'. __('Details') .'</h6>
					    	<div class="clear"></div>
					    </div>
	                    <ul class="niceList params">
	                        <li>
	                        	<div class="myPic"><img src="'.$user['user_img'].'" alt="" width="80" height="80"/></div>
	                            <div class="myInfo">
	                                <h5>'.$user['user_name'].' '.$user['user_surname'].'</h5>
	                                <span class="myRole">'. __('Auth').': '.$user['user_auth'].'</span>
	                                <span class="followers">IP: '.$user['user_ip'].'</span>
	                            </div>
	                            <div class="clear"></div>
	                        </li>
	                        <li>
	                            <label for="ch1"><span class="icon-clock"></span>'. __('Last seen') .': '.$user['user_timestamp'].'</label>
	                            <div class="clear"></div>
	                        </li>';
							if (!empty($user['last_page']))
							{
								echo '
		                        <li>
		                            <label for="ch1"><span class="icon-newspaper"></span>'. __('Last page') .': <a href="'.$user['last_page'].'">'.str_replace(Routes::$base, '', $user['last_page']).'</a></label>
		                            <div class="clear"></div>
		                        </li>';
		                	}
							if (!empty($user['pages']))
							{
								foreach ($user['pages'] AS $page)
								{
									echo '  <li>
					                            <label for="ch1"><span class="icon-paper"></span>'. __('Most visit').' ('.$page['count'].'): <a href="'.$page['url'].'">'.str_replace(Routes::$base, '', $page['url']).'</a></label>
					                            <div class="clear"></div>
					                        </li>';
					        	}
		                	}
						echo '
	                    </ul>
		            </div>   
					
					
				</div>
			 </div>';
			 
	function last_active_users($auth_level, $title)
	{
		$u = new User();
		$u->user_auth = $auth_level;
		$users = @$u->users_by_lastlogin();
		
		echo '	<div class="widget grid4">
					<div class="whead">
                    	<h6>'.$title.'</h6>
                    	<div class="clear"></div>
                	</div>
                    <table cellpadding="0" cellspacing="0" width="100%" class="tAlt wGeneral">
                        <thead>
                            <tr>
                                <td width="30">'.__('image').'</td>
                                <td>'.__('User').'</td>
                                <td width="20%">'.__('Last seen').'</td>
                                <td width="20%">'. __('Edit') .'</td>
                                <td width="20%">'. __('Del') .'</td>
                            </tr>
                        </thead>
                        <tbody>';
							if (!empty($users))
							{
								foreach ($users AS $user)
								{
									echo '	<tr>
				                                <td><a href="'.$user['user_img'].'" class="lightbox"><img src="'.$user['user_img'].'" alt="" width="32" height="32"/></a></td>
				                                <td><a href="'.Routes::$base.'admin/user/'.$user['user_id'].'" >'.$user['user_name'].' '.$user['user_surname'].'</a><a href="#" title="" class="email">'.$user['user_email'].'</a></td>
				                                
				                                <td align="center">'.$user['user_timestamp'].'</td>
												<td align="center"><a href="'.Routes::$base.'admin/user/'.$user['user_id'].'">'. __('Edit') .'</a></td>';
												
												if ($_SESSION['user_auth'] > $user['user_auth'])
													echo '	<td align="center"><a href="javascript:void(0);" onClick="delete_from_database(\'users\', '.$user['user_id'].', \'row\');">'. __('Del') .'</a></td>';
												else
													echo '	<td align="center">'.__('Can\'t delete').'</td>';
									echo '  </tr>';	
								}	
							}
                        echo '
                        </tbody>
                    </table> 
            	</div>  ';	
	}
	
	function not_activated_users($is_active = 0)
	{
		$u = new User();
		$u->user_is_active = $is_active;
		$users = @$u->users_by_active();
		
		echo '	<div class="widget grid4">
					<div class="whead">
                    	<h6>'. __('Unactivated users') .'</h6>
                    	<div class="clear"></div>
                	</div>
                    <table cellpadding="0" cellspacing="0" width="100%" class="tAlt wGeneral">
                        <thead>
                            <tr>
                                <td width="30">'.__('image').'</td>
                                <td>'.__('User').'</td>
                                <td width="20%">'.__('activate').'</td>
                                <td width="20%">'. __('Edit') .'</td>
                                <td width="20%">'. __('Del') .'</td>
                            </tr>
                        </thead>
                        <tbody>';
							if (!empty($users))
							{
								foreach ($users AS $user)
								{
									echo '	<tr id="is_active_'.$user['user_id'].'">
				                                <td><a href="'.$user['user_img'].'" title="" class="lightbox"><img src="'.$user['user_img'].'" alt="" width="32" height="32"/></a></td>
				                                <td><a href="'.Routes::$base.'admin/user/'.$user['user_id'].'">'.$user['user_name'].' '.$user['user_surname'].'</a><a href="#" title="" class="email">'.$user['user_email'].'</a></td>
				                                
				                                <td align="center"><a href="javascript:void(0);" onClick="update_value(\'users\', \'is_active\', '.$user['user_id'].', 1)">'. __('Activate') .'</a></td>
												<td align="center"><a href="'.Routes::$base.'admin/user/'.$user['user_id'].'">'. __('Edit') .'</a></td>';
												
												if ($_SESSION['user_auth'] > $user['user_auth'])
													echo '	<td align="center"><a href="javascript:void(0);" onClick="delete_from_database(\'users\', '.$user['user_id'].', \'row\');">'. __('Del') .'</a></td>';
												else
													echo '	<td align="center"></td>';
									echo '	</tr>';	
								}
							}
                        echo '
                        </tbody>
                    </table> 
            	</div>';	
	}

	echo '
	<div class="wrapper">     
		<div class="fluid">';	
			   
			
			last_active_users(' <= '.$_SESSION['user_auth'].' AND user_auth > 99', __('Last active editors'));
			last_active_users('= 1', __('Last active members'));
			not_activated_users(0); 
			
		echo '	
		</div>
	</div>';
}
function category()
{
	$blog = new _Blog();
	$blog->category = Routes::$get[1];
	$blog->category_id = $blog->category_sef_to_id(Routes::$get[1]);
	
	echo $blog->edit_category();
	
	$result = $blog->category();
	
	$blog->category = false;
	$categories = $blog->format_categories_for_select($blog->categories());
	
	echo '	<div class="wrapper">    
			<div class="fluid">
				<div class="widget grid12">
					<div class="whead">
						<h6>'.__('Category').': '.$result['category_name'] .'</h6>
						<div class="clear"></div>
			  		</div>
			  		<div class="body">
			  			<form class="main" enctype="multipart/form-data" method="post" action="'.Routes::$path.'">
							<fieldset>
								'.
								Input::hidden('category_id', $result['category_id']).
								// Category name
								Input::text('category_name', $result['category_name']).
								// Category image
								Input::finder('category_img', $result['category_img']).
								// Cateogries for parent
								Input::select('parent_id', $categories, $result['parent_id'])
								.'
								<div class="formRow">
						            <input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
				                    <input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Save') .'">
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>';
}
function category_new()
{
	global $setting;
	
	$blog = new _Blog();
	echo $blog->add_category();
	
	$blog->special_categories = 'is_special >= 0';
	$blog->category_id = Routes::$get[1];
	
	if (isset(Routes::$get[1]))
		$parents = $blog->sibling_categories(Routes::$get[1]);
	else
	{
		$blog->special_categories = 'is_special = 0';
		$parents = $blog->categories();
	}
		
	// Get the parent category
	$category = Routes::$get[1];
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
							<h6>'. __('New') .'</h6>
							<div class="clear"></div>
					  	</div>
					  	<div class="body">
						  	<form class="main" method="post" action="'. Routes::$current .'">
								<fieldset>';
								
									echo Input::text('category_name');
									echo Input::select('parent_id', $blog->format_categories_for_select($parents), $category);
									
									if ($setting['multi_lang'])
										echo Input::select('lang_id', format_langs_for_select(), $_SESSION['lang_id']);
									
									echo Input::finder('category_img');
									
									echo '
									<div class="formRow">
								    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
						            	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Add') .'">
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>';
}
function categories()
{
	global $setting, $site;
	
	$blog = new _Blog();
	$blog->category_id = Routes::$get[1];
	
	if (!empty($blog->category_id))
	{
		$categories = $blog->sibling_categories($blog->category_id);
	}
	else
	{
		$blog->special_categories = 'is_special = 0';
		$categories = $blog->categories();
	}
	
	echo $blog->add_category();
	
	$auth = _user_auth();
	
	echo '	<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
			    			<h6>'. __('Categories') .'</h6>
			    			<div class="clear"></div>
			    		</div>
			            <div id="dyn" class="hiddenpars">
			                <a class="tOptions" title="Options"><img src="'.Routes::$base.'cms/design/images/icons/options.png" alt="" /></a>
			                
			                <table cellpadding="0" cellspacing="0" border="0" class="dinamik_tablo" id="dynamic">
				                <thead>
					                <tr>
						                <th>'. __('Name') .'</th>
						                <th>'. __('Auth') .'</th>
						                <th>'. __('Parent category') .'</th>
						                <th>'. __('Lang') .'</th>
						                <th>'. __('Actions') .' </th>
					                </tr>
				                </thead>
				                <tbody>';
									foreach ($categories AS $result){
										echo '	<tr class="gradeX" id="row_'.$result['category_id'].'">
													<td>'.$result['category_name'].'</td>
													<td>'.$auth[$result['category_auth']]['value'].'</td>
													<td>'.$result['parent_name'].'</td>
													<td>'.@$result['lang_code'].'</td>
													<td class="center">';
														
														if ($blog->category_id == $setting['product_category_id'])
														echo '	<a href="'.Routes::$base.'admin/products/'.$result['category_id'].'" class="buttonM bDefault ml10">'. __('Products') .'</a>';
														echo '	<a href="'.Routes::$base.'admin/category/'.$result['category_sef'].'" 	 class="buttonM bDefault ml10">'. __('Details') .'</a>';
														if ($result['is_erasable'] == 1)
															echo '	<a href="javascript:void(0);" onClick="delete_from_database(\'categories\', '.$result['category_id'].', \'row\');" class="buttonM bRed ml10" style="color:#fff">'. __('Del') .'</a>';
								                   	echo '
												    </td>
												</tr>';
									}
						            echo '
					            </tbody>
			                </table> 
			            </div>
			            <div class="clear"></div> 
					</div>
				</div>
			</div>
		</div>';
}
function categories_order()
{
	global $setting;
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
						<h6>'. __('Categories') .'</h6>
						<div class="clear"></div>
					</div>
					<div class="body">';
					  
						if ($setting['multi_lang'])
						{
							?>
							<script>
							function categories_by_lang()
							{
								// HTML'deki verileri JS'ye al
								lang_id = $('#lang_id').val()
								// Ajax'a gönderilecek hale getir
								var veri = {
						    		lang_id: lang_id
						  		}  	
						  		$('#loading').fadeIn();
								$.ajax({
									url: ajax_cms+"categories_for_serialize",      
									type: "POST",       
									data: veri,   
									cache: false,
									success: function (response) {
										$('#serialize_categories').html(response);	 // Ajax'ın cevabını ekrana yazdır
										$(".select").chosen(); 										 // Gerekliyse ajax'tan gelen veri için kullanılacak jquery'i rebind et
										$('#loading').fadeOut();
										
										$('ol.sortable').nestedSortable({
											forcePlaceholderSize: true,
											handle: 'div',
											helper:	'clone',
											items: 'li',
											opacity: .6,
											placeholder: 'placeholder',
											revert: 250,
											tabSize: 25,
											tolerance: 'pointer',
											toleranceElement: '> div',
											maxLevels: 5,
									
											isTree: true,
											expandOnHover: 700,
											startCollapsed: true
										});
									
										$('.disclose').on('click', function() {
											$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
										})
									
										$('#serialize').on('click', function() {
											serialized = $('ol.sortable').nestedSortable('serialize');
											$('#serializeOutput').text(serialized+'\n\n');
											
											$('#loading').fadeIn();
											$.ajax({
												url: ajax_cms+"serialize_categories",
												type: "POST",       
												data: serialized,   
												cache: false,
												success: function (response) {
													$('#loading').fadeOut();
												}
											});	
										});
									}
								});
							}
							</script>
							<?php
							echo '
				            <div class="formRow">
				            	<div class="grid2"><label>'. __('Lang') .'</label></div>
			                    <div class="grid10 searchDrop">
			                        <select data-placeholder="'. __('Select') .'" class="select" id="lang_id" onChange="categories_by_lang();" style="width:350px;" tabindex="2">
			                            <option value=""></option>'; 
										foreach (langs() AS $result)
					                    	echo '<option value="'.$result['lang_id'].'">'.$result['lang_name'].'</option>'; 
			                        echo '    
			                        </select>
			                     </div>
			                     <div class="clear"></div>
				            </div>';
				        }
						else 
						{
							echo '<input type="hidden" name="lang_id" value="'.$setting['default_lang_id'].'"/>';	
						?>
							<script type="text/javascript">
							$(function() {	
								// HTML'deki verileri JS'ye al
								lang_id = <?php echo $setting['default_lang_id']; ?>
								// Ajax'a gönderilecek hale getir
								var veri = {
						    		lang_id: lang_id
						  		}  	
						  		$('#loading').fadeIn();
								$.ajax({
									url: ajax_cms+"categories_for_serialize",      
									type: "POST",       
									data: veri,   
									cache: false,
									success: function (response) {
										$('#serialize_categories').html(response);	 // Ajax'ın cevabını ekrana yazdır
										$(".select").chosen(); 										 // Gerekliyse ajax'tan gelen veri için kullanılacak jquery'i rebind et
										$('#loading').fadeOut();
										
										$('ol.sortable').nestedSortable({
											forcePlaceholderSize: true,
											handle: 'div',
											helper:	'clone',
											items: 'li',
											opacity: .6,
											placeholder: 'placeholder',
											revert: 250,
											tabSize: 25,
											tolerance: 'pointer',
											toleranceElement: '> div',
											maxLevels: 5,
									
											isTree: true,
											expandOnHover: 700,
											startCollapsed: true
										});
									
										$('.disclose').on('click', function() {
											$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
										})
									
										$('#serialize').on('click', function() {
											serialized = $('ol.sortable').nestedSortable('serialize');
											$('#serializeOutput').text(serialized+'\n\n');
											
											$('#loading').fadeIn();
											$.ajax({
												url: ajax_cms+"serialize_categories",
												type: "POST",       
												data: serialized,   
												cache: false,
												success: function (response) {
													$('#loading').fadeOut();
												}
											});	
										});
									}
								});
							});
							</script>
						<?php
						}
						echo '	<div id="serialize_categories"></div>
						</div>
					</div>
				</div>
			</div>';
}
function content()
{
	global $setting, $site;

	// Ckfinder ile dosya yüklemek için
	require_once('ckeditor/ckupload.php');
	
	$blog = new _Blog();
	
	echo $blog->edit_content();
	
	$blog->content_format = false;
	$blog->content = Routes::$get[1];
	$result = $blog->content();
	
	// Set content
	$blog->content_id = $result['content_id'];
	
	$blog->lang_id = $result['lang_id'];
	$blog->category_display_with_parent_name = true;
	if (isset($_REQUEST['category_group']))
	{
		$blog->group_id = $_REQUEST['category_group'];
		$categories_by_lang = $blog->categories_by_group();
	}
	else
	{
		$categories_by_lang = $blog->categories_by_lang();
	}
	$categories_of_content = $blog->categories_of_content();	

	$not_similar_contents = $blog->not_similars();
	$similar_contents = $blog->similars();
	
	$patterns = $blog->format_patterns_for_select($blog->patterns());
	$patterns_of_content = $blog->pattern_of_content();

	$album = new _Gallery();
	$galleries = $album->format_galleries_for_select($album->galleries_by_lang($result['lang_id']));
	$gallery = $blog->gallery_of_content();

	/* Selected categories of content */
	foreach ($categories_by_lang AS $category)
	{
		$array1[] = $category['category_id'];
		$category_names[$category['category_id']]['name'] = $category['category_name'];
	}	
	foreach ($categories_of_content AS $category)
		$array2[] = $category['category_id'];
	
	$macth_categories = array_intersect($array1, $array2);
	$diff_categories  = array_diff($array1, $array2);
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
							<h6>'. __('Content') .': '.Routes::$get[1].'</h6>
							<div class="clear"></div>
						</div>
						<div class="body">
							<form action="'.Routes::$path.'" class="main" method="post">
								<input type="hidden" name="content_id" value="'.$result['content_id'].'"/>
								<fieldset>';
									// Language id
									if ($setting['multi_lang'])
									{
										Input::$disabled = true;
										echo Input::select('lang_id',  format_langs_for_select(), $result['lang_id']);
									}
									Input::$disabled = false;
									
										
									echo Input::text('content_title', $result['content_title']);
									echo Input::editor('content_text', $result['content_text']);
									
									Input::$note = __('Summerize your content with 150-160 chars');
									echo Input::textarea('content_summary', $result['content_summary']);
									Input::$note = false;
									/*
									echo '
									<div class="formRow" style="height:300px;">
						                <div class="grid2"><label>'. __('Categories') .'</label></div>
						                <div class="grid10">
						                    <select multiple="multiple" class="multiple" title="" name="categories[]" style="height:280px;">';
												// Firstly display selected categories
												foreach ($macth_categories AS $category)
													echo '	<option value="'.$category.'" selected>'.$category_names[$category]['name'].'</option>';
												
												foreach ($diff_categories AS $category)
													echo '	<option value="'.$category.'">'.$category_names[$category]['name'].'</option>';
												
											echo '    
											</select>
											<span class="note">'.__('You can select multiple categories with ctrl').'</span>
										</div>
									</div>';
									*/
									
									echo '
									<div class="formRow" style="height:360px;">
						            	<div class="grid2"><label>'. __('Categories') .'</label></div>
						            	<div class="grid10 searchDrop">
						            		<div class="leftBox">
						                        <input type="text" id="box3Filter" class="boxFilter" placeholder="'. __('Filter') .'" /><button type="button" id="box3Clear" class="dualBtn fltr">x</button><br />
						                        
						                        <select id="box3View" multiple="multiple" class="multiple" style="height:300px;">';
						                        // Seçili içerikleri seçili olarak işaretle
						                        foreach ($diff_categories AS $category)
												{
													echo '<option value="'.$category.'">'.$category_names[$category]['name'].'</option>';
									        	}
												echo '
						                        </select>
						                        <br/>
						                        <!-- <span id="box3Counter" class="countLabel"></span> -->
						                        
						                        <div class="displayNone"><select id="box3Storage"></select></div>
						                    </div>
						                            
						                    <div class="dualControl">
						                        <button id="to4" type="button" class="dualBtn mr5 mb15">&nbsp;&gt;&nbsp;</button>
						                        <button id="allTo4" type="button" class="dualBtn">&nbsp;&gt;&gt;&nbsp;</button><br />
						                        <button id="to3" type="button" class="dualBtn mr5">&nbsp;&lt;&nbsp;</button>
						                        <button id="allTo3" type="button" class="dualBtn">&nbsp;&lt;&lt;&nbsp;</button>
						                    </div>
						                            
						                    <div class="rightBox">
						                        <input type="text" id="box4Filter" class="boxFilter" placeholder="'. __('Filter') .'" /><button type="button" id="box4Clear" class="dualBtn fltr">x</button><br />
						                        <select id="box4View" multiple="multiple" class="multiple" name="categories[]" style="height:300px;">';
						                        if (!empty($macth_categories))
							                        foreach ($macth_categories AS $category)
														echo '<option value="'.$category.'">'.$category_names[$category]['name'].'</option>';
						                        echo '
						                        </select><br/>
						                        <!-- <span id="box4Counter" class="countLabel"></span> -->
						                        
						                        <div class="displayNone"><select id="box4Storage"></select></div>
						                    </div>';
						                    echo '
						                    <div class="clear"></div>
						                    <span class="note">'.__('Double click to select similar contents').'</span>
						            	</div>
						            </div>';
									
									if (@$setting['content_similars'] != 'off')
									{
									echo '
									<div class="formRow" style="height:360px;">
						            	<div class="grid2"><label>'. __('Similar contents') .'</label></div>
						            	<div class="grid10 searchDrop">
						            		<div class="leftBox">
						                        <input type="text" id="box1Filter" class="boxFilter" placeholder="'. __('Filter') .'" /><button type="button" id="box1Clear" class="dualBtn fltr">x</button><br />
						                        
						                        <select id="box1View" multiple="multiple" class="multiple" style="height:300px;">';
						                        // Seçili içerikleri seçili olarak işaretle
						                        foreach ($not_similar_contents AS $not_similar)
													echo '<option value="'.$not_similar['content_id'].'">'.$not_similar['content_title'].'</option>';
						                        	
												echo '
						                        </select>
						                        <br/>
						                        <!-- <span id="box1Counter" class="countLabel"></span> -->
						                        
						                        <div class="displayNone"><select id="box1Storage"></select></div>
						                    </div>
						                            
						                    <div class="dualControl">
						                        <button id="to2" type="button" class="dualBtn mr5 mb15">&nbsp;&gt;&nbsp;</button>
						                        <button id="allTo2" type="button" class="dualBtn">&nbsp;&gt;&gt;&nbsp;</button><br />
						                        <button id="to1" type="button" class="dualBtn mr5">&nbsp;&lt;&nbsp;</button>
						                        <button id="allTo1" type="button" class="dualBtn">&nbsp;&lt;&lt;&nbsp;</button>
						                    </div>
						                            
						                    <div class="rightBox">
						                        <input type="text" id="box2Filter" class="boxFilter" placeholder="'. __('Filter') .'" /><button type="button" id="box2Clear" class="dualBtn fltr">x</button><br />
						                        <select id="box2View" multiple="multiple" class="multiple" name="similars[]" style="height:300px;">';
						                        // Seçili içerikleri seçili olarak işaretle
						                       	if (!empty($similar_contents))
							                        foreach ($similar_contents AS $similar)
														echo '<option value="'.$similar['content_id'].'">'.$similar['content_title'].'</option>';
						                        
												echo '
						                        </select><br/>
						                        <!-- <span id="box2Counter" class="countLabel"></span> -->
						                        
						                        <div class="displayNone"><select id="box2Storage"></select></div>
						                    </div>';
						                    echo '
						                    <div class="clear"></div>
						            	</div>
						            </div>';
						            }
						            
									// Maps
									if ($setting['content_has_location'] == 'on' && @$_REQUEST['map'] != 'no')
									{
										Input::$lng = $result['content_lng'];	
										Input::$lat = $result['content_lat'];
										
										echo Input::map('content_map');
									}
						            // Inline date picker
									echo Input::date('content_time', $result['content_time']);
									
									// Patterns
									?>
									<script>
									$(function() {	
										$('#pattern_id').on('change',function(){
											pattern_id = $(this).val();
											
											var veri = {
									    		pattern_id: pattern_id
									  		}  
											$('#loading').fadeIn();
											$.ajax({
												data: veri,
												url: ajax_cms+"content_pattern",
												type: "POST",       
												cache: false,
												success: function (response) {
													$('#content_patterns').html(response);	 // Ajax'ın cevabını ekrana yazdır
													$('#loading').fadeOut();
													$('#content_patterns').show();
												}
											});	
										});
									});
									</script>
									<?php
									if (@$_GET['pattern'] != 'no' && isset($patterns_of_content[0]['pattern_id']))
										echo Input::select('pattern_id',  $patterns, $patterns_of_content[0]['pattern_id']);
									
									echo '	<div id="content_patterns">';
									if (!empty($patterns_of_content))
									{
										foreach ($patterns_of_content AS $pattern)
										{
											Input::$name = 'pattern['.$pattern['pattern_data_id'].']';
											echo Input::$pattern['pattern_type']($pattern['pattern_data_key'], $pattern['content_pattern_value']);
											/*
											echo '	<div class="formRow">
														<div class="grid2">'.$pattern['pattern_data_key'].'</div>
														<div class="grid10"><input type="text" name="pattern['.$pattern['pattern_data_id'].']" value=""/></div>
										            	<div class="clear"></div>     
										          	</div>';	
											*/  	 
										}
									}
									echo '	</div>';
									Input::$name = false;
									
									// Related gallery
									if ($setting['content_add_gallery'] == 'on')
									{
							        	// Gallery of content
										echo Input::select('gallery_id', $galleries, $gallery['gallery_id']);	  	
									}
									// Images
									//echo Input::finder('content_img_c', $result['content_img_c']);
									Input::$note = __('Image dimension should be :thumb_w px and height :thumb_h px', array('thumb_w'=>$setting['thumb_w'], 'thumb_h'=>$setting['thumb_h']));
									echo Input::finder('content_img_t', $result['content_img_t'] );
									Input::$note = false;
									
									Input::$default = false;
									echo Input::select('is_home',  format_true_false('Anasayfa\'ya koy', 'Anasayfa\'ya koyma'), $result['is_home']);
									
									// SEO Option
									if ($setting['content_seo_mode'] == 'on')
									{
										echo '<hr>';
										echo Input::text('seo_title', $result['content_seo_title']);
										echo Input::text('seo_desc', $result['content_seo_desc']);
										echo Input::text('seo_author', $result['content_seo_author']);
										echo Input::text('seo_keywords', $result['content_seo_keywords']);
										echo Input::finder('seo_img', $result['content_seo_img']);
									}
									echo '
									<div class="formRow">
							            <div class="grid2">
											<div class="wButton">
												<a class="buttonL bRed first" href="'.Routes::$current.'">'. __('Cancel') .'</a>
											</div>
										</div>';
										
										if ($result['is_public'])
										{
											echo '
											<div class="grid2">
												<div class="wButton">
													<button type="submit" name="save_draft" class="buttonL bLightBlue first">'. __('Save as draft') .'</button>
												</div>
											</div>
											<div class="grid8">
												<div class="wButton">
													<button type="submit" name="save_content" class="buttonL bLightBlue first">'. __('Save') .'</button>
												</div>
											</div>';	
										}
										else
										{
											echo '
											<div class="grid2">
												<div class="wButton">
													<button type="submit" name="save_draft" class="buttonL bLightBlue first">'. __('Save as draft') .'</button>
												</div>
											</div>
											<div class="grid8">
												<div class="wButton">
													<button type="submit" name="save_content" class="buttonL bLightBlue first">'. __('Publish') .'</button>
												</div>
											</div>';		
										}

										
										
										echo '
									</div>
					    		</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>'; 
}
function content_new()
{
	global $setting, $site;

	// Ckfinder ile dosya yüklemek için
	require_once('ckeditor/ckupload.php');
	
	$blog = new _Blog();
	
	$blog->add_content();
	
	// Get Category sef to id
	if (!empty(Routes::$get[1]))
		$category_id = $blog->category_sef_to_id(Routes::$get[1]);
	
	// Pattern
	$pattern_id = Routes::$get[2];
	
	if (isset($_GET['pattern']))
		$blog->pattern_id = $_GET['pattern'];
	
	$blog->lang_id = $_SESSION['lang_id'];
	$blog->category_display_with_parent_name = true;
	if (isset($_REQUEST['category_group']))
	{
		$blog->group_id = $_REQUEST['category_group'];
		$categories_by_lang = $blog->categories_by_group();
	}
	else
	{
		$categories_by_lang = $blog->categories_by_lang();
	}
	
	$not_similar_contents = $blog->not_similars();
	
	$patterns = $blog->format_patterns_for_select($blog->patterns_by_lang());
	$patterns_of_content = $blog->pattern();
	
	$album = new _Gallery();
	$galleries = @$album->format_galleries_for_select($album->galleries_by_lang($_SESSION['lang_id']));

	if (!isset($_GET['pattern']))
		$_GET['pattern'] = 'yes';
	if (!isset($_GET['gallery']))
		$_GET['gallery'] = 'yes';
	
	Input::$required = true;
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
							<h6>'. __('New') .'</h6>
							<div class="clear"></div>
						</div>
						<div class="body">
							<form action="'.Routes::$path.'" class="main" method="post" id="usualValidate" novalidate="novalidate">
								<fieldset>';
									// Language id
									if ($setting['multi_lang'])
									{
										Input::$disabled = true;
										echo Input::select('lang_id',  format_langs_for_select(), $_SESSION['lang_id']);
									}
									Input::$disabled = false;
									
										
									echo Input::text('content_title');
									echo Input::editor('content_text');
									
									Input::$note = __('Summerize your content with 150-160 chars');
									echo Input::textarea('content_summary');
									Input::$note = false;
									
									
									if (isset($_REQUEST['categories']) && $_REQUEST['categories'] == 'no')
									{
										echo Input::hidden('categories[]', $category_id);	
									}
									else
									{
										/*
										echo '
										<div class="formRow" style="height:300px;">
							                <div class="grid2"><label>'. __('Categories') .'</label></div>
							                <div class="grid10">
							                    <select multiple="multiple" class="multiple" title="" name="categories[]" style="height:280px;">';
													// Seçili kategorileri seçili olarak işaretle
													$i = 0;
													foreach ($categories_by_lang AS $category)
													{
														if ($category['category_id'] == $category_id)
															$selected = 'selected';
														else
															$selected = '';
														
														$i++;
														
														echo '<option value="'.$category['category_id'].'" '.$selected.'>'.$category['category_name'].'</option>';
										        	}
										        echo '    
												</select>
												<span class="note">'.__('You can select multiple categories with ctrl').'</span>
											</div>
										</div>';	
										*/
										echo '
										<div class="formRow" style="height:360px;">
							            	<div class="grid2"><label>'. __('Categories') .'</label></div>
							            	<div class="grid10 searchDrop">
							            		<div class="leftBox">
							                        <input type="text" id="box3Filter" class="boxFilter" placeholder="'. __('Filter') .'" /><button type="button" id="box3Clear" class="dualBtn fltr">x</button><br />
							                        
							                        <select id="box3View" multiple="multiple" class="multiple" style="height:300px;">';
							                        // Seçili içerikleri seçili olarak işaretle
							                        foreach ($categories_by_lang AS $category)
													{
														echo '<option value="'.$category['category_id'].'">'.$category['category_name'].'</option>';
										        	}
													echo '
							                        </select>
							                        <br/>
							                        <!-- <span id="box3Counter" class="countLabel"></span> -->
							                        
							                        <div class="displayNone"><select id="box3Storage"></select></div>
							                    </div>
							                            
							                    <div class="dualControl">
							                        <button id="to4" type="button" class="dualBtn mr5 mb15">&nbsp;&gt;&nbsp;</button>
							                        <button id="allTo4" type="button" class="dualBtn">&nbsp;&gt;&gt;&nbsp;</button><br />
							                        <button id="to3" type="button" class="dualBtn mr5">&nbsp;&lt;&nbsp;</button>
							                        <button id="allTo3" type="button" class="dualBtn">&nbsp;&lt;&lt;&nbsp;</button>
							                    </div>
							                            
							                    <div class="rightBox">
							                        <input type="text" id="box4Filter" class="boxFilter" placeholder="'. __('Filter') .'" /><button type="button" id="box4Clear" class="dualBtn fltr">x</button><br />
							                        <select id="box4View" multiple="multiple" class="multiple" name="categories[]" style="height:300px;">
							                        </select><br/>
							                        <!-- <span id="box4Counter" class="countLabel"></span> -->
							                        
							                        <div class="displayNone"><select id="box4Storage"></select></div>
							                    </div>';
							                    echo '
							                    <div class="clear"></div>
							                    <span class="note">'.__('Double click to select similar contents').'</span>
							            	</div>
							            </div>';
									}
									
									// Similar contents
									if (@$setting['content_similars'] != 'off')
									{
										echo '
										<div class="formRow" style="height:360px;">
							            	<div class="grid2"><label>'. __('Similar contents') .'</label></div>
							            	<div class="grid10 searchDrop">
							            		<div class="leftBox">
							                        <input type="text" id="box1Filter" class="boxFilter" placeholder="'. __('Filter') .'" /><button type="button" id="box1Clear" class="dualBtn fltr">x</button><br />
							                        
							                        <select id="box1View" multiple="multiple" class="multiple" style="height:300px;">';
							                        // Seçili içerikleri seçili olarak işaretle
							                        foreach ($not_similar_contents AS $content)
													{
														echo '<option value="'.$content['content_id'].'">'.$content['content_title'].'</option>';
										        	}
													echo '
							                        </select>
							                        <br/>
							                        <!-- <span id="box1Counter" class="countLabel"></span> -->
							                        
							                        <div class="displayNone"><select id="box1Storage"></select></div>
							                    </div>
							                            
							                    <div class="dualControl">
							                        <button id="to2" type="button" class="dualBtn mr5 mb15">&nbsp;&gt;&nbsp;</button>
							                        <button id="allTo2" type="button" class="dualBtn">&nbsp;&gt;&gt;&nbsp;</button><br />
							                        <button id="to1" type="button" class="dualBtn mr5">&nbsp;&lt;&nbsp;</button>
							                        <button id="allTo1" type="button" class="dualBtn">&nbsp;&lt;&lt;&nbsp;</button>
							                    </div>
							                            
							                    <div class="rightBox">
							                        <input type="text" id="box2Filter" class="boxFilter" placeholder="'. __('Filter') .'" /><button type="button" id="box2Clear" class="dualBtn fltr">x</button><br />
							                        <select id="box2View" multiple="multiple" class="multiple" name="similars[]" style="height:300px;">
							                        </select><br/>
							                        <!-- <span id="box2Counter" class="countLabel"></span> -->
							                        
							                        <div class="displayNone"><select id="box2Storage"></select></div>
							                    </div>';
							                    echo '
							                    <div class="clear"></div>
							                    <span class="note">'.__('Double click to select similar contents').'</span>
							            	</div>
							            </div>';
							        }

									// Maps
									if ($setting['content_has_location'] == 'on' && @$_REQUEST['map'] != 'no')
										echo Input::map('content_map');
						            
						            // Inline date picker
						            echo Input::date('content_time');
									// Patterns
									?>
									<script>
									$(function() {	
										$('#pattern_id').on('change',function(){
											pattern_id = $(this).val();
											
											var veri = {
									    		pattern_id: pattern_id
									  		}  
											$('#loading').fadeIn();
											$.ajax({
												data: veri,
												url: ajax_cms+"content_pattern",
												type: "POST",       
												cache: false,
												success: function (response) {
													$('#content_patterns').html(response);	 // Ajax'ın cevabını ekrana yazdır
													$('#loading').fadeOut();
													$('#content_patterns').show();
												}
											});	
										});
									});
									</script>
									<?php
									
									if ($_GET['pattern'] != 'no')
									{
										Input::$note = __('You can use predefined patterns to enhance your content');
										echo Input::select('pattern_id', $patterns, $_GET['pattern']);
										Input::$note = false;
									}
										
									if (!empty($patterns_of_content))
									{
										echo '	<div id="content_patterns">';
										foreach ($patterns_of_content AS $pattern)
										{
											if (__('pattern['.$pattern['pattern_data_id'].']'))
												Input::$note = 'pattern['.$pattern['pattern_data_id'].']';
											
											Input::$required = false;
											Input::$note = $pattern['pattern_desc'];
											Input::$name = 'pattern['.$pattern['pattern_data_id'].']';
											echo Input::$pattern['pattern_type']($pattern['pattern_data_key']);
											Input::$note = false;
										}
										echo '	</div>';
									}
									else
									{
										echo '	<div id="content_patterns" class="none"></div>';	
									}
									Input::$name = false;
									
									// Related gallery
									if ($setting['content_add_gallery'] == 'on' && $_GET['gallery'] != 'no')
									{
							        	// Gallery of content
							        	echo Input::select('gallery_id', $galleries, $_GET['gallery']);
									}
									// Images
									Input::$required = false;
									//echo Input::finder('content_img_c');
									Input::$note = __('Image dimension should be :thumb_w px and height :thumb_h px', array('thumb_w'=>$setting['thumb_w'], 'thumb_h'=>$setting['thumb_h']));
									echo Input::finder('content_img_t');
									Input::$note = false;
									
									Input::$default = false;
									echo Input::select('is_home',  format_true_false('Anasayfa\'ya koy', 'Anasayfa\'ya koyma'), 0);
									
									// SEO Option
									if ($setting['content_seo_mode'] == 'on')
									{
										echo '<hr>';
										echo Input::text('seo_title');
										echo Input::text('seo_desc');
										echo Input::text('seo_author');
										echo Input::text('seo_keywords');
										echo Input::finder('seo_img');
									}
									
									echo '
									<div class="formRow">
							            <div class="grid2">
											<div class="wButton">
												<a class="buttonL bRed first">'.__('Cancel') .'</a>
											</div>
										</div>
					                    <div class="grid8">
											<div class="wButton">
												<button type="submit" name="save_content" class="buttonL bLightBlue first">'.__('Save') .'</button>
											</div>
										</div>
										<div class="grid2">
											<div class="wButton">
												<button type="submit" name="save_draft" class="buttonL bLightBlue first">'.__('Save as draft') .'</button>
											</div>
										</div>
									</div>
					    		</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>'; 
}
function contents()
{
	global $site;
	
	$blog = new _Blog();
	
	// Every contents or just in the given category
	if (isset($_REQUEST['category_group']))
	{
		$blog->category_group = $_REQUEST['category_group'];
		$contents = $blog->contents_by_category_group();
	}
	else 
	{
		if (isset(Routes::$get[1]))
			$blog->category = Routes::$get[1];
				
		if (is_auth(100)) { 
			$contents = $blog->contents();
		} else {
			$blog->author = $_SESSION['user_id'];
			$contents = $blog->contents_by_author();
		}

	}
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
			    			<h6>'.__('Contents').'</h6>
			    			<div class="clear"></div>
			    		</div>
		            
			            <div id="dyn" class="shownpars">
			                <a class="tOptions act" title="Options"><img src="'.Routes::$base.'cms/design/images/icons/options.png" alt="" /></a>
			                
			                <table cellpadding="0" cellspacing="0" border="0" class="dinamik_tablo tMedia" id="dynamic">
				                <thead>
					                <tr>
					                	<th>'. __('Image') .'</th>
						                <th>'. __('Title') .'</th>
						                <th>'. __('Category') .' </th>
						                <th>'. __('Lang') .' </th>
						                <th>'. __('Date') .' </th>
						                <th>'. __('Is_public') .' </th>
						                <th>'. __('Actions') .' </th>
					                </tr>
				                </thead>
				                <tbody>';
									if (!empty($contents))
									{
										foreach ($contents AS $result){
											echo '<tr class="gradeX" id="row_'.$result['content_id'].'">
													<td width="50"><img src="'.$result['content_img_t'].'" width="50"></td>
													<td style="min-width:200px;">'.$result['content_title'].'</td>
							                	  	<td>'.$result['category_name'].' </td>
							                	  	<td>'.$result['lang_code'].'  </td>
							                	  	<td>'.$result['content_date'].' </td>
							                	  	<td>'.$result['is_public'].' </td>
							                	  	<td class="center">
							                	  		<a href="'.Routes::$base.'admin/content/'.$result['content_sef'].$result['category_properties'].'" class="buttonM bBlue ml10">'. __('Edit') .'</a>';
							                	  		if ($result['is_erasable'] == 1 || is_auth(111))
							                      			echo '	<a href="javascript:void(0);" onClick="delete_content_from_database('.$result['content_id'].');" class="buttonM bRed ml10">'. __('Del') .'</a>';
							                      		echo '
							                      	</td>
							                      </tr>';
										}
									}    
						            echo '
					            </tbody>
			                </table> 
			            </div>
			            <div class="clear"></div>
					</div>
				</div>
			</div>';	
}
function contents_order()
{
	global $setting, $site;
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
						<h6>'. __('Order') .'</h6>
						<a class="buttonH bBlue" href="'.Routes::$base.'admin/content-new">'. __('New') .'</a>
						<div class="clear"></div>
					</div>
					<div class="body">';
					  
							
							if (!isset(Routes::$get[1]))
							{
								echo '
					            <div class="formRow">
					            	<div class="grid2"><label>'. __('Categories') .'</label></div>
				                    <div class="grid10 searchDrop">
				                        <select data-placeholder="'. __('Categories') .'" class="select" id="gnc_yonetim_kategori_sec" style="width:350px;" tabindex="2">
				                            <option value=""></option>'; 
											$resultlar = gnc_model_kategorilerin_hepsi();
											foreach ($resultlar AS $result)
				                            	echo '<option value="'.$result['kategori_id'].'">'.$result['kategori_adi'].'</option>'; 
				                        echo '    
				                        </select>
				                     </div>
				                     <div class="clear"></div>
					            </div>';
				            }
							else 
							{
								echo '<input type="hidden" id="gnc_yonetim_kategori_sec" value="'.Routes::$get[1].'">';	
								?>
								<script type="text/javascript">
								$(function() {	
									// Veritabanı bilgilerini
									tablo_adi = 'gnc_icerikler';
									eleman_adi = 'icerik';
									// Sıralama özellikleri
									kategori_sayisi = 1; // 1 olması alt kategori olmayacak anlamına gelir
									// HTML'deki verileri JS'ye al
									kategori_id = $('#gnc_yonetim_kategori_sec').val();
									// Ajax'a gönderilecek hale getir
									var veri = {
							    		kategori_id: kategori_id
							  		}  	
							  		$('#loading').fadeIn();
									$.ajax({
										url: ajax_adresi+"gnc_yonetim_icerik_siralama_icin_kategori_secimi",  // sistem/ajax.php dosyasındaki çağırılacak fonksiyonu yaz     
										type: "POST",       
										data: veri,   
										cache: false,
										success: function (response) {
											$('#gnc_yonetim_icerik_siralama_icin_kategori_secildi').html(response);	 // Ajax'ın cevabını ekrana yazdır
											$(".select").chosen(); 								 // Gerekliyse ajax'tan gelen veri için kullanılacak jquery'i rebind et
											$('#loading').fadeOut();
											
											$('ol.sortable').nestedSortable({
												forcePlaceholderSize: true,
												handle: 'div',
												helper:	'clone',
												items: 'li',
												opacity: .6,
												placeholder: 'placeholder',
												revert: 250,
												tabSize: 25,
												tolerance: 'pointer',
												toleranceElement: '> div',
												maxLevels: kategori_sayisi,
										
												isTree: false,
												expandOnHover: 700,
												startCollapsed: true
											});
										
											$('.disclose').on('click', function() {
												$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
											});
										
											$('#serialize').on('click', function() {
												serialized = $('ol.sortable').nestedSortable('serialize');
												$('#serializeOutput').text(serialized+'\n\n');
												
												$('#loading').fadeIn();
												$.ajax({
													url: ajax_adresi+"gnc_yonetim_serialize/"+tablo_adi+"/"+eleman_adi,
													type: "POST",       
													data: serialized,   
													cache: false,
													success: function (response) {
														$('#loading').fadeOut();
													}
												});	
											});
										}
									});	
								});
								</script>
								<?php
							}
							echo '
				            <div id="gnc_yonetim_icerik_siralama_icin_kategori_secildi"></div>
						</div>
					</div>
				</div>
			</div>';
}
function pattern()
{
	global $setting;
	
	$blog = new _Blog();
	echo $blog->edit_pattern();
	
	$blog->pattern_id = Routes::$get[1];
	$pattern = $blog->pattern();
	
	echo '	<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
							<h6>'. __('Pattern') .'</h6>
							<div class="clear"></div>
		  				</div>
		  				<div class="body">
		  					<form class="main" method="post" action="'.Routes::$current.'">
								<fieldset>
										<div class="formRow">
					                        <div class="grid2"><label>'. __('Name of pattern') . '</label></div>
					                        <div class="grid10"><input type="text" name="pattern_name" value="'.$pattern[0]['pattern_name'].'"/></div>
					                        <div class="clear"></div>     
					                    </div>';
										
					                    /* Language id
										if ($setting['multi_lang'])
											echo Input::select('lang_id', format_langs_for_select(), $pattern[0]['lang_id']);
										*/
										foreach($pattern AS $pattern_data)
										{
											echo '  <div class="formRow">
								                        <div class="grid2"><label class="alan_adi">'. __('Name') . '</label></div>
								                        <div class="grid2"><input type="text" name="pattern_keys['.$pattern_data['pattern_data_id'].']" value="'. $pattern_data['pattern_data_key'] . '"/></div>
								                        <div class="clear"></div>     
								                    </div>';
							            }
										echo '
										<div class="formRow">
							            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
					                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Save').'">
										</div>
							    </fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>';	
}
function pattern_new()
{
	global $setting;
	
	$blog = new _Blog();
	echo $blog->add_pattern();
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
							<h6>'. __('New') .'</h6>
							<div class="clear"></div>
		  				</div>
		  				<div class="body">
		  					<form class="main" method="post" action="'.Routes::$current.'">
								<fieldset>
										<div class="formRow">
					                        <div class="grid2"><label>'. __('Name of pattern') . '</label></div>
					                        <div class="grid10"><input type="text" name="pattern_name"/></div>
					                        <div class="clear"></div>     
					                    </div>';
										
					                    if ($setting['multi_lang'])
											echo Input::select('lang_id', format_langs_for_select(), $_SESSION['lang_id']);
									
										echo '
					                    <div class="formRow">
					                        <div class="grid2"><label class="alan_adi">'. __('Name') . '</label></div>
					                        <div class="grid2"><input type="text" name="pattern_keys[]"/></div>
					                        <div class="grid2">
												<div class="">
													<a class="sablona_yeni_alan_ekle buttonS bGreen first" title="" href="javascript:void(0)">'. __('Add') .'</a>
													<a style="display:none;" class="sablona_yeni_alan_sil buttonS bRed first" title="" href="javascript:void(0)">'. __('Del') .'</a>
												</div>
											</div>	
											<div class="clear"></div>     
					                    </div>
										<div id="pattern_data"></div>
										
										<div class="formRow">
							            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
					                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Save') .'">
										</div>
							    </fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>';
}
function patterns()
{
	global $site;
	
	$blog = new _Blog();
	$patterns = $blog->patterns();
	
	echo '	<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
			    			<h6>'.__('Patterns').'</h6>
			    			<div class="clear"></div>
			    		</div>
				        <div id="dyn" class="hiddenpars">
				            <a class="tOptions" title="Options"><img src="'.Routes::$base.'cms/design/images/icons/options.png" alt="" /></a>
				            
				            <table cellpadding="0" cellspacing="0" border="0" class="dinamik_tablo" id="dynamic">
				                <thead>
					                <tr>
						                <th>'. __('Name') .'</th>
						                <th>'. __('Actions') .' </th>
					                </tr>
				                </thead>
				                <tbody>';
									
										foreach ($patterns AS $result)
										{
											echo '<tr class="gradeX" id="row_'.$result['pattern_id'].'">
													<td>'.$result['pattern_name'].' </td>
							                	  	<td class="center">
							                	  		<a href="'.Routes::$base.'admin/pattern/'.$result['pattern_id'].'" class="buttonM bDefault ml10">'. __('Details') .'</a>';
							                      		if ($result['is_erasable'] == 1)
							                      			echo '	<a href="javascript:void(0);" onClick="delete_from_database(\'patterns\', '.$result['pattern_id'].', \'row\');" class="buttonM bRed ml10">'. __('Del') .'</a>';
							                      	echo '
							                      	</td>
							                      </tr>';
										}	
									
									echo '
					            </tbody>
				            </table> 
				        </div>
				        <div class="clear"></div>
					</div>
				</div>
			</div>';
}
function product()
{
	global $setting, $site;

	// Ckfinder ile dosya yüklemek için
	require_once('ckeditor/ckupload.php');
	
	// Create object for categorization
	$b = new _Blog();
	$b->category_id = $setting['product_category_id'];
	$categories = $b->sibling_categories($setting['product_category_id']);
	
	$p = new _Product();
	echo $p->edit_product();
	
	$p->product_id = Routes::$get[1];
	$p->format = false;
	$result = $p->product();
	
	$categories_of_product = $p->categories_of_product();
	
	$similars = $p->similars();
	$not_similars = $p->not_similars();
	
	$featured[0]['id'] = 0;
	$featured[0]['value'] = __('Not featured');
	$featured[1]['id'] = 1;
	$featured[1]['value'] = __('Featured');
	
	$manufacturers = $p->manufacturers_for_select();
	$taxes = $p->taxes_for_select();
	
	Input::$required = false;
	
	// Features of product
	$features = $p->features();
	$features_of_product = $p->features_of_product();
	
	/* Selected categories of content */
	foreach ($categories AS $category)
	{
		$array1[] = $category['category_id'];
		$category_names[$category['category_id']]['name'] = $category['category_name'];
	}	
	foreach ($categories_of_product AS $category)
		$array2[] = $category['category_id'];
	
	if (isset($array2))
	{
		$macth_categories = array_intersect($array1, $array2);
		$diff_categories  = array_diff($array1, $array2);
	}
	else 
	{
		$diff_categories = $array1;
	}
	
	echo '	<!-- Main content -->
			<div class="wrapper">    
				<form action="'.Routes::$path.'" class="main" method="post" id="usualValidate" novalidate="novalidate">
			        <div class="fluid">
						<div class="widget grid12">
							<div class="whead">
								<h6>'. __('Product') .': '. $result['name'] .'</h6>
								<div class="clear"></div>
							</div>';
							
							if ($setting['multi_lang'])
							{
								echo '	<ul class="tabs">';
											$i = 0;
											$class = 'class="activeTab"';
											foreach (langs() AS $l)
											{
												if ($i > 0)
													$class = '';
												
												echo '	<li '.$class.'><a href="#'.$l['lang_id'].'"><img src="'.Routes::$base.'cms/lang/'.$l['lang_code'].'/flag.png" style="margin-top: 6px; vertical-align: top;">'.$l['lang_name'].'</a></li>';	
												
												$i++;
											}
										echo '
										</ul>
										<div class="tab_container">';
											$i = 0;
											$style = 'style="display: block;"';
											foreach ($result['locals'] AS $l)
											{
												if ($i > 0)
													$class = 'style="display: none;"';
												
												echo '	<div id="'.$l['lang_id'].'" class="tab_content" '.$style.'>';
															//echo Input::text('product_name['.$l['lang_id'].']',$l['product_name']);
															echo '	<div class="formRow">
												                        <div class="grid2"><label>'. __('product_name['.$_SESSION['lang_id'].']') . '</label></div>
												                        <div class="grid10">
												                        	<input type="text" name="product_name['.$_SESSION['lang_id'].']" class="search-string" rel="search_possible_product" title="search_possible_product" placeholder="" value=""/>
												                        </div>
												                        <!-- Search results -->
									               						<div class="sResults search_possible_product none" style="left: 237px; width:283px; margin-top: 30px; position: absolute; z-index: 999;"></div>
												                        <div class="clear"></div>
														            </div>';
															echo Input::editor('product_text['.$l['lang_id'].']',$l['product_text']);
												echo '	</div>';
														
												$i++;
											}
										echo '
										</div>
										<div class="clear"></div>';
							}
							else 
							{
								echo '	<div class="body">
											<fieldset>';
												//echo Input::text('product_name['.$_SESSION['lang_id'].']',$result['locals'][0]['product_name']);
												echo '	<div class="formRow">
									                        <div class="grid2"><label>'. __('product_name['.$_SESSION['lang_id'].']') . '</label></div>
									                        <div class="grid10">
									                        	<input type="text" name="product_name['.$_SESSION['lang_id'].']" class="search-string" rel="search_possible_product" title="search_possible_product" placeholder="" value="'.$result['locals'][0]['product_name'].'"/>
									                        </div>
									                        <!-- Search results -->
						               						<div class="sResults search_possible_product none" style="left: 237px; width:283px; margin-top: 30px; position: absolute; z-index: 999;"></div>
									                        <div class="clear"></div>
											            </div>';
												echo Input::editor('product_text['.$_SESSION['lang_id'].']',$result['locals'][0]['product_text']);
											echo '	
											</fieldset>
										</div>';	
							}
						echo '
						</div>
					</div>
				    
				    <div class="fluid">
				    	<div class="widget grid12">
				    		<div class="whead">
								<h6>'. __('Details') .'</h6>
								<div class="clear"></div>
							</div>
							<ul class="tabs">
								<li class="activeTab"><a href="#product_details">'.__('General').'</a></li>
								<li><a href="#product_sale">'.__('Sale').'</a></li>
								<li><a href="#product_images">'.__('Image').'</a></li>';
								if ($setting['content_seo_mode'] == 'on')
									echo '<li><a href="#product_seo">'.__('SEO').'</a></li>';
								if ($setting['product_has_features'] == 'on')
									echo '<li><a href="#product_features">'.__('Features').'</a></li>';
								if ($setting['product_detailed_pricing'] == 'on')
									echo '<li><a href="#detailed_pricing">'.__('Different prices').'</a></li>';
							echo '
							</ul>
							<div class="tab_container">
								<div id="product_details" class="tab_content" style="display: block;">';
									Input::$default = false;
									echo Input::select('featured', $featured, $result['general']['is_featured']);
									echo Input::select('is_public', format_true_false('Public', 'Not public'), $result['general']['is_public']);
									
									echo Input::select('manufacturer', $manufacturers, $result['general']['manufacturer_id']);
									
									echo Input::text('price',$result['general']['product_price']);
									echo Input::select('tax', $taxes, $result['general']['tax_id']);
									
									Input::$note = __('cm');
									echo Input::text('length', $result['general']['product_l']);
									echo Input::text('width', $result['general']['product_w']);
									echo Input::text('height', $result['general']['product_h']);
									Input::$note = __('kg');
									echo Input::text('weight', $result['general']['product_weight']);
									Input::$note = false;
									
									echo Input::text('stock_amount', $result['general']['product_stock_amount']);
									echo Input::text('code', $result['general']['product_code']);
									
									echo '
									<div class="formRow" style="height:300px;">
						                <div class="grid2"><label>'. __('Categories') .'</label></div>
						                <div class="grid10">
						                    <select multiple="multiple" class="multiple" title="" name="categories[]" style="height:280px;">';
												// Firstly display selected categories
												foreach ($macth_categories AS $category)
													echo '	<option value="'.$category.'" selected>'.$category_names[$category]['name'].'</option>';
												
												foreach ($diff_categories AS $category)
													echo '	<option value="'.$category.'">'.$category_names[$category]['name'].'</option>';
												
											echo '    
											</select>
										</div>
									</div>
									<div class="formRow" style="height:360px;">
						            	<div class="grid2"><label>'. __('Similar contents') .'</label></div>
						            	<div class="grid10 searchDrop">
						            		<div class="leftBox">
						                        <input type="text" id="box1Filter" class="boxFilter" placeholder="'. __('Filter') .'" /><button type="button" id="box1Clear" class="dualBtn fltr">x</button><br />
						                        
						                        <select id="box1View" multiple="multiple" class="multiple" style="height:300px;">';
						                        // Seçili içerikleri seçili olarak işaretle
						                        foreach ($not_similars AS $product)
												{
													echo '<option value="'.$product['product_id'].'">'.$product['product_name'].'</option>';
									        	}
												echo '
						                        </select>
						                        <br/>
						                        <!-- <span id="box1Counter" class="countLabel"></span> -->
						                        
						                        <div class="displayNone"><select id="box1Storage"></select></div>
						                    </div>
						                            
						                    <div class="dualControl">
						                        <button id="to2" type="button" class="dualBtn mr5 mb15">&nbsp;&gt;&nbsp;</button>
						                        <button id="allTo2" type="button" class="dualBtn">&nbsp;&gt;&gt;&nbsp;</button><br />
						                        <button id="to1" type="button" class="dualBtn mr5">&nbsp;&lt;&nbsp;</button>
						                        <button id="allTo1" type="button" class="dualBtn">&nbsp;&lt;&lt;&nbsp;</button>
						                    </div>
						                            
						                    <div class="rightBox">
						                        <input type="text" id="box2Filter" class="boxFilter" placeholder="'. __('Filter').'" /><button type="button" id="box2Clear" class="dualBtn fltr">x</button><br />
						                        <select id="box2View" multiple="multiple" class="multiple" name="similars[]" style="height:300px;">';
						                        // Seçili içerikleri seçili olarak işaretle
						                       	if (!empty($similars))
							                        foreach ($similars AS $similar)
														echo '<option value="'.$similar['product_id'].'">'.$similar['product_name'].'</option>';
														
												echo '
												</select>
						                        <br/>
						                        <!-- <span id="box2Counter" class="countLabel"></span> -->
						                        <div class="displayNone"><select id="box2Storage"></select></div>
						                    </div>';
						                    echo '
						                    <div class="clear"></div>
						            	</div>
						            </div>';
									// Inline date picker
									if ($setting['product_has_expiration_date'] == 'on')
						            	echo Input::date('expire', $result['general']['product_expire']);
									
									// Images
									echo Input::finder('img_c', $result['general']['product_img_c']);
									echo Input::finder('img_t', $result['general']['product_img_t']);
									
									// Video
									Input::$note = 'Type iframe code';
									echo Input::textarea('video', $result['general']['product_video']);
									Input::$note = false;
								echo '
								</div>
								<div id="product_sale" class="tab_content" style="display: none;">'; 
									Input::$required = false;
									echo @Input::text('sale_price', $result['general']['sale_price']);
									echo @Input::date('sale_start', $result['general']['sale_start']);
									echo @Input::date('sale_expire', $result['general']['sale_expire']);
								echo '
								</div>
								<div id="product_images" class="tab_content" style="display: none;">'; 
									Input::$required = false;
									Input::$label = __('image');
									$images = array_values($result['images']);
									for ($i = 0; $i < $setting['product_img_count']; $i++)
										echo Input::finder('product_img['.$i.']', @$images[$i]['product_img_path']);
										
									Input::$label = false;
								echo '
								</div>';
								if ($setting['content_seo_mode'] == 'on')
								{
									Input::$required = false;
									echo '	<div id="product_seo" class="tab_content" style="display: none;">';
												echo Input::text('seo_title', $result['general']['product_seo_title']);
												echo Input::text('seo_desc', $result['general']['product_seo_desc']);
												echo Input::text('seo_author', $result['general']['product_seo_author']);
												echo Input::text('seo_keywords', $result['general']['product_seo_keywords']);
												echo Input::finder('seo_img', $result['general']['product_seo_img']);
									echo '	</div>';
								}
								if ($setting['product_has_features'] == 'on')
								{
									echo '	<div id="product_features" class="tab_content" style="display: none;">';
												foreach($features AS $feature)
												{
													if ($features_of_product)
													{
														foreach ($features_of_product AS $feature_of_product)
														{
															if ($feature['feature_id'] == $feature_of_product['feature_id'])
																Input::$checked = true;
															else
																Input::$checked = false;
														}
													}
													Input::$label = '-1';
													Input::$note = $feature['feature_text'];
													echo Input::check('features[]', $feature['feature_id'], $feature['feature_name']);	
												}
									echo '	</div>';	
								}
								if ($setting['product_detailed_pricing'] == 'on')
								{
									Input::$required = false;
									echo '	<div id="detailed_pricing" class="tab_content" style="display: none;">
												<div id="detailed_pricing_note" class="wrapper">  
													<div class="fluid">
												    	<div class="grid12">
														    <ul class="wInvoice">
																<li>
																	<p class="green"><strong>'.__('detailed_price_info').'</strong></p>
																</li>
																<li>
																	<a class="buttonL bLightBlue first" title="" href="javascript:void(0);" onClick="price_range_new();">'.__('price_range_new').'</a>
																</li>
															</ul>
														</div>
													</div>
												</div>
												
												<div id="price_ranges"></div>';
												
									echo '	</div>';
								}
							echo '
							</div>
							<div class="clear"></div>
							
				    		<div class="body">
								<fieldset>
									<div class="formRow">
							            <div class="grid2">
											<div class="wButton">
												<a class="buttonL bRed first">'. __('Cancel') .'</a>
											</div>
										</div>
					                    <div class="grid10">
											<div class="wButton">
												<button type="submit" name="save_content" class="buttonL bLightBlue first">'. __('Save') .'</button>
											</div>
										</div>
									</div>
					    		</fieldset>
							</div>
						</div>
					</div>
				</form>
			</div>'; 
}
function product_new()
{
	global $setting, $site;

	// Ckfinder ile dosya yüklemek için
	require_once('ckeditor/ckupload.php');
	
	// Create object for categorization
	$b = new _Blog();
	$b->category_id = $setting['product_category_id'];
	$categories = $b->sibling_categories($setting['product_category_id']);
	
	$p = new _Product();
	
	$not_similars = $p->not_similars();
	
	$featured[0]['id'] = 0;
	$featured[0]['value'] = __('Not featured');
	$featured[1]['id'] = 1;
	$featured[1]['value'] = __('Featured');
	
	$manufacturers = $p->manufacturers_for_select();
	$currencies = $p->currencies_for_select();
	$taxes = $p->taxes_for_select();
	
	$features = $p->features();
	
	Input::$required = false;

	echo $p->add_product();
	
	if (isset(Routes::$get[1]) && Routes::$get[1] == 'bot')
	{
		$bot = bot_for_product();
	
		if (!strpos(Routes::$get[4], 'erkek') || !strpos(Routes::$get[4], 'homme'))
			$category_id = 120;
		else
			$category_id = 121;
		
		echo '<div class="wrapper"><form action="'.Routes::$path.'"><div class="fluid"><div class="widget grid12">';
		echo Input::hidden('bot','yes');
		echo Input::text('manufacturer', @Routes::$get[2]);
		echo Input::text('manufacturer_name', @Routes::$get[3]);
		echo Input::text('url');
		echo '	<div class="body">
					<fieldset>
						    <div class="grid2">
								<div class="wButton">
									<a class="buttonL bRed first">'. __('Cancel') .'</a>
								</div>
							</div>
		                    <div class="grid10">
								<div class="wButton">
									<button type="submit" name="save_content" class="buttonL bLightBlue first">'. __('Refresh') .'</button>
								</div>
							</div>
					</fieldset>
				</div>';
		echo '</div></div></form></div>';
	}
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <form action="'.Routes::$path.'" class="main" method="post" id="usualValidate" novalidate="novalidate">
			        <div class="fluid">
						<div class="widget grid12">
							<div class="whead">
								<h6>'. __('New product') .' - '. __('Local') .'</h6>
								<div class="clear"></div>
							</div>';
							
							if ($setting['multi_lang'])
							{
								echo '	<ul class="tabs">';
											$i = 0;
											$class = 'class="activeTab"';
											foreach (langs() AS $l)
											{
												if ($i > 0)
													$class = '';
												
												echo '	<li '.$class.'><a href="#'.$l['lang_id'].'"><img src="'.Routes::$base.'cms/lang/'.$l['lang_code'].'/flag.png" style="margin-top: 6px; vertical-align: top;">'.$l['lang_name'].'</a></li>';	
												
												$i++;
											}
										echo '
										</ul>
										<div class="tab_container">';
											$i = 0;
											$style = 'style="display: block;"';
											foreach (langs() AS $l)
											{
												if ($i > 0)
													$class = 'style="display: none;"';
												
												echo '	<div id="'.$l['lang_id'].'" class="tab_content" '.$style.'>';
															//echo Input::text('product_name['.$l['lang_id'].']');
															
															echo '	<div class="formRow">
												                        <div class="grid2"><label>'. __('product_name['.$l['lang_id'].']') . '</label></div>
												                        <div class="grid10">
												                        	<input type="text" name="product_name['.$l['lang_id'].']" class="search-string" rel="search_possible_product" title="search_possible_product" placeholder="" value=""/>
												                        </div>
												                        <!-- Search results -->
									               						<div class="sResults search_possible_product none" style="left: 237px; width:283px; margin-top: 30px; position: absolute; z-index: 999;"></div>
												                        <div class="clear"></div>
														            </div>';
															echo Input::editor('product_text['.$l['lang_id'].']');
												echo '	</div>';
														
												$i++;
											}
										echo '
										</div>
										<div class="clear"></div>';
							}
							else 
							{
								echo '	<div class="body">
											<fieldset>';
												//echo Input::text('product_name['.$_SESSION['lang_id'].']', @$bot['name']);
												echo '	<div class="formRow">
									                        <div class="grid2"><label>'. __('product_name['.$_SESSION['lang_id'].']') . '</label></div>
									                        <div class="grid10">
									                        	<input type="text" name="product_name['.$_SESSION['lang_id'].']" class="search-string" rel="search_possible_product" title="search_possible_product" placeholder="" value=""/>
									                        </div>
									                        <!-- Search results -->
						               						<div class="sResults search_possible_product none" style="left: 237px; width:283px; margin-top: 30px; position: absolute; z-index: 999;"></div>
									                        <div class="clear"></div>
											            </div>';
												echo Input::editor('product_text['.$_SESSION['lang_id'].']', @$bot['desc']);
											echo '	
											</fieldset>
										</div>';	
							}
						echo '
						</div>
					</div>
				    
				    <div class="fluid">
				    	<div class="widget grid12">
				    		<div class="whead">
								<h6>'. __('New product') .' - '. __('Global') .'</h6>
								<div class="clear"></div>
							</div>
							<ul class="tabs">
								<li class="activeTab"><a href="#product_details">'.__('Details').'</a></li>
								<li><a href="#product_sale">'.__('Sale').'</a></li>
								<li><a href="#product_images">'.__('Image').'</a></li>';
								if ($setting['content_seo_mode'] == 'on')
									echo '<li><a href="#product_seo">'.__('SEO').'</a></li>';
								if ($setting['product_has_features'] == 'on')
									echo '<li><a href="#product_features">'.__('Features').'</a></li>';
								if ($setting['product_detailed_pricing'] == 'on')
									echo '<li><a href="#detailed_pricing">'.__('Different prices').'</a></li>';
							echo '
							</ul>
							<div class="tab_container">
								<div id="product_details" class="tab_content" style="display: block;">';
									Input::$default = false;
									Input::$note = __('Select to show this product in homepage');
									echo Input::select('featured', $featured);
									echo Input::select('is_public', format_true_false('Public', 'Not public'), 0);
									
									Input::$note = false;
									Input::$default = false;
									echo Input::select('manufacturer', $manufacturers, @$bot['manufacturer']);
									
									Input::$note = __('Purchasing price of product');
									echo Input::text('price_purchasing');
									
									Input::$note = __('Price of product without taxes');
									echo Input::text('price', @$bot['price']);
									Input::$note = false;
									
									echo Input::select('currency', $currencies, 1);
									
									echo Input::select('tax', $taxes, 2);
									Input::$note = __('cm');
									echo Input::text('length', 7);
									echo Input::text('width', 6);
									echo Input::text('height', 20);
									Input::$note = __('kg');
									echo Input::text('weight', 0.5);
									Input::$note = false;
									
									Input::$note = __('To track your stock, please fill here and select after all sales');
									echo Input::text('stock_amount');
									Input::$disabled = false;
									Input::$note = false;
									
									echo Input::text('code');
									
									echo '
									<div class="formRow" style="height:300px;">
						                <div class="grid2"><label>'. __('Categories') .'</label></div>
						                <div class="grid10">
						                    <select multiple="multiple" class="multiple" title="" name="categories[]" style="height:280px;">';
												// Seçili kategorileri seçili olarak işaretle
												$i = 0;
												foreach ($categories AS $category)
												{
													if (@$category['category_id'] == $category_id)
														$selected = 'selected';
													/*
													elseif($i == 0)
														$selected = 'selected';
													*/
													else
														$selected = '';
													
													$i++;
													
													echo '<option value="'.$category['category_id'].'" '.$selected.'>'.$category['category_name'].'</option>';
									        	}
									        echo '    
											</select>
										</div>
									</div>
									<div class="formRow" style="height:360px;">
						            	<div class="grid2"><label>'. __('Similar contents') .'</label></div>
						            	<div class="grid10 searchDrop">
						            		<div class="leftBox">
						                        <input type="text" id="box1Filter" class="boxFilter" placeholder="'. __('Filter') .'" /><button type="button" id="box1Clear" class="dualBtn fltr">x</button><br />
						                        
						                        <select id="box1View" multiple="multiple" class="multiple" style="height:300px;">';
						                        // Seçili içerikleri seçili olarak işaretle
						                        foreach ($not_similars AS $product)
												{
													echo '<option value="'.$product['product_id'].'">'.$product['product_name'].'</option>';
									        	}
												echo '
						                        </select>
						                        <br/>
						                        <!-- <span id="box1Counter" class="countLabel"></span> -->
						                        
						                        <div class="displayNone"><select id="box1Storage"></select></div>
						                    </div>
						                            
						                    <div class="dualControl">
						                        <button id="to2" type="button" class="dualBtn mr5 mb15">&nbsp;&gt;&nbsp;</button>
						                        <button id="allTo2" type="button" class="dualBtn">&nbsp;&gt;&gt;&nbsp;</button><br />
						                        <button id="to1" type="button" class="dualBtn mr5">&nbsp;&lt;&nbsp;</button>
						                        <button id="allTo1" type="button" class="dualBtn">&nbsp;&lt;&lt;&nbsp;</button>
						                    </div>
						                            
						                    <div class="rightBox">
						                        <input type="text" id="box2Filter" class="boxFilter" placeholder="'. __('Filter') .'" /><button type="button" id="box2Clear" class="dualBtn fltr">x</button><br />
						                        <select id="box2View" multiple="multiple" class="multiple" name="similars[]" style="height:300px;">
						                        </select><br/>
						                        <!-- <span id="box2Counter" class="countLabel"></span> -->
						                        
						                        <div class="displayNone"><select id="box2Storage"></select></div>
						                    </div>';
						                    echo '
						                    <div class="clear"></div>
						            	</div>
						            </div>';
									
									// Maps
									if ($setting['product_has_location'] == 'on' && @$_REQUEST['map'] != 'no')
										echo Input::map('product_map');
										
									// Inline date picker
									if ($setting['product_has_expiration_date'] == 'on')
						            	echo Input::date('expire', $site['timestamp']+6*30*24*60*60);
									
									// Images
									Input::$note = __('Image dimension should be :img_w px and height :img_h px', array('img_w'=>$setting['product_img_w'], 'img_h'=>$setting['product_img_h']));
									echo Input::finder('img_c', @$bot['img_c']);
									
									Input::$note = __('Image dimension should be :thumb_w px and height :thumb_h px', array('thumb_w'=>$setting['product_thumb_w'], 'thumb_h'=>$setting['product_thumb_h']));
									echo Input::finder('img_t', @$bot['img_t']);
									
									// Video
									Input::$note = 'Type iframe code';
									echo Input::textarea('video');
									Input::$note = false;
								echo '
								</div>
								<div id="product_sale" class="tab_content" style="display: none;">
									<div class="nNote nSuccess"><p>'.__('Set sale price between dates').'</p></div>'; 
									Input::$required = false;
									echo Input::text('sale_price');
									echo Input::date('sale_start');
									echo Input::date('sale_expire', $site['timestamp']+6*30*24*60*60);
								echo '
								</div>
								<div id="product_images" class="tab_content" style="display: none;">'; 
									Input::$required = false;
									Input::$label = 'image';
									Input::$note = __('Image dimension should be :thumb_w px and height :thumb_h px', array('thumb_w'=>$setting['product_thumb_w'],'thumb_h'=>$setting['product_thumb_h']));
									for ($i = 0; $i < $setting['product_img_count']; $i++)
										echo Input::finder('product_img['.$i.']');
									Input::$label = false;
									Input::$note = false;
								echo '
								</div>';
								if ($setting['content_seo_mode'] == 'on')
								{
									
									Input::$required = false;
									echo '	<div id="product_seo" class="tab_content" style="display: none;">';
												echo Input::text('seo_title');
												echo Input::text('seo_desc');
												echo Input::text('seo_author');
												echo Input::text('seo_keywords', 'parfüm, kozmetik, kalıcı koku');
												echo Input::finder('seo_img');
												Input::$note = false;
									echo '	</div>';
								}
								if ($setting['product_has_features'] == 'on')
								{
									echo '	<div id="product_features" class="tab_content" style="display: none;">';
												foreach($features AS $feature)
												{
													Input::$label = '-1';
													Input::$note = $feature['feature_text'];
													echo Input::check('features[]', $feature['feature_id'], $feature['feature_name']);	
												}
									echo '	</div>';	
								}
								if ($setting['product_detailed_pricing'] == 'on')
								{
									Input::$required = false;
									echo '	<div id="detailed_pricing" class="tab_content" style="display: none;">
												<div id="detailed_pricing_note" class="wrapper">  
													<div class="fluid">
												    	<div class="grid2">
														    <a class="buttonL bLightBlue first pull-right" title="" href="javascript:void(0);" onClick="price_range_new();">'.__('New price range').'</a>
														</div>
													</div>
												</div>
												
												<div id="price_ranges"></div>';
												
									echo '	</div>';
								}
							echo '
							</div>
							<div class="clear"></div>
							
				    		<div class="body">
								<fieldset>
									    <div class="grid2">
											<div class="wButton">
												<a class="buttonL bRed first">'. __('Cancel') .'</a>
											</div>
										</div>
					                    <div class="grid10">
											<div class="wButton">
												<button type="submit" name="save_content" class="buttonL bLightBlue first">'. __('Add') .'</button>
											</div>
										</div>
								</fieldset>
							</div>
						</div>
					</div>
				</form>
			</div>'; 
}
function products()
{
	$p = new _Product();
	
	// Every contents or just in the given category
	$p->format = false;
	$products = $p->products(Routes::$get[1]);
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
			    			<h6>'. __('Products').'</h6>
			    			<div class="clear"></div>
			    		</div>
		            
			            <div id="dyn" class="shownpars">
			                <a class="tOptions act" title="Options"><img src="'.Routes::$base.'cms/design/images/icons/options.png" alt="" /></a>
			                
			                <table cellpadding="0" cellspacing="0" border="0" class="dinamik_tablo tMedia" id="dynamic">
				                <thead>
					                <tr>
					                	<th>'. __('Image') .'</th>
						                <th>'. __('Name') .'</th>
						                
						                <th>'. __('Price (Purchasing)') .' </th>
						                <th>'. __('Price (Selling)') .' </th>
						                <th>'. __('Price (Sale)') .' </th>
						                <th>'. __('Code') .' </th>
						                <th>'. __('Stock amount') .' </th>
						                <th>'. __('Storage') .' </th>
						                <th>'. __('Actions') .' </th>
					                </tr>
				                </thead>
				                <tbody>';
								
									if (!empty($products))
									{
										foreach ($products AS $result)
										{
											echo '<tr class="gradeX" id="row_'.$result['product_id'].'">
													<td width="50"><img src="'.$result['img_t'].'" width="50"></td>
													<td style="min-width:200px;">'.$result['product_name'].'</td>
							                	  	
							                	  	<td><input onChange="set_price_purchase('.$result['product_id'].');" id="price_purchasing_'.$result['product_id'].'" value="'.$result['product_price_purchasing'].'"></td>
							                	  	<td><input onChange="set_price('.$result['product_id'].');" 		 id="price_selling_'.$result['product_id'].'" 	 value="'.$result['product_price'].'"></td>
							                	  	<td><input onChange="set_price_sale('.$result['product_id'].');" 	 id="price_sale_'.$result['product_id'].'" 	 	 value="'.$result['sale_price'].'"></td>
							                	  	
							                	  	<td><input onChange="set_stock_code('.$result['product_id'].');"     id="stock_code_'.$result['product_id'].'" 	 value="'.$result['product_code'].'"></td>
							                	  	
							                	  	<td><input onChange="set_stock('.$result['product_id'].');" 		 id="stock_amount_'.$result['product_id'].'" 	 value="'.$result['product_stock_amount'].'"></td>
							                	  	
							                	  	<td><input onChange="set_storage('.$result['product_id'].');"     id="stock_storage_'.$result['product_id'].'" 	 value="'.$result['product_storage'].'"></td>
							                	  	
							                	  	<td class="center">
							                	  		<a href="'.Routes::$base.'admin/product/'.$result['product_id'].'" class="buttonM bBlue ml10">'. __('Details') .'</a>';
							                	  		if ($result['is_erasable'] == 1)
							                      			echo '	<a href="javascript:void(0);" onClick="delete_from_database(\'products\', '.$result['product_id'].', \'row\');" class="buttonM bRed ml10">'. __('Del') .'</a>';
							                      		echo '
							                      	</td>
							                      </tr>';
										}
									}    
						            echo '
					            </tbody>
			                </table> 
			            </div>
			            <div class="clear"></div>
					</div>
				</div>
			</div>';	
}
function products_price_in_category()
{
	products();
}
function products_stock_in_category()
{
	products();	
}
function products_featured()
{
	$p = new _Product();
	
	// Every contents or just in the given category
	if (!isset(Routes::$get[1]))
		$p->category = Routes::$get[1];
	
	$p->is_featured = '= 1';
	
	$products = $p->products();
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
			    			<h6>'. __('Contents') .'</h6>
			    			<div class="clear"></div>
			    		</div>
		            
			            <div id="dyn" class="shownpars">
			                <a class="tOptions" title="Options"><img src="'.Routes::$base.'cms/design/images/icons/options.png" alt="" /></a>
			                
			                <table cellpadding="0" cellspacing="0" border="0" class="dinamik_tablo tMedia" id="dynamic">
				                <thead>
					                <tr>
					                	<th>'. __('Image') .'</th>
						                <th>'. __('Name') .'</th>
						                <th>'. __('Price') .' </th>
						                <th>'. __('Price with taxes') .' </th>
						                <th>'. __('Code') .' </th>
						                <th>'. __('Stock amount') .' </th>
						                <th>'. __('Actions') .' </th>
					                </tr>
				                </thead>
				                <tbody>';
									if (!empty($products))
									{
										foreach ($products AS $result){
											echo '<tr class="gradeX" id="row_'.$result['product_id'].'">
													<td width="50"><img src="'.$result['img_t'].'" width="50"></td>
													<td style="min-width:200px;">'.$result['product_name'].'</td>
							                	  	<td>'.$result['product_price'].' </td>
							                	  	<td>'.$result['product_price_with_tax'].' </td>
							                	  	<td>'.$result['product_code'].'  </td>
							                	  	<td>'.$result['product_stock_amount'].' </td>
							                	  	<td class="center">
							                	  		<a href="'.Routes::$base.'admin/product/'.$result['product_id'].'" class="buttonM bBlue ml10">'. __('Edit') .'</a>';
							                	  		if ($result['is_erasable'] == 1)
							                      			echo '	<a href="javascript:void(0);" onClick="delete_from_database(\'products\', '.$result['product_id'].', \'row\');" class="buttonM bRed ml10">'. __('Del') .'</a>';
							                      		echo '
							                      	</td>
							                      </tr>';
										}
									}    
						            echo '
					            </tbody>
			                </table> 
			            </div>
			            <div class="clear"></div>
					</div>
				</div>
			</div>';	
}
function manufacturer()
{
	$p = new _Product();
	$p->manufacturer_id = Routes::$get[1];
	
	echo $p->edit_manufacturer();
	
	$result = $p->manufacturers();
	
	echo '	<div class="wrapper">    
			<div class="fluid">
				<div class="widget grid12">
					<div class="whead">
						<h6>'. __('Manufacturer').': '.$result['manufacturer_name'] .'</h6>
						<div class="clear"></div>
			  		</div>
			  		<div class="body">
			  			<form class="main" enctype="multipart/form-data" method="post" action="'.Routes::$current.'">
							<fieldset>';
								echo Input::text('name', $result['manufacturer_name']);
								echo Input::textarea('desc', $result['manufacturer_desc']);
								echo Input::finder('image', $result['manufacturer_img']);
								Input::$default = false;
								echo Input::select('is_public', format_true_false('is_public', 'not_public'), $result['is_public']);
		            			echo '
								<div class="formRow">
						            <input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
				                    <input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Save') .'">
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>';
}
function manufacturer_new()
{
	$p = new _Product();
	
	echo $p->add_manufacturer();
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
							<h6>'. __('New') .'</h6>
							<div class="clear"></div>
					  	</div>
					  	<div class="body">
						  	<form class="main" method="post" action="'. Routes::$current .'">
								<fieldset>';
								
									echo Input::text('name');
									echo Input::textarea('desc');
									Input::$note = 'Marka resimleri 165 px genişliğinde, 80 px yüksekliğinde olmalıdır.';
									echo Input::finder('image');
									Input::$note = false;
									Input::$default = false;
									echo Input::select('is_public', format_true_false('is_public', 'not_public'), 1);
		            			
									echo '
									<div class="formRow">
								    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
						            	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Add') .'">
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>';
}
function manufacturers()
{
	global $site;
	
	$p = new _Product();
	$manufacturer = $p->manufacturers();
	
	echo '	<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
			    			<h6>'. __('Manufacturers') .'</h6>
			    			<div class="clear"></div>
			    		</div>
			            <div id="dyn" class="hiddenpars">
			                <a class="tOptions" title="Options"><img src="'.Routes::$base.'cms/design/images/icons/options.png" alt="" /></a>
			                
			                <table cellpadding="0" cellspacing="0" border="0" class="dinamik_tablo" id="dynamic">
				                <thead>
					                <tr>
						                <th>'. __('Image') .'</th>
						                <th>'. __('Name') .'</th>
						                <th>'. __('Desc') .'</th>
						                <th>'. __('Actions') .' </th>
					                </tr>
				                </thead>
				                <tbody>';
									foreach ($manufacturer AS $result){
										
										if (!$result['is_public'])
											$style = 'style="color:red;"';
										else
											$style = '';
	
										echo '	<tr class="gradeX" id="row_'.$result['manufacturer_id'].'">
													<td width="50"><img src="'.$site['image_path'].$result['manufacturer_img'].'" width="50"></td>
													<td '.$style.'>'.$result['manufacturer_name'].'</td>
													<td>'.$result['manufacturer_desc'].'</td>
													<td class="center">
														<a href="'.Routes::$base.'admin/manufacturer/'.$result['manufacturer_id'].'" 	 class="buttonM bDefault ml10">'. __('Details') .'</a>';
														if ($result['is_erasable'] == 1)
															echo '	<a href="javascript:void(0);" onClick="delete_from_database(\'manufacturers\', '.$result['manufacturer_id'].', \'row\');" class="buttonM bRed ml10" style="color:#fff">'. __('Del') .'</a>';
								                   	echo '
												    </td>
												</tr>';
									}
						            echo '
					            </tbody>
			                </table> 
			            </div>
			            <div class="clear"></div> 
					</div>
				</div>
			</div>
		</div>';
}

function shipping()
{
	$p = new _Product();
	
	$p->shipping_id = Routes::$get[1];
	echo $p->edit_shipping();

	$result = $p->shippings();
	
	echo '	<div class="wrapper">    
			<div class="fluid">
				<div class="widget grid12">
					<div class="whead">
						<h6>'. __('Shipping').': '.__($result['shipping_name']) .'</h6>
						<div class="clear"></div>
			  		</div>
			  		<div class="body">
			  			<form class="main" enctype="multipart/form-data" method="post" action="'.Routes::$current.'">
							<fieldset>';
								echo Input::hidden('type', $result['shipping_type']);
								if ($result['shipping_id'] > 6)
								{
									echo Input::text('name', $result['shipping_name']);
									echo Input::textarea('desc', $result['shipping_desc']);	
								}
								else {
									Input::$disabled = true;
									echo Input::text('name', __($result['shipping_name']));
									echo Input::textarea('desc', __($result['shipping_desc']));		
									Input::$disabled = false;
								}
								if ($result['shipping_type'] == 1)
								{
									echo Input::text('condition', $result['shipping_condition']);
								}
								if ($result['shipping_type'] == 2)
								{
									echo Input::text('price', $result['shipping_price']);
									Input::$note = __('shipping_fixed_condition_note');
									echo Input::text('condition', $result['shipping_condition']);
									Input::$note = false;
								}
								if ($result['shipping_type'] == 3)
								{
									Input::$note = __('shipping_weight_note');
									echo Input::text('condition', $result['shipping_condition']);
									Input::$note = false;
								}
								if ($result['shipping_type'] == 4)
								{
									Input::$label = 'desi_plus';	
									Input::$note = __('shipping_desi_plus_note');
									echo Input::text('condition', $result['shipping_condition']);	
									Input::$label = false;
									Input::$note = __('shipping_desi_fixed_note');
									echo Input::text('price', $result['shipping_price']);
									Input::$note = false;
									
									$d = new _Data();
									$regions = $d->regions();
									echo '
									<div class="formRow">	
										<div class="grid2">
											<label>'.__('Regions').'</label>
										</div>
										<div class="grid10 moreFields">
											<ul class="rowData">';
												foreach ($regions AS $region)
												{
													echo '	<li style="text-align:center">'.$region['region_name'].'</li>
															<li class="sep">&nbsp</li>';	
												}
											echo '	
											</ul>
										</div>
										<div class="clear"></div>
									</div>';
									
									for ($i=0; $i<51; $i++)
									{
										$j = $i + 1;
										if ($i == 0)
											$label = '0 =< desi <'.$j;
										else
											$label = $i.' =< desi <'.$j;
										
										echo '
										<div class="formRow">	
											<div class="grid2">
												<label>'.$label.'</label>
												<input type="hidden" maxlength="6" name="desi['.$i.'][desi_id]" value="'.$i.'"/>
											</div>
											<div class="grid10 moreFields">
												<ul class="rowData">';
													foreach ($regions AS $region)
													{
														$desies = $p->shipping_desies_by_regions($i);
														
														echo '
														<li><input type="text" maxlength="6" name="desi['.$i.'][region]['.$region['region_id'].']" value="'.@$desies[$region['region_id']].'" placeholder="'.$region['region_name'].'"></li>
														<li class="sep">-</li>';
													}
												echo '
												</ul>
											</div>
											<div class="clear"></div>
										</div>';
									}
								}
								Input::$note = __('order_note');
								echo Input::text('order', $result['shipping_order']);
								Input::$note = false;
								Input::$default = false;
								$is_public[0]['id'] = 0;
								$is_public[0]['value'] = __('not_public');
								$is_public[1]['id'] = 1;
								$is_public[1]['value'] = __('is_public');
								echo Input::select('is_public', $is_public, $result['is_public']);
								Input::$default = true;
								echo '
								<div class="formRow">
						            <input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
				                    <input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Save') .'">
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>';
}
function shipping_new()
{
	$p = new _Product();
	echo $p->add_shipping();
	
	echo '	<div class="wrapper">    
			<div class="fluid">
				<div class="widget grid12">
					<div class="whead">
						<h6>'. __('New') .'</h6>
						<div class="clear"></div>
			  		</div>
			  		<div class="body">
			  			<form class="main" enctype="multipart/form-data" method="post" action="'.Routes::$current.'">
							<fieldset>';
								echo Input::hidden('type', 4);
								echo Input::text('name');
								echo Input::textarea('desc');	
								
								Input::$label = 'desi_plus';	
								Input::$note = __('shipping_desi_plus_note');
								echo Input::text('condition');	
								Input::$label = false;
								Input::$note = __('shipping_desi_fixed_note');
								echo Input::text('price');
								Input::$note = false;
									
								$d = new _Data();
								$regions = $d->regions();
								echo '
								<div class="formRow">	
									<div class="grid2">
										<label>'.__('Regions').'</label>
									</div>
									<div class="grid10 moreFields">
										<ul class="rowData">';
											foreach ($regions AS $region)
											{
												echo '	<li style="text-align:center">'.$region['region_name'].'</li>
														<li class="sep">&nbsp</li>';	
											}
										echo '	
										</ul>
									</div>
									<div class="clear"></div>
								</div>';
									
								for ($i=0; $i<51; $i++)
								{
									$j = $i + 1;
									if ($i == 0)
										$label = '0 =< desi <'.$j;
									else
										$label = $i.' =< desi <'.$j;
									
									echo '
									<div class="formRow">	
										<div class="grid2">
											<label>'.$label.'</label>
											<input type="hidden" maxlength="6" name="desi['.$i.'][desi_id]" value="'.$i.'"/>
										</div>
										<div class="grid10 moreFields">
											<ul class="rowData">';
												foreach ($regions AS $region)
												{
													echo '
													<li><input type="text" maxlength="6" name="desi['.$i.'][region]['.$region['region_id'].']" value="" placeholder="'.$region['region_name'].'"></li>
													<li class="sep">-</li>';
												}
											echo '
											</ul>
										</div>
										<div class="clear"></div>
									</div>';
								}
								Input::$note = __('order_note');
								echo Input::text('order', 1);
								Input::$note = false;
								Input::$default = false;
								$is_public[0]['id'] = 0;
								$is_public[0]['value'] = __('not_public');
								$is_public[1]['id'] = 1;
								$is_public[1]['value'] = __('is_public');
								echo Input::select('is_public', $is_public, 0);
								Input::$default = true;
								echo '
								<div class="formRow">
						            <input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
				                    <input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Save') .'">
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>';
}
function shippings()
{
	$p = new _Product();
	
	$table = new Dynamic_forms();
	
	$table->data = $p->shippings();
	
	$table->title = 'Shippings';
	$table->link = 'shipping';
								
	$table->th = array(0=>'Name', 
					   1=>'Text',
					   2=>'Status');	
					   
	$table->td = array(0=>'shipping_name', 
					   1=>'shipping_desc',
					   2=>'is_public');
					   								
	$table->data_list();
}

function payment()
{
	$p = new _Product();
	$p->payment_id = Routes::$get[1];
	
	$pay = new _Payment();
	$pay->payment_id = Routes::$get[1];
	echo $pay->edit_payment();
	
	$result = $p->payments();
	
	echo '	<div class="wrapper">    
			<div class="fluid">
				<div class="widget grid12">
					<div class="whead">
						<h6>'.$result['payment_name'] .'</h6>
						<div class="clear"></div>
			  		</div>
			  		<div class="body">
			  			<form class="main" enctype="multipart/form-data" method="post" action="'.Routes::$current.'">
							<fieldset>';
								echo Input::text('payment_name', $result['payment_name']);
								echo Input::text('payment_min', $result['payment_min']);
								echo Input::text('payment_max', $result['payment_max']);
								
								Input::$note = __('Sabit olarak ara toplama eklenecek ödeme fiyatı, kapıda ödeme işlemi gibi durumlar için kullanımı uygundur');
								echo Input::text('price', $result['payment_price']);
								
								Input::$label = __('Taksit imkanı');
								Input::$note = __('Taksit seçeneklerini taksit:yüzde artış, taksit:yüzde artış şeklinde yazabilirsiniz, taksit seçeneği yoksa boş bırakın');
								echo Input::textarea('condition', $result['payment_condition']);
								Input::$label = false;
								Input::$note = false;
								
								Input::$default = false;
								$is_public[0]['id'] = 0;
								$is_public[0]['value'] = __('not_public');
								$is_public[1]['id'] = 1;
								$is_public[1]['value'] = __('is_public');
								Input::$note = __('Ödeme sisteminin kullanıma açık olup olmadığını belirtir, aktif olduğu durumlarda yukarda tanımlanan durumlara uygun olan siparişlerde müşteriye bu ödeme metudu gösterilecektir');
								echo Input::select('is_public', $is_public, $result['is_public']);
								Input::$note = true;
								Input::$label = false;
								
								echo Input::text('payment_order', $result['payment_order']);
		            			echo '
								<div class="formRow">
						            <input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
				                    <input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Save') .'">
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>';
}
/*
function payment_new()
{
	global $lang, $setting;
	
	$p = new _Product();
	
	echo $p->add_manufacturer();
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
							<h6>'. $lang['New_manufacturer'] .'</h6>
							<div class="clear"></div>
					  	</div>
					  	<div class="body">
						  	<form class="main" method="post" action="'. Routes::$current .'">
								<fieldset>';
								
									echo Input::text('name');
									echo Input::textarea('desc');
									echo Input::finder('image');
									
									echo '
									<div class="formRow">
								    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
						            	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Add') .'">
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>';
}
*/
function payments()
{
	$p = new _Product();
	
	$table = new Dynamic_forms();
	
	$table->data = $p->payments();
	
	$table->title = 'Payments';
	$table->link = 'payment';
								
	$table->th = array(0=>'Name', 
					   1=>'Min',
					   2=>'Max',
					   3=>'Status');	
					   
	$table->td = array(0=>'payment_name', 
					   1=>'payment_min',
					   2=>'payment_max',
					   3=>'is_public');
					   								
	$table->data_list();
}
function status_new()
{
	global $setting;
	
	$p = new _Product();
	
	echo $p->add_status();
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
							<h6>'. __('New') .'</h6>
							<div class="clear"></div>
					  	</div>
					  	
						<form class="main" method="post" action="'. Routes::$current .'">
							<fieldset>';
								
								if ($setting['multi_lang'])
								{
									echo '	<ul class="tabs">';
												$i = 0;
												$class = 'class="activeTab"';
												foreach (langs() AS $l)
												{
													if ($i > 0)
														$class = '';
													
													echo '	<li '.$class.'><a href="#'.$l['lang_id'].'"><img src="'.Routes::$base.'cms/lang/'.$l['lang_code'].'/flag.png" style="margin-top: 6px; vertical-align: top;">'.$l['lang_name'].'</a></li>';	
													
													$i++;
												}
											echo '
											</ul>
											<div class="tab_container">';
												$i = 0;
												$style = 'style="display: block;"';
												foreach (langs() AS $l)
												{
													if ($i > 0)
														$class = 'style="display: none;"';
													
													echo '	<div id="'.$l['lang_id'].'" class="tab_content" '.$style.'>';
																echo Input::text('name['.$l['lang_id'].']');
													echo '	</div>';
															
													$i++;
												}
											echo '
											</div>
											<div class="clear"></div>';
								}
								else 
								{
									echo '	<div class="body">
												<fieldset>';
													echo Input::text('name['.$_SESSION['lang_id'].']');
												echo '	
												</fieldset>
											</div>';	
								}
								
								echo '
								<div class="formRow">
							    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
					            	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Add') .'">
					            	<div class="clear"></div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>';
}
function status()
{
	$p = new _Product();
	
	if (!isset(Routes::$get[1]))
	{
		
		$table = new Dynamic_forms();
		$table->data = $p->status();

		$table->title = 'Status';
		$table->link = 'status';
									
		$table->th = array(0=>'name', 
						   1=>'Lang');	
						   
		$table->td = array(0=>'status_name', 
						   1=>'lang_name');
						   								
		$table->data_list();
	}
	else
	{
		$setting;
		
		echo $p->edit_status();
		
		$p->status_id = Routes::$get[1];
		$result = $p->status();
		
		echo '<!-- Main content -->
				<div class="wrapper">    
				    <div class="fluid">
				    	<div class="widget grid12">
				    		<div class="whead">
								<h6>'. __('Status') .'</h6>
								<div class="clear"></div>
						  	</div>
						  	
							<form class="main" method="post" action="'. Routes::$current .'">
								<fieldset>';
									Input::$label = false;
									echo Input::hidden('status_id', Routes::$get[1]);
									if ($setting['multi_lang'])
									{
										echo '	<ul class="tabs">';
													$i = 0;
													$class = 'class="activeTab"';
													foreach (langs() AS $l)
													{
														if ($i > 0)
															$class = '';
														
														echo '	<li '.$class.'><a href="#'.$l['lang_id'].'"><img src="'.Routes::$base.'cms/lang/'.$l['lang_code'].'/flag.png" style="margin-top: 6px; vertical-align: top;">'.$l['lang_name'].'</a></li>';	
														
														$i++;
													}
												echo '
												</ul>
												<div class="tab_container">';
													$i = 0;
													$style = 'style="display: block;"';
													foreach (langs() AS $l)
													{
														if ($i > 0)
															$class = 'style="display: none;"';
														
														echo '	<div id="'.$l['lang_id'].'" class="tab_content" '.$style.'>';
																	echo @Input::text('name['.$l['lang_id'].']', $result[$l['lang_id']-1]['status_name']);
														echo '	</div>';
																
														$i++;
													}
												echo '
												</div>
												<div class="clear"></div>';
									}
									else 
									{
										echo '	<div class="body">
													<fieldset>';
														echo Input::text('name['.$_SESSION['lang_id'].']', $result[0]['status_name']);
													echo '	
													</fieldset>
												</div>';	
									}
									
									echo '
									<div class="formRow">
								    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
						            	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Edit') .'">
						            	<div class="clear"></div>
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>';
	}
}
function currency()
{
	$p = new _Product();
	$p->currency_id = Routes::$get[1];
	
	echo $p->edit_currency();
	
	$result = $p->currencies();
	
	echo '	<div class="wrapper">    
			<div class="fluid">
				<div class="widget grid12">
					<div class="whead">
						<h6>'. __('Currency') .': '.$result['currency_name'] .'</h6>
						<div class="clear"></div>
			  		</div>
			  		<div class="body">
			  			<form class="main" enctype="multipart/form-data" method="post" action="'.Routes::$current.'">
							<fieldset>';
								echo Input::text('name', $result['currency_name']);
								echo Input::text('currency_code', $result['currency_code']);
								echo Input::text('multiplier', $result['currency_multiplier']);
								
								$data[0]['id'] = 'right';
								$data[0]['value'] = __('right');
								$data[1]['id'] = 'left';
								$data[1]['value'] = __('left');
								
								echo Input::select('side', $data, $result['currency_side']);
								
								echo Input::text('order', $result['currency_order']);
								
								echo '
								<div class="formRow">
						            <input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
				                    <input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Save') .'">
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>';
}
function currency_new()
{
	global $setting;
	
	$p = new _Product();
	
	echo $p->add_currency();
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
							<h6>'. __('New') .'</h6>
							<div class="clear"></div>
					  	</div>
					  	<div class="body">
						  	<form class="main" method="post" action="'. Routes::$current .'">
								<fieldset>';
								
									echo Input::text('name');
									echo Input::text('currency_code');
									echo Input::text('multiplier');
									
									$data[0]['id'] = 'right';
									$data[0]['value'] = __('right');
									$data[1]['id'] = 'left';
									$data[1]['value'] = __('left');
									
									Input::$note = 'note_currency_side';
									echo Input::select('side', $data, 'right');
									
									echo '
									<div class="formRow">
								    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
						            	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Add') .'">
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>';
}
function currencies()
{
	global $site;
	
	$p = new _Product();
	
	$table = new Dynamic_forms();
	
	$table->table = 'products_currencies';
	$table->data = $p->currencies();
	
	$table->title = 'Currencies';
	$table->link = 'currency';
								
	$table->th = array(0=>'Name', 
					   1=>'Code',
					   2=>'Multiplier');	
					   
	$table->td = array(0=>'currency_name', 
					   1=>'currency_code',
					   2=>'currency_multiplier');
					   								
	$table->data_list();
}
function feature()
{
	global $setting;
	
	$p = new _Product();
	$p->feature_id = Routes::$get[1];
	
	echo $p->edit_feature();
	
	$result = $p->features();
	
	echo '	<div class="wrapper">    
			<div class="fluid">
				<div class="widget grid12">
					<div class="whead">
						<h6>'.$result['feature_name'] .'</h6>
						<div class="clear"></div>
			  		</div>
			  		<form class="main" method="post" action="'. Routes::$current .'">
						<fieldset>';
							
							if ($setting['multi_lang'])
							{
								echo '	<ul class="tabs">';
											$i = 0;
											$class = 'class="activeTab"';
											foreach (langs() AS $l)
											{
												if ($i > 0)
													$class = '';
												
												echo '	<li '.$class.'><a href="#'.$l['lang_id'].'"><img src="'.Routes::$base.'cms/lang/'.$l['lang_code'].'/flag.png" style="margin-top: 6px; vertical-align: top;">'.$l['lang_name'].'</a></li>';	
												
												$i++;
											}
										echo '
										</ul>
										<div class="tab_container">';
											$i = 0;
											$style = 'style="display: block;"';
											foreach (langs() AS $l)
											{
												if ($i > 0)
													$class = 'style="display: none;"';
												
												echo '	<div id="'.$l['lang_id'].'" class="tab_content" '.$style.'>';
															echo Input::text('name['.$l['lang_id'].']');
															echo Input::textarea('text['.$l['lang_id'].']');
												echo '	</div>';
														
												$i++;
											}
										echo '
										</div>
										<div class="clear"></div>';
							}
							else 
							{
								echo '	<div class="body">
											<fieldset>';
												echo Input::text('name', $result['feature_name']);
												echo Input::textarea('text', $result['feature_text']);
								
											echo '	
											</fieldset>
										</div>';	
							}
							
							echo '
							<div class="formRow">
						    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
				            	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Add') .'">
				            	<div class="clear"></div>
							</div>
						</fieldset>
					</form>
			  	</div>
			</div>
		</div>';
}
function feature_new()
{
	global $setting;
	
	$p = new _Product();
	
	echo $p->add_feature();
	
	if ($setting['multi_lang'])
	{	
		echo '	<!-- Main content -->
				<div class="wrapper">  
					<div class="fluid">
				    	<div class="grid12">
					    	<div class="nNote nSuccess">
								<p>'.__('note_new_feature') .'</p>
							</div>
						</div>
					</div> 
				</div>';
	}		
	echo '	<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
							<h6>'. __('New') .'</h6>
							<div class="clear"></div>
					  	</div>
				  	  	<form class="main" method="post" action="'. Routes::$current .'">
							<fieldset>';
								
								if ($setting['multi_lang'])
								{
									echo '	<ul class="tabs">';
												$i = 0;
												$class = 'class="activeTab"';
												foreach (langs() AS $l)
												{
													if ($i > 0)
														$class = '';
													
													echo '	<li '.$class.'><a href="#'.$l['lang_id'].'"><img src="'.Routes::$base.'cms/lang/'.$l['lang_code'].'/flag.png" style="margin-top: 6px; vertical-align: top;">'.$l['lang_name'].'</a></li>';	
													
													$i++;
												}
											echo '
											</ul>
											<div class="tab_container">';
												$i = 0;
												$style = 'style="display: block;"';
												foreach (langs() AS $l)
												{
													if ($i > 0)
														$class = 'style="display: none;"';
													
													echo '	<div id="'.$l['lang_id'].'" class="tab_content" '.$style.'>';
																Input::$label = __('Name');
																echo Input::text('name['.$l['lang_id'].']');
																Input::$label = __('Text');
																echo Input::textarea('text['.$l['lang_id'].']');
													echo '	</div>';
															
													$i++;
												}
											echo '
											</div>
											<div class="clear"></div>';
								}
								else 
								{
									echo '	<div class="body">
												<fieldset>';
													echo Input::text('name['.$_SESSION['lang_id'].']');
													echo Input::textarea('text['.$_SESSION['lang_id'].']');
												echo '	
												</fieldset>
											</div>';	
								}
								
								echo '
								<div class="formRow">
							    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
					            	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Add') .'">
					            	<div class="clear"></div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>';
}
function features()
{
	$p = new _Product();
	
	$table = new Dynamic_forms();
	
	$table->table = 'features';
	$table->data = $p->features();
	
	$table->title = __('Features');
	$table->link = 'feature';
								
	$table->th = array(0=>'feature_name', 
					   1=>'feature_text');	
					   
	$table->td = array(0=>'feature_name', 
					   1=>'feature_text');
					   								
	$table->data_list();
}
function tax()
{
	$p = new _Product();
	$p->tax_id = Routes::$get[1];
	
	echo $p->edit_tax();
	
	$result = $p->taxes();
	
	echo '	<div class="wrapper">    
			<div class="fluid">
				<div class="widget grid12">
					<div class="whead">
						<h6>'. __('Tax') .': '.$result['tax_name'] .'</h6>
						<div class="clear"></div>
			  		</div>
			  		<div class="body">
			  			<form class="main" enctype="multipart/form-data" method="post" action="'.Routes::$current.'">
							<fieldset>';
								echo Input::text('name', $result['tax_name']);
								Input::$note = __('Tax_percent');
								echo Input::text('percent', $result['tax_percent']);
								Input::$note = __('Tax_amount');
								echo Input::text('fixed', $result['tax_amount']);
								Input::$note = false;
		            			echo '
								<div class="formRow">
						            <input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
				                    <input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Save') .'">
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>';
}
function tax_new()
{
	$setting;
	
	$p = new _Product();
	
	echo $p->add_tax();
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
							<h6>'. __('New') .'</h6>
							<div class="clear"></div>
					  	</div>
					  	<div class="body">
						  	<form class="main" method="post" action="'. Routes::$current .'">
								<fieldset>';
								
									echo Input::text('name', $result['tax_name']);
									Input::$note = __('Tax_percent');
									echo Input::text('percent', $result['tax_percent']);
									Input::$note = __('Tax_amount');
									echo Input::text('fixed', $result['tax_amount']);
									Input::$note = false;
									
									echo '
									<div class="formRow">
								    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
						            	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Add') .'">
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>';
}
function taxes()
{
	global $site;
	
	$p = new _Product();
	$manufacturer = $p->taxes();
	
	echo '	<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
			    			<h6>'. __('Taxes') .'</h6>
			    			<div class="clear"></div>
			    		</div>
			            <div id="dyn" class="hiddenpars">
			                <a class="tOptions" title="Options"><img src="'.Routes::$base.'cms/design/images/icons/options.png" alt="" /></a>
			                
			                <table cellpadding="0" cellspacing="0" border="0" class="dinamik_tablo" id="dynamic">
				                <thead>
					                <tr>
						                <th>'. __('Name') .'</th>
						                <th>'. __('Percent') .'</th>
						                <th>'. __('Amount') .'</th>
						                <th>'. __('Actions') .' </th>
					                </tr>
				                </thead>
				                <tbody>';
									foreach ($manufacturer AS $result){
										echo '	<tr class="gradeX" id="row_'.$result['tax_id'].'">
													<td>'.$result['tax_name'].'</td>
													<td>'.$result['tax_percent'].'</td>
													<td>'.$result['tax_amount'].'</td>
													<td class="center">
														<a href="'.Routes::$base.'admin/tax/'.$result['tax_id'].'" 	 class="buttonM bDefault ml10">'. __('Details') .'</a>
														<a href="javascript:void(0);" onClick="delete_from_database(\'products_taxes\', '.$result['tax_id'].', \'row\');" class="buttonM bRed ml10" style="color:#fff">'. __('Del') .'</a>
								                   	</td>
												</tr>';
									}
						            echo '
					            </tbody>
			                </table> 
			            </div>
			            <div class="clear"></div> 
					</div>
				</div>
			</div>
		</div>';
}
function orders()
{
	global $setting;
	
	$p = new _Product();
	
	if (!isset(Routes::$get[1]) || Routes::$get[1] == 'completed')
	{
		/* Order is completed */
		if (Routes::$get[1] == 'completed')
			$p->order_status = '= 4';
		else
			$p->order_status = '<> 4';
		
		$orders = $p->orders();
		
		echo '	<!-- Main content -->
				<div class="wrapper">    
				    <div class="fluid">
				    	<div class="widget grid12">
				    		<div class="whead">
				    			<h6>'. __('Orders').'</h6>
				    			<div class="clear"></div>
				    		</div>
				            <div id="dyn">
				                <a class="tOptions act" title="Options"><img src="'.Routes::$base.'cms/design/images/icons/options.png" alt="" /></a>
				                
				                <table cellpadding="0" cellspacing="0" border="0" class="dinamik_tablo" id="dynamic">
					                <thead>
						                <tr>
							                <th> </th>
							                <th>'. __('Name') .'</th>
							                <th>'. __('Address') .'</th>
							                <th>'. __('City') .'</th>
							                <th>'. __('Tel') .' </th>
							                <th>'. __('Date') .' </th>
							                <th>'. __('Total') .' </th>';
							         		// <th>'. __('Shipping') .' </th>
							         echo ' <th>'. __('Payment') .' </th>
							                <th>'. __('Status') .' </th>
							                <th>'. __('Actions') .' </th>
							            </tr>
					                </thead>
					                <tbody>';
										
										$status = select('status')->results();
										
										foreach ($orders AS $result)
										{
											//$shipping = select('shippings')->where('shipping_id = '.$result['order_shipping_id'])->result();
											$payment = select('payments')->where('payment_id = '.$result['order_payment_id'])->result();
											$status = select('status')->where('status_id = '.$result['order_status'].' AND lang_id = '.$_SESSION['lang_id'])->result();
											
											echo '	<tr class="gradeX" id="row_'.$result['order_id'].'">
														<td>'.$result['order_id'].'</td>
														<td>'.$result['order_name'].'</td>
														<td>'.$result['order_address'].'</td>
														<td>'.$result['order_city'].'</td>
														<td>'.$result['order_tel_h'].'</td>
														<td>'.date($setting['date_format'], $result['order_timestamp']).'</td>
														<td>'.$result['order_total'].'</td>';
														
														//<td>'.__($shipping['shipping_name']).'</td>
														
														
											echo '		<td>'.__($payment['payment_name']).'</td>
														<td>'.$status['status_name'].'</td>
														<td class="center">
															<a href="'.Routes::$base.'admin/orders/'.$result['order_id'].'" 	 class="buttonM bDefault ml10">'. __('Details') .'</a>
															<a href="'.Routes::$base.'admin/invoice/'.$result['invoice_id'].'" 	 class="buttonM bDefault ml10">'. __('Invoice') .'</a>
															<a href="javascript:void(0);" onClick="delete_from_database(\'products_orders\', '.$result['order_id'].', \'row\');" class="buttonM bRed ml10" style="color:#fff">'. __('Del') .'</a>
									                   	</td>
													</tr>';
										}
							            echo '
						            </tbody>
				                </table> 
				            </div>
				            <div class="clear"></div> 
						</div>
					</div>
				</div>
			</div>';
	}
	else
	{
		echo $p->edit_order_address_cargo_details();
		echo $p->edit_order_address_cargo();
		echo $p->edit_order_address_invoice();
		
		$p->order_id = Routes::$get[1];
		$results = $p->orders();
		
		$shipping = select('shippings')->where('shipping_id = '.$results[0]['order_shipping_id'])->result();
		$payment = select('payments')->where('payment_id = '.$results[0]['order_payment_id'])->result();
		$status = select('status')->where('status_id = '.$results[0]['order_status'].' AND lang_id = '.$_SESSION['lang_id'])->result();
											
		echo '	<!-- Main content -->
				<div class="wrapper">    
		    		<div class="fluid">
		    			<div class="widget grid12">
							<form class="main" method="post" action="'. Routes::$current .'">
								<fieldset>
									<div class="formRow">
										<h5>'.__('Info about order').' #'.Routes::$get[1].'</h5>
									</div>';
										Input::$default = false;
										echo Input::select('order_status', format_status_for_select(), $results[0]['order_status']);
										Input::$disabled = true;
										echo Input::hidden('order_id', $results[0]['order_id']);
										echo Input::text('order_timestamp', date('d.m.Y H:i',$results[0]['order_timestamp']));
										echo Input::text('order_desi', $results[0]['order_desi']);
										echo Input::text('order_weight', $results[0]['order_weight']);
										Input::$disabled = false;
										echo Input::text('order_total', $results[0]['order_total']);
										echo Input::select('order_shipping_id', format_shippings_id_for_select(), $shipping['shipping_id']);
										echo Input::text('order_shipping_code', $results[0]['order_shipping_code']);
				            			Input::$disabled = true;
										echo Input::text('order_payment_id', __($payment['payment_name']));
				            			echo Input::select('order_installement_id', format_i(), $results[0]['order_installement_id']);
				            			Input::$disabled = false;
				            			echo '
								</fieldset>
								<div class="formRow">
							    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
					            	<input class="buttonS bBlue formSubmit grid10" type="submit" name="order_cargo_details" value="'. __('Edit').'">
					            	<div class="clear"></div>
								</div>
							</form>
						</div>	
					</div>	
				</div>';
									
				if ($results[0]['user_id'] > 1)
				{
					echo '	<div class="wrapper">    
							    <div class="fluid">
							    	<div class="widget grid12">
							    		<form class="main" method="post" action="'. Routes::$current .'">
											<fieldset>
													<div class="formRow">
														<h5>'.__('User').'</h5>
													</div>
													<div class="formRow myInfo">
														<a href="'.Routes::$base.'admin/user/'.$results[0]['user_id'].'"><h5>'.$results[0]['user_name'].' '.$results[0]['user_surname'].'</h5></a>
														<span class="myRole">'.$results[0]['user_email'].'</span>
														<span class="followers"><i class="icon-phone"></i>'.$results[0]['user_tel1'].'</span>
													</div>
											</fieldset>
										</form>
									</div>	
								</div>	
							</div>';
				}	
				
				echo '
				<div class="wrapper">    
		    		<div class="fluid">
		    			<div class="widget grid12">
							<form class="main" method="post" action="'. Routes::$current .'">
								<fieldset>
									<div class="formRow">
										<h5>'. __('Cargo') .'</h5>
									</div>';
										echo Input::hidden('order_id', $results[0]['order_id']);
										echo Input::text('order_name', $results[0]['order_name']);
										echo Input::text('order_address', $results[0]['order_address']);
										echo Input::text('order_city', $results[0]['order_city']);
										echo Input::text('order_tel_h', $results[0]['order_tel_h']);
										echo Input::text('order_tel_m', $results[0]['order_tel_m']);
				            			echo Input::text('order_fax', $results[0]['order_fax']);
				            			echo Input::text('order_email', $results[0]['order_email']);
										echo Input::textarea('user_note', $results[0]['user_note']);
										echo Input::textarea('order_comment', $results[0]['order_comment']);
				            			
				            			
				            			echo '
									<div class="formRow">
								    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
						            	<input class="buttonS bBlue formSubmit grid10" type="submit" name="order_cargo_address" value="'. __('Edit').'">
						            	<div class="clear"></div>
									</div>
								</fieldset>
							</form>
						</div>	
					</div>	
				</div>	
				
				<div class="wrapper">    
		    		<div class="fluid">
		    			<div class="widget grid12">
							<form class="main" method="post" action="'. Routes::$current .'">
								<fieldset>
									<div class="formRow">
										<h5>'. __('Invoice') .'</h5>
									</div>';
										echo Input::hidden('invoice_id', $results[0]['invoice_id']);
										echo Input::text('invoice_name', $results[0]['invoice_name']);
										echo Input::text('invoice_address', $results[0]['invoice_address']);
										echo Input::text('invoice_city', $results[0]['invoice_city']);
										echo Input::text('invoice_tel_h', $results[0]['invoice_tel_h']);
										echo Input::text('invoice_tel_m', $results[0]['invoice_tel_m']);
				            			echo Input::text('invoice_fax', $results[0]['invoice_fax']);
				            			echo Input::text('invoice_email', $results[0]['invoice_email']);
										echo Input::select('invoice_email_on', format_string_string('Yes','No'), $results[0]['invoice_email_on']);
				            		echo '
						            <div class="formRow">
								    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel').'">
						            	<input class="buttonS bBlue formSubmit grid10" type="submit" name="order_invoice_address" value="'. __('Edit').'">
						            	<div class="clear"></div>
									</div>
								</fieldset>
							</form>
						</div>	
					</div>	
				</div>';
				
		echo '<!-- Main content -->
			  <div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
			    			<h6>'.__('Products').'</h6>
			    			<div class="clear"></div>
			    		</div>
		            
			            <div id="dyn" class="shownpars">
			                <a class="tOptions act" title="Options"><img src="'.Routes::$base.'cms/design/images/icons/options.png" alt="" /></a>
			                
			                <table cellpadding="0" cellspacing="0" border="0" class="dinamik_tablo tMedia" id="dynamic">
				                <thead>
					                <tr>
					                	<th>'. __('Image') .'</th>
						                <th>'. __('Name') .'</th>
						                <th>'. __('Price in order') .'</th>
						                <th>'. __('Quantity') .'</th>
						                <th>'. __('Current price') .' </th>
						                <th>'. __('Code') .' </th>
						                <th>'. __('Stock amount') .' </th>
						                <th>'. __('Actions') .' </th>
					                </tr>
				                </thead>
				                <tbody>';
									if (!empty($results[0]['order_data']))
									{
										
										foreach ($results AS $result)
										{
											$p->product_id = $result['product_id'];
											$product = $p->product();
											
											echo '<tr class="gradeX" id="row_'.$result['product_id'].'">
													<td width="50"><img src="'.$product['general']['img_t'].'" width="50"></td>
													<td style="min-width:200px;">'.$product['name'].'</td>
							                	  	<td>'.$result['order_product_price'].' </td>
							                	  	<td>'.$result['order_product_quantity'].' </td>
							                	  	<td>'.$product['general']['product_price_with_tax'].' </td>
							                	  	<td>'.$product['general']['product_code'].'  </td>
							                	  	<td>'.$product['general']['product_stock_amount'].' </td>
							                	  	<td class="center">';
														Input::$only_element = true;
														Input::$default = false;
														Input::$id = $result['product_id'];
							                	  		echo Input::select('order_product_status_id',  format_status_for_select(), $result['order_product_status']);
														Input::$id = false;
														Input::$only_element = false;
														Input::$default = true;
														echo '
							                	  		<a href="'.Routes::$base.'admin/product/'.$result['product_id'].'" class="buttonM bBlue ml10">'. __('Edit') .'</a>
							                	  		<a href="javascript:void(0);" onClick="delete_from_database(\'products_orders_products\', '.$result['product_id'].', \'row\');" class="buttonM bRed ml10">'. __('Del') .'</a>';
							                      		echo '
							                      	</td>
							                      </tr>';
										}
									}    
						            echo '
					            </tbody>
			                </table> 
			            </div>
			            <div class="clear"></div>
					</div>
				</div>
			</div>';	
	}
}
function invoice()
{
	$p = new _Product();
	
	$p->invoice_id = Routes::$get[1];
	$invoice = $p->invoices();;
	
	$p->shipping_id = $invoice['order_shipping_id'];
	$shipping = $p->shippings();
	
	$p->payment_id = $invoice['order_payment_id'];
	$payment = $p->payments($invoice['order_payment_id']);
	
	$p->payment_id = $invoice['order_payment_id'];
	$payment = $p->payments($invoice['order_payment_id']);
	
	$p->order_id = $invoice['order_id'];
	$results = $p->orders();
		
	$pay = new Payment();
	$pay->payment_id = $invoice['order_payment_id'];
	$installement = $pay->installements();
	
	echo '	<div class="wrapper">    
				<div class="fluid">
					<div class="widget grid12">
						<div class="whead">
							<h6>'.__('Invoice').'</h6>
							<div class="clear"></div>
				  		</div>
				  		<div class="body">
				  			<form class="main" enctype="multipart/form-data" method="post" action="'.Routes::$current.'">
								<fieldset>
									<div class="formRow">
										<label class="grid2">Fatura numarası:</label>
										<label class="grid10">'.$invoice['invoice_id'].'</label>
										<div class="clear"></div>
									</div>
									<div class="formRow">
										<label class="grid2">Sipariş numarası:</label>
										<label class="grid10"> '.$invoice['order_id'].'</label>
										<div class="clear"></div>
									</div>
									<div class="formRow">
										<label class="grid2">Sipariş tutarı:</label>
										<label class="grid10"> '.$invoice['order_total'].' TL</label>
										<div class="clear"></div>
									</div>';
									if (isset($shipping['shipping_name'])) 
									{
										echo '
										<div class="formRow">
											<label class="grid2">Kargo yöntemi:</label>
											<label class="grid10"> '.__($shipping['shipping_name']).'</label>
											<div class="clear"></div>
										</div>';
									}
									if (isset($payment['payment_name'])) 
									{
										echo '
										<div class="formRow">
											<label class="grid2">Ödeme yöntemi:</label>
											<label class="grid10"> '.__($payment['payment_name']).'</label>
											<div class="clear"></div>
										</div>';
									}
									
									if (isset($invoice['order_installement_id']) && isset($installement[$invoice['order_installement_id']]))
									{
										echo '	<div class="formRow">
													<label class="grid2">Taksit durumu:</label>
													<label class="grid10"> '.$invoice['order_installement_id'].' ( x'.$installement[$invoice['order_installement_id']].')</label>
													<div class="clear"></div>
												</div>';	
									}
									
									
									echo '
									<div class="formRow">
										<label class="grid2">Teslimat adresi:</label>
										<label class="grid10"> '.$invoice['order_name'].' </br>'.$invoice['order_address'].'/'.$invoice['order_city'].' </br>'.$invoice['order_tel_h'].'</label>
										<div class="clear"></div>
									</div>
									<div class="formRow">
										<label class="grid2">Fatura adresi:</label>
										<label class="grid10"> '.$invoice['invoice_name'].' </br>'.$invoice['invoice_address'].'/'.$invoice['invoice_city'].' </br>'.$invoice['invoice_tel_h'].'</label>
										<div class="clear"></div>
									</div>
									<div class="formRow">
							            <input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
					                    <input class="buttonS bBlue formSubmit grid10" type="submit" value="'.__('Print').'">
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>';
	
	echo '	<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
			    			<h6>'.__('Products').'</h6>
			    			<div class="clear"></div>
			    		</div>
		            
			            <div id="dyn" class="shownpars">
			                <a class="tOptions act" title="Options"><img src="'.Routes::$base.'cms/design/images/icons/options.png" alt="" /></a>
			                
			                <table cellpadding="0" cellspacing="0" border="0" class="dinamik_tablo tMedia" id="dynamic">
				                <thead>
					                <tr>
					                	<th>'. __('Image') .'</th>
						                <th>'. __('Name') .'</th>
						                <th>'. __('Price in order') .' </th>
						                <th>'. __('Quantity') .' </th>
						                <th>'. __('Current price') .' </th>
						                <th>'. __('Code') .' </th>
						                <th>'. __('Actions') .' </th>
						            </tr>
				                </thead>
				                <tbody>';
									if (!empty($results))
									{
										foreach ($results AS $result)
										{
											$p->product_id = $result['product_id'];
											$product = $p->product();
											
											echo '<tr class="gradeX" id="row_'.$result['product_id'].'">
													<td width="50"><img src="'.$product['general']['img_t'].'" width="50"></td>
													<td style="min-width:200px;">'.$product['name'].'</td>
							                	  	<td>'.$result['order_product_price'].' </td>
							                	  	<td>'.$result['order_product_quantity'].' </td>
							                	  	<td>'.$product['general']['product_price_with_tax'].' </td>
							                	  	<td>'.$product['general']['product_code'].'  </td>
							                	  	<td><a href="'.Routes::$base.'admin/product/'.$result['product_id'].'" class="buttonM bDefault ml10">'. __('Details') .'</a></td>
												  </tr>';
										}
									}    
						            echo '
					            </tbody>
			                </table> 
			            </div>
			            <div class="clear"></div>
					</div>
				</div>
			</div>';		
}
function invoices()
{
	$p = new _Product();
	
	$table = new Dynamic_forms();
	
	$table->table = 'products_invoices';
	$table->data = $p->invoices();
	
	$table->title = __('Invoices');
	$table->link = 'invoice';
								
	$table->th = array(0=>'Name', 
					   1=>'Address',
					   2=>'City',
					   3=>'Postal code',
					   4=>'Tel');	
					   
	$table->td = array(0=>'invoice_name', 
					   1=>'invoice_address',
					   2=>'invoice_city',
					   3=>'invoice_postal',
					   4=>'invoice_tel_h');
					   								
	$table->data_list();
}
function coupons()
{
	$table = new Dynamic_forms();

	$table->data = select('coupons')->results();
	
	$table->title = __('Coupons');
	$table->link = 'dynamic-row/coupons/coupon_id'.Routes::$get[1];
								
	$table->th = array(0=>__('Coupon name'), 
					   1=>__('Coupon code'),
					   2=>__('Coupon value'),
					   3=>__('Coupon amount'));	
					   
	$table->td = array(0=>'coupon_name', 
					   1=>'coupon_code',
					   2=>'coupon_value',
					   3=>'coupon_amount');
					   								
	$table->data_list();	
}
function gallery()
{
	global $setting, $site;
	
	$album = new _Gallery();
	$album->gallery_format = false;
	echo $album->edit_gallery();
	
	$gallery = $album->gallery(Routes::$get[1]);
	
	echo '	<div class="wrapper">    
				<div class="fluid">
					<div class="widget grid12">
						<div class="whead">
							<h6>'. __('Gallery') .': '.$gallery['gallery_title'].'</h6>
							<div class="clear"></div>
				  		</div>
				  		<div class="body">
				  			<form class="main" enctype="multipart/form-data" method="post" action="'. Routes::$current .'">
								<fieldset>';
									if ($setting['multi_lang'])
										echo Input::select('lang_id', format_langs_for_select(), $gallery['lang_id']);
									
									echo 
									Input::text('gallery_title', $gallery['gallery_title']).
									Input::textarea('gallery_text', $gallery['gallery_text']).
			            			Input::date('gallery_date', $site['today']).
			            			'<div class="nNote nInformation"><p>'. __('w_gallery_img').'</p></div>'.
			            			Input::finder('gallery_img', $gallery['gallery_img']).
			            			'<div class="nNote nInformation"><p>'. __('w_gallery_data_thumb').'</p></div>'.
			            			Input::text('thumb_w', $gallery['gallery_thumb_w']).
			            			Input::text('thumb_h', $gallery['gallery_thumb_h']).
			            			'<div class="nNote nInformation"><p>'. __('w_gallery_data_crop').'</p></div>'.
			            			Input::text('crop_w', $gallery['gallery_crop_w']).
			            			Input::text('crop_h', $gallery['gallery_crop_h'])
			            			.'
				                    <div class="formRow">
							            <input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
					                    <input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Save') .'">
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>';	
}
/* New gallery */
function gallery_new()
{
	global $setting, $site;
	
	$album = new _Gallery();
	echo $album->add_gallery();
	
	echo '	<div class="wrapper">    
				<div class="fluid">
					<div class="widget grid12">
						<div class="whead">
							<h6>'. __('New') .'</h6>
							<div class="clear"></div>
				  		</div>
				  		<div class="body">
				  			<form class="main" enctype="multipart/form-data" method="post" action="'. Routes::$current .'">
								<fieldset>';
									if ($setting['multi_lang'])
										echo Input::select('lang_id', format_langs_for_select(), $_SESSION['lang_id']);
									
									echo 
									Input::text('gallery_title').
									Input::textarea('gallery_text');
									
									if ($setting['gallery_has_location'] == 'on')
										echo Input::map('gallery');
										
									echo 
			            			Input::date('gallery_date', $site['today']).
			            			'<div class="nNote nInformation"><p>'. __('Cover photo of the album') .'</p></div>'.
			            			Input::finder('gallery_img').
			            			'<div class="nNote nInformation"><p>'. __('Size of thumb, width and height') .'</p></div>'.
			            			Input::text('thumb_w', $setting['thumb_w']).
			            			Input::text('thumb_h', $setting['thumb_h']).
			            			'<div class="nNote nInformation"><p>'. __('Size of image, width and height') .'</p></div>'.
			            			Input::text('crop_w', $setting['crop_w']).
			            			Input::text('crop_h', $setting['crop_h'])
			            			.'
				                    <div class="formRow">
							            <input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
					                    <input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Add') .'">
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>';
}
/* Add image or video to a gallery */
function gallery_data()
{
	global $setting, $site;
	
	//gnc_model_albume_resim_ekle();
	$album = new _Gallery();
	$gallery = $album->gallery(Routes::$get[1]);
	
	echo $album->add_data_to_gallery();
	?>
	<script type="text/javascript">
	// CK Finder image selector
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
		
		$('#gallery_data_image_path').val(fileUrl);
		
		// Seçili resmin küçük halini gösterelim
		$('#secili_resim_div').show();
		$('#cropbox').attr('src', image_path+text);
		$('#image_select').hide();
		$('#image_cancel').show();
		
		$('#cropbox').Jcrop({
			onChange: showCoords,
			onSelect: showCoords,
			minSize: [ 310, 215 ],
			maxSize: [ 310, 215 ]
		});	
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
	$('#gallery_data_type').live('change', function(){
		if ($(this).val() == 1)
		{
			$('#gallery_data_image').show();
			$('#gallery_data_video').hide();
		}
		else
		{
			$('#gallery_data_video').fadeIn();
			$('#gallery_data_image').hide();
		}
	})
	</script>
	<?php
		
	echo '	<div class="wrapper">    
				<div class="fluid">
					<div class="widget grid12">
						<div class="whead">
							<h6>'.$gallery['gallery_title'] .'</h6>
							<div class="clear"></div>
						</div>
		  				<div class="body">
		  					<form class="main" enctype="multipart/form-data" method="post" action="'. Routes::$current .'">';
		  						Input::$default = false;
								$type[0]['id'] = 1;
								$type[0]['value'] = __('Image');
								$type[1]['id'] = 2;
								$type[1]['value'] = __('Video');
								echo Input::select('gallery_data_type', $type);
		  						echo '
		  						<fieldset>
		  							<div id="gallery_data_image">
			  							<div class="nNote nInformation">
											<p>'. __('w_add_image_to_gallery') .'</p>
										</div>
			  							<div class="formRow">
			  							
			  								<div class="grid2">
							    				<label>'. __('Image') .'</label>
							    			</div>
					                        <a class="buttonM bGreen first grid5" id="image_select" onclick="BrowseServer( \'Images:/\', \'gallery_data_image\' );">'. __('Select image to add').'</a>
					                        <a class="buttonM bBlack first grid5" id="image_cancel" style="display:none;" href="'.Routes::$current.'">'. __('Select another one').'</a>
				                            
				                            <input id="gallery_data_image_path" name="gallery_data_image" type="hidden" size="60" value=""/>
					                        
					                        <div class="none">
												<label>X1 <input type="text" size="4" id="x"  name="x"  /></label>
												<label>Y1 <input type="text" size="4" id="y"  name="y"  /></label>
												<label>X2 <input type="text" size="4" id="x2" name="x2" /></label>
												<label>Y2 <input type="text" size="4" id="y2" name="y2" /></label>
												<label>W  <input type="text" size="4" id="w"  name="w"  /></label>
												<label>H  <input type="text" size="4" id="h"  name="h"  /></label>
											</div>
											<div id="sonuc"></div>
					                        <div class="clear"></div>  
					                    </div>
					                    <div class="formRow none" id="secili_resim_div">
			  								<div class="grid12">
			  									<div class="gallery">
			  										<ul><li><img src="" id="cropbox"></li></ul>
			  									</div>
			  								</div>
			  								<div class="clear"></div> 
			  							</div>
			  							'.
				            			Input::text('gallery_data_text')
				            			.'
		  							</div>
		  							<div id="gallery_data_video" class="none">
		  								<div class="nNote nInformation">
											<p>'. __('w_add_video_to_gallery').'</p>
										</div>';
		  								echo Input::textarea('gallery_vid');
										echo Input::text('gallery_video_text');
									echo '
		  							</div>
		  							<div class="formRow">
							            <input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel').'">
					                    <input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Add').'">
									</div>
								</fieldset>
							</form>
						</div>
					</div>
					<div class="clear"></div>
			    </div>				    
			</div>';
			
			
			$gallery = $album->gallery_data(Routes::$get[1]);

			if (empty($gallery))
			{
				echo '	<div class="nNote nFailure">
							<p>'. __('Nothing found').'</p>
						</div>';
			}
			else 
			{
				echo '
				<div class="wrapper">    
					<div class="fluid">
						<div class="widget grid12">
							<div class="whead">
								<h6>'. __('Gallery data') .'</h6>
								<div class="clear"></div>
							</div>
			  				<div class="body">
			  					<div class="gallery">
			  						<ul>';
									foreach ($gallery AS $image)
									{
					                    echo '	<li id="row_'.$image['gallery_data_id'].'">';
					                    			if ($image['is_video'])
					                    				echo str_replace('width="640" height="360"', 'width="180" height="100"', $image['gallery_data_path']);
													else
														echo '<a href="'.$site['image_path'].$image['gallery_data_path'].'" title="'.$image['gallery_data_path'].'" class="lightbox">
									                    		<img src="'.Routes::$base.$image['gallery_data_path'].'" alt="'.$image['gallery_data_text'].'" style="height:100px; max-width="180px;"/>
									                    	</a>';
							                    	echo '
							                        <a href="javascript:void(0);" onClick="delete_from_database(\'galleries_data\', '.$image['gallery_data_id'].', \'row\');" title="'. __('Delete') .'" class="galeri hover"><img src="'.Routes::$base.'cms/design/images/icons/delete.png" alt="" /></a>
												</li>
							                    ';
		       						}
							echo '  </ul>
								</div>
							</div>
						<div class="clear"></div>
				    </div>				    
				</div>';	
			}
			
}
// Albümleri listeleyelim
function galleries()
{
	global $setting, $site;
	
	// Kategorinin altındaki alt kategorileri ağaç yapısı içinde gösteren fonksiyon
	$album = new _Gallery();
	$galleries = $album->galleries()
	?>
	<script type="text/javascript">
	$(function() {	
		// Veritabanı bilgilerini
		table = 'galleries';
		column = 'gallery';
		// Sıralama özellikleri
		kategori_sayisi = 1; // 1 olması alt kategori olmayacak anlamına gelir

		$('ol.sortable').nestedSortable({
			forcePlaceholderSize: true,
			handle: 'div',
			helper:	'clone',
			items: 'li',
			opacity: .6,
			placeholder: 'placeholder',
			revert: 250,
			tabSize: 25,
			tolerance: 'pointer',
			toleranceElement: '> div',
			maxLevels: kategori_sayisi,
	
			isTree: false,
			expandOnHover: 700,
			startCollapsed: true
		});
	
		$('.disclose').on('click', function() {
			$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
		});
	
		$('#serialize').on('click', function() {
			serialized = $('ol.sortable').nestedSortable('serialize');
			$('#serializeOutput').text(serialized+'\n\n');
			
			$('#loading').fadeIn();
			$.ajax({
				url: ajax_cms+"serialize_in_database/"+table+"/"+column,
				type: "POST",       
				data: serialized,   
				cache: false,
				success: function (response) {
					$('#loading').fadeOut();
				}
			});	
		});
			
	});
	</script>
	<?php
	
	echo '	<div class="wrapper">    
				<div class="fluid">
					<div class="widget grid12">
						<div class="whead">
							<h6>'. __('Galleries') .'</h6>
							<div class="clear"></div>
						</div>
		  				<div class="body">';
		  					
							// Drag & Drop ile sıralama için gerekli olan yapı, $ic_kategori ana kategori olmadığını bir parent kategorinin child'ı durumunu ifade etmektedir.
							echo '<ol class="sortable">';
							foreach ($galleries AS $result)
							{
								echo '<li id="list_'.$result['gallery_id'].'">
										<div id="gallery-list">
											<img src="'.$result['gallery_img'].'" style="margin: 10px; height:100px; min-width:120px; max-width:240px;">
											<span style="display: inline-block; margin-top:10px; position: absolute; width: 900px;">
												<a href="'.Routes::$base.Routes::$module.'/gallery/'.$result['gallery_sef'].'">
													<h4>'. $result['gallery_title'] .' ('.$result['gallery_date'].') '. $result['gallery_public'] .'</h4>
												</a>
												<p><strong>'. __('Number of photo').':</strong> '. $result['gallert_pic_count'] .' </p>
												<p><strong>'. __('Description').':</strong> '. $result['gallery_text'] .' </p>
												<p>'.__('Width of thumb').': <strong>'.$result['gallery_thumb_w'].'px</strong>, '.__('Height of thumb').': <strong>'.$result['gallery_thumb_h'].'px</strong></p>
												<p>'.__('Width of photo').': <strong>'.$result['gallery_crop_w'].'px</strong>, '.__('Height of thumb').': <strong>'.$result['gallery_crop_h'].'px</strong></p>
											</span>
											<a href="'.Routes::$base.Routes::$module.'/gallery-data/'.$result['gallery_sef'].'" class="sortable_silme_tusu hover" style="margin-right:250px;"><img src="'.Routes::$base.'cms/design/images/icons/add.png" alt="" /><span>'. __('Add').'/'.__('Edit').'</span></a>
											<a href="'.Routes::$base.Routes::$module.'/gallery/'.$result['gallery_sef'].'" class="sortable_silme_tusu hover" style="margin-right:125px;"><img src="'.Routes::$base.'cms/design/images/icons/update.png" alt="" /><span>'. __('Details').'</span></a>';
											if ($result['is_erasable'] == 1)
												echo '	<a href="javascript:void(0);" onClick="delete_from_database(\'galleries\', '.$result['gallery_id'].', \'list\');" class="sortable_silme_tusu hover" style="margin-right:30px;"><img src="'.Routes::$base.'cms/design/images/icons/delete.png" alt="" /><span>'. __('Delete') .'</span></a>';
										echo '
										</div>';
								echo '</li>';
							}
							echo '</ol>';
							
							echo '	<div class="formRow border-0 padding-0 padding-bottom-35">
										<a id="serialize" class="buttonM bBlue grid12" href="javascript:void(0);">
											<span class="icon-export"></span>
											<span>'.__('Save').'</span>
										</a>
										<!--<pre id="serializeOutput"></pre>-->
									</div>';
		  				echo '
				  		</div>
				  	</div>
				</div>
			</div>';
}
function menu_edit()
{
	
}
function menu_new()
{
	global $setting;
	
	$m = new _Menu();
	echo $m->add_menu();
	
	echo '	<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
						<div class="whead">
							<h6>'. __('New') .'</h6>
							<div class="clear"></div>
						</div>
				    	<div class="menu_body">
				    		<form class="main" enctype="multipart/form-data" method="post" action="'. Routes::$current .'">
								<fieldset>';
									if ($setting['multi_lang'])
										echo Input::select('lang_id', format_langs_for_select(), $_SESSION['lang_id']);
								
									echo Input::text('menu_name');
									echo Input::text('menu_text');
							   	
									echo '
									<div class="formRow">
						            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
				                    	<input class="buttonS bBlue formSubmit grid10" name="menu_add" type="submit" value="'. __('Add') .'">
				                    </div>
						        </fieldset>
						      </form>
				          </div>
						</div>
					</div>
				</div>';
}
function menu_order()
{
	global $setting;
	
	$m = new _Menu();
	
	$menus = $m->menus();
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
						<h6>'. __('Menus') .'</h6>
						<div class="clear"></div>
					</div>
					<div class="body">';
						?>
						<script>
						function menu_data()
						{
							// HTML'deki verileri JS'ye al
							menu_id = $('#menu_id').val()
							// Ajax'a gönderilecek hale getir
							var veri = {
					    		menu_id: menu_id
					  		}  	
					  		$('#loading').fadeIn();
							$.ajax({
								url: ajax_cms+"menu_data_for_serialize",      
								type: "POST",       
								data: veri,   
								cache: false,
								success: function (response) {
									$('#serialize_menu_data').html(response);	 // Ajax'ın cevabını ekrana yazdır
									$(".select").chosen(); 										 // Gerekliyse ajax'tan gelen veri için kullanılacak jquery'i rebind et
									$('#loading').fadeOut();
									
									$('ol.sortable').nestedSortable({
										forcePlaceholderSize: true,
										handle: 'div',
										helper:	'clone',
										items: 'li',
										opacity: .6,
										placeholder: 'placeholder',
										revert: 250,
										tabSize: 25,
										tolerance: 'pointer',
										toleranceElement: '> div',
										maxLevels: 9,
								
										isTree: true,
										expandOnHover: 700,
										startCollapsed: true
									});
								
									$('.disclose').on('click', function() {
										$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
									})
								
									$('#serialize').on('click', function() {
										serialized = $('ol.sortable').nestedSortable('serialize');
										$('#serializeOutput').text(serialized+'\n\n');
										
										$('#loading').fadeIn();
										$.ajax({
											url: ajax_cms+"serialize_menu_data",
											type: "POST",       
											data: serialized,   
											cache: false,
											success: function (response) {
												$('#loading').fadeOut();
											}
										});	
									});
								}
							});
						}
						</script>
						<?php
						echo '
			            <div class="formRow">
			            	<div class="grid2"><label>'. __('Menu') .'</label></div>
		                    <div class="grid10 searchDrop">
		                        <select data-placeholder="'. __('Select') .'" class="select" id="menu_id" onChange="menu_data();" style="width:350px;" tabindex="2">
		                            <option value=""></option>'; 
									foreach ($menus AS $result)
				                    	echo '<option value="'.$result['menu_id'].'">'.$result['menu_name'].'</option>'; 
		                        echo '    
		                        </select>
		                     </div>
		                     <div class="clear"></div>
			            </div>	
						<div id="serialize_menu_data"></div>
					</div>
				</div>
			</div>';
}
function menu_data()
{
	$m = new _Menu();
	echo $m->edit_menus_data();
	
	$menus = $m->menus();
	$data = $m->menu_data(Routes::$get[1]);
	
	echo '	<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
						<div class="whead">
							<h6>'. __('Edit') .'</h6>
							<div class="clear"></div>
						</div>
					    <div class="menu_body">
							<form class="main" enctype="multipart/form-data" method="post" action="'. Routes::$current .'">
								<fieldset>';
									echo Input::hidden('menu_data_id', Routes::$get[1]);
									
									Input::$label = __('Menus');
									echo Input::select('menu_id',  format_menus_for_select(), $data['menu_id']);
									Input::$label = false;
									echo '
									<div class="formRow">
				                        <div class="grid2"><label>'. $lang['menu_data_name'] . '</label></div>
				                        <div class="grid3"><input type="text" name="menu_data_name" value="'.$data['menu_data_name'].'"/></div>
				                        <div class="clear"></div>
						            </div>
						            <div class="formRow">
				                        <div class="grid2"><label>'. $lang['menu_data_href'] . '</label></div>
				                        <div class="grid3">
				                        	<input type="text" name="menu_data_href" class="arama" rel="search_possible_href" title="search_result_href" placeholder="http://" value="'.$data['menu_data_href'].'"/>
				                        	<span class="note">'. $lang['w_href'] . '</span>
				                        </div>
				                        <!-- Search results -->
	               						<div class="sResults search_result_href none" style="left: 237px; width:283px; margin-top: 30px; position: absolute; z-index: 999;"></div>
				                        <div class="clear"></div>
						            </div>';
						            
						            Input::$default = false;
									Input::$note = __('w_target');
									echo Input::select('menu_data_target', _menu_target(), $data['menu_data_target']);
									
						            echo '
						            <div class="formRow">
						            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
				                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Save') .'" name="edit_menus_data">
				                    </div>
						        </fieldset>
						     </form>   
				        </div>
					</div>
				</div>
			</div>';
}
function menu_data_new()
{
	$m = new _Menu();
	
	$menus = $m->menus();
	echo $m->add_menus_data();
	
	echo '	<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
						<div class="whead">
							<h6>'. __('New') .'</h6>
							<div class="clear"></div>
						</div>
					    <div class="menu_body">
							<form class="main" enctype="multipart/form-data" method="post" action="'. Routes::$current .'">
								<fieldset>
									<div class="formRow">
						            	<div class="grid2"><label>'. __('Menus') .'</label></div>
						                <div class="grid3 searchDrop">
						                    <select data-placeholder="'. __('Select') .'" class="select" name="menu_id" style="width:350px;" tabindex="2">'; 
												foreach ($menus AS $menu)
						                        	echo '<option value="'.$menu['menu_id'].'">'.$menu['menu_name'].'</option>'; 
													
						                    echo '    
						                    </select>
						                 </div>
						                 <div class="clear"></div>
						            </div>
						    		<div class="formRow">
				                        <div class="grid2"><label>'. __('Name') . '</label></div>
				                        <div class="grid3"><input type="text" name="menu_data_name"/></div>
				                        <div class="clear"></div>
						            </div>
						            <div class="formRow">
				                        <div class="grid2"><label>'. __('URL') . '</label></div>
				                        <div class="grid3">
				                        	<input type="text" name="menu_data_href" class="search-string" rel="search_possible_href"  title="search_result_href" placeholder="http://"/>
				                        </div>
				                        <!-- Search results -->
	               						<div class="sResults search_result_href none" style="left: 237px; width:283px; margin-top: 30px; position: absolute; z-index: 999;"></div>
				                        <div class="clear"></div>
						            </div>';
									
									Input::$default = false;
									echo Input::select('menu_data_target', _menu_target());
									
									echo '
						            <div class="formRow">
						            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
				                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Save') .'" name="add_menus_data">
				                    </div>
						        </fieldset>
						     </form>   
				        </div>
					</div>
				</div>
			</div>';
}
function popup()
{
	global $setting;
	
	$p = new _Popup();
	
	echo $p->edit_popup();
	
	$popup = $p->popup_by_lang();

	Input::$required = false;
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
							<h6>'. __('Popup') .'</h6>
							<div class="clear"></div>
						</div>
						<div class="body">
							<form action="'.Routes::$current.'" class="main" method="post" id="usualValidate" novalidate="novalidate">
								<fieldset>';
									Input::$default = false;
									echo Input::select('is_public', format_true_false('Public','Not public'), $popup['is_public']);
									
									// Language id
									if ($setting['multi_lang'])
									{
										Input::$disabled = true;
										echo Input::select('lang_id',  format_langs_for_select(), $_SESSION['lang_id']);
									}
									Input::$disabled = false;
									echo Input::finder('image', $popup['popup_img']);
									
									Input::$note = __('Width of image in the popup window');
									echo Input::text('image_width', $popup['popup_img_width']);
									Input::$note = false;
									
									echo Input::editor('popup_text', $popup['popup_text']);
									
									Input::$note = __('What will happen on click');
									echo Input::text('popup_href', $popup['popup_img']);
									Input::$note = false;
									
									Input::$default = false;
									echo Input::select('target', _menu_target(), $popup['popup_target']);
									
									Input::$note = __('Width of popup window');
									echo Input::text('window_width', $popup['popup_width']);
									Input::$note = __('Height of popup window');
									echo Input::text('window_height', $popup['popup_height']);
									Input::$note = false;
									echo '
									<div class="formRow">
							            <div class="grid2">
											<div class="wButton">
												<a class="buttonL bRed first">'.__('Delete') .'</a>
											</div>
										</div>
					                    <div class="grid10">
											<div class="wButton">
												<button type="submit" name="edit" class="buttonL bLightBlue first">'.__('Save') .'</button>
											</div>
										</div>
									</div>
					    		</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>'; 
}
function slide_new()
{
	global $setting;
	
	$slide_group = 1;
	$s = new _Slide();
	
	echo $s->add_slide();
	
	echo '	<div class="wrapper">    
				<div class="fluid">
					<div class="widget grid12">
						<div class="whead">
							<h6>'. __('New') .'</h6>
							<div class="clear"></div>
		  				</div>
		  				<div class="body">
		  					<form class="main" enctype="multipart/form-data" method="post" action="'.Routes::$current.'">
								<fieldset>';
								
									if ($setting['multi_lang'])
										echo Input::select('lang_id', format_langs_for_select(), $_SESSION['lang_id']);
									
									if (Routes::$get[1] == 1)
										Input::$note = __('Image dimension should be :thumb_w px and height :thumb_h px', array('thumb_w'=>$setting['slide_w'],'thumb_h'=>$setting['slide_h']));
									else 
										Input::$note = __('Image dimension should be :thumb_w px and height :thumb_h px', array('thumb_w'=>$setting['slide_w'],'thumb_h'=>$setting['slide_h']));
									
									echo Input::finder('slide_img');
									Input::$note = false;
									echo Input::text('slide_title');
									echo Input::text('slide_text');
									echo Input::hidden('slide_group', Routes::$get[1]);
									echo '
									<div class="formRow">
				                        <div class="grid2"><label>'. __('URL') . '</label></div>
				                        <div class="grid3">
				                        	<input type="text" name="slide_href" class="search-string" rel="search_possible_href"  title="search_result_href" placeholder="http://"/>
				                        	<span class="note">'. __('What will happen on click') . '</span>
				                        </div>
				                        <!-- Search results -->
	               						<div class="sResults search_result_href none" style="left: 237px; width:283px; margin-top: 30px; position: absolute; z-index: 999;"></div>
				                        <div class="clear"></div>
						            </div>';
									Input::$default = false;
						            echo Input::select('slide_target', _menu_target());
						            echo '
						            <div class="formRow">
						            	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel').'">
				                    	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Add') .'" name="add_slide">
				                    </div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>';	
}
function slide_order()
{
	global $setting, $site;
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
						<h6>'. __('Slides') .'</h6>
						<div class="clear"></div>
					</div>
					<div class="body">';
					  
						if ($setting['multi_lang'])
						{
							echo '	<input type="hidden" name="slide_group" id="slide_group" value="'.Routes::$get[1].'"/>';	
							?>
							<script>
							function slides_by_lang()
							{
								// HTML'deki verileri JS'ye al
								lang_id = $('#lang_id').val();
								slide_group = $('#slide_group').val();
								// Ajax'a gönderilecek hale getir
								var veri = {
						    		lang_id: lang_id,
						    		slide_group: slide_group
						  		}  	
						  		$('#loading').fadeIn();
								$.ajax({
									url: ajax_cms+"slides_for_serialize",      
									type: "POST",       
									data: veri,   
									cache: false,
									success: function (response) {
										$('#serialize_slides').html(response);	 // Ajax'ın cevabını ekrana yazdır
										$(".select").chosen(); 										 // Gerekliyse ajax'tan gelen veri için kullanılacak jquery'i rebind et
										$('#loading').fadeOut();
										
										$('ol.sortable').nestedSortable({
											forcePlaceholderSize: true,
											handle: 'div',
											helper:	'clone',
											items: 'li',
											opacity: .6,
											placeholder: 'placeholder',
											revert: 250,
											tabSize: 25,
											tolerance: 'pointer',
											toleranceElement: '> div',
											maxLevels: 1,
									
											isTree: true,
											expandOnHover: 700,
											startCollapsed: true
										});
									
										$('.disclose').on('click', function() {
											$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
										})
									
										$('#serialize').on('click', function() {
											serialized = $('ol.sortable').nestedSortable('serialize');
											$('#serializeOutput').text(serialized+'\n\n');
											
											$('#loading').fadeIn();
											$.ajax({
												url: ajax_cms+"serialize_slides",
												type: "POST",       
												data: serialized,   
												cache: false,
												success: function (response) {
													$('#loading').fadeOut();
												}
											});	
										});
									}
								});
							}
							</script>
							<?php
							echo '
				            <div class="formRow">
				            	<div class="grid2"><label>'. __('Lang') .'</label></div>
			                    <div class="grid10 searchDrop">
			                        <select data-placeholder="'. __('Select').'" class="select" id="lang_id" onChange="slides_by_lang();" style="width:350px;" tabindex="2">
			                            <option value=""></option>'; 
										foreach (langs() AS $result)
					                    	echo '<option value="'.$result['lang_id'].'">'.$result['lang_name'].'</option>'; 
			                        echo '    
			                        </select>
			                     </div>
			                     <div class="clear"></div>
				            </div>';
				        }
						else 
						{
							echo '	<input type="hidden" name="lang_id" id="lang_id" value="'.$setting['default_lang_id'].'"/>
									<input type="hidden" name="slide_group" id="slide_group" value="'.Routes::$get[1].'"/>';	
						?>
							<script type="text/javascript">
							$(function() {	
								// HTML'deki verileri JS'ye al
								lang_id = $('#lang_id').val();
								slide_group = $('#slide_group').val();
								// Ajax'a gönderilecek hale getir
								var veri = {
						    		lang_id: lang_id,
						    		slide_group: slide_group
						  		}  	
						  		$('#loading').fadeIn();
								$.ajax({
									url: ajax_cms+"slides_for_serialize",      
									type: "POST",       
									data: veri,   
									cache: false,
									success: function (response) {
										$('#serialize_slides').html(response);	 // Ajax'ın cevabını ekrana yazdır
										$(".select").chosen(); 										 // Gerekliyse ajax'tan gelen veri için kullanılacak jquery'i rebind et
										$('#loading').fadeOut();
										
										$('ol.sortable').nestedSortable({
											forcePlaceholderSize: true,
											handle: 'div',
											helper:	'clone',
											items: 'li',
											opacity: .6,
											placeholder: 'placeholder',
											revert: 250,
											tabSize: 25,
											tolerance: 'pointer',
											toleranceElement: '> div',
											maxLevels: 1,
									
											isTree: true,
											expandOnHover: 700,
											startCollapsed: true
										});
									
										$('.disclose').on('click', function() {
											$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
										})
									
										$('#serialize').on('click', function() {
											serialized = $('ol.sortable').nestedSortable('serialize');
											$('#serializeOutput').text(serialized+'\n\n');
											
											$('#loading').fadeIn();
											$.ajax({
												url: ajax_cms+"serialize_slides",
												type: "POST",       
												data: serialized,   
												cache: false,
												success: function (response) {
													$('#loading').fadeOut();
												}
											});	
										});
									}
								});
							});
							</script>
						<?php
						}
						echo '	<div id="serialize_slides"></div>
						</div>
					</div>
				</div>
			</div>';
}
function faqs()
{
	$table = new Dynamic_forms();

	$table->data = select('faqs')->results();
	
	$table->title = __('faqs');
	$table->link = 'dynamic-row/faqs/faq_id';
								
	$table->th = array(0=>__('Question'), 
					   1=>__('Answer'));	
					   
	$table->td = array(0=>'faq_question', 
					   1=>'faq_answer');
					   								
	$table->data_list();	
}
function faq_order()
{
	global $setting, $site;
	
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
						<h6>'. __('Faqs') .'</h6>
						<div class="clear"></div>
					</div>
					<div class="body">';
					  
						if ($setting['multi_lang'])
						{
							?>
							<script>
							function faqs_by_lang()
							{
								// HTML'deki verileri JS'ye al
								lang_id = $('#lang_id').val()
								// Ajax'a gönderilecek hale getir
								var veri = {
						    		lang_id: lang_id
						  		}  	
						  		$('#loading').fadeIn();
								$.ajax({
									url: ajax_cms+"faqs_for_serialize",      
									type: "POST",       
									data: veri,   
									cache: false,
									success: function (response) {
										$('#serialize_slides').html(response);	 // Ajax'ın cevabını ekrana yazdır
										$(".select").chosen(); 										 // Gerekliyse ajax'tan gelen veri için kullanılacak jquery'i rebind et
										$('#loading').fadeOut();
										
										$('ol.sortable').nestedSortable({
											forcePlaceholderSize: true,
											handle: 'div',
											helper:	'clone',
											items: 'li',
											opacity: .6,
											placeholder: 'placeholder',
											revert: 250,
											tabSize: 25,
											tolerance: 'pointer',
											toleranceElement: '> div',
											maxLevels: 1,
									
											isTree: true,
											expandOnHover: 700,
											startCollapsed: true
										});
									
										$('.disclose').on('click', function() {
											$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
										})
									
										$('#serialize').on('click', function() {
											serialized = $('ol.sortable').nestedSortable('serialize');
											$('#serializeOutput').text(serialized+'\n\n');
											
											$('#loading').fadeIn();
											$.ajax({
												url: ajax_cms+"serialize_faqs",
												type: "POST",       
												data: serialized,   
												cache: false,
												success: function (response) {
													$('#loading').fadeOut();
												}
											});	
										});
									}
								});
							}
							</script>
							<?php
							echo '
				            <div class="formRow">
				            	<div class="grid2"><label>'. __('Lang') .'</label></div>
			                    <div class="grid10 searchDrop">
			                        <select data-placeholder="'. __('Select') .'" class="select" id="lang_id" onChange="faqs_by_lang();" style="width:350px;" tabindex="2">
			                            <option value=""></option>'; 
										foreach (langs() AS $result)
					                    	echo '<option value="'.$result['lang_id'].'">'.$result['lang_name'].'</option>'; 
			                        echo '    
			                        </select>
			                     </div>
			                     <div class="clear"></div>
				            </div>';
				        }
						else 
						{
							echo '<input type="hidden" name="lang_id" value="'.$setting['default_lang_id'].'"/>';	
						?>
							<script type="text/javascript">
							$(function() {	
								// HTML'deki verileri JS'ye al
								lang_id = <?php echo $setting['default_lang_id']; ?>
								// Ajax'a gönderilecek hale getir
								var veri = {
						    		lang_id: lang_id
						  		}  	
						  		$('#loading').fadeIn();
								$.ajax({
									url: ajax_cms+"faqs_for_serialize",      
									type: "POST",       
									data: veri,   
									cache: false,
									success: function (response) {
										$('#serialize_slides').html(response);	 // Ajax'ın cevabını ekrana yazdır
										$(".select").chosen(); 					 // Gerekliyse ajax'tan gelen veri için kullanılacak jquery'i rebind et
										$('#loading').fadeOut();
										
										$('ol.sortable').nestedSortable({
											forcePlaceholderSize: true,
											handle: 'div',
											helper:	'clone',
											items: 'li',
											opacity: .6,
											placeholder: 'placeholder',
											revert: 250,
											tabSize: 25,
											tolerance: 'pointer',
											toleranceElement: '> div',
											maxLevels: 1,
									
											isTree: true,
											expandOnHover: 700,
											startCollapsed: true
										});
									
										$('.disclose').on('click', function() {
											$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
										})
									
										$('#serialize').on('click', function() {
											serialized = $('ol.sortable').nestedSortable('serialize');
											$('#serializeOutput').text(serialized+'\n\n');
											
											$('#loading').fadeIn();
											$.ajax({
												url: ajax_cms+"serialize_faqs",
												type: "POST",       
												data: serialized,   
												cache: false,
												success: function (response) {
													$('#loading').fadeOut();
												}
											});	
										});
									}
								});
							});
							</script>
						<?php
						}
						echo '	<div id="serialize_slides"></div>
						</div>
					</div>
				</div>
			</div>';
}
function subscribers()
{
	$s = new _Subscriber();
	$subscribers = $s->subscribers();
	// Subscribers
	echo '	<div class="wrapper">    
				<div class="fluid">
					<div class="widget grid12">
						<div class="whead">
							<h6>'.__('Subscribers').'</h6>
							<div class="clear"></div>
				  		</div>
				  		<div class="body">
				  			<p>';
				  			foreach ($subscribers AS $subscriber)
								echo $subscriber['subscriber_email'].', ';
				  			echo '	</p>	
						</div>
					</div>
				</div>
			</div>';
	
	$u = new _User();
	$users = $u->users();		
	// Users
	echo '	<div class="wrapper">    
				<div class="fluid">
					<div class="widget grid12">
						<div class="whead">
							<h6>'.__('All_users').'</h6>
							<div class="clear"></div>
				  		</div>
				  		<div class="body">
				  			<p>';
				  			foreach ($users AS $user)
								echo $user['user_email'].', ';
				  			echo '	</p>	
						</div>
					</div>
				</div>
			</div>';	
			
	$subscribers = $s->subscribe_email1();
	// Subscribers
	echo '	<div class="wrapper">    
				<div class="fluid">
					<div class="widget grid12">
						<div class="whead">
							<h6>'.__('Remember_cart').'</h6>
							<div class="clear"></div>
				  		</div>
				  		<div class="body">
				  			<p>';
				  			foreach ($subscribers AS $subscriber)
								echo $subscriber['user_email'].', ';
				  			echo '	</p>	
						</div>
					</div>
				</div>
			</div>';
	
	$subscribers = $s->subscribe_email2();
	// Subscribers
	echo '	<div class="wrapper">    
				<div class="fluid">
					<div class="widget grid12">
						<div class="whead">
							<h6>'.__('Remember_old_product').'</h6>
							<div class="clear"></div>
				  		</div>
				  		<div class="body">
				  			<p>';
				  			foreach ($subscribers AS $subscriber)
								echo $subscriber['user_email'].', ';
				  			echo '	</p>	
						</div>
					</div>
				</div>
			</div>';
}
function backups()
{
	global $setting;
	
	$b = new _Database_backup();
	
	if (isset(Routes::$get[1]))
	{
		$b->add_backup();
		sleep(1);
		header('Location:'. Routes::$base.'admin/backups');
	}
	
	$backups = $b->backups();
	
	echo '	<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
			    			<h6>'. __('Backups').'</h6>
			    			<div class="clear"></div>
			    		</div>
			            <div id="dyn" class="hiddenpars">
			                <a class="tOptions" title="Options"><img src="'.Routes::$base.'cms/design/images/icons/options.png" alt="" /></a>
			                
			                <table cellpadding="0" cellspacing="0" border="0" class="dinamik_tablo" id="dynamic">
				                <thead>
					                <tr>
						                <th>'. __('Backup file') .'</th>
						                <th>'. __('Date') .'</th>
						                <th>'. __('Actions') .' </th>
					                </tr>
				                </thead>
				                <tbody>';
									foreach ($backups AS $result)
									{
										if (file_exists(Routes::$base.$result['database_backup_path']))
										{
											echo '	<tr class="gradeX" id="row_'.$result['database_backup_id'].'">
														<td><a href="'.Routes::$base.$result['database_backup_path'].'">'.$result['database_backup_path'].'</a></td>
														<td>'.date($setting['date_format']. ' H:i', $result['database_backup_time']).'</td>
														<td class="center">
															<a href="javascript:void(0);" onClick="delete_from_database(\'database_backups\', '.$result['database_backup_id'].', \'row\');" class="buttonM bRed ml10" style="color:#fff">'. __('Del') .'</a>
									                    </td>
													</tr>';
										}
									}
						            echo '
					            </tbody>
			                </table> 
			            </div>
			            <div class="clear"></div> 
					</div>
				</div>
			</div>
		</div>';
}
/** This function doesn't have a functional option
 * It's just showing possible input options that can Input class generate
 *
 * @return string
 */
function html_elements()
{
	echo '<!-- Main content -->
			<div class="wrapper">    
			    <div class="fluid">
			    	<div class="widget grid12">
			    		<div class="whead">
							<h6>'. __('New') .'</h6>
							<div class="clear"></div>
					  	</div>
					  	<div class="body">
						  	<form class="main" method="post" action="'. Routes::$current .'">
								<fieldset>';
								
									echo Input::text('text');
									echo Input::pass('pass');
									echo Input::browse('browse');
									echo Input::finder('finder');
									$data[0]['id'] = 'right';
									$data[0]['value'] = __('right');
									$data[1]['id'] = 'left';
									$data[1]['value'] = __('left');
									
									Input::$note = 'note_currency_side';
									echo Input::select('select', $data, 'right');
									
									Input::$note = false;
									
									echo Input::textarea('textarea');
									echo Input::editor('editor');
									echo Input::img('img', 'asdads');
									echo Input::date('content_time');
									echo Input::time('time');
									echo Input::color('color');
									echo Input::label('label');
									echo Input::hidden('hidden');
									echo Input::map('map');
									
									
									echo '
									<div class="formRow">
								    	<input class="buttonS bRed formSubmit grid2" type="reset" value="'. __('Cancel') .'">
						            	<input class="buttonS bBlue formSubmit grid10" type="submit" value="'. __('Add') .'">
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>';
}
/** Custom bot for product
 * 
 * Bots are very useful to gather content from allover the world
 * This function is just an exampla to show how to use simple_html_dom class
 * and how to insert data into database and save images into our side
 *
 * @access public
 * @var string
 */
function bot_for_product()
{
	// echo dirname(__FILE__);
	
	// ?manufacturer=6&url=http://www.sevil.com.tr/burberry-body-edp-bayan-parfum-85ml.html
	$manufacturer = Routes::$get[2];
	$manufacturer_name = Routes::$get[3];
	$url = 'http://www.sevil.com.tr/'.Routes::$get[4];
	
	$dom = new simple_html_dom();
	$html = file_get_html($url);
	
	foreach($html->find('div.product-name h1') as $e)
    	$data['name'] = $e->innertext;
	
	foreach($html->find('div.short-description div') as $e)
    	$data['desc'] = $e->innertext;
	
	$data['manufacturer'] = $manufacturer;
	
	foreach($html->find('p.old-price span.price') as $e)
    	$price = trim(str_replace('TL','',$e->innertext));
	
	if (!isset($price))
	{
		foreach($html->find('span.price') as $e)
    		$price = trim(str_replace('TL','',$e->innertext));
	}
	$p = explode(',', $price);
	$data['price'] = $p[0];
	
	foreach($html->find('#zoom-btn') as $e)
    	$data['image'] = $e->href;
	
	$data['img_c'] = 'Manufacturers/'.$manufacturer_name.'/720/'.sef($data['name']).'.jpg';
	$data['img_t'] = 'Manufacturers/'.$manufacturer_name.'/242/'.sef($data['name']).'.jpg';
	
	$folder = '/var/www/vhosts/xn--parfmal-q2a.com/httpdocs/data/_images/Manufacturers/'.$manufacturer_name.'/'.sef($data['name']).'.jpg';
	file_put_contents($folder, file_get_contents(trim($data['image'])));
	
	$handle = new Upload($folder);
		
	if ($handle->uploaded) 
	{
		//$handle->file_new_name_ext = '';
		$handle->image_resize	= true;
		$handle->image_ratio_y	= true;
		$handle->image_x = 720;
		
		// Pay attantion to file permissions
		$file = '/Applications/MAMP/htdocs/parfümal/data/_images/Manufacturers/'.$manufacturer_name.'/720';
		$handle->Process($file);
		
		//$handle->file_new_name_ext = '';
		$handle->image_resize	= true;
		$handle->image_ratio_y	= true;
		$handle->image_x = 438;
		
		$file = '/Applications/MAMP/htdocs/parfümal/data/_images/Manufacturers/'.$manufacturer_name.'/438';
		$handle->Process($file);
		
		//$handle->file_new_name_ext = '';
		$handle->image_resize	= true;
		$handle->image_ratio_y	= true;
		$handle->image_x = 242;
		
		$file = '/Applications/MAMP/htdocs/parfümal/data/_images/Manufacturers/'.$manufacturer_name.'/242';
		$handle->Process($file);
		
		//$handle->file_new_name_ext = '';
		$handle->image_resize	= true;
		$handle->image_ratio_y	= true;
		$handle->image_x = 110;
		
		$file = '/Applications/MAMP/htdocs/parfümal/data/_images/Manufacturers/'.$manufacturer_name.'/110';
		$handle->Process($file);
	}

	return $data;
}
