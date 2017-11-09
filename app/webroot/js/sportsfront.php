<?php
?>
<script>$(document).ready(function(){
      
       // slider configuration
       $('#mainSlider').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: true,
            slideshow: true,
            slideshowSpeed: 2000, 
            startAt: 0, 
            after: function(slider) {
            /* auto-restart player if paused after action */
            if (!slider.playing) {
              slider.play();
            }
          }
        });

    //add & edit users for admin,sports,league,team
       $("#signInId").validate({
        rules: {
          "data[User][email]": {
                                required: true,
                                email: true
                                },
           "data[User][password]": {required:true,
                                    minlength:6}
        },
        messages: {
          "data[User][email]": {
                                required: "<?php echo __('Please enter your email.'); ?>",
                                email: "<?php echo __('Please enter valid email.')?>",
                                },
          "data[User][password]": {required:"<?php echo __('Please enter password.')?>",
                                   minlength:"<?php echo __('Minimum 6 characters required.')?>"
                                }
         
        }
      });   
      
      $("#blogSignInId").validate({
        rules: {
          "data[User][email]": {
                                required: true,
                                email: true
                                },
           "data[User][password]": {required:true,
                                    minlength:6}
        },
        messages: {
          "data[User][email]": {
                                required: "<?php echo __('Please enter your email.')?>",
                                email: "<?php echo __('Please enter valid email.')?>",
                                },
          "data[User][password]": {required:"<?php echo __('Please enter password.')?>",
                                   minlength:"<?php echo __('Minimum 6 characters required.')?>"
                    }
         
        }
      });
      
       $("#editorSignInId").validate({
        rules: {
          "data[User][email]": {
                                required: true,
                                email: true
                                },
           "data[User][password]": {required:true,
                                    minlength:6}
        },
        messages: {
          "data[User][email]": {
                                required: "<?php echo __('Please enter your email.')?>",
                                email: "<?php echo __('Please enter valid email.')?>",
                                },
          "data[User][password]": {required:"<?php echo __('Please enter password.')?>",
                                   minlength:"<?php echo __('Minimum 6 characters required.')?>"
                    }
         
        }
      });
      
      

        
        //method to check date validation  
        $.validator.addMethod("uploadFile",  function (value) {
                    if (value == '') {
                        return true;
                    }
                    var fileExtension = value.split('.').pop();

                    return ((fileExtension === 'GIF') || (fileExtension === 'gif') || (fileExtension === 'jpg') || (fileExtension === 'jpeg') || (fileExtension === 'PNG') || (fileExtension === 'png') || (fileExtension === 'JPG') || (fileExtension === 'JPEG'));
                }, "<?php echo __('Gif, jpg, jpeg, png images are allowed.')?>");
       
     
       
        
        $("#bloggerSignUpId").validate({
        rules: {
          "data[User][name]": {required:true,maxlength:25},
          "data[User][email]": {
                                required: true,
                                email: true,
                                remote: {
                                  url: "/users/checkEmailExist/"+$('#UserEmail').val(),
                                  type: "post"
                                }
                                },
          "data[User][password]": {required:true,
                                    minlength:6},
          "data[User][confirm_password]": {
                                required: true,
                                equalTo: "#BloggerPassword"
                                },
          "data[User][locale_id]": "required",
          "data[User][gender]": "required",
          "data[User][file_id]": {uploadFile:true},
        },
        messages: {
          "data[User][name]": {required :"<?php echo __('Please enter your name.')?>",
                               maxlength :"<?php echo __('25 characters max limit.')?>"},
          "data[User][email]": {
                                required: "<?php echo __('Please enter your email.')?>",
                                email: "<?php echo __('Please enter valid email.')?>",
                                remote: jQuery.format("<?php echo __('Email is already in use')?>"),
                                },
          "data[User][password]": {required:"<?php echo __('Please enter password.')?>",
                                   minlength:"<?php echo __('Minimum 6 characters required.')?>"
                    },
          "data[User][confirm_password]": {
                                required: "<?php echo __('Please re-enter password.')?>",
                                equalTo: "<?php echo __('Password do not match.')?>",
                                },
          "data[User][locale_id]": "<?php echo __('Please select language.')?>",
          "data[User][gender]": "<?php echo __('Please select gender.')?>"
        }
      });
      
      
       $("#fanSignUpId").validate({
        rules: {
          "data[User][name]": {required:true,maxlength:25},
          "data[User][email]": {
                                required: true,
                                email: true,
                                remote: {
                                  url: "/users/checkEmailExist/"+$('#UserEmail').val(),
                                  type: "post"
                                }
                                },
          "data[User][password]": {required:true,
                                    minlength:6},
          "data[User][confirm_password]": {
                                required: true,
                                equalTo: "#fanPassword"
                                },
          "data[User][locale_id]": "required",
          "data[User][gender]": "required",
          "data[User][file_id]": {uploadFile:true},
        },
        messages: {
          "data[User][name]": {required :"<?php echo __('Please enter your name.')?>",
                               maxlength :"<?php echo __('25 characters max limit.'); ?>"},
          "data[User][email]": {
                                required: "<?php echo __('Please enter your email.')?>",
                                email: "<?php echo __('Please enter valid email.')?>",
                                remote: jQuery.format("<?php echo __('Email is already in use')?>"),
                                },
          "data[User][password]": {required:"<?php echo __('Please enter password.')?>",
                                   minlength:"<?php echo __('Minimum 6 characters required.')?>"
                    },
          "data[User][confirm_password]": {
                                required: "<?php echo __('Please re-enter password.')?>",
                                equalTo: "<?php echo __('Password do not match.')?>",
                                },
          "data[User][locale_id]": "<?php echo __('Please select language.')?>",
          "data[User][gender]": "<?php echo __('Please select gender.')?>"
        }
      });

      $("#UserMyProfileForm,#UserBloggerMyProfileForm").validate({
        rules: {
          "data[User][name]": "required",
        },
        messages: {
          "data[User][name]":"<?php echo __('Please enter your name.')?>"
         
         
        }
      });   
      
      
        //Change Password
       $("#UserFanChangePasswordForm,#UserBloggerChangePasswordForm").validate({
        rules: {
          "data[User][current_password]": "required",
          "data[User][new_password]": {required:true,
                                    minlength:6},
          "data[User][re_enter_password]": {
                                required: true,
                                equalTo: "#UserNewPassword"
                                },
        },
        messages: {
          "data[User][current_password]": "<?php echo __('Please enter current password.')?>",
          "data[User][new_password]": {required:"<?php echo __('Please enter new password.')?>",
                                        minlength:"<?php echo __('Minimum 6 characters required.')?>"
                    },
          "data[User][re_enter_password]": {
                                required: "<?php echo __('Please re-enter new password.')?>",
                                equalTo: "<?php echo __('Password do not match.')?>",
                                }
        }
      });


      //registration step 2
       $("#UserTeamAddForm,#UserTeamBloggerAddForm").validate({
        rules: {
          "data[UserTeam][sport_id]": "required",  
          "data[UserTeam][tournament_id]": "required",
          "data[UserTeam][league_id]": "required",
          "data[UserTeam][team_id]": "required",
          
          
        },
        messages: {
          "data[UserTeam][sport_id]": "<?php echo __('Please select sport.')?>",    
          "data[UserTeam][tournament_id]": "<?php echo __('Please select tournament.')?>",  
          "data[UserTeam][league_id]": "<?php echo __('Please select league.')?>",
          "data[UserTeam][team_id]": "<?php echo __('Please select team.')?>",
          
         
        }
      });
       
      //Youtube video add
       $("#WallContentBloggerShareVideoForm").validate({
        rules: {
          "data[WallContent][name]": "required",  
          "data[WallContent][title]": "required",
          "data[WallContent][status]": "required",
          
          
        },
        messages: {
          "data[WallContent][name]": "<?php echo __('Please input link.')?>",    
          "data[WallContent][title]": "<?php echo __('Please input video title.')?>",  
          "data[WallContent][status]": "<?php echo __('Please select status.')?>",
          
        }
      });

      
     
      //user forgot password  
      $("#UserForgotPasswordForm").validate({
        rules: {
          "data[User][email]": {
                                required: true,
                                email: true
                                }
        },
        messages: {
          "data[User][email]": {
                                required: "<?php echo __('Please enter your email.')?>",
                                email: "<?php echo __('Please enter valid email.')?>",
                                }
        }
      });   
         
  $("#NewsEditorAddForm").validate({
        rules: {  
          "data[News][foreign_key]": "required",
          "data[News][description]": "required",
          "data[News][file_id]": "required",
          "data[News][status]": "required"
          
        },
        messages: {
          "data[News][foreign_key]": "<?php echo __('Please select sport.')?>",
          "data[News][description]": "<?php echo __('Please add description.')?>",
          "data[News][file_id]": "<?php echo __('Please select file.')?>",
          "data[News][status]": "<?php echo __('Please select status.')?>"
         
        }
      });
       $("#NewsEditorEditForm").validate({
        rules: {  
          "data[News][foreign_key]": "required",
          "data[News][description]": "required",
          "data[News][status]": "required"
          
        },
        messages: {
          "data[News][foreign_key]": "<?php echo __('Please select sport.')?>",
          "data[News][description]": "<?php echo __('Please add description.')?>",
          "data[News][status]": "<?php echo __('Please select status.')?>"
         
        }
      });
      
      $("#NewsAddCommentForm").validate({
        rules:{
            "data[NewsComment][content]":"required"
        },
        messages:{
            "data[NewsComment][content]":"<?php echo __('Please add news content.')?>"
        }
      });
      
      
       $(document).on('change','#UserFileId',function(){
            var previousbtn = $(this);
            var file_id = this.files[0];
            console.log(file_id);
            //var file_id;
            name = file_id.name;
            size = file_id.size;
            type = file_id.type;
            var formdata = new FormData()
            formdata.append('file_id', file_id);
            $.ajax({
                type: 'POST',
                url: "<?php echo $this->Html->url(['controller' => 'editors', 'action' => 'checkMimeType']); ?>",
                data: formdata,
                processData: false,
                contentType: false,
                success: function (result) {
                   if(result==0){
                       alert("<?php echo __('Invalid Image'); ?>");
                       previousbtn.val('');
                   }else{
                       
                   }
                }
            });
        });
        
        $(document).on('click','.ui-menu-item a',function(){
            $('#contentHere').html("<div class='text-center'><img src='/img/loader.gif'></div>");
            //console.log($(this).closest('form').attr('id'));
            var formId = $('#findForm').closest('form').attr('id');
            var c_p_type = '';
            var c_p_l_id = '';
            var c_p_g_c_id = ''; 
            if(formId == 'BaseballPredictionBaseballPredictionForm'){
                 c_p_type = $("#BaseballPredictionType").val();
                 c_p_l_id = $("#BaseballPredictionLocationId").val();
                 c_p_g_c_id = $("#BaseballPredictionGiftCategoryId").val();
            }else if(formId == 'BasketballPredictionBasketballPredictionForm'){
                 c_p_type = $("#BasketballPredictionType").val();
                 c_p_l_id = $("#BasketballPredictionLocationId").val();
                 c_p_g_c_id = $("#BasketballPredictionGiftCategoryId").val();
            }else if(formId == 'FootballPredictionFootballPredictionForm'){
                 c_p_type = $("#FootballPredictionType").val();
                 c_p_l_id = $("#FootballPredictionLocationId").val();
                 c_p_g_c_id = $("#FootballPredictionGiftCategoryId").val();
            }else if(formId == 'SoccerPredictionSoccerPredictionForm'){
                 c_p_type = $("#SoccerPredictionType").val();
                 c_p_l_id = $("#SoccerPredictionLocationId").val();
                 
                 c_p_g_c_id = $("#SoccerPredictionGiftCategoryId").val();
            }else if(formId == 'HockeyPredictionHockeyPredictionForm'){
                 c_p_type = $("#HockeyPredictionType").val();
                 c_p_l_id = $("#HockeyPredictionLocationId").val();
                 c_p_g_c_id = $("#HockeyPredictionGiftCategoryId").val();
            }else{
                 c_p_type = $("#CricketPredictionType").val();
                 c_p_l_id = $("#CricketPredictionLocationId").val();
                 c_p_g_c_id = $("#CricketPredictionGiftCategoryId").val();
            }
            
            $.ajax({
                url:"/gifts/showlinks",
                type:"get",
                data:{'type':c_p_type,'location_id':c_p_l_id,'gift_category_id':c_p_g_c_id},
                success:function(result){
                   // console.log(result);
                    $('#contentHere').html(result);
                }
            });
        });
        
        function gohere(href){ 
            if(typeof(href) === 'undefined'){ 
                return false; 
            } 
            $.post(href, {ajaxpost:'true'}, function(data){ 
               var response = $.parseJSON(data); 
               $("#contentHere").append(response.html); 
               if(response.page != "0"){ 
                   $("#moreButton").html(response.page); 
               }else{ 
                   $("#moreButton").remove(); 
               } 
            }); 
            return false; 
        } 
        
        $(document).on('change','.radioinput',function(){
            console.log($(this).attr('id'));
            console.log($(this).attr('name'));
            console.log($(this).attr('class'));
            console.log($(this).closest('tr').html());
            $(this).attr('checked',true);
            var tdbody = $(this).closest('tr').html();
            $('#innhtmlhere').html("<table class='table table-bordered'><tr>"+tdbody+"</tr></table>");
            
            $('#before_radio').addClass('after-radio');
            $('#after_radio').removeClass('after-radio');
        });
        
        $(document).on('click','.goback',function(){
            $('#before_radio').removeClass('after-radio');
            $('#after_radio').addClass('after-radio');
        });
        
  });


function getRate(){
            document.getElementById("yahoo-rates").innerHTML = "<img src='/img/loader.gif'>";
            from = document.getElementById('from').value;
            to = document.getElementById('to').value;
            $.post("<?php echo $this->Html->url(['controller'=>'games', 'action'=>'getCurrencyRate']); ?>",{'from':from,'to':to,'access_Token':'OO0OO0OO0O0O0O0O0OO0O'},function(data){
                document.getElementById("yahoo-rates").innerHTML = data;
                
                $('.calcamount').each(function(){
                    var amt = data*parseFloat($(this).data('amount'));
                    $(this).html(amt);
                });
            });
        }
</script>