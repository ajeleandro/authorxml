<?php
App::uses('AppModel', 'Model');
/**
 * Video Model
 *
 * @property Category $Category
 * @property Accesssite $Accesssite
 * @property Contributor $Contributor
 */
class Video extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'video';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

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
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

}
