$(document).ready(function() {
  var ar = window.ar;
  var myData = {};
  $.each(ar, function( key, value ) {
    console.log(value);
    var name = value.name;
    var email = value.email;
    var valueToShow = '';
    if (email && email != '') {
      valueToShow = name + ' (' + email + ')';
    } else {
      valueToShow = name;
    }
    myData[value.catsone_candidate_id] = valueToShow;
  });
  console.log(myData);
  var myDataArray = $.map(myData, function(value, key) {

    return {
      value: value ,
      data: key
    };
  });

  // initialize autocomplete with custom appendTo
  $('#autocomplete-custom-append').autocomplete({
    lookup: myDataArray,
    onSelect: function (val) {
      $('.loaderMain').show();
      $('#userInfo').hide();
      $('.err').hide();
      console.log(val.data);
      $('#userId').val(val.data)
      var settings = {
        "url": "/getUserData",
        "method": "GET",
        "data": {
          'id': val.data
        },
        "headers": {
          "cache-control": "no-cache",
        }
      }

      $.ajax(settings).done(function (response) {
        try {
          if (response.data.code == 404) {
            $('#userInfo').hide();
            $('.err').show();
            $('.loaderMain').hide();
            setTimeout(function () {
              $('.err').hide();
            }, 7000);
          } else {
            var data = response.data.data;
            var fName = data.first_name ? data.first_name : '--';
            var lName= data.last_name ? data.last_name : '--';
            var email = data.emails.primary ? data.emails.primary : '--';
            var city = data.address.city ? data.address.city : '';
            var state = data.address.state ? ',' + data.address.state: '';
            var zip = data.address.postalcode ? ',' +  data.address.postalcode + ',': '';
            var phone = data.phones.cell ? data.phones.cell : '--';

            if (!city && !state && !zip) {
              zip = '--';
            }
            $('#f_name').html(fName);
            $('#l_name').html(lName);
            $('#email').html(email);
            $('#address').html("<div>"+city + ' ' + state + ' ' +  ' '+  zip+  "</div>");
            $('#state').html(state);
            $('#zip').html(zip);
            $('#phone').html(phone);

            $('.err').hide();
            $('#userInfo').show();
            $('.loaderMain').hide();

          }
        } catch(e) {
          console.log(e);
          $('.err').show();
          $('.err').show();
          $('.loaderMain').hide();
        }
      });
    }
  });

});