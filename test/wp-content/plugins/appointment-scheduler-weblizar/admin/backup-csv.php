<?php
if(isset($_REQUEST['customer'])) {
	require_once '../../../../wp-load.php';
	header('Content-Type: text/csv');
	header('Content-Disposition: inline; filename="All Customer List-'.date('Y-m-d-H-i-s').'.csv"');
	$results = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix ."apt_clients");
	echo "First Name,Last Name,Phone,Skype Id,Email,Notes\r\n";   
	if (count($results)) {
		foreach($results as $result) {
			echo $result->first_name.",".$result->last_name .",".$result->phone.",".$result->skype_id .", ".$result->email .",".$result->notes."\r\n";
		}
	}
}

if(isset($_REQUEST['services'])) {
	require_once '../../../../wp-load.php';
	header('Content-Type: text/csv');
	header('Content-Disposition: inline; filename="All Services List-'.date('Y-m-d-H-i-s').'.csv"');
	$results = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix ."apt_services");
	echo "Services Name,Icon,Color,Duration,Padding Time Before,Padding After,Service Type,Price,Capacity,Category,Info Message\r\n";   
	if (count($results))  {
		foreach($results as $result) {
			echo $result->name.",".$result->icon .",".$result->color.",".$result->duration .", ".$result->p_before .",".$result->p_after.",".$result->service_type.",".$result->price.",".$result->capacity.",".$result->category.",".$result->info_message."\r\n";
		}
	}
}

if(isset($_REQUEST['appoinment'])) {
	require_once '../../../../wp-load.php';
	header('Content-Type: text/csv');
	header('Content-Disposition: inline; filename="All Appointment List-'.date('Y-m-d-H-i-s').'.csv"');
	$results = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix ."apt_appointments");
	echo "Client Name,Staff Member,Service Type	,Contact,Booking Date,Start Time,End Time,Status,Client Email,Staff Email,Appointment Unique Id\r\n";   
	if (count($results))  {
		foreach($results as $result) {
			echo $result->client_name.",".$result->staff_member .",".$result->service_type.",".$result->contact .",".$result->booking_date.",".$result->start_time.",".$result->end_time.",".$result->status.", ".$result->payment_status." ,".$result->client_email.",".$result->staff_email.",".$result->appt_unique_id."\r\n";
		}
	}
}