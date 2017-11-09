<?php
class SectionList extends AppModel{
    public $name = 'SectionList';
    public $hasMany = [
        'Section' => [
            'className' => 'Section',
            'foreignKey' => 'section_list_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ]
        ];
}