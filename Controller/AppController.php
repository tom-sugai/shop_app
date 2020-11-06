<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	public $components = array(
			'Flash',
			'Auth' => array(
					'loginRedirect' => array(
							'controller' => 'products',
							'action' => 'index',
							'shop'
					),
					'logoutRedirect' => array(
							'controller' => 'pages',
							'action' => 'display',
							'shop'
					),
					'authenticate' => array(
							'Form' => array(
									'passwordHasher' => 'Blowfish'
							)
					),
					'authorize' => array('Controller') // この行を追加しました
			)
	);
	
	function beforeFilter() {
		$this->Auth->allow('index','view','display','logout');
		$this->Auth->authenticate = array(
				'Form' => array('userModel' => 'User','passwordHasher' => 'Blowfish')
		);
		$this->set('auth',$this->Auth);//これがないとログインログアウトの表示切替ができない
	
	}
	
	public function isAuthorized($user) {
		// Admin can access every action
		if (isset($user['role']) && $user['role'] === 'admin') {
			return true;
		}	
		// デフォルトは拒否
		return false;
	}
	

	

	
}


