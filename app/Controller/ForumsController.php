<?php
class ForumsController extends AppController {
	
	public $uses = array('FCategory', 'FForum', 'FTopic', 'FPost', 'FPostText');
	
	public $paginate = array(
		'FTopic' => array(
	        'limit' => 50,
	        'order' => array(
	            'FTopic.updated' => 'desc'
        	)
		),
		'FPost' => array(
	        'limit' => 10,
	        'order' => array(
	            'FPost.created' => 'asc'
        	)
		)
	);
	
	function index(){
		$this->FTopic->unbindModel(
			array('belongsTo' => array('User'))
		);
		
		$this->User->unbindModel(
			array('hasMany' => array('FTopic', 'FPost'))
		);
		
		$this->FForum->unbindModel(
			array('hasMany' => array('FTopic'))
		);
		
		$this->FCategory->unbindModel(
			array('hasMany' => array('FForum'))
		);
				
		$this->FPost->unbindModel(
			array('belongsTo' => array('FTopic', 'User'))
		);
		$this->FTopic->unbindModel(
			array('hasMany' => array('FPost'))
		);
		
		$topics = $this->FTopic->find('all', array('recursive' => 2, 'limit' => 50, 'order' => 'FTopic.updated DESC'));
		$validTopics = array();
		$topicCount = 0;
		foreach($topics as $topic){
			if($topic['FForum']['FCategory']['public'] == 'true'){
				if($topicCount < 6){
					$topicCount = $topicCount + 1;
					array_push($validTopics, $topic);
				}else{
					break;
				}
			}
		}
		$this->set('recentTopics', $validTopics);
		
		$this->FCategory->bindModel(
			array('hasMany' => array('FForum'))
		);
		
		$globalUserData = $this->Session->read('User.globalData');
		$localUserData = $this->Session->read('User.localData');
		if($globalUserData['Admin'] == 'true' or $globalUserData['Editor'] == 'true' or $localUserData['Editor'] == 'true'){
			$this->set('categories', $category = $this->FCategory->find('all'));
		}else{
			if($localUserData['Moderator'] == 'true' or $globalUserData['Moderator'] == 'true'){
				$this->set('categories', $category = $this->FCategory->find('all', array('conditions' => array('moderator' => 'true'))));
			}else
			if($localUserData['Officer'] == 'true'){
				$this->set('categories', $category = $this->FCategory->find('all', array('conditions' => array('officer' => 'true'))));
			}else
			if($localUserData['Member'] == 'true'){
				$this->set('categories', $category = $this->FCategory->find('all', array('conditions' => array('member' => 'true'))));
			}else{
				$this->set('categories', $category = $this->FCategory->find('all', array('conditions' => array('public' => 'true'))));
			}
		}
	}
	
	function createCategory(){
		$globalUserData = $this->Session->read('User.globalData'); //Set globalUserData
		if($globalUserData['Admin'] == 'true'){
			$groups = array(
				'Editor' => 'GW2 Editors',
				'Moderator' => 'GW2 Moderators',
				'Officer' => 'THD Officers',
				'Member' => 'THD Members',
				'Public' => 'Everyone'
			);
			$this->set('groups', $groups);
			
		if(!empty($this->request->data)){
			if($this->request->data['FCategory']['group'] == 'Editor'){
				$this->FCategory->set('editor', 'true');
				$this->FCategory->set('moderator', 'false');
				$this->FCategory->set('officer', 'false');
				$this->FCategory->set('member', 'false');
				$this->FCategory->set('public', 'false');
			}else
			if($this->request->data['FCategory']['group'] == 'Moderator'){
				$this->FCategory->set('editor', 'true');
				$this->FCategory->set('moderator', 'true');
				$this->FCategory->set('officer', 'false');
				$this->FCategory->set('member', 'false');
				$this->FCategory->set('public', 'false');
			}else
			if($this->request->data['FCategory']['group'] == 'Officer'){
				$this->FCategory->set('editor', 'true');
				$this->FCategory->set('moderator', 'true');
				$this->FCategory->set('officer', 'true');
				$this->FCategory->set('member', 'false');
				$this->FCategory->set('public', 'false');
			}else
			if($this->request->data['FCategory']['group'] == 'Member'){
				$this->FCategory->set('editor', 'true');
				$this->FCategory->set('moderator', 'true');
				$this->FCategory->set('officer', 'true');
				$this->FCategory->set('member', 'true');
				$this->FCategory->set('public', 'false');
			}else
			if($this->request->data['FCategory']['group'] == 'Public'){
				$this->FCategory->set('editor', 'true');
				$this->FCategory->set('moderator', 'true');
				$this->FCategory->set('officer', 'true');
				$this->FCategory->set('member', 'true');
				$this->FCategory->set('public', 'true');
			}
			if($this->FCategory->save($this->data)){
				$this->Session->setFlash('Category Created.');
				$this->redirect(array('controller' => 'forums', 'action' => 'index'));
			}else{
				$this->Session->setFlash('Category Failed to Create. If this problem persists please contact support.');
			}
		}
		}else{
			$this->Session->setFlash('You do not have access for the requested action!');
		}
	}

	function editCategory($id = NULL) {
		if(!empty($id)){
			$globalUserData = $this->Session->read('User.globalData'); //Set globalUserData
			if($globalUserData['Admin'] == 'true'){
				$groups = array(
					'Editor' => 'GW2 Editors',
					'Moderator' => 'GW2 Moderators',
					'Officer' => 'THD Officers',
					'Member' => 'THD Members',
					'Public' => 'Everyone'
				);
				$this->set('groups', $groups);
				$this->set('id', $id);
			    $this->FCategory->id = $id; //Set variable id to this news' ID
			    if ($this->request->is('get')) { //Makre sure we're are requesting data
			        $this->request->data = $this->FCategory->read(); //Read the data and insert into proper form fields
			        $this->set('data', $this->request->data);
			    }else{ //If we're not requesting data, we're sending it.
			    	if($this->request->data['FCategory']['group'] == 'Editor'){
						$this->FCategory->set('editor', 'true');
						$this->FCategory->set('moderator', 'false');
						$this->FCategory->set('officer', 'false');
						$this->FCategory->set('member', 'false');
						$this->FCategory->set('public', 'false');
					}else
					if($this->request->data['FCategory']['group'] == 'Moderator'){
						$this->FCategory->set('editor', 'true');
						$this->FCategory->set('moderator', 'true');
						$this->FCategory->set('officer', 'false');
						$this->FCategory->set('member', 'false');
						$this->FCategory->set('public', 'false');
					}else
					if($this->request->data['FCategory']['group'] == 'Officer'){
						$this->FCategory->set('editor', 'true');
						$this->FCategory->set('moderator', 'true');
						$this->FCategory->set('officer', 'true');
						$this->FCategory->set('member', 'false');
						$this->FCategory->set('public', 'false');
					}else
					if($this->request->data['FCategory']['group'] == 'Member'){
						$this->FCategory->set('editor', 'true');
						$this->FCategory->set('moderator', 'true');
						$this->FCategory->set('officer', 'true');
						$this->FCategory->set('member', 'true');
						$this->FCategory->set('public', 'false');
					}else
					if($this->request->data['FCategory']['group'] == 'Public'){
						$this->FCategory->set('editor', 'true');
						$this->FCategory->set('moderator', 'true');
						$this->FCategory->set('officer', 'true');
						$this->FCategory->set('member', 'true');
						$this->FCategory->set('public', 'true');
					}
					if($this->FCategory->save($this->data)){
						$this->Session->setFlash('Category id('.$id.') Edited!');
						$this->redirect(array('controller' => 'forums', 'action' => 'index'));
					}else{
						$this->Session->setFlash('Category id('.$id.') Failed to Edit. If this problem persists please contact support.');
					}
		   		}
			}else{ //User role or group was of insificient access, redirect to home page and set flash message
				$this->Session->setFlash('You do not have access for the requested action!');
				$this->redirect(array('controller' => 'home'));
			}
		}else{
			$this->redirect(array('controller' => 'home'));
		}
	}
	
	function deleteCategory($id = NULL){
		$globalUserData = $this->Session->read('User.globalData'); //Set globalUserData
		if($globalUserData['Admin'] == 'true'){ //If global user role or local user group is editor then allow the delete action
			if($this->FCategory->delete($id, true)){ //If news deletes redirect to home page and set flash message
				$this->Session->setFlash('Category id('.$id.') Was Successfully Deleted.');
				$this->Redirect(array('controller'=>'forums'));
			}else{//If news delete fails redirecte to home and set flash message
				$this->Session->setFlash('Category id('.$id.') Failed to Delete. If this problem persists please contact support.');
				$this->Redirect(array('controller'=>'forums'));
			}
		}else{ //User role or group was of insificiednt access, redirect to home page and set flash message
			$this->Session->setFlash('You do not have access for the requested action!');
			$this->Redirect(array('controller'=>'home'));
		}
	}

	function createForum(){
		$globalUserData = $this->Session->read('User.globalData'); //Set globalUserData
		if($globalUserData['Admin'] == 'true'){
			$categories = array();
			$allCategories = $this->FCategory->find('all');
			foreach($allCategories as $allCategories){
				$categoryId = $allCategories['FCategory']['id'];
				$categoryName = $allCategories['FCategory']['name'];
				$categories[$categoryId] = $categoryName;
			}
			$this->set('categories', $categories);
			if($this->FForum->save($this->data)){
				$this->Session->setFlash('Forum Created!');
				$this->redirect(array('controller' => 'forums', 'action' => 'index'));
			}
		}else{
			$this->Session->setFlash('You do not have access for the requested action!');
			$this->Redirect(array('controller'=>'home'));
		}
	}
	
	function editForum($id = null){
		if(!empty($id)){
			$globalUserData = $this->Session->read('User.globalData'); //Set globalUserData
			if($globalUserData['Admin'] == 'true'){
				$categories = array();
				$allCategories = $this->FCategory->find('all');
				foreach($allCategories as $allCategories){
					$categoryId = $allCategories['FCategory']['id'];
					$categoryName = $allCategories['FCategory']['name'];
					$categories[$categoryId] = $categoryName;
				}
				$this->set('categories', $categories);
				$this->FForum->id = $id; //Set variable id to this news' ID
			    if ($this->request->is('get')) { //Makre sure we're are requesting data
			        $this->request->data = $this->FForum->read(); //Read the data and insert into proper form fields
			    }else{ //If we're not requesting data, we're sending it.
				    if($this->FForum->save($this->data)){
						$this->Session->setFlash('Forum id('.$id.') Edited.');
						$this->redirect(array('controller' => 'forums', 'action' => 'index'));
					}else{
						$this->Session->setFlash('Forum id('.$id.') Failed to Edit. If this problem persists please contact support.');
					}
		   		}
			}else{
				$this->Session->setFlash('You do not have access for the requested action!');
				$this->Redirect(array('controller'=>'home'));
			}
		}
	}

	function viewForum($id = null){
		if(!empty($id)){
			$this->FTopic->unbindModel(
				array('belongsTo' => array('User', 'FForum'))
			);
			$this->FTopic->unbindModel(
				array('hasMany' => array('FPost'))
			);
			$this->FForum->unbindModel(
				array('hasMany' => array('FTopic'))
			);
			$this->FTopic->bindModel(
		        array('hasMany' => array(
		                'FPost' => array(
		                    'fields' => 'id'
		                )
		            )
		        )
		    );
			
			$this->set('forum', $forum = $this->FForum->find('first', array('conditions' => array('FForum.id' => $id), 'recursive' => 2)));
						
			$globalUserData = $this->Session->read('User.globalData');
			$localUserData = $this->Session->read('User.localData');
			if($globalUserData['Admin'] == 'true' or $globalUserData['Editor'] == 'true' or $localUserData['Editor'] == 'true'){
				$Access = 'Editor';
			}else
			if($globalUserData['Moderator'] == 'true' or $localUserData['Moderator'] == 'true'){
				$Access = 'Moderator';
			}else
			if($localUserData['Officer'] == 'true'){
				$Access = 'Officer';
			}else
			if($localUserData['Member'] == 'true'){
				$Access = 'Member';
			}else{
				$Access = 'Public';
			}
			
			if($forum['FCategory']['moderator'] == 'false'){
				if($Access != 'Editor'){
					$this->Redirect(array('controller'=>'forums','action'=>'index'));
				}
			}else
			if($forum['FCategory']['officer'] == 'false'){
				if($Access != 'Editor' && $Access != 'Moderator'){
					$this->Redirect(array('controller'=>'forums','action'=>'index'));
				}			
			}else
			if($forum['FCategory']['member'] == 'false'){
				if($Access != 'Editor' && $Access != 'Moderator' && $Access != 'Officer'){
					$this->Redirect(array('controller'=>'forums','action'=>'index'));
				}
			}else
			if($forum['FCategory']['public'] == 'false'){
				if($Access != 'Editor' && $Access != 'Moderator' && $Access != 'Officer' && $Access != 'Member'){
					$this->Redirect(array('controller'=>'forums','action'=>'index'));
				}
			}	
			$this->set('topics', $topics = $this->paginate('FTopic', array('FTopic.f_forum_id' => $id, 'FTopic.status_sticky' => 'false')));
			$this->set('stickies', $stickies = $this->FTopic->find('all', array('conditions' => array('FTopic.f_forum_id' => $id, 'FTopic.status_sticky' => 'true'))));
			$this->set('access', $Access);
		}
	}
	
	function createTopic($id = NULL){
		if($this->Auth->user()){
			if(!empty($id)){
				
				$forum = $this->FForum->find('first', array('conditions' => array('FForum.id' => $id), 'recursive' => 2));
				
				$globalUserData = $this->Session->read('User.globalData');
				$localUserData = $this->Session->read('User.localData');
				if($globalUserData['Admin'] == 'true' or $globalUserData['Editor'] == 'true' or $localUserData['Editor'] == 'true'){
					$Access = 'Editor';
				}else
				if($globalUserData['Moderator'] == 'true' or $localUserData['Moderator'] == 'true'){
					$Access = 'Moderator';
				}else
				if($localUserData['Officer'] == 'true'){
					$Access = 'Officer';
				}else
				if($localUserData['Member'] == 'true'){
					$Access = 'Member';
				}else{
					$Access = 'Public';
				}
				
				if($forum['FCategory']['moderator'] == 'false'){
					if($Access != 'Editor'){
						$this->Redirect(array('controller'=>'forums','action'=>'index'));
					}
				}else
				if($forum['FCategory']['officer'] == 'false'){
					if($Access != 'Editor' && $Access != 'Moderator'){
						$this->Redirect(array('controller'=>'forums','action'=>'index'));
					}			
				}else
				if($forum['FCategory']['member'] == 'false'){
					if($Access != 'Editor' && $Access != 'Moderator' && $Access != 'Officer'){
						$this->Redirect(array('controller'=>'forums','action'=>'index'));
					}
				}else
				if($forum['FCategory']['public'] == 'false'){
					if($Access != 'Editor' && $Access != 'Moderator' && $Access != 'Officer' && $Access != 'Member'){
						$this->Redirect(array('controller'=>'forums','action'=>'index'));
					}
				}	
				if($this->request->data){
					$this->FTopic->set('f_forum_id', $id);
					$this->FTopic->set('user_id', $this->Auth->user('id'));
					$this->FTopic->set('author', $this->Auth->user('username'));
					$this->FTopic->set('last_poster', $this->Auth->user('username'));
					$this->FTopic->set('replies', 0);
					$this->FTopic->set('views', 0);
					if($this->FTopic->save($this->data)){
						$topic = $this->FTopic->find('first', array('order' => array('FTopic.id' => 'desc')));
						$this->FPost->set('f_forum_id', $id);
						$this->FPost->set('f_topic_id', $topic['FTopic']['id']);
						$this->FPost->set('user_id', $this->Auth->user('id'));
						$this->FPost->set('body', $this->request->data['FTopic']['body']);
						if($this->FPost->save($this->data)){
							$this->Session->setFlash('Topic Created');
							$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$topic['FTopic']['id']));
						}else{
							$this->Session->setFlash('Your Topic Failed to Create. Please correct any errors and resubmit. If this problem persists please contact support.');
						}
					}
				}
			}
		}else{
			$this->Session->setFlash('You Must Log In To Post a New Topic!');
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}
	}

	function viewTopic($id = NULL){
		$this->FPost->unbindModel(
			array('belongsTo' => array('User'))
		);
		$this->UserRole->unbindModel(
			array('hasMany' => array('User'))
		);
		$this->UserProfile->unbindModel(
			array('belongsTo' => array('User'))
		);
		$this->UserGroup->unbindModel(
			array('hasMany' => array('UserProfile'))
		);
		$globalUserData = $this->Session->read('User.globalData'); //Set globalUserData
		$this->set('topicData', $post = $this->paginate('FPost', array('FPost.f_topic_id' => $id)));
		$userData = array();
		$userProfile = array();
		foreach($post as $post){
			$userProfileUserID = $post['FPost']['user_id'];
			array_push($userProfile, $userProfileUserID);
		}
		$userProfiles = array_unique($userProfile);
		foreach($userProfiles as $userProfile){
			$user = $this->User->find('first', array('conditions' => array('User.id' => $userProfile), 'recursive' => 3));
			$userDataHolder['Group'] = $user['UserProfile']['UserGroup']['group_name'];
			$userDataHolder['Server'] = $user['UserProfile']['server'];
			$userDataHolder['UserName'] = $user['User']['username'];
			$userDataHolder['UserID'] = $user['User']['id'];
			$userDataHolder['Avatar'] = $user['UserProfile']['avatar'];
			$userDataHolder['UserRole'] = $user['UserRole']['role_name'];
			array_push($userData, $userDataHolder);
		}
		$this->set('userData', $userData);
		$this->set('topicTitle', $post['FTopic']['title']);
		$this->set('topicLock', $post['FTopic']['status_lock']);
		$this->set('topicSticky', $post['FTopic']['status_sticky']);
		$this->set('topicID', $post['FTopic']['id']);
		$this->set('user', $user);
		$this->set('forumData', $this->FForum->find('first', array('conditions' => array('FForum.id' => $post['FTopic']['f_forum_id']))));
		if($this->Auth->user()){
			$list = $this->FForum->find('list');
			$this->set('forumList', $list);
			//$this->FTopic->id = $post['FTopic']['id'];
			//$this->FTopic->set('views', $post['FTopic']['views']+1);
			//$this->FTopic->save($this->data);
			if(!empty($this->request->data)){
				$this->FPost->set('f_topic_id', $id);
				$this->FPost->set('user_id', $this->Auth->user('id'));
				$this->FTopic->id = $post['FTopic']['id'];
				if(!empty($this->request->data['FTopic']['title'])){
					$this->FTopic->set('title', $this->request->data['FTopic']['title']);
					if($this->FTopic->save($this->data)){
						$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$id));
					}
				}
				if(!empty($this->request->data['FTopicMove']['f_forum_id'])){
					$this->FTopic->set('f_forum_id', $this->request->data['FTopicMove']['f_forum_id']);
					if($this->FTopic->save($this->data)){
						if($this->FPost->updateAll(
   							array('FPost.f_forum_id' => $this->request->data['FTopicMove']['f_forum_id']),
  							array('FPost.f_topic_id' => $id)
						)){
							$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$id));
						}
					}
				}
				if(!empty($this->request->data['FPost']['body'])){
					$this->FPost->set('f_forum_id', $post['FTopic']['f_forum_id']);
					if($this->FPost->save($this->data)){
						$this->User->id = $this->Auth->User('id');
						$this->FTopic->set('replies', $post['FTopic']['replies']+1);
						$this->FTopic->set('last_poster', $globalUserData['UserName']);
						$this->FTopic->save($this->data);
						//$this->User->set('f_post_count', $this->Auth->User('f_post_count') + 1);
						//$this->User->save($this->data);
						$this->Session->setFlash('Reply Submitted');
						$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$id));
					}
				}else{
					//$this->Session->setFlash('Please correct any errors and resubmit. If this problem persists please contact support.');
				}
			}
		}
	}

	function editPost($id = NULL){
		if(!empty($id)){
			$globalUserData = $this->Session->read('User.globalData'); //Set globalUserData
			$localUserData = $this->Session->read('User.localData'); //Set globalUserData
			$postData = $this->FPost->find('first', array('conditions' => array('FPost.id' => $id)));
			if($globalUserData['Admin'] == 'true' or $globalUserData['Editor'] == 'true' or $globalUserData['Moderator'] == 'true' or $localUserData['Editor'] == 'true' 
			or $localUserData['Moderator'] == 'true' or $globalUserData['id'] == $postData['FPost']['user_id']){
				$this->FPost->id = $id; //Set variable id to this news' ID
			    if($this->request->is('get')) { //Makre sure we're are requesting data
			        $this->request->data = $this->FPost->read(); //Read the data and insert into proper form fields
			    }else{ //If we're not requesting data, we're sending it.
				    if($this->FPost->save($this->data)){
						$this->Session->setFlash('Post Edited!');
						$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$postData['FPost']['f_topic_id']));
					}else{
						$this->Session->setFlash('Please correct any errors and resubmit. If this problem persists please contact support.');
					}
				}
			}else{
				$this->Session->setFlash('You lack the proper permission to edit that post! Make sure you are still logged in!');
				$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$postData['FPost']['f_topic_id']));
			}
		}
	}

	function deletePost($id = NULL){
		$globalUserData = $this->Session->read('User.globalData'); //Set globalUserData
		$localUserData = $this->Session->read('User.localData'); //Set globalUserData
		$postData = $this->FPost->find('first', array('conditions' => array('FPost.id' => $id)));
		if($globalUserData['Admin'] == 'true' or $globalUserData['Editor'] == 'true' or $globalUserData['Moderator'] == 'true' or $localUserData['Editor'] == 'true' 
		or $localUserData['Moderator'] == 'true' or $globalUserData['id'] == $postData['FPost']['user_id']){
			$this->FPost->id = $id; //Set variable id to this news' ID	
			$this->FPost->set('body', '[i]Post was deleted by '.$globalUserData['UserName'].'[/i]');
			if($this->FPost->save($this->data)){
				$this->Session->setFlash('Post Deleted!');
				$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$postData['FPost']['f_topic_id']));
			}else{
				$this->Session->setFlash('Post Failed to Delete!');
				$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$postData['FPost']['f_topic_id']));
			}
		}else{
			$this->Session->setFlash('You lack the proper permission to delete that post! Make sure you are still logged in!');
			$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$postData['FPost']['f_topic_id']));
		}
	}

	function lockTopic($id = NULL){
		if($this->Auth->user()){
			$globalUserData = $this->Session->read('User.globalData'); //Set globalUserData
			$localUserData = $this->Session->read('User.localData'); //Set globalUserData
			if($globalUserData['Admin'] == 'true' or $globalUserData['Editor'] == 'true' or $globalUserData['Moderator'] == 'true'
			or $localUserData['Editor'] == 'true' or $localUserData['Moderator'] == 'true'){
				$this->FTopic->id = $id;
				$this->FTopic->set('status_lock', 'true');
				if($this->FTopic->save($this->data)){
					$this->Session->setFlash('Thread has been locked!');
					$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$id));
				}else{
					$this->Session->setFlash('Thread id('.$id.') Failed to Lock! If this problem persists please contact support.');
					$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$id));
				}
			}else{
				$this->Session->setFlash('You do not have access for the requested action!');
				$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$id));
			}
		}else{
			$this->Session->setFlash('You do not have access for the requested action! Your session has expired.');
			$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$id));
		}
	}

	function unlockTopic($id = NULL){
		if($this->Auth->user()){
			$globalUserData = $this->Session->read('User.globalData'); //Set globalUserData
			$localUserData = $this->Session->read('User.localData'); //Set globalUserData
			if($globalUserData['Admin'] == 'true' or $globalUserData['Editor'] == 'true' or $globalUserData['Moderator'] == 'true'
			or $localUserData['Editor'] == 'true' or $localUserData['Moderator'] == 'true'){
				$this->FTopic->id = $id;
				$this->FTopic->set('status_lock', 'false');
				if($this->FTopic->save($this->data)){
					$this->Session->setFlash('Thread has been unlocked!');
					$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$id));
				}else{
					$this->Session->setFlash('Thread id('.$id.') Failed to unlock! If this problem persists please contact support.');
					$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$id));
				}
			}else{
				$this->Session->setFlash('You do not have access for the requested action!');
				$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$id));
			}
		}else{
			$this->Session->setFlash('You do not have access for the requested action! Your session has expired.');
			$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$id));
		}
	}

	function stickyTopic($id = NULL){
		if($this->Auth->user()){
			$globalUserData = $this->Session->read('User.globalData'); //Set globalUserData
			$localUserData = $this->Session->read('User.localData'); //Set globalUserData
			if($globalUserData['Admin'] == 'true' or $globalUserData['Editor'] == 'true' or $globalUserData['Moderator'] == 'true'
			or $localUserData['Editor'] == 'true' or $localUserData['Moderator'] == 'true'){
				$this->FTopic->id = $id;
				$this->FTopic->set('status_sticky', 'true');
				if($this->FTopic->save($this->data)){
					$this->Session->setFlash('Thread has been stickied!');
					$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$id));
				}else{
					$this->Session->setFlash('Thread id('.$id.') Failed to sticky!');
					$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$id));
				}
			}else{
				$this->Session->setFlash('You do not have access for the requested action!');
				$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$id));
			}
		}else{
			$this->Session->setFlash('You do not have access for the requested action! Your session has expired.');
			$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$id));
		}
	}

	function unstickyTopic($id = NULL){
		if($this->Auth->user()){
			$globalUserData = $this->Session->read('User.globalData'); //Set globalUserData
			$localUserData = $this->Session->read('User.localData'); //Set globalUserData
			if($globalUserData['Admin'] == 'true' or $globalUserData['Editor'] == 'true' or $globalUserData['Moderator'] == 'true'
			or $localUserData['Editor'] == 'true' or $localUserData['Moderator'] == 'true'){
				$this->FTopic->id = $id;
				$this->FTopic->set('status_sticky', 'false');
				if($this->FTopic->save($this->data)){
					$this->Session->setFlash('Thread has been unstickied!');
					$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$id));
				}else{
					$this->Session->setFlash('Thread id('.$id.') Failed to unsticky!');
					$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$id));
				}
			}else{
				$this->Session->setFlash('You do not have access for the requested action!');
				$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$id));
			}
		}else{
			$this->Session->setFlash('You do not have access for the requested action! Your session has expired.');
			$this->redirect(array('controller' => 'forums', 'action' => 'viewTopic/'.$id));
		}
	}
}
?>