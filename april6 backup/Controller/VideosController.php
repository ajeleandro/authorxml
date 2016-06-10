<?php
App::uses('AppController', 'Controller');
/**
 * Videos Controller Zipline XML
 *
 * @property Video $Video
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class VideosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session','RequestHandler');
    public $helpers = array('Js');

    public function xml($id = null){

        Configure::load('authorxml','default');

        $this->Video->recursive = 3;
        if (!$this->Video->exists($id)){
			throw new NotFoundException(__('Invalid video'));
		}
		$options = array('conditions' => array('Video.' . $this->Video->primaryKey => $id));
        $video = $this->Video->find('first', $options);
        $dom = new DomDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->load(Configure::read('authorxml.mainXMLload'));

        $dom->getElementsByTagName("title")->item(0)->nodeValue = $video['Video']['title'];
        $dom->getElementsByTagName("book-part-id")->item(0)->nodeValue = $video['Video']['videoid'];
        $dom->getElementsByTagName("meta-value")->item(0)->nodeValue = $video['Video']['duration'];
        $dom->getElementsByTagName("meta-value")->item(1)->nodeValue = $video['Video']['height'];
        $dom->getElementsByTagName("meta-value")->item(2)->nodeValue = $video['Video']['width'];
        $dom->getElementsByTagName("meta-value")->item(3)->nodeValue = $video['Video']['player'];
        $dom->getElementsByTagName("meta-value")->item(4)->nodeValue = $video['Video']['playerkey'];
        $dom->getElementsByTagName("meta-value")->item(5)->nodeValue = $video['Video']['videoid'];
        $dom->getElementsByTagName("graphic")->item(0)->setAttribute('xlink:href', $video['Video']['Thumbnail']);

        //We Add the Categories
        $categorias = $dom->getElementsByTagName("subj-group")->item(0);
        if(count($video['Category']['name']) > 0 ){ //check if it has categories
            if(count($video['Category']['ParentCategory']) > 0){ //check if it has a parent then we add the parent and the child element
                $categorias->getElementsByTagName("subject")->item(0)->nodeValue = $video['Category']['ParentCategory']['name'];  
                $subcategory = $dom->createElement('subj-group');  
                $subcategory->setAttribute('subj-group-type', 'category');
                $subcategorysubject = $dom->createElement('subject',$video['Category']['name']);  
                $subcategory->appendChild($subcategorysubject); 
                $categorias->appendChild($subcategory);
                   
            }
            else{//if it doesn't have a parent
                $categorias->getElementsByTagName("subject")->item(0)->nodeValue = $video['Category']['name'];
            }
        }

        //we find the contrib tag and start adding them
        $contribs = $dom->getElementsByTagName("contrib-group")->item(0);
        $affid = 1;
        $newaff = array();
        $affNames = array();
        foreach($video['Contributor'] as $contributors){
            $contrib = $dom->createElement('contrib');
            $contrib->setAttribute('contrib-type', 'author');
            $contribs->appendChild($contrib);
            $contrib->appendChild($dom->createElement('name'));
            $inside = $contrib->getElementsByTagName("name")->item(0);
            $inside->appendChild($dom->createElement('surname',$contributors['Surname']));
            $inside->appendChild($dom->createElement('given-names',$contributors['Name']));
            $contrib->appendChild($dom->createElement('degrees', $contributors['Degrees']));
            //we add the contributor affiliations
            for ($x = 0; $x < count($contributors['Affiliation']); $x++){
                $xref =  $dom->createElement('xref');
                $xref->setAttribute('ref-type', 'aff');
                $exist = false;
                for($k=0; $k < count($newaff);$k++)                
                    if(array_search($contributors['Affiliation'][$x]['id'],$newaff[$k]) != false){
                        $exist = true;
                        $xref->setAttribute('rid', 'aff'.array_search($contributors['Affiliation'][$x]['id'],$newaff[$k]));                       
                    }
                if(!$exist){
                    $xref->setAttribute('rid', 'aff'.$affid);
                    array_push($newaff, array($affid => $contributors['Affiliation'][$x]['id']));
                    array_push($affNames, $contributors['Affiliation'][$x]['Name']);
                    $affid += 1;
                }
                $contrib->appendChild($xref);
            }
        }
        $affid = 1;

        //we add the affiliations after the contributors
        for ($z = 0; $z < count($newaff); $z++){
            $aff = $dom->createElement('aff',$affNames[$z]);
            $key = array_keys($newaff[$z]);
            $aff->setAttribute('id', 'aff'.$key[0]);
            $contribs->appendChild($aff);
        }

        $dom->save(Configure::read('authorxml.saveLastXml'));
        $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $video['Video']['Thumbnail']);
        $this->viewClass = 'Media';
        $params = array(
            'id'        => 'last.xml',
            'name'      => $withoutExt,
            'download'  => true,
            'extension' => 'xml',
            'path'      => Configure::read('authorxml.downloadParamsFilePath')
        );
        $this->set($params);
	}

/**
 * index method
 *
 * @return void
 */
	public function index2() {
		$this->Video->recursive = 0;
        $this->Paginator->settings = array(
            'order' => array('id' => 'DESC')
        );
		$this->set('videos', $this->Paginator->paginate());
	}



    public function index() {
		$conditions = array();
		//Transform POST into GET
		if(($this->request->is('post') || $this->request->is('put')) && isset($this->data['Filter'])){
			$filter_url['controller'] = $this->request->params['controller'];
			$filter_url['action'] = $this->request->params['action'];
			// We need to overwrite the page every time we change the parameters
			$filter_url['page'] = 1;

			// for each filter we will add a GET parameter for the generated url
			foreach($this->data['Filter'] as $name => $value){
				if($value){
					// You might want to sanitize the $value here
					// or even do a urlencode to be sure
					$filter_url[$name] = urlencode($value);
				}
			}	
			// now that we have generated an url with GET parameters, 
			// we'll redirect to that page
			return $this->redirect($filter_url);
		} else {
			// Inspect all the named parameters to apply the filters
			foreach($this->params['named'] as $param_name => $value){
				// Don't apply the default named parameters used for pagination
				if(!in_array($param_name, array('page','sort','direction','limit'))){
					// You may use a switch here to make special filters
					// like "between dates", "greater than", etc
					if($param_name == "search"){
						$conditions['OR'] = array(
							array('Video.title LIKE' => '%' . $value . '%'),
    						array('Video.tags LIKE' => '%' . $value . '%'),
                            array('Video.videoid' => $value)
						);
					} else {
						$conditions['Video.'.$param_name] = $value;
					}					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}
		$this->Video->recursive = 0;
		$this->paginate = array(
			'limit' => 20,
            'order' => array('id' => 'DESC'),
			'conditions' => $conditions
		);
		$this->set('videos', $this->paginate());

		// get the possible values for the filters and 
		// pass them to the view
		$categories = $this->Video->Category->find('list');
		$accesssites = $this->Video->Accesssite->find('list');
		$this->set(compact('accesssites', 'categories'));

		// Pass the search parameter to highlight the text
		$this->set('search', isset($this->params['named']['search']) ? $this->params['named']['search'] : "");
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Video->recursive = 3;
		if (!$this->Video->exists($id)) {
			throw new NotFoundException(__('Invalid video'));
		}
		$options = array('conditions' => array('Video.' . $this->Video->primaryKey => $id));
		$this->set('video', $this->Video->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */

    public function getbycategory() {
        if(isset($this->request->data['Video'])){
                $id = $this->request->data['Video']['category_id'];
            if($id != NULL){    
                $subcategories = $this->Video->Category->find('list', array('conditions'=>array('Category.category_id =' => $id),'order' => array('ID' => 'desc')));
            }
            else{
                $subcategories = NULL;
            }
            $this->set('subcategories',$subcategories);

            $this->render('subcategories','ajax');
        }
    }

	public function add() {
	if ($this->request->is('post')) {
		$this->Video->create();
            $editors = $this->request->data['Video']['editors'];
            $authors = $this->request->data['Video']['authors'];
            if((is_array($editors)) and (is_array($authors))){
                $contribs = array_merge($authors, $editors); 
            }
            elseif(is_array($editors)){
                $contribs = $editors;
            }elseif(is_array($authors)){
                $contribs = $authors;
            }else{
            	$contribs = array();
            }        
            $video = $this->request->data['Video'];
            $video['Contributor'] = $contribs;
            
            if(isset($this->request->data['category_id'])){
                $category = $this->request->data['category_id'];
                if(count($category) > 0)
                    if($category != NULL)
                        $video['category_id'] = $category;   
            }         
            
			if ($this->Video->save($video)) {
				$this->Session->setFlash(__('The video has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The video could not be saved. Please, try again.'));
			}
	}
        $parentcategories = $this->Video->Category->find('list', array('conditions'=>array('Category.category_id =' => NULL),'order' => array('ID' => 'desc')));
        $this->set('parentcategories',$parentcategories);
        $authors = $this->Video->Contributor->find('list', array('fields'=>array('id','full_name'),'conditions'=>array('Contributor.type =' => 0),'order' => array('ID' => 'desc')));
        $this->set('authors',$authors);
        $editors = $this->Video->Contributor->find('list', array('fields'=>array('id','full_name'),'conditions'=>array('Contributor.type =' => 1),'order' => array('ID' => 'desc')));
        $this->set('editors',$editors);
        $accesssites = $this->Video->Accesssite->find('list');
        $this->set('accesssites',$accesssites);
        
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Video->exists($id)) {
			throw new NotFoundException(__('Invalid video'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Video->save($this->request->data)) {
				$this->Session->setFlash(__('The video has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The video could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Video.' . $this->Video->primaryKey => $id));
			$this->request->data = $this->Video->find('first', $options);
		}
		$categories = $this->Video->Category->find('list');
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
		$this->Video->id = $id;
		if (!$this->Video->exists()) {
			throw new NotFoundException(__('Invalid video'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Video->delete()) {
			$this->Session->setFlash(__('The video has been deleted.'));
		} else {
			$this->Session->setFlash(__('The video could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Video->recursive = 0;
		$this->set('videos', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Video->exists($id)) {
			throw new NotFoundException(__('Invalid video'));
		}
		$options = array('conditions' => array('Video.' . $this->Video->primaryKey => $id));
		$this->set('video', $this->Video->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Video->create();
			if ($this->Video->save($this->request->data)) {
				$this->Session->setFlash(__('The video has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The video could not be saved. Please, try again.'));
			}
		}
		$categories = $this->Video->Category->find('list');
		$this->set(compact('categories'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Video->exists($id)) {
			throw new NotFoundException(__('Invalid video'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Video->save($this->request->data)) {
				$this->Session->setFlash(__('The video has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The video could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Video.' . $this->Video->primaryKey => $id));
			$this->request->data = $this->Video->find('first', $options);
		}
		$categories = $this->Video->Category->find('list');
		$this->set(compact('categories'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Video->id = $id;
		if (!$this->Video->exists()) {
			throw new NotFoundException(__('Invalid video'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Video->delete()) {
			$this->Session->setFlash(__('The video has been deleted.'));
		} else {
			$this->Session->setFlash(__('The video could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}