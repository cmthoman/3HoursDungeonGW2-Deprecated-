<?
class FForum extends AppModel {
	
	public $useDbConfig = 'content';
	
	public $belongsTo = array(
		'FCategory'
	);
	
	public $hasMany = array(
		'FTopic'
	);
	
	public $validate = array(
    	'title' => array(
			'between' => array(
				'rule'    => array('between', 4, 40),
				'message' => 'ERROR: Forum Title Must be Between 4 and 40 Characters.'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'ERROR: Forum Title Missing.'
			)
		),
			
		'description' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'ERROR: Forum Description Missing.'
			),
			'between' => array(
				'rule' => array('between', 4, 115),
				'message' => 'ERROR: Forum Description Must be Between 4 and 40 Characters.'
			)
		)
	);
}
?>