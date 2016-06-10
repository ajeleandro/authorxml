<?php
App::uses('AppController', 'Controller');
/**
 * Accesssites Controller
 *
 * @property Accesssite $Accesssite
 * @property PaginatorComponent $Paginator
 */
class AccesssitesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Accesssite->recursive = 0;
		$this->set('accesssites', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Accesssite->exists($id)) {
			throw new NotFoundException(__('Invalid accesssite'));
		}
		$options = array('conditions' => array('Accesssite.' . $this->Accesssite->primaryKey => $id));
		$this->set('accesssite', $this->Accesssite->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Accesssite->create();
			if ($this->Accesssite->save($this->request->data)) {
				$this->Session->setFlash(__('The accesssite has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The accesssite could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Accesssite->exists($id)) {
			throw new NotFoundException(__('Invalid accesssite'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Accesssite->save($this->request->data)) {
				$this->Session->setFlash(__('The accesssite has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The accesssite could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Accesssite.' . $this->Accesssite->primaryKey => $id));
			$this->request->data = $this->Accesssite->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Accesssite->id = $id;
		if (!$this->Accesssite->exists()) {
			throw new NotFoundException(__('Invalid accesssite'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Accesssite->delete()) {
			$this->Session->setFlash(__('The accesssite has been deleted.'));
		} else {
			$this->Session->setFlash(__('The accesssite could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
