<script>
    window.fbAsyncInit = function() {
        FB.init({   
            appId: '883677821789067', // App ID'<?php // echo trim(FB_APP_ID); ?>'
            //channelUrl : '//WWW.YOUR_DOMAIN.COM/channel.html', // Channel File
            status: true,  // check login status
            cookie: true, // enable cookies to allow the server to access the session
            xfbml: true  // parse XFBML
        });

        // Here we subscribe to the auth.authResponseChange JavaScript event. This event is fired
        // for any auth related change, such as login, logout or session refresh. This means that
        // whenever someone who was previously logged out tries to log in again, the correct case below
        // will be handled.

        FB.Event.subscribe('auth.authResponseChange', function(response) {
            // Here we specify what we do with the response anytime this event occurs.

            /* if (response.status === 'connected') {
             // The response object is returned with a status field that lets the app know the current
             // login status of the person. In this case, we're handling the situation where they
             // have logged in to the app.
             testAPI();
             } else if (response.status === 'not_authorized') {
             // In this case, the person is logged into Facebook, but not into the app, so we call
             // FB.login() to prompt them to do so.
             // In real-life usage, you wouldn't want to immediately prompt someone to login
             // like this, for two reasons:
             // (1) JavaScript created popup windows are blocked by most browsers unless they
             // result from direct user interaction (such as a mouse click)
             // (2) it is a bad experience to be continually prompted to login upon page load.
             FB.login();
             } else {
             // In this case, the person is not logged into Facebook, so we call the login()
             // function to prompt them to do so. Note that at this stage there is no indication
             // of whether they are logged into the app. If they aren't then they'll see the Login
             // dialog right after they log in to Facebook.
             // The same caveats as above apply to the FB.login() call here.
             FB.login();
             }*/
        });
    };


    // Load the SDK asynchronously
    (function(d) {
        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement('script');
        js.id = id;
        js.async = true;
        js.src = "//connect.facebook.net/en_US/all.js";
        ref.parentNode.insertBefore(js, ref);
    }(document));

    // Here we run a very simple test of the Graph API after login is successful.
    // This testAPI() function is only called in those cases.
    function fbAPI() {
        FB.api('/me', function(response) {
            $.post("<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'fb_connect')); ?>", {"data[User]": response}, function(data) {
                //to do
                if (data=='Success') {
                    window.location.href='/users/profile';
                }
            });
        });
    }
    //Facebook API CAll when login error
    function fb_login() { 
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                // the user is logged in and has authenticated your
                // app, and response.authResponse supplies
                // the user's ID, a valid access token, a signed
                // request, and the time the access token
                // and signed request each expire
                var uid = response.authResponse.userID;
                var accessToken = response.authResponse.accessToken;
                fbAPI();
            } else if (response.status === 'not_authorized') {
                // the user is logged in to Facebook,
                // but has not authenticated your app
                FB.login(function(response) {
                    // handle the response
                    fbAPI();
                }, {scope: 'email,user_likes'});
            } else {
                // the user isn't logged in to Facebook.
                FB.login(function(response) {
                    fbAPI();
                    // handle the response
                }, {scope: 'email,user_likes'});
            }
        });
    }
    
    //Facebook logout
    $(document).ready(function(){
        jQuery(document).on('click','.fb_logout',function(){
            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    FB.logout(logout);
                }else{
                    logout();
                }
            });
        });
    });
    
    function logout() {
        jQuery.ajax({
                      type: "POST",
                      url: "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'fb_logout')); ?>",
                      success: function(response){
                          window.location.href = '/users/login';
                      }
        });
      }
</script>
<div id="fb-root"></div>