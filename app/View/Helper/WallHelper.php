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
class WallHelper extends AppHelper {
    /**
     * showName method
     *
     * @package       app.View.Helper
     *
     * @param null|mixed $id
     */
    public function showName($id = null) {
        $this->UserObj = ClassRegistry::init('User');
        $userName = $this->UserObj->find('first',['conditions'=>['User.id'=>$id], 'fields'=>['User.name']]);
        if (!$this->UserObj->exists($id)) {
                  return __dbt('invalid User');

                }
       return __dbt($userName['User']['name']);
    }

    /**
     * showMedia method
     *
     * @package       app.View.Helper
     *
     * @param null|mixed $id
     * @param null|mixed $contentType
     * @param null|mixed $contentId
     */
    public function showMedia($id = null, $contentType = null,$contentId = null) {

        $this->UserObj = ClassRegistry::init('User');
        $this->WallContent = ClassRegistry::init('WallContent');
        $this->FileObj = ClassRegistry::init('File');
        //$file_id = $this->UserObj->find('first',array('conditions'=>array('User.id'=>$id),'fields'=>array('User.file_id')));
        $content = $this->WallContent->find('first',['conditions'=>['WallContent.id'=>$contentId]]);
        if($contentType == 'text') {
            return !empty($content['WallContent']['name']) ? $content['WallContent']['name'] : '';
        } else if($contentType == 'embed') {
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $content['WallContent']['name'], $match);
             $video_id = 'http://www.youtube.com/embed/' . $match[1];
            return  '<figure>'
                    . '<figcaption>'
                    . '<span class="card-title">' . __dbt($content['WallContent']['title']) . '</span><p>'
                    . '<iframe width="100%" height="300" src="' . $video_id . '" frameborder="0"></iframe>
                    </figure>';
        }
    }

    /**
     * showPostUpload method
     *
     * @package       app.View.Helper
     *
     * @param null|mixed $fileId
     * @param null|mixed $mimeType
     *
     * @return html
     */
    public function showPostUpload($fileId = null, $mimeType = null)
    {
        $this->File = ClassRegistry::init('File');
        $file = $this->File->find('first',['conditions'=>['File.id'=>$fileId]]);
        if(!empty($file['File']['path']))
        {
           if($mimeType == 'image') {
               //return '<img class="img-responsive" src="'.$file['File']['path'].'" alt="'.$file['File']['name'].'">';
               return '<img  src="' . $file['File']['path'] . '" alt="' . __dbt($file['File']['name']) . '">';
           }

        }

    }

    /**
     * userImage method
     *
     * @package       app.View.Helper
     *
     * @param null|mixed $id
     */
    public function userImage($id = null) {
        $this->UserObj = ClassRegistry::init('User');
        $this->FileObj = ClassRegistry::init('File');
        $file_id = $this->UserObj->find('first',['conditions'=>['User.id'=>$id], 'fields'=>['User.file_id']]);
        $file_id = isset($file_id['User']['file_id']) ? $file_id['User']['file_id'] : 0;
        if($file_id == 0)
        {
          return '<img src="/img/default_profile.png" alt="' . __dbt('default image') . '">';
        }
            $url = $this->FileObj->find('first',['conditions'=>['File.id'=>$file_id], 'fields'=>['File.path', 'File.name']]);
            //return '<img src="'.$url['File']['path'].'" alt="'.$url['File']['name'].'" class="img-responsive">';
            return '<img src="' . $url['File']['path'] . '" alt="' . __dbt($url['File']['name']) . '" >';
            //return $this->Html->image($url['File']['path'], array('alt' => $url['File']['name']));

    }

    /**
     * userImage method
     *
     * @package       app.View.Helper
     *
     * @param null|mixed $id
     */
    public function profileImage($id = null) {
        $this->UserObj = ClassRegistry::init('User');
        $this->FileObj = ClassRegistry::init('File');
        $file_id = $this->UserObj->find('first',['conditions'=>['User.id'=>$id], 'fields'=>['User.file_id']]);
        $file_id = $file_id['User']['file_id'];
        if($file_id == 0)
        {
          return '<img align="left" class="fb-image-profile thumbnail" src="/img/default_profile.png" alt="' . __dbt('default image') . '">';
          }
            $url = $this->FileObj->find('first',['conditions'=>['File.id'=>$file_id], 'fields'=>['File.path', 'File.name']]);
            return '<img align="left" class="fb-image-profile thumbnail img-responsive" src="' . $url['File']['path'] . '" alt="' . __dbt($url['File']['name']) . '">';
            //return $this->Html->image($url['File']['path'], array('alt' => $url['File']['name']));

    }

    /**
     * getTaggedUser method
     *
     * @package       app.View.Helper
     *
     * @param null|mixed $contentId
     * @param null|mixed $userId
     */
    public function getTaggedUser($contentId = null,$userId = null) {

        $this->NotificationObj = ClassRegistry::init('Notification');
        $users = $this->NotificationObj->find('all',['conditions'=>['Notification.by'=>$userId, 'Notification.content_id'=>$contentId], 'fields'=>['To.name']]);

        $userStr = '';
        if(!empty($users)) {
            $userStr = __dbt('Tagged User: ');
            foreach($users as $user) {
                $userStrArr[]= $user['To']['name'];
            }
            $userStrArr = implode(',', $userStrArr);
          return '<span class="chat-desc">' . rtrim($userStr) . " <span style='font-weight:bold;'>" . $userStrArr . '</span></span>';
        }
            return $userStr;

    }

}