<!--breadcrumbs-->
<section class="breadcrumbs">
	<div class="container">
		<ul class="horizontal_list clearfix bc_list f_size_medium">
			<li class="m_right_10 current"><a href="<?php echo Routes::$base; ?>" class="default_t_color">Anasayfa<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
			<!--
			<li class="m_right_10"><a href="#" class="default_t_color">Parfüm</a><i class="fa fa-angle-right d_inline_middle m_left_10"></i></li>
			-->
			<li><a href="<?php echo Routes::$path; ?>" class="default_t_color"><?php echo Routes::$get[1]; ?></a></li>
		</ul>
	</div>
</section>
<!--content-->
<div class="page_content_offset">
	<div class="container">
		<div class="row clearfix">
			<!--left content column-->
			<section class="col-lg-9 col-md-9 col-sm-9 m_xs_bottom_30" itemscope itemtype="http://schema.org/Product">
				<div class="clearfix m_bottom_30 t_xs_align_c">
					<div class="photoframe type_2 shadow r_corners f_left f_sm_none d_xs_inline_b product_single_preview relative m_right_30 m_bottom_5 m_sm_bottom_20 m_xs_right_0 w_mxs_full">
						<?php if (isset($product['general']['product_price_old_with_tax'])) { ?>
						<span class="hot_stripe"><img src="<?php echo Routes::$base;?>app/design/images/sale_product.png" alt=""></span>
						<?php } ?>
						<div class="relative d_inline_b m_bottom_10 qv_preview d_xs_block">
							<img id="zoom_image" src="<?php echo $product['general']['img_c']; ?>" data-zoom-image="<?php echo $product['general']['img_c']; ?>" class="tr_all_hover" alt="">
						</div>
						<!--carousel-->
						<?php if (!empty($product['images'])) { ?>
						<div class="relative qv_carousel_wrap">
							<button class="button_type_11 bg_light_color_1 t_align_c f_size_ex_large bg_cs_hover r_corners d_inline_middle bg_tr tr_all_hover qv_btn_single_prev">
								<i class="fa fa-angle-left "></i>
							</button>
							<ul class="qv_carousel_single d_inline_middle">
								<?php foreach ($product['images'] AS $image) { ?>
								<a href="#" data-image="<?php echo Routes::$image.$image['product_img_path'];?>" data-zoom-image="<?php echo Routes::$image.$image['product_img_path'];?>"><img src="<?php echo Routes::$image.$image['product_img_path'];?>" alt=""></a>
								<?php } ?>
							</ul>
							<button class="button_type_11 bg_light_color_1 t_align_c f_size_ex_large bg_cs_hover r_corners d_inline_middle bg_tr tr_all_hover qv_btn_single_next">
								<i class="fa fa-angle-right "></i>
							</button>
						</div>
						<?php } ?>
					</div>
					<div class="p_top_10 t_xs_align_l">
						<!--description-->
						<h1 class="color_dark fw_medium m_bottom_10" itemprop="name"><?php echo $product['name']; ?></h1>
						<!--
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
							<a href="#" class="d_inline_middle default_t_color f_size_small m_left_5">4 Değerlendirme </a>
						</div>
						-->
						<hr class="m_bottom_10 divider_type_3">
						<table class="description_table m_bottom_10">
							<tr>
								<td>Marka:</td>
								<td><a href="<?php echo Routes::$base.'manufacturer/'.$product['general']['manufacturer_id'].'/'.$product['general']['manufacturer_name']; ?>" class="color_dark" itemprop="manufacturer"><?php echo $product['general']['manufacturer_name']; ?></a></td>
							</tr>
							<tr>
								<td>Stok durumu:</td>
								<?php if ($product['general']['product_stock_amount'] > 0) { ?>
								<td><span class="color_green">Stokta <?php echo $product['general']['product_stock_amount']+100;?> adet var.</span></td>
								<?php } else { ?>
								<td><span class="scheme_color">Stokta bulunmuyor.</span></td>
								<?php } ?>
							</tr>
							<tr>
								<td>Stok kodu:</td>
								<td><?php echo $product['general']['product_code']; ?></td>
							</tr>
						</table>
						<h5 class="fw_medium m_bottom_10">Ürün ebatları</h5>
						<table class="description_table m_bottom_5">
							<tr>
								<td>Boyutlar:</td>
								<td><?php echo $product['general']['product_l']; ?>cm x <?php echo $product['general']['product_w']; ?>cm x <?php echo $product['general']['product_h']; ?>cm</td>
							</tr>
							<tr>
								<td>Ağırlık:</td>
								<td><?php echo $product['general']['product_weight']; ?> kg</td>
							</tr>
						</table>
						<hr class="divider_type_3 m_bottom_10">
						<!--
						<p class="m_bottom_10">Ut tellus dolor, dapibus eget, elementum vel, cursus eleifend, elit. Aenean auctor wisi et urna. Aliquam erat volutpat. Duis ac turpis. Donec sit amet eros. Lorem ipsum dolor sit amet, consecvtetuer adipiscing. </p>
						<hr class="divider_type_3 m_bottom_15">
						-->
						<div class="m_bottom_15">
							<?php if (isset($product['general']['product_price_old_with_tax'])) { ?>
							<s class="v_align_b f_size_ex_large"><?php echo $product['general']['product_price_old_with_tax']; ?> TL</s>
							<?php } ?>
							<span class="v_align_b f_size_big m_left_5 scheme_color fw_medium" itemprop="price"><?php echo $product['general']['product_price_with_tax']; ?> TL</span>
						</div>
						<table class="description_table type_2 m_bottom_15">
							<!--
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
							-->
							<tr>
								<td class="v_align_m">Miktar:</td>
								<td class="v_align_m">
								<div class="clearfix quantity r_corners d_inline_middle f_size_medium color_dark">
									<button class="bg_tr d_block f_left" data-direction="down" data-action="none">-</button>
									<?php 
									if (isset($_SESSION['cart']['amount'][$product['general']['product_id']]))
										$value = $_SESSION['cart']['amount'][$product['general']['product_id']];
									else
										$value = 1;
									?>
									<input type="text" name="" readonly value="<?php echo $value; ?>" class="f_left" id="product-<?php echo $product['general']['product_id'];?>-amount">
									<button class="bg_tr d_block f_left" data-direction="up" data-action="none">+</button>
								</div></td>
							</tr>
						</table>
						<div class="d_ib_offset_0 m_bottom_20">
							<button class="button_type_12 r_corners bg_scheme_color color_light tr_delay_hover d_inline_b f_size_large" onClick="cart_add(<?php echo $product['general']['product_id']; ?>);">
								Sepete Ekle
							</button>
							<!--
							<button class="button_type_12 bg_light_color_2 tr_delay_hover d_inline_b r_corners color_dark m_left_5 p_hr_0"><span class="tooltip tr_all_hover r_corners color_dark f_size_small">Wishlist</span><i class="fa fa-heart-o f_size_big"></i></button>
							<button class="button_type_12 bg_light_color_2 tr_delay_hover d_inline_b r_corners color_dark m_left_5 p_hr_0"><span class="tooltip tr_all_hover r_corners color_dark f_size_small">Compare</span><i class="fa fa-files-o f_size_big"></i></button>
							<button class="button_type_12 bg_light_color_2 tr_delay_hover d_inline_b r_corners color_dark m_left_5 p_hr_0 relative"><i class="fa fa-question-circle f_size_big"></i><span class="tooltip tr_all_hover r_corners color_dark f_size_small">Ask a Question</span></button>
							-->
						</div>
						<div class="d_inline_middle m_left_5 addthis_widget_container">
							<!-- AddThis Button BEGIN -->
							<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
								<a class="addthis_button_preferred_1"></a>
								<a class="addthis_button_preferred_2"></a>
								<a class="addthis_button_preferred_3"></a>
								<a class="addthis_button_preferred_4"></a>
								<a class="addthis_button_compact"></a>
								<a class="addthis_counter addthis_bubble_style"></a>
							</div>
							<!-- AddThis Button END -->
						</div>
					</div>
				</div>
				<!--tabs-->
				<div class="tabs m_bottom_45">
					<!--tabs navigation-->
					<nav>
						<ul class="tabs_nav horizontal_list clearfix">
							<li class="f_xs_none">
								<a href="#tab-1" class="bg_light_color_1 color_dark tr_delay_hover r_corners d_block">Ürün hakkında</a>
							</li>
							<li class="f_xs_none">
								<a href="#tab-2" class="bg_light_color_1 color_dark tr_delay_hover r_corners d_block">Özellikleri</a>
							</li>
							<li class="f_xs_none">
								<a href="#tab-3" class="bg_light_color_1 color_dark tr_delay_hover r_corners d_block">Yorumlar</a>
							</li>
							<?php if (!empty($product['general']['product_video'])) { ?>
							<li class="f_xs_none">
								<a href="#tab-4" class="bg_light_color_1 color_dark tr_delay_hover r_corners d_block">Videosu</a>
							</li>
							<?php } ?>
						</ul>
					</nav>
					<section class="tabs_content shadow r_corners">
						<div id="tab-1">
							<p class="m_bottom_15">
								<?php echo $product['locals'][0]['product_text']; ?>
							</p>
							<hr class="m_bottom_15">
							Anahtar kelimeler: <?php echo $product['general']['product_seo_keywords']; ?>
						</div>
						<div id="tab-2">
							<h5 class="fw_medium m_bottom_15">Ürün Özellikleri:</h5>
							<div class="row clearfix">
								<div class="col-lg-6 col-md-6 col-sm-6 m_xs_bottom_15">
									<div class="table_sm_wrap">
										<table class="description_table type_3 m_xs_bottom_10">
											<tr>
												<td>Durumu:</td>
												<td>Orjinal kutusunda, açılmamış, kullanılmamış</td>
											</tr>
											<tr>
												<td>Markası:</td>
												<td><a href="<?php echo Routes::$base.'manufacturer/'.$product['general']['manufacturer_id'].'/'.$product['general']['manufacturer_name']; ?>" class="color_dark" itemprop="manufacturer"><?php echo $product['general']['manufacturer_name']; ?></a></td>
											</tr>
										</table>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6">
									<div class="table_sm_wrap">
										<table class="description_table type_3 m_xs_bottom_10">
											<tr>
												<td>Uzunluk:</td>
												<td><?php echo @$product['general']['product_l']; ?> cm</td>
											</tr>
											<tr>
												<td>Genişlik:</td>
												<td><?php echo @$product['general']['product_w']; ?> cm</td>
											</tr>
											<tr>
												<td>Yükseklik:</td>
												<td><?php echo @$product['general']['product_h']; ?> cm</td>
											</tr>
											<tr>
												<td>Ağırlık:</td>
												<td><?php echo @$product['general']['product_weight']; ?> kg</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div id="tab-3">
							<div class="row clearfix">
								<div class="col-lg-8 col-md-8 col-sm-8">
									<h5 class="fw_medium m_bottom_15">Last Reviews</h5>
									<!--review-->
									<article>
										<div class="clearfix m_bottom_10">
											<p class="f_size_medium f_left f_mxs_none m_mxs_bottom_5">
												By John Smith - Thursday, 26 December 2013
											</p>
											<!--rating-->
											<ul class="horizontal_list f_right f_mxs_none clearfix rating_list type_2">
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
										</div>
										<p class="m_bottom_15">
											Ut tellus dolor, dapibus eget, elementum vel, cursus eleifend, elit. Aenean auctor wisi et urna. Aliquam erat volutpat. Duis ac turpis. Donec sit amet eros. Lorem ipsum dolor sit amet, consecvtetuer adipiscing elit. Mauris fermentum dictum magna. Sed laoreet aliquam leo. Ut tellus dolor, dapibus eget, elementum vel, cursus eleifend, elit.
										</p>
									</article>
									<hr class="m_bottom_15">
									<!--review-->
									<article>
										<div class="clearfix m_bottom_10">
											<p class="f_size_medium f_left f_mxs_none m_mxs_bottom_5">
												By Admin - Thursday, 26 December 2013
											</p>
											<!--rating-->
											<ul class="horizontal_list f_right f_mxs_none clearfix rating_list type_2">
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
										</div>
										<p class="m_bottom_15">
											Vivamus eget nibh. Etiam cursus leo vel metus. Nulla facilisi. Aenean nec eros. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse sollicitudin velit sed leo.
										</p>
									</article>
									<hr class="m_bottom_15">
									<!--review-->
									<article>
										<div class="clearfix m_bottom_10">
											<p class="f_size_medium f_left f_mxs_none m_mxs_bottom_5">
												By Alan Doe - Thursday, 26 December 2013
											</p>
											<!--rating-->
											<ul class="horizontal_list f_right f_mxs_none clearfix rating_list type_2">
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
										</div>
										<p class="m_bottom_15">
											Ut pharetra augue nec augue. Nam elit agna,endrerit sit amet, tincidunt ac, viverra sed, nulla. Donec porta diam eu massa. Quisque diam lorem, interdum vitae,dapibus ac, scelerisque vitae, pede. Donec eget tellus non erat lacinia fermentum. Donec in velit vel ipsum auctor pulvinar. Vestibulum iaculis lacinia est.
										</p>
									</article>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4">
									<h5 class="fw_medium m_bottom_15">Write a Review</h5>
									<p class="f_size_medium m_bottom_15">
										Now please write a (short) review....(min. 100, max. 2000 characters)
									</p>
									<form>
										<textarea class="r_corners full_width m_bottom_10 review_tarea"></textarea>
										<p class="f_size_medium m_bottom_5">
											First: Rate the product. Please select a rating between 0 (poorest) and 5 stars (best).
										</p>
										<div class="d_block full_width m_bottom_10">
											<div class="d_block m_bottom_5 v_align_m">
												<p class="f_size_medium d_inline_middle m_right_5">
													Rating:
												</p>
												<!--rating-->
												<ul class="horizontal_list clearfix rating_list type_2 d_inline_middle">
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
											</div>
											<div class="f_size_medium m_bottom_10 d_block">
												<p class="d_inline_middle">
													Characters written:
												</p>
												<input type="text" class="r_corners d_inline_middle type_2 m_left_5 m_sm_left_0 m_xs_left_5 mxw_0 small_field" value="0">
											</div>
										</div>
										<button type="submit" class="r_corners button_type_4 tr_all_hover mw_0 color_dark bg_light_color_2">
											Submit
										</button>
									</form>
								</div>
							</div>
						</div>
						<?php if (!empty($product['general']['product_video'])) { ?>
						<div id="tab-4">
							<div class="iframe_video_wrap">
								<?php echo $product['general']['product_video']; ?>
							</div>
						</div>
						<?php } ?>
					</section>
				</div>
				
				<hr class="divider_type_3 m_bottom_15">
				<a href="<?php echo Routes::$base.'manufacturer/'.$product['general']['manufacturer_id'].'/'.$product['general']['manufacturer_name']; ?>" role="button" class="d_inline_b bg_light_color_2 color_dark tr_all_hover button_type_4 r_corners"><i class="fa fa-reply m_left_5 m_right_10 f_size_large"></i><?php echo $product['general']['manufacturer_name']; ?> markasının ürünlerini görmek için tıklayın</a>
				<p class="divider_type_3 m_bottom_45"> </p>
				
				<!--banners-->
				<?php banners(6); ?>
				<div class="clearfix">
					<h2 class="color_dark tt_uppercase f_left m_bottom_15 f_mxs_none heading5 animate_ftr">YENİ ÜRÜNLER</h2>
					<div class="f_right clearfix nav_buttons_wrap animate_fade f_mxs_none m_mxs_bottom_5">
						<button class="button_type_7 bg_cs_hover box_s_none f_size_ex_large t_align_c bg_light_color_1 f_left tr_delay_hover r_corners nc_prev"><i class="fa fa-angle-left"></i></button>
						<button class="button_type_7 bg_cs_hover box_s_none f_size_ex_large t_align_c bg_light_color_1 f_left m_left_5 tr_delay_hover r_corners nc_next"><i class="fa fa-angle-right"></i></button>
					</div>
				</div>
				<!-- new product carousel-->
				<div class="nc_carousel m_bottom_30 m_sm_bottom_20">
					<?php 
					foreach ($new_products AS $new_p) {
						product_view_242($new_p);
					}
					?>
				</div>
			</section>
			
			<!--right column-->
			<aside class="col-lg-3 col-md-3 col-sm-3">
				<?php product_categories(); ?>
				<!--compare products
				<figure class="widget shadow r_corners wrapper m_bottom_30">
				<figcaption>
				<h3 class="color_light">Compare Products</h3>
				</figcaption>
				<div class="widget_content">
				You have no product to compare.
				</div>
				</figure>
				-->
				<!--banner-->
				<?php echo banners(5); ?>
				<!--Bestsellers-->
				<?php echo best_sellers(); ?>
				<!--tags
				<figure class="widget shadow r_corners wrapper m_bottom_30">
				<figcaption>
				<h3 class="color_light">Tags</h3>
				</figcaption>
				<div class="widget_content">
				<div class="tags_list">
				<a href="#" class="color_dark d_inline_b v_align_b">accessories,</a>
				<a href="#" class="color_dark d_inline_b f_size_ex_large v_align_b">bestseller,</a>
				<a href="#" class="color_dark d_inline_b v_align_b">clothes,</a>
				<a href="#" class="color_dark d_inline_b f_size_big v_align_b">dresses,</a>
				<a href="#" class="color_dark d_inline_b v_align_b">fashion,</a>
				<a href="#" class="color_dark d_inline_b f_size_large v_align_b">men,</a>
				<a href="#" class="color_dark d_inline_b v_align_b">pants,</a>
				<a href="#" class="color_dark d_inline_b v_align_b">sale,</a>
				<a href="#" class="color_dark d_inline_b v_align_b">short,</a>
				<a href="#" class="color_dark d_inline_b f_size_ex_large v_align_b">skirt,</a>
				<a href="#" class="color_dark d_inline_b v_align_b">top,</a>
				<a href="#" class="color_dark d_inline_b f_size_big v_align_b">women</a>
				</div>
				</div>
				</figure>
				-->
			</aside>
		</div>
	</div>
</div>