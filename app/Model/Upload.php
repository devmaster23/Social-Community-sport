<?php
App::uses('AppModel', 'Model');
/**
 * File Model
 */
class Upload extends AppModel
{
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
    public $useTable = 'files';
}
