<?php
class Article extends AppModel {
	
	public $useDbConfig = 'content';
	
	var $actsAs = array("Search"); 
    var $fulltext = array("Article.title", "Article.body_short", "Article.body");
		 
	public $validate = array(
    	'title' => array(
			'between' => array(
				'rule'    => array('between', 4, 75),
				'message' => 'ERROR: Article Title Must be Between 4 and 75 Characters.'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'ERROR: Article Title Missing.'
			)
		),
			
		'body_short' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'ERROR: Article Description Missing.'
			),
			'between' => array(
				'rule' => array('maxLength', 5000),
				'message' => 'ERROR: Article Description Must be 5,000 Characters or Less.'
			)
		),
		
		'body' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'ERROR: Article Body Missing.'
			),
			'maxLength' => array(
				'rule' => array('maxLength', 50000),
				'message' => 'ERROR: Article Body Must be 50,000 Characters or Less.'
			)
		)
	);
}
?>