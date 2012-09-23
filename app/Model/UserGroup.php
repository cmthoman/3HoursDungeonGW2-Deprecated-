<?php
class UserGroup extends AppModel {
		
	public $useDbConfig = 'content';
	
	public $hasMany = array(
		'UserProfile'
	);
}
?>