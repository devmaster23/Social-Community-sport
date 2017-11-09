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
class PollHelper extends AppHelper {
    /**
     * getPollTrend method
     *
     * @package       app.View.Helper
     *
     * @param null|mixed $pollId
     * @param null|mixed $optionVal
     */
    public function getPollTrend($pollId = null,$optionVal = null) {
        $this->PollResponse = ClassRegistry::init('PollResponse');
        $pollTrend = $this->PollResponse->find('count',['conditions'=>  ['PollResponse.poll_id'=> $pollId, 'PollResponse.name'=>$optionVal]]);
        $pollTrendSum = $this->PollResponse->find('count',['conditions'=>  ['PollResponse.poll_id'=> $pollId]]);
        //return $pollTrend .''.$pollTrendSum;
        if(!empty($pollTrendSum) && !empty($pollTrend)) {
             return  floor(($pollTrend/$pollTrendSum)*100);
                }
                    return  0;

        }

    /**
     * showForumComments method
     *
     * @package app.View.Helper
     *
     * @param null|mixed $forumId
     * @param null|mixed $page
     */
    public function showForumComments($forumId = null,$page = null) {
        $this->ForumComment = ClassRegistry::init('ForumComment');
        $contains = ['User.id', 'User.name'=> ['File.id', 'File.new_name']];
        $comments = $this->ForumComment->find('all',['contain'=>$contains, 'conditions'=>  ['ForumComment.forum_id'=> $forumId, 'ForumComment.status'=>1, 'ForumComment.is_deleted'=>0], 'fields'=>['ForumComment.id', 'ForumComment.name', 'ForumComment.created']]);
       // return pr($comments);
        if(!empty($comments)) {
            $commentData = '';
            $countComment = 1;
            $commentData .= '<ul id="commentContainer_' . $forumId . '">';
            foreach ($comments as $comment) :
               $commentId = $comment['ForumComment']['id'];
                if(AuthComponent::User('id') == $comment['User']['id']){
                    $commentData .= '<li id="li_' . $commentId . '">
                                        <div class="clearfix">
                                            <span class="profile_img"><a href="javascript:void(0);"><img alt="' . $comment['User']['File']['new_name'] . '" src="' . BASE_URL . 'img/ProfileImages/thumbnail/' . $comment['User']['File']['new_name'] . '"></a></span>
                                                <div class="main-comment">
                                                    <div class="clearfix">
                                                        <div class="pull-left">
                                                            <span class="name"><a href="javascript:void(0);">' . $comment['User']['name'] . '</a></span>
                                                            <span class="comment-time">' . date('Y-F-d',strtotime($comment['ForumComment']['created'])) . '</span>
                                                        </div>
                                                        <div class="pull-right">
                                                            <a id="delete_' . $commentId . '" class="delete-comment del-hover" title="delete comment" href="javascript:void(0)"><i class="fa fa-trash-o"></i></a>
                                                            <a id="edit_' . $commentId . '" class="edit-comment edit-hover" title="edit comment" href="javascript:void(0)"><i class="fa fa-pencil-square-o"></i></a>
                                                        </div>
                                                    </div>
                                                  <div id="comment_' . $commentId . '" class="coment-content CommentBoxShow">' . $comment['ForumComment']['name'] . '</div>
                                                  <div class="CommentBoxHide" id="commentBox_' . $commentId . '"></div>
                                                </div>
                                        </div>
                                    </li>';
                } else {
                    $commentData .= '<li id="li_' . $commentId . '">
                                        <div class="clearfix">
                                            <span class="profile_img"><a href="javascript:void(0);"><img alt="' . $comment['User']['File']['new_name'] . '" src="' . BASE_URL . 'img/ProfileImages/thumbnail/' . $comment['User']['File']['new_name'] . '"></a></span>
                                                <div class="main-comment">
                                                    <div class="clearfix">
                                                        <div class="pull-left">
                                                            <span class="name"><a href="javascript:void(0);">' . $comment['User']['name'] . '</a></span>
                                                            <span class="comment-time">' . date('Y-F-d',strtotime($comment['ForumComment']['created'])) . '</span>
                                                        </div>
                                                    </div>
                                                  <div id="comment_' . $commentId . '" class="coment-content CommentBoxShow">' . $comment['ForumComment']['name'] . '</div>
                                                  <div class="CommentBoxHide" id="commentBox_' . $commentId . '"></div>
                                                </div>
                                        </div>
                                    </li>';
                }
                if($countComment >=6 && $page != 'detail'){
                   break;
                }
                ++$countComment;
            endforeach;
            $commentData .= '</ul>';
                if($countComment >=6 && $page != 'detail'){
                    $commentData .= '<div class="full-post-link"><a title="view Post" href="' . BASE_URL . 'PollCategories/viewDetail/' . base64_encode($forumId) . '">View More</a></div>';
                }
            return $commentData;
        }
            return '<ul id="commentContainer_' . $forumId . '"><li></li></ul>';

    }

    /**
     * forumCommentCount method
     *
     * @package app.View.Helper
     *
     * @param null|mixed $forumId
     */
    public function forumCommentCount($forumId = null) {
        $this->ForumComment = ClassRegistry::init('ForumComment');
        $comments = $this->ForumComment->find('count',['conditions'=>  ['ForumComment.forum_id'=> $forumId, 'ForumComment.status'=>1, 'ForumComment.is_deleted'=>0]]);
        if($comments >1)
        {
            return '<span>' . $comments . '</span>' . __dbt('Comments');
        }
             return '<span>' . $comments . '</span>' . __dbt('Comment');

    }

}