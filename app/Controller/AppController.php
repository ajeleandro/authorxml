<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

    public $components = array(
		'Session',
        'Auth' => array(
            'loginRedirect' => array(
                'controller' => 'pages',
                'action' => 'display',
                'home'
            ),
            'logoutRedirect' => array(
                'controller' => 'pages',
                'action' => 'display',
                'home'
            ),
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => 'Blowfish'
                )
            ),
            'authorize' => array('Controller') // Added this line
        )
    );

    public function beforeFilter() {
         if ((strpos($this->here, '/videos/add') !== false)or(strpos($this->here, '/videos/addseassioncontrib') !== false)or(strpos($this->here, '/videos/edit') !== false)or(strpos($this->here, '/Contributors/quickadd') !== false)or(strpos($this->here, '/contributors/quickedit') !== false)or(strpos($this->here, '/videos/getbycategory/') !== false)) {
             //echo 'do nothing';
         }else{
             //echo $this->here;
             $this->Session->delete('Contributors');
         } 
    }

    public function isAuthorized($user) {
        if (isset($user['role']) && ($user['role'] === 'admin')) {
            return true;
        }

        // Default deny
        return false;
    }

}
