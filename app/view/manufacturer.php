<!--breadcrumbs-->
<section class="breadcrumbs">
	<div class="container">
		<ul class="horizontal_list clearfix bc_list f_size_medium">
			<li class="m_right_10 current"><a href="<?php echo Routes::$base;?>" class="default_t_color">Anasayfa<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
			<li class="m_right_10 current"><a href="<?php echo Routes::$base.Routes::$module;?>s" class="default_t_color">Markalar<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
			<li><a href="<?php echo Routes::$base.Routes::$module.'/'.Routes::$func.'/'.Routes::$get[1];?>" class="default_t_color"><?php echo Routes::$get[1]; ?></a></li>
		</ul>
	</div>
</section>
<!--content-->
<div class="page_content_offset">
	<div class="container">
		<div class="row clearfix">
			<!--left content column-->
			<section class="col-lg-9 col-md-9 col-sm-9 m_xs_bottom_30">
				<h2 class="tt_uppercase color_dark m_bottom_30"><?php echo $manufacturer['manufacturer_name']; ?></h2>
				<?php if (!empty($manufacturer['manufacturer_img']) && !empty($manufacturer['manufacturer_desc'])) { ?>
				<div class="bg_light_color_3 r_corners shadow manufacturers">
					<img class="f_left m_right_20 m_sm_bottom_5" src="<?php echo Routes::$image.$manufacturer['manufacturer_img']; ?>" alt="">
					<p class="m_bottom_10"><?php echo $manufacturer['manufacturer_desc']; ?></p>
					<!--
					<p class="m_bottom_10">Integer rutrum ante eu lacus.Vestibulum libero nisl, porta vel, scelerisque eget, malesuada at, neque. Vivamus eget nibh. Etiam cursus leo vel metus. Nulla facilisi. Aenean nec eros. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse sollicitudin velit sed leo. Ut pharetra augue nec augue. </p>
					<div class="clearfix">
						<ul class="horizontal_list d_inline_b l_width_divider">
							<li class="m_right_15"><a href="#" class="color_dark">Email</a></li>
							<li class="m_right_15"><a href="#" class="color_dark">Manufacturer Page</a></li>
							<li class="m_right_15"><a href="#" class="color_dark">View All Manufacturer Name 1 Products</a></li>
						</ul>
					</div>
					-->
				</div>
				<?php } ?>
				<!--products-->
				<?php if (!empty($products)) { ?>
				<hr class="m_bottom_10 divider_type_3">
				<section class="products_container category_grid clearfix m_bottom_15">
					<!--product item-->
					<?php 
					foreach ($products AS $product) 
					{
						echo '<div class="product_item hit w_xs_full">';
						product_view_242($product);	
						echo '</div>';
					} 
					?>
				</section>
				<hr class="m_bottom_10 divider_type_3">
				<?php } else { ?>
					<h2>Bu markaya ait ürün bulunmamaktadır.</h2>
				<?php } ?>
			</section>
			
			<!--right column-->
			<aside class="col-lg-3 col-md-3 col-sm-3">
				<!--widgets-->
				<?php echo product_categories(); ?>
				<?php specials(); ?>
			</aside>
		</div>
	</div>
</div>