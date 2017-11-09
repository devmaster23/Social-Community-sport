<?php
class Section extends AppModel{
    public $name = 'Section';
    public $belongsTo = [
        'SectionList' => [
            'className' => 'SectionList',
            'foreignKey' => 'section_list_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]
        ];
}