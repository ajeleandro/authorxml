<?php
App::uses('AppController', 'Controller');
/**
 * Affiliations Controller
 *
 * @property Affiliation $Affiliation
 * @property PaginatorComponent $Paginator
 */
class AffiliationsController extends AppController {

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
		$this->Affiliation->recursive = 0;
		$this->set('affiliations', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Affiliation->exists($id)) {
			throw new NotFoundException(__('Invalid affiliation'));
		}
		$options = array('conditions' => array('Affiliation.' . $this->Affiliation->primaryKey => $id));
		$this->set('affiliation', $this->Affiliation->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */

    public function addajax() {
		if ($this->request->is('post')) {
			$this->Affiliation->create();
			if ($this->Affiliation->save($this->request->data)) {
				$last = $this->Affiliation->read(null,$this->Affiliation->id);
                $response = array(
                    'id' => $last['Affiliation']['id'],
                    'Name' => $last['Affiliation']['Name']
                );
                // Send the json response
                //$this->sendJson($response);
                // Make sure no debug info is printed
                Configure::write('debug', 0); // Turn this to 2 for debugging
                // Set the data for view
                $this->set('response', $response);
                // We will use no layout
                $this->layout = '';

			} else {
				$this->Session->setFlash(__('The affiliation could not be saved. Please, try again. '));
			}
		}
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->Affiliation->create();
                $this->Session->setFlash(__('The affiliation has been saved.'));
			} else {
				$this->Session->setFlash(__('The affiliation could not be saved. Please, try again. '));
			}
		$contributors = $this->Affiliation->Contributor->find('list');
		$this->set(compact('contributors'));
	}

    public function quickadd() {
		if ($this->request->is('post')) {
			$this->Affiliation->create();
            $this->request->data['Affiliation']['Name'] = trim($this->request->data['Affiliation']['Name']); //trimming
			if ($this->Affiliation->save($this->request->data)) {
				$this->Session->setFlash(__('The affiliation has been saved.'));
				return $this->redirect(array('action' => 'close'));
			} else {
				$this->Session->setFlash(__('The affiliation could not be saved. Please, try again.'));
			}
		}
	}

    public function close(){}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Affiliation->exists($id)) {
			throw new NotFoundException(__('Invalid affiliation'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Affiliation->save($this->request->data)) {
				$this->Session->setFlash(__('The affiliation has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The affiliation could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Affiliation.' . $this->Affiliation->primaryKey => $id));
			$this->request->data = $this->Affiliation->find('first', $options);
		}
		$contributors = $this->Affiliation->Contributor->find('list');
		$this->set(compact('contributors'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Affiliation->id = $id;
		if (!$this->Affiliation->exists()) {
			throw new NotFoundException(__('Invalid affiliation'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Affiliation->delete()) {
			$this->Session->setFlash(__('The affiliation has been deleted.'));
		} else {
			$this->Session->setFlash(__('The affiliation could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
