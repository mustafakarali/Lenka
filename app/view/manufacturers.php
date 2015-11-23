<!--breadcrumbs-->
<section class="breadcrumbs">
	<div class="container">
		<ul class="horizontal_list clearfix bc_list f_size_medium">
			<li class="m_right_10 current"><a href="<?php echo Routes::$base;?>" class="default_t_color">Anasayfa<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
			<li><a href="<?php echo Routes::$base;?>manufacturers" class="default_t_color">Manufacturers</a></li>
		</ul>
	</div>
</section>
<!--content-->
<div class="page_content_offset">
	<div class="container">
		<div class="row clearfix">
			<!--left content column-->
			<section class="col-lg-9 col-md-9 col-sm-9 m_xs_bottom_30">
				<h2 class="tt_uppercase color_dark m_bottom_30">Manufacturers</h2>
				<div class="bg_light_color_3 r_corners shadow manufacturers t_xs_align_c">
					<div class="row clearfix m_bottom_25 m_xs_bottom_0">
						<?php foreach ($manufacturers AS $manufacturer) { ?>
						<figure class="col-lg-3 col-md-3 col-sm-3 col-xs-6 m_xs_bottom_15">
							<a href="<?php echo Routes::$base.'manufacturer/'.$manufacturer['manufacturer_id'].'/'.$manufacturer['manufacturer_name']; ?>" class="m_image_wrap d_block m_bottom_15 d_xs_inline_b d_mxs_block">
								<img src="images/brand_logo_type_2.jpg" alt="">
							</a>
							<figcaption>
								<h5><a href="<?php echo Routes::$base.'manufacturer/'.$manufacturer['manufacturer_id'].'/'.$manufacturer['manufacturer_name']; ?>" class="color_dark fw_medium"><?php echo $manufacturer['manufacturer_name']; ?></a></h5>
							</figcaption>
						</figure>
						<?php } ?>
					</div>
				</div>
			</section>
			<!--right column-->
			<aside class="col-lg-3 col-md-3 col-sm-3">
				<!--widgets-->
				<?php echo product_categories(); ?>
			</aside>
		</div>
	</div>
</div>