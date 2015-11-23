<!--breadcrumbs-->
<section class="breadcrumbs">
	<div class="container">
		<ul class="horizontal_list clearfix bc_list f_size_medium">
			<li class="m_right_10 current"><a href="<?php echo Routes::$base; ?>" class="default_t_color">Anasayfa<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
			<li><a href="<?php echo Routes::$base . Routes::$module . '/' . Routes::$func . '/' . Routes::$get[1]; ?>" class="default_t_color"><?php echo Routes::$get[1]; ?></a></li>
		</ul>
	</div>
</section>
<!--content-->
<div class="page_content_offset">
	<div class="container">
		<div class="row clearfix">
			<?php if (!empty($products)) { ?>
			<!--left content column-->
			<section class="col-lg-9 col-md-9 col-sm-9">
				<h2 class="tt_uppercase color_dark m_bottom_25"><?php echo Routes::$get[1]; ?></h2>
				<?php if (!empty($category['category_img'])) { ?>
				<img class="r_corners m_bottom_40" src="<?php echo $category['category_img'];?>" alt="<?php echo $category['category_name'];?>">
				<?php } ?>
				<!--sort-->
				<div class="row clearfix m_bottom_10">
					<div class="col-lg-7 col-md-8 col-sm-12 m_sm_bottom_10">
						<p class="d_inline_middle f_size_medium">Sırala:</p>
						<div class="clearfix d_inline_middle m_left_10">
							<!--product name select-->
							<form action="<?php echo Routes::$path; ?>" method="get">
								<div class="f_size_medium relative f_left">
									<select name="order_by">
										<option value="product_name_ASC">Ada göre sırala (A'dan Z'ye) </option>
										<option value="product_name_DESC">Ada göre sırala (Z'den A'ya) </option>
										<option value="product_price_ASC">Fiyata göre sırala (Artan) </option>
										<option value="product_price_DESC">Fiyata göre sırala (Azalan) </option>
									</select>
								</div>
								<button class="button_type_16 bg_light_color_1 color_dark tr_all_hover r_corners mw_0 box_s_none bg_cs_hover f_left m_left_5"><i class="fa fa-sort-amount-asc m_left_0 m_right_0"></i> Sırala</button>
							</form>
						</div>
						<!--manufacturer select
						<div class="custom_select f_size_medium relative d_inline_middle m_left_15 m_xs_left_5 m_mxs_left_0 m_mxs_top_10">
							<div class="select_title r_corners relative color_dark">Marka Seçin</div>
							<ul class="select_list d_none"></ul>
							<select name="manufacturer">
								<?php foreach ($manufacturers AS $manufacturer) { ?>
								<option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['manufacturer_name']; ?></option>
								<?php } ?>
							</select>
						</div>
						-->
					</div>
					<div class="col-lg-5 col-md-4 col-sm-12 t_align_r t_sm_align_l">
						<!--pagination
						<a role="button" href="#" class="button_type_10 color_dark d_inline_middle bg_cs_hover bg_light_color_1 t_align_c tr_delay_hover r_corners box_s_none"><i class="fa fa-angle-left"></i></a>
						<ul class="horizontal_list clearfix d_inline_middle f_size_medium m_left_10">
							<li class="m_right_10"><a class="color_dark" href="#">1</a></li>
							<li class="m_right_10"><a class="scheme_color" href="#">2</a></li>
							<li class="m_right_10"><a class="color_dark" href="#">3</a></li>
						</ul>
						<a role="button" href="#" class="button_type_10 color_dark d_inline_middle bg_cs_hover bg_light_color_1 t_align_c tr_delay_hover r_corners box_s_none"><i class="fa fa-angle-right"></i></a>
						-->
					</div>
				</div>
				<hr class="m_bottom_10 divider_type_3">
				
				<!--products-->
				<section class="products_container category_grid clearfix m_bottom_15">
					<!--product item-->
					<?php 
					foreach ($products AS $product) {
						echo '<div class="product_item hit w_xs_full">';
						product_view_242($product);	
						echo '</div>';
					} 
					?>
				</section>
				<hr class="m_bottom_10 divider_type_3">
				<div class="row clearfix m_bottom_15 m_xs_bottom_30">
					<div class="col-lg-7 col-md-7 col-sm-8 m_xs_bottom_10">
					</div>
					<div class="col-lg-5 col-md-5 col-sm-4 t_align_r t_xs_align_l">
						<!--pagination
						<a role="button" href="#" class="button_type_10 color_dark d_inline_middle bg_cs_hover bg_light_color_1 t_align_c tr_delay_hover r_corners box_s_none"><i class="fa fa-angle-left"></i></a>
						<ul class="horizontal_list clearfix d_inline_middle f_size_medium m_left_10">
							<li class="m_right_10"><a class="color_dark" href="#">1</a></li>
							<li class="m_right_10"><a class="scheme_color" href="#">2</a></li>
							<li class="m_right_10"><a class="color_dark" href="#">3</a></li>
						</ul>
						<a role="button" href="#" class="button_type_10 color_dark d_inline_middle bg_cs_hover bg_light_color_1 t_align_c tr_delay_hover r_corners box_s_none"><i class="fa fa-angle-right"></i></a>
						-->
					</div>
				</div>
			</section>
			<?php } else { ?>
				<section class="col-lg-9 col-md-9 col-sm-9">
					<h2 class="tt_uppercase color_dark m_bottom_25">Bu kategoride ürün bulunmamaktadır.</h2>
				</section>
			<?php } ?>	
			
			
			
			<!--right column-->
			<aside class="col-lg-3 col-md-3 col-sm-3">
				<?php echo product_categories(); ?>
				<!--widgets-->
				<figure class="widget shadow r_corners wrapper m_bottom_30">
					<figcaption>
						<h3 class="color_light">Filtrele</h3>
					</figcaption>
					<div class="widget_content">
						<!--filter form-->
						<form>
							<!--price-->
							<fieldset class="m_bottom_20">
								<legend class="default_t_color f_size_large m_bottom_15 clearfix full_width relative">
									<b class="f_left">Fiyat Aralığı</b>
								</legend>
								<div id="price" class="m_bottom_10"></div>
								<div class="clearfix range_values">
									<input class="f_left first_limit" readonly name="" type="text" value="0 TL">
									<input class="f_right last_limit t_align_r" readonly name="" type="text" value="2500 TL">
								</div>
							</fieldset>
							<!--checkboxes
							<fieldset class="m_bottom_15">
								<legend class="default_t_color f_size_large m_bottom_15 clearfix full_width relative">
									<b class="f_left">Markalar</b>
								</legend>
								<?php foreach ($manufacturers AS $manufacturer) { ?>
								<input type="checkbox" checked name="" id="checkbox_2" class="d_none" value="<?php echo $manufacturer['manufacturer_id']; ?>"><label for="checkbox_2"><?php echo $manufacturer['manufacturer_name']; ?></label><br>
								<?php } ?>
							</fieldset>
							-->
						</form>
					</div>
				</figure>
				<!--banner-->
				<a href="#" class="d_block r_corners m_bottom_30">
					<img src="<?php echo Routes::$base; ?>app/design/images/banner_img_6.jpg" alt="">
				</a>
				<!--Bestsellers-->
				<?php echo best_sellers(); ?>
			</aside>
		</div>
	</div>
</div>