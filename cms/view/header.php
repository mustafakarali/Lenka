<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		
		<title><?php echo Seo::title(); ?></title>
		
		<!-- Jquery ve jquery-ui -->
		<script type="text/javascript" src="<?php echo Routes::$base; ?>core/js/jquery.js"></script> 
		<?php
		echo '
		<script type="text/javascript">
		<!-- // --><![CDATA[
			var site_path = "'.Routes::$base.'";
			var image_path = "'.$site['image_path'].'";
			var file_path = "'.$site['file_path'].'";
			
			var ajax_app = "'.Routes::$base.'ajax-app/";
			var ajax_cms = "'.Routes::$base.'ajax-cms/";
			var ajax = "'.Routes::$base.'ajax/";
			
			var page_timestamp = '.$site['timestamp'].';
			
			var session_life = "'.$setting['session_life'].'";
			var session_dead = "'. __('Session died') .'";
			
			var sSearch = "'. __('sSearch') .'";
			var sLengthMenu = "'. __('sLengthMenu')  .'";
			var sZeroRecords = "'. __('sZeroRecords')  .'";
			var sInfo = "'. __('sInfo')  .'";
			var sInfoEmpty = "'. __('sInfoEmpty')  .'";
			var sInfoFiltered = "'. __('sInfoFiltered')  .'";
			var sFirst = "'. __('sFirst')  .'";
			var sLast = "'. __('sLast')  .'";
			var sNext = "'. __('sNext')  .'";
			var sPrevious = "'. __('sPrevious')  .'";
			var fileDefaultText = "'. __('fileDefaultText') .'";
			var zeroRecords = "'.__('zeroRecords').'";
			
			var selectedFile = "'. __('selectedFile')  .'";
			var file_Url = "'. __('file_Url') .'";
			var file_Size = "'. __('file_Size') .'";
			var file_Date = "'. __('file_Date') .'";
			
			var config_fullcalendar = {
				editable: false,
				header: {
					left: "prev,next",
					center: "title",
					right:  "month,basicWeek,basicDay"
				},
				timeFormat: {
					agenda: "h(:mm)t{ - h(:mm)t}",
					"": "h(:mm)t{-h(:mm)t }"
				},
				monthNames: ["'.__('January').'","'.__('February').'","'.__('March').'","'.__('April').'","'.__('Mayis').'","'.__('June').'","'.__('July').'", "'.__('August').'", "'.__('September').'", "'.__('October').'", "'.__('November').'", "'.__('December').'" ], 
				monthNamesShort: ["'.__('Jan').'","'.__('Feb').'","'.__('Mar').'","'.__('Apr').'","'.__('May').'","'.__('Jun').'","'.__('Jul').'", "'.__('Aug').'", "'.__('Sep').'", "'.__('Oct').'", "'.__('Nov').'", "'.__('December').'"],
				dayNames: [ "'.__('Sunday').'","'.__('Monday').'","'.__('Tuesday').'","'.__('Wednesday').'","'.__('Thursday').'","'.__('Friday').'","'.__('Saturday').'"],
				dayNamesShort: ["'.__('Sun').'","'.__('Mon').'","'.__('Tue').'","'.__('Wed').'","'.__('Thu').'","'.__('Fri').'","'.__('Sat').'"],
				buttonText: {
					today: "'.__('Today') .'",
					month: "'.__('Month') .'",
					week: "'.__('Week') .'",
					day: "'.__('Day') .'"
				},
				events: '.$events = Calendar::events_json().'
			};
	
			var kategori_aylar = '. __('month_categories') .';
			
			var w_process_can_not_be_undone = "'.__('w_process_can_not_be_undone').'";
			var w_have_not_choose_language  = "'.__('w_have_not_choose_language').'";
			 			
			var crop_x = '.$setting['crop_w'].';
			var crop_y = '.$setting['crop_h'].';
			
			var dateformat = "'.$setting['date_format_ui'].'";
		// ]]>
		</script>';
		?>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/js/custom.js?<?php echo rand(1,10000); ?>"></script>
		
		<link href="<?php echo Routes::$base; ?>cms/design/css/styles.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo Routes::$base; ?>core/css/custom.css" rel="stylesheet" type="text/css" />
		<!--[if IE]> <link href="<?php echo Routes::$base; ?>cms/design/css/ie.css" rel="stylesheet" type="text/css"> <![endif]-->
		
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/forms/ui.spinner.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/forms/jquery.mousewheel.js"></script>
		
		<script type="text/javascript" src="<?php echo Routes::$base; ?>core/js/jquery-ui.js"></script> 
		
		<?php if ($_SESSION['lang_code'] == 'tr') { ?>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>core/js/datepicker-tr.js"></script>
		<?php } ?>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/charts/excanvas.min.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/charts/jquery.flot.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/charts/jquery.flot.orderBars.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/charts/jquery.flot.pie.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/charts/jquery.flot.resize.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/charts/jquery.sparkline.min.js"></script>
		
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/tables/jquery.dataTables.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/tables/jquery.sortable.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/tables/jquery.resizable.js"></script>
		
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/forms/autogrowtextarea.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/forms/jquery.uniform.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/forms/jquery.inputlimiter.min.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/forms/jquery.tagsinput.min.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/forms/jquery.maskedinput.min.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/forms/jquery.autotab.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/forms/jquery.chosen.min.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/forms/jquery.dualListBox.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/forms/jquery.cleditor.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/forms/jquery.ibutton.js"></script>
		
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/forms/jquery.validationEngine-<?php echo $_SESSION['lang_code']?>.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/forms/jquery.validationEngine.js"></script>
		
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/uploader/plupload.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/uploader/plupload.html4.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/uploader/plupload.html5.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/uploader/jquery.plupload.queue.js"></script>
		
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/wizards/jquery.form.wizard.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/wizards/jquery.validate.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/wizards/jquery.form.js"></script>
		
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/ui/jquery.collapsible.min.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/ui/jquery.breadcrumbs.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/ui/jquery.tipsy.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/ui/jquery.progress.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/ui/jquery.timeentry.min.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/ui/jquery.colorpicker.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/ui/jquery.jgrowl.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/ui/jquery.fancybox.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/ui/jquery.fileTree.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/ui/jquery.sourcerer.js"></script>
		
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/others/jquery.fullcalendar.js"></script>
		
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/ui/jquery.easytabs.min.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/files/bootstrap.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/files/functions.js"></script>
		
		<!--
			<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/charts/chart.js"></script>
			<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/charts/hBar_side.js"></script>
		-->
		<script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>
		<script type="text/javascript" src="http://code.highcharts.com/modules/exporting.js"></script>
		
		<!--
			As a wysiwyg editor we will use a custom entegration of ckefitor & ckfindder 
			For more info: http://ckeditor.com/ 
		-->
		<script type="text/javascript" src="<?php echo Routes::$base; ?>ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>ckfinder/ckfinder.js"></script>
		
		<!-- Image crop -->
		<script type="text/javascript" src="<?php echo Routes::$base; ?>core/js/jquery-jcrop.js"></script>
		<link type="text/css" href="<?php echo Routes::$base; ?>core/css/jcrop.css" rel="stylesheet"/>
		
		<!-- For sortable list -->
		<script type="text/javascript" src="<?php echo Routes::$base; ?>core/js/jquery-nested-sortable.js"></script>

		<?php 
		echo '<script>'.$setting['js_in_header'].'</script>'; 
		echo '<style>'.$setting['css_in_header'].'</style>'; 
		?>
	</head>
	<body>
		<?php
		/* Modal box with ajax load
		 * 
		 * Usage:
		 * <a rel="http://localhost/lenka/ajax-cms/user-details" title="Details of user" class="buttonM bDefault ml10 open-modal" id="'.$sonuc['user_id'].'">Detaylar</a></a>
		 */
		echo '<div class="modal">
      			<div class="load none"></div>
            	<div id="modal-content"></div>
        	  </div>';
		?>
		<!-- Sidebar begins -->
		<div id="sidebar">
		    <div class="mainNav">
				<div class="user">
					<img src="<?php echo $_SESSION['user_img']; ?>" alt="" width="80" height="80" /><span><!--<strong>3</strong>--></span>
					<span><?php echo $_SESSION['user_name']; ?></span>
				</div>
				<!-- Main nav -->
		        <ul class="nav">
		            <li><a href="<?php echo Routes::$base; ?>admin"> <!-- class="active" --> <img src="<?php echo Routes::$base; ?>cms/design/images/icons/mainnav/dashboard.png" alt="" /><span><?php echo __('Administrator'); ?></span></a></li>
		            <li><a href="<?php echo Routes::$base; ?>admin/configs"><img src="<?php echo Routes::$base; ?>cms/design/images/icons/mainnav/settings.png" alt="" /><span><?php echo __('Settings'); ?></span></a>
		            	<ul>
		                    <li><a href="<?php echo Routes::$base; ?>admin/configs"><span class="icol-cog2"></span><?php echo __('Settings'); ?></a></li>
		                    <li><a href="<?php echo Routes::$base; ?>admin/dynamic-variables"><span class="icon-quote"></span><?php echo __('Dynamic variables') ?></a></li>
		                    <?php if (is_auth(111)){ ?>
		                    <li><a href="<?php echo Routes::$base; ?>admin/datatables"><span class="icon-database"></span><?php echo __('Datatables'); ?></a></li>
		                    <li><a href="<?php echo Routes::$base; ?>admin/dynamic-tables"><span class="icon-equalizer"></span><?php echo __('Dynamic table rules'); ?></a></li>
		                    <li><a href="<?php echo Routes::$base; ?>admin/modules"><span class="icon-code"></span><?php echo __('Modules'); ?></a></li>
		                    <li><a href="<?php echo Routes::$base; ?>admin/routers"><span class="icon-arrow"></span><?php echo __('Routers'); ?></a></li>
		                	<?php } ?>
		                </ul>
		            </li>
		            <li><a href="#"><img src="<?php echo Routes::$base; ?>cms/design/images/icons/mainnav/category.png" alt="" /><span><?php echo __('Categories'); ?></span></a>
		                <ul>
		                    <li><a href="<?php echo Routes::$base; ?>admin/categories"><span class="icon-folder-3"></span><?php echo __('Categories'); ?></a></li>
		                    <li><a href="<?php echo Routes::$base; ?>admin/categories-order"><span class="icon-list"></span><?php echo __('Order'); ?></a></li>
		                    <li><a href="<?php echo Routes::$base; ?>admin/category-new"><span class="icol-add"></span><?php echo __('New'); ?></a></li>
		    			</ul>
		            </li>
		            <li><a href="#"><img src="<?php echo Routes::$base; ?>cms/design/images/icons/mainnav/forms.png" alt="" /><span><?php echo __('Contents'); ?></span></a>
		                <ul>
		                    <li><a href="<?php echo Routes::$base; ?>admin/contents"><span class="icon-document"></span><?php echo __('Contents'); ?></a></li>
		                    <li><a href="<?php echo Routes::$base; ?>admin/content-new"><span class="icol-add"></span><?php echo __('New'); ?></a></li>
		                	
		                	<?php if (is_auth(111)){ ?>
		                		<li><a href="<?php echo Routes::$base; ?>admin/patterns"><span class="icon-drawer"></span><?php echo __('Patterns'); ?></a></li>
		                    	<li><a href="<?php echo Routes::$base; ?>admin/pattern-new"><span class="icol-add"></span><?php echo __('New'); ?></a></li>
		                	<?php } ?>
		                </ul>
		            </li>
		            <?php if ($setting['ecommerce_mode'] == 'on') { ?>
		            <li id="menu_ecommerce"><a href="#"><img src="<?php echo Routes::$base; ?>cms/design/images/icons/mainnav/cart.png" alt="" /><span><?php echo __('E-commerce'); ?></span></a></li>
		            <li><a href="#"><img src="<?php echo Routes::$base; ?>cms/design/images/icons/mainnav/page.png" alt="" /><span><?php echo __('Pages'); ?></span></a>
		                <ul>
		                    <li><a href="<?php echo Routes::$base; ?>admin/contents/sayfalar"><span class="icon-document"></span><?php echo __('Pages'); ?></a></li>
		                    <li><a href="<?php echo Routes::$base; ?>admin/content-new/sayfalar/?action=content&categories=no&pattern=no&gallery=no"><span class="icol-add"></span><?php echo __('New'); ?></a></li>
		                </ul>
		            </li>
		            <?php } ?>
		            <?php if ($setting['gallery_mode'] == 'on') { ?>
		            <li><a href="<?php echo Routes::$base; ?>admin/galleries"><img src="<?php echo Routes::$base; ?>cms/design/images/icons/mainnav/gallery.png" alt="" /><span><?php echo __('Galleries'); ?></span></a>
		            	<ul>
		            		<li><a href="<?php echo Routes::$base; ?>admin/galleries"><span class="icon-landscape"></span><?php echo __('Galleries'); ?></a></li>
		                    <li><a href="<?php echo Routes::$base; ?>admin/gallery-new"><span class="icol-add"></span><?php echo __('New'); ?></a></li>
		                </ul>
		            </li>
		            <?php } ?>
		            <li><a href="<?php echo Routes::$base; ?>admin/menu-order"><img src="<?php echo Routes::$base; ?>cms/design/images/icons/mainnav/menu.png" alt="" /><span><?php echo __('Menus'); ?></span></a>
		                <ul>
		                	<li><a href="<?php echo Routes::$base; ?>admin/menu-order"><span class="icon-list"></span><?php echo __('Menus'); ?></a></li>
		                    <?php if (is_auth(111)){ ?>
		                    <li><a href="<?php echo Routes::$base; ?>admin/menu-new"><span class="icol-add"></span><?php echo __('New menu'); ?></a></li>
		                    <?php } ?>
		                    <li><a href="<?php echo Routes::$base; ?>admin/menu-data-new"><span class="icol-add"></span><?php echo __('New menu element'); ?></a></li>
		            	</ul>
		            </li>
		            <li><a href="<?php echo Routes::$base; ?>admin/popup"><img src="<?php echo Routes::$base; ?>cms/design/images/icons/mainnav/popup.png" alt="" /><span><?php echo __('Popup'); ?></span></a></li>	            
		            <li><a href="javascript:void(0);"><img src="<?php echo Routes::$base; ?>cms/design/images/icons/mainnav/slide.png" alt="" /><span><?php echo __('Slides'); ?></span></a>
		                <ul>
		                	<li><a href="<?php echo Routes::$base; ?>admin/slide-order/1"><span class="icon-eye"></span><?php echo __('Slides'); ?></a></li>
		                	<li><a href="<?php echo Routes::$base; ?>admin/slide-new/1"><span class="icol-add"></span><?php echo __('New'); ?></a></li>
		                </ul>
		            </li>
		            <?php if (@$setting['faq_module'] != 'off') { ?>
		            <li><a href="<?php echo Routes::$base; ?>admin/faq-order"><img src="<?php echo Routes::$base; ?>cms/design/images/icons/mainnav/question.png"/><span><?php echo __('Faqs'); ?></span></a>
		                <ul>
		                	<li><a href="<?php echo Routes::$base; ?>admin/faqs"><span class="icon-info"></span><?php echo __('Faqs'); ?></a></li>
		                	<li><a href="<?php echo Routes::$base; ?>admin/faq-order"><span class="icon-list"></span><?php echo __('Order'); ?></a></li>
		                	<li><a href="<?php echo Routes::$base; ?>admin/dynamic-new/faqs?title=FAQS&prefix=faq"><span class="icol-add"></span><?php echo __('New'); ?></a></li>
		                </ul>
		            </li>
		            <?php } ?>
		            <li><a href="<?php echo Routes::$base; ?>admin/users" ><img src="<?php echo Routes::$base; ?>cms/design/images/icons/mainnav/ui.png" alt="" /><span><?php echo __('Users'); ?></span></a>
		            	<ul>
		            		<li><a href="<?php echo Routes::$base; ?>admin/users" title=""><span class="icol-user"></span><?php echo __('Users'); ?></a></li>
		                    <li><a href="<?php echo Routes::$base; ?>admin/user/<?php echo $_SESSION['user_id']; ?>"><span class="icol-tag"></span><?php echo __('My profile'); ?></a></li>
		                    <li><a href="<?php echo Routes::$base; ?>admin/user-new" title=""><span class="icol-add"></span><?php echo __('New'); ?></a></li>
		                </ul>
		            </li>
		            
		            <!--
		            <li><a href="<?php echo Routes::$base; ?>admin/human-resources"><img src="<?php echo Routes::$base; ?>cms/design/images/icons/mainnav/users.png" alt="" /><span><?php echo __('Human resources'); ?></span></a></li>
					<li><a href="<?php echo Routes::$base; ?>admin/subscribers"><img src="<?php echo Routes::$base; ?>cms/design/images/icons/mainnav/mail.png" alt="" /><span><?php echo __('Subscribers'); ?></span></a></li>
					-->
					<?php if (@$setting['backup_database'] == 'on'){ ?>
		            <li><a href="<?php echo Routes::$base; ?>admin/backups"><img src="<?php echo Routes::$base; ?>cms/design/images/icons/mainnav/database.png"/><span><?php echo __('Database backup'); ?></span></a>
		            	<ul>
		                	<li><a href="<?php echo Routes::$base; ?>admin/backups"><span class="icon-database"></span><?php echo __('Old backups'); ?></a></li>
		                	<li><a href="<?php echo Routes::$base; ?>admin/backups/new"><span class="icol-add"></span><?php echo __('Backup'); ?></a></li>
		                </ul>	
		            </li>
		            <?php } ?>
		            <!--
		            <li><a href="<?php echo Routes::$base; ?>admin/help-general" title=""><img src="<?php echo Routes::$base; ?>cms/design/images/icons/mainnav/help.png" alt="" /><span><?php echo __('Help'); ?></span></a>
		        		<ul>
		                	<li><a href="<?php echo Routes::$base; ?>admin/help-general" title=""><span class="icon-question_mark"></span><?php echo __('General'); ?></a></li>
		                	<li><a href="<?php echo Routes::$base; ?>admin/help-ckfinder" title=""><span class="icon-question_mark"></span><?php echo __('Help about editor'); ?></a></li>
		                </ul>
		            </li>
		            -->
		            <?php 
					/** All dynamic menu items 
					 * 
					 */
					$dynamic_menu_items = select('dynamic_tables')->where('is_inmenu = 1 AND is_public = 1')->results();
					?>
					<?php if ($dynamic_menu_items){ ?>
						<?php foreach ($dynamic_menu_items AS $item) { ?>
			            <li><a href="<?php echo Routes::$base; ?>admin/dynamic-rows/<?php echo $item['dynamic_table_name']; ?>"><img src="<?php echo Routes::$base; ?>data/_images/<?php echo $item['dynamic_table_image']; ?>"/><span><?php echo __($item['dynamic_table_title']); ?></span></a>
			            	<ul>
			                	<li><a href="<?php echo Routes::$base; ?>admin/dynamic-rows/<?php echo $item['dynamic_table_name']; ?>"><span class="icon-document"></span><?php echo __($item['dynamic_table_title']); ?></a></li>
			                	<li><a href="<?php echo Routes::$base; ?>admin/dynamic-new/<?php echo $item['dynamic_table_name']; ?>"><span class="icol-add"></span><?php echo __('New'); ?></a></li>
			                </ul>	
			            </li>
			            <?php } ?>
		            <?php } ?>
		            <li><a href="<?php echo Routes::$base; ?>exit"><img src="<?php echo Routes::$base; ?>cms/design/images/icons/mainnav/other.png" alt="" /><span><?php echo __('Sign out'); ?></span></a></li>
		        </ul>
		    </div>
		    
		    
		    
		    
		    
		    
		    
		    
		    
		    
		    
		    
		    
		    
		    
		    <!-- Ecommnerce -->
		    <div id="menu_ecommerce_details" class="secNav none">
		        <div class="secWrapper">
		            <div class="secTop">
		                <div class="balance">
			                <div class="balInfo"><?php echo __('Waiting orders');?>: </div>
			                <a href="<?php echo Routes::$base; ?>admin/orders"><div class="balAmount"><span><?php echo count(select('products_orders')->where('order_status = 2 OR order_status = 3')->results()); ?></span></div></a>
		                </div>
		            </div>
		            
		            <!-- Tabs container -->
		            <div id="tab-container" class="tab-container">
		                <ul class="iconsLine ic3 etabs">
		                    <li><a href="#products" title=""><?php echo __('Products') ?></a></li>
		                    <li><a href="#orders" title=""><?php echo __('Orders') ?></a></li>
		                    <li><a href="#others" title=""><?php echo __('Others') ?></a></li>
		                </ul>
		                <div id="products">
		                    <ul class="subNav">
		                        <li><a href="<?php echo Routes::$base; ?>admin/categories/<?php echo $setting['product_category_id']; ?>"><span class="icon-folder-3"></span><?php echo __('Shop categories'); ?></a></li>
			                    <li><a href="<?php echo Routes::$base; ?>admin/categories-order/<?php echo $setting['product_category_id']; ?>"><span class="icon-list"></span><?php echo __('Order'); ?></a></li>
			                    <li><a href="<?php echo Routes::$base; ?>admin/category-new/<?php echo $setting['product_category_id']; ?>"><span class="icon-plus"></span><?php echo __('New shop category');; ?></a></li>
			                	<div class="divider"><span></span></div>
					            <li><a href="<?php echo Routes::$base; ?>admin/products"><span class="icon-document"></span><?php echo __('Products'); ?></a></li>
					            <li><a href="<?php echo Routes::$base; ?>admin/product-new"><span class="icon-plus"></span><?php echo __('New'); ?></a></li>
					            <li><a href="<?php echo Routes::$base; ?>admin/products-featured"><span class="icon-document"></span><?php echo __('Featured products'); ?></a></li>
						    	<?php if ($setting['product_has_features'] == 'on') { ?>
						    	<div class="divider"><span></span></div>
		                    	<li><a href="<?php echo Routes::$base; ?>admin/features"><span class="icon-document"></span><?php echo __('Features'); ?></a></li>
			                    <li><a href="<?php echo Routes::$base; ?>admin/feature-new"><span class="icon-plus"></span><?php echo __('New'); ?></a></li>
			                	<?php } ?>
			                	<div class="divider"><span></span></div>
			                	<li><a href="<?php echo Routes::$base; ?>admin/status"><span class="icon-document"></span><?php echo  __('Status of a product'); ?></a></li>
			                    <li><a href="<?php echo Routes::$base; ?>admin/status-new"><span class="icon-plus"></span><?php echo __('New'); ?></a></li>
			                </ul>
		                </div>
		                
		                <div id="orders">
		                	<ul class="subNav">
		                		<li><a href="<?php echo Routes::$base; ?>admin/orders"><span class="icon-list"></span><?php echo  __('Waiting orders'); ?></a></li>
					            <li><a href="<?php echo Routes::$base; ?>admin/orders/completed"><span class="icon-list"></span><?php echo __('Completed orders'); ?></a></li>
					        	<div class="divider"><span></span></div>
					            <li><a href="<?php echo Routes::$base; ?>admin/invoices"><span class="icon-list"></span><?php echo __('Invoices'); ?></a></li>
					        </ul>   
		                </div>
		                
		                <div id="others">
		                    <ul class="subNav">
		                    	<li><a href="<?php echo Routes::$base; ?>admin/manufacturers"><span class="icon-document"></span><?php echo __('Manufacturers'); ?></a></li>
				                <li><a href="<?php echo Routes::$base; ?>admin/manufacturer-new"><span class="icon-plus"></span><?php echo __('New'); ?></a></li>
			                	<div class="divider"><span></span></div>
		                    	<li><a href="<?php echo Routes::$base; ?>admin/shippings"><span class="icon-document"></span><?php echo __('Shipping options'); ?></a></li>
				                <li><a href="<?php echo Routes::$base; ?>admin/shipping-new"><span class="icon-plus"></span><?php echo __('New'); ?></a></li>
			                	<div class="divider"><span></span></div>
		                    	<li><a href="<?php echo Routes::$base; ?>admin/payments"><span class="icon-document"></span><?php echo __('Payment modules'); ?></a></li>
				                <!--
				                <li><a href="<?php echo Routes::$base; ?>admin/payment-new"><span class="icon-plus"></span><?php echo $lang['menu']['payment_new']; ?></a></li>
			                	-->
			                	<div class="divider"><span></span></div>
					            <li><a href="<?php echo Routes::$base; ?>admin/coupons"><span class="icon-tag"></span><?php echo __('Coupons'); ?></a></li>
					            <li><a href="<?php echo Routes::$base; ?>admin/dynamic-new/coupons"><span class="icon-plus"></span><?php echo __('New'); ?></a></li>
					        	<div class="divider"><span></span></div>
		                    	<li><a href="<?php echo Routes::$base; ?>admin/currencies"><span class="icon-document"></span><?php echo __('Currencies'); ?></a></li>
			                    <li><a href="<?php echo Routes::$base; ?>admin/currency-new"><span class="icon-plus"></span><?php echo __('New'); ?></a></li>
			                	<div class="divider"><span></span></div>
		                    	<li><a href="<?php echo Routes::$base; ?>admin/taxes"><span class="icon-document"></span><?php echo __('Taxes'); ?></a></li>
			                    <li><a href="<?php echo Routes::$base; ?>admin/tax-new"><span class="icon-plus"></span><?php echo __('New'); ?></a></li>
			                </ul>
		                </div>
		            </div>
		       </div> 
		       <div class="clear"></div>
		   </div>		    
		</div>	