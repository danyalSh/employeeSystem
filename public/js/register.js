function saveSpecialties() {  //step1
  var specialities = $('#tab1').find('input:checkbox:checked').map(function () {
    return $(this).val();
  }).get();
  if (specialities.length > 0) {
    $('#specialities').val(specialities);
  } else {
    $('#err').show();
    setTimeout(function () {
      $('#err').hide();
    }, 3000);
  }
}

function saveClasses() { //step2
  var classes = $('#tab2').find('input:checkbox:checked').map(function () {
    return $(this).val();
  }).get();
  if (classes.length > 0) {
    $('#classes').val(classes);
  } else {
    window.scrollTo(0, 0);
    $('#err').show();
    setTimeout(function () {
      $('#err').hide();
    }, 3000);
  }
}

function saveHomeTraining() { //step2
  var homeTrainingRadio = $("input:radio[name=homeTrainingRadio]:checked").val();
  $('#home_training').val(homeTrainingRadio);
}

function populateApiData(data) {
  name = data.name ? data.name : '';
  email = data.email ? data.email : '';
  city = data.city ? data.city : '';
  state = data.state ? data.state : '';
  country = data.country ? data.country : '';
  zip = data.zip ? data.zip : '';
  number = data.number ? data.number : '';
  gender = data.gender ? data.gender : '';

  if (name) {
    $('#name').val(name);
    $('#nameMain').hide();

    $('#password').val(name);
    $('#password_confirmation').val(name);
    $('#passwordMain').hide();
    $('#confirmPasswordMain').hide();
    $('#fbDiv').hide();
    $('#gDiv').hide();
    $('#or').hide();
  }
  if (email) {
    $('#email').val(email);
    $('#emailMain').hide();
  }
  if (city) {
    $('#city').val(city);
    $('#cityMain').hide();
  }
  if (state) {
    $('#state').val(state);
    $('#stateMain').hide();
  }
  if (country) {
    $('#country').val(country);
    $('#countryMain').hide();
  }
  if (zip) {
    $('#zip').val(zip);
    $('#zipMain').hide();
  }
  if (number) {
    $('#number').val(number);
    $('#numberMain').hide();
  }
  if (gender) {
    $('#gender').val(gender);
    $('#genderMain').hide();
  }
}
