<?php
global $wpdb;
if(isset($_REQUEST['holiday_info'])) {
	$fetch_var=$_REQUEST['holiday_info'];
	$appointment_apt_holidays=$wpdb->get_row("select * from $wpdb->prefix"."apt_holidays WHERE id = $fetch_var ");
}
?>
<script>
jQuery(document).ready(function() {
	if(jQuery("#allday_update").is(":checked")) {
		jQuery("#day_off_update").hide();
	}

	var check=jQuery("#repeat_update").val();
	if(check=="no") {
		jQuery(".all_hide").hide();	 
		jQuery(".p_date_hide").show();
	}

	if(check=="p_d") {
		jQuery(".all_hide").hide();
		jQuery(".p_date_hide").hide();	 
		jQuery(".p_date_show").show();	 
	}

	if(check=="daily") {
		jQuery(".all_hide").hide();	 
		jQuery(".hide_repeat_day").show();	 
		jQuery(".p_date_hide").show();
	}
	
	if(check=="weekly") {
		jQuery(".all_hide").hide();	
		jQuery(".hide_repeat_week").show();
		jQuery(".p_date_hide").show();	  
	}

	if(check=="bi_weekly") {
		jQuery(".all_hide").hide();
		jQuery(".hide_bi_repeat_week").show();
		jQuery(".p_date_hide").show();
	}

	if(check=="monthly") {
		jQuery(".all_hide").hide();
		jQuery(".hide_repeat_month").show();
		jQuery(".p_date_hide").show();
	}
});
</script>
<form action="" method="post" id="form_holiday_update">
	<div class="row ad-ser">
		<div class="col-md-12 col-sm-12">
			<label><?php _e('All Day Time Off', 'WF_A_P_SYSTEM'); ?></label>
			<input name="allday_update" id="allday_update" type="checkbox" value="1" <?php if($appointment_apt_holidays->all_off=="1") { echo 'checked="checked"';}?>  class="form-control"/>
		</div>
	</div>

	<div class="row ad-ser">
		<div class="col-md-12 col-sm-12">
			<label><?php _e('Name','WF_A_P_SYSTEM'); ?></label>
			<input name="name_update" id="name_update" type="text" class="form-control" value="<?php echo $appointment_apt_holidays->name;  ?>" />
			<span  class="validation_alert" id="holiday_name_update"><?php _e("This field is required",'WF_A_P_SYSTEM' ); ?></span>
		</div>
	</div>

	<div class="row ad-ser" id="day_off_update">
		<div class="col-md-6 col-sm-6">
			<label><?php _e('Start Time','WF_A_P_SYSTEM'); ?></label>
			<div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
				<input name="start_time_update" id="start_time_update" type="text" class="form-control" value="<?php echo $appointment_apt_holidays->start_time;  ?>" />
			</div>
		</div>
		<div class="col-md-6 col-sm-6">
			<label><?php _e('End Time','WF_A_P_SYSTEM'); ?></label>
			<div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
				<input name="end_time_update" id="end_time_update" type="text" class="form-control" value="<?php echo $appointment_apt_holidays->end_time;  ?>" />
			</div>
		</div>
	</div>
	
	<div class="row ad-ser p_date_hide">
		<div class="col-md-12 col-sm-12">
			<label><?php _e('Date','WF_A_P_SYSTEM'); ?></label>
			<input name="event_date_update" id="event_date_update" type="text" class="form-control holiday_dates" value="<?php echo $appointment_apt_holidays->holiday_date;  ?>" />
		</div>
	</div>

	<div class="row ad-ser">
		<div class="col-md-12 col-sm-">
			<label ><?php _e('Repeat','WF_A_P_SYSTEM'); ?></label>
			<select name="repeat_update" id="repeat_update" class="form-control" onchange="holiday_function(this.value)">
				<option  value="no" <?php if($appointment_apt_holidays->repeat_value=="no") {echo 'selected="selected"';} ?>><?php _e('No','WF_A_P_SYSTEM'); ?></option>
				<option  value="p_d" <?php if($appointment_apt_holidays->repeat_value=="p_d") {echo 'selected="selected"';} ?>><?php _e('Particular Date(s)','WF_A_P_SYSTEM'); ?></option>
				<option  value="daily" <?php if($appointment_apt_holidays->repeat_value=="daily") {echo 'selected="selected"';} ?>><?php _e('Daily','WF_A_P_SYSTEM'); ?></option>
				<option  value="weekly" <?php if($appointment_apt_holidays->repeat_value=="weekly") {echo 'selected="selected"';} ?>><?php _e('Weekly','WF_A_P_SYSTEM'); ?></option>
				<option  value="bi_weekly" <?php if($appointment_apt_holidays->repeat_value=="bi_weekly") {echo 'selected="selected"';} ?>><?php _e('Bi-Weekly','WF_A_P_SYSTEM'); ?></option>
				<option  value="monthly" <?php if($appointment_apt_holidays->repeat_value=="monthly") {echo 'selected="selected"';} ?>><?php _e('Monthly','WF_A_P_SYSTEM'); ?></option>
			</select>
		</div>
	</div>
	
	<div class="row ad-ser hide_repeat_day all_hide" style="display:none">
		<div class="col-md-12 col-sm-12">
			<label><?php _e('Repeat Day(s)','WF_A_P_SYSTEM'); ?></label>
			<input name="re_days_update" id="re_days_update" type="number" value="<?php if($appointment_apt_holidays->repeat_days) echo $appointment_apt_holidays->repeat_days; else echo 0; ?>" maxlength="2" class="form-control"  />
		</div>
	</div>
	
	<div class="row ad-ser hide_repeat_week all_hide" style="display:none">	  
		<div class="col-md-12 col-sm-12">
			<label><?php _e('Repeat Week(s)','WF_A_P_SYSTEM'); ?></label>
			<input name="re_weeks_update" id="re_weeks_update" type="number" value="<?php if($appointment_apt_holidays->repeat_weeks) echo $appointment_apt_holidays->repeat_weeks; else echo 0;  ?>" maxlength="2" class="form-control" />
		</div>
	</div>

	<div class="row ad-ser hide_bi_repeat_week all_hide" style="display:none">
		<div class="col-md-12 col-sm-12">
			<label><?php _e('Repeat Bi-Week(s)','WF_A_P_SYSTEM'); ?></label>
			<input name="re_biweeks_update" id="re_biweeks_update" type="number" value="<?php if($appointment_apt_holidays->repeat_bi_weeks) echo $appointment_apt_holidays->repeat_bi_weeks; else echo 0; ?>" maxlength="2" class="form-control" />
		</div>
	</div> 

	<div class="row ad-ser hide_repeat_month all_hide" style="display:none">
		<div class="col-md-12 col-sm-12">
			<label ><?php _e('Repeat Month(s)','WF_A_P_SYSTEM'); ?></label>	
			<input name="re_months_update" id="re_months_update" type="number" value="<?php if($appointment_apt_holidays->repeat_month) echo $appointment_apt_holidays->repeat_month; else echo 0;  ?>"  maxlength="2" class="form-control" />
		</div>
	</div>
	
	<div class="row ad-ser all_hide p_date_show all_hide" style="display:none">
		<div class="col-md-6 col-sm-6">
			<label><?php _e('Start Date','WF_A_P_SYSTEM'); ?></label>
			<input name="start_date_update" id="start_date_update" type="text" value="<?php if($appointment_apt_holidays->start_date) echo $appointment_apt_holidays->start_date; else echo date("m/d/Y"); ?>" class="form-control holiday_dates" />
		</div>
		<div class="col-md-6 col-sm-6">
			<label ><?php _e('End Date','WF_A_P_SYSTEM'); ?></label>
			<input name="end_date_update" id="end_date_update" value="<?php if($appointment_apt_holidays->end_date) echo $appointment_apt_holidays->end_date; else echo date("m/d/Y")  ?>" type="text" class="form-control holiday_dates" />
		</div>
	</div>
	
	<div class="col-md-12 col-sm-12">
		<label ><?php _e('Note','WF_A_P_SYSTEM'); ?></label>
		<textarea name="note_update" id="note_update" size="7" class="form-control" ><?php echo $appointment_apt_holidays->notes;  ?></textarea>
	</div>
	<input type="hidden" name="update_holiday_value" value="<?php echo $appointment_apt_holidays->id;  ?>" >
</form>