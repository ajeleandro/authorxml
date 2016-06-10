<?php
App::uses('AppController', 'Controller');

class VideosController extends AppController {

	public $components = array('Paginator', 'Session','RequestHandler');
    public $helpers = array('Js');


    public function videosactions() {

        //--------------------------------------Move Selected Videos to:--------------------------------------//
        if($this->request->data['submit'] == 'Move Selected Videos to:'){

            //To the Move Function:
            $this->move($this->data['Video'], $this->data['dir']);
        }
        elseif($this->request->data['submit'] == 'Download Selected XMLs'){

        //--------------------------------------Download Selected XMLs--------------------------------------//

            Configure::load('authorxml','default');

            $files = glob(Configure::read('authorxml.zippedxmls').DS.'*'); // get all file names
            foreach($files as $file){ // iterate files
              if(is_file($file)){
                unlink($file); // delete file
              }
            }
        
            $keys = array_keys($this->data['Video']);
            $i = 0;
            $x = 0;
            foreach($this->data['Video'] as $selected){
                if($selected == 1){
                    $xmllist[$x] = $keys[$i];
                    $x++;
                }
                $i++;
            }
        
            if(isset($xmllist)){
                for($j = 0; $j < count($xmllist);$j++){
                    $this->xml($xmllist[$j],TRUE);
                }
            }else{
                $this->Session->setFlash(__('No video selected to download the xml, please go back'));
                return $this->redirect($this->Auth->redirectUrl());
            }

            // Get real path for our folder
            $rootPath = realpath(Configure::read('authorxml.zippedxmls'));

            // Initialize archive object
            $zip = new ZipArchive();
            $zip->open(Configure::read('authorxml.zippedxmls').DS.'AuthorXML.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

            // Create recursive directory iterator
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($rootPath),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file)
            {
                // Skip directories (they would be added automatically)
                if (!$file->isDir())
                {

                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($rootPath) + 1);

                    // Add current file to archive
                    $zip->addFile($filePath, $relativePath);
                }
            }

            // Zip archive will be created only after closing object
            $zip->close();

            $this->viewClass = 'Media';
            $params = array(
                'id'        => 'AuthorXML.zip',
                'name'      => 'AuthorXML',
                'download'  => true,
                'extension' => 'xml',
                'path'      => Configure::read('authorxml.downloadzippedxmls')
            );
            $this->set($params);
        }
        else{
                $this->Session->setFlash(__('Error in videosactions() VideosController'));
                return $this->redirect($this->Auth->redirectUrl());
        }
	}

    public function xml($id = null,$zip = null){

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

        $dom->getElementsByTagName("title")->item(0)->nodeValue = htmlspecialchars($video['Video']['title']);
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
            $aff = $dom->createElement('aff',htmlspecialchars($affNames[$z]));
            $key = array_keys($newaff[$z]);
            $aff->setAttribute('id', 'aff'.$key[0]);
            $contribs->appendChild($aff);
        }
        $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $video['Video']['Thumbnail']);

        if($zip == null){
            $dom->save(Configure::read('authorxml.saveLastXml'));           
            $this->viewClass = 'Media';
            $params = array(
                'id'        => 'last.xml',
                'name'      => $withoutExt,
                'download'  => true,
                'extension' => 'xml',
                'path'      => Configure::read('authorxml.downloadParamsFilePath')
            );
            $this->set($params);
        }elseif($zip == TRUE){
            $dom->save(Configure::read('authorxml.zippedxmls').DS.$withoutExt.'.xml');
        }
	}

    public function index($folder_id = null, $xmldownload = null) {
        $this->set('title_for_layout', 'List of Videos');
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
        if(isset($folder_id)){
            if($folder_id == NULL){
                //nothing
            }
            elseif ($folder_id != 0){
                $conditions['Video.dir_id'] = $folder_id;   
                $folder = $this->Video->Dir->find('list');             
            }else{
                $conditions['Video.dir_id'] = NULL;   
            }
        }
		$this->Video->recursive = 0;
		$this->paginate = array(
			'limit' => 100,
            'order' => array('id' => 'DESC'),
			'conditions' => $conditions
		);
		$this->set('videos', $this->paginate());

		// get the possible values for the filters and 
		// pass them to the view
		$categories = $this->Video->Category->find('list');
        $accesssites = $this->Video->Accesssite->find('list',array('order'=>array('name' => 'asc')));
		$this->set(compact('accesssites', 'categories'));

		// Pass the search parameter to highlight the text
		$this->set('search', isset($this->params['named']['search']) ? $this->params['named']['search'] : "");
        $this->Session->write('Auth.User.reference', '/videos/index/'.$folder_id);

        $movedir = $this->Video->Dir->find('list',array('order'=>array('id' => 'desc')));
        $this->set('movedir',$movedir);
        if($xmldownload != NULL)
            $this->set('xmldownload',$xmldownload);
        else
            $this->set('xmldownload','no');
	}

	public function view($id = null) {
		$this->Video->recursive = 3;
		if (!$this->Video->exists($id)) {
			throw new NotFoundException(__('Invalid video'));
		}
		$options = array('conditions' => array('Video.' . $this->Video->primaryKey => $id));
        $video = $this->Video->find('first', $options);
		$this->set('video', $video);

        //$this->loadModel('Category');
        $options = array('conditions' => array('Category.id' => $video['Category']['category_id']));
        $parentcategory = $this->Video->Category->find('first', $options);
        if(count($parentcategory) > 0)
            $this->set('parentcategory', $parentcategory['Category']);
        else
            $this->set('parentcategory', NULL);
        $this->set('title_for_layout', $video['Video']['title']);
	}

    public function getbycategory($type = null) {
        if(isset($this->request->data['Video'])){
                $id = $this->request->data['Video']['category_id'];
            if($id != NULL){    
                $subcategories = $this->Video->Category->find('list', array('conditions'=>array('Category.category_id =' => $id),'order' => array('ID' => 'desc')));
            }
            else{
                $subcategories = NULL;
            }
            $this->set('subcategories',$subcategories);
            if($type == 0){
                $this->render('subcategories','ajax');
            }else{
                $this->set('selected',$type); //this will let 'subcategoriesedit.ctp' to know which option should be selected
                $this->render('subcategoriesedit','ajax');                
            }
        }
    }

	public function add($function = null) {
        $this->set('title_for_layout', 'Add new Video');
        $this->set('SessionContributors', $this->Session->read('Contributors'));
	    if ($this->request->is('post')) {
		    $this->Video->create();
            $video = $this->request->data['Video'];
            $video['Contributor'] = $this->request->data['Contributor']['Contributor'];
            if(isset($this->request->data['category_id'])){
                $category = $this->request->data['category_id'];
                if(count($category) > 0)
                    if($category != NULL)
                        $video['category_id'] = $category;
            }     
            
            //triming xml data    
            $video['title'] = trim($video['title']);
            $video['duration'] = trim($video['duration']);
            $video['videoid'] = trim($video['videoid']);
            $video['width'] = trim($video['width']);
            $video['height'] = trim($video['height']);
            $video['player'] = trim($video['player']);
            $video['playerkey'] = trim($video['playerkey']);
            $video['Thumbnail'] = trim($video['Thumbnail']);

            $video['dir_id'] = $this->Session->read('Auth.User.currectprojectid');

            $folder_id = $this->Session->read('Auth.User.currectprojectid');
            if( $folder_id != NULL){
                 $video['dir_id'] =  $folder_id;
            }
           
		    if ($this->Video->save($video)) {
			    $this->Session->setFlash(__('The video has been saved.'));
                $this->Session->delete('Contributors');

                if($folder_id != NULL){
                    $this->loadModel('Dir');
                    $this->Dir->id = $this->Session->read('Auth.User.currectprojectid');
                    $this->Dir->saveField('accesssite_id', $video['accesssite_id']);
                }
                
                
                else{
                    if($this->Session->read('Auth.User.currectprojectid')){
                        if($this->request->data['submit'] == 'downloadxml')
                             return $this->redirect(array('action' => 'index/'.$this->Session->read('Auth.User.currectprojectid').'/'.$this->Video->getInsertId()));
			            return $this->redirect(array('action' => 'index/'.$this->Session->read('Auth.User.currectprojectid')));
                    }
                    else{
                        if($this->request->data['submit'] == 'downloadxml')
                            return $this->redirect(array('action' => 'index/0/'.$this->Video->getInsertId())); 
			            return $this->redirect(array('action' => 'index/0')); 
                    }   
                }   
		    }else {
			    $this->Session->setFlash(__('The video could not be saved. Please, try again.'));
		    }
	    }
        $parentcategories = $this->Video->Category->find('list', array('conditions'=>array('Category.category_id =' => NULL),'order' => array('ID' => 'desc')));
        $this->set('parentcategories',$parentcategories);
    
        $contributors = $this->Video->Contributor->find('all', array('order' => array('ID' => 'desc')));
        $i=0;

        $testing = $contributors;
        $this->set('testing',$testing);
        foreach($contributors as $contributor){
            $response[$i]['id'] = $contributor['Contributor']['id'];

            $allaffs = '';
            foreach($contributor['Affiliation'] as $affname){
                $allaffs = $affname['Name'].' '.$allaffs;
            }

            $response[$i]['label'] = $contributor['Contributor']['full_name'].' '.$allaffs;
            $response[$i]['value'] = $contributor['Contributor']['full_name'].' '.$allaffs;
            $i++;
        }
        $contributors = json_encode($response);
        $this->set('contributors',$contributors);

        $accesssites = $this->Video->Accesssite->find('list',array('order'=>array('name' => 'asc')));
        $this->set('accesssites',$accesssites); 
    
        if ($function != null) {
            if($function == 'reset'){
                $this->Session->delete('Contributors');
                return $this->redirect(array('action' => 'add'));
            }
        }
        $this->Video->Dir->recursive = 0;
        $projectsite = $this->Video->Dir->find('first',array('fields' => 'accesssite_id','conditions'=>array('Dir.id' => $this->Session->read('Auth.User.currectprojectid'))));        
        if(count($projectsite) < 1){
            $this->set('defaultsite',NULL); 
        }else{
            $this->set('defaultsite',$projectsite['Dir']['accesssite_id']);            
        }
	}

    public function addseassioncontrib($id = null, $name = null){
         $this->Session->write('Contributors.'.$id, utf8_encode($name));
    }

    public function edit($id = null) {
        if (!$this->Video->exists($id)) {
			throw new NotFoundException(__('Invalid video'));
		}
        $this->set('SessionContributors', $this->Session->read('Contributors'));
	    if ($this->request->is(array('post', 'put'))) {

            $video = $this->request->data['Video'];
            if($this->request->data['Contributor']['Contributor'] == NULL){
                $video['Contributor'] = array( 0 => '');
            }else{
                $video['Contributor'] = $this->request->data['Contributor']['Contributor'];             
            }
            
            if(isset($this->request->data['category_id'])){
                $category = $this->request->data['category_id'];
                if(count($category) > 0)
                    if($category != NULL)
                        $video['category_id'] = $category;
            }
            
            //triming xml data    
            $video['title'] = trim($video['title']);
            $video['duration'] = trim($video['duration']);
            $video['videoid'] = trim($video['videoid']);
            $video['width'] = trim($video['width']);
            $video['height'] = trim($video['height']);
            $video['player'] = trim($video['player']);
            $video['playerkey'] = trim($video['playerkey']);
            $video['Thumbnail'] = trim($video['Thumbnail']);


		    if ($this->Video->save($video)) {

			    $this->Session->setFlash(__('The video has been saved.'));
                $this->Session->delete('Contributors');
                
                if($this->Session->read('Auth.User.reference'))
                    return $this->redirect($this->Session->read('Auth.User.reference'));                
			    return $this->redirect(array('action' => 'index'));
		    } else {
			    $this->Session->setFlash(__('The video could not be saved. Please, try again.'));
		    }
	    }
        
		$this->Video->recursive = 2;
        $options = array('conditions' => array('Video.' . $this->Video->primaryKey => $id));
		$video =  $this->Video->find('first', $options);

        $parentcategories = $this->Video->Category->find('list', array('conditions'=>array('Category.category_id =' => NULL),'order' => array('ID' => 'desc')));
        $this->set('parentcategories',$parentcategories);
    
        $objcontributors = NULL;
        foreach($video['Contributor'] as $contributor){
            $contribSessionName = $contributor['full_name'];
            foreach($contributor['Affiliation'] as $affiliations){
                    $contribSessionName = $contribSessionName.", ".$affiliations['Name'];
            }
            $objcontributors[$contributor['id']] = $contribSessionName;
        }
        $this->set('objcontributors',$objcontributors);

        //All the contributors for the autocomplete:
        $contributors = $this->Video->Contributor->find('all', array('fields'=>array('id','full_name'),'order' => array('ID' => 'desc')));        
        $i=0;
        foreach($contributors as $contributor){
            $fullname = $contributor['Contributor']['full_name'];
            foreach($contributor['Affiliation'] as $affiliations){
                    $fullname = $fullname.", ".$affiliations['Name'];
            }
            $response[$i]['id'] = $contributor['Contributor']['id'];
            $response[$i]['label'] = $fullname;
            $response[$i]['value'] = $fullname;
            $i++;
        }
        $contributors = json_encode($response);
        $this->set('contributors',$contributors);

        $accesssites = $this->Video->Accesssite->find('list');
        $this->set('accesssites',$accesssites);
        
        $this->set('title_for_layout','Edit: '. $video['Video']['title']);
        $this->request->data = $video;
	}

	public function delete($id = null) {
		$this->Video->id = $id;
		if (!$this->Video->exists()) {
			throw new NotFoundException(__('Invalid video'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Video->delete()) {
			$this->Session->setFlash(__('The video has been deleted.'));
            if($this->Session->read('Auth.User.reference'))
                return $this->redirect($this->Session->read('Auth.User.reference'));                
			return $this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(__('The video could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

    public function move($videoarray = null, $folder_id = null){

        $keys = array_keys($this->data['Video']);
        $i = 0;
        $x = 0;
        foreach($this->data['Video'] as $selected){
            if($selected == 1){
                $videoids[$x] = $keys[$i];
                $x++;
            }
            $i++;
        }
        
        if(isset($videoids)){
            
            $this->Video->updateAll(
                array('Video.dir_id' => $folder_id),
                array('Video.id' => $videoids)
            );

            $this->Session->setFlash(__('Videos Moved Successfully'));
            return $this->redirect(array('action' => 'index/'.$folder_id));
        }else{
            $this->Session->setFlash(__('No video selected to move to another folder, please go back'));
            return $this->redirect(array('action' => 'index/'.$folder_id));
        }
    }

    public function deletecontrib($contribid = NULL, $videoids = NULL){
         $options = array('conditions' => array('Video.' . $this->Video->primaryKey => $videoids));
         $video = $this->Video->find('first', $options);
         for($i = 0; $i < count($video['Contributor']);$i++ ){
             if($video['Contributor'][$i]['id'] == $contribid){
                 $video['Contributor'][$i] = NULL;
                 $this->Video->save($video);
                 break;
             }
         }
    }
}