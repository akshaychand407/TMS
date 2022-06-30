<?php echo doctype();  ?>
<html lang="en">
<head>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<?php

$meta = array(
                array(
                        'name' => 'Content-type',
                        'content' => 'text/html; charset=utf-8', 'type' => 'equiv'
                )
        );
echo meta($meta);
echo link_tag('https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all');
echo link_tag('public/img/TMSLogo2.png', 'shortcut icon', 'image/ico');
echo link_tag('public/assets/plugins/font-awesome/css/font-awesome.min.css');
echo link_tag('public/assets/plugins/simple-line-icons/simple-line-icons.min.css');
echo link_tag('public/assets/plugins/bootstrap/css/bootstrap.min.css');
echo link_tag('public/assets/plugins/uniform/css/uniform.default.css');
echo link_tag('public/assets/css/style-conquer.css');
echo link_tag('public/assets/css/style.css');
echo link_tag('public/assets/css/style-responsive.css');
echo link_tag('public/assets/css/plugins.css');
echo link_tag('public/assets/css/themes/light.css');
echo link_tag('public/assets/css/pages/login.css');
echo link_tag('public/assets/css/custom.css');

?>
</head>
<body class="login">
        <!-- BEGIN LOGO -->
        <div class="logo">
                <a href="http://www.eolastech.com/">
                        <img src="<?=base_url()?>public/img/TMSLogo2.png" alt=""/>
                </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
        	<div><?php $this->load->view($MainContent); ?></div>
        	<script type="text/javascript" src="<?=base_url()?>public/assets/plugins/jquery-1.11.0.min.js"></script>
        	<script type="text/javascript" src="<?=base_url()?>public/assets/plugins/jquery-migrate-1.2.1.min.js"></script>
        	<script type="text/javascript" src="<?=base_url()?>public/assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js"></script>
			<script type="text/javascript" src="<?=base_url()?>public/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
			<script type="text/javascript" src="<?=base_url()?>public/assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
			<script type="text/javascript" src="<?=base_url()?>public/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
			<script type="text/javascript" src="<?=base_url()?>public/assets/plugins/jquery.blockui.min.js"></script>
			<script type="text/javascript" src="<?=base_url()?>public/assets/plugins/uniform/jquery.uniform.min.js"></script>
			<script type="text/javascript" src="<?=base_url()?>public/assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
			<script type="text/javascript" src="<?=base_url()?>public/assets/plugins/select2/select2.min.js"></script>
			<script type="text/javascript" src="<?=base_url()?>public/assets/scripts/app.js"></script>
        	<!-- END PAGE LEVEL SCRIPTS -->
			<script language="javascript">
				jQuery(document).ready(function() {     
				  App.init();
				  var action = location.hash.substr(1);
		          if (action == 'createaccount') {
		              $('.register-form').show();
		              $('.login-form').hide();
		              $('.forget-form').hide();
		          } else if (action == 'forgetpassword')  {
		              $('.register-form').hide();
		              $('.login-form').hide();
		              $('.forget-form').show();
		          }
				});
			</script>
        </div>
        <!-- END LOGIN -->
		<!-- BEGIN COPYRIGHT -->
		<!-- <div class="copyright">
			 <?=date('Y')?> &copy; Fenero is regulated by the Association of Chartered Certified Accountants. <br> Version 2.0
		</div> -->
		<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
