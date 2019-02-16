<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
wp_enqueue_style( 'respport-banner', WPFRANK_A_P_SYSTEM . 'css/aps-banner.css' );
$aps_imgpath = WPFRANK_A_P_SYSTEM . "images/aps1.png";
?>
<div class="wb_plugin_feature notice">
    <div class="wb_plugin_feature_banner default_pattern pattern_ ">
        <div class="wb-col-md-6 wb-col-sm-12 box">
            <div class="ribbon"><span>Check Pro</span></div>
            <img class="wp-img-responsive" src="<?php echo $aps_imgpath; ?>" alt="img">
        </div>
        <div class="wb-col-md-6 wb-col-sm-12 wb_banner_featurs-list">
            <span class="gp_banner_head"><h2><?php _e( 'Appointment Scheduler Pro Features', WF_A_P_SYSTEM ); ?> </h2></span>
            <ul>
                <li><?php _e( 'Experience Responsive Scheduling', WF_A_P_SYSTEM ); ?></li>
                <li><?php _e( 'Unlimited Bookings, Unlimited Staff & Unlimited Services', WF_A_P_SYSTEM ); ?></li>
                <li><?php _e( 'Statistical Administrator Dashboard', WF_A_P_SYSTEM ); ?></li>
                <li><?php _e( 'Notification', WF_A_P_SYSTEM ); ?></li>
                <li><?php _e( 'Appointment Management', WF_A_P_SYSTEM ); ?></li>
                <li><?php _e( 'Business Hours Widget', WF_A_P_SYSTEM ); ?></li>
                <li><?php _e( 'Export', WF_A_P_SYSTEM ); ?></li>
                <li><?php _e( 'Calendar View', WF_A_P_SYSTEM ); ?></li>
                <li><?php _e( 'Staff Time Schedule', WF_A_P_SYSTEM ); ?></li>
                <li><?php _e( 'PayPal Secure Payment', WF_A_P_SYSTEM ); ?></li>
                <li><?php _e( 'Appearance Settings', WF_A_P_SYSTEM ); ?></li>
                <li><?php _e( 'Reminders', WF_A_P_SYSTEM ); ?></li>
            </ul>
            <div class="wp_btn-grup">
                <a class="wb_button-primary" href="https://wpfrank.com/demo/appointment-scheduler-pro/"
                   target="_blank"><?php _e( 'View Demo', WF_A_P_SYSTEM ); ?></a>
                <a class="wb_button-primary" href="https://wpfrank.com/account/signup/appointment-scheduler-pro"
                   target="_blank"><?php _e( 'Buy Now', WF_A_P_SYSTEM ); ?> $39</a>
            </div>

        </div>
    </div>
</div>