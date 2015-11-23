<!--breadcrumbs-->
<section class="breadcrumbs">
	<div class="container">
		<ul class="horizontal_list clearfix bc_list f_size_medium">
			<li class="m_right_10 current"><a href="<?php echo Routes::$base; ?>" class="default_t_color">Anasayfa<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
			<li><a href="<?php echo Routes::$base . Routes::$module;?>" class="default_t_color">Sipariş Kontrolü</a></li>
		</ul>
	</div>
</section>
<!--content-->
<div class="page_content_offset">
	<div class="container">
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 m_bottom_45">
				<?php 
				if (isset($order_id))
				{
					echo '	<div class="row clearfix">
								<div class="col-lg-12 col-md-12 col-sm-12 m_bottom_40 m_xs_bottom_10">
									<div class="alert_box r_corners color_green success m_bottom_10">
										<i class="fa fa-smile-o"></i>
										<p>Başarılı! Siparişiniz tarafımıza ulaşmış olup en kısa sürede ürününüz tarafınıza ulaştırılacaktır.</p>
										<h2>Sipariş takip numaranız: '.$order_id.'</h2>
										<p>Bu numarayla siparişinizin durumunu takip edebilir, siparişiniz hakkındaki sorularınızı tarafımıza iletebilirsiniz.</p>
									</div>
								</div>
							</div>';
				}
				/* unset cookie order 
				setcookie('order', '', time() + (86400 * 90), "/"); // 86400 * 90 = 90 day
				unset($_COOKIE);
				*/
				if (isset($_COOKIE['order']))
				{
					$orders = array_reverse(unserialize($_COOKIE['order']));
				?>
					
				<div class="col-lg-12 col-md-12 col-sm-12 m_bottom_20">	
					<div class="col-lg-6 col-md-6 col-sm-6">
						<h2 class="tt_uppercase color_dark m_bottom_25">TÜM SİPARİŞLERİNİZ</h2>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6">
						<form class="relative type_2" role="search" method="post">
							<input type="text" placeholder="Sipariş numarasını biliyorsanız, buraya yazarak arama yapabilirsiniz." name="search" class="r_corners f_size_medium full_width">
							<button class="f_right search_button tr_all_hover f_xs_none">
								<i class="fa fa-search"></i>
							</button>
						</form>
					</div>
				</div>
				
				<?php if (isset($_REQUEST['search'])) { ?>
				<div class="col-lg-12 col-md-12 col-sm-12 m_bottom_45">
					<?php if ($c->is_order((int)security($_REQUEST['search']))) { ?>
						<h3>Sipariş numarası <strong><?php echo $_REQUEST['search']; ?></strong> olan alışverişin detaylarını görüyorsunuz.</h3>
						<p>Kargo takip numaranız: <strong><?php $c->order_display_cargo_details((int)security($_REQUEST['search'])); ?></strong></p>
						<?php $c->order_display((int)security($_REQUEST['search'])); ?>
					<?php } else { ?>
						<h3><strong><?php echo $_REQUEST['search']; ?></strong> numaralı hiçbir sipariş kaydı bulamadık, üzgünüz. Lütfen sipariş numarasını kontrol edin yada <a href="tel:<?php echo $setting['contact_tel1'];?>"><?php echo $setting['contact_tel1'];?></a> numaralı müşteri hizmetlerimizi arayarak bilgi alın.</h3>
					<?php } ?>
				</div>	
				<?php } ?>
				
				<div class="tabs vertical clearfix">
					<!--tabs navigation-->
					<nav>
						<ul class="tabs_nav clearfix f_left">
							<?php 
							$i = count($orders);
							
							foreach ($orders AS $order)
							{
								 
								echo '	<li class="m_bottom_5"><a href="#tab-'.$i.'" class="bg_light_color_1 shadow color_dark tr_delay_hover d_block">'.$i.'. Siparişiniz </br>('. $c->order_date($order) .')</a></li>';
								$i--;
							} 
							?>
						</ul>
					</nav>
					<!--tabs content-->
					<section class="tabs_content shadow r_corners f_left">
						<?php 
						$i = count($orders);
						foreach ($orders AS $order)
						{
							
							$o = $c->order($order);
							$status_name = select('status')->where('lang_id = '.$_SESSION['lang_id'].' AND status_id = '.$o['order_status'])->limit(1)->result('status_name');
							
							echo '	<div id="tab-'.$i.'">
										<h3>Sipariş numarası <strong>'.$order.'</strong> olan alışverişinizin detaylarını görüyorsunuz.</h3>
										<p class="m_bottom_5">Güvenlik sebebiyle kişisel bilgilerinizi, kredi kartı bilgilerinizi, fatura ve teslimat bilgilerinizi paylaşamıyoruz. </p>
										<p class="m_bottom_5">Siparişiniz şuan <strong>"'. $status_name .'"</strong> durumundadır.</p>
										<p class="m_bottom_5">Kargo detayları: <strong>"'; $c->order_display_cargo_details($order); echo '"</strong></p>
										<p class="m_bottom_20">Detaylı bilgi almak için <a href="tel:'.$setting['contact_tel1'].'">'.$setting['contact_tel1'].'</a> numaralı telefonu sipariş kaydı yaptığınız numaradan arayabilirsiniz.</p>';
										$c->order_display($order);
							echo '	</div>';
							
							$i--;
						} 
						?>
					</section>
				</div>
				<?php } else { ?>
				<h3>Haydi alışverişe...</h3>
				<p class="m_bottom_20">Sizin için seçtiğimiz fırsatlara gözatın, uygun fiyatlara istediğiniz ürünü kaçırmayın.</p>
				<?php
				banners(8);
				banners(9);
				} ?>
			</div>
		</div>
	</div>
</div>
