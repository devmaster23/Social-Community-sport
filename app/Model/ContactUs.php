<?php
App::uses('AppModel', 'Model');
/**
 * Sport Model
 *
 * @property User $User
 * @property League $League
 * @property Team $Team
 * @property Tournament $Tournament
 */
class ContactUs extends AppModel {
    /**
     * Display field
     *
     * @var string
     */
    public $useTable = 'contact_us';
        public $displayField = 'name';

        /**
         * Virtual field
         *
         * @var string
         */
        public $virtualFields = [
                'status_name' => 'CASE WHEN ContactUs.status = "0" THEN "Unread" WHEN ContactUs.status = "1" THEN "Read" WHEN ContactUs.status = "2" THEN "Replied" END'
        ];

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = [
        'email' => [
                    'required' => [
                        'rule' => ['notBlank'],
                        'message' => 'Please enter email address.',
                        'last' =>true
                    ],
                    'validemail'=>[
                                    'rule'=>'email',
                                    'message'=>'Please enter a valid email address.'
                    ],
                    'customrule'=> [
                            'rule' => ['custom', '/^[a-z0-9-@_\.]+$/i'],
                            'message' => 'only a-z 0-9 @ . _ - are allowed.'
                    ]
                ],
                'message' => [
                    'required' => [
                        'rule' => ['notBlank'],
                        'message' => 'Please enter message.',
                    ]
                ]

    ];
}