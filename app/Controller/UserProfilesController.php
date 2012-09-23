<?php
class UserProfilesController extends AppController {
	
	public $uses = array('UserGroupQueue');
	
	function index(){
		$limit = 10; //How Many Users
		$recentlyJoined = $this->UserProfile->find('all', array('order' => 'UserProfile.id DESC', 'limit' => $limit)); //Retrieve Data and Store in array "recentlyJoined"
	}
	
	function view($id = null){
		if(!empty($id)){
			$this->set('viewUserData', $viewUserData = $this->User->find('first', array('conditions' => array('User.id' => $id))));
			if(!empty($viewUserData['UserProfile']['id'])){
				$this->UserGroup->unbindModel(
				    array('hasMany' => array('UserProfile'))
				);
				$this->User->unbindModel(
					array('hasMany' => array('FPost'))
				);
				$this->set('viewUserGroupData', $viewUserGroupData = $this->UserGroup->find('first', array('conditions' => array('UserGroup.id' => $viewUserData['UserProfile']['user_group_id']))));
			}else{
				$this->redirect(array('controller' => 'home'));
			}
		}else{
			$this->redirect(array('controller' => 'home'));
		}
	}
	
	function edit($id = null){
		if(!empty($id)){
			$globalUserData = $this->Session->read('User.globalData'); //Set globalUserData
			$localUserData = $this->Session->read('User.localData'); //Set localUserData
			//Check for Global and Local Roles and set $Access
			if($globalUserData['Admin'] == 'true'){
				$Access = 'Admin';
			}else
			if($globalUserData['Editor'] == 'true' or $globalUserData['Editor'] == 'true' or $localUserData['Editor'] == 'true' or $localUserData['Moderator'] == 'true'){
				$Access = 'Moderator';
			}else{
				$Access = 'User';
			}
			$this->set('Access', $Access);
			//Retrieve ALL Necessary Data, Check Requestor's Role and Assign Access, Generate Editable Data...
			if($Access == 'Admin' or $Access == 'Moderator' or $globalUserData['id'] == $id){ //If global user role or local user group is editor then allow the create action
				$this->set('viewUserData', $viewUserData = $this->User->find('first', array('conditions' => array('User.id' => $id))));
				if(!empty($viewUserData)){
					$this->set('viewUserGroupData', $viewUserGroupData = $this->UserGroup->find('first', array('conditions' => array('UserGroup.id' => $viewUserData['UserProfile']['user_group_id']))));
					switch($Access){
						case 'User':
							$this->set('groups', '');
							$this->set('hideGroupDropdown', 'true');
							$this->set('availableGroups', $availableGroups = $this->UserGroup->find('all', array('conditions' => array('public' => 'true', 'UserGroup.id !=' => $viewUserData['UserProfile']['user_group_id']))));
							if(empty($availableGroups)){
								$this->set('availableGroups', NULL);
							}
						break;
						case 'Moderator':
							if($viewUserData['UserRole']['admin'] == 'true' or $viewUserData['UserRole']['moderator'] == 'true'
							or $viewUserData['UserRole']['editor'] == 'true' or $viewUserGroupData['UserGroup']['editor'] == 'true'
							or $viewUserGroupData['UserGroup']['moderator'] == 'true'){
								if($globalUserData['id'] != $id){
									$this->Session->setFlash('Moderators May Not Change Other Moderator, Admin or Editor Profiles!');
									$this->redirect(array('controller' => 'userprofiles', 'action' => 'view/'.$viewUserGlobalData['User']['id']));
								}else{
									$groups = array();
									if($globalUserData['id'] == $id){
										$groups = array($viewUserData['UserProfile']['user_group_id'] => 'Cannot Change Your Own Group!');
										$hideGroupDropdown = 'true';
									}
									$this->set('groups', $groups);
									$this->set('hideGroupDropdown', $hideGroupDropdown);
								}
							}else{
								$allGroups = $this->UserGroup->find('all');
								$hideGroupDropdown = 'false';
								foreach($allGroups as $allGroups){
									if($allGroups['UserGroup']['moderator'] == 'false' and $allGroups['UserGroup']['editor'] == 'false'){
										$groupId = $allGroups['UserGroup']['id'];
										$groupName = $allGroups['UserGroup']['group_name'];
										$groups[$groupId] = $groupName;
									}
								}
								$this->set('groups', $groups);
								$this->set('hideGroupDropdown', $hideGroupDropdown);
							}
						break;
						case 'Admin':
							$groups = array();
							$allGroups = $this->UserGroup->find('all');
							$hideGroupDropdown = 'false';
							foreach($allGroups as $allGroups){
								$groupId = $allGroups['UserGroup']['id'];
								$groupName = $allGroups['UserGroup']['group_name'];
								$groups[$groupId] = $groupName;
							}
							$this->set('groups', $groups);
							$this->set('hideGroupDropdown', $hideGroupDropdown);
						break;
					}
				}else{
					$this->Session->setFlash('Unable to Find User Profile Data!');
					$this->redirect(array('controller' => 'home'));
				}
				//Data has been retrieved, All for editable fields to be populated and/or saved...
				$this->UserProfile->id = $viewUserData['UserProfile']['id']; //Set variable id to this user's profile ID
			    if($this->request->is('get')) { //Makre sure we are requesting data
			        $this->request->data = $this->UserProfile->read(); //Read the data and insert into proper form fields
			        if($pendingGroup = $this->UserGroupQueue->find('first', array('conditions' => array('UserGroupQueue.user_id' => $id)))){
			        	$this->set('hideGroupApplication', 'true');
						$this->set('pendingGroup', $pendingGroup['UserGroupQueue']['user_group_name']);
			        }else{
			        	$this->set('hideGroupApplication', 'false');
			        }
			    }else{ //If we're not requesting data, we're sending it.
			    	if(!empty($this->request->data['UserGroupQueue'])){
						$data = array(
							'user_id' => $this->request->data['UserGroupQueue']['user_id'], 
							'user_group_id' => $this->request->data['UserGroupQueue']['user_group_id'],
							'user_group_name' => $this->request->data['UserGroupQueue']['user_group_name']
						);
						if($this->UserGroupQueue->find('first', array('conditions' => array('user_id' => $data['user_id'])))){
						}else{
							if($this->UserGroupQueue->save($data)){
								$this->Session->setFlash('Group Application Successful.');
								$this->redirect(array('controller' => 'UserProfiles', 'action' => 'edit/'.$viewUserData['User']['id']));
							}else{
								$this->Session->setFlash('Group Application Failed. If this problem persists please contact support.');
								$this->redirect(array('controller' => 'UserProfiles', 'action' => 'edit/'.$viewUserData['User']['id']));
							}
						}	
					}else{
						if($groupQueue = $this->UserGroupQueue->find('first', array('conditions' => array('UserGroupQueue.user_id' => $viewUserData['User']['id'])))){
							if($this->UserGroupQueue->delete($groupQueue['UserGroupQueue']['id'])){
								if ($this->UserProfile->save($this->request->data)) { //Save the form data, if successfull redirect to home and set flash message
						        	$this->Session->setFlash('Porfile Update Sucessfull.');
						            $this->redirect(array('controller' => 'UserProfiles', 'action' => 'edit/'.$viewUserData['User']['id']));
								}else{ //If profile failed to save, redirect to home and set flash message
									$this->Session->setFlash('Profile Update Failed.  If this problem persists please contact support');
									$this->redirect(array('controller' => 'UserProfiles', 'action' => 'edit/'.$viewUserData['User']['id']));
								}
							}else{
								$this->Session->setFlash('Profile Update Failed (Couldnt Delete User from Group Queue). If this problem persists please contact support');
								$this->redirect(array('controller' => 'UserProfiles', 'action' => 'edit/'.$viewUserData['User']['id']));
							}
						}else{
							if ($this->UserProfile->save($this->request->data)) { //Save the form data, if successfull redirect to home and set flash message
								if($globalUserData['id'] == $id){
									$localUserData['display_name'] = $this->request->data['UserProfile']['display_name'];
									$localUserData['Server'] = $this->request->data['UserProfile']['server'];
									$this->Session->write('User.localData', $localUserData);
								}
					        	$this->Session->setFlash('Porfile Update Sucessfull');
					            $this->redirect(array('controller' => 'UserProfiles', 'action' => 'view/'.$viewUserData['User']['id']));
							}else{ //If profile failed to save, redirect to home and set flash message
								$this->Session->setFlash('Profile Update Failed. Please correct any errors and resubmit. If this problem persists please contact support');
							}
						}
					}
		   		}
			}else{ //User role or group was of insificient access, redirect to home page and set flash message
				$this->Session->setFlash('You do not have access for the requested action!');
				$this->redirect(array('controller' => 'home'));
			}
		}else{ //Requested User ID does not exist redirect to home
			$this->Session->setFlash('The User Profile You Requested Does Not Exist!');
			$this->redirect(array('controller' => 'home'));
		}
	}
}
?>