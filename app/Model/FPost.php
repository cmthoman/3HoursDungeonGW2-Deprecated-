<?
class FPost extends AppModel {
	
	public $useDbConfig = 'content';
	
	public $belongsTo = array(
		'FTopic',
		'User'
	);
	
	public $validate = array(
	
		'body' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'ERROR: Post Body Missing.'
			),
			'maxLength' => array(
				'rule' => array('between', 10, 7500),
				'message' => 'ERROR: Post Body must be at least 10 characters and no more than 7500 characters per post.'
			)
		)
	);
}
?>