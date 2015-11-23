<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		<title><?php echo Seo::title(); ?></title>
		<meta name="description" content="<?php echo Seo::description(); ?>">
		<meta name="keywords" content="<?php echo Seo::keywords(); ?>">
		
		<!-- Konumsal etiketler -->
		<meta property="place:location:latitude" content="<?php echo $setting['lat']; ?>"/>
		<meta property="place:location:longitude" content="<?php echo $setting['lng']; ?>"/>
		<meta property="business:contact_data:street_address" content="<?php echo $setting['contact_address']; ?>"/>
		<meta property="business:contact_data:locality" content=""/>
		<meta property="business:contact_data:postal_code" content=""/>
		<meta property="business:contact_data:country_name" content="<?php echo $setting['local_country']; ?>"/>
		<meta property="business:contact_data:email" content="<?php echo $setting['contact_email']; ?>"/>
		<meta property="business:contact_data:phone_number" content="<?php echo $setting['contact_tel1']; ?>"/>
		<meta property="business:contact_data:website" content="<?php echo Routes::$base; ?>"/>
		
		<!-- FB -->
		<meta property="og:url" content="<?php echo Routes::$current; ?>"/>
		<meta property="og:site_name" content="<?php Seo::$name; ?>"/>
		<meta property="og:title" content="<?php echo Seo::title(); ?>"/>
		<meta property="og:description" content="<?php echo Seo::description(); ?>"/>
		<meta property="og:image" content="<?php echo $setting['og_image']; ?>"/> 
		<!--
		<meta property="og:see_also" content="http://www.website.com"/>
		<meta property="fb:admins" content="Facebook_ID"/>
		<meta property="fb:app_id" content="App_ID"/>
		-->
		
		<!-- G+ --> 
		<meta itemprop="name" content="<?php echo Seo::$name; ?>"/>
		<meta itemprop="description" content="<?php echo Seo::description(); ?>"/>
		<meta itemprop="image" content="<?php echo $setting['og_image']; ?>"/>
		
		<!-- Twitter -->
		<!--
		<meta name="twitter:card" content="summary"/>
		 -->
		<meta name="twitter:site" content="<?php echo Seo::$name; ?>"/>
		<meta name="twitter:title" content="<?php echo Seo::title(); ?>">
		<meta name="twitter:description" content="<?php Seo::description(); ?>"/>
		<meta name="twitter:creator" content="<?php echo $setting['site_name']; ?>"/>
		<meta name="twitter:image:src" content="<?php echo $setting['og_image']; ?>"/>
		<meta name="twitter:domain" content="<?php echo Routes::$current; ?>"/>
		
		<!-- Favicon --> 
		<link rel="shortcut icon" href="<?php echo Routes::$image.$setting['favicon']; ?>" />
		<link rel="shortcut icon" href="<?php echo Routes::$image.$setting['favicon']; ?>" />
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo Routes::$image.$setting['apple_icon_72']; ?>" />
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo Routes::$image.$setting['apple_icon_114']; ?>" />
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo Routes::$image.$setting['apple_icon_144']; ?>" />
		<meta name="author" content="<?php Seo::author(); ?>"/>
		
		<!--stylesheet include-->
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo Routes::$base; ?>app/design/css/flexslider.css">
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo Routes::$base; ?>app/design/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo Routes::$base; ?>app/design/css/owl.carousel.css">
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo Routes::$base; ?>app/design/css/owl.transitions.css">
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo Routes::$base; ?>app/design/css/jquery.custom-scrollbar.css">
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo Routes::$base; ?>app/design/css/style.css">
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo Routes::$base; ?>app/css/custom.css">
		<!--font include-->
		<link href="<?php echo Routes::$base; ?>app/design/css/font-awesome.min.css" rel="stylesheet">
	    <!-- Validation engine -->
	    <link href="<?php echo Routes::$base; ?>app/design/css/validationEngine.jquery.css" rel="stylesheet" type="text/css"/>
		
		<!-- JScripts 
		<script type="text/javascript" src="<?php echo Routes::$base; ?>core/js/jquery.js"></script> 
		<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
	    
		<script type="text/javascript" src="<?php echo Routes::$base; ?>core/js/jquery-ui.js"></script> 
		-->
		<script src="<?php echo Routes::$base; ?>app/design/js/jquery-2.1.0.min.js"></script>
		<script src="<?php echo Routes::$base; ?>app/design/js/jquery-ui.min.js"></script>
		
		
		<?php
		// javascriptte kullanılacak dil degiskenlerini global js değişkenlerine dönüştürür. gnc.js'den önce çağırılmalıki fonksiyonlardan önce değişkenler tanımlanmış olsun
		echo '
		<script type="text/javascript">
		<!-- // --><![CDATA[
			var site_path = "'.$site['url'].'";
			var image_path = "'.$site['image_path'].'";
			var file_path = "'.$site['file_path'].'";
			
			var ajax_app = "'.$site['url'].'ajax-app/";
			var ajax_cms = "'.$site['url'].'ajax-cms/";
			var ajax = "'.$site['url'].'ajax/";
			
			var page_timestamp = '.$site['timestamp'].';
			
			var session_life = "'.$setting['session_life'].'";
			var session_dead = "'. __('Session has expired, please sign in again').'";
			
			var sSearch = "'. __('Search:') .'";
			var sLengthMenu = "'. __('Show _MENU_ entries')  .'";
			var sZeroRecords = "'. __('Sorry, we couldn\'t find any results')  .'";
			var sInfo = "'. __('_TOTAL_ kayıttan _START_ ile _END_ arasındakiler gösteriliyor.')  .'";
			var sInfoEmpty = "'. __('Showing 0 to 0 of 0 records')  .'";
			var sInfoFiltered = "'. __('(filtered from _MAX_ total records)')  .'";
			var sFirst = "'. __('First')  .'";
			var sLast = "'. __('Last')  .'";
			var sNext = "'. __('Next')  .'";
			var sPrevious = "'. __('Previous')  .'";
			var fileDefaultText = "'. __('Select a file') .'";
			
			var selectedFile = "'. __('Selected File')  .'";
			var file_Url = "'. __('File URL')  .'";
			var file_Size = "'. __('File Size')  .'";
			var file_Date = "'. __('Upload Date')  .'";
		// ]]>
		</script>';

		echo '
		<script>'.$setting['js_in_header'].'</script> 
		<style>'.$setting['css_in_header'].'</style>'; 
		?>	
	</head>
	<body>
		<script>
		  window.fbAsyncInit = function() {
		    FB.init({
		      appId      : '340272746147230',
		      xfbml      : true,
		      version    : 'v2.1'
		    });
		  };
		
		  (function(d, s, id){
		     var js, fjs = d.getElementsByTagName(s)[0];
		     if (d.getElementById(id)) {return;}
		     js = d.createElement(s); js.id = id;
		     js.src = "//connect.facebook.net/tr_TR/sdk.js";
		     fjs.parentNode.insertBefore(js, fjs);
		   }(document, 'script', 'facebook-jssdk'));
		</script>
		<!--boxed layout-->
		<div class="wide_layout relative w_xs_auto">
			<!--[if (lt IE 9) | IE 9]>
				<div style="background:#fff;padding:8px 0 10px;">
				<div class="container" style="width:1170px;"><div class="row wrapper"><div class="clearfix" style="padding:9px 0 0;float:left;width:83%;"><i class="fa fa-exclamation-triangle scheme_color f_left m_right_10" style="font-size:25px;color:#e74c3c;"></i><b style="color:#e74c3c;">Attention! This page may not display correctly.</b> <b>You are using an outdated version of Internet Explorer. For a faster, safer browsing experience.</b></div><div class="t_align_r" style="float:left;width:16%;"><a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode" class="button_type_4 r_corners bg_scheme_color color_light d_inline_b t_align_c" target="_blank" style="margin-bottom:2px;">Update Now!</a></div></div></div></div>
			<![endif]-->
			<!--markup header type 2-->
			<header role="banner">
				<!--header top part-->
				<section class="h_top_part">
					<div class="container">
						<div class="row clearfix">
							<div class="col-lg-6 col-md-6 col-sm-6 t_xs_align_c">
								<!--
								<p class="f_size_small"><a href="#" data-popup="#login_popup">Giriş yap</a> | <a href="#" data-popup="#login_popup">Kayıt ol</a> </p>
								-->
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 t_align_r t_xs_align_c">
								<!--
								<ul class="horizontal_list clearfix d_inline_b t_align_l f_size_small site_settings type_2">
									<li class="container3d relative">
										<a role="button" href="#" class="color_dark" id="lang_button"><img class="d_inline_middle m_right_10" src="images/flag_en.jpg" alt="">English</a>
										<ul class="dropdown_list type_2 top_arrow color_light">
											<li><a href="#" class="tr_delay_hover color_light"><img class="d_inline_middle" src="images/flag_en.jpg" alt="">English</a></li>
											<li><a href="#" class="tr_delay_hover color_light"><img class="d_inline_middle" src="images/flag_fr.jpg" alt="">French</a></li>
											<li><a href="#" class="tr_delay_hover color_light"><img class="d_inline_middle" src="images/flag_g.jpg" alt="">German</a></li>
											<li><a href="#" class="tr_delay_hover color_light"><img class="d_inline_middle" src="images/flag_i.jpg" alt="">Italian</a></li>
											<li><a href="#" class="tr_delay_hover color_light"><img class="d_inline_middle" src="images/flag_s.jpg" alt="">Spanish</a></li>
										</ul>
									</li>
									<li class="m_left_20 relative container3d">
										<a role="button" href="#" class="color_dark" id="currency_button"><span class="scheme_color">$</span> US Dollar</a>
										<ul class="dropdown_list type_2 top_arrow color_light">
											<li><a href="#" class="tr_delay_hover color_light"><span class="scheme_color">$</span> US Dollar</a></li>
											<li><a href="#" class="tr_delay_hover color_light"><span class="scheme_color">&#8364;</span> Euro</a></li>
											<li><a href="#" class="tr_delay_hover color_light"><span class="scheme_color">&#163;</span> Pound</a></li>
										</ul>
									</li>
								</ul>
								-->
							</div>
						</div>
					</div>
				</section>
				<!--header bottom part-->
				<section class="h_bot_part container">
					<div class="clearfix row">
						<div class="col-lg-6 col-md-6 col-sm-4 t_xs_align_c">
							<a href="<?php echo Routes::$base;?>" class="logo m_xs_bottom_15 d_xs_inline_b">
								<img src="<?php echo Routes::$base;?>app/design/images/logo.svg" alt="parfümal.com logo" width="250">
							</a>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-8">
							<div class="row clearfix">
								<div class="col-lg-6 col-md-6 col-sm-6 t_align_r t_xs_align_c m_xs_bottom_15 pull-right">
									<dl class="l_height_medium">
										<dt class="f_size_small">Bize ulaşın:</dt>
										<dd class="f_size_ex_large color_dark"><b><a href="tel:<?php echo $setting['contact_tel1']; ?>"><?php echo $setting['contact_tel1']; ?></a></b></dd>
									</dl>
								</div>
								<!--
								<div class="col-lg-6 col-md-6 col-sm-6">
									<form class="relative type_2" role="search">
										<input type="text" placeholder="Ara" name="search" class="r_corners f_size_medium full_width">
										<button class="f_right search_button tr_all_hover f_xs_none">
											<i class="fa fa-search"></i>
										</button>
									</form>
								</div>
								-->
							</div>
						</div>
					</div>
				</section>
			</header>