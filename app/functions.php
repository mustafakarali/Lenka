<?php
/*
$query = update('deneme')->values(array('deneme_name'=>':deneme'))->where('deneme_id = 1', false)->text();
$query->bindParam(':deneme', 'xxxxxxx');
*/
/** Run functions by checking their authentications level
 * 
 * @param string  $func_name  name of a function to run
 * @return runs a function by checking authentication level of function
 */
function func_app($func_name)
{
    // Set levels
    $func_auth = array('cache_klasorunu_temizle' => '100',
                       'tablodaki_ilgili_satir_ve_sutunu_guncelle' => '100', );

    if (!empty($func_auth[$func_name])) {
        if ($_SESSION['user_auth'] > $func_auth[$func_name]) {
            $func_name();
        } else {
            include 'app/view/header.php';
            error_in_page(401);

            return false;
        }
    } else {
        $func_name();
    }
}
/** Dynamic menu in app, it's in app folder because of possible design changes - stupid front end developers :))
 * 
 * @param int  $menu
 * @param int  $menu_data
 * @param int  $child
 * @return string  menu
 */
function menu($menu = 0, $menu_data = 0, $child = 0)
{
    $menus_data = select('menus')
                    ->left('menus_data ON menus_data.menu_id = menus.menu_id')
                    ->where('menus_data.parent_id = '.$menu_data.' AND
							 menus_data.menu_data_auth <= "'.$_SESSION['user_auth'].'" AND
						 	 menus.menu_id = '.$menu.'')
                    ->order('menus_data.menu_data_order ASC')
                    ->results();

    if ($child) {
        echo '<ul class="dropdown-menu">';
    }

    foreach ($menus_data as $data) {
        if ($data['menu_data_color'] != '0') {
            $style = 'style="color:'.$data['menu_data_color'].'"';
        } else {
            $style = '';
        }

        if (has_child($data['menu_id'], $data['menu_data_id'])) {
            echo '<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" '.$style.' target="'.$data['menu_data_target'].'">'.$data['menu_data_name'].'  <b class="caret"></b></a>';
            menu($data['menu_id'], $data['menu_data_id'], 1);
            echo '</li>';
        } else {
            echo '<li><a href="'.Routes::$base.$data['menu_data_href'].'" '.$style.' target="'.$data['menu_data_target'].'">'.$data['menu_data_name'].'</a></li>';
        }
    }
    if ($child) {
        echo '</ul>';
    }
}
/** Check if menu has a child 
 * 
 * @param int $menu
 * @param int $menu_data
 * @return bool
 */
function has_child($menu = 0, $menu_data = 0)
{
    $result = select('menus')
                    ->left('menus_data ON menus_data.menu_id = menus.menu_id')
                    ->where('menus_data.parent_id = '.$menu_data.' AND
							 menus_data.menu_data_auth <= "'.$_SESSION['user_auth'].'" AND
						 	 menus.menu_id = '.$menu.'')
                    ->order('menus_data.menu_data_order ASC')
                    ->results();
    if ($result) {
        return true;
    } else {
        return false;
    }
}
/** Product categories
 * 
 */
function product_categories()
{
    global $setting;

    $b = new Blog();
    $categories_product = $b->child_categories($setting['product_category_id']);

    echo '	<figure class="widget animate_ftr shadow r_corners wrapper m_bottom_30">
				<figcaption>
					<h3 class="color_light">KATEGORİLER</h3>
				</figcaption>
				<div class="widget_content">
					<ul class="categories_list">';

    $i = 0;
    foreach ($categories_product as $category) {
        if ($i == 1) {
            $active = 'class="active"';
            $d_none = '';
        } else {
            $active = '';
            $d_none = 'class="d_none"';
        }

        $sub_categories2 = $b->child_categories($category['category_id']);
        if (empty($sub_categories2)) {
            $active = '';
        }

        echo '
							<li '.$active.'>
								<a href="'.Routes::$base.'products/'.$category['category_id'].'/'.$category['category_name'].'" class="f_size_large scheme_color d_block relative">
									<b>'.$category['category_name'].'</b>';
        if (!empty($sub_categories2)) {
            echo '<span class="bg_light_color_1 r_corners f_right color_dark talign_c"></span>';
        }
        echo '
								</a>';

        if (!empty($sub_categories2)) {
            echo '	<!--second level-->
											<ul '.$d_none.'>';
            $j = 0;
            foreach ($sub_categories2 as $sub_category2) {
                if ($j == 0) {
                    $sub_active = 'class="active"';
                    $sub_d_none = '';
                } else {
                    $sub_active = '';
                    $sub_d_none = 'class="d_none"';
                }

                $sub_categories3 = $b->child_categories($sub_category2['category_id']);
                if (empty($sub_categories3)) {
                    $sub_active = '';
                }

                echo '
										<li '.$sub_active.'>
											<a href="'.Routes::$base.'products/'.$sub_category2['category_id'].'/'.$sub_category2['category_name'].'" class="d_block f_size_large color_dark relative">
												'.$sub_category2['category_name'];
                if (!empty($sub_categories3)) {
                    echo '<span class="bg_light_color_1 r_corners f_right color_dark talign_c"></span>';
                }
                echo '
											</a>';

                if (!empty($sub_categories3)) {
                    echo '	<!--third level-->
														<ul '.$sub_d_none.'>';
                    foreach ($sub_categories3 as $sub_category3) {
                        echo '<li><a href="'.Routes::$base.'products/'.$sub_category3['category_id'].'/'.$sub_category3['category_name'].'" class="color_dark d_block">'.$sub_category3['category_name'].'</a></li>';
                    }
                    echo '	</ul>';
                }
                echo '
										</li>';

                $j++;
            }
            echo '	</ul>';
        }

        echo '
							</li>';

        $i++;
    }
    echo '
					</ul>
				</div>
			</figure>';
}
/* Product view in 242px box */
function product_view_242($product, $type = false)
{
    echo '	<figure class="r_corners photoframe animate_ftb long tr_all_hover type_2 t_align_c shadow relative product" data-price="'.$product['product_price_with_tax'].'">
				<!--product preview-->
				<a href="'.Routes::$base.'product/'.$product['product_id'].'/'.$product['product_name'].'" class="d_block relative pp_wrap m_bottom_15">';
    if ($type == 'featured') {
        echo '<span class="hot_stripe type_2"><img src="'.Routes::$base.'app/design/images/hot_product_type_2.png" alt="Öne çıkan"></span>';
    } elseif ($type == 'sale') {
        echo '<span class="hot_stripe type_2"><img src="'.Routes::$base.'app/design/images/sale_product_type_2.png" alt="Fırsat"></span>';
    } elseif (isset($product['product_price_old'])) {
        echo '<span class="hot_stripe type_2"><img src="'.Routes::$base.'app/design/images/sale_product_type_2.png" alt="İndirim"></span>';
    }

    echo '
					<img src="'.$product['img_t'].'" class="tr_all_hover width_242" alt="'.$product['product_name'].'">
					<span role="button" class="button_type_5 box_s_none color_light r_corners tr_all_hover d_xs_none">Ürünü İncele</span>
				</a>
				<!--description and price of product-->
				<figcaption class="p_vr_0">
					<h5 class="m_bottom_10"><a href="'.Routes::$base.'product/'.$product['product_id'].'/'.$product['product_name'].'" class="color_dark">'.shorten($product['product_name'], 50).'</a></h5>
					<div class="clearfix">
						<p class="scheme_color f_size_large m_bottom_15">';
    if (isset($product['product_price_old_with_tax'])) {
        echo '<s>'.$product['product_price_old_with_tax'].' TL</s> ';
    }
    echo $product['product_price_with_tax'].' TL</p>
					</div>
					<button class="button_type_4 bg_scheme_color r_corners tr_all_hover color_light mw_0 m_bottom_15" onClick="cart_add('.$product['product_id'].')">Sepete Ekle</button>
				</figcaption>
			</figure>';
}
/* Best sellers */
function best_sellers()
{
    return false;
    echo '	<figure class="widget animate_ftr shadow r_corners wrapper m_bottom_30">
				<figcaption>
					<h3 class="color_light">EN ÇOK SATANLAR</h3>
				</figcaption>
				<div class="widget_content">
					<div class="clearfix m_bottom_15">
						<img src="app/design/images/bestsellers_img_1.jpg" alt="" class="f_left m_right_15 m_sm_bottom_10 f_sm_none f_xs_left m_xs_bottom_0">
						<a href="#" class="color_dark d_block bt_link">Ut dolor dapibus</a>
						<p class="scheme_color">$61.00</p>
					</div>
					<hr class="m_bottom_15">
					<div class="clearfix m_bottom_15">
						<img src="app/design/images/bestsellers_img_2.jpg" alt="" class="f_left m_right_15 m_sm_bottom_10 f_sm_none f_xs_left m_xs_bottom_0">
						<a href="#" class="color_dark d_block bt_link">Elementum vel</a>
						<p class="scheme_color">$57.00</p>
					</div>
					<hr class="m_bottom_15">
					<div class="clearfix m_bottom_5">
						<img src="app/design/images/bestsellers_img_3.jpg" alt="" class="f_left m_right_15 m_sm_bottom_10 f_sm_none f_xs_left m_xs_bottom_0">
						<a href="#" class="color_dark d_block bt_link">Crsus eleifend elit</a>
						<p class="scheme_color">$24.00</p>
					</div>
				</div>
			</figure>';
}
/* Special products */
function specials()
{
    $p = new Product();
    $products = $p->products_featured();

    echo '	<figure class="widget shadow r_corners wrapper m_bottom_30">
				<figcaption class="clearfix relative">
					<h3 class="color_light f_left f_sm_none m_sm_bottom_10 m_xs_bottom_0">ÖNE ÇIKANLAR</h3>
					<div class="f_right nav_buttons_wrap_type_2 tf_sm_none f_sm_none clearfix">
						<button class="button_type_7 bg_cs_hover box_s_none f_size_ex_large color_light t_align_c bg_tr f_left tr_delay_hover r_corners sc_prev"><i class="fa fa-angle-left"></i></button>
						<button class="button_type_7 bg_cs_hover box_s_none f_size_ex_large color_light t_align_c bg_tr f_left m_left_5 tr_delay_hover r_corners sc_next"><i class="fa fa-angle-right"></i></button>
					</div>
				</figcaption>
				<div class="widget_content">
					<div class="specials_carousel">';
    foreach ($products as $product) {
        echo '	<!--carousel item-->
									<div class="specials_item">
										<a href="'.Routes::$base.'product/'.$product['product_id'].'/'.$product['product_name'].'" class="d_block d_xs_inline_b wrapper m_bottom_20">
											<img class="tr_all_long_hover" src="'.$product['img_t'].'" alt="'.$product['product_name'].'">
										</a>
										<h5 class="m_bottom_10"><a href="#" class="color_dark">'.$product['product_name'].'</a></h5>
										<p class="f_size_large m_bottom_15"><s>'.@$product['product_price_old_with_tax'].'</s> <span class="scheme_color">'.$product['product_price_with_tax'].' TL</span></p>
										<button class="button_type_4 mw_sm_0 r_corners color_light bg_scheme_color tr_all_hover m_bottom_5" onClick="cart_add('.$product['product_id'].');">Sepete Ekle</button>
									</div>';
    }
    echo '
					</div>
				</div>
			</figure>';
}
/* Banners */
function banners($id = 5)
{
    if ($id == 1) {
        echo '	<!-- banner 1 -->
				<a href="'.Routes::$base.'product/254/Emporio%20Armani%20Emporio%20Diamonds%20Elle%20EDP%20Vapo%20100ml" class="d_block d_xs_inline_b m_bottom_20 animate_ftr">
					<img src="'.Routes::$base.'app/design/images/banner_img_7.jpg" alt="Armani Diamond Fırsatı" class="radius-5">
					<span class="d_inline_middle m_left_10 t_align_l d_md_block t_md_align_c right-slide">
						<b>ARMANI DIAMOND</b><br><span class="color-white"><s>250 TL yerine</s></span></br><h3>120 TL</h3>
					</span>
				</a>';
    } elseif ($id == 2) {
        echo '	<!-- banner 2 -->
				<a href="'.Routes::$base.'product/350/Jean%20Paul%20Gaultier%20Classique%20X%20EDT%20Bayan%20Parf%C3%BCm%20100ml" class="d_block d_xs_inline_b m_xs_left_5 animate_ftr m_mxs_left_0">
					<img src="'.Routes::$base.'app/design/images/banner_img_8.jpg" alt="Jean Paul Gaultier parfümünde indirim" class="radius-5">
					<span class="d_inline_middle m_left_10 t_align_r d_md_block t_md_align_c right-slide2">
						<b>JEAN PAUL GAULTIER</b><br><span class="color-white"><s>289 TL yerine</s></span></br><h3>199 TL</h3>
					</span>
				</a>';
    } elseif ($id == 3) {
        echo '	<!-- banner 3 -->
				<img src="'.Routes::$base.'app/design/images/woman_image_1.jpg" class="d_sm_none f_right m_bottom_10" alt="Reklam alanı" class="radius-5">';
    } elseif ($id == 5) {
        echo '	<!-- banner 5 -->
				<a href="javascript:void(0);" class="widget animate_ftr d_block r_corners m_bottom_30 d_xs_none">
					<img src="'.Routes::$base.'app/design/images/banner_img_6.jpg" alt="Süpriz Hediyeler" class="radius-5">
				</a>
				<a href="javascript:void(0);" class="widget animate_ftr d_block r_corners m_bottom_30 d_xs_none">
					<img src="'.Routes::$base.'app/design/images/banner_img_9.jpg" alt="Tüm ürünler orijinal" class="radius-5">
				</a>
				<a href="javascript:void(0);" class="widget animate_ftr d_block r_corners m_bottom_30 d_xs_none">
					<img src="'.Routes::$base.'app/design/images/banner_img_10.jpg" alt="Kapıda ödeme imkanı" class="radius-5">
				</a>';
    } elseif ($id == 6) {
        echo '	<div class="row clearfix m_bottom_45 d_xs_none">
					<div class="col-lg-6 col-md-6 col-sm-6">
						<a href="javascript:void(0);" class="d_block animate_ftb h_md_auto m_xs_bottom_15 banner_type_2 r_corners red t_align_c tt_uppercase vc_child n_sm_vc_child">
							<span class="d_inline_middle">
								<img class="d_inline_middle m_md_bottom_5" src="'.Routes::$base.'app/design/images/banner_img_3.png" alt="Müşteri memnuniyeti" class="radius-5">
								<span class="d_inline_middle m_left_10 t_align_l d_md_block t_md_align_c">
									<b>100% MÜŞTERİ</b><br><span class="color_dark">MEMNUNİYETİ</span>
								</span>
							</span>
						</a>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6">
						<a href="javascript:void(0);" class="d_block animate_ftb h_md_auto m_xs_bottom_15 banner_type_2 r_corners green t_align_c tt_uppercase vc_child n_sm_vc_child">
							<span class="d_inline_middle">
								<img class="d_inline_middle m_md_bottom_5" src="'.Routes::$base.'app/design/images/banner_img_4.png" alt="Ücretsiz kargo" class="radius-5">
								<span class="d_inline_middle m_left_10 t_align_l d_md_block t_md_align_c">
									<b>TÜM<br class="d_none d_sm_block"> ÜRÜNLERDE</b><br><span class="color_dark">ÜCRETSİZ KARGO</span>
								</span>
							</span>
						</a>
					</div>
				</div>';
    } elseif ($id == 8) {
        echo '	<div class="col-lg-6 col-md-6 col-sm-6 m_bottom_50 m_sm_bottom_35">
					<a href="'.Routes::$base.'products/new" class="d_block banner animate_ftr wrapper r_corners relative m_xs_bottom_30">
						<img src="'.Routes::$base.'app/design/images/banner_img_1.png" alt="Yeni ürünler" class="radius-5">
						<span class="banner_caption d_block vc_child t_align_c w_sm_auto">
							<span class="d_inline_middle">
								<span class="d_block color_dark tt_uppercase m_bottom_5 let_s">YENİ ÜRÜNLER!</span>
								<span class="d_block scheme_color tt_uppercase m_bottom_25 m_xs_bottom_10 banner_title"><b>ŞOK FİYATLAR</b></span>
								<span class="button_type_6 bg_scheme_color tt_uppercase r_corners color_light d_inline_b tr_all_hover box_s_none f_size_ex_large">YENİ ÜRÜNLERE GÖZAT</span>
							</span>
						</span>
					</a>
				</div>';
    } elseif ($id == 9) {
        echo '	<div class="col-lg-6 col-md-6 col-sm-6 m_bottom_50 m_sm_bottom_35">
					<a href="'.Routes::$base.'manufacturer/3/Armani" class="d_block banner animate_ftr wrapper r_corners type_2 relative">
						<img src="'.Routes::$base.'app/design/images/banner_img_2.png" alt="Burberry Classic 140 TL" class="radius-5">
						<span class="banner_caption d_block vc_child t_align_c w_sm_auto">
							<span class="d_inline_middle">
								<span class="d_block scheme_color banner_title type_3 m_bottom_5 m_mxs_bottom_5"><b>140 TL</b></span>
								<span class="d_block color_light tt_uppercase m_bottom_15 banner_title_3 m_md_bottom_5">AÇILIŞA ÖZEL<br><b>BURBERRY CLASSIC</b></span>
								<!--
								<span class="button_type_6 bg_dark_color tt_uppercase r_corners color_light d_inline_b tr_all_hover box_s_none f_size_ex_large">HEMEN AL</span>
								-->
							</span>
						</span>
					</a>
				</div>';
    }
}

function echo_cart_header()
{
    $p = new Product();

    if (!isset($_SESSION['cart']['count'])) {
        echo '	<a role="button" href="javascript:void(0);" class="button_type_3 color_light bg_scheme_color d_block r_corners tr_delay_hover box_s_none">
					<span class="d_inline_middle shop_icon">
						<i class="fa fa-shopping-cart"></i>
						<span id="i_cart" class="count tr_delay_hover type_2 circle t_align_c">0</span>
					</span>
					<b>0 TL</b>
				</a>';
    } else {
        $_SESSION['cart']['total'] = $_SESSION['cart']['price_with_tax'] + $_SESSION['cart']['price_extra'] - $_SESSION['cart']['price_sale'];

        echo '	<a role="button" href="javascript:void(0);" class="button_type_3 color_light bg_scheme_color d_block r_corners tr_delay_hover box_s_none">
					<span class="d_inline_middle shop_icon">
						<i class="fa fa-shopping-cart"></i>
						<span id="i_cart" class="count tr_delay_hover type_2 circle t_align_c">'.$_SESSION['cart']['count'].'</span>
					</span>
					<b>'.$_SESSION['cart']['total'].' TL</b>
				</a>
				<div class="shopping_cart top_arrow tr_all_hover r_corners">
					<div class="f_size_medium sc_header">Sepetinizde '.count($_SESSION['cart']['products']).' farklı toplam '.$_SESSION['cart']['count'].' ürün bulunmaktadır.</div>
					<ul class="products_list">';
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart']['products'] as $cart_product) {
                $p->product_id = $cart_product;
                $cart_p = $p->product();

                echo '	<li>
										<div class="clearfix">
											<!--product image-->
											<img class="f_left m_right_10" src="'.$cart_p['general']['img_t'].'" alt="'.$cart_p['name'].'">
											<!--product description-->
											<div class="f_left product_description">
												<a href="'.Routes::$base.'product/'.$cart_p['general']['product_id'].'/'.$cart_p['name'].'" class="color_dark m_bottom_5 d_block">'.$cart_p['name'].'</a>
												<span class="f_size_medium">Ürün kodu: '.$cart_p['general']['product_code'].'</span>
											</div>
											<!--product price-->
											<div class="f_left f_size_medium">
												<div class="clearfix">
													'.$_SESSION['cart']['amount'][$cart_p['general']['product_id']].' x <b class="color_dark">'.$cart_p['general']['product_price_with_tax'].' TL</b>
												</div>
												<button class="close_product color_dark tr_hover" onClick="cart_del('.$cart_p['general']['product_id'].', 1)"><i class="fa fa-times"></i></button>
											</div>
										</div>
									</li>';
            }
        }

        echo '	</ul>
					<ul class="total_price bg_light_color_1 t_align_r color_dark">
						<li class="m_bottom_10">KDV: <span class="f_size_large sc_price t_align_l d_inline_b m_left_15">'.$_SESSION['cart']['price_tax'].' TL</span></li>
						<li class="m_bottom_10">İndirim: <span class="f_size_large sc_price t_align_l d_inline_b m_left_15">'.$_SESSION['cart']['price_sale'].' TL</span></li>
						<li class="m_bottom_10">Ekstra: <span class="f_size_large sc_price t_align_l d_inline_b m_left_15">'.$_SESSION['cart']['price_extra'].' TL</span></li>
						<li>Toplam (KDV Dahil): <b class="f_size_large bold scheme_color sc_price t_align_l d_inline_b m_left_15">'.$_SESSION['cart']['total'].' TL</b></li>
					</ul>
					<div class="sc_footer t_align_c">
						<a href="'.Routes::$base.'checkorder" role="button" class="button_type_4 d_inline_middle bg_light_color_2 r_corners color_dark t_align_c tr_all_hover m_mxs_bottom_5">Önceki Siparişlerim</a>
						<a href="'.Routes::$base.'checkout" role="button" class="button_type_4 bg_scheme_color d_inline_middle r_corners tr_all_hover color_light">Ödeme Yap</a>
					</div>
				</div>';
    }
}
function echo_cart_table($cart, $update = true)
{
    $ecommerce = new Product();

    if ($_SESSION['cart']['count'] == 0) {
        ?>
		<h3>Sepetinizde hiç ürün bulunmuyor. </h3>
		<p class="m_bottom_45">Alışverişinizi yapmak için lütfen menüde bulunan kategorilerden istediğiniz bölüme gidin, ürünleri sepetinize ekleyin ve ödeme yaparak siparişinizi tamamlayın. </p>
		<h3>Alışverişe burdan başlamaya ne dersiniz?</h3>
		<p class="m_bottom_20">Sizin için seçtiğimiz fırsatlara gözatın, uygun fiyatlara istediğiniz ürünü kaçırmayın.</p>
		<?php
        banners(8);
        banners(9);
    } else {
        $_SESSION['cart']['total'] = $_SESSION['cart']['price_with_tax'] + $_SESSION['cart']['price_extra'] - $_SESSION['cart']['price_sale'];

        echo '	<table class="table_type_4 responsive_table full_width r_corners wraper shadow t_align_l t_xs_align_c m_bottom_30">
					<thead>
						<tr class="f_size_large">
							<!--titles for td-->
							<th>Ürün resmi & ismi</th>
							<th>Kod</th>
							<th>Fiyat</th>
							<th>Miktar</th>
							<th>Toplam</th>
						</tr>
					</thead>
					<tbody>';

        foreach ($cart['products'] as $cart_product) {
            $ecommerce->product_id = $cart_product;
            $cart_p = $ecommerce->product();
            ?>
						<tr id="table-product-<?php echo $cart_p['general']['product_id'];
            ?>">
							<!--Product name and image-->
							<td data-title="Product Image &amp; Name" class="t_md_align_c">
								<img src="<?php echo $cart_p['general']['img_t'];
            ?>" alt="<?php echo $cart_p['name'];
            ?>" class="m_md_bottom_5 d_xs_block d_xs_centered width_80">
								<a href="<?php echo Routes::$base.'product/'.$cart_p['general']['product_id'].'/'.$cart_p['name'];
            ?>" class="d_inline_b m_left_5 color_dark product_name"><?php echo $cart_p['name'];
            ?></a>
							</td>
							<!--product key-->
							<td data-title="SKU"><?php echo $cart_p['general']['product_id'];
            ?></td>
							<!--product price-->
							<td data-title="Price">
								<?php
                                    if (isset($cart_p['general']['product_price_old_with_tax'])) {
                                        echo '<s>'.@$cart_p['general']['product_price_old_with_tax'].' TL</s>';
                                    }
            ?>
								<p class="f_size_large color_dark"><?php echo $cart_p['general']['product_price_with_tax'];
            ?> TL</p>
							</td>
							<!--quanity-->
							<td data-title="Quantity">
								<?php if ($update) {
    ?>
								<div class="clearfix quantity r_corners d_inline_middle f_size_medium color_dark m_bottom_10">
									<button class="bg_tr d_block f_left" data-direction="down" data-product="<?php echo $cart_p['general']['product_id'];
    ?>">-</button>
									<input type="text" name="" readonly value="<?php echo $cart['amount'][$cart_p['general']['product_id']];
    ?>" class="f_left" id="product-<?php echo $cart_p['general']['product_id'];
    ?>-amount">
									<button class="bg_tr d_block f_left" data-direction="up" data-product="<?php echo $cart_p['general']['product_id'];
    ?>">+</button>
								</div>
								<div>
									<!--
									<a href="javascript:void(0);" class="color_dark" onClick="cart_add(<?php echo $cart_p['general']['product_id'];
    ?>, 1)"><i class="fa fa-check f_size_medium m_right_5"></i>Güncelle</a><br>
									-->
									<a href="javascript:void(0);" class="color_dark" onClick="cart_del(<?php echo $cart_p['general']['product_id'];
    ?>, 1)"><i class="fa fa-times f_size_medium m_right_5"></i>Kaldır</a><br>
								</div>
								<?php 
} else {
    ?>
									<?php echo $cart['amount'][$cart_p['general']['product_id']];
    ?>
								<?php 
}
            ?>
							</td>
							<!--subtotal-->
							<td data-title="Subtotal">
								<p class="f_size_large fw_medium scheme_color"><?php echo $cart['amount'][$cart_p['general']['product_id']] * $cart_p['general']['product_price_with_tax'];
            ?> TL</p>
							</td>
						</tr>
					<?php 
        }
        ?>
					<!--prices-->
					<tr>
						<td colspan="4">
							<p class="fw_medium f_size_large t_align_r t_xs_align_c">KDV:</p>
						</td>
						<td colspan="1">
							<p class="fw_medium f_size_large color_dark"><?php echo $cart['price_tax'];
        ?> TL</p>
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<p class="fw_medium f_size_large t_align_r t_xs_align_c">İndirim:</p>
						</td>
						<td colspan="1">
							<p class="fw_medium f_size_large color_dark"><?php echo $cart['price_sale'];
        ?> TL</p>
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<p class="fw_medium f_size_large t_align_r t_xs_align_c">Ekstra:</p>
						</td>
						<td colspan="1">
							<p class="fw_medium f_size_large color_dark"><?php echo $cart['price_extra'];
        ?> TL</p>
						</td>
					</tr>
					<!--total-->
					<tr>
						<td class="v_align_m d_ib_offset_large t_xs_align_l" colspan="4">
							<form class="d_ib_offset_0 d_inline_middle d_xs_block w_xs_full m_xs_bottom_5">
								<?php if (isset($_SESSION['cart']['coupon_code'])) {
    ?>
								<input class="r_corners f_size_medium" type="text" name="" placeholder="İndirim kodu girin" value="<?php echo $_SESSION['cart']['coupon_code'];
    ?>" id="coupon-code">
								<?php 
} else {
    ?>
								<input class="r_corners f_size_medium" type="text" name="" placeholder="İndirim kodu girin" id="coupon-code">
								<?php 
}
        ?>
								<button class="button_type_4 r_corners bg_light_color_2 m_left_5 mw_0 tr_all_hover color_dark" id="coupon">Uygula</button>
							</form>
							<p class="fw_medium f_size_large t_align_r scheme_color p_xs_hr_0 d_inline_middle half_column d_ib_offset_normal d_xs_block w_xs_full t_xs_align_c" style="width:55%;">Toplam (KDV Dahil):</p>
						</td>
						<td class="v_align_m" colspan="1">
							<p class="fw_medium f_size_large scheme_color m_xs_bottom_10"><?php echo $_SESSION['cart']['total'];
        ?> TL</p>
						</td>
					</tr>
				</tbody>
			</table>
<?php

    }
}
function echo_order_table($cart, $update = true)
{
    $ecommerce = new Product();

    echo '	<table class="table_type_4 responsive_table full_width r_corners wraper shadow t_align_l t_xs_align_c m_bottom_30">
				<thead>
					<tr class="f_size_large">
						<!--titles for td-->
						<th>Ürün resmi & ismi</th>
						<th>Kod</th>
						<th>Fiyat</th>
						<th>Miktar</th>
						<th>Toplam</th>
					</tr>
				</thead>
				<tbody>';

    foreach ($cart['products'] as $cart_product) {
        $ecommerce->product_id = $cart_product;
        $cart_p = $ecommerce->product();

        ?>
					<tr id="table-product-<?php echo $cart_p['general']['product_id'];
        ?>">
						<!--Product name and image-->
						<td data-title="Product Image &amp; Name" class="t_md_align_c">
							<img src="<?php echo $cart_p['general']['img_t'];
        ?>" alt="<?php echo $cart_p['name'];
        ?>" class="m_md_bottom_5 d_xs_block d_xs_centered width_80">
							<a href="<?php echo Routes::$base.'product/'.$cart_p['general']['product_id'].'/'.$cart_p['name'];
        ?>" class="d_inline_b m_left_5 color_dark product_name"><?php echo $cart_p['name'];
        ?></a>
						</td>
						<!--product key-->
						<td data-title="SKU"><?php echo $cart_p['general']['product_code'];
        ?></td>
						<!--product price-->
						<td data-title="Price">
							<?php
                                if (isset($cart_p['general']['product_price_old_with_tax'])) {
                                    echo '<s>'.@$cart_p['general']['product_price_old_with_tax'].' TL</s>';
                                }
        ?>
							<p class="f_size_large color_dark"><?php echo $cart_p['general']['product_price_with_tax'];
        ?> TL</p>
						</td>
						<!--quanity-->
						<td data-title="Quantity">
							<?php if ($update) {
    ?>
							<div class="clearfix quantity r_corners d_inline_middle f_size_medium color_dark m_bottom_10">
								<button class="bg_tr d_block f_left" data-direction="down" data-product="<?php echo $cart_p['general']['product_id'];
    ?>">-</button>
								<input type="text" name="" readonly value="<?php echo $cart['amount'][$cart_p['general']['product_id']];
    ?>" class="f_left" id="product-<?php echo $cart_p['general']['product_id'];
    ?>-amount">
								<button class="bg_tr d_block f_left" data-direction="up" data-product="<?php echo $cart_p['general']['product_id'];
    ?>">+</button>
							</div>
							<div>
								<!--
								<a href="javascript:void(0);" class="color_dark" onClick="cart_add(<?php echo $cart_p['general']['product_id'];
    ?>, 1)"><i class="fa fa-check f_size_medium m_right_5"></i>Güncelle</a><br>
								-->
								<a href="javascript:void(0);" class="color_dark" onClick="cart_del(<?php echo $cart_p['general']['product_id'];
    ?>, 1)"><i class="fa fa-times f_size_medium m_right_5"></i>Kaldır</a><br>
							</div>
							<?php 
} else {
    ?>
								<?php echo $cart['amount'][$cart_p['general']['product_id']];
    ?>
							<?php 
}
        ?>
						</td>
						<!--subtotal-->
						<td data-title="Subtotal">
							<p class="f_size_large fw_medium scheme_color"><?php echo $cart['amount'][$cart_p['general']['product_id']] * $cart_p['general']['product_price_with_tax'];
        ?> TL</p>
						</td>
					</tr>
				<?php 
    }
    ?>
				<!--prices-->
				<tr>
					<td colspan="4">
						<p class="fw_medium f_size_large t_align_r t_xs_align_c">KDV:</p>
					</td>
					<td colspan="1">
						<p class="fw_medium f_size_large color_dark"><?php echo $cart['price_tax'];
    ?> TL</p>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<p class="fw_medium f_size_large t_align_r t_xs_align_c">İndirim:</p>
					</td>
					<td colspan="1">
						<p class="fw_medium f_size_large color_dark"><?php echo $cart['price_sale'];
    ?> TL</p>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<p class="fw_medium f_size_large t_align_r t_xs_align_c">Ekstra:</p>
					</td>
					<td colspan="1">
						<p class="fw_medium f_size_large color_dark"><?php echo $cart['price_extra'];
    ?> TL</p>
					</td>
				</tr>
				<!--total-->
				<tr>
					<td colspan="4" class="v_align_m d_ib_offset_large t_xs_align_l">
						<!--coupon
						<form class="d_ib_offset_0 d_inline_middle half_column d_xs_block w_xs_full m_xs_bottom_5">
							<input type="text" placeholder="Enter your coupon code" name="" class="r_corners f_size_medium">
							<button class="button_type_4 r_corners bg_light_color_2 m_left_5 mw_0 tr_all_hover color_dark">Save</button>
						</form>
						-->
						<p class="fw_medium f_size_large t_align_r t_xs_align_c scheme_color">Toplam (KDV Dahil):</p>
					</td>
					<td colspan="1" class="v_align_m">
						<p class="fw_medium f_size_large scheme_color m_xs_bottom_10"><?php echo $cart['total'];
    ?> TL</p>
					</td>
				</tr>
			</tbody>
		</table>
	<?php

}
function echo_cart_payment($payment_id)
{
    $pay = new Payment();
    $pay->row_price = true;
    $pay->payment_id = $payment_id;

    // Free payment for online documents
    if ($payment_id == 1) {
    }
    // Pay at door
    elseif ($payment_id == 2) {
        echo '	<h3 class="m_bottom_5">Ödeme sistemi olarak "'.$pay->payment_name().'" sistemini seçtiniz.</h3>
				<button class="button_type_6 bg_scheme_color f_size_large r_corners tr_all_hover color_light m_bottom_20" type="submit" name="checkout" value="atdoor">Alışverişi Tamamla</button>

				<p><small>Bu sistem ile sadece '.$pay->payment_price().' TL daha fazla ödeyerek, siparişinizin ödemesini kargodan alırken yapabilirsiniz.</small></p>';
    }
    // Paypal
    elseif ($payment_id == 3) {
        echo '	<h3 class="m_bottom_5">Ödeme sistemi olarak "'.$pay->payment_name().'" sistemini seçtiniz.</h3>
			   	<button class="button_type_6 bg_scheme_color f_size_large r_corners tr_all_hover color_light m_bottom_20" type="submit" name="checkout" value="paypal">Sipariş Kaydımı Oluştur ve Ödeme Sayfasına Git</button>';
    }
    // EFT
    elseif ($payment_id == 7) {
        echo '	<h3 class="m_bottom_5">Ödeme sistemi olarak "'.$pay->payment_name().'" sistemini seçtiniz.</h3>
				<p><strong>Havale/EFT yapılacak kişi:</strong> Onur DEMİRER</p>
				<p class="m_bottom_20"><strong>IBAN:</strong> TR94 0006 2000 0800 0006 6680 58</p>

				<button class="button_type_6 bg_scheme_color f_size_large r_corners tr_all_hover color_light m_bottom_20" type="submit" name="checkout">Alışverişi Tamamla</button>

				<p><small>Bu ödeme seçeneğini kullanarak ilgili siparişinizi ödemek için banka bilgilerini hiçkimseyle paylaşmadan ödemenizi tamamlayabilirsiniz.</small></p>';
    }
    // Credit card
    elseif ($payment_id == 8) {
        echo '	<h3 class="m_bottom_20">Ödeme sistemi olarak "'.$pay->payment_name().'" sistemini seçtiniz.</h3>
				<button class="button_type_6 bg_scheme_color f_size_large r_corners tr_all_hover color_light m_bottom_20" type="submit" name="checkout" value="credit">Sipariş Kaydımı Oluştur ve Ödeme Sayfasına Git</button>';
        /*
        echo '	<ul>
                    <li class="m_bottom_15">
                        <label class="d_inline_b m_bottom_5">Kart sahibinin adı</label>
                        <input class="r_corners full_width" type="text" name="credit_username">
                    </li>
                    <li class="m_bottom_15">
                        <label class="d_inline_b m_bottom_5">Kart numarası</label>
                        <input class="r_corners full_width credit-number-mask" type="text" name="credit_username">
                    </li>
                    <li class="m_bottom_15">
                        <label class="d_inline_b m_bottom_5">Son kullanma tarihi</label>
                        <input class="r_corners full_width credit-date-mask" type="text" name="credit_username">
                    </li>
                    <li class="m_bottom_15">
                        <label class="d_inline_b m_bottom_5">CVS numarası</label>
                        <input class="r_corners full_width credit-cvs-mask" type="text" name="credit_username">
                    </li>
                </ul>';
        */
    }
}
