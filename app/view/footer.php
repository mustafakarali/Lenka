<?php 
	$b = new Blog();
	$b->limit = 6;
	$b->is_public = '>0';
	
	$b->category = 1;
	$b->condition = 'ORDER BY contents.content_order ASC, contents.content_time DESC';
	$contents_pages = $b->contents();
	
	$b->category  = 2;
	$b->condition = 'ORDER BY contents.content_order ASC, contents.content_time DESC';
	$contents_blog = $b->contents();
?>
<!--markup footer-->
			<footer id="footer" class="type_2">
				<div class="footer_top_part">
					<!--
					<div class="container t_align_c m_bottom_20">
						<!--social icons
						<ul class="clearfix d_inline_b horizontal_list social_icons">
							<li class="facebook m_bottom_5 relative">
								<span class="tooltip tr_all_hover r_corners color_dark f_size_small">Facebook</span>
								<a href="#" class="r_corners t_align_c tr_delay_hover f_size_ex_large">
									<i class="fa fa-facebook"></i>
								</a>
							</li>
							<li class="twitter m_left_5 m_bottom_5 relative">
								<span class="tooltip tr_all_hover r_corners color_dark f_size_small">Twitter</span>
								<a href="#" class="r_corners f_size_ex_large t_align_c tr_delay_hover">
									<i class="fa fa-twitter"></i>
								</a>
							</li>
							<li class="google_plus m_left_5 m_bottom_5 relative">
								<span class="tooltip tr_all_hover r_corners color_dark f_size_small">Google Plus</span>
								<a href="#" class="r_corners f_size_ex_large t_align_c tr_delay_hover">
									<i class="fa fa-google-plus"></i>
								</a>
							</li>
							<li class="rss m_left_5 m_bottom_5 relative">
								<span class="tooltip tr_all_hover r_corners color_dark f_size_small">Rss</span>
								<a href="#" class="r_corners f_size_ex_large t_align_c tr_delay_hover">
									<i class="fa fa-rss"></i>
								</a>
							</li>
							<li class="pinterest m_left_5 m_bottom_5 relative">
								<span class="tooltip tr_all_hover r_corners color_dark f_size_small">Pinterest</span>
								<a href="#" class="r_corners f_size_ex_large t_align_c tr_delay_hover">
									<i class="fa fa-pinterest"></i>
								</a>
							</li>
							<li class="instagram m_left_5 m_bottom_5 relative">
								<span class="tooltip tr_all_hover r_corners color_dark f_size_small">Instagram</span>
								<a href="#" class="r_corners f_size_ex_large t_align_c tr_delay_hover">
									<i class="fa fa-instagram"></i>
								</a>
							</li>
							<li class="linkedin m_left_5 m_bottom_5 m_sm_left_5 relative">
								<span class="tooltip tr_all_hover r_corners color_dark f_size_small">LinkedIn</span>
								<a href="#" class="r_corners f_size_ex_large t_align_c tr_delay_hover">
									<i class="fa fa-linkedin"></i>
								</a>
							</li>
							<li class="vimeo m_left_5 m_bottom_5 relative">
								<span class="tooltip tr_all_hover r_corners color_dark f_size_small">Vimeo</span>
								<a href="#" class="r_corners f_size_ex_large t_align_c tr_delay_hover">
									<i class="fa fa-vimeo-square"></i>
								</a>
							</li>
							<li class="youtube m_left_5 m_bottom_5 relative">
								<span class="tooltip tr_all_hover r_corners color_dark f_size_small">Youtube</span>
								<a href="#" class="r_corners f_size_ex_large t_align_c tr_delay_hover">
									<i class="fa fa-youtube-play"></i>
								</a>
							</li>
							<li class="flickr m_left_5 m_bottom_5 relative">
								<span class="tooltip tr_all_hover r_corners color_dark f_size_small">Flickr</span>
								<a href="#" class="r_corners f_size_ex_large t_align_c tr_delay_hover">
									<i class="fa fa-flickr"></i>
								</a>
							</li>
							<li class="envelope m_left_5 m_bottom_5 relative">
								<span class="tooltip tr_all_hover r_corners color_dark f_size_small">Contact Us</span>
								<a href="#" class="r_corners f_size_ex_large t_align_c tr_delay_hover">
									<i class="fa fa-envelope-o"></i>
								</a>
							</li>
						</ul>
					</div>
					<hr class="divider_type_4 m_bottom_50">
					-->
					<div class="container">
						<div class="row clearfix">
							<div class="col-lg-3 col-md-3 col-sm-3 m_xs_bottom_30">
								<h3 class="color_light_2 m_bottom_20">Hakkımızda</h3>
								<p class="m_bottom_15"><?php echo __('hakkimizda')?></p>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-2 m_xs_bottom_30">
								<h3 class="color_light_2 m_bottom_20">Müşteri Hizmetleri</h3>
								<ul class="vertical_list">
									<?php foreach ($contents_pages AS $p) { ?>
									<li><a class="color_light tr_delay_hover" href="<?php echo Routes::$base.'page/'.$p['content_id'].'/'.$p['content_title'];?>"><?php echo $p['content_title']; ?><i class="fa fa-angle-right"></i></a></li>
									<?php } ?>
								</ul>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-2 m_xs_bottom_30">
								<h3 class="color_light_2 m_bottom_20">Blog</h3>
								<ul class="vertical_list">
									<?php foreach ($contents_blog AS $p) { ?>
									<li><a class="color_light tr_delay_hover" href="<?php echo Routes::$base.'page/'.$p['content_id'].'/'.$p['content_title'];?>"><?php echo $p['content_title']; ?><i class="fa fa-angle-right"></i></a></li>
									<?php } ?>
								</ul>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-2 m_xs_bottom_30">
								<h3 class="color_light_2 m_bottom_20">İlginizi çekecekler</h3>
								<ul class="vertical_list">
									<li><a class="color_light tr_delay_hover" href="<?php echo Routes::$base.'products/featured';?>">Fırsat ve Kampanyalar<i class="fa fa-angle-right"></i></a></li>
									<li><a class="color_light tr_delay_hover" href="<?php echo Routes::$base.'products/best';?>">En Çok Satanlar<i class="fa fa-angle-right"></i></a></li>
									<li><a class="color_light tr_delay_hover" href="<?php echo Routes::$base.'products/featured';?>">Öne Çıkanlar<i class="fa fa-angle-right"></i></a></li>
									<li><a class="color_light tr_delay_hover" href="<?php echo Routes::$base.'manufacturers';?>">Markalar<i class="fa fa-angle-right"></i></a></li>
								</ul>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-3">
								<h3 class="color_light_2 m_bottom_20">Bize Ulaşın</h3>
								<ul class="c_info_list">
									<li class="m_bottom_10">
										<div class="clearfix m_bottom_15">
											<i class="fa fa-map-marker f_left"></i>
											<p class="contact_e"><?php echo $setting['contact_address']; ?></p>
										</div>
									</li>
									<li class="m_bottom_10">
										<div class="clearfix m_bottom_10">
											<i class="fa fa-phone f_left"></i>
											<a class="contact_e color_light" href="tel:<?php echo $setting['contact_tel1']; ?>"><?php echo $setting['contact_tel1']; ?></a>
										</div>
									</li>
									<li class="m_bottom_10">
										<div class="clearfix m_bottom_10">
											<i class="fa fa-envelope f_left"></i>
											<a class="contact_e color_light" href="mailto:#"><?php echo $setting['contact_email']; ?></a>
										</div>
									</li>
									<li>
										<div class="clearfix">
											<i class="fa fa-clock-o f_left"></i>
											<p class="contact_e">P.tesi - Cuma: 08.00-20.00 <br>C.tesi: 09.00-15.00<br> Pazar: İzmirliyiz :)</p>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!--copyright part-->
				<div class="footer_bottom_part">
					<div class="container clearfix t_mxs_align_c">
						<p class="f_left f_mxs_none m_mxs_bottom_10">&copy; 2014 <span class="color_light"><a href="<?php echo Routes::$base; ?>">ParfümAL.com</a></span> Tüm hakları saklıdır.</p>
						<ul class="f_right horizontal_list clearfix f_mxs_none d_mxs_inline_b">
							<li class="m_left_5"><img src="app/design/images/payment_img_2.png" alt="visa"></li>
							<li class="m_left_5"><img src="app/design/images/payment_img_3.png" alt="mastercard"></li>
							<li class="m_left_5"><img src="app/design/images/payment_img_1.png" alt="paypal"></li>
						</ul>
					</div>
				</div>
			</footer>
		</div>
		<!--social widgets
		<ul class="social_widgets d_xs_none">
			<!--facebook
			<li class="relative">
				<button class="sw_button t_align_c facebook"><i class="fa fa-facebook"></i></button>
				<div class="sw_content">
					<h3 class="color_dark">Sayfamızı beğenin</h3>
					<p class="m_bottom_20">Fırsatlardan haberdar olun</p>
					<div class="fb-like-box" data-href="https://www.facebook.com/pages/Parf%C3%BCmalcom/1547574288854575?ref=hl" data-width="235" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
				</div>
			</li>
			<!--twitter feed
			<li class="relative">
				<button class="sw_button t_align_c twitter"><i class="fa fa-twitter"></i></button>
				<div class="sw_content">
					<h3 class="color_dark">Bizi takip edin</h3>
					<p class="m_bottom_20">Fırsatları ilk siz duyun</p>
					<div class="twitterfeed m_bottom_25"></div>
					<a role="button" class="button_type_4 d_inline_b r_corners tr_all_hover color_light tw_color" href="https://twitter.com/fanfbmltemplate">Follow on Twitter</a>
				</div>	
			</li>
			-->
			<!--contact form
			<li class="relative">
				<button class="sw_button t_align_c contact"><i class="fa fa-envelope-o"></i></button>
				<div class="sw_content">
					<h3 class="color_dark m_bottom_20">Bize Ulaşın</h3>
					<p class="f_size_medium m_bottom_15">Aşağıdaki formu doldurarak bize ulaşabilirsiniz</p>
					<form id="contactform" class="mini">
						<input class="f_size_medium m_bottom_10 r_corners full_width" type="text" name="cf_name" placeholder="İsminiz">
						<input class="f_size_medium m_bottom_10 r_corners full_width" type="email" name="cf_email" placeholder="Email adresiniz">
						<textarea class="f_size_medium r_corners full_width m_bottom_20" placeholder="Mesajınız" name="cf_message"></textarea>
						<button type="submit" class="button_type_4 r_corners mw_0 tr_all_hover color_dark bg_light_color_2">Gönder</button>
					</form>
				</div>	
			</li>
			-->
			<!--contact info
			<li class="relative">
				<button class="sw_button t_align_c googlemap"><i class="fa fa-map-marker"></i></button>
				<div class="sw_content">
					<h3 class="color_dark m_bottom_20">Mağazamız</h3>
					<ul class="c_info_list">
						<li class="m_bottom_10">
							<img src="<?php echo Routes::$base; ?>app/design/images/map-small.jpg">
						</li>
						<li class="m_bottom_10">
							<div class="clearfix m_bottom_10">
								<i class="fa fa-phone f_left color_dark"></i>
								<p class="contact_e"><a href="tel:<?php echo $setting['contact_tel1']; ?>"><?php echo $setting['contact_tel1']; ?></a></p>
							</div>
						</li>
						<li class="m_bottom_10">
							<div class="clearfix m_bottom_10">
								<i class="fa fa-envelope f_left color_dark"></i>
								<a class="contact_e default_t_color" href="mailto:<?php echo $setting['contact_email']; ?>"><?php echo $setting['contact_email']; ?></a>
							</div>
						</li>
					</ul>
				</div>	
			</li>
		</ul>
		<!--custom popup
		<div class="popup_wrap d_none" id="quick_view_product">
			<section class="popup r_corners shadow">
				<button class="bg_tr color_dark tr_all_hover text_cs_hover close f_size_large"><i class="fa fa-times"></i></button>
				<div class="clearfix">
					<div class="custom_scrollbar">
						<!--left popup column
						<div class="f_left half_column">
							<div class="relative d_inline_b m_bottom_10 qv_preview">
								<span class="hot_stripe"><img src="images/sale_product.png" alt=""></span>
								<img src="images/quick_view_img_1.jpg" class="tr_all_hover" alt="">
							</div>
							<!--carousel
							<div class="relative qv_carousel_wrap m_bottom_20">
								<button class="button_type_11 t_align_c f_size_ex_large bg_cs_hover r_corners d_inline_middle bg_tr tr_all_hover qv_btn_prev">
									<i class="fa fa-angle-left "></i>
								</button>
								<ul class="qv_carousel d_inline_middle">
									<li data-src="images/quick_view_img_1.jpg"><img src="images/quick_view_img_4.jpg" alt=""></li>
									<li data-src="images/quick_view_img_2.jpg"><img src="images/quick_view_img_5.jpg" alt=""></li>
									<li data-src="images/quick_view_img_3.jpg"><img src="images/quick_view_img_6.jpg" alt=""></li>
									<li data-src="images/quick_view_img_1.jpg"><img src="images/quick_view_img_4.jpg" alt=""></li>
									<li data-src="images/quick_view_img_2.jpg"><img src="images/quick_view_img_5.jpg" alt=""></li>
									<li data-src="images/quick_view_img_3.jpg"><img src="images/quick_view_img_6.jpg" alt=""></li>
								</ul>
								<button class="button_type_11 t_align_c f_size_ex_large bg_cs_hover r_corners d_inline_middle bg_tr tr_all_hover qv_btn_next">
									<i class="fa fa-angle-right "></i>
								</button>
							</div>
							<div class="d_inline_middle">Share this:</div>
							<div class="d_inline_middle m_left_5">
								<!-- AddThis Button BEGIN 
								<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
								<a class="addthis_button_preferred_1"></a>
								<a class="addthis_button_preferred_2"></a>
								<a class="addthis_button_preferred_3"></a>
								<a class="addthis_button_preferred_4"></a>
								<a class="addthis_button_compact"></a>
								<a class="addthis_counter addthis_bubble_style"></a>
								</div>
								<!-- AddThis Button END 
							</div>
						</div>
						<!--right popup column
						<div class="f_right half_column">
							<h2 class="m_bottom_10"><a href="#" class="color_dark fw_medium">Eget elementum vel</a></h2>
							<div class="m_bottom_10">
								<ul class="horizontal_list d_inline_middle type_2 clearfix rating_list tr_all_hover">
									<li class="active">
										<i class="fa fa-star-o empty tr_all_hover"></i>
										<i class="fa fa-star active tr_all_hover"></i>
									</li>
									<li class="active">
										<i class="fa fa-star-o empty tr_all_hover"></i>
										<i class="fa fa-star active tr_all_hover"></i>
									</li>
									<li class="active">
										<i class="fa fa-star-o empty tr_all_hover"></i>
										<i class="fa fa-star active tr_all_hover"></i>
									</li>
									<li class="active">
										<i class="fa fa-star-o empty tr_all_hover"></i>
										<i class="fa fa-star active tr_all_hover"></i>
									</li>
									<li>
										<i class="fa fa-star-o empty tr_all_hover"></i>
										<i class="fa fa-star active tr_all_hover"></i>
									</li>
								</ul>
								<a href="#" class="d_inline_middle default_t_color f_size_small m_left_5">1 Review(s) </a>
							</div>
							<hr class="m_bottom_10 divider_type_3">
							<table class="description_table m_bottom_10">
								<tr>
									<td>Manufacturer:</td>
									<td><a href="#" class="color_dark">Chanel</a></td>
								</tr>
								<tr>
									<td>Availability:</td>
									<td><span class="color_green">in stock</span> 20 item(s)</td>
								</tr>
								<tr>
									<td>Product Code:</td>
									<td>PS06</td>
								</tr>
							</table>
							<h5 class="fw_medium m_bottom_10">Product Dimensions and Weight</h5>
							<table class="description_table m_bottom_5">
								<tr>
									<td>Product Length:</td>
									<td><span class="color_dark">10.0000M</span></td>
								</tr>
								<tr>
									<td>Product Weight:</td>
									<td>10.0000KG</td>
								</tr>
							</table>
							<hr class="divider_type_3 m_bottom_10">
							<p class="m_bottom_10">Ut tellus dolor, dapibus eget, elementum vel, cursus eleifend, elit. Aenean auctor wisi et urna. Aliquam erat volutpat. Duis ac turpis. Donec sit amet eros. Lorem ipsum dolor sit amet, consecvtetuer adipiscing elit. </p>
							<hr class="divider_type_3 m_bottom_15">
							<div class="m_bottom_15">
								<s class="v_align_b f_size_ex_large">$152.00</s><span class="v_align_b f_size_big m_left_5 scheme_color fw_medium">$102.00</span>
							</div>
							<table class="description_table type_2 m_bottom_15">
								<tr>
									<td class="v_align_m">Size:</td>
									<td class="v_align_m">
										<div class="custom_select f_size_medium relative d_inline_middle">
											<div class="select_title r_corners relative color_dark">s</div>
											<ul class="select_list d_none"></ul>
											<select name="product_name">
												<option value="s">s</option>
												<option value="m">m</option>
												<option value="l">l</option>
											</select>
										</div>
									</td>
								</tr>
								<tr>
									<td class="v_align_m">Quantity:</td>
									<td class="v_align_m">
										<div class="clearfix quantity r_corners d_inline_middle f_size_medium color_dark">
											<button class="bg_tr d_block f_left" data-direction="down">-</button>
											<input type="text" name="" readonly value="1" class="f_left">
											<button class="bg_tr d_block f_left" data-direction="up">+</button>
										</div>
									</td>
								</tr>
							</table>
							<div class="clearfix m_bottom_15">
								<button class="button_type_12 r_corners bg_scheme_color color_light tr_delay_hover f_left f_size_large">Sepete Ekle</button>
								<button class="button_type_12 bg_light_color_2 tr_delay_hover f_left r_corners color_dark m_left_5 p_hr_0"><i class="fa fa-heart-o f_size_big"></i><span class="tooltip tr_all_hover r_corners color_dark f_size_small">Wishlist</span></button>
								<button class="button_type_12 bg_light_color_2 tr_delay_hover f_left r_corners color_dark m_left_5 p_hr_0"><i class="fa fa-files-o f_size_big"></i><span class="tooltip tr_all_hover r_corners color_dark f_size_small">Compare</span></button>
								<button class="button_type_12 bg_light_color_2 tr_delay_hover f_left r_corners color_dark m_left_5 p_hr_0 relative"><i class="fa fa-question-circle f_size_big"></i><span class="tooltip tr_all_hover r_corners color_dark f_size_small">Ask a Question</span></button>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		-->
		<!--login popup
		<div class="popup_wrap d_none" id="login_popup">
			<section class="popup r_corners shadow">
				<button class="bg_tr color_dark tr_all_hover text_cs_hover close f_size_large"><i class="fa fa-times"></i></button>
				<h3 class="m_bottom_20 color_dark">Log In</h3>
				<form>
					<ul>
						<li class="m_bottom_15">
							<label for="username" class="m_bottom_5 d_inline_b">Username</label><br>
							<input type="text" name="" id="username" class="r_corners full_width">
						</li>
						<li class="m_bottom_25">
							<label for="password" class="m_bottom_5 d_inline_b">Password</label><br>
							<input type="password" name="" id="password" class="r_corners full_width">
						</li>
						<li class="m_bottom_15">
							<input type="checkbox" class="d_none" id="checkbox_10"><label for="checkbox_10">Remember me</label>
						</li>
						<li class="clearfix m_bottom_30">
							<button class="button_type_4 tr_all_hover r_corners f_left bg_scheme_color color_light f_mxs_none m_mxs_bottom_15">Log In</button>
							<div class="f_right f_size_medium f_mxs_none">
								<a href="#" class="color_dark">Forgot your password?</a><br>
								<a href="#" class="color_dark">Forgot your username?</a>
							</div>
						</li>
					</ul>
				</form>
				<footer class="bg_light_color_1 t_mxs_align_c">
					<h3 class="color_dark d_inline_middle d_mxs_block m_mxs_bottom_15">New Customer?</h3>
					<a href="#" role="button" class="tr_all_hover r_corners button_type_4 bg_dark_color bg_cs_hover color_light d_inline_middle m_mxs_left_0">Create an Account</a>
				</footer>
			</section>
		</div>
		-->
		<button class="t_align_c r_corners type_2 tr_all_hover animate_ftl" id="go_to_top"><i class="fa fa-angle-up"></i></button>
		<!-- scripts include-->
		<script type="text/javascript" src="<?php echo Routes::$base; ?>core/js/jquery.cookie.js"></script> 
		
		<!-- Validation engine -->
	    <script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/forms/jquery.validationEngine-tr.js"></script>
		<script type="text/javascript" src="<?php echo Routes::$base; ?>cms/design/js/plugins/forms/jquery.validationEngine.js"></script>
		
		
		<script src="<?php echo Routes::$base; ?>app/design/js/jquery-migrate-1.2.1.min.js"></script>
		<script src="<?php echo Routes::$base; ?>app/design/js/elevatezoom.min.js"></script>
		<script src="<?php echo Routes::$base; ?>app/design/js/jquery.fancybox-1.3.4.js"></script>
		<!--
		<script src="<?php echo Routes::$base; ?>app/design/js/retina.js"></script>
		-->
		<script src="<?php echo Routes::$base; ?>app/design/js/jquery.flexslider-min.js"></script>
		<script src="<?php echo Routes::$base; ?>app/design/js/waypoints.min.js"></script>
		<script src="<?php echo Routes::$base; ?>app/design/js/jquery.isotope.min.js"></script>
		<script src="<?php echo Routes::$base; ?>app/design/js/owl.carousel.min.js"></script>
		<!--
		<script src="<?php echo Routes::$base; ?>app/design/js/jquery.tweet.min.js"></script>
		-->
		<script src="<?php echo Routes::$base; ?>app/design/js/jquery.custom-scrollbar.js"></script>
		<script src="<?php echo Routes::$base; ?>app/design/js/scripts.js"></script>
		<script type="text/javascript" src="https://s7.addthis.com/js/300/addthis_widget.js#pubid=xa-5306f8f674bfda4c"></script>
		
		<script src="<?php echo Routes::$base; ?>app/js/jquery.maskedinput.min.js"></script>
		<!-- custom scripts -->
		<script src="<?php echo Routes::$base; ?>app/js/custom.js"></script>
	</body>
</html>