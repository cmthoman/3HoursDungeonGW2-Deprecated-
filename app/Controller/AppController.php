<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
 
 App::uses('CakeEmail', 'Network/Email');
 
class AppController extends Controller {
	
	public $helpers = array('Form', 'Html', 'bb', 'Time');
	public $components = array('Security', 'Auth', 'Session');
	public $uses = array('User', 'UserRole', 'UserProfile', 'UserGroup');
		
	function beforeFilter(){
		//Allow access to all actions of the website by default without authentication. Lock down specific features and pages later using $this->Auth->deny(); 
		$this->Auth->allow();
		$this->_checkSession();
		$this->_checkAccount();
	}
	
	function _checkAccount(){
		if($this->Auth->user()){
			$globalUserData = $this->Session->read('User.globalData');
			if($this->Auth->user('active') == 'false'){
				$this->set($error, 'Your account has not been activated, please check your email for the activation link!');
				$this->Auth->logout();
				$this->Session->destroy('User');
				$this->redirect(array('controller' => 'users', 'action' => 'activate'));
			}
			if($globalUserData['Banned'] == 'true'){
				$this->set($error, 'Your account has been suspended until '.$this->Auth->user('suspended').'!');
				$this->Auth->logout();
				$this->Session->destroy('User');
				$this->redirect(array('controller' => 'users', 'action' => 'banned'));
			}
		}
	}

	function _checkSession(){
		$userSession = $this->Session->check('User.globalData');
		if(!empty($userSession)){
			//Set the variable loggedIn
			$this->set('loggedIn', $this->_loggedIn());
			//Set the variable globalUserData
			$this->set('globalUserData', $this->Session->read('User.globalData'));
			//Set the variable localUserData
			$this->set('localUserData', $this->Session->read('User.localData'));
		}else{
			$globalUserData = $this->_defineGlobalUserData();
			$localUserData = $this->_defineLocalUserData();
			$this->Session->write('User.globalData', $globalUserData);
			$this->Session->write('User.localData', $localUserData);
			$this->set('loggedIn', $this->_loggedIn());
			//Set the variable globalUserData
			$this->set('globalUserData', $globalUserData);
			//Set the variable localUserData
			$this->set('localUserData', $localUserData);
		}
	}
	
	function _loggedIn(){
		//Define loggedIn
		$loggedIn = FALSE;
		//Check for user session
		if($this->Auth->user()){
			//If user session exists define loggedIn as True
			$loggedIn = TRUE;
		}else{
			$globalUserData['Admin'] = 'false';
			$globalUserData['Editor'] = 'false';
			$globalUserData['Moderator'] = 'false';
			$globalUserData['Banned'] = 'false';
			$globalUserData['id'] = 0;
			$this->Session->write('User.globalData', $globalUserData);
			
			$localUserData['Editor'] = 'false';
			$localUserData['Moderator'] = 'false';
			$localUserData['Officer'] = 'false';
			$localUserData['Member'] ='false';
			$this->Session->write('User.localData', $localUserData);
		}
		//Return the results of the log in test as TRUE or FALSE
		return $loggedIn;
	}
	
	function _defineGlobalUserData(){
		$globalUserData = NULL;
		//Check for user Log-In
		if($this->Auth->user()){
			//If user is logged in define user's global username
			$globalUserName = $this->Auth->user('username');
			//If User is logged in find user's global role
			if($globalUserData = $this->UserRole->find('first', array('conditions' => array('UserRole.id' => $this->Auth->user('user_role_id'))))){
				//If user's global role was found construct user's global data array
				$globalUserData = array(
					'RoleName' => $globalUserData['UserRole']['role_name'],
					'Color' => $globalUserData['UserRole']['color'],
					'Admin' => $globalUserData['UserRole']['admin'],
					'Editor' =>  $globalUserData['UserRole']['editor'],
					'Moderator' => $globalUserData['UserRole']['moderator'],
					'Banned' => $globalUserData['UserRole']['banned'],
					'UserName' => $globalUserName,
					'id' => $this->Auth->user('id')
				);
			}
		}
		return $globalUserData;
	}

		
	function _defineLocalUserData(){
		$localUserData = NULL;
		//Check for user Log-in
		if($this->Auth->user()){
			$this->User->unbindModel(
				array('belongsTo' => array('UserRole'))
			);
			$this->UserProfile->unbindModel(
				array('belongsTo' => array('UserGroup'))
			);
			//If logged-in, find user's local profile
			if($localUserProfile = $this->UserProfile->find('first', array('conditions' => array('UserProfile.user_id' => $this->Auth->user('id'))))){
				//If user's local profile was retrieved find user's local group
				if($localUserGroup = $this->UserGroup->find('first', array('conditions' => array('UserGroup.id' => $localUserProfile['UserProfile']['user_group_id'])))){
					//If user's local group was found construct user's local data array
					$localUserData = array(
						'DisplayName' => $localUserProfile['UserProfile']['display_name'],
						'Avatar' => $localUserProfile['UserProfile']['avatar'],
						'Server' => $localUserProfile['UserProfile']['server'],
						'Group' => $localUserGroup['UserGroup']['group_name'],
						'GroupID' => $localUserGroup['UserGroup']['id'],
						'Editor' => $localUserGroup['UserGroup']['editor'],
						'Moderator' => $localUserGroup['UserGroup']['moderator'],
						'Officer' => $localUserGroup['UserGroup']['officer'],
						'Member' => $localUserGroup['UserGroup']['member']
					);
				}
			}else{
				//If no profile was found, generate a default profile for this user
				$globalUserData = $this->_defineGlobalUserData(); //Define the global user data
				$this->UserProfile->set('user_id', $this->Auth->user('id')); //Set the user ID in the user's profile
				$this->UserProfile->set('avatar', "1");
				$this->UserProfile->set('display_name', $this->Auth->user('username'));
				$this->UserProfile->set('user_name', $this->Auth->user('username'));
				
				//Determine Global Role and Set Local Group Based on Global Role
				if($globalUserData['Admin'] == 'true'){
					$this->UserProfile->set('group_id', 1); //Set the user's group to "Community Editor" (default ID is 1) -- Highest Community Access!!!
				}else
				if($globalUserData['Editor'] == 'true'){
					$this->UserProfile->set('group_id', 1); //Set the user's group to "Community Editor" (default ID is 1) -- Highest Community Access!!!
				}else
				if($globalUserData['Moderator'] == 'true'){
					$this->UserProfile->set('group_id', 2); //Set the user's group to "Community Moderator" (default ID is 2)
				}else{
					$this->UserProfile->set('group_id', 3); //Set the user's group to "Community Member" (default ID is 3)
				}
				$this->UserProfile->save($this->data);
				$this->redirect(array('controller' => 'home'));
			}
		}
		return $localUserData;
	}
}