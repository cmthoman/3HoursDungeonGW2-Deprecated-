<?php
class UserGroupsController extends AppController {
	
	public $uses = array('UserGroupQueue');
	
	function index(){
		$globalUserData = $this->Session->read('User.globalData'); //Set globalUserData
		$localUserData = $this->Session->read('User.localData'); //Set localUserData
		if($globalUserData['Admin'] == 'true' or $globalUserData['Editor'] == 'true' or $globalUserData['Moderator'] == 'true'
		or $localUserData['Editor'] == 'true' or $localUserData['Moderator'] == 'true'){
			if($UserGroupQueue = $this->UserGroupQueue->find('all', array('limit' => 25))){
				$pendingGroups = array();
				foreach($UserGroupQueue as $UserGroupQueue){
					$viewUserData = $this->User->find('first', array(
						'conditions' => array(
							'User.id' => $UserGroupQueue['UserGroupQueue']['user_id']
						), 
						'fields' => array(
							'User.username',
							'User.email',
							'User.id'
						))
					);
					$pendingUser = array(
										'user_name' => $viewUserData['User']['username'],
										'user_email' => $viewUserData['User']['email'],
										'user_group_id' => $UserGroupQueue['UserGroup']['id'],
										'group_name' => $UserGroupQueue['UserGroup']['group_name'],
										'user_profile_id' => $viewUserData['UserProfile']['id'],
										'display_name' => $viewUserData['UserProfile']['display_name'],
										'user_group_queue_id' => $UserGroupQueue['UserGroupQueue']['id']
									);
					array_push($pendingGroups, $pendingUser);
				}
				$this->set('pendingGroups', $pendingGroups);
				$this->set('debug', $UserGroupQueue);
			}else{
				$this->set('pendingGroups', NULL);
			}
			
			if ($this->request->is('post')){
				if($this->request->data['UserGroup']['approve'] == 'true'){
					$this->UserProfile->id = $this->request->data['UserGroup']['user_profile_id'];
					$this->UserProfile->set('user_group_id', $this->request->data['UserGroup']['user_group_id']);
					$this->UserProfile->save();
					$this->UserGroupQueue->delete($this->request->data['UserGroup']['user_group_queue_id']);
					$this->Session->setFlash('User was approved');
					$this->redirect(array('controller' => 'usergroups'));
				}else{
					$this->UserGroupQueue->delete($this->request->data['UserGroup']['user_group_queue_id']);
					$this->Session->setFlash('User was denied');
					$this->redirect(array('controller' => 'usergroups'));
				}
			}
		}else{
			$this->Session->setFlash('You lack the proper permissions to perform that action!');
			$this->redirect(array('controller' => 'home'));
		}
	}	
}
?>