<?php
	
	$roleIds    	=   $this->session->roles;
	$controllerURL 	=	$this->uri->segment(1);
	$actionURL 		=	$this->uri->segment(2);	


	$classActive 	=	'class="active"';

	if($controllerURL == 'Dashboard'){
		$ctrlDashboard =$classActive;
		$ctrlTeam ='';
		$ctrlTask ='';
		$ctrlWork ='';
		$ctrlUsers ='';
	}
	else if($controllerURL == 'Team'){
		 $ctrlTeam =$classActive;
		$ctrlDashboard ='';
		$ctrlTask ='';
		$ctrlWork ='';
		$ctrlUsers ='';
	}
	else if($controllerURL == 'Task'){
	    $ctrlTask = $classActive;
		$ctrlTeam ='';
		$ctrlDashboard ='';
		$ctrlWork ='';
		$ctrlUsers ='';
	}
	else if($controllerURL == 'Work'){
	    $ctrlWork = $classActive;
		$ctrlTeam ='';
		$ctrlTask ='';
		$ctrlDashboard ='';
		$ctrlUsers ='';
	}
	else if($controllerURL == 'ApproveWork' && $actionURL == 'index'){
	    $ctrlWork = $classActive;
		$ctrlTeam ='';
		$ctrlTask ='';
		$ctrlDashboard ='';
		$ctrlUsers ='';
	}
	else if($controllerURL == 'Users' ){
      	$ctrlUsers = $classActive;
		$ctrlTeam ='';
		$ctrlTask ='';
		$ctrlWork ='';
		$ctrlDashboard ='';
	}
?>

<div class="page-sidebar-wrapper">
	<div class="page-sidebar navbar-collapse collapse">
	<!-- BEGIN SIDEBAR MENU -->
		<ul class="page-sidebar-menu">
			<li class="sidebar-toggler-wrapper">
				<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				<div class="sidebar-toggler"></div>
				<div class="clearfix"></div>
				<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
			</li>
			<li id="liDashboard" <?=$ctrlDashboard?>>
				<a href="<?php echo base_url(); ?>Dashboard/index">
					<i class="fa fa-dashboard green_icon"></i>
					<span class="title">Dashboard</span>
				</a>
			</li>
			<li id="liTeam" <?=$ctrlTeam?>>
				<a href="<?php echo base_url(); ?>Team/index">
					<i class="fa fa-group blue_icon" style="font-size:12px" aria-hidden="true"></i>
					<span class="title">Team</span>
				</a>
			</li>
			<li id="liTask" <?=$ctrlTask?>>
				<a href="<?php echo base_url(); ?>Task/index">
					<i class="fa fa-tasks blue_icon"></i>
					<span class="title">Task</span>
				</a>
			</li>
			<li id="liInvoice" <?=$ctrlWork?>>
				<a href="<?php echo base_url(); ?>Work/index">
					<i class="fa fa-list-alt blue_icon"></i>
					<span class="title">Work</span>
				</a>
			</li>
			<li id="liPayroll" <?=$ctrlUsers?>>
				<a href="<?php echo base_url(); ?>Users/index">
					<i class="fa fa-user blue_icon" aria-hidden="true"></i>
					<span class="title">Users</span>
				</a>
			</li>
		</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>