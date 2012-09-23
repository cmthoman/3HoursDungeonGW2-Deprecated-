<?php
class User extends AppModel {
	
	var $actsAs = array("Search"); 
    var $fulltext = array("User.username", "User.email");
				
	public $belongsTo = array(
		'UserRole' => array(
			'type' => 'inner'
		)
	);
	
	public $hasOne = array(
		'UserProfile'
	);
	
	public $hasMany = array(
	);
	
	function formatName($data){
		if(isset($this->data['User']['username'])){
			$this->data['User']['username'] = ucfirst(strtolower($this->data['User']['username']));
		}
		return true;
	}
	
	
	function hashPasswords($data){
		if(isset($this->data['User']['password'])){
			$this->data['User']['password'] = Security::hash($this->data['User']['password'], NULL, TRUE);
			return $data;
		}
		return $data;
	}
	
	function matchPasswords($data){
		if($data['password'] == $this->data['User']['password2']){
			return TRUE;
		}
		$this->invalidate('password2', 'The passwords do not match');
		return FALSE;
	}
	
	function matchEmails($data){
		$this->data['User']['email'] = strtolower($this->data['User']['email']);
		$this->data['User']['email2'] = strtolower($this->data['User']['email2']);
		if($this->data['User']['email'] == $this->data['User']['email2']){
			return TRUE;
		}
		$this->invalidate('email2', 'The emails do not match');
		return FALSE;
	}
	
	function beforeSave(){
		$this->hashPasswords(NULL, TRUE);
		return TRUE;
	}
	
	var $validate = array(
		'username' => array(
		
			'formatName' => array(
				'rule' => 'formatName'
			),
			
			'alphanumeric' => array(
				'rule' => 'alphaNumeric',        
				'message' => 'Usernames must only contain letters and numbers.'
			),
			
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter a username.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'username_between_4_and_10' => array(
				'rule' => array('between', 4, 14),
				'message' => 'User Names must be between 4 and 14 characters in length.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'username_unique' => array(
				'rule' => 'isUnique',
				'message' => 'That user name is already taken.',
			)
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter a password.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'match_pass' => array(
				'rule' => 'matchPasswords',
				'message' => 'The Passwords do not match.',
			),
			'pass_at_least_6' => array(
				'rule' => array('minLength', 6),
				'message' => 'Passwords must be at least 6 characters in length.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'password2' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter a password.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),		
		'email' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter your e-mail address.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'email' => array(
				'rule' => array('email'),
				'message' => 'You must enter a valid email address.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'match_email' => array(
				'rule' => 'matchEmails',
				'message' => 'The emails do not match.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'email_is_unique' => array(
				'rule' => array('isUnique'),
				'message' => 'That Email address is already in use.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);	
}
?>