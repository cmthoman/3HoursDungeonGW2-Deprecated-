<?
class FCategory extends AppModel {
	
	public $hasMany = array(
		'FForum' => array(
			'dependent' => true
		)
	);
	
	public $useDbConfig = 'content';
	
	public $validate = array(
    	'name' => array(
			'between' => array(
				'rule'    => array('between', 4, 40),
				'message' => 'ERROR: Forum Category Names Must be Between 4 and 75 Characters.'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'ERROR: Forum Category Name Missing.'
			)
		)
	);

}
?>