 $(function(){ 

 		$("#loginF").submit('on',function(e){

					e.preventDefault();

					

					$('#ErrorMessageL').html('<span style="color:#060;">Please wait...</span>');

				 

   					$.ajax({

					  dataType : "json",

					  type : "post",

 					  data : { email: $(".emaillogin").val(), password : $(".passwordlogin").val(), captcha: grecaptcha.getResponse() },//$('#loginF').serializeArray(),

					  headers: {  'Authkey': $('#loginhash').val()},

  					  url: $('#loginF').attr('action'),

					  success:function(data)

							{

								 

  								if(data.code == 400)

								{

								  $('#ErrorMessageL').html('<span style="color:red;">'+data.error+'</span>');
									grecaptcha.reset();
								}

								

 								if(data.status == 0)

								{

								  $('#ErrorMessageL').html('<span style="color:red;">'+data.message+'</span>');
								  grecaptcha.reset();

								}
 
								if(data.status == 1)

								{

 									  $('#ErrorMessageL').html('<span style="color:green;">'+data.message+'</span>');

									  $('#loginF').trigger('reset');

									  window.location.href=data.redirectUrl;

 								}

 					  },

					  error: function (jqXHR, status, err) {

						  $('#ErrorMessageL').html("<span style='color:red;'>Network Error.</span>");

 					  }

				

					});

					 



		});

		

		$("#register").submit('on',function(e){

					e.preventDefault();

					

					$('#ErrorMessage').html('<span style="color:#060;">Please wait...</span>');

				 

   					$.ajax({

					  dataType : "json",

					  type : "post",

 					  data : $('#register').serializeArray(),

					  headers: {  'Authkey': $('#reghash').val()},

  					  url: $('#register').attr('action'),

					  success:function(data)

							{

								 

  								if(data.code == 400)

								{

								  $('#ErrorMessage').html('<span style="color:red;">'+data.error+'</span>');

								}

								

 								if(data.status == 0)

								{

								  $('#ErrorMessage').html('<span style="color:red;">'+data.message+'</span>');

								}

								if(data.status == 1)

								{

 									  $('#ErrorMessage').html('<span style="color:green;">'+data.message+'</span>');

									  $('#register').trigger('reset');

									  //window.location.href=data.redirectUrl;

 								}

 					  },

					  error: function (jqXHR, status, err) {

						  $('#ErrorMessage').html("'<span style='color:red;'>Network Error.</span>");

 					  }

				

					});

					 



		});

		

		$("#vendor_register").submit('on',function(e){

					e.preventDefault();

					

					$('#ErrorMessageVendor').html('<span style="color:#060;">Please wait...</span>');

					

   					var form_data = new FormData();

					 

 					for(var i=0; i<$('#vendorfiles').prop('files').length; i++){

 						form_data.append('vendorfilesImg[]', $('#vendorfiles').prop('files')[i]);

					}

 					form_data.append('firstname', $("#first_name").val());

					form_data.append('lastname', $("#last_name").val());

					form_data.append('email', $("#email").val());

					form_data.append('password', $("#password").val());

					form_data.append('confirm_password', $("#confirm_password").val());

					form_data.append('tc', $("#tc").val());

					

 				 

   					$.ajax({

					  dataType : "json",

					  type : "post",

					  cache: false,

					  contentType: false,

					  processData: false,

					  data : form_data,

					  headers: {  'Authkey': $('#vendorreghash').val()},

  					  url: $('#vendor_register').attr('action'),

					  success:function(data)

							{

								 

  								if(data.code == 400)

								{

								  $('#ErrorMessageVendor').html('<span style="color:red;">'+data.error+'</span>');

								}

								

 								if(data.status == 0)

								{

								  $('#ErrorMessageVendor').html('<span style="color:red;">'+data.message+'</span>');

								}

								if(data.status == 1)

								{

 									  $('#ErrorMessageVendor').html('<span style="color:green;">'+data.message+'</span>');

									  $('#vendor_register').trigger('reset');

									  //window.location.href=data.redirectUrl;

 								}

 					  },

					  error: function (jqXHR, status, err) {

						  $('#ErrorMessageVendor').html("'<span style='color:red;'>Network Error.</span>");

 					  }

				

					});

					 



		});

		

  	

});

 