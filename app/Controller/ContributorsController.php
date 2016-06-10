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

    public function quickadd($function = null) {

        $this->set('title_for_layout', 'Add New Contributor');
        $this->set('SessionAffiliations', $this->Session->read('Affiliations'));

		if ($this->request->is('post')) {
			$this->Contributor->create();
			foreach ($this->request->data['Contributor'] as $key => $value) {
			    $this->request->data['Contributor'][$key] = trim($value);
			}
            
			if ($this->Contributor->save($this->request->data)) {
				$this->Session->setFlash(__('The contributor has been saved.'));                

                //session variables to add next in videoAdd

                $seassionContribs = count($this->Session->read('Contributors'));        
                $seassionContribs = $seassionContribs + 1;

                //creating the Contributor seasson full name
                $last = $this->Contributor->read(null,$this->Contributor->getInsertId());
                $contribSessionName = $last['Contributor']['full_name'];
                foreach($last['Affiliation'] as $affiliations){
                    $contribSessionName = $contribSessionName.", ".$affiliations['Name'];
                }

                $this->Session->write('Contributors.'.$last['Contributor']['id'], $contribSessionName);

				return $this->redirect(array('controller' => 'affiliations', 'action' => 'close'));
			} else {
				$this->Session->setFlash(__('The contributor could not be saved. Please, try again.'));
			}
		}

        $affiliations = $this->Contributor->Affiliation->find('all', array('order' => array('ID' => 'desc')));
        $i=0;
        foreach($affiliations as $affiliation){
            $response[$i]['id'] = $affiliation['Affiliation']['id'];
            $response[$i]['label'] = $affiliation['Affiliation']['Name'];
            $response[$i]['value'] = $affiliation['Affiliation']['Name'];
            $i++;
        }
        $affiliations = json_encode($response);
        $this->set('affiliations',$affiliations);

        if ($function != null) {
            if($function == 'reset'){
                $this->Session->delete('Affiliations');
                return $this->redirect(array('action' => 'quickadd'));
            }
        }
	}

    public function quickedit($id = null) {

        if (!$this->Contributor->exists($id)) {
			throw new NotFoundException(__('Invalid video'));
		}

        $this->set('SessionAffiliations', $this->Session->read('Affiliations'));
        
		if ($this->request->is(array('post', 'put'))) {

			foreach ($this->request->data['Contributor'] as $key => $value) {
			    $this->request->data['Contributor'][$key] = trim($value);
			}
            $this->request->data['Contributor']['id'] = $id;
			if ($this->Contributor->save($this->request->data)) {
				$this->Session->setFlash(__('The contributor has been saved.'));                

                //session variables to add next in videoAdd
                $seassionContribs = count($this->Session->read('Contributors'));        
                $seassionContribs = $seassionContribs + 1;

                $options = array('conditions' => array('Contributor.' . $this->Contributor->primaryKey => $id));
                $Contributor = $this->Contributor->find('first', $options);

                //creating the Contributor session full name
                $contribSessionName = $Contributor['Contributor']['full_name'];
                foreach($Contributor['Affiliation'] as $affiliations){
                    $contribSessionName = $contribSessionName.", ".$affiliations['Name'];
                }

                $this->Session->write('Contributors.'.$Contributor['Contributor']['id'], $contribSessionName);

				return $this->redirect(array('controller' => 'affiliations', 'action' => 'close'));
			} else {
				$this->Session->setFlash(__('The contributor could not be saved. Please, try again.'));
			}
		}
        
        $options = array('conditions' => array('Contributor.' . $this->Contributor->primaryKey => $id));
        $Contributor =  $this->Contributor->find('first', $options);

        $affiliations = $this->Contributor->Affiliation->find('all', array('order' => array('ID' => 'desc')));
        $i=0;
        foreach($affiliations as $affiliation){
            $response[$i]['id'] = $affiliation['Affiliation']['id'];
            $response[$i]['label'] = $affiliation['Affiliation']['Name'];
            $response[$i]['value'] = $affiliation['Affiliation']['Name'];
            $i++;
        }
        $affiliations = json_encode($response);
        $this->set('affiliations',$affiliations);


        
        $objaffiliations = NULL;
        foreach($Contributor['Affiliation'] as $aff){
            $objaffiliations[$aff['id']] = $aff['Name'];
        }
        $this->set('objaffiliations',$objaffiliations);

        $this->set('title_for_layout', 'Edit '.$Contributor['Contributor']['full_name']);
        $this->request->data = $Contributor;
	}

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

    public function autoComplete($name = null){
        Configure::write('debug', 0);
        $this->autoRender=false;
        $this->layout = 'ajax';
        $query = $_GET['term'];

        $splited = explode(' ', $query);
        if (count($splited) > 1){
            $authors = $this->Contributor->find('all', array(
                'conditions' => array(
                'OR' => array(
                    'Contributor.Name LIKE' => '%' . $splited[0] . '%',
                    'Contributor.Name LIKE' => '%' . $splited[1] . '%',
                    'Contributor.Surname LIKE' => '%' . $splited[0] . '%',
                    'Contributor.Surname LIKE' => '%' . $splited[1] . '%'
                )),
                'fields'=>array('full_name','id')
            ));
        }else{
            $authors = $this->Contributor->find('all', array(
                'conditions' => array(
                'OR' => array(
                    'Contributor.Name LIKE' => '%' . $query . '%',
                    'Contributor.Surname LIKE' => '%' . $query . '%'
                )),
                'fields'=>array('full_name','id')
            ));
        }

        $i=0;
        foreach($authors as $author){
            $response[$i]['id'] = $author['Contributor']['id'];
            $response[$i]['label'] = $author['Contributor']['full_name'];
            $response[$i]['value'] = $author['Contributor']['full_name'];
            $i++;
        }
        echo json_encode($response);
    }
}