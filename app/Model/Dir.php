<?php    
App::uses('AppModel', 'Model');


class Dir extends AppModel {

    public $useTable = 'dir';

	public $belongsTo = array(
		'ParentDir' => array(
			'className' => 'Dir',
			'foreignKey' => 'dir_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

    public $hasMany = array(
		'ChildDir' => array(
			'className' => 'Dir',
			'foreignKey' => 'dir_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Video' => array(
			'className' => 'Video',
			'foreignKey' => 'dir_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
}