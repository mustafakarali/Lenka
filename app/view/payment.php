<!--breadcrumbs-->
<section class="breadcrumbs">
	<div class="container">
		<ul class="horizontal_list clearfix bc_list f_size_medium">
			<li class="m_right_10 current"><a href="<?php echo Routes::$base; ?>" class="default_t_color">Anasayfa<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
			<li><a href="<?php echo Routes::$base . Routes::$module;?>" class="default_t_color">Ödeme Yapın</a></li>
		</ul>
	</div>
</section>
<!--content-->
<div class="page_content_offset">
	<div class="container">
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 m_bottom_45">
				<?php 
				if (isset($c->order_id))
				{
					echo '	<div class="row clearfix">
								<div class="col-lg-12 col-md-12 col-sm-12 m_bottom_40 m_xs_bottom_10">
									<div class="alert_box r_corners color_green success m_bottom_10">
										<i class="fa fa-smile-o"></i>
										<h2>Siparişiniz, ödemeyi gerçekleştirmeniz için hazır!</h2>
										<p>Sipariş takip numaranız: '.$c->order_id.'</p>
										<p>Bu numarayla siparişinizin durumunu takip edebilir, siparişiniz hakkındaki sorularınızı tarafımıza iletebilirsiniz.</p>
									</div>
								</div>
							</div>';

					//$c->payment_form();
					if (Routes::$get[1] == 'paypal')
					{
						$c->payment_paypal();
					}
					else 
					{
						if (is_numeric(Routes::$func))
						{
							$c->payment_creditcard_vakifbank();
						}
						else 
						{
							$response = $_POST["json"];
							$resultJson = json_decode($response, true);
							if (strstr($resultJson['response']['state'],"success"))
							{
							    echo 'S';
							} 
							else 
							{
								echo 'E';
							}	
						}
					}
					
				}
				else 
				{
					header('Location: '.Routes::$base);
				}
				?>
			</div>
		</div>
	</div>
</div>
