<?php

App::uses('AppController', 'Controller');

class DirsController extends AppController {

    public $components = array('Paginator', 'Session');

    public function view($id = null, $name = null) {
		$this->Dir->recursive = 2;
        
        $this->loadModel('Video');
        if($name == null){
            $options = array('conditions' => array('Video.dir_id' => $id));
            $videos = $this->Video->find('list', $options);
            $numvideos = sizeof($videos);
        }else{
            $options = array('conditions' => array('Video.dir_id' => $id));
            $videos = $this->Video->find('list', $options);
            $numvideos = sizeof($videos);
        }
		$this->set('numvideos', $numvideos);
        if($id == null){
            $this->paginate = array(
                'Dir' => array(
                    'conditions' => array('Dir.dir_id' => NULL),
                    'limit' => 50
            ));
        }
        else{
            $this->paginate = array(
            'Dir' => array(
                'conditions' => array('Dir.dir_id' => $id),
                'limit' => 50
            ));
        }
        
        $Dir = $this->paginate('Dir');
        
		$this->set('Dirs', $Dir);
		$this->set('listorgrid', "createDir");
		$this->set('Dir_name', $name);
        $this->Session->write('Auth.User.reference', '/Dirs/view/'.$id.'/'.$name);
        $accesssites = $this->Video->Accesssite->find('list',array('order'=>array('name' => 'asc')));
        $this->set('accesssites',$accesssites);    
	}

    public function listview($id = null, $name = null) {
		$this->Dir->recursive = 2;
        
        $this->loadModel('Video');
        $this->Video->recursive = 3;
        $options = array('conditions' => array('Video.dir_id' => $id),'order' => array('Video.id' => 'DESC'));
        $videos = $this->Video->find('all', $options);
        $numvideos = sizeof($videos);
		$this->set('numvideos', $numvideos);
		$this->set('videos', $videos);

        if($id == null){
            $this->paginate = array(
                'Dir' => array(
                    'conditions' => array('Dir.dir_id' => NULL),
                    'limit' => 50
            ));
        }
        else{
            $this->paginate = array(
            'Dir' => array(
                'conditions' => array('Dir.dir_id' => $id),
                'limit' => 50
            ));
        }
        
        $Dir = $this->paginate('Dir');
		$this->set('Dirs', $Dir);
		$this->set('listorgrid', "createDirList");
		$this->set('Dir_name', $name);
        $this->Session->write('Auth.User.reference', '/Dirs/listview/'.$id.'/'.$name);  
        $movedir = $this->Video->Dir->find('list',array('order'=>array('id' => 'desc')));
        $this->set('movedir',$movedir);
	}

    public function index() {
		$this->set('dirs', $this->paginate('Dir'));
        $this->Session->write('Auth.User.reference', '/Dirs/index');
	}

    public function createDir($parentid = null, $newDirname = null, $name = null){
        $this->Dir->create();
        if($parentid == 0){
            $Dir = array('name' => $newDirname);
        }else{
            $Dir = array('name' => $newDirname, 'dir_id'=> $parentid);            
        }
        $this->Dir->save($Dir);
        if ($this->Dir->save($Dir)) {
            $this->Session->setFlash(__('Folder Created'));
        }else{
            $this->Session->setFlash(__('Error creating Dir'));
        }
        if($parentid == 0){
            return $this->redirect(array('action' => 'view')); 
        }else{
            return $this->redirect(array('action' => 'view/'.$parentid.'/'.$name));            
        }
    }

    public function createDirList($parentid = null, $newDirname = null, $name = null){
        $this->Dir->create();
        if($parentid == 0){
            $Dir = array('name' => $newDirname);
        }else{
            $Dir = array('name' => $newDirname, 'dir_id'=> $parentid);            
        }
        $this->Dir->save($Dir);
        if ($this->Dir->save($Dir)) {
            $this->Session->setFlash(__('Folder Created'));
        }else{
            $this->Session->setFlash(__('Error creating Dir'));
        }
        if($parentid == 0){
            return $this->redirect(array('action' => 'listview')); 
        }else{
            return $this->redirect(array('action' => 'listview/'.$parentid.'/'.$name));            
        }
    }

    public function setproject($listorgrid = null, $id = null,$name = null) {
        if($id == 0){
            $this->Session->write('Auth.User.currectproject', 'No Dir Selected');
            $this->Session->write('Auth.User.currectprojectid', NULL);

            $this->loadModel('User');
            $this->User->id = $this->Session->read('Auth.User.id');
            if ($this->User->saveField('currectproject', NULL)) {
                $this->Session->setFlash(__('Records will be saved outside all the Dir'));
            }else{
                $this->Session->setFlash(__('Error changing the Currect Project'));
            }

            return $this->redirect(array('action' => "".$listorgrid));
        }else{
            $options = array('conditions' => array('Dir.id' => $id));
            $currectproject = $this->Dir->find('list', $options);
            $this->Session->write('Auth.User.currectproject', $currectproject[$id]);
            $this->Session->write('Auth.User.currectprojectid', $id);
            
            $this->loadModel('User');
            $this->User->id = $this->Session->read('Auth.User.id');
            if ($this->User->saveField('currectproject', $id)) {
                $this->Session->setFlash(__('Records will be saved in the '.$currectproject[$id].' Folder'));
            }else{
                $this->Session->setFlash(__('Error changing the Currect Project'));
            }
            return $this->redirect(array('action' => $listorgrid.'/'.$id.'/'.$name));
        }
	}

    public function deleteproject($listorgrid = null, $id = null) {
        
        $this->Dir->recursive = 1;
        $options = array('conditions' => array('Dir.id' => $id));
        $foldertodelete = $this->Dir->find('first', $options);
        $parentid = $foldertodelete['Dir']['dir_id'];
        $parentname = $foldertodelete['ParentDir']['name'];
        $foldertodeletename = $foldertodelete['Dir']['name'];

        if(sizeof($foldertodelete['ChildDir'])>0){
            $this->Session->setFlash(__('You cannot delete a Parent Folder'));
            return $this->redirect(array('action' => $listorgrid.'/'.$id.'/'.$foldertodeletename));
        }

        if($id == $this->Session->read('Auth.User.currectprojectid')){
            $this->Session->write('Auth.User.currectprojectid', $parentid);
            $this->Session->write('Auth.User.currectproject', $parentname);
        }

        $this->loadModel('Video');
        $options = array('conditions' => array('Video.dir_id' => $id));
        $videostomove = $this->Video->find('list', $options);

        $keys = array_keys($videostomove);
        $i = 0;
        foreach($videostomove as $selected){
                $videoids[$i] = $keys[$i];
                $i++;
        }
            
        if(isset($videoids)){
            $this->Video->updateAll(
                array('Video.dir_id' => $parentid),
                array('Video.id' => $videoids)
            );
        }

        $this->loadModel('Dir');
        if ($this->Dir->delete($id)) {
            $this->Session->setFlash(__('Folder Deleted, Videos inside of it were moved to its parent folder'));
        }else{
            $this->Session->setFlash(__('Error Deleting Folder'));
        }
        return $this->redirect(array('action' => $listorgrid.'/'.$parentid.'/'.$parentname));
        
	}

    public function setview($listorgrid = null, $id = null, $name = null) {

        if($listorgrid == 'listview')
            $view = 1;
        else
            $view = 0;

        $this->Session->write('Auth.User.folderview', $view);
        $this->loadModel('User');
        $this->User->id = $this->Session->read('Auth.User.id');
        if ($this->User->saveField('folderview', $view)) {
                return $this->redirect(array('action' => $listorgrid.'/'.$id.'/'.$name));
        }else{
                $this->Session->setFlash(__('Error changing view'));
        }
	}
}

?>