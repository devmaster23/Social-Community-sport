<?php

App::uses('Helper', 'View');

/**
 * Chat helper
 *
 * Add your chat based methods in the class below.
 *
 * @package       app.View.Helper
 */
class ChatHelper extends AppHelper {
    public $chatroom_id;
    public $hObject;
    public $Chat;
    public $File;
    public $User;
    public $lastMessage;

    public function __construct() {
        $this->Chat = ClassRegistry::init('Chat');
        $this->User = ClassRegistry::init('User');
        $this->File = ClassRegistry::init('File');
        $this->lastMessage = date('Y-m-d H:i:s');
    }

    public function loadChat($chatroom_id, $hObject) {
        $this->hObject = $hObject;
        $this->chatroom_id = $chatroom_id;
        $chattext = __dbt('Chat Room');
        $chats = $this->getChats();
        $chatHistory = BASE_URL . 'chats/maximize_chat/' . base64_encode($_SESSION['Auth']['User']['sportSession']['chatroom_id']);
        $script = <<<EOD
    <style>
        .chat-floater{ width:362px; position:absolute; background-color:#fff; z-index:99; bottom:224px; right:15px;}
        .chat-floater .chat-content { overflow-y:auto; height:350px; position:relative; bottom:36px; }
        .chat-floater .chat-bar { position:relative; bottom:36px;}
        .chat-floater .input-group { position:absolute; bottom:0; margin-right:10px; width:362px; }
        .btm0 { bottom:0; }
        .chat-floater .chat-bar.posbtmwd { bottom: 0 !important; width: 362px; }
        .chat-floater .chat-avtar img { width:100%; height:100%; }
        .chat-desc.my-txt { text-align:right; }
        .smile-sticker { background: rgba(0, 0, 0, 0) url("/img/smile-icon.png") no-repeat scroll right 0 / 20px 20px; height: 20px; position: absolute; right: 40px; top: 7px; width: 20px; cursor:pointer; }
        .sticker-box { background: #ffffff; border: 2px solid #ccc; border-radius: 6px; height: 60%; overflow-y: auto; position: absolute; top: 0; width: 100%; z-index: 1; display:none; }
        .sticker-box li { border: 1px solid; float: left; margin: 2px; padding: 2px; width: 60px; cursor:pointer; }
        .sticker-box li:hover { padding:8px; }
        .chat-desc img { width:50px; }
    </style>
    <div class="chat-wrap chat-floater">
        <div class="chat-bar">
            <h4><p class="cht-rm-stts actve-chat"></p><a title="Chat History" href="{$chatHistory}">{$chattext}</a></h4>
            <div class="smile-sticker"></div>
            <div class="chat-mmx"><i class="fa fa-minus"></i></div>
        </div>
        <div class="sticker-box">
                <ul>
                    <li> <img src="/img/stickers/1.png" > </li><li> <img src="/img/stickers/2.png" > </li><li> <img src="/img/stickers/3.png" > </li><li> <img src="/img/stickers/4.png" > </li><li> <img src="/img/stickers/5.png" > </li><li> <img src="/img/stickers/6.png" > </li><li> <img src="/img/stickers/7.png" > </li><li> <img src="/img/stickers/8.png" > </li><li> <img src="/img/stickers/9.png" > </li><li> <img src="/img/stickers/10.png" > </li><li> <img src="/img/stickers/11.png" > </li><li> <img src="/img/stickers/12.png" > </li><li> <img src="/img/stickers/13.png" > </li><li> <img src="/img/stickers/14.png" > </li><li> <img src="/img/stickers/15.png" > </li><li> <img src="/img/stickers/16.png" > </li><li> <img src="/img/stickers/17.png" > </li><li> <img src="/img/stickers/18.png" > </li><li> <img src="/img/stickers/19.png" > </li><li> <img src="/img/stickers/20.png" > </li><li> <img src="/img/stickers/21.png" > </li><li> <img src="/img/stickers/22.png" > </li><li> <img src="/img/stickers/23.png" > </li><li> <img src="/img/stickers/24.png" > </li><li> <img src="/img/stickers/25.png" > </li><li> <img src="/img/stickers/26.png" > </li><li> <img src="/img/stickers/27.png" > </li>
                <ul>
        </div>
        <div class="chat-content" id="chat_data">
            {$chats}
        </div>
        <div class="input-group">
            <input type="text" id="chat_input" placeholder="..." class="form-control">
            <span class="input-group-btn">
            </span>
        </div>
    </div>
EOD;

        $js = $this->loadjs();
        return $script . $js;
    }

    //"{$this->Session->read('LoginTime')}";
    public function loadjs() {
        $date = date('Y-m-d H:i:s');
        $crm = base64_encode($this->chatroom_id);
        $lm = $this->lastMessage;
       $league_id= base64_encode($_SESSION['Auth']['User']['sportSession']['league_id']);
       $sport_id= base64_encode($_SESSION['Auth']['User']['sportSession']['sport_id']);
       $team_id= base64_encode($_SESSION['Auth']['User']['sportSession']['team_id']);
       $teams_id= $_SESSION['Auth']['User']['sportSession']['team_id'];
       $tournament_id= base64_encode($_SESSION['Auth']['User']['sportSession']['tournament_id']);
        $js = <<<EOD
    <script>
        var crm = "{$crm}";
        var lastMessage = "{$lm}";
                
        $(document).ready(function(){
                
            setInterval(refreshChat, 2000);
            setInterval(getChatRoomChat,2000);
        
            $(document).on("click", ".sticker-box li", function(){
                var OBJ = $(this);
                msg = OBJ.html();
                $(".sticker-box").toggle();
                $.post("{$this->hObject->Html->url([$this->params['prefix'] => false, 'controller' => 'chats', 'action' => 'add'])}",{id:crm,msg:msg}, function(resp){
                        data = $.parseJSON(resp);
                        if(data.status=='0'){	
                                return false;
                        }
                        else{
                                //update lastMessage vaue
                                lastMessage = data.lm;
                                $('#chat_data').append(data.html);
                                $("#chat_input").val('');
                                $('.chat-content').scrollTop($('.chat-content')[0].scrollHeight+200);
                        }
                });
            });
            
            $(document).on("keydown", "#chat_input",function(e){
                    if(e.shiftKey == 1){
                    }
                    else{
                      if((e.keyCode == 13))
                      {
                            msg = $("#chat_input").val();
                            msg = $.trim(msg);
                            var gameIds = $("#chat_input").attr('data-gameids');
                            if(msg==''){ return false; }
                            $.post("{$this->hObject->Html->url([$this->params['prefix'] => false, 'controller' => 'chats', 'action' => 'add'])}",{id:crm,msg:msg,gameIds:gameIds}, function(resp){
                                    data = $.parseJSON(resp);
                                    if(data.status=='0'){	
                                            return false;
                                    }
                                    else{
                                            //update lastMessage vaue
                                            lastMessage = data.lm;
                                            $('#chat_data').append(data.html);
                                            $("#chat_input").val('');
                                            $('.chat-content').scrollTop($('.chat-content')[0].scrollHeight+200);
                                    }
                            });
                      }
                    }
            });
            $('.chat-content').scrollTop($('.chat-content')[0].scrollHeight+200);
        });
                            
        
        
        function refreshChat(){
            var LoginTime = "{$date}"; 
            var PageLoadTime = "{$date}";

            $.post("{$this->hObject->Html->url([$this->params['prefix'] => false, 'controller' => 'chats', 'action' => 'getChatUpdate'])}",{lastMessageTime:lastMessage, PageLoadTime:PageLoadTime,id:crm},function(resp){
                data = $.parseJSON(resp);
                if(data.status == '0'){
                    return false;
                }
                else{
                    if(data.status == 1) { //new message
                        //if minimized
                        //maximize
                        //alert("awww"); //$('.chat1_minimizer section').show();
                    }
                    //update lastMessage value
                    lastMessage = data.lm;
                    $('#chat_data').append(data.html);
                    $('.chat-content').scrollTop($('.chat-content')[0].scrollHeight+200);
                }
            });
        }
             function getChatRoomChat(){
            var leagueId = "{$league_id}";
            var tournamentId = "{$tournament_id}";
            var sportId = "{$sport_id}";
            var teamId = "{$team_id}";
            var teamsId = "{$teams_id}";
            $.post("{$this->hObject->Html->url([$this->params['prefix'] => false, 'controller' => 'chats', 'action' => 'getMatchUpdateList'])}",{teamId:teamId},function(response){
                // alert(response);
                if(response==1)
                {         
                  
                  jQuery("#putErrorGiftBox").modal({
                        backdrop: 'static',
                        keyboard: true, 
                        show: true
                         }); 
            }

            });
     
           }
    
    </script>
    <div class="bloger-modal">
    <div class="modal fade" id="putErrorGiftBox" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width:60%;left:20%;">
                <div class="modal-header">
                <button type="button" class="close">x</button>
                    <h4 class="modal-title">Alert</h4>
                </div>
                <div class="modal-body2" style="height:min-height;">
                <div class="errorbox" id="errorbox" style="text-align:center;padding-top:14px;padding-bottom:14px;color:black;"><strong>Your chat window is changed now.</strong>
               <form id="post_data" method="post" style="display:none;" name="post_data" action="/dashboard/startTeamSession/$team_id/$tournament_id/$league_id/$sport_id">
                 <input type="hidden" value="POST" name="_method">
                 </form>         
                 <center><button type="button" class="btn btn-info" onclick="document.post_data.submit(); event.returnValue = false; return false;" style="padding:2px 16px;margin-top:15px;margin-bottom:2px;">ok</button></center>
                
                
                </div>
            </div>
        </div>
    </div>
</div>
EOD;
        return $js;
    }

    public function getChats() {
        $this->Chat->bindModel(['belongsTo' => ['User']], false);

        $userData = $this->getUserData(AuthComponent::User('id'));
        $options['conditions'] = ['Chat.chatroom_id' => $this->chatroom_id, 'Chat.created >=' => $userData['User']['created']];
        $options['order'] = 'Chat.created ASC';
        $options['limit'] = 100;
        $options['fields'] = ['Chat.*', 'User.id', 'User.name', 'User.file_id'];

        $chats = $this->Chat->find('all', $options);

        return $this->formatChats($chats);
    }

    public function getUserData($userId) {
        $this->User->UnbindModel(['hasMany' => ['League', 'PollResponse', 'Sport', 'Team', 'WallContent', 'UserTeam']], false);
        $userJoindedDate = $this->User->find('first', ['conditions' => ['User.id' => $userId], 'fields' => ['User.created', 'User.modified', 'User.id']]);
        return $userJoindedDate;
    }

    public function formatChats($chats) {
        $script = '';
        foreach ($chats as $chat) {

            $file = $this->File->findById($chat['User']['file_id']);
            if (empty($file)) {
                $file['File']['path'] = '/img/default_profile.png';
            }
            $timeElapsed = humanTiming(strtotime($chat['Chat']['created']));
            $pull_right = ($chat['User']['id'] == AuthComponent::user('id')) ? 'pull-right' : '';
            $my_txt = ($chat['User']['id'] == AuthComponent::user('id')) ? 'my-txt' : '';

            $script .=
                    <<<EOD
<div class="chat-rpt">
            <div class="chat-usr-dtl {$pull_right}">
                <div class="chat-avtar">
                    <img src="{$file['File']['path']}" alt="chat user" title="chat user" />
                </div>
                <div class="chat-user">
                    <h4>{$chat['User']['name']} </h4>
                    <p>{$timeElapsed} ago </p>
                </div>
            </div>
            <div class="chat-desc {$my_txt}">
                {$chat['Chat']['name']}
            </div>
</div>
EOD;

            $this->lastMessage = $chat['Chat']['created'];
        }

        return $script;
    }

    /** getTeamsChatStatus method 
     * @admin method
     * check team allowed for chat or not
     *
     * @param null|mixed $firstTeam
     * @param null|mixed $secondTeam
     */
    public function getTeamsChatStatus($firstTeam = null, $secondTeam = null) {
        $this->Chatroom = ClassRegistry::init('Chatroom');
        $allowedTeams = $firstTeam . ',' . $secondTeam;
        return $room = $this->Chatroom->find('count', ['conditions' => ['Chatroom.allowed_teams' => $allowedTeams, 'Chatroom.status' => 1]]);
    }

    /** getUserImage method 
     * @chat history
     * show chat user image
     *
     * @param null|mixed $fileId
     */
    public function getUserImage($fileId = null) {
        $this->File = ClassRegistry::init('File');
        if (!empty($fileId)) {
            $imageUrl = $this->File->find('first', ['conditions' => ['File.id' => $fileId, 'File.status  ' => 1], 'fields' => ['File.new_name']]);
            $imageUrl = BASE_URL . 'img/ProfileImages/thumbnail/' . $imageUrl['File']['new_name'];
        } else {
            $imageUrl = BASE_URL . 'img/default_profile.png';
        }
        return '<img title="chat user" alt="chat user" src="' . $imageUrl . '">';
    }

    public function loadChatFull($chatroom_id, $hObject) {
        $this->hObject = $hObject;
        $this->chatroom_id = $chatroom_id;
        $chattext = __dbt('Chat History');
        $chats = $this->getChats();
        $chatHistory = BASE_URL . 'chats/viewChatHistory/' . base64_encode($_SESSION['Auth']['User']['sportSession']['chatroom_id']);
        $script = <<<EOD
    <style>
                  #chat_data {height: auto;max-height: 500px;overflow-y: auto;}
                .chat-floater .chat-avtar img { width:100%; height:100%; }
        .chat-desc.my-txt { text-align:right; }
        .smile-sticker { background: rgba(0, 0, 0, 0) url("/img/smile-icon.png") no-repeat scroll right 0 / 20px 20px; height: 20px; position: absolute; right: 15px; top: 7px; width: 20px; cursor:pointer; }
        .sticker-box { background: #ffffff; border: 2px solid #ccc; border-radius: 6px; height: 60%; overflow-y: auto; position: absolute; top: 62px; width: 94%; z-index: 1; display:none; }
        .sticker-box li { border: 1px solid; float: left; margin: 2px; padding: 2px; width: 60px; cursor:pointer; }
        .sticker-box li:hover { padding:8px; }
        .chat-desc img { width:50px; }
                </style>
    <div class="chat-wrap chat-floater btm0">
        <div class="chat-bar">
            <h4><a title="Chat History" href="{$chatHistory}">{$chattext}</a></h4>
            <div class="smile-sticker"></div>
        </div>
        <div class="sticker-box">
                <ul>
                    <li> <img src="/img/stickers/1.png" > </li><li> <img src="/img/stickers/2.png" > </li><li> <img src="/img/stickers/3.png" > </li><li> <img src="/img/stickers/4.png" > </li><li> <img src="/img/stickers/5.png" > </li><li> <img src="/img/stickers/6.png" > </li><li> <img src="/img/stickers/7.png" > </li><li> <img src="/img/stickers/8.png" > </li><li> <img src="/img/stickers/9.png" > </li><li> <img src="/img/stickers/10.png" > </li><li> <img src="/img/stickers/11.png" > </li><li> <img src="/img/stickers/12.png" > </li><li> <img src="/img/stickers/13.png" > </li><li> <img src="/img/stickers/14.png" > </li><li> <img src="/img/stickers/15.png" > </li><li> <img src="/img/stickers/16.png" > </li><li> <img src="/img/stickers/17.png" > </li><li> <img src="/img/stickers/18.png" > </li><li> <img src="/img/stickers/19.png" > </li><li> <img src="/img/stickers/20.png" > </li><li> <img src="/img/stickers/21.png" > </li><li> <img src="/img/stickers/22.png" > </li><li> <img src="/img/stickers/23.png" > </li><li> <img src="/img/stickers/24.png" > </li><li> <img src="/img/stickers/25.png" > </li><li> <img src="/img/stickers/26.png" > </li><li> <img src="/img/stickers/27.png" > </li>
                <ul>
        </div>
        <div class="chat-content" id="chat_data">
            {$chats}
        </div>
        <div class="input-group" style="width:100% !important">
            <input type="text" id="chat_input" placeholder="..." class="form-control">
            <span class="input-group-btn">
            </span>
        </div>
    </div>
EOD;

        $js = $this->loadjsAll();
        return $script . $js;
    }

    public function loadjsAll() {
        $date = date('Y-m-d H:i:s');
        $crm = base64_encode($this->chatroom_id);
        $lm = $this->lastMessage;
        $js = <<<EOD
    <script>
        var crm = "{$crm}";
        var lastMessage = "{$lm}";
                
        $(document).ready(function(){
                
            setInterval(refreshChat, 2000);
        
            $(document).on("click", ".sticker-box li", function(){
                var OBJ = $(this);
                msg = OBJ.html();
                $(".sticker-box").toggle();
                $.post("{$this->hObject->Html->url([$this->params['prefix'] => false, 'controller' => 'chats', 'action' => 'add'])}",{id:crm,msg:msg}, function(resp){
                        data = $.parseJSON(resp);
                        if(data.status=='0'){	
                                return false;
                        }
                        else{
                                //update lastMessage vaue
                                lastMessage = data.lm;
                                $('#chat_data').append(data.html);
                                $("#chat_input").val('');
                                $('.chat-content').scrollTop($('.chat-content')[0].scrollHeight+1000);
                        }
                });
            });
            
            $(document).on("keydown", "#chat_input",function(e){
                    if(e.shiftKey == 1){
                    }
                    else{
                      if((e.keyCode == 13))
                      {
                            msg = $("#chat_input").val();
                            msg = $.trim(msg);
                            var gameIds = $("#chat_input").attr('data-gameids');
                            if(msg==''){ return false; }
                            $.post("{$this->hObject->Html->url([$this->params['prefix'] => false, 'controller' => 'chats', 'action' => 'add'])}",{id:crm,msg:msg,gameIds:gameIds}, function(resp){
                                    data = $.parseJSON(resp);
                                    if(data.status=='0'){	
                                            return false;
                                    }
                                    else{
                                            //update lastMessage vaue
                                            lastMessage = data.lm;
                                            $('#chat_data').append(data.html);
                                            $("#chat_input").val('');
                                            $('.chat-content').scrollTop($('.chat-content')[0].scrollHeight+1000);
                                    }
                            });
                      }
                    }
            });
            $('.chat-content').scrollTop($('.chat-content')[0].scrollHeight+1000);
        });
                            
        
        
        function refreshChat(){
            var LoginTime = "{$date}"; 
            var PageLoadTime = "{$date}";

            $.post("{$this->hObject->Html->url([$this->params['prefix'] => false, 'controller' => 'chats', 'action' => 'getChatUpdate'])}",{lastMessageTime:lastMessage, PageLoadTime:PageLoadTime,id:crm},function(resp){
                data = $.parseJSON(resp);
                if(data.status == '0'){
                    return false;
                }
                else{
                    if(data.status == 1) { //new message
                        //if minimized
                        //maximize
                        //alert("awww"); //$('.chat1_minimizer section').show();
                    }
                    //update lastMessage value
                    lastMessage = data.lm;
                    $('#chat_data').append(data.html);
                    $('.chat-content').scrollTop($('.chat-content')[0].scrollHeight+1000);
                }
            });
        }
            
    </script>
EOD;
        return $js;
    }

}
