<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $this->load->view('include/header');?>

<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('public');?>/components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style>
.imgcls {
	height: 70px;
	width: 80px;
}
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php $this->load->view('include/topbar');?>

<!-- Left side column. contains the logo and sidebar -->

<?php $this->load->view('include/sidebar');?>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper"> 
  
  <!-- Content Header (Page header) -->
  
  <section class="content-header">
    <h1> Vendor Listing <small>Control panel</small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?=base_url('dashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">
        <?=$this->uri->segment(2).'/'.$this->uri->segment(3);?>
      </li>
    </ol>
  </section>
  
  <!-- Main content -->
  
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">&nbsp;</h3>
          </div>
          
          <!-- /.box-header -->
          
          <div class="box-body" id="element_overlapT">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Avatar</th>
                  <th>Username/Email</th>
                  <th>Email</th>
                  <th>Mobile No.</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Avatar</th>
                  <th>Username/Email</th>
                  <th>Email</th>
                  <th>Mobile No.</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th>Actions</th>
                </tr>
              </tfoot>
            </table>
          </div>
          
          <!-- /.box-body --> 
          
        </div>
        
        <!-- /.box --> 
        
      </div>
      
      <!-- /.col --> 
      
    </div>
    
    <!-- /.row --> 
    
  </section>
  
  <!-- /.content --> 
  
</div>

<!-- /.content-wrapper -->

<div class="modal fade" id="myModal2" role="dialog">
  <div class="modal-dialog modal-sm"> 
    
    <!-- Modal content-->
    
    <div class="modal-content">
      <div class="modal-body">
        <p><b id="modalmessage"></b></p>
        <input type="hidden" id="b_status">
        <input type="hidden" id="b_id">
      </div>
      <div class="modal-footer" style="padding: 5px;">
        <button type="button" onClick="blockAction();" class="btn btn-info" >Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('include/footer');?>
<script src="<?=base_url('public');?>/loadingoverlap/loadingoverlay.min.js"></script> 
<script src="<?=base_url('public');?>/loadingoverlap/loadingoverlay_progress.min.js"></script> 
<script src="<?=base_url('public');?>/components/datatables.net/js/jquery.dataTables.min.js"></script> 
<script src="<?=base_url('public');?>/components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
<script>

  $(function () {

     $('#example1').DataTable({

	 					"processing": true,

						"serverSide": true, 

						"ajax":{

							url :"<?=base_url('vendor/grid-data')?>", 

							type: "post",  

							headers: {  'Authkey': '<?=$this->security->get_csrf_hash();?>'},

							error: function(){  

								$(".contacts-grid-error").html("");

								$("#contacts-grid").append('<tbody class="contacts-grid-error"><tr><th align="center" colspan="5">No data found in the server</th></tr></tbody>');

								$("#contacts-grid_processing").css("display","none");

							} 

						},

	 });

  });

  

function trash(id){

	

   	$("#element_overlapT").LoadingOverlay("show");

 				$.ajax({

						  dataType : "json",

 						  headers: {  'Authkey': '<?=$this->security->get_csrf_hash();?>'},

						  url: '<?=base_url('vendor/trash?id=')?>'+id,

						  success:function(data)

								{

  									$("#element_overlapT").LoadingOverlay("hide", true);

									if(data.code == 400)

									{

									  alert(data.error);

									}

									if(data.status == 0)

									{

									  //alert(data.message);

									}

									if(data.status == 1)

									{

 										//alert(data.message);

										 var table = $('#example1').DataTable();

					 						table.ajax.reload(null, false);

 									}

						  },

						  error: function (jqXHR, status, err) {

							  $("#element_overlapT").LoadingOverlay("hide", true);

							  alert('Local error callback');

						  }

 					});

}



function status(id,status){

	

   	$("#element_overlapT").LoadingOverlay("show");

 				$.ajax({

						  dataType : "json",

 						  headers: {  'Authkey': '<?=$this->security->get_csrf_hash();?>'},

						  url: '<?=base_url('vendor/status?id=')?>'+id+'&status='+status,

						  success:function(data)

								{

  									$("#element_overlapT").LoadingOverlay("hide", true);

									if(data.code == 400)

									{

									  alert(data.error);

									}

									if(data.status == 0)

									{

									  //alert(data.message);

									}

									if(data.status == 1)

									{

 										//alert(data.message);

										 var table = $('#example1').DataTable();

					 						table.ajax.reload(null, false);

 									}

						  },

						  error: function (jqXHR, status, err) {

							  $("#element_overlapT").LoadingOverlay("hide", true);

							  alert('Local error callback');

						  }

 					});

}

function block(id,status){

	var str='';

	if(status == 2){

		str='Are you sure this vendor blocked !';

	}if(status == 1){

		str='Are you sure this vendor unblock !';

	}

 	$('#modalmessage').html(str);

 	$('#b_status').val(status);

	$('#b_id').val(id);

 	$('#myModal2').modal({ backdrop: 'static' });

}



function blockAction(){

	$('#myModal2').modal('hide');

	var status = $('#b_status').val();

	var id = $('#b_id').val();

	

	   	$("#element_overlapT").LoadingOverlay("show");

 				$.ajax({

						  dataType : "json",

 						  headers: {  'Authkey': '<?=$this->security->get_csrf_hash();?>'},

						  url: '<?=base_url('vendor/block?id=')?>'+id+'&status='+status,

						  success:function(data)

								{

  									$("#element_overlapT").LoadingOverlay("hide", true);

									if(data.code == 400)

									{

									  alert(data.error);

									}

									if(data.status == 0)

									{

									  //alert(data.message);

									}

									if(data.status == 1)

									{

 										//alert(data.message);

										 var table = $('#example1').DataTable();

					 						table.ajax.reload(null, false);

 									}

						  },

						  error: function (jqXHR, status, err) {

							  $("#element_overlapT").LoadingOverlay("hide", true);

							  alert('Local error callback');

						  }

 					});

					

 }

 

</script>
</body>
</html>