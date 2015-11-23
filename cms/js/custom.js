/*
 * Custom js codes including ajax requests
 * 
 * You can run functions which are pre-defined in ./cms/ajax.php file by calling as ajax_cms+"function_name"  
 */


/* Refresh the page */
function refresh(){
	location.reload();
}
/* Clean the element with id */
function clean(id){
	$('#'+id).val('');
}

$(function() {
	/* E-Commerce Menu */
	$('#menu_ecommerce').on('click', function(){
		$(this).toggleClass('active');
		$('#menu_ecommerce_details').toggleClass('active');
	});
	/*
	$('#menu_ecommerce').on('mouseenter', function(){
		$('#menu_ecommerce_details').show();
	})
	$('#menu_ecommerce_details').on('mouseleave', function(){
		$('#menu_ecommerce_details').hide();	
	})
	*/
	/* Datatable localization
	 * 
	 */
	oTable = $('.dinamik_tablo').dataTable({
		"bJQueryUI": false,
		"bAutoWidth": false,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"fl>t<"F"ip>',
		"sSearch" : 'sadasda',
		"oLanguage": {
			"sSearch": sSearch,
            "sLengthMenu": sLengthMenu,
            "sZeroRecords": "Nothing found - sorry",
            "sInfo": sInfo,
            "sInfoEmpty": "Showing 0 to 0 of 0 records",
            "sInfoFiltered": "(filtered from _MAX_ total records)",
            "oPaginate": {
		    	"sFirst": sFirst,
		    	"sLast": sLast,
		    	"sNext": sNext,
		    	"sPrevious": sPrevious
	    	}
        },
	});
	
	// Profit amount to set selling price automatically
	$("#price_purchasing").live('keyup', function(){
		if ($(this).val() != '')
			$("#price").val($(this).val() * 1.35);
		else
			$("#price").val('');
	});
});
/* Set values for ecommerce */
function set_price_purchase(id){
	v = $('#price_purchasing_'+id).val();
	
	var data = {
		id: id,
		value: v,
		field: 'product_price_purchasing'
	}	
	
	$('#loading').fadeIn();
	$.ajax({
		url: ajax_cms+'product_change_fast',    
		type: "POST",       
		data: data,   
		cache: false,
		success: function (response) {
			$('#loading').fadeOut();
		}
	});	
	return false;	
}
function set_price(id){
	v = $('#price_selling_'+id).val();
	
	var data = {
		id: id,
		value: v,
		field: 'product_price'
	}	
	
	$('#loading').fadeIn();
	$.ajax({
		url: ajax_cms+'product_change_fast',    
		type: "POST",       
		data: data,   
		cache: false,
		success: function (response) {
			$('#loading').fadeOut();
		}
	});	
	return false;
}
function set_price_sale(id){
	v = $('#price_sale_'+id).val();
	
	var data = {
		id: id,
		value: v,
		field: 'sale_price'
	}	
	
	$('#loading').fadeIn();
	$.ajax({
		url: ajax_cms+'product_sale_price',    
		type: "POST",       
		data: data,   
		cache: false,
		success: function (response) {
			$('#loading').fadeOut();
		}
	});	
	return false;
}
function set_stock_code(id){
	v = $('#stock_code_'+id).val();
	
	var data = {
		id: id,
		value: v,
		field: 'product_code'
	}	
	
	$('#loading').fadeIn();
	$.ajax({
		url: ajax_cms+'product_change_fast',    
		type: "POST",       
		data: data,   
		cache: false,
		success: function (response) {
			$('#loading').fadeOut();
		}
	});	
	return false;
}
function set_stock(id){
	v = $('#stock_amount_'+id).val();
	
	var data = {
		id: id,
		value: v,
		field: 'product_stock_amount'
	}	
	
	$('#loading').fadeIn();
	$.ajax({
		url: ajax_cms+'product_change_fast',    
		type: "POST",       
		data: data,   
		cache: false,
		success: function (response) {
			$('#loading').fadeOut();
		}
	});	
	return false;
}
function set_storage(id){
	v = $('#stock_storage_'+id).val();
	
	var data = {
		id: id,
		value: v,
		field: 'product_storage'
	}	
	
	$('#loading').fadeIn();
	$.ajax({
		url: ajax_cms+'product_change_fast',    
		type: "POST",       
		data: data,   
		cache: false,
		success: function (response) {
			$('#loading').fadeOut();
		}
	});	
	return false;
}
/* Delete from database
 * 
 * It needs 3 paramaters;
 * table_name: table in the database 
 * data_id: unique id (in the first column of the table) of the row
 * element_id: id of dom element to hide
 * 
 * Example:
 * onClick="delete_from_database(\'contents\', '.$row['content_id'].', \'row\');"
 * 
 * PS: don't forget to escape ' with \
 */
function delete_from_database(table, key, elemanin_idsi){
	var data = {
		table: table,
		key: key
	}	
	
	$('#loading').fadeIn();
	$.ajax({
		url: ajax_cms+'delete_from_database',    
		type: "POST",       
		data: data,   
		cache: false,
		success: function (response) {
			if (elemanin_idsi == 'yenile')
				yenile();
			else
				$('#'+elemanin_idsi+'_'+key).slideUp();
				
			$('#loading').fadeOut();
		}
	});	
	return false;	
}
function delete_content_from_database(id){
	var data = {
		id: id
	}	
	
	$('#loading').fadeIn();
	$.ajax({
		url: ajax_cms+'delete_content_from_database',   
		type: "POST",       
		data: data,   
		cache: false,
		success: function () {
			$('#row_'+id).slideUp();
			$('#loading').fadeOut();
		}
	});	
	return false;		
}
/* Update any value from database with choosing col and row */
function update_value(table, col, row, val, refresh)
{
	var data = {
		table: table,
		col: col,
		row: row,
		val: val
	}	
	
	$('#loading').fadeIn();
	$.ajax({
		url: ajax_cms+'update_value_on_database',   
		type: "POST",       
		data: data,   
		cache: false,
		success: function () {
			$('#'+col+'_'+row).slideUp();
			$('#loading').fadeOut();
			
			if (refresh == 'refresh')
				location.reload();
		}
	});	
	return false;	
}
$(function() {	
	// Search
	$(".search-string").on("keyup", function ()
	{
		eleman = $(this);
		aranan = $(this).val();
		sonuc = $(this).attr('title');
		fonk = $(this).attr('rel');
		
		var veri = {
			aranan: aranan
		}  	
		if(aranan == ''){
    		$("."+sonuc).slideUp('fast'); 
		}
		else{  
    		$.ajax({
      			type: "POST",
  				url: ajax_cms+fonk,
  				data: veri,
				cache: false,
				success: function(response){
					$("."+sonuc).html(response).slideDown('fast');
					
					// Return possible href options
					$('.select').on("click", function (){
						$(eleman).val($(this).attr('rel'));
						$("."+sonuc).slideUp('fast');
					});
				}
			});
  		}
  		return false;    
	});
	
	
	
	/* Create new fields for newly created pattern 
	 * 
	 */
	var addDiv = $('#pattern_data');
	var i = $('#pattern_data p').size() + 1;
	// New fields
	$('.sablona_yeni_alan_ekle').live('click', function() {
		if( i < 10 ) {
			i++;
			alan_adi 		= $('.alan_adi').html();
			alan_aciklamasi = $('.sablon_alan_aciklama').attr('placeholder');
			yeni_alan_ekle 	= $('.sablona_yeni_alan_ekle').html();
			yeni_alan_sil  	= $('.sablona_yeni_alan_sil').html();
			$('<div class="formRow"><div class="grid2"><label>'+alan_adi+'</label></div><div class="grid2"><input type="text" name="pattern_keys[]" placeholder="'+alan_adi+'" /></div><div class="grid2"><div class=""><a class="sablona_yeni_alan_ekle buttonS bGreen first" title="" href="javascript:void(0)">'+yeni_alan_ekle+'</a>&nbsp<a class="sablona_yeni_alan_sil buttonS bRed first" title="" href="javascript:void(0)">'+yeni_alan_sil+'</a></div></div><div class="clear"></div></div>').appendTo(addDiv);
		}
		return false;
	});
	// Remove a field
	$('.sablona_yeni_alan_sil').live('click', function() {
		if( i > 1 ) {
			$(this).parents('.formRow').remove();
			i--;
		}
		return false;
	});	
	
	
	// Popup window
	$('#gnc_yonetim_yeni_popup').on("click",function () {	
		yuklenen_resim = $('#gnc_ckfinder_ile_dosya_yukle').val();
		popup_resmi_width = $('#popup_resmi_width').val();
		href = $('#popup_href').val();
		aciklama = $('#popup_aciklama').val();
		width = $('#popup_width').val();
		height = $('#popup_height').val();
		
		var veri = {
    		yuklenen_resim: yuklenen_resim,
    		popup_resmi_width: popup_resmi_width,
    		href: href,
    		aciklama: aciklama,
    		width: width,
    		height: height
    	}  
  		$('#loading').fadeIn();
		$.ajax({
			url: ajax_cms+"gnc_yonetim_popup_duzenle",
			type: "POST",       
			data: veri,   
			cache: false,
			success: function (response) {
				yenile();
			}
		});
	});
	
	
	
	/* Crop image with JCrop
	 * 
	 * For more info visit: http://deepliquid.com/content/Jcrop.html 
	 */
	$('#album_secimi').live("change",function () {
		$('.resim_kirpma_islemi').slideDown();
		
		crop = $('#album_secimi').val();
		crop_deger = crop.split("-");
				
		var crop_deger = crop.split("-");
		
		album_id = crop_deger[0];
		crop_x = crop_deger[1];
		crop_y = crop_deger[2];
		
     	$('#cropbox').Jcrop({
			onChange: showCoords,
			onSelect: showCoords,
			minSize: [ crop_x, crop_y ],
			maxSize: [ crop_x, crop_y ]
		});	
		
	});
	
	// Changes on order & order_product status
	$('#order_status').live('change',function(){
		order_id = $('#order_id').val();
		val = $(this).val();
		
		var data = {
			order_id: order_id,
			val: val
		}	
		
		$('#loading').fadeIn();
		$.ajax({
			url: ajax_cms+'change_status_of_order',   
			type: "POST",       
			data: data,   
			cache: false,
			success: function () {
				$('#loading').fadeOut();
			}
		});	
		return false;
	});
	
	$('.order_product_status_id').live('change',function(){
		order_id = $('#order_id').val();
		product_id = $(this).attr('id');
		val = $(this).val();
		
		var data = {
			order_id: order_id,
			product_id: product_id,
			val: val
		}	
		
		$('#loading').fadeIn();
		$.ajax({
			url: ajax_cms+'change_status_of_product_in_order',   
			type: "POST",       
			data: data,   
			cache: false,
			success: function () {
				$('#loading').fadeOut();
				refresh();
			}
		});	
		return false;
	});
});
function showCoords(c)
{
	$('#x').val(c.x);
	$('#y').val(c.y);
	$('#x2').val(c.x2);
	$('#y2').val(c.y2);
	$('#w').val(c.w);
	$('#h').val(c.h);
};
function resim_kirp(){
	crop = $('#cropbox').attr('src');
	x1 = $('#x').val();
	y1 = $('#y').val();
	x2 = $('#x2').val();
	y2 = $('#y2').val();
	w  = $('#w').val();
	h  = $('#h').val();
	
	album_degeri = $('#album_secimi').val();
	album_degerleri = album_degeri.split("-");
	album_id = album_degerleri[0];
	resim_aciklama = $('#gnc_yonetim_resim_aciklama').val();
	var veri = {
		album_id: album_id,
		crop: crop,
		x1: x1,
		y1: y1,
		x2: x2,
		y2: y2,
		w: w,
		h: h,
		resim_aciklama: resim_aciklama
	}  

	$.ajax({
		url: ajax_cms+"crop_image",
		type: "POST",       
		data: veri,   
		cache: false,
		success: function (response) {
			$('#sonuc').html(response);
		}
	});	
}
var price_i = 0;
function price_range_new(range, label, start, expire)
{
	var data = {
		price_i: price_i
	}	
	
	$('#loading').fadeIn();
	
	var addDiv = $('#price_ranges');
	
	$.ajax({
		url: ajax_cms+'price_range_new',    
		type: "POST",       
		data: data,   
		cache: false,
		success: function (response) {
			
			if (addDiv.is(':empty'))
				addDiv.html(addDiv.html() + response);
			else
				$(response).appendTo(addDiv);
			
			$('#loading').fadeOut();
			price_i++;
		}
	});	
	return false;	
}