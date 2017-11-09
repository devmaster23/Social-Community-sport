<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 *
 * @package       app.View.Helper
 *
 * @since         CakePHP(tm) v 0.2.9
 *
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('CakeTime', 'Utility');
class SportHelper extends AppHelper {
    /**
     * showName method
     *
     * @package       app.View.Helper
     *
     * @param null|mixed $id
     */
    public function showTileImage($id = null) {
        $this->File = ClassRegistry::init('File');
        $sportTileImg = $this->File->find('first',['conditions'=>['File.id'=>$id], 'fields'=>['File.new_name']]);
        if(!empty($sportTileImg)) {
        return '<img src="' . BASE_URL . 'img/BannerImages/large/' . $sportTileImg['File']['new_name'] . '" >';
        }
           // return __dbt('Image not uploaded.');
           return '<img src="' . BASE_URL . 'img/defaultSport.jpg" >';

    }

    /**
     * sportBammerImage method
     *
     * @package       app.View.Helper
     *
     * @param null|mixed $id
     */
    public function sportBannerImage($id = null) {
        $this->File = ClassRegistry::init('File');
        $sportBannerImg = $this->File->find('first',['conditions'=>['File.id'=>$id], 'fields'=>['File.new_name']]);
        $name = isset($sportBannerImg['File']['new_name']) ? $sportBannerImg['File']['new_name'] : '' ;

        if($name == '')
        {
          return '<img align="left" class="fb-image-profile thumbnail" src="/img/default_profile.png" alt="default image">';
          }
            return '<img align="left" class="fb-image-lg" src="' . BASE_URL . 'img/BannerImages/' . $name . '" >';

    }

}