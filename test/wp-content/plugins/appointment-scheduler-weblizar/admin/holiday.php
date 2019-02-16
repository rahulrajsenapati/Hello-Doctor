<script>
// multiple select checkbox
 jQuery(document).ready(function() {
   
	jQuery('#selec_tall_holiday').click(function(event) {  //on click
		if(this.checked) { // check select status
			jQuery('.checkbox_1').each(function() { //loop through each checkbox
				this.checked = true;  //select all checkboxes with class "checkbox1"
			});
		} else {
			jQuery('.checkbox_1').each(function() { //loop through each checkbox
				this.checked = false; //deselect all checkboxes with class "checkbox1"
			});
		}
	});
});
jQuery(document).ready(function() {
	var table = jQuery('#display_holiday').DataTable({
		stateSave: true,
		responsive: true,
		ajax: ajaxurl+'?action=holiday_json_ajax_request',
		"aoColumnDefs" : [
			{ 'bSortable' : false, className: 'all', 'aTargets' : ['nosort'],},
			{className: 'all', orderable: true, targets:['sh_ow']}
		],
		"language": {
			"loadingRecords": "No Holiday Add"
		},
	});
});

//save holiday
function  holiday_save() {
	if(jQuery("#name").val() == "") {
		jQuery(".validation_alert").hide();
		jQuery("#holiday_name_alert").show();  
		jQuery("#name").focus();
		return false;
	}
	jQuery(".save_appt_holiday").prop('disabled', true);
	jQuery('.save_appt_holiday').html('<i class="fa fa-spinner fa-spin"></i> <?php _e("Creating",WF_A_P_SYSTEM ); ?>');  

	jQuery.ajax({
		url: location.href,
		type: "POST",
		data: jQuery("form#form_holiday").serialize(),
		dataType: "html",
		//Do not cache the page
		cache: false,
		//success
		success: function (html) {
			jQuery(".save_appt_holiday").prop('disabled', false);
			jQuery('.save_appt_holiday').html('<?php _e("Create Holiday",WF_A_P_SYSTEM ); ?>');
			jQuery.notify("<?php _e('Holiday Created Successfully',WF_A_P_SYSTEM ); ?>", {type:"success",icon:"check",align:"center", verticalAlign:"middle",color: "#3c763d", background: "#dff0d8"});
			jQuery('form#form_holiday')[0].reset();
			jQuery('div#holi_day').modal('hide');
			jQuery('#display_holiday').DataTable().ajax.reload(null, false);
			jQuery(".all_hide").hide();
		}
	});
}
	
//fetch records on  model
jQuery(document).ready(function(){
	jQuery('#holi_day_update').on('show.bs.modal', function (e) {
	var rowid = jQuery(e.relatedTarget).data('id');
	//console.log(rowid);
	jQuery.ajax({
		type : 'post',
		url : ajaxurl+'?action=holiday_fetch_ajax_request',  
		data :  'holiday_info='+ rowid, //Pass $id
		success : function(data){
				jQuery('#holiday_html_fetch').html(data);
				var dateToday = new Date();
				jQuery(".holiday_dates").datepicker({minDate: dateToday,});
				jQuery('.clockpicker').clockpicker();
			}
		});
	});
});
	  
//Update holiday
function  holiday_update() {
	if(jQuery("#name_update").val() == "") {
		jQuery(".validation_alert").hide();
		jQuery("#holiday_name_update").show();  
		jQuery("#name_update").focus();
		return false;
	}
	jQuery(".update_appt_holiday").prop('disabled', true);
	jQuery('.update_appt_holiday').html('<i class="fa fa-spinner fa-spin"></i><?php _e("Update",WF_A_P_SYSTEM ); ?>');
	jQuery.ajax({
		url: location.href,
		type: "POST",
		data: jQuery("form#form_holiday_update").serialize(),
		dataType: "html",
		//Do not cache the page
		cache: false,
		//success
		success: function (html) {
			jQuery(".update_appt_holiday").prop('disabled', false);
			jQuery('.update_appt_holiday').html('<?php _e("Update Holiday",WF_A_P_SYSTEM ); ?>');
			jQuery.notify("<?php _e('Holiday Update Successfully',WF_A_P_SYSTEM ); ?>", {type:"success",icon:"check",align:"center", verticalAlign:"middle",color: "#3c763d", background: "#dff0d8"});
			jQuery('form#form_holiday_update')[0].reset();
			jQuery('div#holi_day_update').modal('hide');
			jQuery('#display_holiday').DataTable().ajax.reload(null, false);
		}
	});
}

//single delete
jQuery(document).on("click", '.del_holi_day', function (event) {
	var d_id = jQuery(this).attr('href');
	var res = d_id.substring(1);
	jQuery.confirm({
		title: '<?php _e("Please Confirm",WF_A_P_SYSTEM ); ?>',
		theme: 'black',
		content: '<?php _e("Are you sure to Delete Holiday?",WF_A_P_SYSTEM ); ?>',
		animation: 'rotate',
		closeAnimation: 'rotateXR',
		icon: 'fa fa-check-square-o',
		confirmButton: '<?php _e("Delete",WF_A_P_SYSTEM ); ?>',
		cancelButton: '<?php _e("Cancel",WF_A_P_SYSTEM ); ?>',
		confirm: function () {
			jQuery.ajax({
				data:"holiday_id="+res,
				url: location.href,
				type:"POST",
				success:function(data) {
					jQuery.notify("<?php _e('Delete Successfully',WF_A_P_SYSTEM ); ?>", {type:"success",icon:"check",align:"center", verticalAlign:"middle",color: "#3c763d", background: "#dff0d8"});	 
					jQuery('#display_holiday').DataTable().ajax.reload(null, false);
				}
			})
		},
	});
});

// multiple delete
jQuery(function() {
	jQuery("a.delete_holiday").click(function(){
		ids = new Array()
		a = 0;
		jQuery("#my_check_holiday:checked").each(function(i){
			ids[i]=jQuery(this).val();
		})
		if(ids.length ==0){
			jQuery.notify("<?php _e('Please Select At Least One Holiday To Delete',WF_A_P_SYSTEM); ?>", {type:"",icon:"check",align:"center", verticalAlign:"middle",color: "#fff", background: "#FF0000"}); 
		}
		else{
		jQuery.confirm({
			title: '<?php _e("Please Confirm",WF_A_P_SYSTEM ); ?>',
			theme: 'black',
			content: '<?php _e("Are you sure to Delete Holiday?",WF_A_P_SYSTEM ); ?>',
			animation: 'rotate',
			closeAnimation: 'rotateXR',
			icon: 'fa fa-check-square-o',
			confirmButton: '<?php _e("Delete",WF_A_P_SYSTEM ); ?>',
			cancelButton: '<?php _e("Cancel",WF_A_P_SYSTEM ); ?>',
			confirm: function () {
				jQuery(".delete_holiday").prop('disabled', true);
				jQuery('.delete_holiday').html('<i class="fa fa-spinner fa-spin"></i><?php _e("Deleting",WF_A_P_SYSTEM ); ?>');
				
				jQuery.ajax({
				data:"id="+ids,
				url: location.href,
				type:"POST",
				success:function(res) {
						jQuery(".delete_holiday").prop('disabled', false);
						jQuery('.delete_holiday').html('<?php _e("Delete",WF_A_P_SYSTEM ); ?>');
						jQuery.notify("<?php _e('Holiday Delete Successfully',WF_A_P_SYSTEM ); ?>", {type:"success",icon:"check",align:"center", verticalAlign:"middle",color: "#3c763d", background: "#dff0d8"});
						jQuery('#display_holiday').DataTable().ajax.reload(null, false);
						jQuery('input[type=checkbox]').attr('checked',false); 
						if(res==1) {
							jQuery("#my_check_holiday:checked").each(function(){
								jQuery(this).parent.remove();
							})
						}
					}
				})
			},
		});
	}	
		return false;
	})
});

// all day off
jQuery(function () {
	jQuery("#allday").click(function () {
		if (jQuery(this).is(":checked")) {
			jQuery("#day_off").hide();
		} else {
			jQuery("#day_off").show();
		}
	});
});

function holiday_function(val) {
	if(val=="no") {
		jQuery(".all_hide").hide();	 
		jQuery(".p_date_hide").show();
	}

	if(val=="p_d") {
		jQuery(".all_hide").hide();
		jQuery(".p_date_hide").hide();	 
		jQuery(".p_date_show").show();	 
	}

	if(val=="daily") {
		jQuery(".all_hide").hide();	 
		jQuery(".hide_repeat_day").show();	 
		jQuery(".p_date_hide").show();
	}
	if(val=="weekly") {
		jQuery(".all_hide").hide();	
		jQuery(".hide_repeat_week").show();
		jQuery(".p_date_hide").show();	  
	}

	if(val=="bi_weekly") {
		jQuery(".all_hide").hide();
		jQuery(".hide_bi_repeat_week").show();
		jQuery(".p_date_hide").show();
	}	 

	if(val=="monthly") {
		jQuery(".all_hide").hide();
		jQuery(".hide_repeat_month").show();
		jQuery(".p_date_hide").show();
	}
}

// all day off on update form
jQuery(function (){
 jQuery(document).on("click", '#allday_update', function (event) {
		if(jQuery(this).is(":checked")) {
			jQuery("#day_off_update").hide();
		} else {
			jQuery("#day_off_update").show();
		}
	});
});
</script>
<?php
global $wpdb;
if(isset($_REQUEST['name'])) {
	if(isset($_REQUEST['allday'])) {$allday=sanitize_text_field($_REQUEST['allday']); } else { $allday="0"; }
	$name=sanitize_text_field($_REQUEST['name']);
	$start_time=sanitize_text_field($_REQUEST['start_time']);
	$end_time=sanitize_text_field($_REQUEST['end_time']);
	$event_date=sanitize_text_field($_REQUEST['event_date']);
	$repeat=sanitize_text_field($_REQUEST['repeat']);
	$re_days=sanitize_text_field($_REQUEST['re_days']);
	$re_weeks=sanitize_text_field($_REQUEST['re_weeks']);
	$re_biweeks=sanitize_text_field($_REQUEST['re_biweeks']);
	$re_months=sanitize_text_field($_REQUEST['re_months']);
	$start_date=sanitize_text_field($_REQUEST['start_date']);
	$end_date=sanitize_text_field($_REQUEST['end_date']);
	$note=sanitize_text_field($_REQUEST['note']);
	$wpdb->insert($wpdb->prefix.'apt_holidays',array('all_off' => $allday,'name' =>$name,'start_time' => $start_time,'end_time' => $end_time,'holiday_date' => $event_date,'repeat_value' => $repeat,'repeat_days' => $re_days,'repeat_weeks' => $re_weeks,'repeat_bi_weeks' => $re_biweeks,'repeat_month' => $re_months,'start_date' => $start_date,'end_date' => $end_date,'notes' =>$note,));
}


if(isset($_REQUEST['name_update'])) {
	if(isset($_REQUEST['allday_update'])) {$allday_update=sanitize_text_field($_REQUEST['allday_update']); } else { $allday_update="0"; }
	$update_holiday_value=sanitize_text_field($_REQUEST['update_holiday_value']);		
	//$allday_update=sanitize_text_field($_REQUEST['allday_update']);
	$name_update=sanitize_text_field($_REQUEST['name_update']);
	$start_time_update=sanitize_text_field($_REQUEST['start_time_update']);
	$end_time_update=sanitize_text_field($_REQUEST['end_time_update']);
	$event_date_update=sanitize_text_field($_REQUEST['event_date_update']);
	$repeat_update=sanitize_text_field($_REQUEST['repeat_update']);
	$re_days_update=sanitize_text_field($_REQUEST['re_days_update']);
	$re_weeks_update=sanitize_text_field($_REQUEST['re_weeks_update']);
	$re_biweeks_update=sanitize_text_field($_REQUEST['re_biweeks_update']);
	$re_months_update=sanitize_text_field($_REQUEST['re_months_update']);
	$start_date_update=sanitize_text_field($_REQUEST['start_date_update']);
	$end_date_update=sanitize_text_field($_REQUEST['end_date_update']);
	$note_update=sanitize_text_field($_REQUEST['note_update']);
	$wpdb->update($wpdb->prefix.'apt_holidays',array('all_off' => $allday_update,'name' =>$name_update,'start_time' => $start_time_update,'end_time' => $end_time_update,'holiday_date' => $event_date_update,'repeat_value' => $repeat_update,'repeat_days' => $re_days_update,'repeat_weeks' => $re_weeks_update,'repeat_bi_weeks' => $re_biweeks_update,'repeat_month' => $re_months_update,'start_date' => $start_date_update,'end_date' => $end_date_update,'notes' =>$note_update,),array('id'=>$update_holiday_value));
	$wpdb->show_errors(); 
	$wpdb->print_error();
}

//single delete
if(isset($_REQUEST['holiday_id'])) {
	$del=$_REQUEST['holiday_id'];
	$wpdb->delete( $wpdb->prefix.'apt_holidays', array( 'id' => $del ));
}

// multi delete
if(isset($_REQUEST['id'])) { 
	$id_array =sanitize_text_field($_REQUEST['id']);
	$arr=explode(',',$id_array);
	echo $id_count = count($arr);
	for($i=0;$i<=$id_count;$i++) {
		$del=$arr[$i];
		$wpdb->delete( $wpdb->prefix.'apt_holidays', array( 'id' =>$del ) );
		$wpdb->show_errors();
		$wpdb->print_error();
	}
}
?>
<div class="panel panel-default">
	<div class="panel-heading"><i class="fa fa-coffee"></i><span class="panel_heading"><?php _e('Holiday',WF_A_P_SYSTEM); ?></span>
		<div class="theme-export">
			<button type="button" class="btn theme-customer add-customer" data-toggle="modal" data-target="#holi_day"> <i class="fa fa-plus" aria-hidden="true"></i><?php _e(' Add Holiday',WF_A_P_SYSTEM); ?></button>
		</div>
	</div>
	<div class="panel-body">
		<div class="theme-add-customer">    
			<div class="modal fade" id="holi_day" role="dialog">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title"><?php _e('Add Holiday',WF_A_P_SYSTEM); ?></h4>
						</div>
						<div class="col-md-12 modal-body">
							<div class="form-group">
								<form action="" method="post" id="form_holiday">
								<div class="row ad-ser">
									<div class="col-md-12 col-sm-12">
										<label><?php _e('All Day Off',WF_A_P_SYSTEM); ?></label>
										<input name="allday" id="allday" type="checkbox" value="1"  class="form-control"/>
									</div>
								</div>
								<div class="row ad-ser">
									<div class="col-md-12 col-sm-12">
										<label><?php _e('Name',WF_A_P_SYSTEM); ?></label>
										<input name="name" id="name" type="text" class="form-control" />
										<span  class="validation_alert" id="holiday_name_alert"><?php _e("This field is required",WF_A_P_SYSTEM ); ?></span>
									</div>
								</div>
								<div class="row ad-ser" id="day_off">
									<div class="col-md-6 col-sm-6">
										<label><?php _e('Start Time',WF_A_P_SYSTEM); ?></label>
										<div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
											<input name="start_time" id="start_time_holiday" type="text" class="form-control" value="<?php echo "10:00"; ?>" />
										</div>
									</div>
									<div class="col-md-6 col-sm-6">
										<label><?php _e('End Time',WF_A_P_SYSTEM); ?></label>
										<div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
											<input name="end_time" id="end_time_holiday" type="text" class="form-control" value="<?php echo "10:30"; ?>" />
										</div>
									</div>
								</div>
								<div class="row ad-ser p_date_hide">
									<div class="col-md-12 col-sm-12">
										<label><?php _e('Date',WF_A_P_SYSTEM); ?></label>
										<input name="event_date" id="event_date" type="text" class="form-control holiday_dates" value="<?php echo date("m/d/Y"); ?>" />
									</div>
								</div>
								<div class="row ad-ser">
									<div class="col-md-12 col-sm-">
										<label ><?php _e('Repeat',WF_A_P_SYSTEM); ?></label>
										<select name="repeat" id="repeat"  class="form-control" onchange="holiday_function(this.value)">
											<option  value="no"><?php _e('No',WF_A_P_SYSTEM); ?></option>
											<option  value="p_d"><?php _e('Particular Date(s)',WF_A_P_SYSTEM); ?></option>
											<option  value="daily"><?php _e('Daily',WF_A_P_SYSTEM); ?></option>
											<option  value="weekly"><?php _e('Weekly',WF_A_P_SYSTEM); ?></option>
											<option  value="bi_weekly"><?php _e('Bi-Weekly',WF_A_P_SYSTEM); ?></option>
											<option  value="monthly"><?php _e('Monthly',WF_A_P_SYSTEM); ?></option>
										</select>
									</div>
								</div>
								<div class="row ad-ser hide_repeat_day all_hide" style="display:none">
									<div class="col-md-12 col-sm-12">
										<label><?php _e('Repeat Day(s)',WF_A_P_SYSTEM); ?></label>
										<input name="re_days" id="re_days" type="number" value="0" maxlength="2" class="form-control" />
									</div>
								</div>

								<div class="row ad-ser hide_repeat_week all_hide" style="display:none">	  
									<div class="col-md-12 col-sm-12">
										<label><?php _e('Repeat Week(s)',WF_A_P_SYSTEM); ?></label>
										<input name="re_weeks" id="re_weeks" type="number" value="0" maxlength="2" class="form-control" />
									</div>
								</div>
								<div class="row ad-ser hide_bi_repeat_week all_hide" style="display:none">
									<div class="col-md-12 col-sm-12">
										<label><?php _e('Repeat Bi-Week(s)',WF_A_P_SYSTEM); ?></label>
										<input name="re_biweeks" id="re_biweeks" type="number" value="0" maxlength="2" class="form-control" />
									</div>
								</div>
								<div class="row ad-ser hide_repeat_month all_hide" style="display:none">
									<div class="col-md-12 col-sm-12">
										<label ><?php _e('Repeat Month(s)',WF_A_P_SYSTEM); ?></label>	
										<input name="re_months" id="re_months" type="number" value="0"  maxlength="2" class="form-control" />	
									</div>
								</div>
								<div class="row ad-ser all_hide p_date_show all_hide" style="display:none">
									<div class="col-md-6 col-sm-6">
										<label><?php _e('Start Date',WF_A_P_SYSTEM); ?></label>
										<input name="start_date" id="start_date" type="text" maxlength="2" class="form-control holiday_dates" value="<?php echo date("m/d/Y"); ?>" />
									</div>
									<div class="col-md-6 col-sm-6">
										<label><?php _e('End Date',WF_A_P_SYSTEM); ?></label>
										<input name="end_date" id="end_date"  type="text" class="form-control holiday_dates" value="<?php echo date("m/d/Y"); ?>" />
									</div>
								</div>	
								<div class="col-md-12 col-sm-12">
									<label ><?php _e('Note',WF_A_P_SYSTEM); ?></label>
									<textarea name="note" id="note" size="7" class="form-control" ></textarea>
								</div>								
							</div>
						</div>
						<div class="modal-footer">
							<button name="create" id="create" class="btn btn-primary save_appt_holiday" type="button"  onclick="return holiday_save();"><?php _e('Create Holiday',WF_A_P_SYSTEM); ?></button>
							<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Cancel',WF_A_P_SYSTEM); ?></button>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="holi_day_update" role="dialog">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title"> <?php _e('Update Holiday',WF_A_P_SYSTEM); ?></h4>
						</div>
						<div class="col-md-12 modal-body">
							<div class="form-group" id="holiday_html_fetch"></div>
						</div>
						<div class="modal-footer">
							<button name="create" id="create" class="btn btn-primary update_appt_holiday" type="button" onclick="return holiday_update();"><?php _e('Update Holiday',WF_A_P_SYSTEM); ?></button>
							<button type="button" class="btn btn-default" data-dismiss="modal"> <?php _e('Cancel',WF_A_P_SYSTEM); ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div id="mydiv" class="table-responsive">
			<form method="post" id="holiday_del" name="holiday_del" >
				<table  id="display_holiday" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th style="padding: 10px 12px;" class="nosort"><input type="checkbox" name="selec_tall_holiday" id="selec_tall_holiday" value=""></th>
							<th class="sh_ow"> <?php _e('Name',WF_A_P_SYSTEM); ?></th>
							<th><?php _e('Date',WF_A_P_SYSTEM); ?></th>
							<th><?php _e('Time',WF_A_P_SYSTEM); ?></th>
							<th><?php _e('Repeat',WF_A_P_SYSTEM); ?></th>
							<th><?php _e('Status',WF_A_P_SYSTEM); ?></th>
							<th class="nosort"> <?php _e('Action',WF_A_P_SYSTEM); ?></th>
						</tr>
					</thead>
				</table>
				<a href="#" class="delete_holiday btn btn-link"> <i class="fa fa-trash-o" aria-hidden="true"></i><?php _e(' Delete',WF_A_P_SYSTEM); ?></a></td>
			</form>
		</div>
	</div>
</div>
<script>
var dateToday = new Date();
jQuery(function() {
	jQuery( ".holiday_dates" ).datepicker({
		minDate: dateToday,
	//beforeShowDay: DisableSpecificDates
	});
});
</script>