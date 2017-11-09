  $(document).ready(function(){
      
        //method to check date validation  
//        $.validator.addMethod("dateDifference", function(value, element) {
//            var startDate = $('#GameStartTime').val().trim();
//            var endDate = $('#GameEndTime').val().trim(); 
//            
//            var startDateBase = Base64.encode($('#GameStartTime').val().trim());
//            var league_id = $('#GameLeagueId').val().trim();
//            
//            //var x = testdate(startDateBase,league_id);
//            if(startDate<endDate){
//            return true;
//            }
//        }, "Enddate can not be less then Startdate.");
/**************Check Start Date start****************/      
       $.validator.addMethod("dateStartCheck", function(value, element) {
            var startDate = $('#GameStartTime').val().trim();
            var stdate = $('#stdate').val().trim();
            var enddate = $('#enddate').val().trim();
            
            // working for form start date
            // form start date
            var arrStartDate = $.trim($('#GameStartTime').val()).split(" ");
            // form start date - date only
            var arrStDate = arrStartDate[0];
            var arrStDateNew = arrStDate.split("-");
            // form start date - time only
            var arrStTime = arrStartDate[1];
            var arrStTimeNew = arrStTime.split(":");
            // start date object
            var objStartDate = new Date();
            objStartDate.setFullYear(arrStDateNew[0]);
            objStartDate.setMonth(arrStDateNew[1] - 1);
            objStartDate.setDate(arrStDateNew[2]);
            objStartDate.setHours(arrStTimeNew[0]);
            objStartDate.setMinutes(arrStTimeNew[1]);
            objStartDate.setSeconds(arrStTimeNew[2]);
            
            // working for league start date
            // form start date
            var arrLgStartDate = $.trim($('#stdate').val()).split(" ");
            // form start date - date only
            var arrLgStDate = arrLgStartDate[0];
            var arrLgStDateNew = arrLgStDate.split("-");
            // form start date - time only
            var arrLgStTime = arrLgStartDate[1];
            var arrLgStTimeNew = arrLgStTime.split(":");
            // start date object
            var objLgStartDate = new Date();
            objLgStartDate.setFullYear(arrLgStDateNew[0]);
            objLgStartDate.setMonth(arrLgStDateNew[1] - 1);
            objLgStartDate.setDate(arrLgStDateNew[2]);
            objLgStartDate.setHours(arrLgStTimeNew[0]);
            objLgStartDate.setMinutes(arrLgStTimeNew[1]);
            objLgStartDate.setSeconds(arrLgStTimeNew[2]);
            
            // working for league end date
            // form end date
            var arrLgEndDate = $.trim($('#enddate').val()).split(" ");
            // form end date - date only
            var arrLgEnDate = arrLgEndDate[0];
            var arrLgEnDateNew = arrLgEnDate.split("-");
            // form end date - time only
            var arrLgEnTime = arrLgEndDate[1];
            var arrLgEnTimeNew = arrLgEnTime.split(":");
            // end date object
            var objLgEndDate = new Date();
            objLgEndDate.setFullYear(arrLgEnDateNew[0]);
            objLgEndDate.setMonth(arrLgEnDateNew[1] - 1);
            objLgEndDate.setDate(arrLgEnDateNew[2]);
            objLgEndDate.setHours(arrLgEnTimeNew[0]);
            objLgEndDate.setMinutes(arrLgEnTimeNew[1]);
            objLgEndDate.setSeconds(arrLgEnTimeNew[2]);
            
            var error = 0;
            
            if ((new Date(objStartDate)) < (new Date(objLgStartDate))){
                error++;
            }
            if ((new Date(objStartDate)) > (new Date(objLgEndDate))){
                error++;
            }
            
            if (error > 0) {
                return false;
            } else {
                return true;
            }
            
        }, "Date should be in between League Dates.");
        
/**************Check Start Date end****************/
/**************Check End Date start****************/
       $.validator.addMethod("dateEndCheck", function(value, element) {
            var startDate = $('#GameEndTime').val().trim(); //startDate is endDate Here
            var stdate = $('#stdate').val().trim();
            var enddate = $('#enddate').val().trim();
            var startOriginalDate = $('#GameStartTime').val().trim();
            
            // working for form start date
            // form start date
            var arrStartDate = $.trim($('#GameEndTime').val()).split(" ");
            // form start date - date only
            var arrStDate = arrStartDate[0];
            var arrStDateNew = arrStDate.split("-");
            // form start date - time only
            var arrStTime = arrStartDate[1];
            var arrStTimeNew = arrStTime.split(":");
            // start date object
            var objStartDate = new Date();
            objStartDate.setFullYear(arrStDateNew[0]);
            objStartDate.setMonth(arrStDateNew[1] - 1);
            objStartDate.setDate(arrStDateNew[2]);
            objStartDate.setHours(arrStTimeNew[0]);
            objStartDate.setMinutes(arrStTimeNew[1]);
            objStartDate.setSeconds(arrStTimeNew[2]);
            
            // working for league start date
            // form start date
            var arrLgStartDate = $.trim($('#stdate').val()).split(" ");
            // form start date - date only
            var arrLgStDate = arrLgStartDate[0];
            var arrLgStDateNew = arrLgStDate.split("-");
            // form start date - time only
            var arrLgStTime = arrLgStartDate[1];
            var arrLgStTimeNew = arrLgStTime.split(":");
            // start date object
            var objLgStartDate = new Date();
            objLgStartDate.setFullYear(arrLgStDateNew[0]);
            objLgStartDate.setMonth(arrLgStDateNew[1] - 1);
            objLgStartDate.setDate(arrLgStDateNew[2]);
            objLgStartDate.setHours(arrLgStTimeNew[0]);
            objLgStartDate.setMinutes(arrLgStTimeNew[1]);
            objLgStartDate.setSeconds(arrLgStTimeNew[2]);
            
            // working for league end date
            // form end date
            var arrLgEndDate = $.trim($('#enddate').val()).split(" ");
            // form end date - date only
            var arrLgEnDate = arrLgEndDate[0];
            var arrLgEnDateNew = arrLgEnDate.split("-");
            // form end date - time only
            var arrLgEnTime = arrLgEndDate[1];
            var arrLgEnTimeNew = arrLgEnTime.split(":");
            // end date object
            var objLgEndDate = new Date();
            objLgEndDate.setFullYear(arrLgEnDateNew[0]);
            objLgEndDate.setMonth(arrLgEnDateNew[1] - 1);
            objLgEndDate.setDate(arrLgEnDateNew[2]);
            objLgEndDate.setHours(arrLgEnTimeNew[0]);
            objLgEndDate.setMinutes(arrLgEnTimeNew[1]);
            objLgEndDate.setSeconds(arrLgEnTimeNew[2]);
            
            var error = 0;
            if(startOriginalDate>startDate){
                error++;
            }
            
            if ((new Date(objStartDate)) < (new Date(objLgStartDate))){
                error++;
            }
            if ((new Date(objStartDate)) > (new Date(objLgEndDate))){
                error++;
            }
            //console.log(error);return false;
            if (error > 0) {
                return false;
            } else {
                return true;
            }
            
        }, "Date should be in between League Dates.");

/**************Check End Date end****************/

       
//       $.validator.addMethod("dateEndCheck", function(value, element) {
//            var startDate = Base64.encode($('#GameStartTime').val().trim());
//            var endDate = Base64.encode($('#GameEndTime').val().trim());
//            var league_id = $('#GameLeagueId').val().trim(); 
//            var tmp = 'fail';
//            $.ajax({
//                    url:"/admin/games/checkdate",
//                    method:"POST",
//                    data:{startDate:startDate,endDate:endDate,league_id:league_id,check:"end"},
//                    success:function(result){
//                        console.log(result);
//                        if(result=='fail'){
//                            tmp = 'fail';
//                            
//                            //return false;
//                        }else{
//                            tmp ='success';
//                            //$("#GameEndTime-error").remove();
//                            //return true;
//                        }
//                    }
//                });
//                console.log(tmp);
//                if(tmp =='success'){
//                    $("#GameEndTime-error").remove();
//                    return true;
//                }
//            
//        }, "Date should be in range.");


/********************************/
      //Game  add & edit  for admin,league
       $("#GameAdminAddForm,#GameAdminEditForm,#GameLeagueAddForm,#GameLeagueEditForm,#GameSportsAddForm,#GameSportsEditForm").validate({
        rules: {
          "data[Game][sport_id]": "required",  
          "data[Game][tournament_id]": "required",
          "data[Game][league_id]": "required",
          "data[Game][start_time]": {required:true,dateStartCheck:true},
          "data[Game][end_time]": {required:true,dateEndCheck:true},
          "data[Game][first_team]": "required",
          "data[Game][second_team]": "required",
          "data[Game][teams_gameday]": "required",
          "data[Game][status]": "required"
          
        },
        messages: {
          "data[Game][sport_id]": "Please select sport.",    
          "data[Game][tournament_id]": "Please select tournament.",  
          "data[Game][league_id]": "Please select league.",
          "data[Game][start_time]": {required:"Please select game start time."},
          "data[Game][end_time]": {required:"Please select game end time."},
          "data[Game][first_team]": "Please select first team.",
          "data[Game][second_team]": "Please select second team.",
          "data[Game][teams_gameday]":{required: "Please select game day."},
          "data[Game][status]": "Please select status"
         
        }
      });
       
       
       
       //method to check date validation  
//        $.validator.addMethod("leagueDateDifference", function(value, element) {
//            var startDate = $('#LeagueStartDate').val().trim();
//            var endDate = $('#LeagueEndDate').val().trim(); 
//            if(startDate < endDate){
//            return true;
//            }
//        }, "Enddate can not be less then Startdate.");
        
        //leagues add & edit  for admin,sports   
       $("#LeagueAdminAddForm,#LeagueAdminEditForm,#LeagueSportsAddForm,#LeagueSportsEditForm").validate({
        rules: {
          "data[League][name]": "required",
          "data[League][sport_id]": "required",
          "data[League][tournament_id]": "required",
          "data[League][no_of_teams]": {required: true,min: 2},
          "data[League][start_time]": {required:true,dateStartCheck:true},
          "data[League][end_time]": {required:true,dateEndCheck:true},
          "data[League][status]": "required"
          
        },
        messages: {
          "data[League][name]": "Please enter league name.",
          "data[League][sport_id]": "Please select sport.",
          "data[League][tournament_id]": "Please select tournament.",
          "data[League][no_of_teams]": {required: "Please enter number of team.",
                                        min: "Minimum 2 team required for leage."},
          "data[League][start_time]": {required:"Please select game start time."},
          "data[League][end_time]": {required:"Please select game end time."},
          "data[League][status]": "Please select status."
         
        }
      });
    
    //Tournament add & edit for admin, sports
       $("#TournamentAdminAddForm,#LeagueAdminEditForm,#TournamentSportsAddForm,#TournamentSportsEditForm,#TournamentLeagueAddForm,#TournamentLeagueEditForm").validate({
        rules: {
          "data[Tournament][name]": "required",
          "data[Tournament][sport_id]": "required",
          "data[Tournament][file_id]": "required",
          "data[Tournament][description]": "required",
          "data[Tournament][status]": "required"
        },
        messages: {
          "data[Tournament][name]": "Please enter tournament name.",
          "data[Tournament][sport_id]": "Please select sport.",
          "data[Tournament][file_id]": "Please upload file.",
          "data[Tournament][description]": "Please enter tournament description.",
          "data[Tournament][status]": "Please select status."
         
        }
      });
       
       
    //User add & edit  for admin,sports,league,team
       $("#UserAdminAddForm,#UserSportsAddForm,#UserSportsEditForm,#UserLeagueAddForm,#UserLeagueEditForm,#UserTeamAddForm,#UserTeamEditForm").validate({
        rules: {
          "data[User][name]": "required",
          "data[User][email]": {
                                required: true,
                                email: true,
                                remote: {
                                url: "/Users/checkEmailExist/"+$('#UserEmail').val(),
                                type: "post"
                            }
                                },
          "data[User][role_id]": "required",
          "data[User][locale_id]": "required",
          "data[User][password]": {required:true,
                                    minlength:6},
          "data[User][confirm_password]": {
                                required: true,
                                equalTo: "#UserPassword"
                                },                                    
                                    
          "data[User][gender]": "required",
          "data[User][status]": "required"
        },
        messages: {
          "data[User][name]": "Please enter user name.",
          "data[User][email]": {
                                required: "Please enter email.",
                                email: "Please enter valid email.",
                                },
          "data[User][role_id]": "Please select user role.",
          "data[User][locale_id]": "Please select user language.",
          "data[User][password]": {required:"Please enter password.",
                                    minlength:"Minimum 6 characters required"},
          "data[User][confirm_password]": {required:"Please enter password again.",
                                    equalTo:"Password do not match"},                                    
          "data[User][gender]": "Please select user gender.",
          "data[User][status]": "Please select user status."
         
        }
      });

       $("#UserAdminEditForm").validate({
   rules: {
          "data[User][name]": "required",
          
          "data[User][role_id]": "required",
          "data[User][locale_id]": "required",
          "data[User][password]": {required:true,
                                    minlength:6},
          "data[User][confirm_password]": {
                                required: true,
                                equalTo: "#UserPassword"
                                },                                    
                                    
          "data[User][gender]": "required",
          "data[User][status]": "required"
        },
        messages: {
          "data[User][name]": "Please enter user name.",
          "data[User][email]": {
                                required: "Please enter email.",
                                email: "Please enter valid email.",
                                },
          "data[User][role_id]": "Please select user role.",
          "data[User][locale_id]": "Please select user language.",
          "data[User][password]": {required:"Please enter password.",
                                    minlength:"Minimum 6 characters required"},
          "data[User][confirm_password]": {required:"Please enter password again.",
                                    equalTo:"Password do not match"},                                    
          "data[User][gender]": "Please select user gender.",
          "data[User][status]": "Please select user status."
         
        }
      });
       
       //Profile add, edit for admin,league,sport,team
       $("#UserLeagueMyProfileForm,#UserAdminMyProfileForm,#UserSportsMyProfileForm,#UserTeamMyProfileForm").validate({
        rules: {
          "data[User][name]": "required",
          "data[User][gender]": "required",
          "data[User][locale_id]": "required"
        },
        messages: {
          "data[User][name]": "Please enter user name.",
          "data[User][status]": "Please select user status.",
          "data[User][locale_id]": "Please select user language."
          
        }
      });
       
       //Change Password
       $("#DashboardLeagueMyProfileForm,#DashboardAdminMyProfileForm,#DashboardSportsMyProfileForm,#DashboardTeamMyProfileForm").validate({
        rules: {
          "data[User][current_password]": "required",
          "data[User][new_password]": "required",
          "data[User][re_enter_password]": {
                                required: true,
                                equalTo: "#UserNewPassword"
                                },
        },
        messages: {
          "data[User][current_password]": "Please enter current password.",
          "data[User][new_password]": "Please enter new password.",
          "data[User][re_enter_password]": {
                                required: "Please re-enter new password.",
                                equalTo: "Password do not match.",
                                }
        }
      });


      //Team add & edit  for admin
       $("#TeamAdminAddForm,#TeamAdminEditForm,#TeamSportsAddForm,#TeamSportsEditForm").validate({
        rules: {
          "data[Team][name]": "required",
          "data[Team][sport_id]": "required",              
          "data[Team][tournament_id]": "required",
          "data[Team][league_id]": "required",
          "data[Team][user_id]": "required",
          "data[Team][status]": "required",
          "data[Team][optionid]":"required",
        },
        messages: {
          "data[Team][name]": "Please enter team name.",
          "data[Team][sport_id]": "Please select sport.",               
          "data[Team][tournament_id]": "Please select tournament.",
          "data[Team][league_id]": "Please select League.",
          "data[Team][user_id]": "Please select team admin.",
          "data[Team][status]": "Please select status.",
          "data[Team][optionid]":"Please select team option.",
        }
      });
      
      //News add & edit  for admin
       $("#NewsAdminAddForm,#NewsAdminEditForm,#NewsSportsAddForm,#NewsSportsEditForm").validate({
        rules: {
          "data[News][name]": "required",
          "data[News][description]": "required",              
          "data[News][file_id]": "required",
          "data[News][news_type]": "required",
          "data[News][foreign_key]": "required",
          "data[News][status]": "required"
     
        },
        messages: {
          "data[News][name]": "Please enter news name.",
          "data[News][description]": "Please enter news description.",               
          "data[News][file_id]": "Please select news image.",
          "data[News][news_type]": "Please enter news type.",
          "data[User][password]": "Please enter password.",
          "data[News][foreign_key]": "Please select sport releted to news.",
          "data[News][status]": "Please select news status."
         
        }
      });
      
 
      //StaticPage add & edit  for admin
      $("#StaticPageAdminAddForm,#StaticPageAdminEditForm").validate({
        rules: {
          "data[StaticPage][name]": "required",
          "data[StaticPage][description]": "required"
        },
        messages: {
          "data[StaticPage][name]": "Please enter page name.",
          "data[StaticPage][description]": "Please enter page content."
          
        }
      });
      
      //StaticPage add & edit  for admin
      $("#SliderAdminAddsliderForm,#SliderAdminEditsliderForm").validate({
        rules: {
          "data[Slider][title]": "required",
          "data[Slider][content]": "required",
          "data[Slider][file_id]": "required",              
          "data[Slider][status]": "required",
        },
        messages: {
          "data[Slider][title]": "Please enter title.",
          "data[Slider][content]": "Please enter content for slider.",
          "data[Slider][file_id]": "Please select image.",               
          "data[Slider][status]": "Please enter status.",
         
        }
      });
      
      //StaticPage add & edit  for admin
      $("#SliderAdminAddSportSliderForm,#SliderAdminEditSportSliderForm").validate({
        rules: {
          "data[Slider][title]": "required",
          "data[Slider][content]": "required",
          "data[Slider][file_id]": "required",   
          "data[Slider][foreign_key]": "required",  
          "data[Slider][status]": "required",
        },
        messages: {
          "data[Slider][title]": "Please enter title.",
          "data[Slider][content]": "Please enter content for slider.",
          "data[Slider][file_id]": "Please select image.",       
          "data[Slider][foreign_key]": "Please select sport.",     
          "data[Slider][status]": "Please enter status.",
         
        }
      });
      
      //Sports add & edit  for admin
      $("#SportAdminAddForm").validate({
        rules: {
          "data[Sport][name]": "required",
          "data[Sport][banner_image]": "required",              
          "data[Sport][user_id]": "required",
          "data[Sport][status]": "required",
        },
        messages: {
          "data[Sport][name]": "Please insert sport name.",
          "data[Sport][banner_image]": "Please add bammer image. ",              
          "data[Sport][user_id]": "Please select sport admin.",
          "data[Sport][status]": "Please select status.",
        }
      });
      
       
      //StaticPage add & edit  for admin
      $("#WallContentTeamAddForm,#WallContentTeamEditForm").validate({
        rules: {
          "data[WallContent][status]": "required"
        },
        messages: {
          "data[WallContent][status]": "Please select post status."
        }
      });
      
      //message reply  for admin
      $("#ContactUsAdminReplyMessageForm").validate({
        rules: {
          "data[ContactUs][email]": "required",
          "data[ContactUs][message]": "required"
        },
        messages: {
          "data[ContactUs][email]": "Please enter sender email.",
          "data[ContactUs][message]": "Please enter reply message."
          
        }
      });

      //Gifts Add  for admin
      $("#GiftAdminAddForm").validate({
        rules: {
          "data[Gift][sport_id]": "required",
          "data[Gift][tournament_id]": "required",
          "data[Gift][league_id]": "required",
          "data[Gift][game_day]": "required",
          "data[Gift][name]": "required",
          "data[Gift][location_id]": "required",
          "data[Gift][type]": "required",
          "data[Gift][amount]": "required",
          "data[Gift][product_link]": "required",
          "data[Gift][gift_category_id]": "required",
          "data[Gift][winning_no_game]": "required",
          "data[Gift][file_id]": "required",
          "data[Gift][status]": "required"
        },
        messages: {
          "data[Gift][sport_id]": "Please select sport.",
          "data[Gift][tournament_id]": "Please select tournament.",
          "data[Gift][league_id]":"Please select league.",
          "data[Gift][game_day]": "Please select game day.",
          "data[Gift][name]": "Please enter name.",
          "data[Gift][location_id]": "Please select location.",
          "data[Gift][type]": "Please select type.",
          "data[Gift][amount]": "Please enter amount.",
          "data[Gift][product_link]": "Please enter product link.",
          "data[Gift][gift_category_id]": "Please select gift category.",
          "data[Gift][winning_no_game]": "Please enter number.",
          "data[Gift][file_id]": "Please select file.",
          "data[Gift][status]": "Please select status."
          
        }
      });
      //Gifts edit  for admin
      $("#GiftAdminEditForm").validate({
        rules: {
         "data[Gift][game_day]": "required",
          "data[Gift][name]": "required",
          "data[Gift][location_id]": "required",
          "data[Gift][type]": "required",
          "data[Gift][amount]": "required",
          "data[Gift][product_link]": "required",
          "data[Gift][gift_category_id]": "required",
          "data[Gift][winning_no_game]": "required",
          "data[Gift][status]": "required"
        },
        messages: {
          "data[Gift][game_day]": "Please select game day.",
          "data[Gift][name]": "Please enter name.",
          "data[Gift][location_id]": "Please select location.",
          "data[Gift][type]": "Please select type.",
          "data[Gift][amount]": "Please enter amount.",
          "data[Gift][product_link]": "Please enter product link.",
          "data[Gift][gift_category_id]": "Please select gift category.",
          "data[Gift][winning_no_game]": "Please enter number.",
          "data[Gift][status]": "Please select status."
          
        }
      });
      
      
  });
    
  
