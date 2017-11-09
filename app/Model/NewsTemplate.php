<?php
App::uses('AppModel', 'Model');
/**
 * News Model
 *
 */
class NewsTemplate extends AppModel {
    /**
     * Display field
     *
     * @var string
     */
   public $useTable = 'news_templates';
   // public $displayField = 'name';
 
        /**
         * Virtual field
         *
         * @var string
         */
        public $virtualFields = [
                'status_name' => 'CASE WHEN NewsTemplate.status = "0" THEN "Inactive" WHEN NewsTemplate.status = "1" THEN "Active" END',
        ];

    /**
     * Validation rules
     *
     * @var array
     */
    

}
