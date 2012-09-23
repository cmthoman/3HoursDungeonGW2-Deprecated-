<?php
class SearchController extends AppController {
	
	public $helpers = array('Form', 'Html');
	public $components = array('Auth', 'Session');
	public $uses = array('Article');
	
	function beforeFilter(){
		parent::beforeFilter();
		$this->Security->csrfCheck = false;
	}
	
	function index(){
		$this->User->unbindModel(
			array('belongsTo' => array('UserRole'))
		);
		
		if($this->request->is('post')){
			$this->set('search', $search = $this->request->data['Search']['searchQuery']);
			if(strlen($search) > 3){
				$this->set('userCount', $this->User->searchCount($search));
				$this->set('articleCount', $this->Article->searchCount($search));
				$userResults = $this->User->search3($search);
				$users = array();
				foreach($userResults as $userResult){
					if(!empty($userResult['UserProfile']['id'])){
						array_push($users, $userResult);
					}
				}
				
				$articleResults = $this->Article->search3($search);
				$articles = array();
				foreach($articleResults as $articleResult){
					if(strlen($articleResult['Article']['title']) > 25){
						$articleResult['Article']['title'] = substr($articleResult['Article']['title'], 0, 25)."...";
						array_push($articles, $articleResult);
					}else{
						array_push($articles, $articleResult);
					}
				}
				$this->set('articleResults', $articles);
				$this->set('userResults', $users);
			}else{
				$this->Session->setFlash('Search terms must be at least 4 characters in length...Please try again.');
			}
		}
		
	}
	
}