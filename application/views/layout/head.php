<?php echo doctype();  ?>
<html lang="en">
<head>
<title></title>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<?php

$meta = array(
                array(
                        'name' => 'Content-type',
                        'content' => 'text/html; charset=utf-8', 'type' => 'equiv'
                )
        );
echo meta($meta);
echo link_tag('public/img/TMSLogo2.png', 'shortcut icon', 'image/ico');
echo link_tag('public/css/googlefonts.css');
echo link_tag('public/assets/plugins/typeahead/typeahead.css');
echo link_tag('public/assets/plugins/font-awesome/css/font-awesome.min.css');
echo link_tag('public/assets/plugins/simple-line-icons/simple-line-icons.min.css');
echo link_tag('public/assets/plugins/bootstrap/css/bootstrap.min.css');
echo link_tag('public/assets/plugins/uniform/css/uniform.default.css');
echo link_tag('public/assets/css/style-conquer.css');
echo link_tag('public/assets/css/style.css');
echo link_tag('public/assets/css/style-responsive.css');
echo link_tag('public/assets/css/plugins.css');

if(ENVIRONMENT == 'localdevelopment')
	echo link_tag('public/assets/css/themes/default.css');
else if(ENVIRONMENT == 'development')
	echo link_tag('public/assets/css/themes/red.css');
else if(ENVIRONMENT == 'production')
	echo link_tag('public/assets/css/themes/fen.css');


echo link_tag('public/assets/css/custom.css');
echo link_tag('public/assets/plugins/bootstrap-toastr/toastr.min.css');
echo link_tag('public/assets/css/postitall.css');
echo link_tag('public/css/jquery-confirm.css');

?>

</head>

