<?php
// Arama motoru optimizasyonu için 404 sayfalarının 404 header'ı göndermesini sağla
header('Status: 404 Not Found');
header('HTTP/1.1 404 Not Found');

global $setting;
?>
<div class="page_content_offset">
	<div class="container">
		<h2 class="tt_uppercase color_dark m_bottom_25">Upss! <small><?php echo __('Page not found');?></small></h2>
		<h3 class="centered m_bottom_25"><?php echo __('You\'re looking for something that doesn\'t actually exist');?>.</h3>
		<div class="row clearfix">
			<a href="<?php echo Routes::$base;?>blog">
			<div class="col-lg-4 col-md-4 col-sm-4 m_bottom_45">
				<div class="r_corners bg_color_green_2 glyphicon_item vc_child">
					<div class="d_inline_middle d_md_block t_align_l">
						<i class="fa fa-bullhorn d_inline_middle m_right_15 color_light d_md_block m_md_bottom_5 m_md_right_0"></i>
						<dl class="d_inline_middle color_light d_md_block">
							<dt><b>Blog </b></dt>
							<dd class="fw_medium">İlginiz çekebilecek</br>yazıları okuyun</dd>
						</dl>
					</div>
				</div>
			</div>
			</a>
			<a href="<?php echo Routes::$base;?>">
			<div class="col-lg-4 col-md-4 col-sm-4 m_bottom_45">
				<div class="r_corners bg_color_blue_2 glyphicon_item vc_child">
					<div class="d_inline_middle d_md_block t_align_l">
						<i class="fa fa fa-shopping-cart d_inline_middle m_right_15 color_light d_md_block m_md_bottom_5 m_md_right_0"></i>
						<dl class="d_inline_middle color_light d_md_block">
							<dt><b>Alışveriş</b></dt>
							<dd class="fw_medium">Sepetinizi doldurun</br>fırsatları kaçırmayın</dd>
						</dl>
					</div>
				</div>
			</div>
			</a>
			<a href="<?php echo Routes::$base;?>contact">
			<div class="col-lg-4 col-md-4 col-sm-4 m_bottom_45">
				<div class="r_corners bg_scheme_color glyphicon_item vc_child">
					<div class="d_inline_middle d_md_block t_align_l">
						<i class="fa fa-smile-o d_inline_middle m_right_15 color_light d_md_block m_md_bottom_5 m_md_right_0"></i>
						<dl class="d_inline_middle color_light d_md_block">
							<dt><b>İletişim</b></dt>
							<dd class="fw_medium">Şikayet ve önerileriniz</br>için bize ulaşın</dd>
						</dl>
					</div>
				</div>
			</div>
			</a>
		</div>
	</div>
</div>
<?php
require_once('app/view/footer.php');
?>