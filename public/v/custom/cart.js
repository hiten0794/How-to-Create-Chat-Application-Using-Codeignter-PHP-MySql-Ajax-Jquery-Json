 $(function(){ 

 		$(".addToCart").click('on',function(){

			var p_id = $(this).attr('id');

			 

   					$.ajax({
 					  dataType : "json",
   					  data : { p_id : p_id},
 					  headers: {  'Authkey': csrf},
   					  url: './add-to-cart',
 					  success:function(res)
 					  { 

						var str='';

						for(var i=0; i<JSON.stringify(res['items'].length);i++){

						str+='<div class="wd-item-list">';

							str+='<div class="media">';

								str+='<img class="d-flex mr-3" style="height:25px;width:30px;" src="'+res['items'][i]['imgUrl']+'">';

							  str+='<div class="media-body">';

								str+='<h6 class="mt-0 list-group-title">'+res['items'][i]['name']+'</h6>';

								 str+='<div class="rating">'; 

									str+='<a href="#"><i class="fa fa-star active-color" aria-hidden="true"></i></a>'; 

									str+='<a href="#"><i class="fa fa-star active-color" aria-hidden="true"></i></a>'; 

									str+='<a href="#"><i class="fa fa-star active-color" aria-hidden="true"></i></a>';

									str+='<a href="#"><i class="fa fa-star-o" aria-hidden="true"></i></a>';

									str+='<a href="#"><i class="fa fa-star-o" aria-hidden="true"></i></a>'; 

								str+='</div>';

								str+='<div class="cart-price">$'+res['items'][i]['price']+'</div>';

							  str+='</div>';

							str+='</div>';

						  str+='</div>';

						}

						  $('.totalItems').html(res.totalItems)

						  $('#cartItems').html(str);

 					  },

					  error: function (jqXHR, status, err) {

						  //alert("Network Error.");

 					  }

				

					});

					 

 		});

		

		$(".wishlisttrash").click('on',function(){

			var id = $(this).attr('id');

 			 

   					$.ajax({

					  dataType : "json",

  					  data : { id : id},

					  headers: {  'Authkey': csrf},

  					  url: './wishlist/removeItem',

					  success:function(res)

					  {
						  if(res.code == 400)
						{
							alert(res.error);
						}

 						  if(res.status==1){

						  	$('#trash'+id).remove();

						  }else{

							alert(res.message); 

							}

 					  },

					  error: function (jqXHR, status, err) {

						  alert("Network Error.");

 					  }

				

					});

					 

 		});

	
	
	
			$("#updateqty").submit('on',function(e){
					e.preventDefault();
    					$.ajax({
					  dataType : "json",
					  type : "post",
 					  data : $('#updateqty').serializeArray(),
					  headers: {  'Authkey': csrf},
  					  url: $('#updateqty').attr('action'),
					  success:function(res)
					 {
						 
						 if(res.code == 400)
						{
							alert(res.error);
						}
							
							
						 var str='';

						for(var i=0; i<JSON.stringify(res['items'].length);i++){

						str+='<div class="wd-item-list">';

							str+='<div class="media">';

								str+='<img class="d-flex mr-3" style="height:25px;width:30px;" src="'+res['items'][i]['imgUrl']+'">';

							  str+='<div class="media-body">';

								str+='<h6 class="mt-0 list-group-title">'+res['items'][i]['name']+'</h6>';

								 str+='<div class="rating">'; 

									str+='<a href="#"><i class="fa fa-star active-color" aria-hidden="true"></i></a>'; 

									str+='<a href="#"><i class="fa fa-star active-color" aria-hidden="true"></i></a>'; 

									str+='<a href="#"><i class="fa fa-star active-color" aria-hidden="true"></i></a>';

									str+='<a href="#"><i class="fa fa-star-o" aria-hidden="true"></i></a>';

									str+='<a href="#"><i class="fa fa-star-o" aria-hidden="true"></i></a>'; 

								str+='</div>';

								str+='<div class="cart-price">$'+res['items'][i]['price']+'</div>';

							  str+='</div>';

							str+='</div>';

						  str+='</div>';

						}

						  $('.totalItems').html(res.totalItems)

						  $('#cartItems').html(str);
					 
					 },
					  error: function (jqXHR, status, err) {
						  alert("Add to cart faild !");
 					  }
			
				});
			});
								
								

 });

 
function Plus(counter){

 	var oldvalue = $('#input'+counter).val();

	var plus = parseInt(oldvalue)+1;

	$('#input'+counter).val(plus);

}

function Minus(counter){
  	var oldvalue = $('#input'+counter).val();
 
 	if(oldvalue==0){
  		$('#input'+counter).val(1);
 	}else if(oldvalue!=0){

 		 if(oldvalue==1){
			$('#input'+counter).val(1);
		}else{
			var plus = parseInt(oldvalue)-1;
			$('#input'+counter).val(plus);
		}
 	}

}
function updateCart(){
	var ids = $("input[name='ids[]']").map(function(){return $(this).val();}).get();
	var qty = $("input[name='qty[]']").map(function(){return $(this).val();}).get();
	//window.location.href= './update-cart?id='+ids+'&qty='+qty;
 
				$.ajax({
 					  dataType : "json",
  					  headers: {  'Authkey': csrf},
   					  url: './update-cart?ids='+ids+'&qty='+qty,
 					  success:function(res)
 					  { 
					  	if(res.code == 400)
						{
							alert(res.error);
						}else{
					  	window.location.reload();
						}
  					  },
					  error: function (jqXHR, status, err) {
						  //alert("Network Error.");
 					  }

					});
}
function removecartItem(id){
 				$.ajax({
						dataType : "json",
   					  headers: {  'Authkey': csrf},
   					  url: './remove-cart-item?id='+id,
 					  success:function(res)
 					  { 
					  	if(res.code == 400)
						{
							alert(res.error);
						}else{
							window.location.reload();
						}
  					  },
					  error: function (jqXHR, status, err) {
						  //alert("Network Error.");
 					  }

					});
}

 