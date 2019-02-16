<?php
global $wpdb;
$appearence_table =	$wpdb->prefix."apt_appearence";

$staff_member 	  = $_REQUEST['staff'] ;
$service 		  = $_REQUEST['service'] ;
$booking_st 	  = $_REQUEST['booking_st'] ;
$apt_time_format  = $_REQUEST['apt_time_format'] ;

$login_email 	  = $_REQUEST['login_email'] ;		//login
$login_password   = $_REQUEST['login_password'] ;	//login

$client_email 	  = $_REQUEST['client_email'] ;		//registeration
$appoint_username = $_REQUEST['appoint_username'] ;	
$full_name 		  = $_REQUEST['full_name'] ;	
$client_contact   = $_REQUEST['client_contact'] ;	
$skype_id 		  = $_REQUEST['skype_id'] ;	
$apt_date 		  = $_REQUEST['apt_date'] ;	
$first_name 	  = $_REQUEST['first_name'] ;	
$last_name 		  = $_REQUEST['last_name'] ;	
$appoint_notes    = $_REQUEST['appoint_notes'] ;	
$client_password  = $_REQUEST['client_password'] ;

if ( empty( $appoint_username ) ) {
	$appoint_username = $client_email;
}

$date_format 	  = get_option( 'date_format' );
$appt_date_format = date($date_format, strtotime($apt_date));
											
$time_format = get_option( 'time_format' ); 
$temp_time_slot_format = strtotime($booking_st);
$time_slot_format 	   = date($time_format, $temp_time_slot_format);

//LOGIN ACCOUNT
 if(isset($_REQUEST['login_email'])) { 
	$client = get_user_by( 'email', $login_email );
	
	if (!empty($client)) {
		$user_password = $client->user_pass;
		require_once( ABSPATH . WPINC . '/class-phpass.php');
		$wp_hasher = new PasswordHash(8, TRUE);
		if($wp_hasher->CheckPassword($login_password, $user_password)) { ?>
			<script>
				<?php
					$client_first_name = $client->first_name;
					$client_last_name  = $client->last_name;
					$client_user_email = $client->user_email;
					$client_username   = $client->user_login;
				?>
				
				jQuery.notify("<?php _e("Login Successfull",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
						
				document.getElementById('client_username_detail').innerHTML = '<strong><?php _e("Username :",WF_A_P_SYSTEM ); ?> &nbsp;</strong>' +  '<?php echo $client_username;?>';
				document.getElementById('client_fullname_detail').innerHTML = '<strong><?php _e("Name :",WF_A_P_SYSTEM ); ?> &nbsp;</strong>' + '<?php echo $client_first_name;?><?php echo " ".$client_last_name;?>';
				document.getElementById('client_email_detail').innerHTML = '<strong><?php _e("Email Id.:",WF_A_P_SYSTEM ); ?> &nbsp;</strong>' + '<?php echo $client_user_email;?>';
					
				jQuery('.ap_payment_customer').val('<?php echo $client_first_name;?><?php echo " ".$client_last_name;?>');
				document.getElementById('date_detail').innerHTML = '<strong><?php _e("Date :",WF_A_P_SYSTEM ); ?> &nbsp;</strong>' + '<?php echo $appt_date_format;?>';
				document.getElementById('time_detail').innerHTML = '<strong><?php _e("Appointment Time :",WF_A_P_SYSTEM ); ?> &nbsp;</strong>' + '<?php echo $apt_time_format;?>';
					
				jQuery('.client_email_address').val('<?php echo $client_user_email;?>');
					
				<?php 
				$clients_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_clients where email='$login_email'");
				foreach($clients_details as $clients_detail){
					$client_contact =$clients_detail->phone; 
					$skype_id =$clients_detail->skype_id; ?>
					document.getElementById('client_contact_detail').innerHTML = '<strong><?php _e("Contact No.:",WF_A_P_SYSTEM ); ?> &nbsp;</strong>' + '<?php echo $client_contact;?>';
					jQuery('.ap_client_contact_detail').val('<?php echo $client_contact;?>');
					document.getElementById('client_skype_detail').innerHTML = '<strong><?php _e("Skype Id.:",WF_A_P_SYSTEM ); ?> &nbsp;</strong>' + '<?php echo $skype_id;?>';
				<?php  } ?>
				jQuery('.ap_email_notification').val('<?php echo $login_email; ?>');
				jQuery('.ap_payment_date').val(appointment_date);
				jQuery('.ap_staff_id').val(appointment_staff);	
				jQuery('.appoint_staff_id').val(appointment_staff);	
				<?php $staff_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_staff where id='$staff_member'" );
				foreach($staff_details as $staff_detail) {
					$staff_id=$staff_detail->id; 
					$staff_name=$staff_detail->staff_member_name;
					$staff_email=$staff_detail->staff_email; ?>
					document.getElementById('staff_detail').innerHTML = '<strong><?php _e("Staff Member :",WF_A_P_SYSTEM ); ?> &nbsp;</strong>' + '<?php echo $staff_name;?>';
					jQuery('.ap_payment_staff').val('<?php echo $staff_name;?>');
					jQuery('.ap_payment_staff_email').val('<?php echo $staff_email;?>');
				<?php } ?>
				
				<?php $service_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_services where id='$service'");
				foreach($service_details as $service_detail) {
					$service_id=$service_detail->id; 
					$service_name=$service_detail->name;
					$service_price=$service_detail->price;
					$service_duration=$service_detail->duration;
					$service_p_before=$service_detail->p_before;
					$service_p_after=$service_detail->p_after;
					$service_type=$service_detail->service_type;
					$service_duration_with_padding = $service_duration + $service_p_before;
					$settings_table =	$wpdb->prefix."apt_settings";
					$settings_payment_currency = $wpdb->get_col( "SELECT currency from $settings_table" ); 
					$payment_currency	= $settings_payment_currency[0]; ?>
					
					document.getElementById('service_detail').innerHTML = '<strong><?php _e("Name :",WF_A_P_SYSTEM ); ?> &nbsp;</strong>' + '<?php echo $service_name;?>';
					document.getElementById('service_price').innerHTML = '<strong><?php _e("Price :",WF_A_P_SYSTEM ); ?> &nbsp;</strong>' + '<?php echo $service_price;?>';

					<?php
					$settings_service_duration_type = $wpdb->get_col( "SELECT service_duration_type from $settings_table" ); 
					$service_duration_type	= $settings_service_duration_type[0];
					if($service_duration_type=='sd'){	?>
						document.getElementById('service_duration').innerHTML = '<strong><?php _e("Duration :",WF_A_P_SYSTEM ); ?> &nbsp;</strong>' + '<?php echo $service_duration;?><?php echo "minutes";?>' ;
						<?php 
					} else{ ?>
						document.getElementById('service_duration').innerHTML = '<strong><?php _e("Duration :",WF_A_P_SYSTEM ); ?> &nbsp;</strong>' + '<?php echo $service_duration_with_padding;?><?php echo "minutes";?>' ;
						<?php 
					} ?>
					
					jQuery('.ap_booking_end_time').val('<?php echo $service_duration;?><?php echo " minutes";?>');
					jQuery('.ap_payment_service').val('<?php echo $service_name;?>');
	
					jQuery('.ap_payment_amount').val('<?php echo $service_price;?><?php if ($payment_currency==""){echo ' USD';} else{ echo ' '.$payment_currency;} ?>');
					jQuery('#c_service_price').val('<?php echo $service_price;?>');
					jQuery('.service_tag').text('<?php echo $service_name;?>');
					jQuery('.service_price_tag').text('<?php echo $service_price;?><?php if ($payment_currency==""){echo ' USD';} else{ echo ' '.$payment_currency;} ?>');
				<?php } ?>
				jQuery('.ap_booking_start_time').val('<?php echo $booking_st;?>');
				jQuery('.ap_payment_service_id').val('<?php echo $service;?>');
			</script>
			
			<form style="margin-bottom: 0;" action="" method="POST" id="confirm_appointment" name="confirm_appointment">
				<div class="col-md-12 col-sm-12 ap-steps">
					<div class="col-md-2 col-sm-2 ap-step1 services complete">
						<label><?php _e("1. Services",WF_A_P_SYSTEM ); ?></label>
						<span></span>
					</div>
					<div class="col-md-2 col-sm-2 ap-step2 time complete">
						<label><?php _e("2. Time",WF_A_P_SYSTEM ); ?></label>
						<span></span>
					</div>
					<div class="col-md-2 col-sm-2 ap-step3 time complete">
						<label><?php _e("3. Details",WF_A_P_SYSTEM ); ?></label>
						<span></span>
					</div>
					<div class="col-md-2 col-sm-2 ap-step4 Details active">
						<label><?php _e("4. Confirm",WF_A_P_SYSTEM ); ?> </label>
						<span></span>
					</div>
					<div class="col-md-2 col-sm-2 ap-step5 done">
						<label><?php _e("5. Done",WF_A_P_SYSTEM ); ?></label>
						<span></span>
					</div>
				</div>
				
				<!-- Step 4 -->
				<div  id="4" class="ap-steps-detail5">
					<div class="col-md-6 col-sm-6">
					<h4 class="ap-heading"><?php _e("Service Detail",WF_A_P_SYSTEM ); ?></h4>
						<p id="service_detail"></p>
						<p id="service_price"></p>
						<p id="service_duration"></p>
						<p style="display:none" id="staff_detail"></p>
						<p id="time_detail"> </p>
						<p id="date_detail"></p>
					</div>
					<div class="col-md-6 col-sm-6">
						<h4 class="ap-heading"><?php _e("User Detail",WF_A_P_SYSTEM ); ?></h4>
						<p id="client_username_detail"></p>
						<p id="client_fullname_detail"></p>
						<p id="client_contact_detail"></p>
						<p id="client_email_detail"></p>
						<p id="client_skype_detail"></p>
					</div>
					<input type="hidden" class="ap_email_notification" name="ap_email_notification">
					<input type="hidden" class="ap_payment_customer" name="ap_payment_customer"/>
					<input type="hidden" class="ap_payment_staff" name="ap_payment_staff"/>
					<input type="hidden" class="ap_payment_date" name="ap_payment_date"/>
					<input type="hidden" class="ap_payment_service" name="ap_payment_service"/>
					<input type="hidden" class="ap_payment_amount" name="ap_payment_amount"/>
					<input type="hidden" class="ap_payment_staff_email" name="ap_payment_staff_email"/>
					<input type="hidden" class="ap_client_contact_detail" name="ap_client_contact_detail">
					<input type="hidden" class="appoint_staff_id" name="appoint_staff_id">
					<input type="hidden" class="ap_booking_start_time" name="ap_booking_start_time">
					<input type="hidden" class="ap_booking_end_time" name="ap_booking_end_time">
					<input type="hidden" class="client_email_address" name="client_email_address">
					<input type="hidden" class="appoint_unique_id" name="appoint_unique_id" value="<?php echo uniqid(); ?>">
					<input type="hidden" class="ap_payment_service_id" name="ap_payment_service_id"/>
					<div s class="col-md-12 col-sm-12 confirm-link" id="appt_confirm">
						<p><strong><?php _e("Do you want to Confirm Appointment ?",WF_A_P_SYSTEM ); ?></strong></p>
					</div>
					<?php  $confirm_editor_content= get_option("confirm_tips");
						if (!empty($confirm_editor_content)) {	?>
							<div class="col-md-12 step-description">
								<ul> <?php echo "<pre class='pre_bg' style='display:block !important;'>".$confirm_editor_content."</pre>"; ?>  </ul>
							</div>
					<?php } ?>				
				</div>
				
				<!-- Step 4 -->
				<div class="ap-step-link">
					<?php
					$appearence_confirm_navigation_text_backward = $wpdb->get_col( "SELECT confirm_navigation_text_backward from $appearence_table" );
					$confirm_navigation_text_backward	= $appearence_confirm_navigation_text_backward[0]; 
					$appearence_confirm_navigation_text_forward = $wpdb->get_col( "SELECT confirm_navigation_text_forward from $appearence_table" );
					$confirm_navigation_text_forward	= $appearence_confirm_navigation_text_forward[0];
					?>
					<a id="stepback4" href="#step3" onclick="return step4_back();" class="btn step-left" data-toggle="tab" aria-expanded="false"><?php if (!empty($confirm_navigation_text_backward)) {  _e($confirm_navigation_text_backward,WF_A_P_SYSTEM ); } else { _e("Back",WF_A_P_SYSTEM ); } ?></a>
					<button id="stepnext4" name="stepnext4" href="#step5" type="button" onclick="return step4_next();" class="btn step-right"><?php if (!empty($confirm_navigation_text_forward)) { _e($confirm_navigation_text_forward,WF_A_P_SYSTEM ); } else { _e("Next",WF_A_P_SYSTEM ); } ?></button> 
				</div>
			</form>
			<?php
		} else { ?>
			<script>
					jQuery.notify("<?php _e("Invalid Password",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
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
				<div class="col-md-2 col-sm-2 ap-step4 Details">
					<label><?php _e("4. Confirm",WF_A_P_SYSTEM ); ?> </label>
					<span></span>
				</div>
				<div class="col-md-2 col-sm-2 ap-step6 done">
					<label><?php _e("5. Done",WF_A_P_SYSTEM ); ?></label>
					<span></span>
				</div>
			</div>

			<div class="col-md-12 col-sm-12 step3-form">
				<?php _e("<center><p>You have entered invalid Password, Please Try Again.</center><br><center>Thank You</center></p>",WF_A_P_SYSTEM );   ?>
			</div>		
			<?php  $detail_editor_content= get_option("details_tips");
			if (!empty($detail_editor_content)) { ?>
			<div class="row step-description">
				<div><?php echo "<pre class='pre_bg' style='display:block !important;'>".$detail_editor_content."</pre>"; ?></div> 
			</div>
			<?php } ?> 
			<div class="ap-step-link">
				<a id="stepnext2"  onclick="return step2_next();" class="btn step-right" data-toggle="tab" aria-expanded="false"><?php  _e("Try Again",WF_A_P_SYSTEM ); "Try Again";  ?></a>
			</div>
			<?php	
		}
	} else { ?>
		<script>
			jQuery.notify("<?php _e("Email Does Not Exist.",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
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
			<div class="col-md-2 col-sm-2 ap-step5 done">
				<label><?php _e("5. Done",WF_A_P_SYSTEM ); ?></label>
				<span></span>
			</div>
		</div>
		
		<div class="col-md-12 col-sm-12 step3-form">
			<?php _e("<center><p>Email Does Not Exist, Please Register Your Account.</center><br><center>Thank You</center></p>",WF_A_P_SYSTEM ) ;  ?>
		</div>		
		<?php  $detail_editor_content= get_option("details_tips");
		if (!empty($detail_editor_content)) {?>
		<div class="row step-description">
			<div><?php echo "<pre class='pre_bg' style='display:block !important;'>".$detail_editor_content."</pre>"; ?></div> 
		</div>
		<?php } ?> 
		<div class="ap-step-link">
			<a id="stepnext2"  onclick="return step2_next();" class="btn step-right" data-toggle="tab" aria-expanded="false"><?php  _e("Try Again",WF_A_P_SYSTEM );   ?></a>
		</div>
		<?php
	}
}

//REGISTER CUSTOMER AND SUBSCRIBER
if(isset($_REQUEST['client_email'])) {	
	$user_reg_email = get_user_by( 'email',$client_email);
	if (empty($user_reg_email)) {

		$wpdb->insert( $wpdb->prefix.'apt_clients',
			array (
				'first_name' => $first_name,
				'last_name'  => $last_name,
				'phone' 	 => $client_contact,
				'skype_id'   => $skype_id,
				'email' 	 => $client_email,
				'notes' 	 => $appoint_notes,
			)
		);

		$user_data = array (
			'first_name' => $first_name,
			'last_name'  => $last_name,
			'user_pass'  => $client_password,
			'user_email' => $client_email,
			'user_login' => $client_email,
			'role' 		 => 'subscriber' // Use default role or another role, e.g. 'editor'
		);
		$user_id = wp_insert_user( $user_data );
		add_action( 'admin_init', 'wp_insert_user' );
		?>
		<script>
			<?php
			$settings_table =	$wpdb->prefix."apt_settings";
			$settings_payment_currency = $wpdb->get_col( "SELECT currency from $settings_table" ); 
			$payment_currency	= $settings_payment_currency[0];
			$service_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_services where id='$service'");
			foreach($service_details as $service_detail) {
				$service_id=$service_detail->id; 
				$service_name=$service_detail->name;
				$service_price=$service_detail->price;
				$service_duration=$service_detail->duration;
				$service_p_before=$service_detail->p_before;
				$service_p_after=$service_detail->p_after;
				$service_type=$service_detail->service_type;
				$service_duration_with_padding = $service_duration + $service_p_before;
				$settings_service_duration_type = $wpdb->get_col( "SELECT service_duration_type from $settings_table" ); 
				$service_duration_type	= $settings_service_duration_type[0];
				
				if($service_duration_type=='sd') { ?>		
					document.getElementById('service_duration').innerHTML = '<strong>Duration: &nbsp;</strong>' + '<?php echo $service_duration;?><?php echo " minutes";?>' ;
				<?php } else { ?>
					document.getElementById('service_duration').innerHTML = '<strong>Duration: &nbsp;</strong>' + '<?php echo $service_duration_with_padding;?><?php echo " minutes";?>' ;
				<?php } ?>
				
				jQuery('#c_service_price').val('<?php echo $service_price;?>');
				jQuery('.ap_payment_amount').val('<?php echo $service_price;?><?php if ($payment_currency==""){echo ' USD';} else{ echo ' '.$payment_currency;} ?>');
				document.getElementById('service_detail').innerHTML = '<strong>Name: &nbsp;</strong>' + '<?php echo $service_name;?>';
				document.getElementById('service_price').innerHTML = '<strong>Price: &nbsp;</strong>' + '<?php echo $service_price;?><?php if ($payment_currency==""){echo ' USD';} else{ echo ' '.$payment_currency;} ?>';
				jQuery('.ap_booking_end_time').val('<?php echo $service_duration;?><?php echo " minutes";?>');
				jQuery('.ap_payment_service').val('<?php echo $service_name;?>');
				<?php 
			} 
			$staff_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_staff where id='$staff_member'" );
			foreach($staff_details as $staff_detail) {
				$staff_id=$staff_detail->id; 
				$staff_name=$staff_detail->staff_member_name;
				$staff_email=$staff_detail->staff_email; ?>
			jQuery('.ap_payment_staff_email').val('<?php echo $staff_email;?>');
			document.getElementById('staff_detail').innerHTML = '<strong>Staff Member: &nbsp;</strong>' + '<?php echo $staff_name;?>';
			jQuery('.ap_payment_staff').val('<?php echo $staff_name;?>');
			<?php } ?>			
			
			document.getElementById('date_detail').innerHTML = '<strong>Date: &nbsp;</strong>' + '<?php echo $appt_date_format;?>';
			document.getElementById('time_detail').innerHTML = '<strong>Appointment Time: &nbsp;</strong>' + '<?php echo $apt_time_format;?>';
			
			jQuery('.ap_booking_start_time').val('<?php echo $booking_st; ?>');
			jQuery('.ap_email_notification').val('<?php echo $client_email; ?>');
			jQuery('.ap_payment_customer').val('<?php echo $full_name; ?>');
			
			jQuery('.ap_payment_date').val('<?php echo $apt_date; ?>');
			jQuery('.ap_staff_id').val('<?php echo $staff_member; ?>');
			jQuery('.appoint_staff_id').val('<?php echo $staff_member; ?>');
			document.getElementById('client_username_detail').innerHTML = '<strong>Username: &nbsp;</strong>' + '<?php echo $appoint_username; ?>';
			document.getElementById('client_fullname_detail').innerHTML = '<strong>Name: &nbsp;</strong>' +  '<?php echo $full_name; ?>';
			document.getElementById('client_email_detail').innerHTML = '<strong>Email Id.: &nbsp;</strong>' +  '<?php echo $client_email; ?>';
			jQuery('.client_email_address').val(appointment_client_email);
			document.getElementById('client_contact_detail').innerHTML = '<strong>Contact No.: &nbsp;</strong>' +  '<?php echo $client_contact; ?>';
			jQuery('.ap_client_contact_detail').val(appointment_client_contact);
			document.getElementById('client_skype_detail').innerHTML = '<strong>Skype Id.: &nbsp;</strong>' + '<?php echo $skype_id; ?>';
			
			jQuery('.ap_payment_service_id').val('<?php echo $service; ?>');
		</script>
		<form style="margin-bottom: 0;" action="" method="POST" id="confirm_appointment" name="confirm_appointment">
			<div class="col-md-12 col-sm-12 ap-steps">
				<div class="col-md-2 col-sm-2 ap-step1 services complete">
					<label>1. Services</label>
					<span></span>
				</div>
				<div class="col-md-2 col-sm-2 ap-step2 time complete">
					<label>2. Time</label>
					<span></span>
				</div>
				<div class="col-md-2 col-sm-2 ap-step3 time complete">
					<label>3. Details</label>
					<span></span>
				</div>
				<div class="col-md-2 col-sm-2 ap-step4 Details active">
					<label>4. Confirm </label>
					<span></span>
				</div>
				<div class="col-md-2 col-sm-2 ap-step5 done">
					<label>5. Done</label>
					<span></span>
				</div>
			</div>

			<!-- Step 4 -->
			<div  id="4" class="ap-steps-detail5">
				<div class="col-md-6 col-sm-6">
					<h4 class="ap-heading">Service Detail</h4>
					<p id="service_detail"></p>
					<p id="service_price"></p>
					<p id="service_duration"></p>
					<p style="display:none" id="staff_detail"></p>
					<p id="time_detail"> </p>
					<p id="date_detail"></p>
				</div>
				<div class="col-md-6 col-sm-6">
					<h4 class="ap-heading">User Detail</h4>
					<p id="client_username_detail"></p>
					<p id="client_fullname_detail"></p>
					<p id="client_contact_detail"></p>
					<p id="client_email_detail"></p>
					<p id="client_skype_detail"></p>
				</div>
				<input type="hidden" class="ap_email_notification" name="ap_email_notification">
				<input type="hidden" class="ap_payment_customer" name="ap_payment_customer"/>
				<input type="hidden" class="ap_payment_staff" name="ap_payment_staff"/>
				<input type="hidden" class="ap_payment_date" name="ap_payment_date"/>
				<input type="hidden" class="ap_payment_service" name="ap_payment_service"/>
				<input type="hidden" class="ap_payment_amount" name="ap_payment_amount"/>
				<input type="hidden" class="ap_payment_staff_email" name="ap_payment_staff_email"/>
				<input type="hidden" class="ap_client_contact_detail" name="ap_client_contact_detail">
				<input type="hidden" class="appoint_staff_id" name="appoint_staff_id">
				<input type="hidden" class="ap_booking_start_time" name="ap_booking_start_time">
				<input type="hidden" class="ap_booking_end_time" name="ap_booking_end_time">
				<input type="hidden" class="client_email_address" name="client_email_address">
				<input type="hidden" class="appoint_unique_id" name="appoint_unique_id" value="<?php echo uniqid(); ?>">
				<input type="hidden" class="ap_payment_service_id" name="ap_payment_service_id"/>
				<div class="col-md-12 col-sm-12 confirm-link" id="appt_confirm">
					<p><strong>Do you want to Confirm Appointment ?</strong></p>
				</div>
				<?php  $confirm_editor_content= get_option("confirm_tips");
					if (!empty($confirm_editor_content)) {	?>
						<div class="col-md-12 step-description">
							<ul> <?php echo "<pre class='pre_bg' style='display:block !important;'>".$confirm_editor_content."</pre>"; ?>  </ul>
						</div>
				<?php } ?> 
			</div>
			
			<!-- Step 4 -->
			<div class="ap-step-link">
				<?php 
				$appearence_confirm_navigation_text_backward = $wpdb->get_col( "SELECT confirm_navigation_text_backward from $appearence_table" );
				$confirm_navigation_text_backward	= $appearence_confirm_navigation_text_backward[0]; 
				$appearence_confirm_navigation_text_forward = $wpdb->get_col( "SELECT confirm_navigation_text_forward from $appearence_table" );
				$confirm_navigation_text_forward	= $appearence_confirm_navigation_text_forward[0]; ?>
				<a id="stepback4" href="#step3" onclick="return step4_back();" class="btn step-left" data-toggle="tab" aria-expanded="false"><?php if (!empty($confirm_navigation_text_backward)) {  echo $confirm_navigation_text_backward; } else { echo "Back" ; } ?></a>
				<button id="stepnext4" name="stepnext4" href="#step5" type="button" onclick="return step4_next();" class="btn step-right"><?php if (!empty($confirm_navigation_text_forward)) { echo $confirm_navigation_text_forward; } else { echo "Next"; } ?></button> 
			</div>
		</form>
		<?php	
	} else { ?>
		<!-- Step 4 -->
		<script>
			jQuery.notify("<?php _e("Email Already Registered.",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
		</script>
		<div class="col-md-12 col-sm-12 ap-steps">
			<div class="col-md-2 col-sm-2 ap-step1 services complete">
				<label>1. Services</label>
					<span></span>
			</div>
			<div class="col-md-2 col-sm-2 ap-step2 time complete">
				<label>2. Time</label>
				<span></span>
			</div>
			<div class="col-md-2 col-sm-2 ap-step3 time active">
				<label>3. Details</label>
				<span></span>
			</div>
			<div class="col-md-2 col-sm-2 ap-step4 Details">
				<label>4. Confirm </label>
				<span></span>
			</div>
			<div class="col-md-2 col-sm-2 ap-step6 done">
				<label>5. Done</label>
				<span></span>
			</div>
		</div>
		
		<div class="col-md-12 col-sm-12 step3-form">
			<?php echo "<center><p>".__('The Email You Entered is already registered with us, Please Login Your Account.',WF_A_P_SYSTEM )."</center><br><center>".__('Thank You',WF_A_P_SYSTEM )."</center></p>";  ?>
		</div>		
		<?php  $detail_editor_content= get_option("details_tips");
		if (!empty($detail_editor_content)) {	?>
			<div class="row step-description">
				<div><?php echo "<pre class='pre_bg' style='display:block !important;'>".$detail_editor_content."</pre>"; ?></div> 
			</div>
		<?php } ?> 
		<div class="ap-step-link">
			<a id="stepnext2"  onclick="return step2_next();" class="btn step-right" data-toggle="tab" aria-expanded="false"><?php  echo __('Try Again',WF_A_P_SYSTEM );  ?></a>
		</div>
		<?php
	}
}
?>	  