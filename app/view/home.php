<!--slider with banners-->
<section class="container d_xs_none">
	<div class="row clearfix">
		<!--slider-->
		<div class="col-lg-9 col-md-9 col-sm-9 m_xs_bottom_30">
			<div class="flexslider animate_ftr long">
				<ul class="slides radius-5">
					<?php echo $slides; ?>
				</ul>
			</div>
		</div>
		<!--banners-->
		<div class="col-lg-3 col-md-3 col-sm-3 t_xs_align_c s_banners">
			<?php 
			banners(1);
			banners(2);
			?>
		</div>
	</div>
</section>
<!--content-->
<div class="page_content_offset">
	<div class="container">
		<!--banners-->
		<section class="row clearfix">
			<?php
			banners(8);
			banners(9);
			?>
		</section>
		<div class="row clearfix">
			<aside class="col-lg-3 col-md-3 col-sm-3 m_xs_bottom_30">
				<!--widgets-->
				<?php product_categories(); ?>
				<!--compare products
				<figure class="widget animate_ftr shadow r_corners wrapper m_bottom_30">
					<figcaption>
						<h3 class="color_light">Compare Products</h3>
					</figcaption>
					<div class="widget_content">
						<div class="clearfix m_bottom_15 relative cw_product">
							<img src="app/design/images/bestsellers_img_1.jpg" alt="" class="f_left m_right_15 m_sm_bottom_10 f_sm_none f_xs_left m_xs_bottom_0">
							<a href="#" class="color_dark d_block bt_link">Ut tellus dolor<br> dapibus</a>
							<button type="button" class="f_size_medium f_right color_dark bg_tr tr_all_hover close_fieldset"><i class="fa fa-times lh_inherit"></i></button>
						</div>
						<hr class="m_bottom_15">
						<div class="clearfix m_bottom_25 relative cw_product">
							<img src="app/design/images/bestsellers_img_2.jpg" alt="" class="f_left m_right_15 m_sm_bottom_10 f_sm_none f_xs_left m_xs_bottom_0">
							<a href="#" class="color_dark d_block bt_link">Elemenum vel</a>
							<button type="button" class="f_size_medium f_right color_dark bg_tr tr_all_hover close_fieldset"><i class="fa fa-times lh_inherit"></i></button>
						</div>
						<a href="#" class="color_dark"><i class="fa fa-files-o m_right_10"></i>Go to Compare</a>
					</div>
				</figure>
				-->
				<!--wishlist
				<figure class="widget animate_ftr shadow r_corners wrapper m_bottom_30">
					<figcaption>
						<h3 class="color_light">Wishlist</h3>
					</figcaption>
					<div class="widget_content">
						You have no product to compare.
					</div>
				</figure>
				-->
				<!--banner-->
				<?php banners(5); ?>
				<!--Bestsellers-->
				<?php best_sellers(); ?>
				<!--tags
				<figure class="widget animate_ftr shadow r_corners wrapper">
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
			<section class="col-lg-9 col-md-9 col-sm-9">
				<h2 class="tt_uppercase color_dark m_bottom_10 heading5 animate_ftr">ÖNE ÇIKAN ÜRÜNLER</h2>
				<!--products-->
				<section class="products_container a_type_2 category_grid clearfix m_bottom_25">
					<!--product item-->
					<?php 
					foreach ($featured_products AS $featured_p) {
						echo '	<div class="product_item hit w_xs_full">';
						product_view_242($featured_p, 'featured');
						echo '	</div>';
					}
					?>
				</section>
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
		</div>
		
		<!--product brands-->
		<div class="clearfix m_bottom_25 m_sm_bottom_20">
			<h2 class="tt_uppercase color_dark f_left heading2 animate_fade f_mxs_none m_mxs_bottom_15">EN ÇOK SATAN MARKALAR</h2>
			<div class="f_right clearfix nav_buttons_wrap animate_fade f_mxs_none">
				<button class="button_type_7 bg_cs_hover box_s_none f_size_ex_large t_align_c bg_light_color_1 f_left tr_delay_hover r_corners pb_prev"><i class="fa fa-angle-left"></i></button>
				<button class="button_type_7 bg_cs_hover box_s_none f_size_ex_large t_align_c bg_light_color_1 f_left m_left_5 tr_delay_hover r_corners pb_next"><i class="fa fa-angle-right"></i></button>
			</div>
		</div>
		<!--product brands carousel-->
		<div class="product_brands with_sidebar m_sm_bottom_35">
			<?php foreach ($manufacturers AS $manufacturer) { 
					if (!empty($manufacturer['manufacturer_img'])) { ?>
						<a href="<?php echo Routes::$base.'manufacturer/'.$manufacturer['manufacturer_id']; ?>" class="d_block t_align_c animate_fade"><img src="<?php echo Routes::$image.$manufacturer['manufacturer_img']; ?>" alt="<?php echo $manufacturer['manufacturer_name']; ?>"></a>
			<?php 	} 
				  } ?>
		</div>
		
		<!--blog-->
		<hr class="m_top_20 m_bottom_15">
		<div class="row clearfix m_top_45 m_bottm_45 m_md_bottom_35 m_xs_bottom_30">
			<div class="col-lg-6 col-md-6 col-sm-12 m_sm_bottom_35 blog_animate animate_ftr">
				<div class="clearfix m_bottom_25 m_sm_bottom_20">
					<h2 class="tt_uppercase color_dark f_left">BLOG'DAN HABERLER</h2>
					<div class="f_right clearfix nav_buttons_wrap">
						<button class="button_type_7 bg_cs_hover box_s_none f_size_ex_large bg_light_color_1 f_left tr_delay_hover r_corners blog_prev"><i class="fa fa-angle-left"></i></button>
						<button class="button_type_7 bg_cs_hover box_s_none f_size_ex_large bg_light_color_1 f_left m_left_5 tr_delay_hover r_corners blog_next"><i class="fa fa-angle-right"></i></button>
					</div>
				</div>
				
				
				<!--blog carousel-->
				<div class="blog_carousel">
					<?php foreach ($contents AS $content) { ?>
					<div class="clearfix">
						<!--image-->
						<?php if (!strpos($content['content_img_t'],'no-pic.png')) { ?>
						<a href="<?php echo Routes::$base.'/page/'.$content['content_id'].'/'.$content['content_title']; ?>" class="d_block photoframe relative shadow wrapper r_corners f_left m_right_20 animate_ftt f_mxs_none m_mxs_bottom_10">
							<img class="tr_all_long_hover" src="<?php echo $content['content_img_t']; ?>" alt="">
						</a>
						<?php } ?>
						<!--post content-->
						<div class="mini_post_content">
							<h4 class="m_bottom_5 animate_ftr"><a href="#" class="color_dark"><b><?php echo $content['content_title']; ?></b></a></h4>
							<p class="f_size_medium m_bottom_10 animate_ftr"><?php echo $content['content_date']; ?></p>
							<p class="m_bottom_10 animate_ftr"><?php echo $content['content_summary']; ?></p>
							<a class="tt_uppercase f_size_large animate_ftr" href="<?php echo Routes::$base.'/page/'.$content['content_id'].'/'.$content['content_title']; ?>">Devamını Oku</a>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
			<!--testimonials-->
			<div class="col-lg-6 col-md-6 col-sm-12 ti_animate animate_ftr">
				<div class="clearfix m_bottom_25 m_sm_bottom_20">
					<h2 class="tt_uppercase color_dark f_left f_mxs_none m_mxs_bottom_15">MÜŞTERİ YORUMLARI</h2>
					<div class="f_right clearfix nav_buttons_wrap f_mxs_none">
						<button class="button_type_7 bg_cs_hover box_s_none f_size_ex_large bg_light_color_1 f_left tr_delay_hover r_corners ti_prev"><i class="fa fa-angle-left"></i></button>
						<button class="button_type_7 bg_cs_hover box_s_none f_size_ex_large bg_light_color_1 f_left m_left_5 tr_delay_hover r_corners ti_next"><i class="fa fa-angle-right"></i></button>
					</div>
				</div>
				<!--testimonials carousel-->
				<div class="testiomials_carousel">
					<div>
						<blockquote class="r_corners shadow f_size_large relative m_bottom_15 animate_ftr">Kız arkadaşıma doğum gününden bir gün önce Armani Diamond aldım, ertesi gün elindeydi. Hem beni hem sevgilimi mutlu etmeyi başaran parfümal.com ekibine teşekkür ediyorum.</blockquote>
						<!--
						<img class="circle m_left_20 d_inline_middle animate_ftr" src="images/testimonial_img_1.jpg" alt="">
						-->
						<div class="d_inline_middle m_left_15 animate_ftr">
							<h5 class="color_dark"><b>Anıl AKKÖY</b></h5>
							<p>İzmir</p>
						</div>
					</div>
					<div>
						<blockquote class="r_corners shadow f_size_large relative m_bottom_15">Arayıp bulamadığım ürünlerin tamamını bir sitede bulabilmek çok hoş, fiyatlarda gayet uygun.</blockquote>
						<!--
						<img class="circle m_left_20 d_inline_middle animate_ftr" src="images/testimonial_img_1.jpg" alt="">
						-->
						<div class="d_inline_middle m_left_15">
							<h5 class="color_dark"><b>Özge ÇEŞMECİ</b></h5>
							<p>Manisa</p>
						</div>
					</div>
					<div>
						<blockquote class="r_corners shadow f_size_large relative m_bottom_15">İnternetten orjinal parfüm alınca dolandırılmaktan korkuyordum, Gülüş parfümeri Alsancak'ta ofisime çok yakınmış gidip tanıştım. Beni çok güzel ağırladılar. Az önce üçüncü siparişim elime geçti yine çok güzel bir kutu hazırlamışlar, Onur Bey'e teşekkür ederim.</blockquote>
						<!--
						<img class="circle m_left_20 d_inline_middle animate_ftr" src="images/testimonial_img_1.jpg" alt="">
						-->
						<div class="d_inline_middle m_left_15">
							<h5 class="color_dark"><b>Merve PAZARCI</b></h5>
							<p>İzmir</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>