<?php
class UserGroupQueue extends AppModel {
	public $useDbConfig = 'content';
	
	public $belongsTo = array(
		'UserGroup' => array(
			'fields' =>array(
				'id',
				'group_name'
			)
		)
	);
}
?>