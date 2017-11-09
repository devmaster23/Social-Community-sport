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
class NotificationHelper extends AppHelper {
    /**
     * showRejoinNotification admin method
     *
     * @package       app.View.Helper
     *
     * @param null|mixed $id
     */
    public function showRejoinNotification($id = null) {
        $this->UserTeam = ClassRegistry::init('UserTeam');
        $userTeams = 0;
        $getdate = new DateTime('15 days ago');
        $dateBefore = $getdate->format('Y-m-d h:i:s');
            if($id) { //code for individual team admin
                $userTeams = $this->UserTeam->find('count',['conditions'=>  ['UserTeam.status'=> 2, 'UserTeam.team_id'=> $id, 'UserTeam.request_date > '=> $dateBefore]]);
            } else {  //code for super admin
                $userTeams = $this->UserTeam->find('count',['conditions'=>  ['UserTeam.status'=> 2, 'UserTeam.request_date > '=> $dateBefore]]);
            }
        if ($userTeams) {
                return $userTeams;
                }
                    return $userTeams;

    }

    /**
     * showFanNotification method
     *
     * @package       app.View.Helper
     *
     * @param null|mixed $wallId
     */
    public function showFanPostNotification($wallId = null) {
        $this->Notification = ClassRegistry::init('Notification');
        $this->File = ClassRegistry::init('File');
        $postNotification = 0;
        $imageUrl = '';
                $postNotification = $this->Notification->find('all',['conditions'=>  ['Notification.to'=> AuthComponent::User('id'), 'Notification.status  '=> 0, 'WallContent.wall_id'=>$wallId], 'fields'=>['User.name', 'User.file_id', 'WallContent.id', 'WallContent.name', 'Notification.id']]);
                if (!empty($postNotification)) {
                    $data = '';
                        foreach($postNotification as $notification) {
                         $fileId = $notification['User']['file_id'];

                        if(!empty($fileId)){
                            $imageUrl = $this->File->find('first',['conditions'=>  ['File.id'=> $fileId, 'File.status  '=> 1], 'fields'=>['File.new_name']]);
                            $imageUrl = BASE_URL . 'img/ProfileImages/thumbnail/' . $imageUrl['File']['new_name'];
                            } else {
                                $imageUrl = BASE_URL . 'img/default_profile.png';
                            }
                            $data .= '<li><div class="notification-imgdiv"><img class="notification-user" src="' . $imageUrl . '"></div><div class="notification-text" ><a href="' . BASE_URL . 'walls/notificaton/' . base64_encode($notification['WallContent']['id']) . '/' . base64_encode($notification['Notification']['id']) . '">' . __dbt('Tagged by ' . $notification['User']['name']) . ' </a></div></li>';
                        }
                        return $data;
                }
                    return '<li><a href="javascript:void(0)">' . __dbt('You have 0 notification.') . '</a></li>';

    }

    /**
     * showFanNotification method
     *
     * @package       app.View.Helper
     *
     * @param null|mixed $wallId
     */
    public function getNotificationCount($wallId = null) {
        $this->Notification = ClassRegistry::init('Notification');
        $NotificationCount = $this->Notification->find('count',['conditions'=>  ['Notification.to'=> AuthComponent::User('id'), 'Notification.status  '=> 0, 'WallContent.wall_id'=>$wallId], 'fields'=>['User.name', 'User.file_id', 'WallContent.id', 'WallContent.name', 'Notification.id']]);
        if($NotificationCount == 0) {
            return '';
            }
                return '<div class="round red"><span>' . $NotificationCount . '</span></div>';

        }

}