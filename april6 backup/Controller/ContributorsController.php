<?php
App::uses('AppController', 'Controller');
/**
 * Contributors Controller
 *
 * @property Contributor $Contributor
 * @property PaginatorComponent $Paginator
 */
class ContributorsController extends AppController {

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
		$this->Contributor->recursive = 0;
		$this->set('contributors', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Contributor->exists($id)) {
			throw new NotFoundException(__('Invalid contributor'));
		}
		$options = array('conditions' => array('Contributor.' . $this->Contributor->primaryKey => $id));
		$this->set('contributor', $this->Contributor->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Contributor->create();
			if ($this->Contributor->save($this->request->data)) {
				$this->Session->setFlash(__('The contributor has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contributor could not be saved. Please, try again.'));
			}
		}
		$affiliations = $this->Contributor->Affiliation->find('list', array('order' => array('ID' => 'desc')));
		$this->set(compact('affiliations'));
	}
    //array('controller' => 'categories', 'action' => 'add')

    public function quickadd() {
		if ($this->request->is('post')) {
			$this->Contributor->create();
			foreach ($this->request->data['Contributor'] as $key => $value) {
			    $this->request->data['Contributor'][$key] = trim($value);
			}
			if ($this->Contributor->save($this->request->data)) {
				$this->Session->setFlash(__('The contributor has been saved.'));
				return $this->redirect(array('controller' => 'affiliations', 'action' => 'close'));
			} else {
				$this->Session->setFlash(__('The contributor could not be saved. Please, try again.'));
			}
		}
		$affiliations = $this->Contributor->Affiliation->find('list', array('order' => array('ID' => 'desc')));
		$this->set(compact('affiliations'));
	}
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Contributor->exists($id)) {
			throw new NotFoundException(__('Invalid contributor'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Contributor->save($this->request->data)) {
				$this->Session->setFlash(__('The contributor has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contributor could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Contributor.' . $this->Contributor->primaryKey => $id));
			$this->request->data = $this->Contributor->find('first', $options);
		}
		$affiliations = $this->Contributor->Affiliation->find('list');
		$degrees = $this->Contributor->Degree->find('list');
		$this->set(compact('affiliations', 'degrees'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Contributor->id = $id;
		if (!$this->Contributor->exists()) {
			throw new NotFoundException(__('Invalid contributor'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Contributor->delete()) {
			$this->Session->setFlash(__('The contributor has been deleted.'));
		} else {
			$this->Session->setFlash(__('The contributor could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}