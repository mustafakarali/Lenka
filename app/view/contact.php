<!--breadcrumbs-->
<section class="breadcrumbs">
	<div class="container">
		<ul class="horizontal_list clearfix bc_list f_size_medium">
			<li class="m_right_10 current"><a href="<?php echo Routes::$base; ?>" class="default_t_color">Anasayfa<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
			<li><a href="<?php echo Routes::$base . Routes::$module; ?>" class="default_t_color">İletişim</a></li>
		</ul>
	</div>
</section>
<!--content-->
<div class="page_content_offset">
	<div class="container">
		<div class="row clearfix">
			<!--left content column-->
			<section class="col-lg-9 col-md-9 col-sm-9">
				<h2 class="tt_uppercase color_dark m_bottom_25">BİZE ULAŞIN</h2>
				<div class="r_corners photoframe map_container shadow m_bottom_45">
					<img src="<?php echo Routes::$base; ?>app/design/images/map-big.jpg">
				</div>
				<div class="row clearfix">
					<div class="col-lg-4 col-md-4 col-sm-4 m_xs_bottom_30">
						<h2 class="tt_uppercase color_dark m_bottom_25">İLETİŞİM BİLGİLERİ</h2>
						<ul class="c_info_list">
							<li class="m_bottom_10">
								<div class="clearfix m_bottom_15">
									<i class="fa fa-map-marker f_left color_dark"></i>
									<p class="contact_e"><?php echo $setting['contact_address']; ?></p>
								</div>
							</li>
							<li class="m_bottom_10">
								<div class="clearfix m_bottom_10">
									<i class="fa fa-phone f_left color_dark"></i>
									<a class="contact_e default_t_color" href="tel:<?php echo $setting['contact_address']; ?>"><?php echo $setting['contact_tel1']; ?></a>
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
					<div class="col-lg-8 col-md-8 col-sm-8 m_xs_bottom_30">
						<h2 class="tt_uppercase color_dark m_bottom_25">İLETİŞİM FORMU</h2>
						<?php //send_contact_form(); ?>
						<p class="m_bottom_10">Aşağıdaki formu doldurarak bize ulaşabilirsiniz, <span class="scheme_color">*</span> ile işaretli alanların doldurulması zorunludur.</p>
						<form id="contactform" action="<?php echo Routes::$path; ?>" method="post">
							<ul>
								<li class="clearfix m_bottom_15">
									<div class="f_left half_column">
										<label for="cf_name" class="required d_inline_b m_bottom_5">Adınız ve Soyadınız</label>
										<input type="text" id="cf_name" name="name" class="full_width r_corners">
									</div>
									<div class="f_left half_column">
										<label for="cf_email" class="required d_inline_b m_bottom_5">E-posta adresiniz</label>
										<input type="email" id="cf_email" name="email" class="full_width r_corners">
									</div>
								</li>
								<li class="m_bottom_15">
									<label for="cf_subject" class="d_inline_b m_bottom_5">Konu</label>
									<input type="text" id="cf_subject" name="subjeck" class="full_width r_corners">
								</li>
								<li class="m_bottom_15">
									<label for="cf_message" class="d_inline_b m_bottom_5 required">Mesaj</label>
									<textarea id="cf_message" name="message" class="full_width r_corners"></textarea>
								</li>
								<li>
									<input type="hidden" name="chk" value="">
									<button class="button_type_4 bg_light_color_2 r_corners mw_0 tr_all_hover color_dark" name="submit">Gönder</button>
								</li>
							</ul>
						</form>
					</div>
				</div>
			</section>
			<!--right column-->
			<aside class="col-lg-3 col-md-3 col-sm-3">
				<!--widgets-->
				<?php product_categories(); ?>
				<!--banner-->
				<a href="#" class="d_block r_corners m_bottom_30">
					<img src="images/banner_img_6.jpg" alt="">
				</a>
			</aside>
		</div>
	</div>
</div>