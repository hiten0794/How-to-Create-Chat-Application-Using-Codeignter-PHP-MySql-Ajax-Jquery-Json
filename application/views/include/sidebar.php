<aside class="main-sidebar">
  
  <!-- sidebar: style can be found in sidebar.less -->
  
  <section class="sidebar">
    
    <!-- Sidebar user panel -->
    
    <div class="user-panel">
      <div class="pull-left image">
        <?php
            	$obj=&get_instance();
				$obj->load->model(['UserModel','OuthModel']);
 				$profile_url = $obj->UserModel->PictureUrl();
				$user=$obj->UserModel->GetUserData();
			?>
        <img src="<?=$profile_url;?>" class="img-circle profileImgUrl" alt="User Image"> </div>
      <div class="pull-left info">
        <p class="NameEdt">
          <?=$user['name'];?>
        </p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a> </div>
    </div>
 
    
    <!-- sidebar menu: : style can be found in sidebar.less -->
    
    <?php $uri=$this->uri->segment(1).'/'.$this->uri->segment(2)?>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <li class="<?php if($this->uri->segment(2)=='dashboard'){echo'active';}?>"><a href="<?=base_url('v3/dashboard');?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      <?php if($this->session->userdata['Admin']['role'] == 'Admin'){?>
      <li class="treeview <?php if($uri=='vendor/list'){ echo 'active';}?>"> <a href="#"> <i class="fa fa-users"></i> <span>Users</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
        <ul class="treeview-menu">
          <li class="<?php if($uri=='vendor/list'){ echo 'active';}?>"> <a href="<?=base_url('vendor/list');?>"><i class="fa fa-list"></i>List</a></li>
        </ul>
      </li>
       
 
      <?php
	   }
		?>
 
 
	
	
       <?php $invoiceuri=$this->uri->segment(3);?>
   
      
      <li class="<?php if($this->uri->segment(1)=='chat'){ echo 'active';}?>"> <a href="<?=base_url('chat');?>"> 
      <i class="fa fa fa-comment"></i> <span>Chat</span> 
     </a>
         
      </li>
      
 
    </ul>
  </section>
  
  <!-- /.sidebar -->
  
</aside>