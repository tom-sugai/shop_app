<?php
App::uses('AppController', 'Controller');
/**
 * Products Controller
 *
 * @property Product $Product
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class ProductsController extends AppController {
	public $helpers = array('Html','Form');	
	
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','Cookie', 'Session', 'Flash');
	
	public $paginate = array(
			'limit'=>3,
			'ordef'=> array(
					'Product.id' => 'desc'));
	
/**
 * productlist method
 * @param int(11) $id
 */	
	public function productlist($id = null) {
		$this->layout = false;
		if(!empty($id)) {
			$conditions = "Product.category_id ='" . $id . "'";
			$this->set('products', $this->paginate(null, $conditions));
		} else {
			$this->set('products',array());
		}
	}
/**
 * incart method
 * $paran int(11) $id
 */	
	public function incart($id=null) {
		if(!empty($id)) {
			$cart_list = array();
			$time = time() + (1 * 24 * 60 * 60); // keep time for cookie
			if($this->Cookie->read('cart') != "") {
				// get info from cookie and then save info to cookie
				$cart_list = unserialize($this->Cookie->read('cart'));
				$cart_list[] = $id;
				$cart_list = array_unique($cart_list); // omit dupulicate id
				// save info to cookie
				$this->Cookie->write('cart',serialize($cart_list),true,$time);
			} else {
				//save id to cookei
				$cart_list[] = $id;
				$this->Cookie->write('cart',serialize($cart_list),true,$time);
				$this->Cookie->read('cart');
			}
			// confirm to put id into the cart
			$detail = $this->Product->read(null,$id);
			$this->Session->setFlash("「" . $detail['Product']['name'] .	"」in to the cart." );
			$this->redirect($this->referer()); // return to caller page
		} else {
			$this->redirect($this->referer()); // return to caller page
		}
	}
/**
 *  cartlist method
 *  
 */
	public function cartlist() {
		$this->Product->recursive = 0;
		$conditions = array();
		$data = $this->Cookie->read('cart');
		debug($data);
		// get product from db that id given by cookie
		if($this->Cookie->read('cart') != ""){
			$cart = unserialize($this->Cookie->read('cart'));
			//debug($cart);
			$this->set('cart',$cart);		
			$options = array(
						'conditions' => array(
							'OR' => array(

							)
					)
			);		
			//debug($cart);
			foreach($cart as $value){
				$options['conditions']['OR'][] = "Product.id = " . $value . "";
			}		
			//debug($options);
			$this->set('products',$this->Product->find('all',$options));
			
		} else {
			$this->set('products',array());
		}
	}

/**
 * delcart method
 * param int(11) id
 * 
 */
	public function delcart($id = null){
		if(!empty($id)){
			$detail = $this->Product->read(null,$id);
			$cart = array();
			$time = time() + (1 * 24 * 60 * 60); // keep time for cookie
			if($this->Cookie->read('cart') != "") {
				// get info from cookie and then save info to cookie
				$cart = unserialize($this->Cookie->read('cart'));
				debug($cart);
				// confirm delete id in the cart
				foreach ($cart as $key => $value) {
					if($value == $id){
						unset($cart[$key]);
					}				
				}
				debug($cart);
				$cart = array_unique($cart); // omit dupulicate id				
				// save info to cookie
				debug($cart);
				$this->Cookie->write('cart',serialize($cart),true,$time);
			}
			$this->Session->setFlash("[deleted id : " . $detail['Product']['name'] ."  from cart.]");
			return $this->redirect(array('controller' => 'products','action' => 'cartlist')); // return to caller page
		} else {
			return $this->redirect(array('controller' => 'products','action' => 'cartlist'));
		}
	}
	
/**
 * index method
 *
 * @return void
 */
	public function index($id = null) {
		$this->Product->recursive = 1;
		//$this->layout = true;		
		if(!empty($id)) {
			$conditions = "Product.category_id ='" . $id . "'";
			$this->set('products',$this->paginate(null,$conditions));
		} else {
			$products = $this->paginate('Product');
			$this->set('products',$products);
		}
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Product->exists($id)) {
			throw new NotFoundException(__('Invalid product'));
		}
		$options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
		$this->set('product', $this->Product->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Product->create();
			if ($this->Product->save($this->request->data)) {
				$this->Flash->success(__('The product has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The product could not be saved. Please, try again.'));
			}
		}
		$categories = $this->Product->Category->find('list');
		$this->set(compact('categories'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Product->exists($id)) {
			throw new NotFoundException(__('Invalid product'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Product->save($this->request->data)) {
				$this->Flash->success(__('The product has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The product could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
			$this->request->data = $this->Product->find('first', $options);
		}
		$categories = $this->Product->Category->find('list');
		$this->set(compact('categories'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->Product->exists($id)) {
			throw new NotFoundException(__('Invalid product'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Product->delete($id)) {
			$this->Flash->success(__('The product has been deleted.'));
		} else {
			$this->Flash->error(__('The product could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

}