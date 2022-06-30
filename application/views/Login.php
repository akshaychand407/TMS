
<?php
    $Email = array(
        'name'          => 'Email',
        'id'            => 'Email',
        'class'         =>  'form-control input-ld',
        'placeholder'   =>  'UserName',
        'required'      =>  'required'
    );

    $Password = array(
        'name'          => 'Password',
        'id'            => 'Password',
        'type'          => 'Password',
        'class'         => 'form-control input-md',
        'placeholder'   =>  'Password',
        'required'      =>  'required'
    );

    $submitBtn = array( 
        'name'      =>  'SubmitBtn',        
        'value'     =>  'Login',   
        'class'     => 'btn btn-info pull-right',
        'type'      =>  'submit' 
    );
?>

<h3>Login to your account</h3>  
    <form method="post" action="<?= base_url()?>Login/login_validation">
    <div class="form-group">
                
        <label class="control-label visible-ie8 visible-ie9"><label for="identity">Email</label></label>
        <div class="input-icon">
            <i class="fa fa-user"></i>
            <?= form_input($Email);?>
            <span class="text-danger"><?= form_error('Email'); ?></span>        
        </div>
    </div>

    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9"><label for="credential">Password</label></label>
        <div class="input-icon">
            <i class="fa fa-lock"></i>
            <?= form_input($Password);?> 
            <span class="text-danger"><?= form_error('Password'); ?></span>   
        </div>
    </div>
        
    
    <div class="form-actions">
        <label class="checkbox">
        <input type="checkbox" name="remember" value="1"/> Remember me </label>
        <?= form_submit($submitBtn);?> 
        <br /><br />
        <!-- <a href="<?= base_url()?>auth/forgetPassword" class="text-right" style="padding-left: 6px;"> Forgot Your Password?</a>   -->
    </div>
    <?php if($this->session->userdata('error')) {   ?>
    <p style="color:red"><?php echo $this->session->userdata('error');
    $this->session->unset_userdata('error');
    ?></p>
    <?php } ?> 
    </form>