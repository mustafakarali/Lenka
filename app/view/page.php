<?php
if (is_auth(99))
{
	?>
	<script type="text/javascript" src="<?php echo Routes::$base; ?>ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?php echo Routes::$base; ?>ckfinder/ckfinder.js"></script>
	<script>
		$('#inpage-edit').live('click', function() {
			text = $('#editable_content').html();
			sef   = $(this).attr('rel');
			
			var veri = {
				text: text,
				sef: sef
			}
			$.ajax({
				url: ajax_cms+"inpage_content_edit",   
				type: "POST",       
				data: veri,   
				cache: false,
				success: function (response) {
					location.reload();	
				}
			});
		});
	</script>
	<?php
	$contenteditable = 'contenteditable="true"';
}
else
{
	$contenteditable = '';
}
?>
<!--breadcrumbs-->
<section class="breadcrumbs">
	<div class="container">
		<ul class="horizontal_list clearfix bc_list f_size_medium">
			<li class="m_right_10 current"><a href="<?php echo Routes::$base; ?>" class="default_t_color">Anasayfa<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
			<li><a href="<?php echo Routes::$path;?>" class="default_t_color">Blog</a></li>
		</ul>
	</div>
</section>
<!--content-->
<div class="page_content_offset">
	<div class="container">
		<div class="row clearfix">
			<!--left content column-->
			<section class="col-lg-9 col-md-9 col-sm-9">
				<!--blog post-->
				<article class="m_bottom_45">
					<div class="row clearfix m_bottom_15">
						<div class="col-lg-9 col-md-9 col-sm-8">
							<h1 class="m_bottom_5 color_dark fw_medium m_xs_bottom_10"><?php echo $content['content_title']; ?></h1>
							<p class="f_size_medium"><?php echo $content['content_date']; ?></p>
						</div>
					</div>
					
					<!--post content-->
					<div class="m_bottom_15" id="editable_content" class="col-xs-12 col-sm-12" <?php echo $contenteditable;?>"><?php echo $content['content_text']; ?></div>
				
					<?php
					if (is_auth(99))
						echo '</br></br></br><p class="text-center"><a href="javascript:void(0);" id="inpage-edit" rel="'.$content['content_sef'].'" class="btn btn-danger" role="button">'.__('Save').'</a></p>';
					?>
				</article>
				<div class="m_bottom_30">
					<p class="d_inline_middle">Paylaş:</p>
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
				<div class="fb-comments" data-href="<?php echo Routes::$current; ?>" data-numposts="5" data-colorscheme="light" data-width="100%"></div>
			</section>
			<!--right column-->
			<aside class="col-lg-3 col-md-3 col-sm-3">
				<!--contents in category-->
				<figure class="widget shadow r_corners wrapper m_bottom_30">
					<figcaption>
						<h3 class="color_light">Blog'dan Haberler</h3>
					</figcaption>
					<div class="widget_content">
						<!--Categories list-->
						<ul class="categories_list">
							<?php echo $in_category ?>
						</ul>
					</div>
				</figure>
				<!-- Products -->
				<?php specials(); ?>
				<!--similar contents-->
				<?php if (!empty($in_similar)) { ?>
				<figure class="widget shadow r_corners wrapper m_bottom_30">
					<figcaption>
						<h3 class="color_light">Benzer İçerikler</h3>
					</figcaption>
					<div class="widget_content">
						<!--Categories list-->
						<ul class="categories_list">
							<?php echo $in_similar ?>
						</ul>
					</div>
				</figure>
				<?php } ?>
				<!--banner-->
				<a href="#" class="d_block r_corners m_bottom_30">
					<img src="images/banner_img_6.jpg" alt="">
				</a>
			</aside>
		</div>
	</div>
</div>

