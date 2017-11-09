<?php
App::uses('AppModel', 'Model');
/**
 * News Model
 *
 */
class HinNews extends AppModel {
    /**
     * Display field
     *
     * @var string
     */
    public $belongsTo = [
        'News' => [
            'className' => 'News',
            'foreignKey' => 'news_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]
        ];

    public function beforeSave($options = [])
    {
        if(!parent::beforeSave($options))
        {
            return false;
        }

        if(!empty($this->data[$this->alias]['description']))
        {
            $this->data[$this->alias]['description'] = strip_tags($this->data[$this->alias]['description']);
        }

        return true;
    }

}