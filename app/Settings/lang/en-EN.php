<?php
define( 'APPTEXT', serialize([
	'message' 		=> 	[
		"required"	=> strtoupper(":attribute") . " is required",
		"size" 		=> strtoupper(":attribute") . " from :min to :max",
	],
	'text_control' 	=>	[
		'add_button' 		=>		'Add new',
		'del_button' 		=>		'Delete',
		'display_button' 	=>		'Display',
		'edit_button' 		=>		'Edit',
		'update_button' 	=>		'Update',
		'cancel_button' 	=>		'Cancel',
		'back_button' 		=>		'Back',
		'display_radio'		=>		[ 1 => 'Show', 0 => 'Hide' ],
		'default_radio'		=>		[ 1 => 'Yes', 0 => 'No' ],
	],
	'error'	=>	[
		'not_found_record'	=>		'Record is not found'
	],
	'info'	=>	[
		'no_record'	=>		'There is no record to display'
	],
]) );