<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * User Model
 *
 * @property Role $Role
 * @property Locale $Locale
 * @property File $File
 * @property League $League
 * @property PollResponse $PollResponse
 * @property Sport $Sport
 * @property Team $Team
 * @property WallContent $WallContent
 */
class EmailTemplate extends AppModel {
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
}