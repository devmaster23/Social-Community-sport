  $(document).ready(function(){
      
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
                                required: "Please enter your email.",
                                email: "Please enter valid email.",
                                },
          "data[User][password]": {required:"Please enter password.",
                                   minlength:"Minimum 6 characters required."
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
                                required: "Please enter your email.",
                                email: "Please enter valid email.",
                                },
          "data[User][password]": {required:"Please enter password.",
                                   minlength:"Minimum 6 characters required."
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
                }, "Gif, jpg, jpeg, png images are allowed");
       
     
       
        
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
          "data[User][name]": {required :"Please enter your name.",
                               maxlength :"25 charcecters max limit."},
          "data[User][email]": {
                                required: "Please enter your email.",
                                email: "Please enter valid email.",
                                remote: jQuery.format('Email is already in use'),
                                },
          "data[User][password]": {required:"Please enter password.",
                                   minlength:"Minimum 6 characters required."
                    },
          "data[User][confirm_password]": {
                                required: "Please re-enter password.",
                                equalTo: "Password do not match.",
                                },
          "data[User][locale_id]": "Please select language.",
          "data[User][gender]": "Please select gender."
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
          "data[User][name]": {required :"Please enter your name.",
                               maxlength :"25 charcecters max limit."},
          "data[User][email]": {
                                required: "Please enter your email.",
                                email: "Please enter valid email.",
                                remote: jQuery.format('Email is already in use'),
                                },
          "data[User][password]": {required:"Please enter password.",
                                   minlength:"Minimum 6 characters required."
                    },
          "data[User][confirm_password]": {
                                required: "Please re-enter password.",
                                equalTo: "Password do not match.",
                                },
          "data[User][locale_id]": "Please select language.",
          "data[User][gender]": "Please select gender."
        }
      });

      $("#UserMyProfileForm,#UserBloggerMyProfileForm").validate({
        rules: {
          "data[User][name]": "required",
        },
        messages: {
          "data[User][name]":"Please enter your name."
         
         
        }
      });   
      
      
        //Change Password
//       $("#UserFanChangePasswordForm,#UserBloggerChangePasswordForm").validate({
//        rules: {
//          "data[User][current_password]": "required",
//          "data[User][new_password]": {required:true,
//                                    minlength:6},
//          "data[User][re_enter_password]": {
//                                required: true,
//                                equalTo: "#UserNewPassword"
//                                },
//        },
//        messages: {
//          "data[User][current_password]": "Please enter current password.",
//          "data[User][new_password]": {required:"Please enter new password.",
//                                        minlength:"Minimum 6 characters required."
//                    },
//          "data[User][re_enter_password]": {
//                                required: "Please re-enter new password.",
//                                equalTo: "Password do not match.",
//                                }
//        }
//      });


      //registration step 2
       $("#UserTeamAddForm,#UserTeamBloggerAddForm").validate({
        rules: {
          "data[UserTeam][sport_id]": "required",  
          "data[UserTeam][tournament_id]": "required",
          "data[UserTeam][league_id]": "required",
          "data[UserTeam][team_id]": "required",
          
          
        },
        messages: {
          "data[UserTeam][sport_id]": "Please select sport.",    
          "data[UserTeam][tournament_id]": "Please select tournament.",  
          "data[UserTeam][league_id]": "Please select league.",
          "data[UserTeam][team_id]": "Please select team.",
          
         
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
          "data[WallContent][name]": "Please input link.",    
          "data[WallContent][title]": "Please input video title.",  
          "data[WallContent][status]": "Please select status.",
          
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
                                required: "Please enter your email.",
                                email: "Please enter valid email.",
                                }
        }
      });   
         
         
      //contact form  
      //contact form  
      $("#ContactUsViewForm").validate({
        rules: {
          "data[ContactUs][email]": {
                                required: true,
                                email: true
                                },
            "data[ContactUs][message]": {required:true, maxlength: 256}                            
        },
        messages: {
          "data[ContactUs][email]": {
                                required: "Please enter your email.",
                                email: "Please enter valid email.",
                                },
           "data[ContactUs][message]": {required:"Please enter your query."}                               
        }
      });  
       
  });