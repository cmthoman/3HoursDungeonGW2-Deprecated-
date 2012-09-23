<?php
class UsersController extends AppController {
	
	var $components = array('Email');
	
	function beforeFilter(){
		parent::beforeFilter();
		$this->Security->csrfCheck = false;
	}
	
	function register(){
		if($this->Auth->user()){
			$this->redirect(array('controller' => 'home'));
		}else{
			if (!empty($this->data)) {
				$this->User->create();
				$this->request->data['User']['activate_hash'] = Security::hash(rand(20, 40), NULL, TRUE);
				if ($this->User->save($this->data)) {
					$email = new CakeEmail();
					$email->emailFormat('text');
					$email->template('activation', 'activation');
					$email->from(array('noreply@3hoursdungeon.com' => '3 Hours Dungeon'));
					$email->to($this->data['User']['email']);
					$email->subject('3 Hours Dungeon Account Activation');
					$email->send();
					$this->Session->setFlash('Your account was created. Please follow the link in your email to activate your new account.', 'flash_success');
					$this->redirect(array('action' => 'activate', 'username' => $this->data['User']['username'], 'email' => $this->data['User']['email']));
				}
			}
		}
	}
	
	public function login() {
		$this->Session->destroy('User');
		if($this->Auth->user()){
			$this->redirect(array('controller' => 'home'));
		}else{
		    if ($this->request->is('post')) {
		        if ($this->Auth->login()) {
		            return $this->redirect($this->Auth->redirect());
		        } else {
		            $this->Session->setFlash(__('Login failed! Please check your user name and password and try again!', true));
		        }
		    }
		}
	}
	
	public function logout(){
		$this->Auth->logout();
		$this->Session->destroy('User');
		$this->redirect(array('controller' => 'home'));
	}
	
	function activateAccount(){
		$username = $this->params['url']['username'];
		$key = $this->params['url']['key'];
		$activate_user = $this->User->find('first', array('conditions'=>array('User.username'=>$username, 'User.activate_hash'=>$key)));
		if(!empty($activate_user)){
			$this->User->id = $activate_user['User']['id'];
			if($this->User->saveField('active', 'true')){
				$this->User->saveField('activate_hash', Security::hash(rand(20, 40), NULL, TRUE));
				$this->redirect(array('action' => 'activateSuccess'));
			}else{
				$this->Session->setFlash('Account activation failed, please retry. If this problem persists please contact a site admin.');
				$this->redirect(array('action' => 'activate'));
			}
		}else{
			$this->Session->setFlash('Invalid activation data.');
			$this->redirect(array('action' => 'activate'));
		}
	}
	
	function activate(){
		
	}
	function activateSuccess(){
		
	}
}