<?php
Seo::$value = 'parfümal.com | Orijinal parfümler';
Seo::$desc = 'Başta parfüm olmak üzere tüm orijinal kozmetik ürünlerini uygun fiyata bulabileceğiniz adres';
Seo::$keys = 'orijinal, parfüm, kozmetik, edt, edp, homme, femme, eticaret, gülüş, izmir';

$home = new Home();
$slides_data = $home->slides($_SESSION['lang_id']);

$slides = '';
foreach($slides_data AS $slide)
{
	$slides .=  '	<li>
						<img src="'.Routes::$image.$slide['slide_img'].'" alt="'.$slide['slide_title'].'">
						<section class="slide_caption t_align_c d_xs_none">
							<div class="color_light slider_title_4 tt_uppercase t_align_c m_bottom_10 m_md_bottom_10"><strong>'.$slide['slide_title'].'</strong></div>
							<div class="f_size_large color_light tt_uppercase slider_title_3 m_bottom_45">'.$slide['slide_text'].'</div>
							<a href="'.$slide['slide_href'].'" role="button" class="d_sm_inline_b button_type_4 bg_scheme_color color_light r_corners tt_uppercase tr_all_hover">TIKLA, GÖR!</a>
						</section>
					</li>';
}
$popup = $home->popup();
$popup['sonuc'] = '<a href="'.$popup['popup_href'].'" target="'.$popup['popup_target'].'"><img src="'.$site['image_path'].$popup['popup_img'].'" width="'.$popup['popup_img_width'].'"></a>'; 
	
$blog = new Blog();
$blog->limit = 5;
$blog->is_public = '= 1';
$contents = $blog->contents();

$i = 1;
$content = '';
foreach ($contents AS $c)
{
	$content .= ' <div class="row feature">
				    <div class="col-md-7">
				      <h2 class="featurette-heading">'. $c['content_title'] .'</h2>
				      <p class="lead">'. $c['content_summary'] .'</p>
				      <p><a class="btn btn-danger" href="'. Routes::$base.'page/'.$c['content_sef'] .'/'.$c['content_id'] .'" role="button">Devamını oku &raquo;</a></p>
				    </div>
				    <div class="col-md-5">
				      <img class="img img-responsive" src="'. $c['content_img_t'] .'" alt="Generic placeholder image">
				    </div>
				  </div>';
		
	if ($i < count($contents))		  
		$content .= ' <hr class="featurette-divider">'; 
	
	$i++;
}