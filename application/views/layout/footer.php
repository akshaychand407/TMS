<!-- BEGIN FOOTER -->
<div class="footer"> 
  <div class="footer-inner">
   <!-- <?=date('Y')?> &copy; Fenero. Version 2.0  -->
   <a style="text-decoration: none;color:#009558;font-size:12px;font-weight: bold;" href="Javascript:loginMyFenero()" onClick="if(document.forms[0].CONTRACTORID.value==''){alert('Please select a contractor.');return false;}else{return true;}">
   </a> 
</div>
<div class="footer-tools">
    <span class="go-top">
        <i class="fa fa-angle-up"></i>
    </span>
</div>
</div>
<!-- END FOOTER -->           
</body>
</html>
<!-- Toaster Code missing -->
<?php

if ($this->session->userdata('message')) {
 ?>
 <script>
  $( document ).ready(function() {
     toastr.success("<?php echo $this->session->userdata('message');?>", 'Success');
 });
</script>
<?php
}

if ($this->session->userdata('error')) {
    ?>
    <script>
      $( document ).ready(function() {
        toastr.error("<?php echo $this->session->userdata('error');?>", 'Error');
    });
</script>
<?php
}

if ($this->session->userdata('info')) {
    ?>
    <script>
      $( document ).ready(function() {
        toastr.warning("<?php echo $this->session->userdata('info');?>", 'Warning');   
    });
</script>
<?php 
}

if ($this->session->userdata('xeroErr')) {
    ?>
    <script>
      $( document ).ready(function() {
        toastr.error("<?php echo $this->session->userdata('xeroErr');?>", 'Error');
    });
</script>
<?php
}
$this->session->unset_userdata('message');
$this->session->unset_userdata('error');
$this->session->unset_userdata('info');
$this->session->unset_userdata('xeroErr');
?>


