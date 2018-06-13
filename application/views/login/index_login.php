 <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Chat Application</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?=base_url('public');?>/components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('public');?>/components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url('public');?>/components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url('public');?>/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=base_url('public');?>/plugins/iCheck/square/blue.css">
 
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?=base_url();?>"><b>Chat Application</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="<?=base_url('dashboard-login');?>" method="post" id="loginF">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" required name="email" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" required class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div id="ErrorMessage"></div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
      
      <br>
      <div class="row">
        <div class="col-xs-12">
        
         <div class="col-xs-12">
        	 <table class="table table-striped">
             	<tr>
                	<th>Username</th>
                    <th>Role</th>
                    <th>Password</th>
                </tr>
                <tr>
                	<td>admin@ca.com</td>
                    <td>Admin</td>
                    <td>123456</td>
                </tr>
                <tr>
                	<td>vendor1@ca.com</td>
                    <td>Vendor</td>
                    <td>123456</td>
                </tr>
                 <tr>
                	<td>vendor2@ca.com</td>
                    <td>Vendor</td>
                    <td>123456</td>
                </tr>
                 <tr>
                	<td>client1@ca.com</td>
                     <td>Client</td>
                    <td>123456</td>
                </tr>
                 <tr>
                	<td>client2@ca.com</td>
                     <td>Client</td>
                    <td>123456</td>
                </tr>
                
             </table>
         </div>
          
         
        </div>
        <!-- /.col -->
        
        <!-- /.col -->
      </div>
    </form>
 
 
    
    

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?=base_url('public');?>/components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url('public');?>/components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?=base_url('public');?>/plugins/iCheck/icheck.min.js"></script>
<script>
 $(function(){ 
 		$("#loginF").submit('on',function(e){
					e.preventDefault();
					
					$('#ErrorMessage').html('<span style="color:#060;">Please wait...</span>');
				 
   					$.ajax({
					  dataType : "json",
					  type : "post",
					  cache: false,
					 // contentType: false,
					  //processData: false,
					  data : $('#loginF').serializeArray(),
					  headers: {  'Authkey': '<?=$this->security->get_csrf_hash();?>'},
  					  url: $('#loginF').attr('action'),
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
									  $('#loginF').trigger('reset');
									  window.location.href=data.redirectUrl;
 								}
 					  },
					  error: function (jqXHR, status, err) {
						  $('#ErrorMessage').html("'<span style='color:red;'>'Local error callback.</span>");
 					  }
				
					});
					 

		});
  	
});

</script>
</body>
</html>
