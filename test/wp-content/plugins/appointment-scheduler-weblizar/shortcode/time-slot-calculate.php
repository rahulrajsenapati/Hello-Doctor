<?php
global $wpdb;
$appointments_table = $wpdb->prefix ."apt_appointments";
$appearence_table =	$wpdb->prefix."apt_appearence";
$settings_table = $wpdb->prefix."apt_settings";
$staff_table =	$wpdb->prefix."apt_staff";
$holidays_table = $wpdb->prefix.'apt_holidays';

$staff_id= $_REQUEST['staff_member'] ;
$current_url= $_REQUEST['current_url'] ;
$service_id= $_REQUEST['service'] ;
$appointment_date=  $_REQUEST['apt_dates'];
$current_time= $_REQUEST['current_time'] ;
$current_date= date("m/d/Y");

$settings_time_slots = $wpdb->get_col( "SELECT time_slots from $settings_table" ); 
$time_slots	= $settings_time_slots[0];

$settings_custom_slot = $wpdb->get_col( "SELECT custom_slot from $settings_table" ); 
$custom_slot	= $settings_custom_slot[0];	
$selected_date= $_REQUEST['date_label'] ;

$AppointmentDate = date("Y-m-d", strtotime($_REQUEST['apt_dates']));
$weekday = date('l', strtotime($AppointmentDate));

$staff_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_staff where id='$staff_id'");
foreach($staff_details as $staff_detail){
	$staff_member_name= $staff_detail->staff_member_name;	 ?>
	<div class="ap-steps">
		<div class="col-md-12 col-sm-12 ap-steps">
			<div class="col-md-2 col-sm-2 ap-step1 services complete">
				<label><?php _e("1. Services",WF_A_P_SYSTEM ); ?></label>
				<span></span>
			</div>
			<div class="col-md-2 col-sm-2 ap-step2 time active">
				<label><?php _e("2. Time",WF_A_P_SYSTEM ); ?></label>
				<span></span>
			</div>
			<div class="col-md-2 col-sm-2 ap-step3 time ">
				<label><?php _e("3. Details",WF_A_P_SYSTEM ); ?></label>
				<span></span>
			</div>
			<div class="col-md-2 col-sm-2 ap-step4 Details ">
				<label><?php _e("4. Confirm",WF_A_P_SYSTEM ); ?></label>
				<span></span>
			</div>
			<div class="col-md-2 col-sm-2 ap-step5 done ">
				<label><?php _e("5. Done",WF_A_P_SYSTEM ); ?></label>
				<span></span>
			</div>
		</div>
	</div>
	<form style="margin-bottom: 0;" action="" method="POST" id="appoint_time" name="appoint_time">
		<div id="2" class="ap-steps-detail1">
			<p><?php _e("Available time slots for",WF_A_P_SYSTEM ); ?> &nbsp; </p>  <p class="service_tag">
			<?php  
			$service_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_services where id='$service_id'");
			foreach($service_details as $service_detail){	
				$service_name=$service_detail->name;
				$service_duration=$service_detail->duration;
				$service_p_before=$service_detail->p_before;
				$service_p_after=$service_detail->p_after;
				$service_duration_with_padding = $service_duration + $service_p_before;
				
				$settings_service_duration_type = $wpdb->get_col( "SELECT service_duration_type from $settings_table" ); 
				$service_duration_type	= $settings_service_duration_type[0];
				if($service_duration_type=='sd'){
					_e($service_name, WF_A_P_SYSTEM ); 
					echo "&nbsp;("; _e($service_duration.'minutes',WF_A_P_SYSTEM ); echo ")&nbsp;";
				}
			} ?>
			</p><p>&nbsp;</p>
			<p class="staff_tag"><?php  echo $staff_member_name;  ?></p>
			<?php
			$date_format = get_option( 'date_format' );
			$appt_date_format=date($date_format, strtotime($appointment_date)); 
			?>
			<p>&nbsp; <?php _e('on',WF_A_P_SYSTEM ); ?> &nbsp;</p><p class="date_tag"><?php _e($appt_date_format,WF_A_P_SYSTEM ); ?></p>
			<input type="hidden" id="appt_date_format" name="appt_date_format" value="<?php echo $appt_date_format ; ?>">
			<div class="row service-form">
				<div class="swiper-container home-timing">
					<div class="swiper-wrapper ">
						<div class="swiper-slide">
							<div class="step-time">
								<div class="aps-date">
									<label id="date_01" class="tm-value" ><?php _e($selected_date,WF_A_P_SYSTEM ); ?></label>
								</div>
								<ul class="stp-duration">
									<?php
									//BUSINESS HOURS FOR SELECTED DAY (START AND END SLOT)
									$AppointmentDate = date("Y-m-d", strtotime($_REQUEST['apt_dates']));
									$weekday = date('l', strtotime($AppointmentDate));
									if($weekday=="Sunday"){
										$settings_bh_sunday_st = $wpdb->get_col( "SELECT bh_sunday from $settings_table" ); 
										$sunday_time = unserialize($settings_bh_sunday_st[0]); 
										$sunday_start_time_staff=  $sunday_time[0]['start_time'];
										$sunday_end_time_staff= $sunday_time[0]['end_time'];
										
										$lunch_start_time_staff=  $sunday_time[0]['break_start'];
										$lunch_end_time_staff= $sunday_time[0]['break_end'];
											
										$biz_start_time = strtotime($sunday_start_time_staff);	
										$t20 = strtotime($sunday_end_time_staff);
										
										$service_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_services where id='$service_id'");
										foreach($service_details as $service_detail){
											$service_duration= $service_detail->duration;
											$service_p_after= $service_detail->p_after;
											$service_p_before= $service_detail->p_before;
											
											$biz_end_time = $t20 - (60*($service_p_after)) + (60*5) - (60*($service_duration)) - (60*($service_p_before)); 												
										}
									}
									if($weekday=="Monday"){
										$settings_bh_monday_st = $wpdb->get_col( "SELECT bh_monday from $settings_table" );
										$monday_time = unserialize($settings_bh_monday_st[0]); 
										$monday_start_time_staff=  $monday_time[0]['start_time'];
										$monday_end_time_staff= $monday_time[0]['end_time'];
										
										$lunch_start_time_staff=  $monday_time[0]['break_start'];
										$lunch_end_time_staff= $monday_time[0]['break_end'];
										
										$biz_start_time = strtotime($monday_start_time_staff);			
										$t20 = strtotime($monday_end_time_staff);

										$service_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_services where id='$service_id'");
										foreach($service_details as $service_detail){
											$service_duration= $service_detail->duration;
											$service_p_after= $service_detail->p_after;
											$service_p_before= $service_detail->p_before;
											$biz_end_time = $t20 - (60*($service_p_after)) + (60*5) - (60*($service_duration)) - (60*($service_p_before)); 												
										}
									}
									if($weekday=="Tuesday"){
										$settings_bh_tuesday_st = $wpdb->get_col( "SELECT bh_tuesday from $settings_table" );
										$tuesday_time = unserialize($settings_bh_tuesday_st[0]); 
										$tuesday_start_time_staff=  $tuesday_time[0]['start_time'];
										$tuesday_end_time_staff= $tuesday_time[0]['end_time'];
										
										$lunch_start_time_staff=  $tuesday_time[0]['break_start'];
										$lunch_end_time_staff= $tuesday_time[0]['break_end'];
											
										$biz_start_time = strtotime($tuesday_start_time_staff);		
										$t20 = strtotime($tuesday_end_time_staff);
										
										$service_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_services where id='$service_id'");
										foreach($service_details as $service_detail){
											$service_duration= $service_detail->duration;
											$service_p_after= $service_detail->p_after;
											$service_p_before= $service_detail->p_before;
											$biz_end_time = $t20 - (60*($service_p_after)) + (60*5) - (60*($service_duration)) - (60*($service_p_before)); 	 											
										}									
									}
									if($weekday=="Wednesday"){
										$settings_bh_wednesday_st = $wpdb->get_col( "SELECT bh_wednesday from $settings_table" ); 
										$wednesday_time = unserialize($settings_bh_wednesday_st[0]); 
										$wednesday_start_time_staff=  $wednesday_time[0]['start_time'];
										$wednesday_end_time_staff= $wednesday_time[0]['end_time'];
										
										$lunch_start_time_staff=  $wednesday_time[0]['break_start'];
										$lunch_end_time_staff= $wednesday_time[0]['break_end'];
										
										$biz_start_time = strtotime($wednesday_start_time_staff);
										$t20 = strtotime($wednesday_end_time_staff);
										
										$service_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_services where id='$service_id'");
										foreach($service_details as $service_detail){
											$service_duration= $service_detail->duration;
											$service_p_after= $service_detail->p_after;
											$service_p_before= $service_detail->p_before;
											$biz_end_time = $t20 - (60*($service_p_after)) + (60*5) - (60*($service_duration)) - (60*($service_p_before)); 												
										}
									}
									if($weekday=="Thursday"){
										$settings_bh_thursday_st = $wpdb->get_col( "SELECT bh_thursday from $settings_table" ); 
										$thursday_time = unserialize($settings_bh_thursday_st[0]); 
										$thursday_start_time_staff=  $thursday_time[0]['start_time'];
										$thursday_end_time_staff= $thursday_time[0]['end_time'];

										$lunch_start_time_staff=  $thursday_time[0]['break_start'];
										$lunch_end_time_staff= $thursday_time[0]['break_end'];

										$biz_start_time = strtotime($thursday_start_time_staff);
										$t20 = strtotime($thursday_end_time_staff);
										
										$service_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_services where id='$service_id'");
										foreach($service_details as $service_detail){
											$service_duration= $service_detail->duration;
											$service_p_after= $service_detail->p_after;
											$service_p_before= $service_detail->p_before;
											$biz_end_time = $t20 - (60*($service_p_after)) + (60*5) - (60*($service_duration)) - (60*($service_p_before)); 											
										}
									}
									if($weekday=="Friday"){
										$settings_bh_friday_st = $wpdb->get_col( "SELECT bh_friday from $settings_table" ); 
										$friday_time = unserialize($settings_bh_friday_st[0]); 
										$friday_start_time_staff=  $friday_time[0]['start_time'];
										$friday_end_time_staff= $friday_time[0]['end_time'];
										
										$lunch_start_time_staff=  $friday_time[0]['break_start'];
										$lunch_end_time_staff= $friday_time[0]['break_end'];
										
										$biz_start_time = strtotime($friday_start_time_staff);	
										$t20 = strtotime($friday_end_time_staff);
										$service_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_services where id='$service_id'");
										foreach($service_details as $service_detail){
											$service_duration= $service_detail->duration;
											$service_p_after= $service_detail->p_after;
											$service_p_before= $service_detail->p_before;
											
											$biz_end_time = $t20 - (60*($service_p_after)) + (60*5) - (60*($service_duration)) - (60*($service_p_before)); 	 											
										}
									}
									if($weekday=="Saturday"){
										$settings_bh_saturday_st =  $wpdb->get_col( "SELECT bh_saturday from $settings_table" ); 
										$saturday_time = unserialize($settings_bh_saturday_st[0]); 
										$saturday_start_time_staff=  $saturday_time[0]['start_time'];
										$saturday_end_time_staff= $saturday_time[0]['end_time'];
										
										$lunch_start_time_staff=  $saturday_time[0]['break_start'];
										$lunch_end_time_staff= $saturday_time[0]['break_end'];
									
										$biz_start_time = strtotime($saturday_start_time_staff);	
										$t20 = strtotime($saturday_end_time_staff);
										
										$service_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_services where id='$service_id'");
										foreach($service_details as $service_detail){
											$service_duration= $service_detail->duration;
											$service_p_after= $service_detail->p_after;
											$service_p_before= $service_detail->p_before;
											$biz_end_time = $t20  - (60*($service_p_after))  + (60*5) - (60*($service_duration)) - (60*($service_p_before)); 	 											
										}
									}
									$settings_appt_status = $wpdb->get_col( "SELECT appt_status from $settings_table" ); 
									$appt_status	= $settings_appt_status[0];
									
									
									//DISABLED SLOTS ARRAY
									$disabled_slots = array();    

									//DISABLE PREVIOUS BOOKED TIME SLOTS
									$booked_appointments = $wpdb->get_results("SELECT * FROM $appointments_table where status='$appt_status' OR status='approved'");
									foreach($booked_appointments as $single_booked_appointment){
										$appt_repeat_value= $single_booked_appointment->repeat_appointment;
										if($appt_repeat_value=="Non" || $appt_repeat_value==""){
											$booked_appt_date= $single_booked_appointment->booking_date; 
											$appt_date = date("Y-m-d", strtotime($appointment_date));
												if($appt_date==$booked_appt_date){
										
													$appt_start_time= $single_booked_appointment->start_time; 
													$appt_end_time= $single_booked_appointment->end_time;
													
													$temp_start_time = strtotime($appt_start_time);
													$temp_end_time = strtotime($appt_end_time);
													
													$service_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_services where id='$service_id'");
													foreach($service_details as $service_detail){
														$service_duration= $service_detail->duration;
														$service_p_after= $service_detail->p_after;
														$service_p_before= $service_detail->p_before;
														
														//INTERSECT B4_PADDING TIME(FOR NEXT APPT), DURATION, B4_PADDING TIME(FOR CURRENT APPT), AFTER_PADDING TIME
														$appointment_start_time = $temp_start_time  + (60*5) - (60*($service_duration)) - (60*($service_p_before)) - (60*($service_p_after)); 
														
														$appointment_end_time = $temp_end_time - (60*5) + (60*($service_p_before)) +   (60*($service_p_after));  ;									
													}
													while ($appointment_start_time <= $appointment_end_time) {
														$appointment_start_time = $appointment_start_time + (60*5) ;
														$slots_view = $appointment_start_time - (60*5);
														$booked_slots= date(" H:i", $slots_view);
														$temp_appt_booked_time_slots[] = $booked_slots;
													}
													foreach($temp_appt_booked_time_slots as $temp_appt_booked_single_time_slot){
														$appt_booked_time_slots= substr($temp_appt_booked_single_time_slot, 1); 
														array_push($disabled_slots,$appt_booked_time_slots );
													}
												}
										}

										$daily_appts = array();
										if($appt_repeat_value=="daily" ){
											$re_days=$single_booked_appointment->re_days;
												for($i=0;$i<=$re_days;$i++)
											{
												$date_format=date("'m/d/Y", strtotime('+'.$i.'days', strtotime($single_booked_appointment->booking_date))); 
												$daily_off= substr($date_format, 1); 
												array_push($daily_appts,$daily_off);
											}
											
											if (in_array($appointment_date, $daily_appts)){
												$appt_daily_st= $single_booked_appointment->start_time; 
												$appt_daily_et= $single_booked_appointment->end_time;
																 
														$temp_appt_start_time = strtotime($appt_daily_st);
														$temp_appt_end_time = strtotime($appt_daily_et);
														foreach($service_details as $service_detail){
															$service_duration= $service_detail->duration;
															$service_p_after= $service_detail->p_after;
															$service_p_before= $service_detail->p_before;
															$appt_start_time = $temp_appt_start_time + (60*5)   - (60*($service_duration))  - (60*($service_p_before)) - (60*($service_p_after)); 
															$appt_end_time = $temp_appt_end_time - (60*5) +  (60*($service_p_before))  + (60*($service_p_after));
														}
														
														
														while ($appt_start_time <= $appt_end_time) {
															$appt_start_time = $appt_start_time + (60*5) ;
															$appt_daily_off_schedule = $appt_start_time - (60*5);
																		
															$daily_appt_off= date(" H:i", $appt_daily_off_schedule);
															$temp_appt_offs[] = $daily_appt_off;
														}
														foreach($temp_appt_offs as $temp_appt_off){
															$appt_daily_off= substr($temp_appt_off, 1); 
															array_push($disabled_slots,$appt_daily_off );
														}
											}
										}
										
										$weekly_appts = array();
										if($appt_repeat_value=="weekly" ) {
											$re_weeks=$single_booked_appointment->re_weeks;
											for($i=0;$i<=$re_weeks;$i++) {
												$date_format=date("'m/d/Y", strtotime('+'.$i.'week', strtotime($single_booked_appointment->booking_date))); 
												$weekly_off= substr($date_format, 1); 
												array_push($weekly_appts,$weekly_off);
											}
											if (in_array($appointment_date, $weekly_appts)){
												$appt_weekly_st= $single_booked_appointment->start_time; 
												$appt_weekly_et= $single_booked_appointment->end_time;
												$temp_appt_start_time = strtotime($appt_weekly_st);
												$temp_appt_end_time = strtotime($appt_weekly_et);
												foreach($service_details as $service_detail){
													$service_duration= $service_detail->duration;
													$service_p_after= $service_detail->p_after;
													$service_p_before= $service_detail->p_before;
													$appt_start_time = $temp_appt_start_time + (60*5)  - (60*($service_duration))  - (60*($service_p_before)) - (60*($service_p_after)); 
													$appt_end_time = $temp_appt_end_time - (60*5) +  (60*($service_p_before))  + (60*($service_p_after));
												}
												
												while ($appt_start_time <= $appt_end_time) {
													$appt_start_time = $appt_start_time + (60*5) ;
													$appt_weekly_off_schedule = $appt_start_time - (60*5);
																
													$weekly_appt_off= date(" H:i", $appt_weekly_off_schedule);
													$temp_appt_offs[] = $weekly_appt_off;
												}
												foreach($temp_appt_offs as $temp_appt_off){
													$appt_weekly_off= substr($temp_appt_off, 1); 
													array_push($disabled_slots,$appt_weekly_off );
												}
											}
										}
										
										$monthly_appts = array();
										if($appt_repeat_value=="monthly" ){
											$re_months=$single_booked_appointment->re_months;
											for($i=0;$i<=$re_months;$i++) {
												$date_format=date("'m/d/Y", strtotime('+'.$i.'months', strtotime($single_booked_appointment->booking_date))); 
												$monthly_off= substr($date_format, 1); 
												array_push($monthly_appts,$monthly_off);
											}
											if (in_array($appointment_date, $monthly_appts)){
												$appt_monthly_st= $single_booked_appointment->start_time; 
												$appt_monthly_et= $single_booked_appointment->end_time;
												$temp_appt_start_time = strtotime($appt_monthly_st);
												$temp_appt_end_time = strtotime($appt_monthly_et);
												foreach($service_details as $service_detail){
													$service_duration= $service_detail->duration;
													$service_p_after= $service_detail->p_after;
													$service_p_before= $service_detail->p_before;
													$appt_start_time = $temp_appt_start_time + (60*5)  - (60*($service_duration))  - (60*($service_p_before)) - (60*($service_p_after)); 
													$appt_end_time = $temp_appt_end_time - (60*5) +  (60*($service_p_before))  + (60*($service_p_after));
												}
												
												while ($appt_start_time <= $appt_end_time) {
													$appt_start_time = $appt_start_time + (60*5) ;
													$appt_monthly_off_schedule = $appt_start_time - (60*5);
													$monthly_appt_off= date(" H:i", $appt_monthly_off_schedule);
													$temp_appt_offs[] = $monthly_appt_off;
												}
												foreach($temp_appt_offs as $temp_appt_off){
													$appt_monthly_off= substr($temp_appt_off, 1); 
													array_push($disabled_slots,$appt_monthly_off );
												}
											}
										}								
										
										if($appt_repeat_value=="PD" ){
											$appt_start_date= $single_booked_appointment->re_start_date; 
											$appt_end_date= $single_booked_appointment->re_end_date;
											
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
											
											// Call the function
											$appt_date_range = appt_pd_off($appt_start_date, $appt_end_date);
											if (in_array($appointment_date, $appt_date_range)){
												$appt_monthly_st= $single_booked_appointment->start_time; 
												$appt_monthly_et= $single_booked_appointment->end_time;
												$temp_appt_start_time = strtotime($appt_monthly_st);
												$temp_appt_end_time = strtotime($appt_monthly_et);
												foreach($service_details as $service_detail){
													$service_duration= $service_detail->duration;
													$service_p_after= $service_detail->p_after;
													$service_p_before= $service_detail->p_before;
													$appt_start_time = $temp_appt_start_time + (60*5)  - (60*($service_duration))  - (60*($service_p_before)) - (60*($service_p_after)); 
													$appt_end_time = $temp_appt_end_time - (60*5) +  (60*($service_p_before))  + (60*($service_p_after));
												}
												while ($appt_start_time <= $appt_end_time) {
													$appt_start_time = $appt_start_time + (60*5) ;
													$appt_pd_off_schedule = $appt_start_time - (60*5);
													$pd_appt_off= date(" H:i", $appt_pd_off_schedule);
													$temp_appt_offs[] = $pd_appt_off;
												}
												foreach($temp_appt_offs as $temp_appt_off){
													$appt_particular_dayz_off= substr($temp_appt_off, 1); 
													array_push($disabled_slots,$appt_particular_dayz_off );
												}
											}
										}
									} //DISABLE PREVIOUS BOOKED TIME SLOTS END
										
										
									//DISABLE HOLIDAY TIME SLOTS
									$multiple_holidays = $wpdb->get_results("SELECT * FROM $holidays_table where all_off='0'");
									foreach($multiple_holidays as $single_holiday){
										$holiday_all_off = $single_holiday->all_off; 
										if($holiday_all_off == "0"){
											$holiday_repeat_value= $single_holiday->repeat_value;
											if($holiday_repeat_value=="no"){
												$holiday_date= $single_holiday->holiday_date; 
												
												if($appointment_date==$holiday_date){
													$holiday_start_date= $single_holiday->start_time; 
													$holiday_end_date= $single_holiday->end_time;
													 
													$temp_start_time = strtotime($holiday_start_date);
													$temp_end_time = strtotime($holiday_end_date);
													$service_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_services where id='$service_id'");
													foreach($service_details as $service_detail){
														$service_duration= $service_detail->duration;
														$service_p_after= $service_detail->p_after;
														$service_p_before= $service_detail->p_before;
														$no_repeat_holiday_st = $temp_start_time - (60*($service_duration)) + (60*5) - (60*($service_p_before)) - (60*($service_p_after)) ; 
													}
													
													$no_repeat_holiday_et = $temp_end_time - (60*5)  ;
													while ($no_repeat_holiday_st <= $no_repeat_holiday_et) {
														$no_repeat_holiday_st = $no_repeat_holiday_st + (60*5) ;
														$today_holiday_off_slots = $no_repeat_holiday_st - (60*5);
														$no_repeat_holidays= date(" H:i", $today_holiday_off_slots);
														$temp_holiday_off_no_repeats[] = $no_repeat_holidays;
													}
													foreach($temp_holiday_off_no_repeats as $temp_holiday_off_no_repeat){
														$holiday_off_no_repeat= substr($temp_holiday_off_no_repeat, 1); 
														array_push($disabled_slots,$holiday_off_no_repeat );
													}
												}
											}
											
											// particular days holidays
											if($holiday_repeat_value == "p_d"){
												$holiday_start_date = $single_holiday->start_date; 
												$holiday_end_date = $single_holiday->end_date;
												function holiday_pd_off($start, $end, $format = 'm/d/Y') {
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
												
												// Call the function
												$date_period = holiday_pd_off($holiday_start_date, $holiday_end_date); 
												if (in_array($appointment_date, $date_period)){
													$holiday_start_time= $single_holiday->start_time; 
													$holiday_end_time= $single_holiday->end_time;
													$temp_holiday_start_time = strtotime($holiday_start_time);
													$temp_end_time = strtotime($holiday_end_time);
													foreach($service_details as $service_detail){
														$service_duration= $service_detail->duration;
														$service_p_after= $service_detail->p_after;
														$service_p_before= $service_detail->p_before;
														$pd_holiday_st = $temp_holiday_start_time - (60*($service_duration)) + (60*5) - (60*($service_p_before)) - (60*($service_p_after)); 
													}
														
													$pd_holiday_et = $temp_end_time - (60*5) ;
													while ($pd_holiday_st <= $pd_holiday_et) {
														$pd_holiday_st = $pd_holiday_st + (60*5) ;
														$pd_holiday_off_slots = $pd_holiday_st - (60*5);
														$pd_holiday_off= date(" H:i", $pd_holiday_off_slots);
														$temp_holiday_time_slots[] = $pd_holiday_off;
													}
													foreach($temp_holiday_time_slots as $temp_holiday_time_slot){
														$holiday_off_pd= substr($temp_holiday_time_slot, 1); 
														array_push($disabled_slots,$holiday_off_pd );
													}
												}
											}
											
											// daily holidays
											if($holiday_repeat_value=="daily"){
												$holiday_start_date=date("m/d/Y", strtotime($single_holiday->holiday_date));  
												$add_days=$single_holiday->repeat_days;
												$holiday_end_date = date('m/d/Y',strtotime($holiday_start_date) + (24*3600*$add_days)); 
												
												function holiday_daily_off($start, $end, $format = 'm/d/Y') {
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
												
												$date_range = holiday_daily_off($holiday_start_date, $holiday_end_date);
												if(in_array($appointment_date, $date_range)){
													$holiday_start_time= $single_holiday->start_time; 
													$holiday_end_time= $single_holiday->end_time;
													$temp_holiday_start_time = strtotime($holiday_start_time);
													$temp_end_time = strtotime($holiday_end_time);
														
													foreach($service_details as $service_detail){
														$service_duration= $service_detail->duration;
														$service_p_after= $service_detail->p_after;
														$service_p_before= $service_detail->p_before;
														$daily_holiday_st = $temp_holiday_start_time - (60*($service_duration)) + (60*5) - (60*($service_p_before)) - (60*($service_p_after)); 
													}
													$daily_holiday_et = $temp_end_time - (60*5) ;
														
													while ($daily_holiday_st <= $daily_holiday_et) {
														$daily_holiday_st = $daily_holiday_st + (60*5) ;
														$daily_holiday_off_slots = $daily_holiday_st - (60*5);
														$daily_holiday_off= date(" H:i", $daily_holiday_off_slots);
														$temp_holiday_time_slots[] = $daily_holiday_off;
													}
													foreach($temp_holiday_time_slots as $temp_holiday_time_slot){
														$holiday_off_daily= substr($temp_holiday_time_slot, 1); 
														array_push($disabled_slots,$holiday_off_daily );
													}
												}
											}
											
											if($holiday_repeat_value=="weekly"){
												
												$weekz=$single_holiday->repeat_weeks;
												$holiday_start_date= $single_holiday->holiday_date;
												$holiday_end_date =  date('m/d/Y',strtotime('+'.$weekz.' weeks', strtotime($holiday_start_date))); 
												function holiday_week_off($start, $end, $format = 'm/d/Y') {
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
												 
												$weekly_off = holiday_week_off($holiday_start_date, $holiday_end_date);
												if(in_array($appointment_date, $weekly_off)){
													$holiday_start_time= $single_holiday->start_time; 
													$holiday_end_time= $single_holiday->end_time;
													$temp_holiday_start_time = strtotime($holiday_start_time);
													$temp_end_time = strtotime($holiday_end_time);
													foreach($service_details as $service_detail){
														$service_duration= $service_detail->duration;
														$service_p_after= $service_detail->p_after;
														$service_p_before= $service_detail->p_before;
														$weekly_holiday_st = $temp_holiday_start_time - (60*($service_duration)) + (60*5) - (60*($service_p_before)) - (60*($service_p_after)); 
													}
													
													$weekly_holiday_et = $temp_end_time - (60*5) ;
													while ($weekly_holiday_st <= $weekly_holiday_et) {
														$weekly_holiday_st = $weekly_holiday_st + (60*5) ;
														$weekly_holiday_off_slots = $weekly_holiday_st - (60*5);
														$weekly_holiday_off= date(" H:i", $weekly_holiday_off_slots);
														$temp_holiday_time_slots[] = $weekly_holiday_off;
													}
													foreach($temp_holiday_time_slots as $temp_holiday_time_slot){
														$holiday_off_weekly= substr($temp_holiday_time_slot, 1); 
														array_push($disabled_slots,$holiday_off_weekly );
													}
												}
											}
											if($holiday_repeat_value=="bi_weekly"){
												$temp_weekz=$single_holiday->repeat_bi_weeks;
												$weekz= $temp_weekz + 1;
												$holiday_start_date= $single_holiday->holiday_date;
												$holiday_end_date =  date('m/d/Y',strtotime('+'.$weekz.' weeks', strtotime($holiday_start_date))); 
												
												function holiday_bi_weekly($start, $end, $format = 'm/d/Y') {
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

												$bi_weekly = holiday_bi_weekly($holiday_start_date, $holiday_end_date);
												if (in_array($appointment_date, $bi_weekly)){
													$holiday_start_time= $single_holiday->start_time; 
													$holiday_end_time= $single_holiday->end_time;
															 
													$temp_holiday_start_time = strtotime($holiday_start_time);
													$temp_end_time = strtotime($holiday_end_time);
													foreach($service_details as $service_detail){
														$service_duration= $service_detail->duration;
														$service_p_after= $service_detail->p_after;
														$service_p_before= $service_detail->p_before;
														$bi_weekly_holiday_st = $temp_holiday_start_time - (60*($service_duration)) + (60*5) - (60*($service_p_before)) - (60*($service_p_after)); 
													}
													
													
													$bi_weekly_holiday_et = $temp_end_time - (60*5) ;
													while ($bi_weekly_holiday_st <= $bi_weekly_holiday_et) {
														$bi_weekly_holiday_st = $bi_weekly_holiday_st + (60*5) ;
														$bi_weekly_holiday_off = $bi_weekly_holiday_st - (60*5);
														$bi_weekly_holiday= date(" H:i", $bi_weekly_holiday_off);
														$temp_holiday_time_slots[] = $bi_weekly_holiday;
													}
													foreach($temp_holiday_time_slots as $temp_holiday_time_slot){
														$holiday_bi_weekly_off= substr($temp_holiday_time_slot, 1); 
														array_push($disabled_slots,$holiday_bi_weekly_off );
													}
												}
											}
											
											// monthly holidays
											$monthly_holidays = array();
											if($holiday_repeat_value=="monthly"){
												$months=$single_holiday->repeat_month;
													for($i=0;$i<=$months;$i++) {
													$date_format=date("'m/d/Y", strtotime('+'.$i.'months', strtotime($single_holiday->holiday_date))); 
													$monthly_off= substr($date_format, 1); 
													array_push($monthly_holidays,$monthly_off);
												}
												if (in_array($appointment_date, $monthly_holidays)){
													$holiday_start_time= $single_holiday->start_time; 
													$holiday_end_time= $single_holiday->end_time;
													$temp_holiday_start_time = strtotime($holiday_start_time);
													$temp_end_time = strtotime($holiday_end_time);
													foreach($service_details as $service_detail){
														$service_duration= $service_detail->duration;
														$service_p_after= $service_detail->p_after;
														$service_p_before= $service_detail->p_before;
														$monthly_holiday_st = $temp_holiday_start_time - (60*($service_duration)) + (60*5) - (60*($service_p_before)) - (60*($service_p_after)); 
													}
													$monthly_holiday_et = $temp_end_time - (60*5) ;
													
													while ($monthly_holiday_st <= $monthly_holiday_et) {
														$monthly_holiday_st = $monthly_holiday_st + (60*5) ;
														$monthly_holiday_off = $monthly_holiday_st - (60*5);
														$monthly_holiday= date(" H:i", $monthly_holiday_off);
														$temp_holiday_time_slots[] = $monthly_holiday;
													}
													foreach($temp_holiday_time_slots as $temp_holiday_time_slot){
														$holiday_monthly_off= substr($temp_holiday_time_slot, 1); 
														array_push($disabled_slots,$holiday_monthly_off );
													}
												}
											}										
										}	
									} //DISABLE HOLIDAY TIME SLOTS END
										
									//TOTAL TIME SLOTS
									if($time_slots=="service_slots"){
										$service_details = $wpdb->get_results( "SELECT * from $wpdb->prefix"."apt_services where id='$service_id'");
										foreach($service_details as $service_detail){
											$service_duration= $service_detail->duration;
											for( $i = $biz_start_time; $i < $biz_end_time; $i += (60*($service_duration)))  {
												$total_time_slots[] = date('H:i', $i);
											}
										}
									} else {
										for( $i = $biz_start_time; $i < $biz_end_time; $i += (60*($custom_slot))) {
											$total_time_slots[] = date('H:i', $i);
										}
									}
										
									//DISABLE PREVIOUS TIME SLOTS FOR CURRENT DATE
									if($appointment_date == $current_date){
										$temp_end_slot_time=	date(" H:i", $biz_end_time);
										$end_slot_time= substr($temp_end_slot_time, 1); 
										
										if($current_time < $end_slot_time){
											$slots= array_filter($total_time_slots, function ($x) use ($current_time) { return $x > $current_time; });
											$available_slots = array_diff($slots, $disabled_slots);
											
											if($available_slots ==""){
												$time_slots_available = $slots;	
											}else{
												$time_slots_available = $available_slots;
											}
											foreach ($time_slots_available as $slot ) {
												$time_format = get_option( 'time_format' ); 
												$temp_time_slot_format = strtotime($slot);
												$time_slot_format=	date($time_format, $temp_time_slot_format);
												?><li id="ap_slots" class="col-md-3 col-xs-6"><input class="radio_button" title="<?php echo $time_slot_format; ?>" value="<?php echo $slot; ?>" id="radio<?php echo $slot; ?>" type="radio" name="ap_time" /><label for="radio<?php echo $slot; ?>" id="tm-value" class="tm-value"><span id="time_value<?php echo $slot; ?>"></span> <?php echo $time_slot_format; ?></label></li><?php	
											}
										} else {
											_e("<center>Business Hours Closed for Today. Please Select Another Date.</center><br><center>Thank You</center>",WF_A_P_SYSTEM ); 
										}
									} else { 
										//DISABLE PREVIOUS TIME SLOTS FOR OTHER DAYS
										$available_slots = array_diff($total_time_slots, $disabled_slots);
										foreach ($available_slots as $slot) {
											$time_format = get_option( 'time_format' ); 
											$temp_time_slot_format = strtotime($slot);
											$time_slot_format=	date($time_format, $temp_time_slot_format);
											?><li id="ap_slots" class="col-md-3 col-xs-6"><input class="radio_button" title="<?php echo $time_slot_format; ?>"  value="<?php echo $slot; ?>" id="radio<?php echo $slot; ?>" type="radio" name="ap_time" /><label for="radio<?php echo $slot; ?>" id="tm-value" class="tm-value"><span id="time_value<?php echo $slot; ?>"></span> <?php echo $time_slot_format; ?></label></li><?php
										}
									}	
									?>
								</ul>	
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php  $time_editor_content= get_option("time_tips");
			if (!empty($time_editor_content)) {	?>
				<div class="row step-description">
					<div> <?php echo "<pre class='pre_bg' style='display:block !important;'>".$time_editor_content."</pre>"; ?>  </div> 
				</div> <?php 
			} ?> 
		</div>
		
		<!-- Step 2 -->
		<div class="ap-step-link">
			<?php
			$appearence_time_navigation_text_backward = $wpdb->get_col( "SELECT time_navigation_text_backward from $appearence_table" );
			$time_navigation_text_backward	= $appearence_time_navigation_text_backward[0]; 
			$appearence_time_navigation_text_forward= $wpdb->get_col( "SELECT time_navigation_text_forward from $appearence_table" );
			$time_navigation_text_forward	= $appearence_time_navigation_text_forward[0]; ?>
			<button id="stepback2" href="#step1" type="button"  onclick="return step2_back();" class="btn step-left"><?php if (!empty($time_navigation_text_backward)) {  _e($time_navigation_text_backward,WF_A_P_SYSTEM );  } else { _e("Back",WF_A_P_SYSTEM );   } ?></button> 
			<button id="stepnext2" type="button"  onclick="return step2_next();" class="btn step-right"><?php if (!empty($time_navigation_text_forward)) {  _e($time_navigation_text_forward,WF_A_P_SYSTEM );  } else { _e("Next",WF_A_P_SYSTEM );   } ?></button> 
		</div>
	</form>
	<?php
}
?>	