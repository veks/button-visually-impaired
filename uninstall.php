<?php
if (!defined('WP_UNINSTALL_PLUGIN'))
	exit();

$option_name = 'database_bvi';
delete_option($option_name);