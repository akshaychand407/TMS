<?php


$this->load->view('layout/head.php'); 
$controllerURL  = $this->uri->segment(1);
$actionURL      = $this->uri->segment(2);
$headerAttr     = 'page-sidebar-fixed';
if($controllerURL == 'dms' || $actionURL == 'invoiceTool'|| $actionURL == 'bulkpayfinalise'|| $actionURL == 'pendingApprovals'|| $actionURL == 'pendingApprovalsFlc'|| $actionURL == 'cxtracking'|| $actionURL == 'bulkpaydatechange'|| $actionURL == 'bulkinvmatch')
    $headerAttr = 'page-sidebar-closed';
?>
<body class="page-header-fixed page-sidebar-fixed <?=$headerAttr?>" id="body">
    <?php $this->load->view('layout/header.php');  ?> <!-- Common top area above dynamic section of page  -->
    <div class="clearfix"></div>
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <?php $this->load->view('layout/menu.php'); ?> <!-- Left side menu  -->
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">
                <?php $this->load->view('layout/headerscripts.php'); ?> <!-- Javascript functions and libraries are here -->
                
                <!-- CONTENT GOES HERE -->
                <div>
                   <?php $this->load->view($mainContent);  ?> <!-- Changing Part -->
               </div>
           </div>
       </div>
   </div>
   <?php $this->load->view('layout/footer.php'); ?>