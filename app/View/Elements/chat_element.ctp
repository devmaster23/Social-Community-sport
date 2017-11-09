<?php

echo $this->Chat->loadChat($_SESSION['Auth']['User']['sportSession']['chatroom_id'], $this);
//echo $this->Chat->loadChat(21, $this);
?>
<style>
    .game_widget { background-color: #fff;
    left: 0;
    position: absolute;
    width: 200px;
    z-index: 9999;
    border-top: 1px solid #ddd;
    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd; }
    .game_wizard { float: left;
    margin: 0;
    padding: 0;
    width: 200px; }
    .game_wizard > li { display: inline;
    float: left;
    margin: 0;
    padding: 10px; color:#555; font-size:13px;
    width: 200px;
    cursor: pointer;
    border-bottom: 1px solid #ddd; }
    .game_wizard > li:hover { background-color: #ddd; }
    .dispNone { display: none; }
    
    .game_wizard > li:hover{ background: #df1f13; color: #fff;}
</style>
<script>
    $(document).ready(function(){
        $(document).on("click", ".chat-mmx", function(){
            if($(this).parents(1).children(".chat-content").css("display") != 'none'){
                $(this).parents(1).children(".chat-content").hide();
                $(this).parents(1).children(".input-group").hide();
                $(".smile-sticker").hide();
                $(this).parents(1).addClass("posbtmwd");
            }
            else{
                $(this).parents(1).children(".chat-content").show();
                $(this).parents(1).children(".input-group").show();
                $(".smile-sticker").show();
                $(this).parents(1).removeClass("posbtmwd");
            }
        });
        
        $(document).on("click", ".smile-sticker", function(){
            $(".sticker-box").toggle();
        });
        
        $(document).on("keydown", "#chat_input", function(e){
            var glist = '<?php echo $gameList; ?>';
            glist = $.parseJSON(glist);
            console.log(glist);
            var pointer = $(this);

            if(e.shiftKey==true && e.keyCode == 50){
                var topPos = pointer.offset().top;
                var leftPos = pointer.offset().left;

                var strAutocompleteHtm = '<div class="game_widget dispNone">'+
                                        '<ul class="game_wizard">';

                $.each( glist, function( key, value ) {
                    strAutocompleteHtm += '<li class="game_section" data-gamename="'+value.GameName+'" data-gameid="'+value.GameID+'">'+value.GameName+'</li>';
                });

                strAutocompleteHtm += '</ul></div>';
                $('body').append(strAutocompleteHtm);
                var autoCompHgt = $('.game_widget').height();
                $('.game_widget').css('top', (topPos - autoCompHgt)).css('left', (leftPos - 1)).removeClass('dispNone');
            } else {
                $('.game_widget').addClass('dispNone');
            }
        });

        $(document).on('click', '.game_section', function(){
            $('.game_widget').addClass('dispNone');
            var gameId = $(this).data('gameid');
            
            if (typeof $('#chat_input').attr('data-gameids') != 'undefined') {
                var strIds = $('#chat_input').attr('data-gameids');
                var arrIds = strIds.split(',');
                arrIds[arrIds.length] = gameId;
            } else {
                var arrIds = [gameId];
            }
            $('#chat_input').attr('data-gameids', arrIds.join(','));
            
            var gameName = '@' + $(this).data('gamename');
            var strVal = $('#chat_input').val();
            var strValNew = strVal.substring(0, strVal.lastIndexOf("@"));
            strValNew = $.trim(strValNew);
            strValNew = strValNew + ' ' + gameName+' ';
            $('#chat_input').val(strValNew);
            $( "#chat_input" ).focus();
        });
    });
</script>