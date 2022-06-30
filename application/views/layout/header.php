 <!-- BEGIN HEADER -->
 <div class="header navbar  navbar-fixed-top">
 <!-- BEGIN TOP NAVIGATION BAR -->
        <div class="header-inner">
                <!-- BEGIN LOGO -->
                <div class="page-logo" style="margin-top:-19px;">
                        <a href="#"><img src="<?=base_url()?>public/img/TMSLogo2.png" alt="logo" height="50"/></a>
                </div>
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <img src="<?=base_url()?>public/assets/img/menu-toggler.png" alt=""/>
                </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <ul class="nav navbar-nav pull-right">

                        <li class="devider">&nbsp;</li>
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <li class="dropdown user">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                        <img alt="" src="<?=base_url()?>public/assets/img/avatar3_small.jpg"/>
                                        <span class="username"><?php echo $this->session->User; ?></span>
                                        <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu">
                                        <?php if($CONTRACTORFULLNAME != '') { ?>
                                        <li>
                                            <?php echo anchor('contractor/personalinfo',' Clear Sesion','class="fa fa-ban"'); ?>
                                        </li>
                                        <?php } ?>
                                        <li>
                                            <a style="cursor:pointer;" onclick="populateChangePassword()"><span class="fa fa-lock">&nbsp;Change Password</span></a>
                                        </li>
                                        
                                        
                                        <?php if(!$this->session->xeroAccessToken && $this->session->userId == 15){?>
                                        <li>
                                            <a style="cursor:pointer;" onclick="setXeroAccessToken();"><span class="fa fa-key">&nbsp;Xero Access Token</span></a>
                                        </li>
                                        <?php }?>

                                        <?php if($this->session->userId == 15){?>
                                        <li>
                                            <a style="cursor:pointer;" onclick="addXeroTenantID();"><span class="fa fa-key">&nbsp;Xero-Company setup</span></a>
                                        </li>                                        
                                        <?php }?>    
                                        <li>
                                            <?php echo anchor('Login/logout',' Log Out','class="fa fa-power-off" onclick="sessionUnset()"'); ?>
                                        </li>
                                </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                </ul>
                <!-- <div align="right" style="padding-top: 45px;">
                    <font color="black" style="font-size:15px;color: #0B2240;">
                        <Marquee direction="left" bgcolour="white"  behavior="alternative" width="85%">
                            <img style="width: 20px;height: 20px;" data-emoji="🇺🇸" class="an1" alt="🇺🇸" aria-label="🇺🇸" src="https://fonts.gstatic.com/s/e/notoemoji/14.0/1f1fa_1f1f8/72.png" loading="lazy">
                            &nbsp;
                        Happy Thanksgiving Day
                            &nbsp;
                            <img style="width: 20px;height: 20px;" data-emoji="🇺🇸" class="an1" alt="🇺🇸" aria-label="🇺🇸" src="https://fonts.gstatic.com/s/e/notoemoji/14.0/1f1fa_1f1f8/72.png" loading="lazy">
                    </Marquee>
                    </font>
                </div> -->
                <!-- END TOP NAVIGATION MENU -->                
        </div>
        <!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<!-- Modal -->

<div id="ChangePasswordModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Password</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">New Password</div>
          <div class="col-md-6"><input type="password" name="newCredential" class="form-control"  id="newCred"></div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-6">Verify New Password</div>
          <div class="col-md-6"><input type="password" name="newCredentialVerify" class="form-control"  id="newCredVerify" ></div>
        </div>
      </div>
      <div class="modal-footer">
        <a class="btn btn-sm btn-danger" id="save" onclick ="validateAndSubmit()">Save</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function populateChangePassword() {
        $('#ChangePasswordModal').modal('show');
    }
    function validateAndSubmit(){

        var password  = $('#newCred').val();
        var cPassword = $('#newCredVerify').val();
        var userid    = <?php echo $this->session->Id;?>;
        if(password!=='' || cPassword!==''){

            if(password!==cPassword){
                 toastr.error('password does not match');
            }
            else{
                $.ajax({
                    url: '<?php echo base_url();?>Dashboard/changePassword',
                    type: 'POST',
                    dataType:'json',
                    data: {'newCredential':password,'newCredentialVerify':cPassword,'hiddenId':userid},
                    success: function(data, status){ 
                        if(data.success == 1) {
                            toastr.success(data.message,'Success');
                        }
                        else {
                            toastr.error(data.message,'Error');
                        }
                        $('#ChangePasswordModal').modal('hide');
                    },
                    error : function(xhr, textStatus, errorThrown) {
                      if (xhr.status === 0) {
                        alert('Not connected. Verify Network.');
                      } else if (xhr.status == 404) {
                        alert('Requested page not found. [404]');
                      } else if (xhr.status == 500) {
                        alert('Server Error [500].'); 
                      } else if (errorThrown === 'parsererror') {
                        alert('Requested JSON parse failed.');
                      } else if (errorThrown === 'timeout') {
                        alert('Time out error.');
                      } else if (errorThrown === 'abort') {
                        alert('Ajax request aborted.');
                      } else {
                        alert('Remote sever unavailable. Please try later');
                      }
                    }
            });
        }
    }
        
}
function sessionUnset(){
    sessionStorage.clear();
}
</script>