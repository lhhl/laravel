<?php
define( 'BACKEND_TEXT', serialize([
	'message' 		=> 	[
		"required"	=> strtoupper(":attribute") . " is required",
		"size" 		=> strtoupper(":attribute") . " from :min to :max",
	],
	'text_control' 	=>	[
		'add_button' 		=>		'Add new',
		'del_button' 		=>		'Delete',
		'display_button' 	=>		'Change display',
		'default_button' 	=>		'Set as default',
		'edit_button' 		=>		'Edit',
		'update_button' 	=>		'Update',
		'cancel_button' 	=>		'Cancel',
		'back_button' 		=>		'Back',
		'search_button' 	=>		'Search',
		'file_button' 		=>		'Upload file',
	],
	'error'	=>	[
		'recordNotFound'	=>		'Record is not found',
		'insert'	=>		'Can\'t insert database',
		'update'	=>		'Can\'t update database',
		'delete'	=>		'Can\'t delete database',
		'changDisplay'	=>		'Can\'t change display',
		'changSort'	=>		'Can\'t change sort',
		'setDefault'	=>		'Can\'t set default',
	],
	'success'	=>	[
		'insert'	=>		'Insert successfully',
		'update'	=>		'Update successfully',
		'delete'	=>		'Delete successfully',
		'changeDisplay'	=>		'Change display successfully',
		'changeSort'	=>		'Change position successfully',
		'setDefault'	=>		'Set as default successfully',
	],
	'warning'	=>	[
		'noRecord'	=>		'There is no record to display'
	],
	'info'	=>	[
		'noRecord'	=>		'There is no record to display'
	],
]) );