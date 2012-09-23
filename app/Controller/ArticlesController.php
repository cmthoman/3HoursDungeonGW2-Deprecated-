<?php
class ArticlesController extends AppController {
		
	public $uses = array('Article', 'FCategory', 'FForum', 'FTopic', 'FPost');
	
	function beforeFilter(){
		 parent::beforeFilter();
	}
		
	function delete($id = NULL){
		$globalUserData = $this->Session->read('User.globalData'); //Set globalUserData
		$localUserData = $this->Session->read('User.localData'); //Set localUserData
		if($globalUserData['Editor'] == 'true' or $localUserData['Editor'] == 'true'){ //If global user role or local user group is editor then allow the delete action
			if($this->Article->delete($id)){ //If news deletes redirect to home page and set flash message
				$this->Session->setFlash('Article id('.$id.') Deleted.');
				$this->Redirect(array('controller'=>'home'));
			}else{//If news delete fails redirecte to home and set flash message
				$this->Session->setFlash('Article id('.$id.') Failed to Delete. If this problem persists please contact support.');
				$this->Redirect(array('controller'=>'home'));
			}
		}else{ //User role or group was of insificiednt access, redirect to home page and set flash message
			$this->Session->setFlash('You do not have access for the requested action!');
			$this->Redirect(array('controller'=>'home'));
		}
	}
	
	function create(){
		$globalUserData = $this->Session->read('User.globalData'); //Set globalUserData
		$localUserData = $this->Session->read('User.localData'); //Set localUserData
		if($globalUserData['Editor'] == 'true' or $localUserData['Editor'] == 'true'){ //If global user role or local user group is editor then allow the create action
			if (!empty($this->data)) { //If the data field(s) are not empty continue
				$this->Article->set('user_id', $this->Auth->user('id')); //Save the user's ID to the news post to detemrine who posted it
				$this->Article->set('user_name', $this->Auth->user('username'));
				if ($this->Article->save($this->data)) { //Call the save function, if successful redirect to home and set flash message
					$this->Session->setFlash('Article Created.');
					$this->redirect(array('controller' => 'home'));
				}else{ //If news fails to save
					$this->Session->setFlash('Article Failed to Create. If this problem persists please contact support.');
				}
			}
		}else{ //User role or group was of insificiednt access, redirect to home page and set flash message
			$this->Session->setFlash('You do not have access for the requested action!');
			$this->redirect(array('controller' => 'home'));
		}
	}
	
	function edit($id = null) {
		if(!empty($id)){
			$globalUserData = $this->Session->read('User.globalData'); //Set globalUserData
			$localUserData = $this->Session->read('User.localData'); //Set localUserData
			if($globalUserData['Editor'] == 'true' or $localUserData['Editor'] == 'true'){ //If global user role or local user group is editor then allow the create action
			    $this->Article->id = $id; //Set variable id to this news' ID
			    if ($this->request->is('get')) { //Makre sure we're are requesting data
			        $this->request->data = $this->Article->read(); //Read the data and insert into proper form fields
			    }else{ //If we're not requesting data, we're sending it.
			        if ($this->Article->save($this->request->data)) { //Save the form data, if successfull redirect to home and set flash message
			            $this->Session->setFlash('Article id('.$id.') Edited');
			            $this->redirect(array('controller' => 'home'));
			        }else{ //If news failed to save, redirect to home and set flash message
			            $this->Session->setFlash('Article id('.$id.') Edit Failed. If this problem persists please contact support.');
					}
		   		}
			}else{ //User role or group was of insificiednt access, redirect to home page and set flash message
				$this->Session->setFlash('You do not have access for the requested action!');
				$this->redirect(array('controller' => 'home'));
			}
		}else{
			$this->redirect(array('controller' => 'home'));
		}
	}
	
	function archive(){
		/*************************
		* Retrieve Last 100 News *
		**************************/
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
		$topicCount = 0;
		$validTopics = array();
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
		
		
		$limit = 100; //How Many Articles
		$articles = $this->Article->find('all', array('order' => 'Article.id DESC', 'limit' => $limit)); //Retrieve Data and Store in array "news"
		$this->set('articles', $articles); //Push Retrieved Data to the View as an array called "news"
	}

	function read($id = NULL){
		/*****************************
		* Retrieve Requested Article *
		******************************/
		if(!empty($id)){
			
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
			$topicCount = 0;
			$validTopics = array();
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
			$article = $this->Article->find('first', array('conditions' => array('Article.id' => $id))); //Retrieve Data and Store in var "news"
			if(!empty($article)){
				$this->set('article', $article); //Push Retrieved Data to the View as an var called "news"
			}else{
				$this->redirect(array('controller' => 'home'));
			}
		}else{
			$this->redirect(array('controller' => 'home'));
		}
	}
	
	function preview(){
		
	}
}
?>