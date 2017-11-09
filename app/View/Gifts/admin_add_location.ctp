<section class="content-header">
    <h1><?php echo __dbt('Add Location'); ?>
        <small><?php echo __dbt('Admin Add Location'); ?></small>
    </h1>
    <?php echo $this->element($elementFolder . '/breadcrumb'); ?>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                </div>
                <div class="box-body">
                    <?php
                    echo $this->Form->create('Location', array('class' => 'form-horizontal', 'autocomplete' => "off", "enctype" => "multipart/form-data"));
                    $this->Form->inputDefaults(array('required' => false));
                    ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label amt" for="inputEmail3"><?php echo __dbt('Location'); ?></label>
                        <div class="col-sm-4"  id="locationField">
                        <?php echo $this->Form->input('address', array('class' => 'form-control', 'id'=>"autocomplete", 'label' => false,'type'=>'text')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label amt" for="inputEmail3"></label>
                        <div class="col-sm-4"  id="address">
                        <?php echo $this->Form->input('name', array('class' => 'form-control', 'id'=>"locality", 'label' => false,'type'=>'text','disabled'=>"true")); ?>
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="col-sm-4 control-label">
                            <?php echo $this->Form->submit('Submit', array('type' => 'submit', 'class' => 'btn btn-primary', 'div' => false, 'id' => 'submitPoll')); ?>
                            <a class="btn btn-warning margin" href="/admin/gifts"><?php echo __dbt('Cancel'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="dtBox1"></div><!-- this div used for date picker  -->












    <script>

    $("#LocationAdminAddLocationForm").validate({
     rules: {
       "data[Location][address]": {
                             required: true
                             },
       "data[Location][name]": {
                             required: true
                             },

     },
     messages: {
       "data[Location][address]": {required: "Please enter gift location."
     },
    "data[Location][name]": {required: "Please enter location."
                                                   }


     }
   });
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete;
      var componentForm = {
        //street_number: 'short_name',
        //route: 'long_name',
        locality: 'long_name',
        //administrative_area_level_1: 'short_name',
      //  country: 'long_name',
      //  postal_code: 'short_name'
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADhE6Dd6GpXAYqJT5G3fhGth-RnVg8tWg&libraries=places&callback=initAutocomplete"
        async defer></script>
