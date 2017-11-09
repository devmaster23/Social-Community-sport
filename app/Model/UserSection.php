<?php
class UserSection extends AppModel
{
    public $name = 'UserSection';

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