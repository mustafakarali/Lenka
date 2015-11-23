<!--breadcrumbs-->
<section class="breadcrumbs">
	<div class="container">
		<ul class="horizontal_list clearfix bc_list f_size_medium">
			<li class="m_right_10 current"><a href="<?php echo Routes::$base; ?>" class="default_t_color">Anasayfa<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
			<li><a href="<?php echo Routes::$base.Routes::$module;?>" class="default_t_color">Ödeme</a></li>
		</ul>
	</div>
</section>
<!--content-->
<div class="page_content_offset">
	<div class="container">
		<div class="row clearfix">
			<!--left content column-->
			<section class="col-lg-9 col-md-9 col-sm-9 m_xs_bottom_30">
			<h2 class="tt_uppercase color_dark m_bottom_25">SEPETİM</h2>
			<!--cart table-->

					<?php
                    if (isset($_SESSION['cart']) && $_SESSION['cart']['price_with_tax'] > 0) {
                        echo '	<div id="table_cart">';
                        echo echo_cart_table($_SESSION['cart']);
                        echo '	</div>';
                    } else {
                        ?>
						<h3>Sepetinizde hiç ürün bulunmuyor. </h3>
						<p class="m_bottom_45">Alışverişinizi yapmak için lütfen menüde bulunan kategorilerden istediğiniz bölüme gidin, ürünleri sepetinize ekleyin ve ödeme yaparak siparişinizi tamamlayın. </p>
						<h3>Alışverişe burdan başlamaya ne dersiniz?</h3>
						<p class="m_bottom_20">Sizin için seçtiğimiz fırsatlara gözatın, uygun fiyatlara istediğiniz ürünü kaçırmayın.</p>
						<?php
                        banners(8);
                        banners(9);
                    }
                    ?>
				<!--tabs
				<div class="tabs m_bottom_45">
					<nav>
						<ul class="tabs_nav horizontal_list clearfix">
							<li><a href="#tab-1" class="bg_light_color_1 color_dark tr_delay_hover r_corners d_block">Login</a></li>
							<li><a href="#tab-2" class="bg_light_color_1 color_dark tr_delay_hover r_corners d_block">Register</a></li>
						</ul>
					</nav>
					<section class="tabs_content shadow r_corners">
						<div id="tab-1">
							<h5 class="fw_medium m_bottom_15">I am Already Registered</h5>
							<form>
								<ul>
									<li class="clearfix m_bottom_15">
										<div class="half_column type_2 f_left">
											<label for="username" class="m_bottom_5 d_inline_b">Username</label>
											<input type="text" id="username" name="" class="r_corners full_width m_bottom_5">
											<a href="#" class="color_dark f_size_medium">Forgot your username?</a>
										</div>
										<div class="half_column type_2 f_left">
											<label for="pass" class="m_bottom_5 d_inline_b">Password</label>
											<input type="password" id="pass" name="" class="r_corners full_width m_bottom_5">
											<a href="#" class="color_dark f_size_medium">Forgot your password?</a>
										</div>
									</li>
									<li class="m_bottom_15">
										<input type="checkbox" class="d_none" name="checkbox_4" id="checkbox_4"><label for="checkbox_4">Remember me</label>
									</li>
									<li><button class="button_type_4 r_corners bg_scheme_color color_light tr_all_hover">Log In</button></li>
								</ul>
							</form>
						</div>
						<div id="tab-2">
							<form>
								<ul>
									<li class="m_bottom_25">
										<label for="d_name" class="d_inline_b m_bottom_5 required">Displayed Name</label>
										<input type="text" id="d_name" name="" class="r_corners full_width">
									</li>
									<li class="m_bottom_5">
										<input type="checkbox" class="d_none" name="checkbox_5" id="checkbox_5"><label for="checkbox_5">Create an account</label>
									</li>
									<li class="m_bottom_15">
										<label for="u_name" class="d_inline_b m_bottom_5 required">Username</label>
										<input type="text" id="u_name" name="" class="r_corners full_width">
									</li>
									<li class="m_bottom_15">
										<label for="u_email" class="d_inline_b m_bottom_5 required">Email</label>
										<input type="email" id="u_email" name="" class="r_corners full_width">
									</li>
									<li class="m_bottom_15">
										<label for="u_pass" class="d_inline_b m_bottom_5 required">Password</label>
										<input type="password" id="u_pass" name="" class="r_corners full_width">
									</li>
									<li>
										<label for="u_repeat_pass" class="d_inline_b m_bottom_5 required">Confirm Password</label>
										<input type="password" id="u_repeat_pass" name="" class="r_corners full_width">
									</li>
								</ul>
							</form>
						</div>
					</section>
				</div>
				-->
				<?php if (isset($_SESSION['cart']) && $_SESSION['cart']['price_with_tax'] > 0) { ?>
				<form id="invoice" class="keepFormData" method="post" action="<?php echo Routes::$base;?>checkorder">

					<h2 class="color_dark tt_uppercase m_bottom_25">FATURA VE TESLİMAT BİLGİLERİ</h2>
					<div class="bs_inner_offsets bg_light_color_3 shadow r_corners m_bottom_45">
						<div class="row clearfix">
							<div class="col-lg-6 col-md-6 col-sm-6 m_xs_bottom_30">
								<h5 class="fw_medium m_bottom_15">Fatura Bilgileri</h5>
									<ul>
										<li class="m_bottom_15">
											<label for="email_1" class="d_inline_b m_bottom_5 required">E-mail adresi <small>"Sipariş numaranızı göndereceğiz"</small></label>
											<input type="text" id="email_1" name="email_1" class="r_corners full_width validate[required,custom[email]]">
										</li>
										<li class="m_bottom_15">
											<label for="c_name_1" class="d_inline_b m_bottom_5">Şirket adı</label>
											<input type="text" id="c_name_1" name="company_1" class="r_corners full_width">
										</li>
										<!--
										<li class="m_bottom_15">
											<label class="d_inline_b m_bottom_5">Title</label>
											<div class="custom_select relative">
												<div class="select_title type_2 r_corners relative color_dark mw_0">Mr</div>
												<ul class="select_list d_none"></ul>
												<select name="product_name">
													<option value="Mr 1">Mr 1</option>
													<option value="Ms">Ms</option>
												</select>
											</div>
										</li>
										-->
										<li class="m_bottom_15">
											<label for="f_name_1" class="d_inline_b m_bottom_5 required">Fatura için ad ve soyad</label>
											<input type="text" id="f_name_1" name="user_1" class="r_corners full_width validate[required]">
										</li>
										<li class="m_bottom_15">
											<label for="address_1" class="d_inline_b m_bottom_5 required">Fatura adresi</label>
											<input type="text" id="address_1" name="address_1" class="r_corners full_width validate[required]">
										</li>
										<!--
										<li class="m_bottom_15">
											<label for="address_1_1" class="d_inline_b m_bottom_5 required">Address 2</label>
											<input type="text" id="address_1_1" name="" class="r_corners full_width">
										</li>
										-->
										<li class="m_bottom_15">
											<label for="code_1" class="d_inline_b m_bottom_5 required">Posta kodu</label>
											<input type="text" id="code_1" name="postal_1" class="r_corners full_width validate[required,custom[number]]">
										</li>
										<li class="m_bottom_15">
											<label for="city_1" class="d_inline_b m_bottom_5 required">Şehir</label>
											<input type="text" id="city_1" name="city_1" class="r_corners full_width validate[required]">
										</li>
										<li class="m_bottom_15">
											<label class="d_inline_b m_bottom_5 required">Ülke</label>
											<!--product name select-->
											<input type="text" id="country_1" name="country_1" class="r_corners full_width validate[required]" value="Türkiye" disabled>
										</li>
										<!--
										<li class="m_bottom_15">
											<label class="d_inline_b m_bottom_5 required">State / Province / Region</label>
											<div class="custom_select relative">
												<div class="select_title type_2 r_corners relative color_dark mw_0">Please select</div>
												<ul class="select_list d_none"></ul>
												<select name="product_name">
													<option value="1">1</option>
													<option value="2">2</option>
												</select>
											</div>
										</li>
										-->
										<li class="m_bottom_15">
											<label for="phone_1" class="d_inline_b m_bottom_5 required">Cep telefonu numarası <small>"Sipariş numaranızı göndereceğiz"</small></label>
											<input type="text" id="phone_1" name="tel_h_1" class="r_corners full_width phone-mask">
										</li>
										<li class="m_bottom_15">
											<label for="m_phone_1" class="d_inline_b m_bottom_5">Ekstra telefon numarası</label>
											<input type="text" id="m_phone_1" name="tel_m_1" class="r_corners full_width phone-mask">
										</li>
										<li class="m_bottom_15">
											<label for="fax_1" class="d_inline_b m_bottom_5">Fax numarası</label>
											<input type="text" id="fax_1" name="fax_1" class="r_corners full_width phone-mask">
										</li>
										<li>
											<label for="f_name_1" class="d_inline_b m_bottom_5">T.C. Kimlik numarası <small>"Fatura isteniyorsa girilmesi zorunludur"</small></label>
											<input type="text" id="f_name_1" name="user_1" class="r_corners full_width tc-mask">
										</li>
									</ul>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6">
								<h5 class="fw_medium m_bottom_15">Teslimat Bilgileri </h5>
									<ul>
										<li class="m_bottom_15">
											<label for="email_2" class="d_inline_b m_bottom_5">E-mail adresi</label>
											<input type="text" id="email_2" name="email_2" class="r_corners full_width validate[custom[email]]">
										</li>
										<!--
										<li class="m_bottom_5">
											<input type="checkbox" checked class="d_none" name="checkbox_6" id="checkbox_6"><label for="checkbox_6">Add/Edit shipment address</label>
										</li>
										<li class="m_bottom_15">
											<label for="a_name_1" class="d_inline_b m_bottom_5">Address Nickname</label>
											<input type="text" id="a_name_1" name="" class="r_corners full_width">
										</li>
										-->
										<li class="m_bottom_15">
											<label for="c_name_2" class="d_inline_b m_bottom_5">Şirket adı</label>
											<input type="text" id="c_name_2" name="company_2" class="r_corners full_width">
										</li>
										<li class="m_bottom_15">
											<label for="f_name_2" class="d_inline_b m_bottom_5">Teslimat yapılacak kişinin adı ve soyadı</label>
											<input type="text" id="f_name_2" name="user_2" class="r_corners full_width">
										</li>
										<li class="m_bottom_15">
											<label for="address_2" class="d_inline_b m_bottom_5">Teslimat adresi</label>
											<input type="text" id="address_2" name="address_2" class="r_corners full_width">
										</li>
										<!--
										<li class="m_bottom_15">
											<label for="address_1_2" class="d_inline_b m_bottom_5">Address 2</label>
											<input type="text" id="address_1_2" name="" class="r_corners full_width">
										</li>
										-->
										<li class="m_bottom_15">
											<label for="code_2" class="d_inline_b m_bottom_5">Posta kodu</label>
											<input type="text" id="code_2" name="postal_2" class="r_corners full_width validate[custom[number]]">
										</li>
										<li class="m_bottom_15">
											<label for="city_2" class="d_inline_b m_bottom_5">Şehir</label>
											<input type="text" id="city_2" name="city_2" class="r_corners full_width">
										</li>
										<li class="m_bottom_15">
											<label class="d_inline_b m_bottom_5 required">Ülke</label>
											<!--product name select-->
											<input type="text" id="country_2" name="country_2" class="r_corners full_width" value="Türkiye" disabled>
										</li>
										<!--
										<li class="m_bottom_15">
											<label class="d_inline_b m_bottom_5">State / Province / Region</label>
											<div class="custom_select relative">
												<div class="select_title type_2 r_corners relative color_dark mw_0">Please select</div>
												<ul class="select_list d_none"></ul>
												<select name="product_name">
													<option value="1">1</option>
													<option value="2">2</option>
												</select>
											</div>
										</li>
										-->
										<li class="m_bottom_15">
											<label for="phone_2" class="d_inline_b m_bottom_5">Cep telefonu numarası</label>
											<input type="text" id="phone_2" name="tel_h_2" class="r_corners full_width phone-mask">
										</li>
										<li class="m_bottom_15">
											<label for="m_phone_2" class="d_inline_b m_bottom_5">Ekstra telefon numarası</label>
											<input type="text" id="m_phone_2" name="tel_m_2" class="r_corners full_width phone-mask">
										</li>
										<li>
											<label for="fax_2" class="d_inline_b m_bottom_5">Fax numarası</label>
											<input type="text" id="fax_2" name="fax_2" class="r_corners full_width phone-mask">
										</li>
									</ul>
							</div>
						</div>
						</br>
						<input type="checkbox" id="checkbox_9" name="order_address_is_invoice_address" class="d_none"><label for="checkbox_9"><strong>Fatura bilgilerimi teslimat bilgilerim olarak kullan.</strong></label>
						</br>
						<input type="checkbox" id="checkbox_10" name="invoice_email_on" class="d_none" checked><label for="checkbox_10"><strong>Faturamı e-mail olarak almak istiyorum.</strong></label>
						</br>
						<input type="checkbox" id="checkbox_11" name="invoice_remember_on" class="d_none" checked><label for="checkbox_11"><strong>Sonraki siparişlerimde beni hatırla.</strong></label>
					</div>
					<h2 class="tt_uppercase color_dark m_bottom_30">KARGO SEÇİMİ</h2>
					<div class="bs_inner_offsets bg_light_color_3 shadow r_corners m_bottom_45">
						<?php
                        $i = 0;
    $j = count($shippings);
    ?>
						<?php foreach ($shippings as $shipping) {
    ?>
							<?php
                                if ($_SESSION['cart']['shipping_id'] == $shipping['shipping_id'] || count($shippings) == 1) {
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
    ?>
							<figure class="block_select clearfix relative shipping-select m_bottom_15" data-shipping="<?php echo $shipping['shipping_id'];
    ?>">
								<input type="radio" <?php echo $checked;
    ?> name="radio_1" class="d_none" value="<?php echo $shipping['shipping_id'];
    ?>">
								<img src="<?php echo Routes::$image;
    ?><?php echo $shipping['shipping_img'];
    ?>" alt="" class="f_left m_right_20 f_mxs_none m_mxs_bottom_10">
								<figcaption>
									<div class="d_table_cell d_sm_block p_sm_right_0 p_right_45 m_mxs_bottom_5">
										<h5 class="color_dark fw_medium m_bottom_15 m_sm_bottom_5"><?php echo $shipping['shipping_name'];
    ?></h5>
										<p><?php echo $shipping['shipping_desc'];
    ?></p>
									</div>
									<div class="d_table_cell d_sm_block discount">
										<h5 class="color_dark fw_medium m_bottom_15 m_sm_bottom_0">Ücret</h5>
										<?php if ($shipping['shipping_price'] > 0) {
    ?>
										<p class="color_dark">+<?php echo $shipping['shipping_price'];
    ?> TL</p>
										<?php 
} else {
    ?>
										<p class="color_dark">Ücretsiz</p>
										<?php 
}
    ?>
									</div>
								</figcaption>
							</figure>

							<?php $i++;
    if ($i < $j) {
        echo '<hr class="m_bottom_20">';
    }
    ?>

						<?php 
}
    ?>
					</div>

					<h2 class="tt_uppercase color_dark m_bottom_30">KULLANICI SÖZLEŞMESİ</h2>
					<table class="table_type_5 full_width r_corners wraper shadow t_align_l m_bottom_45">
						<tr>
							<td colspan="2">
								<?php
                                $blog = new Blog();
    $blog->content_id = 123;
    $content = $blog->content();
    ?>
								<div id="term-of-service" class="m_bottom_10">
									<?php echo $content['content_text'];
    ?>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="checkbox" name="termofservice" id="checkbox_8" class="d_none" checked><label for="checkbox_8"><strong>Kullanıcı sözleşmesini okudum ve anladım.</strong></label>
							</td>
						</tr>
					</table>

					<h2 class="tt_uppercase color_dark m_bottom_30">NOTUNUZ</h2>
					<!--requests table-->
					<table class="table_type_5 full_width r_corners wraper shadow t_align_l m_bottom_45">
						<tr>
							<td colspan="2">
								<label for="notes" class="d_inline_b m_bottom_5">Belirtmek istediğiniz özel bir durum, hediye paketi vb. isteklerinizi bu alana yazabilirsiniz:</label>
								<textarea id="notes" name="note" class="r_corners notes full_width"></textarea>
							</td>
						</tr>
					</table>

					<h2 class="tt_uppercase color_dark m_bottom_30">ÖDEME YÖNTEMİ</h2>
					<div class="bs_inner_offsets bg_light_color_3 shadow r_corners m_bottom_45">
						<?php
                        $i = 0;
    $j = count($payments_available);
    ?>

						<?php foreach ($payments_available as $payment) {
    ?>

							<?php
                                if (@$_SESSION['cart']['payment_id'] == $payment['payment_id']) {
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
    ?>

							<figure class="block_select clearfix relative payment-select m_bottom_20" data-payment="<?php echo $payment['payment_id'];
    ?>">
								<input type="radio" <?php echo $checked;
    ?> name="radio_2" class="d_none" value="<?php echo $payment['payment_id'];
    ?>">
								<img src="<?php echo Routes::$image;
    ?><?php echo $payment['payment_img'];
    ?>" alt="" class="f_left m_right_20 f_mxs_none m_mxs_bottom_10">
								<figcaption>
									<div class="d_table_cell d_sm_block p_sm_right_0 p_right_45 m_mxs_bottom_5">
										<h5 class="color_dark fw_medium m_bottom_15 m_sm_bottom_5"><?php echo $payment['payment_name'];
    ?></h5>
										<p><?php echo $payment['payment_desc'];
    ?></p>
									</div>
									<div class="d_table_cell d_sm_block discount">
										<h5 class="color_dark fw_medium m_bottom_15 m_sm_bottom_0">İlave Ücret</h5>
										<?php if (!empty($payment['payment_info'])) {
    ?>
										<p class="color_dark"><?php echo $payment['payment_info'];
    ?></p>
										<?php 
} else {
    ?>
										<p class="color_dark">Yok</p>
										<?php 
}
    ?>
									</div>

								</figcaption>
							</figure>

							<?php $i++;
    if ($i < $j) {
        echo '<hr class="m_bottom_20">';
    }
    ?>

						<?php 
}
    ?>
					</div>

					<h2 class="tt_uppercase color_dark m_bottom_30">ÖDEMEYİ YAPIN</h2>
					<div class="bs_inner_offsets bg_light_color_3 shadow r_corners m_bottom_45" id="payment-done">
					<?php if (isset($_SESSION['cart']['payment_id'])) {
    ?>
						<?php echo_cart_payment($_SESSION['cart']['payment_id']);
    ?>
					<?php 
} else {
    ?>
						<p>Siparişinizi tamamlamak için bir ödeme yöntemi seçmelisiniz</p>
					<?php 
}
    ?>
					</div>
				</form>
				<?php 
} ?>
			</section>
			<!--right column-->
			<aside class="col-lg-3 col-md-3 col-sm-3">
				<!--widgets-->
				<?php
                product_categories();
                banners(5);
                best_sellers();
                ?>
			</aside>
		</div>
	</div>
</div>
