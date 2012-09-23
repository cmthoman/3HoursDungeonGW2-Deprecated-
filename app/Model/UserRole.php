<?php
class UserRole extends AppModel {
	public $hasMany = array(
		'User'
	);
}
?>