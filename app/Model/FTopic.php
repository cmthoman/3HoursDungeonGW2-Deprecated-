<?
class FTopic extends AppModel {
	
	public $useDbConfig = 'content';
	
	public $belongsTo = array(
		'FForum',
		'User'
	);
	
	public $hasMany = array(
		'FPost'
	);
	
	public $validate = array(
	
		'title' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'ERROR: Topic Title Missing.'
			),
			'maxLength' => array(
				'rule' => array('between', 4, 40),
				'message' => 'ERROR: Post Topic must be at least 4 characters and no more than 40 characters.'
			)
		),
	
		'body' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'ERROR: Topic Body Missing.'
			),
			'maxLength' => array(
				'rule' => array('between', 10, 7500),
				'message' => 'ERROR: Topic Body must be at least 10 characters and no more than 7500 characters per post.'
			)
		)
	);

}
?>