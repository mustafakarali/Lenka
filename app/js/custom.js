/*
 * gnc içinde çalışan ajax istekleri, php tetikleyicileri ajax.php'nin içinde bulunmaktadır.
 * 
 * Ajax istekleri çalıştırılırken sadece fonksiyon içeriği çalıştırılır daha önce veya daha sonra sayfa yüklemesi 
 * yapılmamaktadır. Zaten ajax'ın olayı da budur. Ayrıca kullanılan tüm js kodları tek bir js dosyasında bulunmalıdır.
 * 
 * Ajax isteklerinin url kısmına    ajax_cms+"fonskiyon_adi"    yazılmalıdır. 
 * Bu sayede sistem/ajax.php içindeki fonksiyonlar ajax ile çalıştırılabilir.
 */


/* Sayfayı yenileyen fonksiyon */
function refresh(){
	location.reload();
}
/* İlgili id değerini temizler */
function clean(id){
	$('#'+id).val('');
}
function cart_add(id, refresh, shipping, pay){
	
	count = $('#product-'+id+'-amount').val();

	var data = {
		id: id,
		count: count,
		shipping: shipping,
		pay: pay
	}	
	
	if (!$('#loading-cart').is(':visible'))
		$('#loading-cart').fadeIn();
		
	$.ajax({
		url: ajax_app+'cart_add',    
		type: "POST",       
		data: data,   
		cache: false,
		success: function (response) {
			$('#shopping_button').html(response);
			$('#loading-cart').fadeOut();		
			
			if (refresh == 1)
			{
				$.ajax({
					url: ajax_app+'cart_table',    
					type: "POST",       
					data: data,   
					cache: false,
					success: function (response) {
						$('#table_cart').html(response);
						
						$('.quantity').on('click','button',function(){
							var data = $(this).data('direction'),
								i = $(this).parent().children('input[type="text"]'),
								val = i.val();
							if(data == "up"){
								val++;
								i.val(val);
								cart_add($(this).data('product'), 1);
							}else if(data == "down"){
								if(val == 1) return;
								val--;
								i.val(val);
								cart_add($(this).data('product'), 1);
							}
						});
					}
				});	
			}
		}
	});	
			
	return false;	
}
function cart_del(id, refresh){
	var data = {
		id: id
	}	
	
	if (!$('#loading-cart').is(':visible'))
		$('#loading-cart').fadeIn();
		
	$.ajax({
		url: ajax_app+'cart_del',    
		type: "POST",       
		data: data,   
		cache: false,
		success: function (response) {
			$('#shopping_button').html(response);
			$('#loading-cart').fadeOut();	
			
			if (refresh == 1)
			{
				$.ajax({
					url: ajax_app+'cart_table',    
					type: "POST",       
					data: data,   
					cache: false,
					success: function (response) {
						$('#table_cart').html(response);
						
						$('.quantity').on('click','button',function(){
							var data = $(this).data('direction'),
								i = $(this).parent().children('input[type="text"]'),
								val = i.val();
							if(data == "up"){
								val++;
								i.val(val);
								cart_add($(this).data('product'), 1);
							}else if(data == "down"){
								if(val == 1) return;
								val--;
								i.val(val);
								cart_add($(this).data('product'), 1);
							}
						});
					}
				});	
			}
		}
	});			
	return false;	
}
$('#coupon').live('click', function(){

	coupon = $('#coupon-code').val();

	var data = {
		coupon: coupon
	}	
	
	if (!$('#loading-cart').is(':visible'))
		$('#loading-cart').fadeIn();
		
	$.ajax({
		url: ajax_app+'cart_coupon',    
		type: "POST",       
		data: data,   
		cache: false,
		success: function (response) {
			refresh();
		}
	});			
	return false;
})
$('#invoice').validationEngine();

$(".tc-mask").mask("99999999999");
$(".phone-mask").mask("0(999)999-99-99");
$(".credit-number-mask").mask("9999-9999-9999-9999");
$(".credit-date-mask").mask("99/99");
$(".credit-cvv-mask").mask("999");
$(".credit-dd-mask").mask("99");
$(".credit-dddd-mask").mask("2099");

$(".phone-mask").on("blur", function() {
    var last = $(this).val().substr( $(this).val().indexOf("-") + 1 );

    if( last.length == 3 ) {
        var move = $(this).val().substr( $(this).val().indexOf("-") - 1, 1 );
        var lastfour = move + last;
        var first = $(this).val().substr( 0, 9 );

        $(this).val( first + '-' + lastfour );
    }
});

$('#checkbox_9').live('change', function(){
	if ($(this).is(':checked')){
		$('#c_name_2').val($('#c_name_1').val());
		$('#f_name_2').val($('#f_name_1').val());
		$('#address_2').val($('#address_1').val());
		$('#code_2').val($('#code_1').val());
		$('#city_2').val($('#city_1').val());
		$('#phone_2').val($('#phone_1').val());
		$('#m_phone_2').val($('#m_phone_1').val());
		$('#fax_2').val($('#fax_1').val());
		$('#email_2').val($('#email_1').val());
	}
});


$('figure.shipping-select').live('click', function() {
	type = $(this).data('shipping');
	
	var data = {
		type: type
	}	
	
	if (!$('#loading-cart').is(':visible'))
		$('#loading-cart').fadeIn();
	
	$.ajax({
		url: ajax_app+'cart_shipping',    
		type: "POST",       
		data: data,   
		cache: false,
		success: function (response) {
			
			cart_add(0, 1, type, 0);
	
			$('#loading-cart').fadeOut();	
		}
	});			
	return false;	
});
$('figure.payment-select').live('click', function() {
	type = $(this).data('payment');
	
	var data = {
		type: type
	}	
	
	if (!$('#loading-cart').is(':visible'))
		$('#loading-cart').fadeIn();
	
	cart_add(0, 1, 0, type);
		
	$.ajax({
		url: ajax_app+'cart_payment',    
		type: "POST",       
		data: data,   
		cache: false,
		success: function (response) {
			$('#payment-done').html(response);
			
			$(".credit-number-mask").mask("9999-9999-9999-9999");
			$(".credit-date-mask").mask("99/99");
			$(".credit-cvs-mask").mask("999");
			
			$('#loading-cart').fadeOut();	
		}
	});			
	return false;	
});
$('#search-word').live('keyup', function(){
	
	string = $(this).val();
	
	var data = {
		string: string
	}  	
	
	if(string == '' || string.length < 3){
		$("#search-results").slideUp('fast'); 
	}
	else{  
		$.ajax({
  			type: "POST",
			url: ajax_app+'search',
			data: data,
			cache: false,
			success: function(response){
				$("#search-results").html(response).slideDown('fast');
			}
		});
	}
	return false;  
});