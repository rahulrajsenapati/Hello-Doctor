<?php
// appointment shortcode second file
global $wpdb;
$appointment_staff_details = $wpdb->get_results( "select * from $wpdb->prefix"."apt_staff");
$apt_shortcode_service_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_services");
$appointment_category_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_category");
$appearence_table =	$wpdb->prefix."apt_appearence";
$settings_table =	$wpdb->prefix."apt_settings"; ?>

<script>
//global variables
var appointment_username;
var appointment_date;
var appointment_service;
var appointment_staff;
var appointment_time;
var appointment_first_name;
var appointment_last_name;
var appointment_client_password;
var appointment_client_contact;
var appointment_client_email;
var appointment_skype_id;
var appointment_login_email;
var appointment_login_password;
var appointment_staff_email;
var appointment_id;
var appt_date_format;
var appt_time_format;
var appointment_service_amount;

jQuery(window).on('load', function() {
   jQuery("#ap_fornt_main_div").show();
});

jQuery( document ).ready(function() {
    jQuery(".ap_class_active").hide();
});

//STEP 1 NEXT
jQuery(document).on("click", '#step1_next', function (event) {
	appointment_date= jQuery('#apt_date').val();
	var date = new Date(appointment_date);
	
	day_01= date.setDate(date.getDate());
	date_001 = new Date(day_01);
	var selected_date = date_001.toString().substr(0, 15);	
	
	appointment_service= jQuery('#groups').val();
	
	appointment_staff= jQuery('#sub_groups').val();
	
	var today_date = new Date();
	current_time = today_date.toString().substr(16,5);
	
	var current_date = new Date(appointment_date);
	var current_day = current_date.getDay();
	
	if(appointment_service=='default'){
		jQuery.notify("<?php _e("Please Select Service",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
		jQuery('#service_name').focus();
		document.getElementById("step1").style.opacity = "1";
	}
	else if(appointment_staff=='0'){
		jQuery.notify("<?php _e("Please Select Staff",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
		jQuery('#staff_member').focus();
		document.getElementById("step1").style.opacity = "1";
	}
	else if(appointment_date==''){
		jQuery.notify("<?php _e("Please Select date",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
		jQuery('#apt_date').focus();
		document.getElementById("step1").style.opacity = "1";
	} else {
		var current_url = jQuery(location).attr('href');
		
		jQuery('#img-thumbnail').removeClass('img-thumbnail ap-dashboard ap-front');
		jQuery('#img-thumbnail').addClass('img-thumbnail ap-dashboard');
		 
		jQuery("#step1_next").prop('disabled', true);
		jQuery('#step1_next').html('<i class="fa fa-spinner fa-spin"></i><?php _e("Please Wait",WF_A_P_SYSTEM ); ?> ');
		
		jQuery.ajax({
			type : 'post',
			url : frontendajax.ajaxurl+'?action=time_ajax_request',  
			data :  'apt_dates='+ appointment_date  + '&service='+ appointment_service + '&staff_member='+ appointment_staff  + '&date_label='+ selected_date  + '&current_time='+ current_time + '&current_url='+ current_url, 
			success : function(data){
				jQuery("#step1_next").prop('disabled', false);
				jQuery('#step1_next').html('Next');
				jQuery('#form_02').html(data);
				jQuery('#step2').show();
				jQuery('#step1').hide();
				jQuery('#step3').hide();
				jQuery('#step4').hide();
				jQuery('#step5').hide();
				jQuery('#step6').hide();
			}
		});
	}
});
	
function step2_next(){
	var appt_date_format = jQuery('#appt_date_format').val();
	jQuery('.date_tag').text(appt_date_format);
	<?php 
	$staff_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_staff");
	foreach($staff_details as $staff_detail) {
		$staff_id=$staff_detail->id; 
		$staff_name=$staff_detail->staff_member_name;
		?>
		if(appointment_staff=='<?php echo $staff_id;?>'){
			jQuery('.staff_tag').text('<?php echo $staff_name;?>');
		}
	<?php } ?>
	
	var checked_radio = jQuery('input[name=ap_time]:checked');
	var appointment_time = checked_radio.val();
	
	var appt_time_format = checked_radio.attr("title");
	jQuery('.time_tag').text(appt_time_format);
	
	if(jQuery('.radio_button').is(':checked')) {
		
		document.getElementById("stepnext2").href="#step3";
		jQuery("#stepnext2").prop('disabled', true);
		jQuery('#stepnext2').html('<i class="fa fa-spinner fa-spin"></i> <?php _e("Please Wait",WF_A_P_SYSTEM ); ?>');
		
		jQuery.ajax({
			type : 'post',
			url : frontendajax.ajaxurl+'?action=details_ajax_request',  
			data :  'apt_time='+ appointment_time  + '&service='+ appointment_service + '&time_format='+ appt_time_format + '&staff_member='+ appointment_staff + '&apt_date='+ appointment_date , 
			success : function(data){
				jQuery("#stepnext2").prop('disabled', false);
				jQuery('#stepnext2').html('<?php _e("Next",WF_A_P_SYSTEM ); ?>');

				jQuery('#user_details').html(data);
				jQuery('#step3').show();
				jQuery('#step1').hide();
				jQuery('#step2').hide();
				jQuery('#step4').hide();
				jQuery('#step5').hide();
				jQuery('#step6').hide();
			}
		});
	} else {
		jQuery.notify("<?php _e("Please Select Appointment Time",WF_A_P_SYSTEM ); ?>", {class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
	}
}

function step2_back(){
	jQuery('.stp-duration').empty();
	//jQuery('form#step_01')[0].reset();
	jQuery('#step1').show();
	jQuery('#step2').hide();
	jQuery('#step3').hide();
	jQuery('#step4').hide();
	jQuery('#step5').hide();
	jQuery('#step6').hide();
}	
	

function step3_next(){ 
	var login_button = document.getElementById("appoint_login");
	if (login_button.clicked == true) { 
	} else {
		jQuery.notify("<?php _e("Please Login Your Account",WF_A_P_SYSTEM ); ?>", { class:"alert_box", type:"danger", align:"center", verticalAlign:"middle"});
	}
}   
 
function step3_back(){
	jQuery('#step2').show();
	jQuery('#step1').hide();
	jQuery('#step3').hide();
	jQuery('#step4').hide();
	jQuery('#step5').hide();
	jQuery('#step6').hide();
}	
	
function step4_next(){
	var appointment_id= jQuery('.appoint_unique_id').val();
	var selected_service= jQuery('.ap_payment_service_id').val();				
	jQuery("#stepnext4").prop('disabled', true);
	jQuery('#stepnext4').html('<i class="fa fa-spinner fa-spin"></i> Please Wait');
	jQuery.ajax({
		type: "POST",
		data: jQuery("form#confirm_appointment").serialize(),
		dataType: "html",
		//Do not cache the page
		cache: false,
		//success
		success: function (html) {
			jQuery("#stepnext4").prop('disabled', false);
			jQuery('#stepnext4').html('<?php _e("Save",WF_A_P_SYSTEM ); ?>');

			jQuery('#step6').show();
			jQuery('#step1').hide();
			jQuery('#step2').hide();
			jQuery('#step3').hide();
			jQuery('#step4').hide();
			jQuery('#step5').hide();
		}
	});
}
	
function step4_back(){
	jQuery('#step3').show();
	jQuery('#step1').hide();
	jQuery('#step2').hide();
	jQuery('#step4').hide();
	jQuery('#step5').hide();
	jQuery('#step6').hide();
}
function step6_back(){
	jQuery('#step5').show();
	jQuery('#step1').hide();
	jQuery('#step2').hide();
	jQuery('#step3').hide();
	jQuery('#step4').hide();
	jQuery('#step6').hide();
}

function step7_booknew(){
	jQuery('select option[value="default"]').attr("selected",true);
	jQuery('#step1').show();
	jQuery('#step2').hide();
	jQuery('#step3').hide();
	jQuery('#step4').hide();
	jQuery('#step5').hide();
	jQuery('#step6').hide();
}

function New(){
	jQuery('#new').show();
	jQuery('#existing').hide();
}
	
function existing(){
	jQuery('form#ap_login')[0].reset();
	jQuery('#existing').show();
	jQuery('#new').hide();		
}

//CONTACT PICKER	
jQuery(document).ajaxComplete(function(){
	jQuery(".phone").intlTelInput();
});
</script>
<?php	
$admin_info = get_userdata(1);
$admin_user_login= $admin_info->first_name . " " . $admin_info->last_name;

$first_name=  $admin_info->first_name; 
$last_name= $admin_info->last_name;
if (!empty($first_name) && !empty($last_name)){
	$admin_user_login= $admin_info->first_name . " " . $admin_info->last_name;
} else {
	$admin_user_login = $admin_info->user_login;
}

$site_url=get_site_url();
$blog_name= get_bloginfo();
$email_settings= get_option("Appoint_notification");
 
//BOOK APPOINTMENT & SEND EMAIL
if(isset($_REQUEST['appoint_staff_id'])) {
	$ap_customer_name = sanitize_text_field( $_REQUEST['ap_payment_customer'] );
	$ap_staff_id = sanitize_text_field( $_REQUEST['appoint_staff_id'] );
	$ap_service_name = sanitize_text_field( $_REQUEST['ap_payment_service'] );
	$ap_client_contact_detail = sanitize_text_field( $_REQUEST['ap_client_contact_detail'] );
	$temp_date = sanitize_text_field( $_REQUEST['ap_payment_date'] );
	$ap_booking_date = date("Y-m-d", strtotime($temp_date));
	$ap_start_time = sanitize_text_field( $_REQUEST['ap_booking_start_time'] );
	$temp_time = sanitize_text_field( $_REQUEST['ap_booking_end_time'] );
	$endTime = strtotime('+'.$temp_time, strtotime($ap_start_time));
	$ap_booking_end_time= date('H:i', $endTime);

	$client_email_address = sanitize_text_field( $_REQUEST['client_email_address'] );
	$appoint_unique_id = sanitize_text_field( $_REQUEST['appoint_unique_id'] );
	$ap_payment_staff_email = sanitize_text_field( $_REQUEST['ap_payment_staff_email'] );

	$table_name =$wpdb->prefix ."apt_appointments";
	$Insert_Appointments="INSERT INTO `$table_name` (`id` ,client_name,`staff_member` ,`service_type` ,`contact` ,`booking_date` ,`start_time` ,`end_time` ,`status` ,`client_email`, `appt_unique_id` , `staff_email`, `appt_booked_by` , `repeat_appointment`) VALUES ('NULL', '$ap_customer_name', '$ap_staff_id', '$ap_service_name', '$ap_client_contact_detail', '$ap_booking_date', '$ap_start_time', '$ap_booking_end_time', 'pending', '$client_email_address', '$appoint_unique_id', '$ap_payment_staff_email','by_user','Non');";

	$wpdb->query($Insert_Appointments);
	
	$temp_staff_member_name = $wpdb->get_col( "SELECT staff_member_name from $wpdb->prefix"."apt_services  WHERE id='$appoint_staff_id'" ); 
	$ap_staff_name	= $temp_staff_member_name[0];	

	$notification_enable= $email_settings['enable'];
	$notification_emailtype= $email_settings['emailtype'];	
	
	$time_format = get_option( 'time_format' );
	$temp_ap_start_time = strtotime($ap_start_time);
	$appt_start_time=	date($time_format, $temp_ap_start_time);

	$temp_ap_end_time = strtotime($ap_booking_end_time);
	$appt_end_time=	date($time_format, $temp_ap_end_time);
	
	$appointment_time= $appt_start_time . "-" . $appt_end_time;
	
	$date_format = get_option( 'date_format' );
	$appt_date=date($date_format, strtotime($ap_booking_date));	
		
	if($notification_enable =="yes" ) {
		//PHP MAIL
		if($notification_emailtype=="phpmail") {
			$notification_admin_email_php= $email_settings['phpemail'];
			if($notification_admin_email_php !=="") {
				//ADMIN PENDING
				$notification_admin_pending= $email_settings['send_notification_admin_pending'];
				if($notification_admin_pending=="yes") {
						$temp_notification_subject_admin_pending= $email_settings['subject_admin_pending'];
						$notification_subject_admin_pending =  strtr($temp_notification_subject_admin_pending, array( 
							'[SERVICE_NAME]'	=>	$ap_service_name,
							'[APPOINTMENT_DATE]'	=>	$appt_date,
							'[APPOINTMENT_TIME]'	=>	$appointment_time,
							'[CLIENT_NAME]'		=>	$ap_customer_name,
							'[CLIENT_EMAIL]'	=>	$client_email_address,
							'[APPOINTMENT_STATUS]'	=>	'pending',
							'[ADMIN_NAME]'	=>	$admin_user_login,
							'[BLOG_NAME]'	=>	$blog_name,
							'[SITE_URL]'		=> $site_url
						));
						
						$temp_notification_body_admin_pending= $email_settings['admin_body_pending'];
						$notification_body_admin_pending =  strtr($temp_notification_body_admin_pending, array( 
							'[SERVICE_NAME]'	=>	$ap_service_name,
							'[APPOINTMENT_DATE]'	=>	$appt_date,
							'[APPOINTMENT_TIME]'	=>	$appointment_time,
							'[CLIENT_NAME]'		=>	$ap_customer_name,
							'[CLIENT_EMAIL]'	=>	$client_email_address,
							'[APPOINTMENT_STATUS]'	=>	'pending',
							'[ADMIN_NAME]'	=>	$admin_user_login,
							'[BLOG_NAME]'	=>	$blog_name,
							'[SITE_URL]'		=> $site_url
						));
						
						if($notification_subject_admin_pending !=="" &&  $notification_body_admin_pending !==""){
							$to_admin_email_pending = $notification_admin_email_php;
							$subject_admin_pending = $notification_subject_admin_pending;
							$body_admin_pending = $notification_body_admin_pending;
							$from_admin_email = $notification_admin_email_php;
							$header = "From: $admin_user_login <$from_admin_email>" . "\r\n";
							$mail_check_client_pending = mail ($to_admin_email_pending,$subject_admin_pending,$body_admin_pending,$header);
						}					
				}
				
				//CLIENT PENDING
				$notification_client_pending= $email_settings['send_notification_client_pending'];
				if($notification_client_pending=="yes") {
					$temp_notification_subject_client_pending= $email_settings['subject_notification_client_pending'];
					$notification_subject_client_pending =  strtr($temp_notification_subject_client_pending, array( 
						'[SERVICE_NAME]'	=>	$ap_service_name,
						'[APPOINTMENT_DATE]'	=>	$appt_date,
						'[APPOINTMENT_TIME]'	=>	$appointment_time,
						'[CLIENT_NAME]'	=>	$ap_customer_name,
						'[CLIENT_EMAIL]'	=>	$client_email_address,
						'[APPOINTMENT_STATUS]'	=>	'pending',
						'[ADMIN_NAME]'	=>	$admin_user_login,
						'[BLOG_NAME]'	=>	$blog_name,
						'[SITE_URL]'	 => $site_url
					));
					$temp_notification_body_client_pending= $email_settings['body_notification_client_pending'];
					$notification_body_client_pending =  strtr($temp_notification_body_client_pending, array( 
						'[SERVICE_NAME]'	=>	$ap_service_name,
						'[APPOINTMENT_DATE]'	=>	$appt_date,
						'[APPOINTMENT_TIME]'	=>	$appointment_time,
						'[CLIENT_NAME]'	=>	$ap_customer_name,
						'[CLIENT_EMAIL]'	=>	$client_email_address,
						'[APPOINTMENT_STATUS]'	=>	'pending',
						'[ADMIN_NAME]'	=>	$admin_user_login,
						'[BLOG_NAME]'	=>	$blog_name,
						'[SITE_URL]'	 => $site_url
					));

					if($notification_subject_client_pending !=="" &&  $notification_body_client_pending !==""){
						$to_client_email_pending = $client_email_address;
						$subject_client_pending = $notification_subject_client_pending;
						$body_client_pending = $notification_body_client_pending;
						$from_admin_email = $notification_admin_email_php;
						$header = "From: $admin_user_login <$from_admin_email>" . "\r\n";
						$mail_check_client_pending = mail ($to_client_email_pending,$subject_client_pending,$body_client_pending,$header);
					}						
				}
			}
		}		
	}
}
?>
<div class="ap_wrapper1">
	<div id="img-thumbnail" class="img-thumbnail ap-dashboard ap-front">
		<div id="preloader">
			<div id="preloader-inner"></div>
		</div>
		<div id="change-loader" class="change-loader" style="display:none">
			<div id="change-loader-inner"></div>
		</div>
	    <div id="ap_fornt_main_div" style="display:none;">  
			<div class="row ap-logo">
				<?php
				$appearence_ap_show_logo = $wpdb->get_col( "SELECT ap_show_logo from $appearence_table" );
				$ap_show_logo	= $appearence_ap_show_logo[0];
				if($ap_show_logo=="yes") { ?>
					<div class="col-md-3 logo">
						<?php	$appearence_ap_logo = $wpdb->get_col( "SELECT ap_logo from $appearence_table" );
						$ap_logo	= $appearence_ap_logo[0]; ?>
						<img src="<?php  echo $ap_logo;  ?>" class="img-responsive" alt=""/>
					</div>
				<?php } ?>
				<div class="col-md-6 contact-info">
					<?php
						$settings_b_name = $wpdb->get_col( "SELECT b_name from $settings_table" );
						$b_name	= $settings_b_name[0];
						$blog_title = get_bloginfo( 'name' ); 
						
						$appearence_ap_phone_icon = $wpdb->get_col( "SELECT ap_phone_icon from $appearence_table" );
						$ap_phone_icon	= $appearence_ap_phone_icon[0];

						$appearence_ap_phone_no= $wpdb->get_col( "SELECT ap_phone_no from $appearence_table" );
						$ap_phone_no	= $appearence_ap_phone_no[0];?>
					<label id="business_name"><?php  if($b_name==""){ echo  __($blog_title,WF_A_P_SYSTEM );   } else{ echo __($b_name,WF_A_P_SYSTEM );   } ?></label><br>	
					<?php
					$current_date=date('d-m-Y');
					$current_day= date("D",strtotime($current_date));
					
					if($current_day=="Mon"){
						$settings_bh_monday_st = $wpdb->get_col( "SELECT bh_monday from $settings_table" );
						$monday = unserialize($settings_bh_monday_st[0]); 
						$start_time= $monday[0]['start_time'];
						$end_time= $monday[0]['end_time'];
					}
					if($current_day=="Tue"){
						$settings_bh_tuesday_st = $wpdb->get_col( "SELECT bh_tuesday from $settings_table" ); 
						$tuesday= unserialize($settings_bh_tuesday_st[0]);
						$start_time= $tuesday[0]['start_time'];
						$end_time= $tuesday[0]['end_time'];
					}
					if($current_day=="Wed"){
						$settings_bh_wednesday_st = $wpdb->get_col( "SELECT bh_wednesday from $settings_table" ); 
						$wednesday= unserialize($settings_bh_wednesday_st[0]);
						$start_time= $wednesday[0]['start_time'];
						$end_time= $wednesday[0]['end_time'];
					}
					if($current_day=="Thu"){
						$settings_bh_thursday_st = $wpdb->get_col( "SELECT bh_thursday from $settings_table" ); 
						$thursday= unserialize($settings_bh_thursday_st[0]);
						$start_time= $thursday[0]['start_time'];
						$end_time= $thursday[0]['end_time'];
					}
					if($current_day=="Fri"){
						$settings_bh_friday_st = $wpdb->get_col( "SELECT bh_friday from $settings_table" ); 
						$friday	= unserialize($settings_bh_friday_st[0]);
						$start_time= $friday[0]['start_time'];
						$end_time= $friday[0]['end_time'];
					}
					if($current_day=="Sat"){
						$settings_bh_saturday_st = $wpdb->get_col( "SELECT bh_saturday from $settings_table" ); 
						$saturday = unserialize($settings_bh_saturday_st[0]);
						$start_time= $saturday[0]['start_time'];
						$end_time= $saturday[0]['end_time'];
					}
					if($current_day=="Sun"){
						$settings_bh_sunday_st = $wpdb->get_col( "SELECT bh_sunday from $settings_table" ); 
						$sunday	= unserialize($settings_bh_sunday_st[0]);
						$start_time= $sunday[0]['start_time'];
						$end_time= $sunday[0]['end_time'];
					}								
					$time_format = get_option( 'time_format' ); 
					$biz_st = strtotime($start_time);
					$biz_et = strtotime($end_time);
						
					$biz_start_time=	date($time_format, $biz_st);
					$biz_end_time=	date($time_format, $biz_et);									
					?>
					<span class="bs_opening_hours"><i class="fa fa-clock-o"></i> <?php /* _e("Timing:",WF_A_P_SYSTEM ); */ echo " ".$biz_start_time; echo " - "; echo $biz_end_time;?></span><br>
					<?php
					$appearence_ap_email_icon = $wpdb->get_col( "SELECT ap_email_icon from $appearence_table" );
					$ap_email_icon	= $appearence_ap_email_icon[0];

					$appearence_ap_email= $wpdb->get_col( "SELECT ap_email from $appearence_table" );
					$ap_email	= $appearence_ap_email[0];
					
					$appearence_ap_show_phone_no = $wpdb->get_col( "SELECT ap_show_phone_no from $appearence_table" );
					$ap_show_phone_no	= $appearence_ap_show_phone_no[0];
					
					
					if($ap_show_phone_no=="yes"){ ?>
					<span class="phone_number_info"><i class="<?php  echo $ap_phone_icon; ?>"></i> <?php  echo $ap_phone_no; ?></span><br>
					<?php }
					
					$appearence_ap_show_email = $wpdb->get_col( "SELECT ap_show_email from $appearence_table" );
					$ap_show_email	= $appearence_ap_show_email[0];
					if($ap_show_email=="yes"){ ?>
						<span class="email_address_info"><i class="<?php  echo $ap_email_icon; ?>"></i> <?php  echo $ap_email; ?></span>
					<?php
					}					
					
					?>
				</div>
				<div class="col-md-3 social-info">
					<ul class="social">
						<?php 
						$appearence_ap_social_link1 = $wpdb->get_col( "SELECT ap_social_link1 from $appearence_table" );
						$ap_social_link1	= $appearence_ap_social_link1[0];
						
						$appearence_ap_social_icon1 = $wpdb->get_col( "SELECT ap_social_icon1 from $appearence_table" );
						$ap_social_icon1= $appearence_ap_social_icon1[0];
						
						$appearence_ap_social_link2 = $wpdb->get_col( "SELECT ap_social_link2 from $appearence_table" );
						$ap_social_link2	= $appearence_ap_social_link2[0];
						
						$appearence_ap_social_icon2 = $wpdb->get_col( "SELECT ap_social_icon2 from $appearence_table" );
						$ap_social_icon2	= $appearence_ap_social_icon2[0];
						
						$appearence_ap_social_link3 = $wpdb->get_col( "SELECT ap_social_link3 from $appearence_table" );
						$ap_social_link3= $appearence_ap_social_link3[0];
						
						$appearence_ap_social_icon3 = $wpdb->get_col( "SELECT ap_social_icon3 from $appearence_table" );
						$ap_social_icon3= $appearence_ap_social_icon3[0];
						
						$appearence_ap_sl_pinterest = $wpdb->get_col( "SELECT ap_social_link4 from $appearence_table" );
						$ap_social_link4= $appearence_ap_sl_pinterest[0];
						
						$appearence_ap_social_icon4 = $wpdb->get_col( "SELECT ap_social_icon4 from $appearence_table" );
						$ap_social_icon4= $appearence_ap_social_icon4[0];
						
						$appearence_ap_social_link5 = $wpdb->get_col( "SELECT ap_social_link5 from $appearence_table" );
						$ap_social_link5	= $appearence_ap_social_link5[0];
						
						$appearence_ap_social_icon5 = $wpdb->get_col( "SELECT ap_social_icon5 from $appearence_table" );
						$ap_social_icon5= $appearence_ap_social_icon5[0];
						?>
						<?php if (!empty($ap_social_link1)) { ?><li><a href="<?php  echo $ap_social_link1; ?>"><i class="<?php echo $ap_social_icon1; ?>"></i></a></li> <?php } ?>
						<?php if (!empty($ap_social_link2)) { ?><li><a href="<?php  echo $ap_social_link2; ?>"><i class="<?php echo $ap_social_icon2; ?>"></i></a></li><?php } ?>
						<?php if (!empty($ap_social_link3)) { ?><li><a href="<?php  echo $ap_social_link3; ?>"><i class="<?php echo $ap_social_icon3; ?>"></i></a></li><?php } ?>
						<?php if (!empty($ap_social_link4)) { ?><li><a href="<?php  echo $ap_social_link4; ?>"><i class="<?php echo $ap_social_icon4; ?>"></i></a></li><?php } ?>
						<?php if (!empty($ap_social_link5)) { ?><li><a href="<?php  echo $ap_social_link5; ?>"><i class="<?php echo $ap_social_icon5; ?>"></i></a></li><?php } ?>
					</ul>							
				</div>
			</div>
						
			<div id="step1">
				<div class="col-md-12 col-sm-12  ap-steps">
					<div class="col-md-2 col-sm-2 col-xm-12 ap-step1 services active">
						<label><?php _e("1. Services",WF_A_P_SYSTEM ); ?></label>
						<span></span>
					</div>
					<div class="col-md-2 col-sm-2 ap-step2 time">
						<label><?php _e("2. Time",WF_A_P_SYSTEM ); ?></label>
						<span></span>
					</div>
					<div class="col-md-2 col-sm-2 ap-step3 time">
						<label><?php _e("3. Details",WF_A_P_SYSTEM ); ?></label>
						<span></span>
					</div>
					<div class="col-md-2 col-sm-2 ap-step4 Details">
						<label><?php _e("4. Confirm",WF_A_P_SYSTEM ); ?></label>
						<span></span>
					</div>
					
					<div class="col-md-2 col-sm-2 ap-step6 done">
						<label><?php _e("5. Done",WF_A_P_SYSTEM ); ?></label>
						<span></span>
					</div>
				</div>
				
				<!-- Step 1 -->
				<form style="margin-bottom: 0;" action="" method="POST" id="step_01" name="step_01">
					<div  id="1" class="ap-steps-detail">
						<div class="row service-form">
							<div class="col-md-6 col-sm-6 ap-category">
								<label><?php _e("Services",WF_A_P_SYSTEM ); ?></label>
								<select class="form-control "  id="groups" name="service_name" >
									<option value='default'><?php _e("--Select--",WF_A_P_SYSTEM ); ?></option>
									<?php 
										$settings_table =	$wpdb->prefix."apt_settings";
										$settings_payment_currency = $wpdb->get_col( "SELECT currency from $settings_table" ); 
										$payment_currency	= $settings_payment_currency[0];
										foreach($appointment_category_details as $appointment_category_single_detail) { ?>
											<optgroup label="<?php echo $appointment_category_single_detail->name;?>">
												<?php $service_table=	$wpdb->prefix."apt_services";
												$appointment_details = $wpdb->get_results( "SELECT * from $service_table where category= '$appointment_category_single_detail->id'");  
												foreach($appointment_details as $appointment_single_detail){	?>
													<option value="<?php echo $appointment_single_detail->id ?>" > <?php _e($appointment_single_detail->name,WF_A_P_SYSTEM ); ?>(<?php echo $appointment_single_detail->price ?><?php if ($payment_currency==""){echo ' USD';} else{ echo ' '.$payment_currency;} ?>)</option>
												<?php } ?>
											</optgroup>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-4 col-sm-6 ap-employee" style="display:none">
								<label>Employee</label>
								<select class="form-control staff" id="sub_groups"  name="staff_member"   >
									<?php foreach($appointment_staff_details as $appointment_single_detail){ ?>
									<option  value="<?php echo $appointment_single_detail->id;?>"><?php echo $appointment_single_detail->staff_member_name;?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-6 col-sm-6 ap-dates">
								<label><?php _e('Appointment Date',WF_A_P_SYSTEM ); ?></label>
								<input id="apt_date" name="apt_date" placeholder="Select date @eg <?php echo $date = date('m/d/Y'); ?>" class="form-control ap-date"  type="text"/>
							</div>
						</div>
					
						<?php $service_editor_content= get_option("service_tips");
						if (!empty($service_editor_content)) {	?>
							<div class="row step-description">
								<div> <?php echo "<pre class='pre_bg' style='display:block !important;'>" ?><?php _e($service_editor_content,WF_A_P_SYSTEM ); ?><?php echo "</pre>" ?>  </div> 
							</div>
						<?php } ?> 
					</div>
					<!-- Step 1 -->
					<div class="ap-step-link">
					<?php $appearence_service_navigation_text = $wpdb->get_col( "SELECT service_navigation_text from $appearence_table" );
							$service_navigation_text	= $appearence_service_navigation_text[0]; ?>
						<button id="step1_next" type="button" class="btn step-right"><?php if (!empty($service_navigation_text)) {    _e($service_navigation_text,WF_A_P_SYSTEM );    } else { _e("Next",WF_A_P_SYSTEM );  } ?></button> 
					</div>
				</form>
			</div>

			<!-- Step 2 -->
			<div id="step2" class="ap_class_active">
				<div id="form_02"></div>
			</div>
			
			<!-- Step 3 -->
			<div id="step3" class="ap_class_active">
				<div id="user_details"></div>
			</div>
			
			<!-- Step 4 -->
			<div id="step4" class="ap_class_active">
			</div>

			<!-- Step 6 -->
			<div id="step6" class="ap_class_active">
				<div class="col-md-12 col-sm-12 ap-steps">
					<div class="col-md-2 col-sm-2 ap-step1 services complete">
						<label><?php _e('1. Services',WF_A_P_SYSTEM ); ?></label>
						<span></span>
					</div>
					<div class="col-md-2 col-sm-2 ap-step2 time complete">
						<label><?php _e('2. Time',WF_A_P_SYSTEM ); ?></label>
						<span></span>
					</div>
					<div class="col-md-2 col-sm-2 ap-step3 time complete">
						<label><?php _e('3. Details',WF_A_P_SYSTEM ); ?></label>
						<span></span>
					</div>
					<div class="col-md-2 col-sm-2 ap-step4 Details complete">
						<label><?php _e('4. Confirm',WF_A_P_SYSTEM ); ?> </label>
						<span></span>
					</div>
					<div class="col-md-2 col-sm-2 ap-step5 done active">
						<label><?php _e('5. Done',WF_A_P_SYSTEM ); ?></label>
						<span></span>
					</div>
				</div>
				
				<!-- Step 6 -->
				<div id="6" class="ap-steps-detail6">
					<?php $appearence_done_page_icon = $wpdb->get_col( "SELECT done_page_icon from $appearence_table" );
					$done_page_icon	= $appearence_done_page_icon[0]; ?>
					<?php  if (!empty($done_page_icon)) { ?><i class="<?php echo $done_page_icon; ?>"></i><?php  }  ?>
					<?php  $done_editor_content= get_option("done_tips");
					if (!empty($done_editor_content)) {	?>
					<div class="row step-description">
						<div> <?php echo "<pre class='pre_bg' style='display:block !important;'>".$done_editor_content."</pre>"; ?> </div> 
					</div>
					<?php } else { ?>
					<h4 class="ap-heading"><?php  _e('Booking Done',WF_A_P_SYSTEM );    ?></h4>
					<div class="row service-form">
						<p> <?php _e("Thank You! Your Booking Is Complete.",WF_A_P_SYSTEM ); ?></p>
					</div>					
					<?php } ?>
					<div class="row">
						<div class="col-md-12">
							<a class="btn btn-primary" href="#step1" onclick="return step7_booknew();"><?php _e('Book Another Appointment', WF_A_P_SYSTEM); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>		
	</div>
</div>
<?php 
	$holiday_table =	$wpdb->prefix."apt_holidays";
	$business_holidays1 = $wpdb->get_results( "SELECT * from $holiday_table" );
	$weeks_repeat1 = $wpdb->get_var("SELECT COUNT(*) from $holiday_table where repeat_value ='weekly' ");
	$num  = $wpdb->num_rows;
 ?>
 <script>
 	console.log("45");
 	console.log(<?php echo $num; ?>);
 </script>
<style>
	.staff_tag {
		display:none !important;
	}
	#appointment_booking_request{
		margin-left:10px !important;
	}
	.ap-steps {
		text-align: center;
	}
	#staff_off_text {
		color: #337ab7 !important;
	}
	.alert_box{
	   background: #304CD8;
	   background: -webkit-linear-gradient(left, #304CD8 0%, #9F3762 100%);
	   background: -ms-linear-gradient(left, #304CD8 0%, #9F3762 100%);
	   background: linear-gradient(to right, #304CD8 0%, #9F3762 100%);
	   color: #fff;
	   font-size: 25px;
	   padding: 35px;
	   text-align: center;
	}
	#dd-w-0 .dd-c .dd-s{
		background:#337ab7 !important;
	}
	.step3-form {
		min-height: 90px !important;
	}
	#date_01{
		height:70px !important;
		width: 100%;
		border-radius: 5px;
		text-align:center;
	}
	.ap-steps-detail1 p {
		float:left !important;
	}
	.ap-steps-detail3 p {
		float:left !important;
	}
	.swiper-container{
		overflow:visible !important;
	}
	.signup-info{
		clear:both !important;
	}
	.service_tag, .staff_tag, .date_tag, .service_price_tag, .time_tag {
		font-style: oblique !important;
	}
	#date_01{
		font-size:30px !important;
	}
	.b_closed{
		font-size:25px !important;
	}
	input[type="tel"]{
		padding-left: 50px !important;
	}
	#business_name{
		font-size:18px !important;
	}
	#appoint_register, #appoint_login{
		color: #fff !important;
		background-color: #f0ad4e !important;;
		border-color: #eea236 !important;;
	}
	#register_button{
		color: #fff !important;
		background-color: #c9302c !important;
		border-color: #ac2925 !important; 
	}
	#login_button{
		color: #fff !important;
		background-color: #449d44 !important;
		border-color: #398439 !important;
	}
	#img-thumbnail img{
		transform: none !important;
		transition: none !important;
	}
	<?php 
	$appearence_ap_theme_color = $wpdb->get_col( "SELECT ap_bg_color from $appearence_table" ); 
	$ap_theme_color	= $appearence_ap_theme_color[0];?>
	.ap-steps .active span , .ap-steps .complete span, .ap-step-link .step-right,.ap-step-link .step-left, .aps-date .tm-value,.step4-form .save ,.social-info .social li{
		background-color:<?php echo $ap_theme_color;?> !important;
	}
	<?php if (!empty($ap_theme_color)) { ?>
	.ap-dashboard .form-control:focus, .stp-duration li {
		border: 2px solid <?php echo $ap_theme_color;?> !important;
	}
	<?php } ?>
	.stp-duration .tm-value {
		color: <?php echo $ap_theme_color;?> !important;
	}
	<?php $appearence_ap_progress_bar = $wpdb->get_col( "SELECT ap_progress_bar from $appearence_table" );
	$ap_progress_bar	= $appearence_ap_progress_bar[0];
	if($ap_progress_bar=="no"){ ?>
	.col-md-12.col-sm-12.ap-steps{
		display:none !important;
	}
	<?php }	
	$appearence_ap_logo_width = $wpdb->get_col( "SELECT ap_logo_width from $appearence_table" );
	$ap_logo_width	= $appearence_ap_logo_width[0];

	$appearence_ap_logo_height = $wpdb->get_col( "SELECT ap_logo_height from $appearence_table" );
	$ap_logo_height	= $appearence_ap_logo_height[0];
	?>

	.logo img {
		height: <?php echo $ap_logo_height;?>px !important;
		width: <?php echo $ap_logo_width;?>px !important;
	}

	<?php if ( !wp_is_mobile() ) { ?>
	#ap_slots{
		width:24% !important;
	}

	.social-info {
		margin-top: 80px !important;
	} 
	<?php } else { ?>
	#ap_slots{
		width:31% !important;
	}	
	<?php } ?>

	.pre_bg {
		background-color:white !important;
	}
	div#existing:focus ,div#new:focus {
		outline: none !important;
	}

	<?php 
	$temp_custom_css = $wpdb->get_col( "SELECT custom_css from $settings_table" ); 
	$appt_custom_css= $temp_custom_css[0];
	if(isset($appt_custom_css)) echo $appt_custom_css; ?>
</style>

<script>
<?php
//DISABLE BUSINESS OFF DATES
$holiday_table =	$wpdb->prefix."apt_holidays";
$business_holidays = $wpdb->get_results( "SELECT * from $holiday_table" );
$total_holidays = array();
/*function Declartion for OFF*/
	/*week off*/
function appt_week_off($start, $end, $format = 'm/d/Y') {
	$array = array();
	$interval = new DateInterval('P7D');

	$realEnd = new DateTime($end);
	$realEnd->add($interval);

	$period = new DatePeriod(new DateTime($start), $interval, $realEnd);

	foreach($period as $date) { 
		$array[] = $date->format($format); 
	}
	return $array;
}

	/*particular day off*/
function appt_pd_off($start, $end, $format = 'm/d/Y') {
	$array = array();
	$interval = new DateInterval('P1D');

	$realEnd = new DateTime($end);
	$realEnd->add($interval);
	$period = new DatePeriod(new DateTime($start), $interval, $realEnd);

	foreach($period as $date) { 
		$array[] = $date->format($format); 
	}
	return $array;
}

	/*daily off*/
function appt_daily_off($start, $end, $format = 'm/d/Y') {
	$array = array();
	$interval = new DateInterval('P1D');

	$realEnd = new DateTime($end);
	$realEnd->add($interval);

	$period = new DatePeriod(new DateTime($start), $interval, $realEnd);

	foreach($period as $date) { 
		$array[] = $date->format($format); 
	}
	return $array;
}
	/*Bi weekly*/
function appt_bi_weekly($start, $end, $format = 'm/d/Y') {
	$array = array();
	$interval = new DateInterval('P14D');

	$realEnd = new DateTime($end);
	$realEnd->add($interval);

	$period = new DatePeriod(new DateTime($start), $interval, $realEnd);

	foreach($period as $date) { 
		$array[] = $date->format($format); 
	}
	return $array;
}
/*function declration end*/

if (!empty($business_holidays)) {
	//it fetches full day off with no repeat
	$full_day_off = $wpdb->get_col("SELECT holiday_date FROM $holiday_table where repeat_value='no' AND all_off='1'"); 
	if (!empty($full_day_off)) {
		array_push($total_holidays,$full_day_off );
	}
	foreach($business_holidays as $business_holiday) {
		//p_d particulate dates start date and end date different
		if($business_holiday->repeat_value=="p_d" && $business_holiday->all_off=="1") {
			$date_start=date("m/d/Y", strtotime($business_holiday->start_date));
			$date_end=date("m/d/Y", strtotime($business_holiday->end_date));			
			// Call the function
			$date_period = appt_pd_off($date_start, $date_end); 
			array_push($total_holidays,$date_period );
		}	
	
		if($business_holiday->repeat_value =="daily" && $business_holiday->all_off=="1") {
			$holiday_start_date=date("m/d/Y", strtotime($business_holiday->holiday_date));  
			$temp_add_days=$business_holiday->repeat_days;
			$add_days= $temp_add_days ;
			$holiday_end_date = date('m/d/Y',strtotime($holiday_start_date) + (24*3600*$add_days)); 			
			$date_range = appt_daily_off($holiday_start_date, $holiday_end_date);
			array_push($total_holidays,$date_range );
		}
			
		if($business_holiday->repeat_value =="weekly" && $business_holiday->all_off=="1") {
			$temp_weekz=$business_holiday->repeat_weeks;
			$weekz= $temp_weekz;
			$start_date= $business_holiday->holiday_date;
			$end_date =  date('m/d/Y',strtotime('+'.$weekz.' weeks', strtotime($start_date))); 				
			$weekly_off = appt_week_off($start_date, $end_date);
			array_push($total_holidays,$weekly_off );
		}
		
		if($business_holiday->repeat_value =="bi_weekly" && $business_holiday->all_off=="1") {
			$temp_weekz=$business_holiday->repeat_bi_weeks;
			$weekz= $temp_weekz + 1;
			$start_date= $business_holiday->holiday_date;
			$end_date =  date('m/d/Y',strtotime('+'.$weekz.' weeks', strtotime($start_date)));				
			$bi_weekly = appt_bi_weekly($start_date, $end_date);
			array_push($total_holidays,$bi_weekly );
		}	
		
		$monthly_holidays = array();
		if($business_holiday->repeat_value =="monthly" && $business_holiday->all_off=="1") {
			$months=$business_holiday->repeat_month;
				for($i=0;$i<=$months;$i++) {
				$date_format=date("'m/d/Y", strtotime('+'.$i.'months', strtotime($business_holiday->holiday_date))); 
				$monthly_off= substr($date_format, 1); 
				array_push($monthly_holidays,$monthly_off);
			}			
			array_push($total_holidays,$monthly_holidays );
		}

		if($business_holiday->repeat_value =="monthly" && $business_holiday->all_off=="1") {
			$months=$business_holiday->repeat_month;
			$start_date= $business_holiday->holiday_date;
			$end_date =  date('m/d/Y',strtotime('+'.$months.' months', strtotime($start_date))); 
			
			$begin = new DateTime($start_date);
			$end = new DateTime($end_date);
			while ($begin <= $end) {
				$date_months= $begin->format('m/d/Y');
				$month_off= array($date_months);
				array_push($total_holidays,$month_off );
				$begin->modify('first day of next month');
			}
		}	 
		?>
		//console.log(<?php echo json_encode($total_holidays ); ?>);
		var disableddates = '<?php echo json_encode($total_holidays ); ?>';
		//console.log(<?php echo json_encode($total_holidays ); ?>);
		function DisableSpecificDates(date) {
			var string = jQuery.datepicker.formatDate('mm/dd/yy', date);
			return [disableddates.indexOf(string) == -1];
		}
	
		var dateToday = new Date();
		jQuery(function() {
			jQuery("#apt_date").datepicker({
				minDate: dateToday,
				dateFormat: 'mm/dd/yy',
				beforeShowDay: DisableSpecificDates
			});
		});	
		<?php
	} 
} else { ?>
	var dateToday = new Date();
	jQuery.noConflict()(function (jQuery) {
		jQuery(function() {
			jQuery( "#apt_date" ).datepicker({
				dateFormat: 'mm/dd/yy',
				minDate: dateToday,		//DISABLE PREVIOUS DATES
			}); 
			jQuery("#apt_date").datepicker("setDate", dateToday);
		}); 
	});
<?php } ?>
</script>