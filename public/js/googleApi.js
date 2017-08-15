/**
 * Handler for the signin callback triggered after the user selects an account.
 */
function onSignInCallback(resp) {
  gapi.client.load('plus', 'v1', apiClientLoaded);
}

/**
 * Sets up an API call after the Google API client loads.
 */
function apiClientLoaded() {
  gapi.client.plus.people.get({userId: 'me'}).execute(handleEmailResponse);
}

/**
 * Response callback for when the API client receives a response.
 *
 * @param resp The API response object with the user email and profile information.
 */
function handleEmailResponse(resp) {
  var primaryEmail;
  for (var i = 0; i < resp.emails.length; i++) {
    if (resp.emails[i].type === 'account') primaryEmail = resp.emails[i].value;
  }
  
  // console.log(primaryEmail);
  // console.log(JSON.stringify(resp));
  // document.getElementById('responseContainer').value = 'Primary email: ' +
  //   primaryEmail + '\n\nFull Response:\n' + JSON.stringify(resp);

  if (route == 'login') {
    loginWithAPI({
      name: resp.displayName,
      email: primaryEmail,
      gender: resp.gender
    });
  } else {
    populateApiData({
      name: resp.displayName,
      email: primaryEmail,
      gender: resp.gender
    });
  }
}

$( document ).ready(function() {
  window.onbeforeunload = function(e){
    gapi.auth2.getAuthInstance().signOut();
  };

  if (navigator.geolocation) {
    console.log('Geolocation is supported!');
  }
  else {
    console.log('Geolocation is not supported for this Browser/OS version yet.');
  }
});