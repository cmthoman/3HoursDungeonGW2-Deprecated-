<?php
class HomeController extends AppController {
	
	var $uses = array('Article', 'FPost', 'FTopic', 'FForum', 'FCategory');
		
	function beforeFilter(){
		parent::beforeFilter();
	}
	
	function index(){
		/***********************
		* Retrieve Latest News *
		***********************/
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
		
		$limit = 5; //How Many Articles
		$this->set('articles', $articles = $this->Article->find('all', array('order' => 'Article.id DESC', 'limit' => $limit))); //Push Retrieved Data to the View as an array called "news"
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
	}
}
?>