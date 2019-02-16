<?php
global $wpdb;
$appearence_table =	$wpdb->prefix."apt_appearence";
$service_table 	  = $wpdb->prefix."apt_services";
$staff_table 	  = $wpdb->prefix."apt_staff";
$settings_table   = $wpdb->prefix."apt_settings";

$apt_time 		  = $_REQUEST['apt_time'] ;
$apt_time_format  = $_REQUEST['time_format'] ;
$apt_service 	  = $_REQUEST['service'] ;
$apt_staff_member = $_REQUEST['staff_member'] ;
$apt_date 		  = $_REQUEST['apt_date'] ;

$service_price 	   = $wpdb->get_col( "SELECT price from $service_table where id='$apt_service'" ); 
$apt_service_price = $service_price[0];

$service_name 	  = $wpdb->get_col( "SELECT name from $service_table where id='$apt_service'" ); 
$apt_service_name = $service_name[0];

$staff_name 	= $wpdb->get_col( "SELECT staff_member_name from $staff_table where id='$apt_staff_member'" ); 
$apt_staff_name	= $staff_name[0];

$settings_payment_currency = $wpdb->get_col( "SELECT currency from $settings_table" ); 
$payment_currency		   = $settings_payment_currency[0];

/* Form control */
$form_field_option = get_option( 'reg_form_field' );
$ap_flname_field   = $form_field_option['ap_flname_field'];
$ap_username_field = $form_field_option['ap_username_field'];
$ap_skype_field    = $form_field_option['ap_skype_field'];
?>
<style type="text/css">
	.hide_fl_name_field {
	<?php 
		if( $ap_flname_field == 'no' ){
			?>
			display: none;
			<?php
		}
		else{
			?>
			display: block;
			<?php
		}
	?>
}
.hide_username_field{
	<?php 
		if( $ap_username_field == 'no' ){
			?>
			display: none;
			<?php
		}
		else{
			?>
			display: block;
			<?php
		}
	?>
}
.hide_skype_field{
	<?php 
		if( $ap_skype_field == 'no' ){
			?>
			display: none;
			<?php
		}
		else{
			?>
			display: block;
			<?php
		}
	?>
}
</style>
<script>
	<?php 
		if( $ap_flname_field == 'no' || $ap_username_field == 'no' ) {
			?>
			function appoint_register(){
				staff_member 	= '<?php echo $apt_staff_member; ?>';
				service 	 	= '<?php echo $apt_service; ?>';
				booking_st 	 	= '<?php echo $apt_time; ?>';
				apt_date 	 	= '<?php echo $apt_date; ?>';
				apt_time_format = '<?php echo $apt_time_format; ?>';
				
				appointment_username 		= document.getElementById('appoint_username').value;
				appointment_first_name 		= document.getElementById('first_name').value;
				appointment_last_name 		= document.getElementById('last_name').value;
				appointment_client_password = jQuery('#client_password').val();
				appointment_client_contact 	= jQuery('#client_contact').val();
				appointment_client_email 	= jQuery('#client_email').val();
				
				appointment_skype_id 	  = jQuery('#skype_id').val();
				appointment_appoint_notes = jQuery('#appoint_notes').val();
				
				// Add them together and display
			    var full_name = appointment_first_name + " "+ appointment_last_name;		
				jQuery('#client_full_name').val(full_name);
				
				/*if(appointment_username==''){
					jQuery.notify("<?php _e("Please Enter Username",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
					jQuery('#appoint_username').focus();
				} else if(appointment_client_password==''){
					jQuery.notify("<?php _e("Please Enter Password",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
					jQuery('#client_password').focus();
				} */
				if(appointment_client_contact==''){
					jQuery.notify("<?php _e("Please Enter Contact Number",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
					jQuery('#client_contact').focus();
				} else if(appointment_client_email==''){
					jQuery.notify("<?php _e("Please Enter Email Address",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
					jQuery('#client_email').focus();
				} else {
					jQuery("#appoint_register").prop('disabled', true);
					jQuery('#appoint_register').html('<i class="fa fa-spinner fa-spin"></i> <?php _e("Saving",WF_A_P_SYSTEM ); ?>');
					jQuery.ajax({
						type : 'post',
			            url : frontendajax.ajaxurl+'?action=login_ajax_request',  
			            data :  'full_name='+ full_name   + '&client_password='+ appointment_client_password     + '&appoint_username='+ appointment_username + '&first_name='+ appointment_first_name +  '&last_name='+ appointment_last_name  +  '&client_contact='+ appointment_client_contact  +  '&client_email='+ appointment_client_email  +  '&skype_id='+ appointment_skype_id  +  '&appoint_notes='+ appointment_skype_id  +  '&appoint_notes='+ appointment_appoint_notes  + '&staff='+ staff_member + '&service='+ service + '&booking_st='+ booking_st  + '&apt_date='+ apt_date + '&apt_time_format='+ apt_time_format  , 
			            success : function(data){
							jQuery("#appoint_register").prop('disabled', false);
							jQuery('#appoint_register').html('<?php _e("Register",WF_A_P_SYSTEM ); ?>');
							jQuery('#step4').html(data);
							jQuery('#step4').show();
							jQuery('#step1').hide();
							jQuery('#step2').hide();
							jQuery('#step3').hide();
							jQuery('#step5').hide();
							jQuery('#step6').hide();
							jQuery('#existing').hide();
							jQuery('#new').hide();
						}
					});
				}
			}
			<?php
		}
		else {
			?>
			function appoint_register(){
				staff_member = '<?php echo $apt_staff_member; ?>';
				service = '<?php echo $apt_service; ?>';
				booking_st = '<?php echo $apt_time; ?>';
				apt_date = '<?php echo $apt_date; ?>';
				apt_time_format = '<?php echo $apt_time_format; ?>';
				
				appointment_username = document.getElementById('appoint_username').value;
				appointment_first_name = document.getElementById('first_name').value;
				appointment_last_name = document.getElementById('last_name').value;
				appointment_client_password= jQuery('#client_password').val();
				appointment_client_contact= jQuery('#client_contact').val();
				appointment_client_email= jQuery('#client_email').val();
				
				appointment_skype_id= jQuery('#skype_id').val();
				appointment_appoint_notes= jQuery('#appoint_notes').val();
				
				// Add them together and display
			    var full_name = appointment_first_name + " "+ appointment_last_name;		
				jQuery('#client_full_name').val(full_name);
				
				if(appointment_username==''){
					jQuery.notify("<?php _e("Please Enter Username",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
					jQuery('#appoint_username').focus();
				} else if(appointment_first_name==''){
					jQuery.notify("<?php _e("Please Enter First Name",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
					jQuery('#first_name').focus();
				} else if(appointment_last_name==''){
					jQuery.notify("<?php _e("Please Enter Last Name",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
					jQuery('#last_name').focus();
				} else if(appointment_client_password==''){
					jQuery.notify("<?php _e("Please Enter Password",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
					jQuery('#client_password').focus();
				} else if(appointment_client_contact==''){
					jQuery.notify("<?php _e("Please Enter Contact Number",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
					jQuery('#client_contact').focus();
				} else if(appointment_client_email==''){
					jQuery.notify("<?php _e("Please Enter Email Address",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
					jQuery('#client_email').focus();
				} else {
					jQuery("#appoint_register").prop('disabled', true);
					jQuery('#appoint_register').html('<i class="fa fa-spinner fa-spin"></i> <?php _e("Saving",WF_A_P_SYSTEM ); ?>');
					jQuery.ajax({
						type : 'post',
			            url : frontendajax.ajaxurl+'?action=login_ajax_request',  
			            data :  'full_name='+ full_name   + '&client_password='+ appointment_client_password     + '&appoint_username='+ appointment_username + '&first_name='+ appointment_first_name +  '&last_name='+ appointment_last_name  +  '&client_contact='+ appointment_client_contact  +  '&client_email='+ appointment_client_email  +  '&skype_id='+ appointment_skype_id  +  '&appoint_notes='+ appointment_skype_id  +  '&appoint_notes='+ appointment_appoint_notes  + '&staff='+ staff_member + '&service='+ service + '&booking_st='+ booking_st  + '&apt_date='+ apt_date + '&apt_time_format='+ apt_time_format  , 
			            success : function(data){
							jQuery("#appoint_register").prop('disabled', false);
							jQuery('#appoint_register').html('<?php _e("Register",WF_A_P_SYSTEM ); ?>');
							jQuery('#step4').html(data);
							jQuery('#step4').show();
							jQuery('#step1').hide();
							jQuery('#step2').hide();
							jQuery('#step3').hide();
							jQuery('#step5').hide();
							jQuery('#step6').hide();
							jQuery('#existing').hide();
							jQuery('#new').hide();
						}
					});
				}
			}
			<?php
		}
	?>

function appoint_login(){
	staff_member 	= '<?php echo $apt_staff_member; ?>';
	service 	 	= '<?php echo $apt_service; ?>';
	booking_st 	 	= '<?php echo $apt_time; ?>';
	apt_date 		= '<?php echo $apt_date; ?>';
	apt_time_format = '<?php echo $apt_time_format; ?>';
	
	appointment_login_email= jQuery('#ap_email').val();
	appointment_login_password= jQuery('#ap_password').val();
	
	if(appointment_login_email==''){
		jQuery.notify("<?php _e("Please Enter Email",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
		jQuery('#ap_email').focus();
	} else if(appointment_login_password==''){
		jQuery.notify("<?php _e("Please Enter Password",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
		jQuery('#ap_password').focus();
	} else {
		jQuery("#appoint_login").prop('disabled', true);
		jQuery('#appoint_login').html('<i class="fa fa-spinner fa-spin"></i> <?php _e("Loading",WF_A_P_SYSTEM ); ?>');
		
		jQuery.ajax({
			type : 'post',
            url : frontendajax.ajaxurl+'?action=login_ajax_request',  
            data :  'login_email='+ appointment_login_email  + '&login_password='+ appointment_login_password  +  '&staff='+ staff_member + '&service='+ service + '&booking_st='+ booking_st + '&apt_date='+ apt_date + '&apt_time_format='+ apt_time_format, 
            success : function(data){
				jQuery("#appoint_login").prop('disabled', true);
				jQuery('#appoint_login').html('<i class="fa fa-spinner fa-spin"></i> <?php _e("Login",WF_A_P_SYSTEM ); ?>');
				document.getElementById("appoint_login").href="#step4";
				jQuery('#step4').html(data);
				jQuery('#step4').show();
				jQuery('#step1').hide();
				jQuery('#step2').hide();
				jQuery('#step3').hide();
				jQuery('#step5').hide();
				jQuery('#step6').hide();
				jQuery('#existing').hide();
				jQuery('#new').hide();					
			}
        });
	}
}
</script>
<div class="col-md-12 col-sm-12 ap-steps">
	<div class="col-md-2 col-sm-2 ap-step1 services complete">
		<label><?php _e("1. Services",WF_A_P_SYSTEM ); ?></label>
		<span></span>
	</div>
	<div class="col-md-2 col-sm-2 ap-step2 time complete">
		<label><?php _e("2. Time",WF_A_P_SYSTEM ); ?></label>
		<span></span>
	</div>
	<div class="col-md-2 col-sm-2 ap-step3 time active">
		<label><?php _e("3. Details",WF_A_P_SYSTEM ); ?></label>
		<span></span>
	</div>
	<div class="col-md-2 col-sm-2 ap-step4 Details ">
		<label><?php _e("4. Confirm",WF_A_P_SYSTEM ); ?> </label>
		<span></span>
	</div>

	<div class="col-md-2 col-sm-2 ap-step5 done ">
		<label><?php _e("5. Done",WF_A_P_SYSTEM ); ?></label>
		<span></span>
	</div>
</div>

<div id="3" class="ap-steps-detail3">
	<div id="appointment_booking_request">
		<p><?php _e("You are about to request an appointment for",WF_A_P_SYSTEM ); ?> &nbsp;</p><p class="service_tag"><?php _e($apt_service_name,WF_A_P_SYSTEM ); ?></p> <p>&nbsp;</p><p class="staff_tag"><?php echo $apt_staff_name; ?></p><p>&nbsp; <?php _e("at",WF_A_P_SYSTEM ); ?> &nbsp;</p><p class="time_tag">&nbsp;<?php _e($apt_time_format,WF_A_P_SYSTEM ); ?></p><p>&nbsp; <?php _e("on",WF_A_P_SYSTEM ); ?> &nbsp;</p> 
		<?php 
		$date_format = get_option( 'date_format' );
		$appt_date_format=date($date_format, strtotime($apt_date));	?>
		<p class="date_tag"><?php _e($appt_date_format,WF_A_P_SYSTEM ); ?></p>
		<p>. <?php _e("Price for the",WF_A_P_SYSTEM ); ?> &nbsp;</p><p class="service_tag"><?php _e($apt_service_name,WF_A_P_SYSTEM ); ?></p> </p><p>&nbsp;<?php _e("is",WF_A_P_SYSTEM ); ?> </p><p class="service_price_tag"> &nbsp; <?php echo $apt_service_price; ?> <?php if ($payment_currency==""){echo ' USD';} else{ echo ' '.$payment_currency;} ?></p>
		<div class="row signup-info">
			<button id="register_button" onclick="return New();" class="btn btn-danger register-link" type="button"  href="#new"><?php _e("New User",WF_A_P_SYSTEM ); ?></button> 
			<button id="login_button" onclick="return existing();" class="btn btn-success register-link" type="button"  href="#existing"><?php _e("Existing User",WF_A_P_SYSTEM ); ?></button> 
		</div>
	</div>
	
	<!-- Step 3 -->
	<div id="new" class="row service-form">
		<form style="margin-bottom: 0;" action="" method="POST" id="ap_register" name="ap_register">
			<div class="col-md-6 col-sm-6 step3-form hide_username_field">
				<label><?php _e("Username :",WF_A_P_SYSTEM); ?></label>
				<input type="text" class="form-control" name="appoint_username" id="appoint_username" placeholder="<?php _e("Enter User Name",WF_A_P_SYSTEM ); ?>"/>
			</div>
			<div class="col-md-6 col-sm-6 step3-form">
				<label><?php _e("Email :",WF_A_P_SYSTEM); ?></label>
				<input type="email" class="form-control" name="client_email" id="client_email" placeholder="<?php _e("Enter Email Address",WF_A_P_SYSTEM ); ?>"/>
			</div>
			<div class="col-md-6 col-sm-6 step3-form hide_fl_name_field">
				<label><?php _e("First Name :",WF_A_P_SYSTEM); ?></label>
				<input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?php _e("Enter Name",WF_A_P_SYSTEM ); ?>"/>
			</div>
			<div class="col-md-6 col-sm-6 step3-form hide_fl_name_field">
				<label><?php _e("Last Name :",WF_A_P_SYSTEM); ?></label>
				<input type="text" class="form-control" name="last_name" id="last_name" placeholder="<?php _e("Enter Name",WF_A_P_SYSTEM ); ?>"/>
			</div>
			<div class="col-md-6 col-sm-6 step3-form">
				<label><?php _e("Password :",WF_A_P_SYSTEM); ?></label>
				<input type="password" class="form-control" name="client_password" id="client_password" placeholder="<?php _e("Enter Password",WF_A_P_SYSTEM ); ?>"/>
			</div>
			<div class="col-md-6 col-sm-6 step3-form">
				<label><?php _e("Phone :",WF_A_P_SYSTEM ); ?> </label>
				<input type="tel" class="phone form-control" name="client_contact" id="client_contact" >
			</div>
			<div class="col-md-6 col-sm-6 step3-form hide_skype_field">
				<label><?php _e("Skype Id :",WF_A_P_SYSTEM); ?></label>
				<input type="skype_id" class="form-control" name="skype_id" id="skype_id" placeholder="<?php _e("Enter Skype Id",WF_A_P_SYSTEM ); ?>"/>
			</div>
			<?php
				if( $ap_flname_field == 'no' || $ap_username_field == 'no' ) {
					$col_length = '12';
				}
				else {
					$col_length = '6';
				}
			?>
			<div class="col-md-<?php echo $col_length; ?> col-sm-<?php echo $col_length; ?> step3-form">
				<label><?php _e("Notes :",WF_A_P_SYSTEM); ?></label>
				<input type="notes" class="form-control" name="appoint_notes" id="appoint_notes" placeholder="<?php _e("Enter Notes",WF_A_P_SYSTEM ); ?>"/>
			</div>
			<input type="hidden" class="form-control" name="client_full_name" id="client_full_name"/>
			<div class="col-md-6 col-sm-6 step3-form">
				<a class="btn btn-warning" id="appoint_register" onclick="return appoint_register();"><?php _e("Register",WF_A_P_SYSTEM ); ?></a>
			</div>
		</form>
	</div>
		
	<div id="existing" class="row service-form" style="display:none;">
		<form style="margin-bottom: 0;" action="" method="POST" id="ap_login" name="ap_login">
			<div class="col-md-6 col-sm-12 col-xm-12 step3-form">
				<label><?php _e("Email :",WF_A_P_SYSTEM ); ?></label>
				<input type="text"  id="ap_email" class="form-control" name="ap_email" placeholder="<?php _e("Enter Email",WF_A_P_SYSTEM ); ?>"/>
			</div>
			<div class="col-md-6 col-sm-12 col-xm-12 step3-form">
				<label><?php _e("Password :",WF_A_P_SYSTEM ); ?></label>
				<input type="password" class="form-control" id="ap_password" name="ap_password" placeholder="<?php _e("Enter Password",WF_A_P_SYSTEM ); ?>">
			</div>
			<div class="col-md-4 col-sm-12 col-xm-12 step3-form">
				<a class="btn btn-warning" id="appoint_login" onclick="return appoint_login();"><?php _e("Login",WF_A_P_SYSTEM ); ?></a>
			</div>
		</form>
	</div>
	<?php  $detail_editor_content= get_option("details_tips");
	if (!empty($detail_editor_content)) { ?>
	<div class="row step-description">
		<div><?php echo "<pre class='pre_bg' style='display:block !important;'>".$detail_editor_content."</pre>"; ?></div> 
	</div>
	<?php } ?>
</div>

<!-- Step 3 -->
<div class="ap-step-link">
	<?php
	$appearence_details_navigation_text_backward = $wpdb->get_col( "SELECT details_navigation_text_backward from $appearence_table" );
	$details_navigation_text_backward	= $appearence_details_navigation_text_backward[0]; 
	$appearence_details_navigation_text_forward = $wpdb->get_col( "SELECT details_navigation_text_forward from $appearence_table" );
	$details_navigation_text_forward	= $appearence_details_navigation_text_forward[0];
	?>
	<button href="#step2" onclick="return step3_back();" class="btn step-left" type="button"  ><?php  if (!empty($details_navigation_text_backward)) { _e($details_navigation_text_backward,WF_A_P_SYSTEM ); } else { _e("Back",WF_A_P_SYSTEM ); }  ?></button> 
	<!-- <button id="stepnext3" type="button" onclick="return step3_next();" class="btn step-right"><?php if (!empty($details_navigation_text_forward)) { _e($details_navigation_text_forward,WF_A_P_SYSTEM );  } else { _e("Next",WF_A_P_SYSTEM ); }  ?></button> -->
</div>