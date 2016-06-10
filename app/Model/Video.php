<?php
App::uses('AppModel', 'Model');


class Video extends AppModel {

    public $useTable = 'video';
	public $displayField = 'title';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

    	public $validate = array(
		'title' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
                'message' => 'This is a require field'
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'duration' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
                'message' => 'This is a require field'
			),
		),
		'width' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
                'message' => 'This is a require field'
			),
		),
		'height' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
                'message' => 'This is a require field'
			),
		),
		'videoid' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
                'message' => 'This is a require field'
			),
		),
        'player' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
                'message' => 'This is a require field'
			),
		),
		'playerkey' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
                'message' => 'This is a require field'
			),
		),
		'Thumbnail' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
                'message' => 'This is a require field'
			),
		)
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Accesssite' => array(
			'className' => 'Accesssite',
			'foreignKey' => 'accesssite_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Dir' => array(
			'className' => 'Dir',
			'foreignKey' => 'dir_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Contributor' => array(
			'className' => 'Contributor',
			'joinTable' => 'video_contributor',
			'foreignKey' => 'video_id',
			'associationForeignKey' => 'contributor_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => 'VideoContributor.id',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

}
