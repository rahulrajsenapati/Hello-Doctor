<?php
require_once get_template_directory() . '/includes/options-config.php';
require_once get_template_directory() . '/admin/control-icon-picker.php';
	if( ! class_exists('Remedial_Customizer_API_Wrapper') ) {
		require_once get_template_directory() . '/admin/class.remedial-customizer-api-wrapper.php';
	}


Remedial_Customizer_API_Wrapper::getInstance($options);
